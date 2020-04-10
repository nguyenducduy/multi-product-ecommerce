<?php

/**
 * core/class.jobcv.php
 *
 * File contains the class used for Jobcv Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Jobcv extends Core_Object
{
	const STATUS_NEW = 1;
	const STATUS_INTERVIEW = 3;
	const STATUS_SAVE = 5;


	public $jid = 0;
	public $id = 0;
	public $title = "";
	public $file = "";
	public $firstname = "";
	public $lastname = "";
	public $birthday = "";
	public $email = "";
	public $phone = "";
	public $moderatorid = 0;
	public $ipaddress = 0;
	public $status = 0;
	public $rating = 0;
	public $note = '';
	public $dateinterview = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $jobactor = null;
	public $moderatoractor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'jobcv (
					j_id,
					jc_title,
					jc_file,
					jc_firstname,
					jc_lastname,
					jc_birthday,
					jc_email,
					jc_phone,
					jc_moderatorid,
					jc_ipaddress,
					jc_status,
					jc_rating,
					jc_note,
					jc_dateinterview,
					jc_datecreated,
					jc_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->jid,
					(string)$this->title,
					(string)$this->file,
					(string)$this->firstname,
					(string)$this->lastname,
					(string)$this->birthday,
					(string)$this->email,
					(string)$this->phone,
					(int)$this->moderatorid,
					(int)$this->ipaddress,
					(int)$this->status,
					(int)$this->rating,
					(string)$this->note,
					(int)$this->dateinterview,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		if($this->id > 0)
		{
			if(strlen($_FILES['ffile']['name']) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->file != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'jobcv
                            SET jc_file = ?
                            WHERE jc_id = ?';
                    $result=$this->db->query($sql, array($this->file, $this->id));
                    if(!$result)
                    	return false;
                }
            }
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'jobcv
				SET j_id = ?,
					jc_title = ?,
					jc_file = ?,
					jc_firstname = ?,
					jc_lastname = ?,
					jc_birthday = ?,
					jc_email = ?,
					jc_phone = ?,
					jc_moderatorid = ?,
					jc_ipaddress = ?,
					jc_status = ?,
					jc_rating = ?,
					jc_note = ?,
					jc_dateinterview = ?,
					jc_datecreated = ?,
					jc_datemodified = ?
				WHERE jc_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->jid,
					(string)$this->title,
					(string)$this->file,
					(string)$this->firstname,
					(string)$this->lastname,
					(string)$this->birthday,
					(string)$this->email,
					(string)$this->phone,
					(int)$this->moderatorid,
					(int)$this->ipaddress,
					(int)$this->status,
					(int)$this->rating,
					(string)$this->note,
					(int)$this->dateinterview,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
		{
			if(strlen($_FILES['ffile']['name']) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                {
                	return false;
                }
                elseif($this->file != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'jobcv
                            SET jc_file = ?
                            WHERE jc_id = ?';
                    $result=$this->db->query($sql, array($this->file, $this->id));
                    if(!$result)
                    	return false;
                }
            }
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'jobcv jc
				WHERE jc.jc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->jid = $row['j_id'];
		$this->id = $row['jc_id'];
		$this->title = $row['jc_title'];
		$this->file = $row['jc_file'];
		$this->firstname = $row['jc_firstname'];
		$this->lastname = $row['jc_lastname'];
		$this->birthday = $row['jc_birthday'];
		$this->email = $row['jc_email'];
		$this->phone = $row['jc_phone'];
		$this->moderatorid = $row['jc_moderatorid'];
		$this->ipaddress = $row['jc_ipaddress'];
		$this->status = $row['jc_status'];
		$this->rating = $row['jc_rating'];
		$this->note = $row['jc_note'];
		$this->dateinterview = $row['jc_dateinterview'];
		$this->datecreated = $row['jc_datecreated'];
		$this->datemodified = $row['jc_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'jobcv
				WHERE jc_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();
        $this->deleteImage();
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'jobcv jc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'jobcv jc';

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
			$myJobcv = new Core_Jobcv();

			$myJobcv->jid = $row['j_id'];
			$myJobcv->id = $row['jc_id'];
			$myJobcv->title = $row['jc_title'];
			$myJobcv->file = $row['jc_file'];
			$myJobcv->firstname = $row['jc_firstname'];
			$myJobcv->lastname = $row['jc_lastname'];
			$myJobcv->birthday = $row['jc_birthday'];
			$myJobcv->email = $row['jc_email'];
			$myJobcv->phone = $row['jc_phone'];
			$myJobcv->moderatorid = $row['jc_moderatorid'];
			$myJobcv->ipaddress = $row['jc_ipaddress'];
			$myJobcv->status = $row['jc_status'];
			$myJobcv->rating = $row['jc_rating'];
			$myJobcv->note = $row['jc_note'];
			$myJobcv->dateinterview = $row['jc_dateinterview'];
			$myJobcv->datecreated = $row['jc_datecreated'];
			$myJobcv->datemodified = $row['jc_datemodified'];


            $outputList[] = $myJobcv;
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
	public static function getJobcvs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fjid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.j_id = '.(int)$formData['fjid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_id = '.(int)$formData['fid'].' ';

		if($formData['ftitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_title = "'.Helper::unspecialtext((string)$formData['ftitle']).'" ';

		if($formData['ffirstname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_firstname = "'.Helper::unspecialtext((string)$formData['ffirstname']).'" ';

		if($formData['flastname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_lastname = "'.Helper::unspecialtext((string)$formData['flastname']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fphone'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_phone = "'.Helper::unspecialtext((string)$formData['fphone']).'" ';

		if($formData['fmoderatorid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_moderatorid = '.(int)$formData['fmoderatorid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'title')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'firstname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_firstname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'lastname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_lastname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'phone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'jc.jc_phone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (jc.jc_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (jc.jc_firstname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (jc.jc_lastname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (jc.jc_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (jc.jc_phone LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'jid')
			$orderString = 'j_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'jc_id ' . $sorttype;
		elseif($sortby == 'firstname')
			$orderString = 'jc_firstname ' . $sorttype;
		elseif($sortby == 'lastname')
			$orderString = 'jc_lastname ' . $sorttype;
		elseif($sortby == 'email')
			$orderString = 'jc_email ' . $sorttype;
		elseif($sortby == 'phone')
			$orderString = 'jc_phone ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'jc_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'jc_datemodified ' . $sorttype;
		else
			$orderString = 'jc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_NEW] = 'Mới';
		$output[self::STATUS_INTERVIEW] = 'Hẹn phỏng vấn';
		$output[self::STATUS_SAVE] = 'Lưu hồ sơ';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_NEW: $name = 'Mới'; break;
			case self::STATUS_INTERVIEW: $name = 'Hẹn phỏng vấn'; break;
			case self::STATUS_SAVE: $name = 'Lưu hồ sơ'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_NEW && $name == 'mới' || $this->status == self::STATUS_INTERVIEW && $name == 'hẹn phỏng vấn' || $this->status == self::STATUS_SAVE && $name == 'lưu hồ sơ')
			return true;
		else
			return false;
	}

	public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['ffile']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->title, true,true) . '-' . Helper::codau2khongdau($this->firstname . $this->lastname , true, true) .$this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['ffile']['tmp_name'], $name, $registry->setting['jobcv']['imageDirectory'] . $curDateDir, '');
        $uploader->validType =  $registry->setting['jobcv']['imageValidType'];
        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //update database
            $this->file = $curDateDir . $name;
        }
    }

    public function deleteImage($imagepath = '')
    {
        global $registry;

        //delete current image
        if($imagepath == '')
            $deletefile = $this->file;
		else
            $deletefile = $imagepath;

        if(strlen($deletefile) > 0)
        {
            $file = $registry->setting['jobcv']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

			}

            //delete current image
            if($imagepath == '')
                $this->file = '';
        }
    }

}