<?php

/**
 * core/class.relitemkeyword.php
 *
 * File contains the class used for RelItemKeyword Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelItemKeyword extends Core_Object
{
	const TYPE_PRODUCT = 1;
    const TYPE_NEWS = 3;
    const TYPE_STUFF = 5;
    const TYPE_PAGE = 7;
    const TYPE_EVENT = 9;

	public $kid = 0;
	public $id = 0;
	public $type = 0;
	public $objectid = 0;
	public $displayorder = 0;
	public $datecreated = 0;
	public $detail = '';

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_item_keyword (
					k_id,
					ik_type,
					ik_objectid,
					ik_displayorder,
					ik_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->kid,
					(int)$this->type,
					(int)$this->objectid,
					(int)$this->displayorder,
					(int)$this->datecreated
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_item_keyword
				SET k_id = ?,
					ik_type = ?,
					ik_objectid = ?,
					ik_displayorder = ?,
					ik_datecreated = ?
				WHERE ik_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->kid,
					(int)$this->type,
					(int)$this->objectid,
					(int)$this->displayorder,
					(int)$this->datecreated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_item_keyword rik
				WHERE rik.ik_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->kid = $row['k_id'];
		$this->id = $row['ik_id'];
		$this->type = $row['ik_type'];
		$this->objectid = $row['ik_objectid'];
		$this->displayorder = $row['ik_displayorder'];
		$this->datecreated = $row['ik_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_item_keyword
				WHERE ik_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_item_keyword rik';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_item_keyword rik';

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
			$myRelItemKeyword = new Core_RelItemKeyword();

			$myRelItemKeyword->kid = $row['k_id'];
			$myRelItemKeyword->id = $row['ik_id'];
			$myRelItemKeyword->type = $row['ik_type'];
			$myRelItemKeyword->objectid = $row['ik_objectid'];
			$myRelItemKeyword->displayorder = $row['ik_displayorder'];
			$myRelItemKeyword->datecreated = $row['ik_datecreated'];


            $outputList[] = $myRelItemKeyword;
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
	public static function getRelItemKeywords($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fkid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rik.k_id = '.(int)$formData['fkid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rik.ik_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rik.ik_type = '.(int)$formData['ftype'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rik.ik_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['ffilterkeywordin'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rik.k_id IN ('.(string)$formData['ffilterkeywordin'].') ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'kid')
			$orderString = 'k_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ik_id ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 'ik_type ' . $sorttype;
		elseif($sortby == 'objectid')
			$orderString = 'ik_objectid ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'ik_displayorder ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ik_datecreated ' . $sorttype;
		else
			$orderString = 'ik_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getObjectList($type, $keywordfilter, $limit = '')
	{
		global $db;

		$sql = '	SELECT rik.ik_objectid FROM ' . TABLE_PREFIX . 'rel_item_keyword rik
					WHERE rik.ik_type = ' . $type . ' AND rik.k_id IN ('.$keywordfilter.') LIMIT '.$limit.'';

		$stmt = $db->query($sql);

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myRelItemKeyword = new Core_RelItemKeyword();

			$myRelItemKeyword->objectid = $row['ik_objectid'];

            $outputList[] = $myRelItemKeyword;
        }

        return $outputList;
	}

    public static function getTypeList()
    {
        $output = array();

        $output[self::TYPE_PRODUCT] = 'Product';
        $output[self::TYPE_NEWS] = 'News';
        $output[self::TYPE_STUFF] = 'Stuff';
        $output[self::TYPE_PAGE] = 'Page';

        return $output;
    }

    public function getTypeName()
    {
        $name = '';

        switch($this->from)
        {
            case self::TYPE_PRODUCT: $name = 'Product'; break;
            case self::TYPE_NEWS: $name = 'News'; break;
            case self::TYPE_STUFF: $name = 'Stuff'; break;
            case self::TYPE_PAGE: $name = 'Page'; break;
        }

        return $name;
    }

    public function checkTypeName($name)
    {
        $name = strtolower($name);

        if(($this->from == self::TYPE_PRODUCT && $name == 'product' )
			|| ($this->from == self::TYPE_NEWS && $name == 'news')
			|| ($this->from == self::TYPE_STUFF && $name == 'stuff')
			|| ($this->from == self::TYPE_PAGE && $name == 'page')
			)
            return true;
        else
            return false;
    }
}