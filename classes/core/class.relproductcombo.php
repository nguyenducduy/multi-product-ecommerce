<?php

/**
 * core/class.relproductcombo.php
 *
 * File contains the class used for RelProductCombo Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelProductCombo extends Core_Object
{

	public $pbarcode = "";
	public $coid = "";
	public $id = 0;
	public $type = 0;
	public $value = 0;
	public $quantity = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_combo (
					p_barcode,
					co_id,
					rpc_type,
					rpc_value,
					rpc_quantity,
					rpc_displayorder
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(string)$this->coid,
					(int)$this->type,
					(float)$this->value,
					(int)$this->quantity,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_combo
				SET p_barcode = ?,
					co_id = ?,
					rpc_type = ?,
					rpc_value = ?,
					rpc_quantity = ?,
					rpc_displayorder = ?
				WHERE rpc_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(string)$this->coid,
					(int)$this->type,
					(float)$this->value,
					(int)$this->quantity,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_combo rpc
				WHERE rpc.rpc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->coid = $row['co_id'];
		$this->id = $row['rpc_id'];
		$this->type = $row['rpc_type'];
		$this->value = $row['rpc_value'];
		$this->quantity = $row['rpc_quantity'];
		$this->displayorder = $row['rpc_displayorder'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_product_combo
				WHERE rpc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_product_combo rpc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_combo rpc';

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
			$myRelProductCombo = new Core_RelProductCombo();

			$myRelProductCombo->pbarcode = $row['p_barcode'];
			$myRelProductCombo->coid = $row['co_id'];
			$myRelProductCombo->id = $row['rpc_id'];
			$myRelProductCombo->type = $row['rpc_type'];
			$myRelProductCombo->value = $row['rpc_value'];
			$myRelProductCombo->quantity = $row['rpc_quantity'];
			$myRelProductCombo->displayorder = $row['rpc_displayorder'];


            $outputList[] = $myRelProductCombo;
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
	public static function getRelProductCombos($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpc.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fcoid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpc.co_id = "'.Helper::unspecialtext((string)$formData['fcoid']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpc.rpc_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpc.rpc_type = '.(int)$formData['ftype'].' ';

		if($formData['fvalue'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpc.rpc_value = '.(float)$formData['fvalue'].' ';

		if($formData['fquantity'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpc.rpc_quantity = '.(int)$formData['fquantity'].' ';


	    if(count($formData['fcoidarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fcoidarr']) ; $i++)
            {
                if($i == count($formData['fcoidarr']) - 1)
                {
                    $whereString .= 'rpc.co_id = "' . (string)$formData['fcoidarr'][$i].'"';
                }
                else
                {
                    $whereString .= 'rpc.co_id = "' . (string)$formData['fcoidarr'][$i] . '" OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'rpc_id ' . $sorttype;
		else
			$orderString = 'rpc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}