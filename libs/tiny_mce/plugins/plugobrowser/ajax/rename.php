<?php
require '../config.php';

if (isset($_GET['path']) && $_GET['path'] && isset($_GET['prevName']) && $_GET['prevName'] && isset($_GET['newName']) && $_GET['newName'])
{
  $r = $plugoBrowser->rename($_GET['path'], $_GET['prevName'], $_GET['newName']);
  $path = $plugoBrowser->getExistingPathPart($_GET['path']);
  
  $plugoBrowser->sendJson(array(
    'result' => $r,
    'path' => $path
  ));
}