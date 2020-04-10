<?php

/**
 * core/class.adsclick.php
 *
 * File contains the class used for AdsClick Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_AdsClick extends Core_Object
{
	const PLATFORM_DESKTOP = 1;
	const PLATFORM_TABLET = 3;
	const PLATFORM_MOBILE = 5;

	const FRAUDSTATUS_PENDING = 1;
	const FRAUDSTATUS_VALID = 3;
	const FRAUDSTATUS_INVALID = 5;

	public $uid = 0;
	public $aid = 0;
	public $id = 0;
	public $platform = 0;
	public $positionx = 0;
	public $positiony = 0;
	public $ipaddress = 0;
	public $referer = "";
	public $referercontrollergroup = "";
	public $referercontroller = "";
	public $referercontrolleraction = "";
	public $region = 0;
	public $useragent = '';
	public $fraudstatus = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ads_click (
					u_id,
					a_id,
					ac_platform,
					ac_positionx,
					ac_positiony,
					ac_ipaddress,
					ac_referer,
					ac_referercontrollergroup,
					ac_referercontroller,
					ac_referercontrolleraction,
					ac_region,
					ac_useragent,
					ac_fraudstatus,
					ac_datecreated,
					ac_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->aid,
					(int)$this->platform,
					(int)$this->positionx,
					(int)$this->positiony,
					(int)$this->ipaddress,
					(string)$this->referer,
					(string)$this->referercontrollergroup,
					(string)$this->referercontroller,
					(string)$this->referercontrolleraction,
					(int)$this->region,
					(string)$this->useragent,
					(int)$this->fraudstatus,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'ads_click
				SET u_id = ?,
					a_id = ?,
					ac_platform = ?,
					ac_positionx = ?,
					ac_positiony = ?,
					ac_ipaddress = ?,
					ac_referer = ?,
					ac_referercontrollergroup = ?,
					ac_referercontroller = ?,
					ac_referercontrolleraction = ?,
					ac_fraudstatus = ?,
					ac_datecreated = ?,
					ac_datemodified = ?
				WHERE ac_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->aid,
					(int)$this->platform,
					(int)$this->positionx,
					(int)$this->positiony,
					(int)$this->ipaddress,
					(string)$this->referer,
					(string)$this->referercontrollergroup,
					(string)$this->referercontroller,
					(string)$this->referercontrolleraction,
					(int)$this->fraudstatus,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_click ac
				WHERE ac.ac_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->aid = $row['a_id'];
		$this->id = $row['ac_id'];
		$this->platform = $row['ac_platform'];
		$this->positionx = $row['ac_positionx'];
		$this->positiony = $row['ac_positiony'];
		$this->ipaddress = $row['ac_ipaddress'];
		$this->referer = $row['ac_referer'];
		$this->referercontrollergroup = $row['ac_referercontrollergroup'];
		$this->referercontroller = $row['ac_referercontroller'];
		$this->referercontrolleraction = $row['ac_referercontrolleraction'];
		$this->region = $row['ac_region'];
		$this->useragent = $row['ac_useragent'];
		$this->fraudstatus = $row['ac_fraudstatus'];
		$this->datecreated = $row['ac_datecreated'];
		$this->datemodified = $row['ac_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ads_click
				WHERE ac_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ads_click ac';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_click ac';

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
			$myAdsClick = new Core_AdsClick();

			$myAdsClick->uid = $row['u_id'];
			$myAdsClick->aid = $row['a_id'];
			$myAdsClick->id = $row['ac_id'];
			$myAdsClick->platform = $row['ac_platform'];
			$myAdsClick->positionx = $row['ac_positionx'];
			$myAdsClick->positiony = $row['ac_positiony'];
			$myAdsClick->ipaddress = $row['ac_ipaddress'];
			$myAdsClick->referer = $row['ac_referer'];
			$myAdsClick->referercontrollergroup = $row['ac_referercontrollergroup'];
			$myAdsClick->referercontroller = $row['ac_referercontroller'];
			$myAdsClick->referercontrolleraction = $row['ac_referercontrolleraction'];
			$myAdsClick->region = $row['ac_region'];
			$myAdsClick->useragent = $row['ac_useragent'];
			$myAdsClick->fraudstatus = $row['ac_fraudstatus'];
			$myAdsClick->datecreated = $row['ac_datecreated'];
			$myAdsClick->datemodified = $row['ac_datemodified'];


            $outputList[] = $myAdsClick;
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
	public static function getAdsClicks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.u_id = '.(int)$formData['fuid'].' ';

		if($formData['faid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.a_id = '.(int)$formData['faid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_id = '.(int)$formData['fid'].' ';

		if($formData['fplatform'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_platform = '.(int)$formData['fplatform'].' ';

		if($formData['fpositionx'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_positionx = '.(int)$formData['fpositionx'].' ';

		if($formData['fpositiony'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_positiony = '.(int)$formData['fpositiony'].' ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_ipaddress = '.(int)$formData['fipaddress'].' ';

		if($formData['freferer'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referer = "'.Helper::unspecialtext((string)$formData['freferer']).'" ';

		if($formData['freferercontrollergroup'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referercontrollergroup = "'.Helper::unspecialtext((string)$formData['freferercontrollergroup']).'" ';

		if($formData['freferercontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referercontroller = "'.Helper::unspecialtext((string)$formData['freferercontroller']).'" ';

		if($formData['freferercontrolleraction'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referercontrolleraction = "'.Helper::unspecialtext((string)$formData['freferercontrolleraction']).'" ';

		if($formData['ffraudstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_fraudstatus = '.(int)$formData['ffraudstatus'].' ';

		if($formData['ftimestampstart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_datecreated >= '.(int)$formData['ftimestampstart'].' ';

		if($formData['ftimestampend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_datecreated <= '.(int)$formData['ftimestampend'].' ';




		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'referer')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referer LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'referercontrollergroup')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referercontrollergroup LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'referercontroller')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referercontroller LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'referercontrolleraction')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ac.ac_referercontrolleraction LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ac.ac_referer LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ac.ac_referercontrollergroup LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ac.ac_referercontroller LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ac.ac_referercontrolleraction LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ac_id ' . $sorttype;
		else
			$orderString = 'ac_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}