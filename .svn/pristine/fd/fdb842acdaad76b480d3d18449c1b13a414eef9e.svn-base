<?php

Class Controller_Profile_BottomBar Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
		
		
	} 
	
	function indexajaxAction()
	{
		//keep online connection
		Core_UserOnline::setonline($this->registry->me->id);
		
		header('Content-type: text/xml');
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl'); 
	}
}

