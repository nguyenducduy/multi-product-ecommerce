<?php
class Controller_Site_ProductReviewThumb Extends Controller_Site_Base
{
	public function indexAction()
	{

	}
	public function addajaxAction()
	{
		$objectid = (int)$_POST['pid'];
		$reviewid = (int)$_POST['rid'];

		if($objectid > 0)
		{
			$myProductReviewThumb = new Core_ProductReviewThumb();

			$myProductReviewThumb->robjectid = $objectid;
			$myProductReviewThumb->rid = $reviewid;
			$myProductReviewThumb->uid = $this->registry->me->id;
			$myProductReviewThumb->value = 1;
			$myProductReviewThumb->ipaddress = Helper::getIpAddress(true);

            if($myProductReviewThumb->addData() > 0)
            {	
            	$this->registry->me->writelog('productreviewthumb_add', $myProductReviewThumb->id, array());
            	echo 'done';
            }
		}
	}
	public function addajaxmobileAction()
	{
		$objectid = (int)$_POST['pid'];
		$reviewid = (int)$_POST['rid'];

		if($objectid > 0)
		{
			$myProductReviewThumb = new Core_ProductReviewThumb();

			$myProductReviewThumb->robjectid = $objectid;
			$myProductReviewThumb->rid = $reviewid;
			$myProductReviewThumb->uid = $this->registry->me->id;
			$myProductReviewThumb->value = 1;
			$myProductReviewThumb->ipaddress = Helper::getIpAddress(true);
            if($myProductReviewThumb->addData() > 0)
            {	
            	if($_SESSION['productreviewthumb'][$reviewid] != $reviewid)
	            	$_SESSION['productreviewthumb'][$reviewid] =  $reviewid;
            	$this->registry->me->writelog('productreviewthumb_add', $myProductReviewThumb->id, array());
            	echo 'done';
            }
		}
	}
}
