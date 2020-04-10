<?php

	Class Controller_Crm_ArchivedorderDetail Extends Controller_Cms_Base
	{
		private $recordPerPage = 20;

		function indexAction()
		{
			$error                     = array();
			$success                   = array();
			$warning                   = array();
			$formData                  = array('fbulkid' => array());
			$_SESSION['securityToken'] = Helper::getSecurityToken(); //Token
			$page                      = (int)($this->registry->router->getArg('page')) > 0 ? (int)($this->registry->router->getArg('page')) : 1;


			$saleorderidFilter = (string)($this->registry->router->getArg('saleorderid'));
			$productidFilter   = (string)($this->registry->router->getArg('productid'));
			$salepriceFilter   = (int)($this->registry->router->getArg('saleprice'));
			$retailpriceFilter = (int)($this->registry->router->getArg('retailprice'));
			$idFilter          = (int)($this->registry->router->getArg('id'));

			$keywordFilter   = (string)$this->registry->router->getArg('keyword');
			$searchKeywordIn = (string)$this->registry->router->getArg('searchin');

			//check sort column condition
			$sortby = $this->registry->router->getArg('sortby');
			if ($sortby == '') {
				$sortby = 'id';
			}
			$formData['sortby'] = $sortby;
			$sorttype           = $this->registry->router->getArg('sorttype');
			if (strtoupper($sorttype) != 'ASC') {
				$sorttype = 'DESC';
			}
			$formData['sorttype'] = $sorttype;


			if (!empty($_POST['fsubmitbulk'])) {
				if ($_SESSION['archivedorderdetailBulkToken'] == $_POST['ftoken']) {
					if (!isset($_POST['fbulkid'])) {
						$warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
					}
					else {
						$formData['fbulkid'] = $_POST['fbulkid'];

						//check for delete
						if ($_POST['fbulkaction'] == 'delete') {
							$delArr             = $_POST['fbulkid'];
							$deletedItems       = array();
							$cannotDeletedItems = array();
							foreach ($delArr as $id) {
								//check valid user and not admin user
								$myArchivedorderDetail = new Core_ArchivedorderDetail($id);

								if ($myArchivedorderDetail->id > 0) {
									//tien hanh xoa
									if ($myArchivedorderDetail->delete()) {
										$deletedItems[] = $myArchivedorderDetail->id;
										$this->registry->me->writelog('archivedorderdetail_delete', $myArchivedorderDetail->id, array());
									}
									else {
										$cannotDeletedItems[] = $myArchivedorderDetail->id;
									}
								}
								else {
									$cannotDeletedItems[] = $myArchivedorderDetail->id;
								}
							}

							if (count($deletedItems) > 0) {
								$success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);
							}

							if (count($cannotDeletedItems) > 0) {
								$error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
							}
						}
						else {
							//bulk action not select, show error
							$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
						}
					}
				}

			}

			$_SESSION['archivedorderdetailBulkToken'] = Helper::getSecurityToken(); //Gan token de kiem soat viec nhan nut submit form

			$paginateUrl = $this->registry->conf['rooturl'] . $this->registry->controllerGroup . '/' . $this->registry->controller . '/index/';


			if ($saleorderidFilter != "") {
				$paginateUrl .= 'saleorderid/' . $saleorderidFilter . '/';
				$formData['fsaleorderid'] = $saleorderidFilter;
				$formData['search']       = 'saleorderid';
			}

			if ($productidFilter != "") {
				$paginateUrl .= 'productid/' . $productidFilter . '/';
				$formData['fproductid'] = $productidFilter;
				$formData['search']     = 'productid';
			}

			if ($salepriceFilter > 0) {
				$paginateUrl .= 'saleprice/' . $salepriceFilter . '/';
				$formData['fsaleprice'] = $salepriceFilter;
				$formData['search']     = 'saleprice';
			}

			if ($retailpriceFilter > 0) {
				$paginateUrl .= 'retailprice/' . $retailpriceFilter . '/';
				$formData['fretailprice'] = $retailpriceFilter;
				$formData['search']       = 'retailprice';
			}

			if ($idFilter > 0) {
				$paginateUrl .= 'id/' . $idFilter . '/';
				$formData['fid']    = $idFilter;
				$formData['search'] = 'id';
			}

			if (strlen($keywordFilter) > 0) {
				$paginateUrl .= 'keyword/' . $keywordFilter . '/';

				if ($searchKeywordIn == 'productid') {
					$paginateUrl .= 'searchin/productid/';
				}
				$formData['fkeyword']  = $formData['fkeywordFilter'] = $keywordFilter;
				$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
				$formData['search']    = 'keyword';
			}

			//tim tong so
			$total     = Core_ArchivedorderDetail::getArchivedorderDetails($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total / $this->recordPerPage);
			$curPage   = $page;


			//get latest account
			$archivedorderdetails = Core_ArchivedorderDetail::getArchivedorderDetails($formData, $sortby, $sorttype, (($page - 1) * $this->recordPerPage) . ',' . $this->recordPerPage);

			//filter for sortby & sorttype
			$filterUrl = $paginateUrl;

			//append sort to paginate url
			$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


			//build redirect string
			$redirectUrl = $paginateUrl;
			if ($curPage > 1) {
				$redirectUrl .= 'page/' . $curPage;
			}


			$redirectUrl = base64_encode($redirectUrl);


			$this->registry->smarty->assign(array('archivedorderdetails' => $archivedorderdetails,
												  'formData' => $formData,
												  'success' => $success,
												  'error' => $error,
												  'warning' => $warning,
												  'filterUrl' => $filterUrl,
												  'paginateurl' => $paginateUrl,
												  'redirectUrl' => $redirectUrl,
												  'total' => $total,
												  'totalPage' => $totalPage,
												  'curPage' => $curPage,));


			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');

			$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
												  'contents' => $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		}


		function addAction()
		{
			$error    = array();
			$success  = array();
			$contents = '';
			$formData = array();

			if (!empty($_POST['fsubmit'])) {
				if ($_SESSION['archivedorderdetailAddToken'] == $_POST['ftoken']) {
					$formData = array_merge($formData, $_POST);


					if ($this->addActionValidator($formData, $error)) {
						$myArchivedorderDetail = new Core_ArchivedorderDetail();


						$myArchivedorderDetail->saleorderid          = $formData['fsaleorderid'];
						$myArchivedorderDetail->productid            = $formData['fproductid'];
						$myArchivedorderDetail->quantity             = $formData['fquantity'];
						$myArchivedorderDetail->saleprice            = $formData['fsaleprice'];
						$myArchivedorderDetail->outputtypeid         = $formData['foutputtypeid'];
						$myArchivedorderDetail->vat                  = $formData['fvat'];
						$myArchivedorderDetail->salepriceerp         = $formData['fsalepriceerp'];
						$myArchivedorderDetail->endwarrantytime      = $formData['fendwarrantytime'];
						$myArchivedorderDetail->ispromotionautoadd   = $formData['fispromotionautoadd'];
						$myArchivedorderDetail->promotionid          = $formData['fpromotionid'];
						$myArchivedorderDetail->promotionlistgroupid = $formData['fpromotionlistgroupid'];
						$myArchivedorderDetail->applyproductid       = $formData['fapplyproductid'];
						$myArchivedorderDetail->replicationstoreid   = $formData['freplicationstoreid'];
						$myArchivedorderDetail->adjustpricetypeid    = $formData['fadjustpricetypeid'];
						$myArchivedorderDetail->adjustprice          = $formData['fadjustprice'];
						$myArchivedorderDetail->adjustpricecontent   = $formData['fadjustpricecontent'];
						$myArchivedorderDetail->discountcode         = $formData['fdiscountcode'];
						$myArchivedorderDetail->adjustpriceuser      = $formData['fadjustpriceuser'];
						$myArchivedorderDetail->vatpercent           = $formData['fvatpercent'];
						$myArchivedorderDetail->retailprice          = $formData['fretailprice'];
						$myArchivedorderDetail->inputvoucherdetailid = $formData['finputvoucherdetailid'];
						$myArchivedorderDetail->buyinputvoucherid    = $formData['fbuyinputvoucherid'];
						$myArchivedorderDetail->inputvoucherdate     = $formData['finputvoucherdate'];
						$myArchivedorderDetail->isnew                = $formData['fisnew'];
						$myArchivedorderDetail->isshowproduct        = $formData['fisshowproduct'];
						$myArchivedorderDetail->costprice            = $formData['fcostprice'];
						$myArchivedorderDetail->productsaleskitid    = $formData['fproductsaleskitid'];
						$myArchivedorderDetail->refproductid         = $formData['frefproductid'];
						$myArchivedorderDetail->productcomboid       = $formData['fproductcomboid'];

						if ($myArchivedorderDetail->addData()) {
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('archivedorderdetail_add', $myArchivedorderDetail->id, array());
							$formData = array();
						}
						else {
							$error[] = $this->registry->lang['controller']['errAdd'];
						}
					}
				}

			}

			$_SESSION['archivedorderdetailAddToken'] = Helper::getSecurityToken(); //Tao token moi

			$this->registry->smarty->assign(array('formData' => $formData,
												  'redirectUrl' => $this->getRedirectUrl(),
												  'error' => $error,
												  'success' => $success,

											));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'add.tpl');
			$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_add'],
												  'contents' => $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}


		function editAction()
		{
			$id                    = (int)$this->registry->router->getArg('id');
			$myArchivedorderDetail = new Core_ArchivedorderDetail($id);

			$redirectUrl = $this->getRedirectUrl();
			if ($myArchivedorderDetail->id > 0) {
				$error    = array();
				$success  = array();
				$contents = '';
				$formData = array();

				$formData['fbulkid'] = array();


				$formData['fpid']                  = $myArchivedorderDetail->pid;
				$formData['foorderid']             = $myArchivedorderDetail->oorderid;
				$formData['fid']                   = $myArchivedorderDetail->id;
				$formData['fsaleorderid']          = $myArchivedorderDetail->saleorderid;
				$formData['fproductid']            = $myArchivedorderDetail->productid;
				$formData['fquantity']             = $myArchivedorderDetail->quantity;
				$formData['fsaleprice']            = $myArchivedorderDetail->saleprice;
				$formData['foutputtypeid']         = $myArchivedorderDetail->outputtypeid;
				$formData['fvat']                  = $myArchivedorderDetail->vat;
				$formData['fsalepriceerp']         = $myArchivedorderDetail->salepriceerp;
				$formData['fendwarrantytime']      = $myArchivedorderDetail->endwarrantytime;
				$formData['fispromotionautoadd']   = $myArchivedorderDetail->ispromotionautoadd;
				$formData['fpromotionid']          = $myArchivedorderDetail->promotionid;
				$formData['fpromotionlistgroupid'] = $myArchivedorderDetail->promotionlistgroupid;
				$formData['fapplyproductid']       = $myArchivedorderDetail->applyproductid;
				$formData['freplicationstoreid']   = $myArchivedorderDetail->replicationstoreid;
				$formData['fadjustpricetypeid']    = $myArchivedorderDetail->adjustpricetypeid;
				$formData['fadjustprice']          = $myArchivedorderDetail->adjustprice;
				$formData['fadjustpricecontent']   = $myArchivedorderDetail->adjustpricecontent;
				$formData['fdiscountcode']         = $myArchivedorderDetail->discountcode;
				$formData['fadjustpriceuser']      = $myArchivedorderDetail->adjustpriceuser;
				$formData['fvatpercent']           = $myArchivedorderDetail->vatpercent;
				$formData['fretailprice']          = $myArchivedorderDetail->retailprice;
				$formData['finputvoucherdetailid'] = $myArchivedorderDetail->inputvoucherdetailid;
				$formData['fbuyinputvoucherid']    = $myArchivedorderDetail->buyinputvoucherid;
				$formData['finputvoucherdate']     = $myArchivedorderDetail->inputvoucherdate;
				$formData['fisnew']                = $myArchivedorderDetail->isnew;
				$formData['fisshowproduct']        = $myArchivedorderDetail->isshowproduct;
				$formData['fcostprice']            = $myArchivedorderDetail->costprice;
				$formData['fproductsaleskitid']    = $myArchivedorderDetail->productsaleskitid;
				$formData['frefproductid']         = $myArchivedorderDetail->refproductid;
				$formData['fproductcomboid']       = $myArchivedorderDetail->productcomboid;

				if (!empty($_POST['fsubmit'])) {
					if ($_SESSION['archivedorderdetailEditToken'] == $_POST['ftoken']) {
						$formData = array_merge($formData, $_POST);

						if ($this->editActionValidator($formData, $error)) {

							$myArchivedorderDetail->saleorderid          = $formData['fsaleorderid'];
							$myArchivedorderDetail->productid            = $formData['fproductid'];
							$myArchivedorderDetail->quantity             = $formData['fquantity'];
							$myArchivedorderDetail->saleprice            = $formData['fsaleprice'];
							$myArchivedorderDetail->outputtypeid         = $formData['foutputtypeid'];
							$myArchivedorderDetail->vat                  = $formData['fvat'];
							$myArchivedorderDetail->salepriceerp         = $formData['fsalepriceerp'];
							$myArchivedorderDetail->endwarrantytime      = $formData['fendwarrantytime'];
							$myArchivedorderDetail->ispromotionautoadd   = $formData['fispromotionautoadd'];
							$myArchivedorderDetail->promotionid          = $formData['fpromotionid'];
							$myArchivedorderDetail->promotionlistgroupid = $formData['fpromotionlistgroupid'];
							$myArchivedorderDetail->applyproductid       = $formData['fapplyproductid'];
							$myArchivedorderDetail->replicationstoreid   = $formData['freplicationstoreid'];
							$myArchivedorderDetail->adjustpricetypeid    = $formData['fadjustpricetypeid'];
							$myArchivedorderDetail->adjustprice          = $formData['fadjustprice'];
							$myArchivedorderDetail->adjustpricecontent   = $formData['fadjustpricecontent'];
							$myArchivedorderDetail->discountcode         = $formData['fdiscountcode'];
							$myArchivedorderDetail->adjustpriceuser      = $formData['fadjustpriceuser'];
							$myArchivedorderDetail->vatpercent           = $formData['fvatpercent'];
							$myArchivedorderDetail->retailprice          = $formData['fretailprice'];
							$myArchivedorderDetail->inputvoucherdetailid = $formData['finputvoucherdetailid'];
							$myArchivedorderDetail->buyinputvoucherid    = $formData['fbuyinputvoucherid'];
							$myArchivedorderDetail->inputvoucherdate     = $formData['finputvoucherdate'];
							$myArchivedorderDetail->isnew                = $formData['fisnew'];
							$myArchivedorderDetail->isshowproduct        = $formData['fisshowproduct'];
							$myArchivedorderDetail->costprice            = $formData['fcostprice'];
							$myArchivedorderDetail->productsaleskitid    = $formData['fproductsaleskitid'];
							$myArchivedorderDetail->refproductid         = $formData['frefproductid'];
							$myArchivedorderDetail->productcomboid       = $formData['fproductcomboid'];

							if ($myArchivedorderDetail->updateData()) {
								$success[] = $this->registry->lang['controller']['succUpdate'];
								$this->registry->me->writelog('archivedorderdetail_edit', $myArchivedorderDetail->id, array());
							}
							else {
								$error[] = $this->registry->lang['controller']['errUpdate'];
							}
						}
					}


				}


				$_SESSION['archivedorderdetailEditToken'] = Helper::getSecurityToken(); //Tao token moi

				$this->registry->smarty->assign(array('formData' => $formData,
													  'redirectUrl' => $redirectUrl,
													  'error' => $error,
													  'success' => $success,

												));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'edit.tpl');
				$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_edit'],
													  'contents' => $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
			else {
				$redirectMsg = $this->registry->lang['controller']['errNotFound'];
				$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													  'redirectMsg' => $redirectMsg,));
				$this->registry->smarty->display('redirect.tpl');
			}
		}

		function detailshowAction()
		{
			set_time_limit(0);
			$saleid    = $this->registry->router->getArg('saleid');
			$saleorder = Core_ArchivedorderDetail::getList('od_saleorderid="' . $saleid . '"', "", "");
			if (!empty($saleorder)) {
				$customer       = Core_Archivedorder::SaleorderFromDetail($saleid); /* trong database là saleorder nhung co luu tru thong tin khach hang*/
				$sale           = new Core_Saleorder();
				$saleorder_info = $sale->GetSaleOrderDetailInfo($customer['o_crmcustomerid'], $saleid);

				$formData['toltal']    = 0;
				$formData['toltalpay'] = 0;
				foreach ($saleorder as $key => $value) {
					$p = Core_Product::getIdByBarcode($value->productid);
					if ($p->id != "0") {
						$saleorder[$key]->productname = $p->name;
						$sync                         = Core_Product::getIdByBarcode($value->productid);
						if ($sync->id != "0") {
							if ($sync->image != null) {
								$saleorder[$key]->img = $this->registry->conf['rooturl'] . "uploads/product/" . $sync->image;
							}
							else {
								$saleorder[$key]->img = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
							}
						}
					}
					else {
						$saleorder[$key]->productname = 'Chưa đồng bộ';
						$saleorder[$key]->img         = $this->registry->conf['rooturl'] . "templates/default/images/noimage.jpg";
					}

					$formData['toltal'] = $value->retailprice + $formData['toltal'];
				}
				$formData['toltalpay'] = $formData['toltal'] - $saleorder_info[0]->discount;
				$this->registry->smarty->assign(array('formData' => $formData,
													  'saleorder' => $saleorder,
													  'saleorder_info' => $saleorder_info,
													  'customer' => $customer

												));
				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'saledetail.tpl');

				$this->registry->smarty->assign(array('menu' => 'useradd',
													  'pageTitle' => $this->registry->lang['controller']['pageTitle_saledetail'],
													  'contents' => $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
			else {
				$redirectUrl = $this->registry['conf']['rooturl_crm'] . "archivedorder";
				$redirectMsg = 'Dữ liệu test hoặc chưa đồng bộ';
				$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													  'redirectMsg' => $redirectMsg,));
				$this->registry->smarty->display('redirect.tpl');
			}
		}

		function deleteAction()
		{
			$id                    = (int)$this->registry->router->getArg('id');
			$myArchivedorderDetail = new Core_ArchivedorderDetail($id);
			if ($myArchivedorderDetail->id > 0) {
				//tien hanh xoa
				if ($myArchivedorderDetail->delete()) {
					$redirectMsg = str_replace('###id###', $myArchivedorderDetail->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('archivedorderdetail_delete', $myArchivedorderDetail->id, array());
				}
				else {
					$redirectMsg = str_replace('###id###', $myArchivedorderDetail->id, $this->registry->lang['controller']['errDelete']);
				}

			}
			else {
				$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			}

			$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												  'redirectMsg' => $redirectMsg,));
			$this->registry->smarty->display('redirect.tpl');

		}

		####################################################################################################
		####################################################################################################
		####################################################################################################

		//Kiem tra du lieu nhap trong form them moi
		private function addActionValidator($formData, &$error)
		{
			$pass = true;


			if ($formData['fsaleorderid'] == '') {
				$error[] = $this->registry->lang['controller']['errSaleorderidRequired'];
				$pass    = false;
			}

			if ($formData['fproductid'] == '') {
				$error[] = $this->registry->lang['controller']['errProductidRequired'];
				$pass    = false;
			}

			if ($formData['fquantity'] == '') {
				$error[] = $this->registry->lang['controller']['errQuantityRequired'];
				$pass    = false;
			}

			if ($formData['fsaleprice'] == '') {
				$error[] = $this->registry->lang['controller']['errSalepriceRequired'];
				$pass    = false;
			}

			if ($formData['foutputtypeid'] == '') {
				$error[] = $this->registry->lang['controller']['errOutputtypeidRequired'];
				$pass    = false;
			}

			if ($formData['fvat'] == '') {
				$error[] = $this->registry->lang['controller']['errVatRequired'];
				$pass    = false;
			}

			if ($formData['fsalepriceerp'] == '') {
				$error[] = $this->registry->lang['controller']['errSalepriceerpRequired'];
				$pass    = false;
			}

			if ($formData['fendwarrantytime'] == '') {
				$error[] = $this->registry->lang['controller']['errEndwarrantytimeRequired'];
				$pass    = false;
			}

			if ($formData['fispromotionautoadd'] == '') {
				$error[] = $this->registry->lang['controller']['errIspromotionautoaddRequired'];
				$pass    = false;
			}

			if ($formData['fpromotionid'] == '') {
				$error[] = $this->registry->lang['controller']['errPromotionidRequired'];
				$pass    = false;
			}

			if ($formData['fpromotionlistgroupid'] == '') {
				$error[] = $this->registry->lang['controller']['errPromotionlistgroupidRequired'];
				$pass    = false;
			}

			if ($formData['fapplyproductid'] == '') {
				$error[] = $this->registry->lang['controller']['errApplyproductidRequired'];
				$pass    = false;
			}

			if ($formData['freplicationstoreid'] == '') {
				$error[] = $this->registry->lang['controller']['errReplicationstoreidRequired'];
				$pass    = false;
			}

			if ($formData['fadjustpricetypeid'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpricetypeidRequired'];
				$pass    = false;
			}

			if ($formData['fadjustprice'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpriceRequired'];
				$pass    = false;
			}

			if ($formData['fadjustpricecontent'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpricecontentRequired'];
				$pass    = false;
			}

			if ($formData['fdiscountcode'] == '') {
				$error[] = $this->registry->lang['controller']['errDiscountcodeRequired'];
				$pass    = false;
			}

			if ($formData['fadjustpriceuser'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpriceuserRequired'];
				$pass    = false;
			}

			if ($formData['fvatpercent'] == '') {
				$error[] = $this->registry->lang['controller']['errVatpercentRequired'];
				$pass    = false;
			}

			if ($formData['fretailprice'] == '') {
				$error[] = $this->registry->lang['controller']['errRetailpriceRequired'];
				$pass    = false;
			}

			if ($formData['finputvoucherdetailid'] == '') {
				$error[] = $this->registry->lang['controller']['errInputvoucherdetailidRequired'];
				$pass    = false;
			}

			if ($formData['fbuyinputvoucherid'] == '') {
				$error[] = $this->registry->lang['controller']['errBuyinputvoucheridRequired'];
				$pass    = false;
			}

			if ($formData['finputvoucherdate'] == '') {
				$error[] = $this->registry->lang['controller']['errInputvoucherdateRequired'];
				$pass    = false;
			}

			if ($formData['fisnew'] == '') {
				$error[] = $this->registry->lang['controller']['errIsnewRequired'];
				$pass    = false;
			}

			if ($formData['fisshowproduct'] == '') {
				$error[] = $this->registry->lang['controller']['errIsshowproductRequired'];
				$pass    = false;
			}

			if ($formData['fcostprice'] == '') {
				$error[] = $this->registry->lang['controller']['errCostpriceRequired'];
				$pass    = false;
			}

			if ($formData['fproductsaleskitid'] == '') {
				$error[] = $this->registry->lang['controller']['errProductsaleskitidRequired'];
				$pass    = false;
			}

			if ($formData['frefproductid'] == '') {
				$error[] = $this->registry->lang['controller']['errRefproductidRequired'];
				$pass    = false;
			}

			if ($formData['fproductcomboid'] == '') {
				$error[] = $this->registry->lang['controller']['errProductcomboidRequired'];
				$pass    = false;
			}

			return $pass;
		}

		//Kiem tra du lieu nhap trong form cap nhat
		private function editActionValidator($formData, &$error)
		{
			$pass = true;


			if ($formData['fsaleorderid'] == '') {
				$error[] = $this->registry->lang['controller']['errSaleorderidRequired'];
				$pass    = false;
			}

			if ($formData['fproductid'] == '') {
				$error[] = $this->registry->lang['controller']['errProductidRequired'];
				$pass    = false;
			}

			if ($formData['fquantity'] == '') {
				$error[] = $this->registry->lang['controller']['errQuantityRequired'];
				$pass    = false;
			}

			if ($formData['fsaleprice'] == '') {
				$error[] = $this->registry->lang['controller']['errSalepriceRequired'];
				$pass    = false;
			}

			if ($formData['foutputtypeid'] == '') {
				$error[] = $this->registry->lang['controller']['errOutputtypeidRequired'];
				$pass    = false;
			}

			if ($formData['fvat'] == '') {
				$error[] = $this->registry->lang['controller']['errVatRequired'];
				$pass    = false;
			}

			if ($formData['fsalepriceerp'] == '') {
				$error[] = $this->registry->lang['controller']['errSalepriceerpRequired'];
				$pass    = false;
			}

			if ($formData['fendwarrantytime'] == '') {
				$error[] = $this->registry->lang['controller']['errEndwarrantytimeRequired'];
				$pass    = false;
			}

			if ($formData['fispromotionautoadd'] == '') {
				$error[] = $this->registry->lang['controller']['errIspromotionautoaddRequired'];
				$pass    = false;
			}

			if ($formData['fpromotionid'] == '') {
				$error[] = $this->registry->lang['controller']['errPromotionidRequired'];
				$pass    = false;
			}

			if ($formData['fpromotionlistgroupid'] == '') {
				$error[] = $this->registry->lang['controller']['errPromotionlistgroupidRequired'];
				$pass    = false;
			}

			if ($formData['fapplyproductid'] == '') {
				$error[] = $this->registry->lang['controller']['errApplyproductidRequired'];
				$pass    = false;
			}

			if ($formData['freplicationstoreid'] == '') {
				$error[] = $this->registry->lang['controller']['errReplicationstoreidRequired'];
				$pass    = false;
			}

			if ($formData['fadjustpricetypeid'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpricetypeidRequired'];
				$pass    = false;
			}

			if ($formData['fadjustprice'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpriceRequired'];
				$pass    = false;
			}

			if ($formData['fadjustpricecontent'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpricecontentRequired'];
				$pass    = false;
			}

			if ($formData['fdiscountcode'] == '') {
				$error[] = $this->registry->lang['controller']['errDiscountcodeRequired'];
				$pass    = false;
			}

			if ($formData['fadjustpriceuser'] == '') {
				$error[] = $this->registry->lang['controller']['errAdjustpriceuserRequired'];
				$pass    = false;
			}

			if ($formData['fvatpercent'] == '') {
				$error[] = $this->registry->lang['controller']['errVatpercentRequired'];
				$pass    = false;
			}

			if ($formData['fretailprice'] == '') {
				$error[] = $this->registry->lang['controller']['errRetailpriceRequired'];
				$pass    = false;
			}

			if ($formData['finputvoucherdetailid'] == '') {
				$error[] = $this->registry->lang['controller']['errInputvoucherdetailidRequired'];
				$pass    = false;
			}

			if ($formData['fbuyinputvoucherid'] == '') {
				$error[] = $this->registry->lang['controller']['errBuyinputvoucheridRequired'];
				$pass    = false;
			}

			if ($formData['finputvoucherdate'] == '') {
				$error[] = $this->registry->lang['controller']['errInputvoucherdateRequired'];
				$pass    = false;
			}

			if ($formData['fisnew'] == '') {
				$error[] = $this->registry->lang['controller']['errIsnewRequired'];
				$pass    = false;
			}

			if ($formData['fisshowproduct'] == '') {
				$error[] = $this->registry->lang['controller']['errIsshowproductRequired'];
				$pass    = false;
			}

			if ($formData['fcostprice'] == '') {
				$error[] = $this->registry->lang['controller']['errCostpriceRequired'];
				$pass    = false;
			}

			if ($formData['fproductsaleskitid'] == '') {
				$error[] = $this->registry->lang['controller']['errProductsaleskitidRequired'];
				$pass    = false;
			}

			if ($formData['frefproductid'] == '') {
				$error[] = $this->registry->lang['controller']['errRefproductidRequired'];
				$pass    = false;
			}

			if ($formData['fproductcomboid'] == '') {
				$error[] = $this->registry->lang['controller']['errProductcomboidRequired'];
				$pass    = false;
			}

			return $pass;
		}
	}

