<?php

/**
 * core/class.productattribute.php
 *
 * File contains the class used for ProductAttribute Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductAttribute extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	const DATATYPE_NUMBER = 5;
	const DATATYPE_STRING =10;

	public $uid = 0;
	public $pgaid = 0;
	public $pcid = 0;
	public $id = 0;
	public $name = "";
	public $nameseo = "";
	public $link = "";
	public $weightrecommand = 1;
	public $description = "";
	public $datatype = 0;
	public $unit = "";
	public $status = 0;
	public $displayorder = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $value = '';
	public $values = array();
	public $actor = null;
	public $weight = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_attribute (
					u_id,
					pga_id,
					pc_id,
					pa_name,
					pa_link,
					pa_weightrecommand,
					pa_description,
					pa_datatype,
					pa_unit,
					pa_status,
					pa_displayorder,
					pa_datecreated,
					pa_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pgaid,
					(int)$this->pcid,
					(string)$this->name,
					(string)$this->link,
					(int)$this->weightrecommand,
					(string)$this->description,
					(int)$this->datatype,
					(string)$this->unit,
					(int)$this->status,
					(int)$this->displayorder,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_attribute
				SET u_id = ?,
					pga_id = ?,
					pc_id = ?,
					pa_name = ?,
					pa_link = ?,
					pa_weightrecommand = ?,
					pa_description = ?,
					pa_datatype = ?,
					pa_unit = ?,
					pa_status = ?,
					pa_displayorder = ?,
					pa_datecreated = ?,
					pa_datemodified = ?
				WHERE pa_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pgaid,
					(int)$this->pcid,
					(string)$this->name,
					(string)$this->link,
					(int)$this->weightrecommand,
					(string)$this->description,
					(int)$this->datatype,
					(string)$this->unit,
					(int)$this->status,
					(int)$this->displayorder,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_attribute pa
				WHERE pa.pa_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pgaid = $row['pga_id'];
		$this->pcid = $row['pc_id'];
		$this->id = $row['pa_id'];
		$this->name = $row['pa_name'];
		$this->link = $row['pa_link'];
		$this->weightrecommand = $row['pa_weightrecommand'];
		$this->description = $row['pa_description'];
		$this->datatype = $row['pa_datatype'];
		$this->unit = $row['pa_unit'];
		$this->status = $row['pa_status'];
		$this->displayorder = $row['pa_displayorder'];
		$this->datecreated = $row['pa_datecreated'];
		$this->datemodified = $row['pa_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_attribute
				WHERE pa_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_attribute pa';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_attribute pa';

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
			$myProductAttribute               = new Core_ProductAttribute();

			$myProductAttribute->uid          = $row['u_id'];
			$myProductAttribute->pgaid        = $row['pga_id'];
			$myProductAttribute->pcid         = $row['pc_id'];
			$myProductAttribute->id           = $row['pa_id'];
			$myProductAttribute->name         = $row['pa_name'];
			$myProductAttribute->nameseo      = Helper::codau2khongdau($row['pa_name'],true,true);
			$myProductAttribute->link         = $row['pa_link'];
			$myProductAttribute->weightrecommand = $row['pa_weightrecommand'];
			$myProductAttribute->description  = $row['pa_description'];
			$myProductAttribute->datatype     = $row['pa_datatype'];
			$myProductAttribute->unit 		   = $row['pa_unit'];
			$myProductAttribute->status       = $row['pa_status'];
			$myProductAttribute->displayorder = $row['pa_displayorder'];
			$myProductAttribute->datecreated  = $row['pa_datecreated'];
			$myProductAttribute->datemodified = $row['pa_datemodified'];


            $outputList[] = $myProductAttribute;
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
	public static function getProductAttributes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpgaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pga_id = '.(int)$formData['fpgaid'].' ';

		if($formData['fpcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pc_id = '.(int)$formData['fpcid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pa_id = '.(int)$formData['fid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pa_status = '.(int)$formData['fstatus'].' ';

		if(count($formData['fpcidarr']) > 0 && $formData['fpcid'] == 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(';
			for($i = 0; $i < count($formData['fpcidarr']) ; $i++)
			{
				if($i == count($formData['fpcidarr']) - 1)
				{
					$whereString .= 'pa.pc_id = ' . (int)$formData['fpcidarr'][$i];
				}
				else
				{
					$whereString .= 'pa.pc_id = ' . (int)$formData['fpcidarr'][$i] . ' OR ';
				}
			}
			$whereString .= ')';
		}

		if(is_array($formData['fpgaidarr']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pga_id IN ('.implode(',' , $formData['fpgaidarr']).') ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pc_id , pa_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'pc_id , pa_displayorder ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'pc_id, pa_name ' . $sorttype;
		else
			$orderString = 'pc_id , pa_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(pa_displayorder) FROM ' . TABLE_PREFIX . 'product_attribute';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public static function getDatatypeList()
	{
		$output = array();

		$output[self::DATATYPE_NUMBER] = 'Kiểu số';
		$output[self::DATATYPE_STRING] = 'Kiểu chuỗi';

		return $output;
	}

	public function getDatatypeName()
	{
		$name = '';

		switch($this->datatype)
		{
			case self::DATATYPE_NUMBER: $name = 'Kiểu số'; break;
			case self::DATATYPE_STRING: $name = 'Kiểu chữ'; break;
		}

		return $name;
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

	/**
	 * get product attribute info from Db
	 * @param  [type] $pid [description]
	 * @return [type]      [description]
	 */
	public static function getProductAttributeInfoFromDb($pid)
	{
		global $db;
		$outputList = array();
		$myProduct = new Core_Product($pid , true);
		if($myProduct->id > 0)
		{
			$sql = 'SELECT pa.pa_id , pa.pa_name , rpa.rpa_value
					FROM ' . TABLE_PREFIX . 'product_attribute pa
					INNER JOIN ' . TABLE_PREFIX . 'rel_product_attribute rpa ON pa.pa_id = rpa.pa_id
					WHERE rpa.p_id = ?';

			$stmt = $db->query($sql , array($myProduct->id));

			while ($row = $stmt->fetch(PDO::FETCH_NUM))
			{
				$outputList[] = $row;
			}
		}

		return $outputList;
	}


	public static function getProductAttributeInfo($pid)
	{
		$productattributeinfo = array();

		$myCacher = new Cacher('pa:' . $pid , Cacher::STORAGE_MEMCACHED , 86400 * 2); // 2 days
		$data = $myCacher->get();
		if($data != false)
		{
			$productattributeinfo = $data;
		}
		else
		{
			$productattributeinfo = self::getProductAttributeInfoFromDb($pid);
			$myCacher->set($productattributeinfo);
		}

		return $productattributeinfo;
	}

}
