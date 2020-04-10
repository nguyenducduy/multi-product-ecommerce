<?php
ini_set('memory_limit', '2048M');
class Controller_Site_Account extends Controller_Site_Base
{
    public $recordPerPage = 20;
    public $error;
    public $success;
    public $phone = 0;
    public $crm;
    private $errorinput = '';

    public function indexAction()
    {

        header("Location :" . $this->registry['conf']['rooturl'] . "account/detail");
        exit();

    }

    public function infoAction()
    {
        if ($this->registry->me->id <= 0) {
            header('location: ' . $this->registry->conf['rooturl'] . 'login');
            exit();
        }
        $this->registry->smarty->assign(array());
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'info.tpl');
        $this->registry->smarty->assign(array(
            'contents' => $contents ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function detailAction()
    {

        global $setting;
        if ($this->registry->me->id != 0) {
            $subdomain = '';
            if (SUBDOMAIN == 'm') {
                $subdomain = SUBDOMAIN;
            }
            if (!isset($_SESSION['idCrmCustomer'])) {
                $this->createdCustomerid();
            }

            set_time_limit(0);
            global $setting;
            $error                 = array();
            $success               = array();
            $formData              = array();
            $this->errorinput      = array();
            $formData['errfpass']  = 'in';
            $formData['errfpass1'] = 'in';
            $formData['errfpass2'] = 'in';
            $account               = new Core_Register();
            $formData['vip']       = 0;
            /*=================================================*/
            if (isset($_POST['fSubmitBasic'])) {
                $me                 = new Core_User($this->registry->me->id);
                $this->registry->me = $me;
                $formData           = array_merge($formData, $_POST);
                if ($this->updateValid($formData)) {

                    $myUser                    = new Core_User();
                    $myUser->email             = $_POST['femail'] != ""? $_POST['femail'] : $this->registry->me->email;
                    $myUser->fullname          = isset($_POST['ffullname']) && $_POST['ffullname'] != ''? $_POST['ffullname'] : $this->registry->me->fullname;
                    $myUser->parentid          = 0; //used for department
                    $myUser->birthday          = isset($_POST['fbirthday']) && $_POST['fbirthday'] != ''? $this->formattime($_POST['fbirthday'], 'crm') : $this->formattime($this->registry->me->birthday, 'crm2');
                    $myUser->phone             = isset($_POST['fphone']) && $_POST['fphone'] != ''? $_POST['fphone'] : $this->registry->me->phone;
                    $myUser->address           = isset($_POST['faddress']) && $_POST['faddress'] != ''? $_POST['faddress'] : $this->registry->me->address;
                    $myUser->personalid        = isset($_POST['fpersonalid']) && $_POST['fpersonalid'] != ''? $_POST['fpersonalid'] : $this->registry->me->personalid;
                    $myUser->city              = isset($_POST['fcity']) && $_POST['fcity'] != ''? $_POST['fcity'] : $this->registry->me->city;
                    $myUser->district          = isset($_POST['fdistrict']) && $_POST['fdistrict'] != ''? $_POST['fdistrict'] : $this->registry->me->district;
                    $myUser->gender            = isset($_POST['fgender']) && $_POST['fgender'] != ''? $_POST['fgender'] : $this->registry->me->gender;
                    $myUser->country           = 'VN';
                    $myUser->bio               = $this->registry->me->bio;
                    $myUser->id                = $this->registry->me->id;
                    $myUser->groupid           = $this->registry->me->groupid;
                    $myUser->website           = $this->registry->me->website;
                    $myUser->privacyBinary     = $this->registry->me->privacyBinary;
                    $myUser->favouriteCategory = $this->registry->me->favouriteCategory;
                    $myUser->activatedcode     = $this->registry->me->activatedcode;
                    // de update
                    $arr['fullname'] = $_POST['ffullname'] != ""? $_POST['ffullname'] : $this->registry->me->fullname;
                    if ($this->registry->me->email != '' && $this->registry->me->phone != '' && isset($_SESSION['idCrmCustomer'])) {

                        if ($this->registry->me->personalid != 0) {
                            $myUser->customerid = $_SESSION['idCrmCustomer'];
                            $this->crm          = Core_Customer::DIENMAY_WEB_CreateOrUpdateMembership($myUser);
                            $this->getError(true);
                        } else {

                            $this->crm = Core_Customer::UpdateDMCustomer($myUser, $_SESSION['idCrmCustomer']);
                            $this->getError(false);
                        }

                    } else {
                        $this->crm = '1';
                    }
                    if ($this->crm == '4' || $this->crm == '1') {

                        $myUser->birthday = isset($_POST['fbirthday']) && $_POST['fbirthday'] != ''? $this->formattime($_POST['fbirthday'], 'mysql') : $this->registry->me->birthday;

                        $this->updateMyData($myUser);
                    }
                }

            }
            // Đổi mật khẩu
            if (isset($_POST['changepass'])) {
                if ($this->vaildChangepass($_POST)) {
                    $formData = array_merge($formData, $_POST);
                    $userid   = $this->registry->me->id;
                    $myUser   = new Core_User($userid);

                    $CrmAcc = Core_Customer::LoginReturnCustomerJson($myUser->email, $formData['fpass']);

                    if (!empty($CrmAcc) && $CrmAcc->CUSTOMERID != '0' && $CrmAcc != '') {
                        if ($myUser->id != 0) {
                            $Crm = new Core_Customer();
                            if ($Crm->resetPass($myUser->email, '-1', $_POST['password1'])) {
                                $myUser->newpass = $_POST['password1'];
                                if ($myUser->updateData()) {
                                    $this->success[] = 'Mật khẩu được thay đổi thành công';

                                } else {
                                    $this->error[] = 'Có lỗi khi đổi mật khẩu';
                                }
                            } else {
                                $this->error[] = 'Có lỗi khi đổi mật khẩu , Vui lòng thử lại sau';
                            }
                        }
                    } else {
                        $this->error[]                = 'Sai mật khẩu hiện tại';
                        $pass                         = false;
                        $this->errorinput['errfpass'] = 'red';
                    }

                    //$myUser = Core_User::getUsers(array('fpass' => viephpHashing::hash($formData['fpass'])));

                }
                if ($subdomain != 'm') {
                    $errorpass = $this->error;
                    foreach ($this->errorinput as $k => $v) {
                        $formData[$k] = $v != ''? $v : $formData[$k];
                    }

                    $this->error   = array();
                    $successpass   = $this->success;
                    $this->success = array();
                }

            }

            $formData['codeuser'] = base64_encode('dienmay.com-' . $this->registry->me->id);
            $USER                 = new Core_User($this->registry->me->id);
            foreach ($USER as $key => $value) {
                $formData[$key] = $this->registry->lang['controller']['Empty'];
                if ($value != "" && $value != "-1") {
                    $formData[$key] = $value;
                }
                if ($key == 'birthday') {
                    $formData[$key] = $this->formattime($value, 'mysql') == '00-00-0000'? 'Chưa cập nhật' : $this->formattime($value, 'mysql');
                }
            }

            if ($this->registry->me->email == '') {
                $arrmsg[] = 'femail';
                if ($this->registry->me->phone == '') {
                    $arrmsg[] = 'fphone';
                }
            }
            $_SESSION['update'] = serialize($arrmsg);
            // thong bao chua dong bo crm
            if ($this->registry->me->phone != '') {
                $this->checkExistCrm($this->registry->me->phone, $this->registry->me->email);
            }

            $str = '';
            if ($formData['personalid'] != 0) {
                $formData['vip'] = 1;
            }
            if ($formData['district'] != "0" && $formData['district'] != $this->registry->lang['controller']['Empty']) {
                $region = Core_Region::getRegions(array( 'fid' => $formData['districtid'], 'fparentid' => $formData['city'] ), '', '');
                foreach ($region as $key => $value) {


                    if ($formData['district'] == $value->id) {
                        $city = new Core_Region($this->registry->me->city);
                        $str .= '<option selected value="' . $value->id . '">' . $value->name . '</option>';
                    } else {
                        $str .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                    }
                }

            }
            $warning = array();
            if ($this->registry->me->groupid != GROUPID_MEMBER) {
                $warning[] = 'Tài khoản của bạn không thành viên thuờng , vui lòng cập nhật tài khoản trong CMS';
            }
            if (isset($_GET['update']) && $_GET['update'] == 1) {
                $warning[] = 'Vui lòng cập nhật đầy đủ thông tin , để được phục vụ tốt nhất';
            }
            $formData['empty']          = 'Chưa cập nhật';
            $subcriber                  = Core_Subscriber::getSubscribers(array( 'fuid' => $this->registry->me->id ), '', '', '');
            $formData['subcriberMail']  = 0;
            $formData['subcriberPhone'] = 0;
            if (!empty($subcriber)) {
                $formData['subcriberMail'] = $subcriber[0]->email == ''? 0 : 1;

                $formData['subcriberPhone'] = ($subcriber[0]->phone == '' && $subcriber[0]->sms == 0)? 0 : 1;
            }
            /*$this->error[] = 'test';
           $warning = 'test';*/
            $this->registry->smarty->assign(array( 'formData'    => $formData,
                                                   'region'      => $setting['region'],
                                                   'redirectUrl' => $this->getRedirectUrl(),
                                                   'userGroups'  => Core_User::getGroupnameList(),
                                                   'error'       => $this->error,
                                                   'errorP'      => $errorpass,
                                                   'success'     => $this->success,
                                                   'successP'    => $successpass,
                                                   'warning'     => $warning,
                                                   'strdictrict' => $str,

            ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'chitiet.tpl');
            $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                   'pageTitle' => $this->registry->lang['controller']['pageTitle_detail'],
                                                   'contents'  => $contents ));

            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        } else {
            header('location: ' . $this->registry['conf']['rooturl'] . 'thanh-vien/dang-ky');
        }

    }

    private function createdCustomerid()
    {
        if ($this->registry->me->phone != '' && $this->registry->me->phone != 0) {
            $customer = Core_Customer::DM_WEB_CUSTOMER_SEARCH($this->registry->me->phone);

            if ($customer == '') {
                $customer = Core_Customer::DM_WEB_CUSTOMER_SEARCH($this->registry->me->mail);
            }

            if ($customer != '') {

                $_SESSION['idCrmCustomer'] = $customer[0]->CUSTOMERID;
            }
        }
    }

    public function accountsaleorderAction()
    {

        global $setting;
        $formData = array();
        if ($this->registry->me->id != 0 && isset($_SESSION['idCrmCustomer'])) {
            $saleorder    = new Core_Saleorder();
            $saleorderCrm = $saleorder->getSaleorderByid($_SESSION['idCrmCustomer']);

            $codeuser     = base64_encode('dienmay.com-' . $this->registry->me->id);
            if (!empty($saleorderCrm)) {

                foreach ($saleorderCrm as $key => $value) {
                    $detail = $saleorder->getSaleorderDetailByid($_SESSION['idCrmCustomer'], $value['SALEORDERID']);
                    foreach ($value as $k => $v) {
                        $formData['saleorder'][$key][$k] = $v;
                    }
                    foreach ($detail as $khoa => $giatri) {
                        $formData['saleorderdetail'][$key][$khoa] = $giatri;
                        $product                                  = new Core_Product();
                        if ($giatri->strImei != "") {
                            $sync = $product->getIdByBarcode($giatri->strImei);
                            if ($sync->barcode != null) {
                                if ($sync->image != null) {
                                    $formData['saleorderdetail'][$key][$khoa]->img = $product->getSmallImage();
                                } else {
                                    $formData['saleorderdetail'][$key][$khoa]->img = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                                }
                            } else {
                                $formData['saleorderdetail'][$key][$khoa]->img = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                            }
                        } else {
                            $formData['saleorderdetail'][$key][$khoa]->img = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                        }
                    }


                }
            }
            $this->registry->smarty->assign(array( 'formData'    => $formData,
                                                   'region'      => $setting['region'],
                                                   'redirectUrl' => $this->getRedirectUrl(),
                                                   'userGroups'  => Core_User::getGroupnameList(),
                                                   'codeuser'    => $codeuser
            ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'accountsaleorder.tpl');
            $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                   'pageTitle' => $this->registry->lang['controller']['pageTitle_detail'],
                                                   'contents'  => $contents ));

            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        } else {
            header('location: ' . $this->registry['conf']['rooturl'] . 'login');
        }

    }

