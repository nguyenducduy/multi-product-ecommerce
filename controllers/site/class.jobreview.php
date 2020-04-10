<?php
Class Controller_Site_JobReview Extends Controller_Site_Base
{
	public function indexAction()
	{
		
	}
	
	function indexajaxAction()
	{
	
		//get productid
		$fjid = (int)$_POST['id'];		
		$order = strtolower(trim((string)$_POST['order']));
		$sortby = '';
	
		switch($order)
		{
			case 'lasted' : $sortby = 'datecreated';
			break;
	
			case 'like' : $sortby = 'countthumbup';
			break;
		}
	
		//get product's comment
		$jobreviewList = array();
	
		$totalreview =  $productreviewroots = Core_JobReview::getJobReviews(array('fobjectid' => $fjid,
				'fstatus' => Core_JobReview::STATUS_ENABLE) , 'id' , 'ASC' , '' ,true);
	
		$productreviewroots = Core_JobReview::getJobReviews(array('fobjectid' => $fjid ,
				'fparent' => true,
				'fstatus' => Core_JobReview::STATUS_ENABLE) , $sortby , 'DESC'); //get root comment
	
		if(count($productreviewroots) > 0)
		{
			foreach ($productreviewroots as $rootreview)
			{
				$review = Core_JobReview::getFullReview($rootreview);
				$jobreviewList[] = $review;
			}
		}
	
		$job = new Core_Job($fjid);
		///////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////
	
		$this->registry->smarty->assign(array('jobreviewList'		=> $jobreviewList,
				'fjid' => $fjid,
				'total' => $totalreview,
				'job' => $job,
				'order' => $order,));
	
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');
	
	}
	
	public function replyAction()
	{
		$objectid = (int)$this->registry->router->getArg('id');
		$parentreviewid = (int)$this->registry->router->getArg('parentid');
	
		if($objectid > 0 && $parentreviewid > 0)
		{
			$this->registry->smarty->assign(array( 'objectid' => $objectid,
					'parentreviewid' => $parentreviewid,
			));
	
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reply.tpl');
	
			$this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
					'contents'  => $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
		}
	}
	
	public function successAction()
	{
		$success = array();
	
		$success[] = 'Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn';
		$this->registry->smarty->assign(array('success' => $success
		));
	
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'success.tpl');
	
		$this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
				'contents'  => $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
	}
	
	public function addajaxAction()
	{
		$name = (string)$_POST['name'];
		$email = (string)$_POST['email'];
		$content = (string)$_POST['content'];
		$objectid = (int)$_POST['id'];
		$parentid = (int)$_POST['parent'];
	
		//kiem tra xem user da dang nhap hay chua ?
		if($this->registry->me->id > 0)
		{
			$name = $this->registry->me->fullname;
			$email = $this->registry->me->email;
		}
	
		//kiem tra email , name , content,id
		if($objectid ==0)
		{
			echo '5'; // khong co productid
			exit();
		}
	
		if(strlen($name) == 0)
		{
			echo '1'; //khong co name
			exit();
		}
	
		if(strlen($email) == 0)
		{
			echo '2'; //khong co email
			exit();
		}
		else
		{
			if(!Helper::ValidatedEmail($email))
			{
				echo '3'; //email khong hop le
				exit();
			}
		}
	
		if(strlen($content) == 0)
		{
			echo '4'; // khong co content
			exit();
		}
	
		//them mot review moi cho san pham
		$myJobReview = new Core_JobReview();
	
		$myJobReview->uid = $this->registry->me->id;
		$myJobReview->objectid = $objectid;
		$myJobReview->fullname = $name;
		$myJobReview->email = $email;
		$myJobReview->text = Helper::plaintext($content);
		$myJobReview->ipaddress = Helper::getIpAddress(true);
		$myJobReview->status = Core_JobReview::STATUS_PENDING;
		$myJobReview->parentid = $parentid;
	
		if($parentid > 0)
		{
			$productreviewparent = new Core_JobReview($parentid);
			$productreviewparent->countreply++;
			$productreviewparent->updateData();
		}
	
		if($myJobReview->addData() > 0)
		{
			echo '6'; //them review thanh cong
		}
		else
		{
			echo '7'; //them review khong thanh cong
		}
	}
	
	public function addinfoAction()
	{
		$objectid = (int)$this->registry->router->getArg('pid');
		$parentid = (int)$this->registry->router->getArg('parentid');
		$content =  (string)$this->registry->router->getArg('content');
	
		$this->registry->smarty->assign(array( 'fpid' => $objectid,
				'fparentid' => $parentid,
				'content' => $content,
		));
	
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'info.tpl');
	
		$this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
				'contents'  => $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
	}
}