<?php

Class Controller_Crm_EmailPreview Extends Controller_Crm_Base
{
	
	public function indexAction()
	{
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'emailpreview',
												'pageTitle'	=> 'Email Template Preview',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	}
	
	public function previewAction()
	{
		$type = $_GET['type'];
		$this->registry->smarty->assign(array('datecreated' => date("F j, Y, g:i a"),
											'myUser' => $this->registry->me
															));
		switch($type)
		{
			case 'friendinvite': $mc = $this->friendinvite(); break;
			case 'friendaccept': $mc = $this->friendaccept(); break;
			case 'statusadd': $mc = $this->statusadd(); break;
			case 'messageadd': $mc = $this->statusadd(); break;
			case 'passreset': $mc = $this->statusadd(); break;
			case 'contact': $mc = $this->statusadd(); break;
			case 'message': $mc = $this->message(); break;
			case 'friendrequest': $mc = $this->friendrequest(); break;
		}
		
		$this->registry->smarty->assign(array('mailContents' => $mc));
	 	$this->registry->smarty->display($this->registry->smartyControllerContainer.'preview.tpl'); 
		
	}
	
	private function friendinvite()
	{
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'register/user.tpl');
	}
	
	private function friendaccept()
	{
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'register/user.tpl');
	}
	
	private function statusadd()
	{
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'register/user.tpl');
	}
	
	private function messageadd()
	{
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'register/user.tpl');
	}
	
	private function passreset()
	{
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'register/user.tpl');
	}
	
	private function contact()
	{
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'register/user.tpl');
	}
	
	private function message()
	{
		$this->registry->smarty->assign(array('message' => 'Nunc sit amet metus lorem, auctor rutrum neque. Nam velit neque, porta sed lobortis in, fringilla nec est. Vivamus viverra nisi id lectus imperdiet feugiat rhoncus sapien viverra. Integer odio leo, consequat et volutpat fringilla, rhoncus quis purus. Proin facilisis sodales gravida. Quisque tristique dolor ac eros ornare congue. Curabitur non quam nisi.'
															));
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'message/user.tpl');
	}
	
	private function friendrequest()
	{
		$this->registry->smarty->assign(array('mailuser' => $this->registry->me, 'mailuser2' => $this->registry->me
															));
		return $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'friend/request.tpl');
	}
	
    	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	
	
}
