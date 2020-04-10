<?php

Class Controller_Stat_Realtime Extends Controller_Stat_Base
{
	public function indexAction()
	{
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> 'Real-time Analytic',
												'nav'		=> 'realtime',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
}


