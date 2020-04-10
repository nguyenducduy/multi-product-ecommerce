<?php

/**
 * core/class.reverseauctions.php
 *
 * File contains the class used for ReverseAuctions Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ReverseAuctions extends Core_Object
{
	const STATUS_BUYING = 3;
	const STATUS_ENABLE = 2;
	const STATUS_DISABLED = 1;
	const SHOWBLOCK = 1;
	const NOSHOWBLOCK = 0;
	public $id = 0;
	public $productname = "";
	public $image = "";
	public $video = "";
	public $image360 = "";
	public $price = 0;
	public $content = "";
	public $technical = "";
	public $journalistically = "";
	public $startdate = 0;
	public $enddate = 0;
	public $status = 0;
	public $position = 0;
	public $isshowblock = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'reverse_auctions (
					ra_productname,
					ra_image,
					ra_video,
					ra_image360,
					ra_price,
					ra_content,
					ra_technical,
					ra_journalistically,
					ra_startdate,
					ra_enddate,
					ra_status,
					ra_isshowblock,
					ra_datecreated,
					ra_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->productname,
					(string)$this->image,
					(string)$this->video,
					(string)$this->image360,
					(float)$this->price,
					(string)$this->content,
					(string)$this->technical,
					(string)$this->journalistically,
					(int)$this->startdate,
					(int)$this->enddate,
					(int)$this->status,
					(int)$this->isshowblock,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		if($this->id > 0)
		{
			$this->updateCacher();
		}
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'reverse_auctions
				SET ra_productname = ?,
					ra_image = ?,
					ra_video = ?,
					ra_image360 = ?,
					ra_price = ?,
					ra_content = ?,
					ra_technical = ?,
					ra_journalistically = ?,
					ra_startdate = ?,
					ra_enddate = ?,
					ra_status = ?,
					ra_isshowblock = ?,
					ra_datecreated = ?,
					ra_datemodified = ?
				WHERE ra_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->productname,
					(string)$this->image,
					(string)$this->video,
					(string)$this->image360,
					(float)$this->price,
					(string)$this->content,
					(string)$this->technical,
					(string)$this->journalistically,
					(int)$this->startdate,
					(int)$this->enddate,
					(int)$this->status,
					(int)$this->isshowblock,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
		{
			$this->updateCacher();
			return true;
		}
		else
			return false;
	}
    public function updateStatus()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'reverse_auctions
				SET ra_status = ?
				WHERE ra_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->status,
					(int)$this->id
					));
		if($stmt)
		{
			return true;
		}
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'reverse_auctions ra
				WHERE ra.ra_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['ra_id'];
		$this->productname = $row['ra_productname'];
		$this->image = $row['ra_image'];
		$this->video = $row['ra_video'];
		$this->image360 = $row['ra_image360'];
		$this->price = $row['ra_price'];
		$this->content = $row['ra_content'];
		$this->technical = $row['ra_technical'];
		$this->journalistically = $row['ra_journalistically'];
		$this->startdate = $row['ra_startdate'];
		$this->enddate = $row['ra_enddate'];
		$this->status = $row['ra_status'];
		$this->isshowblock = $row['ra_isshowblock'];
		$this->datecreated = $row['ra_datecreated'];
		$this->datemodified = $row['ra_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'reverse_auctions
				WHERE ra_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'reverse_auctions ra';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'reverse_auctions ra';

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
			$myReverseAuctions = new Core_ReverseAuctions();

			$myReverseAuctions->id = $row['ra_id'];
			$myReverseAuctions->productname = $row['ra_productname'];
			$myReverseAuctions->image = $row['ra_image'];
			$myReverseAuctions->video = $row['ra_video'];
			$myReverseAuctions->image360 = $row['ra_image360'];
			$myReverseAuctions->price = $row['ra_price'];
			$myReverseAuctions->content = $row['ra_content'];
			$myReverseAuctions->technical = $row['ra_technical'];
			$myReverseAuctions->journalistically = $row['ra_journalistically'];
			$myReverseAuctions->startdate = $row['ra_startdate'];
			$myReverseAuctions->enddate = $row['ra_enddate'];
			$myReverseAuctions->status = $row['ra_status'];
			$myReverseAuctions->isshowblock = $row['ra_isshowblock'];
			$myReverseAuctions->datecreated = $row['ra_datecreated'];
			$myReverseAuctions->datemodified = $row['ra_datemodified'];


            $outputList[] = $myReverseAuctions;
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
	public static function getReverseAuctionss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_id = '.(int)$formData['fid'].' ';

		if($formData['fproductname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_productname = "'.Helper::unspecialtext((string)$formData['fproductname']).'" ';

		if($formData['fprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_price = '.(float)$formData['fprice'].' ';

		if($formData['fstartdate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_startdate = '.(int)$formData['fstartdate'].' ';

		if($formData['fenddate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_enddate = '.(int)$formData['fenddate'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_datemodified = '.(int)$formData['fdatemodified'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'productname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ra.ra_productname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ra.ra_productname LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ra_id ' . $sorttype;
		elseif($sortby == 'productname')
			$orderString = 'ra_productname ' . $sorttype;
		elseif($sortby == 'price')
			$orderString = 'ra_price ' . $sorttype;
		elseif($sortby == 'startdate')
			$orderString = 'ra_startdate ' . $sorttype;
		elseif($sortby == 'enddate')
			$orderString = 'ra_enddate ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ra_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ra_datemodified ' . $sorttype;
		else
			$orderString = 'ra_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
    {
        $output = array();

        $output[self::STATUS_ENABLE] = 'Chờ Đấu giá';
        $output[self::STATUS_DISABLED] = 'Đã Đấu giá';
        $output[self::STATUS_BUYING] = 'Đang Đấu giá';

        return $output;
    }

    public function getStatusName()
    {
        $name = '';

        switch($this->status)
        {
            case self::STATUS_ENABLE: $name = '<span class="label label-info">Chờ Đấu giá<span>'; break;
            case self::STATUS_DISABLED: $name = '<span class="label">Đã Đấu giá</span>'; break;
            case self::STATUS_BUYING: $name = '<span class="label label-warning">Đang Đấu giá</span>'; break;
        }

        return $name;
    }
    public function setCacher($id)
    {
    	$keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listProducts = $myCacher->get();
		//Neu khong co cache thi cache lai
		if (empty($listProducts))
		{
			//truy van database
			$listProducts = array();
			$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'asc', '');
			if (!empty($listproductfromdb))
			{
				foreach ($listproductfromdb as $product)
				{
					$listProducts[$product->id] = (array) $product;
					$listProducts[$product->id]['image'] = unserialize($listProducts[$product->id]['image']);
				}
			}
			$myCacher->set(json_encode($listProducts));
		}
		else
		{
			$listProducts = json_decode($listProducts, true);
			$reverseauctions = new Core_ReverseAuctions($id);
			if($reverseauctions->id > 0)
			{
				$reverseauctions->image = unserialize($reverseauctions->image);
				array_unshift($listProducts,get_object_vars($reverseauctions));
			}
			$myCacher->set(json_encode($listProducts));
		}
    }

    public function updateCacher()
    {

    	$keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'asc', '');
		$listProducts = array();
		if (!empty($listproductfromdb))
		{
			foreach ($listproductfromdb as $product)
			{
				$listProducts[$product->id] = (array) $product;
				$listProducts[$product->id]['image'] = unserialize($listProducts[$product->id]['image']);
			}
		}
		$myCacher->set(json_encode($listProducts));
    }
}