<?php
class Controller_Site_ProductCompare extends Controller_Site_Base
{
    public function indexAction()
    {
    	$formData = array();
    	$success = array();
    	$error = array();
    	$warning = array();
		$productGroupAttributeList = array();

    	$pid = (int)(isset($_GET['pid'])?$_GET['pid']:0);
    	$myProduct = new Core_Product($pid);

    	if($myProduct->id > 0)
    	{
    		$myProductCompareCookieExpire = time() + 24 * 3600 ;	//1 days
    		$compareProductList = array();

    		//get same product list
    		$sameproductList = Core_Product::getProducts(array('fisonsitestatus' => 1, 'fpcid' => $myProduct->pcid) , 'id' , 'ASC' , '0,10');

    		//add current product into session
    		if(!empty($_COOKIE['compareproduct']))
    		{
    			//$data = $_COOKIE['compareproduct'];
    			$comparestr = $_COOKIE['compareproduct'];
    			$compareProductList = explode(',', $comparestr);
    		}


    		if(count($compareProductList) < 3)
			{
                //if exist product not add
				if(!in_array($myProduct->id, $compareProductList))
				{
                    //echodebug($compareProductList);
					if(count($compareProductList) > 0)
                    {
                        $productsample = new Core_Product($compareProductList[0]);
                        if($productsample->pcid != $myProduct->pcid)
                        {
                            $data = implode(',', $compareProductList);
                            setcookie('compareproduct' , $data , $myProductCompareCookieExpire - time() + 24 * 3600 * 2 , '/');
                            $_COOKIE['compareproduct'] = '';

                            $compareProductList = array();
                            $compareProductList[] = $myProduct->id;
                            $data = implode(',', $compareProductList);

                            setcookie('compareproduct' , $data , $myProductCompareCookieExpire , '/');
                            $_COOKIE['compareproduct'] = $data;
                        }
                        else
                        {
                            //mysterious of cookie in new browser
                            $compareProductList[] = $myProduct->id;
                            $data = implode(',', $compareProductList);

                            setcookie('compareproduct' , $data , $myProductCompareCookieExpire , '/');
                            $_COOKIE['compareproduct'] = $data;
                            //////////////////////////////////////////////////////////////////////////
                        }
                    }
                    else
                    {
                        //mysterious of cookie in new browser
                        $compareProductList[] = $myProduct->id;
                        $data = implode(',', $compareProductList);

                        setcookie('compareproduct' , $data , $myProductCompareCookieExpire , '/');
                        $_COOKIE['compareproduct'] = $data;
                        //////////////////////////////////////////////////////////////////////////
                    }
				}
                $list = $compareProductList;
                $compareProductList = array();
                foreach($list as $id)
                {
                    $product = new Core_Product($id);
                    $compareProductList[] = $product;
                }

                //get promotion of product
                $promotionList = array();
                foreach($compareProductList as $product)
                {
                    $listData = Core_Promotion::getPromotionNameByProductID(trim($product->barcode), $this->registry->region);
                    $check = true;
                    if(is_array($listData))
                    {
                        $promotionList[$product->id] = $listData;
                    }
                }



                //get product group attribute
                $productGroupAttributeList = array();
                $pgaList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $myProduct->pcid), 'displayorder', 'ASC' , '0,5');

                //get product attribute
                $productAttributeList = array();
                foreach ($compareProductList as $product)
                {
                    foreach($pgaList as $groupAttr)
                    {
                        $list = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$myProduct->pcid , 'fpgaid' => $groupAttr->id), 'displayorder', 'ASC' , '0,10');
                        if(count($list) > 0)
                        {
                            $productGroupAttributeList[$groupAttr->id] = $groupAttr;

                            foreach($list as $attr)
                            {
                                $relproductattribute = Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$product->id , 'fpaid'=> $attr->id),'','' , '0,1');
                                $attr->value = $relproductattribute[0]->value;
                            }

