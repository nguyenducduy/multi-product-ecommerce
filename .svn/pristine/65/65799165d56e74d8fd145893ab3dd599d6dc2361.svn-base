<?php

//viephp authenticate
//create database connection
include('viephp_adapter.php');

ini_set("display_errors", 0);

if($_SESSION['userLogin'] >= 1)
{
	$me = new Core_User();
	$me->updateFromSession();

	if($me->id > 0 && ($me->groupid == GROUPID_ADMIN || $me->groupid == GROUPID_MODERATOR || $me->groupid == GROUPID_DEVELOPER || $me->groupid == GROUPID_EMPLOYEE || $me->groupid == GROUPID_PARTNER))
	{
		// Set session
		$_SESSION['isLoggedIn'] = true;

		
	}
}

if($_SESSION['isLoggedIn'] == false)
{
	die('Authentication Failed. Contact your Administrator for this permission checking.');
	exit();
}



function __autoload($class)
{
  $dir = dirname(__FILE__);
  if (file_exists($dir . '/classes/' . $class . '.php')) require_once $dir . '/classes/' . $class . '.php';
}

$plugoBrowser = new PlugoBrowser();