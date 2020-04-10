<?php

Class Controller_Cms_Newscategory Extends Controller_Cms_Base
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
		$permission = $this->registry->router->getArg('permission');

		//display error permission
		switch($permission)
		{
			case 'add' : $error[] = $this->registry->lang['controller']['errorAddPermission'];
				break;
			case 'edit' : $error[] = $this->registry->lang['controller']['errorEditPermission'];
				break;
			case 'delete' : $error[] = $this->registry->lang['controller']['errorDeletePermission'];
				break;
			case 'filter' : $error[] = $this->registry->lang['controller']['errorFilterPermission'];
				break;
			case 'segment' : $error[] = $this->registry->lang['controller']['errorSegmentPermission'];
				break;
		}

		/*$nameFilter = (string)($this->registry->router->getArg('name'));
		$summaryFilter = (string)($this->registry->router->getArg('summary'));*/
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));

        $keywordFilter = (string)$this->registry->router->getArg('keyword');
        $searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'displayorder';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['newscategoryBulkToken']==$_POST['ftoken'])
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
                            $myNewscategory = new Core_Newscategory($id);

                            if($myNewscategory->id > 0)
                            {
                            	if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
                            	{
                            		$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $myNewscategory->id, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
									if(!$checker)
									{
										$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $myNewscategory->parentid, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
									}

									if(!$checker)
									{
										header('location: ' . $this->registry['conf']['rooturl_cms'].'newscategory/index/permission/delete');
										exit();
									}
									else
									{
										//tien hanh xoa
		                                if($myNewscategory->delete())
		                                {
		                                    $deletedItems[] = $myNewscategory->id;
		                                    $this->registry->me->writelog('newscategory_delete', $myNewscategory->id, array());
		                                }
		                                else
		                                    $cannotDeletedItems[] = $myNewscategory->id;
									}
                            	}
                            	else
                            	{
                            		//tien hanh xoa
	                                if($myNewscategory->delete())
	                                {
	                                    $deletedItems[] = $myNewscategory->id;
	                                    $this->registry->me->writelog('newscategory_delete', $myNewscategory->id, array());
	                                }
	                                else
	                                    $cannotDeletedItems[] = $myNewscategory->id;
                            	}

                            }
                            else
                                $cannotDeletedItems[] = $myNewscategory->id;
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

        //change order of item
        if(!empty($_POST['fsubmitchangeorder']))
        {
            $displayorderList = $_POST['fdisplayorder'];
            foreach($displayorderList as $id => $neworder)
            {
                $myItem = new Core_Newscategory($id);
                if($myItem->id > 0 && $myItem->displayorder != $neworder)
                {
                    $myItem->displayorder = $neworder;
                    $myItem->updateData();
                }
            }

            $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
        }

		$_SESSION['newscategoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($summaryFilter != "")
		{
			$paginateUrl .= 'summary/'.$summaryFilter . '/';
			$formData['fsummary'] = $summaryFilter;
			$formData['search'] = 'summary';
		}

		if($parentidFilter > 0)
		{
			$paginateUrl .= 'parentid/'.$parentidFilter . '/';
			$formData['fparentid'] = $parentidFilter;
			$formData['search'] = 'parentid';
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

        if(strlen($keywordFilter) > 0)
        {
            $paginateUrl .= 'keyword/' . $keywordFilter . '/';

            if($searchKeywordIn == 'name')
            {
                $paginateUrl .= 'searchin/name/';
            }
            elseif($searchKeywordIn == 'summary')
            {
                $paginateUrl .= 'searchin/summary/';
            }
            $formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
            $formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
            $formData['search'] = 'keyword';
        }

        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
        	$list = array();
			$categorys = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id, 'fstatus' => Core_RoleUser::STATUS_ENABLE), 'objectid' , 'ASC','',false,true);

			if(count($categorys) > 0)
			{
				foreach($categorys as $category)
				{
					$list[] = $category->objectid;
					$catList = Core_Newscategory::getNewscategorys(array('fparentid' => $category->objectid) , '' , 'ASC');
					if(count($catList) > 0)
					{
						foreach($catList as $cat)
						{
							$list[] = $cat->id;
						}
					}
				}

				$formData['fidarr'] = $list;
			}

        }

		if(count($formData['fidarr']) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			//tim tong so
			$total = Core_Newscategory::getNewscategorys($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;


			//get latest account
			$newscategorys = Core_Newscategory::getNewscategorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
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


		$this->registry->smarty->assign(array(	'newscategorys' 	=> $newscategorys,
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
                                                'statusList'    => Core_Newscategory::getStatusList(),
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		$slugList = array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['newscategoryAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);

				$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
               	//get all slug related to current slug
				if($formData['fslug'] != '')
					$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                if($this->addActionValidator($formData, $error))
                {
                    $myNewscategory = new Core_Newscategory();


					$myNewscategory->image = $formData['fimage'];
					$myNewscategory->pcid = strlen($formData['fpcid']) > 0 ? implode(',' , $formData['fpcid']) : '';
					$myNewscategory->name = Helper::plaintext($formData['fname']);
					$myNewscategory->slug = $formData['fslug'];
					$myNewscategory->summary = Helper::plaintext($formData['fsummary']);
					$myNewscategory->seotitle = $formData['fseotitle'];
					$myNewscategory->seokeyword = $formData['fseokeyword'];
                    $myNewscategory->seodescription = $formData['fseodescription'];
					$myNewscategory->metarobot = $formData['fmetarobot'];
					$myNewscategory->parentid = $formData['fparentid'];
					$myNewscategory->countitem = $formData['fcountitem'];
					$myNewscategory->displayorder = $formData['fdisplayorder'];
					$myNewscategory->status = $formData['fstatus'];

                    if($myNewscategory->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('newscategory_add', $myNewscategory->id, array());
                        $formData = array();

    					///////////////////////////////////
   						//Add Slug base on slug of page
						$mySlug = new Core_Slug();
						$mySlug->uid = $this->registry->me->id;
						$mySlug->slug = $myNewscategory->slug;
						$mySlug->controller = 'newscategory';
						$mySlug->objectid = $myNewscategory->id;
						if(!$mySlug->addData())
						{
							$error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

							//reset slug of current item
							$myNewscategory->slug = '';
							$myNewscategory->updateData();
						}
						//end Slug process
						////////////////////////////////
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$newscategoryList = array();
		$parentCategory1 = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'parentid', 'ASC');
		for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
		{
			if($parentCategory1[$i]->parentid == 0)
			{
				$newscategoryList[] = $parentCategory1[$i];
				$parentCategory2 = Core_Newscategory::getNewscategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
				for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
				{
					$parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
					$newscategoryList[] = $parentCategory2[$j];

					$subCategory = Core_Newscategory::getNewscategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
					foreach ($subCategory as $sub)
					{
						$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
						$newscategoryList[] = $sub;
					}
				}
			}
		}

		//get product category
		$productcategorylist = array();
		$list = Core_Productcategory::getFullCategoryList();
		if(count($list) > 0)
		{
			foreach ($list as $productcategory)
			{
				switch ($productcategory->level)
				{
					case 2:
						$productcategory->name = '&nbsp;&nbsp;' . $productcategory->name;
						break;

					case 3:
						$productcategory->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $productcategory->name;
						break;
				}

				$productcategorylist[] = $productcategory;
			}
		}

		$_SESSION['newscategoryAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
                                                'newscategoryList'     => $newscategoryList,
                                                'statusList'    => Core_Newscategory::getStatusList(),
												'slugList'		=> $slugList,
												'productcategorylist' => $productcategorylist,
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
		$myNewscategory = new Core_Newscategory($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myNewscategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			$slugList	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myNewscategory->id;
			$formData['fimage'] = $myNewscategory->image;
			$formData['fname'] = $myNewscategory->name;
			$formData['fslug'] = $myNewscategory->slug;
			$formData['fsummary'] = $myNewscategory->summary;
			$formData['fseotitle'] = $myNewscategory->seotitle;
			$formData['fseokeyword'] = $myNewscategory->seokeyword;
            $formData['fseodescription'] = $myNewscategory->seodescription;
			$formData['fmetarobot'] = $myNewscategory->metarobot;
			$formData['fparentid'] = $myNewscategory->parentid;
			$formData['fcountitem'] = $myNewscategory->countitem;
			$formData['fdisplayorder'] = $myNewscategory->displayorder;
			$formData['fstatus'] = $myNewscategory->status;
			$formData['fdatecreated'] = $myNewscategory->datecreated;
			$formData['fdatemodified'] = $myNewscategory->datemodified;
			$formData['fpcid'] = array();

			if(strlen($myNewscategory->pcid) > 0)
			{
				$formData['fpcid'] = explode(',' , $myNewscategory->pcid);
			}

			//Current Slug
			$formData['fslugcurrent'] = $myNewscategory->slug;

            //khong phai la admin
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $formData['fid'], 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					//kiem tra quyen cua danh muc cha
					$checkerparent = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $formData['fparentid'], 0 , Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
					if(!$checkerparent)
					{
						header('location: ' . $this->registry['conf']['rooturl_cms'].'newscategory/index/permission/edit');
					}
				}
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['newscategoryEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

					/////////////////////////
					//get all slug related to current slug
					$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
					if($formData['fslug'] != '')
						$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                    if($this->editActionValidator($formData, $error))
                    {

						$myNewscategory->image = $formData['fimage'];
						$myNewscategory->pcid = count($formData['fpcid']) > 0 ? implode(',' , $formData['fpcid']) : '';
						$myNewscategory->name = $formData['fname'];
						$myNewscategory->slug = $formData['fslug'];
						$myNewscategory->summary = $formData['fsummary'];
						$myNewscategory->seotitle = $formData['fseotitle'];
						$myNewscategory->seokeyword = $formData['fseokeyword'];
                        $myNewscategory->seodescription = $formData['fseodescription'];
						$myNewscategory->metarobot = $formData['fmetarobot'];
						$myNewscategory->parentid = $formData['fparentid'];
						$myNewscategory->countitem = $formData['fcountitem'];
						$myNewscategory->displayorder = $formData['fdisplayorder'];
						$myNewscategory->status = $formData['fstatus'];

                        if($myNewscategory->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('newscategory_edit', $myNewscategory->id, array());

							///////////////////////////////////
	   						//Add Slug base on slug of page
							if($formData['fslug'] != $formData['fslugcurrent'])
							{
								$mySlug = new Core_Slug();
								$mySlug->uid = $this->registry->me->id;
								$mySlug->slug = $myNewscategory->slug;
								$mySlug->controller = 'newscategory';
								$mySlug->objectid = $myNewscategory->id;
								if(!$mySlug->addData())
								{
									$error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

									//reset slug of current item
									$myNewscategory->slug = $formData['fslugcurrent'];
									$myNewscategory->updateData();
								}
								else
								{
									//Add new slug ok, keep old slug but change the link to keep the reference to new ref
									Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'newscategory', $myNewscategory->id);
								}
							}

							//end Slug process
							////////////////////////////////
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}

			//get product category
			$productcategorylist = array();
			$list = Core_Productcategory::getFullCategoryList();
			if(count($list) > 0)
			{
				foreach ($list as $productcategory)
				{
					switch ($productcategory->level)
					{
						case 2:
							$productcategory->name = '&nbsp;&nbsp;' . $productcategory->name;
							break;

						case 3:
							$productcategory->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $productcategory->name;
							break;
					}

					$productcategorylist[] = $productcategory;
				}
			}

			$_SESSION['newscategoryEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'slugList'	=> $slugList,
                                                    'category'  => Core_Newscategory::getNewscategorys(array(), '', 'ASC',''),
                                                    'statusList'    => Core_Newscategory::getStatusList(),
                                                    'productcategorylist' => $productcategorylist,

													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'] . ' &raquo; ' . $myNewscategory->name ,
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
		$myNewscategory = new Core_Newscategory($id);
		if($myNewscategory->id > 0)
		{
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $myNewscategory->id, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $myNewscategory->parentid, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				}

				if(!$checker)
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'newscategory/index/permission/delete');
					exit();
				}
				else
				{
					//tien hanh xoa
					if($myNewscategory->delete())
					{
						$redirectMsg = str_replace('###id###', $myNewscategory->id, $this->registry->lang['controller']['succDelete']);

						$this->registry->me->writelog('newscategory_delete', $myNewscategory->id, array());

						//xoa slug lien quan den item nay
						Core_Slug::deleteSlug($myNewscategory->slug, 'newscategory', $myNewscategory->id);
					}
					else
					{
						$redirectMsg = str_replace('###id###', $myNewscategory->id, $this->registry->lang['controller']['errDelete']);
					}
				}

			}
			else
			{
				//tien hanh xoa
				if($myNewscategory->delete())
				{
					$redirectMsg = str_replace('###id###', $myNewscategory->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('newscategory_delete', $myNewscategory->id, array());
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myNewscategory->id, $this->registry->lang['controller']['errDelete']);
				}
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



		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fseodescription'] == '')
        {
            $error[] = $this->registry->lang['controller']['errMetaDescriptionRequired'];
            $pass = false;
        }

        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if($formData['fparentid'] == 0)
			{
				$error[] = $this->registry->lang['controller']['errParentRequired'];
				$pass = false;
			}
			else
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSCATEGORY, $this->registry->me->id, $formData['fparentid'],0,Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					 $error[] = $this->registry->lang['controller']['errorAddPermission'];
					 $pass = false;
				}
			}
		}

		//CHECKING SLUG
		if(Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
		{
			$error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fstatus'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStatusRequired'];
			$pass = false;
		}

		if($formData['fseodescription'] == '')
        {
            $error[] = $this->registry->lang['controller']['errMetaDescriptionRequired'];
            $pass = false;
        }

        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if($formData['fparentid'] == 0)
			{
				$error[] = $this->registry->lang['controller']['errParentRequired'];
				$pass = false;
			}
		}


		//CHECKING SLUG
		if($formData['fslug'] != $formData['fslugcurrent'] && Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
		{
			$error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
			$pass = false;
		}

		return $pass;
	}

	//Script import data tu Oracle qua mysql


	public function importAction()
	{
		$oracle = new Oracle();

		$sqlGetSiteID = 'SELECT * FROM TGDD_NEWS.NEWS_CATEGORY_SITE WHERE SITEID=8';

		$site = $oracle->query($sqlGetSiteID);
		foreach($site as $s)
		{
			$sqlGetCatID = 'SELECT * FROM TGDD_NEWS.NEWS_CATEGORY WHERE CATEGORYID='.$s['NEWSCATEID'].'';
			$result = $oracle->query($sqlGetCatID);

			foreach($result as $res)
			{
				$dateCreated = DateTime::createFromFormat('d-M-y', $res['CREATEDDATE']);

				if($res['ISACTIVED'] == 0)
					$ncstatus = 1;
				else
					$ncstatus = 1;

				if($res['URL'] == '')
					$res['URL'] = Helper::codau2khongdau($res['CATEGORYNAME'], true, true);

				$sqlImport = 'INSERT INTO ' . TABLE_PREFIX . 'newscategory(
								nc_id,
								nc_name,
								nc_slug,
								nc_summary,
								nc_seotitle,
								nc_seokeyword,
								nc_seodescription,
								nc_parentid,
								nc_displayorder,
								nc_status,
								nc_datecreated)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';


				$stmt = $this->registry->db->query($sqlImport, array(
								(int)$res['CATEGORYID'],
								(string)$res['CATEGORYNAME'],
								(string)$res['URL'],
								(string)$res['DESCRIPTION'],
								(string)$res['METATITLE'],
								(string)$res['METAKEYWORD'],
								(string)$res['METADESCRIPTION'],
								(int)$res['PARENTID'],
								(int)$res['DISPLAYORDER'],
								(int)$ncstatus,
								Helper::strtotimedmy($dateCreated->format('d/m/Y'))
								));

				if($stmt)
					echo $res['CATEGORYNAME'] . ' <i>inserted</i>	<br />';
			}
		}

		//convert oracle date to normal date
		//$date = DateTime::createFromFormat('d-M-y', '15-Feb-10');
		//echo $date->format('d/m/Y');

		/**/
	}

	public function roleAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		$permission = $this->registry->router->getArg('permission');

		switch ($permission) {
			case 'delegate':
				$error[] = $this->registry->lang['controller']['errorAccess'];
				break;
		}


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$valueFilter = (int)($this->registry->router->getArg('value'));
		$objectidFilter = (int)($this->registry->router->getArg('objectid'));
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

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/role/';

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($valueFilter > 0)
		{
			$paginateUrl .= 'value/'.$valueFilter . '/';
			$formData['fvalue'] = $valueFilter;
			$formData['search'] = 'value';
		}

		if($objectidFilter > 0)
		{
			$paginateUrl .= 'objectid/'.$objectidFilter . '/';
			$formData['fobjectid'] = $objectidFilter;
			$formData['search'] = 'objectid';
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

		$newscategoryList = Core_Newscategory::getNewscategorys(array(),'id','ASC');

        $formData['fcreatorid'] = $this->registry->me->id;
        $formData['ftypearr'] = array(Core_RoleUser::TYPE_NEWSCATEGORY, Core_RoleUser::TYPE_NEWS);
		//tim tong so
		$total = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype, 0, true,true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		//$roleusers = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		$roleusers = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype,'',false,true);

		if(count($roleusers) > 0)
		{
			foreach($roleusers as $roleuser)
			{
				$roleuser->actor = new Core_User($roleuser->uid);
				$roleuser->newscategory = new Core_Newscategory($roleuser->objectid);
				$roleuser->newscategory->parent = Core_Newscategory::getFullParentNewsCategorys($roleuser->newscategory->id);
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

		//user list

		if (count($roleusers) > 0)
		{
			$groupList = array();
			$group = array();
			for($i = 0 ; $i < count($roleusers) ; $i++)
			{
				if($i ==0)
				{
					$group[] = $roleusers[$i];
				}
				else
				{
					foreach($group as $obj)
					{
						if($obj->uid == $roleusers[$i]->uid)
						{
							$group[] =	$roleusers[$i];
							break;
						}
						else
						{
							$groupList[] = $group;
							$group = array();
							$group[] = $roleusers[$i];
							break;
						}
					}
				}

				if($i== count($roleusers)-1)
				{
					$groupList[] = $group;
				}
			}
		}


		//kiem tra xem user co the phan quyen cho nguoi khac khong
		$delegate = true;
		if($this->registry->me->isGroup('administrator') && $this->registry->me->isGroup('developer'))
		{
			$delegate = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id);
		}

		$redirectUrl = base64_encode($redirectUrl);

		$this->registry->smarty->assign(array(	'roleusers' 	=> $roleusers,
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
												'groupList'		=> $groupList,
												'statusList'	=> Core_RoleUser::getStatusList(),
												'newscategoryList'	=> $newscategoryList,
												'delegate'		=> $delegate
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'role.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function roleaddAction()
    {
    	$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			if(!empty($_POST['fsubmit']))
			{
	            if($_SESSION['roleuserAddToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);

	                if($this->addroleActionValidator($formData, $error))
	                {
                		$ok = false;
                		//add role of news
                   		if(count($formData['fnews']) > 0)
                   		{
                   			foreach($formData['fnews'] as $key => $value)
                   			{
                   				 $myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_NEWS;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

			                    if($myRoleUser->addData())
			                    {
		                    		$ok = true;
			                        $this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
			                    }
                   			}
                   		}


                   		//add role of news category
	                    if(count($formData['fnewscategory']) > 0)
	                    {
                    		foreach ($formData['fnewscategory'] as $key => $value)
                    		{
                    			$myRoleUser = new Core_RoleUser();


								$myRoleUser->type = Core_RoleUser::TYPE_NEWSCATEGORY;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

			                    if($myRoleUser->addData())
			                    {
		                    		$ok = true;
			                        $this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
			                    }
                    		}
	                    }

	                    #################################################################
	                    if($ok)
	                    {
                    		 $success[] = $this->registry->lang['controller']['succAddRole'];
                    		 $formData = array();
	                    }
	                    else
	                    {
                    		$error[] = $this->registry->lang['controller']['errAddRole'];
	                    }
	                }
	            }

			}

			//get news category
			$newscategoryList = Core_Newscategory::getNewscategorys(array('fparentidall' => 'all') , '' , '');

			if(count($newscategoryList) > 0)
			{
				$list = $newscategoryList;
				$newscategoryList = array();
				foreach ($list as $newscategory)
				{
					$output = array();
					$parentCat = new Core_Newscategory($newscategory->parentid);
					if($parentCat->parentid == 0)
					{
						$output = Core_Newscategory::getSubListCategory($newscategory->id , $list);
						foreach ($output as $obj)
						{
							$newscategoryList[] = $obj;
						}
					}
				}
			}

			$_SESSION['roleuserAddToken']=Helper::getSecurityToken();//Tao token moi
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errorAccess'];
		}


		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'newscategoryList' => $newscategoryList,
												'statusList' => Core_RoleUser::getStatusList(),
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roleadd.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_addrole'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    private function addroleActionValidator($formData, &$error)
	{
		$pass = true;
		if($formData['fuid'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errRoleUser'];
			$pass = false;
		}

		if(!isset($formData['fnews']) || !isset($formData['fnewscategory']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}
		elseif($formData['fuid'] > 0)
		{
			if(isset($formData['fnews']) && count($formData['fnews']) > 0)
			{
				foreach ($formData['fnews'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
														'ftype' => Core_RoleUser::TYPE_NEWS,
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fnewscategory']) && count($formData['fnewscategory']) > 0)
			{
				foreach ($formData['fnewscategory'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fmod']) && count($formData['fmod']) > 0)
			{
				foreach ($formData['fmod'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}

			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				//kiem tra xem nguoi dang phan quyen va nguoi phan quyen co cung 1 phong ban hay khong ?
				$startuser = new Core_User($this->registry->me->id);
				$startdepartmentList = $startuser->getBelongDepartments();

				$enduser = new Core_User($formData['fuid']);
				$enddepartmentList = $enduser->getBelongDepartments();

				if(count($startdepartmentList) > 0)
				{
					if(count($enddepartmentList) > 0)
					{
						$startdepartment = end($startdepartmentList);
						$enddepartment = end($enddepartmentList);
						if( $startdepartment->id == $enddepartment->id)
						{
							//lay tri cua 2 user de so sanh
							$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $startuser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$startuseredge = $startuseredges[0];

							$enduseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $enduser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$enduseredge = $enduseredges[0];

							if($startuseredge->id > 0 && $enduseredge->id > 0)
							{
								$startpriority = new Core_HrmTitle($startuseredge->point);
								$endpriority = new Core_HrmTitle($enduseredge->point);

								if($startpriority->priority >  $endpriority->priority)
								{
									$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUserPiority']);
									$pass = false;
								}
							}

						}
						else
						{
							$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
							$pass = false;
						}
					}
					else
					{
						$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
						$pass = false;
					}
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errstartUser'];
					$pass = false;
				}
			}
		}

		return $pass;
	}

	private function editroleActionValidator($formData, &$error)
	{
		$pass = true;

		if(!isset($formData['fnews']) || !isset($formData['fnewscategory']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}

		return $pass;
	}

	private function delegateroleActionValidator($formData, &$error)
	{
		$pass = true;
		if($formData['fuid'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errRoleUser'];
			$pass = false;
		}

		if(!isset($formData['fnews']) || !isset($formData['fnewscategory']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}
		elseif($formData['fuid'] > 0)
		{
			if(isset($formData['fnews']) && count($formData['fnews']) > 0)
			{
				foreach ($formData['fnews'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
														'ftype' => Core_RoleUser::TYPE_NEWS,
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}

					if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSDELEGATE, $this->registry->me->id, $key, 0, 0, Core_RoleUser::STATUS_ENABLE))
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fnewscategory']) && count($formData['fnewscategory']) > 0)
			{
				foreach ($formData['fnewscategory'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}

					if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSDELEGATE, $this->registry->me->id, $key, 0, 0, Core_RoleUser::STATUS_ENABLE))
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fmod']) && count($formData['fmod']) > 0)
			{
				foreach ($formData['fmod'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}

					if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSDELEGATE, $this->registry->me->id, $key, 0, 0, Core_RoleUser::STATUS_ENABLE))
					{
						$cat = new Core_Newscategory($key);
						$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
						$pass = false;
					}
				}
			}

			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				//kiem tra xem nguoi dang phan quyen va nguoi phan quyen co cung 1 phong ban hay khong ?
				$startuser = new Core_User($this->registry->me->id);
				$startdepartmentList = $startuser->getBelongDepartments();

				$enduser = new Core_User($formData['fuid']);
				$enddepartmentList = $enduser->getBelongDepartments();

				if(count($startdepartmentList) > 0)
				{
					if(count($enddepartmentList) > 0)
					{
						$startdepartment = end($startdepartmentList);
						$enddepartment = end($enddepartmentList);
						if( $startdepartment->id == $enddepartment->id)
						{
							//lay tri cua 2 user de so sanh
							$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $startuser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$startuseredge = $startuseredges[0];

							$enduseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $enduser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$enduseredge = $enduseredges[0];

							if($startuseredge->id > 0 && $enduseredge->id > 0)
							{
								$startpriority = new Core_HrmTitle($startuseredge->point);
								$endpriority = new Core_HrmTitle($enduseredge->point);

								if($startpriority->priority >  $endpriority->priority)
								{
									$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUserPiority']);
									$pass = false;
								}
							}

						}
						else
						{
							$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
							$pass = false;
						}
					}
					else
					{
						$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
						$pass = false;
					}
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errstartUser'];
					$pass = false;
				}
			}
		}

		return $pass;
	}

	public function roleeditAction()
    {
    	$uid = (int)$this->registry->router->getArg('uid');
    	$ncid = (int)$this->registry->router->getArg('ncid');

    	$redirectUrl = $this->getRedirectUrl();

    	$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $uid ,
    													'fobjectid' => $ncid), 'id' , 'ASC');

    	if(count($roleusers) > 0)
    	{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();


			foreach($roleusers as $roleuser)
			{
				switch ($roleuser->type)
				{
					case Core_RoleUser::TYPE_NEWS :
						$formData['fnews'] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_NEWSCATEGORY :
						$formData['fnewscategory'] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_NEWSDELEGATE :
						$formData['fmod'] = $roleuser->value;
						break;
				}

				$formData['fstatus'] = $roleuser->status;
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['roleuserEditToken'] == $_POST['ftoken'])
                {
                	$formData = array();
                    $formData = array_merge($formData, $_POST);

                    if($this->editroleActionValidator($formData,$error))
                    {
						//xoa tat ca cac record hien tai
						if(Core_RoleUser::deleteRoles($uid, $ncid, 0) > 0)
						{
							$ok = false;

                			//add role of news
                			if(isset($formData['fnews']))
                			{
                				$myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_NEWS;
								$myRoleUser->uid = $uid;
								$myRoleUser->value = Core_RoleUser::getRoleValue($formData['fnews']);
								$myRoleUser->objectid = $ncid;
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

					            if($myRoleUser->addData())
					            {
			                    	$ok = true;
					                $this->registry->me->writelog('roleuser_edit', $myRoleUser->id, array());
					            }
                			}

                   			//add role of news category
                   			if(isset($formData['fnewscategory']))
                   			{
                   				$myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_NEWSCATEGORY;
								$myRoleUser->uid = $uid;
								$myRoleUser->value = Core_RoleUser::getRoleValue($formData['fnewscategory']);
								$myRoleUser->objectid = $ncid;
								$myRoleUser->subobjectid = 0;
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

					            if($myRoleUser->addData())
					            {
			                    	$ok = true;
					                $this->registry->me->writelog('roleuser_edit', $myRoleUser->id, array());
					            }
                   			}

				            //add role of product deletegate
				            if(isset($formData['fmod']))
				            {
								$myRoleUser = new Core_RoleUser();

                   				$myRoleUser->type = Core_RoleUser::TYPE_NEWSDELEGATE;
								$myRoleUser->uid = $uid;
								$myRoleUser->value = $formData['fmod'];
								$myRoleUser->objectid = $ncid;
								$myRoleUser->subobjectid = 0;
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

			                    if($myRoleUser->addData())
			                    {
		                    		$ok = true;
			                        $this->registry->me->writelog('roleuser_edit', $myRoleUser->id, array());
			                    }
				            }
				            if($ok)
				            {
								$success[] = $this->registry->lang['controller']['succUpdateRole'];
				            }
				            else
				            {
								$error[] = $this->registry->lang['controller']['errUpdateRole'];
				            }
						}
                    }
				}
			}

			//
			$newscategory = new Core_Newscategory($ncid);
			$newscategory->parent = Core_Newscategory::getFullParentNewsCategorys($newscategory->id);

			//get info of user
			$user = new Core_User($uid);

    		$_SESSION['roleuserEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'newscategory' => $newscategory,
													'user' => $user,
													'statusList' => Core_Newscategory::getStatusList()
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roleedit.tpl');
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

    public function roledeleteAction()
    {
		$uid = (int)$this->registry->router->getArg('uid');
    	$ncid = (int)$this->registry->router->getArg('ncid');

    	$redirectUrl = $this->getRedirectUrl();

    	$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $uid ,
    													'fobjectid' => $ncid), 'id' , 'ASC');

		if(count($roleusers) > 0)
		{
			//tien hanh xoa phan quyen cho danh muc
			if(Core_RoleUser::deleteRoles($uid, $ncid, 0))
			{
				$newscategory = new Core_Newscategory($ncid);
				$redirectMsg = str_replace('###name###', $newscategory->name, $this->registry->lang['controller']['succDeleteRole']);

				$this->registry->me->writelog('roleuser_delete', $myRoleUser->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###name###', $newscategory->name, $this->registry->lang['controller']['errDeleteRole']);
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

    public function roledelegateAction()
    {
    	$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

    	//lay tat cac danh muc ma user co the phan quyen duoc
    	$newscategoryList = array();
    	$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id), 'id' , 'ASC' , '' , false , true);

    	if(count($roleusers) > 0)
    	{
			foreach($roleusers as $roleuser)
			{
				if(Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_NEWSDELEGATE, $this->registry->me->id, $roleuser->objectid, 0, 0, Core_RoleUser::STATUS_ENABLE))
				{
					$category = new Core_Newscategory($roleuser->objectid);
					$newscategoryList[] = $category;
				}
			}

			if(count($newscategoryList) == 0)
			{
				header('location: ' . $this->registry['conf']['rooturl_cms'].'newscategory/role/permission/delegate');
				exit();
			}
    	}

    	if(!empty($_POST['fsubmit']))
		{
	    	if($_SESSION['roleuserAddToken'] == $_POST['ftoken'])
	        {
	        	$formData = array_merge($formData, $_POST);
	        	if($this->delegateroleActionValidator($formData, $error))
	            {
					$ok = false;
                	//add role of news
                   	if(count($formData['fnews']) > 0)
                   	{
                   		foreach($formData['fnews'] as $key => $value)
                   		{
                   			$myRoleUser = new Core_RoleUser();

							$myRoleUser->type = Core_RoleUser::TYPE_NEWS;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = Core_RoleUser::getRoleValue($value);
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = 0;
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

			                if($myRoleUser->addData())
			                {
		                    	$ok = true;
			                    $this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
			                }
                   		}
                   	}


                   	//add role of news category
	                if(count($formData['fnewscategory']) > 0)
	                {
                    	foreach ($formData['fnewscategory'] as $key => $value)
                    	{
                    		$myRoleUser = new Core_RoleUser();


							$myRoleUser->type = Core_RoleUser::TYPE_NEWSCATEGORY;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = Core_RoleUser::getRoleValue($value);
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = 0;
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

			                if($myRoleUser->addData())
			                {
		                    	$ok = true;
			                    $this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
			                }
                    	}
	                }

	                //add role of mod
                   	if(count($formData['fmod']) > 0)
                   	{
                   		foreach ($formData['fmod'] as $key => $value)
                   		{
                   			$myRoleUser = new Core_RoleUser();

                   			$myRoleUser->type = Core_RoleUser::TYPE_NEWSDELEGATE;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = $value;
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = 0;
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

			                if($myRoleUser->addData())
			                {
		                    	$ok = true;
			                    $this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
			                }
                   		}
                   	}

	                #################################################################
	                if($ok)
	                {
                    	$success[] = $this->registry->lang['controller']['succAddRole'];
                    	$formData = array();
	                }
	                else
	                {
                    	$error[] = $this->registry->lang['controller']['errAddRole'];
	                }


	            }
			}
		}

		$_SESSION['roleuserAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'newscategoryList' => $newscategoryList,
												'statusList' => Core_RoleUser::getStatusList(),
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roledelegate.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_addrole'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }



}


