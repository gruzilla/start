<?php


namespace App;

/**
 * SQLite Create Table Demo
 */
class SQLiteProjects {

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
        $projects = require('app/assets/initial/initialProjects.php');
        $i=0;
        foreach ($projects as $project) {
            $this->pdo->exec('INSERT INTO projects '.
                '(project_id, project_name) VALUES '.
                '(' . $i . ', "' . $project .'")');
            $i++;
        }
    }

    public function get($tag = null) {

        if ($tag === null) {
            $stmt = $this->pdo->query("SELECT *
                       FROM projects
                       ORDER BY RANDOM()");
        } else {
            $stmt = $this->pdo->query("SELECT *
                   FROM tags
                   WHERE tag_name=\"" . $tag . "\"");
            $res = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($res === false) {
                return array();
            }
            $stmt = $this->pdo->prepare("SELECT projects.*
                       FROM tag_project
                       LEFT JOIN projects ON (tag_project.project_id=projects.project_id)
                       WHERE tag_project.tag_id=:id
                       ORDER BY RANDOM()");
            $stmt->execute(array(':id' => $res['tag_id']));
        }

        $projects = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $projects[] = $row;
        }
        return $projects;
    }
}