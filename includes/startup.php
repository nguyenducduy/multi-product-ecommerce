<?php
spl_autoload_register('autoload1');


if (get_magic_quotes_gpc())
{
    function stripslashes_gpc(&$value)
    {
        $value = stripslashes($value);
    }

    array_walk_recursive($_GET, 'stripslashes_gpc');
    array_walk_recursive($_POST, 'stripslashes_gpc');
    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
}


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//INIT REGISTRY VARIABLE - MAIN STORAGE OF APPLICATION
$registry = new Registry();

//detect HTTPS/SSL Connection
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	$registry->https = true;
}


//=========================================================
//connect to database using PDO
/*
try
{
	$db = new MyPDO('mysql:host=' . $conf['db']['host'] . ';dbname=' . $conf['db']['name'] . '', '' . $conf['db']['user'] . '', '' . $conf['db']['pass'] . '');
	$db->query('SET NAMES utf8');
}
catch(PDOException $e)
{
	$error = $e->getMessage();
	die('Database connection failed. <!-- '.$error.'-->');
}
*/



$db = new MyPDOProxy();
$db->addMaster($conf['db']['host'], $conf['db']['user'], $conf['db']['pass'], $conf['db']['name']);
$db->addSlaver($conf['db_replicate01']['host'], $conf['db_replicate01']['user'], $conf['db_replicate01']['pass'], $conf['db_replicate01']['name']);
$db->addSlaver($conf['db_replicate02']['host'], $conf['db_replicate02']['user'], $conf['db_replicate02']['pass'], $conf['db_replicate02']['name']);


//unset the database config information for not leak security
unset($conf['db']);

//register an object to hold all global objects
$registry->conf = $conf;
$registry->db = $db;
$registry->setting = $setting;

//Init session
//$session = new dbsession($db);
ini_set('session.cookie_domain', '.dienmay.myhost');
session_start();

//Init tracking ID
if(!isset($_COOKIE['_t']) || strlen($_COOKIE['_t']) == 0)
{
	setcookie('_t', Helper::getSessionId(), time() + 3600 * 24 * 365, '/');
	$_COOKIE['_t'] = Helper::getSessionId();	//use for current first access ^^
}


//=========================================================
//---IMPORTANT-------------------
// set base dir to correct the relative link
$route = parseRouterFromHtaccess(Router::initRoute('site'));

$parts = explode('/', $route);


