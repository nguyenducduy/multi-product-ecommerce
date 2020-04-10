<?php

Class Controller_Cms_ReviewQueue Extends Controller_Cms_Base
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
						$myReview = new Core_ReviewQueue($id);
						
						if($myReview->id > 0)
						{
							//tien hanh xoa
							if($myReview->delete())
							{
								$deletedItems[] = $myReview->id;
								$this->registry->me->writelog('reviewqueue_delete', $myReview->id, array('text' => substr(strip_tags($myReview->text), 100), 'userid' => $myReview->uid, 'bookid' => $myReview->bid));
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
		
				
		$paginateUrl = $this->registry->conf['rooturl_admin'].'reviewqueue/index/';      
		
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
		$total = Core_ReviewQueue::getReviews($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$reviews = Core_ReviewQueue::getReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage, false, true);
		
		
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
		
		$this->registry->smarty->assign(array(	'menu'		=> 'reviewqueuelist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	public function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myReview = new Core_ReviewQueue($id);
		
			
		if($myReview->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myReview->delete())
				{
					$redirectMsg = $this->registry->lang['controller']['succDelete'];
					
					$this->registry->me->writelog('reviewqueue_delete', $myReview->id, array('text' => substr(strip_tags($myReview->text), 100), 'userid' => $myReview->uid, 'bookid' => $myReview->bid));
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
	
	/**
	* Dong y day la 1 review hop le, chuyen sang table review
	* 
	*/
	function acceptAction()
	{
		$id = (int)$this->registry->router->getArg('id');
        $myReview = new Core_ReviewQueue($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myReview->id > 0)
        {
        	$myAcceptReview = new Core_Review();
        	$myAcceptReview->uid = $myReview->uid;
        	$myAcceptReview->bid = $myReview->bid;
        	$myAcceptReview->text = $myReview->text;
        	$myAcceptReview->ipaddress = $myReview->ipaddress;
			$myAcceptReview->parentid = $myReview->parentid;
        	$myAcceptReview->datecreated = $myReview->datecreated;
        	if($myAcceptReview->addData())
        	{
        		//them thanh cong, tien hanh cap nhat thong tin
        		//create feed
				$myFeedReviewAdd = new Core_Backend_Feed_ReviewAdd();
				$myFeedReviewAdd->uid = $myReview->uid;
				$myFeedReviewAdd->myBook = $myReview->book;
				$myFeedReviewAdd->reviewText = Helper::truncateperiod($myReview->text, 200);
				$myFeedReviewAdd->addData();
				
				//select correct REP REVIEW TYPE
				$reviewLength = mb_strlen($myReview->text);
				$repType = 0;
				if($reviewLength >= 1600)
					$repType = Core_Rep::TYPE_REVIEW_LONG_ADD;
				elseif($reviewLength >= 800)
					$repType = Core_Rep::TYPE_REVIEW_MEDIUM_ADD;
				elseif($reviewLength >= 400)
					$repType = Core_Rep::TYPE_REVIEW_SHORT_ADD;
				elseif($reviewLength >= 100)
					$repType = Core_Rep::TYPE_REVIEW_TINY_ADD;
				
				//xu ly them REP neu hop le
				if($repType > 0 && Core_Rep::canAdd($myReview->uid, $repType))
				{
					$myRep = new Core_Rep();
					$myRep->uid = $myReview->uid;
					$myRep->uidtrigger = $myReview->uid;
					$myRep->type = $repType;
					$myRep->objectid1 = $myBook->id;
					$myRep->objectid2 = $myAcceptReview->id;
					$myRep->text = substr($myReview->text, 0, 200);
					$repValue = $myRep->addData();
					if($repValue > 0)
					{
						$myReview->actor->rep += $repValue;
					}
				}
				
				//increase review counting
				$myReview->book->updateCount('review', 1);
				
				//update user-stat
				$myReview->actor->updateCounting(array('review'));
				
				//khong can update metadata o day
				//boi vi khi aadd review thi ngoai viec update metadata
				//con tao notification den nhung userid lien quan den booknay dua vao metadata lists
				//do do, su dung co che async job de vua send notification (co the co nhieu INSERT sql)
				//de process nhanh cho nay
				//viec goi notification nay duoc thiet ke rieng 1 automatic task (standalone) voi cac tham so tuong ung
				//de tu dong goi ma thoi
				$taskUrl = $this->registry->setting['site']['taskurl'] . 'index.php?c=booknotification&a=review';
				Helper::backgroundHttpPost($taskUrl, 'uid=' . $myReview->uid.'&bid=' . $myReview->book->id . '&rid=' . $myAcceptReview->id);
        		
        		//delete queue
        		$myReview->delete();
        		
        		//redirect sang review manager
        		header('location: ' . $this->registry->conf['rooturl_admin'] . '/reviewqueue');
			}
			else
			{
				$redirectMsg = 'Accept error.';
	            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
	                                                    'redirectMsg' => $redirectMsg,
	                                                    ));
	            $this->registry->smarty->display('redirect.tpl');
			}
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
	function acceptajaxAction()
	{
		$success = 0;
		$message = '';
		
		
		$id = (int)$this->registry->router->getArg('id');
        $myReview = new Core_ReviewQueue($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myReview->id > 0)
        {
        	$myAcceptReview = new Core_Review();
        	$myAcceptReview->uid = $myReview->uid;
        	$myAcceptReview->bid = $myReview->bid;
        	$myAcceptReview->text = $myReview->text;
        	$myAcceptReview->ipaddress = $myReview->ipaddress;
			$myAcceptReview->parentid = $myReview->parentid;
        	$myAcceptReview->datecreated = $myReview->datecreated;
        	if($myAcceptReview->addData())
        	{
        		//them thanh cong, tien hanh cap nhat thong tin
        		//create feed
				$myFeedReviewAdd = new Core_Backend_Feed_ReviewAdd();
				$myFeedReviewAdd->uid = $myReview->uid;
				$myFeedReviewAdd->myBook = $myReview->book;
				$myFeedReviewAdd->reviewText = Helper::truncateperiod($myReview->text, 200);
				$myFeedReviewAdd->addData();
				
				//select correct REP REVIEW TYPE
				$reviewLength = mb_strlen($myReview->text);
				$repType = 0;
				if($reviewLength >= 1600)
					$repType = Core_Rep::TYPE_REVIEW_LONG_ADD;
				elseif($reviewLength >= 800)
					$repType = Core_Rep::TYPE_REVIEW_MEDIUM_ADD;
				elseif($reviewLength >= 400)
					$repType = Core_Rep::TYPE_REVIEW_SHORT_ADD;
				elseif($reviewLength >= 100)
					$repType = Core_Rep::TYPE_REVIEW_TINY_ADD;
				
				//xu ly them REP neu hop le
				if($repType > 0 && Core_Rep::canAdd($myReview->uid, $repType))
				{
					$myRep = new Core_Rep();
					$myRep->uid = $myReview->uid;
					$myRep->uidtrigger = $myReview->uid;
					$myRep->type = $repType;
					$myRep->objectid1 = $myBook->id;
					$myRep->objectid2 = $myAcceptReview->id;
					$myRep->text = substr($myReview->text, 0, 200);
					$repValue = $myRep->addData();
					if($repValue > 0)
					{
						$myReview->actor->rep += $repValue;
					}
				}
				
				//increase review counting
				$myReview->book->updateCount('review', 1);
				
				//update user-stat
				$myReview->actor->updateCounting(array('review'));
				
				//khong can update metadata o day
				//boi vi khi aadd review thi ngoai viec update metadata
				//con tao notification den nhung userid lien quan den booknay dua vao metadata lists
				//do do, su dung co che async job de vua send notification (co the co nhieu INSERT sql)
				//de process nhanh cho nay
				//viec goi notification nay duoc thiet ke rieng 1 automatic task (standalone) voi cac tham so tuong ung
				//de tu dong goi ma thoi
				$taskUrl = $this->registry->setting['site']['taskurl'] . 'index.php?c=booknotification&a=review';
				Helper::backgroundHttpPost($taskUrl, 'uid=' . $myReview->uid.'&bid=' . $myReview->book->id . '&rid=' . $myAcceptReview->id);
        		
        		//delete queue
        		$myReview->delete();
        		
				$success = 1;
				$message = 'Accept successfully!';
			}
			else
			{
				$message = 'Accept Error';
			}
		}
		else
        {
			$message = $this->registry->lang['controller']['errNotFound'];
        }

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
    
    function editAction()
    {                         
        $id = (int)$this->registry->router->getArg('id');
        $myReview = new Core_ReviewQueue($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myReview->id > 0)
        {
            $error         = array();
	        $success     = array();
	        $contents     = '';
	        $formData     = array();
	        
	        $formData['ftext'] = $myReview->text;
	        $_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
	        
	        if(!empty($_POST['fsubmit']))
	        {
	            if($_SESSION['reviewEditToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);
	                
	                if($this->editActionValidator($formData, $error))
	                {
                       	$myReview->text = $formData['ftext'];
	                    						
	                    if($myReview->updateData())
	                    {
	                       $success[] = $this->registry->lang['controller']['succEdit'];
	                       $this->registry->me->writelog('reviewqueue_edit', $myReview->id, array('userid' => $myReview->uid, 'bookid' => $myReview->bid));
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
	                                                'menu'        => 'reviewqueuelist',
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

	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
		
	
    private function editActionValidator($formData, &$error)
    {
        $pass = true;
      
      	
                
        return $pass;
    }
    
    	
	
	
}
