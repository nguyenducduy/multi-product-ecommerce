<?php

Class Controller_Admin_User Extends Controller_Admin_Base
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
		$groupidFilter 	= (int)($this->registry->router->getArg('groupid'));
		$oauthpartnerFilter = (int)($this->registry->router->getArg('oauthpartner'));
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

		if($this->registry->router->checkArg('oauthpartner'))
		{
			$oauthpartnerFilter = (int)($this->registry->router->getArg('oauthpartner'));

			$paginateUrl .= 'oauthpartner/'.$oauthpartnerFilter . '/';
			$formData['foauthpartner'] = $oauthpartnerFilter;
			$formData['search'] = 'oauthpartner';
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

		for($i = 0; $i < count($users); $i++)
		{
			//Neu la nhan vien, thi kiem tra phong ban
			if($users[$i]->isGroup('employee'))
			{
				$departmentList = $users[$i]->getBelongDepartments();
				$users[$i]->departmentList = $departmentList;
			}
			else
				$users[$i]->departmentList = array();
		}

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
            if($this->registry->me->groupid == GROUPID_ADMIN || $this->registry->me->groupid == GROUPID_MODERATOR )
            {
            	$error         = array();
	            $success     = array();
	            $contents     = '';
	            $formData     = array();

	            $formData['fgroupid'] = $myUser->groupid;
	            $formData['femail'] = $myUser->email;
	            $formData['ffullname'] = $myUser->fullname;
	            $formData['fgender'] = $myUser->gender;
	            $formData['fbirthday'] = $myUser->birthday;
	            $formData['fphone'] = $myUser->phone;
	            $formData['faddress'] = $myUser->address;
	            $formData['fregion'] = $myUser->region;
	            $formData['fcountry'] = $myUser->country;
	            $formData['fwebsite'] = $myUser->website;
	            $formData['fbio'] = $myUser->bio;
	            $formData['foauthpartner'] = $myUser->oauthPartner;
	            $formData['foauthuid'] = $myUser->oauthUid;

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
							$myUser->oauthPartner = $formData['foauthpartner'];
							$myUser->oauthUid = $formData['foauthuid'];

	                        if(isset($_POST['fdeleteimage']) && $_POST['fdeleteimage'] == '1')
							{
								$myUser->deleteImage();
							}

	                        if($myUser->updateData(array('fullname' => $formData['ffullname'], 'groupid' => $formData['fgroupid'])))
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


	function autocompleteajaxAction()
	{
		$keyword = Helper::xss_clean(strip_tags($_GET['tag']));

		//remove first @ character
		if(strpos($keyword, '@') === 0)
			$keyword = substr($keyword, 1);


		//search by id
		if(preg_match('/^a(\d+)$/i', $keyword, $match))
			$formData = array('fid' => (int)$match[1]);
		else
			$formData = array('fkeywordFilter' => $keyword);

		if(isset($_GET['type']))
		{
			if($_GET['type'] == 'employeeonly')
			{
				$formData['femployeeonly'] = 1;
			}
		}

		$userList = Core_User::getUsers($formData, 'datelasaction', 'DESC', 7);
		$items = array();
		for($i = 0; $i < count($userList); $i++)
		{
			$value = '<img src="'.$userList[$i]->getSmallImage().'" /> <span class="label label-success"></title><small title="'.$userList[$i]->oauthUid.'">A'.$userList[$i]->id.'</small></span> ' . $userList[$i]->fullname;
			$items[] = array('key' => $userList[$i]->id, 'value' => $value);
		}

		echo json_encode($items);

	}


	####################################################################################################
	####################################################################################################
	####################################################################################################


	private function addActionValidator($formData, &$error)
    {
        $pass = true;

		if($formData['fgroupid'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errGroupInvalid'];
			$pass = false;
		}

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


		if($formData['fgender'] != '' && $formData['fgender'] != 'm' && $formData['fgender'] != 'fm')
        {
        	$error[] = $this->registry->lang['controller']['errGenderInvalid'];
            $pass = false;
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



}
