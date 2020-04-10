<?php

Class Controller_Site_Cart Extends Controller_Site_Base
{
    const CRM_PROGRAMEID = 34;//mã chương trình giá rẻ được phát sinh từ CRM
    const REGION_HCM = 3;// khuyen mai lay o thanh pho hcm
    function indexAction()
    {
        $formData = $error = $success = array();
        //addtocart
        if(!empty($_GET['id']))
        {
            $promotionid = '';
            $pbarcode = '';
            if(!empty($_GET['prid']))
            {
                $explode = explode('_',$_GET['prid']);
                if(!empty($explode[1])) $promotionid = $explode[1];
                if(!empty($explode[0])) $pbarcode = trim($explode[0]);
            }
            //$promotionid = !empty($_GET['prid'])?$_GET['prid']:'';
            $myProduct = new Core_Product($_GET['id'], true);
            $myProduct->barcode = trim($myProduct->barcode);
            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, self::REGION_HCM);
            if($finalprice > 0)
            {
                $myProduct->sellprice = $finalprice;
            }
            //echodebug($myProduct);
            //Kiem tra xem book nay co thuc su dang ban tren Reader khong, cai nay quan trong boi co the add BookID bay ba
            if($myProduct->id > 0 && $myProduct->sellprice > 0 && $myProduct->onsitestatus > 0 && $myProduct->instock > 0 && $myProduct->status == Core_Product::STATUS_ENABLE)// && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
            {
                if(!empty($promotionid) && $pbarcode == $myProduct->barcode)
                {
                    $promotioninfo = Core_Promotion::getOnePromotionbyID($promotionid, self::REGION_HCM, trim($myProduct->barcode));
                    if(empty($promotioninfo))
                    {
                        $error[] = $this->registry->lang['controller']['cartpromotioninvalid'];
                    }
                }
                if(empty($error) && $this->addtocartValidate($formData, $error))
                {
                    $quantity = 1; //chưa kiểm tra trường hợp quantity lớn hơn instock
                    $options = array('promotionid' => $promotionid, 'regionid' => self::REGION_HCM);
                    $this->registry->cart->addItem($myProduct->id, $quantity, $options);
                    $this->registry->cart->saveToSession();
                    $success[] = $this->registry->lang['controller']['succAddToCart'];
                    $_SESSION['addtocartSpam'] = time();
                }
            }
            else
                $error[] = $this->registry->lang['controller']['errProductSellNotFound'];
            //chua kiem tra gio hang o day
        }

        //update cart item quantity
        if(isset($_POST['fsubmitupdate']))
        {
            $formData = $_POST;

            //clear current cart
            $this->registry->cart->emptyCart();
            foreach($formData['fquantity'] as $id => $quantity)
            {
                if($quantity > 0)
                    $this->registry->cart->addItem($id, (int)$quantity);
            }
            $this->registry->cart->saveToSession();
            $success[] = $this->registry->lang['controller']['succUpdate'];
        }

        //delete an item from cart or clear cart
        if(isset($_GET['deleteid']))
        {
            if($_GET['deleteid'] > 0)
            {
                $this->registry->cart->delItem($_GET['deleteid']);
                $this->registry->cart->saveToSession();
                $success[] = $this->registry->lang['controller']['succDeleteItem'];
            }
            else
            {
                $this->registry->cart->emptyCart();
                $this->registry->cart->saveToSession();
                $success[] = $this->registry->lang['controller']['succClearCart'];
            }
            //header('Location: '.$this->registry->conf['rooturl'].'cart/checkout');
        }
        $formData['fregion'] = self::REGION_HCM;
        if(isset($_POST['btncheckout']))
        {
            $formData = $_POST;
            if($this->checkValidatePaymentForm($formData, $error, false))
            {
                $invoicedid = $this->addToOrder($formData);
                if(!empty($invoicedid))
                {
                    $this->registry->cart->emptyCart();
                    $this->registry->cart->saveToSession();
                    ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/success?o='.$invoicedid;?>";</script><?php
                }
                else {
                    ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/fail';?>";</script><?php
                }
            }
        }
        else{

            if($this->registry->me->id > 0)
            {
                $formData['fgender'] = ($this->registry->me->gender == Core_User::GENDER_MALE? 1: 0);
                $formData['femail'] = $this->registry->me->email;
                $formData['ffullname'] = $this->registry->me->fullname;
                $formData['fphonenumber'] = $this->registry->me->phone;
                $formData['faddress'] = $this->registry->me->address;
            }
        }

        //get the cart Item
        //$cartItemCount = $this->registry->cart->itemCount();

        $cartpricetotal = 0;
        $this->cartfirstpricetotal = 0;
        $this->cartItems = $this->registry->cart->getContents();
        $numberofcarts = count($this->cartItems);

        if($numberofcarts <= 0)
        {
            $error[] = 'Không có sản phẩm nào cho giỏ hàng của bạn';
        }

        $listproductid = array();
        if(!empty($this->cartItems))
        {
            //Kieemr tra coi ton kho da het

            for($i = 0; $i < $numberofcarts; $i++)
            {
                $this->cartItems[$i]->product = new Core_Product($this->cartItems[$i]->id, true);
                if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice > 0 && $this->cartItems[$i]->product->instock > 0 && $this->cartItems[$i]->product->onsitestatus > 0 && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)// && $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
                {
                    $listproductid[] = $this->cartItems[$i]->product->id;
                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($this->cartItems[$i]->product->barcode, self::REGION_HCM);
                    if($finalprice > 0)
                    {
                        $this->cartItems[$i]->product->sellprice = $finalprice;
                    }
                    $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);
                    $sellprice = 0;
                    if(!empty($this->cartItems[$i]->options['promotionid']))
                    {
                        $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], self::REGION_HCM, $this->cartItems[$i]->product->barcode);
                        if(!empty($promotioninfo['promotiongroup']))
                        {
                            foreach($promotioninfo['promotiongroup'] as $pg)
                            {
                                if((int)$pg->discountvalue > 0)
                                {
                                    if($pg->isdiscountpercent == 1) {
                                        $sellprice = round($this->cartItems[$i]->product->sellprice - ((double)$this->cartItems[$i]->product->sellprice*(double)$pg->discountvalue/100));
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
                    if($sellprice > 0)
                    {
                        $this->cartItems[$i]->pricesell = $sellprice;
                    }
                    else {
                        $this->cartItems[$i]->pricesell = $this->cartItems[$i]->product->sellprice;
                    }
                    $this->cartItems[$i]->subtotal = $this->cartItems[$i]->quantity * $this->cartItems[$i]->pricesell;

                    $cartpricetotal += $this->cartItems[$i]->subtotal;
                }
            }
        }
        $deliverMethod = Core_Orders::getOrderDeliveryMethod();
        $relProductCart = null;
        if(!empty($listproductid))
        {
            $relProductCart = $this->getRelProductCart($listproductid);
        }
        $this->registry->smarty->assign(array(  'success' => $success,
                                                'error'    => $error,
                                                'formData'    => $formData,
                                                'isPopup' => $isPopup,
                                                'orderDelivery' => $deliverMethod,
                                                'cartItems'           => $this->cartItems,
                                                'cartpricetotal' => $cartpricetotal,
                                                'relProductCart' => $relProductCart,
                                                'cartItemCount' => $cartItemCount,

                                            ));
        $tplshow = 'popupmuanhanh.tpl';
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$tplshow);

        $this->registry->smarty->assign(array('contents' => $contents,
                                               'pageTitle' => $this->registry->lang['controller']['muanhanh'],
                                            ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');  //smartyControllerContainerRoot
    }

    function checkoutAction()
    {
        $formData = $error = $success = array();

        $pageCanonical = $this->registry->conf['rooturl'].'cart/checkout';
        //addtocart
        if(!empty($_GET['id']))
        {
            $promotionid = '';
            $pbarcode = '';
            if(!empty($_GET['prid']))
            {
                $explode = explode('_',$_GET['prid']);
                if(!empty($explode[1])) $promotionid = $explode[1];
                if(!empty($explode[0])) $pbarcode = trim($explode[0]);
            }
            //$promotionid = !empty($_GET['prid'])?$_GET['prid']:'';
            $myProduct = new Core_Product($_GET['id'], true);
            $myProduct->barcode = trim($myProduct->barcode);
            $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, self::REGION_HCM);
            if($finalprice > 0)
            {
                $myProduct->sellprice = $finalprice;
            }
            if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                $productMain = Core_Product::getMainProductFromColor($myProduct->id);
                if(!empty($productMain))
                {
                    //$productDetail->displaysellprice = $productMain->displaysellprice;
                    $myProduct->status           = $productMain->status;
                }
            }
            //Kiem tra xem book nay co thuc su dang ban tren Reader khong, cai nay quan trong boi co the add BookID bay ba
            if($myProduct->id > 0 && $myProduct->sellprice > 0 && $myProduct->onsitestatus > 0 && $myProduct->instock > 0 && $myProduct->status == Core_Product::STATUS_ENABLE)// && ($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN || $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                if (!empty($myProduct->slug)) $pageCanonical = $this->registry->conf['rooturl'].'cart/mua-'.$myProduct->slug;
                if(!empty($promotionid) && $pbarcode == trim($myProduct->barcode))
                {
                    $promotioninfo = Core_Promotion::getOnePromotionbyID($promotionid, self::REGION_HCM, trim($myProduct->barcode));
                    //echodebug($promotionid);
                    if(empty($promotioninfo))
                    {
                        $error[] = $this->registry->lang['controller']['cartpromotioninvalid'];
                    }
                }
                if(empty($error) && $this->addtocartValidate($formData, $error))
                {
                    $quantity = 1;
                    $options = array('promotionid' => $promotionid, 'regionid' => self::REGION_HCM);

                    $getCurrentQuantityCart = $this->registry->cart->getCurrentQuantity($myProduct->id, $options);
                    if ($getCurrentQuantityCart < 5)
                    {
                        $this->registry->cart->addItem($myProduct->id, $quantity, $options);

                        if (!empty($_GET['more']))
                        {
                            $moreid = explode(',', Helper::plaintext($_GET['more']));
                            if (!empty($moreid))
                            {
                                foreach ($moreid as $mid)
                                {
                                    if (!empty($mid) && is_numeric($mid))
                                    {
                                        $mProduct = new Core_Product($mid, true);
                                        if ($mProduct->id > 0 && $mProduct->sellprice > 0 && $mProduct->onsitestatus > 0 && $mProduct->instock > 0 && $mProduct->status == Core_Product::STATUS_ENABLE)//$mProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&
                                        {
                                            $promotion = $mProduct->promotionPrice();
                                            $options = array('regionid' => self::REGION_HCM);
                                            if (!empty($promotion) && !empty($promotion['promoid']))
                                            {
                                                $options['promotionid'] = $promotion['promoid'];
                                            }
                                            $this->registry->cart->addItem($mProduct->id, 1, $options);
                                        }
                                    }
                                }
                            }
                        }
                        $this->registry->cart->saveToSession();

                        $success[] = $this->registry->lang['controller']['succAddToCart'];
                        $_SESSION['addtocartSpam'] = time();
                    }
                    else $error[] = 'Số lượng mua không lớn hơn 5 sản phẩm';
                }

                /*Kiểm tra nếu đây là Mã Chương Trình KM của CRM*/
                if (!empty($_GET['po']))
                {
                    $programeorderid = substr((string)$_GET['po'], 6);
                    if ( $programeorderid > 0)
                    {
                        $_SESSION['sesPromotionidfromCRM'] = $programeorderid;
                    }
                }
            }
            else
                $error[] = $this->registry->lang['controller']['errProductSellNotFound'];
            //chua kiem tra gio hang o day
        }

        //update cart item quantity
        if(isset($_POST['fsubmitupdate']))
        {
            $formData = $_POST;

            //clear current cart
            $this->registry->cart->emptyCart();
            foreach($formData['fquantity'] as $id => $quantity)
            {
                if($quantity > 0)
                    $this->registry->cart->addItem($id, (int)$quantity);
            }
            $this->registry->cart->saveToSession();
            $success[] = $this->registry->lang['controller']['succUpdate'];
        }

        //delete an item from cart or clear cart
        if(isset($_GET['deleteid']))
        {
            if($_GET['deleteid'] > 0)
            {
                $this->registry->cart->delItem($_GET['deleteid']);
                $this->registry->cart->saveToSession();
                $success[] = $this->registry->lang['controller']['succDeleteItem'];
            }
            else
            {
                $this->registry->cart->emptyCart();
                $this->registry->cart->saveToSession();
                $success[] = $this->registry->lang['controller']['succClearCart'];
            }
            header('Location: '.$this->registry->conf['rooturl'].'cart/checkout');
        }
        $formData['fregion'] = self::REGION_HCM;
        if(isset($_POST['btncheckout']))
        {
            $formData = $_POST;

            if($this->checkValidatePaymentForm($formData, $error))
            {
                $invoicedid = $this->addToOrder($formData);
                if(!empty($invoicedid))
                {
                    //$success[] = cartsuccess;
                    $this->registry->cart->emptyCart();
                    $this->registry->cart->saveToSession();
                    if (SUBDOMAIN == 'm') {
                        $productid = 0;
                        if ($_SESSION['isgift'] > 0) {
                            $productid = $_SESSION['isgift'];
                            unset($_SESSION['isgift']);
                        }
                    }
                    //header('Location: '.$this->registry->conf['rooturl'].'cart/success');
                    if ($productid > 0) {
                        header('Location: '.$this->registry->conf['rooturl'].'cart/success?o='.$invoicedid.'&p='.$productid);
                    }
                    else {
                        header('Location: '.$this->registry->conf['rooturl'].'cart/success?o='.$invoicedid);
                    }
                    exit();
                }
                else {
                    header('Location: '.$this->registry->conf['rooturl'].'cart/fail');
                    exit();
                }
            }
        }
        else{

            if($this->registry->me->id > 0)
            {
                $formData['fgender'] = ($this->registry->me->gender == Core_User::GENDER_MALE? 1: 0);
                $formData['femail'] = $this->registry->me->email;
                $formData['ffullname'] = $this->registry->me->fullname;
                $formData['fphonenumber'] = $this->registry->me->phone;
                $formData['faddress'] = $this->registry->me->address;
                if(SUBDOMAIN == 'm')
                {
                    $district = new Core_Region($this->registry->me->district);
                    if($district > 0)
                    {
                        $formData['fdistrict'] = $district->name;
                    }
                    $formData['fcity'] = $this->registry->me->city;
                }

            }
        }

        $cartpricetotal = 0;
        $this->cartfirstpricetotal = 0;
        $this->cartItems = $this->registry->cart->getContents();
        $listproductsid = array();
        //get the cart Item
        $cartItemCount = count($this->cartItems);//$this->registry->cart->itemCount();
        /*if($cartItemCount == 0)
        {
            header('Location: '.$this->registry->conf['rooturl']);
        }*/
        if(!empty($this->cartItems))
        {
            //Kieemr tra coi ton kho da het
            for($i = 0; $i < $cartItemCount; $i++)
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
                if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice > 0 && $this->cartItems[$i]->product->onsitestatus > 0 && $this->cartItems[$i]->product->instock > 0 && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)//($this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN || $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR ) &&
                {
                    $listproductid[] = $this->cartItems[$i]->product->id;
                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($this->cartItems[$i]->product->barcode, self::REGION_HCM);
                    if($finalprice > 0)
                    {
                        $this->cartItems[$i]->product->sellprice = $finalprice;
                    }
                    $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);
                    $sellprice = 0;//$this->cartItems[$i]->product->sellprice;
                    if(!empty($this->cartItems[$i]->options['promotionid']))
                    {
                        $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], self::REGION_HCM, $this->cartItems[$i]->product->barcode);
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
                    if($sellprice > 0)
                    {
                        $this->cartItems[$i]->pricesell = $sellprice;
                    }
                    else {
                        $this->cartItems[$i]->pricesell = $this->cartItems[$i]->product->sellprice;
                    }
                    $this->cartItems[$i]->subtotal = $this->cartItems[$i]->quantity * $this->cartItems[$i]->pricesell;

                    $cartpricetotal += $this->cartItems[$i]->subtotal;
                    $formData['cartpricetotal'] = $cartpricetotal;
                    $listproductsid[] = $this->cartItems[$i]->product->id;
                }
            }

        }
        $deliverMethod = Core_Orders::getOrderDeliveryMethod();
        $paymentMethod = Core_Orders::getOrderPaymentMethod();

        //Lay phu kien di kem cua san pham
        $listrelproductproducts = array();
        if (!empty($listproductsid))
        {
            $listrelsourcedes = Core_RelProductProduct::getRelProductProducts(array('fpiddestinationarr' => $listproductsid, 'fpidsourcearr' => $listproductsid, 'ftype' => Core_RelProductProduct::TYPE_ACCESSORIES), '', '', 6);
            if (!empty($listrelsourcedes))
            {
                $listproductdescsource = array();
                foreach ($listrelsourcedes as $relproduct)
                {
                    if (!in_array($relproduct->pidsource, $listproductdescsource) && !in_array($relproduct->pidsource, $listproductsid))
                    {
                        $listproductdescsource[] = $relproduct->pidsource;
                    }
                    if (!in_array($relproduct->piddestination, $listproductdescsource) && !in_array($relproduct->piddestination, $listproductsid))
                    {
                        $listproductdescsource[] = $relproduct->piddestination;
                    }
                }
                if (!empty($listproductdescsource))
                {
                    $counterbreak = 1;
                    foreach ($listproductdescsource as $pidrel)
                    {
                        $myRelProduct = new Core_Product((int) $pidrel, true);
                        if ($myRelProduct->id > 0 && $myRelProduct->sellprice > 0 && $myRelProduct->onsitestatus > 0 && $myRelProduct->instock > 0 && $myRelProduct->status == Core_Product::STATUS_ENABLE)// && $myRelProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
                        {
                            if ($counterbreak > 3) break;
                            $listrelproductproducts[] = $myRelProduct;
                            $counterbreak++;
                        }
                    }
                }
            }
        }
        $giftOrder = Core_Giftorder::getGiftorders(array('fpricein'=>$cartpricetotal,'fisactive'=>1),'fpriceto','DESC','0,1');
        $giftProduct = array();
        $isshowgift = 0;
        if (!empty($giftOrder)) {
            $giftOrder = $giftOrder[0];
            $giftOrderProduct = Core_Giftorderproduct::getGiftorderproducts(array('fgoid'=>$giftOrder->id,'fhavestock'=>1,'fstatus'=>Core_Giftorderproduct::STATUS_ENABLE),'rand','');
            if (!empty($giftOrderProduct)) {
                foreach ($giftOrderProduct as $gift => $giftOP) {
                    $product = new Core_Product($giftOP->productid);
                    $giftProduct[] = $product;
                    $isshowgift = 1;
                    $_SESSION['cartpricegifttotal'] = $cartpricetotal;
                }
                $totalProductGift = count($giftProduct);
                if ($totalProductGift == 1) {
                    $giftProduct[1] = $giftProduct[0];
                    $giftProduct[2] = $giftProduct[0];
                }
                if ($totalProductGift == 2) {
                    $giftProduct[2] = $giftProduct[1];
                }

            }
        }
        //echodebug($this->cartItems);
        $lengcart = count($this->cartItems) - 1;
        $category = Core_Product::getFullCategoryByProductId($this->cartItems[$lengcart ]->product->id);
        $dmreview = !empty($this->cartItems)?" - ".strip_tags($this->cartItems[$lengcart ]->product->dienmayreview):"";
        //echodebug($paymentMethod);
            $this->registry->smarty->assign(array(
                'success'               => $success,
                'error'                 => $error,
                'formData'              => $formData,
                'isPopup'               => $isPopup,
                'orderDelivery'         => $deliverMethod,
                'cartItems'             => $this->cartItems,
                'cartpricetotal'        => $cartpricetotal,
                'paymentMethod'         => $paymentMethod,
                'cartItemCount'         => $cartItemCount,
                'listRelProductProduct' => $listrelproductproducts,
                'giftProduct'           => $giftProduct,
                'isshowgift'            => $isshowgift,
                'redirect' => base64_encode($this->registry->conf['rooturl'] . 'cart/checkout'),
        ));
        $tplshow = 'popupgiohang.tpl';

        if(SUBDOMAIN == 'm'){
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$tplshow);
            $this->registry->smarty->assign(array(
                'contents'        => $contents,
                'pageTitle'       => 'Đặt mua sản phẩm '.$this->cartItems[$lengcart]->product->name.' - '.$category[$lengcart ]['pc_name'], //.$this->registry->lang['controller']['pagetitlePayment'],
                'pageKeyword'     => 'giỏ hàng, thanh toán, giao hàng, xác nhận đơn hàng',
                'pageDescription' => 'Mua sản phẩm '.$this->cartItems[$lengcart ]->product->name.$dmreview,
                'pageMetarobots'  => 'noindex, nofollow',
                'pageCanonical'  => $pageCanonical,
            ));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');  //smartyControllerContainerRoot
        }else{
            $this->registry->smarty->display($this->registry->smartyControllerContainer.$tplshow);
        }

    }
    private function addToOrder($formData)
    {
        $this->cartItems = $this->registry->cart->getContents();
        $totalofcartitem = count($this->cartItems);
        if($totalofcartitem==0) return false;

        $cartpricetotal = 0;
        $this->cartfirstpricetotal = 0;
        $listproductid = array();
        $totalquantities = 0;
        //Kieemr tra coi ton kho da het
        for($i = 0; $i < $totalofcartitem; $i++)
        {
            $this->cartItems[$i]->product = new Core_Product($this->cartItems[$i]->id, true);
            if (empty($this->cartItems[$i]->product)) continue;
            if($this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                $productMain = Core_Product::getMainProductFromColor($this->cartItems[$i]->product->id);
                if(!empty($productMain))
                {
                    //$productDetail->displaysellprice = $productMain->displaysellprice;
                    $this->cartItems[$i]->product->status           = $productMain->status;
                }
            }
            //$this->cartItems[$i]->product->sellprice = Helper::refineMoneyString($this->cartItems[$i]->product->sellprice);
            if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice>0 && $this->cartItems[$i]->product->onsitestatus > 0 && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)// && $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
            {
                $listproductid[] = $this->cartItems[$i]->product->id;
                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($this->cartItems[$i]->product->barcode, self::REGION_HCM);
                if($finalprice > 0)
                {
                    $this->cartItems[$i]->product->sellprice = $finalprice;
                }
                $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);

                $sellprice = 0;
                if(!empty($this->cartItems[$i]->options['promotionid']))
                {
                    $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], self::REGION_HCM, $this->cartItems[$i]->product->barcode);
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
                $totalquantities += $this->cartItems[$i]->quantity;

                $cartpricetotal += $this->cartItems[$i]->subtotal;
            }
        }


        //Nếu user chưa login
        $uid = $this->registry->me->id;
        /*if($uid == 0)//    && count($this->cartItems) > 0
        {
            $getuser = Core_User::getByEmail($formData['femail']);
            //Trường hợp email đã có rồi thì không làm gì hết (hay nên update lại thông tin. hiện tại ko làm gì hết)
            if($getuser->id <= 0)
            {
                $createUser = new Core_User();
                $createUser->fullname = $formData['ffullname'];
                //$createUser->groupid = $formData['ffullname'];
                $createUser->region = $formData['myregion'];
                $createUser->gender = (($formData['fgender']==1)?Core_User::GENDER_MALE:Core_User::GENDER_FEMALE);
                $createUser->phone = $formData['fphonenumber'];
                $createUser->email = $formData['femail'];
                $createUser->address = $formData['faddress'];
                $uid = $createUser->addData();
            }
            else {
                $uid = $getuser->id;
                $formFields['fullname'] = $formData['ffullname'];
                $formFields['region'] = $formData['myregion'];
                $formFields['gender'] = (($formData['fgender']==1)?Core_User::GENDER_MALE:Core_User::GENDER_FEMALE);
                $formFields['phone'] = $formData['fphonenumber'];
                $formFields['email'] = $formData['femail'];
                $formFields['address'] = $formData['faddress'];
                $getuser->updateData($formFields);
            }
        }
        else{
            $getuser = new Core_User($uid);
            if($getuser->id > 0)
            {
                $formFields['fullname'] = $formData['ffullname'];
                $formFields['region'] = $formData['myregion'];
                $formFields['gender'] = (($formData['fgender']==1)?Core_User::GENDER_MALE:Core_User::GENDER_FEMALE);
                $formFields['phone'] = $formData['fphonenumber'];
                $formFields['email'] = $formData['femail'];
                $formFields['address'] = $formData['faddress'];
                $getuser->updateData($formFields);
            }
        }*/
        //Lưu xuống CSDL
        $formData['femail'] = strip_tags($formData['femail']);
        $formData['ffullname'] = strip_tags($formData['ffullname']);
        $formData['faddress'] = strip_tags($formData['faddress']);
        $formData['fphonenumber'] = strip_tags($formData['fphonenumber']);
        $currentOrder = new Core_Orders();
        $currentOrder->uid = $uid;
        //$currentOrder->invoiceid = Core_Orders::getInvoicedCode();
        $currentOrder->pricesell = $this->cartfirstpricetotal;
        $currentOrder->pricediscount = ($this->cartfirstpricetotal- $cartpricetotal);
        $currentOrder->pricefinal = $cartpricetotal;
        $currentOrder->contactemail = $formData['femail'];
        $currentOrder->billinggender = (($formData['fgender']==1)?Core_User::GENDER_MALE:Core_User::GENDER_FEMALE);;
        $currentOrder->billingfullname = $formData['ffullname'];
        $currentOrder->billingphone = $formData['fphonenumber'];
        $currentOrder->billingaddress = $formData['faddress'];
        $currentOrder->billingregionid = $formData['myregion'];
        $currentOrder->billingdistrict = $formData['fdistrict'];
        $currentOrder->shippingfullname = $formData['ffullname'];
        $currentOrder->shippingphone = $formData['fphonenumber'];
        $currentOrder->shippingaddress = $formData['faddress'];
        $currentOrder->shippingregionid = $formData['myregion'];
        $currentOrder->shippingdistrict = $formData['fdistrict'];
        $stringtogetshippingfee = 'sescart_shippingfee';
        if (!empty($listproductid)) {
            $stringtogetshippingfee .= md5(implode(',', $listproductid)) . '-' . $totalquantities;
            if (!empty($_SESSION[$stringtogetshippingfee])) {
                $currentOrder->priceship = $_SESSION[$stringtogetshippingfee];
                $currentOrder->pricefinal += $currentOrder->priceship;
                unset($_SESSION[$stringtogetshippingfee]);
            }
        }

        //$currentOrder->shippinglat = $formData['ffullname'];
        //$currentOrder->shippinglng = $formData['ffullname'];
         $currentOrder->note = $formData['frequest'];
        if (SUBDOMAIN == 'm') {
            if (!empty($formData['productgift']) && $formData['productgift'] == 'gift') {
                $giftOrder = Core_Giftorder::getGiftorders(array('fpricein'=>$cartpricetotal,'fisactive'=>1),'fpriceto','DESC','0,1');
                $giftProduct = array();
                if (!empty($giftOrder)) {
                    $giftOrder = $giftOrder[0];
                    $giftOrderProduct = Core_Giftorderproduct::getGiftorderproducts(array('fgoid'=>$giftOrder->id,'fhavestock'=>1,'fstatus'=>Core_Giftorderproduct::STATUS_ENABLE),'rand','');
                    if (!empty($giftOrderProduct)) {
                        foreach ($giftOrderProduct as $gift => $giftOP) {
                            $product = new Core_Product($giftOP->productid);
                            $giftProduct[] = $product->id;
                        }
                    }
                }

                if (count($giftProduct) > 0) {
                    $product = new Core_Product($giftProduct[0]);
                    if($product->id > 0) {
                        $currentOrder->note .= ' Sản phẩm tặng kèm : Mã sản phẩm : '.$product->id.' , Tên sản phẩm: '.$product->name;
                        $_SESSION['isgift'] = $product->id;
                    }
                }
            }
        }
        $currentOrder->ipaddress = Helper::getIpAddress(true);
        //$currentOrder->paymentmethod = ;
        if (isset($formData['ftransfer']))$currentOrder->deliverymethod = $formData['ftransfer'];
        if (isset($formData['fpaymentmethod'])) $currentOrder->paymentmethod = $formData['fpaymentmethod'];
        $currentOrder->status = Core_Orders::STATUS_PENDING;
        //if(!empty($formData['fprogrameid'])) $currentOrder->promotionid = $formData['fprogrameid'];

        if (!empty($_SESSION['sesPromotionidfromCRM'])) $currentOrder->promotionid = (int)$_SESSION['sesPromotionidfromCRM'];
        else $currentOrder->promotionid = (int)$formData['fprogrameid'];

        $currentOrder->datecreated = time();
        $idorder = $currentOrder->addData();
        //$crm_listpro = array();
        if($idorder)
        {
            //generate invoicedid
            $currentOrder->invoiceid = $currentOrder->getInvoicedCode();
            if($currentOrder->invoiceid !='')
            {
                $currentOrder->updateData();
                //Thêm xuống order detail
                //$ctnit = 0;
                //Tao session invoiceid de~ checking khi bao don hang thanh dong ma $_GET['0'] co bang $_SESSION
                if (SUBDOMAIN == 'm') {
                    $_SESSION['invoicedid'] = $currentOrder->invoiceid;
                }
                foreach($this->cartItems as $it)
                {
                    if($it->product->sellprice > 0 && $it->product->onsitestatus > 0 && $it->product->status == Core_Product::STATUS_ENABLE)// && $it->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
                    {
                        $orderdetail = new Core_OrdersDetail();
                        $orderdetail->oid = $idorder;
                        $orderdetail->pid = $it->product->id;
                        $orderdetail->pricesell = $it->product->sellprice;
                        $orderdetail->pricediscount = ($it->product->sellprice - $it->pricesell);
                        $orderdetail->pricefinal = $it->pricesell;
                        $orderdetail->quantity = $it->quantity;

                        /*$crm_listpro[$ctnit][0] = (int)$it->product->id;
                        $crm_listpro[$ctnit][1] = (int)($it->quantity);
                        $crm_listpro[$ctnit][2] = $it->product->barcode;

                        $crm_listpro[$ctnit][4] = (int)$it->product->pcid;
                        $crm_listpro[$ctnit][5] = (double)$orderdetail->pricesell;
                        $crm_listpro[$ctnit][6] = (double)$orderdetail->pricefinal;

                        $ctnit++;*/

                        $orderdetail->options = array('promotionid' => $it->options['promotionid'], 'regionid' => $it->options['regionid']);
                        $orderdetail->addData();
                    }
                }
                $_SESSION['user_fullname'] = $formData['ffullname'];
                $_SESSION['user_email'] = $formData['femail'];
                $_SESSION['user_address'] = $formData['faddress'];
                $_SESSION['user_phonenumber'] = $formData['fphonenumber'];
                $_SESSION['user_fprovince'] = $formData['myregion'];
                $_SESSION['user_fdistrict'] = $formData['fdistrict'];
                $_SESSION['user_fregister'] = $formData['fregister'];
                $_SESSION['ses_orderidsuccess'] = $idorder;
                //send background job
                if (empty($formData['hiddengift'])) {
                    $taskUrl = $this->registry->conf['rooturl'] . 'task/ordercrm?debug=1';
                    file_put_contents('uploads/backgroundjob.txt','uid=' . $uid.'&oid='.$idorder);
                    Helper::backgroundHttpPost($taskUrl, 'oid='.$idorder);
                }
                unset($_SESSION['sesPromotionidfromCRM']);
                return $currentOrder->invoiceid;
            }
            else{
                return false;
            }
        }
        else {
            return false;
        }
    }

    private function checkValidatePaymentForm($formData, &$error, $norequireemailaddress = true)
    {
        $pass = true;
        if(SUBDOMAIN != 'm'){
        //echodebug(self::REGION_HCM); || $formData['myregion'] != self::REGION_HCM
            if(empty($formData['myregion']))
            {
                $error[0] = $this->registry->lang['controller']['errEmptyRegion'];
                $pass = false;
            }
//            if(!isset($formData['fgender']) || $formData['fgender'] <0)
//            {
//                $error[0] = $this->registry->lang['controller']['errEmptyGender'];
//                $pass = false;
//            }
        }
        if(empty($formData['ffullname']) )
        {
            $error[0] = $this->registry->lang['controller']['errEmptyFullname'];
            $pass = false;
        }
        if(empty($formData['fphonenumber']) || !Helper::checkPhoneAvalible($formData['fphonenumber']))
        {
            $error[0] = $this->registry->lang['controller']['errEmptyPhone'];
            $pass = false;
        }
        //if($norequireemailaddress && empty($formData['femail']) )
        if(!empty($formData['femail']) && !Helper::ValidatedEmail($formData['femail']))
        {
            $error[0] = $this->registry->lang['controller']['errInvalidemail'];
            $pass = false;
        }
        /*if($norequireemailaddress && empty($formData['faddress']) )
        {
            $error[0] = $this->registry->lang['controller']['cartinputaddress'];
            $pass = false;
        }
        if(empty($formData['ftransfer']) )
        {
            $error[0] = $this->registry->lang['controller']['cartinputfulldata'];
            $pass = false;
        }
        if(!isset($formData['frequest']) )
        {
            $error[0] = $this->registry->lang['controller']['cartinputfulldata'];
            $pass = false;
        }*/
        return $pass;
    }


    protected function addtocartValidate($formData, &$error)
    {
        $pass = true;


        //check contact spam
        $addtocartExpire = 5;    //seconds
        if(isset($_SESSION['addtocartSpam']) && time() - $_SESSION['addtocartSpam'] < $addtocartExpire)
        {
            $error[] = $this->registry->lang['controller']['errSpam'];
            $pass = false;
        }


        return $pass;
    }

    public function updateAction()
    {
        $formData = $_POST;
        //clear current cart
        $this->registry->cart->emptyCart();
        foreach($formData['fquantity'] as $id => $quantity)
        {
            if($quantity > 0)
            {
                $options = array('promotionid' => $formData['promotionid'][$id], 'regionid' => (int)$formData['regionid'][$id]);
                $getCurrentQuantityCart = $this->registry->cart->getCurrentQuantity($id, $options);
                $newquantity = (int)$quantity;
                if ($newquantity > 5) $newquantity = 5;
                $this->registry->cart->addItem($id, $newquantity, $options);
            }
        }
        $this->registry->cart->saveToSession();
    }

    public function updatecartmobileAction()
    {
        $formData = $_POST;
        //clear current cart
        $this->registry->cart->emptyCart();
        foreach($formData['fquantity'] as $id => $quantity)
        {
            if($quantity > 0)
            {
                $options = array('promotionid' => $formData['promotionid'][$id], 'regionid' => (int)$formData['regionid'][$id]);
                $getCurrentQuantityCart = $this->registry->cart->getCurrentQuantity($id, $options);
                $newquantity = (int)$quantity;
                if ($newquantity > 5) $newquantity = 5;
                $this->registry->cart->addItem($id, $newquantity, $options);
            }
        }
        $this->registry->cart->saveToSession();
    }

    public function successAction()
    {
        $success = $this->registry->lang['controller']['cartsuccess'];
        $isday = 2;
        if(date('H')>=6 && date('H')<=19)
        {
            $isday = 1;
        }
        $fullname = $_SESSION['user_fullname'];
        $email =  $_SESSION['user_email'];
        $address =  $_SESSION['user_address'];
        $phonenumberusers = $_SESSION['user_phonenumber'];
        $province = $_SESSION['user_fprovince'];
        $district = $_SESSION['user_fdistrict'];
        $register = $_SESSION['user_fregister'];
        //list thong tin don hang
        $str = '';
        //$_SESSION['ses_orderidsuccess'] = 3695;
        if (!empty($_SESSION['ses_orderidsuccess']))
        {
            //get order detail
            $listtrackingecommerce = array();
            $myOrder = new Core_Orders($_SESSION['ses_orderidsuccess']);

            if ($myOrder->id > 0)
            {
                $orderDetail = Core_OrdersDetail::getOrdersDetails(array('foid' => $myOrder->id), '', '');
                if (!empty($orderDetail))
                {
                    if(SUBDOMAIN == 'm')
                    {
//                            $str = "_gaq.push(['_addTrans',
//                              '".$myOrder->invoiceid."',           // transaction ID - required
//                              'Dienmay.com mobile', // affiliation or store name
//                              '".$myOrder->pricefinal."'
//                           ]);\n";

                            $str = "\n" . "ga('require', 'ecommerce', 'ecommerce.js');" . "\n";
                            $str .= "ga('ecommerce:addTransaction', {
                              'id': '".$myOrder->invoiceid."',
                              'affiliation': 'Dienmay.com mobile',
                              'revenue': '".$myOrder->pricefinal."'
                            });\n";

                            foreach($orderDetail as $od)
                            {
                                $product = new Core_Product($od->pid, true);
                                $listtrackingecommerce['orderDetail'][] = array('pid' => $od->pid, 'pname' => $product->name);

                                $str .= "ga('ecommerce:addItem', {
                                      'id': '".$myOrder->invoiceid."',
                                      'name': '".(addslashes($product->name))."',
                                      'sku': '".trim($product->barcode)."',
                                      'category': '".(addslashes($product->pcid))."',
                                      'price': '".$od->pricesell."',
                                      'quantity': '".$od->quantity."'
                                    });\n";
                            }
                            $str .= "\n" . "ga('ecommerce:send');";
                    }
                    else
                    {
                        $str = "_gaq.push(['_addTrans',
                              '".$myOrder->invoiceid."',           // transaction ID - required
                              'Dienmay.com', // affiliation or store name
                              '".$myOrder->pricefinal."',
                              '0',
                              '".$myOrder->shippingfeeprice."'
                           ]);\n";

                        /*'1.29',           // tax
                          '15.00',          // shipping
                          'San Jose',       // city
                          'California',     // state or province*/
                        foreach($orderDetail as $od)
                        {
                            $product = new Core_Product($od->pid, true);
                            $listtrackingecommerce['orderDetail'][] = array('pid' => $od->pid, 'pname' => $product->name);
                            $str .= " _gaq.push(['_addItem',
                                  '".$myOrder->invoiceid."',         // transaction ID - necessary to associate item with transaction
                                  '".trim($product->barcode)."',         // SKU/code - required
                                  '".(addslashes($product->name))."',      // product name - necessary to associate revenue with product
                                  '".(addslashes($product->pcid))."',
                                  '".$od->pricesell."',        // unit price - required
                                  '".$od->quantity."'             // quantity - required
                               ]);\n";
                        }
                        $str .= "\n".'_gaq.push([\'_trackTrans\']);';
                    }


                }

            }
        }
        else{
            header('Location:'.$this->registry->conf['rooturl']);
        }

        $getdistrict = new Core_Region($district);
        if (!empty($getdistrict)){
            $districname = $getdistrict->name;
        }
        $getcity = new Core_Region($province);
        if (!empty($getcity)){
            $cityname = $getcity->name;
        }
        if ($_SESSION['invoicedid'] == $_GET['o'] && !empty($_SESSION['invoicedid'])) {
            $productid = $_GET['p'];
            $productGift = new Core_Product($productid);
            if ($productid > 0) {
                $giftOrderProduct =  Core_Giftorderproduct::getGiftorderproducts(array('fproductid'=>$productid,'fhavestock'=>1),'','','0,1');
                if ($giftOrderProduct[0]->id > 0) {
                    if($giftOrderProduct[0]->instock > 0) {
                        $giftOrderProduct[0]->instock = $giftOrderProduct[0]->instock - 1;
                        if ($giftOrderProduct[0]->updateData()) {

                        }
                    }
                }
            }
        }
        $this->registry->smarty->assign(array(  'success' => $success,'listtrackingecommerce' => $str,'isday'=>$isday,'invoicedid' => (!empty($_GET['o'])?$_GET['o']:0),
                                                'phonenumberuser' => $phonenumberusers,
                                                'myOrder'=>$myOrder,
                                                'fullname' => $fullname,
                                                'email' => $email,
                                                'address' => $address,
                                                'province' => $province,
                                                'district' => $district,
                                                'register' => $register,
                                                'districname' => $districname,
                                                'cityname' => $cityname,
                                                'productGift' => $productGift,
                                            ));
        unset($_SESSION['invoicedid']);
        unset($_SESSION['user_fullname']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_address']);
        unset($_SESSION['user_phonenumber']);
        unset($_SESSION['user_fprovince']);
        unset($_SESSION['user_fdistrict']);
        unset($_SESSION['user_fregister']);
        unset($_SESSION['ses_orderidsuccess']);
        $tplshow = 'dathangthanhcong.tpl';

        if(SUBDOMAIN == 'm'){
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$tplshow);
            $this->registry->smarty->assign(array('contents' => $contents,
                                                   'pageTitle' => $this->registry->lang['controller']['pagetitlePayment'],
                                                ));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
        }else{
            $this->registry->smarty->display($this->registry->smartyControllerContainer.$tplshow);
        }
    }

    public function failAction()
    {
        $error = $this->registry->lang['controller']['cartpaymenterror'];
        $this->registry->smarty->assign(array(  'error' => $error,
                                            ));
        $tplshow = 'dathangthatbai.tpl';
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$tplshow);

        $this->registry->smarty->assign(array('contents' => $contents,
                                               'pageTitle' => $this->registry->lang['controller']['pagetitlePayment'],
                                            ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
    }

    private function getRelProductCart($listpid)
    {
        if(!empty($listpid))
        {
            $relProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsourcearr'=>$listpid, 'ftype' => Core_RelProductProduct::TYPE_PRODUCT3),'','',0);

            $relProductProduct = array();

            if(!empty($relProduct))
            {
                foreach($relProduct as $relpp)
                {
                    $relProductProduct[] = $relpp->piddestination;
                }
                //echodebug($relProductProduct);
                if(!empty($relProductProduct))
                {
                    $newRelProductProduct = Core_Product::getProducts(array('fidarr'=>$relProductProduct,'fquantitythan0'=> 1, 'fpricethan0'=> 1, 'fisonsitestatus' =>1, 'fstatus' =>Core_Product::STATUS_DISABLED, 'fcustomizetype' =>Core_Product::CUSTOMIZETYPE_MAIN),'','',0); //,
                    if(!empty($newRelProductProduct))
                    {
                        $num = count($newRelProductProduct);
                        for($i =0 ; $i < $num; $i++)
                        {
                            if($newRelProductProduct[$i]->sellprice > 0)
                            {
                                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($newRelProductProduct[$i]->barcode, self::REGION_HCM);
                                if(!empty($finalprice)) {
                                    $newRelProductProduct[$i]->sellprice = $finalprice;
                                }
                            }
                            $newsummary = '';
                            $explodenewsummary = explode("\n",$newRelProductProduct[$i]->summary);//Helper::xss_replacewithBreakline(strip_tags($pro->summary));

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
                            }
                        }
                    }
                    return $newRelProductProduct;
                }
            }
        }
        return false;
    }

    public function loadcartajaxAction()
    {
        if(!empty($_SERVER['HTTP_REFERER'])){
            $cartpricetotal = 0;
            $this->cartfirstpricetotal = 0;
            $this->cartItems = $this->registry->cart->getContents();
            $numberofcarts = count($this->cartItems);
            if($numberofcarts > 0)
            {
                //Kieemr tra coi ton kho da het
                for($i = 0; $i < $numberofcarts; $i++)
                {
                    $this->cartItems[$i]->product = new Core_Product($this->cartItems[$i]->id, true);
                    if (empty($this->cartItems[$i]->product)) continue;
                    if($this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
                    {
                        $productMain = Core_Product::getMainProductFromColor($this->cartItems[$i]->product->id);
                        if(!empty($productMain))
                        {
                            //$productDetail->displaysellprice = $productMain->displaysellprice;
                            $this->cartItems[$i]->product->status           = $productMain->status;
                        }
                    }
                    //$this->cartItems[$i]->product->sellprice = Helper::refineMoneyString($this->cartItems[$i]->product->sellprice);
                    if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice>0 && $this->cartItems[$i]->product->onsitestatus > 0 && $this->cartItems[$i]->product->instock > 0 && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)//$this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&
                    {
                        $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($this->cartItems[$i]->product->barcode, self::REGION_HCM);
                        if(!empty($finalprice))
                        {
                            $this->cartItems[$i]->product->sellprice = $finalprice;
                        }
                        else {
                            $this->cartItems[$i]->product->sellprice = ($this->cartItems[$i]->product->sellprice);
                        }
                        $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);
                        $sellprice = 0;//$this->cartItems[$i]->product->sellprice;
                        if(!empty($this->cartItems[$i]->options['promotionid']))
                        {
                            $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], self::REGION_HCM, $this->cartItems[$i]->product->barcode);
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
                        //echodebug($this->cartItems);
                    }
                }
                $this->registry->smarty->assign(array(
                                                'cartItems'           => $this->cartItems,
                                                'cartpricetotal' => $cartpricetotal,
                                            )
                                       );
                $content = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'cartheader.tpl');
                echo json_encode(array('content' => $content, 'success' => 1));
            }
            else echo json_encode(array('fail' => 1));
        }
        else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        }
    }

    public function deletecartitemAction()
    {
        if(isset($_POST['deleteid']) && $_POST['deleteid'] > 0)
        {
            $this->registry->cart->delItem($_POST['deleteid']);
            $this->registry->cart->saveToSession();
            $cartpricetotal = 0;
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
                    if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice>0 && $this->cartItems[$i]->product->onsitestatus > 0 && $this->cartItems[$i]->product->instock > 0 && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)//&& $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
                    {
                        $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($this->cartItems[$i]->product->barcode, self::REGION_HCM);
                        if(!empty($finalprice))
                        {
                            $this->cartItems[$i]->product->sellprice = $finalprice;
                        }
                        else {
                            $this->cartItems[$i]->product->sellprice = ($this->cartItems[$i]->product->sellprice);
                        }
                        $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);
                        $sellprice = 0;//$this->cartItems[$i]->product->sellprice;
                        if(!empty($this->cartItems[$i]->options['promotionid']))
                        {
                            $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], self::REGION_HCM, $this->cartItems[$i]->product->barcode);
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
                        //echodebug($this->cartItems);
                    }
                }
                echo json_encode(array('cartpricetotal' => Helper::formatPrice($cartpricetotal), 'success' => 1));
            }
        }
    }

    //Cho khuyen mai giare, 1 lan chi tao don hang cho 1 san pham
    function giareAction()
    {
        //header('Location: '.$this->registry->conf['rooturl'].'cart'.(!empty($_GET['id'])?'/?id='.$_GET['id']:''));
        $formData = $error = $success = array();
        //addtocart
        if(!empty($_GET['id']))
        {
            $this->registry->cart->emptyCart();
            $this->registry->cart->saveToSession();//chi cho phep dat 1 san pham 1 lan
            $promotionid = '';
            $pbarcode = '';
            if(!empty($_GET['prid']))
            {
                $explode = explode('_',$_GET['prid']);
                if(!empty($explode[1])) $promotionid = $explode[1];
                if(!empty($explode[0])) $pbarcode = trim($explode[0]);
            }
            $myProduct = new Core_Product($_GET['id'], true);
            $myProduct->barcode = trim($myProduct->barcode);

            if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                $productMain = Core_Product::getMainProductFromColor($myProduct->id);
                if(!empty($productMain))
                {
                    //$productDetail->displaysellprice = $productMain->displaysellprice;
                    $myProduct->status           = $productMain->status;
                }
            }
            //Kiem tra xem book nay co thuc su dang ban tren Reader khong, cai nay quan trong boi co the add BookID bay ba
            if($myProduct->id > 0 && $myProduct->sellprice > 0 && $myProduct->onsitestatus > 0 && $myProduct->instock > 0 && $myProduct->status == Core_Product::STATUS_ENABLE)// && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
            {
                if(!empty($promotionid) && $pbarcode == $myProduct->barcode)
                {
                    $promotioninfo = Core_Promotion::getOnePromotionbyID($promotionid, self::REGION_HCM, trim($myProduct->barcode));
                    if(empty($promotioninfo))
                    {
                        $error[] = $this->registry->lang['controller']['cartpromotioninvalid'];
                    }
                }
                if(empty($error) && $this->addtocartValidate($formData, $error))
                {
                    $quantity = 1; //chưa kiểm tra trường hợp quantity lớn hơn instock
                    $options = array('promotionid' => $promotionid, 'regionid' => self::REGION_HCM);
                    $this->registry->cart->addItem($myProduct->id, $quantity, $options);
                    $this->registry->cart->saveToSession();
                    $success[] = $this->registry->lang['controller']['succAddToCart'];
                    $_SESSION['addtocartSpam'] = time();
                }
            }
            else
                $error[] = $this->registry->lang['controller']['errProductSellNotFound'];
            //chua kiem tra gio hang o day
        }
        //delete an item from cart or clear cart
        if(isset($_GET['deleteid']))
        {
            if($_GET['deleteid'] > 0)
            {
                $this->registry->cart->delItem($_GET['deleteid']);
                $this->registry->cart->saveToSession();
                $success[] = $this->registry->lang['controller']['succDeleteItem'];
            }
            else
            {
                $this->registry->cart->emptyCart();
                $this->registry->cart->saveToSession();
                $success[] = $this->registry->lang['controller']['succClearCart'];
            }
            //header('Location: '.$this->registry->conf['rooturl'].'cart/checkout');
        }
        $formData['fregion'] = self::REGION_HCM;
        if(isset($_POST['btncheckout']))
        {
            $formData = $_POST;
            if($this->checkValidatePaymentForm($formData, $error, false))
            {
                $formData['fprogrameid'] = 34;//self::CRM_PROGRAMEID;
                $invoicedid = $this->addToOrder($formData);
                if(!empty($invoicedid))
                {
                    $this->registry->cart->emptyCart();
                    $this->registry->cart->saveToSession();
                    if(!empty($_SESSION['sesgiaregioithieuid']))
                    {
                        $taskUrl = $this->registry->conf['rooturl'] . 'task/giare';
                        Helper::backgroundHttpPost($taskUrl, 'id=' . $_SESSION['sesgiaregioithieuid'].'&fullname='.base64_encode($formData['ffullname']));
                    }
                    ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/success?o='.$invoicedid;?>";</script><?php
                }
                else {
                    ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/fail';?>";</script><?php
                }
            }
        }
        else{

            if($this->registry->me->id > 0)
            {
                $formData['fgender'] = ($this->registry->me->gender == Core_User::GENDER_MALE? 1: 0);
                $formData['femail'] = $this->registry->me->email;
                $formData['ffullname'] = $this->registry->me->fullname;
                $formData['fphonenumber'] = $this->registry->me->phone;
                $formData['faddress'] = $this->registry->me->address;
            }
        }

        //get the cart Item

        $cartpricetotal = 0;
        $this->cartfirstpricetotal = 0;
        $this->cartItems = $this->registry->cart->getContents();
        $numberofcarts = count($this->cartItems);

        if($numberofcarts <= 0)
        {
            $error[] = 'Không có sản phẩm nào cho giỏ hàng của bạn';
        }

        $listproductid = array();
        if(!empty($this->cartItems))
        {
            //Kieemr tra coi ton kho da het

            for($i = 0; $i < $numberofcarts; $i++)
            {
                $this->cartItems[$i]->product = new Core_Product($this->cartItems[$i]->id, true);
                if($this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
                {
                    $productMain = Core_Product::getMainProductFromColor($this->cartItems[$i]->product->id);
                    if(!empty($productMain))
                    {
                        //$productDetail->displaysellprice = $productMain->displaysellprice;
                        $this->cartItems[$i]->product->status           = $productMain->status;
                    }
                }
                if($this->cartItems[$i]->product->id > 0 && $this->cartItems[$i]->product->sellprice > 0 && $this->cartItems[$i]->product->onsitestatus > 0 && $this->cartItems[$i]->product->instock > 0 && $this->cartItems[$i]->product->status == Core_Product::STATUS_ENABLE)// && $this->cartItems[$i]->product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN
                {
                    $listproductid[] = $this->cartItems[$i]->product->id;
                    $this->cartfirstpricetotal += ($this->cartItems[$i]->quantity * $this->cartItems[$i]->product->sellprice);
                    $sellprice = 0;
                    if(!empty($this->cartItems[$i]->options['promotionid']))
                    {
                        $promotioninfo = Core_Promotion::getOnePromotionbyID($this->cartItems[$i]->options['promotionid'], self::REGION_HCM, $this->cartItems[$i]->product->barcode);
                        if(!empty($promotioninfo['promotiongroup']))
                        {
                            foreach($promotioninfo['promotiongroup'] as $pg)
                            {
                                if((int)$pg->discountvalue > 0)
                                {
                                    if($pg->isdiscountpercent == 1) {
                                        $sellprice = round($this->cartItems[$i]->product->sellprice - ((double)$this->cartItems[$i]->product->sellprice*(double)$pg->discountvalue/100));
                                    }
                                    else {
                                        $sellprice = $this->cartItems[$i]->product->sellprice - $pg->discountvalue;
                                    }
                                    $this->cartItems[$i]->firstprice = $this->cartItems[$i]->product->sellprice;
                                    break;
                                }
                            }
                        }
                    }
                    if($sellprice > 0)
                    {
                        $this->cartItems[$i]->pricesell = $sellprice;
                    }
                    else {
                        $this->cartItems[$i]->pricesell = $this->cartItems[$i]->product->sellprice;
                    }
                    $this->cartItems[$i]->subtotal = $this->cartItems[$i]->quantity * $this->cartItems[$i]->pricesell;

                    $cartpricetotal += $this->cartItems[$i]->subtotal;
                }
            }
        }

        $deliverMethod = Core_Orders::getOrderDeliveryMethod();
        $relProductCart = null;
        if(!empty($listproductid))
        {
            $relProductCart = $this->getRelProductCart($listproductid);
        }
        $this->registry->smarty->assign(array(  'success' => $success,
                                                'error'    => $error,
                                                'formData'    => $formData,
                                                'isnotchangequantity' => 1,
                                                'orderDelivery' => $deliverMethod,
                                                'cartItems'           => $this->cartItems,
                                                'cartpricetotal' => $cartpricetotal,
                                                'relProductCart' => $relProductCart,
                                                'cartItemCount' => $cartItemCount,
                                            ));
        $tplshow = 'checkout.tpl';
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$tplshow);

        $this->registry->smarty->assign(array('contents' => $contents,
                                               'pageTitle' => $this->registry->lang['controller']['muanhanh'],
                                            ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');  //smartyControllerContainerRoot
    }

    //Cho khách hàng đặt hàng trước (dat truoc khong xet chon KM)
    function dattruocAction()
    {
        $formData = $error = $success = array();
        $myProduct = null;
        $myPromotion = null;
        $promotionid = '';
        $pbarcode = '';
        //addtocart
        if(!empty($_GET['id']))
        {
            $myProduct = new Core_Product($_GET['id'], true);
            $myProduct->barcode = trim($myProduct->barcode);
            //Check so luong duoc dat hang
            //38 la ma chuong trinh dat hang truoc
            $counterorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($myProduct->prepaidstartdate, $myProduct->prepaidenddate )),'','', '', true);//,'isgroupbyuser' => 1
            if (count($counterorders) > 0)
            {
                $counterpreorders = 0;
                for ($cntorder = 0; $cntorder <= $counterorders; $cntorder +=50)
                {
                    $listmyorders = Core_Orders::getOrderss(array('fpromotionid' => 38, 'forderbytimesegment' => array($myProduct->prepaidstartdate, $myProduct->prepaidenddate )),'','', $cntorder.',50');//,'isgroupbyuser' => 1
                    if(!empty($listmyorders)){
                        $listordersid = array();
                        $listusername = array();
                        foreach($listmyorders as $od){
                            $listordersid[] = $od->id;
                            $listusername[$od->id] = $od->billingfullname;
                        }
                        if(!empty($listordersid)){
                            //$counterpreorders += Core_Orders::getOrderss(array('fpromotionid' => 38, 'fidarr' => $listordersid, 'forderbytimesegment' => array($productDetail[0]->prepaidstartdate, $productDetail[0]->prepaidenddate )),'','', '', true);//, 'isgroupbyorder' => 1
                            $prepaidorderdetail = Core_OrdersDetail::getOrdersDetails(array('foidarr' => $listordersid, 'fpid' => $myProduct->id),'oid','DESC');
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

                $numberreorder = $counterpreorders;
            }
            $displaybutton = true;
            if ($myProduct->prepaidrand > 0) {
                if ($myProduct->prepaidrand <= $numberreorder) {
                    $displaybutton = false;
                    $error[] = 'Sản phẩm '.$myProduct->name.' đã đủ số lượng đặt trước. mời bạn quay lại khi sản phẩm chính thức bán';
                }
            }
            //End check so luong co the dat hang
            if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                $productMain = Core_Product::getMainProductFromColor($myProduct->id);
                if(!empty($productMain))
                {
                    //$productDetail->displaysellprice = $productMain->displaysellprice;
                    $myProduct->status           = $productMain->status;
                }
            }
            if(!empty($_GET['prid']))
            {
                $explode = explode('_',$_GET['prid']);
                if(!empty($explode[1])) $promotionid = $explode[1];
                if(!empty($explode[0])) $pbarcode = trim($explode[0]);

                if(!empty($promotionid) && $myProduct->barcode == $pbarcode){
                    $myPromotionChk = new Core_Promotion($promotionid);
                    if($myPromotionChk->status == Core_Promotion::STATUS_ENABLE && $myPromotionChk->startdate <= time() && $myPromotionChk->enddate >= time() && $myPromotionChk->isactived ==1 )
                    {
                        $myPromotion = $myPromotionChk;
                    }
                }
            }
            //Kiem tra xem book nay co thuc su dang ban tren Reader khong, cai nay quan trong boi co the add BookID bay ba
            if($myProduct->id <= 0 || $myProduct->prepaidprice <= 0 || $myProduct->onsitestatus != Core_Product::OS_ERP_PREPAID || $myProduct->status != Core_Product::STATUS_ENABLE) {// || $myProduct->customizetype != Core_Product::CUSTOMIZETYPE_MAIN
                $error[] = $this->registry->lang['controller']['errProductSellNotFound'];
            }
        }

        if($this->registry->me->id > 0)
        {
            $formData['femail'] = $this->registry->me->email;
            $formData['ffullname'] = $this->registry->me->fullname;
            $formData['fphonenumber'] = $this->registry->me->phone;
            $formData['faddress'] = $this->registry->me->address;
            if(SUBDOMAIN == 'm')
            {
                $district = new Core_Region($this->registry->me->district);
                if($district > 0)
                {
                    $formData['fdistrict'] = $district->name;
                }
                $formData['fcity'] = $this->registry->me->city;
            }
        }

        if(isset($_POST['btncheckout']) && $myProduct->id > 0 && $myProduct->prepaidprice >0 && $myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID && $myProduct->status == Core_Product::STATUS_ENABLE)//$myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN &&
        {
            $formData = $_POST;
            $formData['ftransfer'] = 1;
            $formData['frequest'] = 1;
            $formData['fgender'] = ($this->registry->me->gender == Core_User::GENDER_MALE? 1: 0);
            //$formData['myregion'] = (!empty(self::REGION_HCM)?self::REGION_HCM:3);//mac dinh lay HCM neu ko detect ra, c
            if($this->checkValidatePaymentForm($formData, $error, false))
            {
                $formData['fprogrameid'] = 38;//Chương trình đặt hàng trước
                $formData['myProduct'] = $myProduct;
                $myProduct->barcode = trim($myProduct->barcode);
                if(!empty($myPromotion) && $myPromotion->id > 0)
                {
                    $formData['promotionid'] = $promotionid;
                }
                $invoicedid = $this->addToOrderNoCart($formData);
                if(!empty($invoicedid))
                {
                    if(!empty($_SESSION['sesgiaregioithieuid']))
                    {
                        $taskUrl = $this->registry->conf['rooturl'] . 'task/giare';
                        Helper::backgroundHttpPost($taskUrl, 'id=' . $_SESSION['sesgiaregioithieuid'].'&fullname='.base64_encode($formData['ffullname']));
                    }
                    ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/success?o='.$invoicedid;?>";</script><?php
                }
                else {
                    ?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'cart/fail';?>";</script><?php
                }
            }
        }


        $this->registry->smarty->assign(array(  'success' => $success,
                                                'error'    => $error,
                                                'formData'    => $formData,
                                                'myProduct'    => $myProduct,
                                                'myPromotion'    => $myPromotion,
                                                'displaybutton'   => $displaybutton
                                            ));
        $tplshow = 'dathangtruoc.tpl';
        if(SUBDOMAIN == 'm')
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$tplshow);
        else
            $this->registry->smarty->display($this->registry->smartyControllerContainer.$tplshow);

        $this->registry->smarty->assign(array('contents' => $contents,
                                               'pageTitle' => $this->registry->lang['controller']['muanhanh'],
                                            ));
        if(SUBDOMAIN == 'm')
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');  //smartyControllerContainerRoot
        /*else
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl'); */ //smartyControllerContainerRoot
    }

    private function addToOrderNoCart($formData)
    {
        if(empty($formData['myProduct'])) return false;

        //Lưu xuống CSDL
        $formData['femail'] = strip_tags($formData['femail']);
        $formData['ffullname'] = strip_tags($formData['ffullname']);
        $formData['faddress'] = strip_tags($formData['faddress']);
        $formData['fphonenumber'] = strip_tags($formData['fphonenumber']);
        $currentOrder = new Core_Orders();
        $currentOrder->uid = $uid;
        //$currentOrder->invoiceid = Core_Orders::getInvoicedCode();
        $currentOrder->pricesell = $formData['myProduct']->prepaidprice;
        $currentOrder->pricediscount = 0;
        $currentOrder->pricefinal = $formData['myProduct']->prepaidprice;
        $currentOrder->contactemail = $formData['femail'];
        $currentOrder->billinggender = (($formData['fgender']==1)?Core_User::GENDER_MALE:Core_User::GENDER_FEMALE);;
        $currentOrder->billingfullname = $formData['ffullname'];
        $currentOrder->billingphone = $formData['fphonenumber'];
        $currentOrder->billingaddress = $formData['faddress'];
        $currentOrder->billingregionid = $formData['myregion'];
        $currentOrder->billingdistrict = $formData['fdistrict'];
        $currentOrder->shippingfullname = $formData['ffullname'];
        $currentOrder->shippingphone = $formData['fphonenumber'];
        $currentOrder->shippingaddress = $formData['faddress'];
        $currentOrder->shippingregionid = $formData['myregion'];
        $currentOrder->shippingdistrict = $formData['fdistrict'];
        //$currentOrder->shippinglat = $formData['ffullname'];
        //$currentOrder->shippinglng = $formData['ffullname'];
        $currentOrder->ipaddress = Helper::getIpAddress(true);
        //$currentOrder->paymentmethod = ;
        $currentOrder->deliverymethod = $formData['ftransfer'];
        $currentOrder->status = Core_Orders::STATUS_PENDING;
        $currentOrder->note = strip_tags($formData['fnotedattruoc']);
        if (isset($formData['fpaymentmethod'])) {
            $currentOrder->paymentmethod = $formData['fpaymentmethod'];
        }
        //if(!empty($formData['fprogrameid'])) $currentOrder->promotionid = $formData['fprogrameid'];
        $currentOrder->promotionid = (int)$formData['fprogrameid'];
        $currentOrder->datecreated = time();

        $stringtogetshippingfee = 'sescart_shippingfee';
        if (!empty($listproductid)) {
            $stringtogetshippingfee .= md5($formData['myProduct']->id . '-1');
            if (!empty($_SESSION[$stringtogetshippingfee])) {
                $currentOrder->priceship = $_SESSION[$stringtogetshippingfee];
                $currentOrder->pricefinal += $currentOrder->priceship;
                unset($_SESSION[$stringtogetshippingfee]);
            }
        }

        $idorder = $currentOrder->addData();
        //$crm_listpro = array();
        if($idorder)
        {
            //generate invoicedid
            $currentOrder->invoiceid = $currentOrder->getInvoicedCode();
            if($currentOrder->invoiceid !='')
            {
                $currentOrder->updateData();
                //Thêm xuống order detail
                //$ctnit = 0;
                $orderdetail = new Core_OrdersDetail();
                $orderdetail->oid = $idorder;
                $orderdetail->pid = $formData['myProduct']->id;
                $orderdetail->pricesell = $formData['myProduct']->sellprice;
                $orderdetail->pricediscount = 0;
                $orderdetail->pricefinal = $formData['myProduct']->prepaidprice;
                $orderdetail->quantity = 1;
                $orderdetail->options = array('regionid' => $formData['myregion']);
                if(!empty($formData['promotionid'])){
                    $orderdetail->options['promotionid'] = $formData['promotionid'];
                }
                $orderdetail->addData();
                $_SESSION['user_fullname'] = $formData['ffullname'];
                $_SESSION['user_email'] = $formData['femail'];
                $_SESSION['user_address'] = $formData['faddress'];
                $_SESSION['user_phonenumber'] = $formData['fphonenumber'];
                $_SESSION['ses_orderidsuccess'] = $idorder;
                //send background job
                $taskUrl = $this->registry->conf['rooturl'] . 'task/ordercrm?debug=1';
                Helper::backgroundHttpPost($taskUrl, 'oid='.$idorder);
                return $currentOrder->invoiceid;
            }
            else{
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function addcartajaxAction()
    {
        if (!empty($_SERVER['HTTP_REFERER']) && !empty($_SESSION['ses_savingsessionproductid']) && count($_SESSION['ses_savingsessionproductid']) > 0)
        {
            $error = array();
            $jsonreturn = array('success' => 2);
            if($this->addtocartValidate(array(), $error))
            {

                $listids = $_SESSION['ses_savingsessionproductid'];
                if (empty($error))
                {
                    foreach($listids as $pid)
                    {
                        $quantity = 1;
                        $options = array('promotionid' => 0, 'regionid' => self::REGION_HCM);
                        $this->registry->cart->addItem($pid, $quantity, $options);
                        $this->registry->cart->saveToSession();
                    }
                    if (!empty($_POST['id']) && !in_array($_POST['id'] ,$listids))
                    {
                        $quantity = 1;
                        $options = array('promotionid' => 0, 'regionid' => self::REGION_HCM);
                        $this->registry->cart->addItem($_POST['id'], $quantity, $options);
                        $this->registry->cart->saveToSession();
                    }
                    $jsonreturn['success'] = 1;
                    unset($_SESSION['ses_savingsessionproductid']);
                }
            }
            echo json_encode($jsonreturn);
        }
    }
    public function showgiftAction()
    {
        $invoicedid = $this->registry->router->getArg('invoiceid');
        if(!empty($_SESSION['invoicedid']) && $_SESSION['invoicedid'] == $invoicedid)
        {
            $orders = Core_Orders::getOrderss(array('finvoiceid'=>$invoicedid),'','','0,1');
            $order = $orders[0];
            $giftOrder = Core_Giftorder::getGiftorders(array('fpricein'=>$order->pricefinal,'fisactive'=>1),'fpriceto','DESC','0,1');
            //$giftProduct = array();
            if (!empty($giftOrder)) {
                $giftOrder = $giftOrder[0];
                $giftOrderProduct = Core_Giftorderproduct::getGiftorderproducts(array('fgoid'=>$giftOrder->id,'fhavestock'=>1,'fstatus'=>Core_Giftorderproduct::STATUS_ENABLE),'rand','');
                if (!empty($giftOrderProduct)) {
                    foreach ($giftOrderProduct as $gift => $giftOP) {
                        $product = new Core_Product($giftOP->productid);
                        $giftProduct[] = $product;
                    }
                }
            }
            $totalProductGift = count($giftProduct);
            if ($totalProductGift == 1) {
                $giftProduct[1] = $giftProduct[0];
                $giftProduct[2] = $giftProduct[0];
            }
            if ($totalProductGift == 2){
                $giftProduct[2] = $giftProduct[1];
            }
            $this->registry->smarty->assign(array(
                'giftProduct'=>$giftProduct,
                'invoiceid' => $invoicedid
            ));
            $this->registry->smarty->display($this->registry->smartyControllerContainer . 'productgift.tpl');
        }
    }
    public function updatecheckoutgiftAction()
    {
        $invoicedid = $_POST['invoicedid'];
        //$productid = $_POST['productid'];
        $orders = Core_Orders::getOrderss(array('finvoiceid'=>$invoicedid),'','','0,1');
        $order = $orders[0];
        $giftOrder = Core_Giftorder::getGiftorders(array('fpricein'=>$order->pricefinal,'fisactive'=>1),'fpriceto','DESC','0,1');
        //$giftProduct = array();
        if (!empty($giftOrder)) {
            $giftOrder = $giftOrder[0];
            $giftOrderProduct = Core_Giftorderproduct::getGiftorderproducts(array('fgoid'=>$giftOrder->id,'fhavestock'=>1,'fstatus'=>Core_Giftorderproduct::STATUS_ENABLE),'rand','');
            if (!empty($giftOrderProduct)) {
                foreach ($giftOrderProduct as $gift => $giftOP) {
                    $product = new Core_Product($giftOP->productid);
                    $giftProduct[] = $product->id;
                }
            }
        }
        if(count($giftProduct) > 0)
        {
            if(!empty($_SESSION['invoicedid']) && $_SESSION['invoicedid'] == $invoicedid)
            {
                $orders = Core_Orders::getOrderss(array('finvoiceid'=>$invoicedid),'','','0,1');
                $order = $orders[0];
                //Xu ly update
                $myOrder = new Core_Orders($order->id);
                if($myOrder->id > 0)
                {
                    $product = new Core_Product($giftProduct[0]);
                    if($product->id > 0)
                    {
                        $productgift = 'Sản phẩm tặng kèm : Mã sản phẩm : '.$product->id.' , Tên sản phẩm: '.$product->name;
                        $myOrder->note = $productgift;
                        if($myOrder->updateData())
                        {
                            echo $product->id;
                            //header('Location: '.$this->registry->conf['rooturl'].'cart/success?o='.$order->invoicedid.'&p='.$productid);
                        }
                    }
                }
            }
        } else {
            //User bấm nút tắt . chỉ đẩy đơn hàng vào crm
            echo '2';
        }
        //header('Location: '.$this->registry->conf['rooturl'].'cart/success?o='.$order->invoicedid);
        $taskUrl = $this->registry->conf['rooturl'] . 'task/ordercrm?debug=1';
        file_put_contents('uploads/backgroundjob.txt','uid=' . $uid.'&oid='.$order->id);
        Helper::backgroundHttpPost($taskUrl, 'oid='.$order->id);
        exit();
    }
    public function checkoutajaxAction()
    {
        $formData['fregion'] = self::REGION_HCM;

        $formData = $_POST;
        if($this->checkValidatePaymentForm($formData, $error))
        {
            $invoicedid = $this->addToOrder($formData);
            if(!empty($invoicedid))
            {
                $_SESSION['invoicedid'] = $invoicedid;
                $this->registry->cart->emptyCart();
                $this->registry->cart->saveToSession();
                echo $invoicedid;
            }
            else {
                //header('Location: '.$this->registry->conf['rooturl'].'cart/fail');
                exit();
            }
        }

    }

    /* ĐỐI VỚI CỘT ORDER trong SETTING
        1: Tính lúc vừa mới lấy từ bảng giá trị ra
        2: Tính tổng từ 1 rồi + 2
        3: 2 + 3 + VXVS (TTC OR SBP)
        4: lấy tất cả + 4
    */
    public function shippingfeeajaxAction()
    {
        global $db;
        $results = array();
        $hasproductids = '';
        $totalquantities = 0;
        $totalprices = 0;
        $listpids = array();

        $listcartitems = $this->registry->cart->getContents();
        $totalofcartitem = count($listcartitems);
        $results['nosupport'] = 1;
        $results['fee'] = 0;
        if (!empty($_POST['myregion']) && !empty($_POST['fdistrict']) && $totalofcartitem > 0) {
            //Tim ra tinh di dua vao san pham, nhung hien nay lay tphcm la tinh mac dinh
            $regionstart = 3;
            $regionend = $_POST['myregion'];//$_POST['rid'];
            $districtend = $_POST['fdistrict'];//$_POST['rsid'];
            $totalweight = 0;
            $ttcpricefee = 0;
            $sbppricefee = 0;

            for($i = 0; $i < $totalofcartitem; $i++)
            {
                $myProduct = new Core_Product($listcartitems[$i]->id, true);
                if ($myProduct->id <= 0) {
                    continue;
                }
                if($myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR) {
                    $productMain = Core_Product::getMainProductFromColor($myProduct->id);
                    if(!empty($productMain)) {
                        $myProduct->status = $productMain->status;
                        $myProduct->length = $productMain->length;
                        $myProduct->height = $productMain->height;
                        $myProduct->width = $productMain->width;
                        $myProduct->weight = $productMain->weight;
                    } else {
                        continue;
                    }
                }
                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion(trim($myProduct->barcode), self::REGION_HCM);
                if($finalprice <= 0)
                {
                    $finalprice = $myProduct->sellprice;
                }

                //$firstprice = 0;

                if(!empty($listcartitems[$i]->options['promotionid'])) {
                    $promotioninfo = Core_Promotion::getOnePromotionbyID($listcartitems[$i]->options['promotionid'], self::REGION_HCM, trim($myProduct->barcode));
                    if(!empty($promotioninfo['promotiongroup']))
                    {
                        foreach($promotioninfo['promotiongroup'] as $pg)
                        {
                            if((int)$pg->discountvalue > 0)
                            {
                                if($pg->isdiscountpercent == 1) {
                                    $finalprice = $finalprice - ((double)$finalprice*(double)$pg->discountvalue/100);
                                }
                                else {
                                    $finalprice = $finalprice - $pg->discountvalue;
                                }
                                //$firstprice = $myProduct->sellprice;
                                break;
                            }
                        }
                    }
                }
                $totalprices += ($listcartitems[$i]->quantity * $finalprice);
                $totalquantities += $listcartitems[$i]->quantity;

                $volume = ($myProduct->width * $myProduct->length * $myProduct->height) / 6000;
                if ($volume > $myProduct->weight) {
                    $totalweight += ($volume * $listcartitems[$i]->quantity);
                } else {
                    $totalweight += ($myProduct->weight * $listcartitems[$i]->quantity);
                }

                $listpids[] = $myProduct->id;
            }
            $hasproductids = implode(',', $listpids) . '-' . $totalquantities;

            if ($totalweight > 0 && $totalprices > 0) {
                $ttctotaldiscountpercent = array();
                $ttctotaldiscountprice = array();
                $sbptotaldiscountpercent = array();
                $sbptotaldiscountprice = array();
                $ttcordertocalculate = array();
                $sbpordertocalculate = array();

                $myCacher = new Cacher('shippingfeeprovince_'.$regionstart.'_'.$regionend, Cacher::STORAGE_MEMCACHED);
                $cacheshippingprovince = $myCacher->get();
                unset($myCacher);

                $myCacher = new Cacher('shippingfeeprice', Cacher::STORAGE_MEMCACHED);
                $cacheshippingprice = $myCacher->get();
                unset($myCacher);

                $myCacher = new Cacher('shippingfeesettings', Cacher::STORAGE_MEMCACHED);
                $cacheshippingsettings = $myCacher->get();
                unset($myCacher);

                $myCacher = new Cacher('shippingfeelabel', Cacher::STORAGE_MEMCACHED);
                $cacheshippinglabel = $myCacher->get();

                unset($myCacher);

                $myCacher = new Cacher('shippingfeevxvsttc_'.$regionend, Cacher::STORAGE_MEMCACHED);
                $cacheshippingvxvsttc = $myCacher->get();

                unset($myCacher);

                //tinh price plug nếu nó lớn hơn 10kg (weight plus)
                $wegithplus = 0;

                if ($totalweight > 10) {
                    $wegithplus = (($this->ceiling($totalweight, 0.5) - 10) / 0.5);
                }
                if (!empty($cacheshippingprovince) && !empty($cacheshippingprice) && !empty($cacheshippingsettings) && !empty($cacheshippinglabel) && !empty($cacheshippingvxvsttc)) {
                    $cacheshippingprovince = json_decode($cacheshippingprovince, true);
                    $cacheshippingprice = json_decode($cacheshippingprice, true);
                    $cacheshippingsettings = json_decode($cacheshippingsettings, true);
                    $cacheshippinglabel = json_decode($cacheshippinglabel, true);
                    $cacheshippingvxvsttc = json_decode($cacheshippingvxvsttc, true);
                    if (!empty($cacheshippingprovince[$districtend])) {
                        $ttcexplode = explode(';', $cacheshippingprovince[$districtend]['ttc']);
                        $sbpexplode = explode(';', $cacheshippingprovince[$districtend]['sbp']);

                        $ttcfromkm = 0;
                        $ttctokm = 0;
                        $ttcissupport = 0;
                        $ttcisdeeparea = 0;

                        $sbparea = 'Không phục vụ';
                        $sbpissupport = 0;
                        $sbpisdeeparea = 0;

                        if (!empty($ttcexplode[0])) {
                            $explodekm = explode('-', $ttcexplode[0]);
                            if (!empty($explodekm)) {
                                $ttctokm = $explodekm[0];
                                $ttctokm = $explodekm[1];
                            }
                        }
                        if (!empty($ttcexplode[1])) {
                            $ttcissupport = $ttcexplode[1];
                        }
                        if (!empty($ttcexplode[2])) {
                            $ttcisdeeparea = $ttcexplode[2];
                        }

                        if (!empty($sbpexplode[0])) {
                            $sbparea = $sbpexplode[0];
                        }
                        if (!empty($sbpexplode[1])) {
                            $sbpissupport = $sbpexplode[1];
                        }
                        if (!empty($sbpexplode[2])) {
                            $sbpisdeeparea = $sbpexplode[2];
                        }
                        //get fee from setting fee
                        foreach ($cacheshippingsettings as $fee) {
                            if (Core_ShippingfeeSettings::TYPEFEE_TTC == $fee['typefee']) {
                                $ttcordertocalculate[] = $fee['order'];
                                if ($fee['ispercent'] == 1) {
                                    $ttctotaldiscountpercent[$fee['order']][] = $fee['price'];
                                } else {
                                    $ttctotaldiscountprice[$fee['order']][] = $fee['price'];
                                }
                            } else {
                                $sbpordertocalculate[] = $fee['order'];
                                if ($fee['ispercent'] == 1) {
                                    $sbptotaldiscountpercent[$fee['order']][] = $fee['price'];
                                } else {
                                    $sbptotaldiscountprice[$fee['order']][] = $fee['price'];
                                }
                            }
                        }
                        if ($ttcissupport > 0) {
                            $getfeefromdb = $this->getweightitem($cacheshippingprice, $totalweight, $ttcfromkm, $ttctokm);
                            if (!empty($getfeefromdb)) {

                                foreach ($getfeefromdb as $fee) {
                                    $ttcpricefee += ($fee['price'] + ($fee['priceplus'] * $wegithplus));
                                }

                                //tinh vung sau vung xa cua ttc
                                $feevxvs = 0;
                                if ($ttcisdeeparea > 0) {
                                    if (!empty($cacheshippingvxvsttc[$districtend])) {
                                        if ($totalweight < 30) {
                                            $feevxvs += $cacheshippingvxvsttc[$districtend]['less30kg'];
                                        } else {
                                            $feevxvs += $cacheshippingvxvsttc[$districtend]['from30kg'];
                                        }
                                    }
                                }

                                if (!empty($ttcordertocalculate)) {
                                    asort($ttcordertocalculate);
                                    foreach ($ttcordertocalculate as $ttcorder) {
                                        //phi vung xau vung xa hien tai order = 4
                                        if ($ttcorder == 4) {
                                            $ttcpricefee += $feevxvs;
                                        } else {
                                            if (!empty($ttctotaldiscountpercent[$ttcorder])) {
                                                foreach ($ttctotaldiscountpercent[$ttcorder] as $iprice) {
                                                    $ttcpricefee += ($ttcpricefee * $iprice / 100);
                                                }
                                            } elseif (!empty($ttctotaldiscountprice[$ttcorder])) {
                                                foreach ($ttctotaldiscountprice[$ttcorder] as $iprice) {
                                                    $ttcpricefee += $iprice;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            unset($cacheshippingprice);
                            unset($getfeefromdb);
                        }

                        if ($sbpissupport > 0) {
                            $getfeefromdb = $this->getweightitembyarea($cacheshippingprice, $totalweight, $sbparea);
                            if (!empty($getfeefromdb)) {
                                foreach ($getfeefromdb as $fee) {
                                    //tinh price plus
                                    $sbppricefee += ($fee['price'] + ($fee['priceplus'] * $wegithplus));
                                }

                                if (!empty($sbpordertocalculate)) {
                                    asort($sbpordertocalculate);
                                    foreach ($sbpordertocalculate as $ttcorder) {
                                        if (!empty($sbptotaldiscountpercent[$ttcorder])) {
                                            foreach ($sbptotaldiscountpercent[$ttcorder] as $iprice) {
                                                $sbppricefee += ($sbppricefee * $iprice / 100);
                                            }
                                        } elseif (!empty($sbptotaldiscountprice[$ttcorder])) {
                                            foreach ($sbptotaldiscountprice[$ttcorder] as $iprice) {
                                                $sbppricefee += $iprice;
                                            }
                                        }
                                    }
                                }
                            }
                            unset($cacheshippingprice);
                            unset($getfeefromdb);
                        }
                        if ($ttcpricefee > 0 && $ttcpricefee < $sbppricefee) {
                            $results['fee'] = $ttcpricefee;
                        } elseif ($sbppricefee > 0 && $ttcpricefee > $sbppricefee) {
                            $results['fee'] = $sbppricefee;
                        } elseif ($ttcpricefee == 0) {
                            $results['fee'] = $sbppricefee;
                        } elseif ($sbppricefee == 0) {
                            $results['fee'] = $ttcpricefee;
                        }
                        $results['nosupport'] = 2;
                    }
                } else {
                    $getshippingfeedienmay = Core_ShippingfeeDienmay::getShippingfeeDienmays(array('fprovincestart' => $regionstart,
                                                                                               'fprovinceend' => $regionend,
                                                                                               'fdistrictend' => $districtend
                                                                                            ), '', '', '0,1');

                    if (!empty($getshippingfeedienmay) && !empty($listpids)) {
                        $ttcexplode = explode(';', $getshippingfeedienmay[0]->ttc);
                        $sbpexplode = explode(';', $getshippingfeedienmay[0]->sbp);
                        $ttcfromkm = 0;
                        $ttctokm = 0;
                        $ttcissupport = 0;
                        $ttcisdeeparea = 0;

                        $sbparea = 'Không phục vụ';
                        $sbpissupport = 0;
                        $sbpisdeeparea = 0;

                        if (!empty($ttcexplode[0])) {
                            $explodekm = explode('-', $ttcexplode[0]);

                            if (!empty($explodekm)) {
                                $ttcfromkm = $explodekm[0];
                                $ttctokm = $explodekm[1];
                            }
                        }
                        if (!empty($ttcexplode[1])) {
                            $ttcissupport = $ttcexplode[1];
                        }
                        if (!empty($ttcexplode[2])) {
                            $ttcisdeeparea = $ttcexplode[2];
                        }

                        if (!empty($sbpexplode[0])) {
                            $sbparea = $sbpexplode[0];
                        }
                        if (!empty($sbpexplode[1])) {
                            $sbpissupport = $sbpexplode[1];
                        }
                        if (!empty($sbpexplode[2])) {
                            $sbpisdeeparea = $sbpexplode[2];
                        }
                        //get fee from setting fee
                        $getsettingfees = Core_ShippingfeeSettings::getShippingfeeSettingss(array(), '', '');

                        if (!empty($getsettingfees)) {
                            foreach ($getsettingfees as $fee) {
                                if (Core_ShippingfeeSettings::TYPEFEE_TTC == $fee->typefee) {
                                    $ttcordertocalculate[] = $fee->order;
                                    if ($fee->ispercent == 1) {
                                        $ttctotaldiscountpercent[$fee->order][] = $fee->price;
                                    } else {
                                        $ttctotaldiscountprice[$fee->order][] = $fee->price;
                                    }
                                } else {
                                    $sbpordertocalculate[] = $fee->order;
                                    if ($fee->ispercent == 1) {
                                        $sbptotaldiscountpercent[$fee->order][] = $fee->price;
                                    } else {
                                        $sbptotaldiscountprice[$fee->order][] = $fee->price;
                                    }
                                }
                            }
                        }

                        if ($ttcissupport > 0) {
                            $getfeefromdb = Core_ShippingfeePrices::getShippingfeePricess(array('fdistancemin' => $ttcfromkm,
                                                                                            'fdistancemax' => $ttctokm,
                                                                                            'fcompareweight' => ($totalweight * 10),
                                                                                            'ftypefee' => Core_ShippingfeePrices::TYPE_TTC
                                                                                            ), '', '', '0,1');
                            if (!empty($getfeefromdb)) {
                                foreach ($getfeefromdb as $fee) {
                                    $ttcpricefee += ($fee->price + ($fee->priceplus * $wegithplus));
                                }
                                //Dung toi day

                                $feevxvs = 0;
                                //tinh vung sau vung xa cua ttc
                                if ($ttcisdeeparea > 0) {
                                    $getdatavxvsttc = Core_ShippingfeeVxvsTtc::getShippingfeeVxvsTtcs(array('frid' => $rid, 'fdistrictid' => $districtend), '', '', '0,1');
                                    if (!empty($getdatavxvsttc)) {
                                        if ($totalweight < 30) {
                                            $feevxvs += $getdatavxvsttc[0]->less30kg;
                                        } else {
                                            $feevxvs += $getdatavxvsttc[0]->from30kg;
                                        }
                                    }
                                }

                                if (!empty($ttcordertocalculate)) {
                                    asort($ttcordertocalculate);
                                    foreach ($ttcordertocalculate as $ttcorder) {
                                        //phi vung xau vung xa hien tai order = 4
                                        if ($ttcorder == 4) {
                                            $ttcpricefee += $feevxvs;
                                        } else {
                                            if (!empty($ttctotaldiscountpercent[$ttcorder])) {
                                                foreach ($ttctotaldiscountpercent[$ttcorder] as $iprice) {
                                                    $ttcpricefee += ($ttcpricefee * $iprice / 100);
                                                }
                                            } elseif (!empty($ttctotaldiscountprice[$ttcorder])) {
                                                foreach ($ttctotaldiscountprice[$ttcorder] as $iprice) {
                                                    $ttcpricefee += $iprice;
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                            unset($getfeefromdb);
                        }
                        //echodebug($sbpissupport.'--'.$sbparea.'---'.$totalweight);
                        if ($sbpissupport > 0) {

                            $getfeefromdb = Core_ShippingfeePrices::getShippingfeePricess(array('farea' => $sbparea,
                                                                                            'fcompareweight' => ($totalweight * 10),
                                                                                            'ftypefee' => Core_ShippingfeePrices::TYPE_SBP
                                                                                            ), '', '', '0,1');

                            if (!empty($getfeefromdb)) {
                                foreach ($getfeefromdb as $fee) {
                                    $sbppricefee += ($fee->price + ($fee->priceplus * $wegithplus));
                                }

                                if (!empty($sbpordertocalculate)) {
                                    asort($sbpordertocalculate);
                                    foreach ($sbpordertocalculate as $ttcorder) {
                                        if (!empty($sbptotaldiscountpercent[$ttcorder])) {
                                            foreach ($sbptotaldiscountpercent[$ttcorder] as $iprice) {
                                                $sbppricefee += ($sbppricefee * $iprice / 100);
                                            }
                                        } elseif (!empty($sbptotaldiscountprice[$ttcorder])) {
                                            foreach ($sbptotaldiscountprice[$ttcorder] as $iprice) {
                                                $sbppricefee += $iprice;
                                            }
                                        }
                                    }
                                }
                            }
                            unset($getfeefromdb);
                        }

                        if ($ttcpricefee > 0 && $ttcpricefee < $sbppricefee) {
                            $results['fee'] = $ttcpricefee;
                        } elseif ($sbppricefee > 0 && $ttcpricefee > $sbppricefee) {
                            $results['fee'] = $sbppricefee;
                        } elseif ($ttcpricefee == 0 && $sbppricefee >0) {
                            $results['fee'] = $sbppricefee;
                        } elseif ($sbppricefee == 0 && $ttcpricefee >0) {
                            $results['fee'] = $ttcpricefee;
                        }
                        $results['nosupport'] = 2;
                    }
                }
                if (!empty($results['nosupport']) && $results['nosupport'] == 2 && !empty($results['fee']) && !empty($hasproductids)) {

                    /*sau khi tinh xong ra cai phi cuoi cung roi moi so voi gia tri don hang de xem coi co thuoc dien mien phi hay giam 50% hay ko dua vao setting fee*/
                    $getshippingsetting = Core_ShippingfeeNamefee::getShippingfeeNamefees(array('ftotalprice' => $totalprices, 'ftotalweight' => $totalweight), '', '', '0,1');
                    //echodebug($results['fee']);
                    //echodebug($getshippingsetting);
                    if (!empty($getshippingsetting)) {
                        if ($getshippingsetting[0]->ispercent == 1) {
                            $results['fee'] = $results['fee'] + ($results['fee'] * $getshippingsetting[0]->discount / 100);
                        } else {
                            $results['fee'] = $results['fee'] + $getshippingsetting[0]->discount;
                        }
                        $results['newfeemessage'] = 'PHÍ HÀNG CỒNG KỀNH (đã giảm 50%)';
                    } else {
                        $results['newfeemessage'] = '';
                    }
                    $_SESSION['sescart_shippingfee'.md5($hasproductids)] = $results['fee'];
                    $results['totalfinalprice'] = Helper::formatPrice($totalprices + $results['fee']);
                    $results['totalprices'] = Helper::formatPrice($totalprices);
                    $results['fee'] = Helper::formatPrice($results['fee']);
                }
            }
        }
        echo json_encode($results);
    }

    public function shippingtimeAction()
    {
        if (!empty($_POST['rid'])) {
            $regionstart = 3;
            $regionend = $_POST['rid'];
            //chua xac dinh duoc cai huyen nen chua lay duoc km

            $myCacher = new Cacher('shippingfeeprovince_'.$regionstart.'_'.$regionend, Cacher::STORAGE_MEMCACHED);
            $cacheshippingprovince = $myCacher->get();
            if (!empty($cacheshippingprovince)) {

            } else {
                $getshippingfeedienmay = Core_ShippingfeeDienmay::getShippingfeeDienmays(array('fprovincestart' => $regionstart,
                                                                                               'fprovinceend' => $regionend
                                                                                            ), '', '', '0,1');
            }
        }
    }

    private function getweightitem($arrayval = array(), $totalweight, $ttcfromkm, $ttctokm)
    {
        $arrayreturn = array();
        foreach ($arrayval as $val) {
            $weightincrease = ($totalweight * 10);
            if ($val['distancemin'] == $ttcfromkm
                && $val['distancemax'] == $ttctokm
                && ($val['weightmin'] <= $weightincrease || $val['weightmin'] == 0)
                && ($val['weightmax'] > $weightincrease || $val['weightmax'] == 0)
                && Core_ShippingfeePrices::TYPE_SBP == $val['weightmax']) {
                $arrayreturn[] = $val;
                break;
            }
        }
        return $arrayreturn;
    }

    private function getweightitembyarea($arrayval = array(), $totalweight, $sbparea)
    {
        $arrayreturn = array();
        foreach ($arrayval as $val) {
            $weightincrease = ($totalweight * 10);
            if (Helper::codau2khongdau($val['area'], true, true) == Helper::codau2khongdau($sbparea, true, true)
                && ($val['weightmin'] <= $weightincrease || $val['weightmin'] == 0)
                && ($val['weightmax'] > $weightincrease || $val['weightmax'] == 0)
                && Core_ShippingfeePrices::TYPE_SBP == $val['weightmax']) {
                $arrayreturn[] = $val;
                break;
            }
        }
        return $arrayreturn;
    }

    private function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }
}
