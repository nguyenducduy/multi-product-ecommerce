<?php

Class Controller_Cms_AccessTicket Extends Controller_Cms_Base 
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
		$uidissueFilter = (int)($this->registry->router->getArg('uidissue'));
		$uidmodifyFilter = (int)($this->registry->router->getArg('uidmodify'));
		$tickettypeFilter = (int)($this->registry->router->getArg('tickettype'));
		$groupcontrollerFilter = (string)($this->registry->router->getArg('groupcontroller'));
		$controllerFilter = (string)($this->registry->router->getArg('controller'));
		$actionFilter = (string)($this->registry->router->getArg('action'));
		$suffixFilter = (string)($this->registry->router->getArg('suffix'));
		$fullticketFilter = (string)($this->registry->router->getArg('fullticket'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['accessticketBulkToken']==$_POST['ftoken'])
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
                            $myAccessTicket = new Core_AccessTicket($id);
                            
                            if($myAccessTicket->id > 0)
                            {
                                //tien hanh xoa
                                if($myAccessTicket->delete())
                                {
                                    $deletedItems[] = $myAccessTicket->id;
                                    $this->registry->me->writelog('accessticket_delete', $myAccessTicket->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myAccessTicket->id;
                            }
                            else
                                $cannotDeletedItems[] = $myAccessTicket->id;
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
		
		$_SESSION['accessticketBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($uidissueFilter > 0)
		{
			$paginateUrl .= 'uidissue/'.$uidissueFilter . '/';
			$formData['fuidissue'] = $uidissueFilter;
			$formData['search'] = 'uidissue';
		}

		if($uidmodifyFilter > 0)
		{
			$paginateUrl .= 'uidmodify/'.$uidmodifyFilter . '/';
			$formData['fuidmodify'] = $uidmodifyFilter;
			$formData['search'] = 'uidmodify';
		}

		if($tickettypeFilter > 0)
		{
			$paginateUrl .= 'tickettype/'.$tickettypeFilter . '/';
			$formData['ftickettype'] = $tickettypeFilter;
			$formData['search'] = 'tickettype';
		}

		if($groupcontrollerFilter != "")
		{
			$paginateUrl .= 'groupcontroller/'.$groupcontrollerFilter . '/';
			$formData['fgroupcontroller'] = $groupcontrollerFilter;
			$formData['search'] = 'groupcontroller';
		}

		if($controllerFilter != "")
		{
			$paginateUrl .= 'controller/'.$controllerFilter . '/';
			$formData['fcontroller'] = $controllerFilter;
			$formData['search'] = 'controller';
		}

		if($actionFilter != "")
		{
			$paginateUrl .= 'action/'.$actionFilter . '/';
			$formData['faction'] = $actionFilter;
			$formData['search'] = 'action';
		}

		if($suffixFilter != "")
		{
			$paginateUrl .= 'suffix/'.$suffixFilter . '/';
			$formData['fsuffix'] = $suffixFilter;
			$formData['search'] = 'suffix';
		}

		if($fullticketFilter != "")
		{
			$paginateUrl .= 'fullticket/'.$fullticketFilter . '/';
			$formData['ffullticket'] = $fullticketFilter;
			$formData['search'] = 'fullticket';
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
		
				
		//tim tong so
		$total = Core_AccessTicket::getAccessTickets($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$accesstickets = Core_AccessTicket::getAccessTickets($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		if(count($accesstickets) > 0)
		{
			foreach ($accesstickets as $accessticket) 
			{
				$accessticket->accesstickettypeactor = new Core_AccessTicketType($accessticket->tickettype);
				$accessticket->actor = new Core_User($accessticket->uid , true);
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
		
		////GET ALL ACCESS_TICKET_TYPE IN SYSTEM
		$accesstickettypelist = Core_AccessTicketType::getAccessTicketTypes(array() , 'id' , 'ASC');

		$this->registry->smarty->assign(array(	'accesstickets' 	=> $accesstickets,
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
												'statusList'    => Core_AccessTicket::getStatusList(),
												'accesstickettypelist' => $accesstickettypelist,
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
            if($_SESSION['accessticketAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myAccessTicket = new Core_AccessTicket();

					
					$myAccessTicket->uid = $formData['fuid'];
					$myAccessTicket->uidissue = $this->registry->me->id;					
					$myAccessTicket->tickettype = $formData['ftickettype'];

					$myAccessTicketType = new Core_AccessTicketType($formData['ftickettype']);					

					$myAccessTicket->groupcontroller = $myAccessTicketType->groupcontroller;
					$myAccessTicket->controller = $myAccessTicketType->controller;
					$myAccessTicket->action = $myAccessTicketType->action;
					$myAccessTicket->suffix = $formData['fsuffix'];

					if(!isset($formData['fwildcard']))
                    {
                        $fullticket = $myAccessTicket->groupcontroller . '_' . $myAccessTicket->controller . '_' . $myAccessTicket->action . '_' . $formData['fsuffix'];
                    }
                    else
                    {
                        $fullticket = $myAccessTicket->groupcontroller . '_' . $myAccessTicket->controller . '_*_' . $formData['fsuffix'];
                    }

					$myAccessTicket->fullticket = $fullticket;	
					$myAccessTicket->status = $formData['fstatus'];					
					
                    if($myAccessTicket->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('accessticket_add', $myAccessTicket->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		////GET ALL ACCESS_TICKET_TYPE IN SYSTEM
		$accesstickettypelist = Core_AccessTicketType::getAccessTicketTypes(array() , 'id' , 'ASC');

		////GET ROOT CATEGORY OF SYSTEM
		$rootcategorylist = Core_Productcategory::getRootProductcategory();

		$_SESSION['accessticketAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'accesstickettypelist' => $accesstickettypelist,
												'statusList' => Core_AccessTicket::getStatusList(),
												'rootcategorylist' => $rootcategorylist,
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
		$myAccessTicket = new Core_AccessTicket($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myAccessTicket->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myAccessTicket->uid;
			$formData['fuidissue'] = $myAccessTicket->uidissue;
			$formData['fuidmodify'] = $myAccessTicket->uidmodify;
			$formData['fid'] = $myAccessTicket->id;
			$formData['ftickettype'] = $myAccessTicket->tickettype;
			$formData['fgroupcontroller'] = $myAccessTicket->groupcontroller;
			$formData['fcontroller'] = $myAccessTicket->controller;
			$formData['faction'] = $myAccessTicket->action;
			$formData['fsuffix'] = $myAccessTicket->suffix;
			$formData['ffullticket'] = $myAccessTicket->fullticket;
			$formData['fobjectid'] = $myAccessTicket->objectid;
			$formData['fipaddress'] = $myAccessTicket->ipaddress;
			$formData['fstatus'] = $myAccessTicket->status;
			$formData['fdatecreated'] = $myAccessTicket->datecreated;
			$formData['fdatamodified'] = $myAccessTicket->datamodified;			
			$formData['actor'] = new Core_User($formData['fuid'] , true);
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['accessticketEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {											
						$myAccessTicket->uidmodify = $this->registry->me->id;
						$myAccessTicket->tickettype = $formData['ftickettype'];
						$myAccessTicketType = new Core_AccessTicketType($formData['ftickettype']);					

						$myAccessTicket->groupcontroller = $myAccessTicketType->groupcontroller;
						$myAccessTicket->controller = $myAccessTicketType->controller;
						$myAccessTicket->action = $myAccessTicketType->action;
											
						$myAccessTicket->suffix = $formData['fsuffix'];

						$fullticket = $myAccessTicket->groupcontroller . '_' . $myAccessTicket->controller . '_' . $myAccessTicket->action . '_' . $formData['fsuffix'];

						$myAccessTicket->fullticket = $fullticket;
						$myAccessTicket->status = $formData['fstatus'];						
                        
                        if($myAccessTicket->updateData())
                        {
                        	///XOA CACHE ACCESS TICKET
                        	$actor = new Core_User($formData['fuid'] , true);
                        	$actor->clearAccessTicketCache();

                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('accessticket_edit', $myAccessTicket->id, array());
                            $this->deleteAccessTicketKey($myAccessTicket->uid); //delete cache
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			////GET ALL ACCESS_TICKET_TYPE IN SYSTEM
			$accesstickettypelist = Core_AccessTicketType::getAccessTicketTypes(array() , 'id' , 'ASC');

			////GET ROOT CATEGORY OF SYSTEM
			$rootcategorylist = Core_Productcategory::getRootProductcategory();
			
			$_SESSION['accessticketEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'accesstickettypelist' => $accesstickettypelist,
													'statusList' => Core_AccessTicket::getStatusList(),
													'rootcategorylist' => $rootcategorylist,
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
		$myAccessTicket = new Core_AccessTicket($id);
		if($myAccessTicket->id > 0)
		{
			//tien hanh xoa
			if($myAccessTicket->delete())
			{
				$redirectMsg = str_replace('###id###', $myAccessTicket->id, $this->registry->lang['controller']['succDelete']);
                $this->deleteAccessTicketKey($myAccessTicket->uid); //delete cache
				$this->registry->me->writelog('accessticket_delete', $myAccessTicket->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myAccessTicket->id, $this->registry->lang['controller']['errDelete']);
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
	
	public function cloneAction()
	{
		$formData = array();
		$error = array();
		$success = array();
		$warning = array();
		
		
		if( isset($_POST['fsubmit']) )
		{
			$formData = array_merge($formData , $_POST);

			if($this->cloneActionValidator($formData ,$error))
			{
				$ok = false;
				foreach ($formData['fticket'] as $ticketid) 
				{
					$myAccessTicket = new Core_AccessTicket($ticketid);

					if($myAccessTicket->id > 0)
					{
						if(!Core_AccessTicket::checkexistticket($formData['fuiddes'] , $myAccessTicket->fullticket))
                        {
                            $mycloneAccessticket = new Core_AccessTicket();

                            $mycloneAccessticket->uid = $formData['fuiddes'];
                            $mycloneAccessticket->uidissue = $this->registry->me->id;
                            $mycloneAccessticket->tickettype = $myAccessTicket->tickettype;


                            $mycloneAccessticket->groupcontroller = $myAccessTicket->groupcontroller;
                            $mycloneAccessticket->controller = $myAccessTicket->controller;
                            $mycloneAccessticket->action = $myAccessTicket->action;
                            $mycloneAccessticket->suffix = $myAccessTicket->suffix;

                            $mycloneAccessticket->fullticket = $myAccessTicket->fullticket;
                            $mycloneAccessticket->status = $myAccessTicket->status;

                            if($mycloneAccessticket->addData())
                            {
                                $ok = true;
                            }
                            else
                            {
                                $ok = false;
                            }

                        }
					}
				}

				if($ok)
				{
					$success[] = $this->registry->lang['controller']['succClone'];
					$this->registry->me->writelog('accessticket_add', $mycloneAccessticket->id, array());
                    $this->deleteAccessTicketKey($formData['fuiddes']); //delete cache
                    $formData = array();
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errClone'];
				}
			}
		}
		
		$_SESSION['accessticketCloneToken'] = Helper::getSecurityToken();//Tao token moi
			
		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
				'redirectUrl'=> $redirectUrl,
				'error'		=> $error,
				'success'	=> $success,				
		));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'clone.tpl');
		$this->registry->smarty->assign(array(
				'pageTitle'	=> $this->registry->lang['controller']['pageTitle_clone'],
				'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	private function cloneActionValidator($formData , &$error)
	{
		$pass = true;

		if($formData['fuiddes'] == 0)
		{
			$error[] = 'Please enter uid destination .';
			$pass = false;
		}


		if( empty($formData['fticket']) )
		{
			$error[] = 'Please choose ticket to clone .';
			$pass = false;
		}

		return $pass;
	}

	public function getaccessticketajaxAction()
	{
		$uidsource = (int)$_POST['uidsoruce'];

		$html = '';

		if($uidsource > 0)
		{
			//get accessticke of uid soruce
			$accessticklist = Core_AccessTicket::getAccessTickets(array('fuid' => $uidsource) , 'id' , 'ASC');

			if( count($accessticklist) > 0 )
			{
				$html .= '<table class="table table-bordered"><thead><tr><td>Full ticket</td><td><input type="checkbox" id="checkallticket" /></td></tr></thead><tbody>';

				foreach ( $accessticklist as $accesstick ) 
				{
					$html .= '<tr>';

					$html .= '<td>'.$accesstick->fullticket.'</td>';					
					$html .= '<td><input type="checkbox" id="fticket'.$accesstick->id.'" name="fticket[]" class="checkticket" value="'.$accesstick->id.'" /></td>';

					$html .= '</tr>';
				}

				$html .= '</tbody></table>';
			}
			else
			{
				$html = 'Data not found.';
			}
		}

		echo $html;
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftickettype'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errTickettypeMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fsuffix'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSuffixRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftickettype'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errTickettypeMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fsuffix'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSuffixRequired'];
			$pass = false;
		}
				
		return $pass;
	}

    private function deleteAccessTicketKey($uid)
    {
        $pass = false;

        if($this->id > 0)
        {
            $key = 'user_accessticket_' . $uid;
            $myCacher = new Cacher($key);
            $pass = $myCacher->clear();
        }

        return $pass;
    }
}

?>