<?php

/**
 * core/class.productaward.php
 *
 * File contains the class used for ProductAward Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductAward extends Core_Object
{

	public $pbarcode = "";
	public $poid = 0;
	public $ppaid = 0;
	public $id = 0;
	public $totalawardforstaff = 0;
	public $datecreated = 0;
	public $updatedatedoferp = 0;

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
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_award (
					p_barcode,
					po_id,
					ppa_id,
					pw_totalawardforstaff,
					pw_datecreated,
					pw_updatedatedoferp
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->poid,
					(int)$this->ppaid,
					(float)$this->totalawardforstaff,
					(int)$this->datecreated,
					(int)$this->updatedatedoferp
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_award
				SET p_barcode = ?,
					po_id = ?,
					ppa_id = ?,
					pw_totalawardforstaff = ?,
					pw_datecreated = ?,
					pw_updatedatedoferp = ?
				WHERE pw_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->poid,
					(int)$this->ppaid,
					(float)$this->totalawardforstaff,
					(int)$this->datecreated,
					(int)$this->updatedatedoferp,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_award pw
				WHERE pw.pw_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->poid = $row['po_id'];
		$this->ppaid = $row['ppa_id'];
		$this->id = $row['pw_id'];
		$this->totalawardforstaff = $row['pw_totalawardforstaff'];
		$this->datecreated = $row['pw_datecreated'];
		$this->updatedatedoferp = $row['pw_updatedatedoferp'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_award
				WHERE pw_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_award pw';

		if($where != '')
			$sql .= ' WHERE ' . $where;

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
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_award pw';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myProductAward = new Core_ProductAward();

			$myProductAward->pbarcode = $row['p_barcode'];
			$myProductAward->poid = $row['po_id'];
			$myProductAward->ppaid = $row['ppa_id'];
			$myProductAward->id = $row['pw_id'];
			$myProductAward->totalawardforstaff = $row['pw_totalawardforstaff'];
			$myProductAward->datecreated = $row['pw_datecreated'];
			$myProductAward->updatedatedoferp = $row['pw_updatedatedoferp'];


            $outputList[] = $myProductAward;
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
	public static function getProductAwards($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pw.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fpoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pw.po_id = '.(int)$formData['fpoid'].' ';

		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pw.ppa_id = '.(int)$formData['fppaid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pw.pw_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pbarcode')
			$orderString = 'p_barcode ' . $sorttype;
		elseif($sortby == 'poid')
			$orderString = 'po_id ' . $sorttype;
		elseif($sortby == 'ppaid')
			$orderString = 'ppa_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'pw_id ' . $sorttype;
		elseif($sortby == 'totalawardforstaff')
			$orderString = 'pw_totalawardforstaff ' . $sorttype;
		else
			$orderString = 'pw_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getDataByBarcode()
	{
		$sql = 'SELECT * FROM '.TABLE_PREFIX.'product_award
				WHERE p_barcode = ? AND po_id = ? AND ppa_id = ?';

		$row = $this->db->query($sql , array($this->barcode ,
											$this->poid,
											$this->ppaid,
											))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->poid = $row['po_id'];
		$this->ppaid = $row['ppa_id'];
		$this->id = $row['pw_id'];
		$this->totalawardforstaff = $row['pw_totalawardforstaff'];
		$this->datecreated = $row['pw_datecreated'];
		$this->updatedatedoferp = $row['pw_updatedatedoferp'];
	}


}