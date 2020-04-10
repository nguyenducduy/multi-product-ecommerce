<?php

/**
 * core/class.pagetheme.php
 *
 * File contains the class used for Pagetheme Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Pagetheme extends Core_Object
{

	public $id = 0;
	public $name = "";
	public $description = "";
	public $classidentifier = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'pagetheme (
					pt_name,
					pt_description,
					pt_classidentifier,
					pt_datecreated,
					pt_datemodified
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->description,
					(string)$this->classidentifier,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'pagetheme
				SET pt_name = ?,
					pt_description = ?,
					pt_classidentifier = ?,
					pt_datecreated = ?,
					pt_datemodified = ?
				WHERE pt_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->description,
					(string)$this->classidentifier,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'pagetheme p
				WHERE p.pt_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['pt_id'];
		$this->name = $row['pt_name'];
		$this->description = $row['pt_description'];
		$this->classidentifier = $row['pt_classidentifier'];
		$this->datecreated = $row['pt_datecreated'];
		$this->datemodified = $row['pt_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'pagetheme
				WHERE pt_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'pagetheme p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'pagetheme p';

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
			$myPagetheme = new Core_Pagetheme();

			$myPagetheme->id = $row['pt_id'];
			$myPagetheme->name = $row['pt_name'];
			$myPagetheme->description = $row['pt_description'];
			$myPagetheme->classidentifier = $row['pt_classidentifier'];
			$myPagetheme->datecreated = $row['pt_datecreated'];
			$myPagetheme->datemodified = $row['pt_datemodified'];


            $outputList[] = $myPagetheme;
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
	public static function getPagethemes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pt_id = '.(int)$formData['fid'].' ';

		if($formData['fclassidentifier'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pt_classidentifier = "'.Helper::unspecialtext((string)$formData['fclassidentifier']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pt_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'description')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pt_description LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.pt_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (p.pt_description LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pt_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'pt_name ' . $sorttype;
		else
			$orderString = 'pt_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}