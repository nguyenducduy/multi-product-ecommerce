<?php

class Controller_Site_EventProductHours extends Controller_Site_Base{
	public function indexAction()
	{
		//$starttime = '';//'29-08-2013 08:00:00';
		//$endtime = '31-08-2013 12:00:00';
		$starttime = strtotime('2013-11-01 08:00:00');
		$endtime = strtotime('2013-11-20 20:00:00');
		$today = time();
		$minute = 1;  // default 1 phut

		////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////
					
			$cachefile = 'sitehtml_eventproducthours02092013';
			$myCache = new Cacher($cachefile);
			$pageHtml = '';
			if(isset($_GET['live'])){
				$myCache->clear();
			}
			else $pageHtml = $myCache->get();
			if(!$pageHtml)
			{
				/*$productActive = Core_EventProductHours::getEventProductHourss(array('fstatus' => Core_EventProductHours::STATUS_BUYING ),'','',1);
				$productRand = Core_EventProductHours::getProductRand(Core_EventProductHours::STATUS_DISABLED);
				$productRand->status = Core_EventProductHours::STATUS_BUYING;
				if($productRand->updateData()){
				}*/
				$listproductActive = array();
				$listproductDisable = array();
				$listProduct = Core_EventProductHours::getEventProductHourss(array('fcomingisactive'=>1),'displayorder','ASC');
				/* List product discount  */
				$listDiscountProduct = array();
				$listDiscount = Core_DiscountProduct::getDiscountProducts(array('fstatus' => 1,'ftype'=>3), 'displayorder', 'ASC');
				//var_dump($listDiscount);die;
				foreach ($listDiscount as $discount) {
					$listProduct2 = array();
					if($discount->listproduct != ''){
						$listProductID = explode(',', $discount->listproduct);
						foreach ($listProductID as $productID) {
							$product = new Core_Product($productID);
							$listProduct2[] = $product;
						}
					}
				}
				/* End list product discount*/
				$productActive_randid = 0;
				$lastminute = 0;
				foreach ($listProduct as $product) {
					if($product->status == Core_EventProductHours::STATUS_BUYING && $product->expiretime >= time()){
						$listproductActive = $product;
						$minute = $product->eventtime;
						$productActive_randid = $product->randid;
					}elseif ($product->status == Core_EventProductHours::STATUS_DISABLED){
						$customerwinner = $this->getUserLucky($product->id);
						$newdisableproduct = $product;
						$listproductDisable[] = array('product' => $newdisableproduct, 'userinfo' => $customerwinner);
						
						$product->customerwinner = $customerwinner;
						$lastminute +=$product->eventtime;
					}
				}
				if (!empty($listproductDisable))
				{
					$cachedisable = new Cacher('sitehtml_eventproducthours02092013_listproductold');
					$cachedisable->set(json_encode($listproductDisable, true));		
					if(isset($_GET['live']))
					{
						$cachedisable->clear();
					}
					else{
						$cachedisable->get();
					}			
				}				
				// Tinh thời gian hết hạn và số phút còn l
				

				
				//echodebug($listProduct);
				$this->registry->smarty->assign(array(
	                                                      'listproduct' => $listProduct,
														  'realtime' =>  1 * 60 * 1000,
														  'productActive_randid' =>  $productActive_randid,
														  'discount' =>1,
														  'countdowntime' => $countdowntime,
														  'countdownnone' => $countdownnone,
														  'customerwinner' => $customerwinner,
														  'listProduct2'	=> $listProduct2,
														  
				));
				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');

				$this->registry->smarty->assign(array('contents' => $contents,
					'pageTitle'=>'Mua hàng đồng giá 33,000 - Mừng dienmay.com tròn 3 tuổi'
				));
				$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index.tpl');
				$myCache->set($pageHtml);
			}
			echo $pageHtml;
		
		
	}
	