if($parts[0])
{
	$GLOBALS['controller_group'] = $parts[0];
	$conf['servername'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $parts[0] . '/';
}



if(!empty($parts[1]))
{
	$GLOBALS['controller'] = $parts[1];
	if(!empty($parts[2]))
	{
		$GLOBALS['action'] = $parts[2];
	}
	else
	{
		$GLOBALS['action'] = 'index';
		$route = $GLOBALS['controller_group'] . '/' . $GLOBALS['controller'] . '/' . 'index';
	}
}
else
{
	$GLOBALS['controller'] = 'index';
	$GLOBALS['action'] = 'index';
	$route = $GLOBALS['controller_group'] . '/' . 'index' . '/' . 'index';
}



$GLOBALS['route'] = $route;
for ($i = 0; $i < count($parts) - 1; $i++)
{
	Registry::$base_dir .= '../';
}


//===================================================
//get language
if(isset($_GET['language']))
{
	$_SESSION['language'] = $_GET['language'];
	setcookie('language', $_GET['language'], time() + 24 * 3600, '/');
}

if(isset($_POST['language']))
{
	$_SESSION['language'] = $_POST['language'];
	setcookie('language', $_POST['language'], time() + 24 * 3600, '/');
}



/*
if(isset($_SESSION['language']))
	$langCode = $_SESSION['language'];
elseif(isset($_COOKIE['language']))
	$langCode = $_COOKIE['language'];
else
	$langCode = $conf['defaultLang'];

$langCode = substr($langCode, 0, 2);
*/
$langCode = 'vn';

//declare language variable
$lang = array();
$lang['global'] = Helper::GetLangContent('language' . DIRECTORY_SEPARATOR  . $langCode . DIRECTORY_SEPARATOR, 'global');

if(in_array($GLOBALS['controller_group'], array('admin', 'cms', 'stat', 'crm', 'erp', 'task', 'cron', 'profile')))
	$defaultDirectoryLang = 'admin';
else
	$defaultDirectoryLang = 'site';

$lang['default'] = Helper::GetLangContent('language' . DIRECTORY_SEPARATOR . $langCode . DIRECTORY_SEPARATOR . $defaultDirectoryLang . DIRECTORY_SEPARATOR, 'default');
$lang['controller'] = Helper::GetLangContent('language' . DIRECTORY_SEPARATOR . $langCode . DIRECTORY_SEPARATOR . $GLOBALS['controller_group'] . DIRECTORY_SEPARATOR, $GLOBALS['controller']);


//=============================
// CURRENCY INITIALIZATION
$currencyCode = $_SESSION['fcurrency'];

//set currency
if(isset($_GET['fcurrency']))
	$currencyCode = substr($_GET['fcurrency'], 0, 3);

if(isset($_POST['fcurrency']))
	$currencyCode = substr($_POST['fcurrency'], 0, 3);

$_SESSION['fcurrency'] = $currencyCode;
setcookie('fcurrency', $currencyCode, time() + 24*3600);

//create currency object
$currency = new Currency($setting['payment']['vnd_to_usd_exchange']);

///////////////////////////////////////////
//detect mobile device
$mobiledetect = new MobileDetect();
//trick here from the algorithm of extract subdomain just from the dot character, so if there is no subdomain, subdomain = dienmay (extract from http://dienmay.com)
if($mobiledetect->isMobile() && SUBDOMAIN == 'mywebshop')
{
	//check force desktopsite is disable
	if(!isset($_COOKIE['forcedesktop']) || $_COOKIE['forcedesktop'] == 0)
	{
		//begin redirect link to mobile version
		$curPageURL = Helper::curPageURL();
		$curPageURL = str_replace(array('http://', 'https://'), array('http://m.', 'https://m.'), $curPageURL);
		header('location: ' . $curPageURL);
	}
}
$registry->mobiledetect = $mobiledetect;
///////////////////////////////////////////


$registry->lang = $lang;
$registry->langCode = $langCode;
$registry->currency = $currency;
$registry->controller = $GLOBALS['controller'];
$registry->controllerGroup = $GLOBALS['controller_group'];

$registry->cart = new Core_CookieCart();
//$registry->cart = new Core_Cart();


$me = new Core_User();
$me->updateFromSession();
$me->checkPerm();
$registry->me = $me;



//===================================================
//get region of current user/guest
//update region id to cookie
//first, get region from ME, lowest priority
//first time, there is no region information
$myRegionIdCookieExpire = time() + 24 * 3600 * 30;	//30 days

if(!isset($_SESSION['myregion']) || !isset($_COOKIE['myregion']))
{
	if($me->region > 0)
	{
		$_SESSION['myregion'] = $me->region;
		setcookie('myregion', $me->region, $myRegionIdCookieExpire, '/');
	}
	else
	{
		//heuristic to predict the region of current user
		//To do:
		$myRegionId = Core_Region::predictRegion();
		if($myRegionId > 0)
		{
			$_SESSION['myregion'] = $myRegionId;
			setcookie('myregion', $myRegionId, $myRegionIdCookieExpire, '/');
		}
	}
}

if(isset($_GET['myregion']))
{
	$_SESSION['myregion'] = (int)$_GET['myregion'];
	setcookie('myregion', $_GET['myregion'], $myRegionIdCookieExpire, '/');
}

if(isset($_POST['myregion']))
{
	$_SESSION['myregion'] = (int)$_POST['myregion'];
	setcookie('myregion', $_POST['myregion'], $myRegionIdCookieExpire, '/');
}

//init the region
if(isset($_SESSION['myregion']) && $_SESSION['myregion'] > 0)
	$registry->region = (int)$_SESSION['myregion'];
elseif(isset($_COOKIE['myregion']) && $_COOKIE['myregion'] > 0)
	$registry->region = (int)$_COOKIE['myregion'];
else
	$registry->region = 3;	//default: Ho Chi Minh

if($registry->region < 3)
	$registry->region = 3;

//////////////////
//Include Smarty class
include(SITE_PATH. 'libs' . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php');
$smarty = new Smarty();

//set current template
$currentTemplate = 'default';
$registry->currentTemplate =  $registry->getResourceHost('static');

$smarty->template_dir = 'templates/' . $currentTemplate;
$smarty->compile_dir = 'templates/_core/templates_c/';
$smarty->config_dir = 'templates/_core/configs/';
$smarty->cache_dir = 'templates/_core/cache/';
$smarty->compile_id = $currentTemplate;	//seperate compiled template file
$smarty->error_reporting = E_ERROR | E_PARSE;
$smarty->compile_check = $setting['site']['smartyCompileCheck'];

// force compilation of all template files
//$smarty->compileAllTemplates('.tpl',true);
//exit();


$smarty->assign(array('base_dir' => Registry::$base_dir,
					  'registry' => $registry,
					  'langCode' => $langCode,
					  'lang' => $lang,
					  'currency'	=> $currency,
					  'setting'	=> $setting,
					  'controller' => $GLOBALS['controller'],
					  'controllerGroup' => $GLOBALS['controller_group'],
					  'action' => $GLOBALS['action'],
					  'redirect' => base64_encode($GLOBALS['route']),
					  'currentTemplate'	=> $registry->getResourceHost('static'),
					  'currentUrl' => Helper::curPageURL(),
					  'imageDir' => $registry->getResourceHost('static') . (SUBDOMAIN == 'm' ? 'm/' : '') . 'images/',
					  'paginateLang' 	=> array('first' 			=> $lang['global']['navpageFirst'],
												'last' 				=> $lang['global']['navpageLast'],
												'firstTooltip' 		=> $lang['global']['navpageFirstTooltip'],
												'lastTooltip' 		=> $lang['global']['navpageLastTooltip'],
												'previous'			=> $lang['global']['navpagePrevious'],
												'next' 				=> $lang['global']['navpageNext'],
												'previousTooltip' 	=> $lang['global']['navpagePreviousTooltip'],
												'nextTooltip' 		=> $lang['global']['navpageNextTooltip'],
												'pageTooltip' 		=> $lang['global']['navpagePageTooltip']),
					  'me' => $me,
					  'conf' => $conf));
$registry->smarty = $smarty;






Helper::fixBackButtonOnIE();

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


/////////////////////////////////////////////////
/////////////////////////////////////////////////
//REWRITE RULE FOR WEBSITE HERE
function parseRouterFromHtaccess($route)
{
	global $setting, $conf;


	$parts = explode('/', $route);


	//not check URL Rewrite if specified controller group
// var_dump($parts[0]);die;
	if(in_array($parts[0], array('site', 'admin', 'task', 'cron', 'cms', 'stat', 'crm', 'erp', 'profile', 'ws', 'wse', 'connection')))
		return $route;

	$controllergroup = '';
	$controller = '';
	$action = '';
	$routerArgString = '';
	for($i = 0; $i < count($parts); $i++)
	{
		$partValue = $parts[$i];

		//this is a page group: trang-1, trang-2...
		if(preg_match('/^a(\d+)$/', $partValue, $match))
		{
			$controllergroup = 'profile';
			$_GET['profileid'] = $match[1];
		}
		elseif(preg_match('/page-(\d+)/', $partValue, $match))
		{
			//this is a page group: trang-1, trang-2...
			$_GET['page'] = $match[1];
		}
		elseif($i == 0 && preg_match('/^[a-z0-9\_-]+-a(\d+)$/', $partValue, $match))
		{
			//banner quang cao
			$controllergroup = 'site';
			$controller = 'go';
			$_GET['id'] = $match[1];
		}
		elseif($i == 0 && $partValue == 'tim-kiem')
		{
			$url = $conf['rooturl'] . 'search?c=0&q=' . $_GET['s'];
			header('location: ' . $url);
			exit();
		}
		elseif(preg_match('/^[a-z0-9\_-]+-rao-vat-(\d+)$/', $partValue, $match))
		{
			//raovat
			$controllergroup = 'site';
			$controller = 'stuff';
			$action = 'detail';
			$_GET['id'] = $match[1];
			header('HTTP/1.0 404 Not Found');
			readfile('./404.html');
			exit();
		}
		elseif($partValue == 'add' || $partValue == 'edit' || $partValue == 'delete')
		{
			//check action
			$action = $partValue;
		}
		elseif($partValue == 'tin-tuc')
		{
			$controllergroup = 'site';
			$controller = 'news';
		}
		elseif($partValue == 'rao-vat')
		{
			$controllergroup = 'site';
			$controller = 'stuff';
			header('HTTP/1.0 404 Not Found');
			readfile('./404.html');
			exit();
		}
		elseif($partValue == 'thuong-hieu')
		{
			$controllergroup = 'site';
			$controller = 'product';
			$action = 'vendorList';
		}
		elseif(is_numeric($partValue) && !isset($_GET['id']))
		{
			$_GET['id'] = (int)$partValue;
		}
		elseif(preg_match('/^[a-z0-9-]+$/', $partValue, $match))
		{
			//find slug
			$mySlug = Core_Slug::getSlugFromText($partValue);
			if($mySlug->id <= 0 && $partValue == 'dienthoaigi')
			{
				header("HTTP/1.1 301 Moved Permanently");
				header('location: '.$conf['rooturl'].'dien-thoai-di-dong');
				exit();
			}
			if($mySlug->id > 0)
			{
				//Rewrite rule here
				if($mySlug->checkStatusName('redirect'))
				{
					header("HTTP/1.1 301 Moved Permanently");
					header('location: ' . $mySlug->getSlugPathRedirect());
					exit();
				}
				elseif($mySlug->checkStatusName('reference'))
				{
					//get reference slug id
					$mySlugReference = new Core_Slug($mySlug->ref);
					if($mySlugReference->id > 0)
					{
						header('location: ' . $mySlugReference->getSlugPath());
						exit();
					}
					else
					{
						//header('location: ' . $conf['rooturl'] . 'notfound');
						header('HTTP/1.0 404 Not Found');
						readfile('./404.html');
						exit();
					}
				}
				else
				{
					switch($mySlug->controller)
					{
						case 'product':
							$controllergroup = 'site';
							$controller = 'product';
							$action = 'detail';
							$_GET['pid'] = $mySlug->objectid;
							break;
						case 'productcategory':
							$controllergroup = 'site';
							$controller = 'product';
							$action = 'index';
							$_GET['pcid'] = $mySlug->objectid;
							break;
						case 'vendor':
							$controllergroup = 'site';
							$controller = 'product';
							$_GET['fvid'] = $mySlug->objectid;

							if($_GET['pcid'] > 0)
								$action = 'index';
							else
								$action = 'vendor';

							break;
						case 'news':
							$controllergroup = 'site';
							$controller = 'news';
							$action = 'detail';
							$_GET['id'] = $mySlug->objectid;
							break;
						case 'newscategory':
							$controllergroup = 'site';
							$controller = 'news';
							$action = 'index';
							$_GET['ncid'] = $mySlug->objectid;
							break;
						case 'stuffcategory':
							$controllergroup = 'site';
							$controller = 'stuff';
							$action = 'index';
							$_GET['scid'] = $mySlug->objectid;
							break;
						case 'page':
							$controllergroup = 'site';
							$controller = 'page';
							$action = 'detail';
							$_GET['id'] = $mySlug->objectid;
							break;
						case 'event':
							$controllergroup = 'site';
							$controller = 'event';
							$action = 'detail';
							$_GET['id'] = $mySlug->objectid;
							break;
					}//end switch
				}//end check
			}
			else
			{
				//not found slug, just normal matching in URL
				if($i == 0)
				{
					//default controller from group SITE
					$controllergroup = 'site';
					$controller = $partValue;
				}
				else
				{
					if($controller != '')
					{
						if($action == '')
							$action = $partValue;
						else
							$routerArgString .= $partValue . '/';
					}
					else
						$controller = $partValue;
				}
			}
		}
		else if(strlen($partValue) > 0)
		{
			$routerArgString .= $partValue . '/';
		}
	}
	
	
	if($parts[0] == 'product-of-the-year' && $parts[1] == 'san-pham')
	{
		$controllergroup = 'site';
		$controller = 'productyear';
		$action = 'detail';
		$_GET['id'] = $parts[2];
	}elseif ($parts[0] == 'product-of-the-year' && !empty($parts[1])) {
		$controllergroup = 'site';
		$controller = 'productyear';
		$action = 'article';
		$_GET['slug'] = $parts[1];
	}
	
	switch ($controller)
	{
		case 'sieuthi':
						if($action == 'tinh')
						{
							//define cho tinh
							$action = 'region';
							if ($routerArgString != '') $_GET['id'] =  Core_Region::getIdBySlug(substr($routerArgString, 0, -1));
						}
						else
						{
							if ($action == '')
							{
								$action = 'index';
							}
							else
							{
								if (empty($_GET['id'])) $_GET['id'] =  Core_Store::getIdBySlug($action);
								$action = 'detail';
							}
						}
			break;
		case 'khoi-dau-hoan-hao':
					$controller = 'discountproduct';
					if ($action == 'san-pham')
					{
						$action = 'detail';
					}
			break;
		case 'dau-gia-nguoc':
			$controller = 'reverseauctions';
			$action = 'index';
			break;
		case 'year-in-review':
			$controller = 'gamefasteye';
			$action = 'index';
			break;
		case 'product-of-the-year':
			$controller = 'productyear';
			$action = 'index';
			break;
		case 'thanh-vien':
				if ($action == 'dang-ky')
				{
					$controller = 'login';
					$action = 'index';
				}
				elseif ($action == 'quen-mat-khau')
				{
					$controller = 'forgotpass';
					$action = 'index';
				}
			break;
		case 'dong-gia-33-ngan':
			$controller = 'eventproducthours';
			$action = 'index';
			break;
		case 'cart':
		 	 $mypartsing = substr($action,4);
		 	 $newmySlug = Core_Slug::getSlugFromText($mypartsing);
		 	 if($newmySlug->id > 0 && $newmySlug->objectid > 0)
		 	 {
			 	$_GET['id'] = $newmySlug->objectid;
			 	$action = 'checkout';
			 }
			 //$action = 'checkout';
			 /*if($action != 'dattruoc')
			 {
			 	$action = 'checkout';
			 }*/
			 //echodebug($controller.'---'.$action.'----', true);
			break;
		case 'news':
				if (!empty($action) && $action != 'detail' && $action != 'index')
				{
					header('HTTP/1.0 404 Not Found');
					readfile('./404.html');
					exit();
				}
			break;
		case 'product':
				if (($action == '' && empty($_GET['pcid'])) || ($action == 'detail' && empty($_GET['pid'])))
				{
					header('HTTP/1.0 404 Not Found');
					readfile('./404.html');
					exit();
				}
			break;
		case '':
				if($_GET['productid'] > 0)
			    {
	     			$controller = 'product';
	     			$action = 'detail';
				}
			    else
	    			$controller = 'index';
			break;
	}

	if($action == '') $action = 'index';

	$route = '';
	if($controllergroup != '')
		$route .= $controllergroup . '/';
	if($controller != '')
		$route .=  $controller . '/' ;
	if($action != '')
		$route .= $action . '/';
	if($routerArgString != '')
		$route .= $routerArgString;



	return $route;
}


function echodebug($data, $die=false)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';

	if($die) die();
}
