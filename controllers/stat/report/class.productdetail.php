<?php
//ini_set('display_errors', 'off');

Class Controller_Stat_Report_ProductDetail Extends Controller_Stat_Report
{
	/**
	 * [indexAction description]
	 * @return [type] [description]
	 * @author [author] <[email]>
	 * @version [version]
	 */
	public function indexAction()
	{
		global $conf;
		set_time_limit(0);

		$id = (int)$_GET['id'];

		$chartby = (string)$_GET['chartby'] != '' ? (string)$_GET['chartby'] : 'revenue';
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


		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		//tim ngay dau thang
		$beginday = date('d/m/Y' , $startdate);
		$datepart = explode('/', $beginday);
		$begindate = Helper::strtotimedmy('01/' . date('m', $startdate)  . '/' . date('Y', $startdate) );


		$tab = isset($_GET['tab']) ? (int)$_GET['tab'] : 1;
		$myProduct = new Core_Product($id , true);
		$myProductcategory = new Core_Productcategory($myProduct->pcid,true);
		$dataList = array();
		$refineData = array();

		if($myProduct->id > 0)
		{
			$getproductname = explode('|', $myProduct->name, 1);
			if (!empty($getproductname[0])) $myProduct->name = $getproductname[0];

			$strangthai = Core_Product::getstaticbusinessstatusName($myProduct->businessstatus);//$myProduct->getbusinessstatusName();
			$svaitro = (!empty($myProduct->skurole)?$myProduct->skurole:'Chủ lực');;
			$snhom = '';
			$sranking = '';
			$ssoluongthucban = 0;
			$stralai = 0;
			$sdoanhthu = 0;
			$sthanhtoan = 0;
			$slaigop = 0;
			$smargin = 0;
			$sdiemchuan = 0;
			$stongdiemthuong = 0;
			$sgiabantrungbinh = 0;
			$sgiabantrungbinhcovat = 0;
			$sgiavontrungbinh = 0;
			$stonkho = 0;
			$stocdobantrungbinh = 0;
			$ssucban = 0;
			$sngaytonkho = '';
			$snhaptrongky = 0;
			$sngaycaodiem = '';
			$sgianiemyet = Helper::formatPrice($myProduct->sellprice);
			$inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice(trim($myProduct->barcode));
			$sgiamuavao = Helper::formatPrice($inputpriceinfo['inputprice'] - $inputpriceinfo['discount']);
			$strigiahangkhuyenmai = 0;
			$sdoanhthutralai = 0;


			$giavontrungbinhtong = 0;
			$listproductidapply = array();//array($myProduct->id);
			$getcolorproductids = $myProduct->getProductColor();
			if (!empty($getcolorproductids)) $listproductidapply = $getcolorproductids;
			if (!in_array($myProduct->id, $listproductidapply)) $listproductidapply[] = $myProduct->id;

			$dataidlist = array('product' => $listproductidapply,
								'store' => $storeid,
								);
			if($storeid > 0)
			{
				$dataidlist['groupstore'] = 1;
			}

			$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'thanhtoanthucte' , 'giabanchuavat' , 'giabancovat' , 'giavontrungbinh' , 'laigop' , 'margin' , 'giavon' , 'tralai' , 'doanhthutralai');
			$mastervalues = array('ssoluongthucban' , 'stralai' , 'sdoanhthutralai' , 'sdoanhthu' , 'sthanhtoan' , 'slaigop' , 'smargin' , 'sgiabantrungbinh' , 'sgiavontrungbinh' , 'sgiabantrungbinhcovat' , 'stonkho' , 'snhaptrongky' , 'sngaycaodiem', 'xuatban', 'tongsodiemchuan');

			$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

			//if (!empty($_GET['test']))echodebug($data);
			$dataList = array();

			foreach ($listproductidapply as $pid)
			{
				if (!empty($data['data'][$storeid][$pid]))
				{
					foreach ($data['data'][$storeid][$pid] as $kdt=>$itemval)
					{
						foreach ($detailvalues as $val)
						{
							$dataList[$kdt][$val] += $itemval[$val];
						}
					}
				}
			}

			if(count($dataList) > 0)
			{
				foreach($dataList as $date => $value)
				{
					if ($value['laigop'] > 0 ) $dataList[$date]['margin'] = round($dataList[$date]['laigop']*100 / $dataList[$date]['doanhthuthucte'], 2);
					if ($value['soluongthucban'] > 0 ) {
						$dataList[$date]['giabanchuavat'] = round($dataList[$date]['doanhthuthucte'] / $dataList[$date]['soluongthucban'], 2);
						$dataList[$date]['giabancovat'] = round($dataList[$date]['thanhtoanthucte'] / $dataList[$date]['soluongthucban'], 2);
						$dataList[$date]['giavontrungbinh'] = abs($dataList[$date]['giavon'] / $dataList[$date]['soluongthucban']);
					}

					$xdtdate = date('d/m' , $date);
					switch ($chartby)
					{
						case 'revenue':
							$refineData[$xdtdate] = $value['doanhthuthucte'];
							break;

						case 'volume':
							$refineData[$xdtdate] = $value['soluongthucban'];
							break;

						case 'profit':
							$refineData[$xdtdate] = $value['laigop'];
							break;
					}
				}
			}
			//summary info
			$ssoluongthucban = $data['datamaster']['ssoluongthucban'];
			$stralai = $data['datamaster']['stralai'];
			$sdoanhthu = $data['datamaster']['sdoanhthu'];
			$sthanhtoan = $data['datamaster']['sthanhtoan'];
			$slaigop = $data['datamaster']['slaigop'];
			$smargin = $data['datamaster']['smargin'];
			$sdiemchuan = $data['datamaster']['tongsodiemchuan'];
			$stongdiemthuong = 0;
			$sgiabantrungbinh = $data['datamaster']['sgiabantrungbinh'];
			$sgiabantrungbinhcovat = $data['datamaster']['sgiabantrungbinhcovat'];
			$sgiavontrungbinh = $data['datamaster']['sgiavontrungbinh'];
			$stonkho = $data['datamaster']['stonkho'];
			$ssongaybanhang = ceil(($enddate - $startdate)/(24*3600)) + 1;
			$stocdobantrungbinh = round($ssoluongthucban/$ssongaybanhang, 2);
			$ssucban = round($data['datamaster']['xuatban']/$ssongaybanhang, 0);
			$sngaytonkho = round($stonkho/$stocdobantrungbinh, 0);
			$snhaptrongky = $data['datamaster']['snhaptrongky'];
			$sngaycaodiem = $data['datamaster']['sngaycaodiem'];
			$sdoanhthutralai = $data['datamaster']['sdoanhthutralai'];

			//get group and ranking of product
			$rankinggroups = self::getproductsrankingandgroup($myProduct->pcid , $myProduct->id);
			$snhom = $rankinggroups['group'];
			$sranking = $rankinggroups['ranking'];	//tam thoi comment lai cho tinh toan
		}

		//chart
		$chartData = array();

		$chartData[$myProduct->name] = $refineData;
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

		//////////////////////////////////////////////
		$content = '';
		switch ($tab)
		{
			case 2:
				$content = $this->instockvolume($listproductidapply , $startdate , $enddate , $begindate);
				break;

			case 3:
				$contentarr = $this->instockvalue($listproductidapply, $startdate , $enddate , $begindate);
				$content = $contentarr['content'];
				//$stonkho = $contentarr['cuoiky'];
				break;

			case 10 :
				$content = $this->forecastproduct($begindate , $myProduct);
				break;
		}
		///////////////////////////////////////////////
		$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($myProduct->pcid);
		$fullproductcategory[$myProductcategory->id] = array('name' => $myProductcategory->name);

		$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
		if($stepdate > 7)
			$stepdate = ceil($stepdate / 7) - 1;
		///////////////////////////////////////////////

		$urlparam = '';
		if (!empty($_GET['startdate']) && !empty($_GET['enddate']))
		{
			$urlparam .= 'startdate='.$_GET['startdate'].'&enddate='.$_GET['enddate'];
		}
		if (!empty($_GET['fsid']))
		{
			if (!empty($urlparam)) $urlparam .= '&fsid='.$storeid;
			else $urlparam = 'fsid='.$storeid;
		}

		$cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
		$report_timeupdatereport = $cacheredis->get();
		if (!empty($report_timeupdatereport))
		{
			$report_timeupdatereport = 'Dữ liệu cập nhật mới nhất vào '.date('H:i:s d/m/Y', $report_timeupdatereport);
		}

		$finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($myProduct, 3);
		if ($finalprice < 10)
		{
			$finalprice = $myProduct->sellprice;
		}
		$getpromotion = Core_Promotion::getFirstDiscountPromotion(trim($myProduct->barcode), 3);
		$sgiabancuoi = $myProduct->sellprice;
		if(!empty($getpromotion))
		{
			if ($getpromotion['percent'] == 1)
			{
				$sgiabancuoi = $finalprice - ($finalprice * $getpromotion['discountvalue']/100);
			}
			else
			{
				$sgiabancuoi = $finalprice - $getpromotion['discountvalue'];
			}
		}
		unset($getpromotion);
		unset($finalprice);

		$this->registry->smarty->assign(array(
										'report_timeupdatereport' => $report_timeupdatereport,
												'myProduct' => $myProduct,
												'chartData' => $chartData,
												'liststores' => Core_Store::getStoresFromCache(),
												'chartType' => 'line',
												'chartby' => $chartby,
												'storeid' => $storeid,
												'chartTitle' => $chartTitle,
												'startdate' => date('d/m/Y', $startdate),
												'enddate' => date('d/m/Y', $relenddate),
												'dataList' => $dataList,
												'strangthai' => $strangthai,
												'svaitro' => $svaitro,
												'snhom' => $snhom,
												'sranking' => $sranking,
												'ssoluongthucban' => $ssoluongthucban,
												'stralai' => $stralai,
												'sdoanhthutralai' => $sdoanhthutralai,
												'sdoanhthu' => $sdoanhthu,
												'sthanhtoan' => $sthanhtoan,
												'smargin' => $smargin,
												'slaigop' => $slaigop,
												'sdiemchuan' => $sdiemchuan,
												'stongdiemthuong' => $stongdiemthuong,
												'sgiabantrungbinh' => $sgiabantrungbinh,
												'sgiabantrungbinhcovat' => $sgiabantrungbinhcovat,
												'sgiavontrungbinh' => $sgiavontrungbinh,
												'stonkho' => $stonkho,
												'stocdoban' => $stocdobantrungbinh,
												'sngaytonkho' => $sngaytonkho,
												'snhaptrongky' => $snhaptrongky,
												'sngaycaodiem' => $sngaycaodiem,
												'sgianiemyet' => $sgianiemyet,
												'sgiamuavao' => $sgiamuavao,
												'tab' => $tab,
												'content' => $content,
												'fullproductcategory' => $fullproductcategory,
												'stepdate' => $stepdate,
												'urlparam' => $urlparam,
												'sgiabancuoi' => $sgiabancuoi,
                                            ));
	$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
	}


	/**
	 * [instokvolumeAction description]
	 * @return [type] [description]
	 */
	private function instockvolume($productidarr , $startdate , $enddate , $begindate)
	{

		if(count($productidarr) > 0 && $startdate < $enddate)
		{
			//lay tat ca cac store hien tai trong he thong
			$storelist = Core_Store::getStoresFromCache(true);

			$ssoluongthucban = 0;
			$ssoluongtralai = 0;
			$stonkhodauky = 0;
			$scuoiky = 0;
			$snhapmua = 0;
			$snhapnoibo = 0;
			$snhaptralai = 0;
			$snhapkhac = 0;
			$sxuatban = 0;
			$sxuattramuahang = 0;
			$sxuatnoibo = 0;
			$sxuatkhac = 0;

			$storedatalist = array();
			foreach ($storelist as $storeid => $storename)
			{
				$storeitem = array();

				$dataidlist = array('product' => $productidarr,
									'store' => $storeid,
									'groupstore' => 1,
									);
				$detailvalues = array();
				$mastervalues = array('soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'sucban' , 'ngaybanhang' , 'stonkho');

				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

				if ($data['datamaster']['soluongdauky'] ==0 && $data['datamaster']['stonkho'] == 0 && $data['datamaster']['nhaptralai'] == 0) continue;

				$storeitem['ten']            = $storename;
				$storeitem['tonkhodauky']    = $data['datamaster']['soluongdauky'];
				$storeitem['nhapmua']        = $data['datamaster']['nhapmua'];
				$storeitem['nhapnoibo']      = $data['datamaster']['nhapnoibo'];
				$storeitem['nhaptralai']     = $data['datamaster']['nhaptralai'];
				$storeitem['nhapkhac']       = $data['datamaster']['nhapkhac'];
				$storeitem['xuatban']        = $data['datamaster']['xuatban'];
				$storeitem['xuatnoibo']      = $data['datamaster']['xuatnoibo'];
				$storeitem['xuattramuahang'] = $data['datamaster']['xuattramuahang'];
				$storeitem['xuatkhac']       = $data['datamaster']['xuatkhac'];
				$storeitem['cuoiky']         = $data['datamaster']['stonkho'];
				$storeitem['chonhapkho']     = 0;
				$storeitem['sucban']         = $data['datamaster']['sucban'];
				$storeitem['tocdoban']       = '';
				$storeitem['ngaybanhang']    = $data['datamaster']['ngaybanhang'];

				//sum data
				$stonkhodauky += $data['datamaster']['soluongdauky'];
				$snhapmua += $data['datamaster']['nhapmua'];
				$snhapnoibo += $data['datamaster']['nhapnoibo'];
				$snhaptralai += $data['datamaster']['nhaptralai'];
				$snhapkhac += $data['datamaster']['nhapkhac'];
				$sxuatban += $data['datamaster']['xuatban'];
				$sxuattramuahang += $data['datamaster']['xuattramuahang'];
				$sxuatnoibo += $data['datamaster']['xuatnoibo'];
				$sxuatkhac += $data['datamaster']['xuatkhac'];
				$scuoiky += $data['datamaster']['stonkho'];


				$storedatalist[] = $storeitem;

				unset($storeitem);

			}

			$datalist = $storedatalist;
			$storedatalist = array();

			$songay = ($enddate - $startdate) / (24*3600);
			$ssucban =  ($songay > 0) ? ceil($sxuatban / $songay) : 0;
			$sngaybanhang = ($ssucban > 0) ? ceil($scuoiky / $ssucban) : 0;

			$storedatalist[] = array('ten' => 'Toàn công ty',
									'tonkhodauky' => $stonkhodauky,
									'nhapmua' => $snhapmua,
									'nhapnoibo' => $snhapnoibo,
									'nhaptralai' => $snhaptralai,
									'nhapkhac' => $snhapkhac,
									'xuatban' => $sxuatban,
									'xuatnoibo' => $sxuatnoibo,
									'xuattramuahang' => $sxuattramuahang,
									'xuatkhac' => $sxuatkhac,
									'cuoiky' => $scuoiky,
									'chonhapkho' => 0,
									'sucban' => $ssucban,
									'tocdoban' => '',
									'ngaybanhang' => $sngaybanhang,
									);

			foreach ($datalist as $data)
			{
				$storedatalist[] = $data;
			}
		}

		$this->registry->smarty->assign(array(
										'tab' => $tab,
										'startdate' => date('d/m/Y', $startdate),
										'enddate' => date('d/m/Y', strtotime('-1 day', $enddate)),
										'storedatalist' => $storedatalist
										));

		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'instockvolume.tpl');
		return $content;

	}



	/**
	 * [instockvalue description]
	 * @param  [type] $startdate [description]
	 * @param  [type] $enddate   [description]
	 * @param  [type] $begindate [description]
	 * @return [type]            [description]
	 */
	private function instockvalue($productidarr , $startdate , $enddate , $begindate)
	{
		$tab = (int)$_GET['tab'];

		$contentarr = array();

		if(count($productidarr) > 0 && $startdate < $enddate)
		{
			//lay tat ca cac store hien tai trong he thong
			$storelist = Core_Store::getStoresFromCache(true);
			/*$storelist = array();
			$storegetfromdb = Core_Store::getStores(array(), '', '');
			foreach ($storegetfromdb as $store)
			{
				$storelist[$store->id] = $store->name;
			}*/

			$ssoluongthucban  = 0;
			$ssoluongtralai   = 0;
			$stonkhodauky     = 0;
			$ssoluongdauky    = 0;
			$scuoiky          = 0;
			$snhapmua         = 0;
			$snhapnoibo       = 0;
			$snhaptralai      = 0;
			$snhapkhac        = 0;
			$sxuatban         = 0;
			$sxuattramuahang  = 0;
			$sxuatnoibo       = 0;
			$sxuatkhac        = 0;
			$strigiadauky     = 0;
			$strigiacuoiky    = 0;
			$strigianhapmua   = 0;
			$strigianhapnoibo = 0;
			$strigianhaptra   = 0;
			$strigianhapkhac  = 0;
			$strigiaxuatban   = 0;
			$strigiaxuatnoibo = 0;
			$strigiaxuattra   = 0;
			$strigiaxuatkhac  = 0;

			$storedatalist = array();
			foreach ($storelist as $storeid => $storename)
			{
				$storeitem = array();

				$dataidlist = array('product' => $productidarr,
									'store' => $storeid,
									'groupstore' => 1,
									);
				$detailvalues = array();
				$mastervalues = array('soluongdauky' , 'nhapmua' , 'nhapnoibo' , 'nhaptralai' , 'nhapkhac' , 'xuatban' , 'xuatnoibo' , 'xuattramuahang' , 'xuatkhac' , 'trigiadauky' , 'trigianhapmua' , 'trigianhapnoibo' , 'trigianhaptra' , 'trigianhapkhac' , 'trigiaxuatban' , 'trigiaxuatnoibo' , 'trigiaxuattra' , 'trigiaxuatkhac' ,  'stonkho' , 'trigiacuoiky' , 'giavoncuoiky' , 'giavondauky');

				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);

				if ($data['datamaster']['soluongdauky'] ==0 && $data['datamaster']['stonkho'] == 0 && $data['datamaster']['nhaptralai'] == 0) continue;

				$storeitem['ten']             = $storename;
				$storeitem['storeid']         = $storeid;
				$storeitem['tonkhodauky']     = $data['datamaster']['soluongdauky'];
				$storeitem['trigiadauky']     = $data['datamaster']['trigiadauky'];
				$storeitem['giavondauky']     = $data['datamaster']['giavondauky'];
				$storeitem['nhapmua']         = $data['datamaster']['nhapmua'];
				$storeitem['nhapnoibo']       = $data['datamaster']['nhapnoibo'];
				$storeitem['nhaptralai']      = $data['datamaster']['nhaptralai'];
				$storeitem['nhapkhac']        = $data['datamaster']['nhapkhac'];
				$storeitem['xuatban']         = $data['datamaster']['xuatban'];
				$storeitem['xuatnoibo']       = $data['datamaster']['xuatnoibo'];
				$storeitem['xuattramuahang']  = $data['datamaster']['xuattramuahang'];
				$storeitem['xuatkhac']        = $data['datamaster']['xuatkhac'];
				$storeitem['cuoiky']          = $data['datamaster']['stonkho'];
				$storeitem['trigiacuoiky']    = $data['datamaster']['trigiacuoiky'];
				$storeitem['giavoncuoiky']    = $data['datamaster']['giavoncuoiky'];
				$storeitem['trigianhapmua']   = $data['datamaster']['trigianhapmua'];
				$storeitem['trigianhapnoibo'] = $data['datamaster']['trigianhapnoibo'];
				$storeitem['trigianhaptra']   = $data['datamaster']['trigianhaptra'];
				$storeitem['trigianhapkhac']  = $data['datamaster']['trigianhapkhac'];
				$storeitem['trigiaxuatban']   = $data['datamaster']['trigiaxuatban'];
				$storeitem['trigiaxuatnoibo'] = $data['datamaster']['trigiaxuatnoibo'];
				$storeitem['trigiaxuattra']   = $data['datamaster']['trigiaxuattra'];
				$storeitem['trigiaxuatkhac']  = $data['datamaster']['trigiaxuatkhac'];

				//if ($storeitem['cuoiky'] > 0) echo $storeid.'--'.$storeitem['cuoiky'].',';
				//sum data
				$ssoluongdauky += $data['datamaster']['soluongdauky'];
				$snhapmua += $data['datamaster']['nhapmua'];
				$snhapnoibo += $data['datamaster']['nhapnoibo'];
				$snhaptralai += $data['datamaster']['nhaptralai'];
				$snhapkhac += $data['datamaster']['nhapkhac'];
				$sxuatban += $data['datamaster']['xuatban'];
				$sxuattramuahang += $data['datamaster']['xuattramuahang'];
				$sxuatnoibo += $data['datamaster']['xuatnoibo'];
				$sxuatkhac += $data['datamaster']['xuatkhac'];
				$scuoiky += $data['datamaster']['stonkho'];
				$strigiadauky += $data['datamaster']['trigiadauky'];
				$strigiacuoiky += $data['datamaster']['trigiacuoiky'];
				$strigianhapmua += $data['datamaster']['trigianhapmua'];
				$strigianhapnoibo += $data['datamaster']['trigianhapnoibo'];
				$strigianhaptra += $data['datamaster']['trigianhaptra'];
				$strigianhapkhac += $data['datamaster']['trigianhapkhac'];
				$strigiaxuatban += $data['datamaster']['trigiaxuatban'];
				$strigiaxuatnoibo += $data['datamaster']['trigiaxuatnoibo'];
				$strigiaxuattra += $data['datamaster']['trigiaxuattra'];
				$strigiaxuatkhac += $data['datamaster']['trigiaxuatkhac'];

				$storedatalist[] = $storeitem;

				unset($storeitem);
			}

			$datalist = $storedatalist;
			$storedatalist = array();


			$storedatalist[] = array('ten' => 'Tổng cộng',
									'tonkhodauky' => $ssoluongdauky,
									'trigiadauky' => $strigiadauky,
									'giavondauky' => ($ssoluongdauky > 0) ?  $strigiatondauky / $ssoluongdauky : 0,
									'nhapmua' => $snhapmua,
									'trigianhapmua' => $strigianhapmua,
									'nhapnoibo' => $snhapnoibo,
									'trigianhapnoibo' => $strigianhapnoibo,
									'nhaptralai' => $snhaptralai,
									'trigianhaptra' => $strigianhaptra,
									'nhapkhac' => $snhapkhac,
									'trigianhapkhac' => $strigianhapkhac,
									'xuatban' => $sxuatban,
									'trigiaxuatban' => $strigiaxuatban,
									'xuatnoibo' => $sxuatnoibo,
									'trigiaxuatnoibo' => $strigiaxuatnoibo,
									'xuattramuahang' => $sxuattramuahang,
									'trigiaxuattra' => $strigiaxuattra,
									'xuatkhac' => $sxuatkhac,
									'trigiaxuatkhac' => $strigiaxuatkhac,
									'cuoiky' => $scuoiky,
									'trigiacuoiky' => $strigiacuoiky,
									'giavoncuoiky' => ($scuoiky > 0) ? $strigiacuoiky / $scuoiky  : 0,
									);

			foreach ($datalist as $data)
			{
				$storedatalist[] = $data;
			}
		}
		//////
		$contentarr['cuoiky'] = $scuoiky;
		$this->registry->smarty->assign(array(
										'tab' => $tab,
										'startdate' => date('d/m/Y', $startdate),
										'enddate' => date('d/m/Y', strtotime('-1 day', $enddate)),
										'storedatalist' => $storedatalist
										));

		$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'instockvalue.tpl');
		$contentarr['content'] = $content;
		return $contentarr;
	}

    public function forecastproductajaxAction()
    {
        set_time_limit(0);

        $id = (int)$_GET['id'];
        $error = array();
        $product = new Core_Product($id);
        if($product->id > 0)
        {
            //$begindate = Helper::strtotimedmy('01/09/2013 00:00');
            $begindate = Helper::strtotimedmy('01/' . date('m',time()) . '/' . date('Y' , time()) , '00:01' );   // tam thoi sua code fix data demo
		    $begindate = strtotime('-2 month' ,  $begindate);
            $datahtml = $this->forecastproduct($begindate , $product , true);
        }
        else
        {
            $error[] = 'Thông tin sản phẩm không hợp lệ';
        }

        $this->registry->smarty->assign(array(
                                        'datahtml' => $datahtml,
                                        'error' => $error
                                        ));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'forecastpopup.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'forecastpopup.tpl');
    }

	private function forecastproduct($begindate , $product , $popup = false)
	{
		set_time_limit(0);
		$begindate = Helper::strtotimedmy('01/' . date('m',time()) . '/' . date('Y' , time()) , '00:01' );   // tam thoi sua code fix data demo
		//$begindate = Helper::strtotimedmy('01/09/2013');
		$begindate = strtotime('-2 month' ,  $begindate);
		//$numberofmonth = 2;
		$error = array();

		////THOI GIAN DUOC EDIT CHI TU NGAY 20 - 26 HANG THANG
		$isedit = 0;
		$starttimeline = mktime('0' , '0' , '1' , date('m',time()) , '20' , date('Y' , time()) );
		$endtimeline = mktime('23' , '59' , '59' , date('m',time()) , '30' , date('Y' , time()) );
        if($popup)
        {
            $isedit = 0;
        }
        else
        {
            if($starttimeline <= time() && $endtimeline >= time())
		    {
			    $isedit = 1;
		    }
        }

		///////////////////////////
		//// LAY THONG TIN MA USER NAY DA INPUT CHO CAC USERVALUE TRONG SHEET NAY
		$uservalueBefore = array();
		//$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fuid' => $this->registry->me->id, 'fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');

		$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');

		if(count($forecastUserValueList) > 0)
		{
			foreach($forecastUserValueList as $forecastUserValue)
			{
				$uservalueBefore[$forecastUserValue->identifier] = $forecastUserValue->value;
			}
		}
		//ket thuc lay du lieu


		//$montharr = array($begindate , strtotime('+1 month' , $begindate) , strtotime('+2 month' , $begindate), strtotime('+3 month' , $begindate));
		$montharr = array($begindate , strtotime('+1 month' , $begindate) , strtotime('+2 month' , $begindate));

		$storelist = Core_Store::getStoresFromCache();

		if($product->id > 0 && count($storelist) > 0)
		{
			$datalist = array();
			foreach($storelist as $storeid => $storename)
			{
				$datainfo = array();
				$datainfo['name'] = $storename;
				$datainfo['sid'] = $storeid;
				//////////TINH SO LIEU CUA 2 THANG TRUOC
				for($i = 0 , $ilen = count($montharr) ; $i < $ilen-1 ; $i++)
				{
					$startdateofmonth = $montharr[$i];
					$enddateofmonth = $montharr[$i+1];
					$begindateofmonth = $montharr[$i];

					$dataidlist = array('product' => $product->getProductColor(),
										'store' => $storeid,
										'groupstore' => 1,
										);
                    $detailvalues = array();
					$mastervalues = array('ssoluongthucban');

                    $data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdateofmonth , $enddateofmonth , $begindateofmonth);


					$datainfo['soluongban'][date('m' , $montharr[$i])] = $data['datamaster']['ssoluongthucban'];
					unset($data);
				}


				////////TINH SO LIEU CUA THANG HIEN TAI TINH DEN NGAY HOM NAY
				$currentstartdate = Helper::strtotimedmy('01/' . date('m' , time()) . '/' .  date('Y' , time()) , '00:001' );
				$currentenddate = Helper::strtotimedmy(date('d' , time()) . '/' . date('m' , time()) . '/' . date('Y' , time()) , '00:01' );
				//$currentstartdate = Helper::strtotimedmy('01/09/2013' , '00:00');
				//$currentenddate = Helper::strtotimedmy('01/10/2013' , '00:00');
				$dataidlist = array('product' => $product->getProductColor(),
									'store' => $storeid,
									'groupstore' => 1,
									);
				$detailvalues = array();
				$mastervalues = array('ssoluongthucban' , 'stonkho');
                $data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $currentstartdate , $currentenddate , $currentstartdate);
                //echodebug(date('d/m/Y') , $currentstartdate);
                //echodebug(date('d/m/Y') , $currentenddate);
				$datainfo['soluongbanhientai'] = $data['datamaster']['ssoluongthucban'];
				$datainfo['tonkhohientai'] = $data['datamaster']['stonkho'];

				////TOC DO BAN
				$songayban = (($currentenddate - $currentstartdate) / 86400) + 1;
				//tocdoban = soluongbanthucte / songayban
				$tocdoban = ($songayban > 0) ? $data['datamaster']['ssoluongthucban'] / $songayban : 0;
				$datainfo['tocdo'] = $tocdoban;

				$enddateofcurrentmonth = strtotime('-1 day' , strtotime('+1 month' , $currentstartdate) );

				$songayconlai = ($enddateofcurrentmonth - $currentenddate) / 86400;


				$soluongbandukien = ceil($tocdoban * $songayconlai) +  $datainfo['soluongbanhientai'];


				/////SO LUONG BAN DU KIEN
				$datainfo['soluongbandukien'] = $soluongbandukien;

				/////TON KHO DU KIEN
				$tonkhodukien = $data['datamaster']['stonkho'] - ($soluongbandukien - $data['datamaster']['ssoluongthucban']);
				$datainfo['tonkhodukien'] = $tonkhodukien;

				////////NGAY MIN
				//LAY THONG TIN MIN CUA SIEU THI
				$specialstore = array(5 , 919 ,819);
				//if(!in_array($storeid, $specialstore))
				//{
					$rootcategorys = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($product->pcid); //get root of productcategory
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
						$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $product->id, 'storetype' =>$storetype->type ));
						$uservaluelistconfig[$uname] = array(
								'name' => $identifier,
								'value' => isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0,
						);
					}

					$datainfo['min'] = $uservaluelistconfig['min']['value'];
					$datainfo['ngaymin'] = $uservaluelistconfig['ngaymin']['value'];
					$datainfo['ngaymax'] = $uservaluelistconfig['ngaymax']['value'];
				//}


				/////////LAY THONG TIN CUA IMPUT CUA NGUOI DUNG
				$uservaluename = array('soluongban', 'soluongnhap');
				$uservaluelist = array();
				foreach($uservaluename as $uname)
				{
					$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $product->id, 'outputstore' => $storeid ));
					$uservaluelist[$uname] = array(
							'name' => $identifier,
							'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
					);
				}
				$datainfo['soluongbandk'] = $uservaluelist['soluongban'];
				$datainfo['soluongnhapdk'] = $uservaluelist['soluongnhap'];

				//////////////////////
				$datalist[] = $datainfo;
				unset($datainfo);
			}

			//////LAY THONG TIN NHAP CUA NGANH HANG
			$uservaluename = array('soluongban', 'soluongnhap');
			$uservaluelistcategory = array();
			foreach ($uservaluename as $uname)
			{
				$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $product->id, 'category' => $product->pcid , 'outputstore' => $storeid ));
				$uservaluelist[$uname] = array(
						'name' => $identifier,
						'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
				);
			}
			$datacategory['soluongnhapdk'] = $uservaluelist['soluongnhap'];
			$datacategory['soluongbandk'] = $uservaluelist['soluongban'];

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
				$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $product->id, 'storetype' =>4));
				$uservaluelistconfig[$uname] = array(
						'name' => $identifier,
						'value' => isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0,
				);
			}

			$datacategory['min'] = $uservaluelistconfig['min']['value'];
			$datacategory['ngaymin'] = $uservaluelistconfig['ngaymin']['value'];
			$datacategory['ngaymax'] = $uservaluelistconfig['ngaymax']['value'];

			/////LAY GIA MUA VAO CUA NGUOI DUNG NHAP
			$identifier = Core_Backend_ForecastUservalue::getIdentifier('gianhapmua', array('product' => $product->id));
			$inputpriceuser = isset($uservalueBeforeStoreConfig[$identifier]) ? $uservalueBeforeStoreConfig[$identifier] : 0;
			$inputpriceuserdata['inputpriceuser'] = $inputpriceuser;
			// ////LAY GIA MUA VAO GAN NHAT
			$inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice($product->barcode);

			$inputpricevat = ($inputpriceinfo['vatpercent'] != 0) ? $inputpriceinfo['inputprice'] * (1 + $inputpriceinfo['vat'] / $inputpriceinfo['vatpercent']) : $inputpriceinfo['inputprice'];
			$inputpricereal = $inputpriceinfo['inputprice'] - $inputpriceinfo['discount'];

			$inputpricedata['inputpricevat'] = $inputpricevat;
			$inputpricedata['inputpricereal'] = $inputpricereal;
			$inputpricedata['inputdate'] = $inputpriceinfo['inputdate'];

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
			$currentmonth = date('m' , strtotime('+2 month' , $begindate));
			$nextmonth = date('m' , strtotime('+3 month' , $begindate));

			///caculate number of days of next month forecast
			$numberdayofnextmonth = ( strtotime('+4 month' , $begindate) - strtotime('+3 month' , $begindate) ) / 86400;
			///////////////////
			$product->finalprice = (float)$product->finalprice;
			$product->sellprice = (float)$product->sellprice;
			$_SESSION['forecastcategoryAddToken']=Helper::getSecurityToken();//Tao token moi
			$this->registry->smarty->assign(array(
												'datalist' => $datalist,
												'last2month' => $last2month,
												'currentmonth' => $currentmonth,
												'nextmonth' => $nextmonth,
												'currentdate' => date('d/m' , time()),
												//'currentdate' => '30/09',
												'numberdayofnextmonth' => $numberdayofnextmonth,
												'error' => $error,
												'sheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI,
												'product' => $product,
												'currentyear' => date('Y' ,time()),
												'isedit' => $isedit,
												'datacategory' => $datacategory,
												'typelist' => Core_Backend_StoreTypeForecast::gettypeList(),
												'inputpricedata' => $inputpricedata,
												'inputpriceuserdata' => $inputpriceuserdata,
												));
			$content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'forecastsku.tpl');
			return $content;
		}
	}

	public function updatedataforecastAction()
	{
		//submit du lieu do user nhap vao
		$formData = array();
		$formData = array_merge($formData, $_POST);
		$session = $_SESSION['forecastcategoryAddToken'];
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
	 * [getproductsranking description]
	 * @param  array  $productidlist [description]
	 * @return [type]                [description]
	 */
	public static function getproductsrankingandgroup($pcid , $pid)
	{
		global $conf;
		$datalist = array();

		$myCacher = new Cacher('grlist_' . $pcid , Cacher::STORAGE_REDIS, $conf['redis'][1]);
		$data = $myCacher->get();

		$rankinggroups = json_decode($data , true);

		//echodebug($rankinggroups[$pcid][$pid]['group'],true);

		$datalist['ranking'] = $rankinggroups[$pcid][$pid]['ranking'];
		$datalist['group'] = $rankinggroups[$pcid][$pid]['group'];

		return $datalist;
	}

}
