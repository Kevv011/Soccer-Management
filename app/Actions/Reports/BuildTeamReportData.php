<?php

namespace App\Actions\Reports;

use App\Models\Team;

class BuildTeamReportData
{
    /**
     * @param  array{all_teams?: bool, team_ids?: array<int, int|string>}  $filters
     * @return array{
     *     report: string,
     *     generated_at: \Illuminate\Support\Carbon,
     *     summary: array{teams_count: int, federations_count: int, players_count: int},
     *     data: array<int, array{
     *         name: string,
     *         crest_path: string,
     *         players_count: int,
     *         federation: array{
     *             name: ?string,
     *             logo_path: ?string,
     *             foundation_date: ?string,
     *             country: ?string,
     *             subdivision: ?string,
     *             municipality: ?string,
     *             address_line: ?string
     *         },
     *         players: array<int, array{name: string, birth_date: ?string, gender: ?string}>
     *     }>
     * }
     */
    public function handle(array $filters = []): array
    {
        $teams = Team::query()
            ->with([
                'federation.subdivision.country',
                'federation.media',
                'players',
                'media',
            ])
            ->when(
                ! ($filters['all_teams'] ?? false),
                fn ($query) => $query->whereIn('id', $filters['team_ids'] ?? []),
            )
            ->orderBy('name')
            ->get();

        return [
            'report' => 'team',
            'generated_at' => now(),
            'summary' => [
                'teams_count' => $teams->count(),
                'federations_count' => $teams->pluck('federation_id')->filter()->unique()->count(),
                'players_count' => $teams->sum(fn (Team $team): int => $team->players->count()),
            ],
            'data' => $teams->map(function (Team $team): array {
                return [
                    'name' => $team->name,
                    'crest_path' => $team->getFirstMediaPath('crest', 'thumb') ?: $team->getFirstMediaPath('crest'),
                    'players_count' => $team->players->count(),
                    'federation' => [
                        'name' => $team->federation?->name,
                        'logo_path' => $team->federation?->getFirstMediaPath('logo', 'thumb')
                            ?: $team->federation?->getFirstMediaPath('logo'),
                        'foundation_date' => $team->federation?->foundation_date?->toDateString(),
                        'country' => $team->federation?->subdivision?->country?->name,
                        'subdivision' => $team->federation?->subdivision?->name,
                        'municipality' => $team->federation?->municipality,
                        'address_line' => $team->federation?->address_line,
                    ],
                    'players' => $team->players
                        ->sortBy('name')
                        ->values()
                        ->map(fn ($player): array => [
                            'name' => $player->name,
                            'birth_date' => $player->birth_date?->toDateString(),
                            'gender' => $player->gender?->value,
                        ])
                        ->all(),
                ];
            })->values()->all(),
        ];
    }
}
