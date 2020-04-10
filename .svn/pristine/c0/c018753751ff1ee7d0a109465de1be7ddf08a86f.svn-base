<?php

/**
 * core/class.lottecode.php
 *
 * File contains the class used for LotteCode Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_LotteCode extends Core_Object
{

	const Type_Newmember =1;
	const Type_Reference =3;
	const Type_Erpsaleorder= 5;


	public $leid = 0;
	public $lmid = 0;
	public $id = 0;
	public $type = 0;
	public $code = "";
	public $erpsaleorderid = "";
	public $referer = 0;
	public $status = 0;
	public $datecreated = 0;

    public function __construct($id = 0, $loadFromCache = false)
	{
		parent::__construct();
		if($id > 0)
		{
			if($loadFromCache)
				$this->copy(self::cacheGet($id));
			else
				$this->getData($id);
		}
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'lotte_code (
					le_id,
					lm_id,
					lc_type,
					lc_code,
					lc_erpsaleorderid,
					lc_referer,
					lc_status,
					lc_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->leid,
					(int)$this->lmid,
					(int)$this->type,
					(string)$this->code,
					(string)$this->erpsaleorderid,
					(int)$this->referer,
					(int)$this->status,
					(int)$this->datecreated
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;
	}
        public static function getstatic()
        {
            global $db;
            $sql = 'SELECT count(lc_code) dem , lm_id
                    FROM lit_lotte_code
                    GROUP BY
                    lit_lotte_code.lm_id
                    ORDER BY dem DESC
                    LIMIT 0,10';
            $outputList = array();
            $stmt = $db->query($sql);
            while($row = $stmt->fetch())
            {
                $outputList[] = $row;
            }

            return $outputList;
        }

        public static function getType()
	{
		$arr[self::Type_Newmember] = 'New member';
		$arr[self::Type_Reference] = 'Reference';
		$arr[self::Type_Erpsaleorder] = 'Erp Saleorder';
		return $arr;
	}
	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'lotte_code
				SET le_id = ?,
					lm_id = ?,
					lc_type = ?,
					lc_code = ?,
					lc_erpsaleorderid = ?,
					lc_referer = ?,
					lc_status = ?,
					lc_datecreated = ?
				WHERE lc_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->leid,
					(int)$this->lmid,
					(int)$this->type,
					(string)$this->code,
					(string)$this->erpsaleorderid,
					(int)$this->referer,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code lc
				WHERE lc.lc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->leid = $row['le_id'];
		$this->lmid = $row['lm_id'];
		$this->id = $row['lc_id'];
		$this->type = $row['lc_type'];
		$this->code = $row['lc_code'];
		$this->erpsaleorderid = $row['lc_erpsaleorderid'];
		$this->referer = $row['lc_referer'];
		$this->status = $row['lc_status'];
		$this->datecreated = $row['lc_datecreated'];

	}

	public function getDataByArray($row)
	{
		$this->leid = $row['le_id'];
		$this->lmid = $row['lm_id'];
		$this->id = $row['lc_id'];
		$this->type = $row['lc_type'];
		$this->code = $row['lc_code'];
		$this->erpsaleorderid = $row['lc_erpsaleorderid'];
		$this->referer = $row['lc_referer'];
		$this->status = $row['lc_status'];
		$this->datecreated = $row['lc_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'lotte_code
				WHERE lc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'lotte_code lc';

		if($where != '')
			$sql .= ' WHERE ' . $where;
		return $db->query($sql)->fetchColumn(0);
	}
	public static function maxCode()
	{
		global $db;

		$sql = 'SELECT max(lc_code) FROM ' . TABLE_PREFIX . 'lotte_code lc';
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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code lc';

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
			$myLotteCode = new Core_LotteCode();

			$myLotteCode->leid = $row['le_id'];
			$myLotteCode->lmid = $row['lm_id'];
			$myLotteCode->id = $row['lc_id'];
			$myLotteCode->type = $row['lc_type'];
			$myLotteCode->code = $row['lc_code'];
			$myLotteCode->erpsaleorderid = $row['lc_erpsaleorderid'];
			$myLotteCode->referer = $row['lc_referer'];
			$myLotteCode->status = $row['lc_status'];
			$myLotteCode->datecreated = $row['lc_datecreated'];


            $outputList[] = $myLotteCode;
        }

        return $outputList;
    }
    public static function getTypename()
    {
        $arr =array();
        $arr[self::Type_Newmember] = 'Đăng kí';
        $arr[self::Type_Erpsaleorder] = 'Đổi điểm thành công';
        $arr[self::Type_Reference] = 'Giới thiệu thành công';
        return $arr;
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

	public static function getLotteCodes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fleid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.le_id = '.(int)$formData['fleid'].' ';

		if($formData['flmid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lm_id = '.(int)$formData['flmid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_type = '.(int)$formData['ftype'].' ';

		if($formData['fcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_code = "'.Helper::unspecialtext((string)$formData['fcode']).'" ';

		if($formData['ferpsaleorderid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_erpsaleorderid = "'.Helper::unspecialtext((string)$formData['ferpsaleorderid']).'" ';

		if($formData['freferer'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_referer = '.(int)$formData['freferer'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_status = '.(int)$formData['fstatus'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_datecreated = '.(int)$formData['fdatecreated'].' ';
		if($formData['fdatecreatedf'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_datecreated >= '.(int)$formData['fdatecreatedf'].' ';
		if($formData['fdatecreatedt'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_datecreated < '.(int)$formData['fdatecreatedt'].' ';
		if($formData['fdatecreatedsend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_datecreated = '.(int)$formData['fdatecreated'].' ';
		if($formData['fdatecreatedsend2'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_datecreated < '.(int)$formData['fdatecreatedsend2'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'code')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_code LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'erpsaleorderid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lc.lc_erpsaleorderid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (lc.lc_code LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (lc.lc_erpsaleorderid LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'leid')
			$orderString = 'le_id ' . $sorttype;
		elseif($sortby == 'lmid')
			$orderString = 'lm_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'lc_id ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 'lc_type ' . $sorttype;
		elseif($sortby == 'code')
			$orderString = 'lc_code ' . $sorttype;
		elseif($sortby == 'erpsaleorderid')
			$orderString = 'lc_erpsaleorderid ' . $sorttype;
		elseif($sortby == 'referer')
			$orderString = 'lc_referer ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'lc_status ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'lc_datecreated ' . $sorttype;
		else
			$orderString = 'lc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	////////////////////////////////
	////////////////////////////////
	// START CACHE PROCESS

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $id
	*/
	public static function cacheBuildKey($id)
	{
		return 'lottecode_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myLotteCode = new Core_LotteCode();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['lc_id'] > 0)
			{
				$myLotteCode->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myLotteCode->getDataByArray($row);
		}

		return $myLotteCode;
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $id
	*/
	public static function cacheClear($id)
	{
		$myCacher = new Cacher(self::cacheBuildKey($id));
		return $myCacher->clear();
	}

	// - END CACHE PROCESS
	////////////////////////////////


}