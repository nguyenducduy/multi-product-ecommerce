<?php

Class Controller_Admin_Index Extends Controller_Admin_Base
{

	function indexAction()
	{

		header('location: ' . $this->registry->me->getUserPath() . '/home');
		exit();

		global $session;

		$server_php = $_SERVER['SERVER_SOFTWARE'];
		//explode to get server info and php info
		$pos = strripos($server_php, 'php');
		$formData['fserverip'] = $_SERVER['SERVER_ADDR'];
		$formData['fserver'] = trim(substr($server_php, 0, $pos-1));
		$formData['fphp'] = trim(substr($server_php, $pos));

		//get statistic info
		$stat['user'] = Core_User::getUsers(array(), '', '', '', true);
		$stat['useronline'] = $this->registry->db->query('SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'sess')->fetchColumn(0);
		$stat['memberonline'] = $this->registry->db->query('SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'sess WHERE s_userid <> 0')->fetchColumn(0);



		$this->registry->smarty->assign(array('formData' => $formData,
												'stat'	=> $stat
												));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		$this->registry->smarty->assign(array('contents' => $contents,
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_dashboard'])
												);
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

	}
}

