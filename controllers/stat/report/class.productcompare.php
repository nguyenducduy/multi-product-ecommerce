<?php
Class Controller_Stat_Report_ProductCompare Extends Controller_Stat_Report
{
	public function indexAction()
	{		
		$chartby = (string)$_GET['by'] != '' ? (string)$_GET['by'] : 'revenue';
		set_time_limit(0);

		$startdate = (isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));
		$relenddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		if(isset($_GET['enddate']))
		{
			if($startdate == $relenddate)
			{
				$enddatepath = explode('/', $_GET['enddate']);
				$enddatestring = ($enddatepath[0] +1) . '/' . $enddatepath[1] . '/' . $enddatepath[2];			
				$enddate = Helper::strtotimedmy($enddatestring);
			}
			else
			{
				$enddate = $relenddate;
			}
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

		$products = array();
		$fid = (int)$_GET['id'];
		$fid2 = (int)$_GET['fid2'];

		//kiem tra danh muc san pham
		$myProduct = new Core_Product($fid , true);
		$products[] = $myProduct;
		$myProduct2 = new Core_Product($fid2 , true);
		if( ($myProduct->id != $myProduct2->id) && ($myProduct2->pcid == $myProduct->pcid) )
		{
			$products[] = $myProduct2;
		}
			

		//summary info
		$strangthai            = array();
		$svaitro               = array();
		$snhom                 = array();
		$sranking              = array();
		$ssoluongthucban       = array();
		$stralai               = array();
		$sdoanhthu             = array();
		$sthanhtoan            = array();
		$slaigop               = array();
		$smargin               = array();
		$sdiemchuan            = array();
		$stongdiemthuong       = array();
		$sgiabantrungbinh      = array();
		$sgiabantrungbinhcovat = array();
		$sgiavontrungbinh      = array();
		$stonkho               = array();
		$stocdobantrungbinh    = array();
		$sngaytonkho           = array();
		$snhaptrongky          = array();
		$sngaycaodiem          = array();
		$ssoluongdauky         = array();
		$sgiavon               = array();
		
		$dataList              = array();
		$refineData = array();
		foreach ($products as $product) 
		{
			$dataidlist = array('product' => array($product->id),
								'store' => array($storeid),
								);			
			if($storeid > 0)
			{
				$dataidlist['groupstore'] = 1;
			}	
			$detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'thanhtoanthucte' , 'giabanchuavat' , 'giabancovat' , 'giavontrungbinh' , 'laigop' , 'margin' , 'giavon' , 'tralai');
			$mastervalues = array('ssoluongthucban' , 'stralai' , 'sdoanhthu' , 'sthanhtoan' , 'slaigop' , 'smargin' , 'sgiabantrungbinh' , 'sgiavontrungbinh' , 'sgiabantrungbinhcovat' , 'stonkho' , 'snhaptrongky' , 'sngaycaodiem');

			$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);			
			$datarowList = $data['data'][$storeid][$product->id];

			if(count($datarowList) > 0)
			{				
				foreach($datarowList as $date => $value)
				{
					$xdtdate = date('d/m' , $date);					
					switch ($chartby)
					{
						case 'revenue':
							$refineData[$product->id][$date] = $value['doanhthuthucte'];
							break;

						case 'volume':
							$refineData[$product->id][$date] = $value['soluongthucban'];
							break;

						case 'profit':
							$refineData[$product->id][$date] = $value['laigop'];
							break;
					}					
					$dataList[$date][$product->id] = array('soluong' => $value['soluongthucban'],
															'doanhthu' => $value['doanhthuthucte'],
															'thanhtoan' => $value['thanhtoanthucte'],
															'giabanchuavat' => $value['giabanchuavat'],
															'giabancovat' => $value['giabancovat'],
															'giavontrungbinh' => $value['giavontrungbinh'],
															'laigop' => $value['laigop'],
															'margin' => $value['margin'],
															'tralai' => $value['tralai'],										
														);
				}
			}				
			
			//summary info
			$strangthai[$product->id] = 'N/A';
			$svaitro[$product->id] = 'N/A';
			$ssoluongthucban[$product->id] = $data['datamaster']['ssoluongthucban'];
			$stralai[$product->id] = $data['datamaster']['stralai'];
			$sdoanhthu[$product->id] = $data['datamaster']['sdoanhthu'];
			$sthanhtoan[$product->id] = $data['datamaster']['sthanhtoan'];
			$slaigop[$product->id] = $data['datamaster']['slaigop'];
			$smargin[$product->id] = $data['datamaster']['smargin'];
			$sdiemchuan[$product->id] = 0;
			$stongdiemthuong[$product->id] = 0;
			$sgiabantrungbinh[$product->id] = $data['datamaster']['sgiabantrungbinh'];
			$sgiabantrungbinhcovat[$product->id] = $data['datamaster']['sgiabantrungbinhcovat'];
			$sgiavontrungbinh[$product->id] = $data['datamaster']['sgiavontrungbinh'];
			$stonkho[$product->id] = $data['datamaster']['stonkho'];
			$stocdobantrungbinh[$product->id] = 0;
			$ssucban[$product->id] = 0;
			$sngaytonkho[$product->id] = '';
			$snhaptrongky[$product->id] = $data['datamaster']['snhaptrongky'];
			$sngaycaodiem[$product->id] = $data['datamaster']['sngaycaodiem'];					

			//get group and ranking
			// $rankinggroups = self::getproductsrankingandgroup($product->pcid, $startdate , $enddate);				
			// $snhom[$product->id] = $rankinggroups['group'][$product->id];
			// $sranking[$product->id] = $rankinggroups['ranking'][$product->id];	
		}
		
		//chart
		$chartData = array();		
		foreach ($products as $product)
		{
			$chartData[$product->name] = $refineData[$product->id];
		}
		//echodebug($chartData,true);
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
		$fullproductcategory = Core_Productcategory::getFullparentcategoryInfoFromRedisCahe($myProductcategory->id);
		$fullproductcategory[$myProductcategory->id] = array('name' => $myProductcategory->name);

		$stepdate = ceil(($relenddate - $startdate) / (24 * 3600)) - 1;
		if($stepdate > 7)
			$stepdate = ceil($stepdate / 7) - 1;
		/////////////////////////////////////
		$this->registry->smarty->assign(array(  'products' => $products,
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
												'stocdobantrungbinh' => $stocdobantrungbinh,
												'sngaytonkho' => $sngaytonkho,
												'snhaptrongky' => $snhaptrongky,
												'sngaycaodiem' => $sngaycaodiem,																										
												'tab' => $tab,		
												'numberproduct' => count($products),
												'fid2' => $fid2,
												'id' => $fid,
												'fullproductcategory' => $fullproductcategory,
												'myProduct' => $myProduct,
												'stepdate' => $stepdate,
                                        	));
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
	}

	/**
	 * [getproductsranking description]
	 * @param  array  $productidlist [description]
	 * @return [type]                [description]
	 */
	public static function getproductsrankingandgroup($pcid , $startdate , $enddate)
	{
		//lay danh sach san pham cung danh muc
		$productidlist = Core_Productcategory::getProductlistFromCache($pcid);		

		$datalist = array();
		$rankinglist = array();
		$grouplist = array();

		$sumvolume = 0;
		$sumrevenue = 0;
		$sumprofit = 0;
		
		if(count($productidlist) > 0)
		{
			$totalvoume = array();
			$totalrevenue = array();
			$totalprofit = array();

			//get volume , revenue , profit
			foreach ($productidlist as $productid => $vendorid)
			{				
				$dataidlist = array('product' => array($productid),
								'store' => array(0),
								);			

				$detailvalues = array();
				$mastervalues = array('ssoluongthucban' ,  'sdoanhthu' , 'slaigop');

				$data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , $enddate , $begindate);				

				$totalvoume[$productid] = $data['datamaster']['ssoluongthucban'];
				$totalrevenue[$productid] = $data['datamaster']['sdoanhthu'];
				$totalprofit[$productid] = $data['datamaster']['slaigop'];

				//summary info
				$sumvolume += $data['datamaster']['ssoluongthucban'];
				$sumrevenue += $data['datamaster']['sdoanhthu'];
				$sumprofit += $data['datamaster']['slaigop'];
			}			

			//sort data
			if(count($totalvoume) > 0)
			{
				asort($totalvoume);
				array_reverse($totalvoume);
			}				

			if(count($totalrevenue) > 0)
			{
				asort($totalrevenue);
				array_reverse($totalrevenue);
			}				

			if(count($totalprofit) > 0)
			{
				asort($totalprofit);
				array_reverse($totalprofit);
			}	

			//sort group data of product
			$v80numbervolume = ceil($sumvolume * 80 /100); // 80% of volume
			$v80numberrevenue = ceil($sumrevenue * 80 / 100); // 80% of revenue
			$v80numberprofit = ceil($sumprofit * 80 /100); //80% of profit

			$v80conditionvolume = 0;
			$v80conditionrevenue = 0;
			$v80conditionprofit = 0;

			//ranking data
			foreach ($productidlist as $productid) 
			{
				$rankinglist[$productid] = '';

				//volume
				$j = 0;
				foreach ($totalvoume as $pid => $volume) 
				{
					if($pid == $productid)
					{
						$rankinglist[$productid] .= 'V' . ($j+1);						
					}
					$j++;
				}

				//revenue
				$j = 0;
				foreach ($totalrevenue as $pid => $revenue) 
				{
					if($pid == $productid)
					{
						$rankinglist[$productid] .= ' , R' . ($j+1);						
					}
					$j++;
				}
				

				//profit
				$j = 0;
				foreach ($totalprofit as $pid => $profit) 
				{
					if($pid == $productid)
					{
						$rankinglist[$productid] .= ' , P' . ($j+1);						
					}
					$j++;
				}

				//group of product
				$v80conditionvolume += $totalvoume[$productid];
				if($v80conditionvolume <= $v80numbervolume)
				{
					$grouplist[$productid] .= 'V80';
				}
				else
				{
					$grouplist[$productid] .= 'V20';
				}

				$v80conditionrevenue += $totalrevenue[$productid];
				if($v80conditionrevenue <= $v80numbervolume)
				{
					$grouplist[$productid] .= ',R80';
				}
				else
				{
					$grouplist[$productid] .= ',R20';
				}

				$v80conditionprofit += $totalprofit[$productid];
				if($v80conditionprofit <= $v80numbervolume)
				{
					$grouplist[$productid] .= ',P80';
				}
				else
				{
					$grouplist[$productid] .= ',P20';
				}								
			}			
		}

		$datalist['ranking'] = $rankinglist;
		$datalist['group'] = $grouplist;

		return $datalist;
	}	

}
