<?php

require 'vendor/autoload.php';


use App\SQLiteConnection as SQLiteConnection;
use App\SQLiteLogs as SQLiteLogs;

$connection = new SQLiteConnection();

$logsMgr = new SQLiteLogs($connection);

header('Content-Type: application/json');

$logs = $logsMgr->get(isset($_GET['project']) ? intval($_GET['project']) : null);

echo json_encode($logs);