<?php

Class Controller_Site_NotPermission Extends Controller_Site_Base 
{
	
	function indexAction() 
	{

		header('HTTP/1.0 404 Not Found');
		readfile('./404.html');

		/*
		if(isset($_GET['r']))
		{
			$ref = base64_decode($_GET['r']);
		}
		else
		{
			$ref = $_SERVER['HTTP_REFERER'];
		}
		
		
		///////////////////
		//tracking search trong search product
		$postData = array();
		$postData[] = 'q=' . urlencode(Helper::plaintext($formData['q']));
		$postData[] = 'uid=' . (int)$this->registry->me->id;
		$postData[] = 'sid=' . (string)Helper::getSessionId();
		$postData[] = 'tid=' . (string)Helper::getTrackingId();
		$postData[] = 'ip=' . (int)Helper::getIpAddress(true);
		$postData[] = 'ref=' . urlencode(Helper::plaintext($ref));
		$postData[] = 'useragent=' . urlencode(Helper::plaintext($_SERVER['HTTP_USER_AGENT']));
		$postDataString = implode('&', $postData);
		$taskUrl = $this->registry->conf['rooturl'] . 'task/notpermissiontracking';
		Helper::backgroundHttpPost($taskUrl, $postDataString);
		//END TRACKING SEARCH
		///////////////////////////////
		
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
		$this->registry->smarty->assign('contents', $contents);
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl'); 
		*/
		    	
	} 
}

