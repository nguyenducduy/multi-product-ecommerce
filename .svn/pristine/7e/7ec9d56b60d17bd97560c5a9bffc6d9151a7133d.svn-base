<?php

Class Controller_Cms_ProductGroupAttribute Extends Controller_Cms_Base
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


		$pcidFilter = (int)($this->registry->router->getArg('pcid'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$displayorderFilter = (string)($this->registry->router->getArg('displayorder'));
		$statusFilter = (string)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		$permission = (string)($this->registry->router->getArg('permission'));

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;

		//display error permission
		switch($permission)
		{
			case 'add' : $error[] = $this->registry->lang['controller']['errorAddPermission'];
				break;
			case 'edit' : $error[] = $this->registry->lang['controller']['errorEditPermission'];
				break;
			case 'delete' : $error[] = $this->registry->lang['controller']['errorDeletePermission'];
				break;
		}

		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['productgroupattributeBulkToken']==$_POST['ftoken'])
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
                            $myProductGroupAttribute = new Core_ProductGroupAttribute($id);

                            if($myProductGroupAttribute->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductGroupAttribute->delete())
                                {
                                    $deletedItems[] = $myProductGroupAttribute->id;
                                    $this->registry->me->writelog('productgroupattribute_delete', $myProductGroupAttribute->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myProductGroupAttribute->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductGroupAttribute->id;
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
				$myItem = new Core_ProductGroupAttribute($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}

			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}

		$_SESSION['productgroupattributeBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($pcidFilter > 0)
		{
			$paginateUrl .= 'pcid/'.$pcidFilter . '/';
			$formData['fpcid'] = $pcidFilter;
			$formData['search'] = 'pcid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($displayorderFilter != "")
		{
			$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
			$formData['fdisplayorder'] = $displayorderFilter;
			$formData['search'] = 'displayorder';
		}

		if($statusFilter != "")
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

		if($this->registry->me->id != 1) // khong phai la admin
		{
			//get permission category
			$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');

			$permissionList = array();
			foreach($permissionCat as $permission)
			{
				$permissionList[] = $permission->pcid;
				$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
				foreach($subList as $sub)
				{
					$permissionList[] = $sub->id;
				}
			}
			$formData['fpcidarr'] = $permissionList;
		}

		if(count($formData['fpcidarr']) > 0 || $this->registry->me->groupid == 1)
		{
			//tim tong so
			$total = Core_ProductGroupAttribute::getProductGroupAttributes($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;
			//get latest account
			$productgroupattributes = Core_ProductGroupAttribute::getProductGroupAttributes($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
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


		$productcategoryList = array();
		$parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');

		if($this->registry->me->groupid != 1) // khong phai la admin
		{
			//check permission
			for($i = 0; $i < count($parentCategory1) ; $i++)
			{
				$ok = false;
				$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid' => $parentCategory1[$i]->id) , 'display_order' , 'ASC');
				if(count($parentCategory2) > 0)
				{
					$temp = array();
					for($k = 0 ; $k < count($parentCategory2) ; $k++)
					{
						//kiem tra phan quyen
						foreach($permissionCat as $permission)
						{
							if($permission->pcid == $parentCategory2[$k]->id)
							{
								$have = true;
								$temp[] = $parentCategory2[$k];
							}
						}
					}

					if($have && count($temp) > 0)
					{
						$productcategoryList[] = $parentCategory1[$i];
						for($j = 0 ; $j < count($temp) ; $j++)
						{
							$temp[$j]->name = '&nbsp;&nbsp;' . $temp[$j]->name;
							$productcategoryList[] = $temp[$j];
							$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$temp[$j]->id), 'displayorder', 'ASC');
							foreach ($subCategory as $sub)
							{
								$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
								$productcategoryList[] = $sub;
							}
						}
					}
				}

			}
		}
		else
		{
			for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
			{
				if($parentCategory1[$i]->parentid == 0)
				{
					$productcategoryList[] = $parentCategory1[$i];
					$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
					for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
					{
						$parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
						$productcategoryList[] = $parentCategory2[$j];

						$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
						foreach ($subCategory as $sub)
						{
							$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
							$productcategoryList[] = $sub;
						}
					}
				}
			}
		}

		$this->registry->smarty->assign(array(	'productgroupattributes' 	=> $productgroupattributes,
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
												'productcategoryList'	=> $productcategoryList,
												'statusList'	=> Core_ProductGroupAttribute::getStatusList(),
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

		//get permission category
		$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');

		if($this->registry->router->getArg('id') > 0)
		{
			$formData['fpcid'] = (int)$this->registry->router->getArg('id');
		}

		if($this->registry->router->getArg('pcid') > 0)
		{
			$formData['fpcid'] = (int)$this->registry->router->getArg('pcid');
		}

		if(!empty($_POST['fsubmitnext']))
		{
			//check user choose category
			$pcidparent = (int)$_POST['fpcidparent'];
			$pcidparent1 = 0;
			$pcidsub = (int)$_POST['fpcidsub'];
			if($pcidparent == 0)
			{
				$error[] = 'Please choose category !';
			}
			else
			{
				if($pcidsub > 0)
				{
					$pcidparent1 = $pcidparent;
					$pcidparent = $pcidsub;
				}

				if($this->registry->me->groupid != 1) // khong phai la admin
				{
					//check permission add
					$permissionList = array();
					foreach($permissionCat as $permission)
					{
						//$permissionList[] = $permission->pcid;
						$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
						$temp = array();
						foreach($subList as $sub)
						{
							$temp[] = $sub->id;
						}

						$permissionList[$permission->pcid] = $temp;
					}

					foreach($permissionList as $id=>$values)
					{
						if($id == $pcidparent)
						{
							$permissionAdds = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $id) , 'id' , 'ASC');
							break;
						}
						else
						{
							foreach($values as $value)
							{
								if($value == $pcidparent)
								{
									$permissionAdds = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $id) , 'id' , 'ASC');
										break;
								}
							}
						}
					}


					if(count($permissionAdds) > 0)
					{
						foreach($permissionAdds as $pAdd)
						{
							if($pAdd->permissionattribute >= Core_RelProductcategoryUser::PERMISSION_ADD)
							{
								header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/add/pcid/' . $pcidparent);
							}
							else
							{
								header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/index/permission/add');
								exit();
							}
							break;
						}
					}
					else
					{
						header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/index/permission/add');
						exit();
					}
				}
				else
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/add/pcid/' . $pcidparent);
				}
			}
		}


		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['productgroupattributeAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);
                if($this->addActionValidator($formData, $error))
                {
                    $myProductGroupAttribute = new Core_ProductGroupAttribute();

					$myProductGroupAttribute->uid = $this->registry->me->id;
					$myProductGroupAttribute->pcid = $formData['fpcid'];
					$myProductGroupAttribute->name = $formData['fname'];
					$myProductGroupAttribute->status = $formData['fstatus'];

                    if($myProductGroupAttribute->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productgroupattribute_add', $myProductGroupAttribute->id, array());
                        $formData = array();
						//header('location: ' . $this->registry['conf']['rooturl_cms'].'/productgroupattribute/add/');
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}


		$productcategoryList = array();
		$parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid'=>0), 'parentid', 'ASC');

		if($this->registry->me->groupid != 1) // khong phai la admin
		{
			//check permission
			for($i = 0; $i < count($parentCategory1) ; $i++)
			{
				$ok = false;
				$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid' => $parentCategory1[$i]->id) , 'display_order' , 'ASC');
				if(count($parentCategory2) > 0)
				{
					$temp = array();
					for($k = 0 ; $k < count($parentCategory2) ; $k++)
					{
						//kiem tra phan quyen
						foreach($permissionCat as $permission)
						{
							if($permission->pcid == $parentCategory2[$k]->id)
							{
								$have = true;
								$temp[] = $parentCategory2[$k];
							}
						}
					}

					if($have && count($temp) > 0)
					{
						$productcategoryList[] = $parentCategory1[$i];
						for($j = 0 ; $j < count($temp) ; $j++)
						{
							$temp[$j]->name = '&nbsp;&nbsp;' . $temp[$j]->name;
							$productcategoryList[] = $temp[$j];
							$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$temp[$j]->id), 'displayorder', 'ASC');
							foreach ($subCategory as $sub)
							{
								$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
								$productcategoryList[] = $sub;
							}
						}
					}
				}

			}
		}
		else
		{
			for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
			{
				if($parentCategory1[$i]->parentid == 0)
				{
					$productcategoryList[] = $parentCategory1[$i];
					$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
					for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
					{
						$parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
						$productcategoryList[] = $parentCategory2[$j];

						$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
						foreach ($subCategory as $sub)
						{
							$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
							$productcategoryList[] = $sub;
						}
					}
				}
			}
		}

		if((int)$formData['fpcid'] > 0)
		{
			$productcategory = new Core_Productcategory($formData['fpcid']);
		}

		$_SESSION['productgroupattributeAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'productcategoryList'	=> $productcategoryList,
												'statusList'		=> Core_ProductGroupAttribute::getStatusList(),
												'productcategory'	=> $productcategory,
												));
		if((int)$formData['fpcid'] > 0)
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addgroupattribute.tpl');
		}
		else
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		}
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myProductGroupAttribute = new Core_ProductGroupAttribute($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductGroupAttribute->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myProductGroupAttribute->uid;
			$formData['fpcid'] = $myProductGroupAttribute->pcid;
			$formData['fid'] = $myProductGroupAttribute->id;
			$formData['fname'] = $myProductGroupAttribute->name;
			$formData['fdisplayorder'] = $myProductGroupAttribute->displayorder;
			$formData['fstatus'] = $myProductGroupAttribute->status;
			$formData['fdatecreated'] = $myProductGroupAttribute->datecreated;
			$formData['fdatemodified'] = $myProductGroupAttribute->datemodified;

			if($this->registry->me->groupid != 1)
			{
				//get permission category
				$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');

				//check permission add
				$permissionList = array();
				foreach($permissionCat as $permission)
				{
					//$permissionList[] = $permission->pcid;
					$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
					$temp = array();
					foreach($subList as $sub)
					{
						$temp[] = $sub->id;
					}

					$permissionList[$permission->pcid] = $temp;
				}


				foreach($permissionList as $id=>$values)
				{
					if($id = $formData['fpcid'])
					{
						$permissionEidts = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $id) , 'id' , 'ASC');
						break;
					}
					else
					{
						foreach($values as $value)
						{
							if($value == $formData['fpcid'])
							{
								$permissionEidts = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $id) , 'id' , 'ASC');
									break;
							}
						}
					}
				}

				if(count($permissionEidts) > 0)
				{
					foreach($permissionEidts as $pEdit)
					{
						if($pEdit->permissionattribute < Core_RelProductcategoryUser::PERMISSION_EDIT)
						{
							header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/index/permission/edit');
						}
						break;
					}
				}
				else
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/index/permission/edit');
					exit();
				}
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productgroupattributeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myProductGroupAttribute->pcid = $formData['fpcid'];
						$myProductGroupAttribute->name = $formData['fname'];
						$myProductGroupAttribute->displayorder = $formData['fdisplayorder'];
						$myProductGroupAttribute->status = $formData['fstatus'];

                        if($myProductGroupAttribute->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productgroupattribute_edit', $myProductGroupAttribute->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$productcategoryList = array();
			$parentCategory1 = Core_Productcategory::getProductcategorys(array(), 'parentid', 'ASC');

			if($this->registry->me->groupid != 1) // khong phai la admin
			{
				//check permission
				for($i = 0; $i < count($parentCategory1) ; $i++)
				{
					$ok = false;
					$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid' => $parentCategory1[$i]->id) , 'display_order' , 'ASC');
					if(count($parentCategory2) > 0)
					{
						$temp = array();
						for($k = 0 ; $k < count($parentCategory2) ; $k++)
						{
							//kiem tra phan quyen
							foreach($permissionCat as $permission)
							{
								if($permission->pcid == $parentCategory2[$k]->id)
								{
									$have = true;
									$temp[] = $parentCategory2[$k];
								}
							}
						}

						if($have && count($temp) > 0)
						{
							$productcategoryList[] = $parentCategory1[$i];
							for($j = 0 ; $j < count($temp) ; $j++)
							{
								$temp[$j]->name = '&nbsp;&nbsp;' . $temp[$j]->name;
								$productcategoryList[] = $temp[$j];
								$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$temp[$j]->id), 'displayorder', 'ASC');
								foreach ($subCategory as $sub)
								{
									$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
									$productcategoryList[] = $sub;
								}
							}
						}
					}

				}
			}
			else
			{
				for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
				{
					if($parentCategory1[$i]->parentid == 0)
					{
						$productcategoryList[] = $parentCategory1[$i];
						$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
						for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
						{
							$parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
							$productcategoryList[] = $parentCategory2[$j];

							$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
							foreach ($subCategory as $sub)
							{
								$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
								$productcategoryList[] = $sub;
							}
						}
					}
				}
			}

			$_SESSION['productgroupattributeEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'productcategoryList'	=> $productcategoryList,
													'statusList'	=> Core_ProductGroupAttribute::getStatusList(),
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
		$myProductGroupAttribute = new Core_ProductGroupAttribute($id);
		if($myProductGroupAttribute->id > 0)
		{
			if($this->registry->me->groupid != 1) // khong phai la admin
			{
				//get permission category
				$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');

				//check permission delete
				$permissionList = array();
				foreach($permissionCat as $permission)
				{
					//$permissionList[] = $permission->pcid;
					$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
					$temp = array();
					foreach($subList as $sub)
					{
						$temp[] = $sub->id;
					}

					$permissionList[$permission->pcid] = $temp;
				}


				foreach($permissionList as $id=>$values)
				{
					if($id = $myProductGroupAttribute->pcid)
					{
						$permissionDeletes = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $id) , 'id' , 'ASC');
						break;
					}
					else
					{
						foreach($values as $value)
						{
							if($value == $formData['fpcid'])
							{
								$permissionDeletes = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $id) , 'id' , 'ASC');
									break;
							}
						}
					}
				}

				if(count($permissionDeletes) > 0)
				{
					foreach($permissionDeletes as $pDelete)
					{
						if($pDelete->permissionattribute < Core_RelProductcategoryUser::PERMISSION_DELETE)
						{
							header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/index/permission/delete');
							exit();
						}
						else
						{
							//tien hanh xoa
							if($myProductGroupAttribute->delete())
							{
								$redirectMsg = str_replace('###id###', $myProductGroupAttribute->id, $this->registry->lang['controller']['succDelete']);

								$this->registry->me->writelog('productgroupattribute_delete', $myProductGroupAttribute->id, array());
							}
							else
							{
								$redirectMsg = str_replace('###id###', $myProductGroupAttribute->id, $this->registry->lang['controller']['errDelete']);
							}
						}
						break;
					}
				}
				else
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'productgroupattribute/index/permission/delete');
					exit();
				}
			}
			else
			{
				//tien hanh xoa
				if($myProductGroupAttribute->delete())
				{
					$redirectMsg = str_replace('###id###', $myProductGroupAttribute->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('productgroupattribute_delete', $myProductGroupAttribute->id, array());
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myProductGroupAttribute->id, $this->registry->lang['controller']['errDelete']);
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

	public function viewAction()
	{
		$success = array();
		$error = array();
		$pcid = (int)$this->registry->router->getArg('pcid');
		$act = (string)$this->registry->router->getArg('act');
		$redirectUrl = $this->getRedirectUrl();
		$formData['act'] = $act;
		if($pcid > 0)
		{
			//cap nhat tt hien thi cua nhom thuoc tinh
			if(!empty($_POST['fsubmitgpa']))
			{
				$formData = array_merge($formData, $_POST);
				if(count($formData['fdisplayorder']) > 0)
				{
					$ok = false;
					foreach($formData['fdisplayorder'] as $gpaid => $displayorder)
					{
						if((int)$gpaid > 0)
						{
							$gpa = new Core_ProductGroupAttribute($gpaid);
							$gpa->displayorder = $displayorder;
							if($gpa->updateData())
							{
								$ok = true;
							}
						}
					}

					if($ok)
					{
						$success[] = $this->registry->lang['controller']['succUpdateGpa'];
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errUpdateGpa'];
						$formData = array();
					}
				}
			}

			if(!empty($_POST['fsubmitpa']))
			{
				$formData = array_merge($formData, $_POST);
				if(count($_POST['fpadisplayorder']) > 0)
				{
					$ok = false;
					foreach($formData['fpadisplayorder'] as $paid => $displayorder)
					{
						if((int)$paid > 0)
						{
							$pa = new Core_ProductAttribute($paid);
							$pa->displayorder = $displayorder;
							if($pa->updateData())
								$ok = true;
						}
					}

					if($ok)
					{
						$success[] = $this->registry->lang['controller']['succUpdatePa'];
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errUpdatePa'];
						$formData = array();
					}
				}
			}

			if(!empty($_POST['fsubmit']))
			{
				$formData = array_merge($formData,$_POST);
				if(count($formData['fdisplayorder']) > 0)
				{
					$ok = false;
					foreach($formData['fdisplayorder'] as $gpaid => $displayorder)
					{
						if((int)$gpaid > 0)
						{
							$gpa = new Core_ProductGroupAttribute($gpaid);
							$gpa->displayorder = $displayorder;
							if($gpa->updateData())
							{
								$ok = true;
							}
						}
					}
				}

				if(count($_POST['fpadisplayorder']) > 0)
				{
					$ok = false;
					foreach($formData['fpadisplayorder'] as $paid => $displayorder)
					{
						if((int)$paid > 0)
						{
							$pa = new Core_ProductAttribute($paid);
							$pa->displayorder = $displayorder;
							if($pa->updateData())
								$ok = true;
						}
					}
				}


					if($ok)
					{
						$success[] = $this->registry->lang['controller']['succUpdateDisplay'];
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errUpdateDisplay'];
						$formData = array();
					}
			}

			$formData['fpcid'] = $pcid;
			$productcategory = new Core_Productcategory($pcid);
			$denied = false;
			// if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
			// {
			// 	$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTATTRIBUTE, $this->registry->me->id, $productcategory->id,0, Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
			// 	if(!$checker)
			// 	{
			// 		$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTATTRIBUTE, $this->registry->me->id, $productcategory->parentid, 0, Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
			// 	}
			// }
			// else
			// {
			// 	$checker = true;
			// }

			$checker = true;

			// cap nhat group attribute
			if($checker)
			{
				//get latest account
				$productgroupattributes = Core_ProductGroupAttribute::getProductGroupAttributes($formData, 'displayorder', 'ASC');

				$parentcategory = new Core_Productcategory();
				if(count($productgroupattributes) == 0)
				{
					//lay danh sach thuoc tinh cua danh muc cha neu co
					$parentcategory = new Core_Productcategory($productcategory->parentid);
					if($parentcategory->parentid > 0)
					{
						$productgroupattributes = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$parentcategory->id), $sortby, $sorttype);
					}

				}

				if(count($productgroupattributes) > 0)
				{
					foreach($productgroupattributes as $productgroupattribute)
					{
						$productgroupattribute->attributes = Core_ProductAttribute::getProductAttributes(array('fpgaid'=>$productgroupattribute->id), 'displayorder', 'ASC');
					}
				}
			}
			else
			{
				$error[] = $this->registry->lang['controller']['errorEditPermission'];
				$denied = true;
			}


			$this->registry->smarty->assign(array(	'productcategory' => $productcategory,
													'parentcategory' => $parentcategory,
													'productgroupattributes' => $productgroupattributes,
													'formData' => $formData,
													'success' 	=> $success,
													'error' 	=> $error,
													'denied'	=>$denied,
													'dataTypeList' => Core_ProductAttribute::getDatatypeList(),
													'redirectUrl' => $redirectUrl,
												));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'view.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
														'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'view.tpl');
		}
	}

	public function editgroupattributeinlineAction()
	{
		$pgaid = (int)$_POST['id'];
		$pcid = (int)$_POST['fpcid'];
		$name = (string)$_POST['value'];
		$result = '';

		if($pcid > 0)
		{
			if($pgaid == 0)
			{
				if(strlen($name) > 0)
				{
					$myProductGroupAttribute = new Core_ProductGroupAttribute();

					$myProductGroupAttribute->uid = $this->registry->me->id;
					$myProductGroupAttribute->pcid = $pcid;
					$myProductGroupAttribute->name = Helper::plaintext($name);
					$myProductGroupAttribute->status = Core_ProductGroupAttribute::STATUS_ENABLE;

                    if($myProductGroupAttribute->addData() > 0)
                    {
                        $this->registry->me->writelog('productgroupattribute_add', $myProductGroupAttribute->id, array());
                        $result = $myProductGroupAttribute->id . ':' . $myProductGroupAttribute->name;
                    }
				}
			}
			else if($pgaid > 0)
			{
				$myProductGroupAttribute = new Core_ProductGroupAttribute($pgaid);

				if(strlen($name) > 0)
				{
					$myProductGroupAttribute->uid = $this->registry->me->id;
					$myProductGroupAttribute->pcid = $pcid;
					$myProductGroupAttribute->name = Helper::plaintext($name);
					$myProductGroupAttribute->status = Core_ProductGroupAttribute::STATUS_ENABLE;

	                if($myProductGroupAttribute->updateData() > 0)
	                {
	                    $this->registry->me->writelog('productgroupattribute_edit', $myProductGroupAttribute->id, array());
	                    $result = $myProductGroupAttribute->id . ':' . $myProductGroupAttribute->name. ':update';
	                }
				}
				else
				{
					$result = $myProductGroupAttribute->id . ':' . $myProductGroupAttribute->name . ':error';
				}
			}
			echo $result;
		}
	}

	public function editproductgroupattributeajaxAction()
	{
		$type = (string)$_POST['type'];
		$pgaid = (int)$_POST['gpaid'];
		$value = (string)$_POST['value'];
		$displayorder = (int)$_POST['displayorder'];
		$pcid = (int)$_POST['pcid'];


		if($pcid > 0)
		{
			switch ($type) {
				case 'add':
					if($value == '')
					{
						echo 0;
					}
					else
					{
						//add new group attribute
						$groupattribute = new Core_ProductGroupAttribute();
						$groupattribute->name = $value;
						$groupattribute->pcid = $pcid;
						$groupattribute->displayorder = $displayorder;
						$groupattribute->uid = $this->registry->me->id;
						$groupattribute->status = Core_ProductGroupAttribute::STATUS_ENABLE;						
						if($groupattribute->addData() > 0)
						{
							echo $groupattribute->id;
						}
						else
						{
							echo 0;
						}
					}
					break;

				case 'edit' :
					$groupattribute = new Core_ProductGroupAttribute($pgaid);
					if($groupattribute->id == 0 || $value == '')
					{
						echo 0;
					}
					else
					{
						//edit group attribute
						$groupattribute->name = $value;
						$groupattribute->displayorder = $displayorder;
						if($groupattribute->updateData() > 0)
							echo $groupattribute->id;
						else
							echo 0;
					}
					break;


				default:
					# code...
					break;
			}
		}
		else
		{
			echo 0;
		}

	}

	public function indexAjaxAction()
	{
		$result='';
		$fpcid = (int)$_POST['fpcid'];
		$fpgaid = (int)$_POST['fpgaid'];
		$ouputList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$fpcid),'id','ASC');
		for($i = 0 , $counter = count($ouputList) ; $i < $counter ; $i++)
		{
			$result .= '<option value="'.$ouputList[$i]->id.'" ';
			if($ouputList[$i]->id == $fpgaid)
			{
				$result .= ' selected="selected"';
			}
			$result .= '>' . $ouputList[$i]->name . '</option>';
		}
		echo $result;
	}

	public function deletegroupattributeajaxAction()
	{
		$result = '';
		$pgaid = (int)$_POST['id'];
		$pga = new Core_ProductGroupAttribute($pgaid);
		if($pga->id > 0)
		{
			$ok = false;
			$attributes = Core_ProductAttribute::getProductAttributes(array('fpgaid' => $pgaid) , 'id' , 'ASC');
			if(count($attributes) > 0)
			{
				foreach($attributes as $attribute)
				{
					if($attribute->delete() > 0)
						$ok = true;
				}
			}

			//delete group attribute
			if($pga->delete() > 0)
					$result = 'success';
		}
		echo $result;
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

		return $pass;
	}
}


