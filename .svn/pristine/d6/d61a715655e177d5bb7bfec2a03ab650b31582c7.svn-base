<?php

Class Controller_Cms_Productyear Extends Controller_Cms_Base 
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
		
		
		$pidFilter = (int)($this->registry->router->getArg('pid'));
		$countarticleFilter = (int)($this->registry->router->getArg('countarticle'));
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
            if($_SESSION['productyearBulkToken']==$_POST['ftoken'])
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
                            $myProductyear = new Core_Productyear($id);
                            
                            if($myProductyear->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductyear->delete())
                                {
                                    $deletedItems[] = $myProductyear->id;
                                    $this->registry->me->writelog('productyear_delete', $myProductyear->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myProductyear->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductyear->id;
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
		
		$_SESSION['productyearBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($countarticleFilter > 0)
		{
			$paginateUrl .= 'countarticle/'.$countarticleFilter . '/';
			$formData['fcountarticle'] = $countarticleFilter;
			$formData['search'] = 'countarticle';
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
		$total = Core_Productyear::getProductyears($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$productyears = Core_Productyear::getProductyears($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'productyears' 	=> $productyears,
												'statusOptions' => Core_Productyear::getStatusList(),
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
            if($_SESSION['productyearAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myProductyear = new Core_Productyear();

					
					$myProductyear->pid = $formData['fpid'];
					$myProductyear->countarticle = $formData['fcountarticle'];
					$myProductyear->status = $formData['fstatus'];
					
                    if($myProductyear->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productyear_add', $myProductyear->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['productyearAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_Productyear::getStatusList(),
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
		$myProductyear = new Core_Productyear($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myProductyear->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpid'] = $myProductyear->pid;
			$formData['fid'] = $myProductyear->id;
			$formData['fcountarticle'] = $myProductyear->countarticle;
			$formData['fstatus'] = $myProductyear->status;
			$formData['fdatecreated'] = $myProductyear->datecreated;
			$formData['fdatemodified'] = $myProductyear->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productyearEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myProductyear->pid = $formData['fpid'];
						$myProductyear->countarticle = $formData['fcountarticle'];
						$myProductyear->status = $formData['fstatus'];
                        
                        if($myProductyear->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productyear_edit', $myProductyear->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['productyearEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_Productyear::getStatusList(),
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
		$myProductyear = new Core_Productyear($id);
		if($myProductyear->id > 0)
		{
			//tien hanh xoa
			if($myProductyear->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductyear->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('productyear_delete', $myProductyear->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductyear->id, $this->registry->lang['controller']['errDelete']);
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
	
	public function getpointarticleAction() 
	{
		$articles = Core_ProductyearArticle::getProductyearArticles(array('fstatus'=> Core_ProductyearArticle::STATUS_ENABLE), '', '');
		foreach ($articles as $article) {
			$url = $this->registry->conf['rooturl'] .'product-of-the-year/' . Helper::codau2khongdau($article->title, true, true) . '-' . $article->id;
			
			//Get total like from facebook
			$json = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls=' . $url);
			$arrayfb = json_decode($json);
			$countlikefb = $arrayfb[0]->like_count;
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://plusone.google.com/_/+1/fastbutton?bsv&size=tall&hl=it&url=".urlencode($url));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$html = curl_exec ($curl);
			curl_close ($curl);
			$doc = new DOMDocument();
			libxml_use_internal_errors(true);
			$doc->loadHTML($html);
			$counter=$doc->getElementById('aggregateCount');
			$countlike_google = str_replace('.', '', $counter->nodeValue) ;
			
			$article->point = (int)$countlikefb + (int)$countlike_google;
			$article->updateData();
			
		}
		
	}
}
