<?php

	///////////////////////////////////////////////////////
	// Embed the viephp session mechanism
	//
	//author: voduytuan<tuanmaster2002@yahoo.com>
	//

	
	$plugobrowser_imagemanager_path = 'libs'.DIRECTORY_SEPARATOR.'tiny_mce'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugobrowser';
	$viephpDirName = str_replace($plugobrowser_imagemanager_path, '', dirname(__FILE__));

	
	include($viephpDirName.'includes'.DIRECTORY_SEPARATOR.'config.php');
	include($viephpDirName.'includes'.DIRECTORY_SEPARATOR.'db.php');
	include($viephpDirName.'classes'.DIRECTORY_SEPARATOR.'class.helper.php');
	include($viephpDirName.'classes'.DIRECTORY_SEPARATOR.'class.timer.php');
	include($viephpDirName.'classes'.DIRECTORY_SEPARATOR.'class.cacher.php');
	include($viephpDirName.'classes'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'class.object.php');
	include($viephpDirName.'classes'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'class.user.php');
	include($viephpDirName.'classes'.DIRECTORY_SEPARATOR.'class.mypdo.php');
	
	try 
	{
		$db = new MyPDO('mysql:host='.$conf['db']['host'].';dbname='.$conf['db']['name'].'', ''.$conf['db']['user'].'', ''.$conf['db']['pass'].'');
		$db->query('SET NAMES utf8');

	}
	catch(PDOException $e) 
	{
		die('Database connection failed.');
	}

	//$session = new dbsession($db);
	//$session = new apcsession();
	ini_set('session.cookie_domain', '.dienmay.com');
	session_start();	
	
	$registry = new ArrayObject();
	$registry->db = $db;
	$registry->conf = $conf;
	
	//end customize