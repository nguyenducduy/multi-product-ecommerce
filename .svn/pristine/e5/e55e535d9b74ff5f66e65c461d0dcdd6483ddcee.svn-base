<?php
Class Controller_Cron_InputVoucher Extends Controller_Cron_Base
{
	public function indexAction()
	{

	}

	public function importdataAction()
	{
		set_time_limit(0);
		$recordPerPage = 1000;
		$counter = 0;
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
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_INPUTVOUCHER_DM WHERE INPUTDATE >= TO_DATE(\''. $startdate .'\') AND INPUTDATE < TO_DATE(\''. $enddate .'\')';

		 $countAll = $oracle->query($sql);

		 foreach($countAll as $count)
		 {
		 	$total = $count['TOTAL'];
		 }

		//$total = 249565;
		$totalpage = ceil($total/$recordPerPage);

		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT iv.* , ROWNUM r FROM ERP.VW_INPUTVOUCHER_DM iv WHERE INPUTDATE >= TO_DATE(\''. $startdate .'\') AND INPUTDATE < TO_DATE(\''. $enddate .'\')) WHERE r > ' . $start .' AND r <=' . $end;//
			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTDATE']);
                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));

                // $checker = Core_Backend_Inputvoucher::getInputvouchers(array('finputvoucherid' => $result['INPUTVOUCHERID'],
                // 													'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID'],
                // 													'forderid' => $result['ORDERID'],
                // 													'fsid' => $result['STOREID'],
                // 													'fpbarcode' => $result['PRODUCTID'],
                // 													), 'id', 'ASC', '0,1' , true);
                // if($checker == 0)
                // {
                	$myInputVoucher = new Core_Backend_Inputvoucher();
                	$myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                	$myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                	$myInputVoucher->orderid = $result['ORDERID'];
                	$myInputVoucher->invoiceid = $result['INVOICEID'];
                	$myInputVoucher->sid = $result['STOREID'];
                	$myInputVoucher->username = $result['USERNAME'];
                	$myInputVoucher->inputdate = $date;
                	$myInputVoucher->piid = $result['INPUTTYPEID'];
                	$myInputVoucher->pbarcode = $result['PRODUCTID'];
                	$myInputVoucher->quantity = $result['QUANTITY'];
                	$myInputVoucher->price = (float)$result['PRICE'];
                	$myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                	$myInputVoucher->discount = (float)$result['DISCOUNT'];
                	$myInputVoucher->vat = $result['VAT'];
                	$myInputVoucher->vatpercent = $result['VATPERCENT'];
                	$myInputVoucher->isnew = $result['ISNEW'];
                	$myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                	$myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                	$myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                	$myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];

                	if($myInputVoucher->addData() > 0)
                	{
                		$counter++;
                		unset($checker);
                		unset($myInputVoucher);
                		unset($result);
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
		$recordPerPage = 500;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();
		$today = strtoupper(date('d-M-y' , time()));
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_INPUTVOUCHER_DM WHERE INPUTDATE >= TO_DATE(\' '. $today .'\')';

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

				$sql = 'SELECT * FROM (SELECT iv.* , ROWNUM r FROM ERP.VW_INPUTVOUCHER_DM iv WHERE INPUTDATE >= TO_DATE(\' '. $today .'\')) WHERE r > ' . $start .' AND r <=' . $end;

				$results = $oracle->query($sql);

				foreach ($results as $result)
				{
					$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTDATE']);
	                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));

	                $checker = Core_Backend_Inputvoucher::getInputvouchers(array('finputvoucherid' => $result['INPUTVOUCHERID'],
	                													'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID'],
	                													'forderid' => $result['ORDERID'],
	                													'fsid' => $result['STOREID'],
	                													'fpbarcode' => $result['PRODUCTID'],
	                													), 'id', 'ASC', '' , true);
	                if($checker == 0)
	                {
	                	$myInputVoucher = new Core_Backend_Inputvoucher();
	                	$myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
	                	$myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
	                	$myInputVoucher->orderid = $result['ORDERID'];
	                	$myInputVoucher->invoiceid = $result['INVOICEID'];
	                	$myInputVoucher->sid = $result['STOREID'];
	                	$myInputVoucher->username = $result['USERNAME'];
	                	$myInputVoucher->inputdate = $date;
	                	$myInputVoucher->piid = $result['INPUTTYPEID'];
	                	$myInputVoucher->pbarcode = $result['PRODUCTID'];
	                	$myInputVoucher->quantity = $result['QUANTITY'];
	                	$myInputVoucher->price = $result['PRICE'];
	                	$myInputVoucher->inputprice = $result['INPUTPRICE'];
	                	$myInputVoucher->discount = $result['DISCOUNT'];
	                	$myInputVoucher->vat = $result['VAT'];
	                	$myInputVoucher->vatpercent = $result['VATPERCENT'];
	                	$myInputVoucher->isnew = $result['ISNEW'];
	                	$myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
	                	$myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];

	                	if($myInputVoucher->addData() > 0)
	                	{
	                		$counter++;
	                		unset($checker);
	                		unset($myInputVoucher);
	                		unset($result);
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
		$total = 239565;
		$totalpage = ceil($total/$recordPerPage);
		//server la 770
		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT ov.PRICE,ov.INPUTPRICE,ov.DISCOUNT, ov.INPUTVOUCHERDETAILID, ROWNUM r FROM ERP.VW_INPUTVOUCHER_DM ov WHERE INPUTDATE >= TO_DATE(\' '. $startdate .'\') AND INPUTDATE <= TO_DATE(\' '. $enddate .'\')) WHERE r > ' . $start .' AND r <=' . $end;
			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$myOutputvoucher = array();
				$myOutputvoucher['iv_price'] = (float)$result['PRICE'];
				$myOutputvoucher['iv_inputprice'] = (float)$result['INPUTPRICE'];
				$myOutputvoucher['iv_discount'] = $result['DISCOUNT'];
				Core_Backend_Inputvoucher::updateDataByVoucherDetail($myOutputvoucher, $result['INPUTVOUCHERDETAILID']);
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