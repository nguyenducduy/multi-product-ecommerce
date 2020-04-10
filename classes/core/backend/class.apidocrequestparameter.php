<?php

/**
 * core/class.apidocrequestparameter.php
 *
 * File contains the class used for ApidocRequestParameter Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ApidocRequestParameter extends Core_Backend_Object
{
	const TYPE_GET = 1;
	const TYPE_POST = 2;

	const DATATYPE_STRING = 1;
	const DATATYPE_INTEGER = 3;
	const DATATYPE_FLOAT = 5;
	const DATATYPE_FILEUPLOAD = 7;

	public $arid = 0;
	public $id = 0;
	public $type = 0;
	public $name = "";
	public $summary = "";
	public $datatype = "";
	public $isrequired = 0;
	public $displayorder = 0;
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
		$this->displayorder = $this->getMaxOrder();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'apidoc_request_parameter (
					ar_id,
					arp_type,
					arp_name,
					arp_summary,
					arp_datatype,
					arp_isrequired,
					arp_displayorder,
					arp_datecreated,
					arp_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->arid,
					(int)$this->type,
					(string)$this->name,
					(string)$this->summary,
					(int)$this->datatype,
					(int)$this->isrequired,
					(int)$this->displayorder,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'apidoc_request_parameter
				SET ar_id = ?,
					arp_type = ?,
					arp_name = ?,
					arp_summary = ?,
					arp_datatype = ?,
					arp_isrequired = ?,
					arp_displayorder = ?,
					arp_datecreated = ?,
					arp_datemodified = ?
				WHERE arp_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->arid,
					(int)$this->type,
					(string)$this->name,
					(string)$this->summary,
					(int)$this->datatype,
					(int)$this->isrequired,
					(int)$this->displayorder,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_request_parameter arp
				WHERE arp.arp_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->arid = $row['ar_id'];
		$this->id = $row['arp_id'];
		$this->type = $row['arp_type'];
		$this->name = $row['arp_name'];
		$this->summary = $row['arp_summary'];
		$this->datatype = $row['arp_datatype'];
		$this->isrequired = $row['arp_isrequired'];
		$this->displayorder = $row['arp_displayorder'];
		$this->datecreated = $row['arp_datecreated'];
		$this->datemodified = $row['arp_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'apidoc_request_parameter
				WHERE arp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'apidoc_request_parameter arp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_request_parameter arp';

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
			$myApidocRequestParameter = new Core_Backend_ApidocRequestParameter();

			$myApidocRequestParameter->arid = $row['ar_id'];
			$myApidocRequestParameter->id = $row['arp_id'];
			$myApidocRequestParameter->type = $row['arp_type'];
			$myApidocRequestParameter->name = $row['arp_name'];
			$myApidocRequestParameter->summary = $row['arp_summary'];
			$myApidocRequestParameter->datatype = $row['arp_datatype'];
			$myApidocRequestParameter->isrequired = $row['arp_isrequired'];
			$myApidocRequestParameter->displayorder = $row['arp_displayorder'];
			$myApidocRequestParameter->datecreated = $row['arp_datecreated'];
			$myApidocRequestParameter->datemodified = $row['arp_datemodified'];


            $outputList[] = $myApidocRequestParameter;
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
	public static function getApidocRequestParameters($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['farid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arp.ar_id = '.(int)$formData['farid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arp.arp_id = '.(int)$formData['fid'].' ';

		if($formData['fisrequired'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arp.arp_isrequired = '.(int)$formData['fisrequired'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arp.arp_displayorder = '.(int)$formData['fdisplayorder'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'arp.arp_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'arp.arp_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (arp.arp_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (arp.arp_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (arp.arp_datatype LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'arp_id ' . $sorttype;
		elseif($sortby == 'isrequired')
			$orderString = 'arp_isrequired ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'arp_displayorder ' . $sorttype;
		else
			$orderString = 'arp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getDatatypeList()
	{
		$output = array();

		$output[self::DATATYPE_STRING] = 'String';
		$output[self::DATATYPE_INTEGER] = 'Integer';
		$output[self::DATATYPE_FLOAT] = 'Float';
		$output[self::DATATYPE_FILEUPLOAD] = 'File Upload';

		return $output;
	}

	public function getDatatypeName()
	{
		$name = '';

		switch($this->datatype)
		{
			case self::DATATYPE_STRING: $name = 'String'; break;
			case self::DATATYPE_INTEGER: $name = 'Integer'; break;
			case self::DATATYPE_FLOAT: $name = 'Float'; break;
			case self::DATATYPE_FILEUPLOAD: $name = 'File Upload'; break;
		}

		return $name;
	}

	public static function getTypeList()
	{
		$output = array();

		$output[self::TYPE_GET] = 'GET';
		$output[self::TYPE_POST] = 'POST';

		return $output;
	}

	public function getTypeName()
	{
		$name = '';

		switch($this->type)
		{
			case self::TYPE_GET: $name = 'GET'; break;
			case self::TYPE_POST: $name = 'POST'; break;
		}

		return $name;
	}

	public function checkTypeName($name)
	{
		$name = strtolower($name);

		return (
			($name == 'get' && $this->type == self::TYPE_GET) ||
			($name == 'post' && $this->type == self::TYPE_POST)
			);
	}

	public function getMaxOrder()
	{
		$sql = 'SELECT MAX(arp_displayorder)
				FROM ' . TABLE_PREFIX . 'apidoc_request_parameter
				WHERE ar_id = ?';
		return $this->db3->query($sql, array($this->arid))->fetchColumn(0)+1;
	}



}