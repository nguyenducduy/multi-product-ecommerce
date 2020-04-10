<?php
ini_set('memory_limit', '3048M');
class Controller_Cron_Archivedorder extends Controller_Cron_Base
{
    public $demSql = 0;
    public $demtrung = 0;
    public $recordGetPerTime = 900;

    public function indexAction()
    {

    }

    /** Archivedorder */

    public function syncbydateAction()
    {
        $archived  = new Core_Archivedorder();
        $LastID    = $archived->getIdNewOrder();

        $arrAdd    = array();
        $arrRe     = array();
        $re        = Core_Store::getList('', '', '');
        foreach ($re as $k => $v) {
            $arrRe[$v->id] = $v->region;
        }



        // ngay tinh range
        $begindate2 = "2013-01-01";

        $countA     = Core_Archivedorder::countList('');
        if ($LastID == 0) {

            $range = $this->calrangedate($begindate2);
            for ($i = 0; $i <= $range; $i++) {
                /* cong them 1 gay */
                $endate     = new DateTime($begindate2);
                $endate->modify('+1 day');


                /* tao begindate & endate */
                $enddate    = $endate->format('d-M-y');
                $begindate  = date('d-M-y', strtotime($begindate2));
                $begindate2 = $endate->format('Y-m-d');


                // lay mang order trong 1 ngay & insert
                $arrAdd     = $this->processSync($begindate, $enddate);
                $this->adddataArchive($arrAdd, $arrRe);
            }
            $countB     = Core_Archivedorder::countList('');
            $this->updatedetail($countB - $countA);

        } else {

            $begindate = Core_OrderArchive::getOrderAchiveByID($LastID['o_saleorderid']);
            $arrAdd    = $this->processSync($begindate, '', false);
            $this->adddataArchive($arrAdd, $arrRe);
            $countB     = Core_Archivedorder::countList('');
            $this->updatedetail($countB - $countA);
        }
    }

    private function processSync($begindate, $enddate, $todate = true)
    {

        $arrAdd     = array();
        $count      = Core_OrderArchive::getOrderAchiveBydate('', '', $begindate, $enddate, true, $todate);
        if ($count > 0) {

            $chia      = (int)$count / (int)$this->recordGetPerTime;
            $toltalget = ceil($chia);


            for ($j = 0; $j <= $toltalget; $j++) {

                set_time_limit(0);

                $begin = $j * $this->recordGetPerTime + 1;
                $end   = $begin + $this->recordGetPerTime - 1;
                $results = Core_OrderArchive::getOrderAchiveBydate($begin, $end, $begindate, $enddate, false, $todate);
                if (!empty($results)) {
                    foreach ($results as $key => $value) {
                        $arrAdd[$value['SALEORDERID']] = $results[$key];
                    }

                }
            }
        }
        return $arrAdd;
    }

