<?php

Class Core_GoogleAnalytics_PagePath extends Core_GoogleAnalytics
{
	public $type = 'pie';
	public $title = 'Page Path';
	
	//Base on type of this Chart, we will get the correct data from the Data storage
	public function getData($profileid, $datestart, $dateend)
	{
		
		$data = array();
		$this->analytics->requestReportData($profileid,array('pagePath'), array('visitors'), array('-visitors'), null, $datestart, $dateend);
		
		foreach($this->analytics->getResults() as $result)
		{
			$data[$result->getPagePath()] = $result->getVisitors();
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