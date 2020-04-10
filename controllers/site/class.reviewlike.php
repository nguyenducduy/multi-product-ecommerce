<?php

Class Controller_Site_ReviewLike Extends Controller_Site_Base 
{
	function indexAction() 
	{
		$error = array();
		
		$reviewId = (int)$_GET['id'];
		$myReview = new Core_Review($reviewId);
		if($myReview->id > 0)
		{
			//lay cac like user
			//tim tong so record
			$formData = array('freviewid' => $myReview->id);
			$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
			$total = Core_ReviewLike::getReviewLikes($formData, '', '', '', true, false);
			$totalPage = ceil($total/$this->registry->setting['reviewlike']['recordPerPage']);
			$curPage = $page;
			$paginateUrl = $this->registry->conf['rooturl'].'reviewlike/' . $reviewId . '/';
			
			$reviewlikes = Core_ReviewLike::getReviewLikes($formData, '', '', (($page - 1)*$this->registry->setting['reviewlike']['recordPerPage']).','.$this->registry->setting['reviewlike']['recordPerPage'], false, true);
			
			$this->registry->smarty->assign(array('reviewlikes' => $reviewlikes,
												'formData'		=> $formData,
												'paginateurl' 	=> $paginateUrl, 
												'paginatesuffix' 	=> $paginateSuffix, 
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage
												));
			
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errReviewnotfound'];
		}
		
		$this->registry->smarty->assign(array(	'error' 	=> $error,
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 

		$this->registry->smarty->assign(array('contents' => $contents,
											));

		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot.'index_shadowbox.tpl');
	}
	
	
	
	/**
	* Them 1 like cho review
	* 
	*/
	function addajaxAction()
	{
		$moreMessage = '';
		$error = array();
		$formData = $_POST;
		
		$reviewId = (int)$_POST['reviewid'];
		$myReview = new Core_Review($reviewId);
		$myBook = Core_Book::cacheGet($myReview->bid);
		
		$formData['fid'] = $myReview->id;
		
		if($myReview->id > 0 && $myReview->canLike())
		{
			if($this->addajaxValidator($formData, $error))
			{
				//create review like
				$myReviewLike = new Core_ReviewLike();
				$myReviewLike->rid = $reviewId;
				$myReviewLike->uid = $this->registry->me->id;
				$myReviewLike->actor = $this->registry->me;
				
				if($myReviewLike->addData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succAdd'];		
					
					$moreMessage = '<liketext>'.$this->registry->lang['controller']['succLiketext'].'</liketext>';
					
					$_SESSION['likeSpam'] = time();
					
					
					
					//create notification cho nguoi post review
					//dieu kien: notify neu nguoi like khong phai la chu cua feed
					//va chu feed khong chon hide 
					if($myReview->actor->id != $this->registry->me->id)
					{
						$myNotificationReviewLike = new Core_Backend_Notification_ReviewLike();
						$myNotificationReviewLike->uid = $this->registry->me->id;
						$myNotificationReviewLike->uidreceive = $myReview->actor->id;
						$myNotificationReviewLike->reviewid = $myReview->id;
						$myNotificationReviewLike->reviewpath = $myReview->getReviewPath();
						$myNotificationReviewLike->summary = 'B&#236;nh lu&#7853;n cho s&#225;ch ' . $myBook->title . ' " ' . Helper::truncateperiod($myReview->text, 40, '...', ' ') ;
						if($myNotificationReviewLike->addData())
						{
							//increase notification count for receiver
							Core_User::notificationIncrease('notification', array($myNotificationReviewLike->uidreceive));
						}
					}
					
					
					//update feed info
					//neu chua nam trong likelist
					//tuc la chua comment
					//thi them vao like list
					$myReview->addToList($myReviewLike->uid, 'like');
					$myReview->numlike++;
					$myReview->updateData();
					
					//update Date last action
					$this->registry->me->updateDateLastaction();	
				}
				else
				{
					$success = 0;
					$message = $this->registry->lang['controller']['errAdd'];	
				}
			}
			else
			{
				$success = 0;
				$message = implode(', ', $error);
			}	
		}
		else
		{
			$success = 0;
			$message = $this->registry->lang['controller']['errReviewnotfound'];
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}
	
	###########################################################3
	###########################################################3
	###########################################################3 

	
	
	protected function addajaxValidator($formData, &$error)
	{
		$pass = true;
		
		//kiem tra xem user nay da like review nay chua
		$cnt = Core_ReviewLike::getReviewLikes(array('fuserid' => $this->registry->me->id, 'freviewid' => $formData['fid']), '','', '', true);
		if($cnt > 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errAlreadyLike'];
		}
		
		//check spam
		if(isset($_SESSION['likeSpam']) && $_SESSION['likeSpam'] + $this->registry->setting['reviewlike']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}
		
		return $pass;
	}
}