    private function adddataArchive($arr, $arrRe, $action = 'import')
    {
        if (!empty($arr)) {
            foreach ($arr as $key => $results) {


                $checkid = Core_Archivedorder::countList("o_saleorderid = '" . $results['SALEORDERID'] . "'");
                if ($checkid == 0) {
                    $flag = true;
                } else {
                    $flag = false;
                }


                if ($flag) {

                    $complete = "1";
                    if ($results['ISDELETED'] == 0) {
                        if ($results['ISREVIEWED'] == "0" || $results['ISINCOME'] == "0" || $results['ISOUTPRODUCT'] == "0" || $results['ISDELIVERY'] == "0") {
                            $complete = "0";
                        }
                    } else {
                        $complete = "2";
                    }
                    $myArchivedorder                         = new Core_Archivedorder();
                    $myArchivedorder->saleorderid            = $results["SALEORDERID"];
                    $myArchivedorder->ordertypeid            = $results["ORDERTYPEID"];
                    $myArchivedorder->deliverytypeid         = $results["DELIVERYTYPEID"];
                    $myArchivedorder->customerid             = $results["CUSTOMERID"];
                    $myArchivedorder->customername           = $results["CUSTOMERNAME"];
                    $myArchivedorder->customeraddress        = $results["CUSTOMERADDRESS"];
                    $myArchivedorder->customerphone          = $results["CUSTOMERPHONE"];
                    $myArchivedorder->contactname            = $results["CONTACTNAME"];
                    $myArchivedorder->gender                 = $results["GENDER"];
                    $myArchivedorder->ageid                  = $results["AGEID"];
                    $myArchivedorder->deliveryaddress        = $results["DELIVERYADDRESS"];
                    $myArchivedorder->provinceid             = $results["PROVINCEID"];
                    $myArchivedorder->districtid             = $results["DISTRICTID"];
                    $myArchivedorder->isreviewed             = $results["ISREVIEWED"];
                    $myArchivedorder->payabletypeid          = $results["PAYABLETYPEID"];
                    $myArchivedorder->currencyunitid         = $results["CURRENCYUNITID"];
                    $myArchivedorder->currencyexchange       = $results["CURRENCYEXCHANGE"];
                    $myArchivedorder->totalquantity          = $results["TOTALQUANTITY"];
                    $myArchivedorder->totalamount            = $results["TOTALAMOUNT"];
                    $myArchivedorder->totaladvance           = $results["TOTALADVANCE"];
                    $myArchivedorder->shippingcost           = $results["SHIPPINGCOST"];
                    $myArchivedorder->debt                   = $results["DEBT"];
                    $myArchivedorder->discountreasonid       = $results["DISCOUNTREASONID"];
                    $myArchivedorder->discount               = $results["DISCOUNT"];
                    $myArchivedorder->originatestoreid       = $results["ORIGINATESTOREID"];
                    $myArchivedorder->isoutproduct           = $results["ISOUTPRODUCT"];
                    $myArchivedorder->outputstoreid          = $results["OUTPUTSTOREID"];
                    $myArchivedorder->isincome               = $results["ISINCOME"];
                    $myArchivedorder->isdeleted              = $results["ISDELETED"];
                    $myArchivedorder->promotiondiscount      = $results["PROMOTIONDISCOUNT"];
                    $myArchivedorder->vouchertypeid          = $results["VOUCHERTYPEID"];
                    $myArchivedorder->voucherconcern         = $results["VOUCHERCONCERN"];
                    $myArchivedorder->deliveryuser           = $results["DELIVERYUSER"];
                    $myArchivedorder->saleprogramid          = $results["SALEPROGRAMID"];
                    $myArchivedorder->totalpaid              = $results["TOTALPAID"];
                    $myArchivedorder->issmspromotion         = $results["ISSMSPROMOTION"];
                    $myArchivedorder->deliverytime           = $this->formatTime($results["DELIVERYTIME"]);
                    $myArchivedorder->isdelivery             = $results["ISDELIVERY"];
                    $myArchivedorder->deliveryupdatetime     = $this->formatTime($results["DELIVERYUPDATETIME"]);
                    $myArchivedorder->ismove                 = $results["ISMOVE"];
                    $myArchivedorder->iscomplete             = $complete;
                    $myArchivedorder->parentsaleorderid      = $results["PARENTSALEORDERID"];
                    $myArchivedorder->thirdpartyvoucher      = $results["THIRDPARTYVOUCHER"];
                    $myArchivedorder->payabletime            = $this->formatTime($results["PAYABLETIME"]);
                    $myArchivedorder->createdbyotherapps     = $results["CREATEDBYOTHERAPPS"];
                    $myArchivedorder->contactphone           = $results["CONTACTPHONE"];
                    $myArchivedorder->customercarestatusid   = $results["CUSTOMERCARESTATUSID"];
                    $myArchivedorder->totalprepaid           = $results["TOTALPREPAID"];
                    $myArchivedorder->crmcustomerid          = $results["CRMCUSTOMERID"];
                    $myArchivedorder->originatestoreregionid = isset($arrRe[$results['ORIGINATESTOREID']])? $arrRe[$results['ORIGINATESTOREID']] : 0;
                    if ($results['ORIGINATESTOREID'] != $results['OUTPUTSTOREID']) {
                        $myArchivedorder->outputstoreregionid = isset($arrRe[$results['OUTPUTSTOREID']])? $arrRe[$results['OUTPUTSTOREID']] : 0;
                    } else {
                        $myArchivedorder->outputstoreregionid = $myArchivedorder->originatestoreregionid;
                    }
                    $myArchivedorder->createdate                   = $this->formatTime($results["CREATEDATE"]);
                    $myArchivedorder->taxid                        = $results["TAXID"];
                    $myArchivedorder->note                         = $results["NOTE"];
                    $myArchivedorder->revieweduser                 = $results["REVIEWEDUSER"];
                    $myArchivedorder->revieweddate                 = $results["REVIEWEDDATE"];
                    $myArchivedorder->outproductdate               = $results["OUTPRODUCTDATE"];
                    $myArchivedorder->inputtime                    = $this->formatTime($results["INPUTTIME"]);
                    $myArchivedorder->userdeleted                  = $results["USERDELETED"];
                    $myArchivedorder->contentdeleted               = $results["CONTENTDELETED"];
                    $myArchivedorder->staffuser                    = $results["STAFFUSER"];
                    $myArchivedorder->printtimes                   = $this->formatTime($results["PRINTTIMES"]);
                    $myArchivedorder->deliveryupdateuser           = $results["DELIVERYUPDATEUSER"];
                    $myArchivedorder->movetime                     = $this->formatTime($results["MOVETIME"]);
                    $myArchivedorder->outputuser                   = $results["OUTPUTUSER"];
                    $myArchivedorder->deliveryuserupdatetime       = $this->formatTime($results["DELIVERYUSERUPDATETIME"]);
                    $myArchivedorder->deliveryuserupdateuser       = $results["DELIVERYUSERUPDATEUSER"];
                    $myArchivedorder->customercarestausupdatetime  = $this->formatTime($results["CUSTOMERCARESTATUSUPDATETIME"]);
                    $myArchivedorder->customercarestatusupdateuser = $results["CUSTOMERCARESTATUSUPDATEUSER"];
                    $myArchivedorder->contactid                    = $results["CONTACTID"];
                    $myArchivedorder->customercode                 = $results["CUSTOMERCODE"];
                    $myArchivedorder->birthday                     = $this->formatTime($results["BIRTHDAY"]);
                    $myArchivedorder->customeridcard               = $results["CUSTOMERIDCARD"];
                    $myArchivedorder->createdapplicationid         = $results["CREATEDAPPLICATIONID"];
                    $myArchivedorder->iscreatefromoutputreceipt    = $results["ISCREATEFROMOUTPUTRECEIPT"];
                    $myArchivedorder->iscreatefromsimprocessreq    = $results["ISCREATEFROMSIMPROCESSREQ"];
                    $myArchivedorder->bankvoucher                  = $results["BANKVOUCHER"];
                    $myArchivedorder->processuser                  = $results["PROCESSUSER"];
                    $myArchivedorder->contractid                   = $results["CONTRACTID"];
                    $myArchivedorder->isinputimeicomplete          = $results["ISINPUTIMEICOMPLETE"];
                    $myArchivedorder->organizationname             = $results["ORGANIZATIONNAME"];
                    $myArchivedorder->positionname                 = $results["POSITIONNAME"];
                    $myArchivedorder->currentreviewlevelid         = $results["CURRENTREVIEWLEVELID"];
                    $myArchivedorder->mspromotionlevelidlist       = $results["MSPROMOTIONLEVELIDLIST"];
                    $myArchivedorder->crmcustomercardcode          = $results["CRMCUSTOMERCARDCODE"];
                    $myArchivedorder->iswarningduplicatesaleorder  = $results["ISWARNINGDUPLICATESALEORDER"];
                    $myArchivedorder->duplicatesaleorderid         = $results["DUPLICATESALEORDERID"];
                    $myArchivedorder->pointpaid                    = $results["POINTPAID"];
                    $myArchivedorder->iscomplete                   = $complete;

                    $myArchivedorder->addData();

                } else {
                    echodebug($results, true);
                }
            }
        }
    }

