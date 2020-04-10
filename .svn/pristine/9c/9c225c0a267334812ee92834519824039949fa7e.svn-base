<?php
Class Controller_Site_Productsegment Extends Controller_Site_Base
{
    public function indexAction() 
    {      
    }
    
    /**
     * 
     */
    public function indexajaxAction()
    {
    	if ( !empty($_SERVER['HTTP_REFERER']) )
    	{
    		$productidlist = array();
	       	$promotionlist = array();
	       	$idstr = (string)$_POST['id'];
	       	$arrayReturn = array();
		    //explode to get id of product and promotion list
		    if(strlen($idstr) > 0)
		    {
		    	$idlist = explode('#', $idstr);   
		    	if(count($idlist) > 0)
		    	{
		    		foreach ($idlist as $data) 
		    		{
		    			if(strlen($data) > 0)
		    			{
		    				$datainfo = explode(':', $data);
		    				$idhtml = $datainfo[0];
							$pid = (int)substr($idhtml, 2);
							$myProduct = new Core_Product( $pid, true);
							if ($myProduct->id > 0)
							{
								$promotioninfo = array();
								$getpromotion = null;
								$discount = 0;
								$promoiddiscount = 0;
								$finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($myProduct, $this->registry->region);
								
								if ($finalprice <= 0) $finalprice = $myProduct->sellprice;
								
								if (!empty($datainfo[1]))
								{
									$listidpromoarr = explode(',', $datainfo[1]);
									$promotioninfo = Core_Promotion::getPromotions(array('fisavailable' => 1, 'fidarr' => $listidpromoarr, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','','');
									$getpromotion = Core_Promotion::getFirstDiscountPromotionByListId($listidpromoarr, $this->registry->region);
								}
								else
								{
									$promotioninfo = Core_Promotion::getPromotionByProductIDFrontEnd(trim($myProduct->barcode), $this->registry->region, $finalprice);
									$getpromotion = Core_Promotion::getFirstDiscountPromotion(trim($myProduct->barcode), $this->registry->region);
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
				                
								$this->registry->smarty->assign(array('productDetail' => $myProduct, 'finalprice' => $finalprice, 'discount' => $discount, 'promoiddiscount' => $promoiddiscount, 'promoinfo' => $promotioninfo ,));
                				$blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'loadproductinfo.tpl');
                				$arrayReturn[] = array('id' => $idhtml, 'block' => $blockhtml);
							}
		    			}//end of if
		    		}		    		

		    	}
		    	header('Content-Type: application/json');
				echo json_encode(array('data' => $arrayReturn));		    	
		    }
    	}//end of if
    }//end of function
}