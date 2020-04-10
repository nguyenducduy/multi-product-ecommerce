<?php
Class Controller_Cms_Brandcategory extends Controller_Cms_Base
{
    public $recordPerPage = 20;
    public function indexAction()
    {
        $error 			= array();
        $success 		= array();
        $warning 		= array();
        $formData 		= array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token
        $page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

        //fillter
        $vidFilter = (string)($this->registry->router->getArg('vid'));
        $pcidFilter = (string)($this->registry->router->getArg('pcid'));
        $idFilter = (int)($this->registry->router->getArg('id'));
        $statusFilter = (int)($this->registry->router->getArg('status'));
        $nameFilter = (string)($this->registry->router->getArg('name'));
        $sortby 	= $this->registry->router->getArg('sortby');
        if($sortby == '') $sortby = 'id';
        $formData['sortby'] = $sortby;
        $sorttype 	= $this->registry->router->getArg('sorttype');
        if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
        $formData['sorttype'] = $sorttype;

        //Xu ly mutiaction
        if(!empty($_POST['fsubmitbulk']))
        {
            if($_SESSION['brandCategoryBulkToken']==$_POST['ftoken'])
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
                            $myBrandCategory = new Core_BrandCategory($id);

                            if($myBrandCategory->id > 0)
                            {
                                //tien hanh xoa
                                if($myBrandCategory->delete())
                                {
                                    $deletedItems[] = $myBrandCategory->id;
                                    $this->registry->me->writelog('BrandCategory_delete', $myBrandCategory->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myBrandCategory->id;
                            }
                            else
                                $cannotDeletedItems[] = $myBrandCategory->id;
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
        //Ket thuc xy ly mutiaction

        $_SESSION['brandCategoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';


        if($nameFilter != "")
        {
            $paginateUrl .= 'name/'.$nameFilter . '/';
            $formData['fname'] = $nameFilter;
            $formData['search'] = 'name';
        }

        if($vidFilter > 0)
        {
            $paginateUrl .= 'vid/'.$vidFilter . '/';
            $formData['fvid'] = $vidFilter;
            $formData['search'] = 'vid';
        }

        if($pcidFilter > 0)
        {
            $paginateUrl .= 'pcid/'.$pcidFilter . '/';
            $formData['fpcid'] = $pcidFilter;
            $formData['search'] = 'pcid';
        }

        if($statusFilter > 0)
        {
            $paginateUrl .= 'type/'.$statusFilter . '/';
            $formData['fstatus'] = $statusFilter;
            $formData['search'] = 'status';
        }

        if($idFilter > 0)
        {
            $paginateUrl .= 'id/'.$idFilter . '/';
            $formData['fid'] = $idFilter;
            $formData['search'] = 'id';
        }
        $total = Core_BrandCategory::getBrandCategorys($formData, $sortby, $sorttype, 0, true);
        $totalPage = ceil($total/$this->recordPerPage);
        $curPage = $page;

        $brandCategory = Core_BrandCategory::getBrandCategorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


        //filter for sortby & sorttype
        $filterUrl = $paginateUrl;

        //append sort to paginate url
        $paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

        //build redirect string
        $redirectUrl = $paginateUrl;
        if($curPage > 1)
            $redirectUrl .= 'page/' . $curPage;


        $redirectUrl = base64_encode($redirectUrl);

        // $vendorList = Core_Vendor::getVendors(array('fid'=>))

        $this->registry->smarty->assign(array(
            'brandCategory' 	=> $brandCategory,
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
            'statusList'	=> Core_BrandCategory::getStatusList()
        ));

        $contents  = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
        $this->registry->smarty->assign(array(
                'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
                'contents' 			=> $contents)
        );
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

    }
    public function addAction()
    {
        $error 	= array();
        $success 	= array();
        $contents 	= '';
        $formData 	= array();
        if(!empty($_POST['fsubmit']))
        {
            //Add formData

            if($_SESSION['brandCategoryAddToken'] == $_POST['ftoken'])
            {

                $formData = array_merge($formData, $_POST);
                if($this->addActionValidator($formData,$error))
                {
                    $brandCategory = new Core_BrandCategory();

                    $brandCategory->pcid        = $formData['fpcid'];
                    $brandCategory->vid         = $formData['fvid'];
                    $brandCategory->name        = $formData['fname'];
                    $brandCategory->seotitle    = $formData['fseotitle'];
                    $brandCategory->seokeyword  = $formData['fseokeyword'];
                    $brandCategory->seodescription = $formData['fseodescription'];
                    $brandCategory->titlecol1   = $formData['ftitlecol1'];
                    $brandCategory->desccol1    = $formData['fdesccol1'];
                    $brandCategory->titlecol2   = $formData['ftitlecol2'];
                    $brandCategory->desccol2    = $formData['fdesccol2'];
                    $brandCategory->titlecol3   = $formData['ftitlecol3'];
                    $brandCategory->desccol3    = $formData['fdesccol3'];
                    $brandCategory->topseokeyword = $formData['ftopseokeyword'];
                    $brandCategory->footerkey   = $formData['ffooterkey'];
                    $brandCategory->status      = $formData['fstatus'];
                    $brandCategory->datecreated = time();
                    if($brandCategory->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('brandcategory_add', $brandCategory->id, array());
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }
        }
        //Category ==============================
        $categoryParent = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
        $category = array();
        for($i = 0 ;$i <count($categoryParent);$i++)
        {
            $category[] = $categoryParent[$i];
            $subCategory = Core_Productcategory::getProductcategorys(array('fparentid' =>$categoryParent[$i]->id), 'displayorder', 'ASC');
            for($j = 0 ;$j <count($subCategory);$j++)
            {
                $subCategory[$j]->name = '&nbsp;&nbsp;&nbsp;'.$subCategory[$j]->name;
                $category[] = $subCategory[$j];
                $subsubCategory = Core_Productcategory::getProductcategorys(array('fparentid' => $subCategory[$j]->id), 'displayorder', 'ASC');
                for($z = 0 ;$z <count($subsubCategory);$z++)
                {
                    $subsubCategory[$z]->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$subsubCategory[$z]->name;
                    $category[] = $subsubCategory[$z];
                }
            }
        }
        //End Category ==========================
        //Vendor ================================
        $vendorType  =  Core_Vendor::getVendorTypeList();
        $vendor = array();

        foreach($vendorType as $key=>$vType)
        {
            $vendor[$vType] = Core_Vendor::getVendors(array('ftype' => $key),'v_id','DESC');
        }
        //End Vendor ============================
        $_SESSION['brandCategoryAddToken']=Helper::getSecurityToken();//Tao token moi
        $this->registry->smarty->assign(array(	'formData' 		=> $formData,
            'redirectUrl'	=> $this->getRedirectUrl(),
            'error'			=> $error,
            'success'		=> $success,
            'category'      => $category,
            'vendor'       => $vendor,
            'statusList'        =>Core_BrandCategory::getStatusList()
        ));
        $contents  = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
        $this->registry->smarty->assign(array(
                'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
                'contents' 			=> $contents)
        );
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
    }

    public function editAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myBrandCategory = new Core_BrandCategory($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myBrandCategory->id > 0)
        {
            $error 		= array();
            $success 	= array();
            $contents 	= '';
            $formData 	= array();

            $formData['fbulkid']        = array();


            $formData['fid']            = $myBrandCategory->id;
            $formData['fpcid']          = $myBrandCategory->pcid;
            $formData['fvid']           = $myBrandCategory->vid;
            $formData['fname']          = $myBrandCategory->name;
            $formData['fstatus']        = $myBrandCategory->status;
            $formData['fseotitle']      = $myBrandCategory->seotitle;
            $formData['fseotitle']      = $myBrandCategory->seotitle;
            $formData['fseokeyword']      = $myBrandCategory->seokeyword;
            $formData['fseodescription'] = $myBrandCategory->seodescription;
            $formData['ftitlecol1']      = $myBrandCategory->titlecol1;
            $formData['fdesccol1']      = $myBrandCategory->desccol1;
            $formData['ftitlecol2']      = $myBrandCategory->titlecol2;
            $formData['fdesccol2']      = $myBrandCategory->desccol2;
            $formData['ftitlecol3']      = $myBrandCategory->titlecol3;
            $formData['fdesccol3']      = $myBrandCategory->desccol3;
            $formData['ftopseokeyword'] = $myBrandCategory->topseokeyword;
            $formData['ffooterkey']     = $myBrandCategory->footerkey;
            $formData['fdatecreated']   = $myBrandCategory->datecreated;
            $formData['fdatemodified']  = $myBrandCategory->datemodified;

            //Current Slug
            $formData['fslugcurrent'] = $myVendor->slug;
            if(!empty($_POST['fsubmit']))
            {
                //Add formData

                if($_SESSION['brandCategoryAddToken'] == $_POST['ftoken'])
                {

                    $formData = array_merge($formData, $_POST);
                    if($this->addActionValidator($formData,$error))
                    {
                        $brandCategory = new Core_BrandCategory();
                        $brandCategory->id          =  $formData['fid'] ;
                        $brandCategory->pcid        = $formData['fpcid'];
                        $brandCategory->vid         = $formData['fvid'];
                        $brandCategory->name        = $formData['fname'];
                        $brandCategory->seotitle    = $formData['fseotitle'];
                        $brandCategory->seokeyword  = $formData['fseokeyword'];
                        $brandCategory->seodescription = $formData['fseodescription'];
                        $brandCategory->titlecol1   = $formData['ftitlecol1'];
                        $brandCategory->desccol1    = $formData['fdesccol1'];
                        $brandCategory->titlecol2   = $formData['ftitlecol2'];
                        $brandCategory->desccol2    = $formData['fdesccol2'];
                        $brandCategory->titlecol3   = $formData['ftitlecol3'];
                        $brandCategory->desccol3    = $formData['fdesccol3'];
                        $brandCategory->topseokeyword = $formData['ftopseokeyword'];
                        $brandCategory->footerkey       = $formData['ffooterkey'];
                        $brandCategory->status      = $formData['fstatus'];
                        $brandCategory->datecreated = time();
                        if($brandCategory->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succAdd'];
                            $this->registry->me->writelog('brandcategory_add', $brandCategory->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errAdd'];
                        }
                    }
                }
            }
        }
        //Category ==============================
        $categoryParent = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
        $category = array();
        for($i = 0 ;$i <count($categoryParent);$i++)
        {
            $category[] = $categoryParent[$i];
            $subCategory = Core_Productcategory::getProductcategorys(array('fparentid' =>$categoryParent[$i]->id), 'displayorder', 'ASC');
            for($j = 0 ;$j <count($subCategory);$j++)
            {
                $subCategory[$j]->name = '&nbsp;&nbsp;&nbsp;'.$subCategory[$j]->name;
                $category[] = $subCategory[$j];
                $subsubCategory = Core_Productcategory::getProductcategorys(array('fparentid' => $subCategory[$j]->id), 'displayorder', 'ASC');
                for($z = 0 ;$z <count($subsubCategory);$z++)
                {
                    $subsubCategory[$z]->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$subsubCategory[$z]->name;
                    $category[] = $subsubCategory[$z];
                }
            }
        }
        //End Vendor ============================
        //End Category ==========================
        //Vendor ================================
        $vendorType  =  Core_Vendor::getVendorTypeList();
        $vendor = array();

        foreach($vendorType as $key=>$vType)
        {
            $vendor[$vType] = Core_Vendor::getVendors(array('ftype' => $key),'v_id','DESC');
        }
        //End Vendor ============================
        $_SESSION['brandCategoryAddToken']=Helper::getSecurityToken();//Tao token moi
        $this->registry->smarty->assign(array(	'formData' 		=> $formData,
            'redirectUrl'	=> $this->getRedirectUrl(),
            'error'			=> $error,
            'success'		=> $success,
            'category'      => $category,
            'vendor'       => $vendor,
            'statusList'        =>Core_BrandCategory::getStatusList()
        ));
        $contents  = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
        $this->registry->smarty->assign(array(
                'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
                'contents' 			=> $contents)
        );
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
    }

    function deleteAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $brandCategory = new Core_BrandCategory($id);
        if($brandCategory->id > 0)
        {
            //tien hanh xoa
            if($brandCategory->delete())
            {
                $redirectMsg = str_replace('###id###', $brandCategory->id, $this->registry->lang['controller']['succDelete']);

                $this->registry->me->writelog('brandCategory_delete', $brandCategory->id, array());
            }
            else
            {
                $redirectMsg = str_replace('###id###', $brandCategory->id, $this->registry->lang['controller']['errDelete']);
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

    public function addActionValidator($formData, &$error)
    {
        $pass = true;
        if($formData['fname'] == '')
        {
            $error[] = $this->registry->lang['controller']['errNameRequired'];
            $pass = false;
        }
        return $pass;
    }


}

?>