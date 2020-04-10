<?php

	/**
	* Homepage of automatic task
	* 
	* This section is not using main site permission to check
	* because it's can be run from command line
	* 
	* So, for security problem
	* it's must be check from request IP address	
	*/
	
	include('../includes/config.php');
	include('../includes/setting.php');
	include('_template.php');
	
	
	// error_reporting(E_ALL & ~E_NOTICE);
	// ini_set('display_erros', 1);
	
	////////////////////////////////////////
	//	AUTHENTICATION BASED ON IP ADDRESS
	$allowIp = array();
	
	if(count($allowIp) > 0 && !in_array(Helper::getIpAddress(), $allowIp))
	{
		die();
	}
	
	//////////////////////////////////////
	//	INITIALIZE MAIN PROCESS
	$site_path = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	define ('DEBUG_WRITEFILE', true);
	define ('SITE_PATH', $site_path);
	define('IN_TASK', 1);
	define('NL', "\n");
	define('DASH', "--------------------------------------------------------------------------------");
	define ('TABLE_PREFIX', 'lit_');
	spl_autoload_register('autoload1');
	
	


	$debugTimer = new timer();
	$debugTimer->start();
	
	//=========================================================
	//connect to database using PDO
	try 
	{
		$db = new MyPDO('mysql:host=' . $conf['db']['host'] . ';dbname=' . $conf['db']['name'] . '', '' . $conf['db']['user'] . '', '' . $conf['db']['pass'] . '');
		$db->query('SET NAMES utf8');

	}
	catch(PDOException $e)
	{
		die('Database connection failed.');
	}
	//unset the database config information for not leak security
	unset($conf['db']);
	
	$session = new dbsession($db);
	
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	//INIT REGISTRY VARIABLE - MAIN STORAGE OF APPLICATION
	$registry = new Registry();
	//register an object to hold all global objects
	$registry->conf = $conf;
	$registry->db = $db;
	$registry->setting = $setting;
	
	//////////////////////////////////////
	//	CHECK CONTROLLER
	$controller = $_GET['c'];
	$controller = preg_replace('/[^a-z]/', '', $controller);
	
	if(DEBUG_WRITEFILE)
	{
		$fh = fopen($_GET['c'] . '_' . $_GET['a'] .'.txt', 'w');
		ob_start();
	}
	
	if(file_exists('controller/task.' . $controller . '.php'))
	{
		include('controller/task.' . $controller . '.php');
	}
	else
	{
		include('controller/task.index.php');
	}
	
	
	
	$debugTimer->stop();
	echo '<pre>' . NL.NL.NL.NL.DASH.NL.'Total Time process: ' . $debugTimer->get_exec_time() . ' second(s)</pre>';
	
	
	
	if(DEBUG_WRITEFILE)
	{
		fwrite($fh, ob_get_contents());
		fclose($fh);
	}
	
	////////////////////////////////////////////////
	function autoload1($classname)
	{
		$namepart = explode('_', $classname);
		$namepartCount = count($namepart);
		
		if($namepartCount > 1)
		{
			if($namepart[0] == 'Controller')
			{
				$filepath = '';
				for($i = 1; $i < $namepartCount - 1; $i++)
				{
					$filepath .= strtolower($namepart[$i]) . DIRECTORY_SEPARATOR;
				}
				$filename = SITE_PATH . 'controllers' . DIRECTORY_SEPARATOR . $filepath . 'class.' . strtolower($namepart[$namepartCount - 1]) . '.php';
			}
			else
			{
				$filepath = '';
				for($i = 0; $i < $namepartCount - 1; $i++)
				{
					$filepath .= strtolower($namepart[$i]) . DIRECTORY_SEPARATOR;
				}
				$filename = SITE_PATH . 'classes' . DIRECTORY_SEPARATOR . $filepath . 'class.' . strtolower($namepart[$namepartCount - 1]) . '.php';
			}
			
		}
		else
			$filename = SITE_PATH . 'classes' . DIRECTORY_SEPARATOR . 'class.' . strtolower($classname) . '.php';
			
		
		if (file_exists($filename) == false) 
		{
			return false;
		}
		

		include ($filename);
	}