<?php

Class Controller_Cms_ProductyearUser Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken'] = Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$usernameFilter = (string)($this->registry->router->getArg('username'));
		$fullnameFilter = (string)($this->registry->router->getArg('fullname'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
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
            if($_SESSION['productyearuserBulkToken']==$_POST['ftoken'])
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
                            $myProductyearUser = new Core_ProductyearUser($id);
                            
                            if($myProductyearUser->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductyearUser->delete())
                                {
                                    $deletedItems[] = $myProductyearUser->id;
                                    $this->registry->me->writelog('productyearuser_delete', $myProductyearUser->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myProductyearUser->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductyearUser->id;
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
		
		$_SESSION['productyearuserBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($usernameFilter != "")
		{
			$paginateUrl .= 'username/'.$usernameFilter . '/';
			$formData['fusername'] = $usernameFilter;
			$formData['search'] = 'username';
		}

		if($fullnameFilter != "")
		{
			$paginateUrl .= 'fullname/'.$fullnameFilter . '/';
			$formData['ffullname'] = $fullnameFilter;
			$formData['search'] = 'fullname';
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

		if($ipaddressFilter > 0)
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = $ipaddressFilter;
			$formData['search'] = 'ipaddress';
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

			if($searchKeywordIn == 'username')
			{
				$paginateUrl .= 'searchin/username/';
			}
			elseif($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_ProductyearUser::getProductyearUsers($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$productyearusers = Core_ProductyearUser::getProductyearUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'productyearusers' 	=> $productyearusers,
												'statusOptions' => Core_ProductyearUser::getStatusList(),
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
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['productyearuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myProductyearUser = new Core_ProductyearUser();

					
					$myProductyearUser->gfeid = $formData['fgfeid'];
					$myProductyearUser->username = $formData['fusername'];
					$myProductyearUser->fullname = $formData['ffullname'];
					$myProductyearUser->email = $formData['femail'];
					$myProductyearUser->phone = $formData['fphone'];
					$myProductyearUser->point = $formData['fpoint'];
					$myProductyearUser->shareid = $formData['fshareid'];
					$myProductyearUser->countlike = $formData['fcountlike'];
					$myProductyearUser->countshare = $formData['fcountshare'];
					$myProductyearUser->oauthpartner = $formData['foauthpartner'];
					$myProductyearUser->status = $formData['fstatus'];
					$myProductyearUser->ipaddress = $formData['fipaddress'];
					
                    if($myProductyearUser->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productyearuser_add', $myProductyearUser->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['productyearuserAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_ProductyearUser::getStatusList(),
												'redirectUrl'	=> $this->getRedirectUrl(),
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
		$myProductyearUser = new Core_ProductyearUser($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myProductyearUser->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fgfeid'] = $myProductyearUser->gfeid;
			$formData['fid'] = $myProductyearUser->id;
			$formData['fusername'] = $myProductyearUser->username;
			$formData['ffullname'] = $myProductyearUser->fullname;
			$formData['femail'] = $myProductyearUser->email;
			$formData['fphone'] = $myProductyearUser->phone;
			$formData['fpoint'] = $myProductyearUser->point;
			$formData['fshareid'] = $myProductyearUser->shareid;
			$formData['fcountlike'] = $myProductyearUser->countlike;
			$formData['fcountshare'] = $myProductyearUser->countshare;
			$formData['foauthpartner'] = $myProductyearUser->oauthpartner;
			$formData['fstatus'] = $myProductyearUser->status;
			$formData['fdatecreated'] = $myProductyearUser->datecreated;
			$formData['fdatemodified'] = $myProductyearUser->datemodified;
			$formData['fipaddress'] = $myProductyearUser->ipaddress;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productyearuserEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myProductyearUser->gfeid = $formData['fgfeid'];
						$myProductyearUser->username = $formData['fusername'];
						$myProductyearUser->fullname = $formData['ffullname'];
						$myProductyearUser->email = $formData['femail'];
						$myProductyearUser->phone = $formData['fphone'];
						$myProductyearUser->point = $formData['fpoint'];
						$myProductyearUser->shareid = $formData['fshareid'];
						$myProductyearUser->countlike = $formData['fcountlike'];
						$myProductyearUser->countshare = $formData['fcountshare'];
						$myProductyearUser->oauthpartner = $formData['foauthpartner'];
						$myProductyearUser->status = $formData['fstatus'];
						$myProductyearUser->ipaddress = $formData['fipaddress'];
                        
                        if($myProductyearUser->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productyearuser_edit', $myProductyearUser->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['productyearuserEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_ProductyearUser::getStatusList(),
													'redirectUrl'=> $redirectUrl,
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
		$myProductyearUser = new Core_ProductyearUser($id);
		if($myProductyearUser->id > 0)
		{
			//tien hanh xoa
			if($myProductyearUser->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductyearUser->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('productyearuser_delete', $myProductyearUser->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductyearUser->id, $this->registry->lang['controller']['errDelete']);
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
