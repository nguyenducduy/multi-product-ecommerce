<?php

Abstract Class Controller_Stat_Base Extends Controller_Admin_Base 
{
	/**
	 * Get the date range for current chart will show
	 * Call with: list($dateRangeStart, $dateRangeEnd) = $this->getDateRange();
	 */
	public function getDateRange()
	{
		if(isset($_GET['dateRangeStart']) && isset($_GET['dateRangeStart']))
		{
			$dateRangeStart = $_SESSION['dateRangeStart'] = (int)$_GET['dateRangeStart'];
			$dateRangeEnd = $_SESSION['dateRangeEnd'] = (int)$_GET['dateRangeEnd'];
		}
		elseif(isset($_SESSION['dateRangeStart']) && isset($_SESSION['dateRangeStart']))
		{
			$dateRangeStart = $_SESSION['dateRangeStart'];
			$dateRangeEnd = $_SESSION['dateRangeEnd'];
		}
		else
		{
			//default Date Range stat
			$dateRangeEnd = strtotime('-1 day');
			$dateRangeStart = strtotime('-30 days', $dateRangeEnd);
		}
		
		
		$info = array($dateRangeStart, $dateRangeEnd); 
		
		return $info;
	}
}
