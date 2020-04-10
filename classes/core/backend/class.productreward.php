<?php

/**
 * core/class.productreward.php
 *
 * File contains the class used for Productreward Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Productreward extends Core_Backend_Object
{

	public $poid = 0;
	public $ppaid = 0;
	public $id = 0;
	public $pbarcode = "";
	public $totalrewardforstaff = 0;
	public $isconfirmrewardforstaff = 0;
	public $updateddate = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productreward (
					po_id,
					ppa_id,
					p_barcode,
					pr_totalrewardforstaff,
					pr_isconfirmrewardforstaff,
					pr_updateddate
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->poid,
					(int)$this->ppaid,
					(string)$this->pbarcode,
					(int)$this->totalrewardforstaff,
					(int)$this->isconfirmrewardforstaff,
					(int)$this->updateddate
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'productreward
				SET po_id = ?,
					ppa_id = ?,
					p_barcode = ?,
					pr_totalrewardforstaff = ?,
					pr_isconfirmrewardforstaff = ?,
					pr_updateddate = ?
				WHERE pr_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->poid,
					(int)$this->ppaid,
					(string)$this->pbarcode,
					(int)$this->totalrewardforstaff,
					(int)$this->isconfirmrewardforstaff,
					(int)$this->updateddate,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productreward p
				WHERE p.pr_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->poid = $row['po_id'];
		$this->ppaid = $row['ppa_id'];
		$this->id = $row['pr_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->totalrewardforstaff = $row['pr_totalrewardforstaff'];
		$this->isconfirmrewardforstaff = $row['pr_isconfirmrewardforstaff'];
		$this->updateddate = $row['pr_updateddate'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'productreward
				WHERE pr_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productreward p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productreward p';

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
			$myProductreward = new Core_Backend_Productreward();

			$myProductreward->poid = $row['po_id'];
			$myProductreward->ppaid = $row['ppa_id'];
			$myProductreward->id = $row['pr_id'];
			$myProductreward->pbarcode = $row['p_barcode'];
			$myProductreward->totalrewardforstaff = $row['pr_totalrewardforstaff'];
			$myProductreward->isconfirmrewardforstaff = $row['pr_isconfirmrewardforstaff'];
			$myProductreward->updateddate = $row['pr_updateddate'];


            $outputList[] = $myProductreward;
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
	public static function getProductrewards($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.po_id = '.(int)$formData['fpoid'].' ';

		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ppa_id = '.(int)$formData['fppaid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pr_id = '.(int)$formData['fid'].' ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fisconfirmrewardforstaff'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pr_isconfirmrewardforstaff = '.(int)$formData['fisconfirmrewardforstaff'].' ';

		if($formData['fupdateddate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pr_updateddate = '.(int)$formData['fupdateddate'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'poid')
			$orderString = 'po_id ' . $sorttype;
		elseif($sortby == 'ppaid')
			$orderString = 'ppa_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'pr_id ' . $sorttype;
		elseif($sortby == 'updateddate')
			$orderString = 'pr_updateddate ' . $sorttype;
		else
			$orderString = 'pr_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}