<?php
require '../config.php';

if (isset($_GET['settings']) && is_array($_GET['settings']))
{
  $r = $plugoBrowser->saveSettings($_GET['settings']);
  $plugoBrowser->sendJson(array(
    'result' => $r
  ));
}