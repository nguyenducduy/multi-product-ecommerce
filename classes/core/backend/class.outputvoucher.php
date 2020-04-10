<?php

/**
 * core/class.outputvoucher.php
 *
 * File contains the class used for Outputvoucher Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Outputvoucher extends Core_Backend_Object
{

	public $poid                  = 0;
	public $pbarcode              = "";
	public $promoid               = 0;
	public $coid                  = 0;
	public $sid                   = 0;
	public $id                    = 0;
	public $outputvoucherdetailid = "";
	public $outputvoucherid       = "";
	public $orderid               = "";
	public $invoiceid             = "";
	public $username              = 0;
	public $staffuser             = 0;
	public $outputdate            = 0;
	public $quantity              = 0;
	public $costprice             = 0;
	public $saleprice             = 0;
	public $totaldiscount         = 0;
	public $promotiondiscount     = 0;
	public $vat                   = 0;
	public $vatpercent            = 0;
	public $isnew                 = 0;
	public $voucherisdelete       = 0;
	public $iserror			      = 0;
	public $voucherdetailisdelete = 0;
	public $applyproductid        = "";
	public $ovorarowscn			  = 0;
	public $ovdorarowscn        = 0;
	public $originatestoreid        = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'outputvoucher (
					po_id,
					p_barcode,
					promo_id,
					co_id,
					s_id,
					ov_outputvoucherdetailid,
					ov_outputvoucherid,
					ov_orderid,
					ov_invoiceid,
					ov_username,
					ov_staffuser,
					ov_outputdate,
					ov_quantity,
					ov_costprice,
					ov_saleprice,
					ov_totaldiscount,
					ov_promotiondiscount,
					ov_vat,
					ov_vatpercent,
					ov_isnew,
					ov_voucherisdelete,
					ov_voucherdetailisdelete,
					ov_iserror,
					ov_applyproductid,
					ov_ovorarowscn,
					ov_ovdorarowscn,
					ov_originatestoreid
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->poid,
					(string)$this->pbarcode,
					(int)$this->promoid,
					(int)$this->coid,
					(int)$this->sid,
					(string)$this->outputvoucherdetailid,
					(string)$this->outputvoucherid,
					(string)$this->orderid,
					(string)$this->invoiceid,
					(int)$this->username,
					(int)$this->staffuser,
					(int)$this->outputdate,
					(int)$this->quantity,
					(float)$this->costprice,
					(float)$this->saleprice,
					(float)$this->totaldiscount,
					(float)$this->promotiondiscount,
					(int)$this->vat,
					(int)$this->vatpercent,
					(int)$this->isnew,
					(int)$this->voucherisdelete,
					(int)$this->voucherdetailisdelete,
					(int)$this->iserror,
					(string)$this->applyproductid,
					(string)$this->ovorarowscn,
					(string)$this->ovdorarowscn,
					(string)$this->originatestoreid,

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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'outputvoucher
				SET po_id = ?,
					p_barcode = ?,
					promo_id = ?,
					co_id = ?,
					s_id = ?,
					ov_outputvoucherdetailid = ?,
					ov_outputvoucherid = ?,
					ov_orderid = ?,
					ov_invoiceid = ?,
					ov_username = ?,
					ov_staffuser = ?,
					ov_outputdate = ?,
					ov_quantity = ?,
					ov_costprice = ?,
					ov_saleprice = ?,
					ov_totaldiscount = ?,
					ov_promotiondiscount = ?,
					ov_vat = ?,
					ov_vatpercent = ?,
					ov_isnew = ?,
					ov_voucherisdelete = ?,
					ov_voucherdetailisdelete = ?,
					ov_iserror = ?,
					ov_applyproductid = ?,
					ov_ovorarowscn = ?,
					ov_ovdorarowscn = ?,
					ov_originatestoreid = ?
				WHERE ov_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->poid,
					(string)$this->pbarcode,
					(int)$this->promoid,
					(int)$this->coid,
					(int)$this->sid,
					(string)$this->outputvoucherdetailid,
					(string)$this->outputvoucherid,
					(string)$this->orderid,
					(string)$this->invoiceid,
					(int)$this->username,
					(int)$this->staffuser,
					(int)$this->outputdate,
					(int)$this->quantity,
					(float)$this->costprice,
					(float)$this->saleprice,
					(float)$this->totaldiscount,
					(float)$this->promotiondiscount,
					(int)$this->vat,
					(int)$this->vatpercent,
					(int)$this->isnew,
					(int)$this->voucherisdelete,
					(int)$this->voucherdetailisdelete,
					(int)$this->iserror,
					(string)$this->applyproductid,
					(string)$this->ovorarowscn,
					(string)$this->ovdorarowscn,
					(string)$this->originatestoreid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'outputvoucher o
				WHERE o.ov_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->poid = $row['po_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->promoid = $row['promo_id'];
		$this->coid = $row['co_id'];
		$this->sid = $row['s_id'];
		$this->id = $row['ov_id'];
		$this->outputvoucherdetailid = $row['ov_outputvoucherdetailid'];
		$this->outputvoucherid = $row['ov_outputvoucherid'];
		$this->orderid = $row['ov_orderid'];
		$this->invoiceid = $row['ov_invoiceid'];
		$this->username = $row['ov_username'];
		$this->staffuser = $row['ov_staffuser'];
		$this->outputdate = $row['ov_outputdate'];
		$this->quantity = $row['ov_quantity'];
		$this->costprice = $row['ov_costprice'];
		$this->saleprice = $row['ov_saleprice'];
		$this->totaldiscount = $row['ov_totaldiscount'];
		$this->promotiondiscount = $row['ov_promotiondiscount'];
		$this->vat = $row['ov_vat'];
		$this->vatpercent = $row['ov_vatpercent'];
		$this->isnew = $row['ov_isnew'];
		$this->voucherisdelete = $row['ov_voucherisdelete'];
		$this->voucherdetailisdelete = $row['ov_voucherdetailisdelete'];
		$this->iserror = $row['ov_iserror'];
		$this->applyproductid = $row['ov_applyproductid'];
		$this->ovorarowscn = $row['ov_ovorarowscn'];
		$this->ovdorarowscn = $row['ov_ovdorarowscn'];
		$this->originatestoreid = $row['ov_originatestoreid'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'outputvoucher
				WHERE ov_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'outputvoucher o';

		if($where != '')
			$sql .= ' WHERE ' . $where;
		//echodebug($sql);
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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'outputvoucher o';

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
			$myOutputvoucher = new Core_Backend_Outputvoucher();

			$myOutputvoucher->poid = $row['po_id'];
			$myOutputvoucher->pbarcode = $row['p_barcode'];
			$myOutputvoucher->promoid = $row['promo_id'];
			$myOutputvoucher->coid = $row['co_id'];
			$myOutputvoucher->sid = $row['s_id'];
			$myOutputvoucher->id = $row['ov_id'];
			$myOutputvoucher->outputvoucherdetailid = $row['ov_outputvoucherdetailid'];
			$myOutputvoucher->outputvoucherid = $row['ov_outputvoucherid'];
			$myOutputvoucher->orderid = $row['ov_orderid'];
			$myOutputvoucher->invoiceid = $row['ov_invoiceid'];
			$myOutputvoucher->username = $row['ov_username'];
			$myOutputvoucher->staffuser = $row['ov_staffuser'];
			$myOutputvoucher->outputdate = $row['ov_outputdate'];
			$myOutputvoucher->quantity = $row['ov_quantity'];
			$myOutputvoucher->costprice = $row['ov_costprice'];
			$myOutputvoucher->saleprice = $row['ov_saleprice'];
			$myOutputvoucher->totaldiscount = $row['ov_totaldiscount'];
			$myOutputvoucher->promotiondiscount = $row['ov_promotiondiscount'];
			$myOutputvoucher->vat = $row['ov_vat'];
			$myOutputvoucher->vatpercent = $row['ov_vatpercent'];
			$myOutputvoucher->isnew = $row['ov_isnew'];
			$myOutputvoucher->voucherisdelete = $row['ov_voucherisdelete'];
			$myOutputvoucher->voucherdetailisdelete = $row['ov_voucherdetailisdelete'];
			$myOutputvoucher->iserror = $row['ov_iserror'];
			$myOutputvoucher->applyproductid = $row['ov_applyproductid'];
			$myOutputvoucher->ovdorarowscn = $row['ovdorarowscn'];
			$myOutputvoucher->ovorarowscn = $row['ov_ovorarowscn'];
			$myOutputvoucher->originatestoreid = $row['ov_originatestoreid'];

            $outputList[] = $myOutputvoucher;
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
	public static function getOutputvouchers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.po_id = '.(int)$formData['fpoid'].' ';

		if($formData['fovorarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_ovorarowscn = "'.(string)$formData['fovorarowscn'].'" ';

		if($formData['fovdorarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_ovdorarowscn = "'.(string)$formData['fovdorarowscn'].'" ';

		if($formData['foriginatestoreid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_originatestoreid = "'.(string)$formData['foriginatestoreid'].'" ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fpromoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.promo_id = '.(int)$formData['fpromoid'].' ';

		if($formData['fcoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.co_id = '.(int)$formData['fcoid'].' ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_id = '.(int)$formData['fid'].' ';

		if($formData['foutputvoucherdetailid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_outputvoucherdetailid = "'.Helper::unspecialtext((string)$formData['foutputvoucherdetailid']).'" ';

		if($formData['foutputvoucherid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_outputvoucherid = "'.Helper::unspecialtext((string)$formData['foutputvoucherid']).'" ';

		if($formData['forderid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_orderid = "'.Helper::unspecialtext((string)$formData['forderid']).'" ';

		if($formData['finvoiceid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_invoiceid = "'.Helper::unspecialtext((string)$formData['finvoiceid']).'" ';

		if($formData['fusername'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_username = '.(int)$formData['fusername'].' ';

		if($formData['fstaffuser'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_staffuser = '.(int)$formData['fstaffuser'].' ';

		if($formData['foutputdate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_outputdate = '.(int)$formData['foutputdate'].' ';

		if($formData['fvat'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_vat = '.(int)$formData['fvat'].' ';

		if($formData['fvatpercent'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_vatpercent = '.(int)$formData['fvatpercent'].' ';

		if($formData['fisnew'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_isnew = '.(int)$formData['fisnew'].' ';

		if($formData['fvoucherisdelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_voucherisdelete = '.(int)$formData['fvoucherisdelete'].' ';

		if($formData['fvoucherdetailisdelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ov_voucherdetailisdelete = '.(int)$formData['fvoucherdetailisdelete'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'poid')
			$orderString = 'po_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ov_id ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'ov_quantity ' . $sorttype;
		elseif($sortby == 'costprice')
			$orderString = 'ov_costprice ' . $sorttype;
		elseif($sortby == 'saleprice')
			$orderString = 'ov_saleprice ' . $sorttype;
		elseif($sortby == 'totaldiscount')
			$orderString = 'ov_totaldiscount ' . $sorttype;
		elseif($sortby == 'promotiondiscount')
			$orderString = 'ov_promotiondiscount ' . $sorttype;
		else
			$orderString = 'ov_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function updateDataByVoucherDetail($data, $vcdetail)
	{
		$db3 = self::getDb();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'outputvoucher
				SET ov_costprice = ?,
					ov_saleprice = ?,
					ov_totaldiscount = ?,
					ov_promotiondiscount = ?,
					ov_iserror = ?
				WHERE ov_outputvoucherdetailid = ?';

		$stmt = $db3->query($sql, array(
					(float)$data['ov_costprice'],
					(float)$data['ov_saleprice'],
					(float)$data['ov_totaldiscount'],
					(float)$data['ov_promotiondiscount'],
					(int)$data['ov_iserror'],
					(string)$vcdetail
					));

		if($stmt)
			return true;
		else
			return false;
	}


}