<?php

Class Controller_Site_Product Extends Controller_Site_Base
{
    private $recordPerPage = 60;
    private $recordPerSearchPage = 60;


    /**
     * Su dung landing page ma thoi
     *
     */
    function tinyindexAction()
    {
        if(isset($_GET['start']))
        {
            $this->indexstartAction();
            exit();
        }

        if($this->registry->me->id > 0)
        {
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
        else
        {
            //$myCache = new cache('productpage.html', $this->registry->setting['cache']['site'], $this->registry->setting['cache']['productpageExpire']);
            $pageHtml = '';//$myCache->get();
            if(!$pageHtml)
            {

                $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

                //save to cache
                //$myCache->save($pageHtml);
            }

            //replace register token
            //get token for form
            $_SESSION['userRegisterToken'] = Helper::getSecurityToken();
            $pageHtml = str_replace('###TOKEN###', $_SESSION['userRegisterToken'], $pageHtml);

            echo $pageHtml;
        }


    }

    /**
     * Frontpage of the app
     */
    function mobilestartAction()
    {

        $from = $_GET['from'];
        if($from == 'ios')
        {

        }
        elseif($from == 'windowsphone')
        {

        }
        elseif($from == 'android')
        {

        }

        setcookie('onmobile', $from, time() + 14 * 24 * 3600, '/');
        //$this->indexAction();

        $this->registry->smarty->display($this->registry->smartyControllerContainer.'mobileproduct.tpl');
    }

    /**
     * Trang homepage cu, co day du va nhieu thong tin
     *
     */
    function indexAction()
    {
        global $protocol;
        if($_GET['a'] || $_GET['pricefrom'] || $_GET['priceto'])//search action
        {
            $this->searchAction();
            exit();
        }
        //delete search session
        if (!empty($_SESSION['ses_filterproduct'])) unset($_SESSION['ses_filterproduct']);

        if(!isset($_GET['pcid']))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }

        $arrayAssignTemplate = array();
        $fpcid = (int)$_GET['pcid'];
        $fvid = (int)(isset($_GET['fvid'])?$_GET['fvid']:0);
        $fvidlist = isset($_GET['vendor'])?$_GET['vendor']:'';
    	$order = $_GET['o'];
    	$promotion = $_GET['f'];

        $arrayAssignTemplate['page']        = (int)(($_GET['page'])>0?(int)($_GET['page']):1);
        $subdomain = '';
        if(SUBDOMAIN == 'm'){
       		$this->recordPerPage= 12;
    		$this->recordPerSearchPage = 12;
            $subdomain = SUBDOMAIN;
        }
        $cachefile = $protocol.$subdomain.'sitehtml_productlist'.$fpcid.'_'.$fvid.'_'.md5($fvidlist).'_'.$this->registry->region.'_'.$arrayAssignTemplate['page']. '_' . $order . '_' . $promotion;//.'.html';
        //if(!empty($_SESSION['ses_filterproduct'])) unset($_SESSION['ses_filterproduct']);
        //$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['ProductpageExpire']);
        $myCache = new Cacher($cachefile);

        //$pageHtml = $myCache->get();
        if(isset($_GET['customer']) || isset($_GET['live'])) //no edit
        {
            //lấy tất cả các region để clear cache
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.$subdomain.'sitehtml_productlist'.$fpcid.'_'.$fvid.'_'.md5($fvidlist).'_'.$ritem->id.'_1_' . $order . '_' . $promotion;
                    $cachefile2 = $protocol.$subdomain.'sitehtml_productlist'.$fpcid.'_'.$fvid.'_'.md5($fvidlist).'_'.$ritem->id.'_2_' . $order . '_' . $promotion;
                    $cachefile3 = $protocol.$subdomain.'sitehtml_productlist'.$fpcid.'_'.$fvid.'_'.md5($fvidlist).'_'.$ritem->id.'_3_' . $order . '_' . $promotion;
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->clear();

                    $removeCache2 = new Cacher($cachefile2);
                    $removeCache2->clear();

                    $removeCache3 = new Cacher($cachefile3);
                    $removeCache3->clear();
                }
            }
            $pageHtml = '';
        }
        elseif($arrayAssignTemplate['page'] < 4) {
            $pageHtml = $myCache->get();
        }
        else {
            $pageHtml = '';

        }
        if(empty($pageHtml))
        {
            $getCurrentCat    = new Core_Productcategory($fpcid, true);
            if(empty($getCurrentCat))
            {
                header('location: ' . $this->registry->conf['rooturl']);
                exit();
            }
            // Get content of brand category
            $getCurrentBrand = Core_BrandCategory::getDatabyVendor($fvid,$fpcid);
            //var_dump($getCurrentBrand);die;
            $templatepage = 'productsnew.tpl';
            $arrayAssignTemplate['curCategory'] = $getCurrentCat;
            $arrayAssignTemplate['curBrand'] = $getCurrentBrand;
            //Getslugbanner/////////////////////////
            $slug = Helper::slugBannerURL();
            $slug = explode("?",$slug);
            //End Getslugbanner/////////////////////

            $arrayAssignTemplate['bannerProduct']= $this->getBannerProduct($fpcid,$slug[0]);
            if (!empty($getCurrentBrand->topseokeyword))
                $arrayAssignTemplate['headertext'] = $getCurrentBrand->topseokeyword;
            elseif (!empty($getCurrentCat->topseokeyword))
                $arrayAssignTemplate['headertext'] = $getCurrentCat->topseokeyword;
            $arrayAssignTemplate['currentTime'] = time();
            $getAllChildCategory = array();
            $arr_catid = array();
            $arr_catid[] = $fpcid;
            $getAllChildCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$fpcid, 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
            //doi logic lay tu homepage ra
//            $getsubcatehomepage = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_PRODUCT, 'fcategory' => $getCurrentCat->id), 'id', 'ASC');
//            if(!empty($getsubcatehomepage[0]) && !empty($getsubcatehomepage[0]->subcategory)){
//                $getAllChildCategory[] = $getCurrentCat;
//                $explodesubcate = explode(',', $getsubcatehomepage[0]->subcategory);
//                if(!empty($explodesubcate)){
//                    foreach($explodesubcate as $subcat){
//                        if(!empty($subcat)){
//                            $arr_catid[] = $subcat;
//                            $mysubcate = new Core_Productcategory($subcat, true);
//                            if($mysubcate->id > 0) $getAllChildCategory[] = $mysubcate;
//                        }
//                    }
//                }
//            }
//            else {
//                $getAllChildCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$fpcid, 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
//            }
            $arrayConditionProduct = array();//dieu kiem dua where cua product
            $strOrderBy = 'id';
            $strSortOrder = 'DESC';

            $arrayConditionProduct['fisonsitestatus'] = 1;
            $arrayConditionProduct['fstatus'] = Core_Product::STATUS_ENABLE;
            $arrayConditionProduct['fproductavailble'] = 1;
            //$arrayConditionProduct['fpricethan0'] = 1;
            $arrayConditionProduct['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
            if($promotion == 'khuyen-mai'){
            	$arrayConditionProduct['fhaspromotion'] = 1;
            }
            //$arrayConditionProduct['fquantitythan0'] = 1;
            if($fvidlist != '') {
                $vendorslug = explode(",", $fvidlist);
                $vendorlist = Core_Vendor::getVendors(array('fslugarr'=>$vendorslug),'','');
                $vid = array();
                foreach ($vendorlist as $vl) {
                    $vid[] = $vl->id;
                }
                $arrayConditionProduct['fvidarr'] = $vid;
                $arrayAssignTemplate['myVendors'] = new Core_Vendor();
                $myVendorsList = Core_Vendor::getVendors(array('fidin'=>$vid), '','');
                foreach ($myVendorsList as $myVendorsL) {
                    if($myVendorsL->topseokeyword != '')
                    {
                        $arrayAssignTemplate['headertext'] .= $myVendorsL->topseokeyword.",";
                        $newtopseokeyword .= ",".$myVendorsL->topseokeyword;
                    }
                    $newname .= ",".$myVendorsL->name;
                    $newslug .= ",".$myVendorsL->slug;
                }
                $arrayAssignTemplate['myVendors']->topseokeyword = substr($newtopseokeyword,1);
                $arrayAssignTemplate['myVendors']->name = substr($newname, 1);
                $arrayAssignTemplate['myVendors']->arrslug = substr($newslug, 1);
            }
            elseif($fvid > 0){
                $flaglink = 1; //Kiem tra link co vendor hay ko;
                $fvid = explode(",", $fvid);
                $arrayConditionProduct['fvidarr'] = $fvid;
                $arrayAssignTemplate['myVendors'] = new Core_Vendor($fvid[0], true);
                if (!empty($arrayAssignTemplate['myVendors']->topseokeyword))
                    $arrayAssignTemplate['headertext'] = $arrayAssignTemplate['myVendors']->topseokeyword;
            }

             //neu khong lay list sub tu homepage thi lay cai nay
            if(!empty($getAllChildCategory))
            {
                $lists = $getAllChildCategory;
                $getAllChildCategory = array();
                $getAllChildCategory[] = $getCurrentCat;
                //$getAllChildCategory[0] = $getCurrentCat;
                foreach($lists as $cat)
                {
                    $getAllChildCategory[] = $cat;
                    //if($fpcid == 1282 && $cat->id == 44) continue;
                    $arr_catid[] = $cat->id;
                }
                //$getAllChildCategory[count($getAllChildCategory)] = $getCurrentCat;
            }
            else $getAllChildCategory[] = $getCurrentCat;

          //
            if(!empty($arr_catid)) {
                $arrayConditionProduct['fpcidarrin'] = $arr_catid;
                $listvendors = array();

                if($getCurrentCat->parentid != 0)//nganh hang con
                {
                    if(!empty($getCurrentCat->vendorlist))
                    {
                        $idvendors = trim($getCurrentCat->vendorlist);
                        $vendoridlist = explode(',', $idvendors);
                        if(!empty($vendoridlist))
                        {
                            foreach($vendoridlist as $vid)
                            {
                                if(!empty($vid))
                                {
                                    $myVen = new Core_Vendor($vid, true);
                                    $listvendors[] = $myVen;
                                    unset($myVen);
                                }
                            }
                        }
                    }
                    else{
                        $listvendors = Core_Product::getVendorFromCategories($arr_catid);
                    }
                    if(count($listvendors > 0))
                    {
                         /**/
                        if($flaglink != 1)
                        {
                            $afilter = isset($_GET['a']) && $_GET['a'] != ""?"&a=".$_GET['a']:"";
                            $cururl = $this->registry->conf['rooturl'].$getCurrentCat->slug."?vendor=".$_GET['vendor'].$afilter;
                        }
                        else{
                             $afilter = isset($_GET['a']) && $_GET['a'] != ""?"&a=".$_GET['a']:"";
                            $vendorname = new Core_Vendor($fvid[0]);
                            $cururl = $this->registry->conf['rooturl'].$getCurrentCat->slug."?vendor=".$vendorname->slug.$afilter;
                        }
                        if(count($listvendors) > 0)
                        {
                            $vendorvalue = array();
                            $vendorseo = array();
                            $urlvendor = array();
                            foreach ($listvendors as $key => $listvendor) {
                                $vendorseo[]= $listvendor->name;
                                $vendorvalue[] = $listvendor->slug;
                                $vendorid[] = $listvendor->id;
                            }
                            foreach ($vendorvalue as $key => $vvendors) {
                                if(strpos($cururl,'?live') !== false)
                                {
                                    $tmpcurl = str_replace('?live', '', $cururl);
                                }
                                else{
                                    if(strpos($cururl,'&live') !== false)
                                        $tmpcurl = str_replace('&live', '', $cururl);
                                    else
                                        $tmpcurl = $cururl;
                                }
                                $specialchar = '&';
                                if(!isset($_GET['a']) || strpos($tmpcurl,'&a') !== false)
                                    $specialchar = '?';
                                if(strpos($cururl, $vvendors) === false)
                                {
                                    if(empty($_GET['vendor']) && strpos($tmpcurl, $specialchar.'vendor=') === false){
                                        $urlvendor[$key] = $tmpcurl.$specialchar."vendor=".$vvendors;
                                    }
                                    else{
                                        if(strpos($tmpcurl, $specialchar.'vendor=')!== false)
                                        {
                                            $tmpcurl1 = explode($specialchar.'vendor=', $tmpcurl);
                                            $vvendors = isset($_GET['vendor'])||$vendorname->slug!=""?$vvendors.",":$vvendors;
                                            $tmpcurl1 = $tmpcurl1[0].$specialchar.'vendor='.$vvendors.$tmpcurl1[1];
                                        }
                                        //echodebug($tmpcurl);
                                        $urlvendor[$key] = $tmpcurl1;
                                    }
                                }
                                else{
                                    //del link
                                    $newcurl = str_replace($vvendors,'',$cururl);
                                    if(substr($newcurl, -15)=='?vendor=&live=1') $newcurl= substr($newcurl, 0, -15);
                                    elseif(substr($newcurl, -13)=='?vendor=&live') $newcurl= substr($newcurl, 0, -13);
                                    elseif(substr($newcurl, -8)=='?vendor=')
                                    {
                                            $newcurl= substr($newcurl, 0, -8);
                                    }
                                    elseif(substr($newcurl, -1)=='?') $newcurl= substr($newcurl, 0, -1);
                                    if(strpos($newcurl, '?vendor=,')!==false) $newcurl= str_replace('?vendor=,', '?vendor=', $newcurl);

                                    if(substr($newcurl, -15)=='&vendor=&live=1') $newcurl= substr($newcurl, 0, -15);
                                    elseif(substr($newcurl, -13)=='&vendor=&live') $newcurl= substr($newcurl, 0, -13);
                                    elseif(substr($newcurl, -8)=='&vendor=') $newcurl= substr($newcurl, 0, -8);
                                    elseif(substr($newcurl, -1)=='&') $newcurl= substr($newcurl, 0, -1);
                                    if(strpos($newcurl, '&vendor=,')!==false) $newcurl= str_replace('&vendor=,', '&vendor=', $newcurl);
                                    if(strpos($newcurl, ',,')!==false) $newcurl= str_replace(',,', ',', $newcurl);
                                    if(substr($newcurl, -1)==',') $newcurl= substr($newcurl,0, -1);
                                    if(strpos($newcurl,'?vendor=&a'))
                                        $newcurl = str_replace('?vendor=&', '?', $newcurl);
                                    $urlvendor[$key] = $newcurl;

                                }
                            }
                            $listvendors = array($vendorseo,$vendorvalue,$urlvendor,$vendorid);
                        }
                    }
                }
                elseif (count($getAllChildCategory) > 1)
                {
                    foreach ($getAllChildCategory as $childcat)
                    {
                        if (!empty($childcat->vendorlist))
                        {
                            $idvendors = trim($childcat->vendorlist);
                            $vendoridlist = explode(',', $idvendors);
                            if(!empty($vendoridlist))
                            {
                                $vendorchild = array();
                                foreach($vendoridlist as $vid)
                                {
                                    if(!empty($vid))
                                    {
                                        $myVen = new Core_Vendor($vid, true);
                                        $vendorchild[] = $myVen;
                                        unset($myVen);
                                    }
                                }
                                $listvendors[$childcat->id] = $vendorchild;
                            }
                        }
                        else
                        {
                            $listvendors[$childcat->id] = Core_Product::getVendorFromCategories(array($childcat->id));

                        }
                    }
 					//$listvendors = Core_Product::getVendorFromCategories($arr_catid);
                    $productlists = array();
                    foreach ($listvendors as $list) {
                    	foreach ($list as $vendor){
                    		$productlists[] = $vendor;
                    	}
                    }

 					$listvendors = $productlists;

                    if(count($listvendors > 0))
                    {
                         /**/
                        if($flaglink != 1)
                        {
                            $afilter = isset($_GET['a']) && $_GET['a'] != ""?"&a=".$_GET['a']:"";
                            $cururl = $this->registry->conf['rooturl'].$getCurrentCat->slug."?vendor=".$_GET['vendor'].$afilter;
                        }
                        else{
                             $afilter = isset($_GET['a']) && $_GET['a'] != ""?"&a=".$_GET['a']:"";
                            $vendorname = new Core_Vendor($fvid[0]);
                            $cururl = $this->registry->conf['rooturl'].$getCurrentCat->slug."?vendor=".$vendorname->slug.$afilter;
                        }
                        if(count($listvendors) > 0)
                        {
                            $vendorvalue = array();
                            $vendorseo = array();
                            $urlvendor = array();
                            foreach ($listvendors as $key => $listvendor) {
                                $vendorseo[]= $listvendor->name;
                                $vendorvalue[] = $listvendor->slug;
                                $vendorid[] = $listvendor->id;
                            }
                            foreach ($vendorvalue as $key => $vvendors) {
                                if(strpos($cururl,'?live') !== false)
                                {
                                    $tmpcurl = str_replace('?live', '', $cururl);
                                }
                                else{
                                    if(strpos($cururl,'&live') !== false)
                                        $tmpcurl = str_replace('&live', '', $cururl);
                                    else
                                        $tmpcurl = $cururl;
                                }
                                $specialchar = '&';
                                if(!isset($_GET['a']) || strpos($tmpcurl,'&a') !== false)
                                    $specialchar = '?';
                                if(strpos($cururl, $vvendors) === false)
                                {
                                    if(empty($_GET['vendor']) && strpos($tmpcurl, $specialchar.'vendor=') === false){
                                        $urlvendor[$key] = $tmpcurl.$specialchar."vendor=".$vvendors;
                                    }
                                    else{
                                        if(strpos($tmpcurl, $specialchar.'vendor=')!== false)
                                        {
                                            $tmpcurl1 = explode($specialchar.'vendor=', $tmpcurl);
                                            $vvendors = isset($_GET['vendor'])||$vendorname->slug!=""?$vvendors.",":$vvendors;
                                            $tmpcurl1 = $tmpcurl1[0].$specialchar.'vendor='.$vvendors.$tmpcurl1[1];
                                        }
                                        //echodebug($tmpcurl);
                                        $urlvendor[$key] = $tmpcurl1;
                                    }
                                }
                                else{
                                    //del link
                                    $newcurl = str_replace($vvendors,'',$cururl);
                                    if(substr($newcurl, -15)=='?vendor=&live=1') $newcurl= substr($newcurl, 0, -15);
                                    elseif(substr($newcurl, -13)=='?vendor=&live') $newcurl= substr($newcurl, 0, -13);
                                    elseif(substr($newcurl, -8)=='?vendor=')
                                    {
                                            $newcurl= substr($newcurl, 0, -8);
                                    }
                                    elseif(substr($newcurl, -1)=='?') $newcurl= substr($newcurl, 0, -1);
                                    if(strpos($newcurl, '?vendor=,')!==false) $newcurl= str_replace('?vendor=,', '?vendor=', $newcurl);

                                    if(substr($newcurl, -15)=='&vendor=&live=1') $newcurl= substr($newcurl, 0, -15);
                                    elseif(substr($newcurl, -13)=='&vendor=&live') $newcurl= substr($newcurl, 0, -13);
                                    elseif(substr($newcurl, -8)=='&vendor=') $newcurl= substr($newcurl, 0, -8);
                                    elseif(substr($newcurl, -1)=='&') $newcurl= substr($newcurl, 0, -1);
                                    if(strpos($newcurl, '&vendor=,')!==false) $newcurl= str_replace('&vendor=,', '&vendor=', $newcurl);
                                    if(strpos($newcurl, ',,')!==false) $newcurl= str_replace(',,', ',', $newcurl);
                                    if(substr($newcurl, -1)==',') $newcurl= substr($newcurl,0, -1);
                                    if(strpos($newcurl,'?vendor=&a'))
                                        $newcurl = str_replace('?vendor=&', '?', $newcurl);
                                    $urlvendor[$key] = $newcurl;

                                }
                            }
                            $listvendors = array(array_keys(array_count_values($vendorseo)),array_keys(array_count_values($vendorvalue)),array_keys(array_count_values($urlvendor)),array_keys(array_count_values($vendorid)));
                        }
                    }

                }
                $arrayAssignTemplate['listvendors'] = $listvendors;

            }
            if($fvid <=0) {
                //lay display order

                if($getCurrentCat->itemdisplayorder == Core_Productcategory::ITEM_PRICE_ASC)
                {

                    $strOrderBy = 'finalprice';
                    $strSortOrder = 'ASC';
                }
                elseif($getCurrentCat->itemdisplayorder == Core_Productcategory::ITEM_PRICE_DESC)
                {
                    $strOrderBy = 'finalprice';
                    $strSortOrder = 'DESC';

                }
                elseif($getCurrentCat->itemdisplayorder == Core_Productcategory::ITEM_DISPLAYORDER)
                {

                    $strOrderBy = 'displayorder';
                    $strSortOrder = 'ASC';
                }
            }
            //Lay segmentprice va check display order
            $newsegment = array(); //lấy phân khúc giá

            $paginateUrl = $getCurrentCat->getProductcateoryPath();
            $arrayAssignTemplate['paginateurl'] = $paginateUrl;

            $arrayAssignTemplate['attributeList']= $this->addFilterForm($fpcid);


            //////////////////////////////////////////////////////////////////////////

            /////////////////////////////////////////////////////////////////////////
            if(!empty($newsegment))
            {
                $arrayAssignTemplate['attributeList']= $this->addFilterForm($fpcid);
            }//neu la danh muc con
            elseif($getCurrentCat->parentid != 0)//!empty($getCurrentCat->parentid) ||
            {
                $strOrderBy = 'sellprice';
                $strSortOrder = 'DESC';
		        if(empty($order)){
		    		$order = 'gia-cao-den-thap';
		    	}
	    			switch ($order) {
	    				case 'gia-cao-den-thap':
	    				 	$strOrderBy = 'finalprice';
                			$strSortOrder = 'DESC';
	    				break;
	    				case 'gia-thap-den-cao':
	    				 	$strOrderBy = 'finalprice';
                			$strSortOrder = 'ASC';
	    				break;
	    				case 'moi-nhat':
	    				 	$strOrderBy = 'id';
                			$strSortOrder = 'DESC';
	    				break;
	    				case 'ban-chay-nhat':
	    				 	$strOrderBy = 'finalprice';
                			$strSortOrder = 'DESC';
	    				break;
	    				case 'duoc-quan-tam-nhat':
	    				 	$strOrderBy = 'countview';
                			$strSortOrder = 'DESC';
	    				break;
	    			}
	    			$arrayAssignTemplate['order'] = $order;

                $total = Core_Product::getProducts($arrayConditionProduct,'','', 0, true);
                $arrayAssignTemplate['total']       = $total;
                $arrayAssignTemplate['totalPage']   = ceil($total/$this->recordPerPage);
                $arrayAssignTemplate['curPage']     = $arrayAssignTemplate['page'];
                $arrayAssignTemplate['attributeList']= $this->addFilterForm($fpcid);
              	$arrayAssignTemplate['totalproductpage'] = $total - ($arrayAssignTemplate['page'] * $this->recordPerPage) ;

                $listproductcat   = Core_Product::getProducts($arrayConditionProduct,$strOrderBy,$strSortOrder,(($arrayAssignTemplate['page'] - 1)*$this->recordPerPage).','.$this->recordPerPage);
                $listnewpro = array();
                if(!empty($listproductcat)){
                    foreach($listproductcat as $pro){
                    	if($pro->id > 0 && $pro->onsitestatus > 0 && $pro->status == Core_Product::STATUS_ENABLE && $pro->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&  (($pro->sellprice > 0 && $pro->instock > 0) || ($pro->prepaidprice > 0 && $pro->onsitestatus == Core_Product::OS_ERP_PREPAID)  || $pro->onsitestatus == Core_Product::OS_COMMINGSOON || $pro->onsitestatus == Core_Product::OS_DOANGIA)){
                            if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){
                                $newsummary = '';
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
                                $pro->summary = $newsummary;

                                $pro->productspecial = Core_Ads::getBannerListByProuctId($pro->id, 'h');
                                if(!empty($pro->productspecial)) $pro->productspecial = $pro->productspecial[0];
                            }
							$myCategory  = new Core_Productcategory($pro->pcid, true);
							if ($myCategory->appendtoproductname == 1) $pro->name = $myCategory->name.' '.$pro->name;

                            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);
                            if($finalprice > 0) {
                                $pro->sellprice = $finalprice;
                            }
                            if($strOrderBy == 'sellprice' || $fvid > 0)
                            {
                                $getpromotion = $pro->promotionPrice();
                                if(!empty($getpromotion['price']))
                                {
                                    $pro->pricecomparea = $getpromotion['price'];
                                }
                                else
                                    $pro->pricecomparea = $pro->sellprice;
                            }
                            $pro->summary = $newsummary;
                            $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$pro->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                            $listnewpro[$pro->id] = $pro;
                        }
                    }
                }

                $arrayAssignTemplate['listproductcat']    = $listnewpro;

                $fullPathCat = Core_Productcategory::getFullParentProductCategorys($fpcid);
                $arrayAssignTemplate['fullPathCategory'] = $fullPathCat;

                $allChildCategory = array();
                $arr_cat[] = array();
				$listchildsubcate = array();
				$allChildCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$fullPathCat[0]['pc_id'], 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
                foreach ($allChildCategory as $mysubcate) {

	                if (!empty($mysubcate)){


	                		if($mysubcate->id == $fpcid){
	                			$mysubcate->parentcurrent = 1;
	                		}

	                        $listsubsubcate = array();
	                        $parentcurrent = '';
	                        $subcate = Core_Productcategory::getProductcategorys(array('fparentid'=>$mysubcate->id, 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
	                        if(!empty($subcate)){
	                        	foreach ($subcate as $item) {
	                        		if($item->id == $fpcid){
	                        			  $mysubcate->parentcurrent = $item->parentid;
	                        		}
	                        	}
	                       		$mysubcate->subsubcate = $subcate;
	                        }
	                }

	                $listchildsubcate[] = $mysubcate;

                }
          		usort($listchildsubcate, 'sortcategorydesc');
				$arrayAssignTemplate['allChildCategory'] = $listchildsubcate;

            }
            else //danh muc cha
            {
                if($fvid <= 0)
                {
                	$getcatetree = Core_Productcategory::getCategoryTree($fpcid);
                	$listproductmanual = array();
                    $newProductCategory = array();
                    foreach($getcatetree as $cat)
                    {
                        $arrayFormData = $arrayConditionProduct;
                        unset($arrayFormData['fpcidarrin']);
                        $arrayFormData['fpcid'] = $cat->id;

                        $listproduct = array();

                        $listproduct = Core_Product::getProducts($arrayFormData,'sellprice','DESC');


                        if(!empty($listproduct))
                        {
                            foreach($listproduct as $pro){
                            	if($pro->id > 0 && $pro->onsitestatus > 0 && $pro->status == Core_Product::STATUS_ENABLE && $pro->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&  (($pro->sellprice > 0 && $pro->instock > 0) || ($pro->prepaidprice > 0 && $pro->onsitestatus == Core_Product::OS_ERP_PREPAID)  || $pro->onsitestatus == Core_Product::OS_COMMINGSOON || $pro->onsitestatus == Core_Product::OS_DOANGIA))
                                {
                                    if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){
                                        $newsummary = '';
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
                                        $pro->summary = $newsummary;
										$myCategory  = new Core_Productcategory($pro->pcid, true);
										//if ($myCategory->appendtoproductname == 1) $pro->name = $myCategory->name.' '.$pro->name;

                                        //$getProductBannerVer = Core_Ads::getBannerListByProuctId($pro->id, 'v');
                                        $pro->productspecial = Core_Ads::getBannerListByProuctId($pro->id, 'h');
                                        if(!empty($pro->productspecial)) $pro->productspecial = $pro->productspecial[0];

                                    }
                                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);
                                    if($finalprice > 0) {
                                        $pro->finalprice = ($finalprice);
                                    }
                                    else
                                    {
                                         $pro->finalprice = $pro->sellprice;
                                    }

                                    $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$pro->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                                    if($strOrderBy == 'sellprice' || $fvid >0 )
                                    {
                                        $getpromotion = $pro->promotionPrice();
                                        if(!empty($getpromotion['price']))
                                        {
                                            $pro->pricecomparea = $getpromotion['price'];
                                        }
                                        else
                                            $pro->pricecomparea = $pro->sellprice;
                                    }
                                    //$newProductCategory[$cat->id]['cat'] = $cat;

                                    if ($pro->displaymanual <= 0)
                                    	$newProductCategory[$cat->id][] = $pro;
                                    else
                                    	$listproductmanual[] = $pro;
                                }
                            }
                        }
                    }
                    $listfinal = array();
                    $counternews = 0;
                    foreach ($newProductCategory as $idcat=>$catobj)
                    {

                    	$cnt = count($newProductCategory[$idcat]);
                    	if ($counternews < $cnt)
                    	{
                    		$counternews = $cnt;
                    	}
                    }
                    if ($counternews > 0)
                    {
                    	for ($i = 0; $i < $counternews; $i++)
                    	{
                    		foreach ($newProductCategory as $idcat=>$catobj)
                    		{
                    			if (!empty($catobj[$i])) $listfinal[] = $catobj[$i];
                    		}
                    	}
                    }
                    //sort san pham manual
                    usort($listproductmanual,'sortproductmanualasc');
                    // Merge 2 mang san pham
                    $listfinal = array_merge($listproductmanual,$listfinal );


                    $order = $_GET['o'];
                    if(!empty($order)){
                    	if (!empty($listfinal)){
                    		switch ($order) {
                    			case 'gia-cao-den-thap':
                    				usort($listfinal,'sortpricesegmentdesc' );
                    				break;
                    			case 'gia-thap-den-cao':
                    				usort($listfinal,'sortpricesegmentasc' );
                    				break;
                    			case 'moi-nhat':
                    				usort($listfinal,'sortdatedesc' );
                    				break;
                    			case 'ban-chay-nhat':
                    				usort($listfinal,'sortpricesegmentdesc' );
                    				break;
                    			case 'duoc-quan-tam-nhat':
                    				usort($listfinal,'sortinterested' );
                    				break;
                    		}
                    	}
                    }
                    $total = count($listfinal);
                    $arrayAssignTemplate['total']       = $total;
	                $arrayAssignTemplate['totalPage']   = ceil($total/$this->recordPerPage);
	                $arrayAssignTemplate['curPage']     = $arrayAssignTemplate['page'];
	              	$arrayAssignTemplate['totalproductpage'] = $total - ($arrayAssignTemplate['page'] * $this->recordPerPage) ;
                    $limitStart = ($arrayAssignTemplate['page'] - 1) * $this->recordPerPage;
                    $productlist = array_slice( $listfinal, $limitStart,$this->recordPerPage );
	    			$arrayAssignTemplate['order'] = $order;

                    $arrayAssignTemplate['productlists'] = $productlist;



                    //$arrayAssignTemplate['bannerProduct']= $this->getBannerProduct($fpcid,$slug[0]);
                   // $arrayAssignTemplate['attributeList']= $this->addFilterForm($fpcid);
                    $templatepage = 'productparentnew.tpl';
                }
                else{//vendor list process like as child cate
                    $fullPathCat = Core_Productcategory::getFullParentProductCategorys($fpcid);
                    $arrayAssignTemplate['fullPathCategory'] = $fullPathCat;

                    $listproduct = Core_Product::getProducts($arrayConditionProduct,$strOrderBy,$strSortOrder);//them sau ,'fquantitythan0'=>1
                    if(!empty($listproduct))
                    {
                        $newlistproduct = array();
                        foreach($listproduct as $pro)
                        {
                        	if($pro->id > 0 && $pro->onsitestatus > 0 && $pro->status == Core_Product::STATUS_ENABLE && $pro->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&  (($pro->sellprice > 0 && $pro->instock > 0) || ($pro->prepaidprice > 0 && $pro->onsitestatus == Core_Product::OS_ERP_PREPAID)  || $pro->onsitestatus == Core_Product::OS_COMMINGSOON || $pro->onsitestatus == Core_Product::OS_DOANGIA))
                            {
                                if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){
                                    $newsummary = '';
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
                                    $pro->summary = $newsummary;
									$myCategory  = new Core_Productcategory($pro->pcid, true);
									if ($myCategory->appendtoproductname == 1) $pro->name = $myCategory->name.' '.$pro->name;

                                    //$getProductBannerVer = Core_Ads::getBannerListByProuctId($pro->id, 'v');
                                    $pro->productspecial = Core_Ads::getBannerListByProuctId($pro->id, 'h');
                                    if(!empty($pro->productspecial)) $pro->productspecial = $pro->productspecial[0];
                                    /*if(!empty($getProductBannerVer) && $pro->displaytype == Core_Product::DISPLAY_TEXT){
                                        $pro->productspecial = $getProductBannerVer[0];//->getImage()
                                        $newsummary = '';
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
                                        $pro->summary = $newsummary;
                                    }*/
                                    /*if(!empty($getProductBannerHor) && $pro->displaytype == Core_Product::DISPLAY_BANNER){//set noi bat banner moi cho phep chay
                                        $pro->productspecial = $getProductBannerHor[0];//->getImage()
                                    }
                                    else{
                                        //$getProductBannerVer = Core_Ads::getBannerListByProuctId($pro->id, 'v');
                                        $pro->productspecial = $pro;
                                    }*/
                                }

                                //$pro->p_sellprice = (!empty($pro->p_sellprice)?$pro->p_sellprice:0);
                                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);
                                if($finalprice > 0) {
                                    $pro->sellprice = ($finalprice);
                                }
                                else
                                {
                                    $pro->sellprice = ($pro->sellprice);
                                }
                                //$pro->summary = $newsummary;
                                $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$pro->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                                if($strOrderBy == 'sellprice' || $fvid > 0)
                                {
                                    $getpromotion = $pro->promotionPrice();
                                    if(!empty($getpromotion['price']))
                                    {
                                        $pro->pricecomparea = $getpromotion['price'];
                                    }
                                    else
                                        $pro->pricecomparea = $pro->sellprice;
                                }
                                $newlistproduct[] = $pro;
                            }
                        }
                        //usort($newlistproduct, 'sortpricesegmentdesc');
                        $arrayAssignTemplate['listproductcat']    = $newlistproduct;
                    }
                }
            }
            // Lay mau san pham
            //echodebug($productlist);
            $productlistcolors = count( $arrayAssignTemplate['listproductcat']) > 0 ? $arrayAssignTemplate['listproductcat'] : $productlist;
            if(count($productlistcolors) > 0)
            {
                $listProductColor = array();
                $listProductColorTmp = array();
                foreach ($productlistcolors  as $productcoloritem) {
                    //Loop top item list get color if exsist
                    $listProductColorTmp = explode("###", $productcoloritem->colorlist);
                    foreach ($listProductColorTmp as $productColor) {
                        $listProductColor[$productcoloritem->id][] = explode(':', $productColor);
                    }
                }
                unset($listProductColorTmp);
            }
            $arrayAssignTemplate['listProductColor'] = $listProductColor;
            //End lay may san pham

            //load banner
            /*$slidebanner = $this->getBanner($fpcid);
            $counterbanner = ceil(count($slidebanner)/2);
            $this->registry->smarty->assign(
                array(
                    'slidebanner'           =>  (!empty($slidebanner)?array_slice($slidebanner, 0, $counterbanner):null),
                    'slidebanner2'           =>  (!empty($slidebanner)?array_slice($slidebanner, $counterbanner):null),
                    'rightbanner'           =>  $this->getBanner($fpcid, 6),
                )
            );

            $banner = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productbanner.tpl');
			*/

            // Get top dan pham ban chay
            $topproid = explode(',', $getCurrentCat->topitemlist);
            $listtopprouct = array();
            foreach ($topproid as $id){

            	$topproduct = new Core_Product($id);
            	if($topproduct->id > 0 && $topproduct->onsitestatus >0 && $topproduct->status == Core_Product::STATUS_ENABLE && $topproduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN  && (($topproduct->sellprice > 0 && $topproduct->instock > 0) || $topproduct->prepaidprice > 0))
               	{
               		$topproduct->summarynew = explode('#', $topproduct->summarynew);
					$listtopprouct[] = $topproduct;
               	}
            }
            //var_dump($listtopprouct);die;
            // Get list product top color
            if(count($listtopprouct) > 0)
            {
                $listTopProductColor = array();
                $listTopProductTmp = array();
                foreach ($listtopprouct as $keypromotion => $promotionitem) {
                    //Loop top item list get color if exsist
                    $listTopProductTmp = explode("###", $promotionitem->colorlist);
                    foreach ($listTopProductTmp as $productPromotionColor) {
                        $listTopProductColor[$promotionitem->id][] = explode(':', $productPromotionColor);
                    }
                }
            }
            // End list product top color
            $arrayAssignTemplate['listtopprouct'] = $listtopprouct;
            $arrayAssignTemplate['listTopProductColor'] = $listTopProductColor; //Color list
            $arrVendorselect =  $vendorslug;
            $showpageonpagetitle = ($arrayAssignTemplate['page'] > 1? ' - Trang '.$arrayAssignTemplate['page']:'');
            if($fvid > 0)
            {
                $arrayAssignTemplate['pageCanonical'] = $arrayAssignTemplate['myVendors']->getVendorPath($fpcid);//$arrayAssignTemplate['paginateurl'].$arrayAssignTemplate['myVendors']->slug;
                $arrayAssignTemplate['pageTitle'] = $arrayAssignTemplate['myVendors']->name.' - '.(!empty($getCurrentBrand->seotitle)?$getCurrentBrand->seotitle:$getCurrentCat->seotitle).$showpageonpagetitle;
                $arrayAssignTemplate['pageKeyword'] = $arrayAssignTemplate['myVendors']->name.', '.(!empty($getCurrentBrand->seokeyword)?$getCurrentBrand->seokeyword:$getCurrentCat->seokeyword);
                $arrayAssignTemplate['pageDescription'] = $arrayAssignTemplate['myVendors']->name.' - '.(!empty($getCurrentBrand->seodescription)?$getCurrentBrand->seodescription:$getCurrentCat->seodescription);
                $arrayAssignTemplate['pageMetarobots'] = (!empty($getCurrentBrand->metarobot)?$getCurrentBrand->metarobot:'');
                $arrayAssignTemplate['footerkey'] = (!empty($getCurrentBrand->footerkey)?$getCurrentBrand->footerkey:$getCurrentCat->footerkey);
            }
            else {
                $arrayAssignTemplate['pageCanonical'] = $arrayAssignTemplate['paginateurl'];
                $arrayAssignTemplate['pageTitle'] = (!empty($getCurrentCat->seotitle)?$getCurrentCat->seotitle:$getCurrentCat->name).$showpageonpagetitle;
                $arrayAssignTemplate['pageKeyword'] = $getCurrentCat->seokeyword;
                $arrayAssignTemplate['pageDescription'] = $getCurrentCat->seodescription;
                $arrayAssignTemplate['pageMetarobots'] = (!empty($getCurrentCat->metarobot)?$getCurrentCat->metarobot:'');
                $arrayAssignTemplate['footerkey'] = (!empty($getCurrentCat->footerkey)?$getCurrentCat->footerkey:'');
                $arrayAssignTemplate['fvid'] = $fvid;

            }

            //lay bai viet lien quan cua danh muc
            $newslist = array();
            $newscategorylist = Core_Newscategory::getNewsCategoryFromProductcategory($fpcid);
            if( count($newscategorylist) > 0 )
            {
                $newslist = Core_News::getNewss(array('fncidarr' => $newscategorylist) , 'datecreated' , 'DESC' , '0,3');
            }
            $myNewscategory = new Core_Newscategory($newscategorylist[0] , true);
            $arrayAssignTemplate['newslist'] = $newslist;
            $arrayAssignTemplate['myNewscategory'] = $myNewscategory;

            $arrayAssignTemplate['fpcid'] = $fpcid;
            $arrayAssignTemplate['fvidlist'] = $fvidlist;
            $arrayAssignTemplate['arrVendorselect'] = $arrVendorselect;
            $arrayAssignTemplate['promotion'] = $promotion;
            //$arrayAssignTemplate['banner'] = $banner;
            $arrayAssignTemplate['listChildCat'] = $getAllChildCategory;
            $this->registry->smarty->assign($arrayAssignTemplate);

        	// IF subdomain cache filter
 			if(SUBDOMAIN == 'm'){
 				$keyfilter = 'mfilter_' . $fpcid;
 				$cachefilter = new Cacher($keyfilter);
 				if(isset($_GET['live'])){
 					$cachefilter->clear();
 				}
 				$productfilter = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'filter.tpl');
 				$cachefilter->set($productfilter);
 			}

            $producttop = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'producttopnew.tpl');

            $arrayAssignTemplate['producttop'] = $producttop;
            //$arrayAssignTemplate['hideMenu'] = 1;

            $arrayAssignTemplate['productdisplaytext'] = Core_Product::DISPLAY_TEXT;
            $arrayAssignTemplate['productdisplaybanner'] = Core_Product::DISPLAY_BANNER;

            $internaltopbar_refreshurl = Helper::curPageURL();
            $internaltopbar_refreshurl = $internaltopbar_refreshurl.(strpos($internaltopbar_refreshurl,'?')===false?'?customer=1&live':'&customer=1&live');
            $arrayAssignTemplate['internaltopbar_editurl'] = $this->registry->conf['rooturl'].'cms/productcategory/edit/id/'.$fpcid;
            $arrayAssignTemplate['internaltopbar_refreshurl'] = $internaltopbar_refreshurl;
            $vendorurlforstat = '';
            if ($fvid > 0)
            {
				if (is_array($fvid))
				{
					$vendorurlforstat .= '&vid='.implode(',', $fvid);
				}
				else $vendorurlforstat .= '&vid='.$fvid;
            }
            elseif (!empty($arrayConditionProduct['fvidarr'])){
				$vendorurlforstat .= '&vid='.implode(',', $arrayConditionProduct['fvidarr']);
            }
            $arrayAssignTemplate['internaltopbar_reporturl'] = $this->registry->conf['rooturl'] . '/stat/report/productcategory?id='.$fpcid.$vendorurlforstat;
            $arrayAssignTemplate['internaltopbar_objectid'] = $fpcid;
            $arrayAssignTemplate['internaltopbar_reporttype'] = 'productcategory';

            $this->registry->smarty->assign( $arrayAssignTemplate );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$templatepage);

            $this->registry->smarty->assign(array('contents' => $contents));

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');

            $myCache->set($pageHtml);
        }

        //for View Tracking
        $_GET['trackingid'] = $fpcid;
        echo $pageHtml;
    }

    function searchAction()
    {

        if(!isset($_GET['pcid']))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }

        //$attribute = $_GET['a'];
        //if(!empty($))
        $error = array();
        $fpcid = $_GET['pcid'];
        $fvid = (int)(isset($_GET['fvid'])?$_GET['fvid']:0);
        $fvidlist = isset($_GET['vendor'])?$_GET['vendor']:'';
        $getCurrentCat    = new Core_Productcategory($fpcid);
        $promotion = $_GET['f'];
        $ispromotion = 0;
        if ($promotion == 'khuyen-mai'){
        	$ispromotion = 1;
        }
        //Getslugbanner/////////////////////////
        $slug = Helper::slugBannerURL();
        $slug = explode("?",$slug);
        //End Getslugbanner/////////////////////
        if(empty($getCurrentCat))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        ini_set('memory_limit','300M');
        $formData = array();

