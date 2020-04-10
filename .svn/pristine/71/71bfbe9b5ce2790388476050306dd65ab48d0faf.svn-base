<?php

/**
 * core/class.apipartnersale.php
 *
 * File contains the class used for ApiPartnerSale Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ApiPartnerSale extends Core_Backend_Object
{
	const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;

	public $apid = 0;
	public $uid = 0;
	public $pid = 0;
	public $pbarcode = "";
	public $id = 0;
	public $discountvalue = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $dateimport = 0;
	public $apipartneractor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'api_partner_sale (
					ap_id,
					u_id,
					p_id,
					p_barcode,
					apc_discountvalue,
					apc_status,
					apc_datecreated,
					apc_datemodified,
					apc_dateimport
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->apid,
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->pbarcode,
					(float)$this->discountvalue,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->dateimport
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'api_partner_sale
				SET ap_id = ?,
					u_id = ?,
					p_id = ?,
					p_barcode = ?,
					apc_discountvalue = ?,
					apc_status = ?,
					apc_datecreated = ?,
					apc_datemodified = ?,
					apc_dateimport = ?
				WHERE apc_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->apid,
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->pbarcode,
					(float)$this->discountvalue,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->dateimport,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'api_partner_sale aps
				WHERE aps.apc_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->apid = $row['ap_id'];
		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['apc_id'];
		$this->discountvalue = $row['apc_discountvalue'];
		$this->status = $row['apc_status'];
		$this->datecreated = $row['apc_datecreated'];
		$this->datemodified = $row['apc_datemodified'];
		$this->dateimport = $row['apc_dateimport'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'api_partner_sale
				WHERE apc_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'api_partner_sale aps';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db3->query($sql)->fetchColumn(0);
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
		$db3 = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'api_partner_sale aps';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myApiPartnerSale = new Core_Backend_ApiPartnerSale();

			$myApiPartnerSale->apid = $row['ap_id'];
			$myApiPartnerSale->uid = $row['u_id'];
			$myApiPartnerSale->pid = $row['p_id'];
			$myApiPartnerSale->pbarcode = $row['p_barcode'];
			$myApiPartnerSale->id = $row['apc_id'];
			$myApiPartnerSale->discountvalue = $row['apc_discountvalue'];
			$myApiPartnerSale->status = $row['apc_status'];
			$myApiPartnerSale->datecreated = $row['apc_datecreated'];
			$myApiPartnerSale->datemodified = $row['apc_datemodified'];
			$myApiPartnerSale->dateimport = $row['apc_dateimport'];


            $outputList[] = $myApiPartnerSale;
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
	public static function getApiPartnerSales($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fapid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.ap_id = '.(int)$formData['fapid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.apc_id = '.(int)$formData['fid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.apc_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'pbarcode')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'aps.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (aps.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'apid')
			$orderString = 'ap_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'apc_id ' . $sorttype;
		elseif($sortby == 'discountvalue')
			$orderString = 'apc_discountvalue ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'apc_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'apc_datemodified ' . $sorttype;
		elseif($sortby == 'dateimport')
			$orderString = 'apc_dateimport ' . $sorttype;
		else
			$orderString = 'apc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getStatusList()
    {
        $outputList = array();

        $outputList[self::STATUS_ENABLE] = 'Enable';
        $outputList[self::STATUS_DISABLE] = 'Disable';

        return $outputList;
    }

    public function getStatusName()
    {
        $statusName = '';

        switch ($this->status)
        {
            case self::STATUS_ENABLE:
                $statusName = 'Enable';
                break;

            case self::STATUS_DISABLE:
                $statusName = 'Disable';
                break;
        }

        return $statusName;
    }

    public function checkStatusName($name)
    {
        $name = strtolower($name);

        if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
            return true;
        else
            return false;
    }


    public static function checkbarcodeisExist($barcode = '' , $apid = 0)
    {
        $isexist = true;
        $db3 = self::getDb();

        if(strlen(trim($barcode)) > 0)
        {
			if($apid > 0) {
				$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'api_partner_sale WHERE p_barcode = ? AND ap_id = ?';

				$rowCount = $db3->query($sql , array($barcode , $apid))->fetchColumn(0);

			} else {
				$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'api_partner_sale WHERE p_barcode = ?';

				$rowCount = $db3->query($sql , array($barcode))->fetchColumn(0);
			}

            if($rowCount == 0)
                $isexist = false;

        }

        return $isexist;
    }

	public static function updateDiscountValue($formData = array())
	{
		$db3 = self::getDb();
		if(count($formData) > 0) {
			$sql = 'UPDATE ' . TABLE_PREFIX . 'api_partner_sale SET apc_discountvalue = ?  WHERE ap_id = ? AND p_barcode = ?';
			$stmt = $db3->query($sql, array(
									$formData['discountvalue'],
									$formData['apid'],
									$formData['pbarcode']
								));
			if($stmt)
				return true;
			else
				return false;
		}

	}


	public static function getDiscountValueByBarcode($formData = array())
	{
		$discountvalue = 0;
		$db3 = self::getDb();
		if(count($formData) > 0)
		{
			$sql = 'SELECT apc_discountvalue FROM ' . TABLE_PREFIX . 'api_partner_sale WHERE ap_id = ? AND p_barcode = ?';
			$row = $db3->query($sql , array($formData['apid'] , $formData['barcode']))->fetch();
			$discountvalue = $row['apc_discountvalue'];
		}

		return $discountvalue;
	}

}