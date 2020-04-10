<?php

Class Controller_Cms_Shippingfee Extends Controller_Cms_Base
{
	private $recordPerPage = 100;

	public function indexAction()
	{
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token

        if($_POST['fbulkaction'] == 'delete')
        {
            $delArr = $_POST['fbulkid'];
            $deletedItems = array();
            $cannotDeletedItems = array();
            foreach($delArr as $id)
            {
                //check valid user and not admin user
                $mySPP = new Core_ShippingfeePrices($id);

                if($mySPP->id > 0)
                {
                    //tien hanh xoa
                    if($mySPP->delete())
                    {
                        $deletedItems[] = $mySPP->id;
                        $this->registry->me->writelog('shippingfeeprices_delete', $mySPP->id, array());
                    }
                    else
                        $cannotDeletedItems[] = $mySPP->id;
                }
                else
                    $cannotDeletedItems[] = $mySPP->id;
            }

            if(count($deletedItems) > 0)
                $success[] = 'Deleted '.implode(', ', $deletedItems).' success';

            if(count($cannotDeletedItems) > 0)
                $error[] = 'Deleted '.implode(', ', $cannotDeletedItems).' fail';
        }
        else
        {
            //bulk action not select, show error
            $warning[] = 'Do not have data to delete';
        }

        $listofshippingfee = Core_ShippingfeePrices::getShippingfeePricess(array(), 'id', 'ASC');

        $this->registry->smarty->assign(array(  'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'listofshippingfee'        => $listofshippingfee,
                                            ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function shippingprovinceAction()
    {
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token

        if($_POST['fbulkaction'] == 'delete')
        {
            $delArr = $_POST['fbulkid'];
            $deletedItems = array();
            $cannotDeletedItems = array();
            foreach($delArr as $id)
            {
                //check valid user and not admin user
                $mySPP = new Core_ShippingfeeDienmay($id);

                if($mySPP->id > 0)
                {
                    //tien hanh xoa
                    if($mySPP->delete())
                    {
                        $deletedItems[] = $mySPP->id;
                        $this->registry->me->writelog('shippingfeedienmay_delete', $mySPP->id, array());
                    }
                    else
                        $cannotDeletedItems[] = $mySPP->id;
                }
                else
                    $cannotDeletedItems[] = $mySPP->id;
            }

            if(count($deletedItems) > 0)
                $success[] = 'Deleted '.implode(', ', $deletedItems).' success';

            if(count($cannotDeletedItems) > 0)
                $error[] = 'Deleted '.implode(', ', $cannotDeletedItems).' fail';
        }
        else
        {
            //bulk action not select, show error
            $warning[] = 'Do not have data to delete';
        }

        $curPage           = (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
        $listofshippingfee = Core_ShippingfeeDienmay::getShippingfeeDienmays(array(), 'id', 'ASC', (($curPage - 1)*$this->recordPerPage).','.$this->recordPerPage);

        $total = Core_ShippingfeeDienmay::getShippingfeeDienmays(array(), 'id', 'ASC', 1, true);
        $totalPage = ceil($total/$this->recordPerPage);
        $allregions = Core_Region::getRegions(array(), '', '');
        $allregionsarray = array();
        if ($allregions) {
            foreach ($allregions as $region) {
                $allregionsarray[$region->id] = $region->name;
            }
        }

        $this->registry->smarty->assign(array(  'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'paginateurl'        => $paginateurl,
                                                'curPage'        => $curPage,
                                                'totalPage'        => $totalPage,
                                                'listshippingprovince'        => $listofshippingfee,
                                                'allregionsarray'        => $allregionsarray,
                                            ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function settinglabelAction()
    {
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token

        if($_POST['fbulkaction'] == 'delete')
        {
            $delArr = $_POST['fbulkid'];
            $deletedItems = array();
            $cannotDeletedItems = array();
            foreach($delArr as $id)
            {
                //check valid user and not admin user
                $mySPP = new Core_ShippingfeeNamefee($id);

                if($mySPP->id > 0)
                {
                    //tien hanh xoa
                    if($mySPP->delete())
                    {
                        $deletedItems[] = $mySPP->id;
                        $this->registry->me->writelog('shippingfeenamefee_delete', $mySPP->id, array());
                    }
                    else
                        $cannotDeletedItems[] = $mySPP->id;
                }
                else
                    $cannotDeletedItems[] = $mySPP->id;
            }

            if(count($deletedItems) > 0)
                $success[] = 'Deleted '.implode(', ', $deletedItems).' success';

            if(count($cannotDeletedItems) > 0)
                $error[] = 'Deleted '.implode(', ', $cannotDeletedItems).' fail';
        }
        else
        {
            //bulk action not select, show error
            $warning[] = 'Do not have data to delete';
        }

        $listofshippingfee = Core_ShippingfeeNamefee::getShippingfeeNamefees(array(), 'id', 'ASC');

        $this->registry->smarty->assign(array(  'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'listofshippingfeename' => $listofshippingfee,
                                            ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function settingfeeAction()
    {
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token

        if($_POST['fbulkaction'] == 'delete')
        {
            $delArr = $_POST['fbulkid'];
            $deletedItems = array();
            $cannotDeletedItems = array();
            foreach($delArr as $id)
            {
                //check valid user and not admin user
                $mySPP = new Core_ShippingfeeSettings($id);

                if($mySPP->id > 0)
                {
                    //tien hanh xoa
                    if($mySPP->delete())
                    {
                        $deletedItems[] = $mySPP->id;
                        $this->registry->me->writelog('shippingfeesettings_delete', $mySPP->id, array());
                    }
                    else
                        $cannotDeletedItems[] = $mySPP->id;
                }
                else
                    $cannotDeletedItems[] = $mySPP->id;
            }

            if(count($deletedItems) > 0)
                $success[] = 'Deleted '.implode(', ', $deletedItems).' success';

            if(count($cannotDeletedItems) > 0)
                $error[] = 'Deleted '.implode(', ', $cannotDeletedItems).' fail';
        }
        else
        {
            //bulk action not select, show error
            $warning[] = 'Do not have data to delete';
        }

        $listofshippingfee = Core_ShippingfeeSettings::getShippingfeeSettingss(array(), 'id', 'ASC');

        $this->registry->smarty->assign(array(  'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'listofshippingsettingsfee' => $listofshippingfee,
                                            ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function vxvsttcAction()
    {
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token

        if($_POST['fbulkaction'] == 'delete')
        {
            $delArr = $_POST['fbulkid'];
            $deletedItems = array();
            $cannotDeletedItems = array();
            foreach($delArr as $id)
            {
                //check valid user and not admin user
                $mySPP = new Core_ShippingfeeVxvsTtc($id);

                if($mySPP->id > 0)
                {
                    //tien hanh xoa
                    if($mySPP->delete())
                    {
                        $deletedItems[] = $mySPP->id;
                        $this->registry->me->writelog('shippingfeevxvsttc_delete', $mySPP->id, array());
                    }
                    else
                        $cannotDeletedItems[] = $mySPP->id;
                }
                else
                    $cannotDeletedItems[] = $mySPP->id;
            }

            if(count($deletedItems) > 0)
                $success[] = 'Deleted '.implode(', ', $deletedItems).' success';

            if(count($cannotDeletedItems) > 0)
                $error[] = 'Deleted '.implode(', ', $cannotDeletedItems).' fail';
        }
        else
        {
            //bulk action not select, show error
            $warning[] = 'Do not have data to delete';
        }

        $curPage           = (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
        $listofshippingfee = Core_ShippingfeeVxvsTtc::getShippingfeeVxvsTtcs(array(), 'id', 'ASC', (($curPage - 1)*$this->recordPerPage).','.$this->recordPerPage);

        $total = Core_ShippingfeeVxvsTtc::getShippingfeeVxvsTtcs(array(), 'id', 'ASC', 1, true);
        $totalPage = ceil($total/$this->recordPerPage);
        $allregions = Core_Region::getRegions(array(), '', '');
        $allregionsarray = array();
        if ($allregions) {
            foreach ($allregions as $region) {
                $allregionsarray[$region->id] = $region->name;
            }
        }

        $this->registry->smarty->assign(array(  'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'paginateurl'        => $paginateurl,
                                                'curPage'        => $curPage,
                                                'totalPage'        => $totalPage,
                                                'listfeevxvsttc'        => $listofshippingfee,
                                                'allregionsarray'        => $allregionsarray,
                                            ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function uploadAction()
    {
        global $db;
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array();

        if (isset($_POST['fsubmit'])) {
            $formData = $_POST;
            if ($this->checkuploadvalidation($_POST, $_FILES['fuploadfile'], $error)) {
                $savefileurl = SITE_PATH.'uploads/shippingfeeupload.xlsx';
                if (move_uploaded_file($_FILES["fuploadfile"]["tmp_name"], $savefileurl)) {
                    if (file_exists($savefileurl)) {
                        include_once SITE_PATH.'libs/phpexcel/PHPExcel.php';
                        include_once SITE_PATH.'libs/phpexcel/PHPExcel/IOFactory.php';
                        $objReader = new PHPExcel_Reader_Excel2007();
                        $objReader->setReadDataOnly(true);
                        $objPHPExcel = $objReader->load($savefileurl);
                        $objWorksheet = $objPHPExcel->getActiveSheet();
                        if ($objWorksheet) {
                            //delete all old data in table
                            $db->query('truncate '.$_POST['ftabletoupload']);
                            $countrows = 1;

                            switch($_POST['ftabletoupload'])
                            {
                                case 'lit_shippingfee_prices':
                                    foreach ($objWorksheet->getRowIterator() as $row) {
                                        if ($countrows == 1) {
                                            $countrows++;
                                            continue;
                                        }
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false);
                                        $newshippingprices = new Core_ShippingfeePrices();
                                        $datacells = array();
                                        foreach ($cellIterator as $cell) {
                                            $datacells[] = trim($cell->getValue());
                                        }
                                        if (count($datacells) >= 10) {
                                            $newshippingprices->area = $datacells[0];
                                            $newshippingprices->distancemin = $datacells[1];
                                            $newshippingprices->distancemax = $datacells[2];
                                            $newshippingprices->weightmin = $datacells[3];
                                            $newshippingprices->weightmax = $datacells[4];
                                            $newshippingprices->price = $datacells[5];
                                            $newshippingprices->priceplus = $datacells[6];
                                            $newshippingprices->timemin = $datacells[7];
                                            $newshippingprices->timemax = $datacells[8];
                                            $newshippingprices->typefee = (strtolower($datacells[9])== 'ttc' ? Core_ShippingfeePrices::TYPE_TTC : Core_ShippingfeePrices::TYPE_SBP);
                                            $newshippingprices->addData();
                                        }
                                        unset($newshippingprices);
                                        $countrows++;
                                    }
                                    header('Location:'.$this->registry->conf['rooturl'].$this->registry->controllerGroup.'/'.$this->registry->controller);
                                    break;
                                case 'lit_shippingfee_dienmay':
                                    //get all regions
                                    $allregions = Core_Region::getRegions(array(), '', '');
                                    $allregionsarray = array();
                                    if ($allregions) {
                                        foreach ($allregions as $region) {
                                            $allregionsarray[$region->slug] = $region->id;
                                        }
                                    }
                                    foreach ($objWorksheet->getRowIterator() as $row) {
                                        if ($countrows == 1) {
                                            $countrows++;
                                            continue;
                                        }
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false);
                                        $newshippingfeedm = new Core_ShippingfeeDienmay();
                                        $datacells = array();
                                        foreach ($cellIterator as $cell) {
                                            $datacells[] = trim($cell->getValue());
                                        }
                                        if (count($datacells) >= 6) {
                                            $newshippingfeedm->provincestart = $allregionsarray[Helper::codau2khongdau($datacells[0], true, true)];
                                            $newshippingfeedm->districtstart = $allregionsarray[Helper::codau2khongdau($datacells[1], true, true)];
                                            $newshippingfeedm->provinceend = $allregionsarray[Helper::codau2khongdau($datacells[2], true, true)];
                                            $newshippingfeedm->districtend = $allregionsarray[Helper::codau2khongdau($datacells[3], true, true)];
                                            $newshippingfeedm->ttc = $datacells[4];
                                            $newshippingfeedm->sbp = $datacells[5];
                                            $newshippingfeedm->addData();
                                        }
                                        unset($newshippingfeedm);
                                        $countrows++;
                                    }
                                    header('Location:'.$this->registry->conf['rooturl'].$this->registry->controllerGroup.'/'.$this->registry->controller.'/shippingprovince');
                                    break;
                                case 'lit_shippingfee_namefee'://label
                                    foreach ($objWorksheet->getRowIterator() as $row) {
                                        if ($countrows == 1) {
                                            $countrows++;
                                            continue;
                                        }
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false);
                                        $newshippingnamefee = new Core_ShippingfeeNamefee();
                                        $datacells = array();
                                        foreach ($cellIterator as $cell) {
                                            $datacells[] = trim($cell->getValue());
                                        }

                                        if (count($datacells) >= 7) {
                                            $newshippingnamefee->name = $datacells[0];
                                            $newshippingnamefee->pricemin = $datacells[1];
                                            $newshippingnamefee->pricemax = $datacells[2];
                                            $newshippingnamefee->weightmin = $datacells[3];
                                            $newshippingnamefee->weightmax = $datacells[4];
                                            $newshippingnamefee->discount = $datacells[5];
                                            $newshippingnamefee->ispercent = $datacells[6];
                                            $newshippingnamefee->addData();
                                        }

                                        unset($newshippingnamefee);
                                        $countrows++;
                                    }
                                    header('Location:'.$this->registry->conf['rooturl'].$this->registry->controllerGroup.'/'.$this->registry->controller.'/settinglabel');
                                    break;
                                case 'lit_shippingfee_settings':
                                    foreach ($objWorksheet->getRowIterator() as $row) {
                                        if ($countrows == 1) {
                                            $countrows++;
                                            continue;
                                        }
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false);
                                        $newshippingfeesettings = new Core_ShippingfeeSettings();
                                        $datacells = array();
                                        foreach ($cellIterator as $cell) {
                                            $datacells[] = trim($cell->getValue());
                                        }
                                        if (count($datacells) >= 4) {
                                            $newshippingfeesettings->name = $datacells[0];
                                            $newshippingfeesettings->price = $datacells[1];
                                            $newshippingfeesettings->ispercent = $datacells[2];
                                            $newshippingfeesettings->typefee = (strtolower($datacells[3])== 'ttc' ? Core_ShippingfeeSettings::TYPEFEE_TTC : Core_ShippingfeeSettings::TYPEFEE_SBP);
                                            $newshippingfeesettings->order = $datacells[4];

                                            $newshippingfeesettings->addData();
                                        }
                                        unset($newshippingfeesettings);
                                        $countrows++;
                                    }
                                    header('Location:'.$this->registry->conf['rooturl'].$this->registry->controllerGroup.'/'.$this->registry->controller.'/settingfee');
                                    break;
                                case 'lit_shippingfee_vxvs_ttc':
                                    //get all regions
                                    $allregions = Core_Region::getRegions(array(), '', '');
                                    $allregionsarray = array();
                                    if ($allregions) {
                                        foreach ($allregions as $region) {
                                            $allregionsarray[$region->slug] = $region->id;
                                        }
                                    }
                                    foreach ($objWorksheet->getRowIterator() as $row) {
                                        if ($countrows == 1) {
                                            $countrows++;
                                            continue;
                                        }
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false);
                                        $newshippingfeevxvsttc = new Core_ShippingfeeVxvsTtc();
                                        $datacells = array();
                                        foreach ($cellIterator as $cell) {
                                            $datacells[] = trim($cell->getValue());
                                        }
                                        if (count($datacells) == 4) {
                                            $newshippingfeevxvsttc->rid = $allregionsarray[Helper::codau2khongdau($datacells[0], true, true)];
                                            $newshippingfeevxvsttc->districtid = $allregionsarray[Helper::codau2khongdau($datacells[1], true, true)];
                                            $newshippingfeevxvsttc->less30kg = $datacells[2];
                                            $newshippingfeevxvsttc->from30kg = $datacells[3];

                                            $newshippingfeevxvsttc->addData();
                                        }
                                        unset($newshippingfeevxvsttc);
                                        $countrows++;
                                    }
                                    header('Location:'.$this->registry->conf['rooturl'].$this->registry->controllerGroup.'/'.$this->registry->controller.'/vxvsttc');
                                    break;
                            }
                        }
                    }
                }
            }
        }

        $this->registry->smarty->assign(array(  'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'formData'        => $formData,
                                                'listofshippingfee'        => $listofshippingfee,
                                            ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'upload.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    private function checkuploadvalidation($formData, $files, &$error)
    {
        if (empty($formData['ftabletoupload'])) {
            $error[] = 'Please select type to upload';
            return false;
        } elseif (empty($files['name'])) {
            $error[] = 'Please select file to upload';
            return false;
        } elseif (substr($files['name'], -5) != '.xlsx') {
            $error[] = 'Please select excel file to upload';
            return false;
        }
        return true;
    }

}
