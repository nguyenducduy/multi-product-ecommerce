<?php

Class Controller_Site_faq Extends Controller_Site_Base
{
	public function indexAction()
	{
		$myFaqs = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), '', '', '');

		$parentCat = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'displayorder', 'ASC', '');

        foreach($parentCat as $pcat)
        {
            $pcat->subCat = Core_Newscategory::getNewscategorys(array('fparentid' => $pcat->id), 'displayorder', 'ASC');
        }

        $newfaq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), 'id', 'DESC', '0, 5');
        $totalfaq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), 'id', 'DESC', '0, 5', true);

		$this->registry->smarty->assign(array(	
													'parentCat'		=> $parentCat,
													'myFaqs'		=> $myFaqs,
													'newfaq'		=> $newfaq,
													'totalfaq'		=> $totalfaq
                                                    ));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(
											'contents' => $contents,
                                            'pageTitle'                 => 'Hỏi và đáp'));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'indexnews.tpl');
	}

	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['faqAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);
                
                
                if($this->addActionValidator($formData, $error))
                {
                	if($this->registry->me->id > 0)
                		$formData['ffullname'] = $this->registry->me->fullname;

                    $myFaq = new Core_Faq();

					$myFaq->uid = (int)$this->registry->me->id;
					$myFaq->title = $formData['ftitle'];
					$myFaq->fullname = $formData['ffullname'];
					$myFaq->displayorder = $formData['fdisplayorder'];
					$myFaq->status = Core_Faq::STATUS_PENDING;
					
                    if($myFaq->addData())
                    {
                        $success[] = 'Chúng tôi đã nhận được câu hỏi của bạn và sẽ hồi âm cho bạn trong thời gian sớm nhất.';
                        $this->registry->me->writelog('faq_add', $myFaq->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = 'Có lỗi xảy ra trong quá trình nhập liệu.';            
                    }
                }
            }
            
		}
		
		$_SESSION['faqAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'error'			=> $error,
												'success'		=> $success
												));

		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'add.tpl');
	}

	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		if($this->registry->me->id == 0)
		{
			if($formData['ffullname'] == '')
			{
				$error[] = 'Họ tên không được để trống.';
				$pass = false;
			}
		}

		if($formData['ftitle'] == '')
		{
			$error[] = 'Nội dung không được để trống.';
			$pass = false;
		}

		if(strlen($formData['ftitle']) > 300)
		{
			$error[] = 'Nội dung không được dài quá 300 ký tự.';
			$pass = false;
		}
		
		return $pass;
	}

}
