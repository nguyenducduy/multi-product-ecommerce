<?php

Class Controller_Admin_ApiPartner Extends Controller_Cms_Base 
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
		$keyFilter = (string)($this->registry->router->getArg('key'));
		$secretFilter = (string)($this->registry->router->getArg('secret'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
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
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['apipartnerBulkToken']==$_POST['ftoken'])
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
                            $myApiPartner = new Core_Backend_ApiPartner($id);
                            
                            if($myApiPartner->id > 0)
                            {
                                //tien hanh xoa
                                if($myApiPartner->delete())
                                {
                                    $deletedItems[] = $myApiPartner->id;
                                    $this->registry->me->writelog('apipartner_delete', $myApiPartner->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myApiPartner->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApiPartner->id;
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
		
		$_SESSION['apipartnerBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($keyFilter != "")
		{
			$paginateUrl .= 'key/'.$keyFilter . '/';
			$formData['fkey'] = $keyFilter;
			$formData['search'] = 'key';
		}

		if($secretFilter != "")
		{
			$paginateUrl .= 'secret/'.$secretFilter . '/';
			$formData['fsecret'] = $secretFilter;
			$formData['search'] = 'secret';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
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

			if($searchKeywordIn == 'key')
			{
				$paginateUrl .= 'searchin/key/';
			}
			elseif($searchKeywordIn == 'secret')
			{
				$paginateUrl .= 'searchin/secret/';
			}
			elseif($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			elseif($searchKeywordIn == 'phone')
			{
				$paginateUrl .= 'searchin/phone/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ApiPartner::getApiPartners($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$apipartners = Core_Backend_ApiPartner::getApiPartners($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'apipartners' 	=> $apipartners,
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
												'statusList'    => Core_Backend_ApiPartner::getStatusList(),
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
            if($_SESSION['apipartnerAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myApiPartner = new Core_Backend_ApiPartner();

					
					$myApiPartner->uid = $this->registry->me->id;
					$myApiPartner->key = $formData['fkey'];
					$myApiPartner->serect = $myApiPartner->createSerectString();					
					$myApiPartner->name = $formData['fname'];
					$myApiPartner->email = $formData['femail'];
					$myApiPartner->phone = $formData['fphone'];
					$myApiPartner->description = $formData['fdescription'];
					$myApiPartner->status = $formData['fstatus'];
					
                    if($myApiPartner->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('apipartner_add', $myApiPartner->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['apipartnerAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'    => Core_Backend_ApiPartner::getStatusList(),
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
		$myApiPartner = new Core_Backend_ApiPartner($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myApiPartner->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myApiPartner->uid;
			$formData['fid'] = $myApiPartner->id;
			$formData['fkey'] = $myApiPartner->key;
			$formData['fsecret'] = $myApiPartner->secret;
			$formData['fname'] = $myApiPartner->name;
			$formData['femail'] = $myApiPartner->email;
			$formData['fphone'] = $myApiPartner->phone;
			$formData['fdescription'] = $myApiPartner->description;
			$formData['fstatus'] = $myApiPartner->status;
			$formData['fdatecreated'] = $myApiPartner->datecreated;
			$formData['fdatemodified'] = $myApiPartner->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apipartnerEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myApiPartner->uid = $this->registry->me->id;
						$myApiPartner->key = $formData['fkey'];
						$myApiPartner->secret = $formData['fsecret'];
						$myApiPartner->name = $formData['fname'];
						$myApiPartner->email = $formData['femail'];
						$myApiPartner->phone = $formData['fphone'];
						$myApiPartner->description = $formData['fdescription'];
						$myApiPartner->status = $formData['fstatus'];
                        
                        if($myApiPartner->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apipartner_edit', $myApiPartner->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['apipartnerEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList' => Core_Backend_ApiPartner::getStatusList(),
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
		$myApiPartner = new Core_Backend_ApiPartner($id);
		if($myApiPartner->id > 0)
		{
			//tien hanh xoa
			if($myApiPartner->delete())
			{
				$redirectMsg = str_replace('###id###', $myApiPartner->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('apipartner_delete', $myApiPartner->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApiPartner->id, $this->registry->lang['controller']['errDelete']);
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

	public function changesecretajaxAction()
	{
		$data = '';
		$id = (int)$_POST['id'];

		$myApiPartner = new Core_Backend_ApiPartner($id);
		if($myApiPartner->id > 0)
		{
			$myApiPartner->serect = $myApiPartner->createSerectString();
			if($myApiPartner->updateData())
			{
				$data = $myApiPartner->secret;
			}
		}

		echo $data;
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fkey'] == '')
		{
			$error[] = $this->registry->lang['controller']['errKeyRequired'];
			$pass = false;
		}

		/*if($formData['fsecret'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSecretRequired'];
			$pass = false;
		}*/

		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fstatus'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errStatusMustGreaterThanZero'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fkey'] == '')
		{
			$error[] = $this->registry->lang['controller']['errKeyRequired'];
			$pass = false;
		}

		/*if($formData['fsecret'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSecretRequired'];
			$pass = false;
		}*/

		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fstatus'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errStatusMustGreaterThanZero'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>