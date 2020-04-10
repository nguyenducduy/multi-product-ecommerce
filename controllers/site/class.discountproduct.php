<?php

class Controller_Site_Discountproduct extends Controller_Site_Base{

	function indexAction(){
		$this->registry->smarty->assign(array(
			'discount' =>1,
		));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');

		$this->registry->smarty->assign(array('contents' => $contents,
													'pageTitle'                 => 'Hành trang chu đáo - khởi đầu hoàn hảo cùng dienmay.com',
                                                    'pageKeyword'               => 'khuyến mãi, tin khuyến mãi, dienmay.com',
                                                    'pageDescription'           => 'dienmay.com đang đồng hành cùng cuộc sống học sinh, sinh viên và đem lại những ưu đãi ở các nhu cầu như học hành, kết nối, ăn ở tại ký túc xá, giải trí... với ưu đãi lên đến 2 triệu đồng dành cho bạn - Cho Sinh Viên',
                                                    'pageMetarobots'           => 'index, follow',
		));
		$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index.tpl');
		echo $pageHtml;
	}

	function detailAction(){

		$cachefile = 'sitehtml_discountproduct';
		$myCache = new Cacher($cachefile);
		$pageHtml = '';
		if(isset($_GET['live'])){
			$myCache->clear();
		}
		else
		$pageHtml = $myCache->get();
		if(!$pageHtml)
		{
			$listDiscountProduct = array();
			$listDiscount = Core_DiscountProduct::getDiscountProducts(array('fstatus' => 1,'fnottype'=>3), 'displayorder', 'ASC');
			//var_dump($listDiscount);die;
			foreach ($listDiscount as $discount) {
				$listProduct = array();
				if($discount->listproduct != ''){
					$listProductID = explode(',', $discount->listproduct);
					foreach ($listProductID as $productID) {
						$product = new Core_Product($productID);
						if($product->status == Core_Product::STATUS_ENABLE){
							$listpromotions = Core_Promotion::getPromotionByProductIDFrontEnd(trim($product->barcode), $this->registry->region, $product->sellprice);

							if(!empty($listpromotions['listPromotions']))
							{
								$promotion = array();
								$gifts = array();
								foreach($listpromotions['listPromotions'] as $lpromo)
								{
									$checkPromotionAvailable = Core_Promotion::getPromotions(array('fisavailable' => 1, 'fid' =>$lpromo['promoid']),'','');
									if(!empty($checkPromotionAvailable)){
										$getPromotionGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoid' => $lpromo['promoid']),'discountvalue','DESC');
										if(!empty($getPromotionGroup)){
											foreach($getPromotionGroup as $gp)
											{
												$promoname = strip_tags(trim($lpromo['promoname']));
												if($promoname == '.' || $promoname =='-')
												{
													$promotion['promoid'] = $gp->promoid;
													if((int)$gp->isdiscountpercent > 0)
													{
														$promotion['percent'] = 1; //giảm giá theo tỉ lệ %
														$promotion['discountvalue'] = $gp->discountvalue;
													}
													else{
														$promotion['percent'] = -1; //giảm giá theo tien
														$promotion['discountvalue'] = $gp->discountvalue;
													}
												}elseif((int)$gp->discountvalue > 0)
												{
													if($promotion['discountvalue'] < $gp->discountvalue){
														$promotion['promoid'] = $gp->promoid;
														if((int)$gp->isdiscountpercent > 0)
														{
															$promotion['percent'] = 1; //giảm giá theo tỉ lệ %
															$promotion['discountvalue'] = $gp->discountvalue;
														}
														else{
															$promotion['percent'] = -1; //giảm giá theo tien
															$promotion['discountvalue'] = $gp->discountvalue;
														}
													}
													$gifts[$lpromo['promoid']] = strip_tags($lpromo['promoname']);
												}else{
													$gifts[$lpromo['promoid']] = strip_tags($lpromo['promoname']);
												}
											}
											$promoprice = '';
											if (!empty($promotion)) {
												if ($promotion['percent'] == 1) {
													$promoprice = round($product->sellprice - ($product->sellprice * $promotion['discountvalue'] / 100));
												}
												else {
													$promoprice = $product->sellprice - $promotion['discountvalue'];
												}

											}
											$product->promotionid =  $promotion['promoid'];
											$product->promotionprice = $promoprice;
											$product->discountvalue = $promotion['discountvalue'];
											$product->gifts = $gifts;
										}
									}
								}
							}
							$listProduct[] = $product;
						}
					}
				}
				$listDiscountProduct[] = array('id'=>$discount->id, 'discountname'=>$discount->discountname,'discountcombo'=>$discount->discountcombo,'amount'=> $discount->amount, 'type'=>$discount->type, 'listProduct'=>$listProduct) ;
				//var_dump($listProduct);
			}
			//var_dump($listDiscountProduct);die;
			//echodebug($listDiscountProduct, true);
				
			$colordiscount = array('htri', 'mtri', 'ntra', 'btra', 'batra', 'hatra');
			$colorpresent = array(50=>'namper', 40=>'bonper', 30=>'baper',20=>'haiper');
			$colorpresenticon = array(50=>'iconfty', 40=>'iconforty', 30=>'iconthrty',20=>'icontwety');
			$colorstudent = array('hoc-hanh'=>'learn', 'nha-tro'=>'motel', 'ket-noi'=>'connt','giai-tri'=>'enter');

			$this->registry->smarty->assign(array(
                                                      'listDiscountProduct' => $listDiscountProduct,
													  'colordiscount' =>$colordiscount,
													  'colorpresent' =>$colorpresent,
			 										  'colorpresenticon' =>$colorpresenticon,
													  'colorstudent' => $colorstudent,
			));

			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'detaildiscountproduct.tpl');

			$this->registry->smarty->assign(array('contents' => $contents,
													'pageTitle'                 => 'Hành trang chu đáo - khởi đầu hoàn hảo cùng dienmay.com',
                                                    'pageKeyword'               => 'khuyến mãi, tin khuyến mãi, dienmay.com',
                                                    'pageDescription'           => 'dienmay.com đang đồng hành cùng cuộc sống học sinh, sinh viên và đem lại những ưu đãi ở các nhu cầu như học hành, kết nối, ăn ở tại ký túc xá, giải trí... với ưu đãi lên đến 2 triệu đồng dành cho bạn - Cho Sinh Viên',
                                                    'pageMetarobots'           => 'index, follow',
			));
			$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index.tpl');
			$myCache->set($pageHtml);

		}
		echo $pageHtml;
	}
}