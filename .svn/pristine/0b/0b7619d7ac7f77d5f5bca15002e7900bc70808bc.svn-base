<?php

Class Controller_Crm_Contact Extends Controller_Crm_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		
		$_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		$idFilter 		= (int)($this->registry->router->getArg('id'));
		$reasonFilter	= $this->registry->router->getArg('reason');
		$statusFilter	= $this->registry->router->getArg('status');
		$keywordFilter 	= $this->registry->router->getArg('keyword'); 
		$searchKeywordIn= $this->registry->router->getArg('searchin');  
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
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
						$myContact = new Core_Contact($id);
						
						if($myContact->id > 0)
						{
							//tien hanh xoa
							if($myContact->delete())
							{
								$deletedItems[] = $myContact->id;
								$this->registry->me->writelog('contact_delete', $myContact->id, array('fullname' => $myContact->fullname, 'email' => $myContact->email, 'phone' => $myContact->phone, 'reason' => $myContact->reason, 'status' => $myContact->status, 'message' => $myContact->message));  	
							}
							else
								$cannotDeletedItems[] = $myContact->id;
						}
						else
							$cannotDeletedItems[] = $myContact->id;
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
		
		
				
		$paginateUrl = $this->registry->conf['rooturl_admin'].'contact/index/';      
		
				
		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
		if(strlen($reasonFilter) > 0)
		{
			$paginateUrl .= 'reason/'.$reasonFilter . '/';
			$formData['freason'] = $reasonFilter;
			$formData['search'] = 'reason';
		}
		
		if(strlen($statusFilter) > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}
		
		
		if(strlen($keywordFilter) > 0)
		{
			
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';
			
			if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			elseif($searchKeywordIn == 'phone')
			{
				$paginateUrl .= 'searchin/phone/';
			}
			elseif($searchKeywordIn == 'message')
			{
				$paginateUrl .= 'searchin/message/';
			}
			elseif($searchKeywordIn == 'ipaddress')
			{
				$paginateUrl .= 'searchin/ipaddress/';
			}
			elseif($searchKeywordIn == 'note')
			{
				$paginateUrl .= 'searchin/note/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
		
		//tim tong so
		$total = Core_Contact::getContacts($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest records
		$contacts = Core_Contact::getContacts($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage, false);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'contacts' 		=> $contacts,
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
		
		$this->registry->smarty->assign(array(	'menu'		=> 'contactlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
		
		$myContact = new Core_Contact($id);
		
		
		$redirectUrl = $this->getRedirectUrl();
		
		if($myContact->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fid'] = $myContact->id;
			$formData['ffullname'] = $myContact->fullname;
			$formData['femail'] = $myContact->email;
			$formData['fphone'] = $myContact->phone;
			$formData['freason'] = $myContact->reason;
			$formData['fmessage'] = $myContact->message;
			$formData['fipaddress'] = $myContact->ipaddress;
			$formData['fstatus'] = $myContact->status;
			$formData['fnote'] = $myContact->note;
			$formData['fdatecreated'] = $myContact->datecreated;
			if(!empty($_POST['fsubmit']))
			{
				$formData = array_merge($formData, $_POST);
				
				if($this->editActionValidator($formData, $error))
				{
					$myContact->fullname = $formData['ffullname'];
					$myContact->email = $formData['femail'];
					$myContact->phone = $formData['fphone'];
					$myContact->message = strip_tags($formData['fmessage']);
					$myContact->note = $formData['fnote'];
					
					if($formData['freason'] == 'general' || $formData['freason'] == 'ads' || $formData['freason'] == 'idea' || $formData['freason'] == 'support')
						$myContact->reason = $formData['freason'];
						
					if($formData['fstatus'] == 'new' || $formData['fstatus'] == 'pending' || $formData['fstatus'] == 'completed')
						$myContact->status = $formData['fstatus'];
					
					
					if($myContact->updateData($error))
					{
						$success[] = str_replace('###id###', $myContact->id, $this->registry->lang['controller']['succUpdate']);
						$this->registry->me->writelog('contact_edit', $myContact->id, array('fullname' => $myContact->fullname, 'email' => $myContact->email, 'phone' => $myContact->phone, 'reason' => $myContact->reason, 'status' => $myContact->status));
						
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errUpdate'];			
					}
					
				}
			}
			
			
			//get token for form
			$_SESSION['contactEditToken'] = Helper::getSecurityToken();
			
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'myContact'	=> $myContact,
													'backUrl'=> $redirectUrl,
													'redirectUrl' => base64_encode($redirectUrl),
													'error'		=> $error,
													'success'	=> $success,
													
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'menu'		=> 'contact',
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
		
		$myContact = new Core_Contact($id);
			
		if($myContact->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myContact->delete())
				{
					$redirectMsg = str_replace('###id###', $myContact->id, $this->registry->lang['controller']['succDelete']);
					
					$this->registry->me->writelog('contact_delete', $myContact->id, array('fullname' => $myContact->fullname, 'email' => $myContact->email, 'phone' => $myContact->phone, 'reason' => $myContact->reason, 'status' => $myContact->status, 'message' => $myContact->message));  	
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myContact->id, $this->registry->lang['controller']['errDelete']);
				}
			}
			else
				$redirectMsg = $this->registry->lang['default']['errFormTokenInvalid'];   
			
			
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
	
		
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		//check form token
		if($formData['ftoken'] != $_SESSION['contactEditToken'])
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errFormTokenInvalid'];	
		}
		
		
		return $pass;
	}
	
		
}

