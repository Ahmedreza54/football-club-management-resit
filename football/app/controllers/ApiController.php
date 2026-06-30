<?php
declare(strict_types=1);

final class ApiController
{
    /**
     * Return the current Premier League standings.
     */
    public function standings(): void
    {
        require_login();

        $api = new FootballApi();
        $data = $api->getStandings();

        if (isset($_GET['ajax'])) {

            header('Content-Type: application/json');
           
           // Send JSON response to the frontend
           echo json_encode($data['standings'][0]['table']);

            return;
        }

        View::render('api/standings', [
            'title' => 'Premier League Standings',
            'standings' => $data['standings'][0]['table']
        ]);
    }
    /**
     * Return upcoming Premier League fixtures.
     */

    public function upcomingMatches(): void
    {
        require_login();

        $api = new FootballApi();
        $data = $api->getUpcomingMatches();

        if (isset($_GET['ajax'])) {

            header('Content-Type: application/json');

            echo json_encode($data['matches']);

            return;
        }

        View::render('api/matches', [
            'title' => 'Upcoming Premier League Fixtures',
            'matches' => $data['matches']
        ]);
    }
    /**
     * Return the current Premier League top scorers.
     */

    public function topScorers(): void
    {
        require_login();

        $api = new FootballApi();
        $data = $api->getTopScorers();

        header('Content-Type: application/json');

        echo json_encode($data['scorers']);
    }
}