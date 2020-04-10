<?php
Class Controller_Site_Tracking Extends Controller_Site_Base
{
	public function __construct()
	{
		
	}
	
	public function indexAction()
	{
		global $registry;

		$objectId = (int)$_POST['trackingid'];
		$controllergroup = $_POST['controller_group'];
		$controller = $_POST['controller'];
		$action = $_POST['action'];
		$referer = $_POST['referer'];

		$maxViewCountPerSession = 200;
		
		if(class_exists('Core_Backend_View'))
		{
			//Init object
			$viewType = Core_Backend_View::getType($controllergroup, $controller, $action);
			$moretext = '';
			
			if(Core_Backend_View::checkTypeName($viewType, 'groupcontrollersite'))
				$moretext = $controller;
			elseif(Core_Backend_View::checkTypeName($viewType, 'search'))
				$moretext = Helper::plaintext($_POST['q']);
				
			//Use identifier to prevent spam in ONE second
			$trackingObjectIdentifier = Core_Backend_View::getTrackingObjectIdentifier($controllergroup, $controller, $action, $objectId, $moretext);
			// echodebug($trackingObjectIdentifier);
			// echodebug($_SESSION['currentView']);

			// var_dump((!isset($_SESSION['currentView']) || (is_array($_SESSION['currentView']) && count($_SESSION['currentView']) < $maxViewCountPerSession && !in_array($trackingObjectIdentifier, $_SESSION['currentView']))));

			// var_dump(Core_Backend_View::isTrackable($controllergroup, $controller, $action) );

			// var_dump(!isset($_SESSION['viewtrackingBeforeMoretext']) || ($_SESSION['viewtrackingBeforeMoretext'] != '' && $_SESSION['viewtrackingBeforeMoretext'] != $moretext));

			// var_dump($_SESSION['viewtrackingBeforeMoretext']);

			// 	exit();
			//Validate for spamming
			if(Helper::checkCookieEnable()
				&& (!isset($_SESSION['currentView']) || (is_array($_SESSION['currentView']) && count($_SESSION['currentView']) < $maxViewCountPerSession && !in_array($trackingObjectIdentifier, $_SESSION['currentView']))) && Core_Backend_View::isTrackable($controllergroup, $controller, $action) 
				&&
					(
						$moretext == '' || ($moretext != '' && 

				 (!isset($_SESSION['viewtrackingBeforeMoretext']) || ($_SESSION['viewtrackingBeforeMoretext'] != '' && $_SESSION['viewtrackingBeforeMoretext'] != $moretext))
				 ))
			)
			{
				$_SESSION['viewtrackingBeforeType'] = $viewType;
				$_SESSION['viewtrackingBeforeId'] = $objectId;
				$_SESSION['viewtrackingBeforeMoretext'] = $moretext;
				$_SESSION['currentView'][] = $trackingObjectIdentifier;
				
				//Insert view BackgroundTask
				$taskUrl = $registry->conf['rooturlbackground'] . 'task/viewtracking';

				$postData = array();
				$postData[] = 't=' . (int)$viewType;
				$postData[] = 'mt=' . urlencode(Helper::plaintext($moretext));
				$postData[] = 'uid=' . (int)$registry->me->id;
				$postData[] = 'oid=' . (int)$objectId;
				$postData[] = 'dv=' . urlencode(Core_Backend_View::getDevice());
				$postData[] = 'os=' . urlencode(Core_Backend_View::getOs());
				$postData[] = 'ref=' . (string)$referer;
				$postData[] = 'bt=' . (int)$_SESSION['viewtrackingBeforeType'];
				$postData[] = 'bid=' . (int)$_SESSION['viewtrackingBeforeId'];
				$postData[] = 'sid=' . (string)Helper::getSessionId();
				$postData[] = 'tid=' . (string)Helper::getTrackingId();
				$postData[] = 'ip=' . (int)Helper::getIpAddress(true);
				$postDataString = implode('&', $postData);
				Helper::backgroundHttpPost($taskUrl, $postDataString);
			}
		}
	}

}