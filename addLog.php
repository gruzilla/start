<?php

require 'vendor/autoload.php';


use App\SQLiteConnection as SQLiteConnection;
use App\SQLiteLogs as SQLiteLogs;

$connection = new SQLiteConnection();

$logsMgr = new SQLiteLogs($connection);

header('Content-Type: application/json');

$worked = $logsMgr->add(
    isset($_POST['id']) ? intval($_POST['id']) : null,
    isset($_POST['data']) ? $_POST['data'] : null
);

echo json_encode($worked);