    private function calrangedate($begindate)
    {
        $now = time(); // or your date as well
        $your_date = strtotime($begindate);
        $datediff = $now - $your_date;
        return floor($datediff/(60*60*24));
    }

    /** end Archivedorder */

    /** Archivedorder detail */

    private function updatedetail($count_old)
    {
        $countd_old     = Core_ArchivedorderDetail::countList("");
        /* lay id cua archive lon nhat trong bang detail */
        $idOrderSync = Core_ArchivedorderDetail::getDataSync();

        $this->demTruyVan();
        if ($idOrderSync > 0) {

            $this->processSyncDetail($idOrderSync);

        } else {

            $archiveorder = new Core_Archivedorder();
            $idOrderSync  = $archiveorder->getIdMinOrder();
            if ($idOrderSync > 0) {
                $this->processSyncDetail($idOrderSync);
            }

        }


        $countd_new     = Core_ArchivedorderDetail::countList("");
        $dem_detail     = $countd_new - $countd_old;
        $str            = "Insert Success Archivedorder : " . $count_old . "<br/>Insert Success Archivedorder Detail : " . $dem_detail . "<br/>SQL ERP : " . $this->demSql . "<br/>Record Exist : " . $this->demtrung;
        $this->demSql   = 0;
        $this->demtrung = 0;
        unset($begindate);
        echo $str;
    }

