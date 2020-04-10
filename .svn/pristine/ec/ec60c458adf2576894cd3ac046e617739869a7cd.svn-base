<?php

Class Controller_Cms_ReverseAuctions Extends Controller_Cms_Base 
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
		
		
		$productnameFilter = (string)($this->registry->router->getArg('productname'));
		$priceFilter = (float)($this->registry->router->getArg('price'));
		$startdateFilter = (int)($this->registry->router->getArg('startdate'));
		$enddateFilter = (int)($this->registry->router->getArg('enddate'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
		$datemodifiedFilter = (int)($this->registry->router->getArg('datemodified'));
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
            if($_SESSION['reverseauctionsBulkToken']==$_POST['ftoken'])
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
                            $myReverseAuctions = new Core_ReverseAuctions($id);
                            
                            if($myReverseAuctions->id > 0)
                            {
                                //tien hanh xoa
                                if($myReverseAuctions->delete())
                                {
                                    $deletedItems[] = $myReverseAuctions->id;
                                    $this->registry->me->writelog('reverseauctions_delete', $myReverseAuctions->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myReverseAuctions->id;
                            }
                            else
                                $cannotDeletedItems[] = $myReverseAuctions->id;
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
		
		$_SESSION['reverseauctionsBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($productnameFilter != "")
		{
			$paginateUrl .= 'productname/'.$productnameFilter . '/';
			$formData['fproductname'] = $productnameFilter;
			$formData['search'] = 'productname';
		}

		if($priceFilter > 0)
		{
			$paginateUrl .= 'price/'.$priceFilter . '/';
			$formData['fprice'] = $priceFilter;
			$formData['search'] = 'price';
		}

		if($startdateFilter > 0)
		{
			$paginateUrl .= 'startdate/'.$startdateFilter . '/';
			$formData['fstartdate'] = $startdateFilter;
			$formData['search'] = 'startdate';
		}

		if($enddateFilter > 0)
		{
			$paginateUrl .= 'enddate/'.$enddateFilter . '/';
			$formData['fenddate'] = $enddateFilter;
			$formData['search'] = 'enddate';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
		}

		if($datemodifiedFilter > 0)
		{
			$paginateUrl .= 'datemodified/'.$datemodifiedFilter . '/';
			$formData['fdatemodified'] = $datemodifiedFilter;
			$formData['search'] = 'datemodified';
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

			if($searchKeywordIn == 'productname')
			{
				$paginateUrl .= 'searchin/productname/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_ReverseAuctions::getReverseAuctionss($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$reverseauctionss = Core_ReverseAuctions::getReverseAuctionss($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'reverseauctionss' 	=> $reverseauctionss,
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
		$myReverseStatus = new Core_ReverseAuctions();
		$statusList = $myReverseStatus->getStatusList();
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['reverseauctionsAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);      
                if($this->addActionValidator($formData, $error))
                {
                    $myReverseAuctions = new Core_ReverseAuctions();
					$myReverseAuctions->productname = $formData['fproductname'];
					$myReverseAuctions->image = serialize($formData['fimage']);
					$myReverseAuctions->video = $formData['fvideo'];
					$myReverseAuctions->image360 = $formData['fimage360'];
					$myReverseAuctions->price = Helper::refineMoneyString($formData['fprice']);
					$myReverseAuctions->content = $formData['fcontent'];
					$myReverseAuctions->technical = $formData['ftechnical'];
					$myReverseAuctions->status  = $formData['fstatus'];
					$myReverseAuctions->isshowblock  = $formData['fisshowblock'];
					$myReverseAuctions->journalistically = $formData['fjournalistically'];
					$myReverseAuctions->startdate = Helper::strtotimedmy($formData['fstartdate'],$formData['fsttime']);
					$myReverseAuctions->enddate = Helper::strtotimedmy($formData['fenddate'],$formData['fextime']);
					
                    if($myReverseAuctions->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('reverseauctions_add', $myReverseAuctions->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['reverseauctionsAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'	=> $statusList,
												
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
		$myReverseAuctions = new Core_ReverseAuctions($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myReverseAuctions->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			$statusList = $myReverseAuctions->getStatusList();
			$formData['fid'] = $myReverseAuctions->id;
			$formData['fproductname'] = $myReverseAuctions->productname;
			$images = unserialize($myReverseAuctions->image);
			$formData['fimage'] = $images;
			$formData['fstatus'] = $myReverseAuctions->status;
			$formData['fisshowblock'] = $myReverseAuctions->isshowblock;
			$formData['fvideo'] = $myReverseAuctions->video;
			$formData['fimage360'] = $myReverseAuctions->image360;
			$formData['fprice'] = (float)$myReverseAuctions->price;
			$formData['fcontent'] = $myReverseAuctions->content;
			$formData['ftechnical'] = $myReverseAuctions->technical;
			$formData['fjournalistically'] = $myReverseAuctions->journalistically;
			$startdate = date("d/m/Y H:i:s",$myReverseAuctions->startdate);
			$startdate = explode(" ", $startdate);
			$formData['fstartdate'] = $startdate[0];
			$formData['fsttime'] = $startdate[1];

			$enddate = date("d/m/Y H:i:s",$myReverseAuctions->enddate);
			$enddate = explode(" ", $enddate);
			$formData['fenddate'] = $enddate[0];
			$formData['fextime'] = $enddate[1];

			$formData['fdatecreated'] = $myReverseAuctions->datecreated;
			$formData['fdatemodified'] = $myReverseAuctions->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['reverseauctionsEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
					
						$myReverseAuctions->productname = $formData['fproductname'];
						$myReverseAuctions->image = serialize($formData['fimage']);
						$myReverseAuctions->video = $formData['fvideo'];
						$myReverseAuctions->image360 = $formData['fimage360'];
						$myReverseAuctions->price = Helper::refineMoneyString($formData['fprice']);
						$myReverseAuctions->content = $formData['fcontent'];
						$myReverseAuctions->technical = $formData['ftechnical'];
						$myReverseAuctions->status = $formData['fstatus'];
						$myReverseAuctions->isshowblock  = $formData['fisshowblock'];
						$myReverseAuctions->journalistically = $formData['fjournalistically'];
						$myReverseAuctions->startdate = Helper::strtotimedmy($formData['fstartdate'],$formData['fsttime']);
						$myReverseAuctions->enddate = Helper::strtotimedmy($formData['fenddate'],$formData['fextime']);
                        
                        if($myReverseAuctions->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('reverseauctions_edit', $myReverseAuctions->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['reverseauctionsEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList' => $statusList,
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
		$myReverseAuctions = new Core_ReverseAuctions($id);
		if($myReverseAuctions->id > 0)
		{
			//tien hanh xoa
			if($myReverseAuctions->delete())
			{
				$cachefile1 = 'daugianguoc';
                $removeCache1 = new Cacher($cachefile1,Cacher::STORAGE_MEMCACHED);
                $removeCache1->clear();
                $cachefile2 = 'runningproductold';
                $removeCache2 = new Cacher($cachefile2,Cacher::STORAGE_REDIS);
                $removeCache2->clear();
				$redirectMsg = str_replace('###id###', $myReverseAuctions->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('reverseauctions_delete', $myReverseAuctions->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myReverseAuctions->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fproductname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errProductnameRequired'];
			$pass = false;
		}

		if($formData['fimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errImageRequired'];
			$pass = false;
		}

		if($formData['fvideo'] == '')
		{
			$error[] = $this->registry->lang['controller']['errVideoRequired'];
			$pass = false;
		}

		if($formData['fprice'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPriceMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		if($formData['fstartdate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStartdateRequired'];
			$pass = false;
		}

		if($formData['fenddate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEnddateRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fproductname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errProductnameRequired'];
			$pass = false;
		}

		if($formData['fimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errImageRequired'];
			$pass = false;
		}

		if($formData['fvideo'] == '')
		{
			$error[] = $this->registry->lang['controller']['errVideoRequired'];
			$pass = false;
		}

		if($formData['fprice'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPriceMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		if($formData['fstartdate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStartdateRequired'];
			$pass = false;
		}

		if($formData['fenddate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEnddateRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>