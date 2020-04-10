<?php

Class Controller_Stat_Index Extends Controller_Stat_Base
{
	public function indexAction()
	{

		//Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VALUE, array(), '2013/07/11', 10000);


		if(empty($_GET['dateRangeStart']))
		{
			$dateRangeStart = mktime(0,0,1,1,1,2013);	//first day of year 2013
		}
		else
			$dateRangeStart = $_GET['dateRangeStart'];

		$this->registry->smarty->assign(array('dateRangeStart' => $dateRangeStart,
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'nav'		=> 'dashboard',
												'pageTitle'	=> 'Website Statistics :: Dashboard',
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function indexajaxAction()
	{
		$dateRangeStart = (int)$_GET['dateRangeStart'];

		$totalAccountOnline = $this->registry->db->query('SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'sess WHERE s_userid <> 0')->fetchColumn(0);
		$totalAccount = Core_User::statTotalAccount($dateRangeStart);
		$totalArchivedOrder = Core_ArchivedOrder::statTotalOrder($dateRangeStart);
		$totalArchivedOrderAmount = Core_ArchivedOrder::statTotalAmount($dateRangeStart);
		$totalProductView = Core_Backend_View::getViews(array('ftimestampstart' => $dateRangeStart, 'ftype' => Core_Backend_View::TYPE_PRODUCT), '', '', '', true);
		$totalNewsView = Core_Backend_View::getViews(array('ftimestampstart' => $dateRangeStart, 'ftype' => Core_Backend_View::TYPE_NEWS), '', '', '', true);
		$totalStuffView = Core_Backend_View::getViews(array('ftimestampstart' => $dateRangeStart, 'ftype' => Core_Backend_View::TYPE_STUFF), '', '', '', true);
		$totalPageView = Core_Backend_View::getViews(array('ftimestampstart' => $dateRangeStart, 'ftype' => Core_Backend_View::TYPE_PAGE), '', '', '', true);
		$totalStuff = Core_Stuff::getStuffs(array('ftimestampstart' => $dateRangeStart), '', '', '', true);
		$totalAdsClick = Core_Backend_AdsClick::getAdsClicks(array('ftimestampstart' => $dateRangeStart), '', '', '', true);

		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="utf-8"?>
				<result>
				<totalAccount>'.(int)$totalAccount.'</totalAccount>
				<totalAccountOnline>'.(int)$totalAccountOnline.'</totalAccountOnline>
				<totalArchivedOrder>'.(int)$totalArchivedOrder.'</totalArchivedOrder>
				<totalArchivedOrderAmount>'.(float)$totalArchivedOrderAmount.'</totalArchivedOrderAmount>
				<totalProductView>'.(int)$totalProductView.'</totalProductView>
				<totalNewsView>'.(int)$totalNewsView.'</totalNewsView>
				<totalStuffView>'.(int)$totalStuffView.'</totalStuffView>
				<totalPageView>'.(int)$totalPageView.'</totalPageView>
				<totalStuff>'.(int)$totalStuff.'</totalStuff>
				<totalAdsClick>'.(int)$totalAdsClick.'</totalAdsClick>
				</result>';
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

	public function internaltopbarsummaryAction()
	{
		//Request POST data
		$currenturl = urldecode($_POST['currenturl']);
		$reporttype = $_POST['reporttype'];
		$objectid = (int)$_POST['objectid'];

		//init output
		$output = '<viewinday>0</viewinday>';


		//output final data
		$xml = '<?xml version="1.0" encoding="utf-8"?><result>' . $output;
		$xml .= '</result>';
        header ("content-type: text/xml");
        echo $xml;
	}
	####################################################################################################
	####################################################################################################
	####################################################################################################

}


