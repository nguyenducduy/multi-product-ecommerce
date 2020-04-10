<?php

Class Controller_Wse_Logout Extends Controller_Wse_Base 
{
	
	function indexAction() 
	{
		$myMobileSession = new Core_Backend_MSession();
		$myMobileSession->getDataBySession($_GET['s']);
		if($myMobileSession->id > 0)
		{
			$myMobileSession->delete();
		}
		
		///////////////
		// output
		$this->jsonGeneralOutput(true, $this->registry->setting['controller']['succLogout'], '', 0, true, false);
		
		
	} 
}

