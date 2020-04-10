<?php

/**
 * core/backend/class.file.php
 *
 * File contains the class used for File Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_File extends Core_Backend_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLESHARING = 3;

	const UPLOADTYPE_NORMALUPLOAD = 0;
	const UPLOADTYPE_MESSAGEATTACH = 2;
	const UPLOADTYPE_FEEDATTACH = 4;
	const UPLOADTYPE_INTRASH = 6;
	const UPLOADTYPE_DELETED = 8;


	public $uid = 0;
	public $id = 0;
	public $name = "";
	public $nameseo = "";
	public $publictoken = "";
	public $summary = "";
	public $extension = "";
	public $isdirectory = 0;
	public $type = 0;
	public $parentid = 0;
	public $isstarred = 0;
	public $status = 0;
	public $permission = 0;
	public $countview = 0;
	public $countdownload = 0;
	public $countchildren = 0;
	public $uploadtype = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $datelastdownloaded = 0;

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
		$this->publictoken = $this->generatePublicToken();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'file (
					u_id,
					f_name,
					f_nameseo,
					f_publictoken,
					f_summary,
					f_extension,
					f_filesize,
					f_isdirectory,
					f_type,
					f_parentid,
					f_isstarred,
					f_status,
					f_permission,
					f_countview,
					f_countdownload,
					f_countchildren,
					f_uploadtype,
					f_datecreated,
					f_datemodified,
					f_datelastdownloaded
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->name,
					(string)$this->nameseo,
					(string)$this->publictoken,
					(string)$this->summary,
					(string)$this->extension,
					(int)$this->filesize,
					(int)$this->isdirectory,
					(int)$this->type,
					(int)$this->parentid,
					(int)$this->isstarred,
					(int)$this->status,
					(int)$this->permission,
					(int)$this->countview,
					(int)$this->countdownload,
					(int)$this->countchildren,
					(int)$this->uploadtype,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->datelastdownloaded
					))->rowCount();

		$this->id = $this->db3->lastInsertId();

		if($this->id > 0)
		{
			if(strlen($_FILES['ffile']['name']) > 0)
	        {
				$checksum = md5_file($_FILES['ffile']['tmp_name']);
				$myFileDrive = Core_Backend_FileDrive::getFromChecksum($checksum);



				if($myFileDrive->id == 0)
				{
					$myFileDrive = new Core_Backend_FileDrive();
					$myFileDrive->uid = $this->uid;
					$myFileDrive->status = Core_Backend_FileDrive::STATUS_ENABLE;
					if($myFileDrive->addData() == false)
						return false;
				}

				$this->fdid = $myFileDrive->id;
				$this->name = $_FILES['ffile']['name'];
				$this->nameseo = Helper::codau2khongdau($this->name, true, true);
				$this->filesize = $_FILES['ffile']['size'];
				$this->extension = strtoupper(Helper::fileExtension($this->name));

				$sql = 'UPDATE ' . TABLE_PREFIX . 'file
						SET fd_id = ?,
							f_name = ?,
							f_nameseo = ?,
							f_filesize = ?,
							f_extension = ?
						WHERE f_id = ?';
				$this->db3->query($sql, array(
					$this->fdid,
					$this->name,
					$this->nameseo,
					$this->filesize,
					$this->extension,
					$this->id
				));
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'file
				SET u_id = ?,
					f_name = ?,
					f_nameseo = ?,
					f_publictoken = ?,
					f_summary = ?,
					f_extension = ?,
					f_filesize = ?,
					f_isdirectory = ?,
					f_type = ?,
					f_parentid = ?,
					f_isstarred = ?,
					f_status = ?,
					f_permission = ?,
					f_countview = ?,
					f_countdownload = ?,
					f_countchildren = ?,
					f_uploadtype = ?,
					f_datecreated = ?,
					f_datemodified = ?,
					f_datelastdownloaded = ?
				WHERE f_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->name,
					(string)$this->nameseo,
					(string)$this->publictoken,
					(string)$this->summary,
					(string)$this->extension,
					(int)$this->filesize,
					(int)$this->isdirectory,
					(int)$this->type,
					(int)$this->parentid,
					(int)$this->isstarred,
					(int)$this->status,
					(int)$this->permission,
					(int)$this->countview,
					(int)$this->countdownload,
					(int)$this->countchildren,
					(int)$this->uploadtype,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->datelastdownloaded,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file f
				WHERE f.f_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->fdid = $row['fd_id'];
		$this->id = $row['f_id'];
		$this->name = $row['f_name'];
		$this->nameseo = $row['f_nameseo'];
		$this->publictoken = $row['f_publictoken'];
		$this->summary = $row['f_summary'];
		$this->extension = $row['f_extension'];
		$this->filesize = $row['f_filesize'];
		$this->isdirectory = $row['f_isdirectory'];
		$this->type = $row['f_type'];
		$this->parentid = $row['f_parentid'];
		$this->isstarred = $row['f_isstarred'];
		$this->status = $row['f_status'];
		$this->permission = $row['f_permission'];
		$this->countview = $row['f_countview'];
		$this->countdownload = $row['f_countdownload'];
		$this->countchildren = $row['f_countchildren'];
		$this->uploadtype = $row['f_uploadtype'];
		$this->datecreated = $row['f_datecreated'];
		$this->datemodified = $row['f_datemodified'];
		$this->datelastdownloaded = $row['f_datelastdownloaded'];

	}

	public function getDataFromArray($row)
	{
		$this->uid = $row['u_id'];
		$this->fdid = $row['fd_id'];
		$this->id = $row['f_id'];
		$this->name = $row['f_name'];
		$this->nameseo = $row['f_nameseo'];
		$this->publictoken = $row['f_publictoken'];
		$this->summary = $row['f_summary'];
		$this->extension = $row['f_extension'];
		$this->filesize = $row['f_filesize'];
		$this->isdirectory = $row['f_isdirectory'];
		$this->type = $row['f_type'];
		$this->parentid = $row['f_parentid'];
		$this->isstarred = $row['f_isstarred'];
		$this->status = $row['f_status'];
		$this->permission = $row['f_permission'];
		$this->countview = $row['f_countview'];
		$this->countdownload = $row['f_countdownload'];
		$this->countchildren = $row['f_countchildren'];
		$this->uploadtype = $row['f_uploadtype'];
		$this->datecreated = $row['f_datecreated'];
		$this->datemodified = $row['f_datemodified'];
		$this->datelastdownloaded = $row['f_datelastdownloaded'];

	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'file
				WHERE f_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		if($this->isdirectory == 0)
		{
			//delete connection between file & filedrive
		}

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'file f';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file f';

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
			$myFile = new Core_Backend_File();

			$myFile->uid = $row['u_id'];
			$myFile->fdid = $row['fd_id'];
			$myFile->id = $row['f_id'];
			$myFile->name = $row['f_name'];
			$myFile->nameseo = $row['f_nameseo'];
			$myFile->publictoken = $row['f_publictoken'];
			$myFile->summary = $row['f_summary'];
			$myFile->extension = $row['f_extension'];
			$myFile->filesize = $row['f_filesize'];
			$myFile->isdirectory = $row['f_isdirectory'];
			$myFile->type = $row['f_type'];
			$myFile->parentid = $row['f_parentid'];
			$myFile->isstarred = $row['f_isstarred'];
			$myFile->status = $row['f_status'];
			$myFile->permission = $row['f_permission'];
			$myFile->countview = $row['f_countview'];
			$myFile->countdownload = $row['f_countdownload'];
			$myFile->countchildren = $row['f_countchildren'];
			$myFile->uploadtype = $row['f_uploadtype'];
			$myFile->datecreated = $row['f_datecreated'];
			$myFile->datemodified = $row['f_datemodified'];
			$myFile->datelastdownloaded = $row['f_datelastdownloaded'];


            $outputList[] = $myFile;
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
	public static function getFiles($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.u_id = '.(int)$formData['fuid'].' ';

		if($formData['ffdid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.fd_id = '.(int)$formData['ffdid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fextension'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_extension = "'.Helper::unspecialtext((string)$formData['fextension']).'" ';

		if($formData['fisdirectory'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_isdirectory = '.(int)$formData['fisdirectory'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_type = '.(int)$formData['ftype'].' ';

		if(isset($formData['fparentid']) && $formData['fkeywordFilter'] == '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_parentid = '.(int)$formData['fparentid'].' ';

		if($formData['fisstarred'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_isstarred = '.(int)$formData['fisstarred'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_status = '.(int)$formData['fstatus'].' ';

		if($formData['fpermission'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_permission = '.(int)$formData['fpermission'].' ';

		if($formData['fcountview'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_countview = '.(int)$formData['fcountview'].' ';

		if($formData['fcountdownload'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_countdownload = '.(int)$formData['fcountdownload'].' ';

		if($formData['fcountchildren'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_countchildren = '.(int)$formData['fcountchildren'].' ';

		if(isset($formData['fuploadtype']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_uploadtype = '.(int)$formData['fuploadtype'].' ';

		if($formData['fdatelastdownloaded'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_datelastdownloaded = '.(int)$formData['fdatelastdownloaded'].' ';


		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'nameseo')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_nameseo LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (f.f_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (f.f_nameseo LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (f.f_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'f_id ' . $sorttype;
		elseif($sortby == 'filesize')
			$orderString = 'f_filesize ' . $sorttype;
		elseif($sortby == 'natural')
			$orderString = 'f_isdirectory DESC, f_nameseo ASC';
		else
			$orderString = 'f_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	public static function isExists($isdirectory, $name, $parentid, $userid)
	{
		return self::getFiles(array('fisdirectory' => 1, 'fname' => $name, 'fparentid' => $parentid, 'fuid' => $userid, 'fuploadtype' => self::UPLOADTYPE_NORMALUPLOAD), '', '', '', true) > 0;
	}

	public static function getFullParentDirectories($fileId)
	{
		global $registry;

		$db3 = self::getDb();

		$myFile = new Core_Backend_File($fileId);
		$output = array();

		$sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'file f
				WHERE f_isdirectory = 1 AND f_id = ?
				LIMIT 1';

		$directoryList = $db3->query($sql, array($myFile->parentid))->fetchAll();

		foreach($directoryList as $directory)
		{
			$myDirectory = new Core_Backend_File();
			$myDirectory->getDataFromArray($directory);

			$output[] = $myDirectory;
			$output = array_merge($output, self::getFullParentDirectories($myDirectory->id));
		}

		return $output;
	}

	public static function getFullChildren($parentid, $prefix, $idOnly = false)
	{
		$db3 = self::getDb();

		$output = array();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file f
				WHERE f_parentid = ?';
		$filelist = $db3->query($sql, array($parentid))->fetchAll();
		foreach($filelist as $file)
		{
			if($prefix != '')
				$name = $prefix . '\\' . $file['f_name'];
			else
				$name = $file['f_name'];


			if($file['f_isdirectory'] == 1)
			{
				$output = array_merge($output, self::getFullChildren($file['f_id'], $name, $idOnly));
			}

			if($idOnly)
				$output[] = $file['f_id'];
			else
				$output[] = array('id' => $file['f_id'], 'name' => $name, 'isdirectory' => $file['f_isdirectory']);

		}

		return $output;
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLESHARING] = 'Disable Sharing';

		return $output;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return ($name == 'enable' && $this->status == self::STATUS_ENABLE ||
				$name == 'disablesharing' && $this->status == self::STATUS_DISABLESHARING);
	}


	public static function markAsTrash($idList)
	{
		$db3 = self::getDb();

		if(is_array($idList) && count($idList) > 0)
		{
			//we need to splice array to smaller chunk to prevent mysql limit string in UPDATE query.
			//Now, just do it, does not need to chung ^^
			$sql = 'UPDATE ' . TABLE_PREFIX . 'file
					SET f_uploadtype = ?
					WHERE f_id IN ('.implode(',', $idList).')';
			$rowCount = $db3->query($sql, array(
				self::UPLOADTYPE_INTRASH
			))->rowCount();
		}
		else
			$rowCount = 0;

		return $rowCount;


	}

	public function generatePublicToken()
	{
		$s1 = $this->uid;
		$s2 = $this->name;
		$s3 = $this->datecreated;
		$s4 = time();
		$s5 = rand(0, 100000);

		return md5($s1 . ',' . $s2 . ',' . $s3 . ',' . $s4 . ',' . $s5);
	}

	public function getDownloadUrl()
	{
		global $registry;

		$url = $registry['conf']['rooturl_profile'] . 'file/download/id/' . $this->id . '/' . $this->nameseo;

		return $url;
	}

	public function getPublicUrl()
	{
		global $registry;

		$url = $registry['conf']['rooturl_profile'] . 'file/view/id/' . $this->id . '/t/' . $this->publictoken;

		return $url;
	}


	public function canDownload()
	{
		global $registry;

		return ($this->uploadtype != self::UPLOADTYPE_INTRASH && $this->uploadtype != self::UPLOADTYPE_DELETED &&
			($this->uid == $registry->me->id || $this->status == self::STATUS_ENABLE));
	}

	public function canPublic()
	{
		global $registry;

		return ($this->uploadtype != self::UPLOADTYPE_INTRASH && $this->uploadtype != self::UPLOADTYPE_DELETED && $this->status == self::STATUS_ENABLE);
	}


}