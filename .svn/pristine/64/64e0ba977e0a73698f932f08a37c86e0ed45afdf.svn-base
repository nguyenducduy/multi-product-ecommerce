<?php
ini_set('memory_limit','1260M');
Class Controller_Cron_Reporting Extends Controller_Cron_Base
{
	function indexAction()
	{
		set_time_limit(0);
		$starttime = time();

		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));//strtotime('-1 month')
		$enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());//time());

		$countsql = 0;
		//Dieu kien tong the (ROOT) o_originatestoreid: input store

		$dt = $startdate;

		$counterorder = 0;
		$counterorderdetail = 0;

		while ($dt <= $enddate)
		{
			$listorderdate = array();
			$listorderdetaildate = array();

			$listproductorderdetail = array();
			$listoutputstore = array();
			$listinputstore = array();
			$listregion = array();
			$listoutputtype = array();

			$totalproductorderdetail = array();
			$totaloutputstore = array();
			$totalinputstore = array();
			$totalregion = array();
			$totaloutputtype = array();

			$localDateBegin = mktime(0,0,0,date('m', $dt), date('d', $dt), date('Y', $dt));
			$localDateEnd = mktime(23,23,59,date('m', $dt), date('d', $dt), date('Y', $dt));
			$counter = $this->registry->db->query('SELECT count(*) FROM '.TABLE_PREFIX.'archivedorder WHERE o_iscomplete = '.Core_Archivedorder::STATUS_COMPLETE.' AND o_createdate >='.$localDateBegin.' AND o_createdate <'.$localDateEnd)->fetchColumn(0);

			if ($counter > 0)
			{
				$counter++;
				$limit = 10;
				for ($offset = 0; $offset < $counter; $offset+=$limit)
				{
					//loop theo tung ngay
					$sqlorder = 'SELECT o_id,
									o_ordertypeid,
									o_customername,
									o_provinceid,
									o_totalquantity,
									o_vouchertypeid,
									o_voucherconcern,
									o_totalpaid,
									o_outputstoreid,
									o_outputstoreregionid,
									o_outputstoreid,
									o_originatestoreid,
									o_pointpaid
							FROM '.TABLE_PREFIX.'archivedorder
							WHERE o_iscomplete = '.Core_Archivedorder::STATUS_COMPLETE.' AND o_createdate >='.$localDateBegin.'
								  AND o_createdate <'.$localDateEnd.' LIMIT '.$offset.','.$limit;

					$stmt = $this->registry->db->query($sqlorder);

					while($row = $stmt->fetch())
					{
						$listorderdate[$dt][$row['o_id']] = $row;

						$counterorder++;
						$sqlorderdetail = 'SELECT o_orderid,
										  od_saleprice,
										  od_quantity,
										  od_outputtypeid,
										  od_inputvoucherdetailid,
										  od_buyinputvoucherid,
										  od_costprice,
										  od_subtotalvat,
										  od_subprofit,
										  od_productid
									FROM '.TABLE_PREFIX.'archivedorder_detail
									WHERE o_orderid = '.(int)$row['o_id'];
						$stmt1 = $this->registry->db->query($sqlorderdetail);

						/*if (!empty($totalproductorderdetail[$dt][$row['o_outputstoreid']]))
						{
							$totalproductorderdetail[$dt][$row['o_outputstoreid']]++;
						}
						else $totalproductorderdetail[$dt][$row['o_outputstoreid']] = 1;
						*/
						if (!empty($totaloutputstore[$dt][$row['o_outputstoreid']]))
						{
							$totaloutputstore[$dt][$row['o_outputstoreid']]++;
						}
						else $totaloutputstore[$dt][$row['o_outputstoreid']] = 1;

						if (!empty($totalinputstore[$dt][$row['o_outputstoreid']]))
						{
							$totalinputstore[$dt][$row['o_outputstoreid']]++;
						}
						else $totalinputstore[$dt][$row['o_outputstoreid']] = 1;

						if (!empty($totalregion[$dt][$row['o_outputstoreid']]))
						{
							$totalregion[$dt][$row['o_outputstoreid']]++;
						}
						else $totalregion[$dt][$row['o_outputstoreid']] = 1;

						if (!empty($totalordertype[$dt][$row['o_outputstoreid']]))
						{
							$totalordertype[$dt][$row['o_outputstoreid']]++;
						}
						else $totalordertype[$dt][$row['o_outputstoreid']] = 1;

						while($row2 = $stmt1->fetch())
						{
							$listorderdetaildate[$dt][$row['o_id']][] = $row2;

							$pbarcode = trim($row2['od_productid']);
							$listproductorderdetail[$dt][$pbarcode][] = $row2;
							$listoutputstore[$dt][$row['o_outputstoreid']][] = $row2;
							$listinputstore[$dt][$row['o_originatestoreid']][] = $row2;
							$listregion[$dt][$row['o_provinceid']][] = $row2;
							$listoutputtype[$dt][$row['o_ordertypeid']][] = $row2;
							$counterorderdetail++;
							unset($row2);
						}
						unset($stmt1);
						unset($row);
					}
					unset($stmt);
				}
			}

			if (!empty($listorderdate))
			{
				foreach($listorderdate as $datekey => $orders)
				{
					$datevalue = date('Y/m/d', $datekey);
					$totalsaleitemvalue = 0;
					$totalsaleitemvolume = 0;
					$totalprofititem = 0;
					$totalpaid = 0;

					foreach ( $orders as $oid => $myorder)
					{
						if (!empty($listorderdetaildate[$datekey][$myorder['o_id']]))
						{
							$orderdetails = $listorderdetaildate[$datekey][$myorder['o_id']];
							foreach ($orderdetails as $myorderdetail)
							{
								$totalsaleitemvalue += $myorderdetail['od_subtotalvat'];
								$totalsaleitemvolume += $myorderdetail['od_quantity'];
								$totalprofititem += $myorderdetail['od_subprofit'];
							}
							$totalpaid += $myorder['o_totalpaid'];
						}
					}
					//Luu  value theo don hang khong co dieu kien (Root)
					Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VALUE, array(), $datevalue, $totalpaid);
					Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array(), $datevalue, count($orders));
					Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array(), $datevalue, $totalsaleitemvalue);
					Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array(), $datevalue, $totalsaleitemvolume);
					Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array(), $datevalue, $totalprofititem);

					//echodebug('ROOT: '.$totalpaid.' - '.count($orders).' - '.$totalsaleitemvalue.' - '.$totalsaleitemvolume.' - '.$totalprofititem);
					//---END Luu  value theo don hang khong co dieu kien---

					//---Luu value theo product id, vendoer product category, category
					if (!empty($listproductorderdetail[$datekey]))
					{
						$listpcids = array();
						$listvendorids = array();

						$categoryvendor = array();

						$totalordercategory = array();
						//product root
						foreach ($listproductorderdetail[$datekey] as $pbarcode => $orderdetails)
						{
							$myProduct = Core_Product::getProductIDByBarcode($pbarcode);

							if (!empty($myProduct) && $myProduct['p_id'] > 0)
							{
								$productitemvol = 0;
								$productitemrev = 0;
								$productitemprof = 0;
								$listpcids[$myProduct['pc_id']]['counter'] = 0;
								$listpcids[$myProduct['pc_id']]['quantity'] = 0;
								$listpcids[$myProduct['pc_id']]['revenue'] = 0;
								$listpcids[$myProduct['pc_id']]['profit'] = 0;

								$listvendorids[$myProduct['v_id']]['counter'] = 0;
								$listvendorids[$myProduct['v_id']]['quantity'] = 0;
								$listvendorids[$myProduct['v_id']]['revenue'] = 0;
								$listvendorids[$myProduct['v_id']]['profit'] = 0;

								$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['counter'] = 0;
								$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['quantity'] = 0;
								$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['revenue'] = 0;
								$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['profit'] = 0;

								if (!empty($orderdetails))
								{
									foreach ($orderdetails as $myoderdetail)
									{
										$productitemvol 	+= $myoderdetail['od_quantity'];
										$productitemrev 	+= $myoderdetail['od_subtotalvat'];
										$productitemprof 	+= $myoderdetail['od_subprofit'];

										$listpcids[$myProduct['pc_id']]['counter']++;
										$listpcids[$myProduct['pc_id']]['quantity'] += $myoderdetail['od_quantity'];
										$listpcids[$myProduct['pc_id']]['revenue'] += $myoderdetail['od_subtotalvat'];
										$listpcids[$myProduct['pc_id']]['profit'] += $myoderdetail['od_subprofit'];

										$listvendorids[$myProduct['v_id']]['counter']++;
										$listvendorids[$myProduct['v_id']]['quantity'] += $myoderdetail['od_quantity'];
										$listvendorids[$myProduct['v_id']]['revenue'] += $myoderdetail['od_subtotalvat'];
										$listvendorids[$myProduct['v_id']]['profit'] += $myoderdetail['od_subprofit'];

										$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['counter']++;
										$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['quantity'] += $myoderdetail['od_quantity'];
										$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['revenue'] += $myoderdetail['od_subtotalvat'];
										$categoryvendor[$myProduct['pc_id']][$myProduct['v_id']]['profit'] += $myoderdetail['od_subprofit'];
									}
								}
								//echodebug('ROOT product: '.$totalpaid.' - '.$productitemvol.' - '.$productitemrev.' - '.$productitemprof);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('product' => $myProduct['p_id']), $datevalue, $productitemvol);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('product' => $myProduct['p_id']), $datevalue, $productitemrev);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('product' => $myProduct['p_id']), $datevalue, $productitemprof);
							}
						}

						//category root, vendor root
						if (!empty($listpcids))
						{
							foreach ($listpcids as $pcid => $startpcid)
							{
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('category' => $pcid), $datevalue, $startpcid['counter']);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('category' => $pcid), $datevalue, $startpcid['quantity']);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('category' => $pcid), $datevalue, $startpcid['revenue']);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('category' => $pcid), $datevalue, $startpcid['profit']);

								//echodebug('ROOT category: '.print_r($startpcid, 1));
							}
							foreach ($listvendorids as $vid => $startvid)
							{
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('vendor' => $vid), $datevalue, $startvid['counter']);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('vendor' => $vid), $datevalue, $startvid['quantity']);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('vendor' => $vid), $datevalue, $startvid['revenue']);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('vendor' => $vid), $datevalue, $startvid['profit']);
								//echodebug('ROOT Vendor: '.print_r($startvid, 1));
							}
						}

						//vendor category
						if (!empty($categoryvendor))
						{
							//loop vendor and category
							foreach ($categoryvendor as $pcid=>$vendorpcid)
							{
								foreach ($vendorpcid as $vid => $vpcids)
								{
									Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('vendor' => $vid, 'category' => $pcid), $datevalue, $vpcids['counter']);
									Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('vendor' => $vid, 'category' => $pcid), $datevalue, $vpcids['quantity']);
									Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('vendor' => $vid, 'category' => $pcid), $datevalue, $vpcids['revenue']);
									Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('vendor' => $vid, 'category' => $pcid), $datevalue, $vpcids['revenue']);
									//echodebug('ROOT Vendor category: '.print_r($vpcids, 1));
								}
							}
						}

						//outputstore list root, category outputstire, product output store
						if (!empty($listoutputstore[$datekey]))
						{
							$categorystores = array();
							$productstores = array();
							foreach ($listoutputstore[$datekey] as $osid => $ostore)
							{
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputstore' => $osid), $datevalue, $totalinputstore[$datekey][$osid]);

								$totalsaleitemvalue = 0;
								$totalsaleitemvolume = 0;
								$totalprofititem = 0;

								foreach ($ostore as $myoderdetail)
								{
									$myProduct = Core_Product::getProductIDByBarcode(trim($myoderdetail['od_productid']));
									if (!empty($myProduct) && $myProduct['p_id'] > 0)
									{
										if (empty($categorystores[$myProduct['pc_id']][$osid]['counter']))
											$categorystores[$myProduct['pc_id']][$osid]['counter'] = 0;
										if (empty($categorystores[$myProduct['pc_id']][$osid]['profit']))
											$categorystores[$myProduct['pc_id']][$osid]['profit'] = 0;

										if (empty($categorystores[$myProduct['pc_id']][$osid]['revenue']))
											$categorystores[$myProduct['pc_id']][$osid]['revenue'] = 0;

										if (empty($categorystores[$myProduct['pc_id']][$osid]['quantity']))
											$categorystores[$myProduct['pc_id']][$osid]['quantity'] = 0;

										$categorystores[$myProduct['pc_id']][$osid]['counter']++;//category theo storeid
										$categorystores[$myProduct['pc_id']][$osid]['quantity'] += $myoderdetail['od_quantity'];
										$categorystores[$myProduct['pc_id']][$osid]['revenue'] += $myoderdetail['od_subtotalvat'];
										$categorystores[$myProduct['pc_id']][$osid]['profit'] += $myoderdetail['od_subprofit'];

										//product store
										if (empty($productstores[$osid][$myProduct['p_id']]['counter']))
											$productstores[$osid][$myProduct['p_id']]['counter'] = 0;
										if (empty($productstores[$osid][$myProduct['p_id']]['profit']))
											$productstores[$osid][$myProduct['p_id']]['profit'] = 0;

										if (empty($productstores[$osid][$myProduct['p_id']]['revenue']))
											$productstores[$osid][$myProduct['p_id']]['revenue'] = 0;

										if (empty($productstores[$osid][$myProduct['p_id']]['quantity']))
											$productstores[$osid][$myProduct['p_id']]['quantity'] = 0;

										$productstores[$osid][$myProduct['p_id']]['counter']++;//category theo storeid
										$productstores[$osid][$myProduct['p_id']]['quantity'] += $myoderdetail['od_quantity'];
										$productstores[$osid][$myProduct['p_id']]['revenue'] += $myoderdetail['od_subtotalvat'];
										$productstores[$osid][$myProduct['p_id']]['profit'] += $myoderdetail['od_subprofit'];

									}

									//root
									$totalsaleitemvolume += $myoderdetail['od_quantity'];
									$totalsaleitemvalue += $myoderdetail['od_subtotalvat'];
									$totalprofititem += $myoderdetail['od_subprofit'];
								}

								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('outputstore' => $osid), $datevalue, $totalsaleitemvalue);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputstore' => $osid), $datevalue, $totalsaleitemvolume);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('outputstore' => $osid), $datevalue, $totalprofititem);

								//echodebug('ROOT outputstore: '.$totalinputstore[$datekey][$osid].' - '.$totalsaleitemvalue.' '.$totalsaleitemvolume.' '.$totalprofititem);
							}

							if (!empty($categorystores))
							{
								foreach ($categorystores as $pcid => $orderinfo)
								{
									foreach ($orderinfo as $sid => $valueod)
									{
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['counter']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('outputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['quantity']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['revenue']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('outputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['profit']);
										//echodebug('ROOT category store: '.print_r($valueod,  1));
									}
								}
							}
							unset($categorystores);

							if (!empty($productstores))
							{
								foreach ($productstores as $sid => $orderinfo)
								{
									foreach ($orderinfo as $pid => $valueod)
									{
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputstore' => $sid, 'product' => $pid), $datevalue, $valueod['counter']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('outputstore' => $sid, 'product' => $pid), $datevalue, $valueod['quantity']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputstore' => $sid, 'product' => $pid), $datevalue, $valueod['revenue']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('outputstore' => $sid, 'product' => $pid), $datevalue, $valueod['profit']);
										//echodebug('ROOT product store: '.print_r($valueod,  1));
									}
								}
							}
							unset($productstores);
						}

						//inputstore list root, category inputstire, product inputstore
						if (!empty($listinputstore[$datekey]))
						{
							$categoryinputstores = array();
							$productstores = array();
							foreach ($listinputstore[$datekey] as $osid => $ostore)
							{
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputstore' => $osid), $datevalue, $totalinputstore[$datekey][$osid]);

								$totalsaleitemvalue = 0;
								$totalsaleitemvolume = 0;
								$totalprofititem = 0;

								foreach ($ostore as $myoderdetail)
								{
									$myProduct = Core_Product::getProductIDByBarcode(trim($myoderdetail['od_productid']));
									if (!empty($myProduct) && $myProduct['p_id'] > 0)
									{
										if (empty($categoryinputstores[$myProduct['pc_id']][$osid]['counter']))
											$categoryinputstores[$myProduct['pc_id']][$osid]['counter'] = 0;
										if (empty($categoryinputstores[$myProduct['pc_id']][$osid]['profit']))
											$categoryinputstores[$myProduct['pc_id']][$osid]['profit'] = 0;

										if (empty($categoryinputstores[$myProduct['pc_id']][$osid]['revenue']))
											$categoryinputstores[$myProduct['pc_id']][$osid]['revenue'] = 0;

										if (empty($categoryinputstores[$myProduct['pc_id']][$osid]['quantity']))
											$categoryinputstores[$myProduct['pc_id']][$osid]['quantity'] = 0;

										$categoryinputstores[$myProduct['pc_id']][$osid]['counter']++;//category theo storeid
										$categoryinputstores[$myProduct['pc_id']][$osid]['quantity'] += $myoderdetail['od_quantity'];
										$categoryinputstores[$myProduct['pc_id']][$osid]['revenue'] += $myoderdetail['od_subtotalvat'];
										$categoryinputstores[$myProduct['pc_id']][$osid]['profit'] += $myoderdetail['od_subprofit'];

										//product store
										if (empty($productstores[$osid][$myProduct['p_id']]['counter']))
											$productstores[$osid][$myProduct['p_id']]['counter'] = 0;
										if (empty($productstores[$osid][$myProduct['p_id']]['profit']))
											$productstores[$osid][$myProduct['p_id']]['profit'] = 0;

										if (empty($productstores[$osid][$myProduct['p_id']]['revenue']))
											$productstores[$osid][$myProduct['p_id']]['revenue'] = 0;

										if (empty($productstores[$osid][$myProduct['p_id']]['quantity']))
											$productstores[$osid][$myProduct['p_id']]['quantity'] = 0;

										$productstores[$osid][$myProduct['p_id']]['counter']++;//category theo storeid
										$productstores[$osid][$myProduct['p_id']]['quantity'] += $myoderdetail['od_quantity'];
										$productstores[$osid][$myProduct['p_id']]['revenue'] += $myoderdetail['od_subtotalvat'];
										$productstores[$osid][$myProduct['p_id']]['profit'] += $myoderdetail['od_subprofit'];

									}

									//Root
									$totalsaleitemvolume += $myoderdetail['od_quantity'];
									$totalsaleitemvalue += $myoderdetail['od_subtotalvat'];
									$totalprofititem += $myoderdetail['od_subprofit'];

									//
								}

								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('inputstore' => $osid), $datevalue, $totalsaleitemvalue);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('inputstore' => $osid), $datevalue, $totalsaleitemvolume);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('inputstore' => $osid), $datevalue, $totalprofititem);
								//echodebug('ROOT input store: '.$totalsaleitemvalue);
							}

							if (!empty($categoryinputstores))
							{
								foreach ($categoryinputstores as $pcid => $orderinfo)
								{
									foreach ($orderinfo as $sid => $valueod)
									{
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('inputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['counter']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('inputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['quantity']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('inputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['revenue']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('inputstore' => $sid, 'category' => $pcid), $datevalue, $valueod['profit']);
										//echodebug('ROOT product store: '.print_r($valueod,  1));

									}
								}
							}
							unset($categoryinputstores);

							if (!empty($productstores))
							{
								foreach ($productstores as $sid => $orderinfo)
								{
									foreach ($orderinfo as $pid => $valueod)
									{
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('inputstore' => $sid, 'product' => $pid), $datevalue, $valueod['counter']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('inputstore' => $sid, 'product' => $pid), $datevalue, $valueod['quantity']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('inputstore' => $sid, 'product' => $pid), $datevalue, $valueod['revenue']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('inputstore' => $sid, 'product' => $pid), $datevalue, $valueod['profit']);
										//echodebug('ROOT product store: '.print_r($valueod,  1));
									}
								}
							}
							unset($productstores);
						}

						//output type rooot, category outputtype, product outputtype
						if (!empty($listoutputtype[$datekey]))
						{
							$categoryoutputtype = array();
							$productoutputtype = array();
							foreach ($listoutputtype[$datekey] as $opid => $orderdetails)
							{
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputtype' => $opid), $datevalue, $totaloutputtype[$datekey][$opid]);

								$totalsaleitemvalue = 0;
								$totalsaleitemvolume = 0;
								$totalprofititem = 0;

								foreach ($orderdetails as $myoderdetail)
								{
									$myProduct = Core_Product::getProductIDByBarcode(trim($myoderdetail['od_productid']));
									if (!empty($myProduct) && $myProduct['p_id'] > 0)
									{
										$totalsaleitemvolume += $myoderdetail['od_quantity'];
										$totalsaleitemvalue += $myoderdetail['od_subtotalvat'];
										$totalprofititem += $myoderdetail['od_subprofit'];

										if (empty($categoryoutputtype[$myProduct['pc_id']][$opid]['counter']))
											$categoryoutputtype[$myProduct['pc_id']][$opid]['counter'] = 0;
										if (empty($categoryoutputtype[$myProduct['pc_id']][$opid]['profit']))
											$categoryoutputtype[$myProduct['pc_id']][$opid]['profit'] = 0;

										if (empty($categoryoutputtype[$myProduct['pc_id']][$opid]['revenue']))
											$categoryoutputtype[$myProduct['pc_id']][$opid]['revenue'] = 0;

										if (empty($categoryoutputtype[$myProduct['pc_id']][$opid]['quantity']))
											$categoryoutputtype[$myProduct['pc_id']][$opid]['quantity'] = 0;

										$categoryoutputtype[$myProduct['pc_id']][$opid]['counter']++;//category theo storeid
										$categoryoutputtype[$myProduct['pc_id']][$opid]['quantity'] += $myoderdetail['od_quantity'];
										$categoryoutputtype[$myProduct['pc_id']][$opid]['revenue'] += $myoderdetail['od_subtotalvat'];
										$categoryoutputtype[$myProduct['pc_id']][$opid]['profit'] += $myoderdetail['od_subprofit'];

										//product store
										if (empty($productoutputtype[$opid][$myProduct['p_id']]['counter']))
											$productoutputtype[$opid][$myProduct['p_id']]['counter'] = 0;
										if (empty($productoutputtype[$opid][$myProduct['p_id']]['profit']))
											$productoutputtype[$opid][$myProduct['p_id']]['profit'] = 0;

										if (empty($productoutputtype[$opid][$myProduct['p_id']]['revenue']))
											$productoutputtype[$opid][$myProduct['p_id']]['revenue'] = 0;

										if (empty($productoutputtype[$opid][$myProduct['p_id']]['quantity']))
											$productoutputtype[$opid][$myProduct['p_id']]['quantity'] = 0;

										$productoutputtype[$opid][$myProduct['p_id']]['counter']++;//category theo storeid
										$productoutputtype[$opid][$myProduct['p_id']]['quantity'] += $myoderdetail['od_quantity'];
										$productoutputtype[$opid][$myProduct['p_id']]['revenue'] += $myoderdetail['od_subtotalvat'];
										$productoutputtype[$opid][$myProduct['p_id']]['profit'] += $myoderdetail['od_subprofit'];
									}
									//Root
									$totalsaleitemvolume += $myoderdetail['od_quantity'];
									$totalsaleitemvalue += $myoderdetail['od_subtotalvat'];
									$totalprofititem += $myoderdetail['od_subprofit'];
								}

								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('outputtype' => $opid), $datevalue, $totalsaleitemvalue);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputtype' => $opid), $datevalue, $totalsaleitemvolume);
								Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('outputtype' => $opid), $datevalue, $totalprofititem);
								//echodebug('ROOT Outputtype: '.$totalsaleitemvalue);
							}
							if (!empty($categoryoutputtype))
							{
								foreach ($categoryoutputtype as $pcid => $orderinfo)
								{
									foreach ($orderinfo as $opid => $valueod)
									{
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputtype' => $opid, 'category' => $pcid), $datevalue, $valueod['counter']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('outputtype' => $opid, 'category' => $pcid), $datevalue, $valueod['quantity']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputtype' => $opid, 'category' => $pcid), $datevalue, $valueod['revenue']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('outputtype' => $opid, 'category' => $pcid), $datevalue, $valueod['profit']);
										//echodebug('ROOT Outputtype category: '.print_r($valueod,  1));
									}
								}
							}
							unset($categoryinputstores);

							if (!empty($productoutputtype))
							{
								foreach ($productoutputtype as $opid => $orderinfo)
								{
									foreach ($orderinfo as $pid => $valueod)
									{
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array('outputtype' => $opid, 'product' => $pid), $datevalue, $valueod['counter']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, array('outputtype' => $opid, 'product' => $pid), $datevalue, $valueod['quantity']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputtype' => $opid, 'product' => $pid), $datevalue, $valueod['revenue']);
										Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, array('outputtype' => $opid, 'product' => $pid), $datevalue, $valueod['profit']);
										//echodebug('ROOT Outputtype product: '.print_r($valueod,  1));
									}
								}
							}
							unset($productoutputtype);
						}
					}
				}
			}

			unset($listorderdate);
			unset($listorderdate);
			unset($listorderdetaildate);

			unset($listproductorderdetail);
			unset($listoutputstore);
			unset($listinputstore);
			unset($listregion);
			unset($listoutputtype);

			unset($totalproductorderdetail);
			unset($totaloutputstore);
			unset($totalinputstore);
			unset($totalregion);
			unset($totaloutputtype);

			$dt = strtotime('+1 day', $dt);
			//sleep(10);
		}
		//echodebug($listorderdate, true);

		echo '<p> Time: '.(time() - $starttime). ' order:  '.$counterorder.' orderdetail:  '.$counterorderdetail.'</p>';
	}
}