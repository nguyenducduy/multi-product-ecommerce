<?php

Class Core_GoogleAnalytics_Browser extends Core_GoogleAnalytics
{
	public $type = 'pie';
	public $title = 'Browser';
	
	//Base on type of this Chart, we will get the correct data from the Data storage
	public function getData($profileid, $datestart, $dateend)
	{
		
		$data = array();
		
		$this->analytics->requestReportData($profileid,array('browser'), array('visitors'), array('-visitors'), null, $datestart, $dateend);
		
		foreach($this->analytics->getResults() as $result)
		{
			$data[$result->getBrowser()] = $result->getVisitors();
		}
		
		arsort($data);
		
		//limit to 7 items on pie chart
		$finalData = array();
		$i = 0;
		foreach($data as $label => $value)
		{
			if($i < 9)
				$finalData[$label] = $value;
			else
				$finalData['Others'] += $value;
			
			$i++;
		}
		
		return $finalData;
		
		
	}
	
}