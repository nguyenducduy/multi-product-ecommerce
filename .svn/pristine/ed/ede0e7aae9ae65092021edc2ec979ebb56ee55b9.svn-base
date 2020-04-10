<?php

/**
 * core/class.relproductproduct.php
 *
 * File contains the class used for RelProductProduct Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelProductProduct extends Core_Object
{
	const TYPE_ACCESSORIES = 1;//phụ kiện
    const TYPE_SAMPLE = 2;//sản phẩm tương đương
    const TYPE_COLOR = 5;//màu
    const TYPE_OLD = 10;//sản phẩm cũ
    const TYPE_PRODUCT2 = 20; //sản phẩm ưu tiên bán
    const TYPE_PRODUCT3 = 30; //san phẩm liên quan đặt hàng

	public $pidsource = 0;
	public $piddestination = 0;
	public $id = 0;
    public $type = 0;
    public $typevalue = "";
	public $displayorder = 0;
    public $datecreated = 0;

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

		$this->displayorder = $this->getMaxDisplayOrder() + 1;
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_product (
					p_idsource,
					p_iddestination,
                    pp_type,
                    pp_typevalue,
					pp_displayorder,
					pp_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pidsource,
					(int)$this->piddestination,
                    (int)$this->type,
                    (string)$this->typevalue,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_product
				SET p_idsource = ?,
					p_iddestination = ?,
                    pp_type = ?,
                    pp_typevalue = ?,
					pp_displayorder = ?,
					pp_datecreated = ?
				WHERE pp_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pidsource,
					(int)$this->piddestination,
                    (int)$this->type,
                    (int)$this->typevalue,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_product rpp
				WHERE rpp.pp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pidsource = $row['p_idsource'];
		$this->piddestination = $row['p_iddestination'];
		$this->id = $row['pp_id'];
        $this->type = $row['pp_type'];
        $this->typevalue = $row['p_typevalue'];
		$this->displayorder = $row['pp_displayorder'];
		$this->datecreated = $row['pp_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_product_product
				WHERE pp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_product_product rpp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_product rpp';

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
			$myRelProductProduct = new Core_RelProductProduct();

			$myRelProductProduct->pidsource = $row['p_idsource'];
			$myRelProductProduct->piddestination = $row['p_iddestination'];
			$myRelProductProduct->id = $row['pp_id'];
            $myRelProductProduct->type = $row['pp_type'];
            $myRelProductProduct->typevalue = $row['pp_typevalue'];
			$myRelProductProduct->displayorder = $row['pp_displayorder'];
			$myRelProductProduct->datecreated = $row['pp_datecreated'];


            $outputList[] = $myRelProductProduct;
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
	public static function getRelProductProducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpidsource'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpp.p_idsource = '.(int)$formData['fpidsource'].' ';

		if($formData['fpiddestination'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpp.p_iddestination = '.(int)$formData['fpiddestination'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpp.pp_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpp.pp_type = '.(int)$formData['ftype'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpp.pp_displayorder = '.(int)$formData['fdisplayorder'].' ';


        if(count($formData['fpidsourcearr']) > 0)
        {
            $numsource = count($formData['fpidsourcearr']);
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < $numsource ; $i++)
            {
                if($i == $numsource - 1)
                {
                    $whereString .= 'rpp.p_idsource = ' . (int)$formData['fpidsourcearr'][$i];
                }
                else
                {
                    $whereString .= 'rpp.p_idsource = ' . (int)$formData['fpidsourcearr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }
        if(count($formData['fpiddestinationarr']) > 0)
        {
            $numdesc = count($formData['fpiddestinationarr']);
            if (!empty($formData['fpidsourcearr'])) $whereString .= ($whereString != '' ? ' OR ' : '') . '(';
            else $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i <  $numdesc; $i++)
            {
                if($i == $numdesc - 1)
                {
                    $whereString .= 'rpp.p_iddestination = ' . (int)$formData['fpiddestinationarr'][$i];
                }
                else
                {
                    $whereString .= 'rpp.p_iddestination = ' . (int)$formData['fpiddestinationarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'piddestination')
			$orderString = 'p_iddestination ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'pp_id ' . $sorttype;
		else
			$orderString = 'pp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getType($typename)
	{
		$type = 0;
		switch($typename)
		{
			case 'accessories' : $type = Core_RelProductProduct::TYPE_ACCESSORIES;
				break;
			case 'sample' : $type = Core_RelProductProduct::TYPE_SAMPLE;
				break;
			case 'product2' : $type = Core_RelProductProduct::TYPE_PRODUCT2;
				break;
			case 'product3' : $type = Core_RelProductProduct::TYPE_PRODUCT3;
				break;
		}

		return $type;
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(pp_displayorder) FROM ' . TABLE_PREFIX . 'rel_product_product';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

}
