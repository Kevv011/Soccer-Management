<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reports\FederationReportRequest;
use App\Http\Requests\Reports\TeamReportRequest;
use App\Models\Federation;
use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * Build and render the federation report.
     */
    public function index(FederationReportRequest $request): Response
    {
        $validated = $request->validated();

        $federations = Federation::query()
            ->with([
                'subdivision.country',
                'teams.players',
                'teams.media',
                'media',
            ])
            ->when(
                ! ($validated['all_federations'] ?? false),
                fn ($query) => $query->whereIn('id', $validated['federation_ids'] ?? []),
            )
            ->orderBy('name')
            ->get();

        $reportData = [
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
                    'teams' => $federation->teams->map(function ($team): array {
                        return [
                            'name' => $team->name,
                            'crest_path' => $team->getFirstMediaPath('crest', 'thumb') ?: $team->getFirstMediaPath('crest'),
                            'players_count' => $team->players->count(),
                        ];
                    })->values()->all(),
                ];
            })->values()->all(),
        ];

        return Pdf::loadView('reports.federation-report', $reportData)
            ->setPaper('a4', 'portrait')
            ->stream('federation-report.pdf');
    }

    /**
     * Build and render the team report.
     */
    public function teams(TeamReportRequest $request): Response
    {
        $validated = $request->validated();

        $teams = Team::query()
            ->with([
                'federation.subdivision.country',
                'federation.media',
                'players',
                'media',
            ])
            ->when(
                ! ($validated['all_teams'] ?? false),
                fn ($query) => $query->whereIn('id', $validated['team_ids'] ?? []),
            )
            ->orderBy('name')
            ->get();

        $reportData = [
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

        return Pdf::loadView('reports.team-report', $reportData)
            ->setPaper('a4', 'portrait')
            ->stream('team-report.pdf');
    }
}
