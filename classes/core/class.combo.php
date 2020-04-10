<?php

/**
 * core/class.combo.php
 *
 * File contains the class used for Combo Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Combo extends Core_Object
{

	public $id = "";
	public $name = "";
	public $description = "";
    public $isactive = 0;
	public $isdeleted = 0;

    public function __construct($id = 0)
	{
		parent::__construct();

		if(strlen($id) > 0)
			$this->getData($id);
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'combo (
					co_id,
                    co_name,
					co_description,
                    co_isactive,
					co_isdeleted
					)
		        VALUES(?, ?, ?, ?, ?)';
		$this->db->query($sql, array(
                    (string)$this->id,
					(string)$this->name,
					(string)$this->description,
                    (int)$this->isactive,
					(int)$this->isdeleted
					));

		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'combo
				SET co_name = ?,
					co_description = ?,
                    co_isactive = ? ,
					co_isdeleted = ?
				WHERE co_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->description,
					(int)$this->isactive,
                    (int)$this->isdeleted,
					(string)$this->id
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
		$id = (string)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'combo c
				WHERE c.co_id = ?';

		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['co_id'];
		$this->name = $row['co_name'];
		$this->description = $row['co_description'];
        $this->isactive = $row['co_isactive'];
		$this->isdeleted = $row['co_isdeleted'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'combo
				WHERE co_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'combo c';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'combo c';

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
			$myCombo = new Core_Combo();

			$myCombo->id = $row['co_id'];
			$myCombo->name = $row['co_name'];
			$myCombo->description = $row['co_description'];
			$myCombo->isactive = $row['co_isactive'];
			$myCombo->isdeleted = $row['co_isdeleted'];

            $outputList[] = $myCombo;
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
	public static function getCombos($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.co_id = "'.Helper::unspecialtext((string)$formData['fid']).'" ';

        if($formData['fidarr'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'c.co_id IN ("'.implode('","',$formData['fidarr']).'") ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.co_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if(isset($formData['fisdeleted']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'c.co_isdeleted = "'.((int)$formData['fisdeleted']).'" ';

        if(isset($formData['fisactive']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'c.co_isactive = "'.((int)$formData['fisactive']).'" ';


        if(count($formData['fidarr']) > 0 && $formData['fid'] == '')
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fidarr']) ; $i++)
            {
                if($i == count($formData['fidarr']) - 1)
                {
                    $whereString .= 'c.co_id = "' . (string)$formData['fidarr'][$i].'"';
                }
                else
                {
                    $whereString .= 'c.co_id = "' . (string)$formData['fidarr'][$i] . '" OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'co_id ' . $sorttype;
		else
			$orderString = 'co_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}