<?php
declare(strict_types=1);
?>

<div class="app-panel p-4">
    <h1 class="h3 fw-bold text-primary mb-2">
        <?php echo htmlspecialchars($title ?? 'Performance Dashboard'); ?>
    </h1>
    <p class="text-muted mb-4">
        Monitor player performance, team rankings, leaderboards and live Premier League information from a single dashboard.
    </p>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="border rounded shadow-sm p-3 h-100 bg-white">
            <h5 class="fw-bold text-primary mb-2">Player Statistics</h5>
                <div class="text-muted small mt-1">Player points and wins from recorded match results.</div>
                <div id="player-stats" class="small" class="mt-3 text-muted">Loading...</div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="border rounded shadow-sm p-3 h-100 bg-white">
            <h5 class="fw-bold text-success mb-2">Team Rankings</h5>
                <div class="text-muted small mt-1">Ranked by wins, tie-break by points.</div>
                <div id="team-ranking" class="small" class="mt-3 text-muted">Loading...</div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="border rounded shadow-sm p-3 h-100 bg-white">
            <h5 class="fw-bold text-warning mb-2">Leaderboard</h5>
                <div class="text-muted small mt-1">Top players by points.</div>
                <div id="leaderboard" class="small" class="mt-3 text-muted">Loading...</div>
            </div>
        </div>
        <div class="col-lg-4">
    <div class="border rounded shadow-sm p-3 h-100 bg-white">
    <h5 class="fw-bold text-info mb-2">Live Premier League</h5>
        <div class="text-muted small mt-1">Top 5 teams (Football API)</div>

        <table class="table table-sm mt-3 mb-0">
            <tbody>
            <?php foreach ($standings as $team): ?>
                <tr>
                    <td><?= $team['position'] ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($team['team']['crest']) ?>"
                             width="20"
                             height="20"
                             style="margin-right:8px;">
                        <?= htmlspecialchars($team['team']['name']) ?>
                    </td>
                    <td class="text-end">
                        <?= $team['points'] ?> pts
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <a href="index.php?r=api-standings" class="btn btn-sm btn-primary">
                View Full Table
            </a>
        </div>

    </div>
</div>

<script>
    function renderRows(rows) {
        if (!rows || rows.length === 0) {
            return '<div class="alert alert-info mb-0">No data yet.</div>';
        }
        let html = '<div class="table-responsive"><table class="table table-sm table-striped mb-0">';
        html += '<tbody>';
        rows.forEach(function (r) {
            html += '<tr>';
            if (r.rank !== undefined) html += '<td style="width:60px;">' + r.rank + '</td>';
            if (r.player_name !== undefined) html += '<td>' + r.player_name + '</td>';
            if (r.team_name !== undefined) html += '<td>' + r.team_name + '</td>';
            if (r.wins !== undefined) html += '<td class="text-end" style="width:80px;">' + r.wins + '</td>';
            if (r.points !== undefined) html += '<td class="text-end" style="width:90px;">' + r.points + '</td>';
            html += '</tr>';
        });
        html += '</tbody></table></div>';
        return html;
    }

    $(function () {
        function loadAction(action, targetId, renderFn) {
            // Support both entrypoints:
            // - /VollyBall Management System/public/index.php?r=dashboard
            // - /VollyBall Management System/index.php?r=dashboard
            const isPublicEntry = window.location.pathname.indexOf('/public/') !== -1;
            const apiUrl = isPublicEntry ? './api/dashboard.php' : './public/api/dashboard.php';

            $.getJSON(apiUrl, { action: action })
                .done(function (data) {
                    $('#' + targetId).html(renderFn(data));
                })
                .fail(function (xhr) {
                    $('#' + targetId).html('<div class="alert alert-danger mb-0">Failed to load: ' + (xhr.responseText || 'unknown error') + '</div>');
                });
        }

        loadAction('player_stats', 'player-stats', function (data) {
            const rows = data.player_stats || [];
            // Normalize for consistent row rendering.
            const norm = rows.map(function (r, i) {
                return { rank: i + 1, player_name: r.player_name, wins: r.wins, points: r.points };
            });
            return renderRows(norm);
        });

        loadAction('team_ranking', 'team-ranking', function (data) {
            const rows = data.team_ranking || [];
            const norm = rows.map(function (r, i) {
                return { rank: i + 1, team_name: r.team_name, wins: r.wins, points: r.points };
            });
            return renderRows(norm);
        });

        loadAction('leaderboard', 'leaderboard', function (data) {
            const rows = data.leaderboard || [];
            const norm = rows.map(function (r, i) {
                return { rank: i + 1, player_name: r.player_name, wins: r.wins, points: r.points };
            });
            return renderRows(norm);
        });
    });
</script>

