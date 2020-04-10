<?php

/**
 * core/class.stuffreview.php
 *
 * File contains the class used for StuffReview Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_StuffReview extends Core_Object
{
	const STATUS_PENDING = 1;
	const STATUS_ENABLE = 2;
	const STATUS_SPAM = 3;

	public $uid = 0;
	public $id = 0;
	public $objectid = 0;
	public $fullname = "";
	public $email = "";
	public $text = "";
	public $ipaddress = 0;
	public $moderatorid = 0;
	public $status = 0;
	public $countthumbup = 0;
	public $countthumbdown = 0;
	public $countreply = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $datemoderated = 0;
	public $parentid = 0;
	public $actor = '';
	public $stuff = '';

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stuff_review (
					u_id,
					r_objectid,
					r_fullname,
					r_email,
					r_text,
					r_ipaddress,
					r_moderatorid,
					r_status,
					r_countthumbup,
					r_countthumbdown,
					r_countreply,
					r_datecreated,
					r_datemodified,
					r_datemoderated,
					r_parentid
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->objectid,
					(string)$this->fullname,
					(string)$this->email,
					(string)$this->text,
					(int)$this->ipaddress,
					(int)$this->moderatorid,
					(int)$this->status,
					(int)$this->countthumbup,
					(int)$this->countthumbdown,
					(int)$this->countreply,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->datemoderated,
					(int)$this->parentid
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'stuff_review
				SET u_id = ?,
					r_objectid = ?,
					r_fullname = ?,
					r_email = ?,
					r_text = ?,
					r_ipaddress = ?,
					r_moderatorid = ?,
					r_status = ?,
					r_countthumbup = ?,
					r_countthumbdown = ?,
					r_countreply = ?,
					r_datecreated = ?,
					r_datemodified = ?,
					r_datemoderated = ?,
					r_parentid = ?
				WHERE r_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->objectid,
					(string)$this->fullname,
					(string)$this->email,
					(string)$this->text,
					(int)$this->ipaddress,
					(int)$this->moderatorid,
					(int)$this->status,
					(int)$this->countthumbup,
					(int)$this->countthumbdown,
					(int)$this->countreply,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->datemoderated,
					(int)$this->parentid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff_review sr
				WHERE sr.r_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['r_id'];
		$this->objectid = $row['r_objectid'];
		$this->fullname = $row['r_fullname'];
		$this->email = $row['r_email'];
		$this->text = $row['r_text'];
		$this->ipaddress = $row['r_ipaddress'];
		$this->moderatorid = $row['r_moderatorid'];
		$this->status = $row['r_status'];
		$this->countthumbup = $row['r_countthumbup'];
		$this->countthumbdown = $row['r_countthumbdown'];
		$this->countreply = $row['r_countreply'];
		$this->datecreated = $row['r_datecreated'];
		$this->datemodified = $row['r_datemodified'];
		$this->datemoderated = $row['r_datemoderated'];
		$this->parentid = $row['r_parentid'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stuff_review
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stuff_review sr';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff_review sr';

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
			$myStuffReview = new Core_StuffReview();

			$myStuffReview->uid = $row['u_id'];
			$myStuffReview->id = $row['r_id'];
			$myStuffReview->objectid = $row['r_objectid'];
			$myStuffReview->fullname = $row['r_fullname'];
			$myStuffReview->email = $row['r_email'];
			$myStuffReview->text = $row['r_text'];
			$myStuffReview->ipaddress = $row['r_ipaddress'];
			$myStuffReview->moderatorid = $row['r_moderatorid'];
			$myStuffReview->status = $row['r_status'];
			$myStuffReview->countthumbup = $row['r_countthumbup'];
			$myStuffReview->countthumbdown = $row['r_countthumbdown'];
			$myStuffReview->countreply = $row['r_countreply'];
			$myStuffReview->datecreated = $row['r_datecreated'];
			$myStuffReview->datemodified = $row['r_datemodified'];
			$myStuffReview->datemoderated = $row['r_datemoderated'];
			$myStuffReview->parentid = $row['r_parentid'];


            $outputList[] = $myStuffReview;
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
	public static function getStuffReviews($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_id = '.(int)$formData['fid'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_ipaddress = '.(int)$formData['fipaddress'].' ';

		if($formData['fmoderatorid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_moderatorid = '.(int)$formData['fmoderatorid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_status = '.(int)$formData['fstatus'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fparentid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_parentid = '.(int)$formData['fparentid'].' ';

		if(isset($formData['fparent']) && $formData['fparent'])
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_parentid = 0 ';


		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'text')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sr.r_text LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (sr.r_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (sr.r_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (sr.r_text LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'r_id ' . $sorttype;
		elseif($sortby == 'objectid')
			$orderString = 'r_objectid ' . $sorttype;
		elseif($sortby == 'moderatorid')
			$orderString = 'r_moderatorid ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'r_status ' . $sorttype;
		elseif($sortby == 'countthumbup')
			$orderString = 'r_countthumbup ' . $sorttype;
		elseif($sortby == 'countthumbdown')
			$orderString = 'r_countthumbdown ' . $sorttype;
		elseif($sortby == 'countreply')
			$orderString = 'r_countreply ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'r_datecreated ' . $sorttype;
		elseif($sortby == 'parentid')
			$orderString = 'r_parentid ' . $sorttype;
		else
			$orderString = 'r_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_PENDING] = 'Chờ duyệt';
		$output[self::STATUS_ENABLE] = 'Đã duyệt';
		$output[self::STATUS_SPAM] = 'Spam';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Đã duyệt'; break;
			case self::STATUS_PENDING: $name = 'Chờ duyệt'; break;
			case self::STATUS_SPAM: $name = 'Spam'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_PENDING && $name == 'pending' || $this->status == self::STATUS_SPAM && $name == 'spam')
			return true;
		else
			return false;
	}

	public static function getFullReview($review)
	{

		$output = array();
		$output[] = $review;
		$replyReviewList = Core_StuffReview::getStuffReviews(array('fobjectid' => $fpid,
                                                                        'fparentid' => $review->id,
                                                                        'fstatus' => Core_StuffReview::STATUS_ENABLE) , 'id' , 'ASC');
		foreach($replyReviewList as $reply)
		{
			$output = array_merge($output,self::getFullReview($reply));
		}

		return $output;
	}

}