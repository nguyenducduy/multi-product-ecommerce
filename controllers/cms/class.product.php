<?php

Class Controller_Cms_Product Extends Controller_Cms_Base
{
    private $recordPerPage = 300;

    function indexAction()
    {
        $error             = array();
        $success         = array();
        $warning         = array();
        $formData         = array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token
        $page             = (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


        $vidFilter       = (int)($this->registry->router->getArg('vid'));
        $vsubidFilter     =(int)($this->registry->router->getArg('vsubid'));
        $pcidFilter      = (int)($this->registry->router->getArg('pcid'));
        $barcodeFilter   = (string)($this->registry->router->getArg('barcode'));
        $nameFilter      = (string)($this->registry->router->getArg('name'));
        $slugFilter      = (string)($this->registry->router->getArg('slug'));
        $unitpriceFilter = Helper::refineMoneyString($this->registry->router->getArg('unitprice'));
        $sellpriceFilter = Helper::refineMoneyString($this->registry->router->getArg('sellprice'));
        $instockFilter   = (int)($this->registry->router->getArg('instock'));
        $countviewFilter = (int)($this->registry->router->getArg('countview'));
        $statusFilter    = (int)($this->registry->router->getArg('status'));
        if($this->registry->router->getArg('onsitestatus') != '')
        {
            $onsitestatusFilter    = (int)($this->registry->router->getArg('onsitestatus'));
        }

        if($this->registry->router->getArg('businessstatus') != '')
        {
            $businessstatusFilter    = (int)($this->registry->router->getArg('businessstatus'));
        }


        $idFilter        = (int)($this->registry->router->getArg('id'));
        //$instockFilter   = (int)($this->registry->router->getArg('instock'));
        $syncstatusFilter = (int)($this->registry->router->getArg('syncstatus'));
        $barcodestatusFilter   = (int)($this->registry->router->getArg('barcodestatus'));
        $permission      = (string)($this->registry->router->getArg('permission'));

        //check sort column condition
        $sortby     = $this->registry->router->getArg('sortby');
        if($sortby == '') $sortby = 'onsitestatus';
        $formData['sortby'] = $sortby;
        $sorttype     = $this->registry->router->getArg('sorttype');
        if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
        $formData['sorttype'] = $sorttype;


        //display error permission
        switch($permission)
        {
            case 'add' : $error[] = $this->registry->lang['controller']['errorAddPermission'];
                break;
            case 'edit' : $error[] = $this->registry->lang['controller']['errorEditPermission'];
                break;
            case 'delete' : $error[] = $this->registry->lang['controller']['errorDeletePermission'];
                break;
            case 'clone' : $error[] = $this->registry->lang['controller']['errorClonePermission'];
                break;
        }

        if(!empty($_POST['fsubmitbulk']))
        {
            if($_SESSION['productBulkToken']==$_POST['ftoken'])
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
                            $myProduct = new Core_Product($id);

                            if($myProduct->id > 0)
                            {
                                //tien hanh xoa
                                /*if($myProduct->delete())
                                {
                                    $deletedItems[] = $myProduct->id;
                                    $this->registry->me->writelog('product_delete', $myProduct->id, array());
                                }*/
                                $myProduct->status = Core_Product::STATUS_DELETED;
                                $myProduct->datedeleted = time();
                                if($myProduct->updateData())
                                {
                                    $deletedItems[] = $myProduct->id;
                                    $this->registry->me->writelog('product_delete', $myProduct->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myProduct->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProduct->id;
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
        //change order of item
        if(!empty($_POST['fsubmitchangeorder']))
        {
            $displayorderList = $_POST['fdisplayorder'];
            foreach($displayorderList as $id => $neworder)
            {
                $myItem = new Core_Product($id);
                if($myItem->id > 0 && $myItem->displayorder != $neworder)
                {
                    $myItem->displayorder = $neworder;
                    $myItem->updateData();
                }
            }

            $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
        }

        $_SESSION['productBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';


        if($vsubidFilter > 0)
        {
            $paginateUrl .= 'vsubid/'.$vsubidFilter . '/';
            $formData['fvsubid'] = $vsubidFilter;
            $formData['search'] = 'vsubid';
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

        if($barcodeFilter != "")
        {
            $paginateUrl .= 'barcode/'.$barcodeFilter . '/';
            $formData['fbarcode'] = $barcodeFilter;
            $formData['search'] = 'barcode';
        }

        if($nameFilter != "")
        {
            $paginateUrl .= 'name/'.$nameFilter . '/';
            $formData['fname'] = $nameFilter;
            $formData['search'] = 'name';
        }

        if($slugFilter != "")
        {
            $paginateUrl .= 'slug/'.$slugFilter . '/';
            $formData['fslug'] = $slugFilter;
            $formData['search'] = 'slug';
        }

        if($unitpriceFilter > 0)
        {
            $paginateUrl .= 'unitprice/'.$unitpriceFilter . '/';
            $formData['funitprice'] = $unitpriceFilter;
            $formData['search'] = 'unitprice';
        }

        if($sellpriceFilter > 0)
        {
            $paginateUrl .= 'sellprice/'.$sellpriceFilter . '/';
            $formData['fsellprice'] = $sellpriceFilter;
            $formData['search'] = 'sellprice';
        }

        if($instockFilter > 0)
        {
            $paginateUrl .= 'instock/'.$instockFilter . '/';
            $formData['finstock'] = $instockFilter;
            $formData['search'] = 'instock';
        }

        if($countviewFilter > 0)
        {
            $paginateUrl .= 'countview/'.$countviewFilter . '/';
            $formData['fcountview'] = $countviewFilter;
            $formData['search'] = 'countview';
        }

        if($statusFilter > 0)
        {
            $paginateUrl .= 'status/'.$statusFilter . '/';
            $formData['fstatus'] = $statusFilter;
            $formData['search'] = 'status';
        }

        if(isset($onsitestatusFilter))
        {
            $paginateUrl .= 'onsitestatus/'.$onsitestatusFilter . '/';
            $formData['fonsitestatus'] = $onsitestatusFilter;
            $formData['search'] = 'onsitestatus';
        }

        if(isset($businessstatusFilter))
        {
            $paginateUrl .= 'businessstatus/'.$businessstatusFilter . '/';
            $formData['fbusinessstatus'] = $businessstatusFilter;
            $formData['search'] = 'businessstatus';
        }

        if($syncstatusFilter > 0)
        {
            $paginateUrl .= 'syncstatus/'.$syncstatusFilter . '/';
            $formData['fsyncstatus'] = $syncstatusFilter;
            $formData['search'] = 'syncstatus';
        }

        if($instockFilter > 0)
        {
            $paginateUrl .= 'instock/'.$instockFilter . '/';
            $formData['search'] = 'instock';

            switch($instockFilter)
            {
                case 1 :
                    $formData['fquantitythan0'] = $instockFilter;
                    break;
                case 2 :
                    $formData['fquantity0'] = $instockFilter;
                    break;
            }

            $formData['finstock'] = $instockFilter;
        }



        if($barcodestatusFilter > 0)
        {
            $paginateUrl .= 'barcodestatus/'.$barcodestatusFilter . '/';
            $formData['search'] = 'barcodestatus';
            switch($barcodestatusFilter)
            {
                case 2 :
                    $formData['fhasbarcode'] = $barcodestatusFilter;
                    break;
                case 3 :
                    $formData['fhasnotbarcode'] = $barcodestatusFilter;
                    break;
            }

            $formData['fbarcodestatus'] = $barcodestatusFilter;
        }

        if($idFilter > 0)
        {
            $paginateUrl .= 'id/'.$idFilter . '/';
            $formData['fid'] = $idFilter;
            $formData['search'] = 'id';
        }

        //get avalible product
        $formData['favalible'] = 1;

        //chi lay nhung san pham chinh khi khong search id
        //$formData['fcustomizetype'] = 10;

        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            $formData['fpcidarrin'] = array();
            $accessTicketSuffixWithoutId = $this->getAccessTicket('pview_');
            $accessTicketSuffixObjectIdList = $this->registry->me->getAccessTicketSuffixId($accessTicketSuffixWithoutId);
            if(count($accessTicketSuffixObjectIdList) > 0)
            {
                foreach($accessTicketSuffixObjectIdList as $productcategoryid)
                {
                    ////GET FULL SUB CATEGORY
                    $fullsubcategorylist = Core_Productcategory::getFullSubCategory($productcategoryid) ;
                    $formData['fpcidarrin'] = array_merge($formData['fpcidarrin'] , $fullsubcategorylist);
                }
            }

        }

        if(count($formData['fpcidarrin']) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
        {
            //Customize Record Per Page
            if(isset($_GET['recordperpage']) && $_GET['recordperpage'] > 0)
                $_SESSION['productrecordperpage'] = (int)$_GET['recordperpage'];

            if($_SESSION['productrecordperpage'] > 0)
                $this->recordPerPage = $_SESSION['productrecordperpage'];
            //////////

            if(isset($_GET['hidephoto'])) $_SESSION['producthidephoto'] = (int)$_GET['hidephoto'];


            //chi lay nhung san pham chinh
            //tim tong so
            $total = Core_Product::getProducts($formData, $sortby, $sorttype, 0, true);
            $totalPage = ceil($total/$this->recordPerPage);
            $curPage = $page;


            //get latest account
            $products = Core_Product::getProducts($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


            //FORMAT PRICE
            if(count($products) > 0)
            {
                foreach ($products as $product)
                {
                    $product->sellprice = Helper::formatPrice($product->sellprice);
                    $product->unitprice = Helper::formatPrice($product->unitprice);


                    if($product->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
                    {
                        //kiem tra xem san pham chinh hay mau
                        $myRelProductProducts = Core_RelProductProduct::getRelProductProducts(array('fpiddestination' => $product->id) , 'id' , 'ASC' , '0,1');
                        if(count($myRelProductProducts) > 0)
                        {
                            $myRelProductProduct = $myRelProductProducts[0];
                            $myProductSoruce = new Core_Product($myRelProductProduct->pidsource , true);
                            $product->productmainlink = $this->registry['conf']['rooturl_cms'] . 'product/edit/id/' . $myProductSoruce->id;
                        }
                    }
                }
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

        $roleusers = Core_RoleUser::getRoleUsers(array('fuid'=> $this->registry->me->id , 'fstatus' => Core_RoleUser::STATUS_ENABLE), 'id' , 'ASC', '', false, true);
        $cond = array();
        foreach($roleusers as $roleuser)
        {
            if($roleuser->subobjectid > 0)
            {
                $cond[] = $roleuser->subobjectid;
            }
        }

        $vendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_VENDOR, 'fidarr' => $cond), 'name', 'ASC');
        $subVendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_SUBVENDOR), 'name', 'ASC');

        $productcategoryList = array();
        $parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');

        for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
        {
              if($parentCategory1[$i]->parentid == 0)
            {
                $productcategoryList[] = $parentCategory1[$i];
                $parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
                {
                    $parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                    $productcategoryList[] = $parentCategory2[$j];

                    $subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                    foreach ($subCategory as $sub)
                    {
                        $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                        $productcategoryList[] = $sub;
                    }
                }
            }
        }

        //echodebug($productcategoryList,true);

        $this->registry->smarty->assign(array(    'products'     => $products,
                                                'formData'        => $formData,
                                                'success'        => $success,
                                                'error'            => $error,
                                                'warning'        => $warning,
                                                'filterUrl'        => $filterUrl,
                                                'paginateurl'     => $paginateUrl,
                                                'redirectUrl'    => $redirectUrl,
                                                'total'            => $total,
                                                'totalPage'     => $totalPage,
                                                'curPage'        => $curPage,
                                                'statusList'    => Core_Product::getStatusList(),
                                                'syncstatusList' => Core_Product::getSyncStatusList(),
                                                'vendorList'    => $vendorList,
                                                'subVendorList' => $subVendorList,
                                                'productcategoryList'    => $productcategoryList,
                                                'onsitestatusList' => Core_Product::getonsitestatusList(),
                                                'businessstatusList' => Core_Product::getbusinessstatusList(),
                                                ));


        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

    }


    function addAction()
    {
        set_time_limit(0);
        $error    = array();
        $success  = array();
        $contents = '';
        $formData = array();
        $pcid     = 0;
        $pgaid    = 0;

        $slugList = array();

        if($this->registry->router->getArg('pcid') > 0)
        {
            $formData['fpcid'] = (int)$this->registry->router->getArg('pcid');
        }

        if(!empty($_POST['fsubmitNext']))
        {
            $pcid = (int)$_POST['fpcid'];
            if($pcid > 0)
            {
                if(!empty($_POST['fpcid1']))
                {
                    $pcid = (int)$_POST['fpcid1'];
                }
                $formData['fpcid'] = $pcid;
                header('location: '. $this->registry['conf']['rooturl_cms'].'product/add/pcid/'.$pcid);
            }
            else
            {
                $error = $this->registry->lang['controller']['errPcidMustGreaterThanZero'];
            }
        }

        if($formData['fpcid'] > 0)
        {
            // check permission of add product
            $checker = false;
            if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
            {
                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($formData['fpcid']);

                //create suffix
                $suffix = 'padd_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);
            }
            else
            {
                $checker = true;
            }


            // add new product
            if($checker)
            {
                $groupAttributeList = array();
                //kiem tra group attribute va attribute
                if($formData['fpcid'] > 0)
                {
                    $productGroupAttribute = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$formData['fpcid']),'displayorder','ASC');
                    $category = new Core_Productcategory($formData['fpcid']);
                    $parentCategory = 0;
                    if(count($productGroupAttribute) == 0)
                    {
                        //kiem tra xem category cha co group attribute hay khong
                        if($category->parentid > 0)
                        {
                            $productGroupAttributeParent =    Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$category->parentid),'displayorder','ASC');
                            if(count($productGroupAttributeParent) > 0)
                            {
                                $groupAttributeList = $productGroupAttributeParent;
                                $parentCategory = $category->parentid;
                            }
                            else
                            {
                                $error[] = $this->registry->lang['controller']['errAttributeGroup'];
                                $formData['fpcid'] = 0;
                            }
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errAttributeGroup'];
                            $formData['fpcid'] = 0;
                        }
                    }
                    else
                    {
                        $groupAttributeList = $productGroupAttribute;
                    }
                }

                $productAttributeList = array();
                //lay tat ca san pham trong danh muc hien tai
                // $catid = 0;
                // if($parentCategory > 0)
                // {
                //     $catid = $parentCategory;
                // }
                // else
                // {
                //     $catid = $formData['fpcid'];
                // }
                // $productsList = Core_Product::getProducts(array('fpcid' => $catid) , 'id' , 'ASC');

                //lay tat cac ca thuoc tinh trong moi group attribute
                for($i = 0 ; $i < count($groupAttributeList) ; $i++)
                {
                    if($parentCategory > 0)
                        $attributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$parentCategory,'fpgaid'=>$groupAttributeList[$i]->id),'displayorder','ASC');
                    else
                        $attributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$formData['fpcid'],'fpgaid'=>$groupAttributeList[$i]->id),'displayorder','ASC');

                    if(count($attributes) > 0 )
                    {
                        foreach($attributes as $attribute)
                        {
                           $values = Core_RelProductAttribute::getRelProductAttributes(array('fpaid' => $attribute->id) , 'id' , 'ASC');
                                if(count($values) > 0)
                                {
                                    if(count($attribute->values) > 0)
                                    {
                                        $have = false;
                                        foreach($attribute->values as $key=>$value)
                                        {
                                            if($value == $values[0]->value)
                                            {
                                                $have = true;
                                                break;
                                            }
                                        }
                                        if(!$have)
                                        {
                                            $attribute->values[] = $values[0]->value;
                                        }
                                    }
                                    else
                                    {
                                        $attribute->values[] = $values[0]->value;
                                    }
                                }
                        }
                    }

                    //echodebug($attributes,true);

                    $productAttributeList[$groupAttributeList[$i]->name] = $attributes;
                }

                //  lay danh muc goc cua danh muc hien tai
                $category->parent = Core_Productcategory::getFullParentProductCategorys($category->id);


                if(!empty($_POST['fsubmit']))
                {
                   // if($_SESSION['productAddToken'] == $_POST['ftoken'])
//                    {

                        $formData = array_merge($formData, $_POST);

                        $formData['fslug'] = Helper::codau2khongdau(($formData['fslug'] != '') ? $formData['fslug'] : $formData['fname'], true, true);
                           //get all slug related to current slug
                        if($formData['fslug'] != '')
                            $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                        if($this->addActionValidator($formData, $error))
                        {
                            $myProduct = new Core_Product();

                            $myProductcategory = new Core_Productcategory($formData['fpcid']);

                            $myProduct->uid = $this->registry->me->id;
                            $myProduct->vid = $formData['fvid'];
                            $myProduct->vsubid = $formData['fvsubid'];
                            $myProduct->pcid = $formData['fpcid'];
                            if($formData['ffileurl'] != '')
                            {
                                $myProduct->image = $formData['ffileurl'];
                            }
                            $myProduct->barcode          = $formData['fbarcode'];
                            $myProduct->name             = htmlspecialchars(Helper::xss_clean($formData['fname']));
                            $myProduct->slug             = ($formData['fslug'] != '') ? $formData['fslug'] : Helper::codau2khongdau($formData['fname'],true,true);
                            $myProduct->content          = Helper::xss_clean($formData['fcontent']);
                            //Relace image in content
                            $myProduct->content          = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myProduct->content);
                            $myProduct->summary          = Helper::xss_clean($formData['fsummary']);
                            $myProduct->summarynew       = implode('#' , $formData['fsummarynew']);
                            $myProduct->good             = Helper::xss_clean($formData['fgood']);
                            $myProduct->bad              = Helper::xss_clean($formData['fbad']);
                            $myProduct->dienmayreview    = Helper::xss_clean($formData['fdienmayreview']);
                            $myProduct->fullbox          = Helper::xss_clean($formData['ffullbox']);
                            //Relace image in fullbox
                            $myProduct->fullbox          = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myProduct->fullbox);
                            $myProduct->laigop           = $formData['flaigop'];
                            $myProduct->seotitle         = htmlspecialchars(Helper::xss_clean($formData['fseotitle']));
                            $myProduct->seokeyword       = ($myProduct->seokeyword != '') ? Helper::plaintext($formData['fseokeyword']) : $myProduct->name . ',' . $myProductcategory->name . ',' . $this->registry['conf']['rooturl'];
                            $myProduct->seodescription   = Helper::xss_clean($formData['fseodescription']);
                            $myProduct->canonical        = Helper::xss_clean($formData['fcanonical']);
                            $myProduct->metarobot        = Helper::xss_clean($formData['fmetarobot']);
                            $myProduct->topseokeyword    = Helper::xss_clean($formData['ftopseokeyword']);
                            $myProduct->textfooter       = Helper::xss_clean($formData['ftextfooter']);
                            $myProduct->isbagdehot       = (isset($formData['fisbagdehot']) ? 1 : 0);
                            $myProduct->isbagdenew       = (isset($formData['fisbagdenew']) ? 1 : 0);
                            $myProduct->isbagdegift      = (isset($formData['fisbagdegift']) ? 1 : 0);
                            $myProduct->status           = $formData['fstatus'];
                            $myProduct->onsitestatus     = $formData['fonsitestatus'];
                            $myProduct->syncstatus       = Core_Product::STATUS_SYNC_LOCALONLY;
                            $myProduct->customizetype    = Core_Product::CUSTOMIZETYPE_MAIN;
                            $myProduct->ipaddress        = Helper::getIpAddress(true);
                            $myProduct->displaysellprice = (isset($formData['fdisplaysellprice']) ? 1 : 0);
                            $myProduct->warranty         = (int)$formData['fwarranty'];
                            $myProduct->width            = $formData['fpwidth'];
                            $myProduct->height           = $formData['fpheight'];
                            $myProduct->length           = $formData['fplength'];
                            $myProduct->weight           = $formData['fpweight'];
                            $myProduct->transporttype    = $formData['ftransporttype'];
                            $myProduct->setuptype        = $formData['fsetuptype'];
                            $myProduct->businessstatus   = $formData['fbusinessstatus'];
                            $myProduct->isrequestimei    = $formData['fisrequestimei'];
                            $myProduct->displaymanual    = $formData['fdisplaymanual'];


                            //kiem tra neu trang thai onsitestatus la ERP thi xoa prepaid startdate va prepaid enddate
                            if($myProduct->onsitestatus == Core_Product::OS_ERP)
                            {
                                $myProduct->prepaidstartdate = 0;
                                $myProduct->prepaidenddate = 0;
                            }
                            else if($myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID)
                            {
                                $myProduct->prepaidstartdate = Helper::strtotimedmy($formData['fprepaidstartdate'],$formData['fsttime']);
                                $myProduct->prepaidenddate = Helper::strtotimedmy($formData['fprepaidenddate'],$formData['fextime']);
                                $myProduct->prepaidprice  = Helper::refineMoneyString($formData['fprepaidprice']);
                                $myProduct->prepaidname = $formData['fprepaidname'];
                                $myProduct->prepaidpromotion = $formData['fprepaidpromotion'];
                                $myProduct->prepaidpolicy =$formData['fprepaidpolicy'];
                                $myProduct->prepaidrand = $formData['fprepaidrand'];
                                $myProduct->prepaiddepositrequire = Helper::refineMoneyString($formData['fprepaiddepositrequire']);
                            }

                            //kiem tra neu trang thai onsitestatus la ERP thi xoa comingsoondate va comingsoonprice
                            if($myProduct->onsitestatus == Core_Product::OS_ERP)
                            {
                                $myProduct->comingsoondate = '';
                                $myProduct->comingsoonprice = '';
                            }
                            else if($myProduct->onsitestatus == Core_Product::OS_COMMINGSOON)
                            {
                                $myProduct->comingsoondate = $formData['fcomingsoondate'];
                                $myProduct->comingsoonprice = $formData['fcomingsoonprice'];
                            }

                            //insert attribute for product
                            $attrList = $_POST['fattr'];
                            $ok = false;
                            if($myProduct->addData())
                            {
                                //update color list
                                $colorlist = '';
                                $colorlist .= $myProduct->id . ':' . $formData['fname'];
                                if($formData['fpchoosecolor'] == -1)
                                {
                                    $colorlist .= ':' . $formData['fpcolorname'] . ':' . substr($formData['fpcolor'], 1);
                                }
                                else
                                {
                                    $colorlist .=  ':' . 'Không xác định:kxd';
                                }
                                $colorlist .= ':1';
                                $myProduct->colorlist = $colorlist;
                                $myProduct->updateData();

                                //add product index
                                $myProductindex = new Core_Backend_Productindex();
                                $myProductindex->pid = $myProduct->id;
                                $myProductindex->updateData();

                                if(count($attrList) > 0)
                                {
                                    foreach($attrList as $attr=>$value)
                                    {
                                        $rpa = new Core_RelProductAttribute();
                                        $rpa->pid = (int)$myProduct->id;
                                        $rpa->paid = (int)$attr;
                                        $rpa->value = ($value != -1) ? $value : '';
                                        $rpa->weight = $formData['fweight'][$attr];
                                        $rpa->valueseo = ($value != -1) ? Helper::codau2khongdau($value) : '';
                                        $rpa->description = Helper::xss_clean($formData['fattrdescription'][$attr]);
                                        if($rpa->addData())
                                        {
                                            $ok = true;
                                        }
                                        else
                                        {
                                            break;
                                        }

                                        $formData['fattr'] = $attrList;
                                    }
                                }

                                $attrList = $_POST['fattropt'];
                                if(count($attrList) > 0)
                                {
                                    foreach($attrList as $attr=>$value)
                                    {
                                        if(strlen($value) > 0)
                                        {
                                            $rpa = new Core_RelProductAttribute();
                                            $rpa->pid = (int)$myProduct->id;
                                            $rpa->paid = (int)$attr;
                                            $rpa->value = $value;
                                            $rpa->weight = $formData['fweight'][$attr];
                                            $rpa->valueseo = Helper::codau2khongdau($value);
                                            $rpa->description = Helper::xss_clean($formData['fattrdescription'][$attr]);
                                            if($rpa->addData())
                                            {
                                                $ok = true;
                                            }
                                            else
                                            {
                                                break;
                                            }
                                        }
                                    }
                                }

                                ///////////////////////////////////
                                   //Add Slug base on slug of page
                                $mySlug = new Core_Slug();
                                $mySlug->uid = $this->registry->me->id;
                                $mySlug->slug = $myProduct->slug;
                                $mySlug->controller = 'product';
                                $mySlug->objectid = $myProduct->id;
                                if(!$mySlug->addData())
                                {
                                    $error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

                                    //reset slug of current item
                                    $myProduct->slug = '';
                                    $myProduct->updateData();
                                }
                                //end Slug process
                                ////////////////////////////////
                            }
                            else
                            {
                                $error[] = $this->registry->lang['controller']['errAdd'];
                            }


                            //echodebug($_FILES['ffile'],true);
                            foreach($formData['furl'] as $key=>$value)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->moreurl = $value;
                                $productMedia->caption = $formData['fcaption'][$key];
                                $productMedia->alt = $formData['falt'][$key];
                                $productMedia->titleseo = $formData['ftitleseo'][$key];
                                $productMedia->mediaorder = -1;
                                $productMedia->type = Core_ProductMedia::TYPE_URL;
                                if(strlen($value) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            for($key = 0 ; $key < count($_FILES['ffile']['size']); $key++)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                if(strrpos($formData['fimageurl'][$key], '?'))
                                {
                                    $formData['fimageurl'][$key] = substr($formData['fimageurl'][$key], 0, strrpos($formData['fimageurl'][$key], '?'));
                                }
                                $productMedia->caption = Helper::codau2khongdau($formData['fname'],true,true) . $key;
                                $productMedia->alt = Helper::codau2khongdau($formData['fname'],true,true) . $key;
                                $productMedia->titleseo = Helper::codau2khongdau($formData['fname'],true,true);
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_FILE;
                                if($productMedia->moreurl != '' || strlen($_FILES['ffile']['name'][$productMedia->mediaorder]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }


                            /*if(isset($_FILES['ffile']))
                            {
                                //unset($_FILES['ffile']);
                                $_FILES['ffile'] = $_FILES['ffile360'];
                            }*/
                            unset($_FILES['ffile']);
                            $_FILES['ffile'] = $_FILES['ffile360'];

                            //them hinh 360
                            for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->caption = Helper::codau2khongdau($formData['fname'] , true, true) . '-360-'. $key;
                                $productMedia->alt = Helper::codau2khongdau($formData['fname'] , true, true) . '-360-'. $key;
                                $productMedia->titleseo = Helper::codau2khongdau($formData['fname'] , true, true) . '-360-'. $key;
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_360;
                                if(strlen($_FILES['ffile']['name'][$key]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }
                            unset($_FILES['ffile']);
                            $_FILES['ffile'] = $_FILES['ftypespecialimg'];

                            //them hinh thong so ky thuat
                            $productMedia = new Core_ProductMedia();
                            $productMedia->pid = $myProduct->id;
                            $productMedia->uid = $this->registry->me->id;
                            $productMedia->caption = $formData['ftypespecialcaption'];
                            $productMedia->alt = $formData['ftypespecialalt'];
                            $productMedia->titleseo = $formData['ftypespecialtitle'];
                            $productMedia->type = Core_ProductMedia::TYPE_SPECIALTYPE;
                            $productMedia->mediaorder = 0;
                            if(strlen($_FILES['ffile']['name'][0]) > 0)
                            {
                                if($productMedia->addData() > 0)
                                {
                                    $ok = true;
                                }
                            }

                            //add product 's accessories
                            if(count($formData['accessories']) >0)
                            {
                                foreach($formData['accessories'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_ACCESSORIES;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            if(count($formData['sample']) > 0)
                            {
                                foreach($formData['sample'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_SAMPLE;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            if(count($formData['product2']) > 0)
                            {
                                foreach($formData['product2'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_PRODUCT2;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            if(count($formData['product3']) > 0)
                            {
                                foreach($formData['product3'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_PRODUCT3;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            if(count($formData['product4']) > 0)
                            {
                                foreach($formData['product4'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $rp;
                                    $relProduct->piddestination = $myProduct->id;
                                    $relProduct->type = Core_RelProductProduct::TYPE_ACCESSORIES;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }



                            if($ok)
                            {
                                //Insert keyword to keyword table
                                if($formData['fkeyword'] != '')
                                {
                                    $keywordArr = explode(',', $formData['fkeyword']);

                                    foreach($keywordArr as $keyword)
                                    {
                                        $existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');

                                        if(empty($existKeyword))
                                        {
                                            $myKeyword = new Core_Keyword();
                                            $myKeyword->text = trim($keyword);
                                            $myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
                                            $myKeyword->hash = MD5($keyword);
                                            $myKeyword->from = Core_Keyword::TYPE_PRODUCT;
                                            $myKeyword->status = Core_Keyword::STATUS_ENABLE;

                                            $myKeyword->id = $myKeyword->addData();

                                            $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myProduct->id), '', '', '');

                                            if(empty($record))
                                            {
                                                $myRelkeyword = new Core_RelItemKeyword();
                                                $myRelkeyword->kid = $myKeyword->id;
                                                $myRelkeyword->type = Core_RelItemKeyword::TYPE_PRODUCT;
                                                $myRelkeyword->objectid = $myProduct->id;

                                                $myRelkeyword->addData();
                                            }
                                        }

                                        foreach($existKeyword as $existkey)
                                        {
                                            $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myProduct->id), '', '', '');

                                            if(empty($record))
                                            {
                                                $myRelkeyword = new Core_RelItemKeyword();
                                                $myRelkeyword->kid = $existkey->id;
                                                $myRelkeyword->type = Core_RelItemKeyword::TYPE_PRODUCT;
                                                $myRelkeyword->objectid = $myProduct->id;

                                                $myRelkeyword->addData();
                                            }
                                        }
                                    }
                                }

                                $success[] = $this->registry->lang['controller']['succAdd'];
                                $this->registry->me->writelog('product_add', $myProduct->id, array());

                                $urlcron = $this->registry->conf['rooturl']."task/externalimagedownload/imageproductdownloadbyid?id=".$myProduct->id;
                                //Run scon
                                Helper::backgroundHttpGet($urlcron);


                                ///////////////////////////////////////////////
                                //call background task to send notification
                                $taskUrl = $this->registry->conf['rooturl']."task/productchangenotify?uid=".$this->registry->me->id."&id=".$myProduct->id . '&from=add&editsection=';
                                Helper::backgroundHttpGet($taskUrl);




                                $formData = array();
                            }
                            else
                            {
                                $error[] = $this->registry->lang['controller']['errAdd'];
                            }
                        }
                   // }//end of if

                }
            }
            else
            {
                header('location: ' . $this->registry['conf']['rooturl_cms'].'product/index/permission/add');
                exit();
            }
        }


        ##########################################
        $roleusers = Core_RoleUser::getRoleUsers(array('fuid'=> $this->registry->me->id , 'fstatus' => Core_RoleUser::STATUS_ENABLE), 'id' , 'ASC', '', false, true);
        $cond = array();
        foreach($roleusers as $roleuser)
        {
            if($roleuser->subobjectid > 0)
            {
                $cond[] = $roleuser->subobjectid;
            }
        }

        $vendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_VENDOR, 'fidarr' => $cond), 'name', 'ASC');
        $subVendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_SUBVENDOR), 'name', 'ASC');

        $productcategoryList = array();
        $parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
        for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
        {
            if($parentCategory1[$i]->parentid == 0)
            {
                $productcategoryList[] = $parentCategory1[$i];
                $parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
                {
                    $parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                    $productcategoryList[] = $parentCategory2[$j];

                    $subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                    foreach ($subCategory as $sub)
                    {
                        $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                        $productcategoryList[] = $sub;
                    }
                }
            }
        }

        ///// GET PRODUCT COLOR
        $productcolors = Core_Productcolor::getProductcolors(array('fstatus' => Core_Productcolor::STATUS_ENABLE) , 'id' , 'ASC');

        $_SESSION['productAddToken']=Helper::getSecurityToken();//Tao token moi


        $this->registry->smarty->assign(array(  'formData'         => $formData,
                                                'redirectUrl'    => $this->getRedirectUrl(),
                                                'error'            => $error,
                                                'success'        => $success,
                                                'vendorList'    => $vendorList,
                                                'subVendorList'    => $subVendorList,
                                                'productcategoryList' => $productcategoryList,
                                                'statusList'    => Core_Product::getStatusList(),
                                                'category'      => $category,
                                                'productAttributeList' => $productAttributeList,
                                                'mediaList'        => Core_ProductMedia::getMediaType(),
                                                'slugList'        => $slugList,
                                                'onsitestatusList' => Core_Product::getonsitestatusList(),
                                                'category' => $category,
                                                'transporttypeList' => Core_Product::getTranspostTypeList(),
                                                'setuptypeList' => Core_Product::getSetupTypeList(),
                                                'businessstatusList' => Core_PRoduct::getbusinessstatusList(),
                                                'productcolors' => $productcolors,
                                                ));

        if($formData['fpcid'] > 0)
        {
            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addproduct.tpl');
        }
        else
        {
            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
        }

        $this->registry->smarty->assign(array(
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_add'],
                                                'contents'             => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }



    function editAction()
    {
        set_time_limit(0);
        ini_set('memory_limit','1260M');
        $id = (int)$this->registry->router->getArg('id');
        $from = (string)$this->registry->router->getArg('from');
        $tab = (int)$this->registry->router->getArg('tab') > 0 ? (int)$this->registry->router->getArg('tab') : 1;
        $myProduct = new Core_Product($id);

        $redirectUrl = $this->getRedirectUrl();
        if($myProduct->id > 0)
        {
            $error         = array();
            $success     = array();
            $contents     = '';
            $formData     = array();
            $slugList    = array();

            $formData['fbulkid']          = array();

            //select keyword
            $myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $myProduct->id), 'ik_id', 'ASC', '');
            $selectKeywordArr = array();

            foreach($myKeyword as $keyword)
            {
                $selectKeyword = new Core_Keyword($keyword->kid);

                $selectKeywordArr[] = $selectKeyword->text;
            }

            $formData['fkeyword']            = implode(',',$selectKeywordArr);

            $formData['fuid']                = $myProduct->uid;
            $formData['fvid']                = $myProduct->vid;
            $formData['fvsubid']             = $myProduct->vsubid;
            $formData['fpcid']               = $myProduct->pcid;
            $formData['fid']                 = $myProduct->id;
            $formData['fbarcode']            = $myProduct->barcode;
            $formData['fname']               = htmlspecialchars_decode($myProduct->name);
            $formData['fimage']              = ($myProduct->image != '') ? $myProduct->getSmallImage() : '';
            $formData['fslug']               = $myProduct->slug;
            $formData['fcontent']            = $myProduct->content;
            $formData['fsummary']            = $myProduct->summary;
            $formData['fgood']               = $myProduct->good;
            $formData['fbad']                = $myProduct->bad;
            $formData['fdienmayreview']      = $myProduct->dienmayreview;
            $formData['ffullbox']            = $myProduct->fullbox;
            $formData['ffullboxshort']       = $myProduct->fullboxshort;
            $formData['flaigopauto']         = $myProduct->laigopauto;
            $formData['flaigop']             = $myProduct->laigop;
            $formData['fseotitle']           = htmlspecialchars_decode($myProduct->seotitle);
            $formData['fseokeyword']         = $myProduct->seokeyword;
            $formData['fseodescription']     = $myProduct->seodescription;
            $formData['fcanonical']          = $myProduct->canonical;
            $formData['fmetarobot']          = $myProduct->metarobot;
            $formData['ftopseokeyword']      = $myProduct->topseokeyword;
            $formData['ftextfooter']         = $myProduct->textfooter;
            $formData['funitprice']          = Helper::formatPrice($myProduct->unitprice);
            $formData['fsellprice']          = Helper::formatPrice($myProduct->sellprice);
            $formData['fvendorprice']        = $myProduct->vendorprice;
            $formData['fdiscountpercent']    = $myProduct->discountpercent;
            $formData['fisbagdehot']         = (!isset($_POST['fsubmit'])?$myProduct->isbagdehot:(!empty($_POST['fisbagdehot'])?1:0));
            $formData['fisbagdenew']         = (!isset($_POST['fsubmit'])?$myProduct->isbagdenew:(!empty($_POST['fisbagdenew'])?1:0));
            $formData['fisbagdegift']        = (!isset($_POST['fsubmit'])?$myProduct->isbagdegift:(!empty($_POST['fisbagdegift'])?1:0));
            $formData['finstock']            = $myProduct->instock;
            $formData['fcountview']          = $myProduct->countview;
            $formData['fcountreview']        = $myProduct->countreview;
            $formData['fcountrating']        = $myProduct->countrating;
            $formData['faveragerating']      = $myProduct->averagerating;
            //$formData['fcolorList']          = explode('###',$myProduct->colorlist);
            $formData['fdisplayroder']       = $myProduct->displayorder;
            $formData['fstatus']             = $myProduct->status;
            $formData['fonsitestatus']       = $myProduct->onsitestatus;
            $formData['fbusinessstatus']     = $myProduct->businessstatus;
            $formData['fdisplaytype']        = $myProduct->displaytype;
            $formData['fipaddress']          = $myProduct->ipaddress;
            $formData['fdatedeleted']        = $myProduct->datedeleted;
            $formData['fdatelastsync']       = $myProduct->datelastsync;
            $formData['fdatecreated']        = $myProduct->datecreated;
            $formData['fdatemodified']       = $myProduct->datemodified;
            $formData['fwarranty']           = $myProduct->warranty;
            $formData['fdisplaysellprice']   = (!isset($_POST['fsubmit'])?$myProduct->displaysellprice:(!empty($_POST['fdisplaysellprice'])?1:0));
            $formData['productpath']         = $myProduct->getProductPath();
            $formData['fprepaidprice']       = Helper::formatPrice($myProduct->prepaidprice);
            $prepaidstartdate                = date("d/m/Y H:i:s",$myProduct->prepaidstartdate);
            $prepaidstartdate                = explode(" ", $prepaidstartdate);
            $formData['fprepaidstartdate']   = $prepaidstartdate[0];
            $formData['fsttime']             = $prepaidstartdate[1];
            $prepaidenddate                  = date("d/m/Y H:i:s",$myProduct->prepaidenddate);
            $prepaidenddate                  = explode(" ", $prepaidenddate);
            $formData['fprepaidenddate']     = $prepaidenddate[0];
            $formData['fextime']             = $prepaidenddate[1];
            $formData['fprepaidname']        = $myProduct->prepaidname;
            $formData['fprepaidpromotion']   = $myProduct->prepaidpromotion;
            $formData['fprepaidpolicy']      = $myProduct->prepaidpolicy;
            $formData['fprepaidrand']        = $myProduct->prepaidrand;
            $formData['fprepaiddepositrequire'] = Helper::formatPrice($myProduct->prepaiddepositrequire);
            //$formData['fprepaidstartdate']   = $myProduct->prepaidstartdate > 0 ? date('d/m/Y' , $myProduct->prepaidstartdate) : date('d/m/Y' , time() + 24 *3600);
            //$formData['fprepaidenddate']     = $myProduct->prepaidenddate > 0 ? date('d/m/Y', $myProduct->prepaidenddate) :  date('d/m/Y' , time() + 7 * 24 *3600);
            $formData['fpcomingsoonprice']   = $myProduct->comingsoonprice;
            $formData['fpcomingsoondate']    = $myProduct->comingsoondate;
            $formData['fapplypromotionlist'] = $myProduct->applypromotionlist;
            $formData['fimportdate']         = $myProduct->importdate > 0 ? date('d/m/Y' , $myProduct->importdate) : date('d/m/Y' , time() + 14 * 24 * 3600);
            $formData['fpwidth']             = $myProduct->width;
            $formData['fplength']            = $myProduct->length;
            $formData['fpheight']            = $myProduct->height;
            $formData['fpweight']            = $myProduct->weight;
            $formData['fsetuptype']          = $myProduct->setuptype;
            $formData['ftransporttype']      = $myProduct->transporttype;
            $formData['fisrequestimei']      = $myProduct->isrequestimei;
            $formData['fcomingsoodate'] = $myProduct->comingsoondate;
            $formData['fcomingsoonprice'] = $myProduct->comingsoonprice;
            $formData['fdisplaymanual']      = $myProduct->displaymanual;
            $formData['fcustomizetype'] = $myProduct->customizetype;
            $formData['ftab'] = $tab;
            $formData['fproductlink'] = $myProduct->getProductPath();

            //get new summary
            $formData['fsummarynew'] = array();

            if(strlen($myProduct->summarynew) > 0)
            {
                $formData['fsummarynew'] = explode('#' , $myProduct->summarynew);
            }

            //Current Slug
            $formData['fslugcurrent'] = $myProduct->slug;
            $category = new Core_Productcategory($formData['fpcid']);

            $checker = false;
            if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
            {
                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($myProduct->pcid);

                //create suffix
                $suffix = 'pedit_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);
            }
            else
            {
                $checker = true;
            }


            //kiem tra phan quyen
            if(!$checker)
            {
                header('location: ' . $this->registry['conf']['rooturl_cms'].'product/index/permission/edit');
                exit();
            }

            if(!empty($_POST['fdeletegallery']))
            {
                $formData = array_merge($formData, $_POST);
                if(count($formData['fdeletegallerys']) > 0)
                {
                    $ok = false;
                    foreach ($formData['fdeletegallerys'] as $productmediaid => $value)
                    {
                        $productmedia = new Core_ProductMedia($productmediaid);
                        if($productmedia->id > 0)
                        {
                            if($productmedia->delete() > 0 )
                            {
                                $ok = true;
                            }
                        }
                    }

                    if($ok)
                    {
                        $success[] = 'Xóa gallery thành công.';
                    }
                }
            }

            if( !empty($_POST['fdeletegallery360']) )
            {
                $formData = array_merge($formData , $_POST);
                if( count($formData['fdeletegallery360']) > 0 )
                {
                    $ok = false;

                    foreach( $formData['fdeletegallerys360'] as $productmediaid => $value)
                    {
                        $productmedia = new Core_ProductMedia($productmediaid);

                        if($productmedia->id > 0)
                        {
                            if($productmedia->delete() > 0 )
                            {
                                $ok = true;
                            }
                        }
                    }

                    if($ok)
                    {
                        $success = 'Xóa gallery 360 thành công.';
                    }
                }
            }


            if(!empty($_POST['fsubmit']))
            {
                //if($_SESSION['productEditToken'] == $_POST['ftoken'])
//                {
                    $formData = array_merge($formData, $_POST);
                    /////////////////////////
                    //get all slug related to current slug
                    $formData['fslug'] = Helper::codau2khongdau(($formData['fslug'] != '') ? $formData['fslug'] : $formData['fname'], true, true);
                    if($formData['fslug'] != '')
                        $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                    if($this->editActionValidator($formData, $error))
                    {
                        //echodebug($_FILES['ffile360'],true);
                        $myProduct->vid = $formData['fvid'];
                        $myProduct->vsubid = $formData['fvsubid'];
                        $myProduct->pcid = $formData['fpcid'];

                        $myProductcategory = new Core_Productcategory($myProduct->id);

                        if($formData['ffileurl'] != '')
                        {
                            $myProduct->image = $formData['ffileurl'];
                        }
                        $myProduct->uid              = $this->registry->me->id;
                        $myProduct->barcode          = $formData['fbarcode'];
                        $myProduct->name             = htmlspecialchars(Helper::xss_clean($formData['fname']));
                        $myProduct->slug             = (strlen($formData['fslug']) > 0) ? $formData['fslug'] : Helper::codau2khongdau($formData['fname'],true,true);
                        $myProduct->content          = Helper::xss_clean($formData['fcontent']);
                        $myProduct->content          = Helper::xss_clean($formData['fcontent']);
                        //Relace image in content
                        $myProduct->content          = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myProduct->content);
                        $myProduct->summary          = Helper::xss_clean($formData['fsummary']);

                        $myProduct->summarynew       = implode('#' , $formData['fsummarynew']);

                        $myProduct->good             = Helper::xss_clean($formData['fgood']);
                        $myProduct->bad              = Helper::xss_clean($formData['fbad']);
                        $myProduct->dienmayreview    = Helper::xss_clean($formData['fdienmayreview']);
                        $myProduct->fullbox          = Helper::xss_clean($formData['ffullbox']);
                        //Relace image in content
                        $myProduct->fullbox          = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myProduct->fullbox);
                        $myProduct->fullboxshort     = Helper::xss_clean($formData['ffullboxshort']);
                        $myProduct->laigopauto       = $formData['flaigopauto'];
                        $myProduct->laigop           = $formData['flaigop'];
                        $myProduct->seotitle         = htmlspecialchars(Helper::xss_clean($formData['fseotitle']));
                        $myProduct->seokeyword       = ($myProduct->seokeyword != '') ? Helper::xss_clean($formData['fseokeyword']) : $myProduct->name . ',' . $myProductcategory->name . ',' . $this->registry['conf']['rooturl'];
                        $myProduct->seodescription   = Helper::xss_clean($formData['fseodescription']);
                        $myProduct->canonical        = Helper::xss_clean($formData['fcanonical']);
                        $myProduct->metarobot        = Helper::xss_clean($formData['fmetarobot']);
                        $myProduct->topseokeyword    = Helper::xss_clean($formData['ftopseokeyword']);
                        $myProduct->textfooter       = Helper::xss_clean($formData['ftextfooter']);
                        $myProduct->unitprice        = Helper::refineMoneyString($formData['funitprice']);
                        //$myProduct->sellprice      = Helper::refineMoneyString($formData['fsellprice']);
                        $myProduct->vendorprice      = Helper::refineMoneyString($formData['fvendorprice']);
                        $myProduct->discountpercent  = $formData['fdiscountpercent'];
                        $myProduct->isbagdehot       = (isset($formData['fisbagdehots']) ? 1 : 0);
                        $myProduct->isbagdenew       = (isset($formData['fisbagdenews']) ? 1 : 0);
                        $myProduct->isbagdegift      = (isset($formData['fisbagdegifts']) ? 1 : 0);
                        //$myProduct->instock        = $formData['finstock'];
                        $myProduct->countview        = $formData['fcountview'];
                        $myProduct->countreview      = $formData['fcountreview'];
                        $myProduct->countrating      = $formData['fcountrating'];
                        $myProduct->averagerating    = $formData['faveragerating'];
                        $myProduct->status           = $formData['fstatus'];
                        $myProduct->onsitestatus     = $formData['fonsitestatus'];
                        //$myProduct->businessstatus   = $formData['fbusinessstatus'];
                        $myProduct->displaytype      = $formData['fdisplaytype'];
                        $myProduct->ipaddress        = $formData['fipaddress'];
                        $myProduct->displayorder     = $formData['fdisplayroder'];
                        $myProduct->displaysellprice = ($formData['fdisplaysellprice']==1 ? 1 : 0);
                        $myProduct->warranty         = (int)$formData['fwarranty'];
                        $myProduct->width            = $formData['fpwidth'];
                        $myProduct->height           = $formData['fpheight'];
                        $myProduct->length           = $formData['fplength'];
                        $myProduct->weight           = $formData['fpweight'];
                        $myProduct->transporttype    = $formData['ftransporttype'];
                        $myProduct->setuptype        = $formData['fsetuptype'];
                        $myProduct->isrequestimei    = $formData['fisrequestimei'];
                        $myProduct->displaymanual    = $formData['fdisplaymanual'];

                        if($myProduct->onsitestatus == Core_Product::OS_COMMINGSOON)
                        {
                            $myProduct->importdate = strtotime(implode('-', array_reverse(explode('/', $formData['fimportdate']))));
                        }
                        else
                        {
                            $myProduct->importdate = 0;
                        }

                        if(isset($formData['fapplyprid']))
                        {
                            $count = 0;
                            $formData['fapplypromotionlist'] = '';
                            foreach($formData['fapplyprid'] as $rid => $prid)
                            {
                                if($count == count($formData['fapplyprid']) - 1)
                                {
                                    $formData['fapplypromotionlist'] .= $rid .'###' . $prid;
                                }
                                else
                                {
                                     $formData['fapplypromotionlist'] .= $rid .'###' . $prid . ',';
                                }

                                $count++;
                            }

                            $myProduct->applypromotionlist = $formData['fapplypromotionlist'];
                        }
                        else
                        {
                            $myProduct->applypromotionlist = '0';
                        }

                        //kiem tra neu trang thai onsitestatus la ERP thi xoa prepaid startdate va prepaid enddate
                        if($myProduct->onsitestatus == Core_Product::OS_ERP)
                        {
                            $myProduct->prepaidstartdate = 0;
                            $myProduct->prepaidenddate = 0;
                            $myproduct->prepaidname = "";
                            $myproduct->prepaidpolicy = "";
                            $myproduct->prepaidrand = 0;
                            $myproduct->prepaiddepositrequire = 0;

                        }
                        else if($myProduct->onsitestatus == Core_Product::OS_ERP_PREPAID)
                        {
                            $myProduct->prepaidstartdate = Helper::strtotimedmy($formData['fprepaidstartdate'],$formData['fsttime']);
                            $myProduct->prepaidenddate = Helper::strtotimedmy($formData['fprepaidenddate'],$formData['fextime']);
                            $myProduct->prepaidprice = (float)Helper::refineMoneyString($formData['fprepaidprice']);
                            $myProduct->prepaidname = $formData['fprepaidname'];
                            $myProduct->prepaidpromotion = $formData['fprepaidpromotion'];
                            $myProduct->prepaidpolicy =$formData['fprepaidpolicy'];
                            $myProduct->prepaidrand = $formData['fprepaidrand'];
                            $myProduct->prepaiddepositrequire = Helper::refineMoneyString($formData['fprepaiddepositrequire']);
                        }

                        //kiem tra neu trang thai onsitestatus la ERP thi xoa comingsoondate va comingsoonprice
                        if($myProduct->onsitestatus == Core_Product::OS_ERP)
                        {
                            $myProduct->comingsoondate = '';
                            $myProduct->comingsoonprice = '';
                        }
                        else if($myProduct->onsitestatus == Core_Product::OS_COMMINGSOON)
                        {
                            $myProduct->comingsoondate = $formData['fcomingsoondate'];
                            $myProduct->comingsoonprice = $formData['fcomingsoonprice'];
                        }
                        //update color list
                        $colorlist = '';
                        $colorlistdata = explode('###',$myProduct->colorlist);
                        if(count($colorlistdata) > 0 && !empty($colorlistdata[0]))
                        {
                            $i = 0;
                            foreach ($colorlistdata as $colordata)
                            {
                                $listdata = explode(':', $colordata);
                                if(isset($formData['fdefaultcolor'][$listdata[0]]))
                                {
                                    if($listdata[0] == $formData['fid']) // cap nhat thong tin cho mau chinh cua san pham
                                    {
                                        $colorlist .= $myProduct->id . ':' . $formData['fname'];
                                        if($formData['fpchoosecolor'] == -1)
                                        {
                                            $colorlist .= ':' . $formData['fpcolorname'] . ':' . substr($formData['fpcolorstring'], 1);
                                        }
                                        else
                                        {
                                            $colorlist .=  ':' . 'Không xác định:kxd';
                                        }
                                    }
                                    else
                                    {
                                        $colorlist .= $listdata[0] . ':' . $formData['fname'] . ':' . $listdata[2] . ':' . $listdata[3];
                                    }
                                    $colorlist .= ' :' . (isset($formData['fdefaultcolormain'][$listdata[0]]) ? '1' : '0' );

                                    if($i < count($formData['fdefaultcolor'])-1)
                                    {
                                        $colorlist .= '###';
                                    }
                                    $i++;
                                }
                            }
                        }
                        else
                        {
                            $colorlist .= $myProduct->id . ':' . $formData['fname'];
                            if($formData['fpchoosecolor'] == -1)
                            {
                                $colorlist .= ':' . $formData['fpcolorname'] . ':' . substr($formData['fpcolorstring'], 1);
                            }
                            else
                            {
                                $colorlist .=  ':' . 'Không xác định:kxd';
                            }
                        }

                        $myProduct->colorlist = $colorlist;
                        /////////////////////////////////////////////

                        //add product index
                        $myProductindex = new Core_Backend_Productindex();
                        $myProductindex->pid = $myProduct->id;
                        $myProductindex->updateData();

                        $ok = false;
                        //echodebug($formData,true);
                        if($myProduct->updateData())
                        {
                            $ok = true;
                            //update keyword to keyword table
                            if($formData['fkeyword'] != '')
                            {
                                $keywordArr = explode(',', $formData['fkeyword']);

                                //kiem tra array de xoa keyword
                                $checkKeyword = array_diff($selectKeywordArr, $keywordArr);

                                if(!empty($checkKeyword))
                                {
                                    foreach($checkKeyword as $keyname)
                                    {
                                        $keyhash = MD5($keyname);

                                        $deleteList = Core_Keyword::getKeywords(array('fkeyword' => $keyhash), '', '', '');

                                        foreach($deleteList as $delete)
                                        {
                                            $myDelete = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $delete->id), '', '', '');

                                            foreach($myDelete as $deleted)
                                            {
                                                $deleted->delete();
                                            }
                                        }
                                    }
                                }

                                foreach($keywordArr as $keyword)
                                {
                                    $existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');

                                    if(empty($existKeyword))
                                    {
                                        $myKeyword = new Core_Keyword();
                                        $myKeyword->text = trim($keyword);
                                        $myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
                                        $myKeyword->hash = MD5($keyword);
                                        $myKeyword->from = Core_Keyword::TYPE_PRODUCT;
                                        $myKeyword->status = Core_Keyword::STATUS_ENABLE;

                                        $myKeyword->id = $myKeyword->addData();

                                        $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myProduct->id), '', '', '');

                                        if(empty($record))
                                        {
                                            $myRelkeyword = new Core_RelItemKeyword();
                                            $myRelkeyword->kid = $myKeyword->id;
                                            $myRelkeyword->type = Core_RelItemKeyword::TYPE_PRODUCT;
                                            $myRelkeyword->objectid = $myProduct->id;

                                            $myRelkeyword->addData();
                                        }
                                    }

                                    foreach($existKeyword as $existkey)
                                    {
                                        $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myProduct->id), '', '', '');

                                        if(empty($record))
                                        {
                                            $myRelkeyword = new Core_RelItemKeyword();
                                            $myRelkeyword->kid = $existkey->id;
                                            $myRelkeyword->type = Core_RelItemKeyword::TYPE_PRODUCT;
                                            $myRelkeyword->objectid = $myProduct->id;

                                            $myRelkeyword->addData();
                                        }
                                    }
                                }
                            }

                            if($formData['fcustomizetype'] == Core_Product::CUSTOMIZETYPE_MAIN)
                            {
                                ///////////////////////////////////
                                //Add Slug base on slug of page
                                if($formData['fslug'] != $formData['fslugcurrent'])
                                {
                                    $mySlug = new Core_Slug();
                                    $mySlug->uid = $this->registry->me->id;
                                    $mySlug->slug = $myProduct->slug;
                                    $mySlug->controller = 'product';
                                    $mySlug->objectid = $myProduct->id;
                                    if(!$mySlug->addData())
                                    {
                                        $error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

                                        //reset slug of current item
                                        $myProduct->slug = $formData['fslugcurrent'];
                                        $myProduct->updateData();
                                    }
                                    else
                                    {
                                        //Add new slug ok, keep old slug but change the link to keep the reference to new ref
                                        Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'product', $myPage->id);
                                    }
                                }
                                //end Slug process
                                ////////////////////////////////
                            }

                            $formData['fisbagdehot'] = $myProduct->isbagdehot;
                            $formData['fisbagdenew'] = $myProduct->isbagdenew;
                            $formData['fisbagdegift'] = $myProduct->isbagdegift;
                            $formData['fimage'] = ($myProduct->image != '') ? $myProduct->getSmallImage() : '';

                            $formData['fsummarynew'] = explode('#' , $myProduct->summarynew);

                            if(isset($formData['fattributeloadajaxsuccess']) && $formData['fattributeloadajaxsuccess'] == 1)
                            {
                                //xoa tat ca cac thuoc tinh cu
                                Core_RelProductAttribute::deleteAttributeByProductId($myProduct->id);
                                $attrList = $_POST['fattr'];
                                if(count($attrList) > 0)
                                {
                                    foreach($attrList as $attr=>$value)
                                    {

                                        $rpa = new Core_RelProductAttribute();
                                        $rpa->pid = (int)$myProduct->id;
                                        $rpa->paid = (int)$attr;
                                        $rpa->value = ($value != -1) ? $value : '';
                                        $rpa->weight = $formData['fweight'][$attr];
                                        $rpa->valueseo =($value != -1) ?  Helper::codau2khongdau($value) : '';
                                        $rpa->description = Helper::xss_clean($formData['fattrdescription'][$attr]);
                                        if($rpa->value != '')
                                        {
                                            if($rpa->addData())
                                            {
                                                $ok = true;
                                            }
                                        }
                                    }


                                }

                                $attrList = $_POST['fattropt'];
                                if(count($attrList) > 0)
                                {
                                    foreach($attrList as $attr=>$value)
                                    {
                                        if(strlen($value) > 0)
                                        {
                                            $rpa = new Core_RelProductAttribute();
                                            $rpa->pid = (int)$myProduct->id;
                                            $rpa->paid = (int)$attr;
                                            $rpa->value = $value;
                                            $rpa->weight = $formData['fweight'][$attr];
                                            $rpa->valueseo = Helper::codau2khongdau($value);
                                            $rpa->description = Helper::xss_clean($formData['fattrdescription'][$attr]);
                                            if($rpa->addData())
                                            {
                                                $ok = true;
                                            }
                                            else
                                            {
                                                break;
                                            }
                                        }
                                    }
                                }
                            }

                            //update lai media
                            if(count($formData['fmediaId']) > 0)
                            {
                                foreach($formData['fmediaId'] as $key=>$value)
                                {
                                    $productMedia = new Core_ProductMedia($value);
                                    if($productMedia->id > 0)
                                    {
                                        $productMedia->caption = $formData['fcaptionmedia'][$value];
                                        $productMedia->alt = $formData['faltmedia'][$value];
                                        $productMedia->titleseo = $formData['ftitleseomedia'][$value];
                                        $productMedia->displayorder = $formData['fdisplaygallery'][$value];
                                        $productMedia->mediaorder = -1;
                                        $productMedia->updateData();
                                    }
                                }
                            }

                            if(count($formData['fmoreurlold']) > 0)
                            {
                                foreach ($formData['fmoreurlold'] as $key => $value)
                                {
                                    $productMedia = new Core_ProductMedia($key);
                                    if($productMedia->id >0)
                                    {
                                        $productMedia->moreurl = $value;
                                        $productMedia->mediaorder = -1;
                                        $productMedia->updateData();
                                    }
                                }
                            }

                            //them moi media
                            foreach($formData['furl'] as $key=>$value)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->moreurl = $value;
                                $productMedia->caption = $formData['fcaption'][$key];
                                $productMedia->alt = $formData['falt'][$key];
                                $productMedia->titleseo = $formData['ftitleseo'][$key];
                                $productMedia->mediaorder = -1;
                                $productMedia->type = Core_ProductMedia::TYPE_URL;
                                if(strlen($value) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            for($key = 0 ; $key < count($_FILES['ffile']['size']); $key++)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                if(strrpos($formData['fimageurl'][$key], '?'))
                                {
                                    $formData['fimageurl'][$key] = substr($formData['fimageurl'][$key], 0, strrpos($formData['fimageurl'][$key], '?'));
                                }
                                $productMedia->caption = Helper::codau2khongdau($formData['fname'],true,true) . $key;
                                $productMedia->alt = Helper::codau2khongdau($formData['fname'],true,true) . $key;
                                $productMedia->titleseo = Helper::codau2khongdau($formData['fname'],true,true);
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_FILE;
                                if($productMedia->moreurl != '' || strlen($_FILES['ffile']['name'][$productMedia->mediaorder]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }


                            /*if(isset($_FILES['ffile']))
                            {
                                //unset($_FILES['ffile']);
                                $_FILES['ffile'] = $_FILES['ffile360'];
                            }*/
                            unset($_FILES['ffile']);
                            $_FILES['ffile'] = $_FILES['ffile360'];

                            //them hinh 360
                            for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->caption = Helper::codau2khongdau($formData['fname'] , true, true) . '-360-'. $key;
                                $productMedia->alt = Helper::codau2khongdau($formData['fname'] , true, true) . '-360-'. $key;
                                $productMedia->titleseo = Helper::codau2khongdau($formData['fname'] , true, true) . '-360-'. $key;
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_360;
                                if(strlen($_FILES['ffile']['name'][$key]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            unset($_FILES['ffile']);
                            $_FILES['ffile'] = $_FILES['ftypespecialimg'];

                            if(isset($formData['ftypespecial']))
                            {
                               //them hinh thong so ky thuat
                                $productMedia = new Core_ProductMedia($formData['ftypespecial']);
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->caption = $formData['ftypespecialcaption'];
                                $productMedia->alt = $formData['ftypespecialalt'];
                                $productMedia->titleseo = $formData['ftypespecialtitle'];
                                $productMedia->type = Core_ProductMedia::TYPE_SPECIALTYPE;
                                $productMedia->mediaorder = 0;
                                if(strlen($_FILES['ffile']['name'][0]) > 0)
                                {
                                    if($productMedia->updateData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }
                            else
                            {
                                //them hinh thong so ky thuat
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->caption = $formData['ftypespecialcaption'];
                                $productMedia->alt = $formData['ftypespecialalt'];
                                $productMedia->titleseo = $formData['ftypespecialtitle'];
                                $productMedia->type = Core_ProductMedia::TYPE_SPECIALTYPE;
                                $productMedia->mediaorder = 0;
                                if(strlen($_FILES['ffile']['name'][0]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            //update display order of accessories
                            if(count($formData['faccessoriesdisplayorder']) > 0)
                            {
                                foreach($formData['faccessoriesdisplayorder'] as $key=>$value)
                                {
                                    $relproductproduct = new Core_RelProductProduct($key);
                                    if($relproductproduct->id > 0)
                                    {
                                        $relproductproduct->displayorder = $value;
                                        if($relproductproduct->updateData())
                                        {
                                            $ok = true;
                                        }
                                    }
                                }
                            }

                            //update display order of product2
                            if(count($formData['fproduct2displayorder']) > 0)
                            {
                                foreach($formData['fproduct2displayorder'] as $key=>$value)
                                {
                                    $relproductproduct = new Core_RelProductProduct($key);
                                    if($relproductproduct->id > 0)
                                    {
                                        $relproductproduct->displayorder = $value;
                                        if($relproductproduct->updateData())
                                        {
                                            $ok = true;
                                        }
                                    }
                                }
                            }

                            //update display order of product3
                            if(count($formData['fproduct3displayorder']) > 0)
                            {
                                foreach($formData['fproduct3displayorder'] as $key=>$value)
                                {
                                    $relproductproduct = new Core_RelProductProduct($key);
                                    if($relproductproduct->id > 0)
                                    {
                                        $relproductproduct->displayorder = $value;
                                        if($relproductproduct->updateData())
                                        {
                                            $ok = true;
                                        }
                                    }
                                }
                            }

                            //update display order of product 4
                            if(count($formData['fproduct4displayorder']) > 0)
                            {
                                foreach($formData['fproduct4displayorder'] as $key=>$value)
                                {
                                    $relproductproduct = new Core_RelProductProduct($key);
                                    if($relproductproduct->id > 0)
                                    {
                                        $relproductproduct->displayorder = $value;
                                        if($relproductproduct->updateData())
                                        {
                                            $ok = true;
                                        }
                                    }
                                }
                            }

                            //update display order of accessories
                            if(count($formData['fsampledisplayorder']) > 0)
                            {
                                foreach($formData['fsampledisplayorder'] as $key=>$value)
                                {
                                    $relproductproduct = new Core_RelProductProduct($key);
                                    if($relproductproduct->id > 0)
                                    {
                                        $relproductproduct->displayorder = $value;
                                        if($relproductproduct->updateData())
                                        {
                                            $ok = true;
                                        }
                                    }
                                }
                            }

                            //add product 's accessories
                            if(count($formData['accessories']) >0)
                            {
                                foreach($formData['accessories'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_ACCESSORIES;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            if(count($formData['sample']) > 0)
                            {
                                foreach($formData['sample'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_SAMPLE;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            //add new rel product 2
                            if(count($formData['product2']) > 0)
                            {
                                foreach($formData['product2'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_PRODUCT2;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            //add new rel product 3
                            if(count($formData['product3']) > 0)
                            {
                                foreach($formData['product3'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $myProduct->id;
                                    $relProduct->piddestination = $rp;
                                    $relProduct->type = Core_RelProductProduct::TYPE_PRODUCT3;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            //add new rel product 4
                            if(count($formData['product4']) > 0)
                            {
                                foreach($formData['product4'] as $key=>$rp)
                                {
                                    $relProduct = new Core_RelProductProduct();
                                    $relProduct->pidsource = $rp;
                                    $relProduct->piddestination = $myProduct->id;
                                    $relProduct->type = Core_RelProductProduct::TYPE_ACCESSORIES;
                                    if($relProduct->addData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            unset($_FILES['fimage']);
                            //add new banner horizontal
                            if(strlen($_FILES['fhorizonbanner']['name']) > 0)
                            {
                                $_FILES['fimage'] = $_FILES['fhorizonbanner'];
                                $myAds = new Core_Ads();
                                $myAds->azid = Core_Ads::PRODUCT_LINK_HORIZOTAL;
                                $myAds->campaign = $formData['fid'];
                                $myAds->status = Core_Ads::STATUS_ENABLE;
                                $myAds->datebegin = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerstartdate']))));
                                $myAds->dateend = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerendate']))));
                                if($myAds->addData() > 0)
                                {
                                    $ok = true;
                                }
                            }

                             //add new banner vertical
                            if(strlen($_FILES['fverticalbanner']['name']) > 0)
                            {
                                $_FILES['fimage'] = $_FILES['fverticalbanner'];
                                $myAds = new Core_Ads();
                                $myAds->azid = Core_Ads::PRODUCT_LINK_VERTICAL;
                                $myAds->campaign = $formData['fid'];
                                $myAds->status = Core_Ads::STATUS_ENABLE;
                                $myAds->datebegin = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerstartdate']))));
                                $myAds->dateend = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerendate']))));
                                if($myAds->addData() > 0)
                                {
                                    $ok = true;
                                }
                            }

                            //cap nhat thoi gian hien thi cua banner san pham
                            if(count($formData['fhbanner']) > 0)
                            {
                                foreach ($formData['fhbanner'] as $adsid)
                                {
                                    $myAds = new Core_Ads($adsid);
                                    $myAds->datebegin = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerstartdate']))));
                                    $myAds->dateend = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerendate']))));
                                    if($myAds->updateData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            if(count($formData['fvbanner']) > 0)
                            {
                                foreach ($formData['fvbanner'] as $adsid)
                                {
                                    $myAds = new Core_Ads($adsid);
                                    $myAds->datebegin = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerstartdate']))));
                                    $myAds->dateend = strtotime(implode('-', array_reverse(explode('/', $formData['fbannerendate']))));
                                    if($myAds->updateData())
                                    {
                                        $ok = true;
                                    }
                                }
                            }

                            $from = '';

                            if($ok)
                            {
                                $success[] = $this->registry->lang['controller']['succUpdate'];
                                $this->registry->me->writelog('product_edit', $myProduct->id, array());

                                //comment lai de test
                                $urlcron = $this->registry->conf['rooturl']."task/externalimagedownload/imageproductdownloadbyid?id=".$myProduct->id;
                                //Run scon
                                Helper::backgroundHttpGet($urlcron);

                                ///////////////////////////////////////////////
                                //call background task to send notification
                                $taskUrl = $this->registry->conf['rooturl']."task/productchangenotify?uid=".$this->registry->me->id."&id=".$myProduct->id . '&from=edit&editsection=';
                                Helper::backgroundHttpGet($taskUrl);
                            }
                            else
                            {
                                $error[] = $this->registry->lang['controller']['errUpdate'];
                            }

                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }

               // }
//                else $error[] = 'Token không trùng khớp';

            }


            //get all accessories product
            $accessories = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$myProduct->id , 'ftype' => Core_RelProductProduct::TYPE_ACCESSORIES),'id','ASC');

            $accessoriesList = array();
            foreach($accessories as $obj)
            {
                $product = new Core_Product($obj->piddestination);
                $product->sellprice = Helper::formatPrice($product->sellprice);
                $product->categoryactor = new Core_Productcategory($product->pcid);
                $product->rppdisplayorder = $obj->displayorder;
                $accessoriesList[$obj->id] = $product;
            }

            //get all sample product
            $samples = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$myProduct->id , 'ftype' => Core_RelProductProduct::TYPE_SAMPLE),'id','ASC');
            $sampleList = array();
            foreach($samples as $obj)
            {
                $product = new Core_Product($obj->piddestination);
                $product->sellprice = Helper::formatPrice($product->sellprice);
                $product->categoryactor = new Core_Productcategory($product->pcid);
                $product->rppdisplayorder = $obj->displayorder;
                $sampleList[$obj->id] = $product;
            }

            //get all product2
            $product2s = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$myProduct->id , 'ftype' => Core_RelProductProduct::TYPE_PRODUCT2),'id','ASC');

            $product2List = array();
            foreach($product2s as $obj)
            {
                $product = new Core_Product($obj->piddestination);
                $product->sellprice = Helper::formatPrice($product->sellprice);
                $product->rppdisplayorder = $obj->displayorder;
                $product->categoryactor = new Core_Productcategory($product->pcid);
                $product->datecreated = $obj->datecreated;
                $product->enddate = $obj->datecreated + 30 * 24 * 3600;
                $product2List[$obj->id] = $product;
            }

            //get all product3
            $product3s = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$myProduct->id , 'ftype' => Core_RelProductProduct::TYPE_PRODUCT3),'id','ASC');

            $product3List = array();
            foreach($product3s as $obj)
            {
                $product = new Core_Product($obj->piddestination);
                $product->sellprice = Helper::formatPrice($product->sellprice);
                $product->rppdisplayorder = $obj->displayorder;
                $product->datecreated = $obj->datecreated;
                $product->categoryactor = new Core_Productcategory($product->pcid);
                $product->enddate = $obj->datecreated + 30 * 24 * 3600;
                $product3List[$obj->id] = $product;
            }

            //get all product4
            $product4s = Core_RelProductProduct::getRelProductProducts(array('fpiddestination'=>$myProduct->id , 'ftype' => Core_RelProductProduct::TYPE_ACCESSORIES),'id','ASC');

            $product4List = array();
            foreach($product4s as $obj)
            {
                $product = new Core_Product($obj->pidsource);
                $product->sellprice = Helper::formatPrice($product->sellprice);
                $product->rppdisplayorder = $obj->displayorder;
                $product->categoryactor = new Core_Productcategory($product->pcid);
                $product4List[$obj->id] = $product;
            }

            //get product color
            $colorlistdata = explode('###',$myProduct->colorlist);

            if(count($colorlistdata) > 0)
            {
                $i = 0;
                foreach ($colorlistdata as $colordata)
                {
                    $listdata = explode(':', $colordata);

                    if (!empty($listdata[2]) && !empty($listdata[3])) {
                        if($i == 0) //màu của sản phẩm chính
                        {
                            if(trim($listdata[3]) == 'kxd')
                            {
                                $formData['fpchoosecolor'] = 'kxd';
                            }
                            else
                            {
                                $formData['fpchoosecolor'] = -1;
                                $formData['fpcolorname'] = $listdata[2];
                                $formData['fpcolorstring'] = $listdata[3];
                            }
                            $formData['fcolorList'][$listdata[0]] = array('id' => $listdata[0] , 'name' => $listdata[1] , 'colorname' => $listdata[2] , 'colorcode' => $listdata[3] , 'default' => $listdata[4]);
                        }
                        else
                        {
                            $productColor = new Core_Product($listdata[0] , true);
                            if($productColor->id > 0) {
                                $formData['fcolorList'][$listdata[0]] = array('id' => $listdata[0] , 'name' => $listdata[1] , 'colorname' => $listdata[2] , 'colorcode' => $listdata[3] , 'default' => $listdata[4]);
                            }
                        }

                    }

                    $i++;
                }
            }

            $colorlistdata = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $myProduct->id , 'ftype'=>Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC');
            if(count($colorlistdata) > 0)
            {
                foreach ($colorlistdata as $colordata) {
                    if (!array_key_exists($colordata->piddestination, $formData['fcolorList'])) {
                        if (preg_match('/[a-zA-Z0-9 ]+:[a-zA-Z0-9]+/' , $colordata->typevalue , $out) > 0) {
                            $colorinfo = explode(':' , $colordata->typevalue);
                            $productColor = new Core_Product($colordata->piddestination , true);
                            if (!empty($colorinfo[0])  && !empty($colorinfo[1]) && $productColor->id > 0) {
                                $formData['fcolorList'][$colordata->piddestination] = array('id' => $colordata->piddestination ,
                                                                                        'name' => $myProduct->name,
                                                                                        'colorname' => $colorinfo[0],
                                                                                        'colorcode' => $colorinfo[1],
                                                                                        'default' => 0,
                                                                                        );
                            }
                        }

                    }
                }
            }

            if (count($formData['fcolorList']) > 0) {
                $colorinfoList = array();
                foreach ($formData['fcolorList'] as $colordata) {
                    $colorinfoList[] = implode(':' , $colordata);
                }

                $colorstring = implode('###' , $colorinfoList);

                $myProduct->colorlist = $colorstring;
                $myProduct->updateproductcolor();
            }

            if($from == 'clone')
            {
                $success[] = $this->registry->lang['controller']['succClone'];
                $this->registry->me->writelog('product_clone', $myProduct->id, array());
            }

            ###################################################
            /*if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
            {
                $roleusers = Core_RoleUser::getRoleUsers(array('fuid'=> $this->registry->me->id), 'id' , 'ASC', '', false, true);
                $cond = array();
                foreach($roleusers as $roleuser)
                {
                    if($roleuser->subobjectid > 0)
                    {
                        $cond[] = $roleuser->subobjectid;
                    }
                }
            }

            $roleusers = Core_RoleUser::getRoleUsers(array('fuid'=> $this->registry->me->id , 'fstatus' => Core_RoleUser::STATUS_ENABLE), 'id' , 'ASC', '', false, true);
            $cond = array();
            foreach($roleusers as $roleuser)
            {
                if($roleuser->subobjectid > 0)
                {
                    $cond[] = $roleuser->subobjectid;
                }
            }*/

            $vendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_VENDOR, 'fidarr' => $cond), 'name', 'ASC');
            $subVendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_SUBVENDOR), 'name', 'ASC');
            //lay danh muc cha day du cua danh muc san pham hien tai
            $category->parent = Core_Productcategory::getFullParentProductCategorys($category->id);

            //get product media list
            $productmediaList = Core_ProductMedia::getProductMedias(array('fpid'=> $formData['fid']), 'displayorder', 'ASC');

            //get special banner for product
            $horizonalbanners = Core_Ads::getBannerListByProuctId($formData['fid'] , 'h');
            $verticalbanners = Core_Ads::getBannerListByProuctId($formData['fid'] , 'v');
            if(count($horizonalbanners) > 0)
            {
                $formData['fbannerstartdate'] = $horizonalbanners[0]->datebegin;
                $formData['fbannerendate'] = $horizonalbanners[0]->dateend;
            }
            elseif (count($verticalbanners) > 0)
            {
                $formData['fbannerstartdate'] = $verticalbanners[0]->datebegin;
                $formData['fbannerendate'] = $verticalbanners[0]->dateend;
            }
            else
            {
                $formData['fbannerstartdate'] = time();
                $formData['fbannerendate'] = time() + 3*24*3600;
            }

            //get apply promotion list
            $applypromotionlist = array();
            if($formData['fapplypromotionlist'] != '')
            {
                if($formData['fapplypromotionlist'] == '0')
                {

                }
                else
                {
                    $datalist = explode(',', $formData['fapplypromotionlist']);
                    foreach ($datalist as $data)
                    {
                        $data = explode('###', $data);
                        $applypromotionlist[$data[0]] = $data[1];
                    }
                }
            }

            $productcategoryList = array();
            $parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
            for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
            {
                if($parentCategory1[$i]->parentid == 0)
                {
                    $productcategoryList[] = $parentCategory1[$i];
                    $parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                    for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
                    {
                        $parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                        $productcategoryList[] = $parentCategory2[$j];

                        $subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                        foreach ($subCategory as $sub)
                        {
                            $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                            $productcategoryList[] = $sub;
                        }
                    }
                }
            }

            $formData['ftab'] = isset($formData['ftab']) ? $formData['ftab'] : 1;

            //check product can change to product color
            $ischangeproductcolor = true;

            $colorlist = explode('###' , $myProduct->colorlist);
            if(count($colorlist) > 1 || $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_COLOR)
            {
                $ischangeproductcolor = false;
            }

            /** recommendation */

            // f2
            $myCacher = new Cacher('rp1:'.$id,Cacher::STORAGE_REDIS);
            $arr = $myCacher->get();
            if($arr)
                $arr      = explode(',',$arr);
            if(!empty($arr))
            {
                $arrRecommend =array();
                $arr =  $this->sortrecommend($arr,$id);
                if(empty($sampleList))
                {
                    $formData['recommendSample'] = $this->getSample($arr);
                    foreach ( $formData['recommendSample'] as $k => $v ) {
                        $arrRecommend[] = $v->id;
                    }
                }
                $formData['recommendationf2'] = $this->searchProductAjaxAction($arr,'recommendation' , $id , 'sample',$arrRecommend);
                $formData['access']           = $this->searchProductAjaxAction($arr, 'recommendation', $id, 'accessories', $arrRecommend);
            }
            else
                $formData['recommendationf2'] = 'Chưa có recommend SP mua cùng cho SP này';
            //f3
            $myCacher = new Cacher('rp3:'.$id,Cacher::STORAGE_REDIS);
            $arr = $myCacher->get();
            if($arr)
                $arr      = explode(',',$arr);
            if(!empty($arr))
            {

                $formData['recommendationf3'] = $this->searchProductAjaxAction($arr,'recommendation' , $id , 'sample');
            }
            else
                $formData['recommendationf3'] = 'Chưa có recommend SP tương tự cho SP này';


            /** end recommendation*/

            //$_SESSION['productEditToken'] = Helper::getSecurityToken();//Tao token moi

            ///// GET PRODUCT COLOR
            $productcolors = Core_Productcolor::getProductcolors(array('fstatus' => Core_Productcolor::STATUS_ENABLE) , 'id' , 'ASC');

            $this->registry->smarty->assign(array(    'formData'     => $formData,
                                                    'redirectUrl'=> $redirectUrl,
                                                    'error'        => $error,
                                                    'success'    => $success,
                                                    'vendorList'  => $vendorList,
                                                    'subVendorList' => $subVendorList,
                                                    'statusList' => Core_Product::getStatusList(),
                                                    //'productAttributeList' => $productAttributeList,
                                                    'productmediaList'    => $productmediaList,
                                                    'productcategoryList' => $productcategoryList,
                                                    'mediaList'        => Core_ProductMedia::getMediaType(),
                                                    'accessoriesList' => $accessoriesList,
                                                    'sampleList' => $sampleList,
                                                    'relProductColor' => $relProductColor,
                                                    'product2List' => $product2List,
                                                    'product3List' => $product3List,
                                                    'product4List' => $product4List,
                                                    'slugList'    => $slugList,
                                                    'onsitestatusList' => Core_Product::getonsitestatusList(),
                                                    'category' => $category,
                                                    'displaytypeList' => Core_Product::getDisplayTypeList(),
                                                    'horizonalbanners' => $horizonalbanners,
                                                    'verticalbanners' => $verticalbanners,
                                                    'applypromotionlist' => $applypromotionlist,
                                                    'transporttypeList' => Core_Product::getTranspostTypeList(),
                                                    'setuptypeList' => Core_Product::getSetupTypeList(),
                                                    'businessstatusList' => Core_Product::getbusinessstatusList(),
                                                    'ischangeproductcolor' => $ischangeproductcolor,
                                                    'productcolors' => $productcolors,
                                                ));
            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
            $this->registry->smarty->assign(array(
                                                    'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProduct->name,
                                                    'contents'             => $contents));
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

    private function getSample($arr)
    {
        $rs = array();
        foreach ( $arr as $key => $value ) {
            $product = new Core_Product($value);
            if(!empty($product) && $product->instock>0)
            {
                $product->image           = $product->getSmallImage();
                $cate                     = new Core_Productcategory($product->pcid);
                $product->productCategory = $cate->name;
                $product->sellprice       = Helper::formatPrice($product->sellprice);
                $rs[]                     = $product;
            }
            if(count($rs)==4)
                return $rs;

        }
        return $rs;
    }

    private function sortrecommend($arr,$id)
    {
        $p1 = new Core_Product($id);
        $count = count($arr);
        $rs1 = array();
        $rs2 = array();
        for($i = 0 ; $i < $count ; $i++ )
        {
            $p2 = new Core_Product($arr[$i]);
            if($p2->pcid == $p1->pcid)
                $rs1[] = $p2->id;
            else
                $rs2[] = $p2->id;

        }
        return array_merge($rs2,$rs1);
    }

    public function cloneAction()
    {
        $redirectUrl = $this->registry->router->getArg('redirect');
        $id = (int)$this->registry->router->getArg('id');

        $product = new Core_Product($id);
        if($product->id > 0)
        {
            //check role of user
            $checker = false;
            if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
            {
                //check role of user
                $checker = false;
                if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
                {
                    //get full parentcategory from cache
                    $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($product->pcid);

                    //create suffix
                    $suffix = 'pedit_' . $parentcategorylist[0];
                    $checker = $this->checkAccessTicket($suffix);
                }
                else
                {
                    $checker = true;
                }
            }
            else
            {
                $checker = true;
            }

            ########################
            if($checker)
            {
                $cloneProduct                  = new Core_Product();
                $cloneProduct->uid             = $this->registry->me->id;
                $cloneProduct->vid             = $product->vid;
                $cloneProduct->pcid            = $product->pcid;
                $cloneProduct->name            = $product->name;
                $cloneProduct->slug            = '';
                $cloneProduct->content         = $product->content;
                $cloneProduct->summary         = $product->summary;
                $cloneProduct->good            = $product->good;
                $cloneProduct->bad             = $product->bad;
                $cloneProduct->seotitle        = $product->seotitle;
                $cloneProduct->seokeyword      = $product->seokeyword;
                $cloneProduct->seodescription  = $product->seodescription;
                $cloneProduct->instock         = 0;
                $cloneProduct->status          = $product->status;
                $cloneProduct->onsitestatus    = Core_Product::OS_NOSELL;
                $cloneProduct->customizetype   = $product->customizetype;

                if($cloneProduct->addData() > 0)
                {
                    //clone product attribute
                    $relproductattributeList = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $product->id), 'id', 'ASC');
                    if(count($relproductattributeList) > 0)
                    {
                        $ok = false;
                        foreach($relproductattributeList as $relproductattribute)
                        {
                            $rpa = new Core_RelProductAttribute();
                            $rpa->pid = $cloneProduct->id;
                            $rpa->paid = $relproductattribute->paid;
                            $rpa->value = $relproductattribute->value;
                            if($rpa->addData() > 0)
                            {
                                $ok = true;


                            }
                        }
                    }

                    if($ok)
                    {
                        ///////////////////////////////////////////////
                        //call background task to send notification
                        $taskUrl = $this->registry->conf['rooturl']."task/productchangenotify?uid=".$this->registry->me->id."&id=".$cloneProduct->id . '&from=add&editsection=clone';
                        Helper::backgroundHttpGet($taskUrl);


                        //echodebug($this->registry['conf']['rooturl_cms'] . 'product/edit/from/clone/id/' . $cloneProduct->id . '/redirect/' . $redirectUrl,true);
                        header('location: ' . $this->registry['conf']['rooturl_cms'] . 'product/edit/from/clone/id/' . $cloneProduct->id . '/redirect/' . $redirectUrl);

                    }
                    else
                    {
                        header('location: ' . $this->registry['conf']['rooturl_cms'].'product/index/permission/clone');
                        exit();
                    }
                    //header('location: ' . $this->registry['conf']['rooturl_cms'] . 'product/edit/from/clone/id/' . $cloneProduct->id . '/redirect/' . $redirectUrl);
                }
            }
            else
            {
                header('location: ' . $this->registry['conf']['rooturl_cms'].'product/index/permission/clone');
                exit();
            }

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
        $myProduct = new Core_Product($id);
        if($myProduct->id > 0)
        {
            //check role of delete product
            $checker = false;
            if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
            {
                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($myProduct->pcid);

                //create suffix
                $suffix = 'pdelete_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);
            }
            else
            {
                $checker = true;
            }

            ###################################

            if($checker)
            {
                //tien hanh xoa
                /*if($myProduct->delete())
                {
                    $redirectMsg = str_replace('###id###', $myProduct->id, $this->registry->lang['controller']['succDelete']);

                    $this->registry->me->writelog('product_delete', $myProduct->id, array());
                }
                else
                {
                    $redirectMsg = str_replace('###id###', $myProduct->id, $this->registry->lang['controller']['errDelete']);
                }*/

                //update lai status
                $myProduct->status = Core_Product::STATUS_DELETED;
                $myProduct->datedeleted = time();
                if($myProduct->updateData())
                {
                    $redirectMsg = str_replace('###id###', $myProduct->id, $this->registry->lang['controller']['succDelete']);

                    $this->registry->me->writelog('product_delete', $myProduct->id, array());

                    //xoa slug lien quan den item nay
                    Core_Slug::deleteSlug($myProduct->slug, 'product', $myProduct->id);
                }
                else
                {
                    $redirectMsg = str_replace('###id###', $myProduct->id, $this->registry->lang['controller']['errDelete']);
                }

            }
            else
            {
                header('location: ' . $this->registry['conf']['rooturl_cms'].'product/index/permission/delete');
                exit();
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

    public function indexAjaxAction()
    {
        $pcat = (int)$_POST['fpcid'];
        $outputList = Core_Productcategory::getProductcategorys(array('fparentid' => $pcat),'', '');
        $result = '';
        foreach($outputList as $category)
        {
            $result .= '<option value="'.$category->id.'">'.$category->name.'</option>';
        }
        echo $result;
    }

    public function getAttributeAjaxAction()
    {
        $html = '';
        $pcid = (int)$_POST['fpcid'];
        $pid  = (int)$_POST['fpid'];
        $groupAttributeList = array();
        //kiem tra group attribute va attribute
        if($pcid > 0)
        {
            $productGroupAttribute = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$pcid),'displayorder','ASC');
            $category = new Core_Productcategory($pcid , true);
            if(count($productGroupAttribute) == 0)
            {
                //kiem tra xem category cha co group attribute hay khong
                if($category->parentid > 0)
                {
                    $productGroupAttributeParent =    Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$category->parentid),'displayorder','ASC');
                    if(count($productGroupAttributeParent) > 0)
                    {
                        $groupAttributeList = $productGroupAttributeParent;
                        $pcid = $category->parentid;
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAttributeGroup'];
                        $formData['fpcid'] = 0;
                    }
                }
                else
                {
                    $error[] = $this->registry->lang['controller']['errAttributeGroup'];
                }
            }
            else
            {
                $groupAttributeList = $productGroupAttribute;
            }
        }


        $productAttributeList = array();
        //lay tat cac ca thuoc tinh trong moi group attribute
        for($i = 0 ; $i < count($groupAttributeList) ; $i++)
        {
            $attributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$pcid,'fpgaid'=>$groupAttributeList[$i]->id),'displayorder','ASC');
            $attributeList = array();
            foreach($attributes as $attr)
            {
                $relproductattribute = Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$pid, 'fpaid'=> $attr->id),'displayorder','ASC');
                $attr->value = $relproductattribute[0]->value;
                $attributeList[] = $attr;
            }
            $productAttributeList[$groupAttributeList[$i]->name] = $attributeList;
        }

        if(count($productAttributeList) > 0)
        {
            $html .= '<table class="table">';
            foreach($productAttributeList as $group=>$attrList)
            {
                $checker = true;
                if(count($attrList) > 0)
                {
                    foreach($attrList as $attr)
                    {
                        $html .= '<tr>';
                        if($checker)
                        {
                            $html .= '<td><b>'.$group.'</b></td>';
                            $checker = false;
                        }
                        else
                        {
                            $html .= '<td></td>';
                        }

                        $html .= '<td>'.$attr->name.'</td>
                            <td><input type="text" name="fattr['.$attr->id.']" value="'.$attr->value.'"></td>
                            <td style="width:250px;"></td>';
                    }
                }
                else
                {
                    $html .= '<tr>
                            <td><b>'.$group.'</b></td>
                            <td></td>
                            <td></td>
                            <td style="width:250px;"></td>
                        <tr/>';
                }
            }
            $html .= '</table>';
        }

        echo $html;
    }

    public function deleteMediaAjaxAction()
    {
        $result = '';
        $mid = (int)$_POST['id'];
        $productmedia = new Core_ProductMedia($mid);
        if($productmedia->delete() > 0)
        {
            $result .= 'success';
        }

        echo $result;
    }

    public function searchProductAjaxAction($arr = array() , $actionname = '' ,$reid = '' , $retype = '' , $arrRecommend = array())
    {
        $result = '';

        $pname  = $actionname == '' ? (string)$_POST['pname'] : $actionname;
        $type   = $retype == ''   ?  (string)$_POST['type'] : $retype;
        $id     = $reid == ''   ?  (int)$_POST['pid']: $reid;
        $typeId = Core_RelProductProduct::getType($retype == ''  ?  $type : $retype);
        //lay tat cac san pham lien quan den pid
        if($id > 0)
        {
            $relproduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=>$id, 'ftype'=>$typeId),'id','ASC');
            $des = array();
            foreach($relproduct as $relObj)
            {
                $des[] = $relObj->piddestination;
            }
        }

        if($pname != '')
        {
            $productList = array();
            /** recommendation */
            $style='';
            if($pname=='recommendation')
            {
                $style = 'style="width:20%"';
                foreach ( $arr as $key => $value ) {
                    $myProduct   =  new Core_Product($value);
                    if(!empty($myProduct) )
                        $productList[] =  $myProduct;

                }

            }
            else
                $productList = Core_Product::getProducts(array('fgeneralkeyword'=>$pname) , 'id' , 'ASC');


            if(count($productList) > 0)
            {
                $result .= '<table class="table"><thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Barcode</th>
                        <th>Danh mục</th>
                        <th> Tên sản phẩm</th>
                        <th> Số lượng</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead>';
                $i =0;
                foreach($productList as $product)
                {

                    if($id != $product->id)
                    {
                        if(count($des) > 0)
                        {
                            if(!in_array($product->id , $des))
                            {

                                $product->categoryactor = new Core_Productcategory($product->pcid);
                                $result .= '<tr id="rows'.$type.'_'.$product->id.'">';
                                $result .= '<td>';
                                if($product->image != '')
                                {

                                    $result .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image '.$style .' id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="100px;" height="100px;" /></a>';
                                }
                                $result .= '</td>';
                                $result .= '<td id="pid">'.$product->id.'</td>';
                                $result .= '<td id="barcode">'.$product->barcode.'</td>';
                                $result .= '<td id="categorys_'.$product->id.'"><span class="label label-info">'.$product->categoryactor->name.'</span></td>';
                                $result .= '<td id="names_'.$product->id.'">'.$product->name.'</td>';
                                $result .= '<td id="instocks_'.$product->id.'">'.$product->instock.'</td>';
                                $result .= '<td id="prices_'.$product->id.'">'.Helper::formatPrice($product->sellprice).  ' '  . $this->registry->lang['controller']['labelCurrency'] . '</td>';
                                $result .= '<td><input class="btn btn-success" type="button" id="fchoose_'.$product->id.'" onclick="chooseFunction('.$product->id.',\''.$type.'\')" value="Choose" /></td>';
                                $result .= '</tr>';
                            }
                        }
                        else
                        {
                            $display ='';
                            if(in_array($product->id,$arrRecommend))
                                $display = 'style=\'display:none\'';
                            $product->categoryactor = new Core_Productcategory($product->pcid);
                            $result .= '<tr id="rows'.$type.'_'.$product->id.'" '.$display .'>';
                            $result .= '<td>';
                            if($product->image != '')
                            {
                                $result .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image '.$style.' id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="100px;" height="100px;" /></a>';
                            }
                            $result .= '</td>';
                            $result .= '<td id="pid">'.$product->id.'</td>';
                            $result .= '<td id="barcode">'.$product->barcode.'</td>';
                            $result .= '<td id="categorys_'.$product->id.'"><span class="label label-info">'.$product->categoryactor->name.'</span></td>';
                            $result .= '<td id="names_'.$product->id.'">'.$product->name.'</td>';
                            $result .= '<td id="instocks_'.$product->id.'">'.$product->instock.'</td>';
                            $result .= '<td id="prices_'.$product->id.'">'.Helper::formatPrice($product->sellprice) . ' ' . $this->registry->lang['controller']['labelCurrency'] . '</td>';

                            $result .= '<td><input class="btn btn-success" type="button" id="fchoose_'.$product->id.'" onclick="chooseFunction('.$product->id.',\''.$type.'\')" value="Choose" /></td>';
                            $result .= '</tr>';
                        }
                    }

                    $i++;
                }
                $result .= '</table><br/>';

                //$result .= '<h1>Product Choose</h1><table class="table" id="choose'.$type.'"><tbody></tbody></table>';
            }
        }
        if($pname!='recommendation')
            echo $result;
        else
            return $result;

    }

    public function deleteRelProductAjaxAction()
    {
        $result = '';
        $id = (int)$_POST['id'];
        if($id > 0)
        {
            $relproduct = new Core_RelProductProduct($id);
            if($relproduct->delete())
            {
                $result = 'success';
            }
        }

        echo $result;
    }

    public function addProductColorAction()
    {
        set_time_limit(0);
        $formData = array();
        $success = array();
        $warning = array();
        $error = array();

        $pid = (int)$this->registry->router->getArg('pid');
        $pcid = (int)$this->registry->router->getArg('pcid');
        $tab = (int)$this->registry->router->getArg('tab');

        if($pid > 0)
        {
            $formData['fpid'] = $pid;
        }

        $formData['fpid'] = $pid;
        $formData['fpcid'] = $pcid;
        $formData['ftab'] = $tab;

        if(isset($_POST['fsubmit']))
        {
            $formData = array_merge($formData, $_POST);
            if($this->addProductColorValidator($formData, $error))
            {
                $ok = false;
                $have = false;
                $myProduct = new Core_Product($formData['fpid']);
                 /////////////////////cap nhat color list cua san pham chinh
                //kiem tra trung mau cua san pham
                $colorlistdata = explode('###', $myProduct->colorlist );
                foreach ($colorlistdata as $colordata)
                {
                    $listdata = explode(':', $colordata);
                    if(trim($listdata[3]) == trim(substr($formData['fpcolor'], 1)))
                    {
                        $error[] = 'Sản phẩm đã tồn tại màu này xin vui lòng chọn màu khác.';
                        $have = true;
                        break;
                    }
                }

                if(!$have)
                {
                    //tao ra custom san pham
                    $productCus = new Core_Product();
                    $productCus->customizetype = Core_Product::CUSTOMIZETYPE_COLOR;
                    $productCus->barcode = $formData['fbarcode'];
                    $productCus->name = $myProduct->name;
                    $productCus->pcid = $myProduct->pcid;
                    $productCus->isrequestimei = $myProduct->isrequestimei;
                    $productCus->isservice = $myProduct->isservice;
                    $productCus->onsitestatus = Core_Product::OS_ERP;

                    if($productCus->addData() > 0)
                    {
                        $colorlist = '';
                        $colorlist .= $productCus->id . ':' . $productCus->name;
                        if($formData['fpchoosecolor'] == -1)
                        {
                            $colorlist .= ':' . $formData['fpcolorname'] . ':' . substr($formData['fpcolor'], 1);
                        }
                        $colorlist .= ':0';
                        $myProduct->colorlist .= '###' . $colorlist;
                        if($myProduct->updateData())
                            $ok = true;

                        $myRelProductProduct = new Core_RelProductProduct();
                        $myRelProductProduct->pidsource = $formData['fpid'];
                        $myRelProductProduct->piddestination = $productCus->id;
                        $myRelProductProduct->type = Core_RelProductProduct::TYPE_COLOR;
                        $myRelProductProduct->typevalue = $formData['fpcolorname'] . ':' .trim(substr($formData['fpcolor'], 1));
                        if($myRelProductProduct->addData() > 0)
                        {
                            for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
                            {
                                $productMedia = new Core_ProductMedia();
                                $productMedia->pid = $productCus->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->caption = Helper::codau2khongdau($myProduct->name , true, true) . $key;
                                $productMedia->alt = Helper::codau2khongdau($myProduct->name , true, true) . $key;
                                $productMedia->titleseo = Helper::codau2khongdau($myProduct->name , true, true) . $key;
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_FILE;
                                if(strlen($_FILES['ffile']['name'][$key]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }
                                }
                            }
                        }

                    }
                }
                if($ok)
                {
                    $success[] = 'Thêm màu cho gallery thành công . Vui lòng nhấn vào nút Đóng lại để xem kết quả .';
                }
                else
                {
                    $error[] = 'Thêm màu cho gallery không thành công .';
                }
            }
        }

        if($tab > 0)
        {
            $myProduct = new Core_Product($pidsoruce);
        }

        $this->registry->smarty->assign(array(
                                            'formData' => $formData,
                                            'success' => $success,
                                            'error' => $error,
                                            'myProduct' => $myProduct,
                                            ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addColor.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerContainer . 'addColor.tpl');
    }

    public function editProductColorAction()
    {
        set_time_limit(0);
        $formData = array();
        $success = array();
        $warning = array();
        $error = array();

        $pid = (int)$this->registry->router->getArg('pid');
        $values = (int)$this->registry->router->getArg('value');
        $tab = (int)$this->registry->router->getArg('tab');
        $pidsoruce = (int)$this->registry->router->getArg('pidsource');
        $type = (int)$this->registry->router->getArg('type');
        $pcid = (int)$this->registry->router->getArg('pcid');


        $product = new Core_Product($pid);
        if(isset($_POST['fsubmit']))
        {
            $formData = array_merge($formData, $_POST);

            if($this->editProductColorValidator($formData, $error))
            {
                $ok = true;
                //cap nhat barcode
                $product->barcode = (string)$formData['fbarcode'];

                $product->updateData();                

                //cap nhat thu tu hien thi cua media
                if(count($formData['fdisplayordergallery']) > 0)
                {
                    foreach($formData['fdisplayordergallery'] as $pmid => $displayorder)
                    {
                        $myProductMedia = new Core_ProductMedia($pmid);
                        $myProductMedia->displayorder = $displayorder;
                        if($myProductMedia->updateDataWithoutUploadImage())
                            $ok = true;
                    }
                }

                //cap nhat caption cu
                if(count($formData['fcaption']) > 0)
                {
                    foreach($formData['fcaption'] as $pmid => $caption)
                    {
                        $myProductMedia = new Core_ProductMedia($pmid);
                        $myProductMedia->caption = $caption;
                        $myProductMedia->mediaorder = -1;
                        if($myProductMedia->updateDataWithoutUploadImage())
                            $ok = true;
                    }
                }

                //cap nhat alt cu
                if(count($formData['falt']) > 0)
                {
                    foreach($formData['falt'] as $pmid=>$alt)
                    {
                        $myProductMedia = new Core_ProductMedia($pmid);
                        $myProductMedia->alt = $alt;
                        $myProductMedia->mediaorder = -1;
                        if($myProductMedia->updateDataWithoutUploadImage())
                            $ok = true;
                    }
                }

                //cap nhat alt cu
                if(count($formData['ftitleseo']) > 0)
                {
                    foreach($formData['ftitleseo'] as $pmid=>$titleseo)
                    {
                        $myProductMedia = new Core_ProductMedia($pmid);
                        $myProductMedia->titleseo = $titleseo;
                        $myProductMedia->mediaorder = -1;
                        if($myProductMedia->updateDataWithoutUploadImage())
                            $ok = true;
                    }
                }

                $myProduct = new Core_Product($pidsoruce);

                //them product media moi                
                for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
                {
                    $productMedia = new Core_ProductMedia();
                    $productMedia->pid = $pid;
                    $productMedia->uid = $this->registry->me->id;
                    $productMedia->caption = Helper::codau2khongdau($myProduct->name , true, true). $key;
                    $productMedia->alt = Helper::codau2khongdau($myProduct->name , true, true) .  $key;
                    $productMedia->titleseo = Helper::codau2khongdau($myProduct->name , true, true) . $key;
                    $productMedia->mediaorder = $key;
                    $productMedia->type = Core_ProductMedia::TYPE_FILE;
                    if(strlen($_FILES['ffile']['name'][$key]) > 0)
                    {
                        if($productMedia->addData() > 0)
                        {
                            $ok = true;
                        }
                    }

                    unset($productMedia);
                }

                if($ok)
                {
                    $success[] = 'Thêm màu cho gallery thành công . Vui lòng nhấn vào nút Đóng lại để xem kết quả .';
                }
                else
                {
                    $error[] = 'Cập nhật thông tin màu sản phẩm không thành công .';
                }
            }
        }

        $relproducts = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $pidsoruce , 'fpiddestination' => $pid , 'ftype' => Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC');
        $relproduct = $relproducts[0];
        $formData['fpchoosecolor'] = -1;
        $colordatainfo = explode(':', $relproduct->typevalue);
        $formData['fpcolorname'] = $colordatainfo[0];
        $formData['fpcolor'] = '#' . $colordatainfo[1];

        $productColorList = Core_ProductMedia::getProductMedias(array('fpid' => $pid), 'displayorder', 'ASC');
        if($tab > 0)
        {
            $myProduct = new Core_Product($pidsoruce);
        }
        $this->registry->smarty->assign(array(
                                                'formData' => $formData,
                                                'success' => $success,
                                                'error' => $error,
                                                'myProduct' => $myProduct,
                                                'type' => $type,
                                                'product' => $product,
                                                'myProduct' => $myProduct,
                                                'productColorList' => $productColorList
                                                ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'editColor.tpl');

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                'contents'     => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerContainer . 'editColor.tpl');
    }

    public function deleteProductColorAjaxAction()
    {
        $pidsource = (int)$_POST['pidsource'];
        $piddestination = (int)$_POST['piddestination'];
        $colorcode = (string)$_POST['colorcode'];

        $ok = false;
        //xoa product customize
        $customProduct = new Core_Product($piddestination);
        if($customProduct->id > 0)
        {
            //cap nhat lai danh sach mau cua san pham chinh
            $myProduct = new Core_Product($pidsource);
            if($myProduct->id > 0)
            {
                $colorlist = '';
                $colorlistdata = explode('###', $myProduct->colorlist);
                if(count($colorlistdata) > 0)
                {
                    $i = 0;
                    foreach ($colorlistdata as $colordata)
                    {
                        $listdata = explode(':', $colordata);
                        if($listdata[0] != $piddestination)
                        {
                            $colorlist .= $listdata[0] . ':' . $listdata[1] . ':' . $listdata[2] . ':' . trim($listdata[3]) . ':' . $listdata[4];
                            if($i < count($colorlistdata) -2)
                            {
                                $colorlist .= '###';
                            }
                            $i++;
                        }
                    }
                }
                $myProduct->colorlist = $colorlist;
                $myProduct->updateData();
            }

            if($customProduct->delete() > 0)
            {
                //xoa rel product
                $relProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource'=> $pidsource, 'fpiddestination'=> $piddestination), 'id', 'ASC');

                $reProductProduct = $relProduct[0];

                if($reProductProduct->id > 0)
                {
                    if($reProductProduct->delete() > 0)
                    {
                        $ok = true;
                        //xoa product media
                        $productMediaList = Core_ProductMedia::getProductMedias(array('fpid'=> $piddestination), 'id', 'ASC');
                        if(count($productMediaList) > 0)
                        {
                            foreach($productMediaList as $productMedia)
                            {
                                if($productMedia->delete() > 0)
                                    $ok = true;
                            }
                        }
                    }
                    else
                        $ok = false;
                }
            }
            else
                $ok = false;

            if($ok)
                echo 'success';
        }
    }

    public function deletecolorAjaxAction()
    {
        $id = (int)$_POST['id'];
        $productMedia = new Core_ProductMedia($id);
        if($productMedia->id > 0)
        {
            if($productMedia->delete())
            {
                echo 'success';
            }
        }
    }


    public function changecategoryAction()
    {
        set_time_limit(0);
        $formData = array();
        $error = array();
        $success = array();
        $warning = array();
        $pcidsource = (int)$this->registry->router->getArg('pcid');
        $pid = (int)$this->registry->router->getArg('pid');
        $productcategory = new Core_Productcategory($pcidsource);
        $myProduct = new Core_Product($pid);



        $formData['fpid'] = $pid;
        if($productcategory->id > 0)
        {

            if(isset($_POST['fsubmitNext']))
            {
                $formData = array_merge($formData, $_POST);
                $categorydes = new Core_Productcategory($formData['fpciddes']);
                if($categorydes->id > 0)
                {
                    //kiem tra danh muc source va danh muc des
                    if($categorydes->id == $productcategory->id)
                    {
                        $warning[] = $this->registry->lang['controller']['categorysampleError'];
                    }
                }
            }

            if(isset($_POST['fsubmit']))
            {
                $formData = array_merge($formData, $_POST);
                //xoa tat ca cac thuoc tinh cu
                Core_RelProductAttribute::deleteAttributeByProductId($formData['fpid']);

                //tao attribute value moi cho san pham
                if(count($formData['fattrdesvalue']) > 0)
                {
                    $ok = fasle;
                    foreach($formData['fattrdesvalue'] as $attrid => $value)
                    {
                        $relproductattribute = new Core_RelProductAttribute();
                        $relproductattribute->pid = (int)$formData['fpid'];
                        $relproductattribute->paid = $attrid;
                        $relproductattribute->value = $value;
                        $relproductattribute->weight = $formData['fattrdesweight'][$attrid];
                        $relproductattribute->valueseo = Helper::codau2khongdau($value,true,true);

                        if($relproductattribute->addData() > 0)
                        {
                            $ok = true;
                        }

                    }

                    if($ok)
                    {
                        $myProduct->pcid = $formData['fpciddes'];
                        if($myProduct->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['changecategorysucces'];
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['changecategoryerror'];
                        }
                    }
                }
                $formData['done'] = 1;
            }
        }

        //
        if($formData['fpciddes'] > 0)
        {
            $categorydes = new Core_Productcategory($formData['fpciddes']);
            if($categorydes->id > 0 && $categorydes->id != $productcategory->id)
            {
                   //lay tat ca cac attribute cua moi danh muc hien tai
                        $attributesource = Core_ProductAttribute::getProductAttributes(array('fpcid' => $pcidsource) , 'name' , 'ASC');
                        if(count($attributesource) == 0)
                        {
                            //lay attribute cua danh muc cha
                           $attributesource = Core_ProductAttribute::getProductAttributes(array('fpcid' => $productcategory->parentid) , 'name' , 'ASC');
                        }

                        if(count($attributesource) > 0)
                        {
                            foreach($attributesource as $attrsource)
                            {
                                $values = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $pid , 'fpaid' => $attrsource->id) , 'id' , 'ASC');
                                if(count($values) > 0)
                                {
                                    $attrsource->value = $values[0];
                                }
                            }
                        }

                        //lay thuoc tinh cua danh muc chuyen den
                        $attributedes = Core_ProductAttribute::getProductAttributes(array('fpcid' => $formData['fpciddes']) , 'name' , 'ASC');
                        if(count($attributedes) == 0)
                        {
                            $attributedes = Core_ProductAttribute::getProductAttributes(array('fpcid' => $categorydes->parentid) , 'name' , 'ASC');
                        }

                        //kiem tra gia tri thuoc tinh cua danh muc hien tai va danh muc den
                        foreach($attributesource as $attrsource)
                        {
                            foreach($attributedes as $attrdes)
                            {
                                if(Helper::codau2khongdau($attrsource->name,true,true) == Helper::codau2khongdau($attrdes->name,true,true)) //kiem tra slug
                                {
                                    $attrdes->value = $attrsource->value;
                                }
                            }
                        }
            }

        }

        //get all product category
        $productcategoryList = array();
            $parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
            for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
            {
                if($parentCategory1[$i]->parentid == 0)
                {
                    $productcategoryList[] = $parentCategory1[$i];
                    $parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                    for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
                    {
                        $parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                        $productcategoryList[] = $parentCategory2[$j];

                        $subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                        foreach ($subCategory as $sub)
                        {
                            $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                            $productcategoryList[] = $sub;
                        }
                    }
                }
            }

        $this->registry->smarty->assign(array('productcategoryList' => $productcategoryList,
                                              'productcategory' => $productcategory,
                                                    'attributesource' => $attributesource,
                                                    'attributedes' => $attributedes,
                                              'formData' => $formData,
                                                    'error' => $error,
                                                    'success' => $success,
                                                    'warning' => $warning,
                                                    'warning' => $warning,
                                                    'datesync' => $datesync,
                                                    'enemys' => $enemys,
                                                    ));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'changeproductcategory.tpl');

        $this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
                                                    'contents'  => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerContainer . 'changeproductcategory.tpl');
    }





    ####################################################################################################
    ####################################################################################################
    ####################################################################################################

    //Kiem tra du lieu nhap trong form them moi
    private function addActionValidator($formData, &$error)
    {
        $pass = true;

        if($formData['fname'] == '')
        {
            $error[] = $this->registry->lang['controller']['errNameNotEmpty'];
            $pass = false;
        }

        if($formData['fpcid'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPcidMustGreaterThanZero'];
            $pass = false;
        }

        if(!empty($formData['fprepaidprice']) && $formData['fprepaidprice'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPrepaidPriceMustGreaterThanZero'];
            $pass = false;
        }
        if(!empty($formData['fprepaidrand']) && $formData['fprepaidrand'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPrepaindMustGreaterThanZero'];
            $pass = false;
        }
        if(!empty($formData['fprepaiddepositrequire']) && $formData['fprepaiddepositrequire'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPrepaidDepositMustGreaterThanZero'];
            $pass = false;
        }
        // if(strlen($formData['fseodescription']) == 0)
        // {
        //     $error[] = $this->registry->lang['controller']['errSeoDescriptionNotEmpty'];
        //     $pass = false;
        // }

        //kiem tra hinh dai dien san pham
        if(strlen($_FILES['fimage']['name']) > 0)
        {
            //kiem tra dinh dang hinh anh
            if(!in_array(strtoupper(end(explode('.', $_FILES['fimage']['name']))), $this->registry->setting['product']['imageValidType']))
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }

            //kiem tra kich thuoc file
            if($_FILES['fimage']['size'] > $this->registry->setting['product']['imageMaxFileSize'])
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }

            //kiem tra kich thuoc cua hinh anh
            $imageinfo = getimagesize($_FILES['fimage']['tmp_name']);
            if((int)$imageinfo[0] != 150 && (int)$imageinfo[1] != 150)
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }
        }


        for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
        {
            if(strlen($_FILES['ffile']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name'][$key]))), $this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFileMediaType'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile']['size'][$key] > $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra kich thuoc cua hinh anh
                $imageinfo = getimagesize($_FILES['ffile']['tmp_name'][$key]);
                if((int)$imageinfo[0] != 800  && (int)$imageinfo[1] != 800)
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
            }
        }


        for($key = 0 ; $key < count($_FILES['ffile360']['size']) ; $key++)
        {
            if(strlen($_FILES['ffile360']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile360']['name'][$key]))),$this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFile360Type'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile360']['size'][$key] >  $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra kich thuoc cua hinh anh
                $imageinfo = getimagesize($_FILES['ffile360']['tmp_name'][$key]);
                if((int)$imageinfo[0] != 400  && (int)$imageinfo[1] != 400)
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
            }
        }

        //kiem tra special image
        if(strlen($_FILES['ftypespecialimg']['name'][0]) > 0)
        {
            if(!in_array(strtoupper(end(explode('.', $_FILES['ftypespecialimg']['name'][0]))),$this->registry->setting['product']['imageValidType']))
            {
                $error[] =  $this->registry->lang['controller']['errFileSpecialType'];
                $pass = false;
            }

            //kiem tra kich thuoc file
            if($_FILES['ftypespecialimg']['size'][0] >  $this->registry->setting['product']['imageMaxFileSize'])
            {
                $error[] =  $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }

            if(!preg_match("/^[a-zA-Z0-9\- ]+\-[1-9]*[0-9]*.[a-z]+$/", $_FILES['ffile360']['name'][$key] , $out)) {                    
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }  
        }


        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            $checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fpcid'], $formData['fvid'], Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
            if(!$checker)
            {
                $checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fpcid'], 0, Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
                if(!checker)
                {
                    $vendor = new Core_Vendor($formData['fvid']);
                    $error[] = str_replace('###name###',$vendor->name,$this->registry->lang['controller']['errVendor']);
                    $pass = false;
                }
            }
        }

        //CHECKING SLUG
        if(Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
        {
            $error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
            $pass = false;
        }

        //checking datatype of attribute
        if(count($_POST['fattropt']) > 0)
        {
            foreach($_POST['fattropt'] as $attr => $value)
            {
                if(strlen($value) > 0)
                {
                    $attribute = new Core_ProductAttribute($attr);
                    if($attribute->datatype == Core_ProductAttribute::DATATYPE_NUMBER)
                    {
                        if($value != -1)
                        {
                            if(!is_numeric($value))
                            {
                                $error[] = str_replace('###name###',$attribute->name,$this->registry->lang['controller']['errAttributeDataType']);
                                $pass = false;
                            }
                        }
                    }

                    if($attribute->datatype == Core_ProductAttribute::DATATYPE_STRING)
                    {
                        if($value != -1)
                        {
                            if(is_numeric($value))
                            {
                                $error[] = str_replace('###name###',$attribute->name,$this->registry->lang['controller']['errAttributeDataType']);
                                $pass = false;
                            }
                        }
                    }
                }
            }
        }

        //////////////////CHECK BARCODE IS EXIST
        $isExistBarcode = Core_Product::isBarcodeExist($formData['fbarcode']);
        if($isExistBarcode)
        {
            $error[] = 'Barcode này đã tồn tại trên hệ thống . Xin vui lòng kiễm tra lại';
            $pass = false;
        }

        if($formData['fpchoosecolor'] == -1)
        {
            if(strlen($formData['fpcolor']) == 0)
            {
                $error[] = 'Vui lòng chọn màu của sản phẩm .';
                $pass = false;
            }
            elseif(strlen($formData['fpcolorname']) == 0)
            {
                $error[] = 'Vui lòng nhập tên màu của sản phẩm .';
                $pass = false;
            }
        }


        return $pass;
    }
    //Kiem tra du lieu nhap trong form cap nhat
    private function editActionValidator($formData, &$error)
    {
        $pass = true;

        if($formData['fname'] == '')
        {
            $error[] = $this->registry->lang['controller']['errNameNotEmpty'];
            $pass = false;
        }

        if($formData['fpcid'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPcidMustGreaterThanZero'];
            $pass = false;
        }

        if(!empty($formData['fprepaidprice']) && $formData['fprepaidprice'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPrepaidPriceMustGreaterThanZero'];
            $pass = false;
        }
        if(!empty($formData['fprepaidrand']) && $formData['fprepaidrand'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPrepaindMustGreaterThanZero'];
            $pass = false;
        }
        if(!empty($formData['fprepaiddepositrequire']) && $formData['fprepaiddepositrequire'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errPrepaidDepositMustGreaterThanZero'];
            $pass = false;
        }
        // if(strlen($formData['fseodescription']) == 0)
        // {
        //     $error[] = $this->registry->lang['controller']['errSeoDescriptionNotEmpty'];
        //     $pass = false;
        // }

        if(strlen($_FILES['fimage']['name']) > 0)
        {
            //kiem tra dinh dang hinh anh
            if(!in_array(strtoupper(end(explode('.', $_FILES['fimage']['name']))), $this->registry->setting['product']['imageValidType']))
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }

            //kiem tra kich thuoc file
            if($_FILES['fimage']['size'] > $this->registry->setting['product']['imageMaxFileSize'])
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }

            //kiem tra kich thuoc cua hinh anh
            $imageinfo = getimagesize($_FILES['fimage']['tmp_name']);
            if((int)$imageinfo[0] != 150 && (int)$imageinfo[1] != 150)
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }
        }

        for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
        {
            if(strlen($_FILES['ffile']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name'][$key]))), $this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFileMediaType'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile']['size'][$key] > $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra kich thuoc cua hinh anh
                $imageinfo = getimagesize($_FILES['ffile']['tmp_name'][$key]);
                if((int)$imageinfo[0] != 800 && (int)$imageinfo[1] != 800)
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
            }
        }

        for($key = 0 ; $key < count($_FILES['ffile360']['size']) ; $key++)
        {            
            if(strlen($_FILES['ffile360']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile360']['name'][$key]))),$this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFile360Type'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile360']['size'][$key] >  $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra xem hinh da ton tai hay chua
                $productmedias = Core_ProductMedia::getProductMedias(array('fpid' => $formData['fid'] , 'ftype' => Core_ProductMedia::TYPE_360) , 'id' , 'ASC');
                if(count($productmedias) > 0)
                {
                    $productmedia = $productmedias[0];
                    $path = explode('/', $productmedia->file);

                    $curDateDir = '';

                    for($i = 0 ; $i< count($path) - 1 ; $i++)
                    {
                        $curDateDir .= $path[$i] . '/';
                    }

                    if(file_exists($this->registry->setting['product']['imageDirectory'] . $curDateDir . $_FILES['ffile360']['name'][$key]))
                    {
                        $error = str_replace('###filename###', $_FILES['ffile360']['name'][$key] , $this->registry->lang['controller']['errFileExist']);
                        $pass = false;
                    }
                }

                //kiem tra kich thuoc cua hinh anh
                $imageinfo = getimagesize($_FILES['ffile360']['tmp_name'][$key]);
                if((int)$imageinfo[0] != 400 && (int)$imageinfo[1] != 400)
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
                
                //kiem tra dinh dang product image
                if(!preg_match("/^[a-zA-Z0-9\- ]+\-[1-9]*[0-9]*.[a-z]+$/", $_FILES['ffile360']['name'][$key] , $out)) {                    
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }               
            }
        }

        //kiem tra special image
        if(strlen($_FILES['ftypespecialimg']['name'][0]) > 0)
        {
            if(!in_array(strtoupper(end(explode('.', $_FILES['ftypespecialimg']['name'][0]))),$this->registry->setting['product']['imageValidType']))
            {
                $error[] = $this->registry->lang['controller']['errFileSpecialType'];
                $pass = false;
            }

            //kiem tra kich thuoc file
            if($_FILES['ftypespecialimg']['size'][0] >  $this->registry->setting['product']['imageMaxFileSize'])
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }
        }

        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            $checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fpcid'], $formData['fvid'], Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
            if(!$checker)
            {
                $checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fpcid'], 0, Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
                if(!checker)
                {
                    $vendor = new Core_Vendor($formData['fvid']);
                    $error[] = str_replace('###name###',$vendor->name,$this->registry->lang['controller']['errVendor']);
                    $pass = false;
                }
            }
        }

        //CHECKING SLUG
        if($formData['fslug'] != $formData['fslugcurrent'] && Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
        {
            $error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
            $pass = false;
        }

        //checking datatype of attribute
        if(count($_POST['fattropt']) > 0)
        {
            foreach($_POST['fattropt'] as $attr => $value)
            {
                if(strlen($value) > 0)
                {
                    $attribute = new Core_ProductAttribute($attr);
                    if($attribute->datatype > 0)
                    {
                        if(($attribute->datatype == Core_ProductAttribute::DATATYPE_NUMBER))
                        {
                             if(!is_numeric($value))
                             {
                                $error[] = str_replace('###name###',$attribute->name,$this->registry->lang['controller']['errAttributeDataType']);
                                $pass = false;
                                break;
                             }
                        }

                        if($attribute->datatype == Core_ProductAttribute::DATATYPE_STRING)
                        {
                            if(is_numeric($value))
                            {
                                $error[] = str_replace('###name###',$attribute->name,$this->registry->lang['controller']['errAttributeDataType']);
                                $pass = false;
                                break;
                            }

                        }
                    }
                }
            }
        }


        if($formData['fonsitestatus'] == Core_Product::OS_ERP_PREPAID)
        {
            if((int)$formData['fprepaidprice'] == 0)
            {
                $error[] = 'Vui lòng nhập giá đặt hàng trước cho sản phẩm';
                $pass = false;
            }

            $startdateprepaidarr = explode('/',$formData['fprepaidstartdate']);
            $enddateprepaidarr = explode('/' , $formData['fprepaidenddate']);
            $startprepaidate = strtotime($startdateprepaidarr[2] . '-' . $startdateprepaidarr[1] . '-' . $startdateprepaidarr[0]);
            $endprepaiddate = strtotime($enddateprepaidarr[2] . '-' . $enddateprepaidarr[1] . '-' . $enddateprepaidarr[0]);
            if($startprepaidate > $endprepaiddate)
            {
                $error[] = 'Thời gian đặt hàng trước không hợp lệ.';
                $pass = false;
            }
            else if($endprepaiddate < strtotime("now"))
            {
                $error[] = 'Ngày kết thúc đặt hàng trước không hợp lệ.';
                $pass = false;
            }
        }


        //kiem tra thoi gian hien thi banner
        $startdateprepaidarr = explode('/',$formData['fbannerstartdate']);
        $enddateprepaidarr = explode('/' , $formData['fbannerendate']);
        $startprepaidate = strtotime($startdateprepaidarr[2] . '-' . $startdateprepaidarr[1] . '-' . $startdateprepaidarr[0]);
        $endprepaiddate = strtotime($enddateprepaidarr[2] . '-' . $enddateprepaidarr[1] . '-' . $enddateprepaidarr[0]);
        if($startprepaidate > $endprepaiddate)
        {
            $error[] = 'Thời gian hiển thị banner sản phẩm không hợp lệ.';
            $pass = false;
        }
        elseif($endprepaiddate < strtotime("now"))
        {
            $error[] = 'Ngày kết thúc hiển thị banner sản phẩm không hợp lệ.';
            $pass = false;
        }

        //kiem tra neu nhu barcode khong co thi khong the cap nhat onsitestaus cua san pham
        /*if(strlen($formData['fbarcode']) == 0)
        {
            if($formData['fonsitestatus'] != Core_Product::OS_NOSELL)
            {
                $error[] = 'Vui lòng nhập barcode của sản phẩm trước khi thay đổi onsitestatus của sản phẩm';
                $pass = false;
            }
        }*/

        if($formData['fcustomizetype'] == Core_Product::CUSTOMIZETYPE_MAIN)
        {
            if($formData['fpchoosecolor'] == -1)
            {
                if(strlen($formData['fpcolorstring']) == 0)
                {
                    $error[] = 'Vui lòng chọn màu của sản phẩm .';
                    $pass = false;
                }
                elseif(strlen($formData['fpcolorname']) == 0)
                {
                    $error[] = 'Vui lòng nhập tên màu của sản phẩm .';
                    $pass = false;
                }
            }
        }

        return $pass;
    }

    /**
     * [addProductColorValidator description]
     * @param [type] $formData [description]
     * @param [type] $error    [description]
     */
    private function addProductColorValidator($formData, &$error)
    {
        $pass = true;        

        for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
        {
            if(strlen($_FILES['ffile']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name'][$key]))), $this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFileMediaType'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile']['size'][$key] > $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra kich thuoc cua hinh anh
                $imageinfo = getimagesize($_FILES['ffile']['tmp_name'][$key]);
                if((int)$imageinfo[0] != 800 && (int)$imageinfo[1] != 800)
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
            }
        }

        //////////////////CHECK BARCODE IS EXIST
        if(strlen($formData['fbarcode']) > 0)
        {
            $isExistBarcode = Core_Product::isBarcodeExist($formData['fbarcode']);
            if($isExistBarcode)
            {
                $error[] = 'Barcode này đã tồn tại trên hệ thống . Xin vui lòng kiễm tra lại';
                $pass = false;
            }
        }
        else
        {
            $error[] = 'Vui lòng nhập barcode của sản phẩm';
            $pass = false;
        }

        if($formData['fpchoosecolor'] == -1)
        {
            if(strlen($formData['fpcolor']) == 0)
            {
                $error[] = 'Vui lòng chọn màu của sản phẩm .';
                $pass = false;
            }
            elseif(strlen($formData['fpcolorname']) == 0)
            {
                $error[] = 'Vui lòng nhập tên màu của sản phẩm .';
                $pass = false;
            }
        }

        return $pass;
    }

    /**
     * [editProductColorValidator description]
     * @param  [type] $formData [description]
     * @param  [type] $error    [description]
     * @return [type]           [description]
     */
    private function editProductColorValidator($formData, &$error)
    {
        $pass = true;
        for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
        {
            if(strlen($_FILES['ffile']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name'][$key]))), $this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFileMediaType'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile']['size'][$key] > $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra kich thuoc cua hinh anh
                $imageinfo = getimagesize($_FILES['ffile']['tmp_name'][$key]);
                if((int)$imageinfo[0] != 800 && (int)$imageinfo[1] != 800)
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
            }
        }

        if(strlen($formData['fbarcode']) == 0)
        {
            $error[] = 'Vui lòng nhập barcode của sản phẩm';
            $pass = fasle;
        }

        if($formData['fpchoosecolor'] == -1)
        {
            if(strlen($formData['fpcolor']) == 0)
            {
                $error[] = 'Vui lòng chọn màu của sản phẩm .';
                $pass = false;
            }
            elseif(strlen($formData['fpcolorname']) == 0)
            {
                $error[] = 'Vui lòng nhập tên màu của sản phẩm .';
                $pass = false;
            }
        }

        return $pass;
    }

    /**
     * after download gallery/360 file from cdn.tgdd.com, there are many 0-byte file. I run this script to clear these file and remove from table lit_product_media
     */
    function removenotfoundmediaAction()
    {
        set_time_limit(0);

        $sql = 'SELECT pm_id, pm_file FROM ' . TABLE_PREFIX . 'product_media
                WHERE pm_id >0
                ORDER BY pm_id ASC
                ';
        $stmt = $this->registry->db->query($sql);
        $corruptList = $normalList = array();
        while($row = $stmt->fetch())
        {
            $filepath = $this->registry->setting['product']['imageDirectory'] . $row['pm_file'];

            if(file_exists($filepath))
            {
                $imageinfo = getimagesize($filepath);
                if($imageinfo[0] == 0 || $imageinfo[1] == 0)
                    $corruptList[] = $row;
                else
                    $normalList[] = $row;
            }
            else
                $corruptList[] = $row;
        }

        //////////
        echo '<h1>CORRUPT LIST</h1><ol>';
        foreach($corruptList as $row)
        {
            echo '<li style="color:#f00;">'.$row['pm_file'].'';

            //update database to turn off this image
            $sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                    SET pm_status = ' . Core_ProductMedia::STATUS_DISABLED . '
                    WHERE pm_id = ?';
            $this->registry->db->query($sql, array($row['pm_id']));


            //Xoa hinh
            $filepath = $this->registry->setting['product']['imageDirectory'] . $row['pm_file'];
            if(file_exists($filepath))
            {
                if(unlink($filepath))
                    echo '<u>DELETED success</u>';
                else
                    echo '<u>CAN NOT DELETE</u>';
            }

            echo '</li>';
        }
        echo '</ol>';

        echo '<hr /><hr />';

        echo '<h1>NORMAL LIST</h1><ol>';
        foreach($normalList as $row)
        {
            echo '<li style="color:#0f0;">'.$row['pm_file'].'</li>';
        }
        echo '</ol>';

    }

    /**
     * After refine gallery/360, i need to create thumbnail version of these file
     */
    function mediathumbcreatorAction()
    {
        set_time_limit(0);
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_media
                WHERE pm_status = 1
                ORDER BY pm_id ASC
                ';
        $stmt = $this->registry->db->query($sql);
        while($row = $stmt->fetch())
        {
            $filepath = $this->registry->setting['product']['imageDirectory'] . $row['pm_file'];
            if(file_exists($filepath))
            {
                $dotPos = strrpos($row['pm_file'], '.');
                $extPart = substr($row['pm_file'], $dotPos + 1);
                $namePart = substr($row['pm_file'], 0, $dotPos);
                $nameThumb = $namePart . '-small.' . $extPart;

                //Create thumb image
                $myImageResizer = new ImageResizer(    $this->registry->setting['product']['imageDirectory'] , $row['pm_file'],
                                                        $this->registry->setting['product']['imageDirectory'] , $nameThumb,
                                                        $this->registry->setting['product']['imageThumbWidth'],
                                                        $this->registry->setting['product']['imageThumbHeight'],
                                                        '',
                                                        $this->registry->setting['product']['imageQuality']);
                $myImageResizer->output();
                echo $nameThumb . '<br />';
                unset($myImageResizer);
            }
        }
    }

    private function getRefProductId($barcode)
    {
        $productIdRef = 0;
        $oracle = new Oracle();
        $sql = 'SELECT PRODUCTIDREF FROM ERP.PM_PRODUCT
                WHERE PRODUCTID = \'' . (string)$barcode . '\'';

        $stmt = $oracle->query($sql);
        $productIdRef = (int)$stmt[0]['PRODUCTIDREF'];

        return $productIdRef;
    }

    /**
     * Sau khi nhan duoc thong tin product tu Ms Tham
     * Chay script nay de giai quyet cac truong hop URL su dung CDN external
     */
    public function fixproductdetailexternalAction()
    {
        set_time_limit(0);

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product
                WHERE p_id > 0 AND (p_content != "" OR p_fullbox != "" OR p_dienmayreview != "")
                ORDER BY p_id DESC
                ';
        $stmt = $this->registry->db->query($sql);
        while($row = $stmt->fetch())
        {
            echo '<h2>PID: ' . $row['p_id'] . '</h2>';
            ///////
            //////
            //xu ly dienmayreview
            $refineddienmayreview = preg_replace('/\[specs id="\d+"\]/', '', $row['p_dienmayreview']);

            ///////
            //xy ly fullbox
            $newfullbox = preg_replace('/src="http:\/\/cdn\.thegioididong\.com\/loading\.gif" alt="[^"]*" data-original="([^"]+)"/', 'src="$1"', $row['p_fullbox']);
            $newfullbox = preg_replace('/(<br\/>)+/', '$1', $newfullbox);
            $newfullbox = str_replace(' align=""', '', $newfullbox);
            $newfullbox = str_replace(' class="lazy"', '', $newfullbox);
            $newfullbox = preg_replace('/<a href="http:\/\/www\.thegioididong\.com[^"]+"[^>]+>([^<]+)<\/a>/ims', '<strong>$1</strong>', $newfullbox);

            $myExternalResourceDownload = new ExternalResourceDownload($newfullbox);
            $refinedfullbox = $myExternalResourceDownload->run('/', 'uploads/pimages/Article/');


            /////
            //xy ly content
            $newcontent = preg_replace('/src="http:\/\/cdn\.thegioididong\.com\/loading\.gif" alt="[^"]*" data-original="([^"]+)"/', 'src="$1"', $row['p_content']);
            $newcontent = preg_replace('/(<br\/>)+/', '$1', $newcontent);
            $newcontent = str_replace(' align=""', '', $newcontent);
            $newcontent = str_replace(' class="lazy"', '', $newcontent);
            $newcontent = preg_replace('/<a href="http:\/\/www\.thegioididong\.com[^"]+"[^>]+>([^<]+)<\/a>/ims', '<strong>$1</strong>', $newcontent);

            $myExternalResourceDownload = new ExternalResourceDownload($newcontent);
            $refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/Article/');

            //////////////////
            //////////////////
            // everything ok, update
            $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                    SET p_content = ?,
                        p_fullbox = ?,
                        p_dienmayreview = ?
                    WHERE p_id = ?';
            $this->registry->db->query($sql, array($refinedcontent, $refinedfullbox, $refineddienmayreview, $row['p_id']));
        }
    }

    public function updatepromotionajaxAction()
    {
        $mybarcode = (string)($this->registry->router->getArg('barcode'));
        if($mybarcode != '')
        {
            $this->synpromotionforproduct($mybarcode);
        }
        else echo json_encode(array('fail' => 1));
    }

    private function synpromotionforproduct($barcode)
    {
      $barcode = trim($barcode);
      set_time_limit(0);
      $this->synpromotionbybarcode($barcode);
      echo json_encode(array('success' => 1));
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

    private function synpromotionbybarcode($barcode)
    {
        global $db;
        $oracle = new Oracle();
        //Tìm tất cả các promotion của product trên erp
        $today = strtoupper(date('d-M-y' , time()));
        $findpromotions = $oracle->query('SELECT DISTINCT PROMOTIONID FROM ERP.VW_PROMOTIONINFO_DM WHERE PRODUCTID = \''.$barcode.'\' AND ENDDATE >= TO_DATE(\' '.$today.' \')');

        $listpromotionids = array();
        if(!empty($findpromotions))
        {
          if(!empty($findpromotions))
          {
              foreach($findpromotions as $promos)
              {
                  $promos['PROMOTIONID'] = trim($promos['PROMOTIONID']);
                  if(!in_array($promos['PROMOTIONID'], $listpromotionids))
                  {
                      //kiểm tra output time
                      $checkpromotionoutputtype = $oracle->query('SELECT COUNT(*) AS NUMPROMO FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE OUTPUTTYPEID IN (222, 8, 621, 3,201,601, 801) AND PROMOTIONID = '.$promos['PROMOTIONID']);
                      //741: xuat ban online trực tuyến
                      if($checkpromotionoutputtype[0]['NUMPROMO'] > 0)
                      {
                          $listpromotionids[] = $promos['PROMOTIONID'];
                      }
                  }
              }
          }
        }
        //lấy promotion theo dạng combo
        $findcombolist = $oracle->query('SELECT distinct PRODUCTCOMBOID FROM ERP.VW_COMBO_PRODUCT  WHERE PRODUCTID = \''.$barcode.'\'');
        if(!empty($findcombolist))
        {
          $listcombosid = array();
          foreach($findcombolist as $combo)
          {
              if(!in_array($combo['PRODUCTCOMBOID'], $listcombosid))
              {
                  $listcombosid[] = $combo['PRODUCTCOMBOID'];
              }
          }

          if(!empty($listcombosid))
          {
              $findpromotionlist = $oracle->query('SELECT distinct PROMOTIONID FROM
                                                   ERP.vw_promotioncombo_dm  WHERE
                                                   productcomboid IN (\''.implode('\',\'',$listcombosid).'\')'
                                                  );
              if(!empty($findpromotionlist))
              {
                  foreach($findpromotionlist as $promos)
                  {
                      $promos['PROMOTIONID'] = trim($promos['PROMOTIONID']);
                      if(!in_array($promos['PROMOTIONID'], $listpromotionids))
                      {
                          $checkpromotionoutputtype = $oracle->query('SELECT COUNT(*) AS NUMPROMO FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE OUTPUTTYPEID IN (222, 8, 621, 3,201,601, 801) AND PROMOTIONID = '.$promos['PROMOTIONID']);
                          //741: xuat ban online trực tuyến
                          if($checkpromotionoutputtype[0]['NUMPROMO'] > 0)
                          {
                              $listpromotionids[] = $promos['PROMOTIONID'];
                          }
                      }
                  }
              }

          }
        }
        //tìm promotion product cũ của barcode này trên csdl và  xóa nó
        $getlistoldpromotionproduct = $db->query('SELECT distinct promo_id FROM '.TABLE_PREFIX.'promotion_product WHERE p_barcode = "'.$barcode.'"');
        $listpromotiondeleted = array();
        if(!empty($getlistoldpromotionproduct))
        {
            while($rowpromoproducts = $getlistoldpromotionproduct->fetch())
                {
                    if(!empty($listpromotionids))//trường hợp $listpromotionids có
                    {
                        $rowpromoproducts['promo_id'] = trim($rowpromoproducts['promo_id']);
                        //Trường hợp promotion cần delete không nằm trong promotion mới tìm thấy
                        if( !in_array($rowpromoproducts['promo_id'] ,$listpromotionids))
                        {
                            if( !in_array($rowpromoproducts['promo_id'] ,$listpromotiondeleted))
                            {
                                $listpromotiondeleted[] = $rowpromoproducts['promo_id'];
                            }
                        }
                    }
                    else {
                        $listpromotiondeleted[] = $rowpromoproducts['promo_id'];
                    }
                }
        }
        if(!empty($listpromotiondeleted))
        {
            $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_product WHERE p_barcode = "'.$barcode.'" AND promo_id IN ('.implode(',',$listpromotiondeleted).')');
            //kiem tra xem promotion nay con chua nhung product khac khong, nếu không có thì  xóa nó đi
            foreach($listpromotiondeleted as $promoid)
            {
                $totalpromotionproducthasdata = $db->query('SELECT count(*) FROM '.TABLE_PREFIX.'promotion_product WHERE promo_id = '.(int)$promoid)->fetchColumn(0);
                if($totalpromotionproducthasdata == 0)
                {
                    //trường hợp promotion này không có promotion apply product kiểm tra tiếp coi có trong promotion combo không
                    $totalpromotioncombohasdata = $db->query('SELECT count(*) FROM '.TABLE_PREFIX.'promotion_combo WHERE promo_id = '.(int)$promoid)->fetchColumn(0);
                    if($totalpromotioncombohasdata == 0)
                    {
                        //delete tất cả những gì liên quan đến promotion này
                        $db->query('DELETE FROM '.TABLE_PREFIX.'promotion WHERE promo_id = '.(int)$promoid);

                        $getAllpromotionGroup = $db->query('SELECT promog_id FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id ='.(int)$promoid);
                        if(!empty($getAllpromotionGroup))
                        {
                            while($rgprow = $getAllpromotionGroup->fetch())
                            {
                                $db->query('DELETE FROM '.TABLE_PREFIX.'promotionlist WHERE promog_id = '.(int)$rgprow['promog_id']);
                            }
                        }
                        $this->expriedproductpromotion($promoid);
                        $db->query('DELETE FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id = '.(int)$promoid);
                        $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_combo WHERE promo_id = '.(int)$promoid);
                        $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_exclude WHERE promo_id = '.(int)$promoid);
                        $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_outputtype WHERE promo_id = '.(int)$promoid);
                        $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_store WHERE promo_id = '.(int)$promoid);
                    }
                }
            }
        }

        if(!empty($listpromotionids))
        {
            //lấy promotion mới từ ERP
            $sql = 'SELECT pr.* FROM ERP.VW_PROMOTIONSUMARY_DM pr WHERE pr.PROMOTIONID IN ('.implode(',', $listpromotionids).') AND (pr.DESCRIPTION IS NOT NULL OR pr.DESCRIPTION !=\'\') AND ISACTIVE = 1';

            $result = $oracle->query($sql);
            if(!empty($result))
            {
                foreach($result as $res)
                {
                    //update promotion, check combo, exclude promotion, scrope name, promotion apply, promotion list, promotion list group
                    //check promotion id
                    $checkpromotion = new Core_Promotion((int)$res['PROMOTIONID']);
                    $promotion = new Core_Promotion((int)$res['PROMOTIONID']);

                    $promotion->id                          = $res['PROMOTIONID'];
                    $promotion->usercreate                  = $res['USERCREATE'];
                    $promotion->useractive                  = $res['USERACTIVE'];
                    $promotion->userdelete                  = $res['USERDELETE'];
                    $promotion->name                        = $res['PROMOTIONNAME'];
                    $promotion->shortdescription            = $res['SHORTDESCRIPTION'];
                    $promotion->description                 = $res['DESCRIPTION'];
                    $promotion->isnew                       = $res['ISNEWTYPE'];
                    $promotion->showtype                    = $res['ISSHOWPRODUCTTYPE'];
                    $promotion->isprintpromotion            = $res['ISPRINTONHANDBOOK'];
                    $promotion->descriptionproductapply     = $res['APPLYPRODUCTDESCRIPTION'];
                    $promotion->descriptionpromotioninfo    = $res['PROMOTIONOFFERDESCRIPTION'];
                    $promotion->ispromotionbyprice          = $res['ISPROMOTIONBYPRICE'];
                    $promotion->maxpromotionbyprice         = $res['TOPRICE'];
                    $promotion->minpromotionbyprice         = $res['FROMPRICE'];
                    $promotion->ispromotionbytotalmoney     = $res['ISPROMOTIONBYTOTALMONEY'];
                    $promotion->maxpromotionbytotalmoney    = $res['MAXPROMOTIONTOTALMONEY'];
                    $promotion->minpromotionbytotalmoney    = $res['MINPROMOTIONTOTALMONEY'];
                    $promotion->ispromotionbyquantity       = $res['ISPROMOTIONBYTOTALQUANTITY'];
                    $promotion->maxpromotionbyquantity      = $res['MAXPROMOTIONTOTALQUANTITY'];
                    $promotion->minpromotionbyquantity      = $res['MINPROMOTIONTOTALQUANTITY'];
                    $promotion->ispromotionbyhour           = $res['ISAPPLYBYTIMES'];
                    $promotion->startpromotionbyhour        = (is_numeric($res['STARTTIME'])?$res['STARTTIME']:$this->formatTime($res['STARTTIME']));
                    $promotion->endpromotionbyhour          = (is_numeric($res['ENDTIME'])?$res['ENDTIME']:$this->formatTime($res['ENDTIME']));
                    $promotion->isloyalty                   = $res['ISMEMBERSHIPPROMOTION'];
                    $promotion->isnotloyalty                = $res['ISNOTAPPLYFORMEMBERSHIP'];

                    $promotion->isactived                   = $res['ISACTIVE'];
                    $promotion->iscombo                     = $res['ISCOMBO'];
                    $promotion->isshowvat                   = $res['ISSHOWVATINVOICEMESSAGE'];
                    $promotion->messagevat                  = $res['VATINVOICEMESSAGE'];
                    $promotion->isdeleted                   = $res['ISDELETE'];

                    $promotion->isunlimited                 = $res['ISLIMITPROMOTIONTIMES'];
                    $promotion->timepromotion               = $res['MAXPROMOTIONTIMES'];
                    $promotion->islimittimesoncustomer      = $res['ISLIMITTIMESONCUSTOMER'];

                    $promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
                    $promotion->enddate                     = $this->formatTime($res['ENDDATE']);
                    $promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
                    $promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');

                    //Get promotion apply product list
                    //$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID'].' AND PRODUCTID = \''.$barcode.'\'');

                    //get promotion apply store
                    $promotionapplystorelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYSCOPE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                    //get promotion combo
                    $promotioncombolist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONCOMBO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                    //get promotion exclude
                    $promotionexcludelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONEXCLUDE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                    //get promotion group
                    $promotiongroup = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONGROUP_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                    //get promotion group list
                    $promotiongrouplist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONLISTGROUP_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                    //get promotion out put type
                    $promotionoutputtypelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                    if($checkpromotion->id > 0) {
                        //if promotion exists
                        $promotion->updateData();
                    }
                    else {
                        //if promotion not exists
                        $promotion->addDataID();
                    }

                    //update promotion apply product
                    $excludeapplyproduct = array();
                    $excludeapplyarea = array();
                    if(!empty($promotionapplyproductlist))
                    {
                        foreach($promotionapplyproductlist as $promoapplyproduct)
                        {
                            if(!empty($promoapplyproduct['PROMOTIONID']) && !empty($promoapplyproduct['PRODUCTID']) && !empty($promoapplyproduct['AREAID']))
                            {
                                $PromotionProduct = new Core_PromotionProduct();
                                $checkpromotionlist = Core_PromotionProduct::getPromotionProducts(array('fpbarcode'=>$promoapplyproduct['PRODUCTID'],'fpromoid'=>$promoapplyproduct['PROMOTIONID'],'faid' => $promoapplyproduct['AREAID']),'','',1);
                                $PromotionProduct->pbarcode = $promoapplyproduct['PRODUCTID'];
                                $PromotionProduct->promoid = $promoapplyproduct['PROMOTIONID'];
                                $PromotionProduct->aid = $promoapplyproduct['AREAID'];

                                $promoapplyproduct['PRODUCTID'] = trim($promoapplyproduct['PRODUCTID']);
                                //if(!in_array($promoapplyproduct['PRODUCTID'], $excludeapplyproduct)) $excludeapplyproduct[] = $promoapplyproduct['PRODUCTID'];
                                //if(!in_array($promoapplyproduct['AREAID'], $excludeapplyarea)) $excludeapplyarea[] = $promoapplyproduct['AREAID'];

                                if(empty($checkpromotionlist))
                                {
                                    $PromotionProduct->addData();
                                }
                                else{
                                    $PromotionProduct->id = $checkpromotionlist[0]->id;
                                    $PromotionProduct->updateData();
                                }
                            }
                        }

                    }
                    /*if(!empty($excludeapplyproduct) && !empty($excludeapplyarea))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_product
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND p_barcode NOT IN ('."'".implode("','",$excludeapplyproduct)."'".') AND a_id NOT IN ('.implode(',',$excludeapplyarea).')'
                                                   );
                    }
                    else {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_product
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID']
                                                   );
                    }*/

                    //update promotion apply store
                    $excludeapplystore = array();
                    if(!empty($promotionapplystorelist))
                    {
                        foreach($promotionapplystorelist as $promoapplystore)
                        {
                            if(!empty($promoapplystore['PROMOTIONID']) && !empty($promoapplystore['STOREID']))
                            {
                                $promotionStore = new Core_PromotionStore();
                                $checkpromotionstore = Core_PromotionStore::getPromotionStores(array('fpromoid'=>$promoapplystore['PROMOTIONID'],'fsid'=>$promoapplystore['STOREID']),'','',1);
                                //if(!in_array($promoapplystore['STOREID'], $excludeapplystore)) $excludeapplystore[] = $promoapplystore['STOREID'];

                                $promotionStore->promoid = $promoapplystore['PROMOTIONID'];
                                $promotionStore->sid = $promoapplystore['STOREID'];

                                //check if store not exist in current database, add the new store
                                $getStore = Core_Store::getStores(array('fid'=>$promoapplystore['STOREID']),'','',1);
                                if(empty($getStore))
                                {
                                    $listStores = $oracle->query('SELECT * FROM ERP.VW_PM_STORE_DM s WHERE s.STOREID = '.(int)$promoapplystore['STOREID']);
                                    if(!empty($listStores[0]))
                                    {
                                        $store = $listStores[0];
                                        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'store (
                                            a_id,
                                            ppa_id,
                                            s_id,
                                            s_name,
                                            s_address,
                                            s_region,
                                            s_phone,
                                            s_fax,
                                            s_datecreated
                                            )
                                        VALUES(?, ?, ?,?, ?, ?,?, ?, ?)';
                                        $rowCount = $this->registry->db->query($sql, array(
                                            (int)$store['AREAID'],
                                            (int)$store['PRICEAREAID'],
                                            (int)$store['STOREID'],
                                            (string)$store['STORENAME'],
                                            (string)$store['STOREADDRESS'],
                                            (int)$store['PROVINCEID'],
                                            (string)$store['STOREPHONENUM'],
                                            (string)$store['STOREFAX'],
                                            time()
                                            ))->rowCount();
                                    }
                                }

                                if(empty($checkpromotionstore))
                                {
                                    $promotionStore->addData();
                                }
                                else
                                {
                                    $promotionStore->id = $checkpromotionstore[0]->id;
                                    $promotionStore->updateData();
                                }
                            }
                        }
                    }
                    /*if(!empty($excludeapplystore))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_store
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND s_id NOT IN ('.implode(',',$excludeapplystore).')'
                                                   );
                    }
                    else {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_store
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID']
                                                   );
                    }*/


                    //update promotion combo
                    $excludepromotioncombo = array();
                    //$excludepromotioncombopromotion = array();
                    if(!empty($promotioncombolist))
                    {
                        foreach($promotioncombolist as $combo)
                        {
                            if(!empty($combo['PRODUCTID']) && !empty($combo['PROMOTIONID']) && !empty($combo['PRODUCTCOMBOID']))
                            {
                                //check if combo not exist in current database, add the new combo
                                $getCombo = Core_Combo::getCombos(array('fid'=>$combo['PRODUCTCOMBOID']),'','',1);
                                //Core_Store::getStores(array('fid'=>$promoapplystore['STOREID']),'','',1);
                                if(empty($getCombo))
                                {
                                    $listCombo = $oracle->query('SELECT * FROM ERP.VW_COMBO_DM s WHERE s.PRODUCTCOMBOID = \''.(int)$combo['PRODUCTCOMBOID'].'\'');
                                    if(!empty($listCombo[0]))
                                    {
                                        $ncombo = $listCombo[0];
                                        $newcombo = new Core_Combo();
                                        $newcombo->id = $ncombo['PRODUCTCOMBOID'];
                                        $newcombo->name = $ncombo['PRODUCTCOMBONAME'];
                                        $newcombo->description = $ncombo['DESCRIPTION'];
                                        $newcombo->isactive = $ncombo['ISACTIVE'];
                                        $newcombo->addData();
                                    }
                                }
                                if(!empty($combo['PRODUCTCOMBOID']))
                                {
                                    $combo = new Core_Combo($combo['PRODUCTCOMBOID']);
                                    $combo->isdeleted = $combo['ISDELETE'];
                                    $combo->updateData();
                                }
                                $getRelComboProduct = Core_RelProductCombo::getRelProductCombos(array('fcoid' => $combo['PRODUCTCOMBOID'],'fpbarcode'=>$combo['PRODUCTID']),'','');
                                if(empty($getRelComboProduct))
                                {
                                    //Thêm rel combo product nếu chưa có
                                    $getComboProduct = $oracle->query('SELECT count(*) FROM ERP.VW_COMBO_PRODUCT pr WHERE pr.PRODUCTCOMBOID=\''.$combo['PRODUCTCOMBOID'].'\' AND PRODUCTID='.$combo['PRODUCTID']);
                                    if(!empty($getComboProduct))
                                    {
                                        $getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID=\''.$combo['PRODUCTID'].'\'');
                                        if(!empty($getProductDetailFromERP[0]))
                                        {
                                            foreach($getComboProduct as $rcp)
                                            {
                                                $RelProductCombo = new Core_RelProductCombo();
                                                $RelProductCombo->pbarcode = $rcp['PRODUCTID'];
                                                $RelProductCombo->coid = $rcp['PRODUCTCOMBOID'];
                                                $RelProductCombo->type = $rcp['COMBOTYPE'];
                                                $RelProductCombo->value = round($rcp['VALUE']*(1+$getProductDetailFromERP[0]['VAT'] * $getProductDetailFromERP[0]['VATPERCENT']/10000));
                                                $RelProductCombo->quantity = $rcp['QUANTITY'];
                                                $RelProductCombo->displayorder = $rcp['ORDERINDEX'];
                                                $RelProductCombo->addData();
                                            }
                                        }
                                    }
                                }
                                    $PromotionProduct = new Core_PromotionCombo();
                                    $checkpromotionlist = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=>$combo['PROMOTIONID'],'fcoid'=>$combo['PRODUCTCOMBOID']),'','',1);

                                    $PromotionProduct->promoid = $combo['PROMOTIONID'];
                                    $PromotionProduct->coid = $combo['PRODUCTCOMBOID'];
                                    //if(!in_array($combo['PRODUCTCOMBOID'], $excludepromotioncombo)) $excludepromotioncombo[] = $combo['PRODUCTCOMBOID'];

                                    if(empty($checkpromotionlist))
                                    {
                                        $PromotionProduct->addData();
                                    }
                                    else
                                    {
                                        $PromotionProduct->id = $checkpromotionlist[0]->id;
                                        $PromotionProduct->updateData();
                                    }
                                //}
                            }
                        }
                    }
                    /*if(!empty($excludepromotioncombo))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_combo
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND co_id NOT IN ('."'".implode("','",$excludepromotioncombo)."'".')'
                                                   );
                    }
                    else {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_combo
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID']
                                                   );
                    }*/

                    //update promotion exclude
                    $excludepromotionexclude = array();
                    if(!empty($promotionexcludelist))
                    {
                        foreach($promotionexcludelist as $promoexclude)
                        {
                            if(!empty($promoexclude['PROMOTIONID']) && !empty($promoexclude['EXCLUDEPROMOTIONID']))
                            {
                                $PromotionExclude = new Core_PromotionExclude();
                                $checkpromotionlist = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=>$res['PROMOTIONID'],'fpromoeid'=>$promoexclude['EXCLUDEPROMOTIONID']),'','',1);
                                $PromotionExclude->promoid = $promoexclude['PROMOTIONID'];
                                $PromotionExclude->promoeid = $promoexclude['EXCLUDEPROMOTIONID'];

                                //if(!in_array($promoexclude['EXCLUDEPROMOTIONID'], $excludepromotionexclude)) $excludepromotionexclude[] = $promoexclude['EXCLUDEPROMOTIONID'];
                                if(empty($checkpromotionlist))
                                {
                                    $PromotionExclude->addData();
                                }
                                else
                                {
                                    $PromotionExclude->promooldid = $checkpromotionlist[0]->promoid;
                                    $PromotionExclude->promoeoldid = $checkpromotionlist[0]->promoeid;
                                    $PromotionExclude->updateData();
                                }
                            }
                        }
                    }
                    /*if(!empty($excludepromotionexclude))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_exclude
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND promoe_id NOT IN ('.implode(',',$excludepromotionexclude).')'
                                                   );
                    }
                    else {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_exclude
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID']
                                                   );
                    }*/


                    //update promotion group
                    $excludepromotiongroup = array();
                    if(!empty($promotiongroup))
                    {
                        foreach($promotiongroup as $promogroup)
                        {
                            if(!empty($promogroup['PROMOTIONID']) && !empty($promogroup['PROMOTIONLISTGROUPID']))
                            {
                                $promotionGroup = new Core_Promotiongroup();
                                $checkpromotionstore = Core_Promotiongroup::getPromotiongroups(array('fid'=>$promogroup['PROMOTIONLISTGROUPID']),'discountvalue','DESC',1);

                                //if(!in_array($promogroup['PROMOTIONLISTGROUPID'], $excludepromotiongroup)) $excludepromotiongroup[] = $promogroup['PROMOTIONLISTGROUPID'];

                                $promotionGroup->id = $promogroup['PROMOTIONLISTGROUPID'];
                                $promotionGroup->promoid = $promogroup['PROMOTIONID'];
                                $promotionGroup->name = $promogroup['PROMOTIONLISTGROUPNAME'];
                                $promotionGroup->isfixed = $promogroup['ISFIXED'];
                                $promotionGroup->isdiscount = $promogroup['ISDISCOUNT'];
                                $promotionGroup->discountvalue = $promogroup['DISCOUNTVALUE'];
                                $promotionGroup->isdiscountpercent = $promogroup['ISPERCENTDISCOUNT'];
                                $promotionGroup->iscondition = $promogroup['ISCONDITION'];
                                $promotionGroup->conditioncontent = $promogroup['CONDITIONCONTENT'];
                                $promotionGroup->type = $promogroup['PROMOTIONLISTGROUPTYPE'];

                                if(empty($checkpromotionstore))
                                {
                                    $promotionGroup->addDataID();
                                }
                                else
                                {
                                    $promotionGroup->updateData();
                                }
                            }
                        }
                    }
                    /*if(!empty($excludepromotiongroup))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotiongroup
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND promog_id NOT IN ('.implode(',',$excludepromotiongroup).')'
                                                   );
                    }
                    else {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotiongroup
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID']
                                                   );
                    }*/

                    //update promotion group list
                    $excludepromotionlistgroup = array();
                    $excludepromotionlistgroupbarcode = array();
                    if(!empty($promotiongrouplist))
                    {
                        foreach($promotiongrouplist as $grouplist)
                        {
                            if(!empty($grouplist['PROMOTIONLISTGROUPID']) && !empty($grouplist['PRODUCTID']))
                            {
                                $promotionGroupList = new Core_Promotionlist();
                                $checkpromotionlist = Core_Promotionlist::getPromotionlists(array('fpbarcode'=>$grouplist['PRODUCTID'],'fpromogid'=>$grouplist['PROMOTIONLISTGROUPID']),'','',1);
                                $promotionGroupList->promogid = $grouplist['PROMOTIONLISTGROUPID'];
                                $promotionGroupList->pbarcode = $grouplist['PRODUCTID'];
                                $promotionGroupList->iscombo = $grouplist['ISCOMBO'];
                                $promotionGroupList->price = $grouplist['PROMOTIONPRICE'];
                                $promotionGroupList->quantity = $grouplist['QUANTITY'];
                                $promotionGroupList->ispercentcalc = $grouplist['ISPERCENTCALC'];
                                $promotionGroupList->imei = $grouplist['IMEI'];
                                $promotionGroupList->imeipromotionid = $grouplist['IMEIPRODUCTID'];

                                //if(!in_array($grouplist['PROMOTIONLISTGROUPID'], $excludepromotionlistgroup)) $excludepromotionlistgroup = $grouplist['PROMOTIONLISTGROUPID'];
                                //if(!in_array($grouplist['PRODUCTID'], $excludepromotionlistgroupbarcode)) $excludepromotionlistgroupbarcode = $grouplist['PRODUCTID'];

                                $promotionGroupList->datemodify = time();
                                if(empty($checkpromotionlist))
                                {
                                    $promotionGroupList->dateadd = time();
                                    $promotionGroupList->addData();
                                }
                                else{
                                    $promotionGroupList->id = $checkpromotionlist[0]->id;
                                    $promotionGroupList->updateData();
                                }
                            }
                        }
                    }
                    /*if(!empty($excludepromotionlistgroup) && !empty($excludepromotionlistgroupbarcode))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotionlist
                                                    WHERE promog_id NOT IN ('.implode(',',$excludepromotionlistgroup).') AND p_barcode NOT IN ('."'".implode("','",$excludepromotionlistgroupbarcode)."'".')'
                                                   );
                    }*/

                    //update promotion out put type
                    $excludepromotionoutputtype = array();
                    if(!empty($promotionoutputtypelist))
                    {
                        foreach($promotionoutputtypelist as $outputtype)
                        {
                            if(!empty($outputtype['PROMOTIONID']) && !empty($outputtype['OUTPUTTYPEID']))
                            {
                                $promotionOutputtype = new Core_PromotionOutputtype();
                                $checkpromotionlist = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromoid'=>$outputtype['PROMOTIONID'],'fpoid'=>$outputtype['OUTPUTTYPEID']),'','',1);
                                //if(!in_array($outputtype['OUTPUTTYPEID'], $excludepromotionoutputtype))  $excludepromotionoutputtype[] = $outputtype['OUTPUTTYPEID'];
                                $promotionOutputtype->promoid = $outputtype['PROMOTIONID'];
                                $promotionOutputtype->poid = $outputtype['OUTPUTTYPEID'];
                                if(empty($checkpromotionlist))
                                {
                                    $promotionOutputtype->addData();
                                }
                                else
                                {
                                    $promotionOutputtype->id = $checkpromotionlist[0]->id;
                                    $promotionOutputtype->updateData();
                                }
                            }
                        }
                    }
                    /*if(!empty($excludepromotionoutputtype))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_outputtype
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND po_id NOT IN ('.implode(',',$excludepromotionoutputtype).')'
                                                   );
                    }
                    else {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_outputtype
                                                    WHERE promo_id = '.(int)$res['PROMOTIONID']
                                                   );
                    }*/
                    $totalrecord++;
                }

                $this->savepromotionproductprice($listpromotionids);//doi cai nay lai thanh 1 list
            }
        }
    }

    private function savepromotionproductprice($listpromotionids)
    {
        if(empty($listpromotionids)) return false;
        //tim promotion giam gia cao nhat
        $findhighestpromotion = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $listpromotionids),'discountvalue', 'DESC', 1);
        $promoid = 0;
        if(!empty($findhighestpromotion))
        {
            $promoid = $findhighestpromotion[0]->promoid;
        }

        if($promoid ==0 ) return false;

        $getPromoStoreList = Core_PromotionStore::getPromotionStores(array('fpromoid' => $promoid),'','');
        if(!empty($getPromoStoreList))
        {
            $liststoreids = array();
            foreach($getPromoStoreList as $store)
            {
                if(!in_array($store->sid, $liststoreids))
                {
                    $liststoreids[] = $store->sid;
                }
            }
            if(!empty($liststoreids))
            {
                $getStoreList = Core_Store::getStores(array('fidarr' => $liststoreids), '', '');
                if(!empty($getStoreList))
                {
                    $listaids = array();
                    $listppaid = array();
                    foreach($getStoreList as $st)
                    {
                        if(!in_array($st->aid, $listaids))
                        {
                            $listaids[] = $st->aid;
                        }
                        if($st->ppaid > 0 && !in_array($st->ppaid, $listppaid))
                        {
                            $listppaid[] = $st->ppaid;
                        }
                    }
                    if(!empty($listaids) && !empty($listppaid))
                    {
                        $listRegionPriceAreas = Core_RelRegionPricearea::getRelRegionPriceareas(array('faidarr' => $listaids, 'fppaidarr' => $listppaid),'','');
                        if(empty($listRegionPriceAreas)) return false;
                        $listRegions = array();
                        foreach($listRegionPriceAreas as $relRP)
                        {
                            if(!in_array($relPR->rid, $listRegions))
                            {
                                $listRegions[] =  $relRP->rid;
                            }
                        }
                        if(!empty($listRegions))
                        {
                            //lay promotion product
                            $listpromotionproduct = Core_PromotionProduct::getPromotionProducts(array('fpromoid' => $promoid, 'faidarr' => $listaids), '', '');
                            if(!empty($listpromotionproduct))
                            {
                                $listproductpromolists = array();
                                foreach($listpromotionproduct as $productpromo)
                                {
                                    $productpromo->pbarcode = trim($productpromo->pbarcode);
                                    if(!empty($productpromo->pbarcode))
                                    {
                                        $getProductBybarocde = Core_Product::getIdByBarcode($productpromo->pbarcode);

                                        if($getProductBybarocde->id > 0)
                                        {
                                            $arrupdate = array();
                                            $discountpromotion = Core_Promotion::getFirstDiscountPromotionById($promoid);
                                                if(!empty($discountpromotion))
                                                {
                                                    foreach($listRegions as $rid)
                                                    {
                                                        if(!empty($discountpromotion))
                                                        {
                                                            $sellpriceproduct = $getProductBybarocde->sellprice;
                                                            if($discountpromotion['percent'] == 1)
                                                            {
                                                                $sellpriceproduct = $sellpriceproduct - ($sellpriceproduct * $discountpromotion['discountvalue']/100);
                                                            }
                                                            else
                                                                $sellpriceproduct = $sellpriceproduct - $discountpromotion['discountvalue'];

                                                            $arrupdate[] = $rid.','.$promoid.','.$discountpromotion['promogpid'].','.$sellpriceproduct;
                                                        }
                                                    }
                                                }
                                            if(!empty($arrupdate))
                                            {
                                                $updateProduct = new Core_Product($getProductBybarocde->id);
                                                $updateProduct->promotionlist = implode('###', $arrupdate);

                                                $updateProduct->updateData();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    private function expriedproductpromotion($idFilter)//$idFilter: promotion id
    {
        $promotion = new Core_Promotion($idFilter);
        if($promotion->id > 0)
        {
            $listallProductPromotion = Core_PromotionProduct::getPromotionProducts(array('fpromoid' => $promotion->id), '', '');
            //lay promotion product ra de clear field promotionlist cua product
            if(!empty($listallProductPromotion))
            {
                $listproductbarcode = array();
                foreach($listallProductPromotion as $promoproduct)
                {
                    $promoproduct->pbarcode = trim($promoproduct->pbarcode);
                    if(!in_array($promoproduct->pbarcode, $listproductbarcode))
                    {
                        $myproduct = Core_Product::getIdByBarcode($promoproduct->pbarcode);
                        if($myproduct->id > 0)
                        {
                            $arrupdate = array();
                            if($myproduct->promotionlist != '')
                            {
                                $com = explode('###',$myproduct->promotionlist);
                                if(!empty($com))
                                {
                                    foreach($com as $c)
                                    {
                                        if(!empty($c))
                                        {
                                            list($newrid, $newpromoid, $newpromogrupid, $newpsellprice) = explode(',',trim($c));
                                            $checkpromotion = $this->registry->db->query('SELECT promo_id FROM '. TABLE_PREFIX.'promotion WHERE promo_id = '.(int)$promotion->id. ' AND promo_enddate < '.(int)time())->fetch();
                                            if(empty($checkpromotion) && $newpromoid != $promotion->id)
                                            {
                                                $arrupdate[] = $c;
                                            }
                                        }
                                    }
                                }
                            }
                            $updateProduct = new Core_Product($myproduct->id);
                            if(!empty($arrupdate)) {
                                $updateProduct->promotionlist = implode('###', $arrupdate);
                            }
                            else $updateProduct->promotionlist = '';

                            $updateProduct->updateData();
                        }
                    }
                }
            }
            $recordaffect++;
        }
    }

    public function getproductattributeajaxAction()
    {
        $formData = array();
        $formData['fpcid'] = (int)$_POST['pcid'];
        $pid = (int)$_POST['pid'];
        $myProduct = new Core_Product($pid);

        $groupAttributeList = array();
        //kiem tra group attribute va attribute
        if($formData['fpcid'] > 0)
        {
            $productGroupAttribute = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$formData['fpcid']),'displayorder','ASC');
            $category = new Core_Productcategory($formData['fpcid']);
            if(count($productGroupAttribute) == 0)
            {
                //kiem tra xem category cha co group attribute hay khong
                if($category->parentid > 0)
                {
                    $productGroupAttributeParent =    Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$category->parentid),'displayorder','ASC');
                    if(count($productGroupAttributeParent) > 0)
                    {
                        $groupAttributeList[] = $productGroupAttributeParent;
                        $parentcategory = $category->parentid;
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAttributeGroup'];
                        $formData['fpcid'] = 0;
                    }
                }
                else
                {
                    $error[] = $this->registry->lang['controller']['errAttributeGroup'];
                    $formData['fpcid'] = 0;
                }
            }
            else
            {
                $groupAttributeList = $productGroupAttribute;
            }
        }


        $productAttributeList = array();


        //lay tat cac ca thuoc tinh trong moi group attribute
        for($i = 0 ; $i < count($groupAttributeList) ; $i++)
        {
            if((int)$parentcategory > 0)
            {
                $attributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$parentcategory,'fpgaid'=>$groupAttributeList[$i]->id),'displayorder','ASC');
            }
            else
            {
                $attributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$formData['fpcid'],'fpgaid'=>$groupAttributeList[$i]->id),'displayorder','ASC');
            }


            $attributeList = array();
            foreach($attributes as $attr)
            {
                $relproductattribute = Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$myProduct->id , 'fpaid'=> $attr->id),'','');
                $attr->value = $relproductattribute[0]->value;
                $attr->weight = $relproductattribute[0]->weight;
                $values = Core_RelProductAttribute::getRelProductAttributes(array('fpaid' => $attr->id) , 'id' , 'ASC');

                if(count($values) > 0)
                {
                    $datavalues = array();

                    foreach($values as $value)
                    {
                        $datavalues[] = $value->value;
                    }
                    $datavalues = array_unique($datavalues);
                }
                $attr->values = $datavalues;
                $attributeList[] = $attr;
            }
            $productAttributeList[$groupAttributeList[$i]->name] = $attributeList;
        }
        $this->registry->smarty->assign(array('productAttributeList' => $productAttributeList,));

        $this->registry->smarty->display($this->registry->smartyControllerContainer.'attributeajax.tpl');

    }

    public function getpromotionajaxAction()
    {
        $pid = (int)$_POST['pid'];
        $myProduct = new Core_Product($pid);

        //lay danh sach tat ca khuyen mai cua san pham
        $listnewpromotion = array();
        $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');

        $currentpromotion = array();
        if(!empty($myProduct->promotionlist))
        {
            $explodepromotionlist = explode('###', $myProduct->promotionlist);
            if(!empty($explodepromotionlist))
            {
                foreach($explodepromotionlist as $promoprice)
                {
                    list($rid, $promoid, $promogrupid, $psellprice) = explode(',',trim($promoprice));
                    $currentpromotion[$rid] = $promoid;
                }
            }
        }
        if(!empty($listregion))
        {
            foreach($listregion as $region)
            {
                $listpromotions = Core_Promotion::getPromotionByProductIDBackEnd(trim($myProduct->barcode), $region->id, $myProduct->sellprice);
                if(!empty($listpromotions) && !empty($listpromotions['listPromotions']))
                {
                    $listnewpromotion[$region->id] = array('promotion' =>$listpromotions['listPromotions'], 'regionname' =>$region->name);
                }
            }
        }

        $this->registry->smarty->assign(array('listpromotions' => $listnewpromotion,
                                                'promostatusList' => Core_Promotion::getStatusList(),
                                                'listcurrentpromotion' => $currentpromotion,));

        $this->registry->smarty->display($this->registry->smartyControllerContainer.'promotionajax.tpl');
    }

    public function updateproductpromotionstatusAction()
    {
        if(!empty($_SERVER['HTTP_REFERER']))
        {
            $arrReturn = array('success' => 2);
            if(!empty($_POST['promo']) && is_array($_POST['promo']) && !empty($_POST['pid']))
            {
                $promoiddisable = array();
                $promoidenable = array();
                $ischangedata = false;
                foreach($_POST['promo'] as $promoinfo)
                {
                    $promoid    = $promoinfo['name'];
                    $val        = $promoinfo['value'];
                    $myPromo = new Core_Promotion($promoid);
                    if($myPromo->id > 0)
                    {
                        if($myPromo->status != $val){
                            $myPromo->status = $val;
                            $myPromo->updateData();
                            $ischangedata = true;
                        }
                        if($val == 0) $promoidenable[] = $promoid;
                        else $promoiddisable[] = $promoid;
                    }
                }
                if($ischangedata)
                {
                    //delete nhung promotion co status la disable tu promotionlist
                    if(!empty($promoiddisable)){
                        foreach($promoiddisable as $promodis)
                        {
                            $this->expriedproductpromotion($promodis);
                        }
                    }
                    if(!empty($promoidenable))
                    {
                        $this->savepromotionproductprice($promoidenable);
                    }
                    $arrReturn['success'] = 1;
                    $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
                    if(!empty($listregion))
                    {
                        foreach($listregion as $ritem)
                        {
                            $cachefile1 = 'http'.'sitehtml_productdetail'.$_POST['pid'].'_'.$ritem->id;
                            $removeCache1 = new Cacher($cachefile1);
                            $removeCache1->clear();
                            $cachefile1 = 'https'.'sitehtml_productdetail'.$_POST['pid'].'_'.$ritem->id;
                            $removeCache1 = new Cacher($cachefile1);
                            $removeCache1->clear();
                        }
                    }
                }
            }
            echo json_encode($arrReturn);
        }
    }

    public function autocompleteajaxAction()
    {
        $formData = array();
        $keyword = Helper::xss_clean(strip_tags($_GET['tag']));


        //remove first @ character
        if(strpos($keyword, '@') === 0)
            $keyword = substr($keyword, 1);


        $formData['fgeneralkeyword'] = $keyword;

        $productList = Core_Product::getProducts($formData , 'id' , 'ASC' , '0,10');

        $items = array();
        for ($i=0 , $ilen = count($productList) ; $i < $ilen ; $i++)
        {
            $value = '<span class="label label-success"><small>'.$productList[$i]->id.'</small></span> ' . $productList[$i]->name;
            $items[] = array('key' => $productList[$i]->id , 'value' => $value);
        }

        echo json_encode($items);
    }

    public function importproductsizeAction()
    {
        set_time_limit(0);

        $formData = array();
        $error = array();
        $success = array();
        $warning = array();

        $productlist = array();

        if(isset($_POST['fsubmit']))
        {
            if($this->importsizeActionValidator($formData , $error))
            {
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
                            /////LAY THONG TIN CUA SAN PHAM
                            $productinfo = Core_Product::getProductIDByBarcode($data[1]);
                            if(!empty($productinfo))
                            {
                                //////KIEM TRA XEM USER HIEN TAI CO QUYEN VOI SAN PHAM NAY KHONG
                                if( Core_RoleUser::checkProductcategory($productinfo['pc_id']) || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer') )
                                {
                                    $productsizeinfo = explode('x' , $data[2]);
                                    $productinfo['p_length'] = $productsizeinfo[0];
                                    $productinfo['p_width'] = $productsizeinfo[1];
                                    $productinfo['p_height'] = $productsizeinfo[2];
                                    $productinfo['p_weight'] = $data[3];

                                    if(Core_Product::updateProductInfo($productinfo))
                                        $ok = true;
                                    else
                                        $ok = false;
                                }
                                else
                                {
                                    $warning[] = 'Bạn không có quyền với sản phẩm có barcode là : ' . $productinfo['p_barcode'];
                                }
                            }
                            else
                            {
                                $warning[] = 'Sản phẩm có barcode là : ' . $data[1] . ' không tồn tại';
                            }

                        }
                        $i++;
                    }

                    if($ok)
                        $success[] = 'Import kích thước sản phẩm thành công';
                    else
                        $error[] = 'Có lỗi xảy ra trong quá trình import kích thước sản phẩm';

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
                                                ));
        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'importsize.tpl');
        $this->registry->smarty->assign(array(
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProduct->name,
                                                'contents'             => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function importkeysellingpointAction()
    {
        set_time_limit(0);

        $formData = array();
        $error = array();
        $success = array();
        $warning = array();

        $productlist[] = array();

        if(isset($_POST['fsubmit']))
        {
            if($this->importkeysellingpointActionValidator($formData , $error))
            {
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
                            /////LAY THONG TIN CUA SAN PHAM
                            $productinfo = Core_Product::getProductIDByBarcode($data[1]);
                            if(!empty($productinfo))
                            {
                                //////KIEM TRA XEM USER HIEN TAI CO QUYEN VOI SAN PHAM NAY KHONG
                                if( Core_RoleUser::checkProductcategory($productinfo['pc_id']) || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer') )
                                {
                                    $keysellingpointlist = explode( ';' , $data[2]);
                                    $productinfo['p_summarynew'] = implode('#' , $keysellingpointlist);
                                    if(Core_Product::updateProductInfo($productinfo))
                                        $ok = true;
                                    else
                                        $ok = false;
                                }
                                else
                                {
                                    $warning[] = 'Bạn không có quyền với sản phẩm có barcode là : ' . $productinfo['p_barcode'];
                                }
                            }
                            else
                            {
                                $warning[] = 'Sản phẩm có barcode là : ' . $data[1] . ' không tồn tại';
                            }

                        }
                        $i++;
                    }

                    if($ok)
                        $success[] = 'Import keysellingpoint của sản phẩm thành công';
                    else
                        $error[] = 'Có lỗi xảy ra trong quá trình import keysellingpoint của sản phẩm';

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
                                                ));
        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'importkeysellingpoint.tpl');
        $this->registry->smarty->assign(array(
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProduct->name,
                                                'contents'             => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    private function importsizeActionValidator($formData , &$error)
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

    private function importkeysellingpointActionValidator()
    {
        $pass = true;

        //check file valid
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

    public function exportinfoproductwebAction()
    {
        set_time_limit(0);

        $data = '';

        $data .= 'Id#Barcode#Link#Name#Category#Status#Instock Status#Onsitestatus#ERP status#Sellprice#Finalprice#Customize Type' . "\n";

        $page = 1;

        while(1)
        {
            $productlist = Core_Product::getProducts(array() , 'id' , 'DESC' , ($page -1) * $this->recordPerPage . ',' . $this->recordPerPage );
            if(count($productlist) == 0)
            {
                break;
            }
            else
            {
                foreach($productlist as $product)
                {
                    $data .= $product->id . '#' . $product->barcode . '#' . $product->getProductPath() . '#' . $product->name ;

                    $category = new Core_Productcategory($product->pcid , true);

                    $data .= '#' . $category->name;

                    $data .=  '#' . $product->getStatusName() . '#';

                    $data .= ($product->instock > 0) ? 'Have' : 'Out of stock';

                    $data .= '#' . $product->getonsitestatusName() . '#' . $product->getbusinessstatusName() . '#' . $product->sellprice . '#' . $product->finalprice . ($product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN ? '#Main' : '#Color');

                    $data .= "\n";
                }

                unset($productlist);
            }
            $page++;
        }


        $myHttpDownload = new HttpDownload();
        $myHttpDownload->set_bydata($data); //Download from php data
        $myHttpDownload->use_resume = true; //Enable Resume Mode
        $myHttpDownload->filename = 'productdataexport-'.date('Y-m-d-H-i-s') . '.csv';
        $myHttpDownload->download(); //Download File
    }

    public function deleteproductsAction()
    {
        set_time_limit(0);

        if( $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer') ) //chuc nang nay chi co admin va developer co the lam dc
        {

            if(isset($_POST['fsubmit']))
            {
                ////READ CONTENT CVS FILE
                $tmpName = $_FILES['ffile']['tmp_name'];
                if (($handle = fopen($tmpName, "r")) !== FALSE)
                {
                    $i = 0;
                    $ok = false;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                    {
                        if( $i > 0 )
                        {
                            /////LAY THONG TIN CUA SAN PHAM
                            $product = new Core_Product($data[3] , true);
                            if($product->id > 0)
                            {
                                //////DELETE PRODUCT
                                if($product->delete() > 0)
                                    $ok = true;
                                else
                                    $ok = false;
                            }
                            else
                            {
                                $warning[] = 'Sản phẩm có barcode là : ' . $data[1] . ' không tồn tại';
                            }

                            unset($product);
                        }
                        $i++;
                    }

                    if($ok)
                        $success[] = 'Xóa sản phẩm thành công';
                    else
                        $error[] = 'Có lỗi xảy ra trong quá trình xóa sản phẩm';

                    fclose($handle);
                }
                ////END OF READ CONTENT FILE
            }

            $this->registry->smarty->assign(array( 'formData' => $formData,
                                                'error'   => $error,
                                                'success' => $success,
                                                'warning' => $warning,
                                                'redirectUrl'    => $this->getRedirectUrl(),
                                                ));
            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'deleteproducts.tpl');
            $this->registry->smarty->assign(array(
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProduct->name,
                                                'contents'             => $contents));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        }
    }

    public function changedatacolorAction()
    {
        $result = 0;
        $pidsource = (int)$_POST['pidsource'];
        $piddestination = (int)$_POST['piddestination'];
        $colornamechange = (string)$_POST['colornamechange'];
        $colorchange = (string)$_POST['colorchange'];

        $productidsource = new Core_Product($pidsource , true);
        $productiddestination = new Core_Product($piddestination , true);

        if($productidsource->id > 0 && $productiddestination->id > 0 && strlen(trim($colornamechange)) > 0 && trim($colorchange))
        {
            //update color list of product id source
            $colorliststring = '###' . $productiddestination->id . ':' . $productidsource->name . ':' . $colornamechange . ':' . substr(trim($colorchange), 1) . ':0';
            $productidsource->colorlist .= $colorliststring;

            if($productidsource->updateData())
            {
                //update customize type of product id destination
                $productiddestination->customizetype = Core_Product::CUSTOMIZETYPE_COLOR;

                if($productiddestination->updateData())
                {
                    //create rel product product
                    $myRelProductProduct = new Core_RelProductProduct();
                    $myRelProductProduct->pidsource = $productidsource->id;
                    $myRelProductProduct->piddestination = $productiddestination->id;
                    $myRelProductProduct->type = Core_RelProductProduct::TYPE_COLOR;
                    $myRelProductProduct->typevalue = $colornamechange . ':' .substr(trim($colorchange), 1);

                    if($myRelProductProduct->addData() > 0)
                    {
                        $result = 1;
                    }
                }
            }
        }

        echo $result;
    }

    public function exportproductcolorAction()
    {
        set_time_limit(0);

        //get all main product have color

    }

    public function exportproductsizeAction()
    {
        set_time_limit(0);

        $data = 'ID#Barcode#Product name#Height#Width#Length#Weight' . "\n";

        $sql = 'SELECT p_barcode , p_id , p_name ,p_weight , p_height , p_length , p_width FROM '. TABLE_PREFIX . 'product WHERE p_onsitestatus > 0';

        $stmt = $this->registry->db->query($sql , array($sql));

        while ($row = $stmt->fetch())
        {
            $data .= $row['p_id'] . '#' . $row['p_barcode'] . '#' . $row['p_name'] . '#' . $row['p_height'] . '#' . $row['p_width'] . '#' . $row['p_length'] . '#' . $row['p_weight'] . "\n";
        }

        $myHttpDownload = new HttpDownload();
        $myHttpDownload->set_bydata($data); //Download from php data
        $myHttpDownload->use_resume = true; //Enable Resume Mode
        $myHttpDownload->filename = 'productdata-'.date('Y-m-d-H-i-s') . '.csv';
        $myHttpDownload->download(); //Download File
    }


    public function exportproductbuyingAction()
    {
        set_time_limit(0);
        $recordPerPage = 100;
        $data = 'ID#Barcode#Tên sản phẩm#Ngành hàng cha#Nhóm hàng#Giá niêm yết#Giá bán cuối#Tồn kho#Trạng thái#Promotionid#Khuyến mãi' . "\n";

        $page = 1;

        while(1)
        {
            $limit = ($page - 1) * $recordPerPage . ',' . $recordPerPage;

            $productList = Core_Product::getProducts(array('fstatus' => Core_Product::STATUS_ENABLE,
                                                            'fisonsitestatus' => 1,
                                                            ) , 'id' ,'ASC' , $limit);

            if(count($productList) > 0)
            {
                foreach ($productList as $product)
                {
                    ///GET PROMOTION INFO
                    $promotioninfoList = Core_Promotion::getPromotionNameByProductID($product->barcode);


                    if($promotioninfoList !== false && count($promotioninfoList) > 0)
                    {
                        $data .= $product->id . '#';
                        $data .= trim($product->barcode) . '#';
                        $data .= $product->name . '#';

                        $fullparentcategoryList = Core_Productcategory::getFullParentProductCategorys($product->pcid);
                        $data .= $fullparentcategoryList[0]['pc_name'] . '#';

                        $myProductcategory = new Core_Productcategory($product->pcid , true);
                        $data .= $myProductcategory->name . '#';

                        $data .= $product->sellprice . '#';
                        $data .= $product->finalprice . '#';
                        $data .= $product->instock . '#';
                        $data .= $product->getbusinessstatusName() . '#';

                        foreach ($promotioninfoList as $promotion)
                        {
                            if(!empty($promotion->descriptionclone))
                            {
                                $promodata = nl2br($promotion->descriptionclone);
                                $promodata = strip_tags($promodata);
                                $promodata = str_replace (array("\r\n", "\n", "\r"), ';', $promodata);

                                $data .= $promotion->id . ',' .$promodata . ':';
                            }
                            else
                            {
                                $promodata = nl2br($promotion->description);
                                $promodata = strip_tags($promodata);
                                $promodata = str_replace (array("\r\n", "\n", "\r"), ';', $promodata);

                                $data .= $promotion->id . ',' .$promodata . ':';
                            }

                        }

                        $data .= "\n";

                    }
                }
            }
            else
            {
                break;
            }


            unset($productList);
            $page++;
        }
        //echodebug($data , true);
        $myHttpDownload = new HttpDownload();
        $myHttpDownload->set_bydata($data); //Download from php data
        $myHttpDownload->use_resume = true; //Enable Resume Mode
        $myHttpDownload->filename = 'promotionlist-'.date('Y-m-d-H-i-s') . '.csv';
        $myHttpDownload->download(); //Download File
    }

}

