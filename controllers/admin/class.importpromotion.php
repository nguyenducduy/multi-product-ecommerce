<?php

Class Controller_Admin_Importpromotion Extends Controller_Admin_Base
{    
    public function indexAction()
    {
        //echo 'XIN HAO: '.'10-JUN-12 10.29.31.000000000 PM';
        //var_dump($this->formatTime('10-JUN-12 10.29.31.000000000 PM', true));
    }
    
    /*
    Userid bÃƒÂªn bÃƒÂ¡o cÃƒÂ¡o nÃ¡Â»â„¢i bÃ¡Â»â„¢ lÃƒÂ  type lÃƒÂ  sÃ¡Â»â€˜ 4 vÃƒÂ  lÃ¡ÂºÂ¥y value tÃ¡Â»Â« cÃ¡Â»â„¢t authen uid
    */
    
    public function importPromotionAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONSUMARY_DM pr');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONSUMARY_DM pr )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if((int)$res['PROMOTIONID'] > 0)
                {
                    $promotion = new Core_Promotion();
                    $checkproduct = Core_Promotion::getPromotions(array('fid'=>$res['PROMOTIONID']),'','',1);
                    if(empty($checkproduct))
                    {
                        $promotion->id                          = $res['PROMOTIONID'];
                        $promotion->usercreate                  = $res['USERCREATE'];
                        $promotion->useractive                  = $res['USERACTIVE'];
                        $promotion->userdelete                  = $res['USERDELETE'];
                        $promotion->name                        = $res['PROMOTIONNAME'];
                        $promotion->shortdescription            = $res['SHORTDESCRIPTION'];
                        $promotion->description                 = $res['DESCRIPTION'];
                        $promotion->descriptionclone                 = $res['DESCRIPTION'];
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
                        $promotion->startpromotionbyhour        = $this->formatTime($res['STARTTIME']);
                        $promotion->endpromotionbyhour          = $this->formatTime($res['ENDTIME']);
                        $promotion->isloyalty                   = $res['ISMEMBERSHIPPROMOTION'];
                        $promotion->isnotloyalty                = $res['ISNOTAPPLYFORMEMBERSHIP'];
                        //$promotion->isimei                      = $this->formatTime($res['']);
                        
                        $promotion->iscombo                     = $res['ISCOMBO'];
                        $promotion->isactived                     = $res['ISACTIVE'];
                        $promotion->isshowvat                   = $res['ISSHOWVATINVOICEMESSAGE'];
                        $promotion->messagevat                  = $res['VATINVOICEMESSAGE'];
                        
                        $promotion->isunlimited                 = $res['ISLIMITPROMOTIONTIMES'];
                        $promotion->timepromotion               = $res['MAXPROMOTIONTIMES'];
                        $promotion->islimittimesoncustomer      = $res['ISLIMITTIMESONCUSTOMER'];                   
                        
                        $promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
                        $promotion->enddate                     = $this->formatTime($res['ENDDATE']);
                        $promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
                        $promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');
                        
                        $promotion->addDataID();
                        file_put_contents('importPromotionAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID']);
                    }                    
                }
            }
        }
    }
    
    public function importPromotionStoreAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONAPPLYSCOPE_DM pr WHERE PROMOTIONID');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONAPPLYSCOPE_DM pr WHERE PROMOTIONID )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PROMOTIONID']) && !empty($res['STOREID']))
                {
                    $promotionStore = new Core_PromotionStore();
                    $checkpromotionstore = Core_PromotionStore::getPromotionStores(array('fpromoid'=>$res['PROMOTIONID'],'fsid'=>$res['STOREID']),'','',1);
                    if(empty($checkpromotionstore))
                    {
                        $promotionStore->promoid = $res['PROMOTIONID'];
                        $promotionStore->sid = $res['STOREID'];
                        $promotionStore->addData();
                        file_put_contents('importPromotionStoreAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID'].' STOREID: '.$res['STOREID']);
                    }
                }                
            }
        }
    }
    
    public function importPromotionGroupAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONGROUP_DM pr WHERE PROMOTIONID');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONGROUP_DM pr WHERE PROMOTIONID )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PROMOTIONID']) && !empty($res['PROMOTIONLISTGROUPID']))
                {
                    $promotionGroup = new Core_Promotiongroup();
                    $checkpromotionstore = Core_Promotiongroup::getPromotiongroups(array('fid'=>$res['PROMOTIONLISTGROUPID']),'','',1);//$promotion->getData($res['PROMOTIONLISTGROUPID']);
                    if(empty($checkpromotionstore))
                    {
                        $promotionGroup->id = $res['PROMOTIONLISTGROUPID'];
                        $promotionGroup->promoid = $res['PROMOTIONID'];
                        $promotionGroup->name = $res['PROMOTIONLISTGROUPNAME'];
                        $promotionGroup->isfixed = $res['ISFIXED'];
                        $promotionGroup->isdiscount = $res['ISDISCOUNT'];
                        $promotionGroup->discountvalue = $res['DISCOUNTVALUE'];
                        $promotionGroup->isdiscountpercent = $res['ISPERCENTDISCOUNT'];
                        $promotionGroup->iscondition = $res['ISCONDITION'];
                        $promotionGroup->conditioncontent = $res['CONDITIONCONTENT'];
                        $promotionGroup->type = $res['PROMOTIONLISTGROUPTYPE'];                        
                        $promotionGroup->addDataID();
                        echo '<p>Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONLISTGROUPID: '.$res['PROMOTIONLISTGROUPID'].'</p>';
                        file_put_contents('importPromotionGroupAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONLISTGROUPID: '.$res['PROMOTIONLISTGROUPID']);
                    }
                }                
            }
        }
    }
    
    public function importPromotionListAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONLISTGROUP_DM pr');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);
        set_time_limit(0);
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);            

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONLISTGROUP_DM pr )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PROMOTIONLISTGROUPID']) && !empty($res['PRODUCTID']))
                {
                    $promotionGroupList = new Core_Promotionlist();
                    $checkpromotionlist = Core_Promotionlist::getPromotionlists(array('fpbarcode'=>$res['PRODUCTID'],'fpromogid'=>$res['PROMOTIONLISTGROUPID']),'','',1);
                    if(empty($checkpromotionlist))
                    {
                        $promotionGroupList->promogid = $res['PROMOTIONLISTGROUPID'];
                        $promotionGroupList->pbarcode = $res['PRODUCTID'];
                        $promotionGroupList->iscombo = $res['ISCOMBO'];
                        $promotionGroupList->price = $res['PROMOTIONPRICE'];
                        $promotionGroupList->quantity = $res['QUANTITY'];
                        $promotionGroupList->ispercentcalc = $res['ISPERCENTCALC'];                        
                        $promotionGroupList->imei = $res['IMEI'];
                        $promotionGroupList->imeipromotionid = $res['IMEIPRODUCTID'];
                        $promotionGroupList->dateadd = time();
                        $promotionGroupList->datemodify = time();
                        
                        $promotionGroupList->addData();
                        file_put_contents('importPromotionListAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PRODUCTID: '.$res['PRODUCTID'].' PROMOTIONLISTGROUPID: '.$res['PROMOTIONLISTGROUPID']);
                    }
                }                
            }
        }
    }
    
    public function importPromotionOutputTypeAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM pr WHERE PROMOTIONID');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM pr WHERE PROMOTIONID )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PROMOTIONID']) && !empty($res['OUTPUTTYPEID']))
                {
                    $promotionOutputtype = new Core_PromotionOutputtype();
                    $checkpromotionlist = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromoid'=>$res['PROMOTIONID'],'fpoid'=>$res['OUTPUTTYPEID']),'','',1);
                    if(empty($checkpromotionlist))
                    {
                        $promotionOutputtype->promoid = $res['PROMOTIONID'];
                        $promotionOutputtype->poid = $res['OUTPUTTYPEID'];
                        $promotionOutputtype->addData();
                        file_put_contents('importPromotionOutputTypeAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID'].' OUTPUTTYPEID: '.$res['OUTPUTTYPEID']);
                    }
                }                
            }
        }
        
    }
    
    public function importPromotionExcludeAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONEXCLUDE_DM pr WHERE PROMOTIONID');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONEXCLUDE_DM pr WHERE PROMOTIONID )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PROMOTIONID']) && !empty($res['EXCLUDEPROMOTIONID']))
                {
                    $PromotionExclude = new Core_PromotionExclude();
                    $checkpromotionlist = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=>$res['PROMOTIONID'],'fpromoeid'=>$res['EXCLUDEPROMOTIONID']),'','',1);
                    if(empty($checkpromotionlist))
                    {
                        $PromotionExclude->promoid = $res['PROMOTIONID'];
                        $PromotionExclude->promoeid = $res['EXCLUDEPROMOTIONID'];
                        $PromotionExclude->addData();
                        file_put_contents('importPromotionExcludeAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID'].' EXCLUDEPROMOTIONID: '.$res['EXCLUDEPROMOTIONID']);
                    }
                }                
            }
        }
        
    }
    
    public function importPromotionProductAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM pr WHERE PROMOTIONID ');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM pr WHERE PROMOTIONID )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PROMOTIONID']) && !empty($res['PRODUCTID']) && !empty($res['AREAID']))
                {
                    $PromotionProduct = new Core_PromotionProduct();
                    $checkpromotionlist = Core_PromotionProduct::getPromotionProducts(array('fpbarcode'=>$res['PRODUCTID'],'fpromoid'=>$res['PROMOTIONID'],'faid'=>$res['AREAID']),'','',1);
                    if(empty($checkpromotionlist))
                    {
                        //$promotionGroupList->pid = $res['PROMOTIONLISTGROUPID'];
                        //$promotionGroupList->pbarcode = $res['PROMOTIONID'];
                        $PromotionProduct->pbarcode = $res['PRODUCTID'];
                        $PromotionProduct->promoid = $res['PROMOTIONID'];
                        $PromotionProduct->aid = $res['AREAID'];
                        $PromotionProduct->addData();
                        echo '<p>Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID'].' PRODUCTID: '.$res['PRODUCTID'].' INPUT TYPE '.$res['INPUTTIME'].'</p>';
                        file_put_contents('importPromotionProductAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID'].' PRODUCTID: '.$res['PRODUCTID'].' INPUT TYPE '.$res['INPUTTIME']);
                    }
                }                
            }
        }
    }
    
    public function importComboAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_COMBO_DM pr');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_COMBO_DM pr )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            foreach($result as $res)
            {
                if(!empty($res['PRODUCTCOMBOID']))
                {
                    
                    $checkpromotionlist = Core_Combo::getCombos(array('fid'=>$res['PRODUCTCOMBOID']),'','',1);//$combo->getData($res['PRODUCTCOMBOID']);
                    $combo = new Core_Combo();
                    if(empty($checkpromotionlist))
                    {
                        $combo->id = $res['PRODUCTCOMBOID'];
                        $combo->name = $res['PRODUCTCOMBONAME'];
                        $combo->description = $res['DESCRIPTION'];
                        $combo->isactive = $res['ISACTIVE'];
                        $combo->addData();
                        file_put_contents('importComboAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PRODUCTCOMBOID: '.$res['PRODUCTCOMBOID']);
                    }
                }                
            }
        }
    }
    
    public function importPromotionComboAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_PROMOTIONCOMBO_DM pr WHERE PROMOTIONID');        
        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_PROMOTIONCOMBO_DM pr WHERE PROMOTIONID )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);
            
            foreach($result as $res)
            {    
                if(!empty($res['PROMOTIONID']) && !empty($res['PRODUCTCOMBOID']))
                {
                    $PromotionProduct = new Core_PromotionCombo();
                    $checkpromotionlist = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=>$res['PROMOTIONID'],'fcoid'=>$res['PRODUCTCOMBOID']),'','',1);
                    
                    if(empty($checkpromotionlist))
                    {
                        $PromotionProduct->promoid = $res['PROMOTIONID'];
                        $PromotionProduct->coid = $res['PRODUCTCOMBOID'];
                        /*$PromotionProduct->type = $res['COMBOTYPE'];
                        $PromotionProduct->value = round($res['VALUE']*(1+$getProductDetailFromERP[0]['VAT'] * $getProductDetailFromERP[0]['VATPERCENT']/10000)); 
                        $PromotionProduct->quantity = $res['QUANTITY'];
                        $PromotionProduct->displayorder = $res['ORDERINDEX'];*/
                        $PromotionProduct->addData();
                        //echodebug($PromotionProduct, true);
                        //cÃ¡ÂºÂ­p nhÃ¡ÂºÂ­t trÃ¡ÂºÂ¡ng thÃƒÂ¡i delete cÃ¡Â»Â§a combo
                        if(!empty($res['PRODUCTCOMBOID']))
                        {
                            $combo = new Core_Combo($res['PRODUCTCOMBOID']);
                            $combo->isdeleted = $res['ISDELETE'];
                            $combo->updateData();
                        }                            
                        
                        file_put_contents('importPromotionComboAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID'].' PRODUCTID: '.$res['PRODUCTID']);
                    }                   
                }
                //else echo     $res['PRODUCTID'].' '.$res['PROMOTIONID'].' '.$res['PRODUCTCOMBOID']  .'<br/>'          ;
            }
        }
    }
    
    public function importProductComboAction()
    {
        $recordPerPage = 2000;
        $oracle = new Oracle();
        $countAll = $oracle->query('SELECT count(*) FROM ERP.VW_COMBO_PRODUCT pr');        
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }        
 
        $page = ceil($total/$recordPerPage);

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pr.*, ROWNUM r FROM ERP.VW_COMBO_PRODUCT pr )  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);
            
            foreach($result as $res)
            {
                if(!empty($res['PRODUCTID']) && !empty($res['PRODUCTCOMBOID']))
                {
                    $getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID='.$res['PRODUCTID']);
                    
                    if(!empty($getProductDetailFromERP[0]))
                    {
                        $PromotionProduct = new Core_RelProductCombo();
                        $checkpromotionlist = Core_RelProductCombo::getRelProductCombos(array('fpbarcode'=>$res['PRODUCTID'],'fcoid'=>$res['PRODUCTCOMBOID']),'','',1);
                        
                        if(empty($checkpromotionlist))
                        {
                            $PromotionProduct->pbarcode = $res['PRODUCTID'];
                            $PromotionProduct->coid = $res['PRODUCTCOMBOID'];
                            $PromotionProduct->type = $res['COMBOTYPE'];
                            $PromotionProduct->value = round($res['VALUE']*(1+$getProductDetailFromERP[0]['VAT'] * $getProductDetailFromERP[0]['VATPERCENT']/10000)); 
                            $PromotionProduct->quantity = $res['QUANTITY'];
                            $PromotionProduct->displayorder = $res['ORDERINDEX'];
                            $PromotionProduct->addData();
                            //echodebug($PromotionProduct, true);
                        
                            file_put_contents('importProductComboAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['COMBOID'].' PRODUCTID: '.$res['PRODUCTID']);
                        }
                    }                    
                }
                //else echo     $res['PRODUCTID'].' '.$res['PROMOTIONID'].' '.$res['PRODUCTCOMBOID']  .'<br/>'          ;
            }
        }
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
     
    function importProductPromotionAction()
    {//PHAI CHECK LAI TRUONG HOP CO PRODUCTID REF DE MAP VOI PRODUCT ID XEM CO CHUA MOI THEM MOI
        $pcid = (int)($_GET['pcid']);
        if(empty($pcid)) exit('Chon category de import product promotion');
        $recordPerPage = 500;
        $oracle = new Oracle();
        //$today = strtoupper(date('d-M-y' , time()));
        $sql = 'SELECT count(*) FROM ERP.VW_PROMOTIONPRODUCT WHERE PRODUCTIDREF = 0 OR PRODUCTIDREF is null';// WHERE DATEUPDATE >= TO_DATE(\' '.$today.' \')';
        $productStockList = $oracle->query($sql);

        $countAll = $oracle->query($sql);
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;//WHERE pr.DATEUPDATE >= TO_DATE(\' '.$today.' \') 
            $sql = 'SELECT * FROM ( 
                                    SELECT pr.*, ROWNUM r 
                                    FROM ERP.VW_PROMOTIONPRODUCT pr
                                    WHERE PRODUCTIDREF = 0 OR PRODUCTIDREF is null
                                    )  
                              WHERE r > '.$start.' AND r <= '.$end.'';
            $result = $oracle->query($sql);
            foreach($result as $res)
            {
                $product = new Core_Product();
                $checkProductBarcode = Core_Product::getProducts(array('fbarcode' => $res['PRODUCTID']), '' , '', 1);
                if(empty($checkProductBarcode))
                {
                    $product->uid=1;
                    $product->id=$res['PRODUCTIDREF'];
                    $product->pcid=$pcid;
                    $product->barcode=$res['PRODUCTID'];
                    $product->name=$res['PRODUCTNAME'];
                    $product->slug=Helper::codau2khongdau($res['PRODUCTNAME'], true, true);
                    $product->content=$res['PRODUCTDESCRIPTION'];
                    $product->summary=$res['ABC'];
                    $product->seotitle=$res['PRODUCTNAME'];
                    $product->seokeyword=$res['PRODUCTDESCRIPTION'];
                    $product->seodescription=$res['PRODUCTDESCRIPTION'];
                    $product->status= Core_Product::STATUS_ENABLE;
                    $product->colorlist='no';
                    $product->datecreated=time();
                    $product->importProduct();
                    echo 'BARCODE: '.$res['PRODUCTID'].' - '.$res['PRODUCTIDREF'];
                }
            }
        }
    }
    
    public function synpromotionidAction()
    {
        $promoid = isset($_GET['id'])?$_GET['id']:0;
        if($promoid <= 0) return false;
        $recordPerPage = 500;
        $oracle = new Oracle();
        set_time_limit(0);
        //echodebug($getLastestPromotion,true);
        $sql = 'SELECT count(*) FROM ERP.VW_PROMOTIONSUMARY_DM WHERE PROMOTIONID >= '.$promoid;
        
        $countAll = $oracle->query($sql);
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        $totalrecord = 0;
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;
            $sql = 'SELECT * FROM ( 
                                    SELECT pr.*, ROWNUM r 
                                    FROM ERP.VW_PROMOTIONSUMARY_DM pr
                                    WHERE pr.promotionid >= '.$promoid.' )  
                              WHERE r > '.$start.' AND r <= '.$end.'';
            $result = $oracle->query($sql);
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
                $promotion->startpromotionbyhour        = $this->formatTime($res['STARTTIME']);
                $promotion->endpromotionbyhour          = $this->formatTime($res['ENDTIME']);
                $promotion->isloyalty                   = $res['ISMEMBERSHIPPROMOTION'];
                $promotion->isnotloyalty                = $res['ISNOTAPPLYFORMEMBERSHIP'];
                $promotion->isactived                   = $res['ISACTIVE'];
                $promotion->iscombo                     = $res['ISCOMBO'];
                $promotion->isshowvat                   = $res['ISSHOWVATINVOICEMESSAGE'];
                $promotion->messagevat                  = $res['VATINVOICEMESSAGE'];
                
                $promotion->isunlimited                 = $res['ISLIMITPROMOTIONTIMES'];
                $promotion->timepromotion               = $res['MAXPROMOTIONTIMES'];
                $promotion->islimittimesoncustomer      = $res['ISLIMITTIMESONCUSTOMER'];                   
                
                $promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
                $promotion->enddate                     = $this->formatTime($res['ENDDATE']);
                $promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
                $promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');
                
                //Get promotion apply product list
                //$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                $promotionapplyproductlist = null;
                $countAllapplyproduct = $oracle->query('SELECT COUNT(*) FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                foreach($countAllapplyproduct as $count)
                {
                    if($count['COUNT(*)'] <= 500)
                    {
                        $promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                        break;
                    }
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
                            $PromotionProduct->pbarcode = trim($promoapplyproduct['PRODUCTID']);
                            $PromotionProduct->promoid = trim($promoapplyproduct['PROMOTIONID']);
                            $PromotionProduct->aid = trim($promoapplyproduct['AREAID']);
                            
                            $promoapplyproduct['PRODUCTID'] = trim($promoapplyproduct['PRODUCTID']);
                            if(!in_array($promoapplyproduct['PRODUCTID'], $excludeapplyproduct))$excludeapplyproduct[] = $promoapplyproduct['PRODUCTID'];
                            if(!in_array($promoapplyproduct['AREAID'], $excludeapplyarea))$excludeapplyarea[] = $promoapplyproduct['AREAID'];
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
                /*if($promotionapplyproductlist){
                    echodebug($excludeapplyarea);
                    echodebug($excludeapplyproduct, true);
                }*/
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
                                        s_id,
                                        s_name,
                                        s_address,
                                        s_region,
                                        s_phone,
                                        s_fax,
                                        s_datecreated
                                        )
                                    VALUES(?, ?, ?,?, ?, ?,?, ?)';
                                    $rowCount = $this->registry->db->query($sql, array(
                                        (int)$store['AREAID'],
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
                            
                            //$getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID='.$combo['PRODUCTID']);
                            //if(!empty($getProductDetailFromERP[0]))
                            //{
                                $PromotionProduct = new Core_PromotionCombo();
                                $checkpromotionlist = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=>$combo['PROMOTIONID'],'fcoid'=>$combo['PRODUCTCOMBOID']),'','',1);
                                
                                //$PromotionProduct->pbarcode = $combo['PRODUCTID'];
                                $PromotionProduct->promoid = $combo['PROMOTIONID'];
                                $PromotionProduct->coid = $combo['PRODUCTCOMBOID'];
                                /*$PromotionProduct->type = $combo['COMBOTYPE'];
                                $PromotionProduct->value = round($combo['VALUE']*(1+$getProductDetailFromERP[0]['VAT'] * $getProductDetailFromERP[0]['VATPERCENT']/10000));                        
                                $PromotionProduct->quantity = $combo['QUANTITY'];
                                $PromotionProduct->displayorder = $combo['ORDERINDEX'];*/
                                
                                if(!in_array($combo['PRODUCTCOMBOID'], $excludepromotioncombo)) $excludepromotioncombo[] = $combo['PRODUCTCOMBOID'];
                                //$excludepromotioncombopromotion[] = $combo['PROMOTIONID'];
                                
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
                            $grouplist['PRODUCTID'] = trim($grouplist['PRODUCTID']);
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
                            if(!in_array($grouplist['PRODUCTID'], $excludepromotionlistgroupbarcode)) $excludepromotionlistgroupbarcode[] = $grouplist['PRODUCTID'];
                            
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
                            $checkpromotionlist = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromooid'=>$outputtype['PROMOTIONID'],'fpoid'=>$outputtype['OUTPUTTYPEID']),'','',1);
                            if(!in_array($outputtype['OUTPUTTYPEID'], $excludepromotionoutputtype)) $excludepromotionoutputtype[] = $outputtype['OUTPUTTYPEID'];
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
                
                //echo 'DONE PROMOTIONID: '.$res['PROMOTIONID'].'<br />';
                //file_put_contents('synPromotionAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID']);
            }
        }
        
        echo 'Total record: '.$totalrecord.'. TOTAL PAGE: '.$page;
    }
    
    public function synpromotionavailableAction()
    {
        $recordPerPage = 100;
        $oracle = new Oracle();
        $today = strtoupper(date('d-M-y' , time()));
        //$getLastestPromotion = $this->registry->db->query('SELECT promo_id FROM ' . TABLE_PREFIX . 'promotion ORDER BY promo_id DESC LIMIT 1')->fetch();
        //echodebug($getLastestPromotion,true);
        $sql = 'SELECT count(*) FROM ERP.VW_PROMOTIONSUMARY_DM WHERE ENDDATE >= TO_DATE(\' '.$today.' \')';
        
        $sql_where = '';// ' AND PROMOTIONID = 141484';
        /*if(!empty($getLastestPromotion['promo_id']))
        {
            $sql_where = ' AND PROMOTIONID > '.$getLastestPromotion['promo_id'];
        }*/
        $countAll = $oracle->query($sql.$sql_where);
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        //echodebug($total. '    '.$recordPerPage .'   '.$page, true);
        $totalrecord = 0;
        set_time_limit(0);
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);           

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;
            $sql = 'SELECT * FROM ( 
                                    SELECT pr.*, ROWNUM r 
                                    FROM ERP.VW_PROMOTIONSUMARY_DM pr
                                    WHERE pr.ENDDATE >= TO_DATE(\' '.$today.' \') '.$sql_where.')  
                              WHERE r > '.$start.' AND r <= '.$end.'';
            $result = $oracle->query($sql);
            foreach($result as $res)
            {
                //update promotion, check combo, exclude promotion, scrope name, promotion apply, promotion list, promotion list group
                //check promotion id
                $checkpromotion = new Core_Promotion((int)$res['PROMOTIONID']);
                if($checkpromotion->id > 0) { echo 'CONTINE PAGE: '.$i.'----'.$res['PROMOTIONID'];continue;}
                else echo 'PAGE: '.$i.'----'.$res['PROMOTIONID'];
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
                $promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
                $promotion->enddate                     = $this->formatTime($res['ENDDATE']);
                $promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
                //$promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');
                //Get promotion apply product list
                //$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                $promotionapplyproductlist = null;
                $countAllapplyproduct = $oracle->query('SELECT COUNT(*) FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                foreach($countAllapplyproduct as $count)
                {
                    if($count['COUNT(*)'] <= 500)
                    {
                        $promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                        break;
                    }
                }
                //echodebug($promotionapplyproductlist,true);
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
                
                if($checkpromotion->id > 0) {echodebug('<p>EDIT</p>');
                    //if promotion exists                    
                    $promotion->updateData();                    
                }
                else {
                    //if promotion not exists                    
                    echodebug('<p>ADDTOP</p>');
                    $promotion->addDataID();
                    echodebug('<p>ADD</p>');
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
                            $PromotionProduct->pbarcode = trim($promoapplyproduct['PRODUCTID']);
                            $PromotionProduct->promoid = trim($promoapplyproduct['PROMOTIONID']);
                            $PromotionProduct->aid = trim($promoapplyproduct['AREAID']);
                            
                            $promoapplyproduct['PRODUCTID'] = trim($promoapplyproduct['PRODUCTID']);
                            if(!in_array($promoapplyproduct['PRODUCTID'], $excludeapplyproduct))$excludeapplyproduct[] = $promoapplyproduct['PRODUCTID'];
                            if(!in_array($promoapplyproduct['AREAID'], $excludeapplyarea))$excludeapplyarea[] = $promoapplyproduct['AREAID'];
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
                /*if($promotionapplyproductlist){
                    echodebug($excludeapplyarea);
                    echodebug($excludeapplyproduct, true);
                }*/
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
                            
                            //$getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID='.$combo['PRODUCTID']);
                            //if(!empty($getProductDetailFromERP[0]))
                            //{
                                $PromotionProduct = new Core_PromotionCombo();
                                $checkpromotionlist = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=>$combo['PROMOTIONID'],'fcoid'=>$combo['PRODUCTCOMBOID']),'','',1);
                                
                                //$PromotionProduct->pbarcode = $combo['PRODUCTID'];
                                $PromotionProduct->promoid = $combo['PROMOTIONID'];
                                $PromotionProduct->coid = $combo['PRODUCTCOMBOID'];
                                /*$PromotionProduct->type = $combo['COMBOTYPE'];
                                $PromotionProduct->value = round($combo['VALUE']*(1+$getProductDetailFromERP[0]['VAT'] * $getProductDetailFromERP[0]['VATPERCENT']/10000));                        
                                $PromotionProduct->quantity = $combo['QUANTITY'];
                                $PromotionProduct->displayorder = $combo['ORDERINDEX'];*/
                                
                                if(!in_array($combo['PRODUCTCOMBOID'], $excludepromotioncombo)) $excludepromotioncombo[] = $combo['PRODUCTCOMBOID'];
                                //$excludepromotioncombopromotion[] = $combo['PROMOTIONID'];
                                
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
                            $grouplist['PRODUCTID'] = trim($grouplist['PRODUCTID']);
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
                            if(!in_array($grouplist['PRODUCTID'], $excludepromotionlistgroupbarcode)) $excludepromotionlistgroupbarcode[] = $grouplist['PRODUCTID'];
                            
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
                            $checkpromotionlist = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromooid'=>$outputtype['PROMOTIONID'],'fpoid'=>$outputtype['OUTPUTTYPEID']),'','',1);
                            if(!in_array($outputtype['OUTPUTTYPEID'], $excludepromotionoutputtype)) $excludepromotionoutputtype[] = $outputtype['OUTPUTTYPEID'];
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
                echo $res['PROMOTIONID'].'<br />';
                //echo 'DONE PROMOTIONID: '.$res['PROMOTIONID'].'<br />';
                //file_put_contents('synPromotionAction.txt','Start: '.$start.' End: '.$end.' TOTAL PAGE: '.$page.' PROMOTIONID: '.$res['PROMOTIONID']);
            }
        }
        
        echo 'Total record: '.$totalrecord.'. TOTAL PAGE: '.$page;
    }
    
    function testAction()
    {
        var_dump(date('Y-m-d',$this->formatTime()));
    }
    
}

