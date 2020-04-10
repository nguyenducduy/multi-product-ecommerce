<?php

Class Controller_Task_OrderCrm Extends Controller_Task_Base
{

	public function indexAction()
	{
		//$_POST['oid'] = 33;$_POST['uid'] = 1;
        $orderid = (int)$_POST['oid'];
		//$userid = (int)$_POST['uid'];

		//check valid param
		if($orderid == 0)
			return 'noo1';

        /*if($userid == 0)
            return 'nou1';*/

		$myOrder = new Core_Orders($orderid);

		//check valid object
		if($myOrder->id == 0)
			return 'noo2';

        /*if($myOrder->uid != $userid)
            return 'nou2';

        $myUser = new Core_User($userid);

        if($myUser->id == 0)
            return 'nou2';*/

        $getOrderDetail = Core_OrdersDetail::getOrdersDetails(array('foid' => $orderid),'','');

        if(empty($getOrderDetail))
            return 'nood1';

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
                if($product->onsitestatus == Core_Product::OS_ERP_PREPAID)
                {
                    $crm_listpro[$ctnit]['PRICE'] = (double)$product->prepaidprice;
                }
                else
                {
                     $crm_listpro[$ctnit]['PRICE'] = (double)$od->pricesell;
                }
                $crm_listpro[$ctnit]['ADJUSTPRICE'] = (string)$od->pricefinal;

                $orderdatalist['orderdetail'][$ctnit] = $od;
                $orderdatalist['orderdetail'][$ctnit]->product = $product;

                $ctnit++;
            }
        }
        if(!empty($crm_listpro))
        {
            //send notification (tam thoi goi cho developer)
            /*$developers = Core_User::getUsers(array('fgroupidlist' => array(GROUPID_ADMIN, GROUPID_DEVELOPER)), '', '', '');
            $textNotification = $myOrder->billingfullname. '(SĐT: '.$myOrder->billingphone.') mua hàng với Invoice ID: '.$myOrder->invoiceid;
            $urlNOtification = $this->registry->conf['rooturl_crm'] .'orders/index/invoiceid/577308569';
            foreach($developers as $dev)
            {
                $myNotificationSystemNotify = new Core_Backend_Notification_SystemNotify();
                $myNotificationSystemNotify->uid = 1;
                $myNotificationSystemNotify->uidreceive = $dev->id;
                $myNotificationSystemNotify->objectid = $myUser->id;
                $myNotificationSystemNotify->text = $textNotification;
                $myNotificationSystemNotify->url = $urlNOtification;
                if($myNotificationSystemNotify->addData())
                {
                    //increase notification count for receiver
                    Core_User::notificationIncrease('notification', array($myNotificationSystemNotify->uidreceive));
                }
            }*/
            $district = new Core_Region($myOrder->billingdistrict);
            $arr = array();
            $arr['strFullname']               = (string)$myOrder->billingfullname;
            $arr['strAddress']                = (string)$myOrder->billingaddress;
            $arr['strBillAddress']            = (string)$myOrder->billingaddress;
            $arr['strShippAddress']           = (string)$myOrder->shippingaddress;
            $arr['strEmail']                  = strtolower($myOrder->contactemail);
            $arr['strPhone']                  = preg_replace('/[^0-9]/','', $myOrder->billingphone);
            $arr['strPersonalID']             = '';
            $arr['strNote']                   = $myOrder->note;
            $arr['intGender']                 = ($myOrder->gender == Core_Orders::GENDER_MALE ? 1: 0);
            $arr['dtBirthdate']               = '01-01-1970';
            $arr['strTaxNo']                  = '';
            $arr['intStoreID']                = 0;
            $arr['intCountryID']              = 3;
            $arr['intProvinceID']             = $myOrder->billingregionid;
            $arr['intDistrictID']             = ($district->id > 0 ? $district->districtcrm : $myOrder->billingdistrict);
            $arr['intPayment']                = $myOrder->paymentmethod;
            $arr['intDelivery']               = 0;
            $arr['dbShippingCost']            = (double)($myOrder->priceship > 0 ? $myOrder->priceship : 0.0);
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
            //file_put_contents('uploads/testfile.txt', print_r($arr,1));
            //echodebug($arr,true);
            $saleorders = new Core_Saleorder();
            $orderidcrm =  $saleorders->addSaleorder($arr);
            if(!empty($orderidcrm) && is_numeric($orderidcrm))
            {
                $getOrder = new Core_Orders($orderid);
                if(!empty($getOrder->id))
                {
                    $getOrder->orderidcrm = $orderidcrm;
                    $getOrder->ordercrmdate = time();
                    $getOrder->updateData();
                    echo 'ORDERCRMID: '.$orderidcrm;
                }
            }
            else echo 'ORDERCRMID: '.$orderidcrm;
            /*else{
                file_put_contents('uploads/testeordercrmerror.txt', print_r($orderidcrm, 1).' ORDERIDWEB: '.$orderid);
            }*/
            if(!empty($myOrder->contactemail))
            {
				//send mail to user
	            $orderdatalist['order'] = $myOrder;
	            $orderdatalist['order']->datecreated = date('d/m/Y H:i:s',$myOrder->datecreated);
	            if (!empty($myOrder->deliverymethod)) {
                    $orderdatalist['order']->deliverymethod = $myOrder->getOrderDeliveryMethod($myOrder->deliverymethod);
                }
	            if (!empty($myOrder->paymentmethod)) {
                    $orderdatalist['order']->paymentmethod = $myOrder->getOrderPaymentMethod($myOrder->paymentmethod);
                }
	            if (is_array($orderdatalist['order']->deliverymethod)) {
                    $orderdatalist['order']->deliverymethod = '';
                }
	            if (is_array($orderdatalist['order']->paymentmethod)) {
                    $orderdatalist['order']->paymentmethod = '';
                }
                foreach ($orderdatalist['orderdetail'] as $key => $orderdetail) {
                    $promotion = new Core_Promotion($orderdetail->options['promotionid']);
                    $orderdetail->options = $promotion;
                }
                $region = new Core_Region($orderdatalist['order']->billingregionid);
                $orderdatalist['order']->billingregionid = $region->name;
                $district = new Core_Region($orderdatalist['order']->billingdistrict);
                $orderdatalist['order']->billingdistrict = $district->name;
	            $this->registry->smarty->assign(array(
	                                                    'formData' => $orderdatalist
	                                                    ));
	            $mailcontent = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'orders/ordersuccessnew.tpl');
	            if(!empty($myOrder->contactemail)) $this->sendmail('Xác nhận đặt hàng',$mailcontent, $myOrder->contactemail, $myOrder->billingfullname);
            }
        }
	}

    public function installmentAction()
    {
       // $_POST['iid'] = 10;
        $idtragop = (int)$_POST['iid'];
        if($idtragop <=0) return 'noid';
        $myInstallment = new Core_Installment($idtragop);
        if($myInstallment->id > 0)
        {
            $myProduct = new Core_Product($myInstallment->pid);
            if($myProduct->id > 0)
            {
                //send notification (tam thoi goi cho developer)
                /*$developers = Core_User::getUsers(array('fgroupidlist' => array(GROUPID_ADMIN, GROUPID_DEVELOPER)), '', '', '');
                $textNotification = $myInstallment->fullname. '(SĐT: '.$myInstallment->phone.') mua trả góp với Invoice ID (mã đơn hàng): '.$myInstallment->invoiceid;
                $urlNOtification = $this->registry->conf['rooturl_cms'] .'installment/index/invoiceid/577308569';
                foreach($developers as $dev)
                {
                    $myNotificationSystemNotify = new Core_Backend_Notification_SystemNotify();
                    $myNotificationSystemNotify->uid = 1;
                    $myNotificationSystemNotify->uidreceive = $dev->id;
                    $myNotificationSystemNotify->objectid = $myUser->id;
                    $myNotificationSystemNotify->text = $textNotification;
                    $myNotificationSystemNotify->url = $urlNOtification;
                    if($myNotificationSystemNotify->addData())
                    {
                        //increase notification count for receiver
                        Core_User::notificationIncrease('notification', array($myNotificationSystemNotify->uidreceive));
                    }
                }*/


                $finalPrice = Core_RelRegionPricearea::getPriceByProductRegion(trim($myProduct->barcode), $myInstallment->region);
                if(!empty($finalPrice)) {
                    $myProduct->sellprice = $finalPrice;
                }
                $ctnit = 0;
                $crm_listpro = array();
                $crm_listpro[$ctnit]['PRODUCTID'] = (int)$myProduct->id;
                $crm_listpro[$ctnit]['QUANTITY'] = 1;
                $crm_listpro[$ctnit]['PRODUCTCODE'] = (string)trim($myProduct->barcode);
                $crm_listpro[$ctnit]['IMEI'] = '';
                $crm_listpro[$ctnit]['CATEGORYID'] = (int)$myProduct->pcid;
                $crm_listpro[$ctnit]['PRICE'] = (double)$myProduct->sellprice;
                $crm_listpro[$ctnit]['ADJUSTPRICE'] = (string)$myProduct->sellprice;

                $arr = array();
                $arr['strFullname']               = (string)$myInstallment->fullname;
                $arr['strAddress']                = (string)$myInstallment->address;
                $arr['strBillAddress']            = (string)$myInstallment->address;
                $arr['strShippAddress']           = (string)$myInstallment->address;
                $arr['strEmail']                  = strtolower($myInstallment->email);
                $arr['strPhone']                  = preg_replace('/[^0-9]/','', $myInstallment->phone);
                $arr['strPersonalID']             = $myInstallment->personalid;
                $arr['strNote']                   = 'Tỷ lệ trả trước '.$myInstallment->segmentpercent.'%';
                $arr['intGender']                 = ($myInstallment->gender == Core_Installment::GENDER_MALE ? 1: 0);
                $arr['dtBirthdate']               = '01-01-1970';
                $arr['strTaxNo']                  = '';
                $arr['intStoreID']                = '';
                $arr['intCountryID']              = 3;
                $arr['intProvinceID']             = $myInstallment->region;
                $arr['intDistrictID']             = 0;
                $arr['intPayment']                = 0;
                $arr['intDelivery']               = 0;
                $arr['dbShippingCost']            = 0.0;
                $arr['intCurrencyUnit']           = 0;
                $arr['dbCurrencyExchange']        = 0.0;
                $arr['lstProductList2']            = json_encode($crm_listpro);
                $arr['strAccountSecretInfo']      = '';
                $arr['strCouponCode']             = '';
                $arr['flCouponDiscount']          = 0.0;
                $arr['strOWNERBANKNAME']          = '';
                $arr['intTemporaryProvince'] = $myInstallment->region;
                $arr['longRepaymentMonths'] = $myInstallment->installmentmonth;
                //$arr['PrepaidAmount'] = $myInstallment->segmentpercent;//ty le tra truoc , khong truyen duoc so tien tra gop
                $arr['string strCareerStatusCode'] = ($myInstallment->personaltype==Core_Installment::TYPE_NGUOIDILAM?'CN':'SV');
                $arr['strInvoiceCode'] = $myInstallment->invoiceid;
                $arr['username'] = '';
                $arr['password'] = '';
                $arr['intProgramID'] = 35;
                $saleOrder = new Core_Saleorder();
                $installmentId = $saleOrder->addinstallmentCRM($arr);
                if(!empty($installmentId) && is_numeric($installmentId))
                {
                    $myInstallment->installmentcrm = $installmentId;
                    $myInstallment->installmentcrmdate = time();
                    $myInstallment->updateData();
                    echo 'INSTALLMENT ID: '.$installmentId;
                }
                //send mail to user
                $orderdatalist = array();
                $orderdatalist['installment'] = $myInstallment;
                $orderdatalist['product'] = $myProduct;
                $orderdatalist['installment']->datecreate = date('d/m/Y H:i:s',$myInstallment->datecreate);

                $getprepaid = Core_Installment::calcInstallment($myProduct->sellprice, ((int)$myInstallment->segmentpercent)/100, $myInstallment->installmentmonth, $myProduct->pcid);
                $orderdatalist['installmentacs'] = $getprepaid['ACS'];
                $orderdatalist['installmentppf'] = $getprepaid['PPF'];

                $this->registry->smarty->assign(array(
                                                        'formData' => $orderdatalist
                                                        ));
                $mailcontent = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'orders/installmentsuccess.tpl');
                if(!empty($myInstallment->email))$this->sendmail('Xác nhận đặt hàng',$mailcontent, $myInstallment->email, $myInstallment->fullname);
            }
        }
    }


    private function sendmail($subject,$mailcontent, $to, $toname = '')
    {
        $sender = new SendMail($this->registry,
                                    $to,
                                    $toname,
                                    $subject,
                                    $mailcontent,
                                    $this->registry->setting['mail']['fromEmail'],
                                    $this->registry->setting['mail']['fromName']
                                    );
        //echodebug($mailcontent);return true;
        if($sender->Send()) return true;
        return false;
    }

}

