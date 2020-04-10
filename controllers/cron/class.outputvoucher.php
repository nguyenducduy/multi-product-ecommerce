<?php
Class Controller_Cron_Outputvoucher Extends Controller_Cron_Base
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
		$recordPerPage = 1000;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();

		 $startdate = strtoupper(date('d-M-y' , strtotime('2013/08/01')));
		 //$startdate = '';//'2013/08/01';
		 if (!empty($_GET['startdate']) && !empty($_GET['enddate']))
		 {
			 $startdate = strtoupper(date('d-M-y' , Helper::strtotimedmy($_GET['startdate'])));
			 $endtime = Helper::strtotimedmy($_GET['enddate']);
			 $endtime = strtotime('+1 day', $endtime);
			 $enddate = strtoupper(date('d-M-y' , $endtime));
		 }
		 else $enddate = strtoupper(date('d-M-y'));
		 $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE >= TO_DATE(\''.$startdate .'\') AND OUTPUTDATE < TO_DATE(\''.$enddate.'\')';
		 $countAll = $oracle->query($sql);

		 foreach ($countAll as $count)
		 {
		 	$total = $count['TOTAL'];
		 }

		$totalpage = ceil($total/$recordPerPage);

		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ov WHERE OUTPUTDATE >= TO_DATE(\''.$startdate .'\') AND OUTPUTDATE < TO_DATE(\''.$enddate.'\')) WHERE r > ' . $start .' AND r <=' . $end;
			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['OUTPUTDATE']);
                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                $checker = Core_Backend_Outputvoucher::getOutputvouchers(array(
                												'fpoid' => $result['OUTPUTTYPEID'],
                												'fpbarcode' => $result['PRODUCTID'],
                												'fpromoid' => $result['PROMOTIONID'],
                												'fcoid' => $result['PRODUCTCOMBOID'],
                												'fsid' => $result['STOREID'],
                												'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                												'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                												'forderid' => $result['ORDERID'],
                												'finvoiceid' => $result['INVOICEID'],
                												'fovorarowscn' => $result['OVORA_ROWSCN'],
	                											'fovdorarowscn' => $result['OVDORA_ROWSCN'],
                												) , 'id' , 'ASC' , '' , true);

                if($checker == 0)
                {
					$myOutputvoucher                        = new Core_Backend_Outputvoucher();

					$myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
					$myOutputvoucher->pbarcode              = $result['PRODUCTID'];
					$myOutputvoucher->promoid               = $result['PROMOTIONID'];
					$myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
					$myOutputvoucher->sid                   = $result['STOREID'];
					$myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
					$myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
					$myOutputvoucher->orderid               = $result['ORDERID'];
					$myOutputvoucher->invoiceid				= $result['INVOICEID'];
					$myOutputvoucher->username              = $result['USERNAME'];
					$myOutputvoucher->staffuser             = $result['STAFFUSER'];
					$myOutputvoucher->outputdate            = $date;
					$myOutputvoucher->quantity              = $result['QUANTITY'];
					$myOutputvoucher->costprice             = $result['COSTPRICE'];
					$myOutputvoucher->saleprice             = $result['SALEPRICE'];
					$myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
					$myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
					$myOutputvoucher->vat                   = $result['VAT'];
					$myOutputvoucher->vatpercent            = $result['VATPERCENT'];
					$myOutputvoucher->isnew                 = $result['ISNEW'];
					$myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
					$myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
					$myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
					$myOutputvoucher->iserror        		= $result['ISERROR'];
					$myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
					$myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];

					if($myOutputvoucher->addData() > 0)
					{
						$counter++;
						unset($myOutputvoucher);
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

	//import theo ngay va luu file
	public function importdatabydateAction()
	{
		set_time_limit(0);
		$start = strtotime('2013-08-01');//moc start
		$parentend = strtotime('2013-09-30');
		$parentdt = $start;
		$oracle = new Oracle();$recordPerPage = 1000;
		while ($parentdt <= $parentend)
		{

			$counter = 0;
			$total = 0;

			 $startdate = strtoupper(date('d-M-y' , $parentdt));//date('Y/m/d', $parentdt);
			 $enddate = strtoupper(date('d-M-y' , strtotime('+1 day', $parentdt)));//date('Y/m/d', $parentdt);
			 $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE >= TO_DATE(\''.$startdate .'\') AND OUTPUTDATE < TO_DATE(\''.$enddate.'\')';
			 $countAll = $oracle->query($sql);

			 foreach ($countAll as $count)
			 {
		 		$total = $count['TOTAL'];
			 }

			$totalpage = ceil($total/$recordPerPage);
			for ($i = 1 ; $i <= $totalpage ; $i++)
			{
				$start = ($recordPerPage * $i) - $recordPerPage;
				$end = $recordPerPage * $i;

				$sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ov WHERE OUTPUTDATE >= TO_DATE(\''.$startdate .'\') AND OUTPUTDATE < TO_DATE(\''.$enddate.'\')) WHERE r > ' . $start .' AND r <=' . $end;
				$results = $oracle->query($sql);

				foreach ($results as $result)
				{
					$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['OUTPUTDATE']);
	                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

	                $checker = Core_Backend_Outputvoucher::getOutputvouchers(array(
                													'fpoid' => $result['OUTPUTTYPEID'],
                													'fpbarcode' => $result['PRODUCTID'],
                													'fpromoid' => $result['PROMOTIONID'],
                													'fcoid' => $result['PRODUCTCOMBOID'],
                													'fsid' => $result['STOREID'],
                													'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                													'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                													'forderid' => $result['ORDERID'],
                													'finvoiceid' => $result['INVOICEID'],
                													'fovorarowscn' => $result['OVORA_ROWSCN'],
	                												'fovdorarowscn' => $result['OVDORA_ROWSCN'],
                													) , 'id' , 'ASC' , '' , true);

	                if($checker == 0)
	                {
						$myOutputvoucher                        = new Core_Backend_Outputvoucher();

						$myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
						$myOutputvoucher->pbarcode              = $result['PRODUCTID'];
						$myOutputvoucher->promoid               = $result['PROMOTIONID'];
						$myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
						$myOutputvoucher->sid                   = $result['STOREID'];
						$myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
						$myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
						$myOutputvoucher->orderid               = $result['ORDERID'];
						$myOutputvoucher->invoiceid             = $result['INVOICEID'];
						$myOutputvoucher->username              = $result['USERNAME'];
						$myOutputvoucher->staffuser             = $result['STAFFUSER'];
						$myOutputvoucher->outputdate            = $date;
						$myOutputvoucher->quantity              = $result['QUANTITY'];
						$myOutputvoucher->costprice             = $result['COSTPRICE'];
						$myOutputvoucher->saleprice             = $result['SALEPRICE'];
						$myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
						$myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
						$myOutputvoucher->vat                   = $result['VAT'];
						$myOutputvoucher->vatpercent            = $result['VATPERCENT'];
						$myOutputvoucher->isnew                 = $result['ISNEW'];
						$myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
						$myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
						$myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
						$myOutputvoucher->iserror        		= $result['ISERROR'];

						if($myOutputvoucher->addData() > 0)
						{
							$counter++;
							unset($myOutputvoucher);
							unset($result);
							unset($checker);
						}
	                }
				}

				unset($results);
				unset($start);
				unset($end);
			}
			$firstparent = $parentdt;
			$parentdt = strtotime('+1 day', $parentdt);
			file_put_contents('./uploads/outputvoucher_runingdate.txt', $firstparent.'-'.date('Y-m-d H:i:s', $firstparent).'-COUNTER: '.$counter.'----AFTER: '.$parentdt.'-'.date('Y-m-d H:i:s', $parentdt));
		}
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
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE > TO_DATE(\' '. $today .'\')';

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

				$sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ov WHERE OUTPUTDATE > TO_DATE(\' '. $today .'\')) WHERE r > ' . $start .' AND r <=' . $end;
				$results = $oracle->query($sql);

				foreach ($results as $result)
				{
					$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['OUTPUTDATE']);
	                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

	                $checker = Core_Backend_Outputvoucher::getOutputvouchers(array(
	                												'fpoid' => $result['OUTPUTTYPEID'],
	                												'fpbarcode' => $result['PRODUCTID'],
	                												'fpromoid' => $result['PROMOTIONID'],
	                												'fcoid' => $result['PRODUCTCOMBOID'],
	                												'fsid' => $result['STOREID'],
	                												'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
	                												'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
	                												'forderid' => $result['ORDERID'],
	                												'finvoiceid' => $result['INVOICEID'],
	                												'fovorarowscn' => $result['OVORA_ROWSCN'],
	                												'fovdorarowscn' => $result['OVDORA_ROWSCN'],
	                												) , 'id' , 'ASC' , '' , true);

	                if($checker == 0)
	                {
						$myOutputvoucher                        = new Core_Backend_Outputvoucher();

						$myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
						$myOutputvoucher->pbarcode              = $result['PRODUCTID'];
						$myOutputvoucher->promoid               = $result['PROMOTIONID'];
						$myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
						$myOutputvoucher->sid                   = $result['STOREID'];
						$myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
						$myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
						$myOutputvoucher->orderid               = $result['ORDERID'];
						$myOutputvoucher->invoiceid				= $result['INVOICEID'];
						$myOutputvoucher->username              = $result['USERNAME'];
						$myOutputvoucher->staffuser             = $result['STAFFUSER'];
						$myOutputvoucher->outputdate            = $date;
						$myOutputvoucher->quantity              = $result['QUANTITY'];
						$myOutputvoucher->costprice             = $result['COSTPRICE'];
						$myOutputvoucher->saleprice             = $result['SALEPRICE'];
						$myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
						$myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
						$myOutputvoucher->vat                   = $result['VAT'];
						$myOutputvoucher->vatpercent            = $result['VATPERCENT'];
						$myOutputvoucher->isnew                 = $result['ISNEW'];
						$myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
						$myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
						$myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
						$myOutputvoucher->ovorarowsc        = $result['OVORA_ROWSCN'];
						$myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];

						if($myOutputvoucher->addData() > 0)
						{
							$counter++;
							unset($myOutputvoucher);
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
		$total = 746351;
		$totalpage = ceil($total/$recordPerPage);
		//server la 770
		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT ov.COSTPRICE,ov.SALEPRICE,ov.TOTALDISCOUNT,ov.PROMOTIONDISCOUNT, ov.OUTPUTVOUCHERDETAILID, ov.ISERROR, ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ov WHERE OUTPUTDATE >= TO_DATE(\' '. $startdate .'\') AND OUTPUTDATE <= TO_DATE(\' '. $enddate .'\')) WHERE r > ' . $start .' AND r <=' . $end;

			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$myOutputvoucher = array();
				$myOutputvoucher['ov_costprice'] = (float)$result['COSTPRICE'];
				$myOutputvoucher['ov_saleprice'] = (float)$result['SALEPRICE'];
				$myOutputvoucher['ov_totaldiscount'] = (float)$result['TOTALDISCOUNT'];
				$myOutputvoucher['ov_promotiondiscount'] = (float)$result['PROMOTIONDISCOUNT'];
				$myOutputvoucher['ov_iserror'] = $result['ISERROR'];
				Core_Backend_Outputvoucher::updateDataByVoucherDetail($myOutputvoucher, $result['OUTPUTVOUCHERDETAILID']);
				$counter++;
				unset($myOutputvoucher);
				unset($result);
                //}
			}

			unset($results);
			unset($start);
			unset($end);
		}
		echo 'So luong record thuc thi : ' . $counter;
	}
}