<?php
declare(strict_types=1);

final class FootballApi
{
    private string $apiKey;

    public function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/db.php';
        $this->apiKey = $config['football_api_key'];
    }

    public function getStandings(): array
    {
        $url = "https://api.football-data.org/v4/competitions/PL/standings?season=2025";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Auth-Token: {$this->apiKey}"
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }

    public function getUpcomingMatches(): array
    {
        $url = "https://api.football-data.org/v4/competitions/PL/matches?status=SCHEDULED";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Auth-Token: {$this->apiKey}"
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }

    public function getTopScorers(): array
    {
        $url = "https://api.football-data.org/v4/competitions/PL/scorers?season=2025";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Auth-Token: {$this->apiKey}"
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}