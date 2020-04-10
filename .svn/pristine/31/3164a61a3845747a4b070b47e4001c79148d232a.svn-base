<?php

/**
 * core/class.apipartnersalerequest.php
 *
 * File contains the class used for ApiPartnerSaleRequest Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ApiPartnerSaleRequest extends Core_Backend_Object
{

	public $apid = 0;
	public $id = 0;
	public $parameter = "";
	public $executetime = 0;
	public $record = 0;
	public $ipaddress = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $apipartneractor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'api_partner_sale_request (
					ap_id,
					apsr_parameter,
					apsr_executetime,
					apsr_record,
					apsr_ipaddress,
					apsr_datecreated,
					apsr_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->apid,
					(string)$this->parameter,
					(float)$this->executetime,
					(int)$this->record,
					(int)$this->ipaddress,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'api_partner_sale_request
				SET ap_id = ?,
					apsr_parameter = ?,
					apsr_executetime = ?,
					apsr_record = ?,
					apsr_ipaddress = ?,
					apsr_datecreated = ?,
					apsr_datemodified = ?
				WHERE apsr_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->apid,
					(string)$this->parameter,
					(float)$this->executetime,
					(int)$this->record,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'api_partner_sale_request apsr
				WHERE apsr.apsr_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->apid = $row['ap_id'];
		$this->id = $row['apsr_id'];
		$this->parameter = $row['apsr_parameter'];
		$this->executetime = $row['apsr_executetime'];
		$this->record = $row['apsr_record'];
		$this->ipaddress = long2ip($row['apsr_ipaddress']);
		$this->datecreated = $row['apsr_datecreated'];
		$this->datemodified = $row['apsr_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'api_partner_sale_request
				WHERE apsr_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'api_partner_sale_request apsr';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'api_partner_sale_request apsr';

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
			$myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest();

			$myApiPartnerSaleRequest->apid = $row['ap_id'];
			$myApiPartnerSaleRequest->id = $row['apsr_id'];
			$myApiPartnerSaleRequest->parameter = $row['apsr_parameter'];
			$myApiPartnerSaleRequest->executetime = $row['apsr_executetime'];
			$myApiPartnerSaleRequest->record = $row['apsr_record'];
			$myApiPartnerSaleRequest->ipaddress = long2ip($row['apsr_ipaddress']);
			$myApiPartnerSaleRequest->datecreated = $row['apsr_datecreated'];
			$myApiPartnerSaleRequest->datemodified = $row['apsr_datemodified'];


            $outputList[] = $myApiPartnerSaleRequest;
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
	public static function getApiPartnerSaleRequests($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fapid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'apsr.ap_id = '.(int)$formData['fapid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'apsr.apsr_id = '.(int)$formData['fid'].' ';

		if($formData['fparameter'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'apsr.apsr_parameter = "'.Helper::unspecialtext((string)$formData['fparameter']).'" ';

		if($formData['frecord'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'apsr.apsr_record = '.(int)$formData['frecord'].' ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'apsr.apsr_ipaddress = '.(int)$formData['fipaddress'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'parameter')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'apsr.apsr_parameter LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (apsr.apsr_parameter LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'apid')
			$orderString = 'ap_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'apsr_id ' . $sorttype;
		elseif($sortby == 'executetime')
			$orderString = 'apsr_executetime ' . $sorttype;
		elseif($sortby == 'record')
			$orderString = 'apsr_record ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'apsr_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'apsr_datemodified ' . $sorttype;
		else
			$orderString = 'apsr_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}