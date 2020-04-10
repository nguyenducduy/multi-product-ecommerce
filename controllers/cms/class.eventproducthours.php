<?php 
	Class Controller_Cms_EventProductHours Extends Controller_Cms_Base{
		private $recordPerPage = 20;
		public function indexAction()
		{
			$error 			= array();
	        $success 		= array();
	        $warning 		= array();
	        $formData 		= array('fbulkid' => array());
	        $_SESSION['securityToken']=Helper::getSecurityToken();//Token
	        //GET ARG
          	$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
          	$tab 			= (int)($this->registry->router->getArg('tab'));
          	// END GET ARG
	        $sortby 	= $this->registry->router->getArg('sortby');
	        if($sortby == '') $sortby = 'displayorder';
	        	$formData['sortby'] = $sortby;
	        $sorttype 	= $this->registry->router->getArg('sorttype');
	        if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
	        	$formData['sorttype'] = $sorttype;

	        ////////////////////////////////////////////////////////////////////////////////////////////
	       	////////////////////////////////////////////////////////////////////////////////////////////
	        $formData['ftype'] = 3;
	        $total = Core_DiscountProduct::getDiscountProducts($formData, $sortby, $sorttype, 0, true);
        	$totalPage = ceil($total/$this->recordPerPage);
        	$curPage = $page;
        	// Tien hanh xu~ ly delete
	        if(!empty($_POST['fsubmitbulk']))
	        {
	            if($_SESSION['discountproductBulkToken']==$_POST['ftoken'])
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
	                            $myDiscountProduct = new Core_DiscountProduct($id);

	                            if($myDiscountProduct->id > 0)
	                            {
	                                //tien hanh xoa
	                                if($myDiscountProduct->delete())
	                                {
	                                    $deletedItems[] = $myDiscountProduct->id;
	                                    $this->registry->me->writelog('DiscountProduct_delete', $myDiscountProduct->id, array());
	                                }
	                                else
	                                    $cannotDeletedItems[] = $myDiscountProduct->id;
	                            }
	                            else
	                                $cannotDeletedItems[] = $myDiscountProduct->id;
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
	            $tab = 2;
	        }
          	if(!empty($_POST['fsubmitchangeorder']))
        	{
            	if($_SESSION['discountproductBulkToken']==$_POST['ftoken'])
	            {
	                $displayorderList = $_POST['fdisplayorder'];
	                foreach($displayorderList as $id => $neworder)
	                {
	                    $myItem = new Core_DiscountProduct($id);
	                    if($myItem->id > 0 && $myItem->displayorder != $neworder)
	                    {
	                        $myItem->displayorder = $neworder;
	                        $myItem->updateData();
	                    }
	                }
	                $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
	            }
            }
	       
        	// End tien hanh xu~ ly dele
	        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';

        	$discountProduct = Core_DiscountProduct::getDiscountProducts($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

        	$filterUrl = $paginateUrl;
        	//append sort to paginate url
	        $paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

	        //build redirect string
	        $redirectUrl = $paginateUrl;
	        if($curPage > 1)
	        {
	            $redirectUrl .= 'page/' . $curPage;
	            $filterUrl .= 'page/' . $curPage."/";
	        }
	        $redirectUrl = base64_encode($redirectUrl);
	        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        // Tien hanh xu~ ly delete
	        if(!empty($_POST['fsubmitbulkevent']))
	        {
	            if($_SESSION['discountproductBulkToken']==$_POST['ftoken'])
	            {

	                if(!isset($_POST['fbulkidevent']))
	                {
	                    $warning[] = $this->registry->lang['default']['bulkItemNoSelected'];

	                }
	                else
	                {
	                    $formData['fbulkidevent'] = $_POST['fbulkidevent'];

	                    //check for delete
	                    if($_POST['fbulkeventaction'] == 'delete')
	                    {
	                        $delArr = $_POST['fbulkidevent'];
	                        $deletedItems = array();
	                        $cannotDeletedItems = array();
	                        foreach($delArr as $id)
	                        {
	                            //check valid user and not admin user
	                            $myEventProductHours = new Core_EventProductHours($id);

	                            if($myEventProductHours->id > 0)
	                            {
	                                //tien hanh xoa
	                                if($myEventProductHours->delete())
	                                {
	                                    $deletedItems[] = $myEventProductHours->id;
	                                    $this->registry->me->writelog('EventProductHours_delete', $myEventProductHours->id, array());
	                                }
	                                else
	                                    $cannotDeletedItems[] = $myEventProductHours->id;
	                            }
	                            else
	                                $cannotDeletedItems[] = $myEventProductHours->id;
	                        }

	                        if(count($deletedItems) > 0)
	                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

	                        if(count($cannotDeletedItems) > 0)
	                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
	                    }
	                    else
	                    {
	                    	$isok = false;
	                    	if($_POST['fbulkeventaction'] == 'choban')
	                    	{
	                    		echo "adsasd";
	                    		$statusArr = $_POST['fbulkidevent'];
		                        foreach($statusArr as $id)
		                        {
		                            //check valid user and not admin user
		                            $myEventProductHours = new Core_EventProductHours($id);

		                            if($myEventProductHours->id > 0)
		                            {
		                                //tien hanh capnhat
		                                $myEventProductHours->status = Core_EventProductHours::STATUS_ENABLE;
		                                if($myEventProductHours->updateData())
		                                	$isok = true;
		                            }
		                          
		                        }

	                    		
	                    	}
	                    	if($_POST['fbulkeventaction'] == 'daban')
	                    	{
	                    		$statusArr = $_POST['fbulkidevent'];
		                        foreach($statusArr as $id)
		                        {
		                            //check valid user and not admin user
		                            $myEventProductHours = new Core_EventProductHours($id);

		                            if($myEventProductHours->id > 0)
		                            {
		                                 //tien hanh capnhat
		                                $myEventProductHours->status = Core_EventProductHours::STATUS_DISABLED;
		                                if($myEventProductHours->updateData())
		                                	$isok = true;
		                            }
		                          
		                        }
	                    	}
	                    	if($_POST['fbulkeventaction'] == 'chobanngaysau')
	                    	{
	                    		$statusArr = $_POST['fbulkidevent'];
		                        foreach($statusArr as $id)
		                        {
		                            //check valid user and not admin user
		                            $myEventProductHours = new Core_EventProductHours($id);

		                            if($myEventProductHours->id > 0)
		                            {
		                                 //tien hanh capnhat
		                                $myEventProductHours->status = Core_EventProductHours::STATUS_COMMING;
		                                if($myEventProductHours->updateData())
		                                	$isok = true;
		                            }
		                          
		                        }
	                    	}
	                    	if($isok == false)
	                    	{
		                        //bulk action not select, show error
		                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
	                    	}
	                    }
	                }
	            }
	        }
          	if(!empty($_POST['fsubmitchangeorderevent']))
        	{
            	if($_SESSION['discountproductBulkToken']==$_POST['ftoken'])
	            {
	                $displayorderList = $_POST['fdisplayorder'];
	                foreach($displayorderList as $id => $neworder)
	                {
	                    $myItem = new Core_EventProductHours($id);
	                    if($myItem->id > 0 && $myItem->displayorder != $neworder)
	                    {
	                        $myItem->displayorder = $neworder;
	                        $myItem->updateData();
	                    }
	                }
	                $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
	            }
            }
	        $eventProductHours = Core_EventProductHours::getEventProductHourss(array(),'displayorder','ASC');
	        $_SESSION['discountproductBulkToken'] = Helper::getSecurityToken();
	        $this->registry->smarty->assign(array(	
	        	'discountProduct' => $discountProduct,           
	            'formData'		=> $formData,
	            'success'		=> $success,
	            'error'			=> $error,
	            'warning'		=> $warning,
	            'redirectUrl'		=> $redirectUrl,
	            'paginateurl' 	=> $paginateUrl,
	            'redirectUrl'	=> $redirectUrl,
	            'filterUrl'		=> $filterUrl,
	            'total'			=> $total,
	            'totalPage' 	=> $totalPage,
	            'curPage'		=> $curPage,
	            'tab'			=> $tab,
	            'eventProductHours'=>$eventProductHours
												
			));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		public function addAction()
		{
			$contents = '';
			$error = array();
			$success = array();
			$warning = array();
			$formData =array();
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['eventProductAddToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($_POST,$formData);
					$formData['fcurrentprice'] = str_replace(",", "", $formData['fcurrentprice']);
					$formData['fdiscountprice'] = str_replace(",", "", $formData['fdiscountprice']);
					if($this->addActionValidator($formData,$error)){
						$eventProductHours =  new Core_EventProductHours();
						$eventProductHours->pid = $formData['fpid'];
						$eventProductHours->name = $formData['fname'];
						$eventProductHours->images = $formData['fimages'];
						$eventProductHours->currentprice = $formData['fcurrentprice'];
						$eventProductHours->discountprice = $formData['fdiscountprice'];
						$eventProductHours->eventtime = $formData['feventtime'];
						$eventProductHours->status = $formData['fstatus'];
						$eventProductHours->datecreated = time();
						$eventProductHours->begindate = Helper::strtotimedmy($formData['fbegindate'],$formData['fsttime']);
						$eventProductHours->enddate = Helper::strtotimedmy($formData['fenddate'],$formData['fextime']);
						$eventCheckRandID = Core_EventProductHours::getEventProductHourss(array(),'displayorder','ASC');
						$randidexist = array();
						foreach ($eventCheckRandID as $value) {
							$randidexist[] = $value->randid;
						}
						//echodebug($randidexist);

						$randid = rand(10000,99999);
						while (in_array($randid, $randidexist)){
							$randid = rand(10000,99999);
						}
						$eventProductHours->randid = $randid;
						if($eventProductHours->addData())
						{
							$success[] = $this->registry->lang['controller']['succEventProductAdd'];
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errEventProductAdd'];;
						}
					}

				}
			}
			$_SESSION['eventProductAddToken'] = Helper::getSecurityToken();
			$this->registry->smarty->assign(array(
											"error"=>$error,
											"success"=>$success,
											"formData" => $formData
										));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		public function editAction()
		{
			$id = $this->registry->router->getArg('id');
			$contents = '';
			$error = array();
			$success = array();
			$warning = array();
			$formData =array();
			$myEventProductHours = new Core_EventProductHours($id);
			if($myEventProductHours->id > 0)
			{
				$formData['fname'] = $myEventProductHours->name;
				$formData['fimages'] = $myEventProductHours->images;
				$formData['fcurrentprice'] = $myEventProductHours->currentprice;
				$formData['fdiscountprice'] = $myEventProductHours->discountprice;
				$formData['feventtime'] = $myEventProductHours->eventtime;
				$formData['fstatus'] = $myEventProductHours->status;
				$formData['fpid'] = $myEventProductHours->pid;

				$begindate = date("d/m/Y H:i:s",$myEventProductHours->begindate);
				$begindate = explode(" ", $begindate);
				$formData['fbegindate'] = $begindate[0];
				$formData['fsttime'] = $begindate[1];

				$enddate = date("d/m/Y H:i:s",$myEventProductHours->enddate);
				$enddate = explode(" ", $enddate);
				$formData['fenddate'] = $enddate[0];
				$formData['fextime'] = $enddate[1];

				if(!empty($_POST['fsubmit']))
				{
					if($_SESSION['eventProductEditToken'] == $_POST['ftoken'])
					{
						$formData = array();
						$formData = array_merge($_POST,$formData);
						$formData['fcurrentprice'] = str_replace(",", "", $formData['fcurrentprice']);
						$formData['fdiscountprice'] = str_replace(",", "", $formData['fdiscountprice']);
						if($this->editActionValidator($formData,$error)){
							$eventProductHours =  new Core_EventProductHours();
							$eventProductHours->id = $id;
							$eventProductHours->pid = $formData['fpid'];
							$eventProductHours->name = $formData['fname'];
							$eventProductHours->images = $formData['fimages'];
							$eventProductHours->currentprice = $formData['fcurrentprice'] ;
							$eventProductHours->discountprice = $formData['fdiscountprice'];
							$eventProductHours->eventtime = $formData['feventtime'];
							$eventProductHours->status = $formData['fstatus'];
							$eventProductHours->begindate = Helper::strtotimedmy($formData['fbegindate'],$formData['fsttime']);
							$eventProductHours->enddate = Helper::strtotimedmy($formData['fenddate'],$formData['fextime']);
							$eventProductHours->datemodified = time();
							$eventProductHours->datecreated = $myEventProductHours->datecreated;
							$eventProductHours->randid = $myEventProductHours->randid;
							if($eventProductHours->updateData())
							{
								$success[] = $this->registry->lang['controller']['succEventProductEdit'];
							}
							else{
								$success[] = $this->registry->lang['controller']['succEventProductEdit'];
							}
						}	
					}
				}
			}
			$_SESSION['eventProductEditToken'] = Helper::getSecurityToken();
			$this->registry->smarty->assign(array(
											"error"=>$error,
											"success"=>$success,
											"formData" => $formData
										));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		public function getDiscountProductList($formData)
		{
			
		}
		public function adddiscountAction()
	    {
	    	$error 	= array();
			$success 	= array();
	        $warning    = array();
			$contents 	= '';
			$formData 	= array();
			if(!empty($_POST['fsubmit']))
			{
	            if($_SESSION['discountAddToken'] == $_POST['ftoken'])
	            {
	            	$formData = array_merge($formData,$_POST);
	            	if($formData['fdiscountname'] != ""){
            			$discountproduct = new Core_DiscountProduct();
            			$discountproduct->discountname = $formData['fdiscountname'];
            			$discountproduct->displayorder = $formData['fdisplayorder'];
            			$discountproduct->type = 3;
            			$discountproduct->datecreated = time();
            			$discountproduct->status = $formData['fstatus'];
            			if($discountproduct->addData())
            			{
            				$success[] = "Thêm thành công";
            			}
            			else{
            				$error[] = "Thêm không thành công";
            			}
	            	}
	            	else{
	            		$error[] = "Vui lòng nhập tên loại giảm giá";
	            	}
	            }
	        }
        	$_SESSION['discountAddToken']=Helper::getSecurityToken();//Tao token moi
        	$this->registry->smarty->assign(array(	'formData' 		=> $formData,
													'error'			=> $error,
	                                                'success'        => $success,
	                                                'warning' =>$warning
												));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'adddiscount.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	    }	
	     public function editdiscountAction()
	    {
	    	$id = $this->registry->router->getArg('id');
	    	$discountproduct = new Core_DiscountProduct($id);
	    	if($discountproduct->id > 0)
	    	{
	    		$formData = array();
	    		$formData['fdisplayorder'] = $discountproduct->displayorder;
	    		$formData['fdiscountname'] = $discountproduct->discountname;
	    		$formData['ftype'] = $discountproduct->type;
	    		$formData['fstatus'] = $discountproduct->status;
	    		if(isset($_POST['fsubmit']))
	    		{
	    			if($_SESSION['editDiscountToken'] == $_POST['ftoken'])
	    			{

	    				$formData = array();
	    				$formData = array_merge($formData,$_POST);
	    				if($formData['fdiscountname'] != "")
	    				{
		    				$mydiscount = new Core_DiscountProduct();
		    				$mydiscount->id = $discountproduct->id;
		    				$mydiscount->discountname = $formData['fdiscountname'];
		    				$mydiscount->type = 3;
		    				$mydiscount->displayorder = $formData['fdisplayorder'];
		    				$mydiscount->datemodified = time();
		    				$mydiscount->status = $formData['fstatus'];
		    				$mydiscount->listproduct = $discountproduct->listproduct;
		    				if($mydiscount->updateData())
		    				{
		    					$success[] = "Cập nhật thành công";
		    				}
		    				else{
		    					$error[] = "Cập nhật không thành công";
		    				}
	    				}
	    				else{
	    					$error[] = "Vui lòng nhập tên loại giảm giá";
	    				}
	    			}
	    		}
	    		
	    		//echo $_SESSION['editDiscountToken'];	
			}
			$_SESSION['editDiscountToken'] = Helper::getSecurityToken();
			$this->registry->smarty->assign(array("formData"=>$formData,
													"success"=>$success,
													"error" => $error
													));
			//Add template
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer."editdiscount.tpl");
			$this->registry->smarty->assign(array(
												"pageTitle"=>"Edit Discount Product",
												"contents" => $contents,
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer."index.tpl");
	    }
	    public function deletediscountAction()
	    {
			$id = $this->registry->router->getArg('id');
	    	$discountproduct = new Core_DiscountProduct($id);
    		if($discountproduct->id > 0)
	    	{
	            //tien hanh xoa
	            if($discountproduct->delete())
	            {
	                $redirectMsg = str_replace('###id###', $discountproduct->id, $this->registry->lang['controller']['succDelete']);

	                $this->registry->me->writelog('discountproduct_delete', $discountproduct->id, array());
	            }
	            else
	            {
	                $redirectMsg = str_replace('###id###', $discountproduct->id, $this->registry->lang['controller']['errDelete']);
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
	    public function deleteAction()
	    {
			$id = $this->registry->router->getArg('id');
	    	$myEventProductHours = new Core_EventProductHours($id);
    		if($myEventProductHours->id > 0)
	    	{
	            //tien hanh xoa
	            if($myEventProductHours->delete())
	            {
	                $redirectMsg = str_replace('###id###', $myEventProductHours->id, $this->registry->lang['controller']['succDelete']);

	                $this->registry->me->writelog('eventproducthours_delete', $myEventProductHours->id, array());
	            }
	            else
	            {
	                $redirectMsg = str_replace('###id###', $myEventProductHours->id, $this->registry->lang['controller']['errDelete']);
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

	    private function addActionValidator($formData, &$error)
		{
			$pass = true;
			
			
			if($formData['fpid'] == '')
			{
				$error[] = $this->registry->lang['controller']['errPidRequired'];
				$pass = false;
			}

			if($formData['fname'] == '')
			{
				$error[] = $this->registry->lang['controller']['errNameRequired'];
				$pass = false;
			}
			if($formData['fimages'] == '')
			{
				$error[] = $this->registry->lang['controller']['errImagesRequired'];
				$pass = false;
			}
	        if($formData['fcurrentprice'] <=0 || !is_numeric($formData['fdiscountprice']))
			{
				$error[] = $this->registry->lang['controller']['errCurrentPriceRequired'];
				$pass = false;
			}

			if($formData['fdiscountprice'] <=0 || !is_numeric($formData['fdiscountprice']) )
			{
				$error[] = $this->registry->lang['controller']['errDiscountPriceRequired'];
				$pass = false;
			}

			if($formData['feventtime'] <= 0 || !is_numeric($formData['fdiscountprice']))
			{
				$error[] = $this->registry->lang['controller']['errEventTimeRequired'];
				$pass = false;
			}

		
			return $pass;
		}
		private function editActionValidator($formData, &$error)
		{
			$pass = true;
			
			
			if($formData['fpid'] == '')
			{
				$error[] = $this->registry->lang['controller']['errPidRequired'];
				$pass = false;
			}

			if($formData['fname'] == '')
			{
				$error[] = $this->registry->lang['controller']['errNameRequired'];
				$pass = false;
			}
			if($formData['fimages'] == '')
			{
				$error[] = $this->registry->lang['controller']['errImagesRequired'];
				$pass = false;
			}
	         if($formData['fcurrentprice'] <=0 || !is_numeric($formData['fdiscountprice']))
			{
				$error[] = $this->registry->lang['controller']['errCurrentPriceRequired'];
				$pass = false;
			}

			if($formData['fdiscountprice'] <=0 || !is_numeric($formData['fdiscountprice']) )
			{
				$error[] = $this->registry->lang['controller']['errDiscountPriceRequired'];
				$pass = false;
			}

			if($formData['feventtime'] <= 0 || !is_numeric($formData['fdiscountprice']))
			{
				$error[] = $this->registry->lang['controller']['errEventTimeRequired'];
				$pass = false;
			}

		
			return $pass;
		}

	}