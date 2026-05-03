<?php

namespace App\Http\Controllers;

use App\Actions\Reports\BuildFederationReportData;
use App\Actions\Reports\BuildTeamReportData;
use App\Http\Requests\Reports\FederationReportRequest;
use App\Http\Requests\Reports\TeamReportRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * Build and render the federation report.
     */
    public function index(FederationReportRequest $request, BuildFederationReportData $buildFederationReportData): Response
    {
        $reportData = $buildFederationReportData->handle($request->validated());

        return Pdf::loadView('reports.federation-report', $reportData)
            ->setPaper('a4', 'portrait')
            ->stream('federation-report.pdf');
    }

    /**
     * Build and render the team report.
     */
    public function teams(TeamReportRequest $request, BuildTeamReportData $buildTeamReportData): Response
    {
        $reportData = $buildTeamReportData->handle($request->validated());

        return Pdf::loadView('reports.team-report', $reportData)
            ->setPaper('a4', 'portrait')
            ->stream('team-report.pdf');
    }
}
