<?php
Class Controller_Site_Giare Extends Controller_Site_Base
{
    private $recordPerPage = 10;
    public $error;
    public $begindate = '26/4/2013';
    public $enddate   = '24/5/2013';
    public $errorcontrol;
    public function indexAction()
    {
           
            $formData = array();

            $formData['dateend'] = 0;
            if(time()>=Helper::strtotimedmy('25/05/2013 00:00:01'))
	            $formData['dateend'] = 1;

            $this->begindate = Helper::strtotimedmy($this->begindate);
            $this->enddate   = Helper::strtotimedmy($this->enddate);
                    
            $formData['countmem'] = Core_LotteMember::getLotteMembers(array(), '', '', '', true);        
            $formData['countcode'] = Core_LotteCode::getLotteCodes(array(), '', '', '', true); 
            $newmem = Core_LotteMember::getnewid();
            if(!empty($newmem))
            {
                 foreach ($newmem as $key => $value) {
                    $formData['newmem']     = $value->fullname;
                    $code = Core_LotteCode::getLotteCodes(array('flmid'=>$value->id), '', '');
                    foreach ($code as $k => $v) {
                        $type = Core_LotteCode::getTypename();
                        $formData['newaction']  = $type[$v->type].($v->type=='5'? " người khác " : ' thành công ') ;
                        $formData['newcode']    = $v->code;
                    }

                }
            }
          
            $myCheapProduct = new Core_CheapProduct(1);
            $listproductapply = null;
            if(!empty($myCheapProduct->listproduct))
            {
                $sortby = '';
                if($_GET['fillter'] != "")
                {
                    $fillter = $_GET['fillter'];
                    if($fillter == 'giam-gia' || $fillter == 'qua-tang')
                        $formData['fisbagdegift'] = $fillter == 'giam-gia'? 0 : $fillter == 'qua-tang'?1:-1;
                    if($fillter == 'gia')
                    {
                        $sortby = 'sellprice';
                    }
                    if($fillter == 'nganh-hang')
                    {
                      $sortby= 'id';
                    }
                }
                $formData['fidarr'] = explode(',',$myCheapProduct->listproduct);
                $formData['fonsitestatus'] = Core_Product::OS_ERP;
                $listproductapply = Core_Product::getProducts($formData,$sortby,'ASC');
                $newlistproduct = array();
                if(!empty($listproductapply))
                {
                    foreach($listproductapply as $proapp)
                    {
                        $newprod = Core_Promotion::getAllPromotionwithOutputByBarcode($proapp->barcode);
                        if($newprod) {
                            $promotionprice = $newprod->promotionprice;
                            $productprice = $newprod->sellprice;
                            $percent = floor((-($promotionprice-$productprice)*100/$productprice)); 
                            $newprod->discountpercent = $percent;
                            $newlistproduct[] = $newprod;
                        }
                        else
                        { 
                          $newlistproduct[] = $proapp;

                        }
                    }
                    $listproductapply = $newlistproduct;
                }
            }
             //Getslugbanner/////////////////////////
            $slug = Helper::slugBannerURL();
            $slug = explode("?",$slug);
            //End Getslugbanner/////////////////////
            //Banner header 
            $bannerHeader = $this->getBannerBySlugZone($slug[0],17);
            //Banner footer 1
            $bannerFooter1 = $this->getBannerBySlugZone($slug[0],18);
            $bannerFooter2 = $this->getBannerBySlugZone($slug[0],19);
            $bannerFooter3 = $this->getBannerBySlugZone($slug[0],20);
            $this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
                                                    'listproductapply' => $listproductapply,
                                                    'listbanner' => $this->getBanner(),
                                                    'region'        => $this->registry->setting['region'],
                                                    'mypageid32'        => new Core_Page(32),
                                                    'formData'  =>$formData,
                                                    'regulations' => $this->getPage(51),
                                                    'orders'=> $this->getOrder(34),
                                                    'productorder' => $this->getProductOrder(),
                                                    'bannerHeader' => $bannerHeader,
                                                    'bannerFooter1' => $bannerFooter1,
                                                    'bannerFooter2' => $bannerFooter2,
                                                    'bannerFooter3' => $bannerFooter3
            ));

            $this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');


    }
    private function invisilbeStr($input)
    {
        $str = '';
        $dem = strlen($input);
        for ($index = 0; $index < $dem; $index++) {
            $sub = $dem-4;
            if($index<=$sub)
                $str .='x';
            else
                $str .=$input[$index];

        }
        return $str;
    }

    public function formattime($value = '')
    {
            $str = explode("-", $value);
            $rs  = $str[2] . "/" . $str[1] . "/" . $str[0];
            return $rs;

    }
    private function formatdatecrm($str)
    {
            $str = substr($str, 0, 10);
            return $str;
    }

   public function indexajaxAction()
    {
        $action = isset($_POST['action']) && $_POST['action']=='checkcode' ? $_POST['action'] : '' ;



        if($action!='')
        {

            switch ($action) {
                case 'dangki':
                   
                       if($this->validregister($_POST))
                       {
                            $formData                       = array();
                            $formData                       = array_merge($formData, $_POST);
                            
                            $arrUrl = explode('/', $_POST['url']);
                            
                            if(is_numeric($arrUrl[count($arrUrl)-1]))
                            {
                               
                                $formData['freferermemberid'] = $arrUrl[count($arrUrl)-1];
                                $rs = new Core_LotteMember($formData['freferermemberid']);
                                if($rs->id==0)
                                    $formData['freferermemberid']= '';
                           
                            }
                            else
                                $formData['freferermemberid'] = '0';
                            
                            $content = $this->insertmember($formData, '1' ,'1');
                            
                            if($content[1]=='ok')
                            {
                                $code = Core_LotteCode::getLotteCodes(array('flmid'=>$content[0]), '', '');
                                $gender = $_POST['fgender'] == '1' ? 'anh' : 'chị' ;
                                $this->sendEmail($this->registry->conf['rooturl'].'giare/'.$content[0], $_POST['femail'], $_POST['ffullname'],$code[0]->code,$gender);
                            }
                            if($content[1]=='ok' && $formData['freferermemberid']!='0')
                            {
                                
                                // lay thong tin nguoi gioi thieu : A
                                $Mymember     = new Core_LotteMember($formData['freferermemberid']);
                                
                                // lấy thông tin người dc gioi thieu : B
                                $membertoRefer= $Mymember->getLotteMembers(array('fcmnd'=>$formData['fcmnd']), '', '');
                                
                                if(!empty($membertoRefer) && $Mymember->id!='0')
                                {
                                    
                                     // dem A co dc code tu viec gioi thieu B chua
                                     $MymemberRefer = Core_LotteCode::getLotteCodes(array('freferer'=>$content[0]), '', '', '', true);
                                     
                                    //ko co insert code
                                     if($MymemberRefer=="0")
                                        $this->insertcode($membertoRefer[0], '3' , $formData['freferermemberid'] ,'0');
                                }
                               
                            }
                            
                       }
                       else
                       {
                            foreach ($this->error as $key=>$value) {
                                $err[] = $value;
                            }
                            $content[] = json_encode($err);
                            $content[] = 'err';
                       }
                       echo json_encode($content);
                    break;
                    
                case 'getlistmember':
                        $page                     = $curPage = (int)($_POST['page'])>0?(int)($_POST['page']):1;
                        $limit                    = ($page-1)*$this->recordPerPage.','.$this->recordPerPage;
                        $member                   = Core_LotteMember::getLotteMembers(array(), '', '' , $limit);
                        $total                    = Core_LotteMember::getLotteMembers(array(), '', '' , $limit,true);
                        if(!empty($member))
                        {
                            foreach ($member as $k => $v)
                            {
                                  $code = Core_LotteCode::getLotteCodes(array('flmid'=>$v->id), '', '');  
                                  if(!empty($code))
                                  {
                                      $member[$k]->link = $v->id;
                                  }
                                  else
                                      $member[$k]->link = '';
                                  
                                  
                                  $email = explode("@", $member[$k]->email);
                                  $member[$k]->phone = $this->invisilbeStr($member[$k]->phone);
                                  $member[$k]->cmnd = $this->invisilbeStr($member[$k]->cmnd);
                                  $member[$k]->email = $email[0];
                            }
                        
                        }
                        $this->registry->smarty->assign(array(	
                                                            'formData'          => $formData,
                                                            'countmember'       => count($member),
                                                            'paginateurl'       => '#', 
                                                            'member'            => $member,
                                                            'paginateurl'       => '#', 
                                                            'totalPage'         => ceil($total/$this->recordPerPage),
                                                            'curPage'           => $curPage,

                          ));
                    
                       echo $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'getlistmember.tpl'); 
                    break;
                    
                case 'getcode':
                        $id                     = (int)($_POST['id'])>0?(int)($_POST['id']):'';
                        if($id!='')
                        {
                            $code = Core_LotteCode::getLotteCodes(array('flmid'=>$id), '', '');  
                            foreach ($code as $key => $value) {
                                $err[] = $value->code; 
                            }
                            echo json_encode($err);
                        }
                        
                    break;
                
                case 'expoint':
                    
                    if($this->validexpoint($_POST))
                    {
                       $cmp = false;
                       $strcmp = 1;
                       set_time_limit(0);
                       $this->begindate = Helper::strtotimedmy($this->begindate);
                       $this->enddate   = Helper::strtotimedmy($this->enddate);
                       // kt don hang da doi diem chua
                       $checkcodeexist = Core_LotteCode::getLotteCodes(array('ferpsaleorderid'=>trim($_POST['fsid'])), '', '','',true);
                       
                       // chua co
                       if($checkcodeexist=='0')
                       {
                            $online         = false;
                            $flag           = false;
                            $demcode        = 0;
                            $diem           = '500000';
                            $Mysaleorder    = new Core_Saleorder();
                            // lay thong tin khach bang email
                            $customer       = Core_Customer::DM_WEB_CUSTOMER_SEARCH($_POST['fuser']);

                            
                            // co thong tin khach hang
                            if($customer!='')
                            {
                                // lay lich su mua hang cua khach hang
                                $saleorder   = $Mysaleorder->getSaleorderDmAndTgddById($customer[0]->CUSTOMERID);
                                
                              
                                // co lich su
                                if($saleorder!='')
                                {
                                    
                                    foreach ($saleorder as $key=>$value) {


                                        $saleid = trim($value['SALEORDERID']);
                                        
                                        // so sanh tim kiem don hang khach hang nhap vao voi lich su
                                        
                                        if($strcmp)
                                            $strcmp = strcmp($saleid,$_POST['fsid'] );
                                        // = 0 co ton tai don hang ,  ko co ton tai 
                                        if($strcmp==0)
                                        {
                                            // == 5 la kho xuat tu online
                                            if($value['ORIGINATESTOREID']=="5")
                                            {
                                                 $online = true;
                                                 $bdate = Helper::strtotimedmy($this->formattime($this->formatdatecrm($value['CREATEDATE'])));
                                                 // check thoi gian voi chuong trinh
                                                 if($bdate>=$this->begindate && $bdate <= $this->enddate)
                                                 {
                                                     
                                                     // check tong tien co > 500k ko
                                                     if($value['TOTALAMOUNT']>=$diem)
                                                     {

                                                         $demcode = ceil($value['TOTALAMOUNT']/$diem)-1;
                                                         $flag = true;
                                                         $formData['saleid'] = $value['SALEORDERID'];
                                                     }
                                                     else
                                                     {
                                                         $this->errorcontrol[] = 'sidgr';
                                                         $this->error[] = 'Giá trị đơn hàng không đủ';
                                                     }
                                                         
                                                 }
                                                 else
                                                 {
                                                      $this->errorcontrol[] = 'sidgr';
                                                      $this->error[] = 'Đơn hàng mua từ 26/4-24/5';
                                                 }

                                            }
                                        
                                                


                                        }
                                       
                                    }
                                    // kt ton tai don hang
                                    if($strcmp!=0)
                                    {
                                        $flag = false;
                                        $this->errorcontrol[] = 'sidgr';
                                        $this->error[] = 'Sai thông tin đơn hàng';
                                    }
                                    
                                    // kt don hàng online
                                    if(!$online)
                                    {
                                        $this->errorcontrol[] = 'sidgr';
                                        $this->error[] = 'Đơn hàng phải được mua online';
                                    }
                                    
                                    // có ton tai don hang && gia tri du
                                    if($flag && $demcode>=0)
                                    {
                                         $member = Core_LotteMember::getLotteMembers(array('fcmnd'=>$_POST['fcmnd']), '', '', '');
                                         $formData['ffullname']        = $customer['FULLNAME'];
                                         $formData['femail']           = $customer['MAINEMAIL'];
                                         $formData['fgender']          = $customer['GENDER'];
                                         $formData['fphone']           = $customer['MAINMOBILE'];
                                         $formData['fcmnd']            = $_POST['fcmnd'];
                                         $formData['fregion']          = $customer['CITYID'];
                                         $formData['freferermemberid'] = '';
                                         
                                         if(!empty($member))
                                         {
                                             for ($index = 0; $index < $demcode; $index++) {
                
                                                $rs = $this->insertcode($member[0],'5','0', $formData['saleid']);

                                                if($rs && $index == ($demcode-1))
                                                {
                                                    $code = Core_LotteCode::getLotteCodes(array('ferpsaleorderid'=>$formData['saleid']), '', '');
                                                    
                                                }
                                            }
                                            $content[] = $member[0]->id;
                                            $content[] = 'ok';
                                         }
                                         else
                                         {
                                             $this->errorcontrol[] = 'cmndgr';
                                             $this->error[] = 'Vui lòng đăng kí tham gia <br> &nbsp&nbsp&nbsp&nbsp , trước khi đổi mã đơn hàng';
                                         }
                                    }
                                }
                                else
                                {
                                     $this->errorcontrol[] = 'sidgr';
                                     $this->error[] = 'Bạn chưa mua hàng trên dienmay.com';
                                }   
                            }
                            else
                            {
                                $this->errorcontrol[] = 'usergr';
                                $this->error[] = 'Email(sdt) không tồn tại'; 
                            } 
                       }
                       else
                       {
                           $this->errorcontrol[] = 'sidgr';
                           $this->error[] = 'Đơn hàng đã được đổi điểm'; 
                       }
                           
                       
                       
                     
                       
                       
                       
                    }
                    
                    if(!empty($this->error))
                    {
                         foreach ($this->error as $key=>$value) {
                              $err[] = $value;
                              $con[] = $this->errorcontrol[$key];
                         }
                         $content[] = json_encode($err);
                         $content[] = 'err';   
                         $content[] = json_encode($con);
                    }
                    echo json_encode($content);
                    break;
                
                case 'checkcode':
                        if($this->validcheck($_POST))
                        {
                            // khach tham gia
                            $member                   = Core_LotteMember::getLotteMembers(array('fphone'=>$_POST['fphone'],'fcmnd'=>$_POST['fcmnd']), '', '');
                            if(!empty($member))
                            {
                                $formData['link'] = $this->registry->conf['rooturl'].'giare/'.$member[0]->id;
                                // code cua khach tham gia
                                $Mycode = Core_LotteCode::getLotteCodes(array('flmid'=>$member[0]->id), '', '');
                                $typename = Core_LotteCode::getTypename();
                                if(!empty($Mycode))
                                {
                                     foreach ($Mycode as $key => $value) {
                                        if($value->type == '3')
                                        {
                                            // lấy referer
                                            $refer = Core_LotteMember::getLotteMembers(array('fid'=>$value->referer), '' , '');
                                            if(!empty($refer))
                                            {
                                                 $Mycode[$key]->typename .= $typename[$value->type].' cho '.$refer[0]->fullname.' ( ID là '.$refer[0]->id." )" ;
                                            }
                                           
                                        }
                                        else{
                                            
                                            $Mycode[$key]->typename = $typename[$value->type];
                                        }
                                        $Mycode[$key]->timecreate = date('d/m/Y h:i:s A',$Mycode[$key]->datecreated);
                                     }
                                }
                                $this->registry->smarty->assign(array(	
                                                                'formData'          => $formData,
                                                                'countmember'       => count($member),
                                                                'member'            => $member,
                                                                'mycode'            => $Mycode,
                                                                'paginateurl'       => '#', 

                              ));

                                $content[] = json_encode($this->registry->smarty->fetch($this->registry->smartyControllerContainer.'listcheckcode.tpl')); 
                                $content[] = 'ok';
                            }
                            else
                            {
                                $this->error[] = 'Sai thông tin';
                            }
                            
                        }
                        if(!empty($this->error))
                        {
                             foreach ($this->error as $key=>$value) {
                                 $err[] = $value;
                             }
                             $content[] = json_encode($err);
                             $content[] = 'err';
                        }
                    echo json_encode($content);
                    break;
                    
                default:
                    break;
            }
        }
    }
    public function popupAction()
    {
        
        $id = isset($_GET['uid']) ? $_GET['uid'] : '' ;
        $action = isset($_GET['ac']) ? $_GET['ac'] : '' ;
        if($id!='')
        {
            $member = new Core_LotteMember($id);
            $code   = Core_LotteCode::getLotteCodes(array('flmid'=>$id), '', '');
            
            if($action!="1")
            {
                foreach ($code as $key => $value) {
                    if($value->erpsaleorderid=='0')
                        unset($code[$key]);
                }
            }
            
            $formData['id'] = $id;
            $formData['msg'] = ' đổi điểm ';
            if($action=='1')
                $formData['msg'] = ' đăng kí ';
            $this->registry->smarty->assign(array(	
                                      'formData'          =>$formData,
                                       'code'             =>$code,
              ));
            $content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'popupsucess.tpl');
            $this->registry->smarty->assign( array(
                                        'contents' => $content,
            ));
            echo $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
        }
    }

   
    private function insertmember($formData,$type,$countfor)
    {
       
        $content                        = array();
        $myLotteMember                  = new Core_LotteMember();
        $myLotteMember->urlcode         = str_replace('/', '', $this->registry->conf['rooturl']).$formData['url'];
        $myLotteMember->leid            = '1';
        $myLotteMember->fullname        = $formData['ffullname'];
        $myLotteMember->email           = $formData['femail'];
        $myLotteMember->gender          = $formData['fgender'];
        $myLotteMember->phone           = $formData['fphone'];
        $myLotteMember->cmnd            = trim($formData['fcmnd']);
        $myLotteMember->region          = $formData['fregion'];
        $myLotteMember->referermemberid = $formData['freferermemberid'];
        $myLotteMember->id              = $myLotteMember->addData();
        if ($myLotteMember->id > 0) 
        {
            $this->registry->me->writelog('lottemember_add', $myLotteMember->id, array());
            for ($index = 0; $index < $countfor; $index++) {
                
                $rs = $this->insertcode($myLotteMember,$type, '0' , isset($formData['saleid']) ? $formData['saleid'] : 0 );
                
                if($rs && $index == ($countfor-1))
                {
                    $content[] = $myLotteMember->id;
                    $content[] = 'ok';
                }
            }
        }
        else 
        {
                $this->error[] = 'Có lỗi khi insert';
                foreach ($this->error as $key=>$value) {
                    $err[] = $value;
                }

                $content[] = json_encode($err);
                $content[] = 'err';
        }
        return $content;
    }
    
    private function insertcode($obj,$type,$referid='0',$saleid='0')
    {
        $myLotteCode = new Core_LotteCode();
        
        $code = Core_LotteCode::maxCode();
        $myLotteCode->lmid           = $type==3 ? $referid : $obj->id ;
        $myLotteCode->leid           = '1';
        $myLotteCode->type           = $type;
        $myLotteCode->code           = $code == NULL ? '1000001' : $code + 1  ;
        $myLotteCode->erpsaleorderid = $saleid;
        $myLotteCode->referer        = $type==3 ? $obj->id : '0' ;
        
        $rs = $myLotteCode->addData();
        if ($rs) 
        {
                $success[] = 'ok';
                $this->registry->me->writelog('lottecode_add', $myLotteCode->id, array());
                return true;
        }
        
    }
    private function validcheck($arr)
    {
        $pass = true;
        if(in_array('', $arr))
        {
            $this->error[1] = 'Thông tin không đầy đủ';
            return $pass = false;
            exit();
        }
        
        if(count($arr)!=3)
        {
            $this->error[2] = 'Lỗi !!!!!';
            return $pass = false;
            exit();
        }
        
       
        // check phone 
       if(isset($arr['fphone']))
        {
            
            if(!$this->checkint($arr['fphone'],array('10','11'),'Số điện thoại ','1'))
                $pass = false ;
            
        }
        else
        {
            $pass = false ;
            $this->error[] = 'Thiếu thông tin điện thoại';
        }
        
        
         // check cmnd
        if(isset($arr['fcmnd']))
        {
            if(!$this->checkint($arr['fcmnd'],array('9'),'Số chứng minh ',"3"))
                    $pass = false;
                
        }
        else
             $this->error[] = 'Thiếu thông tin';
        
        return $pass;
    }
    
    private function validexpoint($arr)
    {
        $pass = true;
        if(in_array('', $arr))
        {
            $this->error[1] = 'Thông tin không đầy đủ';
            $this->errorcontrol[] = 'requiredgr';
            return $pass = false;
            exit();
        }
        
        if(count($arr)!=5)
        {
            $this->error[2] = 'Lỗi !!!!!';
            $this->errorcontrol[] = 'requiredgr';
            return $pass = false;
            exit();
        }
       
        
        
        
         // check cmnd
        if(isset($arr['fcmnd']))
        {
            if(!$this->checkint($arr['fcmnd'],array('9'),'Số chứng minh ',"3"))
            {
                $this->errorcontrol[] = 'cmndgr';
                $pass = false;
            }
        }
        else
        {
            $this->errorcontrol[] = 'cmndgr';
            $this->error[] = 'Thiếu thông tin cmnd';
        }
             
        
        return $pass;
    }

    private function validregister($arr)
    {
        
        $pass = true;
        if(in_array('', $arr))
        {
            $this->error[1] = 'Thông tin không đầy đủ';
            return $pass = false;
            exit();
        }
        
        if(count($arr)!=9)
        {
            $this->error[2] = 'Lỗi !!!!!';
            return $pass = false;
            exit();
        }
        
        // check cmnd
        if(isset($arr['fcmnd']))
        {
            if($this->checkint($arr['fcmnd'],array('9'),'Số chứng minh ',"3"))
            {
                $rs = Core_LotteMember::getLotteMembers(array('fcmnd'=>$arr['fcmnd']), '', '');
                if(!empty($rs))
                {
                    $pass = false;
                    $this->error[] = 'Số chứng minh đã đăng kí';
                }
            }
            else
            {
                $pass = false;
            }
                
        }
        else{
            $pass = false;
            $this->error[] = 'Thiếu thông tin';
        }
            
            
            
        
        
        // check dien thoai
        if(isset($arr['fphone']))
        {
            
            if(!$this->checkint($arr['fphone'],array('10','11'),'Số điện thoại ','1'))
                $pass = false ;
            
        }
        else
        {
            $pass = false ;
            $this->error[] = 'Thiếu thông tin';
        }
             
        
        
        
        // check email
        if(isset($arr['femail']))
        {
            if(!Helper::ValidatedEmail($arr['femail']))
            {
                $pass = false ;
                $this->error[] = 'Email không hợp lệ';
            }
                 
        }
        else
        {
            $pass = false ;
            $this->error[] = 'Thiếu thông tin';
        }
             
        
        
        // check region
        if(!isset($arr['fregion']))
        {
            $pass = false ;
            $this->error[] = 'Thiếu thông tin';
        }
            
        
        // check anwser
        if(isset($arr['fanswer']))
        {
            if($arr['fanswer'] != '1900.1883' && $arr['fanswer'] != '1080' && $arr['fanswer'] != '19001090')
            {
                $pass = false ;
                $this->error[] = 'Câu hỏi trắc nghiệm không đúng';
            }
               
        }
        else
        {
            $pass = false ;
            $this->error[] = 'Thiếu thông tin';
        }
         
        return $pass;
    }
    
    private function checkint($data,$lengh = array(),$strerr = '',$control)
    {
            $pass    = false;
            
            if (ctype_digit(trim($data))) {
                $pass    = true;
            }
            else
            {
                if($control=='1')
                    $this->error[] = $strerr.'không hợp lệ';
                if($control=='3')
                {
                    $rs2  = preg_match('/[a-zA-Z][0-9]/is', $data);
                    if(!$rs2)
                        $this->error[] = $strerr.'không hợp lệ';
                    else 
                        $pass = true;
                    
                }
                   
            }
            
           
                
            return $pass;
    }
    public function sendEmail($url, $mail , $name , $code , $gender)
    {
            $formData['link']   = $url;
            $formData['gender'] = $gender;
            
            $arrname = explode(' ', $name);
            if(count($arrname)>1)
                $formData['name'] = $arrname[count($arrname)-1];
            else
                $formData['name'] = $name;
            $formData['code'] = $code;
            $this->registry->smarty->assign(array('formData'=>$formData));
            $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'giare/registry.tpl');
            $this->registry->smarty->assign(array('formData'=>$formData));
            $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
            $sender       = new SendMail($this->registry, $mail, 'dienmay.com', 'Đăng kí thành công chương trình mua hàng giá 1000đ tại dienmay.com', $mailContents, $this->registry->setting['mail']['fromEmail'], $this->registry->setting['mail']['fromName']);
            if ($sender->Send()) {
                    return true;
            }
            else {
                    return false;
            }
    }
    private function getBanner($fazid = 1, $ftype = Core_Ads::TYPE_BANNER)
    {
        $formData['fazid']     = $fazid; //Dienmay Homepage
        $formData['ftype']     = $ftype;
        $formData['fisactive'] = 1;
        return Core_Ads::getAdss($formData, '', 'DESC',6);
    }
    public function popupshareAction()
    {
        if(!empty($_GET['id']))
        {
            $this->registry->smarty->assign(array('formurl' => $_GET['id'],
                                                   
                                                ));
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'popupmuangay.tpl');
        
            $this->registry->smarty->assign(array('contents' => $contents,
                                                   'pageTitle' => $this->registry->lang['controller']['muanhanh'],
                                                ));
                                                
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
        }
        else
        {
            ?><script>parent.location.reload();</script><?php
        }        
    }

    public function checkvalidationAction()
    {
        if(!empty($_POST['email1']) && !empty($_POST['email2']) && Helper::ValidatedEmail($_POST['email1']) && Helper::ValidatedEmail($_POST['email2']) && $_POST['email2'] != $_POST['email1'])
        {
            $checkValidationemail = Core_GiareGioithieu::getGiareGioithieus(array('fcheckallemail'=> $_POST['email1']),'','','', true);
            if($checkValidationemail > 0)
            {
                echo json_encode(array('error' => 1, 'message' => 'Email 1 đã được sử dụng. Vui lòng giới thiệu email khác'));
            }
            else
            {
                $checkValidationemail = Core_GiareGioithieu::getGiareGioithieus(array('fcheckallemail'=> $_POST['email2']),'','','', true);
                if($checkValidationemail > 0)
                {
                    echo json_encode(array('error' => 1, 'message' => 'Email 2 đã được sử dụng. Vui lòng giới thiệu email khác'));
                }
                else{
                    $giaregioithieu = new Core_GiareGioithieu();
                    $giaregioithieu->email1 = $_POST['email1'];
                    $giaregioithieu->email2 = $_POST['email2'];
                    $giaregioithieu->uid = $this->registry->me->id;
                    $giaregioithieu->ip = Helper::getIpAddress(true);
                    $giaregioithieu->datecreated = time();
                    $_SESSION['sesgiaregioithieuid'] = $giaregioithieu->addData();
                    echo json_encode(array('success' => 1));
                }
            }
        }
        elseif(isset($_POST['email1']) && isset($_POST['email2'])) {
            echo json_encode(array('error' => 1, 'message' => 'Vui lòng nhập đủ 2 mail hợp lệ để giới thiệu bạn bè'));
        }
        elseif(!empty($_POST['likefb']))
        {
            if(empty($_COOKIE['giarecheckfacebooklike']))
            {
                $myCookieExpire = time() + 90 * 24 * 3600 ;    //90 days
                $data = time();
                setcookie('giarecheckfacebooklike' , $data , $myCookieExpire , '/');
                $_COOKIE['giarecheckfacebooklike'] = $data;
            }
        }
        elseif(!empty($_POST['likegplus']))
        {
            if(empty($_COOKIE['giarecheckgooglepluslike']))
            {
                $myCookieExpire = time() + 90 * 24 * 3600 ;    //90 days
                $data = time();
                setcookie('giarecheckgooglepluslike' , $data , $myCookieExpire , '/');
                $_COOKIE['giarecheckgooglepluslike'] = $data;
            }
        }
    }

    public function getPage($pageid)
    {
        if(!is_array($pageid))
        {
          $formData['fid'] = $pageid;
        }
        else
        {
          $formData['fidarr'] = $pageid;
        }
        $page = Core_Page::getPages($formData,'','');
        return $page;
    }
    public function getOrder($type)
    {   
        
        /*$formData['fpidarr'] = explode(',', $productid->listproduct);
        $orderDetails = Core_OrdersDetail::getOrdersDetails($formData,'','');
        $orderid = array();
        foreach ($orderDetails as $key => $orderDetail) {
          # code...
            $orderid[] = $orderDetail->oid;
        }*/
        $formData['fpromotionid'] = $type;
        $order = Core_Orders::getOrderss($formData,'','','',true);
        return $order;
    }
    public function getProductOrder()
    {
        $formData['fpromotionid'] = 34;
        $formData['forderbytimesegment'] = array();
        $startime = strtotime(date('y-m-d',time())." 00:00:00");
        $endtime = strtotime(date('y-m-d',time())." 23:59:59");
        $formData['forderbytimesegment'][0] = $startime;
        $formData['forderbytimesegment'][1] = $endtime;
        $data = array();
        $orders = Core_Orders::getOrderss($formData,'','DESC','0,10');
        $orderid =array();
        foreach ($orders as $key => $order) {
            $formData['foid'] = $order->id;
            //echodebug($order->datecreated);
            $orderDetails = Core_OrdersDetail::getOrdersDetails($formData,'','');
            unset($formData['foid']);
            if(!empty($orderDetails)){
              //echodebug($orderDetails);
              $data['timeago'] = $this->time_ago($order->datecreated);
              foreach ($orderDetails as $orderDetail) {
                $formData['fid'] = $orderDetail->pid;
                $products = Core_Product::getProducts($formData,'','');
                if(!empty($products)){
                    $data['name'] = $products[0]->name;
                    $data['time'] = $order->datecreated;
                    $data['path'] = $products[0]->getProductPath();
                    $result[] = $data;
                }
                unset($products);
                unset($formData['fid']);
              }
            }
        }
        return $result;
    }
    public function getBannerBySlugZone($slug = '', $fazid, $ftype = Core_Ads::TYPE_BANNER)
    {
        $formData['fisactive'] = 1;
        $listAds = array();
        $formData['fslug'] = $slug;
        $formData['fazid'] = $fazid; 
        $formData['ftype'] = $ftype;
        $listAdsSlug = Core_AdsSlug::getAdsSlugs($formData,'','DESC');
        if(count($listAdsSlug) > 0)
        {
            $arrID = array();
            foreach($listAdsSlug as $lAdsSlug)
            {
                $arrID[] = $lAdsSlug->aid;
            }
            $formData['fidarr'] = $arrID;
            $listAds = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
        }
        return $listAds;
    }

    function time_ago($tm, $rcs = 0) {
      $cur_tm = time(); 
      $dif = $cur_tm - $tm;
      $pds = array('giây','" ','giờ','ngày','tuần','tháng','năm','thế kỷ');
      $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);

      for ($v = count($lngh) - 1; ($v >= 0) && (($no = $dif / $lngh[$v]) <= 1); $v--);
        if ($v < 0)
          $v = 0;
      $_tm = $cur_tm - ($dif % $lngh[$v]);

      $no = floor($no);

      //if ($no != 1)
        //$pds[$v] .= 's';
      $x = "$no $pds[$v] ";

      if (($rcs > 0) && ($v >= 1))
        $x .= time_ago($_tm, $rcs - 1);

      return $x;
    }
   
 
}

