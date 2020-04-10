<?php

Class Controller_Cms_GamefasteyeQuestion Extends Controller_Cms_Base 
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
		
		
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$pointFilter = (int)($this->registry->router->getArg('point'));
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
            if($_SESSION['gamefasteyequestionBulkToken']==$_POST['ftoken'])
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
                            $myGamefasteyeQuestion = new Core_GamefasteyeQuestion($id);
                            
                            if($myGamefasteyeQuestion->id > 0)
                            {
                                //tien hanh xoa
                                if($myGamefasteyeQuestion->delete())
                                {
                                    $deletedItems[] = $myGamefasteyeQuestion->id;
                                    $this->registry->me->writelog('gamefasteyequestion_delete', $myGamefasteyeQuestion->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myGamefasteyeQuestion->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGamefasteyeQuestion->id;
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
		
		$_SESSION['gamefasteyequestionBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($pointFilter > 0)
		{
			$paginateUrl .= 'point/'.$pointFilter . '/';
			$formData['fpoint'] = $pointFilter;
			$formData['search'] = 'point';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_GamefasteyeQuestion::getGamefasteyeQuestions($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$gamefasteyequestions = Core_GamefasteyeQuestion::getGamefasteyeQuestions($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'gamefasteyequestions' 	=> $gamefasteyequestions,
												'statusOptions' => Core_GamefasteyeQuestion::getStatusList(),
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
            if($_SESSION['gamefasteyequestionAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGamefasteyeQuestion = new Core_GamefasteyeQuestion();

					
					$myGamefasteyeQuestion->gfeid = $formData['fgfeid'];
					$myGamefasteyeQuestion->name = $formData['fname'];
					$myGamefasteyeQuestion->image = $formData['fimage'];
					$myGamefasteyeQuestion->answer = serialize($formData['fanswer']);
					$myGamefasteyeQuestion->correct = $formData['fcorrect'];
					$myGamefasteyeQuestion->point = $formData['fpoint'];
					$myGamefasteyeQuestion->displayorder = $formData['fdisplayorder'];
					$myGamefasteyeQuestion->status = $formData['fstatus'];
					
                    if($myGamefasteyeQuestion->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('gamefasteyequestion_add', $myGamefasteyeQuestion->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['gamefasteyequestionAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_GamefasteyeQuestion::getStatusList(),
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'gamefasteye' => Core_Gamefasteye::getGamefasteyes(array(), '', ''),
												
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
		$myGamefasteyeQuestion = new Core_GamefasteyeQuestion($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myGamefasteyeQuestion->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fgfeid'] = $myGamefasteyeQuestion->gfeid;
			$formData['fid'] = $myGamefasteyeQuestion->id;
			$formData['fname'] = $myGamefasteyeQuestion->name;
			$formData['fimage'] = $myGamefasteyeQuestion->image;
			$formData['fanswer'] = unserialize($myGamefasteyeQuestion->answer);
			$formData['fcorrect'] = $myGamefasteyeQuestion->correct;
			$formData['fpoint'] = $myGamefasteyeQuestion->point;
			$formData['fdisplayorder'] = $myGamefasteyeQuestion->displayorder;
			$formData['fstatus'] = $myGamefasteyeQuestion->status;
			$formData['fdatecreated'] = $myGamefasteyeQuestion->datecreated;
			$formData['fdatemodified'] = $myGamefasteyeQuestion->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['gamefasteyequestionEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myGamefasteyeQuestion->gfeid = $formData['fgfeid'];
						$myGamefasteyeQuestion->name = $formData['fname'];
						$myGamefasteyeQuestion->image = $formData['fimage'];
						$myGamefasteyeQuestion->answer = serialize($formData['fanswer']);
						$myGamefasteyeQuestion->correct = $formData['fcorrect'];
						$myGamefasteyeQuestion->point = $formData['fpoint'];
						$myGamefasteyeQuestion->displayorder = $formData['fdisplayorder'];
						$myGamefasteyeQuestion->status = $formData['fstatus'];
                        
                        if($myGamefasteyeQuestion->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('gamefasteyequestion_edit', $myGamefasteyeQuestion->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['gamefasteyequestionEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'statusOptions' => Core_GamefasteyeQuestion::getStatusList(),
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'gamefasteye' => Core_Gamefasteye::getGamefasteyes(array(), '', ''),
													
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
		$myGamefasteyeQuestion = new Core_GamefasteyeQuestion($id);
		if($myGamefasteyeQuestion->id > 0)
		{
			//tien hanh xoa
			if($myGamefasteyeQuestion->delete())
			{
				$redirectMsg = str_replace('###id###', $myGamefasteyeQuestion->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('gamefasteyequestion_delete', $myGamefasteyeQuestion->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGamefasteyeQuestion->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['fimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errImageRequired'];
			$pass = false;
		}

		if($formData['fpoint'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPointRequired'];
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

		if($formData['fimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errImageRequired'];
			$pass = false;
		}

		if($formData['fpoint'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPointRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}
