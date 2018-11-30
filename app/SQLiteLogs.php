<?php


namespace App;

/**
 * SQLite Manager for goals
 */
class SQLiteLogs {

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
    }

    public function get($projectId) {
        $stmt = $this->pdo->prepare('SELECT *
                                   FROM log
                                   WHERE project_id=:id
                                   ORDER BY created DESC');

        $stmt->execute(array(':id' => $projectId));

        $logs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $logs[] = $row;
        }
        return $logs;
    }

    public function add($projectId, $logEntry) {
        $stmt = $this->pdo->prepare('INSERT INTO log
                                   (project_id, log_entry) VALUES (:id, :data)');

        return (bool) $stmt->execute(array(':id' => $projectId, ':data' => $logEntry));
    }
}