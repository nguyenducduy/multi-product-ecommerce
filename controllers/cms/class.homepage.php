<?php

Class Controller_Cms_Homepage Extends Controller_Cms_Base
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

		$permission     = (string)$this->registry->router->getArg('permission');
		switch ($permission)
		{
			case 'error':
				$error[] = $this->registry->lang['controller']['errAccess'];
				break;
		}

		$categoryFilter = (int)($this->registry->router->getArg('category'));
		$inputtypeFilter = (int)($this->registry->router->getArg('inputtype'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$listidFilter = (int)($this->registry->router->getArg('listid'));
		$idFilter = (int)($this->registry->router->getArg('id'));


		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'displayorder';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') 
			$sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;

		$checker = false;
		//checker permission of user
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			//create suffix
            $suffix = 'hview_1';
            $checker = $this->checkAccessTicket($suffix);
		}
		else
		{
			$checker = true;
		}

		if(!$checker)
		{
			header('location: ' . $this->registry['conf']['rooturl_cms']);
			exit();
		}

		if(!empty($_POST['fsubmitbulk']))
		{
            	if($_SESSION['homepageBulkToken']==$_POST['ftoken'])
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
                            	$myHomepage = new Core_Homepage($id);

                            	if($myHomepage->id > 0)
                            	{
                               		//tien hanh xoa
                                	if($myHomepage->delete())
                                	{
                                    	$deletedItems[] = $myHomepage->id;
                                    	$this->registry->me->writelog('homepage_delete', $myHomepage->id, array());
                                	}
                                	else
                                    	$cannotDeletedItems[] = $myHomepage->id;
                            	}
                            	else
                                	$cannotDeletedItems[] = $myHomepage->id;
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

		//cap nhat thu tu hien thi cua product
		if(!empty($_POST['fsubmitchangeorderproduct']))
		{
			$ok = false;
			$formData['forderproduct'] = $_POST['forderproduct'];
			foreach($formData['forderproduct'] as $id => $values)
			{
				$producthomepage = new Core_Homepage($id);

				//sap xep thu tu hien thi
				asort($values);

				$pidlist = array();
				foreach($values as $key => $value)
				{
					$pidlist[] = $key;
				}
				$producthomepage->listid = implode(',', $pidlist);
				if($producthomepage->updateData())
				{
					$ok = true;
				}

			}

			if($ok)
			{
				$success[] = $this->registry->lang['controller']['succDisplayorder'];
			}
			else
			{
				$error[] = $this->registry->lang['controller']['errDisplayorder'];
			}

		}

		//cap nhat thu tu hien thi cua promotion
		if(!empty($_POST['fsubmitchangeorderpromotion']))
		{
			$ok = false;
			$formData['forderpromotion'] = $_POST['forderpromotion'];
			foreach($formData['forderpromotion'] as $id => $values)
			{
				$producthomepage = new Core_Homepage($id);

				//sap xep thu tu hien thi
				asort($values);

				$pidlist = array();
				foreach($values as $key => $value)
				{
					$pidlist[] = $key;
				}

				$producthomepage->listid = implode(',', $pidlist);
				if($producthomepage->updateData())
				{
					$ok = true;
				}
			}

			if($ok)
				{
					$success[] = $this->registry->lang['controller']['succDisplayorder'];
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errDisplayorder'];
				}
		}

		//cap nhat thu tu hien thi cua promotion
		if(!empty($_POST['fsubmitchangeordernews']))
		{
			$ok = false;
			$formData['fordernews'] = $_POST['fordernews'];
			foreach($formData['fordernews'] as $id => $values)
			{
				$producthomepage = new Core_Homepage($id);

				//sap xep thu tu hien thi
				asort($values);

				$pidlist = array();
				foreach($values as $key => $value)
				{
					$pidlist[] = $key;
				}

				$producthomepage->listid = implode(',', $pidlist);
				if($producthomepage->updateData())
				{
					$ok = true;
				}
			}

			if($ok)
				{
					$success[] = $this->registry->lang['controller']['succDisplayorder'];
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errDisplayorder'];
				}
		}

		//cap nhat subcategory cua danh muc
		if(isset($_POST['fupdatesubcat']))
		{
			$ok = false;
			$formData['fsubcat'] = $_POST['fsubcat'];
			$formData['fdisplayorder'] = $_POST['fdisplayorder'];
			$formData['fblockhomepage'] = $_POST['fblockhomepage'];		
			$formData['fblockbannerright']	= $_POST['fblockbannerright'];
			foreach ($formData['fsubcat'] as $hid => $value)
			{
				$homepage = new Core_Homepage($hid);
				$homepage->subcategory = $value;
				$homepage->displayorder = $formData['fdisplayorder'][$hid];				
				$homepage->blockhomepage = Helper::xss_clean($formData['fblockhomepage'][$hid]);
				$homepage->blockbannerright = Helper::xss_clean($formData['fblockbannerright'][$hid]);				
				if($homepage->updateData())
				{
					$ok = true;
					//Chuyen image trong blockbannerright sang con server 40
					$urlcron = $this->registry->conf['rooturl']."task/externalimagedownload/imagehomepagedownloadbyid?id=".$hid;
                    Helper::backgroundHttpGet($urlcron);
				}
			}
			if($ok)
			{
				$success[] = 'Cập nhật thông tin thành công.';
			}
			else
			{
				$error[] = 'Cập nhật thông tin không thành công';
			}
		}
		
		////CAP NHAT TOP SAN PHAM BAN CHAT
		if(isset($_POST['fsubmittopsell']))
		{
			$ok = false;
			$formData = array_merge($formData, $_POST);
			if(count($formData['ftopselldisplayorder']) > 0)
			{
				///SORT DISPLAY
				asort($formData['ftopselldisplayorder']);
				
				$topselllist = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_TOPSELL) , 'id' , 'ASC');
				if(count($topselllist) > 0)
				{
					$topselldata = $topselllist[0];
					$producttoplist = array_keys($formData['ftopselldisplayorder']);
					$topselldata->topselllist = implode(',' , $producttoplist);
					
					if($topselldata->updateData())
					{
						$ok = true;
					}
				}
				else
				{
					$topselldata = new Core_Homepage();
					$topselldata->type = Core_Homepage::TYPE_TOPSELL;
					$producttoplist = array_keys($formData['ftopselldisplayorder']);
					$topselldata->topselllist = implode(',' , $producttoplist);
					
					if($topselldata->addData() > 0)
					{
						$ok = true;
					}
				}
			}
			else
			{
				$ok = true;
			}
			
			if($ok)
			{
				$success[] = 'Cập nhật thông tin thành công.';
			}
			else
			{
				$error[] = 'Cập nhật thông tin không thành công';
			}
		}

		$_SESSION['homepageBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($categoryFilter > 0)
		{
			$paginateUrl .= 'category/'.$categoryFilter . '/';
			$formData['fcategory'] = $categoryFilter;
			$formData['search'] = 'category';
		}

		if($inputtypeFilter > 0)
		{
			$paginateUrl .= 'inputtype/'.$inputtypeFilter . '/';
			$formData['finputtype'] = $inputtypeFilter;
			$formData['search'] = 'inputtype';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($listidFilter > 0)
		{
			$paginateUrl .= 'listid/'.$listidFilter . '/';
			$formData['flistid'] = $listidFilter;
			$formData['search'] = 'listid';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		//check role of user
		//echodebug($this->registry->me->id,true);
		$catlist = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCT , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false);
			if(count($roleusers) > 0)
			{
				foreach($roleusers as $roleuser)
				{
					$parentcategories = Core_Productcategory::getFullParentProductCategorys($roleuser->objectid);
					if(count($parentcategories) > 0)
					{
						$rootcategory = $parentcategories[0];
						if(!in_array($rootcategory['pc_id'].'-p', $catlist) || count($catlist) == 0)
						{
							$catlist[$rootcategory['pc_id'].'-p'] = $rootcategory['pc_id'];
						}
					}
				}
			}
		}

		$rolepromotion = true;

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if(Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCTPROMOTION , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', true,true) == 0)
			{
				$rolepromotion = false;
			}
			
			//special category
			$catlist['1782-p'] = 1782;
			$formData['fcategoryarr'] = $catlist;
		}

		//check role of promotion
		/*if(Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCTPROMOTION , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', true,true) > 0)
		{
			$catlist[] = 0;
		}*/			
				

		//tim tong so
		// $total = Core_Homepage::getHomepages($formData, $sortby, $sorttype, 0, true);
		// $totalPage = ceil($total/$this->recordPerPage);
		// $curPage = $page;


		//get latest account
		//$homepages = Core_Homepage::getHomepages($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		$homepages = Core_Homepage::getHomepages($formData, $sortby, $sorttype);
		$productcategoryhomepagelist = array();
		$homepageproduct = array();
		$homepagepromotion = array();
		$homepagenews = array();
		if(count($homepages) > 0)
		{
			foreach ($homepages as $homepage)
			{
				$homepage->categoryactor = new Core_Productcategory($homepage->category);
				switch ($homepage->type)
				{
					case Core_Homepage::TYPE_PRODUCT :
						$idlist = explode(',', $homepage->listid);
						for($i = 0 ; $i < count($idlist) ; $i++)
						{
							$product = new Core_Product($idlist[$i]);
							$product->sellprice = Helper::formatPrice($product->sellprice);
							$homepage->objectlist[] = $product;
						}
						$homepageproduct[] = $homepage;
						break;
				}

				$productcategoryhomepagelist[$homepage->id] = explode(',', $homepage->subcategory);
			}
		}		

		//get news of homepage
		$idnewslist = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_NEWS) , 'id' , 'ASC');
		if(count($idnewslist) > 0)
		{
			foreach ($idnewslist as $idnews)
			{
				$idlist = explode(',', $idnews->listid);
				for($i = 0 ; $i < count($idlist) ; $i++)
				{
					$news = new Core_News($idlist[$i]);
					$idnews->objectlist[] = $news;
				}
				$homepagenews[] = $idnews;
			}
		}

		//get promotion if user have role
		if($rolepromotion)
		{
			$idpromotionlist = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_PROMOTION) , 'id' , 'ASC');

			if(count($idpromotionlist) > 0)
			{
				foreach ($idpromotionlist as $idpromotion)
				{
					$idlist = explode(',', $idpromotion->listid);
					for($i = 0 ; $i < count($idlist) ; $i++)
					{
						$promotion = new Core_Product($idlist[$i]);
						$idpromotion->objectlist[] = $promotion;
					}
					$homepagepromotion[] = $idpromotion;
				}
			}
		}

		////GET TOPSELL PRODUCT IN HOMEPAGE
		$topsellinfos = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_TOPSELL) , 'id' , 'ASC');
		$topsellproducts = array();
		if(count($topsellinfos) > 0)
		{
			$topsellinfo = $topsellinfos[0];			
			$idlist = explode(',', $topsellinfo->topselllist);
			foreach ($idlist as $id) 
			{
				 if((int)$id > 0)
				 {
				 	$product = new Core_Product($id , true);
					$product->categoryactor = new Core_Productcategory($product->pcid , true);
					$topsellproducts[] = $product;
				 }
			}
		}
			

		/////GET FULL CATEGORY
		$productcategorylist = array();
		$list = Core_Productcategory::getFullCategoryList();

		foreach ($list as $productcategory) 
		{
			switch ($productcategory->level) 
			{
				case 2 : $productcategory->name = '&nbsp;&nbsp;' . $productcategory->name;
					break;

				case 3 : $productcategory->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $productcategory->name;
					break;
			}

			$productcategorylist[] = $productcategory;
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


		$this->registry->smarty->assign(array(	'homepages' 	=> $homepages,
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
												'homepageproduct' => $homepageproduct,
												'homepagepromotion' => $homepagepromotion,
												'homepagenews' => $homepagenews,
												'promotionhomeid' => $homepagepromotion[0]->id,
												'typeList' => Core_Homepage::getTypeList(),
												'rolepromotion' => $rolepromotion,
												'topsellproducts' => $topsellproducts,
												'productcategorylist' => $productcategorylist,
												'productcategoryhomepagelist' => $productcategoryhomepagelist,
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



		if($this->registry->router->getArg('type') > 0)
		{
			$formData['type'] = (int)$this->registry->router->getArg('type');
			$formData['typename'] = Core_Homepage::getTypeNames($formData['type']);
			if($formData['type'] == Core_Homepage::TYPE_PROMOTION)
			{
				if(!$this->registry->me->isGroup('administrator')&&!$this->registry->me->isGroup('developer'))
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTPROMOTION,$this->registry->me->id,0,0,0,Core_RoleUser::STATUS_ENABLE);
					if(!$checker)
					{
						header('location: '.$this->registry['conf']['rooturl_cms'].'/homepage/index/permission/error');
					}
				}
			}
		}

		if(!empty($_POST['fsubmitNext']))
		{
			$type = (int)$_POST['ftype'];
			if($type > 0)
			{
				$formData['type'] = $type;
				header('location: '. $this->registry['conf']['rooturl_cms'].'homepage/add/type/'.$type);
			}
			else
			{
				$error = $this->registry->lang['controller']['errTypeMustGreaterThanZero'];
			}
		}


		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['homepageAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);

                if($this->addActionValidator($formData, $error))
                {

                    $myHomepage = new Core_Homepage();


					$myHomepage->category = $formData['fcategory'];
					$myHomepage->inputtype = $formData['finputtype'];
					$myHomepage->type = $formData['ftype'];
					$myHomepage->listid = implode(',', $formData['listid']);

                    if($myHomepage->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('homepage_add', $myHomepage->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		if($formData['type'] == Core_Homepage::TYPE_PRODUCT || $formData['type'] == Core_Homepage::TYPE_PROMOTION)
		{
			$catlist = array();
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCT , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
				if(count($roleusers) > 0)
				{
					foreach($roleusers as $roleuser)
					{
						$parentcategories = Core_Productcategory::getFullParentProductCategorys($roleuser->objectid);

						$rootcategory = $parentcategories[0];
						if(!in_array($rootcategory['pc_id'], $catlist) || count($catlist) == 0)
						{
							$catlist[$rootcategory['pc_id']] = $rootcategory['pc_id'];
						}
					}
				}
			}

			if(count($catlist) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
			{
				$productcategoryList = Core_Productcategory::getProductcategorys(array('fparent'=>1 , 'fidarr' => $catlist) , 'id' , 'ASC');
			}
		}

		if($formData['type'] == Core_Homepage::TYPE_NEWS)
		{
			$catlist = array();
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_NEWS , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
				if(count($roleusers) > 0)
				{
					foreach($roleusers as $roleuser)
					{
						$parentcategories = Core_Newscategory::getFullParentNewsCategorys($roleuser->objectid);
						//echodebug($parentcategories);
						$rootcategory = $parentcategories[0];
						if(!in_array($rootcategory['nc_id'], $catlist) || count($catlist) == 0)
						{
							$catlist[$rootcategory['nc_id']] = $rootcategory['nc_id'];
						}
					}
				}
			}
			if(count($catlist) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
			{
				$newscategoryList = Core_Newscategory::getNewscategorys(array('fparentid' => 0) , 'id' , 'ASC');
			}
		}

		$_SESSION['homepageAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'typeList'		=> Core_Homepage::getTypeList(),
												'productcategoryList' => $productcategoryList,
												'newscategoryList' => $newscategoryList,
												));
		if($formData['type'] == 0)
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		}
		elseif($formData['type'] == Core_Homepage::TYPE_PRODUCT)
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addproducthomepage.tpl');
		}
		elseif ($formData['type'] == Core_Homepage::TYPE_PROMOTION)
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addpromotionhomepage.tpl');
		}
		elseif($formData['type'] == Core_Homepage::TYPE_NEWS)
		{
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addnewshomepage.tpl');
		}

		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myHomepage = new Core_Homepage($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myHomepage->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myHomepage->id;
			$formData['fcategory'] = $myHomepage->category;
			$formData['fcategoryold'] = $myHomepage->category;
			$formData['finputtype'] = $myHomepage->inputtype;
			$formData['ftype'] = $myHomepage->type;
			$formData['typename'] = $myHomepage->getTypeName();
			$formData['flistid'] = explode(',', $myHomepage->listid);
			$formData['fobjectidlist'] = array();


			if($formData['ftype'] == Core_Homepage::TYPE_PROMOTION)
			{
				if(!$this->registry->me->isGroup('administrator')&&!$this->registry->me->isGroup('developer'))
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTPROMOTION,$this->registry->me->id,0,0,0,Core_RoleUser::STATUS_ENABLE);
					if(!$checker)
					{
						header('location: '.$this->registry['conf']['rooturl_cms'].'/homepage/index/permission/error');
					}
				}
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['homepageEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    if($this->editActionValidator($formData, $error))
                    {

						$myHomepage->category = $formData['fcategory'];
						$myHomepage->inputtype = $formData['finputtype'];
						$myHomepage->type = $formData['ftype'];
						$myHomepage->listid = implode(',', $formData['flistid']);

                        if($myHomepage->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('homepage_edit', $myHomepage->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}

			switch ($formData['ftype'])
			{
				case Core_Homepage::TYPE_PRODUCT:
					for($i = 0 ; $i < count($formData['flistid']) ;$i++)
					{
						if($formData['flistid'][$i] > 0)
						{
							$product = new Core_Product($formData['flistid'][$i]);
							$product->categoryactor = new Core_Productcategory($product->pcid);
							$product->sellprice = Helper::formatPrice($product->sellprice);
							$formData['fobjectidlist'][] = $product;
						}
					}
					break;

				case Core_Homepage::TYPE_PROMOTION:
					for($i = 0 ; $i < count($formData['flistid']) ;$i++)
					{
						if($formData['flistid'][$i] > 0)
						{
							$promotion = new Core_Product($formData['flistid'][$i]);
							$promotion->sellprice = Helper::formatPrice($promotion->sellprice);
							$formData['fobjectidlist'][] = $promotion;
						}
					}
					break;

				case Core_Homepage::TYPE_NEWS:
					for($i = 0 ; $i < count($formData['flistid']) ;$i++)
					{
						if($formData['flistid'] > 0)
						{
							$news = new Core_News($formData['flistid'][$i]);
							$formData['fobjectidlist'][] = $news;
						}
					}
					break;

			}

			$_SESSION['homepageEditToken'] = Helper::getSecurityToken();//Tao token moi

			if($formData['ftype'] == Core_Homepage::TYPE_PRODUCT || $formData['ftype'] == Core_Homepage::TYPE_PROMOTION)
			{
				$catlist = array();
				if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
				{
					$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCT , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
					if(count($roleusers) > 0)
					{
						foreach($roleusers as $roleuser)
						{
							$parentcategories = Core_Productcategory::getFullParentProductCategorys($roleuser->objectid);

							$rootcategory = $parentcategories[0];
							if((!in_array($rootcategory['pc_id'], $catlist) || count($catlist) == 0) && (int)$rootcategory['pc_id'] != 0)
							{
								$catlist[] = $rootcategory['pc_id'];
							}
						}
					}
				}

				if(count($catlist) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
				{
					$productcategoryList = Core_Productcategory::getProductcategorys(array('fparent'=>1 , 'fidarr' => $catlist) , 'id' , 'ASC');

				}
			}

			if($formData['ftype'] == Core_Homepage::TYPE_NEWS)
			{
				$catlist = array();
				if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
				{
					$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_NEWS , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
					if(count($roleusers) > 0)
					{
						foreach($roleusers as $roleuser)
						{
							$parentcategories = Core_Newscategory::getFullParentNewsCategorys($roleuser->objectid);
							//echodebug($parentcategories);
							$rootcategory = $parentcategories[0];
							if(!in_array($rootcategory['nc_id'], $catlist) || count($catlist) == 0)
							{
								$catlist[$rootcategory['nc_id']] = $rootcategory['nc_id'];
							}
						}
					}
				}
				if(count($catlist) > 0 || $this->registry->me->isGroup('administrator')|| $this->registry->me->isGroup('developer'))
				{
					$newscategoryList = Core_Newscategory::getNewscategorys(array('fparentid' => 0) , 'id' , 'ASC');
				}
			}

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'productcategoryList' => $productcategoryList,
													'newscategoryList' => $newscategoryList,
													));
			if($formData['ftype'] == Core_Homepage::TYPE_PRODUCT)
			{
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'editproducthomepage.tpl');
			}
			elseif ($formData['ftype'] == Core_Homepage::TYPE_PROMOTION)
			{
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'editpromotionhomepage.tpl');
			}
			elseif($formData['ftype'] == Core_Homepage::TYPE_NEWS)
			{
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'editnewshomepage.tpl');
			}
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
		$myHomepage = new Core_Homepage($id);
		if($myHomepage->id > 0)
		{
			if($myHomepage->type == Core_Homepage::TYPE_PROMOTION)
			{
				if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTPROMOTION,$this->registry->me->id,0,0,0,Core_RoleUser::STATUS_ENABLE);
					if(!$checker)
					{
						header('location: '.$this->registry['conf']['rooturl_cms'].'/homepage/index/permission/error');
						exit();
					}
					else
					{
						//tien hanh xoa
						if($myHomepage->delete())
						{
							$redirectMsg = str_replace('###id###', $myHomepage->id, $this->registry->lang['controller']['succDelete']);

							$this->registry->me->writelog('homepage_delete', $myHomepage->id, array());
						}
						else
						{
							$redirectMsg = str_replace('###id###', $myHomepage->id, $this->registry->lang['controller']['errDelete']);
						}
					}
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


	public function deleteajaxAction()
	{
		$id = (int)$_POST['id'];
		$pid = (int)$_POST['pid'];
		$type = (int)$_POST['type'];
		$newlist = array();

		$homepage = new Core_Homepage($id);

		if($homepage->id > 0 && $pid > 0 && $type > 0)
		{
			$oldlist = explode(',', $homepage->listid);
			if(count($oldlist) > o)
			{
				foreach($oldlist as $old)
				{
					if($old != $pid)
					{
						$newlist[] = $old;
					}
				}

				if(count($newlist) > 0)
				{
					$homepage->listid = implode(',', $newlist);
				}
				else
				{
					$homepage->listid = '';
				}

				if($homepage->updateData())
				{
					echo 'success';
				}
			}
		}
	}

	public function loadproductajaxAction()
	{
		$html = '';
        $keywordsearch = (string)$_POST['keywordsearch'];
        $categorysearch = (int)$_POST['categorysearch'];
        if(strlen($keywordsearch) > 0)
        {        	
            $products = Core_Product::getProducts(array('fgeneralkeyword' => $keywordsearch , 'fpcid' => $categorysearch , 'fcustomizetype' => Core_Product::CUSTOMIZETYPE_MAIN) , 'id' , 'ASC');
            if(count($products) > 0)
            {            	
				$html .=  '<h1>Danh sách sản phẩm</h1><table class="table table-striped"><thead><th>Hình ảnh</th><th>Id</th><th>Barcode</th><th>Tên sản phẩm</th><th>Danh mục</th><th>Giá</th><th>Số lượng</th><th></th></thead><tbody>';
				foreach($products as $product)
				{
					if($product->id > 0)
					{
						$product->categoryactor = new Core_Productcategory($product->pcid);
						$html .= '<tr id="rows'.$product->id.'">';
						$html .= '<td>';
						if($product->image != '')
						{
							$html .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="100px;" height="100px;" /></a>';
						}
						$html .= '</td>';						
						$html .= '<td id="pid_'.$product->id.'">'.$product->id.'</td>';
						$html .= '<td id="pbarcode_'.$product->id.'">'.$product->barcode.'</td>';
						$html .= '<td id="names_'.$product->id.'">'.$product->name.'</td>';
						$html .= '<td id="categorys_'.$product->id.'"><span class="label label-info">'.$product->categoryactor->name.'</span></td>';
						$html .= '<td id="prices_'.$product->id.'">'.Helper::formatPrice($product->sellprice) . ' ' . $this->registry->lang['controller']['labelCurrency'] . '</td>';
						$html .= '<td id="instocks_'.$product->id.'">'.$product->instock . '</td>';
						$html .= '<td><input class="btn btn-success" type="button" id="fchoose_'.$product->id.'" onclick="chooseFunction('.$product->id.')" value="Choose" /></td>';
						$html .= '</tr>';
					}
				}
				$html .= '</tbody></table>';

            }
            else
            {
            	echo '0';
            }
        }
        else
        {
            $html = '-1';
        }

        echo $html;
	}    


	public function loadpromotionajaxAction()
	{
		$barcode = (string)$_POST['barcode'];
		$name = (string)$_POST['name'];
		if($barcode != '' || $name != '')
		{
			$formData['fbarcode'] = $barcode;
			$formData['fname'] = $name;
			$formData['fquantitythan0'] = 1;
			$formData['fsyncstatus'] = Core_Product::STATUS_SYNC_FOUND;
			$formData['fpricethan0'] = 1;
			//$formData['fonsitestatus'] = Core_Product::OS_ERP;
			$products = Core_Product::getProducts($formData , 'id' , 'ASC');
			if(count($products) > 0)
			{
				$result = '';
				$result .=  '<h1>Danh sách sản phẩm</h1><table class="table table-striped"><th></th><th>Danh mục</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th></th>';
				foreach($products as $product)
				{
					if($product->id > 0)
					{
						$product->categoryactor = new Core_Productcategory($product->pcid);
						$result .= '<tr id="rows'.$product->id.'">';
						$result .= '<td>';
						if($product->image != '')
						{
							$result .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="100px;" height="100px;" /></a>';
						}
						$result .= '</td>';
						$result .= '<td id="categorys_'.$product->id.'"><span class="label label-info">'.$product->categoryactor->name.'</span></td>';
						$result .= '<td id="names_'.$product->id.'">'.$product->name.'</td>';
						$result .= '<td id="prices_'.$product->id.'">'.Helper::formatPrice($product->sellprice). ' ' . $this->registry->lang['controller']['labelCurrency'] . '</td>';
						$result .= '<td id="instocks_'.$product->id.'">'.$product->instock . '</td>';
						$result .= '<td><input class="btn btn-success" type="button" id="fchoose_'.$product->id.'" onclick="chooseFunction('.$product->id.')" value="Choose" /></td>';
						$result .= '</tr>';
					}
				}
				$result .= '</table>';

				echo $result;
			}
			else
			{
				echo $this->registry->lang['controller']['errProductNotFound'];
			}
		}
		else
		{
			echo '';
		}
	}

	public function loadnewsajaxAction()
	{
		$catid = (int)$_POST['catid'];
		$id = (string)$_POST['id'];
		$title = (string)$_POST['title'];
		if($catid > 0 && ($id != '' || $title != ''))
		{
			//lay tat ca nhung danh muc con chua danh muc san pham
			$catidList = Core_Newscategory::getFullSubCategory($catid);
			if(count($catidList) > 0)
			{
				$catlist = array();
				if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
				{
					$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_NEWS , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
					if(count($roleusers) > 0)
					{
						foreach($roleusers as $roleuser)
						{
							foreach($catidList as $catid)
							{
								if($catid == $roleuser->objectid && $catid > 0)
								{
									$formData['fncidarr'][] = $catid;
								}
							}
						}
					}
				}
				else
				{
					$formData['fncidarr'] = $catidList;
				}

				//get data
				if(count($formData['fncidarr']) > 0)
				{
					$formData['fid'] = $id;
					$formData['fstitle'] = $title;
					$newss = Core_News::getNewss($formData , 'id' , 'ASC');
					if(count($newss) > 0)
					{
						$result = '';
						$result .=  '<h1>Danh sách tin tức</h1><table class="table table-striped"><thead><tr><th></th><th>Tiêu đề</th><th>Ngày đăng</th><th></th></tr></thead>';
						foreach($newss as $news)
						{
							if($news->id > 0)
							{
								$result .= '<tr id="rows'.$news->id.'">';
								$result .= '<td>';
								if($news->image != '')
								{
									$result .= '<a href="'.$news->getSmallImage().'" rel="shadowbox"><image id="images_'.$news->id.'" src="'.$news->getSmallImage().'" width="100px;" height="100px;" /></a>';
								}
								$result .= '</td>';
								$result .= '<td id="names_'.$news->id.'">'.$news->title.'</td>';
								$result .= '<td id="date_'.$news->id.'">'. date("d/m/Y" , $news->datecreated) .'</td>';
								$result .= '<td><input class="btn btn-success" type="button" id="fchoose_'.$news->id.'" onclick="chooseFunction('.$news->id.')" value="Choose" /></td>';
								$result .= '</tr>';
							}
						}
						$result .= '</table>';


						echo $result;
					}
					else
					{
						echo $this->registry->lang['controller']['errNewsNotFound'];
					}
				}
			}
			else
			{
				echo $this->registry->lang['controller']['errNewsNotFound'];
			}
		}
		else
		{
			echo '';
		}
	}

	public function getcategoryajaxAction()
	{
		$result = '';
		$type = (int)$_POST['type'];
		if($type == Core_Homepage::TYPE_PRODUCT)
		{
			$productcategoryList = Core_Productcategory::getProductcategorys(array('fparent'=>1) , 'id' , 'ASC');
			if(count($productcategoryList) > 0)
			{
				foreach($productcategoryList as $productcategory)
				{
					$result .= '<option value="'.$productcategory->id.'">'.$productcategory->name.'</option>';
				}
			}
		}

		if($type == Core_Homepage::TYPE_NEWS)
		{
			$newscategoryList = Core_Newscategory::getNewscategorys(array('fparentid' => 0) , 'id' , 'ASC');
			foreach($newscategoryList as $newscategory)
			{
				$result .= '<option value="'.$newscategory->id.'">'.$newscategory->name.'</option>';
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



		if($formData['ftype'] != Core_Homepage::TYPE_PROMOTION)
		{
			if($formData['fcategory'] == 0)
			{
				$error[] = $this->registry->lang['controller']['errCategoryRequired'];
				$pass = false;
			}
			else
			{
				if($formData['ftype'] == Core_Homepage::TYPE_PRODUCT)
				{
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						$catlist = array();
						$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCT , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
						if(count($roleusers) > 0)
						{
							foreach($roleusers as $roleuser)
							{
								$parentcategories = Core_Productcategory::getFullParentProductCategorys($roleuser->objectid);

								$rootcategory = $parentcategories[0];
								if(!in_array($rootcategory['pc_id'], $catlist) || count($catlist) == 0)
								{
									$catlist[$rootcategory['pc_id']] = $rootcategory['pc_id'];
								}
							}
						}
						if(!in_array($formData['fcategory'], $catlist))
						{
							$error[] = $this->registry->lang['controller']['errCategoryProductValid'];
							$pass = false;
	                    	}
					}

                    if(Core_Homepage::getHomepages(array('fcategory' => $formData['fcategory'] , 'ftype' => Core_Homepage::TYPE_PRODUCT) , 'id' , 'ASC' , '' , true) > 0)
                    {
                        $error[] = $this->registry->lang['controller']['errCategoryExist'];
                        $pass = false;
                    }
				}

				if($formData['ftype'] == Core_Homepage::TYPE_NEWS)
				{
					$catlist = array();
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_NEWS , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
						if(count($roleusers) > 0)
						{
							foreach($roleusers as $roleuser)
							{
								$parentcategories = Core_Newscategory::getFullParentNewsCategorys($roleuser->objectid);
								$rootcategory = $parentcategories[0];
								if(!in_array($rootcategory['nc_id'], $catlist) || count($catlist) == 0)
								{
									$catlist[$rootcategory['nc_id']] = $rootcategory['nc_id'];
								}
							}
							if(!in_array($formData['fcategory'], $catlist))
							{
								$error[] = $this->registry->lang['controller']['errCategoryNewsValid'];
								$pass = false;
	                        }
						}
					}
					if(Core_Homepage::getHomepages(array('fcategory' => $formData['fcategory'] , 'ftype' => Core_Homepage::TYPE_NEWS) , 'id' , 'ASC' , '' , true) >0)
	                  {
	                       $error[] = $this->registry->lang['controller']['errCategoryExist'];
	                       $pass = false;
	                  }
				}
			}
		}

		// if($formData['finputtype'] == '')
		// {
		// 	$error[] = $this->registry->lang['controller']['errInputtypeRequired'];
		// 	$pass = false;
		// }

		if($formData['ftype'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errTypeRequired'];
			$pass = false;
		}

		// if($formData['flistid'] == '')
		// {
		// 	$error[] = $this->registry->lang['controller']['errListidRequired'];
		// 	$pass = false;
		// }
		if(count($formData['listid']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errProductHomepageRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['ftype'] != Core_Homepage::TYPE_PROMOTION)
		{
			if($formData['fcategory'] == 0)
			{
				$error[] = $this->registry->lang['controller']['errCategoryRequired'];
				$pass = false;
			}
			else
			{
				if($formData['ftype'] == Core_Homepage::TYPE_PRODUCT)
				{
					$catlist = array();
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCT , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
						if(count($roleusers) > 0)
						{
							foreach($roleusers as $roleuser)
							{
								$parentcategories = Core_Productcategory::getFullParentProductCategorys($roleuser->objectid);

								$rootcategory = $parentcategories[0];
								if(!in_array($rootcategory['pc_id'], $catlist) || count($catlist) == 0)
								{
									$catlist[$rootcategory['pc_id']] = $rootcategory['pc_id'];
								}
							}
						}

						if(!in_array($formData['fcategory'], $catlist))
						{
							$error[] = $this->registry->lang['controller']['errCategoryProductValid'];
							$pass = false;
						}
					}

					if($formData['fcategory'] != $formData['fcategoryold'])
					{
						if(Core_Homepage::getHomepages(array('fcategory' => $formData['fcategory'] , 'ftype' => Core_Homepage::TYPE_PRODUCT) , 'id' , 'ASC' , '' , true) > 0)
	                    {
	                        $error[] = $this->registry->lang['controller']['errCategoryExist'];
	                        $pass = false;
	                    }
					}

				}

				if($formData['ftype'] == Core_Homepage::TYPE_NEWS)
				{
					$catlist = array();
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_NEWS , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
						if(count($roleusers) > 0)
						{
							foreach($roleusers as $roleuser)
							{
								$parentcategories = Core_Newscategory::getFullParentNewsCategorys($roleuser->objectid);
								//echodebug($parentcategories);
								$rootcategory = $parentcategories[0];
								if(!in_array($rootcategory['nc_id'], $catlist) || count($catlist) == 0)
								{
									$catlist[$rootcategory['nc_id']] = $rootcategory['nc_id'];
								}
							}
						}
						if(!in_array($formData['fcategory'], $catlist))
						{
							$error[] = $this->registry->lang['controller']['errCategoryNewsValid'];;
							$pass = false;
						}
					}

					if($formData['fcategory'] != $formData['fcategoryold'])
					{
						if(Core_Homepage::getHomepages(array('fcategory' => $formData['fcategory'] , 'ftype' => Core_Homepage::TYPE_NEWS) , 'id' , 'ASC' , '' , true)>0)
	                    {
	                        $error[] = $this->registry->lang['controller']['errCategoryExist'];
	                        $pass = false;
	                    }
					}
				}
			}
		}

		// if($formData['finputtype'] == '')
		// {
		// 	$error[] = $this->registry->lang['controller']['errInputtypeRequired'];
		// 	$pass = false;
		// }

		if($formData['ftype'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errTypeRequired'];
			$pass = false;
		}

		// if($formData['flistid'] == '')
		// {
		// 	$error[] = $this->registry->lang['controller']['errListidRequired'];
		// 	$pass = false;
		// }
		if(count($formData['flistid']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errProductHomepageRequired'];
			$pass = false;
		}

		return $pass;
	}
}


