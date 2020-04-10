<?php
Class Controller_Cron_Productcache Extends Controller_Cron_Base
{
	/**
	 * [indexAction description]
	 * @return [type] [description]
	 */
	public function indexAction()
	{

	}

	/**
	 * [catepproductcategory description]
	 * @return [type] [description]
	 */
	public function cachecategoryAction()
	{
		set_time_limit(0);

		$timer = new Timer();

        $timer->start();
		$subdomain = '';
		if (!empty($_GET['subdomain'])) {
			$subdomain = $_GET['subdomain'];
		}

		$myCacher = new Cacher('catlist'.$subdomain , Cacher::STORAGE_MEMCACHED);

		$categorylisttree = array();
		Core_Productcategory::getCategoryIdTree($categorylisttree);

		$data = json_encode($categorylisttree);

		$myCacher->set((string)$data, 86400 * 2);

		$timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';

	}

	public function cachecategoryredisAction()
	{
		global $conf;
		set_time_limit(0);

		$timer = new Timer();

        $timer->start();


		$myCacher = new Cacher('catlist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

		$categorylisttree = array();
		Core_Productcategory::getCategoryIdTree($categorylisttree);

		$data = json_encode($categorylisttree);

		$myCacher->set((string)$data, 86400 * 2);

		$timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';

	}


	/**
	 * [cacheproductbycategoryAction description]
	 * @return [type] [description]
	 */
	public function cacheproductbycategoryAction()
	{
		global $conf;
		set_time_limit(0);
		$timer = new Timer();

        $timer->start();

		//initialize cache
		$myCacher = new Cacher('',Cacher::STORAGE_REDIS, $conf['redis'][1]);	//2 days

		$productcategorylist = array();
		Core_Productcategory::getCategoryIdTree($productcategorylist);

		if(count($productcategorylist) > 0)
		{
			foreach ($productcategorylist as $catid => $datavalue)
			{
				$catidlist = array($catid);
				if(count($datavalue['child']) > 0)
				{
					foreach ($datavalue['child'] as $catidchild)
					{
						$catidlist[] = $catidchild;
					}
				}

				//lay tat ca san pham ca danh muc
				$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product
						WHERE pc_id IN(' . implode(',', $catidlist) .') AND p_barcode != ""';
				$resultstmt = $this->registry->db->query($sql);
				$data = '';
				$productlist = array();

				while ($rowdata = $resultstmt->fetch())
				{
					///////////////////////CACHE REL PRODUCT COLOR
					$myProduct = new Core_Product($rowdata['p_id'] , true);
					$relproductcolors = $myProduct->getProductColor();

					$pcdata = $rowdata['p_id'] . ':' . $rowdata['v_id'] . ':' . $rowdata['p_name'] . ':' . trim($rowdata['p_barcode']) . ':' . $rowdata['p_finalprice'] . ':' . $rowdata['p_businessstaus'] . ':' . implode(',', $relproductcolors) . ':' . $rowdata['p_customizetype'];

					//check attribute of product cached
					$myCacher->key = 'pa:list_' . $rowdata['p_id'];

					if(!$this->checkKeyExist($key , Cacher::STORAGE_REDIS))
					{
						//////////////CACHE ATTRIBUTE
						//Lay danh sach filter cua danh muc hien tai
						$productattributefilterlist = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $catid,
																												'fpaidthan' => 1,
																												) , 'id' , 'ASC');
						if(count($productattributefilterlist) > 0)
						{
							$dataattributelist = array();
							foreach ($productattributefilterlist as $productattributefilter)
							{
								$sql = 'SELECT rpa.rpa_value FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa
										WHERE pa_id = ? AND p_id = ?';

								$rowresult = $this->registry->db->query($sql , array($productattributefilter->paid, $rowdata['p_id']))->fetch();
								$dataattributelist[] = $productattributefilter->paid . ':' . $productattributefilter->panameseo . ':' . $rowresult['rpa_value'] . ':' . Helper::codau2khongdau($rowresult['rpa_value'] , true, true);
							}

							///////////////////CACHE PRICE SEGMENT
							//lay phan khuc gia cua danh muc hien tai
							$productattributefilterlistprice = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $catid,
																												'fpaid' => 0,
																												) , 'id' , 'ASC');

							if(count($productattributefilterlistprice) > 0)
							{
								//
								$productattributefilterprice = $productattributefilterlistprice[0];
								$datalist = explode('###', $productattributefilterprice->value);
								$segmentlist = array();
								foreach ($datalist as $datainfo)
								{
									$info = explode('##', $datainfo);
									$segmentlist[] = array('name' => $info[0],
															'slug' => $info[1],
															'from' => $info[3],
															'to' => $info[4]
														);
								}

								//get final price
								$finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);

								$sellprice = ($finalprice > 0) ? $finalprice : $rowdata['p_finalprice'];

								//lay gia khuyen mai neu co
								$promotionprice = Core_Promotion::getFirstDiscountPromotion($rowdata['p_barcode'], 3);
								$productprice = 0;
								if($promotionprice == false)
									$productprice = $sellprice;
								else
								{
									if((int)$promotionprice['percent'] == 1)
									{
										$dicountprice = $sellprice * (int)$promotionprice['percent'] / 100;
									}
									else
									{
										$dicountprice = $promotionprice['discountvalue'];
									}

									$productprice = $sellprice - $dicountprice;
									//cap nhat vao co so du lieu
									$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_finalprice = ? WHERE p_id = ?';
									$execute = $this->registry->db->query($sql , array($finalprice , $rowdata['p_id']));
								}

								//
								if(count($segmentlist) > 0)
								{
									foreach ($segmentlist as $segment)
									{
										if((float)$segment['from'] <= $productprice && $productprice < (float)$segment['to'] )
										{
											$dataattributelist[] = $segment['slug'] . ':' . $segment['name'];
										}
									}
								}
							}

							////////////////////////////////////////////

							$myCacher->key =  'pa:list_' . $rowdata['p_id'];
							$dataattribute = (string)implode('#', $dataattributelist);
							$myCacher->set($dataattribute, 86400 * 2);
						}
					}
					$productlist[] = $pcdata;
				}

				//set key of data
				$myCacher->key = 'pc:list_' . $catid;

				$data = (string)implode('#' , $productlist);
				$myCacher->set($data, 86400 * 2); //tam thoi de test
			}
		}

		$timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';
	}

	/**
	 * [cachestoreAction description]
	 * @return [type] [description]
	 */
	public function cachestoreAction()
	{
		global $conf;
		set_time_limit(0);
		$timer = new Timer();

        $timer->start();


		$myCacher = new Cacher('storelist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

		$data = '';

		$storelist =  Core_Store::getStores(array('fissalestore' => 1 , 'specialstore' => 1), 'displayorder', 'ASC');
		$datalist = array();
		foreach ($storelist as $store)
		{
			$storedata = array();
			$storedata['id'] = $store->id;
			$storedata['name'] = $store->storeshortname;
			$storedata['isautostorechange'] = $store->isautostorechange;

			//lay tat ca cac kho trong cung mot group
			if($store->isautostorechange == 1)
			{
				$groupstorelist = Core_Store::getStores(array('fissalestore' =>1 , 'fstoregroupid' => $store->storegroupid) , 'displayorder' , 'ASC');
				$groupid = array();
				if(count($groupstorelist) > 0)
				{
					foreach ($groupstorelist as $groupstore)
					{
						$groupid[] = $groupstore->id;
					}
					$storedata['groupstore'] = implode(',', $groupid);
				}
			}
			else
			{
				$storedata['groupstore'] = '';
			}

			$datalist[$store->id]=  $storedata;
		}

		//$data = implode('#', $datalist);
		$data = json_encode($datalist);
		$myCacher->set((string)$data, 86400 * 2);
		$timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';
	}

	/**
	 * [cachefilterAction description]
	 * @return [type] [description]
	 */
	public function cachefilterAction()
	{
		global $conf;
		set_time_limit(0);
		$timer = new Timer();

        $timer->start();

		$myCacher = new Cacher('filterlist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

        $filterlist = array();
        //lay tat ca danh muc
        $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_status = ?' ;

        $stmt = $this->registry->db->query($sql , array(Core_Productcategory::STATUS_ENABLE));

        while ($row = $stmt->fetch())
        {
        	$productattributefilters = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $row['pc_id']) , 'id' , 'ASC');

        	if(count($productattributefilters) > 0)
        	{
        		foreach ($productattributefilters as $attributefilter)
        		{
        			$filterlist[$row['pc_id']][$attributefilter->panameseo]['name'] = $attributefilter->paname;
        			$info = explode('###', $attributefilter->value);
        			foreach ($info as $infodata)
        			{
        				$infoarr = explode('##', $infodata);
        				$filterdatalist = array($infoarr[0] => $infoarr[1] , 'type' => $infoarr[2]);

        				if($infoarr[2] == Core_ProductAttributeFilter::TYPE_PRICE || $infoarr[2] == Core_ProductAttributeFilter::TYPE_WEIGHT)
        				{
        					$filterdatalist['from'] = $infoarr[3];
        					$filterdatalist['to'] = $infoarr[4];
        				}
        				$filterdatalist['value'] = $infoarr[1];
        				$filterdatalist['name'] = $infoarr[0];
        				$filterlist[$row['pc_id']][$attributefilter->panameseo]['values'][$infoarr[1]] = $filterdatalist;

        			}
        			$filterlist[$row['pc_id']][$attributefilter->panameseo]['displayreport'] = $attributefilter->displayreport;
        		}
        	}
        }
        $data = json_encode($filterlist);
        $myCacher->set((string)$data, 86400 * 2);

		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br />';
	}

	/**
	 * [cachevendorbycategoryAction description]
	 * @return [type] [description]
	 */
	public function cachevendorbycategoryAction()
	{
		global $conf;
		set_time_limit(0);
		$timer = new Timer();

        $timer->start();

		$myCacher = new Cacher('' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

		$productcategorylist = array();
		Core_Productcategory::getCategoryIdTree($productcategorylist);

		foreach ($productcategorylist as $pcid => $datavalue)
		{
			$datavalue['child'][] = $pcid;

			$vendorlist = Core_Product::getVendorFromCategories($datavalue['child']);
			$datalist = array();

			if(count($vendorlist) > 0)
			{
				foreach ($vendorlist as $vendor)
				{
					$datalist[] = $vendor->id . ':' . $vendor->name;
				}
			}

			$myCacher->key = 'vendor:list_' . $pcid;
			$data = implode('#', $datalist);

			$myCacher->set((string)$data, 86400 * 2);
		}

		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br />';
	}

	public function cacheproductbyvendorAction()
	{
		set_time_limit(0);
		$timer = new Timer();

        $timer->start();

		$myCacher = new Cacher('pvc_list' , Cacher::STORAGE_MEMCACHED);
		//$myCacher = new Cacher('pvc_list' , Cacher::STORAGE_REDIS , 86400 *2);

		$categorylisttree = array();
		Core_Productcategory::getCategoryIdTree($categorylisttree);
		$datalist = array();
		foreach($categorylisttree as $catid => $datavalue)
		{
			///////LAY TAT CA SAN PHAM CUA DANH MUC HIEN TAI
			$catlist = $datavalue['child'];
			$catlist[] = $catid;
			$vendorlist = Core_Product::getVendorFromCategories($catlist);
			foreach($vendorlist as $vendor)
			{
			  	$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product
						WHERE pc_id IN(' . implode($catlist)  . ') AND v_id = ' . $vendor->id ;
				$stmt = $this->registry->db->query($sql);
				while($row = $stmt->fetch())
				{
				  	$datalist[$catid][$vendor->id][] = $row['p_id'];
				}
			}
		}
		$data = json_encode($datalist);
		$myCacher->set((string)$data, 86400 * 2);
		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br/>';
	}

	public function cachepricesegmentbycategoryAction()
	{
		global $conf;
		set_time_limit(0);
		$timer = new Timer();

        $timer->start();
		$datalist = array();
		//$myCacher = new Cacher('pseglist' , Cacher::STORAGE_MEMCACHED ,86400 * 2);
		$myCacher = new Cacher('pseglist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);
		$sql = 'SELECT pc_id , paf_value FROM ' . TABLE_PREFIX . 'product_attribute_filter WHERE pa_id = 0';
		$stmt = $this->registry->db->query($sql);
		while ( $row = $stmt->fetch())
		{
			$datainfo = explode('###', $row['paf_value']);
			foreach ($datainfo as $data)
			{
				$infolist = explode('##', $data);
				$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE pc_id IN(?) ';//'  AND p_finalprice >= ?  AND p_finalprice < ?' ;
				$arrrcondi = array();

				//lay tat ca cac nganh hang con cua danh muc hien tai
				$subcategorylist = Core_Productcategory::getFullSubCategory($row['pc_id']);

				//$arrrcondi[0] =  $row['pc_id'];// , $infolist[3] , $infolist[4]
				$arrrcondi[0] = implode(',' , $subcategorylist);

				if ($infolist[3] > 0 && $infolist[4] > $infolist[3])
				{
					$sql .= '  AND p_finalprice >= ?  AND p_finalprice < ?';
					$arrrcondi[1] = $infolist[3];
					$arrrcondi[2] = $infolist[4];
				}
				elseif ($infolist[3] > 0 && $infolist[4] <=0 )
				{
					$sql .= '  AND p_finalprice >= ?';
					$arrrcondi[1] = $infolist[3];
				}
				elseif ($infolist[3] <= 0 && $infolist[4] > 0)
				{
					$sql .= ' AND p_finalprice <= ?';
					$arrrcondi[1] = $infolist[4];
				}
				//echodebug($data.':--'.$sql.'--'.print_r($arrrcondi, 1)) ;
				if (count($arrrcondi) >1)
				{
					$resultset = $this->registry->db->query($sql , $arrrcondi);
					$pidlist = array();
					while ( $result =  $resultset->fetch())
					{
				  		if (empty($datalist[$row['pc_id']][$infolist[1]]) || !in_array($result['p_id'], $datalist[$row['pc_id']][$infolist[1]]))
				  		{
							$datalist[$row['pc_id']][$infolist[1]][] = $result['p_id'];
				  		}
					}
				}
			}
		}
		$data = json_encode($datalist);
		$myCacher->set((string)$data, 86400 * 2);
		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br/>';
	}

	public function cachemaincharacterAction()
	{
		global $conf;
		set_time_limit(0);
		$timer = new Timer();
		$timer->start();

		$sql = 'SELECT pc_id , paf_value , pa_id FROM ' . TABLE_PREFIX . 'product_attribute_filter WHERE pa_id > 0';// AND pa_isreport = 1
		$stmt = $this->registry->db->query($sql);
		$datalist = array();
		$counter = 0;
		while ( $row = $stmt->fetch())
		{
			$datainfo = explode('###', $row['paf_value']);
			foreach ($datainfo as $data)
			{
				$infolist = explode('##', $data);
				$resultset = null;
				//if ($infolist[3] == '14"') echo 'HERE';
				//echo '<p>--------'.$infolist[3].'-------</p>';
				if((int)$infolist[2] == Core_ProductAttributeFilter::TYPE_EXACT)
				{
					$sql = 'SELECT p.p_id FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa INNER JOIN '. TABLE_PREFIX .'product p ON p.p_id = rpa.p_id WHERE rpa_value=? AND p.pc_id = ? AND pa_id = ? AND p.p_barcode !=""';
					$resultset = $this->registry->db->query($sql, array($infolist[3], $row['pc_id'],  $row['pa_id']));
				}
				elseif((int)$infolist[2] == Core_ProductAttributeFilter::TYPE_LIKE)
				{
					$sql = 'SELECT p.p_id FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa INNER JOIN '. TABLE_PREFIX .'product p ON p.p_id = rpa.p_id WHERE rpa_value LIKE ? AND p.pc_id = ? AND pa_id = ? AND p.p_barcode !=""';
					$resultset = $this->registry->db->query($sql, array('%'.$infolist[3].'%', $row['pc_id'],  $row['pa_id']));
				}
				elseif((int)$infolist[2] == Core_ProductAttributeFilter::TYPE_WEIGHT)
				{
					$sql = 'SELECT p.p_id FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa INNER JOIN '. TABLE_PREFIX .'product p ON p.p_id = rpa.p_id WHERE rpa_value >= ? AND p.pc_id = ? AND pa_id = ? AND p.p_barcode !=""';
					$resultset = $this->registry->db->query($sql, array($infolist[3], $row['pc_id'],  $row['pa_id']));
				}

				$pidlist = array();
				while($result = $resultset->fetch())
				{
				  	$pidlist[] = $result['p_id'];
				}
				//echodebug($pidlist);
				$datalist[$row['pc_id']][$infolist[1]] = $pidlist;
				unset($pidlist);
				unset($infolist);
				unset($resultset);
			}
			$counter++;
			unset($datainfo);
		}

		$data = json_encode($datalist);
		//$myCacher = new Cacher('pseglist' , Cacher::STORAGE_MEMCACHED ,86400 * 2);
		$myCacher = new Cacher('pcattrlist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

		$myCacher->set((string)$data , 86400 * 2);
		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br/>';
	}

    public function cacheproductbybarcodeAction()
    {
        global $conf;
        set_time_limit(0);
        $timer = new Timer();

        $myCacher = new Cacher('' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

        $timer->start();

        $sql = 'SELECT p_id , p_name , pc_id , p_barcode , v_id , p_isrequestimei , p_isservice FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != ""';
        $stmt = $this->registry->db->query($sql);
        while($row = $stmt->fetch())
        {
            $data = '';

            $data .= $row['p_id'] . ':' . $row['p_name'] . ':' . $row['pc_id'] . ':' . trim($row['p_barcode']) . ':' . $row['v_id'] . ':' . $row['p_isrequestimei'] . ':' . $row['p_isservice'];
            $myCacher->key = 'pb:' . $row['p_barcode'];
            $myCacher->set((string)$data, 86400 * 2);
            unset($data);
        }

        $timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br/>';
    }

	public function cachetopitembydayAction()
	{

	}

	public function cachetopitembyweekAction()
	{

	}

	public function cachetopitembymonthAction()
	{

	}

	/**
	 * [checkKeyExist description]
	 * @param  [type] $key     [description]
	 * @param  [type] $storage [description]
	 * @return [type]          [description]
	 */
	private function checkKeyExist($key , $storage)
	{
		global $conf;
		$configuration = null;
		$isExist = false;
		if ($storage == Cacher::STORAGE_REDIS) {
			$configuration = $conf['redis'][1];
		}
		$myCacher = new Cacher($key , $storage, $configuration);//
		$data = $myCacher->get();

		if($data != false) {
			$isExist = true;
		}

		return $isExist;
	}

	public function importproductvatAction()
    {
        global $db;
        $counter = 0;
        $oracle = new Oracle();
        //get all product from cms
        $sql = 'SELECT p_id,
                    p_barcode
                FROM ' . TABLE_PREFIX . 'product ';//
                //WHERE p_onsitestatus = ?';

        $stmt = $this->registry->db->query($sql);// , array(Core_Product::OS_ERP)

        while ($row = $stmt->fetch())
        {
            //cap nhat vat va isrequestimei
            $sql = 'SELECT ISREQUESTIMEI , VAT , ISSERVICE FROM ERP.VW_PRODUCT_DM WHERE PRODUCTID = \'' . $row['p_barcode'] . '\'';
            $results = $oracle->query($sql);
            if(count($results) > 0)
            {
                $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                        SET p_isrequestimei = ? ,
                            p_vat = ?,
                            p_isservice = ?
                        WHERE p_id = ?';

                $stmt1 = $this->registry->db->query($sql , array(
                                                $results[0]['ISREQUESTIMEI'],
                                                $results[0]['VAT'],
                                                $results[0]['ISSERVICE'],
                                                $row['p_id'],
                                                ));
                if($stmt1)
                {
                    $counter++;
                    unset($results);
                    unset($stmt1);
                }
            }
        }

        echo 'So luong record : ' . $counter;
    }


	public function apiGetProductDetailDataAction()
	{
		$data = array();

		$productid = (int)$_GET['pid'];
		$key = md5('dienmay.com/stat/report' . $productid);

		$serect = (string)$_GET['serect'];

		if($serect === $key)
		{

			$product = new Core_Product($productid , true);
			$giavontrungbinh = 0;

			$dataidlist = array('product' => $product->id);

			if($product->id > 0)
			{
				$begindate = strtotime(date('Y') . '-' . date('m') . '-01');
		        $startdate = strtotime(date('Y') . '-' . date('m') . '-01');
		        $enddate = time();

		        $detailvalues = array();
		        $mastervalues = array('sgiavontrungbinh');

		        $datacache = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

		        $giavontrungbinh = $datacache['datamaster']['sgiavontrungbinh'];

				$data['giavontrungbinh'] = $giavontrungbinh;
			}

			//header('Content-Type: application/json');
		}

		echo json_encode($data);
	}
}