//        $arrayAssignTemplate['paginateurl'] = preg_replace('/\/page\-[0-9]+/', '', Helper::curPageURL());
//        if($fvid > 0)
//        {
//            if (substr($arrayAssignTemplate['paginateurl'], -1, 1) == '/')
//                $arrayAssignTemplate['paginateurl'] = substr($arrayAssignTemplate['paginateurl'], 0, -1);
//
//            if(strpos($arrayAssignTemplate['paginateurl'], '?') !== false)
//                $arrayAssignTemplate['paginateurl'] = substr($arrayAssignTemplate['paginateurl'], 0, strpos($arrayAssignTemplate['paginateurl'], '?'));
//        }
//        else
//        {
//            if(strpos( $arrayAssignTemplate['paginateurl'], '?')!==false) {
//                $indexpos                           = strpos( $arrayAssignTemplate['paginateurl'], '?');
//                $arrayAssignTemplate['joinpaginationlink']                 = substr( $arrayAssignTemplate['paginateurl'], $indexpos );
//                $arrayAssignTemplate['paginateurl'] = substr( $arrayAssignTemplate['paginateurl'], 0, $indexpos);
//             }
//        }
        $paginateUrl = $getCurrentCat->getProductcateoryPath();
       	$arrayAssignTemplate['paginateurl'] = $paginateUrl;
        $getAllChildCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$fpcid,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');

        if($fvidlist != '') {
            $vendorslug = explode(",", $fvidlist);
            $vendorlist = Core_Vendor::getVendors(array('fslugarr'=>$vendorslug),'','');
            $vid = array();
            foreach ($vendorlist as $vl) {
                $vid[] = $vl->id;
            }
            $formData['fvidarr'] = $vid;
            $myVendor = new Core_Vendor();

            $myVendorsList = Core_Vendor::getVendors(array('fidin'=>$vid), '','');
            foreach ($myVendorsList as $myVendorsL) {
                if($myVendorsL->topseokeyword != '')
                {
                    $arrayAssignTemplate['headertext'] .= $myVendorsL->topseokeyword.",";
                    $newtopseokeyword .= ",".$myVendorsL->topseokeyword;
                }
                $newname .= ",".$myVendorsL->name;
                $newslug .= ",".$myVendorsL->slug;
            }
            if($newtopseokeyword != '')
                $myVendor->topseokeyword = substr($newtopseokeyword,1);
            $myVendor->name = substr($newname, 1);
            $myVendor->arrslug = substr($newslug, 1);
        }elseif($fvid > 0){
            $flaglink = 1;
            $fvid = explode(',', $fvid);
            $formData['fvidarr'] = $fvid;
            $arrayAssignTemplate['myVendors'] = new Core_Vendor($fvid[0], true);
            $myVendors = Core_Vendor::getVendors(array('fidin'=>$fvid),'','');
            $myVendor = $myVendors[0];
            if (!empty($arrayAssignTemplate['myVendors']->topseokeyword))
                $arrayAssignTemplate['headertext'] = $arrayAssignTemplate['myVendors']->topseokeyword;
            $pageCanonical = $arrayAssignTemplate['myVendors']->getVendorPath($fpcid);
        }else{
             $pageCanonical = $arrayAssignTemplate['paginateurl'];
        }

        $pageCanonical = '';
        $geturl = array();
        if(count($fvidlist) > 0)
        {
            $geturl[] = 'vendor=' . $fvidlist;
        }

        $filterparamstr = (string)$_GET['a'];
        if(strlen($filterparamstr) > 0)
        {
            $filterparams = explode(',' , $filterparamstr);
            $listfilter = array();
            if(count($filterparams) > 0)
            {
                for($i = 0 , $counter = count($filterparams) - 1 ; $i < $counter ; $i+=2)
                {
                    $listfilter[] = $filterparams[$i] . ',' . $filterparams[$i+1];
                }
            }

            //sort param
            asort($listfilter);
            $listfilter = array_reverse( $listfilter );
            $geturl[] = 'a=' . implode(',' , $listfilter);
        }

        if(isset($_GET['pricefrom']))
        {
            $geturl[] = 'pricefrom=' . (string)$_GET['pricefrom'];
        }

        if(isset($_GET['priceto']))
        {
            $geturl[] = 'priceto=' . (string)$_GET['priceto'];
        }

        $pageCanonical = $arrayAssignTemplate['paginateurl'] . '?' . implode('&' , $geturl);

        $arr_catid = array($fpcid);
        if(!empty($getAllChildCategory))
        {
            foreach($getAllChildCategory as $cat)
            {
                $arr_catid[] = $cat->id;
            }
            $getAllChildCategory[count($getAllChildCategory)] = $getCurrentCat;
        }
        else
        {
            $getAllChildCategory[0] = $getCurrentCat;
        }

        /*start vendor*/
        $listvendors = array();
//        if(count($getAllChildCategory) == 1)//nganh hang con
//        {
            if(!empty($getCurrentCat->vendorlist))
            {
                $idvendors = trim($getCurrentCat->vendorlist);
                $vendoridlist = explode(',', $idvendors);
                if(!empty($vendoridlist))
                {
                    foreach($vendoridlist as $vid)
                    {
                        if(!empty($vid))
                        {
                            $myVen = new Core_Vendor($vid, true);
                            $listvendors[] = $myVen;
                            unset($myVen);
                        }
                    }
                }
            }
            else{
                $listvendors = Core_Product::getVendorFromCategories($arr_catid);
            }
            if(count($listvendors > 0))
            {
                 /**/
                 if($flaglink != 1)
                {
                    $afilter = isset($_GET['a']) && $_GET['a'] != ""?"&a=".$_GET['a']:"";
                    $cururl = $this->registry->conf['rooturl'].$getCurrentCat->slug."?vendor=".$_GET['vendor'].$afilter;
                }
                else{
                     $afilter = isset($_GET['a']) && $_GET['a'] != ""?"&a=".$_GET['a']:"";
                    $vendorname = new Core_Vendor($fvid[0]);
                    $cururl = $this->registry->conf['rooturl'].$getCurrentCat->slug."?vendor=".$vendorname->slug.$afilter;
                }
                if(count($listvendors) > 0)
                {
                    $vendorvalue = array();
                    $vendorseo = array();
                    $urlvendor = array();
                    foreach ($listvendors as $key => $listvendor) {
                        $vendorseo[]= $listvendor->name;
                        $vendorvalue[] = $listvendor->slug;
                    }
                    foreach ($vendorvalue as $key => $vvendors) {
                        if(strpos($cururl,'?live') !== false)
                        {
                            $tmpcurl = str_replace('?live', '', $cururl);
                        }
                        else{
                            if(strpos($cururl,'&live') !== false)
                                $tmpcurl = str_replace('&live', '', $cururl);
                            else
                                $tmpcurl = $cururl;
                        }
                        $specialchar = '&';
                        if(!isset($_GET['a']) || strpos($tmpcurl,'&a') !== false)
                            $specialchar = '?';
                        if(strpos($cururl, $vvendors) === false)
                        {
                            if(empty($_GET['vendor'])&& strpos($tmpcurl, $specialchar.'vendor=') === false){
                                $urlvendor[$key] = $tmpcurl.$specialchar."vendor=".$vvendors;
                            }
                            else{
                                if(strpos($tmpcurl, $specialchar.'vendor=')!== false)
                                {
                                    $tmpcurl1 = explode($specialchar.'vendor=', $tmpcurl);
                                    $vvendors = isset($_GET['vendor'])||$vendorname->slug!=""?$vvendors.",":$vvendors;
                                    $tmpcurl1 = $tmpcurl1[0].$specialchar.'vendor='.$vvendors.$tmpcurl1[1];
                                }
                                //echodebug($tmpcurl);
                                $urlvendor[$key] = $tmpcurl1;
                            }
                        }
                        else{
                            //del link
                            $newcurl = str_replace($vvendors,'',$cururl);
                            if(substr($newcurl, -15)=='?vendor=&live=1') $newcurl= substr($newcurl, 0, -15);
                            elseif(substr($newcurl, -13)=='?vendor=&live') $newcurl= substr($newcurl, 0, -13);
                            elseif(substr($newcurl, -8)=='?vendor=')
                            {
                                    $newcurl= substr($newcurl, 0, -8);
                            }
                            elseif(substr($newcurl, -1)=='?') $newcurl= substr($newcurl, 0, -1);
                            if(strpos($newcurl, '?vendor=,')!==false) $newcurl= str_replace('?vendor=,', '?vendor=', $newcurl);

                            if(substr($newcurl, -15)=='&vendor=&live=1') $newcurl= substr($newcurl, 0, -15);
                            elseif(substr($newcurl, -13)=='&vendor=&live') $newcurl= substr($newcurl, 0, -13);
                            elseif(substr($newcurl, -8)=='&vendor=') $newcurl= substr($newcurl, 0, -8);
                            elseif(substr($newcurl, -1)=='&') $newcurl= substr($newcurl, 0, -1);
                            if(strpos($newcurl, '&vendor=,')!==false) $newcurl= str_replace('&vendor=,', '&vendor=', $newcurl);
                            if(strpos($newcurl, ',,')!==false) $newcurl= str_replace(',,', ',', $newcurl);
                            if(substr($newcurl, -1)==',') $newcurl= substr($newcurl,0, -1);
                            if(strpos($newcurl,'?vendor=&a'))
                                $newcurl = str_replace('?vendor=&', '?', $newcurl);
                            $urlvendor[$key] = $newcurl;

                        }
                    }
                    $urlprice = array();

                    if(isset($_GET['pricefrom']) || isset($_GET['priceto'])){
                    	foreach ($urlvendor as $url) {
                    		$url = $url . '&pricefrom=' .  $_GET['pricefrom'] . '&priceto=' . $_GET['priceto'];
                    		$urlprice[] = $url;
                    	}

                    	$urlvendor = $urlprice;
                    }

                    $listvendors = array($vendorseo,$vendorvalue,$urlvendor);
                }
            }
