<?php

Class Controller_Cms_Keyword Extends Controller_Cms_Base 
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
		
		
		$fromFilter = (int)($this->registry->router->getArg('from'));
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
            if($_SESSION['keywordBulkToken']==$_POST['ftoken'])
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
                            $myKeyword = new Core_Keyword($id);
                            
                            if($myKeyword->id > 0)
                            {
                                //tien hanh xoa
                                if($myKeyword->delete())
                                {
                                    $deletedItems[] = $myKeyword->id;
                                    $this->registry->me->writelog('keyword_delete', $myKeyword->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myKeyword->id;
                            }
                            else
                                $cannotDeletedItems[] = $myKeyword->id;
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
		
		$_SESSION['keywordBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($fromFilter > 0)
		{
			$paginateUrl .= 'from/'.$fromFilter . '/';
			$formData['ffrom'] = $fromFilter;
			$formData['search'] = 'from';
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

			if($searchKeywordIn == 'text')
			{
				$paginateUrl .= 'searchin/text/';
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
		$total = Core_Keyword::getKeywords($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$keywords = Core_Keyword::getKeywords($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'keywords' 	=> $keywords,
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
												'statusList'    => Core_Keyword::getStatusList(),
												'typeList'    => Core_Keyword::getTypeList()
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
            if($_SESSION['keywordAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myKeyword = new Core_Keyword();

					
					$myKeyword->text = $formData['ftext'];
					$myKeyword->slug = $formData['fslug'];
					$myKeyword->from = $formData['ffrom'];
					$myKeyword->status = $formData['fstatus'];
					
                    if($myKeyword->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('keyword_add', $myKeyword->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['keywordAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'    => Core_Keyword::getStatusList(),
												'typeList'    => Core_Keyword::getTypeList()
												
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
		$myKeyword = new Core_Keyword($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myKeyword->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myKeyword->id;
			$formData['ftext'] = $myKeyword->text;
			$formData['fslug'] = $myKeyword->slug;
			$formData['fcounttotal'] = $myKeyword->counttotal;
			$formData['fcountproduct'] = $myKeyword->countproduct;
			$formData['fcountnews'] = $myKeyword->countnews;
			$formData['fcountstuff'] = $myKeyword->countstuff;
			$formData['ffrom'] = $myKeyword->from;
			$formData['fstatus'] = $myKeyword->status;
			$formData['fdatecreated'] = $myKeyword->datecreated;
			$formData['fdatemodified'] = $myKeyword->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['keywordEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myKeyword->text = $formData['ftext'];
						$myKeyword->slug = $formData['fslug'];
						$myKeyword->from = $formData['ffrom'];
						$myKeyword->status = $formData['fstatus'];
                        
                        if($myKeyword->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('keyword_edit', $myKeyword->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['keywordEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'    => Core_Keyword::getStatusList(),
													'typeList'    => Core_Keyword::getTypeList()
													
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
		$myKeyword = new Core_Keyword($id);
		if($myKeyword->id > 0)
		{
			//tien hanh xoa
			if($myKeyword->delete())
			{
				$redirectMsg = str_replace('###id###', $myKeyword->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('keyword_delete', $myKeyword->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myKeyword->id, $this->registry->lang['controller']['errDelete']);
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
	
	
	/**
	 * Boi vi khi import keyword trong qua trinh import product
	 * Da khong su dung co che Hash cua keyword, nen tao ra action nay de giai quyet dong rac nay
	 */
	public function fixproductkeywordimportAction()
	{
		set_time_limit(0);
		
		//lay tat ca keyword
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'keyword
				ORDER BY k_id ASC';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$hash = md5($row['k_text']);
			
			$sql = 'UPDATE ' . TABLE_PREFIX . 'keyword
					SET k_hash = ?
					WHERE k_id = ?';
			$this->registry->db->query($sql, array($hash, $row['k_id']));
		}
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
			$pass = false;
		}
				
		return $pass;
	}

	public function verifyproductkeywordAction()
	{
		$sqlSelect = 'SELECT p_id FROM lit_product ORDER BY p_id ASC';

		$stmt = $this->registry->db->query($sqlSelect);

		while($row = $stmt->fetch())
		{
			set_time_limit(0);

			$objectid = $row['p_id'];

			$sqlCheck = 'SELECT *, count(k_id) as number 
							FROM '. TABLE_PREFIX .'rel_item_keyword
							WHERE ik_objectid = '. $objectid .' AND ik_type=1
							GROUP BY k_id';

			$stmt2 = $this->registry->db->query($sqlCheck);

			while($row2 = $stmt2->fetch())
			{
				if($row2['number'] > 1)
				{
					$sqlDelete = 'DELETE FROM '. TABLE_PREFIX .'rel_item_keyword WHERE k_id = '.$row2['k_id'].' AND ik_type = 1 AND ik_objectid = '. $objectid .' LIMIT '.(--$row2['number']).'';

					$this->registry->db->query($sqlDelete);
				}
			}
		}
	}
}

