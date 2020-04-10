<?php

Class Controller_Admin_NotPermission Extends Controller_Admin_Base 
{
	
	function indexAction() 
	{
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
		$this->registry->smarty->assign('contents', $contents);
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     	
	} 
}

