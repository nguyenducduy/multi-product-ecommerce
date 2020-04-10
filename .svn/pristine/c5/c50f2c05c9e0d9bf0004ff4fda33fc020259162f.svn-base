<?php

Class Controller_Cms_Review Extends Controller_Cms_Base
{
	public $recordPerPage = 40;
	
	public function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		
		$_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		$idFilter 		= (int)($this->registry->router->getArg('id'));
		$bookIdFilter 		= (int)($this->registry->router->getArg('bookid'));
		$userIdFilter 		= (int)($this->registry->router->getArg('userid'));
		$keywordFilter 	= $this->registry->router->getArg('keyword'); 
		$searchKeywordIn= $this->registry->router->getArg('searchin');  
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
			if(!isset($_POST['fbulkid']))
			{
				$warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
			}
			else
			{
				$formData['fbulkid'] = $_POST['fbulkid'];
				
				//check for delete 
				if($_POST['fbulkaction'] == 'delete')
				{
					$delArr = $_POST['fbulkid'];
					$deletedItems = array();
					$cannotDeletedItems = array();
					foreach($delArr as $id)
					{
						$myReview = new Core_Review($id);
						
						if($myReview->id > 0)
						{
							//tien hanh xoa
							if($myReview->delete())
							{
								$deletedItems[] = $myReview->id;
								$this->registry->me->writelog('review_delete', $myReview->id, array('text' => substr(strip_tags($myReview->text), 100), 'userid' => $myReview->uid, 'bookid' => $myReview->bid));
							}
							else
								$cannotDeletedItems[] = $myReview->id;
						}
						else
							$cannotDeletedItems[] = $myReview->id;
					}
					
					if(count($deletedItems) > 0)
						$success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);
					
					if(count($cannotDeletedItems) > 0)
						$error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
				}
				else
				{
					//bulk action not select, show error
					$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
				}
			}
		}
		
				
		$paginateUrl = $this->registry->conf['rooturl_admin'].'review/index/';      
		
		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
		if($bookIdFilter > 0)
		{
			$paginateUrl .= 'bookid/'.$bookIdFilter . '/';
			$formData['fbookid'] = $bookIdFilter;
			$formData['search'] = 'bookid';
		}
		
		if($userIdFilter > 0)
		{
			$paginateUrl .= 'userid/'.$userIdFilter . '/';
			$formData['fuserid'] = $userIdFilter;
			$formData['search'] = 'userid';
		}
		
		
		if(strlen($keywordFilter) > 0)
		{
			
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';
			
			if($searchKeywordIn == 'text')
			{
				$paginateUrl .= 'searchin/text/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
		
		//tim tong so
		$total = Core_Review::getReviews($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$reviews = Core_Review::getReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage, false, true);
		
		for($i = 0; $i < count($reviews); $i++)
		{
			$reviews[$i]->charactercount = mb_strlen($reviews[$i]->text);
		}
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'reviews' 		=> $reviews,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl, 
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'reviewlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	public function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myReview = new Core_Review($id);
		
			
		if($myReview->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myReview->delete())
				{
					$redirectMsg = $this->registry->lang['controller']['succDelete'];
					
					$this->registry->me->writelog('review_delete', $myReview->id, array('text' => substr(strip_tags($myReview->text), 100), 'userid' => $myReview->uid, 'bookid' => $myReview->bid));
				}
				else
				{
					$redirectMsg = $this->registry->lang['controller']['errDelete'];
				}
			}
			else
				$redirectMsg = $this->registry->lang['default']['errFormTokenInvalid'];   
			
			
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}
		
		$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												'redirectMsg' => $redirectMsg,
												));
		$this->registry->smarty->display('redirect.tpl');
	}
	
	
    
    function editAction()
    {                         
        $id = (int)$this->registry->router->getArg('id');
        $myReview = new Core_Review($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myReview->id > 0)
        {
            $error         = array();
	        $success     = array();
	        $contents     = '';
	        $formData     = array();
	        
	        $formData['ftext'] = $myReview->text;
	        $formData['fxuid'] = $myReview->xuid;
	        $_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
	        
	        if(!empty($_POST['fsubmit']))
	        {
	            if($_SESSION['reviewEditToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);
	                
	                if($this->editActionValidator($formData, $error))
	                {
                       	$myReview->text = $formData['ftext'];
                       	$myReview->xuid = $formData['fxuid'];
	                    						
	                    if($myReview->updateData())
	                    {
	                       $success[] = $this->registry->lang['controller']['succEdit'];
	                       $this->registry->me->writelog('review_edit', $myReview->id, array('userid' => $myReview->uid, 'bookid' => $myReview->bid));
	                    }                       
	                    else
	                    {
	                        $error[] = $this->registry->lang['controller']['errEdit'];    
	                    }
	                }
	            }
	        }
	        $_SESSION['reviewEditToken']=Helper::getSecurityToken();//Tao token moi  
	        $this->registry->smarty->assign(array(   'formData'     => $formData, 
            										'myReview'	=> $myReview,
	                                                'redirectUrl'=> $redirectUrl,
	                                                'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                'error'        => $error,
	                                                'success'    => $success,
	                                                
	                                                ));
	        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
	        $this->registry->smarty->assign(array(
	                                                'menu'        => 'reviewlist',
	                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'],
	                                                'contents'             => $contents));
	        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
            
        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                    'redirectMsg' => $redirectMsg,
                                                    ));
            $this->registry->smarty->display('redirect.tpl');
        }
    } 

	/**
	* Dong y day la 1 review hop le, chuyen sang table review
	* 
	*/
	function createxuajaxAction()
	{
		$success = 0;
		$message = '';
		
		
		$id = (int)$this->registry->router->getArg('id');
        $myReview = new Core_Review($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myReview->id > 0)
        {
        	if($myReview->xuid > 0)
			{
				$message = 'This review had already add xu.';
			}
			else
			{
				//kiem tra xem da add xu cho user review nay cho book nay chua
				$reviewcount = Core_Review::getReviews(array('fuserid' => $myReview->uid, 'fbookid' => $myReview->bid, 'fhasxu' => 1), '', '', '', true);
				if($reviewcount > 0)
					$message = 'This User had create xu bonus for this review on this book. So, can not add more xu for review in this book.';
				else
				{
					//everything ok, just add xu
					$myUser = new Core_User($myReview->uid);
					$myUser->xu = Core_Xu::getUserTotalXu($myReview->uid);
					
					$myXu = new Core_Xu();
					$myXu->uid = $myUser->id;
					$myXu->uidtrigger = 0;	//system
					$myXu->type = Core_Xu::TYPE_REVIEW_BONUS;
					$myXu->status = Core_Xu::STATUS_OK;
					$myXu->xubefore = $myUser->xu;
					$myXu->xu = $this->registry->setting['review']['xubonus'];
					$myXu->invoiceid = 'REVIEW' . $myReview->id;
					$reviewtext = Helper::mentionMetaRemove($myReview->text);
					$myXu->text = 'Bonus review: ' . Helper::truncateperiod(Helper::plaintext($reviewtext), 100);
					if($myXu->addData())
					{
						$myReview->xuid = $myXu->id;
						if($myReview->updateData())
						{
							$myUser->xu += $myXu->xu;
							$myUser->updateXu();
							
							//create notification
							$myNotificationReviewBonusXu = new Core_Backend_Notification_ReviewBonusXu();
							$myNotificationReviewBonusXu->uid = 2;
							$myNotificationReviewBonusXu->uidreceive = $myReview->uid;
							$myNotificationReviewBonusXu->reviewid = $myReview->id;
							$myNotificationReviewBonusXu->xuid = $myXu->id;
							$myNotificationReviewBonusXu->xuvalue = $myXu->xu;
							if($myNotificationReviewBonusXu->addData())
							{
								//increase notification count for receiver
								Core_User::notificationIncrease('notification', array($myNotificationReviewBonusXu->uidreceive));
							}
							
							$success = 1;
							$message = 'Xu bonus create successfully!';
						}
						else
						{
							//unknown error, delete xu
							$myXu->delete();
							$message = 'Unknown error while adding bonus xu review. Try again.';
						}
					}
					else
					{
						$message = 'Error while adding XU';
					}
				}
			}
		}
		else
        {
			$message = $this->registry->lang['controller']['errNotFound'];
        }

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}

	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
		
	
    private function editActionValidator($formData, &$error)
    {
        $pass = true;
      
      	
                
        return $pass;
    }
    
    	
	
	
}
