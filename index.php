<?php
error_reporting(E_ERROR | E_PARSE);
// $banIp = array('118.71.202.4','123.25.3.38');
// if(in_array($_SERVER['REMOTE_ADDR'], $banIp))
// {
// 	die('');
// }


require 'includes/config.php';
require 'includes/db.php';

//VERY IMPORTANT TO DETECT DOS
// include_once('classes/class.dosdetector.php');
include_once('classes/class.cacher.php');
include_once('classes/class.timer.php');
include_once('classes/class.statsd.php');


// $myDosDetector = new DosDetector();
// $myDosDetector->run();


if(isset($_GET['xprofiler']))
{
	include 'libs/pqp/classes/PhpQuickProfiler.php';
	$pqpProfiler = new PhpQuickProfiler(PhpQuickProfiler::getMicroTime(), SITE_PATH . 'libs/pqp/');
	define('PROFILER_PQP', 1);
}

$myTimer = new Timer();
$myTimer->start();

require 'includes/setting.php';
require 'includes/permission.php';
require 'includes/startup.php';
require 'controllers/core/class.base.php';

if((isset($_GET['live']) || isset($_GET['xprofiler'])) && ($me->groupid == 0 || $me->groupid > 5))
{
	header('HTTP/1.0 404 Not Found');
	die('Not found. <a href="https://ecommerce.kubil.app/" title="Dienmay.com">https://ecommerce.kubil.app</a>');
}


# Load router
$router = new Router($registry);
$registry->router = $router;
$router->setPath (SITE_PATH . 'controllers');
$router->delegate();


$myTimer->stop();
$execTime = $myTimer->get_exec_time(0, false);

//Tracking Process Time of PHP
MonitorMetric::timing('dienmay.web.server_all.cg_'.$GLOBALS['controller_group'].'.process_time', $execTime);
MonitorMetric::timing('dienmay.web.server_'. substr($_SERVER['SERVER_ADDR'], strrpos($_SERVER['SERVER_ADDR'], '.') + 1) .'.cg_'.$GLOBALS['controller_group'].'.process_time', $execTime);

//Tracking Number of access
MonitorMetric::increment('dienmay.web.server_all.cg_'.$GLOBALS['controller_group'].'.access');
MonitorMetric::increment('dienmay.web.server_all.access');

if(defined('PROFILER_PQP'))
{
	$pqpProfiler->display();	
}



