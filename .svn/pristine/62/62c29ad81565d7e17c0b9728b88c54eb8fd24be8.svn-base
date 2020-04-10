<?php

	/**
	 * core/class.view.php
	 *
	 * File contains the class used for View Model
	 *
	 * @category Litpi
	 * @package Core
	 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
	 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
	 */

	/**
	 * Core_PhotoComment Class for photo feature
	 */
	Class Core_Register extends Core_Object
	{

		public function __construct()
		{
			require_once(SITE_PATH . 'libs/lib/nusoap.php');
			$soap_client = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl', true);
			$err         = $soap_client->getError();
			if ($err) {
				return false;
			}
			else {
				return true;
			}

		}

		/*khong co chuyen*/
		public static function getCityDic()
		{
			$soap_client = new nusoap_client('http://crmservices.dienmay.com/crmtgdd/CRMTGDDService.asmx?wsdl', true);
			$rs          = $soap_client->call('GetAllProvinceAndDictristOfCRM');
			$rs          = $rs['GetAllProvinceAndDictristOfCRMResult']['diffgram']['NewDataSet']['Data'];

			foreach ($rs as $key => $value) {
				$arrCity[$value['PROVINCEID']] = $value['PROVINCENAME'];
				$arrDis [$value['DISTRICTID']] = $value['DISTRICTNAME'];
			}
			$result[] = $arrDis;
			$result[] = $arrCity;
			return $result;
		}

		public static function register($arr)
		{
			require_once(SITE_PATH . 'libs/lib/nusoap.php');
			$soap_client       = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/WEBDIENMAYServices.asmx?wsdl', true);
			$arr['username']   = '-1';
			$arr['password']   = '-1';
			$arr['gender']     = '1';
			$arr['address']    = isset($arr['address']) ? $arr['address'] : '-1';
			$arr['coutryID']   = '-1';
			$arr['coutryID']   = '-1';
			$arr['ISEMAIL']    = 'true';
			$arr['districtID'] = '-1';
			$arr['birthDay']   = isset($arr['birthDay']) ? $arr['birthDay'] : '';
			$arr['subEmail']   = '-1';
			$arr['subMobile']  = '-1';
			$arr['personalID'] = isset($arr['personalID']) ? $arr['personalID'] : '-1';
			$arr['taxNo']      = '-1';
			$arr['ISSMS']      = "true";
			/*$arr['programID']   = '0' ;
			$arr['sourceID']    = '20';*/
			$rs = $soap_client->call('DM_CreateCustomer', $arr);
			$rs = $rs['DM_CreateCustomerResult'];
			return $rs;
		}



		public static function updateCustomer($arr)
		{
			unset($arr['personalID']);
			unset($arr['email']);
			unset($arr['SubmitBasic']);
			unset($arr['bio']);
			unset($arr['gender']);

			$soap_client         = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/WEBDIENMAYServices.asmx?wsdl', true);
			$arr['username']     = '-1';
			$arr['password']     = '-1';
			$arr['phone']        = '-1';
			$arr['PID']          = '-1';
			$arr['SALUTATION']   = '-1';
			$arr['DONOTSMS']     = "true";
			$arr['otherEmail']   = '-1';
			$arr['districtID']   = '-1';
			$arr['otherAddress'] = '-1';
			$rs                  = $soap_client->call('UpdateDMCustomer', $arr);
			return $rs;
		}

		function searchcustomer($key)
		{
			$soap_client               = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/CRMExternalServices.asmx?wsdl', true);
			$crm_param['strKEYSEARCH'] = trim($key);
			$crm_param['username']     = '-1';
			$crm_param['password']     = '-1';
			$rs                        = $soap_client->call('ERP_SEARCHCUSTOMER', $crm_param);
			if ($rs['ERP_SEARCHCUSTOMERResult']['CUSTOMERID'] != 0) {
				return $rs['ERP_SEARCHCUSTOMERResult'];
			}
			else {
				return false;
			}
		}

		function login($user, $pass)
		{
			$soap_client          = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/WEBDIENMAYServices.asmx?wsdl', true);
			$arr['userName']      = $user;
			$arr['passWord']      = $pass;
			$arr['encryptedPass'] = false;
			$rs                   = $soap_client->call('LoginReturnCustomer', $arr);
			if ($rs != "") {
				return $rs['LoginReturnCustomerResult'];
			}
			else {
				return false;
			}
		}

		/*pass md5 moi gui di*/

	}