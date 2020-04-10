<?php

Class Controller_Stat_Report_Company Extends Controller_Stat_Report
{
	/**
	 * view sheet company-view top item
	 * @return [type] [description]
	 */
	public function indexAction()
	{
		global $conf;
		set_time_limit(0);
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');

		if (!empty($_GET['startdate']) && (empty($_GET['yeartopitem']) || $_GET['monthtopitem'] || $_GET['weektopitem'] || $_GET['daytopitem']))
		{
			$parsingstarttime = Helper::strtotimedmy($_GET['startdate']);
			$parsingstartendtime = Helper::strtotimedmy($_GET['enddate']);
			if (($parsingstartendtime - strtotime('+6 day', $parsingstarttime) ) <= 2){
				 $_GET['weektopitem'] = date('W', $parsingstartendtime);
				 $_GET['monthtopitem'] = 0;
			}
			else
			{
				$_GET['weektopitem'] = 0;
				$_GET['monthtopitem'] = date('m', $parsingstarttime);
			}
			//$parsingendtime = Helper::strtotimedmy($_GET['enddate']);
			$_GET['yeartopitem'] = date('Y', $parsingstarttime);
			$_GET['daytopitem'] = '';
		}

		$currentyear = (int)(!empty($_GET['yeartopitem'])? $_GET['yeartopitem'] : date('Y' , time()));
		$currentmonth = (int)(isset($_GET['monthtopitem'])? $_GET['monthtopitem'] : date('m' , time() ));
		$currentweek = (int)(isset($_GET['weektopitem'])? $_GET['weektopitem'] : 0);//date('W' , time())
		$currentday = (string)(isset($_GET['daytopitem'])? $_GET['daytopitem'] : '');//date('d/m/Y' , time())
		$startdate = Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = time();
		$enddate = $relenddate;
		if($currentmonth > 0 && $currentweek <= 0 )
		{
			$startdate = Helper::strtotimedmy( '01/' . $currentmonth . '/' . $currentyear);//. date('Y') );
			$enddate = strtotime('+1 month' , $startdate);
			$relenddate = strtotime('-1 day' , $enddate);

		}
		else if($currentweek > 0)
		{
			for($day=0; $day<=6; $day++)
			{
				if($day == 0)
				{
					$startdate = strtotime($currentyear."W".$currentweek.$day);
				}

				if($day == 6)
				{
					$relenddate = strtotime($currentyear."W".$currentweek.$day);
					$enddate = strtotime('+1 day' , $relenddate);
				}
			}
		}
		elseif (strlen($currentday) > 0)
		{
			$startdate = Helper::strtotimedmy($currentday);
			$enddate = strtotime('+1 day' ,$startdate);
			$relenddate = $startdate;
		}

		if ($enddate > time()) $enddate = strtotime("+1 day");
		if ($relenddate > time()) $relenddate = time();

		$_GET['startdate'] = date('d/m/Y', $startdate);
		$_GET['enddate'] = date('d/m/Y', $enddate);


		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );


		$weekOfYearList = $this->getAllWeekInYear();

		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		////////////////CHECK FILE CACHE IS EXIST
		$filename = 'r'.$id.$storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $relenddate) . $sortby . 'indexAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/company';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' .$filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			//summary info
			$ssoluongban               = 0;
			$sdoanhthu               = 0;
			$slaigop                 = 0;
			$smargin                 = 0;
			$sgiatritonkho           = 0;
			$ssoluongtonkho           = 0;
			$stongtraffic            = 0;
			$ssoluongdonhang         = 0;
			$sconversionrate         = 0;
			$sgiatritrungbinhdonhang = 0;

			$refineData = array();
			$chartData = array();
			/////GET ROOT CATEGORY
			$productcategorylist = Core_Productcategory::getProductcategoryListFromCache();
			$rootcategory = array();
			if(count($productcategorylist) > 0)
			{
				foreach ($productcategorylist as $catid => $datavalue)
				{
					if(count($datavalue['parent']) == 0)
					{
						$rootcategory[$catid] = $datavalue['name'];
					}
				}
			}

			if(count($rootcategory) > 0)
			{
				foreach ($rootcategory as $catid => $catname)
				{
					$dataidlist = array('category' => $catid);
					if ($storeid > 0)
					{
						$dataidlist['store'] = $storeid;
						$dataidlist['groupstore'] = 1;
					}
					else $dataidlist['store'] = 0;
					$detailvalues = array('doanhthuthucte' , 'laigop' , 'soluotkhach' , 'soluongthucban');
					$mastervalues = array('ssoluongthucban' , 'sdoanhthu' ,  'sgiavon' , 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'stonkho' , 'trigiacuoiky' , 'tongsoluongdonhang' );

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

					$datalist = $data['data'][$storeid][$catid];

					//get data of line chart
					if(count($datalist) > 0)
					{
						foreach ($datalist as $date => $value)
						{
							$xdtdate = date('d/m' , $date);

							switch ($chartby)
							{
								case 'revenue':
									$refineData[$xdtdate] += $value['doanhthuthucte'];
									break;

								case 'traffic':
									$refineData[$xdtdate] += $value['soluotkhach'];
									break;

								case 'volume':
									$refineData[$xdtdate] += $value['soluongthucban'];
									break;

								case 'profit':
									$refineData[$xdtdate] += $value['laigop'];
									break;
							}
						}
					}

					//summary info
					$sdoanhthu += $data['datamaster']['sdoanhthu'];
					$ssoluongban += $data['datamaster']['ssoluongthucban'];
					$slaigop += $data['datamaster']['slaigop'];
					$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
					$ssoluongtonkho += $data['datamaster']['stonkho'];
					//$stongtraffic += $data['datamaster']['tongsoluotkhach'];
					$ssoluongdonhang += $data['datamaster']['tongsoluongdonhang'];

					/*$categoryitem = array();

					//get full sub category
					$productcategorysublist = Core_Productcategory::getFullSubCategoryFromRedisCache($catid , 10);

					$subcatidlist = array_keys($productcategorysublist);
					foreach ($subcatidlist as $subcatid)
					{
						$dataidlist = array('category' => $subcatid);
						if ($storeid > 0)
						{
							$dataidlist['store'] = $storeid;
							$dataidlist['groupstore'] = 1;
						}
						else $dataidlist['store'] = 0;
						$detailvalues = array('doanhthuthucte' , 'laigop' , 'soluotkhach' , 'soluongthucban');
						$mastervalues = array('ssoluongthucban' , 'sdoanhthu' ,  'sgiavon' , 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'stonkho' , 'trigiacuoiky' , 'tongsoluongdonhang' );

						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

						$datalist = $data['data'][$storeid][$subcatid];

						//get data of line chart
						if(count($datalist) > 0)
						{
							foreach ($datalist as $date => $value)
							{
								$xdtdate = date('d/m' , $date);

								switch ($chartby)
								{
									case 'revenue':
										$refineData[$xdtdate] += $value['doanhthuthucte'];
										break;

									case 'traffic':
										$refineData[$xdtdate] += $value['soluotkhach'];
										break;

									case 'volume':
										$refineData[$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$xdtdate] += $value['laigop'];
										break;
								}
							}
						}

						//summary info
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$ssoluongban += $data['datamaster']['ssoluongthucban'];
						$slaigop += $data['datamaster']['slaigop'];
						$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
						$ssoluongtonkho += $data['datamaster']['stonkho'];
						//$stongtraffic += $data['datamaster']['tongsoluotkhach'];
						$ssoluongdonhang += $data['datamaster']['tongsoluongdonhang'];
					}*/
				}
			}
			$stongtraffic = Core_Backend_Caculatereport::calsoluotkhach($storeid, $startdate, $enddate);
			////////////////////////////////////////////////////////
			//get top 10 product
			$conditionarr = array();
			if($currentweek > 0)
			{
				switch ($sortby)
				{
					case 1:
						$conditionarr['type'] = Core_Stat::TOPITEM_WEEK_REVENUE;
						break;

					case 2:
						$conditionarr['type'] = Core_Stat::TOPITEM_WEEK_VOLUME;
						break;

					case 3:
						$conditionarr['type'] = Core_Stat::TOPITEM_WEEK_PROFIT;
						break;

					case 4:
						$conditionarr['type'] = Core_Stat::TOPITEM_WEEK_TRAFFIC;
						break;
				}
				$conditionarr['typevalue'] = (int)$currentyear . (int)$currentweek;
			}
			elseif($currentmonth > 0)
			{
				switch ($sortby)
				{
					case 1:
						$conditionarr['type'] = Core_Stat::TOPITEM_MONTH_REVENUE;
						break;

					case 2:
						$conditionarr['type'] = Core_Stat::TOPITEM_MONTH_VOLUME;
						break;

					case 3:
						$conditionarr['type'] = Core_Stat::TOPITEM_MONTH_PROFIT;
						break;

					case 4:
						$conditionarr['type'] = Core_Stat::TOPITEM_MONTH_TRAFFIC;
						break;
				}
				$conditionarr['typevalue'] = (int)$currentyear . sprintf('%02d', $currentmonth);
			}
			elseif(strlen($currentday) > 0)
			{
				$day = date('Y-m-d', Helper::strtotimedmy($currentday));
				switch ($sortby)
				{
					case 1:
						$conditionarr['type'] = Core_Stat::TOPITEM_DAY_REVENUE;
						break;

					case 2:
						$conditionarr['type'] = Core_Stat::TOPITEM_DAY_VOLUME;
						break;

					case 3:
						$conditionarr['type'] = Core_Stat::TOPITEM_DAY_PROFIT;
						break;

					case 4:
						$conditionarr['type'] = Core_Stat::TOPITEM_DAY_TRAFFIC;
						break;
				}

				$conditionarr['typevalue'] = $day;
			}

			if($storeid > 0)
					$conditionarr['store'] = $storeid;

			$producttop = Core_Stat::getcachetopitem($conditionarr);
			$songay = ceil(($enddate - $startdate) / 86400);
			if(count($producttop) > 0)
			{
				$producttoplist = array();
				$productidlist = array_keys($producttop);

				$dataidlist = array('product' => $productidlist);
				if ($storeid > 0)
				{
					$dataidlist['store'] = $storeid;
					$dataidlist['groupstore'] = 1;
				}
				//$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
				$detailvalues = array('soluongthucban', 'doanhthuthucte', 'thanhtoanthucte', 'giabantrungbinh', 'giavontrungbinh', 'laigop', 'ngaybanhang', 'tralai', 'doanhthutralai', 'tonkho', 'trigiacuoiky', 'giavon');
				$mastervalues = array();//'ssoluongthucban' , 'sdoanhthu' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'stonkho' ,'ngaybanhang', 'stralai' , 'trigiacuoiky'
				$songay = ceil(($enddate - $startdate) / 86400);
				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
				if (isset($data['data'][$storeid]))
				{
					$datalist = $data['data'][$storeid];
					//foreach ($datalist as $productid => $listdatedatas)
					foreach ($datalist as $productid => $datavalue)
					{
						$productitem = array();
						$product = new Core_Product($productid , true);
						$productitem['productid'] = $productid;
						$productitem['ten'] = $product->name;
						$productitem['sku'] = $product->barcode;
						$productitem['vaitro'] = Core_Product::getstaticbusinessstatusName($product->businessstatus);

						$productitem['soluong']         = 0;
						$productitem['doanhthu']        = 0;
						$productitem['giabantrungbinh'] = 0;
						$productitem['giavontrungbinh'] = 0;
						$productitem['laigop']          = 0;
						$productitem['margin']          = 0;
						$productitem['tonkho']          = 0;
						$productitem['ngaybanhang']     = 0;
						$productitem['tralai']          = 0;
						$listdatedatas = (!empty($datalist[$productid]) ? $datalist[$productid]: array());
						if (!empty($listdatedatas))
						{
							foreach ($listdatedatas as $date=>$values)
							{
								$productitem['soluong']         += $values['soluongthucban'];
								$productitem['doanhthu']        += $values['doanhthuthucte'];
								$productitem['giabantrungbinh'] += $values['giabantrungbinh'];
								$productitem['giavontrungbinh'] += $values['giavontrungbinh'];
								$productitem['laigop']          += $values['laigop'];
								$productitem['tonkho']          += $values['tonkho'];
								$productitem['tralai']          += $values['tralai'];
								$productitem['doanhthutralai']          += $values['doanhthutralai'];
								$productitem['giavon']          += $values['giavon'];
							}
						}
						$productitem['ngaybanhang'] = ($productitem['soluong'] >0 ? round($productitem['tonkho']*$songay / $productitem['soluong'], 2) : 0);
						$productitem['margin'] = ($productitem['doanhthu'] >0 ? ($productitem['laigop']*100 / $productitem['doanhthu']) : 0);
						$productitem['giabanhientai']   = $product->sellprice;
						if ($productitem['soluong'] > 0 ) {
							$productitem['giabantrungbinh'] = abs($productitem['doanhthu'] / $productitem['soluong']);
							$productitem['giavontrungbinh'] = abs($productitem['giavon'] / $productitem['soluong']);
						}

						$inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice(trim($product->barcode));
						$productitem['giamuahientai']   = $inputpriceinfo['inputprice'] - $inputpriceinfo['discount'];
						$producttoplist[] = $productitem;
						unset($productitem);
					}
				}
			}
			/////////////end of get top 10 product
			////////////////////////////////////////////

			//summary info
			$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) , 2) : 0;
			$sconversionrate = ($stongtraffic > 0) ? round(($ssoluongdonhang * 100 / $stongtraffic) , 2) : 0;
			$sgiatritrungbinhdonhang = ($ssoluongdonhang > 0) ? $sdoanhthu / $ssoluongdonhang : 0;

			// Line chart
			$chartTitle = 'Thống kê ';
			switch ($chartby)
			{
				case 'revenue':
					$chartTitle .= 'Doanh số ';
					break;

				case 'volume':
					$chartTitle .= 'Số lượng ';
					break;

				case 'profit':
					$chartTitle .= 'Lãi gộp ';
					break;
			}
			$chartData['dienmay.com'] = $refineData;
			////////////////////////////////////////

			//create paramurl
			$paramurl = '';
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '?startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode(date('d/m/Y', $relenddate));
				$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode(date('d/m/Y', $relenddate));
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= (!empty($paramurl)?'&':'?').'fsid='.urlencode($_GET['fsid']);
				$urlparam .= (!empty($urlparam)?'&':'').'fsid='.urlencode($_GET['fsid']);
			}
			//////////////////////////////////
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
				if($stepdate > 7)
					$stepdate = ceil($stepdate / 7) - 1;
			//assign template

			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'startdate' => date('d/m/Y', $startdate),
											'enddate' => date('d/m/Y', $relenddate),
											'storeid'    => $storeid,
											'sortby'	=> $sortby,
											'liststores' => Core_Store::getStoresFromCache(),
											'sortby'     => $sortby,
											'chartby'	=> $chartby,
											'chartTitle' => $chartTitle,
											'chartData' => $chartData,
											'producttoplist' => $producttoplist,
											'ssoluongban'	=> $ssoluongban,
											'sdoanhthu'	=> $sdoanhthu,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'sgiatritonkho' => $sgiatritonkho,
											'ssoluongtonkho' => $ssoluongtonkho,
											'stongtraffic' => $stongtraffic,
											'ssoluongdonhang' => $ssoluongdonhang,
											'sconversionrate' => $sconversionrate,
											'sgiatritrungbinhdonhang' => $sgiatritrungbinhdonhang,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'stepdate' => $stepdate,
											'weekOfYearList' => $weekOfYearList,
											'currentyear' => $currentyear,
											'currentmonth' => $currentmonth,
											'currentweek' => $currentweek,
											'currentday' => $currentday,
											'songay' => $songay,
											));

			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
			$myCache->save($content);
			echo $content;
			//$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
		}
	}

	/**
	 * view company view-cate base
	 * @return [type] [description]
	 */
	public function catebaseAction()
	{
		global $conf;
		set_time_limit(0);
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');
		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):strtotime('-1 day'));
		if(isset($_GET['enddate']))
		{
			$enddate = 	strtotime("+1 day" , $relenddate);
			if ($enddate > time()) $enddate = strtotime("+1 day");
			if ($relenddate > time()) $relenddate = time();
		}
		else
		{
			$enddate = 	strtotime("+1 day");
		}

		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit
		////////////////CHECK FILE CACHE IS EXIST
		$filename = 'r'.$id.$storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $relenddate) . $sortby . 'catebaseAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/company';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' .$filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			//summary info
			$sdoanhthu = 0;
			$slaigop              = 0;
			$smargin              = 0;
			$sgiatritonkho        = 0;
			$ssoluongtonkho        = 0;
			$stongtraffic 		  = 0;
			$ssoluongdonhang = 0;
			$ssoluongthucban = 0;
			$sconversionrate = 0;
			$sgiatritrungbinhdonhang = 0;

			$lineChartData = array();
			$pieChartData = array();
			$pieChartDataSL = array();
			$pieChartDataLaigop = array();
			$categoryitemlist = array();
			$refineData = array();

			/////GET ROOT CATEGORY
			$productcategorylist = Core_Productcategory::getProductcategoryListFromCache();
			$listcategoryhavedatafromcache = Core_Stat::getproducthavereport($startdate, $enddate);
			if (empty($listcategoryhavedatafromcache)) {
				$listcategoryhavedatafromcache = Core_Productcategory::getProductlistFromCategory();
			}
			$rootcategory = array();
			if(count($productcategorylist) > 0)
			{
				foreach ($productcategorylist as $catid => $datavalue)
				{
					if(count($datavalue['parent']) == 0)
					{
						$rootcategory[$catid] = $datavalue['name'];
					}
				}
			}
			$songay = ceil(($enddate - $startdate) / 86400);
			if(count($rootcategory) > 0)
			{

				foreach ($rootcategory as $catid => $catname)
				{
					$categoryitem = array();
					$dataidlist = array('category' => $catid);
					if ($storeid > 0)
					{
						$dataidlist['store'] = $storeid;
						$dataidlist['groupstore'] = 1;
					}
					else $dataidlist['store'] = 0;
					$detailvalues = array('doanhthuthucte' , 'laigop' , 'soluongthucban');//'soluotkhach',
					$mastervalues = array('ssoluongthucban' , 'sdoanhthu' ,  'sgiavon' , 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai', 'sdoanhthutralai' , 'stonkho' , 'trigiacuoiky' , 'tongsoluongdonhang' , 'tongsoluotkhach');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

					$datalist = $data['data'][$storeid][$catid];

					//get data of line chart
					if(count($datalist) > 0)
					{
						foreach ($datalist as $date => $value)
						{
							$xdtdate = date('d/m' , $date);

							switch ($chartby)
							{
								case 'revenue':
									$refineData[$catname][$xdtdate] += $value['doanhthuthucte'];
									break;

								case 'traffic':
									$refineData[$catname][$xdtdate] += $value['soluotkhach'];
									break;

								case 'volume':
									$refineData[$catname][$xdtdate] += $value['soluongthucban'];
									break;

								case 'profit':
									$refineData[$catname][$xdtdate] += $value['laigop'];
									break;
							}
						}
					}

					$categoryitem['soluong'] = $data['datamaster']['ssoluongthucban'];
					$categoryitem['doanhthu'] = $data['datamaster']['sdoanhthu'];
					$categoryitem['laigop'] = $data['datamaster']['slaigop'];
					//$categoryitem['margin'] += $data['datamaster']['smargin'];
					$categoryitem['tonkho'] = $data['datamaster']['stonkho'];

					$categoryitem['ngaybanhang'] = ($data['datamaster']['ssoluongthucban'] > 0? round($data['datamaster']['stonkho']*$songay/$data['datamaster']['ssoluongthucban'], 2): 0);//$data['datamaster']['ngaybanhang'];
					$categoryitem['tralai'] = $data['datamaster']['stralai'];
					$categoryitem['doanhthutralai'] = $data['datamaster']['sdoanhthutralai'];
					$categoryitem['trigiatonkho'] = $data['datamaster']['trigiacuoiky'];
					$categoryitem['giavon'] = $data['datamaster']['sgiavon'];

					//summary info
					$sdoanhthu += $data['datamaster']['sdoanhthu'];
					$slaigop += $data['datamaster']['slaigop'];
					$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
					$ssoluongtonkho += $data['datamaster']['stonkho'];
					//$stongtraffic = $data['datamaster']['tongsoluotkhach'];//vi category khong co so luot khach, chi co store & root
					$ssoluongdonhang += $data['datamaster']['tongsoluongdonhang'];
					$ssoluongthucban += $data['datamaster']['ssoluongthucban'];
					//$ssoluongthucban += $data['datamaster']['sdoanhthutralai'];

					//get full sub category
					/*$productcategorysublist = Core_Productcategory::getFullSubCategoryFromRedisCache($catid , 10);

					$subcatidlist = array_keys($productcategorysublist);

					foreach ($subcatidlist as $subcatid)
					{
						$dataidlist = array('category' => $subcatid);
						if ($storeid > 0)
						{
							$dataidlist['store'] = $storeid;
							$dataidlist['groupstore'] = 1;
						}
						else $dataidlist['store'] = 0;
						$detailvalues = array('doanhthuthucte' , 'laigop' , 'soluongthucban');//'soluotkhach',
						$mastervalues = array('ssoluongthucban' , 'sdoanhthu' ,  'sgiavon' , 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'stonkho' , 'trigiacuoiky' , 'tongsoluongdonhang' , 'tongsoluotkhach');

						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

						$datalist = $data['data'][$storeid][$subcatid];

						//get data of line chart
						if(count($datalist) > 0)
						{
							foreach ($datalist as $date => $value)
							{
								$xdtdate = date('d/m' , $date);

								switch ($chartby)
								{
									case 'revenue':
										$refineData[$catname][$xdtdate] += $value['doanhthuthucte'];
										break;

									case 'traffic':
										$refineData[$catname][$xdtdate] += $value['soluotkhach'];
										break;

									case 'volume':
										$refineData[$catname][$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$catname][$xdtdate] += $value['laigop'];
										break;
								}
							}
						}

						$categoryitem['soluong'] += $data['datamaster']['ssoluongthucban'];
						$categoryitem['doanhthu'] += $data['datamaster']['sdoanhthu'];
						$categoryitem['laigop'] += $data['datamaster']['slaigop'];
						//$categoryitem['margin'] += $data['datamaster']['smargin'];
						$categoryitem['tonkho'] += $data['datamaster']['stonkho'];
						$categoryitem['ngaybanhang'] += $data['datamaster']['ngaybanhang'];
						$categoryitem['tralai'] += $data['datamaster']['stralai'];
						$categoryitem['trigiatonkho'] += $data['datamaster']['trigiacuoiky'];
						$categoryitem['giavon'] += $data['datamaster']['sgiavon'];
						$categoryitem['cateid'] = $subcatid;

						//summary info
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$slaigop += $data['datamaster']['slaigop'];
						$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
						$ssoluongtonkho += $data['datamaster']['stonkho'];
						//$stongtraffic = $data['datamaster']['tongsoluotkhach'];//vi category khong co so luot khach, chi co store & root
						$ssoluongdonhang += $data['datamaster']['tongsoluongdonhang'];
						$ssoluongthucban += $data['datamaster']['ssoluongthucban'];
					}*/

					$categoryitem['cateid'] = $catid;
					$categoryitem['margin'] = ($categoryitem['doanhthu'] > 0) ? round(($categoryitem['laigop'] * 100 / $categoryitem['doanhthu']) , 2) : 0;
					$categoryitem['tendanhmuc'] = $catname;
					$categoryitem['vaitro'] = 'N/A';
					$categoryitem['giabantrungbinh'] = ($categoryitem['soluong'] > 0) ? $categoryitem['doanhthu'] / $categoryitem['soluong'] : 0;
					$categoryitem['giavontrungbinh'] = ($categoryitem['soluong'] > 0) ? $categoryitem['giavon'] / $categoryitem['soluong'] : 0;

					//dem tong so sku
					$categoryitem['numssku'] = 0;
					if (!empty($productcategorylist[$catid]['child']))
					{
						foreach($productcategorylist[$catid]['child'] as $childcate)
						{
							$categoryitem['numssku'] += count($listcategoryhavedatafromcache[$childcate]);
						}
					}
					else $categoryitem['numssku'] += count($listcategoryhavedatafromcache[$catid]);

					$categoryitemlist[$catname] = $categoryitem;

					unset($categoryitem);
				}


				$stongtraffic = Core_Backend_Caculatereport::calsoluotkhach($storeid, $startdate, $enddate);


				//summary info
				$smargin = ($sdoanhthu > 0) ? round(($slaigop *100/ $sdoanhthu) ,2) : 0;
				$sgiatritrungbinhdonhang = ($ssoluongdonhang > 0) ? round(($sdoanhthu / $ssoluongdonhang) ,2) : 0;
				$sconversionrate = ($stongtraffic > 0) ? round(($ssoluongdonhang * 100/ $stongtraffic) , 2) : 0;

				// Line chart
				$chartTitle = 'Thống kê ';
				switch ($chartby)
				{
					case 'revenue':
						$chartTitle .= 'Doanh số ';
						break;

					case 'volume':
						$chartTitle .= 'Số lượng ';
						break;

					case 'profit':
						$chartTitle .= 'Lãi gộp ';
						break;
				}

				foreach ($categoryitemlist as $catname => $catdata)
				{
					$lineChartData[$catname] = $refineData[$catname];

					//pie chart
					/*$pieChartData[$catname] = ($sdoanhthu > 0) ? round(($catdata['doanhthu'] * 100 / $sdoanhthu) , 2) : 0;
					$pieChartDataSL[$catname] = ($sdoanhthu > 0) ? round(($catdata['laigop'] * 100 / $sdoanhthu) , 2) : 0;
					$pieChartDataLaigop[$catname] = ($sdoanhthu > 0) ? round(($catdata['soluong'] * 100 / $sdoanhthu) , 2) : 0;
					*/
					switch ($chartby)
					{
						case 'revenue':
							$pieChartData[$catname] = ($sdoanhthu > 0) ? round(($catdata['doanhthu'] * 100 / $sdoanhthu) , 2) : 0;
							break;

						case 'volume':
							$pieChartData[$catname] = ($ssoluongthucban > 0) ? round(($catdata['soluong'] * 100 / $ssoluongthucban) , 2) : 0;
							break;

						case 'profit':
							$pieChartData[$catname] = ($slaigop > 0) ? round(($catdata['laigop'] * 100 / $slaigop) , 2) : 0;
							break;
					}
				}

			}//end of if

			////////////////////////////////////////
			//create paramurl
			$paramurl = '';
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '?startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= (!empty($paramurl)?'&':'?').'fsid='.urlencode($_GET['fsid']);
				$urlparam .= (!empty($urlparam)?'&':'').'fsid='.urlencode($_GET['fsid']);
			}
			//////////////////////////////////
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
				if($stepdate > 7)
					$stepdate = ceil($stepdate / 7) - 1;
			//assign template
			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'startdate' => date('d/m/Y', $startdate),
											'enddate' => date('d/m/Y', $relenddate),
											'storeid'    => $storeid,
											'sortby'	=> $sortby,
											'liststores' => Core_Store::getStoresFromCache(),
											'sortby'     => $sortby,
											'chartby'	=> $chartby,
											'chartTitle' => $chartTitle,
											'lineChartData' => $lineChartData,
											'lineChartType' => 'line',
											'pieChartDataSL' => $pieChartDataSL,
											'pieChartDataLaigop' => $pieChartDataLaigop,
											'pieChartData' => $pieChartData,
											'pieChartType' => 'pie',
											'categoryitemlist' => $categoryitemlist,
											'sdoanhthu'	=> $sdoanhthu,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'sgiatritonkho' => $sgiatritonkho,
											'ssoluongtonkho' => $ssoluongtonkho,
											'stongtraffic' => $stongtraffic,
											'ssoluongdonhang' => $ssoluongdonhang,
											'sconversionrate' => $sconversionrate,
											'sgiatritrungbinhdonhang' => $sgiatritrungbinhdonhang,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'stepdate' => $stepdate,
											'songay' => $songay,
											));
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcate.tpl');
			$myCache->save($content);
			//////////////////////////////////////////////////
			echo $content;
			//$this->registry->smarty->display($this->registry->smartyControllerContainer.'subcate.tpl');
		}


	}//end of function

	/**
	 * view company-store
	 * @return [type] [description]
	 */
	public function catestoreAction()
	{
		global $conf;
		set_time_limit(0);
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$sid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');
		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			$enddate = 	strtotime("+1 day" , $relenddate);
			if ($enddate > time()) $enddate = strtotime("+1 day");
			if ($relenddate > time()) $relenddate = time();
		}
		else
		{
			$enddate = 	strtotime("+1 day");
		}

		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit


		////////////////CHECK FILE CACHE IS EXIST
		$filename = 'r'.$id.$sid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $relenddate) . $sortby . 'catestoreAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/company';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' .$filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			//summary info
			$ssoluongthucban = 0;
			$sdoanhthu = 0;
			$slaigop              = 0;
			$smargin              = 0;
			$sgiatritonkho        = 0;
			$stongtraffic 		  = 0;
			$ssoluongdonhang = 0;
			$sconversionrate = 0;
			$sgiatritrungbinhdonhang = 0;

			$lineChartData = array();
			$pieChartData = array();
			$storeitemlist = array();
			$refineData = array();

			$productcategorylist = Core_Productcategory::getProductcategoryListFromCache();
			$rootcategory = array();
			if(count($productcategorylist) > 0)
			{
				foreach ($productcategorylist as $catid => $datavalue)
				{
					if(count($datavalue['parent']) == 0)
					{
						if (!in_array($catid, $rootcategory)) $rootcategory[] = $catid;
					}
				}
			}

			$storelist = Core_Store::getStoresFromCache();
			$songay = ceil(($enddate - $startdate) / 86400);
			if(count($storelist) > 0)
			{
				foreach ($storelist as $storeid => $storename)
				{
					$storeitem = array();

					$storeitem['tenkho'] = $storename;//.'-'.$storeid;
					$storeitem['storeid'] = $storeid;//.'-'.$storeid;

					$storeitem['soluotkhach'] = Core_Backend_Caculatereport::calsoluotkhach($storeid, $startdate, $enddate);
					$storeitem['soluongthucban'] = 0;
					$storeitem['soluongdonhang'] = 0;
					$storeitem['doanhthu'] = 0;
					$storeitem['laigop'] = 0;
					$storeitem['conversionrate'] = 0;

					$storeitem['trigiatonkho'] = 0;
					$storeitem['ngaybanhang'] = 0;
					$storeitem['tralai'] = 0;

					if (!empty($rootcategory))
					{
						foreach ($rootcategory as $categoryid)
						{
							$dataidlist = array('category' => $categoryid,
												'store' => $storeid,
												'groupstore' => 1,
																);
							$detailvalues = array('doanhthuthucte' , 'laigop' , 'soluotkhach', 'soluongthucban');
							$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sdoanhthutralai' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'stonkho' , 'trigiacuoiky' , 'tongsoluongdonhang' , 'conversionrate' , 'giatritrungbinhdonhang');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

							$datalist = $data['data'][$storeid][$categoryid];

							//get data of line chart
							if(count($datalist) > 0)
							{
								foreach ($datalist as $date => $value)
								{
									$xdtdate = date('d/m' , $date);

									switch ($chartby)
									{
										case 'revenue':
											$refineData[$storename][$xdtdate] += $value['doanhthuthucte'];
											break;

										case 'traffic':
											$refineData[$storename][$xdtdate] += $value['soluotkhach'];
											break;

										case 'volume':
											$refineData[$storename][$xdtdate] += $value['soluongthucban'];
											break;

										case 'profit':
											$refineData[$storename][$xdtdate] += $value['laigop'];
											break;
									}
								}
							}//end of if

							$storeitem['soluongthucban'] += $data['datamaster']['ssoluongthucban'];
							$storeitem['soluongdonhang'] += $data['datamaster']['tongsoluongdonhang'];
							$storeitem['doanhthu'] += $data['datamaster']['sdoanhthu'];
							$storeitem['laigop'] += $data['datamaster']['slaigop'];
							$storeitem['conversionrate'] += $data['datamaster']['conversionrate'];
							$storeitem['trigiatonkho'] += $data['datamaster']['trigiacuoiky'];
							//$storeitem['ngaybanhang'] += $data['datamaster']['ngaybanhang'];
							$storeitem['tralai'] += $data['datamaster']['stralai'];
							$storeitem['doanhthutralai'] += $data['datamaster']['sdoanhthutralai'];

							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$slaigop += $data['datamaster']['slaigop'];
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluongdonhang += $data['datamaster']['tongsoluongdonhang'];
							$ssoluongthucban += $data['datamaster']['ssoluongthucban'];
						}
					}

					$storeitem['ngaybanhang'] = ($storeitem['doanhthu'] > 0 ? round($storeitem['trigiatonkho']*$songay/$storeitem['doanhthu'], 2) : 0);//
					$storeitem['giatritrungbinhdonhang'] = ($storeitem['soluongdonhang'] > 0) ? $storeitem['doanhthu'] / $storeitem['soluongdonhang'] : 0;
					$storeitem['laidonhang'] = ($storeitem['soluongdonhang'] > 0) ? $storeitem['laigop'] / $storeitem['soluongdonhang'] : 0;
					$storeitem['margin'] = ($storeitem['doanhthu'] > 0 ? round($storeitem['laigop']*100/$storeitem['doanhthu'], 2) : 0);
					$stongtraffic += $storeitem['soluotkhach'];

					$storeitemlist[$storename] = $storeitem;
					unset($storeitem);

				}

				////////////////////////////////////////
				//summary info
				$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) ,2) : 0;
				$sgiatritrungbinhdonhang = ($ssoluongdonhang > 0) ? round(($sdoanhthu / $ssoluongdonhang) ,2) : 0;
				$sconversionrate = ($stongtraffic > 0) ? round(($ssoluongdonhang * 100/ $stongtraffic),2) : 0;

				// Line chart
				$chartTitle = 'Thống kê ';
				switch ($chartby)
				{
					case 'revenue':
						$chartTitle .= 'Doanh số ';
						break;

					case 'volume':
						$chartTitle .= 'Số lượng ';
						break;

					case 'profit':
						$chartTitle .= 'Lãi gộp ';
						break;
				}

				foreach ($storeitemlist as $storename => $storedata)
				{
					$lineChartData[$storename] = $refineData[$storename];
					//pie chart
					switch ($chartby)
					{
						case 'revenue':
							$pieChartData[$storename] = ($sdoanhthu > 0) ? round(($storedata['doanhthu'] * 100 / $sdoanhthu) , 2) : 0;
							break;

						case 'traffic':
							$pieChartData[$storename] = ($stongtraffic > 0) ? round(($storedata['soluotkhach'] * 100 / $stongtraffic) , 2) : 0;
							break;

						case 'volume':
							$pieChartData[$storename] = ($ssoluongthucban > 0) ? round(($storedata['soluongthucban'] * 100 / $ssoluongthucban) , 2) : 0;
							break;

						case 'profit':
							$pieChartData[$storename] = ($slaigop > 0) ? round(($storedata[$store->id] * 100 / $slaigop) , 2) : 0;
							break;
					}
				}

			}
			////////////////////////////////////////
			//create paramurl
			$paramurl = '';
			$subparamurl = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '?startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				$subparamurl .= '?startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
				$paramurl .= (!empty($paramurl)?'&':'?').'fsid='.urlencode($_GET['fsid']);


			//////////////////////////////////
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
				if($stepdate > 7)
					$stepdate = ceil($stepdate / 7) - 1;

			//assign template
			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'startdate' => date('d/m/Y', $startdate),
											'enddate' => date('d/m/Y', $relenddate),
											'storeid'    => $storeid,
											'sortby'	=> $sortby,
											'liststores' => Core_Store::getStoresFromCache(),
											'sortby'     => $sortby,
											'chartby'	=> $chartby,
											'chartTitle' => $chartTitle,
											'lineChartData' => $lineChartData,
											'lineChartType' => 'line',
											'pieChartData' => $pieChartData,
											'pieChartType' => 'pie',
											'storeitemlist' => $storeitemlist,
											'sdoanhthu'	=> $sdoanhthu,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'sgiatritonkho' => $sgiatritonkho,
											'stongtraffic' => $stongtraffic,
											'ssoluongdonhang' => $ssoluongdonhang,
											'sconversionrate' => $sconversionrate,
											'sgiatritrungbinhdonhang' => $sgiatritrungbinhdonhang,
											'paramurl' => $paramurl,
											'subparamurl' => $subparamurl,
											'stepdate' => $stepdate,
											'songay' => $songay,
											));
			//$this->registry->smarty->display($this->registry->smartyControllerContainer.'stores.tpl');
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'stores.tpl');
			$myCache->save($content);
			//////////////////////////////////////////////////
			echo $content;
		}
	}//end of function
}

function cmp_volume($volume1 , $volume2)
{
	if($volume1['soluong'] == $volume2['soluong'])
	{
		return 0;
	}

	return ($volume1['soluong'] >  $volume2['soluong']) ? -1 : 1;
}

function cmp_revenue($revenue1 , $revenue2)
{
	if($revenue1['doanhthu'] == $revenue2['doanhthu'])
	{
		return 0;
	}

	return ($revenue1['doanhthu'] >  $revenue2['doanhthu']) ? -1 : 1;
}

function cmp_profit($profit1 , $profit2)
{
	if($profit1['laigop'] == $profit2['laigop'])
	{
		return 0;
	}

	return ($profit1['laigop'] >  $profit2['laigop']) ? -1 : 1;
}