    private function processSyncDetail($idOrderSync)
    {
        $count      = Core_Archivedorder::countList("o_id>'" . $idOrderSync . "'");

        $total      = ceil($count / $this->recordGetPerTime);
        for ($i = 0; $i <= $total; $i++) {

            set_time_limit(0);
            $begin   = $i * 1000;
            $results = Core_Archivedorder::getOrderByID($idOrderSync, $begin, $this->recordGetPerTime);
            if (!empty($results)) {

                foreach ($results as $khoa => $giatri) {

                    $rs = Core_OrderArchive::getOrderAchiveDetail($giatri['o_saleorderid']); //lay detail oracle
                    $this->demTruyVan();
                    if (!empty($rs)) {

                        foreach ($rs as $key => $value) {


                            $p_id   = Core_Product::getIdByBarcode($value['PRODUCTID']);
                            $detail = Core_ArchivedorderDetail::getArchivedorderDetails(array( 'fpid' => $p_id->id, 'fsaleorderid' => $value['SALEORDERID'] ), '', '', '', true);
                            if ($detail==0) {

                                $myArchivedorderDetail                       = new Core_ArchivedorderDetail();
                                $myArchivedorderDetail->pid                  = $p_id->id;
                                $myArchivedorderDetail->oorderid             = $giatri['o_id'];
                                $myArchivedorderDetail->imei                 = $value['IMEI'];
                                $myArchivedorderDetail->saleorderid          = $value['SALEORDERID'];
                                $myArchivedorderDetail->productid            = $value['PRODUCTID'];
                                $myArchivedorderDetail->quantity             = $value['QUANTITY'];
                                $myArchivedorderDetail->saleprice            = $value['SALEPRICE'];
                                $myArchivedorderDetail->outputtypeid         = $value['OUTPUTTYPEID'];
                                $myArchivedorderDetail->vat                  = $value['VAT'];
                                $myArchivedorderDetail->salepriceerp         = $value['SALEPRICEERP'];
                                $myArchivedorderDetail->endwarrantytime      = $this->formatTime($value['ENDWARRANTYTIME']);
                                $myArchivedorderDetail->ispromotionautoadd   = $value['ISPROMOTIONAUTOADD'];
                                $myArchivedorderDetail->promotionid          = $value['PROMOTIONID'];
                                $myArchivedorderDetail->promotionlistgroupid = $value['PROMOTIONLISTGROUPID'];
                                $myArchivedorderDetail->applyproductid       = $value['APPLYPRODUCTID'];
                                $myArchivedorderDetail->replicationstoreid   = $value['RELICATIONSTOREID'];
                                $myArchivedorderDetail->adjustpricetypeid    = $value['ADJUSTPRICETYPEID'];
                                $myArchivedorderDetail->adjustprice          = $value['ADJUSTPRICE'];
                                $myArchivedorderDetail->adjustpricecontent   = $value['ADJUSTPRICECONTENT'];
                                $myArchivedorderDetail->discountcode         = $value['DISCOUNTCODE'];
                                $myArchivedorderDetail->adjustpriceuser      = $value['ADJUSTPRICEUSER'];
                                $myArchivedorderDetail->vatpercent           = $value['VATPERCENT'];
                                $myArchivedorderDetail->retailprice          = $value['RETAILPRICE'];
                                $myArchivedorderDetail->inputvoucherdetailid = $value['INPUTVOUCHERDETAILID'];
                                $myArchivedorderDetail->buyinputvoucherid    = $value['BUYINPUTVOUCHERID'];
                                $myArchivedorderDetail->inputvoucherdate     = $this->formatTime($value['INPUTVOUCHERDATE']);
                                $myArchivedorderDetail->isnew                = $value['ISNEW'];
                                $myArchivedorderDetail->isshowproduct        = $value['ISSHOWPRODUCT'];
                                $myArchivedorderDetail->costprice            = $value['COSTPRICE'];
                                $myArchivedorderDetail->productsaleskitid    = $value['PRODUCTSALESKITID'];
                                $myArchivedorderDetail->refproductid         = $value['REFPRODUCTID'];
                                $myArchivedorderDetail->productcomboid       = $value['PRODUCTCOMBOID'];
                                $myArchivedorderDetail->subtotal             = $value['SALEPRICE'] * $value['QUANTITY'];
                                $myArchivedorderDetail->subtotalvat          = $value['SALEPRICE'] * (1 + $value['VAT'] / $value['VATPERCENT']) * $value['QUANTITY'];
                                $myArchivedorderDetail->addData();
                                Core_Archivedorder::updateIsDetail($giatri['o_id']);

                            }

                        }

                    }

                }
                unset($myArchivedorderDetail);
                unset($str);
                unset($rs);
                unset($arr);
                unset($results);


            }
        }
    }

