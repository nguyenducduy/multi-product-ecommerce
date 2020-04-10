<?php
class Controller_Site_PageReviewThumb Extends Controller_Site_Base
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
			$myPageReviewThumb = new Core_PageReviewThumb();


			$myPageReviewThumb->robjectid = $objectid;
			$myPageReviewThumb->rid = $reviewid;
			$myPageReviewThumb->uid = $this->registry->me->id;
			$myPageReviewThumb->value = 1;
			$myPageReviewThumb->ipaddress = Helper::getIpAddress(true);

            if($myPageReviewThumb->addData() > 0)
            {
            	$this->registry->me->writelog('pagereviewthumb_add', $myPageReviewThumb->id, array());
            	echo 'done';
            }
		}
	}
}