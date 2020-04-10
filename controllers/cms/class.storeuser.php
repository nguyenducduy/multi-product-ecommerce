<?php

Class Controller_Cms_StoreUser Extends Controller_Cms_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		//kiem tra group cua user , neu khong phai la admin hoac developer thi khong the vao chuc nang nay
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			header('location: '.$this->registry['conf']['rooturl_cms']);
			exit();
		}

		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$sidFilter = (int)($this->registry->router->getArg('sid'));
		$roleFilter = (int)($this->registry->router->getArg('role'));
		$creatoridFilter = (int)($this->registry->router->getArg('creatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));


		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['storeuserBulkToken']==$_POST['ftoken'])
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
                            $myStoreUser = new Core_StoreUser($id);

                            if($myStoreUser->id > 0)
                            {
                                //tien hanh xoa
                                if($myStoreUser->delete())
                                {
                                    $deletedItems[] = $myStoreUser->id;
                                    $this->registry->me->writelog('storeuser_delete', $myStoreUser->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myStoreUser->id;
                            }
                            else
                                $cannotDeletedItems[] = $myStoreUser->id;
                        }

                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    }
                    else
                    {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }

		}

		$_SESSION['storeuserBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($sidFilter > 0)
		{
			$paginateUrl .= 'sid/'.$sidFilter . '/';
			$formData['fsid'] = $sidFilter;
			$formData['search'] = 'sid';
		}

		if($roleFilter > 0)
		{
			$paginateUrl .= 'role/'.$roleFilter . '/';
			$formData['frole'] = $roleFilter;
			$formData['search'] = 'role';
		}

		if($creatoridFilter > 0)
		{
			$paginateUrl .= 'creatorid/'.$creatoridFilter . '/';
			$formData['fcreatorid'] = $creatoridFilter;
			$formData['search'] = 'creatorid';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}


		//tim tong so
		$total = Core_StoreUser::getStoreUsers($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$storeusers = Core_StoreUser::getStoreUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		if(count($storeusers) > 0)
		{
			foreach($storeusers as $storeuser)
			{
				$storeuser->userActor = new Core_User($storeuser->uid);
				$storeuser->storeActor = new Core_Store($storeuser->sid);
			}
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


		$this->registry->smarty->assign(array(	'storeusers' 	=> $storeusers,
												'formData'		=> $formData,
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

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		//kiem tra group cua user , neu khong phai la admin hoac developer thi khong the vao chuc nang nay
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			header('location: '.$this->registry['conf']['rooturl_cms']);
			exit();
		}

		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['storeuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myStoreUser = new Core_StoreUser();


					$myStoreUser->uid = $formData['fuid'];
					$myStoreUser->role = $formData['frole'];
					if($formData['frole'] == Core_StoreUser::ROLE_SUPERMARKET)
					{
						$myStoreUser->sid = $formData['fsid'];
					}
					else
					{
						$myStoreUser->sid = 0;
					}
					$myStoreUser->creatorid = $this->registry->me->id;
					$myStoreUser->status = $formData['fstatus'];

                    if($myStoreUser->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('storeuser_add', $myStoreUser->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['storeuserAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'rolelist'		=> Core_StoreUser::getRoleList(),
												'storelist'		=> Core_Store::getStores(array() , 'name' , 'ASC'),
												'statusList'	=> Core_StoreUser::getStatusList(),
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		//kiem tra group cua user , neu khong phai la admin hoac developer thi khong the vao chuc nang nay
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			header('location: '.$this->registry['conf']['rooturl_cms']);
			exit();
		}

		$id = (int)$this->registry->router->getArg('id');
		$myStoreUser = new Core_StoreUser($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myStoreUser->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myStoreUser->uid;
			$formData['fsid'] = $myStoreUser->sid;
			$formData['fid'] = $myStoreUser->id;
			$formData['frole'] = $myStoreUser->role;
			$formData['fcreatorid'] = $myStoreUser->creatorid;
			$formData['fstatus'] = $myStoreUser->status;
			$formData['fdatecreated'] = $myStoreUser->datecreated;
			$formData['fdatemodified'] = $myStoreUser->datemodified;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['storeuserEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myStoreUser->uid = $formData['fuid'];
						if($formData['frole'] == Core_StoreUser::ROLE_SUPERMARKET)
						{
							$myStoreUser->sid = $formData['fsid'];
						}
						else
						{
							$myStoreUser->sid = 0;
						}
						$myStoreUser->role = $formData['frole'];
						$myStoreUser->creatorid = $formData['fcreatorid'];
						$myStoreUser->status = $formData['fstatus'];

                        if($myStoreUser->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('storeuser_edit', $myStoreUser->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}
			$userinfo = new Core_User($formData['fuid']);

			$_SESSION['storeuserEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'rolelist'		=> Core_StoreUser::getRoleList(),
													'storelist'		=> Core_Store::getStores(array() , 'name' , 'ASC'),
													'statusList'	=> Core_StoreUser::getStatusList(),
													'userinfo'		=> $userinfo,
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
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

	function deleteAction()
	{
		//kiem tra group cua user , neu khong phai la admin hoac developer thi khong the vao chuc nang nay
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			header('location: '.$this->registry['conf']['rooturl_cms']);
			exit();
		}

		$id = (int)$this->registry->router->getArg('id');
		$myStoreUser = new Core_StoreUser($id);
		if($myStoreUser->id > 0)
		{
			//tien hanh xoa
			if($myStoreUser->delete())
			{
				$redirectMsg = str_replace('###id###', $myStoreUser->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('storeuser_delete', $myStoreUser->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myStoreUser->id, $this->registry->lang['controller']['errDelete']);
			}

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

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fsid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errSidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['frole'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRoleMustGreaterThanZero'];
			$pass = false;
		}

		//kiem tra xem tai khoan nay da duoc phan quyen hay chua
		if($formData['frole'] == Core_StoreUser::ROLE_SUPERMARKET)
			$checker = Core_StoreUser::getStoreUsers(array('fuid' => $formData['fuid'],
															'fsid' => $formData['fsid'],
															'frole' => $formData['frole']
														) , 'id' ,'ASC' , '' , true);
		else
			$checker = Core_StoreUser::getStoreUsers(array('fuid' => $formData['fuid'],
															'frole' => $formData['frole']
														) , 'id' ,'ASC' , '' , true);

		if($checker > 0)
		{
			$error[] = $this->registry->lang['controller']['errUserExist'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fsid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errSidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['frole'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRoleMustGreaterThanZero'];
			$pass = false;
		}

		return $pass;
	}
}

?>