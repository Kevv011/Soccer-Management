<?php

namespace App\Actions\Reports;

use App\Models\Federation;
use Illuminate\Support\Collection;

class BuildFederationReportData
{
    /**
     * @param  array{all_federations?: bool, federation_ids?: array<int, int|string>}  $filters
     * @return array{
     *     report: string,
     *     generated_at: \Illuminate\Support\Carbon,
     *     summary: array{federations_count: int, teams_count: int, players_count: int},
     *     data: array<int, array{
     *         name: string,
     *         foundation_date: ?string,
     *         country: ?string,
     *         subdivision: ?string,
     *         municipality: string,
     *         address_line: string,
     *         logo_path: string,
     *         teams_count: int,
     *         players_count: int,
     *         teams: array<int, array{name: string, crest_path: string, players_count: int}>
     *     }>
     * }
     */
    public function handle(array $filters = []): array
    {
        $federations = Federation::query()
            ->with([
                'subdivision.country',
                'teams.players',
                'teams.media',
                'media',
            ])
            ->when(
                ! ($filters['all_federations'] ?? false),
                fn ($query) => $query->whereIn('id', $filters['federation_ids'] ?? []),
            )
            ->orderBy('name')
            ->get();

        return [
            'report' => 'federation',
            'generated_at' => now(),
            'summary' => [
                'federations_count' => $federations->count(),
                'teams_count' => $federations->sum(fn (Federation $federation): int => $federation->teams->count()),
                'players_count' => $federations->sum(
                    fn (Federation $federation): int => $federation->teams->sum(fn ($team): int => $team->players->count())
                ),
            ],
            'data' => $federations->map(function (Federation $federation): array {
                return [
                    'name' => $federation->name,
                    'foundation_date' => $federation->foundation_date?->toDateString(),
                    'country' => $federation->subdivision?->country?->name,
                    'subdivision' => $federation->subdivision?->name,
                    'municipality' => $federation->municipality,
                    'address_line' => $federation->address_line,
                    'logo_path' => $federation->getFirstMediaPath('logo', 'thumb') ?: $federation->getFirstMediaPath('logo'),
                    'teams_count' => $federation->teams->count(),
                    'players_count' => $federation->teams->sum(fn ($team): int => $team->players->count()),
                    'teams' => $federation->teams
                        ->map(function ($team): array {
                            return [
                                'name' => $team->name,
                                'crest_path' => $team->getFirstMediaPath('crest', 'thumb') ?: $team->getFirstMediaPath('crest'),
                                'players_count' => $team->players->count(),
                            ];
                        })
                        ->values()
                        ->all(),
                ];
            })->values()->all(),
        ];
    }
}
