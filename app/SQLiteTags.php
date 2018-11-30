<?php


namespace App;

/**
 * SQLite Create Table Demo
 */
class SQLiteTags {

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
        $tags = require('app/assets/initial/initialTags.php');
        $p = 0;
        $ti = 0;
        foreach ($tags as $projTags) {
            foreach ($projTags as $tag) {
                $stmt = $this->pdo->query("SELECT *
                       FROM tags
                       WHERE tag_name=\"" . $tag . "\"");
                $res = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($res === false) {
                    $this->pdo->exec('INSERT INTO tags '.
                        '(tag_id, tag_name) VALUES '.
                        '(' . $ti . ', "' . $tag .'")');
                    $tagId = $ti;
                    $ti++;
                } else {
                    $tagId = $res['tag_id'];
                }

                $this->pdo->exec('INSERT INTO tag_project '.
                    '(tag_id, project_id) VALUES '.
                    '(' . $tagId . ', ' . $p .')');
            }
            $p++;
        }
    }

    public function get($projectId = null) {
        if (is_numeric($projectId)) {
            $stmt = $this->pdo->prepare("SELECT tags.*
                                       FROM tags
                                       LEFT JOIN tag_project ON (tags.tag_id=tag_project.tag_id)
                                       WHERE tag_project.project_id=:id");

            $stmt->execute(array(':id' => $projectId));
        } else {
            $stmt = $this->pdo->query("SELECT *
                       FROM tags");
        }

        $tags = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tags[] = $row;
        }
        return $tags;
    }
}