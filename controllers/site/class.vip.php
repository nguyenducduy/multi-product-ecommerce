<?php
Class Controller_Site_Vip extends Controller_Site_Base
{
	public function indexAction()
	{
		header('Location: ./');
		exit();
		$formData['fazid'] = 13; //VIP
        $formData['ftype'] = Core_Ads::TYPE_BANNER;
        $formData['fisactive'] = 1;
		$listAds = Core_Ads::getAdss($formData, '', 'DESC');
		$this->registry->smarty->assign(array('listbanner' => $listAds));
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'vip.tpl');
	}

	public function checkpointAction()
	{
		$fname = (string) (isset($_POST['fname'])?Helper::plaintext( $_POST['fname'] ):'');
		$fphone = (string) (isset($_POST['fphone'])?Helper::plaintext( $_POST['fphone'] ):'');
		if((empty($_SESSION['ses_runtimecheckpoint']) || $_SESSION['ses_runtimecheckpoint']<=time()) && Helper::checkPhoneAvalible($fphone))
		{
			$customer = Core_Customer:: DM_WEB_CUSTOMER_SEARCH($fphone);
			if(!empty($customer[0])){
				$_SESSION['ses_runtimecheckpoint'] = strtotime('+1 second');
				echo json_encode(array('fpoint' => $customer[0]->CURRENTPOINT, 'success' => 1));
			}
		}
		elseif(!empty($_SESSION['ses_runtimecheckpoint']) && $_SESSION['ses_runtimecheckpoint']>time()){
			echo json_encode(array('message' => 'Vui lòng chờ trong giây lát để kiểm tra tiếp', 'error' => 1));
		}
	}
}