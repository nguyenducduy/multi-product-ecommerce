<?php
ini_set('memory_limit','126M');
Class Controller_Cron_Promotion Extends Controller_Cron_Base
{
    function indexAction()
    {

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

    function importpromotionnewAction()
    {
        global $db;
        set_time_limit(0);
        $timer = new timer();
        $timer->start();
        $oracle = new Oracle();
        //$today = time();//date('Y/m/d');
        $today = date('Y/m/d H:i:s', strtotime('-3 day')); //lay truoc 3 ngay

        //Dau tien vo la tim promotion het han va delete no
        $currentdate = date('Y/m/d H:i:s');
        $sqlpromotion = 'SELECT PROMOTIONID FROM ERP.VW_PROMOTIONSUMARY_DM WHERE
                        ora_rowscn >= TIMESTAMP_TO_SCN(to_TimeStamp(\''.$today.'\', \'YYYY/MM/DD HH24:MI:SS\')) AND
                        (ISDELETE = 1 OR ISACTIVE = 0 OR to_char(ENDDATE, \'yyyy/mm/dd HH24:MI:SS\') < \''.$currentdate.'\' )';
        $promotionexpried = $oracle->query($sqlpromotion);
        if (!empty($promotionexpried))
        {
            foreach ($promotionexpried as $promodelete)
            {
                $promoid = $promodelete['PROMOTIONID'];
                $chkPromotion = new Core_Promotion((int)$promoid);

                if ($chkPromotion->id > 0)
                {
                    $getAllpromotionGroup = $db->query('SELECT promog_id FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id ='.(int)$promoid);
                    if(!empty($getAllpromotionGroup))
                    {
                        while($rgprow = $getAllpromotionGroup->fetch())
                        {
                            $db->query('DELETE FROM '.TABLE_PREFIX.'promotionlist WHERE promog_id = '.(int)$rgprow['promog_id']);
                        }
                    }
                    unset($getAllpromotionGroup);
                    $this->expriedproductpromotion($promoid);

                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id = '.(int)$promoid);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_combo WHERE promo_id = '.(int)$promoid);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_exclude WHERE promo_id = '.(int)$promoid);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_outputtype WHERE promo_id = '.(int)$promoid);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_store WHERE promo_id = '.(int)$promoid);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_product WHERE promo_id = '.(int)$promoid);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion WHERE promo_id = '.(int)$promoid);
                }
            }
        }

        $totalRecord = $db->query('SELECT count(*) FROM '. TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" AND p_sellprice > 0')->fetchColumn(0);
        $countererp++;
        $recordperpage = 500;
        $totalPage = ceil($totalRecord / $recordperpage);
        $totalaffected = 0;
        for($i = 0; $i < $totalPage; $i++ )
        {
            $offset = $i * $recordperpage;
            $sql = 'SELECT p_id,p_barcode  FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" AND p_sellprice > 0
                ORDER BY p_id DESC LIMIT ' . $offset . ', ' . $recordperpage;

            $stmt = $db->query($sql);
            while($row = $stmt->fetch())
            {
                $pbarcode = trim($row['p_barcode']);
                $this->synpromotionbybarcode($pbarcode);
                $this->synpromotionprice($pbarcode);
                $totalaffected++;
            }
        }
        $timer->stop();
        unset($totalRecord);
        echo $timer->get_exec_time().'<br />';
        echo 'Total affected: '.$totalaffected;
    }

    private function synpromotionbybarcode($barcode)
    {
        global $db;
        $oracle = new Oracle();
        $countererp = 0;
        //Tìm tất cả các promotion của product trên erp
        $today = strtoupper(date('d-M-y' , strtotime('-4 day')));
        $findpromotions = $oracle->query('SELECT DISTINCT PROMOTIONID FROM ERP.VW_PROMOTIONINFO_DM WHERE PRODUCTID = \''.$barcode.'\' AND DATEUPDATE >= TO_DATE(\''.$today.'\')');
        $countererp++;
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
                      $checkpromotionoutputtype = $oracle->query('SELECT COUNT(*) AS NUMPROMO FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE OUTPUTTYPEID IN (222, 8, 621, 3,201,601,801) AND PROMOTIONID = '.$promos['PROMOTIONID']);
                      $countererp++;
                      //741: xuat ban online trực tuyến
                      if($checkpromotionoutputtype[0]['NUMPROMO'] > 0)
                      {
                          $listpromotionids[] = $promos['PROMOTIONID'];
                      }
                      unset($checkpromotionoutputtype);
                  }
              }
          }
        }
        unset($findpromotions);
        //lấy promotion theo dạng combo
        $findcombolist = $oracle->query('SELECT distinct PRODUCTCOMBOID FROM ERP.VW_COMBO_PRODUCT  WHERE PRODUCTID = \''.$barcode.'\'');
        $countererp++;
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
              $countererp++;
              if(!empty($findpromotionlist))
              {
                  foreach($findpromotionlist as $promos)
                  {
                      $promos['PROMOTIONID'] = trim($promos['PROMOTIONID']);
                      if(!in_array($promos['PROMOTIONID'], $listpromotionids))
                      {
                          $checkpromotionoutputtype = $oracle->query('SELECT COUNT(*) AS NUMPROMO FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE OUTPUTTYPEID IN (222, 8, 621, 3,201,601,801) AND PROMOTIONID = '.$promos['PROMOTIONID']);
                          $countererp++;
                          //741: xuat ban online trực tuyến
                          if($checkpromotionoutputtype[0]['NUMPROMO'] > 0)
                          {
                              $listpromotionids[] = $promos['PROMOTIONID'];
                          }
                      }
                  }
              }
              unset($findpromotionlist);
          }
        }
        unset($findcombolist);
        //tìm promotion product cũ của barcode này trên csdl và  xóa nó
        $getlistoldpromotionproduct = $db->query('SELECT distinct promo_id FROM '.TABLE_PREFIX.'promotion_product WHERE p_barcode = "'.$barcode.'"');
        $listpromotiondeleted = array();
        $listpromotionidsnotindatabase = array();//tìm ra những promotion không nằm trong chỗ VW_PRoMOTIONINFO trên ERP
        if(!empty($getlistoldpromotionproduct))
        {
            while($rowpromoproducts = $getlistoldpromotionproduct->fetch())
            {
                if (!in_array($rowpromoproducts['promo_id'], $listpromotionids))
                {
                    //trường hợp ngành hàng xóa KM trong cái
                    if (!in_array($rowpromoproducts['promo_id'], $listpromotionidsnotindatabase)) $listpromotionidsnotindatabase[] = $rowpromoproducts['promo_id'];
                }
                if(!empty($listpromotionids))//trường hợp $listpromotionids có
                {
                    $rowpromoproducts['promo_id'] = trim($rowpromoproducts['promo_id']);
                    //Trường hợp promotion cần delete không nằm trong promotion mới tìm thấy
                    if( !in_array($rowpromoproducts['promo_id'], $listpromotionids))
                    {
                        if( !in_array($rowpromoproducts['promo_id'] ,$listpromotiondeleted))
                        {
                            $getonepromotion = new Core_Promotion($rowpromoproducts['promo_id']);
                            $currenthours = date('H') * 60 + date('m');
                            if($getonepromotion->status==Core_Promotion::STATUS_DISABLED || $getonepromotion->enddate < time() || $getonepromotion->isactived != 1 ||
                                ($getonepromotion->ispromotionbyhour == 1 &&
                                    ($getonepromotion->startpromotionbyhour > $currenthours || $getonepromotion->endpromotionbyhour < $currenthours)
                                )
                            )
                            {
                                $listpromotiondeleted[] = $rowpromoproducts['promo_id'];
                            }
                            unset($getonepromotion);
                        }
                    }
                }
                else {
                        $getonepromotion = new Core_Promotion($rowpromoproducts['promo_id']);
                        $currenthours = date('H') * 60 + date('m');
                        if($getonepromotion->status==Core_Promotion::STATUS_DISABLED || $getonepromotion->enddate < time() || $getonepromotion->isactived != 1 ||
                            ($getonepromotion->ispromotionbyhour == 1 &&
                                ($getonepromotion->startpromotionbyhour > $currenthours || $getonepromotion->endpromotionbyhour < $currenthours)
                            )
                        )
                        {
                            $listpromotiondeleted[] = $rowpromoproducts['promo_id'];
                        }
                        unset($getonepromotion);
                }


            }
        }

        unset($getlistoldpromotionproduct);

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
                        unset($getAllpromotionGroup);
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
            $sql = 'SELECT pr.* FROM ERP.VW_PROMOTIONSUMARY_DM pr WHERE pr.PROMOTIONID IN ('.implode(',', $listpromotionids).') AND (pr.DESCRIPTION IS NOT NULL OR pr.DESCRIPTION !=\'\') AND pr.ISACTIVE = 1 AND pr.ISDELETE = 0';// AND to_char(pr.ENDDATE, \'yyyy/mm/dd HH24:MI:SS\') >=\''.date('Y/m/d H:i:s').'\'

            $result = $oracle->query($sql);
            $countererp++;
            if(!empty($result))
            {
                $listpromotionidsavailable = array();
                $listexcludeproductapply = array();
                foreach($result as $res)
                {
                    //update promotion, check combo, exclude promotion, scrope name, promotion apply, promotion list, promotion list group
                    //check promotion id
                    //$checkpromotion = new Core_Promotion((int)$res['PROMOTIONID']);

                    $promotion = new Core_Promotion($res['PROMOTIONID']);

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
                    $promotion->isdeleted                   = $res['ISDELETE'];

                    $promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
                    $promotion->enddate                     = $this->formatTime($res['ENDDATE']);
                    $promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
                    $promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');

                    //Get promotion apply product list
                    //$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONINFO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONINFO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID'].' AND PRODUCTID = \''.$barcode.'\'');
                    $countererp++;
                    //get promotion apply store
                    $promotionapplystorelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYSCOPE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $countererp++;
                    //get promotion combo
                    $promotioncombolist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONCOMBO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $countererp++;
                    //get promotion exclude
                    $promotionexcludelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONEXCLUDE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $countererp++;
                    //get promotion group
                    $promotiongroup = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONGROUP_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $countererp++;
                    //get promotion group list
                    $promotiongrouplist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONLISTGROUP_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $countererp++;
                    //get promotion out put type
                    $promotionoutputtypelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
                    $countererp++;

                    if($promotion->id > 0) {
                        //if promotion exists
                        $promotion->updateData();
                    }
                    else {
                        //if promotion not exists
                        $promotion->id = $res['PROMOTIONID'];
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
                                if (!empty($listpromotionidsnotindatabase) && in_array($promoapplyproduct['PROMOTIONID'], $listpromotionidsnotindatabase))
                                {
                                    $keyspromodel = array_search($promoapplyproduct['PROMOTIONID'], $listpromotionidsnotindatabase);

                                    if (!empty($listpromotionidsnotindatabase[$keyspromodel])) unset($listpromotionidsnotindatabase[$keyspromodel]);
                                }
                                $PromotionProduct = new Core_PromotionProduct();
                                $checkpromotionlist = Core_PromotionProduct::getPromotionProducts(array('fpbarcode'=>$promoapplyproduct['PRODUCTID'],'fpromoid'=>$promoapplyproduct['PROMOTIONID'],'faid' => $promoapplyproduct['AREAID']),'','',1);
                                $PromotionProduct->pbarcode = $promoapplyproduct['PRODUCTID'];
                                $PromotionProduct->promoid = $promoapplyproduct['PROMOTIONID'];
                                $PromotionProduct->aid = $promoapplyproduct['AREAID'];

                                $promoapplyproduct['PRODUCTID'] = trim($promoapplyproduct['PRODUCTID']);
                                if(!in_array($promoapplyproduct['PRODUCTID'], $listexcludeproductapply)) $listexcludeproductapply[] = $promoapplyproduct['PRODUCTID'];
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
                                    $countererp++;
                                    if(!empty($listStores[0]))
                                    {
                                        $store = $listStores[0];
                                        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'store (
                                            a_id,
                                            ppa_id,
                                            s_id,
                                            s_name,
                                            s_storeaddress,
                                            s_region,
                                            s_storephonenum,
                                            s_storefax,
                                            s_issalestore,
                                            s_isinputstore,
                                            s_iswarrantystore,
                                            s_isautostorechange,
                                            s_isauxiliarystore,
                                            s_isactive,
                                            s_isdeleted,
                                            s_datecreated
                                            )
                                        VALUES(?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                                        $rowCount = $this->registry->db->query($sql, array(
                                            (int)$store['AREAID'],
                                            (int)$store['PRICEAREAID'],
                                            (int)$store['STOREID'],
                                            (string)$store['STORENAME'],
                                            (string)$store['STOREADDRESS'],
                                            (int)$store['PROVINCEID'],
                                            (string)$store['STOREPHONENUM'],
                                            (string)$store['STOREFAX'],
                                            (int)$store['ISSALESTORE'],
                                            (int)$store['ISINPUTSTORE'],
                                            (int)$store['ISWARRANTYSTORE'],
                                            (int)$store['ISAUTOSTORECHANGE'],
                                            (int)$store['ISAUXILIARYSTORE'],
                                            (int)$store['ISACTIVE'],
                                            (string)$store['ISDELETED'],
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
                    unset($promotionapplystorelist);
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
                                    $countererp++;
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
                                    $getComboProduct = $oracle->query('SELECT count(*) FROM ERP.VW_COMBO_PRODUCT pr WHERE pr.PRODUCTCOMBOID=\''.$combo['PRODUCTCOMBOID'].'\' AND PRODUCTID=\''.$combo['PRODUCTID'].'\'');
                                    $countererp++;
                                    if(!empty($getComboProduct))
                                    {
                                        $getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID=\''.$combo['PRODUCTID'].'\'');
                                        $countererp++;
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
                    unset($promotioncombolist);
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
                    unset($promotiongroup);
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
                    unset($promotiongrouplist);
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
                    unset($promotionoutputtypelist);
                    $totalrecord++;
                }

                /*if (!empty($listpromotionidsnotindatabase) && !empty($listexcludeproductapply) && count($listexcludeproductapply)  < 1001)
                {
                    //echo '<br />PROMOTION DELETED: ';
                    //echodebug($listpromotionidsnotindatabase);
                    $db->query('DELETE FROM '.TABLE_PREFIX.'promotion_product WHERE p_barcode NOT IN ("'.implode('","', $listexcludeproductapply).'") AND promo_id IN ('.implode(',',$listpromotionidsnotindatabase).')');
                }*/
                //$this->savepromotionproductprice($listpromotionids);  (khong can thiet vi co cai )
                unset($result);
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
        unset($findhighestpromotion);
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
                                            $discountpromotion = Core_Promotion::getFirstDiscountPromotionById($promoid, $rid);
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
                                                /*$updateProduct = new Core_Product($getProductBybarocde->id);
                                                $updateProduct->promotionlist = implode('###', $arrupdate);

                                                $updateProduct->updateData();*/
                                                $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ? WHERE p_id = ?';
                                                $this->registry->db->query($sql, array(implode('###', $arrupdate), $getProductBybarocde->id));
                                            }
                                            else{
                                                $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ? WHERE p_id = ?';
                                                $this->registry->db->query($sql, array('', $getProductBybarocde->id));
                                            }
                                        }
                                    }
                                }
                            }
                            unset($listpromotionproduct);
                        }
                    }
                }
                unset($getStoreList);
            }
        }
        unset($getPromoStoreList);
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

    //Ham nay de syn gia cua nhung sp km
    private function synpromotionprice($barcode)
    {
        $listpromotionids       = array();
        $listpromotionproducts  = array();
        $listpromotionobjs      = array();
        $listareaids            = array();
        //get promotion by product barcode
        $getPromotionByProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => $barcode), '', 'DESC', '');
        if (count($getPromotionByProduct) > 0)
        {
            $listpromotionidofproduct = array();
            foreach ($getPromotionByProduct as $promoproduct)
            {
                if (!in_array($promoproduct->promoid, $listpromotionidofproduct))   $listpromotionidofproduct[] = $promoproduct->promoid;
                if (!in_array($promoproduct->aid, $listareaids))                    $listareaids[] = $promoproduct->aid;
                $listpromotionproducts[$promoproduct->promoid][] = $promoproduct;
            }
            unset($promoproduct);
            unset($getPromotionByProduct);
            if (count($listpromotionidofproduct) > 0)
            {
                $getPromotionlist = Core_Promotion::getPromotions(array('fisavailable' => 1, 'fidarr' => $listpromotionidofproduct, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','','');
                if (count( $getPromotionlist ) > 0)
                {
                    foreach ($getPromotionlist as $promo)
                    {
                        if (!in_array($promo->id, $listpromotionids))
                        {
                            $listpromotionobjs[$promo->id]  = $promo;
                            $listpromotionids[]             = $promo->id;
                        }
                    }
                }
                else {//truong hop KM ko co thi update cot promotion list lai
                    $this->updatefinalpriceforproduct($barcode);
                    return false;
                }
            }
            else {//truong hop KM ko co thi update cot promotion list lai
                $this->updatefinalpriceforproduct($barcode);
                return false;
            }
        }
        else {//truong hop KM ko co thi update cot promotion list lai
            $this->updatefinalpriceforproduct($barcode);
            return false;
        }

        if(empty($listpromotionids)) {//truong hop KM ko co thi update cot promotion list lai
            $this->updatefinalpriceforproduct($barcode);
            return false;
        }

        //tim promotion giam gia cao nhat
        $findhighestpromotion = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $listpromotionids, 'fisdiscountvaluegreater' => 0),'discountvalue', 'DESC', '0, 1');
        $promoid = 0;
        if(!empty($findhighestpromotion))
        {
            $promoid = $findhighestpromotion[0]->promoid;

            if((int)$findhighestpromotion[0]->discountvalue > 0)
            {
                $pricediscount = array();
                $pricediscount['promogpid']     = $findhighestpromotion[0]->id;
                $pricediscount['promoid']       = $findhighestpromotion[0]->promoid;
                if((int)$findhighestpromotion[0]->isdiscountpercent > 0)
                {
                    $pricediscount['percent']       = 1; //giảm giá theo tỉ lệ %
                    $pricediscount['discountvalue'] = $findhighestpromotion[0]->discountvalue;
                }
                else{
                    $pricediscount['percent']       = -1; //giảm giá theo tỉ lệ %
                    $pricediscount['discountvalue'] = $findhighestpromotion[0]->discountvalue;
                }

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
                        $getStoreList = Core_Store::getStores(array('fidarr' => $liststoreids, 'faidarr' => $listareaids), '', '');
                        if(!empty($getStoreList))
                        {
                            $listRegions = array();
                            foreach($getStoreList as $st)
                            {
                                if(!in_array($st->region, $listRegions))
                                {
                                    $listRegions[] = $st->region;
                                }
                            }
                            if (!empty($listRegions))
                            {
                                //get product
                                $myProductPrice = $this->registry->db->query('SELECT p_id, p_sellprice FROM '.TABLE_PREFIX.'product WHERE p_barcode = ? LIMIT 1', array((string)$barcode))->fetch();
                                if (!empty($myProductPrice))
                                {
                                    $arrupdate = array();
                                    $finalprice = 0;
                                    foreach($listRegions as $rid)
                                    {
                                        $sellpriceproduct = Core_RelRegionPricearea::getPriceByProductRegion($barcode, $rid);//$myProductPrice['p_sellprice'];
                                        if ($sellpriceproduct < 1) $sellpriceproduct = $myProductPrice['p_sellprice'];
                                        if ($sellpriceproduct > 1)
                                        {
                                            if($pricediscount['percent'] == 1)
                                            {
                                                $sellpriceproduct = $sellpriceproduct - ($sellpriceproduct * $pricediscount['discountvalue']/100);
                                            }
                                            else
                                                $sellpriceproduct = $sellpriceproduct - $pricediscount['discountvalue'];
                                            $arrupdate[] = $rid.','.$promoid.','.$pricediscount['promogpid'].','.$sellpriceproduct;
                                        }
                                        if ($rid == 3) $finalprice = $sellpriceproduct;
                                    }
                                    if(!empty($arrupdate))
                                    {
                                        if ($finalprice > 1)
                                        {
                                            $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = ? WHERE p_id = ?';
                                            $this->registry->db->query($sql, array(implode('###', $arrupdate), (float)$finalprice, $myProductPrice['p_id']));
                                        }
                                        else
                                        {
                                            if (!empty($myProductPrice) && $myProductPrice['p_sellprice'] > 1)
                                            {
                                                $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = ? WHERE p_id = ?';
                                                $this->registry->db->query($sql, array(implode('###', $arrupdate), (float)$myProductPrice['p_sellprice'], $myProductPrice['p_id']));
                                            }
                                            else
                                            {
                                                $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = 0 WHERE p_id = ?';
                                                $this->registry->db->query($sql, array(implode('###', $arrupdate), $myProductPrice['p_id']));
                                            }
                                        }
                                    }
                                    else{
                                        if ($finalprice > 1)
                                        {
                                            $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = ? WHERE p_id = ?';
                                            $this->registry->db->query($sql, array('', (float)$finalprice, $myProductPrice['p_id']));
                                        }
                                        else{
                                            if (!empty($myProductPrice) && $myProductPrice['p_sellprice'] > 1)
                                            {
                                                $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = ? WHERE p_id = ?';
                                                $this->registry->db->query($sql, array('', (float)$myProductPrice['p_sellprice'], $myProductPrice['p_id']));
                                            }
                                            else
                                            {
                                                $sql = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = 0 WHERE p_id = ?';
                                                $this->registry->db->query($sql, array('', $myProductPrice['p_id']));
                                            }
                                        }
                                    }
                                }
                            }
                            else{//truong hop KM không có store nào để apply vô
                                $this->updatefinalpriceforproduct($barcode);
                                return false;
                            }
                        }
                        else{//truong hop KM không có store nào để apply vô
                            $this->updatefinalpriceforproduct($barcode);
                            return false;
                        }
                    }
                }
                else{//truong hop KM không có store nào để apply vô
                    $this->updatefinalpriceforproduct($barcode);
                    return false;
                }
            }
            else {//truong hop KM giảm giá <=0
                $this->updatefinalpriceforproduct($barcode);
                return false;
            }
        }
        else {//truong hop không có KM giảm giá nào
            $this->updatefinalpriceforproduct($barcode);
            return false;
        }
        //echodebug('SQLUPDATE: '.$sqlupdate.'---'.$barcode);
        //echodebug('SQL: '.$sql.'---'.$barcode.'<br /><br /><br /><br />');
        unset($findhighestpromotion);
    }

    private function updatefinalpriceforproduct($barcode)
    {
        $finalpriceprodut = Core_RelRegionPricearea::getPriceByProductRegion($barcode, 3);
        if ($finalpriceprodut > 1)
        {
            $sqlupdate = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = ? WHERE p_barcode = ?';
            $this->registry->db->query( $sqlupdate, array('', (float)$finalpriceprodut, $barcode));
        }
        else
        {
            $myProductPrice = $this->registry->db->query('SELECT p_id, p_sellprice FROM '.TABLE_PREFIX.'product WHERE p_barcode = ? LIMIT 1', array((string)$barcode))->fetch();
            if (!empty($myProductPrice) && $myProductPrice['p_sellprice'] > 1)
            {
                $sqlupdate = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = ? WHERE p_barcode = ?';
                $this->registry->db->query( $sqlupdate, array('', (float)$myProductPrice['p_sellprice'], $barcode));
            }
            else
            {
                $sqlupdate = 'UPDATE '.TABLE_PREFIX.'product SET p_promotionlist = ?, p_finalprice = 0 WHERE p_barcode = ?';
                $this->registry->db->query( $sqlupdate, array('', $barcode));
            }
        }
    }
}
?>