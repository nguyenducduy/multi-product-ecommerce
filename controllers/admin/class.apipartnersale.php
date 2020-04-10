<?php

Class Controller_Admin_ApiPartnerSale Extends Controller_Cms_Base
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


		$apidFilter = (int)($this->registry->router->getArg('apid'));
		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$pidFilter = (int)($this->registry->router->getArg('pid'));
		$pbarcodeFilter = (string)($this->registry->router->getArg('pbarcode'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));

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
            if($_SESSION['apipartnersaleBulkToken']==$_POST['ftoken'])
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
                            $myApiPartnerSale = new Core_Backend_ApiPartnerSale($id);

                            if($myApiPartnerSale->id > 0)
                            {
                                //tien hanh xoa
                                if($myApiPartnerSale->delete())
                                {
                                    $deletedItems[] = $myApiPartnerSale->id;
                                    $this->registry->me->writelog('apipartnersale_delete', $myApiPartnerSale->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myApiPartnerSale->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApiPartnerSale->id;
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

		$_SESSION['apipartnersaleBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($apidFilter > 0)
		{
			$paginateUrl .= 'apid/'.$apidFilter . '/';
			$formData['fapid'] = $apidFilter;
			$formData['search'] = 'apid';
		}

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($pbarcodeFilter != "")
		{
			$paginateUrl .= 'pbarcode/'.$pbarcodeFilter . '/';
			$formData['fpbarcode'] = $pbarcodeFilter;
			$formData['search'] = 'pbarcode';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
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

			if($searchKeywordIn == 'pbarcode')
			{
				$paginateUrl .= 'searchin/pbarcode/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Backend_ApiPartnerSale::getApiPartnerSales($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$apipartnersales = Core_Backend_ApiPartnerSale::getApiPartnerSales($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		if(count($apipartnersales) > 0)
		{
			foreach($apipartnersales as $apipartnersale)
			{
				$apipartnersale->apipartneractor = new Core_Backend_ApiPartner($apipartnersale->apid);
			}
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


		$this->registry->smarty->assign(array(	'apipartnersales' 	=> $apipartnersales,
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
												'statusList'    => Core_Backend_ApiPartnerSale::getStatusList(),
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
            if($_SESSION['apipartnersaleAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myApiPartnerSale = new Core_Backend_ApiPartnerSale();


					$myApiPartnerSale->apid = $formData['fapid'];
					$myApiPartnerSale->uid = $this->registry->me->id;
					//$myApiPartnerSale->pid = $formData['fpid'];
					$myApiPartnerSale->pbarcode = $formData['fpbarcode'];
					$myProduct = Core_Product::getProductIDByBarcode($formData['fpbarcode']);
					$myApiPartnerSale->pid = $myProduct['p_id'];
					$myApiPartnerSale->discountvalue = $formData['fdiscountvalue'];
					$myApiPartnerSale->status = $formData['fstatus'];

                    if($myApiPartnerSale->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('apipartnersale_add', $myApiPartnerSale->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

        //get api partner list enable
        $apipartnerList = Core_Backend_ApiPartner::getApiPartners(array() , 'id' , 'ASC');


		$_SESSION['apipartnersaleAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'apipartnerList' => $apipartnerList,
                                                'statusList' => Core_Backend_ApiPartnerSale::getStatusList(),
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
		$myApiPartnerSale = new Core_Backend_ApiPartnerSale($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myApiPartnerSale->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fapid'] = $myApiPartnerSale->apid;
			$formData['fuid'] = $myApiPartnerSale->uid;
			$formData['fpid'] = $myApiPartnerSale->pid;
			$formData['fpbarcode'] = $myApiPartnerSale->pbarcode;
			$formData['fid'] = $myApiPartnerSale->id;
			$formData['fdiscountvalue'] = $myApiPartnerSale->discountvalue;
			$formData['fstatus'] = $myApiPartnerSale->status;
			$formData['fdatecreated'] = $myApiPartnerSale->datecreated;
			$formData['fdatemodified'] = $myApiPartnerSale->datemodified;
			$formData['fdateimport'] = $myApiPartnerSale->dateimport;
			 $myApiPartnerSale->apipartneractor = new Core_Backend_ApiPartner($myApiPartnerSale->apid);
			 $formData['fapipartnername'] = $myApiPartnerSale->apipartneractor->name;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apipartnersaleEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {
						$myApiPartnerSale->uid = $this->registry->me->id;

						$myApiPartnerSale->discountvalue = $formData['fdiscountvalue'];
						$myApiPartnerSale->status = $formData['fstatus'];

                        if($myApiPartnerSale->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apipartnersale_edit', $myApiPartnerSale->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['apipartnersaleEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList' => Core_Backend_ApiPartnerSale::getStatusList(),
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
		$myApiPartnerSale = new Core_Backend_ApiPartnerSale($id);
		if($myApiPartnerSale->id > 0)
		{
			//tien hanh xoa
			if($myApiPartnerSale->delete())
			{
				$redirectMsg = str_replace('###id###', $myApiPartnerSale->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('apipartnersale_delete', $myApiPartnerSale->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApiPartnerSale->id, $this->registry->lang['controller']['errDelete']);
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



		if($formData['fapid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errApidMustGreaterThanZero'];
			$pass = false;
		}

//		if($formData['fpid'] <= 0)
//		{
//			$error[] = $this->registry->lang['controller']['errPidMustGreaterThanZero'];
//			$pass = false;
//		}

		if($formData['fpbarcode'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPbarcodeRequired'];
			$pass = false;
		}

		if($formData['fstatus'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errStatusMustGreaterThanZero'];
			$pass = false;
		}

        //check barcode is exist
        if(strlen(trim($formData['fpbarcode']))  > 0)
        {
            $isExist = Core_Backend_ApiPartnerSale::checkbarcodeisExist($formData['fpbarcode']);

            if($isExist)
            {
                $error[] = $this->registry->lang['controller']['errBarcodeIsExist'];
                $pass = false;
            }
            else
            {
                //check barcode is valid
                $myProduct = Core_Product::getProductIDByBarcode($formData['fpbarcode']);

                if($myProduct['p_id'] == 0)
                {
                    $error[] = $this->registry->lang['controller']['errBarcodeNotValid'];
                    $pass = false;
                }
            }
        }

        //check discount value is number
        if(preg_match('/[0-9]+/' , $formData['fdiscountvalue'] , $out) == 0)
        {
            $error[] = $this->registry->lang['controller']['errDiscountValueDataType'];
            $pass = false;
        }


		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



//		if($formData['fapid'] <= 0)
//		{
//			$error[] = $this->registry->lang['controller']['errApidMustGreaterThanZero'];
//			$pass = false;
//		}

//		if($formData['fpid'] <= 0)
//		{
//			$error[] = $this->registry->lang['controller']['errPidMustGreaterThanZero'];
//			$pass = false;
//		}

		/*if($formData['fpbarcode'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPbarcodeRequired'];
			$pass = false;
		}

		if($formData['fstatus'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errStatusMustGreaterThanZero'];
			$pass = false;
		}*/

		//check barcode is exist
        /*if(strlen(trim($formData['fpbarcode']))  > 0)
        {
            $isExist = Core_Backend_ApiPartnerSale::checkbarcodeisExist($formData['fpbarcode']);

            if($isExist)
            {
                $error[] = $this->registry->lang['controller']['errBarcodeIsExist'];
                $pass = false;
            }
            else
            {
                //check barcode is valid
                $myProduct = Core_Product::getProductIDByBarcode($formData['fpbarcode']);

                if($myProduct['p_id'] == 0)
                {
                    $error[] = $this->registry->lang['controller']['errBarcodeNotValid'];
                    $pass = false;
                }
            }
        }*/

		//check discount value is number
        if(preg_match('/[0-9]+/' , $formData['fdiscountvalue'] , $out) == 0)
        {
            $error[] = $this->registry->lang['controller']['errDiscountValueDataType'];
            $pass = false;
        }

		return $pass;
	}

	public function exportpartnersaleinfoAction()
	{
        set_time_limit(0);
        $data = '';
        $recordPerPage = 100;

        $data .= 'Barcode#Tên sản phẩm#Danh mục#Tồn kho#Giá niêm yết#Giá cuối#Giá vốn TB#Giá mua vào#Lãi tạm tính#Discount' . "\n";

        $page = 1;
        while(1)
        {
            $productList = Core_Product::getProducts(array('favalible' => 1 ,
                                                        'fisonsitestatus' => 1,
                                                        'fhasbarcode' => 1,
                                                    ) , 'id' , 'ASC' , ($page-1)*$recordPerPage .',' . $recordPerPage);
            if(count($productList) == 0)
            {
                break;
            }
            else
            {
                foreach($productList as $product)
                {
                    $data .= $product->barcode . '#';
                    $data .= $product->name .'#';

                    $myProductcategory = new Core_Productcategory($product->pcid , true);

                    $data .= $myProductcategory->name .'#';

                    $instock = 0;

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


                    $instock = Core_ProductStock::getProductIntockByStore($storeidList , $product->barcode);

                    $data .= $instock . '#';

                    $data .= $product->sellprice . '#';
                    $data .= $product->finalprice . '#';

                    ////TINH GIA VON TRUNG BINH
                    $giavontrungbinh = 0;

					$ip = '172.16.141.39';
					$serect = md5('dienmay.com/stat/report' . $product->id);
					$url = 'http://' . $ip . '/cron/productcache/apiGetProductDetailData?username=dmadm&password=03avdea43&pid=' . $product->id . '&serect=' . $serect;

					$datastring = file_get_contents($url);

					if(!empty($datastring))
					{
						$datainfo = json_decode($datastring , true);
						$giavontrungbinh = $datainfo['giavontrungbinh'];
					}

                    $data .= $giavontrungbinh . '#';

                    /////TINH GIA MUA VAO GAN NHAT CUA SAN PHAM
                    $giamuavao = 0;
                    $inputpriceinfo = Core_Backend_Inputvoucher::getlastinputprice(trim($product->barcode));
                    $giamuavao = $inputpriceinfo['inputprice'] - $inputpriceinfo['discount'];

                    $data .= $giamuavao . '#';

                    ///TINH LAI TAM TINH
                    $laitamtinh = 0;
                    $laitamtinh = ($giavontrungbinh > $giamuavao) ? ($product->finalprice - $giavontrungbinh) : ($product->finalprice - $giamuavao);

                    $data .= $laitamtinh . '#';
                    $data .= 0;

                    $data .= "\n";
                }
            }

            unset($productList);
            $page++;
        }

        $myHttpDownload = new HttpDownload();
        $myHttpDownload->set_bydata($data); //Download from php data
        $myHttpDownload->use_resume = true; //Enable Resume Mode
        $myHttpDownload->filename = 'apipartdatasale-'.date('Y-m-d-H-i-s') . '.csv';
        $myHttpDownload->download(); //Download File

	}

	public function importpartnersaleinfoAction()
	{
		set_time_limit(0);

		$formData = array();
		$success = array();
		$error = array();
		$warning = array();

		if(isset($_POST['fsubmit']))
		{
			if($this->importpartnersaleinfoActionValidator($formData, $error))
			{
				$formData = array_merge($formData , $_POST);
				$tmpName = $_FILES['ffile']['tmp_name'];
				//////READ CONTENT CSV FILE
				if (($handle = fopen($tmpName, "r")) !== FALSE)
				{
					$i = 0;
					$ok = false;
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
					{
						if( $i > 0 )
						{
							///////CHECK BARCODE HAVE EXIST FOR PARTNER
							if(Core_Backend_ApiPartnerSale::checkbarcodeisExist($data[0], $formData['fapid']))
							{
								$ok = Core_Backend_ApiPartnerSale::updateDiscountValue(array(
																					'discountvalue' => $data[1],
																					'apid' => $formData['fapid'],
																					'pbarcode' => $data[0]
																				));

							}
							else
							{

								$myApiPartnerSale = new Core_Backend_ApiPartnerSale();


								$myApiPartnerSale->apid = $formData['fapid'];
								$myApiPartnerSale->uid = $this->registry->me->id;
								//$myApiPartnerSale->pid = $formData['fpid'];
								$myApiPartnerSale->pbarcode = $data[0];
								$myProduct = Core_Product::getProductIDByBarcode(trim($data[0]));
								$myApiPartnerSale->pid = $myProduct['p_id'];
								$myApiPartnerSale->discountvalue = $data[1];
								$myApiPartnerSale->status = Core_Backend_ApiPartnerSale::STATUS_ENABLE;
								$myApiPartnerSale->dateimport = time();

								if($myApiPartnerSale->addData())
								{
									$this->registry->me->writelog('apipartnersale_add', $myApiPartnerSale->id, array());
								}
							}
						}
						$i++;
					}

					if($ok)
						$success[] = 'Import discount value thành công';
					else
						$error[] = 'Có lỗi xảy ra trong quá trình import discount value';

					fclose($handle);
				}
				////END OF READ CONTENT FILE
			}
		}

		$this->registry->smarty->assign(array( 'formData' => $formData,
												'error'   => $error,
												'success' => $success,
												'warning' => $warning,
												'redirectUrl'    => $this->getRedirectUrl(),
												'apipartnerList' => Core_Backend_ApiPartner::getApiPartners(array() , 'id' , 'ASC'),
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'importpartnersale.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProduct->name,
												'contents'             => $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	private function importpartnersaleinfoActionValidator($formData , &$error)
	{
		$pass = true;

		//check file is valid
		if( strlen($_FILES['ffile']['name']) > 0 )
		{
			//kiem tra dinh dang cua file
			if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name']))), $this->registry->setting['product']['fileimportValidType']))
			{
				$error[] = 'File upload không hợp lệ . Xin vui lòng thử lại';
				$pass = false;
			}

			//kiem tra kich thuoc cua file
			if($_FILES['ffile']['size'] > $this->registry->setting['product']['fileimportFileSize'])
			{
				$error[] = 'Kích thước file lớn hơn quy định . Xin vui lòng thử lại';
				$pass = false;
			}
		}
		else
		{
			$error[] = 'Vui lòng chọn file để upload';
			$pass = false;
		}

		return $pass;
	}
}

?>
