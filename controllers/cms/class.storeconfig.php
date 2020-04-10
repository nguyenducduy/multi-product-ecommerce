<?php
Class Controller_Cms_Storeconfig Extends Controller_Cms_Base
{
	public function indexAction()
	{		
		$error = array();
		$success = array();	
		$formData = array();			

		if(isset($_POST['fsubmitNext']))
		{
			$formData = array_merge($formData , $_POST);
			if($formData['fpcid'] > 0)
			{
				header('Location: ' . $this->registry['conf']['rooturl_cms'] . 'storeconfig/index/pcid/' . $formData['fpcid']);
			}
		}	

		$pcid = $this->registry->router->getArg('pcid');
		if($pcid > 0)
		{
			$formData['fpcid'] = $pcid;

			if($this->checkcategoryroot($formData['fpcid']))
			{
				$myrootcategory = new Core_Productcategory($pcid , true);
				if(isset($_POST['fsubmit']))
				{
					$formData = array($formData , $_POST);					
					$ok = false;					
					foreach($formData[1]['fstoretype'] as $storeid => $type)
					{
						$storetypeforecasts = Core_Backend_StoreTypeForecast::getStoreTypeForecasts(array('fsid' => $storeid , 'fpcid' => $formData[1]['fpcid']) , 'id' , 'ASC');
						if(count($storetypeforecasts) > 0)
						{
							$myStoreTypeForecast = $storetypeforecasts[0];
							$myStoreTypeForecast->sid = $storeid;
							$myStoreTypeForecast->pcid = $pcid;						
							$myStoreTypeForecast->type = $type;
							$myStoreTypeForecast->uid = $this->registry->me->id;						
							if($myStoreTypeForecast->updateData())
							{
								$ok = true;
							}
						}
						else
						{
							$myStoreTypeForecast = new Core_Backend_StoreTypeForecast();
			
							$myStoreTypeForecast->sid = $storeid;
							$myStoreTypeForecast->pcid = $pcid;						
							$myStoreTypeForecast->type = $type;
							$myStoreTypeForecast->uid = $this->registry->me->id;						
							if($myStoreTypeForecast->addData() > 0)
							{
								$ok = true;
							}
						}
					}

					if($ok)
					{
						$success[] = 'Lưu thông tin thành công.';
					}
					else
					{
						$error[] = 'Lưu thông không thành công.';
					}
				}
			}
			else
			{
				$error[] = 'Danh mục không hợp lệ.';
			}

			/////LAY THONG TIN CONFIG KHO CUA NGANH HANG
			$storeconfiglist = Core_Backend_StoreTypeForecast::getStoreTypeForecasts(array('fpcid' => $pcid) , 'id' , 'ASC');			
			//////GET MAIN STORE
			$storelist = Core_Store::getStores(array('fissalestore' => 1 , 'fisautostorechange' => 1) , 'id' , 'ASC');	

			//lay tat ca vendor cua ngành hàng
			$vendorlist = Core_Vendor::getVendorByProductcategoryFromCache($pcid);

			//lay tat ca phan khuc gia cua danh muc
			$listfilter = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($pcid);		
			

			$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'storelist' => $storelist,
												'typelist' => Core_Backend_StoreTypeForecast::gettypeList(),
												'storeconfiglist' => $storeconfiglist,
												'bussinessstatusList' => Core_Product::getbusinessstatusList(),
												'vendorlist' => $vendorlist,
												'myrootcategory' => $myrootcategory,
												));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
				$this->registry->smarty->assign(array(
														'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
														'contents' 			=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			//get root category
			$rootcategorylist = Core_Productcategory::getProductcategoryListFromCache(true);
			$this->registry->smarty->assign(array(
											'rootcategory' => $rootcategorylist,
											));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'step.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
	}

	public function searchajaxAction()
	{
		$html = '';

		$name = (string)$_POST['pname'];
		$bs = (string)$_POST['bs'];
		$barcode = (string)$_POST['pbarcode'];
		$pcid = (int)$_POST['pcid'];
		$vid = (string)$_POST['vid'];

		if(strlen($name) > 0 || strlen($bs) > 0 || strlen($barcode) > 0 && $pcid > 0 && strlen($vid) > 0)
		{		
			/////GET FULL SUBCATEGORY
			$subcatlist = Core_Productcategory::getFullSubCategoryFromCache($pcid);

			$subcatlist = array_keys($subcatlist);			

			$conditionsearch = array();
			$conditionsearch['fonsitestatus'] = Core_Product::OS_ERP;
			$conditionsearch['fname'] = $name;
			$conditionsearch['fbarcode'] = $barcode;
			$conditionsearch['fpcidarrin'] = $subcatlist;			

			if(strlen($bs) > 0)
				$conditionsearch['fbusinessstatusarr'] = explode(',', $bs);

			if(strlen($vid) > 0)
				$conditionsearch['fvidarr'] = explode(',', $vid);
			
			$productlist = Core_Product::getProducts($conditionsearch , 'id' , 'ASC');
			if(count($productlist) > 0)
			{
				//// LAY THONG TIN MA USER NAY DA INPUT CHO CAC USERVALUE TRONG SHEET NAY
				$uservalueBefore = array();
				//$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fuid' => $this->registry->me->id, 'fsheet' => Core_Backend_ForecastUservalue::SHEET_KEHOACHPRODUCTSIEUTHI ,'fdate' =>( date('m' , strtotime('+3 month' , $begindate)) . date('Y' , strtotime('+3 month' , $begindate))) ), '', '', '');				

				$forecastUserValueList = Core_Backend_ForecastUservalue::getForecastUservalues(array('fsheet' => Core_Backend_ForecastUservalue::SHEET_SANPHAMCONFIG ), '', '', '');	
				
				if(count($forecastUserValueList) > 0)
				{
					foreach($forecastUserValueList as $forecastUserValue)
					{
						$uservalueBefore[$forecastUserValue->identifier] = $forecastUserValue->value;
					}
				}
				$datalist = array();
				//ket thuc lay du lieu				
				foreach ($productlist as $product) 
				{
					$datainfo = array();

					$datainfo['name'] = $product->name;
					$datainfo['barcode'] = $product->barcode;
					$datainfo['bussinessstatus'] = $product->getbusinessstatusName();

					$storetypelist = Core_Backend_StoreTypeForecast::gettypeList();
					$storetypelist[4] = 'Hệ thống';

					/////LAY GIA MUA NAO CUA USER
					$identifier = Core_Backend_ForecastUservalue::getIdentifier('gianhapmua', array('product' => $product->id));
					$datainfo['gianhapmua'] = array('name' => $identifier,
													'value' => isset($uservalueBefore[$identifier]) ? Helper::formatPrice($uservalueBefore[$identifier]) : 0,
													);



					//////LAY HAN MUC THEO LOAI SIEU THI
					foreach($storetypelist as $typeid => $typename)
					{
						$uservaluename = array('min', 'ngaymin' , 'ngaymax');
						$uservaluelist = array();
						foreach($uservaluename as $uname)
						{					
							$identifier = Core_Backend_ForecastUservalue::getIdentifier($uname, array('product' => $product->id, 'storetype' =>$typeid ));
							$uservaluelist[$uname] = array(
									'name' => $identifier,
									'value' => isset($uservalueBefore[$identifier]) ? $uservalueBefore[$identifier] : 0,
							);
						}						
						$datainfo[$typeid]['min'] = $uservaluelist['min'];
						$datainfo[$typeid]['ngaymin'] = $uservaluelist['ngaymin'];
						$datainfo[$typeid]['ngaymax'] = $uservaluelist['ngaymax'];
					}					
					$datalist[] = $datainfo;
					unset($datainfo);					
				}

				$_SESSION['storeconfigAddToken']=Helper::getSecurityToken();//Tao token moi
				$this->registry->smarty->assign(array(
											'datalist' => $datalist,
											'storetypelist' => $storetypelist,
											'fsheet' => Core_Backend_ForecastUservalue::SHEET_SANPHAMCONFIG,
											));
				$html = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'search.tpl');				
			}
			else
			{
				$html ='Không tìm thấy thông tin.';
			}
		}
		else
		{
			$html = -1;
		}


		echo $html;
	}

	public function updatedataforecastAction()
	{
		//submit du lieu do user nhap vao
		$formData = array();
		$formData = array_merge($formData, $_POST);
		$session = $_SESSION['storeconfigAddToken'];		
		///////////////////////////////////
		if($session == $formData['ftoken'])
		{
			$ok = -1;			
			if($this->updatedataforecasValidation($formData))
			{													
				$date = date('m' , time()) . date('Y' , time());						
				foreach ($formData['fdataforecast'] as $identifier => $value) 
				{
					//$myForecastUservalue = Core_Backend_ForecastUservalue::getDataBySheet($identifier , $formData['fsheet'] , $this->registry->me->id, $date);
					$myForecastUservalue = Core_Backend_ForecastUservalue::getDataBySheet($identifier , $formData['fsheet'] , $date);
					if($myForecastUservalue->id > 0)
					{
						$oldvalue = $myForecastUservalue->value;
						$newvalue = $value;

						if($newvalue != $oldvalue)
						{										
							$myForecastUservalue->identifier   = $identifier;
							$myForecastUservalue->sheet        = (int)$formData['fsheet'];
							$myForecastUservalue->value        = Helper::refineMoneyString($value);					
							$myForecastUservalue->date         = $date;

							if($myForecastUservalue->updateData())
							{
								$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory();
			
								$myForecastUservalueHistory->uid = $myForecastUservalue->uid;
								$myForecastUservalueHistory->fuid = $myForecastUservalue->id;								
								$myForecastUservalueHistory->oldvalue = Helper::refineMoneyString($oldvalue);
								$myForecastUservalueHistory->newvalue = Helper::refineMoneyString($newvalue);
								$myForecastUservalueHistory->edituserid = $this->registry->me->id;	
								$myForecastUservalueHistory->type = Core_Backend_ForecastUservalueHistory::TYPE_EDIT;
								$myForecastUservalueHistory->fromsheet = (int)$formData['fsheet'];	

								if($myForecastUservalueHistory->addData() > 0)
								{
									$ok = 1;
								}						
							}
						}
					}
					else
					{						
						$myForecastUservalue->uid          = $this->registry->me->id;					
						$myForecastUservalue->identifier   = (string)$identifier;
						$myForecastUservalue->sheet        = (int)$formData['fsheet'];
						$myForecastUservalue->value        = (int)Helper::refineMoneyString($value);					
						$myForecastUservalue->date         = (int)$date;
						
						if($myForecastUservalue->addData() > 0)
						{							
							if((int)$value > 0)
							{
								//////UPDATE HISTORY FOR SHEET
								$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory();
				
								$myForecastUservalueHistory->uid = $myForecastUservalue->uid;
								$myForecastUservalueHistory->fuid = $myForecastUservalue->id;								
								$myForecastUservalueHistory->oldvalue = 0;
								$myForecastUservalueHistory->newvalue = (int)$value;
								$myForecastUservalueHistory->edituserid = $this->registry->me->id;
								$myForecastUservalueHistory->type = Core_Backend_ForecastUservalueHistory::TYPE_ADD;
								$myForecastUservalueHistory->fromsheet = (int)$formData['fsheet'];

								if($myForecastUservalueHistory->addData() > 0)
								{
									$ok = 1;
								}	
							}
							else
							{
								$ok = 1;
							}
						}					
					}
				}
			}
			else
			{
				$ok = 0;
			}
			
			echo $ok;
		}

		//end of submit form
	}//end of function
	
	private function updatedataforecasValidation($formData)
	{
		$pass = true;				

		if(count($formData['fdataforecast']) == 0)
		{
			$pass = false;
		}
		else 
		{
			foreach ($formData['fdataforecast'] as $identifier => $value) 
			{
				if(!is_numeric(Helper::refineMoneyString($value)))
				{
					$pass = false;
					break;
				}
			}
		}

		return $pass;
	}//end of function

	private function checkcategoryroot($pcid)
	{
		$pass = true;
		if($pcid > 0)
		{
			$productcategory = new Core_Productcategory($pcid , true);
			if($productcategory->parentid > 0 || $productcategory->id ==0)
			{
				$pass = false;
			}
		}	
		return $pass;
	}
}