    public function bookmarkAction()
    {
        $id   = (string)$this->registry->router->getArg('id');
        $user = $id != ''? base64_decode($id) : 0;
        $user = @(int)end(explode('-', $user));
        global $protocol;
        $subdomain = '';
        if (SUBDOMAIN == 'm') {
            $subdomain = SUBDOMAIN;
        }
        if ($user != 0) {
            $formData           = array();
            $product            = array();
            $formData['myuser'] = 0;
            if ($this->registry->me->id == $user) {
                $formData['myuser'] = 1;
            }
            $formData['codeuser'] = base64_encode('dienmay.com-' . $this->registry->me->id);
            $user                 = new Core_User($user);
            $formData['name']     = $user->fullname;
            $bookmark             = Core_RelProductbookmark::getRelProductbookmarks(array( 'fuid' => $user->id ), '', '', '');

            if (!empty($bookmark)) {
                foreach ($bookmark as $key => $value) {
                    $MyProduct            = new Core_Product($value->pid);
                    $MyProduct->img       = $MyProduct->getSmallImage();
                    $MyProduct->date      = $value->datecreated;
                    $MyProduct->link      = $MyProduct->getProductPath();
                    $MyProduct->crazydeal = $this->getCrazyforbookmark($MyProduct, $protocol, $subdomain);
                    $product[]            = $MyProduct;

                }

            }
            $this->registry->smarty->assign(array( 'formData'    => $formData,
                                                   'product'     => $product,
                                                   'redirectUrl' => $this->getRedirectUrl(),
                                                   'userGroups'  => Core_User::getGroupnameList(),

            ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'bookmark.tpl');
            $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                   'pageTitle' => $this->registry->lang['controller']['pageTitle_detail'],
                                                   'contents'  => $contents ));

            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        } else {
            header('location: ' . $this->registry['conf']['rooturl']);
        }
    }

    private function getCrazyforbookmark($MyProduct, $protocol, $subdomain)
    {


        /*=============================CRAZY==================================*/
        $crazydeal = array();
        if ($MyProduct->onsitestatus == Core_Product::OS_CRAZYSALE) {
            $crazydeal = Core_Crazydeal::getCrazydeals(array( 'fisactive' => 1, 'fstatus' => Core_Crazydeal::STATUS_ENABLE, 'fpid' => $MyProduct->id ), 'id', 'DESC');
        }

        if (empty($crazydeal)) {
            if ($MyProduct->onsitestatus == Core_Product::OS_CRAZYSALE) {
                $crazydealtmp = Core_Crazydeal::getCrazydeals(array( 'fpid' => $MyProduct->id ), 'id', 'DESC');
                if (!empty($crazydealtmp)) {
                    $productupdate = new Core_Product($MyProduct->id);
                    if ($productupdate->id > 0) {
                        $promotionliststr             = $productupdate->promotionlist;
                        $productupdate->onsitestatus  = $crazydealtmp[0]->oldonsitestatus;
                        $productupdate->promotionlist = '';
                        //$productupdate->applypromotionlist = '';
                        if ($productupdate->updateData()) {
                            $promotiontmp = explode(",", $promotionliststr);
                            $promotionid  = $promotiontmp[1];
                            $promotion    = new Core_Promotion($promotionid);
                            if ($promotion->id > 0) {
                                $promotion->status = Core_Promotion::STATUS_DISABLED;
                                $promotion->updateData();
                            }
                            $listregion = Core_Region::getRegions(array( 'fparentid' => 0 ), '', '');
                            if (!empty($listregion)) {
                                foreach ($listregion as $ritem) {
                                    $cachefile1   = $protocol . $subdomain . 'sitehtml_productdetail' . $MyProduct->id . '_' . $ritem->id;
                                    $removeCache1 = new Cacher($cachefile1);
                                    $removeCache1->clear();
                                }
                            }
                        }
                    }
                }
            }
        }

        /*===============================END=========================================================*/


        return $crazydeal;
    }

    public function ajaxupdateprofileAction()
    {
        $result = array( 'error' => -1, 'data' => '' );
        if ($this->registry->me->id != 0) {
            set_time_limit(0);
            global $setting;
            $error           = array();
            $success         = array();
            $formData        = array();
            $account         = new Core_Register();
            $formData['vip'] = 0;
            $formData        = array_merge($formData, $_POST);

            $myUser           = new Core_User();
            $myUser->email    = $this->registry->me->email;
            $myUser->fullname = isset($_POST['ffullname']) && $_POST['ffullname'] != ''? $_POST['ffullname'] : $this->registry->me->fullname;
            $myUser->parentid = 0; //used for department
            $myUser->birthday = isset($_POST['fbirthday']) && $_POST['fbirthday'] != ''? $this->formattime($_POST['fbirthday'], 'crm') : $this->formattime($this->registry->me->birthday, 'crm2');

            $myUser->address           = isset($_POST['faddress']) && $_POST['faddress'] != ''? $_POST['faddress'] : $this->registry->me->address;
            $myUser->personalid        = isset($_POST['fpersonalid']) && $_POST['fpersonalid'] != ''? $_POST['fpersonalid'] : $this->registry->me->personalid;
            $myUser->city              = isset($_POST['fcity']) && $_POST['fcity'] != ''? $_POST['fcity'] : $this->registry->me->city;
            $myUser->district          = isset($_POST['fdistrict']) && $_POST['fdistrict'] != ''? $_POST['fdistrict'] : $this->registry->me->district;
            $myUser->gender            = isset($_POST['fgender']) && $_POST['fgender'] != ''? $_POST['fgender'] : $this->registry->me->gender;
            $myUser->country           = 'VN';
            $myUser->bio               = $this->registry->me->bio;
            $myUser->id                = $this->registry->me->id;
            $myUser->groupid           = $this->registry->me->groupid;
            $myUser->website           = $this->registry->me->website;
            $myUser->privacyBinary     = $this->registry->me->privacyBinary;
            $myUser->favouriteCategory = $this->registry->me->favouriteCategory;
            $myUser->activatedcode     = $this->registry->me->activatedcode;
            $pass                      = true;
            if ($this->registry->me->phone != $_POST['fphone'] && $_POST['fphone'] != '' && isset($_POST['fphone'])) {
                $myUser->phone = $_POST['fphone'];
                if ($formData['fphone'] != '') {
                    $user = Core_User::getUsers(array( 'fphone' => $formData['fphone'] ));
                    if (!empty($user[0]->id)) {
                        if ($user[0]->id != $this->registry->me->id) {
                            $result = array( 'error' => -3, 'data' => 'Số điện thoại đã có người sử dụng' );
                            $pass   = false;
                        }
                    }
                }
            } else {
                $myUser->phone = $this->registry->me->phone;
            }
            if ($pass == true) {
                // de update
                $arr['fullname'] = $_POST['ffullname'] != ""? $_POST['ffullname'] : $this->registry->me->fullname;
                $arr['gender']   = $_POST['fgender'] != ""? $_POST['fgender'] : $this->registry->me->gender;
                if ($this->registry->me->oauthUid == '0' && $this->registry->me->email != '' && $this->registry->me->phone != '' && isset($_SESSION['idCrmCustomer'])) {

                    if ($this->registry->me->personalid != 0) {
                        $myUser->customerid = $_SESSION['idCrmCustomer'];
                        $this->crm          = Core_Customer::DIENMAY_WEB_CreateOrUpdateMembership($myUser);
                    } else {
                        $this->crm = Core_Customer::UpdateDMCustomer($myUser, $_SESSION['idCrmCustomer']);

                    }

                } else {
                    $this->crm = '1';
                }

                if ($this->crm == '4' || $this->crm == '1') {

                    $myUser->birthday = isset($_POST['fbirthday']) && $_POST['fbirthday'] != ''? $this->formattime($_POST['fbirthday'], 'mysql') : $this->registry->me->birthday;

                    $this->updateMyData($myUser);

                    $result = array( 'error' => 0, 'data' => 'Cập nhật thành công' );
                } else {
                    if ($this->crm == "-3") {
                        $result = array( 'error' => -3, 'data' => 'Số điện thoại đã có người sử dụng' );
                    } elseif ($this->crm == "-4") {
                        $result = array( 'error' => -4, 'data' => 'Email không hợp lệ' );
                    } elseif ($this->crm == "-1") {
                        $result = array( 'error' => -1, 'data' => 'Email không đúng định dạng' );
                    } else {
                        $result = array( 'error' => $this->crm, 'data' => 'Có lỗi xảy ra trong quá trình cập nhật! Vui lòng thử lại' );
                    }
                }
            }

        }
        echo json_encode($result);

    }

    private function formattime($str, $action)
    {

        if ($action == 'crm') {
            $arr = explode('-', $str);
            $rs  = $arr[1] . '/' . $arr[0] . '/' . $arr[2];
        }
        if ($action == 'crm2') {
            $arr = explode('-', $str);
            $rs  = $arr[1] . '/' . $arr[0] . '/' . $arr[2];
        }
        if ($action == 'mysql') {
            $arr = explode('-', $str);
            $rs  = $arr[2] . '-' . $arr[1] . '-' . $arr[0];

        }
        if ($action == 'mysql2') {
            $arr = explode('/', $str);
            $rs  = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

        }

        return $rs;
    }

    private function getError($vip)
    {
        $this->error = array();
        if (!$vip) {
            if ($this->crm == "-4") {
                $this->error [] = 'Email đã được đăng kí, vui lòng chọn email khác';
            }
            if ($this->crm == "-3") {
                $this->error [] = 'Số điện thoại đã được đăng kí, vui lòng chọn số điện thoại khác';
            }
        } else {
            if ($this->crm == "-1") {
                $this->error [] = 'Mã công ty không chính xác';
            }
            if ($this->crm == "-2") {
                $this->error [] = 'Mobile không hợp lệ';
            }
            if ($this->crm == "-3") {
                $this->error [] = 'CMND không hợp lệ';
            }
            if ($this->crm == "-4") {
                $this->error [] = 'Email không hợp lệ';
            }
            if ($this->crm == "-5") {
                $this->error [] = 'Nâng hạng thất bại';
            }
            if ($this->crm == "-7") {

                $this->error [] = 'CMND đã đăng ký VIP';
            }
            if ($this->crm == "-8") {

                $this->error [] = 'Mobile đã đăng ký VIP';
            }
            if ($this->crm == "-9") {

                $this->error [] = 'Email đã đăng ký VIP';
            }
            if ($this->crm == "-10") {

                $this->error [] = 'Cập nhật thông tin VIP thất Bại';
            }
        }

        return $this->error;
    }
    // phone , email
    private function checkExistCrm($value, $valuecmp, $check = false)
    {
        $pass     = true;
        $customer = Core_Customer::DM_WEB_CUSTOMER_SEARCH($value);
        if ($customer != '') {
            if ($customer[0]->MAINEMAIL != strtolower($valuecmp)) {
                $email = explode("@", $customer[0]->MAINEMAIL);
                if (empty($this->error)) {
                    $this->error[] = 'Do quá trình đồng bộ nên trước khi bạn đăng kí tài khoản này số điện thoại của bạn đã được đăng kí bởi email <b>' . $email[0] . '</b><br> Bạn vui lòng chọn số điện thoại khác để tránh việc xảy ra lỗi. Mong bạn thông cảm vì sự bất tiện này';
                }
                $pass = false;
            }

        }
        if ($check) {
            return $pass;
        }
    }

    private function validUpdate($formdata)
    {

        $pass = true;

        foreach ($formdata as $k => $v) {
            if ($v == '') {
                $name = substr($k, 1);
                if ($this->registry->me->$name == '') {
                    $this->error[] = 'Vui lòng điền đầy đủ thông tin ';

                    return false;
                }
            }


        }
        $arr = unserialize($_SESSION['update']);
        if ($arr != null && $pass) {
            foreach ($arr as $key => $value) {
                if ($formdata[$value] == '') {
                    $pass = false;
                    if ($value == 'fphone') {
                        $this->error[] = 'Vui nhập số điện thoại';
                    } else {
                        $this->error[] = 'Vui nhập Email';
                    }
                } else {
                    if ($value == 'fphone') {
                        if (!$this->ValidMobile($formdata[$value])) {
                            $pass          = false;
                            $this->error[] = 'Số điện thoại không hợp lệ';
                        } else {
                            if (Core_User::getUsers(array( 'fphone' => $formdata[$formdata] ), '', '', '', true) > 0) {
                                $pass          = false;
                                $this->error[] = 'Số điện thoại đã được đăng kí, vui lòng chọn số điện thoại khác';
                            }
                        }

                    } else {
                        if (!Helper::ValidatedEmail($formdata[$formdata])) {
                            $pass          = false;
                            $this->error[] = 'Email không hợp lệ';
                        } else {
                            if (Core_User::getUsers(array( 'femail' => $formdata[$formdata] ), '', '', '', true) > 0) {
                                $pass          = false;
                                $this->error[] = 'Email đã được đăng kí, vui lòng chọn email khác';
                            }
                        }

                    }

                }
            }
        }

        return $pass;

    }

    private function updateMyData($myUser)
    {
        $updateUser           = new Core_User($myUser->id);
        $updateUser->email    = $myUser->email != ''? $myUser->email : $this->registry->me->email;
        $updateUser->birthday = $myUser->birthday != ''? $myUser->birthday : $this->registry->me->birthday;
        $updateUser->phone    = $myUser->phone != ''? $myUser->phone : $this->registry->me->phone;
        $updateUser->city     = $myUser->city != ''? $myUser->city : $this->registry->me->city;
        $updateUser->district = $myUser->district != ''? $myUser->district : $this->registry->me->district;
        //$updateUser->gender   = $myUser->gender !='' ? $myUser->gender : $this->registry->me->gender;
        $updateUser->address = $myUser->address != ''? $myUser->address : $this->registry->me->address;
        $arr['fullname']     = $myUser->fullname != ''? $myUser->fullname : $this->registry->me->fullname;
        $arr['gender']       = $myUser->gender != ''? $myUser->gender : $this->registry->me->gender;

        $rs = $updateUser->updateData($arr);

        if ($rs) {
            $myUserLoad = new Core_User($myUser->id);
            /*cập nhật lại user*/
            foreach ($myUserLoad as $key => $value) {
                $this->registry->me->$key = $value;
            }
            $this->success[] = 'Cập nhật thành công';
        }
    }

    private function updateValid($formData)
    {

        $pass = true;
        if ($formData['femail'] != '') {
            $user = Core_User::getByEmail($formData['femail']);

            if ($user->id != 0) {
                $this->error[] = 'Email đã có người sử dụng';
                $pass          = false;
            }
        }

        if ($formData['fphone'] != '') {
            $user = Core_User::getUsers(array( 'fphone' => $formData['fphone'] ));

            if ($user[0]->id != 0) {
                $this->error[] = 'Số điện thoại đã có người sử dụng';
                $pass          = false;
            }
        }

        return $pass;
    }

    private function checkupdate($formData)
    {

        $pass = true;
        if ($formData['femail'] != '') {
            $user = Core_User::getByEmail($formData['femail']);
            if (!empty($user[0]->id)) {
                if ($user->id != $this->registry->me->id) {
                    $this->error[] = 'Email đã có người sử dụng';
                    $pass          = false;
                }
            }
        }

        if ($formData['fphone'] != '') {
            $user = Core_User::getUsers(array( 'fphone' => $formData['fphone'] ));

            if (!empty($user[0]->id)) {
                if ($user[0]->id != $this->registry->me->id) {
                    $this->error[] = 'Số điện thoại đã có người sử dụng';
                    $pass          = false;
                }
            }
        }

        return $pass;
    }

    private function vaildChangepass($formData)
    {

        $pass = true;


        if ($formData['fpass'] == '') {
            $this->error[]                = 'Vui lòng nhập mật khẩu hiện tại';
            $pass                         = false;
            $this->errorinput['errfpass'] = 'red';
        }

        if ($formData['password1'] == '') {

            $this->error[]                 = 'Vui lòng nhập mật khẩu mới';
            $pass                          = false;
            $this->errorinput['errfpass1'] = 'red';
        }

        if ($formData['password2'] == '') {

            $this->error[]                 = 'Vui lòng nhập mật khẩu xác nhận';
            $pass                          = false;
            $this->errorinput['errfpass2'] = 'red';
        }
        if ($pass == true) {
            if ($formData['password1'] != $formData['password2']) {

                $this->error[]                 = 'Xác nhận mật khẩu không đúng';
                $pass                          = false;
                $this->errorinput['errfpass2'] = 'red';
            }
        }

        return $pass;
    }


    public function saleorderAction()
    {
        set_time_limit(0);
        if (!isset($_SESSION['idCrmCustomer'])) {
            $this->accountNotSync();
            exit();
        }

        if ($this->registry->me->id != 0) {
            $flag       = array();
            $saleorders = new Core_Saleorder();

            $saleorder = $saleorders->getSaleorderByid($_SESSION['idCrmCustomer']);

            if (isset($_POST['fsubmit'])) {
                if (isset($_POST['fsearchsaleid']) && $_POST['fsearchsaleid'] != '') {
                    $conditionArr['SALEORDERID'] = $_POST['fsearchsaleid'];
                }
                if (isset($_POST['fsearchdate']) && $_POST['fsearchdate'] != '') {
                    $conditionArr['INPUTTIME'] = $_POST['fsearchdate'];
                }
                if (isset($_POST['fsearchstatus']) && $_POST['fsearchstatus'] != '') {
                    $conditionArr['STATUSNAME'] = $this->getNameStatus($_POST['fsearchstatus']);
                }
                if (!empty($saleorder)) {
                    foreach ($saleorder as $key => $value) {
                        $flag[$key] = false;
                        if (!empty($conditionArr)) {
                            foreach ($conditionArr as $k => $v) {
                                $ss = strpos(strtolower(trim($value->$k)), strtolower(trim($v)));
                                if (is_int($ss)) {
                                    $flag[$key] = true;
                                }

                            }
                        }

                    }
                }

            }

            if (!empty($conditionArr)) {
                if (!empty($flag)) {
                    foreach ($flag as $key => $value) {
                        if (!$value) {
                            unset($saleorder[$key]);
                        }
                    }

                }


            }
            $prostr = '';
            foreach ($saleorder as $khoa => $giatri) {
                $detail = $saleorders->getSaleorderDetailByid($_SESSION['idCrmCustomer'], $giatri['SALEORDERID']);
                foreach ($detail as $k => $v) {
                    $prostr                                = $prostr == ''? $v->strProductName : ',' . $v->strProductName;
                    $saleorder[$khoa]['strOutputTypeName'] = $v->strOutputTypeName;
                }
                $saleorder[$khoa]['PRODUCTNAME'] = $prostr;

            }

            $formData['countSal'] = $saleorder == ""? 0 : count($saleorder);
            $this->registry->smarty->assign(array( 'formData'  => $formData,
                                                   'saleorder' => $saleorder,
            ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleorder.tpl');

            $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                   'pageTitle' => $this->registry->lang['controller']['pageTitle_saledetail'],
                                                   'contents'  => $contents ));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        } else {
            header('location: ' . $this->registry['conf']['rooturl'] . 'notfound');
        }
    }

    private function accountNotSync()
    {
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'notsync.tpl');
        $this->registry->smarty->assign('contents', $contents);
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    private function getNameStatus($id)
    {
        $name = "";
        switch ($id) {
            case '0':
                $name = $this->registry->lang['controller']['staDXL'];
                break;
            case '1':
                $name = $this->registry->lang['controller']['staDAXL'];
                break;
            case '3':
                $name = $this->registry->lang['controller']['staDGH'];
                break;
            case '2':
                $name = $this->registry->lang['controller']['staDAGH'];
                break;
        }

        return $name;
    }

    public function checksaleorderAction($value = '')
    {
        $formData['load']   = '1';
        $formData['user']   = isset($_GET['user']) && $_GET['user'] != ''? $_GET['user'] : '';
        $formData['saleid'] = isset($_GET['id']) && $_GET['id'] != ''? $_GET['id'] : '';
        if ($formData['user'] != '' && $formData['saleid'] != '') {
            $formData['autosearch'] = 1;
            $_POST['fuser']         = $formData['user'];
            $_POST['fidsaleorder']  = $formData['saleid'];

        } else {
            if ($formData['saleid'] != '') {
                $formData['autosearch'] = 1;
                $_POST['fidsaleorder']  = $formData['saleid'];
            } else {
                $formData['autosearch'] = 0;
            }
        }

        if (isset($_POST['action']) && $_POST['action'] == 'checksaleorder') {
            set_time_limit(0);
            $saleorder = new Core_Saleorder();
            $error     = $this->validateCheckSaleorder($_POST);
            if (empty($error) && isset($_SESSION['checksaleorder']) && $_SESSION['checksaleorder'] != '') {
                // $rs = $saleorder->getSaleorderByid("1005680691");
                $register                            = new Core_Register();
                $customer                            = $register->searchcustomer($_POST['fuser']);
                $_SESSION['idcusomerchecksaleorder'] = $customer['CUSTOMERID'];
                $rs                                  = $saleorder->getSaleorderByid($_SESSION['checksaleorder']);
                if (!empty($rs)) {
                    foreach ($rs as $key => $value) {
                        if (trim($value->SALEORDERID) != $_POST['fidsaleorder']) {
                            unset($rs[$key]);
                        }
                    }
                    if (!empty($rs)) {
                        //							$this->showordercheck($rs);
                        exit();
                    } else {
                        $error[] = "Mã đơn hàng không tồn tại";
                    }
                } else {
                    $error[] = "tài khoản chưa đặt hàng";
                }
            }
        }


        // danh cho mobile
        if (isset($_POST['action']) && $_POST['action'] == 'checkordermobile') {
            $saleorder = new Core_Saleorder();
            if ($_POST['fidsaleorder'] != '') {
                $formData['fidsaleorder'] = $_POST['fidsaleorder'];
                if ($this->checkSaleid($_POST['fidsaleorder']) == 'ERP') {

                    $fidsaleorder = strtolower($_POST['fidsaleorder']);
                    $rs           = Core_Archivedorder::getArchivedorders(array( 'fsaleorderid' => $fidsaleorder ));
                    if ($rs[0]->id != "0") {
                        $saleorder  = array();
                        $strproduct = '';

                        foreach ($rs as $key => $value) {


                            $detail = Core_ArchivedorderDetail::getArchivedorderDetails(array( 'fsaleorderid' => $value->saleorderid ), '', '');

                            foreach ($detail as $key => $val) {
                                $product = Core_Product::getProducts(array( 'fid' => $val->pid ), '', '');
                                $strproduct .= $strproduct == ''? $product[0]->name : "," . $product[0]->name;
                            }

                            $region                             = new Core_Region($value->originatestoreregionid);
                            $saleorder[$key]['saleorderid']     = $value->saleorderid;
                            $saleorder[$key]['productname']     = $strproduct;
                            $saleorder[$key]['totalamount']     = $value->totalamount;
                            $saleorder[$key]['outputstorename'] = $region->name;
                            $saleorder[$key]['inputtime']       = date('d/m/Y', $value->inputtime);

                        }

                        $formData['countSal']  = $saleorder == ""? 0 : count($saleorder);
                        $formData['invoice']   = 4;
                        $formData['saleorder'] = $saleorder;
                    } else {
                        $error[] = "Mã đơn hàng không tồn tại";
                    }
                }

                if ($this->checkSaleid($_POST['fidsaleorder']) == 'order') {

                    $order = Core_Orders::getOrderss(array( 'finvoiceid' => $_POST['fidsaleorder'] ), '', '');
                    if ($order[0]->id != 0) {
                        $od_detail            = new Core_OrdersDetail();
                        $saleorder            = $order;
                        $formData['countSal'] = $saleorder == ""? 0 : count($saleorder);
                        $formData['invoice']  = 1;
                        $arrSaleorder         = array();
                        foreach ($saleorder as $k => $v) {
                            $strproduct = '';
                            $detail     = $od_detail::getOrdersDetails(array( 'foid' => $v->id ), '', '');
                            foreach ($detail as $key => $val) {
                                $product = Core_Product::getProducts(array( 'fid' => $val->pid ), '', '');
                                $strproduct .= $strproduct == ''? $product[0]->name : "," . $product[0]->name;
                            }

                            $region                                = new Core_Region($v->shippingregionid);
                            $arrSaleorder[$key]['saleorderid']     = $v->invoiceid;
                            $arrSaleorder[$key]['productname']     = $strproduct;
                            $arrSaleorder[$key]['totalamount']     = $v->pricefinal;
                            $arrSaleorder[$key]['outputstorename'] = $region->name;
                            $arrSaleorder[$key]['inputtime']       = date('d/m/Y', $v->datecreated);
                        }
                        $formData['saleorder'] = $arrSaleorder;
                    } else {
                        $error[] = "Không tìm thấy đơn hàng của bạn";
                    }

                }

                if ($this->checkSaleid($_POST['fidsaleorder']) == 'ins') {
                    $order = Core_Installment::getInstallments(array( 'finvoiceid' => $_POST['fidsaleorder'] ), '', '');
                    if ($order[0]->id != 0) {
                        $saleorder            = $order;
                        $formData['countSal'] = $saleorder == ""? 0 : count($saleorder);
                        $formData['invoice']  = 2;
                        $formData['user']     = $user;
                        $arrSaleorder         = array();
                        foreach ($saleorder as $k => $v) {

                            $product = Core_Product::getProducts(array( 'fid' => $v->pid ), '', '');

                            $region = new Core_Region($v->region);

                            $arrSaleorder[$k]['saleorderid']     = $v->invoiceid;
                            $arrSaleorder[$k]['productname']     = $product[0]->name;
                            $arrSaleorder[$k]['totalamount']     = $v->pricesell;
                            $arrSaleorder[$k]['outputstorename'] = $region->name;
                            $arrSaleorder[$k]['inputtime']       = date('d/m/Y', $v->datecreate);
                        }
                        $formData['saleorder'] = $arrSaleorder;
                    } else {
                        $error[] = "Không tìm thấy đơn hàng của bạn";
                    }
                }

            } else {
                $error[] = "Nhập mã đơn hàng";
            }
        }

        $this->registry->smarty->assign(array( 'error'    => $error,

                                               'formData' => $formData ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'check.tpl');
        $this->registry->smarty->assign(array( 'contents'        => $contents,
                                               'pageTitle'       => $this->registry->lang['controller']['titleCheck'],
                                               'pageKeyword'     => $this->registry->lang['controller']['pageKeyword'],
                                               'pageDescription' => $this->registry->lang['controller']['pageDescription'], ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function validateCheckSaleorder($arr)
    {
        $pass = true;
        if ($arr['fuser'] == '') {
            $this->error[] = $this->registry->lang['controller']['errfuser'];
            $pass          = false;
        } else {
            if (Helper::ValidatedEmail($arr['fuser'])) {
                $user        = Core_User::getByEmail($arr['fuser']);
                $this->phone = $user->phone;
            } else {
                if ($this->ValidMobile($arr['fuser'])) {
                    $this->phone = $arr['fuser'];
                }
            }
        }
        if ($arr['fidsaleorder'] == '') {
            $this->error[] = hi;
            $pass          = false;
        }

        return $pass;
    }

    //New
    public function validateCheckSaleorderGiaRe($arr)
    {
        $pass = true;
        if ($arr['fidsaleorder'] == '') {
            $this->error[] = $this->registry->lang['controller']['errsaleorder'];
            $pass          = false;
        }

        return $pass;
    }

    //End new
    private function ValidMobile($data)
    {
        $pass = true;
        if (!ctype_digit($data) && strlen($data) < 10 || strlen($data) > 11) {
            $pass = false;
        }

        return $pass;
    }

    public function indexajaxAction()
    {
        if (!isset($_SESSION['idCrmCustomer'])) {
            $this->createdCustomerid();
        }
        $formData['autosearch'] = 0;
        $action                 = isset($_POST['action']) && $_POST['action'] != ''? $_POST['action'] : '';
        $contents               = '';
        if ($action != '') {
            switch ($action) {

                case "checksaleorder":
                    set_time_limit(0);
                    $saleorder = new Core_Saleorder();
                    /*kt rong*/
                    if ($this->validateCheckSaleorder($_POST)) {
                        if ($this->checkSaleid($_POST['fidsaleorder']) == 'ERP') {
                            /*check user*/
                            $error[]               = $this->checkuser($_POST);
                            $_POST['fidsaleorder'] = strtolower($_POST['fidsaleorder']);
                            if (!empty($error) && $this->ValidPhone($_POST['fuser'])) {
                                $arr = array( 'fsaleorderid'   => $_POST['fidsaleorder'],
                                              'fcustomerphone' => $this->phone,

                                );
                                $rs  = Core_Archivedorder::getArchivedorders($arr);

                            } else {
                                $error[] = 'Vui lòng nhập số điện thoại để kiểm tra loại đơn hàng này';
                            }

                            if ($rs[0]->id != "0") {

                                $contents = $this->showordercheck($rs, base64_encode($_POST['fuser']));
                            } else {

                                $error[] = "Mã đơn hàng không tồn tại";
                            }

                        }


                        if ($this->checkSaleid($_POST['fidsaleorder']) == 'order') {

                            $arr = array();
                            if (Helper::ValidatedEmail($_POST['fuser'])) {
                                $arr = array( 'fcontactemail' => $_POST['fuser'],
                                              'finvoiceid'    => $_POST['fidsaleorder'] );
                            } else {
                                $error[] = 'Email không đúng định dạng';
                            }
                            if ($this->ValidMobile($_POST['fuser'])) {
                                $arr = array( 'fbillingphone' => $_POST['fuser'],
                                              'finvoiceid'    => $_POST['fidsaleorder'] );
                            } else {
                                $error[] = 'Số điện thoại không đúng định dạng';
                            }

                            if (!empty($arr)) {
                                $order = Core_Orders::getOrderss($arr, '', '');
                                if ($order[0]->id != 0) {
                                    $contents = $this->showorderinvoice($order, base64_encode($_POST['fuser']));
                                } else {
                                    $error[] = "Không tìm thấy đơn hàng của bạn";
                                }
                            } else {
                                $error[] = "tài khoản chưa đặt hàng hoặc thông tin không đúng";
                            }
                        }

                        if ($this->checkSaleid($_POST['fidsaleorder']) == 'ins') {

                            $arr = array();
                            if (Helper::ValidatedEmail($_POST['fuser'])) {
                                $arr = array( 'fcontactemail' => $_POST['fuser'],
                                              'finvoiceid'    => $_POST['fidsaleorder'] );
                            } else {
                                $error[] = 'Email không đúng định dạng';
                            }
                            if ($this->ValidMobile($_POST['fuser'])) {
                                $arr = array( 'fbillingphone' => $_POST['fuser'],
                                              'finvoiceid'    => $_POST['fidsaleorder'] );
                            } else {
                                $error[] = 'Số điện thoại không đúng định dạng';
                            }

                            if (!empty($arr)) {
                                $order = Core_Installment::getInstallments($arr, '', '');
                                if ($order[0]->id != 0) {
                                    $contents = $this->showorderintallment($order, base64_encode($_POST['fuser']));
                                } else {
                                    $error[] = "Không tìm thấy đơn hàng của bạn";
                                }
                            } else {
                                $error[] = "tài khoản chưa đặt hàng hoặc thông tin không đúng";
                            }
                            $error[] = 'đơn hàng của bạn là đơn hàng trả góp hiện đang phát triển';
                        }
                        /*có lỗi từ crm*/
                        if (!empty($error) && $contents == '') {
                            $this->registry->smarty->assign(array( 'error' => $error ));
                            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'check.tpl');
                        }

                    } else /*có lỗi về data truyen vao*/ {
                        $this->registry->smarty->assign(array( 'error' => $this->error ));
                        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'check.tpl');
                    }
                    echo $contents;

                    return;

                case 'checksaleordergiare':
                    set_time_limit(0);
                    $saleorder = new Core_Saleorder();
                    /*kt rong*/
                    if ($this->validateCheckSaleorderGiaRe($_POST)) {
                        if ($this->checkSaleid($_POST['fidsaleorder']) == 'ERP') {
                            $_POST['fidsaleorder'] = strtolower($_POST['fidsaleorder']);
                            $arr                   = array( 'fsaleorderid' => $_POST['fidsaleorder'] );
                            $rs                    = Core_Archivedorder::getArchivedorders($arr);
                            //echodebug($rs);
                            if (!empty($rs)) {
                                $contents = $this->showordercheck($rs, base64_encode($rs[0]->customerphone));
                            } else {

                                $error[] = "Mã đơn hàng không tồn tại";
                            }

                        }
                        if ($this->checkSaleid($_POST['fidsaleorder']) == 'order') {
                            $arr = array();
                            $arr = array( 'finvoiceid' => $_POST['fidsaleorder'] );

                            if (!empty($arr)) {
                                $order = Core_Orders::getOrderss($arr, '', '');
                                if (!empty($order)) {
                                    $contents = $this->showorderinvoice($order, base64_encode($order[0]->contactemail));
                                } else {
                                    $error[] = "Không tìm thấy đơn hàng của bạn";
                                }
                            } else {
                                $error[] = "Không tìm thấy đơn hàng của bạn";
                            }
                        }

                        if ($this->checkSaleid($_POST['fidsaleorder']) == 'ins') {
                            $arr = array();
                            $arr = array( 'finvoiceid' => $_POST['fidsaleorder'] );
                            if (!empty($arr)) {
                                $order = Core_Installment::getInstallments($arr, '', '');
                                //echodebug($order);
                                if (!empty($order)) {
                                    $contents = $this->showorderintallment($order, base64_encode($order[0]->email));
                                } else {
                                    $error[] = "Không tìm thấy đơn hàng của bạn";
                                }
                            } else {
                                $error[] = "Không tìm thấy đơn hàng của bạn";
                            }
                        }
                        /*có lỗi từ crm*/
                        if (!empty($error) && $contents == '') {
                            $this->registry->smarty->assign(array( 'error' => $error ));
                            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'check.tpl');
                        }


                    } else /*có lỗi về data truyen vao*/ {
                        $this->registry->smarty->assign(array( 'error' => $this->error ));
                        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'check.tpl');
                    }
                    echo $contents;

                    return;

                case 'updateaccount':

                    $rs    = array();
                    $value = isset($_POST['value'])? json_decode($_POST['value']) : '';
                    $field = isset($_POST['field'])? $_POST['field'] : '';
                    $error = array();
                    if ($field == 'gender') {
                        $value = (string)$value;
                    }


                    if ($value != '' && $field != '' || !empty($value)) {


                        if ($field == 'password') {
                            $error = $this->geterr($this->validateUpdate($value, $field), $field);
                            if (empty($error)) {
                                $error = $this->changepassajax($value);
                            }

                        } else {

                            $error = $this->geterr($this->validateUpdate($value, $field), $field);
                            $arr   = array();
                            if (empty($error)) {

                                $myuser = new Core_User($this->registry->me->id);
                                if ($field == 'address') {

                                    $myuser->address  = $value[0] != ''? $value[0] : $myuser->address;
                                    $myuser->city     = $value[1] != ''? $value[1] : $myuser->city;
                                    $myuser->district = $value[2] != ''? $value[2] : $myuser->district;
                                    $rs['sta']        = "ok";

                                } else {
                                    $arrfield    = array( 'fullname', 'gender' );
                                    $arr[$field] = $value == ''? $myuser->$field : $value;
                                    if (!in_array($field, $arrfield)) {

                                        if ($field == 'birthday') {
                                            $value = $this->formattime($value, 'crm');
                                        }

                                        $myuser->$field = $value == ''? $myuser->$field : $value;
                                    }


                                }
                                if ($field == 'gender') {
                                    $oldgender      = $myuser->gender;
                                    $myuser->gender = $value;
                                }
                                $this->crm = Core_Customer::UpdateDMCustomer($myuser, $_SESSION['idCrmCustomer']);


                                if ($this->crm > 0) {
                                    if ($field == 'birthday') {
                                        $value          = $this->formattime($value, 'mysql2');
                                        $myuser->$field = $value == ''? $myuser->$field : $value;
                                    }
                                    if ($field == 'gender') {
                                        $myuser->gender             = $oldgender;
                                        $this->registry->me->gender = $value;
                                    }

                                    $myuser->updateData($arr);
                                } else {
                                    $error = $this->getError(false);
                                }
                            }


                        }

                    } else {
                        $error[] = 'Thông tin tài khoản không chính xác , vui lòng thử lại';
                    }
                    if (!empty($error)) {
                        $rs['sta'] = "notok";
                        $rs['msg'] = json_encode($error);
                    } else {
                        $rs['sta'] = "ok";
                    }

                    echo json_encode($rs);

                    break;
                case 'updatesub';
                    $value = isset($_POST['value'])? $_POST['value'] : '';
                    $str   = '';
                    if ($value != '') {
                        $subcriber = Core_Subscriber::getSubscribers(array( 'fuid' => $this->registry->me->id ), '', '', '');

                        if ($value == 'email') {
                            if (empty($subcriber)) {
                                $MySub        = new Core_Subscriber();
                                $MySub->email = $this->registry->me->email;
                                $MySub->uid   = $this->registry->me->id;
                                $MySub->addData();

                                $this->subcriberCrm();
                                $str[] = 'nhan';
                                $str[] = 'konhan';
                            } else {

                                $MySub = new Core_Subscriber($subcriber[0]->id);
                                if ($MySub->email != '') {
                                    if ($subcriber[0]->phone != '' && $subcriber[0]->sms != 1) {
                                        $MySub->delete();
                                    } else {
                                        $MySub->email = '';
                                        $MySub->updateData();
                                    }
                                    $this->subcriberCrm();
                                    $str[] = 'konhan';
                                    $str[] = 'nhan';
                                } else {
                                    $MySub->email = $this->registry->me->email;
                                    $MySub->updateData();

                                    $this->subcriberCrm();

                                    $str[] = 'nhan';
                                    $str[] = 'konhan';
                                }

                            }
                        }
                        if ($value == 'phone') {
                            if (empty($subcriber)) {
                                $MySub        = new Core_Subscriber();
                                $MySub->phone = $this->registry->me->phone;
                                $MySub->sms   = 1;
                                $MySub->uid   = $this->registry->me->id;
                                $MySub->addData();

                                $this->subcriberCrm();

                                $str[] = 'nhan';
                                $str[] = 'konhan';
                            } else {
                                if ($subcriber[0]->phone == '' && $subcriber[0]->sms == 0) {
                                    $MySub        = new Core_Subscriber($subcriber[0]->id);
                                    $MySub->sms   = 1;
                                    $MySub->phone = $this->registry->me->phone;
                                    $MySub->updateData();

                                    $this->subcriberCrm();

                                    $str[] = 'nhan';
                                    $str[] = 'konhan';
                                } else {
                                    $MySub = new Core_Subscriber($subcriber[0]->id);
                                    if ($MySub->email == '') {
                                        $MySub->delete();
                                    } else {
                                        $MySub->phone = '';
                                        $MySub->sms   = 0;
                                        $MySub->updateData();
                                    }

                                    $this->subcriberCrm();

                                    $str[] = 'konhan';
                                    $str[] = 'nhan';
                                }

                            }
                        }
                    }
                    echo json_encode($str);
                    break;
                case 'delbookmark':
                    $id = isset($_POST['value']) && (int)$_POST['value'] > 0? $_POST['value'] : '';
                    if ($id != '') {
                        $search = Core_RelProductbookmark::getRelProductbookmarks(array( 'fpid' => $id, 'fuid' => $this->registry->me->id ), '', '', '');
                        if (count($search) == 1 && !empty($search)) {
                            $MyBookmark = new Core_RelProductbookmark($search[0]->id);
                            $MyBookmark->delete();
                        }
                    }

                    return;
            }
        }


    }

    private function subcriberCrm()
    {
        $MySub                = Core_Subscriber::getSubscribers(array( 'fuid' => $this->registry->me->id ), '', '', '');
        $user                 = new Core_User($this->registry->me->id);
        $user->subcriberemail = $MySub[0]->email != ''? 'true' : 'false';
        $user->subcribersms   = $MySub[0]->sms != 0? 'true' : 'false';
        Core_Customer::UpdateDMCustomer($user, $_SESSION['idCrmCustomer']);
    }

    private function changepassajax($value)
    {
        $myUser = new Core_User($this->registry->me->id);
        $CrmAcc = array();
        $error  = array();
        if ($myUser->email != '') {
            $CrmAcc = Core_Customer::LoginReturnCustomerJson($myUser->email, $value[0]);
        } elseif ($myUser->phone != '') {
            $CrmAcc = Core_Customer::LoginReturnCustomerJson($myUser->phone, $value[0]);
        }


        if (!empty($CrmAcc) && $CrmAcc->CUSTOMERID != '0' && $CrmAcc != '') {
            if ($myUser->id != 0) {
                $Crm     = new Core_Customer();
                $CrmCode = 0;
                if ($myUser->email != '') {
                    $CrmCode = $Crm->insertCodeReset($myUser->email);
                } elseif ($myUser->phone) {
                    $CrmCode = $Crm->insertCodeReset($myUser->email);
                }


                if ($CrmCode != 0) {
                    if ($Crm->resetPass($myUser->email, $CrmCode, $value[1])) {
                        $myUser->newpass = $value[1];
                        if (!$myUser->updateData()) {
                            $error[] = 'Có lỗi khi đổi mật khẩu';
                        }
                    } else {
                        $error[] = 'Có lỗi khi đổi mật khẩu , Vui lòng thử lại sau';
                    }
                }

            }

        }

        return $error;
    }

    private function geterr($arr, $field)
    {
        $err = array();
        foreach ($arr as $k => $v) {
            if ($v == 1) {
                $err[] = $this->registry->lang['controller']['errpassword[' . $v . ']'];
            } else {
                $err[] = $this->registry->lang['controller']['err' . $field . '[' . $v . ']'];
            }
        }

        return $err;
    }

    private function validateUpdate($value, $field)
    {
        $pass = array();

        if ($field == 'password') {
            foreach ($value as $v) {
                if ($v == '') {
                    $pass = false;
                }
            }

            if (!$pass) {
                $pass[] = 1;
            } else {
                if (is_array($value) && count($value) == 3) {

                    $newepass = viephpHashing::hash($value[0]);

                    $user = new Core_User($this->registry->me->id);
                    if ($newepass != $user->password) {
                        $pass[] = 2;
                    }
                    if (strlen($value[0]) < 6) {
                        $pass[] = 3;
                    }
                    if ($value[1] != $value[2]) {
                        $pass[] = 4;
                    }
                } else {
                    $pass[] = -1;
                }
            }

        } else {

            if (is_array($value)) {
                $flag = true;
                foreach ($value as $v) {
                    if ($v == '') {
                        $flag = false;
                    }

                }
                if (!$flag) {
                    $pass[] = 1;
                }

            } else {
                if ($value == '') {
                    $pass[] = 1;
                }
            }

        }


        return $pass;
    }

    private function checkSaleid($str)
    {
        $rs = 'order';
        if (preg_match('/[0-9]SO[0-9]/', $str)) {
            $rs = 'ERP';
        }
        if (preg_match('/[A-z0-9]i/i', $str)) {
            $rs = 'ins';
        }

        return $rs;
    }

    private function checkuser($arr)
    {

        $err  = '';
        $rs   = '';
        $user = '';
        if ($arr['fuser'] != '') {

            if (Helper::ValidatedEmail($_POST['fuser'])) {
                $rs = 'mail';
            }

            if ($this->ValidMobile($_POST['fuser'])) {
                $rs = 'phone';
            }

            if ($rs != '') {
                if ($rs == 'mail') {
                    $user[] = Core_User::getByEmail($arr['fuser']);
                }
                if ($rs == 'phone') {
                    $user = Core_User::getUsers(array( 'fphone' => $arr['fuser'] ));
                }
            }

            if ($user[0]->id == '0') {
                $err = $this->registry->lang['controller']['existInfo'];
            }

            return $err;
        }
    }

    private function ValidPhone($data)
    {
        $pass = true;
        if (!ctype_digit($data) && strlen($data) < 10 || strlen($data) > 11) {
            $pass = false;
        }

        return $pass;
    }

    public function showordercheck($rs, $user)
    {
        $saleorder  = array();
        $strproduct = '';

        foreach ($rs as $key => $value) {


            $detail = Core_ArchivedorderDetail::getArchivedorderDetails(array( 'fsaleorderid' => $value->saleorderid ), '', '');

            foreach ($detail as $key => $val) {
                $product = Core_Product::getProducts(array( 'fid' => $val->pid ), '', '');
                $strproduct .= $strproduct == ''? $product[0]->name : "," . $product[0]->name;
            }

            $region                             = new Core_Region($value->originatestoreregionid);
            $saleorder[$key]['saleorderid']     = $value->saleorderid;
            $saleorder[$key]['productname']     = $strproduct;
            $saleorder[$key]['totalamount']     = $value->totalamount;
            $saleorder[$key]['outputstorename'] = $region->name;
            $saleorder[$key]['inputtime']       = date('d/m/Y', $value->inputtime);

        }

        $formData['countSal'] = $saleorder == ""? 0 : count($saleorder);
        $formData['invoice']  = 4;
        $formData['user']     = $user;

        $this->registry->smarty->assign(array( 'formData'  => $formData,
                                               'saleorder' => $saleorder ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleordercheck.tpl');

        return $contents;
    }

    public function showorderinvoice($rs, $user)
    {
        $od_detail            = new Core_OrdersDetail();
        $saleorder            = $rs;
        $formData['countSal'] = $saleorder == ""? 0 : count($saleorder);
        $formData['invoice']  = 1;
        $formData['user']     = $user;
        $arrSaleorder         = array();
        foreach ($saleorder as $k => $v) {
            $strproduct = '';
            $detail     = $od_detail::getOrdersDetails(array( 'foid' => $v->id ), '', '');
            foreach ($detail as $key => $val) {
                $product = Core_Product::getProducts(array( 'fid' => $val->pid ), '', '');
                $strproduct .= $strproduct == ''? $product[0]->name : "," . $product[0]->name;
            }

            $region                                = new Core_Region($v->shippingregionid);
            $arrSaleorder[$key]['saleorderid']     = $v->invoiceid;
            $arrSaleorder[$key]['productname']     = $strproduct;
            $arrSaleorder[$key]['totalamount']     = $v->pricefinal;
            $arrSaleorder[$key]['outputstorename'] = $region->name;
            $arrSaleorder[$key]['inputtime']       = date('d/m/Y', $v->datecreated);
        }

        $this->registry->smarty->assign(array( 'formData'  => $formData,
                                               'saleorder' => $arrSaleorder ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleordercheck.tpl');

        return $contents;
    }

    public function showorderintallment($rs, $user)
    {

        $od_detail            = new Core_OrdersDetail();
        $saleorder            = $rs;
        $formData['countSal'] = $saleorder == ""? 0 : count($saleorder);
        $formData['invoice']  = 2;
        $formData['user']     = $user;
        $arrSaleorder         = array();
        foreach ($saleorder as $k => $v) {
            /*$strproduct = '';
            $detail     = $od_detail::getOrdersDetails(array('foid' => $v->id), '', '');
            foreach ($detail as $key => $val) {*/
            $product = Core_Product::getProducts(array( 'fid' => $v->pid ), '', '');
            //				}

            $region = new Core_Region($v->region);

            $arrSaleorder[$k]['saleorderid']     = $v->invoiceid;
            $arrSaleorder[$k]['productname']     = $product[0]->name;
            $arrSaleorder[$k]['totalamount']     = $v->pricesell;
            $arrSaleorder[$k]['outputstorename'] = $region->name;
            $arrSaleorder[$k]['inputtime']       = date('d/m/Y', $v->datecreate);
        }
        $this->registry->smarty->assign(array( 'formData'  => $formData,
                                               'saleorder' => $arrSaleorder ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleordercheck.tpl');

        return $contents;
    }

    public function showorderdetailcheckAction()
    {

        $saleid              = $this->registry->router->getArg('saleid');
        $user                = base64_decode($this->registry->router->getArg('user'));
        $formData['invoice'] = 4;
        set_time_limit(0);
        /*id customer*/
        $flag             = false;
        $saleorder_info   = array();
        $saleorder_detail = array();
        if ($saleid != null && $user != null && $this->ValidPhone($user)) {

            $archiveOrder = Core_Archivedorder::getArchivedorders(array( 'fsaleorderid' => $saleid, 'fcustomerphone' => $user ));

            if ($archiveOrder[0]->id != '0' && !empty($archiveOrder)) {
                $archiveOrderDetail = Core_ArchivedorderDetail::getArchivedorderDetails(array( 'fsaleorderid' => $saleid ), '', '');
                $flag               = true;
            } else {
                $saleorder_detail = array();
            }


            if ($flag) {
                $Myuser = Core_User::getUsers(array( 'fphone' => $user ));

                //echodebug($archiveOrder);
                $saleorder_info[0]['inputTime']    = date('d/m/Y', $archiveOrder[0]->createdate);
                $saleorder_info[0]['deliveryTime'] = date('d/m/Y', $archiveOrder[0]->deliverytime);
                if (!empty($Myuser)) {
                    $saleorder_info[0]['cusname'] = $user[0]->fullname;
                    $saleorder_info[0]['cusmail'] = $user[0]->email;
                } else {
                    $saleorder_info[0]['cusname'] = 'Khách lẻ';
                    $saleorder_info[0]['cusmail'] = 'Khách lẻ';
                }
                $saleorder_info[0]['cusphone'] = $user;


                $product = new Core_Product();

                $formData['totalorder']     = 0;
                $formData['promotionmoney'] = 0;
                foreach ($archiveOrder as $key => $value) {

                    $formData['totalorder']     = $value->totalamount;
                    $formData['promotionmoney'] = $value->discount;
                }
                $product = new Core_Product();

                foreach ($archiveOrderDetail as $key => $value) {
                    if ($value->productid != "") {
                        $sync = $product->getIdByBarcode($value->productid);
                        if ($sync->barcode != null) {
                            if ($sync->image != null) {
                                $saleorder_detail[$key]['img'] = $this->registry->conf['rooturl'] . "uploads/" . $sync->image;
                            } else {
                                $saleorder_detail[$key]['img'] = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                            }
                            $saleorder_detail[$key]['strProductName'] = $sync->name;
                        } else {
                            $saleorder_detail[$key]['img'] = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                        }

                    } else {
                        $saleorder_detail[$key]['img'] = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                    }
                    $saleorder_detail[$key]['strImei']      = $value->productid;
                    $saleorder_detail[$key]['strQuantity']  = $value->quantity;
                    $saleorder_detail[$key]['strTotalCost'] = $value->saleprice;
                }
                /*sort theo gia*/
                krsort($saleorder_detail);

                $formData['totalpayment'] = $formData['totalorder'] - $formData['promotionmoney'];
                $formData['saleid']       = trim($saleid);
                $store                    = new Core_Store($archiveOrder[0]->originatestoreid);

                $formData['storename'] = $store->name;
                $formData['countsale'] = count($saleorder_detail);
                $this->registry->smarty->assign(array( 'formData'       => $formData,
                                                       'saleorder'      => $saleorder_detail,
                                                       'saleorder_info' => $saleorder_info,
                ));
                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleorderdetailcheck.tpl');

                $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                       'pageTitle' => $this->registry->lang['controller']['pageTitle_saledetail'],
                                                       'contents'  => $contents ));
                $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

            } else {
                $this->redirectErr();
                exit();
            }

        } else {
            $this->redirectErr();
            exit();
        }
    }

    function redirectErr()
    {
        header('location: ' . $this->registry['conf']['rooturl'] . 'notfound');
    }

    public function showdetailinvoiceAction()
    {
        $user   = $this->registry->router->getArg('user');
        $saleid = $this->registry->router->getArg('saleid');
        if ($saleid != null && $user != null) {
            $user                = base64_decode($user);
            $formData['invoice'] = 0;
            $formData            = array();
            $saleorder_detail    = array();
            if (Helper::ValidatedEmail($user)) {
                $order = Core_Orders::getOrderss(array( 'finvoiceid'    => $saleid,
                                                        'fcontactemail' => $user ), '', '');
            }
            if ($this->ValidMobile($user)) {
                $order = Core_Orders::getOrderss(array( 'finvoiceid'    => $saleid,
                                                        'fbillingphone' => $user ), '', '');
            }
            if ($order[0]->id != 0) {
                $od_detail        = new Core_OrdersDetail();
                $saleorder_detail = $od_detail::getOrdersDetails(array( 'foid' => $order[0]->id ), '', '');


                foreach ($saleorder_detail as $key => $val) {
                    $product                                   = Core_Product::getProducts(array( 'fid' => $val->pid ), '', '');
                    $saleorder_detail1[$key]['strProductName'] = $product[0]->name;
                    $saleorder_detail1[$key]['img']            = $this->registry['conf']['rooturl'] . 'uploads/product/' . $product[0]->image;
                    $saleorder_detail1[$key]['strImei']        = $product[0]->barcode;
                    $saleorder_detail1[$key]['strTotalCost']   = $val->pricesell;
                    $saleorder_detail1[$key]['strQuantity']    = $val->quantity;

                }
                $formData['discountname'] = 'không có...';
                if ($order[0]->promotionid > 0) {
                    $promotion                = Core_Promotion::getPromotions(array( 'fid' => $order[0]->promotionid ), '', '');
                    $formData['discountname'] = $promotion[0]->name;
                }

                $formData['totalorder']     = $order[0]->pricesell;
                $formData['saleid']         = $order[0]->invoiceid;
                $formData['promotionmoney'] = $order[0]->pricediscount;
                $formData['totalpayment']   = $order[0]->pricesell - $order[0]->pricediscount;
            }
            $formData['countsale'] = count($saleorder_detail);
            $this->registry->smarty->assign(array( 'formData'  => $formData,
                                                   'saleorder' => $saleorder_detail1,
            ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleorderdetailcheck.tpl');
            $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                   'pageTitle' => $this->registry->lang['controller']['pageTitle_saledetail'],
                                                   'contents'  => $contents ));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        } else {
            $this->redirectErr();
            exit();
        }
    }

    public function showdetailinsAction()
    {
        $user   = $this->registry->router->getArg('user');
        $saleid = $this->registry->router->getArg('saleid');
        if ($saleid != null && $user != null) {

            $user                = base64_decode($user);
            $formData            = array();
            $formData['invoice'] = 2;
            $od_detail           = new Core_Installment();
            $saleorder_detail    = array();
            if (Helper::ValidatedEmail($user)) {
                $saleorder_detail = $od_detail::getInstallments(array( 'finvoiceid' => $saleid,
                                                                       'femail'     => $user ), '', '');
            }
            if ($this->ValidMobile($user)) {
                $saleorder_detail = $od_detail::getInstallments(array( 'finvoiceid' => $saleid,
                                                                       'fphone'     => $user ), '', '');
            }
            $totalorderinstall = 0;
            //echodebug($saleorder_detail);
            if (!empty($saleorder_detail)) {
                foreach ($saleorder_detail as $key => $val) {
                    $product                                     = Core_Product::getProducts(array( 'fid' => $val->pid ), '', '');
                    $saleorder_detail1[$key]['strProductName']   = $product[0]->name;
                    $saleorder_detail1[$key]['img']              = $this->registry['conf']['rooturl'] . 'uploads/product/' . $product[0]->image;
                    $saleorder_detail1[$key]['strImei']          = $product[0]->barcode;
                    $saleorder_detail1[$key]['strTotalCost']     = $val->pricesell;
                    $saleorder_detail1[$key]['strQuantity']      = $val->quantity;
                    $saleorder_detail1[$key]['datecreate']       = date('d/m/Y', $val->datecreate);
                    $saleorder_detail1[$key]['fullname']         = $val->fullname;
                    $saleorder_detail1[$key]['phone']            = $val->phone;
                    $saleorder_detail1[$key]['email']            = $val->email;
                    $calcInstallment                             = Core_Installment::calcInstallment($val->pricesell, ($val->segmentpercent / 100), $val->installmentmonth, $product[0]->pcid);
                    $saleorder_detail1[$key]['pricemonthly']     = isset($calcInstallment['ACS']['monthly'])? $calcInstallment['ACS']['monthly'] : $calcInstallment['PFF']['monthly'];
                    $saleorder_detail1[$key]['installmentmonth'] = $val->installmentmonth;
                    $formData['totalorder']                      = $val->pricesell;
                    $totalorderinstall += $val->pricesell;
                    $formData['saleid'] = $val->invoiceid;

                }
                $formData['totalpayment'] = $totalorderinstall;
                $formData['countsale']    = count($saleorder_detail);
                $this->registry->smarty->assign(array( 'formData'  => $formData,
                                                       'saleorder' => $saleorder_detail1,
                ));
                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleorderdetailcheck.tpl');
                $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                       'pageTitle' => $this->registry->lang['controller']['pageTitle_saledetail'],
                                                       'contents'  => $contents ));
                $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
            } else {
                $this->redirectErr();
                exit();
            }
        }
    }

    public function saleorderdetailAction()
    {
        set_time_limit(0);
        /*id customer*/
        if (!isset($_SESSION['idCrmCustomer'])) {
            $this->accountNotSync();
            exit();
        }

        $flag = false;

        $saleid = $this->registry->router->getArg('saleid');

        if ($saleid != null) {
            $saleorders = new Core_Saleorder();

            /*do 2 hàm info va detail ko có kt customerid va search theo like nen phai kt history xem co don hang tren url ko*/
            $flag = $this->checksaleorderid($saleid);

            if ($flag) {
                $saleorder_info   = array();
                $saleorder_detail = array();
                $saleorder_info   = $saleorders->GetSaleOrderDetailInfo($_SESSION['idCrmCustomer'], $saleid);
                $saleorder_detail = $saleorders->getSaleorderDetailByid($_SESSION['idCrmCustomer'], $saleid);


                // $saleorder_detail = $saleorders->getSaleorderDetailByid("1005680691",$saleid);

                if (!empty($saleorder_info) && !empty($saleorder_detail)) {
                    $saleorder_info[0]['inputTime']    = $this->formatdatecrm($saleorder_info[0]->inputTime);
                    $saleorder_info[0]['deliveryTime'] = $this->formatdatecrm($saleorder_info[0]->deliveryTime);
                    $formData['discountname']          = $saleorder_info[0]->discountName;
                    $product                           = new Core_Product();


                    $formData['totalorder']     = 0;
                    $formData['promotionmoney'] = 0;
                    foreach ($saleorder_info as $key => $value) {

                        $formData['totalorder']     = $value->total;
                        $formData['promotionmoney'] = $value->discount;
                    }

                    foreach ($saleorder_detail as $key => $value) {
                        if ($value->strImei != "") {
                            $sync = $product->getIdByBarcode($value->strImei);
                            if ($sync->barcode != null) {
                                $saleorder_detail[$key]['sync'] = "V";
                                if ($sync->image != null) {
                                    $saleorder_detail[$key]['img'] = $this->registry->conf['rooturl'] . "uploads/" . $sync->image;
                                } else {
                                    $saleorder_detail[$key]['img'] = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                                }
                            } else {
                                $saleorder_detail[$key]['sync'] = "X";
                                $saleorder_detail[$key]['img']  = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                            }
                        } else {
                            $saleorder_detail[$key]['sync'] = "O";
                            $saleorder_detail[$key]['img']  = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
                        }
                    }
                    /*sort theo gia*/
                    krsort($saleorder_detail);

                    $formData['totalpayment'] = $formData['totalorder'] - $formData['promotionmoney'];
                    $formData['saleid']       = $saleid;
                    $formData['storename']    = $saleorder_info[0]->storeName;
                    $this->registry->smarty->assign(array(
                        'formData'       => $formData,
                        'saleorder'      => $saleorder_detail,
                        'saleorder_info' => $saleorder_info,
                    ));

                }
                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saleorderdetail.tpl');

                $this->registry->smarty->assign(array( 'menu'      => 'useradd',
                                                       'pageTitle' => $this->registry->lang['controller']['pageTitle_saledetail'],
                                                       'contents'  => $contents ));
                $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
            } else {

                $this->redirectErr();
                exit();
            }

        } else {
            $this->redirectErr();
            exit();
        }
    }

    private function checksaleorderid($saleid)
    {
        $flag            = false;
        $saleorders      = new Core_Saleorder();
        $saleorder_check = $saleorders->getSaleorderByid($_SESSION['idCrmCustomer']);
        foreach ($saleorder_check as $k => $v) {
            if (trim($v->SALEORDERID) == trim($saleid)) {
                $flag = true;
            }
        }

        return $flag;
    }

    private function formatdatecrm($str)
    {
        $str = substr($str, 0, 10);

        return $str;
    }

}