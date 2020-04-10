<?php

Class Controller_Site_Price Extends Controller_Site_Base
{

	function indexAction()
	{
		if (!empty($_SERVER['HTTP_REFERER']))
		{
			$pidList = array();

			if(isset($_POST['id']) && strlen($_POST['id']) > 0)
				$pidList = explode(',', $_POST['id']);


			///////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////
			//EXTRACT PRODUCT LIST BEFORE SEARCH PRICE INFORMATION FOR EACH PRODUCT
			//Array store the product id and barcode check
			$productList = array();
			$promotionList = array();
			if(!empty($pidList) && is_array($pidList) && count($pidList) < 501)
			{
				foreach($pidList as $itemlist)
				{
					$explodeitem = explode('#', $itemlist);
					if (!empty($explodeitem[0]))
					{
						$pidraw = $explodeitem[0];
						$pid = substr($pidraw, 0, -5);
						$check= substr($pidraw, -5);

						if($pid > 0 && $check != '' && !isset($productList[$pid]))
						{
							$productList[$pid] = array('id' => $pid, 'check' => $check, 'rawid' => $pidraw);
							if (!empty($explodeitem[1]))
							{
								$promoproduct 			= explode(':', $explodeitem[1]);
								if (count($promoproduct) < 11) $promotionList[$pid] 	= $promoproduct;
							}
						}
					}
					unset($explodeitem);
				}
			}

			///////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////
			//EXTRACT PRODUCT LIST BEFORE SEARCH PRICE INFORMATION FOR EACH PRODUCT
			//Array store the price information about a product
			
			$arrayreturn = array();
			if (count($productList) < 501)
			{
				$priceList = array();				
				//TODO...
				$subdomain = '';
				if(SUBDOMAIN == 'm');
					$subdomain = SUBDOMAIN;
				foreach($productList as $pid => $productinfo)
				{
					$myCacher = new Cacher($subdomain.'sitehtm_price_'.$pid, Cacher::STORAGE_MEMCACHED);
					//echo $subdomain.'sitehtm_price_'.$pid;
					$getproductcache = $myCacher->get();
					if (!empty($getproductcache) || isset($_POST['live']))
					{
						$priceList[] = json_decode($getproductcache, TRUE);
					}
					else
					{
						$myProduct = new Core_Product($pid, true);
						$plast5cbarcode = substr(trim($myProduct->barcode), -5);
						if ($myProduct->id > 0 && $plast5cbarcode == $productinfo['check'])
						{
							$finalprice = 0;
							if ($myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID && $myProduct->prepaidprice > 0 && $myProduct->prepaidstartdate <= time() && $myProduct->prepaidenddate >= time())
							{
								$finalprice = $myProduct->prepaidprice;
							}
							else
							{
								$finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($myProduct, $this->registry->region);
								if ($finalprice < 10)
								{
									$finalprice = $myProduct->sellprice;
								}
							}				
							
							$discount = 0;
							$isdiscount = 0;
							if ($myProduct->displaysellprice != 1)
							{
								$getpromotion = null;
								if (!empty($promotionList[$myProduct->id]))
								{
									$getpromotion = Core_Promotion::getFirstDiscountPromotionByListId($promotionList[$myProduct->id], $this->registry->region);
								}
								else
								{
									$getpromotion = Core_Promotion::getFirstDiscountPromotion(trim($myProduct->barcode), $this->registry->region);//$myProduct->promotionPrice();
								}
								
				                if(!empty($getpromotion))
				                {
				                    if ($getpromotion['percent'] == 1)
				                    {
										$discount = $finalprice - ($finalprice * $getpromotion['discountvalue']/100);
				                    }
				                    else
				                    {
										$discount = $finalprice - $getpromotion['discountvalue'];
				                    }
				                }
							}

                            $percent = 0;
			                if ($discount <= 0 ) $discount = $finalprice;
			                else
							{								
								$isdiscount = 1;
								//CACULATE PERCENT
                                $percent = floor(($finalprice - $discount) * 100  / $finalprice);
							}

			                $discount = Helper::formatPrice($discount);						   							
							
							if ( $finalprice >0 )
							{
								$savepriceitem = array('id' => $productinfo['rawid'], 'sell' => Helper::formatPrice($finalprice), 'discount' => $discount, 'percent' => $percent ,'isdiscount' => $isdiscount);
				                //cacher
				                $myCacher->set(json_encode($savepriceitem), 30);
				                
				                $priceList[] = $savepriceitem;
							}			                
			                
			                unset($savepriceitem);
			                unset($discount);
			                unset($getpromotion);
			                unset($finalprice);
						}
						unset($plast5cbarcode);
						unset($myProduct);
					}
				}
				unset($productList);

				///////////////////////////////////////////////////////////////////
				///////////////////////////////////////////////////////////////////
				/*//Output XML
				header('content-type: text/xml');
				echo '<?xml version="1.0" encoding="utf-8"?><result>';
				foreach($priceList as $priceinfo)
				{
					echo '<price><id>'.$priceinfo['id'].'</id><sell>'.$priceinfo['sell'].'</sell><discount>'.$priceinfo['discount'].'</discount></price>';
				}
				echo '</result>';*/
				
				//Out put Json
				
				foreach($priceList as $priceinfo)
				{
					$itemreturn = array();
					$itemreturn['id']			= $priceinfo['id'];
					$itemreturn['sell']			= $priceinfo['sell'];
					$itemreturn['discount']		= $priceinfo['discount'];
                    $itemreturn['percent']      = $priceinfo['percent'];
					$itemreturn['isdiscount']	= $priceinfo['isdiscount'];
					$arrayreturn[]				= $itemreturn;
				}
			}			
			header('Content-Type: application/json');
			echo json_encode(array('data' => $arrayreturn));
		}		
	}

	
}


