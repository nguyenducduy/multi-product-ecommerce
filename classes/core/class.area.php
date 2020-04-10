<?php

/**
 * core/class.area.php
 *
 * File contains the class used for Area Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Area extends Core_Object
{

	public $id = 0;
	public $name = "";
	public $displayorder = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'area (
					a_name,
					a_displayorder
					)
		        VALUES(?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->displayorder
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'area
				SET a_name = ?,
					a_displayorder = ?
				WHERE a_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->displayorder,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'area a
				WHERE a.a_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['a_id'];
		$this->name = $row['a_name'];
		$this->displayorder = $row['a_displayorder'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'area
				WHERE a_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'area a';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'area a';

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
			$myArea = new Core_Area();

			$myArea->id = $row['a_id'];
			$myArea->name = $row['a_name'];
			$myArea->displayorder = $row['a_displayorder'];


            $outputList[] = $myArea;
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
	public static function getAreas($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if(count($formData['faidarr']) > 0 && $formData['faid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['faidarr']) ; $i++)
            {
                if($i == count($formData['faidarr']) - 1)
                {
                    $whereString .= 'a.a_id = ' . (int)$formData['faidarr'][$i];
                }
                else
                {
                    $whereString .= 'a.a_id = ' . (int)$formData['faidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (a.a_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'a_id ' . $sorttype;
		else
			$orderString = 'a_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}