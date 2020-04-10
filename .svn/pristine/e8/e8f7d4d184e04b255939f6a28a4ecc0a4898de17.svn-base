<?php

Class Controller_Cms_Promotion Extends Controller_Cms_Base
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


        $nameFilter = (string)($this->registry->router->getArg('name'));
		$descriptionFilter = (string)($this->registry->router->getArg('description'));
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
            if($_SESSION['promotionBulkToken']==$_POST['ftoken'])
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
                            $myPromotion = new Core_Promotion($id);

                            if($myPromotion->id > 0)
                            {
                                //tien hanh xoa
                                if($myPromotion->delete())
                                {
                                    $deletedItems[] = $myPromotion->id;
                                    $this->registry->me->writelog('promotion_delete', $myPromotion->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myPromotion->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPromotion->id;
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

		$_SESSION['promotionBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}
        if($descriptionFilter != "")
        {
            $paginateUrl .= 'description/'.$descriptionFilter . '/';
            $formData['fsdescription'] = $descriptionFilter;
            $formData['search'] = 'name';
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

			if($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
            if($searchKeywordIn == 'description')
            {
                $paginateUrl .= 'searchin/description/';
            }
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Promotion::getPromotions($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$promotions = Core_Promotion::getPromotions($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'promotions' 	=> $promotions,
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

	function showpromotionAction()
    {
        $formData['promotionid'] = (int)($this->registry->router->getArg('id'));
        $tabid = (int)($this->registry->router->getArg('tab'));
        $formData['tab'] = !empty($tabid)?$tabid:1;
        $success = array();
        if(!empty($formData['promotionid']))
        {
            $formData['promotiondetail'] = Core_Promotion::getPromotions(array('fid'=> $formData['promotionid']),'','',1);
            if(!empty($_POST['fupdatedescriptionclone']))
            {
                if($_SESSION['updatedescriptionclone'] == $_POST['ftoken'])
                {
                    $myPromotion = new Core_Promotion($formData['promotionid']);
                    if($myPromotion->id>0)
                    {

                        $myPromotion->descriptionclone = $_POST['fdescriptionclone'];
                        if($myPromotion->updateData())
                        {
                            header("Location:".$this->registry->conf['rooturl_cms']."promotion/showpromotion/id/".$formData['promotionid']);
                        }

                    }
                }
            }
            $_SESSION['updatedescriptionclone']=Helper::getSecurityToken();
            switch($tabid){
                case 2:
                        $stores = Core_Store::getStores(array(),'','');
                        $newstores = array();
                        if(!empty($stores))
                        {
                            foreach($stores as $st)
                            {
                                $newstores[$st->id] = $st->name;
                            }
                        }

                        $promotionstore = Core_PromotionStore::getPromotionStores(array('fpromoid'=> $formData['promotionid']),'','');

                        $newpromotionstore = array();
                        if(!empty($promotionstore))
                        {
                            foreach($promotionstore as $pstore)
                            {
                                if(!empty($newstores[$pstore->sid]))
                                {
                                    $pstore->storename = $newstores[$pstore->sid];
                                    $newpromotionstore[] = $pstore;
                                }
                            }
                        }
                        //echodebug($promotionstore, true);
                        $formData['promotionstore'] = $newpromotionstore;

                    break;
                case 3:
                        $productoutputtype = Core_ProductOutputype::getProductOutputypes(array(),'','');
                        $newoutputtype = array();
                        if(!empty($productoutputtype))
                        {
                            foreach($productoutputtype as $po)
                            {
                                $newoutputtype[$po->id] = $po->name;
                            }
                        }
                        $promotionsoutputtype = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromoid'=> $formData['promotionid']),'','');

                        $newpromotionoutputtype = array();
                        if(!empty($promotionsoutputtype))
                        {
                            foreach($promotionsoutputtype as $promooutput)
                            {
                                if(!empty($newoutputtype[$promooutput->poid]))
                                {
                                    $promooutput->outputtypename = $newoutputtype[$promooutput->poid];
                                    $newpromotionoutputtype[] = $promooutput;
                                }
                            }
                        }
                        //echodebug($newpromotionoutputtype);
                        $formData['promotionoutputtype'] = $newpromotionoutputtype;
                    break;
                case 4:
                        $newpromotionapplyproduct = array();
                        if($formData['promotiondetail'][0]->iscombo==1)
                        {
                            $promotioncombo = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=> $formData['promotionid']),'','');
                            if(!empty($promotioncombo))
                            {
                                $listpcombo = array();
                                foreach($promotioncombo as $promocombo)
                                {
                                    $listpcombo[] = $promocombo->coid;
                                }
                                $newpromotionapplyproduct = $promotioncombo;
                            }
                            if(!empty($listpcombo))
                            {
                                $listcombo = Core_Combo::getCombos(array('fidarr'=>$listpcombo),'','');
                                $newcombo = array();
                                if(!empty($listcombo))
                                {
                                    foreach($listcombo as $combo)
                                    {
                                        $newcombo[$combo->id] = $combo->name;
                                    }
                                }//echodebug($newcombo);
                                $formData['listcombo'] = $newcombo;
                            }
                        }
                        else
                        {
                            $promotionapplyproduct = Core_PromotionProduct::getListPromotionProductGroupBy($formData['promotionid']);
                            $listpproduct = array();
                            $listvendor = array();
                            //echodebug($promotionapplyproduct, true);
                            if(!empty($promotionapplyproduct))
                            {
                                foreach($promotionapplyproduct as $papply)
                                {
                                    $papply->pbarcode = trim($papply->pbarcode);
                                    $listpproduct[] = $papply->pbarcode;
                                }
                            }

                            if(!empty($listpproduct))
                            {
                                $listproductdetail = Core_Product::getProducts(array('fpbarcodearr'=>$listpproduct),'','');
                                $newlistproduct = array();
                                foreach($listproductdetail as $pro)
                                {
                                    $pro->barcode = trim($pro->barcode);
                                    $newlistproduct[$pro->barcode] = $pro;
                                    //$newlistproduct[$pro->barcode]->name = $pro->name;
                                }
                                $formData['listproduct'] = $newlistproduct;
                                if(!empty($newlistproduct))
                                {
                                    foreach($newlistproduct as $product)
                                    {
                                        if(!empty($product->vid)) $listvendor[] = $product->vid;
                                    }
                                }
                                if(!empty($listvendor))
                                {
                                    $newvendor = array();
                                    $vdor = Core_Vendor::getVendors(array('fidarr'=>$listvendor,'ftype'=>Core_Vendor::TYPE_SUBVENDOR),'','');
                                    if(!empty($vdor))
                                    {
                                        foreach($vdor as $v)
                                        {
                                            $newvendor[$v->id] = $v->name;
                                        }
                                    }
                                    $formData['listvendor'] = $newvendor;
                                }
                            }
                        }//echodebug($formData['listproduct']);
                        $newpromotionapplyproduct = $promotionapplyproduct;
                        $formData['promotionapplyproduct'] = $newpromotionapplyproduct;

                    break;
                case 5:
                        $promotiongroup = Core_Promotiongroup::getPromotiongroups(array('fpromoid'=> $formData['promotionid'],'fisdeleted'=>0),'','');
                        //$formData['promotioncombo'] = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=> $formData['promotionid']),'','');
                        if(!empty($promotiongroup))
                        {
                            $idlistpromotiongroup = array();
                            $newpromotiongroup = array();
                            foreach($promotiongroup as $pgr)
                            {
                                $idlistpromotiongroup[] = $pgr->id;
                                $newpromotiongroup[$pgr->id] = $pgr;
                            }//var_dump($newpromotiongroup);
                            //HONG LOGIC O DAY, TRUONG HOP CO PROMOTION GROUP NHUNG KO CO PROMOTION LIST GROUP VAN SHOW LEN DUOC
                            $formData['promotiongroup'] = $newpromotiongroup;
                            $formData['promotiongrouplist'] = Core_Promotionlist::getPromotionlists(array('fpromogidarr'=> $idlistpromotiongroup),'','');
                            /*if(!empty($idlistpromotiongroup))
                            {
                                $promotiongrouplist = Core_Promotionlist::getPromotionlists(array('fpromogidarr'=> $idlistpromotiongroup),'','');
                                if(!empty($promotiongrouplist))
                                {
                                    $newgrouplist = array();
                                    foreach($promotiongrouplist as $pgl)
                                    {
                                        $newgrouplist[$pgl->]
                                    }
                                }
                            }*/
                        }
                    break;
                case 6:
                        $promotionexclude = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=> $formData['promotionid']),'','');
                        if(!empty($promotionexclude))
                        {
                            $excludelist = array();
                            foreach($promotionexclude as $promoex)
                            {
                                if(!empty($promoex->promoeid)) $excludelist[] = $promoex->promoeid;
                            }
                            if(!empty($excludelist))
                            {
                                $formData['promotionexclude'] = Core_Promotion::getPromotions(array('fidarr'=>$excludelist),'','');
                            }
                        }
                    break;

            }

        }

        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                  'formData' => $formData,
                                                  'success'=>$success
                                             ));
        $this->registry->smarty->display($this->registry->smartyControllerContainer . 'showpromotion.tpl');
    }

    function showpromocombolistAction()
    {
        $formData['promotionid'] = (int)($this->registry->router->getArg('id'));
        $formData['promotiongroupid'] = (int)($this->registry->router->getArg('gpid'));
        if(!empty($formData['promotionid']) && !empty($formData['promotiongroupid']))
        {
             $promotionglist = Core_PromotionCombo::getPromotionCombos(array(//'fpromogid'=> $formData['promotionid'],
                                                                            'fpromoid'=>$formData['promotionid']
                                                                            ),'promoc_displayorder','ASC');
             //var_dump($promotionglist);
             $listproductcombo = array();
             $listbarcode = array();
             if(!empty($promotionglist))
             {
                 foreach($promotionglist as $pl)
                 {
                     $pl->pbarcode = trim($pl->pbarcode);
                     $listproductcombo[] = trim($pl->coid);
                     if(!in_array($pl->pbarcode,$listbarcode)){
                         $listbarcode[] = $pl->pbarcode;
                     }
                 }
                 if(!empty($listproductcombo))
                 {
                     $listCombo = Core_Combo::getCombos(array('fidarr'=>$listproductcombo),'','');
                     if(!empty($listCombo))
                     {
                         $newcombo = array();
                         foreach($listCombo as $cobo)
                         {
                             $newcombo[$cobo->id] = $cobo;
                         }
                         $formData['listCombo'] = $newcombo;
                     }
                 }
                 if(!empty($listbarcode))
                 {
                     $listProduct = Core_Product::getProducts(array('fpbarcodearr'=>$listbarcode),'','');
                     if(!empty($listProduct))
                     {
                         $newprod = array();
                         foreach($listProduct as $prod)
                         {
                             $newprod[$prod->barcode] = $prod;
                         }
                         $formData['listProduct'] = $newprod;
                     }
                 }
                 $formData['promotionproduct'] = $promotionglist;
             }
        }



        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                  'formData' => $formData,
                                             ));
        $this->registry->smarty->display($this->registry->smartyControllerContainer . 'promotioncombolist.tpl');
    }

    function showpromoproductlistAction()
    {
        $formData['promotionid'] = (int)($this->registry->router->getArg('id'));
        $formData['promotiongroupid'] = (int)($this->registry->router->getArg('gpid'));
        if(!empty($formData['promotionid']) && !empty($formData['promotiongroupid']))
        {
             $promotionglist = Core_Promotionlist::getPromotionlists(array(//'fpromogid'=> $formData['promotionid'],
                                                                            'fpromogid'=>$formData['promotiongroupid']
                                                                            ),'','');
             $listproductcombo = array();
             if(!empty($promotionglist))
             {
                 foreach($promotionglist as $pl)
                 {
                     $listproductcombo[] = trim($pl->pbarcode);
                 }

             }
             $formData['promotionproduct'] = Core_Product::getProducts(array('fpbarcodearr'=>$listproductcombo, 'fpricethan0' => 1),'','');
             //var_dump($formData['promotionproduct']);
        }



        $this->registry->smarty->assign(array(    'pageTitle'    => $this->registry->lang['controller']['pageTitle_list'],
                                                  'formData' => $formData,
                                             ));
        $this->registry->smarty->display($this->registry->smartyControllerContainer . 'promotionproductlist.tpl');
    }

    function syncerpajaxAction()
    {
        ini_set('memory_limit','1260M');
        $idFilter = (int)($this->registry->router->getArg('id'));
		if($idFilter > 0)
        {
            set_time_limit(0);
            $checkPromo = new Core_Promotion($idFilter);
            /*if($checkPromo->id > 0) {
                echo json_encode(array('fail' => 1));
                return;
            }*/
            $sql = 'SELECT pr.*
                    FROM ERP.VW_PROMOTIONSUMARY_DM pr
                    WHERE pr.PROMOTIONID = '.$idFilter. '';// AND ISACTIVE = 1  AND (pr.DESCRIPTION IS NOT NULL OR pr.DESCRIPTION !=\'\')
            $oracle = new Oracle();
            $result = $oracle->query($sql);

            /*if(count($result) == 0)
            {
                echo json_encode(array('fail' => 1));
                return;
            }*/
            foreach($result as $res)
            {
                //kiem tra neu promotion da het hang
                $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $res['ENDDATE']);
                $datechk =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'), $dateUpdated->format('H:i:s'));
                if ($datechk < time() || $res['ISDELETE'] == 1 || $res['ISACTIVE'] == 0)
                {
					$promodelid = (int)$res['PROMOTIONID'];
					$getAllpromotionGroup = $this->registry->db->query('SELECT promog_id FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id ='.(int)$promodelid);
			        if(!empty($getAllpromotionGroup))
			        {
			            while($rgprow = $getAllpromotionGroup->fetch())
			            {
			                $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotionlist WHERE promog_id = '.(int)$rgprow['promog_id']);
			            }
			        }
			        unset($getAllpromotionGroup);
			        $this->expriedproductpromotion($promodelid);

			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id = '.(int)$promodelid);
			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotion_combo WHERE promo_id = '.(int)$promodelid);
			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotion_exclude WHERE promo_id = '.(int)$promodelid);
			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotion_outputtype WHERE promo_id = '.(int)$promodelid);
			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotion_store WHERE promo_id = '.(int)$promodelid);
			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotion_product WHERE promo_id = '.(int)$promodelid);
			        $this->registry->db->query('DELETE FROM '.TABLE_PREFIX.'promotion WHERE promo_id = '.(int)$promodelid);
					continue;
                }

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

                $promotion->isunlimited                 = $res['ISLIMITPROMOTIONTIMES'];
                $promotion->timepromotion               = $res['MAXPROMOTIONTIMES'];
                $promotion->islimittimesoncustomer      = $res['ISLIMITTIMESONCUSTOMER'];
                $promotion->isdeleted      				= $res['ISDELETE'];

                $promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
                $promotion->enddate                     = $this->formatTime($res['ENDDATE']);
                $promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
                $promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');

                //Get promotion apply product list
                //$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                $promotionapplyproductlist = array();
                $countAllapplyproduct = $oracle->query('SELECT COUNT(*) FROM ERP.VW_PROMOTIONINFO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

                foreach($countAllapplyproduct as $count)
                {
                    $numofproductapplyrow = $count['COUNT(*)'];
                    if($numofproductapplyrow <= 500)
                    {
                        $promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONINFO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    }
                    else{
						for ($ctnpa = 0; $ctnpa < $numofproductapplyrow; $ctnpa+=500)
						{
							$promoapplylist = $oracle->query('SELECT * FROM
																(SELECT pa.*, ROWNUM r FROM ERP.VW_PROMOTIONINFO_DM pa WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']
																.') WHERE r > '.$ctnpa.' AND r <= '.($ctnpa + 500).''
															);
							if (!empty($promoapplylist))
							{
								$promotionapplyproductlist = array_merge_recursive($promotionapplyproductlist, $promoapplylist);
							}
						}
                    }
                    break;
                }
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
                            if(!in_array($promoapplyproduct['PRODUCTID'], $excludeapplyproduct)) $excludeapplyproduct[] = $promoapplyproduct['PRODUCTID'];
                            if(!in_array($promoapplyproduct['AREAID'], $excludeapplyarea)) $excludeapplyarea[] = $promoapplyproduct['AREAID'];

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
                if(!empty($excludeapplyproduct) && !empty($excludeapplyarea))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_product
                                                WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND p_barcode NOT IN ('."'".implode("','",$excludeapplyproduct)."'".') AND a_id NOT IN ('.implode(',',$excludeapplyarea).')'
                                               );
                }
                else {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_product
                                                WHERE promo_id = '.(int)$res['PROMOTIONID']
                                               );
                }

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
                            if(!in_array($promoapplystore['STOREID'], $excludeapplystore)) $excludeapplystore[] = $promoapplystore['STOREID'];

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
                if(!empty($excludeapplystore))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_store
                                                WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND s_id NOT IN ('.implode(',',$excludeapplystore).')'
                                               );
                }
                else {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_store
                                                WHERE promo_id = '.(int)$res['PROMOTIONID']
                                               );
                }


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
                                $listCombo = $oracle->query('SELECT * FROM ERP.VW_COMBO_DM s WHERE s.PRODUCTCOMBOID = '.(int)$combo['PRODUCTCOMBOID']);
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
                                $getComboProduct = $oracle->query('SELECT count(*) FROM ERP.VW_COMBO_PRODUCT pr WHERE pr.PRODUCTCOMBOID="'.$combo['PRODUCTCOMBOID'].'" AND PRODUCTID='.$combo['PRODUCTID']);
                                if(!empty($getComboProduct))
                                {
                                    $getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID='.$combo['PRODUCTID']);
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
                                if(!in_array($combo['PRODUCTCOMBOID'], $excludepromotioncombo)) $excludepromotioncombo[] = $combo['PRODUCTCOMBOID'];

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
                if(!empty($excludepromotioncombo))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_combo
                                                WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND co_id NOT IN ('."'".implode("','",$excludepromotioncombo)."'".')'
                                               );
                }
                else {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_combo
                                                WHERE promo_id = '.(int)$res['PROMOTIONID']
                                               );
                }

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

                            if(!in_array($promoexclude['EXCLUDEPROMOTIONID'], $excludepromotionexclude)) $excludepromotionexclude[] = $promoexclude['EXCLUDEPROMOTIONID'];
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
                if(!empty($excludepromotionexclude))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_exclude
                                                WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND promoe_id NOT IN ('.implode(',',$excludepromotionexclude).')'
                                               );
                }
                else {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_exclude
                                                WHERE promo_id = '.(int)$res['PROMOTIONID']
                                               );
                }


                //update promotion group
                $excludepromotiongroup = array();
                if(!empty($promotiongroup))
                {
                    foreach($promotiongroup as $promogroup)
                    {
                        if(!empty($promogroup['PROMOTIONID']) && !empty($promogroup['PROMOTIONLISTGROUPID']))
                        {
                            $promotionGroup = new Core_Promotiongroup();
                            $checkpromotionstore = Core_Promotiongroup::getPromotiongroups(array('fid'=>$promogroup['PROMOTIONLISTGROUPID']),'','',1);

                            if(!in_array($promogroup['PROMOTIONLISTGROUPID'], $excludepromotiongroup)) $excludepromotiongroup[] = $promogroup['PROMOTIONLISTGROUPID'];

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
                if(!empty($excludepromotiongroup))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotiongroup
                                                WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND promog_id NOT IN ('.implode(',',$excludepromotiongroup).')'
                                               );
                }
                else {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotiongroup
                                                WHERE promo_id = '.(int)$res['PROMOTIONID']
                                               );
                }

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

                            if(!in_array($grouplist['PROMOTIONLISTGROUPID'], $excludepromotionlistgroup)) $excludepromotionlistgroup[] = $grouplist['PROMOTIONLISTGROUPID'];
                            if (empty($excludepromotionlistgroupbarcode)) {
                                $excludepromotionlistgroupbarcode[] = $grouplist['PRODUCTID'];
                            } elseif(is_array($excludepromotionlistgroupbarcode) && !in_array((string)$grouplist['PRODUCTID'], $excludepromotionlistgroupbarcode)) {
                                $excludepromotionlistgroupbarcode[] = $grouplist['PRODUCTID'];
                            }

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
                if(!empty($excludepromotionlistgroup) && !empty($excludepromotionlistgroupbarcode))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotionlist
                                                WHERE promog_id NOT IN ('.implode(',',$excludepromotionlistgroup).') AND p_barcode NOT IN ('."'".implode("','",$excludepromotionlistgroupbarcode)."'".')'
                                               );
                }

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
                            if(!in_array($outputtype['OUTPUTTYPEID'], $excludepromotionoutputtype))  $excludepromotionoutputtype[] = $outputtype['OUTPUTTYPEID'];
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
                if(!empty($excludepromotionoutputtype))
                {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_outputtype
                                                WHERE promo_id = '.(int)$res['PROMOTIONID'].' AND po_id NOT IN ('.implode(',',$excludepromotionoutputtype).')'
                                               );
                }
                else {
                    $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_outputtype
                                                WHERE promo_id = '.(int)$res['PROMOTIONID']
                                               );
                }
                $totalrecord++;
                $this->updateproductpricebypromotionid(trim($res['PROMOTIONID']));
            }
            echo json_encode(array('success' => 1));
        }
    }

    function deletepromotionbyidajaxAction()
    {
        set_time_limit(0);
        $idFilter = (int)($this->registry->router->getArg('id'));
        if($idFilter > 0)
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
                $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_product
                                                WHERE promo_id = '.$promotion->id
                                               );
                $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_store
                                                                WHERE promo_id = '.$promotion->id
                                                               );
                $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_combo
                                                                WHERE promo_id = '.$promotion->id
                                                               );
                $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_exclude
                                                                WHERE promo_id = '.$promotion->id
                                                               );

                $getpromotiongroup = Core_Promotiongroup::getPromotiongroups(array('fpromoid' => $promotion->id), '', '');
                if(!empty($getpromotiongroup))
                {
                    $listpromogrouplistid = array();
                    foreach($getpromotiongroup as $promogroup)
                    {
                        $listpromogrouplistid[] = $promogroup->id;
                    }
                    if(!empty($listpromogrouplistid))
                    {
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotiongroup
                                                                WHERE promo_id = '.$promotion->id
                                                               );
                        $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotionlist
                                                                WHERE promog_id IN ('.implode(',',$listpromogrouplistid).')'
                                                               );
                    }
                }
                $this->registry->db->query('DELETE FROM ' . TABLE_PREFIX . 'promotion_outputtype
                                                                WHERE promo_id = '.$promotion->id
                                                               );
                $promotion->delete();
                echo json_encode(array('success' => 1));
            }
            else echo json_encode(array('fail' => 1));
        }
        else echo json_encode(array('fail' => 1));

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

    private function updateproductpricebypromotionid($promoid)
    {
        if(empty($promoid)) return false;
        //tim tat cac cac product cua promotion
        $listproduct = Core_PromotionProduct::getPromotionProducts(array('fpromoid' => $promoid),'','');
        if(!empty($listproduct))
        {
			foreach($listproduct as $product)
			{
				$barcode = trim($product->pbarcode);
				$findallpromotionsofproduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => $barcode),'','');
				if(!empty($findallpromotionsofproduct))
				{
					$listpromo = array();
					foreach($findallpromotionsofproduct as $findpromo)
					{
						if(!in_array($findpromo->promoid, $listpromo)) $listpromo[] = $findpromo->promoid;
					}
					if(!empty($listpromo))
					{
						$this->savepromotionproductprice($listpromo);
					}
				}
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

    public function importpromotioncloneAction()
    {
        set_time_limit(0);
        $formData = array();
        $success = array();
        $error = array();
        $warning = array();


        if(isset($_POST['fsubmit'])) {
            if($this->importpromotioncloneActionValidator($formData, $error)) {

                $formData = array_merge($formData , $_POST);
                $tmpName = $_FILES['ffile']['tmp_name'];
                //////READ CONTENT CSV FILE
                if (($handle = fopen($tmpName, "r")) !== FALSE) {
                    $i = 0;
                    $ok = false;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                    {
                        if( $i > 0 )
                        {
                            $promotion = new Core_Promotion((int)$data[0] , true);
                            if ($promotion->id > 0) {
                                $promotion->descriptionclone = $data[1];

                                if($promotion->updateData()) {
                                    $ok = true;
                                }
                                else {
                                    $ok = false;
                                }
                            }

                        }
                        $i++;
                    }
                    if($ok)
                        $success[] = 'Import promtion clone thành công';
                    else
                        $error[] = 'Có lỗi xảy ra trong quá trình import promotion clone.';

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
        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'importpromtionclone.tpl');
        $this->registry->smarty->assign(array(
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProduct->name,
                                                'contents'             => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

    }

    private function importpromotioncloneActionValidator($formData , &$error)
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
                            /*$updateProduct = new Core_Product($myproduct->id);

                            $updateProduct->updateData();*/
                            $promotionlisttext = '';
                            if(!empty($arrupdate)) {
                                $promotionlisttext = implode('###', $arrupdate);
                            }
                            $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ? WHERE p_id = ?';
                        	$this->registry->db->query($sql, array($promotionlisttext, $myproduct->id));
                        }
                    }
                }
            }
            unset($listallProductPromotion);
            $recordaffect++;
        }
        unset($promotion);
    }

	/**
	 * Test Promotion combination
	 */
	function combineAction()
	{
		$promotionList = array(1, 2, 3, 4, 5, 6);
		$excludeList = array(
			2 => array(3),
			3 => array(1,4),
			4 => array(1, 5),
			5 => array(3,1),
		);
		echodebug(Helper::combinePromotion($promotionList, $excludeList));
	}
}
