<?php

/**
 * core/class.productgroupattribute.php
 *
 * File contains the class used for ProductGroupAttribute Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductGroupAttribute extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $uid = 0;
	public $pcid = 0;
	public $id = 0;
	public $name = "";
	public $displayorder = "";
	public $status = "";
	public $datecreated = 0;
	public $datemodified = 0;
	public $attributes = null;

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
		if($this->displayorder == 0)
		{
			$this->displayorder = $this->getMaxDisplayOrder() + 1;
		}

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_group_attribute (
					u_id,
					pc_id,
					pga_name,
					pga_displayorder,
					pga_status,
					pga_datecreated,
					pga_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pcid,
					(string)$this->name,
					(string)$this->displayorder,
					(string)$this->status,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_group_attribute
				SET u_id = ?,
					pc_id = ?,
					pga_name = ?,
					pga_displayorder = ?,
					pga_status = ?,
					pga_datecreated = ?,
					pga_datemodified = ?
				WHERE pga_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pcid,
					(string)$this->name,
					(string)$this->displayorder,
					(string)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_group_attribute pga
				WHERE pga.pga_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pcid = $row['pc_id'];
		$this->id = $row['pga_id'];
		$this->name = $row['pga_name'];
		$this->displayorder = $row['pga_displayorder'];
		$this->status = $row['pga_status'];
		$this->datecreated = $row['pga_datecreated'];
		$this->datemodified = $row['pga_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_group_attribute
				WHERE pga_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_group_attribute pga';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_group_attribute pga';

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
			$myProductGroupAttribute = new Core_ProductGroupAttribute();

			$myProductGroupAttribute->uid = $row['u_id'];
			$myProductGroupAttribute->pcid = $row['pc_id'];
			$myProductGroupAttribute->id = $row['pga_id'];
			$myProductGroupAttribute->name = $row['pga_name'];
			$myProductGroupAttribute->displayorder = $row['pga_displayorder'];
			$myProductGroupAttribute->status = $row['pga_status'];
			$myProductGroupAttribute->datecreated = $row['pga_datecreated'];
			$myProductGroupAttribute->datemodified = $row['pga_datemodified'];


            $outputList[] = $myProductGroupAttribute;
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
	public static function getProductGroupAttributes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pga.pc_id = '.(int)$formData['fpcid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pga.pga_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pga.pga_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fdisplayorder'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pga.pga_displayorder = "'.Helper::unspecialtext((string)$formData['fdisplayorder']).'" ';

		if($formData['fstatus'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pga.pga_status = '.(int)$formData['fstatus'].' ';

		if(count($formData['fpcidarr']) > 0 && $formData['fpcid'] == 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(';
			for($i = 0; $i < count($formData['fpcidarr']) ; $i++)
			{
				if($i == count($formData['fpcidarr']) - 1)
				{
					$whereString .= 'pga.pc_id = ' . (int)$formData['fpcidarr'][$i];
				}
				else
				{
					$whereString .= 'pga.pc_id = ' . (int)$formData['fpcidarr'][$i] . ' OR ';
				}
			}
			$whereString .= ')';
		}



		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'ASC';


		if($sortby == 'id')
			$orderString = 'pc_id , pga_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'pc_id , pga_name ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'pga_displayorder ' . $sorttype;
		else
			$orderString = 'pga_displayorder ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(pga_displayorder) FROM ' . TABLE_PREFIX . 'product_group_attribute';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
			return true;
		else
			return false;
	}

}
