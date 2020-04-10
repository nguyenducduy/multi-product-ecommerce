<?php

/**
 * core/class.promotiongroup.php
 *
 * File contains the class used for Promotiongroup Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Promotiongroup extends Core_Object
{
	//0: chỉ được chọn giảm giá hoặc tặng quà, 1: được chọn cả 2; 2: Bắt buộc chọn cả 2
	const TYPE_DISCOUNTORGIFT = 0;
	const TYPE_DISCOUNTANDGIFT = 1;
	const TYPE_REQUEREDDISCOUNTGIF = 2;
	public $promoid = 0;
	public $id = 0;
	public $name = "";
	public $isfixed = 0;
	public $isdiscountpercentcal = 0;
	public $isonlyapplyforimei = 0;
	public $isdiscount = 0;
	public $discountvalue = 0;
	public $isdiscountpercent = 0;
	public $iscondition = 0;
	public $conditioncontent = "";
	public $type = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotiongroup (
					promo_id,
					promog_name,
					promog_isfixed,
					isdiscountpercentcal,
					promog_isonlyapplyforimei,
					promog_isdiscount,
					promog_discountvalue,
					promog_isdiscountpercent,
					promog_iscondition,
					promog_conditioncontent,
					promog_type
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->promoid,
					(string)$this->name,
					(int)$this->isfixed,
					(int)$this->isdiscountpercentcal,
					(int)$this->isonlyapplyforimei,
					(int)$this->isdiscount,
					(float)$this->discountvalue,
					(int)$this->isdiscountpercent,
					(int)$this->iscondition,
					(string)$this->conditioncontent,
					(int)$this->type
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;
	}

    public function addDataID()
    {

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotiongroup (
                    promo_id,
                    promog_id,
                    promog_name,
                    promog_isfixed,
                    isdiscountpercentcal,
                    promog_isonlyapplyforimei,
                    promog_isdiscount,
                    promog_discountvalue,
                    promog_isdiscountpercent,
                    promog_iscondition,
                    promog_conditioncontent,
                    promog_type
                    )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
                    (int)$this->promoid,
                    (string)$this->id,
                    (string)$this->name,
                    (int)$this->isfixed,
                    (int)$this->isdiscountpercentcal,
                    (int)$this->isonlyapplyforimei,
                    (int)$this->isdiscount,
                    (float)$this->discountvalue,
                    (int)$this->isdiscountpercent,
                    (int)$this->iscondition,
                    (string)$this->conditioncontent,
                    (int)$this->type
                    ))->rowCount();

        //$this->id = $this->db->lastInsertId();
        return $this->id;
    }

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotiongroup
				SET promo_id = ?,
					promog_name = ?,
					promog_isfixed = ?,
					isdiscountpercentcal = ?,
					promog_isonlyapplyforimei = ?,
					promog_isdiscount = ?,
					promog_discountvalue = ?,
					promog_isdiscountpercent = ?,
					promog_iscondition = ?,
					promog_conditioncontent = ?,
					promog_type = ?
				WHERE promog_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->promoid,
					(string)$this->name,
					(int)$this->isfixed,
					(int)$this->isdiscountpercentcal,
					(int)$this->isonlyapplyforimei,
					(int)$this->isdiscount,
					(float)$this->discountvalue,
					(int)$this->isdiscountpercent,
					(int)$this->iscondition,
					(string)$this->conditioncontent,
					(int)$this->type,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotiongroup p
				WHERE p.promog_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->promoid = $row['promo_id'];
		$this->id = $row['promog_id'];
		$this->name = $row['promog_name'];
		$this->isfixed = $row['promog_isfixed'];
		$this->isdiscountpercentcal = $row['isdiscountpercentcal'];
		$this->isonlyapplyforimei = $row['promog_isonlyapplyforimei'];
		$this->isdiscount = $row['promog_isdiscount'];
		$this->discountvalue = $row['promog_discountvalue'];
		$this->isdiscountpercent = $row['promog_isdiscountpercent'];
		$this->iscondition = $row['promog_iscondition'];
		$this->conditioncontent = $row['promog_conditioncontent'];
		$this->type = $row['promog_type'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotiongroup
				WHERE promog_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotiongroup p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotiongroup p';

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
			$myPromotiongroup = new Core_Promotiongroup();

			$myPromotiongroup->promoid = $row['promo_id'];
			$myPromotiongroup->id = $row['promog_id'];
			$myPromotiongroup->name = $row['promog_name'];
			$myPromotiongroup->isfixed = $row['promog_isfixed'];
			$myPromotiongroup->isdiscountpercentcal = $row['isdiscountpercentcal'];
			$myPromotiongroup->isonlyapplyforimei = $row['promog_isonlyapplyforimei'];
			$myPromotiongroup->isdiscount = $row['promog_isdiscount'];
			$myPromotiongroup->discountvalue = $row['promog_discountvalue'];
			$myPromotiongroup->isdiscountpercent = $row['promog_isdiscountpercent'];
			$myPromotiongroup->iscondition = $row['promog_iscondition'];
			$myPromotiongroup->conditioncontent = $row['promog_conditioncontent'];
			$myPromotiongroup->type = $row['promog_type'];


            $outputList[] = $myPromotiongroup;
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
	public static function getPromotiongroups($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpromoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_id = '.(int)$formData['fpromoid'].' ';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promog_id = '.(int)$formData['fid'].' ';

		if($formData['fisdiscountvalue'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promog_discountvalue = '.(int)$formData['fisdiscountvalue'].' ';

        if(isset($formData['fisdiscountvaluegreater']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promog_discountvalue > '.(int)$formData['fisdiscountvaluegreater'].' ';

		if(count($formData['fidarr']) > 0 && $formData['fid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fidarr']) ; $i++)
            {
                if($i == count($formData['fidarr']) - 1)
                {
                    $whereString .= 'p.promog_id = ' . (int)$formData['fidarr'][$i];
                }
                else
                {
                    $whereString .= 'p.promog_id = ' . (int)$formData['fidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

        if(count($formData['fpromoidarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fpromoidarr']) ; $i++)
            {
                if($i == count($formData['fpromoidarr']) - 1)
                {
                    $whereString .= 'p.promo_id = ' . (int)$formData['fpromoidarr'][$i];
                }
                else
                {
                    $whereString .= 'p.promo_id = ' . (int)$formData['fpromoidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
            $orderString = 'promog_id ' . $sorttype;
        elseif($sortby == 'discountvalue')
			$orderString = 'promog_discountvalue ' . $sorttype;
		else
			$orderString = 'promog_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}