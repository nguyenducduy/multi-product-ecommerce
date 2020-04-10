<?php
Class Controller_Cron_Averagecostprice extends Controller_Cron_Base
{
	/**
	* put your comment there...
	* 
	*/
	public function indexAction()
	{
		
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function importdataAction()
	{
		set_time_limit(0);		
		$recordPerPage = 1000;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_AVERAGECOSTPRICE_DM';
		
		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			$total = $count['TOTAL'];
		}
		
		$totalpage = ceil($total/$recordPerPage); 
		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;
			
			$sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_AVERAGECOSTPRICE_DM a) WHERE r > ' . $start .' AND r <=' . $end;
			$results = $oracle->query($sql);			
						
			foreach($results as $result)
			{
				$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['MONTH']);				
				$datepart = explode('/', $dateUpdated->format('d/m/Y'));								
				
				//$checker = Core_Backend_Averagecostprice::getAveragecostprices(array('fpbarcode' => $result['PRODUCTID'],
//																			'fmonth' => $datepart[1],
//																			'fyear' => $datepart[2],
//																			), 'id' , 'ASC', '' , true);
				
				$myAveragecostprice = new Core_Backend_Averagecostprice();
				$myAveragecostprice->pbarcode = $result['PRODUCTID'];
				$myAveragecostprice->month = $datepart[1];
				$myAveragecostprice->year = $datepart[2];
				$myAveragecostprice->price = (float)$result['COSTPRICE'];
				$myAveragecostprice->orarowscn = $result['ORA_ROWSCN'];
				
				if($myAveragecostprice->addData() > 0)
				{
					$counter++;
					unset($result);	
					unset($myAveragecostprice);
				}
								
			}
			
			unset($start);
			unset($end);
		}
		
		echo 'So luong record thuc hien : ' . $counter;
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function syncdataAction()
	{
		set_time_limit(0);
		$recordPerPage = 1000;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();
		$today = strtoupper(date('d-M-y' , strtotime('2013/08/01')));
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_AVERAGECOSTPRICE_DM WHERE MONTH >= TO_DATE(\'' . $today . '\')';
		
		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			 $total = $count['TOTAL'];
		}
		
		if($total > 0)
		{
			$totalpage = $total > 500 ? ceil($total/$recordPerPage) : 1;
			for ($i = 1 ; $i <= $totalpage ; $i++)
			{
				$start = ($recordPerPage * $i) - $recordPerPage;
				$end = $recordPerPage * $i;
				
				$sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_AVERAGECOSTPRICE_DM a) WHERE r > ' . $start .' AND r <=' . $end;
				$results = $oracle->query($sql);			
							
				foreach($results as $result)
				{
					$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['MONTH']);				
					$datepart = explode('/', $dateUpdated->format('d/m/Y'));								
					
					$checker = Core_Backend_Averagecostprice::getAveragecostprices(array('fpbarcode' => $result['PRODUCTID'],
																				'fmonth' => $datepart[1],
																				'fyear' => $datepart[2],
																				), 'id' , 'ASC', '' , true);
					
					if($checker == 0)
					{
						$myAveragecostprice = new Core_Backend_Averagecostprice();
						$myAveragecostprice->pbarcode = $result['PRODUCTID'];
						$myAveragecostprice->month = $datepart[1];
						$myAveragecostprice->year = $datepart[2];
						$myAveragecostprice->price = $result['COSTPRICE'];
					}
					
					if($myAveragecostprice->addData() > 0)
					{
						$counter++;
						unset($result);	
						unset($myAveragecostprice);
					}
									
				}
				
				unset($start);
				unset($end);
			}
			
			echo 'So luong record thuc hien : ' . $counter;
		}
	}
	
	public function importstorestatisticAction()
	{
		set_time_limit(0);
		$db3 = Core_Backend_Object::getDb();
		$lastrow = '2013/01/01';
		$recordPerPage = 1000;
		$oracle = new Oracle();
		$countAll = $oracle->query('SELECT count(*) as total from ERP.VW_STORE_STATISTIC WHERE to_char(STATISTICDATE, \'yyyy/mm/dd\') >= \''.$lastrow.'\'');
			
		if (!empty($countAll))
		{
			$total = $countAll[0]['TOTAL'];
			if ($total > 0)
			{
				$totalpage = ceil($total/$recordPerPage); 
				for ($i = 1 ; $i <= $totalpage ; $i++)
				{
					$start = ($recordPerPage * $i) - $recordPerPage;
					$end = $recordPerPage * $i;
					
					$sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_STORE_STATISTIC a WHERE to_char(a.STATISTICDATE, \'yyyy/mm/dd\') >= \''.$lastrow.'\') WHERE r > ' . $start .' AND r <=' . $end;
					$results = $oracle->query($sql);			
								
					foreach($results as $result)
					{					
						//$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['STATISTICDATE']);				               			
						$date =  strtotime($result['STATISTICDATE']);//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
						$checker = $db3->query('SELECT ss_id FROM '.TABLE_PREFIX.'store_statistic 
												WHERE ss_statisticvalue= ? AND ss_statisticdate = ? AND s_id = ? LIMIT 1',
												array($result['STATISTICVALUE'], $date, $result['STOREID'])
												)->fetch();
						if (count($checker) > 0 && $checker['ss_id'] > 0)
						{
							$sqlupdate = 'UPDATE '.TABLE_PREFIX.'store_statistic SET ss_statisticvalue= ? , ss_statisticdate = ? , s_id = ? WHERE ss_id = ?';
							$db3->query($sqlupdate, array($result['STATISTICVALUE'], $date, $result['STOREID'], $checker['ss_id']));
						}
						else
						{
							$sqlupdate = 'INSERT INTO '.TABLE_PREFIX.'store_statistic(ss_statisticvalue , ss_statisticdate , s_id ) VALUES (?, ?, ?)';
							$db3->query($sqlupdate, array($result['STATISTICVALUE'], $date, $result['STOREID']));
						}
					}
				}
			}
		}
	}
}
