<?php

Class Controller_Cms_Event Extends Controller_Cms_Base 
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
		$permission = $this->registry->router->getArg('permission');

		$uidFilter = (int)($this->registry->router->getArg('uid'));
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
            if($_SESSION['pageBulkToken']==$_POST['ftoken'])
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
                            $myEvent = new Core_Event($id);
                            
                            if($myEvent->id > 0)
                            {
                            	//tien hanh xoa
                                if($myEvent->delete())
                                {
                                    $deletedItems[] = $myEvent->id;
                                    $this->registry->me->writelog('page_delete', $myEvent->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myEvent->id;
                            	
                            }
                            else
                                $cannotDeletedItems[] = $myEvent->id;
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
        
		
		$_SESSION['pageBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
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

            if($searchKeywordIn == 'title')
            {
                $paginateUrl .= 'searchin/title/';
            }
            elseif($searchKeywordIn == 'content')
            {
                $paginateUrl .= 'searchin/content/';
            }
            $formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
            $formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
            $formData['search'] = 'keyword';
        }
		
			
		//tim tong so
		$total = Core_Event::getPages($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$pages = Core_Event::getPages($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'pages' 	=> $pages,
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
                                                'statusList'    => Core_Event::getStatusList(), 
												'themeList'		=> Core_EventTheme::getEventthemes(array(), 'name', 'ASC', '')
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['eventTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
		
	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		$slugList = array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['eventAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);
               	
				$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
               	//get all slug related to current slug
				if($formData['fslug'] != '')
					$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

               	if($this->addActionValidator($formData, $error))
                {
                    $myEvent = new Core_Event();

					$myEvent->uid = $this->registry->me->id;
					$myEvent->title = Helper::plaintext($formData['ftitle']);
					$myEvent->slug = Helper::codau2khongdau($formData['fslug'], true, true);
					$myEvent->themeid = $formData['fthemeid'];
					$myEvent->content = $formData['fcontent'];
                    //$myEvent->content = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myEvent->content);
					$myEvent->productstyle = $formData['fproductstyle'];
                    $myEvent->iscounter = $formData['fiscounter'];
					if(!empty($formData['fstarttime'])) $myEvent->starttime = Helper::strtotimedmy($formData['fstarttime']);
                    else $myEvent->starttime = 0;
                   	if(!empty($formData['fendtime'])) $myEvent->endtime = Helper::strtotimedmy($formData['fendtime']);
					else $myEvent->endtime = 0;
                    $myEvent->seotitle = $formData['fseotitle'];
					$myEvent->seokeyword = $formData['fseokeyword'];
                    $myEvent->seodescription = $formData['fseodescription'];
					$myEvent->metarobot = $formData['fmetarobot'];
					$myEvent->topseokeyword = $formData['ftopseokeyword'];
					$myEvent->footerkey = $formData['ffooterkey'];
					$myEvent->status = $formData['fstatus'];
					$myEvent->blank = $formData['fblank'];
					
                    if($myEvent->addData())
                    {
                    	//Insert keyword to keyword table
			            if($formData['fkeyword'] != '')
			            {
			            	$keywordArr = explode(',', $formData['fkeyword']);

			            	foreach($keywordArr as $keyword)
			            	{
			            		$existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');
			            		
			            		if(empty($existKeyword))
			            		{
			            			$myKeyword = new Core_Keyword();
			            			$myKeyword->text = trim($keyword);
			            			$myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
			            			$myKeyword->hash = MD5($keyword);
			            			$myKeyword->from = Core_Keyword::TYPE_EVENT;
			            			$myKeyword->status = Core_Keyword::STATUS_ENABLE;

			            			$myKeyword->id = $myKeyword->addData();

			            			$record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myEvent->id), '', '', '');
			            			
			            			if(empty($record))
			            			{
			            				$myRelkeyword = new Core_RelItemKeyword();
				            			$myRelkeyword->kid = $myKeyword->id;
				            			$myRelkeyword->type = Core_RelItemKeyword::TYPE_EVENT;
				            			$myRelkeyword->objectid = $myEvent->id;

				            			$myRelkeyword->addData();
			            			}
			            		}

			            		foreach($existKeyword as $existkey)
			            		{
			            			$record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myEvent->id), '', '', '');

			            			if(empty($record))
			            			{
			            				$myRelkeyword = new Core_RelItemKeyword();
				            			$myRelkeyword->kid = $existkey->id;
				            			$myRelkeyword->type = Core_RelItemKeyword::TYPE_EVENT;
				            			$myRelkeyword->objectid = $myEvent->id;

				            			$myRelkeyword->addData();
			            			}
			            		}
			            	}
			            }

                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('event_add', $myEvent->id, array());

                        //$urlcron = $this->registry->conf['rooturl']."/task/externalimagedownload/imagepagedownloadbyid?id=".$myEvent->id;
                        //Run scon
                       // Helper::backgroundHttpGet($urlcron);
                        $formData = array();   

						///////////////////////////////////
   						//Add Slug base on slug of page
						$mySlug = new Core_Slug();
						$mySlug->uid = $this->registry->me->id;
						$mySlug->slug = $myEvent->slug;
						$mySlug->controller = 'event';
						$mySlug->objectid = $myEvent->id;
						if(!$mySlug->addData())
						{
							$error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';
							
							//reset slug of current item
							$myEvent->slug = '';
							$myEvent->updateData();
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

		$_SESSION['eventAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
                                                'statusList'    => Core_Event::getStatusList(),
												'themeList'		=> Core_EventTheme::getEventthemes(array(), 'name', 'ASC', ''),
												'slugList'		=> $slugList,
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['eventTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myEvent = new Core_Event($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myEvent->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			$slugList	= array();
			
			$formData['fbulkid'] = array();
			
			//select keyword
			$myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $myEvent->id), 'ik_id', 'ASC', '');
			$selectKeywordArr = array();

			foreach($myKeyword as $keyword)
			{
				$selectKeyword = new Core_Keyword($keyword->kid);
				
				$selectKeywordArr[] = $selectKeyword->text;
			}

			$formData['fkeyword'] = implode(',',$selectKeywordArr);
			
			$formData['fuid'] = $myEvent->uid;
			$formData['fid'] = $myEvent->id;
			$formData['ftitle'] = $myEvent->title;
			$formData['fslug'] = $myEvent->slug;
			$formData['fcontent'] = $myEvent->content;
			$formData['fproductstyle'] = $myEvent->productstyle;
			$formData['fiscounter'] = $myEvent->iscounter;
			if(!empty( $myEvent->starttime)) $formData['fstarttime'] = date('d/m/Y', $myEvent->starttime);
                else $formData['fstarttime'] = 0;

                if(!empty($myEvent->endtime)) $formData['fendtime'] = date('d/m/Y',$myEvent->endtime);
                else $formData['fendtime'] = 0;

			$formData['fseotitle'] = $myEvent->seotitle;
			$formData['fseokeyword'] = $myEvent->seokeyword;
            $formData['fseodescription'] = $myEvent->seodescription;
			$formData['fmetarobot'] = $myEvent->metarobot;
			$formData['ftopseokeyword'] = $myEvent->topseokeyword ;
			$formData['ffooterkey'] = $myEvent->footerkey ;
			$formData['fcountview'] = $myEvent->countview;
			$formData['fcountreview'] = $myEvent->countreview;
			$formData['fthemeid'] = $myEvent->themeid;
			$formData['fstatus'] = $myEvent->status;
			$formData['fipaddress'] = $myEvent->ipaddress;
			$formData['fdatecreated'] = $myEvent->datecreated;
			$formData['fdatemodified'] = $myEvent->datemodified;
			$formData['fblank'] = $myEvent->blank;
		
			//Current Slug
			$formData['fslugcurrent'] = $myEvent->slug;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['eventEditToken'] == $_POST['ftoken'])
                {
					
                    $formData = array_merge($formData, $_POST);
					/////////////////////////
					//get all slug related to current slug
					$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
					if($formData['fslug'] != '')
						$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');
					
					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myEvent->title = $formData['ftitle'];
						$myEvent->slug = $formData['fslug'];
						$myEvent->content = $formData['fcontent'];
                        //$myEvent->content = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myEvent->content);
						$myEvent->productstyle = $formData['fproductstyle'];
                        $myEvent->iscounter = $formData['fiscounter'];
						if(!empty($formData['fstarttime'])) $myEvent->starttime = Helper::strtotimedmy($formData['fstarttime']);
                    	else $myEvent->starttime = 0;
                   		if(!empty($formData['fendtime'])) $myEvent->endtime = Helper::strtotimedmy($formData['fendtime']);
						else $myEvent->endtime = 0;
                        $myEvent->seotitle = $formData['fseotitle'];
						$myEvent->seokeyword = $formData['fseokeyword'];
                        $myEvent->seodescription = $formData['fseodescription'];
						$myEvent->metarobot = $formData['fmetarobot'];
						$myEvent->topseokeyword = $formData['ftopseokeyword'];
						$myEvent->footerkey = $formData['ffooterkey'];
						$myEvent->status = $formData['fstatus'];
						$myEvent->themeid = $formData['fthemeid'];
						$myEvent->blank = $formData['fblank'];
                        
                        if($myEvent->updateData())
                        {
                        	//update keyword to keyword table
				            if($formData['fkeyword'] != '')
				            {
				            	$keywordArr = explode(',', $formData['fkeyword']);

				            	//kiem tra array de xoa keyword
				            	$checkKeyword = array_diff($selectKeywordArr, $keywordArr);
				            	
				            	if(!empty($checkKeyword))
				            	{
				            		foreach($checkKeyword as $keyname)
				            		{
				            			$keyhash = MD5($keyname);

				            			$deleteList = Core_Keyword::getKeywords(array('fkeyword' => $keyhash), '', '', '');

				            			foreach($deleteList as $delete)
				            			{
				            				$myDelete = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $delete->id), '', '', '');

				            				foreach($myDelete as $deleted)
				            				{
				            					$deleted->delete();
				            				}
				            			}
				            		}
				            	}
				            	
				            	foreach($keywordArr as $keyword)
				            	{
				            		$existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');
				            		
				            		if(empty($existKeyword))
				            		{
				            			$myKeyword = new Core_Keyword();
				            			$myKeyword->text = trim($keyword);
				            			$myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
				            			$myKeyword->hash = MD5($keyword);
				            			$myKeyword->from = Core_Keyword::TYPE_EVENT;
				            			$myKeyword->status = Core_Keyword::STATUS_ENABLE;

				            			$myKeyword->id = $myKeyword->addData();

				            			$record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myEvent->id), '', '', '');
				            			
				            			if(empty($record))
				            			{
				            				$myRelkeyword = new Core_RelItemKeyword();
					            			$myRelkeyword->kid = $myKeyword->id;
					            			$myRelkeyword->type = Core_RelItemKeyword::TYPE_EVENT;
					            			$myRelkeyword->objectid = $myEvent->id;

					            			$myRelkeyword->addData();
				            			}
				            		}

				            		foreach($existKeyword as $existkey)
				            		{
				            			$record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myEvent->id), '', '', '');

				            			if(empty($record))
				            			{
				            				$myRelkeyword = new Core_RelItemKeyword();
					            			$myRelkeyword->kid = $existkey->id;
					            			$myRelkeyword->type = Core_RelItemKeyword::TYPE_EVENT;
					            			$myRelkeyword->objectid = $myEvent->id;

					            			$myRelkeyword->addData();
				            			}
				            		}
				            	}
				            }

                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('page_edit', $myEvent->id, array());

                            //$urlcron = $this->registry->conf['rooturl']."/task/externalimagedownload/imagepagedownloadbyid?id=".$myEvent->id;
                            //Run scon
                            //Helper::backgroundHttpGet($urlcron);
							///////////////////////////////////
	   						//Add Slug base on slug of page
							if($formData['fslug'] != $formData['fslugcurrent'])
							{
								$mySlug = new Core_Slug();
								$mySlug->uid = $this->registry->me->id;
								$mySlug->slug = $myEvent->slug;
								$mySlug->controller = 'event';
								$mySlug->objectid = $myEvent->id;
								if(!$mySlug->addData())
								{
									$error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

									//reset slug of current item
									$myEvent->slug = $formData['fslugcurrent'];
									$myEvent->updateData();
								}
								else
								{
									//Add new slug ok, keep old slug but change the link to keep the reference to new ref
									Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'page', $myEvent->id);
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
			
			
			$_SESSION['eventEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'slugList'	=> $slugList,
                                                    'statusList'    => Core_Event::getStatusList(),
													'themeList'		=> Core_EventTheme::getEventthemes(array(), 'name', 'ASC', ''),
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['eventTitle_edit'].' &raquo; '.$myEvent->title,
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
		$myEvent = new Core_Event($id);
		if($myEvent->id > 0)
		{
			//tien hanh xoa
			if($myEvent->delete())
			{
				$redirectMsg = str_replace('###id###', $myEvent->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('page_delete', $myEvent->id, array());  	
				
				//xoa slug lien quan den item nay
				Core_Slug::deleteSlug($myEvent->slug, 'event', $myEvent->id);
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myEvent->id, $this->registry->lang['controller']['errDelete']);
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
		
		
		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		/*if($formData['fseodescription'] == '')
        {
            $error[] = $this->registry->lang['controller']['errMetaDescriptionRequired'];
            $pass = false;
        }*/

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
		
		

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		/*if($formData['fseodescription'] == '')
        {
            $error[] = $this->registry->lang['controller']['errMetaDescriptionRequired'];
            $pass = false;
        }*/

        if($formData['fstatus'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStatusRequired'];
			$pass = false;
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


