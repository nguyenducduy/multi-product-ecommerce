<?php

Class Controller_Cms_Index Extends Controller_Cms_Base 
{
	
	function indexAction() 
	{
		header('location: ' . $this->registry->me->getUserPath() . '/home');
		
	} 
}
