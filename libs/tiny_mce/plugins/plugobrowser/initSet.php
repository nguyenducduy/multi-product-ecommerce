<?php
/*
	PlugoBrowser v1.0
	Date: Januray 5, 2012
	Url: http://www.plugobrowser.com
	Copyright (c) 2012 Plugo s.r.o.
*/

require 'config.php';

if (isset($_POST['init']['upload_dir']) && ($uploadDir = trim($_POST['init']['upload_dir'])))
{
  if ($plugoBrowser->saveSettings(array('upload_dir' => $uploadDir, 'timezone' => $_POST['init']['timezone'])))
  {
    $plugoBrowser->initSettings();
    if (is_dir($plugoBrowser->getSettings('upload_dir_abs')))
    {
		  header('Location: dialog.php');
		  exit;
		}
  }
}

require 'data/template_init.php';