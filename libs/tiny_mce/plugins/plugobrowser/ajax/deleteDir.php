<?php
require '../config.php';

if (isset($_GET['path']) && $_GET['path'])
{
  if ($plugoBrowser->deleteDir($_GET['path']))
  {
    $path = $plugoBrowser->getExistingPathPart(dirname($_GET['path']));
  
    $plugoBrowser->sendJson(array(
      'result' => TRUE,
      'path' => $path
    ));
  }
  else $plugoBrowser->sendJson(array(
    'result' => FALSE
  ));
}