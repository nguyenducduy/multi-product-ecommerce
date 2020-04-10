<?php

/**
 * core/class.homepage.php
 *
 * File contains the class used for Homepage Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Homepage extends Core_Object
{
	const TYPE_PRODUCT = 5;
	const TYPE_PROMOTION = 10;
	const TYPE_NEWS = 15;
	const TYPE_TOPSELL = 20;
	const TYPE_PRODUCTPROMOTION = 25;

	public $id = 0;
	public $category = 0;
	public $subcategory = "";
	public $inputtype = 0;
	public $type = 0;
	public $listid = '';
	public $topselllist = "";
	public $productpromotionlist = "";
	public $blockhomepage = "";
	public $blockbannerright = "";
	public $displayorder = 0;
	public $categoryactor = null;
	public $subcategoryactor = null;
	public $objectlist = array();

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'homepage (
					h_category,
					h_subcategory,
					h_inputtype,
					h_type,
					h_listid,
					h_topselllist,
					h_productpromotionlist,
					h_blockhomepage,
					h_blockbannerright,
					h_displayorder,
					)
		        VALUES(?, ?, ?, ? ,? ,?, ?, ?, ?, ?)';

		$rowCount = $this->db->query($sql, array(
					(int)$this->category,
					(string)$this->subcategory,
					(int)$this->inputtype,
					(int)$this->type,
					(string)$this->listid,
					(string)$this->topselllist,
					(string)$this->productpromotionlist,
					(string)$this->blockhomepage,
					(string)$this->blockbannerright,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'homepage
				SET h_category = ?,
					h_subcategory = ?,
					h_inputtype = ?,
					h_type = ?,
					h_listid = ?,
					h_topselllist = ?,
					h_productpromotionlist =?,
					h_blockhomepage = ?,
					h_blockbannerright = ?,
					h_displayorder = ?
				WHERE h_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->category,
					(string)$this->subcategory,
					(int)$this->inputtype,
					(int)$this->type,
					(string)$this->listid,
					(string)$this->topselllist,
					(string)$this->productpromotionlist,
					(string)$this->blockhomepage,
					(string)$this->blockbannerright,
					(int)$this->displayorder,
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
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'homepage h
				WHERE h.h_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id           = $row['h_id'];
		$this->category     = $row['h_category'];
		$this->subcategory  = $row['h_subcategory'];
		$this->inputtype    = $row['h_inputtype'];
		$this->type         = $row['h_type'];
		$this->listid       = $row['h_listid'];
		$this->topselllist  = $row['h_topselllist'];
		$this->productpromotionlist = $row['h_productpromotionlist'];
		$this->blockhomepage = $row['h_blockhomepage'];
		$this->blockbannerright = $row['h_blockbannerright'];
		$this->displayorder = $row['h_displayorder'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'homepage
				WHERE h_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'homepage h';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'homepage h';

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
			$myHomepage = new Core_Homepage();

			$myHomepage->id           = $row['h_id'];
			$myHomepage->category     = $row['h_category'];
			$myHomepage->subcategory  = $row['h_subcategory'];
			$myHomepage->inputtype    = $row['h_inputtype'];
			$myHomepage->type         = $row['h_type'];
			$myHomepage->listid       = $row['h_listid'];
			$myHomepage->topselllist  = $row['h_topselllist'];
			$myHomepage->productpromotionlist = $row['h_productpromotionlist'];
			$myHomepage->blockhomepage = $row['h_blockhomepage'];
			$myHomepage->blockbannerright = $row['h_blockbannerright'];
			$myHomepage->displayorder = $row['h_displayorder'];

            $outputList[] = $myHomepage;
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
	public static function getHomepages($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_id = '.(int)$formData['fid'].' ';

		if($formData['fcategory'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_category = '.(int)$formData['fcategory'].' ';

		if($formData['finputtype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_inputtype = '.(int)$formData['finputtype'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_type = '.(int)$formData['ftype'].' ';

		if($formData['flistid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_listid = '.(int)$formData['flistid'].' ';

		if(isset($formData['fhaslistid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_listid != "" ';

		if(count($formData['fcategoryarr']) > 0)
		{
			//$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_category IN ('.implode(',', $formData['fcategoryarr']).') ';
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'h.h_category IN (';
			$i = 0;
			foreach($formData['fcategoryarr'] as $category)
			{
				if($category > 0)
				{
					if($i == count($formData['fcategoryarr'])-1 )
					{
						$whereString .= $category;
					}
					else
					{
						$whereString .= $category .',';
					}
				}
				$i++;
			}
			$whereString .= ') ';
		}



		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'h_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'h_displayorder ' .$sorttype;
		else
			$orderString = 'h_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getTypeList()
	{
		$output = array();

		$output[self::TYPE_PRODUCT] = 'Sản phẩm';
		$output[self::TYPE_PROMOTION] = 'Sản phẩm khuyến mãi';
		$output[self::TYPE_NEWS] = 'Tin tức';

		return $output;
	}

	public function getTypeName()
	{
		$name = '';

		switch($this->type)
		{
			case self::TYPE_PRODUCT: $name = 'Sản phẩm'; break;
			case self::TYPE_PROMOTION: $name = 'Sản phẩm khuyến mãi'; break;
			case self::TYPE_NEWS: $name = 'Tin tức'; break;
		}

		return $name;
	}

	public function checkTypeName($name)
	{
		$name = strtolower($name);

		if($this->type == self::TYPE_PRODUCT && $name == 'product' || $this->type == self::TYPE_PROMOTION && $name == 'promotion' || $this->type == self::TYPE_NEWS && $name == 'news')
			return true;
		else
			return false;
	}

	public static function getTypeNames($type)
	{
		$name = '';

		switch($type)
		{
			case self::TYPE_PRODUCT: $name = 'Product'; break;
			case self::TYPE_PROMOTION: $name = 'Promotion'; break;
			case self::TYPE_NEWS: $name = 'News'; break;
		}

		return $name;
	}

	public function getInputTypeName()
	{
		$inputtype = '';

		switch($this->inputtype)
		{
			case 0: $inputtype = 'Nhập tay'; break;
			case 1: $inputtype = 'Auto'; break;
		}

		return $inputtype;
	}

	public static function getTopitemlist()
	{
		global $db;
		$topitemlist = array();
		$sql = 'SELECT h_topselllist FROM ' . TABLE_PREFIX . 'homepage WHERE h_type = ?';
		$row = $db->query($sql , array(self::TYPE_TOPSELL))->fetch();

		if(strlen($row['h_topselllist']) > 0)
		{
			$topselllistid = explode(',' , $row['h_topselllist']);
			foreach($topselllistid as $pid)
			{
				$myProduct = new Core_Product($pid, true);
				if($myProduct->id > 0)
				{
					$topitemlist[] = $myProduct;
				}
				unset($myProduct);
			}
		}

		return $topitemlist;
	}

	public static function getRootCategoryHomepage()
	{
		global $db;

		$homepagerootcategorylist = array();

		$myCacher = new Cacher('hlist' , Cacher::STORAGE_MEMCACHED, 86400 * 2);

		$data = $myCacher->get();

		if($data !== false)
		{
			$rootcategorylist = explode(',', $data);
		}
		else
		{
			$sql = 'SELECT h_category FROM ' . TABLE_PREFIX . 'homepage WHERE h_subcategory != "" ORDER BY h_displayorder';
			$stmt = $db->query($sql);

			while ( $row = $stmt->fetch() )
			{
				if((int)$row['h_category'] > 0)
				{
					$rootcategorylist[] = $row['h_category'];
				}
			}
		}

		if( count($rootcategorylist) > 0 )
		{
			foreach ( $rootcategorylist as $rootcategoryid )
			{
				$homepagerootcategorylist[$rootcategoryid] = array();
			}
		}

		return $homepagerootcategorylist;
	}


}
