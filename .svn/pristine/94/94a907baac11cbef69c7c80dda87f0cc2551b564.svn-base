<?php
class Controller_Site_NewsReviewThumb Extends Controller_Site_Base
{
	public function indexAction()
	{

	}
	public function addajaxAction()
	{
		$objectid = (int)$_POST['nid'];
		$reviewid = (int)$_POST['rid'];

		if($objectid > 0)
		{
			$myNewsReviewThumb = new Core_NewsReviewThumb();


			$myNewsReviewThumb->robjectid = $objectid;
			$myNewsReviewThumb->rid = $reviewid;
			$myNewsReviewThumb->uid = $this->registry->me->id;
			$myNewsReviewThumb->value = 1;
			$myNewsReviewThumb->ipaddress = Helper::getIpAddress(true);

            if($myNewsReviewThumb->addData() > 0)
            {
            	$this->registry->me->writelog('newsreviewthumb_add', $myNewsReviewThumb->id, array());
            	echo 'done';
            }
		}
	}
}