    /** end Archivedorder detail */
    private function formatTime($str, $debug = false)
    {

        // 14-MAR-13 12.02.22.041411000 PM
        if ($str != null && $str != '0' && strlen($str) >= 28) {


            $date = DateTime::createFromFormat('d-M-y h.i.s.u??? A', $str);
            if (!$date) {
                $date = DateTime::createFromFormat('d-M-y h.i.s.u A', $str);
            }
            if ($date) {
                $str  = $date->format('d/m/Y G:i');
                $gio  = $date->format('G:i');
                $str  = Helper::strtotimedmy($str, $gio);
                return $str;
            } else {
                echodebug($str, true);
            }

        } else {
            return $str;
        }

    }

    private function demTruyVan()
    {
        $this->demSql = $this->demSql + 1;
    }

    public function deleteduplcateAction()
    {
        set_time_limit(0);
        $die         = true;
        $detailorder = new Core_ArchivedorderDetail();

        $count = 1000000;
        $total = ceil($count / 1000);
        for ($index = 0; $index < $total; $index++) {
            $limit = "0,10000";
            $rs    = Core_ArchivedorderDetail::getduplicate($limit);
            echodebug($rs);
            if (!empty($rs)) {
                foreach ($rs as $key => $value) {
                    if ($value['dem'] != '1') {
                        Core_ArchivedorderDetail::deleteduplicate($value['od_id'], $value['od_saleorderid'], $value['od_productid']);
                    } else {
                        var_dump($value['od_saleorderid']);
                        exit();
                    }

                }
            }
        }
    }

    public function exportdataAction()
    {

        $myorder = new Core_Archivedorder('1533971');
        $erp     = Core_OrderArchive::getBySaleorderid('962SO1304008658     ');
        var_dump($erp);
        $str  = '';
        $str2 = 'TIME';
        foreach ($erp as $key => $value) {
            foreach ($value as $k => $v) {
                if (strpos($k, $str2) == false) {
                    $str .= 'o_' . strtolower($k) . ' = "\'.str_replace(\'"\',\'\\"\',$results["' . $k . '"]).\'",<br>';
                } else {
                    $str .= 'o_' . strtolower($k) . ' = "\'.$this->formatTime($results["' . $k . '"]).\'",<br>';
                }
            }


        }

        echo($str);
        die();


//			$count = Core_LotteMember::getLotteMembers(array(),'','','',true);
//			$data='';
//			$dem = 0;
//			for($i = 1 ;$i<=$count;$i++)
//			{
//
//				$sql = 'select lm_email from lit_lotte_member LIMIT '.(($i - 1) * 2000) . ',' . 2000;
//				$rs = $this->registry->db->query($sql);
//				while($row = $rs->fetch())
//				{
//
//
//						$data .= $row['lm_email'] . "</br>";
//						$dem = $dem + 1;
//				}
//
//
//
//
//			}
//
//			echo $data;
//			echo $dem;
//			die();


//			$data = '';
//			$from = 0;
//			$data .= 'Ngày, Đăng kí , SL ngời  giới thiệu , SL ngời đổi điểm ' . "\n";
//			for ($index = 0; $index < 20; $index++) {
//				$from   = $from == 0 ? Helper::strtotimedmy('26/04/2013') : $from;
//				$count1 = Core_LotteCode::getLotteCodes(array('ftype' => '1','fdatecreatedf' => $from,'fdatecreatedt' => ($from + 86400)),'','','',true);
//				$count3 = Core_LotteCode::getLotteCodes(array('ftype' => '3','fdatecreatedf' => $from,'fdatecreatedt' => ($from + 86400)),'','','',true);
//				$count5 = Core_LotteCode::getLotteCodes(array('ftype' => '5','fdatecreatedf' => $from,'fdatecreatedt' => ($from + 86400)),'','','',true);
//				$data .= date('d/m/Y',$from) . "-" . $from . ',' . $count1 . ',' . $count3 . ',' . $count5 . "\n";
//				$from = $from + 86400;
//			}
//			$myHttpDownload = new HttpDownload();
//			$myHttpDownload->set_bydata($data); //Download from php data
//			$myHttpDownload->use_resume = true; //Enable Resume Mode
//			$myHttpDownload->filename   = 'code-' . date('Y-m-d-H-i-s') . '.csv';
//			$myHttpDownload->download(); //Download File
    }

