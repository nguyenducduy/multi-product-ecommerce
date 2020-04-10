<?php

/**
 * core/backend/class.search.php
 *
 * File contains the class used for Search Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_Search extends Core_Backend_Object
{

	public $uid = 0;
	public $id = 0;
	public $text = "";
	public $categoryid = 0;
	public $sessionid = '';
	public $trackingid = '';
	public $referrer = "";
	public $numresult = 0;
	public $ipaddress = '';
	public $datecreated = 0;

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

		if($this->trackingid == '')
			$this->trackingid = $this->sessionid;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'search (
					u_id,
					ks_text,
					ks_categoryid,
					ks_sessionid,
					ks_trackingid,
					ks_referrer,
					ks_numresult,
					ks_ipaddress,
					ks_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->text,
					(int)$this->categoryid,
					(string)$this->sessionid,
					(string)$this->trackingid,
					(string)$this->referrer,
					(int)$this->numresult,
					(int)$this->ipaddress,
					(int)$this->datecreated
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'search
				SET u_id = ?,
					ks_text = ?,
					ks_categoryid = ?,
					ks_sessionid = ?,
					ks_trackingid = ?,
					ks_referrer = ?,
					ks_numresult = ?
				WHERE ks_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->text,
					(int)$this->categoryid,
					(string)$this->sessionid,
					(string)$this->trackingid,
					(string)$this->referrer,
					(int)$this->numresult,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'search s
				WHERE s.ks_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['ks_id'];
		$this->text = $row['ks_text'];
		$this->categoryid = $row['ks_categoryid'];
		$this->sessionid = $row['ks_sessionid'];
		$this->trackingid = $row['ks_trackingid'];
		$this->referrer = $row['ks_referrer'];
		$this->numresult = $row['ks_numresult'];
		$this->ipaddress = long2ip($row['ks_ipaddress']);
		$this->datecreated = $row['ks_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'search
				WHERE ks_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'search s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'search s';

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
			$mySearch = new Core_Backend_Search();

			$mySearch->uid = $row['u_id'];
			$mySearch->id = $row['ks_id'];
			$mySearch->text = $row['ks_text'];
			$mySearch->categoryid = $row['ks_categoryid'];
			$mySearch->sessionid = $row['ks_sessionid'];
			$mySearch->trackingid = $row['ks_trackingid'];
			$mySearch->referrer = $row['ks_referrer'];
			$mySearch->numresult = $row['ks_numresult'];
			$mySearch->ipaddress = long2ip($row['ks_ipaddress']);
			$mySearch->datecreated = $row['ks_datecreated'];


            $outputList[] = $mySearch;
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
	public static function getSearchs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_id = '.(int)$formData['fid'].' ';

		if($formData['ftext'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_text = "'.Helper::unspecialtext((string)$formData['ftext']).'" ';

		if($formData['fcategoryid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_categoryid = '.(int)$formData['fcategoryid'].' ';

		if($formData['freferrer'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_referrer = "'.Helper::unspecialtext((string)$formData['freferrer']).'" ';

		if($formData['fsessionid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_sessionid = "'.Helper::unspecialtext((string)$formData['fsessionid']).'" ';

		if($formData['ftrackingid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_trackingid = "'.Helper::unspecialtext((string)$formData['ftrackingid']).'" ';

		if($formData['fnumresult'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_numresult = '.(int)$formData['fnumresult'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_datecreated = '.(int)$formData['fdatecreated'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'text')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_text LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'referrer')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ks_referrer LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (s.ks_text LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.ks_referrer LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ks_id ' . $sorttype;
		elseif($sortby == 'text')
			$orderString = 'ks_text ' . $sorttype;
		elseif($sortby == 'categoryid')
			$orderString = 'ks_categoryid ' . $sorttype;
		elseif($sortby == 'referrer')
			$orderString = 'ks_referrer ' . $sorttype;
		elseif($sortby == 'numresult')
			$orderString = 'ks_numresult ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ks_datecreated ' . $sorttype;
		else
			$orderString = 'ks_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}