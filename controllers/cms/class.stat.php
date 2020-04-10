<?php

Class Controller_Cms_Stat Extends Controller_Cms_Base
{
	public $recordPerPage = 20;
	
	public function indexAction()
	{
		$formData = $error = array();
		$formData['ftype'] = array();
		$formData['fend'] = date('d/m/Y', strtotime('-1 day'));
		$formData['fstart'] = date('d/m/Y', strtotime('-15 days'));
		$formData['fwidth'] = 800;
		$formData['fheight'] = 500;
		
		if(isset($_POST['fsubmit']))
		{
			$formData = array_merge($formData, $_POST);
			if(count($formData['ftype']) == 0)
			{
				$error[] = 'Please select a section to generate chart.';
			}
			elseif(trim($formData['fstart']) == '' || trim($formData['fend']) == '')
			{
				$error[] = 'Please select date range to view chart';
			}
			else
			{
				$tmp = explode('/', $formData['fstart']);
				$datestart = mktime(0,0,1, $tmp[1], $tmp[0], $tmp[2]);
				$tmp = explode('/', $formData['fend']);
				$dateend = mktime(0,0,1, $tmp[1], $tmp[0], $tmp[2]);
				if($datestart > $dateend)
				{
					$error[] = 'Time range is not valid. Start time must be less than End time.';
				}
				else
				{
					$imagetypeList = array();
					$param = '';
					
					if($formData['fdisplay'] == 'each')
					{
						foreach($formData['ftype'] as $type)
						{
							$imagetypeList[] = $type;
						}
					}
					elseif($formData['fdisplay'] == 'mix')
					{
						$imagetypeList[] = implode(',', $formData['ftype']);
					}
					
				}
			}
		}
		
		
		///////////
		//for testing Chart only
		$myChart = new Core_Chart_ProductView();
		$datestart = mktime(0,0,1, 1,1,2012);
		$dateend = mktime(0,0,1, 1,31,2012);
		
		$data = $myChart->getData($datestart, $dateend);
		//echodebug($data);
		//$myChart->set('name', 'Tuan');
		//echo $myChart->get('name');
		
		$this->registry->smarty->assign(array('typeList' => Core_Stat::getTypeList(),
												'formData' => $formData,
												'imagetypeList' => $imagetypeList,
												'datestart' => $datestart,
												'dateend' => $dateend,
												'error'	=> $error,	
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'statlist',
												'pageTitle'	=> 'Website Statistics',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	/**
	* Tien hanh lay du lieu va ve hinh
	* 
	* Tra ve hinh
	* 
	*/
	public function drawAction()
	{
		$error = $formData = array();$formData['ftype'] = explode(',', $_GET['type']);
		$formData['fstart'] = $_GET['start'];
		$formData['fend'] = $_GET['end'];
		$formData['fcharttype'] = $_GET['charttype'];
		$formData['fdatatype'] = $_GET['datatype'];
		$formData['fshowvalue'] = $_GET['showvalue'];
		$formData['fwidth'] = $_GET['width'];
		$formData['fheight'] = $_GET['height'];
		if($formData['fwidth'] <= 0)
			$formData['fwidth'] = 800;
		if($formData['fheight'] <= 0)
			$formData['fheight'] = 500;
		$formData['fweeklabel'] = $_GET['weeklabel'];
		
		if($this->drawValidator($formData, $error))
		{
			$typeList = Core_Stat::getTypeList();
			
			$chartTitle = '';
			
			
			//////////////////////////////////////////////////
			//get data
			if(count($formData['ftype']) == 1)
			{
				$chartTitle = $chartTitleSmall = $typeList[$formData['ftype'][0]];
			}
			else
			{
				$chartTitleList = array();
				foreach($formData['ftype'] as $typeid)
				{
					$chartTitleList[] = $typeList[$typeid];
				}
				
				$chartTitle = 'Statistics Information';
				$chartTitleSmall = implode(', ', $chartTitleList);
			}
			
			///////////////////////////////////////////////////
			// refine data
			
			////////////////////////////////////////////////////
			// addpoint
			//add abscissa
			$datePoints = array();
			$startpoint = $formData['fstart'];
			$endpoint = $formData['fend'];
			$markLabelIndex = array();
			while($startpoint <= $endpoint)
			{
				$datePoints[] = date('d/m', $startpoint);
				
				
				if($formData['fweeklabel'] != '')
				{
					$tmp = getdate($startpoint);
					if($tmp['wday'] == $formData['fweeklabel'])
					{
						$markLabelIndex[] = count($datePoints) - 1;
					}
				}
				
				$startpoint = strtotime('+1 day', $startpoint);
			}
			
			//add data
			$dataPoints = array();
			$tmp  = 0;
			foreach($formData['ftype'] as $typeid)
			{
				//doi voi moi type, tien hanh lay data 
				//trong thoi gian start/end de thong ke
				$statData = Core_Stat::getStats(array('ftype' => $typeid, 'fstartdate' => $formData['fstart'], 'fenddate' => $formData['fend']), '', '', '');
				//init data for each date in chart
				for($i = 0; $i < count($datePoints); $i++)
				{
					$dataPoints[$typeid][$datePoints[$i]] = 0;
				}
				//sum the value of each datapoints
				for($i = 0; $i < count($statData); $i++)
				{
					$datekey = date('d/m', $statData[$i]->date);
					$dataPoints[$typeid][$datekey] += $statData[$i]->value;
					$tmp += $statData[$i]->value;
				}
			} 
			
			
		}
		else
		{
			$this->drawError(implode("\n\n", $error));
		}
	}
	
	public function getWeekdayName($wday)
	{
		$name = '';
		switch($wday)
		{
			case 0: $name = 'Sunday'; break;
			case 1: $name = 'Monday'; break;
			case 2: $name = 'Tuesday'; break;
			case 3: $name = 'Wednesday'; break;
			case 4: $name = 'Thursday'; break;
			case 5: $name = 'Friday'; break;
			case 6: $name = 'Saturday'; break;
		}
		return $name;
	}
	
	
	public function drawError($errorMessage)
	{
		
		/* Include all the classes */
		include_once($this->libPath . 'class/pDraw.class.php');
		include_once($this->libPath . 'class/pImage.class.php');
		include_once($this->libPath . 'class/pData.class.php');
		
		/* Create the pChart object */
		 $myPicture = new pImage(700,500);

		 /* Draw the background */
		 $Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>0, "DashR"=>190, "DashG"=>203, "DashB"=>107);
		 $myPicture->drawFilledRectangle(0,0,700,500,$Settings);

		 /* Overlay with a gradient */
		 $Settings = array("StartR"=>152, "StartG"=>228, "StartB"=>231, "EndR"=>225, "EndG"=>250, "EndB"=>247, "Alpha"=>50);
		 $myPicture->drawGradientArea(0,0,700,500,DIRECTION_VERTICAL,$Settings);
		 $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

		 /* Add a border to the picture */
		 $myPicture->drawRectangle(0,0,699,499,array("R"=>0,"G"=>0,"B"=>0));
		 
		 /* Write the picture title */ 
		 $myPicture->setFontProperties(array("FontName"=> $this->libPath . "fonts/Silkscreen.ttf","FontSize"=>6));
		 $myPicture->drawText(10,13,"Error - Parameter is invalid",array("R"=>255,"G"=>255,"B"=>255));

		 /* Enable shadow computing */ 
		 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));

		 /* Write some text */ 
		 $myPicture->setFontProperties(array("FontName"=>$this->libPath . "fonts/advent_light.ttf","FontSize"=>30));
		 $TextSettings = array("R"=>0,"G"=>0,"B"=>0,"Angle"=>0,"FontSize"=>30, "Align" => TEXT_ALIGN_MIDDLEMIDDLE);
		 $myPicture->drawText(350,250, $errorMessage,$TextSettings);

		 /* Render the picture (choose the best way) */
		 $myPicture->autoOutput("pictures/example.drawText.png");
	}
	
	/**
	* Run collector to collect stat data of un-update date
	* 
	*/
	public function collectorAction()
	{
		set_time_limit(20);
		$currentDate = getdate();
		$curDateTimestampCheck = mktime(0,0,1, $currentDate['mon'], $currentDate['mday'],$currentDate['year']);
		$statTypeList = Core_Stat::getTypeList();
		$collectorTracking = '';
		foreach($statTypeList as $typeid => $typename)
		{
			//doi voi moi type
			//kiem tra xem stat cho ngay do/gio do da ton tai chua
			//neu chua ton tai thi tien hanh them/cap nhat(neu chua het ngay)
			$lastDate = Core_Stat::getLastStat($typeid);
			
			//chi xu ly neu chua cap nhat cho ngay > lastdate
			$collectorTracking .= '<table class="collectortracking" width="400">
										<tr style="background:#ddd;"><td colspan="5"><strong>'.$typename.'</strong></td></tr>
										<tr><td>No.</td><td>Date</td><td>Hour</td><td>Value</td><td>Result</td></tr>';
			$collectIndex = 1;
			while($curDateTimestampCheck >= $lastDate)
			{
				//neu chua co record nao
				if($lastDate == 0)
				{
					$statData = Core_Stat::collectData($typeid, 1, time(), true);
					if(count($statData) > 0)
					{
						$dateinfotmp = getdate($statData[0]);
						$lastDate = mktime(0,0,1, $dateinfotmp['mon'], $dateinfotmp['mday'], $dateinfotmp['year']);
					}
				}
				
				if($lastDate == 0)
					break;
					
				//echo date('H:i:s, d/m/Y',$lastDate);
				//echo '-';
				//echo date('H:i:s, d/m/Y',strtotime('+1 day', $lastDate));
				
				//tim trong 1 ngay (lastdate)
				$statData = Core_Stat::collectData($typeid, $lastDate, strtotime('+1 day', $lastDate), false);
				
				//print_r($statData);
				$dayinsert = $lastDate;
				$hourinsertCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
				for($i = 0; $i < count($statData); $i++)
				{
					$datestat = getdate($statData[$i]);
					if($dayinsert == 0)
						$dayinsert = mktime(0, 0, 1, $datestat['mon'], $datestat['mday'], $datestat['year']);
					$hourinsertCount[$datestat['hours']]++;
				}
				
				//sau khi da co duoc stat cua tung gio trong ngay
				//tien hanh insert/update
				for($i = 0; $i < 24; $i++)
				{
					$myStat = new Core_Stat();
					$myStat->type = $typeid;
					$myStat->date = $dayinsert;
					$myStat->hour = $i;
					$myStat->value = $hourinsertCount[$i];
					if($myStat->addData())
					{
						$collectorTracking .= '<tr><td>'.$collectIndex++.'</td><td>'.($i==0?date('d/m/Y', $dayinsert):'').'</td><td>'.$i.'</td><td>'.$myStat->value.'</td><td style="color:#00f">PASS</td></tr>';
					}
					else
					{
						$collectorTracking .= '<tr><td>'.$collectIndex++.'</td><td>'.($i==0?date('d/m/Y', $dayinsert):'').'</td><td>'.$i.'</td><td>'.$myStat->value.'</td><td style="color:#f00">EXISTED</td></tr>';
					}
				}
				//increase to next day
				$lastDate = strtotime('+1 day', $dayinsert);
				//echo date('H:i:s, d/m/Y', $lastDate);
				//echo '<hr />';
				//break;
			}
			
			//exit();
			$collectorTracking .= '</table><br>';
		}
		
		$this->registry->smarty->assign(array('collectorTracking' => $collectorTracking));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'collector.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'statlist',
												'pageTitle'	=> 'Website Statistics :: Collector',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
    	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	public function drawValidator($formData, &$error)
	{
		$pass = true;
		
		if($formData['fstart'] == 0)
		{
			$pass = false;
			$error[] = 'Start time is required.';
		}
		
		if($formData['fend'] == 0)
		{
			$pass = false;
			$error[] = 'End time is required.';
		}
		
		if($formData['fstart'] > $formData['fend'])
		{
			$pass = false;
			$error[] = 'Start time can not be greater than End time.';
		}
		
		if($formData['fcharttype'] != 'line' && $formData['fcharttype'] != 'bar')
		{
			$pass = false;
			$error[] = 'Chart type is not valid. (Allow LINE or BAR)';
		}
		
		if($formData['fdatatype'] != 'value' && $formData['fdatatype'] != 'percent')
		{
			$pass = false;
			$error[] = 'Data type is not valid. (Allow VALUE or PERCENT)';
		}
		
		
		return $pass;
	}
	
}


class CRegressionLinear {
	private $mDatas; // input data, array of (x1,y1);(x2,y2);... pairs, or could just be a time-series (x1,x2,x3,...)
	/** constructor */
	function __construct($pDatas) {
	$this->mDatas = $pDatas;
	}

	/** compute the coeff, equation source: http://people.hofstra.edu/faculty/Stefan_Waner/RealWorld/calctopic1/regression.html */
	function calculate() 
	{
		$n = count($this->mDatas);
		$vSumXX = $vSumXY = $vSumX = $vSumY = 0;
		//var_dump($this->mDatas);
		$vCnt = 0; // for time-series, start at t=0
		foreach ($this->mDatas AS $vOne) 
		{
			if (is_array($vOne)) 
			{ // x,y pair
				list($x,$y) = $vOne;
			} 
			else 
			{ // time-series
				$x = $vCnt; $y = $vOne;
			} // fi

			$vSumXY += $x*$y;
			$vSumXX += $x*$x;
			$vSumX += $x;
			$vSumY += $y;
			$vCnt++;
		} // rof
		
		$vTop = ($n*$vSumXY - $vSumX*$vSumY);
		$vBottom = ($n*$vSumXX - $vSumX*$vSumX);
		$a = $vBottom!=0?$vTop/$vBottom:0;
		$b = ($vSumY - $a*$vSumX)/$n;
		//var_dump($a,$b);
		return array($a,$b);
	}

	/** given x, return the prediction y */
	function predict($x) {
	list($a,$b) = $this->calculate();
	$y = $a*$x+$b;
	return $y;
	}
}