    public function syncregionAction()
    {

        set_time_limit(0);
        $re    = Core_Store::getList('', '', '');
        $arrRe = array();
        foreach ($re as $k => $v) {
            $arrRe[$v->id] = $v->region;
        }
        $count = Core_Archivedorder::countList('', '');
        $total = ceil($count / 1000);
        for ($i = 0; $i <= $total; $i++) {
            $begin    = $i * 1000;
            $archcive = Core_Archivedorder::getList('', '', $begin . ',1000');
            foreach ($archcive as $k => $v) {
                $oniregion = $arrRe[$v->originatestoreid];
                $outregion = $arrRe[$v->outputstoreid];

                $sql = "UPDATE `lit_archivedorder` SET `o_originatestoreregionid` = '" . $oniregion . "',`o_outputstoreregionid` = '" . $outregion . "' WHERE `o_id` = '" . $v->id . "'";
                Core_Archivedorder::syncregion($sql);
            }
        }
        echo 'Xong !!!!!!!!!!!!!!!!!!!!!!';
    }

    public function syncproductAction()
    {


        $count  = Core_Product::countList("");
        $total  = ceil($count / 1000);
        $arrPro = array();
        for ($i = 0; $i <= $total; $i++) {
            $begin = $i * 1000;
            $pro   = Core_Product::getList('', '', $begin . ',1000');
            foreach ($pro as $k => $v) {
                if ($v->barcode != '') {
                    $arrPro[trim($v->barcode)] = $v->id;
                }
            }

        }
        $count = Core_ArchivedorderDetail::countList('', '');
        $total = ceil($count / 1000);
        for ($i = 0; $i <= $total; $i++) {
            $begin    = $i * 1000;
            $archcive = Core_ArchivedorderDetail::getList('', '', $begin . ',1000');
            foreach ($archcive as $k => $v) {
                $p_id = $arrPro[$v->productid];
                $sql  = "UPDATE `lit_archivedorder_detail` SET `p_id` = '" . $p_id . "' WHERE `od_id` = '" . $v->id . "'";
                Core_Archivedorder::syncregion($sql);
            }
        }
        echo 'Xong !!!!!!!!!!!!!!!!!!!!!!';
    }

    public function backupnotcompleteAction()
    {
        $die   = true;
        $total = Core_OrderArchive::getSaleorderNotComplete(array(), false, true);


        $recordPer = 100;
        $totalpage = ceil($total / $recordPer);
        $str       = '';
        for ($i = 0; $i <= $totalpage; $i++) {
            set_time_limit(0);
            $limit['begin'] = $i * $recordPer;
            $limit['end']   = $limit['begin'] + $recordPer;
            set_time_limit(0);
            $rs = Core_OrderArchive::getSaleorderNotComplete($limit);
            foreach ($rs as $key => $value) {
                Core_Archivedorder::insertbackupnotComplete($value['SALEORDERID'], '0');
            }
            unset($rs);

        }

        Core_Archivedorder::updatenotComplete();
        Core_Archivedorder::deletebackupnotComplete();

        echo ' total not Complete From ERP : ' . $total;

    }

