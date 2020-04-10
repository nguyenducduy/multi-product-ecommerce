<?php

Class Controller_Admin_NotFound Extends Controller_Admin_Base 
{
	
	function indexAction() 
	{
		$referer = base64_decode($_GET['r']);
		
		
		//calculate recommend url
		//strip query string
		$recommendurl = $referer;
		$querystringPos = strrpos($recommendurl, '?');
		if($querystringPos !== false)
			$recommendurl = substr($recommendurl, 0, $querystringPos);
		//strip page
		$pagePos = strrpos($recommendurl, '/page-');
		if($pagePos !== false)
			$recommendurl = substr($recommendurl, 0, $pagePos);
			
		if($recommendurl == $referer)
			$recommendurl = '';
		
		$this->registry->smarty->assign(array('referer' => $referer, 'recommendurl' => $recommendurl));
				
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
		$this->registry->smarty->assign('contents', $contents);
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		
		/*
		//demo to create notification
		$myWebSocketFeed = new WebSocketFeed();
		$myWebSocketFeed->userid = 1;
		$myWebSocketFeed->emittype = WebSocketFeed::EMITTYPE_PUSHNOTIFICATION;
		$myWebSocketFeed->url = $this->registry->conf['rooturl_cms'];
		$myWebSocketFeed->icon = $this->registry->me->getSmallImage();
		$myWebSocketFeed->meta = array('newmessage' => 3, 'newnotification' => 1, 'text' => 'Hello world');
		
		WebSocket::push(array($myWebSocketFeed));
		*/
		
	} 
}

