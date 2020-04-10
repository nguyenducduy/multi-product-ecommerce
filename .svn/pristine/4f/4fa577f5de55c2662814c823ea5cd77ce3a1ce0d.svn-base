<?php

Class Controller_Admin_ProductPrice Extends Controller_Admin_Base
{
	public $recordPerPage = 20;

	public function indexAction()
	{

        
		$formData = array();
		$error = array();
		$warning = array();
		$success = array();
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) == 'ASC') $sorttype = 'ASC';
		else $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;
		$rid = $this->registry->router->getArg('rid');
		$pbarcode = $this->registry->router->getArg('pbarcode');
		$pbarcodedestination = $this->registry->router->getArg('pbarcodedestination');
		$myProduct = Core_Product::getIdByBarcode($pbarcode);

		if(strlen($pbarcodedestination) > 0)
		{
			$myProductDes = Core_Product::getProductIDByBarcode($pbarcodedestination);
			$relproductcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$myProductDes['p_id'] , 'fpiddestination' => $myProduct->id), 'id', 'ASC');						
			$mycolor = new Core_Productcolor($relproductcolors[0]->typevalue);
		}
		

		$formData['ftab'] = $this->registry->router->getArg('tab');

		$result = (int)$this->registry->router->getArg('rs');



		switch ($result) {
			case Core_ProductPrice::ERRORPRODUCTEXIST :
				$error[] = $this->registry->lang['controller']['errExist'];
				break;
			case Core_ProductPrice::WARININGNOTCHANGE:
				$warning[] = $this->registry->lang['controller']['warnNotChange'];
				break;
			case Core_ProductPrice::SYNCSUCCESS :
				$success[] = $this->registry->lang['controller']['succSync'];
				break;
			case Core_ProductPrice::SYNCERROR :
				$error[] = $this->registry->lang['controller']['errSync'];
				break;
		}

		if($myProduct->id >0)
		{
			$productPriceListHtml = Core_ProductPrice::getProductPrices(array('fpbarcode' => $pbarcode), $sortby , $sorttype , '' , false,false);

			if(count($productPriceListHtml) == 0)
			{
				$error[] = $this->registry->lang['controller']['errExist'];
			}
			else
			{
	            	foreach($productPriceListHtml as $productprice)
	            	{
	            		$productprice->sellprice = Helper::formatPrice($productprice->sellprice);
	            		$productprice->storeActor = new Core_Store($productprice->sid);
	            		$productprice->regionActor = new Core_Region($productprice->rid,true);
	            		$productprice->areaActor = new Core_Area($productprice->aid);
	            	}
	            	$object = end($productPriceListHtml);
	            	$datesync = $object->datemodified;
			}

			if(isset($result) && $result == Core_ProductPrice::ERRORPRODUCTEXIST)
			{
				$productPriceListHtml = array();
			}
			//cap nhat thong tin gia cua doi thu
			if(isset($_POST['fsubmit']))
			{
			     if($_SESSION['securtyToken'] == $_POST['ftoken']){
    				$ok = true;
    				$formData = array_merge($formData, $_POST);								
    				//add url

    				foreach($formData['furl'] as $eid => $url)
    				{
    				    //$formData['fprice'][$eid]= str_replace(",","",$_POST['fprice'][$eid]);
    					//kiem tra xem co ton tai record hay chua ?
    					$mypriceenemys = Core_PriceEnemy::getPriceEnemys(array('fpid' => $myProduct->id, 'fpcid' => $myProduct->pcid,'feid'=>$eid,'ftype'=>Core_PriceEnemy::TYPE_ONLINE) , 'id' , 'ASC');		

    					//da ton tai
    					if(count($mypriceenemys) > 0)
    					{	
        						$mypriceenemy = $mypriceenemys[0];
        						$mypriceenemy->url = $url;
        						
								$mypriceenemy->productname    = $formData['hdProductname'][$eid];
								
								$mypriceenemy->promotioninfo  =  $formData['hdPromotioninfo'][$eid];
								
								$mypriceenemy->description    = $formData['hdDescription'][$eid];
								
								$mypriceenemy->priceauto      = Helper::refineMoneyString($formData['hdPriceAuto'][$eid]);
								$mypriceenemy->pricepromotion = Helper::refineMoneyString($formData['hdPricePromotion'][$eid]);
								
								$mypriceenemy->image          = $formData['hdImage'][$eid];
        						
        						if($mypriceenemy->updateData())
        						{
        							$ok = true;
        						}
        						else
        						{
        							$ok = false;
        						}
                          
    					}
    					else //chua ton tai
    					{					

    						if(strlen($url) > 0)
    						{					
    							$mypriceenemy = new Core_PriceEnemy();
    							$mypriceenemy->eid = $eid;
    							$mypriceenemy->type = Core_PriceEnemy::TYPE_ONLINE;
    							$mypriceenemy->pcid = $myProduct->pcid;
    							$mypriceenemy->pid = $myProduct->id;
        						$mypriceenemy->productname = $formData['hdProductname'][$eid];
        						$mypriceenemy->promotioninfo =  $formData['hdPromotioninfo'][$eid];
        						$mypriceenemy->description = $formData['hdDescription'][$eid];
        						$mypriceenemy->priceauto = Helper::refineMoneyString($formData['hdPriceAuto'][$eid]);
        						$mypriceenemy->pricepromotion = Helper::refineMoneyString($formData['hdPricePromotion'][$eid]);
        						$mypriceenemy->image = $formData['hdImage'][$eid];
    							$mypriceenemy->url = $url;
                                if(!empty($formData['hdPriceAuto'][$eid]))
                                    $mypriceenemy->priceauto = Helper::refineMoneyString($formData['hdPriceAuto'][$eid]);
    							$mypriceenemy->price = Helper::refineMoneyString($formData['fprice'][$eid]);
    							$mypriceenemy->uid = $this->registry->me->id;
    							if($mypriceenemy->addData() > 0)
    							{
    								$ok = true;
    							}
    							else
    							{
    								$ok = false;
    							}
    						}
    					}
    				}								
    				if($ok)
    				{
    					$success[] = 'Cập nhật thông tin giá đối thủ thành công';
    				}
                }
			}
			// Lay thong tin doi thu vao link tu so sanh gia
			if(isset($_POST['fsubmitsosanhgia']))
			{
				if($_SESSION['securtyToken'] == $_POST['ftoken']){
					$formData = array();
					$formData['ftab'] = 2;
					$flinksosanhgia = $_POST['flinksosanhgia'];
					$content = file_get_contents($flinksosanhgia);
					$sosanhgia = new ExtractPrice_SoSanhGia();
					$urlenemy = $sosanhgia->run($content);
					array_push ($urlenemy,$flinksosanhgia);
					foreach($urlenemy as $urle)
					{

						$enemywebsite = parse_url($urle,PHP_URL_HOST);
						$enemy = Core_Enemy::getEnemys(array("fwebsite"=>$enemywebsite),'id','DESC');
						if(count($enemy[0]) <= 0)
						{
							$enemyadd = new Core_Enemy();
							$enemyadd->website = $enemywebsite;
							$enemyadd->name = $enemywebsite;
							$enemyadd->rid = 3; // HO CHI MINH
							$enemyadd->datecreated = time();
							$insertID = $enemyadd->addData();
							if($insertID > 0)
							{
								$mypriceenemy = new Core_PriceEnemy();
    							$mypriceenemy->eid = $insertID;
    							$mypriceenemy->type = Core_PriceEnemy::TYPE_ONLINE;
    							$mypriceenemy->pcid = $myProduct->pcid;
    							$mypriceenemy->pid = $myProduct->id;
    							$mypriceenemy->url = $urle;
    							$mypriceenemy->uid = $this->registry->me->id;
    							if($mypriceenemy->addData() > 0){

    								$ok = true;
    							}
    							else{
    								$ok = false;
    							}
							}
						}
						else
						{
							$mypriceenemys = Core_PriceEnemy::getPriceEnemys(array('fpid' => $myProduct->id, 'fpcid' => $myProduct->pcid,'feid'=>$enemy[0]->id,'ftype'=>Core_PriceEnemy::TYPE_ONLINE) , 'id' , 'ASC');	
							if(count($mypriceenemys) > 0)
							{
	    						$mypriceenemy = $mypriceenemys[0];
	    						$mypriceenemy->url = $urle;
	    						$mypriceenemy->pcid = $myProduct->pcid;
    							$mypriceenemy->pid = $myProduct->id;
	    						$mypriceenemy->type = Core_PriceEnemy::TYPE_ONLINE;
	    						if($mypriceenemy->updateData()){
	    							$ok = true;
	    						}
	    						else{
	    							$ok = false;
	    						}
	    					}
    						else{
    							$mypriceenemy = new Core_PriceEnemy();
    							$mypriceenemy->eid = $enemy[0]->id;
    							$mypriceenemy->type = Core_PriceEnemy::TYPE_ONLINE;
    							$mypriceenemy->pcid = $myProduct->pcid;
    							$mypriceenemy->pid = $myProduct->id;
    							$mypriceenemy->url = $urle;
    							$mypriceenemy->uid = $this->registry->me->id;
    							if($mypriceenemy->addData() > 0){
    								$ok = true;
    							}
    							else{
    								$ok = false;
    							}
    						}
						}
						//INSERT LINK 
					}
					if($ok)
    				{
    					$success[] = 'Lấy link đối thủ thành công';
    				}

				}
			}
			// End lay thong tin doi thu vao link tu so sanh gia

			$_SESSION['securtyToken']= Helper::getSecurityToken();// Gán token để kiểm tra submit form
			//get price of enemy
			//////////////////////////////////////////////////////////////////////////////////////////
			//$enemysonline = Core_Enemy::getEnemys(array("frid"=>$rid,) , 'displayorder' , 'ASC');
			/*$priceenemyonline = Core_PriceEnemy::getPriceEnemys(array('fpid' => $myProduct->id,"ftype"=>Core_PriceEnemy::TYPE_ONLINE) , 'id' , 'ASC');
			if(count($priceenemyonline) > 0)
			{	$i = 0;
				foreach ($priceenemyonline as $online) {
					$online->enemyactor = Core_Enemy::getEnemys(array("frid"=>$rid,"fid"=>$online->eid) , 'displayorder' , 'ASC');
					$i++;
				}
				
			}*/
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
			///////////////////////////////////////////////////////////////////////////////////////////////
			//lay thong tin ve gia cua cac san pham mau
			$productcolorlist = array();
			$productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$myProduct->id), 'id', 'ASC');						
			foreach ($productcolors as $productcolor) 
			{
				$myproductcolor = new Core_Product($productcolor->piddestination);
				$productcolorlist[$myproductcolor->id]['barcode'] = $myproductcolor->barcode;
				$productcolorlist[$myproductcolor->id]['price'] = $myproductcolor->sellprice;
				$color = new Core_Productcolor($productcolor->typevalue);				
				$productcolorlist[$myproductcolor->id]['color'] = $color->name;

				unset($myproductcolor);
			}			
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errBarcodeExist'];
		}
		
		$tab = isset($formData['ftab']) ? $formData['ftab'] : 1;
		$head_list = '';
		if(strlen($myProduct->name) > 0)
		{
			$head_list = str_replace('###PRODUCT_NAME###', $myProduct->name, $this->registry->lang['controller']['head_list']);
		}
		else
		{
			$head_list = str_replace('###PRODUCT_NAME###', $myProductDes['p_name'] . ' - ' . $mycolor->name, $this->registry->lang['controller']['head_list']);	
		}

		$this->registry->smarty->assign(array(	'productPriceListHtml' => $productPriceListHtml,
													'myProduct' => $myProduct,
													'head_list' => $head_list,
													'formData' => $formData,
													'error' => $error,
													'success' => $success,
													'warning' => $warning,
													'datesync' => $datesync,
													'priceenemyoffline' => $priceenemyoffline,
													'priceenemyonline' => $priceenemyonline,
													'tab' => $tab,
                                                    'priceSync'=>$priceSync,
                                                    'productcolorlist' => $productcolorlist,
                                                    'pbarcodedestination' => $pbarcodedestination,
                                                    'pbarcode' =>$pbarcode
													));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'index.tpl');
	}

	public function syncpriceAction()
	{
		$barcode = (string)$_POST['barcode'];

		$total = Core_ProductPrice::getProductPrices(array('fpbarcode' => $barcode) , 'id' , 'ASC' , '' ,true);
		if($total == 0)
		{
			$result = Core_ProductPrice::ERRORPRODUCTEXIST;
		}

		$result = Core_ProductPrice::syncProductPrice($barcode);

		//get product info
		$product = Core_Product::getProductIDByBarcode($barcode);        

        //cap nhat ton kho san pham mau
        $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$product['p_id']), 'id', 'ASC');
        
        if(count($productcolors) > 0)
        {
        	foreach ($productcolors as $productcolor) 
        	{
        		
        		$myproductcolor = new Core_Product($productcolor->piddestination , true);
        		if($myproductcolor->id > 0)
        		{
        			$result = Core_ProductPrice::syncProductPrice($myproductcolor->barcode);

        			unset($myproductcolor);
        		}        		
        	}
        }		

		echo $result;

	}

	public function editinlineurlAction()
	{
		$pid = (int)$_POST['fpid'];
		$id = (int)$_POST['id'];
		$eid =(int)$_POST['feid'];
		$value = (string)$_POST['value'];
		if(strlen($value) > 0)
		{
			if($id > 0)
			{
				$priceenemy = new Core_PriceEnemy($id);
				if($priceenemy->id > 0 && $priceenemy->pid == $pid)
				{
					$priceenemy->url = $value;
					if($priceenemy->updateData())
					{
						echo $priceenemy->id . '_'.$priceenemy->url;
					}
				}
			}
			else
			{
				$priceenemy = new Core_PriceEnemy();
				$priceenemy->url = $value;
				$priceenemy->pid = $pid;
				$myProduct = new Core_Product($pid);
				$priceenemy->pcid = $myProduct->pcid;
				$priceenemy->eid = $eid;
				$priceenemy->uid = $this->registry->me->id;
				if($priceenemy->addData() > 0)
				{
					echo $priceenemy->id . '_'.$priceenemy->url;
				}
			}
		}
		else
		{
			echo 'empty_URL...';
		}
	}

	public function editinlinepriceAction()
	{
		$pid = (int)$_POST['fpid'];
		$id = (int)$_POST['id'];
		$eid =(int)$_POST['feid'];
		$value = (string)$_POST['value'];



		if($id > 0)
		{
			$priceenemy = new Core_PriceEnemy($id);
			if($priceenemy->id > 0 && $priceenemy->pid == $pid)
			{
				$priceenemy->price = Helper::refineMoneyString($value);
				if($priceenemy->updateData())
				{
					echo $priceenemy->id . '_'.Helper::formatPrice($priceenemy->price);
				}
			}
		}
		else
		{
			$priceenemy = new Core_PriceEnemy();
			$priceenemy->price = Helper::refineMoneyString($value);
			$priceenemy->pid = $pid;
			$myProduct = new Core_Product($pid);
			$priceenemy->pcid = $myProduct->pcid;
			$priceenemy->eid = $eid;
			if($priceenemy->addData() > 0)
			{
				echo $priceenemy->id . '_'.Helper::formatPrice($priceenemy->price);
			}
		}
	}
    
    public function ajaxsyncpriceAction()
    {
        if($_POST['url'])
        {
            $urls = $_POST['url'];
            if($_SESSION['securtyToken'] == $_POST['ftoken']){
              
                //Khởi tao đối tượng 
                $thienHoa = new ExtractPrice_ThienHoa();
                $nguyenKim = new ExtractPrice_NguyenKim();
                $lazada = new ExtractPrice_Lazada();
                $maiNguyen =  new ExtractPrice_MaiNguyen();
                $dienMayChiLon = new ExtractPrice_DienMayChoLon();
               $pico = new ExtractPrice_Pico();
                $priceSync = array();
                foreach($urls as $eid => $url)
				{ 
				    set_time_limit(0);
				    if(ExtractPrice::isValidURL($url)){
                        $domainName = ExtractPrice::regularExpressionURL($url);
                        switch($domainName)
                        {
                            
                            case "nguyenkim":                          
                                $priceSync[$eid] = $nguyenKim->run($url);
                                break;
                            case "dienmaythienhoa":
                                 $priceSync[$eid] =  $thienHoa->run($url);
                                break;
                            case "lazada":
                                 $priceSync[$eid] = $lazada->run($url);
                                break;
                            case "mainguyen":
                                $priceSync[$eid] = $maiNguyen->run($url);
                                break;
                            case "dienmaycholon":
                                $priceSync[$eid] = $dienMayChiLon->run($url);
                                break;
                             case "pico":
                        	$priceSync = $pico->run($file);
                        	break;
                        }
                        $ok = true;
                    }
                }
                if($ok == true)
                {
                    echo json_encode($priceSync);
                }
            }
        }
    }
    public function ajaxsyncprice2Action()
    {
        if($_POST['url'])
        {
             set_time_limit(0);
            $urls = $_POST['url'];
            $file = "";
            if($_SESSION['securtyToken'] == $_POST['ftoken']){
                //Kh?i tao d?i tu?ng 
                $thienHoa = new ExtractPrice_ThienHoa();
                $nguyenKim = new ExtractPrice_NguyenKim();
                $lazada = new ExtractPrice_Lazada();
                $maiNguyen =  new ExtractPrice_MaiNguyen();
                $dienMayChoLon = new ExtractPrice_DienMayChoLon();
                $pico = new ExtractPrice_Pico();
                $priceSync = 0;
			    if(ExtractPrice::isValidURL($urls)){
                    $file = file_get_contents($urls);
                    $domainName = ExtractPrice::regularExpressionURL(trim($urls));
                    switch($domainName)
                    {
                        case "dienmaycholon":
                            $priceSync = $dienMayChoLon->run($file);
                            break;
                        case "nguyenkim":                          
                            $priceSync = $nguyenKim->run($file);
                            break;
                        case "dienmaythienhoa":
                             $priceSync =  $thienHoa->run($file);
                            break;
                        case "lazada":
                             $priceSync= $lazada->run($file);
                            break;
                        case "mainguyen":
                            $priceSync = $maiNguyen->run($file);
                            break;
                        case "pico":
                        	$priceSync = $pico->run($file);
                        	break;
                       
                    }
                    $ok = true;
                }
                echo $priceSync;
            }
        }
    }
    public function ajaxaddenemyAction()
    {
    	$success = 0;
		if(!empty($_POST['faddenemy']) || $_POST['faddenemy'] = 'submit')
		{
            $formData = array();
            $formData['fname'] = $_POST['fname'];
            $formData['fwebsite'] = $_POST['fwebsite'];
            $formData['frid'] = $_POST['frid'];
            if($this->addActionValidator($formData))
            {
                $myEnemy = new Core_Enemy();
				$myEnemy->name = $formData['fname'];
				$myEnemy->website = $formData['fwebsite'];					
				$myEnemy->rid = $formData['frid'];		
                if($myEnemy->addData())
                {
                    $success = 1;
                    $this->registry->me->writelog('enemy_add', $myEnemy->id, array());
                          
                }
            }
		}
		echo $success;
    }
    private function addActionValidator($formData)
	{
		$pass = true;
		if($formData['fname'] == '')
		{
			$pass = false;
		}
		return $pass;
	}
	public function deletepriceenemyAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myPriceEnemy = new Core_PriceEnemy($id);
		if($myPriceEnemy->id > 0)
		{
			//tien hanh xoa
			if($myPriceEnemy->delete())
			{
				$redirectMsg = str_replace('###id###', $myPriceEnemy->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('priceenemy_delete', $myPriceEnemy->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPriceEnemy->id, $this->registry->lang['controller']['errDelete']);
			}
			
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}
		$barcode = $this->registry->router->getArg('pbarcode');
		$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl().'/index/pbarcode/'.$barcode.'/tab/2',
												'redirectMsg' => $redirectMsg,
												));
		$this->registry->smarty->display('redirect.tpl');
			
	}

	//////////////////////////////////////////////////////////
	public function ajaxsyncenemyinfoAction()
    {
        if($_POST['url'])
        {
             set_time_limit(0);
            $urls = $_POST['url'];
            $file = "";
            $priceSync = 0;
		    if(ExtractPrice::isValidURL($urls)){
                $file = file_get_contents($urls);
                $domainName = parse_url($urls);
                $hostName = str_replace('www.','',$domainName['host']);
                $data = array();
                switch($hostName)
                {
                    case "dienmaycholon.vn":
                        $data = ExtractPrice_DienMayChoLon::getInfo($file);
                        break;
                    case "nguyenkim.com":                          
                        $data = ExtractPrice_NguyenKim::getInfo($file);
                        break;
                    case "dienmaythienhoa.vn":
                         $data =  ExtractPrice_ThienHoa::getInfo($file);
                        break;
                    case "lazada.vn":
                         $data= ExtractPrice_Lazada::getInfo($file);
                        break;
                    case "mainguyen.vn":
                        $data = ExtractPrice_MaiNguyen::getInfo($file);
                        break;
                    case "pico.vn":
                    	$data = ExtractPrice_Pico::getInfo($file);
                    	break;
                    case "thegioididong.com":
                    	$data = ExtractPrice_Tgdd::getInfo($file);
                    	break;
                    case "vienthonga.vn":
                    	$data = ExtractPrice_Vienthonga::getInfo($file);
                    	break;
                    case "viettelstore.vn":
                    	$data = ExtractPrice_Viettelstore::getInfo($file);
                    	break;
                    case 'fptshop.com.vn':
                    	$data = ExtractPrice_Fptshop::getInfo($file);
                    	break;
                    case 'topcare.vn':
                    	$data = ExtractPrice_TopCare::getInfo($file);
                    	break;
                    case 'www.topcare.vn':
                    	$data = ExtractPrice_TopCare::getInfo($file);
                    	break;
                    case 'hc.com.vn':
                    	$data = ExtractPrice_HC::getInfo($file);
                    	break;
                    case 'phankhang.vn':
                    	$data = ExtractPrice_PhanKhang::getInfo($file);
                    	break;
                    case 'tiki.vn':
                    	$data = ExtractPrice_Tiki::getInfo($file);
                    	break;
                   
                }
                $ok = true;
            }
            echo json_encode($data);
        
        }
    }
   
   
}
