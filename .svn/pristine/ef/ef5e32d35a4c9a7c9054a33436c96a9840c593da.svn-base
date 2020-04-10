<?php

Class Core_Customer extends Core_Object
{

    public function __construct($id = 0, $loadFromCache = false)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client = new nusoap_client('http://crmservices.dienmay.com/CRMERP/CRMERPServices.asmx?wsdl', true);
        $err         = $soap_client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            die();
        }
    }

    public static function customer_getDataFormCustomerID($id)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client           = new nusoap_client('http://crmservices.dienmay.com/oradb5/WebDienMayServices/WebDienMayService.asmx?wsdl', true);
        $arr['longCustomerid'] = $id;
        $rs                    = $soap_client->call('GetCustomerByID', $arr);
        $rs                    = $rs['GetCustomerByIDResult'];

        return $rs;
    }

    public static function customer_getDataFormEmail($mail)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client  = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['email'] = $mail;
        $rs           = $soap_client->call('GetCustomerByEmail', $arr);
        $rs           = $rs['GetCustomerByEmailResult'];

        return $rs;
    }

    public static function customer_getDataFormMobile($phone)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client   = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['mobile'] = $phone;
        $rs            = $soap_client->call('GetCustomerByMobile', $arr);
        $rs            = $rs['GetCustomerByMobileResult'];

        return $rs;
    }

    public static function DM_WEB_CUSTOMER_SEARCH($key)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client        = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['strUsername'] = '';
        $arr['strPassword'] = '';
        $arr['strKeyword']  = $key;
        $rs                 = $soap_client->call('DM_WEB_CUSTOMER_SEARCH', $arr);
        $rs                 = $rs['DM_WEB_CUSTOMER_SEARCHResult'];
        if ($rs != '[]') {
            $rs = json_decode($rs);
        } else {
            $rs = "";
        }

        return $rs;
    }

    public static function DM_CreateCustomer($formdata)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client        = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['username']    = '-1';
        $arr['password']    = '-1';
        $arr['fullName']    = $formdata->fullname;
        $arr['gender']      = $formdata->gender != '' || isset($formdata->gender)? $formdata->gender : '1';
        $arr['address']     = $formdata->address != ''? $formdata->address : '-1';
        $arr['coutryID']    = '-1';
        $arr['ISEMAIL']     = 'false';
        $arr['ISSMS']       = 'false';
        $arr['districtID']  = $formdata->district != ''? $formdata->district : '-1';
        $arr['birthDay']    = '';
        $arr['personalID']  = '-1';
        $arr['cityID']      = $formdata->city != ''? $formdata->city : '-1';
        $arr['subEmail']    = '-1';
        $arr['subMobile']   = '-1';
        $arr['mainMobile']  = $formdata->phone;
        $arr['mainEmail']   = $formdata->email;
        $arr['taxNo']       = '-1';
        $arr['strPassword'] = $formdata->password;

        $rs = $soap_client->call('DM_CreateCustomer', $arr);

        $rs = $rs['DM_CreateCustomerResult'];

        return $rs;
    }

    /*có arr['CUSTOMERID'] != 0 (1 mang) - ko co arr['CUSTOMERID'] == 0*/

    public static function DIENMAY_WEB_CreateOrUpdateMembership($formdata)
    {

        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client         = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['CUSTOMERID']   = $formdata->customerid;
        $arr['GENCOMPANYID'] = '2';
        $arr['FULLNAME']     = $formdata->fullname;
        $arr['FIRSTNAME']    = '-1';
        $arr['LASTNAME']     = '-1';
        $arr['PERSONALID']   = $formdata->personalid;
        $arr['MAINMOBILE']   = $formdata->phone;
        $arr['MAINEMAIL']    = $formdata->email;
        $arr['PASSWORD']     = $formdata->password;
        $arr['CITYID']       = $formdata->city;
        $arr['DISTRICTID']   = $formdata->district;
        $arr['ADDRESS']      = $formdata->address;
        $arr['BIRTHDAY']     = $formdata->birthday;

        $param['strCusObj'] = json_encode($arr);

        $param['username'] = '-1';
        $param['password'] = '-1';
        $rs                = $soap_client->call('DIENMAY_WEB_CreateMembership', $param);
        $rs                = $rs['DIENMAY_WEB_CreateMembershipResult'];

        return $rs;
    }

    /*co tra ve 1 mmang - ko co tra ve rong*/

    public static function UpdateDMCustomer($formdata, $customer)
    {

        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client         = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['username']     = '-1';
        $arr['password']     = '-1';
        $arr['customerID']   = $customer;
        $arr['fullName']     = $formdata->fullname;
        $arr['address']      = $formdata->address;
        $arr['countryID']    = '-1';
        $arr['cityID']       = $formdata->city;
        $arr['districtID']   = $formdata->district;
        $arr['SALUTATION']   = '-1';
        $arr['birthDate']    = substr($formdata->birthday, 0, 3) != '0000'? $formdata->birthday : '';
        $arr['mobile']       = $formdata->phone;
        $arr['phone']        = '-1';
        $arr['email']        = $formdata->email;
        $arr['otherEmail']   = '-1';
        $arr['otherAddress'] = '-1';
        $arr['PID']          = '-1';
        $arr['DONOTSMS']     = isset($formdata->subcribersms)? $formdata->subcribersms : 'true';
        $arr['DONOTEMAIL']   = isset($formdata->subcriberemail)? $formdata->subcriberemail : 'true';
        $arr['intGender']    = $formdata->gender;
        $rs                  = $soap_client->call('UpdateDMCustomer', $arr);
        $rs                  = $rs['UpdateDMCustomerResult'];

        return $rs;
    }


    public static function LoginReturnCustomerJson($user, $pass)
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $soap_client                = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['userName']            = '-1';
        $arr['passWord']            = '-1';
        $arr['strCustomerUserName'] = $user;
        $arr['strCustomerPassword'] = $pass;
        $arr['encryptedPass']       = false;
        $rs                         = $soap_client->call('LoginReturnCustomerJson', $arr);
        if ($rs != "") {
            return json_decode($rs['LoginReturnCustomerJsonResult']);
        } else {
            return '';
        }

    }

    public function resetPass($email, $code, $newpass)
    {
        $soap_client        = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['username']    = '-1';
        $arr['password']    = '-1';
        $arr['strUserName'] = $email;
        $arr['strCode']     = $code;
        $arr['strPassword'] = $newpass;
        $rs                 = $soap_client->call('ResetPassword', $arr);

        return $rs["ResetPasswordResult"] == $newpass? true : false;
    }

    public function insertCodeReset($email)
    {
        $soap_client        = new nusoap_client('http://dmservices.dienmay.com/oraweb/webdienmayservices/webdienmayservice.asmx?wsdl', true);
        $arr['username']    = '-1';
        $arr['password']    = '-1';
        $arr['strUserName'] = $email;
        $rs                 = $soap_client->call('InsertCodeResetPassword', $arr);

        return $rs['InsertCodeResetPasswordResult'];
    }

    ###########################################change link 15042013########################################
    //  ton tai tra ve array[0]=>object , ko la rong

    public function searchCustomer($key, $action)
    {

        $rs          = array();
        $soap_client = new nusoap_client('http://crmservices.dienmay.com/oradb5/WebDienMayServices/WebDienMayService.asmx?wsdl', true);
        if ($action != '' && $action == 0) {
            $crm_param['strKEYSEARCH'] = trim($key);
            $crm_param['password']     = '-1';
            $crm_param['username']     = '-1';
            $rs                        = $soap_client->call('ERP_SEARCHCUSTOMER', $crm_param);
            $customers[]               = $rs['ERP_SEARCHCUSTOMERResult'];
            if ($rs['ERP_SEARCHCUSTOMERResult']['CUSTOMERID'] != 0) {
                $customers['countCus'] = count($customers);
                $customers['countCom'] = 0;
            } else {
                $customers['countCus'] = 0;
                $customers['countCom'] = 0;
            }

        }
        if ($action != '' && $action == 1) {
            $crm_param['strKey'] = trim($key);
            $rs                  = $soap_client->call('CompanySearch_List', $crm_param);
            if ($rs['CompanySearch_ListResult'] != '') {
                $customers[] = $rs['CompanySearch_ListResult']['CRMCOMPANY'];
                if ($rs['CompanySearch_ListResult'] != '') {
                    $customers['countCom'] = count($customers);
                    $customers['countCus'] = 0;
                } else {
                    $customers['countCus'] = 0;
                    $customers['countCom'] = 0;
                }
            }


        }

        return $customers;

    }

    public static function getCityDic()
    {
        require_once(SITE_PATH . 'libs/lib/nusoap.php');
        $arr['username'] = '-1';
        $arr['password'] = '-1';
        $soap_client     = new nusoap_client('http://dmservices.dienmay.com/oraweb/WebDienMayServices/WebDienMayService.asmx?wsdl', true);

        $rs = $soap_client->call('GetAllProvinceAndDistrictOfCRM_JSON');
        $rs = $rs['GetAllProvinceAndDistrictOfCRM_JSONResult'];

        if ($rs != "") {
            return json_decode($rs);
        } else {
            return false;
        }
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
        if ($rs != "") {
            return $rs["GetCustomerByMobileResult"]['CUSTOMERID'] != "0"? false : true;
        } else {
            return true;
        }
    }
}



