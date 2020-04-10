<?php

Class Controller_Stat_Chart Extends Controller_Stat_Base
{
	public $recordPerPage = 20;
	
	public function indexAction()
	{
		
		$formData = $error = $chartData = array();
		list($dateRangeStart, $dateRangeEnd) = $this->getDateRange();
		
		$chartNames = explode(',', $_GET['name']);
		$chartTitle = '';
		$chartData = array();
		$customchart = '';
		
		if(count($chartNames) > 0)
		{
			for($i = 0; $i < count($chartNames); $i++)
			{
				$classname = Core_Chart_Base::getClassFromName($chartNames[$i]);
				if($classname != '')
				{
					$myChart = new $classname();
					$chartData[$myChart->title] = $myChart->getData($dateRangeStart, $dateRangeEnd);

					if($i > 0)
						$chartTitle .= ', ';
					$chartTitle .= $myChart->title;
				}
				else
				{
					switch($chartNames[$i])
					{
						case 'sale': $customchart = 'sale'; $chartTitle = 'Sale'; break;
						default: $error[] = 'We are working hard on this feature. Try again later.'; break;
					}
					
				}
					
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
												'customchart' => $customchart,
												'error'	=> $error,	
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'analytics',
												'pageTitle'	=> 'Statistics :: ' . $chartTitle,
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	
}


