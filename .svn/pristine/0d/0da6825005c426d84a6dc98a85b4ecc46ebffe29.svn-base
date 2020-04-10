<?php

Class Core_Ticket extends Core_Object
{

	public function __construct($id = 0, $loadFromCache = false)
	{
		require_once(SITE_PATH.'libs/lib/nusoap.php');
	}

	public function getTicket($id)
	{

		$soap_client = new nusoap_client('http://crmservices.dienmay.com/crmticketservices/crmticketservices.asmx?wsdl',true);
		$soap_client->soap_defencoding='utf-8';
		$arr['longCustomerID'] = $id;
		$rs  =  $soap_client->call('GetTicketByCustomerID',$arr);
		$rs  =  $rs['GetTicketByCustomerIDResult'];
		if($rs!='')
			$rs = json_decode($rs);
		return $rs;
	}
	public function GetEmailByCustomerID($id)
	{
		$soap_client = new nusoap_client('http://crmservices.dienmay.com/crmticketservices/crmticketservices.asmx?wsdl',true);
		$arr['customerID'] = "1009990402";
		$rs  =  $soap_client->call('GetEmailByCustomerID',$arr);
		$rs  =  $rs['GetEmailByCustomerIDResult'];
		if($rs!='[]')
			$rs = json_decode($rs);
		else
			$rs = "";

		return $rs;
	}
	public function GetSmsByCustomerID($id)
	{
		$soap_client = new nusoap_client('http://crmservices.dienmay.com/crmticketservices/crmticketservices.asmx?wsdl',true);
		$arr['customerID'] = "1008803079";
		$rs  =  $soap_client->call('GetSMSByCustomerID',$arr);
		$rs  =  $rs['GetSMSByCustomerIDResult'];
		if($rs!='[]')
			$rs = json_decode($rs);
		else
			$rs = "";

		return $rs;
	}
	
	
}



