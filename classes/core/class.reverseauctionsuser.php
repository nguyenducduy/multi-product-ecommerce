<?php

/**
 * core/class.reverseauctionsuser.php
 *
 * File contains the class used for ReverseAuctionsUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ReverseAuctionsUser extends Core_Object
{

	public $raid = 0;
	public $id = 0;
	public $fullname = "";
	public $email = "";
	public $price = 0;
	public $phone = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'reverse_auctions_user (
					ra_id,
					rau_fullname,
					rau_email,
					rau_price,
					rau_phone,
					rau_datecreated,
					rau_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->raid,
					(string)$this->fullname,
					(string)$this->email,
					(float)$this->price,
					(string)$this->phone,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'reverse_auctions_user
				SET ra_id = ?,
					rau_fullname = ?,
					rau_email = ?,
					rau_price = ?,
					rau_phone = ?,
					rau_datecreated = ?,
					rau_datemodified = ?
				WHERE rau_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->raid,
					(string)$this->fullname,
					(string)$this->email,
					(float)$this->price,
					(string)$this->phone,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'reverse_auctions_user rau
				WHERE rau.rau_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->raid = $row['ra_id'];
		$this->id = $row['rau_id'];
		$this->fullname = $row['rau_fullname'];
		$this->email = $row['rau_email'];
		$this->price = $row['rau_price'];
		$this->phone = $row['rau_phone'];
		$this->datecreated = $row['rau_datecreated'];
		$this->datemodified = $row['rau_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'reverse_auctions_user
				WHERE rau_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'reverse_auctions_user rau';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'reverse_auctions_user rau';

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
			$myReverseAuctionsUser = new Core_ReverseAuctionsUser();

			$myReverseAuctionsUser->raid = $row['ra_id'];
			$myReverseAuctionsUser->id = $row['rau_id'];
			$myReverseAuctionsUser->fullname = $row['rau_fullname'];
			$myReverseAuctionsUser->email = $row['rau_email'];
			$myReverseAuctionsUser->price = $row['rau_price'];
			$myReverseAuctionsUser->phone = $row['rau_phone'];
			$myReverseAuctionsUser->datecreated = $row['rau_datecreated'];
			$myReverseAuctionsUser->datemodified = $row['rau_datemodified'];


            $outputList[] = $myReverseAuctionsUser;
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
	public static function getReverseAuctionsUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fraid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.ra_id = '.(int)$formData['fraid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_id = '.(int)$formData['fid'].' ';

		if($formData['ffullname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_fullname = "'.Helper::unspecialtext((string)$formData['ffullname']).'" ';

		if($formData['ffullnamelike'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_fullname LIKE  \'%'.$formData['ffullnamelike'].'%\'';;


		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_price = '.(float)$formData['fprice'].' ';

		if($formData['fphone'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_phone = "'.Helper::unspecialtext((string)$formData['fphone']).'" ';

		if($formData['fisdate'] == 1){
			$startdate = Helper::strtotimedmy(date('d/m/Y'),'00:00:00');
			$enddate = Helper::strtotimedmy(date('d/m/Y'),'23:59:00');
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_datecreated >= '.$startdate.' AND rau.rau_datecreated <= '.$enddate.' ';
		}



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rau.rau_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (rau.rau_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (rau.rau_email LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'raid')
			$orderString = 'ra_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rau_id ' . $sorttype;
		elseif($sortby == 'fullname')
			$orderString = 'rau_fullname ' . $sorttype;
		elseif($sortby == 'email')
			$orderString = 'rau_email ' . $sorttype;
		elseif($sortby == 'price')
			$orderString = 'rau_price ' . $sorttype;
		elseif($sortby == 'phone')
			$orderString = 'rau_phone ' . $sorttype;
		else
			$orderString = 'rau_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

   	public function getProductNameByID()
   	{
   		$id = $this->raid;
   		$sql = 'SELECT * FROM '.TABLE_PREFIX.'reverse_auctions WHERE ra_id = '.$id;
   		$row = $this->db->query($sql)->fetch();
   		if(!empty($row))
   		{
   			return $row['ra_productname'];
   		}
   	}
}