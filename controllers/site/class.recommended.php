<?php
ini_set("memory_limit", "1024M");

Class Controller_Site_Recommended Extends Controller_Site_Base
{
    public function indexAction()
    {
        echo 'Recommended Page for Test';
    }

    //*****product lay tu bang product

    public function orderrecommAction()
    {
        //*****danh index cho 2 field o_orderid & p_id trong table archivedorderdetails de chay nhanh hon
        $recordPerPage = 1;
        $total = Core_Product::getProducts(array('fonsitestatus' => Core_Product::OS_ERP), '', '', '', true);
        $totalPage = ceil($total / $recordPerPage);
        $datecreated = time();
        $count = 0; //bien nay de kiem tra xem co chay het tat ca sp hay khong

        for ($i = 1; $i <= $totalPage; $i++) {
            //*****lay danh sach sp va doi voi tung sp lay tat ca order cua sp do
            $myProductList = Core_Product::getProducts(array('fonsitestatus' => Core_Product::OS_ERP), '', '', (($i - 1) * $recordPerPage) . ',' . $recordPerPage);

            foreach ($myProductList as $myProduct) {
                $querypoint = $myProduct->id;
                $count++;

                $summary[$querypoint] = array();
                $items = '';

                //*****lay tat ca don hang co chua query point
                /*$precordPerPage = 10;

                $ptotal = Core_ArchivedorderDetail::getArchivedorderDetails(array('fpid' => $querypoint), '', '', '', true);
                $ptotalPage = ceil($ptotal/$precordPerPage);*/

                $plist = Core_ArchivedorderDetail::getArchivedorderDetails(array('fpid' => $querypoint), '', '', '');

                foreach ($plist as $list) {
                    set_time_limit(0);

                    //*****lay tat ca sp cua tung order
                    $myProductList = Core_ArchivedorderDetail::getArchivedorderDetails(array('forderid' => $list->oorderid, 'ffilterpid' => $querypoint), '', '', '');

                    foreach ($myProductList as $product) {
                        array_push($summary[$querypoint], $product->pid);
                    }
                }

                $output = array_count_values($summary[$querypoint]); //output cua 1 san pham
                arsort($output); //sap xep theo thu tu giam dan

                /*//***** hien thi de test
                echo '<b>Query point <i>['.$querypoint.']</i></b> :  <br />';
                $qp = new Core_Product($querypoint,true);
                echo 'QP Name : ' .$qp->name. '<br /><br />';

                foreach($output as $key => $value)
                {
                    //hien thi de test
                    $item = new Core_Product($key, true);
                    echo '<b>' . $key . '</b> : ' . $item->name . ' (<i>'.$value.'</i>) <br />';
                }
                echo '<hr />';	//hien thi de test*/

                //echodebug($output, true);

                //***** tien hanh insert data vao table euclidean, 2 field eu_qpid & eu_item can phai la Unique
                foreach ($output as $key => $value) {
                    $sql = 'INSERT INTO ' . TABLE_PREFIX . 'euclidean(eu_qpid,
																	eu_item,
																	eu_range,
																	eu_datecreated)
							VALUES (?, ?, ?, ?)
							ON DUPLICATE KEY UPDATE eu_range = ?';
                    $this->registry->db->query($sql, array((int)$querypoint,
                        (int)$key,
                        (int)$value,
                        (int)$datecreated,
                        (int)$value));

                    if (strlen($items) == 0)
                        $items .= $key;
                    else
                        $items .= ', ' . $key;
                }

                //echo $items . '<br />';

                //***** tien hanh insert data vao table neighbors khi da co du lieu items dang chuoi~
                $sql2 = 'INSERT INTO ' . TABLE_PREFIX . 'neighbors(eu_qpid,
																ne_items,
																ne_datecreated)
						VALUES (?, ?, ?)
						ON DUPLICATE KEY UPDATE ne_items = ?';
                $this->registry->db->query($sql2, array((int)$querypoint,
                    (string)$items,
                    (int)$datecreated,
                    (string)$items));
            }
        }
    }

    public function getrecommendedAction()
    {
        $qpid = (int)$_GET['fqpid'];
        $recommendedList = array();

        $myProduct = new Core_Product($qpid, true);

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'neighbors
    			WHERE eu_qpid = ?';

        $stmt = $this->registry->db->query($sql, array($qpid));
        $myRecommended = $stmt->fetch();

        //echodebug($myRecommended);

        echo 'Product Name : <b>' . $myProduct->name . '</b><br />';

        $rebuild = explode(',', $myRecommended['ne_items']);

        echo '<u>Recommended for this Product</u> : <br /><ul>';

        foreach ($rebuild as $build) {
            $product = new Core_Product($build, true);
            echo '<li>' . $product->name . '</li>';
            //$recommendedList[] = $product;
        }

        echo '</ul>';
    }

    public function userrecommAction()
    {
        function getBrowser()
        {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
            $bname = 'Unknown';
            $platform = 'Unknown';
            $version = "";

            //First get the platform?
            if (preg_match('/linux/i', $u_agent)) {
                $platform = 'linux';
            } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
                $platform = 'mac';
            } elseif (preg_match('/windows|win32/i', $u_agent)) {
                $platform = 'windows';
            }

            // Next get the name of the useragent yes seperately and for good reason
            if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            } elseif (preg_match('/Firefox/i', $u_agent)) {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            } elseif (preg_match('/Chrome/i', $u_agent)) {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            } elseif (preg_match('/Safari/i', $u_agent)) {
                $bname = 'Apple Safari';
                $ub = "Safari";
            } elseif (preg_match('/Opera/i', $u_agent)) {
                $bname = 'Opera';
                $ub = "Opera";
            } elseif (preg_match('/Netscape/i', $u_agent)) {
                $bname = 'Netscape';
                $ub = "Netscape";
            }

            // finally get the correct version number
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $u_agent, $matches)) {
                // we have no matching number just continue
            }

            // see how many we have
            $i = count($matches['browser']);
            if ($i != 1) {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                    $version = $matches['version'][0];
                } else {
                    $version = $matches['version'][1];
                }
            } else {
                $version = $matches['version'][0];
            }

            // check if we have a number
            if ($version == null || $version == "") {
                $version = "?";
            }

            return array(
                'userAgent' => $u_agent,
                'name' => $bname,
                'version' => $version,
                'platform' => $platform,
                'pattern' => $pattern
            );
        }

        // now try it
        $ua = getBrowser();
        $yourbrowser = "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " . $ua['platform'] . " reports: <br >" . $ua['userAgent'];
        print_r($yourbrowser);

        echodebug(getallheaders());
    }

    //customer

    public function getrecommendedfAction()
    {

		$action = isset($_GET['action']) && $_GET['action']!='' ? $_GET['action']   : '';
        if($action!='')
        {
	        $funtion = 'detail'.$action;
	        set_time_limit(0);
	        $recordPerPagePro = 2000;
	        $total = Core_Product::getProducts(array('fonsitestatus' => Core_Product::OS_ERP), '', '', '', true);
	        $totalPage = ceil($total / $recordPerPagePro);
	        $datecreated = time();


//			$row =  $this->registry->db->query($sql_lay_san_pham);
//			while($s =$row->fetch())
	        for ($i = 1; $i <= $totalPage; $i++) {
		        //*****lay danh sach sp va doi voi tung sp lay tat ca order cua sp do
		        $sql_lay_san_pham = ' SELECT p_id FROM lit_product WHERE p_onsitestatus = '.Core_Product::OS_ERP.' LIMIT '.(($i - 1) * $recordPerPagePro) . ',' . $recordPerPagePro;

		        $tmp = $this->registry->db->query($sql_lay_san_pham);
		        while ($row = $tmp->fetch()) {

					        $this->$funtion($row['p_id'],$total);

		        }
		        unset($tmp);
		        unset($row);
	        }
        }



    }

	private function detailSameOrder($pro,$total)
	{
		$arrDiss =array();
		$recordPerPageOr  = 1000;

		$con['lit_archivedorder_detail']['p_id'] = $pro;
		$countOrder  = Core_ArchivedorderDetail::getrecommendSameOrder($con, '', true);
		$recordPerPagePro = 1000;
		$totalPageOr = ceil($countOrder / $recordPerPageOr);
		if ($countOrder > 1) {
			// for don hang
			for ($j = 1; $j <= $totalPageOr; $j++) {


				// list order co chua product
				$myOrderList = Core_ArchivedorderDetail::getrecommendSameOrder($con,(($j - 1) * $recordPerPageOr) . ',' . $recordPerPageOr,false);
				if (!empty($myOrderList)) {

					$totalPage = ceil($total / $recordPerPagePro);

					// for san pham
					for ($i = 1; $i <= $totalPage; $i++) {
						$sql_lay_san_pham = ' SELECT p_id FROM lit_product WHERE p_onsitestatus = ' . Core_Product::OS_ERP . ' LIMIT ' . (($i - 1) * $recordPerPagePro) . ',' . $recordPerPagePro;
						$tmp              = $this->registry->db->query($sql_lay_san_pham);
						while ($row = $tmp->fetch()) {

							foreach ($myOrderList as $khoa => $giatri) {
								if ($row['p_id'] != $pro) {

									$conNeibor['lit_archivedorder_detail']['p_id']      = $row['p_id'];
									$conNeibor['lit_archivedorder_detail']['o_orderid'] = $giatri['o_orderid'];

									$ListOrderNeibor                  =  Core_ArchivedorderDetail::getrecommendSameOrder($conNeibor,'',true);
									$arrDiss[$row['p_id']]            = isset($arrDiss) ? $arrDiss[$row['p_id']]+$ListOrderNeibor  : $ListOrderNeibor ;

								}


							}


						}
						unset($tmp);

					}

					foreach ($arrDiss as $key=>$value) {
						$this->insertitemSameCustomer($pro,$key,$value,'is_sameorder');
					}

					unset($myOrderList);
					unset($arrDiss);
				}
			}
		}



	}

	private function detailSameCustomer($pro,$total)
	{
		$arrDiss =array();
		$recordPerPageOr  = 1000;

		$con['lit_archivedorder_detail']['p_id'] = $pro;
		$countOrder  = Core_Archivedorder::getAJoinADByProduct($con, '', true);
		$recordPerPagePro = 1000;
		$totalPageOr = ceil($countOrder / $recordPerPageOr);
		if ($countOrder > 1) {
			// for don hang
			for ($j = 1; $j <= $totalPageOr; $j++) {


				// list order co chua product
				$myOrderList = Core_Archivedorder::getAJoinADByProduct($con,(($j - 1) * $recordPerPageOr) . ',' . $recordPerPageOr,false);
				if (!empty($myOrderList)) {

					$totalPage = ceil($total / $recordPerPagePro);

					// for san pham
					for ($i = 1; $i <= $totalPage; $i++) {
						$sql_lay_san_pham = ' SELECT p_id FROM lit_product WHERE p_onsitestatus = ' . Core_Product::OS_ERP . ' LIMIT ' . (($i - 1) * $recordPerPagePro) . ',' . $recordPerPagePro;
						$tmp              = $this->registry->db->query($sql_lay_san_pham);
						while ($row = $tmp->fetch()) {

							foreach ($myOrderList as $khoa => $giatri) {
								if ($row['p_id'] != $pro) {

									$conNeibor['lit_archivedorder_detail']['p_id']     = $row['p_id'];
									$conNeibor['lit_archivedorder']['o_customerphone'] = $giatri['o_customerphone'];

									$ListOrderNeibor                  = Core_Archivedorder::getAJoinADByProduct($conNeibor,'',true);
									$arrDiss[$row['p_id']]            = isset($arrDiss) ? $arrDiss[$row['p_id']]+$ListOrderNeibor  : $ListOrderNeibor ;
									unset($conNeibor);

								}


							}


						}
						unset($tmp);

					}

					foreach ($arrDiss as $key=>$value) {
						$this->insertitemSameCustomer($pro,$key,$value,'is_samecustomer');
					}

					unset($myOrderList);
					unset($arrDiss);
				}
			}
		}



	}









	private function insertitemSameCustomer($pro,$pro2,$point,$field)
	{
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rec_itemitem_scrore(
                                                                    is_p1,
																	is_p2,
																	'.$field.',
																	is_datecreated)
								VALUES (?, ?, ?, ?)
								ON DUPLICATE KEY UPDATE '.$field.' = ?';
		$this->registry->db->query($sql, array(
		                                      (int)$pro,
		                                      (int)$pro2,
		                                      (int)$point,
		                                      time(),
		                                      (int)$point));
	}

    public function redissameorderAction()
    {
        $productList = array();
        $orderList = array();
        $redis = new RedisCache();

        //lay tat ca sp
        $sql = 'SELECT p_id from ' . TABLE_PREFIX . 'product WHERE p_onsitestatus = 6 LIMIT 100';

        $stmt = $this->registry->db->query($sql);
        while($row = $stmt->fetch())
        {
            $productList[] = $row['p_id'] . "\n";
        }

        //lay tat ca order
        $sql2 = 'SELECT o_id from ' . TABLE_PREFIX . 'archivedorder';

        $stmt2 = $this->registry->db->query($sql2);
        while($row2 = $stmt2->fetch())
        {
            set_time_limit(0);

            $orderList[] = $row2['o_id'] . "\n";
        }

        foreach($productList as $product)
        {
            $p = array();

            //lay tat ca order cua tung sp
            $sql3 = 'SELECT o_orderid FROM '. TABLE_PREFIX .'archivedorder_detail WHERE p_id = '. $product .'';
            $stmt3 = $this->registry->db->query($sql3);
            while($row3 = $stmt3->fetch())
            {
                $orderitem = $row3['o_orderid'];

                foreach($orderList as $order)
                {
                    if($order == $orderitem)
                        echo 'OK';
                }
            }
            //end of 1 product
        }

        unset($productList);
        unset($orderList);
    }

    

}