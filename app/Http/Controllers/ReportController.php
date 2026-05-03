<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reports\FederationReportRequest;
use App\Models\Federation;
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
}
