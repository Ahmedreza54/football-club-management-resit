<?php
declare(strict_types=1);

session_start();

$BASE_PATH = dirname(__DIR__, 2);
require_once $BASE_PATH . '/app/lib/Database.php';
require_once $BASE_PATH . '/app/lib/Auth.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$u = Auth::user();
$userId = (int)$u['id'];
$role = (string)$u['role'];
$action = (string)($_GET['action'] ?? '');

try {

    // ==========================
    // PLAYER STATS
    // ==========================
    if ($action === 'player_stats') {

        if ($role === 'player') {

            $sql = "
                SELECT u.id AS player_user_id,
                       u.name AS player_name,
                       SUM(CASE WHEN m.home_team_id=p.team_id THEN s.home_score ELSE s.away_score END) points,
                       SUM(CASE WHEN s.winner_team_id=p.team_id THEN 1 ELSE 0 END) wins
                FROM players p
                JOIN users u ON u.id=p.player_user_id
                JOIN matches m ON (m.home_team_id=p.team_id OR m.away_team_id=p.team_id)
                JOIN match_scores s ON s.match_id=m.id
                WHERE p.player_user_id=:id
                GROUP BY u.id,u.name
                ORDER BY wins DESC,points DESC";

            $rows = Database::fetchAll($sql,['id'=>$userId]);

        } elseif ($role === 'manager') {

            $sql = "
                SELECT u.id AS player_user_id,
                       u.name AS player_name,
                       SUM(CASE WHEN m.home_team_id=p.team_id THEN s.home_score ELSE s.away_score END) points,
                       SUM(CASE WHEN s.winner_team_id=p.team_id THEN 1 ELSE 0 END) wins
                FROM players p
                JOIN users u ON u.id=p.player_user_id
                JOIN teams t ON t.id=p.team_id
                JOIN matches m ON (m.home_team_id=p.team_id OR m.away_team_id=p.team_id)
                JOIN match_scores s ON s.match_id=m.id
                WHERE t.manager_user_id=:id
                GROUP BY u.id,u.name
                ORDER BY wins DESC,points DESC";

            $rows = Database::fetchAll($sql,['id'=>$userId]);

        } else {

            $sql = "
                SELECT u.id AS player_user_id,
                       u.name AS player_name,
                       SUM(CASE WHEN m.home_team_id=p.team_id THEN s.home_score ELSE s.away_score END) points,
                       SUM(CASE WHEN s.winner_team_id=p.team_id THEN 1 ELSE 0 END) wins
                FROM players p
                JOIN users u ON u.id=p.player_user_id
                JOIN matches m ON (m.home_team_id=p.team_id OR m.away_team_id=p.team_id)
                JOIN match_scores s ON s.match_id=m.id
                GROUP BY u.id,u.name
                ORDER BY wins DESC,points DESC";

            $rows = Database::fetchAll($sql);
        }

        echo json_encode(['player_stats'=>$rows]);
        exit;
    }

    // ==========================
    // TEAM RANKING
    // ==========================
    if ($action === 'team_ranking') {

        if ($role === 'manager') {

            $sql="
                SELECT t.id team_id,
                       t.name team_name,
                       SUM(CASE WHEN s.winner_team_id=t.id THEN 1 ELSE 0 END) wins,
                       SUM(CASE WHEN m.home_team_id=t.id THEN s.home_score ELSE s.away_score END) points
                FROM teams t
                JOIN matches m ON(m.home_team_id=t.id OR m.away_team_id=t.id)
                JOIN match_scores s ON s.match_id=m.id
                WHERE t.manager_user_id=:id
                GROUP BY t.id,t.name
                ORDER BY wins DESC,points DESC";

            $rows=Database::fetchAll($sql,['id'=>$userId]);

        } else {

            $sql="
                SELECT t.id team_id,
                       t.name team_name,
                       SUM(CASE WHEN s.winner_team_id=t.id THEN 1 ELSE 0 END) wins,
                       SUM(CASE WHEN m.home_team_id=t.id THEN s.home_score ELSE s.away_score END) points
                FROM teams t
                JOIN matches m ON(m.home_team_id=t.id OR m.away_team_id=t.id)
                JOIN match_scores s ON s.match_id=m.id
                GROUP BY t.id,t.name
                ORDER BY wins DESC,points DESC";

            $rows=Database::fetchAll($sql);
        }

        echo json_encode(['team_ranking'=>$rows]);
        exit;
    }

    // ==========================
    // LEADERBOARD
    // ==========================
    if ($action==='leaderboard'){

        $sql="
            SELECT u.id player_user_id,
                   u.name player_name,
                   SUM(CASE WHEN m.home_team_id=p.team_id THEN s.home_score ELSE s.away_score END) points,
                   SUM(CASE WHEN s.winner_team_id=p.team_id THEN 1 ELSE 0 END) wins
            FROM players p
            JOIN users u ON u.id=p.player_user_id
            JOIN matches m ON(m.home_team_id=p.team_id OR m.away_team_id=p.team_id)
            JOIN match_scores s ON s.match_id=m.id
            GROUP BY u.id,u.name
            ORDER BY points DESC,wins DESC
            LIMIT 10";

        $rows=Database::fetchAll($sql);

        echo json_encode(['leaderboard'=>$rows]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['error'=>'Unknown action']);

} catch(Throwable $e){

    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
}