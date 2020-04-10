<?php

Class Controller_Profile_Notification Extends Controller_Profile_Base 
{
	protected $recordPerPage = 30;
	
	function indexAction() 
	{
		
		//check main user or fanpage user
		$poster = $this->registry->me;
		
		$formData = array('freceiverid' => $poster->id);
		$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
		
		//tim tong so record
		$total = Core_Backend_Notification::getNotifications($formData, '', '', '', true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		$paginateUrl = $this->registry->myUser->getUserPath().'/notification/';
		
		//process to limit page, prevent leech book data
		if($curPage != 1 && $curPage > $totalPage)
		{
			$this->notfound();
		}
		
		$notificationList = Core_Backend_Notification::getNotifications($formData, '', '', (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		
		///////////////////////////////////////
		///////////////////////////////////////
		//xu ly nang cao
		//thuat toan: combine cac notification giong nhau de tro thanh 1 notification combine
		$finalNotificationList = array();
		
		
		for($i = 0; $i < count($notificationList); $i++)
		{
			//dieu kien de gom nhom notification
			$idHash = $notificationList[$i]->getIdHash();
			
			if(isset($finalNotificationList[$idHash]))
			{
				//grouping notification
				//neu day la notification thu 2 trung, thi khoi tao danh sach actorList 
				//de bao hieu bat dau grouping
				if($finalNotificationList[$idHash]->actorList == null)
				{
					$finalNotificationList[$idHash]->actorList = array($finalNotificationList[$idHash]->actor);
				}
				
				$finalNotificationList[$idHash]->actorList[] = $notificationList[$i]->actor;
			}
			else
			{
				$finalNotificationList[$idHash] = $notificationList[$i];
			}
			
			
		}
		
		
		//end
		////////////////////////////////////////
		////////////////////////////////////////
		
		$notificationGroups = array();
		foreach($finalNotificationList as $notification)
		{
			$notifieddate = date('d/m/Y', $notification->datecreated);
			
			if($notifieddate == date('d/m/Y'))
			{
				$notifieddate = $this->registry->lang['controller']['dategroupToday'];
			}
			elseif($notifieddate == date('d/m/Y', strtotime('-1 day')))
			{
				$notifieddate = $this->registry->lang['controller']['dategroupYesterday'];
			}
			
			$notificationGroups[$notifieddate][] = $notification;
		}
		
		
		$this->registry->smarty->assign(array('notificationGroups' => $notificationGroups,
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
	* lay cac notification cua user
	* 
	*/
	function indexajaxAction()
	{
		//check main user or fanpage user
		$poster = $this->registry->me;
		
		//$formData = array('freceiverid' => $this->registry->me->id, 'funread' => 1);
		$formData = array('freceiverid' => $poster->id);
		         		
		$limit = $poster->newnotification;
		
		if($limit > $this->registry->setting['notification']['bottomItemLimit'])
		{
			$limit = $this->registry->setting['notification']['bottomItemLimit'];
			$formData['funread'] = 1;
		}
		
		
		
		
		$needUpdateReadStatus = true;
		if($limit == 0)
		{
			$needUpdateReadStatus = false;
			$limit = $this->registry->setting['notification']['minShow'];
			$notificationList = Core_Backend_Notification::cacheGetNotificationList($poster->id, $cachesuccess, false, $formData, $limit);
			//$notificationList = Core_Backend_Notification::getNotifications($formData, '', '', $limit);
			
		}
		else
		{
			$formData['funread'] = 1;
			
			
			//force true to get new cache
			$notificationList = Core_Backend_Notification::cacheGetNotificationList($poster->id, $cachesuccess, true, $formData, $limit);
			//$notificationList = Core_Backend_Notification::getNotifications($formData, '', '', $limit);
			
		}
		
		          		
		
		
		if(count($notificationList) > 0)
		{
			if($needUpdateReadStatus)
			{
				//this is slow
				//update notification item to have-read status
				Core_Backend_Notification::updateReadStatus($poster->id);
			}
			
			
			///////////////////////////////////////
			///////////////////////////////////////
			//xu ly nang cao
			//thuat toan: combine cac notification giong nhau de tro thanh 1 notification combine
			$finalNotificationList = array();
			
			
			for($i = 0; $i < count($notificationList); $i++)
			{
				//dieu kien de gom nhom notification
				$idHash = $notificationList[$i]->getIdHash();
				
				if(isset($finalNotificationList[$idHash]))
				{
					//grouping notification
					//neu day la notification thu 2 trung, thi khoi tao danh sach actorList 
					//de bao hieu bat dau grouping
					if($finalNotificationList[$idHash]->actorList == null)
					{
						$finalNotificationList[$idHash]->actorList = array($finalNotificationList[$idHash]->actor);
					}
					
					$finalNotificationList[$idHash]->actorList[] = $notificationList[$i]->actor;
				}
				else
				{
					$finalNotificationList[$idHash] = $notificationList[$i];
				}
				
				
			}
			
			//end
			////////////////////////////////////////
			////////////////////////////////////////
			
		}
		
		//echo '<pre>';
		//print_r($finalNotificationList);
		//exit();
		if($poster->newnotification > 0)
		{
			$poster->notificationReset('notification');
		}
		
		$this->registry->smarty->assign(array('notificationList' => $finalNotificationList,
											));
		
		header('Content-type: text/xml');
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');
		
	}
	
	
	function refreshajaxAction()
	{
		//keep online connection
		Core_UserOnline::setonline($this->registry->me->id);
		
		header('Content-type: text/xml');
		$_SESSION['lastrefreshtime'] = time();
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'refreshajax.tpl'); 
	}
	
		
	###########################################################3
	###########################################################3
	###########################################################3 

	
}

