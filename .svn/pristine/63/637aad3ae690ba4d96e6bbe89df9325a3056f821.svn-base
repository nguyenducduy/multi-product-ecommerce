<?php

Class Controller_Stat_GoogleAnalytics Extends Controller_Stat_Base
{
	
	public function indexAction()
	{
		$formData = $error = $chartData = array();
		list($dateRangeStart, $dateRangeEnd) = $this->getDateRange();
		
		$chartTitle = '';
		$chartData = array();
		$chartNames = array();
		
		$chartNames = explode(',', $_GET['name']);
		$chartTitle = '';
		$chartData = array();
		$chartType = '';
		
		if(count($chartNames) > 0)
		{
			for($i = 0; $i < count($chartNames); $i++)
			{
				$classname = Core_GoogleAnalytics::getClassFromName($chartNames[$i]);
				if($classname != '')
				{
					$myChart = new $classname($this->registry->setting['googleanalytics']['username'], $this->registry->setting['googleanalytics']['password']);
					
					
					$data = Core_GoogleAnalytics::cacheGetData($classname, $dateRangeStart, $dateRangeEnd);
					if($data)
					{
						$chartData[$myChart->title] = $data;
					}
					else
					{
						$myChart->init();
						$chartData[$myChart->title] = $myChart->getData($this->registry->setting['googleanalytics']['profileid'], date('Y-m-d', $dateRangeStart), date('Y-m-d', $dateRangeEnd));
						Core_GoogleAnalytics::cacheSetData($classname, $dateRangeStart, $dateRangeEnd, $chartData[$myChart->title]);
					}

					if($myChart->type == 'pie')
						$chartType = 'pie';
					else
						$chartType = 'bar';

					if($i > 0)
						$chartTitle .= ', ';
					$chartTitle .= $myChart->title;
				}
				else
					$error[] = 'We are working hard on this feature. Try again later.';
			}//end for
		}
		else
			$error[] = 'Chart Not Found.';
			
		//////
		//output
		$this->registry->smarty->assign(array('formData' => $formData,
												'dateRangeStart' => $dateRangeStart,
												'dateRangeEnd' => $dateRangeEnd,
												'chartTitle' => $chartTitle,
												'chartData' => $chartData,
												'chartNames' => $chartNames,
												'error'	=> $error,	
												'chartType' => $chartType
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'googleanalytics',
												'pageTitle'	=> 'Google Analytics :: ' . $chartTitle,
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			
		
	}
	
	
}


