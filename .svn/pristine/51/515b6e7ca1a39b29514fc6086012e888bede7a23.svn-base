<?php

Class Controller_Crm_Archivedorder Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{

		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$saleorderidFilter          = (string)($this->registry->router->getArg('saleorderid'));
		$isdetailFilter             = (int)($this->registry->router->getArg('isdetail'));
		$ordertypeidFilter          = (int)($this->registry->router->getArg('ordertypeid'));
		$deliverytypeidFilter       = (int)($this->registry->router->getArg('deliverytypeid'));
		$companyidFilter            = (int)($this->registry->router->getArg('companyid'));
		$customeridFilter           = (int)($this->registry->router->getArg('customerid'));
		$customernameFilter         = (string)($this->registry->router->getArg('customername'));
		$customeraddressFilter      = (string)($this->registry->router->getArg('customeraddress'));
		$customerphoneFilter        = (string)($this->registry->router->getArg('customerphone'));
		$contactnameFilter          = (string)($this->registry->router->getArg('contactname'));
		$genderFilter               = (int)($this->registry->router->getArg('gender'));
		$ageidFilter                = (int)($this->registry->router->getArg('ageid'));
		$deliveryaddressFilter      = (string)($this->registry->router->getArg('deliveryaddress'));
		$provinceidFilter           = (int)($this->registry->router->getArg('provinceid'));
		$districtidFilter           = (int)($this->registry->router->getArg('districtid'));
		$isreviewedFilter           = (int)($this->registry->router->getArg('isreviewed'));
		$payabletypeidFilter        = (int)($this->registry->router->getArg('payabletypeid'));
		$currencyunitidFilter       = (int)($this->registry->router->getArg('currencyunitid'));
		$currencyexchangeFilter     = (int)($this->registry->router->getArg('currencyexchange'));
		$totalquantityFilter        = (int)($this->registry->router->getArg('totalquantity'));
		$totalamountFilter          = (float)($this->registry->router->getArg('totalamount'));
		$totaladvanceFilter         = (int)($this->registry->router->getArg('totaladvance'));
		$shippingcostFilter         = (int)($this->registry->router->getArg('shippingcost'));
		$debtFilter                 = (float)($this->registry->router->getArg('debt'));
		$discountreasonidFilter     = (int)($this->registry->router->getArg('discountreasonid'));
		$discountFilter             = (float)($this->registry->router->getArg('discount'));
		$originatestoreidFilter     = (int)($this->registry->router->getArg('originatestoreid'));
		$isoutproductFilter         = (int)($this->registry->router->getArg('isoutproduct'));
		$outputstoreidFilter        = (int)($this->registry->router->getArg('outputstoreid'));
		$isincomeFilter             = (int)($this->registry->router->getArg('isincome'));
		$isdeletedFilter            = (int)($this->registry->router->getArg('isdeleted'));
		$promotiondiscountFilter    = (int)($this->registry->router->getArg('promotiondiscount'));
		$vouchertypeidFilter        = (int)($this->registry->router->getArg('vouchertypeid'));
		$voucherconcernFilter       = (string)($this->registry->router->getArg('voucherconcern'));
		$deliveryuserFilter         = (string)($this->registry->router->getArg('deliveryuser'));
		$saleprogramidFilter        = (int)($this->registry->router->getArg('saleprogramid'));
		$totalpaidFilter            = (float)($this->registry->router->getArg('totalpaid'));
		$issmspromotionFilter       = (int)($this->registry->router->getArg('issmspromotion'));
		$deliverytimeFilter         = (int)($this->registry->router->getArg('deliverytime'));
		$isdeliveryFilter           = (int)($this->registry->router->getArg('isdelivery'));
		$deliveryupdatetimeFilter   = (int)($this->registry->router->getArg('deliveryupdatetime'));
		$ismoveFilter               = (int)($this->registry->router->getArg('ismove'));
		$parentsaleorderidFilter    = (string)($this->registry->router->getArg('parentsaleorderid'));
		$thirdpartyvoucherFilter    = (string)($this->registry->router->getArg('thirdpartyvoucher'));
		$payabletimeFilter          = (int)($this->registry->router->getArg('payabletime'));
		$createdbyotherappsFilter   = (int)($this->registry->router->getArg('createdbyotherapps'));
		$contactphoneFilter         = (string)($this->registry->router->getArg('contactphone'));
		$customercarestatusidFilter = (int)($this->registry->router->getArg('customercarestatusid'));
		$totalprepaidFilter         = (float)($this->registry->router->getArg('totalprepaid'));
		$crmcustomeridFilter        = (int)($this->registry->router->getArg('crmcustomerid'));
		$datearchivedFilter         = (int)($this->registry->router->getArg('datearchived'));
		$idFilter                   = (int)($this->registry->router->getArg('id'));
		$createdateFilter           = (int)($this->registry->router->getArg('createdate'));
		
		$keywordFilter              = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn            = (string)$this->registry->router->getArg('searchin');
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['archivedorderBulkToken']==$_POST['ftoken'])
            {
                 if(!isset($_POST['fbulkid']))
                {
                    $warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
                }
                else
                {
                    $formData['fbulkid'] = $_POST['fbulkid'];
                    
                    //check for delete 
                    if($_POST['fbulkaction'] == 'delete')
                    {
                        $delArr = $_POST['fbulkid'];
                        $deletedItems = array();
                        $cannotDeletedItems = array();
                        foreach($delArr as $id)
                        {
                            //check valid user and not admin user
                            $myArchivedorder = new Core_Archivedorder($id);
                            
                            if($myArchivedorder->id > 0)
                            {
                                //tien hanh xoa
                                if($myArchivedorder->delete())
                                {
                                    $deletedItems[] = $myArchivedorder->id;
                                    $this->registry->me->writelog('archivedorder_delete', $myArchivedorder->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myArchivedorder->id;
                            }
                            else
                                $cannotDeletedItems[] = $myArchivedorder->id;
                        }
                        
                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);
                        
                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    }
                    else
                    {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }
			
		}
		
		$_SESSION['archivedorderBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($saleorderidFilter != "")
		{
			$paginateUrl .= 'saleorderid/'.$saleorderidFilter . '/';
			$formData['fsaleorderid'] = $saleorderidFilter;
			$formData['search'] = 'saleorderid';
		}
		if($isdetailFilter != "")
		{
			$paginateUrl .= 'isdetail/'.$isdetailFilter . '/';
			$formData['fisdetail'] = $isdetailFilter;
			$formData['search'] = 'isdetail';
		}
		if($createdateFilter != "")
		{
			$paginateUrl .= 'createdate/'.$createdateFilter . '/';
			$formData['fcreatedate'] = $saleorderidFilter;
			$formData['search'] = 'createdate';
		}

		if($ordertypeidFilter > 0)
		{
			$paginateUrl .= 'ordertypeid/'.$ordertypeidFilter . '/';
			$formData['fordertypeid'] = $ordertypeidFilter;
			$formData['search'] = 'ordertypeid';
		}

		if($deliverytypeidFilter > 0)
		{
			$paginateUrl .= 'deliverytypeid/'.$deliverytypeidFilter . '/';
			$formData['fdeliverytypeid'] = $deliverytypeidFilter;
			$formData['search'] = 'deliverytypeid';
		}

		if($companyidFilter > 0)
		{
			$paginateUrl .= 'companyid/'.$companyidFilter . '/';
			$formData['fcompanyid'] = $companyidFilter;
			$formData['search'] = 'companyid';
		}

		if($customeridFilter > 0)
		{
			$paginateUrl .= 'customerid/'.$customeridFilter . '/';
			$formData['fcustomerid'] = $customeridFilter;
			$formData['search'] = 'customerid';
		}

		if($customernameFilter != "")
		{
			$paginateUrl .= 'customername/'.$customernameFilter . '/';
			$formData['fcustomername'] = $customernameFilter;
			$formData['search'] = 'customername';
		}

		if($customeraddressFilter != "")
		{
			$paginateUrl .= 'customeraddress/'.$customeraddressFilter . '/';
			$formData['fcustomeraddress'] = $customeraddressFilter;
			$formData['search'] = 'customeraddress';
		}

		if($customerphoneFilter != "")
		{
			$paginateUrl .= 'customerphone/'.$customerphoneFilter . '/';
			$formData['fcustomerphone'] = $customerphoneFilter;
			$formData['search'] = 'customerphone';
		}

		if($contactnameFilter != "")
		{
			$paginateUrl .= 'contactname/'.$contactnameFilter . '/';
			$formData['fcontactname'] = $contactnameFilter;
			$formData['search'] = 'contactname';
		}

		if($genderFilter > 0)
		{
			$paginateUrl .= 'gender/'.$genderFilter . '/';
			$formData['fgender'] = $genderFilter;
			$formData['search'] = 'gender';
		}

		if($ageidFilter > 0)
		{
			$paginateUrl .= 'ageid/'.$ageidFilter . '/';
			$formData['fageid'] = $ageidFilter;
			$formData['search'] = 'ageid';
		}

		if($deliveryaddressFilter != "")
		{
			$paginateUrl .= 'deliveryaddress/'.$deliveryaddressFilter . '/';
			$formData['fdeliveryaddress'] = $deliveryaddressFilter;
			$formData['search'] = 'deliveryaddress';
		}

		if($provinceidFilter > 0)
		{
			$paginateUrl .= 'provinceid/'.$provinceidFilter . '/';
			$formData['fprovinceid'] = $provinceidFilter;
			$formData['search'] = 'provinceid';
		}

		if($districtidFilter > 0)
		{
			$paginateUrl .= 'districtid/'.$districtidFilter . '/';
			$formData['fdistrictid'] = $districtidFilter;
			$formData['search'] = 'districtid';
		}

		if($isreviewedFilter > 0)
		{
			$paginateUrl .= 'isreviewed/'.$isreviewedFilter . '/';
			$formData['fisreviewed'] = $isreviewedFilter;
			$formData['search'] = 'isreviewed';
		}

		if($payabletypeidFilter > 0)
		{
			$paginateUrl .= 'payabletypeid/'.$payabletypeidFilter . '/';
			$formData['fpayabletypeid'] = $payabletypeidFilter;
			$formData['search'] = 'payabletypeid';
		}

		if($currencyunitidFilter > 0)
		{
			$paginateUrl .= 'currencyunitid/'.$currencyunitidFilter . '/';
			$formData['fcurrencyunitid'] = $currencyunitidFilter;
			$formData['search'] = 'currencyunitid';
		}

		if($currencyexchangeFilter > 0)
		{
			$paginateUrl .= 'currencyexchange/'.$currencyexchangeFilter . '/';
			$formData['fcurrencyexchange'] = $currencyexchangeFilter;
			$formData['search'] = 'currencyexchange';
		}

		if($totalquantityFilter > 0)
		{
			$paginateUrl .= 'totalquantity/'.$totalquantityFilter . '/';
			$formData['ftotalquantity'] = $totalquantityFilter;
			$formData['search'] = 'totalquantity';
		}

		if($totalamountFilter > 0)
		{
			$paginateUrl .= 'totalamount/'.$totalamountFilter . '/';
			$formData['ftotalamount'] = $totalamountFilter;
			$formData['search'] = 'totalamount';
		}

		if($totaladvanceFilter > 0)
		{
			$paginateUrl .= 'totaladvance/'.$totaladvanceFilter . '/';
			$formData['ftotaladvance'] = $totaladvanceFilter;
			$formData['search'] = 'totaladvance';
		}

		if($shippingcostFilter > 0)
		{
			$paginateUrl .= 'shippingcost/'.$shippingcostFilter . '/';
			$formData['fshippingcost'] = $shippingcostFilter;
			$formData['search'] = 'shippingcost';
		}

		if($debtFilter > 0)
		{
			$paginateUrl .= 'debt/'.$debtFilter . '/';
			$formData['fdebt'] = $debtFilter;
			$formData['search'] = 'debt';
		}

		if($discountreasonidFilter > 0)
		{
			$paginateUrl .= 'discountreasonid/'.$discountreasonidFilter . '/';
			$formData['fdiscountreasonid'] = $discountreasonidFilter;
			$formData['search'] = 'discountreasonid';
		}

		if($discountFilter > 0)
		{
			$paginateUrl .= 'discount/'.$discountFilter . '/';
			$formData['fdiscount'] = $discountFilter;
			$formData['search'] = 'discount';
		}

		if($originatestoreidFilter > 0)
		{
			$paginateUrl .= 'originatestoreid/'.$originatestoreidFilter . '/';
			$formData['foriginatestoreid'] = $originatestoreidFilter;
			$formData['search'] = 'originatestoreid';
		}

		if($isoutproductFilter > 0)
		{
			$paginateUrl .= 'isoutproduct/'.$isoutproductFilter . '/';
			$formData['fisoutproduct'] = $isoutproductFilter;
			$formData['search'] = 'isoutproduct';
		}

		if($outputstoreidFilter > 0)
		{
			$paginateUrl .= 'outputstoreid/'.$outputstoreidFilter . '/';
			$formData['foutputstoreid'] = $outputstoreidFilter;
			$formData['search'] = 'outputstoreid';
		}

		if($isincomeFilter > 0)
		{
			$paginateUrl .= 'isincome/'.$isincomeFilter . '/';
			$formData['fisincome'] = $isincomeFilter;
			$formData['search'] = 'isincome';
		}

		if($isdeletedFilter > 0)
		{
			$paginateUrl .= 'isdeleted/'.$isdeletedFilter . '/';
			$formData['fisdeleted'] = $isdeletedFilter;
			$formData['search'] = 'isdeleted';
		}

		if($promotiondiscountFilter > 0)
		{
			$paginateUrl .= 'promotiondiscount/'.$promotiondiscountFilter . '/';
			$formData['fpromotiondiscount'] = $promotiondiscountFilter;
			$formData['search'] = 'promotiondiscount';
		}

		if($vouchertypeidFilter > 0)
		{
			$paginateUrl .= 'vouchertypeid/'.$vouchertypeidFilter . '/';
			$formData['fvouchertypeid'] = $vouchertypeidFilter;
			$formData['search'] = 'vouchertypeid';
		}

		if($voucherconcernFilter != "")
		{
			$paginateUrl .= 'voucherconcern/'.$voucherconcernFilter . '/';
			$formData['fvoucherconcern'] = $voucherconcernFilter;
			$formData['search'] = 'voucherconcern';
		}

		if($deliveryuserFilter != "")
		{
			$paginateUrl .= 'deliveryuser/'.$deliveryuserFilter . '/';
			$formData['fdeliveryuser'] = $deliveryuserFilter;
			$formData['search'] = 'deliveryuser';
		}

		if($saleprogramidFilter > 0)
		{
			$paginateUrl .= 'saleprogramid/'.$saleprogramidFilter . '/';
			$formData['fsaleprogramid'] = $saleprogramidFilter;
			$formData['search'] = 'saleprogramid';
		}

		if($totalpaidFilter > 0)
		{
			$paginateUrl .= 'totalpaid/'.$totalpaidFilter . '/';
			$formData['ftotalpaid'] = $totalpaidFilter;
			$formData['search'] = 'totalpaid';
		}

		if($issmspromotionFilter > 0)
		{
			$paginateUrl .= 'issmspromotion/'.$issmspromotionFilter . '/';
			$formData['fissmspromotion'] = $issmspromotionFilter;
			$formData['search'] = 'issmspromotion';
		}

		if($deliverytimeFilter > 0)
		{
			$paginateUrl .= 'deliverytime/'.$deliverytimeFilter . '/';
			$formData['fdeliverytime'] = $deliverytimeFilter;
			$formData['search'] = 'deliverytime';
		}

		if($isdeliveryFilter > 0)
		{
			$paginateUrl .= 'isdelivery/'.$isdeliveryFilter . '/';
			$formData['fisdelivery'] = $isdeliveryFilter;
			$formData['search'] = 'isdelivery';
		}

		if($deliveryupdatetimeFilter > 0)
		{
			$paginateUrl .= 'deliveryupdatetime/'.$deliveryupdatetimeFilter . '/';
			$formData['fdeliveryupdatetime'] = $deliveryupdatetimeFilter;
			$formData['search'] = 'deliveryupdatetime';
		}

		if($ismoveFilter > 0)
		{
			$paginateUrl .= 'ismove/'.$ismoveFilter . '/';
			$formData['fismove'] = $ismoveFilter;
			$formData['search'] = 'ismove';
		}

		if($parentsaleorderidFilter != "")
		{
			$paginateUrl .= 'parentsaleorderid/'.$parentsaleorderidFilter . '/';
			$formData['fparentsaleorderid'] = $parentsaleorderidFilter;
			$formData['search'] = 'parentsaleorderid';
		}

		if($thirdpartyvoucherFilter != "")
		{
			$paginateUrl .= 'thirdpartyvoucher/'.$thirdpartyvoucherFilter . '/';
			$formData['fthirdpartyvoucher'] = $thirdpartyvoucherFilter;
			$formData['search'] = 'thirdpartyvoucher';
		}

		if($payabletimeFilter > 0)
		{
			$paginateUrl .= 'payabletime/'.$payabletimeFilter . '/';
			$formData['fpayabletime'] = $payabletimeFilter;
			$formData['search'] = 'payabletime';
		}

		if($createdbyotherappsFilter > 0)
		{
			$paginateUrl .= 'createdbyotherapps/'.$createdbyotherappsFilter . '/';
			$formData['fcreatedbyotherapps'] = $createdbyotherappsFilter;
			$formData['search'] = 'createdbyotherapps';
		}

		if($contactphoneFilter != "")
		{
			$paginateUrl .= 'contactphone/'.$contactphoneFilter . '/';
			$formData['fcontactphone'] = $contactphoneFilter;
			$formData['search'] = 'contactphone';
		}

		if($customercarestatusidFilter > 0)
		{
			$paginateUrl .= 'customercarestatusid/'.$customercarestatusidFilter . '/';
			$formData['fcustomercarestatusid'] = $customercarestatusidFilter;
			$formData['search'] = 'customercarestatusid';
		}

		if($totalprepaidFilter > 0)
		{
			$paginateUrl .= 'totalprepaid/'.$totalprepaidFilter . '/';
			$formData['ftotalprepaid'] = $totalprepaidFilter;
			$formData['search'] = 'totalprepaid';
		}

		if($crmcustomeridFilter > 0)
		{
			$paginateUrl .= 'crmcustomerid/'.$crmcustomeridFilter . '/';
			$formData['fcrmcustomerid'] = $crmcustomeridFilter;
			$formData['search'] = 'crmcustomerid';
		}

		if($datearchivedFilter > 0)
		{
			$paginateUrl .= 'datearchived/'.$datearchivedFilter . '/';
			$formData['fdatearchived'] = $datearchivedFilter;
			$formData['search'] = 'datearchived';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'saleorderid')
			{
				$paginateUrl .= 'searchin/saleorderid/';
			}
			/*if($searchKeywordIn == 'isdetail')
			{
				$paginateUrl .= 'searchin/isdetail/';
			}*/
			elseif($searchKeywordIn == 'customername')
			{
				$paginateUrl .= 'searchin/customername/';
			}
			elseif($searchKeywordIn == 'customeraddress')
			{
				$paginateUrl .= 'searchin/customeraddress/';
			}
			elseif($searchKeywordIn == 'customerphone')
			{
				$paginateUrl .= 'searchin/customerphone/';
			}
			elseif($searchKeywordIn == 'contactname')
			{
				$paginateUrl .= 'searchin/contactname/';
			}
			elseif($searchKeywordIn == 'deliveryaddress')
			{
				$paginateUrl .= 'searchin/deliveryaddress/';
			}
			elseif($searchKeywordIn == 'voucherconcern')
			{
				$paginateUrl .= 'searchin/voucherconcern/';
			}
			elseif($searchKeywordIn == 'deliveryuser')
			{
				$paginateUrl .= 'searchin/deliveryuser/';
			}
			elseif($searchKeywordIn == 'parentsaleorderid')
			{
				$paginateUrl .= 'searchin/parentsaleorderid/';
			}
			elseif($searchKeywordIn == 'thirdpartyvoucher')
			{
				$paginateUrl .= 'searchin/thirdpartyvoucher/';
			}
			elseif($searchKeywordIn == 'contactphone')
			{
				$paginateUrl .= 'searchin/contactphone/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
		//tim tong so
		$total = Core_Archivedorder::getArchivedorders($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account

		$archivedorders = Core_Archivedorder::getArchivedorders($formData, 'id', $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		foreach ($archivedorders as $key => $value) {

			$type = Core_Ordertype::getList('ot_ordertypeid="'.$value->ordertypeid.'"','','');
			$archivedorders[$key]->ordername   = $type[0]->name;
			$archivedorders[$key]->createdate  = date("d/m/Y h:i:s A",$value->createdate);

		}
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'archivedorders' 	=> $archivedorders,
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
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	}


	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if(!empty($_POST['fsubmit']))
		{
			if($_SESSION['archivedorderAddToken'] == $_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);


				if($this->addActionValidator($formData, $error))
				{
					$myArchivedorder = new Core_Archivedorder();


					$myArchivedorder->ordertypeid                  = $formData['fordertypeid'];
					$myArchivedorder->saleorderid                  = $formData['fsaleorderid'];
					$myArchivedorder->deliverytypeid               = $formData['fdeliverytypeid'];
					$myArchivedorder->datearchived                 = $formData['fdatearchived'];
					$myArchivedorder->companyid                    = $formData['fcompanyid'];
					$myArchivedorder->customerid                   = $formData['fcustomerid'];
					$myArchivedorder->customername                 = $formData['fcustomername'];
					$myArchivedorder->customeraddress              = $formData['fcustomeraddress'];
					$myArchivedorder->customerphone                = $formData['fcustomerphone'];
					$myArchivedorder->contactname                  = $formData['fcontactname'];
					$myArchivedorder->gender                       = $formData['fgender'];
					$myArchivedorder->ageid                        = $formData['fageid'];
					$myArchivedorder->deliveryaddress              = $formData['fdeliveryaddress'];
					$myArchivedorder->provinceid                   = $formData['fprovinceid'];
					$myArchivedorder->districtid                   = $formData['fdistrictid'];
					$myArchivedorder->isreviewed                   = $formData['fisreviewed'];
					$myArchivedorder->payabletypeid                = $formData['fpayabletypeid'];
					$myArchivedorder->currencyunitid               = $formData['fcurrencyunitid'];
					$myArchivedorder->currencyexchange             = $formData['fcurrencyexchange'];
					$myArchivedorder->totalquantity                = $formData['ftotalquantity'];
					$myArchivedorder->totalamount                  = $formData['ftotalamount'];
					$myArchivedorder->totaladvance                 = $formData['ftotaladvance'];
					$myArchivedorder->shippingcost                 = $formData['fshippingcost'];
					$myArchivedorder->debt                         = $formData['fdebt'];
					$myArchivedorder->discountreasonid             = $formData['fdiscountreasonid'];
					$myArchivedorder->discount                     = $formData['fdiscount'];
					$myArchivedorder->originatestoreid             = $formData['foriginatestoreid'];
					$myArchivedorder->isoutproduct                 = $formData['fisoutproduct'];
					$myArchivedorder->outputstoreid                = $formData['foutputstoreid'];
					$myArchivedorder->isincome                     = $formData['fisincome'];
					$myArchivedorder->isdeleted                    = $formData['fisdeleted'];
					$myArchivedorder->promotiondiscount            = $formData['fpromotiondiscount'];
					$myArchivedorder->vouchertypeid                = $formData['fvouchertypeid'];
					$myArchivedorder->voucherconcern               = $formData['fvoucherconcern'];
					$myArchivedorder->deliveryuser                 = $formData['fdeliveryuser'];
					$myArchivedorder->saleprogramid                = $formData['fsaleprogramid'];
					$myArchivedorder->totalpaid                    = $formData['ftotalpaid'];
					$myArchivedorder->issmspromotion               = $formData['fissmspromotion'];
					$myArchivedorder->deliverytime                 = $formData['fdeliverytime'];
					$myArchivedorder->isdelivery                   = $formData['fisdelivery'];
					$myArchivedorder->deliveryupdatetime           = $formData['fdeliveryupdatetime'];
					$myArchivedorder->ismove                       = $formData['fismove'];
					$myArchivedorder->parentsaleorderid            = $formData['fparentsaleorderid'];
					$myArchivedorder->thirdpartyvoucher            = $formData['fthirdpartyvoucher'];
					$myArchivedorder->payabletime                  = $formData['fpayabletime'];
					$myArchivedorder->createdbyotherapps           = $formData['fcreatedbyotherapps'];
					$myArchivedorder->contactphone                 = $formData['fcontactphone'];
					$myArchivedorder->customercarestatusid         = $formData['fcustomercarestatusid'];
					$myArchivedorder->totalprepaid                 = $formData['ftotalprepaid'];
					$myArchivedorder->crmcustomerid                = $formData['fcrmcustomerid'];
					$myArchivedorder->IsDetail                     = $formData['fIsDetail'];
					$myArchivedorder->originatestoreregionid       = $formData['foriginatestoreregionid'];
					$myArchivedorder->outputstoreregionid          = $formData['foutputstoreregionid'];
					$myArchivedorder->createdate                   = $formData['fcreatedate'];
					$myArchivedorder->lat                          = $formData['flat'];
					$myArchivedorder->lng                          = $formData['flng'];
					$myArchivedorder->iscomplete                   = $formData['fiscomplete'];
					$myArchivedorder->taxid                        = $formData['ftaxid'];
					$myArchivedorder->note                         = $formData['fnote'];
					$myArchivedorder->revieweduser                 = $formData['frevieweduser'];
					$myArchivedorder->revieweddate                 = $formData['frevieweddate'];
					$myArchivedorder->outproductdate               = $formData['foutproductdate'];
					$myArchivedorder->inputtime                    = $formData['finputtime'];
					$myArchivedorder->userdeleted                  = $formData['fuserdeleted'];
					$myArchivedorder->datedelete                   = $formData['fdatedelete'];
					$myArchivedorder->contentdeleted               = $formData['fcontentdeleted'];
					$myArchivedorder->staffuser                    = $formData['fstaffuser'];
					$myArchivedorder->printtimes                   = $formData['fprinttimes'];
					$myArchivedorder->deliveryupdateuser           = $formData['fdeliveryupdateuser'];
					$myArchivedorder->movetime                     = $formData['fmovetime'];
					$myArchivedorder->outputuser                   = $formData['foutputuser'];
					$myArchivedorder->deliveryuserupdatetime       = $formData['fdeliveryuserupdatetime'];
					$myArchivedorder->deliveryuserupdateuser       = $formData['fdeliveryuserupdateuser'];
					$myArchivedorder->customercarestausupdatetime  = $formData['fcustomercarestausupdatetime'];
					$myArchivedorder->customercarestatusupdateuser = $formData['fcustomercarestatusupdateuser'];
					$myArchivedorder->contactid                    = $formData['fcontactid'];
					$myArchivedorder->customercode                 = $formData['fcustomercode'];
					$myArchivedorder->birthday                     = $formData['fbirthday'];
					$myArchivedorder->customeridcard               = $formData['fcustomeridcard'];
					$myArchivedorder->createdapplicationid         = $formData['fcreatedapplicationid'];
					$myArchivedorder->iscreatefromoutputreceipt    = $formData['fiscreatefromoutputreceipt'];
					$myArchivedorder->iscreatefromsimprocessreq    = $formData['fiscreatefromsimprocessreq'];
					$myArchivedorder->bankvoucher                  = $formData['fbankvoucher'];
					$myArchivedorder->processuser                  = $formData['fprocessuser'];
					$myArchivedorder->contractid                   = $formData['fcontractid'];
					$myArchivedorder->isinputimeicomplete          = $formData['fisinputimeicomplete'];
					$myArchivedorder->organizationname             = $formData['forganizationname'];
					$myArchivedorder->positionname                 = $formData['fpositionname'];
					$myArchivedorder->currentreviewlevelid         = $formData['fcurrentreviewlevelid'];
					$myArchivedorder->mspromotionlevelidlist       = $formData['fmspromotionlevelidlist'];
					$myArchivedorder->crmcustomercardcode          = $formData['fcrmcustomercardcode'];
					$myArchivedorder->iswarningduplicatesaleorder  = $formData['fiswarningduplicatesaleorder'];
					$myArchivedorder->duplicatesaleorderid         = $formData['fduplicatesaleorderid'];
					$myArchivedorder->pointpaid                    = $formData['fpointpaid'];

					if($myArchivedorder->addData())
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('archivedorder_add', $myArchivedorder->id, array());
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}

		}

		$_SESSION['archivedorderAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
		                                          'redirectUrl'	=> $this->getRedirectUrl(),
		                                          'error'			=> $error,
		                                          'success'		=> $success,

		                                ));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
		                                     'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
		                                     'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myArchivedorder = new Core_Archivedorder($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myArchivedorder->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myArchivedorder->id;
			$formData['fordertypeid'] = $myArchivedorder->ordertypeid;
			$formData['fsaleorderid'] = $myArchivedorder->saleorderid;
			$formData['fdeliverytypeid'] = $myArchivedorder->deliverytypeid;
			$formData['fdatearchived'] = $myArchivedorder->datearchived;
			$formData['fcompanyid'] = $myArchivedorder->companyid;
			$formData['fcustomerid'] = $myArchivedorder->customerid;
			$formData['fcustomername'] = $myArchivedorder->customername;
			$formData['fcustomeraddress'] = $myArchivedorder->customeraddress;
			$formData['fcustomerphone'] = $myArchivedorder->customerphone;
			$formData['fcontactname'] = $myArchivedorder->contactname;
			$formData['fgender'] = $myArchivedorder->gender;
			$formData['fageid'] = $myArchivedorder->ageid;
			$formData['fdeliveryaddress'] = $myArchivedorder->deliveryaddress;
			$formData['fprovinceid'] = $myArchivedorder->provinceid;
			$formData['fdistrictid'] = $myArchivedorder->districtid;
			$formData['fisreviewed'] = $myArchivedorder->isreviewed;
			$formData['fpayabletypeid'] = $myArchivedorder->payabletypeid;
			$formData['fcurrencyunitid'] = $myArchivedorder->currencyunitid;
			$formData['fcurrencyexchange'] = $myArchivedorder->currencyexchange;
			$formData['ftotalquantity'] = $myArchivedorder->totalquantity;
			$formData['ftotalamount'] = $myArchivedorder->totalamount;
			$formData['ftotaladvance'] = $myArchivedorder->totaladvance;
			$formData['fshippingcost'] = $myArchivedorder->shippingcost;
			$formData['fdebt'] = $myArchivedorder->debt;
			$formData['fdiscountreasonid'] = $myArchivedorder->discountreasonid;
			$formData['fdiscount'] = $myArchivedorder->discount;
			$formData['foriginatestoreid'] = $myArchivedorder->originatestoreid;
			$formData['fisoutproduct'] = $myArchivedorder->isoutproduct;
			$formData['foutputstoreid'] = $myArchivedorder->outputstoreid;
			$formData['fisincome'] = $myArchivedorder->isincome;
			$formData['fisdeleted'] = $myArchivedorder->isdeleted;
			$formData['fpromotiondiscount'] = $myArchivedorder->promotiondiscount;
			$formData['fvouchertypeid'] = $myArchivedorder->vouchertypeid;
			$formData['fvoucherconcern'] = $myArchivedorder->voucherconcern;
			$formData['fdeliveryuser'] = $myArchivedorder->deliveryuser;
			$formData['fsaleprogramid'] = $myArchivedorder->saleprogramid;
			$formData['ftotalpaid'] = $myArchivedorder->totalpaid;
			$formData['fissmspromotion'] = $myArchivedorder->issmspromotion;
			$formData['fdeliverytime'] = $myArchivedorder->deliverytime;
			$formData['fisdelivery'] = $myArchivedorder->isdelivery;
			$formData['fdeliveryupdatetime'] = $myArchivedorder->deliveryupdatetime;
			$formData['fismove'] = $myArchivedorder->ismove;
			$formData['fparentsaleorderid'] = $myArchivedorder->parentsaleorderid;
			$formData['fthirdpartyvoucher'] = $myArchivedorder->thirdpartyvoucher;
			$formData['fpayabletime'] = $myArchivedorder->payabletime;
			$formData['fcreatedbyotherapps'] = $myArchivedorder->createdbyotherapps;
			$formData['fcontactphone'] = $myArchivedorder->contactphone;
			$formData['fcustomercarestatusid'] = $myArchivedorder->customercarestatusid;
			$formData['ftotalprepaid'] = $myArchivedorder->totalprepaid;
			$formData['fcrmcustomerid'] = $myArchivedorder->crmcustomerid;
			$formData['fIsDetail'] = $myArchivedorder->IsDetail;
			$formData['foriginatestoreregionid'] = $myArchivedorder->originatestoreregionid;
			$formData['foutputstoreregionid'] = $myArchivedorder->outputstoreregionid;
			$formData['fcreatedate'] = $myArchivedorder->createdate;
			$formData['flat'] = $myArchivedorder->lat;
			$formData['flng'] = $myArchivedorder->lng;
			$formData['fiscomplete'] = $myArchivedorder->iscomplete;
			$formData['ftaxid'] = $myArchivedorder->taxid;
			$formData['fnote'] = $myArchivedorder->note;
			$formData['frevieweduser'] = $myArchivedorder->revieweduser;
			$formData['frevieweddate'] = $myArchivedorder->revieweddate;
			$formData['foutproductdate'] = $myArchivedorder->outproductdate;
			$formData['finputtime'] = $myArchivedorder->inputtime;
			$formData['fuserdeleted'] = $myArchivedorder->userdeleted;
			$formData['fdatedelete'] = $myArchivedorder->datedelete;
			$formData['fcontentdeleted'] = $myArchivedorder->contentdeleted;
			$formData['fstaffuser'] = $myArchivedorder->staffuser;
			$formData['fprinttimes'] = $myArchivedorder->printtimes;
			$formData['fdeliveryupdateuser'] = $myArchivedorder->deliveryupdateuser;
			$formData['fmovetime'] = $myArchivedorder->movetime;
			$formData['foutputuser'] = $myArchivedorder->outputuser;
			$formData['fdeliveryuserupdatetime'] = $myArchivedorder->deliveryuserupdatetime;
			$formData['fdeliveryuserupdateuser'] = $myArchivedorder->deliveryuserupdateuser;
			$formData['fcustomercarestausupdatetime'] = $myArchivedorder->customercarestausupdatetime;
			$formData['fcustomercarestatusupdateuser'] = $myArchivedorder->customercarestatusupdateuser;
			$formData['fcontactid'] = $myArchivedorder->contactid;
			$formData['fcustomercode'] = $myArchivedorder->customercode;
			$formData['fbirthday'] = $myArchivedorder->birthday;
			$formData['fcustomeridcard'] = $myArchivedorder->customeridcard;
			$formData['fcreatedapplicationid'] = $myArchivedorder->createdapplicationid;
			$formData['fiscreatefromoutputreceipt'] = $myArchivedorder->iscreatefromoutputreceipt;
			$formData['fiscreatefromsimprocessreq'] = $myArchivedorder->iscreatefromsimprocessreq;
			$formData['fbankvoucher'] = $myArchivedorder->bankvoucher;
			$formData['fprocessuser'] = $myArchivedorder->processuser;
			$formData['fcontractid'] = $myArchivedorder->contractid;
			$formData['fisinputimeicomplete'] = $myArchivedorder->isinputimeicomplete;
			$formData['forganizationname'] = $myArchivedorder->organizationname;
			$formData['fpositionname'] = $myArchivedorder->positionname;
			$formData['fcurrentreviewlevelid'] = $myArchivedorder->currentreviewlevelid;
			$formData['fmspromotionlevelidlist'] = $myArchivedorder->mspromotionlevelidlist;
			$formData['fcrmcustomercardcode'] = $myArchivedorder->crmcustomercardcode;
			$formData['fiswarningduplicatesaleorder'] = $myArchivedorder->iswarningduplicatesaleorder;
			$formData['fduplicatesaleorderid'] = $myArchivedorder->duplicatesaleorderid;
			$formData['fpointpaid'] = $myArchivedorder->pointpaid;

			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['archivedorderEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->editActionValidator($formData, $error))
					{

						$myArchivedorder->ordertypeid = $formData['fordertypeid'];
						$myArchivedorder->saleorderid = $formData['fsaleorderid'];
						$myArchivedorder->deliverytypeid = $formData['fdeliverytypeid'];
						$myArchivedorder->datearchived = $formData['fdatearchived'];
						$myArchivedorder->companyid = $formData['fcompanyid'];
						$myArchivedorder->customerid = $formData['fcustomerid'];
						$myArchivedorder->customername = $formData['fcustomername'];
						$myArchivedorder->customeraddress = $formData['fcustomeraddress'];
						$myArchivedorder->customerphone = $formData['fcustomerphone'];
						$myArchivedorder->contactname = $formData['fcontactname'];
						$myArchivedorder->gender = $formData['fgender'];
						$myArchivedorder->ageid = $formData['fageid'];
						$myArchivedorder->deliveryaddress = $formData['fdeliveryaddress'];
						$myArchivedorder->provinceid = $formData['fprovinceid'];
						$myArchivedorder->districtid = $formData['fdistrictid'];
						$myArchivedorder->isreviewed = $formData['fisreviewed'];
						$myArchivedorder->payabletypeid = $formData['fpayabletypeid'];
						$myArchivedorder->currencyunitid = $formData['fcurrencyunitid'];
						$myArchivedorder->currencyexchange = $formData['fcurrencyexchange'];
						$myArchivedorder->totalquantity = $formData['ftotalquantity'];
						$myArchivedorder->totalamount = $formData['ftotalamount'];
						$myArchivedorder->totaladvance = $formData['ftotaladvance'];
						$myArchivedorder->shippingcost = $formData['fshippingcost'];
						$myArchivedorder->debt = $formData['fdebt'];
						$myArchivedorder->discountreasonid = $formData['fdiscountreasonid'];
						$myArchivedorder->discount = $formData['fdiscount'];
						$myArchivedorder->originatestoreid = $formData['foriginatestoreid'];
						$myArchivedorder->isoutproduct = $formData['fisoutproduct'];
						$myArchivedorder->outputstoreid = $formData['foutputstoreid'];
						$myArchivedorder->isincome = $formData['fisincome'];
						$myArchivedorder->isdeleted = $formData['fisdeleted'];
						$myArchivedorder->promotiondiscount = $formData['fpromotiondiscount'];
						$myArchivedorder->vouchertypeid = $formData['fvouchertypeid'];
						$myArchivedorder->voucherconcern = $formData['fvoucherconcern'];
						$myArchivedorder->deliveryuser = $formData['fdeliveryuser'];
						$myArchivedorder->saleprogramid = $formData['fsaleprogramid'];
						$myArchivedorder->totalpaid = $formData['ftotalpaid'];
						$myArchivedorder->issmspromotion = $formData['fissmspromotion'];
						$myArchivedorder->deliverytime = $formData['fdeliverytime'];
						$myArchivedorder->isdelivery = $formData['fisdelivery'];
						$myArchivedorder->deliveryupdatetime = $formData['fdeliveryupdatetime'];
						$myArchivedorder->ismove = $formData['fismove'];
						$myArchivedorder->parentsaleorderid = $formData['fparentsaleorderid'];
						$myArchivedorder->thirdpartyvoucher = $formData['fthirdpartyvoucher'];
						$myArchivedorder->payabletime = $formData['fpayabletime'];
						$myArchivedorder->createdbyotherapps = $formData['fcreatedbyotherapps'];
						$myArchivedorder->contactphone = $formData['fcontactphone'];
						$myArchivedorder->customercarestatusid = $formData['fcustomercarestatusid'];
						$myArchivedorder->totalprepaid = $formData['ftotalprepaid'];
						$myArchivedorder->crmcustomerid = $formData['fcrmcustomerid'];
						$myArchivedorder->IsDetail = $formData['fIsDetail'];
						$myArchivedorder->originatestoreregionid = $formData['foriginatestoreregionid'];
						$myArchivedorder->outputstoreregionid = $formData['foutputstoreregionid'];
						$myArchivedorder->createdate = $formData['fcreatedate'];
						$myArchivedorder->lat = $formData['flat'];
						$myArchivedorder->lng = $formData['flng'];
						$myArchivedorder->iscomplete = $formData['fiscomplete'];
						$myArchivedorder->taxid = $formData['ftaxid'];
						$myArchivedorder->note = $formData['fnote'];
						$myArchivedorder->revieweduser = $formData['frevieweduser'];
						$myArchivedorder->revieweddate = $formData['frevieweddate'];
						$myArchivedorder->outproductdate = $formData['foutproductdate'];
						$myArchivedorder->inputtime = $formData['finputtime'];
						$myArchivedorder->userdeleted = $formData['fuserdeleted'];
						$myArchivedorder->datedelete = $formData['fdatedelete'];
						$myArchivedorder->contentdeleted = $formData['fcontentdeleted'];
						$myArchivedorder->staffuser = $formData['fstaffuser'];
						$myArchivedorder->printtimes = $formData['fprinttimes'];
						$myArchivedorder->deliveryupdateuser = $formData['fdeliveryupdateuser'];
						$myArchivedorder->movetime = $formData['fmovetime'];
						$myArchivedorder->outputuser = $formData['foutputuser'];
						$myArchivedorder->deliveryuserupdatetime = $formData['fdeliveryuserupdatetime'];
						$myArchivedorder->deliveryuserupdateuser = $formData['fdeliveryuserupdateuser'];
						$myArchivedorder->customercarestausupdatetime = $formData['fcustomercarestausupdatetime'];
						$myArchivedorder->customercarestatusupdateuser = $formData['fcustomercarestatusupdateuser'];
						$myArchivedorder->contactid = $formData['fcontactid'];
						$myArchivedorder->customercode = $formData['fcustomercode'];
						$myArchivedorder->birthday = $formData['fbirthday'];
						$myArchivedorder->customeridcard = $formData['fcustomeridcard'];
						$myArchivedorder->createdapplicationid = $formData['fcreatedapplicationid'];
						$myArchivedorder->iscreatefromoutputreceipt = $formData['fiscreatefromoutputreceipt'];
						$myArchivedorder->iscreatefromsimprocessreq = $formData['fiscreatefromsimprocessreq'];
						$myArchivedorder->bankvoucher = $formData['fbankvoucher'];
						$myArchivedorder->processuser = $formData['fprocessuser'];
						$myArchivedorder->contractid = $formData['fcontractid'];
						$myArchivedorder->isinputimeicomplete = $formData['fisinputimeicomplete'];
						$myArchivedorder->organizationname = $formData['forganizationname'];
						$myArchivedorder->positionname = $formData['fpositionname'];
						$myArchivedorder->currentreviewlevelid = $formData['fcurrentreviewlevelid'];
						$myArchivedorder->mspromotionlevelidlist = $formData['fmspromotionlevelidlist'];
						$myArchivedorder->crmcustomercardcode = $formData['fcrmcustomercardcode'];
						$myArchivedorder->iswarningduplicatesaleorder = $formData['fiswarningduplicatesaleorder'];
						$myArchivedorder->duplicatesaleorderid = $formData['fduplicatesaleorderid'];
						$myArchivedorder->pointpaid = $formData['fpointpaid'];

						if($myArchivedorder->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('archivedorder_edit', $myArchivedorder->id, array());
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}


			}


			$_SESSION['archivedorderEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
			                                          'redirectUrl'=> $redirectUrl,
			                                          'error'		=> $error,
			                                          'success'	=> $success,

			                                ));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
			                                     'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
			                                     'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
			                                      'redirectMsg' => $redirectMsg,
			                                ));
			$this->registry->smarty->display('redirect.tpl');
		}
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myArchivedorder = new Core_Archivedorder($id);
		if($myArchivedorder->id > 0)
		{
			//tien hanh xoa
			if($myArchivedorder->delete())
			{
				$redirectMsg = str_replace('###id###', $myArchivedorder->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('archivedorder_delete', $myArchivedorder->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myArchivedorder->id, $this->registry->lang['controller']['errDelete']);
			}
			
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}
		
		$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												'redirectMsg' => $redirectMsg,
												));
		$this->registry->smarty->display('redirect.tpl');
			
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fsaleorderid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSaleorderidRequired'];
			$pass = false;
		}

		if($formData['fordertypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errOrdertypeidRequired'];
			$pass = false;
		}

		if($formData['fdeliverytypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliverytypeidRequired'];
			$pass = false;
		}

		if($formData['fcompanyid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCompanyidRequired'];
			$pass = false;
		}

		if($formData['fcustomerid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomeridRequired'];
			$pass = false;
		}

		if($formData['fcustomername'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomernameRequired'];
			$pass = false;
		}

		if($formData['fcustomeraddress'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomeraddressRequired'];
			$pass = false;
		}

		if($formData['fcustomerphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomerphoneRequired'];
			$pass = false;
		}

		if($formData['fcontactname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContactnameRequired'];
			$pass = false;
		}

		if($formData['fgender'] == '')
		{
			$error[] = $this->registry->lang['controller']['errGenderRequired'];
			$pass = false;
		}

		if($formData['fageid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errAgeidRequired'];
			$pass = false;
		}

		if($formData['fdeliveryaddress'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliveryaddressRequired'];
			$pass = false;
		}

		if($formData['fprovinceid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errProvinceidRequired'];
			$pass = false;
		}

		if($formData['fdistrictid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDistrictidRequired'];
			$pass = false;
		}

		if($formData['fisreviewed'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsreviewedRequired'];
			$pass = false;
		}

		if($formData['fpayabletypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPayabletypeidRequired'];
			$pass = false;
		}

		if($formData['fcurrencyunitid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCurrencyunitidRequired'];
			$pass = false;
		}

		if($formData['fcurrencyexchange'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCurrencyexchangeRequired'];
			$pass = false;
		}

		if($formData['ftotalquantity'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalquantityRequired'];
			$pass = false;
		}

		if($formData['ftotalamount'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalamountRequired'];
			$pass = false;
		}

		if($formData['ftotaladvance'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotaladvanceRequired'];
			$pass = false;
		}

		if($formData['fshippingcost'] == '')
		{
			$error[] = $this->registry->lang['controller']['errShippingcostRequired'];
			$pass = false;
		}

		if($formData['fdebt'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDebtRequired'];
			$pass = false;
		}

		if($formData['fdiscountreasonid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDiscountreasonidRequired'];
			$pass = false;
		}

		if($formData['fdiscount'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDiscountRequired'];
			$pass = false;
		}

		if($formData['foriginatestoreid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errOriginatestoreidRequired'];
			$pass = false;
		}

		if($formData['fisoutproduct'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsoutproductRequired'];
			$pass = false;
		}

		if($formData['foutputstoreid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errOutputstoreidRequired'];
			$pass = false;
		}

		if($formData['fisincome'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsincomeRequired'];
			$pass = false;
		}

		if($formData['fisdeleted'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsdeletedRequired'];
			$pass = false;
		}

		if($formData['fpromotiondiscount'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPromotiondiscountRequired'];
			$pass = false;
		}

		if($formData['fvouchertypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errVouchertypeidRequired'];
			$pass = false;
		}

		if($formData['fvoucherconcern'] == '')
		{
			$error[] = $this->registry->lang['controller']['errVoucherconcernRequired'];
			$pass = false;
		}

		if($formData['fdeliveryuser'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliveryuserRequired'];
			$pass = false;
		}

		if($formData['fsaleprogramid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSaleprogramidRequired'];
			$pass = false;
		}

		if($formData['ftotalpaid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalpaidRequired'];
			$pass = false;
		}

		if($formData['fissmspromotion'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIssmspromotionRequired'];
			$pass = false;
		}

		if($formData['fdeliverytime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliverytimeRequired'];
			$pass = false;
		}

		if($formData['fisdelivery'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsdeliveryRequired'];
			$pass = false;
		}

		if($formData['fdeliveryupdatetime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliveryupdatetimeRequired'];
			$pass = false;
		}

		if($formData['fismove'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsmoveRequired'];
			$pass = false;
		}

		if($formData['fparentsaleorderid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errParentsaleorderidRequired'];
			$pass = false;
		}

		if($formData['fthirdpartyvoucher'] == '')
		{
			$error[] = $this->registry->lang['controller']['errThirdpartyvoucherRequired'];
			$pass = false;
		}

		if($formData['fpayabletime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPayabletimeRequired'];
			$pass = false;
		}

		if($formData['fcreatedbyotherapps'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCreatedbyotherappsRequired'];
			$pass = false;
		}

		if($formData['fcontactphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContactphoneRequired'];
			$pass = false;
		}

		if($formData['fcustomercarestatusid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomercarestatusidRequired'];
			$pass = false;
		}

		if($formData['ftotalprepaid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalprepaidRequired'];
			$pass = false;
		}

		if($formData['fcrmcustomerid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCrmcustomeridRequired'];
			$pass = false;
		}

		if($formData['fdatearchived'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDatearchivedRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fsaleorderid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSaleorderidRequired'];
			$pass = false;
		}

		if($formData['fordertypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errOrdertypeidRequired'];
			$pass = false;
		}

		if($formData['fdeliverytypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliverytypeidRequired'];
			$pass = false;
		}

		if($formData['fcompanyid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCompanyidRequired'];
			$pass = false;
		}

		if($formData['fcustomerid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomeridRequired'];
			$pass = false;
		}

		if($formData['fcustomername'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomernameRequired'];
			$pass = false;
		}

		if($formData['fcustomeraddress'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomeraddressRequired'];
			$pass = false;
		}

		if($formData['fcustomerphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomerphoneRequired'];
			$pass = false;
		}

		if($formData['fcontactname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContactnameRequired'];
			$pass = false;
		}

		if($formData['fgender'] == '')
		{
			$error[] = $this->registry->lang['controller']['errGenderRequired'];
			$pass = false;
		}

		if($formData['fageid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errAgeidRequired'];
			$pass = false;
		}

		if($formData['fdeliveryaddress'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliveryaddressRequired'];
			$pass = false;
		}

		if($formData['fprovinceid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errProvinceidRequired'];
			$pass = false;
		}

		if($formData['fdistrictid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDistrictidRequired'];
			$pass = false;
		}

		if($formData['fisreviewed'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsreviewedRequired'];
			$pass = false;
		}

		if($formData['fpayabletypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPayabletypeidRequired'];
			$pass = false;
		}

		if($formData['fcurrencyunitid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCurrencyunitidRequired'];
			$pass = false;
		}

		if($formData['fcurrencyexchange'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCurrencyexchangeRequired'];
			$pass = false;
		}

		if($formData['ftotalquantity'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalquantityRequired'];
			$pass = false;
		}

		if($formData['ftotalamount'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalamountRequired'];
			$pass = false;
		}

		if($formData['ftotaladvance'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotaladvanceRequired'];
			$pass = false;
		}

		if($formData['fshippingcost'] == '')
		{
			$error[] = $this->registry->lang['controller']['errShippingcostRequired'];
			$pass = false;
		}

		if($formData['fdebt'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDebtRequired'];
			$pass = false;
		}

		if($formData['fdiscountreasonid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDiscountreasonidRequired'];
			$pass = false;
		}

		if($formData['fdiscount'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDiscountRequired'];
			$pass = false;
		}

		if($formData['foriginatestoreid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errOriginatestoreidRequired'];
			$pass = false;
		}

		if($formData['fisoutproduct'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsoutproductRequired'];
			$pass = false;
		}

		if($formData['foutputstoreid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errOutputstoreidRequired'];
			$pass = false;
		}

		if($formData['fisincome'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsincomeRequired'];
			$pass = false;
		}

		if($formData['fisdeleted'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsdeletedRequired'];
			$pass = false;
		}

		if($formData['fpromotiondiscount'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPromotiondiscountRequired'];
			$pass = false;
		}

		if($formData['fvouchertypeid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errVouchertypeidRequired'];
			$pass = false;
		}

		if($formData['fvoucherconcern'] == '')
		{
			$error[] = $this->registry->lang['controller']['errVoucherconcernRequired'];
			$pass = false;
		}

		if($formData['fdeliveryuser'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliveryuserRequired'];
			$pass = false;
		}

		if($formData['fsaleprogramid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSaleprogramidRequired'];
			$pass = false;
		}

		if($formData['ftotalpaid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalpaidRequired'];
			$pass = false;
		}

		if($formData['fissmspromotion'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIssmspromotionRequired'];
			$pass = false;
		}

		if($formData['fdeliverytime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliverytimeRequired'];
			$pass = false;
		}

		if($formData['fisdelivery'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsdeliveryRequired'];
			$pass = false;
		}

		if($formData['fdeliveryupdatetime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDeliveryupdatetimeRequired'];
			$pass = false;
		}

		if($formData['fismove'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIsmoveRequired'];
			$pass = false;
		}

		if($formData['fparentsaleorderid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errParentsaleorderidRequired'];
			$pass = false;
		}

		if($formData['fthirdpartyvoucher'] == '')
		{
			$error[] = $this->registry->lang['controller']['errThirdpartyvoucherRequired'];
			$pass = false;
		}

		if($formData['fpayabletime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPayabletimeRequired'];
			$pass = false;
		}

		if($formData['fcreatedbyotherapps'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCreatedbyotherappsRequired'];
			$pass = false;
		}

		if($formData['fcontactphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContactphoneRequired'];
			$pass = false;
		}

		if($formData['fcustomercarestatusid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCustomercarestatusidRequired'];
			$pass = false;
		}

		if($formData['ftotalprepaid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTotalprepaidRequired'];
			$pass = false;
		}

		if($formData['fcrmcustomerid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCrmcustomeridRequired'];
			$pass = false;
		}

		if($formData['fdatearchived'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDatearchivedRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

