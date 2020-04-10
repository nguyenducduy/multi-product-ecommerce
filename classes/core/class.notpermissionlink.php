<?php

/**
 * core/class.notpermissionlink.php
 *
 * File contains the class used for Notpermissionlink Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Notpermissionlink extends Core_Object
{

	public $uid = 0;
	public $id = 0;
	public $sessionid = "";
	public $referer = "";
	public $ipaddress = 0;
	public $useragent = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'notpermissionlink (
					u_id,
					n_sessionid,
					n_referer,
					n_ipaddress,
					n_useragent,
					n_datecreated,
					n_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->sessionid,
					(string)$this->referer,
					(int)$this->ipaddress,
					(string)$this->useragent,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'notpermissionlink
				SET u_id = ?,
					n_sessionid = ?,
					n_referer = ?,
					n_ipaddress = ?,
					n_useragent = ?,
					n_datecreated = ?,
					n_datemodified = ?
				WHERE n_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->sessionid,
					(string)$this->referer,
					(int)$this->ipaddress,
					(string)$this->useragent,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'notpermissionlink n
				WHERE n.n_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['n_id'];
		$this->sessionid = $row['n_sessionid'];
		$this->referer = $row['n_referer'];
		$this->ipaddress = long2ip($row['n_ipaddress']);
		$this->useragent = $row['n_useragent'];
		$this->datecreated = $row['n_datecreated'];
		$this->datemodified = $row['n_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'notpermissionlink
				WHERE n_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'notpermissionlink n';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'notpermissionlink n';

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
			$myNotpermissionlink = new Core_Notpermissionlink();

			$myNotpermissionlink->uid = $row['u_id'];
			$myNotpermissionlink->id = $row['n_id'];
			$myNotpermissionlink->sessionid = $row['n_sessionid'];
			$myNotpermissionlink->referer = $row['n_referer'];
			$myNotpermissionlink->ipaddress = long2ip($row['n_ipaddress']);
			$myNotpermissionlink->useragent = $row['n_useragent'];
			$myNotpermissionlink->datecreated = $row['n_datecreated'];
			$myNotpermissionlink->datemodified = $row['n_datemodified'];


            $outputList[] = $myNotpermissionlink;
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
	public static function getNotpermissionlinks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_id = '.(int)$formData['fid'].' ';

		if($formData['fsessionid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_sessionid = "'.Helper::unspecialtext((string)$formData['fsessionid']).'" ';

		if($formData['freferer'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_referer = "'.Helper::unspecialtext((string)$formData['freferer']).'" ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_ipaddress = '.(int)$formData['fipaddress'].' ';

		if($formData['fuseragent'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_useragent = "'.Helper::unspecialtext((string)$formData['fuseragent']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'sessionid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_sessionid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'referer')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_referer LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'useragent')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_useragent LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (n.n_sessionid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (n.n_referer LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (n.n_useragent LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'n_id ' . $sorttype;
		elseif($sortby == 'sessionid')
			$orderString = 'n_sessionid ' . $sorttype;
		elseif($sortby == 'referer')
			$orderString = 'n_referer ' . $sorttype;
		elseif($sortby == 'ipaddress')
			$orderString = 'n_ipaddress ' . $sorttype;
		elseif($sortby == 'useragent')
			$orderString = 'n_useragent ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'n_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'n_datemodified ' . $sorttype;
		else
			$orderString = 'n_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}