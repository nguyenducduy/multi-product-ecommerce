<?php

/**
 * core/class.apidocrequestresponse.php
 *
 * File contains the class used for ApidocRequestResponse Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 */
Class Core_Backend_ApidocRequestResponse extends Core_Backend_Object
{
	const CONTENTTYPE_JSON = 1;
	const CONTENTTYPE_XML = 3;
	const CONTENTTYPE_HTML = 5;
	const CONTENTTYPE_TEXT = 7;
	const CONTENTTYPE_BINARY = 9;

	public $arid = 0;
	public $id = 0;
	public $contenttype = 0;
	public $output = "";
	public $sample = "";
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'apidoc_request_response (
					ar_id,
					arr_contenttype,
					arr_output,
					arr_sample,
					arr_displayorder,
					arr_datecreated,
					arr_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->arid,
					(int)$this->contenttype,
					(string)$this->output,
					(string)$this->sample,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'apidoc_request_response
				SET ar_id = ?,
					arr_contenttype = ?,
					arr_output = ?,
					arr_sample = ?,
					arr_displayorder = ?,
					arr_datecreated = ?,
					arr_datemodified = ?
				WHERE arr_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->arid,
					(int)$this->contenttype,
					(string)$this->output,
					(string)$this->sample,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_request_response arr
				WHERE arr.arr_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->arid = $row['ar_id'];
		$this->id = $row['arr_id'];
		$this->contenttype = $row['arr_contenttype'];
		$this->output = $row['arr_output'];
		$this->sample = $row['arr_sample'];
		$this->displayorder = $row['arr_displayorder'];
		$this->datecreated = $row['arr_datecreated'];
		$this->datemodified = $row['arr_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'apidoc_request_response
				WHERE arr_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'apidoc_request_response arr';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_request_response arr';

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
			$myApidocRequestResponse = new Core_Backend_ApidocRequestResponse();

			$myApidocRequestResponse->arid = $row['ar_id'];
			$myApidocRequestResponse->id = $row['arr_id'];
			$myApidocRequestResponse->contenttype = $row['arr_contenttype'];
			$myApidocRequestResponse->output = $row['arr_output'];
			$myApidocRequestResponse->sample = $row['arr_sample'];
			$myApidocRequestResponse->displayorder = $row['arr_displayorder'];
			$myApidocRequestResponse->datecreated = $row['arr_datecreated'];
			$myApidocRequestResponse->datemodified = $row['arr_datemodified'];


            $outputList[] = $myApidocRequestResponse;
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
	public static function getApidocRequestResponses($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['farid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arr.ar_id = '.(int)$formData['farid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arr.arr_id = '.(int)$formData['fid'].' ';

		if($formData['fcontenttype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arr.arr_contenttype = '.(int)$formData['fcontenttype'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'arr.arr_displayorder = '.(int)$formData['fdisplayorder'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'output')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'arr.arr_output LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'sample')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'arr.arr_sample LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (arr.arr_output LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (arr.arr_sample LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'arr_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'arr_displayorder ' . $sorttype;
		else
			$orderString = 'arr_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getContenttypeList()
	{
		$output = array();

		$output[self::CONTENTTYPE_JSON] = 'JSON';
		$output[self::CONTENTTYPE_XML] = 'XML';
		$output[self::CONTENTTYPE_HTML] = 'HTML';
		$output[self::CONTENTTYPE_TEXT] = 'TEXT';
		$output[self::CONTENTTYPE_BINARY] = 'BINARY';

		return $output;
	}

	public function getContenttypeName()
	{
		$name = '';

		switch($this->contenttype)
		{
			case self::CONTENTTYPE_JSON: $name = 'JSON'; break;
			case self::CONTENTTYPE_XML: $name = 'XML'; break;
			case self::CONTENTTYPE_HTML: $name = 'HTML'; break;
			case self::CONTENTTYPE_TEXT: $name = 'TEXT'; break;
			case self::CONTENTTYPE_BINARY: $name = 'BINARY'; break;
		}

		return $name;
	}

	public function getMaxOrder()
	{
		$sql = 'SELECT MAX(arr_displayorder)
				FROM ' . TABLE_PREFIX . 'apidoc_request_response
				WHERE ar_id = ?';
		return $this->db3->query($sql, array($this->arid))->fetchColumn(0)+1;
	}
}