<?php

Class Controller_Task_Giare Extends Controller_Task_Base 
{
	
	public function indexAction()
	{
        $id = (int)(isset($_POST['id'])?$_POST['id']:0);//ID of giaregioithieu calss
        $fullname = (string)(isset($_POST['fullname'])?$_POST['fullname']:'');
        
        if($fullname == '') return 'No Fullname';
        
        $myGiareGioithieu = new Core_GiareGioithieu($id);
        if($myGiareGioithieu->id <=0 ) return 'No Gia Re Gioithieu';
        
        $email1 = (string)$myGiareGioithieu->email1;
        $email2 = (string)$myGiareGioithieu->email2;
        
        if($email1 == '' && $email2 == '') return 'NoEmail1 AND 2';
        
        $tennguoigui = base64_decode($fullname);
        
        $tennguoinhan1 = explode('@', $email1);
        if(count($tennguoinhan1)==2) $tennguoinhan1 = $tennguoinhan1[0];
        
        $tennguoinhan2 = explode('@', $email2);
        if(count($tennguoinhan2)==2) $tennguoinhan2 = $tennguoinhan2[0];
        
        $this->registry->smarty->assign(array(
                                                'tennguoigui' => $tennguoigui,
                                                'tennguoinhan' => $tennguoinhan1,
                                                ));
        $mailcontent = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'giare/emailgioithieu.tpl');
        $this->sendmail('Tham gia chương trình mua sản phẩm giá 1,000đ tại dienmay.com',$mailcontent, $email1, $tennguoinhan1);
        
        $this->registry->smarty->assign(array(
                                                'tennguoigui' => $tennguoigui,
                                                'tennguoinhan' => $tennguoinhan2,
                                                ));
        $mailcontent = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'giare/emailgioithieu.tpl');
        $this->sendmail('Tham gia chương trình mua sản phẩm giá 1,000đ tại dienmay.com',$mailcontent, $email2, $tennguoinhan2);
	}
    
    private function sendmail($subject,$mailcontent, $to, $toname = '')
    {
        $sender = new SendMail($this->registry,
                                    $to,
                                    $toname,
                                    $subject,
                                    $mailcontent,
                                    $this->registry->setting['mail']['fromEmail'],
                                    $this->registry->setting['mail']['fromName']
                                    );
        //echodebug($mailcontent);return true;
        if($sender->Send()) return true;
        return false;
    }
	
}