//        }
//        elseif (count($getAllChildCategory) > 1)
//        {
//            foreach ($getAllChildCategory as $childcat)
//            {
//                if (!empty($childcat->vendorlist))
//                {
//                    $idvendors = trim($childcat->vendorlist);
//                    $vendoridlist = explode(',', $idvendors);
//                    if(!empty($vendoridlist))
//                    {
//                        $vendorchild = array();
//                        foreach($vendoridlist as $vid)
//                        {
//                            if(!empty($vid))
//                            {
//                                $myVen = new Core_Vendor($vid, true);
//                                $vendorchild[] = $myVen;
//                                unset($myVen);
//                            }
//                        }
//                        $listvendors[$childcat->id] = $vendorchild;
//                    }
//                }
//                else
//                {
//                    $listvendors[$childcat->id] = Core_Product::getVendorFromCategories(array($childcat->id));
//                }
//            }
//
//        }
        /*End vendor*/

        //$formData['fpcidarrin'] = $arr_catid;
        $joinpaginationlink = '';
        //pagination for product
        $paginateUrl = preg_replace('/\/page\-[0-9]+/', '', Helper::curPageURL());//$getCurrentCat->getProductcateoryPath();
        if(strpos($paginateUrl, '?')!==false) {
            $indexpos = strpos($paginateUrl, '?');
            $joinpaginationlink = substr($paginateUrl, $indexpos );
            $paginateUrl = substr($paginateUrl, 0, $indexpos);
        }
        if(isset($_GET['a']) || isset($_GET['pricefrom']) || isset($_GET['priceto']))//fattribute
        {
            $formData = array_merge($formData, $_GET);
            $attrList = array();//product attribute valueseo
            //$attrListNameSEO = array();//product attribute filter
            //$attrListPAValueSEO = array();//Rel product attribute
            $arrListSearch = array();// key =>paf.pa_nameseo, value; gia tri can search

            $queryString = '';
            $arrstringbreadcum = array();

            //echodebug($formData,true);
            if(!empty($formData['a']))
            {
                $getfilterproduct = array();
                /*if(!empty($_SESSION['ses_filterproduct'])){
					$getfilterproduct = $_SESSION['ses_filterproduct'];
					if(!in_array($formData['a'], $getfilterproduct))$getfilterproduct[count($getfilterproduct)] = $formData['a'];
                }
                else $getfilterproduct[0] = $formData['a'];
                */
                //$_SESSION['ses_filterproduct'] = $getfilterproduct;
                //$listattr = explode(',', implode(',',$getfilterproduct));
                $listattr = explode(',', $formData['a']);
                $countlist = count($listattr);
                if($countlist > 1)
                {
                    //$joinstring = array();
                    for($i = 0; $i< $countlist; $i+=2)
                    {
                        if(!empty($listattr[$i]) && !empty($listattr[$i+1]))
                        {
                            $getfilterproduct[] = trim(Helper::plaintext($listattr[$i])).','.trim(Helper::plaintext($listattr[$i+1]));
                            $arrListSearch[trim(Helper::plaintext($listattr[$i]))][] = trim(Helper::plaintext($listattr[$i+1]));
                            //$attrListNameSEO[] = trim(Helper::plaintext($listattr[$i]));
                            //$attrListPAValueSEO[] = trim(Helper::plaintext($listattr[$i+1]));
                        }
                    }
                    if(!empty($getfilterproduct)) {
                        $_SESSION['ses_filterproduct'] = $getfilterproduct;
                    }
                }

            }

            if(isset($_GET['pricefrom']))
            {
                $pricefrom = (float)$_GET['pricefrom'];
            }

            if(isset($_GET['priceto']))
            {
                $priceto = (float)$_GET['priceto'];
            }


            if(count($arrListSearch) > 0 || $pricefrom > 0 || $priceto > 0)
            {
                //$formData['fvalue'] = $arrListSearch;
                //$paginateUrl .= '?a='.$_GET['a']; truyen vo bien favlue

                if((int)$_GET['auto'] == 1)
                {

                    $listarray = Core_RelProductAttribute::getProductIdByFilter(array('fvalue' => $arrListSearch, 'fpcid' => $fpcid , 'fauto' => 1, 'fispromotion'=>$ispromotion , 'pricefrom' => $pricefrom , 'priceto' => $priceto), 'pid' , 'ASC');
                }
                else
                {

                    $listarray = Core_RelProductAttribute::getProductIdByFilter(array('fvalue' => $arrListSearch, 'fpcid' => $fpcid, 'fispromotion'=>$ispromotion , 'pricefrom' => $pricefrom , 'priceto' => $priceto), 'pid' , 'ASC');

                }

                if(!empty($listarray))
                {
                    $formData['fidarr'] = $listarray;
                }
                else {
                    $error[]= $this->registry->lang['controller']['filterproductnotfound'];
                }

                //clear cache
                $fvid = (isset($_GET['vendor'])?$_GET['vendor']:'');
                //$cachefile = (SUBDOMAIN == 'm' ? 'mproductpage'.$fpcid.$fvid.'.html' : 'mproductpage'.$fpcid.$fvid.'.html');
                //$myCache = new cache($cachefile, $this->registry->setting['cache']['site']);
                //$myCache->clear($cachefile);

            }
        }

        //su dung cho chuc nang filter thuoc tinh trong admin
        if(!isset($_GET['auto']))
        {
            $formData['fpricethan0'] = 1;
            //$formData['fquantitythan0'] = 1;
            $formData['fisonsitestatus'] = 1;
            $formData['fstatus'] = Core_Product::STATUS_ENABLE;
            $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
        }

        $page             = (int)($_GET['page'])>0?(int)($_GET['page']):1;
        $total            = Core_Product::getProducts($formData,'','', 0, true);
        $totalPage        = ceil($total/$this->recordPerSearchPage);
        $curPage          = $page;
        $listproductcat   = null;

//        $timer = new Timer();
//        $timer->start();
        if(!empty($formData['fidarr'])) {
            foreach ($formData['fidarr'] as $fpid)
            {
                $pro = new Core_Product($fpid);

                if ($pro->id > 0 && (empty($formData['fvidarr']) || in_array($pro->vid, $formData['fvidarr'])) && $pro->customizetype == Core_Product::CUSTOMIZETYPE_MAIN && $pro->status == Core_Product::STATUS_ENABLE && (($pro->onsitestatus == Core_Product::OS_DM_PREPAID && $pro->prepaidstartdate <= time() && $pro->prepaidenddate >= time()) || ($pro->onsitestatus > 0 && $pro->instock > 0)))
                {
                    //if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){
                        $newsummary = '';
                        $explodenewsummary = explode("\n",strip_tags($pro->summary));//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
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
                        $myCategory  = new Core_Productcategory($pro->pcid, true);
						if ($myCategory->appendtoproductname == 1) $pro->name = $myCategory->name.' '.$pro->name;
                        $pro->summary = $newsummary;
                        $pro->productspecial = Core_Ads::getBannerListByProuctId($pro->id, 'h');
                        if(!empty($pro->productspecial)) $pro->productspecial = $pro->productspecial[0];

                    //}

                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);
                    if($finalprice > 0) {
                        $pro->sellprice = ($finalprice);
                    }
                    else
                    {
                        $pro->sellprice = ($pro->sellprice);
                    }
                    $getpromotion = $pro->promotionPrice();
                    if(!empty($getpromotion['price']))
                    {
                        $pro->pricecomparea = $getpromotion['price'];
                    }
                    else
                        $pro->pricecomparea = $pro->sellprice;

                    $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$pro->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                    $listnewpro[] = $pro;
                }

                //echodebug($listnewpro , true);
            }
            //$listproductcat   = Core_Product::getProducts($formData,'','',(($page - 1)*$this->recordPerSearchPage).','.$this->recordPerSearchPage);
        }
        //
//        $timer->stop();
//        echo 'time : ' . $timer->get_exec_time() . '<br />';

        	$order = $_GET['o'];
    		if(empty($order)){
    			$order = 'gia-cao-den-thap';
    		}

    		if(!empty($listnewpro)){
	            // sort
	            switch ($order) {
	    			case 'gia-cao-den-thap':
	    			 	usort($listnewpro,'sortpricesegmentdesc' );
	    			break;
	    			case 'gia-thap-den-cao':
	    			 	usort($listnewpro,'sortpricesegmentasc' );
	    			break;
	    			case 'moi-nhat':
	    			 	usort($listnewpro,'sortdatedesc' );
	    			break;
	    			case 'ban-chay-nhat':
	    			 	usort($listnewpro,'sortpricesegmentdesc' );
	    			break;
	    			case 'duoc-quan-tam-nhat':
	    			 	usort($listnewpro,'sortinterested' );
	    			break;
	    		}
    		}
//     	if(!empty($listproductcat)){
//		    usort($listproductcat, 'sortpricesegmentdesc');
//		}
        /*$this->registry->smarty->assign(
                array(
                    'slidebanner'           =>  $this->getBanner($fpcid),
                    'rightbanner'           =>  $this->getBanner($fpcid, 6),
                )
        );*/
        //load banner
        /*    $slidebanner = $this->getBanner($fpcid);
            $counterbanner = ceil(count($slidebanner)/2);
            $this->registry->smarty->assign(
                    array(
                        'slidebanner'           =>  array_slice($slidebanner, 0, $counterbanner),
                        'slidebanner2'           =>  array_slice($slidebanner, $counterbanner),
                        'rightbanner'           =>  $this->getBanner($fpcid, 6),
                    )
            );
        $banner = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productbanner.tpl');
		*/

    	$fullPathCat = Core_Productcategory::getFullParentProductCategorys($fpcid);

