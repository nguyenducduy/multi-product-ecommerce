<?php

Class Controller_Cms_Installment Extends Controller_Cms_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		//kiem tra user co quyen vao xem trang nay hay khong ?
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_VIEWORDER , 'fuid' => $this->registry->me->id), 'id', 'ASC' , '' , true);
			if($roleusers == 0)
			{
				header('location: ' . $this->registry['conf']['rooturl'] . 'a'.$this->registry->me->id.'/home');
				exit();
			}
		}

		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$pidFilter = (int)($this->registry->router->getArg('pid'));
		$invoiceidFilter = (string)($this->registry->router->getArg('invoiceid'));
		$orderCRMFilter = (string)($this->registry->router->getArg('orderidcrm'));
		$phoneFilter = (string)($this->registry->router->getArg('phone'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
        $idFilter = (int)($this->registry->router->getArg('id'));

        $startcreatedFilter = (string)(isset($_GET['fstartdate'])? urldecode($_GET['fstartdate']) :'');
		$endcreatedFilter = (string)(isset($_GET['fenddate'])? urldecode($_GET['fenddate']) :'');

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['installmentBulkToken']==$_POST['ftoken'])
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
                            $myInstallment = new Core_Installment($id);

                            if($myInstallment->id > 0)
                            {
                                //tien hanh xoa
                                if($myInstallment->delete())
                                {
                                    $deletedItems[] = $myInstallment->id;
                                    $this->registry->me->writelog('installment_delete', $myInstallment->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myInstallment->id;
                            }
                            else
                                $cannotDeletedItems[] = $myInstallment->id;
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

		$_SESSION['installmentBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';

		if($orderCRMFilter == -1) {//!empty($_POST['fsubmitbulk'])
			$paginateUrl .= 'orderidcrm/-1/';
			$formData['fisorderidcrm'] = 1;
			$formData['search'] = 'orderidcrm';
		}

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($invoiceidFilter != "")
		{
			$paginateUrl .= 'invoiceid/'.$invoiceidFilter . '/';
			$formData['finvoiceid'] = $invoiceidFilter;
			$formData['search'] = 'invoiceid';
		}

		if($phoneFilter != "")
		{
			$paginateUrl .= 'phone/'.$phoneFilter . '/';
			$formData['fphone'] = $phoneFilter;
			$formData['search'] = 'phone';
		}

        if($emailFilter != "")
        {
            $paginateUrl .= 'email/'.$emailFilter . '/';
            $formData['femail'] = $emailFilter;
            $formData['search'] = 'email';
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

			if($searchKeywordIn == 'invoiceid')
			{
				$paginateUrl .= 'searchin/invoiceid/';
			}
			elseif($searchKeywordIn == 'phone')
			{
				$paginateUrl .= 'searchin/phone/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		if($startcreatedFilter != "")
        {
            //$paginateUrl .= '?fstartdate=' . urlencode($startcreatedFilter) . '&fenddate=' . urlencode( $endcreatedFilter);
            $formData['fstartdate'] = (int)Helper::strtotimedmy($startcreatedFilter, '00:00:00');
            $formData['fenddate'] = (int)Helper::strtotimedmy($endcreatedFilter, '23:59:59');
        }

        //tim tong so
		$total = Core_Installment::getInstallments($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$installments = Core_Installment::getInstallments($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;

        $paginateUrl2 = '';
        if($startcreatedFilter != "")
        {
            $paginateUrl2 = '?fstartdate=' . urlencode($startcreatedFilter) . '&fenddate=' . urlencode( $endcreatedFilter);
            $redirectUrl .= '?fstartdate=' . urlencode($startcreatedFilter) . '&fenddate=' . urlencode( $endcreatedFilter);
        }
		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'installments' 	=> $installments,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
                                                'paginateurl'   => $paginateUrl,
												'paginateurl2' 	=> $paginateUrl2,
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

    function detailAction()
    {
		//kiem tra user co quyen vao xem trang nay hay khong ?
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_VIEWORDER , 'fuid' => $this->registry->me->id), 'id', 'ASC' , '' , true);
			if($roleusers == 0)
			{
				header('location: ' . $this->registry['conf']['rooturl'] . 'a'.$this->registry->me->id.'/home');
				exit();
			}
		}

        $id = (int)$this->registry->router->getArg('id');
        if($id <= 0)
        {
            header('Location: '.$this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller);
        }
        $orderInstallment = new Core_Installment($id);
        if($orderInstallment->id <= 0)
        {
            header('Location: '.$this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller);
        }
        $orderInstallment->product = new Core_Installment($orderInstallment->pid);
        $getprepaid = Core_Installment::calcInstallment($orderInstallment->pricesell, $orderInstallment->segmentpercent/100, $orderInstallment->installmentmonth, $orderInstallment->product->pcid);
        $this->registry->smarty->assign(array(
                                            'oneOrder' => $orderInstallment,
                                            'getprepaid' => $getprepaid
                                        ));
        $this->registry->smarty->display($this->registry->smartyControllerContainer.'detail.tpl');
    }

	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['installmentAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myInstallment = new Core_Installment();


					$myInstallment->pid = $formData['fpid'];
					$myInstallment->invoiceid = $formData['finvoiceid'];
					$myInstallment->pricesell = $formData['fpricesell'];
					$myInstallment->pricemonthly = $formData['fpricemonthly'];
					$myInstallment->gender = $formData['fgender'];
					$myInstallment->fullname = $formData['ffullname'];
					$myInstallment->phone = $formData['fphone'];
					$myInstallment->email = $formData['femail'];
					$myInstallment->birthday = $formData['fbirthday'];
					$myInstallment->personalid = $formData['fpersonalid'];
					$myInstallment->personaltype = $formData['fpersonaltype'];
					$myInstallment->address = $formData['faddress'];
					$myInstallment->region = $formData['fregion'];
					$myInstallment->regionresident = $formData['fregionresident'];
					$myInstallment->installmentmonth = $formData['finstallmentmonth'];
					$myInstallment->segmentpercent = $formData['fsegmentpercent'];
					$myInstallment->payathome = $formData['fpayathome'];

                    if($myInstallment->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('installment_add', $myInstallment->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['installmentAddToken']=Helper::getSecurityToken();//Tao token moi

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
		$myInstallment = new Core_Installment($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myInstallment->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fpid'] = $myInstallment->pid;
			$formData['fid'] = $myInstallment->id;
			$formData['finvoiceid'] = $myInstallment->invoiceid;
			$formData['fpricesell'] = $myInstallment->pricesell;
			$formData['fpricemonthly'] = $myInstallment->pricemonthly;
			$formData['fgender'] = $myInstallment->gender;
			$formData['ffullname'] = $myInstallment->fullname;
			$formData['fphone'] = $myInstallment->phone;
			$formData['femail'] = $myInstallment->email;
			$formData['fbirthday'] = $myInstallment->birthday;
			$formData['fpersonalid'] = $myInstallment->personalid;
			$formData['fpersonaltype'] = $myInstallment->personaltype;
			$formData['faddress'] = $myInstallment->address;
			$formData['fregion'] = $myInstallment->region;
			$formData['fregionresident'] = $myInstallment->regionresident;
			$formData['finstallmentmonth'] = $myInstallment->installmentmonth;
			$formData['fsegmentpercent'] = $myInstallment->segmentpercent;
			$formData['fpayathome'] = $myInstallment->payathome;
			$formData['fdatecreate'] = $myInstallment->datecreate;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['installmentEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myInstallment->pid = $formData['fpid'];
						$myInstallment->invoiceid = $formData['finvoiceid'];
						$myInstallment->pricesell = $formData['fpricesell'];
						$myInstallment->pricemonthly = $formData['fpricemonthly'];
						$myInstallment->gender = $formData['fgender'];
						$myInstallment->fullname = $formData['ffullname'];
						$myInstallment->phone = $formData['fphone'];
						$myInstallment->email = $formData['femail'];
						$myInstallment->birthday = $formData['fbirthday'];
						$myInstallment->personalid = $formData['fpersonalid'];
						$myInstallment->personaltype = $formData['fpersonaltype'];
						$myInstallment->address = $formData['faddress'];
						$myInstallment->region = $formData['fregion'];
						$myInstallment->regionresident = $formData['fregionresident'];
						$myInstallment->installmentmonth = $formData['finstallmentmonth'];
						$myInstallment->segmentpercent = $formData['fsegmentpercent'];
						$myInstallment->payathome = $formData['fpayathome'];

                        if($myInstallment->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('installment_edit', $myInstallment->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['installmentEditToken'] = Helper::getSecurityToken();//Tao token moi

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
		$myInstallment = new Core_Installment($id);
		if($myInstallment->id > 0)
		{
			//tien hanh xoa
			if($myInstallment->delete())
			{
				$redirectMsg = str_replace('###id###', $myInstallment->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('installment_delete', $myInstallment->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myInstallment->id, $this->registry->lang['controller']['errDelete']);
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



		if($formData['finvoiceid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errInvoiceidRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['finvoiceid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errInvoiceidRequired'];
			$pass = false;
		}

		return $pass;
	}

	public function syncrmajaxAction()
    {
		$arrresult = array('success' => 2);
		$idtragop = (int)(isset($_POST['iid'])?$_POST['iid']:0);
        if($idtragop > 0)
        {
			$myInstallment = new Core_Installment($idtragop);
	        if($myInstallment->id > 0)
	        {
	            $myProduct = new Core_Product($myInstallment->pid);
	            if($myProduct->id > 0)
	            {
	                $finalPrice = Core_RelRegionPricearea::getPriceByProductRegion(trim($myProduct->barcode), $myInstallment->region);
	                if(!empty($finalPrice)) {
	                    $myProduct->sellprice = $finalPrice;
	                }
	                $ctnit = 0;
	                $crm_listpro = array();
	                $crm_listpro[$ctnit]['PRODUCTID'] = (int)$myProduct->id;
	                $crm_listpro[$ctnit]['QUANTITY'] = 1;
	                $crm_listpro[$ctnit]['PRODUCTCODE'] = (string)trim($myProduct->barcode);
	                $crm_listpro[$ctnit]['IMEI'] = '';
	                $crm_listpro[$ctnit]['CATEGORYID'] = (int)$myProduct->pcid;
	                $crm_listpro[$ctnit]['PRICE'] = (double)$myProduct->sellprice;
	                $crm_listpro[$ctnit]['ADJUSTPRICE'] = (string)$myProduct->sellprice;

	                $arr = array();
	                $arr['strFullname']               = (string)$myInstallment->fullname;
	                $arr['strAddress']                = (string)$myInstallment->address;
	                $arr['strBillAddress']            = (string)$myInstallment->address;
	                $arr['strShippAddress']           = (string)$myInstallment->address;
	                $arr['strEmail']                  = $myInstallment->email;
	                $arr['strPhone']                  = preg_replace('/[^0-9]/','', $myInstallment->phone);
	                $arr['strPersonalID']             = $myInstallment->personalid;
	                $arr['strNote']                   = 'Tỷ lệ trả trước '.$myInstallment->segmentpercent.'%';
	                $arr['intGender']                 = ($myInstallment->gender == Core_Installment::GENDER_MALE ? 1: 0);
	                $arr['dtBirthdate']               = '02-12-1986';
	                $arr['strTaxNo']                  = '';
	                $arr['intStoreID']                = '';
	                $arr['intCountryID']              = 3;
	                $arr['intProvinceID']             = $myInstallment->region;
	                $arr['intDistrictID']             = 0;
	                $arr['intPayment']                = 0;
	                $arr['intDelivery']               = 0;
	                $arr['dbShippingCost']            = 0.0;
	                $arr['intCurrencyUnit']           = 0;
	                $arr['dbCurrencyExchange']        = 0.0;
	                $arr['lstProductList2']            = json_encode($crm_listpro);
	                $arr['strAccountSecretInfo']      = '';
	                $arr['strCouponCode']             = '';
	                $arr['flCouponDiscount']          = 0.0;
	                $arr['strOWNERBANKNAME']          = '';
	                $arr['intTemporaryProvince'] = $myInstallment->region;
	                $arr['longRepaymentMonths'] = $myInstallment->installmentmonth;
	                $arr['string strCareerStatusCode'] = ($myInstallment->personaltype==Core_Installment::TYPE_NGUOIDILAM?'CN':'SV');
	                $arr['strInvoiceCode'] = $myInstallment->invoiceid;
	                $arr['username'] = '';
	                $arr['password'] = '';
	                $arr['intProgramID'] = 35;
	                $saleOrder = new Core_Saleorder();
	                $installmentId = $saleOrder->addinstallmentCRM($arr);
	                //$installmentId = 472933;
	                if(!empty($installmentId) && is_numeric($installmentId))
	                {
	                    $myInstallment->installmentcrm = $installmentId;
	                    $myInstallment->installmentcrmdate = time();
	                    $myInstallment->updateData();
	                    $arrresult['success'] = 1;
	                }
	            }
	        }
        }

		echo json_encode($arrresult);
    }
}

