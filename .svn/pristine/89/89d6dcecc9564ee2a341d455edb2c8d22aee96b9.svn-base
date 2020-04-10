<?php

/**
 * core/class.apipartner.php
 *
 * File contains the class used for ApiPartner Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ApiPartner extends Core_Backend_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $uid = 0;
	public $id = 0;
	public $key = "";
	public $secret = "";
	public $name = "";
	public $email = "";
	public $phone = "";
	public $description = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'api_partner (
					u_id,
					ap_key,
					ap_secret,
					ap_name,
					ap_email,
					ap_phone,
					ap_description,
					ap_status,
					ap_datecreated,
					ap_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->key,
					(string)$this->secret,
					(string)$this->name,
					(string)$this->email,
					(string)$this->phone,
					(string)$this->description,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'api_partner
				SET u_id = ?,
					ap_key = ?,
					ap_secret = ?,
					ap_name = ?,
					ap_email = ?,
					ap_phone = ?,
					ap_description = ?,
					ap_status = ?,
					ap_datecreated = ?,
					ap_datemodified = ?
				WHERE ap_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->key,
					(string)$this->secret,
					(string)$this->name,
					(string)$this->email,
					(string)$this->phone,
					(string)$this->description,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'api_partner ap
				WHERE ap.ap_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['ap_id'];
		$this->key = $row['ap_key'];
		$this->secret = $row['ap_secret'];
		$this->name = $row['ap_name'];
		$this->email = $row['ap_email'];
		$this->phone = $row['ap_phone'];
		$this->description = $row['ap_description'];
		$this->status = $row['ap_status'];
		$this->datecreated = $row['ap_datecreated'];
		$this->datemodified = $row['ap_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'api_partner
				WHERE ap_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'api_partner ap';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'api_partner ap';

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
			$myApiPartner = new Core_Backend_ApiPartner();

			$myApiPartner->uid = $row['u_id'];
			$myApiPartner->id = $row['ap_id'];
			$myApiPartner->key = $row['ap_key'];
			$myApiPartner->secret = $row['ap_secret'];
			$myApiPartner->name = $row['ap_name'];
			$myApiPartner->email = $row['ap_email'];
			$myApiPartner->phone = $row['ap_phone'];
			$myApiPartner->description = $row['ap_description'];
			$myApiPartner->status = $row['ap_status'];
			$myApiPartner->datecreated = $row['ap_datecreated'];
			$myApiPartner->datemodified = $row['ap_datemodified'];


            $outputList[] = $myApiPartner;
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
	public static function getApiPartners($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_id = '.(int)$formData['fid'].' ';

		if($formData['fkey'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_key = "'.Helper::unspecialtext((string)$formData['fkey']).'" ';

		if($formData['fsecret'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_secret = "'.Helper::unspecialtext((string)$formData['fsecret']).'" ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'key')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_key LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'secret')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_secret LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'phone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ap.ap_phone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ap.ap_key LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ap.ap_secret LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ap.ap_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ap.ap_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ap.ap_phone LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ap_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'ap_name ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ap_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ap_datemodified ' . $sorttype;
		else
			$orderString = 'ap_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	public static function getStatusList()
	{
		$outputList = array();

		$outputList[self::STATUS_ENABLE] = 'Enable';
		$outputList[self::STATUS_DISABLE] = 'Disable';

		return $outputList;
	}

	public function getStatusName()
	{
		$statusName = '';

		switch ($this->status)
		{
			case self::STATUS_ENABLE:
				$statusName = 'Enable';
				break;

			case self::STATUS_DISABLE:
				$statusName = 'Disable';
				break;
		}

		return $statusName;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
			return true;
		else
			return false;
	}

    public function createSerectString()
    {
    	$secretString = 'dienmayapi' . rand(1 , 1000000) . md5(Helper::codau2khongdau($this->name) . '-' . $this->key) . time();
    	$this->secret = md5($secretString);
    }

	public static function getPartnerInfo($partnerinfo = array())
	{
		$db3 = self::getDb();

		$myApiPartner = new Core_Backend_ApiPartner();

		if(count($partnerinfo) > 0)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX .'api_partner WHERE ap_key = ? AND ap_secret = ? AND ap_status = ?';
			$row = $db3->query($sql , array(
												$partnerinfo['key'],
												$partnerinfo['secret'],
												self::STATUS_ENABLE
											))->fetch();

			$myApiPartner->uid = $row['u_id'];
			$myApiPartner->id = $row['ap_id'];
			$myApiPartner->key = $row['ap_key'];
			$myApiPartner->secret = $row['ap_secret'];
			$myApiPartner->name = $row['ap_name'];
			$myApiPartner->email = $row['ap_email'];
			$myApiPartner->phone = $row['ap_phone'];
			$myApiPartner->description = $row['ap_description'];
			$myApiPartner->status = $row['ap_status'];
			$myApiPartner->datecreated = $row['ap_datecreated'];
			$myApiPartner->datemodified = $row['ap_datemodified'];

		}

		return $myApiPartner;
	}

}