    public function checkcompleteAction()
    {


        $li          = isset($_GET['li']) && $_GET['li'] != ''? $_GET['li'] : "1";
        $die         = true;
        $recordPer   = 800;
        $demERP      = 0;
        $demComplete = 0;
        $str         = '';
        $demtest     = 0;
        $arrTime     = array();
        // limit , debugs , count
        if ($li == "1") {
            $arrTime['to']   = Helper::strtotimedmy(date('d/m/Y', time()));
            $arrTime['from'] = (Helper::strtotimedmy(date('d/m/Y', time())) - 2592000);
        }

        $total     = Core_Archivedorder::getlistNotComplete('', true, $arrTime);
        $totalpage = ceil($total / $recordPer);

        for ($i = 0; $i <= $totalpage; $i++) {

            $limit['begin'] = $i * $recordPer;
            $limit['end']   = $recordPer;
            $strlimit       = $limit['begin'] . "," . $limit['end'];

            set_time_limit(0);
            $rs = Core_Archivedorder::getlistNotComplete($strlimit, false, $arrTime);
            if ($rs != null) {
                //tao chuoi kt 1 luot cac id (id,id,.....)

                foreach ($rs as $key => $value) {
                    $str .= $str == ''? "'" . $value['o_saleorderid'] . "'" : ",'" . $value['o_saleorderid'] . "'";
                    $demtest = $demtest + 1;
                }

                $rsTuErp = Core_OrderArchive::getMultiid($str);
                $demERP  = $demERP + 1;
                if (!empty($rsTuErp)) {
                    foreach ($rsTuErp as $khoa => $giatri) {
                        $complete = "1";
                        if ($giatri['ISDELETED'] == 0) {
                            if ($giatri['ISREVIEWED'] == "0" || $giatri['ISINCOME'] == "0" || $giatri['ISOUTPRODUCT'] == "0" || $giatri['ISDELIVERY'] == "0") {
                                $complete = "0";
                            }
                        } else {
                            $complete = "2";
                        }
                        if ($complete == "1") {
                            $demComplete = $demComplete + 1;
                        }

                        $sql = 'UPDATE lit_archivedorder SET
                                        o_isreviewed	= "' . $giatri['ISREVIEWED'] . '",
                                        o_isincome		= "' . $giatri['ISINCOME'] . '",
                                        o_isdeleted		= "' . $giatri['ISDELETED'] . '",
                                        o_isoutproduct 	= "' . $giatri['ISOUTPRODUCT'] . '",
                                        o_iscomplete 	= "' . $complete . '"
                                    WHERE o_saleorderid = "' . $giatri['SALEORDERID'] . '"';
                        $this->registry->db->query($sql);
                        $str     = '';
                        $demtest = 0;
                    }

                }

            }


        }
        Core_Archivedorder::updatenotComplete();
        Core_Archivedorder::deletebackupnotComplete();
        echo 'Query ERP : ' . $demERP . "<br>";
        echo 'Query Complete  : ' . $demComplete . "<br>";
        echo 'Tổng số notComplete : ' . $total . "<br>";

    }

    public function updateimeAction()
    {
        $dem       = 0;
        $oracle    = new Core_OrderArchive();
        $str       = '';
        $count     = Core_ArchivedorderDetail::getArchivedorderDetails(array(), '', '', '', true);
        $record    = 800;
        $totalpage = ceil($count / $record);
        echodebug($totalpage, true);
        for ($i = 0; $i <= $totalpage; $i++) {
            $sql  = "SELECT DISTINCT (od_saleorderid) FROM  lit_archivedorder_detail LIMIT " . ($i * $record) . "," . $record;
            $stmt = $this->registry->db->query($sql);
            while ($rs = $stmt->fetch()) {
                $str .= ",'" . $rs['od_saleorderid'] . "'";

            }
            $str  = substr($str, 1);
            $item = ' ERP.vw_saleorderdetail_dm.SALEORDERID,
                         ERP.vw_saleorderdetail_dm.PRODUCTID,
                         ERP.vw_saleorderdetail_dm.IMEI ';

            $result    = $oracle::getMultiidDetail($str, $item);
            $str       = '';
            $sqlupdate = "UPDATE lit_archivedorder_detail SET od_imei= ";
            foreach ($result as $key => $value) {
                if ($value['IMEI'] != '') {
                    $sql  = $sqlupdate . "'" . trim($value['IMEI']) . "' WHERE  od_saleorderid = '" . trim($value['SALEORDERID']) . "' AND od_productid = '" . trim($value['PRODUCTID']) . "'";
                    $rsqr = $this->registry->db->query($sql);
                    if ($rsqr) {
                        $dem = $dem + 1;
                    }
                }

            }


        }
        echodebug("da update : " . $dem . " IMEI");
    }

}

