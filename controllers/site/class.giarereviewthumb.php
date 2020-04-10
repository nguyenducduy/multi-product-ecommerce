<?php
class Controller_Site_GiareReviewThumb extends Controller_Site_Base
{
	public function indexAction()
	{

	}
	public function addajaxAction()
	{
		$objectid = (int)$_POST['pid'];
		$reviewid = (int)$_POST['rid'];

		if($reviewid > 0)
		{
			$mygiaretReviewThumb = new Core_GiareReviewThumb();


			$mygiaretReviewThumb->robjectid = $objectid;
			$mygiaretReviewThumb->rid = $reviewid;
			$mygiaretReviewThumb->uid = $this->registry->me->id;
			$mygiaretReviewThumb->value = 1;
			$mygiaretReviewThumb->ipaddress = Helper::getIpAddress(true);

            if($mygiaretReviewThumb->addData() > 0)
            {
            	$this->registry->me->writelog('productreviewthumb_add', $mygiaretReviewThumb->id, array());
            	echo 'done';
            }
		}
	}
}