<?php
require '../config.php';

$path = isset($_GET['path']) && $_GET['path'] && $_GET['path'] != '/' ? (substr($_GET['path'], -1) != '/' ? $_GET['path'] . '/' : $_GET['path']) : NULL;

$list = $plugoBrowser->readDir($_GET['path']);

$fileList = array();
$dirList = array();

if (is_array($list[0]))
{
  foreach($list[0] as $dir)
  {
    $dirName = htmlspecialchars(StrLib::toUTF8($dir));
    $fileInfo = $plugoBrowser->getFileInfo(($_GET['path'] == '/' ? NULL : $_GET['path'] . '/') . ($plugoBrowser->isWindows() ? iconv('cp1250', 'utf-8', $dir) : $dir));

    $dirList[] = array(
	    'name' => $dirName,
  	  'size' => $fileInfo['size'],
	    'last_modified' => $fileInfo['modified']
	  );
  }
}

if (is_array($list[1]))
{
  foreach($list[1] as $file)
  {
    $fileName = htmlspecialchars(StrLib::toUTF8($file));
	  $fileInfo = $plugoBrowser->getFileInfo(($_GET['path'] == '/' ? NULL : $_GET['path'] . '/') . ($plugoBrowser->isWindows() ? iconv('cp1250', 'utf-8', $file) : $file));
  
    $arr = array(
      'name' => $fileName,
      'size' => $fileInfo['size'],
      'last_modified' => $fileInfo['modified'],
      'icon' => $fileInfo['icon'],
	  );
	  
	  if (isset($fileInfo['width']) && isset($fileInfo['height']))
		{
			$arr['width'] = $fileInfo['width'];
			$arr['height'] = $fileInfo['height'];
		}
	  
	  $fileList[] = $arr;
  }
}

$pathSplit = $plugoBrowser->splitPath($_GET['path']);

$plugoBrowser->sendJson(array(
  'path' => $_GET['path'],
  'dirName' => end($pathSplit),
  'dirList' => $dirList,
	'fileList' => $fileList,
	'pathSplit' => $pathSplit
));