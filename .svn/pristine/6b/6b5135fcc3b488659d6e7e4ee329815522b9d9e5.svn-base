<?php
Class Controller_Site_Event Extends Controller_Site_Base
{
	public function indexAction(){

	}

	public function detailAction(){

		if(empty($_GET['id']))
		{
			header('Location: '.$this->conf['rooturl']);
			exit();
		}
		$subdomain = '';
        if(SUBDOMAIN == 'm'){
            $subdomain = SUBDOMAIN;
        }
		$today = strtotime(date('Y-m-d',time()));
		$eventdate = array();
		$cachedate = $subdomain. 'site_eventdate'.'_'.$_GET['id'];
		$mycachedate = new Cacher($cachedate);
		$isoutofstock = (int)$_GET['outofstock'];
		$outofstockproductlist = array();

		if(isset($_GET['live']) || isset($_GET['outofstock'])) {
			$mycachedate->clear();

		}else{
			$eventdate = json_decode($mycachedate->get(), true);
		}

		if(empty($eventdate)){
			$getEventDetail = new Core_Event($_GET['id']);
			$starttime = strtotime(date('Y-m-d',$getEventDetail->starttime));
			$endtime = strtotime(date('Y-m-d',$getEventDetail->endtime));
			$eventdate['starttime'] = $starttime;
			$eventdate['endtime'] = $endtime;
			$mycachedate->set(json_encode($eventdate, true));
		}

		if (!empty($eventdate)){
			if($today >= $eventdate['starttime'] && $today <= $eventdate['endtime'] ){
				$cachefile = $subdomain . 'sitehtml_eventdetail' . '_' . $_GET['id'];

				$myCache = new Cacher($cachefile);
				$pageHtml = '';
				if(isset($_GET['live']) || isset($_GET['outofstock'])) {
					$myCache->clear();
				}else{
					$pageHtml = $myCache->get();
				}

				if(!$pageHtml)
				{

					$getEventDetail = new Core_Event($_GET['id']);
					if(empty($getEventDetail) || $getEventDetail->status == Core_Event::STATUS_DISABLED)
					{
						header('Location: '.$this->registry->conf['rooturl']);
						exit();
					}
					$arrayAssignTemplate = array();
					$themeEvent = '';

					//get keyword list
					$keywordList = array();

					$myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $getEventDetail->id, 'ftype' => Core_RelItemKeyword::TYPE_EVENT), '', '', '');

					foreach($myKeyword as $keyword)
					{
						$prebuild = new Core_Keyword($keyword->kid);

						$keywordList[] = $prebuild;
					}

					$content = $getEventDetail->content;
					preg_match_all('/\[[a-z0-9 =",]+\]/', $content, $matches);
					if(count($matches[0]) > 0)
					{
						foreach ($matches[0] as $matcher)
						{
							$data = str_replace(array('[' , ']'), '', $matcher);
							$datalist = explode(' ', $data);
							if(count($datalist) > 0)
							{
								//get productid
								$promoid = 0;
								$programid = 0;
								$info = explode('=', $datalist[1]);
								$productid = str_replace('"', '', $info[1]);
								$myProduct = new Core_Product((int)$productid , true);
                                $canselllist = array(Core_Product::OS_ERP , Core_Product::OS_HOT , Core_Product::OS_NEW , Core_Product::OS_BESTSELLER , Core_Product::OS_CRAZYSALE);
								if ($myProduct->id > 0 && in_array($myProduct->onsitestatus , $canselllist)  && $myProduct->sellprice > 0 && $myProduct->instock > 0)
								{
									$mycate = new Core_Productcategory($myProduct->pcid);
									if($mycate->appendtoproductname == 1){
										$myProduct->name = $mycate->name . ' ' . $myProduct->name;
									}
					
									$promotioninfo = array();
									$getpromotion = null;
									$discount = 0;
									$promoiddiscount = 0;

									$finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($myProduct, $this->registry->region);
									if ($finalprice <= 0)
									$finalprice = $myProduct->sellprice;

									//get promotion
									$promotionlist = $myProduct->promotionlist;
									$explodeitem = explode('#', $promotionlist);
									
									$promotion_id = '';
									if (!empty($explodeitem[0]))
									{
										$explodeitem = explode(',', $explodeitem[0]);
										if(!empty($explodeitem[1])){
											$promotion_id = '_' . $explodeitem[1];
										}
									}
									
									$info = explode('=', $datalist[2]);
									$promostr = str_replace('"', '', $info[1]);
									$promostrinfo = implode(':', explode(',', $promostr));
									if(strlen($promostr) > 0)
									{
										$listidpromoarr = explode(',', $promostr);
										$promotioninfo = Core_Promotion::getPromotions(array('fisavailable' => 1, 'fidarr' => $listidpromoarr, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','','');
										$getpromotion = Core_Promotion::getFirstDiscountPromotionByListId($listidpromoarr, $this->registry->region);
											
										if($getpromotion['discountvalue'] > 0){
											$promoid = $getpromotion['promoid'];
										}
									}
									else
									{
										$promotioninfo = Core_Promotion::getPromotionByProductIDFrontEnd(trim($myProduct->barcode), $this->registry->region, $finalprice);
										$getpromotion = Core_Promotion::getFirstDiscountPromotion(trim($myProduct->barcode), $this->registry->region);
											
										if($getpromotion['discountvalue'] > 0){
											$promoid = $getpromotion['promoid'];
										}
									}

									if(!empty($getpromotion))
									{
										$promoiddiscount = $getpromotion['promoid'];
										if ($getpromotion['percent'] == 1)
										{
											$discount = $finalprice - ($finalprice * $getpromotion['discountvalue']/100);
										}
										else
										{
											$discount = $finalprice - $getpromotion['discountvalue'];
										}
									}

									$promoinfos = array();
									if(count($promotioninfo) > 0)
									{
										if(isset($promotioninfo['listPromotions']))
										{
											foreach ($promotioninfo['listPromotions'] as $promotion)
											{
												if($promotion['promoname'] != '.')
												{
													$promoinfos[]['name'] = $promotion['promoname'];
												}
											}
										}
										else
										{
											if($promotioninfo[0]->description != '.')
											$promoinfos[]['name'] = $promotioninfo[0]->description;
										}
									}
									else
									{
										$viewpromotion = 0;
									}
									// get program
									$info = explode('=', $datalist[3]);
									$programid = str_replace('"', '', $info[1]);

									if(empty($getEventDetail->productstyle)){
											
										////////////////////GET TEMPLATE OF BLOCK
										$blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'blockproduct.tpl');

										$this->registry->smarty->assign(array('productDetail' => $myProduct, 'promostr' => $promostrinfo , 'promoinfo' => $promoinfos, 'promoid' => $promoid, 'finalprice' => $finalprice, 'programid' => $programid));
										$blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'blockproduct.tpl');
										$getEventDetail->content = str_replace($matcher, $blockhtml , $getEventDetail->content);

									}else{

										$productstyle = $getEventDetail->productstyle;
										preg_match_all('/\[[a-z0-9 =",]+\]/', $productstyle, $matches_block);
										foreach ($matches_block[0] as $block){
											$data = str_replace(array('[' , ']'), '', $block);
											switch ($data) {
												case 'productpromo':
													if(count($promoinfos) > 0){
														foreach ($promoinfos as $item) {
															if(strip_tags(trim($item['name'])) !='-' && strip_tags(trim($item['name'])) !='.' && strip_tags(trim($item['name'])) !='&nbsp;' ){
																$productstyle = str_replace($block, $item['name'] , $productstyle);
															}else{
																$productstyle = str_replace($block, '', $productstyle);
															}
														}
													}else{
														$productstyle = str_replace($block, '', $productstyle);
													}
													break;
												case 'productpreprice':
													if($discount > 0){
														$per = ceil(($finalprice - $discount)/$myProduct->sellprice *100);
														$productstyle = str_replace($block, '<span>-'.$per . '%</span>', $productstyle);
													}else{
														$productstyle = str_replace($block, '', $productstyle);
													}
													
													break;
												case 'productname':
													$name =  '<a href="' . $myProduct->getProductPath() . '">' . $myProduct->name . '</a>';
													$productstyle = str_replace($block, $name , $productstyle);
													break;
												case 'productimage':
													$image = '<a href="' . $myProduct->getProductPath() . '"><img src="' . $myProduct->getSmallImage() . '" alt="' . $myProduct->seotitle . '" /></a>';
													$productstyle = str_replace($block, $image , $productstyle);
													break;
												case 'productprice':
													$price = '<div id="' . $myProduct->id . substr(trim($myProduct->barcode), -5) . '" class="loadprice lp'. $myProduct->id . substr(trim($myProduct->barcode), -5) . '" rel="' . $myProduct->id . substr(trim($myProduct->barcode), -5) . '"><div class="pricenew"></div></div>';
													$productstyle = str_replace($block, $price , $productstyle);
													break;
												case 'productbuy':
													if($myProduct->slug != ''){
														$slug =  'cart/mua-' . $myProduct->slug;
														if($promoid > 0){
															$slug .= '?prid=' . trim($myProduct->barcode) . $promotion_id;
															if($programid > 0){
																$slug .= '&po=p' . substr(trim($myProduct->barcode), -5, 5) . $programid;
															}
														}else{
															if($programid > 0){
																$slug .= '?po=p' . substr(trim($myProduct->barcode), -5, 5) . $programid;
															}
														}
														
													}
													else{
														$slug = 'cart/checkout?id=' . $myProduct->id;
														if($promoid > 0){
															$slug .= '&prid=' . trim($myProduct->barcode) . $promotion_id;
															
														}
														if($programid > 0){
															$slug .= '&po=p' . substr(trim($myProduct->barcode), -5, 5) . $programid;
														}
													}
													
												
		
													$buy = '<a href="' .$slug . '">Mua ngay</a>';
													$productstyle = str_replace($block, $buy , $productstyle);
													break;
											}
										}
										
										$getEventDetail->content = str_replace($matcher, $productstyle , $getEventDetail->content);
									}
								}else{
                                    $outofstockproductlist[] = $myProduct;
									$getEventDetail->content = str_replace($matcher, '' , $getEventDetail->content);
								}//end of if

							}
						}//end of foreach
					}

                    $dataoutofstock = '';
                    if(count($outofstockproductlist) > 0)
                    {
                        foreach($outofstockproductlist as $myProduct)
                        {
                            if($myProduct->id > 0)
                            {
                                $mycate = new Core_Productcategory($myProduct->pcid);
                                if($mycate->appendtoproductname == 1){
                                    $myProduct->name = $mycate->name . ' ' . $myProduct->name;
                                }

                                $promotioninfo = array();
                                $getpromotion = null;
                                $discount = 0;
                                $promoiddiscount = 0;

                                $finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($myProduct, $this->registry->region);
                                if ($finalprice <= 0)
                                    $finalprice = $myProduct->sellprice;

                                //get promotion
                                $info = explode('=', $datalist[2]);
                                $promostr = str_replace('"', '', $info[1]);
                                $promostrinfo = implode(':', explode(',', $promostr));
                                if(strlen($promostr) > 0)
                                {
                                    $listidpromoarr = explode(',', $promostr);
                                    $promotioninfo = Core_Promotion::getPromotions(array('fisavailable' => 1, 'fidarr' => $listidpromoarr, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','','');
                                    $getpromotion = Core_Promotion::getFirstDiscountPromotionByListId($listidpromoarr, $this->registry->region);

                                    if($getpromotion['discountvalue'] > 0){
                                        $promoid = $getpromotion['promoid'];
                                    }
                                }
                                else
                                {
                                    $promotioninfo = Core_Promotion::getPromotionByProductIDFrontEnd(trim($myProduct->barcode), $this->registry->region, $finalprice);
                                    $getpromotion = Core_Promotion::getFirstDiscountPromotion(trim($myProduct->barcode), $this->registry->region);

                                    if($getpromotion['discountvalue'] > 0){
                                        $promoid = $getpromotion['promoid'];
                                    }
                                }

                                if(!empty($getpromotion))
                                {
                                    $promoiddiscount = $getpromotion['promoid'];
                                    if ($getpromotion['percent'] == 1)
                                    {
                                        $discount = $finalprice - ($finalprice * $getpromotion['discountvalue']/100);
                                    }
                                    else
                                    {
                                        $discount = $finalprice - $getpromotion['discountvalue'];
                                    }
                                }

                                $promoinfos = array();
                                if(count($promotioninfo) > 0)
                                {
                                    if(isset($promotioninfo['listPromotions']))
                                    {
                                        foreach ($promotioninfo['listPromotions'] as $promotion)
                                        {
                                            if($promotion['promoname'] != '.')
                                            {
                                                $promoinfos[]['name'] = $promotion['promoname'];
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if($promotioninfo[0]->description != '.')
                                            $promoinfos[]['name'] = $promotioninfo[0]->description;
                                    }
                                }
                                else
                                {
                                    $viewpromotion = 0;
                                }
                                // get program
                                $info = explode('=', $datalist[3]);
                                $programid = str_replace('"', '', $info[1]);

                                if(empty($getEventDetail->productstyle)){

                                    ////////////////////GET TEMPLATE OF BLOCK
                                    $blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'blockproductoutofstock.tpl');

                                    $this->registry->smarty->assign(array('productDetail' => $myProduct, 'promostr' => $promostrinfo , 'promoinfo' => $promoinfos, 'promoid' => $promoid, 'finalprice' => $finalprice, 'programid' => $programid));
                                    $blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'blockproduct.tpl');
                                    $dataoutofstock .= $blockhtml;

                                }
                                else
                                {
                                    $productstyle = $getEventDetail->productstyle;
                                    preg_match_all('/\[[a-z0-9 =",]+\]/', $productstyle, $matches_block);
                                    foreach ($matches_block[0] as $block){
                                        $data = str_replace(array('[' , ']'), '', $block);
                                        switch ($data) {
                                            case 'productpromo':
                                                if(count($promoinfos) > 0){
                                                    foreach ($promoinfos as $item) {
                                                        if(strip_tags(trim($item['name'])) !='-' && strip_tags(trim($item['name'])) !='.' && strip_tags(trim($item['name'])) !='&nbsp;' ){
                                                            $productstyle = str_replace($block, $item['name'] , $productstyle);
                                                        }else{
                                                            $productstyle = str_replace($block, '', $productstyle);
                                                        }
                                                    }
                                                }else{
                                                    $productstyle = str_replace($block, '', $productstyle);
                                                }
                                                break;
                                            case 'productpreprice':
                                                if($discount > 0){
                                                    $per = ceil(($finalprice - $discount)/$myProduct->sellprice *100);
                                                    $productstyle = str_replace($block, '<span>-'.$per . '%</span>', $productstyle);
                                                }else{
                                                    $productstyle = str_replace($block, '', $productstyle);
                                                }

                                                break;
                                            case 'productname':
                                                $name =  '<a href="' . $myProduct->getProductPath() . '">' . $myProduct->name . '</a>';
                                                $productstyle = str_replace($block, $name , $productstyle);
                                                break;
                                            case 'productimage':
                                                $image = '<a href="' . $myProduct->getProductPath() . '"><img src="' . $myProduct->getSmallImage() . '" alt="' . $myProduct->seotitle . '" /></a>';
                                                $productstyle = str_replace($block, $image , $productstyle);
                                                break;
                                            case 'productprice':
                                                $price = '<div id="' . $myProduct->id . substr(trim($myProduct->barcode), -5) . '" class="loadprice lp'. $myProduct->id . substr(trim($myProduct->barcode), -5) . '" rel="' . $myProduct->id . substr(trim($myProduct->barcode), -5) . '"><div class="pricenew"></div></div>';
                                                $productstyle = str_replace($block, $price , $productstyle);
                                                break;
                                            case 'productbuy':
                                                $productstyle = str_replace($block, '' , $productstyle);
                                                break;
                                        }
                                    }

                                    $dataoutofstock .= $productstyle;
                                }
                            }
                        }//end of foreach
                    }

					//Get theme if exists
					if(!empty($getEventDetail->themeid))
					{
						$themeEvent = new Core_Eventtheme($getEventDetail->themeid);

						$themeContent = $themeEvent->description;
						preg_match_all('/\[[content =",]+\]/', $themeContent, $matches);
						if(count($matches[0]) > 0){
							$getEventDetail->content = str_replace($matches[0], $getEventDetail->content  , $themeContent);
						}

						$arrayAssignTemplate['EventDetail'] = $getEventDetail;
                        $arrayAssignTemplate['outofstockproductlist'] = $outofstockproductlist;
                        $arrayAssignTemplate['dataoutofstock'] = $dataoutofstock;
                        $arrayAssignTemplate['isoutofstock'] = $isoutofstock;
						$arrayAssignTemplate['keywordList'] = $keywordList;
						$arrayAssignTemplate['pageTitle'] = (!empty($getEventDetail->seotitle)?$getEventDetail->seotitle:$getEventDetail->title);
						$arrayAssignTemplate['pageKeyword'] = $getEventDetail->seokeyword;
						$arrayAssignTemplate['pageDescription'] = $getEventDetail->seodescription;
						$arrayAssignTemplate['header'] = $themeEvent->header;
						$arrayAssignTemplate['footer'] = $themeEvent->footer;
						$arrayAssignTemplate['headertext'] = $getEventDetail->topseokeyword;
						$arrayAssignTemplate['footerkey'] = $getEventDetail->footerkey;

						$this->registry->smarty->assign( $arrayAssignTemplate );
						$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'theme.tpl');
						if(!isset($_GET['outofstock']))
                        {
                            $myCache->set($pageHtml);
                        }

					}else {
							
						$arrayAssignTemplate['EventDetail'] = $getEventDetail;
                        $arrayAssignTemplate['isoutofstock'] = $isoutofstock;
                        $arrayAssignTemplate['dataoutofstock'] = $dataoutofstock;
                        $arrayAssignTemplate['outofstockproductlist'] = $outofstockproductlist;
						$arrayAssignTemplate['themeEvent'] = $themeEvent;
						$arrayAssignTemplate['keywordList'] = $keywordList;
							
						$this->registry->smarty->assign( $arrayAssignTemplate );
						$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'default.tpl');
						$this->registry->smarty->assign(
						array('contents' => $contents,
					                    'pageTitle' => (!empty($getEventDetail->seotitle)?$getEventDetail->seotitle:$getEventDetail->title),
					                    'pageKeyword' => $getEventDetail->seokeyword,
					                    'pageDescription' => $getEventDetail->seodescription,
										'headertext' => $getEventDetail->topseokeyword,
										'footerkey' => $getEventDetail->footerkey,
						)
						);
						$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
                        if(!isset($_GET['outofstock']))
                        {
                            $myCache->set($pageHtml);
                        }
					}
				}
				echo $pageHtml;
				//for View Tracking
				$_GET['trackingid'] = $_GET['id'];
			}else{
				header('HTTP/1.0 404 Not Found');
				readfile('./404.html');
				exit();
			}
		}else{
			header('HTTP/1.0 404 Not Found');
			readfile('./404.html');
			exit();
		}



	}
}
