<?php

Class Controller_Stat_ProfileCustomer Extends Controller_Stat_Base
{
	public function indexAction()
	{
		$formData = $error = array();
		
		list($dateRangeStart, $dateRangeEnd) = $this->getDateRange();
		
		///////////
		//for testing Chart only
		$myChart = new Core_Chart_Customer();
		$datestart = $dateRangeStart;
		$dateend = $dateRangeEnd;
		
		$chartData = $myChart->getData($dateRangeStart, $dateRangeEnd);
		
		$this->registry->smarty->assign(array('formData' => $formData,
												'dateRangeStart' => $dateRangeStart,
												'dateRangeEnd' => $dateRangeEnd,
												'myChart' => $myChart,
												'chartData' => $chartData,
												'error'	=> $error,	
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'profile',
												'pageTitle'	=> 'Website Statistics :: Customer',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
    	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
}


