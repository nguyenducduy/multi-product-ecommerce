<?php

Class Controller_Cms_ProductAward Extends Controller_Stat_Base
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


		$pbarcodeFilter = (string)($this->registry->router->getArg('pbarcode'));
		$poidFilter = (int)($this->registry->router->getArg('poid'));
		$ppaidFilter = (int)($this->registry->router->getArg('ppaid'));
		$idFilter = (int)($this->registry->router->getArg('id'));


		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['productawardBulkToken']==$_POST['ftoken'])
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
                            $myProductAward = new Core_ProductAward($id);

                            if($myProductAward->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductAward->delete())
                                {
                                    $deletedItems[] = $myProductAward->id;
                                    $this->registry->me->writelog('productaward_delete', $myProductAward->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myProductAward->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductAward->id;
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

		$_SESSION['productawardBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($pbarcodeFilter != "")
		{
			$paginateUrl .= 'pbarcode/'.$pbarcodeFilter . '/';
			$formData['fpbarcode'] = $pbarcodeFilter;
			$formData['search'] = 'pbarcode';
		}

		if($poidFilter > 0)
		{
			$paginateUrl .= 'poid/'.$poidFilter . '/';
			$formData['fpoid'] = $poidFilter;
			$formData['search'] = 'poid';
		}

		if($ppaidFilter > 0)
		{
			$paginateUrl .= 'ppaid/'.$ppaidFilter . '/';
			$formData['fppaid'] = $ppaidFilter;
			$formData['search'] = 'ppaid';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}


		//tim tong so
		$total = Core_ProductAward::getProductAwards($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$productawards = Core_ProductAward::getProductAwards($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'productawards' 	=> $productawards,
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
            if($_SESSION['productawardAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myProductAward = new Core_ProductAward();


					$myProductAward->pbarcode = $formData['fpbarcode'];
					$myProductAward->poid = $formData['fpoid'];
					$myProductAward->ppaid = $formData['fppaid'];
					$myProductAward->totalawardforstaff = $formData['ftotalawardforstaff'];
					$myProductAward->updatedatedoferp = $formData['fupdatedatedoferp'];

                    if($myProductAward->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productaward_add', $myProductAward->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['productawardAddToken']=Helper::getSecurityToken();//Tao token moi

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
		$myProductAward = new Core_ProductAward($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductAward->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fpbarcode'] = $myProductAward->pbarcode;
			$formData['fpoid'] = $myProductAward->poid;
			$formData['fppaid'] = $myProductAward->ppaid;
			$formData['fid'] = $myProductAward->id;
			$formData['ftotalawardforstaff'] = $myProductAward->totalawardforstaff;
			$formData['fdatecreated'] = $myProductAward->datecreated;
			$formData['fupdatedatedoferp'] = $myProductAward->updatedatedoferp;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productawardEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myProductAward->pbarcode = $formData['fpbarcode'];
						$myProductAward->poid = $formData['fpoid'];
						$myProductAward->ppaid = $formData['fppaid'];
						$myProductAward->totalawardforstaff = $formData['ftotalawardforstaff'];
						$myProductAward->updatedatedoferp = $formData['fupdatedatedoferp'];

                        if($myProductAward->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productaward_edit', $myProductAward->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['productawardEditToken'] = Helper::getSecurityToken();//Tao token moi

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
		$myProductAward = new Core_ProductAward($id);
		if($myProductAward->id > 0)
		{
			//tien hanh xoa
			if($myProductAward->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductAward->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('productaward_delete', $myProductAward->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductAward->id, $this->registry->lang['controller']['errDelete']);
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

	/**
	 * Import productaward from ERP
	 * @return [type] [description]
	 */
	public function importproductawardAction()
	{
		set_time_limit(0);
		$recordPerPage = 100;
		$counter = 0;
		$oracle = new Oracle();

		//count total records
		$total = 0;
		$sql = 'SELECT COUNT(*) AS total FROM ERP.VW_PRODUCTREWARD_DM';
		$count = $oracle->query($sql);
		$total = $count[0]['TOTAL'];

		$totalPage = ceil($total / $recordPerPage);

		for($i = 1 ; $i < $totalPage ; $i++)
		{
			$start = ($i * $recordPerPage) - $recordPerPage;
			$end = ($i * $recordPerPage);

			$sql = 'SELECT * FROM (SELECT pw.* , ROWNUM r FROM ERP.VW_PRODUCTREWARD_DM pw) WHERE r > ' . $start . ' AND r <= ' . $end;
			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$myproductaward = new Core_ProductAward();
				$myproductaward->pbarcode = $result['PRODUCTID'];
				$myproductaward->poid = $result['OUTPUTTYPEID'];
				$myproductaward->ppaid = $result['PRICEAREAID'];
				$myproductaward->totalawardforstaff = $result['TOTALREWARDFORSTAFF'];
				$myproductaward->updatedatedoferp = $this->formatTime($result['UPDATEDDATE']);

				if($myproductaward->addData() > 0)
				{
					$counter++;
				}
				unset($result);
			}
			unset($results);
		}

		echo 'So luong record thuc thi : ' . $counter;
	}

	private function formatTime($str, $time = 'H:i:s')
    {
        $date =  0;
        $str = trim($str);
        if(!empty($str) && $str != '0' &&  $str != 0)
        {
            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $str);
            if(!empty($time))
            {
                $date =  strtotime($dateUpdated->format('Y-m-d '.$time));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'),$dateUpdated->format($time));
            }
            else {
                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
            }
        }
        return $date;
    }

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;



		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		return $pass;
	}
}

?>