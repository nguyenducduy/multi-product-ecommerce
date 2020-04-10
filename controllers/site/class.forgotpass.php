<?php

class Controller_Site_Forgotpass extends Controller_Site_Base
{
    public $error;
    public $success;


    public function indexAction()
    {
        if ($this->registry->me->id > 0) {
            $url = $this->registry['conf']['rooturl'];
            header("Location: $url");
            exit();
        }
        $sub = ($this->registry->router->getArg('sub'));
        if ($sub == 'reset') {
            $this->resetAction();

            return;
        }


        if (isset($_POST['fsubmit'])) {
            $error       = $warning = $formData = $success = array ();
            $redirectUrl = $_GET['redirect']; //base64 encoded
            $formData    = array_merge($formData, $_POST);


            if ($this->submitValidate($formData, $error)) {

                $UserCrm = Core_Customer::DM_WEB_CUSTOMER_SEARCH($formData['femail']);
                $myUser  = Core_User::getUsers(array ( 'femail' => $formData['femail'] ));

                if ($UserCrm != '') {
                    if (!empty($myUser)) {
                        $this->CreateLinkAndSendMail($myUser);
                    } else {
                        $this->parser($UserCrm, 'mysql', 'insert');
                        $myUser = Core_User::getUsers(array ( 'femail' => $formData['femail'] ));
                        $this->CreateLinkAndSendMail($myUser);
                    }
                } else {
                    if (!empty($myUser)) {
                        $this->parser($myUser, 'crm', 'insert');
                        $myUser = Core_User::getUsers(array ( 'femail' => $formData['femail'] ));
                        $this->CreateLinkAndSendMail($myUser);
                    } else {
                        $this->error[] = 'Email chưa được đăng kí';
                    }
                }


            }


        }
        if (isset($_POST['ajax'])) {

            if (empty($this->error)) {
                echo 'ok';
            } else {
                echo $this->error[0];
            }


        } else {
            $_SESSION['forgotpassToken'] = Helper::getSecurityToken();

            $this->registry->smarty->assign(array ( 'formData'    => $formData,
                                                    'error'       => $this->error,
                                                    'success'     => $this->success,
                                                    'warning'     => $warning,
                                                    'redirectUrl' => $redirectUrl ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
            $this->registry->smarty->assign(array ( 'contents'        => $contents,
                                                    'pageTitle'       => $this->registry->lang['controller']['pageTitle'],
                                                    'pageKeyword'     => $this->registry->lang['controller']['pageKeyword'],
                                                    'pageDescription' => $this->registry->lang['controller']['pageDescription'], ));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        }


    }

    private function CreateLinkAndSendMail($myUser)
    {

        $User = new Core_User($myUser[0]->id);
        //xu ly de tai activatedcode cho viec change password
        $activatedCode       = md5($myUser[0]->id . $myUser[0]->email . rand(1000, 9999) . time() . viephpHashing::$secretString);
        $User->activatedcode = $activatedCode;
        if ($User->updateData()) {

            $_SESSION['forgotpassSpam'] = time();

            $link = $this->registry->conf['rooturl'] . 'site/forgotpass/index/sub/reset/eid/' . base64_encode($myUser[0]->email) . '/token/' . $activatedCode;
            if ($this->sendEmail($link, $myUser[0]->email, $myUser[0]->fullname)) {
                $this->success[] = 'Vui lòng kiểm tra email để tiếp tục tìm lại mật khẩu';
            } else {
                $this->error[] = 'Gửi mail thất bại vui lòng thử lại ';
            }

        }

    }

    private function parser($data, $to, $action)
    {
        switch ($to) {
            case 'mysql':
                $formData = array ();
                foreach ($data as $key => $value) {
                    $formData['femail']     = $value->MAINEMAIL;
                    $formData['fphone']     = $value->MAINMOBILE;
                    $formData['fgender']    = $value->GENDER;
                    $formData['ffullname']  = $value->FULLNAME;
                    $formData['fprovince']  = $value->CITYID;
                    $formData['faddress']   = $value->ADDRESS;
                    $formData['fbirthdate'] = $this->formatdatecrm($value->BIRTHDAY);
                    $formData['fpassword']  = $value->PASSWORD;
                    $formData['rankid']     = $value->RANKID;
                    $formData['personalid'] = $value->PERSONALID;
                    if ($action == 'insert') {
                        $id = $this->addMyData($formData);
                    }

                }
                break;
            case 'crm':
                if ($action == 'insert') {
                    $this->addCrm($data[0]);
                }

                break;
        }
    }

    private function addMyData($formData)
    {
        $myUser           = new Core_User();
        $myUser->groupid  = 20; //$formData['fgroupid']
        $myUser->email    = $formData['femail'];
        $myUser->phone    = $formData['fphone'];
        $myUser->gender   = $formData['fgender'];
        $myUser->parentid = 0;
        $myUser->fullname = $formData['ffullname'];
        $myUser->city     = $formData['fprovince'];
        $myUser->address  = $formData['faddress'];
        if ($formData['rankid']) {
            $myUser->personalid = $formData['personalid'];
        }
        $myUser->birthday = Helper::strtotimedmy($formData['fbirthdate']);
        $myUser->password = viephpHashing::hash($formData['fpassword']);
        $id               = $myUser->addData();

        return $id;
    }

    private function addCrm($myUser)
    {

        if ($myUser->personalid != '0') {
            $myUser->birthday = date('Y/m/d', $myUser->birthday);
        }
        if ($myUser->personalid != '0') {
            $this->crm = Core_Customer::DIENMAY_WEB_CreateOrUpdateMembership($myUser);
        } else {
            $this->crm = Core_Customer::DM_CreateCustomer($myUser);
        }

    }

    public function resetAction()
    {
        $flag          = false;
        $error         = $warning = $formData = array ();
        $email         = $this->registry->router->getArg('eid');
        $activatedCode = $this->registry->router->getArg('token');
        $myUser        = Core_User::getUsers(array ( 'femail' => base64_decode($email) ), '', '', '');
        $id            = 0;
        if (!empty($myUser)) {

            foreach ($myUser as $key => $value) {
                if ($value->activatedcode == $activatedCode) {
                    $id   = $value->id;
                    $flag = true;
                }

            }

            if ($flag) {

                if (isset($_POST['fsubmit'])) {
                    if (!in_array("", $_POST)) {
                        if ($_POST['fpassword'] != $_POST['fpassword2']) {
                            $error[] = $this->registry->lang['controller']['errPassNotMatch'];
                        } else {
                            if (strlen($_POST['fpassword']) < 6) {
                                $error[] = 'Password tối thiểu phải có 6 kí tự';
                            } else {
                                $upUser = new Core_User($id);
                                $Crm    = new Core_Customer();
                                $change = $Crm->resetPass($upUser->email, '-1', $_POST['fpassword']);
                                if ($change) {
                                    $upUser->newpass       = $_POST['fpassword'];
                                    $upUser->activatedcode = '';
                                    if ($upUser->updateData()) {
                                        $success[] = 'Password được thay đổi thành công';
                                        header('location: ' . $this->registry->conf['rooturl']);
                                        exit();
                                    } else {
                                        $error = $this->registry->lang['controller']['errReset'];
                                    }
                                } else {
                                    $error = 'Có lỗi khi đổi password , Vui lòng thử lại sau';
                                }
                            }

                        }
                    } else {
                        $error[] = $this->registry->lang['controller']['emptyinfo'];

                    }
                }
                $this->registry->smarty->assign(array ( 'formData' => $formData,
                                                        'myUser'   => $upUser,
                                                        'error'    => $error,
                                                        'warning'  => $warning,
                ));
                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'reset.tpl');
                $this->registry->smarty->assign(array ( 'contents'        => $contents,
                                                        'pageTitle'       => $this->registry->lang['controller']['pageTitle'],
                                                        'pageKeyword'     => $this->registry->lang['controller']['pageKeyword'],
                                                        'pageDescription' => $this->registry->lang['controller']['pageDescription'], ));
                $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
            } else {
                header('location: ' . $this->registry->conf['rooturl']);
                exit();
            }
        } else {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
    }

    protected function submitValidate($formData, &$error)
    {
        $pass = true;
        //check form token
        if ($formData['ftoken'] != $_SESSION['forgotpassToken']) {
            $pass          = false;
            $this->error[] = $this->registry->lang['default']['securityTokenInvalid'];
        }

        //check spam
//			$forgotpassExpire = 30; //seconds
//			if (isset($_SESSION['forgotpassSpam']) && time() - $_SESSION['forgotpassSpam'] < $forgotpassExpire) {
//				$this->error[] = $this->registry->lang['controller']['errSpam'];
//				$pass          = false;
//			}

        //check email length
        if (!Helper::ValidatedEmail($formData['femail'])) {
            $this->error[] = $this->registry->lang['controller']['errInvalidEmail'];
            $pass          = false;
        }

        return $pass;
    }

    private function sendEmail($url, $mail, $name)
    {
        $formData['link']     = $url;
        $formData['fullname'] = $name;
        $this->registry->smarty->assign(array ( 'formData' => $formData ));
        $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'forgotpass/index.tpl');
        $this->registry->smarty->assign(array ( 'formData' => $formData ));
        $this->registry->smarty->fetch($this->registry->smartyControllerContainerRoot . 'index_popup.tpl');
        $sender = new SendMail($this->registry, $mail, 'dienmay.com', 'Lấy lại mật khẩu', $mailContents, $this->registry->setting['mail']['fromEmail'], $this->registry->setting['mail']['fromName']);
        if ($sender->Send()) {
            return true;
        } else {
            return false;
        }
    }

    public function formattime($value = '')
    {
        $str = explode("-", $value);
        $rs  = $str[2] . "/" . $str[1] . "/" . $str[0];

        return $rs;

    }

    //"11/15/1989 12:00:00 AM"
    private function formatdatecrm($str)
    {
        $arr = explode(' ', $str);
        $rs  = $this->formattime($arr[0]);

        return $rs;
    }
}
