<?php

/**
 * core/class.apidocrequest.php
 *
 * File contains the class used for ApidocRequest Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ApidocRequest extends Core_Backend_Object
{
	const METHOD_GET = 1;
	const METHOD_POST = 2;
	const METHOD_PUT = 3;
	const METHOD_DELETE = 4;
	const METHOD_HEAD = 5;

	const STATUS_IMPLEMENT = 1;
	const STATUS_PROTOTYPE = 3;
	const STATUS_DEPRECATED = 5;
	const STATUS_DISABLED = 7;

	public $agid = 0;
	public $id = 0;
	public $name = "";
	public $summary = "";
	public $implementnote = "";
	public $httpmethod = 0;
	public $url = "";
	public $status = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'apidoc_request (
					ag_id,
					ar_name,
					ar_summary,
					ar_implementnote,
					ar_httpmethod,
					ar_url,
					ar_status,
					ar_displayorder,
					ar_datecreated,
					ar_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->agid,
					(string)$this->name,
					(string)$this->summary,
					(string)$this->implementnote,
					(int)$this->httpmethod,
					(string)$this->url,
					(int)$this->status,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'apidoc_request
				SET ag_id = ?,
					ar_name = ?,
					ar_summary = ?,
					ar_implementnote = ?,
					ar_httpmethod = ?,
					ar_url = ?,
					ar_status = ?,
					ar_displayorder = ?,
					ar_datecreated = ?,
					ar_datemodified = ?
				WHERE ar_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->agid,
					(string)$this->name,
					(string)$this->summary,
					(string)$this->implementnote,
					(int)$this->httpmethod,
					(string)$this->url,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_request ar
				WHERE ar.ar_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->agid = $row['ag_id'];
		$this->id = $row['ar_id'];
		$this->name = $row['ar_name'];
		$this->summary = $row['ar_summary'];
		$this->implementnote = $row['ar_implementnote'];
		$this->httpmethod = $row['ar_httpmethod'];
		$this->url = $row['ar_url'];
		$this->status = $row['ar_status'];
		$this->displayorder = $row['ar_displayorder'];
		$this->datecreated = $row['ar_datecreated'];
		$this->datemodified = $row['ar_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'apidoc_request
				WHERE ar_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		//xoa cac parameter
		$paramList = Core_Backend_ApidocRequestParameter::getApidocRequestParameters(array('farid' => $this->id), '', '', '');
		for($i = 0; $i < count($paramList); $i++)
		{
			$paramList[$i]->delete();
		}

		//xoa cac response
		$responseList = Core_Backend_ApidocRequestResponse::getApidocRequestResponses(array('farid' => $this->id), '', '', '');
		for($i = 0; $i < count($responseList); $i++)
		{
			$responseList[$i]->delete();
		}

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'apidoc_request ar';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_request ar';

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
			$myApidocRequest = new Core_Backend_ApidocRequest();

			$myApidocRequest->agid = $row['ag_id'];
			$myApidocRequest->id = $row['ar_id'];
			$myApidocRequest->name = $row['ar_name'];
			$myApidocRequest->summary = $row['ar_summary'];
			$myApidocRequest->implementnote = $row['ar_implementnote'];
			$myApidocRequest->httpmethod = $row['ar_httpmethod'];
			$myApidocRequest->url = $row['ar_url'];
			$myApidocRequest->status = $row['ar_status'];
			$myApidocRequest->displayorder = $row['ar_displayorder'];
			$myApidocRequest->datecreated = $row['ar_datecreated'];
			$myApidocRequest->datemodified = $row['ar_datemodified'];


            $outputList[] = $myApidocRequest;
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
	public static function getApidocRequests($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fagid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ag_id = '.(int)$formData['fagid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fhttpmethod'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_httpmethod = '.(int)$formData['fhttpmethod'].' ';

		if($formData['furl'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_url = "'.Helper::unspecialtext((string)$formData['furl']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_status = '.(int)$formData['fstatus'].' ';

		if($formData['fenable'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_status != '.self::STATUS_DISABLED.' ';

		if(count($formData['fstatuslist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_status IN ('. implode(',', $formData['fstatuslist']).') ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_displayorder = '.(int)$formData['fdisplayorder'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'implementnote')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_implementnote LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'url')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ar.ar_url LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ar.ar_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ar.ar_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ar.ar_implementnote LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ar.ar_url LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ar_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'ar_displayorder ' . $sorttype;
		else
			$orderString = 'ar_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_IMPLEMENT] = 'Implemented';
		$output[self::STATUS_PROTOTYPE] = 'Just Prototyping';
		$output[self::STATUS_DEPRECATED] = 'Deprecated';
		$output[self::STATUS_DISABLED] = 'Disabled';


		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_IMPLEMENT: $name = 'Implemented'; break;
			case self::STATUS_PROTOTYPE: $name = 'Just Prototyping'; break;
			case self::STATUS_DEPRECATED: $name = 'Deprecated'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return (
			($name == 'implement' && $this->status == self::STATUS_IMPLEMENT) ||
			($name == 'prototype' && $this->status == self::STATUS_PROTOTYPE) ||
			($name == 'deprecated' && $this->status == self::STATUS_DEPRECATED) ||
			($name == 'disabled' && $this->status == self::STATUS_DISABLED)
			);
	}


	public static function getMethodList()
	{
		$output = array();

		$output[self::METHOD_GET] = 'GET';
		$output[self::METHOD_POST] = 'POST';
		$output[self::METHOD_PUT] = 'PUT';
		$output[self::METHOD_DELETE] = 'DELETE';
		$output[self::METHOD_HEAD] = 'HEAD';

		return $output;
	}

	public function getMethodName()
	{
		$name = '';

		switch($this->httpmethod)
		{
			case self::METHOD_GET: $name = 'GET'; break;
			case self::METHOD_POST: $name = 'POST'; break;
			case self::METHOD_PUT: $name = 'PUT'; break;
			case self::METHOD_DELETE: $name = 'DELETE'; break;
			case self::METHOD_HEAD: $name = 'HEAD'; break;
		}

		return $name;
	}

	public function getMaxOrder()
	{
		$sql = 'SELECT MAX(ar_displayorder)
				FROM ' . TABLE_PREFIX . 'apidoc_request
				WHERE ag_id = ?';
		return $this->db3->query($sql, array($this->agid))->fetchColumn(0)+1;
	}

	public function getUrlWithQuery()
	{
		$url = $this->url;

		if(count($this->paramList) > 0)
		{
			$getParamList = array();
			//find GET parameter
			foreach($this->paramList as $param)
			{
				if($param->checkTypeName('get'))
				{
					$getParamList[] = $param;
				}
			}

			if(count($getParamList) > 0)
			{
				//remove current ? from default URL because this URL need to append defined GET parameters
				$questionPos = strrpos($url, '?');
				if($questionPos !== false)
				{
					$url = substr($url, 0, $questionPos);
				}

				//append new ?
				$url .= '?';

				for($i = 0; $i < count($getParamList); $i++)
				{
					if($i > 0)
						$url .= '&';

					$url .= $getParamList[$i]->name . '=<b><em>{'.$getParamList[$i]->name.'}</em></b>';
				}
			}

		}


		return $url;
	}

}