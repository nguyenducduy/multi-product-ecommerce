<?php

Class Controller_Site_Page Extends Controller_Site_Base
{
	function indexAction()
	{

	}

	function detailAction()
	{
		if(empty($_GET['id']))
		{
			header('Location: '.$this->conf['rooturl']);
			exit();
		}
		$subdomain = '';
        if(SUBDOMAIN == 'm'){
            $subdomain = SUBDOMAIN;
        }
		$cachefile = $subdomain.'sitehtml_pagedetail'.'_'.$_GET['id'];

		//$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['ProductpageExpire']);
		$myCache = new Cacher($cachefile);
		$pageHtml = $myCache->get();
		if(isset($_GET['live'])) {
			$pageHtml = '';
		}
		if(!$pageHtml)
		{
			$getPageDetail = new Core_Page($_GET['id']);
			if(empty($getPageDetail) || $getPageDetail->status == Core_Page::STATUS_DISABLED)
			{
				header('Location: '.$this->registry->conf['rooturl']);
				exit();
			}
			$arrayAssignTemplate = array();
			$themePage = '';

			if(!empty($getPageDetail->themeid))
			{
				$themePage = new Core_Pagetheme($getPageDetail->themeid);
			}

			//get keyword list
			$keywordList = array();

			$myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $getPageDetail->id, 'ftype' => Core_RelItemKeyword::TYPE_PAGE), '', '', '');

			foreach($myKeyword as $keyword)
			{
				$prebuild = new Core_Keyword($keyword->kid);

				$keywordList[] = $prebuild;
			}
			///////////PROCESS SHORTCUT DATA
			$content = $getPageDetail->content;
			preg_match_all('/\[[a-z0-9 =",\']+\]/', $content, $matches);
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
						$productid = str_replace(array('"' , '\''), '', $info[1]);
						$myProduct = new Core_Product((int)$productid , true);
						if ($myProduct->id > 0 && $myProduct->onsitestatus == Core_Product::OS_ERP && $myProduct->sellprice > 0)
						{
							////////////////////GET TEMPLATE OF BLOCK
							$blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'blockproduct.tpl');

							$promotioninfo = array();
							$getpromotion = null;
							$discount = 0;
							$promoiddiscount = 0;

							$finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($myProduct, $this->registry->region);
							if ($finalprice <= 0)
							$finalprice = $myProduct->sellprice;

							//get promotion
							$info = explode('=', $datalist[2]);
							$promostr = str_replace(array('"' , '\''), '', $info[1]);
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

							$this->registry->smarty->assign(array('productDetail' => $myProduct, 'promostr' => $promostrinfo , 'promoinfo' => $promoinfos , 'finalprice' => $finalprice, 'promoid' => $promoid, 'programid' => $programid));
							$blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'blockproduct.tpl');
							$getPageDetail->content = str_replace($matcher, $blockhtml , $getPageDetail->content);
								
								
						}
						else{
							$getPageDetail->content = str_replace($matcher, '' , $getPageDetail->content);
						}//end of if

					}
				}//end of foreach
			}
			///////////////////////////////////
			$arrayAssignTemplate['pageDetail'] = $getPageDetail;
			$arrayAssignTemplate['themePage'] = $themePage;
			//$arrayAssignTemplate['hideMenu'] = 1;
			$arrayAssignTemplate['barnerPage'] = $this->getBanner(7);
			$arrayAssignTemplate['keywordList'] = $keywordList;

			$this->registry->smarty->assign( $arrayAssignTemplate );
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'pagedetail.tpl');
			$this->registry->smarty->assign(
			array('contents' => $contents,
                    'pageTitle' => (!empty($getPageDetail->seotitle)?$getPageDetail->seotitle:$getPageDetail->title),
                    'pageKeyword' => $getPageDetail->seokeyword,//van de khi cache
			//'hideMenu' => 1,
                    'pageDescription' => $getPageDetail->seodescription,
                    'pageMetarobots'  => $getPageDetail->slug=='doanh-nghiep'?'noindex, nofollow':'index, follow',
			)
			);
			$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
			$myCache->set($pageHtml);
		}
		echo $pageHtml;
		//for View Tracking
		$_GET['trackingid'] = $_GET['id'];

	}
	private function getBanner($fazid = 7, $ftype = Core_Ads::TYPE_BANNER)
	{
		$formData['fazid'] = $fazid; //Dienmay Homepage
		$formData['ftype'] = $ftype;
		$formData['fisactive'] = 1;
		return Core_Ads::getAdss($formData, '', 'DESC', 6);
	}

	public function pagepopupAction()
	{
		if(!empty($_GET['id']))
		{
			$id = (int)$_GET['id'];
			if($id<=0)
			{
				?>
<script>parent.location.href="<?php echo $this->registry->conf['rooturl'];?>";</script>
				<?php
				exit();
			}
			$cachefile = 'sitehtml_pagedetailpopup'.'_'.$id;

			//$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['ProductpageExpire']);
			$myCache = new Cacher($cachefile);
			$pageHtml = $myCache->get();
			if(isset($_GET['live'])) {
				$pageHtml = '';
			}
			if(!$pageHtml)
			{
				$getPageDetail = new Core_Page($id);
				if(empty($getPageDetail) || $getPageDetail->status == Core_Page::STATUS_DISABLED)
				{
					?>
<script>parent.location.href="<?php echo $this->registry->conf['rooturl'];?>";</script>
					<?php
					exit();
				}
				$arrayAssignTemplate = array();
				$themePage = '';

				if(!empty($getPageDetail->themeid))
				{
					$themePage = new Core_Pagetheme($getPageDetail->themeid);
				}
				$arrayAssignTemplate['pageDetail'] = $getPageDetail;

				$this->registry->smarty->assign( $arrayAssignTemplate );
				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'pagedetailpopup.tpl');
				$this->registry->smarty->assign(
				array('contents' => $contents,
                        'pageTitle' => (!empty($getPageDetail->seotitle)?$getPageDetail->seotitle:$getPageDetail->title),
                        'pageKeyword' => $getPageDetail->seokeyword,//van de khi cache
				//'hideMenu' => 1,
                        'pageDescription' => $getPageDetail->seodescription,
				)
				);
				$pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
				$myCache->set($pageHtml);
			}
			echo $pageHtml;
		}
	}
}
