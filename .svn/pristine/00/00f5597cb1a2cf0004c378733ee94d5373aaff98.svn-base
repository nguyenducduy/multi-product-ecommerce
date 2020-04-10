<?php

Class Controller_Profile_Group Extends Controller_Profile_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		
		$this->registry->smarty->assign(array(	
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
		$successGroupUrl = '';
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['groupAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGroup = new Core_User();
					$myGroup->fullname = $formData['fname'];
					$myGroup->screenname = Helper::codau2khongdau($formData['fname'], true, true);
					$myGroup->groupid = GROUPID_GROUP;
					$myGroup->parentid = $this->registry->me->id;
					$myGroup->bio = Helper::plaintext($formData['fbio']);
					
                    if($myGroup->addData())
                    {
						$success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('group_add', $myGroup->id, array('name' => $myGroup->fullname));
                        $formData = array(); 

     					$successGroupUrl = $myGroup->getUserPath();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['groupAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'successGroupUrl' => $successGroupUrl,
												'error'			=> $error,
												'success'		=> $success,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
	}
	
	
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myGroup = new Core_User($id);
		

		if($myGroup->id > 0 && $myGroup->parentid == $this->registry->me->id)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fname'] = $myGroup->fullname;
			$formData['fbio'] = $myGroup->bio;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['groupEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						$myGroup->bio = $formData['fbio'];
                        
                        if($myGroup->updateData(array('fullname' => $formData['fname'])))
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('group_edit', $myGroup->id, array('newname' => $formData['fname']));
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
		}
			
		
		$_SESSION['groupEditToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'error'		=> $error,
												'success'	=> $success,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
		$this->registry->smarty->assign(array(
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
		
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myGroup = new Core_User($id);
		if($myGroup->id > 0 && $myGroup->parentid == $this->registry->me->id)
		{
			//tien hanh xoa
			if($myGroup->delete())
			{
				$redirectMsg = str_replace('###id###', $myGroup->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('group_delete', $myGroup->id, array('name' => $myGroup->fullname));  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGroup->id, $this->registry->lang['controller']['errDelete']);
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
		
		if(strlen($formData['fname']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errGroupnameRequired'];
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		if(strlen($formData['fname']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errGroupnameRequired'];
		}
				
		return $pass;
	}
}

