<?php

/**
 * core/class.promotionstore.php
 *
 * File contains the class used for PromotionStore Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_PromotionStore extends Core_Object
{

	public $promoid = 0;
	public $sid = 0;
	public $id = 0;
    public $storeObject = null;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion_store (
					promo_id,
					s_id
					)
		        VALUES(?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->promoid,
					(int)$this->sid
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotion_store
				SET promo_id = ?,
					s_id = ?
				WHERE promos_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->promoid,
					(int)$this->sid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_store ps
				WHERE ps.promos_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->promoid = $row['promo_id'];
		$this->sid = $row['s_id'];
		$this->id = $row['promos_id'];
		//$this->storeObject = new Core_Store($row['s_id']);
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotion_store
				WHERE promos_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotion_store ps';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_store ps';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
        //echo $sql.'<br />'; die();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myPromotionStore = new Core_PromotionStore();

			$myPromotionStore->promoid = $row['promo_id'];
			$myPromotionStore->sid = $row['s_id'];
			$myPromotionStore->id = $row['promos_id'];

            $outputList[] = $myPromotionStore;
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
	public static function getPromotionStores($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpromoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.promo_id = '.(int)$formData['fpromoid'].' ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.promos_id = '.(int)$formData['fid'].' ';

		if(count($formData['fpromoidarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fpromoidarr']) ; $i++)
            {
                if($i == count($formData['fpromoidarr']) - 1)
                {
                    $whereString .= 'ps.promo_id = ' . (int)$formData['fpromoidarr'][$i];
                }
                else
                {
                    $whereString .= 'ps.promo_id = ' . (int)$formData['fpromoidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

        if(count($formData['fsidarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fsidarr']) ; $i++)
            {
                if($i == count($formData['fsidarr']) - 1)
                {
                    $whereString .= 'ps.s_id = ' . (int)$formData['fsidarr'][$i];
                }
                else
                {
                    $whereString .= 'ps.s_id = ' . (int)$formData['fsidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'promoid')
			$orderString = 'promo_id ' . $sorttype;
		elseif($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'promos_id ' . $sorttype;
		else
			$orderString = 'promos_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}