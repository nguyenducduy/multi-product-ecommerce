<?php

/**
 * core/class.externalresource.php
 *
 * File contains the class used for Externalresource Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Externalresource extends Core_Object
{
	public $rawcontent;
	public $id = 0;
	public $url = "";
	public $resourceserver = 0;
	public $objecttype = 0;
	public $objectid = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0, $rawcontent = '')
	{
		parent::__construct();

		if($id > 0)
		{
			$this->getData($id);
		}

		$this->rawcontent = $rawcontent;
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'externalresource (
					e_url,
					e_resourceserver,
					e_objecttype,
					e_objectid,
					e_status,
					e_datecreated,
					e_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->url,
					(int)$this->resourceserver,
					(int)$this->objecttype,
					(int)$this->objectid,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'externalresource
				SET e_url = ?,
					e_resourceserver = ?,
					e_objecttype = ?,
					e_objectid = ?,
					e_status = ?,
					e_datecreated = ?,
					e_datemodified = ?
				WHERE e_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->url,
					(int)$this->resourceserver,
					(int)$this->objecttype,
					(int)$this->objectid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'externalresource e
				WHERE e.e_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['e_id'];
		$this->url = $row['e_url'];
		$this->resourceserver = $row['e_resourceserver'];
		$this->objecttype = $row['e_objecttype'];
		$this->objectid = $row['e_objectid'];
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
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'externalresource
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'externalresource e';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'externalresource e';

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
			$myExternalresource = new Core_Externalresource();

			$myExternalresource->id = $row['e_id'];
			$myExternalresource->url = $row['e_url'];
			$myExternalresource->resourceserver = $row['e_resourceserver'];
			$myExternalresource->objecttype = $row['e_objecttype'];
			$myExternalresource->objectid = $row['e_objectid'];
			$myExternalresource->status = $row['e_status'];
			$myExternalresource->datecreated = $row['e_datecreated'];
			$myExternalresource->datemodified = $row['e_datemodified'];


            $outputList[] = $myExternalresource;
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
	public static function getExternalresources($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_id = '.(int)$formData['fid'].' ';

		if($formData['fresourceserver'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if($formData['fobjecttype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_objecttype = '.(int)$formData['fobjecttype'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'e_id ' . $sorttype;
		else
			$orderString = 'e_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}



	/**
	 * Tien hanh phan tich noi dung
	 */
	public function run($domainAppend, $saveToDirectory, $internalDomains = array(), &$externalSuccessDownloadList = array(), &$externalErrorDownloadList = array())
	{

		////////////////////////////////////////////
		//get Image resource in html content
		$resourceList = $this->getResourceList($this->rawcontent);
		$internalUrls = array();
		$externalUrls = array();

		//////////////////////////////////////////
		//get all External Url
		if(count($resourceList) > 0)
		{
			foreach($resourceList as $url)
			{
				$urlinfo = parse_url($url);

				//detect whether internal link or not
				if($this->isInternalDomain($internalDomains, $urlinfo['host']))
					$internalUrls[] = $url;
				else
					$externalUrls[] = $url;
			}
		}
		//end get external url

		////////////////////////////
		//Download external Url file
		$externalSuccessDownloadList = array();
		$externalErrorDownloadList = array();

		if(count($externalUrls) > 0)
		{
			foreach($externalUrls as $url)
			{
				//Get file name
				$filename = substr($url, strrpos($url, '/') + 1);
				$curDateDir = Helper::getCurrentDateDirName();

				$extPart = substr(strrchr($filename,'.'),1);
			    $namePart =  substr($filename, 0, strrpos($filename, '.'));

				$destination = $saveToDirectory . $curDateDir . $namePart . '.' . $extPart;

				//check existed directory
			    if(!file_exists($saveToDirectory . $curDateDir))
			    {
					mkdir($saveToDirectory . $curDateDir, 0777, true);
			    }

				//Prevent duplicate file
				$i = 1;
				while(file_exists($destination))
				{
					$destination = $saveToDirectory . $curDateDir . $namePart . '-'.$i++.'.' . $extPart;
				}

				//Start Download External Resource
				if(file_exists($saveToDirectory . $curDateDir) && Helper::saveExternalFile($url, $destination))
				{
					$externalSuccessDownloadList[] = array($url, $destination);
				}
				else
				{
					$externalErrorDownloadList[] = array($url, $destination);
				}
			}
		}
		// End download external Url
		/////////////////////////

		//////////////////////////
		// Update success external Url to content
		if(count($externalSuccessDownloadList) > 0)
		{
			foreach($externalSuccessDownloadList as $info)
			{
				$url = $info[0];
				$replaceurl = $domainAppend . $info[1];

				$this->rawcontent = str_replace($url, $replaceurl, $this->rawcontent);
			}
		}
		// End update content
		////////////////////////

		return $this->rawcontent;
	}

	private function isInternalDomain($internalDomains = array(), $host)
	{
		if(count($internalDomains) == 0)
			$internalDomains = array('dienmay.com', 'tgdt.vn');

		$isInternal = false;

		//Rule here, the internalDomains appear in the source host
		foreach($internalDomains as $internalDomain)
		{
			if(strpos($host, $internalDomain) !== false)
				$isInternal = true;
		}

		return $isInternal;
	}

	/**
	 * Return all resource/url related to this html content
	 */
	private function getResourceList($html)
	{
		$resourceList = array();

		preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $html, $matches);

		if(count($matches) > 0)
		{
			$resourceList = $matches[1];
		}


		return $resourceList;
	}


}