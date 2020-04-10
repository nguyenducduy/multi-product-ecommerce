<?php
ini_set ( 'memory_limit', '2500M' );
class Controller_Cron_Recommendation extends Controller_Cron_Base
{
	public $productList = array();
	public $for_i = 0 ;
	public $for_j = 0 ;
	public $list  = array();
	public $server= '172.16.141.60';
//	public $server= '127.0.0.1';
	public $dem   = 0;
	public $flag  = true;
	public $precentRedis = array();



	function indexAction()
	{

//
//		$redis = new Redis();
//		$redis->connect($this->server,6379);
//		$arr = $redis->keys('rf4*');
//		$re  = $redis->delete($arr);
//		echodebug($re);
//
//		$re = '';
//		$redis = new Redis();
//		$redis->connect($this->server,6379);
//
//		for($i=0;$i<10;$i++)
//		{
//			for($j=0;$j<10;$j++)
//			{
//				$arr = $redis->keys('rs2:'.$i.$j.'*');
//				$re  .= 'key :'.$i.$j.':'. $redis->delete($arr).'<br>';
//			}
//		}
//		echodebug($re);


		$dem = 0;
		$redis = new Redis();
		$redis->connect($this->server,6379);
		for($i=0;$i<10;$i++)
		{
			for($j=0;$j<10;$j++)
			{
				for($k=0;$k<10;$k++)
				{
					$count = count($redis->keys('rs2:'.$i.$j.$k.'*'));
					$dem =$dem + $count;
					echodebug('key :'.$i.$j.$k.':'. $count);

				}

			}
		}
		echodebug('tong cong : ' . $dem);
	}

	function resameorderAction ( )
	{

		set_time_limit ( 0 );
		$record = 10000;
		$arrcheck = array();
		$orderid = '';
		$str = '';
		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product
				WHERE p_onsitestatus = ?';
		$stmt = $this->registry->db->query ( $sql, array(
				Core_Product::OS_ERP
		) );
		$this->productList = array();
		while ( $row = $stmt->fetch () )
		{
			$this->productList[$row['p_id']] = '';
		}
		$sql2 = 'SELECT count(*) FROM ' . TABLE_PREFIX . 'archivedorder_detail WHERE p_id<>0';
		$count = $this->registry->db->query ( $sql2, array() )->fetchSingle ();
		$totalpage = ceil ( $count / $record );

		for ( $i = 0 ; $i < $totalpage ; $i ++ )
		{
			$sql3 = 'SELECT p_id,o_orderid FROM ' . TABLE_PREFIX . 'archivedorder_detail WHERE p_id<>0 ORDER BY lit_archivedorder_detail.o_orderid ASC LIMIT ' . ( $i * $record ) . ',' . $record;

			$rs = $this->registry->db->query ( $sql3, array() );
			while ( $row = $rs->fetch () )
			{
				if ( $row['o_orderid'] == $orderid )
				{
					if ( isset ( $this->productList[$row['p_id']] ) )
					{
						$this->productList[$row['p_id']] .= '1';
						$arrcheck[] = $row['p_id'];

					}
				}
				else
				{
					if ( $orderid == '' )
					{

						$orderid = $row['o_orderid'];
						if ( isset ( $this->productList[$row['p_id']] ) )
						{
							$this->productList[$row['p_id']] .= '1';
							$arrcheck[] = $row['p_id'];
						}
					}
					else
					{

						$orderid = $row['o_orderid'];

						$this->setProduct ( $arrcheck );
						unset ( $arrcheck );
						if ( isset ( $this->productList[$row['p_id']] ) )
						{
							$this->productList[$row['p_id']] .= '1';
							$arrcheck[] = $row['p_id'];
						}

					}

				}

			}
			$this->setProduct ( $arrcheck );
			unset ( $arrcheck );
			echodebug ( $this->productList, true );
		}

	}

	private function setProduct ( $arr )
	{

		foreach ( $this->productList as $key => $value )
		{
			if ( ! empty ( $arr ) )
			{
				if ( ! in_array ( $key, $arr ) )
				{
					$this->productList[$key] .= "0";
				}
			}
			else
				$this->productList[$key] .= "0";
		}
	}

	// ############################################################
	// tao database
	function createdata ( )
	{
		set_time_limit ( 0 );
		$str = '';
		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product
				WHERE p_onsitestatus = ?';
		$stmt = $this->registry->db->query ( $sql, array(
				Core_Product::OS_ERP
		) );
		$productList = array();
		while ( $row = $stmt->fetch () )
		{
			$productList[] = $row['p_id'];
		}
		for ( $i = 0 ; $i < count ( $productList ) ; $i ++ )
		{

			for ( $j = 0 ; $j < count ( $productList ) ; $j ++ )
			{
				$str .= '("' . $productList[$i] . '","' . $productList[$j] . '","0","' . time () . '"),';
			}
			$str = substr ( $str, 0, - 1 );
			$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rec_itemitem_scrore( is_p1,is_p2,is_sameorder,is_datecreated) values ' . $str;
			$this->registry->db->query ( $sql );
			$str = '';
			echo 'Xong';
		}
	}

	function continueorderAction ( )
	{
		$id = 0;
		set_time_limit ( 0 );
		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product
				WHERE p_onsitestatus = ?';
		$stmt = $this->registry->db->query ( $sql, array(
				Core_Product::OS_ERP
		) );
		/* ================================================================ */
		$sql2 = 'SELECT * FROM ' . TABLE_PREFIX . 'rec_itemitem_scrore Where is_datemodified =( SELECT max(is_datemodified) FROM ' . TABLE_PREFIX . 'rec_itemitem_scrore )';
		$rs2 = $this->registry->db->query ( $sql2 );
		while ( $row2 = $rs2->fetch () )
		{
			if ( $row2['is_id'] > $id )
			{
				$sp1 = $row2['is_p1'];
				$sp2 = $row2['is_p2'];
				$id = $row2['is_id'];

			}

		}

		unset ( $rs2 );
		unset ( $row2 );
		$productList = array();
		while ( $row = $stmt->fetch () )
		{
			$productList[] = $row['p_id'];
		}
		for ( $i = 0 ; $i < count ( $productList ) ; $i ++ )
		{
			if ( $productList[$i] == $sp1 )
				$this->for_i = $i;
			for ( $j = 0 ; $j < count ( $productList ) ; $j ++ )
			{
				if ( $productList[$j] == $sp2 )
					$this->for_j = $j;

				if ( $this->for_i > 0 && $this->for_j > 0 )
				{
					unset ( $productList );
					unset ( $stmt );
					unset ( $row );
					$this->recsameorderAction ();
				}

			}
		}
	}
	// 2065
	function recsameorderAction ( )
	{
		$redis = new Redis();
		$redis->connect($this->server, 6379);

		set_time_limit ( 0 );

		$productList = $this->getProduct();
		// ////////////////////////////
		// Loop
		for ( $i = $this->for_i ; $i < count ( $productList ) ; $i ++ )
		{
			$command = '';

            for($j=$this->for_j;$j<count($productList);$j++)
            {
                $value = $this->recSameOrderPair($productList[$i], $productList[$j]);
                //$value2 = $this->recsamecustomerPair($productList[$i], $productList[$j]);

                $key = 'rf1:'.$productList[$i].':'.$productList[$j].'';
                $command .= '->set("'.$key.'", '.$value.')';
            }

            $command .= '->exec();';
            $commandredis = '$redis->pipeline()' . $command;

            eval($commandredis);
			
			unset ( $this->checkOrderList );
			$this->flag = true;
			//$this->getneighbor ( $productList[$i], 'order' );
			
		}
		echo 'xong';
	}

	public function testAction()
	{
		$arrweight = $this->getAttWeight();

		$p1 = $this->getRb($_GET['p1']);
		$p2 = $this->getRb($_GET['p2']);
		echodebug($p1);
		echodebug($p2);
		echodebug($this->calCore($p1,$p2,$arrweight,true));
		foreach($arrweight as $k=>$v)
		{
			if($v=='1')
				unset($arrweight[$k]);
		}
		echodebug($arrweight);

	}

	public function getredisAction()
	{
		$redis = new Redis();
		$redis->connect($this->server, 6379);
		echodebug($redis->get($_GET['key']));
	}

	/**
	 * Tra ve Similar score p1 va p2
	 */
	function recsameorderPair2($p1,$p2) {
		$sim   = 0;
		$sql_p1= 'SELECT o_orderid FROM '. TABLE_PREFIX.'archivedorder_detail WHERE p_id ="'.$p1.'"';
		$sql_p2= 'SELECT o_orderid FROM '. TABLE_PREFIX.'archivedorder_detail WHERE p_id ="'. $p2 . '"';
		$obj1 = $this->registry->db->query ( $sql_p1 );
		$obj2 = $this->registry->db->query ( $sql_p2 );
		$oid1 = array();
		$oid2 = array();
		while ( $rs1 = $obj1->fetch () )
		{
			
			$oid1[] = $rs1['o_orderid'];
		}
		while ( $rs2 = $obj2->fetch () )
		{
			$oid2[] = $rs2['o_orderid'];
		}
	
		$rs_cmp = array_intersect ( $oid1, $oid2 );
		$sim = count ( $rs_cmp );
		unset ( $oid1 );
		unset ( $oid2 );
		unset ( $obj1 );
		unset ( $obj2 );
		return $sim; 
	}


