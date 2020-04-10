<?php

/**
 * core/class.forecastuservalue.php
 *
 * File contains the class used for ForecastUservalue Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ForecastUservalue extends Core_Backend_Object
{

	const SHEET_KEHOACHTUSKUMC = 10000;
	const SHEET_BAOCAOKEHOACHTUSKUMC = 10001;
	const SHEET_KEHOACHTUSKUMCCATEGORY = 10002;

	const SHEET_KEHOACHPRODUCTSIEUTHI = 20001;

	const SHEET_SANPHAMCONFIG = 30001;

	public $uid = 0;
	public $id = 0;
	public $identifier = "";
	public $sheet = 0;
	public $value = "";
	public $description = "";
	public $date = 0;
	public $level = 0;
	public $isofficial = 1;
	public $canedit = 0;
	public $candelete = 0;
	public $sessionid = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'forecast_uservalue (
					u_id,
					fu_identifier,
					fu_sheet,
					fu_value,
					fu_description,
					fu_date,
					fu_level,
					fu_isofficial,
					fu_canedit,
					fu_candelete,
					fu_sessionid,
					fu_ipaddress,
					fu_datecreated,
					fu_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->identifier,
					(int)$this->sheet,
					(string)$this->value,
					(string)$this->description,
					(int)$this->date,
					(int)$this->level,
					(int)$this->isofficial,
					(int)$this->canedit,
					(int)$this->candelete,
					Helper::getSessionId(),
					Helper::getIpAddress(true),
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'forecast_uservalue
				SET u_id = ?,
					fu_identifier = ?,
					fu_sheet = ?,
					fu_value = ?,
					fu_description = ?,
					fu_date = ?,
					fu_level = ?,
					fu_isofficial = ?,
					fu_canedit = ?,
					fu_candelete = ?,
					fu_sessionid = ?,
					fu_ipaddress = ?,
					fu_datecreated = ?,
					fu_datemodified = ?
				WHERE fu_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->identifier,
					(int)$this->sheet,
					(string)$this->value,
					(string)$this->description,
					(int)$this->date,
					(int)$this->level,
					(int)$this->isofficial,
					(int)$this->canedit,
					(int)$this->candelete,
					Helper::getSessionId(),
					Helper::getIpAddress(true),
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'forecast_uservalue fu
				WHERE fu.fu_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['fu_id'];
		$this->identifier = $row['fu_identifier'];
		$this->sheet = $row['fu_sheet'];
		$this->value = $row['fu_value'];
		$this->description = $row['fu_description'];
		$this->date = $row['fu_date'];
		$this->level = $row['fu_level'];
		$this->isofficial = $row['fu_isofficial'];
		$this->canedit = $row['fu_canedit'];
		$this->candelete = $row['fu_candelete'];
		$this->sessionid = $row['fu_sessionid'];
		$this->ipaddress = long2ip($row['fu_ipaddress']);
		$this->datecreated = $row['fu_datecreated'];
		$this->datemodified = $row['fu_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'forecast_uservalue
				WHERE fu_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'forecast_uservalue fu';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'forecast_uservalue fu';

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
			$myForecastUservalue = new Core_Backend_ForecastUservalue();

			$myForecastUservalue->uid = $row['u_id'];
			$myForecastUservalue->id = $row['fu_id'];
			$myForecastUservalue->identifier = $row['fu_identifier'];
			$myForecastUservalue->sheet = $row['fu_sheet'];
			$myForecastUservalue->value = $row['fu_value'];
			$myForecastUservalue->description = $row['fu_description'];
			$myForecastUservalue->date = $row['fu_date'];
			$myForecastUservalue->level = $row['fu_level'];
			$myForecastUservalue->isofficial = $row['fu_isofficial'];
			$myForecastUservalue->canedit = $row['fu_canedit'];
			$myForecastUservalue->candelete = $row['fu_candelete'];
			$myForecastUservalue->sessionid = $row['fu_sessionid'];
			$myForecastUservalue->ipaddress = long2ip($row['fu_ipaddress']);
			$myForecastUservalue->datecreated = $row['fu_datecreated'];
			$myForecastUservalue->datemodified = $row['fu_datemodified'];


            $outputList[] = $myForecastUservalue;
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
	public static function getForecastUservalues($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_id = '.(int)$formData['fid'].' ';

		if($formData['fidentifier'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_identifier = "'.Helper::unspecialtext((string)$formData['fidentifier']).'" ';

		if($formData['fsheet'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_sheet = '.(int)$formData['fsheet'].' ';

		if($formData['fvalue'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_value = "'.Helper::unspecialtext((string)$formData['fvalue']).'" ';

		if($formData['fdate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_date = "'.(int)$formData['fdate'].'" ';

		if($formData['flevel'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_level = '.(int)$formData['flevel'].' ';

		if($formData['fisofficial'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_isofficial = '.(int)$formData['fisofficial'].' ';

		if($formData['fcanedit'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_canedit = '.(int)$formData['fcanedit'].' ';

		if($formData['fcandelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_candelete = '.(int)$formData['fcandelete'].' ';

		if($formData['fsessionid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_sessionid = "'.Helper::unspecialtext((string)$formData['fsessionid']).'" ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fu.fu_ipaddress = '.(int)$formData['fipaddress'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'fu_id ' . $sorttype;
		elseif($sortby == 'date')
			$orderString = 'fu_date ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'fu_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'fu_datemodified ' . $sorttype;
		else
			$orderString = 'fu_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	/**
	 * Generate cache key for stat get data for Sale
	 *
	 * @param array $params: Same with $parameters of method getDataSale();
	 */
	public static function getIdentifier($name, $params)
	{
		$key = '';

		//get valid key index
		$keyPartList = array();


		//find param
		foreach($params as $k => $v)
		{
			if($v > 0)
			{
				$keyAbbr = '';
				switch($k)
				{
					case 'category': $keyAbbr = 'c'; break;
					case 'product': $keyAbbr = 'p'; break;
					case 'region': $keyAbbr = 'r'; break;
					case 'vendor': $keyAbbr = 'v'; break;
					case 'outputtype': $keyAbbr = 'ot'; break;
					case 'inputtype': $keyAbbr = 'it'; break;
					case 'outputstore': $keyAbbr = 'o'; break;
					case 'inputstore': $keyAbbr = 'i'; break;
					case 'barcode': $keyAbbr = 'b'; break;
					case 'storetype' : $keyAbbr = 'st';break;
					default: $keyAbbr = $k;
				}

				$keyPartList[$keyAbbr] = $keyAbbr . $v;
			}
		}

		//generate key
		if(count($keyPartList) > 0)
		{
			ksort($keyPartList);
			$key = implode(':', $keyPartList);
		}

		$key = $name . ':' . $key;
		return $key;
	}

	public static function getDataBySheet($identifier , $sheet ,  $date)
	{
		$db3 = self::getDb();

		$sql = 'SELECT *  FROM ' . TABLE_PREFIX . 'forecast_uservalue
				WHERE fu_identifier = ?
				AND fu_sheet = ?
				AND fu_date = ?';

		$row = $db3->query($sql , array($identifier , $sheet , $date))->fetch();

		$myForecastUservalue               = new Core_Backend_ForecastUservalue();
		$myForecastUservalue->uid          = $row['u_id'];
		$myForecastUservalue->id           = $row['fu_id'];
		$myForecastUservalue->identifier   = $row['fu_identifier'];
		$myForecastUservalue->sheet        = $row['fu_sheet'];
		$myForecastUservalue->value        = $row['fu_value'];
		$myForecastUservalue->description  = $row['fu_description'];
		$myForecastUservalue->date         = $row['fu_date'];
		$myForecastUservalue->level        = $row['fu_level'];
		$myForecastUservalue->isofficial   = $row['fu_isofficial'];
		$myForecastUservalue->canedit      = $row['fu_canedit'];
		$myForecastUservalue->candelete    = $row['fu_candelete'];
		$myForecastUservalue->sessionid    = $row['fu_sessionid'];
		$myForecastUservalue->ipaddress    = long2ip($row['fu_ipaddress']);
		$myForecastUservalue->datecreated  = $row['fu_datecreated'];
		$myForecastUservalue->datemodified = $row['fu_datemodified'];

		return $myForecastUservalue;
	}


}