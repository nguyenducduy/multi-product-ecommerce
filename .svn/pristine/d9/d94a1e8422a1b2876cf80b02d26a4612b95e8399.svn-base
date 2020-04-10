<?php

/**
 * core/class.archivedorderdetail.php
 *
 * File contains the class used for ArchivedorderDetail Model
 *
 * @category  Litpi
 * @package   Core
 * @author    Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ArchivedorderDetail Class
 */
Class Core_ArchivedorderDetail extends Core_Object
{

    public $pid = 0;
    public $imei = '';
    public $oorderid = 0;
    public $id = 0;
    public $saleorderid = '';
    public $productid = '';
    public $quantity = 0;
    public $saleprice = 0;
    public $outputtypeid = 0;
    public $vat = 0;
    public $salepriceerp = '';
    public $endwarrantytime = 0;
    public $ispromotionautoadd = 0;
    public $promotionid = 0;
    public $promotionlistgroupid = 0;
    public $applyproductid = '';
    public $replicationstoreid = 0;
    public $adjustpricetypeid = '';
    public $adjustprice = 0;
    public $adjustpricecontent = '';
    public $discountcode = '';
    public $adjustpriceuser = '';
    public $vatpercent = 0;
    public $retailprice = 0;
    public $inputvoucherdetailid = 0;
    public $buyinputvoucherid = 0;
    public $inputvoucherdate = 0;
    public $isnew = 0;
    public $isshowproduct = 0;
    public $costprice = 0;
    public $productsaleskitid = 0;
    public $refproductid = 0;
    public $productcomboid = 0;
    public $subtotal = 0;
    public $subtotalvat = 0;
    public $subprofit = 0;

    public function __construct($id = 0)
    {
        parent::__construct();

        if ($id > 0) {
            $this->getData($id);
        }
    }

    /**
     * Insert object data to database
     * @return int The inserted record primary key
     */
    public function addData()
    {

        $sql      = 'INSERT INTO ' . TABLE_PREFIX . 'archivedorder_detail (
					p_id,
					od_imei,
					o_orderid,
					od_saleorderid,
					od_productid,
					od_quantity,
					od_saleprice,
					od_outputtypeid,
					od_vat,
					od_salepriceerp,
					od_endwarrantytime,
					od_ispromotionautoadd,
					od_promotionid,
					od_promotionlistgroupid,
					od_applyproductid,
					od_replicationstoreid,
					od_adjustpricetypeid,
					od_adjustprice,
					od_adjustpricecontent,
					od_discountcode,
					od_adjustpriceuser,
					od_vatpercent,
					od_retailprice,
					od_inputvoucherdetailid,
					od_buyinputvoucherid,
					od_inputvoucherdate,
					od_isnew,
					od_isshowproduct,
					od_costprice,
					od_productsaleskitid,
					od_refproductid,
					od_productcomboid,
					od_subtotal,
					od_subtotalvat,
					od_subprofit
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
            (int)$this->pid,
            (string)$this->imei,
            (int)$this->oorderid,
            (string)$this->saleorderid,
            (string)$this->productid,
            (int)$this->quantity,
            (int)$this->saleprice,
            (int)$this->outputtypeid,
            (int)$this->vat,
            (string)$this->salepriceerp,
            (int)$this->endwarrantytime,
            (int)$this->ispromotionautoadd,
            (int)$this->promotionid,
            (int)$this->promotionlistgroupid,
            (string)$this->applyproductid,
            (int)$this->replicationstoreid,
            (string)$this->adjustpricetypeid,
            (int)$this->adjustprice,
            (string)$this->adjustpricecontent,
            (string)$this->discountcode,
            (string)$this->adjustpriceuser,
            (int)$this->vatpercent,
            (int)$this->retailprice,
            (int)$this->inputvoucherdetailid,
            (int)$this->buyinputvoucherid,
            (int)$this->inputvoucherdate,
            (int)$this->isnew,
            (int)$this->isshowproduct,
            (int)$this->costprice,
            (int)$this->productsaleskitid,
            (int)$this->refproductid,
            (int)$this->productcomboid,
            (float)$this->subtotal,
            (float)$this->subtotalvat,
            (float)$this->subprofit
        ))->rowCount();

        $this->id = $this->db->lastInsertId();

        return $this->id;
    }

    /**
     * Update database
     *
     * @return boolean Indicate query success or not
     */
    public function updateData()
    {

        $sql = 'UPDATE ' . TABLE_PREFIX . 'archivedorder_detail
				SET p_id = ?,
					od_imei = ?,
					o_orderid = ?,
					od_saleorderid = ?,
					od_productid = ?,
					od_quantity = ?,
					od_saleprice = ?,
					od_outputtypeid = ?,
					od_vat = ?,
					od_salepriceerp = ?,
					od_endwarrantytime = ?,
					od_ispromotionautoadd = ?,
					od_promotionid = ?,
					od_promotionlistgroupid = ?,
					od_applyproductid = ?,
					od_replicationstoreid = ?,
					od_adjustpricetypeid = ?,
					od_adjustprice = ?,
					od_adjustpricecontent = ?,
					od_discountcode = ?,
					od_adjustpriceuser = ?,
					od_vatpercent = ?,
					od_retailprice = ?,
					od_inputvoucherdetailid = ?,
					od_buyinputvoucherid = ?,
					od_inputvoucherdate = ?,
					od_isnew = ?,
					od_isshowproduct = ?,
					od_costprice = ?,
					od_productsaleskitid = ?,
					od_refproductid = ?,
					od_productcomboid = ?,
					od_subtotal = ?,
					od_subtotalvat = ?,
					od_subprofit = ?
				WHERE od_id = ?';

        $stmt = $this->db->query($sql, array(
            (int)$this->pid,
            (string)$this->imei,
            (int)$this->oorderid,
            (string)$this->saleorderid,
            (string)$this->productid,
            (int)$this->quantity,
            (int)$this->saleprice,
            (int)$this->outputtypeid,
            (int)$this->vat,
            (string)$this->salepriceerp,
            (int)$this->endwarrantytime,
            (int)$this->ispromotionautoadd,
            (int)$this->promotionid,
            (int)$this->promotionlistgroupid,
            (string)$this->applyproductid,
            (int)$this->replicationstoreid,
            (string)$this->adjustpricetypeid,
            (int)$this->adjustprice,
            (string)$this->adjustpricecontent,
            (string)$this->discountcode,
            (string)$this->adjustpriceuser,
            (int)$this->vatpercent,
            (int)$this->retailprice,
            (int)$this->inputvoucherdetailid,
            (int)$this->buyinputvoucherid,
            (int)$this->inputvoucherdate,
            (int)$this->isnew,
            (int)$this->isshowproduct,
            (int)$this->costprice,
            (int)$this->productsaleskitid,
            (int)$this->refproductid,
            (int)$this->productcomboid,
            (float)$this->subtotal,
            (float)$this->subtotalvat,
            (float)$this->subprofit,
            (int)$this->id
        ));

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the object data base on primary key
     * @param int $id : the primary key value for searching record.
     */
    public function getData($id)
    {
        $id  = (int)$id;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'archivedorder_detail ad
				WHERE ad.od_id = ?';
        $row = $this->db->query($sql, array( $id ))->fetch();

        $this->pid                  = (int)$row['p_id'];
        $this->imei                 = (string)$row['od_imei'];
        $this->oorderid             = (int)$row['o_orderid'];
        $this->id                   = (int)$row['od_id'];
        $this->saleorderid          = (string)$row['od_saleorderid'];
        $this->productid            = (string)$row['od_productid'];
        $this->quantity             = (int)$row['od_quantity'];
        $this->saleprice            = (int)$row['od_saleprice'];
        $this->outputtypeid         = (int)$row['od_outputtypeid'];
        $this->vat                  = (int)$row['od_vat'];
        $this->salepriceerp         = (string)$row['od_salepriceerp'];
        $this->endwarrantytime      = (int)$row['od_endwarrantytime'];
        $this->ispromotionautoadd   = (int)$row['od_ispromotionautoadd'];
        $this->promotionid          = (int)$row['od_promotionid'];
        $this->promotionlistgroupid = (int)$row['od_promotionlistgroupid'];
        $this->applyproductid       = (string)$row['od_applyproductid'];
        $this->replicationstoreid   = (int)$row['od_replicationstoreid'];
        $this->adjustpricetypeid    = (string)$row['od_adjustpricetypeid'];
        $this->adjustprice          = (int)$row['od_adjustprice'];
        $this->adjustpricecontent   = (string)$row['od_adjustpricecontent'];
        $this->discountcode         = (string)$row['od_discountcode'];
        $this->adjustpriceuser      = (string)$row['od_adjustpriceuser'];
        $this->vatpercent           = (int)$row['od_vatpercent'];
        $this->retailprice          = (int)$row['od_retailprice'];
        $this->inputvoucherdetailid = (int)$row['od_inputvoucherdetailid'];
        $this->buyinputvoucherid    = (int)$row['od_buyinputvoucherid'];
        $this->inputvoucherdate     = (int)$row['od_inputvoucherdate'];
        $this->isnew                = (int)$row['od_isnew'];
        $this->isshowproduct        = (int)$row['od_isshowproduct'];
        $this->costprice            = (int)$row['od_costprice'];
        $this->productsaleskitid    = (int)$row['od_productsaleskitid'];
        $this->refproductid         = (int)$row['od_refproductid'];
        $this->productcomboid       = (int)$row['od_productcomboid'];
        $this->subtotal             = (float)$row['od_subtotal'];
        $this->subtotalvat          = (float)$row['od_subtotalvat'];
        $this->subprofit            = (float)$row['od_subprofit'];

    }

    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql      = 'DELETE FROM ' . TABLE_PREFIX . 'archivedorder_detail
				WHERE od_id = ?';
        $rowCount = $this->db->query($sql, array( $this->id ))->rowCount();

        return $rowCount;
    }

    /**
     * Count the record in the table base on condition in $where
     *
     * @param string $where : the WHERE condition in SQL string.
     */
    public static function countList($where)
    {
        $db = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'archivedorder_detail ad';

        if ($where != '') {
            $sql .= ' WHERE ' . $where;
        }

        return $db->query($sql)->fetchColumn(0);
    }

    /**
     * Get the record in the table with paginating and filtering
     *
     * @param string $where the WHERE condition in SQL string
     * @param string $order the ORDER in SQL string
     * @param string $limit the LIMIT in SQL string
     */
    public static function getList($where, $order, $limit = '')
    {
        $db = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'archivedorder_detail ad';

        if ($where != '') {
            $sql .= ' WHERE ' . $where;
        }

        if ($order != '') {
            $sql .= ' ORDER BY ' . $order;
        }

        if ($limit != '') {
            $sql .= ' LIMIT ' . $limit;
        }

        $outputList = array();
        $stmt       = $db->query($sql);
        while ($row = $stmt->fetch()) {
            $myArchivedorderDetail = new Core_ArchivedorderDetail();

            $myArchivedorderDetail->pid                  = (int)$row['p_id'];
            $myArchivedorderDetail->imei                 = (string)$row['od_imei'];
            $myArchivedorderDetail->oorderid             = (int)$row['o_orderid'];
            $myArchivedorderDetail->id                   = (int)$row['od_id'];
            $myArchivedorderDetail->saleorderid          = (string)$row['od_saleorderid'];
            $myArchivedorderDetail->productid            = (string)$row['od_productid'];
            $myArchivedorderDetail->quantity             = (int)$row['od_quantity'];
            $myArchivedorderDetail->saleprice            = (int)$row['od_saleprice'];
            $myArchivedorderDetail->outputtypeid         = (int)$row['od_outputtypeid'];
            $myArchivedorderDetail->vat                  = (int)$row['od_vat'];
            $myArchivedorderDetail->salepriceerp         = (string)$row['od_salepriceerp'];
            $myArchivedorderDetail->endwarrantytime      = (int)$row['od_endwarrantytime'];
            $myArchivedorderDetail->ispromotionautoadd   = (int)$row['od_ispromotionautoadd'];
            $myArchivedorderDetail->promotionid          = (int)$row['od_promotionid'];
            $myArchivedorderDetail->promotionlistgroupid = (int)$row['od_promotionlistgroupid'];
            $myArchivedorderDetail->applyproductid       = (string)$row['od_applyproductid'];
            $myArchivedorderDetail->replicationstoreid   = (int)$row['od_replicationstoreid'];
            $myArchivedorderDetail->adjustpricetypeid    = (string)$row['od_adjustpricetypeid'];
            $myArchivedorderDetail->adjustprice          = (int)$row['od_adjustprice'];
            $myArchivedorderDetail->adjustpricecontent   = (string)$row['od_adjustpricecontent'];
            $myArchivedorderDetail->discountcode         = (string)$row['od_discountcode'];
            $myArchivedorderDetail->adjustpriceuser      = (string)$row['od_adjustpriceuser'];
            $myArchivedorderDetail->vatpercent           = (int)$row['od_vatpercent'];
            $myArchivedorderDetail->retailprice          = (int)$row['od_retailprice'];
            $myArchivedorderDetail->inputvoucherdetailid = (int)$row['od_inputvoucherdetailid'];
            $myArchivedorderDetail->buyinputvoucherid    = (int)$row['od_buyinputvoucherid'];
            $myArchivedorderDetail->inputvoucherdate     = (int)$row['od_inputvoucherdate'];
            $myArchivedorderDetail->isnew                = (int)$row['od_isnew'];
            $myArchivedorderDetail->isshowproduct        = (int)$row['od_isshowproduct'];
            $myArchivedorderDetail->costprice            = (int)$row['od_costprice'];
            $myArchivedorderDetail->productsaleskitid    = (int)$row['od_productsaleskitid'];
            $myArchivedorderDetail->refproductid         = (int)$row['od_refproductid'];
            $myArchivedorderDetail->productcomboid       = (int)$row['od_productcomboid'];
            $myArchivedorderDetail->subtotal             = (float)$row['od_subtotal'];
            $myArchivedorderDetail->subtotalvat          = (float)$row['od_subtotalvat'];
            $myArchivedorderDetail->subprofit            = (float)$row['od_subprofit'];


            $outputList[] = $myArchivedorderDetail;
        }

        return $outputList;
    }

    /**
     * Select the record, Interface with the outside (Controller Action)
     *
     * @param array $formData    : filter array to build WHERE condition
     * @param string $sortby     : indicating the order of select
     * @param string $sorttype   : DESC or ASC
     * @param string $limit      : the limit string, offset for LIMIT in SQL string
     * @param boolean $countOnly : flag to counting or return datalist
     *
     */
    public static function getArchivedorderDetails($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';


        if ($formData['fpid'] > 0) {
            $whereString .= ($whereString != ''? ' AND ' : '') . 'ad.p_id = ' . (int)$formData['fpid'] . ' ';
        }

        if ($formData['foorderid'] > 0) {
            $whereString .= ($whereString != ''? ' AND ' : '') . 'ad.o_orderid = ' . (int)$formData['foorderid'] . ' ';
        }

        if ($formData['fid'] > 0) {
            $whereString .= ($whereString != ''? ' AND ' : '') . 'ad.od_id = ' . (int)$formData['fid'] . ' ';
        }

        if ($formData['fsaleorderid'] != '') {
            $whereString .= ($whereString != ''? ' AND ' : '') . 'ad.od_saleorderid = "' . Helper::unspecialtext((string)$formData['fsaleorderid']) . '" ';
        }

        if ($formData['fproductid'] != '') {
            $whereString .= ($whereString != ''? ' AND ' : '') . 'ad.od_productid = "' . Helper::unspecialtext((string)$formData['fproductid']) . '" ';
        }


        //checking sort by & sort type
        if ($sorttype != 'DESC' && $sorttype != 'ASC') {
            $sorttype = 'DESC';
        }


        if ($sortby == 'id') {
            $orderString = 'od_id ' . $sorttype;
        } else {
            $orderString = 'od_id ' . $sorttype;
        }

        if ($countOnly) {
            return self::countList($whereString);
        } else {
            return self::getList($whereString, $orderString, $limit);
        }
    }

    public static function getDataSync()
    {
        global $db;
        $result = 0;
        $sql    = 'SELECT MAX(od_id) FROM ' . TABLE_PREFIX . 'archivedorder_detail ';
        $row    = $db->query($sql)->fetchColumn(0);
        if ($row != null && $row != 0 && $row != '') {

            $sql2   = 'SELECT o_orderid FROM ' . TABLE_PREFIX . 'archivedorder_detail where od_id="' . $row . '"';
            $rs     = $db->query($sql2)->fetch();
            $result = $rs['o_orderid'];

        }

        return $result;
    }

    public function deleteByOrderid($id)
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'archivedorder_detail
				WHERE o_orderid >= ?';
        $rowCount = $this->db->query($sql, array($id))->rowCount();

        return $rowCount;
    }
}