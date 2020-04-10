<?php
Class Core_Backend_Caculatereport Extends Core_Backend_Object
{
	/**
	 * Tính toán số liệu report cho sản phẩm
	 * @param  array  $productidlist [Danh sách id cần tính toán]
	 * @param  array  $detailvalues  [những giá trị chi tiết cần tính]
	 * @param  array  $mastervalues  [những giá trị master cần tính]
	 * @param  int    $startdate     [Ngày bắt đầu]
	 * @param  int    $enddate       [Ngày kết thúc]
	 * @return int    $begindate     [Ngày đầu tháng]
	 */
	public static function caculate($dataidlist = array() , $detailvalues = array() , $mastervalues = array() , $startdate = 0 , $enddate = 0 , $begindate = 0)
	{
		$startdate = strtotime(date('Y-m-d', $startdate));
		$enddate = strtotime(date('Y-m-d', $enddate));
		$begindate = strtotime(date('Y-m-d', $begindate));

		//initialize variable
		$tongsoluongban          = 0;
		$tongsoluongtralai       = 0;
		$tongdoanhthu            = 0;
		$tongdoanhthutralai      = 0;
		$tongthanhtoan           = 0;
		$tongthanhtoantralai     = 0;
		$tonggiavonban           = 0;
		$tonggiavontralai        = 0;
		$tongtrigiahangkhuyenmai = 0;
		$tongtonkhodauky         = 0;
		$tongsoluongnhapmuadauky = 0;
		$tongsoluongxuatbandauky = 0;
		$tongnhapmua             = 0;
		$tongnhapnoibo           = 0;
		$tongnhaptralai          = 0;
		$tongnhapkhac            = 0;
		$tongxuatban             = 0;
		$tongxuatnoibo           = 0;
		$tongxuattralai          = 0;
		$tongxuatkhac            = 0;
		$tongtrigiatonkhodauky   = 0;
		$tongtrigianhapmua       = 0;
		$tongtrigianhapnoibo     = 0;
		$tongtrigianhaptralai    = 0;
		$tongtrigianhapkhac      = 0;
		$tongtrigiaxuatban       = 0;
		$tongtrigiaxuatnoibo     = 0;
		$tongtrigiaxuattralai    = 0;
		$tongtrigiaxuatkhac      = 0;
		$tongtrigianhapmuadauky  = 0;
		$tongtrigiaxuatbandauky  = 0;
		$tongsoluongdonhang      = 0;
		$tongsoluotkhach         = 0;
		$tongsodiemchuan        = 0;
		////////////////////////////////

		//-----LOAI -------------------
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
		$arrtypesrefund = array(
			Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME,
			Core_Stat::TYPE_INPUT_REFUND_REV_VALUE,
			Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT,
			Core_Stat::TYPE_REFUND_COSTPRICE,
			Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME,
			Core_Stat::TYPE_INPUT_BEGINTERM_VALUE,
			Core_Stat::TYPE_INPUT_VOLUME,
			Core_Stat::TYPE_INPUT_INTERNAL_VOLUME,
			Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME,
			Core_Stat::TYPE_INPUT_OTHER_VOLUME,
			Core_Stat::TYPE_INPUT_VALUE,
			Core_Stat::TYPE_INPUT_INTERNAL_VALUE,
			Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE,
			Core_Stat::TYPE_INPUT_OTHER_VALUE,
		);
		//-----END LOAI -------------------

		$result = array();
		$data = array();
		$ngaycaodiem = array();



		$storeid = (!empty($dataidlist['store'])? $dataidlist['store']:0);
		$pricesegment = (!empty($dataidlist['pricesegment'])? $dataidlist['pricesegment']:0);
		$vendor = (!empty($dataidlist['vendor'])? $dataidlist['vendor']:0);
		$maincharacter = (!empty($dataidlist['character'])? $dataidlist['character']:0);

		if(!empty($dataidlist['product']))
		{
			$storeidlist = Core_Store::getGroupStoreFromCache($storeid);
			if ($storeid > 0 && (empty($storeidlist) || !in_array($storeid, $storeidlist))) $storeidlist[] = $storeid;
			if(isset($dataidlist['groupstore']))
			{
				$listallfinalproducts = array();

						$gsoluongban          = array();
						$gsoluongtralai       = array();
						$gdoanhthu            = array();
						$gdoanhthutralai      = array();
						$gthanhtoan           = array();
						$gthanhtoantralai     = array();
						$ggiavonban           = array();
						$ggiavontralai        = array();
						$gtrigiahangkhuyenmai = array();
						$gtonkhodauky         = array();
						$gsoluongdauky         = array();
						$gsoluongnhapmuadauky = array();
						$gsoluongxuatbandauky = array();
						$gnhapmua             = array();
						$gnhapnoibo           = array();
						$gnhaptralai          = array();
						$gnhapkhac            = array();
						$gxuatban             = array();
						$gxuatnoibo           = array();
						$gxuattralai          = array();
						$gxuatkhac            = array();
						$gtrigiatonkhodauky   = array();
						$gtrigiadauky   = array();
						$gtrigianhapmua       = array();
						$gtrigianhapnoibo     = array();
						$gtrigianhaptralai    = array();
						$gtrigianhapkhac      = array();
						$gtrigiaxuatban       = array();
						$gtrigiaxuatnoibo     = array();
						$gtrigiaxuattralai    = array();
						$gtrigiaxuatkhac      = array();
						$gtrigianhapmuadauky  = array();
						$gtrigiaxuatbandauky  = array();
						$gsoluongdonhang      = array();
						$gsoluotkhach         = array();
						$gtongdiemchuan         = array();
				foreach ($storeidlist as $sid)
				{
					$soluonglonnhat = 0;
					$conditionvol = array( 'outputstore' => $sid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);
					$conditionvolreturn = 	array('inputstore' => $sid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);
					$condtionreward = array();
					if (is_array($dataidlist['product']))
					{
						$conditionvol['products'] = $dataidlist['product'];
						$condtionreward['products'] = $dataidlist['product'];
						$conditionvolreturn['products'] = $dataidlist['product'];
					}
					else
					{
						$conditionvol['product'] = $dataidlist['product'];
						$conditionvolreturn['product'] = $dataidlist['product'];
						$condtionreward['product'] = $dataidlist['product'];
					}
					$listfinalproducts = array();

					$getdatalistalltypes = Core_Stat::getDataList($arrtypes, $conditionvol, $startdate, $enddate );
					if (!empty($getdatalistalltypes)) $listfinalproducts = array_merge($listfinalproducts, array_keys($getdatalistalltypes));

					$getdatalistalltypesrefund = Core_Stat::getDataList($arrtypesrefund, $conditionvolreturn, $startdate, $enddate );
					if (!empty($getdatalistalltypesrefund)) $listfinalproducts = array_merge($listfinalproducts, array_keys($getdatalistalltypesrefund));

					//so luot khach vao sieu thi
					$soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $startdate, $enddate );

					//lay diem thuong
					if ($ishavetongdiemchuam == false)
					{
						$diemchuan = Core_Stat::getDataList(Core_Stat::TYPE_PRODUCTREWARD, $condtionreward, $startdate, $enddate );
					}


					$listfinalproducts = array_unique($listfinalproducts);
					$listallfinalproducts = array_merge($listallfinalproducts, $listfinalproducts);
					foreach ($listfinalproducts as $pid)
					{
						$dt = $startdate;
						while ($dt < $enddate)
						{
							$dtdate = date('Y/m/d' , $dt);
							$xdtdate = date('d/m' , $dt);

							//soluongthucban = soluongban - soluongtralai
							$soluongban = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VOLUME][$dtdate]))
							{
								$soluongban = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VOLUME][$dtdate];
							}

							$soluongtralai = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME][$dtdate]))
							{
								$soluongtralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME][$dtdate];
							}

							$doanhthu = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT][$dtdate]))
							{
								$doanhthu = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT][$dtdate];
							}

							$doanhthutralai = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUE][$dtdate]))
							{
								$doanhthutralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUE][$dtdate];
							}

							$thanhtoan = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE][$dtdate]))
							{
								$thanhtoan = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE][$dtdate];
							}

							$thanhtoantralai = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT][$dtdate]))
							{
								$thanhtoantralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT][$dtdate];
							}

							$giavonban = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_COSTPRICE][$dtdate]))
							{
								$giavonban = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_COSTPRICE][$dtdate];
							}

							$giavontralai = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_REFUND_COSTPRICE][$dtdate]))
							{
								$giavontralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_REFUND_COSTPRICE][$dtdate];
							}

							$giatrihangkhuyenmai = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_PROMOTION_COSTPRICE][$dtdate]))
							{
								$giatrihangkhuyenmai = $getdatalistalltypes[$pid][Core_Stat::TYPE_PROMOTION_COSTPRICE][$dtdate];
							}

							/*$tonkhodauky = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate]))//begindate
							{
								$tonkhodauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate];
							}

							$trigiatonkhodauky = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtdate]))//begindate
							{
								$trigiatonkhodauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtdate];
							}

							$soluongnhapmuadauky = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate]))//begindate
							{
								$soluongnhapmuadauky = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
							}

							$trigianhapmuadauky = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate]))//begindate
							{
								$trigianhapmuadauky = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate];
							}

							$soluongxuatbandauky = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate]))//begindate
							{
								$soluongxuatbandauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
							}

							$trigiaxuatbandauky = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate]))//begindate
							{
								$trigiaxuatbandauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate];
							}*/

							$nhapmua = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VOLUME][$dtdate]))
							{
								$nhapmua = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VOLUME][$dtdate];
							}

							$nhapnoibo = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VOLUME][$dtdate]))
							{
								$nhapnoibo = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VOLUME][$dtdate];
							}

							$nhaptralai = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME][$dtdate]))
							{
								$nhaptralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME][$dtdate];
							}

							$nhapkhac = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VOLUME][$dtdate]))
							{
								$nhapkhac = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VOLUME][$dtdate];
							}

							$xuatban = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VOLUME][$dtdate]))
							{
								$xuatban = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VOLUME][$dtdate];
							}

							$xuatnoibo = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME][$dtdate]))
							{
								$xuatnoibo = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME][$dtdate];
							}

							$xuattramuahang = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME][$dtdate]))
							{
								$xuattramuahang = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME][$dtdate];
							}

							$xuatkhac = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VOLUME][$dtdate]))
							{
								$xuatkhac = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VOLUME][$dtdate];
							}

							$trigianhapmua = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VALUE][$dtdate]))
							{
								$trigianhapmua = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VALUE][$dtdate];
							}

							$trigianhapnoibo = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VALUE][$dtdate]))
							{
								$trigianhapnoibo = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VALUE][$dtdate];
							}

							$trigianhaptra = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE][$dtdate]))
							{
								$trigianhaptra = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE][$dtdate];
							}

							$trigianhapkhac = 0;
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VALUE][$dtdate]))
							{
								$trigianhapkhac = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VALUE][$dtdate];
							}

							$trigiaxuatban = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VALUE][$dtdate]))
							{
								$trigiaxuatban = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VALUE][$dtdate];
							}

							$trigiaxuatnoibo = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE][$dtdate]))
							{
								$trigiaxuatnoibo = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE][$dtdate];
							}

							$trigiaxuattra = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE][$dtdate]))
							{
								$trigiaxuattra = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE][$dtdate];
							}

							$trigiaxuatkhac = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VALUE][$dtdate]))
							{
								$trigiaxuatkhac = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VALUE][$dtdate];
							}

							$soluongdonhang = 0;
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ORDER_VOLUME][$dtdate]))
							{
								$soluongdonhang = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ORDER_VOLUME][$dtdate];
							}

							$soluongthucban = $soluongban - $soluongtralai;

							//doanhthuthucthe = doanhthu - doanhthutralai
							$doanhthuthucte = $doanhthu - $doanhthutralai;

							//thanhtoanthuc te = thanhtoan - thanhtoantralai
							$thanhtoanthucte = $thanhtoan - $thanhtoantralai;

							//giavon = giavonban - giavontralai
							$giavon = $giavonban - $giavontralai;

							//laigop = doanhthuthucte - giavon
							$laigop = $doanhthuthucte - $giavon;

							if($soluonglonnhat <= $soluongthucban)
							{
								$ngaycaodiem[$storeid] = date('d/m/Y' , $dt);//[$productid]
								$soluonglonnhat = $soluongthucban;
							}

							if (empty($gsoluongban[$pid][$dt])) $gsoluongban[$pid][$dt] = 0;
							if (empty($gsoluongtralai[$pid][$dt])) $gsoluongtralai[$pid][$dt] = 0;
							if (empty($gdoanhthu[$pid][$dt])) $gdoanhthu[$pid][$dt] = 0;
							if (empty($gdoanhthutralai[$pid][$dt])) $gdoanhthutralai[$pid][$dt] = 0;
							if (empty($gthanhtoan[$pid][$dt])) $gthanhtoan[$pid][$dt] = 0;
							if (empty($gthanhtoantralai[$pid][$dt])) $gthanhtoantralai[$pid][$dt] = 0;
							if (empty($ggiavonban[$pid][$dt])) $ggiavonban[$pid][$dt] = 0;
							if (empty($ggiavontralai[$pid][$dt])) $ggiavontralai[$pid][$dt] = 0;
							if (empty($gtrigiahangkhuyenmai[$pid][$dt])) $gtrigiahangkhuyenmai[$pid][$dt] = 0;
							if (empty($gnhapmua[$pid][$dt])) $gnhapmua[$pid][$dt] = 0;
							if (empty($gnhapnoibo[$pid][$dt])) $gnhapnoibo[$pid][$dt] = 0;
							if (empty($gnhaptralai[$pid][$dt])) $gnhaptralai[$pid][$dt] = 0;
							if (empty($gnhapkhac[$pid][$dt])) $gnhapkhac[$pid][$dt] = 0;
							if (empty($gxuatban[$pid][$dt])) $gxuatban[$pid][$dt] = 0;
							if (empty($gxuatnoibo[$pid][$dt])) $gxuatnoibo[$pid][$dt] = 0;
							if (empty($gxuattralai[$pid][$dt])) $gxuattralai[$pid][$dt] = 0;
							if (empty($gxuatkhac[$pid][$dt])) $gxuatkhac[$pid][$dt] = 0;
							if (empty($gtrigianhapmua[$pid][$dt])) $gtrigianhapmua[$pid][$dt] = 0;
							if (empty($gtrigianhapnoibo[$pid][$dt])) $gtrigianhapnoibo[$pid][$dt] = 0;
							if (empty($gtrigianhaptralai[$pid][$dt])) $gtrigianhaptralai[$pid][$dt] = 0;
							if (empty($gtrigianhapkhac[$pid][$dt])) $gtrigianhapkhac[$pid][$dt] = 0;
							if (empty($gtrigiaxuatban[$pid][$dt])) $gtrigiaxuatban[$pid][$dt] = 0;
							if (empty($gtrigiaxuatnoibo[$pid][$dt])) $gtrigiaxuatnoibo[$pid][$dt] = 0;
							if (empty($gtrigiaxuattralai[$pid][$dt])) $gtrigiaxuattralai[$pid][$dt] = 0;
							if (empty($gtrigiaxuatkhac[$pid][$dt])) $gtrigiaxuatkhac[$pid][$dt] = 0;
							if (empty($gsoluongdonhang[$pid][$dt])) $gsoluongdonhang[$pid][$dt] = 0;
							if (empty($gsoluotkhach[$pid][$dt])) $gsoluotkhach[$pid][$dt] = 0;
							if (empty($gtongdiemchuan[$pid][$dt])) $gtongdiemchuan[$pid][$dt] = 0;


							$gsoluongban[$pid][$dt]          += $soluongban;
							$gsoluongtralai[$pid][$dt]       += $soluongtralai;
							$gdoanhthu[$pid][$dt]            += $doanhthu;
							$gdoanhthutralai[$pid][$dt]      += $doanhthutralai;
							$gthanhtoan[$pid][$dt]           += $thanhtoan;
							$gthanhtoantralai[$pid][$dt]     += $thanhtoantralai ;
							$ggiavonban[$pid][$dt]           += $giavonban;
							$ggiavontralai[$pid][$dt]        += $giavontralai;
							$gtrigiahangkhuyenmai[$pid][$dt] += $giatrihangkhuyenmai;
							$gnhapmua[$pid][$dt]             += $nhapmua;
							$gnhapnoibo[$pid][$dt]           += $nhapnoibo;
							$gnhaptralai[$pid][$dt]          += $nhaptralai;
							$gnhapkhac[$pid][$dt]            += $nhapkhac;
							$gxuatban[$pid][$dt]             += $xuatban;
							$gxuatnoibo[$pid][$dt]           += $xuatnoibo;
							$gxuattralai[$pid][$dt]          += $xuattramuahang;
							$gxuatkhac[$pid][$dt]            += $xuatkhac;
							$gtrigianhapmua[$pid][$dt]       += $trigianhapmua;
							$gtrigianhapnoibo[$pid][$dt]     += $trigianhapnoibo;
							$gtrigianhaptralai[$pid][$dt]    += $trigianhaptra;
							$gtrigianhapkhac[$pid][$dt]      += $trigianhapkhac;
							$gtrigiaxuatban[$pid][$dt]       += $trigiaxuatban;
							$gtrigiaxuatnoibo[$pid][$dt]     += $trigiaxuatnoibo;
							$gtrigiaxuattralai[$pid][$dt]    += $trigiaxuattra;
							$gtrigiaxuatkhac[$pid][$dt]      += $trigiaxuatkhac;
							$gsoluongdonhang[$pid][$dt]      += $soluongdonhang;
							$gsoluotkhach[$pid][$dt]         += $soluotkhach[$dtdate];
							if (!empty($diemchuan[$pid][Core_Stat::TYPE_PRODUCTREWARD][$dtdate]))
							{
								if ($ishavetongdiemchuam == false) $gtongdiemchuan[$pid][$dt]         += $diemchuan[$pid][Core_Stat::TYPE_PRODUCTREWARD][$dtdate];
							}

							$gsoluotkhach[$pid][$dt]         += $soluotkhach[$dtdate];
							/////////////////
							$tongsoluongban          += $soluongban;
							$tongsoluongtralai       += $soluongtralai;
							$tongdoanhthu            += $doanhthu;
							$tongdoanhthutralai      += $doanhthutralai;
							$tongthanhtoan           += $thanhtoan;
							$tongthanhtoantralai     += $thanhtoantralai ;
							$tonggiavonban           += $giavonban;
							$tonggiavontralai        += $giavontralai;
							$tongtrigiahangkhuyenmai += $giatrihangkhuyenmai;
							$tongnhapmua             += $nhapmua;
							$tongnhapnoibo           += $nhapnoibo;
							$tongnhaptralai          += $nhaptralai;
							$tongnhapkhac            += $nhapkhac;
							$tongxuatban             += $xuatban;
							$tongxuatnoibo           += $xuatnoibo;
							$tongxuattralai          += $xuattramuahang;
							$tongxuatkhac            += $xuatkhac;
							$tongtrigianhapmua       += $trigianhapmua;
							$tongtrigianhapnoibo     += $trigianhapnoibo;
							$tongtrigianhaptralai    += $trigianhaptra;
							$tongtrigianhapkhac      += $trigianhapkhac;
							$tongtrigiaxuatban       += $trigiaxuatban;
							$tongtrigiaxuatnoibo     += $trigiaxuatnoibo;
							$tongtrigiaxuattralai    += $trigiaxuattra;
							$tongtrigiaxuatkhac      += $trigiaxuatkhac;
							$tongsoluongdonhang      += $soluongdonhang;
							$tongsoluotkhach         += $soluotkhach[$dtdate];;
							if ($ishavetongdiemchuam == false) $tongsodiemchuan         += $gtongdiemchuan[$dt];
							$ishavetongdiemchuam = true;
							$dt = strtotime('+1 day', $dt);
						}
						if (empty($gtonkhodauky[$pid][$begindate])) $gtonkhodauky[$pid][$begindate] = 0;
						if (empty($gtrigiatonkhodauky[$pid][$begindate])) $gtrigiatonkhodauky[$pid][$begindate] = 0;

						$dtbegidate = date('Y/m/d' , $begindate);
						//begindate
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtbegidate]))
						{
							$tongtonkhodauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtbegidate];
							$gtonkhodauky[$pid][$begindate] += $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtbegidate];
						}
						//begindate
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtbegidate]))
						{
							$tongtrigiatonkhodauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtbegidate];
							$gtrigiatonkhodauky[$pid][$begindate] += $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtbegidate];
						}

						if($begindate < $startdate)
						{
							//tinh so luong nhap va xuat dau ky
							$dt = $begindate;
							while ($dt < $startdate)
							{
								if (empty($gtrigiadauky[$pid][$dt])) $gtrigiadauky[$pid][$dt] = 0;
								if (empty($gsoluongdauky[$pid][$dt])) $gsoluongdauky[$pid][$dt] = 0;
								$dtdate = date('Y/m/d' , $dt);
								//begindate
								if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate]))
								{
									$tongsoluongnhapmuadauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
									$gsoluongdauky[$pid][$dt] += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
								}
								//begindate
								if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate]))
								{
									$tongtrigianhapmuadauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate];
									$gtrigiadauky[$pid][$dt] += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate];
								}
								//begindate
								if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate]))
								{
									$tongsoluongxuatbandauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
									$gsoluongdauky[$pid][$dt] -= $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
								}
								//begindate
								if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate]))
								{
									$tongtrigiaxuatbandauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate];
									$gtrigiadauky[$pid][$dt] -= $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate];
								}

								$dt = strtotime('+1 day', $dt);
							}
						}
					}

				}
				$listallfinalproducts = array_unique($listallfinalproducts);

				if(count($detailvalues) > 0)
				{
					foreach ($listallfinalproducts as $pid)
					{
						$dt = $startdate;
						$datalist = array();
						while ($dt < $enddate)
						{
							foreach ($detailvalues as $detail)
							{
								switch ($detail)
								{
									case 'soluongthucban':
										$datalist[$dt]['soluongthucban'] = $gsoluongban[$pid][$dt] - $gsoluongtralai[$pid][$dt];
										break;

									case 'doanhthuthucte' :
										$datalist[$dt]['doanhthuthucte'] = $gdoanhthu[$pid][$dt] - $gdoanhthutralai[$pid][$dt];
										break;

									case 'thanhtoanthucte' :
										$datalist[$dt]['thanhtoanthucte'] = $gthanhtoan[$pid][$dt] - $gthanhtoantralai[$pid][$dt];
										break;

									case 'giabanchuavat' :
										//giabanchuavat = doanhthu / soluongthucban
										$slthucban = $gsoluongban[$pid][$dt] - $gsoluongtralai[$pid][$dt];
										$doanthuthucte = $gdoanhthu[$pid][$dt] - $gdoanhthutralai[$pid][$dt];
										$giabanchuavat = (($slthucban != 0) ? ($doanthuthucte / $slthucban) : 0);
										$datalist[$dt]['giabanchuavat'] = $giabanchuavat;
										break;

									case 'giabancovat' :
										//giabancovat = thanhtoan / soluongthucban
										$slthucban = $gsoluongban[$pid][$dt] - $gsoluongtralai[$pid][$dt];
										$gthanhtoanthucte = $gthanhtoan[$pid][$dt] - $gthanhtoantralai[$pid][$dt];
										$giabancovat = ($slthucban != 0) ? ($gthanhtoanthucte / $slthucban) : 0;
										$datalist[$dt]['giabancovat'] = $giabancovat;
										break;

									case 'laigop' :
										$gdoanhthuthucte = $gdoanhthu[$pid][$dt] - $gdoanhthutralai[$pid][$dt];
										$ggiavon = $ggiavonban[$pid][$dt] - $ggiavontralai[$pid][$dt];
										$laigop = $gdoanhthuthucte - $ggiavon;
										$datalist[$dt]['laigop'] = $laigop;
										break;

									case 'giavon' :
										$ggiavon = $ggiavonban[$pid][$dt] - $ggiavontralai[$pid][$dt];
										$datalist[$dt]['giavon'] = $ggiavon;
										break;

									case 'margin' :
										//margin = laigop / doanhthuthucte
										$gdoanhthuthucte = $gdoanhthu[$pid][$dt] - $gdoanhthutralai[$pid][$dt];
										$ggiavon = $ggiavonban[$pid][$dt] - $ggiavontralai[$pid][$dt];
										$laigop = $gdoanhthuthucte - $ggiavon;
										$margin = ($gdoanhthuthucte != 0) ? round(($laigop * 100 / $gdoanhthuthucte) ,2) : 0;
										$datalist[$dt]['margin'] = $margin;
										break;

									case 'trigiahangkhuyenmai' :
										$datalist[$dt]['trigiahangkhuyenmai'] = $gtrigiahangkhuyenmai[$pid][$dt];
										break;

									case 'tralai' :
										$datalist[$dt]['tralai'] = $gsoluongtralai[$pid][$dt];
										break;

									case 'doanhthutralai' :
										$datalist[$dt]['doanhthutralai'] = $gdoanhthutralai[$pid][$dt];
										break;

									case 'nhapmua' :
										$datalist[$dt]['nhapmua'] = $gnhapmua[$pid][$dt];
										break;

									case 'soluotkhach' :
										$datalist[$dt]['soluotkhach'] = $gsoluotkhach[$pid][$dt];
										break;

									case 'diemchuan' :
										$datalist[$dt]['diemchuan'] = $gtongdiemchuan[$pid][$dt];
										break;

									case 'tonkho' :
										$sltondauky = $gtonkhodauky[$pid][$dt];
										$sldauky = 0;
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky + $gsoluongdauky[$pid][$dt];
										}
										$datalist[$dt]['tonkho'] = $sldauky +  $gnhapmua[$pid][$dt] + $gnhapnoibo[$pid][$dt] + $gnhaptralai[$pid][$dt] + $gnhapkhac[$pid][$dt] - $gxuatban[$pid][$dt] - $gxuatnoibo[$pid][$dt] - $gxuattralai[$pid][$dt] - $gxuatkhac[$pid][$dt];
										unset($sltondauky);
										unset($sldauky);
										break;
									case 'giavontrungbinh' :
										$slthucban = $gsoluongban[$pid][$dt] - $gsoluongtralai[$pid][$dt];
										$tgiavon = $ggiavonban[$pid][$dt] - $ggiavontralai[$pid][$dt];
										$datalist[$dt]['giavontrungbinh'] = ($slthucban != 0) ? abs($tgiavon / $slthucban) : 0;
										unset($slthucban);
										unset($tgiavon);
										break;
									case 'trigiacuoiky' :
										$sltondauky = $gtrigiatonkhodauky[$pid][$begindate];
										$sldauky = 0;
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky + $gtrigiadauky[$pid][$dt];
										}
										$datalist[$dt]['trigiacuoiky'] = $sldauky +  $gtrigianhapmua[$pid][$dt] + $gtrigianhapnoibo[$pid][$dt] + $gtrigianhaptralai[$pid][$dt] + $gtrigianhapkhac[$pid][$dt] - $gtrigiaxuatban[$pid][$dt] - $gtrigiaxuatnoibo[$pid][$dt] - $gtrigiaxuattralai[$pid][$dt] - $gtrigiaxuatkhac[$pid][$dt];
										unset($sltondauky);
										unset($sldauky);
										break;
									case 'trigiadauky':
										$datalist[$dt]['trigiadauky'] = $gtrigiadauky[$pid][$dt];
										break;
									case 'giabantrungbinh' :
										$slthucban = $gsoluongban[$pid][$dt] - $gsoluongtralai[$pid][$dt];
										$dtthucte = $gdoanhthu[$pid][$dt] - $gdoanhthutralai[$pid][$dt];
										$datalist[$dt]['giabantrungbinh'] = ($slthucban != 0) ? abs($dtthucte / $slthucban) : 0;
										unset($slthucban);
										unset($dtthucte);
										break;
									case 'ngaybanhang' :
										$songay = ceil(($enddate - $startdate) / (24*3600)) + 1;
										$sucban = ($songay > 0) ? ceil($gxuatban[$pid][$dt] /  $songay) : 0;
										$sltondauky = $gtonkhodauky[$pid][$begindate];
										$sldauky = 0;
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky + $gsoluongdauky[$pid][$dt];
										}
										$slcuoiky = $sldauky +  $gnhapmua[$pid][$dt] + $gnhapnoibo[$pid][$dt] + $gnhaptralai[$pid][$dt] + $gnhapkhac[$pid][$dt] - $gxuatban[$pid][$dt] - $gxuatnoibo[$pid][$dt] - $gxuattralai[$pid][$dt] - $gxuatkhac[$pid][$dt];
										$datalist[$dt]['ngaybanhang'] = ($sucban > 0) ? ceil($slcuoiky / $sucban) : 0;
										break;
									case 'soluongdauky' :
										$sltondauky = $gtonkhodauky[$pid][$dt];
										$sldauky = 0;
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky + $gsoluongdauky[$pid][$dt];
										}
										$datalist[$dt]['soluongdauky'] = $sldauky;
										break;
									case 'nhapmua' :
										$datalist[$dt]['nhapmua'] = $gnhapmua[$pid][$dt];
										break;
									case 'nhapnoibo' :
										$datalist[$dt]['nhapnoibo'] = $gnhapnoibo[$pid][$dt];
										break;
									case 'nhaptralai' :
										$datalist[$dt]['nhaptralai'] = $gnhaptralai[$pid][$dt];
										break;
									case 'nhapkhac' :
										$datalist[$dt]['nhapkhac'] = $gnhapkhac[$pid][$dt];
										break;
									case 'xuatban' :
										$datalist[$dt]['xuatban'] = $gxuatban[$pid][$dt];
										break;
									case 'xuatnoibo' :
										$datalist[$dt]['xuatnoibo'] = $gxuatnoibo[$pid][$dt];
										break;
									case 'xuattramuahang' :
										$datalist[$dt]['xuattramuahang'] = $gxuattralai[$pid][$dt];
										break;
									case 'xuatkhac' :
										$datalist[$dt]['xuatkhac'] = $gxuatkhac[$pid][$dt];
										break;
									case 'trigiadauky' :
										$sltondauky = $gtrigiatonkhodauky[$pid][$begindate];
										$sldauky = 0;
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky + $gtrigiadauky[$pid][$dt];
										}
										$datalist[$dt]['trigiadauky'] = $sldauky;
										break;
									case 'trigianhapmua' :
										$datalist[$dt]['trigianhapmua'] = $gtrigianhapmua[$pid][$dt];
										break;
									case 'trigianhapnoibo' :
										$datalist[$dt]['trigianhapnoibo'] = $gtrigianhapnoibo[$pid][$dt];
										break;
									case 'trigianhaptralai' :
										$datalist[$dt]['trigianhaptralai'] = $gtrigianhaptralai[$pid][$dt];
										break;
									case 'trigianhapkhac' :
										$datalist[$dt]['trigianhapkhac'] = $gtrigianhapkhac[$pid][$dt];
										break;
									case 'trigiaxuatban' :
										$datalist[$dt]['trigiaxuatban'] = $gtrigiaxuatban[$pid][$dt];
										break;
									case 'trigiaxuatnoibo' :
										$datalist[$dt]['trigiaxuatnoibo'] = $gtrigiaxuatnoibo[$pid][$dt];
										break;
									case 'trigiaxuattramuahang' :
										$datalist[$dt]['trigiaxuattramuahang'] = $gtrigiaxuattralai[$pid][$dt];
										break;
									case 'trigiaxuatkhac' :
										$datalist[$dt]['trigiaxuatkhac'] = $gtrigiaxuatkhac[$pid][$dt];
										break;
									case 'giavondauky':
										$giatritondauky = $gtonkhodauky[$pid][$begindate];
										$sltondauky = $gtrigiatonkhodauky[$pid][$begindate];
										$tongtrigiadauky = 0;
										$tongsoluongdauky = 0;
										if($startdate == $begindate)
										{
											$tongsoluongdauky = $sltondauky;
											$tongtrigiadauky = $giatritondauky;
										}
										else
										{
											$tongsoluongdauky = $sltondauky + $gsoluongnhapmuadauky[$pid][$dt] - $gsoluongxuatbandauky[$pid][$dt];
											$tongtrigiadauky = $giatritondauky + $gtrigianhapmuadauky[$pid][$dt] - $gtrigiaxuatbandauky[$pid][$dt];
										}
										$datamaster['giavondauky'] = ($tongsoluongdauky != 0) ? ($tongtrigiadauky / $tongsoluongdauky) : 0;
										break;
									case 'sucban' :
										$songay = ($enddate - $startdate) / (24*3600) + 1; //+ 1 la lay luon ngay enddate
										$datalist[$dt]['sucban'] = ($songay > 0) ? ceil($gxuatban[$pid][$dt]/  $songay) : 0;
										break;
								}
							}
							$dt = strtotime('+1 day', $dt);
						}
						$data[$storeid][$pid] = $datalist;
					}
				}
			}
			else
			{
				$conditionvol = array( 'outputstore' => $storeid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);
				$conditionvolreturn = 	array('inputstore' => $storeid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);
				$condtionreward = array();
				if (is_array($dataidlist['product']))
				{
					$conditionvol['products'] = $dataidlist['product'];
					$condtionreward['products'] = $dataidlist['product'];
					$conditionvolreturn['products'] = $dataidlist['product'];
				}
				else
				{
					$conditionvol['product'] = $dataidlist['product'];
					$conditionvolreturn['product'] = $dataidlist['product'];
					$condtionreward['product'] = $dataidlist['product'];
				}

				$listfinalproducts = array();

				$getdatalistalltypes = Core_Stat::getDataList($arrtypes, $conditionvol, $startdate, $enddate );
				if (!empty($getdatalistalltypes)) $listfinalproducts = array_keys($getdatalistalltypes);

				$getdatalistalltypesrefund = Core_Stat::getDataList($arrtypesrefund, $conditionvolreturn, $startdate, $enddate );
				if (!empty($getdatalistalltypesrefund)) $listfinalproducts = array_merge($listfinalproducts, array_keys($getdatalistalltypesrefund));

				//so luot khach vao sieu thi
				$soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $startdate, $enddate );

				//lay diem thuong
				$diemchuan = Core_Stat::getDataList(Core_Stat::TYPE_PRODUCTREWARD, $condtionreward, $startdate, $enddate );

				if (!empty($diemchuan)) $listfinalproducts = array_merge($listfinalproducts, array_keys($diemchuan));

				$listfinalproducts = array_unique($listfinalproducts);
				$soluonglonnhat = 0 ;
				foreach ($listfinalproducts as $pid)
				{

					$gsoluongban          = array();
					$gsoluongtralai       = array();
					$gdoanhthu            = array();
					$gdoanhthutralai      = array();
					$gthanhtoan           = array();
					$gthanhtoantralai     = array();
					$ggiavonban           = array();
					$ggiavontralai        = array();
					$gtrigiahangkhuyenmai = array();
					$gtonkhodauky         = array();
					$gsoluongnhapmuadauky = array();
					$gsoluongxuatbandauky = array();
					$gnhapmua             = array();
					$gnhapnoibo           = array();
					$gnhaptralai          = array();
					$gnhapkhac            = array();
					$gxuatban             = array();
					$gxuatnoibo           = array();
					$gxuattralai          = array();
					$gxuatkhac            = array();
					$gtrigiatonkhodauky   = array();
					$gtrigianhapmua       = array();
					$gtrigianhapnoibo     = array();
					$gtrigianhaptralai    = array();
					$gtrigianhapkhac      = array();
					$gtrigiaxuatban       = array();
					$gtrigiaxuatnoibo     = array();
					$gtrigiaxuattralai    = array();
					$gtrigiaxuatkhac      = array();
					$gtrigianhapmuadauky  = array();
					$gtrigiaxuatbandauky  = array();
					$gsoluongdonhang      = array();
					$gsoluotkhach         = array();
					$gtongdiemchuan         = array();
					$dt = $startdate;
					while ($dt < $enddate)
					{
						$dtdate = date('Y/m/d' , $dt);
						$xdtdate = date('d/m' , $dt);

						//soluongthucban = soluongban - soluongtralai
						$soluongban = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VOLUME][$dtdate]))
						{
							$soluongban = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VOLUME][$dtdate];
						}

						$soluongtralai = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME][$dtdate]))
						{
							$soluongtralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME][$dtdate];
						}

						$doanhthu = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT][$dtdate]))
						{
							$doanhthu = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT][$dtdate];
						}

						$doanhthutralai = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUE][$dtdate]))
						{
							$doanhthutralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUE][$dtdate];
						}

						$thanhtoan = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE][$dtdate]))
						{
							$thanhtoan = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ITEM_VALUE][$dtdate];
						}

						$thanhtoantralai = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT][$dtdate]))
						{
							$thanhtoantralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT][$dtdate];
						}

						$giavonban = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_COSTPRICE][$dtdate]))
						{
							$giavonban = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_COSTPRICE][$dtdate];
						}

						$giavontralai = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_REFUND_COSTPRICE][$dtdate]))
						{
							$giavontralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_REFUND_COSTPRICE][$dtdate];
						}

						$giatrihangkhuyenmai = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_PROMOTION_COSTPRICE][$dtdate]))
						{
							$giatrihangkhuyenmai = $getdatalistalltypes[$pid][Core_Stat::TYPE_PROMOTION_COSTPRICE][$dtdate];
						}
						/*
						$tonkhodauky = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate]))//begindate
						{
							$tonkhodauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate];
						}

						$trigiatonkhodauky = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtdate]))//begindate
						{
							$trigiatonkhodauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtdate];
						}

						$soluongnhapmuadauky = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate]))//begindate
						{
							$soluongnhapmuadauky = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
						}

						$trigianhapmuadauky = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate]))//begindate
						{
							$trigianhapmuadauky = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate];
						}

						$soluongxuatbandauky = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate]))//begindate
						{
							$soluongxuatbandauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
						}

						$trigiaxuatbandauky = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate]))//begindate
						{
							$trigiaxuatbandauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate];
						}*/

						$nhapmua = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VOLUME][$dtdate]))
						{
							$nhapmua = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VOLUME][$dtdate];
						}

						$nhapnoibo = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VOLUME][$dtdate]))
						{
							$nhapnoibo = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VOLUME][$dtdate];
						}

						$nhaptralai = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME][$dtdate]))
						{
							$nhaptralai = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME][$dtdate];
						}

						$nhapkhac = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VOLUME][$dtdate]))
						{
							$nhapkhac = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VOLUME][$dtdate];
						}

						$xuatban = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VOLUME][$dtdate]))
						{
							$xuatban = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VOLUME][$dtdate];
						}

						$xuatnoibo = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME][$dtdate]))
						{
							$xuatnoibo = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME][$dtdate];
						}

						$xuattramuahang = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME][$dtdate]))
						{
							$xuattramuahang = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME][$dtdate];
						}

						$xuatkhac = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VOLUME][$dtdate]))
						{
							$xuatkhac = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VOLUME][$dtdate];
						}

						$trigianhapmua = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VALUE][$dtdate]))
						{
							$trigianhapmua = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_VALUE][$dtdate];
						}

						$trigianhapnoibo = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VALUE][$dtdate]))
						{
							$trigianhapnoibo = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_INTERNAL_VALUE][$dtdate];
						}

						$trigianhaptra = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE][$dtdate]))
						{
							$trigianhaptra = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE][$dtdate];
						}

						$trigianhapkhac = 0;
						if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VALUE][$dtdate]))
						{
							$trigianhapkhac = $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_OTHER_VALUE][$dtdate];
						}

						$trigiaxuatban = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VALUE][$dtdate]))
						{
							$trigiaxuatban = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_VALUE][$dtdate];
						}

						$trigiaxuatnoibo = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE][$dtdate]))
						{
							$trigiaxuatnoibo = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE][$dtdate];
						}

						$trigiaxuattra = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE][$dtdate]))
						{
							$trigiaxuattra = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE][$dtdate];
						}

						$trigiaxuatkhac = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VALUE][$dtdate]))
						{
							$trigiaxuatkhac = $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_OTHER_VALUE][$dtdate];
						}

						$soluongdonhang = 0;
						if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ORDER_VOLUME][$dtdate]))
						{
							$soluongdonhang = $getdatalistalltypes[$pid][Core_Stat::TYPE_SALE_ORDER_VOLUME][$dtdate];
						}

						$soluongthucban = $soluongban - $soluongtralai;

						//doanhthuthucthe = doanhthu - doanhthutralai
						$doanhthuthucte = $doanhthu - $doanhthutralai;

						//thanhtoanthuc te = thanhtoan - thanhtoantralai
						$thanhtoanthucte = $thanhtoan - $thanhtoantralai;

						//giavon = giavonban - giavontralai
						$giavon = $giavonban - $giavontralai;

						//laigop = doanhthuthucte - giavon
						$laigop = $doanhthuthucte - $giavon;

						if($soluonglonnhat <= $soluongthucban)
						{
							$ngaycaodiem[$storeid] = date('d/m/Y' , $dt);//[$productid]
							$soluonglonnhat = $soluongthucban;
						}

						if (empty($gsoluongban[$dt])) $gsoluongban[$dt] = 0;
						if (empty($gsoluongtralai[$dt])) $gsoluongtralai[$dt] = 0;
						if (empty($gdoanhthu[$dt])) $gdoanhthu[$dt] = 0;
						if (empty($gdoanhthutralai[$dt])) $gdoanhthutralai[$dt] = 0;
						if (empty($gthanhtoan[$dt])) $gthanhtoan[$dt] = 0;
						if (empty($gthanhtoantralai[$dt])) $gthanhtoantralai[$dt] = 0;
						if (empty($ggiavonban[$dt])) $ggiavonban[$dt] = 0;
						if (empty($ggiavontralai[$dt])) $ggiavontralai[$dt] = 0;
						if (empty($gtrigiahangkhuyenmai[$dt])) $gtrigiahangkhuyenmai[$dt] = 0;
						if (empty($gnhapmua[$dt])) $gnhapmua[$dt] = 0;
						if (empty($gnhapnoibo[$dt])) $gnhapnoibo[$dt] = 0;
						if (empty($gnhaptralai[$dt])) $gnhaptralai[$dt] = 0;
						if (empty($gnhapkhac[$dt])) $gnhapkhac[$dt] = 0;
						if (empty($gxuatban[$dt])) $gxuatban[$dt] = 0;
						if (empty($gxuatnoibo[$dt])) $gxuatnoibo[$dt] = 0;
						if (empty($gxuattralai[$dt])) $gxuattralai[$dt] = 0;
						if (empty($gxuatkhac[$dt])) $gxuatkhac[$dt] = 0;
						if (empty($gtrigianhapmua[$dt])) $gtrigianhapmua[$dt] = 0;
						if (empty($gtrigianhapnoibo[$dt])) $gtrigianhapnoibo[$dt] = 0;
						if (empty($gtrigianhaptralai[$dt])) $gtrigianhaptralai[$dt] = 0;
						if (empty($gtrigianhapkhac[$dt])) $gtrigianhapkhac[$dt] = 0;
						if (empty($gtrigiaxuatban[$dt])) $gtrigiaxuatban[$dt] = 0;
						if (empty($gtrigiaxuatnoibo[$dt])) $gtrigiaxuatnoibo[$dt] = 0;
						if (empty($gtrigiaxuattralai[$dt])) $gtrigiaxuattralai[$dt] = 0;
						if (empty($gtrigiaxuatkhac[$dt])) $gtrigiaxuatkhac[$dt] = 0;
						if (empty($gsoluongdonhang[$dt])) $gsoluongdonhang[$dt] = 0;
						if (empty($gsoluotkhach[$dt])) $gsoluotkhach[$dt] = 0;
						if (empty($gtongdiemchuan[$dt])) $gtongdiemchuan[$dt] = 0;

						$gsoluongban[$dt]          += $soluongban;
						$gsoluongtralai[$dt]       += $soluongtralai;
						$gdoanhthu[$dt]            += $doanhthu;
						$gdoanhthutralai[$dt]      += $doanhthutralai;
						$gthanhtoan[$dt]           += $thanhtoan;
						$gthanhtoantralai[$dt]     += $thanhtoantralai ;
						$ggiavonban[$dt]           += $giavonban;
						$ggiavontralai[$dt]        += $giavontralai;
						$gtrigiahangkhuyenmai[$dt] += $giatrihangkhuyenmai;
						$gnhapmua[$dt]             += $nhapmua;
						$gnhapnoibo[$dt]           += $nhapnoibo;
						$gnhaptralai[$dt]          += $nhaptralai;
						$gnhapkhac[$dt]            += $nhapkhac;
						$gxuatban[$dt]             += $xuatban;
						$gxuatnoibo[$dt]           += $xuatnoibo;
						$gxuattralai[$dt]          += $xuattramuahang;
						$gxuatkhac[$dt]            += $xuatkhac;
						$gtrigianhapmua[$dt]       += $trigianhapmua;
						$gtrigianhapnoibo[$dt]     += $trigianhapnoibo;
						$gtrigianhaptralai[$dt]    += $trigianhaptra;
						$gtrigianhapkhac[$dt]      += $trigianhapkhac;
						$gtrigiaxuatban[$dt]       += $trigiaxuatban;
						$gtrigiaxuatnoibo[$dt]     += $trigiaxuatnoibo;
						$gtrigiaxuattralai[$dt]    += $trigiaxuattra;
						$gtrigiaxuatkhac[$dt]      += $trigiaxuatkhac;
						$gsoluongdonhang[$dt]      += $soluongdonhang;
						$gsoluotkhach[$dt]         += $soluotkhach[$dtdate];
						if (!empty($diemchuan[$pid][Core_Stat::TYPE_PRODUCTREWARD][$dtdate]))
						{
							$gtongdiemchuan[$dt]         += $diemchuan[$pid][Core_Stat::TYPE_PRODUCTREWARD][$dtdate];
						}
						/////////////////
						$tongsoluongban          += $soluongban;
						$tongsoluongtralai       += $soluongtralai;
						$tongdoanhthu            += $doanhthu;
						$tongdoanhthutralai      += $doanhthutralai;
						$tongthanhtoan           += $thanhtoan;
						$tongthanhtoantralai     += $thanhtoantralai ;
						$tonggiavonban           += $giavonban;
						$tonggiavontralai        += $giavontralai;
						$tongtrigiahangkhuyenmai += $giatrihangkhuyenmai;
						$tongnhapmua             += $nhapmua;
						$tongnhapnoibo           += $nhapnoibo;
						$tongnhaptralai          += $nhaptralai;
						$tongnhapkhac            += $nhapkhac;
						$tongxuatban             += $xuatban;
						$tongxuatnoibo           += $xuatnoibo;
						$tongxuattralai          += $xuattramuahang;
						$tongxuatkhac            += $xuatkhac;
						$tongtrigianhapmua       += $trigianhapmua;
						$tongtrigianhapnoibo     += $trigianhapnoibo;
						$tongtrigianhaptralai    += $trigianhaptra;
						$tongtrigianhapkhac      += $trigianhapkhac;
						$tongtrigiaxuatban       += $trigiaxuatban;
						$tongtrigiaxuatnoibo     += $trigiaxuatnoibo;
						$tongtrigiaxuattralai    += $trigiaxuattra;
						$tongtrigiaxuatkhac      += $trigiaxuatkhac;
						$tongsoluongdonhang      += $soluongdonhang;
						$tongsoluotkhach         += $soluotkhach[$dtdate];
						$tongsodiemchuan         += $gtongdiemchuan[$dt];

						$dt = strtotime('+1 day', $dt);
					}

					$dtbegidate = date('Y/m/d' , $begindate);
					//begindate
					if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtbegidate]))
					{
						$tongtonkhodauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtbegidate];
					}
					//begindate
					if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtbegidate]))
					{
						$tongtrigiatonkhodauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtbegidate];
					}

					if($begindate < $startdate)
					{
						//tinh so luong nhap va xuat dau ky
						$dt = $begindate;
						while ($dt < $startdate)
						{
							$dtdate = date('Y/m/d' , $dt);
							//begindate
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate]))
							{
								$tongsoluongnhapmuadauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
							}
							//begindate
							if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate]))
							{
								$tongtrigianhapmuadauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate];
							}
							//begindate
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate]))
							{
								$tongsoluongxuatbandauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
							}
							//begindate
							if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate]))
							{
								$tongtrigiaxuatbandauky += $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate];
							}

							$dt = strtotime('+1 day', $dt);
						}
					}

					if(count($detailvalues) > 0)
					{
						$dt = $startdate;
						$datalist = array();
						while ($dt < $enddate)
						{
							$dtdate = date('Y/m/d', $dt);
							foreach ($detailvalues as $detail)
							{
								switch ($detail)
								{
									case 'soluongthucban':
										$datalist[$dt]['soluongthucban'] = $gsoluongban[$dt] - $gsoluongtralai[$dt];
										break;

									case 'doanhthuthucte' :
										$datalist[$dt]['doanhthuthucte'] = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
										break;

									case 'thanhtoanthucte' :
										$datalist[$dt]['thanhtoanthucte'] = $gthanhtoan[$dt] - $gthanhtoantralai[$dt];
										break;

									case 'giabanchuavat' :
										//giabanchuavat = doanhthu / soluongthucban
										$gsoluongthucban = $gsoluongban[$dt] - $gsoluongtralai[$dt];
										$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
										$giabanchuavat = (($gsoluongthucban != 0) ? ($gdoanhthuthucte / $gsoluongthucban) : 0);
										//echodebug(.'---'.date('Y-m-d', $dt).'---'.$dt.'---'.$gdoanhthuthucte.'----'.$gsoluongthucban.'---'.$giabanchuavat );
										$datalist[$dt]['giabanchuavat'] = $giabanchuavat;
										break;

									case 'giabancovat' :
										//giabancovat = thanhtoan / soluongthucban
										$gsoluongthucban = $gsoluongban[$dt] - $gsoluongtralai[$dt];
										$gthanhtoanthucte = $gthanhtoan[$dt] - $gthanhtoantralai[$dt];
										$giabancovat = ($gsoluongthucban != 0) ? $gthanhtoanthucte / $gsoluongthucban : 0;
										$datalist[$dt]['giabancovat'] = $giabancovat;
										break;

									case 'giavontrungbinh' :
										//giavontrungbinh = giavon / soluongban
										$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
										$giavontrungbinh = ($gsoluongban[$dt] != 0) ? abs($ggiavon / $gsoluongban[$dt]) : 0;
										$datalist[$dt]['giavontrungbinh'] = $giavontrungbinh;
										break;
									case 'trigiacuoiky' :
										$sltondauky = 0;
										$sldauky = 0;
										//begindate
										if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtdate]))
										{
											$sltondauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$dtdate];
										}
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky;
											if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate]))
											{
												$sldauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VALUE][$dtdate];
											}
											if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate]))
											{
												$sldauky -= $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE][$dtdate];
											}
										}
										$datalist[$dt]['trigiacuoiky'] = $sldauky +  $gtrigianhapmua[$dt] + $gtrigianhapnoibo[$dt] + $gtrigianhaptralai[$dt] + $gtrigianhapkhac[$dt] - $gtrigiaxuatban[$dt] - $gtrigiaxuatnoibo[$dt] - $gtrigiaxuattralai[$dt] - $gtrigiaxuatkhac[$dt];
										unset($sltondauky);
										unset($sldauky);
										break;

									case 'laigop' :
										$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
										$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
										$laigop = $gdoanhthuthucte - $ggiavon;
										$datalist[$dt]['laigop'] = $laigop;
										break;

									case 'giavon' :
										$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
										$datalist[$dt]['giavon'] = $ggiavon;
										break;

									case 'margin' :
										//margin = laigop / doanhthuthucte
										$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
										$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
										$laigop = $gdoanhthuthucte - $ggiavon;
										$margin = ($gdoanhthuthucte != 0) ? round(($laigop * 100 / $gdoanhthuthucte) ,2) : 0;
										$datalist[$dt]['margin'] = $margin;
										break;

									case 'trigiahangkhuyenmai' :
										$datalist[$dt]['trigiahangkhuyenmai'] = $gtrigiahangkhuyenmai[$dt];
										break;

									case 'tralai' :
										$datalist[$dt]['tralai'] = $gsoluongtralai[$dt];
										break;

									case 'doanhthutralai' :
										$datalist[$dt]['doanhthutralai'] = $gdoanhthutralai[$dt];
										break;

									case 'nhapmua' :
										$datalist[$dt]['nhapmua'] = $gnhapmua[$dt];
										break;

									case 'soluotkhach' :
										$datalist[$dt]['soluotkhach'] = $gsoluotkhach[$dt];
										break;

									case 'diemchuan' :
										$datalist[$dt]['diemchuan'] = $gtongdiemchuan[$dt];
										break;

									case 'tonkho' :
										$sltondauky = 0;
										$sldauky = 0;
										//begindate
										if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate]))
										{
											$sltondauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate];
										}
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky;
											if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate]))
											{
												$sldauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
											}
											if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate]))
											{
												$sldauky -= $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
											}
										}
										$datalist[$dt]['tonkho'] = $sldauky +  $gnhapmua[$dt] + $gnhapnoibo[$dt] + $gnhaptralai[$dt] + $gnhapkhac[$dt] - $gxuatban[$dt] - $gxuatnoibo[$dt] - $gxuattralai[$dt] - $gxuatkhac[$dt];
										unset($sltondauky);
										unset($sldauky);
										break;
									case 'giavontrungbinh' :
										$slthucban = $gsoluongban[$dt] - $gsoluongtralai[$dt];
										$tgiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
										$datalist[$dt]['giavontrungbinh'] = ($slthucban != 0) ? abs($tgiavon / $slthucban) : 0;
										unset($slthucban);
										unset($tgiavon);
										break;
									case 'giabantrungbinh' :
										$slthucban = $gsoluongban[$dt] - $gsoluongtralai[$dt];
										$dtthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
										$datalist[$dt]['giabantrungbinh'] = ($slthucban != 0) ? abs($dtthucte / $slthucban) : 0;
										unset($slthucban);
										unset($dtthucte);
										break;
									case 'ngaybanhang' :
										$songay = ceil(($enddate - $startdate) / (24*3600)) + 1;
										$sucban = ($songay > 0) ? ceil($gxuatban[$dt] /  $songay) : 0;
										$sltondauky = 0;
										$sldauky = 0;
										//begindate
										if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate]))
										{
											$sltondauky = $getdatalistalltypes[$pid][Core_Stat::TYPE_STOCK_VOLUME_BEGIN][$dtdate];
										}
										if($startdate == $begindate)
										{
											$sldauky = $sltondauky;
										}
										else
										{
											$sldauky = $sltondauky;
											if (!empty($getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate]))
											{
												$sldauky += $getdatalistalltypesrefund[$pid][Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME][$dtdate];
											}
											if (!empty($getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate]))
											{
												$sldauky -= $getdatalistalltypes[$pid][Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME][$dtdate];
											}
										}
										$slcuoiky = $sldauky +  $gnhapmua[$dt] + $gnhapnoibo[$dt] + $gnhaptralai[$dt] + $gnhapkhac[$dt] - $gxuatban[$dt] - $gxuatnoibo[$dt] - $gxuattralai[$dt] - $gxuatkhac[$dt];
										$datalist[$dt]['ngaybanhang'] = ($sucban > 0) ? ceil($slcuoiky / $sucban) : 0;
										break;
								}
							}
							$dt = strtotime('+1 day', $dt);
						}
						$data[$storeid][$pid] = $datalist;
					}
				}
			}
		}
		else //caculate by store
		{
			$datalist = array();
			$categoryid = (int)$dataidlist['category'];
			$soluonglonnhat = 0;

			if(isset($dataidlist['groupstore']))
			{
				$storeidlist = Core_Store::getGroupStoreFromCache($storeid);
				if ($storeid > 0 && (empty($storeidlist) || !in_array($storeid, $storeidlist))) $storeidlist[] = $storeid;

				$datalist = array();


				$gsoluongban          = array();
				$gsoluongtralai       = array();
				$gdoanhthu            = array();
				$gdoanhthutralai      = array();
				$gthanhtoan           = array();
				$gthanhtoantralai     = array();
				$ggiavonban           = array();
				$ggiavontralai        = array();
				$gtrigiahangkhuyenmai = array();
				$gtonkhodauky         = array();
				$gsoluongnhapmuadauky = array();
				$gsoluongxuatbandauky = array();
				$gnhapmua             = array();
				$gnhapnoibo           = array();
				$gnhaptralai          = array();
				$gnhapkhac            = array();
				$gxuatban             = array();
				$gxuatnoibo           = array();
				$gxuattralai          = array();
				$gxuatkhac            = array();
				$gtrigiatonkhodauky   = array();
				$gtrigianhapmua       = array();
				$gtrigianhapnoibo     = array();
				$gtrigianhaptralai    = array();
				$gtrigianhapkhac      = array();
				$gtrigiaxuatban       = array();
				$gtrigiaxuatnoibo     = array();
				$gtrigiaxuattralai    = array();
				$gtrigiaxuatkhac      = array();
				$gtrigianhapmuadauky  = array();
				$gtrigiaxuatbandauky  = array();
				$gsoluongdonhang      = array();
				$gsoluotkhach         = array();
				$gtongsodiemchuan         = array();

				$ishavetongdiemchuam = false;

				foreach ($storeidlist as $sid)
				{
					$soluonglonnhat = 0;

					$conditionvol = array('category' => $categoryid , 'outputstore' => $sid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);
					$conditionvolreturn = 	array('category' => $categoryid , 'inputstore' => $sid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);

					//so luong thuc ban
					$soluongban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, $conditionvol, $startdate, $enddate );

					//so luong tra lai tru vao thuc te
					$soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $conditionvolreturn, $startdate, $enddate );

					//doanhthu (chua co vat)
					$doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $conditionvol, $startdate, $enddate );

					//doanh thu tra lai duoc tru vao doanh thu
					$doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditionvolreturn, $startdate, $enddate );//	$conditionvol

					//doanh thu tra lai duoc tru vao doanh thu
					//$doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditionvol, $startdate, $enddate );

					//thanh toan (co vat)
					$thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $conditionvol, $startdate, $enddate );

					//thanh toan tra lai
					$thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $conditionvolreturn, $startdate, $enddate );//$conditionvol, $startdate, $enddate );

					//gia von ban
					$giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $conditionvol, $startdate, $enddate );

					//gia von tra lai
					$giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $conditionvolreturn, $startdate, $enddate );

					//gia von hang khuyen mai
					$giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $conditionvol, $startdate , $enddate );

					//ton kho dau ky
					$tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $conditionvol, $begindate, $enddate ); // tinh tu ngay dau thang cua san pham

					//so luong nhap mua dau ky
					$soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $conditionvolreturn, $begindate, $enddate );

					//tri gia nhap mua dau ky
					$trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $conditionvolreturn, $begindate, $enddate );

					//so luong xuat ban dau ky
					$soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $conditionvol, $begindate, $enddate );

					//tri gia xuat ban dau ky
					$trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $conditionvol, $begindate, $enddate );

					//nhap mua
					$nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $conditionvolreturn, $startdate, $enddate );

					//nhap noi bo
					$nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $conditionvolreturn, $startdate, $enddate );

					//nhap tra lai
					$nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $conditionvolreturn, $startdate, $enddate );

					//nhap khac
					$nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $conditionvolreturn, $startdate, $enddate );

					//so luong xuat ban
					$xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $conditionvol, $startdate, $enddate );

					//so luong xuat noi bo
					$xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $conditionvol, $startdate, $enddate );

					//so luong xuat tra mua hang
					$xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $conditionvol, $startdate, $enddate );

					//so luong xuat khac
					$xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $conditionvol, $startdate, $enddate );

					//tri gia dau ky
					$trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $conditionvol, $begindate, $enddate );

					//tri gia nhap mua
					$trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $conditionvolreturn, $startdate, $enddate );

					//tri gia nhap noi bo
					$trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $conditionvolreturn, $startdate, $enddate );

					//tri gia nhap tra
					$trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $conditionvolreturn, $startdate, $enddate );

					//tri gia nhap khac
					$trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $conditionvolreturn, $startdate, $enddate );

					//tri gia xuat ban
					$trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $conditionvol, $startdate, $enddate );

					//tri gia xuat noi bo
					$trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $conditionvol, $startdate, $enddate );

					//tri gia xuat tra
					$trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $conditionvol, $startdate, $enddate );

					//tri gia xuat khac
					$trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $conditionvol, $startdate, $enddate );

					//so luong don hang
					$soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $conditionvol, $startdate, $enddate );

					//so luot khach vao sieu thi
					$soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $startdate, $enddate );

					//lay diem thuong
					if ($ishavetongdiemchuam == false)
					{
						$diemchuan = Core_Stat::getData(Core_Stat::TYPE_PRODUCTREWARD, array('category' => $categoryid), $startdate, $enddate );
					}

					$dt = $startdate;

					while ($dt < $enddate)
					{
						$dtdate = date('Y/m/d' , $dt);
						$xdtdate = date('d/m' , $dt);

						$dtdate = date('Y/m/d' , $dt);
						$xdtdate = date('d/m' , $dt);

						//soluongthucban = soluongban - soluongtralai
						$soluongthucban = $soluongban[$dtdate] - $soluongtralai[$dtdate];

						//doanhthuthucthe = doanhthu - doanhthutralai
						$doanhthuthucte = $doanhthu[$dtdate] - $doanhthutralai[$dtdate];

						//thanhtoanthuc te = thanhtoan - thanhtoantralai
						$thanhtoanthucte = $thanhtoan[$dtdate] - $thanhtoantralai[$dtdate];

						//giavon = giavonban - giavontralai
						$giavon = $giavonban[$dtdate] - $giavontralai[$dtdate];

						//laigop = doanhthuthucte - giavon
						$laigop = $doanhthuthucte - $giavon;

						if($soluonglonnhat <= $soluongthucban)
						{
							$ngaycaodiem[$storeid] = date('d/m/Y' , $dt);//[$categoryid]
							$soluonglonnhat = $soluongthucban;
						}
						if (empty($gsoluongban[$dt])) $gsoluongban[$dt] = 0;
						if (empty($gsoluongtralai[$dt])) $gsoluongtralai[$dt] = 0;
						if (empty($gdoanhthu[$dt])) $gdoanhthu[$dt] = 0;
						if (empty($gdoanhthutralai[$dt])) $gdoanhthutralai[$dt] = 0;
						if (empty($gthanhtoan[$dt])) $gthanhtoan[$dt] = 0;
						if (empty($gthanhtoantralai[$dt])) $gthanhtoantralai[$dt] = 0;
						if (empty($ggiavonban[$dt])) $ggiavonban[$dt] = 0;
						if (empty($ggiavontralai[$dt])) $ggiavontralai[$dt] = 0;
						if (empty($gtrigiahangkhuyenmai[$dt])) $gtrigiahangkhuyenmai[$dt] = 0;
						if (empty($gnhapmua[$dt])) $gnhapmua[$dt] = 0;
						if (empty($gnhapnoibo[$dt])) $gnhapnoibo[$dt] = 0;
						if (empty($gnhaptralai[$dt])) $gnhaptralai[$dt] = 0;
						if (empty($gnhapkhac[$dt])) $gnhapkhac[$dt] = 0;
						if (empty($gxuatban[$dt])) $gxuatban[$dt] = 0;
						if (empty($gxuatnoibo[$dt])) $gxuatnoibo[$dt] = 0;
						if (empty($gxuattralai[$dt])) $gxuattralai[$dt] = 0;
						if (empty($gxuatkhac[$dt])) $gxuatkhac[$dt] = 0;
						if (empty($gtrigianhapmua[$dt])) $gtrigianhapmua[$dt] = 0;
						if (empty($gtrigianhapnoibo[$dt])) $gtrigianhapnoibo[$dt] = 0;
						if (empty($gtrigianhaptralai[$dt])) $gtrigianhaptralai[$dt] = 0;
						if (empty($gtrigianhapkhac[$dt])) $gtrigianhapkhac[$dt] = 0;
						if (empty($gtrigiaxuatban[$dt])) $gtrigiaxuatban[$dt] = 0;
						if (empty($gtrigiaxuatnoibo[$dt])) $gtrigiaxuatnoibo[$dt] = 0;
						if (empty($gtrigiaxuattralai[$dt])) $gtrigiaxuattralai[$dt] = 0;
						if (empty($gtrigiaxuatkhac[$dt])) $gtrigiaxuatkhac[$dt] = 0;
						if (empty($gsoluongdonhang[$dt])) $gsoluongdonhang[$dt] = 0;
						if (empty($gsoluotkhach[$dt])) $gsoluotkhach[$dt] = 0;
						if (empty($gtongsodiemchuan[$dt])) $gtongsodiemchuan[$dt] = 0;

						$gsoluongban[$dt]          += $soluongban[$dtdate];
						$gsoluongtralai[$dt]       += $soluongtralai[$dtdate];
						$gdoanhthu[$dt]            += $doanhthu[$dtdate];
						$gdoanhthutralai[$dt]      += $doanhthutralai[$dtdate];
						$gthanhtoan[$dt]           += $thanhtoan[$dtdate];
						$gthanhtoantralai[$dt]     += $thanhtoantralai[$dtdate] ;
						$ggiavonban[$dt]           += $giavonban[$dtdate];
						$ggiavontralai[$dt]        += $giavontralai[$dtdate];
						$gtrigiahangkhuyenmai[$dt] += $giatrihangkhuyenmai[$dtdate];
						$gnhapmua[$dt]             += $nhapmua[$dtdate];
						$gnhapnoibo[$dt]           += $nhapnoibo[$dtdate];
						$gnhaptralai[$dt]          += $nhaptralai[$dtdate];
						$gnhapkhac[$dt]            += $nhapkhac[$dtdate];
						$gxuatban[$dt]             += $xuatban[$dtdate];
						$gxuatnoibo[$dt]           += $xuatnoibo[$dtdate];
						$gxuattralai[$dt]          += $xuattramuahang[$dtdate];
						$gxuatkhac[$dt]            += $xuatkhac[$dtdate];
						$gtrigianhapmua[$dt]       += $trigianhapmua[$dtdate];
						$gtrigianhapnoibo[$dt]     += $trigianhapnoibo[$dtdate];
						$gtrigianhaptralai[$dt]    += $trigianhaptra[$dtdate];
						$gtrigianhapkhac[$dt]      += $trigianhapkhac[$dtdate];
						$gtrigiaxuatban[$dt]       += $trigiaxuatban[$dtdate];
						$gtrigiaxuatnoibo[$dt]     += $trigiaxuatnoibo[$dtdate];
						$gtrigiaxuattralai[$dt]    += $trigiaxuattra[$dtdate];
						$gtrigiaxuatkhac[$dt]      += $trigiaxuatkhac[$dtdate];
						$gsoluongdonhang[$dt]      += $soluongdonhang[$dtdate];
						$gsoluotkhach[$dt]         += $soluotkhach[$dtdate];
						if ($ishavetongdiemchuam == false) $gtongsodiemchuan[$dt]         += $diemchuan[$dtdate];

						/////////////////
						$tongsoluongban          += $soluongban[$dtdate];
						$tongsoluongtralai       += $soluongtralai[$dtdate];
						$tongdoanhthu            += $doanhthu[$dtdate];
						$tongdoanhthutralai      += $doanhthutralai[$dtdate];
						$tongthanhtoan           += $thanhtoan[$dtdate];
						$tongthanhtoantralai     += $thanhtoantralai[$dtdate] ;
						$tonggiavonban           += $giavonban[$dtdate];
						$tonggiavontralai        += $giavontralai[$dtdate];
						$tongtrigiahangkhuyenmai += $giatrihangkhuyenmai[$dtdate];
						$tongnhapmua             += $nhapmua[$dtdate];
						$tongnhapnoibo           += $nhapnoibo[$dtdate];
						$tongnhaptralai          += $nhaptralai[$dtdate];
						$tongnhapkhac            += $nhapkhac[$dtdate];
						$tongxuatban             += $xuatban[$dtdate];
						$tongxuatnoibo           += $xuatnoibo[$dtdate];
						$tongxuattralai          += $xuattramuahang[$dtdate];
						$tongxuatkhac            += $xuatkhac[$dtdate];
						$tongtrigianhapmua       += $trigianhapmua[$dtdate];
						$tongtrigianhapnoibo     += $trigianhapnoibo[$dtdate];
						$tongtrigianhaptralai    += $trigianhaptra[$dtdate];
						$tongtrigianhapkhac      += $trigianhapkhac[$dtdate];
						$tongtrigiaxuatban       += $trigiaxuatban[$dtdate];
						$tongtrigiaxuatnoibo     += $trigiaxuatnoibo[$dtdate];
						$tongtrigiaxuattralai    += $trigiaxuattra[$dtdate];
						$tongtrigiaxuatkhac      += $trigiaxuatkhac[$dtdate];
						$tongsoluongdonhang      += $soluongdonhang[$dtdate];
						$tongsoluotkhach         += $soluotkhach[$dtdate];
						if ($ishavetongdiemchuam == false) $tongsodiemchuan         += $diemchuan[$dtdate];
						$ishavetongdiemchuam = true;
						$dt = strtotime('+1 day', $dt);
						//$counter++;
					}

					//tinh ton kho dau thang
					$dtbegidate = date('Y/m/d' , $begindate);
					$tongtonkhodauky += $tonkhodauky[$dtbegidate];
					$tongtrigiatonkhodauky += $trigiatonkhodauky[$dtbegidate];

					if($begindate < $startdate)
					{
						//tinh so luong nhap va xuat dau ky
						$dt = $begindate;
						while ($dt < $startdate)
						{
							$dtdate = date('Y/m/d' , $dt);
							$tongsoluongnhapmuadauky += $soluongnhapmuadauky[$dtdate];
							$tongsoluongxuatbandauky += $soluongxuatbandauky[$dtdate];
							$tongtrigianhapmuadauky += $trigianhapmuadauky[$dtdate];
							$tongtrigiaxuatbandauky += $trigiaxuatbandauky[$dtdate];
							$dt = strtotime('+1 day', $dt);
						}
					}
				}

				if(count($detailvalues) > 0)
				{
					$dt = $startdate;
					while ($dt < $enddate)
					{
						foreach ($detailvalues as $detail)
						{
							switch ($detail)
							{
								case 'soluongthucban':
									$datalist[$dt]['soluongthucban'] = $gsoluongban[$dt] - $gsoluongtralai[$dt];
									break;

								case 'doanhthuthucte' :
									$datalist[$dt]['doanhthuthucte'] = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
									break;

								case 'thanhtoanthucte' :
									$datalist[$dt]['thanhtoanthucte'] = $gthanhtoan[$dt] - $gthanhtoantralai[$dt];
									break;

								case 'giabanchuavat' :
									//giabanchuavat = doanhthu / soluongthucban
									$gsoluongthucban = $gsoluongban[$dt] - $gsoluongtralai[$dt];
									$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
									$giabanchuavat = ($gsoluongthucban != 0) ? $gdoanhthuthucte / $gsoluongthucban : 0;
									$datalist[$dt]['giabanchuavat'] = $giabanchuavat;
									break;

								case 'giabancovat' :
									//giabancovat = thanhtoan / soluongthucban
									$gsoluongthucban = $gsoluongban[$dt] - $gsoluongtralai[$dt];
									$gthanhtoanthucte = $gthanhtoan[$dt] - $gthanhtoantralai[$dt];
									$giabancovat = ($gsoluongthucban != 0) ? $gthanhtoanthucte / $gsoluongthucban : 0;
									$datalist[$dt]['giabancovat'] = $giabancovat;
									break;

								case 'giavontrungbinh' :
									//giavontrungbinh = giavon / soluongban
									$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
									$giavontrungbinh = ($gsoluongban[$dt] != 0) ? abs($ggiavon / $gsoluongban[$dt]) : 0;
									$datalist[$dt]['giavontrungbinh'] = $giavontrungbinh;
									break;

								case 'nhapmua' :
									$datalist[$dt]['nhapmua'] = $gnhapmua[$dt];
									break;

								case 'laigop' :
									$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
									$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
									$laigop = $gdoanhthuthucte - $ggiavon;
									$datalist[$dt]['laigop'] = $laigop;
									break;

								case 'giavon' :
									$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
									$datalist[$dt]['giavon'] = $ggiavon;
									break;

								case 'margin' :
									//margin = laigop / doanhthuthucte
									$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
									$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
									$laigop = $gdoanhthuthucte - $ggiavon;
									$margin = ($gdoanhthuthucte != 0) ? round(($laigop * 100 / $gdoanhthuthucte) ,2) : 0;
									$datalist[$dt]['margin'] = $margin;
									break;

								case 'trigiahangkhuyenmai' :
									$datalist[$dt]['trigiahangkhuyenmai'] = $gtrigiahangkhuyenmai[$dt];
									break;

								case 'tralai' :
									$datalist[$dt]['tralai'] = $gsoluongtralai[$dt];
									break;

								case 'doanhthutralai' :
									$datalist[$dt]['doanhthutralai'] = $gdoanhthutralai[$dt];
									break;

								case 'soluotkhach' :
									$datalist[$dt]['soluotkhach'] = $gsoluotkhach[$dt];
									break;

								case 'diemchuan' :
									$datalist[$dt]['diemchuan'] = $gtongsodiemchuan[$dt];
									break;
							}
						}
						$dt = strtotime('+1 day', $dt);
					}
					$data[$storeid][$categoryid] = $datalist;
				}
			}//end of if
			else
			{
				$datalist = array();
				$soluonglonnhat = 0;

				$conditionvol = array('category' => $categoryid , 'outputstore' => $storeid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);
				$conditionvolreturn = 	array('category' => $categoryid , 'inputstore' => $storeid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter);

				//so luong thuc ban
				$soluongban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, $conditionvol, $startdate, $enddate );

				//so luong tra lai tru vao thuc te
				$soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $conditionvolreturn, $startdate, $enddate );

				//doanhthu (chua co vat)
				$doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $conditionvol, $startdate, $enddate );

				//doanh thu tra lai duoc tru vao doanh thu
				$doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditionvolreturn, $startdate, $enddate );//$conditionvol, $startdate, $enddate );

				//doanh thu tra lai duoc tru vao doanh thu
				//$doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditionvol, $startdate, $enddate );

				//thanh toan (co vat)
				$thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $conditionvol, $startdate, $enddate );

				//thanh toan tra lai
				$thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $conditionvolreturn, $startdate, $enddate );//$conditionvol, $startdate, $enddate );

				//gia von ban
				$giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $conditionvol, $startdate, $enddate );

				//gia von tra lai
				$giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $conditionvolreturn, $startdate, $enddate );

				//gia von hang khuyen mai
				$giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $conditionvol, $startdate , $enddate );

				//ton kho dau ky
				$tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $conditionvol, $begindate, $enddate ); // tinh tu ngay dau thang cua san pham

				//so luong nhap mua dau ky
				$soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $conditionvolreturn, $begindate, $enddate );

				//tri gia nhap mua dau ky
				$trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $conditionvolreturn, $begindate, $enddate );

				//so luong xuat ban dau ky
				$soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $conditionvol, $begindate, $enddate );

				//tri gia xuat ban dau ky
				$trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $conditionvol, $begindate, $enddate );

				//nhap mua
				$nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $conditionvolreturn, $startdate, $enddate );

				//nhap noi bo
				$nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $conditionvolreturn, $startdate, $enddate );

				//nhap tra lai
				$nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $conditionvolreturn, $startdate, $enddate );

				//nhap khac
				$nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $conditionvolreturn, $startdate, $enddate );

				//so luong xuat ban
				$xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $conditionvol, $startdate, $enddate );

				//so luong xuat noi bo
				$xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $conditionvol, $startdate, $enddate );

				//so luong xuat tra mua hang
				$xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $conditionvol, $startdate, $enddate );

				//so luong xuat khac
				$xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $conditionvol, $startdate, $enddate );

				//tri gia dau ky
				$trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $conditionvol, $begindate, $enddate );

				//tri gia nhap mua
				$trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $conditionvolreturn, $startdate, $enddate );

				//tri gia nhap noi bo
				$trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $conditionvolreturn, $startdate, $enddate );

				//tri gia nhap tra
				$trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $conditionvolreturn, $startdate, $enddate );

				//tri gia nhap khac
				$trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $conditionvolreturn, $startdate, $enddate );

				//tri gia xuat ban
				$trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $conditionvol, $startdate, $enddate );

				//tri gia xuat noi bo
				$trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $conditionvol, $startdate, $enddate );

				//tri gia xuat tra
				$trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $conditionvol, $startdate, $enddate );

				//tri gia xuat khac
				$trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $conditionvol, $startdate, $enddate );

				//so luong don hang
				$soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $conditionvol, $startdate, $enddate );

				//so luot khach vao sieu thi
				$soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $storeid), $startdate, $enddate );

				//lay diem thuong
				$diemchuan = Core_Stat::getData(Core_Stat::TYPE_PRODUCTREWARD, array('product' => $categoryid), $startdate, $enddate );

				$dt = $startdate;

				while ($dt < $enddate)
				{
					$dtdate = date('Y/m/d' , $dt);
					$xdtdate = date('d/m' , $dt);

					//soluongthucban = soluongban - soluongtralai
					$soluongthucban = $soluongban[$dtdate] - $soluongtralai[$dtdate];

					//doanhthuthucthe = doanhthu - doanhthutralai
					$doanhthuthucte = $doanhthu[$dtdate] - $doanhthutralai[$dtdate];

					//thanhtoanthuc te = thanhtoan - thanhtoantralai
					$thanhtoanthucte = $thanhtoan[$dtdate] - $thanhtoantralai[$dtdate];

					//giavon = giavonban - giavontralai
					$giavon = $giavonban[$dtdate] - $giavontralai[$dtdate];

					//laigop = doanhthuthucte - giavon
					$laigop = $doanhthuthucte - $giavon;

					if($soluonglonnhat <= $soluongthucban)
					{
						$ngaycaodiem[$storeid] = date('d/m/Y' , $dt);//[$categoryid]
						$soluonglonnhat = $soluongthucban;
					}

					$tongsoluongban          += $soluongban[$dtdate];
					$tongsoluongtralai       += $soluongtralai[$dtdate];
					$tongdoanhthu            += $doanhthu[$dtdate];
					$tongdoanhthutralai      += $doanhthutralai[$dtdate];
					$tongthanhtoan           += $thanhtoan[$dtdate];
					$tongthanhtoantralai     += $thanhtoantralai[$dtdate] ;
					$tonggiavonban           += $giavonban[$dtdate];
					$tonggiavontralai        += $giavontralai[$dtdate];
					$tongtrigiahangkhuyenmai += $giatrihangkhuyenmai[$dtdate];
					$tongnhapmua             += $nhapmua[$dtdate];
					$tongnhapnoibo           += $nhapnoibo[$dtdate];
					$tongnhaptralai          += $nhaptralai[$dtdate];
					$tongnhapkhac            += $nhapkhac[$dtdate];
					$tongxuatban             += $xuatban[$dtdate];
					$tongxuatnoibo           += $xuatnoibo[$dtdate];
					$tongxuattralai          += $xuattramuahang[$dtdate];
					$tongxuatkhac            += $xuatkhac[$dtdate];
					$tongtrigianhapmua       += $trigianhapmua[$dtdate];
					$tongtrigianhapnoibo     += $trigianhapnoibo[$dtdate];
					$tongtrigianhaptralai    += $trigianhaptra[$dtdate];
					$tongtrigianhapkhac      += $trigianhapkhac[$dtdate];
					$tongtrigiaxuatban       += $trigiaxuatban[$dtdate];
					$tongtrigiaxuatnoibo     += $trigiaxuatnoibo[$dtdate];
					$tongtrigiaxuattralai    += $trigiaxuattra[$dtdate];
					$tongtrigiaxuatkhac      += $trigiaxuatkhac[$dtdate];
					$tongsoluongdonhang      += $soluongdonhang[$dtdate];
					$tongsoluotkhach         += $soluotkhach[$dtdate];
					$tongsodiemchuan         += $diemchuan[$dtdate];

					if(count($detailvalues) > 0)
					{
						foreach ($detailvalues as $detail)
						{
							switch ($detail)
							{
								case 'soluongthucban':
									$datalist[$dt]['soluongthucban'] = $soluongthucban;
									break;

								case 'doanhthuthucte' :
									$datalist[$dt]['doanhthuthucte'] = $doanhthuthucte;
									break;

								case 'thanhtoanthucte' :
									$datalist[$dt]['thanhtoanthucte'] = $thanhtoanthucte;
									break;

								case 'giabanchuavat' :
									//giabanchuavat = doanhthu / soluongthucban
									$giabanchuavat = ($soluongthucban != 0) ? $doanhthuthucte / $soluongthucban : 0;
									$datalist[$dt]['giabanchuavat'] = $giabanchuavat;
									break;

								case 'giabancovat' :
									//giabancovat = thanhtoan / soluongthucban
									$giabancovat = ($soluongthucban != 0) ? $thanhtoanthucte / $soluongthucban : 0;
									$datalist[$dt]['giabancovat'] = $giabancovat;
									break;

								case 'giavontrungbinh' :
									//giavontrungbinh = giavon / soluongban
									$giavontrungbinh = ($soluongban[$dtdate] != 0) ? abs($giavon / $soluongban[$dtdate]) : 0;
									$datalist[$dt]['giavontrungbinh'] = $giavontrungbinh;
									break;

								case 'nhapmua' :
									$datalist[$dt]['nhapmua'] = $tongnhapmua;
									break;

								case 'laigop' :
									/*$gdoanhthuthucte = $gdoanhthu[$dt] - $gdoanhthutralai[$dt];
									$ggiavon = $ggiavonban[$dt] - $ggiavontralai[$dt];
									$laigop = $gdoanhthuthucte - $ggiavon;*/
									$datalist[$dt]['laigop'] = $laigop;
									break;

								case 'giavon' :
									$datalist[$dt]['giavon'] = $giavon;
									break;

								case 'margin' :
									//margin = laigop / doanhthuthucte
									$margin = ($doanhthuthucte != 0) ? round(($laigop * 100 / $doanhthuthucte) ,2) : 0;
									$datalist[$dt]['margin'] = $margin;
									break;

								case 'trigiahangkhuyenmai' :
									$datalist[$dt]['trigiahangkhuyenmai'] = $giatrihangkhuyenmai;
									break;

								case 'tralai' :
									$datalist[$dt]['tralai'] = $soluongtralai[$dtdate];
									break;

								case 'doanhthutralai' :
									$datalist[$dt]['doanhthutralai'] = $gdoanhthutralai[$dtdate];
									break;

								case 'soluotkhach' :
									$datalist[$dt]['soluotkhach'] = $soluotkhach[$dtdate];
									break;

								case 'diemchuan' :
									$datalist[$dt]['diemchuan'] = $diemchuan[$dtdate];
									break;
							}
						}
					}

					$dt = strtotime('+1 day', $dt);
					//$counter++;
				}

				//tinh ton kho dau thang
				$dtbegidate = date('Y/m/d' , $begindate);
				$tongtonkhodauky += $tonkhodauky[$dtbegidate];
				$tongtrigiatonkhodauky += $trigiatonkhodauky[$dtbegidate];

				if($begindate < $startdate)
				{
					//tinh so luong nhap va xuat dau ky
					$dt = $begindate;
					while ($dt < $startdate)
					{
						$dtdate = date('Y/m/d' , $dt);
						$tongsoluongnhapmuadauky += $soluongnhapmuadauky[$dtdate];
						$tongsoluongxuatbandauky += $soluongxuatbandauky[$dtdate];
						$tongtrigianhapmuadauky += $trigianhapmuadauky[$dtdate];
						$tongtrigiaxuatbandauky += $trigiaxuatbandauky[$dtdate];
						$dt = strtotime('+1 day', $dt);
					}
				}
				if(count($detailvalues) > 0)
				{
					$data[$storeid][$categoryid] = $datalist;
				}
			}//end of else
		}


		$result['data'] = $data;
		$datamaster = array();
		foreach ($mastervalues as $mastervalue)
		{
			switch ($mastervalue)
			{
				case 'ssoluongthucban':
					$tongsoluongthucban = $tongsoluongban - $tongsoluongtralai;
					$datamaster['ssoluongthucban'] = $tongsoluongthucban;
					break;

				case 'stralai':
					$datamaster['stralai'] = $tongsoluongtralai;
					break;

				case 'sdoanhthutralai':
					$datamaster['sdoanhthutralai'] = $tongdoanhthutralai;
					break;

				case 'sgiavon' :
					$tonggiavon = $tonggiavonban - $tonggiavontralai;
					$datamaster['sgiavon'] = $tonggiavon;

				case 'sdoanhthu':
					$tongdoanhthuthucte = $tongdoanhthu - $tongdoanhthutralai;
					$datamaster['sdoanhthu'] = $tongdoanhthuthucte;
					break;

				case 'sthanhtoan':
					$tongthanhtoanthucte = $tongthanhtoan - $tongthanhtoantralai;
					$datamaster['sthanhtoan'] = $tongthanhtoanthucte;
					break;

				case 'slaigop':
					$tongdoanhthuthucte = $tongdoanhthu - $tongdoanhthutralai;
					$tonggiavon = $tonggiavonban - $tonggiavontralai;
					$tonglaigop = $tongdoanhthuthucte - $tonggiavon;
					$datamaster['slaigop'] = $tonglaigop;
					break;

				case 'smargin':
					$tongdoanhthuthucte = $tongdoanhthu - $tongdoanhthutralai;
					$tonggiavon = $tonggiavonban - $tonggiavontralai;
					$tonglaigop = $tongdoanhthuthucte - $tonggiavon;

					$margin = ($tongdoanhthuthucte != 0) ? round(($tonglaigop * 100 / $tongdoanhthuthucte) ,2) : 0;
					$datamaster['smargin'] = $margin;
					break;

				case 'sgiabantrungbinh':
					$tongsoluongthucban = $tongsoluongban - $tongsoluongtralai;
					$tongdoanhthuthucte = $tongdoanhthu - $tongdoanhthutralai;
					$giabantrungbinh = ($tongsoluongthucban != 0) ? abs($tongdoanhthuthucte / $tongsoluongthucban) : 0;
					$datamaster['sgiabantrungbinh'] = $giabantrungbinh;
					break;

				case 'sgiavontrungbinh':
					$tongsoluongthucban = $tongsoluongban - $tongsoluongtralai;
					$tonggiavon = $tonggiavonban - $tonggiavontralai;
					$sgiavontrungbinh = ($tongsoluongthucban != 0) ? abs($tonggiavon / $tongsoluongthucban) : 0;
					$datamaster['sgiavontrungbinh'] = $sgiavontrungbinh;
					break;

				case 'sgiabantrungbinhcovat':
					$tongsoluongthucban = $tongsoluongban - $tongsoluongtralai;
					$tongthanhtoanthucte = $tongthanhtoan - $tongthanhtoantralai;
					$giabantrungbinhcovat = ($tongsoluongthucban != 0) ? abs($tongthanhtoanthucte / $tongsoluongthucban) : 0;
					$datamaster['sgiabantrungbinhcovat'] = $giabantrungbinhcovat;
					break;

				case 'stonkho':

					if($startdate == $begindate)
					{
						$tongsoluongdauky = $tongtonkhodauky;
						//echo '<br />Go here';
					}
					else
					{
						$tongsoluongdauky = $tongtonkhodauky + $tongsoluongnhapmuadauky - $tongsoluongxuatbandauky;
					}
					$stonkho = $tongsoluongdauky + $tongnhapmua + $tongnhapnoibo + $tongnhaptralai + $tongnhapkhac - $tongxuatban - $tongxuattralai - $tongxuatnoibo - $tongxuatkhac;
					$datamaster['stonkho'] = $stonkho;
					break;

				case 'snhaptrongky':
					$snhaptrongky = $tongnhapmua + $tongnhapnoibo + $tongnhaptralai + $tongnhapkhac;
					$datamaster['snhaptrongky'] = $snhaptrongky;
					break;

				case 'sxuattrongky':
					$sxuattrongky = $tongxuatban + $tongxuatnoibo + $tongxuattralai + $tongxuatkhac;
					$datamaster['sxuattrongky'] = $sxuattrongky;
					break;

				case 'sngaycaodiem':
					$datamaster['sngaycaodiem'] = $ngaycaodiem[$storeid];//[$productid]
					break;

				case 'soluongdauky':
					if($startdate == $begindate)
					{
						$tongsoluongdauky = $tongtonkhodauky;
					}
					else
					{
						$tongsoluongdauky = $tongtonkhodauky + $tongsoluongnhapmuadauky - $tongsoluongxuatbandauky;
					}
					$datamaster['soluongdauky'] = $tongsoluongdauky;
					break;

				case 'trigiadauky':
					if($startdate == $begindate)
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky;
					}
					else
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky + $tongtrigianhapmuadauky - $tongtrigiaxuatbandauky;
					}
					$datamaster['trigiadauky'] = $tongtrigiadauky;
					break;

				case 'giavondauky':
					if($startdate == $begindate)
					{
						$tongsoluongdauky = $tongtonkhodauky;
					}
					else
					{
						$tongsoluongdauky = $tongtonkhodauky + $tongsoluongnhapmuadauky - $tongsoluongxuatbandauky;
					}
					if($startdate == $begindate)
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky;
					}
					else
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky + $tongtrigianhapmuadauky - $tongtrigiaxuatbandauky;
					}
					$giavondauky = ($tongsoluongdauky != 0) ? ($tongtrigiadauky / $tongsoluongdauky) : 0;
					$datamaster['giavondauky'] = $giavondauky;
					break;

				case 'trigiacuoiky':
					if($startdate == $begindate)
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky;
					}
					else
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky + $tongtrigianhapmuadauky - $tongtrigiaxuatbandauky;
					}
					$tongtrigiacuoiky = $tongtrigiadauky + $tongtrigianhapmua + $tongtrigianhapnoibo + $tongtrigianhaptralai + $tongtrigianhapkhac - $tongtrigiaxuatban - $tongtrigiaxuatnoibo - $tongtrigiaxuattralai - $tongtrigiaxuatkhac;
					if (!empty($_GET['test']))
					{
						echo '<p>-----------------------------------------------------------------</p>';
						echodebug('$tongtrigiadauky: '.$tongtrigiatonkhodauky);
						echodebug('$tongtrigianhapmuadauky: '.$tongtrigianhapmuadauky);
						echodebug('$tongtrigiaxuatbandauky: '.$tongtrigiaxuatbandauky);
						echodebug('$tongtrigianhapmua: '.$tongtrigianhapmua);
						echodebug('$tongtrigianhapnoibo: '.$tongtrigianhapnoibo);
						echodebug('$tongtrigianhaptralai: '.$tongtrigianhaptralai);
						echodebug('$tongtrigianhapkhac: '.$tongtrigianhapkhac);
						echodebug('$tongtrigiaxuatban: '.$tongtrigiaxuatban);
						echodebug('$tongtrigiaxuattralai: '.$tongtrigiaxuattralai);
						echodebug('$tongtrigiaxuatkhac: '.$tongtrigiaxuatkhac);
					}
					$datamaster['trigiacuoiky'] = $tongtrigiacuoiky;
					break;

				case 'giavoncuoiky':
					if($startdate == $begindate)
					{
						$tongsoluongdauky = $tongtonkhodauky;
					}
					else
					{
						$tongsoluongdauky = $tongtonkhodauky + $tongsoluongnhapmuadauky - $tongsoluongxuatbandauky;
					}
					$stonkho = $tongsoluongdauky + $tongnhapmua + $tongnhapnoibo + $tongnhaptralai + $tongnhapkhac - $tongxuatban - $tongxuattralai - $tongxuatnoibo - $tongxuatkhac;
					if($startdate == $begindate)
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky;
					}
					else
					{
						$tongtrigiadauky = $tongtrigiatonkhodauky + $tongtrigianhapmuadauky - $tongtrigiaxuatbandauky;
					}
					$tongtrigiacuoiky = $tongtrigiadauky + $tongtrigianhapmua + $tongtrigianhapnoibo + $tongtrigianhaptralai + $tongtrigianhapkhac - $tongtrigiaxuatban - $tongtrigiaxuatnoibo - $tongtrigiaxuattralai - $tongtrigiaxuatkhac;
					$giavoncuoiky = ($stonkho != 0) ? ($tongtrigiacuoiky / $stonkho) : 0;
					$datamaster['giavoncuoiky'] = $giavoncuoiky;
					break;

				case 'nhapmua':
					$datamaster['nhapmua'] = $tongnhapmua;
					break;

				case 'trigianhapmua':
					$datamaster['trigianhapmua'] = $tongtrigianhapmua;
					break;

				case 'nhapnoibo' :
					$datamaster['nhapnoibo'] = $tongnhapnoibo;
					break;

				case 'trigianhapnoibo':
					$datamaster['trigianhapnoibo'] = $tongtrigianhapnoibo;
					break;


				case 'nhaptralai' :
					$datamaster['nhaptralai'] = $tongnhaptralai;
					break;

				case 'trigianhaptra':
					$datamaster['trigianhaptra'] = $tongtrigianhaptralai;
					break;

				case 'nhapkhac':
					$datamaster['nhapkhac'] = $tongnhapkhac;
					break;

				case 'trigianhapkhac':
					$datamaster['trigianhapkhac'] = $tongtrigianhapkhac;
					break;

				case 'xuatban' :
					$datamaster['xuatban'] = $tongxuatban;
					break;

				case 'trigiaxuatban':
					$datamaster['trigiaxuatban'] = $tongtrigiaxuatban;
					break;

				case 'xuatnoibo':
					$datamaster['xuatnoibo'] = $tongxuatnoibo;
					break;

				case 'trigiaxuatnoibo':
					$datamaster['trigiaxuatnoibo'] = $tongtrigiaxuatnoibo;
					break;

				case 'xuattramuahang':
					$datamaster['xuattramuahang'] = $tongxuattralai;
					break;

				case 'trigiaxuattra':
					$datamaster['trigiaxuattra'] = $tongtrigiaxuattralai;
					break;

				case 'xuatkhac':
					$datamaster['xuatkhac'] = $tongxuatkhac;
					break;

				case 'trigiaxuatkhac':
					$datamaster['trigiaxuatkhac'] = $tongtrigiaxuatkhac;
					break;

				case 'sucban':
					$songay = ($enddate - $startdate) / (24*3600) + 1; //+ 1 la lay luon ngay enddate
					$sucban = ($songay > 0) ? ceil($tongxuatban /  $songay) : 0;
					$datamaster['sucban'] = $sucban;
					break;

				case 'ngaybanhang':
					$songay = ceil(($enddate - $startdate) / (24*3600)) + 1;
					$sucban = ($songay > 0) ? ceil($tongxuatban /  $songay) : 0;
					if($startdate == $begindate)
					{
						$tongsoluongdauky = $tongtonkhodauky;
					}
					else
					{
						$tongsoluongdauky = $tongtonkhodauky + $tongsoluongnhapmuadauky - $tongsoluongxuatbandauky;
					}
					$cuoiky = $tongsoluongdauky + $tongnhapmua + $tongnhapnoibo + $tongnhaptralai + $tongnhapkhac - $tongxuatban - $tongxuatnoibo - $tongxuattralai - $tongxuatkhac;
					$ngaybanhang = ($sucban > 0) ? ceil($cuoiky / $sucban) : 0;
					$datamaster['ngaybanhang'] = $ngaybanhang;
					break;

				case 'giatritrungbinhitem':
					$tongdoanhthuthucte = $tongdoanhthu - $tongdoanhthutralai;
					$tongsoluongthucban = $tongsoluongban - $tongsoluongtralai;
					$giatritrungbinhitem = ($tongsoluongthucban) ? abs($tongdoanhthuthucte / $tongsoluongthucban) : 0;
					$datamaster['giatritrungbinhitem'] = $giatritrungbinhitem;
					break;

				case 'laiitem':
					$tongdoanhthuthucte = $tongdoanhthu - $tongdoanhthutralai;
					$tonggiavon = $tonggiavonban - $tonggiavontralai;
					$tonglaigop = $tongdoanhthuthucte - $tonggiavon;
					$tongsoluongthucban = $tongsoluongban - $tongsoluongtralai;
					$laiitem = ($tongsoluongthucban != 0) ? $tonglaigop / $tongsoluongthucban : 0;
					$datamaster['laiitem'] = $laiitem;
					break;

				case 'sgiatrihangtralai':
					$datamaster['sgiatrihangtralai'] = $tongdoanhthutralai;
					break;

				case 'strigianhap' :
					$strigianhap = $tongtrigianhapmua + $tongtrigianhapnoibo + $tongtrigianhaptralai + $tongtrigianhapkhac;
					$datamaster['strigianhap'] = $strigianhap;
					break;

				case 'tongsoluongdonhang' :
					$datamaster['tongsoluongdonhang'] = $tongsoluongdonhang;
					break;

				case 'tongsoluotkhach' :
					$datamaster['tongsoluotkhach'] = $tongsoluotkhach;
					break;

				case 'tongsodiemchuan' :
					$datamaster['tongsodiemchuan'] = $tongsodiemchuan;
					break;

				case 'conversionrate' :
					$conversionrate = ($tongsoluotkhach > 0) ? round(($tongsoluongdonhang * 100 / $tongsoluotkhach) , 2) : 0;
					$datamaster['conversionrate'] = $conversionrate;
					break;
			}
		}
		$result['datamaster'] = $datamaster;
		return $result;
	}

	public static function calsoluotkhach($storeid = 0, $startdate, $enddate)
	{
		$startdate = strtotime(date('Y-m-d', $startdate));
		$enddate = strtotime(date('Y-m-d', $enddate));

		$dt = $startdate;
		$tongsoluotkhach = 0;
		while ($dt < $enddate)
		{
			$dtdate = date('Y/m/d' , $dt);

			if ($storeid > 0)
			{
				$storeidlist = Core_Store::getGroupStoreFromCache($storeid);
				if (empty($storeidlist) || !in_array($storeid, $storeidlist)) $storeidlist[] = $storeid;

				foreach ($storeidlist as $sid)
				{
					$soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $startdate, $enddate );
					$tongsoluotkhach         += $soluotkhach[$dtdate];
				}
			}
			else
			{
				$soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array(), $startdate, $enddate );
				$tongsoluotkhach         += $soluotkhach[$dtdate];
			}
			$dt = strtotime('+1 day', $dt);
		}
		return $tongsoluotkhach;
	}
}



