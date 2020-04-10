<?php

/**
 * core/class.productyearuser.php
 *
 * File contains the class used for ProductyearUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ProductyearUser Class
 */
Class Core_ProductyearUser extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;
	
	const PROGRAM = 5;

	public $gfeid = 0;
	public $id = 0;
	public $oauthid = 0;
	public $username = '';
	public $fullname = '';
	public $email = '';
	public $phone = 0;
	public $point = 0;
	public $shareid = '';
	public $countlike = 0;
	public $countshare = 0;
	public $oauthpartner = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $ipaddress = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productyear_user (
					gfe_id,
					pyu_oauthid,
					pyu_username,
					pyu_fullname,
					pyu_email,
					pyu_phone,
					pyu_point,
					pyu_shareid,
					pyu_countlike,
					pyu_countshare,
					pyu_oauthpartner,
					pyu_status,
					pyu_datecreated,
					pyu_ipaddress
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->gfeid,
					(string)$this->oauthid,
					(string)$this->username,
					(string)$this->fullname,
					(string)$this->email,
					(int)$this->phone,
					(int)$this->point,
					(string)$this->shareid,
					(int)$this->countlike,
					(int)$this->countshare,
					(int)$this->oauthpartner,
					(int)$this->status,
					(int)$this->datecreated,
					(int)Helper::getIpAddress(true)
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'productyear_user
				SET gfe_id = ?,
					pyu_oauthid = ?,
					pyu_username = ?,
					pyu_fullname = ?,
					pyu_email = ?,
					pyu_phone = ?,
					pyu_point = ?,
					pyu_shareid = ?,
					pyu_countlike = ?,
					pyu_countshare = ?,
					pyu_oauthpartner = ?,
					pyu_status = ?,
					pyu_datemodified = ?
				WHERE pyu_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->gfeid,
					(string)$this->oauthid,
					(string)$this->username,
					(string)$this->fullname,
					(string)$this->email,
					(int)$this->phone,
					(int)$this->point,
					(string)$this->shareid,
					(int)$this->countlike,
					(int)$this->countshare,
					(int)$this->oauthpartner,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productyear_user pu
				WHERE pu.pyu_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->gfeid = (int)$row['gfe_id'];
		$this->id = (int)$row['pyu_id'];
		$this->oauthid = (string)$row['pyu_oauthid'];
		$this->username = (string)$row['pyu_username'];
		$this->fullname = (string)$row['pyu_fullname'];
		$this->email = (string)$row['pyu_email'];
		$this->phone = (int)$row['pyu_phone'];
		$this->point = (int)$row['pyu_point'];
		$this->shareid = (string)$row['pyu_shareid'];
		$this->countlike = (int)$row['pyu_countlike'];
		$this->countshare = (int)$row['pyu_countshare'];
		$this->oauthpartner = (int)$row['pyu_oauthpartner'];
		$this->status = (int)$row['pyu_status'];
		$this->datecreated = (int)$row['pyu_datecreated'];
		$this->datemodified = (int)$row['pyu_datemodified'];
		$this->ipaddress = (string)long2ip($row['pyu_ipaddress']);
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'productyear_user
				WHERE pyu_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productyear_user pu';

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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productyear_user pu';

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
			$myProductyearUser = new Core_ProductyearUser();

			$myProductyearUser->gfeid = (int)$row['gfe_id'];
			$myProductyearUser->id = (int)$row['pyu_id'];
			$myProductyearUser->oauthid = (string)$row['pyu_oauthid'];
			$myProductyearUser->username = (string)$row['pyu_username'];
			$myProductyearUser->fullname = (string)$row['pyu_fullname'];
			$myProductyearUser->email = (string)$row['pyu_email'];
			$myProductyearUser->phone = (int)$row['pyu_phone'];
			$myProductyearUser->point = (int)$row['pyu_point'];
			$myProductyearUser->shareid = (string)$row['pyu_shareid'];
			$myProductyearUser->countlike = (int)$row['pyu_countlike'];
			$myProductyearUser->countshare = (int)$row['pyu_countshare'];
			$myProductyearUser->oauthpartner = (int)$row['pyu_oauthpartner'];
			$myProductyearUser->status = (int)$row['pyu_status'];
			$myProductyearUser->datecreated = (int)$row['pyu_datecreated'];
			$myProductyearUser->datemodified = (int)$row['pyu_datemodified'];
			$myProductyearUser->ipaddress = (string)long2ip($row['pyu_ipaddress']);
			

            $outputList[] = $myProductyearUser;
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
	public static function getProductyearUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_id = '.(int)$formData['fid'].' ';

		if($formData['fusername'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_username = "'.Helper::unspecialtext((string)$formData['fusername']).'" ';

		if($formData['ffullname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_fullname = "'.Helper::unspecialtext((string)$formData['ffullname']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';
		
		if($formData['fphone'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_phone = "'.(int)$formData['fphone'].'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_status = '.(int)$formData['fstatus'].' ';

		if($formData['fipaddress'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_ipaddress = '.(int)ip2long($formData['fipaddress']).' ';


		
		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'username')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_username LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'pu.pyu_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (pu.pyu_username LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (pu.pyu_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (pu.pyu_email LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'pyu_id ' . $sorttype; 
		else
			$orderString = 'pyu_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	

		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disable';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disable'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'enable')
			 || ($this->status == self::STATUS_DISABLED && $name == 'disable'))
			return true;
		else
			return false;
	}



}