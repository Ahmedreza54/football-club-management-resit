<h2><?= htmlspecialchars($title) ?></h2>
<p>
    <a href="index.php?r=api-standings" id="refreshBtn" class="btn btn-primary">
        Refresh Standings
    </a>
</p>
<p id="lastUpdated" class="text-muted">
    Last updated: <?= date('H:i:s') ?>
</p>

<table id="standingsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Position</th>
            <th>Club</th>
            <th>Played</th>
            <th>Won</th>
            <th>Draw</th>
            <th>Lost</th>
            <th>Points</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($standings as $team): ?>

        <tr>
            <td><?= $team['position'] ?></td>
<td>
      <img
        src="<?= htmlspecialchars($team['team']['crest']) ?>"
        width="25"
        height="25"
        style="margin-right:10px;vertical-align:middle;"
    >
    <?= htmlspecialchars($team['team']['name']) ?>
</td>
            <td><?= $team['playedGames'] ?></td>
            <td><?= $team['won'] ?></td>
            <td><?= $team['draw'] ?></td>
            <td><?= $team['lost'] ?></td>
            <td><?= $team['points'] ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
<script>
document.getElementById("refreshBtn").addEventListener("click", function(e) {
    e.preventDefault();

    fetch("index.php?r=api-standings&ajax=1")
        .then(response => response.json())
        .then(data => {

            let tbody = document.querySelector("#standingsTable tbody");
            tbody.innerHTML = "";
            const now = new Date();

            document.getElementById("lastUpdated").innerHTML =
                "Last updated: " + now.toLocaleTimeString();
            data.forEach(team => {

                tbody.innerHTML += `
                <tr>
                    <td>${team.position}</td>
                    <td>
                        <img src="${team.team.crest}" width="25" height="25" style="margin-right:10px;vertical-align:middle;">
                        ${team.team.name}
                    </td>
                    <td>${team.playedGames}</td>
                    <td>${team.won}</td>
                    <td>${team.draw}</td>
                    <td>${team.lost}</td>
                    <td>${team.points}</td>
                </tr>
                `;
            });

        });
});
</script>