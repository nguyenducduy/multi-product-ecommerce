<?php
Class Controller_Cron_Product extends Controller_Cron_Base
{
	public function indexAction()
	{

	}

	/**
     * [Dong bo so luong san pham tu ERP]
     * @return [type] [description]
     */
    public function syncproductstockoldAction()
    {
    	$number = 0;

        $recordPerPage = 500;
        $oracle = new Oracle();
        $sql = 'SELECT Count(*) FROM ERP.VW_CURRENTINSTOCK_DM';
        $productStockList = $oracle->query($sql);

        $countAll = $oracle->query($sql);
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        //get max revision current
        $maxRevision = Core_ProductStat::getMaxRevision('pst_instockrevision');

        for($i = 1 ; $i <= $page ; $i++)
        {

            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sqlSelect = 'SELECT * FROM ( SELECT ci.*, ROWNUM r FROM ERP.VW_CURRENTINSTOCK_DM ci)  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sqlSelect);

            foreach($result as $res)
            {
                if(strlen((string)$res['PRODUCTID']) > 0)
                {
                    //kiem tra xem id nay da co trong danh sach hay chua ?
                    $myProductStock = new Core_ProductStock();
                    $myProductStock->getProductStockByBarcode((string)$res['PRODUCTID'], (int)$res['STOREID']);

                    if($myProductStock->id > 0)
                    {
                        $myProductStock->quantity = (int)$res['QUANTITY'];

                        $myProductStock->updateData();
                    }
                    else
                    {
                        $myProductStock->pbarcode = (string)$res['PRODUCTID'];
                        $myProductStock->sid = (int)$res['STOREID'];
                        $myProductStock->quantity = (int)$res['QUANTITY'];


                        $myProductStock->addData();
                    }

                    //cap nhat revision cua stock
                    $myProductStat = new Core_ProductStat();
                    $myProductStat->getProductStatByBarcode((string)$res['PRODUCTID']);

                    if($myProductStat->id > 0)
                    {
                        if($myProductStat->instockrevision < $maxRevision + 1)
                        {
                            $myProductStat->instockrevision = $maxRevision + 1;
                            $stmt = $myProductStat->updateData();
                            if($stmt)
                                $number++;
                        }
                    }
                    else
                    {
                        $number++;
                    }
                }
            }
        }

        echo 'so luong record duoc thuc thi : ' . $number;
    }


    public function syncproductstockpriceAction()
    {
        //get all product avalibe
        set_time_limit(0);
        $counter = 0;
        $counteroracle = 0;
        $sql = 'SELECT p_barcode , p_id FROM '.TABLE_PREFIX.'product
                WHERE p_onsitestatus > 0 AND p_barcode != ""';
        $stmt = $this->registry->db->query($sql);

        $timer = new Timer();

        $timer->start();
        $i = 0;
        while($row = $stmt->fetch())
        {
            $oracle = new Oracle();
            $sql = 'select ci.* from ERP.vw_currentinstock_dm ci inner join ERP.VW_PM_STORE_DM s ON ci.STOREID = s.STOREID where ci.productid = \'' . $row['p_barcode'] .'\' and s.ISSALESTORE = 1';

            $counteroracle++;

            $results = $oracle->query($sql);

            if(count($results) > 0)
            {
				$erpreturnstore = array(); # array contain store return from ERP
                foreach($results as $res)
                {
					$erpreturnstore[] = (int)$res['STOREID'];
                    $countProductstock = Core_ProductStock::getProductStocks(array('fpbarcode' =>$row['p_barcode'] , 'fsid' => (int)$res['STOREID']) , 'id' , 'ASC', '');

                    if(count($countProductstock) > 0)
                    {
                        if($res['QUANTITY'] != $countProductstock[0]->quantity)
                        {
                            $sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
                            SET ps_quantity = ?,
                                ps_datemodified = ?
                            WHERE p_barcode = ? AND s_id = ?';

                            $stmt1 = $this->registry->db->query($sql, array(
                                    (int)$res['QUANTITY'],
                                    time(),
                                    $row['p_barcode'],
                                    (int)$res['STOREID']
                                    ));

                            if($stmt1)
                            {
                                $counter++;
                                unset($stmt1);
                            }
                        }
                    }
                    else
                    {
                         $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stock (
                                                                    p_barcode,
                                                                    s_id,
                                                                    ps_quantity
                                                                    )
                                                                VALUES(?, ?, ?)';

                        $stmt1 = $this->registry->db->query($sql, array(
                                $row['p_barcode'],
                                 (int)$res['STOREID'],
                                (int)$res['QUANTITY']
                                ));

                        if($stmt1)
                        {
                            $counter++;
                            unset($stmt1);
                        }
                    }
                }

				if(count($erpreturnstore) > 0)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock SET ps_quantity = 0 , ps_datemodified = ?  WHERE p_barcode = ? AND s_id NOT IN('.  implode(',', $erpreturnstore).')';

					$this->registry->db->query($sql , array(time(),
															$row['p_barcode']
														));
				}

                unset($results);

                 //lay thong tin cua san pham mau ton kho
                $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$row['p_id']), 'id', 'ASC');
                if(count($productcolors) > 0)
                {
                    foreach ($productcolors as $productcolor)
                    {
                        $sql = 'SELECT p_barcode FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
                        $row2 = $this->registry->db->query($sql , array($productcolor->piddestination))->fetch();

                        $sql = 'select ci.* from ERP.vw_currentinstock_dm ci inner join ERP.VW_PM_STORE_DM s ON ci.STOREID = s.STOREID where ci.productid = \'' . $row2['p_barcode'] .'\' and s.ISSALESTORE = 1';

                         $counteroracle++;

                        $results = $oracle->query($sql);

                        if(count($results) > 0)
                        {
                            foreach($results as $res)
                            {
                                $countProductstock = Core_ProductStock::getProductStocks(array('fpbarcode' =>$row2['p_barcode'] , 'fsid' => (int)$res['STOREID']) , 'id' , 'ASC', '');
                                if(count($countProductstock) > 0)
                                {
                                    if($res['QUANTITY'] != $countProductstock[0]->quantity)
                                    {
                                        $sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
                                        SET ps_quantity = ?,
                                            ps_datemodified = ?
                                        WHERE p_barcode = ? AND s_id = ?';

                                        $stmt1 = $this->registry->db->query($sql, array(
                                                (int)$res['QUANTITY'],
                                                time(),
                                                $row2['p_barcode'],
                                                (int)$res['STOREID']
                                                ));

                                        if($stmt1)
                                        {
                                            $counter++;
                                            unset($stmt1);
                                        }
                                    }
                                }
                                else
                                {
                                     $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stock (
                                                                                p_barcode,
                                                                                s_id,
                                                                                ps_quantity
                                                                                )
                                                                            VALUES(?, ?, ?)';

                                    $stmt1 = $this->registry->db->query($sql, array(
                                            $row2['p_barcode'],
                                             (int)$res['STOREID'],
                                            (int)$res['QUANTITY']
                                            ));

                                    if($stmt1)
                                    {
                                        $counter++;
                                        unset($stmt1);
                                    }
                                }
                            }
                            unset($results);
                            unset($row2);
                        }
                        else
                        {
                            $sql = 'UPDATE '. TABLE_PREFIX . 'product_stock
                                    SET ps_quantity = ?,
                                        ps_datemodified = ?
                                        WHERE p_barcode = ?';
                             $stmt1 = $this->registry->db->query($sql, array(
                                                    0,
                                                    time(),
                                                    $row2['p_barcode']
                                                    ));

                            if($stmt1)
                            {
                                $counter++;
                                unset($stmt1);
                            }
                        }
                    }
                }
            }
            else
            {
                $sql = 'UPDATE '. TABLE_PREFIX . 'product_stock
                        SET ps_quantity = ?,
                            ps_datemodified = ?
                            WHERE p_barcode = ?';
                 $stmt1 = $this->registry->db->query($sql, array(
                                        0,
                                        time(),
                                        $row['p_barcode']
                                        ));

                if($stmt1)
                {
                    $counter++;
                    unset($stmt1);
                }
            }
            ////////////////////////////////////////////

            /*$sql = 'SELECT pp.* FROM ERP.VW_PRICE_PRODUCT_DM pp
                    WHERE pp.PRODUCTID = \'' . $row['p_barcode'].'\'';*/
            $today = strtoupper(date('d-M-y' , strtotime('-15 day')));
            $sql = 'select P.UPDATEDPRICEUSER,P.PRICEAREAID, P.OUTPUTTYPEID, p.UPDATEDPRICEDATE ,P.PRODUCTID, P.SALEPRICE, P.ISPRICECONFIRMED, S.STOREID , S.AREAID, S.PROVINCEID , P.COSTPRICE
					from ERP.VW_PRICE_PRODUCT_DM P
					INNER JOIN ERP.VW_PM_STORE_DM S ON S.PRICEAREAID = P.PRICEAREAID
					where P.ISPRICECONFIRMED = 1 AND P.PRODUCTID =\'' .$row['p_barcode']. '\' AND P.UPDATEDPRICEDATE >= TO_DATE(\''.$today.'\')';

            $results = $oracle->query($sql);
            //echodebug($results,true);

            $counteroracle++;

            //xoa thong tin cu ve gia cua san pham
            /*$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price WHERE p_barcode = ?';
            $rowCounts2 = $this->registry->db->query($sql, array($row['p_barcode']));*/

            foreach($results as $res)
            {
                $countProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $row['p_barcode'] , 'fpaid' => $res['PRICEAREAID'] , 'fpoid' => $res['OUTPUTTYPEID'], 'fsid' => $res['STOREID'] ,'faid' => $res['AREAID'] , 'frid' => $res['PROVINCEID']),'id','ASC','');

                if(count($countProductPrice) > 0)
                {
                    if($res['SALEPRICE'] > 100 && $res['SALEPRICE'] != $countProductPrice[0]->sellprice)
                    {
                        $sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
                                SET pp_sellprice = ?,
                                    pp_discount = ?,
                                    pp_confirm = ?,
                                    tgdd_uid = ?,
                                    pp_datemodified = ?
                                WHERE p_barcode = ?  AND ppa_id = ? AND po_id = ? AND s_id = ? AND a_id = ? AND r_id = ?';
                        $stmt1 = $this->registry->db->query($sql , array((float)$res['SALEPRICE'],
                                                            (int)$res['DISCOUNT'],
                                                            (int)$res['ISPRICECONFIRMED'],
                                                            (int)$res['UPDATEDPRICEUSER'],
                                                            time(),
                                                            $row['p_barcode'] ,
                                                            $res['PRICEAREAID'],
                                                            $res['OUTPUTTYPEID'],
                                                            $res['STOREID'],
                                                            $res['AREAID'],
                                                            $res['PROVINCEID']
                                                            ));

                        if($stmt1)
                        {
                            unset($stmt1);
                            //cap nhat gia goc cua san pham
                            $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                                    SET p_unitprice = ?
                                    WHERE p_barcode = ?';
                            $stmt1 = $this->registry->db->query($sql, array((float)$res['COSTPRICE'],
                                                                            $row['p_barcode']
                                                                               ));
                            if($stmt1)
                            {
                                $counter++;
                                unset($stmt1);
                            }
                        }
                    }
                }
                elseif($res['SALEPRICE'] > 100)
                {
                    $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price (
                                                            tgdd_uid,
                                                            p_id,
                                                            p_barcode,
                                                            ppa_id,
                                                            s_id,
                                                            a_id,
                                                            r_id,
                                                            po_id,
                                                            pp_sellprice,
                                                            pp_discount,
                                                            pp_confirm
                                                            )
                                                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $stmt1 = $this->registry->db->query($sql , array(
                                                            (int)$res['UPDATEDPRICEUSER'],
                                                            (int)$res['PRODUCTIDREF'],
                                                            trim($row['p_barcode']),
                                                            (int)$res['PRICEAREAID'],
                                                            $res['STOREID'],
                                                            $res['AREAID'],
                                                            $res['PROVINCEID'],
                                                            (int)$res['OUTPUTTYPEID'],
                                                            (float)$res['SALEPRICE'],
                                                            (int)$res['DISCOUNT'],
                                                            (int)$res['ISPRICECONFIRMED'],
                                                            ));

                    if($stmt1)
                    {
                        $counter++;
                        unset($stmt1);
                        //cap nhat gia goc cua san pham
                        $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                                    SET p_unitprice = ?
                                    WHERE p_barcode = ?';
                        $stmt1 = $this->registry->db->query($sql, array((float)$res['COSTPRICE'],
                                                                            $row['p_barcode']
                                                                               ));
                        if($stmt1)
                        {
                            $counter++;
                            unset($stmt1);
                        }
                    }
                }
            }

            unset($results);
            //lay thong tin cua san pham mau gia
            $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$row['p_id']), 'id', 'ASC');
            if(count($productcolors) > 0)
            {
                foreach ($productcolors as $productcolor)
                {
                    $sql = 'SELECT p_barcode FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
                    $row2 = $this->registry->db->query($sql , array($productcolor->piddestination))->fetch();

                    $today = strtoupper(date('d-M-y' , time()));
                    $sql = 'select P.UPDATEDPRICEUSER,P.PRICEAREAID, P.OUTPUTTYPEID, p.UPDATEDPRICEDATE ,P.PRODUCTID, P.SALEPRICE, P.ISPRICECONFIRMED, S.STOREID , S.AREAID, S.PROVINCEID , P.COSTPRICE
                            from ERP.VW_PRICE_PRODUCT_DM P
                            INNER JOIN ERP.VW_PM_STORE_DM S ON S.PRICEAREAID = P.PRICEAREAID
                            where P.ISPRICECONFIRMED = 1 AND P.PRODUCTID =\'' .$row2['p_barcode']. '\' AND P.UPDATEDPRICEDATE >= TO_DATE(\''.$today.'\')';

                    $results = $oracle->query($sql);
                    //echodebug($results,true);

                    $counteroracle++;

                    //xoa thong tin cu ve gia cua san pham
                    $sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price WHERE p_barcode = ?';
                    $rowCounts2 = $this->registry->db->query($sql, array($row2['p_barcode']));

                    foreach($results as $res)
                    {
                        $countProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $row2['p_barcode'] , 'fpaid' => $res['PRICEAREAID'] , 'fpoid' => $res['OUTPUTTYPEID'], 'fsid' => $res['STOREID'] ,'faid' => $res['AREAID'] , 'frid' => $res['PROVINCEID']),'id','ASC','');

                        if(count($countProductPrice) > 0)
                        {
                            if($res['SALEPRICE'] > 100 && $res['SALEPRICE'] != $countProductPrice[0]->sellprice)
                            {
                                $sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
                                        SET pp_sellprice = ?,
                                            pp_discount = ?,
                                            pp_confirm = ?,
                                            tgdd_uid = ?,
                                            pp_datemodified = ?
                                        WHERE p_barcode = ?  AND ppa_id = ? AND po_id = ? AND s_id = ? AND a_id = ? AND r_id = ?';
                                $stmt1 = $this->registry->db->query($sql , array((float)$res['SALEPRICE'],
                                                                    (int)$res['DISCOUNT'],
                                                                    (int)$res['ISPRICECONFIRMED'],
                                                                    (int)$res['UPDATEDPRICEUSER'],
                                                                    time(),
                                                                    $row2['p_barcode'] ,
                                                                    $res['PRICEAREAID'],
                                                                    $res['OUTPUTTYPEID'],
                                                                    $res['STOREID'],
                                                                    $res['AREAID'],
                                                                    $res['PROVINCEID']
                                                                    ));

                                if($stmt1)
                                {
                                    unset($stmt1);
                                    //cap nhat gia goc cua san pham
                                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                                            SET p_unitprice = ?
                                            WHERE p_barcode = ?';
                                    $stmt1 = $this->registry->db->query($sql, array((float)$res['COSTPRICE'],
                                                                                    $row2['p_barcode']
                                                                                       ));
                                    if($stmt1)
                                    {
                                        $counter++;
                                        unset($stmt1);
                                    }
                                }
                            }
                        }
                        elseif ($res['SALEPRICE'] > 100)
                        {
                            $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price (
                                                                       tgdd_uid,
                                                                        p_id,
                                                                        p_barcode,
                                                                        ppa_id,
                                                                        s_id,
                                                                        a_id,
                                                                        r_id,
                                                                        po_id,
                                                                        pp_sellprice,
                                                                        pp_discount,
                                                                        pp_confirm
                                                                        )
                                                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                            $stmt1 = $this->registry->db->query($sql , array(
                                                                    (int)$res['UPDATEDPRICEUSER'],
                                                                    (int)$res['PRODUCTIDREF'],
                                                                    trim($row2['p_barcode']),
                                                                    (int)$res['PRICEAREAID'],
                                                                    $res['STOREID'],
                                                                    $res['AREAID'],
                                                                    $res['PROVINCEID'],
                                                                    (int)$res['OUTPUTTYPEID'],
                                                                    (float)$res['SALEPRICE'],
                                                                    (int)$res['DISCOUNT'],
                                                                    (int)$res['ISPRICECONFIRMED'],
                                                                    ));

                            if($stmt1)
                            {
                                $counter++;
                                unset($stmt1);
                                //cap nhat gia goc cua san pham
                                $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                                            SET p_unitprice = ?
                                            WHERE p_barcode = ?';
                                $stmt1 = $this->registry->db->query($sql, array((float)$res['COSTPRICE'],
                                                                                    $row2['p_barcode']
                                                                                       ));
                                if($stmt1)
                                {
                                    $counter++;
                                    unset($stmt1);
                                }
                            }
                        }
                    }
                    unset($row2);
                }
            }
            ///////////////////////////////////////////////
            $i++;
            unset($row);
            //if($i==10) break;
        }

        $timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';
        //echo 'i : '.$i . '<br />';
        //echo 'Tong so record thuc hien duoc tren mysql la : ' . $counter . '<br />';
        echo 'Tong so record truy van tren oracle : ' . $counteroracle;

        /////UPDATE PRICE
        $this->updateproductpriceAction();

        //////UPDATE STOSCK
        $this->updateproductstockAction();
    }


    public function syncproductpriceAction()
    {
         //get all product avalibe
        set_time_limit(0);
        $counter = 0;
        $sql = 'SELECT p_barcode FROM '.TABLE_PREFIX.'product
                WHERE p_onsitestatus = ? AND p_barcode != ""';
        $stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

        $timer = new Timer();

        $timer->start();
        $i = 0;
        while($row = $stmt->fetch())
        {
            $oracle = new Oracle();

            $sql = 'SELECT pp.* FROM ERP.VW_PRICE_PRODUCT_DM pp
                    WHERE pp.PRODUCTID = \'' . $row['p_barcode'].'\'';

            $results = $oracle->query($sql);

            foreach($results as $res)
            {
                $sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
                            SET pp_sellprice = ?,
                                pp_discount = ?,
                                pp_datemodified = ?
                            WHERE p_barcode = ?';
                $stmt1 = $this->registry->db->query($sql , array((float)$res['SALEPRICE'],
                                                    (int)$res['DISCOUNT'],
                                                    time(),
                                                    $row['p_barcode']
                                                    ));

                if($stmt1)
                {
                    $counter++;
                    unset($stmt1);
                }
            }

            $i++;

            //if($i==300) break;
        }

        $timer->stop();
        echo 'time : ' . $timer->get_exec_time() . '<br />';
        echo 'i : '.$i . '<br />';
        echo 'Tong so record thuc hien duoc la : ' . $counter;


    }

    public function syncproductpriceoldAction()
    {
    	   $number = 0;
        $recordPerPage = 1000;
        $oracle = new Oracle();
        $sql = 'SELECT Count(*) FROM ERP.VW_PRICE_PRODUCT_DM';
        $productStockList = $oracle->query($sql);

        $countAll = $oracle->query($sql);
        foreach($countAll as $count)
        {
            $total = $count['COUNT(*)']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        //get max revision current
        $maxRevision = Core_ProductStat::getMaxRevision('pst_pricerevision');

        $today = strtoupper(date('d-M-y' , time()));

        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($result);

            set_time_limit(0);

            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $sql = 'SELECT * FROM ( SELECT pp.*, ROWNUM r FROM ERP.VW_PRICE_PRODUCT_DM pp WHERE pp.UPDATEDPRICEDATE >= TO_DATE(\' '.$today.' \'))  WHERE r > '.$start.' AND r <= '.$end.'';

            $result = $oracle->query($sql);

            //echo $sql;die();

            //echodebug($result,true);

            foreach($result as $res)
            {
                if((string)$res['PRODUCTID'] > 0)
                {
                    //echodebug($res['UPDATEDPRICEDATE'],true);
                    //chuyen doi nay cap nhat gia
                    if($res['UPDATEDPRICEDATE'] != '')
                    {
                        $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $res['UPDATEDPRICEDATE']);
                        $date =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
                    }
                    else
                    {
                        $date = time();
                    }

                    $myProductPrice = new Core_Productprice();
                    $myProductPrice->getProductPriceByBarcode((string)$res['PRODUCTID'], (int)$res['PRODUCTIDREF']);
                    if($myProductPrice->id > 0)
                    {
                        $myProductPrice->sellprice =  (float)$res['SALEPRICE'];
                        $myProductPrice->discount =  (int)$res['DISCOUNT'];
                        $myProductPrice->datemodified = $date;

                        $myProductPrice->updateData();
                    }
                    else
                    {
                         //chuyen doi nay cap nhat gia
                        if($res['UPDATEDPRICEDATE'] != '')
                        {
                            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $res['UPDATEDPRICEDATE']);
                            $date =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
                        }
                        else
                        {
                            $date = time();
                        }


                        $myProductPrice = new Core_ProductPrice();

                        $myProductPrice->pbarcode = (string)$res['PRODUCTID'];
                        $myProductPrice->ppa = (int)$res['PRICEAREAID'];
                        $myProductPrice->poid = (int)$res['OUTPUTTYPEID'];
                        $myProductPrice->sellprice = $res['SALEPRICE'];
                        $myProductPrice->discount = (int)$res['DISCOUNT'];
                        $myProductPrice->datemodified = $date;

                        $myProductPrice->addData();
                    }
                    // //cap nhat version cua gia
                    // $myProductStat = new Core_ProductStat();
                    // $myProductStat->getProductStatByBarcode((string)$res['PRODUCTID']);
                    // if($myProductStat->id > 0)
                    // {
                    //     if($myProductStat->pricerevision < $maxRevision + 1)
                    //     {
                    //         $myProductStat->pricerevision = $maxRevision + 1;
                    //         $stmt = $myProductStat->updateData();
                    //         if($stmt)
                    //             $number++;

                    //     }
                    // }

                }

            }

        }

       echo 'so luong record duoc thuc thi : ' .  $number;

    }

    function synwarrantyfullboxshortAction()
    {
        $recordPerPage = 2000;
        $number = 0;
        $oracle = new Oracle();
        $getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM ERP.VW_PRICE_PRODUCT_DM');
        $total = 0;
        foreach($getAllGalleriesRow as $count)
        {
            $total = $count['R']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($listproductprice);

            set_time_limit(0);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $listproductprice = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM ERP.VW_PRICE_PRODUCT_DM g) WHERE r > '.$start.' AND r <= '.$end);
            if(!empty($listproductprice))
            {
                foreach($listproductprice as $p)
                {
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                            SET p_fullbox_short = ?,
                                p_warranty = ?
                            WHERE p_barcode = ?';
                    $stmt = $this->registry->db->query($sql, array(
                                                            (string)$p['ACCESSORIESINCLUDES'],
                                                            (int)$p['WARRANTYINFO'],
                                                            (string)trim($p['PRODUCTID']),
                                                          ));
                    $number++;
                }
            }
        }
        echo $number;
    }


    function synbarcodeproductAction()
    {
        $recordPerPage = 2000;
        $number = 0;
        $oracle = new Oracle();
        $getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM ERP.PM_PRODUCT WHERE PRODUCTIDREF IS NOT NULL AND PRODUCTIDREF > 0');
        $total = 0;
        foreach($getAllGalleriesRow as $count)
        {
            $total = $count['R']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($listproductprice);

            set_time_limit(0);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $listproductprice = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM ERP.PM_PRODUCT g WHERE PRODUCTIDREF IS NOT NULL AND PRODUCTIDREF > 0) WHERE r > '.$start.' AND r <= '.$end);
            if(!empty($listproductprice))
            {
                foreach($listproductprice as $p)
                {
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                            SET p_barcode = ?
                            WHERE p_id = ?';
                    //echo 'UPDATE: '.$p['PRODUCTID'].' - ' .$p['PRODUCTIDREF'];
                    $stmt = $this->registry->db->query($sql, array(
                                                            (string)$p['PRODUCTID'],
                                                            (string)trim($p['PRODUCTIDREF']),
                                                          ));
                    $number++;
                }
            }
        }
        echo $number;
    }

    public function synvendorproductAction()
    {
        $recordPerPage = 2000;
        $number = 0;
        $oracle = new Oracle();
        $getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM TGDD_NEWS.PRODUCT');
        $total = 0;
        foreach($getAllGalleriesRow as $count)
        {
            $total = $count['R']; //tong so record
        }

        $page = ceil($total/$recordPerPage);
        //echo $page;
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($listproductprice);

            set_time_limit(0);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;

            $listproductprice = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM TGDD_NEWS.PRODUCT g) WHERE r > '.$start.' AND r <= '.$end);
            if(!empty($listproductprice))
            {
                foreach($listproductprice as $p)
                {
                    $vendor = $oracle->query('SELECT DISTINCT MANUFACTURERNAME FROM '.Oracle::$ociDatabaseName.'.PRODUCT_MANU WHERE MANUFACTURERID='.$p['MANUFACTURERID']);
                    //var_dump($vendor);
                    if(!empty($vendor)){
                        $searchvendor = $this->registry->db->query('SELECT v_id FROM ' . TABLE_PREFIX . 'vendor WHERE v_name =?',array((string)trim($vendor[0]['MANUFACTURERNAME'])))->fetch();
                        //var_dump($searchvendor);
                        $vendorid = (!empty($searchvendor['v_id'])?$searchvendor['v_id']:0);
                        if(!empty($vendorid))
                        {
                            $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                                SET v_id = ?
                                WHERE p_id = ?';
                                //echo '<p>UPDATE: '.$vendor[0]['MANUFACTURERNAME'].' - ' .$p['PRODUCTID'].'</p>';
                                $stmt = $this->registry->db->query($sql, array(
                                                                        (int)$vendorid,
                                                                        (string)$p['PRODUCTID']
                                                                      ));
                                $number++;
                        }

                    }
                }
            }
        }
        echo $number;
    }

    public function synproductslugAction()
    {
        $recordPerPage = 500;
        $number = 0;
        $oracle = new Oracle();
        $getAllGalleriesRow = $this->registry->db->query('SELECT count(*) as R FROM lit_product WHERE p_slug !="" OR p_slug IS NULL')->fetch();
        $total = $getAllGalleriesRow['R'];

        $page = ceil($total/$recordPerPage);
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($listproductprice);

            set_time_limit(0);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage * $i;
echo '<p>SELECT * FROM lit_product WHERE p_slug !="" OR p_slug IS NOT NULL LIMIT '.$start.','.$end.'</p>';

            $listproductprice = $this->registry->db->query('SELECT * FROM lit_product WHERE p_slug ="" OR p_slug IS NULL LIMIT '.$start.','.$end);
            //var_dump($listproductprice);exit();
            echo '<p>COUNT: '.count($listproductprice).'</p>';
            $iiiii = 1;
            if(!empty($listproductprice))
            {
                while($p = $listproductprice->fetch())
                {
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                                SET p_slug = ?
                                WHERE p_id = ?';
                        //echo '<p>'.$iiiii++.'-- UPDATE: '.$p['p_name'].' - ' .$p['p_id'].'</p>';
                        $stmt = $this->registry->db->query($sql, array(
                                                                (string)Helper::codau2khongdau($p['p_name'], true, true),
                                                                (int)$p['p_id']
                                                              ));
                        $number++;
                }
            }
        }
        echo $number;
    }

    /**
     * [updateQuantityProductAction description]
     * Cap nhat lai so luong san trong trong database
     * @return [type] [description]
     */
    public function updateproductstockAction()
    {
        $counter = 0;
        set_time_limit(0);
        $sql = 'SELECT p_barcode , p_instock , p_id FROM ' . TABLE_PREFIX.'product WHERE p_onsitestatus = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

		while($row = $stmt->fetch())
		{
            $quantity = 0;

            $specialstore = array(988 , 790 , 791 , 806 , 855 , 877 , 946 , 947, 948, 949, 974, 978, 988, 990, 991, 992, 993, 994, 995); // day la nhung kho ma se khong tinh ton kho vao san pham , neu phat sinh them thi them id cua store vao mang nay

			$sql = 'SELECT SUM(ps_quantity) AS quantity FROM ' . TABLE_PREFIX . 'product_stock ps
                WHERE ps.s_id NOT IN(' . implode(',', $specialstore) . ') AND ps.p_barcode = ?  GROUP BY ps.p_barcode';
			$row1 = $this->registry->db->query($sql, array($row['p_barcode']))->fetch();

            $quantity += (int)$row1['quantity'];
            //get instock of product color
            $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$row['p_id']), 'id', 'ASC');
            if(count($productcolors) > 0)
            {
                foreach($productcolors as $productcolor)
                {
                    $sql = 'SELECT p_barcode , p_id , p_instock FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
                    $rowdata = $this->registry->db->query($sql , array($productcolor->piddestination))->fetch();

                    $sql = 'SELECT SUM(ps_quantity) AS quantity FROM ' . TABLE_PREFIX . 'product_stock ps
                            WHERE ps.s_id NOT IN(' . implode(',', $specialstore) . ') AND ps.p_barcode = ?  GROUP BY ps.p_barcode';
                    $rowdata2 = $this->registry->db->query($sql , array($rowdata['p_barcode']))->fetch();

                    $quantity += (int)$rowdata2['quantity'];

                    //cap nhat ton kho cho san pham mau
                    if($rowdata2['quantity'] > 0 && (int)$rowdata['p_instock'] != $rowdata2['quantity'])
                    {
                        $sql = 'UPDATE ' . TABLE_PREFIX .'product p
                        SET p.p_instock = ?,
                            p.p_syncstatus = ?
                        WHERE p_barcode = ?';

                        $result = $this->registry->db->query($sql, array((int)$rowdata2['quantity'], Core_Product::STATUS_SYNC_FOUND ,(string)$rowdata['p_barcode']));
                        $counter++;
                    }

                    unset($rowdata);
                    unset($rowdata2);
                }
            }

            //cap nhat ton kho cho san pham chinh
			//kiem tra so luong co thay doi
            if((int)$row['p_instock'] != $quantity)
            {
                $sql = 'UPDATE ' . TABLE_PREFIX .'product p
                SET p.p_instock = ?,
                    p.p_syncstatus = ?
                WHERE p_barcode = ?';

                $result = $this->registry->db->query($sql, array($quantity, Core_Product::STATUS_SYNC_FOUND ,(string)$row['p_barcode']));
                $counter++;
            }
		}

        echo 'so luong record duoc thuc thi : ' . $counter;
    }

    /**
     * Cap nhat gia cua san phan trong he thong
     * */
    public function updateproductpriceAction()
    {
        $counter = 0;
        set_time_limit(0);
		$sql = 'SELECT p_barcode , p_sellprice, p_id FROM ' . TABLE_PREFIX.'product WHERE p_onsitestatus > 0';
		$stmt = $this->registry->db->query($sql);

		while($row = $stmt->fetch())
		{
			$sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                WHERE ppa_id = 242 AND po_id = 0 AND pp_confirm = 1 AND p_barcode = ?
                GROUP BY pp.p_barcode';

			$row1 = $this->registry->db->query($sql, array($row['p_barcode']))->fetch();

			if((float)$row1['pp_sellprice'] <= 0)
            {
				$sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
							  WHERE ppa_id = 242 AND po_id = 222 AND p_barcode = "' . $row['p_barcode'] . '" AND pp_confirm = 1';
				$result1 = $this->registry->db->query($sql)->fetch();
				if((float)$result1['pp_sellprice'] > 0)
				{
					if((float)$result1['pp_sellprice'] != (float)$row['p_sellprice'])
					{
                        //kiem tra cap nhat final price
                        if($row['p_finalprice'] == 0)
                        {
                            $sql = 'UPDATE '. TABLE_PREFIX .'product
                                SET p_finalprice = '.(float)$result1['pp_sellprice'].'
                                WHERE p_barcode = ' . (string)$row['p_barcode'];
                            $result2 = $this->registry->db->query($sql);
                        }

						$sql = 'UPDATE '. TABLE_PREFIX .'product
								SET p_sellprice = '.(float)$result1['pp_sellprice'].'
								WHERE p_barcode = ' . (string)$row['p_barcode'];

						   //$result = $this->registry->db->query($sql, array((float)$result1['pp_sellprice'],(string)$row['p_barcode']));
						$result = $this->registry->db->query($sql);
						   //echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';

						$counter++;
					}
				}
				else
				{
					$sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
							  WHERE pp_sellprice > 0 AND p_barcode = "' . $row['p_barcode'] . '" AND pp_confirm = 1';
					$result1 = $this->registry->db->query($sql)->fetch();//xuat ban tai sieu thi
					if((float)$result1['pp_sellprice'] > 0)
					{
						if((float)$result1['pp_sellprice'] != (float)$row['p_sellprice'])
						{
	                        //kiem tra cap nhat final price
	                        if($row['p_finalprice'] == 0)
	                        {
	                            $sql = 'UPDATE '. TABLE_PREFIX .'product
	                                SET p_finalprice = '.(float)$result1['pp_sellprice'].'
	                                WHERE p_barcode = ' . (string)$row['p_barcode'];
	                            $result2 = $this->registry->db->query($sql);
	                        }

							$sql = 'UPDATE '. TABLE_PREFIX .'product
									SET p_sellprice = '.(float)$result1['pp_sellprice'].'
									WHERE p_barcode = ' . (string)$row['p_barcode'];

							   //$result = $this->registry->db->query($sql, array((float)$result1['pp_sellprice'],(string)$row['p_barcode']));
							$result = $this->registry->db->query($sql);
							   //echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';

							$counter++;
						}
					}

				}
			}
			else
			{
				if($row1['pp_sellprice'] > 0 && (float)$row1['pp_sellprice'] != (float)$row['p_sellprice'])
				{
                    //kiem tra cap nhat final price
                    if($row['p_sellprice'] == 0)
                    {
                        $sql = 'UPDATE '. TABLE_PREFIX .'product
                            SET p_finalprice = '.(float)$row1['pp_sellprice'].'
                            WHERE p_barcode = ' . (string)$row['p_barcode'];
                        $result2 = $this->registry->db->query($sql);
                    }

					$sql = 'UPDATE '. TABLE_PREFIX .'product
                            SET p_sellprice = '.(float)$row1['pp_sellprice'].'
                            WHERE p_barcode = ' . (string)$row['p_barcode'];

					//$result = $this->registry->db->query($sql, array((float)$row['pp_sellprice'],(string)$row['p_barcode']));
					$result = $this->registry->db->query($sql);
					//echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
					$counter++;
				}
			}

            unset($row1);
            // cap nhat gia cho san pham mau
            $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$row['p_id']), 'id', 'ASC');
            if( count($productcolors) > 0 )
            {
                foreach ($productcolors as $productcolor)
                {
                    $sql = 'SELECT p_barcode , p_id , p_sellprice FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
                    $rowdata = $this->registry->db->query($sql , array($productcolor->piddestination))->fetch();

                    $sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                            WHERE ppa_id = 242 AND po_id = 0 AND pp_confirm = 1 AND p_barcode = ?
                            GROUP BY pp.p_barcode';

                    $row1 = $this->registry->db->query($sql, array($rowdata['p_barcode']))->fetch();

                    if((float)$row1['pp_sellprice'] <= 0)
                    {
                        $sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                                      WHERE ppa_id = 242 AND po_id = 222 AND p_barcode = "' . $rowdata['p_barcode'] . '" AND pp_confirm = 1';
                        $result1 = $this->registry->db->query($sql)->fetch();
                        if((float)$result1['pp_sellprice'] > 0)
                        {
                            if($result1['pp_sellprice'] > 0 && (float)$result1['pp_sellprice'] != (float)$rowdata['p_sellprice'])
                            {
                                $sql = 'UPDATE '. TABLE_PREFIX .'product
                                        SET p_sellprice = '.(float)$result1['pp_sellprice'].'
                                        WHERE p_barcode = ' . (string)$rowdata['p_barcode'];

                                   //$result = $this->registry->db->query($sql, array((float)$result1['pp_sellprice'],(string)$row['p_barcode']));
                                $result = $this->registry->db->query($sql);
                                   //echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
                                $counter++;
                            }
                        }
                        else
                        {
                            /*$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_sellprice = 0
                                        WHERE p_barcode="' . (string)$rowdata['p_barcode'] . '"';
                            $result = $this->registry->db->query($sql);*/
                            $counter++;
                        }
                    }
                    else
                    {
                        if($row1['pp_sellprice'] > 0 && (float)$row1['pp_sellprice'] != (float)$row['p_sellprice'])
                        {
                            $sql = 'UPDATE '. TABLE_PREFIX .'product
                                    SET p_sellprice = '.(float)$row1['pp_sellprice'].'
                                    WHERE p_barcode = ' . (string)$rowdata['p_barcode'];

                            //$result = $this->registry->db->query($sql, array((float)$row['pp_sellprice'],(string)$row['p_barcode']));
                            $result = $this->registry->db->query($sql);
                            //echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
                            $counter++;
                        }
                    }
                }
            }
		}

        echo 'so luong record duoc thuc thi : ' . $counter;
    }

    public function syncquantityproductofvendorAction()
    {
        $counter = 0;
        set_time_limit(0);
        $vendorList = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_VENDOR) , 'displayorder' , 'ASC');
        if(count($vendorList) > 0)
        {
            foreach($vendorList as $vendor)
            {
                unset($countproduct);

                $countproduct = Core_Product::getProducts(array('fvid' => $vendor->id) , 'id' , 'ASC' , '', true);
                $vendor->countproduct = $countproduct;
                if($vendor->updateData())
                {
                    $counter++;
                }
            }
        }
        echo $counter . '<br />';
    }


    public function updateOnisteStatusAction()
    {
        set_time_limit(0);
        $sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_onsitestatus = 0';
        $this->registry->db->query($sql);
    }

    public function syncnumberproductbycategoryAction()
    {
        $counter = 0;
        set_time_limit(0);
        //lay tat ca category
        $productcategorys = Core_Productcategory::getProductcategorys(array() , 'id' , 'ASC');
        if(count($productcategorys) > 0)
        {
            foreach($productcategorys as $productcategory)
            {
                //lay tat ca danh muc con cua no
                $productcategory->sublist = Core_Productcategory::getFullSubCategory($productcategory->id);

                $productcategory->countitem = Core_Product::getProducts(array('fpcidarrin' => $productcategory->sublist) , 'id' , 'ASC' , '',true);
                $productcategory->updateData();
                $counter++;
            }
        }

        echo 'so record thuc thi : ' . $counter;
    }

    public function syncnumberproductbyvendorAction()
    {
        $counter = 0;
        set_time_limit(0);
        //lay tat ca vendor
        $vendors = Core_Vendor::getVendors(array('ftype' => Core_Vendor::TYPE_VENDOR) , 'id' , 'ASC');
        if(count($vendors) > 0)
        {
            foreach($vendors as $vendor)
            {
                $vendor->countproduct = Core_Product::getProducts(array('fvid' => $vendor->id) , 'id' , 'ASC' , '' , true);
                $vendor->updateData();
            }
        }
        echo 'so record thuc thi : ' . $counter;
    }

    public function synproductindexAction()
    {
        set_time_limit(0);
        echo 'Tổng số record indexed: '.Core_Backend_Productindex::fetchall();
    }

    public function syncviewproductAction()
    {
    	$counter = 0;
    	$days = ((int)$_GET['days'] > 0) ? (int)$_GET['days'] : 1;
    	$formData = array();
    	//get all product have onsitestatus = ERP
    	$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product
    			WHERE p_barcode != "" AND p_onsitestatus = ?';
    	$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));
    	$today = time();
    	$formData['ftimestampstart'] = strtotime(date('Y-m-d' , strtotime('-'.$days.' day' ,$today)));
    	$formData['ftimestampend'] = $today;
    	$formData['ftype'] = Core_Backend_View::TYPE_PRODUCT;

    	while($row = $stmt->fetch())
    	{
    		$formData['fobjectid'] = (int)$row['p_id'];


    		$views = Core_Backend_View::getViews($formData, 'id', 'ASC','',true);

    		switch ($days)
    		{
    			case 1 :
    				$sql = 'UPDATE ' . TABLE_PREFIX . 'product
    						SET p_view1 = ?
    						WHERE p_id = ?';
    				break;
    			case 7 :
    				$sql = 'UPDATE ' . TABLE_PREFIX . 'product
    						SET p_view7 = ?
    						WHERE p_id = ?';
    				break;
    			case 15 :
    				$sql = 'UPDATE ' . TABLE_PREFIX . 'product
    						SET p_view15 = ?
    						WHERE p_id = ?';
    				break;
    			case 30 :
    				$sql = 'UPDATE ' . TABLE_PREFIX . 'product
    						SET p_view30 = ?
    						WHERE p_id = ?';
    				break;
    		}

    		$result = $this->registry->db->query($sql , array($views, (int)$row['p_id']));
    		if($result)
    		{
    			$counter++;
    		}
    	}

    	echo 'So luong record thuc thi : ' . $counter;
    }

    public function syncstatproductstockAction()
    {
    	set_time_limit(0);
    	$timer = new Timer();
    	$counter = 0;

    	$timer->start();

        $currentday = date('d' , time());
        //$currentday = 12;
        $currentmonth = date('m' , time());
        $currentyear = date('Y' , time());
        $currenthour = date('H' , time());
        //$currenthour = 13;

        $sql = 'SELECT p_barcode , p_id FROM ' . TABLE_PREFIX . 'product WHERE p_barcode > 0';
        $stmt = $this->registry->db->query($sql);

        while ($row = $stmt->fetch()) {

            $productStockList = Core_ProductStock::getProductStockByStore($row['p_barcode']);
            if(count($productStockList) > 0) {
                $statProductStock = Core_Backend_StatProductstock::getDataByBarcode($row['p_barcode'] , $currentmonth , $currentyear);
                if ($statProductStock->id > 0) {
                    $value = array();
                    $date = 'day_' . $currentday;
                    $valuelist = explode(',', $statProductStock->$date);
                    $sumquantity = 0;
                    $have = no;
                    $rows = array();

                    if(count($valuelist) > 0 && trim($valuelist[0] != '')) {
                        $infodatalist = array();
                        foreach ($valuelist as $valuedata) {
                            $temp = explode(':', $valuedata);
                            $rows[$temp[0]][$temp[1]] = $temp[2];
                        }

                        foreach ($productStockList as $productstock) {
                            $oldquantity = array_pop($rows[$productstock->sid]);
                            if($oldquantity != $productstock->quantity) {
                                $value[] = $productstock->sid . ':' . $currenthour . ':' . $productstock->quantity;
                            }
                            $sumquantity += $productstock->quantity;
                        }

                        $summarylist = explode(':' , $valuelist[count($valuelist) - 1]);
                        if ($summarylist[2] != $sumquantity) {
                            $value[] = '0:' . $currenthour . ':' . $sumquantity;
                        }
                        if(count($value) > 0) {
                            $statProductStock->$date .= ',' . implode(',', $value);
                        }

                    }
                    else {
                        foreach ($productStockList as $productstock) {
                            $value[] = $productstock->sid . ':' . $currenthour . ':' . $productstock->quantity;
                            $sumquantity += $productstock->quantity;
                        }
                        $value[] = '0:' . $currenthour . ':' . $sumquantity;
                        $statProductStock->$date .= implode(',', $value);
                    }
                    //echodebug($statProductStock , true);
                    if($statProductStock->updateData())
                    {
                        $counter++;
                    }

                }
                else {
                    $statProductStock->pbarcode = $row['p_barcode'];
                    $statProductStock->month = $currentmonth;
                    $statProductStock->year = $currentyear;
                    $date = 'day_' . $currentday;
                    $sumquantity = 0;

                    $value = array();
                    foreach ($productStockList as $productstock) {
                        $value[] = $productstock->sid . ':' . $currenthour . ':' . $productstock->quantity;
                        $sumquantity += $productstock->quantity;
                    }
                    $value[] = '0:' . $currenthour . ':' . $sumquantity;
                    $statProductStock->$date = implode(',', $value);
                    if($statProductStock->addData() > 0)
                    {
                        $counter++;
                    }
                }
            }
            unset($productStockList);
        }

    	$timer->stop();
    	echo 'time : ' . $timer->get_exec_time() . '<br />';
    	echo 'So record thuc thi la : ' . $counter;
   	}

   	public function syncstatproductpriceAction()
   	{
        set_time_limit(0);
        $db3 = Core_Backend_Object::getDb();
        $timer = new Timer();
        $counter = 0;
        $timer->start();

        $currentday = date('d' , time());
        //$currentday = 13;
        $currentmonth = date('m' , time());
        $currentyear = date('Y' , time());
        $currenthour = date('H' , time());
        $currenthour = 15;

        $sql = 'SELECT p_barcode , p_id FROM ' . TABLE_PREFIX . 'product WHERE p_barcode > 0';
        $stmt = $this->registry->db->query($sql);

        while ( $row = $stmt->fetch()) {
            $productPriceList = Core_ProductPrice::getProductPriceByArea($row['p_barcode']);
            if (count($productPriceList) > 0) {
                $statProductPrice = Core_Backend_StatProductprice::getDataByBarcode($row['p_barcode'] , $currentmonth , $currentyear);

                if($statProductPrice->id > 0) {
                    $value = array();
                    $date = 'day_' . $currentday;
                    $valuelist = explode(',', $statProductPrice->$date);
                    $sumquantity = 0;
                    $rows = array();

                    if(count($valuelist) > 0 && trim($valuelist[0] != '')) {
                        $infodatalist = array();
                        foreach ($valuelist as $valuedata) {
                            $temp = explode(':', $valuedata);
                            $rows[$temp[0]][$temp[1]][$temp[2]] = $temp[3];
                        }

                        foreach ($productPriceList as $productprice) {
                            $oldprice = array_pop($rows[$productprice->ppaid][$productprice->poid]);
                            if($oldprice != $productprice->sellprice) {
                                $value[] = $productprice->ppaid . ':' . $productprice->poid . ':' . $currenthour . ':' . $productprice->sellprice;
                            }
                        }

                        if(count($value) > 0) {
                            $statProductPrice->$date .= ',' . implode(',', $value);
                        }
                    }
                    else {
                        foreach ($productPriceList as $productprice) {
                            $value[] = $productprice->ppaid . ':' . $productprice->poid . ':' . $currenthour . ':' .$productprice->sellprice;
                        }
                        $statProductPrice->$date .= implode(',', $value);
                    }
                    if($statProductPrice->updateData())
                    {
                        $counter++;
                    }
                }
                else {
                    $statProductPrice->pbarcode = $row['p_barcode'];
                    $statProductPrice->month = $currentmonth;
                    $statProductPrice->year = $currentyear;
                    $date = 'day_' . $currentday;
                    $value = array();

                    foreach ($productPriceList as $productprice) {
                        $value[] = $productprice->ppaid . ':' . $productprice->poid . ':' . $currenthour . ':' .$productprice->sellprice;
                    }

                    $statProductPrice->$date = implode(',', $value);
                    if($statProductPrice->addData() > 0) {
                        $counter++;
                    }
                }
            }
        }

        $timer->stop();
        echo 'Thoi gian thuc thi la ' . $timer->get_exec_time() . '<br/>';
        echo 'So luong record thuc thi : ' . $counter;

   	}

   	public function syncstatproductorderAction()
   	{
   		set_time_limit(0);
   		$timer = new Timer();
   		$counter = 0;

   		$timer->start();

   		$currentdate = explode('-',date('Y-m-d' , time()));
   		$currentday = $currentdate[2];
   		$currentmonth = $currentdate[1];
   		$currentyear = $currentdate[0];

   		//lay tat ca san pham co trang thai la erp
   		$sql = 'SELECT DISTINCT(p_barcode) FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus = ?';
   		$stmt = $this->registry->db->query($sql, array(Core_Product::OS_ERP));

   		$i = 0;
   		while($row = $stmt->fetch())
   		{
   			$productstat = new Core_StatOrderproduct();
   			$productstat->pbarcode = $row['p_barcode'];

   			$sql = 'SELECT SUM(od_quantity) AS quantity FROM ' . TABLE_PREFIX . 'archivedorder_detail WHERE od_productid = ?';
   			$result = $this->registry->db->query($sql , array($row['p_barcode']))->fetch();
   			$productstat->quantity = $result['quantity'];
   			$productstat->day = $currentday;
   			$productstat->month = $currentmonth;
   			$productstat->year = $currentyear;

   			if($productstat->addData() > 0)
   			{
   				$counter++;
   			}
			$i++;
			unset($result);
   		}

   		$timer->stop();
   		echo 'time : ' . $timer->get_exec_time() . '<br />';
   		echo 'So record thuc thi la : ' . $counter;
   	}

    public function syncstatusproductAction()
    {
	  	set_time_limit(0);

	  	$conditionscn = 'TIMESTAMP_TO_SCN(to_TimeStamp(\''.date('d/m/Y', strtotime('-2 day')).'\', \'DD/MM/YYYY\'))';
	  	if (!empty($_GET['all'])) $conditionscn = '';
	  	//echo 'SELECT a.ISSERVICE, a.STATUSID, a.PRODUCTID , ROWNUM r FROM ERP.VW_PRODUCT_DM a WHERE a.ORA_ROWSCN > '.$conditionscn.'';
	  	$oracle = new Oracle();
	  	$countAll = $oracle->query('SELECT count(*) as total from ERP.VW_PRODUCT_DM'.(!empty($conditionscn)? ' WHERE ORA_ROWSCN > '.$conditionscn :''));
		$counter = 0;
		if (!empty($countAll))
		{
			$total = $countAll[0]['TOTAL'];
			$recordPerPage = 1000;
			$totalpage = ceil($total/$recordPerPage);
			for ($i = 1 ; $i <= $totalpage ; $i++)
			{
				$start = ($recordPerPage * $i) - $recordPerPage;
				$end = $recordPerPage * $i;
				$sql = 'SELECT * FROM (SELECT a.ISSERVICE, a.STATUSID, a.PRODUCTID , ROWNUM r FROM ERP.VW_PRODUCT_DM a '.(!empty($conditionscn)? ' WHERE ORA_ROWSCN > '.$conditionscn :'').') WHERE r > ' . $start .' AND r <=' . $end;
				//echodebug($sql, true);
				$results = $oracle->query($sql);
				if (!empty($results))
				{
					foreach($results as $result)
					{
						$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_isservice=?, p_businessstaus =? WHERE p_barcode = ?';
						//echodebug($sql.'-----'.$result['ISSERVICE'] .'-'. $result['STATUSID'].'-'. trim($result['PRODUCTID']), true);
						$rowset = $this->registry->db->query($sql , array($result['ISSERVICE'], $result['STATUSID'], trim($result['PRODUCTID'])));
						if($rowset)
						{
							 $counter++;
						}
					}
				}
			}
		}
	  	echo 'So luong record thuc thi la : ' . $counter;

    }
    ///PRODUCT REVIEW THUMB
    public function syncProductReviewThumbAction()
    {
        //get product review thumb
        $productreviewthumbs = Core_ProductReviewThumb::getValueProductThumb();

        if(count($productreviewthumbs) > 0)
        {
            foreach($productreviewthumbs as $productreviewthumb)
            {
                //cap nhat thumb cho review
                if($productreviewthumb->robjectid > 0 && $productreviewthumb->rid > 0)
                {
                    $myProductReview = new Core_ProductReview($productreviewthumb->rid);
                    if($myProductReview->id > 0)
                    {
                        $myProductReview->countthumbup = $productreviewthumb->value;
                        if($myProductReview->updateData())
                            echo 'Review - id : ' . $myProductReview->id . ' update<br />';
                        else
                            echo 'Review - id : ' . $myProductReview->id . ' not update<br />';
                    }
                }
                else if($productreviewthumb->robjectid > 0) // cap nhat thumb cho san pham
                {
                    $myProduct = new Core_Product($productreviewthumb->robjectid);
                    if($myProduct->id > 0)
                    {
                        $myProduct->countthumbup =  $productreviewthumb->value;
                        if($myProduct->updateData())
                            echo 'Product - id : ' . $myProduct->id . ' update<br />';
                        else
                            echo 'Product - id : ' . $myProduct->id . ' not update<br />';
                    }
                }
            }
        }

    }


	public function syncproductfinalpriceAction()
	{
		set_time_limit(0);

		$counter = 0;

		$timer = new Timer();

		$timer->start();

		$sql = 'SELECT p_id , p_sellprice FROM ' . TABLE_PREFIX . 'product where p_finalprice = 0 AND p_onsitestatus > 0 AND p_status = ?';

		$stmt = $this->registry->db->query($sql , array(Core_Product::STATUS_ENABLE));

		while ($row = $stmt->fetch())
		{
			$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_finalprice=? WHERE p_id = ?';
			$result = $this->registry->db->query($sql , array($row['p_sellprice'] , $row['p_id']) );
			if($result)
			{
				$counter++;
			}
		}

		$timer->stop();

		echo 'So luong record thuc thi : ' . $counter . '<br/>';
		echo 'Thời gian thuc thi : ' . $timer->get_exec_time() . '<br/>';
	}

    public function synordermissingcrm()
    {
        //code here.....
    }

    public function cacheshippingfeeAction()
    {
        $timer = new Timer();
        $timer->start();
        set_time_limit(0);
        $getallprovinces = Core_Region::getRegions(array('fparentid' => 0), '', '');
        unset($getallprovinces);
        $allregions = array();
        foreach ($getallprovinces as $region) {
            $allregions[] = $region->id;
        }
        foreach($allregions as $rid) {
            foreach ($allregions as $rid2) {
                if ($rid2 == $rid) continue;
                $getshippingfeedienmay = Core_ShippingfeeDienmay::getShippingfeeDienmays(array('fprovincestart' => $rid,
                                                                                               'fprovinceend' => $rid2
                                                                                            ), '', '');
                $arraycacheshipping = array();
                if (!empty($getshippingfeedienmay)) {
                    foreach ($getshippingfeedienmay as $fee) {
                        $arraycacheshipping[$rid.'_'.$rid2][$fee->districtend] = array('districtstart' => $fee->provincestart, 'districtend' => $fee->districtend, 'ttc' => $fee->ttc, 'sbp' => $fee->sbp);
                    }
                }
                if (!empty($arraycacheshipping)) {
                    foreach ($arraycacheshipping as $idkey => $arrdata) {
                        $myCacher = new Cacher('shippingfeeprovince_'.$idkey, Cacher::STORAGE_MEMCACHED);
                        $myCacher->set(json_encode($arrdata), 0);
                    }
                    unset($myCacher);
                }
                unset($arraycacheshipping);
                unset($getshippingfeedienmay);
            }
        }
        //unset($allregions);

        //get all shipping prices
        $getshippingprices = Core_ShippingfeePrices::getShippingfeePricess(array(), '', '');
        if (!empty($getshippingprices)) {
            $arraycache = array();
            foreach ($getshippingprices as $key => $prices) {
                $arraycache[] = (array)$prices;
            }
            if (!empty($arraycache)) {
                $myCacher = new Cacher('shippingfeeprice', Cacher::STORAGE_MEMCACHED);
                $myCacher->set(json_encode($arraycache), 0);
            }
            unset($myCacher);
            unset($arraycache);
        }
        unset($getshippingprices);

        /* ĐỐI VỚI CỘT ORDER trong SETTING
        1: Tính lúc vừa mới lấy từ bảng giá trị ra
        2: Tính tổng từ 1 rồi + 2
        3: 2 + 3 + VXVS (TTC OR SBP)
        4: lấy tất cả + 4*/

        //get all shipping settings
        $getshippingprices = Core_ShippingfeeSettings::getShippingfeeSettingss(array(), '', '');
        if (!empty($getshippingprices)) {
            $arraycache = array();
            foreach ($getshippingprices as $key => $prices) {
                $arraycache[] = (array)$prices;
            }
            if (!empty($arraycache)) {
                $myCacher = new Cacher('shippingfeesettings', Cacher::STORAGE_MEMCACHED);
                $myCacher->set(json_encode($arraycache), 0);
            }
            unset($myCacher);
            unset($arraycache);
        }
        unset($getshippingprices);

        //get all shipping settings
        $getshippingprices = Core_ShippingfeeNamefee::getShippingfeeNamefees(array(), '', '');
        if (!empty($getshippingprices)) {
            $arraycache = array();
            foreach ($getshippingprices as $key => $prices) {
                $arraycache[] = (array)$prices;
            }
            if (!empty($arraycache)) {
                $myCacher = new Cacher('shippingfeelabel', Cacher::STORAGE_MEMCACHED);
                $myCacher->set(json_encode($arraycache), 0);
            }
            unset($myCacher);
            unset($arraycache);
        }
        unset($getshippingprices);


        $arraycachevxvs = array();
        foreach($allregions as $rid) {
            $getvxvs = Core_ShippingfeeVxvsTtc::getShippingfeeVxvsTtcs(array('frid' => $rid), '', '');
            if (!empty($getvxvs)) {
                foreach ($getvxvs as $vxvs) {
                    $arraycachevxvs[$rid][$vxvs->districtid] = array('id' => $vxvs->id, 'districtid' => $vxvs->districtid, 'less30kg' => $vxvs->less30kg, 'from30kg' =>  $vxvs->from30kg);
                }
            }
        }
        if (!empty($arraycachevxvs)) {
            foreach ($arraycachevxvs as $idkey => $arrdata) {
                $myCacher = new Cacher('shippingfeevxvsttc_'.$idkey, Cacher::STORAGE_MEMCACHED);
                $myCacher->set(json_encode($arrdata), 0);
            }
            unset($myCacher);
        }

        $timer->stop();
        echo $timer->get_exec_time();
    }

}
