<?php

/**
 * core/class.productrating.php
 *
 * File contains the class used for ProductRating Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductRating extends Core_Object
{

	public $reviewid = 0;
	public $uid = 0;
	public $id = 0;
	public $objectid = 0;
	public $fullname = "";
	public $email = "";
	public $value = 0;
	public $ipaddress = 0;
	public $status = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_rating (
					r_reviewid,
					u_id,
					r_objectid,
					r_fullname,
					r_email,
					r_value,
					r_ipaddress,
					r_status,
					r_datecreated,
					r_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->reviewid,
					(int)$this->uid,
					(int)$this->objectid,
					(string)$this->fullname,
					(string)$this->email,
					(int)$this->value,
					(int)$this->ipaddress,
					(int)$this->status,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_rating
				SET r_reviewid = ?,
					u_id = ?,
					r_objectid = ?,
					r_fullname = ?,
					r_email = ?,
					r_value = ?,
					r_ipaddress = ?,
					r_status = ?,
					r_datecreated = ?,
					r_datemodified = ?
				WHERE r_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->reviewid,
					(int)$this->uid,
					(int)$this->objectid,
					(string)$this->fullname,
					(string)$this->email,
					(int)$this->value,
					(int)$this->ipaddress,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_rating prt
				WHERE prt.r_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->reviewid = $row['r_reviewid'];
		$this->uid = $row['u_id'];
		$this->id = $row['r_id'];
		$this->objectid = $row['r_objectid'];
		$this->fullname = $row['r_fullname'];
		$this->email = $row['r_email'];
		$this->value = $row['r_value'];
		$this->ipaddress = $row['r_ipaddress'];
		$this->status = $row['r_status'];
		$this->datecreated = $row['r_datecreated'];
		$this->datemodified = $row['r_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_rating
				WHERE r_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_rating prt';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_rating prt';

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
			$myProductRating = new Core_ProductRating();

			$myProductRating->reviewid = $row['r_reviewid'];
			$myProductRating->uid = $row['u_id'];
			$myProductRating->id = $row['r_id'];
			$myProductRating->objectid = $row['r_objectid'];
			$myProductRating->fullname = $row['r_fullname'];
			$myProductRating->email = $row['r_email'];
			$myProductRating->value = $row['r_value'];
			$myProductRating->ipaddress = $row['r_ipaddress'];
			$myProductRating->status = $row['r_status'];
			$myProductRating->datecreated = $row['r_datecreated'];
			$myProductRating->datemodified = $row['r_datemodified'];


            $outputList[] = $myProductRating;
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
	public static function getProductRatings($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['freviewid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_reviewid = '.(int)$formData['freviewid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_id = '.(int)$formData['fid'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['ffullname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_fullname = "'.Helper::unspecialtext((string)$formData['ffullname']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'prt.r_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (prt.r_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (prt.r_email LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'reviewid')
			$orderString = 'r_reviewid ' . $sorttype;
		elseif($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'r_id ' . $sorttype;
		elseif($sortby == 'objectid')
			$orderString = 'r_objectid ' . $sorttype;
		else
			$orderString = 'r_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}