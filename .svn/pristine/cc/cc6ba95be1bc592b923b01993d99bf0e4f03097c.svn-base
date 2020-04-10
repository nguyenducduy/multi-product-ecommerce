<?php
require '../config.php';

if (isset($_GET['path']) && $_GET['path'])
{
  $fileInfo = $plugoBrowser->getFileInfo($_GET['path']);
  $path = $plugoBrowser->getExistingPathPart(dirname($_GET['path']));
  
  $plugoBrowser->sendJson(array(
    'fileInfo' => $fileInfo,
    'path' => $path
  ));
}