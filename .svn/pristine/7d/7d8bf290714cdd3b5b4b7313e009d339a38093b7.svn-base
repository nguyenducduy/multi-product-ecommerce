<?php

Class Controller_Cms_Slug Extends Controller_Cms_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$slugFilter = (string)($this->registry->router->getArg('slug'));
		$hashFilter = (string)($this->registry->router->getArg('hash'));
		$controllerFilter = (string)($this->registry->router->getArg('controller'));
		$objectidFilter = (int)($this->registry->router->getArg('objectid'));
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
            if($_SESSION['slugBulkToken']==$_POST['ftoken'])
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
                            $mySlug = new Core_Slug($id);

                            if($mySlug->id > 0)
                            {
                                //tien hanh xoa
                                if($mySlug->delete())
                                {
                                    $deletedItems[] = $mySlug->id;
                                    $this->registry->me->writelog('slug_delete', $mySlug->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $mySlug->id;
                            }
                            else
                                $cannotDeletedItems[] = $mySlug->id;
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

		$_SESSION['slugBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($slugFilter != "")
		{
			$paginateUrl .= 'slug/'.$slugFilter . '/';
			$formData['fslug'] = $slugFilter;
			$formData['search'] = 'slug';
		}

		if($hashFilter != "")
		{
			$paginateUrl .= 'hash/'.$hashFilter . '/';
			$formData['fhash'] = $hashFilter;
			$formData['search'] = 'hash';
		}


		if($controllerFilter != "")
		{
			$paginateUrl .= 'controller/'.$controllerFilter . '/';
			$formData['fcontroller'] = $controllerFilter;
			$formData['search'] = 'controller';
		}


		if($objectidFilter > 0)
		{
			$paginateUrl .= 'objectid/'.$objectidFilter . '/';
			$formData['fobjectid'] = $objectidFilter;
			$formData['search'] = 'objectid';
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
		$total = Core_Slug::getSlugs($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$slugs = Core_Slug::getSlugs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//get User
		for($i = 0; $i < count($slugs); $i++)
		{
			$slugs[$i]->actor = new Core_User($slugs[$i]->uid, true);
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


		///show message
		if($_GET['from'] == 'sync')
		{
			$success[] = $this->registry->lang['controller']['succSync'];
		}

		$this->registry->smarty->assign(array(	'slugs' 	=> $slugs,
												'formData'		=> $formData,
												'statusList'	=> Core_Slug::getStatusList(),
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

	function syncAction()
	{
		set_time_limit(3600);
		$conflictList = Core_Slug::sync();

		if(count($conflictList) == 0)
			header('location: ' . $this->registry->conf['rooturl_cms'] . 'slug/index?from=sync');
		else
		{
			echo '<h1>Can not import data from this list</h1>';
			foreach($conflictList as $module => $list)
			{
				echo '<hr /><h2>Module: ' . $module . '</h2>';
				foreach($list as $row)
				{
					echo '<p>ID: '.$row['id'].'. SLUG: '.$row['slug'].' (This Item will be removed slug = empty slug)</p>';
				}
			}
		}
	}


	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['slugAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $mySlug = new Core_Slug();

					$mySlug->uid = $this->registry->me->id;
					$mySlug->slug = $formData['fslug'];
					$mySlug->hash = md5($formData['fslug']);
					$mySlug->controller = $formData['fcontroller'];
					$mySlug->objectid = $formData['fobjectid'];
					$mySlug->redirecturl = $formData['fredirecturl'];
					$mySlug->status = $formData['fstatus'];
					

                    if($mySlug->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('slug_add', $mySlug->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['slugAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'statusList'	=> Core_Slug::getStatusList(),
												'error'			=> $error,
												'success'		=> $success,

												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$mySlug = new Core_Slug($id);

		$redirectUrl = $this->getRedirectUrl();
		if($mySlug->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $mySlug->uid;
			$formData['fid'] = $mySlug->id;
			$formData['fslug'] = $mySlug->slug;
			$formData['fhash'] = $mySlug->hash;
			$formData['fref'] = $mySlug->ref;
			$formData['fcontroller'] = $mySlug->controller;
			$formData['fobjectid'] = $mySlug->objectid;
			$formData['fredirecturl'] = $mySlug->redirecturl;
			$formData['fstatus'] = $mySlug->status;
			$formData['fdatecreated'] = $mySlug->datecreated;
			$formData['fdatemodified'] = $mySlug->datemodified;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['slugEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$mySlug->slug = $formData['fslug'];
						$mySlug->hash = md5($formData['fslug']);
						$mySlug->controller = $formData['fcontroller'];
						$mySlug->objectid = $formData['fobjectid'];
						$mySlug->redirecturl = $formData['fredirecturl'];
						$mySlug->status = $formData['fstatus'];

                        if($mySlug->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('slug_edit', $mySlug->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['slugEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'statusList'	=> Core_Slug::getStatusList(),
													'error'		=> $error,
													'success'	=> $success,

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
		$id = (int)$this->registry->router->getArg('id');
		$mySlug = new Core_Slug($id);
		if($mySlug->id > 0)
		{
			//tien hanh xoa
			if($mySlug->delete())
			{
				$redirectMsg = str_replace('###id###', $mySlug->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('slug_delete', $mySlug->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $mySlug->id, $this->registry->lang['controller']['errDelete']);
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



		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		return $pass;
	}
}

