<?php

Class Controller_Stat_Product Extends Controller_Stat_Base
{
	var $colproductdetail;
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->colproductdetail = array('ngay',
										'soluong',
										'doanhthu',
										'giabantb',
										'giavontb',
										'laigop',
										'margin',
										'tralai',
										);
	}
	public function indexAction()
	{

	}

	/**
	 * Show info in product detail for employee to process
	 */
	public function infoAction()
	{
		$type = (string)$_GET['type'];
		$id = (int)$_GET['id'];
		$sheet = isset($_GET['fsheet']) ?  (int)$_GET['fsheet'] : 0;

		//kiem tra phan quyen
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$fvid = (string)(!empty($_GET['fvid'])?$_GET['fvid']:(!empty($_GET['fvidf'])?$_GET['fvidf']: 0));
			$this->infoProductCategory($id, $fvid , $sheet);
			if($this->registry->me->id > 0)
			{
				$roleusers = Core_RoleUser::getRoleUsers(array(
														'fuid' => $this->registry->me->id,
														'ftype' => Core_RoleUser::TYPE_PRODUCT,
														'fstatus' => Core_RoleUser::STATUS_ENABLE,) , 'id' , 'ASC');
				$fullsubcategory = Core_Productcategory::getFullSubCategory($id);
				$checker = false;
				if(count($roleusers) > 0)
				{
					foreach( $roleusers as $roleuser )
					{
						if(count($fullsubcategory) > 0)
						{
							foreach($fullsubcategory as $subcategory)
							{
								if($roleuser->objectid == $subcategory)
								{
									$checker = true;
									break;
								}
							}
						}
						else
						{
							if($roleuser->objectid == $id)
							{
								$checker = true;
								break;
							}
						}
					}
				}

			}
			else
			{
				header('location: ' . $this->registry['conf']['root_url']);
			}
		}
		else
		{
			$checker = true;
		}

		if($checker)
		{
			if($type == 'productdetail')
				$this->infoProductDetail($id);
			elseif($type == 'productcategory')
			{
				$fvid = (string)(!empty($_GET['fvid'])?$_GET['fvid']: (!empty($_GET['fvidf'])?$_GET['fvidf']: 0));
				$this->infoProductCategory($id, $fvid , $sheet);
			}
			else
				echo '';
		}
		else
		{
			header('location: ' . $this->registry['conf']['root_url']);
		}

	}

	/**
	 * Get Info in product detail
	 */
	private function infoProductDetail($id)
	{
		set_time_limit(0);
		$myProduct = new Core_Product($id);
		$myProduct->sellprice = Helper::formatPrice($myProduct->sellprice);

		$startdate = (isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):strtotime('-1 month'));
		$enddate = (isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());
		$storeid = (int)(isset($_GET['fsid'])?($_GET['fsid']):0);

		$conditionvol = array('kind' => 2, 'product' => $product->id);
		$conditionrev = array('kind' => 1, 'product' => $product->id);
		if($storeid > 0)
		{
			$conditionvol['outputstore'] = $storeid;
			$conditionrev['outputstore'] = $storeid;
		}

		$salevol = (int)Core_Stat::getData(Core_Stat::TYPE_SALE, $conditionvol, false, $startdate, $enddate );//so luong ban
		$listRevenue = Core_Stat::getData(Core_Stat::TYPE_SALE, $conditionrev, false, $startdate, $enddate );//danh thu

		$dt = $startdate;

		$sstatusproduct = 'Bán Online';
		$sskuroleproduct = (!empty($myProduct->skurole)?$myProduct->skurole:'Chủ lực');
		$snhom = 'V80, R20, P80';
		$sranking = 'V1, R3, P1';
		$sslthucban = 0;
		$stralai = 0;
		$sdoanhthu = 0;
		$slaigop = 0;
		$sdiemchuan = 0;
		$stongdiemthuong = $myProduct->productaward;//tong diem thuong khong co history
		$sgiabantb = 0;
		$sgiavontb = 0;
		$stonkho = $myProduct->instock;
		$stocdoban = 0;
		$sngaytonkho = 0;
		$snhaptrongky = 0;
		$sngaycaodiem = 0;

		$soluongbanlonnhat = 0;

		$outputdata = '[';
		$cnt = 1;
		while($dt <= $enddate)
		{
			$quantity = (!empty($salevol[$dt])?$salevol[$dt]:0);
			$revenue = (!empty($listRevenue[$dt])?$listRevenue[$dt]:0);
			$laigop = ($revenue - ($myProduct->unitprice*$quantity));
			$giabantrungbinh = ($quantity > 0 ?($revenue/$quantity): 0);
			$margin = ($revenue > 0?($laigop/$revenue):0);
			$outputdata .= '["'.
								date('d/m/Y', $dt).'", "'.
								$quantity.'", "'.
								$revenue.'", "'.
								$giabantrungbinh.'","'.
								$myProduct->unitprice.'","'.
								$laigop.'","'.
								$margin.'","'.
								'0"';
			$sslthucban += $quantity;
			$sdoanhthu += $revenue;
			$slaigop += $laigop;
			$sgiabantb += $giabantrungbinh;
			$sgiavontb += $myProduct->unitprice;

			//tim ngay cao diem
			if($soluongbanlonnhat < $quantity)
			{
				$soluongbanlonnhat = $quantity;
				$sngaycaodiem = $dt;
			}

			$dt = strtotime('+1 day', $dt);
			$cnt++;
		}

		//tinh tb
		$sgiabantb = round($sgiabantb/$cnt, 0);
		$sgiavontb = round($sgiavontb/$cnt, 0);
		$stocdoban = round($sslthucban/$cnt, 0);
		if($stocdoban > 0)$sngaytonkho = round($stonkho/$stocdoban, 0);

		$outputdata  = substr($outputdata , 0 , -1);
		$outputdata .= ']';
		/*
		$outputdata = '[';
$outputdata .= '["'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'.addslashes($product->name).'","'.$segmentname.'","'.$segmentprice.'","'.(!empty($product->skurole)?$product->skurole:'NA').'",'.(!empty($product->unitprice)?$product->unitprice:'0').','.$product->sellprice.', "<a href=\''.$product->getProductPath().'\' target=\'_blank\'>VIEW</a> <a href=\''.$this->registry->conf['rooturl'].'cms/product/edit/id/'.$product->id.'/'.'\' target=\'_blank\'>EDIT</a>"],';
$outputdata  = substr($outputdata , 0 , -1);
		$outputdata .= ']';
		*/

		/*$chartData = array();

		if(isset($_GET['view']))
		{
			$stardatestring = explode('/', $_GET['startdate']);
			$startdate = implode('-', array_reverse($stardatestring));

			$enddatestring = explode('/', $_GET['enddate']);
			$enddate = implode('-', array_reverse($enddatestring));
		}
		else
		{
			$enddate = date('Y/m/d' , strtotime('-1 days'));
			$startdate = date('Y/m/d' , strtotime('-60 days'));
		}


		$saleData = Core_Stat::getData(Core_Stat::TYPE_SALE, array('kind' => 1, 'product' => $id), false , strtotime($startdate) , strtotime($enddate));


		$refineData = array();
		foreach($saleData as $date => $value)
		{
			$refineData[strtotime($date)] = ($value != '') ? $value : 0;
		}


		$chartData['Sale'] = $refineData;

		$startdate = date('d/m/Y' , strtotime($startdate));
		$enddate = date('d/m/Y' , strtotime($enddate));
		*/
		$liststores = Core_Store::getStores(array('fstatus' => Core_Store::STATUS_ENABLE), 'displayorder', 'ASC');

		$this->registry->smarty->assign(array(    'myProduct'     => $myProduct,
													'chartData' => $chartData,
													'liststores' => $liststores,
													'chartType' => 'bar',
													'chartTitle' => 'Thống kê doanh số sản phẩm ' . $myProduct->name,
													'storeid' => $storeid,
													'startdate' => date('d/m/Y', $startdate),
													'enddate' => date('d/m/Y', $enddate),
													'schema' => $this->loadschemaproductdetail(),
													'datahandson' => $outputdata,
													'sstatusproduct' => $sstatusproduct,
													'sskuroleproduct' => $sskuroleproduct,
													'snhom' => $snhom,
													'sranking' => $sranking,
													'sslthucban' => $sslthucban,
													'stralai' => $stralai,
													'sdoanhthu' => $sdoanhthu,
													'slaigop' => $slaigop,
													'sdiemchuan' => $sdiemchuan,
													'stongdiemthuong' => $stongdiemthuong,
													'sgiabantb' => $sgiabantb,
													'sgiavontb' => $sgiavontb,
													'stonkho' => $stonkho,
													'stocdoban' => $stocdoban,
													'sngaytonkho' => $sngaytonkho,
													'snhaptrongky' => $snhaptrongky,
													'sngaycaodiem' => date('d/m/Y',$sngaycaodiem),
                                                ));
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'infoproductdetail.tpl');
	}

	private function loadschemaproductdetail()
	{
		$schema = array();
		$schema['columns'] = '[
	                {
	                    type: {renderer: readonlyRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: readonlyRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: readonlyRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: readonlyRender},
	                    readOnly: true
	                },
	                {
	                    type: 	{ renderer : function (instance, TD, row, col, prop, value, cellProperties) {
								    Handsontable.TextCell.renderer.apply(this, arguments);
									$(TD).addClass("cellformular");
									$(TD).css("text-align" , "right");
								    var a,b;
								    a = instance.getDataAtCell(row, 3);
								    b = instance.getDataAtCell(row, 4);

								    TD.innerHTML = numeral(b/a).format("0,0");
								}},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: readonlyRender},
	                    readOnly: true
	                },
	                {
	                    type: 	{ renderer : function (instance, TD, row, col, prop, value, cellProperties) {
								    Handsontable.TextCell.renderer.apply(this, arguments);
									$(TD).addClass("cellformular");
									$(TD).css("text-align" , "right");
								    var a,b,c;
								    a = instance.getDataAtCell(row, 3);
								    b = instance.getDataAtCell(row, 4);
								    b = instance.getDataAtCell(row, 6);

								    TD.innerHTML = numeral((b-(a*c))).format("0,0");
								}},
						readOnly: true
	                },
	                {
	                    type: 	{ renderer : function (instance, TD, row, col, prop, value, cellProperties) {
								    Handsontable.TextCell.renderer.apply(this, arguments);
									$(TD).addClass("cellformular");
									$(TD).css("text-align" , "right");
								    var a,b,c;
								    a = instance.getDataAtCell(row, 3);
								    b = instance.getDataAtCell(row, 4);
								    b = instance.getDataAtCell(row, 6);

								    TD.innerHTML = numeral((b-(a*c))/b).format("0,0");
								}},
						readOnly: true
	                },
	                {
	                    type: {renderer: readonlyRender},
	                    readOnly: true
	                },
	            ]';
	    $schema['colHeaders'] = '["Ngày", "Số lượng", "Doanh thu", "Giá bán trung bình", "Giá vốn trung bình", "Lãi gộp", "Margin", "Trả lại"]';
	    $schema['colWidths'] = '[100 ,  100 , 100 , 110 , 110 , 110 , 100 ,65]';

	    return $schema;
	}

	/**
	 * get Info in product category
	 */
	private function infoProductCategory($id, $fvid = 0, $sheet = 0)
	{
		$fullPathCat = array();
		$fsubpcid = (string)Helper::plaintext(isset($_GET['fsubpcid'])?$_GET['fsubpcid']:'');
		$fpriceseg = (string)Helper::plaintext(isset($_GET['fpriceseg'])?$_GET['fpriceseg']:'');
		$fstartdate = (string)Helper::plaintext(isset($_GET['fstart'])?$_GET['fstart']:date('d/m/Y', strtotime('-1 month')));
		$fenddate = (string)Helper::plaintext(isset($_GET['fend'])?$_GET['fend']:date('d/m/Y'));
		//$fvid = (string)Helper::plaintext(isset($_GET['fvid'])?$_GET['fvid']:$fvid1);
		$arrCondition = array();
		$arrCondition['fisonsitestatus'] = 1;
		$newchildcategory = array();
		$listsubcategory = array();
		//subcate
		$newsubpcids = array();
		if(!empty($fsubpcid))
		{
			$fsubpcidarr = explode(',', $fsubpcid);
			foreach($fsubpcidarr as $subpc)
			{
				$subpc = (int)$subpc;
				if($subpc > 0)
				{
					$newsubpcids[] = $subpc;
				}
			}
			if(count($newsubpcids) > 0 ) {
				$newchildcategory = $newsubpcids;
				$arrCondition['fpcidarrin'] = $newsubpcids;
			}
		}
		else
		{
			$fullPathCat = Core_Productcategory::getFullSubCategory($id);

			if(empty($fullPathCat))
			{
				$arrCondition['fpcid'] = $id;
				$newchildcategory[] = $id;
			}
			else {
				$arrCondition['fpcidarrin'] = $fullPathCat;
				$newchildcategory[] = $fullPathCat;
				$listsubcategory = Core_Productcategory::getProductcategorys(array('fidarr' => $fullPathCat),'','');
			}
		}

		//vendor
		if($fvid !='' )
		{
			$fvid = explode(',', $fvid);
			$newfvid = array();
			foreach($fvid as $vid)
			{
				$vid = (int)$vid;
				if($vid > 0)
				{
					$newfvid[] = $vid;
				}
			}
			if(count($newfvid) > 0 ) $arrCondition['fvidarr'] = $newfvid;
		}
		set_time_limit(0);
		$havepricesegment = array();
		if(!empty($fpriceseg))
		{
			$listpricesegslug = explode(',', $fpriceseg);
			if(!empty($listpricesegslug))
			{
				foreach($listpricesegslug as $slugprice)
				{
					if(!empty($slugprice)){
						/*$explodeslug = explode(';',$slugprice,2);
						if(count($explodeslug)==2){
							$havepricesegment[$explodeslug[0]] = $explodeslug[1];
						}*/
						$havepricesegment[] = $slugprice;
					}
				}
			}
		}
		else $havepricesegment = null;
		if(!empty($havepricesegment))
		{
			$listarray = Core_RelProductAttribute::getProductIdByFilter(array('fvalue' => $havepricesegment, 'fpcid' => $id , 'fstat' => 1), 'pid' , 'ASC');
			if(!empty($listarray)){
				$arrCondition['fidarr'] = $listarray;
			}
		}

		$listproduct = Core_Product::getProducts($arrCondition, '', '');
		$listslugpricesegment = array();
		switch ($sheet) {
			case 0:
				$outputdata = $this->loaddatasheet0($listproduct, $listslugpricesegment);
				break;

			case 2 :
				$outputdata = $this->loaddatasheet2($listproduct, Helper::strtotimedmy($fstartdate), Helper::strtotimedmy($fenddate));
				break;
			case 3 :
				$outputdata = $this->loaddatasheet3($listproduct);
				break;
			case 5 :
				$outputdata = $this->loaddatasheet5($listproduct);
		}
		//get vendor list

		if(count($newsubpcids) > 0)
		{
			$vendorlist = Core_Product::getVendorFromCategories($newsubpcids);
		}
		elseif(count($fullPathCat) == 0)
		{
			$vendorlist = Core_Product::getVendorFromCategories(array($id));
		}
		else
		{
			$vendorlist = Core_Product::getVendorFromCategories($fullPathCat);
		}

		$schema = $this->getDataSchema($sheet);

		$linkshareurl = $this->registry['conf']['rooturl'] . 'stat/product/info?fsheet=' . $sheet . '&type=productcategory' . '&id='.$id;
		$excelurl = $this->registry['conf']['rooturl'] . 'stat/product/exportexcel?fsheet=' . $sheet . '&type=productcategory' . '&id='.$id;

		if($fvid) {
			$linkshareurl .= '&fvid=' . urlencode(implode(',', $fvid));
			$excelurl .= '&fvid=' . urlencode(implode(',', $fvid));
		}
		if($fpriceseg) {
			$linkshareurl .= '&fpriceseg=' . urlencode($fpriceseg);
			$excelurl .= '&fpriceseg=' . urlencode($fpriceseg);
		}

		if(!empty($fstartdate) && !empty($fenddate)) {
			$linkshareurl .= '&fstart=' . urlencode($fstartdate) . '&fend=' . urlencode($fenddate);
			$excelurl .= '&fstart=' . urlencode($fstartdate) . '&fend=' . urlencode($fenddate);
		}

		$this->registry->smarty->assign(array(  'productLists'     => ($listproduct),
                                                'outputdataproduct'     => $outputdata,
                                                'fpcid'     => $id,
												'vendorlist' => $vendorlist,
												'categorylist' => $listsubcategory,
												'listslugpricesegment' => $listslugpricesegment,
												'schema' => $schema,
												'newchildcategory' => $newchildcategory,
												'sheet' => $sheet,
												'isajax' => '0',//((int)$_GET['isajax'] > 0 ? 1 : 0),
												'newfvid' => $newfvid,
												'fromdate' => $fstartdate,
												'enddate' => $fenddate,
												'linkshareurl' => $linkshareurl,
												'excelurl' => $excelurl,
												'fvid' => (!empty($_GET['fvidf'])?$_GET['fvidf']:''),
												'first' => (!empty($_GET['first'])?$_GET['first']:'0'),
                                                ));

		/*if((int)$_GET['isajax'] > 0) {
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'infoproductcategory.tpl');
		}
		else{*/
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'infoproductcategory.tpl');
			$this->registry->smarty->assign(array('contents' => $contents));
			$this->registry->smarty->display('_controller/site/index_popup.tpl');
		//}
	}

	private function loaddatasheet0($listproduct, &$listslugpricesegment)
	{
		$outputdata = '[';
		if(!empty($listproduct))
		{
			foreach($listproduct as $product)
			{
				$category = new Core_Productcategory($product->pcid, true);
				$maincate = '';
				if($category->parent == 0)
				{
					$maincate = $category->name;
				}
				else{
					$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);//Core_Product::getFullCategory($product->id);//new Core_Productcategory($category->parent, true);
					if(!empty($parentcategory[0])){
						$maincate = $parentcategory[0]['pc_name'];
					}
				}
				$product->subcate = $category->name;
				$myvendor = new Core_Vendor($product->vid, true);
				$product->brand = $myvendor->name;

				$segmentname = '';
				$segmentprice = '';

				$listpricesegment = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $product->pcid, 'fpaid' => 0),'','',1);
				if(!empty($listpricesegment))
				{
					foreach($listpricesegment as $priceseg)
					{
						$listrowseg = $priceseg->getDataRow();
						if(!empty($listrowseg))
						{
							foreach($listrowseg as $rowseg)
							{
								if(!empty($rowseg))
								{
									$exploderow = explode('##', $rowseg);//ten##slug##type(20)##fron#to
									$listslugpricesegment[$exploderow[1]] = $exploderow[0];
									if(empty($segmentname) && empty($segmentprice))
									{
										if($exploderow[4] <= 0) {
                                			if($product->sellprice >= $exploderow[3])
                                			{
												$segmentname = $exploderow[0];
												$segmentprice = 'từ '.Helper::formatPrice($exploderow[3]);
                                			}
		                                }
		                                elseif($exploderow[3] <= 0) {
                                			if($product->sellprice <= $exploderow[4])
                                			{
												$segmentname = $exploderow[0];
												$segmentprice = 'dưới '.Helper::formatPrice($exploderow[4]);
                                			}
		                                }
		                                else {
											if($product->sellprice >= $exploderow[3] && $product->sellprice < $exploderow[4])
                                			{
												$segmentname = $exploderow[0];
												$segmentprice = Helper::formatPrice($exploderow[3]). ' - '.Helper::formatPrice($exploderow[4]);
                                			}
		                                }
									}
								}
							}
						}
					}
				}

				/*$outputdata .= json_encode(array(
												//'id' => $product->id,
												'year' => date('Y'), //tạm thời lấy ngày hệ thống sau này sẽ truy vấn database
												'month' => date('m'),
												'cate' => $product->cate,
												'subcate' => $subcate,
												'code' => trim($product->barcode),
												'skuname' => $product->name,
												'segmentname' => $segmentname,
												'pricesegment' => $segmentprice,
												'skurole' => (!empty($product->skurole)?$product->skurole:'NA'),
												'costprice' => (!empty($product->costprice)?$product->costprice:'0'),
												'saleprice' => $product->sellprice,
												)).',';*/
				$outputdata .= '["'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'.addslashes($product->name).'","'.$segmentname.'","'.$segmentprice.'","'.(!empty($product->skurole)?$product->skurole:'NA').'",'.(!empty($product->unitprice)?$product->unitprice:'0').','.$product->sellprice.', "<a href=\''.$product->getProductPath().'\' target=\'_blank\'>VIEW</a> <a href=\''.$this->registry->conf['rooturl'].'cms/product/edit/id/'.$product->id.'/'.'\' target=\'_blank\'>EDIT</a>"],';
			}
		}
		$outputdata  = substr($outputdata , 0 , -1);
		$outputdata .= ']';
		return $outputdata;
	}



	private function loaddatasheet2($listproduct, $startdate = '', $enddate = ''){
		$outputdata = '[';
		if(!empty($listproduct))
		{
			foreach($listproduct as $product)
			{
				$category = new Core_Productcategory($product->pcid, true);
				$maincate = '';
				if($category->parent == 0)
				{
					$maincate = $category->name;
				}
				else{
					$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
					if(!empty($parentcategory[0])){
						$maincate = $parentcategory[0]['pc_name'];
					}
				}
				$product->subcate = $category->name;
				$myvendor = new Core_Vendor($product->vid, true);
				$product->brand = $myvendor->name;

				$costprice = $product->unitprice;
				//SALES PERFORMANCE
				$salevol = (int)Core_Stat::getData(Core_Stat::TYPE_SALE, array('kind' => 2, 'product' => $product->id), true, $startdate, $enddate );

				$saleRev = 0;
				$listRevenue = Core_Stat::getData(Core_Stat::TYPE_SALE, array('kind' => 1, 'product' => $product->id), false, $startdate, $enddate );
				$chartvaluearr = array();
				if(!empty($listRevenue)){
					foreach($listRevenue as $d=>$rev){
						$saleRev += $rev;
						$chartvaluearr[] = $rev;
					}
				}

				$profit = 0;
				$margin = 0;
				if($salevol > 0 && $saleRev > 0 && $costprice > 0) {
					$profit = $saleRev - ($salevol * $costprice);
					$margin = round($profit/$saleRev,2);
				}

				$grossmargin = $margin.' %';

				//Chua co contribute
				$volcount = 'NA';
				$revcount = 'NA';
				$profitcount = 'NA';
				$margincount = 'NA';

				//Rank
				$volrank = 'NA';
				$revrank = 'NA';
				$profitrank = 'NA';
				$marginrank = 'NA';

				/*$outputdata .= '['.date('Y').', '.date('m').', "'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'
								.addslashes($product->name).'",'.$salevol.','.$saleRev.','.$profit.',"'.$grossmargin.'","'
								.$volcount.'","'.$revcount.'","'.$profitcount.'","'.$margincount.'","'
								.$volrank.'","'.$revrank.'","'.$profitrank.'","'.$marginrank.'"'.'],';*/
				$outputdata .= '["'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'
								.addslashes($product->name).'",'.$costprice.','.$salevol.','.$saleRev.',"<a href=\''.$product->getProductPath().'\' target=\'_blank\'><span class=\'sparklines\'>'.implode(',',$chartvaluearr).'</span></a>", '.$profit.',"'.$grossmargin.'","'
								.$volcount.'","'.$revcount.'","'.$profitcount.'","'.$margincount.'","'
								.$volrank.'","'.$revrank.'","'.$profitrank.'","'.$marginrank.'"'.', "<a href=\''.$product->getProductPath().'\' target=\'_blank\'>VIEW</a> <a href=\''.$this->registry->conf['rooturl'].'cms/product/edit/id/'.$product->id.'/'.'\' target=\'_blank\'>EDIT</a>"],';
			}
		}
		$outputdata  = substr($outputdata , 0 , -1);
		$outputdata .= ']';
		return $outputdata;
	}



	private function loaddatasheet3($listproduct)
	{
		$outputdata = '[';
		if(!empty($listproduct))
		{
			foreach($listproduct as $product)
			{
				$category = new Core_Productcategory($product->pcid, true);
				$maincate = '';
				if($category->parent == 0)
				{
					$maincate = $category->name;
				}
				else{
					$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
					if(!empty($parentcategory[0])){
						$maincate = $parentcategory[0]['pc_name'];
					}
				}
				$product->subcate = $category->name;
				$myvendor = new Core_Vendor($product->vid, true);
				$product->brand = $myvendor->name;

				$costprice = $product->unitprice;
				//INVENTORY DATA
				$stockvol = 0;
				$stockvalue = $product->instock * $costprice;
				$stocksaleday = 0;
				$targetstocksaleday = 0;
				$stockvol30day = 0;
				$stockvol60day = 0;
				$stockvol90day = 0;
				$stockvol120day = 0;
				$stockvolgreater120day = 0;
				$stockvalue30day = 0;
				$stockvalue60day = 0;
				$stockvalue90day = 0;
				$stockvalue120day = 0;
				$stockvaluegreater120day = 0;

				$outputdata .= '["'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'.addslashes($product->name).'",'
								.$costprice.','.$stockvol.','.$stockvalue.','.$stocksaleday.','.$targetstocksaleday.','
								.$stockvol30day.','.$stockvol60day.','.$stockvol90day.','.$stockvol120day.','
								.$stockvolgreater120day.','.$stockvalue30day.','.$stockvalue60day.','.$stockvalue90day.','
								.$stockvalue120day.','.$stockvaluegreater120day
								.', "<a href=\''.$product->getProductPath().'\' target=\'_blank\'>VIEW</a> <a href=\''.$this->registry->conf['rooturl'].'cms/product/edit/id/'.$product->id.'/'.'\' target=\'_blank\'>EDIT</a>"],';
			}
		}
		$outputdata  = substr($outputdata , 0 , -1);
		$outputdata .= ']';
		return $outputdata;
	}



	private function loaddatasheet5($listproduct)
	{
		$outputdata = '[';
		if(!empty($listproduct))
		{
			foreach($listproduct as $product)
			{
				$category = new Core_Productcategory($product->pcid, true);
				$maincate = '';
				if($category->parent == 0)
				{
					$maincate = $category->name;
				}
				else{
					$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
					if(!empty($parentcategory[0])){
						$maincate = $parentcategory[0]['pc_name'];
					}
				}
				$product->subcate = $category->name;
				$myvendor = new Core_Vendor($product->vid, true);
				$product->brand = $myvendor->name;

				//SELL-OUT (W8)
				$salevol = 0;
				$salerev = 0;
				$grossprofit = 0;
				$grossmargin = '0%';

				//STOCK (W8)
				$stockvol = 0;
				$stockrev = 0;
				$stockkeepingday = 0;
				$sellinstockday = 0;
				$sellinvol = 0;
				$sellinpricemin4w = 0;
				$sellinvalue = 0;

				$outputdata .= '["'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'.addslashes($product->name).'",'
								.$salevol.','.$salerev.','.$grossprofit.',"'.$grossmargin.'",'
								.$stockvol.','.$stockrev.','.$stockkeepingday.','.$sellinstockday.','
								.$sellinvol.','.$sellinpricemin4w.','.$sellinvalue
								.', "<a href=\''.$product->getProductPath().'\' target=\'_blank\'>VIEW</a> <a href=\''.$this->registry->conf['rooturl'].'cms/product/edit/id/'.$product->id.'/'.'\' target=\'_blank\'>EDIT</a>"],';
			}
		}
		$outputdata  = substr($outputdata , 0 , -1);
		$outputdata .= ']';
		return $outputdata;
	}

	public function filterAction()
	{
		$id = (int)isset($_GET['fpcid'])?$_GET['fpcid']:0;
		$fvid = (string)Helper::plaintext(isset($_GET['fvid'])?$_GET['fvid']:'');
		$fsubpcid = (string)Helper::plaintext(isset($_GET['fsubpcid'])?$_GET['fsubpcid']:'');
		$fpriceseg = (string)Helper::plaintext(isset($_GET['fpriceseg'])?$_GET['fpriceseg']:'');
		$sheet = (int)isset($_GET['sheet']) ? $_GET['sheet'] : 0;
		$fstartdate = (string)Helper::plaintext(isset($_GET['fstart'])?$_GET['fstart']:date('d/m/Y', strtotime('-1 month')));
		$fenddate = (string)Helper::plaintext(isset($_GET['fend'])?$_GET['fend']:date('d/m/Y'));
		$arrsubcate = array();
		if($id > 0)
		{
			$arrCondition = array();
			$arrCondition['fisonsitestatus'] = 1;
			//subcate
			if(!empty($fsubpcid))
			{
				$fsubpcidarr = explode(',', $fsubpcid);
				$newsubpcids = array();
				foreach($fsubpcidarr as $subpc)
				{
					$subpc = (int)$subpc;
					if($subpc > 0)
					{
						$newsubpcids[] = $subpc;
					}
				}
				if(count($newsubpcids) > 0 ) {
					$arrsubcate = $newsubpcids;
					$arrCondition['fpcidarrin'] = $newsubpcids;
				}
			}
			else{
				$fullPathCat = Core_Productcategory::getFullSubCategory($id);

				if(empty($fullPathCat))
				{
					$arrCondition['fpcid'] = $id;
					$arrsubcate[] = $id;
				}
				else {
					$arrsubcate = $fullPathCat;
					$arrCondition['fpcidarrin'] = $fullPathCat;
				}
			}

			//vendor
			if($fvid !='' ) {
				$fvid = explode(',', $fvid);
				$newfvid = array();
				foreach($fvid as $vid)
				{
					$vid = (int)$vid;
					if($vid > 0)
					{
						$newfvid[] = $vid;
					}
				}
				if(count($newfvid) > 0 ) $arrCondition['fvidarr'] = $newfvid;
			}
			set_time_limit(0);
			$havepricesegment = array();
			if(!empty($fpriceseg))
			{
				$listpricesegslug = explode(',', $fpriceseg);
				if(!empty($listpricesegslug))
				{
					foreach($listpricesegslug as $slugprice)
					{
						if(!empty($slugprice)){
							/*$explodeslug = explode(';',$slugprice,2);
							if(count($explodeslug)==2){
								$havepricesegment[$explodeslug[0]] = $explodeslug[1];
							}*/
							$havepricesegment[] = $slugprice;
						}
					}
				}
			}
			else $havepricesegment = null;
			if(!empty($havepricesegment))
			{
				$listarray = Core_RelProductAttribute::getProductIdByFilter(array('fvalue' => $havepricesegment, 'fpcid' => $arrsubcate , 'fstat' => 1), 'pid' , 'ASC');
				if(!empty($listarray)){
					$arrCondition['fidarr'] = $listarray;
				}
			}
			$listproduct = Core_Product::getProducts($arrCondition, '', '');
			if(empty($listproduct)) {
				echo '';
				return;
			}
			//$output = array();
			$outputdata = '';
			switch($sheet)
			{
				case 0:
					$outputdata = $this->loaddatasheet0($listproduct, $listslugpricesegment);
					break;
				case 2: //sheet 2
					//$outputdata = $this->loaddatasheet2($listproduct);
					$outputdata = $this->loaddatasheet2($listproduct, Helper::strtotimedmy($fstartdate), Helper::strtotimedmy($fenddate));
					break;
				case 3: //sheet 3
					$outputdata = $outputdata = $this->loaddatasheet3($listproduct);
					break;
				case 5: //sheet 5
					$outputdata = $this->loaddatasheet5($listproduct);
					break;
			}
			echo '{"data": '.$outputdata.'}';
		}
	}


	/**
	 * @get data schema of table
	 */
	private function getDataSchema($sheet)
	{
		$schema  = array();


		switch ($sheet)
		{
			case 0:

				$schema['columns'] = '[
	                {
	                     type: {renderer: timeRender},
	                     readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                     type: {renderer: categoryRender},
	                     readOnly: true
	                },
	                {
	                    type: {renderer: productRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                    type: {renderer: costpriceRender}
	                },
	                {
	                    type: {renderer: productnameRender}
	                }
	            ]';

	            $schema['colHeaders'] = '["Category" , \'<span class="dropsubcategory0">Sub Category</div>\' , \'<span class="titledropdown0">Brand</span>\', \'Barcode\', "SKU Name" , \'<span class="fiterpricesegment'.$sheet.'">Segment Name</span>\' , "Price Segment" ,\'SKU Role\' ,  "Cost Price" , "Sell Price", " "]';

	            $schema['colWidths'] = '[100 ,  100 , 100 , 100 , 400 , 100 , 120 ,120 , 120, 120, 80]';
				break;

			case 2 :
				$schema['columns'] = '[
	                {
	                     type: {renderer: categoryRender},
	                     readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                     type: {renderer: categoryRender},
	                     readOnly: true
	                },
	                {
	                    type: {renderer: productRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: productnameRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: yellowRender}
	                },
	                {
                		type: {renderer: productnameRender}
	                }
	            ]';
	            $schema['colHeaders'] = '["Category" , \'<span class="dropsubcategory2">Sub Category</div>\', \'<span class="titledropdown2">Brand</span>\', "Barcode" , "SKU Name" , "Cost price" , "Sales Vol" , "Sales Rev" , "Chart" , "ProF" ,\'GrossMargin\' ,  "Vol Cont" , "Rev Cont","ProF cont" , "Vol. Rank" , "Rev. Rank" , "ProF. Rank" , "Margin Rank", " "]';
	            $schema['colWidths'] = '[100 , 100 ,  100 , 100 , 300 , 100 , 100 , 100 , 100 ,150 , 100, 100 , 100 , 100 ,100 , 100 ,100 ,100, 100, 100]';
				break;

			case 3 :
				$schema['columns'] = '[
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                     type: {renderer: categoryRender},
	                     readOnly: true
	                },
	                {
	                    type: {renderer: productRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: productnameRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                    type: {renderer: yellowRender}
	                },
	                {
	                	type: {renderer: yellowRender}
	                },
	                {
	                	type: {renderer: yellowRender}
	                },
	                {
	                	type: {renderer: yellowRender}
	                },
	                {
	                	type: {renderer: yellowRender}
	                },
	                {
	                	type: {renderer: formularcellRender}
	                },
	                {
	                	type: {renderer: formularcellRender}
	                },
	                {
	                	type: {renderer: formularcellRender}
	                },
	                {
	                	type: {renderer: formularcellRender}
	                },
	                {
	                	type: {renderer: formularcellRender}
	                },
	                {
	                	type: {renderer: productnameRender}
	                }
	            ]';
	            $schema['colHeaders'] = '["Category" , \'<span class="dropsubcategory3">Sub Category</div>\' , \'<span class="titledropdown3">Brand</span>\', "Barcode" , "SKU Name" , "Cost price", "STOCK Volume" , "STOCK value" , "STOCK <br/> sale-day" ,\'TARGET-STOCK <br/> sale-day\' ,  "STOCK volume <br /> 30 days" , "STOCK volume <br /> 60 days","STOCK volume <br /> 90 days" , "STOCK volume <br /> 120 days" , " STOCK volume <br /> > 120 days" , "STOCK value <br /> 30 days" , "STOCK value <br /> 60 days" , "STOCK value <br /> 90 days" , "STOCK value <br /> 120 days", "STOCK value <br /> > 120 days", " "]';
	            $schema['colWidths'] = '[100 ,  100 , 100 , 100 , 300 , 100 , 100 ,100 , 100, 100 , 100 , 100 ,100 , 100 ,100 ,100, 100 ,100 ,100, 100, 100]';
	            break;

	        case 5:
	        	$schema['columns'] = '[
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: categoryRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: productRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: productnameRender},
	                    readOnly: true
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
					{
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
					{
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: formularcellRender}
	                },
	                {
	                    type: {renderer: productnameRender}
	                }
	            ]';
	        	$schema['colHeaders'] = '["Category" , \'<span class="dropsubcategory5">Sub Category</div>\' , \'<span class="titledropdown5">Brand</span>\', "Barcode" , "SKU Name" , "(AUTO FORECAST)Sales <br/> volume  ****" , "(AUTO FORECAST)<br/>Sales revenue" , "(AUTO FORECAST)<br/>Gross profit" , "(AUTO FORECAST)<br />Gross margin" ,"(AUTO FORECAST)Stock volume", "(AUTO FORECAST)Stock value ","(AUTO FORECAST)Stock keeping day " ,"(AUTO FORECAST) <br/> Sell-in stock day" , "(AUTO FORECAST)<br/>Sell-in volume **** ","(AUTO FORECAST)<br/>Sell-in price<br/>  (Min in 4Weeks)" , "(AUTO FORECAST)<br/>Sell-in value ", " "]';
	        	$schema['colWidths'] = '[100 ,  100 , 100 , 100 , 350 , 120 , 120 ,120 , 120, 120, 120, 120, 120, 100, 100, 100, 100]';
	        	break;
		}

		return $schema;
	}

	public function exportexcelAction(){
		$id = (int)isset($_GET['id'])?$_GET['id']:0;
		$fvid = (string)Helper::plaintext(isset($_GET['fvid'])?$_GET['fvid']:'');
		$fsubpcid = (string)Helper::plaintext(isset($_GET['fsubpcid'])?$_GET['fsubpcid']:'');
		$fpriceseg = (string)Helper::plaintext(isset($_GET['fpriceseg'])?$_GET['fpriceseg']:'');
		$sheet = (int)isset($_GET['fsheet']) ? $_GET['fsheet'] : 0;
		if($id > 0)
		{
			$arrCondition = array();
			$arrCondition['fisonsitestatus'] = 1;
			//subcate
			if(!empty($fsubpcid))
			{
				$fsubpcidarr = explode(',', $fsubpcid);
				$newsubpcids = array();
				foreach($fsubpcidarr as $subpc)
				{
					$subpc = (int)$subpc;
					if($subpc > 0)
					{
						$newsubpcids[] = $subpc;
					}
				}
				if(count($newsubpcids) > 0 ) $arrCondition['fpcidarrin'] = $newsubpcids;
			}
			else{
				$fullPathCat = Core_Productcategory::getFullSubCategory($id);

				if(empty($fullPathCat))
				{
					$arrCondition['fpcid'] = $id;
				}
				else $arrCondition['fpcidarrin'] = $fullPathCat;
			}

			//vendor
			if($fvid !='' ) {
				$fvid = explode(',', $fvid);
				$newfvid = array();
				foreach($fvid as $vid)
				{
					$vid = (int)$vid;
					if($vid > 0)
					{
						$newfvid[] = $vid;
					}
				}
				if(count($newfvid) > 0 ) $arrCondition['fvidarr'] = $newfvid;
			}
			$havepricesegment = array();
			if(!empty($fpriceseg))
			{
				$listpricesegslug = explode(',', $fpriceseg);
				if(!empty($listpricesegslug))
				{
					foreach($listpricesegslug as $slugprice)
					{
						if(!empty($slugprice)){
							/*$explodeslug = explode(';',$slugprice,2);
							if(count($explodeslug)==2){
								$havepricesegment[$explodeslug[0]] = $explodeslug[1];
							}*/
							$havepricesegment[] = $slugprice;
						}
					}
				}
			}
			else $havepricesegment = null;
			if(!empty($havepricesegment))
			{
				$listarray = Core_RelProductAttribute::getProductIdByFilter(array('fvalue' => $havepricesegment, 'fpcid' => $fpcid), 'pid' , 'ASC');
				if(!empty($listarray)){
					$arrCondition['fidarr'] = $listarray;
				}
			}
			set_time_limit(0);
			$listproduct = Core_Product::getProducts($arrCondition, '', '');
			if(!empty($listproduct)){
				$this->{'exportexcelsheet'.$sheet}($listproduct);
			}
		}
	}

	private function exportexcelsheet0($listproduct){
		require_once 'libs/phpexcel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("DIENMAY")
									->setLastModifiedBy("DIENMAY")
									->setTitle("Danh sách sản phẩm")
									->setSubject("Danh sách sản phẩm")
									->setDescription("Sản phẩm forecast.")
									->setKeywords("product, category")
									->setCategory('Forecast');
		$objPHPExcel->getActiveSheet()->setTitle('Danh sách sản phẩm sheet 1');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Year')
											->setCellValue('B1', 'Month')
											->setCellValue('C1', 'Category')
											->setCellValue('D1', 'Sub Category')
											->setCellValue('E1', 'Brand')
											->setCellValue('F1', 'Barcode')
											->setCellValue('G1', 'SKU Name')
											->setCellValue('H1', 'Segment Name')
											->setCellValue('I1', 'Price Segment')
											->setCellValue('J1', 'SKU Role')
											->setCellValue('K1', 'Cost Price')
											->setCellValue('L1', 'Sell Price')
											;
		$ct = 2;
		foreach($listproduct as $product)
		{
			$category = new Core_Productcategory($product->pcid, true);
			$maincate = '';
			if($category->parent == 0)
			{
				$maincate = $category->name;
			}
			else{
				$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
				if(!empty($parentcategory[0])){
					$maincate = $parentcategory[0]['pc_name'];
				}
			}
			$product->subcate = $category->name;
			$myvendor = new Core_Vendor($product->vid, true);
			$product->brand = $myvendor->name;

			$segmentname = '';
			$segmentprice = '';

			$listpricesegment = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $product->pcid, 'fpaid' => 0),'','',1);
			if(!empty($listpricesegment))
			{
				foreach($listpricesegment as $priceseg)
				{
					$listrowseg = $priceseg->getDataRow();
					if(!empty($listrowseg))
					{
						foreach($listrowseg as $rowseg)
						{
							if(!empty($rowseg))
							{
								$exploderow = explode('##', $rowseg);//ten##slug##type(20)##fron#to
								$listslugpricesegment[$exploderow[1]] = $exploderow[0];
								if(empty($segmentname) && empty($segmentprice))
								{
									if($exploderow[4] <= 0) {
                                		if($product->sellprice <= $exploderow[3])
                                		{
											$segmentname = $exploderow[0];
											$segmentprice = 'từ '.Helper::formatPrice($exploderow[3]);
                                		}
		                            }
		                            elseif($exploderow[3] <= 0) {
                                		if($product->sellprice > $exploderow[4])
                                		{
											$segmentname = $exploderow[0];
											$segmentprice = 'dưới '.Helper::formatPrice($exploderow[4]);
                                		}
		                            }
		                            else {
										if($product->sellprice >= $exploderow[3] && $product->sellprice < $exploderow[4])
                                		{
											$segmentname = $exploderow[0];
											$segmentprice = Helper::formatPrice($exploderow[3]). ' - '.Helper::formatPrice($exploderow[4]);
                                		}
		                            }
								}
							}
						}
					}
				}
			}

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ct, date('Y'))
											->setCellValue('B'.$ct, date('m'))
											->setCellValue('C'.$ct, addslashes($maincate))
											->setCellValue('D'.$ct, addslashes($product->subcate))
											->setCellValue('E'.$ct, addslashes($product->brand))
											->setCellValue('F'.$ct, trim($product->barcode))
											->setCellValue('G'.$ct, addslashes($product->name))
											->setCellValue('H'.$ct, $segmentname)
											->setCellValue('I'.$ct, $segmentprice)
											->setCellValue('J'.$ct, (!empty($product->skurole)?$product->skurole:'NA'))
											->setCellValue('K'.$ct, (!empty($product->unitprice)?$product->unitprice:'0'))
											->setCellValue('L'.$ct, $product->sellprice)
											;
			$objPHPExcel->getActiveSheet(0)->getCell('F'.$ct)->setValueExplicit(trim($product->barcode), PHPExcel_Cell_DataType::TYPE_STRING);

			$ct++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('uploads/forecastsheet.xlsx',);
        ob_end_clean();

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="forecastsheet0.xlsx"');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
	}

	private function exportexcelsheet2($listproduct){
		require_once 'libs/phpexcel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("DIENMAY")
									->setLastModifiedBy("DIENMAY")
									->setTitle("Danh sách sản phẩm")
									->setSubject("Danh sách sản phẩm")
									->setDescription("Sản phẩm forecast.")
									->setKeywords("product, category")
									->setCategory('Forecast');
		$objPHPExcel->getActiveSheet()->setTitle('Danh sách sản phẩm sheet 2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Year')
											->setCellValue('B1', 'Month')
											->setCellValue('C1', 'Category')
											->setCellValue('D1', 'Sub Category')
											->setCellValue('E1', 'Brand')
											->setCellValue('F1', 'Barcode')
											->setCellValue('G1', 'SKU Name')
											->setCellValue('H1', 'Sale Vol')
											->setCellValue('I1', 'Sale Rev')
											->setCellValue('J1', 'ProF')
											->setCellValue('K1', 'Gross Margin')
											->setCellValue('L1', 'Vol Cont')
											->setCellValue('M1', 'Rev Cont')
											->setCellValue('N1', 'ProF Cont')
											->setCellValue('O1', 'Margin on')
											->setCellValue('P1', 'Vol. Rank')
											->setCellValue('Q1', 'Rev. Rank')
											->setCellValue('R1', 'ProF. Rank')
											->setCellValue('S1', 'Margin Rank')
											;
		$ct = 2;
		foreach($listproduct as $product)
		{
			$category = new Core_Productcategory($product->pcid, true);
				$maincate = '';
				if($category->parent == 0)
				{
					$maincate = $category->name;
				}
				else{
					$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
					if(!empty($parentcategory[0])){
						$maincate = $parentcategory[0]['pc_name'];
					}
				}
				$product->subcate = $category->name;
				$myvendor = new Core_Vendor($product->vid, true);
				$product->brand = $myvendor->name;

				$costprice = $product->unitprice;
				//SALES PERFORMANCE
				$salevol = 0;//Core_ArchivedorderDetail::totalSalessVolbyPrductId($product->id);

				$saleRev =  0;//Core_ArchivedorderDetail::totalSalessRevbyPrductId($product->id);
				$profit = 0;
				$margin = 0;
				if($salevol > 0 && $saleRev > 0 && $costprice > 0) {
					$profit = $saleRev - ($salevol * $costprice);
					$margin = round($profit/$saleRev,2);
				}

				$grossmargin = $margin.' %';

				//Chua co contribute
				$volcount = 'NA';
				$revcount = 'NA';
				$profitcount = 'NA';
				$margincount = 'NA';

				//Rank
				$volrank = 'NA';
				$revrank = 'NA';
				$profitrank = 'NA';
				$marginrank = 'NA';

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ct, date('Y'))
											->setCellValue('B'.$ct, date('m'))
											->setCellValue('C'.$ct, addslashes($maincate))
											->setCellValue('D'.$ct, addslashes($product->subcate))
											->setCellValue('E'.$ct, addslashes($product->brand))
											->setCellValue('F'.$ct, trim($product->barcode))
											->setCellValue('G'.$ct, addslashes($product->name))
											->setCellValue('H'.$ct, $salevol)
											->setCellValue('I'.$ct, $saleRev)
											->setCellValue('J'.$ct, $profit)
											->setCellValue('K'.$ct, $grossmargin)
											->setCellValue('L'.$ct, $volcount)
											->setCellValue('M'.$ct, $revcount)
											->setCellValue('N'.$ct, $profitcount)
											->setCellValue('O'.$ct, $margincount)
											->setCellValue('P'.$ct, $volrank)
											->setCellValue('Q'.$ct, $revrank)
											->setCellValue('R'.$ct, $profitrank)
											->setCellValue('S'.$ct, $marginrank)
											;

			$objPHPExcel->getActiveSheet(0)->getCell('F'.$ct)->setValueExplicit(trim($product->barcode), PHPExcel_Cell_DataType::TYPE_STRING);
			$ct++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('uploads/forecastsheet.xlsx',);
        ob_end_clean();

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="forecastsheet2.xlsx"');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
	}

	private function exportexcelsheet3($listproduct){
		require_once 'libs/phpexcel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("DIENMAY")
									->setLastModifiedBy("DIENMAY")
									->setTitle("Danh sách sản phẩm")
									->setSubject("Danh sách sản phẩm")
									->setDescription("Sản phẩm forecast.")
									->setKeywords("product, category")
									->setCategory('Forecast');
		$objPHPExcel->getActiveSheet()->setTitle('Danh sách sản phẩm sheet 2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Year')
											->setCellValue('B1', 'Month')
											->setCellValue('C1', 'Category')
											->setCellValue('D1', 'Sub Category')
											->setCellValue('E1', 'Brand')
											->setCellValue('F1', 'Barcode')
											->setCellValue('G1', 'SKU Name')
											->setCellValue('H1', 'STOCK Volume')
											->setCellValue('I1', 'STOCK value')
											->setCellValue('J1', 'STOCK sales-day')
											->setCellValue('K1', 'TARGET-STOCK sale-day')
											->setCellValue('L1', 'STOCK Volume 30 days')
											->setCellValue('M1', 'STOCK Volume 60 days')
											->setCellValue('N1', 'STOCK Volume 90 days')
											->setCellValue('O1', 'STOCK Volume 120 days')
											->setCellValue('P1', 'STOCK Volume >120 days')
											->setCellValue('Q1', 'STOCK value 30 days')
											->setCellValue('R1', 'STOCK value 60 days')
											->setCellValue('S1', 'STOCK value 90 days')
											->setCellValue('T1', 'STOCK value 120 days')
											->setCellValue('U1', 'STOCK value >120 days')
											;
		$ct = 2;
		foreach($listproduct as $product)
		{
			$category = new Core_Productcategory($product->pcid, true);
			$maincate = '';
			if($category->parent == 0)
			{
				$maincate = $category->name;
			}
			else{
				$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
				if(!empty($parentcategory[0])){
					$maincate = $parentcategory[0]['pc_name'];
				}
			}
			$product->subcate = $category->name;
			$myvendor = new Core_Vendor($product->vid, true);
			$product->brand = $myvendor->name;

			$costprice = $product->unitprice;
			//INVENTORY DATA
			$stockvol = $product->instock * $costprice;
			$stockvalue = 0;
			$stocksaleday = 0;
			$targetstocksaleday = 0;
			$stockvol30day = 0;
			$stockvol60day = 0;
			$stockvol90day = 0;
			$stockvol120day = 0;
			$stockvolgreater120day = 0;
			$stockvalue30day = 0;
			$stockvalue60day = 0;
			$stockvalue90day = 0;
			$stockvalue120day = 0;
			$stockvaluegreater120day = 0;

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ct, date('Y'))
											->setCellValue('B'.$ct, date('m'))
											->setCellValue('C'.$ct, addslashes($maincate))
											->setCellValue('D'.$ct, addslashes($product->subcate))
											->setCellValue('E'.$ct, addslashes($product->brand))
											->setCellValue('F'.$ct, trim($product->barcode))
											->setCellValue('G'.$ct, addslashes($product->name))
											->setCellValue('H'.$ct, $stockvol)
											->setCellValue('I'.$ct, $stockvalue)
											->setCellValue('J'.$ct, $stocksaleday)
											->setCellValue('K'.$ct, $targetstocksaleday)
											->setCellValue('L'.$ct, $stockvol30day)
											->setCellValue('M'.$ct, $stockvol60day)
											->setCellValue('N'.$ct, $stockvol90day)
											->setCellValue('O'.$ct, $stockvol120day)
											->setCellValue('P'.$ct, $stockvolgreater120day)
											->setCellValue('Q'.$ct, $stockvalue30day)
											->setCellValue('R'.$ct, $stockvalue60day)
											->setCellValue('S'.$ct, $stockvalue90day)
											->setCellValue('T'.$ct, $stockvalue120day)
											->setCellValue('U'.$ct, $stockvaluegreater120day)
											;
			$objPHPExcel->getActiveSheet(0)->getCell('F'.$ct)->setValueExplicit(trim($product->barcode), PHPExcel_Cell_DataType::TYPE_STRING);
			$ct++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('uploads/forecastsheet.xlsx',);
        ob_end_clean();

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="forecastsheet3.xlsx"');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
	}

	private function exportexcelsheet5($listproduct){
		require_once 'libs/phpexcel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("DIENMAY")
									->setLastModifiedBy("DIENMAY")
									->setTitle("Danh sách sản phẩm")
									->setSubject("Danh sách sản phẩm")
									->setDescription("Sản phẩm forecast.")
									->setKeywords("product, category")
									->setCategory('Forecast');
		$objPHPExcel->getActiveSheet()->setTitle('Danh sách sản phẩm sheet 2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Year')
											->setCellValue('B1', 'Month')
											->setCellValue('C1', 'Category')
											->setCellValue('D1', 'Sub Category')
											->setCellValue('E1', 'Brand')
											->setCellValue('F1', 'Barcode')
											->setCellValue('G1', 'SKU Name')
											->setCellValue('H1', '(AUTO FORECAST)Sales volume')
											->setCellValue('I1', '(AUTO FORECAST)Sales revenue')
											->setCellValue('J1', '(AUTO FORECAST)Gross profit')
											->setCellValue('K1', '(AUTO FORECAST)Gross margin')
											->setCellValue('L1', '(AUTO FORECAST)Stock volume')
											->setCellValue('M1', '(AUTO FORECAST)Stock value')
											->setCellValue('N1', '(AUTO FORECAST)Stock keeping day')
											->setCellValue('O1', '(AUTO FORECAST) Sell-in stock day')
											->setCellValue('P1', '(AUTO FORECAST)Sell-in volume ')
											->setCellValue('Q1', '(AUTO FORECAST)Sell-in price')
											->setCellValue('R1', '(AUTO FORECAST)Sell-in value')
											;
		$ct = 2;
		foreach($listproduct as $product)
		{
			$category = new Core_Productcategory($product->pcid, true);
				$maincate = '';
				if($category->parent == 0)
				{
					$maincate = $category->name;
				}
				else{
					$parentcategory = Core_Productcategory::getFullParentProductCategorys($product->pcid);
					if(!empty($parentcategory[0])){
						$maincate = $parentcategory[0]['pc_name'];
					}
				}
				$product->subcate = $category->name;
				$myvendor = new Core_Vendor($product->vid, true);
				$product->brand = $myvendor->name;

				//SELL-OUT (W8)
				$salevol = 0;
				$salerev = 0;
				$grossprofit = 0;
				$grossmargin = '0%';

				//STOCK (W8)
				$stockvol = 0;
				$stockrev = 0;
				$stockkeepingday = 0;
				$sellinstockday = 0;
				$sellinvol = 0;
				$sellinpricemin4w = 0;
				$sellinvalue = 0;

				$outputdata .= '['.date('Y').', '.date('m').', "'.addslashes($maincate).'", "'.addslashes($product->subcate).'", "'.addslashes($product->brand).'", "'.trim($product->barcode).'","'.addslashes($product->name).'",'
								.$salevol.','.$salerev.','.$grossprofit.',"'.$grossmargin.'",'
								.$stockvol.','.$stockrev.','.$stockkeepingday.','.$sellinstockday.','
								.$sellinvol.','.$sellinpricemin4w.','.$sellinvalue
								.'],';

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ct, date('Y'))
											->setCellValue('B'.$ct, date('m'))
											->setCellValue('C'.$ct, addslashes($maincate))
											->setCellValue('D'.$ct, addslashes($product->subcate))
											->setCellValue('E'.$ct, addslashes($product->brand))
											->setCellValue('F'.$ct, trim($product->barcode))
											->setCellValue('G'.$ct, addslashes($product->name))
											->setCellValue('H'.$ct, $salevol)
											->setCellValue('I'.$ct, $salerev)
											->setCellValue('J'.$ct, $grossprofit)
											->setCellValue('K'.$ct, $grossmargin)
											->setCellValue('L'.$ct, $stockvol)
											->setCellValue('M'.$ct, $stockrev)
											->setCellValue('N'.$ct, $stockkeepingday)
											->setCellValue('O'.$ct, $sellinstockday)
											->setCellValue('P'.$ct, $sellinvol)
											->setCellValue('Q'.$ct, $sellinpricemin4w)
											->setCellValue('R'.$ct, $sellinvalue)
											;
			$objPHPExcel->getActiveSheet(0)->getCell('F'.$ct)->setValueExplicit(trim($product->barcode), PHPExcel_Cell_DataType::TYPE_STRING);
			$ct++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('uploads/forecastsheet.xlsx',);
        ob_end_clean();

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="forecastsheet5.xlsx"');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
	}
}