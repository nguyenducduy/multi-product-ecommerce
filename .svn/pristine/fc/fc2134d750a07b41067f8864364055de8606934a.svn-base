<?php

class Controller_Site_Login extends Controller_Site_Base
{
    private $error;
    private $crm;

    /* mm1 */
    public function indexAction($forgot = 0)
    {
        if ($this->registry->me->id > 0) {
            $url = $this->registry['conf']['rooturl'];
            header("Location: $url");
            exit();
        }

        set_time_limit(0);
        $error       = $warning = $formData = array ();
        $redirectUrl = $this->registry->router->getArg('redirect'); //base64 encoded
        if (isset($_POST['action']) && $_POST['action'] == "sitelogin" || $_POST['action'] == "login") {


            $formData = array_merge($formData, $_POST);

            if ($this->loginValidate($_POST)) {

                $CrmAcc = Core_Customer::LoginReturnCustomerJson($formData['fuser'], $formData['fpassword']);

                $this->syncaccount($CrmAcc, $formData);
                if (isset($this->error['emptykey']) && $this->error['emptykey']) {
                    header('location: ' . $this->registry->conf['rooturl'] . 'account/detail?update=1');
                    exit();
                }
                if (empty($this->error)) {
                    //neu co chon chuc nang remember me
                    if (isset($_POST['frememberme'])) {
                        setcookie('myHashing', viephpHashing::cookiehashing($_SESSION['userLogin'], $_POST['fpassword']), time() + 24 * 3600 * 14, '/');
                    } else {
                        setcookie('myHashing', "", time() - 3600, '/');
                    }

                    ///////////////
                    setcookie('islogin', '1', time() + 24 * 3600 * 14, '/');


                    if ($redirectUrl == '') {
                        if (SUBDOMAIN == 'm') {
                            header('location: ' . $this->registry->conf['rooturl'] . 'account/info');
                            exit();
                        } else {
                            header('location: ' . $this->registry->conf['rooturl']);
                            exit();
                        }
                    } else {
                        $url = base64_decode($redirectUrl);
                        header('location: ' . $url);
                        exit();
                    }
                }
            } else {
                if ($this->error == '') {
                    $this->error[] = 'Thông tin đăng nhập không chính xác, vui lòng kiểm tra lại';
                }
            }
        }


        /** dang ki */
        //check err

        if (isset($_POST['action']) && $_POST['action'] == "siteregister") {
            $error = $this->checkempty($_POST);
            $arr   = array ();
            $arr   = $formData = array_merge($arr, $_POST);
            if (empty($error)) {


                $user           = new Core_User();
                $user->fullname = $arr['fname'];
                $user->phone    = $arr['fphone'];
                $user->email    = $arr['femail'];
                $user->password = $arr['fpassword'];
                $user->groupid  = GROUPID_MEMBER;
                $user->gender   = -1;
                $crm            = $this->addCrm($user);
                // insert crm thanh cong
                if ($crm > 4) {
                    $user->password = viephpHashing::hash($arr['fpassword']);
                    $uid            = $this->validateRegister($arr);

                    // ko ton tai trong mysql
                    if ($uid == '0') {
                        $uid = $user->addData();
                    } else {
                        //ton tai trong mysql
                        $myUser           = new Core_User($uid);
                        $myUser->phone    = $arr['fphone'];
                        $myUser->email    = $arr['femail'];
                        $myUser->newpass  = viephpHashing::hash($arr['fpassword']);
                        $arr['fullname']  = $arr['fname'];
                        $arr['groupid']   = GROUPID_MEMBER;
                        $myUser->password = viephpHashing::hash($arr['fpassword']);
                        $myUser->updateData($arr);

                    }
                    if (isset($arr['fsubcriber'])) {
                        $sub        = new Core_Subscriber();
                        $sub->uid   = $uid;
                        $sub->email = $arr['femail'];
                        $sub->phone = $arr['fphone'];
                        $sub->sms   = 1;
                        $sub->addData();
                    }

                    $CrmAcc = Core_Customer::LoginReturnCustomerJson($arr['fuser'], $arr['fpassword']);
                    $this->CreateSession($uid, $CrmAcc->CUSTOMERID);
                    $arr['ffullname'] = $arr['fname'];
                    $this->sendEmail($arr);
                    $url = $this->registry['conf']['rooturl'];
                    header("Location: $url");
                } else {
                    $error[] = $this->getError($crm);
                }

            }

        }
        $formData['forgot'] = $forgot;


        $this->registry->smarty->assign(array ( 'formData'    => $formData,
                                                'error'       => $this->error,
                                                'errorR'      => $error,
                                                'redirectUrl' => $redirectUrl ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
        $this->registry->smarty->assign(array ( 'contents'        => $contents,
                                                'pageTitle'       => $this->registry->lang['controller']['pageTitle'],
                                                'pageKeyword'     => $this->registry->lang['controller']['pageKeyword'],
                                                'pageDescription' => $this->registry->lang['controller']['pageDescription'], ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    // bat form quen mat khau
    public function  forgotAction()
    {
        $this->indexAction('1');
    }

    public function syncaccount($CrmAcc, $formData)
    {

        if (!empty($CrmAcc) && $CrmAcc->CUSTOMERID != '0' && $CrmAcc != '') {
            $flag  = false;
            $MyAcc = array ();
            /* kt mysql */
            if ($CrmAcc->MAINEMAIL != '') {
                $MyAcc = Core_User::getUsers(array ( 'femail' => $CrmAcc->MAINEMAIL ));
            } else {
                $this->error['emptykey'] = true;
            }


            if (empty($MyAcc) && $CrmAcc->MAINMOBILE != '' && $CrmAcc->MAINMOBILE != 0) {
                $MyAcc = Core_User::getUsers(array ( 'fphone' => $CrmAcc->MAINMOBILE ));
            }


            if (!empty($MyAcc)) {

                $MyUser  = new Core_User($MyAcc[0]->id);
                $newpass = viephpHashing::hash($formData['fpassword']);

                if ($newpass != $MyAcc[0]->password) {
                    $MyUser->newpass = $formData['fpassword'];
                    $flag            = true;
                }

                if ($CrmAcc->RANKID != '0') {
                    $MyUser->personalid = $CrmAcc->PERSONALID;
                }
                if ($MyUser->fullname != $CrmAcc->FULLNAME) {
                    $arr['fullname'] = $CrmAcc->FULLNAME;
                    $flag            = true;
                }
                if ($MyUser->phone != $CrmAcc->MAINMOBILE) {
                    $MyUser->phone = $CrmAcc->MAINMOBILE;
                    $flag          = true;
                }
                if ($MyUser->address != $CrmAcc->ADDRESS) {
                    $MyUser->address = $CrmAcc->ADDRESS == '-1'? '': $CrmAcc->ADDRESS;
                    $flag            = true;
                }
                if ($MyUser->city != $CrmAcc->CITYID) {
                    $MyUser->city = $CrmAcc->CITYID;
                    $flag         = true;
                }
                if ($MyUser->district != $CrmAcc->DISTRICTID) {
                    $MyUser->district = $CrmAcc->DISTRICTID;
                    $flag             = true;
                }
                if ($MyUser->gender != $CrmAcc->GENDER) {
                    $MyUser->gender = $CrmAcc->GENDER;
                    $flag           = true;
                }


                if ($flag) {
                    $MyUser->updateData($arr);
                }

                $this->CreateSession($MyAcc[0]->id, $CrmAcc->CUSTOMERID);
            } else {
                $CheckAcc = Core_Customer::DM_WEB_CUSTOMER_SEARCH($CrmAcc->CUSTOMERID);

                if ($CrmAcc->RANKID == '0') {
                    $CrmAcc->PERSONALID = '0';
                }


                $CrmAcc->PASSWORD   = $formData['fpassword'];
                $CrmAcc->CITYID     = $CheckAcc[0]->CITYID;
                $CrmAcc->DISTRICTID = $CheckAcc[0]->DISTRICTID;
                $CrmAcc->BIRTHDAY   = $CheckAcc[0]->BIRTHDAY;
                $CrmAcc->GENDER     = $CheckAcc[0]->GENDER;

                $arr[] = $CrmAcc;
                // kt thong tin tai khoan co ton tai chua , chua insert , co sai mat khau
                if ($this->checkExist($CrmAcc)) {
                    $this->parser($arr, 'mysql', 'insert');
                }
            }
        } else {

            $CheckAcc = Core_Customer::DM_WEB_CUSTOMER_SEARCH($formData['fuser']);

            if ($CheckAcc != '') {
                $this->error[] = 'Thông tin mật khẩu không đúng';
            } else {
                $this->error[] = 'Tài khoản không tồn tại';
            }
        }


    }

    private function checkExist($formData)
    {
        $pass = true;
        //check email
        if ($formData->MAINEMAIL == '' && $formData->MAINMOBILE == '') {
            $pass = false;
        } else {
            $user = array ();
            if ($formData->MAINEMAIL != '') {
                $user = Core_User::getUsers(array ( 'femail' => $formData->MAINEMAIL ));
            } else {
                $this->error['emptykey'] = true;
            }

            if (empty($user)) {
                $user = Core_User::getUsers(array ( 'fphone' => $formData->MAINMOBILE ));
            }

            if (!empty($user)) {
                $pass = false;
            } else {
                $this->error['emptykey'] = true;
            }
        }

        return $pass;
    }

    /* mm1 */
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

    /* mm1 */
    protected function loginValidate($formData)
    {
        $pass = true;
        if (in_array('', $formData)) {
            $this->error[] = $this->registry->lang['controller']['errEmptyInfo'];
            $pass          = false;

            return $pass;
        }

        return $pass;
    }

    private function parser($data, $to, $action)
    {

        switch ($to) {
            case 'mysql':

                $formData = array ();
                foreach ($data as $key => $value) {
                    if ($action == 'insert') {
                        $formData['femail']     = $value->MAINEMAIL;
                        $formData['fphone']     = $value->MAINMOBILE;
                        $formData['fgender']    = $value->GENDER;
                        $formData['ffullname']  = $value->FULLNAME;
                        $formData['fdistrict']  = $value->DISTRICTID;
                        $formData['fprovince']  = $value->CITYID;
                        $formData['faddress']   = $value->ADDRESS;
                        $formData['fbirthdate'] = $this->formatdatecrm($value->BIRTHDAY);
                        $formData['fpassword']  = $value->PASSWORD;
                        $formData['rankid']     = $value->RANKID;
                        $formData['personalid'] = $value->PERSONALID;

                        $id = $this->addMyData($formData);
                        $this->CreateSession($id, $value->CUSTOMERID);
                    }


                }
                break;
            case 'crm' :
                if ($data[0]->phone != '' && $data[0]->email != '') {

                    if ($action == 'insert') {

                        $this->addCrm($data[0]);

                        if ($this->crm > 1) {
                            $this->CreateSession($data[0]->id, $this->crm);
                        }
                        if ($this->crm > 4) {
                            $this->CreateSession($data[0]->id, $this->crm);
                        }
                    }


                }


                break;
        }
    }

    private function addMyData($formData)
    {
        $myUser             = new Core_User();
        $myUser->groupid    = GROUPID_MEMBER; //$formData['fgroupid']
        $myUser->email      = $formData['femail'];
        $myUser->phone      = $formData['fphone'];
        $myUser->gender     = $formData['fgender'];
        $myUser->parentid   = 0;
        $myUser->fullname   = $formData['ffullname'];
        $myUser->city       = $formData['fprovince'];
        $myUser->district   = $formData['fdistrict'];
        $myUser->address    = $formData['faddress'];
        $myUser->personalid = $formData['rankid'] == "0" && isset($formData['rankid'])? $formData['rankid']: $formData['personalid'];
        $myUser->birthday   = $formData['fbirthdate'];
        $myUser->password   = viephpHashing::hash($formData['fpassword']);

        $id = $myUser->addData();

        return $id;
    }

    private function addCrm($myUser)
    {
        $this->crm = 0;
        if ($myUser->personalid != '0') {
            $myUser->birthday   = $this->formattime_mdy($myUser->birthday);
            $myUser->customerid = '0';
            $this->crm          = Core_Customer::DIENMAY_WEB_CreateOrUpdateMembership($myUser);
        } else {
            $this->crm = Core_Customer::DM_CreateCustomer($myUser);
        }

        return $this->crm;
    }

    public function formattime($value = '')
    {
        $str = explode("-", $value);
        $rs  = $str[2] . "/" . $str[1] . "/" . $str[0];

        return $rs;

    }

    public function formattime_mdy($value = '')
    {

        $str = explode("-", $value);
        $rs  = $str[1] . "/" . $str[2] . "/" . $str[0];

        return $rs;

    }

    //"11/15/1989 12:00:00 AM"
    private function formatdatecrm($str)
    {

        $arr = explode(' ', $str);
        $str = explode("/", $arr[0]);
        $rs  = $str[2] . "-" . $str[0] . "-" . $str[1];

        return $rs;
    }

    /*=====================================REGISTER==================================================*/
    /** check exist register */
    private function validateRegister($formData)
    {
        $pass = 0;
        $user = Core_user::getUsers(array ( 'femail' => $formData['femail'] ));
        if (empty($user)) {
            $user = Core_user::getUsers(array ( 'fphone' => $formData['fphone'] ));
        }

        if (!empty($user)) {
            $pass = $user[0]->id;
        }

        return $pass;
    }

    /** get error return from crm */
    private function getError($error)
    {
        $pass = $this->registry->lang['controller']['errCrm[' . $error . ']'];

        return $pass;
    }

    /** check empty register */
    private function checkempty($arr)
    {
        $error = array ();

        if (!isset($arr['faccept'])) {
            $error[] = $this->registry->lang['controller']['erraccept'];
        }
        if (in_array('', $arr)) {
            $error[] = $this->registry->lang['controller']['errEmptyInfo'];
        }
        if (strlen($arr['fpassword']) < 6 && empty($error)) {
            $error[] = $this->registry->lang['controller']['errlenghpass'];
        }

        return $error;
    }

    public function loginandsendmessageAction()
    {

        if ($this->registry->me->id > 0) {
            $url = $this->registry['conf']['rooturl'];
            header("Location: $url");
            exit();
        }

        set_time_limit(0);
        $error       = $warning = $formData = array ();
        $redirectUrl = $this->registry->router->getArg('redirect'); //base64 encoded
        if (isset($_POST['action']) && $_POST['action'] == "sitelogin" || $_POST['action'] == "login") {


            $formData = array_merge($formData, $_POST);

            if ($this->loginValidate($_POST)) {

                $CrmAcc = Core_Customer::LoginReturnCustomerJson($formData['fuser'], $formData['fpassword']);

                $this->syncaccount($CrmAcc, $formData);
                if (isset($this->error['emptykey']) && $this->error['emptykey']) {
                    header('location: ' . $this->registry->conf['rooturl'] . 'account/detail?update=1');
                    exit();
                }
                if (empty($this->error)) {
                    //neu co chon chuc nang remember me
                    if (isset($_POST['frememberme'])) {
                        setcookie('myHashing', viephpHashing::cookiehashing($_SESSION['userLogin'], $_POST['fpassword']), time() + 24 * 3600 * 14, '/');
                    } else {
                        setcookie('myHashing', "", time() - 3600, '/');
                    }

                    ///////////////
                    setcookie('islogin', '1', time() + 24 * 3600 * 14, '/');


                    if ($redirectUrl == '') {
                        if (SUBDOMAIN == 'm') {
                            header('location: ' . $this->registry->conf['rooturl'] . 'account/info');
                            exit();
                        } else {
                            header('location: ' . $this->registry->conf['rooturl']);
                            exit();
                        }
                    } else {
                        $url = base64_decode($redirectUrl);
                        header('location: ' . $url);
                        exit();
                    }
                }
            } else {
                if ($this->error == '') {
                    $this->error[] = 'Thông tin đăng nhập không chính xác, vui lòng kiểm tra lại';
                }
            }
        }


        /** dang ki */
        //check err
        $error = $this->checkempty($_POST);
        if (isset($_POST['action']) && $_POST['action'] == "siteregister" && empty($error)) {
            $arr = array ();
            $arr = array_merge($arr, $_POST);

            $user           = new Core_User();
            $user->fullname = $arr['fname'];
            $user->phone    = $arr['fphone'];
            $user->email    = $arr['femail'];
            $user->password = $arr['fpassword'];
            $user->groupid  = GROUPID_MEMBER;
            $crm            = $this->addCrm($user);

            // insert crm thanh cong
            if ($crm > 4) {
                $user->password = viephpHashing::hash($arr['fpassword']);
                $uid            = $this->validateRegister($arr);

                // ko ton tai trong mysql
                if ($uid == '0') {
                    $user->addData();
                } else {
                    //ton tai trong mysql
                    $myUser           = new Core_User($uid);
                    $myUser->phone    = $arr['fphone'];
                    $myUser->email    = $arr['femail'];
                    $myUser->newpass  = viephpHashing::hash($arr['fpassword']);
                    $arr['fullname']  = $arr['fname'];
                    $arr['groupid']   = GROUPID_MEMBER;
                    $myUser->password = viephpHashing::hash($arr['fpassword']);
                    $myUser->updateData($arr);
                }
            } else {
                $error[] = $this->getError($crm);
            }

        } else {
            $error = array ();
        }
        $this->registry->smarty->assign(array ( 'formData'    => $formData,
                                                'errorL'      => $this->error,
                                                'errorR'      => $error,
                                                'redirectUrl' => $redirectUrl ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
        $this->registry->smarty->assign(array ( 'contents'        => $contents,
                                                'pageTitle'       => $this->registry->lang['controller']['pageTitle'],
                                                'pageKeyword'     => $this->registry->lang['controller']['pageKeyword'],
                                                'pageDescription' => $this->registry->lang['controller']['pageDescription'], ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function addandloginajaxAction()
    {

        $email       = (string)$_POST['femail'];
        $pass        = (string)$_POST['fpassword'];
        $content     = (string)$_POST['content'];
        $objectid    = (int)$_POST['id'];
        $parentid    = (int)$_POST['parent'];
        $returnvalue = array ();
        $passlogin   = true;
        /** check login*/
        if ($pass != "" && $email != "") {
            $formData['fpassword'] = $password;
            $formData['fuser']     = $email;
            $CrmAcc                = Core_Customer::LoginReturnCustomerJson($email, $pass);
            $this->syncaccount($CrmAcc, $formData);
            if (isset($this->error['emptykey']) && $this->error['emptykey']) {
                $returnvalue['comment'] = 'loginfail';
                $passlogin              = false;
            }
            if (empty($this->error)) {
                setcookie('islogin', '1', time() + 24 * 3600 * 14, '/');
                $email = $CrmAcc->MAINEMAIL;
                $phone = $CrmAcc->MAINMOBILE;
                $user  = Core_User::getUsers(array ( 'femail' => $email ), '', '');
                if (empty($user)) {
                    $user = Core_User::getUsers(array ( 'fphone' => $phone ), '', '');
                }
                if ($user[0]->id > 0) {
                    $uid  = $user[0]->id;
                    $name = $user[0]->fullname;
                }
                $returnvalue['comment'] = 'loginok';
            } else {
                $returnvalue['comment'] = 'loginfail';
                $passlogin              = false;
            }
        } else {
            if ($this->error == '') {
                $returnvalue['comment'] = 'emptyinfo';
                $passlogin              = false;
            }
        }
        if ($passlogin == true) {
            $pass = true;
            //kiem tra email , name , content,id
            if ($objectid == 0) {
                $returnvalue['comment'] = '5'; // khong co productid
                $pass                   = false;
            }
            if (strlen($content) == 0) {
                $returnvalue['comment'] = '4'; // khong co content
                $pass                   = false;
            }
            if ($pass == true) {
                //them mot review moi cho san pham
                $myProductReview = new Core_ProductReview();

                $myProduct                    = new Core_Product($objectid, true);
                $myProductReview->uid         = $uid;
                $myProductReview->objectid    = $objectid;
                $myProductReview->subobjectid = $myProduct->pcid;
                $myProductReview->fullname    = $name;
                $myProductReview->email       = $email;
                if ($checksubcom == 1) {
                    $myProductReview->isfeedback = Core_ProductReview::EMAILFEEDBACK;
                }
                $myProductReview->text      = Helper::plaintext($content);
                $myProductReview->ipaddress = Helper::getIpAddress(true);
                $myProductReview->status    = Core_ProductReview::STATUS_ENABLE;
                $myProductReview->parentid  = $parentid;


                if ($parentid > 0) {
                    $productreviewparent = new Core_ProductReview($parentid);
                    $productreviewparent->countreply++;
                    $productreviewparent->updateData();
                }

                if ($myProductReview->addData() > 0) {
                    $returnvalue['comment']  = '6'; //them review thanh cong
                    $returnvalue['username'] = $name;
                } else {
                    $returnvalue['comment'] = '7'; //them review khong thanh cong
                }
            }
        }
        echo json_encode($returnvalue);

    }

    public function ajaxcartloginAction()
    {
        $result   = array ( 'error' => -1, 'data' => '' );
        $formData = array ();
        // Login
        if ($_POST['action'] == "login" && isset($_POST['fuser']) && isset($_POST['fpassword'])) {

            $formData = array_merge($formData, $_POST);

            if ($this->loginValidate($_POST)) {

                $CrmAcc = Core_Customer::LoginReturnCustomerJson($formData['fuser'], $formData['fpassword']);
                $this->syncaccount($CrmAcc, $formData);
                if ($this->error == '') {
                    $result = array ( 'error' => 0, 'data' => 'Đăng nhập thành công' );
                } else {
                    $result = array ( 'error' => -2, 'data' => $this->error );
                }
            } else {
                if ($this->error == '') {
                    $result = array ( 'error' => -1, 'data' => 'Thông tin đăng nhập không chính xác, vui lòng kiểm tra lại' );
                }
            }
        }
        echo json_encode($result);
    }


    public function sendEmail($formData)
    {
        $this->registry->smarty->assign(array ( 'formData' => $formData ));
        $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'register/index.tpl');
        //$this->registry->smarty->assign(array('formData'=>$formData));
        //$this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
        $sender = new SendMail(
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
        } else {
            return false;
        }
    }


    public function popuploginAction()
    {
        $formData = $error = array ();
        $fpid     = (int)$_GET['productid'];
        $fbarcode = $_GET['barcode'];
        // Login
        if ($_POST['action'] == "login" && isset($_POST['fuser']) && isset($_POST['fpassword'])) {

            $formData = array_merge($formData, $_POST);

            if ($this->loginValidate($_POST)) {

                $CrmAcc = Core_Customer::LoginReturnCustomerJson($formData['fuser'], $formData['fpassword']);
                $this->syncaccount($CrmAcc, $formData);
                if ($this->error == '') {
                    echo '<script>parent.addproductbookmark();</script>';
                    exit();

                } else {
                    $error = $this->error;
                }
            } else {
                if ($this->error == '') {
                    $error = 'Thông tin đăng nhập không chính xác, vui lòng kiểm tra lại';
                } else {
                    $error = $this->error;
                }
            }
        }

        $this->registry->smarty->assign(array (
            'formData'     => $formData,
            'errorpopup'   => $error,
            'successpopup' => $success,
        ));
        $contentpopup = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'popuplogin.tpl');
        $this->registry->smarty->assign(array (
            'pageTitle' => 'Đăng nhập',
            'contents'  => $contentpopup,
        ));
        echo $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
    }

    public function ajaxcartregisterAction()
    {
        $result   = array ( 'error' => -1, 'data' => 'Có lỗi xảy ra, vui lòng thử lại' );
        $formData = array ();
        if (isset($_POST['action']) && $_POST['action'] == 'register') {

            $formData = array_merge($formData, $_POST);

            $user           = new Core_User();
            $user->fullname = $formData['ffullname'];
            $user->phone    = $formData['fphone'];
            $user->email    = $formData['femail'];
            $user->password = $formData['fpassword'];
            $user->groupid  = GROUPID_MEMBER;
            $user->gender   = -1;
            $crm            = $this->addCrm($user);
            // insert crm thanh cong
            if ($crm > 4) {
                $user->password = viephpHashing::hash($arr['fpassword']);
                $uid            = $this->validateRegister($formData);

                // ko ton tai trong mysql
                if ($uid == '0') {
                    $uid    = $user->addData();
                    $result = array ( 'error' => 0, 'data' => 'Xin chúc mừng, bạn đã là thành viên của dienmay.com' );
                } else {
                    //ton tai trong mysql
                    $myUser               = new Core_User($uid);
                    $myUser->phone        = $formData['fphone'];
                    $myUser->email        = $formData['femail'];
                    $myUser->newpass      = viephpHashing::hash($formData['fpassword']);
                    $formData['fullname'] = $formData['fname'];
                    $formData['groupid']  = GROUPID_MEMBER;
                    $myUser->password     = viephpHashing::hash($formData['fpassword']);
                    $myUser->updateData($formData);
                    $result = array ( 'error' => 0, 'data' => 'Bạn đã là thành viên của dienmay.com' );

                }
                $CrmAcc = Core_Customer::LoginReturnCustomerJson($arr['fuser'], $arr['fpassword']);
                $this->CreateSession($uid, $CrmAcc->CUSTOMERID);

            } else {
                $error  = $this->getError($crm);
                $result = array ( 'error' => $crm, 'data' => $error );
            }
            echo json_encode($result);
        }
    }

}
