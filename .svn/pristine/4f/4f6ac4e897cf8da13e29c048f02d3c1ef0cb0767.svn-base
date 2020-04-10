<?php
require '../config.php';

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

if (isset($_REQUEST['name']) && $_REQUEST['name'] && isset($_REQUEST['path']) && $_REQUEST['path'])
{
  @set_time_limit(5 * 60);
  
  $r = $plugoBrowser->handleUpload(
	  $_REQUEST['name'],
		$_REQUEST['path'],
		isset($_REQUEST['chunk']) ? $_REQUEST['chunk'] : 0,
		isset($_REQUEST['chunks']) ? $_REQUEST['chunks'] : 0,
		isset($_SERVER['HTTP_CONTENT_TYPE']) ? $_SERVER['HTTP_CONTENT_TYPE'] : (isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : NULL)
	);
	
	echo json_encode($r[0] ? array(
	  'result' => $r[0],
	  'id' => 'id'
	) : array(
	  'result' => $r[0],
	  'error' => array(
	    'code' => $r[1],
	    'message' => $r[2]
	  ),
	  'id' => 'id'
	));
}