                            $productAttributeList[$product->id][$groupAttr->id] = $list;
                        }
                    }
                }

                $_SESSION['pcid_compare'] = $myProduct->pcid;
			}

             else if(count($compareProductList) == 3)
            {
                $error[] = 'Số lượng sản phẩm so sánh tối đa là 3 sản phẩm . Đế tiếp tục so sánh xin vui lòng xóa bớt sản phẩm.';
                $list = $compareProductList;
                $compareProductList = array();
                foreach($list as $id)
                {
                    $product = new Core_Product($id);
                    $product->sellprice = Helper::formatPrice($product->sellprice);
                    $compareProductList[] = $product;
                }

                //get promotion of product
                $promotionList = array();
                foreach($compareProductList as $product)
                {
                    $listData = Core_Promotion::getPromotionNameByProductID(trim($product->barcode), $this->registry->region);
                    $check = true;
                    if(is_array($listData))
                    {
                        $promotionList[$product->id] = $listData;
                    }
                }



                //get product group attribute
                $productGroupAttributeList = array();
                $pgaList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $myProduct->pcid), 'displayorder', 'ASC' , '0,5');

                //get product attribute
                $productAttributeList = array();
                foreach ($compareProductList as $product)
                {
                    foreach($pgaList as $groupAttr)
                    {
                        $list = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$myProduct->pcid , 'fpgaid' => $groupAttr->id), 'displayorder', 'ASC' , '0,10');
                        if(count($list) > 0)
                        {
                            $productGroupAttributeList[$groupAttr->id] = $groupAttr;

                            foreach($list as $attr)
                            {
                                $relproductattribute = Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$product->id , 'fpaid'=> $attr->id),'','' , '0,1');
                                $attr->value = $relproductattribute[0]->value;
                            }

                            $productAttributeList[$product->id][$groupAttr->id] = $list;
                        }
                    }
                }

                $_SESSION['pcid_compare'] = $myProduct->pcid;
            }
    	}


    else if(!empty($_COOKIE['compareproduct']))
    {
        $comparestr = $_COOKIE['compareproduct'];
        $list = explode(',', $comparestr);
        $compareProductList = array();
        foreach($list as $id)
        {
            $compareProductList[] = new Core_Product($id);
        }

        //get promotion of product
            $promotionList = array();
            foreach($compareProductList as $product)
            {
                $listData = Core_Promotion::getPromotionNameByProductID(trim($product->barcode), $this->registry->region);
                $check = true;
                // if(count($listData) > 0)
                // {
                //     foreach($listData as $key=>$value)
                //     {
                //         if($key === false)
                //         {
                //             $check = false;
                //             break;
                //         }
                //     }
                // }
                if(is_array($listData))
                {
                    $promotionList[$product->id] = $listData;
                }
            }



            //get product group attribute
            $productGroupAttributeList = array();
            $pgaList = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $compareProductList[0]->pcid), 'displayorder', 'ASC' , '0,5');
            //get product attribute
            $productAttributeList = array();
            foreach ($compareProductList as $product)
            {
                foreach($pgaList as $groupAttr)
                {
                    $list = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$compareProductList[0]->pcid , 'fpgaid' => $groupAttr->id), 'displayorder', 'ASC' , '0,10');
                    if(count($list) > 0)
                    {
                        $productGroupAttributeList[$groupAttr->id] = $groupAttr;

                        foreach($list as $attr)
                        {
                            $relproductattribute = Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$product->id , 'fpaid'=> $attr->id),'','' , '0,1');
                            $attr->value = $relproductattribute[0]->value;
                        }

                        $productAttributeList[$product->id][$groupAttr->id] = $list;
                    }
                }
            }
    }
    // else
    // {
    //     header('location: ' . $this->registry['conf']['rooturl']);
    // }
    //


     	$this->registry->smarty->assign(array(	'compareProductList' 	=> $compareProductList,
     											'sameproductList'  => $sameproductList,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												//'hideMenu'		=> 1,
                                                'promotionList' => $promotionList,
     											'productGroupAttributeList' => $productGroupAttributeList,
     											'productAttributeList'  => $productAttributeList,
												'pgaList' => $pgaList,
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],                                   'pageMetarobots'  => 'noindex, nofollow',
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function removeproductajaxAction()
    {
    	$pid = (int)$_POST['pid'];
    	$compareProductList = array();
    	$myProductCompareCookieExpire = time() + 24 * 3600 ;	//1 days
    	if(!empty($_COOKIE['compareproduct']))
    	{
    		$comparestr = $_COOKIE['compareproduct'];
    		$list = explode(',', $comparestr);
    	}

    	if(in_array($pid, $list))
    	{
    		for($i = 0 , $counter = count($list) ; $i < $counter ; $i++)
    		{
    			if($list[$i] != $pid)
    			{
    				$compareProductList[] = $list[$i];
    			}
    		}
    		$data = implode(',', $compareProductList);

    		setcookie('compareproduct' , $data , $myProductCompareCookieExpire - time() + 24 * 3600 * 2 , '/');
    		$_COOKIE['compareproduct'] = '';

		    setcookie('compareproduct' , $data , $myProductCompareCookieExpire , '/');
		    $_COOKIE['compareproduct'] = $data;

		    echo 'success';
    	}
    	else
    	{
    		echo 'error';
    	}
    }

    public function addproductcompareajaxAction()
    {
    	$pid = (int)$_POST['pid'];
    	$compareProductList = array();
    	$myProductCompareCookieExpire = time() + 24 * 3600 ;	//1 days
    	if(!empty($_COOKIE['compareproduct']))
    	{
    		$comparestr = $_COOKIE['compareproduct'];
    		$compareProductList = explode(',', $comparestr);
    	}


    	   if(count($compareProductList) < 4)
        {
            if(!in_array($pid, $compareProductList))
            {
                $compareProductList[] = $pid;
                $data = implode(',', $compareProductList);

                setcookie('compareproduct' , $data , $myProductCompareCookieExpire , '/');
                $_COOKIE['compareproduct'] = $data;

                echo 'success';
            }
            else
            {
                echo 'success';
            }
        }
        else
        {
            echo 'error';
        }
    }

    public function suggestAction()
    {
        $rooturl = $this->registry->conf['rooturl'];
        $rooturl_cms = $this->registry->conf['rooturl_cms'];
        $rooturl_profile = $this->registry->conf['rooturl_profile'];
        $rooturl_admin = $this->registry->conf['rooturl_admin'];
        $currentTemplate = $this->registry->conf['rooturl'] . 'templates/default/';
        $lang = $this->registry->lang['controller'];

        //search book
        $keyword = htmlspecialchars($_GET['q']);
        $pcid = $_SESSION['pcid_compare'];

        $stopSelect = 0;
        //$keyword = Helper::codau2khongdau($keyword);
        if(mb_strlen($keyword) < 3)
        {
            $stopSelect = 1;
        }

        //search using Sphinx api
        $searchEngine = new SearchEngine();
        $searchEngine->searcher->SetMatchMode(SPH_MATCH_EXTENDED2);

        $searchEngine->addtable('productcategory');

        $myCat = $searchEngine->search($pcid);

        foreach($myCat as $searchInCat)
        {
            if($searchInCat != $myCat['total_found'])
            {
                foreach($searchInCat as $cat)
                {
                    $inCatSearch[] = $cat['id'];
                }
            }
        }
        //echodebug($inCatSearch, true);

        $searchEngine->addtable('productindex');
        $searchEngine->searcher->setFilter('pc_id', array(0 => $pcid), 0);
        $result = $searchEngine->search($keyword);
        //echodebug($result);

        if(count($result['productindex']) > 0)
        {
            //echo $this->registry->conf['rooturl_cms'] . 'product|'.$this->registry->lang['controller']['product'].'|&nbsp;|0|&nbsp;|seperator' . "\n";

            foreach($result['productindex'] as $product)
            {
                $myProduct = new Core_Product($product['id'], true);

                $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, $this->registry->region);
                if($finalprice > 0)
                    $myProduct->sellprice = $finalprice;

                if($myProduct->image == '')
                    $imagePath = $currentTemplate . 'images/default.jpg';
                else
                    $imagePath = $myProduct->getImage();

                if($myProduct->sellprice > 0)
                    echo $this->registry->conf['rooturl'] .'productcompare?pid='.$myProduct->id.'|'.$myProduct->name.'|'.$imagePath.'|&nbsp;|'.($myProduct->sellprice > 0 ? number_format($myProduct->sellprice) . '&#272;' : 'Háº¿t hÃ ng').'|product' . "\n";

            }
		//echodebug($result['productindex'], true);
        }
    }

    /////////////////////////////// SO SANH GIA  //////////////////////////////////
    public function priceenemyAction()
    {
        $formData                  = array();
        $success                   = array();
        $error                     = array();
        $warning                   = array();
        $productGroupAttributeList = array();

        $pid                       = (int)(isset($_GET['pid'])?$_GET['pid']:0);
        $myProduct                 = new Core_Product($pid);

        if($myProduct->id > 0)
        {
            $priceenemyonline = Core_Enemy::getEnemys(array("frid"=>$rid) , 'displayorder' , 'ASC');
            if(!empty($priceenemyonline))
            {
                foreach($priceenemyonline as $enemy)
                {

                    $priceenemy = Core_PriceEnemy::getPriceEnemys(array('feid' => $enemy->id , 'fpid' => $myProduct->id,"ftype"=>Core_PriceEnemy::TYPE_ONLINE) , 'id' , 'ASC');
                    if(count($priceenemy) > 0)
                    {
                        $enemy->priceenemyactor = $priceenemy[0];
                    }

                }
            }
            // get enemy offline
            $priceenemyoffline = Core_PriceEnemy::getPriceEnemys(array('fpid' => $myProduct->id,"ftype"=>Core_PriceEnemy::TYPE_OFFLINE) , 'id' , 'ASC');
            if(count($priceenemyoffline) > 0)
            {
                $i = 0;
                foreach ($priceenemyoffline as $offline) {
                    $offline->enemyactor = Core_Enemy::getEnemys(array("frid"=>$rid,"fid"=>$offline->eid) , 'displayorder' , 'ASC');
                    $i++;
                }

            }
            //echodebug($priceenemyoffline);
        }
        $this->registry->smarty->assign(array(
                                                'priceenemyonline'  =>$priceenemyonline,
                                                'priceenemyoffline' =>$priceenemyoffline,
                                                'myProduct'         => $myProduct,
                                                'currTemplate'      => $this->registry->currentTemplate,
                                                'formData'          => $formData,
                                                'success'           => $success,
                                                'error'             => $error,
                                                'warning'           => $warning,
                                                //'hideMenu'        => 1,
                                                ));


        echo $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'comparepriceenemy.tpl');

    }
}