	function recSameOrderPair ( $p1 , $p2 )
	{
		$sim = 0;
		if ( ! isset ( $this->checkOrderList[$p1] ) && $this->flag )
		{
			$this->flag = false;
			$recordPerPageOr = 1000;
			$con['lit_archivedorder_detail']['p_id'] = $p1;
			$countOrder = Core_ArchivedorderDetail::getrecommendSameOrder ( $con, '', true );
			$totalPageOr = ceil ( $countOrder / $recordPerPageOr );
			
			if ( $countOrder > 1 )
			{
				// for don hang
				for ( $j = 1 ; $j <= $totalPageOr ; $j ++ )
				{
					
					// list order co chua product
					$myOrderList = Core_ArchivedorderDetail::getrecommendSameOrder ( $con, ( ( $j - 1 ) * $recordPerPageOr ) . ',' . $recordPerPageOr, false );
					if ( ! empty ( $myOrderList ) )
					{
						foreach ( $myOrderList as $khoa => $giatri )
						{
							// lay nhung san pham cua order da mua p1
							$con2['lit_archivedorder_detail']['o_orderid'] = $giatri['o_orderid'];
							$proOrder                                      = Core_ArchivedorderDetail::getrecommendSameOrder($con2 , '' , '');
							if ( ! empty ( $proOrder ) )
							{
								// tao mang
								foreach ( $proOrder as $k => $v )
								{
									if ( $v['p_id'] != $p1 && $v['p_id'] != '0' )
									{
										$this->checkOrderList[$p1][] = $v['p_id'];
									}
								}
							
							}
						
						}
					
					}
					unset ( $myOrderList );
					unset ( $proOrder );
				}
			
			}
			if ( isset ( $this->checkOrderList[$p1] ) && ! empty ( $this->checkOrderList[$p1] ) )
				$this->checkOrderList[$p1] = array_count_values ( $this->checkOrderList[$p1] );
		}
		
		if ( ! empty ( $this->checkOrderList[$p1] ) && ! $this->flag )
		{
			
			foreach ( $this->checkOrderList[$p1] as $key => $value )
			{
				if ( $key == $p2 )
				{
					$sim = $this->checkOrderList[$p1][$key];
					unset ( $this->checkOrderList[$p1][$key] );
				}
			}
		}
		
		return $sim;
	}
	/*
	 * get list product
	 * */
	private function getProduct($condition = '')
	{
		$productList = array();
		if($condition=='')
			$condition = "p_onsitestatus = ".Core_Product::OS_ERP;
		if($condition == 'all')
			$condition = '';
		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE '.$condition;
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$productList[] = $row['p_id'];
		}
		sort($productList);
		return $productList;
	}
	/*
	 * lay mang trong so
	 * */
	private function getAttWeight()
	{
		$weight    		  = array();
		$weight['vendor'] = 5;
		$weight['segment']= 3;

		$arrweight = Core_ProductAttribute::getProductAttributes(array(),'','');
		foreach($arrweight as $key=>$value)
		{
			$weight[$value->id] = $value->weightrecommand;
		}
		return $weight;
	}
	/*
	 * get list hang
	 * */
	private function getVendor()
	{
		$rs  = array();
		$sql = 'SELECT p_id,v_id FROM '. TABLE_PREFIX .'product ';
		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{
			$rs[$row['p_id']] = $row['v_id'];

		}
		return $rs;
	}
	/*
	 * get phan khuc gia
	 * */
	private function getPriceSegment()
	{
		$rs      = array ();
		$segment = array ();
		$sql     = 'SELECT pc_id,paf_value FROM ' . TABLE_PREFIX . 'product_attribute_filter WHERE  `pa_id` =0 ';
		$tmp     = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{
			$arr 	= explode('###',$row['paf_value']);
			foreach($arr as $key=>$value)
			{
				$child_segment           = explode('##' , $value);
				if(count($child_segment)==5)
				{
					$rs[$child_segment[1]][] = $child_segment[3];
					$rs[$child_segment[1]][] = $child_segment[4];
				}
			}
			$segment[$row['pc_id']] = $rs;
		}
		return $segment;
	}

	private function getProductByCustomer($condittion = '',$all = false)
	{
		$listProduct = $this->getProduct($condittion);

		$rs      = array ();
		$cutomer = '';
		$str     = '';
		$sql     = "SELECT  o_customerphone , p_id FROM " . TABLE_PREFIX . "archivedorder
		INNER JOIN lit_archivedorder_detail ON lit_archivedorder.o_id = lit_archivedorder_detail.o_orderid
		WHERE  `o_customerphone` <>  ''
		AND  `p_id` <> 0
		ORDER BY  `lit_archivedorder`.`o_customerphone` ASC
		";
		$stmts   = $this->registry->db->query($sql);
		while($rss = $stmts->fetch())
		{
			if($cutomer!=$rss['o_customerphone'])
			{
				if($cutomer=='')
				{
					$cutomer = $rss['o_customerphone'];
					if(in_array($rss['p_id'],$listProduct))
						$str 	.= $str == '' ? $rss['p_id'] : ',' . $rss['p_id'];
				}
				else
				{
					if($str!='')
						$rs[$cutomer] = $str;

					$cutomer      = '';
					$str          = '';
				}


			}
			else
			{
				if($all)
				{
					$str 	.= $str == '' ? $rss['p_id'] : ',' . $rss['p_id'];
				}
				else
				{
					if(in_array($rss['p_id'],$listProduct))
						$str 	.= $str == '' ? $rss['p_id'] : ',' . $rss['p_id'];
				}

			}

		}
		return $rs;
	}

	function updatecustomerAction ( )
	{
		$tmp = 0;
		
		for ( $i = 0 ; $i < 9 ; $i ++ )
		{
			
			$sql = 'SELECT is_p1,is_p2 FROM lit_rec_itemitem_scrore where is_samecustomer>10 LIMIT ' . ( $i * 1000 ) . ",1000";
			$stmt = $this->registry->db->query ( $sql );
			while ( $row = $stmt->fetch () )
			{
				
				if ( $tmp != $row['is_p1'] && ! $this->flag )
				{
					
					unset ( $this->checkOrderList );
					$this->flag = true;
					$tmp = $row['is_p1'];
				
				}
				$sim = $this->recSameCustomerPair ( $row['is_p1'], $row['is_p2'] );
				
				$sql = 'update lit_rec_itemitem_scrore set is_samecustomer = ' . $sim . ' ,is_datemodified = ' . time () . ' WHERE  `is_p1` = ' . $row['is_p1'] . ' AND `is_p2` = ' . $row['is_p2'];
				$rs = $this->registry->db->query ( $sql );
			
			}
			echo 'xong';
		}
	
	}
		
	/*======================================   CUSTOMER   ==============================================*/

	/*
	 * insert 4tr record
	 * cal core f2
	 * */

	public function recsamecustomerAction ( )
	{
		$redis = new Redis();
		$redis->connect($this->server, 6379);

		set_time_limit ( 0 );
		$gettime = new timer();
		$gettime->start();

		$productList = $this->getProduct();

		// ////////////////////////////
		// Loop
		for ( $i = $this->for_i ; $i < count ( $productList ) ; $i ++ )
		{

			$command = '';

			for($j=$this->for_j;$j<count($productList);$j++)
			{
				$value = $this->recSameCustomerPair($productList[$i], $productList[$j]);
				$key = 'rf2:'.$productList[$i].':'.$productList[$j].'';
				$command .= '->set("'.$key.'", '.$value.')';
			}

			$command .= '->exec();';
			$commandredis = '$redis->pipeline()' . $command;
			eval($commandredis);
			unset ( $this->checkOrderList );
			$this->flag = true;
			//$this->getneighbor ( $productList[$i], 'customer' );
		}
		$gettime->stop();
		echodebug($gettime->get_exec_time(),true);
		echo 'xong';
	}

	function recSameCustomerPair ( $p1 , $p2 )
	{
		$sim = 0;

		if ( ! isset ( $this->checkOrderList[$p1] ) && $this->flag )
		{

			$this->checkOrderList[$p1] = array();
			$this->flag = false;
			$recordPerPageOr = 1000;
			$con['lit_archivedorder_detail']['p_id'] = $p1;
			$countOrder = Core_Archivedorder::getAJoinADByProduct ( $con, '', true );
			$totalPageOr = ceil ( $countOrder / $recordPerPageOr );

			if ( $countOrder > 1 )
			{
				// for don hang
				for ( $j = 1 ; $j <= $totalPageOr ; $j ++ )
				{

					// list order co chua product p1
					$myOrderList = Core_Archivedorder::getAJoinADByProduct ( $con, ( ( $j - 1 ) * $recordPerPageOr ) . ',' . $recordPerPageOr, false );
					if ( ! empty ( $myOrderList ) )
					{
						foreach ( $myOrderList as $khoa => $giatri )
						{
							// lay nhung san pham cua order da mua p1
							if ( $giatri['o_customerphone'] != '' )
							{
								$con2['lit_archivedorder']['o_customerphone'] = $giatri['o_customerphone'];
								// order cua 1 khach hang
								$proOrder = Core_Archivedorder::getAJoinADByProduct ( $con2, '', '' );

								if ( ! empty ( $proOrder ) )
								{
									// tao mang
									foreach ( $proOrder as $k => $v )
									{

										if ( $v['p_id'] != $p1 && $v['p_id'] != "0" && $v['o_customerphone'] != '' )
										{

											array_push ( $this->checkOrderList[$p1], $v['p_id'] );

										}
									}

								}

							}

						}

					}
					unset ( $myOrderList );
					unset ( $proOrder );

				}

			}
			// var_dump($dem);

			if ( isset ( $this->checkOrderList[$p1] ) && ! empty ( $this->checkOrderList[$p1] ) )
				$this->checkOrderList[$p1] = array_count_values ( $this->checkOrderList[$p1] );

		}

		if ( ! empty ( $this->checkOrderList[$p1] ) && ! $this->flag )
		{
			foreach ( $this->checkOrderList[$p1] as $key => $value )
			{
				if ( $key == $p2 )
				{
					$sim = $this->checkOrderList[$p1][$key];
					unset ( $this->checkOrderList[$p1][$key] );
				}
			}
		}

		return $sim;
	}

	/*
	 * insert 2tr record
	 * cal sim f2
	 * */
	public function rs2totalAction()
	{
		$arr   = array();
		$redis = new Redis();
		$redis->connect($this->server, 6379);
		$gettime = new timer();

		$datamin = new DataMining();


		$gettime->start();

		$productList = $this->getProduct();
		$count       = count($productList);

		for ( $i = 0;$i < $count;$i++ ) {
			$command = '';
			if ( !isset($arr[$productList[$i]]) ) {
				$arr[$productList[$i]] = $this->rs2Action($productList[$i] , $productList);
			}

			$listp1   = $arr[$productList[$i]];
			for ( $j = $i + 1;$j < $count;$j++ ) {

				if ( !isset($arr[$productList[$j]]) ) {
					$arr[$productList[$j]] = $this->rs2Action($productList[$j] , $productList);
				}

				$listp2 = $arr[$productList[$j]];

				$value = $datamin->cosineSimilarity($listp1 , $listp2);


				$key = 'rs2:' . $productList[$i] . ':' . $productList[$j] . '';
				$command .= '->set("' . $key . '", ' . $value . ')';
			}
			$command .= '->exec();';
			$commandredis = '$redis->pipeline()' . $command;
			eval($commandredis);

		}
		$gettime->stop();
		echo "Hoan thanh trong : ". $gettime->get_exec_time();
	}

	function rs2Action($p1,$productList)
	{
		$result = array();
		set_time_limit(0);
		$redis = new Redis();
		$redis->connect($this->server, 6379);

		$command = '';

		foreach($productList as $key=>$item)
		{
			$command .= '->get("rf2:'.$p1.':'.$item.'")';
		}

		$command .= '->exec();';
		$commandredis = '$redis->pipeline()' . $command;
		eval( '$result = ' . $commandredis . '' );

		//if(array_sum($result)==0)
		//	$this->dem = $this->dem + 1;
		// result la mang sim cua  p1
		return $result;
	}

	/*
	 * 2k record
	 * set list neighbor
	 * */
	public function rs2neighborAction()
		{
			$redis = new Redis();
			$redis->connect($this->server, 6379);
			$productList = $this->getProduct();
			$count       = count($productList);

			for ( $i = 0;$i < $count;$i++ ) {
				$redis->set('rs2n:'.$productList[$i],$this->rs2neighbor($productList[$i],$productList));
			}
		}

	function rs2neighbor($p1 , $productList)
		{


			$str    = '';
			$arr	= array();
			$dem    = 0;
			set_time_limit(0);
			$redis = new Redis();
			$redis->connect($this->server, 6379);

			foreach($productList as $key=>$item)
			{
				if($p1<=$item)
					$arr[$item] = $redis->get("rs2:".$p1.":".$item);
				else
					$arr[$item] = $redis->get("rs2:".$item.":".$p1);
			}

			arsort($arr);

			foreach($arr as $key=>$value)
			{

				$dem = $dem + 1;
				if($dem<=500 && $value>0)
					$str.=$str==''? $key : ','.$key;
			}
			return $str;
		}


	/*=============================================================================================*/


	/*==================================== S CUSTOMER ==============================================*/

		/*
		 * set = true
		 * get = false
		 * ------------------------------------------------
		 * [0] = countu
		 * [1] = counti
		 * [2] = begin
		 * [3] = propre
		 * [4] = prosim
		 * [5] = pronuu
		 * [6] = proui
		 * [7] = proii
		 * [8] = total
		 * [9] = finish
		 * */

		private function Tracking($key , $action = true , $arr = array() )
		{
			$value = '';
			$redis = new Redis();
			$redis->connect($this->server , 6379);

			if($action)
			{
				$monitorData       = $redis->get('recommendation:monitor:' . $key);
				$monitorDataDetail = explode('#' , $monitorData);
				$monitorDataDetail = $arr + $monitorDataDetail;
				ksort($monitorDataDetail);
				foreach ( $monitorDataDetail as $k=>$v )
				{
					$value .= $value =='' ? $v : '#'.$v ;
				}
				$monitorDataDetail = $redis->set('recommendation:monitor:' . $key , $value);
			}
			else
			{
				$monitorData       = $redis->get('recommendation:monitor:' . $key);
				$monitorDataDetail = explode('#' , $monitorData);
			}

			return $monitorDataDetail;

		}
		/*
		 * tong cong record can chay
		 * so phan % mun chia ra de hien ra ngoai
		 * step nao
		 * gia tri
		 * i de tinh cho viec insert
		 * */
		private  function calpercent($total , $per , $f ,  $value  ,  $i = 0 , $beginper = 0)
		{
			if($i == 0)
			{
				$phan    = ceil($total/$per);

				for($i = 1 ; $i <= $per ; $i++)
				{
					$this->precentRedis[] = $phan * $i;
				}
				switch($value)
				{
					case 'propre':
						$arr[3] = 'process (0%)';
						$this->Tracking($f,true,$arr);
						break;
					case 'prosi':
						$arr[4] = 'process (0%)';
						$this->Tracking($f,true,$arr);
						break;
					case 'proii':
						$arr[5] = 'process (0%)';
						$this->Tracking($f,true,$arr);
						break;
					case 'prouu':
						$arr[6] = 'process (0%)';
						$this->Tracking($f,true,$arr);
						break;
					case 'proui':
						$arr[7] = 'process (0%)';
						$this->Tracking($f,true,$arr);
						break;

				}
				return $this->precentRedis;
			}
			else
			{
				if(in_array($i,$this->precentRedis))
				{

					switch($value)
					{
						case 'propre':
							$arr[3] = 'process ('.ceil(($i * (100-$beginper))/$total + $beginper).'%)';
							$this->Tracking($f,true,$arr);
							break;
						case 'prosi':
							$arr[4] = 'process ('.ceil(($i * (100-$beginper))/$total + $beginper).'%)';
							$this->Tracking($f,true,$arr);
							break;
						case 'proii':
							$arr[5] = 'process ('.ceil(($i * (100-$beginper))/$total + $beginper).'%)';
							$this->Tracking($f,true,$arr);
							break;
						case 'prouu':
							$arr[6] = 'process ('.ceil(($i * (100-$beginper))/$total + $beginper).'%)';
							$this->Tracking($f,true,$arr);
							break;
						case 'proui':
							$arr[7] = 'process ('.ceil(($i * (100-$beginper))/$total + $beginper).'%)';
							$this->Tracking($f,true,$arr);
							break;

					}
					$redis = new Redis();
					$redis->connect($this->server,6379);
					$redis->set('rs2testvalueitrack'.$f,$i);


				}
			}

		}
	/** getcore product : save redis */
	public function recsamecustomerfullAction ( )
	{
		$redis = new Redis();
		$redis->connect($this->server, 6379);

		set_time_limit ( 0 );
		$gettime = new timer();
		$gettime->start();
		$condition ='`p_barcode` !=  "" ';
		$productList = $this->getProduct($condition);
		// ////////////////////////////
		// Loop
		$count = count($productList);
		$this->calpercent($count,10,'s2','propre');
		for ( $i = 0 ; $i < $count ; $i ++ )
		{

			$command = '';
			$this->calpercent($count,10,'s2','propre',$i);
			for ( $j = 0;$j < $count;$j++ ) {
				$value = $this->recSameCustomerPair($productList[$i] , $productList[$j]);
				if($value>0)
				{
					$key   = 'rc2:' . $productList[$i] . ':' . $productList[$j];
					$command .= '->set("' . $key . '", ' . $value . ')';
				}

			}

			$command .= '->exec();';
			$commandredis = '$redis->pipeline()' . $command;
			eval($commandredis);
			unset ( $this->checkOrderList );
			// de danh dau ko lay lay lai ds kh da mua p1 nua
			$this->flag = true;
		}
		$gettime->stop();

		$timepre     = $gettime->get_exec_time();
		$arrtrack[0] = 0;
		$arrtrack[1] = $count;
		$arrtrack[2] = time();
		$arrtrack[3] = 'complete ('.$timepre .'s)';
		$this->Tracking('s2' , true , $arrtrack);


		$timesim     = $this->rs2totalfullAction();
		$arrtrack[4] = 'complete ('.$timesim .'s)';
		$this->Tracking('s2' , true , $arrtrack);


		$timenei     = $this->rs2neighborfullAction();
		$arrtrack[5] = 'complete ('.$timenei .'s)';
		$this->Tracking('s2' , true , $arrtrack);

		$timeui      = $this->rs4totalAction('2');
		$arrtrack[7] = 'complete ('.$timeui .'s)';
		$this->Tracking('s2' , true , $arrtrack);


		$arrtrack[8]  = ($timenei + $timepre + $timesim + $timeui);
		$arrtrack[9]  = time();
		$this->Tracking('s2' , true , $arrtrack);

	}





	public function rs2totalfullAction()
	{

		set_time_limit(0);
		$dem         = 0;
		$gettime     = new timer();
		$command	 = '';
		$similar     = new DataMining();
		$arrCore     = array();
		$arrPro      = array();
		$arrtrack    = array();
		$redis       = new Redis();
		$redis->connect($this->server , 6379);

		$gettime->start();
		$x = isset($_GET['next']) &&  $_GET['next'] == 'next' ? $redis->get('rs2testvaluei') : 0;
		$redis->set('rs2testvaluei',0);


		$productList = $this->getProduct("`p_barcode`!=''");

		foreach ( $productList as $key =>$value ) {
			$arrPro[$value] = 0;
		}


		$arrCore = $this->getArrCore();
		$arrKey  = array_keys($arrCore);
		$count   = count($arrCore);

		sort($arrKey);

		$this->calpercent($count,100,'s2','prosi');
		for ( $i = $x  ; $i < $count ; $i++ )
		{
			$this->calpercent($count,100,'s2','prosi',$i);
			$command = '';
			$p1      = $arrCore[$arrKey[$i]] + $arrPro;
			$key     = 'rs2:' . $arrKey[$i] . ":";
			unset($arrCore[$arrKey[$i]]);
			for ( $j = $i + 1 ; $j < $count ; $j++ )
			{

				$p2  = $arrCore[$arrKey[$j]] + $arrPro;

				$core = $similar->cosineSimilarity($p1 , $p2);
				if ( $core > 0 ) {
					$command .= '->set("' . $key . $arrKey[$j] . '","' . $core . '")';
				}

			}

			// insert redis
			if ( $command != '' ) {

				$command .= '->exec();';
				$commandredis = '$redis->pipeline()' . $command;
				eval($commandredis);

			}
			$redis->set('rs2testvaluei',$i);
		}
		$gettime->stop();
		$finish      = $gettime->get_exec_time();
		$arrtrack[4] = 'complete (' . $finish . 's)';
		$this->Tracking('s2' , true , $arrtrack);
		$this->rs4totalAction('2');
		return $finish;
	}


	private function getArrCore()
	{
		$redis   = new Redis();
		$arrCore = array ();
		$redis->connect($this->server , 6379);
		$arr = $redis->keys('rc2*');
		foreach ( $arr as $key=>$value ) {
			$key = explode(':',$value);
			$arrCore[$key[1]][$key[2]] = $arrCore[$key[2]][$key[1]] = $redis->get($value) ;
		}
		return $arrCore;
	}


	public function rs2neighborfullAction()
	{

		set_time_limit(0);
		$gettime = new timer();
		$redis 	 = new Redis();
		$redis->connect($this->server, 6379);
		$gettime->start();
		$productList = $this->getProduct("`p_barcode`!=''");
		$count       = count($productList);
		$command     = '';
		$this->calpercent($count,100,'s2','proii');
		for ( $i = 497;$i < $count;$i++ ) {
			$this->calpercent($count,100,'s2','proii',$i);
			$this->rs2neighborfull($productList[$i]);
		}
		$gettime->stop();
		$finish      = $gettime->get_exec_time();
		$arrtrack[5] = 'complete (' . $finish . 's)';
		$this->Tracking('s2' , true , $arrtrack);
		$this->rs4totalAction();
		return $finish;
	}

	function rs2neighborfull($p1)
	{
		$rs   	= '';
		$str    = '';
		$arr	= array();
		$dem    = 0;
		set_time_limit(0);
		$redis = new Redis();
		$redis->connect($this->server, 6379);
		$arrkey = $redis->keys('rs2:'.$p1.":*");
		$arrkey2= $redis->keys('rs2:*:'.$p1);
		$arrkey = array_merge($arrkey,$arrkey2);
		if(!empty($arrkey))
		{
			foreach ( $arrkey as $key=>$value )
			{
				$khoa 		   = explode(':',$value);
				$arr[$khoa[1]] = $arr[$khoa[2]] =  $redis->get($value);

			}
			if(array_sum($arr)>0)
			{
				unset($arr[$p1]);
				arsort($arr);
				$arrKhoa = array_keys($arr);
				$arr     = array_slice($arrKhoa , 0 , 500);
				$str .= implode(',' , $arr);
				$redis->set('rp2:'.$p1,$str);
			}
		}


		return $rs;
	}
	/*=============================================================================================*/



	/*=================================    F3    ==================================================*/




	/*
	 * 2k list attr
	 * */
	public function rbAction()
	{
		$timebegin = time();
		$redis = new Redis();

		$redis->connect($this->server, 6379);

		$gettime          = new timer();
		$gettime->start();
		$condittion       = "`p_barcode`!=''";
		$productList      = $this->getProduct($condittion);

		$count            = count($productList);
		$arrAd['vendor']  = $this->getVendor();
		$arrAd['segment'] = $this->getPriceSegment();

		$gettime->start();
		$this->calpercent($count,10,'s3','propre');
		for ($i = 0; $i < $count; $i++)
		{
			$this->calpercent($count,10,'s3','propre',$i);
			$strin = $this->getAttr($productList[$i],$arrAd);
			$redis->set('rb:'.$productList[$i],$strin);

		}
		$gettime->stop();


		$timepre     = $gettime->get_exec_time();
		$arrtrack    = $this->Tracking('s3' , false);
		$arrtrack[0] = 0;
		$arrtrack[1] = $count;
		$arrtrack[2] = $timebegin;
		$arrtrack[3] = 'complete ('.$timepre .'s)';
		$this->Tracking('s3' , true , $arrtrack);


		$timesim     = $this->rs3totalAction();
		$arrtrack[4] = 'complete ('.$timesim .'s)';
		$this->Tracking('s3' , true , $arrtrack);


		$timenei     = $this->rs3neighborAction();
		$arrtrack[5] = 'complete ('.$timenei .'s)';
		$this->Tracking('s3' , true , $arrtrack);




		$arrtrack[8]  = ($timenei + $timepre + $timesim);
		$arrtrack[9]  = time();
		$this->Tracking('s3' , true , $arrtrack);



	}

	function getAttr($pc,$arrAd)
	{
		$str     = '';
		$vendor  = array ();
		$segment = array ();

		$vendor  = isset($arrAd['vendor']) ? $arrAd['vendor'] : $vendor;
		$segment = isset($arrAd['segment']) ? $arrAd['segment'] : $segment;


		$sql     = "SELECT rpa_value,pa_id FROM  " . TABLE_PREFIX . "rel_product_attribute WHERE  `p_id` =  '" . $pc . "'";
		$stmt    = $this->registry->db->query($sql);
		while($rs = $stmt->fetch())
		{

			$str .= '###'.$rs['pa_id'].'##'.$rs['rpa_value'];

		}

		// lay vendor
		if(!empty($vendor))
			$str .= '###vendor##'.$vendor[$pc];

		// lay segment
		$sqls     = "SELECT pc_id,p_sellprice FROM  " . TABLE_PREFIX . "product WHERE  `p_id` =  '" . $pc . "'";
		$stmts    = $this->registry->db->query($sqls);
		while($rss = $stmts->fetch())
		{

			if ( !empty($segment) && isset($segment[$rss['pc_id']])) {
				foreach ( $segment[$rss['pc_id']] as $key => $value ) {
					if ( count($value) == 2 ) {

						if ( $rss['p_sellprice'] >= $value[0] && $rss['p_sellprice'] <= $value[1] ) {
							$str .= "###segment##" . $key;
						}

					}
				}

			}
			$str = $rss['pc_id'].'#' . $str;
		}

		return $str;
	}

	/*
	 * 2tr record core
	 * */
	public function rs3totalAction()
	{
		$arrweight = $this->getAttWeight();
		$redis     = new Redis();
		$redis->connect($this->server , 6379);
		$gettime = new timer();


		$ListCategory = $this->getListcategory();
		$count        = count($ListCategory);
		$arr          = $this->getRb();
		$gettime->start();
		$this->calpercent($count,100,'s3','prosi');

		for ($i = 0; $i < $count; $i++)
		{

			$this->calpercent($count,100,'s3','prosi',$i);
			if(is_array($arr[$ListCategory[$i]]) && isset($arr[$ListCategory[$i]]))
			{
				ksort($arr[$ListCategory[$i]]);
				foreach ( $arr[$ListCategory[$i]] as $key=>$value )
				{

					$command  = '';

					$keyRS      = 'rc3:' . $key. ':';
					foreach ( $arr[$ListCategory[$i]] as $k=>$v )
					{


						if($k>$key)
						{
							$core = $this->calCore($value , $v , $arrweight);

							if($core>0)
								$command .= '->set("' . $keyRS . $k . '","' . $core . '")';
						}
					}



					if($command!='')
					{
						$command .= '->exec();';
						$commandredis = '$redis->pipeline()' . $command;
						eval($commandredis);
					}


				}
				$redis->set('rs4testvaluei',$i);
			}

			unset($arr[$ListCategory[$i]]);

		}
		$gettime->stop();
		return $gettime->get_exec_time();
	}
	private  function getListcategory()
	{
		$row = array();
		$sql = 'SELECT pc_id FROM lit_productcategory';
		$tmp = $this->registry->db->query($sql);
		while($tmprow = $tmp->fetch() )
		{
			$row[] = $tmprow['pc_id'];
		}
		return $row;
	}
	/*
	 * get list content base
	 *
	 * pcid####pa_id1##att1###pa_id2##att2
	 * */
	function getRb()
	{
		$redis = new Redis();
		$arr   = array();
		$redis->connect($this->server, 6379);
		$gettime = new timer();
		$strp = $redis->keys('rb:*');
		$arrpro= array();
		foreach($strp as  $key=>$value)
		{
			// lay p_id
			$key = end(explode(':',$value));

			/*
			 * pcid
			 * pa_id1##att1###pa_id2##att2
			 * */
			$giatri = explode('####',$redis->get($value));

			 // pa_id1##att1
			$arratt = explode('###',$giatri[1]);

			foreach ( $arratt as $k=>$v ) {
				$arrtmp = explode('##',$v);
				$arr[$giatri[0]][$key][$arrtmp[0]] = $arrtmp[1];
			}

			// gan ds sp theo danh muc
		}
		return $arr;
	}

	/*
	 * cal core content base
	 * */
	function calCore($p1 , $p2 , $arrweight = array () , $testing = false)
	{

		$Count  = 0;

		// giong nhau hoan toan
		$arrSim = array_intersect_assoc($p1,$p2);
		//loc nhung key ko ton tai trong arrsim ma giong co key giong nhau
		$arrkey = array_diff_assoc(array_intersect_key($p1,$p2),$arrSim);

		foreach ( $arrkey as $k=>$v ) {

			$dem =  $this->checkcontent($p1[$k] , $p2[$k]);
			if($dem>0)
				$Count = ($dem * $arrweight[$k]) + $Count;

		}

//		foreach ( $p1 as $key => $value ) {
//			// tao mang 1 thuoc tinh att_category##att
//			foreach ( $p2 as $k => $v ) {
//				if ( $k == $key ) {
//
//					$dem = $this->checkcontent($v , $value);
//
//					if ( $dem >= 1 ) {
//						$Count = ($dem * $arrweight[$k]) + $Count;
//						unset($p2[$k]);
//						break;
//					}
//
//				}
//			}
//
//		}

//		foreach ( $p1 as $key => $value ) {
//			// tao mang 1 thuoc tinh att_category##att
//			$arr = explode('##' , $value);
//			foreach ( $p2 as $k => $v ) {
//				$arr2 = explode('##' , $v);
//				if ( $arr[0] == $arr2[0] ) {
//
//					$dem = $this->checkcontent($arr[1] , $arr2[1]);
//
//					if ( $dem >= 1 ) {
//						$Count = ($dem * $arrweight[$arr[0]]) + $Count;
//						unset($p2[$k]);
//						break;
//					}
//
//				}
//			}
//
//		}


		return $Count + count($arrSim);
	}
	/*
	 * check content
	 * */
	function checkcontent($con,$con2)
	{

		$pass = 0;
		similar_text($con,$con2,$sim);
		if($sim>=80)
			$pass = 1;

		return $pass;
	}

	/*
	 * get 2k neighbor
	 * */
	public function rs3neighborAction()
	{

		set_time_limit(0);
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		$gettime = new timer();



//		$gettime->start();
//		$condittion  = "`p_barcode`!=''";
//		$productList = $this->getProduct($condittion);
//		$command     = '';
//		$count       = count($productList);
		$gettime->start();
		/** get neighbor theo category  */
		$arrtmp 	  = array();
		$arrrs		  = array();
		$ListCategory = $this->getListcategory();
		$count        = count($ListCategory);
		$arr          = $this->getproductbycategory();


		// xoa nhung danh muc chi co 1 san pham
		foreach ( $arr as $k=>$v ) {
			 if(count($v)<2)
				unset($arr[$k]);
		}
		$this->calpercent($count,100,'s3','proii');
		for ( $i = 0;$i <= $count;$i++ ) {
			$gettime->start();

			$this->calpercent($count,100,'s3','proii',$i);
			if(is_array($arr[$ListCategory[$i]]) && isset($arr[$ListCategory[$i]]))
			{

				ksort($arr[$ListCategory[$i]]);
				foreach ( $arr[$ListCategory[$i]] as $key=>$value )
				{
						$giatri = $this->getrc3($value,$arr[$ListCategory[$i]],$redis);
						$redis->set('rp3:'.$value , $giatri  );

				}

			}
			//$redis->set('testvaluerp3',$i);
		}
		$gettime->stop();
		$arrtrack[5] = 'complete ('.$gettime->get_exec_time() .'s)';
		$this->Tracking('s3' , true , $arrtrack);
		return $gettime->get_exec_time();


/*


		$this->calpercent($count,100,'s3','proii');
		for ( $i = 0;$i < $count;$i++ ) {
			$this->calpercent($count,100,'s3','proii',$i);
			$redis->set('testvaluerp3',$i);
			$gettime->start();
			$command .= '->set("rp3:' . $productList[$i] . '","' . $this->rs3($productList[$i]) . '")';
			$gettime->stop();
			echodebug($gettime->get_exec_time(),true);
		}

		$command .= '->exec();';
		$commandredis = '$redis->pipeline()' . $command;
		eval($commandredis);

		$gettime->stop();
		$arrtrack[5] = 'complete ('.$gettime->get_exec_time() .'s)';
		$this->Tracking('s3' , true , $arrtrack);
		return $gettime->get_exec_time();*/
	}
	private function getrc3($p,$arr,$redis)
	{
		$rs   = array();
		set_time_limit(0);
		$key   =  'rc3:';

		foreach ( $arr as $k => $value ) {
			if($p<$value)
			{
				$rs[$value] = $redis->get($key.$p.':'.$value);
			}
			else
			{
				$rs[$value] = $redis->get($key.$value.':'.$p)+0;
			}

		}
		unset($rs[$p]);
		arsort($rs);
		return implode(',',array_slice(array_keys($rs),0,100,true));
	}
	function getproductbycategory()
	{
		$redis = new Redis();
		$arr   = array();
		$redis->connect($this->server, 6379);
		$gettime = new timer();
		$strp = $redis->keys('rb:*');
		$arrpro= array();
		foreach($strp as  $key=>$value)
		{
			// lay p_id
			$key = end(explode(':',$value));

			/*
			 * pcid
			 * pa_id1##att1###pa_id2##att2
			 * */
			$giatri = explode('####',$redis->get($value));

			// pa_id1##att1
			$arratt = explode('###',$giatri[1]);

			foreach ( $arratt as $k=>$v ) {
				$arrtmp = explode('##',$v);
				$arr[$giatri[0]][$key] = $key;
			}

			// gan ds sp theo danh muc
		}
		return $arr;
	}



	function rs3($p1)
	{
		$gettime =  new timer();

		$arr	= array();
		set_time_limit(0);
		$redis = new Redis();
		$redis->connect($this->server, 6379);
		$arrkey = $redis->keys('rc3:'.$p1.':*');
		foreach($arrkey as $key=>$item)
		{
				$khoa = explode(':',$item);
				$arr[$khoa[2]] = $redis->get($item);
		}
		$arrkey = $redis->keys('rc3:*:'.$p1);
		foreach($arrkey as $k=>$v)
		{
			$khoa = explode(':',$v);
			$arr[$khoa[1]] = $redis->get($v);
		}
		unset($arr[$p1]);
		arsort($arr);

		$str = implode(',',array_slice(array_keys($arr),0,500,true));
		return $str;
	}





	/*=========================================================getRecommended==================================================================*/

	public function GetRf2($p,$limit,$key = 'rp2:')
	{
		$str    = '';
		$result = array ();
		$redis  = new Redis();
		$redis->connect($this->server , 6379);
		$str    = $redis->get($key . $p);
		if($str!='')
		{
			$arr = explode(',',$str);
			if(count($arr)>=$limit)
			{
				for($i = 0 ; $i<=$limit;$i++)
				{
					$result[$i] = $arr[$i];
				}
				return $result;
			}
			else
				return $arr;

		}
		else
			return '';
	}

	public function GetRf3($p,$limit)
	{

		$str    = '';
		$result = array ();
		$redis  = new Redis();
		$redis->connect($this->server , 6379);
		$str    = $redis->get('rp3:' . $p);
		if($str!='')
		{
			$arr = explode(',',$str);
			if(count($arr)>=$limit)
			{
				for($i = 0 ; $i<=$limit;$i++)
				{
					$result[$i] = $arr[$i];
				}
				return $result;
			}
			else
				return $arr;

		}
		else
			return '';
	}
	public function testuseritemAction()
	{
		$re    = array ();
		$rs    = array ();
		$user  = isset($_GET['user']) ? $_GET['user'] : '';
		$getf  = isset($_GET['getf']) ? $_GET['getf'] : '';
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		if($user!='' && $getf !='')
		{
			$strbuy        = $redis->get('rc4:c' . $user);
			$strbuyexplode = explode('###' , $strbuy);

			$sdt           = $strbuyexplode[0];
			$strproduct    = $strbuyexplode[1];
			$arrproduct	   = explode(',',$strproduct);

			foreach ( $arrproduct as $key=>$val ) {
				$product = new Core_Product($val);

				$re[$key] = $product->name;
			}
			$strrecommand  = $redis->get('ru'.$getf.':c'.$user);

			$arrrecommend  = explode(',',$strrecommand);
			foreach ( $arrrecommend as $k=>$v ) {
				$product = new Core_Product($v);

				$rs[$k] = $product->name;
			}

			echodebug('sdt : '.$sdt);
			echodebug('<b>Danh sach san pham da mua : </b>');
			echodebug($re);
			echodebug('<b>Danh sach san pham recommend : </b>');
			echodebug($rs);
		}
		else
			echo 'thieu doi so';
	}

	public function testneighborAction()
	{
		$result= array();
		$p     = isset($_GET['pro']) ? $_GET['pro'] : '';
		$limit = isset($_GET['li']) ? $_GET['li'] : '';
		$getf  = isset($_GET['getf']) ? $_GET['getf'] : '';
		if($getf=='2')
		{
			if($p!='' && $limit!='')
			{
				$rs = $this->GetRf2($p,$limit);
				if($rs!='')
				{
					foreach($rs as $k=>$v)
					{
						$product = Core_Product::getProducts(array('fid'=>$v),'','');
						$result[$v] = $product[0]->name;
					}
					$product1=Core_Product::getProducts(array('fid'=>$p),'','');
					echodebug('san pham dc recommend : '.$product1[0]->name);
					echodebug($result,true);
				}
			}
			else
			{
				echo 'thieu doi so';
			}
		}
		if($getf=='3')
		{
			if($p!='' && $limit!='')
			{
				$rs = $this->GetRf3($p,$limit);
				if($rs!='')
				{
					foreach($rs as $k=>$v)
					{
						$product = Core_Product::getProducts(array('fid'=>$v),'','');

						$result[$v] = $product[0]->name;
					}
					$product1=Core_Product::getProducts(array('fid'=>$p),'','');
					echodebug('san pham dc recommend : '.$product1[0]->name);
					echodebug($result,true);
				}
			}
			else
			{
				echo 'thieu doi so';
			}
		}
		if($getf=='s2')
		{
			if($p!='' && $limit!='')
			{
				$rs = $this->GetRf2($p,$limit,'rss2n:');
				if($rs!='')
				{
					foreach($rs as $k=>$v)
					{
						$product = Core_Product::getProducts(array('fid'=>$v),'','');

						$result[$v] = $product[0]->name;
					}
					$product1=Core_Product::getProducts(array('fid'=>$p),'','');
					echodebug('san pham dc recommend : '.$product1[0]->name);
					echodebug($result,true);
				}
			}
			else
			{
				echo 'thieu doi so';
			}
		}
	}

	public function getproductofcustomerAction()
	{

	}

	/*===================================================== F4 ============================================================================*/
	/*
	 * get user (customerphone)
	 * ds san pham da mua cua user do
	 * */
	public function rf4Action()
	{
		$redis 		 = new Redis();
		$redis->connect($this->server , 6379);
		$condition   ='`p_barcode` !=  "" ';
		$rs          = $this->getProductByCustomer($condition);

		$i           = 1;
		foreach($rs as $key=>$value)
		{


			if($value!='')
			{
				$val  = $key.'###'.$value;
				$key  ='rc4:c'.$i;

				$redis->set($key,$val);
				$i 	  = $i + 1;
			}
		}
		$arr[] = $i ;
		$this->Tracking('s2',true,$arr);
		$this->Tracking('s3',true,$arr);
		$this->Tracking('s4',true,$arr);
	}
	public function mergekeycustomerAction()
	{
		$redis          = new Redis();
		$redis->connect($this->server , 6379);
		$count = $redis->dbSize();
		echo "Redis has $count keys\n";
	//		$arrkey         =$redis->keys('rf4*');
	//		echodebug($arrkey,true);
	//		foreach ( $arrkey as $key=>$value )
	//		{
	//
	//		}

	}
	public function rs4totalAction($acion = '2')
	{
		set_time_limit(0);
		$redis          = new Redis();
		$redis->connect($this->server , 6379);

		$acion          = isset($_GET['getf']) ? $_GET['getf'] : $acion;
		$str            = '';
		$command        = '';
		$gettime        = new timer();






		switch($acion)
		{
			case '2':
				$gettime->start();
				$RedisRs        = 'rs2:';
				$RedisRsn       = 'rp2:';
				$arrneighbor    = $this->getNeighbor($RedisRsn);
				$arrCoreProduct = array ();
				//ds key customer (rf4)

				$arrKey = $redis->keys('rc4:c*');
				$count  = count($arrKey);
				$this->calpercent($count,100,'s2','proui');
				foreach($arrKey as $key=>$value)
				{
					$this->calpercent($count,100,'s2','proui',$key);
					$val_redis = $redis->get($value);

					/*similar u:p*/
					$result         = $this->calcoref4($val_redis , $acion , $arrCoreProduct , $arrneighbor);

					$arrCore        = $result['core'];
					$arrCoreProduct = $result['coresim'];
					$array_val = explode(':' , $value);
					$khoa = 'rcp2:' . $array_val[1] . ':';


					$dem = 0;

					foreach ( $arrCore as $k=>$v ) {

						$str 	 .= ',' . $k;
						$command .= '->set("' . $khoa . $k . '","' . $v . '")';
						$dem = $dem +1;

					}
					if($command!='')
					{
						$command 		.= '->exec();';
						$commandredis    = '$redis->pipeline()' . $command;
						eval($commandredis);
						$command = '';
					}

					if($str!='')
					{
						$redis->set('ru2:'.$array_val[1],$str);
						$str = '';
					}

					$redis->set('rzntesti2',$key);



				}
				$gettime->stop();
				$arr[7] = $gettime->get_exec_time();
				$this->Tracking('s2',true,$arr);
				return $arr[7];
				break;
			case '3':
				$gettime->start();
				$RedisRs        = 'rc3:';
				$RedisRsn       = 'rp3:';
				$arrneighbor    = $this->getNeighbor($RedisRsn);
				$arrCoreProduct = array();

				$arrKey = $redis->keys('rc4:c*');
				$count  = count($arrKey);
				$this->calpercent($count,100,'s3','proui');
				foreach($arrKey as $key=>$value)
				{
					$this->calpercent($count,100,'s3','proui',$key);
					$val_redis = $redis->get($value);

					/*similar u:p*/
					$result         = $this->calcoref4($val_redis , $acion , $arrCoreProduct , $arrneighbor);

					$arrCore        = $result['core'];
					$arrCoreProduct = $result['coresim'];
					$array_val = explode(':' , $value);
					$khoa = 'rcp3:' . $array_val[1] . ':';

					foreach ( $arrCore as $k=>$v ) {

						$str 	 .= ',' . $k;
						$command .= '->set("' . $khoa . $k . '","' . $v . '")';

					}


					if($command!='')
					{
						$command 		.= '->exec();';
						$commandredis    = '$redis->pipeline()' . $command;
						eval($commandredis);
						$command = '';
					}

					if($str!='')
					{
						$redis->set('ru3:'.$array_val[1],$str);
						$str = '';
					}

					$redis->set('rzntesti',$key);



				}
				$gettime->stop();
				$arr[7] = $gettime->get_exec_time();
				$this->Tracking('s3'.true,$arr);
				return $arr[7];
				break;
		}
	}
	/*
	 * str ds sp cua customer
	 * thuat toan
	 * mang core cua pro
	 * mang neighbor
	 * */
	private function calcoref4($str , $f , $arrp = array() , $arrneighbor )
	{


		$gettime = new timer();
		$gettime->start();
		switch($f)
		{
			case '2':
				$RedisRs  = 'rs2:';
				$RedisRsn = 'rp2:';
				break;
			case '3':
				$RedisRs  = 'rc3:';
				$RedisRsn = 'rp3:';
				break;
			default:
				$RedisRs  = 'rs2:';
				$RedisRsn = 'rp2:';
				break;
		}
		$arrp		 	 = array();
		$rs              = array();
		$command		 = '';
		$result		     = array();
		$core            = array();
		$redis           = new Redis();
		$redis->connect($this->server , 6379);
		$arr = explode('###' , $str);
		/* list san pham mua cua customer */
		$productlist  = explode(',',$arr[1]);
		$count 		  = count($productlist);
		foreach ( $productlist as $key=>$value ) {

			/* kiem tra ton tai trong mang neighbor da lay san */
			if(isset($arrneighbor[$value]))
			{

				/* kiem tra core cua p1:neighbor xem da lay lan nao chua */

				if(!isset($arrp[$value]))
				{
					// tao mang tu danh sach neighbor
					$neighbor     = explode(',',$arrneighbor[$value]);
					foreach($neighbor as $k=>$v)
					{
						// tao key
						$keyRedis            = $value >= $v ? $RedisRs . $v . ':' . $value : $RedisRs . $value . ':' . $v;

						$arrp[$value][$v]    = $redis->get($keyRedis) + 0;

					}

				}
				if($count>1)
				{
					foreach ( $arrp[$value] as $kh=>$gt ) {
						if($arrp[$value][$kh] > 0)
							$rs[$kh] = $rs[$kh] + $arrp[$value][$kh];

					}
				}
				else
					$rs = $arrp[$value];

				arsort($rs);
			}

			$result['core']    = array_slice ($rs, 0, 20,true);;
			$result['coresim'] = $arrp;


		}


		return $result;

	}
	/*
	 * chuoi lay ra tu redis : rf4:c1 =  0909090909###59434,.....
	 * tinh theo f2 or f3
	 * core p:p tu f2 or f3
	 * ds neighnor cua cac san pham
	 * */
	private function _calcoref4($str , $f , $arrp = array() , $arrneighbor )
	{
		$gettime = new timer();
		$arrCoreNbOnePro = array();
		$result		     = array();
		$core            = array();
		$redis           = new Redis();
		$redis->connect($this->server , 6379);
		$arr = explode('###' , $str);
		/* list san pham mua cua customer*/
		$productlist  = explode(',',$arr[1]);

		switch($f)
		{
			case '2':
				$RedisRs  = 'rs2:';
				$RedisRsn = 'rss2n:';
			break;
			case '3':
				$RedisRs  = 'rc3:';
				$RedisRsn = 'rp3:';
			break;
			default:
				$RedisRs  = 'rs2:';
				$RedisRsn = 'rs2n:';
			break;
		}

		$gettime->start();
		foreach($productlist as $key=>$value)
		{
			/* neighbor cua san pham */
			$str_neighbor = $arrneighbor[$value];
			if($str_neighbor!='')
			{
				$neighbor     = explode(',',$str_neighbor);

				foreach($neighbor as $k=>$v)
				{



					/*tao key de glay core cua 2 sp */
					$key        = $value >= $v ? $RedisRs . $v . ':' . $value : $RedisRs . $value . ':' . $v;

					/* lay core xong luu lai */
					$arrp[$key] = isset($arrp[$key]) ? $arrp[$key] : $redis->get($key);

					/* tinh core cua u:p  */
					$core[$v]   = isset($core[$v]) ? $arrp[$key] + $core[$v] : $arrp[$key];

				}
			}
		}

		arsort($core);

		/* gioi han 100 phan tu */
		$core                = array_slice ($core, 0, 500,true);
		$result['core']      = $core;
		$result['coreredis'] = $arrp;


		return $result;
//		return $core;
	}

	/* lay ds neighbor cua tat ca sp */
	private function getNeighbor($strredis)
	{
		$redis       = new Redis();
		$redis->connect($this->server , 6379);
		$arrneighbor = array();
		$productList = $this->getProduct();
		foreach($productList as $key=>$value)
		{
			$arrneighbor[$value] = $redis->get($strredis.$value);
		}
		return $arrneighbor;
	}

	public function getkeyAction()
	{
		$redis       = new Redis();
		$redis->connect($this->server , 6379);
		$key = isset($_GET['key']) && $_GET['key']!='' ? $_GET['key'] : '' ;
		if($key!='')
		{
			echodebug($redis->get($key));
		}
	}
	/*==========================================================  VIEW  ========================================================*/
	//stat  view
	public function statviewAction()
	{
		set_time_limit(0);
		$rs   = array();
		$db3  = Core_Backend_Object::getDb();
		$sql  = "SELECT v_objectid,v_trackingid  FROM lit_view WHERE v_type = 11 AND v_trackingid != '' and v_objectid !=0 AND v_datecreated >='".Helper::strtotimedmy('15/07/2013')."' ORDER BY v_trackingid ";
		$tmp  = $db3->query($sql);
		while ( $row = $tmp->fetch() ) {

			$rs[$row['v_trackingid']][$row['v_objectid']] = 1;

		}
		$count['1']    = 0;
		$count['2']    = 0;
		$count['3']    = 0;
		$count['3:5']  = 0;
		$count['5:10'] = 0;
		$count['11']   = 0;
		foreach ( $rs as $key=>$value ) {
			$dem = count($value) ;

			if ( $dem == 1 ) {
				$count['1'] = $count['1'] + 1;
			}
			elseif ( $dem == 2 ) {
				$count['2'] = $count['2'] + 1;
			}
			elseif ( $dem == 3 ) {
				$count['3'] = $count['3'] + 1;
			}
			elseif ( $dem > 3 && $dem <= 5 ) {
				$count['3:5'] = $count['3:5'] + 1;
			}
			elseif ( $dem > 5 && $dem <= 10 ) {
				$count['5:10'] = $count['5:10'] + 1;
			}
			elseif( $dem > 10) {
				$count['11'] = $count['11'] + 1;
			}
		}
		$total = 0;
		foreach ( $count as $k=>$v ) {
			$total += $v;

		}

		echodebug($count);
		echodebug($total);
	}
	public function getview($arrPro)
	{
		set_time_limit(0);
		$rs   = array();
		$redis= new Redis();
		$redis->connect($this->server,6379);
		$db3  = Core_Backend_Object::getDb();
		$sql  = "SELECT v_objectid,v_trackingid  FROM lit_view WHERE v_type = 11 AND v_trackingid != '' and v_objectid !=0 AND v_datecreated >='".Helper::strtotimedmy('15/07/2013')."' ORDER BY v_trackingid ";
		$tmp  = $db3->query($sql);
		while ( $row = $tmp->fetch() ) {
			if(in_array($row['v_objectid'],$arrPro))
				$rs[$row['v_trackingid']][] = $row['v_objectid'];

		}
		foreach ( $rs as $key=>$value ) {
			$redis->set('rvcount:'.$key,implode("," , $value));
//			if(count($value)<2)
//				unset($rs[$key]);
		}
		return $rs;
	}
	// tinh score cung view cua 2 sp
	public function previewAction()
	{


		$redis   = new Redis();
		$redis->connect($this->server , 6379);
		$gettime = new timer();
		$gettime->start();
		$condition = '`p_barcode` !=  "" ';
		$arrPro    = $this->getProduct($condition);
		$result    = $this->getview($arrPro);
		$rs[]      = count($result);
		$rs[]      = count($arrPro);
		$rs[]	   = time();
		$this->Tracking('s5' , true , $rs);


		$rs = array();
		// cal core view 2 product
		foreach ( $result as $key => $value ) {

			$rs     = $this->preViewinsertRedis($value , $rs);

		}
		foreach($rs as $k=>$v)
		{
			$redis->set('rv:'.$k,$v);
		}
		$gettime->stop();
		$rs[3]  = 'complete ('.$gettime->get_exec_time().')';
		$this->Tracking('s5',true,$rs);
		$this->simviewAction();
	}

	private function getview_()
	{
		$db3  = Core_Backend_Object::getDb();
		$arr  = array ();
		$arr2 = array ();
		$sql  = "SELECT v_objectid,v_trackingid  FROM lit_view WHERE v_type = 11 AND v_trackingid != '' and v_objectid !=0 ORDER BY v_trackingid ";
		$sql2 = "SELECT v_trackingid, COUNT(v_trackingid) as DEM FROM lit_view WHERE v_type =11 AND v_trackingid !=  '' AND v_objectid !=0 GROUP BY v_trackingid HAVING DEM >1";
		$tmp  = $db3->query($sql);
		// list page view/user
		while ( $row = $tmp->fetch() ) {


			if(!isset($arr[$row['v_trackingid']]))
				$arr[$row['v_trackingid']] .=  $row['v_objectid'];
			else
				$arr[$row['v_trackingid']] .=  ',' . $row['v_objectid'];
		}

		// list user view >  2 product
		$tmp2 = $db3->query($sql2);
		$itemtmp = 0;
		while ( $row = $tmp2->fetch() ) {

			$arr2[$row['v_trackingid']] = $row['DEM'];

		}
		$rs['list']  = $arr;
		$rs['count'] = $arr2;
		return $rs;
	}

	private function preViewinsertRedis($arr,$rs)
	{

		asort($arr);
		$count = count($arr);
		if($count>1)
		{
			for($i = 0 ; $i < $count ; $i++)
			{
				for($j = $i + 1 ; $j < $count ; $j++)
				{

					$rs[$arr[$i].':'.$arr[$j]] = $rs[$arr[$i].':'.$arr[$j]] + 1;

				}
				unset($rs[$arr[$i].':'.$arr[$i]]);
			}
		}

		return $rs;
	}

 	public function simviewAction()
	{
		set_time_limit(0);
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		$gettime =  new timer();

		$gettime->start();
		$condition   ='`p_barcode` !=  "" ';
		$arrPro      = $this->getProduct($condition);
		$arrExt    	 = array();

		foreach ( $arrPro as $k=>$v ) {
			$arrExt[$v] = 0;
		}

		$arrKey = $redis->keys('rv:*');
		$arr    = array();
		foreach ( $arrKey as $key=>$value ) {

			$key = explode(':',$value);
			if($key[1]!='' && $key[1]!='0')
				$arr[$key[1]][$key[2]]  =  $arr[$key[2]][$key[1]]=  $redis->get($value);

		}

		ksort($arr);
		$arrKey = array_keys($arr);
		$count  = count($arrKey);
		$this->calpercent($count,100,'s5','prosi');
		for ( $i = 0;$i < $count;$i++ ) {
			$this->calpercent($count,100,'s5','prosi',$i);
			$command = '';
			$key     = 'rsv:' . $arrKey[$i] . ':';
			$p1      = $arr[$arrKey[$i]] + $arrExt;
			$redis->set('rsvtestvaluei',$i);
			unset($arr[$arrKey[$i]]);
			for ( $j = $i + 1 ; $j < $count; $j++ ) {

				$core = DataMining::cosineSimilarity($p1 , $arr[$arrKey[$j]] + $arrExt );
				if($core>0)
					$command .= '->set("' . $key . $arrKey[$j] . '","' . $core . '")';

			}

			if($command!='')
			{
				$command 		.= '->exec();';
				$commandredis    = '$redis->pipeline()' . $command;
				eval($commandredis);

			}
		}

		$gettime->stop();
		$rs[4]  = 'complete ('.$gettime->get_exec_time().')';
		$this->Tracking('s5',true,$rs);
	//	$this->itemitemviewAction();



	}

	public function itemitemviewAction()
	{
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		$arr     = array();
		$rs      = array();
		$gettime = new timer();
		$gettime->start();
		$condition   ='`p_barcode` !=  "" ';
		$arrPro      = $this->getProduct($condition);
		$count  	 = count($arrPro);
		$arrkey = $redis->keys('rsv:*');
		foreach ( $arrkey as $key=>$value ) {
			$keys = explode(':',$value);
			$arr[$keys[1]][$keys[2]] = $arr[$keys[2]][$keys[1]] = $redis->get($value);
		}
		foreach ( $arr as $khoa=>$giatri ) {
			arsort($giatri);
			$v = implode(',',array_slice(array_keys($giatri),0,50,true));
			$redis->set('rnv:'.$khoa,$v);
		}
		$gettime->stop();
		$rs[5]  = 'complete ('.$gettime->get_exec_time().')';
		$this->Tracking('s5',true,$rs);
		$this->useritemviewAction();

	}

	public function useritemviewAction()
	{


		set_time_limit(0);
		$gettime = new timer();
		$redis   = new Redis();
		$redis->connect($this->server , 6379);

		$arrCore = array ();
		$gettime->start();
		$condition   ='`p_barcode` !=  "" ';
		$arrPro      = $this->getProduct($condition);
		// $rs[trackingid] = arr[pid] = countview(pid)
		$rs    		 = $this->getview($arrPro);

		// arrkey[]  = trackingid
		$arrkey 	 = array_keys($rs);


		$arrCore 	 = $this->getcoreview();
		$count 		 = count($arrkey);
		$arrNeighbor = $this->getNeighborView();
		$command = '';
		$this->calpercent($count,100,'s5','proui');
		for ( $i = 0 ; $i < $count ; $i++ ) {
			$this->calpercent($count,100,'s5','proui',$i);
			$redis->set('rv:c'.$i,$arrkey[$i].'###'.implode(',',array_keys($rs[$arrkey[$i]])));
			$result= $this->calcoreview($rs[$arrkey[$i]],$arrNeighbor,$arrCore);
			$list  = $result['list'];
			$core  = $result['core'];
			if(is_array($core))
			{
				foreach ( $core as $k=>$v ) {

					$command .= '->set("rcv:' . $arrkey[$i] . ':' . $k . '","' . $v . '")';

				}
				if($command!='')
				{
					$redis->set('ruiv:'.$arrkey[$i],$list);
					$command 		.= '->exec();';
					$commandredis    = '$redis->pipeline()' . $command;
					eval($commandredis);
					$command = '';
				}
			}

		}

		$gettime->stop();
		$arrs5 = $this->Tracking('s5',false);
		$arayredis[7]  = 'complete ('.$gettime->get_exec_time().')';
		$arayredis[8]  = time() -$arrs5[2];
		$arayredis[9]  = time();
		$this->Tracking('s5',true,$arayredis);
	}

	private function getcoreview()
	{
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		$arr  = array();
		$key  = $redis->keys('rsv*');
		foreach ( $key as $k=>$v ) {
			$arrkey  =  explode(':',$v);
			$arr[$arrkey[1]][$arrkey[2]] = $arr[$arrkey[2]][$arrkey[1]] = $redis->get($v);
		}
		return $arr;
	}

	private function getNeighborView()
	{
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		$arr  = array();
		$key  = $redis->keys('rnv*');
		foreach ( $key as $k=>$v ) {
			$arr[end(explode(':' , $v))] = $redis->get($v);
		}
		return $arr;
	}

	private function calcoreview($arrPro,$arrNeighbor,$arrCore)
	{
		//59672
		$redis = new Redis();
		$redis->connect($this->server , 6379);
		$arrPro = array_keys($arrPro);
		$count  = count($arrPro);
		$result= array();
		$tmparr= array();
		if($count>1)
		{

			foreach ( $arrPro as $key=>$value ) {
				$neighbor = explode(',',$arrNeighbor[$value]);
				foreach ( $neighbor as $k=>$v ) {
					$rs = $arrCore[$v];
					foreach ( $rs as $khoa=>$giatri ) {
						if($khoa!='')
							$tmparr[$khoa] = $tmparr[$khoa] + $giatri;
					}

				}


			}

			arsort($tmparr);
			$result['core'] = array_slice($tmparr,0,50,true);
			$result['list'] = implode(',',array_keys($tmparr));
		}
		else
		{

			@arsort($arrCore[$arrPro[0]]);
			$result['core'] = $arrCore[$arrPro[0]];
			$result['list'] = $arrNeighbor[$arrPro[0]];
		}

		return $result;
	}
}





