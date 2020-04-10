<?php

Class Controller_Profile_Blog Extends Controller_Profile_Base 
{
	/**
	* Liet ke tat ca blog entry cua user
	* 
	*/
	function indexAction()
	{
		$formData = $success = $error = array();
		
		$formData['fuserid'] = $this->registry->myUser->id;
		
		$_SESSION['securityToken'] = Helper::getSecurityToken();   //for delete link
		$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
		
		//tim tong so record
		$total = Core_Blog::getBlogs($formData, '', '', $this->registry->setting['blog']['recordPerPage'], true);
		$totalPage = ceil($total/$this->registry->setting['blog']['recordPerPage']);
		$curPage = $page;
		$paginateUrl = $this->registry->myUser->getUserPath() . '/'.$GLOBALS['controller'].'/';
		
		//process to limit page, prevent leech book data
		if($curPage != 1 && $curPage > $totalPage)
		{
			//go to last page
			header('location: ' . $paginateUrl . 'page-' . $totalPage);
			exit();
		}
		
		if($_GET['from'] == 'delete')
			$success[] = $this->registry->lang['controller']['succDelete'];
		elseif($_GET['from'] == 'delete_error')
			$error[] = $this->registry->lang['controller']['errDelete'];
		
		$blogList = Core_Blog::getBlogs($formData, '', '', (($page - 1)*$this->registry->setting['blog']['recordPerPage']).','.$this->registry->setting['blog']['recordPerPage']);
		
		
		//check sharemode if from other user
		if($this->registry->me->id != $this->registry->myUser->id)
		{
			for($i = 0, $cnt = count($blogList); $i < $cnt; $i++)
			{
				if(!$blogList[$i]->isAvailable($this->registry->me->id, $this->registry->userIsFriend))
					unset($blogList[$i]);
			}
		}
		
		$categoryList = Core_BlogCategory::getFullCategories();
		
		//get category
		foreach($blogList as $k => $blog)
		{
			if($blog->categoryid > 0 && isset($categoryList[$blog->categoryid]))
			{
				$blogList[$k]->category = $categoryList[$blog->categoryid];
				
			}
		}
		
		
		//track page view
		if($this->registry->me->id != $this->registry->myUser->id && $this->registry->myUser->increaseView(Core_UserView::TYPE_BLOG))
		{
			$myUserView = new Core_UserView();
			$myUserView->uid = $this->registry->me->id;
			$myUserView->uid_receiver = $this->registry->myUser->id;
			$myUserView->type = Core_UserView::TYPE_BLOG;
			$myUserView->addData();
		}
		
		$this->registry->smarty->assign(array('blogList' => $blogList,
											'formData'		=> $formData,
											'success'		=> $success,
											'error'			=> $error,
											'paginateurl' 	=> $paginateUrl, 
											'paginatesuffix' 	=> $paginateSuffix, 
											'redirectUrl'	=> base64_encode(Helper::curPageURL()),
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
	
	function detailAction()
	{
		$blogid = (int)$_GET['blogid'];
	    $myBlog = new Core_Blog($blogid);
	    
	    if($myBlog->id == 0 || ($this->registry->me->id != $this->registry->myUser->id && !$myBlog->isAvailable($this->registry->me->id, $this->registry->userIsFriend)))
		    $this->notfound();
	    else
	    {
	    	if($myBlog->checkValidRequest($_GET['blogid_requeststring']) && $myBlog->uid == $this->registry->myUser->id)
	    	{
	    		//increase blog view
	    		$myBlog->increaseView();
	    		
								
				$_SESSION['securityToken'] = Helper::getSecurityToken();   //for delete link
				
				if($_GET['from'] == 'add')
					$success[] = $this->registry->lang['controller']['succAdd'];
				elseif($_GET['from'] == 'edit')
					$success[] = $this->registry->lang['controller']['succEdit'];
				
				//kiem tra trong bookmetadata de xem co can show disable notification ko
				$myBlogMetadata = new Core_BlogMetadata($myBlog->id);
				if($myBlogMetadata->id > 0)
					$showBlogfollowDisable = (int)$myBlogMetadata->checkExistedUser($this->registry->me->id);
					
				//array of book object tagged in this blog by blogger
				$tagbookList = array();
				for($i = 0; $i < count($myBlog->bookidList); $i++)
				{
					if($myBlog->bookidList[$i] > 0)
						$tagbookList[] = new Core_Book($myBlog->bookidList[$i], true);	
				}
				
				$this->registry->smarty->assign(array('myBlog' => $myBlog,
													'success'	=> $success,
													'error'		=> $error,
													'tagbookList' => $tagbookList,
													'showBlogfollowDisable' => $showBlogfollowDisable,
													'redirectUrl' => base64_encode($myBlog->getBlogPath()),
													));
				
				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl'); 
				
				$this->registry->smarty->assign(array('contents' => $contents,
													'pageTitle' => $myBlog->title,
													'pageKeyword' => $myBlog->title,
													'pageDescription' => Helper::truncateperiod($myBlog->contents, 200, '..'),
													'pageThumbnail' => $myBlog->getSmallImage(),
													
													));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');  	
			}
			else
			    header('location: ' . $myBlog->getBlogPath());
		}
		
	}
	
	function editAction()
	{
		$blogid = (int)$_GET['id'];
	    $myBlog = new Core_Blog($blogid);
	    
	    $poster = $this->registry->me;
		if($this->registry->myUser->ispage() && $this->registry->myPage->isadmin())
		{
			$poster = $this->registry->myUser;
		}
		
	    if($myBlog->id > 0 && $myBlog->uid == $poster->id)
	    {
	    	$formData = $error = array();
	    	$allowFriendlist = array();
	    	$denyFriendlist = array();
	    	$tagbookList = array();
			
			$formData['fcategoryid'] = $myBlog->categoryid;
			$formData['fshowinhomepage'] = $myBlog->showinhomepage;
			$formData['fsourceurl'] = $myBlog->sourceurl;
			$formData['ftitle'] = $myBlog->title;
			$formData['fcontents'] = $myBlog->contents;
			$formData['fsharemode'] = $myBlog->sharemode;
			$formData['fimageintext'] = $myBlog->imageintext;
			$formData['fopencomment'] = $myBlog->opencomment;
			
			//neu submit co loi, thi tien hanh get them cac userdetail cho danh sach allow/deny
			for($i = 0; $i < count($myBlog->shareallow); $i++)
			{
				if($myBlog->shareallow[$i] > 0)
					$allowFriendlist[] = new Core_User($myBlog->shareallow[$i], true);
			}
				
			for($i = 0; $i < count($myBlog->sharedeny); $i++)
			{
				if($myBlog->sharedeny[$i] > 0)
					$denyFriendlist[] = new Core_User($myBlog->sharedeny[$i], true);
			}
			
			for($i = 0; $i < count($myBlog->bookidList); $i++)
			{
				if($myBlog->bookidList[$i] > 0)
					$tagbookList[] = new Core_Book($myBlog->bookidList[$i], true);	
			}
				
			if(isset($_POST['fsubmit']))
			{
				$formData = $_POST;
				array_walk($formData, 'trim');
				
				//siable sharemode detail on allow and deny, tagbook
				if(SUBDOMAIN != 'm')
				{
					if($formData['fsharemode'] == Core_Blog::SHAREMODE_CUSTOM && is_array($formData['fshareallow']))
					{
						foreach($formData['fshareallow'] as $friendid)
						{
							if(!in_array($friendid, $allowFriendlistId) && $friendid > 0)
								$allowFriendlistId[] = $friendid;
						}
					}
					elseif($formData['fsharemode'] == Core_Blog::SHAREMODE_FRIEND && is_array($formData['fsharedeny']))
					{
						foreach($formData['fsharedeny'] as $friendid)
						{
							if(!in_array($friendid, $denyFriendlistId) && $friendid > 0)
								$denyFriendlistId[] = $friendid;
						}
					}

					$tagbookListId = array();
					foreach($formData['ftagbook'] as $tagbookid)
					{
						if(!in_array($tagbookid, $tagbookListId) && $tagbookid > 0)
							$tagbookListId[] = $tagbookid;
					}
				}
				
				
				if($this->editValidator($formData, $error))
				{
					
					$myBlog->title = htmlspecialchars($formData['ftitle']);
					$myBlog->contents = Helper::xss_clean($formData['fcontents']);
					$myBlog->sharemode = $formData['fsharemode'];
					$myBlog->shareallow = $allowFriendlistId;
					$myBlog->sharedeny = $denyFriendlistId;
					$myBlog->imageintext = $formData['fimageintext'] == '1' ? 1 : 0;
					$myBlog->opencomment = $formData['fopencomment'] == '1' ? 1 : 0;
					$myBlog->categoryid = $formData['fcategoryid'];
					$myBlog->showinhomepage = $formData['fshowinhomepage'];
					$myBlog->sourceurl = $formData['fsourceurl'];
				
					if(isset($_POST['fdeleteimage']) && $_POST['fdeleteimage'] == '1')
					{
						$myBlog->deleteImage();
					}
					
					if($myBlog->updateData())
					{
						////////////////////////////////////////////////////////////
						//process tagbook
						$myRelBlogBook = new Core_RelBlogBook();
						$myRelBlogBook->blog = $myBlog;
						$myRelBlogBook->bookIdList = $tagbookListId;
						$myRelBlogBook->updateData();
						
						
						header('location: ' . $myBlog->getBlogPath() . '?from=edit');
						exit();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
				else
				{
					//neu submit co loi, thi tien hanh get them cac userdetail cho danh sach allow/deny
					for($i = 0; $i < count($allowFriendlistId); $i++)
						$allowFriendlist[] = new Core_User($allowFriendlistId[$i], true);
						
					for($i = 0; $i < count($denyFriendlistId); $i++)
						$denyFriendlist[] = new Core_User($denyFriendlistId[$i], true);
						
					for($i = 0; $i < count($tagbookListId); $i++)
						$tagbookList[] = new Core_Book($tagbookListId[$i], true);
				}
				
			}
			
			//SEO PREPARE
			$pageTitle = $poster->fullname . $this->registry->lang['controller']['pageTitleEdit'];;
			$pageKeyword = $poster->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
			$pageDescription = $poster->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'myBlog'	=> $myBlog,
													'categoryList' => Core_BlogCategory::getFullCategories(),
													'allowFriendlist' => $allowFriendlist,
													'denyFriendlist' => $denyFriendlist,
													'tagbookList' => $tagbookList,
													'error' 	=> $error,
													));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl'); 
			$this->registry->smarty->assign(array('contents' => $contents,
												'pageTitle' => $pageTitle,
												'pageKeyword' => $pageKeyword,
												'pageDescription' => $pageDescription,
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		}
		else
		    $this->notfound();
	}
	
	function addAction() 
	{
		$formData = $error = array();
		$allowFriendlist = array();
		$denyFriendlist = array();
		
		///////////////////////
		//detect BlogEvent
		$blogeventid = $_GET['id'];
		$myBlogEvent = new Core_BlogEvent();
		if($blogeventid > 0)
		{
			$myBlogEvent->getData($blogeventid);
			if($myBlogEvent->id > 0)
			{
				//check xem user nay da goi blog vao event nay chua, de redirect
				$blogEventBlogList = Core_BlogEventBlog::getBlogEventBlogs(array('fuid' => $this->registry->me->id, 'fbeid' => $myBlogEvent->id), '', '', 1);
				if(count($blogEventBlogList) > 0)
				{
					//exist, redirect to edit page
					$redirectUrl = $this->registry->me->getUserPath() . '/blog/edit/' . $blogEventBlogList[0]->bid . '/event/' . $myBlogEvent->id;
					$redirectMsg = $this->registry->lang['controller']['errBlogEventExistedRedirect'];
					
					$this->registry->smarty->assign(array(
						'redirect' => $redirectUrl,
						'redirectMsg' => $redirectMsg,
					));
					$this->registry->smarty->display('redirect.tpl');
					exit();
				}
			}
			else
			{
				$this->notfound();
			}
		}
		
		//end detect BlogEvent
		/////////////////////////
		
		$formData['fimageintext'] = 1;
		$formData['fopencomment'] = 1;
		
		if(isset($_POST['fsubmit']))
		{
			$formData = $_POST;
			array_walk($formData, 'trim');
			
			$allowFriendlistId = array();
			$denyFriendlistId = array();
			$tagbookListId = array();
			
			if($formData['fsharemode'] == Core_Blog::SHAREMODE_CUSTOM && is_array($formData['fshareallow']))
			{
				foreach($formData['fshareallow'] as $friendid)
				{
					if(!in_array($friendid, $allowFriendlistId) && $friendid > 0)
						$allowFriendlistId[] = $friendid;
				}
			}
			elseif($formData['fsharemode'] == Core_Blog::SHAREMODE_FRIEND && is_array($formData['fsharedeny']))
			{
				foreach($formData['fsharedeny'] as $friendid)
				{
					if(!in_array($friendid, $denyFriendlistId) && $friendid > 0)
						$denyFriendlistId[] = $friendid;
				}
			}
			
			foreach($formData['ftagbook'] as $tagbookid)
			{
				if(!in_array($tagbookid, $tagbookListId) && $tagbookid > 0)
					$tagbookListId[] = $tagbookid;
			}
			
			if($this->addValidator($formData, $error))
			{
				$poster = $this->registry->me;
				if($this->registry->myUser->ispage() && $this->registry->myPage->isadmin())
				{
					$poster = $this->registry->myUser;
				}
				
				$myBlog = new Core_Blog();
				$myBlog->uid = $poster->id;
				$myBlog->title = htmlspecialchars($formData['ftitle']);
				$myBlog->contents = Helper::xss_clean($formData['fcontents']);
				$myBlog->categoryid = 0;
				$myBlog->actor = $poster;
				$myBlog->sharemode = $formData['fsharemode'];
				$myBlog->shareallow = $allowFriendlistId;
				$myBlog->sharedeny = $denyFriendlistId;
				$myBlog->imageintext = $formData['fimageintext'] == '1' ? 1 : 0;
				$myBlog->opencomment = $formData['fopencomment'] == '1' ? 1 : 0;
				$myBlog->categoryid = $formData['fcategoryid'];
				$myBlog->showinhomepage = $formData['fshowinhomepage'];
				$myBlog->sourceurl = $formData['fsourceurl'];
				
				if($myBlog->addData())
				{
					$_SESSION['blogSpam'] = time();
					$_SESSION['previousBlog'] = $formData['ftitle'];
					
					//xu ly them REP neu hop le
					if(!$this->registry->myUser->ispage() && Core_Rep::canAdd($myBlog->uid, Core_Rep::TYPE_BLOG_ADD))
					{
						$myRep = new Core_Rep();
						$myRep->uid = $myBlog->uid;
						$myRep->uidtrigger = $myBlog->uid;
						$myRep->type = Core_Rep::TYPE_BLOG_ADD;
						$myRep->objectid1 = $myBlog->id;
						$myRep->text = $myBlog->title;
						$repValue = $myRep->addData();
						if($repValue > 0)
						{
							$this->registry->me->rep += $repValue;
						}
					}
					
					//create feed if public - everyone blog
					if($myBlog->sharemode == Core_Blog::SHAREMODE_EVERYONE)
					{
						$myFeedBlogAdd = new Core_Backend_Feed_BlogAdd();
						$myFeedBlogAdd->uid = $myBlog->uid;
						$myFeedBlogAdd->blogtitle = $myBlog->title;
						$myFeedBlogAdd->blogurl = $myBlog->getBlogPath();
						$myFeedBlogAdd->blogsummary = Helper::truncateperiod(strip_tags($formData['fcontents']), 150, '...', '.');
						$myFeedBlogAdd->addData();	
					}
					
					
					//update counting
					$poster->updateCounting(array('blog'));
					
					//increase notification counter for fanpage if write on fanpage
					if($this->registry->myUser->ispage())
					{
						//use task to reduce traffic
						$taskUrl = $this->registry->conf['rooturl'] . 'task/pagenotification';
						Helper::backgroundHttpPost($taskUrl, 'pageid=' . $this->registry->myUser->id.'&excludeid=' . $this->registry->me->id);
					}
					
					//add tagbook
					if(!empty($formData['ftagbook']))
					{
						$tagbookidList = array();
						foreach($formData['ftagbook'] as $bookid)
						{
							if($bookid > 0)
								$tagbookidList[] = $bookid;
						}
						if(count($tagbookidList) > 0)
						{
							$myRelBlogBook = new Core_RelBlogBook();
							$myRelBlogBook->blog = $myBlog;
							$myRelBlogBook->bookIdList = $tagbookidList;
							$myRelBlogBook->addData();
						}
					}
					
					/////////////////
					// This is a blog event
					if($myBlogEvent->id > 0)
					{
						$myBlogEventBlog = new Core_BlogEventBlog();
						$myBlogEventBlog->uid = $this->registry->me->id;
						$myBlogEventBlog->beid = $myBlogEvent->id;
						$myBlogEventBlog->bid = $myBlog->id;
						$myBlogEventBlog->status = Core_BlogEventBlog::STATUS_ACCEPTED;
						$myBlogEventBlog->addData();
					}
					/////////////////
					
					header('location: ' . $myBlog->getBlogPath() . '?from=add');
					exit();
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errAdd'];
				}
			}
			else
			{
				//neu submit co loi, thi tien hanh get them cac userdetail cho danh sach allow/deny
				for($i = 0; $i < count($allowFriendlistId); $i++)
					$allowFriendlist[] = Core_User::cacheGet($allowFriendlistId[$i]);
					
				for($i = 0; $i < count($denyFriendlistId); $i++)
					$denyFriendlist[] = Core_User::cacheGet($denyFriendlistId[$i]);
					
				for($i = 0; $i < count($tagbookListId); $i++)
					$tagbookList[] = new Core_Book($tagbookListId[$i], true);
			}
			
		}
		elseif(isset($_GET['article']))
		{
			$formData['fshowinhomepage'] = 1;
		}
		
		//SEO PREPARE
		$pageTitle = $this->registry->me->fullname . $this->registry->lang['controller']['pageTitleAdd'];;
		$pageKeyword = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageKeywordAdd'];
		$pageDescription = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageDescriptionAdd'];
		
		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'myBlogEvent' => $myBlogEvent,
												'allowFriendlist' => $allowFriendlist,
												'denyFriendlist' => $denyFriendlist,
												'tagbookList' => $tagbookList,
												'categoryList' => Core_BlogCategory::getFullCategories(),
												'error' 	=> $error,
												'redirectUrl' 	=> $redirectUrl
												));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
	} 
	
	function deleteAction()
	{
		$success = $error = array();
		
		$redirectUrlOnError = $_GET['redirect'];
		if($redirectUrlOnError != '')
			$redirectUrlOnError = base64_decode($redirectUrlOnError);
		else
			$redirectUrlOnError = $this->registry->me->getUserPath() . '/' . $GLOBALS['controller'];
		
		$poster = $this->registry->me;
		if($this->registry->myUser->ispage() && $this->registry->myPage->isadmin())
		{
			$poster = $this->registry->myUser;
		}
		
		
		$blogid = (int)$_GET['id'];
	    $myBlog = new Core_Blog($blogid);
	    if($myBlog->id > 0 && $myBlog->uid == $poster->id)
	    {
	    	//check general security token
			if(Helper::checkSecurityToken())
			{
				if($myBlog->delete())
				{
					//update counting
					$poster->updateCounting(array('blog'));
					
					header('location: ' . $poster->getUserPath() . '/'.$GLOBALS['controller'].'?from=delete');
				}
				else
				{
					header('location: ' . $redirectUrlOnError . '?from=delete_error');
				}      
			}
			else
				$this->notfound();
		}
		else
		    $this->notfound();
		
	}
	
	/**
	* Xoa userid khoi danh sach follow
	* 
	*/
	public function disablefollowajaxAction()
	{
		$success = 0;
		$message = '';
		
		if($this->registry->me->id > 0)
		{
			$myBlog = new Core_Blog((int)$_GET['id']);
			if($myBlog->id > 0)
			{
				$myBlogMetadata = new Core_BlogMetadata($myBlog->id);
				if($myBlogMetadata->id > 0 && $myBlogMetadata->checkExistedUser($this->registry->me->id))
				{
					$myBlogMetadata->removeFromList($this->registry->me->id, 'all');
					if($myBlogMetadata->updateData())
					{
						$success = 1;
						$message = $this->registry->lang['controller']['succDisableNotification'];
					}
					else
						$message = $this->registry->lang['controller']['errDisableNotification'];
				}
				else
					$message = 'Data not found.';
			}
			else
			{
				$message = 'Blog not found.';
			}
		}
		else
		{
			$message = 'Login required.';
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
		
		
	/**
	* Lay cac blog moi duoc using cho trang user
	* 
	* 
	*/
	public function latestajaxAction()
	{
		$formData = array();
		$formData['fuserid'] = $this->registry->myUser->id;
		
		$blogList = Core_Blog::getBlogs($formData, 'id', 'DESC', $this->registry->setting['blog']['sidebarQuantity'], false);
		
		//check sharemode if from other user
		if($this->registry->me->id != $this->registry->myUser->id)
		{
			for($i = 0, $cnt = count($blogList); $i < $cnt; $i++)
			{
				if(!$blogList[$i]->isAvailable($this->registry->me->id, $this->registry->userIsFriend))
					unset($blogList[$i]);
			}
		}
		
		$this->registry->smarty->assign(array(	'blogList' => $blogList,
												));
		
		header ("content-type: text/xml");
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'latestajax.tpl'); 
		
		
		
	}
	###########################################################
	###########################################################
	###########################################################
	public function addValidator($formData, &$error)
	{
		$pass = true;
		
		//check page article add
		if($this->registry->myUser->ispage() && !$this->registry->myPage->isadmin())
		{
			$error[] = $this->registry->lang['controller']['errPageAdminOnly'];
			$pass = false;
		}
		
		//check file upload
		if(strlen($_FILES['fimage']['name']) > 0)
	    {
	    	$extPart = strtoupper(substr(strrchr($_FILES['fimage']['name'],'.'),1));
	    	if(!in_array($extPart, $this->registry->setting['blog']['imageValidType']))
	    	{
	    		$pass = false;
				$error[] = $this->registry->lang['controller']['errImageExtensionInvalid'];
			}
			elseif($_FILES['fimage']['size'] > $this->registry->setting['blog']['imageMaxFileSize'])
			{
				$pass = false;
				$error[] = $this->registry->lang['controller']['errImageMaxFileSize'];
			}
		}
		
		if($formData['ftitle'] == '')
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errTitleEmpty'];
		}
		
		$strlen = mb_strlen($formData['fcontents'], 'utf-8');
		if($strlen < $this->registry->setting['blog']['messageMinLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['blog']['messageMinLength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}
		
		if($strlen > $this->registry->setting['blog']['messageMaxLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['blog']['messageMaxLength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}
		
		if($strlen > 0 && strcmp($formData['ftitle'], $_SESSION['previousBlog']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errDuplicate'];
		}
		
		//check spam
		if(isset($_SESSION['blogSpam']) && $_SESSION['blogSpam'] + $this->registry->setting['blog']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}
		
		//check sharemode
		$sharemodValid = array(Core_Blog::SHAREMODE_EVERYONE, Core_Blog::SHAREMODE_FRIEND, Core_Blog::SHAREMODE_PRIVATE, Core_Blog::SHAREMODE_CUSTOM);
		if(!in_array($formData['fsharemode'], $sharemodValid))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSharemode'];
		}
		elseif($formData['fsharemode'] == Core_Blog::SHAREMODE_CUSTOM && !is_array($formData['fshareallow']))
		{
			//check allow list in custome
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSharemodeCustom'];
		}
		
		return $pass;
	}
	
	
	public function editValidator($formData, &$error)
	{
		$pass = true;
		//check page article add
		if($this->registry->myUser->ispage() && !$this->registry->myPage->isadmin())
		{
			$error[] = $this->registry->lang['controller']['errPageAdminOnly'];
			$pass = false;
		}
		
		
		//check file upload
		if(strlen($_FILES['fimage']['name']) > 0)
	    {
	    	$extPart = strtoupper(substr(strrchr($_FILES['fimage']['name'],'.'),1));
	    	if(!in_array($extPart, $this->registry->setting['blog']['imageValidType']))
	    	{
	    		$pass = false;
				$error[] = $this->registry->lang['controller']['errImageExtensionInvalid'];
			}
			elseif($_FILES['fimage']['size'] > $this->registry->setting['blog']['imageMaxFileSize'])
			{
				$pass = false;
				$error[] = $this->registry->lang['controller']['errImageMaxFileSize'];
			}
		}
		
		if($formData['ftitle'] == '')
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errTitleEmpty'];
		}
		
		$strlen = mb_strlen($formData['fcontents'], 'utf-8');
		if($strlen < $this->registry->setting['blog']['messageMinLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['blog']['messageMinLength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}
		
		if($strlen > $this->registry->setting['blog']['messageMaxLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['blog']['messageMaxLength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}
		
		//check sharemode
		$sharemodValid = array(Core_Blog::SHAREMODE_EVERYONE, Core_Blog::SHAREMODE_FRIEND, Core_Blog::SHAREMODE_PRIVATE, Core_Blog::SHAREMODE_CUSTOM);
		if(!in_array($formData['fsharemode'], $sharemodValid))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSharemode'];
		}
		elseif($formData['fsharemode'] == Core_Blog::SHAREMODE_CUSTOM && !is_array($formData['fshareallow']))
		{
			//check allow list in custome
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSharemodeCustom'];
		}
				
		return $pass;
	}
	
	
	
	public function getBlogCreatorId(Core_Blog $myBlog)
	{
		$uid = 0;
		if($this->registry->myUser->ispage() && $this->registry->me->id == $this->registry->myPage->uid_creator && $this->registry->me->id == $this->registry->myUser->id)
		{
			$uid = $this->registry->myUser->id;
		}
		elseif($this->registry->me->id == $this->registry->myUser->id)
		{
			$uid = $this->registry->myUser->id;
		}
		
		
		return $uid;
	}
}


