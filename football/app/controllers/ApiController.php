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
        $responseData = $api->getStandings();

        if (isset($_GET['ajax'])) {

            header('Content-Type: application/json');

            // Send JSON response to the frontend
            echo json_encode($responseData['standings'][0]['table']);

            return;
        }

        View::render('api/standings', [
            'title' => 'Premier League Standings',
            'standings' => $responseData['standings'][0]['table']
        ]);
    }

    /**
     * Return upcoming Premier League fixtures.
     */
    public function upcomingMatches(): void
    {
        require_login();

        $api = new FootballApi();
        $responseData = $api->getUpcomingMatches();

        if (isset($_GET['ajax'])) {

            header('Content-Type: application/json');

            // Send JSON response to the frontend
            echo json_encode($responseData['matches']);

            return;
        }

        View::render('api/matches', [
            'title' => 'Upcoming Premier League Fixtures',
            'matches' => $responseData['matches']
        ]);
    }

    /**
     * Return the current Premier League top scorers.
     */
    public function topScorers(): void
    {
        require_login();

        $api = new FootballApi();
        $responseData = $api->getTopScorers();

        header('Content-Type: application/json');

        // Send JSON response to the frontend
        echo json_encode($responseData['scorers']);
    }
}