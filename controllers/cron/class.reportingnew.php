<?php
ini_set('memory_limit','4000M');
ini_set('display_errors', 1);
Class Controller_Cron_Reportingnew Extends Controller_Cron_Base
{
    private $arrtypes = array(
            Core_Stat::TYPE_SALE_ITEM_VOLUME,
            Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT,
            Core_Stat::TYPE_SALE_ITEM_VALUE,
            Core_Stat::TYPE_SALE_COSTPRICE,
            Core_Stat::TYPE_PROMOTION_COSTPRICE,
            Core_Stat::TYPE_STOCK_VOLUME_BEGIN,
            Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME,
            Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE,
            Core_Stat::TYPE_OUTPUT_VOLUME,
            Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME,
            Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME,
            Core_Stat::TYPE_OUTPUT_OTHER_VOLUME,
            Core_Stat::TYPE_STOCK_VALUE_BEGIN,
            Core_Stat::TYPE_OUTPUT_VALUE,
            Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE,
            Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE,
            Core_Stat::TYPE_OUTPUT_OTHER_VALUE,
            Core_Stat::TYPE_SALE_ORDER_VOLUME,
        );
    private $arrtypesrefund = array(
            Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME,
            Core_Stat::TYPE_INPUT_REFUND_REV_VALUE,
            Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT,
            Core_Stat::TYPE_REFUND_COSTPRICE,
            Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME,
            Core_Stat::TYPE_INPUT_BEGINTERM_VALUE,
            Core_Stat::TYPE_INPUT_VOLUME,
            Core_Stat::TYPE_INPUT_INTERNAL_VOLUME,
            Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME,
            Core_Stat::TYPE_INPUT_OTHER_VOLUME,
            Core_Stat::TYPE_INPUT_VALUE,
            Core_Stat::TYPE_INPUT_INTERNAL_VALUE,
            Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE,
            Core_Stat::TYPE_INPUT_OTHER_VALUE,
        );

    /*Cron nay phai chay dung 1 thang thi du lieu moi dam bao dung, chay 1 ngay ko chinh xac vi co the du lieu tung ngay no thay doi khac nhau*/
    function indexAction()
    {
        global $conf;

        set_time_limit(0);
        $db3 = Core_Backend_Object::getDb();//get db3

        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));//strtotime('-1 month')

        $startdate = strtotime(date('Y-m-d', $startdate).' 00:00:01');
        $enddate = strtotime(date('Y-m-d', $enddate).' 23:59:59');
        $enddatenotime = strtotime(date('Y-m-d', $enddate).' 00:00:01');
        $starttime = time();
        $dt = $startdate;

        $songay = ceil(($enddate - $startdate)/86400);
        
        if (($songay >= 28 || !isset($_GET['enddate'])) && date('Ym', $startdate) == date('Ym', $enddate))
        {
            try {
                $redis = new Redis();
                $redis->connect($conf['redis'][1]['ip'], $conf['redis'][1]['port']);
                $firstkeyredis = date('Ym', $startdate);
                $arrall = $redis->keys($firstkeyredis.'*');
                $counterallredis = count($arrall);
                for($iredis = 0; $iredis <$counterallredis; $iredis+= 100)
                {
                    $re  = $redis->delete(array_slice($arrall, $iredis, 100));
                }
                unset($arrall);
                unset($re);
            } catch(Exception $ex) {
                echodebug($ex, true);
            }
        }
        $listoutputtypeissale = array();
        $listinputputtypeisreturnsale = array();

        //array object
        $listoutputvouchers = array();
        $listinputvouchers = array();
        $listoutputvoucherreturns = array();

        //SP KM apply cho voucher
        $listproductapplyoutputvoucher = array();
        //lay diem thuong
        $listproductawards = array();

        //list gia von TB theo thang
        $listavgcost = array();
        //list gia von dau ky theo thang
        $listbegintemrcost = array();
        $storelistfromcache = Core_Store::getStoresFromCache(false);

        $listcategoryhaveproducts = array();

        $list = $db3->query('SELECT po_id,po_issale, po_isinternalsale FROM '.TABLE_PREFIX.'product_outputype');

        if (!empty($list))
        {
            while ($row = $list->fetch())
            {
                $listoutputtypeissale[$row['po_id']] = $row;
            }
            unset($row);
            unset($list);
        }

        $list = $db3->query('SELECT pi_id ,pi_isreturnsale FROM '.TABLE_PREFIX.'product_inputtype');
        if (!empty($list))
        {
            while ($row = $list->fetch())
            {
                $listinputputtypeisreturnsale[$row['pi_id']] = $row;
            }
            unset($row);
            unset($list);
        }
        //averagecostprice
        $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'averagecostprice WHERE
                                                        a_month >='.date('m', $startdate).' AND
                                                        a_month <='.date('m', $enddate).' AND
                                                        a_year >='.date('Y', $startdate).' AND
                                                        a_year <='.date('Y', $enddate)
                                            )->fetchColumn(0);
        $lastmonthdonthaveaveragecostprice = 0;
        if ($counter > 0)
        {
            for ($i = 0; $i < $counter; $i+=500)
            {
                $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'averagecostprice
                                                                WHERE
                                                                a_month >='.date('m', $startdate).' AND
                                                                a_month <='.date('m', $enddate).' AND
                                                                a_year >='.date('Y', $startdate).' AND
                                                                a_year <='.date('Y', $enddate).'
                                                                LIMIT '.$i.', 500');
                if (!empty($getoutputvoucher))
                {
                    while($row = $getoutputvoucher->fetch())
                    {
                        $listavgcost[$row['a_year']][$row['a_month']][$row['p_barcode']] = $row;
                        if (date('Y') == $row['a_year'] && $lastmonthdonthaveaveragecostprice < $row['a_month'])
                        {
                            $lastmonthdonthaveaveragecostprice = $row['a_month'];
                        }
                    }
                    unset($row);
                    unset($getoutputvoucher);
                }
            }
            unset($counter);
        }
        if ($lastmonthdonthaveaveragecostprice == 0){
            $newenddate = $startdate;
            $newstartdate = strtotime('-1 month', $newenddate);
            $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'averagecostprice WHERE
                                                        a_month >='.date('m', $newstartdate).' AND
                                                        a_month <='.date('m', $newenddate).' AND
                                                        a_year >='.date('Y', $newstartdate).' AND
                                                        a_year <='.date('Y', $newenddate)
                                            )->fetchColumn(0);
            if ($counter > 0)
            {
                for ($i = 0; $i < $counter; $i+=500)
                {
                    $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'averagecostprice
                                                                    WHERE
                                                                    a_month >='.date('m', $newstartdate).' AND
                                                                    a_month <='.date('m', $newenddate).' AND
                                                                    a_year >='.date('Y', $newstartdate).' AND
                                                                    a_year <='.date('Y', $newenddate).'
                                                                    LIMIT '.$i.', 500');
                    if (!empty($getoutputvoucher))
                    {
                        while($row = $getoutputvoucher->fetch())
                        {
                            $listavgcost[$row['a_year']][date('n', $enddate)][$row['p_barcode']] = $row;
                        }
                        unset($row);
                        unset($getoutputvoucher);
                    }
                }
                unset($counter);
            }
        }

        $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'beginminstock WHERE
                                                        b_month >='.date('m', $startdate).' AND
                                                        b_year >='.date('Y', $startdate).' AND
                                                        b_month <='.date('m', $enddate).' AND
                                                        b_year <='.date('Y', $enddate)
                                            )->fetchColumn(0);//o day chi lay du lieu ve thoi, chua tinh toan

        if ($counter > 0)
        {
            for ($i = 0; $i < $counter; $i+=1000)
            {
                $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'beginminstock
                                                                WHERE
                                                                b_month >='.date('m', $startdate).' AND
                                                                b_year >='.date('Y', $startdate).' AND
                                                                b_month <='.date('m', $enddate).' AND
                                                                b_year <='.date('Y', $enddate).'
                                                                LIMIT '.$i.', 1000');
                if (!empty($getoutputvoucher))
                {
                    while($row = $getoutputvoucher->fetch())
                    {
                        $listbegintemrcost[$row['b_year']][$row['b_month']][] = $row;
                    }
                    unset($row);
                    unset($getoutputvoucher);
                }
            }
            unset($counter);
        }

        while ($dt <= $enddatenotime)
        {
            $localDateBegin = mktime(0,0,0,date('m', $dt), date('d', $dt), date('Y', $dt));
            $localDateEnd = mktime(23,23,59,date('m', $dt), date('d', $dt), date('Y', $dt));

            $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'outputvoucher WHERE ov_outputdate >='.$localDateBegin.' AND ov_outputdate <='.$localDateEnd.' AND ov_voucherisdelete = 0 AND ov_iserror = 0 AND ov_voucherdetailisdelete = 0')->fetchColumn(0);

            if ($counter > 0)
            {
                for ($i = 0; $i < $counter; $i+=1000)
                {
                    $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'outputvoucher
                                                                    WHERE
                                                                    ov_outputdate >='.$localDateBegin.' AND
                                                                    ov_outputdate <='.$localDateEnd.' AND
                                                                    ov_voucherisdelete = 0 AND
                                                                    ov_iserror = 0 AND
                                                                    ov_voucherdetailisdelete = 0
                                                                    LIMIT '.$i.', 1000');
                    if (!empty($getoutputvoucher))
                    {
                        while($row = $getoutputvoucher->fetch())
                        {
                            if (empty($row['ov_applyproductid']))
                            {
                                $listoutputvouchers[$dt][$row['ov_outputvoucherid']][] = $row;
                            }
                            else
                            {
                                $listproductapplyoutputvoucher[$dt][trim($row['ov_applyproductid'])][$row['ov_outputvoucherid']][] = $row;
                            }
                        }
                        unset($row);
                        unset($getoutputvoucher);
                    }
                }
                unset($counter);
            }
            //inputvoucher
            $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'inputvoucher WHERE iv_inputdate >='.$localDateBegin.' AND iv_inputdate <='.$localDateEnd.' AND iv_isvoucherdelete = 0 AND iv_isvoucherdetaildelete = 0')->fetchColumn(0);
            if ($counter > 0)
            {
                for ($i = 0; $i < $counter; $i+=500)
                {
                    $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'inputvoucher
                                                                    WHERE
                                                                    iv_inputdate >='.$localDateBegin.' AND
                                                                    iv_inputdate <='.$localDateEnd.' AND iv_isvoucherdelete = 0 AND iv_isvoucherdetaildelete = 0
                                                                    LIMIT '.$i.', 500');
                    if (!empty($getoutputvoucher))
                    {
                        while($row = $getoutputvoucher->fetch())
                        {
                            $listinputvouchers[$dt][$row['iv_inputvoucherid']][] = $row;
                        }
                        unset($row);
                        unset($getoutputvoucher);
                    }
                }
                unset($counter);
            }

            //outputvoucher return
            $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'outputvoucherreturn WHERE ovr_inputtime >='.$localDateBegin.' AND ovr_inputtime <='.$localDateEnd.' AND ovr_ovisdelete = 0 AND ovr_iserror = 0 AND ovr_ovdetailisdelete = 0')->fetchColumn(0);

            if ($counter > 0)
            {
                for ($i = 0; $i < $counter; $i+=1000)
                {
                    $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'outputvoucherreturn
                                                                    WHERE
                                                                    ovr_inputtime >='.$localDateBegin.' AND
                                                                    ovr_inputtime <='.$localDateEnd.' AND
                                                                    ovr_ovisdelete = 0 AND
                                                                    ovr_iserror = 0 AND
                                                                    ovr_ovdetailisdelete = 0
                                                                    LIMIT '.$i.', 1000');
                    if (!empty($getoutputvoucher))
                    {
                        while($row = $getoutputvoucher->fetch())
                        {
                            $listoutputvoucherreturns[$dt][] = $row;
                        }
                        unset($row);
                        unset($getoutputvoucher);
                    }
                }
                unset($counter);
            }

            //productraward
            $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'productreward WHERE pr_updateddate >='.$localDateBegin.' AND pr_updateddate <='.$localDateEnd.' AND pr_isconfirmrewardforstaff = 1 AND po_id = 0')->fetchColumn(0);

            if ($counter > 0)
            {
                for ($i = 0; $i < $counter; $i+=1000)
                {
                    $getoutputvoucher = $db3->query('SELECT distinct p_barcode, pr_totalrewardforstaff FROM '.TABLE_PREFIX.'productreward
                                                                    WHERE
                                                                    pr_updateddate >='.$localDateBegin.' AND
                                                                    pr_updateddate <='.$localDateEnd.' AND
                                                                    pr_isconfirmrewardforstaff = 1 AND
                                                                    po_id = 0
                                                                    LIMIT '.$i.', 1000');
                    if (!empty($getoutputvoucher))
                    {
                        while($row = $getoutputvoucher->fetch())
                        {
                            $listproductawards[$dt][] = $row;
                        }
                        unset($row);
                        unset($getoutputvoucher);
                    }
                }
                unset($counter);
            }

            $dt = strtotime('+1 day', $dt);
        }

        //Tin tong so luong ton kho va tong TG ton kho dau ky
        foreach($listbegintemrcost as $syear=>$yearstock)
        {
            foreach ($yearstock as $smonth => $listproductstocks)
            {
                //tong sl va TG ton dau ky theo thang (lay ngay 1 cua moi thang)
                $dmonth = $smonth;
                if (strlen($dmonth) == 1) $dmonth = '0'.$dmonth;
                $datebeginstock = $syear.'/'.$dmonth.'/01';
                $sumbeginstockquantity = 0;
                $sumbeginstockvalue = 0;

                $beginstockdetails = array();
                $beginstockdetails2keys = array();

                $beginstockcategoriesid = array();
                foreach ($listproductstocks as  $abeginstock)//$pbarcode => $listbeginstock)
                {
                    $beginstock = $abeginstock;
                    $myProduct = Core_Product::getProductIDByBarcode(trim($beginstock['p_barcode']));
                        //check them store is sale = 1)
                        if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0 && !empty($storelistfromcache[$beginstock['s_id']]))
                        {
                            $beginstock['p_isrequestimei'] = $myProduct['p_isrequestimei'];
                            $sumbeginstockquantity += $beginstock['b_quantity'];
                            $sumbeginstockvalue += ($beginstock['b_quantity'] * $beginstock['b_costprice']);

                            $beginstockdetails['product'][$myProduct['p_id']][]         = $beginstock;
                            $beginstockdetails2keys['outputstore']['product'][$beginstock['s_id']][$myProduct['p_id']][] = $beginstock;

                            $beginstockdetails['outputstore'][$beginstock['s_id']][]        = $beginstock;
                            /*if (empty($listcategoryhaveproducts) || empty($listcategoryhaveproducts[$datebeginstock][$myProduct['pc_id']]) || !in_array($myProduct['p_id'], $listcategoryhaveproducts[$datebeginstock][$myProduct['pc_id']])){
                                $listcategoryhaveproducts[$datebeginstock][$myProduct['pc_id']][] = $myProduct['p_id'];
                            }*/
                            /*if ($myProduct['pc_id'] > 0)
                            {
                                $beginstockdetails['category'][$myProduct['pc_id']][]       = $beginstock;
                                $beginstockdetails2keys['outputstore']['category'][$beginstock['s_id']][$myProduct['pc_id']][] = $beginstock;
                            }*/
                        }
                    unset($myProduct);
                    unset($beginstock);
                }
                unset($abeginstock);
                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, array(), $datebeginstock, (string)$sumbeginstockquantity);//tong SL ton kho dau ky
                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VALUE_BEGIN, array(), $datebeginstock, (string)$sumbeginstockvalue);//tong TG ton kho dau ky
                if ($sumbeginstockquantity != 0)
                {
                    unset($sumbeginstockvalue);
                    unset($sumbeginstockquantity);
                    //1 key
                    if (!empty($beginstockdetails))
                    {
                        foreach ($beginstockdetails as $keytext => $keydetaillist)
                        {
                            foreach ($keydetaillist as $id=>$detailists)
                            {
                                $sumbeginstockquantity = 0;
                                $sumbeginstockvalue = 0;
                                foreach ($detailists as $beginstock)
                                {
                                    $sumbeginstockquantity += $beginstock['b_quantity'];
                                    if ($beginstock['p_isrequestimei'] == 1)
                                    {
                                        $sumbeginstockvalue += ($beginstock['b_quantity'] * $beginstock['b_costprice']);
                                    }
                                    elseif (!empty($listavgcost[$syear][$smonth][$beginstock['p_barcode']]))
                                    {
                                        $sumbeginstockvalue += ($beginstock['b_quantity'] * $listavgcost[$syear][$smonth][$beginstock['p_barcode']]['a_price']);
                                    }
                                    elseif (!empty($lastmonthofaveragecostprice[date('Y')]) && !empty($listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$beginstock['p_barcode']]))
                                    {
                                        $sumbeginstockvalue += ($beginstock['b_quantity'] * $listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$beginstock['p_barcode']]['a_price']);
                                    }
                                    else
                                    {
                                        //average costprice ko tim thay cho san pham nay
                                        //kiem tra averagecostprice truoc
                                        $finalcostprice = 0;
                                        $sqlcheckcostprice = 'SELECT a_price FROM '.TABLE_PREFIX.'averagecostprice
                                                                    WHERE
                                                                    a_year = ? AND
                                                                    a_price > 0 AND
                                                                    p_barcode = ? order by a_month DESC LIMIT 0, 1';
                                        $getaverageprice = $db3->query($sqlcheckcostprice, array(date('Y'), $beginstock['p_barcode']))->fetch();
                                        if (!empty($getaverageprice))
                                        {
                                            $finalcostprice = $getaverageprice['a_price'];
                                        }
                                        else//truong hop lech qua 1 nam
                                        {
                                            $getaverageprice = $db3->query($sqlcheckcostprice, array((date('Y') - 1), $beginstock['p_barcode']))->fetch();
                                            if (!empty($getaverageprice))
                                            {
                                                $finalcostprice = $getaverageprice['a_price'];
                                            }
                                            else
                                            {
                                                //sau khi averagecostprice khong co gia thi moi trong inptvoucher = sm(costprice ) / sum (quantity) trong current month - 1
                                                $lastmonth = strtotime('-1 month', $startdate);
                                                $lastmonth = strtotime(date('Y', $lastmonth).'-'.date('m', $lastmonth).'-01');
                                                $sumquantityinput = $db3->query('SELECT sum(iv_quantity) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($beginstock['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                $sumcostpriceinput = $db3->query('SELECT sum(iv_quantity*iv_inputprice) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($beginstock['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                if ($sumquantityinput > 0) $finalcostprice = round($sumcostpriceinput / $sumquantityinput, 2);
                                            }
                                        }

                                        $sumbeginstockvalue += ($beginstock['b_quantity'] * $finalcostprice);
                                        unset($sqlcheckcostprice);
                                        unset($finalcostprice);
                                        unset($getaverageprice);
                                    }
                                }
                                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, array($keytext => $id), $datebeginstock, (string)$sumbeginstockquantity);//tong SL ton kho dau ky
                                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VALUE_BEGIN, array($keytext => $id), $datebeginstock, (string)$sumbeginstockvalue);//tong TG ton kho dau ky
                                unset($beginstock);
                            }
                            unset($detailists);
                        }
                        unset($keytext);
                        unset($keydetaillist);
                    }
                    unset($beginstockdetails);

                    //2 keys
                    if (!empty($beginstockdetails2keys))
                    {
                        foreach ($beginstockdetails2keys as $keytext1 => $keydetaillist1)
                        {
                            foreach ($keydetaillist1 as $keytext => $keydetaillist2)
                            {
                                foreach ($keydetaillist2 as $id1=>$keydetaillist)
                                {
                                    foreach ($keydetaillist as $id=>$detailists)
                                    {
                                        $sumbeginstockquantity = 0;
                                        $sumbeginstockvalue = 0;
                                        foreach ($detailists as $beginstock)
                                        {
                                            $sumbeginstockquantity += $beginstock['b_quantity'];
                                            if ($beginstock['p_isrequestimei'] == 1)
                                            {
                                                $sumbeginstockvalue += ($beginstock['b_quantity'] * $beginstock['b_costprice']);
                                            }
                                            elseif (!empty($listavgcost[$syear][(int)$smonth][$beginstock['p_barcode']]))
                                            {
                                                $sumbeginstockvalue += ($beginstock['b_quantity'] * $listavgcost[$syear][$smonth][$beginstock['p_barcode']]['a_price']);
                                            }
                                            elseif (!empty($lastmonthofaveragecostprice[date('Y')]) && !empty($listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$beginstock['p_barcode']]))
                                            {
                                                $sumbeginstockvalue += ($beginstock['b_quantity'] * $listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$beginstock['p_barcode']]['a_price']);
                                            }
                                            else
                                            {
                                                //average costprice ko tim thay cho san pham nay
                                                //kiem tra averagecostprice truoc
                                                $finalcostprice = 0;
                                                $sqlcheckcostprice = 'SELECT a_price FROM '.TABLE_PREFIX.'averagecostprice
                                                                            WHERE
                                                                            a_year = ? AND
                                                                            a_price > 0 AND
                                                                            p_barcode = ? order by a_month DESC LIMIT 0, 1';
                                                $getaverageprice = $db3->query($sqlcheckcostprice, array(date('Y'), $beginstock['p_barcode']))->fetch();
                                                if (!empty($getaverageprice))
                                                {
                                                    $finalcostprice = $getaverageprice['a_price'];
                                                }
                                                else//truong hop lech qua 1 nam
                                                {
                                                    $getaverageprice = $db3->query($sqlcheckcostprice, array((date('Y') - 1), $beginstock['p_barcode']))->fetch();
                                                    if (!empty($getaverageprice))
                                                    {
                                                        $finalcostprice = $getaverageprice['a_price'];
                                                    }
                                                    else
                                                    {
                                                        //sau khi averagecostprice khong co gia thi moi trong inptvoucher = sm(costprice ) / sum (quantity) trong current month - 1
                                                        $lastmonth = strtotime('-1 month', $startdate);
                                                        $lastmonth = strtotime(date('Y', $lastmonth).'-'.date('m', $lastmonth).'-01');
                                                        $sumquantityinput = $db3->query('SELECT sum(iv_quantity) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($beginstock['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                        $sumcostpriceinput = $db3->query('SELECT sum(iv_quantity*iv_inputprice) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($beginstock['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                        if ($sumquantityinput > 0) $finalcostprice = round($sumcostpriceinput / $sumquantityinput, 2);
                                                    }
                                                }

                                                $sumbeginstockvalue += ($beginstock['b_quantity'] * $finalcostprice);
                                                unset($sqlcheckcostprice);
                                                unset($finalcostprice);
                                                unset($getaverageprice);
                                            }
                                        }
                                        Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, array($keytext1 => $id1, $keytext => $id), $datebeginstock, (string)$sumbeginstockquantity);//tong SL ton kho dau ky
                                        Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VALUE_BEGIN, array($keytext1 => $id1, $keytext => $id), $datebeginstock, (string)$sumbeginstockvalue);//tong TG ton kho dau ky
                                        unset($beginstock);
                                    }
                                    unset($detailists);
                                }

                            }
                        }
                    }
                    unset($keytext1);
                    unset($keydetaillist1);
                    unset($keydetaillist2);
                    unset($keytext);
                    unset($keydetaillist);
                    unset($beginstockdetails);
                    unset($beginstockcategoriesid);

                }
                unset($sumbeginstockvalue);
            }
        }
        //

        $datetime = $startdate;
        while ($datetime <= $enddatenotime)
        {
            $datevalue = date('Y/m/d', $datetime);

            //Tinh cho output voucher
            if (!empty($listoutputvouchers[$datetime]))
            {
                $vouchers = $listoutputvouchers[$datetime];
                //Tong so luong don hang trong  1 ngay
                //Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array(), $datevalue, (string)count($vouchers));//tong so luong don hang
                $listVoucherDetails = array();
                $listVoucherDetails2keys = array();
                $listVoucherCategoriesId = array();

                foreach ($vouchers as $vcid => $voucherdetail)
                {
                    foreach ($voucherdetail as $vcd)
                    {
                        if ($vcd['ov_voucherisdelete'] != 1 && $vcd['ov_voucherdetailisdelete'] != 1)
                        {
                            $tpbarcode = trim($vcd['p_barcode']);
                            $myProduct = Core_Product::getProductIDByBarcode($tpbarcode);
                            //check them store is sale = 1)
                            if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0 && !empty($storelistfromcache[$vcd['s_id']]))
                            {
                                $newvcd = $vcd;
                                $newvcd['p_isrequestimei'] = $myProduct['p_isrequestimei'];
                                $listVoucherDetails['product'][$myProduct['p_id']][]    = $newvcd;
                                $listVoucherDetails2keys['outputstore']['product'][$vcd['s_id']][$myProduct['p_id']][]      = $newvcd;

                                $listVoucherDetails['outputstore'][$vcd['s_id']][]      = $newvcd;
                                /*if ($myProduct['pc_id'] > 0)
                                {
                                    $listVoucherDetails['category'][$myProduct['pc_id']][]      = $newvcd;
                                    $listVoucherDetails2keys['outputstore']['category'][$vcd['s_id']][$myProduct['pc_id']][] = $newvcd;
                                }*/

                                /*if (empty($listcategoryhaveproducts) || empty($listcategoryhaveproducts[$datevalue][$myProduct['pc_id']]) || !in_array($myProduct['p_id'], $listcategoryhaveproducts[$datevalue][$myProduct['pc_id']])){
                                    $listcategoryhaveproducts[$datevalue][$myProduct['pc_id']][] = $myProduct['p_id'];
                                }*/
                                unset($newvcd);
                            }
                            unset($myProduct);
                        }
                    }
                }
                unset($voucherdetail);

                //Tinh toan luu xuong cache theo 1 keys
                if (!empty($listVoucherDetails))
                {
                    foreach ($listVoucherDetails as $textkey => $voucherObject)
                    {
                        if (empty($voucherObject)) continue;
                        foreach ($voucherObject as $id => $voucherdetail)
                        {
                            if (empty($voucherdetail)) continue;
                            //Tinh theo voucher
                            $sumsoluong = 0;
                            $doanhthuchuav = 0;
                            $doanhthucov = 0;
                            $giavon = 0;
                            $xuatban = 0; //xuat ban
                            $xuatnoibo = 0;
                            $xuattrahang = 0;
                            $xuatkhac = 0;
                            $tgxuatban = 0; //xuat ban
                            $tgxuatnoibo = 0;
                            $tgxuattrahang = 0;
                            $tgxuatkhac = 0;
                            $xuatdauky = 0;
                            $tgxuatdauky = 0;

                            $conditiondata = array();
                            $countVoucherIds = array();
                            if ($textkey != 'all') $conditiondata[$textkey] = $id;
                            foreach($voucherdetail as $vcd)
                            {
                                if (!empty($listoutputtypeissale[$vcd['po_id']]))
                                {
                                    $vat = 0;
                                    if ($vcd['ov_vatpercent'] > 0) $vat = $vcd['ov_vat']/ $vcd['ov_vatpercent'];
                                    $avgcostprice = array();
                                    if (!empty($listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']]))
                                    {
                                        $avgcostprice = $listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']];
                                    }
                                    elseif (!empty($lastmonthofaveragecostprice[date('Y')]) && !empty($listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']]))
                                    {
                                        $avgcostprice = $listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']];
                                    }
                                    else
                                    {
                                        //average costprice ko tim thay cho san pham nay
                                        //kiem tra averagecostprice truoc
                                        $finalcostprice = 0;
                                        $sqlcheckcostprice = 'SELECT a_price FROM '.TABLE_PREFIX.'averagecostprice
                                                                    WHERE
                                                                    a_year = ? AND
                                                                    a_price > 0 AND
                                                                    p_barcode = ? order by a_month DESC LIMIT 0, 1';
                                        $getaverageprice = $db3->query($sqlcheckcostprice, array(date('Y'), $vcd['p_barcode']))->fetch();
                                        if (!empty($getaverageprice))
                                        {
                                            $finalcostprice = $getaverageprice['a_price'];
                                        }
                                        else//truong hop lech qua 1 nam
                                        {
                                            $getaverageprice = $db3->query($sqlcheckcostprice, array((date('Y') - 1), $vcd['p_barcode']))->fetch();
                                            if (!empty($getaverageprice))
                                            {
                                                $finalcostprice = $getaverageprice['a_price'];
                                            }
                                            else
                                            {
                                                //sau khi averagecostprice khong co gia thi moi trong inptvoucher = sm(costprice ) / sum (quantity) trong current month - 1
                                                $lastmonth = strtotime('-1 month', $startdate);
                                                $lastmonth = strtotime(date('Y', $lastmonth).'-'.date('m', $lastmonth).'-01');
                                                $sumquantityinput = $db3->query('SELECT sum(iv_quantity) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                $sumcostpriceinput = $db3->query('SELECT sum(iv_quantity*iv_inputprice) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                if ($sumquantityinput > 0) $finalcostprice = round($sumcostpriceinput / $sumquantityinput, 2);
                                            }
                                        }

                                        $avgcostprice['a_price'] = $finalcostprice;
                                        unset($sqlcheckcostprice);
                                        unset($finalcostprice);
                                        unset($getaverageprice);
                                    }
                                    $xuatdauky          += $vcd['ov_quantity'];
                                    $tgxuatdauky        += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                    if ($listoutputtypeissale[$vcd['po_id']]['po_issale'] == 1 && $listoutputtypeissale[$vcd['po_id']]['po_isinternalsale'] != 1 && $vcd['po_id'] != 5 && $vcd['po_id'] != 281 && $vcd['po_id'] != 321)
                                    {
                                        $xuatban            += $vcd['ov_quantity'];
                                        $tgxuatban          += ($vcd['ov_quantity'] * $vcd['ov_costprice']);
                                    }
                                    elseif($listoutputtypeissale[$vcd['po_id']]['po_isinternalsale'] == 1 && $vcd['po_id'] != 5 && $vcd['po_id'] != 281 && $vcd['po_id'] != 321)
                                    {
                                        $xuatnoibo      += $vcd['ov_quantity'];
                                        $tgxuatnoibo    += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                    }
                                    elseif ($vcd['po_id'] == 5 || $vcd['po_id'] == 281 || $vcd['po_id'] == 321)
                                    {
                                        $xuattrahang        += $vcd['ov_quantity'];
                                        $tgxuattrahang      += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                    }
                                    else
                                    {
                                        $xuatkhac           += $vcd['ov_quantity'];
                                        $tgxuatkhac     += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                    }

                                    if ($listoutputtypeissale[$vcd['po_id']]['po_issale'] == 1)
                                    {
                                        $doanhthuchuav1item = ($vcd['ov_quantity'] * $vcd['ov_saleprice']);

                                        $discountitem = 0;
                                        $doanhthuchuav1item = $doanhthuchuav1item - $discountitem;
                                        $doanhthucov1item   = $doanhthuchuav1item + ($doanhthuchuav1item * $vat);

                                        $doanhthuchuav      += $doanhthuchuav1item;
                                        $doanhthucov        += $doanhthucov1item;
                                        $sumsoluong         += $vcd['ov_quantity'];

                                        $giavon             += ($vcd['ov_quantity'] * $this->getoutputprice($vcd, $avgcostprice));

                                        unset($discountitem);
                                    }
                                    if ($textkey != 'all')
                                    {
                                        if (!empty($countVoucherIds[$vcd['ov_outputvoucherid']]))
                                        {
                                            $countVoucherIds[$vcd['ov_outputvoucherid']]++;
                                        }
                                        else $countVoucherIds[$vcd['ov_outputvoucherid']] = 1;
                                    }
                                }
                            }

                            if ($textkey != 'all')
                            {
                                //Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, $conditiondata, $datevalue, (string)count($countVoucherIds));//tong so luong don hang

                            }
                            unset($countVoucherIds);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, $conditiondata, $datevalue, (string)$doanhthucov);//doanh thu co +v
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $conditiondata, $datevalue, (string)$doanhthuchuav);//doanh thu chua v
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, $conditiondata, $datevalue, (string)$sumsoluong);//sl thuc ban
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_COSTPRICE, $conditiondata, $datevalue, (string)$giavon);//gia von ban
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, $conditiondata, $datevalue, (string)($doanhthuchuav - $giavon));//lai gop

                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VALUE, $conditiondata, $datevalue, (string)$tgxuatban);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VOLUME, $conditiondata, $datevalue, (string)$xuatban);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $conditiondata, $datevalue, (string)$tgxuatdauky);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $conditiondata, $datevalue, (string)$xuatdauky);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $conditiondata, $datevalue, (string)$tgxuatnoibo);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $conditiondata, $datevalue, (string)$xuatnoibo);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $conditiondata, $datevalue, (string)$tgxuattrahang);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $conditiondata, $datevalue, (string)$xuattrahang);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $conditiondata, $datevalue, (string)$tgxuatkhac);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $conditiondata, $datevalue, (string)$xuatkhac);

                            unset($vcd);
                            unset($giavonhangkm);
                            unset($sumsoluong);
                            unset($doanhthuchuav);
                            unset($doanhthucov);
                            unset($giavon);
                            unset($xuatban); //xuat ban
                            unset($xuatnoibo);
                            unset($xuattrahang);
                            unset($xuatkhac);
                            unset($tgxuatban); //xuat ban
                            unset($tgxuatnoibo);
                            unset($tgxuattrahang);
                            unset($tgxuatkhac);
                            unset($xuatdauky);
                            unset($tgxuatdauky);
                        }
                    }
                }//end of 1 key

                //Tinh toan luu xuong cache theo 2 keys
                if (!empty($listVoucherDetails2keys))
                {
                    foreach ($listVoucherDetails2keys as $keytext1 => $listVoucherDetails1)
                    {
                        if (empty($listVoucherDetails1)) continue;
                        foreach ($listVoucherDetails1 as $textkey => $listVoucherDetails2)
                        {
                            if (empty($listVoucherDetails2)) continue;
                            foreach ($listVoucherDetails2 as $id1 => $listVoucherObjects)
                            {
                                if (empty($listVoucherObjects)) continue;
                                foreach ($listVoucherObjects as $id => $voucherdetail)
                                {
                                    //Tinh theo voucher
                                    $sumsoluong = 0;
                                    $doanhthuchuav = 0;
                                    $doanhthucov = 0;
                                    $giavon = 0;
                                    $xuatban = 0; //xuat ban
                                    $xuatnoibo = 0;
                                    $xuattrahang = 0;
                                    $xuatkhac = 0;
                                    $tgxuatban = 0; //xuat ban
                                    $tgxuatnoibo = 0;
                                    $tgxuattrahang = 0;
                                    $tgxuatkhac = 0;
                                    $xuatdauky = 0;
                                    $tgxuatdauky = 0;

                                    $conditiondata = array();
                                    $countVoucherIds = array();
                                    $conditiondata[$textkey] = $id;
                                    $conditiondata[$keytext1] = $id1;
                                    foreach($voucherdetail as $vcd)
                                    {
                                        if (!empty($listoutputtypeissale[$vcd['po_id']]))
                                        {
                                            $vat = 0;
                                            if ($vcd['ov_vatpercent'] > 0) $vat = $vcd['ov_vat']/ $vcd['ov_vatpercent'];

                                            $avgcostprice = array();

                                            if (!empty($listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']]))
                                            {
                                                $avgcostprice = $listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']];
                                            }
                                            elseif (!empty($lastmonthofaveragecostprice[date('Y')]) && !empty($listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']]))
                                            {
                                                $avgcostprice = $listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']];
                                            }
                                            else
                                            {
                                                //average costprice ko tim thay cho san pham nay
                                                //kiem tra averagecostprice truoc
                                                $finalcostprice = 0;
                                                $sqlcheckcostprice = 'SELECT a_price FROM '.TABLE_PREFIX.'averagecostprice
                                                                            WHERE
                                                                            a_year = ? AND
                                                                            a_price > 0 AND
                                                                            p_barcode = ? order by a_month DESC LIMIT 0, 1';
                                                $getaverageprice = $db3->query($sqlcheckcostprice, array(date('Y'), $vcd['p_barcode']))->fetch();
                                                if (!empty($getaverageprice))
                                                {
                                                    $finalcostprice = $getaverageprice['a_price'];
                                                }
                                                else//truong hop lech qua 1 nam
                                                {
                                                    $getaverageprice = $db3->query($sqlcheckcostprice, array((date('Y') - 1), $vcd['p_barcode']))->fetch();
                                                    if (!empty($getaverageprice))
                                                    {
                                                        $finalcostprice = $getaverageprice['a_price'];
                                                    }
                                                    else
                                                    {
                                                        //sau khi averagecostprice khong co gia thi moi trong inptvoucher = sm(costprice ) / sum (quantity) trong current month - 1
                                                        $lastmonth = strtotime('-1 month', $startdate);
                                                        $lastmonth = strtotime(date('Y', $lastmonth).'-'.date('m', $lastmonth).'-01');
                                                        $sumquantityinput = $db3->query('SELECT sum(iv_quantity) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                        $sumcostpriceinput = $db3->query('SELECT sum(iv_quantity*iv_inputprice) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                        if ($sumquantityinput > 0) $finalcostprice = round($sumcostpriceinput / $sumquantityinput, 2);
                                                    }
                                                }

                                                $avgcostprice['a_price'] = $finalcostprice;
                                                unset($sqlcheckcostprice);
                                                unset($finalcostprice);
                                                unset($getaverageprice);
                                            }
                                            $xuatdauky          += $vcd['ov_quantity'];
                                            $tgxuatdauky        += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                            if ($listoutputtypeissale[$vcd['po_id']]['po_issale'] == 1 && $listoutputtypeissale[$vcd['po_id']]['po_isinternalsale'] != 1 && $vcd['po_id'] != 5 && $vcd['po_id'] != 281 && $vcd['po_id'] != 321)
                                            {
                                                $xuatban            += $vcd['ov_quantity'];
                                                $tgxuatban          += ($vcd['ov_quantity'] * $vcd['ov_costprice']);
                                            }
                                            elseif($listoutputtypeissale[$vcd['po_id']]['po_isinternalsale'] == 1 && $vcd['po_id'] != 5 && $vcd['po_id'] != 281 && $vcd['po_id'] != 321)
                                            {
                                                $xuatnoibo      += $vcd['ov_quantity'];
                                                $tgxuatnoibo    += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                            }
                                            elseif ($vcd['po_id'] == 5 || $vcd['po_id'] == 281 || $vcd['po_id'] == 321)
                                            {
                                                $xuattrahang        += $vcd['ov_quantity'];
                                                $tgxuattrahang      += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                            }
                                            else
                                            {
                                                $xuatkhac           += $vcd['ov_quantity'];
                                                $tgxuatkhac     += ($vcd['ov_quantity'] * $vcd['ov_costprice']);//$this->getoutputprice($vcd, $avgcostprice));
                                            }

                                            if ($listoutputtypeissale[$vcd['po_id']]['po_issale'] == 1)
                                            {
                                                $doanhthuchuav1item = ($vcd['ov_quantity'] * $vcd['ov_saleprice']);

                                                $discountitem = 0;
                                                $doanhthuchuav1item = $doanhthuchuav1item - $discountitem;
                                                $doanhthucov1item   = $doanhthuchuav1item + ($doanhthuchuav1item * $vat);

                                                $doanhthuchuav      += $doanhthuchuav1item;
                                                $doanhthucov        += $doanhthucov1item;
                                                $sumsoluong         += $vcd['ov_quantity'];

                                                $giavon             += ($vcd['ov_quantity'] * $this->getoutputprice($vcd, $avgcostprice));

                                                unset($discountitem);
                                            }
                                            if (!empty($countVoucherIds[$vcd['ov_outputvoucherid']]))
                                            {
                                                $countVoucherIds[$vcd['ov_outputvoucherid']]++;
                                            }
                                            else $countVoucherIds[$vcd['ov_outputvoucherid']] = 1;
                                        }
                                    }

                                    if (1)//!empty($countVoucherIds))
                                    {
                                        //Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, $conditiondata, $datevalue, (string)count($countVoucherIds));//tong so luong don hang
                                    }
                                    unset($countVoucherIds);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, $conditiondata, $datevalue, (string)$doanhthucov);//doanh thu co +v
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $conditiondata, $datevalue, (string)$doanhthuchuav);//doanh thu chua v
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, $conditiondata, $datevalue, (string)$sumsoluong);//sl thuc ban
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_COSTPRICE, $conditiondata, $datevalue, (string)$giavon);//gia von ban
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROFIT_ITEM, $conditiondata, $datevalue, (string)($doanhthuchuav - $giavon));//lai gop

                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VALUE, $conditiondata, $datevalue, (string)$tgxuatban);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VOLUME, $conditiondata, $datevalue, (string)$xuatban);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $conditiondata, $datevalue, (string)$tgxuatdauky);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $conditiondata, $datevalue, (string)$xuatdauky);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $conditiondata, $datevalue, (string)$tgxuatnoibo);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $conditiondata, $datevalue, (string)$xuatnoibo);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $conditiondata, $datevalue, (string)$tgxuattrahang);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $conditiondata, $datevalue, (string)$xuattrahang);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $conditiondata, $datevalue, (string)$tgxuatkhac);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $conditiondata, $datevalue, (string)$xuatkhac);

                                    unset($vcd);
                                    unset($sumsoluong);
                                    unset($doanhthuchuav);
                                    unset($doanhthucov);
                                    unset($giavon);
                                    unset($xuatban); //xuat ban
                                    unset($xuatnoibo);
                                    unset($xuattrahang);
                                    unset($xuatkhac);
                                    unset($tgxuatban); //xuat ban
                                    unset($tgxuatnoibo);
                                    unset($tgxuattrahang);
                                    unset($tgxuatkhac);
                                    unset($xuatdauky);
                                    unset($tgxuatdauky);

                                }
                            }
                        }
                    }
                }
                unset($voucherdetail);
                unset($listVoucherDetails2);
                unset($listVoucherDetails1);
                unset($listVoucherDetails);
                unset($listVoucherDetails2keys);
                unset($listVoucherCategoriesId);
            }

            //Tinh theo input voucher
            if (!empty($listinputvouchers[$datetime]))
            {
                $vouchers = $listinputvouchers[$datetime];

                $listVoucherDetails         = array();
                $listVoucherDetails2keys    = array();
                $listVoucherCategoriesId    = array();

                foreach ($vouchers as $vcid => $voucherdetail)
                {
                    foreach ($voucherdetail as $vcd)
                    {
                        if ($vcd['iv_isvoucherdelete'] != 1 && $vcd['iv_isvoucherdetaildelete'] != 1)
                        {
                            $myProduct = Core_Product::getProductIDByBarcode(trim($vcd['p_barcode']));
                            //check them store is sale = 1)
                            if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0 && !empty($storelistfromcache[$vcd['s_id']]))
                            {
                                $newvcd = $vcd;
                                $newvcd['p_isrequestimei'] = $myProduct['p_isrequestimei'];

                                $listVoucherDetails['product'][$myProduct['p_id']][]    = $newvcd;
                                $listVoucherDetails2keys['inputstore']['product'][$vcd['s_id']][$myProduct['p_id']][]       = $newvcd;

                                $listVoucherDetails['inputstore'][$vcd['s_id']][]       = $newvcd;
                                /*if ($myProduct['pc_id'] > 0)
                                {
                                    $listVoucherDetails['category'][$myProduct['pc_id']][]      = $newvcd;
                                    $listVoucherDetails2keys['inputstore']['category'][$vcd['s_id']][$myProduct['pc_id']][] = $newvcd;
                                }*/
                                /*if (empty($listcategoryhaveproducts) || empty($listcategoryhaveproducts[$datevalue][$myProduct['pc_id']]) || !in_array($myProduct['p_id'], $listcategoryhaveproducts[$datevalue][$myProduct['pc_id']])){
                                    $listcategoryhaveproducts[$datevalue][$myProduct['pc_id']][] = $myProduct['p_id'];
                                }*/
                                unset($newvcd);
                            }
                            unset($myProduct);
                        }
                    }
                }
                unset($voucherdetail);

                //Tinh toan luu xuong cache 1 keyss
                if (!empty($listVoucherDetails))
                {
                    foreach ($listVoucherDetails as $textkey => $voucherObject)
                    {
                        foreach ($voucherObject as $id => $voucherdetail)
                        {
                            //Tinh theo voucher
                            $sumsoluong = 0;
                            $doanhthuchuav = 0;
                            $doanhthucov = 0;
                            $giavon = 0;
                            $nhapmua = 0; //nhap mua
                            $nhapnoibo = 0;
                            $nhaptrahang = 0;
                            $nhapkhac = 0;
                            $tgnhapmua = 0; //nhap mua
                            $tgnhapnoibo = 0;
                            $tgnhaptrahang = 0;
                            $tgnhapkhac = 0;

                            $nhapdauky = 0;
                            $tgnhapdauky = 0;

                            $conditiondata = array();
                            if ($textkey != 'all') $conditiondata[$textkey] = $id;
                            foreach($voucherdetail as $vcd)
                            {
                                if (!empty($listinputputtypeisreturnsale[$vcd['pi_id']]))
                                {
                                    $avgcostprice = array();
                                    if (!empty($listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']]))
                                    {
                                        $avgcostprice = $listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']];
                                    }
                                    elseif (!empty($lastmonthofaveragecostprice[date('Y')]) && !empty($listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']]))
                                    {
                                        $avgcostprice = $listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']];
                                    }
                                    else
                                    {
                                        //average costprice ko tim thay cho san pham nay
                                        //kiem tra averagecostprice truoc
                                        $finalcostprice = 0;
                                        $sqlcheckcostprice = 'SELECT a_price FROM '.TABLE_PREFIX.'averagecostprice
                                                                    WHERE
                                                                    a_year = ? AND
                                                                    a_price > 0 AND
                                                                    p_barcode = ? order by a_month DESC LIMIT 0, 1';
                                        $getaverageprice = $db3->query($sqlcheckcostprice, array(date('Y'), $vcd['p_barcode']))->fetch();
                                        if (!empty($getaverageprice))
                                        {
                                            $finalcostprice = $getaverageprice['a_price'];
                                        }
                                        else//truong hop lech qua 1 nam
                                        {
                                            $getaverageprice = $db3->query($sqlcheckcostprice, array((date('Y') - 1), $vcd['p_barcode']))->fetch();
                                            if (!empty($getaverageprice))
                                            {
                                                $finalcostprice = $getaverageprice['a_price'];
                                            }
                                            else
                                            {
                                                //sau khi averagecostprice khong co gia thi moi trong inptvoucher = sm(costprice ) / sum (quantity) trong current month - 1
                                                $lastmonth = strtotime('-1 month', $startdate);
                                                $lastmonth = strtotime(date('Y', $lastmonth).'-'.date('m', $lastmonth).'-01');
                                                $sumquantityinput = $db3->query('SELECT sum(iv_quantity) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                $sumcostpriceinput = $db3->query('SELECT sum(iv_quantity*iv_inputprice) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                if ($sumquantityinput > 0) $finalcostprice = round($sumcostpriceinput / $sumquantityinput, 2);
                                            }
                                        }

                                        $avgcostprice['a_price'] = $finalcostprice;
                                        unset($sqlcheckcostprice);
                                        unset($finalcostprice);
                                        unset($getaverageprice);
                                    }

                                    $nhapdauky          += $vcd['iv_quantity'];
                                    $tgnhapdauky        += ($vcd['iv_quantity'] * $vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));

                                    if ($listinputputtypeisreturnsale[$vcd['pi_id']]['pi_isreturnsale'] == 0 && $vcd['pi_id'] != 8 && $vcd['pi_id'] != 20)
                                    {
                                        $nhapmua            += $vcd['iv_quantity'];
                                        $tgnhapmua          += ($vcd['iv_quantity'] * $vcd['iv_price']);//$vcd['iv_inputprice']);
                                    }
                                    elseif ($vcd['pi_id'] == 8 || $vcd['pi_id'] == 20)
                                    {
                                        $nhapnoibo          += $vcd['iv_quantity'];
                                        $tgnhapnoibo        += ($vcd['iv_quantity'] * $vcd['iv_price']);//$vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));
                                    }
                                    elseif ($listinputputtypeisreturnsale[$vcd['pi_id']]['pi_isreturnsale'] == 1 && $vcd['pi_id'] != 8 && $vcd['pi_id'] != 20)
                                    {
                                        $nhaptrahang        += $vcd['iv_quantity'];
                                        $tgnhaptrahang      += ($vcd['iv_quantity'] * $vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));
                                    }
                                    else
                                    {
                                        $nhapkhac           += $vcd['iv_quantity'];
                                        $tgnhapkhac         += ($vcd['iv_quantity'] * $vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));
                                    }

                                    if ($listinputputtypeisreturnsale[$vcd['pi_id']]['pi_isreturnsale'] == 1)
                                    {
                                        $sumsoluong         += $vcd['iv_quantity'];

                                        $vat = 0;
                                        if ($vcd['iv_vatpercent'] > 0) $vat = $vcd['iv_vat']/ $vcd['iv_vatpercent'];

                                        $doanhthuchuav1item  = ($vcd['iv_quantity'] * $vcd['iv_price']);
                                        $doanhthucov1item    = $doanhthuchuav1item + ($doanhthuchuav1item * $vat);

                                        $doanhthucov        += $doanhthucov1item;
                                        $doanhthuchuav      += $doanhthuchuav1item;

                                        $giavon             += ($vcd['iv_quantity'] * $this->getinputprice($vcd, $avgcostprice));
                                    }
                                }
                            }

                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_VALUE, $conditiondata, $datevalue, (string)$doanhthucov);//doanh thu tra lai co +v
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_VALUE_NOVAT, $conditiondata, $datevalue, (string)$doanhthuchuav);//doanh thu tra lai chua v
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_VOLUME, $conditiondata, $datevalue, (string)$sumsoluong);//sl tra lai
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VALUE, $conditiondata, $datevalue, (string)$tgnhapmua);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VOLUME, $conditiondata, $datevalue, (string)$nhapmua);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $conditiondata, $datevalue, (string)$tgnhapdauky);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $conditiondata, $datevalue, (string)$nhapdauky);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $conditiondata, $datevalue, (string)$tgnhapnoibo);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $conditiondata, $datevalue, (string)$nhapnoibo);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $conditiondata, $datevalue, (string)$tgnhaptrahang);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $conditiondata, $datevalue, (string)$nhaptrahang);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VALUE, $conditiondata, $datevalue, (string)$tgnhapkhac);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $conditiondata, $datevalue, (string)$nhapkhac);

                            unset($vcd);
                            unset($sumsoluong);
                            unset($doanhthuchuav);
                            unset($doanhthucov);
                            unset($giavon);
                            unset($nhapmua); //nhap mua
                            unset($nhapnoibo);
                            unset($nhaptrahang);
                            unset($nhapkhac);
                            unset($tgnhapmua); //nhap mua
                            unset($tgnhapnoibo);
                            unset($tgnhaptrahang);
                            unset($tgnhapkhac);
                            unset($nhapdauky);
                            unset($tgnhapdauky);
                        }
                    }
                }

                //Tinh toan luu xuong cache 2 keyss
                if (!empty($listVoucherDetails2keys))
                {
                    foreach ($listVoucherDetails2keys as $textkey1 => $listvoucherDetails1)
                    {
                        foreach ($listvoucherDetails1 as $textkey => $listVoucherDetails2)
                        {
                            foreach ($listVoucherDetails2 as $id1 => $listVoucherObjects)
                            {
                                foreach ($listVoucherObjects as $id => $voucherdetail)
                                {
                                    //Tinh theo voucher
                                    $sumsoluong = 0;
                                    $doanhthuchuav = 0;
                                    $doanhthucov = 0;
                                    $giavon = 0;
                                    $nhapmua = 0; //nhap mua
                                    $nhapnoibo = 0;
                                    $nhaptrahang = 0;
                                    $nhapkhac = 0;
                                    $tgnhapmua = 0; //nhap mua
                                    $tgnhapnoibo = 0;
                                    $tgnhaptrahang = 0;
                                    $tgnhapkhac = 0;

                                    $nhapdauky = 0;
                                    $tgnhapdauky = 0;

                                    $conditiondata = array();
                                    $conditiondata[$textkey] = $id;
                                    $conditiondata[$textkey1] = $id1;
                                    foreach($voucherdetail as $vcd)
                                    {
                                        if (!empty($listinputputtypeisreturnsale[$vcd['pi_id']]))
                                        {
                                            $avgcostprice = array();
                                            if (!empty($listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']]))
                                            {
                                                $avgcostprice = $listavgcost[date('Y', $datetime)][date('n', $datetime)][$vcd['p_barcode']];
                                            }
                                            elseif (!empty($lastmonthofaveragecostprice[date('Y')]) && !empty($listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']]))
                                            {
                                                $avgcostprice = $listavgcost[$lastyearofaveragecostprice][$lastmonthofaveragecostprice[date('Y')]][$vcd['p_barcode']];
                                            }
                                            else
                                            {
                                                //average costprice ko tim thay cho san pham nay
                                                //kiem tra averagecostprice truoc
                                                $finalcostprice = 0;
                                                $sqlcheckcostprice = 'SELECT a_price FROM '.TABLE_PREFIX.'averagecostprice
                                                                            WHERE
                                                                            a_year = ? AND
                                                                            a_price > 0 AND
                                                                            p_barcode = ? order by a_month DESC LIMIT 0, 1';
                                                $getaverageprice = $db3->query($sqlcheckcostprice, array(date('Y'), $vcd['p_barcode']))->fetch();
                                                if (!empty($getaverageprice))
                                                {
                                                    $finalcostprice = $getaverageprice['a_price'];
                                                }
                                                else//truong hop lech qua 1 nam
                                                {
                                                    $getaverageprice = $db3->query($sqlcheckcostprice, array((date('Y') - 1), $vcd['p_barcode']))->fetch();
                                                    if (!empty($getaverageprice))
                                                    {
                                                        $finalcostprice = $getaverageprice['a_price'];
                                                    }
                                                    else
                                                    {
                                                        //sau khi averagecostprice khong co gia thi moi trong inptvoucher = sm(costprice ) / sum (quantity) trong current month - 1
                                                        $lastmonth = strtotime('-1 month', $startdate);
                                                        $lastmonth = strtotime(date('Y', $lastmonth).'-'.date('m', $lastmonth).'-01');
                                                        $sumquantityinput = $db3->query('SELECT sum(iv_quantity) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                        $sumcostpriceinput = $db3->query('SELECT sum(iv_quantity*iv_inputprice) FROM '.TABLE_PREFIX.'inputvoucher WHERE p_barcode = ? AND iv_inputdate >= ? AND iv_inputdate <= ? AND pi_id NOT IN (221, 8, 13)', array($vcd['p_barcode'], $lastmonth, time()))->fetchColumn(0);
                                                        if ($sumquantityinput > 0) $finalcostprice = round($sumcostpriceinput / $sumquantityinput, 2);
                                                    }
                                                }

                                                $avgcostprice['a_price'] = $finalcostprice;
                                                unset($sqlcheckcostprice);
                                                unset($finalcostprice);
                                                unset($getaverageprice);
                                            }

                                            $nhapdauky          += $vcd['iv_quantity'];
                                            $tgnhapdauky        += ($vcd['iv_quantity'] * $vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));

                                            if ($listinputputtypeisreturnsale[$vcd['pi_id']]['pi_isreturnsale'] == 0 && $vcd['pi_id'] != 8 && $vcd['pi_id'] != 20)
                                            {
                                                $nhapmua            += $vcd['iv_quantity'];
                                                $tgnhapmua          += ($vcd['iv_quantity'] * $vcd['iv_price']);//$vcd['iv_inputprice']);
                                            }
                                            elseif ($vcd['pi_id'] == 8 || $vcd['pi_id'] == 20)
                                            {
                                                $nhapnoibo          += $vcd['iv_quantity'];
                                                $tgnhapnoibo        += ($vcd['iv_quantity'] * $vcd['iv_price']);//$vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));
                                            }
                                            elseif ($listinputputtypeisreturnsale[$vcd['pi_id']]['pi_isreturnsale'] == 1 && $vcd['pi_id'] != 8 && $vcd['pi_id'] != 20)
                                            {
                                                $nhaptrahang        += $vcd['iv_quantity'];
                                                $tgnhaptrahang      += ($vcd['iv_quantity'] * $vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));
                                            }
                                            else
                                            {
                                                $nhapkhac           += $vcd['iv_quantity'];
                                                $tgnhapkhac         += ($vcd['iv_quantity'] * $vcd['iv_inputprice']);//$this->getinputprice($vcd, $avgcostprice));
                                            }

                                            if ($listinputputtypeisreturnsale[$vcd['pi_id']]['pi_isreturnsale'] == 1)
                                            {
                                                $sumsoluong         += $vcd['iv_quantity'];

                                                $vat = 0;
                                                if ($vcd['iv_vatpercent'] > 0) $vat = $vcd['iv_vat']/ $vcd['iv_vatpercent'];

                                                $doanhthuchuav1item  = ($vcd['iv_quantity'] * $vcd['iv_price']);
                                                $doanhthucov1item    = $doanhthuchuav1item + ($doanhthuchuav1item * $vat);

                                                $doanhthucov        += $doanhthucov1item;
                                                $doanhthuchuav      += $doanhthuchuav1item;

                                                $giavon             += ($vcd['iv_quantity'] * $this->getinputprice($vcd, $avgcostprice));
                                            }
                                        }
                                    }

                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_VALUE, $conditiondata, $datevalue, (string)$doanhthucov);//doanh thu tra lai co +v
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_VALUE_NOVAT, $conditiondata, $datevalue, (string)$doanhthuchuav);//doanh thu tra lai chua v
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_VOLUME, $conditiondata, $datevalue, (string)$sumsoluong);//sl tra lai
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VALUE, $conditiondata, $datevalue, (string)$tgnhapmua);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VOLUME, $conditiondata, $datevalue, (string)$nhapmua);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $conditiondata, $datevalue, (string)$tgnhapdauky);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $conditiondata, $datevalue, (string)$nhapdauky);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $conditiondata, $datevalue, (string)$tgnhapnoibo);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $conditiondata, $datevalue, (string)$nhapnoibo);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $conditiondata, $datevalue, (string)$tgnhaptrahang);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $conditiondata, $datevalue, (string)$nhaptrahang);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VALUE, $conditiondata, $datevalue, (string)$tgnhapkhac);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $conditiondata, $datevalue, (string)$nhapkhac);

                                    unset($vcd);
                                    unset($sumsoluong);
                                    unset($doanhthuchuav);
                                    unset($doanhthucov);
                                    unset($giavon);
                                    unset($nhapmua); //nhap mua
                                    unset($nhapnoibo);
                                    unset($nhaptrahang);
                                    unset($nhapkhac);
                                    unset($tgnhapmua); //nhap mua
                                    unset($tgnhapnoibo);
                                    unset($tgnhaptrahang);
                                    unset($tgnhapkhac);
                                    unset($nhapdauky);
                                    unset($tgnhapdauky);
                                }
                            }
                        }
                    }
                }
                unset($voucherdetail);
                unset($listVoucherDetails2);
                unset($listVoucherDetails1);
                unset($listVoucherDetails);
                unset($listVoucherDetails2keys);
                unset($listVoucherCategoriesId);
            }


            //Nhap tra hang
            if (!empty($listoutputvoucherreturns[$datetime]))
            {
                $listVoucherDetails         = array();
                $listVoucherDetails2keys    = array();
                $listVoucherCategoriesId    = array();
                foreach ($listoutputvoucherreturns[$datetime] as $vcd)
                {
                    //foreach($voucherdetail as $vcd)
                    //{
                        $myProduct = Core_Product::getProductIDByBarcode(trim($vcd['p_barcode']));
                        //check them store is sale = 1)
                        if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0 && !empty($storelistfromcache[$vcd['s_id']]))
                        {
                            $newvcd = $vcd;
                            $newvcd['p_isrequestimei'] = $myProduct['p_isrequestimei'];

                            $listVoucherDetails['product'][$myProduct['p_id']][]    = $newvcd;
                            $listVoucherDetails2keys['inputstore']['product'][$vcd['s_id']][$myProduct['p_id']][]               = $newvcd;

                            $listVoucherDetails['inputstore'][$vcd['s_id']][]       = $newvcd;
                            /*if ($myProduct['pc_id'] > 0)
                            {
                                $listVoucherDetails['category'][$myProduct['pc_id']][]      = $newvcd;
                                $listVoucherDetails2keys['inputstore']['category'][$vcd['s_id']][$myProduct['pc_id']][] = $newvcd;
                            }*/
                            /*if (empty($listcategoryhaveproducts) || empty($listcategoryhaveproducts[$datevalue][$myProduct['pc_id']]) || !in_array($myProduct['p_id'], $listcategoryhaveproducts[$datevalue][$myProduct['pc_id']])){
                                $listcategoryhaveproducts[$datevalue][$myProduct['pc_id']][] = $myProduct['p_id'];
                            }*/
                            unset($newvcd);
                        }
                        unset($myProduct);
                    //}

                }
                //Tinh toan luu xuong cache 1 keyss
                if (!empty($listVoucherDetails))
                {
                    foreach ($listVoucherDetails as $textkey => $voucherObject)
                    {
                        foreach ($voucherObject as $id => $voucherdetail)
                        {
                            //Tinh theo voucher
                            $nhaptrahang = 0;
                            $tgnhaptrahang = 0;
                            $tgnhaptrahangvat = 0;
                            $giavontralai = 0;
                            $conditiondata = array();
                            if ($textkey != 'all') $conditiondata[$textkey] = $id;
                            foreach($voucherdetail as $vcd)
                            {
                                $vattralai               = 0.1;//se sua sau
                                $nhaptrahang            += $vcd['ovr_quantity'];
                                $tg1item                = ($vcd['ovr_quantity'] * $vcd['ovr_inputprice']);
                                $tgnhaptrahang          += $tg1item;
                                $tgnhaptrahangvat       += $tg1item + ($tg1item * $vattralai);

                                $giavontralai           += ($vcd['ovr_quantity'] * $vcd['ovr_ivdetailprice']);
                            }
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditiondata, $datevalue, (string)$tgnhaptrahang);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $conditiondata, $datevalue, (string)$tgnhaptrahangvat);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $conditiondata, $datevalue, (string)$nhaptrahang);
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_COSTPRICE, $conditiondata, $datevalue, (string)$giavontralai);//gia von tra lai
                            unset($nhaptrahang);
                            unset($tgnhaptrahang);
                            unset($tgnhaptrahangvat);
                            unset($giavontralai);
                        }
                    }
                }

                //Tinh toan luu xuong cache 2 keyss
                if (!empty($listVoucherDetails2keys))
                {
                    foreach ($listVoucherDetails2keys as $textkey1 => $listvoucherDetails1)
                    {
                        foreach ($listvoucherDetails1 as $textkey => $listVoucherDetails2)
                        {
                            foreach ($listVoucherDetails2 as $id1 => $listVoucherObjects)
                            {
                                foreach ($listVoucherObjects as $id => $voucherdetail)
                                {
                                    //Tinh theo voucher
                                    $nhaptrahang = 0;
                                    $tgnhaptrahang = 0;
                                    $tgnhaptrahangvat = 0;
                                    $giavontralai = 0;

                                    $conditiondata = array();
                                    $conditiondata[$textkey] = $id;
                                    $conditiondata[$textkey1] = $id1;
                                    foreach($voucherdetail as $vcd)
                                    {
                                        $vattralai               = 0.1;//se sua sau
                                        $nhaptrahang            += $vcd['ovr_quantity'];
                                        $tg1item                = ($vcd['ovr_quantity'] * $vcd['ovr_inputprice']);
                                        $tgnhaptrahang          += $tg1item;
                                        $tgnhaptrahangvat       += $tg1item + ($tg1item * $vattralai);

                                        $giavontralai           += ($vcd['ovr_quantity'] * $vcd['ovr_ivdetailprice']);
                                    }

                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditiondata, $datevalue, (string)$tgnhaptrahang);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $conditiondata, $datevalue, (string)$tgnhaptrahangvat);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $conditiondata, $datevalue, (string)$nhaptrahang);
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_COSTPRICE, $conditiondata, $datevalue, (string)$giavontralai);//gia von tra lai
                                    unset($nhaptrahang);
                                    unset($tgnhaptrahang);
                                    unset($tgnhaptrahangvat);
                                    unset($giavontralai);
                                }
                            }
                        }
                    }
                }
                unset($voucherdetail);
                unset($listVoucherDetails2);
                unset($listVoucherDetails1);
                unset($listVoucherDetails);
                unset($listVoucherDetails2keys);
                unset($listVoucherCategoriesId);
            }

            //Nhap tra hang
            if (!empty($listproductawards[$datetime]))
            {
                $listVoucherDetails         = array();
                foreach ($listproductawards[$datetime] as $vcd)
                {
                    $myProduct = Core_Product::getProductIDByBarcode(trim($vcd['p_barcode']));
                    //check them store is sale = 1)
                    if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0)
                    {
                        $newvcd = $vcd;
                        $newvcd['p_isrequestimei'] = $myProduct['p_isrequestimei'];

                        $listVoucherDetails['product'][$myProduct['p_id']][]    = $newvcd;
                        /*if ($myProduct['pc_id'] > 0)
                        {
                            $listVoucherDetails['category'][$myProduct['pc_id']][]      = $newvcd;
                        }*/

                        /*if (empty($listcategoryhaveproducts) || empty($listcategoryhaveproducts[$myProduct['pc_id']]) || !in_array($myProduct['p_id'], $listcategoryhaveproducts[$myProduct['pc_id']])){
                            $listcategoryhaveproducts[$myProduct['pc_id']][] = $myProduct['p_id'];
                        }*/
                        unset($newvcd);
                    }
                    unset($myProduct);
                }
                //Tinh toan luu xuong cache 1 keyss
                if (!empty($listVoucherDetails))
                {
                    foreach ($listVoucherDetails as $textkey => $voucherObject)
                    {
                        foreach ($voucherObject as $id => $voucherdetail)
                        {
                            //Tinh theo voucher
                            $tongdiemchuan = 0;
                            $conditiondata = array();
                            if ($textkey != 'all') $conditiondata[$textkey] = $id;
                            foreach($voucherdetail as $vcd)
                            {
                                $tongdiemchuan          += $vcd['pr_totalrewardforstaff'];
                            }
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PRODUCTREWARD, $conditiondata, $datevalue, (string)$tongdiemchuan);//tong diem thuong cua 1 san pham
                            unset($tongdiemchuan);
                        }
                    }
                }
                unset($listVoucherDetails);
            }
            $datetime = strtotime('+1 day', $datetime);
        }

        unset($datetime);

        //Tinh toan chiec khau (GT hang KM)
        if (!empty($listproductapplyoutputvoucher))
         {
            foreach ($listproductapplyoutputvoucher as $datetime=> $listproductvoucher)
            {
                $datevalue = date('Y/m/d', $datetime);

                $listVoucherDetails = array();
                $listVoucherDetails2keys = array();

                if (!empty($listproductvoucher))
                {
                    foreach ($listproductvoucher as $probarcode => $listvoucherids)
                    {
                        $tpbarcode = trim($probarcode);
                        $myProduct = Core_Product::getProductIDByBarcode($tpbarcode);
                        if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0)
                        {
                            if (!empty($listvoucherids))
                            {
                                foreach ($listvoucherids as $vcid=>$voucherdetail)
                                {
                                    foreach ($voucherdetail as $vcd)
                                    {
                                        //check them store is sale = 1)   && !empty($storelistfromcache[$vcd['s_id']]))//check them store is sale = 1)
                                        if(!empty($storelistfromcache[$vcd['s_id']]))
                                        {
                                            $newvcd = $vcd;
                                            $listVoucherDetails['product'][$myProduct['p_id']][]    = $newvcd;
                                            $listVoucherDetails2keys['outputstore']['product'][$vcd['s_id']][$myProduct['p_id']][]      = $newvcd;
                                            $listVoucherDetails['outputstore'][$vcd['s_id']][]      = $newvcd;
                                            /*if ($myProduct['pc_id'] > 0)
                                            {
                                                $listVoucherDetails['category'][$myProduct['pc_id']][]      = $newvcd;
                                                $listVoucherDetails2keys['outputstore']['category'][$vcd['s_id']][$myProduct['pc_id']][] = $newvcd;
                                            }*/

                                        }

                                    }
                                }
                            }

                            /*if (empty($listcategoryhaveproducts) || empty($listcategoryhaveproducts[$myProduct['pc_id']]) || !in_array($myProduct['p_id'], $listcategoryhaveproducts[$myProduct['pc_id']])){
                                $listcategoryhaveproducts[$myProduct['pc_id']][] = $myProduct['p_id'];
                            }*/
                        }
                        unset($myProduct);
                    }
                }

                //TG KM cho 1 key
                if (!empty($listVoucherDetails))
                {
                    foreach ($listVoucherDetails as $textkey => $voucherObject)
                    {
                        if (empty($voucherObject)) continue;
                        foreach ($voucherObject as $id => $voucherdetail)
                        {
                            if (empty($voucherdetail)) continue;
                            $doanhthukm = 0;
                            $conditiondata = array();
                            if ($textkey != 'all') $conditiondata[$textkey] = $id;
                            foreach($voucherdetail as $vcd)
                            {
                                if (!empty($listoutputtypeissale[$vcd['po_id']]))
                                {
                                    $doanhthukm += ($vcd['ov_quantity'] * $vcd['ov_costprice']);
                                }
                            }
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROMOTION_COSTPRICE, $conditiondata, $datevalue, (string)$doanhthukm);//gia von hang KM
                        }
                    }
                }

                //TG KM 2 key
                //Tinh toan luu xuong cache theo 2 keys
                if (!empty($listVoucherDetails2keys))
                {
                    foreach ($listVoucherDetails2keys as $keytext1 => $listVoucherDetails1)
                    {
                        if (empty($listVoucherDetails1)) continue;
                        foreach ($listVoucherDetails1 as $textkey => $listVoucherDetails2)
                        {
                            if (empty($listVoucherDetails2)) continue;
                            foreach ($listVoucherDetails2 as $id1 => $listVoucherObjects)
                            {
                                if (empty($listVoucherObjects)) continue;
                                foreach ($listVoucherObjects as $id => $voucherdetail)
                                {
                                    $doanhthukm = 0;
                                    $conditiondata = array();
                                    $conditiondata[$textkey] = $id;
                                    $conditiondata[$keytext1] = $id1;
                                    foreach($voucherdetail as $vcd)
                                    {
                                        if (!empty($listoutputtypeissale[$vcd['po_id']]))
                                        {
                                            $doanhthukm += ($vcd['ov_quantity'] * $vcd['ov_costprice']);
                                        }
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROMOTION_COSTPRICE, $conditiondata, $datevalue, (string)$doanhthukm);//gia von hang KM

                                }
                            }
                        }
                    }
                }
            }

            unset($voucherdetail);
            unset($listVoucherDetails2);
            unset($listVoucherDetails1);
            unset($listVoucherDetails);
            unset($listVoucherDetails2keys);
            unset($listVoucherCategoriesId);
        }
        //End tinh toan chiec khau


        /*Import so luong xem*/
        $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'store_statistic WHERE
                                                        ss_statisticdate >='.$startdate.' AND
                                                        ss_statisticdate <='.$enddate
                                            )->fetchColumn(0);
        if ($counter > 0)
        {
            for ($i = 0; $i < $counter; $i+=500)
            {
                $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'store_statistic WHERE
                                                                ss_statisticdate >='.$startdate.' AND
                                                                ss_statisticdate <='.$enddate.'
                                                                LIMIT '.$i.', 500');
                if (!empty($getoutputvoucher))
                {
                    $listviewstores = array();
                    while($row = $getoutputvoucher->fetch())
                    {
                         if (!empty($storelistfromcache[$row['s_id']]))
                         {
                             $listviewstores[$row['ss_statisticdate']][$row['s_id']][] = $row;
                         }
                    }
                    unset($row);
                    unset($getoutputvoucher);
                }
            }
            //
            if (!empty($listviewstores))
            {
                foreach ($listviewstores as $dtview => $storeviews)
                {
                    $datevalue = date('Y/m/d', $dtview);
                    $numviewsofdate = 0;
                    foreach ($storeviews as $sid => $views)
                    {
                        $numofviews = 0;
                        foreach ($views as $item)
                        {
                            $numofviews += $item['ss_statisticvalue'];
                        }
                        Core_Stat::setDataSaleInDate(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $datevalue, (string)$numofviews);
                        $numviewsofdate += $numofviews;
                    }
                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_CUSTOMER_VIEWS, array(), $datevalue, (string)$numviewsofdate);
                }
                unset($listviewstores);
            }
            unset($counter);
        }

        /*
        if (!empty($listcategoryhaveproducts))
        {
            $newproducthavebarcode = array();
            $montharray = array();
            foreach ($listcategoryhaveproducts as $datevalue => $listcatesexist)
            {
                $newdatevalue = strtotime($datevalue);
                foreach ($listcatesexist as $catidexist => $listproductsexist)
                {
                    //$newproducthavebarcode[$catidexist][date('Y', $newdatevalue)][date('n', $newdatevalue)][date('j', $newdatevalue)] = $listproductsexist;
                    $newproducthavebarcode[date('Ym', $newdatevalue)][$catidexist][date('j', $newdatevalue) - 1] = $listproductsexist;
                    $montharray[date('Y', $newdatevalue)][date('n', $newdatevalue)] = date('j', $newdatevalue);
                }
            }

            foreach ($montharray as $cyear => $listmonths)
            {
                foreach ($listmonths as $cmonth => $listdays)
                {
                    $myCacher = new Cacher('catlistreport:'. $cyear.sprintf('%02d', $cmonth), Cacher::STORAGE_REDIS);
                    //get old cache
                    $oldcache = json_decode($myCacher->get(), true);

                    //$nstartdate = date($cyear.'-'.$cmonth.'-01');
                    //$nenddate = strtotime('+1 month', $nstartdate);//strtotime('-1 day', strtotime('+1 month', $nstartdate));
                    $catlistbycurrentyearmonth = $newproducthavebarcode[$cyear.sprintf('%02d', $cmonth)];
                    $newcatlistbycurrentyearmonth = array();
                    foreach ($catlistbycurrentyearmonth as $catidexist => $listdaybyproducts)
                    {
                        $newcatlistbycurrentyearmonth[$catidexist] = $listdaybyproducts;
                        for ($curday = 0; $curday < 31; $curday++)
                        {
                            if (empty($listdaybyproducts[$curday]))
                            {
                                if (!empty($oldcache[$catidexist][$curday]))
                                {
                                    $newcatlistbycurrentyearmonth[$catidexist][$curday] = $oldcache[$catidexist][$curday];
                                }
                                else $newcatlistbycurrentyearmonth[$catidexist][$curday] = array();
                            }
                        }
                    }
                    if (!empty($newcatlistbycurrentyearmonth)) $myCacher->set((string)json_encode($newcatlistbycurrentyearmonth), 0);
                    unset($newcatlistbycurrentyearmonth);
                }
            }
        }*/

        $cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS, $conf['redis'][1]);
        $cacheredis->set(time(), 0);
        unset($cacheredis);

        echo '<p> Time: '.(time() - $starttime).'</p>';//. ' order:  '.$counterorder.' orderdetail:  '.$counterorderdetail;
    }

    public function cacheproducthavequantitybydayAction()
    {
        global $conf;
        set_time_limit(0);
        ini_set('display_errors', 1);
        $timer = new timer();
        $timer->start();

        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        $begindate = strtotime(date('Y-m-01', $startdate));

        $listcategoryfromcache = Core_Productcategory::getProductlistFromCategory();
        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $catlistbycurrentyearmonth = array();
        foreach ($listcategoryfromcache as $pcid => $listpids)
        {
            //$detailvalues = array('soluongthucban');
            //$dataidlist = array('product' =>$listpids);
            //$mastervalues = array();

            $newarrtypes = array_merge($this->arrtypes, $this->arrtypesrefund);
            $getdatalistalltypes = Core_Stat::getDataList($newarrtypes, array('products' =>$listpids), $startdate, $enddate );

            if (!empty($getdatalistalltypes))
            {
                foreach ($getdatalistalltypes as $pid => $listofdatatypes)
                {
                    foreach ($listofdatatypes as $type => $listdatadate)
                    {
                        foreach ($listdatadate as $keyofdate => $value)
                        {
                            $dt = strtotime($keyofdate);
                            $curindex = date('j', $dt) - 1;
                            //$catlistbycurrentyearmonth[date('Ym', $dt)][0][$pcid][$curindex][] = $pid;
                            if (empty($catlistbycurrentyearmonth[date('Ym', $dt)][0][$pcid][$curindex]) || !in_array($pid, $catlistbycurrentyearmonth[date('Ym', $dt)][0][$pcid][$curindex]))
                            {
                                $catlistbycurrentyearmonth[date('Ym', $dt)][0][$pcid][$curindex][] = $pid;
                            }
                        }
                    }
                }
            }
            unset($getdatalistalltypes);

            foreach ($storelistfromcache as $sid => $sname)
            {
                $getdatalistalltypes = Core_Stat::getDataList($this->arrtypes, array('products' =>$listpids, 'outputstore' => $sid), $startdate, $enddate );

                if (!empty($getdatalistalltypes))
                {
                    foreach ($getdatalistalltypes as $pid => $listofdatatypes)
                    {
                        foreach ($listofdatatypes as $type => $listdatadate)
                        {
                            foreach ($listdatadate as $keyofdate => $value)
                            {
                                $dt = strtotime($keyofdate);
                                $curindex = date('j', $dt) - 1;
                                if (empty($catlistbycurrentyearmonth[date('Ym', $dt)][$sid][$pcid][$curindex]) || !in_array($pid, $catlistbycurrentyearmonth[date('Ym', $dt)][$sid][$pcid][$curindex]))
                                {
                                    $catlistbycurrentyearmonth[date('Ym', $dt)][$sid][$pcid][$curindex][] = $pid;
                                }
                            }
                        }
                    }
                }
                unset($getdatalistalltypes);

                $getdatalistalltypes = Core_Stat::getDataList($this->arrtypesrefund, array('products' =>$listpids, 'inputstore' => $sid), $startdate, $enddate );
                if (!empty($getdatalistalltypes))
                {
                    foreach ($getdatalistalltypes as $pid => $listofdatatypes)
                    {
                        foreach ($listofdatatypes as $type => $listdatadate)
                        {
                            foreach ($listdatadate as $keyofdate => $value)
                            {
                                $dt = strtotime($keyofdate);
                                $curindex = date('j', $dt) - 1;
                                if (empty($catlistbycurrentyearmonth[date('Ym', $dt)][$sid][$pcid][$curindex]) || !in_array($pid, $catlistbycurrentyearmonth[date('Ym', $dt)][$sid][$pcid][$curindex]))
                                {
                                    $catlistbycurrentyearmonth[date('Ym', $dt)][$sid][$pcid][$curindex][] = $pid;
                                }
                            }
                        }
                    }
                }

                unset($getdatalistalltypes);
            }
        }

        if (!empty($catlistbycurrentyearmonth))
        {
            foreach ($catlistbycurrentyearmonth as $firstkey => $listsids)
            {
                foreach ($listsids as $sid => $listvaluebypcids)
                {
                    if (!empty($listvaluebypcids))
                    {
                        $keycachedata = 'catlistreport:'. $firstkey;
                        if ($sid > 0 ) $keycachedata .= ':'.$sid;
                        $myCacher = new Cacher($keycachedata, Cacher::STORAGE_REDIS, $conf['redis'][1]);
                        $myCacher->set((string)json_encode($listvaluebypcids), 0);
                        unset($myCacher);
                    }
                }
            }
        }

        $timer->stop();
        echo 'Time: '.$timer->get_exec_time();
    }

    public function cachetongtrafficAction()
    {
        set_time_limit(0);
        $starttime = time();
        $db3 = Core_Backend_Object::getDb();//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));
        $storelistfromcache = Core_Store::getStoresFromCache(false);

        $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'store_statistic WHERE
                                    ss_statisticdate >='.$startdate.' AND
                                    ss_statisticdate <='.$enddate
                                )->fetchColumn(0);
        if ($counter > 0)
        {
            for ($i = 0; $i < $counter; $i+=500)
            {
                $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'store_statistic WHERE
                                                                ss_statisticdate >='.$startdate.' AND
                                                                ss_statisticdate <='.$enddate.'
                                                                LIMIT '.$i.', 500');
                if (!empty($getoutputvoucher))
                {
                    $listviewstores = array();
                    while($row = $getoutputvoucher->fetch())
                    {
                         if (!empty($storelistfromcache[$row['s_id']]))
                         {
                             $listviewstores[$row['ss_statisticdate']][$row['s_id']][] = $row;
                         }
                    }
                    unset($row);
                    unset($getoutputvoucher);
                }
            }

            //
            if (!empty($listviewstores))
            {
                foreach ($listviewstores as $dtview => $storeviews)
                {
                    $datevalue = date('Y/m/d', $dtview);
                    $numviewsofdate = 0;
                    foreach ($storeviews as $sid => $views)
                    {
                        $numofviews = 0;
                        foreach ($views as $item)
                        {
                            $numofviews += $item['ss_statisticvalue'];
                        }
                        Core_Stat::setDataSaleInDate(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $datevalue, (string)$numofviews);
                        $numviewsofdate += $numofviews;
                    }
                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_CUSTOMER_VIEWS, array(), $datevalue, (string)$numviewsofdate);
                }
                unset($listviewstores);
            }
            unset($counter);
        }

        echo '<p> Time: '.(time() - $starttime).'--'.$numofviews.'</p>';
    }


    private function getoutputprice($row, $listavgcostproduct = '')
    {
        if ($row['p_isrequestimei'] == 1 && !empty($row['ov_costprice']))
        {
            return $row['ov_costprice'];
        }
        elseif(!empty($listavgcostproduct))
        {
            return $listavgcostproduct['a_price'];
        }
        return 0;
    }

    private function getinputprice($row, $listavgcostproduct = '')
    {
        if ($row['p_isrequestimei'] == 1 && !empty($row['iv_inputprice']))
        {
            return $row['iv_inputprice'];
        }
        elseif(!empty($listavgcostproduct))
        {
            return $listavgcostproduct['a_price'];
        }
        return 0;
    }

    //Xoa het key
    function deleteallKeyAction()
    {
        $key = $_GET['keys'];
        $redis = new Redis();
        $redis->connect('172.16.141.61', 6379);

        $arr = $redis->keys($key.'*');
        if (!empty($arr)) $re  = $redis->delete($arr);
    }

    public function syncaveragecostpriceAction()
    {
        set_time_limit(0);
        $recordPerPage = 1000;
        $counter = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();
        //import du lieu thang moi nhat

        $lastrowold = $db3->query('SELECT max(a_orarowscn) FROM '.TABLE_PREFIX.'averagecostprice LIMIT 1')->fetchColumn(0);

        $lastrow = '';
        $lastrow = $db3->query('SELECT max(a_month) FROM '.TABLE_PREFIX.'averagecostprice WHERE a_year = '.date('Y').' LIMIT 1')->fetchColumn(0);
        if ($lastrow > 0)
        {
            $strparsingime = strtoupper(date('d-M-y', strtotime(date('Y').'-'.($lastrow).'-01')));
            $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_AVERAGECOSTPRICE_DM WHERE MONTH >= TO_DATE(\''. $strparsingime .'\')';
             $countAll = $oracle->query($sql);

             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }
             $totalpage = ceil($total/$recordPerPage);

            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_AVERAGECOSTPRICE_DM ov WHERE MONTH >= TO_DATE(\''. $strparsingime .'\')) WHERE r > ' . $start .' AND r <=' . $end;
                $results = $oracle->query($sql);

                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['MONTH']);
                            $datepart = explode('/', $dateUpdated->format('d/m/Y'));
                    $checker = Core_Backend_Averagecostprice::getAveragecostprices(array('fpbarcode' => $result['PRODUCTID'],
                                                                                        'fmonth' => $datepart[1],
                                                                                        'fyear' => $datepart[2],
                                                                                        'forarowscn' => $result['ORA_ROWSCN']
                                                                                        ), 'id' , 'ASC', '', true);
                            if ($checker == 0)
                            {
                                $myAveragecostprice = new Core_Backend_Averagecostprice();
                                $myAveragecostprice->pbarcode = $result['PRODUCTID'];
                                $myAveragecostprice->month = $datepart[1];
                                $myAveragecostprice->year = $datepart[2];
                                $myAveragecostprice->price = (float)$result['COSTPRICE'];
                                $myAveragecostprice->orarowscn = $result['ORA_ROWSCN'];

                                $myAveragecostprice->addData();
                                $counter++;
                            }
                }

                unset($results);
                unset($start);
                unset($end);
            }
        }

        $lastrow = $lastrowold;
        if ($lastrow > 0)
        {
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_AVERAGECOSTPRICE_DM WHERE MONTH >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND ORA_ROWSCN > '.$lastrow);
            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_AVERAGECOSTPRICE_DM a WHERE a.MONTH >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND a.ORA_ROWSCN > '.$lastrow.') WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['MONTH']);
                            $datepart = explode('/', $dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Averagecostprice::getAveragecostprices(array('fpbarcode' => $result['PRODUCTID'],
                                                                                        'fmonth' => $datepart[1],
                                                                                        'fyear' => $datepart[2],
                                                                                        //'forarowscn' => $result['ORA_ROWSCN']
                                                                                        ), 'id' , 'ASC', '0,1');

                            if (count($checker) == 0)
                            {
                                $myAveragecostprice = new Core_Backend_Averagecostprice();
                                $myAveragecostprice->pbarcode = $result['PRODUCTID'];
                                $myAveragecostprice->month = $datepart[1];
                                $myAveragecostprice->year = $datepart[2];
                                $myAveragecostprice->price = (float)$result['COSTPRICE'];
                                $myAveragecostprice->orarowscn = $result['ORA_ROWSCN'];

                                $myAveragecostprice->addData();
                            }
                            elseif($checker[0]->id >0 )
                            {
                                $myAveragecostprice = new Core_Backend_Averagecostprice($checker[0]->id);
                                if ($myAveragecostprice->id > 0)
                                {
                                    $myAveragecostprice->pbarcode = $result['PRODUCTID'];
                                    $myAveragecostprice->month = $datepart[1];
                                    $myAveragecostprice->year = $datepart[2];
                                    $myAveragecostprice->price = (float)$result['COSTPRICE'];
                                    $myAveragecostprice->orarowscn = $result['ORA_ROWSCN'];
                                    $myAveragecostprice->updateData();
                                }
                                else
                                {
                                    $myAveragecostprice = new Core_Backend_Averagecostprice();
                                    $myAveragecostprice->pbarcode = $result['PRODUCTID'];
                                    $myAveragecostprice->month = $datepart[1];
                                    $myAveragecostprice->year = $datepart[2];
                                    $myAveragecostprice->price = (float)$result['COSTPRICE'];
                                    $myAveragecostprice->orarowscn = $result['ORA_ROWSCN'];

                                    $myAveragecostprice->addData();
                                }
                            }
                            $counter++;
                        }
                        unset($result);
                        unset($myAveragecostprice);
                        unset($start);
                        unset($end);
                    }
                }
            }
        }

        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter;
    }

    public function syncbeginminstockAction()
    {
        set_time_limit(0);
        $recordPerPage = 500;
        $counter = 0;
        $counterexists = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();

        $lastrowold = $db3->query('SELECT max(b_orarowscn) FROM '.TABLE_PREFIX.'beginminstock LIMIT 1')->fetchColumn(0);

        //import du lieu thang moi nhat
        $lastrow = '';
        $lastrow = $db3->query('SELECT max(b_month) FROM '.TABLE_PREFIX.'beginminstock WHERE b_year = '.date('Y').' LIMIT 1')->fetchColumn(0);
        //check if today great than 2nd of month, increase month
        if (date('j') > 2 && date('n') > $lastrow) $lastrow = date('n');
        if ($lastrow > 0)
        {
            $strparsingime = strtoupper(date('d-M-y', strtotime(date('Y').'-'.($lastrow).'-01')));
            $sql = 'select count(*) as TOTAL from (
                      select sum(QUANTITY) as QUANTITY, avg(COSTPRICE) as COSTPRICE, PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH
                      from ERP.VW_BEGINTERMINSTOCK_DM WHERE INSTOCKMONTH >= TO_DATE(\''.$strparsingime.'\')
                      group by PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH
                    ) sumviews';
             $countAll = $oracle->query($sql);

             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }

             $totalpage = ceil($total/$recordPerPage);
            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT sub.* FROM (
                        select sum(QUANTITY) as QUANTITY, avg(COSTPRICE) as COSTPRICE, PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH , ROWNUM r
                        from ERP.VW_BEGINTERMINSTOCK_DM WHERE INSTOCKMONTH >= TO_DATE(\''.$strparsingime.'\')
                        group by PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH, ROWNUM
                      )sub WHERE r > ' . $start .' AND r <=' . $end;
                $results = $oracle->query($sql);
                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INSTOCKMONTH']);
                    $datepart = explode('/', $dateUpdated->format('d/m/Y'));
                     $checker = Core_Backend_Beginminstock::getBeginminstocks(array('fpbarcode' => $result['PRODUCTID'],
                                                                                        'fsid' => $result['STOREID'],
                                                                                        'fmonth' => $datepart[1],
                                                                                        'fyear' => $datepart[2],
                                                                                        'fimei' => $result['IMEI'],
                                                                                        'fisnew' => $result['ISNEW'],
                                                                                        //'fisshowproduct' => $result['b_isshowproduct'],
                                                                                        //'forarowscn' => $result['b_orarowscn']
                                                                            ), 'id', 'ASC' , '0,1');

                    $myBeginminstock = new Core_Backend_Beginminstock();
                    $myBeginminstock->pbarcode = $result['PRODUCTID'];
                    $myBeginminstock->sid = $result['STOREID'];
                    $myBeginminstock->imei = $result['IMEI'];
                    $myBeginminstock->month = $datepart[1];
                    $myBeginminstock->year = $datepart[2];
                    $myBeginminstock->quantity = $result['QUANTITY'];
                    $myBeginminstock->costprice = $result['COSTPRICE'];
                    $myBeginminstock->isnew = $result['ISNEW'];
                    $myBeginminstock->isshowproduct = $result['ISSHOWPRODUCT'];
                    $myBeginminstock->orarowscn = $result['ORA_ROWSCN'];
                     if(count($checker) == 0)
                     {
                        $myBeginminstock->addData();
                        $counter++;
                    }
                    elseif ($checker[0]->id > 0)
                    {
                        $myBeginminstock->id = $checker[0]->id;
                        $myBeginminstock->updateData();
                        $counterexists++;
                    }
                    unset($myBeginminstock);
                    unset($result);
                    unset($checker);
                }

                unset($results);
                unset($start);
                unset($end);
            }
        }

        if ($lastrowold > 0)
        {
            $sql = 'select count(*) as TOTAL from (
                      select sum(QUANTITY) as QUANTITY, avg(COSTPRICE) as COSTPRICE, PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH
                      from ERP.VW_BEGINTERMINSTOCK_DM WHERE ORA_ROWSCN > '.$lastrowold.' AND INSTOCKMONTH >= TO_DATE(\''.date('d-M-y', strtotime('-2 month')).'\')
                      group by PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH
                    ) sumviews';
             $countAll = $oracle->query($sql);
             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }
             $totalpage = ceil($total/$recordPerPage);

            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT sub.* FROM (
                        select sum(QUANTITY) as QUANTITY, avg(COSTPRICE) as COSTPRICE, PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH, ROWNUM r
                        from ERP.VW_BEGINTERMINSTOCK_DM WHERE ORA_ROWSCN > '.$lastrowold.' AND INSTOCKMONTH >= TO_DATE(\''.date('d-M-y', strtotime('-2 month')).'\')
                        group by PRODUCTID, STOREID, IMEI, ISNEW, ISSHOWPRODUCT, ORA_ROWSCN, INSTOCKMONTH, ROWNUM
                      )sub WHERE r > ' . $start .' AND r <=' . $end;
                $results = $oracle->query($sql);
                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INSTOCKMONTH']);
                    $datepart = explode('/', $dateUpdated->format('d/m/Y'));

                     $checker = Core_Backend_Beginminstock::getBeginminstocks(array('fpbarcode' => $result['PRODUCTID'],
                                                                                        'fsid' => $result['STOREID'],
                                                                                        'fmonth' => $datepart[1],
                                                                                        'fyear' => $datepart[2],
                                                                                        'fimei' => $result['IMEI'],
                                                                                        'fisnew' => $result['ISNEW'],
                                                                                        //'fisshowproduct' => $result['b_isshowproduct'],
                                                                                        //'forarowscn' => $result['b_orarowscn']
                                                                            ), 'id', 'ASC' , '0,1');

                    $myBeginminstock = new Core_Backend_Beginminstock();
                    $myBeginminstock->pbarcode = $result['PRODUCTID'];
                    $myBeginminstock->sid = $result['STOREID'];
                    $myBeginminstock->imei = $result['IMEI'];
                    $myBeginminstock->month = $datepart[1];
                    $myBeginminstock->year = $datepart[2];
                    $myBeginminstock->quantity = $result['QUANTITY'];
                    $myBeginminstock->costprice = $result['COSTPRICE'];
                    $myBeginminstock->isnew = $result['ISNEW'];
                    $myBeginminstock->isshowproduct = $result['ISSHOWPRODUCT'];
                    $myBeginminstock->orarowscn = $result['ORA_ROWSCN'];
                     if(count($checker) == 0)
                     {
                        $myBeginminstock->addData();
                        $counter++;
                    }
                    elseif ($checker[0]->id > 0)
                    {
                        $myBeginminstock->id = $checker[0]->id;
                        $myBeginminstock->updateData();
                        $counterexists++;
                    }
                    unset($myBeginminstock);
                    unset($result);
                    unset($checker);
                }

                unset($results);
                unset($start);
                unset($end);
            }
        }
        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter.'--'.$counterexists;
    }

    //Outputvoucher
    public function syncoutputvoucherAction()
    {
        set_time_limit(0);
        $recordPerPage = 1000;
        $counter = 0;
        $counterupdate = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();

        $lastrowold = $db3->query('SELECT max(ov_ovdorarowscn) FROM '.TABLE_PREFIX.'outputvoucher LIMIT 1')->fetchColumn(0);
        $lastrowold2 = $db3->query('SELECT max(ov_ovorarowscn) FROM '.TABLE_PREFIX.'outputvoucher LIMIT 1')->fetchColumn(0);


        //import du lieu thang moi nhat

        $lastrow = '';
        $lastrow = $db3->query('SELECT max(ov_outputdate) FROM '.TABLE_PREFIX.'outputvoucher LIMIT 1')->fetchColumn(0);
        if ($lastrow > 0)
        {
            $strparsingime = strtoupper(date('d-M-y' , $lastrow));
            $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE >= TO_DATE(\''. $strparsingime .'\')';
             $countAll = $oracle->query($sql);

             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }
             $totalpage = ceil($total/$recordPerPage);

            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ov WHERE OUTPUTDATE >= TO_DATE(\''. $strparsingime .'\')) WHERE r > ' . $start .' AND r <=' . $end;
                $results = $oracle->query($sql);

                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['OUTPUTDATE']);
                    $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                    $checker = Core_Backend_Outputvoucher::getOutputvouchers(array(
                                                                    //'fpoid' => $result['OUTPUTTYPEID'],
                                                                    //'fpbarcode' => $result['PRODUCTID'],
                                                                    //'fpromoid' => $result['PROMOTIONID'],
                                                                    //'fcoid' => $result['PRODUCTCOMBOID'],
                                                                    //'fsid' => $result['STOREID'],
                                                                    'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                                                                    'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                                                                    //'forderid' => $result['ORDERID'],
                                                                    //'finvoiceid' => $result['INVOICEID'],
                                                                    //'fovorarowscn' => $result['OVORA_ROWSCN'],
                                                                    //'fovdorarowscn' => $result['OVDORA_ROWSCN'],
                                                                    ) , 'id' , 'ASC' , '' , true);
                    if($checker == 0)
                    {
                        $myOutputvoucher                        = new Core_Backend_Outputvoucher();

                        $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                        $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                        $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                        $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                        $myOutputvoucher->sid                   = $result['STOREID'];
                        $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                        $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                        $myOutputvoucher->orderid               = $result['ORDERID'];
                        $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                        $myOutputvoucher->username              = $result['USERNAME'];
                        $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                        $myOutputvoucher->outputdate            = $date;
                        $myOutputvoucher->quantity              = $result['QUANTITY'];
                        $myOutputvoucher->costprice             = $result['COSTPRICE'];
                        $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                        $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                        $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                        $myOutputvoucher->vat                   = $result['VAT'];
                        $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                        $myOutputvoucher->isnew                 = $result['ISNEW'];
                        $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                        $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                        $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                        $myOutputvoucher->iserror               = $result['ISERROR'];
                        $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                        $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];

                        if($myOutputvoucher->addData() > 0)
                        {
                            $counter++;
                            unset($myOutputvoucher);
                            unset($result);
                            unset($checker);
                        }
                    }
                }

                unset($results);
                unset($start);
                unset($end);
            }
        }

        $lastrow = $lastrowold;
        if ($lastrow > 0)
        {
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y' , strtotime('-2 month'))) .'\') AND OVDORA_ROWSCN > '.$lastrow);

            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM a WHERE a.OUTPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y' , strtotime('-2 month'))) .'\') AND a.OVDORA_ROWSCN > '.$lastrow.') WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['OUTPUTDATE']);
                            $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Outputvoucher::getOutputvouchers(array(
                                                                    //'fpoid' => $result['OUTPUTTYPEID'],
                                                                    //'fpbarcode' => $result['PRODUCTID'],
                                                                    //'fpromoid' => $result['PROMOTIONID'],
                                                                    //'fcoid' => $result['PRODUCTCOMBOID'],
                                                                    //'fsid' => $result['STOREID'],
                                                                    'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                                                                    'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                                                                    //'forderid' => $result['ORDERID'],
                                                                    //'finvoiceid' => $result['INVOICEID'],
                                                                    //'fovorarowscn' => $result['OVORA_ROWSCN'],
                                                                    //'fovdorarowscn' => $result['OVDORA_ROWSCN'],
                                                                    //'fovdorarowscn' => $result['OVDORA_ROWSCN'],
                                                                    ) , 'id' , 'ASC' , '0,1');
                            if (count($checker) == 0)
                            {
                                $myOutputvoucher                        = new Core_Backend_Outputvoucher();

                                $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                                $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                                $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                                $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                                $myOutputvoucher->sid                   = $result['STOREID'];
                                $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                                $myOutputvoucher->orderid               = $result['ORDERID'];
                                $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                                $myOutputvoucher->username              = $result['USERNAME'];
                                $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                                $myOutputvoucher->outputdate            = $date;
                                $myOutputvoucher->quantity              = $result['QUANTITY'];
                                $myOutputvoucher->costprice             = $result['COSTPRICE'];
                                $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                                $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                                $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                                $myOutputvoucher->vat                   = $result['VAT'];
                                $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                                $myOutputvoucher->isnew                 = $result['ISNEW'];
                                $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                                $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                                $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                                $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                                $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];
                                $myOutputvoucher->addData();
                                $counter++;
                            }
                            elseif($checker[0]->id >0 )
                            {
                                $myOutputvoucher = new Core_Backend_Outputvoucher($checker[0]->id);
                                if ($myOutputvoucher->id > 0)
                                {
                                    $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                                    $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                                    $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                                    $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                                    $myOutputvoucher->sid                   = $result['STOREID'];
                                    $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                    $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                                    $myOutputvoucher->orderid               = $result['ORDERID'];
                                    $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                                    $myOutputvoucher->username              = $result['USERNAME'];
                                    $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                                    $myOutputvoucher->outputdate            = $date;
                                    $myOutputvoucher->quantity              = $result['QUANTITY'];
                                    $myOutputvoucher->costprice             = $result['COSTPRICE'];
                                    $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                                    $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                                    $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                                    $myOutputvoucher->vat                   = $result['VAT'];
                                    $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                                    $myOutputvoucher->isnew                 = $result['ISNEW'];
                                    $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                                    $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                                    $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                                    $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                                    $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];
                                    $myOutputvoucher->updateData();
                                    $counterupdate++;
                                }
                                else
                                {
                                    $myOutputvoucher                        = new Core_Backend_Outputvoucher();
                                    $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                                    $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                                    $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                                    $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                                    $myOutputvoucher->sid                   = $result['STOREID'];
                                    $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                    $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                                    $myOutputvoucher->orderid               = $result['ORDERID'];
                                    $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                                    $myOutputvoucher->username              = $result['USERNAME'];
                                    $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                                    $myOutputvoucher->outputdate            = $date;
                                    $myOutputvoucher->quantity              = $result['QUANTITY'];
                                    $myOutputvoucher->costprice             = $result['COSTPRICE'];
                                    $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                                    $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                                    $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                                    $myOutputvoucher->vat                   = $result['VAT'];
                                    $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                                    $myOutputvoucher->isnew                 = $result['ISNEW'];
                                    $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                                    $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                                    $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                                    $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                                    $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];
                                    $myOutputvoucher->addData();
                                    $counter++;
                                }
                            }
                        }
                        unset($result);
                        unset($myOutputvoucher);
                        unset($start);
                        unset($end);
                    }
                }
            }
        }
        unset($lastrow);
        unset($countAll);
        //Thuc hien update lai originatestoreid
        //$this->syncoriginatestoreAction();

        $lastrow = $lastrowold2;
        if ($lastrow > 0)
        {
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y' , strtotime('-2 month'))) .'\') AND OVORA_ROWSCN > '.$lastrow);

            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM a WHERE a.OUTPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y' , strtotime('-2 month'))) .'\') AND a.OVORA_ROWSCN > '.$lastrow.') WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['OUTPUTDATE']);
                            $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Outputvoucher::getOutputvouchers(array(
                                                                    //'fpoid' => $result['OUTPUTTYPEID'],
                                                                    //'fpbarcode' => $result['PRODUCTID'],
                                                                    //'fpromoid' => $result['PROMOTIONID'],
                                                                    //'fcoid' => $result['PRODUCTCOMBOID'],
                                                                    //'fsid' => $result['STOREID'],
                                                                    'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                                                                    'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                                                                    //'forderid' => $result['ORDERID'],
                                                                    //'finvoiceid' => $result['INVOICEID'],
                                                                    //'fovorarowscn' => $result['OVORA_ROWSCN'],
                                                                    //'fovdorarowscn' => $result['OVDORA_ROWSCN'],
                                                                    ) , 'id' , 'ASC' , '0,1');
                            if (count($checker) == 0)
                            {
                                $myOutputvoucher                        = new Core_Backend_Outputvoucher();

                                $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                                $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                                $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                                $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                                $myOutputvoucher->sid                   = $result['STOREID'];
                                $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                                $myOutputvoucher->orderid               = $result['ORDERID'];
                                $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                                $myOutputvoucher->username              = $result['USERNAME'];
                                $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                                $myOutputvoucher->outputdate            = $date;
                                $myOutputvoucher->quantity              = $result['QUANTITY'];
                                $myOutputvoucher->costprice             = $result['COSTPRICE'];
                                $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                                $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                                $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                                $myOutputvoucher->vat                   = $result['VAT'];
                                $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                                $myOutputvoucher->isnew                 = $result['ISNEW'];
                                $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                                $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                                $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                                $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                                $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];
                                $myOutputvoucher->addData();
                                $counter++;
                            }
                            elseif($checker[0]->id >0 )
                            {
                                $myOutputvoucher = new Core_Backend_Outputvoucher($checker[0]->id);
                                if ($myOutputvoucher->id > 0)
                                {
                                    $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                                    $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                                    $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                                    $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                                    $myOutputvoucher->sid                   = $result['STOREID'];
                                    $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                    $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                                    $myOutputvoucher->orderid               = $result['ORDERID'];
                                    $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                                    $myOutputvoucher->username              = $result['USERNAME'];
                                    $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                                    $myOutputvoucher->outputdate            = $date;
                                    $myOutputvoucher->quantity              = $result['QUANTITY'];
                                    $myOutputvoucher->costprice             = $result['COSTPRICE'];
                                    $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                                    $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                                    $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                                    $myOutputvoucher->vat                   = $result['VAT'];
                                    $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                                    $myOutputvoucher->isnew                 = $result['ISNEW'];
                                    $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                                    $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                                    $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                                    $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                                    $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];
                                    $myOutputvoucher->updateData();
                                    $counterupdate++;
                                }
                                else
                                {
                                    $myOutputvoucher                        = new Core_Backend_Outputvoucher();
                                    $myOutputvoucher->poid                  = $result['OUTPUTTYPEID'];
                                    $myOutputvoucher->pbarcode              = $result['PRODUCTID'];
                                    $myOutputvoucher->promoid               = $result['PROMOTIONID'];
                                    $myOutputvoucher->coid                  = $result['PRODUCTCOMBOID'];
                                    $myOutputvoucher->sid                   = $result['STOREID'];
                                    $myOutputvoucher->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                    $myOutputvoucher->outputvoucherid       = $result['OUTPUTVOUCHERID'];
                                    $myOutputvoucher->orderid               = $result['ORDERID'];
                                    $myOutputvoucher->invoiceid             = $result['INVOICEID'];
                                    $myOutputvoucher->username              = $result['USERNAME'];
                                    $myOutputvoucher->staffuser             = $result['STAFFUSER'];
                                    $myOutputvoucher->outputdate            = $date;
                                    $myOutputvoucher->quantity              = $result['QUANTITY'];
                                    $myOutputvoucher->costprice             = $result['COSTPRICE'];
                                    $myOutputvoucher->saleprice             = $result['SALEPRICE'];
                                    $myOutputvoucher->totaldiscount         = $result['TOTALDISCOUNT'];
                                    $myOutputvoucher->promotiondiscount     = $result['PROMOTIONDISCOUNT'];
                                    $myOutputvoucher->vat                   = $result['VAT'];
                                    $myOutputvoucher->vatpercent            = $result['VATPERCENT'];
                                    $myOutputvoucher->isnew                 = $result['ISNEW'];
                                    $myOutputvoucher->voucherisdelete       = $result['VOUCHERISDELETE'];
                                    $myOutputvoucher->voucherdetailisdelete = $result['VOUCHERDETAILISDELETE'];
                                    $myOutputvoucher->applyproductid        = $result['APPLYPRODUCTID'];
                                    $myOutputvoucher->ovorarowscn        = $result['OVORA_ROWSCN'];
                                    $myOutputvoucher->ovdorarowscn        = $result['OVDORA_ROWSCN'];
                                    $myOutputvoucher->addData();
                                    $counter++;
                                }
                            }
                        }
                        unset($result);
                        unset($myOutputvoucher);
                        unset($start);
                        unset($end);
                    }
                }
            }
        }

        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter.'--COunter updated: '.$counterupdate;
    }

    //inputvoucher
    public function syncinputvoucherAction()
    {
        set_time_limit(0);
        $recordPerPage = 1000;
        $counter = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();


        $lastrowold = $db3->query('SELECT max(iv_dorarowscn) FROM '.TABLE_PREFIX.'inputvoucher LIMIT 1')->fetchColumn(0);
        $lastrowold2 = $db3->query('SELECT max(iv_orarowscn) FROM '.TABLE_PREFIX.'inputvoucher LIMIT 1')->fetchColumn(0);


        //import du lieu thang moi nhat

        $lastrow = '';
        $lastrow = $db3->query('SELECT max(iv_inputdate) FROM '.TABLE_PREFIX.'inputvoucher LIMIT 1')->fetchColumn(0);
        $totaltrung = 0;
        if ($lastrow > 0)
        {
            $strparsingime = strtoupper(date('d-M-y' , $lastrow));
            $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_INPUTVOUCHER_DM WHERE INPUTDATE >= TO_DATE(\''. $strparsingime .'\')';
             $countAll = $oracle->query($sql);

             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }
             $totalpage = ceil($total/$recordPerPage);

            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_INPUTVOUCHER_DM ov WHERE INPUTDATE >= TO_DATE(\''. $strparsingime .'\')) WHERE r > ' . $start .' AND r <=' . $end;
                $results = $oracle->query($sql);

                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTDATE']);
                    $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                    $checker = Core_Backend_Inputvoucher::getInputvouchers(array(
                                                                    //'fpiid' => $result['INPUTTYPEID'],
                                                                    //'fpbarcode' => $result['PRODUCTID'],
                                                                    //'fsid' => $result['STOREID'],
                                                                    'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID'],
                                                                    'finputvoucherid' => $result['INPUTVOUCHERID'],
                                                                    //'forderid' => $result['ORDERID'],
                                                                    //'finvoiceid' => $result['INVOICEID'],
                                                                    //'forarowscn' => $result['IVORA_ROWSCN'],
                                                                    //'fdorarowscn' => $result['IVDORA_ROWSCN'],
                                                                    ) , 'id' , 'ASC' , '' , true);

                    if($checker == 0)
                    {
                        $myInputVoucher                        = new Core_Backend_Inputvoucher();

                        $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                        $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                        $myInputVoucher->orderid = $result['ORDERID'];
                        $myInputVoucher->invoiceid = $result['INVOICEID'];
                        $myInputVoucher->sid = $result['STOREID'];
                        $myInputVoucher->username = $result['USERNAME'];
                        $myInputVoucher->inputdate = $date;
                        $myInputVoucher->piid = $result['INPUTTYPEID'];
                        $myInputVoucher->pbarcode = $result['PRODUCTID'];
                        $myInputVoucher->quantity = $result['QUANTITY'];
                        $myInputVoucher->price = (float)$result['PRICE'];
                        $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                        $myInputVoucher->discount = (float)$result['DISCOUNT'];
                        $myInputVoucher->vat = $result['VAT'];
                        $myInputVoucher->vatpercent = $result['VATPERCENT'];
                        $myInputVoucher->isnew = $result['ISNEW'];
                        $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                        $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                        $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                        $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];

                        if($myInputVoucher->addData() > 0)
                        {
                            $counter++;
                            unset($myInputVoucher);
                            unset($result);
                            unset($checker);
                        }
                    }
                    else
                    {
                        $totaltrung++;
                    }
                }

                unset($results);
                unset($start);
                unset($end);
            }
        }

        $lastrow = $lastrowold;

        if ($lastrow > 0)
        {
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_INPUTVOUCHER_DM WHERE INPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND IVDORA_ROWSCN > '.$lastrow);
            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_INPUTVOUCHER_DM a WHERE a.INPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND a.IVDORA_ROWSCN > '.$lastrow.') WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTDATE']);
                            $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Inputvoucher::getInputvouchers(array(
                                                                    //'fpiid' => $result['INPUTTYPEID'],
                                                                    //'fpbarcode' => $result['PRODUCTID'],
                                                                    //'fsid' => $result['STOREID'],
                                                                    'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID'],
                                                                    'finputvoucherid' => $result['INPUTVOUCHERID'],
                                                                    //'forderid' => $result['ORDERID'],
                                                                    //'finvoiceid' => $result['INVOICEID'],
                                                                    //'fdorarowscn' => $result['IVDORA_ROWSCN'],
                                                                    ) , 'id' , 'ASC' , '0,1');
                            if (count($checker) == 0)
                            {
                                $myInputVoucher                        = new Core_Backend_Inputvoucher();

                                $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myInputVoucher->orderid = $result['ORDERID'];
                                    $myInputVoucher->invoiceid = $result['INVOICEID'];
                                    $myInputVoucher->sid = $result['STOREID'];
                                    $myInputVoucher->username = $result['USERNAME'];
                                    $myInputVoucher->inputdate = $date;
                                    $myInputVoucher->piid = $result['INPUTTYPEID'];
                                    $myInputVoucher->pbarcode = $result['PRODUCTID'];
                                    $myInputVoucher->quantity = $result['QUANTITY'];
                                    $myInputVoucher->price = (float)$result['PRICE'];
                                    $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                                    $myInputVoucher->discount = (float)$result['DISCOUNT'];
                                    $myInputVoucher->vat = $result['VAT'];
                                    $myInputVoucher->vatpercent = $result['VATPERCENT'];
                                    $myInputVoucher->isnew = $result['ISNEW'];
                                    $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                                    $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                                    $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                                    $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];
                                $myInputVoucher->addData();
                            }
                            elseif($checker[0]->id >0 )
                            {
                                $myInputVoucher = new Core_Backend_Inputvoucher($checker[0]->id);
                                if ($myInputVoucher->id > 0)
                                {
                                    $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myInputVoucher->orderid = $result['ORDERID'];
                                    $myInputVoucher->invoiceid = $result['INVOICEID'];
                                    $myInputVoucher->sid = $result['STOREID'];
                                    $myInputVoucher->username = $result['USERNAME'];
                                    $myInputVoucher->inputdate = $date;
                                    $myInputVoucher->piid = $result['INPUTTYPEID'];
                                    $myInputVoucher->pbarcode = $result['PRODUCTID'];
                                    $myInputVoucher->quantity = $result['QUANTITY'];
                                    $myInputVoucher->price = (float)$result['PRICE'];
                                    $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                                    $myInputVoucher->discount = (float)$result['DISCOUNT'];
                                    $myInputVoucher->vat = $result['VAT'];
                                    $myInputVoucher->vatpercent = $result['VATPERCENT'];
                                    $myInputVoucher->isnew = $result['ISNEW'];
                                    $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                                    $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                                    $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                                    $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];
                                    $myInputVoucher->updateData();
                                }
                                else
                                {
                                    $myInputVoucher                        = new Core_Backend_Inputvoucher();
                                    $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myInputVoucher->orderid = $result['ORDERID'];
                                    $myInputVoucher->invoiceid = $result['INVOICEID'];
                                    $myInputVoucher->sid = $result['STOREID'];
                                    $myInputVoucher->username = $result['USERNAME'];
                                    $myInputVoucher->inputdate = $date;
                                    $myInputVoucher->piid = $result['INPUTTYPEID'];
                                    $myInputVoucher->pbarcode = $result['PRODUCTID'];
                                    $myInputVoucher->quantity = $result['QUANTITY'];
                                    $myInputVoucher->price = (float)$result['PRICE'];
                                    $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                                    $myInputVoucher->discount = (float)$result['DISCOUNT'];
                                    $myInputVoucher->vat = $result['VAT'];
                                    $myInputVoucher->vatpercent = $result['VATPERCENT'];
                                    $myInputVoucher->isnew = $result['ISNEW'];
                                    $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                                    $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                                    $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                                    $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];
                                    $myInputVoucher->addData();
                                }
                            }

                            $counter++;
                        }
                        unset($result);
                        unset($myInputVoucher);
                        unset($start);
                        unset($end);
                    }
                }
            }
        }
        unset($lastrow);
        unset($countAll);

        $lastrow = $lastrowold2;
        if ($lastrow > 0)
        {
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_INPUTVOUCHER_DM WHERE INPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND IVORA_ROWSCN > '.$lastrow);

            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_INPUTVOUCHER_DM a WHERE a.INPUTDATE >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND a.IVORA_ROWSCN > '.$lastrow.') WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTDATE']);
                            $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Inputvoucher::getInputvouchers(array(
                                                                    //'fpiid' => $result['INPUTTYPEID'],
                                                                    //'fpbarcode' => $result['PRODUCTID'],
                                                                    //'fsid' => $result['STOREID'],
                                                                    'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID'],
                                                                    'finputvoucherid' => $result['INPUTVOUCHERID'],
                                                                    //'forderid' => $result['ORDERID'],
                                                                    //'finvoiceid' => $result['INVOICEID'],
                                                                    //'forarowscn' => $result['IVORA_ROWSCN'],
                                                                    //'fdorarowscn' => $result['IVDORA_ROWSCN'],
                                                                    ) , 'id' , 'ASC' , '0,1');
                            if (count($checker) == 0)
                            {
                                $myInputVoucher                        = new Core_Backend_Inputvoucher();

                                $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                                $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                $myInputVoucher->orderid = $result['ORDERID'];
                                $myInputVoucher->invoiceid = $result['INVOICEID'];
                                $myInputVoucher->sid = $result['STOREID'];
                                $myInputVoucher->username = $result['USERNAME'];
                                $myInputVoucher->inputdate = $date;
                                $myInputVoucher->piid = $result['INPUTTYPEID'];
                                $myInputVoucher->pbarcode = $result['PRODUCTID'];
                                $myInputVoucher->quantity = $result['QUANTITY'];
                                $myInputVoucher->price = (float)$result['PRICE'];
                                $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                                $myInputVoucher->discount = (float)$result['DISCOUNT'];
                                $myInputVoucher->vat = $result['VAT'];
                                $myInputVoucher->vatpercent = $result['VATPERCENT'];
                                $myInputVoucher->isnew = $result['ISNEW'];
                                $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                                $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                                $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                                $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];
                                $myInputVoucher->addData();
                            }
                            elseif($checker[0]->id >0 )
                            {
                                $myInputVoucher = new Core_Backend_Inputvoucher($checker[0]->id);
                                if ($myInputVoucher->id > 0)
                                {
                                    $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myInputVoucher->orderid = $result['ORDERID'];
                                    $myInputVoucher->invoiceid = $result['INVOICEID'];
                                    $myInputVoucher->sid = $result['STOREID'];
                                    $myInputVoucher->username = $result['USERNAME'];
                                    $myInputVoucher->inputdate = $date;
                                    $myInputVoucher->piid = $result['INPUTTYPEID'];
                                    $myInputVoucher->pbarcode = $result['PRODUCTID'];
                                    $myInputVoucher->quantity = $result['QUANTITY'];
                                    $myInputVoucher->price = (float)$result['PRICE'];
                                    $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                                    $myInputVoucher->discount = (float)$result['DISCOUNT'];
                                    $myInputVoucher->vat = $result['VAT'];
                                    $myInputVoucher->vatpercent = $result['VATPERCENT'];
                                    $myInputVoucher->isnew = $result['ISNEW'];
                                    $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                                    $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                                    $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                                    $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];
                                    $myInputVoucher->updateData();
                                }
                                else
                                {
                                    $myInputVoucher                        = new Core_Backend_Inputvoucher();
                                    $myInputVoucher->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myInputVoucher->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myInputVoucher->orderid = $result['ORDERID'];
                                    $myInputVoucher->invoiceid = $result['INVOICEID'];
                                    $myInputVoucher->sid = $result['STOREID'];
                                    $myInputVoucher->username = $result['USERNAME'];
                                    $myInputVoucher->inputdate = $date;
                                    $myInputVoucher->piid = $result['INPUTTYPEID'];
                                    $myInputVoucher->pbarcode = $result['PRODUCTID'];
                                    $myInputVoucher->quantity = $result['QUANTITY'];
                                    $myInputVoucher->price = (float)$result['PRICE'];
                                    $myInputVoucher->inputprice = (float)$result['INPUTPRICE'];
                                    $myInputVoucher->discount = (float)$result['DISCOUNT'];
                                    $myInputVoucher->vat = $result['VAT'];
                                    $myInputVoucher->vatpercent = $result['VATPERCENT'];
                                    $myInputVoucher->isnew = $result['ISNEW'];
                                    $myInputVoucher->isvoucherdelete = $result['VOUCHERISDELETE'];
                                    $myInputVoucher->isvoucherdetaildelete = $result['VOUCHERDETAILISDELETE'];
                                    $myInputVoucher->orarowscn = $result['IVORA_ROWSCN'];
                                    $myInputVoucher->dorarowscn = $result['IVDORA_ROWSCN'];
                                    $myInputVoucher->addData();
                                }
                            }

                            $counter++;
                        }
                        unset($result);
                        unset($myInputVoucher);
                        unset($start);
                        unset($end);
                    }
                }
            }
        }


        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter;
    }

    public function syncoutputvoucherreturnAction()
    {
        set_time_limit(0);
        $recordPerPage = 1000;
        $counter = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();

        $lastrowold = $db3->query('SELECT max(ovr_orarowscn) FROM '.TABLE_PREFIX.'outputvoucherreturn LIMIT 1')->fetchColumn(0);

        //import du lieu thang moi nhat


        $lastrow = $db3->query('SELECT max(ovr_inputtime) FROM '.TABLE_PREFIX.'outputvoucherreturn LIMIT 1')->fetchColumn(0);
        if ($lastrow > 0)
        {
            $strparsingime = strtoupper(date('d-M-y' , $lastrow));
            $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_RETURN_DM WHERE INPUTTIME >= TO_DATE(\''. $strparsingime .'\')';
             $countAll = $oracle->query($sql);

             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }
             $totalpage = ceil($total/$recordPerPage);

            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_RETURN_DM ov WHERE INPUTTIME >= TO_DATE(\''. $strparsingime .'\')) WHERE r > ' . $start .' AND r <=' . $end;
                $results = $oracle->query($sql);

                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTTIME']);
                            $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Outputvoucherreturn::getOutputvoucherreturns(array(
                                                                    //'fpbarcode'   => $result['PRODUCTID'],
                                                                    //'fsaleorderid' => $result['SALEORDERID'],
                                                                    //'fsaleorderdetailid' => $result['SALEORDERDETAILID'],
                                                                    'finputreturnid' => $result['INPUTRETURNID'],
                                                                    'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                                                                    'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                                                                    'finputvoucherid' => $result['INPUTVOUCHERID'],
                                                                    'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID']
                                                                    ) , 'id' , 'ASC' , '' , true);

                    if($checker == 0)
                    {
                        $myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn();

                                $myOutputvoucherreturn->pbarcode = $result['PRODUCTID'];
                                $myOutputvoucherreturn->saleorderid = $result['SALEORDERID'];
                                $myOutputvoucherreturn->saleorderdetailid = $result['SALEORDERDETAILID'];
                                $myOutputvoucherreturn->inputreturnid = $result['INPUTRETURNID'];
                                $myOutputvoucherreturn->outputvoucherid = $result['OUTPUTVOUCHERID'];
                                $myOutputvoucherreturn->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                $myOutputvoucherreturn->quantity = $result['QUANTITY'];
                                $myOutputvoucherreturn->imei = $result['IMIE'];
                                $myOutputvoucherreturn->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                $myOutputvoucherreturn->inputtime = $date;
                                $myOutputvoucherreturn->inputvoucherid = $result['INPUTVOUCHERID'];
                                $myOutputvoucherreturn->isreturnwithfee = $result['ISRETURNWITHFEE'];
                                $myOutputvoucherreturn->price = $result['PRICE'];
                                $myOutputvoucherreturn->returnfee = $result['RETURNFEE'];
                                $myOutputvoucherreturn->returnnote = $result['RETURNNOTE'];
                                $myOutputvoucherreturn->returnreason = $result['RETURNREASON'];
                                $myOutputvoucherreturn->storemanageruser = $result['STOREMANAGERUSER'];
                                $myOutputvoucherreturn->adjustprice = $result['ADJUSTPRICE'];
                                $myOutputvoucherreturn->originalprice = $result['ORIGINALPRICE'];
                                $myOutputvoucherreturn->totalvatlost = $result['TOTALVATLOST'];
                                $myOutputvoucherreturn->returnreasonid = $result['RETURNREASONID'];
                                $myOutputvoucherreturn->inputprice = $result['INPUTPRICE'];
                                $myOutputvoucherreturn->ivdetailprice = $result['IVDETAILPRICE'];
                                $myOutputvoucherreturn->iserror = $result['ISERROR'];
                                $myOutputvoucherreturn->ovisdelete = $result['OVISDELETE'];
                                $myOutputvoucherreturn->ovdetailisdelete = $result['OVDETAILISDELETE'];
                                $myOutputvoucherreturn->sid = $result['STOREID'];
                                $myOutputvoucherreturn->inputtypeid = $result['INPUTTYPEID'];
                                $myOutputvoucherreturn->orarowscn = $result['IVDORA_ROWSCN'];


                        if($myOutputvoucherreturn->addData() > 0)
                        {
                            $counter++;
                            unset($myOutputvoucherreturn);
                            unset($result);
                            unset($checker);
                        }
                    }
                }

                unset($results);
                unset($start);
                unset($end);
            }
        }

        $lastrow = $lastrowold;
        if ($lastrow > 0)
        {
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_OUTPUTVOUCHER_RETURN_DM WHERE INPUTTIME >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND ORA_ROWSCN > '.$lastrow);

            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT a.* , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_RETURN_DM a WHERE a.INPUTTIME >= TO_DATE(\''. strtoupper(date('d-M-y', strtotime('-2 month'))) .'\') AND a.ORA_ROWSCN > '.$lastrow.') WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['INPUTTIME']);
                            $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = Core_Backend_Outputvoucherreturn::getOutputvoucherreturns(array(
                                                                    //'fpbarcode'   => $result['PRODUCTID'],
                                                                    //'fsaleorderid' => $result['SALEORDERID'],
                                                                    //'fsaleorderdetailid' => $result['SALEORDERDETAILID'],
                                                                    'finputreturnid' => $result['INPUTRETURNID'],
                                                                    'foutputvoucherid' => $result['OUTPUTVOUCHERID'],
                                                                    'foutputvoucherdetailid' => $result['OUTPUTVOUCHERDETAILID'],
                                                                    'finputvoucherid' => $result['INPUTVOUCHERID'],
                                                                    'finputvoucherdetailid' => $result['INPUTVOUCHERDETAILID']
                                                                ) , 'id' , 'ASC' , '0,1');
                            if (count($checker) == 0)
                            {
                                $myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn();

                                $myOutputvoucherreturn->pbarcode = $result['PRODUCTID'];
                                $myOutputvoucherreturn->saleorderid = $result['SALEORDERID'];
                                $myOutputvoucherreturn->saleorderdetailid = $result['SALEORDERDETAILID'];
                                $myOutputvoucherreturn->inputreturnid = $result['INPUTRETURNID'];
                                $myOutputvoucherreturn->outputvoucherid = $result['OUTPUTVOUCHERID'];
                                $myOutputvoucherreturn->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                $myOutputvoucherreturn->quantity = $result['QUANTITY'];
                                $myOutputvoucherreturn->imei = $result['IMIE'];
                                $myOutputvoucherreturn->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                $myOutputvoucherreturn->inputtime = $date;
                                $myOutputvoucherreturn->inputvoucherid = $result['INPUTVOUCHERID'];
                                $myOutputvoucherreturn->isreturnwithfee = $result['ISRETURNWITHFEE'];
                                $myOutputvoucherreturn->price = $result['PRICE'];
                                $myOutputvoucherreturn->returnfee = $result['RETURNFEE'];
                                $myOutputvoucherreturn->returnnote = $result['RETURNNOTE'];
                                $myOutputvoucherreturn->returnreason = $result['RETURNREASON'];
                                $myOutputvoucherreturn->storemanageruser = $result['STOREMANAGERUSER'];
                                $myOutputvoucherreturn->adjustprice = $result['ADJUSTPRICE'];
                                $myOutputvoucherreturn->originalprice = $result['ORIGINALPRICE'];
                                $myOutputvoucherreturn->totalvatlost = $result['TOTALVATLOST'];
                                $myOutputvoucherreturn->returnreasonid = $result['RETURNREASONID'];
                                $myOutputvoucherreturn->inputprice = $result['INPUTPRICE'];
                                $myOutputvoucherreturn->ivdetailprice = $result['IVDETAILPRICE'];
                                $myOutputvoucherreturn->iserror = $result['ISERROR'];
                                $myOutputvoucherreturn->ovisdelete = $result['OVISDELETE'];
                                $myOutputvoucherreturn->ovdetailisdelete = $result['OVDETAILISDELETE'];
                                $myOutputvoucherreturn->sid = $result['STOREID'];
                                $myOutputvoucherreturn->inputtypeid = $result['INPUTTYPEID'];
                                $myOutputvoucherreturn->orarowscn = $result['IVDORA_ROWSCN'];
                                $myOutputvoucherreturn->addData();
                            }
                            elseif($checker[0]->id >0 )
                            {
                                $myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn($checker[0]->id);
                                if ($myOutputvoucherreturn->id > 0)
                                {
                                    $myOutputvoucherreturn->pbarcode = $result['PRODUCTID'];
                                    $myOutputvoucherreturn->saleorderid = $result['SALEORDERID'];
                                    $myOutputvoucherreturn->saleorderdetailid = $result['SALEORDERDETAILID'];
                                    $myOutputvoucherreturn->inputreturnid = $result['INPUTRETURNID'];
                                    $myOutputvoucherreturn->outputvoucherid = $result['OUTPUTVOUCHERID'];
                                    $myOutputvoucherreturn->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                    $myOutputvoucherreturn->quantity = $result['QUANTITY'];
                                    $myOutputvoucherreturn->imei = $result['IMIE'];
                                    $myOutputvoucherreturn->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myOutputvoucherreturn->inputtime = $date;
                                    $myOutputvoucherreturn->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myOutputvoucherreturn->isreturnwithfee = $result['ISRETURNWITHFEE'];
                                    $myOutputvoucherreturn->price = $result['PRICE'];
                                    $myOutputvoucherreturn->returnfee = $result['RETURNFEE'];
                                    $myOutputvoucherreturn->returnnote = $result['RETURNNOTE'];
                                    $myOutputvoucherreturn->returnreason = $result['RETURNREASON'];
                                    $myOutputvoucherreturn->storemanageruser = $result['STOREMANAGERUSER'];
                                    $myOutputvoucherreturn->adjustprice = $result['ADJUSTPRICE'];
                                    $myOutputvoucherreturn->originalprice = $result['ORIGINALPRICE'];
                                    $myOutputvoucherreturn->totalvatlost = $result['TOTALVATLOST'];
                                    $myOutputvoucherreturn->returnreasonid = $result['RETURNREASONID'];
                                    $myOutputvoucherreturn->inputprice = $result['INPUTPRICE'];
                                    $myOutputvoucherreturn->ivdetailprice = $result['IVDETAILPRICE'];
                                    $myOutputvoucherreturn->iserror = $result['ISERROR'];
                                    $myOutputvoucherreturn->ovisdelete = $result['OVISDELETE'];
                                    $myOutputvoucherreturn->ovdetailisdelete = $result['OVDETAILISDELETE'];
                                    $myOutputvoucherreturn->sid = $result['STOREID'];
                                    $myOutputvoucherreturn->inputtypeid = $result['INPUTTYPEID'];
                                    $myOutputvoucherreturn->orarowscn = $result['IVDORA_ROWSCN'];
                                    $myOutputvoucherreturn->updateData();
                                }
                                else
                                {
                                    $myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn();
                                    $myOutputvoucherreturn->pbarcode = $result['PRODUCTID'];
                                    $myOutputvoucherreturn->saleorderid = $result['SALEORDERID'];
                                    $myOutputvoucherreturn->saleorderdetailid = $result['SALEORDERDETAILID'];
                                    $myOutputvoucherreturn->inputreturnid = $result['INPUTRETURNID'];
                                    $myOutputvoucherreturn->outputvoucherid = $result['OUTPUTVOUCHERID'];
                                    $myOutputvoucherreturn->outputvoucherdetailid = $result['OUTPUTVOUCHERDETAILID'];
                                    $myOutputvoucherreturn->quantity = $result['QUANTITY'];
                                    $myOutputvoucherreturn->imei = $result['IMIE'];
                                    $myOutputvoucherreturn->inputvoucherdetailid = $result['INPUTVOUCHERDETAILID'];
                                    $myOutputvoucherreturn->inputtime = $date;
                                    $myOutputvoucherreturn->inputvoucherid = $result['INPUTVOUCHERID'];
                                    $myOutputvoucherreturn->isreturnwithfee = $result['ISRETURNWITHFEE'];
                                    $myOutputvoucherreturn->price = $result['PRICE'];
                                    $myOutputvoucherreturn->returnfee = $result['RETURNFEE'];
                                    $myOutputvoucherreturn->returnnote = $result['RETURNNOTE'];
                                    $myOutputvoucherreturn->returnreason = $result['RETURNREASON'];
                                    $myOutputvoucherreturn->storemanageruser = $result['STOREMANAGERUSER'];
                                    $myOutputvoucherreturn->adjustprice = $result['ADJUSTPRICE'];
                                    $myOutputvoucherreturn->originalprice = $result['ORIGINALPRICE'];
                                    $myOutputvoucherreturn->totalvatlost = $result['TOTALVATLOST'];
                                    $myOutputvoucherreturn->returnreasonid = $result['RETURNREASONID'];
                                    $myOutputvoucherreturn->inputprice = $result['INPUTPRICE'];
                                    $myOutputvoucherreturn->ivdetailprice = $result['IVDETAILPRICE'];
                                    $myOutputvoucherreturn->iserror = $result['ISERROR'];
                                    $myOutputvoucherreturn->ovisdelete = $result['OVISDELETE'];
                                    $myOutputvoucherreturn->ovdetailisdelete = $result['OVDETAILISDELETE'];
                                    $myOutputvoucherreturn->sid = $result['STOREID'];
                                    $myOutputvoucherreturn->inputtypeid = $result['INPUTTYPEID'];
                                    $myOutputvoucherreturn->orarowscn = $result['IVDORA_ROWSCN'];
                                    $myOutputvoucherreturn->addData();
                                }
                            }

                            $counter++;
                        }
                        unset($result);
                        unset($myOutputvoucherreturn);
                        unset($start);
                        unset($end);
                    }
                }
            }
        }

        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter;
    }

    public function syncproductrewardAction()
    {
        set_time_limit(0);
        $recordPerPage = 1000;
        $counter = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();

        //import du lieu thang moi nhat

        $lastrow = '';
        $lastrow = $db3->query('SELECT max(pr_updateddate) FROM '.TABLE_PREFIX.'productreward LIMIT 1')->fetchColumn(0);
        if (!empty($_GET['first'])) $lastrow = strtotime('2013-01-01');
        if ($lastrow > 0)
        {
            $strparsingime = strtoupper(date('d-M-y' , $lastrow));
            $sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_PRODUCTREWARD_DM WHERE UPDATEDDATE >= TO_DATE(\''. $strparsingime .'\')';

             $countAll = $oracle->query($sql);

             foreach ($countAll as $count)
             {
                $total = $count['TOTAL'];
             }
             $totalpage = ceil($total/$recordPerPage);

            for ($i = 1 ; $i <= $totalpage ; $i++)
            {
                $start = ($recordPerPage * $i) - $recordPerPage;
                $end = $recordPerPage * $i;

                $sql = 'SELECT * FROM (SELECT ov.* , ROWNUM r FROM ERP.VW_PRODUCTREWARD_DM ov WHERE UPDATEDDATE >= TO_DATE(\''. $strparsingime .'\')) WHERE r > ' . $start .' AND r <=' . $end;

                $results = $oracle->query($sql);

                foreach ($results as $result)
                {
                    $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['UPDATEDDATE']);
                    $date =  strtotime($dateUpdated->format('Y-m-d 00:00:01'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
                    $checker = Core_Backend_Productreward::getProductrewards(array('fpoid' => $result['OUTPUTTYPEID'],
                                                                                    'fppaid' => $result['PRICEAREAID'],
                                                                                    'fpbarcode' => $result['PRODUCTID'],
                                                                                    //'fupdateddate' => $date,
                                                                            ), '', '', '0, 1');

                    $myProductrewards = new Core_Backend_Productreward();
                    $myProductrewards->poid = $result['OUTPUTTYPEID'];
                    $myProductrewards->ppaid = $result['PRICEAREAID'];
                    $myProductrewards->isconfirmrewardforstaff = $result['ISCONFIRMREWARDFORSTAFF'];
                    $myProductrewards->pbarcode = $result['PRODUCTID'];
                    $myProductrewards->totalrewardforstaff = $result['TOTALREWARDFORSTAFF'];
                    $myProductrewards->updateddate = $date;
                    if (count($checker) == 0)
                    {
                        if ($myProductrewards->addData())
                        {
                            $counter++;
                        }

                    }
                    elseif (!empty($checker[0]->id))
                    {
                        $myProductrewards->id = $checker[0]->id;
                        $myProductrewards->updateData();
                        //echo '<br />'.$date.'--'.date('Y-m-d', $date).'--'.$result['OUTPUTTYPEID'].'-'.$result['PRICEAREAID'].'-'.$result['PRODUCTID'];
                    }
                    unset($myProductrewards);
                    unset($dateUpdated);
                    unset($date);
                }
            }
        }
        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter;
    }

    public function syncstorestastisticAction()
    {
        set_time_limit(0);
        $recordPerPage = 1000;
        $counter = 0;
        $total = 0;
        $timer = new timer();
        $timer->start();
        $db3 = Core_Backend_Object::getDb();
        $oracle = new Oracle();
        $lastrow = '';
        $lastrow = $db3->query('SELECT max(ss_statisticdate) FROM '.TABLE_PREFIX.'store_statistic LIMIT 1')->fetchColumn(0);
        if ($lastrow > 0)
        {
            if (date('Ymd') < date('Ymd', $lastrow)) {
                $lastrow = mktime(0, 0, 0, date('n'), date('j') - 1, date('Y'));
            }
            $countAll = $oracle->query('SELECT count(*) as total from ERP.VW_STORE_STATISTIC WHERE STATISTICDATE >= TO_DATE(\''.strtoupper(date('d-M-y',$lastrow)) .'\')');
            //echodebug('SELECT count(*) as total from ERP.VW_STORE_STATISTIC WHERE STATISTICDATE >= TO_DATE(\''.strtoupper(date('d-M-y',$lastrow)) .'\')', true);
            if (!empty($countAll))
            {
                $total = $countAll[0]['TOTAL'];
                if ($total > 0)
                {
                    $totalpage = ceil($total/$recordPerPage);
                    for ($i = 1 ; $i <= $totalpage ; $i++)
                    {
                        $start = ($recordPerPage * $i) - $recordPerPage;
                        $end = $recordPerPage * $i;

                        $sql = 'SELECT * FROM (SELECT sum(a.STATISTICVALUE) as STATISTICVALUE, a.STATISTICDATE, a.STOREID , ROWNUM r FROM ERP.VW_STORE_STATISTIC a WHERE STATISTICDATE >= TO_DATE(\''.strtoupper(date('d-M-y',$lastrow)) .'\') GROUP BY a.STATISTICDATE, a.STOREID, ROWNUM) WHERE r > ' . $start .' AND r <=' . $end;
                        $results = $oracle->query($sql);

                        foreach($results as $result)
                        {
                            //$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['STATISTICDATE']);
                            $date =  strtotime($result['STATISTICDATE']);//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

                            $checker = $db3->query('SELECT ss_id, ss_statisticvalue FROM '.TABLE_PREFIX.'store_statistic
                                                    WHERE ss_statisticdate = ? AND s_id = ? LIMIT 1',
                                                    array($date, $result['STOREID'])
                                                    )->fetch();
                            if (count($checker) > 0 && $checker['ss_id'] > 0)
                            {
                                $sqlupdate = 'UPDATE '.TABLE_PREFIX.'store_statistic SET ss_statisticvalue= ? , ss_statisticdate = ? , s_id = ? WHERE ss_id = ?';
                                $db3->query($sqlupdate, array($result['STATISTICVALUE'], $date, $result['STOREID'], $checker['ss_id']));
                            }
                            else
                            {

                                $sqlupdate = 'INSERT INTO '.TABLE_PREFIX.'store_statistic (ss_statisticvalue , ss_statisticdate , s_id ) VALUES (?, ?, ?)';
                                $db3->query($sqlupdate, array($result['STATISTICVALUE'], $date, $result['STOREID']));
                                $counter++;
                            }
                        }
                    }
                }
            }
        }
        $timer->stop();
        echo $timer->get_exec_time().'<br />';
        echo 'Row affected : ' . $counter;
    }

    private function getDb($db = 'db')
    {
        global $conf;
        $dbconnect = null;
        try
            {
                $dbconnect = new MyPDO('mysql:host=' . $conf[$db]['host'] . ';dbname=' . $conf[$db]['name'] . '', '' . $conf[$db]['user'] . '', '' . $conf[$db]['pass'] . '');
                $dbconnect->query('SET NAMES utf8');
            }
            catch(PDOException $e)
            {
                $error = $e->getMessage();
                die('Can not connect to Dienmay FrontEnd DB. <!-- '.$error.'-->');
            }
        return $dbconnect;
    }

    //-------------------CACHE THEO NGAY, THEO TUAN, THEO THANG-------------------------------------------------------
    public function cachereporttopitemdayweekmonthAction()//bycategory
    {
        set_time_limit(0);
        ini_set('display_errors', 1);
        $timer = new timer();
        $timer->start();
        $limitsorttopitem = 20;
        $db3 = Core_Backend_Object::getDb();//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));//strtotime('-1 month')
        $startdate = strtotime(date('Y-m-d', $startdate));
        //$enddate = strtotime(date('Y-m-d 23:59:59', $enddate));
        //$enddate = strtotime('+1 day', $enddate);
        //$liststores = Core_Store::getStoresFromCache();

        //Category cache
            $allcategoryproductbyday = array();
            $allcategoryproductbyweek = array();
            $allcategoryproductbymonth = array();

            $allcategoryproductbydays = array();
            $allcategoryproductbyweeks = array();
            $allcategoryproductbymonths = array();

            $allproductbyday = array();
            $allproductbyweek = array();
            $allproductbymonth = array();

            $allproductbydays = array();
            $allproductbyweeks = array();
            $allproductbymonths = array();
            //lay tat ca category & product of category
            $listcategoryobject         = Core_Productcategory::getProductcategoryListFromCache();

            $listcategoryproductgreatethan0         = Core_Stat::getproducthavereport($startdate, $enddate);
            //$listproductcategories        = array();
            if (!empty($listcategoryobject))
            {
                $listcategory = array_keys($listcategoryobject);
                //$listcategory = array(42);
                if (!empty($listcategory))
                {
                    foreach ($listcategory as $catid)
                    {
                        $newlistproductcategoryhavecolors = array();
                        if (empty($listcategoryproductgreatethan0))
                        {
                            $listproductcategoryobject  = Core_Productcategory::getProductlistFromCache($catid);

                            if (!empty($listproductcategoryobject))
                            {
                                //$listproductcategories[$catid] = array_keys($listproductcategoryobject);
                                $listproductfromcategory = array_keys($listproductcategoryobject);
                                foreach ($listproductfromcategory as $pid)
                                {
                                    if (!empty($listproductcategoryobject[$pid]) && $listproductcategoryobject[$pid]['customizetype'] == Core_Product::CUSTOMIZETYPE_MAIN)
                                    {
                                        if (!empty($listproductcategoryobject[$pid]['color']))
                                        {
                                            foreach ($listproductcategoryobject[$pid]['color'] as $newpid)
                                            {
                                                if (!in_array($newpid, $newlistproductcategoryhavecolors)) $newlistproductcategoryhavecolors[] = $newpid;
                                            }
                                        }
                                        else
                                        {
                                            if (!in_array($pid, $newlistproductcategoryhavecolors)) $newlistproductcategoryhavecolors[] = $pid;
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            if (empty($listcategoryobject[$catid]['child']))
                            {
                                $newlistproductcategoryhavecolors = $listcategoryproductgreatethan0[$catid];
                            }
                            else
                            {
                                foreach ($listcategoryobject[$catid]['child'] as $childcatid)
                                {
                                    if (is_array($listcategoryproductgreatethan0[$childcatid]))$newlistproductcategoryhavecolors = array_merge($newlistproductcategoryhavecolors, $listcategoryproductgreatethan0[$childcatid]);
                                }
                                $newlistproductcategoryhavecolors = array_unique($newlistproductcategoryhavecolors);
                            }
                        }
                        if (!empty($newlistproductcategoryhavecolors))
                        {
                            $this->_cachetopitemprocessingproductid($catid, $newlistproductcategoryhavecolors,$startdate, $enddate, $allproductbyday, $allproductbyweek, $allproductbymonth, $allcategoryproductbyday, $allcategoryproductbyweek, $allcategoryproductbymonth, $allproductbydays, $allproductbyweeks, $allproductbymonths, $allcategoryproductbydays, $allcategoryproductbyweeks, $allcategoryproductbymonths );
                        }
                        unset($newlistproductcategoryhavecolors);
                        unset($listproductcategoryobject);
                    }
                }
            }

            //Sort product by date
            if (!empty($allproductbyday))
            {
                foreach ($allproductbyday as $dt => $productcal)
                {
                    //list product id by date
                    if (count($productcal) > 0)
                    {
                        $newproductcal = array();
                        foreach ($productcal as $pid=>$listproductcal)
                        {
                            if (count($listproductcal))
                            {
                                $newdoanhthu = 0;
                                $newsoluong = 0;
                                $newlaigop = 0;
                                $newtraffic = 0;
                                foreach ($listproductcal as $vcal)
                                {
                                    $newdoanhthu += $vcal['doanhthu'];
                                    $newsoluong += $vcal['soluong'];
                                    $newlaigop += $vcal['laigop'];
                                    $newtraffic += $vcal['traffic'];
                                }
                                $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                $newproductcal[] = $databydate;
                                unset($newdoanhthu);
                                unset($newsoluong);
                                unset($newlaigop);
                                unset($newtraffic);
                                unset($databydate);
                            }
                        }
                        if (empty($newproductcal)) continue;

                        $sort = $newproductcal;
                        usort($sort, 'sortdoanhthu');
                        $sort = array_slice($sort, 0, $limitsorttopitem);
                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_REVENUE, 'typevalue' => $dt), $sort);

                        unset($sort);
                        $sort = $newproductcal;
                        usort($sort, 'sortsoluong');
                        $sort = array_slice($sort, 0, $limitsorttopitem);
                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_VOLUME, 'typevalue' => $dt), $sort);

                        unset($sort);
                        $sort = $newproductcal;
                        usort($sort, 'sortlaigop');
                        $sort = array_slice($sort, 0, $limitsorttopitem);
                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_PROFIT, 'typevalue' => $dt), $sort);

                        unset($sort);
                        $sort = $newproductcal;
                        usort($sort, 'sorttraffic');
                        $sort = array_slice($sort, 0, $limitsorttopitem);
                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_TRAFFIC, 'typevalue' => $dt), $sort);

                        unset($newproductcal);
                        unset($sort);
                    }
                }
            }

            //theo tuan
            if (!empty($allproductbyweek))
            {
                foreach ($allproductbyweek as $year => $listofweek)
                {
                    if (count($listofweek) > 0)
                    {
                        foreach ($listofweek as $week => $productcal)
                        {
                            if (count($productcal) > 0)
                            {
                                $newproductcal = array();
                                foreach ($productcal as $pid=>$listproductcal)
                                {
                                    if (count($listproductcal))
                                    {
                                        $newdoanhthu = 0;
                                        $newsoluong = 0;
                                        $newlaigop = 0;
                                        $newtraffic = 0;
                                        foreach ($listproductcal as $vcal)
                                        {
                                            $newdoanhthu += $vcal['doanhthu'];
                                            $newsoluong += $vcal['soluong'];
                                            $newlaigop += $vcal['laigop'];
                                            $newtraffic += $vcal['traffic'];
                                        }
                                        $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                        $newproductcal[] = $databydate;
                                        unset($newdoanhthu);
                                        unset($newsoluong);
                                        unset($newlaigop);
                                        unset($newtraffic);
                                        unset($databydate);
                                    }
                                }
                                if (empty($newproductcal)) continue;
                                $sort = $newproductcal;
                                usort($sort, 'sortdoanhthu');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_REVENUE, 'typevalue' => $year.$week), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sortsoluong');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_VOLUME, 'typevalue' => $year.$week), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sortlaigop');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_PROFIT, 'typevalue' => $year.$week), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sorttraffic');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_TRAFFIC, 'typevalue' => $year.$week), $sort);
                            }
                        }
                    }
                }
            }


            //theo thang
            if (!empty($allproductbymonth))
            {
                foreach ($allproductbymonth as $year => $listofmonth)
                {
                    if (count($listofmonth) > 0)
                    {
                        foreach ($listofmonth as $month => $productcal)
                        {
                            //Luu cache truong hop sortdoanhthu
                            if (count($productcal) > 0)
                            {
                                $newproductcal = array();
                                foreach ($productcal as $pid=>$listproductcal)
                                {
                                    if (count($listproductcal))
                                    {
                                        $newdoanhthu = 0;
                                        $newsoluong = 0;
                                        $newlaigop = 0;
                                        $newtraffic = 0;
                                        foreach ($listproductcal as $vcal)
                                        {
                                            $newdoanhthu += $vcal['doanhthu'];
                                            $newsoluong += $vcal['soluong'];
                                            $newlaigop += $vcal['laigop'];
                                            $newtraffic += $vcal['traffic'];
                                        }
                                        $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                        $newproductcal[] = $databydate;
                                        unset($newdoanhthu);
                                        unset($newsoluong);
                                        unset($newlaigop);
                                        unset($newtraffic);
                                        unset($databydate);
                                    }
                                }
                                if (empty($newproductcal)) continue;
                                $sort = $newproductcal;
                                usort($sort, 'sortdoanhthu');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_REVENUE, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sortsoluong');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_VOLUME, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sortlaigop');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_PROFIT, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sorttraffic');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_TRAFFIC, 'typevalue' => $year.sprintf('%02d', $month)), $sort);
                            }
                        }
                    }
                }
            }


            //cache by store
            if (count($allproductbydays) > 0)
            {
                foreach ($allproductbydays as $dt => $productstores)
                {
                    if (count($productstores) > 0)
                    {
                        foreach ($productstores as $sid => $productcal)
                        {
                            if (count($productcal) > 0)
                            {
                                $newproductcal = array();
                                foreach ($productcal as $pid=>$listproductcal)
                                {
                                    if (count($listproductcal))
                                    {
                                        $newdoanhthu = 0;
                                        $newsoluong = 0;
                                        $newlaigop = 0;
                                        $newtraffic = 0;
                                        foreach ($listproductcal as $vcal)
                                        {
                                            $newdoanhthu += $vcal['doanhthu'];
                                            $newsoluong += $vcal['soluong'];
                                            $newlaigop += $vcal['laigop'];
                                            $newtraffic += $vcal['traffic'];
                                        }
                                        $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                        $newproductcal[] = $databydate;
                                        unset($newdoanhthu);
                                        unset($newsoluong);
                                        unset($newlaigop);
                                        unset($newtraffic);
                                        unset($databydate);
                                    }
                                }
                                if (empty($newproductcal)) continue;
                                $sort = $newproductcal;
                                usort($sort, 'sortdoanhthu');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_REVENUE, 'store' => $sid, 'typevalue' => $dt), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sortsoluong');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_VOLUME, 'store' => $sid, 'typevalue' => $dt), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sortlaigop');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_PROFIT, 'store' => $sid, 'typevalue' => $dt), $sort);

                                unset($sort);
                                $sort = $newproductcal;
                                usort($sort, 'sorttraffic');
                                $sort = array_slice($sort, 0, $limitsorttopitem);
                                Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_TRAFFIC, 'store' => $sid, 'typevalue' => $dt), $sort);
                            }
                        }
                    }
                }
            }
            //store theo tuan
            if (count($allproductbyweeks) > 0)
            {
                foreach ($allproductbyweeks as $year => $productbyweeks)
                {
                    if (count($productbyweeks) == 0) continue;
                    foreach ($productbyweeks as $week => $productstores)
                    {
                        if (count($productstores) > 0)
                        {
                            foreach ($productstores as $sid => $productcal)
                            {
                                if (count($productcal) > 0)
                                {
                                    $newproductcal = array();
                                    foreach ($productcal as $pid=>$listproductcal)
                                    {
                                        if (count($listproductcal))
                                        {
                                            $newdoanhthu = 0;
                                            $newsoluong = 0;
                                            $newlaigop = 0;
                                            $newtraffic = 0;
                                            foreach ($listproductcal as $vcal)
                                            {
                                                $newdoanhthu += $vcal['doanhthu'];
                                                $newsoluong += $vcal['soluong'];
                                                $newlaigop += $vcal['laigop'];
                                                $newtraffic += $vcal['traffic'];
                                            }
                                            $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                            $newproductcal[] = $databydate;
                                            unset($newdoanhthu);
                                            unset($newsoluong);
                                            unset($newlaigop);
                                            unset($newtraffic);
                                            unset($databydate);
                                        }
                                    }
                                    if (empty($newproductcal)) continue;
                                    $sort = $newproductcal;
                                    usort($sort, 'sortdoanhthu');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_REVENUE, 'store' => $sid, 'typevalue' => $year.$week), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortsoluong');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_VOLUME, 'store' => $sid, 'typevalue' => $year.$week), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortlaigop');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_PROFIT, 'store' => $sid, 'typevalue' => $year.$week), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sorttraffic');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_TRAFFIC, 'store' => $sid, 'typevalue' => $year.$week), $sort);
                                }
                            }
                        }
                    }
                }
            }

            //store theo thang
            if (count($allproductbymonths) > 0)
            {
                foreach ($allproductbymonths as $year => $productbymonths)
                {
                    if (count($productbymonths) == 0) continue;
                    foreach ($productbymonths as $month => $productstores)
                    {
                        if (count($productstores) > 0)
                        {
                            foreach ($productstores as $sid => $productcal)
                            {
                                if (count($productcal) > 0)
                                {
                                    $newproductcal = array();
                                    foreach ($productcal as $pid=>$listproductcal)
                                    {
                                        if (count($listproductcal))
                                        {
                                            $newdoanhthu = 0;
                                            $newsoluong = 0;
                                            $newlaigop = 0;
                                            $newtraffic = 0;
                                            foreach ($listproductcal as $vcal)
                                            {
                                                $newdoanhthu += $vcal['doanhthu'];
                                                $newsoluong += $vcal['soluong'];
                                                $newlaigop += $vcal['laigop'];
                                                $newtraffic += $vcal['traffic'];
                                            }
                                            $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                            $newproductcal[] = $databydate;
                                            unset($newdoanhthu);
                                            unset($newsoluong);
                                            unset($newlaigop);
                                            unset($newtraffic);
                                            unset($databydate);
                                        }
                                    }
                                    if (empty($newproductcal)) continue;
                                    $sort = $newproductcal;
                                    usort($sort, 'sortdoanhthu');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_REVENUE, 'store' => $sid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortsoluong');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_VOLUME, 'store' => $sid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortlaigop');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_PROFIT, 'store' => $sid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sorttraffic');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_TRAFFIC, 'store' => $sid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);
                                }
                            }
                        }
                    }
                }
            }

            unset($getAllProduct);
            unset($dt);
            unset($allproductbyday);
            unset($allproductbydays);
            unset($allproductbyweek);
            unset($allproductbyweeks);
            unset($allproductbymonth);
            unset($allproductbymonths);

            //------------------THEO CATEGORY--------------------

            //Sort product by date
            if (!empty($allcategoryproductbyday))
            {
                foreach ($allcategoryproductbyday as $catid => $listproductday)
                {
                    foreach ($listproductday as $dt => $productcal)
                    {
                        //Luu cache truong hop sortdoanhthu
                        if (count($productcal) > 0)
                        {
                            $newproductcal = array();
                            foreach ($productcal as $pid=>$listproductcal)
                            {
                                if (count($listproductcal))
                                {
                                    $newdoanhthu = 0;
                                    $newsoluong = 0;
                                    $newlaigop = 0;
                                    $newtraffic = 0;
                                    foreach ($listproductcal as $vcal)
                                    {
                                        $newdoanhthu += $vcal['doanhthu'];
                                        $newsoluong += $vcal['soluong'];
                                        $newlaigop += $vcal['laigop'];
                                        $newtraffic += $vcal['traffic'];
                                    }
                                    $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                    $newproductcal[] = $databydate;
                                    unset($newdoanhthu);
                                    unset($newsoluong);
                                    unset($newlaigop);
                                    unset($newtraffic);
                                    unset($databydate);
                                }
                            }
                            if (empty($newproductcal)) continue;
                            $sort = $newproductcal;
                            usort($sort, 'sortdoanhthu');
                            $sort = array_slice($sort, 0, $limitsorttopitem);
                            Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_REVENUE, 'category' => $catid, 'typevalue' => $dt), $sort);

                            unset($sort);
                            $sort = $newproductcal;
                            usort($sort, 'sortsoluong');
                            $sort = array_slice($sort, 0, $limitsorttopitem);
                            Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_VOLUME, 'category' => $catid, 'typevalue' => $dt), $sort);

                            unset($sort);
                            $sort = $newproductcal;
                            usort($sort, 'sortlaigop');
                            $sort = array_slice($sort, 0, $limitsorttopitem);
                            Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_PROFIT, 'category' => $catid, 'typevalue' => $dt), $sort);

                            unset($sort);
                            $sort = $newproductcal;
                            usort($sort, 'sorttraffic');
                            $sort = array_slice($sort, 0, $limitsorttopitem);
                            Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_TRAFFIC, 'category' => $catid, 'typevalue' => $dt), $sort);
                        }
                    }
                }
            }
            //theo tuan
            if (!empty($allcategoryproductbyweek))
            {
                foreach ($allcategoryproductbyweek as $catid => $listproductweek)
                {
                    foreach ($listproductweek as $year => $listofweek)
                    {
                        if (count($listofweek) > 0)
                        {
                            foreach ($listofweek as $week => $productcal)
                            {
                                //Luu cache truong hop sortdoanhthu
                                if (count($productcal) > 0)
                                {
                                    $newproductcal = array();
                                    foreach ($productcal as $pid=>$listproductcal)
                                    {
                                        if (count($listproductcal))
                                        {
                                            $newdoanhthu = 0;
                                            $newsoluong = 0;
                                            $newlaigop = 0;
                                            $newtraffic = 0;
                                            foreach ($listproductcal as $vcal)
                                            {
                                                $newdoanhthu += $vcal['doanhthu'];
                                                $newsoluong += $vcal['soluong'];
                                                $newlaigop += $vcal['laigop'];
                                                $newtraffic += $vcal['traffic'];
                                            }
                                            $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                            $newproductcal[] = $databydate;
                                            unset($newdoanhthu);
                                            unset($newsoluong);
                                            unset($newlaigop);
                                            unset($newtraffic);
                                            unset($databydate);
                                        }
                                    }
                                    if (empty($newproductcal)) continue;
                                    $sort = $newproductcal;
                                    usort($sort, 'sortdoanhthu');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_REVENUE, 'category' => $catid, 'typevalue' => $year.$week), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortsoluong');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_VOLUME, 'category' => $catid, 'typevalue' => $year.$week), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortlaigop');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_PROFIT, 'category' => $catid, 'typevalue' => $year.$week), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sorttraffic');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_TRAFFIC, 'category' => $catid, 'typevalue' => $year.$week), $sort);
                                }
                            }
                        }
                    }
                }
            }
            //theo thang
            if (!empty($allcategoryproductbymonth))
            {
                foreach ($allcategoryproductbymonth as $catid => $listproductmonth)
                {
                    foreach ($listproductmonth as $year => $listofmonth)
                    {
                        if (count($listofmonth) > 0)
                        {
                            foreach ($listofmonth as $month => $productcal)
                            {
                                //Luu cache truong hop sortdoanhthu
                                if (count($productcal) > 0)
                                {
                                    $newproductcal = array();
                                    foreach ($productcal as $pid=>$listproductcal)
                                    {
                                        if (count($listproductcal))
                                        {
                                            $newdoanhthu = 0;
                                            $newsoluong = 0;
                                            $newlaigop = 0;
                                            $newtraffic = 0;
                                            foreach ($listproductcal as $vcal)
                                            {
                                                $newdoanhthu += $vcal['doanhthu'];
                                                $newsoluong += $vcal['soluong'];
                                                $newlaigop += $vcal['laigop'];
                                                $newtraffic += $vcal['traffic'];
                                            }
                                            $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                            $newproductcal[] = $databydate;
                                            unset($newdoanhthu);
                                            unset($newsoluong);
                                            unset($newlaigop);
                                            unset($newtraffic);
                                            unset($databydate);
                                        }
                                    }
                                    if (empty($newproductcal)) continue;
                                    $sort = $newproductcal;
                                    usort($sort, 'sortdoanhthu');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_REVENUE, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortsoluong');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_VOLUME, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortlaigop');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_PROFIT, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sorttraffic');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_TRAFFIC, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);
                                }
                            }
                        }
                    }
                }
            }

            //cache by store
            if (count($allcategoryproductbydays) > 0)
            {
                foreach ($allcategoryproductbyday as $catid => $listproductday)
                {
                    foreach ($listproductday as $dt => $productstores)
                    {
                        if (count($productstores) > 0)
                        {
                            foreach ($productstores as $sid => $productcal)
                            {
                                if (count($productcal) > 0)
                                {
                                    $newproductcal = array();
                                    foreach ($productcal as $pid=>$listproductcal)
                                    {
                                        if (count($listproductcal))
                                        {
                                            $newdoanhthu = 0;
                                            $newsoluong = 0;
                                            $newlaigop = 0;
                                            $newtraffic = 0;
                                            foreach ($listproductcal as $vcal)
                                            {
                                                $newdoanhthu += $vcal['doanhthu'];
                                                $newsoluong += $vcal['soluong'];
                                                $newlaigop += $vcal['laigop'];
                                                $newtraffic += $vcal['traffic'];
                                            }
                                            $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                            $newproductcal[] = $databydate;
                                            unset($newdoanhthu);
                                            unset($newsoluong);
                                            unset($newlaigop);
                                            unset($newtraffic);
                                            unset($databydate);
                                        }
                                    }
                                    if (empty($newproductcal)) continue;
                                    $sort = $newproductcal;
                                    usort($sort, 'sortdoanhthu');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_REVENUE, 'store' => $sid, 'category' => $catid, 'typevalue' => $dt), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortsoluong');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_VOLUME, 'store' => $sid, 'category' => $catid, 'typevalue' => $dt), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sortlaigop');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_PROFIT, 'store' => $sid, 'category' => $catid, 'typevalue' => $dt), $sort);

                                    unset($sort);
                                    $sort = $newproductcal;
                                    usort($sort, 'sorttraffic');
                                    $sort = array_slice($sort, 0, $limitsorttopitem);
                                    Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_DAY_TRAFFIC, 'store' => $sid, 'category' => $catid, 'typevalue' => $dt), $sort);
                                }
                            }
                        }
                    }
                }
            }
            //store theo tuan
            if (count($allcategoryproductbyweeks) > 0)
            {
                foreach ($allcategoryproductbyweeks as $catid => $listproductweek)
                {
                    foreach ($listproductweek as $year => $productbyweeks)
                    {
                        if (count($productbyweeks) == 0) continue;
                        foreach ($productbyweeks as $week => $productstores)
                        {
                            if (count($productstores) > 0)
                            {
                                foreach ($productstores as $sid => $productcal)
                                {
                                    if (count($productcal) > 0)
                                    {
                                        $newproductcal = array();
                                        foreach ($productcal as $pid=>$listproductcal)
                                        {
                                            if (count($listproductcal))
                                            {
                                                $newdoanhthu = 0;
                                                $newsoluong = 0;
                                                $newlaigop = 0;
                                                $newtraffic = 0;
                                                foreach ($listproductcal as $vcal)
                                                {
                                                    $newdoanhthu += $vcal['doanhthu'];
                                                    $newsoluong += $vcal['soluong'];
                                                    $newlaigop += $vcal['laigop'];
                                                    $newtraffic += $vcal['traffic'];
                                                }
                                                $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                                $newproductcal[] = $databydate;
                                                unset($newdoanhthu);
                                                unset($newsoluong);
                                                unset($newlaigop);
                                                unset($newtraffic);
                                                unset($databydate);
                                            }
                                        }
                                        if (empty($newproductcal)) continue;
                                        $sort = $newproductcal;
                                        usort($sort, 'sortdoanhthu');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_REVENUE, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.$week), $sort);

                                        unset($sort);
                                        $sort = $newproductcal;
                                        usort($sort, 'sortsoluong');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_VOLUME, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.$week), $sort);

                                        unset($sort);
                                        $sort = $newproductcal;
                                        usort($sort, 'sortlaigop');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_PROFIT, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.$week), $sort);

                                        unset($sort);
                                        $sort = $newproductcal;
                                        usort($sort, 'sorttraffic');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_WEEK_TRAFFIC, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.$week), $sort);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //store theo thang
            if (count($allcategoryproductbymonths) > 0)
            {
                foreach ($allcategoryproductbymonths as $catid => $listproductmonth)
                {
                    foreach ($listproductmonth as $year => $productbymonths)
                    {
                        if (count($productbymonths) == 0) continue;
                        foreach ($productbymonths as $month => $productstores)
                        {
                            if (count($productstores) > 0)
                            {
                                foreach ($productstores as $sid => $productcal)
                                {
                                    if (count($productcal) > 0)
                                    {
                                        $newproductcal = array();
                                        foreach ($productcal as $pid=>$listproductcal)
                                        {
                                            if (count($listproductcal))
                                            {
                                                $newdoanhthu = 0;
                                                $newsoluong = 0;
                                                $newlaigop = 0;
                                                $newtraffic = 0;
                                                foreach ($listproductcal as $vcal)
                                                {
                                                    $newdoanhthu += $vcal['doanhthu'];
                                                    $newsoluong += $vcal['soluong'];
                                                    $newlaigop += $vcal['laigop'];
                                                    $newtraffic += $vcal['traffic'];
                                                }
                                                $databydate = array('pid' => $pid, 'doanhthu' => $newdoanhthu, 'soluong' => $newsoluong, 'laigop' => $newlaigop, 'traffic' => $newtraffic);
                                                $newproductcal[] = $databydate;
                                                unset($newdoanhthu);
                                                unset($newsoluong);
                                                unset($newlaigop);
                                                unset($newtraffic);
                                                unset($databydate);
                                            }
                                        }
                                        if (empty($newproductcal)) continue;
                                        $sort = $newproductcal;
                                        usort($sort, 'sortdoanhthu');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_REVENUE, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                        unset($sort);
                                        $sort = $newproductcal;
                                        usort($sort, 'sortsoluong');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_VOLUME, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                        unset($sort);
                                        $sort = $newproductcal;
                                        usort($sort, 'sortlaigop');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_PROFIT, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);

                                        unset($sort);
                                        $sort = $newproductcal;
                                        usort($sort, 'sorttraffic');
                                        $sort = array_slice($sort, 0, $limitsorttopitem);
                                        Core_Stat::setcachetopitem(array('type' => Core_Stat::TOPITEM_MONTH_TRAFFIC, 'store' => $sid, 'category' => $catid, 'typevalue' => $year.sprintf('%02d', $month)), $sort);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //------------------END THEO CATEGORY--------------------

        $timer->stop();
        echo $timer->get_exec_time().'<br />';
    }

    private function _cachetopitemprocessingproductid($catid, $pids, $startdate, $enddate, &$allproductbyday, &$allproductbyweek, &$allproductbymonth, &$allcategoryproductbyday, &$allcategoryproductbyweek, &$allcategoryproductbymonth, &$allproductbydays, &$allproductbyweeks, &$allproductbymonths, &$allcategoryproductbydays, &$allcategoryproductbyweeks, &$allcategoryproductbymonths )
    {
        //Tinh doanh thu
        $dataidlist = array('product' => $pids);
        $detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop', 'stonkho');
        $mastervalues = array();
        $listcaculate = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , strtotime('+1 day', $enddate) , strtotime(date('Y-m', $startdate).'-01'));
        $datalist = $listcaculate['data'][0];//list nhung product id o day
        if (!empty($datalist))
        {
            foreach ($datalist as $pid => $datedatalist)
            {
                //check again if product is main or color
                $myProduct = new Core_Product($pid, true);
                if ($myProduct->id > 0 && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN) {
                    $productcolorlist = $myProduct->getProductColor();
                    $databydate = array();
                    if (!empty($productcolorlist)) {
                        foreach ($productcolorlist as $newpid) {
                            if (!empty($datalist[$newpid])) {
                                $newdatedatalist = $datalist[$newpid];
                                foreach ($newdatedatalist as $dt => $listdata) {
                                    if (empty($databydate[$dt]['doanhthu'])) {
                                        $databydate[$dt]['doanhthu'] = 0;
                                    }
                                    if (empty($databydate[$dt]['soluong'])) {
                                        $databydate[$dt]['soluong'] = 0;
                                    }
                                    if (empty($databydate[$dt]['laigop'])) {
                                        $databydate[$dt]['laigop'] = 0;
                                    }
                                    if (empty($databydate[$dt]['traffic'])) {
                                        $databydate[$dt]['traffic'] = 0;
                                    }

                                    $databydate[$dt]['doanhthu'] += $listdata['doanhthuthucte'];
                                    $databydate[$dt]['soluong'] += $listdata['soluongthucban'];
                                    $databydate[$dt]['laigop'] += $listdata['laigop'];
                                    $databydate[$dt]['traffic'] += $listdata['soluotkhach'];
                                }
                            }
                        }
                    }
                    if (!empty($databydate)) {
                        foreach ($databydate as $dt => $newdatabydate) {
                            $newdatabydate['pid'] = $pid;
                            $catid = $myProduct->pcid;
                            $allproductbyday[date('Y-m-d', $dt)][$pid][]                = $newdatabydate;
                            $allproductbyweek[date('Y', $dt)][date('W', $dt)][$pid][]   = $newdatabydate;
                            $allproductbymonth[date('Y', $dt)][date('n', $dt)][$pid][]  = $newdatabydate;

                            $allcategoryproductbyday[$catid][date('Y-m-d', $dt)][$pid][]                = $newdatabydate;
                            $allcategoryproductbyweek[$catid][date('Y', $dt)][date('W', $dt)][$pid][]   = $newdatabydate;
                            $allcategoryproductbymonth[$catid][date('Y', $dt)][date('n', $dt)][$pid][]  = $newdatabydate;
                        }
                    }
                }
                else {
                    continue;
                }
            }

            unset($dt);
        }
        unset($dataidlist);
        unset($listcaculate);

        $storelistfromcache = Core_Store::getStoresFromCache(true);
        foreach ($storelistfromcache as $sid=>$sname)
        {
            $dataidlist = array('product' => $pids, 'groupstore' => 1, 'store' => $sid);

            $listcaculate = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , strtotime('+1 day', $enddate) , strtotime(date('Y-m', $startdate).'-01'));
            $datalist = $listcaculate['data'][$sid];//list nhung product id o day

            if (!empty($datalist))
            {
                foreach ($datalist as $pid => $datedatalist)
                {
                    //check again if product is main or color
                    $myProduct = new Core_Product($pid, true);
                    if ($myProduct->id > 0 && $myProduct->customizetype == Core_Product::CUSTOMIZETYPE_MAIN) {
                        $productcolorlist = $myProduct->getProductColor();
                        $databydate = array();
                        if (!empty($productcolorlist)) {
                            foreach ($productcolorlist as $newpid) {
                                if (!empty($datalist[$newpid])) {
                                    $newdatedatalist = $datalist[$newpid];
                                    foreach ($newdatedatalist as $dt => $listdata) {
                                        if (empty($databydate[$dt]['doanhthu'])) {
                                            $databydate[$dt]['doanhthu'] = 0;
                                        }
                                        if (empty($databydate[$dt]['soluong'])) {
                                            $databydate[$dt]['soluong'] = 0;
                                        }
                                        if (empty($databydate[$dt]['laigop'])) {
                                            $databydate[$dt]['laigop'] = 0;
                                        }
                                        if (empty($databydate[$dt]['traffic'])) {
                                            $databydate[$dt]['traffic'] = 0;
                                        }

                                        $databydate[$dt]['doanhthu'] += $listdata['doanhthuthucte'];
                                        $databydate[$dt]['soluong'] += $listdata['soluongthucban'];
                                        $databydate[$dt]['laigop'] += $listdata['laigop'];
                                        $databydate[$dt]['traffic'] += $listdata['soluotkhach'];
                                    }
                                }
                            }
                        }
                        if (!empty($databydate)) {
                            foreach ($databydate as $dt => $newdatabydate) {
                                $newdatabydate['pid'] = $pid;
                                $catid = $myProduct->pcid;
                                $allproductbyday[date('Y-m-d', $dt)][$sid][$pid][]              = $newdatabydate;
                                $allproductbyweek[date('Y', $dt)][date('W', $dt)][$sid][$pid][]     = $newdatabydate;
                                $allproductbymonth[date('Y', $dt)][date('n', $dt)][$sid][$pid][]    = $newdatabydate;

                                $allcategoryproductbyday[$catid][date('Y-m-d', $dt)][$sid][$pid][]              = $newdatabydate;
                                $allcategoryproductbyweek[$catid][date('Y', $dt)][date('W', $dt)][$sid][$pid][]     = $newdatabydate;
                                $allcategoryproductbymonth[$catid][date('Y', $dt)][date('n', $dt)][$sid][$pid][]    = $newdatabydate;
                            }
                        }
                        unset($dt);
                    }
                    else {
                        continue;
                    }
                }

            }
        }
    }
    //-------------------END CACHE THEO NGAY, THEO TUAN, THEO THANG-------------------------------------------------------


    //---CACHE RANKING-----------------------------------------------------------------------------------------------------
    /**
     * [cacheproductrankingAction description]
     * @return [type] [description]
     */
    public function cacheproductrankingAction()
    {
        global $conf;
        set_time_limit(0);
        $timer = new Timer();

        $timer->start();
        ///////////////////////////////////////////
        $startdate = strtotime(date('Y' , time()) .'/'. (date('m' , time()) - 1) . '/01');
        $enddate = strtotime('+1 month' , $startdate);
        $enddate -= 24*3600;
        //////////////////////////////////////////
        $myCacher = new Cacher('' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

        $categorylisttree = array();
        Core_Productcategory::getCategoryIdTree($categorylisttree);

        foreach($categorylisttree as $catid => $datavalue)
        {
            $datalist = array();

            $doanhthulist = array();
            $soluonglist = array();
            $laigoplist = array();

            $sdoanhthu = 0;
            $ssoluong = 0;
            $slaigop = 0;

            //CHECK CATEGORY HAVE PRODUCT
            $productlist = Core_Product::getProducts(array(
                                                        'fpcid' => $catid,
                                                        'fonsitestatus' => Core_Product::OS_ERP,
                                                        'fstatus' => Core_Product::STATUS_ENABLE,
                                                        ) , 'id' , 'ASC' , '');
            if(count($productlist) > 0)
            {
                $productidlists = array();
                foreach($productlist as $product)
                {
                    $productcolors = $product->getProductColor();
                    if (!empty($productcolors))
                    {
                        foreach ($productcolors as $pidcolor)
                        {
                            if (!in_array($pidcolor, $productidlists))
                            {
                                $productidlists[] = $pidcolor;
                            }
                        }
                    }

                }
                if (count($productidlists) > 0)
                {
                    $dataidlist = array('product' => $productidlists);

                    $detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop');
                    $mastervalues = array();

                    $data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , strtotime('+1 day', $enddate) , $begindate);
                    $datalistcal = $data['data'][0];
                    if (!empty($datalistcal))
                    {
                        foreach ($datalistcal as $pid => $datedatalist)
                        {
                            foreach ($datedatalist as $dtdate=>$listdata)
                            {
                                if (!empty($doanhthulist[$pid])) $doanhthulist[$pid] += $listdata['doanhthuthucte'];
                                else $doanhthulist[$pid] = $listdata['doanhthuthucte'];

                                if (!empty($soluonglist[$pid])) $soluonglist[$pid] += $listdata['soluongthucban'];
                                else $soluonglist[$pid] = $listdata['soluongthucban'];

                                if (!empty($laigoplist[$pid])) $laigoplist[$pid] += $listdata['laigop'];
                                else $laigoplist[$pid] = $listdata['laigop'];

                                //summary info
                                $sdoanhthu += $listdata['doanhthuthucte'];
                                $ssoluong += $listdata['soluongthucban'];
                                $slaigop += $listdata['laigop'];
                            }
                        }
                    }

                }
                ////////////SORT DATA
                arsort($doanhthulist); //sort doanh thu
                arsort($soluonglist); //sort so luong
                arsort($laigoplist); //sort lai gop

                //////////////////////CACULATE RANKING AND GROUP OF PRODUCT
                $v80numbervolume = ceil($ssoluong * 80 /100); // 80% of volume
                $v80numberrevenue = ceil($sdoanhthu * 80 / 100); // 80% of revenue
                $v80numberprofit = ceil($slaigop * 80 /100); //80% of profit

                $v80conditionvolume = 0;
                $v80conditionrevenue = 0;
                $v80conditionprofit = 0;

                $i = 1;
                foreach ($soluonglist as $pid => $soluong)
                {
                    $datalist[$catid][$pid]['ranking'] .= 'V' . $i;

                    $v80conditionvolume += $soluong;
                    if($v80conditionvolume <= $v80numbervolume)
                    {
                        $datalist[$catid][$pid]['group'] .= 'V80';
                    }
                    else
                    {
                        $datalist[$catid][$pid]['group'] .= 'V20';
                    }

                    $i++;
                }

                $i = 0;
                foreach ($doanhthulist as $pid => $doanhthu)
                {
                    $datalist[$catid][$pid]['ranking'] .= ' , R' . $i;

                    $v80conditionrevenue += $doanhthu;
                    if($v80conditionrevenue <= $v80numberrevenue)
                    {
                        $datalist[$catid][$pid]['group'] .= ' , R80';
                    }
                    else
                    {
                        $datalist[$catid][$pid]['group'] .= ' , R20';
                    }
                    $i++;
                }

                $i = 0;
                foreach ($laigoplist as $pid => $laigop)
                {
                    $datalist[$catid][$pid]['ranking'] .= ' , P' . $i;

                    $v80conditionprofit += $laigop;
                    if($v80conditionprofit <=  $v80numberprofit)
                    {
                        $datalist[$catid][$pid]['group'] .= ' , P80';
                    }
                    else
                    {
                        $datalist[$catid][$pid]['group'] .= ' , V20';
                    }
                    $i++;
                }

                $myCacher->key = 'grlist_' . $catid;
                $data = json_encode($datalist);
                $myCacher->set($data);
            }
        }

        $timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';
    }
    //---ENĐ CACHE RANKING-------------------------------------------------------------------------------------------------

    //-----cache so lieu de ve bieu do tron cho brand va phan khuc gia----------------------------------------------------


    public function cachepricesegmentAction()
    {
        set_time_limit(0);
        $timer = new timer();
        $timer->start();

        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));
        //$enddate = strtotime(date('Y-m-d 23:59:59', $enddate));
        //$enddate = strtotime('+1 day', $enddate);

        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $productVendorList          = Core_ProductAttributeFilter::getProductByPriceSegmentFromCache(0,0,true);
        //echodebug($productVendorList[44], true);
        if (!empty($productVendorList))
        {
            $inoutstoretype = array();
            $arrparentCategory = array();
            //$listcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate);
            $isbreak = 0;
            foreach ($productVendorList as $catid => $listvendorproduct)
            {
                /*$listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);

                $parentCategory = 0;
                if (!empty($listcate))
                {
                    foreach ($listcate as $pcatid => $pcatename)
                    {
                        $parentCategory = $pcatid;
                        break;
                    }
                }
                else $parentCategory = $catid;
                */
                $listdiffproduct = array();
                //if (!empty($listcategoryfromcache[$catid])) $listdiffproduct = $listcategoryfromcache[$catid];
                //else continue;

                $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);
                foreach ($listvendorproduct as $slug=>$productlist)
                {
                    $customslug = str_replace('-', '', $slug);
                    $arralltypeofvalues = array();
                    $arrnumofskus = array();

                    $conditionvol = array();

                    $conditionvol['products'] = $productlist;

                    $getdatalistalltypes = Core_Stat::getDataList($joinarraytypes, $conditionvol, $startdate, $enddate );
                    if (!empty($getdatalistalltypes))
                    {
                        foreach ($getdatalistalltypes as $pidkey => $listproductids)
                        {
                            if (!empty($listproductids))
                            {
                                foreach ($listproductids as $typekey => $listdatevalues)
                                {
                                    if (!empty($listdatevalues))
                                    {
                                        foreach ($listdatevalues as $datetime => $valueitem)
                                        {
                                            $arrnumofskus[$datetime][0][$pidkey] = 1;
                                            if (!empty($valueitem))
                                            {
                                                if (!empty($arralltypeofvalues[$typekey][0][$datetime])) $arralltypeofvalues[$typekey][0][$datetime] += $valueitem;
                                                else $arralltypeofvalues[$typekey][0][$datetime] = $valueitem;

                                                /*if (!empty($arrparentCategory[$parentCategory][$customslug][$typekey][0][$datetime])) $arrparentCategory[$parentCategory][$customslug][$typekey][0][$datetime] += $valueitem;
                                                else $arrparentCategory[$parentCategory][$customslug][$typekey][0][$datetime] = $valueitem; */
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    unset($getdatalistalltypes);

                    foreach ($storelistfromcache as $sid=>$sname)
                    {
                        $conditionvol = array();
                        $conditionvolreturn = array();

                        $conditionvol['products'] = $productlist;
                        $conditionvolreturn['products'] = $productlist;
                        $conditionvol['outputstore'] = $sid;
                        $conditionvolreturn['inputstore'] = $sid;

                        $getdatalistalltypes = Core_Stat::getDataList($this->arrtypes, $conditionvol, $startdate, $enddate );

                        if (!empty($getdatalistalltypes))
                        {
                            foreach ($getdatalistalltypes as $pidkey => $listproductids)
                            {
                                if (!empty($listproductids))
                                {
                                    foreach ($listproductids as $typekey => $listdatevalues)
                                    {
                                        if (!empty($listdatevalues))
                                        {
                                            foreach ($listdatevalues as $datetime => $valueitem)
                                            {
                                                $arrnumofskus[$datetime][$sid][$pidkey] = 1;
                                                if (!empty($valueitem))
                                                {
                                                    if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                    else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;

                                                    /*if (!empty($arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] += $valueitem;
                                                    else $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] = $valueitem;
                                                    */
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $getdatalistalltypesrefund = Core_Stat::getDataList($this->arrtypesrefund, $conditionvolreturn, $startdate, $enddate );

                        if (!empty($getdatalistalltypesrefund))
                        {
                            foreach ($getdatalistalltypesrefund as $pidkey => $listproductids)
                            {
                                if (!empty($listproductids))
                                {
                                    foreach ($listproductids as $typekey => $listdatevalues)
                                    {
                                        if (!empty($listdatevalues))
                                        {
                                            foreach ($listdatevalues as $datetime => $valueitem)
                                            {
                                                $arrnumofskus[$datetime][$sid][$pidkey] = 1;
                                                if (!empty($valueitem))
                                                {
                                                    if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                    else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;

                                                    /*if (!empty($arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] += $valueitem;
                                                    else $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] = $valueitem;
                                                    */
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (!empty($arrnumofskus)) {
                        foreach ($arrnumofskus as $dtimesku=>$liststoresku) {
                            foreach ($liststoresku as $sid=>$numproducts) {
                                $valueofskus = json_encode(array_keys($numproducts));
                                $valueofskus = str_replace(',', '#', $valueofskus);
                                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('outputstore' => $sid, 'category' => $catid, 'pricesegment'=> $customslug), $dtimesku, (string)$valueofskus);
                            }
                            unset($sid);
                        }
                    }
                    unset($arrnumofskus);

                    if (!empty($arralltypeofvalues))
                    {
                        foreach ($arralltypeofvalues as $typekeys => $liststoredata)
                        {
                            //truong hop tong the khong co kho
                            if (!empty($liststoredata[0]))
                            {
                                $condition = array('category' => $catid, 'pricesegment'=> $customslug);
                                $dtwhile = $startdate;
                                while($dtwhile <= $enddate)
                                {
                                    $dttime = date('Y/m/d', $dtwhile);
                                    $valuebydate = 0;
                                    if (!empty($liststoredata[0][$dttime]))
                                    {
                                        $valuebydate = $liststoredata[0][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                    unset($valuebydate);
                                }
                                unset($condition);
                                unset($dtwhile);
                            }
                            foreach ($storelistfromcache as $sid=>$sname)
                            {
                                $listdatedata = array();
                                if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                                $condition = array('category' => $catid, 'pricesegment'=> $customslug);
                                if (in_array($typekeys, $this->arrtypes))
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                else
                                {
                                    $condition['inputstore'] = $sid;
                                }

                                $dtwhile = $startdate;
                                while($dtwhile <= $enddate)
                                {
                                    $dttime = date('Y/m/d', $dtwhile);
                                    $valuebydate = 0;
                                    if (!empty($listdatedata[$dttime]))
                                    {
                                        $valuebydate = $listdatedata[$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }
                    }
                }

                //$isbreak++;
                //if ($isbreak >3) break;
            }
            /*echodebug($arrparentCategory, true);

            unset($arralltypeofvalues);
            if (!empty($arrparentCategory))
            {
                foreach ($arrparentCategory as $parentcatid => $listvendorvalue)
                {
                    if (!empty($listvendorvalue))
                    {
                        foreach ($listvendorvalue as $customslug => $listkeysavecache)
                        {
                            if (!empty($listkeysavecache))
                            {
                                foreach ($listkeysavecache as $typekeys => $liststoredata)
                                {
                                    //truong hop tong the khong co kho
                                    if (!empty($liststoredata[0]))
                                    {
                                        $condition = array('category' => $parentcatid, 'pricesegment'=> $customslug);
                                        $dtwhile = $startdate;
                                        while($dtwhile <= $enddate)
                                        {
                                            $dttime = date('Y/m/d', $dtwhile);
                                            $valuebydate = 0;
                                            if (!empty($liststoredata[0][$dttime]))
                                            {
                                                $valuebydate = $liststoredata[0][$dttime];
                                            }
                                            Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                            $dtwhile = strtotime('+1 day', $dtwhile);
                                            unset($valuebydate);
                                        }
                                        unset($condition);
                                        unset($dtwhile);
                                    }
                                    foreach ($storelistfromcache as $sid=>$sname)//foreach ($liststoredata as $sid => $listdatedata)
                                    {
                                        $listdatedata = array();
                                        if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                                        $condition = array('category' => $parentcatid, 'pricesegment'=> $customslug);
                                        if ($sid >0)
                                        {
                                            if (in_array($typekeys, $this->arrtypes))
                                            {
                                                $condition['outputstore'] = $sid;
                                            }
                                            else
                                            {
                                                $condition['inputstore'] = $sid;
                                            }
                                        }

                                        $dtwhile = $startdate;
                                        while($dtwhile <= $enddate)
                                        {
                                            $dttime = date('Y/m/d', $dtwhile);
                                            $valuebydate = 0;
                                            if (!empty($listdatedata[$dttime]))
                                            {
                                                $valuebydate = $listdatedata[$dttime];
                                            }
                                            Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                            $dtwhile = strtotime('+1 day', $dtwhile);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            */
        }

        $this->clearcachehtml();
        $timer->stop();
        echo $timer->get_exec_time().'<br />';
    }

    public function cachebrandnameAction()
    {
        set_time_limit(0);
        $timer = new timer();
        $timer->start();

        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        $enddate = strtotime('+1 day', $enddate);

        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $productVendorList          = Core_Vendor::getProductVendorFromCache(0,0,true);

        if (!empty($productVendorList))
        {
            $arrparentCategory = array();
            $inoutstoretype = array();
            $listcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate);
            $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);

            $productcategorylist = Core_Productcategory::getProductcategoryListFromCache();

            foreach ($productVendorList as $catid => $listvendorproduct)
            {
                /*$listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);

                $parentCategory = 0;
                if (!empty($listcate))
                {
                    foreach ($listcate as $pcatid => $pcatename)
                    {
                        $parentCategory = $pcatid;
                        break;
                    }
                }
                else $parentCategory = $catid;
                unset($listcate);*/

                foreach ($listvendorproduct as $vid=>$productlist)
                {
                    $arralltypeofvalues = array();
                    $arrnumofskus = array();
                    $conditionvol = array();
                    $conditionvol['products'] = $productlist;

                    $getdatalistalltypes = Core_Stat::getDataList($joinarraytypes, $conditionvol, $startdate, $enddate );
                    if (!empty($getdatalistalltypes))
                    {
                        foreach ($getdatalistalltypes as $pidkey => $listproductids)
                        {
                            if (!empty($listproductids))
                            {
                                foreach ($listproductids as $typekey => $listdatevalues)
                                {
                                    if (!empty($listdatevalues))
                                    {
                                        foreach ($listdatevalues as $datetime => $valueitem)
                                        {
                                            $arrnumofskus[$datetime][0][$pidkey] = 1;
                                            if (!empty($valueitem))
                                            {
                                                if (!empty($arralltypeofvalues[$typekey][0][$datetime])) $arralltypeofvalues[$typekey][0][$datetime] += $valueitem;
                                                else $arralltypeofvalues[$typekey][0][$datetime] = $valueitem;

                                                /*if (!empty($arrparentCategory[$parentCategory][$vid][$typekey][0][$datetime])) $arrparentCategory[$parentCategory][$vid][$typekey][0][$datetime] += $valueitem;
                                                else $arrparentCategory[$parentCategory][$vid][$typekey][0][$datetime] = $valueitem;*/
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    unset($getdatalistalltypes);
                    foreach ($storelistfromcache as $sid=>$sname)
                    {
                        $conditionvol = array();
                        $conditionvolreturn = array();

                        $conditionvol['products'] = $productlist;
                        $conditionvolreturn['products'] = $productlist;
                        $conditionvol['outputstore'] = $sid;
                        $conditionvolreturn['inputstore'] = $sid;

                        $getdatalistalltypes = Core_Stat::getDataList($this->arrtypes, $conditionvol, $startdate, $enddate );

                        if (!empty($getdatalistalltypes))
                        {
                            foreach ($getdatalistalltypes as $pidkey => $listproductids)
                            {
                                if (!empty($listproductids))
                                {
                                    foreach ($listproductids as $typekey => $listdatevalues)
                                    {
                                        if (!empty($listdatevalues))
                                        {
                                            foreach ($listdatevalues as $datetime => $valueitem)
                                            {
                                                $arrnumofskus[$datetime][$sid][$pidkey] = 1;
                                                if (!empty($valueitem))
                                                {
                                                    if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                    else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;

                                                    /*if (!empty($arrparentCategory[$parentCategory][$vid][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$vid][$typekey][$sid][$datetime] += $valueitem;
                                                    else $arrparentCategory[$parentCategory][$vid][$typekey][$sid][$datetime] = $valueitem; */
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $getdatalistalltypesrefund = Core_Stat::getDataList($this->arrtypesrefund, $conditionvolreturn, $startdate, $enddate );

                        if (!empty($getdatalistalltypesrefund))
                        {
                            foreach ($getdatalistalltypesrefund as $pidkey => $listproductids)
                            {
                                if (!empty($listproductids))
                                {
                                    foreach ($listproductids as $typekey => $listdatevalues)
                                    {
                                        if (!empty($listdatevalues))
                                        {
                                            foreach ($listdatevalues as $datetime => $valueitem)
                                            {
                                                if (!empty($valueitem))
                                                {
                                                    if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                    else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;

                                                    /*if (!empty($arrparentCategory[$parentCategory][$vid][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$vid][$typekey][$sid][$datetime] += $valueitem;
                                                    else $arrparentCategory[$parentCategory][$vid][$typekey][$sid][$datetime] = $valueitem;*/
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (!empty($arrnumofskus))
                    {
                        foreach ($arrnumofskus as $dtimesku=>$liststoresku)
                        {
                            foreach ($liststoresku as $sid=>$numproducts)
                            {
                                $valueofskus = json_encode(array_keys($numproducts));
                                $valueofskus = str_replace(',', '#', $valueofskus);
                                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('outputstore' => $sid, 'vendor'=> $vid, 'category' => $catid), $dtimesku, (string)$valueofskus);
                            }
                            unset($sid);
                        }
                    }
                    unset($arrnumofskus);

                    if (!empty($arralltypeofvalues))
                    {
                        foreach ($arralltypeofvalues as $typekeys => $liststoredata)
                        {
                            //truong hop tong the khong co kho
                            if (!empty($liststoredata[0]))
                            {
                                $condition = array('category' => $catid, 'vendor'=> $vid);
                                $dtwhile = $startdate;
                                while($dtwhile <= $enddate)
                                {
                                    $dttime = date('Y/m/d', $dtwhile);
                                    $valuebydate = 0;
                                    if (!empty($liststoredata[0][$dttime]))
                                    {
                                        $valuebydate = $liststoredata[0][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                    unset($valuebydate);
                                }
                                unset($condition);
                                unset($dtwhile);
                            }
                            foreach ($storelistfromcache as $sid=>$sname)
                            {
                                $listdatedata = array();
                                if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                                $condition = array('category' => $catid, 'vendor'=> $vid);
                                if ($sid >0)
                                {
                                    if (in_array($typekeys, $this->arrtypes))
                                    {
                                        $condition['outputstore'] = $sid;
                                    }
                                    else
                                    {
                                        $condition['inputstore'] = $sid;
                                    }
                                }

                                $dtwhile = $startdate;
                                while($dtwhile <= $enddate)
                                {
                                    $dttime = date('Y/m/d', $dtwhile);
                                    $valuebydate = 0;
                                    if (!empty($listdatedata[$dttime]))
                                    {
                                        $valuebydate = $listdatedata[$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }
                    }
                }
            }
            /*
            unset($arralltypeofvalues);
            if (!empty($arrparentCategory))
            {
                foreach ($arrparentCategory as $parentcatid => $listvendorvalue)
                {
                    if (!empty($listvendorvalue))
                    {
                        foreach ($listvendorvalue as $vid => $listkeysavecache)
                        {
                            if (!empty($listkeysavecache))
                            {
                                foreach ($listkeysavecache as $typekeys => $liststoredata)
                                {
                                    //truong hop tong the khong co kho
                                    if (!empty($liststoredata[0]))
                                    {
                                        $condition = array('category' => $parentcatid, 'vendor'=> $vid);
                                        $dtwhile = $startdate;
                                        while($dtwhile <= $enddate)
                                        {
                                            $dttime = date('Y/m/d', $dtwhile);
                                            $valuebydate = 0;
                                            if (!empty($liststoredata[0][$dttime]))
                                            {
                                                $valuebydate = $liststoredata[0][$dttime];
                                            }
                                            Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                            $dtwhile = strtotime('+1 day', $dtwhile);
                                            unset($valuebydate);
                                        }
                                        unset($condition);
                                        unset($dtwhile);
                                    }
                                    foreach ($storelistfromcache as $sid=>$sname)//foreach ($liststoredata as $sid => $listdatedata)
                                    {
                                        $listdatedata = array();
                                        if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                                        $condition = array('category' => $parentcatid, 'vendor'=> $vid);
                                        if ($sid >0)
                                        {
                                            if (in_array($typekeys, $this->arrtypes))
                                            {
                                                $condition['outputstore'] = $sid;
                                            }
                                            else
                                            {
                                                $condition['inputstore'] = $sid;
                                            }
                                        }

                                        $dtwhile = $startdate;
                                        while($dtwhile <= $enddate)
                                        {
                                            $dttime = date('Y/m/d', $dtwhile);
                                            $valuebydate = 0;
                                            if (!empty($listdatedata[$dttime]))
                                            {
                                                $valuebydate = $listdatedata[$dttime];
                                            }
                                            Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                            $dtwhile = strtotime('+1 day', $dtwhile);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            */
        }

        $this->clearcachehtml();
        $timer->stop();
        echo $timer->get_exec_time().'<br />';
    }

    public function cachemaincharacterAction()
    {
        set_time_limit(0);
        $timer = new timer();
        $timer->start();

        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $productVendorList          = Core_ProductAttributeFilter::getProductByMainCharacterFromCache(0,0,true);
        //echodebug($productVendorList, true);

        if (!empty($productVendorList))
        {
            $inoutstoretype = array();
            //$listcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate);
            foreach ($productVendorList as $catid => $listvendorproduct)
            {
                /*$listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);

                $parentCategory = 0;
                if (!empty($listcate))
                {
                    foreach ($listcate as $pcatid => $pcatename)
                    {
                        $parentCategory = $pcatid;
                        break;
                    }
                }
                else $parentCategory = $catid;
                unset($listcate);
                */
                $listdiffproduct = array();
                //if (!empty($listcategoryfromcache[$catid])) $listdiffproduct = $listcategoryfromcache[$catid];
                //else continue;

                $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);
                foreach ($listvendorproduct as $slug=>$productlist)
                {
                    $customslug = str_replace('-', '', $slug);
                    $arralltypeofvalues = array();
                    $arrnumofskus = array();

                    $conditionvol = array();

                    $conditionvol['products'] = $productlist;

                    $getdatalistalltypes = Core_Stat::getDataList($joinarraytypes, $conditionvol, $startdate, $enddate );
                    if (!empty($getdatalistalltypes))
                    {
                        foreach ($getdatalistalltypes as $pidkey => $listproductids)
                        {
                            if (!empty($listproductids))
                            {
                                foreach ($listproductids as $typekey => $listdatevalues)
                                {
                                    if (!empty($listdatevalues))
                                    {
                                        foreach ($listdatevalues as $datetime => $valueitem)
                                        {
                                            $arrnumofskus[$datetime][0][$pidkey] = 1;
                                            if (!empty($valueitem))
                                            {
                                                if (!empty($arralltypeofvalues[$typekey][0][$datetime])) $arralltypeofvalues[$typekey][0][$datetime] += $valueitem;
                                                else $arralltypeofvalues[$typekey][0][$datetime] = $valueitem;
                                                /*$sid = 0;
                                                if (!empty($arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] += $valueitem;
                                                else $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] = $valueitem;
                                                unset($sid);*/
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    unset($getdatalistalltypes);
                    foreach ($storelistfromcache as $sid=>$sname)
                    {
                        $conditionvol = array();
                        $conditionvolreturn = array();

                        $conditionvol['products'] = $productlist;
                        $conditionvolreturn['products'] = $productlist;
                        $conditionvol['outputstore'] = $sid;
                        $conditionvolreturn['inputstore'] = $sid;

                        $getdatalistalltypes = Core_Stat::getDataList($this->arrtypes, $conditionvol, $startdate, $enddate );

                        if (!empty($getdatalistalltypes))
                        {
                            foreach ($getdatalistalltypes as $pidkey => $listproductids)
                            {
                                if (!empty($listproductids))
                                {
                                    foreach ($listproductids as $typekey => $listdatevalues)
                                    {
                                        if (!empty($listdatevalues))
                                        {
                                            foreach ($listdatevalues as $datetime => $valueitem)
                                            {
                                                $arrnumofskus[$datetime][$sid][$pidkey] = 1;
                                                if (!empty($valueitem))
                                                {
                                                    if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                    else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;

                                                    /*if (!empty($arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] += $valueitem;
                                                    else $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] = $valueitem;*/
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $getdatalistalltypesrefund = Core_Stat::getDataList($this->arrtypesrefund, $conditionvolreturn, $startdate, $enddate );

                        if (!empty($getdatalistalltypesrefund))
                        {
                            foreach ($getdatalistalltypesrefund as $pidkey => $listproductids)
                            {
                                if (!empty($listproductids))
                                {
                                    foreach ($listproductids as $typekey => $listdatevalues)
                                    {
                                        if (!empty($listdatevalues))
                                        {
                                            foreach ($listdatevalues as $datetime => $valueitem)
                                            {
                                                $arrnumofskus[$datetime][$sid][$pidkey] = 1;
                                                if (!empty($valueitem))
                                                {
                                                    if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                    else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;

                                                    /*if (!empty($arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime])) $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] += $valueitem;
                                                    else $arrparentCategory[$parentCategory][$customslug][$typekey][$sid][$datetime] = $valueitem;*/
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (!empty($arrnumofskus))
                    {
                        foreach ($arrnumofskus as $dtimesku=>$liststoresku)
                        {
                            foreach ($liststoresku as $sid=>$numproducts)
                            {
                                $valueofskus = json_encode(array_keys($numproducts));
                                $valueofskus = str_replace(',', '#', $valueofskus);
                                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_NUMBER_OF_PRODUCT, array('outputstore' => $sid, 'character'=> $customslug, 'category' => $catid), $dtimesku, (string)$valueofskus);
                            }
                            unset($sid);
                        }
                    }
                    unset($arrnumofskus);

                    if (!empty($arralltypeofvalues))
                    {
                        foreach ($arralltypeofvalues as $typekeys => $liststoredata)
                        {
                            //truong hop tong the khong co kho
                            if (!empty($liststoredata[0]))
                            {
                                $condition = array('category' => $catid, 'character'=> $customslug);
                                $dtwhile = $startdate;
                                while($dtwhile <= $enddate)
                                {
                                    $dttime = date('Y/m/d', $dtwhile);
                                    $valuebydate = 0;
                                    if (!empty($liststoredata[0][$dttime]))
                                    {
                                        $valuebydate = $liststoredata[0][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                    unset($valuebydate);
                                }
                                unset($condition);
                                unset($dtwhile);
                            }

                            foreach ($storelistfromcache as $sid=>$sname)
                            {
                                $listdatedata = array();
                                if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                                $condition = array('category' => $catid, 'character'=> $customslug);
                                if ($sid >0)
                                {
                                    if (in_array($typekeys, $this->arrtypes))
                                    {
                                        $condition['outputstore'] = $sid;
                                    }
                                    else
                                    {
                                        $condition['inputstore'] = $sid;
                                    }
                                }

                                $dtwhile = $startdate;
                                while($dtwhile <= $enddate)
                                {
                                    $dttime = date('Y/m/d', $dtwhile);
                                    $valuebydate = 0;
                                    if (!empty($listdatedata[$dttime]))
                                    {
                                        $valuebydate = $listdatedata[$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }
                    }
                }
            }
            /*
            unset($arralltypeofvalues);
            if (!empty($arrparentCategory))
            {
                foreach ($arrparentCategory as $parentcatid => $listvendorvalue)
                {
                    if (!empty($listvendorvalue))
                    {
                        foreach ($listvendorvalue as $customslug => $listkeysavecache)
                        {
                            if (!empty($listkeysavecache))
                            {
                                foreach ($listkeysavecache as $typekeys => $liststoredata)
                                {
                                    //truong hop tong the khong co kho
                                    if (!empty($liststoredata[0]))
                                    {
                                        $condition = array('category' => $parentcatid, 'character'=> $customslug);
                                        $dtwhile = $startdate;
                                        while($dtwhile <= $enddate)
                                        {
                                            $dttime = date('Y/m/d', $dtwhile);
                                            $valuebydate = 0;
                                            if (!empty($liststoredata[0][$dttime]))
                                            {
                                                $valuebydate = $liststoredata[0][$dttime];
                                            }
                                            Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                            $dtwhile = strtotime('+1 day', $dtwhile);
                                            unset($valuebydate);
                                        }
                                        unset($condition);
                                        unset($dtwhile);
                                    }
                                    foreach ($storelistfromcache as $sid=>$sname)//foreach ($liststoredata as $sid => $listdatedata)
                                    {
                                        $listdatedata = array();
                                        if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                                        $condition = array('category' => $parentcatid, 'character'=> $customslug);
                                        if ($sid >0)
                                        {
                                            if (in_array($typekeys, $this->arrtypes))
                                            {
                                                $condition['outputstore'] = $sid;
                                            }
                                            else
                                            {
                                                $condition['inputstore'] = $sid;
                                            }
                                        }

                                        $dtwhile = $startdate;
                                        while($dtwhile <= $enddate)
                                        {
                                            $dttime = date('Y/m/d', $dtwhile);
                                            $valuebydate = 0;
                                            if (!empty($listdatedata[$dttime]))
                                            {
                                                $valuebydate = $listdatedata[$dttime];
                                            }
                                            Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                            $dtwhile = strtotime('+1 day', $dtwhile);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            */
        }

        $this->clearcachehtml();
        $timer->stop();
        echo $timer->get_exec_time().'<br />';
    }

    public function cachepricesegmentbrandmancharacterparentAction()
    {
        set_time_limit(0);
        $timer = new timer();
        $timer->start();

        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $arrParents = array();
        //Từ V1.1 pricesegment của ngành hàng cha riêng, ngành hàng con riêng
        /*
        $productVendorList          = Core_ProductAttributeFilter::getProductByPriceSegmentFromCache(0,0,true);

        foreach ($productVendorList as $catid => $listvendorproduct)
        {
            $listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);
            $parentCategory = array();
            if (!empty($listcate))
            {
                foreach ($listcate as $pcatid => $pcatename)
                {
                    $parentCategory[] = $pcatid;
                }
            }
            else $parentCategory[] = $catid;

            $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);
            foreach ($listvendorproduct as $customslug=>$productlist)
            {
                $slug = str_replace('-', '', $customslug);
                foreach ($joinarraytypes as $type)
                {
                    $listtypes = Core_Stat::getData($type, array('category' => $catid, 'pricesegment' => $slug), $startdate, $enddate );
                    if (!empty($listtypes))
                    {
                        foreach ($listtypes as $datetime=>$v)
                        {
                            if (!empty($v))
                            {
                                foreach ($parentCategory as $pcatid)
                                {
                                    if (!empty($arrParents['pricesegment'][$pcatid][$slug][$type][0][$datetime])) $arrParents['pricesegment'][$pcatid][$slug][$type][0][$datetime] += $v;
                                    else $arrParents['pricesegment'][$pcatid][$slug][$type][0][$datetime] = $v;
                                }
                            }
                        }
                    }
                    unset($listtypes);

                    foreach ($storelistfromcache as $sid=>$sname)
                    {
                        $conditionstore = array();
                        $conditionstore['category'] = $catid;
                        $conditionstore['pricesegment'] = $slug;
                        if (in_array($type, $this->arrtypes))
                        {
                            $conditionstore['outputstore'] = $sid;
                        }
                        else $conditionstore['inputstore'] = $sid;

                        $listtypes = Core_Stat::getData($type, $conditionstore, $startdate, $enddate );

                        if (!empty($listtypes))
                        {
                            foreach ($listtypes as $datetime=>$v)
                            {
                                if (!empty($v))
                                {
                                    foreach ($parentCategory as $pcatid)
                                    {
                                        if (!empty($arrParents['pricesegment'][$pcatid][$slug][$type][$sid][$datetime])) $arrParents['pricesegment'][$pcatid][$slug][$type][$sid][$datetime] += $v;
                                        else $arrParents['pricesegment'][$pcatid][$slug][$type][$sid][$datetime] = $v;
                                    }
                                }
                            }
                        }
                        unset($listtypes);
                    }

                }

            }
        }
        unset($productVendorList);
        */
        //----
        $productVendorList          = Core_ProductAttributeFilter::getProductByMainCharacterFromCache(0,0,true);

        foreach ($productVendorList as $catid => $listvendorproduct)
        {
            $listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);
            $parentCategory = array();
            if (!empty($listcate))
            {
                foreach ($listcate as $pcatid => $pcatename)
                {
                    $parentCategory[] = $pcatid;
                }
            }
            else $parentCategory[] = $catid;

            $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);
            foreach ($listvendorproduct as $customslug=>$productlist)
            {
                $slug = str_replace('-', '', $customslug);
                foreach ($joinarraytypes as $type)
                {
                    $listtypes = Core_Stat::getData($type, array('category' => $catid, 'character' => $slug), $startdate, $enddate );
                    if (!empty($listtypes))
                    {
                        foreach ($listtypes as $datetime=>$v)
                        {
                            if (!empty($v))
                            {
                                foreach ($parentCategory as $pcatid)
                                {
                                    if (!empty($arrParents['character'][$pcatid][$slug][$type][0][$datetime])) $arrParents['character'][$pcatid][$slug][$type][0][$datetime] += $v;
                                    else $arrParents['character'][$pcatid][$slug][$type][0][$datetime] = $v;
                                }
                            }
                        }
                    }
                    unset($listtypes);

                    foreach ($storelistfromcache as $sid=>$sname)
                    {
                        $conditionstore = array();
                        $conditionstore['category'] = $catid;
                        $conditionstore['character'] = $slug;
                        if (in_array($type, $this->arrtypes))
                        {
                            $conditionstore['outputstore'] = $sid;
                        }
                        else $conditionstore['inputstore'] = $sid;

                        $listtypes = Core_Stat::getData($type, $conditionstore, $startdate, $enddate );
                        if (!empty($listtypes))
                        {
                            foreach ($listtypes as $datetime=>$v)
                            {
                                if (!empty($v))
                                {
                                    foreach ($parentCategory as $pcatid)
                                    {
                                        if (!empty($arrParents['character'][$pcatid][$slug][$type][$sid][$datetime])) $arrParents['character'][$pcatid][$slug][$type][$sid][$datetime] += $v;
                                        else $arrParents['character'][$pcatid][$slug][$type][$sid][$datetime] = $v;
                                    }
                                }
                            }
                        }
                        unset($listtypes);
                    }
                }

            }
        }
        unset($productVendorList);
        //----

        $productVendorList          = Core_Vendor::getProductVendorFromCache(0,0,true);

        foreach ($productVendorList as $catid => $listvendorproduct)
        {
            $listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe($catid);
            $parentCategory = array();
            if (!empty($listcate))
            {
                foreach ($listcate as $pcatid => $pcatename)
                {
                    $parentCategory[] = $pcatid;
                }
            }
            else $parentCategory[] = $catid;

            $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);
            foreach ($listvendorproduct as $vid=>$productlist)
            {
                foreach ($joinarraytypes as $type)
                {
                    $listtypes = Core_Stat::getData($type, array('category' => $catid, 'vendor' => $vid), $startdate, $enddate );
                    if (!empty($listtypes))
                    {
                        foreach ($listtypes as $datetime=>$v)
                        {
                            if (!empty($v))
                            {
                                foreach ($parentCategory as $pcatid)
                                {
                                    if (!empty($arrParents['vendor'][$pcatid][$vid][$type][0][$datetime])) $arrParents['vendor'][$pcatid][$vid][$type][0][$datetime] += $v;
                                    else $arrParents['vendor'][$pcatid][$vid][$type][0][$datetime] = $v;
                                }
                            }
                        }
                    }
                    unset($listtypes);

                    foreach ($storelistfromcache as $sid=>$sname)
                    {
                        $conditionstore = array();
                        $conditionstore['category'] = $catid;
                        $conditionstore['vendor'] = $slug;
                        if (in_array($type, $this->arrtypes))
                        {
                            $conditionstore['outputstore'] = $sid;
                        }
                        else $conditionstore['inputstore'] = $sid;

                        $listtypes = Core_Stat::getData($type, $conditionstore, $startdate, $enddate );
                        if (!empty($listtypes))
                        {
                            foreach ($listtypes as $datetime=>$v)
                            {
                                if (!empty($v))
                                {
                                    foreach ($parentCategory as $pcatid)
                                    {
                                        if (!empty($arrParents['vendor'][$pcatid][$vid][$type][$sid][$datetime])) $arrParents['vendor'][$pcatid][$vid][$type][$sid][$datetime] += $v;
                                        else $arrParents['vendor'][$pcatid][$vid][$type][$sid][$datetime] = $v;
                                    }
                                }
                            }
                        }
                        unset($listtypes);
                    }
                }
            }
        }
        unset($productVendorList);
        //---------

        if (!empty($arrParents))
        {
            foreach ($arrParents as $keycondition => $listparentcategories)
            {
                //echo $keycondition.'---';
                foreach ($listparentcategories as $parentid => $listslugs)
                {
                    //echo $parentid.'---';
                    foreach ($listslugs as $valuecondtion => $liststype)
                    {
                        //echo $valuecondtion.'---';
                        foreach ($liststype as $type=>$liststores)
                        {
                            //echo $type.'---';
                            foreach ($liststores as $sid => $listdatetimes)
                            {
                                //echo $sid.'---';
                                $condtionspar = array('category' => $parentid, $keycondition => $valuecondtion);
                                if ($sid > 0)
                                {
                                    if (in_array($type, $this->arrtypes))
                                    {
                                        $condtionspar['outputstore'] = $sid;
                                    }
                                    else $condtionspar['inputstore'] = $sid;
                                }
                                foreach ($listdatetimes as $datetime => $valuebydate)
                                {
                                    //echo $datetime.'---'.$valuebydate;exit();
                                    Core_Stat::setDataSaleInDate($type, $condtionspar, $datetime, (string)$valuebydate);
                                    //echo '<br />--'.$type.'--'.$datetime.'--'.print_r($condtionspar, 1).'---'.$valuebydate;
                                }
                                unset($condtionspar);
                            }
                        }
                    }
                }
            }

        }
        unset($arrParents);

        $timer->stop();
        echo $timer->get_exec_time();
    }

    //-----END cache so lieu de ve bieu do tron cho brand va phan khuc gia va main character----------------------------------------------------

    private function clearcachehtml()
    {
        $cacheDir = SITE_PATH . 'uploads/cache/productcategory';

        $listfilecache = scandir($cacheDir);
        if(count($listfilecache) > 0)
        {
            foreach ($listfilecache as $filename)
            {
                if($filename != '.' && $filename != '..')
                {
                    //$myCache = new cache();
                    //$myCache = new cache($filename , $cacheDir);
                    if (file_exists($cacheDir.'/'.$filename))
                    {
                        unlink($cacheDir.'/'.$filename);
                    }
                }
            }
        }
        $cacheDir = SITE_PATH . 'uploads/cache/company';

        $listfilecache = scandir($cacheDir);
        if(count($listfilecache) > 0)
        {
            foreach ($listfilecache as $filename)
            {
                if($filename != '.' && $filename != '..')
                {
                    //$myCache = new cache();
                    //$myCache = new cache($filename , $cacheDir);
                    if (file_exists($cacheDir.'/'.$filename))
                    {
                        unlink($cacheDir.'/'.$filename);
                    }
                }
            }
        }
    }
//------------DO CACHE LAI THEO TUNG CATEGORY----------------------------------------
    public function cachecategorydataAction()
    {
        global $conf;
        //echodebug(Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('product' => 57426), strtotime('2013-09-01'), strtotime('2013-09-31') ), true);

        set_time_limit(0);
        $db3 = Core_Backend_Object::getDb();//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        if (!empty($_GET['isdeletecache']))
        {
            $songay = ceil(($enddate - $startdate)/86400);
            if ($songay >= 28 && date('Ym', $startdate) == date('Ym', $enddate))
            {
                $redis = new Redis();
                $redis->connect($conf['redis'][1]['ip'], $conf['redis'][1]['port']);

                $arr = $redis->keys(date('Ym', $startdate).':c*:*');
                $re  = $redis->delete($arr);
                unset($arr);
                unset($re);
            }
        }

        $starttime = time();
        $storelistfromcache = Core_Store::getStoresFromCache(false);

        $cateid = (int)(isset($_GET['pcid'])?$_GET['pcid']:0);
        $listcategoryfromcache = array();

        if ($cateid <= 0)
        {
            /*if (!isset($_GET['getdb']))
            {
                $listcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate);
            }

            if (empty($listcategoryfromcache))
            {
                //find all subcategory
                $this->registry->db = $this->getDb();
                $getallchildcategories = $this->registry->db->query('SELECT distinct pc_id FROM '.TABLE_PREFIX.'product');
                $allchildcategories = array();
                while($row = $getallchildcategories->fetch())
                {
                    $allchildcategories[] = $row['pc_id'];
                }
                foreach ($allchildcategories as $pcid)
                {Core_Productcategory::getProductlistFromCache();
                    $getproductlist = Core_Productcategory::getProductlistFromCache($pcid , array() , array());
                    $newgetproductlist = array();
                    if (!empty($getproductlist))
                    {
                        foreach ($getproductlist as $myProduct)
                        {
                            if (!empty($myProduct['color']))
                            {
                                foreach ($myProduct['color'] as $pidcolor)
                                {
                                    if (!in_array($pidcolor, $newgetproductlist)) $newgetproductlist[] = $pidcolor;
                                }
                            }
                        }
                        unset($getproductlist);
                    }
                    if (!empty($newgetproductlist)) $listcategoryfromcache[$pcid] = $newgetproductlist;
                    unset($newgetproductlist);
                }
                unset($pcid);
                unset($allchildcategories);
            }*/
            $listcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate);

            if (empty($listcategoryfromcache)) $listcategoryfromcache = Core_Productcategory::getProductlistFromCategory();
        }
        else
        {
            /*$getproductlist = Core_Productcategory::getProductlistFromCache($cateid , array() , array());
            $newgetproductlist = array();
            if (!empty($getproductlist))
            {
                foreach ($getproductlist as $myProduct)
                {
                    if (!empty($myProduct['color']))
                    {
                        foreach ($myProduct['color'] as $pidcolor)
                        {
                            if (!in_array($pidcolor, $newgetproductlist)) $newgetproductlist[] = $pidcolor;
                        }
                    }
                }
            }*/
            $alllistcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate, $cateid);
            if (!empty($alllistcategoryfromcache))
            {
                $listcategoryfromcache[$cateid] = $alllistcategoryfromcache;
            }
            else
            {
                $alllistcategoryfromcache = Core_Productcategory::getProductlistFromCategory();
                if (!empty($alllistcategoryfromcache[$cateid])) $listcategoryfromcache[$cateid] = $alllistcategoryfromcache[$cateid];
            }
        }
        if (!empty($listcategoryfromcache))
        {
            $joinarraytypes = array_merge($this->arrtypes, $this->arrtypesrefund);
            foreach ($listcategoryfromcache as $catid=>$productlist)
            {
                $arralltypeofvalues = array();
                $conditionvol = array();
                $conditionvol['products'] = $productlist;

                $getdatalistalltypes = Core_Stat::getDataList($joinarraytypes, $conditionvol, $startdate, $enddate );

                if (!empty($getdatalistalltypes))
                {
                    foreach ($getdatalistalltypes as $pidkey => $listproductids)
                    {
                        if (!empty($listproductids))
                        {
                            foreach ($listproductids as $typekey => $listdatevalues)
                            {
                                if (!empty($listdatevalues))
                                {
                                    foreach ($listdatevalues as $datetime => $valueitem)
                                    {
                                        if (!empty($valueitem))
                                        {
                                            if (!empty($arralltypeofvalues[$typekey][0][$datetime])) $arralltypeofvalues[$typekey][0][$datetime] += $valueitem;
                                            else $arralltypeofvalues[$typekey][0][$datetime] = $valueitem;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                unset($getdatalistalltypes);
                foreach ($storelistfromcache as $sid=>$sname)
                {
                    $conditionvol = array();
                    $conditionvolreturn = array();

                    $conditionvol['products'] = $productlist;
                    $conditionvolreturn['products'] = $productlist;
                    $conditionvol['outputstore'] = $sid;
                    $conditionvolreturn['inputstore'] = $sid;

                    $getdatalistalltypes = Core_Stat::getDataList($this->arrtypes, $conditionvol, $startdate, $enddate );
                    if (!empty($getdatalistalltypes))
                    {
                        foreach ($getdatalistalltypes as $pidkey => $listproductids)
                        {
                            if (!empty($listproductids))
                            {
                                foreach ($listproductids as $typekey => $listdatevalues)
                                {
                                    if (!empty($listdatevalues))
                                    {
                                        foreach ($listdatevalues as $datetime => $valueitem)
                                        {
                                            if (!empty($valueitem))
                                            {
                                                if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $getdatalistalltypesrefund = Core_Stat::getDataList($this->arrtypesrefund, $conditionvolreturn, $startdate, $enddate );

                    if (!empty($getdatalistalltypesrefund))
                    {
                        foreach ($getdatalistalltypesrefund as $pidkey => $listproductids)
                        {
                            if (!empty($listproductids))
                            {
                                foreach ($listproductids as $typekey => $listdatevalues)
                                {
                                    if (!empty($listdatevalues))
                                    {
                                        foreach ($listdatevalues as $datetime => $valueitem)
                                        {
                                            if (!empty($valueitem))
                                            {
                                                if (!empty($arralltypeofvalues[$typekey][$sid][$datetime])) $arralltypeofvalues[$typekey][$sid][$datetime] += $valueitem;
                                                else $arralltypeofvalues[$typekey][$sid][$datetime] = $valueitem;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if (!empty($arralltypeofvalues))
                {
                    foreach ($arralltypeofvalues as $typekeys => $liststoredata)
                    {
                    //truong hop tong the khong co kho
                        if (!empty($liststoredata[0]))
                        {
                            $condition = array('category' => $catid);
                            $dtwhile = $startdate;
                            while($dtwhile <= $enddate)
                            {
                                $dttime = date('Y/m/d', $dtwhile);
                                $valuebydate = 0;
                                if (!empty($liststoredata[0][$dttime]))
                                {
                                    $valuebydate = $liststoredata[0][$dttime];
                                }
                                Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                $dtwhile = strtotime('+1 day', $dtwhile);
                                unset($valuebydate);
                            }
                            unset($condition);
                            unset($dtwhile);
                        }

                        foreach ($storelistfromcache as $sid=>$sname)
                        {
                            $listdatedata = array();
                            if (!empty($liststoredata[$sid])) $listdatedata = $liststoredata[$sid];
                            $condition = array('category' => $catid);
                            if ($sid >0)
                            {
                                if (in_array($typekeys, $this->arrtypes))
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                else
                                {
                                    $condition['inputstore'] = $sid;
                                }
                            }

                            $dtwhile = $startdate;
                            while($dtwhile <= $enddate)
                            {
                                $dttime = date('Y/m/d', $dtwhile);
                                $valuebydate = 0;
                                if (!empty($listdatedata[$dttime]))
                                {
                                    $valuebydate = $listdatedata[$dttime];
                                }
                                Core_Stat::setDataSaleInDate($typekeys, $condition, $dttime, (string)$valuebydate);
                                $dtwhile = strtotime('+1 day', $dtwhile);
                            }
                        }
                    }
                }
            }
        }
        $this->clearcachehtml();
        echo '<p> Time: '.(time() - $starttime).'</p>';
    }
//------------END DO CACHE LAI THEO TUNG CATEGORY------------------------------------

//----------CACHE CATEGORY PARENT THEO TUNG CATEGORY CHILD---------------------------
    public function cachecategoryparentAction()
    {
        set_time_limit(0);
        $db3 = Core_Backend_Object::getDb();//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        //$startdate = strtotime(date('Y-m-d', $startdate));
        //$enddate = strtotime(date('Y-m-d 23:59:59', $enddate));
        //$enddate = strtotime('+1 day', $enddate);
        $starttime = time();

        $productcategorylist = Core_Productcategory::getProductcategoryListFromCache();
        $storelistfromcache = Core_Store::getStoresFromCache(false);
        /*foreach ($productcategorylist as $catid => $datavalue)
            {
                if(count($datavalue['parent']) == 0)
                {
                    echo '<p>-------------CATEGORY: '.$catid.'----------------------</p>';
                    echodebug($datavalue['parent']);
                    echodebug($datavalue['child']);
                }
            }exit('hee');*/
        $rootcategory = array();
        if(count($productcategorylist) > 0)
        {
            foreach ($productcategorylist as $catid => $datavalue)
            {
                if(count($datavalue['child']) > 0 && count($datavalue['parent']) > 0)
                {
                    $arrsoluongban = array();
                    $arrsoluongtralai = array();
                    $arrdoanhthu = array();
                    $arrdoanhthutralai = array();
                    $arrthanhtoan = array();
                    $arrthanhtoantralai = array();
                    $arrgiavonban = array();
                    $arrgiavontralai = array();
                    $arrgiatrihangkhuyenmai = array();
                    $arrtonkhodauky = array();
                    $arrsoluongnhapmuadauky = array();
                    $arrtrigianhapmuadauky = array();
                    $arrsoluongxuatbandauky = array();
                    $arrtrigiaxuatbandauky = array();
                    $arrnhapmua = array();
                    $arrnhapnoibo = array();
                    $arrnhaptralai = array();
                    $arrnhapkhac = array();
                    $arrxuatban = array();
                    $arrxuatnoibo = array();
                    $arrxuattramuahang = array();
                    $arrxuatkhac = array();
                    $arrtrigiatonkhodauky = array();
                    $arrtrigianhapmua = array();
                    $arrtrigianhapnoibo = array();
                    $arrtrigianhaptra = array();
                    $arrtrigianhapkhac = array();
                    $arrtrigiaxuatban = array();
                    $arrtrigiaxuatnoibo = array();
                    $arrtrigiaxuattra = array();
                    $arrtrigiaxuatkhac = array();
                    $arrsoluongdonhang = array();
                    $arrdiemchuan = array();
                    if (!empty($datavalue['child']))
                    {
                        foreach ($datavalue['child'] as $pcid)
                        {
                            $arrconditon = array('category' => $pcid);
                            $soluongban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongban))
                            {
                                foreach ($soluongban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongban[0][$datetime])) $arrsoluongban[0][$datetime] += $valuedate;
                                        else $arrsoluongban[0][$datetime] = $valuedate;
                                    }
                                }
                            }
                            $soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongtralai))
                            {
                                foreach ($soluongtralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongtralai[0][$datetime])) $arrsoluongtralai[0][$datetime] += $valuedate;
                                        else $arrsoluongtralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $arrconditon, $startdate, $enddate );

                            if (!empty($doanhthu))
                            {
                                foreach ($doanhthu as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrdoanhthu[0][$datetime])) $arrdoanhthu[0][$datetime] += $valuedate;
                                        else $arrdoanhthu[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($doanhthutralai))
                            {
                                foreach ($doanhthutralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrdoanhthutralai[0][$datetime])) $arrdoanhthutralai[0][$datetime] += $valuedate;
                                        else $arrdoanhthutralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($thanhtoan))
                            {
                                foreach ($thanhtoan as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrthanhtoan[0][$datetime])) $arrthanhtoan[0][$datetime] += $valuedate;
                                        else $arrthanhtoan[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $arrconditon, $startdate, $enddate );
                            if (!empty($thanhtoantralai))
                            {
                                foreach ($thanhtoantralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrthanhtoantralai[0][$datetime])) $arrthanhtoantralai[0][$datetime] += $valuedate;
                                        else $arrthanhtoantralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $arrconditon, $startdate, $enddate );
                            if (!empty($giavonban))
                            {
                                foreach ($giavonban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrgiavonban[0][$datetime])) $arrgiavonban[0][$datetime] += $valuedate;
                                        else $arrgiavonban[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $arrconditon, $startdate, $enddate );
                            if (!empty($giavontralai))
                            {
                                foreach ($giavontralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrgiavontralai[0][$datetime])) $arrgiavontralai[0][$datetime] += $valuedate;
                                        else $arrgiavontralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $arrconditon, $startdate , $enddate );
                            if (!empty($giatrihangkhuyenmai))
                            {
                                foreach ($giatrihangkhuyenmai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrgiatrihangkhuyenmai[0][$datetime])) $arrgiatrihangkhuyenmai[0][$datetime] += $valuedate;
                                        else $arrgiatrihangkhuyenmai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $arrconditon, $startdate, $enddate );
                            if (!empty($tonkhodauky))
                            {
                                foreach ($tonkhodauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtonkhodauky[0][$datetime])) $arrtonkhodauky[0][$datetime] += $valuedate;
                                        else $arrtonkhodauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongnhapmuadauky))
                            {
                                foreach ($soluongnhapmuadauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongnhapmuadauky[0][$datetime])) $arrsoluongnhapmuadauky[0][$datetime] += $valuedate;
                                        else $arrsoluongnhapmuadauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapmuadauky))
                            {
                                foreach ($trigianhapmuadauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapmuadauky[0][$datetime])) $arrtrigianhapmuadauky[0][$datetime] += $valuedate;
                                        else $arrtrigianhapmuadauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongxuatbandauky))
                            {
                                foreach ($soluongxuatbandauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongxuatbandauky[0][$datetime])) $arrsoluongxuatbandauky[0][$datetime] += $valuedate;
                                        else $arrsoluongxuatbandauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatbandauky))
                            {
                                foreach ($trigiaxuatbandauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatbandauky[0][$datetime])) $arrtrigiaxuatbandauky[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatbandauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhapmua))
                            {
                                foreach ($nhapmua as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhapmua[0][$datetime])) $arrnhapmua[0][$datetime] += $valuedate;
                                        else $arrnhapmua[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhapnoibo))
                            {
                                foreach ($nhapnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhapnoibo[0][$datetime])) $arrnhapnoibo[0][$datetime] += $valuedate;
                                        else $arrnhapnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhaptralai))
                            {
                                foreach ($nhaptralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhaptralai[0][$datetime])) $arrnhaptralai[0][$datetime] += $valuedate;
                                        else $arrnhaptralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhapkhac))
                            {
                                foreach ($nhapkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhapkhac[0][$datetime])) $arrnhapkhac[0][$datetime] += $valuedate;
                                        else $arrnhapkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuatban))
                            {
                                foreach ($xuatban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuatban[0][$datetime])) $arrxuatban[0][$datetime] += $valuedate;
                                        else $arrxuatban[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuatnoibo))
                            {
                                foreach ($xuatnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuatnoibo[0][$datetime])) $arrxuatnoibo[0][$datetime] += $valuedate;
                                        else $arrxuatnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuattramuahang))
                            {
                                foreach ($xuattramuahang as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuattramuahang[0][$datetime])) $arrxuattramuahang[0][$datetime] += $valuedate;
                                        else $arrxuattramuahang[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuatkhac))
                            {
                                foreach ($xuatkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuatkhac[0][$datetime])) $arrxuatkhac[0][$datetime] += $valuedate;
                                        else $arrxuatkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiatonkhodauky))
                            {
                                foreach ($trigiatonkhodauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiatonkhodauky[0][$datetime])) $arrtrigiatonkhodauky[0][$datetime] += $valuedate;
                                        else $arrtrigiatonkhodauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapmua))
                            {
                                foreach ($trigianhapmua as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapmua[0][$datetime])) $arrtrigianhapmua[0][$datetime] += $valuedate;
                                        else $arrtrigianhapmua[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapnoibo))
                            {
                                foreach ($trigianhapnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapnoibo[0][$datetime])) $arrtrigianhapnoibo[0][$datetime] += $valuedate;
                                        else $arrtrigianhapnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhaptra))
                            {
                                foreach ($trigianhaptra as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhaptra[0][$datetime])) $arrtrigianhaptra[0][$datetime] += $valuedate;
                                        else $arrtrigianhaptra[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapkhac))
                            {
                                foreach ($trigianhapkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapkhac[0][$datetime])) $arrtrigianhapkhac[0][$datetime] += $valuedate;
                                        else $arrtrigianhapkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatban))
                            {
                                foreach ($trigiaxuatban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatban[0][$datetime])) $arrtrigiaxuatban[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatban[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tri gia xuat noi bo
                            $trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatnoibo))
                            {
                                foreach ($trigiaxuatnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatnoibo[0][$datetime])) $arrtrigiaxuatnoibo[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tri gia xuat tra
                            $trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuattra))
                            {
                                foreach ($trigiaxuattra as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuattra[0][$datetime])) $arrtrigiaxuattra[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuattra[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tri gia xuat khac
                            $trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatkhac))
                            {
                                foreach ($trigiaxuatkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatkhac[0][$datetime])) $arrtrigiaxuatkhac[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //so luong don hang
                            $soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongdonhang))
                            {
                                foreach ($soluongdonhang as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongdonhang[0][$datetime])) $arrsoluongdonhang[0][$datetime] += $valuedate;
                                        else $arrsoluongdonhang[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tong diem thuong
                            $tongdiemchuan = Core_Stat::getData(Core_Stat::TYPE_PRODUCTREWARD, $arrconditon, $startdate, $enddate );
                            if (!empty($tongdiemchuan))
                            {
                                foreach ($tongdiemchuan as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrdiemchuan[0][$datetime])) $arrdiemchuan[0][$datetime] += $valuedate;
                                        else $arrdiemchuan[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //lop theo tung kho
                            foreach ($storelistfromcache as $sid=>$sname)
                            {
                                $arrconditon = array('category' => $pcid, 'outputstore' => $sid);
                                $arrconditonrf = array('category' => $pcid, 'inputstore' => $sid);
                                $soluongban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($soluongban))
                                {
                                    foreach ($soluongban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongban[$sid][$datetime])) $arrsoluongban[$sid][$datetime] += $valuedate;
                                            else $arrsoluongban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }
                                $soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($soluongtralai))
                                {
                                    foreach ($soluongtralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongtralai[$sid][$datetime])) $arrsoluongtralai[$sid][$datetime] += $valuedate;
                                            else $arrsoluongtralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $arrconditon, $startdate, $enddate );
                                if (!empty($doanhthu))
                                {
                                    foreach ($doanhthu as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrdoanhthu[$sid][$datetime])) $arrdoanhthu[$sid][$datetime] += $valuedate;
                                            else $arrdoanhthu[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($doanhthutralai))
                                {
                                    foreach ($doanhthutralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrdoanhthutralai[$sid][$datetime])) $arrdoanhthutralai[$sid][$datetime] += $valuedate;
                                            else $arrdoanhthutralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($thanhtoan))
                                {
                                    foreach ($thanhtoan as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrthanhtoan[$sid][$datetime])) $arrthanhtoan[$sid][$datetime] += $valuedate;
                                            else $arrthanhtoan[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $arrconditonrf, $startdate, $enddate );
                                if (!empty($thanhtoantralai))
                                {
                                    foreach ($thanhtoantralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrthanhtoantralai[$sid][$datetime])) $arrthanhtoantralai[$sid][$datetime] += $valuedate;
                                            else $arrthanhtoantralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $arrconditon, $startdate, $enddate );
                                if (!empty($giavonban))
                                {
                                    foreach ($giavonban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrgiavonban[$sid][$datetime])) $arrgiavonban[$sid][$datetime] += $valuedate;
                                            else $arrgiavonban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($giavontralai))
                                {
                                    foreach ($giavontralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrgiavontralai[$sid][$datetime])) $arrgiavontralai[$sid][$datetime] += $valuedate;
                                            else $arrgiavontralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $arrconditonrf, $startdate , $enddate );
                                if (!empty($giatrihangkhuyenmai))
                                {
                                    foreach ($giatrihangkhuyenmai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrgiatrihangkhuyenmai[$sid][$datetime])) $arrgiatrihangkhuyenmai[$sid][$datetime] += $valuedate;
                                            else $arrgiatrihangkhuyenmai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $arrconditon, $startdate, $enddate );
                                if (!empty($tonkhodauky))
                                {
                                    foreach ($tonkhodauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtonkhodauky[$sid][$datetime])) $arrtonkhodauky[$sid][$datetime] += $valuedate;
                                            else $arrtonkhodauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($soluongnhapmuadauky))
                                {
                                    foreach ($soluongnhapmuadauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongnhapmuadauky[$sid][$datetime])) $arrsoluongnhapmuadauky[$sid][$datetime] += $valuedate;
                                            else $arrsoluongnhapmuadauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapmuadauky))
                                {
                                    foreach ($trigianhapmuadauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapmuadauky[$sid][$datetime])) $arrtrigianhapmuadauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapmuadauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($soluongxuatbandauky))
                                {
                                    foreach ($soluongxuatbandauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongxuatbandauky[$sid][$datetime])) $arrsoluongxuatbandauky[$sid][$datetime] += $valuedate;
                                            else $arrsoluongxuatbandauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatbandauky))
                                {
                                    foreach ($trigiaxuatbandauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatbandauky[$sid][$datetime])) $arrtrigiaxuatbandauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatbandauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhapmua))
                                {
                                    foreach ($nhapmua as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhapmua[$sid][$datetime])) $arrnhapmua[$sid][$datetime] += $valuedate;
                                            else $arrnhapmua[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhapnoibo))
                                {
                                    foreach ($nhapnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhapnoibo[$sid][$datetime])) $arrnhapnoibo[$sid][$datetime] += $valuedate;
                                            else $arrnhapnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhaptralai))
                                {
                                    foreach ($nhaptralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhaptralai[$sid][$datetime])) $arrnhaptralai[$sid][$datetime] += $valuedate;
                                            else $arrnhaptralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhapkhac))
                                {
                                    foreach ($nhapkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhapkhac[$sid][$datetime])) $arrnhapkhac[$sid][$datetime] += $valuedate;
                                            else $arrnhapkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuatban))
                                {
                                    foreach ($xuatban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuatban[$sid][$datetime])) $arrxuatban[$sid][$datetime] += $valuedate;
                                            else $arrxuatban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuatnoibo))
                                {
                                    foreach ($xuatnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuatnoibo[$sid][$datetime])) $arrxuatnoibo[$sid][$datetime] += $valuedate;
                                            else $arrxuatnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuattramuahang))
                                {
                                    foreach ($xuattramuahang as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuattramuahang[$sid][$datetime])) $arrxuattramuahang[$sid][$datetime] += $valuedate;
                                            else $arrxuattramuahang[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuatkhac))
                                {
                                    foreach ($xuatkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuatkhac[$sid][$datetime])) $arrxuatkhac[$sid][$datetime] += $valuedate;
                                            else $arrxuatkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiatonkhodauky))
                                {
                                    foreach ($trigiatonkhodauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiatonkhodauky[$sid][$datetime])) $arrtrigiatonkhodauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigiatonkhodauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapmua))
                                {
                                    foreach ($trigianhapmua as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapmua[$sid][$datetime])) $arrtrigianhapmua[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapmua[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapnoibo))
                                {
                                    foreach ($trigianhapnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapnoibo[$sid][$datetime])) $arrtrigianhapnoibo[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhaptra))
                                {
                                    foreach ($trigianhaptra as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhaptra[$sid][$datetime])) $arrtrigianhaptra[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhaptra[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapkhac))
                                {
                                    foreach ($trigianhapkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapkhac[$sid][$datetime])) $arrtrigianhapkhac[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatban))
                                {
                                    foreach ($trigiaxuatban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatban[$sid][$datetime])) $arrtrigiaxuatban[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //tri gia xuat noi bo
                                $trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatnoibo))
                                {
                                    foreach ($trigiaxuatnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatnoibo[$sid][$datetime])) $arrtrigiaxuatnoibo[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //tri gia xuat tra
                                $trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuattra))
                                {
                                    foreach ($trigiaxuattra as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuattra[$sid][$datetime])) $arrtrigiaxuattra[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuattra[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //tri gia xuat khac
                                $trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatkhac))
                                {
                                    foreach ($trigiaxuatkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatkhac[$sid][$datetime])) $arrtrigiaxuatkhac[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //so luong don hang
                                $soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($soluongdonhang))
                                {
                                    foreach ($soluongdonhang as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongdonhang[$sid][$datetime])) $arrsoluongdonhang[$sid][$datetime] += $valuedate;
                                            else $arrsoluongdonhang[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }
                            }
                        }

                        //luu xuong cache
                        $listnewstorecache = array();
                        foreach ($storelistfromcache as $sid => $sname)
                        {
                            $listnewstorecache[] = $sid;
                        }
                        //$listnewstorecache[] = 0;
                        if (!empty($arrsoluongban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongtralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongtralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongtralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrdoanhthu))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrdoanhthu[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrdoanhthu[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrdoanhthutralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrdoanhthutralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrdoanhthutralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        };

                        if (!empty($arrthanhtoan))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrthanhtoan[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrthanhtoan[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrthanhtoantralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrthanhtoantralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrthanhtoantralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrgiavonban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrgiavonban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrgiavonban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_COSTPRICE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrgiavontralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrgiavontralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrgiavontralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_COSTPRICE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrgiatrihangkhuyenmai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrgiatrihangkhuyenmai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrgiatrihangkhuyenmai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROMOTION_COSTPRICE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtonkhodauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtonkhodauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtonkhodauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongnhapmuadauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongnhapmuadauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongnhapmuadauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapmuadauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapmuadauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapmuadauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongxuatbandauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongxuatbandauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongxuatbandauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatbandauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatbandauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatbandauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhapmua))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhapmua[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhapmua[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhapnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhapnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhapnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhaptralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhaptralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhaptralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhapkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhapkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhapkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuatban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuatban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuatban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuatnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuatnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuatnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuattramuahang))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuattramuahang[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuattramuahang[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuatkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuatkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuatkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiatonkhodauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiatonkhodauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiatonkhodauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapmua))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapmua[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapmua[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhaptra))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhaptra[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhaptra[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuattra))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuattra[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuattra[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongdonhang))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongdonhang[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongdonhang[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrdiemchuan))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrdiemchuan[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrdiemchuan[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PRODUCTREWARD, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }


                        //end luu xuong cache
                        unset($arrsoluongban);
                        unset($arrsoluongtralai);
                        unset($arrdoanhthu);
                        unset($arrdoanhthutralai);
                        unset($arrthanhtoan);
                        unset($arrthanhtoantralai);
                        unset($arrgiavonban);
                        unset($arrgiavontralai);
                        unset($arrgiatrihangkhuyenmai);
                        unset($arrtonkhodauky);
                        unset($arrsoluongnhapmuadauky);
                        unset($arrtrigianhapmuadauky);
                        unset($arrsoluongxuatbandauky);
                        unset($arrtrigiaxuatbandauky);
                        unset($arrnhapmua);
                        unset($arrnhapnoibo);
                        unset($arrnhaptralai);
                        unset($arrnhapkhac);
                        unset($arrxuatban);
                        unset($arrxuatnoibo);
                        unset($arrxuattramuahang);
                        unset($arrxuatkhac);
                        unset($arrtrigiatonkhodauky);
                        unset($arrtrigianhapmua);
                        unset($arrtrigianhapnoibo);
                        unset($arrtrigianhaptra);
                        unset($arrtrigianhapkhac);
                        unset($arrtrigiaxuatban);
                        unset($arrtrigiaxuatnoibo);
                        unset($arrtrigiaxuattra);
                        unset($arrtrigiaxuatkhac);
                        unset($arrsoluongdonhang);
                    }
                }
            }
            foreach ($productcategorylist as $catid => $datavalue)
            {
                if(count($datavalue['child']) > 0 && count($datavalue['parent']) == 0)
                {
                    $arrsoluongban = array();
                    $arrsoluongtralai = array();
                    $arrdoanhthu = array();
                    $arrdoanhthutralai = array();
                    $arrthanhtoan = array();
                    $arrthanhtoantralai = array();
                    $arrgiavonban = array();
                    $arrgiavontralai = array();
                    $arrgiatrihangkhuyenmai = array();
                    $arrtonkhodauky = array();
                    $arrsoluongnhapmuadauky = array();
                    $arrtrigianhapmuadauky = array();
                    $arrsoluongxuatbandauky = array();
                    $arrtrigiaxuatbandauky = array();
                    $arrnhapmua = array();
                    $arrnhapnoibo = array();
                    $arrnhaptralai = array();
                    $arrnhapkhac = array();
                    $arrxuatban = array();
                    $arrxuatnoibo = array();
                    $arrxuattramuahang = array();
                    $arrxuatkhac = array();
                    $arrtrigiatonkhodauky = array();
                    $arrtrigianhapmua = array();
                    $arrtrigianhapnoibo = array();
                    $arrtrigianhaptra = array();
                    $arrtrigianhapkhac = array();
                    $arrtrigiaxuatban = array();
                    $arrtrigiaxuatnoibo = array();
                    $arrtrigiaxuattra = array();
                    $arrtrigiaxuatkhac = array();
                    $arrsoluongdonhang = array();
                    $arrdiemchuan = array();
                    if (!empty($datavalue['child']))
                    {
                        foreach ($datavalue['child'] as $pcid)
                        {
                            $arrconditon = array('category' => $pcid);
                            $soluongban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongban))
                            {
                                foreach ($soluongban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongban[0][$datetime])) $arrsoluongban[0][$datetime] += $valuedate;
                                        else $arrsoluongban[0][$datetime] = $valuedate;
                                    }
                                }
                            }
                            $soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongtralai))
                            {
                                foreach ($soluongtralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongtralai[0][$datetime])) $arrsoluongtralai[0][$datetime] += $valuedate;
                                        else $arrsoluongtralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $arrconditon, $startdate, $enddate );

                            if (!empty($doanhthu))
                            {
                                foreach ($doanhthu as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrdoanhthu[0][$datetime])) $arrdoanhthu[0][$datetime] += $valuedate;
                                        else $arrdoanhthu[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($doanhthutralai))
                            {
                                foreach ($doanhthutralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrdoanhthutralai[0][$datetime])) $arrdoanhthutralai[0][$datetime] += $valuedate;
                                        else $arrdoanhthutralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($thanhtoan))
                            {
                                foreach ($thanhtoan as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrthanhtoan[0][$datetime])) $arrthanhtoan[0][$datetime] += $valuedate;
                                        else $arrthanhtoan[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $arrconditon, $startdate, $enddate );
                            if (!empty($thanhtoantralai))
                            {
                                foreach ($thanhtoantralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrthanhtoantralai[0][$datetime])) $arrthanhtoantralai[0][$datetime] += $valuedate;
                                        else $arrthanhtoantralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $arrconditon, $startdate, $enddate );
                            if (!empty($giavonban))
                            {
                                foreach ($giavonban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrgiavonban[0][$datetime])) $arrgiavonban[0][$datetime] += $valuedate;
                                        else $arrgiavonban[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $arrconditon, $startdate, $enddate );
                            if (!empty($giavontralai))
                            {
                                foreach ($giavontralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrgiavontralai[0][$datetime])) $arrgiavontralai[0][$datetime] += $valuedate;
                                        else $arrgiavontralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $arrconditon, $startdate , $enddate );
                            if (!empty($giatrihangkhuyenmai))
                            {
                                foreach ($giatrihangkhuyenmai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrgiatrihangkhuyenmai[0][$datetime])) $arrgiatrihangkhuyenmai[0][$datetime] += $valuedate;
                                        else $arrgiatrihangkhuyenmai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $arrconditon, $startdate, $enddate );
                            if (!empty($tonkhodauky))
                            {
                                foreach ($tonkhodauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtonkhodauky[0][$datetime])) $arrtonkhodauky[0][$datetime] += $valuedate;
                                        else $arrtonkhodauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongnhapmuadauky))
                            {
                                foreach ($soluongnhapmuadauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongnhapmuadauky[0][$datetime])) $arrsoluongnhapmuadauky[0][$datetime] += $valuedate;
                                        else $arrsoluongnhapmuadauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapmuadauky))
                            {
                                foreach ($trigianhapmuadauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapmuadauky[0][$datetime])) $arrtrigianhapmuadauky[0][$datetime] += $valuedate;
                                        else $arrtrigianhapmuadauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongxuatbandauky))
                            {
                                foreach ($soluongxuatbandauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongxuatbandauky[0][$datetime])) $arrsoluongxuatbandauky[0][$datetime] += $valuedate;
                                        else $arrsoluongxuatbandauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatbandauky))
                            {
                                foreach ($trigiaxuatbandauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatbandauky[0][$datetime])) $arrtrigiaxuatbandauky[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatbandauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhapmua))
                            {
                                foreach ($nhapmua as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhapmua[0][$datetime])) $arrnhapmua[0][$datetime] += $valuedate;
                                        else $arrnhapmua[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhapnoibo))
                            {
                                foreach ($nhapnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhapnoibo[0][$datetime])) $arrnhapnoibo[0][$datetime] += $valuedate;
                                        else $arrnhapnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhaptralai))
                            {
                                foreach ($nhaptralai as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhaptralai[0][$datetime])) $arrnhaptralai[0][$datetime] += $valuedate;
                                        else $arrnhaptralai[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($nhapkhac))
                            {
                                foreach ($nhapkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrnhapkhac[0][$datetime])) $arrnhapkhac[0][$datetime] += $valuedate;
                                        else $arrnhapkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuatban))
                            {
                                foreach ($xuatban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuatban[0][$datetime])) $arrxuatban[0][$datetime] += $valuedate;
                                        else $arrxuatban[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuatnoibo))
                            {
                                foreach ($xuatnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuatnoibo[0][$datetime])) $arrxuatnoibo[0][$datetime] += $valuedate;
                                        else $arrxuatnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuattramuahang))
                            {
                                foreach ($xuattramuahang as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuattramuahang[0][$datetime])) $arrxuattramuahang[0][$datetime] += $valuedate;
                                        else $arrxuattramuahang[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($xuatkhac))
                            {
                                foreach ($xuatkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrxuatkhac[0][$datetime])) $arrxuatkhac[0][$datetime] += $valuedate;
                                        else $arrxuatkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiatonkhodauky))
                            {
                                foreach ($trigiatonkhodauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiatonkhodauky[0][$datetime])) $arrtrigiatonkhodauky[0][$datetime] += $valuedate;
                                        else $arrtrigiatonkhodauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapmua))
                            {
                                foreach ($trigianhapmua as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapmua[0][$datetime])) $arrtrigianhapmua[0][$datetime] += $valuedate;
                                        else $arrtrigianhapmua[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapnoibo))
                            {
                                foreach ($trigianhapnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapnoibo[0][$datetime])) $arrtrigianhapnoibo[0][$datetime] += $valuedate;
                                        else $arrtrigianhapnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhaptra))
                            {
                                foreach ($trigianhaptra as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhaptra[0][$datetime])) $arrtrigianhaptra[0][$datetime] += $valuedate;
                                        else $arrtrigianhaptra[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigianhapkhac))
                            {
                                foreach ($trigianhapkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigianhapkhac[0][$datetime])) $arrtrigianhapkhac[0][$datetime] += $valuedate;
                                        else $arrtrigianhapkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            $trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatban))
                            {
                                foreach ($trigiaxuatban as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatban[0][$datetime])) $arrtrigiaxuatban[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatban[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tri gia xuat noi bo
                            $trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatnoibo))
                            {
                                foreach ($trigiaxuatnoibo as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatnoibo[0][$datetime])) $arrtrigiaxuatnoibo[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatnoibo[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tri gia xuat tra
                            $trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuattra))
                            {
                                foreach ($trigiaxuattra as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuattra[0][$datetime])) $arrtrigiaxuattra[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuattra[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tri gia xuat khac
                            $trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiaxuatkhac))
                            {
                                foreach ($trigiaxuatkhac as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiaxuatkhac[0][$datetime])) $arrtrigiaxuatkhac[0][$datetime] += $valuedate;
                                        else $arrtrigiaxuatkhac[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //so luong don hang
                            $soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $arrconditon, $startdate, $enddate );
                            if (!empty($soluongdonhang))
                            {
                                foreach ($soluongdonhang as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrsoluongdonhang[0][$datetime])) $arrsoluongdonhang[0][$datetime] += $valuedate;
                                        else $arrsoluongdonhang[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //tong diem thuong
                            $tongdiemchuan = Core_Stat::getData(Core_Stat::TYPE_PRODUCTREWARD, $arrconditon, $startdate, $enddate );
                            if (!empty($tongdiemchuan))
                            {
                                foreach ($tongdiemchuan as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrdiemchuan[0][$datetime])) $arrdiemchuan[0][$datetime] += $valuedate;
                                        else $arrdiemchuan[0][$datetime] = $valuedate;
                                    }
                                }
                            }

                            //lop theo tung kho
                            foreach ($storelistfromcache as $sid=>$sname)
                            {
                                $arrconditon = array('category' => $pcid, 'outputstore' => $sid);
                                $arrconditonrf = array('category' => $pcid, 'inputstore' => $sid);
                                $soluongban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($soluongban))
                                {
                                    foreach ($soluongban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongban[$sid][$datetime])) $arrsoluongban[$sid][$datetime] += $valuedate;
                                            else $arrsoluongban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }
                                $soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($soluongtralai))
                                {
                                    foreach ($soluongtralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongtralai[$sid][$datetime])) $arrsoluongtralai[$sid][$datetime] += $valuedate;
                                            else $arrsoluongtralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $arrconditon, $startdate, $enddate );
                                if (!empty($doanhthu))
                                {
                                    foreach ($doanhthu as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrdoanhthu[$sid][$datetime])) $arrdoanhthu[$sid][$datetime] += $valuedate;
                                            else $arrdoanhthu[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($doanhthutralai))
                                {
                                    foreach ($doanhthutralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrdoanhthutralai[$sid][$datetime])) $arrdoanhthutralai[$sid][$datetime] += $valuedate;
                                            else $arrdoanhthutralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($thanhtoan))
                                {
                                    foreach ($thanhtoan as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrthanhtoan[$sid][$datetime])) $arrthanhtoan[$sid][$datetime] += $valuedate;
                                            else $arrthanhtoan[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $arrconditonrf, $startdate, $enddate );
                                if (!empty($thanhtoantralai))
                                {
                                    foreach ($thanhtoantralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrthanhtoantralai[$sid][$datetime])) $arrthanhtoantralai[$sid][$datetime] += $valuedate;
                                            else $arrthanhtoantralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $arrconditon, $startdate, $enddate );
                                if (!empty($giavonban))
                                {
                                    foreach ($giavonban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrgiavonban[$sid][$datetime])) $arrgiavonban[$sid][$datetime] += $valuedate;
                                            else $arrgiavonban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($giavontralai))
                                {
                                    foreach ($giavontralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrgiavontralai[$sid][$datetime])) $arrgiavontralai[$sid][$datetime] += $valuedate;
                                            else $arrgiavontralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $arrconditonrf, $startdate , $enddate );
                                if (!empty($giatrihangkhuyenmai))
                                {
                                    foreach ($giatrihangkhuyenmai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrgiatrihangkhuyenmai[$sid][$datetime])) $arrgiatrihangkhuyenmai[$sid][$datetime] += $valuedate;
                                            else $arrgiatrihangkhuyenmai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $arrconditon, $startdate, $enddate );
                                if (!empty($tonkhodauky))
                                {
                                    foreach ($tonkhodauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtonkhodauky[$sid][$datetime])) $arrtonkhodauky[$sid][$datetime] += $valuedate;
                                            else $arrtonkhodauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($soluongnhapmuadauky))
                                {
                                    foreach ($soluongnhapmuadauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongnhapmuadauky[$sid][$datetime])) $arrsoluongnhapmuadauky[$sid][$datetime] += $valuedate;
                                            else $arrsoluongnhapmuadauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapmuadauky))
                                {
                                    foreach ($trigianhapmuadauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapmuadauky[$sid][$datetime])) $arrtrigianhapmuadauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapmuadauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($soluongxuatbandauky))
                                {
                                    foreach ($soluongxuatbandauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongxuatbandauky[$sid][$datetime])) $arrsoluongxuatbandauky[$sid][$datetime] += $valuedate;
                                            else $arrsoluongxuatbandauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatbandauky))
                                {
                                    foreach ($trigiaxuatbandauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatbandauky[$sid][$datetime])) $arrtrigiaxuatbandauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatbandauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhapmua))
                                {
                                    foreach ($nhapmua as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhapmua[$sid][$datetime])) $arrnhapmua[$sid][$datetime] += $valuedate;
                                            else $arrnhapmua[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhapnoibo))
                                {
                                    foreach ($nhapnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhapnoibo[$sid][$datetime])) $arrnhapnoibo[$sid][$datetime] += $valuedate;
                                            else $arrnhapnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhaptralai))
                                {
                                    foreach ($nhaptralai as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhaptralai[$sid][$datetime])) $arrnhaptralai[$sid][$datetime] += $valuedate;
                                            else $arrnhaptralai[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $arrconditonrf, $startdate, $enddate );
                                if (!empty($nhapkhac))
                                {
                                    foreach ($nhapkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrnhapkhac[$sid][$datetime])) $arrnhapkhac[$sid][$datetime] += $valuedate;
                                            else $arrnhapkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuatban))
                                {
                                    foreach ($xuatban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuatban[$sid][$datetime])) $arrxuatban[$sid][$datetime] += $valuedate;
                                            else $arrxuatban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuatnoibo))
                                {
                                    foreach ($xuatnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuatnoibo[$sid][$datetime])) $arrxuatnoibo[$sid][$datetime] += $valuedate;
                                            else $arrxuatnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuattramuahang))
                                {
                                    foreach ($xuattramuahang as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuattramuahang[$sid][$datetime])) $arrxuattramuahang[$sid][$datetime] += $valuedate;
                                            else $arrxuattramuahang[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($xuatkhac))
                                {
                                    foreach ($xuatkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrxuatkhac[$sid][$datetime])) $arrxuatkhac[$sid][$datetime] += $valuedate;
                                            else $arrxuatkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiatonkhodauky))
                                {
                                    foreach ($trigiatonkhodauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiatonkhodauky[$sid][$datetime])) $arrtrigiatonkhodauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigiatonkhodauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapmua))
                                {
                                    foreach ($trigianhapmua as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapmua[$sid][$datetime])) $arrtrigianhapmua[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapmua[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapnoibo))
                                {
                                    foreach ($trigianhapnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapnoibo[$sid][$datetime])) $arrtrigianhapnoibo[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhaptra))
                                {
                                    foreach ($trigianhaptra as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhaptra[$sid][$datetime])) $arrtrigianhaptra[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhaptra[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $arrconditonrf, $startdate, $enddate );
                                if (!empty($trigianhapkhac))
                                {
                                    foreach ($trigianhapkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigianhapkhac[$sid][$datetime])) $arrtrigianhapkhac[$sid][$datetime] += $valuedate;
                                            else $arrtrigianhapkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                $trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatban))
                                {
                                    foreach ($trigiaxuatban as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatban[$sid][$datetime])) $arrtrigiaxuatban[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatban[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //tri gia xuat noi bo
                                $trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatnoibo))
                                {
                                    foreach ($trigiaxuatnoibo as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatnoibo[$sid][$datetime])) $arrtrigiaxuatnoibo[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatnoibo[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //tri gia xuat tra
                                $trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuattra))
                                {
                                    foreach ($trigiaxuattra as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuattra[$sid][$datetime])) $arrtrigiaxuattra[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuattra[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //tri gia xuat khac
                                $trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiaxuatkhac))
                                {
                                    foreach ($trigiaxuatkhac as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiaxuatkhac[$sid][$datetime])) $arrtrigiaxuatkhac[$sid][$datetime] += $valuedate;
                                            else $arrtrigiaxuatkhac[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }

                                //so luong don hang
                                $soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $arrconditon, $startdate, $enddate );
                                if (!empty($soluongdonhang))
                                {
                                    foreach ($soluongdonhang as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrsoluongdonhang[$sid][$datetime])) $arrsoluongdonhang[$sid][$datetime] += $valuedate;
                                            else $arrsoluongdonhang[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }
                            }
                        }

                        //luu xuong cache
                        $listnewstorecache = array();
                        foreach ($storelistfromcache as $sid => $sname)
                        {
                            $listnewstorecache[] = $sid;
                        }
                        $listnewstorecache[] = 0;
                        if (!empty($arrsoluongban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongtralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongtralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongtralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrdoanhthu))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrdoanhthu[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrdoanhthu[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrdoanhthutralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrdoanhthutralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrdoanhthutralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        };

                        if (!empty($arrthanhtoan))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrthanhtoan[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrthanhtoan[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ITEM_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrthanhtoantralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrthanhtoantralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrthanhtoantralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrgiavonban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrgiavonban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrgiavonban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_COSTPRICE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrgiavontralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrgiavontralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrgiavontralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_REFUND_COSTPRICE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrgiatrihangkhuyenmai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrgiatrihangkhuyenmai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrgiatrihangkhuyenmai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PROMOTION_COSTPRICE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtonkhodauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtonkhodauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtonkhodauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongnhapmuadauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongnhapmuadauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongnhapmuadauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapmuadauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapmuadauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapmuadauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongxuatbandauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongxuatbandauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongxuatbandauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatbandauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatbandauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatbandauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhapmua))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhapmua[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhapmua[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhapnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhapnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhapnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhaptralai))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhaptralai[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhaptralai[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrnhapkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrnhapkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrnhapkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuatban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuatban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuatban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuatnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuatnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuatnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuattramuahang))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuattramuahang[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuattramuahang[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrxuatkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrxuatkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrxuatkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiatonkhodauky))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiatonkhodauky[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiatonkhodauky[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapmua))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapmua[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapmua[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhaptra))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhaptra[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhaptra[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigianhapkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigianhapkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigianhapkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_INPUT_OTHER_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatban))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['inputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatban[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatban[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatnoibo))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatnoibo[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatnoibo[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuattra))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuattra[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuattra[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrtrigiaxuatkhac))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrtrigiaxuatkhac[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrtrigiaxuatkhac[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrsoluongdonhang))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrsoluongdonhang[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrsoluongdonhang[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }

                        if (!empty($arrdiemchuan))
                        {
                            foreach ($listnewstorecache as $sid)
                            {
                                $dtwhile = $startdate;
                                $condition = array('category' => $catid);
                                if ($sid >0)
                                {
                                    $condition['outputstore'] = $sid;
                                }
                                while($dtwhile <= $enddate)
                                {
                                    $valuebydate = 0;
                                    $dttime = date('Y/m/d', $dtwhile);
                                    if (!empty($arrdiemchuan[$sid][$dttime]))
                                    {
                                        $valuebydate = $arrdiemchuan[$sid][$dttime];
                                    }
                                    Core_Stat::setDataSaleInDate(Core_Stat::TYPE_PRODUCTREWARD, $condition, $dttime, (string)$valuebydate);
                                    $dtwhile = strtotime('+1 day', $dtwhile);
                                }
                            }
                        }


                        //end luu xuong cache
                        unset($arrsoluongban);
                        unset($arrsoluongtralai);
                        unset($arrdoanhthu);
                        unset($arrdoanhthutralai);
                        unset($arrthanhtoan);
                        unset($arrthanhtoantralai);
                        unset($arrgiavonban);
                        unset($arrgiavontralai);
                        unset($arrgiatrihangkhuyenmai);
                        unset($arrtonkhodauky);
                        unset($arrsoluongnhapmuadauky);
                        unset($arrtrigianhapmuadauky);
                        unset($arrsoluongxuatbandauky);
                        unset($arrtrigiaxuatbandauky);
                        unset($arrnhapmua);
                        unset($arrnhapnoibo);
                        unset($arrnhaptralai);
                        unset($arrnhapkhac);
                        unset($arrxuatban);
                        unset($arrxuatnoibo);
                        unset($arrxuattramuahang);
                        unset($arrxuatkhac);
                        unset($arrtrigiatonkhodauky);
                        unset($arrtrigianhapmua);
                        unset($arrtrigianhapnoibo);
                        unset($arrtrigianhaptra);
                        unset($arrtrigianhapkhac);
                        unset($arrtrigiaxuatban);
                        unset($arrtrigiaxuatnoibo);
                        unset($arrtrigiaxuattra);
                        unset($arrtrigiaxuatkhac);
                        unset($arrsoluongdonhang);
                    }
                }
            }
        }

        echo 'End time; '.(time() - $starttime).'';
    }
