<?php

Class Controller_Profile_Feed Extends Controller_Profile_Base 
{
	function indexAction() 
	{
	}
	 
	/**
	* Xem chi tiet 1 feed
	* Thuong dc xem tu phan notification link qua
	* 
	*/
	function detailAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myFeed = new Core_Backend_Feed($id);
		
		if($myFeed->id == 0)
		{
			$this->notfound();
		}
		else
		{
			//get the valid userid co the xem duoc feed nay
			$friendIds = Core_Backend_Friend::getFriendIds($this->registry->me->id);   
			$friendIds[] = $this->registry->me->id;	
			
			$mySpecificFeed = Core_Backend_Feed::factory($myFeed->type);
			$mySpecificFeed->getDefaultData($myFeed);
			
			if($mySpecificFeed->numcomment > $this->registry->setting['feed']['commentShowInFeedDetail'])
			{
				$mySpecificFeed->comments = array_reverse(Core_Backend_FeedComment::getComments(array('ffeedid' => $mySpecificFeed->id), 'id', 'DESC', $this->registry->setting['feed']['commentShowInFeedDetail']));
			}
			else
			{
				$mySpecificFeed->comments = Core_Backend_FeedComment::getComments(array('ffeedid' => $mySpecificFeed->id), '', '', '');
			}
			
			
			$this->registry->smarty->assign(array('feed' => $mySpecificFeed,
												));
			
			$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'];;
			$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
			$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];
			
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl'); 
			$this->registry->smarty->assign(array('contents' => $contents,
												'pageTitle' => $pageTitle,
												'pageKeyword' => $pageKeyword,
												'pageDescription' => $pageDescription,
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		}
	}
	
	/**
	* lay cac feed cua user
	* 
	*/
	function indexajaxAction()
	{
		$moreMessage = '';
		$error = array();
		$formData = $_POST;
		
		$page = (int)$_POST['page'];
		
		if(isset($_GET['page']))
			$page = (int)$_GET['page'];
			
		if($page <= 1)
			$page = 1;
		
		if(isset($_GET['home']))
		{
			//check valid permission
			if($this->registry->me->id > 0)
			{
				//GET ALL USER FEEDS
				
				//following ids (Include: Following, Group, Department ^^)
				$myFollowingIdList = $this->registry->me->getFullFollowingList();
				
				//add ME to this list
				$myFollowingIdList[] = $this->registry->me->id;
				
				if(!empty($myFollowingIdList))
				{
					//lay cac feed trong cache
					if($page == 1)
					{
						$homeFeedIdList = Core_Backend_Feed::cacheGetHomeFeedIds($this->registry->me->id, $cacheSuccess, false, array('fuseridlist' => $myFollowingIdList), ($page - 1) * $this->registry->setting['feed']['eachRequestCount'] . ',' .$this->registry->setting['feed']['eachRequestCount']);
					}
					else
					{
						//neu page > 2 thi lay live data, ko lay tu cache vi cung it nguoi xem trang 2
						$homeFeedIdList = Core_Backend_Feed::getHomeFeedIds($this->registry->me->id, array('fuseridlist' => $myFollowingIdList), ($page - 1) * $this->registry->setting['feed']['eachRequestCount'] . ',' .$this->registry->setting['feed']['eachRequestCount']);
						
					}
					
					if(!empty($homeFeedIdList))
					{
						$feedList = array();
						
						for($i = 0; $i < count($homeFeedIdList); $i++)
						{
							$myFeed = new Core_Backend_Feed();
							$myFeed = Core_Backend_Feed::cacheGet($homeFeedIdList[$i]); 
							
							if($myFeed->id > 0 && !in_array($myFeed->id, array()))
								$feedList[] = $myFeed;
						}
					}
					
				}
			}
		}
		else
		{
			$userFeedIdList = Core_Backend_Feed::getUserFeedIds($this->registry->me->id, array('fuserid' => $this->registry->myUser->id), ($page - 1) * $this->registry->setting['feed']['eachRequestCount'] . ',' .$this->registry->setting['feed']['eachRequestCount']);
			if(!empty($userFeedIdList))
			{
				$feedList = array();
				
				for($i = 0; $i < count($userFeedIdList); $i++)
				{
					$myFeed = new Core_Backend_Feed();
					$myFeed = Core_Backend_Feed::cacheGet($userFeedIdList[$i]); 
					
					if($myFeed->id > 0)
						$feedList[] = $myFeed;
				}
			}
		}
		
		//compact
		//Boi vi dienmay.com se hien thi theo thu tu latest, ko can compact va group cac feed
		//if(!empty($feedList))
		//	$feedList = Core_Backend_Feed::compact($feedList);
			
		//GET ALL USER FEEDS
		if(count($feedList) > 0)
		{
						
			for($i = 0; $i < count($feedList); $i++)
			{
				//compact repeat feed from same user
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
						//disable minify
						//$feedList[$i]->minify = 1;
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
					$feedList[$i]->comments = array();
				}
				
				$feedList[$i]->minify = 0;
				
				
			}
			
			$this->registry->smarty->assign(array('feedList' => $feedList,
												'page' => $page,
												'redirectUrl' => base64_encode($this->registry->myUser->getUserPath()),
												));
			
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');
		}
		else
		{
			echo 'empty';
		}        
	}
	
	/**
	* Remove feed
	* 
	*/
	function removeajaxAction()
	{
		//sleep(3);
		$feedid = (int)$_GET['feedid'];
		$myFeed = new Core_Backend_Feed($feedid);
		$success = 0;
		
		
		if($myFeed->id > 0)
		{
			//get correct subclass to call canDelete()
			$mySpecificFeed = Core_Backend_Feed::factory($myFeed->type);
			$mySpecificFeed->getDefaultData($myFeed);
			
			//check feed owner
			if($mySpecificFeed->canDelete($this->registry->me->id))
			{
				if($mySpecificFeed->delete())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succDelete'];
					
					//clear cache
					Core_Backend_Feed::cacheDelete($mySpecificFeed->id);
				}
				else
				{
					$message = $this->registry->lang['controller']['errDelete'];	
				}
			}
			else
			{
				$message = $this->registry->lang['controller']['errNotOwner'];
			}
		}
		else
		{
			$message = $this->registry->lang['controller']['errFeednotfound'];
		}
		
				
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
	
	
	/**
	* Danh dau khong nhan thong bao moi tu 1 feed
	* 
	*/
	function unfollowajaxAction()
	{
		$success = 0;
		$message = '';
		
		$feedid = (int)$_GET['id'];
		$myFeed = new Core_Backend_Feed($feedid);
		if($myFeed->id > 0)
		{
			//check xem user nay co lien quan den feed nay khong
			if($myFeed->isFollow($this->registry->me->id))
			{
				$myFeed->addToList($this->registry->me->id, 'hide');
				$myFeed->removeFromList($this->registry->me->id, 'user');
				
				//khong xoa khoi danh sach like
				//boi vi co su dung danh sach nay de hien thi ai like feed nay ^^
				//$myFeed->removeFromList($myid, 'like');
				
				if($myFeed->updateData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succHideFeed'];
				}
				else
				{
					$message = $this->registry->lang['controller']['errHideFeed'];
				}
			}
			else
			{
				$message = $this->registry->lang['controller']['errFeednotfound'];
			}
		}
		else
		{
			$message = $this->registry->lang['controller']['errFeednotfound'];
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
		
	}
	
	function editAction()
	{
		$feedId = (int)$_GET['id'];
		$myFeed = new Core_Backend_Feed($feedId, true);
		
		if($myFeed->id == 0 || !$myFeed->canEdit($this->registry->me->id))
		{
			die('Feed Not Found');
		}

		$mySpecificFeed = Core_Backend_Feed::factory($myFeed->type);
		$mySpecificFeed->getDefaultData($myFeed);
		
		//get the original message
		$statusmessage = $mySpecificFeed->data['message'];
		
		
		
		//kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
		$this->registry->smarty->assign(array('myFeed' => $myFeed,
												'statusmessage' => $statusmessage,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl'); 
		
		//kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
		$this->registry->smarty->assign(array('contents' => $contents,
											));
		
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot.'index_shadowbox.tpl'); 
		
	}
	
	/**
	* Update 1 feed
	* 
	*/
	function editajaxAction()
	{
		$success = 0;
		$message = '';
		
		if($this->registry->me->id < 0)
		{
			$message = $this->registry->lang['default']['loginRequired'];
		}
		else
		{
			$myFeed = new Core_Backend_Feed((int)$_GET['id']);
			if($myFeed->id == 0 || !$myFeed->canEdit($this->registry->me->id))
			{
				$message = $this->registry->lang['controller']['errFeednotfound'];	
			}
			else
			{
				$formData = $_POST;
				
				$mySpecificFeed = Core_Backend_Feed::factory($myFeed->type);
				$mySpecificFeed->getDefaultData($myFeed);
				
				//assign new message
				$mySpecificFeed->data['message'] = htmlspecialchars(trim($formData['fmessage']));
				
				if($mySpecificFeed->updateData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succEdit'];
					
					//clear cache
					Core_Backend_Feed::cacheDelete($myFeed->id);
				}
				else
					$message = $this->registry->lang['controller']['errEdit'];
			}
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
	
	###########################################################3
	###########################################################3
	###########################################################3 

	
}

