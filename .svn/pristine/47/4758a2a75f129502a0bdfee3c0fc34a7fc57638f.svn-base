<?php

Class Controller_Site_Search Extends Controller_Site_Base
{
    public $recordPerpage = 100;

    public function indexAction()
    {
        $formData = array();
        $success = array();
        $error = array();
        //$inCatSearch = array();
        $output = array();

        $formData = array_merge($formData, $_GET);
        $typeFilter = (string)$formData['f'];
        if($formData['q'] == null)
            $formData['q'] = ' ';


        //Tim vendor
        $vendorList = Core_Vendor::getVendors(array('fslug' => Helper::codau2khongdau($formData['q'], true, true)), '', '', 1);

        //Tim Category
        /*$foundCategoryList = array();
        if($formData['c'] == 0)
        {
            $foundCategoryList = Core_ProductCategory::getProductcategorys(array('fslug' => Helper::codau2khongdau($formData['q'], true, true)), '', '', 1);
        }*/


		$searchEngine = new SearchEngine();

		$searchEngine->addtable('productindex');

        /*if($formData['c'] != 0)
        {
            // lay category bang cach query database
            $inCatSearch = Core_ProductCategory::getFullSubCategory($formData['c']);
        }*/

        $searchEngine->searcher->SetFieldWeights(array('pi_title' => 3, 'pi_content' => 1));
        $searchEngine->searcher->SetSortMode(SPH_SORT_EXTENDED, '@weight DESC, pi_onsitestatus DESC');
		$searchEngine->searcher->setLimits(0, $this->recordPerpage, 50000);

        /*if(empty($inCatSearch) && $formData['c'] == 0)
        {
            $result = $searchEngine->search($formData['q']);
        }
        elseif(!empty($inCatSearch) && count($inCatSearch) > 0)
        {
            $searchEngine->searcher->setFilter('pc_id', $inCatSearch, 0);
            $result = $searchEngine->search($formData['q']);
        }
        else
        {
            $searchEngine->searcher->setFilter('pc_id', array(0 => 0), 0);
            $result = $searchEngine->search($formData['q']);
        }*/

        //$searchEngine->searcher->setFilter('pc_id', array(0 => 0), 0);
        $result = $searchEngine->search($formData['q']);
		//echodebug($result,true);

		///////////////////
		//tracking search trong search product

        $savesearchforu = '';
        if($formData['q'] != "")
        {
            //$formData['q'] = Helper::codau2khongdau($formData['q']);
            if($_SESSION['searchforu'] != "")
            {
                $searchforutmp = explode(',', $_SESSION['searchforu']);
                if(count($searchforutmp) >= 1)
                {
                    $flag = true;
                    foreach ($searchforutmp as $key => $value) {
                        if($formData['q'] == $value)
                        {
                            $flag = false;
                        }
                    }
                    if($flag == true)
                        $savesearchforu = $formData['q'].','.$_SESSION['searchforu'];
                    else
                        $savesearchforu = $_SESSION['searchforu'];
                }
                else
                {
                    $savesearchforu = $searchforutmp[0];
                }
            }
            else
            {
                $savesearchforu = $formData['q'];
            }
            $_SESSION['searchforu'] = $savesearchforu;
        }
        if($savesearchforu != "")
        {
            $searchforyou = explode(',', $savesearchforu);
        }
        $reviewkey = $formData['q'];
		//END TRACKING SEARCH
		///////////////////////////////

		unset($searchEngine);
		$searchEngine = new SearchEngine();
		$searchEngine->addtable('news');
		$searchEngine->addtable('stuff');
        $searchEngine->searcher->setLimits(0, $this->recordPerpage, 50000);
        $resultExtend = $searchEngine->search($formData['q']);
		//echodebug($resultExtend, true);


		if(!empty($result) || !empty($resultExtend))
        {
            if($typeFilter == null)
            {
                if($result['productindex']['result_found'] > 0)
                {
                    foreach($result['productindex'] as $product)
                    {
                        if(empty($product['result_found']))
                        {
                            if(isset($product['id']))
                            {
                                $myProduct = new Core_Product($product['id']);

                                if(strlen($myProduct->slug) > 0)
                                {
                                    $myProduct->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$myProduct->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                                    $newsummary = '';
                                    $explodenewsummary = explode("\n",$myProduct->summary);//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
                                    if(!empty($explodenewsummary)){
                                        $cnt = 0;
                                        foreach($explodenewsummary as $suma){
                                            $suma = strip_tags(htmlspecialchars_decode($suma));
                                            $suma = trim(preg_replace( '/[\s]+/mu', " ",$suma));
                                            if(!empty($suma))
                                            {
                                                if(substr($suma,0,1) =='-') $suma = trim(substr($suma,1));
                                                if(!empty($suma) && $suma !='-'){
                                                    if($cnt++==3) break;
                                                    $newsummary .= '<span>'.$suma.'</span>';
                                                }
                                            }
                                        }
                                    }

                                    $myProduct->summary = $newsummary;

                                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, $this->registry->region);
                                    if($finalprice > 0)
                                    {
                                        if(($myProduct->onsitestatus == Core_Product::OS_ERP || $myProduct->onsitestatus == Core_Product::OS_HOT || $myProduct->onsitestatus == Core_Product::OS_NEW || $myProduct->onsitestatus == Core_Product::OS_BESTSELLER || $myProduct->onsitestatus == Core_Product::OS_CRAZYSALE || $myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID || $myProduct->onsitestatus == Core_Product::OS_CRAZYSALE ) && $myProduct->status == Core_Product::STATUS_ENABLE)
                                            $myProduct->sellprice = $finalprice;
                                        else
                                            $myProduct->sellprice = 0;
                                    }

                                    $output['productindex'][] = $myProduct;
                                }
                            }
                        }

                    }
                }
                else
                    header('location:' . $this->registry->conf['rooturl'] . 'search?f=news&q=' . $formData['q']);

            }
            if(count($output['productindex']) > 0)
            {
                //echodebug($output['productindex']);
                $searchitemcolorlist = array();
                $searchitemcolorlisttmp = array();
                foreach ($output['productindex'] as $keyitem => $searchitem) {
                    //Loop top item list get color if exsist
                    $searchitemcolorlisttmp = explode("###", $searchitem->colorlist);
                    foreach ($searchitemcolorlisttmp as $colorkey => $productcolor) {
                        $searchitemcolorlist[$searchitem->id][] = explode(':', $productcolor);
                    }
                }
            }

            if($typeFilter == 'news')
            {
                if($resultExtend['news']['result_found'] > 0)
                {
                    foreach($resultExtend['news'] as $news)
                    {
                        if(empty($news['result_found']))
                        {
                            if(isset($news['id']))
                            {
                                $myNews = new Core_News($news['id'], true);

                                $output['news'][] = $myNews;
                            }
                        }
                    }
                }
                else
                    header('location:' . $this->registry->conf['rooturl'] . 'search?f=stuff&q=' . $formData['q']);
            }

            /*if($typeFilter == 'stuff')
            {
                if($resultExtend['stuff']['result_found'] > 0)
                {
                    foreach($resultExtend['stuff'] as $stuff)
                    {
                        if(empty($stuff['result_found']))
                        {
                            if(isset($stuff['id']))
                            {
                                $myStuff = new Core_Stuff($stuff['id'], true);

                                $output['stuff'][] = $myStuff;
                            }
                        }
                    }
                }

            }*/
        }

        //Get page tim kiem nhieu nhat id = 42
        $pageid = 42;
        $searchTrends = new Core_Page($pageid);
        if(!empty($searchTrends))
        {
            $searchTrendsContent = explode(',', $searchTrends->content);
        }
        $this->registry->smarty->assign(array(    'error'            => $error,
                                                'formData'          => $formData,
                                                'searchforu'        => $searchforyou,
                                                'reviewkey'         => $reviewkey,
                                                'searchTrendsContent'      => $searchTrendsContent,
                                                'vendorList'        => $vendorList,
                                                'foundCategoryList' => $foundCategoryList,
                                                'myProduct'         => $output['productindex'],
                                                'myNews'            => $output['news'],
                                                'myStuff'           => $output['stuff'],
                                                'currentTime'       => time(),
                                                'totalProduct'      => $result['productindex']['result_found'],
                                                'totalNews'         => $resultExtend['news']['result_found'],
                                                'totalStuff'        => $resultExtend['stuff']['result_found'],
                                                'searchitemcolorlist' => $searchitemcolorlist,
                                                ));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => (!empty($formData['q'])?'Kết quả tìm kiếm với từ khóa '.$formData['q']:$this->registry->lang['controller']['pageTitle_list']),
                                                'contents'     => $contents,
                                                  'pageMetarobots'=>'noindex, nofollow'
                                                ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

    }

    public function suggestAction()
    {
        $rooturl = $this->registry->conf['rooturl'];
        $rooturl_cms = $this->registry->conf['rooturl_cms'];
        $rooturl_profile = $this->registry->conf['rooturl_profile'];
        $rooturl_admin = $this->registry->conf['rooturl_admin'];
        $currentTemplate = $this->registry->conf['rooturl'] . 'templates/default/';
        $lang = $this->registry->lang['controller'];
        $output = array();

        //search book
        $keyword = htmlspecialchars($_GET['q']);

        $stopSelect = 0;
        //$keyword = Helper::codau2khongdau($keyword);
        if(mb_strlen($keyword) < 3)
        {
            $stopSelect = 1;
        }

        //search using Sphinx api
        //search product
        $searchEngine = new SearchEngine();
        $searchEngine->addtable('productindex');
        $searchEngine->searcher->SetFieldWeights(array('pi_title' => 3, 'pi_content' => 1));
        $searchEngine->searcher->SetSortMode(SPH_SORT_EXTENDED, '@weight DESC, pi_onsitestatus DESC');
        $searchEngine->searcher->setLimits(0, 5, 50000);
        $result = $searchEngine->search($keyword);
        unset($searchEngine);

        //search news
        $searchEngine = new SearchEngine();
        $searchEngine->searcher->setLimits(0, 5, 50000);
        $searchEngine->addtable('news');
        $resultExtend = $searchEngine->search($keyword);

        //echodebug($result, true);

        if(count($result['productindex']) > 0)
        {
            echo $rooturl . 'site/product|'.$this->registry->lang['controller']['product'].'|&nbsp;|0|&nbsp;|seperator' . "\n";

            foreach($result['productindex'] as $product)
            {
                if(empty($product['result_found']))
                {
                    if(isset($product['id']))
                    {
                        $myProduct = new Core_Product($product['id'], true);

                        if(strlen($myProduct->slug) > 0)
                        {
                            if ($myProduct->status == Core_Product::STATUS_ENABLE && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN)
                            {
                                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, $this->registry->region);
                                if($finalprice > 0)
                                {
                                    if(($myProduct->onsitestatus == Core_Product::OS_ERP || $myProduct->onsitestatus == Core_Product::OS_HOT || $myProduct->onsitestatus == Core_Product::OS_NEW || $myProduct->onsitestatus == Core_Product::OS_BESTSELLER || $myProduct->onsitestatus == Core_Product::OS_CRAZYSALE || $myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID) && $myProduct->status == Core_Product::STATUS_ENABLE)
                                        $myProduct->sellprice = $finalprice;
                                    else
                                        $myProduct->sellprice = 0;
                                }
                                $discount = 0;
                                if ($myProduct->displaysellprice != 1)
                                {
									$discountpromotion = $myProduct->promotionPrice();
	                                if (!empty($discountpromotion) && $discountpromotion['price'] > 0)
	                                {
										$discount = $discountpromotion['price'];
	                                }
                                }

                                if($myProduct->image == '')
                                    $imagePath = $currentTemplate . 'images/default.jpg';
                                else
                                    $imagePath = $myProduct->getSmallImage();

								  $myProduct->name = str_replace('|', '&#124;', $myProduct->name);
								  echo $myProduct->getProductPath().'|'.$myProduct->name.'|'.$imagePath.'|&nbsp;|'.($myProduct->sellprice > 0 && $myProduct->onsitestatus != 0 ?  ($discount > 0 ? number_format($discount). '&#272;' .'&nbsp;' : ''). number_format($myProduct->sellprice) . '&#272;' : '').'|product' . "\n";
                            }
                        }
                    }
                }
            }
        }

        if(count($resultExtend['news']) > 0)
        {
            echo $rooturl . 'site/news|'.$this->registry->lang['controller']['news'].'|&nbsp;|0|&nbsp;|seperator' . "\n";

            foreach($resultExtend['news'] as $news)
            {
                if(empty($news['result_found']))
                {
                    if(isset($news['id']))
                    {
                        $myNews = new Core_News($news['id'], true);

                        if($myNews->image == '')
                            $imagePath = $currentTemplate . 'images/default.jpg';
                        else
                            $imagePath = $myNews->getSmallImage();//$rooturl . 'uploads/news/' .$myNews->image;

						$myNews->title = str_replace('|', '&#124;', $myNews->title);
                        echo $myNews->getNewsPath().'|'.$myNews->title.'|'.$imagePath.'|&nbsp;|&nbsp;|news' . "\n";
                    }
                }
            }
        }


        //////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////
        //search user

        //echo $this->registry->conf['rooturl_admin'] . 'user|'.$this->registry->lang['controller']['user'].'|&nbsp;|0|&nbsp;|seperator' . "\n";
        /*
        //if login, search in friend and fanpage
        $myUserIdList = array();
        $myFriendIds = Core_Backend_Friend::getFriendIds($this->registry->me->id);

        $friendList = Core_User::getUsers(array('fidlist' => $myUserIdList, 'fkeywordFilter' => $keyword), '', '', 2);


        if(!empty($friendList))
        {
            echo $this->registry->me->getUserPath() . '/friend/search?keyword='.$keyword.'|'.$this->registry->lang['default']['mFriend'] . ' &amp; Page'.'|&nbsp;|0|&nbsp;|seperator' . "\n";
            for($i = 0; $i < count($friendList); $i++)
            {
                $authorReplacement = '';
                if($friendList[$i]->ispage())
                {
                    $myPage = new Core_Page($friendList[$i]->id);
                    $authorReplacement = $myPage->countLike . ' ' . $this->registry->lang['default']['mMember'];
                }
                else
                {
                    $authorReplacement = $friendList[$i]->getRegionName(false);
                }

                echo  $friendList[$i]->getUserPath() . '|' . $friendList[$i]->fullname . '|' . $friendList[$i]->getSmallImage() . '|&nbsp;|'.$authorReplacement.'|' . 'user' . "\n";
            }
        }


        if(strlen($keyword) > 6)
        {
            $userListTmp = Core_User::getUsers(array('fkeywordFilter' => $keyword), '', '', 2);
            $userList = array();
            for($i = 0; $i < count($userListTmp); $i++)
            {
                if(!in_array($userListTmp[$i]->id, $myUserIdList))
                    $userList[] = $userListTmp[$i];
            }


            if(!empty($userList))
            {
                echo $this->registry->conf['rooturl'] . 'member?search=1&keyword='.$keyword.'|'.$this->registry->lang['default']['mMember'].'|&nbsp;|0|&nbsp;|seperator' . "\n";
                for($i = 0; $i < count($userList); $i++)
                {
                    $authorReplacement = '';
                    if($userList[$i]->ispage())
                    {
                        $myPage = new Core_Page($userList[$i]->id);
                        $authorReplacement = $myPage->countLike . ' ' . $this->registry->lang['default']['mMember'];
                    }
                    else
                    {
                        $authorReplacement = $friendList[$i]->getRegionName(false);
                    }
                    echo  $userList[$i]->getUserPath() . '|' . $userList[$i]->fullname . '|' . $userList[$i]->getSmallImage() . '|&nbsp;|'.$authorReplacement.'|' . 'user' . "\n";
                }
            }
        }

        */



        //////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////
        //search controller such as: Dang ky, dang nhap, lien he...

        $c = array();
        $c['product'] = array($lang['product'], $rooturl_cms . 'product', 4);

        //synonym
        $c['sanpham'] = $c['product'];

        //foundController
        $foundController = array();
        $foundControllerId = array();
        foreach($c as $k => $v)
        {
            if(strpos($k, $keyword) !== false && !in_array($v[2], $foundControllerId))
            {
                //array tuan tu, vi de lay phan tu dau index = 0 de set default url cho seperator o duoi
                $foundController[] = $v;
                $foundControllerId[] = $v[2];
            }
        }



        if(count($foundController) > 0)
        {
            echo $foundController[0][1] . '|Quick Menu|&nbsp;|0|&nbsp;|seperator' . "\n";
            foreach($foundController as $controller)
            {
                echo  $controller[1] . '|' . $controller[0] . '|'.$this->registry->currentTemplate . 'images/plainicon.jpg' . ' |0|&nbsp;|' . 'controller' . "\n";
            }
        }
    }

    public function keywordAction()
    {
        $formData = array();

        if(!empty($_GET))
        {
            $formData = array_merge($formData, $_GET);

            $page             = (int)($_GET['page'])>0?(int)($_GET['page']):1;
            $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/keyword?fkeyword=' . $formData['fkeyword'];

            $parsekey = explode('-', $formData['fkeyword']);

            foreach($parsekey as $parse)
            {
                $reviewkey .= $parse . '&nbsp;';
            }

            //search keyword theo slug cua keyword  va lay ra id cua keyword
            $keywordList = array();

            //$formData['fkeyword'] = Helper::codau2khongdau($formData['fkeyword'], true, true);
            $myKeyword = Core_Keyword::getKeywords(array('flsug' => $formData['fkeyword']), '', '', '');

            foreach($myKeyword as $keyword)
            {
                $keywordList[] = $keyword->id;
            }

            $keywordFilter = implode(',', $keywordList);

            if(isset($formData['isnews']))
            {
                $myNews = array();

                $paginateUrl .= '&isnews';

                $total = Core_RelItemKeyword::getRelItemKeywords(array('ffilterkeywordin' => $keywordFilter, 'ftype' => Core_RelItemKeyword::TYPE_NEWS), '', '', 0, true);

                $newsList = Core_RelItemKeyword::getObjectList(Core_RelItemKeyword::TYPE_NEWS, $keywordFilter, (($page - 1)*$this->recordPerpage).','.$this->recordPerpage);

                foreach($newsList as $news)
                {
                    $prebuild = new Core_News($news->objectid, true);

                    $myNews[] = $prebuild;
                }
            }
            elseif(isset($formData['ispage']))
            {
                $myPage = array();

                $paginateUrl .= '&ispage';

                $total = Core_RelItemKeyword::getRelItemKeywords(array('ffilterkeywordin' => $keywordFilter, 'ftype' => Core_RelItemKeyword::TYPE_PAGE), '', '', 0, true);

                $pageList = Core_RelItemKeyword::getObjectList(Core_RelItemKeyword::TYPE_PAGE, $keywordFilter, (($page - 1)*$this->recordPerpage).','.$this->recordPerpage);

                foreach($pageList as $pages)
                {

                    $prebuild = new Core_Page($pages->objectid);
                    $prebuild->content = strip_tags($prebuild->content);
                    //echodebug($prebuild, true);
                    $myPage[] = $prebuild;
                }
            }
            else
            {
                $myProduct = array();

                $total = Core_RelItemKeyword::getRelItemKeywords(array('ffilterkeywordin' => $keywordFilter, 'ftype' => Core_RelItemKeyword::TYPE_PRODUCT), '', '', 0, true);

                $productList = Core_RelItemKeyword::getObjectList(Core_RelItemKeyword::TYPE_PRODUCT, $keywordFilter, (($page - 1)*$this->recordPerpage).','.$this->recordPerpage);
                //echodebug($productList, true);
                foreach($productList as $product)
                {
                    $prebuild = new Core_Product($product->objectid, true);
                    if ($prebuild->status == Core_Product::STATUS_ENABLE && $prebuild->customizetype == Core_Product::CUSTOMIZETYPE_MAIN)
                    {
						$prebuild->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$prebuild->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
	                    $newsummary = '';
	                    $explodenewsummary = explode("\n",$prebuild->summary);//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
	                    if(!empty($explodenewsummary)){
	                        $cnt = 0;
	                        foreach($explodenewsummary as $suma){
	                            $suma = strip_tags(htmlspecialchars_decode($suma));
	                            $suma = trim(preg_replace( '/[\s]+/mu', " ",$suma));
	                            if(!empty($suma))
	                            {
	                                if(substr($suma,0,1) =='-') $suma = trim(substr($suma,1));
	                                if(!empty($suma) && $suma !='-'){
	                                    if($cnt++==3) break;
	                                    $newsummary .= '<span>'.$suma.'</span>';
	                                }
	                            }
	                        }
	                    }

	                    $prebuild->summary = $newsummary;

	                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($prebuild->barcode, $this->registry->region);
	                    if($finalprice > 0)
	                        $prebuild->sellprice = $finalprice;

	                    $myProduct[] = $prebuild;
                    }
                }

                usort($myProduct, 'productlist_cmponsite');
            }

            $totalPage = ceil($total/$this->recordPerpage);
            $curPage = $page;

            //build redirect string
            $redirectUrl = $paginateUrl;
            if($curPage > 1)
                $redirectUrl .= '&page=' . $curPage;
        }

        $this->registry->smarty->assign(array(    'formData'        => $formData,
                                                //'hideMenu'        => 1,
                                                'paginateurl'     => $paginateUrl,
                                                'pageMetarobots'     => 'noindex, nofollow',
                                                'redirectUrl'    => $redirectUrl,
                                                'total'            => $total,
                                                'totalPage'     => $totalPage,
                                                'curPage'        => $curPage,
                                                'myProduct'        => $myProduct,
                                                'myNews'        => $myNews,
                                                'myPage'        => $myPage,
                                                'currentTime'        => time(),
                                                'reviewkey'     => $reviewkey));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'searchkeyword.tpl');

        $this->registry->smarty->assign(array(    'pageTitle' => (!empty($reviewkey)?'Kết quả tìm kiếm với từ khóa '.$reviewkey:$this->registry->lang['controller']['pageTitle_list']),
                                                'contents'    => $contents,

                                                ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
    }
    public function clearsessionsearchAction()
    {
        $searchforu = $_SESSION['searchforu'];
        $newsearchsession = "";
        $deleteItem = $_POST['item'];
        if($searchforu != "" && $deleteItem != "")
        {
            $searchforu = explode(',', $searchforu);
            $lengthsession = count($searchforu);
            for($i=0;$i< $lengthsession;$i++){
                if(Helper::codau2khongdau($deleteItem,true,true) != Helper::codau2khongdau($searchforu[$i],true,true))
                {
                    $newsearchsession[] = $searchforu[$i];
                }
            }
            $newsearchsession = implode(',', $newsearchsession);
            $_SESSION['searchforu'] = $newsearchsession;
        }
    }
}


function productlist_cmponsite(Core_Product $p1, Core_Product $p2)
{
	if($p1->onsitestatus > $p2->onsitestatus)
		return -1;
	elseif($p1->onsitestatus < $p2->onsitestatus)
		return 1;
	else
		return 0;
}