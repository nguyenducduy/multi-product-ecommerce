<?php

Class Controller_Cms_ProductAttribute Extends Controller_Cms_Base
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

		$pgaidFilter = (int)($this->registry->router->getArg('pgaid'));
		$pcidFilter = (int)($this->registry->router->getArg('pcid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
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
            if($_SESSION['productattributeBulkToken']==$_POST['ftoken'])
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
                            $myProductAttribute = new Core_ProductAttribute($id);

                            if($myProductAttribute->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductAttribute->delete())
                                {
                                    $deletedItems[] = $myProductAttribute->id;
                                    $this->registry->me->writelog('productattribute_delete', $myProductAttribute->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myProductAttribute->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductAttribute->id;
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
				$myItem = new Core_ProductAttribute($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}

			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}

		$_SESSION['productattributeBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($pgaidFilter > 0)
		{
			$paginateUrl .= 'pgaid/'.$pgaidFilter . '/';
			$formData['fpgaid'] = $pgaidFilter;
			$formData['search'] = 'pgaid';
		}

		if($pcidFilter > 0)
		{
			$paginateUrl .= 'pcid/'.$pcidFilter . '/';
			$formData['fpcid'] = $pcidFilter;
			$formData['search'] = 'pcid';
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

		if($this->registry->me->groupid != 1) // khong phai la admin
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
			$total = Core_ProductAttribute::getProductAttributes($formData, $sortby, $sorttype, 0, true); 					;
			$totalPage =  ceil($total/$this->recordPerPage);
			$curPage = $page;
			//get latest account
			$productattributes =  Core_ProductAttribute::getProductAttributes($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
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


		$productAttributeGroupList = Core_ProductGroupAttribute::getProductGroupAttributes(array() , '','');

		$this->registry->smarty->assign(array(	'productattributes' 	=> $productattributes,
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
												'productcategoryList' => $productcategoryList,
												'productAttributeGroupList' => $productAttributeGroupList,
												'statusList'	=> Core_ProductAttribute::getStatusList(),
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
		$pcid 	= (int)($this->registry->router->getArg('pcid'));
		$pgaid  = (int)($this->registry->router->getArg('pgaid'));

		//get permission category
		$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');

		if(!empty($_POST['fnext']))
		{
			$pcid = (int)$_POST['fpcid'];
			$pgaid = (int)$_POST['fpgaid'];
			if($pgaid > 0)
			{
				$groupattribute = new Core_ProductGroupAttribute($pgaid);
				if($pcid == $groupattribute->pcid)
				{
					$formData['fpcid'] = $pcid;
					$formData['fpgaid'] = $pgaid;
					$productcategory = new Core_Productcategory($pcid);

				}
				else
				{
					$error[] = $this->registry->lang['controller']['errPcidMustGreaterThanZero'];
				}
			}
			else
			{
				$error[] = $this->registry->lang['controller']['errPgaidMustGreaterThanZero'];
			}
		}

		if($pcid > 0)
		{
			$formData['fpcid'] = $pcid;
			$productcategory = new Core_Productcategory($formData['fpcid']);
		}

		if($pgaid > 0)
		{
			$formData['fpgaid'] = $pgaid;
			$groupattribute = new Core_ProductGroupAttribute($formData['fpgaid']);
		}

		if($this->registry->me-groupid != 1) // khong phai la admin
		{
			//check permission add
			$permissionList = array();
			foreach($permissionCat as $permission)
			{
				$permissionList[] = new Core_Productcategory($permission->pcid);
				$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
				foreach($subList as $sub)
				{
					$permissionList[] = $sub;
				}
			}

			for($i = 0, $counter = count($permissionList) ; $i < $counter ; $i++)
			{
				if($permissionList[$i]->id == $pcid)
				{
					$permissionAdds = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $pcid) , 'id' , 'ASC');
					break;
				}
			}

			if(count($permissionAdds) > 0)
			{
				foreach($permissionAdds as $pAdd)
				{
					if($pAdd->permissionattribute < Core_RelProductcategoryUser::PERMISSION_ADD)
					{
						header('location: ' . $this->registry['conf']['rooturl_cms'].'productattribute/index/permission/add');
						exit();
					}
					else
					{
						if($pcid > 0 && $pgaid > 0)
						{
							header('location: ' . $this->registry['conf']['rooturl_cms'] . 'productattribute/add/pcid/'.$pcid.'/pgaid/' . $pgaid);
						}
					}
					break;
				}
			}
			else
			{
				header('location: ' . $this->registry['conf']['rooturl_cms'].'productattribute/index/permission/add');
				exit();
			}
		}

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['productattributeAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);

                if($pcid > 0)
				{
					$formData['fpcid'] = $pcid;
					$productcategory = new Core_Productcategory($formData['fpcid']);
				}

				if($pgaid > 0)
				{
					$formData['fpgaid'] = $pgaid;
					$groupattribute = new Core_ProductGroupAttribute($formData['fpgaid']);
				}

				if($this->addActionValidator($formData, $error))
				{
					$myProductAttribute = new Core_ProductAttribute();

					$myProductAttribute->uid = $this->registry->me->id;
					$myProductAttribute->pgaid = $formData['fpgaid'];
					$myProductAttribute->pcid = $formData['fpcid'];
					$myProductAttribute->name = $formData['fname'];
					$myProductAttribute->link = $formData['flink'];
					$myProductAttribute->status = $formData['fstatus'];
					$myProductAttribute->displayorder = $formData['fdisplayorder'];

					if($myProductAttribute->addData())
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('productattribute_add', $myProductAttribute->id, array());
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}

            }

		}

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


		$_SESSION['productattributeAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'productcategoryList' =>$productcategoryList,
												'productcategory' => $productcategory,
												'groupattribute' => $groupattribute,
												'statusList' => Core_ProductAttribute::getStatusList(),
												));
		if($pcid > 0 && $pgaid > 0)
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addattribute.tpl');
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
		$myProductAttribute = new Core_ProductAttribute($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductAttribute->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myProductAttribute->uid;
			$formData['fpgaid'] = $myProductAttribute->pgaid;
			$formData['fpcid'] = $myProductAttribute->pcid;
			$formData['fid'] = $myProductAttribute->id;
			$formData['fname'] = $myProductAttribute->name;
			$formData['flink'] = $myProductAttribute->link;
			$formData['fstatus'] = $myProductAttribute->status;
			$formData['fdisplayorder'] = $myProductAttribute->displayorder;
			$formData['fdatecreated'] = $myProductAttribute->datecreated;
			$formData['fdatemodified'] = $myProductAttribute->datemodified;

			if($this->registry->me->id != 1) // khong phai la admin
			{
				//get permission category
				$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');

				//check permission edit
				$permissionList = array();
				foreach($permissionCat as $permission)
				{
					$permissionList[] = new Core_Productcategory($permission->pcid);
					$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
					foreach($subList as $sub)
					{
						$permissionList[] = $sub;
					}
				}

				for($i = 0, $counter = count($permissionList) ; $i < $counter ; $i++)
				{
					if($permissionList[$i]->id == $formData['fpcid'])
					{
						$permissionEidts = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $formData['fpcid']) , 'id' , 'ASC');

						if(count($permissionEidts) == 0)
						{
							$permissionEidts = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $permissionList[$i]->parentid) , 'id' , 'ASC');
						}
					}
				}


				if(count($permissionEidts) > 0)
				{
					foreach($permissionEidts as $pEdit)
					{
						if($pEdit->permissionattribute < Core_RelProductcategoryUser::PERMISSION_EDIT)
						{
							header('location: ' . $this->registry['conf']['rooturl_cms'].'productattribute/index/permission/edit');
						}
						break;
					}
				}
				else
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'productattribute/index/permission/edit');
					exit();
				}
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productattributeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myProductAttribute->pgaid = $formData['fpgaid'];
						$myProductAttribute->pcid = $formData['fpcid'];
						$myProductAttribute->name = $formData['fname'];
						$myProductAttribute->link = $formData['flink'];
						$myProductAttribute->status = $formData['fstatus'];
						$myProductAttribute->displayorder = $formData['fdisplayorder'];

                        if($myProductAttribute->updateData())
                        {
                        	$formData['fisfilter'] = $myProductAttribute->isfilter;
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productattribute_edit', $myProductAttribute->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}

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

			$productAttributeGroupList = array();
			if($formData['fpcid'] > 0)
			{
				$productAttributeGroupList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $formData['fpcid']) , '','');
			}

			$_SESSION['productattributeEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'productcategoryList' => $productcategoryList,
													'productAttributeGroupList' => $productAttributeGroupList,
													'statusList' => Core_ProductAttribute::getStatusList(),
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

	function changegroupAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myProductAttribute = new Core_ProductAttribute($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductAttribute->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myProductAttribute->uid;
			$formData['fpgaid'] = $myProductAttribute->pgaid;
			$formData['fpcid'] = $myProductAttribute->pcid;
			$formData['fid'] = $myProductAttribute->id;
			$formData['fname'] = $myProductAttribute->name;
			$formData['flink'] = $myProductAttribute->link;
			$formData['fstatus'] = $myProductAttribute->status;
			$formData['fdisplayorder'] = $myProductAttribute->displayorder;
			$formData['fdatecreated'] = $myProductAttribute->datecreated;
			$formData['fdatemodified'] = $myProductAttribute->datemodified;


			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productattributeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    $myProductAttribute->pgaid = $formData['fpgaid'];

                    if($myProductAttribute->updateData())
                    {
                        $formData['fisfilter'] = $myProductAttribute->isfilter;
                        $success[] = $this->registry->lang['controller']['succUpdate'];
                        $this->registry->me->writelog('productattribute_edit', $myProductAttribute->id, array());
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errUpdate'];
                    }
                }


			}


			$productAttributeGroupList = array();
			if($formData['fpcid'] > 0)
			{
				$productAttributeGroupList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $formData['fpcid']) , '','');
			}

			$_SESSION['productattributeEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'productAttributeGroupList' => $productAttributeGroupList,
													'statusList' => Core_ProductAttribute::getStatusList(),
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'changegroup.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerContainer. 'changegroup.tpl');
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
		$myProductAttribute = new Core_ProductAttribute($id);
		if($myProductAttribute->id > 0)
		{
			//khong phai la admin
			if($this->registry->me->groupid != 1)
			{
				//get permission category
				$permissionCat = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid' => $this->registry->me->id),'id', 'ASC');
				//check permission delete
				$permissionList = array();
				foreach($permissionCat as $permission)
				{
					$permissionList[] = new Core_Productcategory($permission->pcid);
					$subList = Core_Productcategory::getProductcategorys(array('fparentid'=>$permission->pcid), 'id' ,'ASC');
					foreach($subList as $sub)
					{
						$permissionList[] = $sub;
					}
				}

				for($i = 0, $counter = count($permissionList) ; $i < $counter ; $i++)
				{
					if($permissionList[$i]->id == $myProductAttribute->pcid)
					{
						$permissionDeletes = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $permissionList[$i]->id) , 'id' , 'ASC');
						if(count($permissionDeletes) == 0)
						{
							$permissionDeletes = Core_RelProductcategoryUser::getRelProductcategoryUsers(array('fuid'=>$this->registry->me->id , 'fpcid'=> $permissionList[$i]->parentid) , 'id' , 'ASC');
						}
					}
				}

				if(count($permissionDeletes) > 0)
				{
					foreach($permissionDeletes as $pDelete)
					{
						if($pDelete->permissionattribute < Core_RelProductcategoryUser::PERMISSION_DELETE)
						{
							header('location: ' . $this->registry['conf']['rooturl_cms'].'productattribute/index/permission/delete');
							exit();
						}
						else
						{
							//tien hanh xoa
							if($myProductAttribute->delete())
							{
								$redirectMsg = str_replace('###id###', $myProductAttribute->id, $this->registry->lang['controller']['succDelete']);

								$this->registry->me->writelog('productattribute_delete', $myProductAttribute->id, array());
							}
							else
							{
								$redirectMsg = str_replace('###id###', $myProductAttribute->id, $this->registry->lang['controller']['errDelete']);
							}
						}
					}
				}
				else
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'productattribute/index/permission/delete');
					exit();
				}
			}
			else
			{
				//tien hanh xoa
				if($myProductAttribute->delete())
				{
					$redirectMsg = str_replace('###id###', $myProductAttribute->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('productattribute_delete', $myProductAttribute->id, array());
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myProductAttribute->id, $this->registry->lang['controller']['errDelete']);
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

	public function editattributeinlineAction()
	{
		$paid = $_POST['id'];
		$pcid = (int)$_POST['fpcid'];
		$pgaid = (int)$_POST['fpgaid'];
		$name = (string)$_POST['value'];
		$description = (string)$_POST['description'];
		$weight = (int)$_POST['weight'];
		$result = '';

		if(preg_match('/^[0-9]+_pa$/', $paid))
		{
			$arr = explode('_', $paid);
			$pgaid = $arr[0];
			$paid = 0;
		}

		//echo $paid;

		if($pcid > 0 && $pgaid > 0)
		{
			if($paid == 0)
			{
				if(strlen($name) > 0)
				{
					$myProductAttribute = new Core_ProductAttribute();

					$myProductAttribute->uid = $this->registry->me->id;
					$myProductAttribute->pgaid = $pgaid;
					$myProductAttribute->pcid = $pcid;
					$myProductAttribute->name = Helper::plaintext($name);
					$myProductAttribute->description = Helper::xss_clean($description);
					//$myProductAttribute->link = $formData['flink'];
					//$myProductAttribute->status = $formData['fstatus'];
					//$myProductAttribute->displayorder = $formData['fdisplayorder'];
					$myProductAttribute->status = Core_ProductAttribute::STATUS_ENABLE;
					$myProductAttribute->weightrecommand = $weight;

					if($myProductAttribute->addData() >0)
					{
						$this->registry->me->writelog('productattribute_add', $myProductAttribute->id, array());
						$result = $myProductAttribute->id . ':' . $myProductAttribute->name;
					}
				}
			}
			else if($paid > 0)
			{
				$myProductAttribute = new Core_ProductAttribute($paid);
				$myProductAttribute->uid = $this->registry->me->id;
				$myProductAttribute->pgaid = $pgaid;
				$myProductAttribute->pcid = $pcid;
				$myProductAttribute->name = Helper::plaintext($name);
				$myProductAttribute->description = Helper::xss_clean($description);
				//$myProductAttribute->link = $formData['flink'];
				//$myProductAttribute->status = $formData['fstatus'];
				//$myProductAttribute->displayorder = $formData['fdisplayorder'];
				$myProductAttribute->status = Core_ProductAttribute::STATUS_ENABLE;
				$myProductAttribute->weightrecommand = $weight;

				if($myProductAttribute->updateData())
				{
					$this->registry->me->writelog('productattribute_edit', $myProductAttribute->id, array());
					$result =  $myProductAttribute->id . ':' . $myProductAttribute->name . ':update';
				}
			}
		}
		else
		{
			if($paid > 0)
			{
				$myProductAttribute = new Core_ProductAttribute($paid);

				if(strlen($name) > 0)
				{
					$myProductAttribute->uid = $this->registry->me->id;
					$myProductAttribute->pgaid = $pgaid;
					$myProductAttribute->pcid = $pcid;
					$myProductAttribute->name = Helper::plaintext($name);
					$myProductAttribute->description = Helper::xss_clean($description);
					//$myProductAttribute->link = $formData['flink'];
					//$myProductAttribute->status = $formData['fstatus'];
					//$myProductAttribute->displayorder = $formData['fdisplayorder'];
					$myProductAttribute->status = Core_ProductAttribute::STATUS_ENABLE;
					$myProductAttribute->weightrecommand = $weight;

					if($myProductAttribute->updateData())
					{
						$this->registry->me->writelog('productattribute_edit', $myProductAttribute->id, array());
						$result =  $myProductAttribute->id . ':' . $myProductAttribute->name . ':update';
					}
				}
				else
					$result = $myProductAttribute->id . ':' . $myProductAttribute->name .':error';
			}
			else
				$result = 'pgaid';
		}
		echo $result;

	}

	public function editproductattributeajaxAction()
	{
		$pcid = (int)$_POST['pcid'];
		$name = (string)$_POST['name'];
		$displayorder = (string)$_POST['displayorder'];
		$datatype = (int)$_POST['datatype'];
		$unit = (string)$_POST['unit'];
		$gpaid = (int)$_POST['gpaid'];
		$type = (string)$_POST['type'];
		$paid = (int)$_POST['id'];
		$description = (string)$_POST['description'];
		$weight = (int)$_POST['weight'];

		if($gpaid > 0)
		{
			$mygroupattribute = new Core_ProductGroupAttribute($gpaid);
		}

		if($paid > 0)
		{
			$attribute = new Core_ProductAttribute($paid);

		}

		if((($pcid == $mygroupattribute->pcid) && ($name != '')) || ($pcid == $attribute->pcid) && ($name != ''))
		{
			switch ($type) {
				//add new attribute
				case 'add':
					$attribute = new Core_ProductAttribute();
					$attribute->pcid = $pcid;
					$attribute->name = $name;
					$attribute->datatype = $datatype;
					$attribute->pgaid = $gpaid;
					$attribute->uid = $this->registry->me->id;
					$attribute->unit = $unit;
					$attribute->description = $description;
					$attribute->status = Core_ProductAttribute::STATUS_ENABLE;
					$attribute->displayorder = $displayorder;
					$attribute->weightrecommand = $weight;

					if($attribute->addData() > 0)
					{
						echo $attribute->id;
					}
					else
					{
						echo 0;
					}

					break;
				case 'edit' :
					if($attribute->id > 0)
					{
						$attribute->name = $name;
						$attribute->datatype = $datatype;
						$attribute->unit = $unit;
						$attribute->description = $description;
						$attribute->displayorder = $displayorder;
						$attribute->weightrecommand = $weight;

						if($attribute->updateData())
							echo $attribute->id;
						else
							echo 0;
					}
					else
					{
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

	public function deleteattributeajaxAction()
	{
		$result = '';
		$paid = (int)$_POST['id'];
		$pa = new Core_ProductAttribute($paid);
		if($pa->id > 0)
		{
			if($pa->delete() > 0)
			{
				$result = 'success';
			}
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



		if($formData['fpgaid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPgaidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpcid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPcidMustGreaterThanZero'];
			$pass = false;
		}

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



		if($formData['fpgaid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPgaidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpcid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPcidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		return $pass;
	}
}


