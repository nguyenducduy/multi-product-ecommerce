<?php

Class Controller_Crm_Orders Extends Controller_Crm_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		//kiem tra user co quyen vao xem trang nay hay khong ?
		$checker = false;
		//checker permission of user
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			//create suffix
            $suffix = 'oview_1';
            $checker = $this->checkAccessTicket($suffix);
		}
		else
		{
			$checker = true;
		}

		if(!$checker)
		{
			header('location: ' . $this->registry['conf']['rooturl_cms']);
			exit();
		}

		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$orderidcrmFilter = (int)($this->registry->router->getArg('orderidcrm'));
		$relatedorderidFilter = (int)($this->registry->router->getArg('relatedorderid'));
		$invoiceidFilter = (string)($this->registry->router->getArg('invoiceid'));
		$contactemailFilter = (string)($this->registry->router->getArg('contactemail'));
		$billingfullnameFilter = (string)($this->registry->router->getArg('billingfullname'));
		$billingphoneFilter = (string)($this->registry->router->getArg('billingphone'));
		$shippingfullnameFilter = (string)($this->registry->router->getArg('shippingfullname'));
		$shippingphoneFilter = (string)($this->registry->router->getArg('shippingphone'));
		$idFilter = (int)($this->registry->router->getArg('id'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		$startcreatedFilter = (string)(isset($_GET['fstartdate'])? urldecode($_GET['fstartdate']) :'');
		$endcreatedFilter = (string)(isset($_GET['fenddate'])? urldecode($_GET['fenddate']) :'');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['ordersBulkToken']==$_POST['ftoken'])
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
                            $myOrders = new Core_Orders($id);

                            if($myOrders->id > 0)
                            {
                                //tien hanh xoa
                                if($myOrders->delete())
                                {
                                    $deletedItems[] = $myOrders->id;
                                    $this->registry->me->writelog('orders_delete', $myOrders->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myOrders->id;
                            }
                            else
                                $cannotDeletedItems[] = $myOrders->id;
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

		$_SESSION['ordersBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}
		if($orderidcrmFilter > 0)
		{
			$paginateUrl .= 'orderidcrm/'.$orderidcrmFilter . '/';
			$formData['forderidcrm'] = $orderidcrmFilter;
			$formData['search'] = 'orderidcrm';
		}
		elseif($orderidcrmFilter == -1) {//!empty($_POST['fsubmitbulk'])
			$paginateUrl .= 'orderidcrm/-1/';
			$formData['fisorderidcrm'] = 1;
			$formData['search'] = 'orderidcrm';
		}

		if($relatedorderidFilter > 0)
		{
			$paginateUrl .= 'relatedorderid/'.$relatedorderidFilter . '/';
			$formData['frelatedorderid'] = $relatedorderidFilter;
			$formData['search'] = 'relatedorderid';
		}

		if($invoiceidFilter != "")
		{
			$paginateUrl .= 'invoiceid/'.$invoiceidFilter . '/';
			$formData['finvoiceid'] = $invoiceidFilter;
			$formData['search'] = 'invoiceid';
		}

		if($contactemailFilter != "")
		{
			$paginateUrl .= 'contactemail/'.$contactemailFilter . '/';
			$formData['fcontactemail'] = $contactemailFilter;
			$formData['search'] = 'contactemail';
		}

		if($billingfullnameFilter != "")
		{
			$paginateUrl .= 'billingfullname/'.$billingfullnameFilter . '/';
			$formData['fbillingfullname'] = $billingfullnameFilter;
			$formData['search'] = 'billingfullname';
		}

		if($billingphoneFilter != "")
		{
			$paginateUrl .= 'billingphone/'.$billingphoneFilter . '/';
			$formData['fbillingphone'] = $billingphoneFilter;
			$formData['search'] = 'billingphone';
		}

		if($shippingfullnameFilter != "")
		{
			$paginateUrl .= 'shippingfullname/'.$shippingfullnameFilter . '/';
			$formData['fshippingfullname'] = $shippingfullnameFilter;
			$formData['search'] = 'shippingfullname';
		}

		if($shippingphoneFilter != "")
		{
			$paginateUrl .= 'shippingphone/'.$shippingphoneFilter . '/';
			$formData['fshippingphone'] = $shippingphoneFilter;
			$formData['search'] = 'shippingphone';
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

			if($searchKeywordIn == 'invoiceid')
			{
				$paginateUrl .= 'searchin/invoiceid/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		if($startcreatedFilter != "")
		{
            //$paginateUrl .= '?fstartdate=' . urlencode($startcreatedFilter) . '&fenddate=' . urlencode( $endcreatedFilter);
            $formData['fstartdate'] = (int)Helper::strtotimedmy($startcreatedFilter, '00:00:00');
			$formData['fenddate'] = (int)Helper::strtotimedmy($endcreatedFilter, '23:59:59');
		}

		//tim tong so
		$total = Core_Orders::getOrderss($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$orderss = Core_Orders::getOrderss($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;

		$paginateUrl2 = '';
		if($startcreatedFilter != "")
        {
            $paginateUrl2 = '?fstartdate=' . urlencode($startcreatedFilter) . '&fenddate=' . urlencode( $endcreatedFilter);
            $redirectUrl .= '?fstartdate=' . urlencode($startcreatedFilter) . '&fenddate=' . urlencode( $endcreatedFilter);
        }
		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'orderss' 	=> $orderss,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'paginateurl2' 	=> $paginateUrl2,
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
            if($_SESSION['ordersAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myOrders = new Core_Orders();


					$myOrders->uid = $formData['fuid'];
					$myOrders->orderidcrm = $formData['forderidcrm'];
					$myOrders->relatedorderid = $formData['frelatedorderid'];
					$myOrders->invoiceid = $formData['finvoiceid'];
					$myOrders->pricesell = $formData['fpricesell'];
					$myOrders->priceship = $formData['fpriceship'];
					$myOrders->pricediscount = $formData['fpricediscount'];
					$myOrders->pricetax = $formData['fpricetax'];
					$myOrders->pricehandling = $formData['fpricehandling'];
					$myOrders->pricefinal = $formData['fpricefinal'];
					$myOrders->coupon = $formData['fcoupon'];
					$myOrders->couponvalue = $formData['fcouponvalue'];
					$myOrders->promotionid = $formData['fpromotionid'];
					$myOrders->promotionvalue = $formData['fpromotionvalue'];
					$myOrders->contactemail = $formData['fcontactemail'];
					$myOrders->billingfullname = $formData['fbillingfullname'];
					$myOrders->billingphone = $formData['fbillingphone'];
					$myOrders->billingaddress = $formData['fbillingaddress'];
					$myOrders->billingregionid = $formData['fbillingregionid'];
					$myOrders->billingcountry = $formData['fbillingcountry'];
					$myOrders->shippingfullname = $formData['fshippingfullname'];
					$myOrders->shippingphone = $formData['fshippingphone'];
					$myOrders->shippingaddress = $formData['fshippingaddress'];
					$myOrders->shippingcountry = $formData['fshippingcountry'];
					$myOrders->shippingregionid = $formData['fshippingregionid'];
					$myOrders->shippinglat = $formData['fshippinglat'];
					$myOrders->shippinglng = $formData['fshippinglng'];
					$myOrders->shippingservice = $formData['fshippingservice'];
					$myOrders->shippingtrackingcode = $formData['fshippingtrackingcode'];
					$myOrders->ipaddress = $formData['fipaddress'];
					$myOrders->paymentisdone = $formData['fpaymentisdone'];
					$myOrders->paymentmethod = $formData['fpaymentmethod'];
					$myOrders->deliverymethod = $formData['fdeliverymethod'];
					$myOrders->status = $formData['fstatus'];
					$myOrders->isgift = $formData['fisgift'];
					$myOrders->note = $formData['fnote'];
					$myOrders->datecompleted = $formData['fdatecompleted'];

                    if($myOrders->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('orders_add', $myOrders->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['ordersAddToken']=Helper::getSecurityToken();//Tao token moi

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
		$myOrders = new Core_Orders($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myOrders->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myOrders->uid;
			$formData['fid'] = $myOrders->id;
			$formData['forderidcrm'] = $myOrders->orderidcrm;
			$formData['frelatedorderid'] = $myOrders->relatedorderid;
			$formData['finvoiceid'] = $myOrders->invoiceid;
			$formData['fpricesell'] = $myOrders->pricesell;
			$formData['fpriceship'] = $myOrders->priceship;
			$formData['fpricediscount'] = $myOrders->pricediscount;
			$formData['fpricetax'] = $myOrders->pricetax;
			$formData['fpricehandling'] = $myOrders->pricehandling;
			$formData['fpricefinal'] = $myOrders->pricefinal;
			$formData['fcoupon'] = $myOrders->coupon;
			$formData['fcouponvalue'] = $myOrders->couponvalue;
			$formData['fpromotionid'] = $myOrders->promotionid;
			$formData['fpromotionvalue'] = $myOrders->promotionvalue;
			$formData['fcontactemail'] = $myOrders->contactemail;
			$formData['fbillingfullname'] = $myOrders->billingfullname;
			$formData['fbillingphone'] = $myOrders->billingphone;
			$formData['fbillingaddress'] = $myOrders->billingaddress;
			$formData['fbillingregionid'] = $myOrders->billingregionid;
			$formData['fbillingcountry'] = $myOrders->billingcountry;
			$formData['fshippingfullname'] = $myOrders->shippingfullname;
			$formData['fshippingphone'] = $myOrders->shippingphone;
			$formData['fshippingaddress'] = $myOrders->shippingaddress;
			$formData['fshippingcountry'] = $myOrders->shippingcountry;
			$formData['fshippingregionid'] = $myOrders->shippingregionid;
			$formData['fshippinglat'] = $myOrders->shippinglat;
			$formData['fshippinglng'] = $myOrders->shippinglng;
			$formData['fshippingservice'] = $myOrders->shippingservice;
			$formData['fshippingtrackingcode'] = $myOrders->shippingtrackingcode;
			$formData['fipaddress'] = $myOrders->ipaddress;
			$formData['fpaymentisdone'] = $myOrders->paymentisdone;
			$formData['fpaymentmethod'] = $myOrders->paymentmethod;
			$formData['fdeliverymethod'] = $myOrders->deliverymethod;
			$formData['fstatus'] = $myOrders->status;
			$formData['fisgift'] = $myOrders->isgift;
			$formData['fnote'] = $myOrders->note;
			$formData['fdatecreated'] = $myOrders->datecreated;
			$formData['fdatemodified'] = $myOrders->datemodified;
			$formData['fdatecompleted'] = $myOrders->datecompleted;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['ordersEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myOrders->uid = $formData['fuid'];
						$myOrders->orderidcrm = $formData['forderidcrm'];
						$myOrders->relatedorderid = $formData['frelatedorderid'];
						$myOrders->invoiceid = $formData['finvoiceid'];
						$myOrders->pricesell = $formData['fpricesell'];
						$myOrders->priceship = $formData['fpriceship'];
						$myOrders->pricediscount = $formData['fpricediscount'];
						$myOrders->pricetax = $formData['fpricetax'];
						$myOrders->pricehandling = $formData['fpricehandling'];
						$myOrders->pricefinal = $formData['fpricefinal'];
						$myOrders->coupon = $formData['fcoupon'];
						$myOrders->couponvalue = $formData['fcouponvalue'];
						$myOrders->promotionid = $formData['fpromotionid'];
						$myOrders->promotionvalue = $formData['fpromotionvalue'];
						$myOrders->contactemail = $formData['fcontactemail'];
						$myOrders->billingfullname = $formData['fbillingfullname'];
						$myOrders->billingphone = $formData['fbillingphone'];
						$myOrders->billingaddress = $formData['fbillingaddress'];
						$myOrders->billingregionid = $formData['fbillingregionid'];
						$myOrders->billingcountry = $formData['fbillingcountry'];
						$myOrders->shippingfullname = $formData['fshippingfullname'];
						$myOrders->shippingphone = $formData['fshippingphone'];
						$myOrders->shippingaddress = $formData['fshippingaddress'];
						$myOrders->shippingcountry = $formData['fshippingcountry'];
						$myOrders->shippingregionid = $formData['fshippingregionid'];
						$myOrders->shippinglat = $formData['fshippinglat'];
						$myOrders->shippinglng = $formData['fshippinglng'];
						$myOrders->shippingservice = $formData['fshippingservice'];
						$myOrders->shippingtrackingcode = $formData['fshippingtrackingcode'];
						$myOrders->ipaddress = $formData['fipaddress'];
						$myOrders->paymentisdone = $formData['fpaymentisdone'];
						$myOrders->paymentmethod = $formData['fpaymentmethod'];
						$myOrders->deliverymethod = $formData['fdeliverymethod'];
						$myOrders->status = $formData['fstatus'];
						$myOrders->isgift = $formData['fisgift'];
						$myOrders->note = $formData['fnote'];
						$myOrders->datecompleted = $formData['fdatecompleted'];

                        if($myOrders->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('orders_edit', $myOrders->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['ordersEditToken'] = Helper::getSecurityToken();//Tao token moi

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
		$myOrders = new Core_Orders($id);
		if($myOrders->id > 0)
		{
			//tien hanh xoa
			if($myOrders->delete())
			{
				$redirectMsg = str_replace('###id###', $myOrders->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('orders_delete', $myOrders->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myOrders->id, $this->registry->lang['controller']['errDelete']);
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

    public function historyAction()
    {
        $id = (int)($this->registry->router->getArg('id'));
        if(empty($id))
        {
            header('Location: '.$this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller);
        }
        $aOrder = new Core_Orders($id);
        if(empty($aOrder))
        {
            header('Location: '.$this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller);
        }
        $getRegion = new Core_Region($aOrder->billingregionid);
        $aOrder->regionname = $getRegion->name;
        $aOrder->ipaddress = long2ip($aOrder->ipaddress);
        $listorderDetail =  Core_OrdersDetail::getOrdersDetails(array('foid' => $id),'','');
        if(!empty($listorderDetail))
        {
            $ii = 0;
            foreach($listorderDetail as $od)
            {
                $product = new Core_Product($od->pid);
                $od->productname = $product->name;
                $promotion = new Core_Promotion($od->options['promotionid']);
                $od->promotionname = $promotion->name;
                $listorderDetail[$ii] = $od;
                $ii++;
            }
        }
        $this->registry->smarty->assign(array(
                                            'oneOrder' => $aOrder,
                                            'Orderdetail' => $listorderDetail,


                                        ));
        $this->registry->smarty->display($this->registry->smartyControllerContainer.'detail.tpl');
    }

    public function syncrmajaxAction()
    {
		//$userid = (int)(isset($_POST['uid'])?$_POST['uid']:0);
		$arrresult = array('success' => 2);
		$orderid = (int)(isset($_POST['orderidcrm'])?$_POST['orderidcrm']:0);
		if(!empty($orderid))
		{
			$myOrder = new Core_Orders($orderid);
			if($myOrder->id > 0)
			{
				$getOrderDetail = Core_OrdersDetail::getOrdersDetails(array('foid' => $orderid),'','');
				if(!empty($getOrderDetail))
				{
					$ctnit = 0;
				    $crm_listpro = array();
				    $orderdatalist = array();
				    foreach($getOrderDetail as $od)
				    {
				        $product = new Core_Product($od->pid);
				        if($product->id > 0)
				        {
				            $crm_listpro[$ctnit]['PRODUCTID'] = (int)$od->pid;
				            $crm_listpro[$ctnit]['QUANTITY'] = (int)($od->quantity);
				            $crm_listpro[$ctnit]['PRODUCTCODE'] = (string)trim($product->barcode);
				            $crm_listpro[$ctnit]['IMEI'] = '';
				            $crm_listpro[$ctnit]['CATEGORYID'] = (int)$product->pcid;
				            $crm_listpro[$ctnit]['PRICE'] = (double)$od->pricesell;
				            $crm_listpro[$ctnit]['ADJUSTPRICE'] = (string)$od->pricefinal;

				            $orderdatalist['orderdetail'][$ctnit] = $od;
				            $orderdatalist['orderdetail'][$ctnit]->product = $product;

				            $ctnit++;
				        }
				    }
				    if(!empty($crm_listpro))
				    {
				        $arr = array();
				        $arr['strFullname']               = (string)$myOrder->billingfullname;
				        $arr['strAddress']                = (string)$myOrder->billingaddress;
				        $arr['strBillAddress']            = (string)$myOrder->billingaddress;
				        $arr['strShippAddress']           = (string)$myOrder->shippingaddress;
				        $arr['strEmail']                  = $myOrder->contactemail;
				        $arr['strPhone']                  = preg_replace('/[^0-9]/','', $myOrder->billingphone);
				        $arr['strPersonalID']             = '';
				        $arr['strNote']                   = $myOrder->note;
				        $arr['intGender']                 = ($myOrder->gender == Core_Orders::GENDER_MALE ? 1: 0);
				        $arr['dtBirthdate']               = '01-01-1970';
				        $arr['strTaxNo']                  = '';
				        $arr['intStoreID']                = 0;
				        $arr['intCountryID']              = 3;
				        $arr['intProvinceID']             = $myOrder->billingregionid;
				        $arr['intDistrictID']             = 0;
				        $arr['intPayment']                = $myOrder->paymentmethod;
				        $arr['intDelivery']               = 0;
				        $arr['dbShippingCost']            = 0.0;
				        $arr['intCurrencyUnit']           = 0;
				        $arr['dbCurrencyExchange']        = 0.0;
				        $arr['lstProductList2']            = json_encode($crm_listpro);
				        $arr['strAccountSecretInfo']      = '';
				        $arr['strCouponCode']             = '';
				        $arr['flCouponDiscount']          = 0.0;
				        $arr['strOWNERBANKNAME']          = '';
				        $arr['intProgramID'] = (!empty($myOrder->promotionid)?$myOrder->promotionid:29);//programe id từ  CRM
				        $arr['strInvoiceCode'] = $myOrder->invoiceid;
				        $arr['username'] = '';
				        $arr['password'] = '';
				        $saleorders = new Core_Saleorder();
				        //echodebug($arr, true);
				        $orderidcrm =  $saleorders->addSaleorder($arr);
				        //$orderidcrm = 481771;
				        if(!empty($orderidcrm) && is_numeric($orderidcrm))
				        {
				            $getOrder = new Core_Orders($orderid);
				            if(!empty($getOrder->id))
				            {
				                $getOrder->orderidcrm = $orderidcrm;
				                $getOrder->ordercrmdate = time();
				                $getOrder->updateData();
				                $arrresult['success'] = 1;
				            }
				        }
				        else $arrresult['success'] = $orderidcrm;
				    }
				}
			}

		}
		echo json_encode($arrresult);
    }
}

