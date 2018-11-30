CREATE TABLE IF NOT EXISTS projects (
    project_id   INTEGER PRIMARY KEY,
    project_name TEXT    NOT NULL
);

CREATE TABLE IF NOT EXISTS goals (
    goal_id      INTEGER PRIMARY KEY,
    goal_name    TEXT    NOT NULL,
    type         TEXT    NOT NULL,
    project_id   INTEGER NOT NULL,
    FOREIGN KEY (
        project_id
    )
    REFERENCES projects (project_id) ON UPDATE CASCADE
                                     ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tags (
    tag_id       INTEGER PRIMARY KEY,
    tag_name     TEXT    NOT NULL
);

CREATE TABLE IF NOT EXISTS tag_project (
    tag_id       INTEGER NOT NULL,
    project_id   INTEGER NOT NULL,
    FOREIGN KEY (
        tag_id
    )
    REFERENCES tags (tag_id) ON UPDATE CASCADE
                             ON DELETE CASCADE,
    FOREIGN KEY (
        project_id
    )
    REFERENCES projects (project_id) ON UPDATE CASCADE
                                     ON DELETE CASCADE,
    PRIMARY KEY (tag_id, project_id)
);

CREATE TABLE IF NOT EXISTS log (
    log_id       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    log_entry    TEXT    NOT NULL,
    created      TEXT    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    project_id   INTEGER NOT NULL,
    FOREIGN KEY (
        project_id
    )
    REFERENCES projects (project_id) ON UPDATE CASCADE
                                     ON DELETE CASCADE
);