<?php

/**
 * core/class.inputvoucher.php
 *
 * File contains the class used for Inputvoucher Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Inputvoucher extends Core_Backend_Object
{

	public $inputvoucherid = "";
	public $inputvoucherdetailid = "";
	public $orderid = "";
	public $invoiceid = "";
	public $sid = 0;
	public $piid = 0;
	public $pbarcode = "";
	public $id = 0;
	public $username = 0;
	public $inputdate = 0;
	public $quantity = 0;
	public $price = 0;
	public $inputprice = 0;
	public $discount = 0;
	public $vat = 0;
	public $vatpercent = 0;
	public $isnew = 0;
	public $isvoucherdelete = 0;
	public $orarowscn = 0;
	public $dorarowscn = 0;
	public $isvoucherdetaildelete = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'inputvoucher (
					iv_inputvoucherid,
					iv_inputvoucherdetailid,
					iv_orderid,
					iv_invoiceid,
					s_id,
					pi_id,
					p_barcode,
					iv_username,
					iv_inputdate,
					iv_quantity,
					iv_price,
					iv_inputprice,
					iv_discount,
					iv_vat,
					iv_vatpercent,
					iv_isnew,
					iv_isvoucherdelete,
					iv_isvoucherdetaildelete,
					iv_orarowscn,
					iv_dorarowscn
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->inputvoucherid,
					(string)$this->inputvoucherdetailid,
					(string)$this->orderid,
					(string)$this->invoiceid,
					(int)$this->sid,
					(int)$this->piid,
					(string)$this->pbarcode,
					(int)$this->username,
					(int)$this->inputdate,
					(int)$this->quantity,
					(float)$this->price,
					(float)$this->inputprice,
					(float)$this->discount,
					(float)$this->vat,
					(float)$this->vatpercent,
					(int)$this->isnew,
					(int)$this->isvoucherdelete,
					(int)$this->isvoucherdetaildelete,
					$this->orarowscn,
					$this->dorarowscn
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'inputvoucher
				SET iv_inputvoucherid = ?,
					iv_inputvoucherdetailid = ?,
					iv_orderid = ?,
					iv_invoiceid = ?,
					s_id = ?,
					pi_id = ?,
					p_barcode = ?,
					iv_username = ?,
					iv_inputdate = ?,
					iv_quantity = ?,
					iv_price = ?,
					iv_inputprice = ?,
					iv_discount = ?,
					iv_vat = ?,
					iv_vatpercent = ?,
					iv_isnew = ?,
					iv_isvoucherdelete = ?,
					iv_isvoucherdetaildelete = ?,
					iv_orarowscn = ?,
					iv_dorarowscn = ?
				WHERE iv_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->inputvoucherid,
					(string)$this->inputvoucherdetailid,
					(string)$this->orderid,
					(string)$this->invoiceid,
					(int)$this->sid,
					(int)$this->piid,
					(string)$this->pbarcode,
					(int)$this->username,
					(int)$this->inputdate,
					(int)$this->quantity,
					(float)$this->price,
					(float)$this->inputprice,
					(float)$this->discount,
					(float)$this->vat,
					(float)$this->vatpercent,
					(int)$this->isnew,
					(int)$this->isvoucherdelete,
					(int)$this->isvoucherdetaildelete,
					$this->orarowscn,
					$this->dorarowscn,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'inputvoucher i
				WHERE i.iv_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->inputvoucherid = $row['iv_inputvoucherid'];
		$this->inputvoucherdetailid = $row['iv_inputvoucherdetailid'];
		$this->orderid = $row['iv_orderid'];
		$this->invoiceid = $row['iv_invoiceid'];
		$this->sid = $row['s_id'];
		$this->piid = $row['pi_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['iv_id'];
		$this->username = $row['iv_username'];
		$this->inputdate = $row['iv_inputdate'];
		$this->quantity = $row['iv_quantity'];
		$this->price = $row['iv_price'];
		$this->inputprice = $row['iv_inputprice'];
		$this->discount = $row['iv_discount'];
		$this->vat = $row['iv_vat'];
		$this->vatpercent = $row['iv_vatpercent'];
		$this->isnew = $row['iv_isnew'];
		$this->isvoucherdelete = $row['iv_isvoucherdelete'];
		$this->isvoucherdetaildelete = $row['iv_isvoucherdetaildelete'];
		$this->orarowscn = $row['iv_orarowscn'];
		$this->dorarowscn = $row['iv_dorarowscn'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'inputvoucher
				WHERE iv_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'inputvoucher i';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db3->query($sql)->fetchColumn(0);
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
		$db3 = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'inputvoucher i';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myInputvoucher = new Core_Backend_Inputvoucher();

			$myInputvoucher->inputvoucherid = $row['iv_inputvoucherid'];
			$myInputvoucher->inputvoucherdetailid = $row['iv_inputvoucherdetailid'];
			$myInputvoucher->orderid = $row['iv_orderid'];
			$myInputvoucher->invoiceid = $row['iv_invoiceid'];
			$myInputvoucher->sid = $row['s_id'];
			$myInputvoucher->piid = $row['pi_id'];
			$myInputvoucher->pbarcode = $row['p_barcode'];
			$myInputvoucher->id = $row['iv_id'];
			$myInputvoucher->username = $row['iv_username'];
			$myInputvoucher->inputdate = $row['iv_inputdate'];
			$myInputvoucher->quantity = $row['iv_quantity'];
			$myInputvoucher->price = $row['iv_price'];
			$myInputvoucher->inputprice = $row['iv_inputprice'];
			$myInputvoucher->discount = $row['iv_discount'];
			$myInputvoucher->vat = $row['iv_vat'];
			$myInputvoucher->vatpercent = $row['iv_vatpercent'];
			$myInputvoucher->isnew = $row['iv_isnew'];
			$myInputvoucher->isvoucherdelete = $row['iv_isvoucherdelete'];
			$myInputvoucher->isvoucherdetaildelete = $row['iv_isvoucherdetaildelete'];
			$myInputvoucher->orarowscn = $row['iv_orarowscn'];
			$myInputvoucher->dorarowscn = $row['iv_dorarowscn'];

            $outputList[] = $myInputvoucher;
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
	public static function getInputvouchers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['finputvoucherid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_inputvoucherid = "'.Helper::unspecialtext((string)$formData['finputvoucherid']).'" ';

		if($formData['forarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_orarowscn = "'.(string)$formData['forarowscn'].'" ';

		if($formData['fdorarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_dorarowscn = "'.(string)$formData['fdorarowscn'].'" ';

		if($formData['finputvoucherdetailid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_inputvoucherdetailid = "'.Helper::unspecialtext((string)$formData['finputvoucherdetailid']).'" ';

		if($formData['forderid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_orderid = "'.Helper::unspecialtext((string)$formData['forderid']).'" ';

		if($formData['finvoiceid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_invoiceid = "'.Helper::unspecialtext((string)$formData['finvoiceid']).'" ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_id = '.(int)$formData['fid'].' ';

		if($formData['fusername'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_username = '.(int)$formData['fusername'].' ';

		if($formData['finputdate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_inputdate = '.(int)$formData['finputdate'].' ';

		if($formData['fquantity'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_quantity = '.(int)$formData['fquantity'].' ';

		if($formData['finputprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_inputprice = '.(float)$formData['finputprice'].' ';

		if($formData['fisnew'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_isnew = '.(int)$formData['fisnew'].' ';

		if($formData['fisvoucherdelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_isvoucherdelete = '.(int)$formData['fisvoucherdelete'].' ';

		if($formData['fisvoucherdetaildelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.iv_isvoucherdetaildelete = '.(int)$formData['fisvoucherdetaildelete'].' ';

		if($formData['fpiid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.pi_id = '.(int)$formData['fpiid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'iv_id ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'iv_quantity ' . $sorttype;
		elseif($sortby == 'inputprice')
			$orderString = 'iv_inputprice ' . $sorttype;
		else
			$orderString = 'iv_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

   	public static function updateDataByVoucherDetail($data, $vcdetail)
	{
		$db3 = self::getDb();
		$sql = 'UPDATE ' . TABLE_PREFIX . 'inputvoucher
				SET iv_price = ?,
					iv_discount = ?,
					iv_inputprice = ?
				WHERE iv_inputvoucherdetailid = ?';

		$stmt = $db3->query($sql, array(
					(float)$data['iv_price'],
					(float)$data['iv_discount'],
					(float)$data['iv_inputprice'],
					(string)$vcdetail
					));

		if($stmt)
			return true;
		else
			return false;
	}

	public static function getlastinputprice($pbarcode)
	{
		$result = array();
		$db3 = self::getDb();
		if(strlen($pbarcode) > 0)
		{
			$sql = 'SELECT iv_inputdate , iv_inputprice , iv_discount , iv_vat , iv_vatpercent FROM ' . TABLE_PREFIX . 'inputvoucher WHERE p_barcode = ? AND iv_inputprice > 0 ORDER BY iv_inputdate DESC LIMIT 0,1';
			$row = $db3->query($sql , array(trim($pbarcode)))->fetch();
			$result['inputdate'] = date('d/m/Y' , (int)$row['iv_inputdate']);
			$result['inputprice'] = (float)$row['iv_inputprice'];
			$result['discount'] = (float)$row['iv_discount'];
			$result['vat'] = (float)$row['iv_vat'];
			$result['vatpercent'] = (float)$row['iv_vatpercent'];
		}

		return $result;
	}
}