//    	$allChildCategory = array();
//    	$arr_cat[] = array();
//    	$getsubcatehomepage = Core_Homepage::getHomepages(array('ftype' => Core_Homepage::TYPE_PRODUCT, 'fcategory' => $fullPathCat[0]['pc_id']), 'id', 'ASC');
//    	if(!empty($getsubcatehomepage[0]) && !empty($getsubcatehomepage[0]->subcategory)){
//    		$explodesubcate = explode(',', $getsubcatehomepage[0]->subcategory);
//    		if(!empty($explodesubcate)){
//    			foreach($explodesubcate as $subcat){
//    				if(!empty($subcat)){
//    					$arr_cat[] = $subcat;
//    					$mysubcate = new Core_Productcategory($subcat, true);
//    					if($mysubcate->id > 0) $allChildCategory[] = $mysubcate;
//    				}
//    			}
//    		}
//    	}

    	$listchildsubcate = array();
		$allChildCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$fullPathCat[0]['pc_id'], 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
		foreach ($allChildCategory as $mysubcate) {

			if (!empty($mysubcate)){


				if($mysubcate->id == $fpcid){
					$mysubcate->parentcurrent = 1;
				}

				$listsubsubcate = array();
				$parentcurrent = '';
				$subcate = Core_Productcategory::getProductcategorys(array('fparentid'=>$mysubcate->id, 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
				if(!empty($subcate)){
					foreach ($subcate as $item) {
						if($item->id == $fpcid){
							$mysubcate->parentcurrent = $item->parentid;
						}
					}
					$mysubcate->subsubcate = $subcate;
				}
			}

			$listchildsubcate[] = $mysubcate;

		}
		usort($listchildsubcate, 'sortcategorydesc');
		$allChildCategory = $listchildsubcate;

    	if(!empty($formData['vendor'])){
    		$arrVendorselect = explode(',', $formData['vendor']);
    	}

    	$attributeList =  $this->addFilterForm($fpcid);
    	// detect url sort
    	$urlsort = '';
    	if($myVendor->arrslug){
    		$urlsort .= '?vendor=' . $myVendor->arrslug;
    		if($attributeList['VALUE']){
    			$urlsort .= '&a=' . $attributeList['VALUE'];
    		}
    		if(!empty($_GET['f'])){
    			$urlsort .= '&f=khuyen-mai';
    		}
    		if( !empty($_GET['pricefrom']) || !empty($_GET['priceto'])){

    			$urlsort .= '&pricefrom=' . $_GET['pricefrom'] . '&priceto=' . $_GET['priceto'];
    		}

    	}elseif($attributeList['VALUE']){
    		$urlsort .= '?a=' . $attributeList['VALUE'];
    		if(!empty($_GET['f'])) $urlsort .= '&f=khuyen-mai';
    		if( !empty($_GET['pricefrom']) || !empty($_GET['priceto'])){

    			$urlsort .= '&pricefrom=' . $_GET['pricefrom'] . '&priceto=' . $_GET['priceto'];
    		}
    	}else{
    		if(!empty($_GET['f'])){
    			$urlsort .= '?f=khuyen-mai';
	    		if( !empty($_GET['pricefrom']) || !empty($_GET['priceto'])){

	    			$urlsort .= '&pricefrom=' . $_GET['pricefrom'] . '&priceto=' . $_GET['priceto'];
	    		}
    		}else{
	    		if( !empty($_GET['pricefrom']) || !empty($_GET['priceto'])){

	    			$urlsort .= '?pricefrom=' . $_GET['pricefrom'] . '&priceto=' . $_GET['priceto'];
	    		}
    		}
    	}
        //echodebug($attributeList);
        $getCurrentBrand = Core_BrandCategory::getDatabyVendor($fvid, $fpcid);
        $this->registry->smarty->assign(
            array(
                //'banner'            =>  $banner,
                'attributeselected' =>  (!empty($_GET['a'])?$_GET['a']:''),
                'attributeList'    => $attributeList,
                'formData'             =>  $formData,
                'listproductcat'    =>  $listproductcat,//$listnewpro,
                'curCategory'       =>  $getCurrentCat,
                'headertext'       =>  (!empty($myVendor->topseokeyword)?$myVendor->topseokeyword:$getCurrentCat->topseokeyword),
                'listChildCat'      => $getAllChildCategory,
                'paginateurl'      => $paginateUrl,
                'joinpaginationlink'      => $joinpaginationlink,
                'error'             =>  $error,
                'listvendors'       =>  $listvendors,
                'myVendors'       =>  $myVendor,
                'curCategory'             =>  $getCurrentCat,
                'currentTime'           	=> time(),
                'pageCanonical'             => (!empty($arrayAssignTemplate['paginateurlcanoical'])?$arrayAssignTemplate['paginateurlcanoical']:$pageCanonical),
                'curBrand'             => $getCurrentBrand,
                'slugcategory'=>$getCurrentCat->slug,
                'singlevendorname'=>$vendorname->slug,
            	'allChildCategory' => $allChildCategory,
            	'fullPathCategory' => $fullPathCat,
            	'fpcid' => $fpcid,
            	'arrVendorselect' =>$arrVendorselect,
            	'urlsort' => $urlsort
            )
        );

        $producttop = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'producttopnew.tpl');

        $internaltopbar_refreshurl = Helper::curPageURL();
        $internaltopbar_refreshurl = $internaltopbar_refreshurl.(strpos($internaltopbar_refreshurl,'?')===false?'?customer=1&live':'&customer=1&live');

        $vendorurlforstat = '';
        if ($fvid > 0)
        {
			if (is_array($fvid))
			{
				$vendorurlforstat .= '&vid='.implode(',', $fvid);
			}
			else $vendorurlforstat .= '&vid='.$fvid;
        }
        elseif (!empty($formData['fvidarr'])){
			$vendorurlforstat .= '&vid='.implode(',', $formData['fvidarr']);
        }
        if (!empty($_GET['a']))
        {
			$vendorurlforstat .= '&a='.$_GET['a'];
        }


         // Get top dan pham ban chay
         	$listtopprouct = array();
            if($getCurrentCat->topitemlist != ''){
	            $topproid = explode(',', $getCurrentCat->topitemlist);
	            foreach ($topproid as $id){

	            	$topproduct = new Core_Product($id);
	            	if($topproduct->id > 0 && $topproduct->onsitestatus >0 && $topproduct->status == Core_Product::STATUS_ENABLE && $topproduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN  && (($topproduct->sellprice > 0 && $topproduct->instock > 0) || $topproduct->prepaidprice > 0))
	               	{
	               		$topproduct->summarynew = explode('#', $topproduct->summarynew);
						$listtopprouct[] = $topproduct;
	               	}
	            }
    		}
            //get list color listproductcate
        if(count($listnewpro) > 0)
        {
            $listNewProColor = array();
            $listNewProColorTmp = array();
            foreach ($listnewpro as $keypromotion => $listnewproitem) {
                //Loop top item list get color if exsist
                $listNewProColorTmp = explode("###", $listnewproitem->colorlist);
                foreach ($listNewProColorTmp as $productnewproColor) {
                    $listNewProColor[$listnewproitem->id][] = explode(':', $productnewproColor);
                }
            }
        }
        //echodebug($listNewProColor);
        //End get list color listproductcate

        $this->registry->smarty->assign(
            array(
            	'order' => $order,
                'producttop'            =>  $producttop,
                'breadcumsearch'        =>  (!empty($arrstringbreadcum)?implode(', ',$arrstringbreadcum):''),
                //'hideMenu'            =>  1,
                //'attributeList'    => $this->addFilterForm($fpcid),
                'paginateUrl'       =>  $paginateUrl,
                'total'             =>  $total,
                'myVendor'       =>  $myVendor,
                'formData'             =>  $formData,
                'totalPage'         =>  $totalPage,
                'curPage'           =>  $curPage,
                'listproductcat'    =>  $listnewpro,
                'listNewProColor'   => $listNewProColor,
                'curCategory'       =>  $getCurrentCat,
                'listChildCat'      => $getAllChildCategory,
                'pageTitle'                 => (!empty($myVendor->name)?$myVendor->name .' - ': '') . (!empty($getCurrentBrand->seotitle)?$getCurrentBrand->seotitle:$getCurrentCat->seotitle),
                'pageKeyword'               =>  $myVendor->name .', '.(!empty($getCurrentBrand->seokeyword)?$getCurrentBrand->seokeyword:$getCurrentCat->seokeyword),
                'pageCanonical'             => (!empty($arrayAssignTemplate['paginateurlcanoical'])?$arrayAssignTemplate['paginateurlcanoical']:$pageCanonical),
                'pageDescription'           => $myVendor->name .' - '.(!empty($getCurrentBrand->seodescription)?$getCurrentBrand->seodescription:$getCurrentCat->seodescription),
                'pageMetarobots'           => (!empty($getCurrentBrand->metarobot)?$getCurrentBrand->metarobot:''),
                'error' => $error,
                'currentTime'           	=> time(),
                'productdisplaytext'           	=> Core_Product::DISPLAY_TEXT,
                'productdisplaybanner'           	=> Core_Product::DISPLAY_BANNER,
                'productdisplaybanner'           	=> Core_Product::DISPLAY_BANNER,
                'bannerProduct'             => $this->getBannerProduct($fpcid,$slug[0]),

                'internaltopbar_editurl'             => $this->registry->conf['rooturl'].'cms/productcategory/edit/id/'.$fpcid,
                'internaltopbar_refreshurl'             => $internaltopbar_refreshurl,
                'internaltopbar_reporturl'             => $this->registry->conf['rooturl'] . 'stat/report/productcategory?id='.$fpcid.$vendorurlforstat,
                'internaltopbar_objectid'             => $fpcid,
                'internaltopbar_reporttype'             => 'productcategory',
            	'productlists' => $listnewpro,
            	'listtopprouct' => $listtopprouct,
            	'promotion' => $promotion,
            )
        );
        if($getCurrentCat->parentid != 0)//nganh hang con
        {
        	$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productssearchnew.tpl');
        }else{

        	$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productparentnew.tpl');
        }

        $this->registry->smarty->assign(array('contents' => $contents,'pageMetarobots'  => 'noindex, nofollow'));

        $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
        echo $pageHtml;
    }


    function detailAction()
    {
        global $protocol;
        if(!isset($_GET['pcid']) || !isset($_GET['pid']))
        {   
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }

        //delete search session
        if (!empty($_SESSION['ses_filterproduct'])) unset($_SESSION['ses_filterproduct']);

        $fpcid = $_GET['pcid'];
        $fpid = $_GET['pid'];
        //Getslugbanner/////////////////////////
        $slug = Helper::slugBannerURL();
        $slug = explode("?",$slug);
        //End Getslugbanner/////////////////////
        //check mailform url
        $myProduct = new Core_Product($fpid, true);
        if($myProduct->pcid != $fpcid)
        {
            //Wrong URL,
            //redirect to correct url
            header('location: ' . $myProduct->getProductPath());
            exit();
        }

		if (!empty($myProduct->slug) && $_GET['route'] == 'product/detail')
		{
			header("HTTP/1.1 301 Moved Permanently");
			header('location: ' . $myProduct->getProductPath());
            exit();
		}
        $subdomain = '';
        if(SUBDOMAIN == 'm')
            $subdomain = SUBDOMAIN;
        $cachefile = $protocol.$subdomain.'sitehtml_productdetail'.$fpid.'_'.$this->registry->region;
        //$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['ProductpageExpire']);
        $myCache = new Cacher($cachefile);

        if(isset($_GET['customer']) || isset($_GET['live'])) //no edit
        {
            //lấy tất cả các region để clear cache
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.$subdomain.'sitehtml_productdetail'.$fpid.'_'.$ritem->id;
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->clear();
                }
            }
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();
        //token send subcriberendofstock
        $_SESSION['endstocksubcriberAddToken']=Helper::getSecurityToken();//Tao token moi
        //end
        if(!$pageHtml)
        {
            $formData = array();
            $formData['fid'] = $fpid;
            $formData['fpcid'] = $fpcid;
            //$formData['fstatus'] = Core_Product::STATUS_ENABLE;
            //$formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
            //$formData['fpricethan0'] = 1;
            //$formData['favalible'] = 1;
            $productDetail = Core_Product::getProducts($formData,'','',1);
            if(empty($productDetail[0]))
            {
                header('location: ' . $this->registry->conf['rooturl']);
                exit();
            }
            $productDetail[0]->barcode = trim($productDetail[0]->barcode);
			$currentCategory = new Core_Productcategory($fpcid, true);
            //list tat ca cac loai gia can lay
            $listprices = array();
            /*
            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region);//default 222
            if($finalprice > 0) {
                $listprices['online'] = $finalprice;//online tiet kiem
            }
            else{
                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region, false, 8);//8: online thuan loi
                if($finalprice > 0){
                    $listprices['online'] = $finalprice;
                }
                else{
                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region, false, 621);//621: online hoan hao
                    if($finalprice > 0){
                        $listprices['online'] = $finalprice;
                    }
                }
            }
            if($finalprice > 0 && $productDetail[0]->sellprice <=0 ) $productDetail[0]->sellprice = $finalprice;

            //Gia tai sieu thi
            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region, false, 0);
            $listprices['offline'] = $finalprice;//online tiet kiem
            */
            $listprices['offline'] = $listprices['online'] = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region);
            if(!empty($listprices['offline'])) $productDetail[0]->sellprice = $listprices['offline'];
            //Gia tra truoc neu co
            /*if($productDetail[0]->onsitestatus == Core_Product::OS_ERP_PREPAID){
                //881 hinh thuc xuat la pre order
                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region, false, 881);
                $listprices['prepaid'] = $finalprice;
            }*/
            //chua lay gia thanh vien vip


            $productDetail[0]->content = Helper::bbcode_format($productDetail[0]->content);
            $productDetail[0]->fullbox = trim($productDetail[0]->fullbox);
            $newfilterpcid = $fpcid;
            $productGroupAttributes = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$newfilterpcid,'fstatus'=>Core_ProductGroupAttribute::STATUS_ENABLE),'displayorder','ASC');
            if(count($productGroupAttributes) == 0 && $currentCategory->parentid > 0)
            {
				$productGroupAttributes =    Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$currentCategory->parentid),'displayorder','ASC');
				$newfilterpcid = $currentCategory->parentid;
            }
            //echodebug($productGroupAttributes);
            $arrInarray = array();
            $newrelProductAttributes = array();
            $newProductGroupAttributes = array();
            $newProductAttributes = array();
            $listrelAttributes = array();
            if(!empty($productGroupAttributes))
            {
                foreach($productGroupAttributes as $gattr)
                {
                    $newProductGroupAttributes[$gattr->id] = $gattr;
                    $arrInarray[] = $gattr->id;
                }
                $productAttributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$newfilterpcid,'fpgaidarr'=>$arrInarray,'fstatus'=>Core_ProductAttribute::STATUS_ENABLE),'displayorder','ASC',0);


                if(!empty($productAttributes))
                {
                    $arrInarray = array();
                    foreach($productAttributes as $attr)
                    {
                        $newProductAttributes[$attr->pgaid][$attr->id] = $attr;
                        $arrInarray[] = $attr->id;
                    }
                    $relProductAttributes = Core_RelProductAttribute::getRelProductAttributes(array('fpaidarr'=>$arrInarray,'fpid'=>$fpid),'','');
                    if(!empty($relProductAttributes))
                    {
                        foreach($relProductAttributes as $relPro)
                        {
                            if(!empty($relPro->value) && trim($relPro->value) != '-')
                            {
                                $newrelProductAttributes[$relPro->paid][$relPro->pid] = $relPro;
                            }
                        }
                    }

                }
            }
            //Relation product
            $relProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$fpid, 'ftype' => Core_RelProductProduct::TYPE_SAMPLE),'piddestination','DESC',0);

            $relProductProduct = array();
            $newRelProductProduct = array();
            if(!empty($relProduct))
            {
                $counterbreak = 0;
                foreach($relProduct as $relpp)
                {
                    //$relProductProduct[] = $relpp->piddestination;
                    $relProduct = new Core_Product($relpp->piddestination, true);
                    if(($relProduct->onsitestatus > 0 && $relProduct->instock > 0  && $relProduct->sellprice > 0) || ($relProduct->onsitestatus == Core_Product::OS_ERP_PREPAID)  && $relProduct->status == Core_Product::STATUS_ENABLE && $relProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN ){
                        if($counterbreak++ == 11) break;
                        $newRelProductProduct[] = $relProduct;
                    }
                }
                //$newRelProductProduct = Core_Product::getProducts(array('fidarr'=>$relProductProduct, 'fisonsitestatus' => 1, 'fquantitythan0'=> 1, 'fpricethan0'=> 1),'','',3);//lay 3 san pham lien quan
            }

            $accessoriesProducts = array();
            //phu kien di kem
            $phukiendikem = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$fpid, 'ftype' => Core_RelProductProduct::TYPE_ACCESSORIES),'','');
            //echodebug($phukiendikem);
            if(!empty($phukiendikem))
            {
                $counterbreak = 0;
                foreach($phukiendikem as $relasses)
                {
                    $accessProduct = new Core_Product($relasses->piddestination, true);
                    if($accessProduct->onsitestatus > 0 && $accessProduct->instock > 0  && $accessProduct->sellprice > 0  && $accessProduct->status == Core_Product::STATUS_ENABLE && $accessProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN){
                        if($counterbreak++ == 5) break;
                        $accessoriesProducts[] = $accessProduct;
                    }
                }
            }
            $fullPathCat = Core_Product::getFullCategory($fpid);

            //get root category
            $productcategorys = Core_Productcategory::getFullParentProductCategorys($fpcid);
            $rootcategory = $productcategorys[0];

            //Product gallery
            $productMedias = Core_ProductMedia::getProductMedias(array('fpid'=>$fpid),'displayorder','ASC','');//,'ftype'=>Core_ProductMedia::TYPE_FILE, 'ffilenotnull'=>1
            //echodebug($productMedias[0]->file);
            $gallery = array();
            $gallery360 = array();
            $video = array();
            $specialimage = '';
            if(!empty($productMedias))
            {
                foreach($productMedias as $media)
                {
                    if($media->type == Core_ProductMedia::TYPE_FILE)
                    {
                        $gallery[] = $media;
                    }
                    elseif($media->type == Core_ProductMedia::TYPE_360)
                    {
                        $gallery360[] = $media;
                    }
                    elseif($media->type == Core_ProductMedia::TYPE_SPECIALTYPE)
                    {
                        $specialimage = $media->getImage();
                    }
                    elseif($media->type == Core_ProductMedia::TYPE_URL)
                    {
                        if(!empty($media->moreurl))
                        {
                            $media->moreurl = Helper::makeEmbedYouTubeUrl($media->moreurl);
                            $media->youtubeid = Helper::getYouTubeVideoId($media->moreurl);
                        }
                        $video[] = $media;
                    }
                }
            }
            //echodebug($productMedias,true);
            //echo strtotime('+4 day');
            //get product price
            $listProductPrice = Core_RelRegionPricearea::getPriceByProductRegion($productDetail[0]->barcode, $this->registry->region, true);//            Core_ProductPrice::getProductPrices(array('fpbarcode'=>$productDetail[0]->barcode, 'fpoid' => 0),'datemodified','DESC',0);
            //echodebug($listProductPrice);
            //var_dump($getProductPrice);
            /*$listProductPrice = array();
            $listPriceArea = array();
            if(!empty($getProductPrice))
            {
                $in_array = array();
                foreach($getProductPrice as $price)
                {
                    //if($price->ppaid==242) continue;
                    if(!in_array($price->ppaid,$in_array)) $in_array[] = $price->ppaid;
                    $price->sellprice = Helper::formatPrice($price->sellprice);
                    $listProductPrice[$price->ppaid][$price->pbarcode] = $price;
                }
                if(!empty($in_array)){
                    $allAreaPrice = Core_ProductPriceArea::getProductPriceAreas(array('fisactive'=>1,'fidarr'=>$in_array),'','',0);
                    if(!empty($allAreaPrice))
                    {
                        foreach($allAreaPrice as $area)
                        {
                            $listPriceArea[$area->id] = $area;
                        }
                    }
                }
                //echodebug($listPriceArea);
            }*/

            //Chua xu ly moc KM theo online hay offline

            //echodebug($getPromotionPrice);
            $getPathImage360 = '';
            if(!empty($gallery360[0]))
            {

                $imageFile = trim($gallery360[0]->getImage());
                $extension = substr($imageFile,-4);//extension with: .jpg, .png, .gif
                $listexplode = explode('-',substr($imageFile, 0, strrpos($imageFile, '-')+1));
                $getPathImage360 = '';
                if(!empty($listexplode))
                {
                    $number = count($listexplode)-1;
                    if(is_numeric($listexplode[$number])) $number = $number-2;

                    for($i=$number; $i>=0; $i--)
                    {
                        if(!empty($listexplode[$i]))$getPathImage360 = $listexplode[$i].'-'.$getPathImage360;
                    }
                    $getPathImage360 = $getPathImage360.'#'.$extension;
                }
                else {
                    $getPathImage360 = substr($imageFile, 0, strrpos($imageFile, '-')+1).'#'.$extension;
                }
            }

            $countRelProductAdvice = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$fpid, 'ftype' => Core_RelProductProduct::TYPE_PRODUCT2),'','','',true);
            //echo $getPathImage360;
            //echodebug($listPriceArea);

            //get keyword list (tam thoi khong xai)
            $keywordList = array();

            $myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $fpid, 'ftype' => Core_RelItemKeyword::TYPE_PRODUCT), '', '', '');

            foreach($myKeyword as $keyword)
            {
                $prebuild = new Core_Keyword($keyword->kid);

                $keywordList[] = $prebuild;
            }

            $summarypro = strip_tags($productDetail[0]->summary);
            if( $summarypro != '')
            {
                $explodesum = explode("\n", $summarypro);
                $finalsummary = '';
                if(!empty($explodesum))
                {
                    foreach($explodesum as $su)
                    {
                        $su = trim($su);
                        if(!empty($su) && $su !='-' && strlen($su) != 0){
                            if(empty($finalsummary)) $finalsummary .= '<li id="summaryproduct">'.$su.'</li>';
                            else $finalsummary .= '<li>'.$su.'</li>';
                        }
                    }
                }
                else $finalsummary = '<li id="summaryproduct">'.$summarypro.'</li>';
                $productDetail[0]->summary = $finalsummary;
            }
            if($productDetail[0]->summarynew != "")
                $productDetail[0]->summarynew = explode("#", $productDetail[0]->summarynew);
            //============================= Lay mau san pham ==================================
            $productcolortmp = explode("###", $productDetail[0]->colorlist);
            $productcolorlist = array();
            foreach ($productcolortmp as $colorkey => $productcolor) {
                $productcolorlist[] = explode(':', $productcolor);
            }
            //============================= End Lay mau san pham ==================================

            //get rel product type PRODUCT2 san pham uu tien ban
            $countrelProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$fpid, 'ftype' => Core_RelProductProduct::TYPE_PRODUCT2),'','',0,true);

            //for View Tracking
            $_GET['trackingid'] = $_GET['pid'];

            //Check ds sieu thi con hang
            //$liststores = Core_ProductStock::getStoreStockFromErpByProduct(trim($productDetail[0]->barcode));
            $liststores = '';
            $listnewstores = array();
            $havestorestock = array();
            $listnewregion = array();
            if (!empty($liststores))
            {
                foreach ($liststores['stores'] as $st) {
                    $listnewstores[$st->id] = $st;
                    $havestorestock[] = $st;
                    $listnewregion[] = $st->region;
                }
            }


            /*$liststoreid = Core_Product::getStoreAvailable($productDetail[0]->barcode);

            /$listproductstock = Core_ProductStock::getProductStocks(array('fpbarcode' => trim($productDetail[0]->barcode), 'fhavequantity' => 1),'','');
            $liststoreid = array();
            if(!empty($listproductstock))
            {
                foreach($listproductstock as $prodstock)
                {
                    if(!in_array($prodstock->sid, $liststoreid))
                    {
                        if($prodstock->sid != 919 && $prodstock->id != 891)
                        {
                            $liststoreid[] = $prodstock->sid;
                        }
                    }
                }
            }/
            if(!empty($liststoreid))
            {
                $havestorestock = Core_Store::getStores(array('fidarr' => $liststoreid, 'fstatus' => Core_Store::STATUS_ENABLE),'name','ASC','');
                // List store  SIEU THI CON HANG
                //tham; xu ly thua cho nay vi nhu cau khong can phan biet khu vuc
                if(!empty($havestorestock))
                {
                    $listregionid = array();
                    $hashocmcity = false;
                    foreach($havestorestock as $st)
                    {
                        if($st->lng !=0 && $st->lat !=0)
                        {
                            if($st->region == 3) $hashocmcity = true;
                            if(!in_array($st->region, $listregionid))
                            {
                                $listregionid[] = $st->region;
                            }
                        }
                        $listnewstores[$st->id] = $st;
                    }

                    if($hashocmcity)
                    {
                        $liststorehcm = Core_Store::getStores(array('fregion' => 3, 'fstatus' => Core_Store::STATUS_ENABLE),'name','ASC');

                        $liststoreidhcm = array();
                        if(!empty($liststorehcm))
                        {
                            foreach($liststorehcm as $st)
                            {
                                if(empty($listnewstores[$st->id]))
                                {
                                    $listnewstores[$st->id] = $st;
                                }
                            }
                        }
                    }
                    if(!empty($listregionid))
                    {
                        $listregionsieuthi = Core_Region::getRegions(array('fidarr'=>$listregionid),'name','ASC');
                        if(!empty($listregionsieuthi))
                        {
                            foreach($listregionsieuthi as $regid)
                            {
                                if(empty($firstRegion)) $firstRegion = $regid;
                                $listnewregion[$regid->id] = $regid;
                            }
                        }
                    }
                }
                //End SIEU THI CON HANG
            }*/
            $prepaidnumberorders = array();
            $newprepaidnumberorders = array();
            $counterbreak = 1;

            if($productDetail[0]->onsitestatus == Core_Product::OS_ERP_PREPAID && $productDetail[0]->prepaidstartdate <= time() && $productDetail[0]->prepaidenddate >= time())
            {
                //38 la ma chuong trinh dat hang truoc
                $counterorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($productDetail[0]->prepaidstartdate, $productDetail[0]->prepaidenddate )),'','', '', true);//,'isgroupbyuser' => 1
                if (count($counterorders) > 0)
                {
					$counterpreorders = 0;
					for ($cntorder = 0; $cntorder <= $counterorders; $cntorder +=50)
					{
						$listmyorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($productDetail[0]->prepaidstartdate, $productDetail[0]->prepaidenddate )),'','', $cntorder.',50');//,'isgroupbyuser' => 1
						if(!empty($listmyorders)){
							$listordersid = array();
							$listusername = array();
			                foreach($listmyorders as $od){
			                    $listordersid[] = $od->id;
			                    $listusername[$od->id] = $od->billingfullname;
                                $listdatecreate[$od->id] = $od->datecreated;
							}
							if(!empty($listordersid)){
			                    //$counterpreorders += Core_Orders::getOrderss(array('fpromotionid' => 38, 'fidarr' => $listordersid, 'forderbytimesegment' => array($productDetail[0]->prepaidstartdate, $productDetail[0]->prepaidenddate )),'','', '', true);//, 'isgroupbyorder' => 1
			                    $prepaidorderdetail = Core_OrdersDetail::getOrdersDetails(array('foidarr' => $listordersid, 'fpid' => $productDetail[0]->id),'oid','DESC');
				                if(!empty($prepaidorderdetail)){
				                    foreach($prepaidorderdetail as $odd){
				                        if(!empty($listusername[$odd->oid]))
				                        {
											if ($counterbreak < 7){
                                                $newprepaidnumberorders[$odd->id]['username'] = $listusername[$odd->oid];
                                                $newprepaidnumberorders[$odd->id]['time'] = $listdatecreate[$odd->oid];
                                            }
											$counterbreak++;
											$counterpreorders++;
				                        }
				                    }
				                }
			                }
			            }
					}
					$numberreorder = $counterpreorders;
					if (!empty($newprepaidnumberorders))
					{
						foreach ($newprepaidnumberorders as $prepaidorder)
						{
							$prepaidnumberorders[$counterpreorders] = $prepaidorder['username'];
                            $prepaidnumberorderstime[$counterpreorders] = $prepaidorder['time'];
                            $counterpreorders--;
						}
					}
                }
            }
            //Crazy deal
            if($productDetail[0]->onsitestatus == Core_Product::OS_CRAZYSALE)
            {
                $crazydeal = Core_Crazydeal::getCrazydeals(array('fisactive'=>1,'fstatus'=>Core_Crazydeal::STATUS_ENABLE,'fpid'=>$productDetail[0]->id),'id','DESC');
            }
            if(empty($crazydeal))
            {
                if($productDetail[0]->onsitestatus == Core_Product::OS_CRAZYSALE)
                {
                    $crazydealtmp = Core_Crazydeal::getCrazydeals(array('fpid'=>$productDetail[0]->id),'id','DESC');
                    if(!empty($crazydealtmp))
                    {
                        $productupdate = new Core_Product($productDetail[0]->id);
                        if($productupdate->id > 0)
                        {
                            $promotionliststr = $productupdate->promotionlist;
                            $productupdate->onsitestatus = $crazydealtmp[0]->oldonsitestatus;
                            $productupdate->promotionlist = '';
                            //$productupdate->applypromotionlist = '';
                            if($productupdate->updateData())
                            {
                                $promotiontmp = explode(",",$promotionliststr);
                                $promotionid = $promotiontmp[1];
                                $promotion = new Core_Promotion($promotionid);
                                if($promotion->id > 0)
                                {
                                    $promotion->status = Core_Promotion::STATUS_DISABLED;
                                    $promotion->updateData();
                                }
                                $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
                                if(!empty($listregion))
                                {
                                    foreach($listregion as $ritem)
                                    {
                                        $cachefile1 = $protocol.$subdomain.'sitehtml_productdetail'.$productDetail[0]->id.'_'.$ritem->id;
                                        $removeCache1 = new Cacher($cachefile1);
                                        $removeCache1->clear();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //End Crazy deal


            //Đoán giá
            if($productDetail[0]->onsitestatus == Core_Product::OS_DOANGIA)
            {
            	$today = time();
                $productGuess = Core_ProductGuess::getProductGuesss(array('fisactive'=>1,'fstatus'=>Core_ProductGuess::STATUS_ENABLE,'fpid'=>$productDetail[0]->id),'id','DESC');
                $totalquestion = Core_Productquestion::getProductquestions(array('fpgid' => $productGuess[0]->id, 'fstatus'=>Core_Productquestion::STATUS_ENABLE ,'ftime'=> $today ), 'displayorder', 'ASC', '',true);
                $question = Core_Productquestion::getProductquestions(array('fpgid' => $productGuess[0]->id, 'fstatus'=>Core_Productquestion::STATUS_ENABLE, 'ftime'=> $today), 'displayorder', 'ASC', 1);
                $myQuestion = $question[0];
                $myQuestion->answer = unserialize($myQuestion->answer);

                // get user choi doan gia
                $totaluserguess =  Core_ProductGuessUser::getProductGuessUsers(array('fpgid' => $productGuess[0]->id), 'id', 'DESC','', true);
                $userguess = Core_ProductGuessUser::getProductGuessUsers(array('fpgid' => $productGuess[0]->id), 'id', 'DESC', 3);

            }
            if(empty($productGuess))
            {
                if($productDetail[0]->onsitestatus == Core_Product::OS_DOANGIA)
                {
                    $productGuesstmp = Core_ProductGuess::getProductGuesss(array('fpid'=>$productDetail[0]->id),'id','DESC');
                    if(!empty($productGuesstmp))
                    {
                        $productupdate = new Core_Product($productDetail[0]->id);
                        $productupdate->onsitestatus = $productGuesstmp[0]->oldonsitestatus;
                        if($productupdate->id > 0)
                        {
							$productupdate->updateData();
                        }
                    }else{
                    	$productupdate = new Core_Product($productDetail[0]->id);
                        $productupdate->onsitestatus = Core_Product::OS_NOSELL;
                        if($productupdate->id > 0)
                        {
                        	$productDetail[0]->onsitestatus = Core_Product::OS_NOSELL;
							$productupdate->updateData();
							$this->registry->me->writelog('Product_Het_Hang_Tu_Doan_gia', $productDetail[0]->id , array());
                        }
                    }
                }
            }
            //End Doán giá

            //Bai viet lien quan
            $listrelnews = Core_News::getNewss(array(), 'id', 'DESC', 4);

            //get vendor info
            $myVendor = new Core_Vendor($productDetail[0]->vid, true);

            $internaltopbar_refreshurl = Helper::curPageURL();
            $internaltopbar_refreshurl = $internaltopbar_refreshurl.(strpos($internaltopbar_refreshurl,'?')===false?'?customer=1&live':'&customer=1&live');

            /* RECOMEMNTDATION MSITE */
			/*if(SUBDOMAIN=='m')
			{
				$result = array ();
				$redis  = new Redis();
        		$redis->connect('172.16.141.60' , 6379);
				$str    = $redis->get('rp3:' . $fpid);
                $rsRe = array();
                if($str != "")
                {
                	$i = 0;
                    $recodeReperpage = 10;
    				$arr 	= array_slice(explode(',',$str),0 ,$recodeReperpage);
    				foreach ( $arr as $keyword => $value ) {
    					if ($i < 4){
	    					$MyreProduct          = new Core_Product($value);
	    					if ($MyreProduct->onsitestatus == Core_Product::OS_ERP && $MyreProduct->instock > 0 && $MyreProduct->sellprice > 0){
		    					$ReProduct['image']   = $MyreProduct->getSmallImage();
		    					$ReProduct['name']    = $MyreProduct->name;
		    					$ReProduct['barcode'] = $MyreProduct->barcode;
		    					$ReProduct['id']      = $MyreProduct->id;
		                        $ReProduct['link']    = $MyreProduct->getProductPath();
		                        $ReProduct['promotionprices'] = $MyreProduct->promotionPrice();
		                        $ReProduct['onsitestatus'] = $MyreProduct->onsitestatus;
		                        $ReProduct['instock'] = $MyreProduct->instock;
		                        $ReProduct['isbagdenew'] = $MyreProduct->isbagdenew;
		                        $ReProduct['isbagdehot'] = $MyreProduct->isbagdehot;
		                        $ReProduct['isbagdegift'] = $MyreProduct->isbagdegift;
		                        $ReProduct['prepaidstartdate'] = $MyreProduct->prepaidstartdate;
		                        $ReProduct['prepaidenddate'] = $MyreProduct->prepaidenddate;
		                        $ReProduct['sellprice'] = $MyreProduct->sellprice;
		                        $ReProduct['displaysellprice'] = $MyreProduct->displaysellprice;
		                        $ReProduct['prepaidprice'] = $MyreProduct->prepaidprice;
		    					$rsRe[]                 = $ReProduct;
		    					$i++;
	    					}
    					}
    				}
                }
			}*/
            /* RECOMEMNTDATION MSITE */
            //var_dump($rsRe);die;
            $this->registry->smarty->assign( array(
                    //'relProductAttributes'      => Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$fpid),'','',0),
                    //$accessoriesProducts
                    //'ReProduct'        			 => $rsRe,
                    'userguess'					=> $userguess,
            		'totaluserguess'			=> $totaluserguess,
                    'productGuess'				=> $productGuess[0],
            		'totalquestion'				=> $totalquestion,
            		'myQuestion'				=> $myQuestion,
                    'crazydeal'                 => $crazydeal,
                    'listnewregion'             => $listnewregion,
                    'listregionsieuthi'         => $listregionsieuthi,
                    'productcolorlist'           => $productcolorlist,
                    'recodeReperpage'            => $recodeReperpage,
                    'accessoriesProducts'        => $accessoriesProducts,
                    //'accessoriesProducts'        => '',
                    'productDetail'             => $productDetail[0],
                    'headertext'             	=> $productDetail[0]->topseokeyword,
                    'currentCategory'           => $currentCategory,
                    //'hideMenu'                  => 1,
                    'prepaidnumberorders'    	=> $prepaidnumberorders,
                    'prepaidnumberorderstime'   => $prepaidnumberorderstime,
                    'isHaveProductAdvice'    	=> $countRelProductAdvice,
                    'havestorestock'    		=> $havestorestock,
                    'installments'    			=> Core_Installment::calcInstallment($productDetail[0]->sellprice, 0.3, 9, $productDetail[0]->pcid),
                    'productGroupAttributes'    => $newProductGroupAttributes,
                    'productAttributes'         => $newProductAttributes,
                    'specialimage'         		=> $specialimage,
                    'relProductAttributes'      => $newrelProductAttributes,
                    'relProductProduct'         => $newRelProductProduct,
                    'fullPathCategory'          => $fullPathCat,
                    'galleries'                 => $gallery,
                    'galleries360'              => $gallery360,
                    'videos'                    => $video,
                    'listAreaPrice'             => $listPriceArea,
                    //'promotionPrice'            => $getPromotionPrice,
                    'listProductPrice'          => $listProductPrice,
                    //'promotionsInfo'            => $listpromotions,
                    //'maxstartdatepromotion'     => $findmaxstartdatepromotion,
                    //'minenddatepromotion'       => $findminenddatepromotion,
                    //'listpromotionswithexlude'	=> $listpromotionswithexlude,
                    //'listpromotionbypromotionids'=> $listpromotionbypromotionids,
                    //'firstPromotion'            => $firstPromotion,
                    'gpa'                       => Core_ProductEditInline::TYPE_GROUPATTRIBUTE,
                    'pa'                       	=> Core_ProductEditInline::TYPE_ATTRIBUTE,
                    'prel'                     	=> Core_ProductEditInline::TYPE_REL,

                    'pageCanonical'             => (!empty($productDetail[0]->canonical)?$productDetail[0]->canonical:$productDetail[0]->getProductPath()),
                    'pathimage360'              => $getPathImage360,
                    'numimage360'               => count($gallery360),

                    'pageTitle'                 => (!empty($productDetail[0]->seotitle)?$productDetail[0]->seotitle:$productDetail[0]->name),
                    'pageKeyword'               => $productDetail[0]->seokeyword,
                    'pageDescription'           => $productDetail[0]->seodescription,
                    'pageMetarobots'           	=> (!empty($productDetail[0]->metarobot)?$productDetail[0]->metarobot:''),
                    'keywordList'               => $keywordList,
                    'footerkey'                 => $productDetail[0]->textfooter,
                    'countrelProduct'           => $countrelProduct,
                    'listrelnews'           	=> $listrelnews,
                    'myVendor'           		=> $myVendor,
                    'listprices'           		=> $listprices,
                    'currentTime'           	=> time(),

                    'internaltopbar_editurl'	=> $this->registry->conf['rooturl'].'cms/product/edit/id/'.$fpid.'/',
                    'internaltopbar_refreshurl'	=> $internaltopbar_refreshurl,
                    'internaltopbar_reporturl'	=> $this->registry->conf['rooturl'] . 'stat/report/productdetail?id='.$fpid,
                    'internaltopbar_objectid'	=> $fpid,
                    'internaltopbar_reporttype'	=> 'product',
                    'rootcategory'              => $rootcategory,
                    'bannerProductDetail'       => $this->bannerProductDetail($fpcid,$slug[0]),
                    'success'                   => $success,
                    'error'                     => $error,
					'numberreorder'				=> $numberreorder
                )
            );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productsdetailnew.tpl');

            $assignmain = array('contents' => $contents);
            if (!empty($productDetail[0])) {
                $assignmain['smallproductdetail'] = $productDetail[0]->getSmallImage();
            }
            $this->registry->smarty->assign($assignmain);


            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);
        }
        echo $pageHtml;
    }
    private function addFilterForm($fpcid)
    {//product attribute fiter phai luu them dau rao lay valueseo
        $attributeList = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid'=>$fpcid), 'displayorder', 'ASC');
        $leftPosition = array();
        $centerPosition = array();
        $showdeletestring = array();
        $getfilterselected = (!empty($_SESSION['ses_filterproduct'])?$_SESSION['ses_filterproduct']:null);
        if(!empty($attributeList))
        {
            $cntattr = 0;
            foreach($attributeList as $attr)
            {
                //cat de tim ra tat ca cac row của attribute
                $findrows = explode('###', $attr->value);
                if(!empty($findrows))
                {
                    $value = array();
                    $valueseo = array();
                    $valueurl = array();

                    foreach($findrows as $key2 => $frow)
                    {
                        //cat de lay ra gia tri (col)cua tung row
                        $findcols = explode('##', $frow);
                        if(!empty($findcols))
                        {
                            $value[] = $findcols[0];
                            $valueseo[] = $findcols[1];
                            //$atype = $findcols[2];
                            //$avalue = $findcols[3];
                        }
                    }
                    $cururl = Helper::curPageURL();
                    $valuedel = array();
                    if(!empty($getfilterselected)){
                        //echodebug($valueseo);
                        foreach($valueseo as $kx=>$vseo){
                            $valueurl[$kx] = implode(',',$getfilterselected);
                            if(in_array($attr->panameseo.','.$vseo, $getfilterselected)){
                                $newcurl = '';
                                $ixselected = array_search($attr->panameseo.','.$vseo, $getfilterselected);
                                $newselected = $getfilterselected;
                                if($ixselected !==false) unset($newselected[$ixselected]);
                                $valueurl[$kx] = implode(',',$newselected);
                                if(!empty($_GET['a'])){
                                    $newcurl = str_replace($attr->panameseo.','.$vseo,'',$cururl);
                                    if(substr($newcurl, -10)=='?a=&live=1') $newcurl= substr($newcurl, 0, -10);
                                    elseif(substr($newcurl, -8)=='?a=&live') $newcurl= substr($newcurl, 0, -8);
                                    elseif(substr($newcurl, -3)=='?a=') $newcurl= substr($newcurl, 0, -3);
                                    elseif(substr($newcurl, -1)=='?') $newcurl= substr($newcurl, 0, -1);
                                    if(strpos($newcurl, '?a=,')!==false) $newcurl= str_replace('?a=,', '?a=', $newcurl);

                                    if(substr($newcurl, -10)=='&a=&live=1') $newcurl= substr($newcurl, 0, -10);
                                    elseif(substr($newcurl, -8)=='&a=&live') $newcurl= substr($newcurl, 0, -8);
                                    elseif(substr($newcurl, -3)=='&a=') $newcurl= substr($newcurl, 0, -3);
                                    elseif(substr($newcurl, -1)=='&') $newcurl= substr($newcurl, 0, -1);
                                    if(strpos($newcurl, '&a=,')!==false) $newcurl= str_replace('&a=,', '&a=', $newcurl);
                                    if(strpos($newcurl, ',,')!==false) $newcurl= str_replace(',,', ',', $newcurl);
                                    if(substr($newcurl, -1)==',') $newcurl= substr($newcurl,0, -1);
                                }
                                else{
                                    $newcurl = $cururl;
                                    if(strpos($newcurl, '?') !== false){
                                        $newcurl = substr($newcurl, 0, strpos($newcurl, '?'));
                                    }
                                    $newcurl = '?a='.$valueurl[$kx];
                                }
                                $showdeletestring[] = array('url' => $newcurl, 'name' => $attr->display. ' ' .$value[$kx]);
                                $valuedel[$kx]=$newcurl;

                            }
                            //else $valueurl[$kx] = $attr->panameseo.','.$vseo;
                        }

                    }
                    if($attr->position == Core_ProductAttributeFilter::LEFT_POSITION)
                    {
                        $leftPosition[$cntattr] = $attr;
                        $leftPosition[$cntattr]->value = array($value, $valueseo, $valueurl,$valuedel);

                    }
                    elseif($attr->position == Core_ProductAttributeFilter::CENTER_POSITION)
                    {
                        $centerPosition[$cntattr] = $attr;
                        $centerPosition[$cntattr]->value = array($value, $valueseo, $valueurl,$valuedel);
                    }
                    else
                    {
                        $centerPosition[$cntattr] = $attr;
                        $leftPosition[$cntattr] = $attr;
                        $centerPosition[$cntattr]->value = $value;
                        $leftPosition[$cntattr]->value = array($value, $valueseo);
                    }
                    $cntattr++;
                }
            }
        }

        return array('LEFT'=>$leftPosition, 'CENTER'=>$centerPosition, 'DELETEDURL' => $showdeletestring, 'VALUE' => $valueurl[0]);
    }

    private function getBanner($fpcid, $fazid = 3, $ftype = Core_Ads::TYPE_BANNER)
    {
        if(empty($fpcid)) return false;

        $formData['fazid'] = $fazid; //Dienmay Homepage
        $formData['ftype'] = $ftype;
        $formData['fgroup'] = $fpcid;
        $formData['fisactive'] = 1;
        $listAds = Core_Ads::getAdss($formData, '', 'DESC');
        if(empty($listAds))
        {
            $getParentCate = Core_Productcategory::getFullParentProductCategorys($fpcid);
            if(!empty($getParentCate) && !empty($getParentCate['0']['pc_id']))
            {
                $formData['fgroup'] = trim($getParentCate['0']['pc_id']);
                $listAds = Core_Ads::getAdss($formData, '', 'DESC');
            }
        }
        return $listAds;
        //if($fazid==3) echodebug($getAds);
        /*$lastestAds = array();
        $listchilds = array();
        $listparent = array();
        if(!empty($getAds))
        {
            foreach($getAds as $ad)
            {
                if(!empty($ad->parent) && $ad->group == $fpcid)
                {
                    if(empty($lastestAds[$ad->id]))
                    {
                        $lastestAds[$ad->id] = $ad;
                    }
                    $listparent[] = $ad->parent;
                }
                elseif($ad->parent == 0 && !in_array($ad->id, $listparent ))
                {
                    if(empty($lastestAds[$ad->id]))
                    {
                        $lastestAds[$ad->id] = $ad;
                    }
                }
            }
        }

        //get all banner in category from homepage
        $getParentList = Core_Productcategory::getFullParentProductCategorys($fpcid);
        $listcate = array();
        $listcate[] = $fpcid;
        if(!empty($getParentList))
        {
            if(empty($listcate[$getParentList[0]['pc_id']])) {
                $listcate[] = $getParentList[0]['pc_id'];
            }
        }
        //echodebug($listcate);
        if($fazid == 3)
        {
            $getAds = Core_Ads::getAdss(array('fazid' => 1, 'ftype' => $ftype, 'fisactive' => 1, 'fparentgreater0' => 1,'fgrouparr' => $listcate), '', 'DESC');
            if(!empty($getAds))
            {
                foreach($getAds as $ad)
                {
                    if(empty($lastestAds[$ad->id]))
                    {
                        $lastestAds[$ad->id] = $ad;
                    }
                }
            }
        }

        return $lastestAds;*/
    }

    public function getBannerProduct($fpcid, $slug = '', $fazid = 3, $ftype = Core_Ads::TYPE_BANNER)
    {
        if(empty($fpcid))
            return false;
        $formData['fisactive'] = 1;
        $listAds = array();
        $formData['fslug'] = $slug;
        $listAdsSlug = Core_AdsSlug::getAdsSlugs($formData,'','DESC');
        if(count($listAdsSlug) > 0)
        {
            $arrID = array();
            foreach($listAdsSlug as $lAdsSlug)
            {
                $arrID[] = $lAdsSlug->aid;
            }
            $formData['fidarr'] = $arrID;
            $listAds = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
        }
        else
        {
            $slug2 = explode("/",$slug,2);
            if(count($slug2) == 1)
            {
                $getParentCate = Core_Productcategory::getFullParentProductCategorys($fpcid);
                if(!empty($getParentCate))
                {
                    $formData['fslug'] = $getParentCate[0]['pc_slug'];
                    $listParentAdsSlug = Core_AdsSlug::getAdsSlugs($formData,'','DESC');
                    if(count($listParentAdsSlug) > 0)
                    {
                        $arrParentID = array();
                        foreach($listParentAdsSlug as $lParentAdsSlug)
                        {
                            $arrParentID[] = $lParentAdsSlug->aid;
                        }
                        $formData['fidarr'] = $arrParentID;
                        $listAds = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
                    }
                }
            }
        }
        unset($formData['fslug']);
        unset($formData['fidarr']);
        //Get banner by category group
        $formData['fazid'] = $fazid; //
        $formData['ftype'] = $ftype;
        //$formData['fgroup'] = $fpcid;
        $listAdsCate = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
        $adsCate = array();
        if(!empty($listAdsCate))
        {
            $arrID = array();
            foreach($listAdsCate as $lAdsCate)
            {
                $fgrouparr = explode(",",$lAdsCate->group);
                foreach($fgrouparr as $fgroup)
                {
                    if($fgroup == $fpcid)
                    {
                        $arrID[] = $lAdsCate->id;
                    }
                }
            }
            if(!empty($arrID))
            {
                $formData['fidarr'] = $arrID;
                $adsCate = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
            }else{

                $getParentCate = Core_Productcategory::getFullParentProductCategorys($fpcid);
                if(!empty($getParentCate) && !empty($getParentCate['0']['pc_id']))
                {
                    $adsCateEach = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
                    $arrID = array();
                    foreach($adsCateEach as $sadsCate)
                    {
                        $fgrouparr = explode(",",$sadsCate->group);
                        foreach($fgrouparr as $fgroup)
                        {
                            if($fgroup == $getParentCate['0']['pc_id'])
                            {
                                $arrID[] = $sadsCate->id;
                            }
                        }
                    }
                    if(!empty($arrID))
                    {
                        $formData['fidarr'] = $arrID;
                        $adsCate = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
                    }

                }
            }
        }
        return  array_merge($listAds,$adsCate);

    }

    //New : Banner product detail

    private function bannerProductDetail($fpcid,$slug = '',$fazid = 16)
    {
        if(empty($fpcid))
            return false;
        $formData['fisactive'] = 1;
        $listAds = array();
        $formData['fslug'] = $slug;
        $listAdsSlug = Core_AdsSlug::getAdsSlugs($formData,'','DESC');
        if(count($listAdsSlug) > 0)
        {
            $arrID = array();
            foreach($listAdsSlug as $lAdsSlug)
            {
                $arrID[] = $lAdsSlug->aid;
            }
            $formData['fidarr'] = $arrID;
            $listAds = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
        }
        else
        {
            //Get banner by category group
            $formData['fazid'] = $fazid; //
            //$formData['fgroup'] = $fpcid;
            $listAdsCate = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
            $adsCate = array();
            if(!empty($listAdsCate))
            {
                $arrID = array();
                foreach($listAdsCate as $lAdsCate)
                {
                    $fgrouparr = explode(",",$lAdsCate->group);
                    foreach($fgrouparr as $fgroup)
                    {
                        if($fgroup == $fpcid)
                        {
                            $arrID[] = $lAdsCate->id;
                        }
                    }
                }
                if(!empty($arrID))
                {
                    $formData['fidarr'] = $arrID;
                    $listAds = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
                }else{

                    $getParentCate = Core_Productcategory::getFullParentProductCategorys($fpcid);
                    if(!empty($getParentCate) && !empty($getParentCate['0']['pc_id']))
                    {
                        $adsCateEach = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
                        $arrID = array();
                        foreach($adsCateEach as $sadsCate)
                        {
                            $fgrouparr = explode(",",$sadsCate->group);
                            foreach($fgrouparr as $fgroup)
                            {
                                if($fgroup == $getParentCate['0']['pc_id'])
                                {
                                    $arrID[] = $sadsCate->id;
                                }
                            }
                        }
                        if(!empty($arrID))
                        {
                            $formData['fidarr'] = $arrID;
                            $listAds = Core_Ads::getAdss($formData, 'displayorder', 'ASC');
                        }

                    }
                }
            }
        }

        //echodebug($listAds);
        return  $listAds;
    }
    //End new : Banner product detail

    public function initinlineajaxAction()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?><result>';
        if(empty($_GET['customer']))
        {
            if(!empty($_POST['fpcid']) && !empty($_POST['furl']) && !empty($_POST['fpid']) && is_numeric($_POST['fpid']) && is_numeric($_POST['fpcid']))
            {
                if(strpos($_POST['furl'],'?customer')===false && strpos($_POST['furl'],'&customer')===false)
                {
                    //$newurl = $_POST['furl'].(strpos($_POST['furl'],'?')===false?'?customer=1&live':'&customer=1&live');

                    $myProduct = new Core_Product($_POST['fpid']);

                    //check permission of user;
                    $xml .= '<status>'.($this->editInit($_POST['fpcid'])?1:0).'</status>';
                    /*$xml .= '<htmlblock><![CDATA[';
                    $xml .= '<div id="popupeditinline"><div class="popupbrand">dienmay<span>.com</span></div>
								<a href="'.$this->registry->conf['rooturl'].'cms/product/edit/id/'.trim($_POST['fpid']).'/'.'" class="popupbread">'.$myProduct->name.' (ID: '.$_POST['fpid'].')</a>


							<a href="javascript:void(0)" id="productstartbtn" class="editinlinebutton" onclick="product_stat(\'productdetail\', '.$_POST['fpid'].')">THỐNG KÊ</a>

							<a href="javascript:void(0)" id="hidepopup">&times;</a>
							<a href="'.$newurl.'" id="editinlinerefresh">View as Customer</a>
							</div>';
                    $xml .= ']]>';
                    $xml .= '</htmlblock>';*/
                    $xml .= '<rotate360><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/editmedia/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/tab/'.Controller_Cms_ProductEditInline::TAB_IMAGE360.'" class="editicon" rel="shadowbox;height=500;width=1100" title="Sửa hình 360"></a> ]]></rotate360>';
                    //$xml .= '<productname><![CDATA[ <a href="" class="editicon" title="Sá»­a sáº£n pháº©m"></a> ]]></productname>';
                    $xml .= '<good><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/good" class="editicon" rel="shadowbox;height=500;width=600" title="Sửa ưu điểm"></a> ]]></good>';
                    $xml .= '<bad><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/bad" class="editicon" rel="shadowbox;height=500;width=600" title="Sửa nhược điểm"></a> ]]></bad>';
                    $xml .= '<review><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/dienmayreview" class="editicon" rel="shadowbox;height=500;width=600" title="sửa đánh giá điện máy"></a> ]]></review>';

                    $xml .= '<introductionproduct><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/content" class="editicon" rel="shadowbox;height=500;width=600" title="Giới thiệu sản phẩm"></a> ]]></introductionproduct>';

                    $xml .= '<summaryproduct><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/summary" class="editicon" rel="shadowbox;height=500;width=600" title="Summary" id="summaryeditproduct"></a> ]]></summaryproduct>';

                    $xml .= '<image><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/editmedia/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/tab/'.Controller_Cms_ProductEditInline::TAB_IMAGE.'" class="editicon" rel="shadowbox;height=500;width=1100" title="Sửa hình đại diện" style="right: 85%;"></a> ]]></image>';

                    $xml .= '<fullbox><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/fullbox" class="editicon" rel="shadowbox;height=500;width=600" title="Sửa bộ bán hàng chuẩn"></a> ]]></fullbox>';
                    $xml .= '<fullboxshort><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/edittextarea/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/fcol/fullboxshort" class="editicon" rel="shadowbox;height=500;width=600" title="Tóm tắt bộ bán hàng chuẩn"></a> ]]></fullboxshort>';
                    $xml .= '<gallery><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/editmedia/fpid/'.trim($_POST['fpid']).'/fpcid/'.trim($_POST['fpcid']).'/tab/'.Controller_Cms_ProductEditInline::TAB_GALLERY.'" class="editicon" rel="shadowbox;height=500;width=1100" title="Sửa hình ảnh (gallery)"></a> ]]></gallery>';
                    $xml .= '<video><![CDATA[ <a href="'.$this->registry->conf['rooturl'].'cms/producteditinline/editmedia/fpid/'.$_POST['fpid'].'/fpcid/'.$_POST['fpcid'].'/tab/'.Controller_Cms_ProductEditInline::TAB_VIDEO.'" class="editicon" rel="shadowbox;height=500;width=1100" title="Sửa video"></a> ]]></video>';
                    //http://new.dienmay.com/cms/producteditinline/editmedia/fpid/57919/fpcid/1765/tab/1
                    //$xml .= '<note><![CDATA[ <a href="#" class="editiconnote" rel="'.$_POST['fpid'].'" title="Sá»­a chi tiáº¿t tÃ­nh nÄƒng"></a> ]]></note>';


                    /*Class: fullnoteganame: edit product group attribute name
                            fullnotename edit product attribute name
                            fullnote edit product attribute value*/
                }
            }
        }
        $xml .= '</result>';
        header ("content-type: text/xml");
        echo $xml;
    }

    public function initcatinlineajaxAction()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?><result>';

        $pcid = (int)$_POST['fpcid'];

        if(empty($_GET['customer']))
        {
            if(!empty($_POST['fpcid']) && !empty($_POST['furl']) && is_numeric($_POST['fpcid']))
            {
                if(strpos($_POST['furl'],'?customer')===false && strpos($_POST['furl'],'&customer')===false)
                {
                    $myProductCategory = new Core_Productcategory($_POST['fpcid'], true);

                    //$newurl = $_POST['furl'].(strpos($_POST['furl'],'?')===false?'?customer=1&live':'&customer=1&live');

                    //$reporturl = $this->registry->conf['rooturl'] . 'stat/report/productcategory?id=' . $pcid;

                    $xml .= '<status>'.($this->editInit($_POST['fpcid'])?1:0).'</status>';

                    $xml .= '<special><![CDATA[<ul>
                        <li><img rel="gif" src="'.$this->registry->getResourceHost('static').'images/site/icon_gif_grey.png" width="45" height="45" /></li>
                        <li><img rel="new" src="'.$this->registry->getResourceHost('static').'images/site/icon_new_grey.png" width="45" height="45" /></li>
                        <li><img rel="hot" src="'.$this->registry->getResourceHost('static').'images/site/icon_hot_grey.png" width="45" height="45" /></li>

                    </ul> ]]></special>';

                }
            }
        }
        $xml .= '</result>';
        header ("content-type: text/xml");
        echo $xml;
    }

    public function inlinenoteAction()
    {
        if(!empty($_POST['value']) && !empty($_POST['id']) && is_numeric($_POST['id'])
            && !empty($_POST['fpcid']) && !empty($_POST['type']) && is_numeric($_POST['type'])
            && is_numeric($_POST['fpid']) && is_numeric($_POST['fpcid'])
        )
        {
            Core_ProductEditInline::updateAttribute($_POST['fpid'],$_POST['fpcid'],$_POST['type'],$_POST['value'],$_POST['id']);
            echo $_POST['value'];
        }
    }

    public function inlineproductAction()
    {
        if(!empty($_POST['value']) && !empty($_POST['fpid'])
            && !empty($_POST['fpcid']) && !empty($_POST['type'])
            && is_numeric($_POST['fpid']) && is_numeric($_POST['fpcid'])
        )
        {
            $listAllArray = array('p_name','hotgif','newgif','hot','new','gif','rhotgif','rnewgif','rhot','rnew','rgif');
            $imgname = array();
            $imgname['noshowimage']  = '';
            $isarray = true;
            if(in_array($_POST['type'],$listAllArray))
            {
                $arraydata = array();
                switch($_POST['type'])
                {
                    /*case 'hotgif':
                            $arraydata['p_isbagdehot'] = 1;
                            $arraydata['p_isbagdegift'] = 1;
                            //$imgname['returnimg'] = 'icon_hot_gif.png';
//                            $imgname['hot'] = 'icon_hot.png';
//                            $imgname['new'] = 'icon_new.png';
//                            $imgname['gif'] = 'icon_gif_grey.png';
                            //$arraydata['p_isbagdenew'] = 0;
                        break;
                    case 'newgif':
                            $arraydata['p_isbagdenew'] = 1;
                            $arraydata['p_isbagdegift'] = 1;
                            //$arraydata['p_isbagdehot'] = 0;
                            //$imgname['returnimg'] = 'icon_new_gif.png';
//                            $imgname['hot'] = 'icon_hot_grey.png';
//                            $imgname['new'] = 'icon_new.png';
//                            $imgname['gif'] = 'icon_gif.png';
                        break;*/
                    case 'hot':
                        $arraydata['p_isbagdehot'] = 1;
                        $arraydata['p_isbagdenew'] = 0;
                        $arraydata['p_isbagdegift'] = 0;
                        $imgname['disablevalue'] = 'icon_hot_grey.png';
                        $imgname['enablevalue'] = 'icon_hot.png';
                        $imgname['convertdisablevalue'] = 'icon_new_grey.png';
                        $imgname['convertenablevalue'] = 'icon_new.png';
                        $imgname['relconvertdisablevalue'] = 'rnew';
                        $imgname['relconvertenablevalue'] = 'new';
                        $imgname['reldisablevalue'] = 'rhot';
                        $imgname['relenablevalue'] = 'hot';
                        //$imgname = 'icon_hot.png';
                        //$imgname['returnimg'] = 'icon_hot.png';
//                            $imgname['hot'] = 'icon_hot.png';
//                            $imgname['new'] = 'icon_new_grey.png';
//                            $imgname['gif'] = 'icon_gif.png';
                        //$arraydata['p_isbagdenew'] = 0;
                        //$arraydata['p_isbagdegift'] = 0;
                        break;
                    case 'new':
                        $arraydata['p_isbagdenew'] = 1;
                        $arraydata['p_isbagdehot'] = 0;
                        $arraydata['p_isbagdegift'] = 0;
                        $imgname['disablevalue'] = 'icon_new_grey.png';
                        $imgname['enablevalue'] = 'icon_new.png';
                        $imgname['convertdisablevalue'] = 'icon_hot_grey.png';
                        $imgname['convertenablevalue'] = 'icon_hot.png';
                        $imgname['reldisablevalue'] = 'rnew';
                        $imgname['relenablevalue'] = 'new';
                        $imgname['relconvertdisablevalue'] = 'rhot';
                        $imgname['relconvertenablevalue'] = 'hot';
                        //$imgname['returnimg'] = 'icon_new.png';
//                            $imgname['hot'] = 'icon_hot_grey.png';
//                            $imgname['new'] = 'icon_new.png';
//                            $imgname['gif'] = 'icon_gif_grey.png';
                        //$arraydata['p_isbagdehot'] = 0;
                        break;
                    case 'gif':
                        $arraydata['p_isbagdegift'] = 1;
                        $arraydata['p_isbagdenew'] = 0;
                        $arraydata['p_isbagdehot'] = 0;
                        $imgname['disablevalue'] = 'icon_gif_grey.png';
                        $imgname['enablevalue'] = 'icon_gif.png';
                        $imgname['reldisablevalue'] = 'rgif';
                        $imgname['relenablevalue'] = 'gif';
                        //$imgname['returnimg'] = 'icon_gif.png';
//                            $imgname['hot'] = 'icon_hot_grey.png';
//                            $imgname['new'] = 'icon_new_grey.png';
//                            $imgname['gif'] = 'icon_gif.png';
                        //$arraydata['p_isbagdehot'] = 0;
                        //$arraydata['p_isbagdenew'] = 0;
                        break;
                    /*case 'rhotgif':
                            $arraydata['p_isbagdehot'] = 0;
                            $arraydata['p_isbagdegift'] = 0;
                            //$imgname['hot'] = 'icon_hot_grey.png';
//                            $imgname['gif'] = 'icon_gif_grey.png';
                        break;
                    case 'rnewgif':
                            $arraydata['p_isbagdenew'] = 0;
                            $arraydata['p_isbagdegift'] = 0;
                            //$imgname['new'] = 'icon_new_grey.png';
//                            $imgname['gif'] = 'icon_gif_grey.png';
                        break;*/
                    case 'rhot':
                        $arraydata['p_isbagdehot'] = 0;
                        $imgname['enablevalue'] = 'icon_hot_grey.png';
                        $imgname['disablevalue'] = 'icon_hot.png';
                        $imgname['reldisablevalue'] = 'hot';
                        $imgname['relenablevalue'] = 'rhot';
                        $imgname['returnimg'] = 'icon_hot_grey.png';
//                            $imgname['hot'] = 'icon_hot_grey.png';
                        break;
                    case 'rnew':
                        $arraydata['p_isbagdenew'] = 0;
                        $imgname['enablevalue'] = 'icon_new_grey.png';
                        $imgname['disablevalue'] = 'icon_new.png';
                        $imgname['reldisablevalue'] = 'new';
                        $imgname['relenablevalue'] = 'rnew';
                        $imgname['returnimg'] = 'icon_new_grey.png';
//                            $imgname['new'] = 'icon_new_grey.png';
                        break;
                    case 'rgif':
                        $arraydata['p_isbagdegift'] = 0;
                        $imgname['enablevalue'] = 'icon_gif_grey.png';
                        $imgname['disablevalue'] = 'icon_gif.png';
                        $imgname['reldisablevalue'] = 'gif';
                        $imgname['relenablevalue'] = 'rgif';
                        $imgname['returnimg'] = 'icon_gif_grey.png';
//                            $imgname['gif'] = 'icon_gif_grey.png';
                        break;
                    default: $arraydata[$_POST['type']] = $_POST['value']; $isarray = false; break;
                }

                Core_ProductEditInline::updateData($_POST['fpcid'],$_POST['fpid'],$arraydata);//array($colum=>$_POST['value'])
                if($isarray)
                {
                    $getProductDetail = new Core_Product($_POST['fpid']);
                    if(!empty($getProductDetail))
                    {
                        /*if ($getProductDetail->isbagdehot == 1 && $getProductDetail->isbagdegift == 1)
                        {
                            $imgname['returnimg'] = 'icon_hot_gif.png';
                            $imgname['returnclass'] = 'icon-new';//'icon_hot_gif.png';
                        }
                        elseif ($getProductDetail->isbagdenew == 1 && $getProductDetail->isbagdegift == 1)
                        {
                            $imgname['returnimg'] = 'icon_new_gif.png';
                        }
                        else*/if ($getProductDetail->isbagdehot == 1)
                    {
                        $imgname['returnimg'] = 'icon_hot.png';
                        $imgname['returnclass'] = 'icon-hot';//'icon_hot.png';
                    }
                    elseif ($getProductDetail->isbagdenew == 1)
                    {
                        $imgname['returnimg'] = 'icon_new.png';
                        $imgname['returnclass'] = 'icon-new';//'icon_new.png';
                    }
                    elseif ($getProductDetail->isbagdegift == 1)
                    {
                        $imgname['returnimg'] = 'icon_gif.png';
                        $imgname['returnclass'] = 'icon-gift';//;//'icon_gif.png';
                    }
                    else $imgname['noshowimage'] = 1;
                    }
                }
            }
            echo (!empty($imgname['returnimg']))?json_encode($imgname): $_POST['value'];
        }
    }

    public function inlinespecialAction()
    {
        if(!empty($_POST['id']) && !empty($_POST['fpid']) && !empty($_POST['fpcid'])
            && is_numeric($_POST['fpid']) && is_numeric($_POST['fpcid'])
        )
        {
            $listAllArray = array('p_name');
            if(in_array($_POST['type'],$listAllArray))
            {
                Core_ProductEditInline::updateData($_POST['fpcid'],$_POST['fpid'],array($_POST['type']=>$_POST['value']));
            }
            echo $_POST['value'];
        }
    }

    //Tra gop
    public function installmentAction()
    {
        $formData['fid'] = (int)(!empty($_GET['id'])?$_GET['id']:0);
        if($formData['fid'] <=0)
        {
            ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'];?>";</script><?php
            exit();
        }
        $myProduct = new Core_Product($formData['fid']);
        //$myProduct->status != Core_Product::STATUS_ENABLE || $myProduct->customizetype != Core_Product::CUSTOMIZETYPE_MAIN
        if($myProduct->id < 0 || $myProduct->sellprice <= 0 || $myProduct->onsitestatus <=0 || $myProduct->instock <=0)
        {
            ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'];?>";</script><?php
            exit();
        }
        $finalPrice = Core_RelRegionPricearea::getPriceByProductRegion(trim($myProduct->barcode), (!empty($formData['fregion'])?$formData['fregion']:$this->registry->region));
        if($finalprice > 0) {
            $myProduct->sellprice = $finalPrice;
        }

        if(!empty($_POST['btnBuyInstallMent']))
        {
            $formData = $_POST;
            if(!empty($formData['fgender']) && !empty($formData['ffullname'])  && !empty($formData['femail'])  && Helper::ValidatedEmail($formData['femail'])
                && !empty($formData['fbirdthdate']) && !empty($formData['fpersonid']) && !empty($formData['fpersontype'])
                && !empty($formData['faddress']) && !empty($formData['fphone']) && !empty($formData['fregion']) && !empty($formData['fregionresident'])
                && !empty($formData['finstallmentmonth']) && !empty($formData['fsegmentpercent']) && Helper::checkPhoneAvalible($formData['fphone']))// && !empty($formData['fpayathome'])
            {
                $getprepaid = Core_Installment::calcInstallment($myProduct->sellprice, ((int)$formData['fsegmentpercent'])/100, $formData['finstallmentmonth'], $myProduct->pcid);
                if(!empty($getprepaid['ACS']) && !empty($getprepaid['PPF']) && (!empty($getprepaid['PPF']['nosupport']) ||  !empty($getprepaid['ACS']['nosupport'])))
                {
                    $myInstallment = new Core_Installment();
                    $myInstallment->pid = $myProduct->id;
                    $myInstallment->uid = $this->registry->me->id;
                    //$myInstallment->invoiceid = Core_Installment::getInvoicedCode();
                    $myInstallment->pricesell = $myProduct->sellprice;
                    $myInstallment->pricemonthly = (!empty($getprepaid['PPF']['monthly'])?$getprepaid['PPF']['monthly']:0);  //lưu cột này cho PPF
                    $myInstallment->gender = ($formData['fgender']==1?Core_Installment::GENDER_MALE: Core_Installment::GENDER_FEMALE);
                    $myInstallment->fullname = $formData['ffullname'];
                    $myInstallment->email = $formData['femail'];
                    $myInstallment->phone = $formData['fphone'];
                    $myInstallment->birthday = Helper::strtotimedmy($formData['fbirdthdate']);
                    $myInstallment->personalid = $formData['fpersonid'];
                    $myInstallment->personaltype = ($formData['fpersontype'] == 1?Core_Installment::TYPE_NGUOIDILAM: Core_Installment::TYPE_SINHVIEN);
                    $myInstallment->address = $formData['faddress'];
                    $myInstallment->region = $formData['fregion'];
                    $myInstallment->regionresident = $formData['fregionresident'];
                    $myInstallment->installmentmonth = $formData['finstallmentmonth'];
                    $myInstallment->segmentpercent = $formData['fsegmentpercent'];
                    $myInstallment->datecreate = time();
                    $myInstallment->payathome = ((!empty($formData['fpayathome']) && $formData['fpayathome']==1)?Core_Installment::PAYATHOME_YES:Core_Installment::PAYATHOME_NO);
                    $_SESSION['user_phonenumber'] = $formData['fphone'];
                    $idtragop = $myInstallment->addData();
                    if($idtragop > 0)
                    {
                        //update invoiced id
                        //$myInstallment = new Core_Installment($idtragop);
                        $myInstallment->invoiceid = $myInstallment->getInvoicedCode();
                        if(!empty($myInstallment->invoiceid))
                        {
                            //Đẩy xuống background task
                            $myInstallment->updateData();
                            //send background job
                            $taskUrl = $this->registry->conf['rooturl'] . 'task/ordercrm/installment?debug=1&ott='.$myInstallment->invoiceid;

                            //file_put_contents('uploads/backgroundjob.txt','uid=' . $uid.'&oid='.$idorder);
                            Helper::backgroundHttpPost($taskUrl, 'iid=' . $idtragop);
                            ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/success?o='.$myInstallment->invoiceid;?>";</script><?php
                            exit();
                        }
                        else {
                            $error[] = 'Lỗi trong quá trình xử lý đơn hàng. Xin vui lòng thử lại';
                        }
                    }
                    else {
                        $error[] = 'Lỗi trong quá trình truyền dữ liệu. Xin quý khách vui lòng gởi lại';
                    }
                }
                else{
                    $error[] = 'Sản phẩm này không hợp lệ để mua trả góp';
                }
            }
            else{
                $error[] = 'Vui lòng cung cấp chính xác thông tin để mua trả góp';
            }
        }
        else
        {
            if($this->registry->me->id > 0)
            {
                $formData['fgender'] = (($this->registry->me->gender == Core_User::GENDER_MALE) ? 1: 2);
                $formData['femail'] = $this->registry->me->email;
                $formData['ffullname'] = $this->registry->me->fullname;
                $formData['fphone'] = $this->registry->me->phone;
                $formData['faddress'] = $this->registry->me->address;
                //$formData['fbirdthdate'] = Helper:: $this->registry->me->birthday;
            }
            $formData['fregion'] = $this->registry->region;
        }


        $this->registry->smarty->assign( array(
            'formData' => $formData,
            'error' => $error,
            'success' => $success,
            'myProduct' => $myProduct,
            'currentCategory' => new Core_Productcategory($formData['fpcid']),
            'currentProduct' => new Core_Product($formData['fid']),
        ));
        $contentpopup = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'popuptragop.tpl');
        $this->registry->smarty->assign( array(
            'error' => $error,
            'success' => $success,
            'pageTitle' => 'Trả góp',
            'contents' => $contentpopup,
        ));
        echo $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
    }

    //check current region that user selected
    public function checkregionAction()
    {
        $rid = (!empty($_POST['r'])?$_POST['r']:'');
        $arrRegion = array(3, 5, 9);
        if(!empty($rid) && in_array($rid, $arrRegion))
        {
            echo json_encode(array('rt' => 1));
        }
        else echo json_encode(array('rt' => 0));
    }

    public function prepaidAction()
    {
        $paytime = (int)(!empty($_POST['m'])?$_POST['m']:0);
        $pid = (int)(!empty($_POST['o'])?$_POST['o']:'');
        $rid = (int)(!empty($_POST['r'])?$_POST['r']:'');
        $s = (int)(!empty($_POST['s'])?$_POST['s']:'');
        $c = (int)(!empty($_POST['c'])?$_POST['c']:'');
        if(!empty($paytime) && !empty($rid) && !empty($pid))
        {
            $myProduct = new Core_Product($pid);
            if($myProduct->id > 0)
            {
                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion(trim($myProduct->barcode), $rid);
                if($finalprice > 0) {
                    $myProduct->sellprice = $finalprice;
                }
                if(!empty($s))
                {
                    $iprepaid = Core_Installment::calcInstallment($myProduct->sellprice, $s/100, $paytime, $myProduct->pcid);
                    if(!empty($iprepaid['ACS']['nosupport']) || !empty($iprepaid['PPF']['nosupport']))
                    {
                        $str = '<ul>
                                <li>Mua trả góp với ACS: <span class="do">'.(!empty($iprepaid['ACS']['nosupport'])?'~'.Helper::formatPrice($iprepaid['ACS']['monthly']).' đ/tháng':'Không hỗ trợ').' </span></li>
                                <li>Mua trả góp với PPF: <span class="do">'.(!empty($iprepaid['PPF']['nosupport'])?'~'.Helper::formatPrice($iprepaid['PPF']['monthly']).' đ/tháng':'Không hỗ trợ').' </span></li>
                            </ul>';
                        echo json_encode(array('dt'=>$str, 'success' => 1));
                    }
                    else{
                        echo json_encode(array('dt'=>'Không hỗ trợ', 'success' => 2));
                    }
                }
                else
                {
                    $percentPrepaid = array();
                    $percentPrepaid[20] = Core_Installment::calcInstallment($myProduct->sellprice, 0.2, $paytime, $myProduct->pcid);
                    $percentPrepaid[30] = Core_Installment::calcInstallment($myProduct->sellprice, 0.3, $paytime, $myProduct->pcid);
                    $percentPrepaid[40] = Core_Installment::calcInstallment($myProduct->sellprice, 0.4, $paytime, $myProduct->pcid);
                    $percentPrepaid[50] = Core_Installment::calcInstallment($myProduct->sellprice, 0.5, $paytime, $myProduct->pcid);
                    $percentPrepaid[60] = Core_Installment::calcInstallment($myProduct->sellprice, 0.6, $paytime, $myProduct->pcid);
                    $percentPrepaid[70] = Core_Installment::calcInstallment($myProduct->sellprice, 0.7, $paytime, $myProduct->pcid);
                    $percentPrepaid[80] = Core_Installment::calcInstallment($myProduct->sellprice, 0.8, $paytime, $myProduct->pcid);

                    $str = '';
                    if (!empty($percentPrepaid))
                    {
						foreach($percentPrepaid as $percent=> $prepaidper)
	                    {
	                        if($prepaidper['PPF']['nosupport']==1 && $prepaidper['PPF']['totalprepaid'] > 0)
	                        {
	                            $str .= '<option value="'.$percent.'"'.($c==$percent?' selected="selected"':'').'>'.$percent.'% (~ '.Helper::formatPrice($prepaidper['PPF']['totalprepaid']).'đ)</option>';
	                        }
	                        elseif($prepaidper['ACS']['nosupport']==1 && $prepaidper['ACS']['totalprepaid'] > 0)
	                        {
	                            $str .= '<option value="'.$percent.'"'.($c==$percent?' selected="selected"':'').'>'.$percent.'% (~ '.Helper::formatPrice($prepaidper['ACS']['totalprepaid']).'đ)</option>';
	                        }
	                    }
                    }
                    unset($percentPrepaid);

                    if($str !='')
                    {
                        $str = '<option value="">--Chọn--</option>'.$str;
                        $arr_return  = array('dt'=>$str, 'success' => 1);
                        if($c > 0)
                        {
                            $iprepaid = Core_Installment::calcInstallment($myProduct->sellprice, $c/100, $paytime, $myProduct->pcid);
                            $strpopup = '';
                            if(!empty($iprepaid['ACS']['nosupport']) || !empty($iprepaid['PPF']['nosupport']))
                            {
                                $strpopup = '<ul>
                                        <li>Mua trả góp với ACS: <span class="do">'.(!empty($iprepaid['ACS']['nosupport'])?'~'.Helper::formatPrice($iprepaid['ACS']['monthly']).' đ/tháng':'Không hỗ trợ').' </span></li>
                                        <li>Mua trả góp với PPF: <span class="do">'.(!empty($iprepaid['PPF']['nosupport'])?'~'.Helper::formatPrice($iprepaid['PPF']['monthly']).' đ/tháng':'Không hỗ trợ').' </span></li>
                                    </ul>';
                            }
                            else{
                                $strpopup = 'Không hỗ trợ';
                            }
                            $arr_return['rightpopup'] = $strpopup;
                        }

                        echo json_encode($arr_return);
                    }
                    else echo json_encode(array('dt'=>'Không hỗ trợ','success' => 2, 'rightpopup' => '<option value="">--Chọn--</option>'));
                }
            }
        }
    }

    public function promotionajaxAction()
    {
        if(!empty($_POST['id']) && !empty($_POST['ids']) && trim($_POST['ids'])!=',' && !empty($_SERVER['HTTP_REFERER']))
        {// && is_numeric($_POST['id']) && !empty($_POST['pid']) && is_numeric($_POST['pid'])
            $explode = explode('_', $_POST['id']);//0 productid , 1 promoid

            if( !empty($explode) && count($explode) == 2)
            {
                if(!empty($explode[0]) && !empty($explode[1]) && is_numeric($explode[1]) && is_numeric($explode[0]))
                {
                    $productDetail = new Core_Product($explode[0],true);//Core_Product::getProducts(array('fbarcode' => $explode[0], 'fisonsitestatus' => 1, 'fpricethan0' => 1), '','',1);
                    if($productDetail->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
                    {
                        $productMain = Core_Product::getMainProductFromColor($productDetail->id);
                        if(!empty($productMain))
                        {
                            $productDetail->displaysellprice = $productMain->displaysellprice;
                            $productDetail->status           = $productMain->status;
                        }
                    }
                    if($productDetail->id >0 && $productDetail->sellprice > 0 && $productDetail->onsitestatus > 0 && ($productDetail->customizetype == Core_Product::CUSTOMIZETYPE_MAIN||$productDetail->customizetype == Core_Product::CUSTOMIZETYPE_COLOR) && $productDetail->status == Core_Product::STATUS_ENABLE)
                    {
                        //lay nhung KM kem theo
                        $listallpromoids = explode(',', $_POST['ids']);
                        if (!empty($listallpromoids))
                        {
							if (empty($listallpromoids[count($listallpromoids) - 1])) unset($listallpromoids[count($listallpromoids) - 1]);
                        }
                        if (empty($listallpromoids)) $listallpromoids[] = $explode[1];

                        $productDetail->barcode = trim($productDetail->barcode);
                        //$onepromotion = Core_Promotion::getOnePromotionbyID($explode[1], $this->registry->region, $productDetail->barcode);
                        $checkoutLink = $productDetail->slug != ""?'mua-'.$productDetail->slug:"checkout?id=".$productDetail->id;
                        $urlbuynow = $this->registry['conf']['rooturl'].'cart/'.$checkoutLink;
                        //if(!empty($onepromotion))
                        //{
                        $finalprice = Core_RelRegionPricearea::getPriceByProductRegion(trim($productDetail->barcode), 3);

                        if($finalprice>0) {
                            $productDetail->sellprice = $finalprice;
                        }

                        $firstDiscount = Core_Promotion::getFirstDiscountPromotionByListId($listallpromoids, 3 );//Core_Promotion::getFirstDiscountPromotionById($explode[1], $this->registry->region );

                        $promoisdiscount = 0;
                        $promoprice = 0;
                        $saving = 0;
                        if(!empty($firstDiscount))
                        {
                            $promoisdiscount = $firstDiscount['promoid'];
                            $explode[1] = $firstDiscount['promoid'];
                            if($firstDiscount['percent']==1)
                            {
                                $promoprice = round($productDetail->sellprice - ($productDetail->sellprice*$firstDiscount['discountvalue']/100));
                            }
                            else
                            {
                                $promoprice = $productDetail->sellprice - $firstDiscount['discountvalue'];
                            }
                            $saving = Helper::formatPrice($productDetail->sellprice - $promoprice);
                            //$promoprice = Helper::formatPrice($promoprice);
                        }
                        $prefixQuery = $productDetail->slug != ""?"?":"&";
                        $urlbuynow .= $prefixQuery.'prid='.$productDetail->barcode.'_'.$explode[1];

                        if (SUBDOMAIN == 'm'){
                        	$urlbuynow .= '&po=p' . substr(trim($productDetail->barcode), -5, 5) . '41';
                        }


                        $cntpromoids = count($listallpromoids) - 1;
                        if(empty($listallpromoids[$cntpromoids])){
                            unset($listallpromoids[$cntpromoids]);
                            $cntpromoids--;
                        }
                        //xoa KM hien hanh tu list all
                        $ixpromo = array_search($explode[1], $listallpromoids);
                        if($ixpromo === false)
                        {
                            echo json_encode(array('error' => 1));
                        }
                        else
                        {
                            if(!empty($listallpromoids[$ixpromo])) {
                                unset($listallpromoids[$ixpromo]);
                                $cntpromoids--;
                            }

                            //lay tat ca id KM loai tru cua KM hien hanh
                            $checkpromotionexclude = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=>$explode[1]),'','');
                            if(!empty($checkpromotionexclude))
                            {
                                foreach($checkpromotionexclude as $promoexcl)
                                {
                                    //$getexcludepromotion[$lpromo['promoid']][] = $promoexcl->promoeid;
                                    if(in_array($promoexcl->promoeid, $listallpromoids))
                                    {
                                        unset($listallpromoids[array_search($promoexcl->promoeid, $listallpromoids)]);
                                        $cntpromoids--;
                                    }
                                }
                            }
                            $checkpromotionexcludeelse = Core_PromotionExclude::getPromotionExcludes(array('fpromoeid'=>$explode[1]),'','');
                            if(!empty($checkpromotionexcludeelse))
                            {
                                foreach($checkpromotionexcludeelse as $promoexcl)
                                {
                                    if(in_array($promoexcl->promoid, $listallpromoids))
                                    {
                                        unset($listallpromoids[array_search($promoexcl->promoid, $listallpromoids)]);
                                        $cntpromoids--;
                                    }
                                }
                            }

                            //ra duoc list exclude check trong cai list nay coi co trung khong
                            $newlistexclude = $listallpromoids;
                            foreach($newlistexclude as $promoidex)
                            {
                                $checkpromotionexclude = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=>$promoidex),'','');
                                if(!empty($checkpromotionexclude))
                                {
                                    foreach($checkpromotionexclude as $promoexcl)
                                    {
                                        //$getexcludepromotion[$lpromo['promoid']][] = $promoexcl->promoeid;
                                        if(in_array($promoexcl->promoeid, $listallpromoids))
                                        {
                                            unset($listallpromoids[array_search($promoexcl->promoeid, $listallpromoids)]);
                                            $cntpromoids--;
                                        }
                                    }
                                }
                            }

                            $getpromotioninclude = null;
                            if(!empty($listallpromoids))
                            {
                                $cntpromoids = $cntpromoids+1;

                                //get promotion default
                                if($promoprice <= 0)
                                {
                                    $promotiondefault = $productDetail->promotionPrice();
                                    if(!empty($promotiondefault) && !empty($promotiondefault['promoid']) && in_array($promotiondefault['promoid'], $listallpromoids))
                                    {
                                        $promoprice = $promotiondefault['price'];
                                        $promoisdiscount = $promotiondefault['promoid'];
                                    }
                                }
                                if($promoisdiscount > 0 && in_array($promoisdiscount, $listallpromoids))
                                {
                                    unset($listallpromoids[array_search($promoisdiscount, $listallpromoids)]);
                                }
                                if(!empty($listallpromoids)) $getpromotioninclude = Core_Promotion::getPromotions(array('fidarr' => $listallpromoids, 'fisavailable' => 1),'name','ASC',$cntpromoids);
                            }

                            //show KM duoc ap dung kem
                            $joinpromotion = '';
                            if(!empty($getpromotioninclude))
                            {
                                foreach($getpromotioninclude as $promojoin)
                                {
                                    $promotiondes = trim(htmlspecialchars_decode(trim(strip_tags($promojoin->description))));
                                    if($promotiondes != '-' && $promotiondes != '.')
                                    {
                                        $joinpromotion .= '- '.strip_tags(!empty($promojoin->description)?$promojoin->description:$promojoin->descriptionclone).'<br />';
                                    }
                                }
                            }
                            $joinpromotion = '';
                            //echodebug($joinpromotion);
                            $this->registry->smarty->assign(array('productDetail' => $productDetail, 'promotionprice' => $promoprice,'fsaving' => $saving,'joinpromotion' => $joinpromotion,'currentTime' => time()));//'firstPromotion'=>$onepromotion,
                            echo json_encode(array(
                                'block' => $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'loadpormotionajax.tpl'),
                                'id'    => $productDetail->id,//barcode, promotid
                                'prid'    => $productDetail->barcode.'_'.$explode[1],//barcode, promotid
                                'urlbuynow' => $urlbuynow,

                                'fpromotion' => Helper::formatPrice($promoprice),
                                'fsaving' => Helper::formatPrice($saving),
                                'fprice' => Helper::formatPrice($productDetail->sellprice),
                            ));
                        }
                        //}
                    }
                }
            }
        }
    }

    public function loadpromotionajaxAction()
    {
        $arrReturn = array('success' => 2);
        if (!empty($_POST['pid']) && is_numeric( $_POST['pid'] ))
        {
            $pid = (int)$_POST['pid'];
            $productDetail = new Core_Product($pid, true);
            if($productDetail->id >0 )
            {
                $listpromotionbypromotionids = array();
                //$listpromotions = Core_Promotion::getPromotionByProductIDFrontEnd(trim($productDetail->barcode), $this->registry->region, $productDetail->sellprice);
                $listpromotions = Core_Promotion::getPromotionByProductIDFrontEnd(trim($productDetail->barcode), 3, $productDetail->sellprice);
                if(!empty($listpromotions['listPromotions']))
                {
                    foreach($listpromotions['listPromotions'] as $lpromo)
                    {
                        /*if($lpromo['startdate'] > $findmaxstartdatepromotion)
                        {
                            $findmaxstartdatepromotion = $lpromo['startdate'];
                        }
                        if($findminenddatepromotion == 0 || $lpromo['enddate'] < $findminenddatepromotion)
                        {
                            $findminenddatepromotion = $lpromo['enddate'];
                        }*/
                        //$promotiondes = trim(htmlspecialchars_decode(trim(strip_tags($lpromo['promoname']))));
                        //if ($promotiondes == '.' || $promotiondes == '-' || $promotiondes == '' || $promotiondes == '&nbsp;') $lpromo['promoname'] = '.';
                        $promoObj = new Core_Promotion($lpromo['promoid'] , true);
                        if(trim(strip_tags($promoObj->description)) == '.' && trim(strip_tags($promoObj->descriptionclone)) != '') {
                            $lpromo['disablegift'] = 1;
                        } else {
                            $lpromo['disablegift'] = 0;
                        }
                        $listpromotionbypromotionids[$lpromo['promoid']] = $lpromo;
                    }
                }

                $this->registry->smarty->assign(array('productDetail' => $productDetail, 'listpromotionbypromotionids' => $listpromotionbypromotionids));
                $blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'loadpormotionlistajax.tpl');
                $arrReturn['success'] = 1;
                $arrReturn['blockhtml'] = $blockhtml;
            }
        }
        echo json_encode($arrReturn);
    }

    public function adviceAction()
    {
        $newRelProductProduct = array();
        if(!empty($_GET['pid']))
        {
            $relProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$_GET['pid'], 'ftype' => Core_RelProductProduct::TYPE_PRODUCT2),'','',3);

            $relProductProduct = array($_GET['pid']);

            if(!empty($relProduct))
            {
                foreach($relProduct as $relpp)
                {
                    $relProductProduct[] = $relpp->piddestination;
                }

                if(!empty($relProductProduct))
                {
                    $newRelProductProduct = Core_Product::getProducts(array('fidarr'=>$relProductProduct, 'fpricethan0' => 1,'fquantitythan0' => 1, 'fisonsitestatus' => 1, 'fstatus' => Core_Product::STATUS_ENABLE, 'fcustomizetype' => Core_Product::CUSTOMIZETYPE_MAIN),'','',3); //, 'fquantitythan0'=> 1, 'fpricethan0'=> 1
                    //echodebug($newRelProductProduct);
                    if(!empty($newRelProductProduct))
                    {
                        $num = count($newRelProductProduct);
                        for($i =0 ; $i < $num; $i++)
                        {
                            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($newRelProductProduct[$i]->barcode, $this->registry->region);
                            if($finalprice >0) {
                                $newRelProductProduct[$i]->sellprice = ($finalprice);
                            }
                            else
                            {
                                $newRelProductProduct[$i]->sellprice = ($newRelProductProduct[$i]->sellprice);
                            }
                            /*$newsummary = '';
                            $explodenewsummary = explode("\n",strip_tags($newRelProductProduct[$i]->summary));//Helper::xss_replacewithBreakline(strip_tags($pro->summary));

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
                                $newRelProductProduct[$i]->summary = $newsummary;
                            }*/
                        }
                    }
                }
            }
        }
        $this->registry->smarty->assign(array(
            'relProductProduct' => $newRelProductProduct
        ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'advicepopup.tpl');

        $this->registry->smarty->assign(array('contents' => $contents,
            'pageTitle' => 'Tư vấn sản phẩm',
            'relProductProduct' => $newRelProductProduct
        ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_popup.tpl');  //smartyControllerContainerRoot
    }


    //List vendor
    public function vendorAction()
    {
        global $protocol;
        $arrayAssignTemplate = array();
        $slug = parse_url(Helper::slugBannerURL(), PHP_URL_PATH);
        $fvid = (int)(isset($_GET['fvid'])?$_GET['fvid']:0);
        if($fvid == 0)
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        $arrayAssignTemplate['page']        = (int)($_GET['page'])>0?(int)($_GET['page']):1;
        $arrayAssignTemplate['currentTime'] = time();

        $cachefile = $protocol.'sitehtml_productvendor'.'_'.$fvid.'_'.$this->registry->region.'_'.$arrayAssignTemplate['page'];//.'.html';

        $myCache = new Cacher($cachefile);
        if(isset($_GET['live'])) //no edit
        {
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.'sitehtml_productvendor'.'_'.$fvid.'_'.$ritem->id.'_1';
                    $cachefile2 = $protocol.'sitehtml_productvendor'.'_'.$fvid.'_'.$ritem->id.'_2';
                    $cachefile3 = $protocol.'sitehtml_productvendor'.'_'.$fvid.'_'.$ritem->id.'_3';
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->clear();

                    $removeCache2 = new Cacher($cachefile2);
                    $removeCache2->clear();

                    $removeCache3 = new Cacher($cachefile3);
                    $removeCache3->clear();
                }
            }
            $pageHtml = '';
        }
        elseif($arrayAssignTemplate['page'] < 4) {
            $pageHtml = $myCache->get();
        }
        else{
            $pageHtml = '';
        }

        if(!$pageHtml)
        {
            $templatepage = 'productsvendornew.tpl';

            $getCurrentVendor    = new Core_Vendor($fvid);
            if (!empty($getCurrentVendor->topseokeyword)) $arrayAssignTemplate['headertext'] = $getCurrentVendor->topseokeyword;

            if(empty($getCurrentVendor))
            {
                header('location: ' . $this->registry->conf['rooturl']);
                exit();
            }

            $arrayAssignTemplate['paginateurl'] = preg_replace('/\/page\-[0-9]+/', '', Helper::curPageURL());

            $arrProductCond = array('fisonsitestatus'=>1, 'fpricethan0' => 1);
            $arrProductCond['fvid'] = $fvid;
            $arrProductCond['fstatus'] = Core_Product::STATUS_ENABLE;
            $arrProductCond['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;

            $total = Core_Product::getProducts($arrProductCond,'','', 0, true);
            $arrayAssignTemplate['total']       = $total;
            $arrayAssignTemplate['totalPage']   = ceil($total/$this->recordPerSearchPage);
            $arrayAssignTemplate['curPage']     = $arrayAssignTemplate['page'];

            // Get banner of brand
            $getAdsSlugs = Core_AdsSlug::getAdsSlugs(array('faslug'=>$slug),'','');

            $aid = array();
            foreach($getAdsSlugs as $adsSlug){
                $aid[] = $adsSlug->aid;
            }
            if(!empty($aid)){
                $arrBannerBrand['fidarr'] = $aid;
                $arrBannerBrand['fisactive'] = (int)Core_Ads::STATUS_ENABLE;
                $arrBannerBrand['fstatus'] = (int)Core_Ads::STATUS_ENABLE;
                $arrBannerBrand['ftype'] = (int)Core_Ads::TYPE_BANNER;
                $getBannerVendor = Core_Ads::getAdss($arrBannerBrand, '','');

                if(!empty($getBannerVendor))
                    $getBannerVendor = $getBannerVendor[0];
            }
            //end get banner brand
            //$listproductcat   = Core_Product::getProducts($arrProductCond,$orderby,'DESC',(($arrayAssignTemplate['page'] - 1)*$this->recordPerPage).',12');
            $orderby = 'finalprice';
            $listproductcat   = Core_Product::getProducts($arrProductCond,$orderby,'DESC');

            $listnewpro = array();
            if(!empty($listproductcat)){
                foreach($listproductcat as $pro){
                    if ( $pro->customizetype != Core_Product::CUSTOMIZETYPE_MAIN) continue;
                    if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){
                        $newsummary = '';
                        $explodenewsummary = explode("\n",strip_tags($pro->summary));//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
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
                        $myCategory  = new Core_Productcategory($pro->pcid, true);
						if ($myCategory->appendtoproductname == 1) $pro->name = $myCategory->name.' '.$pro->name;
                        $pro->summary = $newsummary;
                        $pro->productspecial = Core_Ads::getBannerListByProuctId($pro->id, 'h');
                        if(!empty($pro->productspecial)) $pro->productspecial = $pro->productspecial[0];
                    }
                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);
                    if($finalprice > 0) {
                        $pro->sellprice = $finalprice;
                    }

                    $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$pro->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                    $listnewpro[] = $pro;
                }
            }
            if(count($listnewpro) > 0)
            {
                $listVendorColor = array();
                $listVendorColorTmp = array();
                foreach ($listnewpro as $keyvendor => $productvendoritem) {
                    //Loop top item list get color if exsist
                    $listVendorColorTmp = explode("###", $productvendoritem->colorlist);
                    foreach ($listVendorColorTmp as $productVendorColor) {
                        $listVendorColor[$productvendoritem->id][] = explode(':', $productVendorColor);
                    }
                }
            }
            //$arrayAssignTemplate['hideMenu'] = 1;
            $arrayAssignTemplate['listVendorColor'] = $listVendorColor;
            $arrayAssignTemplate['listproductcat'] = $listnewpro;
            $arrayAssignTemplate['curVendor'] = $getCurrentVendor;
            $arrayAssignTemplate['pageCanonical'] = $arrayAssignTemplate['paginateurl'];
            $arrayAssignTemplate['pageTitle'] = (!empty($getCurrentVendor->seotitle)?$getCurrentVendor->seotitle:$getCurrentVendor->name);
            $arrayAssignTemplate['pageDescription'] = (!empty($getCurrentVendor->seodescription)?$getCurrentVendor->seodescription:$getCurrentVendor->name);
            $arrayAssignTemplate['pageMetarobots'] = (!empty($getCurrentVendor->metarobot)?$getCurrentVendor->metarobot:'');
            $listvendors = Core_Vendor::getVendors(array('fstatus' => Core_Vendor::STATUS_ENABLE, 'ftype' => Core_Vendor::TYPE_VENDOR), 'name', 'DESC');
            $arrayAssignTemplate['listvendors'] = $listvendors;
            $arrayAssignTemplate['bannervendor'] = $getBannerVendor;

            $this->registry->smarty->assign($arrayAssignTemplate);
            $producttop = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'producttopnew.tpl');
            $arrayAssignTemplate['producttop'] = $producttop;
            $arrayAssignTemplate['productdisplaytext'] = Core_Product::DISPLAY_TEXT;
            $arrayAssignTemplate['productdisplaybanner'] = Core_Product::DISPLAY_BANNER;
            $this->registry->smarty->assign( $arrayAssignTemplate );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$templatepage);
            $this->registry->smarty->assign(array('contents' => $contents));

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);
        }

        echo $pageHtml;
    }

    public function vendorListAction(){
		global $protocol;
        $keyword = (isset($_GET['q'])?$_GET['q']:'all');

        $cachefile = $protocol.'sitehtml_productvendorlist'.'_'.$keyword.'_'.$this->registry->region;//.'.html';

        $myCache = new Cacher($cachefile);
        if(isset($_GET['live'])) //no edit
        {
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.'sitehtml_productvendorlist'.'_'.$keyword.'_'.$ritem->id;
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->clear();
                }
            }
            $pageHtml = '';
        }
        else {
            $pageHtml = $myCache->get();
        }

        if(!$pageHtml)
        {
            if( $keyword == 'all'){
                $brandmostpagetext = new Core_Page(43, true);//nhan hieu ua chuong nhat
                $arrayTemplate = array( 'brand'=> $brandmostpagetext,
                    'keyword'=>$keyword
                );
            }else{
                $arrVendor = array();
                $arrVendor['fkeywordFilterCharacter'] = $keyword;
                $getVendor    = Core_Vendor::getVendors($arrVendor,'name', 'DESC');
                $arrayTemplate = array(
                    'vendorbykey'=> $getVendor,
                    'keyword'=>$keyword,
                    'pageTitle'=>'Nhãn hiệu theo '. $keyword,
                );

            }

            $templatepage = 'productsvendorlist.tpl';
            $this->registry->smarty->assign($arrayTemplate);
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . $templatepage);

            $this->registry->smarty->assign(array(  'contents'  => $contents,));
            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);
        }
        echo $pageHtml;
    }

    public function sieuthiconhangAction()
    {
        $barcode = trim(Helper::plaintext(isset($_GET['code'])?$_GET['code']:''));
        $listnewstores = null;
        $listnewregion = null;
        if(!empty($barcode))
        {
            $myproduct = Core_Product::getIdByBarcode($barcode);
            $liststoreid = array();

            $firstRegion = null;
            if($myproduct->id > 0)
            {

                /*$liststoreid = Core_Product::getStoreAvailable($myproduct->barcode);
                $liststores = array();
                if(!empty($liststoreid))
                {
                    $liststores = Core_Store::getStores(array('fidarr' => $liststoreid, 'fstatus' => Core_Store::STATUS_ENABLE,'fissalestore'=>1,'fisautostorechange'=>1),'name','ASC');//, 'fstatus' =>Core_Store::STATUS_ENABLE
                    //echodebug($liststores);
                    if(!empty($liststores))
                    {
                        $listregionid = array();
                        $hashocmcity = false;
                        foreach($liststores as $st)
                        {
                            if($st->lng !=0 && $st->lat !=0)
                            {
                                if($st->region == 3) $hashocmcity = true;
                                if(!in_array($st->region, $listregionid))
                                {
                                    $listregionid[] = $st->region;
                                }
                            }
                            $listnewstores[$st->id] = $st;
                        }
                        if($hashocmcity)
                        {
                            $liststorehcm = Core_Store::getStores(array('fregion' => 3, 'fstatus' => Core_Store::STATUS_ENABLE),'name','ASC');

                            $liststoreidhcm = array();
                            if(!empty($liststorehcm))
                            {
                                foreach($liststorehcm as $st)
                                {
                                    if(empty($listnewstores[$st->id]))
                                    {
                                        $listnewstores[$st->id] = $st;
                                    }
                                }
                            }
                        }
                        if(!empty($listregionid))
                        {
                            $listregion = Core_Region::getRegions(array('fidarr'=>$listregionid),'name','ASC');
                            if(!empty($listregion))
                            {
                                foreach($listregion as $regid)
                                {
                                    if(empty($firstRegion)) $firstRegion = $regid;
                                    $listnewregion[$regid->id] = $regid;
                                }
                            }
                        }
                    }
                }*/
                $liststores = Core_ProductStock::getStoreStockFromErpByProduct(trim($myproduct->barcode));
                $listnewstores = array();
                $havestorestock = array();
                $listregionid = array();
                $$listnewregion = array();
                if (!empty($liststores))
                {
                    foreach ($liststores['stores'] as $st) {
                        $listnewstores[$st->id] = $st;
                        $havestorestock[] = $st;
                        $listregionid[] = $st->region;
                    }
                }
                if(!empty($listregionid))
                {
                    $listregion = Core_Region::getRegions(array('fidarr'=>$listregionid),'name','ASC');
                    if(!empty($listregion))
                    {
                        foreach($listregion as $regid)
                        {
                            if(empty($firstRegion)) $firstRegion = $regid;
                            $listnewregion[$regid->id] = $regid;
                        }
                    }
                }
            }
            //$myRegion = new Core_Region($this->registry->region, true);
        }
        if(!empty($listnewregion[$this->registry->region]))
        {
            $firstRegion = $listnewregion[$this->registry->region];
        }
        $this->registry->smarty->assign(
            array('liststores' => $listnewstores,
                'listregions' => $listnewregion,
                'firstRegion' => $firstRegion,
            )
        );
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productstores.tpl');
        $this->registry->smarty->assign(
            array('contents' => $contents,
            )
        );
        if(SUBDOMAIN == 'm')
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
        else
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
    }

    public function dattruocAction()
    {
        $id = (int)(isset($_GET['id'])?$_GET['id']:0);
        if($id <= 0) {
            ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'];?>";</script><?php
        }
        $myProduct = new Core_Product($id);
        $myOrders = array();
        if($myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID && $myProduct->prepaidprice >0 && $myProduct->prepaidstartdate <= time() && $myProduct->prepaidenddate >= time() && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN && $myProduct->status == Core_Product::STATUS_ENABLE)
        {
            //38 la ma chuong trinh dat hang truoc
            $listmyorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($myProduct->prepaidstartdate, $myProduct->prepaidenddate )),'id','ASC');
            if(!empty($listmyorders)){
                $listordersid = array();
                $listorderpre = array();
                //$listusername = array();
                foreach($listmyorders as $order)
                {
                    /*$prepaidnumberorders = Core_OrdersDetail::getOrdersDetails(array('foid' => $order->id, 'fpid' => $myProduct->id),'','','', true);
                    if($prepaidnumberorders > 0)
                    {
                        $myOrders[] = $order;
                    }*/
                    $listordersid[] = $order->id;
                    $listorderpre[$order->id] = $order;
                    //$listusername[$order->id] = $order->billingfullname;
                }
                if(!empty($listordersid)){
			        $prepaidorderdetail = Core_OrdersDetail::getOrdersDetails(array('foidarr' => $listordersid, 'fpid' => $myProduct->id),'oid','DESC');
				    if(!empty($prepaidorderdetail)){
				        foreach($prepaidorderdetail as $odd){
				            if (!empty($listorderpre[$odd->oid])) $myOrders[] = $listorderpre[$odd->oid];
				        }
				    }
			    }
            }
        }
        $this->registry->smarty->assign(
            array(
                'myOrders' => $myOrders,
                'myProduct' => $myProduct
            )
        );
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'dattruoc.tpl');
        $this->registry->smarty->assign(
            array('contents' => $contents,
            )
        );
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_popup.tpl');
    }

    public function updateaccessoryAction()
    {
        if(!empty($_POST['pid']) && isset($_POST['acc']) && !empty($_SERVER['HTTP_REFERER']))
        {
            $promoid = 0;
            $pid = (int) $_POST['pid'];
            $myProduct = new Core_Product( $pid, true );
            if($myProduct->id > 0 && $myProduct->status == Core_Product::STATUS_ENABLE && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&
                ($myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID && $myProduct->prepaidprice > 500 && $myProduct->prepaidstartdate <= time() && $myProduct->prepaidenddate > time()
                    || $myProduct->onsitestatus > 0 && $myProduct->instock > 0 && $myProduct->sellprice > 500)
            )
            {

                if( !empty($_POST['promo']) )
                {
                    $promoid = (int) str_replace($pid.'_', '', $_POST['promo']);
                }
                if ($myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID) $productsellprice = $myProduct->prepaidprice;
                else
                {
                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, $this->registry->region);
                    if ($finalprice > 0) $productsellprice = $finalprice;
                    else $productsellprice = $myProduct->sellprice;
                }

                $promoprice = 0;
                if ($promoid > 0)
                {
                    $firstDiscount = Core_Promotion::getFirstDiscountPromotionById($promoid, $this->registry->region );

                    if(!empty($firstDiscount))
                    {
                        $promoisdiscount = $firstDiscount['promoid'];
                        if($firstDiscount['percent']==1)
                        {
                            $promoprice = round($productsellprice - ($productsellprice*$firstDiscount['discountvalue']/100));
                        }
                        else
                        {
                            $promoprice = $productsellprice - $firstDiscount['discountvalue'];
                        }
                    }
                }
                $mainproductprice = $productsellprice;
                $promotionprices = $productsellprice;
                $saving = 0;

                //if ( $myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID ) {
//					$promotionprices = $mainproductprice = $myProduct->prepaidprice;
//				}

                if ( $promoprice > 0 ){
                    $saving = $mainproductprice - $promoprice;
                    $promotionprices = $promoprice;
                }

                if ( !empty($_POST['acc']) )
                {
                    $acc = Helper::plaintext($_POST['acc']);
                    $explodeacc = explode( ',', $acc );
                    if( count($explodeacc) > 0)
                    {
                        $savingsessionproductid = array();
                        foreach($explodeacc as $productid)
                        {
                            if ( $productid > 0)
                            {
                                $accessProduct = new Core_Product($productid, true);
                                if($accessProduct->id > 0 && $accessProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN && $accessProduct->status == Core_Product::STATUS_ENABLE &&
                                    ($accessProduct->onsitestatus == Core_Product::OS_ERP_PREPAID && $accessProduct->prepaidprice > 500 && $accessProduct->prepaidstartdate <= time() && $myProduct->prepaidenddate > time()
                                        || $accessProduct->onsitestatus > 0 && $accessProduct->instock > 0 && $accessProduct->sellprice > 500)
                                )
                                {
                                    $subpriceproduct = 0;
                                    if ( $accessProduct->onsitestatus == Core_Product::OS_ERP_PREPAID ){
                                        $subpriceproduct = $accessProduct->prepaidprice;
                                    }
                                    else{
                                        $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($accessProduct->barcode, $this->registry->region);
                                        if ($finalprice > 0) $subpriceproduct = $finalprice;
                                        else $subpriceproduct = $accessProduct->sellprice;
                                    }
                                    $mainproductprice += $subpriceproduct;
                                    $getAccPromotion = $accessProduct->promotionPrice();
                                    if (!empty($getAccPromotion) && count($getAccPromotion) > 0)
                                    {
                                        $promotionprices += $getAccPromotion['price'];
                                        $subsaving = $subpriceproduct - $getAccPromotion['price'];
                                        $saving += $subsaving;
                                    }
                                    $savingsessionproductid[] = $productid;
                                }
                            }
                        }
                        if (!empty($savingsessionproductid) )
                        {
                            $_SESSION['ses_savingsessionproductid'] = $savingsessionproductid;
                        }
                    }
                }
                else unset($_SESSION['ses_savingsessionproductid']);

                $jsonreturn = array();
                $jsonreturn['mainprice'] = Helper::formatPrice( $mainproductprice );
                $jsonreturn['numproduct'] = (!empty($_SESSION['ses_savingsessionproductid']) ? count($_SESSION['ses_savingsessionproductid']) : 0);
                if ( $saving > 0 ) {
                    $jsonreturn['saving'] = Helper::formatPrice( $saving );
                    $jsonreturn['promotionprices'] = Helper::formatPrice( ($mainproductprice - $saving) );
                }
                echo json_encode($jsonreturn);
            }
        }
    }
    public function loadfullgroupattributesAction()
    {
        if( SUBDOMAIN != 'm')
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        if(!isset($_GET['pcid']) || !isset($_GET['pid']))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        $fpcid = $_GET['pcid'];
        $fpid = $_GET['pid'];
        $subdomain = "";
        if(SUBDOMAIN == "m")
             $subdomain = SUBDOMAIN;
        $cachefile = $protocol.$subdomain.'sitehtml_loadfullgroupattributes'.$fpid.'_'.$this->registry->region;
        //$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['ProductpageExpire']);
        $myCache = new Cacher($cachefile);

        if(isset($_GET['customer']) || isset($_GET['live'])) //no edit
        {
            //lấy tất cả các region để clear cache
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.$subdomain.'sitehtml_loadfullgroupattributes'.$fpid.'_'.$ritem->id;
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->clear();
                }
            }
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();

        if(!$pageHtml)
        {
            $formData = array();
            $formData['fid'] = $fpid;
            $formData['fpcid'] = $fpcid;
            $formData['fstatus'] = Core_Product::STATUS_ENABLE;
            $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
            $productDetail = Core_Product::getProducts($formData,'','',1);

            if(empty($productDetail[0]))
            {
                header('location: ' . $this->registry->conf['rooturl']);
                exit();
            }
            $currentCategory = new Core_Productcategory($fpcid, true);
            $productGroupAttributes = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$fpcid,'fstatus'=>Core_ProductGroupAttribute::STATUS_ENABLE),'displayorder','ASC');
            if(count($productGroupAttributes) == 0 && $currentCategory->parentid > 0)
            {
                $productGroupAttributes =    Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$currentCategory->parentid),'displayorder','ASC');
                $newfilterpcid = $currentCategory->parentid;
            }

            //echodebug($productGroupAttributes);
            $arrInarray = array();
            $newrelProductAttributes = array();
            $newProductGroupAttributes = array();
            $newProductAttributes = array();
            $listrelAttributes = array();
            if(!empty($productGroupAttributes))
            {
                foreach($productGroupAttributes as $gattr)
                {
                    $newProductGroupAttributes[$gattr->id] = $gattr;
                    $arrInarray[] = $gattr->id;
                }
                $productAttributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$newfilterpcid,'fpgaidarr'=>$arrInarray,'fstatus'=>Core_ProductAttribute::STATUS_ENABLE),'displayorder','ASC',0);


                if(!empty($productAttributes))
                {
                    $arrInarray = array();
                    foreach($productAttributes as $attr)
                    {
                        $newProductAttributes[$attr->pgaid][$attr->id] = $attr;
                        $arrInarray[] = $attr->id;
                    }
                    $relProductAttributes = Core_RelProductAttribute::getRelProductAttributes(array('fpaidarr'=>$arrInarray,'fpid'=>$fpid),'','');

                    if(!empty($relProductAttributes))
                    {
                        foreach($relProductAttributes as $relPro)
                        {
                            if(!empty($relPro->value) && trim($relPro->value) != '-')
                            {
                                $newrelProductAttributes[$relPro->paid][$relPro->pid] = $relPro;
                            }
                        }
                    }
                }
            }
            $this->registry->smarty->assign( array(
                        'productGroupAttributes'    => $newProductGroupAttributes,
                        'productAttributes'         => $newProductAttributes,
                        'relProductAttributes'      => $newrelProductAttributes,
                        'productDetailId'           => $fpid,
                        'productDetail'             => $productDetail[0],
                        'currentCategory'           => $currentCategory,
                         'currentTime'              => time(),
                    )
            );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'fullgroupattributes.tpl');
            $this->registry->smarty->assign(array('contents' => $contents));

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);
        }
        echo $pageHtml;
    }
    public function loadfullgalleryAction()
    {
        if( SUBDOMAIN != 'm')
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        if(!isset($_GET['pcid']) || !isset($_GET['pid']))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        $fpcid = $_GET['pcid'];
        $fpid = $_GET['pid'];
        $subdomain = "";
        if(SUBDOMAIN == "m")
             $subdomain = SUBDOMAIN;
        $cachefile = $protocol.$subdomain.'sitehtml_loadfullgallery'.$fpid.'_'.$this->registry->region;
        //$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['ProductpageExpire']);
        $myCache = new Cacher($cachefile);

        if(isset($_GET['customer']) || isset($_GET['live'])) //no edit
        {
            //lấy tất cả các region để clear cache
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.$subdomain.'sitehtml_loadfullgallery'.$fpid.'_'.$ritem->id;
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->clear();
                }
            }
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();

        if(!$pageHtml)
        {
            $formData = array();
            $formData['fid'] = $fpid;
            $formData['fpcid'] = $fpcid;
            $formData['fstatus'] = Core_Product::STATUS_ENABLE;
            $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
            //$formData['fpricethan0'] = 1;
            //$formData['favalible'] = 1;
            $productDetail = Core_Product::getProducts($formData,'','',1);
            if(empty($productDetail[0]))
            {
                header('location: ' . $this->registry->conf['rooturl']);
                exit();
            }
            $productDetail[0]->barcode = trim($productDetail[0]->barcode);
            $currentCategory = new Core_Productcategory($fpcid, true);

            //=============================LOAD GALLERY=============================//
            //Product gallery
            $productMedias = Core_ProductMedia::getProductMedias(array('fpid'=>$fpid),'displayorder','ASC','');//,'ftype'=>Core_ProductMedia::TYPE_FILE, 'ffilenotnull'=>1
            //echodebug($productMedias[0]->file);
            $gallery = array();
            $gallery360 = array();
            $video = array();
            $specialimage = '';
            if(!empty($productMedias))
            {
                foreach($productMedias as $media)
                {
                    if($media->type == Core_ProductMedia::TYPE_FILE)
                    {
                        $gallery[] = $media;
                    }
                    elseif($media->type == Core_ProductMedia::TYPE_360)
                    {
                        $gallery360[] = $media;
                    }
                    elseif($media->type == Core_ProductMedia::TYPE_SPECIALTYPE)
                    {
                        $specialimage = $media->getImage();
                    }
                    elseif($media->type == Core_ProductMedia::TYPE_URL)
                    {
                        if(!empty($media->moreurl))
                        {
                            $media->moreurl = Helper::makeEmbedYouTubeUrl($media->moreurl);
                            $media->youtubeid = Helper::getYouTubeVideoId($media->moreurl);
                        }
                        $video[] = $media;
                    }
                }
            }
            //================================END LOAD GALLERY=========================//
            //echodebug($getPromotionPrice);
            //==================================360=====================================//
            $getPathImage360 = '';
            if(!empty($gallery360[0]))
            {

                $imageFile = trim($gallery360[0]->getImage());
                $extension = substr($imageFile,-4);//extension with: .jpg, .png, .gif
                $listexplode = explode('-',substr($imageFile, 0, strrpos($imageFile, '-')+1));
                $getPathImage360 = '';
                if(!empty($listexplode))
                {
                    $number = count($listexplode)-1;
                    if(is_numeric($listexplode[$number])) $number = $number-2;

                    for($i=$number; $i>=0; $i--)
                    {
                        if(!empty($listexplode[$i]))$getPathImage360 = $listexplode[$i].'-'.$getPathImage360;
                    }
                    $getPathImage360 = $getPathImage360.'#'.$extension;
                }
                else {
                    $getPathImage360 = substr($imageFile, 0, strrpos($imageFile, '-')+1).'#'.$extension;
                }
            }
            $this->registry->smarty->assign( array(
                          'galleries'                 => $gallery,
                          'galleries360'              => $gallery360,
                          'videos'                    => $video,
                          'productDetailId'           => $fpid,
                          'specialimage'              => $specialimage,
                          'pathimage360'              => $getPathImage360,
                          'numimage360'               => count($gallery360),
                          'productDetail'             => $productDetail[0],
                          'currentCategory'           => $currentCategory,
                          'currentTime'              => time(),
                    )
            );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'fullgallery.tpl');
            $this->registry->smarty->assign(array('contents' => $contents));

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);
        }
        echo $pageHtml;
    }

	public function filterAction(){

		$fpcid = $_GET['pcid'];
		$fvid = $_GET['vid'];
		if(!isset($fpcid))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        $keyfilter = 'mfilter_' . $fpcid;
 		$cachefilter = new Cacher($keyfilter);
 		$contents = $cachefilter->get();

        $this->registry->smarty->assign(
            array('contents' => $contents,
            )
        );
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}

	public function ajaxmoreproductAction(){
		global $protocol;
		$fpcid = (int)$_POST['fpcid'];
	    $fvid = (int)(isset($_POST['fvid'])?$_POST['fvid']:0);
	    $fvidlist = isset($_POST['fvidlist'])?$_POST['fvidlist']:'';
		$order = isset($_POST['order'])?$_POST['order']:'gia-cao-den-thap';
		$page = (int)$_POST['pages'];

		$subdomain = '';
		if(SUBDOMAIN == 'm'){
			$this->recordPerPage= 12;
			$subdomain = SUBDOMAIN . '_' . $order;
		}
		$cachefile = 'ajax_'.$subdomain.'sitehtml_productlist'.$fpcid.'_'.$fvid.'_'.md5($fvidlist).'_'.$this->registry->region.'_'.$page;
		$cacheajaxproduct = new Cacher($cachefile);
		//$cacheajaxproduct->clear();
		$pagehtml = $cacheajaxproduct->get();
		$pagehtml = '';
		//echo $this->recordPerPage . '<br>';
		//echo ($page-1)*$this->recordPerPage;die;
		if (empty($pagehtml)){
			switch ($order) {
				case 'gia-cao-den-thap':
					$strOrderBy = 'sellprice';
					$strSortOrder = 'DESC';
				break;
				case 'gia-thap-den-cao':
					$strOrderBy = 'sellprice';
					$strSortOrder = 'ASC';
				break;
				case 'moi-nhat':
					$strOrderBy = 'id';
					$strSortOrder = 'DESC';
				break;
				case 'ban-chay-nhat':
					$strOrderBy = 'sellprice';
					$strSortOrder = 'DESC';
				break;
				case 'duoc-quan-tam-nhat':
					$strOrderBy = 'countview';
					$strSortOrder = 'DESC';
				break;
			}
			$arrayConditionProduct = array();
			$arrayConditionProduct['fpcid'] = $fpcid;
			$arrayConditionProduct['fvid'] = $fvid;
			$arrayConditionProduct['fisonsitestatus'] = 1;
            $arrayConditionProduct['fstatus'] = Core_Product::STATUS_ENABLE;
            //$arrayConditionProduct['fpricethan0'] = 1;
            $arrayConditionProduct['fproductavailble'] = 1;
            $arrayConditionProduct['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
            if($fvidlist != '') {
                $vendorslug = explode(",", $fvidlist);
                $vendorlist = Core_Vendor::getVendors(array('fslugarr'=>$vendorslug),'','');
                $vid = array();
                foreach ($vendorlist as $vl) {
                    $vid[] = $vl->id;
                }
                $arrayConditionProduct['fvidarr'] = $vid;
            }

			$listproductcat   = Core_Product::getProducts($arrayConditionProduct,$strOrderBy,$strSortOrder,(($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
            //var_dump($listproductcat);die;
			$listnewpro = array();
                if(!empty($listproductcat)){
                    foreach($listproductcat as $pro){
                        if($pro->id > 0 && $pro->onsitestatus > 0 && $pro->status == Core_Product::STATUS_ENABLE && $pro->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&  (($pro->sellprice > 0 && $pro->instock > 0) || ($pro->prepaidprice > 0 && $pro->onsitestatus == Core_Product::OS_ERP_PREPAID)  || $pro->onsitestatus == Core_Product::OS_COMMINGSOON || $pro->onsitestatus == Core_Product::OS_DOANGIA)){
                            if($pro->displaytype == Core_Product::DISPLAY_BANNER || $pro->displaytype == Core_Product::DISPLAY_TEXT){
                                $newsummary = '';
                                $explodenewsummary = explode("\n",strip_tags($pro->summary));
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
                                $pro->summary = $newsummary;

                                $pro->productspecial = Core_Ads::getBannerListByProuctId($pro->id, 'h');
                                if(!empty($pro->productspecial)) $pro->productspecial = $pro->productspecial[0];
                            }

                            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($pro->barcode, $this->registry->region);
                            if($finalprice > 0) {
                                $pro->sellprice = $finalprice;
                            }
                            if($strOrderBy == 'sellprice' || $fvid > 0)
                            {
                                $getpromotion = $pro->promotionPrice();
                                if(!empty($getpromotion['price']))
                                {
                                    $pro->pricecomparea = $getpromotion['price'];
                                }
                                else
                                    $pro->pricecomparea = $pro->sellprice;
                            }
                            $pro->summary = $newsummary;
                            $pro->listgallery = Core_ProductMedia::getProductMedias(array('fpid'=>$pro->id, 'ffilenotnull'=>1, 'ftype' => Core_ProductMedia::TYPE_FILE),'','',5);
                            $listnewpro[$pro->id] = $pro;
                        }
                    }
                }
                $listproductcat  = $listnewpro;
		   	$this->registry->smarty->assign(array(
	                'listproductcat'  =>  $listproductcat,

	        )
        );

        	$pagehtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'ajaxmoreproduct.tpl');
			$cacheajaxproduct->set($pagehtml);
		}
		echo $pagehtml;
	}

    //=====================Product color==================================
    public function colorproductajaxAction()
    {
        $formData = array();
        $fpid = $_POST['pid'];
        $productColor = new Core_Product($fpid);
        if($productColor->id > 0)
        {
            $subdomain = '';
            if(SUBDOMAIN == 'm');
                $subdomain = SUBDOMAIN;
            $myCacher = new Cacher($subdomain.'sitehtm_colors_'.$fpid);
            $getproductcache = $myCacher->get();
            if (!empty($getproductcache))
            {
                $returnvalue = json_decode($getproductcache, TRUE);
            }
            else
            {
                    $productColor->barcode = trim($productColor->barcode);
                    //Lay thong tin tu san pham chinh
                     if($productColor->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
                    {
                        $productMain = Core_Product::getMainProductFromColor($productColor->id);
                        if(!empty($productMain))
                        {
                            $productColor->displaysellprice = $productMain->displaysellprice;
                            $productColor->status           = $productMain->status;
                            $productColor->onsitestatus     = $productMain->onsitestatus;
                        }
                    }
                    //List Price
                    $listprices['offline'] = $listprices['online'] = Core_RelRegionPricearea::getPriceByProductRegion($productColor->barcode, $this->registry->region);
                    if(!empty($listprices['offline'])){
                        $productColor->sellprice = $listprices['offline'];
                    }
                    //Product gallery
                    $productMedias = Core_ProductMedia::getProductMedias(array('fpid'=>$fpid),'displayorder','ASC','');//,'ftype'=>Core_ProductMedia::TYPE_FILE, 'ffilenotnull'=>1
                    $gallery = array();
                    if(!empty($productMedias))
                    {
                        foreach($productMedias as $media)
                        {
                            if($media->type == Core_ProductMedia::TYPE_FILE)
                            {
                                $gallery[] = $media;
                            }
                        }
                    }
                    //$parentpromotionprices = $productColor->promotionPrice();
                    $productstatus = "";
                    // PRICE
                    $finalprice = 0;
                    if($productColor->onsitestatus == Core_Product::OS_ERP_PREPAID && $productColor->prepaidstartdate <= time() && $productColor->prepaidenddate >= time())
                    {
                        //Dat truoc
                        $finalprice = $productColor->prepaidprice;
                    }
                    elseif($productColor->onsitestatus == Core_Product::OS_ERP)
                    {
                        $finalprice = Core_RelRegionPricearea::getPriceByProductRegionByProductObject($productColor, 3);
                        if ($finalprice < 10)
                        {
                            $finalprice = $productColor->sellprice;
                        }
                    }
                    $discount = 0;
                    $isdiscount = 0;
                    if ($productColor->displaysellprice != 1)
                    {
                        $getpromotion = null;
                        $getpromotion = Core_Promotion::getFirstDiscountPromotion(trim($productColor->barcode), 3);//$myProduct->promotionPrice();
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

                    if ($finalprice <= 0 && $productColor->sellprice > 10)
                        $finalprice = $productColor->sellprice;
                    elseif ($finalprice <= 0 && $productColor->finalprice > 10)
                        $finalprice = $productColor->finalprice;

                    if ($discount <= 0 ) $discount = $finalprice;
                    else $isdiscount = 1;

                    $discount = Helper::formatPrice($discount);
                    //END PRICE
                    //PROMOTION
                    $listpromotionbypromotionids = array();
                    $listpromotions = Core_Promotion::getPromotionByProductIDFrontEnd(trim($productColor->barcode), 3, $productColor->sellprice);
                    $checkoutLink = $productColor->slug != ""?'mua-'.$productColor->slug:"checkout?id=".$productColor->id;
                    $urlbuynow = $this->registry['conf']['rooturl'].'cart/'.$checkoutLink;
                    if(!empty($listpromotions['listPromotions']))
                    {
                        $firstPromotion = '';
                        foreach($listpromotions['listPromotions'] as $key => $lpromo)
                        {
                            $listpromotionbypromotionids[$lpromo['promoid']] = $lpromo;
                            if($key == 0)
                                $firstPromotion = $lpromo['promoid'];
                        }
                        $prefixQuery = $firstPromotion != ""?"?":"&";
                        $urlbuynow .= $prefixQuery.'prid='.trim($productColor->barcode).'_'.$firstPromotion;
                    }
                    $this->registry->smarty->assign(array('productDetail' => $productColor, 'listpromotionbypromotionids' => $listpromotionbypromotionids));
                    $blockhtml = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'loadpormotionlistajax.tpl');
                    //END PROMOTION
                    $gallerycolor = array();
                    foreach ($gallery as $gal => $gall) {
                        $gallerycolor[$gal]['imagesmall'] = $gall->getSmallImage();
                        $gallerycolor[$gal]['imagemedium'] = $gall->checkimagevalid($gall->getMediumImage()) == true ? $gall->getMediumImage():$gall->getImage();
                        $gallerycolor[$gal]['imagelarge'] = $gall->getImage();
                        $gallerycolor[$gal]['caption'] = $gall->caption;
                        $gallerycolor[$gal]['titleseo'] = $gall->titleseo;
                        $gallerycolor[$gal]['alt'] = $gall->alt;
                    }
                    //Kiem tra con hang
                    $instock = 0;
                    if($productColor->instock > 0 && ($productColor->onsitestatus == Core_Product::OS_ERP || $productColor->onsitestatus == Core_Product::OS_HOT || $productColor->onsitestatus == Core_Product::OS_NEW || $productColor->onsitestatus == Core_Product::OS_BESTSELLER ))
                    {
                        $instock = 1; // Tinh trang con hang
                    }
                    else
                    {
                        if($productColor->onsitestatus == Core_Product::OS_COMMINGSOON)
                        {
                            $instock = 2; // Tinh trang hang sap ve
                        }
                        if($productColor->onsitestatus == Core_Product::OS_DOANGIA)
                        {
                            $instock = 3; //Tinh` trang doan gia
                        }
                    }
                    $savepriceitem = array('id' => $productColor->id, 'sell' => Helper::formatPrice($finalprice), 'discount' => $discount, 'isdiscount' => $isdiscount,'success'=>1,'blockhtml' => $blockhtml,'gallerycolor'=>$gallerycolor,'instock'=>$instock,'urlbuynow'=>$urlbuynow);

                    $myCacher->set(json_encode($savepriceitem), 120);
                    $returnvalue = $savepriceitem;
            }
            echo json_encode($returnvalue);

        }

    }


    //=====================End Product color==============================
    public function subcriberendofstockAction()
    {

         // ENDOFSTOCK SUBCRIBER
        if(isset($_POST['fsubmit']))
        {

            $success = array();
            $error = array();
            $fpid = $_POST['pid'];
            $email = $_POST['femail'];
            if(Helper::ValidatedEmail($email))
            {
                $existemail = Core_SubscriberProductoutofstock::getSubscriberProductoutofstocks(array('femail'=>$email,'fpid'=>$fpid),'','');
                if(empty($existemail))
                {
                    $subcriber_endofproduct = new Core_SubscriberProductoutofstock();
                    $subcriber_endofproduct->pid = $fpid;
                    $subcriber_endofproduct->type = Core_SubscriberProductoutofstock::TYPE_OUTOFSTOCK;
                    $subcriber_endofproduct->uid = $this->registry->me->id;
                    $subcriber_endofproduct->email = $email;
                    $subcriber_endofproduct->status = Core_SubscriberProductoutofstock::NOSENDMAIL;
                    if($subcriber_endofproduct->addData())
                    {
                        echo 1; // ok
                    }
                }
                else{
                    echo 2; // Email da ton tai
                }
            }
            else{
                echo 0; //email ko hop le
            }


        }
        // END ENOFSTOCK SUBCRIBER
    }

	public function addproductbookmarkAction(){
		$result = array('error'=> -1, 'data'=>'Có lỗi xảy ra vui lòng thử lại');
		$fpid = (int)(isset($_POST['fpid'])?$_POST['fpid']:0);
	    $fbarcode = (int)(isset($_POST['fbarcode'])?$_POST['fbarcode']:0);
	    if(isset($_POST) && isset($_POST['fpid']) && isset($_POST['fbarcode'])){
	   		$uid = $this->registry->me->id;
	    	if( $uid > 0){
		    	if (!Core_RelProductbookmark::checkproductbookmark($fpid, $uid)){
			    	$productbookmark = new Core_RelProductbookmark();
			    	$productbookmark->pid = $fpid;
			    	$productbookmark->pbarcode = $fbarcode;
			    	$productbookmark->uid = $this->registry->me->id;
			    	if($productbookmark->addData()){
			    		$result = array('error'=> 0, 'data'=>'Sản phẩm đã được đưa vào danh sách yêu thích của bạn. Bạn có thể chỉnh sửa hoặc chia sẻ danh sách yêu thích của mình <a class="asuccess" href="'.$this->registry->conf['rooturl'].'account/bookmark/id/'. base64_encode($this->registry->me->id) .'">tại đây</a>');
			    	}

		    	}else{
		    		$result = array('error'=> 2, 'data'=>'Bạn đã thêm sản phẩm này vào trang yêu thích của bạn rồi !');
		    	}
	    	}else{
	    			$result = array('error'=> 3, 'data'=>'Bạn chưa đăng nhập !');
	    	}
	    }

	    echo json_encode($result);

	}
    public function gettimecrazydealAction()
    {
        $formData = array();
        $formData['fid'] = $_POST['fpid'];
        $formData['fpcid'] = $_POST['fpcid'];
        $formData['fstatus'] = Core_Product::STATUS_ENABLE;
        $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
        //$formData['fpricethan0'] = 1;
        //$formData['favalible'] = 1;
        $productDetail = Core_Product::getProducts($formData,'','',1);
        if($productDetail[0] -> id > 0)
        {
            if($productDetail[0]->onsitestatus == Core_Product::OS_CRAZYSALE)
            {
                $crazydeal = Core_Crazydeal::getCrazydeals(array('fisactive'=>1,'fstatus'=>Core_Crazydeal::STATUS_ENABLE,'fpid'=>$productDetail[0]->id),'id','DESC');
            }
        }
        if($crazydeal[0]->expiretime != "")
        {
            echo date('Y-m-d H:i:s',$crazydeal[0]->expiretime);
        }
    }
    public function gettimeprepaidAction()
    {
        $formData = array();
        $pid = $_POST['fpid'];
        $productDetail = new Core_Product($pid);
        if($productDetail->id > 0 && $productDetail->onsitestatus == Core_Product::OS_ERP_PREPAID)
        {
            echo date('Y-m-d H:i:s',$productDetail->prepaidenddate);
        }
        else
        {
            echo '';
        }
    }
  	public function gettimedoangiaAction()
    {
    	$result = array('error'=> -1, 'timestart'=>'', 'timeend'=>'');
        $formData = array();
        $formData['fid'] = $_POST['fpid'];
        $formData['fpcid'] = $_POST['fpcid'];
        $formData['fstatus'] = Core_Product::STATUS_ENABLE;
        $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;

        $productDetail = Core_Product::getProducts($formData,'','',1);
        if($productDetail[0]->id > 0)
        {
            if($productDetail[0]->onsitestatus == Core_Product::OS_DOANGIA)
            {
                $productguess = Core_ProductGuess::getProductGuesss(array('fisactive'=>1,'fpid'=>$productDetail[0]->id),'id','DESC');
            }
        }
        if($productguess[0]->expiretime != "")
        {
        	$result = array('error'=> 0, 'timestart'=>date('Y-m-d H:i:s',$productguess[0]->starttime), 'timeend'=>date('Y-m-d H:i:s',$productguess[0]->expiretime));
        }

        echo json_encode($result);
    }

    public function updatestatusandpromotionAction()
    {
    	global $protocol;
        $formData = array();
        $formData['fid'] = $_POST['fpid'];
        $formData['fpcid'] = $_POST['fpcid'];
        $formData['fstatus'] = Core_Product::STATUS_ENABLE;
        $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
        $productDetail = Core_Product::getProducts($formData,'','',1);
        if($productDetail[0] -> id > 0)
        {
            if($productDetail[0]->onsitestatus == Core_Product::OS_CRAZYSALE)
            {
                $crazydeal = Core_Crazydeal::getCrazydeals(array('fstatus'=>Core_Crazydeal::STATUS_ENABLE,'fpid'=>$productDetail[0]->id),'id','DESC');
                if(!empty($crazydeal))
                {
                    $productupdate = new Core_Product($productDetail[0]->id);
                    if($productupdate->id > 0)
                    {
                        $promotionliststr = $productupdate->promotionlist;
                        $productupdate->onsitestatus = $crazydeal[0]->oldonsitestatus;
                        $productupdate->promotionlist = '';
                        if($productupdate->updateData())
                        {
                            $promotiontmp = explode(",",$promotionliststr);
                            $promotionid = $promotiontmp[1];
                            $promotion = new Core_Promotion($promotionid);
                            if($promotion->id > 0)
                            {
                                $promotion->status = Core_Promotion::STATUS_DISABLED;
                                $promotion->updateData();
                            }
                            //lấy tất cả các region để clear cache
                            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
                            if(!empty($listregion))
                            {
                                foreach($listregion as $ritem)
                                {
                                    $cachefile1 = $protocol.'sitehtml_productdetail'.$productDetail[0]->id.'_'.$ritem->id;
                                    $cachefile2 = $protocol.'sitehtml_homepage_'.$ritem->id;
                                    $removeCache1 = new Cacher($cachefile1);
                                    $removeCache1->clear();
                                    $removeCache2 = new Cacher($cachefile2);
                                    $removeCache2->clear();                              }
                            }
                            echo 1;
                        }
                    }
                }
            }
        }
    }


    public function updatestatusdoangiaAction()
    {
    	global $protocol;
    	$subdomain = '';
        $formData = array();
        $formData['fpid'] = $_POST['fpid'];
        $formData['fpcid'] = $_POST['fpcid'];
        $formData['fstatus'] = Core_Product::STATUS_ENABLE;
        $formData['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
        $productDetail = Core_Product::getProducts($formData,'','',1);
        if($productDetail[0]->id > 0)
        {
            if($productDetail[0]->onsitestatus == Core_Product::OS_DOANGIA)
            {
                $productguess = Core_ProductGuess::getProductGuesss(array('fstatus'=>Core_ProductGuess::STATUS_ENABLE,'fpid'=>$productDetail[0]->id),'id','DESC');
                if(!empty($productguess))
                {
                    $productupdate = new Core_Product($productDetail[0]->id);
                    if($productupdate->id > 0)
                    {
                        //$productupdate->onsitestatus = $productguess[0]->oldonsitestatus;
                        $productupdate->onsitestatus = Core_Product::OS_COMMINGSOON;
                        if($productupdate->updateData())
                        {
                        	$this->registry->me->writelog('productguess_auto_update_onsitestatus', $productDetail[0]->id, array());

                        	$cachefile = $protocol.$subdomain.'sitehtml_productdetail'.$productDetail[0]->id.'_'.$this->registry->region;
				            $removeCache = new Cacher($cachefile);
				            $removeCache->set('');
                            //lấy tất cả các region để clear cache
                            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
                            if(!empty($listregion))
                            {
                                foreach($listregion as $ritem)
                                {
                                    $cachefile1 = $protocol.$subdomain.'sitehtml_productdetail'.$productDetail[0]->id.'_'.$ritem->id;
                                    $cachefile2 = $protocol.'sitehtml_homepage_'.$ritem->id;
                                    $removeCache1 = new Cacher($cachefile1);
                                    $removeCache1->set('');
                                    $removeCache2 = new Cacher($cachefile2);
                                    $removeCache2->set('');                              }
                            }
                            echo 1;
                        }
                    }
                }
            }
        }
    }

	public function loadquestionAction(){
    	if(isset($_POST) && $_POST['action'] == 'loadquestion'){

    		$today = time();

    		$pagequestion = $_POST['page'];
    		$fpgid = $_POST['fpgid'];
			$totalquestion = Core_Productquestion::getProductquestions(array('fpgid' => $fpgid, 'fstatus'=>Core_Productquestion::STATUS_ENABLE, 'ftime'=> $today), 'displayorder', 'ASC', '', true);
	    	if($pagequestion <= $totalquestion){
		    	$question = Core_Productquestion::getProductquestions(array('fpgid' => $fpgid, 'fstatus'=>Core_Productquestion::STATUS_ENABLE, 'ftime'=> $today), 'displayorder', 'ASC');
		    	$limitStart = ($pagequestion - 1) * 1;
		    	$listquestion = array_slice( $question, $limitStart,1);
		    	$myQuestion = $listquestion[0];


		    	$html = '<strong>Câu hỏi ' . $pagequestion . '/' . $totalquestion . '</strong><span>' . $myQuestion->name . '</span>';

		    	if(!empty($myQuestion)){
		    		$myQuestion->answer = unserialize($myQuestion->answer);
		    		if ($myQuestion->type == Core_Productquestion::TYPE_RADIO){
				    	$i = 1;
				    	foreach ($myQuestion->answer as $itemquestion) {
				    		$correct = "false";
				    		if($i == $myQuestion->correct){
				    			$correct = "true";
				    		}
				    		$html .= '<label><input class="radio" id="answer_'.$i.'" name="itemanswer" type="radio" value="'. $correct .'">' . $itemquestion . '</label><div class="clear"></div>';
				    		$i++;
				    	}
				    	$html .= '<div class="btn-step"><a data-id="' . $fpgid . '" rel="' . $totalquestion . '" id="next" href="javascript:;">Tiếp tục »</a></div>';
				    	echo $html;
		    		}else{
		    			$html .= '<input id="answertext" class="p3input1" name="itemanswer" type="text"><label> người</label>';
		    			echo $html;
		    		}
		    	}else{

		    		echo $html = '<span>Xin vui lòng chờ trong giây lát. Nếu đợi lâu hãy nhấn F5 để tiếp tục.</span>
			<div class="clear"></div>';
		    	}
	    	}else{
	    		echo $html = '<span>Xin vui lòng chờ trong giây lát. Nếu đợi lâu hãy nhấn F5 để tiếp tục.</span>
			<div class="clear"></div>';
	    	}
    	}
    }

    public function nextquestionAction(){
    	if(isset($_POST) && $_POST['action'] == 'nextquestion'){

    		$today = time();

    		$pagequestion = $_POST['question'];
    		$fpgid = $_POST['fpgid'];
    		$totalquestion = $_POST['totalquestion'];
	    	if($pagequestion <= $totalquestion){
		    	$question = Core_Productquestion::getProductquestions(array('fpgid' => $fpgid, 'fstatus'=>Core_Productquestion::STATUS_ENABLE, 'ftime'=> $today), 'displayorder', 'ASC');
		    	$limitStart = ($pagequestion - 1) * 1;
		    	$listquestion = array_slice( $question, $limitStart,1);
		    	$myQuestion = $listquestion[0];


		    	$html = '<strong>Câu hỏi ' . $pagequestion . '/' . $totalquestion . '</strong><span>' . $myQuestion->name . '</span>';

		    	if(!empty($myQuestion)){
		    		$myQuestion->answer = unserialize($myQuestion->answer);
		    		if ($myQuestion->type == Core_Productquestion::TYPE_RADIO){
				    	$i = 1;
				    	foreach ($myQuestion->answer as $itemquestion) {
				    		$correct = "false";
				    		if($i == $myQuestion->correct){
				    			$correct = "true";
				    		}
				    		$html .= '<label><input class="radio" id="answer_'.$i.'" name="itemanswer" type="radio" value="'. $correct .'">' . $itemquestion . '</label><div class="clear"></div>';
				    		$i++;
				    	}
				    	$html .= '<div class="btn-step"><a data-id="' . $fpgid . '" rel="' . $totalquestion . '" id="next" href="javascript:;">Tiếp tục »</a></div>';
				    	echo $html;
		    		}else{
		    			$html .= '<input id="answertext" class="p3input1" name="itemanswer" type="text"><label> người</label>';
		    			echo $html;
		    		}
		    	}else{

		    		echo $html = '<span>Xin vui lòng chờ trong giây lát. Nếu đợi lâu hãy nhấn F5 để tiếp tục.</span>
			<div class="clear"></div>';
		    	}
	    	}else{
	    		$html = '<span>Xin vui lòng chờ trong giây lát. Nếu đợi lâu hãy nhấn F5 để tiếp tục.</span>
			<div class="clear"></div>';
	    	}
    	}
    }

    public function saveinfoguessAction(){
    	$resuft = array('error'=>-1, 'html'=> '');
    	$today = time();
    	if($today <= strtotime(date("Y-m-d 17:00:00"))){
    		$starttime = strtotime(date("Y-m-d 17:00:00", time() - 60 * 60 * 24));
    		$endtime = strtotime(date("Y-m-d 17:00:00"));
    	}else{
    		$starttime = strtotime(date("Y-m-d 17:00:00"));
    		$endtime = strtotime(date("Y-m-d 17:00:00", time() + 86400));
    	}
    	if(isset($_POST) && $_POST['action'] == 'saveinfoguess'){
    		//$fpid = $_POST['fpid'];
    		$fpgid = $_POST['fpgid'];
    		$ffullname = strip_tags($_POST['ffullname']);
    		$femail = strip_tags($_POST['femail']);
    		$fphone = strip_tags($_POST['fphone']);
    		$faddress = strip_tags($_POST['faddress']);
    		$fanswer = strip_tags($_POST['fanswer']);
    		$fnewsletterproduct = $_POST['fnewsletterproduct'];
    		$fnewsletter = $_POST['newsletter'];

    		$productguess = new Core_ProductGuess($fpgid);
    		$html= $productguess->blockhtml;


    		$checkexit = Core_ProductGuessUser::getProductGuessUsers(array('fpgid'=>$fpgid, 'fphone'=>$fphone, 'ftoday'=>1, 'fstarttime'=> $starttime, 'fendtime'=>$endtime), '', '');
	    		if(empty($checkexit)){
		    		$myProductGuessUser = new Core_ProductGuessUser();
		    		//$myProductGuessUser->pid = $fpid;
		    		$myProductGuessUser->pgid = $fpgid;
		    		$myProductGuessUser->fullname = $ffullname;
		    		$myProductGuessUser->email = $femail;
		    		$myProductGuessUser->phone = $fphone;
		    		$myProductGuessUser->address = $faddress;
		    		$myProductGuessUser->answer = $fanswer;
		    		$myProductGuessUser->newsletterproduct = $fnewsletterproduct;
		    		$myProductGuessUser->newsletter = $fnewsletter;

		    		if($myProductGuessUser->addData())
		    		{

		    			$resuft = array('error'=> 0, 'html'=> $html);
		    		}
	    		}else{
	    				$resuft = array('error'=> -2, 'html'=> $html);
	    		}

    	}
    	echo json_encode($resuft);
    }

    public function showformguessAction(){
    	global $protocol;
    	$subdomain = '';
    	$today = time();
    	if(isset($_POST) && $_POST['action'] == 'showformguess'){
    		$fpid = $_POST['fpid'];
    		$productGuess = Core_ProductGuess::getProductGuesss(array('fisactive'=>1,'fstatus'=>Core_ProductGuess::STATUS_ENABLE,'fpid'=>$fpid),'id','DESC');
    		$totalquestion = Core_Productquestion::getProductquestions(array('fpgid' => $productGuess[0]->id, 'fstatus'=>Core_Productquestion::STATUS_ENABLE, 'ftime'=> $today), 'displayorder', 'ASC', '', true);
    		$question = Core_Productquestion::getProductquestions(array('fpgid' => $productGuess[0]->id, 'fstatus'=>Core_Productquestion::STATUS_ENABLE, 'ftime'=> $today), 'displayorder', 'ASC');
    		$myQuestion = $question[0];
    		$myQuestion->answer = unserialize($myQuestion->answer);
    		$html = '';
    		if (!empty($myQuestion)){

    			$this->registry->smarty->assign(array(
	                'myQuestion'  =>  $myQuestion,
    				'productGuess'=> $productGuess[0],
    				'totalquestion'=> $totalquestion
	                ));

        		$html = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'formproductguess.tpl');
    		}

    		$cachefile = $protocol.$subdomain.'sitehtml_productdetail'.$fpid.'_'.$this->registry->region;
            $removeCache = new Cacher($cachefile);
            $removeCache->set('');

    		//lấy tất cả các region để clear cache
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
            if(!empty($listregion))
            {
                foreach($listregion as $ritem)
                {
                    $cachefile1 = $protocol.$subdomain.'sitehtml_productdetail'.$fpid.'_'.$ritem->id;
                    $removeCache1 = new Cacher($cachefile1);
                    $removeCache1->set('');
                }
            }

    		echo $html;
    	}
    }

    public function showpopupuserguesAction(){
    	$recordPerPage = 12;
    	$id = $this->registry->router->getArg('id');
    	$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

        if($id <= 0) {
            ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'];?>";</script><?php
        }
        //get block user chien thang
        $userwin = new Core_ProductGuess($id);

        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/showpopupusergues/id/'.$id.'';
		$total = Core_ProductGuessUser::getProductGuessUsers(array('fpgid'=> $id), 'id', 'DESC','', true);
        $totalPage = ceil($total/$recordPerPage);
        $curPage = $page;
        $myuserguess = Core_ProductGuessUser::getProductGuessUsers(array('fpgid'=> $id), 'id', 'DESC', ($page -1) * $recordPerPage . ',' . $recordPerPage);
		$listuser = array();
        foreach ($myuserguess as $userguess) {
        	$userguess->phone = substr_replace ($userguess->phone,'xxx',3,3);
        	$listuser[] = $userguess;
        }

        $myuserguess = $listuser;
        $this->registry->smarty->assign(
            array(
                'myuserguess' => $myuserguess,
            	'userwin'		=> $userwin,
	            'paginateurl' 	=> $paginateUrl,
		        'total'			=> $total,
		        'totalPage' 	=> $totalPage,
		        'curPage'		=> $curPage,
            )
        );
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'listuserproductguess.tpl');
        $this->registry->smarty->assign(
            array('contents' => $contents,
            )
        );
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_popup.tpl');

    }

	public function showrulepopupguesAction(){
    	$id = $this->registry->router->getArg('id');
        $myproductguess = new Core_ProductGuess($id);
        echo $myproductguess->rule;
    }

    public function showruleguessAction()
    {
        if( SUBDOMAIN != 'm')
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        if(!isset($_GET['pgid']))
        {
            header('location: ' . $this->registry->conf['rooturl']);
            exit();
        }
        $fpgid = $_GET['pgid'];
        $myproductguess = new Core_ProductGuess($fpgid);
        $this->registry->smarty->assign(
            array(
                'myproductguess' => $myproductguess,
            )
        );
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'theledoangia.tpl');

        $this->registry->smarty->assign(array('contents' => $contents));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

    }

    public function loaduserguessAction()
    {
    	if(isset($_POST) && $_POST['action'] == 'loaduserguess'){
    		 $fpgid = $_POST['fpgid'];
	    	 // get user choi doan gia
	         $totaluserguess =  Core_ProductGuessUser::getProductGuessUsers(array('fpgid' => $fpgid), 'id', 'DESC','', true);
	         $userguess = Core_ProductGuessUser::getProductGuessUsers(array('fpgid' => $fpgid), 'id', 'DESC', 3);
	         $html = '<li class="til">' . $totaluserguess . ' người dự đoán</li>';
	         foreach ($userguess as $user) {
	         	$html .= '<li>' . $user->fullname . '<span style="margin-left:0">dự đoán ' . Helper::time_ago($user->datecreated) . ' trước</span></li>';
	         }
	         $html .= '<li><a href="javascript:void(0)" onclick="showpopupuserguess(' . $fpgid . ')"> Xem tất cả ››</a></li>';

	         echo $html;
    	}
    }


    private function editInit($pcid, $vid = 0)
    {
        global $db;
        global $registry;
        $permission = false;
        //kiem tra xem user nay co trong nhom nguoi dc phep sua hay khong
        if(in_array($registry->me->groupid, $registry->setting['product']['allowEdit']))
        {
            if(!$registry->me->isGroup('administrator') && !$registry->me->isGroup('developer'))
            {
                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($pcid);

                //create suffix
                $suffix = 'pedit_' . $parentcategorylist[0];
                $permission = $this->checkAccessTicket($suffix ,true);
            }
            else
            {
                $permission = true;
            }
        }

        return $permission;
    }

	public function checkstorestockAction()
	{
		$time = new Timer();
		$time->start();
		$pid = (int)(isset($_GET['fpid'])?$_GET['fpid'] :0);
		if ($pid == 0) $pid = (int)(isset($_POST['fpid'])?$_POST['fpid'] :0);
		$arrreturn = array();
		if ($pid > 0)
		{
			$myCacher = new Cacher('sitehtml_sieuthiconhang_'.$pid, Cacher::STORAGE_MEMCACHED);
            $getcacher = array();
			if (!isset($_GET['live'])) $getcacher = $myCacher->get();
			if (empty($getcacher))
			{
				$myProduct = new Core_Product($pid, true);
				if ($myProduct->id > 0 && ($myProduct->status == Core_Product::STATUS_ENABLE || $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR))
				{
					$liststores = Core_ProductStock::getStoreStockFromErpByProduct(trim($myProduct->barcode));
					if (!empty($liststores))
					{
						//$listregions = array();
						$sarrreturn = array();
						foreach ($liststores['stores'] as $store)
						{
							$sarrreturn[] = array(
													'name' => $store->name,
													'slug' => $store->slug,
													'lat' => $store->lat,
													'lng' => $store->lng,
													//'region' => $store->region,
													'storeaddress' => $store->storeaddress,
												);
						}
						if (!empty($sarrreturn))
						{
							$arrreturn = array('stores' => $sarrreturn, 'instock' => $liststores['quantity']);
							$myCacher->set(json_encode($arrreturn), 60);//giay
						}
					}
				}
			}
			else
			{
				$arrreturn = json_decode($getcacher, true);
			}
		}
        if (!empty($arrreturn['stores']))
        {
            $this->registry->smarty->assign(array(
                'registry' => $this->registry,
                'havestorestock' => $arrreturn['stores']
            ));
            $htmlreturn = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'productstorestock.tpl');
            echo json_encode(array('instock' => $arrreturn['instock'], 'html' => $htmlreturn));
        }
        else echo json_encode(array('instock' => 0, 'html' => ''));
		//
		//echodebug($arrreturn);
		//$time->stop();
		//echo $time->get_exec_time();
	}
     //Load so luong nguoi dat hang truoc ajax
    public function loaduserprepaidajaxAction()
    {
        $pid = $_POST['pid'];
        $productDetail = new Core_Product($pid);
        $numberreorder = array();
        if($productDetail->id > 0 && $productDetail->onsitestatus == Core_Product::OS_ERP_PREPAID && $productDetail->prepaidstartdate <= time() && $productDetail->prepaidenddate >= time())
        {
            //38 la ma chuong trinh dat hang truoc
            $counterorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($productDetail->prepaidstartdate, $productDetail->prepaidenddate )),'','', '', true);//,'isgroupbyuser' => 1
            if (count($counterorders) > 0)
            {
                $counterpreorders = 0;
                for ($cntorder = 0; $cntorder <= $counterorders; $cntorder +=50)
                {
                    $listmyorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($productDetail->prepaidstartdate, $productDetail->prepaidenddate )),'','', $cntorder.',50');//,'isgroupbyuser' => 1
                    if(!empty($listmyorders)){
                        $listordersid = array();
                        $listusername = array();
                        foreach($listmyorders as $od){
                            $listordersid[] = $od->id;
                            $listusername[$od->id] = $od->billingfullname;
                            $listdatecreate[$od->id] = $od->datecreated;
                        }
                        if(!empty($listordersid)){
                            //$counterpreorders += Core_Orders::getOrderss(array('fpromotionid' => 38, 'fidarr' => $listordersid, 'forderbytimesegment' => array($productDetail[0]->prepaidstartdate, $productDetail[0]->prepaidenddate )),'','', '', true);//, 'isgroupbyorder' => 1
                            $prepaidorderdetail = Core_OrdersDetail::getOrdersDetails(array('foidarr' => $listordersid, 'fpid' => $productDetail->id),'oid','DESC');
                            if(!empty($prepaidorderdetail)){
                                foreach($prepaidorderdetail as $odd){
                                    if(!empty($listusername[$odd->oid]))
                                    {
                                        $counterbreak++;
                                        $counterpreorders++;
                                    }
                                }
                            }
                        }
                    }
                }
                $numberreorder['numberorder'] = $counterpreorders;
                if ($productDetail->prepaidrand > 0 && $productDetail->prepaidrand > $counterpreorders) {
                    $numberreorder['amountremain'] = $productDetail->prepaidrand - $counterpreorders;
                }
            }

        }
        echo json_encode($numberreorder);
    }
}

