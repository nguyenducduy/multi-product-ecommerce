<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
Class Controller_Stat_Report_Productcategory Extends Controller_Stat_Report
{
	/**
	 * View CatView - top item sheet
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
		$currentday = (string)(isset($_GET['daytopitem'])? $_GET['daytopitem'] : '');//date('d/m/Y' , time()));
		$startdate = Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );
		//if(isset($_GET['form'])) $currentday = (string)$_GET['daytopitem'];
		$relenddate = time();
		$enddate = $relenddate;

		if($currentmonth > 0 && $currentweek <= 0 )
		{
			$startdate = Helper::strtotimedmy( '01/' . $currentmonth . '/' . date('Y') );
			$enddate = strtotime('+1 month' , $startdate);
			$relenddate = strtotime('-1 day' , $enddate);
			//$enddate = $relenddate;
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

		//echodebug('START DATE: '. date('Y-m-d H:i:s', $startdate).' END DATE: '. date('Y-m-d H:i:s', $enddate).'--WEEK: '.$currentweek);

		$_GET['startdate'] = date('d/m/Y', $startdate);
		$_GET['enddate'] = date('d/m/Y', $enddate);
		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );


		$weekOfYearList = $this->getAllWeekInYear();

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		//create paramurl
		$paramurl = '';
		$paramurl = '?id='.$id;
		$productparamurl = '';
		$urlparam = '';
		if(isset($_GET['startdate']))
		{
			$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode(date('d/m/Y', $relenddate));
			$productparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode(date('d/m/Y', $relenddate));
			$urlparam .= 'startdate='.$_GET['startdate'].'&enddate='.date('d/m/Y', $relenddate);
		}
		if(isset($_GET['fsid']))
		{
			$paramurl .= '&fsid='.urlencode($_GET['fsid']);
			$productparamurl .= '&fsid='.urlencode($_GET['fsid']);
			if (!empty($urlparam)) $urlparam .= '&fsid='.$_GET['fsid'];
			else $urlparam = 'fsid='.$_GET['fsid'];
		}

		$productcategory = new Core_Productcategory($id, true);
		$productcategoryidlist = array($id);//nganh hang cha da co cache roi
		////////////////CHECK FILE CACHE IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $relenddate) . $sortby . 'indexAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' .$filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			if($productcategory->id > 0)
			{

				//sumary info
				$sdoanhthu            = 0;
				$slaigop              = 0;
				$smargin              = 0;
				$sgiatritonkho        = 0;
				$ssoluong             = 0;
				$stonkho             = 0;
				$sgiatritrungbinhitem = 0;
				$snhapmua = 0;
				$sngaybanhang = 0;

				$producttoplist = array();
				$productitemlist = array();
				$refineData = array();
				$lineChartData = array();
				$pieChartData = array();

				foreach ($productcategoryidlist as $pcid)
				{
					$dataidlist = array('category' => $pcid,
											'store' => $storeid,
											);
					if($storeid > 0)
					{
						$dataidlist['groupstore'] = 1;
					}

					$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
					$mastervalues = array('ssoluongthucban' , 'sdoanhthu' ,'slaigop' , 'smargin' , 'stonkho' , 'stralai' , 'sdoanhthutralai' , 'trigiacuoiky', 'nhapmua', 'ngaybanhang');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

					$datalist = $data['data'][$storeid][$pcid];

					//get data of line chart
					if(count($data) > 0)
					{
						foreach ($datalist as $date => $value)
						{
							$xdtdate = date('d/m' , $date);

							switch ($chartby)
							{
								case 'revenue':
									$refineData[$productcategory->id][$xdtdate] += $value['doanhthuthucte'];
									break;

								case 'volume':
									$refineData[$productcategory->id][$xdtdate] += $value['soluongthucban'];
									break;

								case 'profit':
									$refineData[$productcategory->id][$xdtdate] += $value['laigop'];
									break;
							}
						}
					}

					//summary caculate
					$sdoanhthu += $data['datamaster']['sdoanhthu'];
					$slaigop += $data['datamaster']['slaigop'];
					$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
					$ssoluong += $data['datamaster']['ssoluongthucban'];
					$stonkho += $data['datamaster']['stonkho'];
					$snhapmua += $data['datamaster']['nhapmua'];
					//$sngaybanhang += $data['datamaster']['ngaybanhang'];
				}
				$songay = ceil(($enddate - $startdate) / 86400);
				$sngaybanhang = ($ssoluong > 0 ? round($stonkho * $songay / $ssoluong, 2) : 0);
				//chartdata
				$lineChartData[$productcategory->name] = $refineData[$productcategory->id];

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

				//caculate summary info
				$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) , 2) : 0;
				$sgiatritrungbinhitem = ($ssoluong > 0) ? ($sdoanhthu / $ssoluong) : 0;

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
					}

					$conditionarr['typevalue'] = $day;
				}

				if($storeid > 0)
						$conditionarr['store'] = $storeid;

				$conditionarr['category'] = $productcategory->id;

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

					$detailvalues = array('soluongthucban', 'doanhthuthucte', 'thanhtoanthucte', 'giabantrungbinh', 'giavontrungbinh', 'laigop', 'ngaybanhang', 'tralai', 'doanhthutralai', 'tonkho', 'trigiacuoiky', 'giavon');
					$mastervalues = array();// , 'sdoanhthu' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'stonkho' ,'ngaybanhang', 'stralai', 'sdoanhthutralai' , 'trigiacuoiky'

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

				////////////////////end get top product
			}

			///////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);

			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;

			$getallproductcategoryfromcache = Core_Productcategory::getProductcategoryListFromCache();

			$havechildrend = 2;
			if (!empty($getallproductcategoryfromcache[$productcategory->id]) && count($getallproductcategoryfromcache[$productcategory->id]['child']) > 0)
			{
				$havechildrend = 1;
			}
			unset($getallproductcategoryfromcache);

			//////////////////////////////////////////////////////////////
			//assign template
			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'productcategoryinfo' => $productcategory,
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
											'sdoanhthu' => $sdoanhthu,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'sgiatritonkho' => $sgiatritonkho,
											'ssoluong' => $ssoluong,
											'snhapmua' => $snhapmua,
											'stonkho' => $stonkho,
											'sngaybanhang' => $sngaybanhang,
											'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
											'producttoplist' => $producttoplist,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'productparamurl' => $productparamurl,
											'fullproductcategory' =>$fullproductcategory,
											'stepdate' => $stepdate,
											'weekOfYearList' => $weekOfYearList,
											'currentyear' => $currentyear,
											'currentmonth' => $currentmonth,
											'currentweek' => $currentweek,
											'currentday' => $currentday,
											'songay' => $songay,
											'havechildrend' => $havechildrend,
											));
			////////////////////////CREATE CAHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
			$myCache->save($content);
			//////////////////////////////////////////////////
			echo $content;
			//$this->registry->smarty->display($this->registry->smartyControllerContainer . 'index.tpl');
		}

	}//end of function

	/**
	 * view sheet cate MC-SKU subcate
	 * @return [type] [description]
	 */
	public function listsubcateAction()
	{
		global $conf;
		set_time_limit(0);

		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');
		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy(urldecode($_GET['enddate'])):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime("+1 day" , $relenddate);
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
		///////////////////////////////////////////

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit
		$productcategory = new Core_Productcategory($id, true);
		$productallcategorylist = Core_Productcategory::getProductcategoryListFromCache();
		$listcategoryhavedatafromcache = Core_Stat::getproducthavereport($startdate, $enddate);
		if (empty($listcategoryhavedatafromcache)) $listcategoryhavedatafromcache = Core_Productcategory::getProductlistFromCategory();

		if($productcategory->id > 0)
		{
			$productcategorylist = Core_Productcategory::getFullSubCategoryFromCache($productcategory->id, 10);

			if(empty($productcategorylist))
			{
				$url = $this->registry->conf['rooturl'].'stat/report/productcategory/subcate/?id='.$id;
				if(isset($_GET['startdate']))
				{
					$url .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				}
				if(isset($_GET['fsid']))
				{
					$url .= '&fsid='.urlencode($_GET['fsid']);
				}

				header('Location: '. $url);
				exit();
			}

			//echodebug('START DATE: '. date('Y-m-d H:i:s', $startdate).' END DATE: '. date('Y-m-d H:i:s', $enddate));
			//////////////////CHECK FILE CACHE IS EXIST
			$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . 'listsubcateAction.html';
			$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
			$myCache = new cache($filename , $cacheDir);
			if(!isset($_GET['live']) && file_exists($cacheDir . '/' . $filename))
			{
				$content = $myCache->get();
				echo $content;
			}
			else
			{
				//sumary info
				$sdoanhthu            = 0;
				$slaigop              = 0;
				$smargin              = 0;
				$sgiatritonkho        = 0;
				$ssoluong             = 0;
				$sgiatritrungbinhitem = 0;
				$ssoluongthucban = 0;
				$sdoanhthutralai = 0;

				$refineData = array();
				$lineChartData = array();
				$pieChartData = array();


				$spdoanhthu = array();
				$spsoluong = array();
				$splaigop = array();

				$categorylist = array();
				$songay = ceil(($enddate - $startdate) / 86400);
				foreach ($productcategorylist as $catid => $datavalue)
				{
					$categoryitem = array();
					//$productlist = Core_Productcategory::getProductlistFromCache($catid);

					//$productidlist = array_keys($productlist);
					$dataidlist = array('category' => $catid,
												'store' => $storeid,
												);
					if($storeid > 0)
					{
						$dataidlist['groupstore'] = 1;
					}

					$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
					$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'sdoanhthutralai' , 'trigiacuoiky');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
					//get data of line chart
					if(count($data['data']) > 0)
					{
						foreach ($data['data'][$storeid] as $pcid => $datacharts)
						{
							foreach ($datacharts as $date => $value)
							{
								$xdtdate = date('d/m' , $date);

								switch ($chartby)
								{
									case 'revenue':
										$refineData[$pcid][$xdtdate] += $value['doanhthuthucte'];
										break;

									case 'volume':
										$refineData[$pcid][$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$pcid][$xdtdate] += $value['laigop'];
										break;
								}
							}
						}
					}

					//get info
					$categoryitem['id']              = $catid;
					$categoryitem['ten']             = $datavalue['name'];
					$categoryitem['mucdonggop']      = '';
					$categoryitem['soluong']         = $data['datamaster']['ssoluongthucban'];
					$categoryitem['doanhthu']        = $data['datamaster']['sdoanhthu'];
					$categoryitem['giabantrungbinh'] = $data['datamaster']['sgiabantrungbinh'];
					$categoryitem['giavontrungbinh'] = $data['datamaster']['sgiavontrungbinh'];
					$categoryitem['laigop']          = $data['datamaster']['slaigop'];
					$categoryitem['margin']          = $data['datamaster']['smargin'];
					$categoryitem['giatritonkho']    = $data['datamaster']['trigiacuoiky'];
					$categoryitem['doanhthutralai']    = $data['datamaster']['sdoanhthutralai'];
					$categoryitem['ngaybanhang']     = ($data['datamaster']['sdoanhthu'] > 0 ? round($data['datamaster']['trigiacuoiky'] * $songay / $data['datamaster']['sdoanhthu'], 2) :0);//$data['datamaster']['ngaybanhang'];
					$categoryitem['tralai']          = $data['datamaster']['stralai'];

					$categorylist[$catid] = $categoryitem;

					//summary info
					$sdoanhthu += $data['datamaster']['sdoanhthu'];
					$ssoluong += $data['datamaster']['ssoluongthucban'];
					$slaigop += $data['datamaster']['slaigop'];
					$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
					$sdoanhthutralai += $data['datamaster']['sdoanhthutralai'];

					unset($categoryitem);
				}
				//summary info
				$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) ,2) : 0;
				$sgiatritrungbinhitem = ($ssoluong > 0) ? round(($sdoanhthu / $ssoluong) ,2) : 0;


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

				$itemlist = $categorylist;
				$categorylist = array();
				foreach ($itemlist as $catid => $catedata)
				{
					$category = new Core_Productcategory($catid , true);
					$lineChartData[$catedata['ten']] = $refineData[$catid];

					if($sdoanhthu > 0 && $ssoluong > 0 && $slaigop > 0)
					{
						$mucdonggop = '';
						$mucdonggop .= 'V' . ceil($catedata['soluong'] * 100 / $ssoluong);
						$mucdonggop .= ',R' . ceil($catedata['doanhthu'] * 100 /$sdoanhthu);
						$mucdonggop .= ',P' . ceil($catedata['laigop'] * 100 / $slaigop);
					}
					else
					{
						$categorylist[$category->id]['mucdonggop'] = 'N/A';
					}

					$categoryitem['id']              = $catedata['id'];
					$categoryitem['ten']             = $catedata['ten'];
					$categoryitem['mucdonggop']      = $mucdonggop;
					$categoryitem['soluong']         = $catedata['soluong'];
					$categoryitem['doanhthu']        = $catedata['doanhthu'];
					$categoryitem['giabantrungbinh'] = $catedata['giabantrungbinh'];
					$categoryitem['giavontrungbinh'] = $catedata['giavontrungbinh'];
					$categoryitem['laigop']          = $catedata['laigop'];
					$categoryitem['margin']          = $catedata['margin'];
					$categoryitem['giatritonkho']    = $catedata['giatritonkho'];
					$categoryitem['ngaybanhang']     = $catedata['ngaybanhang'];
					$categoryitem['tralai']          = $catedata['tralai'];
					$categoryitem['doanhthutralai']          = $catedata['doanhthutralai'];
					$categoryitem['categorypath']    = $category->getProductcateoryPath();

					//dem tong so sku
					$categoryitem['numssku'] = 0;
					if (!empty($productallcategorylist[$catid]['child']))
					{
						foreach($productallcategorylist[$catid]['child'] as $childcate)
						{
							$categoryitem['numssku'] += count($listcategoryhavedatafromcache[$childcate]);
						}
					}
					else $categoryitem['numssku'] += count($listcategoryhavedatafromcache[$catid]);

					$categorylist[$category->id] = $categoryitem;

					//pie chart
					switch ($chartby)
					{
						case 'revenue':
							$pieChartData[$category->name] = ($sdoanhthu > 0) ? round(($categorylist[$category->id]['doanhthu'] * 100 / $sdoanhthu) , 2) : 0;
							break;

						case 'volume':
							$pieChartData[$category->name] = ($ssoluong > 0) ? round(($categorylist[$category->id]['soluong'] * 100 / $ssoluong) , 2) : 0;
							break;

						case 'profit':
							$pieChartData[$category->name] = ($slaigop > 0) ? round(($categorylist[$category->id]['laigop'] * 100 / $slaigop) , 2) : 0;
							break;
					}
				}
				///////////////////////////////////////////////
				//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
				$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id);
				$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);

				$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
				if($stepdate > 7)
					$stepdate = ceil($stepdate / 7) - 1;
				//////////////////////////////////////////////////////////////
				//create paramurl
				$paramurl = '';
				$productcategoryparamurl = '';
				$paramurl = '?id='.$id;
				$urlparam = '';
				if(isset($_GET['startdate']))
				{
					$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
					$productcategoryparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
					$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				}
				if(isset($_GET['fsid']))
				{
					$paramurl .= '&fsid='.urlencode($_GET['fsid']);
					$productcategoryparamurl .= '&fsid='.urlencode($_GET['fsid']);
					if (!empty($urlparam)) $urlparam .= '&fsid='.urlencode($_GET['fsid']);
					else $urlparam .= 'fsid='.urlencode($_GET['fsid']);
				}

				$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
				$report_timeupdatereport = $cacheredis->get();
				if (!empty($report_timeupdatereport))
				{
					$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
				}

				$this->registry->smarty->assign(array(
												'report_timeupdatereport' => $report_timeupdatereport,
												'productcategoryinfo' => $productcategory,
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
												'sdoanhthu' => $sdoanhthu,
												'sdoanhthutralai' => $sdoanhthutralai,
												'slaigop' => $slaigop,
												'smargin' => $smargin,
												'sgiatritonkho' => $sgiatritonkho,
												'ssoluong' => $ssoluong,
												'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
												'categorylist' => $categorylist,
												'paramurl' => $paramurl,
												'urlparam' => $urlparam,
												'productcategoryparamurl' => $productcategoryparamurl,
												'fullproductcategory' => $fullproductcategory,
												'checkpricesegement' => $checkpricesegement,
												'stepdate' => $stepdate,
												'songay' => $songay,
												));
				//////////////////////CREATE CACHE HTML
				$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'listsubcate.tpl');
				$myCache->save($content);
				echo $content;
				////////////////////////////////////////////////
				//$this->registry->smarty->display($this->registry->smartyControllerContainer.'listsubcate.tpl');
			}
		}

	}//end of function


	/**
	 * View Cate view MC-SKU SKUs
	 * @return [type] [description]
	 */
	public function subcateAction()
	{
		global $conf;
		set_time_limit(0);

		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy(urldecode($_GET['enddate'])):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime("+1 day" , $relenddate);
			if ($enddate > time()) $enddate = strtotime("+1 day");
			if ($relenddate > time()) $relenddate = time();
		}
		else
		{
			$enddate = 	strtotime("+1 day");
		}

		//tim ngay dau thang
		//$beginday = date('d/m/Y' , $startdate);
		//$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );

		$id = (int)(isset($_GET['id'])?$_GET['id']:0);//category parent
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		$tab =  (isset($_GET['tab'])) ? (int)$_GET['tab'] : 1;

		$searchstring = (string)(isset($_GET['a'])?$_GET['a']:'');

		$page = (int)(!empty($_GET['page']) ? (int)$_GET['page'] : 1);

		$recordperpage = 20;

		//xu ly chuoi filter cua san pham
		$searchfilter = array();
		$searchdata = array();
		if(strlen($searchstring))
		{
			$fvalue = array();
			$searchstringarr = explode(',', $searchstring);

			for($i = 0 , $ilen = count($searchstringarr) ; $i < $ilen ; $i+=2)
			{
				$fvalue[$searchstringarr[$i]][] = $searchstringarr[$i+1];
				$searchdata[] = $searchstringarr[$i];
				$searchdata[] = $searchstringarr[$i+1];
			}
		}


		$strvid = (string)(isset($_GET['vid'])?$_GET['vid']:'');

		$vidarr = array();
		if(strlen($strvid) > 0)
		{
			$vidarr = explode(',', $strvid);
		}

		$strbussinessstatus = (string)(isset($_GET['bs'])?$_GET['bs']:'');
		$bussinessstatusarr = array();
		if(strlen($strbussinessstatus) > 0)
		{
			$bussinessstatusarr = explode(',', $strbussinessstatus);
		}

		////////////////////// BUILD URL //////////////////////
			$paramurl = 'id='.$id;
			$productparamurl = '';//'id=' . $id;
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$productparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				$productparamurl .= '&fsid='.urlencode($_GET['fsid']);
				if (empty($urlparam)) $urlparam = 'fsid='.urlencode($_GET['fsid']);
				else $urlparam .= '&fsid='.urlencode($_GET['fsid']);
			}

			if(strlen($strvid) > 0)
			{
				$paramurl .= '&vid=' . $strvid;
			}

			if(strlen($searchstring) > 0)
				$paramurl .= '&a=' . $searchstring;

			if(strlen($strbussinessstatus) > 0)
				$paramurl .= '&bs=' . $strbussinessstatus;

			$paramurl .= '&tab='.$tab;
		////////////////////// END BUILD URL //////////////////////

		$productcategory = new Core_Productcategory($id , true);
		/*if (empty($productcategory->parentid)){
			$productcategorylist = Core_Productcategory::getFullSubCategoryFromRedisCache($productcategory->id, 10);
			if (!empty($productcategorylist)) header('Location: '.$this->registry->conf['rooturl'].'stat/report/productcategory?'.$paramurl);
		}*/
		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = 'p'.$page.$productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . $tab . (count($vidarr) > 0 ? implode('' , $vidarr) : '') . (count($searchdata) > 0 ?  implode('' , $searchdata) : '') .$strbussinessstatus. 'subcateAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			$timer = new Timer();
			$timer->start();
			if($productcategory->id > 0)
			{
				$productcategorylist = Core_Productcategory::getFullSubCategoryFromCache($productcategory->id, 10);
				if (empty($productcategorylist)) $productcategorylist[$productcategory->id] = $productcategory->name;
				$ssoluong = 0;
				$sdoanhthu = 0;
				$sdoanhthutralai = 0;
				$slaigop = 0;
				$smargin = 0;
				$ssoluongton = 0;
				$strigiatonkho = 0;
				$sngaybanhang = 0;
				$stralai = 0;

				$refineData = array();
				$datalist = array();
				/////////////////GET PRODUCT LIST
				$productlist = array();
				$productlistobject = array();
				$productlistobjecthavequantity = array();
				$breadcum = '';

				//get all product of current category
				foreach ($productcategorylist as $childcateid => $childcate)
				{
					if(!empty($fvalue) || !empty($bussinessstatusarr))
					{
						$productlistchild = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																								'fpcid' => $childcateid,
																								'fvidarr' => $vidarr,
																								'fbussinessstatuslist' => $bussinessstatusarr,
																								'fvalue' => $fvalue,
																								) , 'id' , 'ASC');

					}
					else
					{
						$productlistchild = Core_Productcategory::getProductlistFromCache($childcateid , $vidarr , $bussinessstatusarr);
					}
					if (!empty($productlistchild))
					{
						if (empty($productlistobject))
						{
							$productlistobject = $productlistchild;//
						}
						else $productlistobject = $this->mergeProductList($productlistobject, $productlistchild);
					}
					$listcategoryproductgreatethan0 		= Core_Stat::getproducthavereport($startdate, $enddate, $childcateid, $storeid);

					if (!empty($listcategoryproductgreatethan0))
					{
						if (empty($productlistobjecthavequantity))
						{
							$productlistobjecthavequantity = $listcategoryproductgreatethan0[$childcateid];//
						}
						else $productlistobjecthavequantity = array_merge($productlistobjecthavequantity, $listcategoryproductgreatethan0[$childcateid]);
					}
					unset($listcategoryproductgreatethan0);
					unset($productlistchild);
				}

				if(!empty($productlistobjecthavequantity))
				{
					$productlistobjecthavequantity = array_unique($productlistobjecthavequantity);
					$productlist = array_intersect(array_keys($productlistobject), $productlistobjecthavequantity );
				}
				elseif (!empty($productlistobject)) $productlist = array_keys($productlistobject);

				//////PAGINATION
				$number = count($productlist);
				$totalPage = ceil($number / $recordperpage);
				$start = ($page -1) * $recordperpage;
				$songay = ceil(($enddate - $startdate) / 86400);
				if(!empty($productlist))
				{
					if (empty($fvalue ) && empty($vidarr) && empty($bussinessstatusarr))
					{
						///////////////GET MASTER DATA
						if (!empty($productcategorylist))
						{
							foreach ($productcategorylist as $keyproductcate => $nameproductcate)
							{
								$dataidlist = array('category' => $keyproductcate,
														'store' => $storeid,
														);
								if($storeid > 0)
								{
									$dataidlist['groupstore'] = 1;
								}

								$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
								$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'slaigop' , 'stonkho' , 'trigiacuoiky', 'ngaybanhang', 'stralai', 'sdoanhthutralai');

								$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

								$datalist = $data['data'][$storeid][$keyproductcate];
								//get data of line chart
								if(count($datalist) > 0)
								{
									foreach ($datalist as $date => $value)
									{
										$xdtdate = date('d/m' , $date);
										if (empty($refineData[$xdtdate])) $refineData[$xdtdate] = 0;
										switch ($chartby)
										{
											case 'revenue':
												$refineData[$xdtdate] += $value['doanhthuthucte'];
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

								$ssoluong += $data['datamaster']['ssoluongthucban'];
								$sdoanhthu += $data['datamaster']['sdoanhthu'];
								$slaigop += $data['datamaster']['slaigop'];
								$ssoluongton += $data['datamaster']['stonkho'];
								$strigiatonkho += $data['datamaster']['trigiacuoiky'];
								//$sngaybanhang += $data['datamaster']['ngaybanhang'];
								$stralai += $data['datamaster']['stralai'];
								$sdoanhthutralai += $data['datamaster']['sdoanhthutralai'];
							}
						}
						////////////////////////END OF GET MASTER DATA
					}
					else
					{
						if (!empty($fvalue))
						{
							$filterlist = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id);
							$subvendornamearr = array();
							foreach ($fvalue as $k=>$vl)
							{
								/*$subvendornamearr[$k][] = $filterlist[$k]['values'][$vl]['name'];
								$breadcum .= 'Filter: '.$k.' ';*/
								if (!empty($vl))
								{
									if (is_array($vl))
									{
										foreach($vl as $subvl)
										{
											$subvendornamearr[$filterlist[$k]['name']][] = $filterlist[$k]['values'][$subvl]['name'];
										}
									}
									else
									{
										//$breadcum .= 'Filter: '.$filterlist[$k]['name'].'('.$filterlist[$k]['values'][$vl]['name'].')';
										$subvendornamearr[$filterlist[$k]['name']][] = $filterlist[$k]['values'][$vl]['name'];
									}
								}
							}

							if (!empty($subvendornamearr))
							{
								$breadcum .= 'Filter: ';
								foreach ($subvendornamearr as $sname => $listvalues)
								{
									$breadcum .= $sname.'('.implode(', ', $listvalues).')';
								}
							}
							unset($subvendornamearr);
						}
						if (!empty($vidarr))
						{
							$subvendornamearr = array();
							foreach ($vidarr as $svidbc)
							{
								$submyvendor = new Core_Vendor($svidbc, true);
								$subvendornamearr[] = $submyvendor->name;
							}
							if (empty($breadcum)) $breadcum .= 'Filter: Brand('.implode(', ', $subvendornamearr).')';
							else $breadcum .= ', Brand('.implode(', ', $subvendornamearr).')';
							unset($subvendornamearr);
						}
						if (!empty($bussinessstatusarr))
						{
							$subvendornamearr = array();
							foreach ($bussinessstatusarr as $substastusarr)
							{
								$subvendornamearr[] = Core_Product::getbusinessstatusListReport($substastusarr);
							}
							if (empty($breadcum)) $breadcum .= 'Filter: Trạng thái KD('.implode(', ', $subvendornamearr).')';
							else $breadcum .= ', Trạng thái KD('.implode(', ', $subvendornamearr).')';
							unset($subvendornamearr);
						}

						$dataidlist = array('product' => $productlist,'store' => $storeid);//array_keys($productlist)
						if($storeid > 0)
						{
							$dataidlist['groupstore'] = 1;
						}
						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sthanhtoan' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'sdoanhthutralai' , 'stonkho' , 'trigiacuoiky');
						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

						$datalist = $data['data'][$storeid];

						//get data of line chart
						if(count($datalist) > 0)
						{
							foreach ($datalist as $pid => $listdate)
							{
								foreach ($listdate as $date => $value)
								{
									$xdtdate = date('d/m' , $date);
									if (empty($refineData[$xdtdate])) $refineData[$xdtdate] = 0;
									switch ($chartby)
									{
										case 'revenue':
											$refineData[$xdtdate] += $value['doanhthuthucte'];
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
						}

						$ssoluong += $data['datamaster']['ssoluongthucban'];
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$slaigop += $data['datamaster']['slaigop'];
						$ssoluongton += $data['datamaster']['stonkho'];
						$strigiatonkho += $data['datamaster']['trigiacuoiky'];
						$sngaybanhang += $data['datamaster']['ngaybanhang'];
						$stralai += $data['datamaster']['stralai'];
						$sdoanhthutralai += $data['datamaster']['sdoanhthutralai'];
					}

					$productlist = array_slice($productlist, $start , $recordperpage, true);
				}
				else
					$productlist = array();




				//summary info
				$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) ,2) : 0;
				$sngaybanhang = ($ssoluong > 0) ? round(($ssoluongton * $songay / $ssoluong) ,2) : 0;

				//get chart data
				$chartData = array();
				$chartData[$productcategory->name] = $refineData;

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
			}

			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id, 10);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);


			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);

			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;


			//get all vendor of productcategory
			$vendorlist = Core_Vendor::getVendorByProductcategoryFromCache($productcategory->id);
			$listfilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , false);

			if (empty($listfilter))
			{
				foreach ($productcategorylist as $childcateid => $childcate)
				{
					if (empty($listfilter)) $listfilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($childcateid , false);
					else $listfilter = $this->mergeProductList($listfilter, Core_ProductAttributeFilter::getFilterOfCategoryFromCache($childcateid , false));
				}
			}
			if (empty($vendorlist))
			{
				foreach ($productcategorylist as $childcateid => $childcate)
				{
					if (empty($vendorlist)) $vendorlist = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($childcateid , false);
					else $vendorlist = $this->mergeProductList($vendorlist, Core_ProductAttributeFilter::getFilterOfCategoryFromCache($childcateid , false));
				}
			}


			$content = '';
			switch ($tab)
			{
				default:
					//////////////////////////////////////
					if(count($productlist) > 0)
					{
						/////////////////
						$newlistproducts = array();

						$dataidlist = array('product' => $productlist,//array_keys($productlist),
											'store' => $storeid,
											);
						if($storeid > 0)
						{
							$dataidlist['groupstore'] = 1;
						}

						$detailvalues = array('soluongthucban', 'doanhthuthucte', 'thanhtoanthucte', 'giabantrungbinh', 'giavontrungbinh', 'laigop', 'ngaybanhang', 'tralai', 'doanhthutralai', 'tonkho');//, 'trigiacuoiky'
						$mastervalues = array('ssoluongthucban');

						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

						if (isset($data['data'][$storeid]))
						{
							$datalist = $data['data'][$storeid];
							//foreach ($datalist as $productid => $listdatedatas)
							foreach ($productlist as $productid)
							{
								$datavalue = (array) new Core_Product($productid, true);//$productlistobject[$productid];
								$productitem = array();

								$productitem['productid'] = $productid;
								$productitem['productname'] = $datavalue['name'];
								$productitem['sku'] = $datavalue['barcode'];
								$productitem['roles'] = Core_Product::getstaticbusinessstatusName($datavalue['businessstatus']);
								$productitem['sellprice'] = Helper::formatPrice($datavalue['sellprice']);

								$myVendor = new Core_Vendor($datavalue['vid'], true);
								$productitem['brand'] = $myVendor->name;
								$productitem['segmentprice'] = $productlistobject[$productid]['attr']['gia']['value'].' &nbsp;';
								$productitem['kenhban'] = 'N/A';

								$productitem['soluong']         = 0;
								$productitem['doanhthu']        = 0;
								$productitem['thanhtoan']       = 0;
								$productitem['giabantrungbinh'] = 0;
								$productitem['giavontrungbinh'] = 0;
								$productitem['laigop']          = 0;
								$productitem['margin']          = 0;
								$productitem['tonkho']          = 0;
								$productitem['ngaybanhang']     = 0;
								$productitem['tralai']          = 0;
								$productitem['doanhthutralai']          = 0;
								$listdatedatas = (!empty($datalist[$productid]) ? $datalist[$productid]: array());
								if (!empty($listdatedatas))
								{
									foreach ($listdatedatas as $date=>$values)
									{
										$productitem['soluong']         += $values['soluongthucban'];
										$productitem['doanhthu']        += $values['doanhthuthucte'];
										$productitem['thanhtoan']       += $values['thanhtoanthucte'];
										$productitem['giabantrungbinh'] += $values['giabantrungbinh'];
										$productitem['giavontrungbinh'] += $values['giavontrungbinh'];
										$productitem['laigop']          += $values['laigop'];
										$productitem['tonkho']          += $values['tonkho'];
										//$productitem['ngaybanhang']     += $values['ngaybanhang'];
										$productitem['tralai']          += $values['tralai'];
										$productitem['doanhthutralai']  += $values['doanhthutralai'];
									}
								}
								$productitem['ngaybanhang'] = ($productitem['soluong'] >0 ? ($productitem['tonkho']*$songay / $productitem['soluong']) : 0);
								$productitem['margin'] = ($productitem['doanhthu'] >0 ? ($productitem['laigop']*100 / $productitem['doanhthu']) : 0);
								$productitem['giabanhientai']   = (!empty($datavalue['sellprice'])?$datavalue['sellprice']:$datavalue['finalprice']);

								$inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice(trim($datavalue['barcode']));
								$productitem['giamuahientai']   = $inputpriceinfo['inputprice'] - $inputpriceinfo['discount'];
								$newlistproducts[] = $productitem;
								unset($productitem);
							}
						}
					}
					///////////////END OF GET PRODUCT

					///////////////////////////////////////////////////////////////////////
					break;
				case 2:
					$content = $this->subcateinstockvolume($startdate , $enddate , $begindate , $productlist, $productlistobject);
					break;

				case 3:
					$content = $this->subcateinstockvalue($startdate, $enddate , $begindate , $productlist, $productlistobject);
					break;
			}
			///////////////////////////////////////////////////////////////////

			$getallproductcategoryfromcache = Core_Productcategory::getProductcategoryListFromCache();

			$havechildrend = 2;
			if (!empty($getallproductcategoryfromcache[$productcategory->id]) && count($getallproductcategoryfromcache[$productcategory->id]['child']) > 0)
			{
				$havechildrend = 1;
			}
			unset($getallproductcategoryfromcache);

			//assign template
			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'productcategoryinfo' => $productcategory,
											'startdate' => date('d/m/Y', $startdate),
											'enddate' => date('d/m/Y', $relenddate),
											'storeid'    => $storeid,
											'sortby'	=> $sortby,
											'liststores' => Core_Store::getStoresFromCache(),
											'sortby'     => $sortby,
											'chartby'	=> $chartby,
											'chartTitle' => $chartTitle,
											'chartData' => $chartData,
											//'chartType' => $chartType,
											'listsubcategories'	=> $newlistproducts,
											'tab' => $tab,
											'chartTitle' => $chartTitle,
											'ssoluong' => $ssoluong,
											'sdoanhthu' => $sdoanhthu,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'ssoluongton' => $ssoluongton,
											'strigiatonkho' => $strigiatonkho,
											'sngaybanhang' => $sngaybanhang,
											'stralai' => $stralai,
											'sdoanhthutralai' => $sdoanhthutralai,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'productparamurl' => $productparamurl,
											'content' => $content,
											'fullproductcategory' => $fullproductcategory,
											'listattributefilter' => $listattributefilter,
											'stepdate' => $stepdate,
											'searchstring' => $searchstring,
											'vid' => $strvid,
											'stepdate' => $stepdate,
											'vendorlist' => $vendorlist,
											'totalPage' => $totalPage,
											'totalrecord' => $number,
											'curPage' => $page,
											'vidarr' => $vidarr,
											'listfilter' => $listfilter,
											'listpricesegmentblock' => $listpricesegmentblock,
											'searchdata' => $searchdata,
											'breadcum' => $breadcum,
											'bussinessstatuslist' => Core_Product::getbusinessstatusListReport(),
											'bussinessstatusarr' => $bussinessstatusarr,
											'strbussinessstatus' => $strbussinessstatus,
											'totalrow' => $number,
											'songay' => $songay,
											'havechildrend' => $havechildrend,
											));
			////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcate.tpl');
			$myCache->save($content);

			$timer->stop();
			echo $timer->get_exec_time();
			echo $content;
			/////////////////////////////////////////////////
			//$this->registry->smarty->display($this->registry->smartyControllerContainer . 'subcate.tpl');
		}
	}//end of function

	/**
	 * [subcateinstockvolume description]
	 * @param  [type] $startdate [description]
	 * @param  [type] $enddate   [description]
	 * @return [type]            [description]
	 */
	private function subcateinstockvolume($startdate , $enddate , $begindate , $productlist, $productlistobject)
	{
		set_time_limit(0);
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);//category parent
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$assignparam = array();
		$assignparam['startdate'] = date('d/m/Y', $startdate);
		$assignparam['enddate'] = date('d/m/Y', $enddate);
		$assignparam['id'] = $id;
		$assignparam['storeid'] = $storeid;
		//end copy each funciton

		$productcategory = new Core_Productcategory($id, true);
		$storeList = Core_Store::getStoresFromCache();

		$listsubcategories = array();
		if(count($productlist) > 0 && ($startdate < $enddate))
		{
			$listdatastores = array();
			foreach ($storeList as $storeid => $storename)
			{
				$dataidlist = array('product' => $productlist,
										'store' => $storeid,
										'groupstore' => 1,
										);
				$detailvalues = array('soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'sucban' , 'tonkho');
				$mastervalues = array();//'soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'sucban' , 'stonkho');

				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
				if (!empty($data['data'][$storeid]))
				{
					//$listdatastores[$storeid] = array('datalist' => $data['data'][$storeid], 'storename' => $storename, 'storeid' => $storeid);
					$datalist = $data['data'][$storeid];
					//foreach ($datalist as $productid => $listdatedatas)
					foreach ($datalist as $productid => $datavalue)
					{
						$listdatastores[$productid][$storeid][] = $datavalue;
						/*if (empty($listsubcategories[$productid]))
						{
							$listsubcategories[$productid] = array();
						}
						$listsubcategories[$productid][$storeid]['id'] = $productid;
						$listsubcategories[$productid][$storeid]['ten'] = $productlistobject[$productid]['name'];
						*/
					}
					unset($datalist);
				}
			}
			if (!empty($listdatastores))
			{
				$songay = ($enddate - $startdate) / (24*3600) + 1;
				foreach ($listdatastores as $productid => $storelist)//$storename => $storelist
				{
					if (empty($listsubcategories[$productid])) $listsubcategories[$productid] = array();
					foreach ($storelist as $storeid => $listdatavalues)
					{
						if (empty($listsubcategories[$productid][$storeid])) $listsubcategories[$productid][$storeid] = array();
						$listsubcategories[$productid][$storeid]['id'] = $productid;
						$listsubcategories[$productid][$storeid]['ten'] = $productlistobject[$productid]['name'];
						$listsubcategories[$productid][$storeid]['sieuthi'] = $storeList[$storeid];
						if (empty($listsubcategories[$productid][$storeid]['dauky'])) $listsubcategories[$productid][$storeid]['dauky'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhapmua'])) $listsubcategories[$productid][$storeid]['nhapmua'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhapnoibo'])) $listsubcategories[$productid][$storeid]['nhapnoibo'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhaptralai'])) $listsubcategories[$productid][$storeid]['nhaptralai'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhapkhac'])) $listsubcategories[$productid][$storeid]['nhapkhac'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuatban'])) $listsubcategories[$productid][$storeid]['xuatban'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuatnoibo'])) $listsubcategories[$productid][$storeid]['xuatnoibo'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuattramuahang'])) $listsubcategories[$productid][$storeid]['xuattramuahang'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuatkhac'])) $listsubcategories[$productid][$storeid]['xuatkhac'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['cuoiky'])) $listsubcategories[$productid][$storeid]['cuoiky'] = 0;
						//if (empty($listsubcategories[$productid][$storeid]['sucban'])) $listsubcategories[$productid][$storeid]['sucban'] = 0;
						$listsubcategories[$productid][$storeid]['vaitro'] = 0;
						$listsubcategories[$productid][$storeid]['phanloai'] = '';
						$listsubcategories[$productid][$storeid]['GFK'] = '';
						$listsubcategories[$productid][$storeid]['tonbanhang'] = 0;
						$listsubcategories[$productid][$storeid]['tonthucte'] = 0;

						foreach ($listdatavalues as $datavalues)
						{
							foreach ($datavalues as $date=>$values)
							{
								$listsubcategories[$productid][$storeid]['dauky'] += $values['soluongdauky'];
								$listsubcategories[$productid][$storeid]['nhapmua'] += $values['nhapmua'];
								$listsubcategories[$productid][$storeid]['nhapnoibo'] += $values['nhapnoibo'];
								$listsubcategories[$productid][$storeid]['nhaptralai'] += $values['nhaptralai'];
								$listsubcategories[$productid][$storeid]['nhapkhac'] += $values['nhapkhac'];
								$listsubcategories[$productid][$storeid]['xuatban'] += $values['xuatban'];
								$listsubcategories[$productid][$storeid]['xuatnoibo'] += $values['xuatnoibo'];
								$listsubcategories[$productid][$storeid]['xuattramuahang'] += $values['xuattramuahang'];
								$listsubcategories[$productid][$storeid]['xuatkhac'] += $values['xuatkhac'];
								$listsubcategories[$productid][$storeid]['cuoiky'] += $values['tonkho'];
							}
						}
						$listsubcategories[$productid][$storeid]['sucban'] = (($songay > 0) ? ceil($listsubcategories[$productid][$storeid]['xuatban']/$songay) : 0);
					}
				}
			}
			$assignparam['listsubcategories'] = $listsubcategories;
			$assignparam['tab'] = 2;
		}
		$this->registry->smarty->assign($assignparam);
		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'subcatevolume.tpl');

		return $content;
	}//end of function


	/**
	 * [subcateinstockvalue description]
	 * @param  [type] $startdate [description]
	 * @param  [type] $enddate   [description]
	 * @return [type]            [description]
	 */
	private function subcateinstockvalue($startdate , $enddate , $begindate, $productlist, $productlistobject)
	{
		set_time_limit(0);
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);//category parent
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$assignparam = array();
		$assignparam['startdate'] = date('d/m/Y', $startdate);
		$assignparam['enddate'] = date('d/m/Y', $enddate);
		$assignparam['id'] = $id;
		$assignparam['storeid'] = $storeid;
		//end copy each funciton

		$productcategory = new Core_Productcategory($id, true);

		$storeList = Core_Store::getStoresFromCache(false);

		$listsubcategories = array();
		if(count($productlist) > 0 && ($startdate < $enddate))
		{
			$listdatastores = array();
			foreach ($storeList as $storeid => $storename)
			{
				$dataidlist = array('product' => $productlist,
										'store' => $storeid,
										'groupstore' => 1,
										);
				$detailvalues = array('soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'trigiadauky' , 'trigianhapmua' , 'trigianhapnoibo' , 'trigianhaptra' , 'trigianhapkhac' , 'trigiaxuatban' , 'trigiaxuatnoibo' , 'trigiaxuattra' , 'trigiaxuatkhac' ,  'stonkho' , 'trigiacuoiky' , 'giavoncuoiky' , 'giavondauky' , 'sucban');
				$mastervalues = array();

				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
				if (!empty($data['data'][$storeid]))
				{
					$datalist = $data['data'][$storeid];
					//foreach ($datalist as $productid => $listdatedatas)
					foreach ($datalist as $productid => $datavalue)
					{
						$listdatastores[$productid][$storeid][] = $datavalue;
					}
					unset($datalist);
				}
			}
			if (!empty($listdatastores))
			{
				$songay = ($enddate - $startdate) / (24*3600) + 1;
				foreach ($listdatastores as $productid => $storelist)//$storename => $storelist
				{
					if (empty($listsubcategories[$productid])) $listsubcategories[$productid] = array();
					foreach ($storelist as $storeid => $listdatavalues)
					{
						if (empty($listsubcategories[$productid][$storeid])) $listsubcategories[$productid][$storeid] = array();
						$listsubcategories[$productid][$storeid]['id'] = $productid;
						$listsubcategories[$productid][$storeid]['ten'] = $productlistobject[$productid]['name'];
						$listsubcategories[$productid][$storeid]['sieuthi'] = $storeList[$storeid];
						if (empty($listsubcategories[$productid][$storeid]['dauky'])) $listsubcategories[$productid][$storeid]['dauky'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigiadauky'])) $listsubcategories[$productid][$storeid]['trigiadauky'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['giavondauky'])) $listsubcategories[$productid][$storeid]['giavondauky'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhapmua'])) $listsubcategories[$productid][$storeid]['nhapmua'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigianhapmua'])) $listsubcategories[$productid][$storeid]['trigianhapmua'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhapnoibo'])) $listsubcategories[$productid][$storeid]['nhapnoibo'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigianhapnoibo'])) $listsubcategories[$productid][$storeid]['trigianhapnoibo'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhaptralai'])) $listsubcategories[$productid][$storeid]['nhaptralai'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigianhaptra'])) $listsubcategories[$productid][$storeid]['trigianhaptra'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['nhapkhac'])) $listsubcategories[$productid][$storeid]['nhapkhac'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigianhapkhac'])) $listsubcategories[$productid][$storeid]['trigianhapkhac'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuatban'])) $listsubcategories[$productid][$storeid]['xuatban'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigiaxuatban'])) $listsubcategories[$productid][$storeid]['trigiaxuatban'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuatnoibo'])) $listsubcategories[$productid][$storeid]['xuatnoibo'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigiaxuatnoibo'])) $listsubcategories[$productid][$storeid]['trigiaxuatnoibo'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuattramuahang'])) $listsubcategories[$productid][$storeid]['xuattramuahang'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigiaxuattra'])) $listsubcategories[$productid][$storeid]['trigiaxuattra'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['xuatkhac'])) $listsubcategories[$productid][$storeid]['xuatkhac'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigiaxuatkhac'])) $listsubcategories[$productid][$storeid]['trigiaxuatkhac'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['cuoiky'])) $listsubcategories[$productid][$storeid]['cuoiky'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['trigiacuoiky'])) $listsubcategories[$productid][$storeid]['trigiacuoiky'] = 0;
						if (empty($listsubcategories[$productid][$storeid]['giavoncuoiky'])) $listsubcategories[$productid][$storeid]['giavoncuoiky'] = 0;

						$listsubcategories[$productid][$storeid]['tocdoban'] = 'N/A';
						$listsubcategories[$productid][$storeid]['vaitro'] = 'N/A';
						$listsubcategories[$productid][$storeid]['phanloai'] = 'N/A';

						foreach ($listdatavalues as $datavalues)
						{
							foreach ($datavalues as $date=>$values)
							{
								$listsubcategories[$productid][$storeid]['dauky'] += $values['soluongdauky'];
								$listsubcategories[$productid][$storeid]['trigiadauky'] += $values['trigiadauky'];
								$listsubcategories[$productid][$storeid]['nhapmua'] += $values['nhapmua'];
								$listsubcategories[$productid][$storeid]['trigianhapmua'] += $values['trigianhapmua'];
								$listsubcategories[$productid][$storeid]['nhapnoibo'] += $values['nhapnoibo'];
								$listsubcategories[$productid][$storeid]['trigianhapnoibo'] += $values['trigianhapnoibo'];
								$listsubcategories[$productid][$storeid]['nhaptralai'] += $values['nhaptralai'];
								$listsubcategories[$productid][$storeid]['trigianhaptra'] += $values['trigianhaptra'];
								$listsubcategories[$productid][$storeid]['nhapkhac'] += $values['nhapkhac'];
								$listsubcategories[$productid][$storeid]['trigianhapkhac'] += $values['trigianhapkhac'];
								$listsubcategories[$productid][$storeid]['xuatban'] += $values['xuatban'];
								$listsubcategories[$productid][$storeid]['trigiaxuatban'] += $values['trigiaxuatban'];
								$listsubcategories[$productid][$storeid]['xuatnoibo'] += $values['xuatnoibo'];
								$listsubcategories[$productid][$storeid]['trigiaxuatnoibo'] += $values['trigiaxuatnoibo'];
								$listsubcategories[$productid][$storeid]['xuattramuahang'] += $values['xuattramuahang'];
								$listsubcategories[$productid][$storeid]['trigiaxuattra'] += $values['trigiaxuattra'];
								$listsubcategories[$productid][$storeid]['xuatkhac'] += $values['xuatkhac'];
								$listsubcategories[$productid][$storeid]['trigiaxuatkhac'] += $values['trigiaxuatkhac'];
								$listsubcategories[$productid][$storeid]['cuoiky'] += $values['tonkho'];
								$listsubcategories[$productid][$storeid]['trigiacuoiky'] += $values['trigiacuoiky'];
								$listsubcategories[$productid][$storeid]['giavoncuoiky'] += $values['giavoncuoiky'];
							}
						}
						$listsubcategories[$productid][$storeid]['sucban'] = (($songay > 0) ? ceil($listsubcategories[$productid][$storeid]['xuatban']/$songay) : 0);
					}
				}
			}

			$assignparam['tab'] = 3;
			$assignparam['listsubcategories'] = $listsubcategories;
		}

		$this->registry->smarty->assign($assignparam);
		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'subcatevalue.tpl');

		return $content;
	}//end of function

	/**
	 * [subcatepricesegmentAction description]
	 * @return [type] [description]
	 */
	public function subcatepricesegmentAction()
	{
		global $conf;
		set_time_limit(0);

		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy(urldecode($_GET['enddate'])):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime("+1 day" , $relenddate);
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

		$id = (int)(isset($_GET['id'])?$_GET['id']:0);//category parent
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		$tab =  (isset($_GET['tab'])) ? (int)$_GET['tab'] : 1;

		$productcategory = new Core_Productcategory($id , true);

		$strvid = (string)$_GET['vid'];

		$vidarr = array();
		if(strlen($strvid) > 0)
		{
			$vidarr = explode(',', $strvid);
		}

		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . (count($vidarr) > 0 ? implode('' , $vidarr) : '') . 'subcatepricesegmentAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			//caculate data
			$lineChartData = array();
			$pieChartData = array();
			$listsegdata = array();
			$refineData = array();
			$songay = ceil(($enddate - $startdate) / 86400);
			if($productcategory->id > 0)
			{
				$sdoanhthu = 0;
				$slaigop = 0;
				$smargin = 0;
				$sgiatritonkho = 0;
				$ssoluong = 0;
				$sgiatritrungbinhitem = 0;

				//lay phan khuc gia
				$filterlist = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id);
				$listpricesegment = $filterlist['gia']['values'];

				if(empty($listpricesegment))
				{
					$url = $this->registry->conf['rooturl'].'stat/report/productcategory/?id='.$productcategory->id;
					header('Location: '. $url);
					exit();
				}

				if(count($listpricesegment) > 0)
				{
					$productallcategorylist = Core_Productcategory::getProductcategoryListFromCache();
					foreach ($listpricesegment as $segslug => $segdata)
					{
						if (empty($segslug)) continue;
						$fvalue['gia'] = array($segslug);
						$itemssoluongthucban = 0;
						$itemsdoanhthu = 0;
						$itemsgiabantrungbinhcovat = 0;
						$itemsgiabantrungbinh = 0;
						$itemsgiavontrungbinh = 0;
						$itemslaigop = 0;
						$itemsmargin = 0;
						$itemtrigiacuoiky = 0;
						$itemsoluongton = 0;
						$itemngaybanhang = 0;
						$itemstralai = 0;
						$itemsdoanhthutralai = 0;

						$segitem = array();

						$segitem['numskus'] = 0;

						if (!empty($vidarr))
						{
							$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																							'fpcid' => $productcategory->id,
																							'fvidarr' => $vidarr,
																							'fvalue' => $fvalue,
																							) , 'id' , 'ASC');

							$productidlist = array_keys($productlist);
							$dataidlist = array('product' => $productidlist,
												'store' => $storeid,
												);
							if($storeid > 0)
							{
								$dataidlist['groupstore'] = 1;
							}

							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai' , 'sdoanhthutralai');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
							//get data of line chart
							if(count($data['data'][$storeid]) > 0)
							{
								$segitem['numskus'] = count($data['data'][$storeid]);
								foreach ($data['data'][$storeid] as $pid => $datacharts)
								{
									foreach ($datacharts as $date => $value)
									{
										$xdtdate = date('d/m' , $date);

										switch ($chartby)
										{
											case 'revenue':
												$refineData[$segdata['name']][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[$segdata['name']][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[$segdata['name']][$xdtdate] += $value['laigop'];
												break;
										}
									}
								}
							}

							$itemssoluongthucban += $data['datamaster']['ssoluongthucban'];
							$itemsdoanhthu += $data['datamaster']['sdoanhthu'];
							$itemsgiabantrungbinhcovat += $data['datamaster']['sgiabantrungbinhcovat'];
							$itemsgiabantrungbinh += $data['datamaster']['sgiabantrungbinh'];
							$itemsgiavontrungbinh += $data['datamaster']['sgiavontrungbinh'];
							$itemslaigop += $data['datamaster']['slaigop'];
							$itemsmargin += $data['datamaster']['smargin'];
							$itemtrigiacuoiky += $data['datamaster']['trigiacuoiky'];
							$itemngaybanhang += $data['datamaster']['ngaybanhang'];
							$itemstralai += $data['datamaster']['stralai'];
							$itemsdoanhthutralai += $data['datamaster']['sdoanhthutralai'];

							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$slaigop += $data['datamaster']['slaigop'];
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];
						}
						else
						{
							$dataidlist = array('category' => $productcategory->id,
												'pricesegment' => str_replace('-', '', $segslug),
												'store' => $storeid,
												);

							if($storeid > 0)
							{
								$dataidlist['groupstore'] = 1;
							}

							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai' , 'stonkho', 'sdoanhthutralai');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

							//get data of line chart
							if(count($data['data'][$storeid]) > 0)
							{
								foreach ($data['data'][$storeid] as $pid => $datacharts)
								{
									foreach ($datacharts as $date => $value)
									{
										$xdtdate = date('d/m' , $date);

										switch ($chartby)
										{
											case 'revenue':
												$refineData[$segdata['name']][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[$segdata['name']][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[$segdata['name']][$xdtdate] += $value['laigop'];
												break;
										}
									}

									if (!empty($productallcategorylist[$productcategory->id]['child']))
									{
										foreach ($productallcategorylist[$productcategory->id]['child'] as $childskus)
										{
											$listnumofskusproducts = Core_Stat::getData(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('category' => $childskus, 'pricesegment' => str_replace('-', '', $segslug), 'outputstore' => $storeid), $startdate , $enddate);
											$listnumofskusproducts = str_replace('#', ',', $listnumofskusproducts);
											$listnumofproductids = array();
											if (!empty($listnumofskusproducts)) {
												foreach ($listnumofskusproducts as $dtsku => $dtskuval) {
													$listnumofproductids = array_merge($listnumofproductids, json_decode($dtskuval, true));
												}
												$listnumofproductids = array_unique($listnumofproductids);
												$segitem['numskus'] += count($listnumofproductids);
											}
										}
									}
									else
									{
										$listnumofskusproducts = Core_Stat::getData(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('category' => $productcategory->id, 'pricesegment' => str_replace('-', '', $segslug), 'outputstore' => $storeid), $startdate , $enddate);

										$listnumofskusproducts = str_replace('#', ',', $listnumofskusproducts);
										$listnumofproductids = array();
										if (!empty($listnumofskusproducts))
										{
											foreach ($listnumofskusproducts as $dtsku => $dtskuval)
											{
												$listnumofproductids = array_merge($listnumofproductids, json_decode($dtskuval, true));
											}
											$listnumofproductids = array_unique($listnumofproductids);
											$segitem['numskus'] += count($listnumofproductids);
										}
									}
								}
							}

							$itemssoluongthucban += $data['datamaster']['ssoluongthucban'];
							$itemsdoanhthu += $data['datamaster']['sdoanhthu'];
							$itemsgiabantrungbinhcovat += $data['datamaster']['sgiabantrungbinhcovat'];
							$itemsgiabantrungbinh += $data['datamaster']['sgiabantrungbinh'];
							$itemsgiavontrungbinh += $data['datamaster']['sgiavontrungbinh'];
							$itemslaigop += $data['datamaster']['slaigop'];
							$itemsmargin += $data['datamaster']['smargin'];
							$itemtrigiacuoiky += $data['datamaster']['trigiacuoiky'];
							$itemsoluongton += $data['datamaster']['stonkho'];
							$itemngaybanhang += $data['datamaster']['ngaybanhang'];
							$itemstralai += $data['datamaster']['stralai'];
							$itemsdoanhthutralai += $data['datamaster']['sdoanhthutralai'];

							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$slaigop += $data['datamaster']['slaigop'];
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];


							//if (!empty($productallcategorylist[]))
						}


						$segitem['tenphankhuc']     = $segdata['name'];
						$segitem['nameseo']         = $segslug;
						$segitem['mucdonggop']      = '';
						$segitem['soluong']         = $itemssoluongthucban;
						$segitem['doanhthu']        = $itemsdoanhthu;
						$segitem['giabancovat']     = $itemsgiabantrungbinhcovat;
						$segitem['giabanchuavat']   = $itemsgiabantrungbinh;
						$segitem['giavontrungbinh'] = $itemsgiavontrungbinh;
						$segitem['laigop']          = $itemslaigop;
						$segitem['margin']          = ($itemsdoanhthu > 0) ? round((($itemslaigop * 100 /$itemsdoanhthu)) , 2) : 0;
						$segitem['giatriton']       = $itemtrigiacuoiky;
						$segitem['ngaybanhang']     = ($itemsdoanhthu > 0) ? round((($itemtrigiacuoiky * $songay /$itemsdoanhthu)) , 2) : 0;//$itemngaybanhang;
						$segitem['tralai']          = $itemstralai;
						$segitem['tonkho']          = $itemsoluongton;
						$segitem['doanhthutralai']  = $itemsdoanhthutralai;
						/*
						//summary info
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$slaigop += $data['datamaster']['slaigop'];
						$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
						$ssoluong += $data['datamaster']['ssoluongthucban'];
						*/

						$listsegdata[] = $segitem;
						unset($segitem);
					}

					/*$productlist = array();
					foreach ($listpricesegment as $segslug => $segdata)
					{
						if (empty($segslug)) continue;
						$fvalue['gia'] = array($segslug);
						if (!empty($vidarr))
						{
							$productlistchild = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																							'fpcid' => $productcategory->id,
																							'fvidarr' => $vidarr,
																							'fvalue' => $fvalue,
																							) , 'id' , 'ASC');
							$productlist = $this->mergeProductList($productlist, $productlistchild);
						}
					}
					if (!empty($productlist))
					{

					}
					else
					{
						foreach ($listpricesegment as $segslug => $segdata)
						{
							if (empty($segslug)) continue;

							$itemssoluongthucban = 0;
							$itemsdoanhthu = 0;
							$itemsgiabantrungbinhcovat = 0;
							$itemsgiabantrungbinh = 0;
							$itemsgiavontrungbinh = 0;
							$itemslaigop = 0;
							$itemsmargin = 0;
							$itemtrigiacuoiky = 0;
							$itemsoluongton = 0;
							$itemngaybanhang = 0;
							$itemstralai = 0;

							$fvalue['gia'] = array($segslug);
							$dataidlist = array('category' => $productcategory->id,
												'pricesegment' => str_replace('-', '', $segslug),
												'store' => $storeid,
												);

							if($storeid > 0)
							{
								$dataidlist['groupstore'] = 1;
							}

							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai' , 'stonkho');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

							//get data of line chart
							if(count($data['data'][$storeid]) > 0)
							{
								foreach ($data['data'][$storeid] as $pid => $datacharts)
								{
									foreach ($datacharts as $date => $value)
									{
										$xdtdate = date('d/m' , $date);

										switch ($chartby)
										{
											case 'revenue':
												$refineData[$segdata['name']][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[$segdata['name']][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[$segdata['name']][$xdtdate] += $value['laigop'];
												break;
										}
									}
								}
							}

							$itemssoluongthucban += $data['datamaster']['ssoluongthucban'];
							$itemsdoanhthu += $data['datamaster']['sdoanhthu'];
							$itemsgiabantrungbinhcovat += $data['datamaster']['sgiabantrungbinhcovat'];
							$itemsgiabantrungbinh += $data['datamaster']['sgiabantrungbinh'];
							$itemsgiavontrungbinh += $data['datamaster']['sgiavontrungbinh'];
							$itemslaigop += $data['datamaster']['slaigop'];
							$itemsmargin += $data['datamaster']['smargin'];
							$itemtrigiacuoiky += $data['datamaster']['trigiacuoiky'];
							$itemsoluongton += $data['datamaster']['stonkho'];
							$itemngaybanhang += $data['datamaster']['ngaybanhang'];
							$itemstralai += $data['datamaster']['stralai'];

							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$slaigop += $data['datamaster']['slaigop'];
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];

							$segitem = array();
							$segitem['tenphankhuc']     = $segdata['name'];
							$segitem['nameseo']         = $segslug;
							$segitem['mucdonggop']      = '';
							$segitem['soluong']         = $itemssoluongthucban;
							$segitem['doanhthu']        = $itemsdoanhthu;
							$segitem['giabancovat']     = $itemsgiabantrungbinhcovat;
							$segitem['giabanchuavat']   = $itemsgiabantrungbinh;
							$segitem['giavontrungbinh'] = $itemsgiavontrungbinh;
							$segitem['laigop']          = $itemslaigop;
							$segitem['margin']          = ($itemsdoanhthu > 0) ? round((($itemslaigop * 100 /$itemsdoanhthu)) , 2) : 0;
							$segitem['giatriton']       = $itemtrigiacuoiky;
							$segitem['ngaybanhang']     = $itemngaybanhang;
							$segitem['tralai']          = $itemstralai;
							$segitem['tonkho']          = $itemsoluongton;
						}
					}*/
					//muc do dong gop cua phan khuc gia
					$listdata = $listsegdata;
					$listsegdata = array();
					foreach ($listdata as $segitem)
					{
						if (empty($segitem)) {
							continue;
						}
						$item = array();

						$item['tenphankhuc'] = $segitem['tenphankhuc'];
						$item['nameseo'] = $segitem['nameseo'];
						$item['soluong'] = $segitem['soluong'];
						$item['doanhthu'] = $segitem['doanhthu'];
						$item['giabancovat'] = $segitem['giabancovat'];
						$item['giabanchuavat'] = $segitem['giabanchuavat'];
						$item['giavontrungbinh'] = $segitem['giavontrungbinh'];
						$item['laigop'] = $segitem['laigop'];
						$item['margin'] = $segitem['margin'];
						$item['giatriton'] = $segitem['giatriton']; // chua tinh ra
						$item['ngaybanhang'] =$segitem['ngaybanhang'];
						$item['tralai'] =$segitem['tralai'];
						$item['doanhthutralai'] =$segitem['doanhthutralai'];
						$item['tonkho'] =$segitem['tonkho'];
						$item['numskus'] =$segitem['numskus'];

						if($sdoanhthu != 0 && $ssoluong != 0 && $slaigop != 0)
						{
							$item['mucdonggop'] = 'V' . abs(ceil($segitem['soluong'] / $ssoluong *100)) . ' , R' . abs(ceil($segitem['doanhthu'] / $sdoanhthu * 100)) . ' ,P' . abs(ceil($segitem['laigop'] / $slaigop * 100));
						}
						else
						{
							$item['mucdonggop'] = 'N/A';
						}

						$listsegdata[$item['tenphankhuc']] = $item;

						$lineChartData[$item['tenphankhuc']] = $refineData[$item['tenphankhuc']];
						switch ($chartby)
						{
							case 'revenue':
								$pieChartData[$item['tenphankhuc']] = ($sdoanhthu > 0) ? abs(round(($item['doanhthu'] / $sdoanhthu * 100) , 2)) : 0;
								break;

							case 'volume':
								$pieChartData[$item['tenphankhuc']] = ($ssoluong > 0) ? abs(round(($item['soluong'] / $ssoluong * 100) , 2)) : 0;
								break;

							case 'profit':
								$pieChartData[$item['tenphankhuc']] = ($slaigop > 0) ? abs(round(($item['laigop'] / $slaigop * 100) , 2)) : 0;
								break;
						}
					}

					//tinh sum
					$smargin = ($sdoanhthu > 0) ? round((($slaigop * 100 /$sdoanhthu)) , 2) : 0;
					$sgiatritrungbinhitem = ($ssoluong > 0)	 ? ($sdoanhthu / $ssoluong) : 0;

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
				}
			}
			///////////////////////////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);

			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);

			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////

			$paramurl = '?id='.$id;
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				if (empty($urlparam)) $urlparam = 'fsid='.urlencode($_GET['fsid']);
				else $urlparam .= '&fsid='.urlencode($_GET['fsid']);
			}

			if(strlen($strvid))
				$paramurl .= '&vid=' . $strvid;

			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'productcategoryinfo' => $productcategory,
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
											'listsegdata' => $listsegdata,
											'sdoanhthu' => $sdoanhthu,
											'ssoluong' => $ssoluong,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'strigiatonkho' => $sgiatritonkho,
											'strigiatrungbinhitem' => $sgiatritrungbinhitem,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'fullproductcategory' => $fullproductcategory,
											'listattributefilter' => $listattributefilter,
											'stepdate' => $stepdate,
											'songay' => $songay,
											));

			/////////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcatesegment.tpl');
			$myCache->save($content);
			echo $content;
			///////////////////////////////////////////////
			//$this->registry->smarty->display($this->registry->smartyControllerContainer . 'subcatesegment.tpl');
		}

	}//end of function

	/**
	 * [maincharacterAction description]
	 * @return [type] [description]
	 */
	public function maincharacterAction()
	{
		global $conf;
		set_time_limit(0);

		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy(urldecode($_GET['enddate'])):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime("+1 day" , $relenddate);
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

		$id = (int)(isset($_GET['id'])?$_GET['id']:0);//category parent
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		$productcategory = new Core_Productcategory($id , true);

		$panamefilter = (string)$_GET['pa'];

		$strvid = (string)$_GET['vid'];

		$vidarr = array();
		if(strlen($strvid) > 0)
		{
			$vidarr = explode(',', $strvid);
		}

		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . (count($vidarr) > 0 ? implode('' , $vidarr) : '') . $panamefilter . 'maincharacterAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' . $filename))
		{
			$content= $myCache->get();
			echo $content;
		}
		else
		{
			$sdoanhthu = 0;
			$ssoluong = 0;
			$slaigop = 0;
			$stonkho = 0;
			$strigiatrungbinhitem = 0;
			$smargin = 0;
			$strigiacuoiky = 0;
			$songay = ceil(($enddate - $startdate) / 86400);
			if($productcategory->id > 0 && strlen($panamefilter) > 0)//
			{
				//caculate data
				$lineChartData = array();
				$pieChartData = array();
				$listattrdata = array();
				$refineData = array();

				//lay phan khuc gia
				$filterlist = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id);
				$attriburefilterlist = $filterlist[$panamefilter]['values'];

				$productallcategorylist = Core_Productcategory::getProductcategoryListFromCache();

				//echodebug($panamefilter);
				//echodebug($attriburefilterlist, true);
				if(count($attriburefilterlist) > 0)
				{
					foreach ($attriburefilterlist as $attrname => $datavalue)
					{
						$fvalue[$panamefilter][] = $attrname;

						$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																						'fpcid' => $productcategory->id,
																						'fvidarr' => $vidarr,
																						'fvalue' => $fvalue,
																						) , 'id' , 'ASC');
						$productidlist = array_keys($productlist);
						$attritem = array();
						$attritem['tengiatrithuoctinh'] = $datavalue['name'];
						$attritem['nameseo']            = $panamefilter;//.','.$attrname;//$datavalue['value'];
						$attritem['filterseo']          = $attrname;
						$attritem['mucdonggop']         = '';
						$attritem['numskus']      = 0;

						if (!empty($vidarr))
						{
							foreach ($vidarr as $nvid)
							{
								$dataidlist = array('product' => $productidlist,
													//'character' => str_replace('-', '', $attrname),
													'store' => $storeid,
													//'vendor' => $nvid,
													);
								if($storeid > 0)
								{
									$dataidlist['groupstore'] = 1;
								}
								$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
								$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai', 'sdoanhthutralai', 'stonkho');

								$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

								//get data of line chart
								if(count($data['data'][$storeid]) > 0)
								{
									foreach ($data['data'][$storeid] as $pid => $datacharts)
									{
										foreach ($datacharts as $date => $value)
										{
											$xdtdate = date('d/m' , $date);

											switch ($chartby)
											{
												case 'revenue':
													$refineData[$attrname][$xdtdate] += $value['doanhthuthucte'];
													break;

												case 'volume':
													$refineData[$attrname][$xdtdate] += $value['soluongthucban'];
													break;

												case 'profit':
													$refineData[$attrname][$xdtdate] += $value['laigop'];
													break;
											}
										}
									}
								}


								$attritem['soluong']            += $data['datamaster']['ssoluongthucban'];
								$attritem['doanhthu']           += $data['datamaster']['sdoanhthu'];
								$attritem['giabancovat']        += $data['datamaster']['sgiabantrungbinhcovat'];
								$attritem['giabanchuavat']      += $data['datamaster']['sgiabantrungbinh'];
								$attritem['giavontrungbinh']    += $data['datamaster']['sgiavontrungbinh'];
								$attritem['laigop']             += $data['datamaster']['slaigop'];
								$attritem['margin']             += $data['datamaster']['smargin'];
								$attritem['giatriton']          += $data['datamaster']['trigiacuoiky'];
								$attritem['ngaybanhang']        += $data['datamaster']['ngaybanhang'];
								$attritem['tralai']             += $data['datamaster']['stralai'];
								$attritem['doanhthutralai']             += $data['datamaster']['sdoanhthutralai'];

								$attritem['numskus']      += count($data['data'][$storeid]);


								//summary info
								$sdoanhthu += $data['datamaster']['sdoanhthu'];
								$ssoluong += $data['datamaster']['ssoluongthucban'];
								$slaigop += $data['datamaster']['slaigop'];
								$stonkho += $data['datamaster']['stonkho'];
								$strigiacuoiky += $data['datamaster']['trigiacuoiky'];
							}
						}
						else
						{
							$dataidlist = array('category' => $productcategory->id,
												'character' => str_replace('-', '', $attrname),
												'store' => $storeid
												);
							if($storeid > 0)
							{
								$dataidlist['groupstore'] = 1;
							}
							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai' , 'sdoanhthutralai', 'stonkho');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

							//get data of line chart
							if(count($data['data'][$storeid]) > 0)
							{
								foreach ($data['data'][$storeid] as $pid => $datacharts)
								{
									foreach ($datacharts as $date => $value)
									{
										$xdtdate = date('d/m' , $date);

										switch ($chartby)
										{
											case 'revenue':
												$refineData[$attrname][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[$attrname][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[$attrname][$xdtdate] += $value['laigop'];
												break;
										}
									}
								}
							}


							$attritem['soluong']            += $data['datamaster']['ssoluongthucban'];
							$attritem['doanhthu']           += $data['datamaster']['sdoanhthu'];
							$attritem['giabancovat']        += $data['datamaster']['sgiabantrungbinhcovat'];
							$attritem['giabanchuavat']      += $data['datamaster']['sgiabantrungbinh'];
							$attritem['giavontrungbinh']    += $data['datamaster']['sgiavontrungbinh'];
							$attritem['laigop']             += $data['datamaster']['slaigop'];
							$attritem['margin']             += $data['datamaster']['smargin'];
							$attritem['giatriton']          += $data['datamaster']['trigiacuoiky'];
							$attritem['ngaybanhang']        += $data['datamaster']['ngaybanhang'];
							$attritem['tralai']             += $data['datamaster']['stralai'];
							$attritem['doanhthutralai']             += $data['datamaster']['sdoanhthutralai'];

							$attritem['numskus']      = 0;
							if (!empty($productallcategorylist[$productcategory->id]['child']))
							{
								foreach ($productallcategorylist[$productcategory->id]['child'] as $childskus)
								{
									$listnumofskusproducts = Core_Stat::getData(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('category' => $childskus,'character' => str_replace('-', '', $attrname), 'outputstore' => $storeid), $startdate , $enddate);
									$listnumofskusproducts = str_replace('#', ',', $listnumofskusproducts);
									$listnumofproductids = array();
									if (!empty($listnumofskusproducts))
									{
										foreach ($listnumofskusproducts as $dtsku => $dtskuval)
										{
											$listnumofproductids = array_merge($listnumofproductids, json_decode($dtskuval, true));
										}
										$listnumofproductids = array_unique($listnumofproductids);
										$attritem['numskus'] += count($listnumofproductids);
									}
								}
							}
							else
							{
								$listnumofskusproducts = Core_Stat::getData(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('category' => $productcategory->id,'character' => str_replace('-', '', $attrname), 'outputstore' => $storeid), $startdate , $enddate);
								$listnumofskusproducts = str_replace('#', ',', $listnumofskusproducts);
								$listnumofproductids = array();
								if (!empty($listnumofskusproducts))
								{
									foreach ($listnumofskusproducts as $dtsku => $dtskuval)
									{
										$listnumofproductids = array_merge($listnumofproductids, json_decode($dtskuval, true));
									}
									$listnumofproductids = array_unique($listnumofproductids);
									$attritem['numskus'] += count($listnumofproductids);
								}
							}

							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];
							$slaigop += $data['datamaster']['slaigop'];
							$stonkho += $data['datamaster']['stonkho'];
							$strigiacuoiky += $data['datamaster']['trigiacuoiky'];
						}
						$strigiatrungbinhitem = ($ssoluong > 0) ? ($sdoanhthu / $ssoluong) : 0;
						$smargin = ($sdoanhthu> 0) ? round($slaigop * 100 / $sdoanhthu, 2) : 0;
						$attritem['ngaybanhang'] = ($attritem['doanhthu']> 0) ? round($attritem['giatriton'] * $songay / $attritem['doanhthu'], 2) : 0;

						$listattrdata[] = $attritem;

						unset($attritem);
					}

					//sort data
					switch ($sortby)
					{
						case 1:
							usort($listattrdata , 'cmp_revenue');
							break;

						case 2:
							usort($listattrdata , 'cmp_volume');
							break;

						case 3:
							usort($listattrdata , 'cmp_profit');
							break;
					}


					//muc do dong gop cua phan khuc gia
					$listdata = $listattrdata;
					$listattrdata = array();
					foreach ($listdata as $segitem)
					{
						$item                       = array();

						$item['tengiatrithuoctinh'] = $segitem['tengiatrithuoctinh'];
						$item['nameseo']            = $segitem['nameseo'];
						$item['filterseo']          = $segitem['filterseo'];
						$item['soluong']            = $segitem['soluong'];
						$item['doanhthu']           = $segitem['doanhthu'];
						$item['giabancovat']        = $segitem['giabancovat'];
						$item['giabanchuavat']      = $segitem['giabanchuavat'];
						$item['giavontrungbinh']    = $segitem['giavontrungbinh'];
						$item['laigop']             = $segitem['laigop'];
						$item['margin']             = $segitem['margin'];
						$item['giatriton']          = $segitem['giatriton']; // chua tinh ra
						$item['ngaybanhang']        = $segitem['ngaybanhang'];
						$item['tralai']             = $segitem['tralai'];
						$item['doanhthutralai']             = $segitem['doanhthutralai'];
						$item['numskus']             = $segitem['numskus'];

						if($sdoanhthu != 0 && $ssoluong != 0 && $slaigop != 0)
						{
							$item['mucdonggop'] = 'V' . abs(ceil($segitem['soluong'] / $ssoluong *100)) . ' , R' . abs(ceil($segitem['doanhthu'] / $sdoanhthu * 100)) . ' ,P' . abs(ceil($segitem['laigop'] / $slaigop * 100));
						}
						else
						{
							$item['mucdonggop'] = 'N/A';
						}

						$listattrdata[$item['tengiatrithuoctinh']] = $item;

						$lineChartData[$item['tengiatrithuoctinh']] = $refineData[Helper::codau2khongdau($item['tengiatrithuoctinh'],true,true)];
						switch ($chartby)
						{
							case 'revenue':
								$pieChartData[$item['tengiatrithuoctinh']] = ($sdoanhthu > 0) ? abs(round(($item['doanhthu'] / $sdoanhthu * 100) , 2)) : 0;
								break;

							case 'volume':
								$pieChartData[$item['tengiatrithuoctinh']] = ($ssoluong > 0) ? abs(round(($item['soluong'] / $ssoluong * 100) , 2)) : 0;
								break;

							case 'profit':
								$pieChartData[$item['tengiatrithuoctinh']] = ($slaigop > 0) ? abs(round(($item['laigop'] / $slaigop * 100) , 2)) : 0;
								break;
						}
					}
				}
			}
			///////////////////////////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);

			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);
			if (empty($listattributefilter))
			{
				$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , false);
			}
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////
			//////////////////////////////////////////////////////////////////

			$paramurl = '?id='.$id;
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$urlparam = '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				if (empty($urlparam)) $urlparam = 'fsid='.urlencode($_GET['fsid']);
				else $urlparam .= '&fsid='.urlencode($_GET['fsid']);
			}

			if(strlen($strvid))
				$paramurl .= '&vid=' . $strvid;



			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'productcategoryinfo' => $productcategory,
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
											'listattrdata' => $listattrdata,
											'sdoanhthu' => $sdoanhthu,
											'ssoluong' => $ssoluong,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'strigiatonkho' => $strigiacuoiky,
											'strigiatrungbinhitem' => $strigiatrungbinhitem,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'fullproductcategory' => $fullproductcategory,
											'listattributefilter' => $listattributefilter,
											'stepdate' => $stepdate,
											'panamefilter' => $panamefilter,
											'songay' => $songay,
											));

			/////////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcateattribute.tpl');
			$myCache->save($content);
			echo $content;
			///////////////////////////////////////////////
			//$this->registry->smarty->display($this->registry->smartyControllerContainer . 'subcateattribute.tpl');
		}

	}//end of function

	/**
	 * [catestoreAction description]
	 * @return [type] [description]
	 */
	public function catestoreAction()
	{
		global $conf;
		set_time_limit(0);

		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$sid = (int)(isset($_GET['fsid'])?$_GET['fsid']:0);
		$storelist = Core_Store::getStoresFromCache();
		$newstorelist = array();
		if ($sid > 0 && !empty($storelist[$sid]))
		{
			$newstorelist = array($sid => $storelist[$sid]);
		}

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');
		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy(urldecode($_GET['enddate'])):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime("+1 day" , $relenddate);
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

		$searchstring = (string)(isset($_GET['a'])?$_GET['a']:'');

		//xu ly chuoi filter cua san pham
		$searchdata = array();
		if(strlen($searchstring))
		{
			$fvalue = array();
			$searchstringarr = explode(',', $searchstring);
			for($i = 0 , $ilen = count($searchstringarr) ; $i < $ilen ; $i+=2)
			{
				$fvalue[$searchstringarr[$i]][] = $searchstringarr[$i+1];
				$searchdata[] = $searchstringarr[$i];
				$searchdata[] = $searchstringarr[$i+1];
			}
		}

		$strvid = (string)(isset($_GET['vid'])?$_GET['vid']:'');

		$vidarr = array();
		if(strlen($strvid) > 0)
		{
			$vidarr = explode(',', $strvid);
		}

		///////////////////////////////////////////
		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit
		$productcategory = new Core_Productcategory($id, true);

		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $sid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . (count($vidarr) > 0 ? implode('' , $vidarr) : '') . (count($searchdata) > 0 ?  implode('' , $searchdata) : '') . 'catestoreAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(!isset($_GET['live']) && file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			$songay = ceil(($enddate - $startdate) / 86400);
			if($productcategory->id > 0)
			{
				$listcatestores = array();
				//summary info
				$sdoanhthu = 0;
				$ssoluong = 0;
				$slaigop = 0;
				$stonkho = 0;
				$smargin = 0;
				$sgiatritrungbinhitem = 0;
				$sgiatritonkho = 0;
				$ssoluongnhap = 0;
				$strigianhap = 0;
				$ssoluongtra = 0;
				$strigiatralai = 0;


				$refineData = array();
				$lineChartData = array();
				$pieChartData = array();

				///////////////////////////////////////////////////////////////////
				//get all product of current category
				if(!empty($fvalue))
				{
					$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																							'fpcid' => $productcategory->id,
																							'fvidarr' => $vidarr,
																							'fvalue' => $fvalue,
																							) , 'id' , 'ASC');

				}
				elseif (!empty($vidarr))
				{
					$productlist = Core_Productcategory::getProductlistFromCache($productcategory->id , $vidarr);
					//Neu la nganh hang cha thi cho nay ko ra
				}

				//get data
				if(!empty($productlist))
				{
					$productidlist = array_keys($productlist);

					//lay tat ca cac mau cua san pham

					$runstorelist = $storelist;
					//if (!empty($newstorelist)) $runstorelist = $newstorelist;
					foreach ($runstorelist as $storeid => $storename)
					{
						$storeitem = array();

						$dataidlist = array('product' => $productidlist,
												'store' => $storeid,
												'groupstore' => 1,
												);
						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'slaigop' , 'smargin' , 'giatritrungbinhitem' , 'laiitem' , 'trigiacuoiky' , 'ngaybanhang', 'stralai' , 'sgiatrihangtralai' , 'snhaptrongky' , 'strigianhap', 'stonkho');

						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

						//get data of line chart
						if(!empty($data['data'][$storeid]))
						{
							foreach ($data['data'][$storeid] as $pid => $datacharts)
							{
								foreach ($datacharts as $date => $value)
								{
									$xdtdate = date('d/m' , $date);

									switch ($chartby)
									{
										case 'revenue':
											$refineData[$storename][$xdtdate] += $value['doanhthuthucte'];
											break;

										case 'volume':
											$refineData[$storename][$xdtdate] += $value['soluongthucban'];
											break;

										case 'profit':
											$refineData[$storename][$xdtdate] += $value['laigop'];
											break;
									}
								}
							}
						}
						//info
						$storeitem['storeid']             = $storeid;
						$storeitem['storename']           = $storename;
						$storeitem['soluong']             = $data['datamaster']['ssoluongthucban'];
						$storeitem['doanhthu']            = $data['datamaster']['sdoanhthu'];
						$storeitem['laigop']              = $data['datamaster']['slaigop'];
						$storeitem['margin']              = $data['datamaster']['smargin'];
						$storeitem['giatritrungbinhitem'] = $data['datamaster']['giatritrungbinhitem'];
						$storeitem['laiitem']             = $data['datamaster']['laiitem'];
						$storeitem['giatritonkho']        = $data['datamaster']['trigiacuoiky'];
						$storeitem['ngaybanhang']         = ($storeitem['doanhthu'] > 0 ? round($storeitem['giatritonkho'] * $songay / $storeitem['doanhthu'], 2) : 0);//$data['datamaster']['ngaybanhang'];
						$storeitem['tralai']              = $data['datamaster']['stralai'];
						$storeitem['giatrihangtralai']    = $data['datamaster']['sgiatrihangtralai'];

						if ($sid <=0 || $sid ==  $storeid)
						{
							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];
							$slaigop += $data['datamaster']['slaigop'];
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluongnhap += $data['datamaster']['snhaptrongky'];
							$strigianhap += $data['datamaster']['strigianhap'];
							$ssoluongtralai += $data['datamaster']['stralai'];
							$strigiatralai += $data['datamaster']['sgiatrihangtralai'];
							$stonkho += $data['datamaster']['stonkho'];
						}
						$listcatestores[$storename] = $storeitem;

					}
				}
				else
				{
					/*$productcategorysublist = Core_Productcategory::getFullSubCategoryFromRedisCache($productcategory->id , 10);
					$subcatidlist = array_keys($productcategorysublist);
					if ($productcategory->parentid >0 && !in_array($productcategory->id, $subcatidlist)) $subcatidlist[] = $productcategory->id;
					*/
					//dat tinh cache rieng cho nganh hang cha nen cat nao chi xai cho cache do
					$subcatidlist = array($productcategory->id);
					$runstorelist = $storelist;

					//if (!empty($newstorelist)) $runstorelist = $newstorelist;
					foreach ($runstorelist as $storeid => $storename)
					{
						$storeitem = array();
						$storeitem['storeid']             = $storeid;
						$storeitem['storename']           = $storename;
						$storeitem['soluong']             = 0;
						$storeitem['doanhthu']            = 0;
						$storeitem['laigop']              = 0;
						$storeitem['margin']              = 0;
						$storeitem['giatritrungbinhitem'] = 0;
						$storeitem['laiitem']             = 0;
						$storeitem['giatritonkho']        = 0;
						$storeitem['ngaybanhang']         = 0;
						$storeitem['tralai']              = 0;
						$storeitem['giatrihangtralai']    = 0;
						foreach ($subcatidlist as $cateid)
						{

							$dataidlist = array('category' => $cateid,
													'store' => $storeid,
													'groupstore' => 1,
													);
							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'slaigop' , 'smargin' , 'giatritrungbinhitem' , 'laiitem' , 'trigiacuoiky' , 'ngaybanhang', 'stralai' , 'sdoanhthutralai' , 'sgiatrihangtralai' , 'snhaptrongky' , 'strigianhap', 'stonkho');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
							//get data of line chart
							if(count($data['data'][$storeid]) > 0)
							{
								foreach ($data['data'][$storeid] as $pid => $datacharts)
								{
									foreach ($datacharts as $date => $value)
									{
										$xdtdate = date('d/m' , $date);
										if (empty($refineData[$storename][$xdtdate])) $refineData[$storename][$xdtdate] = 0;
										switch ($chartby)
										{
											case 'revenue':
												$refineData[$storename][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[$storename][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[$storename][$xdtdate] += $value['laigop'];
												break;
										}
									}
								}
							}
							//info

							$storeitem['soluong']             += $data['datamaster']['ssoluongthucban'];
							$storeitem['doanhthu']            += $data['datamaster']['sdoanhthu'];
							$storeitem['laigop']              += $data['datamaster']['slaigop'];
							//$storeitem['margin']              = $data['datamaster']['smargin'];
							$storeitem['giatritrungbinhitem'] += $data['datamaster']['giatritrungbinhitem'];
							$storeitem['laiitem']             += $data['datamaster']['laiitem'];
							$storeitem['giatritonkho']        += $data['datamaster']['trigiacuoiky'];
							$storeitem['ngaybanhang']         += $data['datamaster']['ngaybanhang'];
							$storeitem['tralai']              += $data['datamaster']['stralai'];
							$storeitem['doanhthutralai']      += $data['datamaster']['sdoanhthutralai'];
							$storeitem['giatrihangtralai']    += $data['datamaster']['sgiatrihangtralai'];

							if ($sid <=0 || $sid ==  $storeid)
							{
								//summary info
								$sdoanhthu += $data['datamaster']['sdoanhthu'];
								$ssoluong += $data['datamaster']['ssoluongthucban'];
								$slaigop += $data['datamaster']['slaigop'];
								$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
								$ssoluongnhap += $data['datamaster']['snhaptrongky'];
								$strigianhap += $data['datamaster']['strigianhap'];
								$ssoluongtralai += $data['datamaster']['stralai'];
								$strigiatralai += $data['datamaster']['sgiatrihangtralai'];
								$stonkho += $data['datamaster']['stonkho'];
							}
						}
						if ($storeitem['doanhthu'] != 0) $storeitem['margin'] = round(($storeitem['laigop'] * 100 / $storeitem['doanhthu']) ,2);
						$storeitem['ngaybanhang'] = ($storeitem['doanhthu'] > 0 ? round($storeitem['giatritonkho'] * $songay / $storeitem['doanhthu'], 2) : 0);//$data['datamaster']['ngaybanhang'];
						$listcatestores[$storename] = $storeitem;
					}
				}
				//summmary info
				$sgiatritrungbinhitem = ($ssoluong != 0) ? round(($sdoanhthu / $ssoluong) ,2) : 0;
				$smargin = ($sdoanhthu != 0) ? round(($slaigop * 100 /$sdoanhthu) ,2) : 0;


				//chart info
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

				if(count($listcatestores) > 0)
				{
					foreach ($listcatestores as $storename => $values)
					{
						$lineChartData[$storename] = $refineData[$storename];
						switch ($chartby)
						{
							case 'revenue':
								$pieChartData[$storename] = ($sdoanhthu > 0) ? round(($values['doanhthu'] * 100 / $sdoanhthu) , 2) : 0;
								break;

							case 'volume':
								$pieChartData[$storename] = ($ssoluong > 0) ? round(($values['soluong'] * 100 / $ssoluong) , 2): 0;
								break;

							case 'profit':
								$pieChartData[$storename] = ($slaigop > 0) ? round(($values['laigop']  * 100 / $slaigop) , 2) : 0;
								break;
						}
					}
				}

			}
			//////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);

			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);

			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////
			//////////////////////////////////////////////////////////////////
			//create paramurl
			$paramurl = '';
			$subparamurl = '?id='.$id;
			$paramurl = '?id='.$id;
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				$subparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				if (empty($urlparam)) $urlparam = 'fsid='.urlencode($_GET['fsid']);
				else $urlparam .= '&fsid='.urlencode($_GET['fsid']);
			}

			if(strlen($searchstring) > 0)
			{
				$paramurl .= '&a='.$searchstring;
				$subparamurl .= '&a='.$searchstring;
			}


			if(strlen($strvid))
			{
				$paramurl .= '&vid=' . $strvid;
				$subparamurl .= '&vid=' . $strvid;
			}

			//assgin template
			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'productcategoryinfo' => $productcategory,
											'startdate' => date('d/m/Y', $startdate),
											'enddate' => date('d/m/Y', $relenddate),
											'storeid'    => $sid,
											'sortby'	=> $sortby,
											'liststores' => $storelist,
											'sortby'     => $sortby,
											'chartby'	=> $chartby,
											'chartTitle' => $chartTitle,
											'lineChartData' => $lineChartData,
											'lineChartType' => 'line',
											'pieChartData' => $pieChartData,
											'pieChartType' => 'pie',
											'listcatestores' => $listcatestores,
											'sdoanhthu' => $sdoanhthu,
											'ssoluong' => $ssoluong,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'stonkho' => $stonkho,
											'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
											'sgiatritonkho' => $sgiatritonkho,
											'ssoluongnhap' => $ssoluongnhap,
											'strigianhap' => $strigianhap,
											'ssoluongtra' => $ssoluongtralai,
											'strigiatralai' => $strigiatralai,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'subparamurl' => $subparamurl,
											'fullproductcategory' => $fullproductcategory,
											'stepdate' => $stepdate,
											'songay' => $songay,
											));

			///////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'catestores.tpl');
			$myCache->save($content);
			////////////////////////////////////////////////////////////////////////
			echo $content;
			//$this->registry->smarty->display($this->registry->smartyControllerContainer.'catestores.tpl');
		}

	}//end of function

	/**
	 * [brandcateAction description]
	 * @return [type] [description]
	 */
	public function brandcateAction()
	{
		global $conf;
		set_time_limit(0);

		$startdate = isset($_GET['startdate']) ? Helper::strtotimedmy(urldecode($_GET['startdate'])) : Helper::strtotimedmy( '01/' . date('m' , time()) . '/' . date('Y' , time()) );

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy(urldecode($_GET['enddate'])):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime("+1 day" , $relenddate);
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

		$id = (int)(isset($_GET['id'])?$_GET['id']:0);//category parent
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$searchstring = (string)$_GET['a'];

		//xu ly chuoi filter cua san pham
		if(strlen($searchstring))
		{
			$fvalue = array();
			$searchstringarr = explode(',', $searchstring);
			for($i = 0 , $ilen = count($searchstringarr) ; $i < $ilen ; $i+=2)
			{
				$fvalue[$searchstringarr[$i]][] = $searchstringarr[$i+1];
				$searchdata[] = $searchstringarr[$i];
				$searchdata[] = $searchstringarr[$i+1];
			}
		}

		$chartby = (string)(!empty($_GET['chartby']) ? (string)$_GET['chartby'] : 'volume');

		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		$productcategory = new Core_Productcategory($id , true);

		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby  . (count($searchdata) > 0 ?  implode('' , $searchdata) : '') . 'brandcateAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);

		if(!isset($_GET['live']) && file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			$sdoanhthu = 0;
			$slaigop = 0;
			$smargin = 0;
			$sgiatritonkho = 0;
			$ssoluong = 0;
			$sgiatritrungbinhitem = 0;
			$breadcum = '';
			$songay = ceil(($enddate - $startdate) / 86400);

			$productallcategorylist = Core_Productcategory::getProductcategoryListFromCache();

			if($productcategory->id > 0)
			{
				$vendorlist = Core_Vendor::getVendorByProductcategoryFromCache($productcategory->id);
				$vendoritemlist = array();
				$lineChartData = array();
				$pieChartData = array();
				$refineData = array();
				$productlist = array();
				foreach ($vendorlist as $vendorid => $vendorname)
				{
					///////////////////////////////////////////////////////////////////
					//get all product of current category
					$productlistchild = array();
					if(count($fvalue) > 0)
					{
						$productlistchild = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																								'fpcid' => $productcategory->id,
																								'fvidarr' => array($vendorid),
																								'fvalue' => $fvalue,
																								) , 'id' , 'ASC');
						$productlist = $this->mergeProductList($productlist, $productlistchild);

					}
					//else
//					{
//						$productlistchild = Core_Productcategory::getProductlistFromCache($productcategory->id , array($vendorid));
//					}
				}

				if (!empty($productlist))
				{
					$productidlist = array_keys($productlist);

					$dataidlist = array('product' => $productidlist,
											'store' => $storeid,
											);
					if($storeid > 0)
					{
						$dataidlist['groupstore'] = 1;
					}
					$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop', 'tralai', 'ngaybanhang', 'trigiacuoiky', 'giavontrungbinh', 'giabantrungbinh', 'doanthutralai');//, 'tonkho'
					$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'slaigop' , 'smargin' , 'trigiacuoiky' , 'ngaybanhang', 'stralai', 'sdoanthutralai' , 'sgiabantrungbinh' , 'sgiavontrungbinh');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

					$listvendorsdata = array();
					if (!empty($data['data'][$storeid]))
					{
						foreach ($data['data'][$storeid] as $pid=>$listdatedata)
						{
							foreach ($listdatedata as $date=>$value)
							{
								$xdtdate = date('d/m' , $date);
								$cvid = $productlist[$pid]['vid'];
								foreach ($detailvalues as $valindex)
								{
									if (empty($listvendorsdata[$cvid][$valindex]))
									{
										$listvendorsdata[$cvid][$valindex] = $value[$valindex];
									}
									else $listvendorsdata[$cvid][$valindex] += $value[$valindex];
								}
								$vendorname = $vendorlist[$cvid];
								switch ($chartby)
								{
									case 'revenue':
										$refineData[$vendorname][$xdtdate] += $value['doanhthuthucte'];
										break;

									case 'volume':
										$refineData[$vendorname][$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$vendorname][$xdtdate] += $value['laigop'];
										break;
								}
							}
						}
					}
					if (!empty($listvendorsdata))
					{
						foreach ($listvendorsdata as $cvid => $listvalues)
						{
							$vendorname = $vendorlist[$cvid];
							$vendoritem = array();
							$vendoritem['ten']             = $vendorname;
							$vendoritem['id']              = $cvid;
							$vendoritem['soluong']         = $listvalues['soluongthucban'];
							$vendoritem['doanhthu']        = $listvalues['doanhthuthucte'];
							$vendoritem['laigop']          = $listvalues['laigop'];
							$vendoritem['mucdonggop']      = '';
							$vendoritem['giabantrungbinh'] = $listvalues['giabantrungbinh'];
							$vendoritem['giavontrungbinh'] = $listvalues['giavontrungbinh'];
							$vendoritem['margin']          = ($listvalues['doanhthu'] > 0 ? ($listvalues['laigop']*100/$vendoritem['doanhthu']) : 0);
							$vendoritem['giatritonkho']    = $listvalues['trigiacuoiky'];
							$vendoritem['ngaybanhang']     = ($vendoritem['doanhthu'] >0 ? round($vendoritem['giatritonkho'] * $songay / $vendoritem['doanhthu'], 2): 0);//$listvalues['ngaybanhang'];
							$vendoritem['tralai']          = $listvalues['tralai'];
							$vendoritem['doanthutralai']          = $listvalues['doanhthutralai'];


							$vendoritem['numskus'] = count($data['data'][$storeid]);

							$vendoritemlist[$vendorname]      = $vendoritem;
						}
					}
					unset($listvendorsdata);
					//summary caculate
					$sdoanhthu += $data['datamaster']['sdoanhthu'];
					$slaigop += $data['datamaster']['slaigop'];
					$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
					$ssoluong += $data['datamaster']['ssoluongthucban'];
				}
				else
				{
					foreach ($vendorlist as $vendorid => $vendorname)
					{
						$subcatidlist = array($productcategory->id);

						$itemssoluongthucban = 0;
						$itemsdoanhthu = 0;
						$itemslaigop = 0;
						$itemsgiabantrungbinh = 0;
						$itemsgiavontrungbinh = 0;
						$itemsmargin = 0;
						$itemtrigiacuoiky = 0;
						$itemstonkho = 0;
						$itemngaybanhang = 0;
						$itemstralai = 0;

						$vendoritemlist[$vendorname]      = $vendoritem;

						 foreach ($subcatidlist as $subcatid)
						 {
							 $dataidlist = array('category' => $subcatid,
												'vendor' => $vendorid,
												'store' => $storeid,
												);
							if($storeid > 0)
							{
								$dataidlist['groupstore'] = 1;
							}
							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'slaigop' , 'smargin' , 'trigiacuoiky' , 'ngaybanhang', 'stralai', 'sdoanhthutralai' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'stonkho');

							$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

							//get data of line chart
							if(count($data['data']) > 0)
							{
								foreach ($data['data'][$storeid] as $pid => $datacharts)
								{
									foreach ($datacharts as $date => $value)
									{
										$xdtdate = date('d/m' , $date);

										switch ($chartby)
										{
											case 'revenue':
												$refineData[$vendorname][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[$vendorname][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[$vendorname][$xdtdate] += $value['laigop'];
												break;
										}
									}
								}
							}

							$itemssoluongthucban += $data['datamaster']['ssoluongthucban'];
							$itemsdoanhthu += $data['datamaster']['sdoanhthu'];
							$itemslaigop += $data['datamaster']['slaigop'];
							$itemsgiabantrungbinh += $data['datamaster']['sgiabantrungbinh'];
							$itemsgiavontrungbinh += $data['datamaster']['sgiavontrungbinh'];
							$itemsmargin += $data['datamaster']['smargin'];
							$itemtrigiacuoiky += $data['datamaster']['trigiacuoiky'];
							$itemstonkho += $data['datamaster']['stonkho'];
							$itemngaybanhang += $data['datamaster']['ngaybanhang'];
							$itemstralai += $data['datamaster']['stralai'];
							$itemsdoanhthutralai += $data['datamaster']['sdoanhthutralai'];

							//summary caculate
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$slaigop += $data['datamaster']['slaigop'];
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];

						 }

						$vendoritem['ten']             = $vendorname;
						$vendoritem['id']              = $vendorid;
						$vendoritem['soluong']         = $itemssoluongthucban;
						$vendoritem['doanhthu']        = $itemsdoanhthu;
						$vendoritem['laigop']          = $itemslaigop;
						$vendoritem['mucdonggop']      = '';
						$vendoritem['giabantrungbinh'] = $itemsgiabantrungbinh;
						$vendoritem['giavontrungbinh'] = $itemsgiavontrungbinh;
						$vendoritem['margin']          = ($itemsdoanhthu > 0 ? ($itemslaigop * 100/$itemsdoanhthu) : 0);
						$vendoritem['giatritonkho']    = $itemtrigiacuoiky;
						$vendoritem['tonkho']    = $itemstonkho;
						$vendoritem['ngaybanhang']     = ($vendoritem['doanhthu'] >0 ? round($vendoritem['giatritonkho'] * $songay / $vendoritem['doanhthu'], 2): 0);//$itemngaybanhang;
						$vendoritem['tralai']          = $itemstralai;
						$vendoritem['doanhthutralai']          = $itemsdoanhthutralai;

						$vendoritem['numskus'] = 0;
						if (!empty($productallcategorylist[$subcatid]['child']))
						{
							foreach ($productallcategorylist[$subcatid]['child'] as $childskus)
							{
								$listnumofskusproducts = Core_Stat::getData(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('category' => $childskus, 'vendor' => $vendorid, 'outputstore' => $storeid), $startdate , $enddate);
								$listnumofskusproducts = str_replace('#', ',', $listnumofskusproducts);
								$listnumofproductids = array();
								if (!empty($listnumofskusproducts))
								{
									foreach ($listnumofskusproducts as $dtsku => $dtskuval)
									{
										$listnumofproductids = array_merge($listnumofproductids, json_decode($dtskuval, true));
									}
									$listnumofproductids = array_unique($listnumofproductids);
									$vendoritem['numskus'] += count($listnumofproductids);
								}
							}
						}
						else
						{
							$listnumofskusproducts = Core_Stat::getData(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('category' => $subcatid, 'vendor' => $vendorid, 'outputstore' => $storeid), $startdate , $enddate);
							$listnumofskusproducts = str_replace('#', ',', $listnumofskusproducts);
							$listnumofproductids = array();
							if (!empty($listnumofskusproducts))
							{
								foreach ($listnumofskusproducts as $dtsku => $dtskuval)
								{
									$listnumofproductids = array_merge($listnumofproductids, json_decode($dtskuval, true));
								}
								$listnumofproductids = array_unique($listnumofproductids);
								$vendoritem['numskus'] += count($listnumofproductids);
							}
						}
						$vendoritemlist[$vendorname]      = $vendoritem;
						unset($vendoritem);
					}
				}

				//summary info
				$sgiatritrungbinhitem = ($ssoluong > 0) ? round(($sdoanhthu / $ssoluong) , 2) : 0;
				$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) ,2) : 0;

				//sort data
				switch ($sortby)
				{
					case 1:
						usort($vendoritemlist , 'cmp_revenue');
						break;

					case 2:
						usort($vendoritemlist , 'cmp_volume');
						break;

					case 3:
						usort($vendoritemlist , 'cmp_profit');
						break;
				}

				//muc do dong gop cua phan khuc gia
				$listitem = $vendoritemlist;
				$vendoritemlist = array();
				foreach ($listitem as $vendorname => $item)
				{
					$lineChartData[$item['ten']] = $refineData[$item['ten']];
					$vendoritem = array();
					$vendoritem['ten'] = $item['ten'];
					$vendoritem['id'] = $item['id'];
					if($sdoanhthu > 0 && $ssoluong > 0 && $slaigop > 0)
					{
						$vendoritem['mucdonggop'] = 'V' . ceil($item['soluong'] *100 / $ssoluong) . ' , R' . ceil($item['doanhthu'] * 100 / $sdoanhthu) . ' ,P' . ceil($item['laigop'] * 100 / $slaigop);
					}
					else
					{
						$vendoritem['mucdonggop'] = 'N/A';
					}

					$vendoritem['soluong'] = $item['soluong'];
					$vendoritem['doanhthu'] = $item['doanhthu'];
					$vendoritem['giabantrungbinh'] = $item['giabantrungbinh'];
					$vendoritem['giavontrungbinh'] = $item['giavontrungbinh'];
					$vendoritem['laigop'] = $item['laigop'];
					$vendoritem['margin'] = $item['margin'];
					$vendoritem['giatritonkho'] = $item['giatritonkho'];
					$vendoritem['tonkho'] = $item['tonkho'];
					$vendoritem['ngaybanhang'] = $item['ngaybanhang'];
					$vendoritem['tralai'] = $item['tralai'];
					$vendoritem['doanhthutralai'] = $item['doanhthutralai'];
					$vendoritem['vendorpath'] = $item['vendorpath'];
					$vendoritem['numskus'] = $item['numskus'];

					$vendoritemlist[] = $vendoritem;
					unset($vendoritem);

					switch ($chartby)
					{
						case 'revenue':
							$pieChartData[$item['ten']] = ($sdoanhthu > 0) ? round(($item['doanhthu'] / $sdoanhthu * 100) , 2) : 0;
							break;

						case 'volume':
							$pieChartData[$item['ten']] = ($ssoluong) ? round(($item['soluong'] / $ssoluong * 100) , 2) : 0;
							break;

						case 'profit':
							$pieChartData[$item['ten']] = ($slaigop > 0) ? round(($item['laigop'] / $slaigop * 100) , 2) : 0;
							break;
					}
				}
				unset($listitem);
			}
			//////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);

			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);

			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////
			//////////////////////////////////////////////////////////////////
			//create paramurl
			$paramurl = '?id='.$id;
			$paramproducturl = '?id='.$id;
			$urlparam = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$paramproducturl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$urlparam .= 'startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid']))
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				$paramproducturl .= '&fsid='.urlencode($_GET['fsid']);
				if (!empty($urlparam)) $urlparam .= '&fsid='.$_GET['fsid'];
				else $urlparam = 'fsid='.$_GET['fsid'];
			}

			if(strlen($searchstring) > 0)
				$paramurl .= '&a='.$searchstring;

			//assign template
			$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$report_timeupdatereport = $cacheredis->get();
			if (!empty($report_timeupdatereport))
			{
				$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
			}

			$this->registry->smarty->assign(array(
											'report_timeupdatereport' => $report_timeupdatereport,
											'productcategoryinfo' => $productcategory,
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
											'vendoritemlist' => $vendoritemlist,
											'sdoanhthu' => $sdoanhthu,
											'ssoluong' => $ssoluong,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'sgiatritonkho' => $sgiatritonkho,
											'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
											'paramurl' => $paramurl,
											'urlparam' => $urlparam,
											'paramproducturl' => $paramproducturl,
											'fullproductcategory' => $fullproductcategory,
											'listattributefilter' => $listattributefilter,
											'breadcum' => $breadcum,
                                            'stepdate' => $stepdate,
                                            'songay' => $songay,
                                        ));
			////////////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'brandcate.tpl');
			$myCache->save($content);
			////////////////////////////////////////////
			echo $content;
			//$this->registry->smarty->display($this->registry->smartyControllerContainer . 'brandcate.tpl');
		}
	}

    public function forecastajaxAction()
    {
        set_time_limit(0);
        $html = '';

        $bsid = (string)$_POST['bsid'];
        $vid = (string)$_POST['vid'];
        $pname = (string)$_POST['pname'];
        $pbarcode = (string)$_POST['pbarcode'];
        $pcid = (int)$_POST['pcid'];
        $type = (string)$_POST['type'];
        $sid = (int)$_POST['sid'];

        $myProductcategory = new Core_Productcategory($pcid);
        if($myProductcategory->id > 0 && (strlen($bsid) > 0 || strlen($vid) > 0 || strlen($pbarcode) > 0 || strlen($pname) >0) )
        {
            ////GET FULL SUB CATEGORY
			$subcatlist = Core_Productcategory::getFullSubCategoryFromCache($myProductcategory->id);
            $subcatlist = array_keys($subcatlist);
            $subcatlist[] = $myProductcategory->id;

            $conditionsearch = array();
			$conditionsearch['fonsitestatus'] = Core_Product::OS_ERP;
			$conditionsearch['fname'] = $pname;
			$conditionsearch['fbarcode'] = $pbarcode;
			$conditionsearch['fpcidarrin'] = $subcatlist;

			if(strlen($bsid) > 0)
				$conditionsearch['fbusinessstatusarr'] = explode(',', $bsid);

			if(strlen($vid) > 0)
				$conditionsearch['fvidarr'] = explode(',', $vid);

			$productlist = Core_Product::searchproductinfo($conditionsearch , 'id' , 'ASC');

			if(count($productlist) > 0)
			{
				$productinfolist = array();
				foreach ($productlist as $product)
				{
					$productinfolist[$product['p_id']] = array('name' => $product['p_name'],
															'barcode' => $product['p_barcode'],
															'bussinessstatus' => $product['p_businessstaus'],
															'sellprice' => $product['p_sellprice'],
															'finalprice' =>$product['p_finalprice'],
															);
				}

				switch ($type)
				{
					case 'cate':
						$html = $this->forecastmaincharacterskubycategory($productinfolist , $myProductcategory);
						break;

					case 'store':
						if($sid > 0)
						{
							$html = $this->forecastmaincharacterskubystore($productinfolist , $myProductcategory , $sid);
						}
						else
						{
							$html = '-1';
						}
						break;
				}
			}

        }
        else
        {
            $html = -1;
        }

        echo $html;
    }

	private function forecastmaincharacterskubystore($productlist , $productcategory , $storeid)
	{

		set_time_limit(0);
		$begindate = Helper::strtotimedmy('01/' . date('m',time()) . '/' . date('Y' , time()) , '00:01' );//  tam thoi comment de demo data
		//$begindate = Helper::strtotimedmy('01/09/2013' , '00:01');
		$begindate = strtotime('-2 month' ,  $begindate);
		////THOI GIAN DUOC EDIT CHI TU NGAY 20 - 26 HANG THANG
		$isedit = 0;
		$starttimeline = mktime('0' , '0' , '1' , date('m',time()) , '20' , date('Y' , time()) );
		$endtimeline = mktime('23' , '59' , '59' , date('m',time()) , '30' , date('Y' , time()) );
		if($starttimeline <= time() && $endtimeline >= time())
		{
			$isedit = 1;
		}

		//$numberofmonth = 2;
		$error = array();
		///////////////////////////
		//$montharr = array($begindate , strtotime('+1 month' , $begindate) , strtotime('+2 month' , $begindate), strtotime('+3 month' , $begindate));
		$montharr = array($begindate , strtotime('+1 month' , $begindate) , strtotime('+2 month' , $begindate));

		$store = new Core_Store($storeid , true);
		if(count($productlist) > 0 && $store->id > 0)
		{
			/////LAY THONG TIN CUA USER INPUT VAO
			$uservalueBefore = array();
			$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');
			if(count($forecastUserValueList) > 0)
			{
				foreach($forecastUserValueList as $forecastUserValue)
				{
					$uservalueBefore[$forecastUserValue->identifier] = $forecastUserValue->value;
				}
			}
			///KET THUC LAY DU LIEU

			$datalist = array();

			foreach ($productlist as $productid => $datavalue)
			{
				$datainfo = array();
				$datainfo['id'] = $productid;
				$datainfo['sid'] = $storeid;
				$nameinfo = explode('|' , $datavalue['name']);
				$datainfo['name'] = $nameinfo[0];
				$datainfo['barcode'] = $datavalue['barcode'];
				$datainfo['bussinessstatus'] = Core_Product::getstaticbusinessstatusName($datavalue['bussinessstatus']);
				$datainfo['sellprice'] = (float)$datavalue['sellprice'];
				$datainfo['finalprice'] = (float)$datavalue['finalprice'];
				$myProducts = new Core_Product($productid,true);
				//////////TINH SO LIEU CUA 2 THANG TRUOC
				for($i = 0 , $ilen = count($montharr) ; $i < $ilen-1 ; $i++)
				{
					$startdateofmonth = $montharr[$i];
					$enddateofmonth = $montharr[$i+1];
					$begindateofmonth = $montharr[$i];

					$dataidlist = array('product' => $myProducts->getProductColor(),
										'store' => $store->id,
										'groupstore' => 1,
										);
					$detailvalues = array();
					$mastervalues = array('ssoluongthucban');
					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdateofmonth , $enddateofmonth , $begindateofmonth);

					$datainfo['soluongban'][date('m' , $montharr[$i])] = $data['datamaster']['ssoluongthucban'];
				}
				////////TINH SO LIEU CUA THANG HIEN TAI TINH DEN NGAY HOM NAY
				$currentstartdate = Helper::strtotimedmy('01/' . date('m' , time()) . '/' .  date('Y' , time()) , '00:01');
				$currentenddate = Helper::strtotimedmy(date('d' , time()) . '/' . date('m' , time()) . '/' . date('Y' , time()) , '00:01');
				//$currentstartdate = Helper::strtotimedmy('01/09/2013' , '00:01');
				//$currentenddate = Helper::strtotimedmy('01/10/2013' , '00:00');
				$dataidlist = array('product' => $myProducts->getProductColor(),
									'store' => $storeid,
									'groupstore' => 1,
									);
				$detailvalues = array();
				$mastervalues = array('ssoluongthucban' , 'stonkho');
				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $currentstartdate , $currentenddate , $currentstartdate);
				$datainfo['soluongbanhientai'] = $data['datamaster']['ssoluongthucban'];
				$datainfo['tonkhohientai'] = $data['datamaster']['stonkho'];

				////TOC DO BAN
				$songayban = (($currentenddate - $currentstartdate) / 86400) + 1;
				//tocdoban = soluongbanthucte / songayban
				$tocdoban = ($songayban > 0) ? $data['datamaster']['ssoluongthucban']/ $songayban : 0;
				$datainfo['tocdo'] = $tocdoban;

				$enddateofcurrentmonth = strtotime('-1 day' , strtotime('+1 month' , $currentstartdate) );

				$songayconlai = ($enddateofcurrentmonth - $currentenddate) / 86400;

				$soluongbandukien = ceil($tocdoban * $songayconlai) + $data['datamaster']['ssoluongthucban'];

				/////SO LUONG BAN DU KIEN
				$datainfo['soluongbandukien'] = $soluongbandukien;

				/////TON KHO DU KIEN
				$tonkhodukien = $data['datamaster']['stonkho'] - ($soluongbandukien - $data['datamaster']['ssoluongthucban']);
				$datainfo['tonkhodukien'] = $tonkhodukien;

				////////NGAY MIN
				$rootcategorys = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($productcategory->id); //get root of productcategory
				$rootcategorylist = array_keys($rootcategorys);
				$storetypes = Core_Backend_StoreTypeForecast::getStoreTypeForecasts(array('fsid' => $storeid , 'fpcid' => $rootcategorylist[0]) , 'id' , 'ASC');

				$storetype = $storetypes[0];
				$datainfo['storetype'] = $storetype->type;

				$uservalueBeforeStoreConfig = array();
				//$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fuid' => $this->registry->me->id, 'fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');

				$forecastUserValueListStoreConfig = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_SANPHAMCONFIG ), '', '', '');

				if(count($forecastUserValueListStoreConfig) > 0)
				{
					foreach($forecastUserValueListStoreConfig as $forecastUserValue)
					{
						$uservalueBeforeStoreConfig[$forecastUserValue->identifier] = $forecastUserValue->value;
					}
				}
				// echodebug($forecastUserValueListStoreConfig,true);
				$uservaluenameconfig = array('min', 'ngaymin' , 'ngaymax');
				$uservaluelistconfig = array();
				foreach($uservaluenameconfig as $uname)
				{
					$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $productid, 'storetype' =>$storetype->type ));
					$uservaluelistconfig[$uname] = array(
							'name' => $identifier,
							'value' => isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0,
					);
				}

				$datainfo['min'] = $uservaluelistconfig['min']['value'];
				$datainfo['ngaymin'] = $uservaluelistconfig['ngaymin']['value'];
				$datainfo['ngaymax'] = $uservaluelistconfig['ngaymax']['value'];

				///LAY GIA MUA VAO GAN NHAT
				$inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice($datavalue['barcode']);

				$inputpricevat = ($inputpriceinfo['vatpercent'] != 0) ? $inputpriceinfo['inputprice'] * (1 + $inputpriceinfo['vat'] / $inputpriceinfo['vatpercent']) : $inputpriceinfo['inputprice'];
				$inputpricereal = $inputpriceinfo['inputprice'] - $inputpriceinfo['discount'];

				$datainfo['inputdate'] = $inputpriceinfo['inputdate'];
				$datainfo['inputpricevat'] = $inputpricevat;
				$datainfo['inputpricereal'] = $inputpricereal;

				/////LAY GIA CUA USER NHAP VAO
				$identifier = Core_Backend_ForecastUservalue::getIdentifier('gianhapmua', array('product' => $productid));
				$inputpriceuser = isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0;
				$datainfo['inputpriceuser'] = $inputpriceuser;

				/////////LAY THONG TIN CUA IMPUT CUA NGUOI DUNG
				$uservaluename = array('soluongban', 'soluongnhap');
				$uservaluelist = array();

				foreach($uservaluename as $uname)
				{
					$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $productid, 'outputstore' => $storeid ));
					$uservaluelist[$uname]['name'] = $identifier;
					foreach($uservaluename as $uname)
					{
						$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $productid, 'outputstore' => $storeid ));
						$uservaluelist[$uname] = array(
								'name' => $identifier,
								'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
						);
					}
				}
				$datainfo['soluongbandk'] = $uservaluelist['soluongban'];
				$datainfo['soluongnhapdk'] = $uservaluelist['soluongnhap'];
				//////////////////////
				$datalist[] = $datainfo;
				unset($datainfo);
			}
		}
		else
		{
			$error[] = 'Vui lòng chọn siêu thị để forecast.';
		}
		//////////////////
		$last2month = array();
		$i = 0;
		foreach($montharr as $month)
		{
			if($i < count($montharr)-1)
			{
				$last2month[] = date('m' , $month);
			}
			$i++;
		}

		$nextmonth = date('m' , strtotime('+3 month' , $begindate));

		///caculate number of days of next month forecast
		$numberdayofnextmonth = ( strtotime('+4 month' , $begindate) - strtotime('+3 month' , $begindate) ) / 86400;

		$_SESSION['forecaststoreAddToken']=Helper::getSecurityToken();//Tao token moi
		$this->registry->smarty->assign(array(
											'currentmonth' => (int)date('m' , strtotime('+2 month' , $begindate)),
											'currentyear' => (int)date('Y' , strtotime('+2 month' , $begindate)),
											'datalist' => $datalist,
											'store' => $store,
											'error' => $error,
											'sheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI,
											'last2month' => $last2month,
											// 'nextmonth' => date('m' , strtotime('+1 month' , time())),
											'currentdate' => date('d/m' , time()),
											'nextmonth' => $nextmonth,
											//'currentdate' => '30/09',
											'isedit' => $isedit,
											'bussinessstatuslist' => Core_Product::getbusinessstatusList(),
											'bussinessstatusarr' => $conditionarr,
											'numberdayofnextmonth' => $numberdayofnextmonth,
											));
		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'forecastsku.tpl');

		return $content;
	}

	private function forecastmaincharacterskubycategory($productlist , $productcategory)
	{
		set_time_limit(0);
		$begindate = Helper::strtotimedmy('01/' . date('m',time()) . '/' . date('Y' , time()) , '00:01' ); // tam thoi comment de demo data
		//$begindate = Helper::strtotimedmy('01/09/2013' , '00:01');
		$begindate = strtotime('-2 month' ,  $begindate);

		////THOI GIAN DUOC EDIT CHI TU NGAY 20 - 26 HANG THANG
		$isedit = 0;
		$starttimeline = mktime('0' , '0' , '1' , date('m',time()) , '20' , date('Y' , time()) );
		$endtimeline = mktime('23' , '59' , '59' , date('m',time()) , '30' , date('Y' , time()) );
		if($starttimeline <= time() && $endtimeline >= time())
		{
			$isedit = 1;
		}
		//$numberofmonth = 2;
		$error = array();
		///////////////////////////
		$montharr = array($begindate , strtotime('+1 month' , $begindate), strtotime('+2 month' , $begindate));

		$storelist = Core_Store::getStoresFromCache();
		if(count($productlist) > 0)
		{
			///LAY DU LIEU CUA CAC KHO
			$uservalueBeforesStore = array();
			$forecastUserValueListStore = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');

			if(count($forecastUserValueListStore) > 0)
			{
				foreach($forecastUserValueListStore as $forecastUserValue)
				{
					$uservalueBeforesStore[$forecastUserValue->identifier] = $forecastUserValue->value;
				}
			}

			/////KET THUC LAY DU LIEU CUA KHO

			/////LAY DU LIEU NGUOI DUNG NHAP VAO
			$uservalueBefore = array();
			$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHTUSKUMCCATEGORY ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');
			if(count($forecastUserValueList) > 0)
			{
				foreach($forecastUserValueList as $forecastUserValue)
				{
					$uservalueBefore[$forecastUserValue->identifier] = $forecastUserValue->value;
				}
			}
			//ket thuc lay du lieu


			foreach ($productlist as $productid => $datavalue)
			{
				$datainfo = array();
				$datainfo['id'] = $productid;
				$nameinfo = explode('|' , $datavalue['name']);
				$datainfo['name'] = $nameinfo[0];
				$datainfo['barcode'] = $datavalue['barcode'];
				$datainfo['bussinessstatus'] = Core_Product::getstaticbusinessstatusName($datavalue['bussinessstatus']);
				$datainfo['sellprice'] = (float)$datavalue['sellprice'];
				$datainfo['finalprice'] = (float)$datavalue['finalprice'];
				$myProducts = new Core_Product($productid,true);

				//////////TINH SO LIEU CUA 2 THANG TRUOC
				for($i = 0 , $ilen = count($montharr) ; $i < $ilen-1 ; $i++)
				{
					$startdateofmonth = $montharr[$i];
					$enddateofmonth = $montharr[$i+1];
					$begindateofmonth = $montharr[$i];

					$dataidlist = array('product' => $myProducts->getProductColor()
										);
					$detailvalues = array();
					$mastervalues = array('ssoluongthucban');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdateofmonth , $enddateofmonth , $begindateofmonth);
					$datainfo['soluongban'][date('m' , $montharr[$i])] = $data['datamaster']['ssoluongthucban'];
				}
				unset($data);
				////////TINH SO LIEU CUA THANG HIEN TAI TINH DEN NGAY HOM NAY
				$currentstartdate = Helper::strtotimedmy('01/' . date('m' , time()) . '/' .  date('Y' , time()) , '00:01' );
				$currentenddate = Helper::strtotimedmy(date('d' , time()) . '/' . date('m' , time()) . '/' . date('Y' , time()) , '00:01');
				//$currentstartdate = Helper::strtotimedmy('01/09/2013' , '00:01');
				//$currentenddate = Helper::strtotimedmy('01/10/2013' , '00:00');
				$dataidlist = array('product' => $myProducts->getProductColor());
				$detailvalues = array();
				$mastervalues = array('ssoluongthucban' , 'stonkho');
				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $currentstartdate , $currentenddate , $currentstartdate);
				$datainfo['soluongbanhientai'] = $data['datamaster']['ssoluongthucban'];
				$datainfo['tonkhohientai'] = $data['datamaster']['stonkho'];

				////TOC DO BAN
				$songayban = (($currentenddate - $currentstartdate) / 86400) + 1;
				//tocdoban = soluongbanthucte / songayban
				$tocdoban = ($songayban > 0) ? $data['datamaster']['ssoluongthucban']/$songayban : 0;
				$datainfo['tocdo'] = $tocdoban;

				$enddateofcurrentmonth = strtotime('-1 day' , strtotime('+1 month' , $currentstartdate) );

				//$songayconlai = round(($enddateofcurrentmonth - $currentenddate) / 86400);
				$songayconlai = round(($enddateofcurrentmonth - strtotime('-1 day' , $currentenddate)) / 86400);
				$soluongbandukien = ceil($tocdoban * $songayconlai) + $data['datamaster']['ssoluongthucban'];

				///LAY GIA MUA VAO GAN NHAT
				$inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice($datavalue['barcode']);

				$inputpricevat = ($inputpriceinfo['vatpercent'] != 0) ? $inputpriceinfo['inputprice'] * (1 + $inputpriceinfo['vat'] / $inputpriceinfo['vatpercent']) : $inputpriceinfo['inputprice'];
				$inputpricereal = $inputpriceinfo['inputprice'] - $inputpriceinfo['discount'];

				$datainfo['inputdate'] = $inputpriceinfo['inputdate'];
				$datainfo['inputpricevat'] = $inputpricevat;
				$datainfo['inputpricereal'] = $inputpricereal;

				/////SO LUONG BAN DU KIEN
				$datainfo['soluongbandukien'] = $soluongbandukien;

				/////TON KHO DU KIEN
				$tonkhodukien = $data['datamaster']['stonkho'] - ($soluongbandukien - $data['datamaster']['ssoluongthucban']);
				$datainfo['tonkhodukien'] = $tonkhodukien;

				////////NGAY MIN
				$uservalueBeforeStoreConfig = array();

				$forecastUserValueListStoreConfig = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_SANPHAMCONFIG ), '', '', '');

				if(count($forecastUserValueListStoreConfig) > 0)
				{
					foreach($forecastUserValueListStoreConfig as $forecastUserValue)
					{
						$uservalueBeforeStoreConfig[$forecastUserValue->identifier] = $forecastUserValue->value;
					}
				}

				$uservaluenameconfig = array('min', 'ngaymin' , 'ngaymax');
				$uservaluelistconfig = array();
				foreach($uservaluenameconfig as $uname)
				{
					$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $productid, 'storetype' => 4 ));
					$uservaluelistconfig[$uname] = array(
							'name' => $identifier,
							'value' => isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0,
					);
				}

				$datainfo['min'] = $uservaluelistconfig['min']['value'];
				$datainfo['ngaymin'] = $uservaluelistconfig['ngaymin']['value'];
				$datainfo['ngaymax'] = $uservaluelistconfig['ngaymax']['value'];


				/////LAY GIA CUA USER NHAP VAO
				$identifier = Core_Backend_ForecastUservalue::getIdentifier('gianhapmua', array('product' => $productid));
				$inputpriceuser = isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0;
				$datainfo['inputpriceuser'] = $inputpriceuser;

				///////TINH TONG SO LUONG BAN CUA SIEU THI
				$tongsoluongbansieuthi = 0;
				foreach ($storelist as $storeid => $storename)
				{
					$identifier = Core_Backend_ForecastUservalue::getIdentifier('soluongban', array('product' => $productid, 'outputstore' => $storeid ));
					$tongsoluongbansieuthi += $uservalueBeforesStore[$identifier];
				}
				$datainfo['tongsoluongbansieuthi'] = $tongsoluongbansieuthi;

				//////////////////////////////////
				/////////LAY THONG TIN CUA IMPUT CUA NGUOI DUNG
				$uservaluename = array('soluongban', 'soluongnhap');
				$uservaluelist = array();

				foreach($uservaluename as $uname)
				{
					$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $productid, 'outputstore' => $storeid ));
					$uservaluelist[$uname]['name'] = $identifier;
					foreach($uservaluename as $uname)
					{
						$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $productid, 'outputstore' => $storeid ));
						$uservaluelist[$uname] = array(
								'name' => $identifier,
								'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
						);
					}
				}
				$datainfo['soluongbandk'] = $uservaluelist['soluongban'];
				$datainfo['soluongnhapdk'] = $uservaluelist['soluongnhap'];
				//////////////////////
				$datalist[] = $datainfo;
				unset($datainfo);
			}
		}

		//////////////////
		$last2month = array();
		$i = 0;
		foreach($montharr as $month)
		{
			if($i < count($montharr)-1)
			{
				$last2month[] = date('m' , $month);
			}
			$i++;
		}
		$nextmonth = date('m' , strtotime('+3 month' , $begindate));

		///caculate number of days of next month forecast
		$numberdayofnextmonth = ( strtotime('+4 month' , $begindate) - strtotime('+3 month' , $begindate) ) / 86400;
		$_SESSION['forecastcategoryAddToken']=Helper::getSecurityToken();//Tao token moi
		$this->registry->smarty->assign(array(
											'currentmonth' => (int)date('m' , strtotime('+2 month' , $begindate)),
											'currentyear' => (int)date('Y' , strtotime('+2 month' , $begindate)),
											'datalist' => $datalist,
											'store' => $store,
											'error' => $error,
											'sheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHTUSKUMCCATEGORY,
											'last2month' => $last2month,
											// 'nextmonth' => date('m' , strtotime('+1 month' , time())),
											'currentdate' => date('d/m' , time()),
											'nextmonth' => $nextmonth,
											//'currentdate' => '30/09',
											'isedit' => $isedit,
											'bussinessstatuslist' => Core_Product::getbusinessstatusList(),
											'bussinessstatusarr' => $conditionarr,
											'numberdayofnextmonth' => $numberdayofnextmonth,
											));
		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'forecastskucate.tpl');
		return $content;
	}//end of function

	public function updatedataforecastAction()
	{
		//submit du lieu do user nhap vao
		$formData = array();
		$formData = array_merge($formData, $_POST);
		$session = '';
		switch ($formData['datajax']) {
			case 1:
				$session = $_SESSION['forecastcategoryAddToken'];
				break;

			case 2:
				$session = $_SESSION['forecaststoreAddToken'];
				break;
		}

		///////////////////////////////////
		if($session == $formData['ftoken'])
		{
			$ok = -1;
			if($this->updatedataforecasValidation($formData))
			{
				$date = $formData['fmonth'] . $formData['fyear'];
				foreach ($formData['fdataforecast'] as $identifier => $value)
				{
					//$myForecastUservalue = Core_Backend_ForecastUservalue::getDataBySheet($identifier , $formData['fsheet'] , $this->registry->me->id, $date);
					$myForecastUservalue = Core_Backend_ForecastUservalue::getDataBySheet($identifier , $formData['fsheet'] , $date);
					if($myForecastUservalue->id > 0)
					{
						$oldvalue = $myForecastUservalue->value;
						$newvalue = $value;

						if($newvalue != $oldvalue)
						{
							$myForecastUservalue->identifier   = $identifier;
							$myForecastUservalue->sheet        = (int)$formData['fsheet'];
							$myForecastUservalue->value        = $value;
							$myForecastUservalue->date         = $date;

							if($myForecastUservalue->updateData())
							{
								$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory();

								$myForecastUservalueHistory->uid = $myForecastUservalue->uid;
								$myForecastUservalueHistory->fuid = $myForecastUservalue->id;
								$myForecastUservalueHistory->oldvalue = $oldvalue;
								$myForecastUservalueHistory->newvalue = $newvalue;
								$myForecastUservalueHistory->edituserid = $this->registry->me->id;
								$myForecastUservalueHistory->type = Core_Backend_ForecastUservalueHistory::TYPE_EDIT;
								$myForecastUservalueHistory->fromsheet = (int)$formData['fsheet'];

								if($myForecastUservalueHistory->addData() > 0)
								{
									$ok = 1;
								}
							}
						}
					}
					else
					{
						$myForecastUservalue->uid          = $this->registry->me->id;
						$myForecastUservalue->identifier   = (string)$identifier;
						$myForecastUservalue->sheet        = (int)$formData['fsheet'];
						$myForecastUservalue->value        = (int)$value;
						$myForecastUservalue->date         = (int)$date;

						if($myForecastUservalue->addData() > 0)
						{
							if((int)$value > 0)
							{
								//////UPDATE HISTORY FOR SHEET
								$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory();

								$myForecastUservalueHistory->uid = $myForecastUservalue->uid;
								$myForecastUservalueHistory->fuid = $myForecastUservalue->id;
								$myForecastUservalueHistory->oldvalue = 0;
								$myForecastUservalueHistory->newvalue = (int)$value;
								$myForecastUservalueHistory->edituserid = $this->registry->me->id;
								$myForecastUservalueHistory->type = Core_Backend_ForecastUservalueHistory::TYPE_ADD;
								$myForecastUservalueHistory->fromsheet = (int)$formData['fsheet'];

								if($myForecastUservalueHistory->addData() > 0)
								{
									$ok = 1;
								}
							}
							else
							{
								$ok = 1;
							}
						}
					}
				}
			}
			else
			{
				$ok = 0;
			}

			echo $ok;
		}

		//end of submit form
	}//end of function

	private function updatedataforecasValidation($formData)
	{
		$pass = true;

		if((int)$formData['fmonth'] == 0)
		{
			$pass = false;
		}

		if(count($formData['fdataforecast']) == 0)
		{
			$pass = false;
		}
		else
		{
			foreach ($formData['fdataforecast'] as $identifier => $value)
			{
				if(!is_numeric($value))
				{
					$pass = false;
					break;
				}
			}
		}

		return $pass;
	}//end of function

	/**
	 * [clearcachehtml description]
	 * @return [type] [description]
	 */
	public function clearcachehtmlAction()
	{
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';

		$listfilecache = scandir($cacheDir);
		if(count($listfilecache) > 0)
		{
			foreach ($listfilecache as $filename)
			{
				if($filename != '.' && $filename != '..')
				{
					$myCache = new cache();
					$myCache = new cache($filename , $cacheDir);
				}
			}
		}
	}
	///merge cai nao giong key thi override value = mang 2
	private function mergeProductList($arr1, $arr2)
	{
		$arrres = array();
		foreach ($arr1 as $key=>$val)
		{
			$arrres[$key] = $val;
		}
		foreach ($arr2 as $key=>$val)
		{
			$arrres[$key] = $val;
		}
		return $arrres;
	}

	public function testAction()
	{
		set_time_limit(0);
		$productVendorList 			= Core_ProductAttributeFilter::getProductByPriceSegmentFromCache(0,0,true);
		echodebug($productVendorList, true);
		$list = Core_Backend_Caculatereport::caculate(array('product' => $productVendorList[42]['3-4-5-trieu']), array('soluongban'), array('sngaycaodiem'), strtotime('2013-11-01'),time(), strtotime('2013-11-01'));
		echodebug($list, true);


		$arrtypes = array(
			Core_Stat::TYPE_SALE_ITEM_VOLUME,
			Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT,
			Core_Stat::TYPE_SALE_ITEM_VALUE,
			Core_Stat::TYPE_SALE_COSTPRICE,
			Core_Stat::TYPE_PROMOTION_COSTPRICE,
			Core_Stat::TYPE_STOCK_VOLUME_BEGIN,
			Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME,
			Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE,
			Core_Stat::TYPE_OUTPUT_VOLUME,
			Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME,
			Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME,
			Core_Stat::TYPE_OUTPUT_OTHER_VOLUME,
			Core_Stat::TYPE_STOCK_VALUE_BEGIN,
			Core_Stat::TYPE_OUTPUT_VALUE,
			Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE,
			Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE,
			Core_Stat::TYPE_OUTPUT_OTHER_VALUE,
			Core_Stat::TYPE_SALE_ORDER_VOLUME,
		);

		$enddate = time();
		$startdate = strtotime('2013-11-01');

		foreach ($productVendorList[284] as $slug=>$listproduct)
		{
			$getdatalistalltypes = Core_Stat::getDataList($arrtypes, array('products' => $listproduct), $startdate, $enddate );
			echodebug($getdatalistalltypes, true);
		}



		$arrparents = array();
		foreach ($productVendorList as $catid => $listvendorproduct)
		{
			$listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);
			$parentCategory = array();
			if (!empty($listcate))
			{
				foreach ($listcate as $pcatid => $pcatename)
				{
					$parentCategory[] = $pcatid;
				}
			}
			else $parentCategory[] = $catid;
			foreach ($listvendorproduct as $slug => $listproduct)
			{
				foreach ($parentCategory as $pid)
				{
					if (!empty($arrparents[$pid][$slug])) $arrparents[$pid][$slug]++;
					else $arrparents[$pid][$slug] = 1;
				}

			}
		}

		//lay bit nganh hang nao la nganh hang cha
		$productcategorylist = Core_Productcategory::getProductcategoryListFromCache();
		$listpro = $productcategorylist[462];
		foreach ($productcategorylist as $catid => $datavalue)
		{
			if(count($datavalue['child']) > 0 && count($datavalue['parent']) > 0)
			{
				echo '<p>BEN TRONG: '.$catid.'</p>';
			}
		}
		foreach ($productcategorylist as $catid => $datavalue)
		{
			if(count($datavalue['child']) > 0 && count($datavalue['parent']) == 0)
			{
				echo '<p>BEN NGOAI: '.$catid.'</p>';
			}
		}
	}
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
