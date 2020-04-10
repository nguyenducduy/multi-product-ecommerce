<?php

/**
 * core/class.giarereviewthumb.php
 *
 * File contains the class used for GiareReviewThumb Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_GiareReviewThumb extends Core_Object
{

	public $robjectid = 0;
	public $rid = 0;
	public $uid = 0;
	public $id = 0;
	public $value = 0;
	public $ipaddress = 0;
	public $datecreared = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'giare_review_thumb (
					r_objectid,
					r_id,
					u_id,
					rt_value,
					rt_ipaddress,
					rt_datecreared,
					rt_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->robjectid,
					(int)$this->rid,
					(int)$this->uid,
					(int)$this->value,
					(int)$this->ipaddress,
					(int)$this->datecreared,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'giare_review_thumb
				SET r_objectid = ?,
					r_id = ?,
					u_id = ?,
					rt_value = ?,
					rt_ipaddress = ?,
					rt_datecreared = ?,
					rt_datemodified = ?
				WHERE rt_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->robjectid,
					(int)$this->rid,
					(int)$this->uid,
					(int)$this->value,
					(int)$this->ipaddress,
					(int)$this->datecreared,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giare_review_thumb grt
				WHERE grt.rt_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->robjectid = $row['r_objectid'];
		$this->rid = $row['r_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['rt_id'];
		$this->value = $row['rt_value'];
		$this->ipaddress = $row['rt_ipaddress'];
		$this->datecreared = $row['rt_datecreared'];
		$this->datemodified = $row['rt_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'giare_review_thumb
				WHERE rt_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'giare_review_thumb grt';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giare_review_thumb grt';

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
			$myGiareReviewThumb = new Core_GiareReviewThumb();

			$myGiareReviewThumb->robjectid = $row['r_objectid'];
			$myGiareReviewThumb->rid = $row['r_id'];
			$myGiareReviewThumb->uid = $row['u_id'];
			$myGiareReviewThumb->id = $row['rt_id'];
			$myGiareReviewThumb->value = $row['rt_value'];
			$myGiareReviewThumb->ipaddress = $row['rt_ipaddress'];
			$myGiareReviewThumb->datecreared = $row['rt_datecreared'];
			$myGiareReviewThumb->datemodified = $row['rt_datemodified'];


            $outputList[] = $myGiareReviewThumb;
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
	public static function getGiareReviewThumbs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['frobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'grt.r_objectid = '.(int)$formData['frobjectid'].' ';

		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'grt.r_id = '.(int)$formData['frid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'grt.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'grt.rt_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'rid')
			$orderString = 'r_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rt_id ' . $sorttype;
		elseif($sortby == 'datecreared')
			$orderString = 'rt_datecreared ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'rt_datemodified ' . $sorttype;
		else
			$orderString = 'rt_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getValueGiareThumb($countthumbup=true)
	{
		global $db;
		$sql = 'SELECT SUM( rt_value ) AS value , r_id, r_objectid FROM  '.TABLE_PREFIX.'giare_review_thumb
            WHERE rt_value = ? GROUP BY r_id';

        $cond = ($countthumbup) ? 1 : -1;
        $stmt = $db->query($sql , array($cond));
        $outputList = array();
        while($row = $stmt->fetch())
        {
            $myProductReviewThumb = new Core_ProductReviewThumb();
            $myProductReviewThumb->robjectid = $row['r_objectid'];
            $myProductReviewThumb->rid = $row['r_id'];
            $myProductReviewThumb->value = $row['value'];

            $outputList[] = $myProductReviewThumb;
        }

        return $outputList;
	}

}