<?php

Abstract Class Controller_Profile_Base Extends Controller_Admin_Base 
{
	public function __construct($registry)
	{
		//check valid uid_request url
		if(isset($_GET['profileid']))
		{
			
			if($registry->me->id == $_GET['profileid'])
				$registry->myUser = $registry->me;
			else
			{
				$myUser = new Core_User($_GET['profileid']);

				if($myUser->id > 0)
				{
					$registry->myUser = $myUser;
					

					//kiem tra trang thai friend voi user nay
					$registry->userIsFollowed = 0;

					if($registry->me->id > 0 && $registry->me->id != $myUser->id)
					{
						if($myUser->checkGroupname('group'))
							$registry->userIsFollowed = Core_UserEdge::isJoining($registry->me->id, $myUser->id);
						else
							$registry->userIsFollowed = Core_UserEdge::isFollowing($registry->me->id, $myUser->id);
					}

					$registry->smarty->assign('userIsFollowed', $registry->userIsFollowed);


					$registry->smarty->assign('myUserEncodedUrl', base64_encode($myUser->getUserPath()));

				}
				else
				{
					//USER NOT FOUND, REDIRECT TO NOT FOUND USER
					header('location: ' . $registry->conf['rooturl_admin'] . 'notfound?r=' . base64_encode(Helper::curPageURL()));
					exit();
				}
			}
		}
		else
		{
			$registry->myUser = $registry->me;
			$registry->userIsFollowed = 0;
			$registry->smarty->assign('userIsFollowed', $registry->userIsFollowed);
			$registry->smarty->assign('myUserEncodedUrl', base64_encode($registry->myUser->getUserPath()));
		}
		
		
		$registry->smarty->assign('myUser', $registry->myUser);
		

		parent::__construct($registry);
	}	
	

	
}
