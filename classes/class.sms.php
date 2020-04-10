<?php

	class sms
	{
		public  $soap_client;
		public function __construct()
		{
			require_once(SITE_PATH . 'libs/lib/nusoap.php');
			$this->soap_client = new nusoap_client('http://dmservices.dienmay.com/oraweb/ExternalServices/crmexternalservices.asmx?wsdl', true);
			$err         = $this->soap_client->getError();
			if ($err) {
				return false;
			}
			else {
				return true;
			}

		}

		function SendSms($phone, $content, $from, $note = '')
		{
			$arr['strPhone']             = $phone;
			$arr['strContent']           = $content;
			$arr['strFROM']              = $from;
			$arr['strSource']            = '';
			$arr['strNote']              = $note;
			$arr['intTemplateID']        = '0';
			$arr['intCommunicationType'] = '0';
			$arr['longCustomerID']       = '0';
			$arr['strCreatedUser']       = '';
			$arr['strRequestID']         = '0';
			$arr['longCampaignID']       = '0';
			$rs                          = $this->soap_client->call('CRMSendSMSFunction', $arr);
			$rs                          = $rs['CRMSendSMSFunctionResult'];
			return $rs;
		}
	}