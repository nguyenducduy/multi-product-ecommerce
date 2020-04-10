<?php

Class Controller_Profile_CalendarEvent Extends Controller_Profile_Base 
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
		$cidFilter = (int)($this->registry->router->getArg('cid'));
		$ccidFilter = (int)($this->registry->router->getArg('ccid'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$regionFilter = (int)($this->registry->router->getArg('region'));
		$datestartFilter = (int)($this->registry->router->getArg('datestart'));
		$dateendFilter = (int)($this->registry->router->getArg('dateend'));
		$isrepeatFilter = (int)($this->registry->router->getArg('isrepeat'));
		$repeattypeFilter = (int)($this->registry->router->getArg('repeattype'));
		$partnertypeFilter = (int)($this->registry->router->getArg('partnertype'));
		$partneridFilter = (int)($this->registry->router->getArg('partnerid'));
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
            if($_SESSION['calendareventBulkToken']==$_POST['ftoken'])
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
                            $myCalendarEvent = new Core_Backend_CalendarEvent($id);
                            
                            if($myCalendarEvent->id > 0)
                            {
                                //tien hanh xoa
                                if($myCalendarEvent->delete())
                                {
                                    $deletedItems[] = $myCalendarEvent->id;
                                    $this->registry->me->writelog('calendarevent_delete', $myCalendarEvent->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myCalendarEvent->id;
                            }
                            else
                                $cannotDeletedItems[] = $myCalendarEvent->id;
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
		
		$_SESSION['calendareventBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($cidFilter > 0)
		{
			$paginateUrl .= 'cid/'.$cidFilter . '/';
			$formData['fcid'] = $cidFilter;
			$formData['search'] = 'cid';
		}

		if($ccidFilter > 0)
		{
			$paginateUrl .= 'ccid/'.$ccidFilter . '/';
			$formData['fccid'] = $ccidFilter;
			$formData['search'] = 'ccid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($regionFilter > 0)
		{
			$paginateUrl .= 'region/'.$regionFilter . '/';
			$formData['fregion'] = $regionFilter;
			$formData['search'] = 'region';
		}

		if($datestartFilter > 0)
		{
			$paginateUrl .= 'datestart/'.$datestartFilter . '/';
			$formData['fdatestart'] = $datestartFilter;
			$formData['search'] = 'datestart';
		}

		if($dateendFilter > 0)
		{
			$paginateUrl .= 'dateend/'.$dateendFilter . '/';
			$formData['fdateend'] = $dateendFilter;
			$formData['search'] = 'dateend';
		}

		if($isrepeatFilter > 0)
		{
			$paginateUrl .= 'isrepeat/'.$isrepeatFilter . '/';
			$formData['fisrepeat'] = $isrepeatFilter;
			$formData['search'] = 'isrepeat';
		}

		if($repeattypeFilter > 0)
		{
			$paginateUrl .= 'repeattype/'.$repeattypeFilter . '/';
			$formData['frepeattype'] = $repeattypeFilter;
			$formData['search'] = 'repeattype';
		}

		if($partnertypeFilter > 0)
		{
			$paginateUrl .= 'partnertype/'.$partnertypeFilter . '/';
			$formData['fpartnertype'] = $partnertypeFilter;
			$formData['search'] = 'partnertype';
		}

		if($partneridFilter > 0)
		{
			$paginateUrl .= 'partnerid/'.$partneridFilter . '/';
			$formData['fpartnerid'] = $partneridFilter;
			$formData['search'] = 'partnerid';
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
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_CalendarEvent::getCalendarEvents($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$calendarevents = Core_Backend_CalendarEvent::getCalendarEvents($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'calendarevents' 	=> $calendarevents,
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
            if($_SESSION['calendareventAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myCalendarEvent = new Core_Backend_CalendarEvent();

					
					$myCalendarEvent->name = $formData['fname'];
					$myCalendarEvent->description = $formData['fdescription'];
					$myCalendarEvent->address = $formData['faddress'];
					$myCalendarEvent->region = $formData['fregion'];
					$myCalendarEvent->status = $formData['fstatus'];
					
                    if($myCalendarEvent->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('calendarevent_add', $myCalendarEvent->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['calendareventAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
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
		$myCalendarEvent = new Core_Backend_CalendarEvent($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myCalendarEvent->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myCalendarEvent->uid;
			$formData['fcid'] = $myCalendarEvent->cid;
			$formData['fccid'] = $myCalendarEvent->ccid;
			$formData['fid'] = $myCalendarEvent->id;
			$formData['fname'] = $myCalendarEvent->name;
			$formData['fdescription'] = $myCalendarEvent->description;
			$formData['faddress'] = $myCalendarEvent->address;
			$formData['fregion'] = $myCalendarEvent->region;
			$formData['flat'] = $myCalendarEvent->lat;
			$formData['flng'] = $myCalendarEvent->lng;
			$formData['fdatestart'] = $myCalendarEvent->datestart;
			$formData['fdateend'] = $myCalendarEvent->dateend;
			$formData['ftimestart'] = $myCalendarEvent->timestart;
			$formData['ftimeend'] = $myCalendarEvent->timeend;
			$formData['fisrepeat'] = $myCalendarEvent->isrepeat;
			$formData['frepeattype'] = $myCalendarEvent->repeattype;
			$formData['frepeatweekday'] = $myCalendarEvent->repeatweekday;
			$formData['frepeatmonthday'] = $myCalendarEvent->repeatmonthday;
			$formData['fpartnertype'] = $myCalendarEvent->partnertype;
			$formData['fpartnerid'] = $myCalendarEvent->partnerid;
			$formData['fpartnerdatesynced'] = $myCalendarEvent->partnerdatesynced;
			$formData['fstatus'] = $myCalendarEvent->status;
			$formData['fdatecreated'] = $myCalendarEvent->datecreated;
			$formData['fdatemodified'] = $myCalendarEvent->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['calendareventEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myCalendarEvent->name = $formData['fname'];
						$myCalendarEvent->description = $formData['fdescription'];
						$myCalendarEvent->address = $formData['faddress'];
						$myCalendarEvent->region = $formData['fregion'];
						$myCalendarEvent->status = $formData['fstatus'];
                        
                        if($myCalendarEvent->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('calendarevent_edit', $myCalendarEvent->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['calendareventEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
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
		$myCalendarEvent = new Core_Backend_CalendarEvent($id);
		if($myCalendarEvent->id > 0)
		{
			//tien hanh xoa
			if($myCalendarEvent->delete())
			{
				$redirectMsg = str_replace('###id###', $myCalendarEvent->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('calendarevent_delete', $myCalendarEvent->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myCalendarEvent->id, $this->registry->lang['controller']['errDelete']);
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

