<?php

Class Controller_Cms_Stuffcategory Extends Controller_Cms_Base
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

		$nameFilter = (string)($this->registry->router->getArg('name'));
		$summaryFilter = (string)($this->registry->router->getArg('summary'));
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
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
            if($_SESSION['stuffcategoryBulkToken']==$_POST['ftoken'])
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
                            $myStuffcategory = new Core_Stuffcategory($id);

                            if($myStuffcategory->id > 0)
                            {
                            	if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
                            	{
                            		$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $myStuffcategory->id, 0, Core_RoleUser::ROLE_CHANGE);
									if(!$checker)
									{
										$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $myStuffcategory->parentid, 0, Core_RoleUser::ROLE_CHANGE);
									}

									if(!$checker)
									{
										header('location: ' . $this->registry['conf']['rooturl_cms'].'stuffcategory/index/permission/delete');
										exit();
									}
									else
									{
										//tien hanh xoa
		                                if($myStuffcategory->delete())
		                                {
		                                    $deletedItems[] = $myStuffcategory->id;
		                                    $this->registry->me->writelog('stuffcategory_delete', $myStuffcategory->id, array());
		                                }
		                                else
		                                    $cannotDeletedItems[] = $myStuffcategory->id;
									}
                            	}
                            	else
                            	{
                            		//tien hanh xoa
	                                if($myStuffcategory->delete())
	                                {
	                                    $deletedItems[] = $myStuffcategory->id;
	                                    $this->registry->me->writelog('stuffcategory_delete', $myStuffcategory->id, array());
	                                }
	                                else
	                                    $cannotDeletedItems[] = $myStuffcategory->id;
                            	}
                            }
                            else
                                $cannotDeletedItems[] = $myStuffcategory->id;
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

		if(!empty($_POST['fsubmitchangeorder']))
		{
			$displayorderList = $_POST['fdisplayorder'];
			foreach($displayorderList as $id => $neworder)
			{
				$myItem = new Core_Stuffcategory($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}

			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}

		$_SESSION['stuffcategoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

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

		if($displayorderFilter > 0)
		{
			$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
			$formData['fdisplayorder'] = $displayorderFilter;
			$formData['search'] = 'displayorder';
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
					$catList = Core_Stuffcategory::getStuffcategorys(array('fparentid' => $category->objectid) , '' , 'ASC');
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
			$total = Core_Stuffcategory::getStuffcategorys($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;


			//get latest account
			$stuffcategorys = Core_Stuffcategory::getStuffcategorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

			for($i = 0; $i < count($stuffcategorys); $i++)
			{
				$stuffcategorys[$i]->countsetting = Core_Stuff::getStuffs(array('fscid' => $stuffcategorys[$i]->id), '', '', '', true);
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


		$this->registry->smarty->assign(array(	'stuffcategorys' 	=> $stuffcategorys,
												'statusList'	=> Core_Stuffcategory::getStatusList(),
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
												'myStuffcategory'	=> Core_Stuffcategory::getStuffcategorys(array('fparentid' => 0), 'displayorder','ASC',''),
												'statusList'	=> Core_Stuffcategory::getStatusList()
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
            if($_SESSION['stuffcategoryAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);

                $formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
               	//get all slug related to current slug
				if($formData['fslug'] != '')
					$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                if($this->addActionValidator($formData, $error))
                {
                    $myStuffcategory = new Core_Stuffcategory();


					$myStuffcategory->image = $formData['fimage'];
					$myStuffcategory->name = $formData['fname'];
					$myStuffcategory->summary = $formData['fsummary'];
					$myStuffcategory->slug = $formData['fslug'];
					$myStuffcategory->seotitle = $formData['fseotitle'];
					$myStuffcategory->seokeyword = $formData['fseokeyword'];
					$myStuffcategory->seodescription = $formData['fseodescription'];
					$myStuffcategory->parentid = $formData['fparentid'];
					$myStuffcategory->displayorder = $formData['fdisplayorder'];
					$myStuffcategory->status = $formData['fstatus'];
					$myStuffcategory->iconclass = $formData['ficonclass'];

                    if($myStuffcategory->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('stuffcategory_add', $myStuffcategory->id, array());
                        $formData = array();

						///////////////////////////////////
   						//Add Slug base on slug of page
						$mySlug = new Core_Slug();
						$mySlug->uid = $this->registry->me->id;
						$mySlug->slug = $myStuffcategory->slug;
						$mySlug->controller = 'stuffcategory';
						$mySlug->objectid = $myStuffcategory->id;
						if(!$mySlug->addData())
						{
							$error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

							//reset slug of current item
							$myStuffcategory->slug = '';
							$myStuffcategory->updateData();
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

		$_SESSION['stuffcategoryAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'statusList'	=> Core_Stuffcategory::getStatusList(),
												'error'			=> $error,
												'success'		=> $success,
												'getParent'     => Core_Stuffcategory::getStuffcategorys(array('fparentid' => 0), 'nc_id', 'ASC'),
												'slugList'		=> $slugList,
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
		$myStuffcategory = new Core_Stuffcategory($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myStuffcategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			$slugList	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myStuffcategory->id;
			$formData['fimage'] = $myStuffcategory->image;
			$formData['fname'] = $myStuffcategory->name;
			$formData['fslug'] = $myStuffcategory->slug;
			$formData['fsummary'] = $myStuffcategory->summary;
			$formData['fseotitle'] = $myStuffcategory->seotitle;
			$formData['fseokeyword'] = $myStuffcategory->seokeyword;
			$formData['fseodescription'] = $myStuffcategory->seodescription;
			$formData['fparentid'] = $myStuffcategory->parentid;
			$formData['fcountitem'] = $myStuffcategory->countitem;
			$formData['fdisplayorder'] = $myStuffcategory->displayorder;
			$formData['fstatus'] = $myStuffcategory->status;
			$formData['ficonclass'] = $myStuffcategory->iconclass;
			$formData['fdatecreated'] = $myStuffcategory->datecreated;
			$formData['fdatemodified'] = $myStuffcategory->datemodified;

			//Current Slug
			$formData['fslugcurrent'] = $myStuffcategory->slug;

            //khong phai la admin
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $formData['fid'], 0, Core_RoleUser::ROLE_CHANGE);
				if(!$checker)
				{
					//kiem tra quyen cua danh muc cha
					$checkerparent = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $formData['fparentid'], 0 , Core_RoleUser::ROLE_CHANGE);
					if(!$checkerparent)
					{
						header('location: ' . $this->registry['conf']['rooturl_cms'].'stuffcategory/index/permission/edit');
					}
				}
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['stuffcategoryEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

					/////////////////////////
					//get all slug related to current slug
					$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
					if($formData['fslug'] != '')
						$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                    if($this->editActionValidator($formData, $error))
                    {

						$myStuffcategory->image = $formData['fimage'];
						$myStuffcategory->name = $formData['fname'];
						$myStuffcategory->summary = $formData['fsummary'];
						$myStuffcategory->seotitle = $formData['fseotitle'];
						$myStuffcategory->slug = $formData['fslug'];
						$myStuffcategory->seokeyword = $formData['fseokeyword'];
						$myStuffcategory->seodescription = $formData['fseodescription'];
						$myStuffcategory->parentid = $formData['fparentid'];
						$myStuffcategory->displayorder = $formData['fdisplayorder'];
						$myStuffcategory->status = $formData['fstatus'];
						$myStuffcategory->iconclass = $formData['ficonclass'];

                        if($myStuffcategory->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('stuffcategory_edit', $myStuffcategory->id, array());

							///////////////////////////////////
	   						//Add Slug base on slug of page
							if($formData['fslug'] != $formData['fslugcurrent'])
							{
								$mySlug = new Core_Slug();
								$mySlug->uid = $this->registry->me->id;
								$mySlug->slug = $myStuffcategory->slug;
								$mySlug->controller = 'stuffcategory';
								$mySlug->objectid = $myStuffcategory->id;
								if(!$mySlug->addData())
								{
									$error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

									//reset slug of current item
									$myStuffcategory->slug = $formData['fslugcurrent'];
									$myStuffcategory->updateData();
								}
								else
								{
									//Add new slug ok, keep old slug but change the link to keep the reference to new ref
									Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'stuffcategory', $myStuffcategory->id);
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


			$_SESSION['stuffcategoryEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'statusList'	=> Core_Stuffcategory::getStatusList(),
													'error'		=> $error,
													'success'	=> $success,
													'slugList'	=> $slugList,
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'] . ' &raquo; ' . $myStuffcategory->name ,
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
		$myStuffcategory = new Core_Stuffcategory($id);
		if($myStuffcategory->id > 0)
		{
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $myStuffcategory->id, 0, Core_RoleUser::ROLE_CHANGE);
				if(!$checker)
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $myStuffcategory->parentid, 0, Core_RoleUser::ROLE_CHANGE);
				}

				if(!$checker)
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'stuffcategory/index/permission/delete');
					exit();
				}
				else
				{
					//tien hanh xoa
					if($myStuffcategory->delete())
					{
						$redirectMsg = str_replace('###id###', $myStuffcategory->id, $this->registry->lang['controller']['succDelete']);

						$this->registry->me->writelog('stuffcategory_delete', $myStuffcategory->id, array());
					}
					else
					{
						$redirectMsg = str_replace('###id###', $myStuffcategory->id, $this->registry->lang['controller']['errDelete']);
					}
				}
			}
			else
			{
				//tien hanh xoa
				if($myStuffcategory->delete())
				{
					$redirectMsg = str_replace('###id###', $myStuffcategory->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('stuffcategory_delete', $myStuffcategory->id, array());
					//xoa slug lien quan den item nay
					Core_Slug::deleteSlug($myStuffcategory->slug, 'stuffcategory', $myStuffcategory->id);
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myStuffcategory->id, $this->registry->lang['controller']['errDelete']);
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

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if($formData['fparentid'] == 0)
			{
				$error[] = $this->registry->lang['controller']['errParentRequired'];
				$pass = false;
			}
			else
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFCATEGORY, $this->registry->me->id, $formData['fparentid'],0,Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
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

		//CHECKING SLUG
		if($formData['fslug'] != $formData['fslugcurrent'] && Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
		{
			$error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
			$pass = false;
		}

		return $pass;
	}

	public function importAction()
	{
		$oracle = new Oracle();

		$sql = 'SELECT * FROM TGDD_NEWS.CLASSIFIED_CATEGORY';

		$result = array();

		$result = $oracle->query($sql);

		foreach($result as $res)
		{
			//chuyen doi time oracle thanh timestamp
				//$dateCreated = DateTime::createFromFormat('d-M-y', $res['CREATEDDATE']); khong chuyen doi vi time trong field nay luu o dang khac
			$this->datecreated = time();

			//chuyen doi gia tri 0,1 thanh 2,1 cho status
			if($res['ISACTIVED'] == 0)
				$status = 2;
			else
				$status = $res['ISACTIVED'];

			$sqlImport = 'INSERT INTO ' . TABLE_PREFIX . 'stuffcategory(
								sc_id,
								sc_image,
								sc_name,
								sc_slug,
								sc_summary,
								sc_seotitle,
								sc_seokeyword,
								sc_seodescription,
								sc_parentid,
								sc_displayorder,
								sc_status,
								sc_datecreated)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

			$stmt = $this->registry->db->query($sqlImport,array(
								(int)$res['CATEGORYID'],
								(string)$res['ICON'],
								(string)$res['CATEGORYNAME'],
								(string)$res['URL'],
								(string)$res['DESCRIPTION'],
								(string)$res['METATITLE'],
								(string)$res['METAKEYWORD'],
								(string)$res['METADESCRIPTION'],
								0,
								(int)$res['DISPLAYORDER'],
								(int)$status,
								(int)$this->datecreated
								));

			if($stmt)
			{
				echo $res['CATEGORYNAME'] . ' INSERTED <br />';
			}
			else
				echo $res['CATEGORYNAME'] . ' <i>NOT INSERTED</i><hr />';


		}
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

		$stuffcategoryList = Core_Stuffcategory::getStuffcategorys(array(),'id','ASC');

        $formData['fcreatorid'] = $this->registry->me->id;
        $formData['ftypearr'] = array(Core_RoleUser::TYPE_STUFFCATEGORY, Core_RoleUser::TYPE_STUFF);
		//tim tong so
		$total = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype, 0, true,true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		//$roleusers = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		$roleusers = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype,'',false,true);
		//echodebug($roleusers);
		if(count($roleusers) > 0)
		{
			foreach($roleusers as $roleuser)
			{
				$roleuser->actor = new Core_User($roleuser->uid);
				$roleuser->stuffcategory = new Core_Stuffcategory($roleuser->objectid);
				$roleuser->stuffcategory->parent = Core_Stuffcategory::getFullParentStuffCategorys($roleuser->stuffcategory->id);
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
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$delegate = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, 0, 0, 0, Core_RoleUser::STATUS_ENABLE);
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
												'stuffcategoryList'	=> $stuffcategoryList,
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
                		//add role of stuff
                   		if(count($formData['fstuff']) > 0)
                   		{
                   			foreach($formData['fstuff'] as $key => $value)
                   			{
                   				$myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_STUFF;
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


                   		//add role of stuff category
	                    if(count($formData['fstuffcategory']) > 0)
	                    {
                    		foreach ($formData['fstuffcategory'] as $key => $value)
                    		{
                    			$myRoleUser = new Core_RoleUser();


								$myRoleUser->type = Core_RoleUser::TYPE_STUFFCATEGORY;
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

	                    //add role of mod
                   		if(count($formData['fmod']) > 0)
                   		{
                   			foreach ($formData['fmod'] as $key => $value)
                   			{
                   				$myRoleUser = new Core_RoleUser();

                   				$myRoleUser->type = Core_RoleUser::TYPE_STUFFDELEGATE;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = $value;
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

			//get stuff category
			$stuffcategoryList = Core_Stuffcategory::getStuffcategorys(array(), 'id' , 'ASC');

			if(count($stuffcategoryList) > 0)
			{
				$list = $stuffcategoryList;
				$stuffcategoryList = array();
				foreach ($list as $stuffcategory)
				{
					$output = array();
					$parentCat = new Core_Stuffcategory($stuffcategory->parentid);
					if($parentCat->parentid == 0)
					{
						$output = Core_Stuffcategory::getSubListCategory($stuffcategory->id , $list);
						foreach ($output as $obj)
						{
							$stuffcategoryList[] = $obj;
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
												'stuffcategoryList' => $stuffcategoryList,
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

		if(!isset($formData['fstuff']) || !isset($formData['fstuffcategory']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}
		elseif($formData['fuid'] > 0)
		{
			if(isset($formData['fstuff']) && count($formData['fstuff']) > 0)
			{
				foreach ($formData['fstuff'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
														'ftype' => Core_RoleUser::TYPE_STUFF,
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Stuffcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fstuffcategory']) && count($formData['fstuffcategory']) > 0)
			{
				foreach ($formData['fstuffcategory'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
														'fuid'	=> $formData['fuid'],
												) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Stuffcategory($key);
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
						$cat = new Core_Stuffcategory($key);
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

		if(!isset($formData['fstuff']) || !isset($formData['fstuffcategory']))
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
														'ftype' => Core_RoleUser::TYPE_STUFF,
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
    	$scid = (int)$this->registry->router->getArg('scid');

    	$redirectUrl = $this->getRedirectUrl();

    	$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $uid ,
    													'fobjectid' => $scid), 'id' , 'ASC');

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
					case Core_RoleUser::TYPE_STUFF :
						$formData['fstuff'] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_STUFFCATEGORY :
						$formData['fstuffcategory'] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_STUFFDELEGATE :
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
						if(Core_RoleUser::deleteRoles($uid, $scid, 0) > 0)
						{
							$ok = false;

                			//add role of stuff
                   			$myRoleUser = new Core_RoleUser();

							$myRoleUser->type = Core_RoleUser::TYPE_STUFF;
							$myRoleUser->uid = $uid;
							$myRoleUser->value = Core_RoleUser::getRoleValue($formData['fstuff']);
							$myRoleUser->objectid = $scid;
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

				            if($myRoleUser->addData())
				            {
		                    	$ok = true;
				                $this->registry->me->writelog('roleuser_edit', $myRoleUser->id, array());
				            }


                   			//add role of stuff category
		                    $myRoleUser = new Core_RoleUser();


							$myRoleUser->type = Core_RoleUser::TYPE_STUFFCATEGORY;
							$myRoleUser->uid = $uid;
							$myRoleUser->value = Core_RoleUser::getRoleValue($formData['fstuffcategory']);
							$myRoleUser->objectid = $scid;
							$myRoleUser->subobjectid = 0;
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

				            if($myRoleUser->addData())
				            {
		                    	$ok = true;
				                $this->registry->me->writelog('roleuser_edit', $myRoleUser->id, array());
				            }

				            //add role of stuff deletegate
				            if(isset($formData['fmod']))
				            {
								$myRoleUser = new Core_RoleUser();

                   				$myRoleUser->type = Core_RoleUser::TYPE_STUFFDELEGATE;
								$myRoleUser->uid = $uid;
								$myRoleUser->value = $formData['fmod'];
								$myRoleUser->objectid = $scid;
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
			$stuffcategory = new Core_Stuffcategory($scid);
			$stuffcategory->parent = Core_Stuffcategory::getFullParentStuffCategorys($stuffcategory->id);

			//get info of user
			$user = new Core_User($uid);

    		$_SESSION['roleuserEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'stuffcategory' => $stuffcategory,
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
    	$scid = (int)$this->registry->router->getArg('scid');

    	$redirectUrl = $this->getRedirectUrl();

    	$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $uid ,
    													'fobjectid' => $scid), 'id' , 'ASC');

		if(count($roleusers) > 0)
		{
			//tien hanh xoa phan quyen cho danh muc
			if(Core_RoleUser::deleteRoles($uid, $scid, 0))
			{
				$stuffcategory = new Core_Stuffcategory($scid);
				$redirectMsg = str_replace('###name###', $stuffcategory->name, $this->registry->lang['controller']['succDeleteRole']);

				$this->registry->me->writelog('roleuser_delete', $myRoleUser->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###name###', $stuffcategory->name, $this->registry->lang['controller']['errDeleteRole']);
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
    	$stufcategoryList = array();
    	$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id), 'id' , 'ASC' , '' , false , true);

    	if(count($roleusers) > 0)
    	{
			foreach($roleusers as $roleuser)
			{
				if(Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFFDELEGATE, $this->registry->me->id, $roleuser->objectid, 0, 0, Core_RoleUser::STATUS_ENABLE))
				{
					$category = new Core_Stuffcategory($roleuser->objectid);
					$stuffcategoryList[] = $category;
				}
			}

			if(count($stuffcategoryList) == 0)
			{
				header('location: ' . $this->registry['conf']['rooturl_cms'].'stuffcategory/role/permission/delegate');
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
                	//add role of stuff
                   	if(count($formData['fstuff']) > 0)
                   	{
                   		foreach($formData['fstuff'] as $key => $value)
                   		{
                   			$myRoleUser = new Core_RoleUser();

							$myRoleUser->type = Core_RoleUser::TYPE_STUFF;
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


                   	//add role of stuff category
	                if(count($formData['fstuffcategory']) > 0)
	                {
                    	foreach ($formData['fstuffcategory'] as $key => $value)
                    	{
                    		$myRoleUser = new Core_RoleUser();


							$myRoleUser->type = Core_RoleUser::TYPE_STUFFCATEGORY;
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

                   			$myRoleUser->type = Core_RoleUser::TYPE_STUFFDELEGATE;
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
												'stuffcategoryList' => $stuffcategoryList,
												'statusList' => Core_RoleUser::getStatusList(),
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roledelegate.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_addrole'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }
}

