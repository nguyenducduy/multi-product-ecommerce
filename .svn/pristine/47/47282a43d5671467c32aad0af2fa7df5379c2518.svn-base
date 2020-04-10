<?php
class Controller_Site_StuffReviewThumb Extends Controller_Site_Base
{
	public function indexAction()
	{

	}
	public function addajaxAction()
	{
		$objectid = (int)$_POST['sid'];
		$reviewid = (int)$_POST['rid'];

		if($objectid > 0)
		{
			$myStuffReviewThumb = new Core_StuffReviewThumb();


			$myStuffReviewThumb->robjectid = $objectid;
			$myStuffReviewThumb->rid = $reviewid;
			$myStuffReviewThumb->uid = $this->registry->me->id;
			$myStuffReviewThumb->value = 1;
			$myStuffReviewThumb->ipaddress = Helper::getIpAddress(true);

            if($myStuffReviewThumb->addData() > 0)
            {
            	$this->registry->me->writelog('stuffreviewthumb_add', $myStuffReviewThumb->id, array());
            	echo 'done';
            }
		}
	}
}