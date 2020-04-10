<?php

Class Controller_Stat_Report Extends Controller_Stat_Base
{
	public function indexAction()
	{
		
	}	
	
	
	public function __call($method, $arg)
	{
		//remove 'Action' in this method
		$subcontroller = strtolower(str_replace('Action', '', $method));
		
		$path = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'report' . DIRECTORY_SEPARATOR . 'class.'.$subcontroller.'.php';
		if(file_exists($path))
		{
			$controllerClassName = 'Controller_Stat_Report_' . $subcontroller;
			
			
			//Init subcontroller object
			$mySubController = new $controllerClassName($this->registry);
			
			
			//Update template path for curent sub contrller
			$mySubController->registry->smartyControllerContainer .= $subcontroller . DIRECTORY_SEPARATOR;
			
			
			$subAction = 'index';
			//get subaction of sub controller
			$argList = $this->registry->router->getArg();
			
			//get Action base on URL
			if(strlen($argList) > 0)
			{
				$argList = explode('/', $argList);
				
				if(count($argList) > 0)
				{
					$firstArg = array_shift($argList);
					if(strlen($firstArg) > 0)
					{
						$subAction = $firstArg;
					}
				}
				
			}
			
			
			//Append to call valid Action function in subcontroller
			$subAction .= 'Action';
			$mySubController->$subAction();
			
		}
		else
			$this->notfound();
		
	}	

	public function getAllWeekInYear()
	{
		$weekOfYearList = array();

		$currentyear = date('Y' , time());

		for ($week_number = 1 ; $week_number < 53; $week_number++) 
		{ 
			if($week_number < 10)
			{
			   $week_number = "0".$week_number;
			}

			for($day=0; $day<=6; $day++)
			{
				if($day == 0)					
				{
					$weekOfYearList[$week_number]['from'] = date('d/m/Y', strtotime($currentyear."W".$week_number.$day));
				}

				if($day == 6)					
				{
					$weekOfYearList[$week_number]['to'] = date('d/m/Y', strtotime($currentyear."W".$week_number.$day));
				}			    	
			}
		}

		return $weekOfYearList;
	}
}


