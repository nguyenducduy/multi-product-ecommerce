<?php

Class Controller_Profile_Friend Extends Controller_Profile_Base
{
	/**
	* Trang liet ke cac friend cua user
	*
	*/
	function indexAction()
	{
		$formData = array('fuserid' => $this->registry->myUser->id);
		$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;

		//tim tong so record
		$total = Core_Backend_Friend::getFriends($formData, '', '', '', true);
		$totalPage = ceil($total/$this->registry->setting['friend']['recordPerPage']);
		$curPage = $page;
		$paginateUrl = $this->registry->myUser->getUserPath().'/friend/';

		if($curPage != 1 && $curPage > $totalPage)
		{
			$this->notfound();
		}

		$friendList = Core_Backend_Friend::getFriends($formData, 'datelastaction', 'DESC', (($page - 1)*$this->registry->setting['friend']['recordPerPage']).','.$this->registry->setting['friend']['recordPerPage']);

		//track page view
		if($this->registry->me->id != $this->registry->myUser->id && $this->registry->myUser->increaseView(Core_UserView::TYPE_FRIEND))
		{
			$myUserView = new Core_UserView();
			$myUserView->uid = $this->registry->me->id;
			$myUserView->uid_receiver = $this->registry->myUser->id;
			$myUserView->type = Core_UserView::TYPE_FRIEND;
			$myUserView->addData();
		}

		//kiem tra trang thai da ket ban chua trong danh sach friend cua nguoi khac
		$myFriendIds = array();
		if($this->registry->me->id != $this->registry->myUser->id)
		{
			$myFriendIds = Core_Backend_Friend::getFriendIds($this->registry->me->id);
		}


		$this->registry->smarty->assign(array('friendList' => $friendList,
											'formData'		=> $formData,
											'myFriendIds' => $myFriendIds,
											'paginateurl' 	=> $paginateUrl,
											'paginatesuffix' 	=> $paginateSuffix,
											'total'			=> $total,
											'totalPage' 	=> $totalPage,
											'curPage'		=> $curPage
											));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');


		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];


		if($curPage > 1)
		{
			$pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
			$pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
			$pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
		}

		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

	}


	/**
	* Trang tim ban
	*
	* Chuc nang chi danh cho viec tim kiem ban be cua minh, ko tim kiem ban be cua nguoi khac
	* Khong dan trang cho trang tim kiem, chi liet ke cac ket qua tim duoc va co toi da recordperpage
	*/
	function searchAction()
	{
		//search in my friendlist only
		if($this->registry->myUser->id != $this->registry->me->id)
		{
			die();
		}

		$keyword = Helper::xss_clean(strip_tags($_GET['keyword']));
		$formData = array('fuserid' => $this->registry->me->id, 'fkeywordFilter' => $keyword);
		$friendList = Core_Backend_Friend::getFriends($formData, 'datelastaction', 'DESC', $this->registry->setting['friend']['recordPerPage']);


		$this->registry->smarty->assign(array('friendList' => $friendList,
											'formData'		=> $formData,
											));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'search.tpl');


		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'] . $keyword;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'] . ',' . $keyword;
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'] . $keyword;



		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

	}


	/**
	* Xoa 1 ban khoi danh sach
	*
	*/
	function deleteajaxAction()
	{
		$success = 0;
		$friendid = (int)$_GET['id'];

		if(Core_Backend_Friend::deleteFriendCouple($this->registry->me->id, $friendid))
		{
			$success = 1;
			$message = $this->registry->lang['controller']['succDelete'];

			$myFriend = new Core_User($friendid);

			//update stat of user
			$this->registry->me->updateCounting(array('friend'));
			$myFriend->updateCounting(array('friend'));

			//update homefeedids
			Core_Backend_Feed::cacheDeleteHomeFeedIds($this->registry->me->id);
			Core_Backend_Feed::cacheDeleteHomeFeedIds($friendid);

			//update friendids cache
			Core_Backend_Friend::cacheDeleteFriendIds($this->registry->me->id);
			Core_Backend_Friend::cacheDeleteFriendIds($friendid);
		}
		else
		{
			$message = $this->registry->lang['controller']['errDelete'];
		}


		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}


	/**
	* Them vao danh sach ban
	*
	*/
	function addajaxAction()
	{
		$success = 0;
		$friendid = (int)$_GET['id'];

		//tinh tong so ban be cua minh
		$friendCount = Core_Backend_Friend::getFriends(array('fuserid' => $this->registry->me->id), '', '', '', true);

		//tinh tong so ban be cua nguoi se them
		$requestorFriendCount = Core_Backend_Friend::getFriends(array('fuserid' => $friendid), '', '', '', true);

		//check frienduser
		$myRequestor = new Core_User($friendid);

		if($myRequestor->id == 0)
		{
			$message = $this->registry->lang['controller']['errFriendNotFound'];
		}
		elseif($friendCount >= $this->registry->me->settingMaxFriend)
		{
			//kiem tra so luong ban cua minh
			$message = str_replace('###VALUE###', $this->registry->me->settingMaxFriend,$this->registry->lang['controller']['errMaxFriendQuotaExceed']);
		}
		elseif($requestorFriendCount >= $myRequestor->settingMaxFriend)
		{
			$message = str_replace(array('###VALUE###', '###VALUE2###'), array($myRequestor->fullname, $myRequestor->settingMaxFriend), $this->registry->lang['controller']['errMaxFriendQuotaExceedRequestor']);
		}
		else
		{
			//check friend request
			$friendRequest = Core_Backend_FriendRequest::getRequests(array('fuserid' => $friendid, 'ffriendid' => $this->registry->me->id), '', '', 1);
			if(count($friendRequest) == 0)
			{
				$message = $this->registry->lang['controller']['errRequestNotFound'];
			}
			else
			{
				//tien hanh them ban
				if(Core_Backend_Friend::addFriendCouple($this->registry->me->id, $friendid) > 0)
				{
					//update stat of user
					$this->registry->me->updateCounting(array('friend'));
					$myRequestor->updateCounting(array('friend'));

					//xoa request
					$friendRequest[0]->delete();

					$success = 1;
					$message = $this->registry->lang['controller']['succAdd'];

					//xu ly them REP neu hop le
					if(Core_Rep::canAdd($friendid, Core_Rep::TYPE_FRIEND_AGREE))
					{
						$myRep = new Core_Rep();
						$myRep->uid = $friendid;
						$myRep->uidtrigger = $this->registry->me->id;
						$myRep->type = Core_Rep::TYPE_FRIEND_AGREE;
						$myRep->objectid1 = $this->registry->me->id;
						$myRep->text = $this->registry->me->fullname;
						$repValue = $myRep->addData();
						if($repValue > 0)
						{
							$myRequestor->rep += $repValue;
							$myRequestor->updateRep();
						}
					}

					//create feed
					$myFeedFriendAdd = new Core_Backend_Feed_FriendAdd();
					$myFeedFriendAdd->uid = $this->registry->me->id;
					$myFeedFriendAdd->uidreceive = $friendid;
					$myFeedFriendAdd->addData();

					//create notification cho nguoi da goi loi moi ket ban
					$myNotificationFriendRequestAccept = new Core_Backend_Notification_FriendRequestAccept();
					$myNotificationFriendRequestAccept->uid = $this->registry->me->id;
					$myNotificationFriendRequestAccept->uidreceive = $friendid;
					if($myNotificationFriendRequestAccept->addData())
					{
						//increase notification count for receiver
						Core_User::notificationIncrease('notification', array($myNotificationFriendRequestAccept->uidreceive));
					}

					//update Date last action
					$this->registry->me->updateDateLastaction();

					//update homefeedids
					Core_Backend_Feed::cacheDeleteHomeFeedIds($this->registry->me->id);
					Core_Backend_Feed::cacheDeleteHomeFeedIds($friendid);

					//update friendids cache
					Core_Backend_Friend::cacheDeleteFriendIds($this->registry->me->id);
					Core_Backend_Friend::cacheDeleteFriendIds($friendid);
				}
				else
				{
					$message = $this->registry->lang['controller']['errAdd'];
				}
			}
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}

	/**
	* goi yeu cau ket ban thong qua ajax
	*
	*/
	function requestajaxAction()
	{
		$success = 0;
		$friendid = (int)$_GET['id'];

		if($this->registry->me->id == 0)
		{
			die('Login First');
		}

		//check nguoi nhan loi moi
		$myReceiver = new Core_User($friendid);

		//tinh tong so ban be cua minh
		$friendCount = Core_Backend_Friend::getFriends(array('fuserid' => $this->registry->me->id), '', '', '', true);


		//tinh tong so ban be cua nguoi nhan loi moi
		$receiverFriendCount = Core_Backend_Friend::getFriends(array('fuserid' => $friendid), '', '', '', true);

		if($friendid == $this->registry->me->id)
		{
			$message = $this->registry->lang['controller']['errFriendYourself'];
		}
		elseif($myReceiver->id == 0)
		{
			$message = $this->registry->lang['controller']['errFriendNotFound'];
		}
		elseif(Core_Backend_Friend::checkFriendship($this->registry->me->id, $friendid))
		{
			$message = str_replace('###VALUE###', $myReceiver->fullname,$this->registry->lang['controller']['errAlreadyFriend']);
		}
		elseif($friendCount >= $this->registry->me->settingMaxFriend)
		{
			//kiem tra so luong ban cua minh
			$message = str_replace('###VALUE###', $this->registry->me->settingMaxFriend,$this->registry->lang['controller']['errMaxFriendQuotaExceed']);
		}
		elseif($receiverFriendCount >= $myReceiver->settingMaxFriend)
		{
			$message = str_replace(array('###VALUE###', '###VALUE2###'), array($myReceiver->fullname, $myReceiver->settingMaxFriend), $this->registry->lang['controller']['errMaxFriendQuotaExceedRequestor']);
		}
		else
		{
			//check friend request
			$myRequestCount = Core_Backend_FriendRequest::getRequests(array('fuserid' => $this->registry->me->id, 'ffriendid' => $friendid), '', '', '', true);
			if($myRequestCount > 0)
			{
				$message = str_replace('###VALUE###', $myReceiver->fullname,$this->registry->lang['controller']['errRequestAlready']);
			}
			else
			{
				//kiem tra xem nguoi kia (friend) truoc day co goi yeu cau ket ban toi ME chua
				$friendRequestCount = Core_Backend_FriendRequest::getRequests(array('fuserid' => $friendid, 'ffriendid' => $this->registry->me->id), '', '', '', true);

				if($friendRequestCount > 0)
				{
					//redirect toi addfriend boi vi 2 ben da goi yeu cau qua lai tuc la ho co the tiep tuc ket ban
					$this->addajaxAction();
					exit();
				}
				else
				{
					//everything's normal
					//tien hanh luu thong tin request

					$myFriendRequest = new Core_Backend_FriendRequest();
					$myFriendRequest->uid = $this->registry->me->id;
					$myFriendRequest->uid_friend = $friendid;
					if($myFriendRequest->addData())
					{
						$success = 1;
						$message = str_replace('###VALUE###', $myReceiver->fullname,$this->registry->lang['controller']['succRequest']);

						//increase notification count for friendrequest
						Core_User::notificationIncrease('friendrequest', array($myReceiver->id));



						//////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////
						//	XY LY CHO RECOMMENDATION

						//update for recommendation system
						//remove from recommend friend list
						$myMutualfriend = new Core_Backend_Mutualfriend($this->registry->me->id);
						if($myMutualfriend->id > 0)
						{
							//kiem tra neu friendid nam trong danh sach mutualbook hoac mutualfriend thi updatedate
							if(isset($myMutualfriend->mutualbooklist[$friendid]) || isset($myMutualfriend->mutualfriendlist[$friendid]))
							{
								$myMutualfriend->removeFromList($friendid, 'mutualbook');
								$myMutualfriend->removeFromList($friendid, 'mutualfriend');
								if($myMutualfriend->updateData())
								{
									//delete cache
									Core_Backend_Mutualfriend::cacheDelete($this->registry->me->id);
								}
							}
						}

						//kiem tra va xoa khoi recommendation system cua nguoi nhan (boi vi ho cung co the co danh sach recommendation chung
						$myMutualfriendReceiver = new Core_Backend_Mutualfriend($friendid);
						if($myMutualfriendReceiver->id > 0)
						{
							//kiem tra neu myid nam trong danh sach mutualbook hoac mutualfriend cua friendid thi updatedate
							if(isset($myMutualfriendReceiver->mutualbooklist[$this->registry->me->id]) || isset($myMutualfriendReceiver->mutualfriendlist[$this->registry->me->id]))
							{
								$myMutualfriendReceiver->removeFromList($this->registry->me->id, 'mutualbook');
								$myMutualfriendReceiver->removeFromList($this->registry->me->id, 'mutualfriend');
								if($myMutualfriendReceiver->updateData())
								{
									//delete cache
									Core_Backend_Mutualfriend::cacheDelete($friendid);
								}
							}
						}
						//	KET THUC XU LY CHO RECOMMENDATION
						//////////////////////////////////////////////////////////////

						//goi email toi nguoi nhan
						$taskUrl = $this->registry->conf['rooturl'] . 'task/friendrequestsendemail';
						Helper::backgroundHttpPost($taskUrl, 'uid=' . $this->registry->me->id.'&uid_friend=' . $myReceiver->id);


					}
					else
					{
						$message = str_replace('###VALUE###', $myReceiver->fullname,$this->registry->lang['controller']['errRequest']);
					}
				}
			}
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}



	/**
	* Trang liet ke cac loi moi ket ban cua user
	*
	* Chi co nguoi chu moi xem duoc loi moi ket ban cua minh
	*/
	function requestAction()
	{
		if($this->registry->me->id != $this->registry->myUser->id)
		{
			$this->notfound();
		}

		$formData = array('ffriendid' => $this->registry->me->id);
		$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;



		//tim tong so record
		$total = Core_Backend_FriendRequest::getRequests($formData, '', '', '', true);
		$totalPage = ceil($total/$this->registry->setting['friend']['recordPerPage']);
		$curPage = $page;
		$paginateUrl = $this->registry->myUser->getUserPath().'/friend/request/';

		if($curPage != 1 && $curPage > $totalPage)
		{
			$this->notfound();
		}

		$requestList = Core_Backend_FriendRequest::getRequests($formData, '', '', (($page - 1)*$this->registry->setting['friend']['recordPerPage']).','.$this->registry->setting['friend']['recordPerPage']);


		$this->registry->smarty->assign(array('requestList' => $requestList,
											'formData'		=> $formData,
											'paginateurl' 	=> $paginateUrl,
											'paginatesuffix' 	=> $paginateSuffix,
											'total'			=> $total,
											'totalPage' 	=> $totalPage,
											'curPage'		=> $curPage
											));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'request.tpl');


		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitleRequest'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeywordRequest'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescriptionRequest'];


		if($curPage > 1)
		{
			$pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
			$pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
			$pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
		}

		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

	}



	/**
	* Trang liet ke cac loi moi ket ban moi nhat (thong qua notification cua user
	*
	* ajax version for bottombar
	*/
	function requestlistajaxAction()
	{
		//sleep(1);
		$formData = array('ffriendid' => $this->registry->me->id);


		$limit = $this->registry->me->newfriendrequest;

		if($limit > $this->registry->setting['notification']['bottomItemLimit'])
		{
			$limit = $this->registry->setting['notification']['bottomItemLimit'];
		}

		if($limit == 0)
			$limit = $this->registry->setting['notification']['minShow'];

		$requestList = Core_Backend_FriendRequest::getRequests($formData, '', '', $limit);

		if($this->registry->me->newfriendrequest > 0)
		{
			$this->registry->me->notificationReset('friendrequest');
		}

		$this->registry->smarty->assign(array('requestList' => $requestList,
											));

		header('Content-type: text/xml');
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'requestlistajax.tpl');
	}



	/**
	* Xoa 1 request khoi danh sach request
	*
	*/
	function deleterequestajaxAction()
	{
		$success = 0;
		$friendid = (int)$_GET['id'];

		//check friend request
		$friendRequest = Core_Backend_FriendRequest::getRequests(array('fuserid' => $friendid, 'ffriendid' => $this->registry->me->id), '', '', 1);
		if(count($friendRequest) == 0)
		{
			$message = $this->registry->lang['controller']['errRequestNotFound'];
		}
		else
		{
			if($friendRequest[0]->delete())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succDeleteRequest'];
			}
			else
			{
				$message = $this->registry->lang['controller']['errDeleteRequest'];
			}
		}


		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}

	/**
	* Lay cac ban be co hoat dong moi nhat
	*
	*
	*/
	public function lastactionajaxAction()
	{
		$formData = array();
		$formData['fuserid'] = $this->registry->myUser->id;

		if($_GET['from'] == 'home')
			$fetchLimit = 18;
		else
			$fetchLimit = 12;
		$friendList = Core_Backend_Friend::getFriends($formData, 'datelastaction', 'DESC', $fetchLimit);


		$this->registry->smarty->assign(array(	'friendList' => $friendList,
												));

		header ("content-type: text/xml");
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'lastactionajax.tpl');



	}

	/**
	* De xuat receipent cho contact To
	*
	*/
	function autocompleteajaxAction()
	{
		$keyword = Helper::xss_clean(strip_tags($_GET['tag']));
		$formData = array('fuserid' => $this->registry->me->id, 'fkeywordFilter' => $keyword);
		$friendList = Core_Backend_Friend::getFriends($formData, 'datelasaction', 'DESC', 5);
		$items = array();
		for($i = 0; $i < count($friendList); $i++)
		{
			$value = '<img src="'.$friendList[$i]->actor->getSmallImage().'" />' . $friendList[$i]->actor->fullname;
			$items[] = array('key' => $friendList[$i]->uid_friend, 'value' => $value);
		}

		echo json_encode($items);

	}
	####################################################################################################
	####################################################################################################
	####################################################################################################



}


