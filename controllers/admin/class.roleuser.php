<?php
class Controller_Admin_RoleUser extends Controller_Admin_Base
{
	public function indexAction()
	{
		$this->registry->smarty->assign(array(	));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
}
