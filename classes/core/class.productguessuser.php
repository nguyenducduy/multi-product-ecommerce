<?php

/**
 * core/class.productguessuser.php
 *
 * File contains the class used for ProductGuessUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ProductGuessUser Class
 */
Class Core_ProductGuessUser extends Core_Object
{

	public $pid = 0;
	public $pgid = 0;
	public $id = 0;
	public $fullname = '';
	public $email = '';
	public $phone = '';
	public $address = '';
	public $answer = '';
	public $newsletterproduct = 0;
	public $newsletter = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_guess_user (
					p_id,
					pg_id,
					pgu_fullname,
					pgu_email,
					pgu_phone,
					pgu_address,
					pgu_answer,
					pgu_newsletterproduct,
					pgu_newsletter,
					pgu_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->pgid,
					(string)$this->fullname,
					(string)$this->email,
					(string)$this->phone,
					(string)$this->address,
					(string)$this->answer,
					(int)$this->newsletterproduct,
					(int)$this->newsletter,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_guess_user
				SET p_id = ?,
					pg_id = ?,
					pgu_fullname = ?,
					pgu_email = ?,
					pgu_phone = ?,
					pgu_address = ?,
					pgu_answer = ?,
					pgu_newsletterproduct = ?,
					pgu_newsletter = ?,
					pgu_datemodified = ?
				WHERE pgu_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->pgid,
					(string)$this->fullname,
					(string)$this->email,
					(string)$this->phone,
					(string)$this->address,
					(string)$this->answer,
					(int)$this->newsletterproduct,
					(int)$this->newsletter,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_guess_user pgu
				WHERE pgu.pgu_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = (int)$row['p_id'];
		$this->pgid = (int)$row['pg_id'];
		$this->id = (int)$row['pgu_id'];
		$this->fullname = (string)$row['pgu_fullname'];
		$this->email = (string)$row['pgu_email'];
		$this->phone = (string)$row['pgu_phone'];
		$this->address = (string)$row['pgu_address'];
		$this->answer = (string)$row['pgu_answer'];
		$this->newsletterproduct = (int)$row['pgu_newsletterproduct'];
		$this->newsletter = (int)$row['pgu_newsletter'];
		$this->datecreated = (int)$row['pgu_datecreated'];
		$this->datemodified = (int)$row['pgu_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_guess_user
				WHERE pgu_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_guess_user pgu';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_guess_user pgu';

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
			$myProductGuessUser = new Core_ProductGuessUser();

			$myProductGuessUser->pid = (int)$row['p_id'];
			$myProductGuessUser->pgid = (int)$row['pg_id'];
			$myProductGuessUser->id = (int)$row['pgu_id'];
			$myProductGuessUser->fullname = (string)$row['pgu_fullname'];
			$myProductGuessUser->email = (string)$row['pgu_email'];
			$myProductGuessUser->phone = (string)$row['pgu_phone'];
			$myProductGuessUser->address = (string)$row['pgu_address'];
			$myProductGuessUser->answer = (string)$row['pgu_answer'];
			$myProductGuessUser->newsletterproduct = (int)$row['pgu_newsletterproduct'];
			$myProductGuessUser->newsletter = (int)$row['pgu_newsletter'];
			$myProductGuessUser->datecreated = (int)$row['pgu_datecreated'];
			$myProductGuessUser->datemodified = (int)$row['pgu_datemodified'];


            $outputList[] = $myProductGuessUser;
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
	public static function getProductGuessUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pgu.pgu_id = '.(int)$formData['fid'].' ';

		if($formData['fpgid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pgu.pg_id = '.(int)$formData['fpgid'].' ';

		if($formData['fphone'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pgu.pgu_phone = '.(int)$formData['fphone'].' ';

		if($formData['ftoday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pgu.pgu_datecreated >= '.(int)$formData['fstarttime'].' AND pgu.pgu_datecreated <= ' .(int)$formData['fendtime'] . ' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pgu_id ' . $sorttype;
		else
			$orderString = 'pgu_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}







}