<?php

namespace App;

/**
 * SQLite Create Table Demo
 */
class SQLiteCreateTable {

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

    /**
     * create tables
     */
    public function createTables() {
        $commands = array_map(
            function($qry) { return $qry . ')'; },
            explode(');', file_get_contents('db.sql'))
        );
        array_pop($commands);

        // execute the sql commands to create new tables
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    public function dropTables() {
        $this->pdo->exec('DROP TABLE projects;');
        $this->pdo->exec('DROP TABLE goals;');
        $this->pdo->exec('DROP TABLE tags;');
        $this->pdo->exec('DROP TABLE tag_project;');
        $this->pdo->exec('DROP TABLE log;');
    }

    /**
     * get the table list in the database
     */
    public function get() {

        $stmt = $this->pdo->query("SELECT name
                                   FROM sqlite_master
                                   WHERE type = 'table'
                                   ORDER BY name");
        $tables = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tables[] = $row['name'];
        }

        return $tables;
    }

}