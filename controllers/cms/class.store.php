<?php

Class Controller_Cms_Store Extends Controller_Cms_Base 
{
	private $recordPerPage = 100;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$descriptionFilter = (string)($this->registry->router->getArg('description'));
		$addressFilter = (string)($this->registry->router->getArg('address'));
		$regionFilter = (int)($this->registry->router->getArg('region'));
		$phoneFilter = (string)($this->registry->router->getArg('phone'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['storeBulkToken']==$_POST['ftoken'])
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
                            $myStore = new Core_Store($id);
                            
                            if($myStore->id > 0)
                            {
                                //tien hanh xoa
                                if($myStore->delete())
                                {
                                    $deletedItems[] = $myStore->id;
                                    $this->registry->me->writelog('store_delete', $myStore->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myStore->id;
                            }
                            else
                                $cannotDeletedItems[] = $myStore->id;
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
                $myItem = new Core_Store($id);
                if($myItem->id > 0 && $myItem->displayorder != $neworder)
                {
                    $myItem->displayorder = $neworder;
                    $myItem->updateData();
                }
            }
            
            $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
        }
		
		$_SESSION['storeBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($descriptionFilter != "")
		{
			$paginateUrl .= 'description/'.$descriptionFilter . '/';
			$formData['fdescription'] = $descriptionFilter;
			$formData['search'] = 'description';
		}

		if($addressFilter != "")
		{
			$paginateUrl .= 'address/'.$addressFilter . '/';
			$formData['faddress'] = $addressFilter;
			$formData['search'] = 'address';
		}

		if($regionFilter > 0)
		{
			$paginateUrl .= 'region/'.$regionFilter . '/';
			$formData['fregion'] = $regionFilter;
			$formData['search'] = 'region';
		}

		if($phoneFilter != "")
		{
			$paginateUrl .= 'phone/'.$phoneFilter . '/';
			$formData['fphone'] = $phoneFilter;
			$formData['search'] = 'phone';
		}

		if($emailFilter != "")
		{
			$paginateUrl .= 'email/'.$emailFilter . '/';
			$formData['femail'] = $emailFilter;
			$formData['search'] = 'email';
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
			elseif($searchKeywordIn == 'description')
			{
				$paginateUrl .= 'searchin/description/';
			}
			elseif($searchKeywordIn == 'address')
			{
				$paginateUrl .= 'searchin/address/';
			}
			elseif($searchKeywordIn == 'phone')
			{
				$paginateUrl .= 'searchin/phone/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			elseif($searchKeywordIn == 'fax')
			{
				$paginateUrl .= 'searchin/fax/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Store::getStores($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$stores = Core_Store::getStores($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'stores' 	=> $stores,
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
                                                'statusList'    => Core_Store::getStatusList(),
                                                'myRegion'		=> Core_Region::getRegions(array('fparentid' => 0),'id','ASC','')
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
		
	function addAction()
	{
		//tam thoi khoa chuc nang nay lai vi he thong kho can tung ung voi ERP
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer') )
		{
			header('Location: '.$this->registry->conf['rooturl_cms'] . 'store');
		}
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['storeAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);

                //get all slug related to current slug
                $formData['fslug'] = Helper::codau2khongdau(($formData['fslug'] != '') ? $formData['fslug'] : $formData['fname'], true, true);
                if($formData['fslug'] != '')
                    $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myStore = new Core_Store();
					
					$myStore->image = $formData['fimage'];
					$myStore->name = Helper::plaintext($formData['fname']);
                    $myStore->slug = $formData['fslug'];
					$myStore->description = Helper::plaintext($formData['fdescription']);
					$myStore->address = Helper::plaintext($formData['faddress']);
					$myStore->region = $formData['fregion'];
					$myStore->phone = $formData['fphone'];
					$myStore->email = $formData['femail'];
					$myStore->fax = $formData['ffax'];
					$myStore->lat = $formData['flat'];
					$myStore->lng = $formData['flng'];
					$myStore->status = $formData['fstatus'];

                    if($myStore->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('store_add', $myStore->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['storeAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
                                                'slugList'		=> $slugList,
                                                'statusList'    => Core_Store::getStatusList(),
                                                'regions'   => Core_Region::getRegions(array('fparentid' => 0), '', '', ''),
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	
	
	function editAction()
	{
        //tam thoi khoa chuc nang nay lai vi he thong kho can tung ung voi ERP
        /*if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer') )
        {
            header('Location: '.$this->registry->conf['rooturl_cms'] . 'store');
        }*/

		$id = (int)$this->registry->router->getArg('id');
		$myStore = new Core_Store($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myStore->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();


			/*$formData['fid'] = $myStore->id;
			$formData['fimage'] = $myStore->image;
			$formData['fname'] = $myStore->name;
            $formData['fslug'] = $myStore->slug;
			$formData['fdescription'] = $myStore->description;
			$formData['faddress'] = $myStore->address;
			$formData['fregion'] = $myStore->region;
			$formData['fphone'] = $myStore->phone;
			$formData['femail'] = $myStore->email;
			$formData['ffax'] = $myStore->fax;
			$formData['flat'] = $myStore->lat;
			$formData['flng'] = $myStore->lng;
			$formData['fcountemployee'] = $myStore->countemployee;
			$formData['fstatus'] = $myStore->status;
			$formData['fdisplayorder'] = $myStore->displayorder;
			$formData['fdatecreated'] = $myStore->datecreated;
			$formData['fdatemodified'] = $myStore->datemodified;*/

            $formData['fid'] = $myStore->id;
            $formData['fimage'] = $myStore->image;
            $formData['fname'] = $myStore->name;
            $formData['fslug'] = $myStore->slug;
            $formData['fdescription'] = $myStore->description;
            $formData['faddress'] = $myStore->storeaddress;
            $formData['fregion'] = $myStore->region;
            $formData['fphone'] = $myStore->storephonenum;
            $formData['femail'] = $myStore->email;
            $formData['ffax'] = $myStore->storefax;
            $formData['flat'] = $myStore->lat;
            $formData['flng'] = $myStore->lng;
            $formData['fstatus'] = $myStore->status;
            $formData['fdisplayorder'] = $myStore->displayorder;

            //Current Slug
            $formData['fslugcurrent'] = $myStore->slug;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['storeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    //get all slug related to current slug
                    $formData['fslug'] = Helper::codau2khongdau(($formData['fslug'] != '') ? $formData['fslug'] : $formData['fname'], true, true);
                    if($formData['fslug'] != '')
                        $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                    if($this->editActionValidator($formData, $error))
                    {
						
						$myStore->image = $formData['fimage'];
						$myStore->name = $formData['fname'];
						$myStore->slug = $formData['fslug'];
						$myStore->description = $formData['fdescription'];
						$myStore->storeaddress = $formData['faddress'];
						$myStore->region = $formData['fregion'];
						$myStore->storephonenum = $formData['fphone'];
						$myStore->email = $formData['femail'];
						$myStore->storefax = $formData['ffax'];
						$myStore->lat = $formData['flat'];
						$myStore->lng = $formData['flng'];
						$myStore->status = $formData['fstatus'];
                        
                        if($myStore->updateData())
                        {
                        $success[] = $this->registry->lang['controller']['succUpdate'];
                        $this->registry->me->writelog('store_edit', $myStore->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }
			}
			
			
			$_SESSION['storeEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
                                                    'slugList'	=> $slugList,
                                                    'statusList'    => Core_Store::getStatusList(),
                                                    'regions'   => Core_Region::getRegions(array('fparentid' => 0), '', '', ''),
													
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
        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            header('location: ' . $this->registry['conf']['rooturl_cms'] . 'store');
        }
		$id = (int)$this->registry->router->getArg('id');
		$myStore = new Core_Store($id);
		if($myStore->id > 0)
		{
			//tien hanh xoa
			if($myStore->delete())
			{
				$redirectMsg = str_replace('###id###', $myStore->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('store_delete', $myStore->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myStore->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['faddress'] == '')
		{
			$error[] = $this->registry->lang['controller']['errAddressRequired'];
			$pass = false;
		}

		if($formData['fregion'] == '')
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
			$pass = false;
		}

		if($formData['fphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPhoneRequired'];
			$pass = false;
		}

		if($formData['femail'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEmailRequired'];
			$pass = false;
		}

		if($formData['fstatus'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStatusRequired'];
			$pass = false;
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

		if($formData['faddress'] == '')
		{
			$error[] = $this->registry->lang['controller']['errAddressRequired'];
			$pass = false;
		}

		if($formData['fregion'] == '')
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
			$pass = false;
		}

		if($formData['fphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPhoneRequired'];
			$pass = false;
		}

		if($formData['femail'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEmailRequired'];
			$pass = false;
		}

		if($formData['fstatus'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStatusRequired'];
			$pass = false;
		}
				
		return $pass;
	}

	public function getMapAction()
	{
		$address = $_GET['address'];
		



		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'getmap.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_getmap'],
												'contents'	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerContainer.'getmap.tpl');
	}
}

