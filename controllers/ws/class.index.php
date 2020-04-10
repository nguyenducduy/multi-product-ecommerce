<?php

Class Controller_Ws_Index Extends Controller_Ws_Base
{
    
	/**
	 * Set device for this client
	 */
    function indexAction()
	{
		$formData = $_POST;
		
		$info = array();
		
		$data = json_encode($info);
		echo $data;
	}
	
	
}

