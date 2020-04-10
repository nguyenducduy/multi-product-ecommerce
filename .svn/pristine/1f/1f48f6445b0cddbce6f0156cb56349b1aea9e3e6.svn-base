<?php

Class Core_Account extends Core_Object
{

	public function __construct($id = 0, $loadFromCache = false)
	{
		require_once(SITE_PATH . 'libs/lib/nusoap.php');
		$soap_client = new nusoap_client('http://crmservices.dienmay.com/CRMERP/CRMERPServices.asmx?wsdl', true);
		$err = $soap_client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			die();
		}
	}

	function searchCustomer($key, $action)
	{

		$rs =array();
		$soap_client = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/CRMExternalServices.asmx?wsdl', true);
		if ($action != '' && $action == 0) {
			$crm_param['strKEYSEARCH'] =  trim($key);
			$crm_param['password'] =  '-1';
			$crm_param['username'] =  '-1';
			$rs = $soap_client->call('ERP_SEARCHCUSTOMER', $crm_param);
			$customers[] = $rs['ERP_SEARCHCUSTOMERResult'];
			if ($rs['ERP_SEARCHCUSTOMERResult']['CUSTOMERID'] != 0) {
				$customers['countCus'] = count($customers);
				$customers['countCom'] = 0;
			}
			else
			{
				$customers['countCus'] = 0;
				$customers['countCom'] = 0;
			}

		}
		if ($action != '' && $action == 1) {
			$crm_param['strKey'] = trim($key);
			$rs = $soap_client->call('CompanySearch_List', $crm_param);
			if($rs['CompanySearch_ListResult']!='')
			{
				$customers[] = $rs['CompanySearch_ListResult']['CRMCOMPANY'];
				if ($rs['CompanySearch_ListResult'] != '') {
					$customers['countCom'] = count($customers);
					$customers['countCus'] = 0;
				}
				else
				{
					$customers['countCus'] = 0;
					$customers['countCom'] = 0;
				}
			}


		}
	
		return $customers;

	}





}



