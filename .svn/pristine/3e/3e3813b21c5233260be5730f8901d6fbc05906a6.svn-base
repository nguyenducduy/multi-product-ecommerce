<?php
Class Controller_Stat_Report_Productcategory Extends Controller_Stat_Report
{
	/**
	 * View CatView - top item sheet
	 * @return [type] [description]
	 */
	public function indexAction()
	{
		set_time_limit(0);
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		$startdate = (isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));		

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			$enddate = strtotime('+1 day', $relenddate);
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
		$productcategory = new Core_Productcategory($id, true);

		//////////////////CHECK FILE CACHE IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $relenddate) . $sortby . 'indexAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);	
		if(file_exists($cacheDir . '/' .$filename))
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
				$sgiatritrungbinhitem = 0;			

				$producttoplist = array();
				$productitemlist = array();
				$refineData = array();
				$lineChartData = array();		
				$pieChartData = array();

				$productlist = Core_Productcategory::getProductlistFromCache($productcategory->id);                
				if(count($productlist) > 0)
				{
					foreach ($productlist as $productid => $dataarr) 
					{
						$productitem = array();	
						$dataidlist = array('product' => array($productid),
											'store' => array($storeid),
											);

						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'stonkho' ,'ngaybanhang', 'stralai' , 'trigiacuoiky');

						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);							

						$datalist = $data['data'][$storeid][$productid];

						//get data of line chart
						if(count($datalist) > 0)
						{
							foreach ($datalist as $date => $value) 
							{
								$xdtdate = date('d/m' , $date);	

								switch ($chartby)
								{
									case 'revenue':
										$refineData[$catid][$xdtdate] += $value['doanhthuthucte'];
										break;

									case 'volume':
										$refineData[$catid][$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$catid][$xdtdate] += $value['laigop'];
										break;
								}
							}
						}

						$productitem['productid']       = $productid;
						$productitem['ten']             = $dataarr['name'];				
						$productitem['sku']             = $dataarr['barcode'];
						$productitem['vaitro']          = 'N/A';
						$productitem['soluong']         = $data['datamaster']['ssoluongthucban'];
						$productitem['doanhthu']        = $data['datamaster']['sdoanhthu'];
						$productitem['giabantrungbinh'] = $data['datamaster']['sgiabantrungbinh'];
						$productitem['giavontrungbinh'] = $data['datamaster']['sgiavontrungbinh'];
						$productitem['laigop']          = $data['datamaster']['slaigop'];
						$productitem['margin']          = $data['datamaster']['smargin'];
						$productitem['tonkho']          = $data['datamaster']['stonkho'];
						$productitem['ngaybanhang']     = $data['datamaster']['ngaybanhang'];
						$productitem['tralai']          = $data['datamaster']['stralai'];

						//summary caculate
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$slaigop += $data['datamaster']['slaigop'];
						$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
						$ssoluong += $data['datamaster']['ssoluongthucban']; 
						/////////////////////////////////////
						
						$productitemlist[] = $productitem;
						unset($productitem);
					}
				}

				//chartdata
				$lineChartData[$catdata['name']] = $refineData[$catid];

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
				switch ($sortby)
				{					
					case 1:
						usort($productitemlist , 'cmp_revenue');				
						break;

					case 2:
						usort($productitemlist , 'cmp_volume');
						break;

					case 3:
						usort($productitemlist , 'cmp_profit');				
						break;
				}
				
				$counter = 0;
				$producttoplist = array();          
				
				foreach($productitemlist as $product)
				{
					$producttoplist[] = $product;
					$counter++;
					if($counter > 9) break;			
				}			
			}
			//create paramurl
			$paramurl = '';
			$paramurl = '?id='.$id;
			$productparamurl = '';
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				$productparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid'])) 
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);		
				$productparamurl .= '&fsid='.urlencode($_GET['fsid']);
			}

			///////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);		
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);
			
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////////////////////////////////////////////
			//assign template
			$this->registry->smarty->assign(array(
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
											'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
											'producttoplist' => $producttoplist,
											'paramurl' => $paramurl,
											'productparamurl' => $productparamurl,
											'fullproductcategory' =>$fullproductcategory,
											'stepdate' => $stepdate,
											));
			////////////////////////CREATE CAHE HTML			
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
			$myCache->save($content);
			//////////////////////////////////////////////////
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'index.tpl');
		}
		
	}//end of function

	/**
	 * view sheet cate MC-SKU subcate
	 * @return [type] [description]
	 */
	public function listsubcateAction()
	{
		
		set_time_limit(0);
		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));		
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{			
			$enddate = strtotime('+1 day', $relenddate);
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
		if($productcategory->id > 0)
		{
			$productcategorylist = Core_Productcategory::getFullSubCategoryFromCache($productcategory->id);			
			if(empty($productcategorylist))
			{
				header('Location: '.$this->registry->conf['rooturl'].'stat/report/productcategory/subcate/?id='.$id);
				exit();
			}
			
			//////////////////CHECK FILE CACHE IS EXIST 
			$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . 'listsubcateAction.html';
			$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
			$myCache = new cache($filename , $cacheDir);
			if(file_exists($cacheDir . '/' . $filename))
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
				
				$refineData = array();
				$lineChartData = array();		
				$pieChartData = array();
				

				$spdoanhthu = array();
				$spsoluong = array();
				$splaigop = array();

				$categorylist = array();

				foreach ($productcategorylist as $catid => $datavalue) 
				{
					$categoryitem = array();
					$productlist = Core_Productcategory::getProductlistFromCache($catid);
					
					$productidlist = array_keys($productlist);
					$dataidlist = array('product' => $productidlist,
												'store' => array($storeid),
												);

					$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
					$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'trigiacuoiky');

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
										$refineData[$category->id][$xdtdate] += $value['doanhthuthucte'];
										break;

									case 'volume':
										$refineData[$category->id][$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$category->id][$xdtdate] += $value['laigop'];
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
					$categoryitem['ngaybanhang']     = $data['datamaster']['ngaybanhang'];
					$categoryitem['tralai']          = $data['datamaster']['stralai'];			

					$categorylist[$catid] = $categoryitem;

					//summary info
					$sdoanhthu += $data['datamaster']['sdoanhthu'];
					$ssoluong += $data['datamaster']['ssoluongthucban'];
					$slaigop += $data['datamaster']['slaigop'];
					$sgiatritonkho += $data['datamaster']['trigiacuoiky'];

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
					$lineChartData[$category->name] = $refineData[$category->id];				

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
					$categoryitem['categorypath']    = $category->getProductcateoryPath();

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
				$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
				$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);
				
				$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
				if($stepdate > 7)
					$stepdate = ceil($stepdate / 7) - 1;
				//////////////////////////////////////////////////////////////
				//create paramurl
				$paramurl = '';
				$productcategoryparamurl = '';
				$paramurl = '?id='.$id;
				if(isset($_GET['startdate']))
				{
					$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
					$productcategoryparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
				}
				if(isset($_GET['fsid'])) 
				{
					$paramurl .= '&fsid='.urlencode($_GET['fsid']);
					$productcategoryparamurl .= '&fsid='.urlencode($_GET['fsid']);
				}
					
				$this->registry->smarty->assign(array(
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
												'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
												'categorylist' => $categorylist,
												'paramurl' => $paramurl,
												'productcategoryparamurl' => $productcategoryparamurl,
												'fullproductcategory' => $fullproductcategory,
												'checkpricesegement' => $checkpricesegement,
												'stepdate' => $stepdate,
												));
				//////////////////////CREATE CACHE HTML
				$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'listsubcate.tpl');
				$myCache->save($content);
				////////////////////////////////////////////////
				$this->registry->smarty->display($this->registry->smartyControllerContainer.'listsubcate.tpl');
			}
		}		
		
	}//end of function


	/**
	 * View Cate view MC-SKU SKUs
	 * @return [type] [description]
	 */
	public function subcateAction()
	{		
		set_time_limit(0);		

		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));		

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{			
			$enddate = strtotime('+1 day', $relenddate);
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
				
		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		
		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		$tab =  (isset($_GET['tab'])) ? (int)$_GET['tab'] : 1;

		$searchstring = (string)$_GET['a'];

		//xu ly chuoi filter cua san pham
		if(strlen($searchstring))
		{
			$fvalue = array();
			$searchstringarr = explode(',', $searchstring);
			$searchdata = array();
			for($i = 0 , $ilen = count($searchstringarr) ; $i < $ilen ; $i+=2)
			{
				$fvalue[$searchstringarr[$i]][] = $searchstringarr[$i+1];
				$searchdata[] = $searchstringarr[$i];
				$searchdata[] = $searchstringarr[$i+1];
			}			
		}
		

		$strvid = (string)$_GET['vid'];

		$vidarr = array();
		if(strlen($strvid) > 0)
		{
			$vidarr = explode(',', $strvid);
		}		
		
		$productcategory = new Core_Productcategory($id , true);
		
		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . $tab . (count($vidarr) > 0 ? implode('' , $vidarr) : '') . (count($searchdata) > 0 ?  implode('' , $searchdata) : '') . 'subcateAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			if($productcategory->id > 0)
			{
				$ssoluong = 0;
				$sdoanhthu = 0;
				$slaigop = 0;
				$smargin = 0;
				$ssoluongton = 0;
				$strigiatonkho = 0;


				$refineData = array();
				
				///////////////////////////////////////////////////////////////////
				//get all product of current category
				if(count($fvalue) > 0)
				{				
					$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																							'fpcid' => $productcategory->id,
																							'fvidarr' => $vidarr,
																							'fvalue' => $fvalue,
																							) , 'id' , 'ASC');
					
				}
				else
				{
					$productlist = Core_Productcategory::getProductlistFromCache($productcategory->id , $vidarr);			
				}
						
				/////////PRODUCT
				if(count($productlist) > 0)
				{
					$newlistproducts = array();

					foreach ($productlist as $productid => $datavalue) 
					{					
						$productitem = array();	

						$productitem['productid'] = $productid;
						$productitem['productname'] = $datavalue['name'];
						$productitem['sku'] = $datavalue['barcode'];
						$productitem['roles'] = 'Chủ lực';
						$productitem['sellprice'] = Helper::formatPrice($datavalue['sellprice']);												

						$myVendor = new Core_Vendor($datavalue['vid'], true);
						$productitem['brand'] = $myVendor->name;
						$productitem['segmentprice'] = $datavalue['attr']['gia']['value'];
						$productitem['kenhban'] = 'N/A';

						foreach ($datavalue['attr'] as $infodata) 
						{
							if(isset($infodata['slug']))
							{
								$productitem['mc'][$infodata['slug']] = $infodata['value'];
							}
						}


						$dataidlist = array('product' => array($product['p_id']),
												'store' => array($storeid),
												);
						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sthanhtoan' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'ngaybanhang', 'stralai' , 'stonkho' , 'trigiacuoiky');

						$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

						$datalist = $data['data'][$storeid][$product['p_id']];
						
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

									case 'volume':
										$refineData[$xdtdate] += $value['soluongthucban'];
										break;

									case 'profit':
										$refineData[$xdtdate] += $value['laigop'];
										break;
								}
							}
						}
						
						$productitem['soluong']         = $data['datamaster']['ssoluongthucban'];
						$productitem['doanhthu']        = $data['datamaster']['sdoanhthu'];
						$productitem['thanhtoan']       = $data['datamaster']['sthanhtoan'];
						$productitem['giabantrungbinh'] = $data['datamaster']['sgiabantrungbinh'];
						$productitem['giavontrungbinh'] = $data['datamaster']['sgiavontrungbinh'];
						$productitem['laigop']          = $data['datamaster']['slaigop'];
						$productitem['margin']          = $data['datamaster']['smargin'];					
						$productitem['tonkho']          = $data['datamaster']['stonkho'];	
						$productitem['ngaybanhang']     = $data['datamaster']['ngaybanhang'];
						$productitem['tralai']          = $data['datamaster']['stralai'];

						//summary info
						$ssoluong += $data['datamaster']['ssoluongthucban'];
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$slaigop += $data['datamaster']['slaigop'];				
						$ssoluongton += $data['datamaster']['stonkho'];
						$strigiatonkho += $data['datamaster']['trigiacuoiky'];

						$newlistproducts[] = $productitem;
						
						unset($productitem);
					}				
				}	


				//summary info
				$smargin = ($sdoanhthu > 0) ? round(($slaigop * 100 / $sdoanhthu) ,2) : 0;
				
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
			switch ($tab) 
			{
				case 2:
					$content = $this->subcateinstockvolume($startdate , $enddate , $begindate , $productlist);
					break;	

				case 3:
					$content = $this->subcateinstockvalue($startdate, $enddate , $begindate , $productlist);			
					break;

				case 11:	
					$content = $this->forecastmaincharacterskubystore($begindate , $productlist , $productcategory, $storeid);
					break;

				case 12:	
					$content = $this->forecastmaincharacterskubycategory($begindate , $productlist , $productcategory);
					break;
			}
			///////////////////////////////////////////////////////////////////
			//$fullproductcategory = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);		
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);
			
			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);
			
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////
			//////////////////////
			$paramurl = '?id='.$id;	
			$productparamurl = '?id='.$id;		
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$productparamurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);			
			}
			if(isset($_GET['fsid'])) 
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				$productparamurl .= '&fsid='.urlencode($_GET['fsid']);			
			}			

			if(strlen($strvid) > 0)
			{
				$paramurl .= '&vid=' . $strvid;			
			}
				
			if(strlen($searchstring) > 0)
				$paramurl .= '&a=' . $searchstring;

			$paramurl .= '&tab='.$tab;		
			//assign template
			$this->registry->smarty->assign(array(
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
											'chartType' => $chartType,
											'listsubcategories'	=> $newlistproducts,
											'tab' => $tab,									
											'chartTitle' => $chartTitle,
											'ssoluong' => $ssoluong,									
											'sdoanhthu' => $sdoanhthu,
											'slaigop' => $slaigop,
											'smargin' => $smargin,
											'ssoluongton' => $ssoluongton,
											'strigiatonkho' => $strigiatonkho,
											'paramurl' => $paramurl,
											'productparamurl' => $productparamurl,
											'content' => $content,										
											'fullproductcategory' => $fullproductcategory,																		
											'listattributefilter' => $listattributefilter,
											'stepdate' => $stepdate,
											'searchstring' => $searchstring,
											'vid' => $strvid,
											'stepdate' => $stepdate,
											));
											
			////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcate.tpl');
			$myCache->save($content);
			/////////////////////////////////////////////////
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'subcate.tpl');
		}		
	}//end of function

	/**
	 * [subcateinstockvolume description]
	 * @param  [type] $startdate [description]
	 * @param  [type] $enddate   [description]
	 * @return [type]            [description]
	 */
	private function subcateinstockvolume($startdate , $enddate , $begindate , $productlist)
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
			foreach ($productlist as $productid => $datavalue) 
			{
				foreach ($storeList as $storeid => $storename) 
				{
					$dataidlist = array('product' => array($product['p_id']),
											'store' => array($storeid),
											);
					$detailvalues = array();
					$mastervalues = array('soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'sucban' , 'stonkho');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
					
					$productitem[$storeid]['id'] = $productid;
					$productitem[$storeid]['ten'] = $datavalue['name'];
					$productitem[$storeid]['sieuthi'] = $storename;
					$productitem[$storeid]['dauky'] = $data['datamaster']['soluongdauky'];
					$productitem[$storeid]['nhapmua'] = $data['datamaster']['nhapmua'];
					$productitem[$storeid]['nhapnoibo'] = $data['datamaster']['nhapnoibo'];
					$productitem[$storeid]['nhaptralai'] = $data['datamaster']['nhaptralai'];
					$productitem[$storeid]['nhapkhac'] = $data['datamaster']['nhapkhac'];
					$productitem[$storeid]['xuatban'] = $data['datamaster']['xuatban'];
					$productitem[$storeid]['xuatnoibo'] = $data['datamaster']['xuatnoibo'];
					$productitem[$storeid]['xuattramuahang'] = $data['datamaster']['xuattramuahang'];
					$productitem[$storeid]['xuatkhac'] = $data['datamaster']['xuatkhac'];
					$productitem[$storeid]['cuoiky'] = $data['datamaster']['stonkho'];
					$productitem[$storeid]['sucban'] = $data['datamaster']['sucban'];
					$productitem[$storeid]['tocdoban'] = '';
					$productitem[$storeid]['vaitro'] = '';
					$productitem[$storeid]['phanloai'] = '';
					$productitem[$storeid]['nhapkhau'] = 0;
					$productitem[$storeid]['GFK'] = '';
					$productitem[$storeid]['tonbanhang'] = 0;
					$productitem[$storeid]['tonthucte'] = 0;					
				}
				$listsubcategories[$productid] = $productitem;
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
	private function subcateinstockvalue($startdate , $enddate , $begindate, $productlist)
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
			foreach ($productlist as $productid => $datavalue) 
			{	
				$productitem = array();							
				foreach ($storeList as $storeid => $storename) 
				{
					$dataidlist = array('product' => array($productid),
											'store' => array($storeid),
											);
					$detailvalues = array();
					$mastervalues = array('soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'trigiadauky' , 'trigianhapmua' , 'trigianhapnoibo' , 'trigianhaptra' , 'trigianhapkhac' , 'trigiaxuatban' , 'trigiaxuatnoibo' , 'trigiaxuattra' , 'trigiaxuatkhac' ,  'stonkho' , 'trigiacuoiky' , 'giavoncuoiky' , 'giavondauky' , 'sucban');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);
					
					
					$productitem[$storeid]['id'] = $productid;
					$productitem[$storeid]['ten']             = $datavalue['name'];
					$productitem[$storeid]['sieuthi']         = $storename;
					$productitem[$storeid]['dauky']           = $data['datamaster']['soluongdauky'];
					$productitem[$storeid]['trigiadauky']     = $data['datamaster']['trigiadauky'];
					$productitem[$storeid]['giavondauky']     = $data['datamaster']['giavondauky'];
					$productitem[$storeid]['nhapmua']         = $data['datamaster']['nhapmua'];
					$productitem[$storeid]['trigianhapmua']   = $data['datamaster']['trigianhapmua'];
					$productitem[$storeid]['nhapnoibo']       = $data['datamaster']['nhapnoibo'];
					$productitem[$storeid]['trigianhapnoibo'] = $data['datamaster']['trigianhapnoibo'];
					$productitem[$storeid]['nhaptralai']      = $data['datamaster']['nhaptralai'];
					$productitem[$storeid]['trigianhaptra']   = $data['datamaster']['trigianhaptra'];
					$productitem[$storeid]['nhapkhac']        = $data['datamaster']['nhapkhac'];
					$productitem[$storeid]['trigianhapkhac']  = $data['datamaster']['trigianhapkhac'];
					$productitem[$storeid]['xuatban']         = $data['datamaster']['xuatban'];
					$productitem[$storeid]['trigiaxuatban']   = $data['datamaster']['trigiaxuatban'];
					$productitem[$storeid]['xuatnoibo']       = $data['datamaster']['xuatnoibo'];
					$productitem[$storeid]['trigiaxuatnoibo'] = $data['datamaster']['trigiaxuatnoibo'];
					$productitem[$storeid]['xuattramuahang']  = $data['datamaster']['xuattramuahang'];
					$productitem[$storeid]['trigiaxuattra']   = $data['datamaster']['trigiaxuattra'];
					$productitem[$storeid]['xuatkhac']        = $data['datamaster']['xuatkhac'];
					$productitem[$storeid]['trigiaxuatkhac']  = $data['datamaster']['trigiaxuatkhac'];
					$productitem[$storeid]['cuoiky']          = $data['datamaster']['stonkho'];
					$productitem[$storeid]['trigiacuoiky']    = $data['datamaster']['trigiacuoiky'];
					$productitem[$storeid]['giavoncuoiky']    = $data['datamaster']['giavoncuoiky'];
					$productitem[$storeid]['sucban']          = $data['datamaster']['sucban'];
					$productitem[$storeid]['tocdoban']        = 'N/A';
					$productitem[$storeid]['vaitro']          = 'N/A';
					$productitem[$storeid]['phanloai']        = 'N/A';										
				}
				$listsubcategories[$productid] = $productitem;
				$assignparam['tab'] = 3;		
			}
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
		set_time_limit(0);		

		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));		

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			$enddatepath = explode('/', $_GET['enddate']);
			$enddatestring = ($enddatepath[0] +1) . '/' . $enddatepath[1] . '/' . $enddatepath[2];			
			$enddate = Helper::strtotimedmy($enddatestring);
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
				
		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		
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
		if(file_exists($cacheDir . '/' . $filename))
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
					header('Location: '.$this->registry->conf['rooturl'].'stat/report/productcategory/?id='.$productcategory->id);
					exit();
				}

				if(count($listpricesegment) > 0)
				{				
					foreach ($listpricesegment as $segdata) 
					{
						foreach ($segdata as $segname => $segslug) 
						{
							$fvalue['gia'] = array($segslug);						
							$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																							'fpcid' => $productcategory->id,
																							'fvidarr' => $vidarr,
																							'fvalue' => $fvalue,
																							) , 'id' , 'ASC');		

							$productidlist = array_keys($productlist);
							$dataidlist = array('product' => $productidlist,
												'store' => array($storeid),
												);
							$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
							$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai');

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
												$refineData[Helper::codau2khongdau($segname,true,true)][$xdtdate] += $value['doanhthuthucte'];
												break;

											case 'volume':
												$refineData[Helper::codau2khongdau($segname,true,true)][$xdtdate] += $value['soluongthucban'];
												break;

											case 'profit':
												$refineData[Helper::codau2khongdau($segname,true,true)][$xdtdate] += $value['laigop'];
												break;
										}
									}
								}
							}
							$segitem['tenphankhuc']     = $segname;
							$segitem['nameseo']         = Helper::codau2khongdau($segname , true,true);
							$segitem['mucdonggop']      = '';
							$segitem['soluong']         = $data['datamaster']['ssoluongthucban'];
							$segitem['doanhthu']        = $data['datamaster']['sdoanhthu'];
							$segitem['giabancovat']     = $data['datamaster']['sgiabantrungbinhcovat'];					
							$segitem['giabanchuavat']   = $data['datamaster']['sgiabantrungbinh'];							
							$segitem['giavontrungbinh'] = $data['datamaster']['sgiavontrungbinh'];						
							$segitem['laigop']          = $data['datamaster']['slaigop'];
							$segitem['margin']          = $data['datamaster']['smargin'];
							$segitem['giatriton']       = $data['datamaster']['trigiacuoiky'];
							$segitem['ngaybanhang']     = $data['datamaster']['ngaybanhang'];
							$segitem['tralai']          = $data['datamaster']['stralai'];

							//summary info
							$sdoanhthu += $data['datamaster']['sdoanhthu'];
							$slaigop += $data['datamaster']['slaigop'];						
							$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
							$ssoluong += $data['datamaster']['ssoluongthucban'];

							$listsegdata[] = $segitem;						
							unset($segitem);
						}
					}


					//muc do dong gop cua phan khuc gia
					$listdata = $listsegdata;
					$listsegdata = array();
					foreach ($listdata as $segitem) 
					{			
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

						if($sdoanhthu != 0 && $ssoluong != 0 && $slaigop != 0)
						{
							$item['mucdonggop'] = 'V' . abs(ceil($segitem['soluong'] / $ssoluong *100)) . ' , R' . abs(ceil($segitem['doanhthu'] / $sdoanhthu * 100)) . ' ,P' . abs(ceil($segitem['laigop'] / $slaigop * 100));
						}
						else
						{
							$item['mucdonggop'] = 'N/A';
						}

						$listsegdata[$item['tenphankhuc']] = $item;

						$lineChartData[$segname] = $refineData[Helper::codau2khongdau($segname,true,true)];
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
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);
			
			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);
			
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////
			
			$paramurl = '?id='.$id;
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid'])) 
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);

			if(strlen($strvid))
				$paramurl .= '&vid=' . $strvid;

			$this->registry->smarty->assign(array(
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
											'strigiatonkho' => $strigiacuoiky,
											'strigiatrungbinhitem' => $strigiatrungbinhitem,
											'paramurl' => $paramurl,	
											'fullproductcategory' => $fullproductcategory,
											'listattributefilter' => $listattributefilter,
											'stepdate' => $stepdate,
											));

			/////////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcatesegment.tpl');
			$myCache->save($content);
			///////////////////////////////////////////////
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'subcatesegment.tpl');
		}		

	}//end of function

	/**
	 * [maincharacterAction description]
	 * @return [type] [description]
	 */
	public function maincharacterAction()
	{		
		set_time_limit(0);		

		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));		

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			$enddatepath = explode('/', $_GET['enddate']);
			$enddatestring = ($enddatepath[0] +1) . '/' . $enddatepath[1] . '/' . $enddatepath[2];			
			$enddate = Helper::strtotimedmy($enddatestring);
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
				
		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		
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
		if(file_exists($cacheDir . '/' . $filename))
		{
			$content= $myCache->get();
			echo $content;
		}
		else
		{
			if($productcategory->id > 0 && strlen($panamefilter) > 0)
			{
				

				//caculate data
				$lineChartData = array();
				$pieChartData = array();
				$listattrdata = array();
				$refineData = array();

				//lay phan khuc gia
				$filterlist = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id);			
				$attriburefilterlist = $filterlist[$panamefilter]['values'];

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
						$dataidlist = array('product' => $productidlist,
												'store' => array($storeid),
												);
						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'sgiabantrungbinh', 'sgiabantrungbinhcovat' , 'sgiavontrungbinh' , 'slaigop' , 'smargin' , 'trigiacuoiky', 'ngaybanhang' , 'stralai');

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

						$attritem['tengiatrithuoctinh'] = $datavalue['name'];
						$attritem['nameseo']            = $datavalue['value'];
						$attritem['filterseo']          = $attrname;
						$attritem['mucdonggop']         = '';
						$attritem['soluong']            = $data['datamaster']['ssoluongthucban'];
						$attritem['doanhthu']           = $data['datamaster']['sdoanhthu'];
						$attritem['giabancovat']        = $data['datamaster']['sgiabantrungbinhcovat'];					
						$attritem['giabanchuavat']      = $data['datamaster']['sgiabantrungbinh'];					
						$attritem['giavontrungbinh']    = $data['datamaster']['sgiavontrungbinh'];					
						$attritem['laigop']             = $data['datamaster']['slaigop'];	
						$attritem['margin']             = $data['datamaster']['smargin'];	
						$attritem['giatriton']          = $data['datamaster']['trigiacuoiky'];	
						$attritem['ngaybanhang']        = $data['datamaster']['ngaybanhang'];
						$attritem['tralai']             = $data['datamaster']['stralai'];

						//summary info
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$ssoluong += $data['datamaster']['ssoluongthucban'];
						$slaigop += $data['datamaster']['slaigop'];

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
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
			$fullproductcategory[$productcategory->id] = array('name' => $productcategory->name);
			
			//lay tat ca filter duoc dua vao report
			$listattributefilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($productcategory->id , true);
			
			$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
			if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;
			//////////////////////
			//////////////////////////////////////////////////////////////////

			$paramurl = '?id='.$id;
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid'])) 
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);

			if(strlen($strvid))
				$paramurl .= '&vid=' . $strvid;



			$this->registry->smarty->assign(array(
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
											'fullproductcategory' => $fullproductcategory,
											'listattributefilter' => $listattributefilter,
											'stepdate' => $stepdate,
											'panamefilter' => $panamefilter,
											));

			/////////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'subcateattribute.tpl');
			$myCache->save($content);
			///////////////////////////////////////////////
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'subcateattribute.tpl');
		}
		
	}//end of function

	/**
	 * [catestoreAction description]
	 * @return [type] [description]
	 */
	public function catestoreAction()
	{		
		set_time_limit(0);
		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));				
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);		
		
		$storelist = Core_Store::getStoresFromCache();

		$sid = (int)$_GET['fsid'];

		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			$enddatepath = explode('/', $_GET['enddate']);
			$enddatestring = ($enddatepath[0] +1) . '/' . $enddatepath[1] . '/' . $enddatepath[2];			
			$enddate = Helper::strtotimedmy($enddatestring);
		}
		else
		{
			$enddate += strtotime("+1 day");
		}		

		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );

		$searchstring = (string)$_GET['a'];

		//xu ly chuoi filter cua san pham
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

		$strvid = (string)$_GET['vid'];

		$vidarr = array();
		if(strlen($strvid) > 0)
		{
			$vidarr = explode(',', $strvid);
		}

		///////////////////////////////////////////		
		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit		
		$productcategory = new Core_Productcategory($id, true);

		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby . (count($vidarr) > 0 ? implode('' , $vidarr) : '') . (count($searchdata) > 0 ?  implode('' , $searchdata) : '') . 'catestoreAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);
		if(file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			if($productcategory->id > 0)
			{			
				$listcatestores = array();
				//summary info
				$sdoanhthu = 0;
				$ssoluong = 0;
				$slaigop = 0;
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
				if(count($fvalue) > 0)
				{				
					$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																							'fpcid' => $productcategory->id,
																							'fvidarr' => $vidarr,
																							'fvalue' => $fvalue,
																							) , 'id' , 'ASC');
					
				}
				else
				{
					$productlist = Core_Productcategory::getProductlistFromCache($productcategory->id , $vidarr);			
				}

				//get data			
				if(count($productlist) > 0)
				{
					$productidlist = array_keys($productlist);
					foreach ($storelist as $storeid => $storename)
					{
						$storeitem = array();					
						
						$dataidlist = array('product' => $productidlist,
												'store' => array($storeid),
												);
						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'slaigop' , 'smargin' , 'giatritrungbinhitem' , 'laiitem' , 'trigiacuoiky' , 'ngaybanhang', 'stralai' , 'sgiatrihangtralai' , 'snhaptrongky' , 'strigianhap');

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
						$storeitem['ngaybanhang']         = $data['datamaster']['ngaybanhang'];
						$storeitem['tralai']              = $data['datamaster']['stralai'];
						$storeitem['giatrihangtralai']    = $data['datamaster']['sgiatrihangtralai'];

						//summary info
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$ssoluong += $data['datamaster']['ssoluongthucban'];
						$slaigop += $data['datamaster']['slaigop'];										
						$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
						$ssoluongnhap += $data['datamaster']['snhaptrongky'];
						$strigianhap += $data['datamaster']['strigianhap'];
						$ssoluongtralai += $data['datamaster']['stralai'];
						$strigiatralai += $data['datamaster']['sgiatrihangtralai'];

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
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
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
			$paramurl = '?id='.$id;
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='. urlencode($_GET['enddate']);
			}
			if(isset($_GET['fsid'])) 
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);

			if(strlen($searchstring) > 0)
				$paramurl .= '&a='.$searchstring;

			if(strlen($strvid))
				$paramurl .= '&vid=' . $strvid;

			//assgin template
			$this->registry->smarty->assign(array(
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
											'sgiatritrungbinhitem' => $sgiatritrungbinhitem,
											'sgiatritonkho' => $sgiatritonkho,
											'ssoluongnhap' => $ssoluongnhap,
											'strigianhap' => $strigianhap,
											'ssoluongtra' => $ssoluongtralai,
											'strigiatralai' => $strigiatralai,		
											'paramurl' => $paramurl,
											'fullproductcategory' => $fullproductcategory,
											'stepdate' => $stepdate,										
											));		

			///////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'catestores.tpl');
			$myCache->save($content);
			////////////////////////////////////////////////////////////////////////
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'catestores.tpl');
		}		

	}//end of function

	/**
	 * [brandcateAction description]
	 * @return [type] [description]
	 */
	public function brandcateAction()
	{		
		set_time_limit(0);		

		$startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));		

		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			$enddatepath = explode('/', $_GET['enddate']);
			$enddatestring = ($enddatepath[0] +1) . '/' . $enddatepath[1] . '/' . $enddatepath[2];			
			$enddate = Helper::strtotimedmy($enddatestring);
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
				
		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
		
		$sortby = (int)(isset($_GET['sort'])?$_GET['sort']:1); //1=money, 2=volumn, 3=profit

		$productcategory = new Core_Productcategory($id , true);

		/////////////////////////CHECK CACHE HTML IS EXIST
		$filename = $productcategory->id . $storeid . $chartby . date('Ymd' , $startdate) . date('Ymd' , $enddate) . $sortby  . (count($searchdata) > 0 ?  implode('' , $searchdata) : '') . 'brandcateAction.html';
		$cacheDir = SITE_PATH . 'uploads/cache/productcategory';
		$myCache = new cache($filename , $cacheDir);

		if(file_exists($cacheDir . '/' . $filename))
		{
			$content = $myCache->get();
			echo $content;
		}
		else
		{
			if($productcategory->id > 0)
			{
				$sdoanhthu = 0;
				$slaigop = 0;
				$smargin = 0;
				$sgiatritonkho = 0;
				$ssoluong = 0;
				$sgiatritrungbinhitem = 0;

				$vendorlist = Core_Vendor::getVendorByProductcategoryFromCache($productcategory->id);								
				$vendoritemlist = array();			
				$lineChartData = array();
				$pieChartData = array();
				$refineData = array();			
				foreach ($vendorlist as $vendorid => $vendorname) 
				{
					$vendoritem = array();
					///////////////////////////////////////////////////////////////////
					//get all product of current category
					if(count($fvalue) > 0)
					{				
						$productlist = Core_RelProductAttribute::getProductIdByFilterFromCache(array(
																								'fpcid' => $productcategory->id,
																								'fvidarr' => array($vendorid),
																								'fvalue' => $fvalue,
																								) , 'id' , 'ASC');
						
					}
					else
					{
						$productlist = Core_Productcategory::getProductlistFromCache($productcategory->id , array($vendorid));			
					}
					
					if(count($productlist) > 0)
					{
						$productidlist = array_keys($productlist);

						$dataidlist = array('product' => $products,
												'store' => array($storeid),
												);
						$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
						$mastervalues = array('sdoanhthu', 'ssoluongthucban' , 'slaigop' , 'smargin' , 'trigiacuoiky' , 'ngaybanhang', 'stralai' , 'sgiabantrungbinh' , 'sgiavontrungbinh');

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

						$vendoritem['ten']             = $vendorname;	
						$vendoritem['id']              = $vendorid;
						$vendoritem['soluong']         = $data['datamaster']['ssoluongthucban'];
						$vendoritem['doanhthu']        = $data['datamaster']['sdoanhthu'];
						$vendoritem['laigop']          = $data['datamaster']['slaigop'];
						$vendoritem['mucdonggop']      = '';									
						$vendoritem['giabantrungbinh'] = $data['datamaster']['sgiabantrungbinh'];				
						$vendoritem['giavontrungbinh'] = $data['datamaster']['sgiavontrungbinh'];
						$vendoritem['margin']          = $data['datamaster']['smargin'];
						$vendoritem['giatritonkho']    = $data['datamaster']['trigiacuoiky'];
						$vendoritem['ngaybanhang']     = $data['datamaster']['ngaybanhang'];					
						$vendoritem['tralai']          = $data['datamaster']['stralai'];
						
						$vendoritemlist[$vendorname]      = $vendoritem;

						//summary caculate
						$sdoanhthu += $data['datamaster']['sdoanhthu'];
						$slaigop += $data['datamaster']['slaigop'];					
						$sgiatritonkho += $data['datamaster']['trigiacuoiky'];
						$ssoluong += $data['datamaster']['ssoluongthucban'];

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
						$vendoritem['mucdonggop'] = 'V' . ceil($vendoritem['soluong'] *100 / $ssoluong) . ' , R' . ceil($vendoritem['doanhthu'] * 100 / $sdoanhthu) . ' ,P' . ceil($vendoritem['laigop'] * 100 / $slaigop);
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
					$vendoritem['ngaybanhang'] = $item['ngaybanhang'];
					$vendoritem['tralai'] = $item['tralai'];
					$vendoritem['vendorpath'] = $item['vendorpath'];

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
			$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromCahe($productcategory->id);
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
			if(isset($_GET['startdate']))
			{
				$paramurl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']);
				$paramproducturl .= '&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']); 
			}
			if(isset($_GET['fsid'])) 
			{
				$paramurl .= '&fsid='.urlencode($_GET['fsid']);
				$paramproducturl .= '&fsid='.urlencode($_GET['fsid']);
			}			

			if(strlen($searchstring) > 0)
				$paramurl .= '&a='.$searchstring;

			//assign template		
			$this->registry->smarty->assign(array(
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
											'paramproducturl' => $paramproducturl,
											'fullproductcategory' => $fullproductcategory,										
											'listattributefilter' => $listattributefilter,										
											'stepdate' => $stepdate,
											));
			////////////////////////////////CREATE CACHE HTML
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'brandcate.tpl');
			$myCache->save($content);
			////////////////////////////////////////////
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'brandcate.tpl');
		}
		
	}//end of function

	private function forecastmaincharacterskubystore($begindate , $productlist , $productcategory , $storeid)
	{		
		
		set_time_limit(0);		

		//$numberofmonth = 2;
		$error = array();		

		///////////////////////////
		//// LAY THONG TIN MA USER NAY DA INPUT CHO CAC USERVALUE TRONG SHEET NAY
		$uservalueBefore = array();
		$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fuid' => $this->registry->me->id, 'fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHTUSKUMC ,'fdate' =>( date('m' , strtotime('+2 month' , $begindate)) . date('Y' , strtotime('+2 month' , $begindate))) ), '', '', '');		

		if(count($forecastUserValueList) > 0)
		{
			foreach($forecastUserValueList as $forecastUserValue)
			{
				$uservalueBefore[$forecastUserValue->identifier] = $forecastUserValue->value;
			}
		}
		//ket thuc lay du lieu


		$montharr = array($begindate , strtotime('+1 month' , $begindate) , strtotime('+2 month' , $begindate), strtotime('+3 month' , $begindate));							

		$datalist = array();
		$store = new Core_Store($storeid , true);		
		if(count($productlist) > 0 && $store->id > 0)
		{
			foreach ($productlist as $product) 
			{
				for ($i=0 , $ilen = count($montharr); $i < $ilen-1; $i++) 
				{ 						
					$startdateofmonth = $montharr[$i];
					$enddateofmonth = $montharr[$i+1];
					$begindateofmonth = $montharr[$i];
					
					$dataidlist = array('product' => array($product['p_id']),
											'store' => array($storeid),
											);
					$detailvalues = array();
					$mastervalues = array('stonkho' ,'snhaptrongky' , 'sxuattrongky');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdateofmonth , $enddateofmonth , $begindateofmonth);
					
					$currentvaluelist = array();
					$currentvaluelist['xuat'] = $data['datamaster']['sxuattrongky'];					
					$currentvaluelist['nhap'] = $data['datamaster']['snhaptrongky'];					
					$currentvaluelist['ton'] = $data['datamaster']['stonkho'];					

					$uservaluename = array('xuat', 'nhap', 'ton');
					$uservaluelist = array();
					foreach($uservaluename as $uname)
					{
						$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('category' => $productcategory->id, 'outputstore' => $store->id, 'barcode' => trim($product['p_barcode'])));
						$uservaluelist[$uname] = array(
							'name' => $identifier,
							'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
						);
					}					

					$datalist[$store->name][$product['p_name']][(int)date('m' , $montharr[$i])] = array('xuat' => $sptongxuat , 'nhap' => $sptongnhap , 'tonkho' => $sptonkho,																					
																				'trangthai'	=> $product['p_businessstaus'],
																				'ngaybanhang' => 0,
																				'min' => 0,
																				'max' => 0,
																				'sid' => $store->id,
																				'uservaluelist' => $uservaluelist,		
																				'currentvaluelist' => $currentvaluelist,
																				);																										
				}	

			}												
		}
		else
		{
			$error[] = 'Vui lòng chọn siêu thị để forecast.';
		}
		$_SESSION['forecastAddToken']=Helper::getSecurityToken();//Tao token moi
		$this->registry->smarty->assign(array(
											'currentmonth' => (int)date('m' , strtotime('+2 month' , $begindate)),
											'currentyear' => (int)date('Y' , strtotime('+2 month' , $begindate)),
											'datalist' => $datalist,
											'store' => $store,
											'error' => $error,
											'sheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHTUSKUMC,
											));
		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'forecastsku.tpl');	

		return $content;
	}

	private function forecastmaincharacterskubycategory($begindate , $productlist , $productcategory)
	{
		set_time_limit(0);		

		//$numberofmonth = 2;
		$error = array();		

		///////////////////////////
		//// LAY THONG TIN MA USER NAY DA INPUT CHO CAC USERVALUE TRONG SHEET NAY
		$uservalueBefore = array();
		$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fuid' => $this->registry->me->id, 'fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHTUSKUMCCATEGORY ,'fdate' =>( date('m' , strtotime('+2 month' , $begindate)) . date('Y' , strtotime('+2 month' , $begindate))) ), '', '', '');		

		if(count($forecastUserValueList) > 0)
		{
			foreach($forecastUserValueList as $forecastUserValue)
			{
				$uservalueBefore[$forecastUserValue->identifier] = $forecastUserValue->value;
			}
		}
		//ket thuc lay du lieu


		$montharr = array($begindate , strtotime('+1 month' , $begindate) , strtotime('+2 month' , $begindate), strtotime('+3 month' , $begindate));							

		$datalist = array();				
		if(count($productlist) > 0)
		{
			foreach ($productlist as $product) 
			{
				for ($i=0 , $ilen = count($montharr); $i < $ilen-1; $i++) 
				{ 						
					$startdateofmonth = $montharr[$i];
					$enddateofmonth = $montharr[$i+1];
					$begindateofmonth = $montharr[$i];
					
					$dataidlist = array('product' => array($product['p_id']),
											'store' => array(0),
											);
					$detailvalues = array();
					$mastervalues = array('stonkho' ,'snhaptrongky' , 'sxuattrongky');

					$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdateofmonth , $enddateofmonth , $begindateofmonth);
					
					$currentvaluelist = array();
					$currentvaluelist['xuat'] = $data['datamaster']['sxuattrongky'];					
					$currentvaluelist['nhap'] = $data['datamaster']['snhaptrongky'];					
					$currentvaluelist['ton'] = $data['datamaster']['stonkho'];					

					$uservaluename = array('xuat', 'nhap', 'ton');
					$uservaluelist = array();
					foreach($uservaluename as $uname)
					{
						$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('category' => $productcategory->id, 'outputstore' => $store->id, 'barcode' => trim($product['p_barcode'])));
						$uservaluelist[$uname] = array(
							'name' => $identifier,
							'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
						);
					}					

					$datalist[$store->name][$product['p_name']][(int)date('m' , $montharr[$i])] = array('xuat' => $sptongxuat , 'nhap' => $sptongnhap , 'tonkho' => $sptonkho,																					
																				'trangthai'	=> $product['p_businessstaus'],
																				'ngaybanhang' => 0,
																				'min' => 0,
																				'max' => 0,
																				'sid' => $store->id,
																				'uservaluelist' => $uservaluelist,		
																				'currentvaluelist' => $currentvaluelist,
																				);																										
				}					
			}												
		}
		else
		{
			$error[] = 'Vui lòng chọn siêu thị để forecast.';
		}
		$_SESSION['forecastAddToken']=Helper::getSecurityToken();//Tao token moi
		$this->registry->smarty->assign(array(
											'currentmonth' => (int)date('m' , strtotime('+2 month' , $begindate)),
											'currentyear' => (int)date('Y' , strtotime('+2 month' , $begindate)),
											'datalist' => $datalist,											
											'error' => $error,
											'sheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHTUSKUMCCATEGORY,
											));
		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'forecastskucate.tpl');			

		return $content;
	}//end of function

	public function updatedataforecastAction()
	{
		//submit du lieu do user nhap vao
		$formData = array();
		$formData = array_merge($formData, $_POST);

		///////////////////////////////////
		if($_SESSION['forecastAddToken'] == $formData['ftoken'])
		{
			$ok = -1;
			if($this->updatedataforecasValidation($formData))
			{						
				$date = $formData['fmonth'] . $formData['fyear'];				
				foreach ($formData['fdataforecast'] as $identifier => $value) 
				{
					$myForecastUservalue = Core_Backend_ForecastUservalue::getDataBySheet($identifier , $formData['fsheet'] , $this->registry->me->id, $date);
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
							$ok = 1;
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
