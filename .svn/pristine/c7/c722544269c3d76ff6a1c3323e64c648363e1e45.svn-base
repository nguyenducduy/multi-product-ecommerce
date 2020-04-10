<?php
class Controller_Site_Subscriber Extends Controller_Site_Base
{
	public function indexAction(){

	}

	function processsubscriberAction(){
		if (!empty($_SERVER['HTTP_REFERER']))
		{
			if (isset($_POST['action']) && $_POST['action'] == 'processsubscriber' && isset($_POST['femail']) && isset($_POST['ffullname'])) {
				$mySubscriber = new Core_Subscriber();
				$mysub        = $mySubscriber->getSubscribers(array('femail' => $_POST['femail']), '', '');
				if ($mysub[0]->id == 0) {
					if (Helper::ValidatedEmail($_POST['femail'])) {
						$myuser              = new Core_User();
						$user                = $myuser->getUsers(array('femail' => $_POST['femail']));
						$mySubscriber->uid   = $user[0]->id;
						$mySubscriber->fullname = $_POST['ffullname'];
						$mySubscriber->gender = $_POST['gender'];
						$mySubscriber->email = $_POST['femail'];
						$last_id = $mySubscriber->addData();
						if($this->createlinkandsendmail($last_id)){
							echo 'ok';
						}else{
							echo 'erroremail';
						}
					}
					else {
						echo 'err';
					}
				}
				else {
					echo 'ext';
				}
			}
		}
	}

	private function createlinkandsendmail($id)
	{
		$subscriber = new Core_Subscriber($id);
		//xu ly de tai activatedcode
		$activatedCode = md5($subscriber->id . $subscriber->email . rand(1000, 9999) . time() . viephpHashing::$secretString);
		$subscriber->activatedcode   = $activatedCode;

		if ($subscriber->updateData()) {

			$_SESSION['subscriber'] = time();

			$link = $this->registry->conf['rooturl'] . 'site/subscriber/active/eid/' . base64_encode($subscriber->email) . '/token/' . $activatedCode;
			if ($this->sendEmail($link, $subscriber->email)) {
				return true;
			}
			else {
				return false;
			}
		}
	}

