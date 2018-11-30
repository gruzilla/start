<?php

require 'vendor/autoload.php';


use App\SQLiteConnection as SQLiteConnection;
use App\SQLiteCreateTable as SQLiteCreateTable;
use App\SQLiteProjects as SQLiteProjects;
use App\SQLiteTags as SQLiteTags;
use App\SQLiteGoals as SQLiteGoals;

$connection = new SQLiteConnection();

$recreate = true;

// create new tables
if ($recreate) {
  $tableMgr = new SQLiteCreateTable($connection);
  $tableMgr->dropTables(); $tableMgr->createTables();
  $tables = $tableMgr->get();
}

// prepare the projects manager
$projectMgr = new SQLiteProjects($connection);
if ($recreate) {
  $projectMgr->init();
}

// prepare the tags manager
$tagsMgr = new SQLiteTags($connection);
if ($recreate) {
  $tagsMgr->init();
}

// prepare the goals manager
$goalsMgr = new SQLiteGoals($connection);
if ($recreate) {
  $goalsMgr->init();
}

$projects = $projectMgr->get(isset($_GET['tag']) ? $_GET['tag'] : null);


?><!doctype html>
<!--
  Abendstille START
  Copyright 2018 Matthias Steinböck. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>START</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="app/assets/images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="START">
    <link rel="apple-touch-icon-precomposed" href="app/assets/images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="app/assets/images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="app/assets/images/favicon.png">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="app/assets/mdl/material.min.css">
    <link rel="stylesheet" href="app/assets/css/dialog-polyfill.css">
    <link rel="stylesheet" href="app/assets/css/styles.css">
  </head>
  <body>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">START</span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <a class="mdl-navigation__link" href="/">all</a>
            <?php $tags = $tagsMgr->get(); foreach ($tags as $tag) { ?>
            <a class="mdl-navigation__link" href="?tag=<?php echo $tag['tag_name']; ?>"><?php echo $tag['tag_name']; ?></a>
            <?php } ?>
          </nav>
        </div>
      </header>
      <!--
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">START</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="">Link</a>
          <a class="mdl-navigation__link" href="">Link</a>
          <a class="mdl-navigation__link" href="">Link</a>
          <a class="mdl-navigation__link" href="">Link</a>
        </nav>
      </div>
      -->
      <main class="mdl-layout__content">
        <div class="page-content content-grid mdl-grid">
        <?php
            foreach ($projects as $project) {
                $title = $project['project_name'];
                $id = intval($project['project_id']);

                $tags = $tagsMgr->get($id);
                $shortTermGoals = $goalsMgr->getShort($id);
                $longTermGoals = $goalsMgr->getLong($id);

                include 'app/templates/card.php';
            }
        ?>
        </div>
      </main>
    </div>
    <dialog class="mdl-dialog" id="log-dialog">
    <h4 class="mdl-dialog__title">Log</h4>
    <div class="mdl-dialog__content">
      <p>
        Allowing us to collect data will let us get you the information you want faster.
      </p>
    </div>
    <div class="mdl-dialog__actions">
      <button type="button" class="mdl-button add">Add</button>
      <button type="button" class="mdl-button close">Close</button>
    </div>
    </dialog>
    <dialog class="mdl-dialog" id="add-log-dialog">
    <h4 class="mdl-dialog__title">Log</h4>
    <div class="mdl-dialog__content">
      <form>
        <textarea></textarea>
      </form>
    </div>
    <div class="mdl-dialog__actions">
      <button type="button" class="mdl-button save">Save</button>
    </div>
    </dialog>
    <script src="app/assets/mdl/material.min.js"></script>
    <script src="app/assets/js/jquery-3.3.1.min.js"></script>
    <script src="app/assets/js/dialog-polyfill.js"></script>
    <script src="app/assets/js/scripts.js"></script>
  </body>
</html>