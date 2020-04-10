<?php
Class Controller_Cron_Beginminstock extends Controller_Cron_Base
{
	public function indexAction()
	{
	}

	public function importdataAction()
	{
		set_time_limit(0);
		$counter = 0;
		$oracle = new Oracle();
		$recordPerPage = 1000;


		$startdate = '2013/07/01';
		 if (!empty($_GET['startdate']) && !empty($_GET['enddate']))
		 {
			 $startdate = date('Y/m/d' , Helper::strtotimedmy($_GET['startdate']));
			 $enddate = date('Y/m/d' , Helper::strtotimedmy($_GET['enddate']));
		 }
		 else $enddate = date('Y/m/d');

		 $countall = $oracle->query('SELECT COUNT(*) AS TOTAL FROM ERP.VW_BEGINTERMINSTOCK_DM WHERE to_char(INSTOCKMONTH, \'yyyy/mm/dd\') >= \''.$startdate .'\' AND to_char(INSTOCKMONTH, \'yyyy/mm/dd\') < \''.$enddate .'\'');

		 $total = 0;
		 foreach($countall as $count)
		 {
		 	$total = $count['TOTAL'];
		 }
		//$total = 171775;//(thang 7)//665123 (all);
		echodebug($total);
		$totalpage = ceil($total/$recordPerPage);


		for ($i = 1 ; $i <= $totalpage ; $i++)  // tiep tuc chay tiep tu page 623
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT bg.* , ROWNUM r FROM ERP.VW_BEGINTERMINSTOCK_DM bg WHERE to_char(INSTOCKMONTH, \'yyyy/mm/dd\') >= \''.$startdate .'\' AND to_char(INSTOCKMONTH, \'yyyy/mm/dd\') < \''.$enddate .'\') WHERE r > ' . $start .' AND r <=' . $end;
			//$sql = 'select sum(quantity) from ERP.vw_beginterminstock_dm where instockmonth >= to_date(\'01-Jun-13\') AND instockmonth < to_date(\'02-Jun-13\') AND productid =\'1000362035001\'';

			$results = $oracle->query($sql);
			//echodebug($results,true);

			foreach($results as $result)
			{
				$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INSTOCKMONTH']);
				$datepart = explode('/', $dateUpdated->format('d/m/Y'));

				 //$checker = Core_Backend_Beginminstock::getBeginminstocks(array('fpbarcode'=>$result['PRODUCTID'],
//				 														'fsid' => $result['STOREID'],
//				 														'fmonth' => $datepart[1],
//				 														'fyear' => $datepart[2]
//				 														), 'id', 'ASC' , '', true);
//
//				 if($checker == 0)
//				 {
					$myBeginminstock = new Core_Backend_Beginminstock();
					$myBeginminstock->pbarcode = $result['PRODUCTID'];
					$myBeginminstock->sid = $result['STOREID'];
					$myBeginminstock->imei = $result['IMEI'];
					$myBeginminstock->isshowproduct = $result['ISSHOWPRODUCT'];
					$myBeginminstock->month = $datepart[1];
					$myBeginminstock->year = $datepart[2];
					$myBeginminstock->quantity = $result['QUANTITY'];
					$myBeginminstock->costprice = $result['COSTPRICE'];
					$myBeginminstock->isnew = $result['ISNEW'];
					$myBeginminstock->orarowscn = $result['ORA_ROWSCN'];
					if($myBeginminstock->addData() > 0)
					{
						$counter++;
						unset($myBeginminstock);
						unset($result);
						//unset($checker);
					}
				//}
			}
			unset($results);
			unset($start);
			unset($end);
		}
		echo 'So luong record thuc thi : ' . $counter;
	}

	public function syncdataAction()
	{
		set_time_limit(0);
		$counter = 0;
		$oracle = new Oracle();
		$recordPerPage = 500;
		$today = strtoupper(date('d-M-y' , time()));
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_BEGINTERMINSTOCK_DM WHERE INSTOCKMONTH >= TO_DATE(\' '.$today.' \')';

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

				$sql = 'SELECT * FROM (SELECT bg.* , ROWNUM r FROM ERP.VW_BEGINTERMINSTOCK_DM bg WHERE INSTOCKMONTH >= TO_DATE(\' '.$today.' \')) WHERE r > ' . $start .' AND r <=' . $end;

				$results = $oracle->query($sql);

				foreach($results as $result)
				{
					$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INSTOCKMONTH']);
					$datepart = explode('/', $dateUpdated->format('d/m/Y'));

					/*$checker = Core_Backend_Beginminstock::getAveragecostprices(array('fpbarcode' => $result['PRODUCTID'],
																						'fmonth' => $datepart[1],
																						'forarowscn' => $result['ORA_ROWSCN'],
																						'fyear' => $datepart[2]
																						), 'id' , 'ASC', 1);
					*/
					$myBeginminstock = new Core_Backend_Beginminstock();
					$myBeginminstock->pbarcode = $result['PRODUCTID'];
					$myBeginminstock->sid = $result['STOREID'];
					$myBeginminstock->month = $datepart[1];
					$myBeginminstock->year = $datepart[2];
					$myBeginminstock->quantity = $result['QUANTITY'];
					$myBeginminstock->costprice = $result['COSTPRICE'];
					$myBeginminstock->isnew = $result['ISNEW'];
					$myBeginminstock->orarowscn = $result['ORA_ROWSCN'];
					if($myBeginminstock->addData() > 0)
					{
						$counter++;
						unset($myBeginminstock);
						unset($result);
					}
				}
				unset($results);
				unset($start);
				unset($end);
			}
			echo 'So luong record thuc thi : ' . $counter;
		}
		else
		{
			echo 'No have data';
		}
	}

	public function updatepricetodecimalAction()
	{
		set_time_limit(0);
		$recordPerPage = 500;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();

		 $startdate = strtoupper(date('d-M-y' , strtotime('2013/05/01')));

		 if (!empty($_GET['startdate']) && !empty($_GET['enddate']))
		 {
			 $startdate = strtoupper(date('d-M-y' , Helper::strtotimedmy($_GET['startdate'])));
			 $enddate = strtoupper(date('d-M-y' , Helper::strtotimedmy($_GET['enddate'])));
		 }
		 else $enddate = strtoupper(date('d-M-y'));
		$total = 493348;
		$totalpage = ceil($total/$recordPerPage);
		//server la 770
		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT ov.*, ROWNUM r FROM ERP.VW_BEGINTERMINSTOCK_DM ov WHERE INSTOCKMONTH >= TO_DATE(\' '. $startdate .'\') AND INSTOCKMONTH <= TO_DATE(\' '. $enddate .'\')) WHERE r > ' . $start .' AND r <=' . $end;
			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INSTOCKMONTH']);
				$datepart = explode('/', $dateUpdated->format('d/m/Y'));

				$myOutputvoucher = array();
				$myOutputvoucher['p_barcode'] = $result['PRODUCTID'];
				$myOutputvoucher['b_month'] = $datepart[1];
				$myOutputvoucher['b_year'] = $datepart[2];
				$myOutputvoucher['s_id'] = $result['STOREID'];
				Core_Backend_Beginminstock::updateDataByBarcode($result['COSTPRICE'], $myOutputvoucher);
				$counter++;
				unset($myOutputvoucher);
				unset($result);
			}

			unset($results);
			unset($start);
			unset($end);
		}
		echo 'So luong record thuc thi : ' . $counter;
	}

	//------------------IMPORT vw_store_statistic tu ERP de lay so luong khach vao sieu thi xem--------------
	public function importstorestatisticAction()
	{
		set_time_limit(0);
		$counter = 0;
		$oracle = new Oracle();
		$recordPerPage = 1000;
		$total = 7598;

		$totalpage = ceil($total/$recordPerPage);
		for ($i = 1 ; $i <= $totalpage ; $i++)  // tiep tuc chay tiep tu page 623
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT sum(a.STATISTICVALUE) as STATISTICVALUE, a.STATISTICDATE, a.STOREID, ROWNUM r FROM ERP.vw_store_statistic a GROUP BY a.STATISTICDATE, a.STOREID, ROWNUM) WHERE r > ' . $start .' AND r <=' . $end;
			//$sql = 'select sum(quantity) from ERP.vw_beginterminstock_dm where instockmonth >= to_date(\'01-Jun-13\') AND instockmonth < to_date(\'02-Jun-13\') AND productid =\'1000362035001\'';

			$results = $oracle->query($sql);
			//echodebug($results,true);

			foreach($results as $result)
			{

					$myStoreStatistic = new Core_Backend_StoreStatistic();

					//$dateUpdated = DateTime::createFromFormat('d-M-y', $result['STATISTICDATE']);
					//$datepart = Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

					$myStoreStatistic->sid = $result['STOREID'];
					$myStoreStatistic->statisticvalue = $result['STATISTICVALUE'];
					$myStoreStatistic->statisticdate = strtotime($result['STATISTICDATE']);
					if($myStoreStatistic->addData() > 0)
					{
						$counter++;
						unset($myStoreStatistic);
						unset($result);
						//unset($checker);
					}
			}
			unset($results);
			unset($start);
			unset($end);
		}
		echo 'So luong record thuc thi : ' . $counter;
	}


}