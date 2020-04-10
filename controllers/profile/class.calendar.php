<?php

Class Controller_Profile_Calendar Extends Controller_Profile_Base 
{
	function indexAction() 
	{
		//get current Month
		$curDate = getDate();
		
		// What is the first day of the month in question?
		$selectedMonth = $curDate['mon'];
		$selectedYear = $curDate['year'];
		
		$this->registry->smarty->assign(array('selectedMonth' => $selectedMonth,
												'selectedYear' => $selectedYear,
											));
											
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
	} 
	
	
	public function indexajaxAction()
	{
		$requestMonth = $_GET['month'];
		
		
		//Get Current Month
		if($requestMonth == '')
		{
			$selectedDate = getDate();	
		}
		else
		{
			$firstDayOfMonth = $_GET['firstdayofmonth'];
			if($requestMonth == 'previous')
			{
				$firstDayOfMonth = strtotime('-1 month', $firstDayOfMonth);
			}
			elseif($requestMonth == 'next')
			{
				$firstDayOfMonth = strtotime('+1 month', $firstDayOfMonth);
			}
			else //specified month/year (in format: MM/YYYY)
			{
				$monthYearGroup = explode('/', $requestMonth);
				$firstDayOfMonth = mktime(0,0,0, $monthYearGroup[0], 1, $monthYearGroup[1]);
			}
			
			$selectedDate = getDate($firstDayOfMonth);
		}
		
		// What is the first day of the month in question?
		$selectedMonth = $selectedDate['mon'];
		$selectedYear = $selectedDate['year'];
		
		
		//First day of selected month
		$firstDayOfMonth = mktime(0,0,0,$selectedMonth,1,$selectedYear);
		$totalDayOfMonth = date('t', $firstDayOfMonth);
		$firstDayOfMonthDetail = getDate($firstDayOfMonth);
		$firstDayWeekdayIndex = $firstDayOfMonthDetail['wday'];
		
		//Last day of selected month
		$lastDayOfMonth = mktime(0,0,0, $selectedMonth, $totalDayOfMonth, $selectedYear);
		$lastDayOfMonthDetail = getDate($lastDayOfMonth);
		$lastDayWeekdayIndex = $lastDayOfMonthDetail['wday'];
		
		//building Day of Month array
		$monthDayList = array();
		for($i = 1; $i <= $totalDayOfMonth; $i++)
		{
			$timestamp = mktime(0,0,0, $selectedMonth, $i, $selectedYear);
			$monthDayList[] = array('timestamp' => $timestamp, 'eventlist' => array(), 'type' => 'current', 'today' => date('dmY') == date('dmY', $timestamp) ? 1 : 0);
		}
		
		//The order is: Mon(1),Tue(2),Wed(3),Thu(4),Fri(5),Sat(6),Sun(0)
		//Base on the weekday of first day of selected month,
		//we will calculate the previous month day to prepend for full in first week
		//to month always starts at Monday
		$prependingCount = $firstDayWeekdayIndex > 0 ? $firstDayWeekdayIndex - 1 : 6;
		for($i = 1; $i <= $prependingCount; $i++)
			array_unshift($monthDayList, array('timestamp' => strtotime('-'.$i.' day'.($i > 1 ? 's' : ''), $firstDayOfMonth), 'eventlist' => array(), 'type' => 'prev', 'today' => 0));
		
		//Base on the weekday of first day of selected month,
		//we will calculate the after month day to prepend for full in first week
		//to month always end at Sunday
		$appendCount = $lastDayWeekdayIndex > 0 ? 7 - $lastDayWeekdayIndex : 0;
		for($i = 1; $i <= $appendCount; $i++)
			array_push($monthDayList, array('timestamp' => strtotime('+'.$i.' day'.($i > 1 ? 's' : ''), $lastDayOfMonth), 'eventlist' => array(), 'type' => 'next', 'today' => 0));
		
		//Tim tat ca Event trong thang hien tai va trong Calendar hien tai
		$eventList = Core_Backend_CalendarEvent::getCalendarEvents(array('fuid' => $this->registry->me->id), 'id', 'DESC', 1000);
		
		//attach event to day in month
		for($i = 0; $i < count($monthDayList); $i++)
		{
			//echo date('d/m/Y', $monthDayList[$i]['timestamp']) . '<br />';
		}
		
		//detect to show today month link
		if(date('mY') == date('mY', $firstDayOfMonth))
			$showTodayMonthLink = 0;
		else
			$showTodayMonthLink = 1;
		
		$this->registry->smarty->assign(array('monthDayList' => $monthDayList,
												'selectedMonth' => $selectedMonth,
												'selectedYear' => $selectedYear,
												'firstDayOfMonth' => $firstDayOfMonth,
												'showTodayMonthLink' => $showTodayMonthLink,
											));
											
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');
	}
	
	
	
	 
}
