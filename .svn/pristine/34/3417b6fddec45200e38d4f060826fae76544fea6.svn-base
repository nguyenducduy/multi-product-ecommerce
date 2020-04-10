<?php

/**
 * core/class.sitemap.php
 *
 * File contains the class used for Sitemap Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Sitemap extends Core_Backend_Object
{

	public $id = 0;
	public $name = "";
	public $changefreq = 0;
	public $priority = "";
	public $lastchanged = 0;
	public $datecreated = 0;
	public $datemodified = 0;

	const ALWAYS = 1;
	const HOURLY = 2;
	const DAILY = 3;
	const WEEKLY = 4;
	const MONTHLY = 5;
	const YEARLY = 6;
	const NERVER = 7;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'sitemap (
					sm_name,
					sm_changefreq,
					sm_priority,
					sm_lastchanged,
					sm_datecreated,
					sm_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->name,
					(int)$this->changefreq,
					(string)$this->priority,
					(int)$this->lastchanged,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'sitemap
				SET sm_name = ?,
					sm_changefreq = ?,
					sm_priority = ?,
					sm_lastchanged = ?,
					sm_datecreated = ?,
					sm_datemodified = ?
				WHERE sm_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->name,
					(int)$this->changefreq,
					(string)$this->priority,
					(int)$this->lastchanged,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'sitemap sm
				WHERE sm.sm_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->id = $row['sm_id'];
		$this->name = $row['sm_name'];
		$this->changefreq = $row['sm_changefreq'];
		$this->priority = $row['sm_priority'];
		$this->lastchanged = $row['sm_lastchanged'];
		$this->datecreated = $row['sm_datecreated'];
		$this->datemodified = $row['sm_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'sitemap
				WHERE sm_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'sitemap sm';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'sitemap sm';

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
			$mySitemap = new Core_Backend_Sitemap();

			$mySitemap->id = $row['sm_id'];
			$mySitemap->name = $row['sm_name'];
			$mySitemap->changefreq = $row['sm_changefreq'];
			$mySitemap->priority = $row['sm_priority'];
			$mySitemap->lastchanged = $row['sm_lastchanged'];
			$mySitemap->datecreated = $row['sm_datecreated'];
			$mySitemap->datemodified = $row['sm_datemodified'];


            $outputList[] = $mySitemap;
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
	public static function getSitemaps($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_id = '.(int)$formData['fid'].' ';
		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_name LIKE "'.Helper::unspecialtext((string)$formData['fname']).'"';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sm_id ' . $sorttype;
		else
			$orderString = 'sm_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getChangefregList()
    {
        $output = array();

        $output[self::ALWAYS] = 'always';
        $output[self::HOURLY] = 'hourly';
        $output[self::DAILY] = 'daily';
        $output[self::WEEKLY] = 'weekly';
        $output[self::MONTHLY] = 'monthly';
        $output[self::YEARLY] = 'yearly';
        $output[self::NERVER] = 'nerver';

        return $output;
    }

 	public function getChangefregName()
    {
        $name = '';

        switch($this->changefreq)
        {
            case self::ALWAYS: $name = 'always'; break;
            case self::HOURLY: $name = 'hourly'; break;
            case self::DAILY: $name = 'daily'; break;
            case self::WEEKLY: $name = 'weekly'; break;
            case self::MONTHLY: $name = 'monthly'; break;
            case self::YEARLY: $name = 'yearly'; break;
            case self::NERVER: $name = 'nerver'; break;
        }

        return $name;
    }


}