function sortpricesegmentasc($p1, $p2)
{
    if ($p1->finalprice > $p2->finalprice) return 1;
    elseif($p1->finalprice < $p2->finalprice) return -1;
    else return 0;
}

function sortpricesegmentdesc($p1, $p2)
{
    if ($p1->finalprice > $p2->finalprice) return -1;
    elseif($p1->finalprice < $p2->finalprice) return 1;
    else return 0;
}

function sortdatedesc($p1, $p2)
{
    if ($p1->datecreated > $p2->datecreated) return -1;
    elseif($p1->datecreated < $p2->datecreated) return 1;
    else return 0;
}

function sortinterested($p1, $p2)
{
    if ($p1->countview > $p2->countview) return -1;
    elseif($p1->countview < $p2->countview) return 1;
    else return 0;
}

function sortcategorydesc($p1, $p2)
{
    if ($p1->parentcurrent > $p2->parentcurrent) return -1;
    elseif($p1->parentcurrent < $p2->parentcurrent) return 1;
    else return 0;
}

function sortproductmanualdesc($p1, $p2)
{
    if ($p1->displaymanual > $p2->displaymanual) return -1;
    elseif($p1->displaymanual < $p2->displaymanual) return 1;
    else return 0;
}

function sortproductmanualasc($p1, $p2)
{
    if ($p1->displaymanual > $p2->displaymanual) return 1;
    elseif($p1->displaymanual < $p2->displaymanual) return -1;
    else return 0;
}


