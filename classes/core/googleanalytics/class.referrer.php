<?php

Class Core_GoogleAnalytics_Referrer extends Core_GoogleAnalytics
{
	public $type = 'pie';
	public $title = 'Referrer';
	
	//Base on type of this Chart, we will get the correct data from the Data storage
	public function getData($profileid, $datestart, $dateend)
	{
		
		$data = array();
		$this->analytics->requestReportData($profileid,array('referralPath', 'source', 'keyword', 'medium'), array('visitors'), array('-visitors'), null, $datestart, $dateend);
		
		foreach($this->analytics->getResults() as $result)
		{
			if($result->getMedium() == 'organic')
				$medium = ' <span class=\'label label-success\'>Organic</span>';
			elseif($result->getMedium() == 'referral')
				$medium = ' <span class=\'label label-info\'>Referral</span>';
			elseif($result->getMedium() == '(none)')
				$medium = '';
			else
				$medium = ' <span class=\'label\'>'.$result->getMedium().'</span>';
			$key = $result->getSource() . $result->getReferralPath() . $medium;
			$data[$key] = $result->getVisitors();
		}
		
		arsort($data);
		
		//limit to 10 items on pie chart
		$finalData = array();
		$i = 0;
		foreach($data as $label => $value)
		{
			if($i < 100)
				$finalData[$label] = $value;
			else
				$finalData['Others'] += $value;
			
			$i++;
		}
		
		return $finalData;
		
		
	}
	
}