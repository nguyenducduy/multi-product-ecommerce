<?php

/**
 * core/class.subscriber.php
 *
 * File contains the class used for Subscriber Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Subscriber extends Core_Object
{

	public $id = 0;
	public $uid = 0;
	public $fullname = '';
	public $campaign = 0;
	public $email = '';
	public $sms = 0;
	public $phone = '';
	public $ipaddress = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'subscriber (
					u_id,
					s_fullname,
					s_campaign,
					s_email,
					s_sms,
					s_phone,
					s_ipaddress,
					s_datecreated,
					s_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ? , ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->fullname,
					(int)$this->campaign,
					(string)$this->email,
					(string)$this->sms,
					(string)$this->phone,
					(int)$this->ipaddress,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'subscriber
				SET u_id = ?,
					s_fullname = ?,
					s_campaign = ?,
					s_email = ?,
					s_sms = ?,
					s_phone = ?,
					s_ipaddress = ?,
					s_datecreated = ?,
					s_datemodified = ?
				WHERE s_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->fullname,
					(int)$this->campaign,
					(string)$this->email,
					(string)$this->sms,
					(string)$this->phone,
					(int)$this->ipaddress,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'subscriber s
				WHERE s.s_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['s_id'];
		$this->uid = $row['u_id'];
		$this->fullname = $row['s_fullname'];
		$this->campaign = $row['s_campaign'];
		$this->email = $row['s_email'];
		$this->sms = $row['s_sms'];
		$this->phone = $row['s_phone'];
		$this->ipaddress = $row['s_ipaddress'];
		$this->datecreated = $row['s_datecreated'];
		$this->datemodified = $row['s_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'subscriber
				WHERE s_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'subscriber s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'subscriber s';

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
			$mySubscriber = new Core_Subscriber();

			$mySubscriber->id = $row['s_id'];
			$mySubscriber->uid = $row['u_id'];
			$mySubscriber->fullname = $row['s_fullname'];
			$mySubscriber->campaign = $row['s_campaign'];
			$mySubscriber->email = $row['s_email'];
			$mySubscriber->sms = $row['s_sms'];
			$mySubscriber->phone = $row['s_phone'];
			$mySubscriber->ipaddress = $row['s_ipaddress'];
			$mySubscriber->datecreated = $row['s_datecreated'];
			$mySubscriber->datemodified = $row['s_datemodified'];


            $outputList[] = $mySubscriber;
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
	public static function getSubscribers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_id = '.(int)$formData['fid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.u_id = '.(int)$formData['fuid'].' ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';
		if($formData['fsms'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_sms = "'.Helper::unspecialtext((string)$formData['fsms']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (s.s_email LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'email')
			$orderString = 's_email ' . $sorttype;
		else
			$orderString = 's_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}