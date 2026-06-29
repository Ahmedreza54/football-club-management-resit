<h2>Upcoming Premier League Fixtures</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Home Team</th>
            <th></th>
            <th>Away Team</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($matches as $match): ?>

        <tr>
            <td><?= htmlspecialchars($match['homeTeam']['name']) ?></td>

            <td><strong>vs</strong></td>

            <td><?= htmlspecialchars($match['awayTeam']['name']) ?></td>

            <td><?= date('d/m/Y', strtotime($match['utcDate'])) ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>