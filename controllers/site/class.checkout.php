<?php

Class Controller_Site_Checkout Extends Controller_Site_Base 
{
	
	function indexAction() 
	{
		//check whether cart empty or not, if empty, redirect to cart listing page
		$this->checkCartEmpty();
		
		$success = $error = $formData = array();
		
		$formData['ffullname'] = $this->registry->me->fullname;
		$formData['femail'] = $this->registry->me->email;
		$formData['fphone'] = $this->registry->me->phone;
		$formData['faddress'] = $this->registry->me->address;
		$formData['fregion'] = $this->registry->me->region;
		
		if(isset($_SESSION['checkoutInfo']))
		{
			$formData['femail'] = $_SESSION['checkoutInfo']['email'];
			$formData['ffullname'] = $_SESSION['checkoutInfo']['billingfullname'];
			$formData['fphone'] = $_SESSION['checkoutInfo']['billingphone'];
			$formData['faddress'] = $_SESSION['checkoutInfo']['billingaddress'];
			$formData['fregion'] = $_SESSION['checkoutInfo']['billingregion'];
			$formData['fsubregion'] = $_SESSION['checkoutInfo']['billingsubregion'];
			$formData['fnote'] = $_SESSION['checkoutInfo']['note'];
			$formData['fbookforuserid'] = $_SESSION['checkoutInfo']['bookforeuserid'];
		}
		
		//tien hanh luu thong tin lien he
		if(isset($_POST['fsubmit']))
		{
			$formData = array_merge($formData, $_POST);
			if($this->billingValidate($formData, $error))
			{
				//everything ok, just save to session
				$checkoutInfo = array(
					'email'					=> $formData['femail'],
					'billingfullname'		=> $formData['ffullname'],
					'billingphone'			=> $formData['fphone'],
					'billingaddress'		=> $formData['faddress'],
					'billingregion'			=> $formData['fregion'],
					'billingsubregion'		=> $formData['fsubregion'],
					'billingcountry'		=> 'VN',
					'shippingfullname'		=> $formData['ffullname'],
					'shippingphone'			=> $formData['fphone'],
					'shippingaddress'		=> $formData['faddress'],
					'shippingregion'		=> $formData['fregion'],
					'shippingsubregion'		=> $formData['fsubregion'],
					'shippingcountry'		=> 'VN',
					'note'					=> $formData['fnote'],
					'password1'				=> $formData['fpassword1'],
					'bookforuserid'			=> 0
				);
				
				if(isset($_SESSION['checkoutInfo']) && is_array($_SESSION['checkoutInfo']))
					$_SESSION['checkoutInfo'] = array_merge($_SESSION['checkoutInfo'], $checkoutInfo);
				else
					$_SESSION['checkoutInfo'] = $checkoutInfo;
				
				//enable step 3 (payment)
				$_SESSION['checkoutStep3Enable'] = 1;
				
				//everything OK, move to next step.
				header('location: ' . $this->registry->conf['rooturl'] . 'checkout/payment');
				exit();
			}
		}
		
		
		//get the contents of cart
		$pricetotal = 0;
		$items = $this->registry->cart->getContents();
		for($i = 0; $i < count($items); $i++)
		{
			$items[$i]->options = $items[$i]->options;
			$items[$i]->product = new Core_Product($items[$i]->id, true);
			
			//////
			//TO DO: check here
			$items[$i]->pricesell = $items[$i]->product->sellprice;
			$items[$i]->pricereal = $items[$i]->product->sellprice;
			
			
			$items[$i]->subtotal = $items[$i]->quantity * $items[$i]->pricereal;
			$pricetotal += $items[$i]->subtotal;
		}
		
		//get region list from db
		$regionList = Core_Region::getRegions(array('fparentid' => 0), 'displayorder', 'ASC', 100);
		
		
		$this->registry->smarty->assign(array(	'success' => $success,
												'error'	=> $error,
												'formData'	=> $formData,
												'regionList' => $regionList,
												'items' => $items,
												'pricetotal' => $pricetotal,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');   
		
	} 
	
	/**
	 * Sau khi nhap thong tin, tien hanh chuyen sang trang thanh toan
	 */
	function paymentAction() 
	{
		//check whether cart empty or not, if empty, redirect to cart listing page
		$this->checkCartEmpty();
		
		$success = $error = $formData = array();
		
		//
		//check requirement checkoutinfo in first step
		if(!isset($_SESSION['checkoutInfo']))
		{
			header('location: ' . $this->registry->conf['rooturl'] . 'checkout');
			exit();
		}
		
		
		//init some price
		$pricetotal = 0;
		$priceship = 0;
		$pricediscount = 0;
		$pricefinal = 0;
		
		
		////////////////////////////////
		//get the contents of cart
		$pricetotal = 0;
		$items = $this->registry->cart->getContents();
		for($i = 0; $i < count($items); $i++)
		{
			$items[$i]->options = $items[$i]->options;
			$items[$i]->product = new Core_Product($items[$i]->id, true);
			
			//////
			//TO DO: check here
			$items[$i]->pricesell = $items[$i]->product->sellprice;
			$items[$i]->pricereal = $items[$i]->product->sellprice;
			$items[$i]->subtotal = $items[$i]->quantity * $items[$i]->pricereal;
			
			$pricetotal += $items[$i]->subtotal;
		}
		
		/////////////////////////////////////
		//calculate shipping price
		$myRegion = new Core_Region($_SESSION['checkoutInfo']['shippingregion']);
		$mySubregion = new Core_Region($_SESSION['checkoutInfo']['shippingsubregion']);
		
		//init shipping information
		$priceship = -1;
		$priceshipDetail = '';	//thong tin chi tiet ve ship hang
		
		if($myRegion->id > 0)
		{
			//mac dinh cho 1 region la se lay tien ship cho region do
			$priceship = $myRegion->calculatePrice($weighttotal);
			$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionRegion'] . $myRegion->name . $this->registry->lang['controller']['shiptimeOffshore'];
			
			/////////////////////
			// check normal ship
			//Neu tim thay 1 thong tin quan/huyen
			if($mySubregion->id > 0)
			{
				$subregionPriceship = $mySubregion->calculatePrice($weighttotal);
				
				
				//neu chua set tien ship cho subregion tuc la se lay
				//tien ship la tien ship cua parent region
				//chi set tien ship cua region neu co set
				if($subregionPriceship > 0)
				{
					$priceship = $subregionPriceship;
					
					//check noi thanh tphcm de show label khac
					if($mySubregion->isinshore)
						$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionSubregionInshore'] . $mySubregion->name . ', ' . $myRegion->name . $this->registry->lang['controller']['shiptimeInshore'];
					else
						$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionSubregion'] . $mySubregion->name . ', ' . $myRegion->name . $this->registry->lang['controller']['shiptimeOffshore'];
				}
			}
			
			//////////////////////
			//check freeship
			//kiem tra freeship trong noi thanh TPHCM truoc
			if($myRegion->id == 1 && $mySubregion->id > 0 && $mySubregion->isinshore && $pricetotal >= $this->registry->setting['checkout']['freeshipInshore'])
			{
				$priceship = 0;
				$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionFree'] . $this->registry->lang['controller']['shiptimeInshore'];
			}
			elseif($pricetotal >= $this->registry->setting['checkout']['freeshipOffshore'])
			{
				$priceship = 0;
				$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionFree'] . $this->registry->lang['controller']['shiptimeOffshore'];
			}
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
		}
		
		
		
		/////////////////////////
		//init coupon code
		if(isset($_SESSION['checkoutInfo']['couponcode']))
		{
			$myCoupon = new Core_Coupon();
			$myCoupon->getDataFromCode($_SESSION['checkoutInfo']['couponcode']);
			
			if($myCoupon->id > 0 && $myCoupon->isValid($pricetotal, $this->registry->me))
			{
				$pricediscount = $myCoupon->getDiscountValue($pricetotal);
				$pricediscountDetail = $myCoupon->getValueDisplay();
				
				$formData['fcouponcode'] = $_SESSION['checkoutInfo']['couponcode'];
			}
		}
		
		
		
		
		
		/////////////////
		if(isset($_POST['fsubmitcoupon']))
		{
			$formData['fcouponcode'] = $_POST['fcouponcode'];
			
			if($formData['fcouponcode'] != '')
			{
				$myCoupon = new Core_Coupon();
				$myCoupon->getDataFromCode($formData['fcouponcode']);
				
				if($myCoupon->id > 0 && $myCoupon->isValid($pricetotal, $this->registry->me))
				{
					$pricediscount = $myCoupon->getDiscountValue($pricetotal);
					$pricediscountDetail = $myCoupon->getValueDisplay();
					
					$_SESSION['checkoutInfo']['couponcode'] = $formData['fcouponcode'];
					
				}
				else
					$error[] = $this->registry->lang['controller']['errCouponNotFound'];
			}
			else
				$error[] = $this->registry->lang['controller']['errCouponcodeRequired'];
		}
		
		
		//final price
		$pricefinal = $pricetotal + $priceship - $pricediscount;
		
		
		//Calculate the final price to pay
		$pricefinal = $pricetotal + $priceship - $pricediscount;
		
		//////////////////////////////////
		if(isset($_POST['fsubmit']))
		{
			$formData = array_merge($formData, $_POST);
			if($this->paymentValidate($formData, $error))
			{
				//everything OK, save data for next step
				
				$_SESSION['checkoutInfo']['shippingmethod'] = $formData['fshippingmethod'];
				$_SESSION['checkoutInfo']['paymentmethod'] = $formData['fpaymentmethod'];
				$_SESSION['checkoutInfo']['couponcode'] = $formData['fcouponcode'];
				
				//enable step 4 (review)
				$_SESSION['checkoutStep4Enable'] = 1;
				
				
				//everything OK, move to next step.
				header('location: ' . $this->registry->conf['rooturl'] . 'checkout/review');
				exit();
			}
			
			
		}
		
		$this->registry->smarty->assign(array(	'success' => $success,
												'error'	=> $error,
												'formData'	=> $formData,
												'items' => $items,
												'pricetotal' => $pricetotal,
												'priceship' => $priceship,
												'priceshipDetail' => $priceshipDetail,
												'pricediscount' => $pricediscount,
												'pricediscountDetail' => $pricediscountDetail,
												'pricefinal' => $pricefinal,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'payment.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');   
		
	}
	
	/**
	 * Sau khi nhap thong tin, tien hanh chuyen sang trang thanh toan
	 */
	function reviewAction() 
	{
		//check whether cart empty or not, if empty, redirect to cart listing page
		$this->checkCartEmpty();
		
		$success = $error = $formData = array();
		
		//
		//check requirement checkoutinfo in first step
		if(!isset($_SESSION['checkoutInfo']))
		{
			header('location: ' . $this->registry->conf['rooturl'] . 'checkout');
			exit();
		}
		
		
		$bookforuser = $this->registry->me;
			
		
		//init some price
		$pricetotal = 0;
		$priceship = 0;
		$pricediscount = 0;
		$pricetax = 0;
		$pricehandling = 0;
		$pricefinal = 0;
		
		
		////////////////////////////////
		//get the contents of cart
		$pricetotal = 0;
		$items = $this->registry->cart->getContents();
		for($i = 0; $i < count($items); $i++)
		{
			//TODO: 
			$items[$i]->options = $items[$i]->options;
			$items[$i]->product = new Core_Product($items[$i]->id, true);
			
			//////
			//TO DO: check here
			$items[$i]->pricesell = $items[$i]->product->sellprice;
			$items[$i]->pricereal = $items[$i]->product->sellprice;
			$items[$i]->subtotal = $items[$i]->quantity * $items[$i]->pricereal;
			
			$pricetotal += $items[$i]->subtotal;
		}
		
		/////////////////////////////////////
		//calculate shipping price
		$myRegion = new Core_Region($_SESSION['checkoutInfo']['shippingregion']);
		$mySubregion = new Core_Region($_SESSION['checkoutInfo']['shippingsubregion']);
		
		//init shipping information
		$priceship = -1;
		$priceshipDetail = '';	//thong tin chi tiet ve ship hang
		$isShipInshore = false;
		
		if($myRegion->id > 0)
		{
			//mac dinh cho 1 region la se lay tien ship cho region do
			$priceship = $myRegion->calculatePrice($weighttotal);
			$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionRegion'] . $myRegion->name . $this->registry->lang['controller']['shiptimeOffshore'];
			
			/////////////////////
			// check normal ship
			//Neu tim thay 1 thong tin quan/huyen
			if($mySubregion->id > 0)
			{
				$subregionPriceship = $mySubregion->calculatePrice($weighttotal);
				
				
				//neu chua set tien ship cho subregion tuc la se lay
				//tien ship la tien ship cua parent region
				//chi set tien ship cua region neu co set
				if($subregionPriceship > 0)
				{
					$priceship = $subregionPriceship;
					
					//check noi thanh tphcm de show label khac
					if($mySubregion->isinshore)
					{
						$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionSubregionInshore'] . $mySubregion->name . ', ' . $myRegion->name . $this->registry->lang['controller']['shiptimeInshore'];
						$isShipInshore = true;
					}
					else
						$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionSubregion'] . $mySubregion->name . ', ' . $myRegion->name . $this->registry->lang['controller']['shiptimeOffshore'];
				}
			}
			
			//////////////////////
			//check freeship
			//kiem tra freeship trong noi thanh TPHCM truoc
			if($myRegion->id == 1 && $mySubregion->id > 0 && $mySubregion->isinshore && $pricetotal >= $this->registry->setting['checkout']['freeshipInshore'])
			{
				$priceship = 0;
				$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionFree'] . $this->registry->lang['controller']['shiptimeInshore'];
			}
			elseif($pricetotal >= $this->registry->setting['checkout']['freeshipOffshore'])
			{
				$priceship = 0;
				$priceshipDetail = $this->registry->lang['controller']['shipdetailOptionFree'] . $this->registry->lang['controller']['shiptimeOffshore'];
			}
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
		}
		
		
		
		/////////////////////////
		//init coupon code
		if($_SESSION['checkoutInfo']['couponcode'] != '')
		{
			$myCoupon = new Core_Coupon();
			$myCoupon->getDataFromCode($_SESSION['checkoutInfo']['couponcode']);
			
			if($myCoupon->id > 0 && $myCoupon->isValid($pricetotal, $this->registry->me))
			{
				$pricediscount = $myCoupon->getDiscountValue($pricetotal);
				$pricediscountDetail = $myCoupon->getValueDisplay();
			}
		}
		
		////////////////
		// moi xu ly lien quan den init/submit xu phai thuc hien sau cac qua trinh discount va tinh tong gia/shipping.
		
		
		//Calculate the final price to pay
		$pricefinal = $pricetotal + $priceship + $pricetax + $pricehandling - $pricediscount;
		
		//////////////////////////////////
		if(isset($_POST['fsubmit']))
		{
			$formData = array_merge($formData, $_POST);
			if($this->reviewValidate($formData, $error))
			{
				
				$userid = $this->registry->me->id;
				
				//everything ok, create order
				$myOrder = new Core_Orders();
				$myOrder->pricesell = $pricetotal;
				$myOrder->priceship = $priceship;
				$myOrder->pricediscount = $pricediscount;
				$myOrder->pricetax = $pricetax;
				$myOrder->pricehandling = $pricehandling;
				$myOrder->pricefinal = $pricefinal;
				$myOrder->discountcouponcode = $_SESSION['checkoutInfo']['couponcode'];
				$myOrder->paymenttype = $_SESSION['checkoutInfo']['paymentmethod'];
				$myOrder->weight = $weighttotal;
				$myOrder->status = Core_Orders::STATUS_PENDING;
				$myOrder->note = $_SESSION['checkoutInfo']['note'];
				$myOrder->contactemail = $_SESSION['checkoutInfo']['email'];
				$myOrder->isreturncustomer = $this->registry->me->id;
				$myOrder->billinguserid = $userid;
				$myOrder->billingfullname = $_SESSION['checkoutInfo']['billingfullname'];
				$myOrder->billinggender = $this->registry->me->gender;
				$myOrder->billingphone = $_SESSION['checkoutInfo']['billingphone'];
				$myOrder->billingaddress = $_SESSION['checkoutInfo']['billingaddress'];
				$myOrder->billingsubregion = $_SESSION['checkoutInfo']['billingsubregion'];
				$myOrder->billingregion = $_SESSION['checkoutInfo']['billingregion'];
				$myOrder->billingcountry = $_SESSION['checkoutInfo']['billingcountry'];
				$myOrder->shippinguserid = $userid;
				$myOrder->shippingfullname = $_SESSION['checkoutInfo']['shippingfullname'];
				$myOrder->shippinggender = $this->registry->me->gender;
				$myOrder->shippingphone = $_SESSION['checkoutInfo']['shippingphone'];
				$myOrder->shippingaddress = $_SESSION['checkoutInfo']['shippingaddress'];
				$myOrder->shippingsubregion = $_SESSION['checkoutInfo']['shippingsubregion'];
				$myOrder->shippingregion = $_SESSION['checkoutInfo']['shippingregion'];
				$myOrder->shippingcountry = $_SESSION['checkoutInfo']['shippingcountry'];
				$myOrder->shippingtype = $isShipInshore ? Core_Orders::SHIPPING_INSHORE : Core_Orders::SHIPPING_OFFSHORE;
				$myOrder->shippingservice = $priceshipDetail;
				
				if($myOrder->addData())
				{
					//tracking order detail error book
					$detailError = array();
					
					//create order detail
					for($i = 0; $i < count($items); $i++)
					{
						//TODO: 
						$items[$i]->options = $items[$i]->options;
						$items[$i]->product = new Core_Product($items[$i]->id, true);

						//////
						//TO DO: check here
						$items[$i]->pricesell = $items[$i]->product->sellprice;
						$items[$i]->pricereal = $items[$i]->product->sellprice;
						$items[$i]->subtotal = $items[$i]->quantity * $items[$i]->pricereal;
						
						$myOrderDetail = new Core_OrdersDetail();
						$myOrderDetail->oid = $myOrder->id;
						$myOrderDetail->bid = $items[$i]->id;
						$myOrderDetail->name = $items[$i]->book->title;
						$myOrderDetail->pricesell = $items[$i]->pricesell;
						$myOrderDetail->pricefinal = $items[$i]->pricereal;
						$myOrderDetail->quantity = $items[$i]->quantity;
						if(!$myOrderDetail->addData())
						{
							$detailError[] = $myOrderDetail;
						}
					}
					
					//neu co loi trong qua trinh them order detail
					if(count($detailError) > 0)
					{
						$error[] = $this->registry->lang['controller']['errAddCreateDetail'];
						
						//xoa dơn hang
						$myOrder->delete();
						
						//xoa cac detail da them thanh cong truoc do
						Core_OrdersDetail::deleteFromOrder($myOrder->id);
					}
					else
					{
						//////////////////////////////////
						//Them order va order detail ok
						
						
						//register user
						if($this->registry->me->id == 0)
						{
							
							//kiem tra xem da co ai dang ky email nay chua
							$myUser = new Core_User();
							$myUser = Core_User::getByEmail($myOrder->contactemail);
							
							//check latelogin, co nghia la cung cap password va email o tren de login, ko thong qua form login
							if($myUser->id > 0 && $myUser->password == viephpHashing::hash($_SESSION['checkoutInfo']['password']) && $myUser->oauthPartner == 0)
							{
								//login success
							}
							else
							{
								$myUser->fullname = $myOrder->billingfullname;
								$myUser->phone = $myOrder->billingphone;
								$myUser->region = $myOrder->billingregion;
								$myUser->email = $myOrder->contactemail;
								$myUser->password = $_SESSION['checkoutInfo']['password'];
								$myUser->groupid = GROUPID_MEMBER;
								$myUser->setPrivacy(Core_User::PRIVACY_INTERNET);

								if($myUser->addData())
								{
									//////////////////////////////////////////////////////////////////////////////////////////////////
									//////////////////////////////////////////////////////////////////////////////////////////////////
									//send mail to user
									$taskUrl = $this->registry->conf['rooturl'] . 'task/registersendemail';
									Helper::backgroundHttpPost($taskUrl, 'uid=' . $myUser->id);
								}
							}
							
							if($myUser->id > 0)
							{
								//autologin
								$_SESSION['userLogin'] = $myUser->id;
								$this->registry->me = $myUser;
								$this->registry->smarty->assign(array(	'me' => $myUser));
								
								//update info
								$myOrder->billinguserid = $myOrder->shippinguserid = $myUser->id;
								$myOrder->updateData();
							}
							else
							{
								//Co van de khi tao user
							}
							
							
						}//end create new customer
						
						/////////////
						// Moi thu OK, tien hanh goi email de confirm don hang
						$taskUrl = $this->registry->conf['rooturl'] . 'task/neworder';
						
						//demo for administrator, dont send email
						Helper::backgroundHttpPost($taskUrl, 'oid=' . $myOrder->id);
						
						//enable step 5 (completed)
						$_SESSION['checkoutStep5Enable'] = 1;
						$_SESSION['checkoutThankyou'][] = $myOrder->id;	//trong truong hop chua phai la thanh vien thi dung array nay de tracking cac order vua tao
						
						//clear gio hang
						$this->registry->cart->emptyCart();
						$this->registry->cart->saveToSession();
						
						//redirect sang buoc cuoi cung
						header('location: ' . $this->registry->conf['rooturl'] . 'checkout/thankyou/' . $myOrder->id);
						exit();
					}
					
					
				}//end addData();
				
			}
		}
		
		
		$this->registry->smarty->assign(array(	'success' => $success,
												'error'	=> $error,
												'formData'	=> $formData,
												'bookforuser' => $bookforuser,
												'items' => $items,
												'myRegion' => $myRegion,
												'mySubregion' => $mySubregion,
												'pricetotal' => $pricetotal,
												'priceship' => $priceship,
												'priceshipDetail' => $priceshipDetail,
												'pricediscount' => $pricediscount,
												'pricediscountDetail' => $pricediscountDetail,
												'pricediscountxu' => $pricediscountxu,
												'pricefinal' => $pricefinal,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'review.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');   
		
	}
	
	/**
	 * Hoan tat don hang, hien thi loi cam on den khach hang
	 */
	function thankyouAction() 
	{
		$success = $error = $formData = array();
		
		$id = (int)$_GET['id'];
		$myOrder = new Core_Orders($id);
		
		//Check permission de truy cap duoc trang nay
		if($myOrder->id > 0 && (in_array($id, $_SESSION['checkoutThankyou']) || $myOrder->contactemail == $this->registry->me->email || $myOrder->billinguserid == $this->registry->me->id || $myOrder->shippinguserid == $this->registry->me->id ) )
		{
			
		}
		else
			$myOrder = new Core_Order();	//clear order
		
		
		
		$this->registry->smarty->assign(array(	'success' => $success,
												'error'	=> $error,
												'formData'	=> $formData,
												'myOrder' => $myOrder,
												
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'thankyou.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitleThankyou'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');   
		
	}
	
	###################################
	###################################
	###################################
	###################################
	
	protected function billingValidate($formData, &$error)
	{
		$pass = true;
		
		
		
		//check name valid
		if(strlen($formData['ffullname']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
			$pass = false;
		}
				
		//check email valid
		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailNotValid'];
			$pass = false;
		}
		
		
		//check phone valid
		if(strlen($formData['fphone']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errPhoneRequired'];
			$pass = false;
		}
		
		//check phone valid
		if(strlen($formData['faddress']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errAddressRequired'];
			$pass = false;
		}
		
		//check phone valid
		if($formData['fregion'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
			$pass = false;
		}
		
		
		//check phone valid
		if($formData['fsubregion'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errSubregionRequired'];
			$pass = false;
		}
		
		
		//check register new user
		if($this->registry->me->id == 0)
		{
			//check existed email
			$myUser = Core_User::getByEmail($formData['femail']);
			if($myUser->id > 0 && $myUser->oauthPartner == 0)
			{
				$error[] = $this->registry->lang['controller']['errEmailExisted'];
				$pass = false;
			}
			else
			{
				//check password
				//check password length
				if(strlen($formData['fpassword1']) < 6)
				{
					$error[] =  $this->registry->lang['controller']['errPasswordLength'];   
					$pass = false;
				}

				//check password matched
				if($formData['fpassword1'] != $formData['fpassword2'])
				{
					$error[] = $this->registry->lang['controller']['errPasswordMatch'];   
					$pass = false;
				}
			}
		}
		
		//Neu order gium nguoi khac
		if($formData['fbookforuserid'] > 0)
		{
			$myUser = new Core_User($formData['fbookforuserid']);

			if($myUser->id == 0)
			{
				$error[] = 'User ID #' . $formData['fbookforuserid'] . ' not found. Check again before booking for this user.';
				$pass = false;
			}
		}
			
		
				
		return $pass;
	}
	
	
	
	protected function paymentValidate($formData, &$error)
	{
		$pass = true;
		
				
		return $pass;
	}
	
	protected function reviewValidate($formData, &$error)
	{
		$pass = true;
		
				
		return $pass;
	}
	
	
	protected function checkCartEmpty()
	{
		if($this->registry->cart->itemCount() <= 0)
		{
			header('location: ' . $this->registry->conf['rooturl'] . 'cart?from=empty');
		}
	}
	
}

