<?php

Class Controller_Cms_Vendor Extends Controller_Cms_Base
{
	private $recordPerPage = 1000;

    /**
    
    */
	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$nameFilter = (string)($this->registry->router->getArg('name'));
		$slugFilter = (string)($this->registry->router->getArg('slug'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		$typeFilter = (int)($this->registry->router->getArg('type'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['vendorBulkToken']==$_POST['ftoken'])
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
                            $myVendor = new Core_Vendor($id);

                            if($myVendor->id > 0)
                            {
                                //tien hanh xoa
                                if($myVendor->delete())
                                {
                                    $deletedItems[] = $myVendor->id;
                                    $this->registry->me->writelog('vendor_delete', $myVendor->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myVendor->id;
                            }
                            else
                                $cannotDeletedItems[] = $myVendor->id;
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
				$myItem = new Core_Vendor($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}

			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}

		$_SESSION['vendorBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($slugFilter != "")
		{
			$paginateUrl .= 'slug/'.$slugFilter . '/';
			$formData['fslug'] = $slugFilter;
			$formData['search'] = 'slug';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
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
			elseif($searchKeywordIn == 'slug')
			{
				$paginateUrl .= 'searchin/slug/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Vendor::getVendors($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$vendors = Core_Vendor::getVendors($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//get number of product
		for($i = 0 , $counter = count($vendors) ; $i < $counter ; $i++)
		{
			$numberOfProduct = Core_Product::getProducts(array('fvid'=>$vendors[$i]->id),'','','',true);
			$vendors[$i]->countproduct = $numberOfProduct;
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


		$this->registry->smarty->assign(array(	'vendors' 	=> $vendors,
												'statusList'	=> Core_Vendor::getStatusList(),
												'typeList'		=> Core_Vendor::getVendorTypeList(),
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
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		$slugList 	= array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['vendorAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);

				$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
               	//get all slug related to current slug
				if($formData['fslug'] != '')
					$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');
				

                if($this->addActionValidator($formData, $error))
                {
					$myVendor                = new Core_Vendor();
					
					
					$myVendor->image         = $formData['fimage'];
					$myVendor->name          = $formData['fname'];
					$myVendor->slug          = $formData['fslug'];
					$myVendor->content       = $formData['fcontent'];
					$myVendor->insurance     = $formData['finsurance'];
					$myVendor->type          = $formData['ftype'];
					$myVendor->status        = $formData['fstatus'];
					$myVendor->topseokeyword = $formData['ftopseokeyword'];
					$myVendor->seotitle      = $formData['fseotitle'];
					$myVendor->seodescription = $formData['fseodescription'];
					$myVendor->seokeyword    = $formData['fseokeyword'];
					$myVendor->metarobot     = $formData['fmetarobot'];
                    $myVendor->titlecol1     = $formData['ftitlecol1'];
                    $myVendor->desccol1      = $formData['fdesccol1'];
                    $myVendor->titlecol2     = $formData['ftitlecol2'];
                    $myVendor->desccol2      = $formData['fdesccol2'];
                    $myVendor->titlecol3     = $formData['ftitlecol3'];
                    $myVendor->desccol3      = $formData['fdesccol3'];
					$myVendor->countproduct  = $formData['fcountproduct'];
					$myVendor->displayorder  = $formData['fdisplayorder'];					

                    if($myVendor->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('vendor_add', $myVendor->id, array());
                        $formData = array();

						///////////////////////////////////
   						//Add Slug base on slug of vendor
						$mySlug = new Core_Slug();
						$mySlug->uid = $this->registry->me->id;
						$mySlug->slug = $myVendor->slug;
						$mySlug->controller = 'vendor';
						$mySlug->objectid = $myVendor->id;
						if(!$mySlug->addData())
						{
							$error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

							//reset slug of current item
							$myVendor->slug = '';
							$myVendor->updateData();
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

		$_SESSION['vendorAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'	=> Core_Vendor::getStatusList(),
												'typeList'		=> Core_Vendor::getVendorTypeList(),
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
		$myVendor = new Core_Vendor($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myVendor->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			$slugList	= array();
			
			$formData['fbulkid']        = array();
			
			
			$formData['fid']            = $myVendor->id;
			$formData['fimage']         = $myVendor->image;
			$formData['fname']          = $myVendor->name;
			$formData['fslug']          = $myVendor->slug;
			$formData['fcontent']       = $myVendor->content;
			$formData['finsurance']     = $myVendor->insurance;
			$formData['ftype']          = $myVendor->type;
			$formData['fstatus']        = $myVendor->status;
            $formData['fseotitle']      = $myVendor->seotitle;

            $formData['fseotitle']      = $myVendor->seotitle;
            $formData['fseokeyword']      = $myVendor->seokeyword;
            $formData['fseodescription']      = $myVendor->seodescription;
            $formData['fmetarobot']      = $myVendor->metarobot;
            $formData['ftitlecol1']      = $myVendor->titlecol1;
            $formData['fdesccol1']      = $myVendor->desccol1;
            $formData['ftitlecol2']      = $myVendor->titlecol2;
            $formData['fdesccol2']      = $myVendor->desccol2;
            $formData['ftitlecol3']      = $myVendor->titlecol3;
            $formData['fdesccol3']      = $myVendor->desccol3;

            $formData['ftopseokeyword'] = $myVendor->topseokeyword;
			$formData['fcountproduct']  = $myVendor->countproduct;
			$formData['fdisplayorder']  = $myVendor->displayorder;
			$formData['fdatecreated']   = $myVendor->datecreated;
			$formData['fdatemodified']  = $myVendor->datemodified;
			
			//Current Slug
			$formData['fslugcurrent'] = $myVendor->slug;
			
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['vendorEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

					/////////////////////////
					//get all slug related to current slug
					$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
					if($formData['fslug'] != '')
						$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');
					
					
                    if($this->editActionValidator($formData, $error))
                    {

						$myVendor->image         = $formData['fimage'];
						$myVendor->name          = $formData['fname'];
						$myVendor->slug          = $formData['fslug'];
						$myVendor->content       = $formData['fcontent'];
						$myVendor->insurance     = $formData['finsurance'];
						$myVendor->type          = $formData['ftype'];
						$myVendor->status        = $formData['fstatus'];
                        $myVendor->seotitle      = $formData['fseotitle'];
                        $myVendor->seokeyword    = $formData['fseokeyword'];
                        $myVendor->seodescription= $formData['fseodescription'];
                        $myVendor->metarobot     = $formData['fmetarobot'];
                        $myVendor->titlecol1     = $formData['ftitlecol1'];
                        $myVendor->desccol1      = $formData['fdesccol1'];
                        $myVendor->titlecol2     = $formData['ftitlecol2'];
                        $myVendor->desccol2      = $formData['fdesccol2'];
                        $myVendor->titlecol3     = $formData['ftitlecol3'];
                        $myVendor->desccol3      = $formData['fdesccol3'];
						$myVendor->topseokeyword = $formData['ftopseokeyword'];
						$myVendor->countproduct  = $formData['fcountproduct'];
						$myVendor->displayorder  = $formData['fdisplayorder'];

                        if($myVendor->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('vendor_edit', $myVendor->id, array());
                            $formData['fimageurl'] = $myVendor->getSmallImage();

							///////////////////////////////////
	   						//Add Slug base on slug of page
							if($formData['fslug'] != $formData['fslugcurrent'])
							{
								$mySlug = new Core_Slug();
								$mySlug->uid = $this->registry->me->id;
								$mySlug->slug = $myVendor->slug;
								$mySlug->controller = 'vendor';
								$mySlug->objectid = $myVendor->id;
								if(!$mySlug->addData())
								{
									$error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

									//reset slug of current item
									$myVendor->slug = $formData['fslugcurrent'];
									$myVendor->updateData();
								}
								else
								{
									//Add new slug ok, keep old slug but change the link to keep the reference to new ref
									Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'vendor', $myVendor->id);
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


			$_SESSION['vendorEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_Vendor::getStatusList(),
													'typeList'		=> Core_Vendor::getVendorTypeList(),
													'slugList'	=> $slugList,
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
		$myVendor = new Core_Vendor($id);
		if($myVendor->id > 0)
		{
			//tien hanh xoa
			if($myVendor->delete())
			{
				$redirectMsg = str_replace('###id###', $myVendor->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('vendor_delete', $myVendor->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myVendor->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['fslug'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSlugRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		if(strlen($_FILES['fimage']['name']) > 0)
		{
			//kiem tra dinh dang hinh anh
			if(!in_array(strtoupper(end(explode('.', $_FILES['fimage']['name']))), $this->registry->setting['vendor']['imageValidType']))
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}

			//kiem tra kich thuoc file
			if($_FILES['fimage']['size'] > $this->registry->setting['vendor']['imageMaxFileSize'])
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
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

		if($formData['fslug'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSlugRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		if(strlen($_FILES['fimage']['name']) > 0)
		{
			//kiem tra dinh dang hinh anh
			if(!in_array(strtoupper(end(explode('.', $_FILES['fimage']['name']))), $this->registry->setting['vendor']['imageValidType']))
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}

			//kiem tra kich thuoc file
			if($_FILES['fimage']['size'] > $this->registry->setting['vendor']['imageMaxFileSize'])
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
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
}


