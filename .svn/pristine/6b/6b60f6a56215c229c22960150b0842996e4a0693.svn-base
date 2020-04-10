<?php
require '../config.php';

$path = isset($_GET['path']) && $_GET['path'] && $_GET['path'] != '/' ? (substr($_GET['path'], -1) != '/' ? $_GET['path'] . '/' : $_GET['path']) : NULL;

$tree = $plugoBrowser->readDirTreeUntil($path);

$plugoBrowser->sendJson(array(
  'dirList' => $tree
));