	function sendEmail($url, $mail)
	{
		$formData['link'] = $url;

		$this->registry->smarty->assign(array('formData'=>$formData));
		$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'subscriber/index.tpl');
		$this->registry->smarty->assign(array('formData'=>$formData));
		$this->registry->smarty->fetch($this->registry->smartyControllerContainerRoot.'index_popup.tpl');
		$sender       = new SendMail(
		$this->registry,
		$mail,
						'dienmay.com', 
						'Mời bạn kích hoạt tài khoản tại website dienmay.com', 
		$mailContents,
		$this->registry->setting['mail']['fromEmail'],
		$this->registry->setting['mail']['fromName']
		);
		if ($sender->Send()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function activeAction(){
		$error         = $warning = $formData = array();
		$email         = $this->registry->router->getArg('eid');
		$activatedCode = $this->registry->router->getArg('token');
		$arraysub = array('femail' => $email);
		$mysub = Core_Subscriber::getSubscribers($arraysub, '', '');
		if(!empty($mysub)){
			if ($mysub[0]->activatedcode != $activatedCode) {
				header('location: ' . $this->registry->conf['rooturl']);
				exit();
			}else {
				$mysub[0]->isactivate = 1;
				if($mysub[0]->updateData()){
					$success[] = 'Bạn đã xác nhận thành công';
				}
			}
		}else{
			header('location: ' . $this->registry->conf['rooturl']);
			exit();
		}

	}

	public function subscribecampaignAction()
	{
		$xmlprocess = '';
		if (!empty($_POST['emailsub']) && Helper::ValidatedEmail($_POST['emailsub']))
		{
			$checkSubscriber = Core_Subscriber::getSubscribers(array('femail' => $_POST['emailsub']), '', '', '', true);
			if ($checkSubscriber == 0)
			{
				$subscriber = new Core_Subscriber();
				$subscriber->email = $_POST['emailsub'];
				$subscriber->campaign = 20130902;
				$subscriber->addData();
				$xmlprocess .= '<output>1</output>';
				//Clear cache trang chu
			}
			else
			{
				$xmlprocess .= '<output>1</output>';
			}
		}
		else $xmlprocess .= '<output>2</output>';

		$xml = '<?xml version="1.0" encoding="utf-8"?><result>'.$xmlprocess;
		$xml .= '</result>';
		header ("content-type: text/xml");
		echo $xml;
	}

	public function subcampainautumnAction(){
		$formData = $error = array();
		$sub_id = 0;
		$lantern = $_GET['id'];
		
		if (isset($_POST['fullnamesub']) && isset($_POST['phonesub']) && !empty($_POST['emailsub']) && Helper::ValidatedEmail($_POST['emailsub']))
		{
			//$cachesub = new Cacher('site_campaign_trungthu_sub_' . $_POST['emailsub']);
			//$sub_id = base64_decode($cachesub->get());
			
				$checkSubscriber = Core_Subscriber::getSubscribers(array('femail' => $_POST['emailsub']), '', '');
				if (empty($checkSubscriber))
				{
					$subscriber = new Core_Subscriber();
					$subscriber->fullname = $_POST['fullnamesub'];
					$subscriber->email = $_POST['emailsub'];
					$subscriber->phone = $_POST['phonesub'];
					$subscriber->campaign = date("Ymd", time());
					$sub_id = $subscriber->addData();
					
						//$cachesub->set(base64_encode($sub_id)); 
				}
				else
				{
					$subscriber = new Core_Subscriber($checkSubscriber[0]->id);
					$subscriber->fullname = $_POST['fullnamesub'];
					$subscriber->phone = $_POST['phonesub'];
					$subscriber->campaign = date("Ymd", time());
					if($subscriber->updateData()){
						$sub_id = $subscriber->id;
						//$cachesub->set(base64_encode($sub_id));
					}
				}
			

			// save campaign user
			if($sub_id > 0){
				$postion = 0;
				
				$cachelantern = new Cacher('site_campaign_trungthu_win_' . $_POST['emailsub'] . '_' . $lantern);
				$cachelanternphone = new Cacher('site_campaign_trungthu_win_' . $_POST['phonesub'] . '_' . $lantern);
				
				$notify_lantern = json_decode($cachelantern->get(), true);
				if(empty($notify_lantern))
					$notify_lantern = json_decode($cachelanternphone->get(), true);
				
				if (empty($notify_lantern)){
					$notify_lantern = array('win'=> 0, 'position' => 0);
					$checkCampaignUser = Core_CampaignUser::getCampaignUserLucky($sub_id);
					if($checkCampaignUser->id > 0){
						$notify_lantern['win'] = 1; // user nay da trung thuong rui
						$notify_lantern['position'] = $postion;
						$cachelantern->set(json_encode($notify_lantern, true));
						$cachelanternphone->set(json_encode($notify_lantern, true));
					}else{
	
						$confiCampaign = array();
						$confiCampaign['ftype'] = $lantern;
	
						$campaignUser = Core_CampaignUser::getCampaignUsers($confiCampaign, 'id', 'ASC');
						if(empty($campaignUser)){
							$myCampainUser = new Core_CampaignUser();
							$myCampainUser->sid = $sub_id;
							$myCampainUser->position = Core_CampaignUser::USERLUCKY;
							$myCampainUser->type = $lantern;
							if($myCampainUser->addData()){
								$notify_lantern['win'] = 2; //Chuc mung nguoi dau tien
								$notify_lantern['position'] = $postion;
								$cachelantern->set(json_encode($notify_lantern, true));
								$cachelanternphone->set(json_encode($notify_lantern, true));
							}
								
						}else {
							
							$confiCampaign['fsid'] = $sub_id;
							$campaignUser = Core_CampaignUser::getCampaignUsers($confiCampaign, 'id', 'ASC');
							if(empty($campaignUser)){
								$maxposition  = Core_CampaignUser::getMaxPosition($lantern);
								$myCampainUser = new Core_CampaignUser();
								$myCampainUser->sid = $sub_id;
								$myCampainUser->position = $maxposition;
								$myCampainUser->type = $lantern;
								$myCampainUser->addData();
								$postion = $maxposition;
								$notify_lantern['win'] = 3; // Luu thanh cong nhung ko phai la ng dau tien
								$notify_lantern['position'] = $postion;
								$cachelantern->set(json_encode($notify_lantern, true));
								$cachelanternphone->set(json_encode($notify_lantern, true));
							}else {
								$postion = $campaignUser[0]->position;
								$notify_lantern['win'] = 3; //user da luu truoc do, thong bao cho ho biet ho o vi tri thu may
								$notify_lantern['position'] = $postion;
								$cachelantern->set(json_encode($notify_lantern, true));
								$cachelanternphone->set(json_encode($notify_lantern, true));
							}
						}
	
					}
				}
			}
		}
		$this->registry->smarty->assign(array(  'success' => $success,
                                                'error'    => $error,
                                                'formData'    => $formData,
												'lantern' => $lantern,
												'notify_lantern' => $notify_lantern,
												
		));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'formtrungthu.tpl');

		$this->registry->smarty->assign(array('contents' => $contents,
                                               'pageTitle' => 'Rước đèn cùng dienmay.com',
		));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
	}

	public function getUserLucky($lantern){

	}
	
	
	public function ajaxgetlanternAction(){
		// campaign trung thu
	        $today = time();
	        $starttime = strtotime('2013-09-18 08:00:00'); 
	        $endtime = strtotime('2013-09-19 23:59:00');
	        if($today >= $starttime && $today <= $endtime){
	        	//cache
	        	
	        	$cachelantern = new Cacher('site_campaign_trungthu_' . $_POST['pid']);
	        	
	       		if(isset($_GET['live'])) {
	       			$cachelantern = new Cacher('site_campaign_trungthu_' . $_GET['pid']);
	       			$cachelantern->clear();
				}
				
				$result = json_decode($cachelantern->get(), true);
			
				if (empty($result)){
	        		$result = array('error'=> -1, 'data'=> '');
	        		if($_POST['pid'] > 0 ){
			        	$confiAutumn = array();
			        	$confiAutumn['fpid'] = $_POST['pid'];
			        	$confiAutumn['fstatus'] = Core_CampaignAutumn::STATUS_ENABLE;
			        	$lantern = Core_CampaignAutumn::getCampaignAutumns($confiAutumn, '', '', 1);
			   			$lanterndate = strtotime(date('Y-m-d',$lantern[0]->starttime));
			   			if($lanterndate == strtotime(date('Y-m-d',$today))){
				        	if (!empty($lantern)){
				        		$result = array('error'=> 0, 'data'=> '<a href="javascript:void(0)" class="campaign_autumn" rel="' . $lantern[0]->id . '" title="Đăng ký nhận quà trung thu">Nhận quà trung thu</a>');
				        		$cachelantern->set(json_encode($result, true));
				        	}
			   			}
	        		}
				}
	        }
        
        echo json_encode($result);
	}
}