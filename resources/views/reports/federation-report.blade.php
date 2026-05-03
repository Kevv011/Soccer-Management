<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Federation Report</title>
    <style>
        @page {
            margin: 24px 26px 28px;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.45;
            color: #16263d;
            background: #f3f6fb;
        }

        .page-shell {
            background: #f3f6fb;
        }

        .topbar {
            width: 100%;
            border-bottom: 1px solid #d6deea;
            padding: 0 0 14px;
            margin-bottom: 22px;
        }

        .topbar-table {
            width: 100%;
            border-collapse: collapse;
        }

        .topbar-table td {
            vertical-align: middle;
        }

        .brand-logo {
            width: 210px;
        }

        .topbar-title {
            text-align: right;
        }

        .topbar-title h1 {
            margin: 0;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #17365f;
        }

        .topbar-title p {
            margin: 6px 0 0;
            font-size: 10px;
            color: #66768d;
        }

        .intro {
            margin-bottom: 14px;
        }

        .eyebrow {
            margin: 0 0 6px;
            font-size: 10px;
            font-weight: 700;
            color: #5f6f83;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .intro h2 {
            margin: 0 0 4px;
            font-size: 18px;
            color: #16263d;
        }

        .intro p {
            margin: 0;
            color: #6b7a90;
        }

        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 -10px 16px;
        }

        .summary-grid td {
            width: 33.33%;
            vertical-align: top;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #e1e8f1;
            border-top: 3px solid #d0a24c;
            border-radius: 10px;
            padding: 12px 14px;
            box-shadow: 0 6px 18px rgba(20, 35, 61, 0.08);
        }

        .summary-card-label {
            margin: 0 0 8px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9b7a35;
        }

        .summary-card-value {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #17365f;
        }

        .summary-card-title {
            margin: 3px 0 0;
            font-size: 12px;
            font-weight: 700;
            color: #16263d;
        }

        .summary-card-caption {
            margin: 3px 0 0;
            font-size: 10px;
            color: #6d7d93;
        }

        .federation-card {
            margin-bottom: 18px;
            background: #ffffff;
            border: 1px solid #dce4ef;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(20, 35, 61, 0.08);
            page-break-inside: auto;
        }

        .federation-hero {
            background: #0f3768;
            color: #ffffff;
            padding: 16px 20px;
            page-break-after: avoid;
        }

        .federation-hero-table {
            width: 100%;
            border-collapse: collapse;
        }

        .federation-hero-table td {
            vertical-align: middle;
        }

        .federation-logo-cell {
            width: 86px;
        }

        .federation-logo-box {
            width: 68px;
            height: 68px;
            background: #ffffff;
            border-radius: 10px;
            text-align: center;
            vertical-align: middle;
        }

        .federation-logo {
            max-width: 54px;
            max-height: 54px;
            margin-top: 7px;
        }

        .federation-hero h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        .federation-hero p {
            margin: 6px 0 0;
            font-size: 11px;
            color: #c4d3ea;
        }

        .federation-body {
            padding: 18px;
        }

        .section-heading {
            margin: 0 0 14px;
            font-size: 13px;
            font-weight: 700;
            color: #17365f;
        }

        .content-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            page-break-inside: auto;
        }

        .content-grid td {
            vertical-align: top;
        }

        .details-column {
            width: 70%;
            padding-right: 18px;
        }

        .summary-column {
            width: 30%;
        }

        .detail-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-grid td {
            width: 50%;
            padding: 0 12px 14px 0;
            vertical-align: top;
        }

        .detail-label {
            margin: 0 0 4px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            color: #7a889b;
        }

        .detail-value {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            color: #1b2c45;
        }

        .address-block td {
            width: 100%;
            padding-right: 0;
        }

        .operational-panel {
            background: #f3f6fb;
            border: 1px solid #d8e1ee;
            border-radius: 10px;
            padding: 12px;
        }

        .operational-panel h4 {
            margin: 0 0 12px;
            font-size: 12px;
            text-align: center;
            color: #17365f;
        }

        .metric-box {
            background: #ffffff;
            border-left: 3px solid #17365f;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 8px;
        }

        .metric-box.gold {
            border-left-color: #d0a24c;
        }

        .metric-table {
            width: 100%;
            border-collapse: collapse;
        }

        .metric-table td {
            vertical-align: middle;
        }

        .metric-label {
            font-size: 10px;
            font-weight: 700;
            color: #5d6d84;
        }

        .metric-value {
            text-align: right;
            font-size: 18px;
            font-weight: 800;
            color: #17365f;
        }

        .status-box {
            margin-top: 12px;
            background: #0d2748;
            border-radius: 8px;
            padding: 10px 12px;
            color: #ffffff;
        }

        .status-label {
            margin: 0 0 5px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #9cb7d6;
        }

        .status-value {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
        }

        .teams-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            page-break-after: avoid;
        }

        .teams-header td {
            vertical-align: middle;
        }

        .teams-count {
            text-align: right;
        }

        .teams-badge {
            display: inline-block;
            background: #f2c76f;
            color: #7f5b13;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            padding: 4px 8px;
            border-radius: 999px;
        }

        .teams-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #dce4ef;
            border-radius: 10px;
            overflow: hidden;
            page-break-inside: auto;
        }

        .teams-table thead th {
            background: #0f2748;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            text-align: left;
            padding: 11px 12px;
        }

        .teams-table tbody td {
            padding: 11px 12px;
            border-top: 1px solid #e5ecf4;
            color: #21324b;
            vertical-align: middle;
        }

        .teams-table tbody tr:nth-child(even) {
            background: #fafcff;
        }

        .teams-table tr {
            page-break-inside: avoid;
        }

        .crest-pill {
            width: 36px;
            height: 36px;
            background: #eef3fb;
            border: 1px solid #d9e3f2;
            border-radius: 999px;
            text-align: center;
            vertical-align: middle;
        }

        .crest-image {
            max-width: 24px;
            max-height: 24px;
            margin-top: 5px;
        }

        .empty-state {
            margin: 0;
            padding: 12px 14px;
            border: 1px dashed #ccd8e8;
            border-radius: 10px;
            color: #71819a;
            background: #fafcff;
        }

        .report-footer {
            margin-top: 28px;
            padding-top: 16px;
            border-top: 1px solid #d6deea;
            color: #73839a;
            font-size: 9px;
        }

        .report-footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-footer-table td:last-child {
            text-align: right;
        }

    </style>
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <table class="topbar-table">
                <tr>
                    <td>
                        <img
                            class="brand-logo"
                            src="{{ public_path('images/soccer-management-long-logo.png') }}"
                            alt="Soccer Management"
                        >
                    </td>
                    <td class="topbar-title">
                        <h1>Football Federation Report</h1>
                        <p>Generated at {{ $generated_at->format('Y-m-d H:i:s') }}</p>
                    </td>
                </tr>
            </table>
        </header>

        <section class="intro">
            <p class="eyebrow">Federation Report</p>
            <h2>Institutional Governance and Operational Performance Summary</h2>
            <p>Structured overview of federations, affiliated teams, and active player registrations.</p>
        </section>

        <table class="summary-grid">
            <tr>
                <td>
                    <div class="summary-card">
                        <p class="summary-card-label">Active</p>
                        <p class="summary-card-value">{{ $summary['federations_count'] }}</p>
                        <p class="summary-card-title">Federations</p>
                        <p class="summary-card-caption">Institutional entities</p>
                    </div>
                </td>
                <td>
                    <div class="summary-card">
                        <p class="summary-card-label">Growth</p>
                        <p class="summary-card-value">{{ $summary['teams_count'] }}</p>
                        <p class="summary-card-title">Teams</p>
                        <p class="summary-card-caption">Registered clubs</p>
                    </div>
                </td>
                <td>
                    <div class="summary-card">
                        <p class="summary-card-label">Total</p>
                        <p class="summary-card-value">{{ $summary['players_count'] }}</p>
                        <p class="summary-card-title">Players</p>
                        <p class="summary-card-caption">Active registrations</p>
                    </div>
                </td>
            </tr>
        </table>

        @forelse ($data as $federation)
            <article class="federation-card">
                <div class="federation-hero">
                    <table class="federation-hero-table">
                        <tr>
                            <td class="federation-logo-cell">
                                <div class="federation-logo-box">
                                    @if (! empty($federation['logo_path']))
                                        <img
                                            class="federation-logo"
                                            src="{{ $federation['logo_path'] }}"
                                            alt="Logo of {{ $federation['name'] }}"
                                        >
                                    @endif
                                </div>
                            </td>
                            <td>
                                <h3>{{ $federation['name'] }}</h3>
                                <p>Official institutional governance profile</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="federation-body">
                    <table class="content-grid">
                        <tr>
                            <td class="details-column">
                                <h4 class="section-heading">General Information</h4>

                                <table class="detail-grid">
                                    <tr>
                                        <td>
                                            <p class="detail-label">Foundation date</p>
                                            <p class="detail-value">{{ $federation['foundation_date'] ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="detail-label">Country</p>
                                            <p class="detail-value">{{ $federation['country'] ?? 'N/A' }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="detail-label">Subdivision</p>
                                            <p class="detail-value">{{ $federation['subdivision'] ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="detail-label">Municipality</p>
                                            <p class="detail-value">{{ $federation['municipality'] }}</p>
                                        </td>
                                    </tr>
                                    <tr class="address-block">
                                        <td colspan="2">
                                            <p class="detail-label">Address</p>
                                            <p class="detail-value">{{ $federation['address_line'] }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="summary-column">
                                <div class="operational-panel">
                                    <h4>Operational Summary</h4>

                                    <div class="metric-box">
                                        <table class="metric-table">
                                            <tr>
                                                <td class="metric-label">Total teams</td>
                                                <td class="metric-value">{{ $federation['teams_count'] }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="metric-box gold">
                                        <table class="metric-table">
                                            <tr>
                                                <td class="metric-label">Total players</td>
                                                <td class="metric-value">{{ $federation['players_count'] }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{-- <div class="status-box">
                                        <p class="status-label">Compliance status</p>
                                        <p class="status-value">Fully compliant</p>
                                    </div> --}}
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table class="teams-header">
                        <tr>
                            <td>
                                <h4 class="section-heading">Affiliated Teams</h4>
                            </td>
                            <td class="teams-count">
                                <span class="teams-badge">{{ count($federation['teams']) }} records found</span>
                            </td>
                        </tr>
                    </table>

                    @if (empty($federation['teams']))
                        <p class="empty-state">No teams registered.</p>
                    @else
                        <table class="teams-table">
                            <thead>
                                <tr>
                                    <th style="width: 76px;">Crest</th>
                                    <th>Team name</th>
                                    <th style="width: 120px;">Player count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($federation['teams'] as $team)
                                    <tr>
                                        <td>
                                            <div class="crest-pill">
                                                @if (! empty($team['crest_path']))
                                                    <img
                                                        class="crest-image"
                                                        src="{{ $team['crest_path'] }}"
                                                        alt="Crest of {{ $team['name'] }}"
                                                    >
                                                @else
                                                    <span>N/A</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $team['name'] }}</td>
                                        <td>{{ $team['players_count'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </article>
        @empty
            <p class="empty-state">No federations found for the selected filters.</p>
        @endforelse

        <footer class="report-footer">
            <table class="report-footer-table">
                <tr>
                    <td>Soccer Management Federation Suite</td>
                    <td>Certified report</td>
                </tr>
            </table>
        </footer>
    </div>
</body>
</html>
