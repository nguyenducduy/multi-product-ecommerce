<?php
class Controller_Connection_Apipartner extends Controller_Connection_Base
{
    public function indexAction()
    {

    }

    public function getproductlistAction()
    {
        $data = array();
        $partnerinfo = null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $recordPerPage = 100;
        /*if(!isset($_GET['recordperpage']) || (int)$_GET['recordperpage'] > 100)
            $recordPerPage = 100;
        else
            $recordPerPage = (int)$_GET['recordperpage'];*/

        $sortby = 'id';
        $sorttype = 'DESC';

        $timer = new Timer();
        $timer->start();

        if($this->checkValidPartner($partnerinfo))
        {
            //total record
            $total = Core_Backend_ApiPartnerSale::getApiPartnerSales(array('fapid' => $partnerinfo->id), $sortby, $sorttype, '' , true);
            $totalPage = ceil($total / $recordPerPage);
            $curPage = $page;

            ///ASSIGN JSON
            $data['total'] = (int)$total;
            $data['totalPage'] = (int)$totalPage;
            $data['curPage'] = (int)$curPage;


            ////GET PARTNER SALE INFO
            $apipartnersaleList = Core_Backend_ApiPartnerSale::getApiPartnerSales(array('fapid' => $partnerinfo->id), $sortby, $sorttype, (($page - 1) * $recordPerPage) . ','  . $recordPerPage);
            if(count($apipartnersaleList) > 0)
            {
                $dataList = array();
                foreach($apipartnersaleList as $apipartnersale)
                {
                    ////GET PRODUCT INFO
                    $myProduct = new Core_Product($apipartnersale->pid , true);

                    $parentbarcode = '';

                    ////GET PRODUCT COLOR NAME
                    $colorname = '';
                    $colorcode = '';
                    if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN)
                    {
                        if(!empty($myProduct->colorlist))
                        {
                            $colorlist = explode('###' , $myProduct->colorlist);
                            $colordata = explode(':' , $colorlist[0]);

                            $colorname = $colordata[2];
                            $colorcode = $colordata[3];

                        }
                    }
                    elseif($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
                    {
                        $relproductproductlist = Core_RelProductProduct::getRelProductProducts(array('fpiddestination' => $myProduct->id , 'ftype'=>  Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC' , '0,1');
                        $relproductproduct = $relproductproductlist[0];
                        $colordata = explode(':', $relproductproduct->typevalue);
                        $colorname = $colordata[0];
                        $colorcode = $colordata[1];

                        $productSource = new Core_Product($relproductproduct->pidsource , true);
                        $parentbarcode = $productSource->barcode;
                    }

                    /////GET CATEGORY NAME
                    $myProductcategory = new Core_Productcategory($myProduct->pcid);

                    ////CACULATE INSTOCK IN TPHCM
                    $instock = 0;
                    $storeidList = array();
                    $storeList = Core_Store::getStores(array('fhoststoreid' => 0 ,
                                                            'fissalestore' => 1,
                                                            'fisinputstore' => 1,
                                                            'fprovinceid' => 3,
                                                            'fisautostorechange' => 1,
                                                        ), 'id', 'ASC');
                    if(count($storeList) > 0)
                    {
                        foreach($storeList as $store)
                        {
                            $storeidList[] = $store->id;
                        }
                    }

                    $instock = Core_ProductStock::getProductIntockByStore($storeidList , $myProduct->barcode);

                    $data['dataitem'][] = array('barcode' => $myProduct->barcode,
                                                'parentbarcode' => $parentbarcode,
                                                 'name' => $myProduct->name,
                                                 'category' => $myProductcategory->name,
                                                 'colorname' => $colorname,
                                                 'colorcode' => $colorcode,
                                                 'instock' => (int)$instock,
                                                 'sellprice' => (float)$myProduct->sellprice,
                                                 'finalprice' => (float)$myProduct->finalprice,
                                                 'discount' => (int)$apipartnersale->discountvalue,
                                                 'dateupdated' => (int)$myProduct->datemodified,
                                                );
                }
            }
            $timer->stop();

            //tracking partber
            $myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest();
            $myApiPartnerSaleRequest->apid = $partnerinfo->id;
            $myApiPartnerSaleRequest->parameter = $_SERVER['QUERY_STRING'];
            $myApiPartnerSaleRequest->executetime = $timer->get_exec_time();
            $myApiPartnerSaleRequest->record = $recordPerPage;
            $myApiPartnerSaleRequest->ipaddress = Helper::getIpAddress(true);

            if($myApiPartnerSaleRequest->addData() > 0)
            {
                $success[] = $this->registry->lang['controller']['succAdd'];
                $this->registry->me->writelog('apipartnersalerequest_add', $myApiPartnerSaleRequest->id, array());
                $formData = array();
            }
            else
            {
                $error[] = $this->registry->lang['controller']['errAdd'];
            }
        }
        else
        {
            $data[] = 'Authentication failed.';
        }


        echo json_encode($data);
    }

    public function getproductdetailAction()
    {
        $data = array();
        $partnerinfo = null;

        $barcode = Helper::xss_clean((string)$_GET['barcode']);

        $timer = new Timer();

        $timer->start();

        $productinfo = Core_Product::getProductIDByBarcode($barcode);
        $myProduct = new Core_Product($productinfo['p_id'] , true);

        if($myProduct->id > 0)
        {
            /////CHECK PRODUCT CUSTOMIZE TYPE
            if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                $relproductproductlist = Core_RelProductProduct::getRelProductProducts(array('fpiddestination' => $productinfo['p_id'] , 'ftype'=>  Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC' , '0,1');
                $relproductproduct = $relproductproductlist[0];

                $myProductMain = new Core_product($relproductproduct->pidsource , true);
            }

            if($this->checkValidPartner($partnerinfo) && $myProduct->id > 0)
            {
                $data['barcode'] = (string)$myProduct->barcode;
                $data['name'] = (string)$myProduct->name;
                $data['productlink'] =(string)$myProduct->getProductPath();

                $myProductcategory = new Core_Productcategory($myProduct->pcid , true);
                $data['category'] = (string)$myProductcategory->name;
                $data['appendtoproductname'] = (int)$myProductcategory->appendtoproductname;

                $myVendor = new Core_Vendor($myProduct->vid , true);
                $data['vendor'] = $myVendor->name;

                $data['keysellingpoint'] = (!empty($myProductMain->summarynew) ? explode('#', $myProductMain->summarynew) : array());

                ///GET PRODUCT COLOR
                if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN)
                {
                    if(!empty($myProduct->colorlist))
                    {
                        $colorlist = explode('###' , $myProduct->colorlist);
                        $colordata = explode(':' , $colorlist[0]);

                        $data['colorname'] = (string)$colordata[2];
                        $data['colorcode'] = trim((string)$colordata[3]);

                    }
                }
                elseif($myProduct->customizetype  == Core_Product::CUSTOMIZETYPE_COLOR)
                {
                    $relproductproductlist = Core_RelProductProduct::getRelProductProducts(array('fpiddestination' => $productinfo['p_id'] , 'ftype'=>  Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC' , '0,1');
                    $relproductproduct = $relproductproductlist[0];
                    $colordata = explode(':', $relproductproduct->typevalue);
                    $data['colorname'] = (string)$colordata[0];
                    $data['colorcode']  = trim((string)$colordata[1]);
                }

                $data['sellprice'] = (float)$myProduct->sellprice;
                $data['finalprice'] = (float)$myProduct->finalprice;


                ////CACULATE INSTOCK IN TPHCM
                $instock = 0;
                $storeidList = array();
                $storeList = Core_Store::getStores(array('fhoststoreid' => 0 ,
                                                        'fissalestore' => 1,
                                                        'fisinputstore' => 1,
                                                        'fprovinceid' => 3,
                                                        'fisautostorechange' => 1,
                                                    ), 'id', 'ASC');
                if(count($storeList) > 0)
                {
                    foreach($storeList as $store)
                    {
                        $storeidList[] = $store->id;
                    }
                }

                $instock = Core_ProductStock::getProductIntockByStore($storeidList , $myProduct->barcode);
                $data['instock'] = (int)$instock;

                ///GET PROMOTION INFO
                $promotioninfoList = Core_Promotion::getPromotionNameByProductID($myProduct->barcode);


                if($promotioninfoList !== false)
                {
                    foreach ($promotioninfoList as $promotion)
                    {
                        /*if(!empty($promotion->descriptionclone))
                        {
                            $data['promotionitem'][$promotion->name] = $promotion->descriptionclone;
                        }
                        elseif($promotion->description !== '.' && !empty($promotion->description))
                        {
                            $data['promotionitem'][$promotion->name] = $promotion->description;
                        }*/
                        if($promotion->description !== '.' && !empty($promotion->description)) {
                            $data['promotionitem'][$promotion->name] = $promotion->description;
                        }

                    }
                }
                else
                {
                    $data['promotionitem'] = array();
                }

                $data['productimage'] = isset($myProductMain) ? $myProductMain->getImage() : $myProduct->getImage();

                ////GET PRODUCT GALLERY
                $productmediaList = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_FILE , 'fpid' => $myProduct->id) , 'id' , 'ASC');
                if(count($productmediaList) > 0)
                {
                    foreach ($productmediaList as $productmedia)
                    {
                        $data['galleryitem'][] = $productmedia->getImage();
                    }
                }
                else
                {
                    $data['galleryitem'] = array();
                }

                $data['content'] = isset($myProductMain) ? $myProductMain->content : $myProduct->content;

                $discountvalue = Core_Backend_ApiPartnerSale::getDiscountValueByBarcode(array('apid' => $partnerinfo->id , 'barcode' => $myProduct->barcode));

                ///GET PRODUCT GROUP ATTRIBUTE
                $data['groupattributeitem'] = array();
                $productGroupAttributeList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $myProduct->pcid , 'fstatus' => Core_ProductGroupAttribute::STATUS_ENABLE) , 'displayorder' , 'ASC');

                if(count($productGroupAttributeList) > 0)
                {
                    foreach ($productGroupAttributeList as $pga) {
                        $data['groupattributeitem'][$pga->name] = array();
                        ///GET PRODUCT ATTRIBUTE
                        $productAttributeList = Core_ProductAttribute::getProductAttributes(array('fpcid' => $myProduct->pcid , 'fpgaid' => $pga->id , 'fstatus' => Core_ProductAttribute::STATUS_ENABLE) , 'displayorder' , 'ASC');
                        if(count($productAttributeList) > 0)
                        {
                            foreach ($productAttributeList as $pa) {
                                //get data of attribute
                                if(isset($myProductMain)) {
                                    $productattributedata = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $myProductMain->id , 'fpaid' => $pa->id) , 'id' , 'ASC' , '0,1');
                                }else{
                                    $productattributedata = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $myProduct->id , 'fpaid' => $pa->id) , 'id' , 'ASC' , '0,1');
                                }

                                if(count($productattributedata) > 0) {
                                    $dataattribute = $productattributedata[0];
                                    $data['groupattributeitem'][$pga->name][$pa->name] = $dataattribute->value . (!empty($pa->unit) ? $pa->unit : '');
                                }
                            }
                        }
                    }
                }

                $data['discount'] = (float)$discountvalue;
                $data['status'] = $myProduct->status;

                $timer->stop();

                //tracking partber
                $myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest();
                $myApiPartnerSaleRequest->apid = $partnerinfo->id;
                $myApiPartnerSaleRequest->parameter = $_SERVER['QUERY_STRING'];
                $myApiPartnerSaleRequest->executetime = $timer->get_exec_time();
                $myApiPartnerSaleRequest->record = 1;
                $myApiPartnerSaleRequest->ipaddress = Helper::getIpAddress(true);

                if($myApiPartnerSaleRequest->addData() > 0)
                {
                    $success[] = $this->registry->lang['controller']['succAdd'];
                    $this->registry->me->writelog('apipartnersalerequest_add', $myApiPartnerSaleRequest->id, array());
                    $formData = array();
                }
                else
                {
                    $error[] = $this->registry->lang['controller']['errAdd'];
                }

            }
            else
            {
                $data[] = 'Authentication failed.';
            }
        }
        else
        {
            $data[] = 'Product not exist';
        }

        echo json_encode($data);
    }

    private function checkValidPartner(&$partnerinfo)
    {
        $pass = true;

        $key = Helper::xss_clean((string)$_GET['key']);
        $secret = Helper::xss_clean((string)$_GET['secret']);

        if(empty($key) || empty($secret))
        {
            $pass = false;
        }
        else
        {
            $partnerinfo = Core_Backend_ApiPartner::getPartnerInfo(array('key' => $key , 'secret' =>$secret));
            if($partnerinfo->id == 0)
            {
                $pass = false;
            }
        }


        return $pass;
    }
}
