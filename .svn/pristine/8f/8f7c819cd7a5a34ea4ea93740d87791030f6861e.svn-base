<?php

/**
 * core/class.emailblacklit.php
 *
 * File contains the class used for EmailBlacklit Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_EmailBlacklit extends Core_Object
{
	const TYPE_BOUNCE = 1;
	const TYPE_COMPLAINT = 3;
	const TYPE_UNSUBCRIBE = 5;
	const TYPE_OTHER = 30;

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $id = 0;
	public $email = "";
	public $type = 0;
	public $source = "";
	public $metadata = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'email_blacklit (
					e_email,
					e_type,
					e_source,
					e_metadata,
					e_status,
					e_datecreated,
					e_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->email,
					(int)$this->type,
					(string)$this->source,
					(string)$this->metadata,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'email_blacklit
				SET e_email = ?,
					e_type = ?,
					e_source = ?,
					e_metadata = ?,
					e_status = ?,
					e_datecreated = ?,
					e_datemodified = ?
				WHERE e_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->email,
					(int)$this->type,
					(string)$this->source,
					(string)$this->metadata,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'email_blacklit eb
				WHERE eb.e_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['e_id'];
		$this->email = $row['e_email'];
		$this->type = $row['e_type'];
		$this->source = $row['e_source'];
		$this->metadata = $row['e_metadata'];
		$this->status = $row['e_status'];
		$this->datecreated = $row['e_datecreated'];
		$this->datemodified = $row['e_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'email_blacklit
				WHERE e_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'email_blacklit eb';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'email_blacklit eb';

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
			$myEmailBlacklit = new Core_EmailBlacklit();

			$myEmailBlacklit->id = $row['e_id'];
			$myEmailBlacklit->email = $row['e_email'];
			$myEmailBlacklit->type = $row['e_type'];
			$myEmailBlacklit->source = $row['e_source'];
			$myEmailBlacklit->metadata = $row['e_metadata'];
			$myEmailBlacklit->status = $row['e_status'];
			$myEmailBlacklit->datecreated = $row['e_datecreated'];
			$myEmailBlacklit->datemodified = $row['e_datemodified'];


            $outputList[] = $myEmailBlacklit;
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
	public static function getEmailBlacklits($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_id = '.(int)$formData['fid'].' ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_type = '.(int)$formData['ftype'].' ';

		if($formData['fsource'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_source = "'.Helper::unspecialtext((string)$formData['fsource']).'" ';

		if($formData['fmetadata'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_metadata = "'.Helper::unspecialtext((string)$formData['fmetadata']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'metadata')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'eb.e_metadata LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (eb.e_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (eb.e_metadata LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'e_id ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'e_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'e_datemodified ' . $sorttype;
		else
			$orderString = 'e_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


   	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
			return true;
		else
			return false;
	}

	public static function checkEmailNotExist($email = '')
	{
		global $db;

		$pass = true;
		if(Helper::ValidatedEmail($email))
		{
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'email_blacklit WHERE e_email = ?';

			$rowCount = $db->query($sql , array($email) )->fetchColumn(0);

			if($rowCount > 0)
			{
				$pass = false;
			}
		}
		else
		{
			$pass = false;
		}

		return $pass;
	}
}