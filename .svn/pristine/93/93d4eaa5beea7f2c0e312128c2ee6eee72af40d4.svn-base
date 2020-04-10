<?php

Class Controller_Profile_FeedReply Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
		$breadcrumb = array(
			array('link' => $this->registry->conf['rooturl'], 'title' => $this->registry->lang['global']['mHomesite']),
			array('link' => '', 'title' => $this->registry->lang['controller']['title'])
		);
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'breadcrumb'	=> $breadcrumb,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		
	} 
}

