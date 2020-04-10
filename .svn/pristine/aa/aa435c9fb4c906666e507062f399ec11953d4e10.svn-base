<?php

Class Controller_Task_ViewTracking Extends Controller_Task_Base 
{
	
	function indexAction() 
	{
		$formData = $_POST;
		
		//Get data from request
		$type = (int)$formData['t'];
		$moretext = urldecode($formData['mt']);
		$uid = (int)$formData['uid'];
		$objectId = (int)$formData['oid'];
		$device = urldecode($formData['dv']);
		$os = urldecode($formData['os']);
		$referer = (string)($formData['ref']);
		$beforeType = (int)$formData['bt'];
		$beforeId = (int)$formData['bid'];
		$sessionId = (string)$formData['sid'];
		$trackingId = (string)$formData['tid'];
		$ip = (int)$formData['ip'];
		
		//Insert DB
		$myView = new Core_Backend_View();
		$myView->type = $type;
		$myView->moretext = $moretext;
		$myView->uid = $uid;
		$myView->objectid = $objectId;
		$myView->device = $device;
		$myView->os = $os;
		$myView->referrer = $referer;
		$myView->beforetype = $beforeType;
		$myView->beforeid = $beforeId;
		$myView->sessionid = $sessionId;
		$myView->trackingid = $trackingid;
		$myView->ipaddress = $ip;
		$myView->addData();
		
		
	} 
	
	
}

