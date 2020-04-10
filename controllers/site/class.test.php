<?php

Class Controller_Site_Test extends Controller_Site_Base
{
	public $recordPerPage = 20;
	public function indexAction()
	{
		$formData = array();
		$success  = array();
		$error    = array();
		$warning  = array();
		
		//get all category
		/*$productcategoryList = array();
		$parentCategory1 = Core_Productcategory::getProductcategorys(array(), 'parentid', 'ASC');
		for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
		{
			if($parentCategory1[$i]->parentid == 0)
			{
				$productcategoryList[] = $parentCategory1[$i];
				$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
				for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
				{
					$parentCategory2[$j]->name = $parentCategory2[$j]->name;
					$productcategoryList[] = $parentCategory2[$j];

					$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
					foreach ($subCategory as $sub)
					{
						$sub->name = $sub->name;
						$productcategoryList[] = $sub;
					}
				}
			}
		}*/

		$myProduct = new Core_Product(57919);

		//echodebug($myProduct->getProductPath());


		$this->registry->smarty->assign(array(	'productcategoryList' => $productcategoryList,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
                                                                                                'hideMenu' => 1,
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function searchAction()
	{
		$formData = array();
		$success  = array();
		$error    = array();
		$warning  = array();

		$formData['fpcid'] = (int)$this->registry->router->getArg('pcid');
		$formData['fvid']  = (int)$this->registry->router->getArg('vid');
		$page              = (int)($_GET['page'])>0?(int)($_GET['page']):1;
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;



		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/search/';


		if($formData['fpcid'] > 0)
		{
			$paginateUrl .= 'pcid/' . $formData['fpcid'] . '/';
		}

		if($formData['fvid'] > 0)
		{
			$paginateUrl .= 'vid/' . $formData['fvid'] . '/';
		}

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		//$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype ;

		$paginateUrl .= '?';
		$redirectUrl = base64_encode($redirectUrl);


		if(!empty($_GET['fsubmit']))
		{
			$formData = array_merge($formData, $_GET);
			$attrList = array();
			$queryString = '';

			//echodebug($formData,true);

			foreach($formData['fattribute'] as $paid => $value)
			{
				if((string)$value != '')
				{
					$attrList[$paid] = trim(Helper::plaintext($value));
				}
			}

			if(count($attrList) > 0)
			{
				$formData['fattribute'] = $attrList;

				foreach ($formData['fattribute'] as $paid => $value)
				{
					$queryString .= 'fattribute['.$paid.']=' . urlencode($value) . '&';
				}
				$queryString .= 'fsubmit=Search';

				$paginateUrl .= $queryString;

				$formData['fidarr'] = Core_RelProductAttribute::getProductIdByFilter($formData, 'pid' , 'ASC');
			}
		}

		//tim tong so
		$total = Core_Product::getProducts($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;

		$productList = Core_Product::getProducts($formData, $sortby, $sorttype,(($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= '&page=' . $curPage;

		//get vendor by category
		$vendorList = Core_Vendor::getVendorByProductcategory($formData, 'v_name ASC');

		//lay tat ca cac thuoc tinh cua san pham va gia tri cua thuoc tinh do
		$attributeList = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid'=>$formData['fpcid']), 'displayorder', 'ASC');

		for($i = 0 ; $i < count($attributeList) ; $i++)
		{
			$attributeList[$i]->value = explode('###', $attributeList[$i]->value);
		}

		$this->registry->smarty->assign(array(  'vendorList'    => $vendorList,
												'productList'	=> $productList,
												'attributeList'	=> $attributeList,
												'queryString'   => $queryString,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'search.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function detailAction()
	{
		$pid = (int)$this->registry->router->getArg('pid');
		if($pid > 0)
		{
			$myProduct = new Core_Product($pid);
			echodebug($myProduct,true);
		}
    }

    public function testurlAction()
    {
        $test = new Core_ProductMedia();
        $test->fileurl = 'http://dienmay.myhost/Products/Images/42/21504/SamsungC170_3.jpg';

        $test->addData();
    }

    public function testCategoryAction()
    {
        $pcid = 48829;

        $result = Core_Product::getFullCategory($pcid);

        //$result = Core_Productcategory::getFullParentProductCategorys(402);
        echodebug($result,true);
    }

    public function testInitAction()
    {
    	$result = Core_Product::editInit(402);

    	echo $result;
    }
	
	public function getattributevalueAction()
	{
		/**
			42 : dien thoai di dong
			522 : may tinh bang
		*/
		$data =  '';
		$data .= 'Ngành hàng#Thuộc tính#Giá trị#Giá trị SEO#Trọng số' . "\n";
		set_time_limit(0);
		$productAttributeList = Core_ProductAttribute::getProductAttributes(array('fpcidarr' => array(42,522)), 'name' , 'ASC');
		//lay tat cac cac gia tri cua thuoc tinh
		for($i = 0 , $counter = count($productAttributeList) ; $i < $counter ; $i++)
		{
					$productAttributeList[$i]->actor = Core_RelProductAttribute::getRelProductAttributeByCategory(array('fpcid' => $productcategory->id, 'fpaid'=>$productAttributeList[$i]->id),'weight' , 'DESC',true);


		}
		
		if(count($productAttributeList) > 0)
		{
			foreach($productAttributeList as $productAttribute)
			{
				if(count($productAttribute->actor) > 0)
				{
					foreach($productAttribute->actor as $valueobj)
					{
						if($productAttribute->pcid == 42)
						{
							$data .=  'Điện thoại di động#';
						}
						else
						{
							$data .= 'Máy tính bảng###';
						}						
						
						$data .= $productAttribute->name . '#';
						$data .= $valueobj->value . '#';
						$data .= $valueobj->valueseo .'#';
						$data .= $valueobj->weight . '#';
						$data .= "\n";
					}
				}
			}
		}
		
		
		
		$myHttpDownload = new HttpDownload();
        $myHttpDownload->set_bydata($data); //Download from php data
        $myHttpDownload->use_resume = true; //Enable Resume Mode
        $myHttpDownload->filename = 'productattributedata-'.date('Y-m-d-H-i-s') . '.csv';
        $myHttpDownload->download(); //Download File
	}


    public function testreAction()
    {
        $pid = $this->registry->router->getArg('pid');
        
        $arrO = array();
        $arrP = array();
       
        $rs = Core_Test::getre();
        //lay order co p1
        foreach ($rs as $key => $value) {
           
            if($value['pid']==$pid)
            {
                $arrO[] = $value['oid'];
            }
                
        }
      
        foreach ($rs as $key => $value) {
           
            if($value['pid'] != $pid && in_array($value['oid'], $arrO))
            {
                if(isset($arrP[$value['pid']]))
                    $arrP[$value['pid']] =  $arrP[$value['pid']] + 1;
                else
                     $arrP[$value['pid']] = 1 ;
            }

        }
        echodebug($arrP);    
      
    }
	
	public function testphoneAction()
	{
		$phone = '0988646724';
		if(Helper::checkPhoneAvalible($phone))
		{
			echo 'so dien thoai hop le !';
		}
		else
		{
			echo 'so dien thoai khong hop le';
		}
	}
    
    public function testgetnewsAction()
    {
        $newslist = Core_News::getNewsOfProduct(1783);
        echodebug($newslist , true);
    }

    public function getparentofnewscatAction()
    {
    	$outputlist = Core_Newscategory::getFullSubCategory(114);

    	echodebug($outputlist);
    }

    public function testcolorAction()
    {
    	$colorproduct = Core_Product::getMainProductFromColor(60696);

    	echodebug($colorproduct);
    }
	
	public function testoracleerrorAction()
	{
		$oracle = new Oracle();
		$sql = 'SELECT PRODUCTID FROM VW_PRICESPRODUCT_DM';
		$result = $oracle->query($sql);
	}

    public function teststatstockAction()
    {
        $barcode = '1704133003700';
        $currentmonth = 12;
        $currentyear = 2013;
        $currentday = 11;
        $day = 'day_' . $currentday;
        
        $result = array();
        $statproductstock = Core_Backend_StatProductstock::getDataByBarcode($barcode , $currentmonth , $currentyear);
        $datarows = array();
        if (strlen(trim($statproductstock->$day)) > 0) {
            $infolist = explode(',', $statproductstock->$day);
            foreach ($infolist as $info) {
                $temp = explode(':' , $info);
                $datarows[$temp[0]][$temp[1]] = $temp[2];
            }            

            foreach ($datarows as $sid => $datarow) {
                for($i = 0 ; $i < 24 ; $i++) {
                    if(!isset($datarow[$i])) {
                        $result[$sid][$i] = $this->getdatabefore($i, $datarow);                        
                    }
                    else {
                        $result[$sid][$i] = $datarow[$i];
                    }
                }                
            }

            echodebug($result,true);
        }        

    }

    public function teststatpriceAction()
    {
        $barcode = '1704133003700';
        $currentmonth = 12;
        $currentyear = 2013;
        $currentday = 12;
        $day = 'day_' . $currentday;

        $result = array();
        $statProductPrice = Core_Backend_StatProductprice::getDataByBarcode($barcode , $currentmonth , $currentyear);
        $datarows = array();
        
        if (strlen(trim($statProductPrice->$day)) > 0) {
            $infolist = explode(',', $statProductPrice->$day);
            foreach ($infolist as $info) {
                $temp = explode(':' , $info);
                $datarows[$temp[0]][$temp[1]][$temp[2]] = $temp[3];
            }            

            foreach ($datarows as $ppaid => $datalist) {
                foreach ($datalist as $poid => $datarow) {
                    for($i = 0 ; $i < 24 ; $i++) {
                        if(!isset($datarow[$i])) {
                            $result[$ppaid][$poid][$i] = $this->getdatabefore($i, $datarow);                        
                        }
                        else {
                            $result[$ppaid][$poid][$i] = $datarow[$i];
                        }
                    }
                }             
            }

            echodebug($result,true);
        }
    }

    public function testarrayAction()
    {
        $catlist = array();
        Core_Productcategory::getCategoryIdTree($catlist);

        echodebug($catlist);
    }

}
