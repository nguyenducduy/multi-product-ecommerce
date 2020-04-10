<?php

Class Controller_Crm_User Extends Controller_Crm_Base
{
	public $recordPerPage = 20;

	public function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());

		$_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

		$exceptid 		= (int)$this->registry->router->getArg('exceptid');
		$idFilter 		= (int)($this->registry->router->getArg('id'));
		$groupidFilter 		= (int)($this->registry->router->getArg('groupid'));
		$keywordFilter 	= $this->registry->router->getArg('keyword');
		$searchKeywordIn= $this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
			if(!isset($_POST['fbulkid']))
			{
				$warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
			}
			else
			{
				$formData['fbulkid'] = $_POST['fbulkid'];

				//check for delete
				if($_POST['fbulkaction'] == 'delete')
				{
					$delArr = $_POST['fbulkid'];
					$deletedItems = array();
					$cannotDeletedItems = array();
					foreach($delArr as $id)
					{
						//check valid user and not admin user
						$myUser = new Core_User($id);

						if($myUser->id > 0)
						{
							//tien hanh xoa
							if($myUser->delete())
							{
								$deletedItems[] = $myUser->email;
								$this->registry->me->writelog('user_delete', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname, 'dateregister' => date('H:i:s d/m/Y', $myUser->datecreated)));
							}
							else
								$cannotDeletedItems[] = $myUser->email;
						}
						else
							$cannotDeletedItems[] = $myUser->email;
					}

					if(count($deletedItems) > 0)
						$success[] = str_replace('###email###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

					if(count($cannotDeletedItems) > 0)
						$error[] = str_replace('###email###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
				}
				else
				{
					//bulk action not select, show error
					$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
				}
			}
		}



		$paginateUrl = $this->registry->conf['rooturl_admin'].'user/index/';

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if($groupidFilter > 0)
		{
			$paginateUrl .= 'groupid/'.$groupidFilter . '/';
			$formData['fgroupid'] = $groupidFilter;
			$formData['search'] = 'groupid';
		}


		if(strlen($keywordFilter) > 0)
		{

			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'screenname')
			{
				$paginateUrl .= 'searchin/screenname/';
			}
			else if($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			else if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_User::getUsers($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$users = Core_User::getUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'users' 		=> $users,
												'formData'		=> $formData,
												'userGroups' => Core_User::getGroupnameList(),
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'menu'		=> 'userlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myUser = new Core_User($id);


		if($myUser->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myUser->delete())
				{
					$redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('user_delete', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname, 'dateregister' => date('H:i:s d/m/Y', $myUser->datecreated)));
				}
				else
				{
					$redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['errDelete']);
				}
			}
			else
				$redirectMsg = $this->registry->lang['default']['errFormTokenInvalid'];


		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}

		$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												'redirectMsg' => $redirectMsg,
												));
		$this->registry->smarty->display('redirect.tpl');
	}

	function addAction()
    {
        $error     = array();
        $success     = array();
        $contents     = '';
        $formData     = array();

        if(!empty($_POST['fsubmit']))
        {
        	//kiem tra token
			if($_SESSION['userAddToken']==$_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);

				//kiem tra du lieu nhap
				if($this->addActionValidator($formData, $error))
				{
					$myUser = new Core_User();
					$myUser->groupid = $formData['fgroupid'];
					$myUser->email = $formData['femail'];
					$myUser->password = viephpHashing::hash($formData['fpassword']);
					$myUser->fullname = $formData['ffullname'];

					if($myUser->addData() > 0)
					{
						$success[] = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['succAdd']);
						$this->registry->me->writelog('user_add', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname));
						$formData = array('fgroupid' => $formData['fgroupid']);
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}
        }

        $_SESSION['userAddToken'] = Helper::getSecurityToken();  //them token moi


        $this->registry->smarty->assign(array(  'formData'         => $formData,
                                                'redirectUrl'    => $this->getRedirectUrl(),
                                                'userGroups' => Core_User::getGroupnameList(),
                                                'error'            => $error,
                                                'success'        => $success,

                                                ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');

        $this->registry->smarty->assign(array(    'menu'        => 'useradd',
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_add'],
                                                'contents'     => $contents));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    function editAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myUser = new Core_User($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myUser->id > 0)
        {
            //check priviledge priority
            //Yeu cau de edit:
            // 1. Hoac la admin
            // 2. Hoac la edit ban than, dung cho moderator, judge...
            // 3. Hoac la co priority number < priority number cua user duoc edit
            if($this->registry->me->groupid == GROUPID_ADMIN || $this->registry->me->id == $myUser->id )
            {
            	$error         = array();
	            $success     = array();
	            $contents     = '';
	            $formData     = array();

	            $formData['fgroupid'] = $myUser->groupid;
	            $formData['femail'] = $myUser->email;
	            $formData['ffullname'] = $myUser->fullname;
	            $formData['fscreenname'] = $formData['fscreennamecurrent'] = $myUser->screenname;
	            $formData['fgender'] = $myUser->gender;
	            $formData['fbirthday'] = $myUser->birthday;
	            $formData['fphone'] = $myUser->phone;
	            $formData['faddress'] = $myUser->address;
	            $formData['fregion'] = $myUser->region;
	            $formData['fcountry'] = $myUser->country;
	            $formData['fwebsite'] = $myUser->website;
	            $formData['fbio'] = $myUser->bio;
	            if(trim($myUser->favouriteCategory) != '')
	            	$formData['fcategory'] = explode(',', $myUser->favouriteCategory);
	            else
	            	$formData['fcategory'] = array();
	            $formData['fstaticshelves'] = Core_Shelf::getStaticShelves();


	            if(!empty($_POST['fsubmitnotificationuser']))
				{
					//create notification cho seller
					$myNotificationUserActivated = new Core_Backend_Notification_UserActivatedNotify();
					$myNotificationUserActivated->uid = $this->registry->me->id;
					$myNotificationUserActivated->uidreceive = $myUser->id;
					if($myNotificationUserActivated->addData())
					{
						//increase notification count for receiver
						Core_User::notificationIncrease('notification', array($myUser->id));

						$success[] = 'Notify OK';
					}
					else
					{
						$error[] =  'Notify Error';
					}
				}


	            if(!empty($_POST['fsubmit']))
	            {
	                if($_SESSION['userEditToken']==$_POST['ftoken'])
	                {
	                    $formData = array_merge($formData, $_POST);

	                    //kiem tra du lieu nhap
	                    if($this->editActionValidator($formData, $error))
	                    {
							$myUser->gender = $formData['fgender'];
							$myUser->birthday = $formData['fbirthday'];
							$myUser->phone = $formData['fphone'];
							$myUser->address = $formData['faddress'];
							$myUser->region = $formData['fregion'];
							$myUser->country = $formData['fcountry'];
							$myUser->website = $formData['fwebsite'];
							$myUser->bio = $formData['fbio'];
							if(is_array($formData['fcategory']))
							{
								$myUser->favouriteCategory = implode(',', $formData['fcategory']);
							}

	                        if(isset($_POST['fdeleteimage']) && $_POST['fdeleteimage'] == '1')
							{
								$myUser->deleteImage();
							}

	                        if($myUser->updateData(array('fullname' => $formData['ffullname'], 'screenname' => $formData['fscreenname'], 'groupid' => $formData['fgroupid'])))
	                        {
	                           $success[] = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['succEdit']);
	                           $this->registry->me->writelog('user_edit', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname));

	                        }
	                        else
	                        {
	                            $error[] = $this->registry->lang['controller']['errEdit'];
	                        }
	                    }
	                }
	            }

	            $_SESSION['userEditToken']=Helper::getSecurityToken();//Tao token moi
	            $this->registry->smarty->assign(array(   'formData'     => $formData,
            											'myUser'	=> $myUser,
	                                                    'redirectUrl'=> $redirectUrl,
	                                                    'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                    'userGroups'	=> Core_User::getGroupnameList(),
	                                                    'staticshelves' => Core_Shelf::getStaticShelves(),
	                                                    'error'        => $error,
	                                                    'success'    => $success,

	                                                    ));
	            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
	            $this->registry->smarty->assign(array(
	                                                    'menu'        => 'userlist',
	                                                    'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'],
	                                                    'contents'             => $contents));
	            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
            else
            {
            	$redirectMsg = $this->registry->lang['global']['notpermissiontitle'];
	            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
	                                                    'redirectMsg' => $redirectMsg,
	                                                    ));
	            $this->registry->smarty->display('redirect.tpl');
			}

        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                    'redirectMsg' => $redirectMsg,
                                                    ));
            $this->registry->smarty->display('redirect.tpl');
        }
    }

	function resetpassAction()
	{
		$id = (int)$this->registry->router->getArg('id');
        $myUser = new Core_User($id);
        $redirectUrl = $this->getRedirectUrl();

        if($myUser->id > 0)
        {
            //check priviledge priority
            //Yeu cau de edit:
            // 1. Hoac la admin
            // 2. Hoac la edit ban than, dung cho moderator, judge...
            // 3. Hoac la co priority number < priority number cua user duoc edit
            if($this->registry->me->groupid == GROUPID_ADMIN || ($this->registry->me->id == $myUser->id) )
            {
            	$error 		= array();
				$success 	= array();
				$contents 	= '';
				$formData 	= array();


				 srand((double)microtime()*1000000);
	   	 		 $newpass = rand(100000, 999999);

	   			 if($myUser->resetpass($newpass))
	   			 {
	   		 		 //send mail
	   		 		 $this->registry->smarty->assign(array('newpass' => $newpass,
	   		 	 											'myUser'	=> $myUser));
	   		 		 $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'user/resetpass.tpl');
	   		 		 $sender=  new SendMail($this->registry,
											$myUser->email,
											$myUser->fullname,
											str_replace('{USERNAME}', $myUser->username, $this->registry->setting['mail']['subjectAdminResetpassUser']),
											$mailContents,
											$this->registry->setting['mail']['fromEmail'],
											$this->registry->setting['mail']['fromName']
											);

					 $this->registry->me->writelog('user_resetpass', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname, 'newpass' => $newpass));


	   		 		 if($sender->Send())
	   		 		 {
	   		 	 		  $redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['succResetpass']);
					 }
					 else
					 {
				 		 $redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['errResetpassSendMail']);
					 }
				 }
				 else
				 {
			 		 $redirectMsg = $this->registry->lang['controller']['errResetpass'];
				 }

				 $redirectUrl = $this->registry->conf['rooturl_admin'] . 'user/edit/id/' . $myUser->id;

			}
            else
            {
            	$redirectMsg = $this->registry->lang['global']['notpermissiontitle'];
			}

        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
        }


		 $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                'redirectMsg' => $redirectMsg,
                                                ));
        $this->registry->smarty->display('redirect.tpl');
	}

	####################################################################################################
	####################################################################################################
	####################################################################################################


	private function addActionValidator($formData, &$error)
    {
        $pass = true;


        //kiem tra email co dung dinh dang hay khong    :ValidatedEmail
        if(!Helper::ValidatedEmail($formData['femail']))
        {
            $error[] = $this->registry->lang['controller']['errEmailInvalid'];
            $pass = false;
        }
        else
        {
            //kiem tra co trung email hay khong
             if(Core_User::getByEmail($formData['femail'])->id > 0)
            {
                $error[] = $this->registry->lang['controller']['errEmailExisted'];
                $pass = false;
            }
        }

        //kiem tra password
        if($formData['fpassword'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errPasswordRequired'];
            $pass = false;
		}

		elseif($formData['fpassword']!=$formData['fpassword2'])
        {
        	//nhap lai password khong dung nhu password dau
            $error[] = $this->registry->lang['controller']['errPasswordRetype'];
            $pass = false;
        }

        if($formData['ffullname'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errFullnameRequired'];
            $pass = false;
		}

        return $pass;
    }
     //khong cap nhat username
    private function editActionValidator($formData, &$error)
    {
        $pass = true;

      	if($formData['fgroupid'] == 0)
        {
            $error[] = $this->registry->lang['controller']['errGroupRequired'];
            $pass = false;
        }

        if($formData['ffullname'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errFullnameRequired'];
            $pass = false;
		}

		if($formData['fscreenname'] != $formData['fscreennamecurrent'])
		{
			if($formData['fscreenname'] == '')
	        {
        		$error[] = $this->registry->lang['controller']['errScreennameRequired'];
	            $pass = false;
			}
			else
			{
				//check existed screenname
				$sameScreenname = Core_User::getUsers(array('fscreenname' => $formData['fscreenname']), '', '', '', true);
				if($sameScreenname != 0)
				{
					$error[] =  $this->registry->lang['controller']['errScreennameExisted'];
					$pass = false;
				}
			}
		}


		if($formData['fgender'] != '' && $formData['fgender'] != 'm' && $formData['fgender'] != 'fm')
        {
        	$error[] = $this->registry->lang['controller']['errGenderInvalid'];
            $pass = false;
		}

		//check valid fav-category
		$tmpCategories = array();
		for($i = 0; $i < count($formData['fcategory']); $i++)
		{
			if(!is_numeric($formData['fcategory'][$i]))
			{
				//invalid category id
				$error[] =  $this->registry->lang['controller']['errCategoryValue'];
				$pass = false;
			}
			else
			{
				if(in_array($formData['fcategory'][$i], $tmpCategories))
				{
					//duplicate category id
					$error[] =  $this->registry->lang['controller']['errCategoryValue'];
					$pass = false;
				}
			}
		}


        return $pass;
    }


	public function searchidAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array();

		$idFilter 		= (int)($this->registry->router->getArg('id'));
		$groupidFilter 		= (int)($this->registry->router->getArg('groupid'));
		$keywordFilter 	= $this->registry->router->getArg('keyword');
		$searchKeywordIn= $this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;




		$paginateUrl = $this->registry->conf['rooturl_admin'].'user/searchid/';

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if($groupidFilter > 0)
		{
			$paginateUrl .= 'groupid/'.$groupidFilter . '/';
			$formData['fgroupid'] = $groupidFilter;
			$formData['search'] = 'groupid';
		}


		if(strlen($keywordFilter) > 0)
		{

			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'screenname')
			{
				$paginateUrl .= 'searchin/screenname/';
			}
			else if($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			else if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}


		//get latest account
		$users = Core_User::getUsers($formData, $sortby, $sorttype, 100);


		//build redirect string
		$redirectUrl = $paginateUrl;


		$this->registry->smarty->assign(array(	'users' 		=> $users,
												'formData'		=> $formData,
												'userGroups' => Core_User::getGroupnameList(),
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'redirectUrl'	=> $redirectUrl,
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'searchid.tpl');

		$this->registry->smarty->assign(array(	'menu'		=> 'userlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_tiny.tpl');
	}


	function changepasswordAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myUser = new Core_User($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myUser->id > 0)
        {
            //check priviledge priority
            //Yeu cau de edit:
            // 1. Hoac la admin
            // 2. Hoac la edit ban than
            if($this->registry->me->id == $myUser->id )
            {
            	$error         = array();
	            $success     = array();
	            $contents     = '';
	            $formData     = array();

	            if(!empty($_POST['fsubmit']))
	            {
					$formData = array_merge($formData, $_POST);

                    //kiem tra du lieu nhap
                    if($this->changepasswordActionValidator($formData, $error))
                    {

                        $myUser->newpass = $formData['fnewpass1'];

                        if($myUser->updateData(array(), $error))
                        {
                           $success[] = $this->registry->lang['controller']['succChangepassword'];
                           $this->registry->me->writelog('user_changepassword', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname));
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errChangepassword'];
                        }
                    }

	            }


	            $this->registry->smarty->assign(array(   'formData'     => $formData,
            											'myUser'	=> $myUser,
	                                                    'redirectUrl'=> $redirectUrl,
	                                                    'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                    'error'        => $error,
	                                                    'success'    => $success,
	                                                    ));
	            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'changepassword.tpl');
	            $this->registry->smarty->assign(array(
	                                                    'pageTitle'    => $this->registry->lang['controller']['pageTitle_changepassword'],
	                                                    'contents'             => $contents));
	            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
            else
            {
            	$redirectMsg = $this->registry->lang['global']['notpermissiontitle'];
	            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
	                                                    'redirectMsg' => $redirectMsg,
	                                                    ));
	            $this->registry->smarty->display('redirect.tpl');
			}

        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                    'redirectMsg' => $redirectMsg,
                                                    ));
            $this->registry->smarty->display('redirect.tpl');
        }
    }



	private function changepasswordActionValidator($formData, &$error)
	{
		$pass = true;

		//check oldpass
		//change password
		if(!viephpHashing::authenticate($formData['foldpass'], $this->registry->me->password))
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errOldpassNotvalid'];
		}

		if(strlen($formData['fnewpass1']) < 6)
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotvalid'];
		}

		if($formData['fnewpass1'] != $formData['fnewpass2'])
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotmatch'];
		}

		return $pass;
	}

}
