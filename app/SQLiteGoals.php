<?php


namespace App;

/**
 * SQLite Manager for goals
 */
class SQLiteGoals {

    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * connect to the SQLite database
     */
    public function __construct($connection) {
        $this->pdo = $connection->getPdo();
    }

    public function init() {
        // wäh
        $goals = require('app/assets/initial/initialGoals.php');
        $p = 0;
        $gi = 0;
        foreach ($goals as $projGoals) {
            $stgs = $projGoals[0];
            $ltgs = $projGoals[1];
            foreach ($stgs as $stg) {
                    $this->pdo->exec('INSERT INTO goals '.
                        '(goal_id, goal_name, type, project_id) VALUES '.
                        '(' . $gi . ', "' . $stg .'", "short", ' . $p . ')');
                $gi++;
            }
            foreach ($ltgs as $ltg) {
                    $this->pdo->exec('INSERT INTO goals '.
                        '(goal_id, goal_name, type, project_id) VALUES '.
                        '(' . $gi . ', "' . $ltg .'", "long", ' . $p . ')');
                $gi++;
            }
            $p++;
        }
    }

    public function getShort($projectId) {
        return $this->get($projectId, 'short');
    }

    public function getLong($projectId) {
        return $this->get($projectId, 'long');
    }

    private function get($projectId, $type) {
        $stmt = $this->pdo->prepare('SELECT *
                                   FROM goals
                                   WHERE project_id=:id AND type="' . $type . '"');

        $stmt->execute(array(':id' => $projectId));

        $goals = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $goals[] = $row;
        }
        return $goals;
    }
}