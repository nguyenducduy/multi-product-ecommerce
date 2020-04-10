<?php
/**
 * Phien ban dang ky thanh vien co captcha trong form dang ky
 *
 */
Class Controller_Site_Register Extends Controller_Site_Base
{
	/* mm1 */
	public $error;
	public $vip = false;
	public $crm;
	public $updatevip = false;
	function indexAction()
	{
			
		set_time_limit(0);
		if($this->registry->me->id !='0')
		{
			header('location: ',$this->registry->conf['rooturl']);
		}
		global $setting;
		$formData['vip'] = '1';
		if(isset($_GET['vip']) &&$_GET['vip']=='1')
		$formData['vip'] = '0';

		$redirectUrl        = $this->registry->router->getArg('redirect'); //base64 encoded
		
		$region = $setting['region']; // Get region

		if (isset($_POST['action']) && $_POST['action'] == 'register') {
			unset($_POST['showpass']);
			unset($_POST['fpasswordshow']);
			$formData = array_merge($formData,$_POST);

			if ($this->registerValidate($formData)) {
				$this->addMyData($formData);
				$this->getError();
				if(empty($this->error) || $this->crm>4)
				{
					
					///////////////////////////////////////////////////////
					$_SESSION['registersuccess'] = Helper::getSecurityToken();
					$inforegister = array();
					$inforegister['fullname'] = $formData['ffullname'];
					$inforegister['email'] = $formData['femail'];
					$inforegister['address'] = $formData['faddress'];
					$inforegister['phone'] = $formData['fphone'];
					$inforegister['region'] = $region[$formData['fprovince']];
					$fdistrict = Core_Region::getRegions(array('fid'=>$formData['fdistrict']), '', '');
					$inforegister['district'] = $fdistrict[0]->name;
					$_SESSION['inforegister']= $inforegister;					
					/////////////////////////////////////////////////////////////
					// Add subscirber if user checkbox
					if ($formData['fregister']){
						$this->addsubscriber($formData['femail']);
					}
					if($this->vip)
					{
						//$success[]='Bạn đã đăng kí thành viên vip thành công';
						$this->sendEmail($formData);
					}
					else
					{ 
						//$success[]='Bạn đã đăng kí thành viên thành công';
						$this->sendEmail($formData);
					}
					//Register success login in dienmay.com
					$CrmAcc = Core_Customer::LoginReturnCustomerJson($formData['femail'],$formData['fpassword']);
					if(!empty($CrmAcc) && $CrmAcc->CUSTOMERID != '0' && $CrmAcc!='')
					{
						$MyAcc = Core_User::getUsers(array('femail'=>$CrmAcc->MAINEMAIL));
						if(!empty($MyAcc))
						{
							$this->CreateSession($MyAcc[0]->id,$CrmAcc->CUSTOMERID);
						}
					}
					$url = $this->registry->conf["rooturl"]."register/registersuccess";
					header("Location:".$url);
					
				}
			}
			$rdistrict = Core_Region::getRegions(array('fparentid'=>$formData['fprovince']), '', '');
			$district = '';
			if(!empty($rdistrict))
			{
				foreach ($rdistrict as $key=>$value) {
					$selected = $value->id == $formData['fdistrict']?"selected='selected'":"";
					$district .= '<option value="'.$value->id.'" '.$selected.'>'.$value->name.'</option>';
				}
			}

		}
		$this->registry->smarty->assign(array('formData' => $formData,
			                                      'region'   => $region,
			                                      'error'    => $this->error,
			                                      'district' =>$district,
		//'hideMenu' => 1,		
			                                      'success'  => $success));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'register.tpl');
		$this->registry->smarty->assign(array(	'contents' => $contents,
              									'pageTitle'=>'Đăng kí thành viên',
              									'pageDescription'=>'Đăng kí làm thành viên của ngay hôm nay để nhận hàng loạt ưu đãi từ dienmay.com'
              ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}
	public function indexajaxAction() {
		if(isset($_GET['city']) && $_GET['city']!='')
		{
			$region = Core_Region::getRegions(array('fparentid'=>$_GET['city']), '', '');
			$str = '';
			if(!empty($region))
			{
				foreach ($region as $key=>$value) {
					$select = '';
					if($_GET['district'] == $value->id)
						$select = 'selected="selected"';
					$str .= '<option ' . $select . ' value="'.$value->id.'">'.$value->name.'</option>';
				}
			}

			echo $str;
		}
	}
	protected function registerValidate($formData)
	{
		$pass = true;
		//danh sach cac truong dang ki vip co the co hoac khong
		$kiplist[] = 'fbirthday';
		$kiplist[] = 'fcmnd';

		// có truong rong
		if (in_array('',$formData)) {
			foreach ($formData as $key => $value) {
				//rong va khong trong danh sach vip
				if ($value == '' && !in_array($key,$kiplist)) {
					$this->error[] = $this->registry->lang['controller']['errEmptyInfo'];
					$pass          = false;
					return $pass;

				}

			}
		}
		else {
			$this->vip = true;
		}


		//check email valid
		if (!Helper::ValidatedEmail($formData['femail'])) {
			$this->error[] = $this->registry->lang['controller']['errEmailNotValid'];
			$pass          = false;
		}
		else {
			//check existed email
			$pass = $this->checkexist($formData['femail'],'email');
		}

		//check phone valid
		if (!$this->ValidMobile($formData['fphone'])) {
			$this->error[] = $this->registry->lang['controller']['errPhoneNotValid'];
			$pass          = false;
		}
		else {
			$pass = $this->checkexist($formData['fphone'],'phone');
		}
		//check password length
		if (strlen($formData['fpassword']) < 6) {
			$this->error[] = $this->registry->lang['controller']['errPasswordLength'];
			$pass          = false;
		}


		return $pass;
	}

	/* check ton tai trong mysql */

	private function checkexist($formData,$type,$alertAndCrmCheck = true)
	{
		$pass = true;
		if ($type == 'email') {
			$myUser = Core_User::getUsers(array('femail' => $formData));
			if (!empty($myUser)) {

				if ($alertAndCrmCheck) {
					$this->error[] = $this->registry->lang['controller']['errEmailExisted'];
				}
				$pass = false;
			}

		}

		if ($type == 'phone') {
			$myUser = Core_User::getUsers(array('fphone' => $formData));
			if (!empty($myUser)) {
				if ($alertAndCrmCheck) {
					$this->error[] = $this->registry->lang['controller']['errPhoneExisted'];
				}
				$pass = false;
			}
		}

		return $pass;
	}

	private function ValidMobile($data)
	{
		$pass = true;
		if (!ctype_digit($data) && (strlen($data) != 10 || strlen($data) != 11)) {
			$pass = false;
		}

		return $pass;
	}

	/* mm1 */

	private function  addMyData($formData)
	{
		$myUser           = new Core_User();
		$myUser->groupid  = 20; //$formData['fgroupid']
		$myUser->email    = $formData['femail'];
		$myUser->phone    = $formData['fphone'];
		$myUser->gender   = $formData['fgender'];
		$myUser->parentid = 0;
		$myUser->fullname = $formData['ffullname'];
		$myUser->city     = $formData['fprovince'];
		$myUser->district = $formData['fdistrict'];
		$myUser->address  = $formData['faddress'];
			
		// pass crm ko ma hoa ,  ngay crm y-m-d
		$myUser->birthday = $this->formattime_mdy($formData['fbirthday']);
		$myUser->password = $formData['fpassword'];

		if ($this->vip) {
			$myUser->personalid = $formData['fcmnd'];
		}



			
		// insert crm
		if ($this->vip) {
			$myUser->customerid = '0';
			$this->crm = Core_Customer::DIENMAY_WEB_CreateOrUpdateMembership($myUser);
		}
		else {
			$this->crm = Core_Customer::DM_CreateCustomer($myUser);
		}

			
		// > 0 là ca dk thuong va vip deu ko co loi
		if ($this->crm > 4) {
			// pass mysql thi co ma hoa
			$myUser->password = viephpHashing::hash($formData['fpassword']);
			$myUser->birthday = $formData['fbirthday'];
			$myUser->addData();
		}
	}

	public function formattime($value = '')
	{
		$str = explode("-",$value);
		$rs  = $str[2] . "/" . $str[1] . "/" . $str[0];

		return $rs;

	}

	public function formattime_mdy($value = '')
	{
			
		$str = explode("-",$value);
		$rs  = $str[1] . "/" . $str[2] . "/" . $str[0];
		return $rs;

	}
	private function getError()
	{
		$this->error = array();
		if (!$this->vip) {
			if ($this->crm == "-2") {
				$this->error[] = 'Điện thoại không đúng định dạng(-2)';
			}
			if ($this->crm == "-1") {
				$this->error[] = 'Email không đúng định dạng(-1)';
			}
			if ($this->crm == "-4") {
				$this->error[] = $this->registry->lang['controller']['errEmailExisted'].'(-4)';
			}
			if ($this->crm == "-3") {
				$this->error[] = $this->registry->lang['controller']['errPhoneExisted'].'(-3)';
			}
		}
		else {
			if ($this->crm == "-1") {
				$this->error[] = 'Mã công ty không chính xác';
			}
			if ($this->crm == "-2") {
				$this->error[] = 'Mobile không hợp lệ';
			}
			if ($this->crm == "-3") {
				$this->error[] = 'CMND không hợp lệ';
			}
			if ($this->crm == "-4") {
				$this->error[] = 'Email không hợp lệ';
			}
			if ($this->crm == "-5") {
				$this->error[] = 'Nâng hạng thất bại';
			}
			if ($this->crm == "-7") {

				$this->error[] = 'CMND đã đăng ký VIP';
			}
			if ($this->crm == "-8") {

				$this->error[] = 'Mobile đã đăng ký VIP';
			}
			if ($this->crm == "-9") {

				$this->error[] = 'Email đã đăng ký VIP';
			}
			if ($this->crm == "-10") {

				$this->error[] = 'Cập nhật thông tin VIP thất Bại';
			}
		}

	}

	private function ValidCmnd($data)
	{
		$pass = true;
		if (!ctype_digit($data) && (strlen($data) != 9)) {
			$pass = false;
		}

		return $pass;
	}

	//"11/15/1989 12:00:00 AM"

	private function formatdatecrm($str)
	{
		$arr = explode(' ',$str);
		$rs  = $this->formattime($arr[0]);

		return $rs;
	}
	private function addsubscriber($email){
		$success = false;
		$mySubscriber = new Core_Subscriber();
		$mysub        = $mySubscriber->getSubscribers(array('femail' => $email), '', '');
		if ($mysub[0]->id == 0) {
			if (Helper::ValidatedEmail($_POST['femail'])) {
				$myuser              = new Core_User();
				$user                = $myuser->getUsers(array('femail' => $email));
				$mySubscriber->uid   = $user[0]->id;
				$mySubscriber->email = $email;
				$mySubscriber->addData();
				$success = true;
			}
			else {
				$success = false;
			}
		}
		return $success;
	}
	public function sendEmail($formData)
    {
        $this->registry->smarty->assign(array('formData'=>$formData));
        $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'register/index.tpl');
        //$this->registry->smarty->assign(array('formData'=>$formData));
        //$this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
        $sender       = new SendMail(
        	$this->registry,
        	$formData['femail'],
        	'dienmay.com',
        	'XÁC NHẬN ĐĂNG KÝ THÀNH CÔNG TỪ DIENMAY.COM',
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
    public function registersuccessAction()
    {
    	if(empty($_SESSION['registersuccess']))
    		header("location:".$this->registry->conf["rooturl"]);

    	$fullname = $_SESSION['inforegister']['fullname'];
    	$email = $_SESSION['inforegister']['email'];
    	$phone = $_SESSION['inforegister']['phone'];
    	$address = $_SESSION['inforegister']['address'];
    	$region = $_SESSION['inforegister']['region'];
    	$district = $_SESSION['inforegister']['district'];
    	unset ($_SESSION['registersuccess']);
    	unset ($_SESSION['inforegister']);
    	$this->registry->smarty->assign(array(
    										'fullname'=>$fullname,
			    								'email'=>$email,
			    								'phone'=>$phone,
			    								'region'=>$region,
			    								'district'=>$district,
			    								'address'=>$address
    									));

    	$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'registersuccess.tpl');
		$this->registry->smarty->assign(array(	'contents' => $contents,
              									'pageTitle'=>'Đăng kí thành viên thành công',
              									'pageDescription'=>'Đăng kí thành viên thành công'
              ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }
	private function CreateSession($id, $CUSTOMERID)
	{

		$myUser = new Core_User($id);
		$myUser->updateLastLogin();
		$_SESSION['userLogin'] = $myUser->id;

		if ($CUSTOMERID != '') {
			$_SESSION['idCrmCustomer'] = $CUSTOMERID;
		}
		//tracking stat for login manual
		$myStat       = new Core_Backend_StatHook();
		$myStat->uid  = $myUser->id;
		$myStat->type = Core_Backend_StatHook::TYPE_LOGIN_MANUAL;
		$myStat->addData();
		session_regenerate_id(true);
	}
	
	
	


}

