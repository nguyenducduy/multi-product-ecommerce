<?php

/**
 * core/class.productprice.php
 *
 * File contains the class used for ProductPrice Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductPrice extends Core_Object
{

	const ERRORPRODUCTEXIST = 1;
	const WARININGNOTCHANGE = 2;
	const SYNCSUCCESS = 3;
	const SYNCERROR = 4;

    public $tgdduid = 0;
	public $pid = 0;
	public $pbarcode = "";
	public $ppaid = 0;
	public $sid = 0;
	public $aid = 0;
	public $rid = 0;
	public $poid = 0;
	public $id = 0;
	public $sellprice = 0;
	public $discount = 0;
	public $confirm = 0;
	public $datemodified = 0;
	public $priceareaActor = null;
	public $outputtypeActor = null;
	public $storeActor = null;
	public $regionActor = null;
	public $areaActor = null;

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price (
                    ttgdd_uid,
					p_id,
					p_barcode,
					ppa_id,
					s_id,
					a_id,
					r_id,
					po_id,
					pp_sellprice,
					pp_discount,
					pp_confirm ,
					pp_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
                    (int)$this->tgdduid,
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->ppaid,
					(int)$this->sid,
					(int)$this->aid,
					(int)$this->rid,
					(int)$this->poid,
					(float)$this->sellprice,
					(float)$this->discount,
					(int)$this->confirm,
					(int)$this->datemodified
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
				SET tgdd_uid = ?,
                    p_id = ?,
					p_barcode = ?,
					ppa_id = ?,
					s_id = ?,
					a_id = ?,
					r_id = ?,
					po_id = ?,
					pp_sellprice = ?,
					pp_discount = ?,
					pp_confirm = ?,
					pp_datemodified = ?
				WHERE pp_id = ?';

		$stmt = $this->db->query($sql, array(
                    (int)$this->tgdduid,
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->ppaid,
					(int)$this->sid,
					(int)$this->aid,
					(int)$this->rid,
					(int)$this->poid,
					(float)$this->sellprice,
					(float)$this->discount,
					(int)$this->confirm,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}

	/**
	 * Get the object data base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public function getData($id)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_price pp
				WHERE pp.pp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

        $this->tgdduid = $row['tgdd_uid'];
		$this->pid = $row['p_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->ppaid = $row['ppa_id'];
		$this->sid = $row['s_id'];
		$this->aid = $row['a_id'];
		$this->rid = $row['r_id'];
		$this->poid = $row['po_id'];
		$this->id = $row['pp_id'];
		$this->sellprice = $row['pp_sellprice'];
		$this->discount = $row['pp_discount'];
		$this->confirm = $row['pp_confirm'];
		$this->datemodified = $row['pp_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price
				WHERE pp_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where, $groupby)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_price pp';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($groupby)
			$sql .= 'GROUP BY ppa_id';
        //echo $sql;die();
		return $db->query($sql)->fetchColumn(0);
	}

	/**
	 * Get the record in the table with paginating and filtering
	 *
	 * @param string $where the WHERE condition in SQL string
	 * @param string $order the ORDER in SQL string
	 * @param string $limit the LIMIT in SQL string
	 */
	public static function getList($where, $order, $limit = '', $groupby)
	{
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_price pp';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($groupby)
			$sql .= 'GROUP BY ppa_id';

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myProductPrice = new Core_ProductPrice();

            $myProductPrice->tgdduid = $row['tgdd_uid'];
			$myProductPrice->pid = $row['p_id'];
			$myProductPrice->pbarcode = $row['p_barcode'];
			$myProductPrice->ppaid = $row['ppa_id'];
			$myProductPrice->sid = $row['s_id'];
			$myProductPrice->aid = $row['a_id'];
			$myProductPrice->rid = $row['r_id'];
			$myProductPrice->poid = $row['po_id'];
			$myProductPrice->id = $row['pp_id'];
			$myProductPrice->sellprice = $row['pp_sellprice'];
			$myProductPrice->discount = $row['pp_discount'];
			$myProductPrice->datemodified = $row['pp_datemodified'];
			$myProductPrice->priceareaActor = new Core_ProductPriceArea($myProductPrice->ppaid);
			$myProductPrice->outputtypeActor = new Core_ProductOutputype($myProductPrice->poid);


            $outputList[] = $myProductPrice;
        }

        return $outputList;
    }

	/**
	 * Select the record, Interface with the outside (Controller Action)
	 *
	 * @param array $formData : filter array to build WHERE condition
	 * @param string $sortby : indicating the order of select
	 * @param string $sorttype : DESC or ASC
	 * @param string $limit: the limit string, offset for LIMIT in SQL string
	 * @param boolean $countOnly: flag to counting or return datalist
	 *
	 */
	public static function getProductPrices($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $groupby = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.p_barcode = "'.Helper::unspecialtext(trim((string)$formData['fpbarcode'])).'" ';

		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.ppa_id = '.(int)$formData['fppaid'].' ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.s_id = '.(int)$formData['fsid'].' ';

		if($formData['faid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.a_id = '.(int)$formData['faid'].' ';

		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.r_id = '.(int)$formData['frid'].' ';

		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.ppa_id = '.(int)$formData['fppaid'].' ';

		if(isset($formData['fpoid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.po_id = '.(int)$formData['fpoid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_id = '.(int)$formData['fid'].' ';

		if($formData['fsellprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_sellprice = '.(float)$formData['fsellprice'].' ';

		if($formData['fdiscount'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_discount = '.(float)$formData['fdiscount'].' ';

		if($formData['fhaveprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_sellprice > 0 ';

		if(count($formData['fppaidarr']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.ppa_id IN ('.implode(',', $formData['fppaidarr']).') ';

		if(isset($formData['fpoidarr']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.po_id IN ('.implode(',' , $formData['fpoidarr']).') ';

		if(isset($formData['fhavesellprice']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_sellprice > 0 ';

		if(isset($formData['fconfirm']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_confirm > 0 ';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pbarcode')
			$orderString = 'p_barcode ' . $sorttype;
		elseif($sortby == 'ppaid')
			$orderString = 'ppa_id ' . $sorttype;
		elseif($sortby == 'poid')
			$orderString = 'po_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ppa_id,pp_id ' . $sorttype;
		elseif($sortby == 'sellprice')
			$orderString = 'pp_sellprice ' . $sorttype;
		elseif($sortby == 'discount')
			$orderString = 'pp_discount ' . $sorttype;
		else
			$orderString = 'ppa_id,pp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString,$groupby);
		else
			return self::getList($whereString, $orderString, $limit,$groupby);
	}

	public function getProductPriceByBarcode($barcode, $pid)
	{
		$sql = 'SELECT DISTINCT(ppa_id) , p_id, p_barcode, po_id, pp_id, pp_sellprice, pp_discount, pp_confirm , s_id , a_id , r_id, pp_datemodified FROM ' . TABLE_PREFIX . 'product_price
				WHERE p_barcode = ? AND p_id = ?';
		$row = $this->db->query($sql , array($barcode, $pid))->fetch();

        $this->tgdduid = $row['tgdd_uid'];
		$this->pid = $row['p_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->ppaid = $row['ppa_id'];
        $this->sid = $row['s_id'];
        $this->aid = $row['a_id'];
        $this->rid = $row['r_id'];
		$this->poid = $row['po_id'];
		$this->id = $row['pp_id'];
		$this->sellprice = $row['pp_sellprice'];
		$this->discount = $row['pp_discount'];
		$this->confirm = $row['pp_confirm'];
		$this->datemodified = $row['pp_datemodified'];
	}

    public static function  getProductPriceByArea($barcode)
    {
        global $db;
        $outputlist = array();
        if (!empty($barcode)) {

            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_price
                    WHERE p_barcode = ? AND ppa_id = 242 AND po_id IN(0,222) GROUP BY po_id';
            $stmt = $db->query($sql , array($barcode));

            while ($row = $stmt->fetch()) {
                $myProductPrice = new Core_ProductPrice();

                $myProductPrice->tgdduid = $row['tgdd_uid'];
                $myProductPrice->pid = $row['p_id'];
                $myProductPrice->pbarcode = $row['p_barcode'];
                $myProductPrice->ppaid = $row['ppa_id'];
                $myProductPrice->sid = $row['s_id'];
                $myProductPrice->aid = $row['a_id'];
                $myProductPrice->rid = $row['r_id'];
                $myProductPrice->poid = $row['po_id'];
                $myProductPrice->id = $row['pp_id'];
                $myProductPrice->sellprice = $row['pp_sellprice'];
                $myProductPrice->discount = $row['pp_discount'];
                $myProductPrice->datemodified = $row['pp_datemodified'];

                $outputlist[] = $myProductPrice;
            }
        }

        return $outputlist;
    }

	public static function syncProductPrice($pbarcode = '')
	{
		global $db;
		$result = 0;
		$oracle = new Oracle();
        $pbarcode = trim($pbarcode);
		$sql = 'select P.UPDATEDPRICEUSER,P.PRICEAREAID, P.OUTPUTTYPEID, p.updatedpricedate ,P.PRODUCTID, P.SALEPRICE, P.ISPRICECONFIRMED, S.STOREID , S.AREAID, S.PROVINCEID
                    from ERP.VW_PRICE_PRODUCT_DM P
                    INNER JOIN ERP.VW_PM_STORE_DM S ON S.PRICEAREAID = P.PRICEAREAID
                    where P.ISPRICECONFIRMED = 1 AND P.PRODUCTID =\'' .$pbarcode. '\'';



        $results = $oracle->query($sql);

        //xoa tat ca cac gia cu da luu cua san pham
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price WHERE p_barcode = ?';
        $rowCounts2 = $db->query($sql, array($pbarcode));

        foreach($results as $res)
        {
            $countProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $pbarcode , 'fppaid' => $res['PRICEAREAID'] , 'fpoid' => $res['OUTPUTTYPEID'], 'fsid' => $res['STOREID'] ,'faid' => $res['AREAID'] , 'frid' => $res['PROVINCEID']),'id','ASC','',true);

                //echodebug($countProductPrice,true);

                if($countProductPrice > 0)
                {
                      $sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
                                SET pp_sellprice = ?,
                                    pp_discount = ?,
                                    pp_confirm = ?,
                                    tgdd_uid = ?,
                                    pp_datemodified = ?
                                WHERE p_barcode = ?  AND ppa_id = ? AND po_id = ? AND s_id = ? AND a_id = ? AND r_id = ?';
                        $stmt = $db->query($sql , array((float)$res['SALEPRICE'],
                                                            (int)$res['DISCOUNT'],
                                                            (int)$res['ISPRICECONFIRMED'],
                                                            (int)$res['UPDATEDPRICEUSER'],
                                                            time(),
                                                            $pbarcode ,
                                                            $res['PRICEAREAID'],
                                                            $res['OUTPUTTYPEID'],
                                                            $res['STOREID'],
                                                            $res['AREAID'],
                                                            $res['PROVINCEID']
                                                            ));

                }
                else
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
                    $stmt = $db->query($sql , array(
                                                            (int)$res['UPDATEDPRICEUSER'],
                                                            (int)$res['PRODUCTIDREF'],
                                                            trim($pbarcode),
                                                            (int)$res['PRICEAREAID'],
                                                            $res['STOREID'],
                                                            $res['AREAID'],
                                                            $res['PROVINCEID'],
                                                            (int)$res['OUTPUTTYPEID'],
                                                            (float)$res['SALEPRICE'],
                                                            (int)$res['DISCOUNT'],
                                                            (int)$res['ISPRICECONFIRMED'],
                                                            ));

                }

        }

        if($stmt)
        {
        	$sql = 'SELECT p_barcode , p_sellprice , p_finalprice FROM ' . TABLE_PREFIX . 'product WHERE p_barcode = ?';
        	$row = $db->query($sql , array($pbarcode))->fetch();


            //cap nhat gia cho san pham
            $sql = 'SELECT pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                            WHERE ppa_id = 242 AND po_id = 0 AND p_barcode = ? AND pp_confirm = 1';

            $row1 = $db->query($sql,array($pbarcode))->fetch();

            if((float)$row1['pp_sellprice'] <= 0)
            {
                $sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                            WHERE ppa_id = 242 AND po_id = 222 AND p_barcode = ' . $pbarcode .' AND pp_confirm = 1';
                $row2 = $db->query($sql)->fetch();
                if($row2['pp_sellprice'] > 0)
                {
                	 //kiem tra cap nhat final price
                    if($row['p_finalprice'] == 0)
                    {
                        $sql = 'UPDATE '. TABLE_PREFIX .'product
                            SET p_finalprice = '.(float)$result1['pp_sellprice'].'
                            WHERE p_barcode = ' . (string)$row['p_barcode'];
                        $result2 = $db->query($sql);
                    }

                     $sql = 'UPDATE '. TABLE_PREFIX .'product
                        SET p_sellprice = ' . $row2['pp_sellprice'].'
                        WHERE p_barcode = ' . Helper::plaintext($pbarcode);
                      $stmt1 = $db->query($sql);
                }
                else
                {
                	$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_sellprice = 0
                			WHERE p_barcode = ' . Helper::plaintext($pbarcode);
                	$stmt1 = $db->query($sql);
                }
            }
            else
            {
            	 //kiem tra cap nhat final price
                if((float)$row['p_finalprice'] == 0)
                {
                    $sql = 'UPDATE '. TABLE_PREFIX .'product
                        SET p_finalprice = '.(float)$row1['pp_sellprice'].'
                        WHERE p_barcode = ' . (string)$row['p_barcode'];
                    $result2 = $db->query($sql);
                }

                $sql = 'UPDATE '. TABLE_PREFIX .'product
                        SET p_sellprice = ' . $row1['pp_sellprice'].'
                        WHERE p_barcode = ' . Helper::plaintext($pbarcode);
                $stmt1 = $db->query($sql);
            }

            if($stmt1)
            {
                $result = Core_ProductPrice::SYNCSUCCESS;
            }
            else
            {
                $result = Core_ProductPrice::SYNCERROR;
            }

        }
        else
        {
            $result = Core_ProductPrice::SYNCERROR;
        }

		return $result;
	}


}

