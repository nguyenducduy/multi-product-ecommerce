<?php

Class Controller_Profile_Hovercard Extends Controller_Profile_Base 
{
	/**
	* Hien thi hovercard khi hover len 1 avatar/name
	* 
	*/
	function indexAction()
	{
		$myPartner = new Core_User((int)$_GET['id']);
		
		
		if($myPartner->id > 0)
		{
			//check privacy
			$isFollowing = false;
			if($this->registry->me->id > 0)
			{
				$isFollowing = Core_UserEdge::isFollowing($this->registry->me->id, $myPartner->id);
			}
			
			
			if($this->registry->me->id > 0 && $myPartner->id != $this->registry->me->id)
			{
				
				$myPartnerMutualfriendTask = Core_Backend_MutualfriendTask::cacheGet($myPartner->id);
				$myMutualfriendTask = Core_Backend_MutualfriendTask::cacheGet($this->registry->me->id);
				
				$mutualfriends = array_intersect($myPartnerMutualfriendTask->friendlist, $myMutualfriendTask->friendlist);
				$totalMutualfriend = count($mutualfriends);
				$mutualfriendlink = 0;
				$maxshow = 6;
				if($totalMutualfriend > $maxshow)
				{
					$mutualfriends = array_slice($mutualfriends, 0, $maxshow);
					$mutualfriendlink = 1;
				}
				$mutualfriendlist = array();
				if($totalMutualfriend > 0)
				{
					foreach($mutualfriends as $userid)
					{
						$mutualfriendlist[] = new Core_User($userid, true);
					}
				}
				
				
				
			}
			
			$this->registry->smarty->assign(array('myPartner' => $myPartner,
												'isFollowing' => $isFollowing,
												'mutualfriendlist' => $mutualfriendlist,
												'totalMutualfriend'			=> $totalMutualfriend,
												'mutualfriendlink'			=> $mutualfriendlink,
												));
			
		}
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl'); 
	}
}

