<?php

/**
 * core/class.adsslug.php
 *
 * File contains the class used for AdsSlug Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_AdsSlug extends Core_Object
{

	public $aid = 0;
	public $id = 0;
	public $slug = "";

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ads_slug (
					a_id,
					as_slug
					)
		        VALUES(?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->aid,
					(string)$this->slug
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'ads_slug
				SET a_id = ?,
					as_slug = ?
				WHERE as_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->aid,
					(string)$this->slug,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_slug asl
				WHERE as.as_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->aid = $row['a_id'];
		$this->id = $row['as_id'];
		$this->slug = $row['as_slug'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ads_slug
				WHERE as_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ads_slug asl';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_slug asl';

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
			$myAdsSlug = new Core_AdsSlug();

			$myAdsSlug->aid = $row['a_id'];
			$myAdsSlug->id = $row['as_id'];
			$myAdsSlug->slug = $row['as_slug'];


            $outputList[] = $myAdsSlug;
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
	public static function getAdsSlugs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['faid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'asl.a_id = '.(int)$formData['faid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'asl.as_id = '.(int)$formData['fid'].' ';

		if($formData['faslug'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'asl.as_slug LIKE \'%'.Helper::unspecialtext((string)$formData['faslug']).'%\' ';
        if($formData['fslug'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'asl.as_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'slug')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'asl.as_slug LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (asl.as_slug LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'aid')
			$orderString = 'a_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'as_id ' . $sorttype;
		elseif($sortby == 'slug')
			$orderString = 'as_slug ' . $sorttype;
		else
			$orderString = 'as_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public function deleteByAId()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'ads_slug
				WHERE a_id = ?';
        $rowCount = $this->db->query($sql, array($this->aid))->rowCount();
        return $rowCount;
    }


}