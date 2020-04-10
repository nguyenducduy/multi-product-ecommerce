<?php

    Class Controller_Site_Index Extends Controller_Site_Base
    {
        /**
         * Su dung landing page ma thoi
         *
         */
        function tinyindexAction()
        {

            if (isset($_GET['start'])) {
                $this->indexstartAction();
                exit();
            }

            if ($this->registry->me->id > 0) {
                header('location: ' . $this->registry->me->getUserPath() . '/home');
                exit();

                /*
                //neu chua hien quote index nao thi hien, con da hien 1 lan roi thi redirect qua home luon
                if(!isset($_SESSION['quotehomepage']))
                {
                    //tim quote id max
                    $maxQuote = Core_Quote::maxQuote();
                    $randomQuoteId = rand(1, $maxQuote);
                    $myQuote = new Core_Quote($randomQuoteId);
                    $this->registry->smarty->assign(
                            array('myQuote' => $myQuote,
                                    'redirect' => $this->registry->me->getUserPath() . '/home'
                            )
                        );
                    $_SESSION['quotehomepage'] = 1;
                    echo $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'homeredirect.tpl');

                }
                else
                {
                    header('location: ' . $this->registry->me->getUserPath() . '/home');
                    exit();
                }
                */


            }
            else {
                //$myCache = new cache('homepage.html', $this->registry->setting['cache']['site'], $this->registry->setting['cache']['homepageExpire']);
                $pageHtml = ''; //$myCache->get();
                /*if(!$pageHtml)
                {

                    $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

                    //save to cache
                    $myCache->save($pageHtml);
                }*/

                //replace register token
                //get token for form
                $_SESSION['userRegisterToken'] = Helper::getSecurityToken();
                $pageHtml                      = str_replace('###TOKEN###', $_SESSION['userRegisterToken'], $pageHtml);

                echo $pageHtml;
            }


        }

        /**
         * Frontpage of the app
         */
        function mobilestartAction()
        {

            $from = $_GET['from'];
            if ($from == 'ios') {

            }
            elseif ($from == 'windowsphone') {

            }
            elseif ($from == 'android') {

            }

            setcookie('onmobile', $from, time() + 14 * 24 * 3600, '/');
            //$this->indexAction();

            $this->registry->smarty->display($this->registry->smartyControllerContainer . 'mobilestart.tpl');
        }

        function forcedesktopAction()
        {
            setcookie('forcedesktop', time(), time() + 14 * 24 * 3600, '/', '.reader.vn'); //!important, set the Domain of cookie to .reader.vn to desktop version regconize the cookie
            header('location: http://reader.vn');
        }


        /**
         * Trang homepage cu, co day du va nhieu thong tin
         *
         */
        function indexAction()
        {
			global $protocol;
			$listcache = false;
			if(isset($_SESSION['idCrmCustomer']))
			{
				$cache     = new Cacher('rmc:0983328308' /*.$this->registry->me->phone*/ , Cacher::STORAGE_MEMCACHED);
				$listcache = $cache->get();
			}

			$listproductrecommend = array();
			if($listcache)
			{
				$listproductidrecommend = explode(',', $listcache);
				if(count($listproductidrecommend) > 0)
				{
					foreach ($listproductidrecommend  as $pid)
					{
						if((int)$pid > 0)
						{
							$myProduct = new Core_Product($pid , true);
							$listproductrecommend[] = $myProduct;
						}
					}
				}
			}
		 	$recommenditemcolorlist = array();
            $recommenditemcolorlisttmp = array();
            if(count($listproductrecommend) > 0)
            {
	            foreach ($listproductrecommend as $keyitem => $recommenditem) {
	            	//Loop top item list get color if exsist
	            	$topitemcolorlisttmp = explode("###", $recommenditem->colorlist);
		            foreach ($topitemcolorlisttmp as $recommendproductcolor) {
		                $topitemcolorlist[$recommenditem->id][] = explode(':', $recommendproductcolor);
		            }
				}
			}
			//echodebug($recommenditemcolorlist);
            /*$arrCon = array();
            $arrCon['foriginatestoreregionid'] = 3;
            $arrCon['ffromdate'] = '1364344741';
            $arrCon['ftodate'] = '1364348701';

            var_dump(Core_Archivedorder::getArchivedorders($arrCon,'','','',false,true));*/
            /*xu ly luu subcriber*/

            $formData["login"] = false;
            $subdomain = '';
            if(SUBDOMAIN == 'm')
                $subdomain = SUBDOMAIN;
            $cachefile         = $protocol.$subdomain.'sitehtml_homepage'.'_'.$this->registry->region;
            $formData['error'] = "display:none";

            $formData['ffullname'] = $this->registry->me->fullname;
			$formData['femail']    = $this->registry->me->email;
			$formData['fphone']    = $this->registry->me->phone;
            //$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['homepageExpire']);
            $myCache = new Cacher($cachefile);

            if(isset($_GET['live'])) {
                $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
                if(!empty($listregion))
                {
                    foreach($listregion as $ritem)
                    {
                        $cachefile1 = $protocol.$subdomain.'sitehtml_homepage'.'_'.$ritem->id;
                        $removeCache1 = new Cacher($cachefile1);
                        $removeCache1->clear();
                    }
                }
                $pageHtml = '';
            }
            else $pageHtml = $myCache->get();

            if (!$pageHtml) {
                //Điện thoại - Máy tính bảng  1783: 42,522
                //Thiết bị văn phòng: 1282: 44,402,442,862,902
				//Dien tu: 102: 103, 125, 144, 164, 165
				//Kỹ thuật số: 48: 49,53,682,1302
				//Gia dụng: 462: 242,262,263,282,323
				//Điện lạnh: 122: 123,142,166,182
				//Loa: 1782: 144, 382, 1442
				//Phụ kiện: 482: 68,66,702,782
				$listCategoriesIds = array(1783, 1282, 102, 48, 462, 122,1782,482);
				$listCategoriesIcon = array(1783 => array('icon' => '<i class="icon-mobile"></i>', 'id' => 'mobile'),
											1282 => array('icon' => '<i class="icon-laptop"></i>', 'id' => 'laptop'),
											102 => array('icon' => '<i class="icon-electro"></i>', 'id' => 'electro'),
											48 => array('icon' => '<i class="icon-camera"></i>', 'id' => 'camera'),
											462 => array('icon' => '<i class="icon-giadung"></i>', 'id' => 'giadung'),
											122 => array('icon' => '<i class="icon-refri"></i>', 'id' => 'refri'),
											1782 => array('icon' => '<i class="icon-loa"></i>', 'id' => 'loa'),
											482 => array('icon' => '<i class="icon-accessories"></i>', 'id' => 'accessories'),
											);

                //LAY DANH MUC CON GAN NHAT CUA CAC NGANH HANG CHA
                $subcatdatalist = array();
                foreach($listCategoriesIds as $catid)
                {
                    $subcatlist = Core_Productcategory::getFullSubCategoryFromCache($catid, 1, false, $subdomain);
                    $subcatdatalist[$catid] = $subcatlist;
                }

				$listCategories = array();
                $blockhomepagelist = array();
                $blockbannerrightlist = array();
				//$listProductsByCategory = array(1783 => array(), 1282 => array(), 102 => array(), 48 => array(), 462 => array(), 122 => array(), 1782 => array(), 482 => array());
				$listProductsByCategory = Core_Homepage::getRootCategoryHomepage();
				$listsubcat = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_PRODUCT, 'fcategoryarr' => $listCategoriesIds), 'id', 'ASC');
                $currentTime = time();
				if(!empty($listsubcat)){
					foreach($listsubcat as $subcat){
						$amaincate = new Core_Productcategory($subcat->category, true);
						if(!empty($subcat->subcategory) && !empty($amaincate->id)){
                            $listsubid = array($amaincate->id);
                            if(SUBDOMAIN == 'm')
                            {
                            	$listsubid =  explode(',', $subcat->subcategory);
                            }
                            else
                            {
								$listsubid = array_merge($listsubid , explode(',', $subcat->subcategory));
							}
							if(!empty($listsubid)){
								foreach($listsubid as $subid){
									//echo '<br />HTML: '.$subid;
									$myCategory = new Core_Productcategory($subid, true);
									if($myCategory->id > 0){
										$listproductofsubcate = array();
										$productids = explode(',', $myCategory->producthomepagelist);
										//$counterbreak = 0;
										if(!empty($productids)){
											foreach($productids as $keybreak=>$itpid){
												$pro = new Core_Product($itpid, true);
                                                //Core_Product::OS_ERP
												if($pro->id > 0 && $pro->status == Core_Product::STATUS_ENABLE && $pro->onsitestatus >0 && $pro->customizetype == Core_Product::CUSTOMIZETYPE_MAIN  && (($pro->sellprice > 0 && $pro->instock > 0) || ($pro->prepaidprice > 0 && $pro->prepaidstartdate <= $currentTime && $pro->prepaidenddate >= $currentTime) || $pro->onsitestatus == Core_Product::OS_COMMINGSOON) )
					                            {
					                                //if($keybreak == 10) break;                                                   					                                                                                    
                                                    if($myCategory->parentid == 0) {                                                        
                                                        $productcategory = new Core_Productcategory($pro->pcid , true);
                                                        if($productcategory->appendtoproductname == 1) {
                                                            $pro->name = $productcategory->name . ' ' . $pro->name;
                                                        }
                                                    }
                                                    else {
                                                        if ($myCategory->appendtoproductname == 1) $pro->name = $myCategory->name.' '.$pro->name;
                                                    }

					                                //tinh lai gia cho san pham
					                                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);

					                                if ($finalprice > 0) {
					                                    $pro->sellprice = ($finalprice);
					                                }
					                                //$pro->sellprice =  $finalprice;

					                                //$pro->summary = $newsummary;
					                                if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){

														$getProductBannerVer = Core_Ads::getBannerListByProuctId($pro->id, 'v');
														$getProductBannerHor = Core_Ads::getBannerListByProuctId($pro->id, 'h');
														if(!empty($getProductBannerVer) && $pro->displaytype == Core_Product::DISPLAY_BANNER){
															$myCategory->havedisplaytype = 1;
															$pro->productspecial = $getProductBannerVer[0];//->getImage()
														}
														elseif(!empty($getProductBannerHor) && $pro->displaytype == Core_Product::DISPLAY_TEXT){
															$myCategory->havedisplaytype = 1;
															$pro->productspecial = $getProductBannerHor[0];//->getImage()
															/*$newsummary = '';
									                        $explodenewsummary = explode("\n",strip_tags($pro->summary));//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
									                        if(!empty($explodenewsummary) && count($explodenewsummary) > 1){
									                            $cnt = 0;
									                            foreach($explodenewsummary as $suma){
									                                $suma = strip_tags(htmlspecialchars_decode($suma));
									                                $suma = trim(preg_replace( '/[\s]+/mu', " ",$suma));
									                                if(!empty($suma))
									                                {
									                                    if(substr($suma,0,1) =='-') $suma = trim(substr($suma,1));
									                                    if(!empty($suma) && $suma !='-'){
									                                        if($cnt++==3) break;
									                                        $newsummary .= '<span>››'.$suma.'</span>';
									                                    }
									                                }
									                            }
									                        }
									                        else{
																$newsummary = str_replace(array('<p>', '</p>'), array('<span>››', '</span>'), $pro->summary);
									                        }
									                        $pro->summary = $newsummary;*/
														}
					                                }
					                                $newsummary = '';
									                $explodenewsummary = explode("\n",strip_tags($pro->summary));//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
									                if(!empty($explodenewsummary) && count($explodenewsummary) > 1){
									                    $cnt = 0;
									                    foreach($explodenewsummary as $suma){
									                        $suma = strip_tags(htmlspecialchars_decode($suma));
									                        $suma = trim(preg_replace( '/[\s]+/mu', " ",$suma));
									                        if(!empty($suma))
									                        {
									                            $suma = trim($suma);
									                            if(substr($suma,0,1) =='-') $suma = trim(substr($suma,1));
									                            if(!empty($suma) && $suma !='-'){
									                                if($cnt++==3) break;
									                                $newsummary .= '<span>›› '.$suma.'</span>';
									                            }
									                        }
									                    }
									                }
									                else{
														$newsummary = str_replace(array('<p>', '</p>'), array('<span>›› ', '</span>'), $pro->summary);
									                }
									                $pro->summary = $newsummary;

					                                //get 5 gallery
					                                $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid' => $pro->id,
					                                                                                              'ffilenotnull' => 1,
					                                                                                              'ftype' => Core_ProductMedia::TYPE_FILE), '', '', 5);
					                                $listproductofsubcate[] = $pro;

					                                $counterbreak++;
                                                    if(SUBDOMAIN == 'm')
                                                    {
                                                        break;
                                                    }
					                            }
											}
										}
										//echodebug('FILTER '.count($listproductofsubcate));
										//if product is available
										if(!empty($listproductofsubcate)){
											$listProductsByCategory[$subcat->category][$subid] = array('category' => $myCategory, 'products' => $listproductofsubcate);

										}
									}
								}
								$listCategories[$subcat->category] = $amaincate;
							}
						}
                        $blockhomepagelist[$amaincate->id] = $subcat->blockhomepage;
                        $blockbannerrightlist[$amaincate->id] = $subcat->blockbannerright;
					}
				}
				//Get list color product
				//echodebug($listProductsByCategory);
				$listProductColor = array();
	            $listProductCateColorTmp = array();
				foreach ($listProductsByCategory as $listProductCate) {
					foreach ($listProductCate as $key => $listProductC) {
						foreach ($listProductC['products'] as $listProductCateColor) {
		                	//Loop top item list get color if exsist
		                	$listProductCateColorTmp = explode("###", $listProductCateColor->colorlist);
		                	//echodebug($listProductCateColorTmp);
				            foreach ($listProductCateColorTmp as $key => $productColor) {
				                $listProductColor[$listProductCateColor->id][$key] = explode(':', $productColor);
				            }

						}
					}
				}
				//End get list color product
				//get crazy deal product
				$crazydeals = Core_Crazydeal::getCrazydeals(array('fisactive'=>1,'fstatus'=>Core_Crazydeal::STATUS_ENABLE),'id','DESC');
				$crazydealproduct = null;
				if(count($crazydeals) > 0)
				{
					$crazydealproduct = $crazydeals[0];
					$myProduct = new Core_Product($crazydealproduct->pid , true);
					$crazydealproduct->pcid =  $myProduct->pcid;
				}


                $this->registry->smarty->assign(array('slidebanner' => $this->getBanner(),
                                                      'slidebannermobile' => $this->getBannerMobile(),
                                                      'crazydealproduct' => $crazydealproduct,

                                                      'rightbanner' => $this->getBanner(5),
                                                      'textbanner' => $this->getBanner(1, Core_Ads::TYPE_TEXTONLY),));


                $banner = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'banner.tpl');

                $listPromotionProductIds = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_PROMOTION), 'id', 'ASC');

                if (count($listPromotionProductIds) > 0) {
                    foreach ($listPromotionProductIds as $listPromotionProductId) {
                        $listid = explode(',', $listPromotionProductId->listid);
                        $numberlistid = count($listid);
                        for ($i = 0; $i < $numberlistid; $i++) {
                            $product = new Core_Product($listid[$i], true);
                            if ($product->id > 0 && $product->status == Core_Product::STATUS_ENABLE && $product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN && /*$product->sellprice > 0 &&*/ $product->onsitestatus > 0) {
                                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($product->barcode, $this->registry->region);
                                if ($finalprice > 0) {
                                    $product->sellprice = $finalprice;
                                }
                                $myCategory  = new Core_Productcategory($product->pcid, true);
								if ($myCategory->appendtoproductname == 1) $product->name = $myCategory->name.' '.$product->name;
                                $promoprice = 0;
                                $promotion  = Core_Promotion::getFirstDiscountPromotion($product->barcode, $this->registry->region);

                                if (!empty($promotion)) {
                                    if ($promotion['percent'] == 1) {
                                        $promoprice = round($product->sellprice - ($product->sellprice * $promotion['discountvalue'] / 100));
                                    }
                                    else {
                                        $promoprice = $product->sellprice - $promotion['discountvalue'];
                                    }
                                    $product->promotionid = $promotion['promoid'];
                                }

                                $newsummary = '';
                                $explodenewsummary = explode("\n", strip_tags($product->summary)); //Helper::xss_replacewithBreakline(strip_tags($pro->summary));
                                if (!empty($explodenewsummary)) {
                                    $cnt = 0;
                                    foreach ($explodenewsummary as $suma) {
                                        $suma = strip_tags(htmlspecialchars_decode($suma));
                                        $suma = trim(preg_replace('/[\s]+/mu', " ", $suma));
                                        if (!empty($suma)) {
                                            if (substr($suma, 0, 1) == '-') {
                                                $suma = trim(substr($suma, 1));
                                            }
                                            if (!empty($suma) && $suma != '-') {
                                                if ($cnt++ == 3) {
                                                    break;
                                                }
                                                $newsummary .= '<span>' . $suma . '</span>';
                                            }
                                        }
                                    }
                                }
                                $product->summary        = $newsummary;
                                $product->promotionprice = $promoprice;
                                $listPromotion[]         = $product;
                            }
                            //$product->sellprice = Helper::refineMoneyString($product->sellprice);
                        }
                    }
                }
                if(count($listPromotion) > 0)
                {
                	$listPromotionColor = array();
	                $listPromotionTmp = array();
	                foreach ($listPromotion as $keypromotion => $promotionitem) {
	                	//Loop top item list get color if exsist
	                	$listPromotionTmp = explode("###", $promotionitem->colorlist);
			            foreach ($listPromotionTmp as $productPromotionColor) {
			                $listPromotionColor[$promotionitem->id][] = explode(':', $productPromotionColor);
			            }
					}
                }
                //LAY TOP SAN PHAM BAN CHAY
                $topitemlist = Core_Homepage::getTopitemlist();
                //Get color list
                if(count($topitemlist) > 0)
                {
	                $topitemcolorlist = array();
	                $topitemcolorlisttmp = array();
	                foreach ($topitemlist as $keyitem => $topitem) {
	                	//Loop top item list get color if exsist
	                	$topitemcolorlisttmp = explode("###", $topitem->colorlist);
			            foreach ($topitemcolorlisttmp as $colorkey => $productcolor) {
			                $topitemcolorlist[$topitem->id][] = explode(':', $productcolor);
			            }
					}
				}
				//End get Color list

                /*
                //load tin duoc set trong danh muc
                $listNewsIds = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_NEWS), 'id', 'ASC');
                $listNews    = null;
                if (!empty($listNewsIds)) {
                	$listNewsId = array();
                    foreach ($listNewsIds as $lnid) {
                        $listid     = explode(',', $lnid->listid);
                        if (!empty($listid)) {
                            foreach ($listid as $lid) {
                                if (!empty($lid) && !in_array($lid, $listNewsId)) {
                                    $listNewsId[] = $lid;
                                }
                            }
                        }
                    }
                    if (!empty($listNewsId)) {
                        $newsPromotion = array_slice($listNewsId, 0, 4);
                        $newsNormal    = array_slice($listNewsId, 4);
                        if (!empty($newsPromotion)) {
                            $listNews['promotion'] = Core_News::getNewss(array('fidarr' => $newsPromotion), '', '');
                        }
                        if (!empty($newsNormal)) {
                            $listNews['normal'] = Core_News::getNewss(array('fidarr' => $newsNormal), '', '');
                        }
                    }
                }*/
                //load tin moi nhat
                $listNews    = array();//187:  	Khuyến mãi, 114:  	Sản phẩm công nghệ
                // $listNews['promotion'] = Core_News::getNewss(array('fncid' => 112, 'fstatus' => Core_News::STATUS_ENABLE), 'id', 'desc', 4);
                // $listNews['normal'] = Core_News::getNewss(array('fncid' => 114, 'fstatus' => Core_News::STATUS_ENABLE), 'id', 'desc', 4);
                $listNews['normal'] = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE), 'id', 'desc', 3);

                //load footer page
                $experince = new Core_Page(80, true);// trai nghiem mua sam tai dien may
				$this->registry->smarty->assign(array('banner' => $banner,
                                                      'formData' => $formData,
                                                      'listnews' => $listNews,
                                                      'sidebarhome' => $this->getBanner(2),
                                                      'listProductsByCategory' => $listProductsByCategory,
                                                      'listPromotions' => $listPromotion,
                                                      'listCategories' => $listCategories,
                                                      'listCategoriesIcon' => $listCategoriesIcon,
                                                      'topitemlist' => $topitemlist,
                                                      'subcatdatalist' => $subcatdatalist,
                                                      'hideMenu' => 1,
                                                      'currentTime'           	=> time(),
                                                      'internaltopbar_editurl'  => $this->registry->conf['rooturl'].'cms/product/edit/id/'.$fpid.'/',
                                                    'internaltopbar_refreshurl' => $internaltopbar_refreshurl,
                                                    'internaltopbar_reporturl'  => $this->registry->conf['rooturl'] . 'stat/report/company',
                                                    'internaltopbar_objectid'   => -1,
                                                    'experince' => $experince,
                                                    'blockhomepagelist' => $blockhomepagelist,
                                                    'blockbannerrightlist' => $blockbannerrightlist,
                                                    'listproductrecommend' => $listproductrecommend,
                                                    'topitemcolorlist'	    => $topitemcolorlist,
                                                    'listPromotionColor'    => $listPromotionColor,
                                                    'listProductColor'		=> $listProductColor,
                                                    'recommenditemcolorlist' => $recommenditemcolorlist,
                								));

				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'indexstart.tpl');

				$this->registry->smarty->assign(array('contents' => $contents));

                $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index.tpl');
                $myCache->set($pageHtml);
            }
            /*save to cache*/

            echo $pageHtml;
        }

        function initxajaxAction()
        {
            $output = '';

            if (!empty($_SERVER['HTTP_REFERER']) && !empty($_POST['url']))
            {
				$formData = array();
				//Userlogin
				if ($this->registry->me->id > 0) {
					$me = new Core_User($this->registry->me->id);
					$this->registry->me = $me;
					$formData['upvip']    = '0';
				    $formData["login"]    = true;
				    $formData["username"] = $this->registry->me->fullname;

				    $name      = explode(' ', $formData['username']);
				    $countname = count($name);
				    if ($countname >= 3) {
				        $formData['username'] = $name[$countname - 2] . " " . $name[$countname - 1];
				    }
					// bao la da la vip chua
					if($this->registry->me->personalid!='0')
						$formData['upvip'] = '1';


					$formData['idbookmark'] = base64_encode('dienmay.com-' . $this->registry->me->id);
				    $this->registry->smarty->assign(array('formData' => $formData,
				                                          'regionname' => $this->registry->setting['region'][$this->registry->me->city!='' ? $this->registry->me->city : $this->registry->region],));
				    $str = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'loginbanner.tpl');
				    $output .= '<logindata><![CDATA['.$str.']]></logindata>';

				    //permission
				    if ($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer') || $this->registry->me->isGroup('employee') )
				    {
						$output .= '<initfunction>1</initfunction>';
				    }
				}

				$urlex = explode("redirect", $_POST['url']);
                $str   = base64_encode($urlex[0]);
				$output .= '<loginlink><![CDATA['.$str.']]></loginlink>';

				//load cart ajax
				$cartpricetotal = 0;
				$totalproduct = 0;
		        $this->cartfirstpricetotal = 0;
		        $this->cartItems = $this->registry->cart->getContents();
		        $numberofcarts = count($this->cartItems);
		        if($numberofcarts > 0)
		        {
		            //Kieemr tra coi ton kho da het
		            for($i = 0; $i < $numberofcarts; $i++)
		            {
		                $this->cartItems[$i]->product = new Core_Product($this->cartItems[$i]->id, true);
		                //$this->cartItems[$i]->product->sellprice = Helper::refineMoneyString($this->cartItems[$i]->product->sellprice);
			            if($this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
						{
							$productMain = Core_Product::getMainProductFromColor($this->cartItems[$i]->product->id);
							if(!empty($productMain))
							{
								 //============================= Lay mau san pham ===================================
									$productcolortmp = explode("###", $productMain->colorlist);

						            foreach ($productcolortmp as $colorkey => $productcolor) {
						                $productcolorlist = explode(':', $productcolor);
						                if($productcolorlist[0] == $this->cartItems[$i]->product->id){

						                	$this->cartItems[$i]->product->name = $productcolorlist[1]. ' - ' . $productcolorlist[2];
						                }
						            }

					            //============================= End Lay mau san pham ==================================

								//$productDetail->displaysellprice = $productMain->displaysellprice;
								$this->cartItems[$i]->product->status  = $productMain->status;
								if($this->cartItems[$i]->product->slug == '')
									$this->cartItems[$i]->product->slug = $productMain->slug;
								if($this->cartItems[$i]->product->pcid <= 0)
									$this->cartItems[$i]->product->pcid = $productMain->pcid;
								if(!$this->cartItems[$i]->product->checkimagevalid($this->cartItems[$i]->product->getSmallImage())){
									$this->cartItems[$i]->product->image = $productMain->image;
									$this->cartItems[$i]->product->resourceserver =$productMain->resourceserver;
								}
							}
						}else{

								 //============================= Lay mau san pham chinh ===================================
									$productcolortmp = explode("###", $this->cartItems[$i]->product->colorlist);
						            foreach ($productcolortmp as $colorkey => $productcolor) {
						                $productcolorlist = explode(':', $productcolor);
						                if($productcolorlist[0] == $this->cartItems[$i]->product->id){
						                	if(strtolower($productcolorlist[2])!= 'không xác định')
						                		$this->cartItems[$i]->product->name = $productcolorlist[1]. ' - ' . $productcolorlist[2];
						                }
						            }

						}
		                if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice>0 && $this->cartItems[$i]->product->onsitestatus > 0 && ($this->cartItems[$i]->product->instock > 0 && $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN || $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR ) && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)
		                {
		                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($this->cartItems[$i]->product->barcode, $this->registry->region);
		                    if(!empty($finalprice))
		                    {
		                        $this->cartItems[$i]->product->sellprice = $finalprice;
		                    }
		                    else {
		                        $this->cartItems[$i]->product->sellprice = ($this->cartItems[$i]->product->sellprice);
		                    }
		                    $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);
		                    $sellprice = 0;
		                    if(!empty($this->cartItems[$i]->options['promotionid']))
		                    {
		                        $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], $this->registry->region, $this->cartItems[$i]->product->barcode);
		                        if(!empty($promotioninfo['promotiongroup']))
		                        {
		                            foreach($promotioninfo['promotiongroup'] as $pg)
		                            {
		                                if((int)$pg->discountvalue > 0)
		                                {
		                                    if($pg->isdiscountpercent == 1) {
		                                        $sellprice = $this->cartItems[$i]->product->sellprice - ((double)$this->cartItems[$i]->product->sellprice*(double)$pg->discountvalue/100);
		                                    }
		                                    else {
		                                        $sellprice = $this->cartItems[$i]->product->sellprice - $pg->discountvalue;
		                                    }
		                                    $this->cartItems[$i]->firstprice = $this->cartItems[$i]->product->sellprice;
		                                    break;
		                                }
		                            }
		                            $this->cartItems[$i]->promotion = $promotioninfo['promotion'];
		                        }
		                    }
		                    if(!empty($sellprice))
		                    {
		                        $this->cartItems[$i]->pricesell = $sellprice;
		                    }
		                    else {
		                        $this->cartItems[$i]->pricesell = $this->cartItems[$i]->product->sellprice;
		                    }
		                    $this->cartItems[$i]->subtotal = $this->cartItems[$i]->quantity * $this->cartItems[$i]->pricesell;

		                    $cartpricetotal += $this->cartItems[$i]->subtotal;
		                    $totalproduct += $this->cartItems[$i]->quantity;
		                }
		            }

		        }
		         $this->registry->smarty->assign(array(
		                                            'cartItems'           => $this->cartItems,
		                                            'cartpricetotal' => $cartpricetotal,
		            								'totalproduct' => $totalproduct,
		                                        )
		                                   );
		            $content = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'cart/cartheader.tpl');
		            $output .= '<cartcontent><![CDATA['.$content.']]></cartcontent>';


            }

            $xml = '<?xml version="1.0" encoding="utf-8"?><result>'.$output;
            $xml .= '</result>';
	        header ("content-type: text/xml");
	        echo $xml;
        }

        //ham nay de kiem tra khi submit subscribers
        function indexajaxAction()
        {
			if (!empty($_SERVER['HTTP_REFERER']))
			{
				if (isset($_POST['action']) && $_POST['action'] == 'addsub' && isset($_POST['femail']) && $_POST['action'] != '') {
	                $mySubscriber = new Core_Subscriber();
	                $mysub        = $mySubscriber->getSubscribers(array('femail' => $_POST['femail']), '', '');
	                if ($mysub[0]->id == 0) {
	                    if (Helper::ValidatedEmail($_POST['femail'])) {
	                        $myuser              = new Core_User();
	                        $user                = $myuser->getUsers(array('femail' => $_POST['femail']));
	                        $mySubscriber->uid   = $user[0]->id;
	                        $mySubscriber->email = $_POST['femail'];
	                        $mySubscriber->addData();
	                        echo 'ok';
	                    }
	                    else {
	                        echo 'err';
	                    }
	                }
	                else {
	                    echo 'ext';
	                }
	            }
			}
        }

    	function processsubscriberAction(){
		if (!empty($_SERVER['HTTP_REFERER']))
		{
			if (isset($_POST['action']) && $_POST['action'] == 'processsubscriber' && isset($_POST['femail']) && isset($_POST['ffullname'])) {
				$mySubscriber = new Core_Subscriber();
				$mysub        = $mySubscriber->getSubscribers(array('femail' => $_POST['femail']), '', '');
				if ($mysub[0]->id == 0) {
					if (Helper::ValidatedEmail($_POST['femail'])) {
						$myuser              = new Core_User();
						$user                = $myuser->getUsers(array('femail' => $_POST['femail']));
						$mySubscriber->uid   = $user[0]->id;
						$mySubscriber->fullname = $_POST['ffullname'];
						$mySubscriber->gender = $_POST['gender'];
						$mySubscriber->email = $_POST['femail'];
						$mySubscriber->addData();
						echo 'ok';
					}
					else {
						echo 'err';
					}
				}
				else {
					echo 'ext';
				}
			}
		}
	}

        public function registerAction()
        {
            $this->registry->smarty->display($this->registry->smartyControllerContainer . 'register.tpl');
        }

        //public
        public function recentajaxAction()
        {
            $myBooklist = array();

            if (isset($_SESSION['viewingBooks']) && count($_SESSION['viewingBooks']) > 0) {
                for ($i = count($_SESSION['viewingBooks']) - 1; $i >= 0; $i--) {
                    if (count($myBooklist) < 6) {
                        $myBooklist[] = new Core_Book($_SESSION['viewingBooks'][$i], true);
                    }
                }
            }

            $this->registry->smarty->assign(array('myBooklist' => $myBooklist,));

            $this->registry->smarty->display($this->registry->smartyControllerContainer . 'recentajax.tpl');
        }


        /**
         * Trang homepage co groupbuy
         *
         */
        public function indexgroupbuyAction()
        {

            //$myCache = new cache('homepage2.html', $this->registry->setting['cache']['site'], $this->registry->setting['cache']['homepageExpire']);
            $pageHtml = ''; //$myCache->get();
            if (!$pageHtml) {
                //prepare data for slideshow
                $slideEntries = array();


                //Sach moi dang
                $latestBooks  = Core_Book::getBooks(array(), 'datelastusing', 'DESC', 25, false, true);
                $sellingBooks = Core_BookSell::getSells(array(), 'id', 'DESC', 20, false, true);
                //$mostviewBooks = Core_Book::getBooks(array(), 'view', 'DESC', 10, false, true);
                $timeArr = getdate();

                $mostviewBooksToday = Core_BookView::getViewTop(array('ftimestampstart' => mktime(0, 0, 0, $timeArr['mon'], $timeArr['mday'], $timeArr['year'])), 15);
                $mostaddBooksToday  = Core_UserBook::getAddTop(array('ftimestampstart' => mktime(0, 0, 0, $timeArr['mon'], $timeArr['mday'], $timeArr['year'])), 15);

                //ebook gia re nhat
                $ebookList = Core_Ebook::getEbooks(array('fenable' => 1), 'price', 'ASC', 10, false, true);

                //groupbuy home url
                $groupbuyUrl = $this->registry->conf['rooturl'] . 'groupbuy/detail/nhan-sach-mien-phi-la-nam-trong-la';
                // - Tong so ticket cua group nay
                $groupbuyTotalTicket = Core_GroupbuyTicket::getTickets(array('fgroupid' => 1), '', '', '', true);

                $this->registry->smarty->assign(array('latestReviews' => $latestReviews,
                                                      'slideEntries' => $slideEntries,
                                                      'latestBooks' => $latestBooks,
                                                      'sellingBooks' => $sellingBooks,
                                                      'mostviewBooksToday' => $mostviewBooksToday,
                                                      'mostaddBooksToday' => $mostaddBooksToday,
                                                      'ebookList' => $ebookList,
                                                      'groupbuyUrl' => $groupbuyUrl,
                                                      'groupbuyTotalTicket' => $groupbuyTotalTicket,));

                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'indexstart.tpl');
                $pageHtml = $contents;
                //$myCache->save($contents);
            }

            $this->registry->smarty->assign(array('contents' => $pageHtml,));

            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
            //save to cache


        }

        private function getBanner($fazid = 1, $ftype = Core_Ads::TYPE_BANNER)
        {
            $formData['fazid']     = $fazid; //Dienmay Homepage
            $formData['ftype']     = $ftype;
            $formData['fisactive'] = 1;
            $formData['fparent']   = 0;
            return Core_Ads::getAdss($formData, 'displayorder', 'ASC', 8);
        }

        private function getBannerMobile($fazid = 17, $ftype = Core_Ads::TYPE_BANNER)
        {
            $formData['fazid']     = $fazid; //Dienmay Homepage
            $formData['ftype']     = $ftype;
            $formData['fisactive'] = 1;
            $formData['fparent']   = 0;
            return Core_Ads::getAdss($formData, 'displayorder', 'ASC', 6);
        }

        public function slideentryCmp($a, $b)
        {
            if ($a['time'] > $b['time']) {
                return -1;
            }
            elseif ($a['time'] < $b['time']) {
                return 1;
            }
            return 0;
        }

        public function showpopup0209Action()
        {
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'popup0209.tpl');
        }
        //Menu mobile
        public function menuAction()
        {
        	if(SUBDOMAIN == 'm'){
	            $active[0] = $_GET['active'];
	            $subactive = Core_Productcategory::getFullparentcategoryInfoFromCahe($active[0]);
	            $subactive = array_keys($subactive);
	            if($subactive[0] != "")
	            {
	                $active[0]=$subactive[0];
	                $active[1]=$_GET['active'];
	            }
	            $html = Core_Productcategory::getTreeDataHtml($active);
	            $this->registry->smarty->assign(array('html' => $html));
	            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'menumobile.tpl');
	            $this->registry->smarty->assign(array('contents' => $contents));
	            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        	}else{
        		header('location: ' . $this->registry->conf['rooturl']);
                exit();
        	}

        }        
    }

