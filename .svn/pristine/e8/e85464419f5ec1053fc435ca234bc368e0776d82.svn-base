<?php

Class Controller_Profile_Home Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
		$this->registry->smarty->assign(array(
											'redirectUrl' => base64_encode(Helper::curPageURL()),
											));
											
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
		    
	} 
	 
	 /**
	 * Sau khi dang nhap vao he thong
	 * Tien hanh re-check lai toan bo thong so stat cua user vua login
	 * 
	 * Luu y, Boi vi qua trinh cap nhat tung field info cua user se ton performance kha nhieu
	 * vi se phai co tuong ung moi query cho moi field
	 * do do, chi update deu dan 5 phut 1 lan chu khong update lien tuc
	 * 
	 */
	function updatestatajaxAction()
	{
		//check spam
		if(isset($_SESSION['updateAccountStat']) && $_SESSION['updateAccountStat'] + $this->registry->setting['account']['updateStatInterval'] > time())
		{
			//not expire
			echo 'OK';
		}
		else
		{
			//Core_Backend_Friend::cacheDeleteFriendIds($this->registry->me->id);
			//Core_PageLike::cacheDeleteLikeIds($this->registry->me->id);
			Core_Backend_Feed::cacheDeleteHomeFeedIds($this->registry->me->id);
			Core_Backend_Feed::cacheDeleteUserFeedIds($this->registry->me->id);
			
			//start update counting
			$this->registry->me->updateCounting(array('friend', 'blog'));
			$_SESSION['updateAccountStat'] = time();
			
			
		}
	}
}


