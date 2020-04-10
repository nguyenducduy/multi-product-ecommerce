<?php

/**
 * core/class.productstat.php
 *
 * File contains the class used for ProductStat Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductStat extends Core_Object
{

	public $pid = 0;
	public $pbarcode = "";
	public $id = 0;
	public $instockrevision = 0;
	public $pricerevision = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stat (
					p_id,
					p_barcode,
					pst_instockrevision,
					pst_pricerevision
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->instockrevision,
					(int)$this->pricerevision
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stat
				SET p_id = ?,
					p_barcode = ?,
					pst_instockrevision = ?,
					pst_pricerevision = ?
				WHERE pst_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->instockrevision,
					(int)$this->pricerevision,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_stat ps
				WHERE ps.pst_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['pst_id'];
		$this->instockrevision = $row['pst_instockrevision'];
		$this->pricerevision = $row['pst_pricerevision'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_stat
				WHERE pst_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_stat ps';

		if($where != '')
			$sql .= ' WHERE ' . $where . ' AND s_id != 734';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_stat ps';

		if($where != '')
			$sql .= ' WHERE ' . $where . ' AND s_id != 734';

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myProductStat = new Core_ProductStat();

			$myProductStat->pid = $row['p_id'];
			$myProductStat->pbarcode = $row['p_barcode'];
			$myProductStat->id = $row['pst_id'];
			$myProductStat->instockrevision = $row['pst_instockrevision'];
			$myProductStat->pricerevision = $row['pst_pricerevision'];


            $outputList[] = $myProductStat;
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
	public static function getProductStats($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.pst_id = '.(int)$formData['fid'].' ';

		if($formData['finstockrevision'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.pst_instockrevision = '.(int)$formData['finstockrevision'].' ';

		if($formData['fpricerevision'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.pst_pricerevision = '.(int)$formData['fpricerevision'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'pbarcode')
			$orderString = 'p_barcode ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'pst_id ' . $sorttype;
		elseif($sortby == 'instockrevision')
			$orderString = 'pst_instockrevision ' . $sorttype;
		elseif($sortby == 'pricerevision')
			$orderString = 'pst_pricerevision ' . $sorttype;
		else
			$orderString = 'pst_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	* get max revision list by column name
	* @param string $column : column name need get max revision
	*/
	public static function getMaxRevisionList($column, $maxrevision)
	{
		global $db;

		$sql = 'SELECT p_barcode FROM ' . TABLE_PREFIX . 'product_stat
				WHERE ' . $column .' >= ' . $maxrevision;
		$stmt = $db->query($sql);

		$output = array();
		while($row = $stmt->fetch())
		{
			if((string)$row[p_barcode] != '')
			{
				$output[] = (string)$row['p_barcode'];
			}
		}

		return $output;
	}

	public static function getMaxRevision($column)
	{
		global $db;
		$revision = 0;
		$sql = 'SELECT MAX('.$column.') AS revision FROM ' . TABLE_PREFIX . 'product_stat';

		$row = $db->query($sql)->fetch();

		$revision = (int)$row['revision'];

		return $revision;
	}

	public function getProductStatByBarcode($barcode)
	{
		if(strlen($barcode) > 0)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_stat
					WHERE p_barcode = ?';
			$row = $this->db->query($sql, array($barcode))->fetch();

			$this->pid = $row['p_id'];
			$this->pbarcode = $row['p_barcode'];
			$this->id = $row['pst_id'];
			$this->instockrevision = $row['pst_instockrevision'];
			$this->pricerevision = $row['pst_pricerevision'];
		}
	}

}