	public function indexajaxAction()
	{	$starttime = strtotime('2013-11-05 08:00:00');
		$endtime = strtotime('2013-11-20 20:00:00');
		$today = time();
		$minute = 1;  // default 1 phut
		if($today >= $starttime && $today <= $endtime)
		{		
			$formData = array();
			$returnValue = array();
			$starttime = time();
			$expiredproduct = array();
			
			//lay nhung san pham nao dang ban
			$getProductBuying =  Core_EventProductHours::getEventProductHourss(array('fstatus' => Core_EventProductHours::STATUS_BUYING,'fisactive'=>1),'displayorder','ASC','0,1');
			if(count($getProductBuying) > 0)
			{
				if($getProductBuying[0]->expiretime < time())
				{
					 ////////////////////////////////////////////
					 $expiredproduct['product'] = $getProductBuying[0];
					 $expiredproduct['userinfo'] = $this->getUserLucky($getProductBuying[0]->id);
					 $this->updateStatus($getProductBuying[0]->id, Core_EventProductHours::STATUS_DISABLED, $getProductBuying[0]->expiretime);
					 //Lay thong tin cua thanh vien voi san pham vua gan tinh trang da~ ban xg
					 ////////////////////////////////////////////
					 $formData2['fstatus'] = Core_EventProductHours::STATUS_ENABLE;
					 $formData2['fisactive'] = 1;
					 $getProduct =  Core_EventProductHours::getEventProductHourss($formData2 ,'pid', 'ASC', '0,1');
					 $getAllProductIsBuying = Core_EventProductHours::getEventProductHourss(array('fisactive'=>1,'fstatus'=>Core_EventProductHours::STATUS_BUYING) ,'pid', 'DESC');
					 if(count($getProduct) > 0 && count($getAllProductIsBuying) <= 0)
					 {
						  $newProduct = $getProduct[0]; 
						  $expiredtime = time() + $newProduct->eventtime*60;
						 if($this->updateStatus($newProduct->id, Core_EventProductHours::STATUS_BUYING, $expiredtime))// Cap nhat lai trang thai san pham moi de ban 
						 {
							  $returnValue['news']['randid'] = $newProduct->randid;
							  $returnValue['news']['pid'] = $newProduct->id; // tra ve id san pham moi dc cap nhat trang thai
							  $returnValue['news']['times'] = $expiredtime;
							  $returnValue['news']['images'] = $newProduct->images;
							  $returnValue['news']['name'] = $newProduct->name;
							  $returnValue['news']['price'] = Helper::formatPrice($newProduct->currentprice);
						  	  $returnValue['news']['discountprice'] = Helper::formatPrice($newProduct->discountprice);
                              $cachefile2 = 'sitehtml_eventproducthours02092013';
                              $removeCache1 = new Cacher($cachefile2);
                              $removeCache1->clear();
						 }
					 }				 
				}
				else
				{
					$newProduct = $getProductBuying[0];				
					$returnValue['news']['randid'] = $newProduct->randid;
					$returnValue['news']['pid'] = $newProduct->id; // tra ve id san pham moi dc cap nhat trang thai
					$returnValue['news']['times'] = $newProduct->eventtime;
					$returnValue['news']['images'] = $newProduct->images;
					$returnValue['news']['name'] = $newProduct->name;
					$returnValue['news']['price'] = Helper::formatPrice($newProduct->currentprice);
					$returnValue['news']['discountprice'] = Helper::formatPrice($newProduct->discountprice);
				}
			}
			else
			{
				// chon 1 san pham va cap nhat trang thai 
				$formData2['fstatus'] = Core_EventProductHours::STATUS_ENABLE;
				$formData2['fisactive'] = 1;
				$getProduct =  Core_EventProductHours::getEventProductHourss($formData2 ,'pid', 'ASC', '0,1');
				$getAllProductIsBuying = Core_EventProductHours::getEventProductHourss(array('fisactive'=>1,'fstatus'=>Core_EventProductHours::STATUS_BUYING) ,'pid', 'DESC');
				 if(count($getProduct) > 0 && count($getAllProductIsBuying) <= 0)
				 {
					  $newProduct = $getProduct[0]; 
					  $expiredtime = time() + $newProduct->eventtime*60;
					 if($this->updateStatus($newProduct->id, Core_EventProductHours::STATUS_BUYING, $expiredtime))// Cap nhat lai trang thai san pham moi de ban 
					 {
						  $returnValue['news']['randid'] = $newProduct->randid;
						  $returnValue['news']['pid'] = $newProduct->id; // tra ve id san pham moi dc cap nhat trang thai
						  $returnValue['news']['times'] = $expiredtime;
						  $returnValue['news']['images'] = $newProduct->images;
						  $returnValue['news']['name'] = $newProduct->name;
						  $returnValue['news']['price'] = Helper::formatPrice($newProduct->currentprice);
						  $returnValue['news']['discountprice'] = Helper::formatPrice($newProduct->discountprice);
					 }
				 }			 			
			}
			
			//lay danh sach nhung nguoi het han		
			$cachedisable = new Cacher('sitehtml_eventproducthours02092013_listproductold');
			$listproductDisable = json_decode($cachedisable->get(), true);
			
			$listolduser = array();
			$listnewcache = array();
			$counter = 0;
			if (!empty($listproductDisable))
			{
				foreach ($listproductDisable as $productold)
				{
					$item = array();
					$item['name'] = $productold['product']['name'];
					$item['randid'] = $productold['product']['randid'];
					$item['pid'] = $productold['product']['id'];
					$item['price'] = Helper::formatPrice($productold['product']['currentprice']);
					$item['discountprice'] = Helper::formatPrice($productold['product']['discountprice']);
					$item['images'] = $productold['product']['images'];
					$item['fullname'] = $productold['userinfo']['fullname'];
					$item['email'] = substr_replace($productold['userinfo']['email'],'xxxx',strpos($productold['userinfo']['email'],"@"),4);
					$item['phone'] = substr_replace ($productold['userinfo']['phone'] , 'xxxx' , 3 ,4);
					$listolduser['k_'.$counter++] = $item;
					$listnewcache[] = $productold;
				}
			}
			if (!empty($expiredproduct))
			{
				$item = array();
				$item['name'] = $expiredproduct['product']->name;
				$item['randid'] = $expiredproduct['product']->randid;
				$item['pid'] = $expiredproduct['product']->id;
				$item['price'] = Helper::formatPrice($expiredproduct['product']->currentprice);
				$item['discountprice'] = Helper::formatPrice($expiredproduct['product']->discountprice);
				$item['images'] = $expiredproduct['product']->images;
				$item['fullname'] = $expiredproduct['userinfo']->fullname;
				$item['email'] = substr_replace($expiredproduct['userinfo']->email,'xxxx',strpos($expiredproduct['userinfo']->email,"@")-4,4);
				$item['phone'] = substr_replace ($expiredproduct['userinfo']->phone,'xxxx',3,4);
				
				$listolduser['k_'.$counter++] = $item;
				$listnewcache[] = $expiredproduct;
				if (!empty($listnewcache)) $cachedisable->set(json_encode($listnewcache, true));
			}
			$returnValue['old'] = $listolduser;
			
			echo json_encode($returnValue);
		}
	}
	public function getUserLucky($productid)
	{
		$userInfo = array();
		$relProductUser = Core_RelProductEventUser::getRelProductEventUsers(array('fepid'=>$productid, 'fposition' => 29),'id','DESC','0,1');
		if(count($relProductUser) == 1)
		{
			$getuserinfo = Core_EventUserHours::getEventUserHourss(array('fid'=>$relProductUser[0]->euid),'','', '0,1');
			if (!empty($getuserinfo))
			{
				$userInfo = $getuserinfo[0];
			}
		}
		return $userInfo;
	}
	public function theleAction()
	{
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'popupthele.tpl');
	}

	public function listuserwinerAction()
	{
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'listuserwinner.tpl');
	}

	public function listuserluckyAction()
	{
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'listuserlucky.tpl');
	}

	public function updateStatus($productid, $status, $expiretime)
	{
		$myproducthours = new Core_EventProductHours($productid);
		$myproducthours->status = $status;
		$myproducthours->expiretime = $expiretime;
		return $myproducthours->updateData();
	}

	public function addeventuserAction()
	{

		$error = array();
		$success = array();
		$warning = array();
		$formData = array();
		$productid = $_GET['pid'];
		$cachefile = "p02092013".$productid;
		$myCache = new Cacher($cachefile);
		$eventproducthours = new Core_EventProductHours($productid);
		$disiablebutton = '';
		if($eventproducthours->id > 0 && $eventproducthours->status == Core_EventProductHours::STATUS_BUYING )
		{
			if(!empty($_POST['submit']))
			{

				if($_SESSION['eventUserToken'] == $_POST['ftoken'])
				{	
					$formData = array_merge($_POST,$formData);
					if($this->addActionValidator($formData,$error))
					{
						if($this->addValidateUserExsist($formData,$eventproducthours->id,$error))
						{
							$eventUser =  new Core_EventUserHours();
							$eventUser->fullname = $formData['ffullname'];
							$eventUser->email = $formData['femail'];
							$eventUser->phone = $formData['fphone'];
							if($eventUser->addData())
							{
								if (isset($formData['fregister'])){
									$this->addsubscriber($formData['femail']);
								}
								$relProductUser = new Core_RelProductEventUser();
								$relProductUser->euid = $eventUser->id;
								$relProductUser->epid = $eventproducthours->id;
								$position = $myCache->get();
								if(empty($position))
								{
									//get user from database if cache null
									$getUserfromDb = Core_RelProductEventUser::getRelProductEventUsers(array('fepid' => $eventproducthours->id), 'position', 'DESC', 1);
									if (count($getUserfromDb) > 0)
									{
										$position = $getUserfromDb[0]->position;
										$position++;
									}
									else $position = 1;
								}									
								else
									$position++;
								$myCache->set($position);
								$relProductUser->position = $position;
								if($postion == 33)
								{
									$relProductUser->status = 1;
									$eventUser->epid = $eventproducthours->id;
								}
								if($relProductUser->addData())
								{
									$success[] = $this->registry->lang['controller']['successForm'];
									$formData = array();
	 							}
	 							$disiablebutton = 'ok';
							}
							else
							{
								$error[] = 'Lỗi trong quá trình xử lý dữ liệu vui lòng thử lại';
							}
						}
					}
				}
			}
		}
		$this->registry->smarty->assign(array(
										'error' => $error,
										'success'=>$success,
										'formData'=>$formData,
										'disiablebutton'=>$disiablebutton
										));
		$_SESSION['eventUserToken'] = Helper::getSecurityToken();
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'popupregister.tpl');
		
	}

	public function listuserAction()
	{
		$recordPerPage 	= 50;
		$error 			= array();
	    $success 		= array();
	    $warning 		= array();
	    $formData 		= array('fbulkid' => array());
	    $_SESSION['securityToken']=Helper::getSecurityToken();//Token
        $page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
        $epid 			= $this->registry->router->getArg('pid');
        //GET ARG
      	$search		= (string)($this->registry->router->getArg('search'));
        $keywordFilter 		= (string)($this->registry->router->getArg('keyword'));
      	$searchKeywordIn 		= (string)($this->registry->router->getArg('searchin'));
        $fphone			= (string)($this->registry->router->getArg('phone'));
    
        //END GET ARG
	    /*$sortby 	= $this->registry->router->getArg('sortby');
	    if($sortby == '') $sortby = 'position';
	        $formData['sortby'] = $sortby;
	    $sorttype 	= $this->registry->router->getArg('sorttype');
	    if(strtoupper($sorttype) != 'DESC') 
	        $sorttype = 'ASC';*/
	    $sortby 	= 'position';
	    $sorttype 	= 'ASC';
	    $formData['sortby'] = 'position';
	    $formData['sorttype'] = 'ASC';

	    $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/listuser/pid/'.$epid.'/';
	    //////
	    if($search != "")
	    {
		    if($keywordFilter != "")
		    {

		        $paginateUrl .= 'keyword/' . $keywordFilter . '/';
		        $formData['fkeywordFilter'] = $keywordFilter;
		         if($searchKeywordIn == 'fullname')
		        {
		            $paginateUrl .= 'searchin/name/';
		        }
		        elseif($searchKeywordIn == 'email')
		        {
		            $paginateUrl .= 'searchin/email/';
		        }
		        $formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
		        $formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
		        $formData['search'] = 'keyword';
		       
		    }
		    if($fphone  != "")
		    {
		        $paginateUrl .= 'phone/'.$fphone . '/';
		        $formData['fphone'] = $fphone;
		    }
		}
	    //////
	    //echo (($page - 1)*$recordPerPage);
	    $eventProduct =  new Core_EventProductHours($epid);
	    if($eventProduct->id > 0)
	    {
		    $formDataRel['fepid'] = $epid;
		    $relProductEventUserList = Core_RelProductEventUser::getRelProductEventUsers($formDataRel,$sortby,$sorttype,(($page - 1)*$recordPerPage).','.$recordPerPage);
		    $countkey  = (($page - 1)*$recordPerPage);
		    $total = Core_RelProductEventUser::getRelProductEventUsers($formDataRel, $sortby, $sorttype, 0, true);
	        $totalPage = ceil($total/$recordPerPage);
	        $curPage = $page;
	        $filterUrl = $paginateUrl;
	        ///////////////////////////////////////////////////////////////////////////////////
		    $userListID = array();
		    foreach ($relProductEventUserList as $k => $relProductEventUser) {
		    	$userListID[$k+1] = $relProductEventUser->euid;
		    }
		    if(!empty($userListID))
		    {
	        	foreach ($userListID as $key => $userID) 
	        	{
	        		$formData['fid'] = $userID;
	        		$eventUserHoursList[++$countkey] = Core_EventUserHours::getEventUserHourss($formData, $sortby, $sorttype);
	        	}
	        	
	        }
	    }
	//echodebug($relProductEventUserList);
	//echodebug($eventUserHoursList);
        ///////////////////////////////////////////////////////////////////////////////////////
	    $this->registry->smarty->assign(array(	         
	        'formData'		=> $formData,
	        'success'		=> $success,
	        'error'			=> $error,
	        'warning'		=> $warning,
	        'paginateurl' 	=> $paginateUrl,
	        'filterUrl'		=> $filterUrl,
	        'total'			=> $total,
	        'totalPage' 	=> $totalPage,
	        'curPage'		=> $curPage,
	        'formDataRel'	=> $formDataRel,
	        'eventProduct'	=> $eventProduct,
			'epid' => $epid,
	        'eventUserHoursList'=>$eventUserHoursList
											
		));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'popupshow.tpl');
	

	}
	private function addValidateUserExsist($data,$productid,&$error)
	{
		$formData['fphone'] = $data['fphone'];
		$formData['femail'] = $data['femail'];
		
		$eventUser = Core_EventUserHours::getEventUserHourss($formData,'','', '0,1');
		$pass = true;
		if(count($eventUser) > 0)
		{
			if($eventUser[0]->epid > 0)
			{
				$error[] = $this->registry->lang['controller']['userLucky'];
				$pass = false;
			}
			else
			{
				$evenProduct = Core_RelProductEventUser::getRelProductEventUsers(array('fepid'=>$productid,'feuid'=>$eventUser[0]->id),'','', '0,1');
				if(count($evenProduct)>0)
				{
					$error[] = $this->registry->lang['controller']['userExsistRegister'];
					$pass = false;
				}
			}
		}
		return $pass;
	}
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		if($formData['ffullname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errffullnameRequired'];
			$pass = false;
		}
		if($formData['femail'] == '')
		{
			$error[] = $this->registry->lang['controller']['errfemailRequired'];
			$pass = false;
		}elseif(!Helper::validatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errvalidatefemailRequired'];
			$pass = false;
		}
		if($formData['fphone'] == '' || !Helper::checkPhoneAvalible($formData['fphone']))
		{
			$error[] = 'Vui lòng nhập số điện thoại đúng và hợp lệ';//$this->registry->lang['controller']['errfphoneRequired'];
			$pass = false;
		}
		return $pass;
	}
	
	private function addsubscriber($email){
		$success = 0;
		if (Helper::ValidatedEmail($_POST['femail'])) {
			$mySubscriber = new Core_Subscriber();
			$mysub        = $mySubscriber->getSubscribers(array('femail' => $email), '', '', '0,1');
			if (count($mysub) == 0) {					
				$user                = Core_User::getUsers(array('femail' => $email), '', '', '0,1');
				if (count($user) == 0) $mySubscriber->uid   = 0;
				else $mySubscriber->uid   = $user[0]->id;
				$mySubscriber->email = $email;
				$mySubscriber->campaign = 220130902;
				$mySubscriber->addData();
				$success = 1;				
			}
			else $success = 1;
		}
		else {
			$success = 0;
		}
		return $success;
	}
	public function countdownajaxAction()
	{
		$listProduct = Core_EventProductHours::getEventProductHourss(array('fcomingisactive'=>1),'displayorder','ASC');
		$listProductActive = Core_EventProductHours::getEventProductHourss(array('fisactive'=>1),'displayorder','ASC');
		if(!empty($listProduct) && empty($listProductActive))
		{
			$timetmp = date('d/m/Y H:i:s',$listProduct[0]->begindate);
			$time = explode(' ', $timetmp);
			$datetime = explode('/', $time[0]);
			$hourtime = explode(':', $time[1]);
			$countdownnone = '';
			$countdownDelay = mktime($hourtime[0], $hourtime[1], $hourtime[2], $datetime[1],$datetime[0],$datetime[2]) - time();
			if($countdownDelay > 0)
			{
				$remainDay = floor($countdownDelay / (3600 * 24));
				$remainHour = floor(($countdownDelay - $remainDay * 24 * 3600) / 3600);
				$remainMinute = floor(($countdownDelay - $remainDay * 24 * 3600 - $remainHour*3600)/60);
				$remainSecond = $countdownDelay - $remainDay * 24 * 3600 - $remainHour * 3600 - $remainMinute * 60;
			}	
			else
			{
				$countdownnone = 'reload';
			}
			$countdowntime = sprintf('%02d',$remainDay).':'.sprintf('%02d',$remainHour).':'.sprintf('%02d',$remainMinute).':'.sprintf('%02d',$remainSecond);
			echo $countdowntime;
		}
	}

}
