<?php
Class Controller_Cron_Outputvoucherreturn Extends Controller_Cron_Base
{
	/**
	 * [indexAction description]
	 * @return [type] [description]
	 */
	public function indexAction()
	{

	}

	/**
	 * [importdataAction description]
	 * @return [type] [description]
	 */
	public function importdataAction()
	{
		set_time_limit(0);
		$recordPerPage = 500;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();		

		$startdate = strtoupper(date('d-M-y' , strtotime('2013/01/01')));		
		if (!empty($_GET['startdate']) && !empty($_GET['enddate']))
	 {
		 $startdate = strtoupper(date('d-M-y' , Helper::strtotimedmy($_GET['startdate'])));
		 $endtime = Helper::strtotimedmy($_GET['enddate']);
		 $endtime = strtotime('+1 day', $endtime);
		 $enddate = strtoupper(date('d-M-y' , $endtime));
	 }
	 else $enddate = strtoupper(date('d-M-y'));
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_RETURN_DM WHERE INPUTTIME >= TO_DATE(\''. $startdate .'\') AND INPUTTIME < TO_DATE(\''. $enddate .'\')';

		$countAll = $oracle->query($sql);		

		foreach ($countAll as $count) 
		{
			$total = $count['TOTAL'];
		}
		//$total = 11861;//109142;
		$totalpage = ceil($total/$recordPerPage);

		for ($i = 1 ; $i <= $totalpage ; $i++)  
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT ovr.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_RETURN_DM ovr WHERE INPUTTIME >= TO_DATE(\' '. $startdate .'\') AND INPUTTIME < TO_DATE(\' '. $enddate .'\')) WHERE r > ' . $start .' AND r <=' . $end;
			$results = $oracle->query($sql);

			foreach ($results as $result) 
			{
				$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTTIME']);
                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                // $checker = Core_Backend_Outputvoucherreturn::getOutputvoucherreturns(array(
                // 													'fpbarcode'	=> $result['PRODUCTID'],
                // 													'fsaleorderid' => $result['SALEORDERID'],
                // 													'fsaleorderdetailid' => $result['SALEORDERDETAILID'],
                // 													'finputreturnid' => $result['INPUTRETURNID'],
                // 													'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                // 													'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID']
                // 												) , 'id' , 'ASC' , '' , true);

                // if($checker == 0)
                // {
					$myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn();
		
					$myOutputvoucherreturn->pbarcode = $result['PRODUCTID'];						
					$myOutputvoucherreturn->saleorderid = $result['SALEORDERID'];
					$myOutputvoucherreturn->saleorderdetailid = $result['SALEORDERDETAILID'];
					$myOutputvoucherreturn->inputreturnid = $result['INPUTRETURNID'];
					$myOutputvoucherreturn->outputvoucherid = $result['OUTPUTVOUCHERID'];
					$myOutputvoucherreturn->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
					$myOutputvoucherreturn->quantity = $result['QUANTITY'];
					$myOutputvoucherreturn->imei = $result['IMIE'];
					$myOutputvoucherreturn->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
					$myOutputvoucherreturn->inputtime = $date;
					$myOutputvoucherreturn->inputvoucherid = $result['INPUTVOUCHERID'];
					$myOutputvoucherreturn->isreturnwithfee = $result['ISRETURNWITHFEE'];
					$myOutputvoucherreturn->price = $result['PRICE'];
					$myOutputvoucherreturn->returnfee = $result['RETURNFEE'];
					$myOutputvoucherreturn->returnnote = $result['RETURNNOTE'];
					$myOutputvoucherreturn->returnreason = $result['RETURNREASON'];
					$myOutputvoucherreturn->storemanageruser = $result['STOREMANAGERUSER'];
					$myOutputvoucherreturn->adjustprice = $result['ADJUSTPRICE'];
					$myOutputvoucherreturn->originalprice = $result['ORIGINALPRICE'];
					$myOutputvoucherreturn->totalvatlost = $result['TOTALVATLOST'];
					$myOutputvoucherreturn->returnreasonid = $result['RETURNREASONID'];
					$myOutputvoucherreturn->inputprice = $result['INPUTPRICE'];
					$myOutputvoucherreturn->ivdetailprice = $result['IVDETAILPRICE'];
					$myOutputvoucherreturn->iserror = $result['ISERROR'];
					$myOutputvoucherreturn->ovisdelete = $result['OVISDELETE'];
					$myOutputvoucherreturn->ovdetailisdelete = $result['OVDETAILISDELETE'];
					$myOutputvoucherreturn->sid = $result['STOREID'];
					$myOutputvoucherreturn->inputtypeid = $result['INPUTTYPEID'];
					$myOutputvoucherreturn->orarowscn = $result['ORA_ROWSCN'];

					if($myOutputvoucherreturn->addData() > 0)
					{
						$counter++;
						unset($myOutputvoucherreturn);
						unset($result);
						unset($checker);						
					}
                //}
			}
		}
		echo 'So luong record thuc thi : ' . $counter;
	}

	/**
	 * [syncdataAction description]
	 * @return [type] [description]
	 */
	public function syncdataAction()
	{
		set_time_limit(0);
		$recordPerPage = 500;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();
		$today = strtoupper(date('d-M-y' , time()));
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_RETURN_DM WHERE OUTPUTDATE > TO_DATE(\' '. $today .'\')';

		$countAll = $oracle->query($sql);
		foreach ($countAll as $count) 
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

				$sql = 'SELECT * FROM (SELECT ovr.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ovr WHERE INPUTTIME > TO_DATE(\' '. $today .'\')) WHERE r > ' . $start .' AND r <=' . $end;
				$results = $oracle->query($sql);
				
				foreach ($results as $result) 
				{
					$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTTIME']);
	                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

	                $checker = Core_Backend_Outputvoucherreturn::getOutputvoucherreturns(array(
	                													'fpbarcode'	=> $result['PRODUCTID'],
	                													'fsaleorderid' => $result['SALEORDERID'],
	                													'fsaleorderdetailid' => $result['SALEORDERDETAILID'],
	                													'finputreturnid' => $result['INPUTRETURNID'],
	                													'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
	                													'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID']
	                												) , 'id' , 'ASC' , '' , true);

	                if($checker == 0)
	                {
						$myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn();
			
						$myOutputvoucherreturn->pbarcode = $result['PRODUCTID'];						
						$myOutputvoucherreturn->saleorderid = $result['SALEORDERID'];
						$myOutputvoucherreturn->saleorderdetailid = $result['SALEORDERDETAILID'];
						$myOutputvoucherreturn->inputreturnid = $result['INPUTRETURNID'];
						$myOutputvoucherreturn->outputvoucherid = $result['OUTPUTVOUCHERID'];
						$myOutputvoucherreturn->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
						$myOutputvoucherreturn->quantity = $result['QUANTITY'];
						$myOutputvoucherreturn->imei = $result['IMIE'];
						$myOutputvoucherreturn->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
						$myOutputvoucherreturn->inputtime = $date;
						$myOutputvoucherreturn->inputvoucherid = $result['INPUTVOUCHERID'];
						$myOutputvoucherreturn->isreturnwithfee = $result['ISRETURNWITHFEE'];
						$myOutputvoucherreturn->price = $result['PRICE'];
						$myOutputvoucherreturn->returnfee = $result['RETURNFEE'];
						$myOutputvoucherreturn->returnnote = $result['RETURNNOTE'];
						$myOutputvoucherreturn->returnreason = $result['RETURNREASON'];
						$myOutputvoucherreturn->storemanageruser = $result['STOREMANAGERUSER'];
						$myOutputvoucherreturn->adjustprice = $result['ADJUSTPRICE'];
						$myOutputvoucherreturn->originalprice = $result['ORIGINALPRICE'];
						$myOutputvoucherreturn->totalvatlost = $result['TOTALVATLOST'];
						$myOutputvoucherreturn->returnreasonid = $result['RETURNREASONID'];
						$myOutputvoucherreturn->inputprice = $result['INPUTPRICE'];
						$myOutputvoucherreturn->ivdetailprice = $result['IVDETAILPRICE'];
						$myOutputvoucherreturn->iserror = $result['ISERROR'];
						$myOutputvoucherreturn->ovisdelete = $result['OVISDELETE'];
						$myOutputvoucherreturn->ovdetailisdelete = $result['OVDETAILISDELETE'];
						$myOutputvoucherreturn->sid = $row['STOREID'];
						$myOutputvoucherreturn->inputtypeid = $row['INPUTTYPEID'];

						if($myOutputvoucherreturn->addData() > 0)
						{
							$counter++;
							unset($myOutputvoucherreturn);
							unset($result);
							unset($checker);
						}
	                }
				}

				unset($results);
				unset($start);
				unset($end);
			}
			echo 'So luong record thuc thi : ' . $counter;
		}
	}
}