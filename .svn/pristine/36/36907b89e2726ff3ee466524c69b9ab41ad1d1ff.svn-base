<?php

Class Core_GoogleAnalytics_AvgTimeOnPage extends Core_GoogleAnalytics
{
	public $title = 'Average Time On Page';
	
	//Base on type of this Chart, we will get the correct data from the Data storage
	public function getData($profileid, $datestart, $dateend)
	{
		$data = array();
		$this->analytics->requestReportData($profileid,array('date'),array('avgTimeOnPage'), null, null, $datestart, $dateend);
		
		foreach($this->analytics->getResults() as $result)
		{
			preg_match('/(\d{4})(\d{2})(\d{2})/', $result->getDate(), $match);
			$date = mktime(0, 0, 1, $match[2], $match[3], $match[1]);
			$data[$date] = $result->getAvgTimeOnPage();
		}
		
		ksort($data);
		return $data;
		
		
	}
	
}