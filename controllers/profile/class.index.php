<?php

Class Controller_Profile_Index Extends Controller_Profile_Base 
{
	function indexAction() 
	{
		//GET ALL USER FEEDS
		
		//not good
		//$feedList = Core_Backend_Feed::getFeeds(array('fuserid' => $this->registry->myUser->id), '', '', $this->registry->setting['feed']['eachRequestCount']);
		
		
		//using caching now
		$userFeedIdList = Core_Backend_Feed::cacheGetUserFeedIds($this->registry->myUser->id, $cachesuccess, false, array('fuserid' => $this->registry->myUser->id), $this->registry->setting['feed']['eachRequestCount']);
		if(!empty($userFeedIdList))
		{
			$feedList = array();
			
			for($i = 0; $i < count($userFeedIdList); $i++)
			{
				$myFeed = new Core_Backend_Feed();
				$myFeed = Core_Backend_Feed::cacheGet($userFeedIdList[$i]); 
				
				//fix bug delete feed but live feedid in cache, it throw error when not found original feed, 22/7/72011
				if($myFeed->id > 0)
					$feedList[] = $myFeed;
			}
		}
		
		//$feedList = Core_Backend_Feed::getFeeds(array(), '', '', $this->registry->setting['feed']['eachRequestCount']);
		for($i = 0; $i < count($feedList); $i++)
		{
			if($feedStatUid != $feedList[$i]->uid)
			{
				$feedStatUid = $feedList[$i]->uid;
				$feedStatCount = 1;
			}
			else
			{
				//if repeat
				$feedStatCount++;
				//neu feed cua cung 1 user xuat hien > N lan thi minif cac feed sau
				if($feedStatCount > 2 && $feedList[$i]->numcomment == 0 && !$prevHasComment && !$prevHasLike)
				{
					$feedList[$i]->minify = 1;
				}
			}
			
			//danh dau de khi kiem tra feed tiep theo co minify hay ko
			//boi vi neu feed nay co comment thi feed sau se ko minify ^^, just UI trick
			if($feedList[$i]->numcomment > 0)
				$prevHasComment = true;
			else
				$prevHasComment = false;
				
			//atleast 2 like to not minify
			if($feedList[$i]->numlike > 1)
				$prevHasLike = true;
			else
				$prevHasLike = false;
				
				
			if($feedList[$i]->numcomment > 0)
			{
				if($feedList[$i]->numcomment > $this->registry->setting['feed']['commentShowPerFeed'])
				{
					$feedList[$i]->comments = array_reverse(Core_Backend_FeedComment::getComments(array('ffeedid' => $feedList[$i]->id), 'id', 'DESC', $this->registry->setting['feed']['commentShowPerFeed']));
				}
				else
				{
					$feedList[$i]->comments = Core_Backend_FeedComment::getComments(array('ffeedid' => $feedList[$i]->id), '', '', '');
					
					
				}
			}
			else
			{
				//echo 'save: ' . $feedList[$i]->id . '<br />';
				$feedList[$i]->comments = array();
			}
			
		}
		
		//track page view
		if($this->registry->me->id != $this->registry->myUser->id && $this->registry->myUser->increaseView(Core_UserView::TYPE_PROFILE))
		{
			$myUserView = new Core_UserView();
			$myUserView->uid = $this->registry->me->id;
			$myUserView->uid_receiver = $this->registry->myUser->id;
			$myUserView->type = Core_UserView::TYPE_PROFILE;
			$myUserView->addData();
		}
		
		
		
		
		$this->registry->smarty->assign(array('feedList' => $feedList,
											'redirectUrl' => base64_encode(Helper::curPageURL()),
											));
											
		if($this->registry->myUser->isStaff())
		{
			
			$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'];;
			$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
			$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];
		}
		else
		{
			$pageTitle = $this->registry->myUser->fullname;
			$pageKeyword = $this->registry->myUser->fullname;
			$pageDescription = $this->registry->myUser->fullname;
		}
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 	
		
			
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
	} 
	
	
	
	
	 
}

