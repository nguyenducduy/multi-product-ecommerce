<?php
Class Controller_Wse_Cms extends Controller_Wse_Base
{
    public function indexAction()
    {

        /*--- set limit----*/
        $search          = Helper::unspecialtext(Helper::xss_clean($_POST['keysearch']));
        $productcategory = $_POST['productcategory'];
        $pageGet         = $_POST['p'];
        $recordGet       = $_POST['r'];
        $start           = $recordGet * ($pageGet - 1);
        $limit           = $start.','.$recordGet;
        $error           = array();
        if ($this->registry->me->isGroup('developer') || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('employee')) {
            if ($pageGet > 0  && $recordGet > 0) {
                if ($productcategory == 0) {
                    if ($search == '') {

                        $formData = array('fMstatus' => array(Core_Product::STATUS_ENABLE,Core_Product::STATUS_DISABLED));
                        $list = Core_Product::getProducts($formData, '', '', $limit);
                        foreach ($list as $product) {
                            $items['items'][] = $this->getDetailProduct($product);

                        }
                    } else {
                        $formData = array('fMstatus' => array(Core_Product::STATUS_ENABLE,Core_Product::STATUS_DISABLED), 'fMobile' => $search);
                        $list = Core_Product::getProducts($formData, '', '', $limit);
                        if (!empty($list)) {
                            foreach ($list as $product) {
                                $items['items'][] = $this->getDetailProduct($product);
                            }
                        } else {
                            $items['items'] = $error;
                        }
                    }
                } else {
                    $formData = array('fparentid' => $productcategory);
                    $category = Core_ProductCategory::getProductcategorys($formData, '', '', '');
                    if (!empty($category)) {
                        foreach ($category as $key => $value) {
                            $catList[] = $value->id;
                        }
                        $formData = array('fMobile' => $search, 'fpcidarrin' => $catList,'fMstatus' => array(Core_Product::STATUS_ENABLE,Core_Product::STATUS_DISABLED));
                    } else {
                        $formData = array('fMobile' => $search, 'fpcid' => $productcategory, 'fMstatus' => array(Core_Product::STATUS_ENABLE,Core_Product::STATUS_DISABLED));
                    }

                    $list = Core_Product::getProducts($formData, '', '', $limit);
                    if (!empty($list)) {
                        foreach ($list as $product) {
                            $items['items'][] = $this->getDetailProduct($product);
                        }
                    } else {
                        $items['items'] = $error;
                    }
                    
                }
            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = 'Permission';
        }
        
        echo json_encode($items);
        
    }
    public function summaryAction()
    {
        $pid     = $_POST['pid'];
        $error   = array();
        $product = new Core_Product($pid, true);
        if ($product->id != '' || $product->id > 0) {

            $productcategory[] = $product->pcid;
            $getCategory       = Core_ProductCategory::getFullParentProductCategoryId($product->pcid);
            $categoryList      = array_merge($getCategory, $productcategory);
            $items['summary']  = $this->getDetailProduct($product);
            foreach ($categoryList as $key => $value) {
                $list = new Core_ProductCategory($value, true);
                $items['summary']['category'][] = $list->name;
            }

        } else {
            $items['summary'] = $error;
        }
        
        echo json_encode($items);
    }
    public function galleryAction()
    {
        $pid     = $_POST['pid'];
        $error   = array();
        if ($pid != '') {
            $gallery = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_FILE, 'fpid' => $pid), '', '', '');
            if (!empty($gallery)) {
                foreach ($gallery as $key => $value) {
                    if ($value->file == '') {
                        $res['link'] = '';
                    } else {
                        $res['link'] = (string)$this->getImage($value->file, false);
                    }

                    $items['items'][] = $res;
                }   
            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function attributeAction()
    {
        $pid   = $_POST['pid'];
        $error = array();
        if ($pid != '') {
            $product = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $pid), '', '', '');
            foreach ($product as $key => $value) {
                $att         = new Core_ProductAttribute($value->paid);
                $group       = new core_ProductGroupAttribute($att->pgaid);
                $res['name'] = (string)$att->name;

                if ($value->value == '-' || $value->value == '') {
                    $res['value'] = 'Đang cập nhật';
                } else {
                    $res['value'] = (string)str_replace('<br>', ', ', $value->value . ' ' . $att->unit);
                }

                if ($group->name != '') {
                    $items[$group->name][] = $res;
                }
            }

            foreach ($items as $key => $value) {
                $short['groupname'] = $key;
                $short['options']   = $value;
                $items['items'][]  = $short;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function stockAction()
    {
        $barcode = $_POST['barcode'];
        $error   = array();
        if ($barcode != '') {
            $stockTotal    = Core_Product::getProducts(array('fbarcode' => $barcode), '', '', 1);
            $stockPerStore = Core_ProductStock::getProductStocks(array('fpbarcode' => $barcode , 'fhavequantity' => true), '', '', '');

            if (!empty($stockPerStore)) {   
                $items['total'] = (int)$stockTotal[0]->instock;               
                foreach ($stockPerStore as $key => $value) {

                    $store               = new Core_Store($value->sid);
                    $res['storeid']      = (int)$store->id;
                    $res['storegroupid'] = (int)$store->storegroupid;
                    $res['storetypeid']  = (int)$store->storetypeid;
                    $res['companytitle'] = (string)$store->companytitle;
                    $res['storename']    = (string)$store->storeshortname;
                    $res['storeaddress'] = (string)$store->storeaddress;
                    $res['storephone']   = (string)$store->storephonenum;
                    $res['taxcode']      = (string)$store->taxcode;
                    $res['stock']        = (int)$value->quantity;
                    $items['items'][]    = $res;
                }
            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function priceAreaAction()
    {
        $barcode       = $_POST['barcode'];
        $error         = array();
        if ($barcode != '') {
            $pricePerStore = Core_ProductPrice::getProductPrices(array('fpbarcode' => $barcode), '', '', '');
            if (!empty($pricePerStore)) {   
                foreach ($pricePerStore as $key => $value) {
                    $store                  = new Core_Store($value->sid);
                    $region                 = new Core_Region($value->rid, true);
                    $res['storeid']         = (int) $store->id;
                    $res['storegroupid']    = (int) $store->storegroupid;
                    $res['storetypeid']     = (int) $store->storetypeid;
                    $res['companytitle']    = (string) $store->companytitle;
                    $res['storename']       = (string) $store->storeshortname;
                    $res['storeaddress']    = (string) $store->storeaddress;
                    $res['storephone']      = (string) $store->storephonenum;
                    $res['taxcode']         = (string) $store->taxcode;
                    $res['price']           = Helper::formatPrice($value->sellprice);
                    $group[$region->name][] = $res;
                }
            } else {
                $items['items'] = $error;
            }
            
            if (!empty($group)) {
                foreach ($group as $key => $value) {
                    if($key == '')
                        $item['region'] = 'Etown';
                    else
                        $item['region'] = (string)$key;

                    $item['stores'] = $value;
                    $items['items'][] = $item;
                }
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function viewAction()
    {   
        $pid   = $_POST['pid'];
        $error = array();

        if ($_POST['start'] != '' && $_POST['end'] != '' && $pid > 0) {

            $start = strtotime($_POST['start']);
            $end   = strtotime($_POST['end']);
       
            $view = Core_Stat::getData(Core_Stat::TYPE_VIEW, array('product' => $pid), $start, $end);
            if (!empty($view)) {
                foreach ($view as $key => $value) {
                    $res['time']      = (string)$key;
                    $res['view']      = (int)$value;
                    $items['items'][] = $res;
                }
            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function priceVsAction()
    {
        $pid   = $_POST['pid'];
        $error = array();
        if ($pid != '') {
            $price = Core_PriceEnemy::getPriceEnemys(array('fpid' => $pid), '', '', '');
            if (!empty($price)) {
                foreach ($price as $key => $value) {
                    
                    $shop = new Core_Enemy($value->eid);
                    
                    if ($shop->id != '') {

                        if ($value->pricepromotion > 0 || $value->priceauto > 0) {
                            $res['pid']         = (int)$value->pid;
                            $res['uid']         = (int)$value->uid;
                            $res['eid']         = (int)$value->eid;
                            $res['productname'] = (string)trim($value->productname);
                            $res['image']       = (string)$value->image;
                            $res['storename']   = (string)trim($shop->name);
                            $res['producturl']  = (string)$value->url;
                            $res['type']        = (int)$value->type;

                            if ($value->priceauto > 0) {
                                $res['price'] = (string)Helper::formatPrice($value->priceauto);
                            } else {
                                $res['price'] = '';
                            }

                            if ($value->pricepromotion > 0) {
                                $res['pricepromotion'] = (string)Helper::formatPrice($value->pricepromotion);
                            } else {
                                $res['pricepromotion'] = '';
                            }
                            
                            $items['items'][] = $res;

                        } else {
                            $items['items'] = $error;
                        }
                    } 
                }

            } else {
                $items['items'] = $price;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function saleAction()
    {
        $pid = $_POST['pid'];
        $error     = array();
        if ($_POST['start'] != '' && $_POST['end'] != '' && $pid > 0) {
            $start = strtotime($_POST['start']);
            $end   = strtotime($_POST['end']);
        
            $sale   = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('product' => $pid), $start, $end);
            $return = Core_Stat::getData(Core_Stat::TYPE_REFUND_VOLUME, array('product' => $pid), $start, $end);
            if (!empty($sale)) {

                foreach ($sale as $key => $value) {
                    $res['time'] = (string)$key;
                    if (!empty($return[$key])) {
                        $res['num'] = (int)($value - $return[$key]);
                    } else {
                        $res['num'] = (int)$value;
                    }

                    $items['items'][] = $res;
                }
            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function commentAction()
    {
        $pid       = $_POST['pid'];
        $pageget   = $_POST['p'] ;
        $recordget = $_POST['r'];
        $start     = $recordget * ($pageget - 1);
        $limit     = $start.','.$recordget;
        $error     = array();

        if ($pageget != '' && $recordget != '' && $pid != '') {

            $view = Core_ProductReview::getProductReviews(array('fobjectid' => $pid, 'fparent' => 0), '', '', $limit);
            if (!empty($view)) {
                $total = Core_ProductReview::getProductReviews(array('fobjectid' => $pid), '', '', '', true);
                foreach ($view as $key => $value) {

                    $res   = $this->commentDetail($value);
                    $reply = Core_ProductReview::getFullReview($value);

                    if (!empty($reply)) {

                        foreach ($reply as $keys => $values) {

                            if ($values->id != $value->id) {
                                $res['replies'][] = $this->commentDetail($values);
                            } else {
                                $res['replies'] = $error;
                            }
                        }
                        
                    } else {
                        $res['replies'] = $error;
                    }
                    $items['total'] = (int)$total;
                    $items['items'][] = $res;
                }

            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function colorAction()
    {
        $pid     = $_POST['pid'];
        $error   = array();
        if ($pid != '') {
            $product = new Core_Product($pid, true);
            if ($product->id > 0) {

                $color = explode('###', $product->colorlist);
                $count = count($color);

                foreach ($color as $key => $value) {

                    if (strpos($value, ':')) {

                        $colorlist      = explode(':', $value);
                        $res['pid']     = (int)$colorlist[0];
                        $res['name']    = (string)$colorlist[2];
                        $barcode        = new Core_Product($colorlist[0], true);
                        $res['barcode'] = (string)$barcode->barcode;

                        if (strlen(trim($colorlist[3])) > 4) {
                            $res['color'] = (string)trim($colorlist[3]);
                        } else {
                            $res['color'] = '';
                        }

                        $items['items'][] = $res;

                    } else {
                        $items['items'] = $error;
                    }
                }
            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function balanceAction()
    {
        $pid   = $_POST['pid'];
        $pcid  = $_POST['pcid'];
        $error = array();
        if ($_POST['start'] != '' && $_POST['end'] != '' && $pid > 0 && $pcid >0) {
            $start = strtotime($_POST['start']);
            $end   = strtotime($_POST['end']);
        
            $sale     = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('product' => (int)$pid), $start, $end);
            $saleReturn   = Core_Stat::getData(Core_Stat::TYPE_REFUND_VOLUME, array('product' => (int)$pid), $start, $end);
            $category = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('category' => (int)$pcid), $start, $end);
            $categoryReturn = Core_Stat::getData(Core_Stat::TYPE_REFUND_VOLUME, array('category' => (int)$pcid), $start, $end);
            if (!empty($sale) && !empty($category)) {

                foreach ($sale as $key => $value) {
                    if (!empty($saleReturn[$key])) {
                        $res = (int)($value - $saleReturn[$key]);
                    } else {
                        $res = (int)$value;
                    }
                    $sales[] = $res;
                }
                
                foreach ($category as $key => $value) {
                    if(!empty($categoryReturn)) {
                        $return = (int)($value - $categoryReturn[$key]);
                    } else {
                        $return = (int)$value;
                    }
                    $returns[] = $return;
                }
                $items['product'] = (int)array_sum($sales);
                $items['category'] = (int)array_sum($returns);

            } else {
                $items['items'] = $error;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items);
    }
    public function getDetailProduct($formData)
    {
        $product          = $formData;
        $items['uid']     = (int)$product->uid;
        $items['vid']     = (int)$product->vid;
        $items['vsubid']  = (int)$product->vsubid;
        $items['pcid']    = (int)$product->pcid;
        $items['pid']     = (int)$product->id;
        $items['barcode'] = (string)$product->barcode;
        $items['name']    = (string)htmlspecialchars_decode($product->name);        
        $items['slug']    = (string)$product->slug;
        
        $sellprice        = str_replace('.', '', $product->sellprice);
        $finalprice       = str_replace('.', '', $product->finalprice);
        
        if ($sellprice == 0 && $finalprice == 0) {
            $items['finalprice']     = '';
            $items['promotionprice'] = '';
        } elseif ($finalprice > 0 && $sellprice == 0) {
            $items['finalprice']     = Helper::formatPrice($product->finalprice);
            $items['promotionprice'] = '';
        } elseif ($sellprice > 0 && $finalprice == 0) {
            $items['finalprice']     = Helper::formatPrice($product->sellprice);
            $items['promotionprice'] = '';
        } elseif ($sellprice > 0 && $finalprice > 0 ) {
            if ($sellprice == $finalprice) {
                $items['finalprice']     = Helper::formatPrice($product->finalprice);
                $items['promotionprice'] = '';
            } else {
                $items['finalprice']     = Helper::formatPrice($product->sellprice);
                $items['promotionprice'] = Helper::formatPrice($product->finalprice);
            }
        }

        $items['status']       = (int)$product->status;
        $items['onsitestatus'] = (int)$product->onsitestatus;
        $items['view']         = (int)$product->countview;
        $items['comment']      = (int)$product->countreview;
        $items['instock']      = (int)$product->instock;
        $items['time']         = date('H:i, d/m/Y', $product->datemodified);

        if ($product->image == '') {
            $items['avatar'] =  '';
        } else {
            $items['avatar'] = (string)$this->getImage($product->image, true);
        }

        return $items;
    }
    public function commentDetail($formData)
    {
        $res['id']       = (int)$formData->id;
        $res['pid']      = (int)$formData->objectid;
        $res['fullname'] = (string)$formData->fullname;
        $res['email']    = (string)$formData->email;
        $res['text']     = (string)trim($formData->text);
        $res['ip']       = (string)$formData->ipaddress;

        if ($formData->datecreated > 0 && $formData->datemodified > 0) {
            $res['time'] = (string)date('H:i, d/m/Y', $formData->datemodified);
        } else {
            $res['time'] = (string)date('H:i, d/m/Y', $formData->datecreated);
        }

        return $res;
    }
    public function getImage($image, $size = true)
    {
        $pos        = strrpos($image, '.');
        $extPart    = substr($image, $pos+1);
        $namePart   =  substr($image, 0, $pos);

        if ($size) {
            $file  = 'http://p.tgdt.vn/' . $namePart . '-small.' . $extPart;
        } else {
            $file  = 'http://p.tgdt.vn/' . $image;
        }

        $url = $file;
        return $url;
    }
}
?>