<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Team Report</title>
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
            margin-bottom: 20px;
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

        .team-card {
            margin-bottom: 24px;
            page-break-inside: auto;
        }

        .team-hero {
            margin-bottom: 18px;
        }

        .team-hero-table {
            width: 100%;
            border-collapse: collapse;
        }

        .team-hero-table td {
            vertical-align: middle;
        }

        .team-crest-cell {
            width: 84px;
        }

        .team-crest-box {
            width: 64px;
            height: 64px;
            background: #ffffff;
            border: 1px solid #e1e8f1;
            border-top: 3px solid #d0a24c;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 6px 18px rgba(20, 35, 61, 0.08);
        }

        .team-crest-box img {
            max-width: 44px;
            max-height: 44px;
            margin-top: 8px;
        }

        .team-title {
            margin: 0;
            font-size: 18px;
            color: #17365f;
            font-weight: 700;
        }

        .team-meta {
            margin: 5px 0 0;
            font-size: 10px;
            color: #8d6e2f;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .team-meta span {
            color: #5f6f83;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 700;
        }

        .team-document {
            text-align: right;
            font-size: 10px;
            color: #9aa9bc;
            font-style: italic;
        }

        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 -10px 18px;
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
            margin: 0 0 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9b7a35;
        }

        .summary-card-value {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            color: #17365f;
        }

        .summary-card-title {
            margin: 4px 0 0;
            font-size: 12px;
            font-weight: 700;
            color: #16263d;
        }

        .summary-card-caption {
            margin: 4px 0 0;
            font-size: 10px;
            color: #6d7d93;
        }

        .info-sections {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .info-sections td {
            width: 50%;
            vertical-align: top;
        }

        .info-panel-left {
            padding-right: 16px;
        }

        .section-heading {
            margin: 0 0 12px;
            font-size: 13px;
            font-weight: 700;
            color: #17365f;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-grid td {
            width: 50%;
            padding: 0 10px 14px 0;
            vertical-align: top;
        }

        .info-label {
            margin: 0 0 4px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #7a889b;
        }

        .info-value {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            color: #1b2c45;
        }

        .full-width td {
            width: 100%;
            padding-right: 0;
        }

        .federation-logo-box {
            margin-top: 8px;
            width: 72px;
            height: 72px;
            background: #ffffff;
            border: 1px solid #dce4ef;
            border-radius: 10px;
            text-align: center;
        }

        .federation-logo-box img {
            max-width: 52px;
            max-height: 52px;
            margin-top: 10px;
        }

        .roster-card {
            background: #ffffff;
            border: 1px solid #dce4ef;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(20, 35, 61, 0.08);
        }

        .roster-head {
            background: #0f3768;
            color: #ffffff;
            padding: 12px 14px;
        }

        .roster-head-table {
            width: 100%;
            border-collapse: collapse;
        }

        .roster-head-table td {
            vertical-align: middle;
        }

        .roster-title {
            margin: 0;
            font-size: 11px;
            font-weight: 700;
        }

        .roster-pill {
            text-align: right;
        }

        .pill {
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

        .players-table {
            width: 100%;
            border-collapse: collapse;
        }

        .players-table thead th {
            background: #0f2748;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            text-align: left;
            padding: 11px 12px;
        }

        .players-table tbody td {
            padding: 11px 12px;
            border-top: 1px solid #e5ecf4;
            vertical-align: middle;
            color: #21324b;
        }

        .players-table tbody tr:nth-child(even) {
            background: #fafcff;
        }

        .players-table tr {
            page-break-inside: avoid;
        }

        .player-name {
            font-weight: 700;
        }

        .gender-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .gender-badge.male {
            background: #e8f2ff;
            color: #245ea8;
        }

        .gender-badge.female {
            background: #fdeaf3;
            color: #ac3a73;
        }

        .gender-badge.unknown {
            background: #eef2f7;
            color: #5f6f83;
        }

        .roster-footer {
            padding: 10px 12px;
            border-top: 1px solid #e5ecf4;
            color: #6d7d93;
            font-size: 9px;
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
                        <img class="brand-logo" src="{{ public_path('images/soccer-management-long-logo.png') }}"
                            alt="Soccer Management">
                    </td>
                    <td class="topbar-title">
                        <h1>Football Federation Report</h1>
                        <p>Generated at {{ $generated_at->format('Y-m-d H:i:s') }}</p>
                    </td>
                </tr>
            </table>
        </header>

        @forelse ($data as $team)
            <article class="team-card">
                <section class="team-hero">
                    <table class="team-hero-table">
                        <tr>
                            <td class="team-crest-cell">
                                <div class="team-crest-box">
                                    @if (!empty($team['crest_path']))
                                        <img src="{{ $team['crest_path'] }}" alt="Crest of {{ $team['name'] }}">
                                    @endif
                                </div>
                            </td>
                            <td>
                                <h2 class="team-title">Team Report: {{ $team['name'] }}</h2>
                                <p class="team-meta">
                                    Member association
                                    <span>{{ $team['federation']['name'] ?? 'N/A' }}</span>
                                </p>
                            </td>
                            <td class="team-document">
                                Official institutional document
                            </td>
                        </tr>
                    </table>
                </section>

                <table class="summary-grid">
                    <tr>
                        <td>
                            <div class="summary-card">
                                <p class="summary-card-label">Current roster</p>
                                <p class="summary-card-value">{{ $team['players_count'] }}</p>
                                <p class="summary-card-title">Players</p>
                                <p class="summary-card-caption">Total professional players</p>
                            </div>
                        </td>
                        <td>
                            <div class="summary-card">
                                <p class="summary-card-label">Association</p>
                                <p class="summary-card-value">{{ $summary['federations_count'] }}</p>
                                <p class="summary-card-title">Federations</p>
                                <p class="summary-card-caption">Connected governing bodies</p>
                            </div>
                        </td>
                        <td>
                            <div class="summary-card">
                                <p class="summary-card-label">Portfolio</p>
                                <p class="summary-card-value">{{ $summary['teams_count'] }}</p>
                                <p class="summary-card-title">Teams</p>
                                <p class="summary-card-caption">Selected report entities</p>
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="info-sections">
                    <tr>
                        <td class="info-panel-left">
                            <h3 class="section-heading">General Information</h3>

                            <table class="info-grid">
                                <tr>
                                    <td>
                                        <p class="info-label">Official name</p>
                                        <p class="info-value">{{ $team['name'] }}</p>
                                    </td>
                                    <td>
                                        <p class="info-label">Players count</p>
                                        <p class="info-value">{{ $team['players_count'] }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="info-label">Foundation date</p>
                                        <p class="info-value">{{ $team['federation']['foundation_date'] ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="info-label">Municipality</p>
                                        <p class="info-value">{{ $team['federation']['municipality'] ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <h3 class="section-heading">Federation Governance</h3>

                            <table class="info-grid">
                                <tr>
                                    <td>
                                        <p class="info-label">Parent association</p>
                                        <p class="info-value">{{ $team['federation']['name'] ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="info-label">Country</p>
                                        <p class="info-value">{{ $team['federation']['country'] ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="info-label">Subdivision</p>
                                        <p class="info-value">{{ $team['federation']['subdivision'] ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="info-label">Address line</p>
                                        <p class="info-value">{{ $team['federation']['address_line'] ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                                <tr class="full-width">
                                    <td colspan="2">
                                        <p class="info-label">Federation logo</p>
                                        @if (!empty($team['federation']['logo_path']))
                                            <div class="federation-logo-box">
                                                <img src="{{ $team['federation']['logo_path'] }}"
                                                    alt="Logo of {{ $team['federation']['name'] ?? 'federation' }}">
                                            </div>
                                        @else
                                            <p class="info-value">N/A</p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <section class="roster-card">
                    <div class="roster-head">
                        <table class="roster-head-table">
                            <tr>
                                <td>
                                    <p class="roster-title">Registered Player Roster</p>
                                </td>
                                <td class="roster-pill">
                                    <span class="pill">{{ count($team['players']) }} players</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    @if (empty($team['players']))
                        <p class="empty-state">No players registered.</p>
                    @else
                        <table class="players-table">
                            <thead>
                                <tr>
                                    <th>Player name</th>
                                    <th>Birth date</th>
                                    <th>Gender</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($team['players'] as $player)
                                    <tr>
                                        <td class="player-name">{{ $player['name'] }}</td>
                                        <td>{{ $player['birth_date'] ?? 'N/A' }}</td>
                                        <td>
                                            <span class="gender-badge {{ $player['gender'] ?? 'unknown' }}">
                                                {{ $player['gender'] ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="roster-footer">
                            Showing {{ count($team['players']) }} registered players for {{ $team['name'] }}.
                        </div>
                    @endif
                </section>
            </article>
        @empty
            <p class="empty-state">No teams found for the selected filters.</p>
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
