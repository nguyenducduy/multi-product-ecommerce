<?php
class Controller_Cron_giare Extends Controller_Cron_Base 
{
    public $demSql   = 0;
    public $demtrung = 0;
    public function indexAction($action ='')
    {

            set_time_limit(0);
            $date_system    = time();
            $date_systemadd = strtotime('-1 day');
            // lấy code trong ngay hom nay
            $new_code    = Core_LotteCode::getLotteCodes(array(), '', '');
            $arrSend     = array();
            $dem         = 0 ;
            $demcodemoi  = array();
            if(!empty($new_code))
            {
                
                foreach ($new_code as $key => $value) {
                    
                    if(isset($arrSend[$value->lmid]) && $arrSend[$value->lmid]!='')
                    {
                        $arrSend[$value->lmid] .= ",".$value->code;  
                    }
                    else
                    {
                        $arrSend[$value->lmid] = $value->code; 
                    }
                    
                    if($value->datecreated <= $date_system && $value->datecreated >= $date_systemadd)
                        $demcodemoi[$value->lmid][] = $value->code;
                }
                foreach ($demcodemoi as $k => $v) {
                    
                    $codemoi[$k] = count($v);
                }
                foreach ($arrSend as $k => $v) {
                    $mem = Core_LotteMember::getLotteMembers(array('fid'=>$k), '', '');
                    if(!empty($mem))
                    {
                        if(isset($codemoi[$k]) && $codemoi[$k]>0)
                        {
                            $gender = $mem[0]->gender =='1' ? 'anh' : 'chị' ;
                            $success = $this->sendEmail($mem[0]->email, $mem[0]->fullname, $v,$codemoi[$k],$gender);
                            sleep(5);
                            if($success)
                            {
                                $dem = $dem +1;
                                $demcodemoi = 0;
                            }
                        }
                       
                            
                    }
                        
                }
            }
            echo 'Đã send : '.$dem.' khách hàng ';

    }
    public function sendEmail($mail , $name , $code , $dem,$gender)
    {
            $this->registry->conf['rooturl'] =  $this->registry->conf['rooturl']=='background.dienmay.com' ? 'dienmay.com' :  $this->registry->conf['rooturl']  ;
            $formData['fname'] = $name;
            $formData['gender'] = $gender;
            $arrname = explode(' ', $name);
            if(count($arrname)>1)
                $formData['name'] = $arrname[count($arrname)-1];
            else
                $formData['name'] = $name;
            $formData['code'] = $code;
            $formData['dem'] = $dem;
            $formData['date'] = date('d/m/Y');
            $this->registry->smarty->assign(array('formData'=>$formData));
            $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'giare/new_code.tpl');
            $this->registry->smarty->assign(array('formData'=>$formData));
            $this->registry->smarty->fetch($this->registry->smartyControllerContainerRoot.'index_popup.tpl');
            $sender       = new SendMail($this->registry, $mail, 'dienmay.com', $gender." ".$formData['name'].' vừa nhận '.$dem.' mã dự thưởng chương trình Mua điện máy giá 1000đ', $mailContents, $this->registry->setting['mail']['fromEmail'], $this->registry->setting['mail']['fromName']);
            if ($sender->Send()) {
                    return true;
            }
            else {
                    return false;
            }
    }
}

		