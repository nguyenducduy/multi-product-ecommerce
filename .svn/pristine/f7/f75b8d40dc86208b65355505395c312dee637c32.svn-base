<?php

/**
 * core/class.relproductbookmark.php
 *
 * File contains the class used for RelProductbookmark Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelProductbookmark extends Core_Object
{

	public $pid = 0;
	public $pbarcode = "";
	public $uid = 0;
	public $id = 0;
	public $datecreated = 0;
	public $datemodified = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_productbookmark (
					p_id,
					p_barcode,
					u_id,
					rpb_datecreated,
					rpb_datemodified
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->uid,
					(int)$this->datecreated,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_productbookmark
				SET p_id = ?,
					p_barcode = ?,
					u_id = ?,
					rpb_datecreated = ?,
					rpb_datemodified = ?
				WHERE rpb_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->uid,
					(int)$this->datecreated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_productbookmark rp
				WHERE rp.rpb_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->uid = $row['u_id'];
		$this->id = $row['rpb_id'];
		$this->datecreated = $row['rpb_datecreated'];
		$this->datemodified = $row['rpb_datemodified'];

	}

	public static function checkproductbookmark($proid, $userid)
	{
		global $db;

		$proid = (int)$proid;
		$userid = (int)$userid;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_productbookmark rp
				WHERE rp.p_id = ? and rp.u_id = ?';
		$row = $db->query($sql, array($proid, $userid))->fetch();

		if($row)
			return true;
		else
			return false;

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_productbookmark
				WHERE rpb_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_productbookmark rp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_productbookmark rp';

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
			$myRelProductbookmark = new Core_RelProductbookmark();

			$myRelProductbookmark->pid = $row['p_id'];
			$myRelProductbookmark->pbarcode = $row['p_barcode'];
			$myRelProductbookmark->uid = $row['u_id'];
			$myRelProductbookmark->id = $row['rpb_id'];
			$myRelProductbookmark->datecreated = $row['rpb_datecreated'];
			$myRelProductbookmark->datemodified = $row['rpb_datemodified'];


            $outputList[] = $myRelProductbookmark;
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
	public static function getRelProductbookmarks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rp.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rp.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rp.rpb_id = '.(int)$formData['fid'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'pbarcode')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rp.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (rp.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rpb_id ' . $sorttype;
		else
			$orderString = 'rpb_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}