//----------END CACHE CATEGORY PARENT THEO TUNG CATEGORY CHILD-----------------------

    function  testAction()
    {
        /*$db3 = $this->getDb('db3');//get db3
        //luuu ngay cap nhat cache of index vo cache
        $getdatecreated = $db3->query('SELECT c_datecreated FROM '.TABLE_PREFIX.'crontask WHERE c_controller = \'reportingnew\' and c_action = \'syncproductreward\' ORDER BY c_datecreated DESC LIMIT 0,1')->fetch();
        if (!empty($getdatecreated))
        {
            $cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS);
            $cacheredis->set($getdatecreated['c_datecreated'], 0);
        }

        exit();*/
        set_time_limit(0);
        $timer = new timer();
        $timer->start();

        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '23:59'):strtotime('-1 month'));//strtotime('-1 month')
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '00:00'):time());//time());
        $startdate = strtotime(date('Y-m-d 00:00:00', $startdate));
        $enddate = strtotime(date('Y-m-d 23:59:59', $enddate));
        $productVendorList          = Core_Vendor::getProductVendorFromCache(0,0,true);
        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $listvendorproduct = $productVendorList[42];
        $arrtrigiatonkhodauky = array();
        $listcategoryfromcache = Core_Stat::getproducthavereport($startdate, $enddate);
        $listdiffproduct = $listcategoryfromcache[42];
        foreach ($listvendorproduct as $vid=>$productlist)
        {
            if (!empty($productlist))
            {
                foreach ($productlist as $pmainproduct)
                {
                    if (!in_array($pmainproduct, $listdiffproduct)) continue;

                    $myProduct = new Core_Product($pmainproduct, true);
                    $listproductcolor = $myProduct->getProductColor($pmainproduct);
                    if (!empty($listproductcolor))
                    {
                        foreach ($listproductcolor as $pidcolor)
                        {
                            $arrconditon = array('product' => $pidcolor);
                            $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $arrconditon, $startdate, $enddate );
                            if (!empty($trigiatonkhodauky))
                            {
                                foreach ($trigiatonkhodauky as $datetime=>$valuedate)
                                {
                                    if (!empty($valuedate))
                                    {
                                        if (!empty($arrtrigiatonkhodauky[0][$datetime])) $arrtrigiatonkhodauky[0][$datetime] += $valuedate;
                                        else $arrtrigiatonkhodauky[0][$datetime] = $valuedate;
                                    }
                                }
                            }
                            foreach ($storelistfromcache as $sid=>$sname)
                            {
                                $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $arrconditon, $startdate, $enddate );
                                if (!empty($trigiatonkhodauky))
                                {
                                    foreach ($trigiatonkhodauky as $datetime=>$valuedate)
                                    {
                                        if (!empty($valuedate))
                                        {
                                            if (!empty($arrtrigiatonkhodauky[$sid][$datetime])) $arrtrigiatonkhodauky[$sid][$datetime] += $valuedate;
                                            else $arrtrigiatonkhodauky[$sid][$datetime] = $valuedate;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //echodebug($arrtrigiatonkhodauky);

            if (!empty($arrtrigiatonkhodauky))
            {
                foreach ($arrtrigiatonkhodauky as $sid=>$arrsoluongbydate)
                {
                    $condition = array('category' => 42, 'vendor'=> $vid);
                    if ($sid >0)
                    {
                        $condition['outputstore'] = $sid;
                    }
                    if (!empty($arrsoluongbydate))
                    {
                        foreach ($arrsoluongbydate as $dttime=>$valuebydate)
                        {
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $condition, $dttime, (string)$valuebydate);
                            //$arrparentCategory[$parentCategory][$vid][Core_Stat::TYPE_STOCK_VALUE_BEGIN][$sid][$dttime] += $valuebydate;
                            //$inoutstoretype[Core_Stat::TYPE_STOCK_VALUE_BEGIN] = 'outputstore';
                        }
                    }
                }
            }break;
        }

        exit('THOAT CAHTE');

        $productVendorList          = Core_Vendor::getProductVendorFromCache(0,0,true);
        //echodebug($productVendorList[42]);
        $newlistproduct = array();
        foreach ($productVendorList[42] as $vid => $listproduct)
        {
            $newlistproduct = array_merge($newlistproduct, $listproduct);
        }
        echo '<p>-----CURRENT LIST: '.count($newlistproduct).'---------</p>';
        exit();

        $listcate = Core_Productcategory::getFullparentcategoryInfoFromCahe(1805);
        //array_keys()
        var_dump($listcate);
        exit();

        if (empty($_GET['pcid'])) return false;
        //$db3 = Core_Backend_Object::getDb();
        $rs = $this->registry->db->query('SELECT p_barcode FROM lit_product WHERE p_barcode !="" AND pc_id = '.$_GET['pcid']);
        $counter = 0;
        while ($r = $rs->fetch())
        {
            echo trim($r['p_barcode']).',';
            if ($counter == 500)
            {
                echo '<p>&nbsp;</p>';
                $counter = 0;
            }
            $counter++;
        }
        /*$storelistfromcache = Core_Store::getStoresFromCache(false);
        foreach ($storelistfromcache as $sid=>$sname)
        {
            $startdate = strtotime('2013-09-01');
            $getsale = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('outputstore' => $sid, 'category' => 42), $startdate, time() );
            $getsaletra = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VOLUME, array('inputstore' => $sid, 'category' => 42), $startdate, time() );
            echo 'STOREID: '.$sid.'--NAME: '.$sname.'---'.$getsale['2013/09/01'].':'.$getsaletra['2013/09/01'].'---'.$getsale['2013/09/02'].':'.$getsaletra['2013/09/01'];
        }
        exit('EXIT------');*/

        /*$db3 = Core_Backend_Object::getDb();
        $rs = $db3->query('select distinct p_barcode, s_id from lit_outputvoucher where ov_outputdate >=1377993600 AND ov_outputdate <=1378166399 And (ov_voucherisdelete = 0 OR ov_voucherdetailisdelete = 0 OR ov_iserror = 0)');
        $storelistfromcache = Core_Store::getStoresFromCache(false);
        $arraybarcode = array() ;
        $arraynobarcode = array()   ;
        while($row = $rs->fetch())
        {
            $myProduct = Core_Product::getProductIDByBarcode(trim($row['p_barcode']));
            $strim = trim($row['p_barcode']);
            if (empty($myProduct) && !in_array($strim, $arraybarcode))
            {
                echo $strim.'<br />';
                $arraybarcode[] = $strim;
            }
            /*$strim = trim($row['p_barcode']);
            if ($myProduct['p_isservice'] == 0 && $myProduct['pc_id'] == 42 && !empty($storelistfromcache[$row['s_id']]) && !in_array($strim, $arraybarcode))
            {
                echo $strim.'<br />';
                $arraybarcode[] = $strim;
            }/
            //else $arraynobarcode[] = $strim;
        }*/
        //echo 'KHONG CO : ';
        //echodebug($arraynobarcode);
    }

    public function checkbarcodeAction()
    {
        /*$erpbarcode = explode(',','2714122011100,2714122051100,2714122038900,2714122047800,2714122059400,2714122055700,2714122055800,2714122059200,2714122026900,2714122055900,2714122054200,2714122013300,2714122022100,2714122022800,2714122014300,2714122022500,2714122032700,2714122050600,2714122050700,2714122038000,2714122036900,2714122037200,2714122058900,2714122008000,2714122052400,2714122052300,2714122021500,2714122053000,2714122012300,2714122026200,2714122036600,2714122054400,2714122028500,2714122051200,2714122043200,2714122047400,2714122027500,2714122028000,2714122028200,2714122008700,2714122059300,2714122011300,2714122039800,2714122055600,2714122018800,2714122018900,2714122007900,2714122043100,2714122042100,2714122042200,2714122042400,2714122017400,2714122017300,2714122054800,2714122034100,2714122035100,2714122059000,2714122048800,2714122013900,2714122013700,2714122014100,2714122014000,2714122037400,2714122053600,2714122053500,2714122010900,2714122010600,2714122010700,2714211002800,2714211002200,2714122054100,2714122053200,2714122056000,2714122036200,2714122036300,2714122058400,2714122058500,2714122052200');
        $this->registry->db = $this->getDb();
        $getdb = $this->registry->db->query('SELECT p_id, pc_id, p_barcode FROM lit_product where p_barcode IN ("'.implode('","', $erpbarcode).'")');
        $listcategoryfromcache = Core_Productcategory::getProductlistFromCategory();
        $barcodewebs = $listcategoryfromcache[282];
        echodebug(count($erpbarcode));
        echodebug(count($listcategoryfromcache[282]));
        $arrbarcodenotexists = array();
        $erpbarcodeid = array();

        while($bp = $getdb->fetch())
        {
            if (!in_array($bp['p_id'], $erpbarcodeid))
            {
                $erpbarcodeid[] = trim($bp['p_id']);
            }
            //$erpbarcodeandid[trim($bp['p_id'])] = $bp['p_barcode'];
        }
        foreach ($barcodewebs as $bp)
        {
            if (!in_array($bp, $erpbarcodeid))
            {
                $arrbarcodenotexists[] = trim($bp);
            }
        }


        echodebug(count($arrbarcodenotexists));
        echo implode(',', $arrbarcodenotexists);
        $erpbarcodeandid = array();
        $getdb = $this->registry->db->query('SELECT p_id, pc_id, p_barcode FROM lit_product where p_id IN ('.implode(',', $arrbarcodenotexists).')');
        while ($row = $getdb->fetch())
        {
            $erpbarcodeandid[] = trim($row['p_barcode']);
        }
        echodebug(implode(',', $erpbarcodeandid));
        //sechodebug($erpbarcodeandid);
        exit();*/
        //echodebug(implode(',', $listcategoryfromcache[282]), true);
        set_time_limit(0);

        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '23:59'):strtotime('-1 month'));//strtotime('-1 month')
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '00:00'):time());//time());
        $startdate = strtotime(date('Y-m-d 00:00:01', $startdate));
        $enddate = strtotime(date('Y-m-d', $enddate));
        $enddate = strtotime('+1 day', $enddate);
        $pcid = (isset($_GET['pcid'])?$_GET['pcid']:42);
        $listproducts = Core_Productcategory::getProductlistFromCache($pcid);
        //$listcategoryfromcache = Core_Productcategory::getProductlistFromCategory($pcid);
        /*$counter = 0;
        foreach($listproducts as $pid => $item)
        {
            if ($counter % 500 == 0) echo '<p>-----</p>';
            echo $item['barcode'].',';
            $counter++;
        }

        echo '<p>----SO LUONT PRODUCT:'.count($listproducts).'------</p>';
        $exportproduct = explode(',','57412,60001,59690,60080,59856,60007,60008,60136,59339,58207,58133,58131,58091,58059,60511,60850,57585,60053,57514,57452,57445,57442,59353,59396,59409,59516,59569,59606,60799,59642,59647,59792,59848,59849,59894,59857,59863,59895,59953,60006,60056,60051,60052,60054,60058,60491,60494,60495,60539,60570,60681,60711,60712,60713,61063');
        $productcurrent = array_keys($listproducts);
        foreach ($exportproduct as $expid)
        {
            if (!in_array($expid, $productcurrent)) echo $expid.',';
        }*/
        //echodebug(array_keys($listproducts));

        //$data111 = Core_Stat::getDataList(array_merge($this->arrtypes, $this->arrtypesrefund), array('products' => array_keys($listproducts)), $startdate, $enddate );
        //echodebug(array_keys($data111));
        $dataidlist = array('product' => array_keys($listproducts),//,
                            //'groupstore' => 1,
                            //'store' => 999,
                            );
        $detailvalues = array('soluongthucban' , 'doanhthuthucte' , 'laigop', 'stonkho');
        $mastervalues = array('ssoluongthucban' , 'sdoanhthu' , 'sgiabantrungbinh' , 'sgiavontrungbinh', 'slaigop' , 'smargin' , 'stonkho' ,'ngaybanhang', 'stralai' , 'trigiacuoiky');
        $begindate = strtotime(date('Y-m', $startdate).'-01');
        $timer = new Timer();
        $timer->start();
        $data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , strtotime('+1 day', $enddate) , $begindate);
        echo '<br />SL Tra: '.$data['datamaster']['stralai'];
        echo '<br />SL: '.$data['datamaster']['ssoluongthucban'];
        echo '<br />DT: '.$data['datamaster']['sdoanhthu'];
        echo '<p>-------------------------------------------</p>';exit();
        $listproducts = Core_Stat::getproducthavereport($startdate, $enddate, $pcid);
        //echodebug($listproducts[$pcid]);
        $dataidlist = array('product' => $listproducts[$pcid],//,
                            //'groupstore' => 1,
                            //'store' => 999,
                            );
        $data = Core_Backend_Caculatereport::caculate($dataidlist , $detailvalues , $mastervalues , $startdate , strtotime('+1 day', $enddate) , $begindate);
        echo '<br />SL Tra: '.$data['datamaster']['stralai'];
        echo '<br />SL: '.$data['datamaster']['ssoluongthucban'];
        echo '<br />DT: '.$data['datamaster']['sdoanhthu'];
        echo '<p>-------------------------------------------</p>';
        echo '<p>---------------CHI TIET----------------------</p>';
        $sumchitiet = 0;
        /*foreach ($data['data'][0] as $pid => $listdates)
        {
            foreach ($listdates as $date=>$value)
            {
                echo '<br />NGAY: '.date('Y-m-d', $date).'. PID: '.$pid.'. SL: '.$value['soluongthucban'].'. DT: '.$value['doanhthuthucte'];
                $sumchitiet += $value['soluongthucban'];
            }
        }
        echo 'SUM CHI TIET: '.$sumchitiet;*/
        $timer->stop();
        echodebug($timer->get_exec_time());
        exit();


        $pcid = (isset($_GET['pcid'])?$_GET['pcid']:42);
        $listproducts = Core_Productcategory::getProductlistFromCache($pcid);
        //, 'inputstore' => $sid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter
        //, 'outputstore' => $sid, 'vendor' => $vendor, 'pricesegment' => $pricesegment, 'character' => $maincharacter
        $timer = new timer();
        $timer->start();
        echo '<p>----SO LUONT PRODUCT:'.count($listproducts).'------</p>';
        $conditionvol = array('products' => array_keys($listproducts) );
        $conditionvolreturn =   array('products' => array_keys($listproducts) );

        //so luong thuc ban
        $soluongban = Core_Stat::getDataList(Core_Stat::TYPE_SALE_ITEM_VOLUME, $conditionvol, $startdate, $enddate );
        echodebug($soluongban, true);
        $timer->stop();
        echo '<p>-------SO LUONG: '.$timer->get_exec_time().'</p>';
        //so luong tra lai tru vao thuc te
        $soluongtralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME, $conditionvolreturn, $startdate, $enddate );

        //doanhthu (chua co vat)
        $doanhthu = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, $conditionvol, $startdate, $enddate );

        //doanh thu tra lai duoc tru vao doanh thu
        $doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditionvolreturn, $startdate, $enddate );// $conditionvol

        //doanh thu tra lai duoc tru vao doanh thu
        //$doanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, $conditionvol, $startdate, $enddate );

        //thanh toan (co vat)
        $thanhtoan = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE, $conditionvol, $startdate, $enddate );

        //thanh toan tra lai
        $thanhtoantralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT, $conditionvolreturn, $startdate, $enddate );//$conditionvol

        //gia von ban
        $giavonban = Core_Stat::getData(Core_Stat::TYPE_SALE_COSTPRICE, $conditionvol, $startdate, $enddate );
        //gia von tra lai
        $giavontralai = Core_Stat::getData(Core_Stat::TYPE_REFUND_COSTPRICE, $conditionvolreturn, $startdate, $enddate );

        //gia von hang khuyen mai
        $giatrihangkhuyenmai = Core_Stat::getData(Core_Stat::TYPE_PROMOTION_COSTPRICE , $conditionvol, $startdate , $enddate );

        //ton kho dau ky
        $tonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VOLUME_BEGIN, $conditionvol, $begindate, $enddate ); // tinh tu ngay dau thang cua san pham

        //so luong nhap mua dau ky
        $soluongnhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME, $conditionvolreturn, $begindate, $enddate );

        //tri gia nhap mua dau ky
        $trigianhapmuadauky = Core_Stat::getData(Core_Stat::TYPE_INPUT_BEGINTERM_VALUE, $conditionvolreturn, $begindate, $enddate );

        //so luong xuat ban dau ky
        $soluongxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME, $conditionvol, $begindate, $enddate );

        //tri gia xuat ban dau ky
        $trigiaxuatbandauky = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE, $conditionvol, $begindate, $enddate );

        //nhap mua
        $nhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VOLUME, $conditionvolreturn, $startdate, $enddate );

        //nhap noi bo
        $nhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VOLUME, $conditionvolreturn, $startdate, $enddate );

        //nhap tra lai
        $nhaptralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME, $conditionvolreturn, $startdate, $enddate );

        //nhap khac
        $nhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VOLUME, $conditionvolreturn, $startdate, $enddate );

        //so luong xuat ban
        $xuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VOLUME, $conditionvol, $startdate, $enddate );

        //so luong xuat noi bo
        $xuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME, $conditionvol, $startdate, $enddate );

        //so luong xuat tra mua hang
        $xuattramuahang = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME, $conditionvol, $startdate, $enddate );

        //so luong xuat khac
        $xuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VOLUME, $conditionvol, $startdate, $enddate );

        //tri gia dau ky
        $trigiatonkhodauky = Core_Stat::getData(Core_Stat::TYPE_STOCK_VALUE_BEGIN, $conditionvol, $begindate, $enddate );

        //tri gia nhap mua
        $trigianhapmua = Core_Stat::getData(Core_Stat::TYPE_INPUT_VALUE, $conditionvolreturn, $startdate, $enddate );

        //tri gia nhap noi bo
        $trigianhapnoibo = Core_Stat::getData(Core_Stat::TYPE_INPUT_INTERNAL_VALUE, $conditionvolreturn, $startdate, $enddate );

        //tri gia nhap tra
        $trigianhaptra = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE, $conditionvolreturn, $startdate, $enddate );

        //tri gia nhap khac
        $trigianhapkhac = Core_Stat::getData(Core_Stat::TYPE_INPUT_OTHER_VALUE, $conditionvolreturn, $startdate, $enddate );

        //tri gia xuat ban
        $trigiaxuatban = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_VALUE, $conditionvol, $startdate, $enddate );

        //tri gia xuat noi bo
        $trigiaxuatnoibo = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE, $conditionvol, $startdate, $enddate );

        //tri gia xuat tra
        $trigiaxuattra = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE, $conditionvol, $startdate, $enddate );

        //tri gia xuat khac
        $trigiaxuatkhac = Core_Stat::getData(Core_Stat::TYPE_OUTPUT_OTHER_VALUE, $conditionvol, $startdate, $enddate );

        //so luong don hang
        $soluongdonhang = Core_Stat::getData(Core_Stat::TYPE_SALE_ORDER_VOLUME, $conditionvol, $startdate, $enddate );

        //so luot khach vao sieu thi
        $soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $startdate, $enddate );

        //lay diem thuong
        $diemchuan = Core_Stat::getData(Core_Stat::TYPE_PRODUCTREWARD, array('product' => $productid), $startdate, $enddate );

        /*$listproducts = array();
        $types = array(
            Core_Stat::TYPE_SALE_ITEM_VOLUME,
            Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT,
            Core_Stat::TYPE_SALE_ITEM_VALUE,
            Core_Stat::TYPE_SALE_COSTPRICE,
            Core_Stat::TYPE_PROMOTION_COSTPRICE,
            Core_Stat::TYPE_STOCK_VOLUME_BEGIN,
            Core_Stat::TYPE_OUTPUT_BEGINTERM_VOLUME,
            Core_Stat::TYPE_OUTPUT_BEGINTERM_VALUE,
            Core_Stat::TYPE_OUTPUT_VOLUME,
            Core_Stat::TYPE_OUTPUT_INTERNAL_VOLUME,
            Core_Stat::TYPE_OUTPUT_REFUND_SALE_VOLUME,
            Core_Stat::TYPE_OUTPUT_OTHER_VOLUME,
            Core_Stat::TYPE_STOCK_VALUE_BEGIN,
            Core_Stat::TYPE_OUTPUT_VALUE,
            Core_Stat::TYPE_OUTPUT_INTERNAL_VALUE,
            Core_Stat::TYPE_OUTPUT_REFUND_SALE_VALUE,
            Core_Stat::TYPE_OUTPUT_OTHER_VALUE,
            Core_Stat::TYPE_SALE_ORDER_VOLUME,
        );
        $typesrefund = array(
            Core_Stat::TYPE_INPUT_REFUND_REV_VOLUME,
            Core_Stat::TYPE_INPUT_REFUND_REV_VALUE,
            Core_Stat::TYPE_INPUT_REFUND_REV_VALUEVAT,
            Core_Stat::TYPE_REFUND_COSTPRICE,
            Core_Stat::TYPE_INPUT_BEGINTERM_VOLUME,
            Core_Stat::TYPE_INPUT_BEGINTERM_VALUE,
            Core_Stat::TYPE_INPUT_VOLUME,
            Core_Stat::TYPE_INPUT_INTERNAL_VOLUME,
            Core_Stat::TYPE_INPUT_REFUND_SALE_VOLUME,
            Core_Stat::TYPE_INPUT_OTHER_VOLUME,
            Core_Stat::TYPE_INPUT_VALUE,
            Core_Stat::TYPE_INPUT_INTERNAL_VALUE,
            Core_Stat::TYPE_INPUT_REFUND_SALE_VALUE,
            Core_Stat::TYPE_INPUT_OTHER_VALUE,
        );*/
        /* 2 keys nay phai tao rieng
        $soluotkhach = Core_Stat::getData(Core_Stat::TYPE_CUSTOMER_VIEWS, array('outputstore' => $sid), $startdate, $enddate );

                        //lay diem thuong
                        $diemchuan = Core_Stat::getData(Core_Stat::TYPE_PRODUCTREWARD, array('product' => $productid), $startdate, $enddate );
        */
        foreach ($listproducts as $product)
        {
            $listproducts[] = Core_Stat::getDataPath($types, $parameters, $datebegin = 0, $dateend = 0);
        }
        exit('END HERE');

        $recordperpage = 1000;

        $sql = 'SELECT count(distinct p_id) FROM lit_outputvoucher v';

        $pcid = (isset($_GET['pcid'])?$_GET['pcid']:44);
        /*$db3 = Core_Backend_Object::getDb();//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate']):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate']):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));//strtotime('-1 month')

        $startdate = strtotime(date('Y-m-d', $startdate).' 00:00:01');
        $enddate = strtotime(date('Y-m-d', $enddate).' 23:59:59');
        $enddatenotime = strtotime(date('Y-m-d', $enddate).' 00:00:01');
        while ($dt <= $enddatenotime)
        {
            $localDateBegin = mktime(0,0,0,date('m', $dt), date('d', $dt), date('Y', $dt));
            $localDateEnd = mktime(23,23,59,date('m', $dt), date('d', $dt), date('Y', $dt));

            $counter = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'outputvoucher WHERE ov_outputdate >='.$localDateBegin.' AND ov_outputdate <='.$localDateEnd.' AND ov_voucherisdelete = 0 AND ov_iserror = 0 AND ov_voucherdetailisdelete = 0')->fetchColumn(0);

            if ($counter > 0)
            {
                for ($i = 0; $i < $counter; $i+=1000)
                {
                    $getoutputvoucher = $db3->query('SELECT * FROM '.TABLE_PREFIX.'outputvoucher
                                                                    WHERE
                                                                    ov_outputdate >='.$localDateBegin.' AND
                                                                    ov_outputdate <='.$localDateEnd.' AND
                                                                    ov_voucherisdelete = 0 AND
                                                                    ov_iserror = 0 AND
                                                                    ov_voucherdetailisdelete = 0
                                                                    LIMIT '.$i.', 1000');
                    if (!empty($getoutputvoucher))
                    {
                        while($row = $getoutputvoucher->fetch())
                        {
                            if (empty($row['ov_applyproductid']))
                            {
                                $listoutputvouchers[$dt][$row['ov_outputvoucherid']][] = $row;
                            }
                            else
                            {
                                $listproductapplyoutputvoucher[$dt][trim($row['ov_applyproductid'])][$row['ov_outputvoucherid']][] = $row;
                            }
                        }
                        unset($row);
                        unset($getoutputvoucher);
                    }
                }
                unset($counter);
            }
        }


        $getbarcodelaptop = $*/
        $listproducts = Core_Productcategory::getProductlistFromCache($pcid);
        $listbarcode = array();
        foreach ($listproducts as $product)
        {
            $pbarcode = trim($product['barcode']);
            if (!in_array($pbarcode, $listbarcode))  $listbarcode[] = $pbarcode;
        }
        echo implode('<br />', $listbarcode);
    }

    public function movebeginminstockAction()
    {
        set_time_limit(0);
        $curmonth = (int)(isset($_GET['m']) ? $_GET['m']: 10);
        $curyear = (int)(isset($_GET['y']) ? $_GET['y']: 2013);
        $subsql = 'select sum(b_quantity) as b_quantity, avg(b_costprice) as b_costprice, b_imei, s_id, p_barcode, b_month, b_year, b_isnew, b_isshowproduct, b_orarowscn from lit_beginminstock_bk where b_month = '.$curmonth.' and b_year = '.$curyear.' group by b_imei, s_id, p_barcode, b_month, b_year, b_isnew,b_isshowproduct, b_orarowscn';
        $sql = 'select count(*) as total from ('.$subsql.') as totalsum';

        $db3 = Core_Backend_Object::getDb();//get db3

        $numrows = $db3->query($sql)->fetchColumn(0) + 1;
        if ($numrows >0)
        {
            $totalsum = 0;
            for ($i = 0; $i < $numrows; $i+=500)
            {
                $results = $db3->query($subsql .' LIMIT '.$i.', 500');
                while ($result = $results->fetch())
                {
                    $checker = Core_Backend_Beginminstock::getBeginminstocks(array('fpbarcode' => $result['p_barcode'],
                                                                                        'fsid' => $result['s_id'],
                                                                                        'fmonth' => $result['b_month'],
                                                                                        'fyear' => $result['b_year'],
                                                                                        'fimei' => $result['b_imei'],
                                                                                        'fisnew' => $result['b_isnew'],
                                                                                        //'fisshowproduct' => $result['b_isshowproduct'],
                                                                                        'forarowscn' => $result['b_orarowscn'],
                                                                                        ), 'id' , 'ASC', '0,1');
                    if (count($checker) == 0)
                    {
                        $myBeginminstock = new Core_Backend_Beginminstock();
                        $myBeginminstock->pbarcode = $result['p_barcode'];
                        $myBeginminstock->sid = $result['s_id'];
                        $myBeginminstock->imei = $result['b_imei'];
                        $myBeginminstock->month = $result['b_month'];
                        $myBeginminstock->year = $result['b_year'];
                        $myBeginminstock->quantity = $result['b_quantity'];
                        $myBeginminstock->costprice = $result['b_costprice'];
                        $myBeginminstock->isnew = $result['b_isnew'];
                        $myBeginminstock->isshowproduct = $result['b_isshowproduct'];
                        $myBeginminstock->orarowscn = $result['b_orarowscn'];
                        $myBeginminstock->addData();
                    }
                    else
                    {
                        echo $checker[0]->id.',';
                        $totalsum++;
                    }
                }
            }
            echodebug('SUM SO LUONG: '.$totalsum);
        }
    }

    public function compareproductAction()
    {
        global $db;
        set_time_limit(0);
        $db3 = Core_Backend_Object::getDb();//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));//strtotime('-1 month')
        $startdate = strtotime(date('Y-m-d', $startdate).' 00:00:01');
        $enddate = strtotime(date('Y-m-d', $enddate).' 23:59:59');

        //$pcid = (isset($_GET['pcid'])?$_GET['pcid']:42);
        //$listproducts = Core_Productcategory::getProductlistFromCache($pcid);
        $listproducts = array();
        $stmt = $db->query('SELECT p_barcode FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != ""');

        while($row = $stmt->fetch())
        {
            $listproducts[] = trim($row['p_barcode']);
        }
        unset($stmt);
        $finalproducts = array();

        $stmt = $db3->query('SELECT distinct p_barcode FROM '.TABLE_PREFIX.'outputvoucher WHERE ov_outputdate >= '.$startdate.' AND ov_outputdate <='.$enddate);

        while($row = $stmt->fetch())
        {
            $finalproducts[] = trim($row['p_barcode']);
        }
        unset($row);
        unset($stmt);
        $stmt = $db3->query('SELECT distinct p_barcode FROM '.TABLE_PREFIX.'inputvoucher WHERE iv_inputdate >= '.$startdate.' AND iv_inputdate <='.$enddate);

        while($row = $stmt->fetch())
        {
            $cbar = trim($row['p_barcode']);
            if (!in_array($cbar, $finalproducts)) $finalproducts[] = $cbar;
            unset($cbar);
        }
        unset($row);
        unset($stmt);
        $stmt = $db3->query('SELECT distinct p_barcode FROM '.TABLE_PREFIX.'outputvoucherreturn WHERE ovr_inputtime >= '.$startdate.' AND ovr_inputtime <='.$enddate);

        while($row = $stmt->fetch())
        {
            $cbar = trim($row['p_barcode']);
            if (!in_array($cbar, $finalproducts)) $finalproducts[] = $cbar;
            unset($cbar);
        }
        unset($row);
        unset($stmt);
        $finalproductarray = array();
        if (!empty($finalproducts))
        {
            foreach ($finalproducts as $pbarcode)
            {
                if (!in_array($pbarcode, $listproducts))
                {
                    //echo $pbarcode.'<br />';
                    $finalproductarray[] = $pbarcode;
                }
            }
        }
        unset($finalproducts);
        unset($listproducts);
        if (!empty($finalproductarray))
        {
            header('Content-Type: text/html; charset=utf-8');
            echo '<table cellspacing =0 cellpadding = 0 border = 1>';
            $totalproduct = count($finalproductarray) + 1;
            for ($i = 0 ; $i < $totalproduct ; $i+= 500)
            {
                $subpro = array_slice($finalproductarray, $i, 500);
                $sql = 'select PRODUCTID, PRODUCTNAME
                        from ERP.VW_PRODUCT_DM WHERE PRODUCTID IN (\''.implode('\',\'', $subpro).'\')';
                $oracle = new Oracle();
                $results = $oracle->query($sql);
                foreach ($results as $result)
                {
                    echo '<tr><td>'.$result['PRODUCTID'].'</td><td>'.$result['PRODUCTNAME'].'</td></tr>';
                }
            }
            echo '</table>';
        }
    }

    //cache luot view cua web hien tai
    public function cacheviewwebAction()
    {
        set_time_limit(0);
        $db3 = Core_Backend_Object::getDb();//get db3

        $timer = new Timer();
        $timer->start();
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        $counterAll = $db3->query('SELECT count(v_objectid) FROM '.TABLE_PREFIX.'view WHERE v_datecreated >='.$startdate.' AND v_datecreated <='.$enddate.' AND v_type='. Core_View::TYPE_PRODUCT.' AND v_objectid >0')->fetchColumn(0);

        for($i = 0; $i < $counterAll; $i+= 500)
        {
            $getproductlist = $db3->query('SELECT v_objectid FROM '.TABLE_PREFIX.'view WHERE v_datecreated >='.$startdate.' AND v_datecreated <='.$enddate.' AND v_type='. Core_View::TYPE_PRODUCT.' AND v_objectid >0 GROUP BY v_objectid LIMIT '.$i.', 500');//count(v_objectid) as countproduct,
            if ($getproductlist)
            {
                while($row = $getproductlist->fetch())
                {
                    $dttime = $startdate;
                    while($dttime <= $enddate)
                    {
                        $localDateBegin = mktime(0,0,0,date('m', $dttime), date('d', $dttime), date('Y', $dttime));
                        $localDateEnd = mktime(23,23,59,date('m', $dttime), date('d', $dttime), date('Y', $dttime));

                        $datavalues = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'view WHERE v_datecreated >='.$localDateBegin.' AND v_datecreated <='.$localDateEnd.' AND v_type='. Core_View::TYPE_PRODUCT.' AND v_objectid = '.$row['v_objectid'])->fetchColumn(0);

                        if ($datavalues > 0)
                        {
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_VIEW, array('product' => (int)$row['v_objectid']), date('Y/m/d', $dttime), $datavalues);
                        }

                        $dttime = strtotime('+1 day', $dttime);
                    }
                }
            }
        }
        $timer->stop();
        echo 'END TIME: '. $timer->get_exec_time();
    }

    public function getduplicateproductAction()
    {
        set_time_limit(0);
        header('Content-Type: text/html; charset=utf-8');
        $db53 = $this->getDb('db_replicate02');

        $getproductlist = $db53->query('SELECT count(p_barcode), p_barcode FROM '.TABLE_PREFIX.'product WHERE p_barcode !="" group by p_barcode having count(p_barcode) > 1');
        $arr_barcode = array();
        if ($getproductlist)
        {
            while ($row = $getproductlist->fetch())
            {
                $arr_barcode[] = trim($row['p_barcode']);
            }
        }
        unset($getproductlist);
        if (!empty($arr_barcode))
        {
            echo '<table border="1" align="center"><tr><th>STT</th><th>Barcode</th><th>Mã sản phẩm</th><th>Mã ngành hàng</th><th>Tên danh mục</th><th>Tên sản phẩm</th></tr>';

            $listproducts = $db53->query('SELECT p_id, p_barcode, p_name, pc_name, c.pc_id FROM '.TABLE_PREFIX.'product p INNER JOIN '.TABLE_PREFIX.'productcategory c ON p.pc_id = c.pc_id WHERE p_barcode IN ("'.implode('","', $arr_barcode).'")');

            if ($listproducts)
            {
                $cnt = 1;
                while ($row = $listproducts->fetch())
                {
                    echo '<tr>';
                    echo '<td>'.$cnt++.'</td>';
                    echo '<td>'.trim($row['p_barcode']).'</td>';
                    echo '<td>'.trim($row['p_id']).'</td>';
                    echo '<td>'.trim($row['pc_id']).'</td>';
                    echo '<td>'.trim($row['pc_name']).'</td>';
                    echo '<td>'.trim($row['p_name']).'</td>';
                    echo '</tr>';
                }
            }

            echo '</table>';

        }
    }

    public function counterorderAction()
    {
        set_time_limit(0);

        $timer = new Timer();
        $timer->start();
        $db3 = $this->getDb('db_replicate02');//get db3
        $enddate = (int)(isset($_GET['enddate'])?Helper::strtotimedmy($_GET['enddate'], '23:59'):time());//time());
        $startdate = (int)(isset($_GET['startdate'])?Helper::strtotimedmy($_GET['startdate'], '00:00'):(strtotime(date('Y').'-'.date('n', $enddate).'-01')));

        $storelistfromcache = Core_Store::getStoresFromCache(false);

        $dt = $startdate;
        $listallProducts = array();
        $listall2Products = array();

        $counterreturn = 0;

        while($dt <= $enddate)
        {
            $localDateBegin = mktime(0,0,0,date('m', $dt), date('d', $dt), date('Y', $dt));
            $localDateEnd = mktime(23,23,59,date('m', $dt), date('d', $dt), date('Y', $dt));
            $sql = 'SELECT count( a.o_saleorderid ) as totalorders , o_originatestoreid, od_productid, o_createdate FROM lit_archivedorder a
                    INNER JOIN lit_archivedorder_detail od ON od.od_saleorderid = a.o_saleorderid
                    WHERE o_createdate >= '.$localDateBegin.' AND o_createdate <= '.$localDateEnd.'
                    GROUP BY o_originatestoreid, od_productid, o_createdate';

            //echodebug(date('Y-m-d H:i:s',$localDateBegin).'----'.date('Y-m-d H:i:s',$localDateEnd));
            //echodebug($sql, true);
            $results = $db3->query($sql);

            $dtdate = date('Y/m/d', $dt);

            if (!empty($results))
            {
                while ($row = $results->fetch())
                {
                    $myProduct = Core_Product::getProductIDByBarcode(trim($row['od_productid']));
                    if (!empty($myProduct) && $myProduct['p_id'] > 0 && $myProduct['p_isservice'] == 0 && !empty($storelistfromcache[$row['o_originatestoreid']]))
                    {
                        $listallProducts[$dtdate]['product'][$myProduct['p_id']][] = $row;
                        $listall2Products[$dtdate]['outputstore']['product'][$row['o_originatestoreid']][$myProduct['p_id']][] = $row;
                        $counterreturn++;
                    }
                }
                unset($row);
            }
            unset($results);
            unset($sql);


            $dt = strtotime('+1 day', $dt);
        }

        unset($storelistfromcache);

        if (!empty($listallProducts))
        {

            foreach($listallProducts as $dtdate=>$listdatedata)
            {
                $totalcounterinday = 0;
                foreach ($listdatedata as $keytext => $listproductids)
                {
                    foreach ($listproductids as $pid => $listdata)
                    {
                        $totalcounter = 0;
                        $arrconditon = array($keytext => $pid);
                        foreach ($listdata as $row)
                        {
                            $totalcounter+= $row['totalorders'];
                            $totalcounterinday += $row['totalorders'];
                            //$totalcounterall += $row['totalorders'];
                        }
                        Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, $arrconditon, $dtdate, $totalcounter );
                        unset($arrconditon);
                    }
                }
                Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, array(), $dtdate, $totalcounterinday );
            }
        }
        unset($listallProducts);

        if (!empty($listall2Products))
        {
            foreach($listall2Products as $dtdate=>$listdatedata)
            {
            foreach ($listdatedata as $keytext1 => $liststoreproducts)
            {
                foreach ($liststoreproducts as $keytext => $liststoreids)
                {
                    foreach ($liststoreids as $sid => $listproductids)
                    {
                        foreach ($listproductids as $pid => $listdata)
                        {
                            $totalcounter = 0;
                            $arrconditon = array($keytext1 => $sid, $keytext => $pid);
                            foreach ($listdata as $row)
                            {
                                $totalcounter+= $row['totalorders'];
                            }
                            Core_Stat::setDataSaleInDate(Core_Stat::TYPE_SALE_ORDER_VOLUME, $arrconditon, $dtdate, $totalcounter );
                            unset($arrconditon);
                        }
                    }
                }
            }
            }
        }
        unset($listall2Products);
        $timer->stop();

        unset($db3);

        /*$db3 = $this->getDb('db3');
        //luuu ngay cap nhat cache of index vo cache
        $getdatecreated = $db3->query('SELECT c_datecreated FROM '.TABLE_PREFIX.'crontask WHERE c_controller = \'reportingnew\' and c_action = \'syncproductreward\' ORDER BY c_datecreated DESC LIMIT 0,1')->fetch();
        if (!empty($getdatecreated))
        {
            $cacheredis = new Cacher('report_timeupdatereport', Cacher::STORAGE_REDIS);
            $cacheredis->set($getdatecreated['c_datecreated'], 0);
        }*/

        echo 'ROWS: '.$counterreturn.'. Time: '.$timer->get_exec_time();
        unset($timer);
    }

    public function cacherecentweekviewdoanhthuAction()
    {
        set_time_limit(0);
        $enddate = time();
        $startdate = strtotime('-7 day', $enddate);

        $timer = new Timer();
        $timer->start();

        $allproducthavebarcode = Core_Stat::getAllProductHaveBarcode();

        if (!empty($allproducthavebarcode)) {
            foreach ($allproducthavebarcode as $pid) {

                $getlistviews = Core_Stat::getData(Core_Stat::TYPE_VIEW, array('product' => $pid), $startdate, $enddate);
                if (!empty($getlistviews)) {
                    $dataviewsave = array();
                    $dt = $startdate;
                    while ($dt <= $enddate) {
                        $date = date('Y/m/d', $dt);
                        if (!empty($dataviewsave[$date]))
                        {
                            $dataviewsave[] = $dataviewsave[$date];
                        }
                        else $dataviewsave[] = 0;
                        $dt = strtotime('+1 day', $dt);
                    }

                    $myCacher = new Cacher('productsummaryview_'.$pid, Cacher::STORAGE_MEMCACHED);
                    $myCacher->set(implode(',', $dataviewsave), 0);
                    unset($dataviewsave);
                    unset($dt);
                }
                unset($getlistviews);
                $getlistdoanhthuban = Core_Stat::getData(Core_Stat::TYPE_SALE_ITEM_VALUE_NOVAT, array('product' => $pid), $startdate, $enddate);
                $getlistdoanhthutralai = Core_Stat::getData(Core_Stat::TYPE_INPUT_REFUND_REV_VALUE, array('product' => $pid), $startdate, $enddate);
                if (!empty($getlistdoanhthuban) || !empty($getlistdoanhthutralai)) {
                    $dataviewsave = array();
                    $dt = $startdate;
                    while ($dt <= $enddate) {
                        $date = date('Y/m/d', $dt);
                        $doanhthu = 0;
                        if (!empty($getlistdoanhthuban[$date]))
                        {
                            $doanhthu = $getlistdoanhthuban[$date];
                        }
                        if (!empty($getlistdoanhthutralai[$date]))
                        {
                            $doanhthu -= $getlistdoanhthutralai[$date];
                        }
                        $dt = strtotime('+1 day', $dt);
                        $dataviewsave[] = $doanhthu;
                    }

                    $myCacher = new Cacher('productsummarydoanhthu_'.$pid, Cacher::STORAGE_MEMCACHED);

                    $myCacher->set(implode(',', $dataviewsave), 0);
                    unset($dataviewsave);
                    unset($dt);
                }
                unset($getlistdoanhthuban);
                unset($getlistdoanhthutralai);

            }
        }

        $timer->stop();
        echo $timer->get_exec_time();
    }
}
//desc sort
function sortdoanhthu($p1, $p2)
{
    if ($p1['doanhthu'] > $p2['doanhthu']) return -1;
    elseif($p1['doanhthu'] < $p2['doanhthu']) return 1;
    else return 0;
}

function sortsoluong($p1, $p2)
{
    if ($p1['soluong'] > $p2['soluong']) return -1;
    elseif($p1['soluong'] < $p2['soluong']) return 1;
    else return 0;
}

function sortlaigop($p1, $p2)
{
    if ($p1['laigop'] > $p2['laigop']) return -1;
    elseif($p1['laigop'] < $p2['laigop']) return 1;
    else return 0;
}

function sorttraffic($p1, $p2)
{
    if ($p1['traffic'] > $p2['traffic']) return -1;
    elseif($p1['traffic'] < $p2['traffic']) return 1;
    else return 0;
}
