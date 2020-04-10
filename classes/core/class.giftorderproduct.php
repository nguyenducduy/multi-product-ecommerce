<?php

/**
 * core/class.giftorderproduct.php
 *
 * File contains the class used for Giftorderproduct Model
 * 
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com) 
 */

/**
 * Core_Giftorderproduct Class
 */
Class Core_Giftorderproduct extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $goid = 0;
	public $id = 0;
	public $productid = 0;
	public $quantity = 0;
	public $instock = 0;
	public $status = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'giftorderproduct (
					go_id,
					gop_productid,
					gop_quantity,
					gop_instock,
					gop_status,
					gop_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->goid,
					(int)$this->productid,
					(int)$this->quantity,
					(int)$this->instock,
					(int)$this->status,
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'giftorderproduct
				SET go_id = ?,
					gop_productid = ?,
					gop_quantity = ?,
					gop_instock = ?,
					gop_status = ?,
					gop_datemodified = ?
				WHERE gop_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->goid,
					(int)$this->productid,
					(int)$this->quantity,
					(int)$this->instock,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giftorderproduct gop
				WHERE gop.gop_id = ?';
		$row = $this->db->query($sql, array($id))->fetch(); 

		$this->goid = (int)$row['go_id'];
		$this->id = (int)$row['gop_id'];
		$this->productid = (int)$row['gop_productid'];
		$this->quantity = (int)$row['gop_quantity'];
		$this->instock = (int)$row['gop_instock'];
		$this->status = (int)$row['gop_status'];
		$this->datecreated = (int)$row['gop_datecreated'];
		$this->datemodified = (int)$row['gop_datemodified'];
		 
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'giftorderproduct
				WHERE gop_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'giftorderproduct gop';
        
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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giftorderproduct gop';

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
			$myGiftorderproduct = new Core_Giftorderproduct();
			
			$myGiftorderproduct->goid = (int)$row['go_id'];
			$myGiftorderproduct->id = (int)$row['gop_id'];
			$myGiftorderproduct->productid = (int)$row['gop_productid'];
			$myGiftorderproduct->quantity = (int)$row['gop_quantity'];
			$myGiftorderproduct->instock = (int)$row['gop_instock'];
			$myGiftorderproduct->status = (int)$row['gop_status'];
			$myGiftorderproduct->datecreated = (int)$row['gop_datecreated'];
			$myGiftorderproduct->datemodified = (int)$row['gop_datemodified'];
			
			
            $outputList[] = $myGiftorderproduct;			
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
	public static function getGiftorderproducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';
		
		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_id = '.(int)$formData['fid'].' ';

		if($formData['fgoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.go_id = '.(int)$formData['fgoid'].' ';

		if($formData['fproductid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_productid = '.(int)$formData['fproductid'].' ';

		if($formData['fquantity'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_quantity = '.(int)$formData['fquantity'].' ';

		if($formData['finstock'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_instock = '.(int)$formData['finstock'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_datemodified = '.(int)$formData['fdatemodified'].' ';

		if ($formData['fhavestock'] == 1) {
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_instock > 0';
		}
		if ($formData['fstatus'] > 0) {
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gop.gop_status = '.(int)$formData['fstatus'].' ';
		}
		
		
		
		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';
			
		
		if($sortby == 'goid')
			$orderString = 'go_id ' . $sorttype; 
		elseif($sortby == 'id')
			$orderString = 'gop_id ' . $sorttype; 
		elseif($sortby == 'productid')
			$orderString = 'gop_productid ' . $sorttype; 
		elseif($sortby == 'quantity')
			$orderString = 'gop_quantity ' . $sorttype; 
		elseif($sortby == 'instock')
			$orderString = 'gop_instock ' . $sorttype; 
		elseif($sortby == 'status')
			$orderString = 'gop_status ' . $sorttype; 
		elseif($sortby == 'rand')
			$orderString = 'rand()'; 
		else
			$orderString = 'gop_id ' . $sorttype;
			
		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	
	
		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Hiển thi';
		$output[self::STATUS_DISABLE] = 'Không hiển thị';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Hiển thi'; break;
			case self::STATUS_DISABLE: $name = 'Không hiển thị'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'hiển thi')
			 || ($this->status == self::STATUS_DISABLE && $name == 'không hiển thị'))
			return true;
		else
			return false;
	}
	public function getPriceByGOID()
	{
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giftorder go where go.go_id = '.$this->goid.' LIMIT 0,1';
        $row = $this->db->query($sql)->fetch();
        $pricestring = number_format($row['go_pricefrom']).' - '.number_format($row['go_priceto']);
        return $pricestring;
	}
    public function getProductName()
    {
        $product = new Core_Product($this->productid);
        $productname  = "";
        if($product->id > 0)
        {
            $productname = $product->name;
        }
        return $productname;
    }
   
}