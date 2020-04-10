<?php

Class Controller_Task_NotPermissionTracking Extends Controller_Task_Base 
{
	
	function indexAction() 
	{
		$formData = $_POST;
		
		//Get data from request
		$uid = (int)$formData['uid'];
		$referer = urldecode($formData['ref']);
		$sessionId = (string)$formData['sid'];
		$trackingId = (string)$formData['tid'];
		$ip = (int)$formData['ip'];
		$useragent = urldecode($formData['useragent']);
		
		//Insert DB
		$myNotPermissionLink = new Core_Backend_Notpermissionlink();
		$myNotPermissionLink->uid = $uid;
		$myNotPermissionLink->sessionid = $sessionId;
		$myNotPermissionLink->ipaddress = $ip;
		$myNotPermissionLink->useragent = $useragent;
		$myNotPermissionLink->addData();
		
	} 
	
	
}

