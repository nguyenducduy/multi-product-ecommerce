<?php

Class Core_Saleorder extends Core_Object
{
    public $soap = '';

    public function __construct($id = 0, $loadFromCache = false)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $this->soap = new nusoap_client('http://crmservices.dienmay.com/oradb5/WebDienMayServices/WebDienMayService.asmx?wsdl', true);
        $err        = $this->soap->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            die();
        }
    }

    // co thi tra ve 1 mang dai ngoang , ko thi null
    public function getSaleorderDmAndTgddById($id)
    {
        $soap_client           = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['strUsername']    = 1;
        $arr['strPassword']    = 1;
        $arr['longCustomerID'] = $id;
        $rs                    = $soap_client->call('WebSite_GetSaleorderHistorybyCustomerID', $arr);
        if ($rs['WebSite_GetSaleorderHistorybyCustomerIDResult'] != null) {

            $rs = $rs['WebSite_GetSaleorderHistorybyCustomerIDResult']['diffgram']['NewDataSet']['Data'];

            if (empty($rs[0])) {
                $re[] = $rs;
            } else {
                $re = $rs;
            }

            return $re;
        } else {
            return '';
        }

    }


    // co : arr[0]->SALEORDERID ; ko có = empty *****loi tim id 1005680680 ko có
    public function getSaleorderByid($id)
    {
        $output                = array();
        $soap_client           = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?WSDL', true);
        $arr['longCustomerID'] = $id;
        $arr['strUsername']    = '-1';
        $arr['strPassword']    = '-1';
        $rs                    = $soap_client->call('WebSite_GetSaleorderHistorybyCustomerID', $arr);
        if (!empty($rs['WebSite_GetSaleorderHistorybyCustomerIDResult']['diffgram'])) {
            $output = $rs['WebSite_GetSaleorderHistorybyCustomerIDResult']['diffgram']['NewDataSet']['Data'];
        }


        return $output;

    }

    /*ko check customer search like*/
    public function GetSaleOrderDetailInfo($id, $saleid)
    {
        $soap_client        = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/WEBDIENMAYServices.asmx?WSDL', true);
        $arr['customerID']  = $id;
        $arr['saleOrderID'] = $saleid;
        $rs                 = $soap_client->call('Website_DIENMAY_GetSaleOrderDetailInfo', $arr);

        $rs = $rs['Website_DIENMAY_GetSaleOrderDetailInfoResult'];

        if ($rs != '[]') {
            $rs = json_decode($rs);
        } else {
            $rs = "";
        }

        return $rs;


    }

    /*ko check customer search like*/
    public function getSaleorderDetailByid($id, $saleid)
    {
        $soap_client        = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?WSDL', true);
        $arr['customerID']  = $id;
        $arr['saleOrderID'] = $saleid;
        $arr['strUsername'] = '-1';
        $arr['strPassword'] = '-1';
        $rs                 = $soap_client->call('Website_DIENMAY_GetSaleOrderDetail', $arr);

        $rs = $rs['Website_DIENMAY_GetSaleOrderDetailResult'];

        if ($rs != '[]') {
            $rs = json_decode($rs);
        } else {
            $rs = "";
        }

        return $rs;

    }


    public function getCityDic()
    {
        $soap_client = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl', true);
        $rs          = $soap_client->call('GetAllProvinceAndDictristOfCRM');
        $rs          = $rs['GetAllProvinceAndDictristOfCRMResult']['diffgram']['NewDataSet']['Data'];

        foreach ($rs as $key => $value) {
            $arrCity[$value['PROVINCEID']] = utf8_encode($value['PROVINCENAME']);
            $arrDis [$value['DISTRICTID']] = utf8_encode($value['DISTRICTNAME']);
        }
        $result[] = $arrDis;
        $result[] = $arrCity;

        return $result;
    }

    public function checkEmail($email)
    {
        $soap_client  = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl', true);
        $arr['email'] = $email;
        $rs           = $soap_client->call('GetCustomerByEmail', $arr);

        return $rs["GetCustomerByEmailResult"]['CUSTOMERID'] != "0"? false : true;
    }

    public function checkMobile($mobile)
    {
        $soap_client   = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl', true);
        $arr['mobile'] = $mobile;
        $rs            = $soap_client->call('GetCustomerByMobile', $arr);

        return $rs["GetCustomerByMobileResult"]['CUSTOMERID'] != "0"? false : true;
    }

    public function addSaleorder($arr)
    {
        //$soap_client = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl',true);

        //file_put_contents('uploads/errorServiceERRORtop.txt', print_r($soap_client->getError(), 1). ' - '. ' - '.print_r($arr, 1));
        //$rs = $soap_client->call('TGDD_WEB_CreateSaleOrderCustomer',$arr);
        try {
            $soap_client = new nusoap_client('http://dmservices.dienmay.com/oraweb/WebDienMayServices/WebDienMayService.asmx?wsdl', true); //URL test
            $rs          = $soap_client->call('DIENMAY_WEB_CreateProgramSaleOrderCustomer', $arr);
            //file_put_contents('uploads/errorServiceERROR.txt', print_r($soap_client->getError(), 1). ' - '.print_r($rs, 1). ' - '.print_r($arr, 1));
            if (isset($rs['DIENMAY_WEB_CreateProgramSaleOrderCustomerResult'])) {
                return $rs['DIENMAY_WEB_CreateProgramSaleOrderCustomerResult'];
            }
        } catch (Exception $e) {
            echo 'Loi order: ' . $e->getMessage();
        }

        return false;
    }

    public function updateCustomer($arr)
    {
        $soap_client = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl', true);
        $rs          = $soap_client->call('UpdateCustomer', $arr);

        return $rs;
    }

    public function addinstallmentCRM($arr)
    {
        try {
            $soap_client = new nusoap_client('http://dmservices.dienmay.com/oraweb/WebDienMayServices/WebDienMayService.asmx?wsdl', true); //URL test
            $rs          = $soap_client->call('DIENMAY_WEB_CreateSaleOrderRepayment', $arr);
            //file_put_contents('uploads/errorServiceInstallment.txt', print_r($soap_client->getError(), 1). ' - '.print_r($rs, 1). ' - '.print_r($arr, 1));
            if (isset($rs['DIENMAY_WEB_CreateSaleOrderRepaymentResult'])) {
                return $rs['DIENMAY_WEB_CreateSaleOrderRepaymentResult'];
            }
        } catch (Exception $e) {
            echo 'Loi tra truoc: ' . $e->getMessage();
        }

        return false;
    }


    /** lay chi tiet don hang theo ma khach hang [ket qua tra ve la tung sp trong don hang - input (rong - sai - ko ton tai) Return false else Return array ]*/
    public function Website_DIENMAY_GetSaleOrderList_ByCustomerid($idCustomer = '')
    {
        $rs = false;
        if ($idCustomer != '') {
            $arr['i_CUSTOMERID'] = $idCustomer;
            $rs                  = $this->soap->call('Website_DIENMAY_GetSaleOrderList_ByCustomerid', $arr);
            $rs                  = $rs['Website_DIENMAY_GetSaleOrderList_ByCustomeridResult']['diffgram'];

            if ($rs != '') {
                $rs = $rs['NewDataSet']['Data'];
            } else {
                $rs = false;
            }
        }

        return $rs;
    }

    /** lay don hang theo ma don hang [ket qua tra ve la gop tat ca sp trong don hang - input (rong - sai - ko ton tai) Return false else Return array ]*/
    public function Website_DIENMAY_GetSaleOrderList_ByCode($idSaleorder = '')
    {
        $rs = false;
        if ($idSaleorder != '') {
            $arr['strCode'] = $idSaleorder;
            $rs             = $this->soap->call('Website_DIENMAY_GetSaleOrderList_ByCode', $arr);
            $rs             = $rs['Website_DIENMAY_GetSaleOrderList_ByCodeResult']['diffgram'];

            if ($rs != '') {
                $rs = $rs['NewDataSet']['Data'];
            } else {
                $rs = false;
            }

        }

        return $rs;
    }
}



