<?php
require '../config.php';

if (isset($_GET['parent']) && $_GET['parent'] && isset($_GET['name']) && $_GET['name'])
{
  $r = $plugoBrowser->createDir($_GET['name'], $_GET['parent']);
  
  $plugoBrowser->sendJson(array(
    'result' => $r[0],
    'path' => $r[0] ? $r[1] : '/'
  ));
}