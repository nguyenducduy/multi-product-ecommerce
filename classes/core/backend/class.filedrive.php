<?php

/**
 * core/backend/class.filedrive.php
 *
 * File contains the class used for File Drive Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

Class Core_Backend_FileDrive extends Core_Backend_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 3;
	const STATUS_TEMP_MESSAGEATTACH = 5;
	const STATUS_TEMP_FEEDATTACH = 7;
	const STATUS_TEMP_GENERAL = 9;

	public $uid = 0;
	public $id = 0;
	public $resourceserver = 0;
	public $filepath = '';
	public $filechecksum = '';
	public $filesize = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}


    //Ham upload anh
    //Da kiem tra co anh roi!!!
    public function uploadFile()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();

		$extPart = strtolower(substr(strrchr($_FILES['ffile']['name'],'.'), 1));
		$name = $this->id . '.' . $extPart;
        $uploader = new Uploader($_FILES['ffile']['tmp_name'], $name, $registry->setting['filecloud']['fileDirectory'] . $curDateDir, '', $registry->setting['filecloud']['fileValidType']);

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //update database
			$this->filesize = filesize($registry->setting['filecloud']['fileDirectory'] . $curDateDir . $name);
			$this->filechecksum = md5_file($registry->setting['filecloud']['fileDirectory'] . $curDateDir . $name);
            $this->filepath = $curDateDir . $name;
        }
    }


	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'file_drive (
					u_id,
					fd_resourceserver,
					fd_filepath,
					fd_filechecksum,
					fd_filesize,
					fd_status,
					fd_datecreated,
					fd_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->resourceserver,
					(string)$this->filepath,
					(string)$this->filechecksum,
					(int)$this->filesize,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					))->rowCount();

		$this->id = $this->db3->lastInsertId();

		if($this->id > 0)
		{
			if(strlen($_FILES['ffile']['name']) > 0)
	        {
	            //upload image
	            $uploadFileResult = $this->uploadFile();

	            if($uploadFileResult != Uploader::ERROR_UPLOAD_OK)
	                return false;
	            else if($this->filepath != '')
	            {
	                if(!$this->updateFile())
	                    return false;
	            }
	        }
		}

		return $this->id;
	}

	public function updateFile()
    {
		$sql = 'UPDATE ' . TABLE_PREFIX . 'file_drive
                SET fd_resourceserver = ?,
					fd_filepath = ?,
					fd_filechecksum = ?,
					fd_filesize = ?
                WHERE fd_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->resourceserver,
                (string)$this->filepath,
                (string)$this->filechecksum,
                (string)$this->filesize,
                (int)$this->id
            ));

        //Xu ly anh
        if($stmt)
        	return true;
		else
			return false;
    }


	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'file_drive
				SET u_id = ?,
					fd_resourceserver = ?,
					fd_filepath = ?,
					fd_filechecksum = ?,
					fd_filesize = ?,
					fd_status = ?,
					fd_datemodified = ?
				WHERE fd_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->resourceserver,
					(string)$this->filepath,
					(string)$this->filechecksum,
					(int)$this->filesize,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file_drive fd
				WHERE fd.fd_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['fd_id'];
		$this->resourceserver = $row['fd_resourceserver'];
		$this->filepath = $row['fd_filepath'];
		$this->filechecksum = $row['fd_filechecksum'];
		$this->filesize = $row['fd_filesize'];
		$this->status = $row['fd_status'];
		$this->datecreated = $row['fd_datecreated'];
		$this->datemodified = $row['fd_datemodified'];
	}

	public function getDataFromArray($row)
	{
		$this->uid = $row['u_id'];
		$this->id = $row['fd_id'];
		$this->resourceserver = $row['fd_resourceserver'];
		$this->filepath = $row['fd_filepath'];
		$this->filechecksum = $row['fd_filechecksum'];
		$this->filesize = $row['fd_filesize'];
		$this->status = $row['fd_status'];
		$this->datecreated = $row['fd_datecreated'];
		$this->datemodified = $row['fd_datemodified'];

	}


	public function deleteFile($filepath = '')
    {
        global $registry;

        //delete current file
        if($filepath == '')
            $deletefile = $this->filepath;
		else
            $deletefile = $imagepath;

        if(strlen($deletefile) > 0)
        {
            $file = $registry->setting['filecloud']['fileDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

			}

            //delete current image
            if($filepath == '')
                $this->filepath = '';
        }
    }


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'file_drive
				WHERE fd_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		$this->deleteFile();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'file_drive fd';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file_drive fd';

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
			$myFileDrive = new Core_Backend_FileDrive();

			$myFileDrive->uid = $row['u_id'];
			$myFileDrive->id = $row['fd_id'];
			$myFileDrive->resourceserver = $row['fd_resourceserver'];
			$myFileDrive->filepath = $row['fd_filepath'];
			$myFileDrive->filechecksum = $row['fd_filechecksum'];
			$myFileDrive->filesize = $row['fd_filesize'];
			$myFileDrive->status = $row['fd_status'];
			$myFileDrive->datecreated = $row['fd_datecreated'];
			$myFileDrive->datemodified = $row['fd_datemodified'];


            $outputList[] = $myFileDrive;
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
	public static function getFileDrives($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fd.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fd.fd_id = '.(int)$formData['fid'].' ';

		if(isset($formData['fresourceserver']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fd.fd_resourceserver = "'.(int)$formData['fresourceserver'].'" ';

		if($formData['ffilechecksum'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fd.fd_filechecksum = "'.Helper::plaintext((string)$formData['ffilechecksum']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fd.fd_status = '.(int)$formData['fstatus'].' ';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'fd_id ' . $sorttype;
		elseif($sortby == 'filesize')
			$orderString = 'fd_filesize ' . $sorttype;
		else
			$orderString = 'fd_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getFromChecksum($filechecksum)
	{
		$files = self::getFileDrives(array('ffilechecksum' => $filechecksum), '', '', 1);


		if(count($files) > 0)
		{
			$myFileDrive = $files[0];
		}
		else
		{
			$myFileDrive = new Core_Backend_FileDrive();
		}

		return $myFileDrive;
	}

	public function getDisplaySize()
	{
		return Helper::formatFileSize($this->filesize);
	}

	public function uploadFileMobile($i)
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();

		$extPart = strtolower(substr(strrchr($_FILES['attachedfile_'.$i]['name'],'.'), 1));
		$name = $this->id . '.' . $extPart;
        $uploader = new Uploader($_FILES['attachedfile_'.$i]['tmp_name'], $name, $registry->setting['filecloud']['fileDirectory'] . $curDateDir, '', $registry->setting['filecloud']['fileValidType']);

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //update database
			$this->filesize = filesize($registry->setting['filecloud']['fileDirectory'] . $curDateDir . $name);
			$this->filechecksum = md5_file($registry->setting['filecloud']['fileDirectory'] . $curDateDir . $name);
            $this->filepath = $curDateDir . $name;
        }
    }
    public function updateFileMobile()
    {
		$sql = 'UPDATE ' . TABLE_PREFIX . 'file_drive
                SET fd_resourceserver = ?,
					fd_filepath = ?,
					fd_filechecksum = ?,
					fd_filesize = ?
                WHERE fd_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->resourceserver,
                (string)$this->filepath,
                (string)$this->filechecksum,
                (string)$this->filesize,
                (int)$this->id
            ));

        //Xu ly anh
        if($stmt)
        	return true;
		else
			return false;
    }
    public function addDataFromMobile($i)
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'file_drive (
					u_id,
					fd_resourceserver,
					fd_filepath,
					fd_filechecksum,
					fd_filesize,
					fd_status,
					fd_datecreated,
					fd_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->resourceserver,
					(string)$this->filepath,
					(string)$this->filechecksum,
					(int)$this->filesize,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					))->rowCount();

		$this->id = $this->db3->lastInsertId();

		if($this->id > 0)
		{
			if(strlen($_FILES['attachedfile_'.$i]['name']) > 0)
	        {
	            //upload image
	            $uploadFileResult = $this->uploadFileMobile($i);

	            if($uploadFileResult != Uploader::ERROR_UPLOAD_OK)
	                return false;
	            else if($this->filepath != '')
	            {
	                if(!$this->updateFileMobile())
	                    return false;
	            }
	        }
		}

		return $this->id;
	}


}