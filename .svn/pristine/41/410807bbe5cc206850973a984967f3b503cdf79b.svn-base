<?php

Class Controller_Task_SearchTracking Extends Controller_Task_Base 
{
	
	function indexAction() 
	{
		$formData = $_POST;
		
		//Get data from request
		$q = urldecode($formData['q']);
		$uid = (int)$formData['uid'];
		$categoryid = (int)$formData['cid'];
		$referer = urldecode($formData['ref']);
		$sessionId = (string)$formData['sid'];
		$trackingId = (string)$formData['tid'];
		$ip = (int)$formData['ip'];
		$numresult = (int)$formData['num'];
		
		//Insert DB
		$mySearch = new Core_Backend_Search();
		$mySearch->uid = $uid;
		$mySearch->text = $q;
		$mySearch->categoryid = $categoryid;
		$mySearch->referrer = $referrer;
		$mySearch->sessionid = $sessionId;
		$mySearch->trackingid = $trackingid;
		$mySearch->ipaddress = $ip;
		$mySearch->numresult = $numresult;
		$mySearch->addData();
		
	} 
	
	
}

