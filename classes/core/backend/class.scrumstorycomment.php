<?php

/**
 * core/backend/class.scrumstorycomment.php
 *
 * File contains the class used for ScrumStoryComment Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_ScrumStoryComment extends Core_Backend_Object
{

	public $uid = 0;
	public $ssid = 0;
	public $id = 0;
	public $content = "";
	public $filepath = "";
	public $ipaddress = 0;
	public $datecreate = 0;
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
	public function upload($id,$filepath)
	{
		 if($id > 0)
			{
				if(strlen($filepath['datafile']['name']) > 0)
				{
					//upload image
					$uploadImageResult = $this->uploadImage();

					if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
						return false;
					elseif($this->filepath != '')
					{
						//update source
						$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story_comment
								SET ssc_filepath = ?
								WHERE ssc_id = ?';
						$result = $this->db3->query($sql, array($this->filepath, $this->id));
						if(!$result)
							return false;
						else
						{
							$rs=$uploadImageResult;
							return $rs;
						}


					}
				}
			}

	}
	public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['datafile']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($registry->me->fullname, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['datafile']['tmp_name'], $name, $registry->setting['scrumstorycomment']['imageDirectory'] . $curDateDir, '');
        $uploader->validType = empty($validType)?array('DOC', 'DOCX', 'XLS', 'XLSX', 'PDF', 'ZIP', 'RAR', 'TXT', 'JPG', 'PNG', 'PPT', 'PPTX', 'RTF'):$validType;

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //update database
            $this->filepath = $curDateDir . $name;
            return $registry->setting['scrumstorycomment']['imageDirectory'] . $curDateDir.$name;
        }
    }
	public function addData()
	{
		$this->datecreate = time();
		$this->ipaddress = Helper::getIpAddress();
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_story_comment (
					u_id,
					ss_id,
					ssc_content,
					ssc_filepath,
					ssc_ipaddress,
					ssc_datecreate,
					ssc_datemodified
					)
				VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->ssid,
					(string)$this->content,
					(string)$this->filepath,
					(int)$this->ipaddress,
					(int)$this->datecreate,
					(int)$this->datemodified
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
		$this->ipaddress = Helper::getIpAddress();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story_comment
				SET u_id = ?,
					ss_id = ?,
					ssc_content = ?,
					ssc_filepath = ?,
					ssc_ipaddress = ?,
					ssc_datecreate = ?,
					ssc_datemodified = ?
				WHERE ssc_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->ssid,
					(string)$this->content,
					(string)$this->filepath,
					(int)$this->ipaddress,
					(int)$this->datecreate,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story_comment ssc
				WHERE ssc.ssc_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->ssid = $row['ss_id'];
		$this->id = $row['ssc_id'];
		$this->content = $row['ssc_content'];
		$this->filepath = $row['ssc_filepath'];
		$this->ipaddress = $row['ssc_ipaddress'];
		$this->datecreate = $row['ssc_datecreate'];
		$this->datemodified = $row['ssc_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story_comment
				WHERE ssc_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
	public static function deleteByStoryDelete($id)
	{
        $db3 = self::getDb();
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story_comment
				WHERE ss_id = ?';
		$rowCount = $db3->query($sql, array($id))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_story_comment ssc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story_comment ssc';

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
			$myScrumStoryComment = new Core_Backend_ScrumStoryComment();

			$myScrumStoryComment->uid = $row['u_id'];
			$myScrumStoryComment->ssid = $row['ss_id'];
			$myScrumStoryComment->id = $row['ssc_id'];
			$myScrumStoryComment->content = $row['ssc_content'];
			$myScrumStoryComment->filepath = $row['ssc_filepath'];
			$myScrumStoryComment->ipaddress = $row['ssc_ipaddress'];
			$myScrumStoryComment->datecreate = $row['ssc_datecreate'];
			$myScrumStoryComment->datemodified = $row['ssc_datemodified'];


			$outputList[] = $myScrumStoryComment;
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
	public static function getScrumStoryComments($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fssid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ss_id = '.(int)$formData['fssid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_id = '.(int)$formData['fid'].' ';

		if($formData['fcontent'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_content = "'.Helper::unspecialtext((string)$formData['fcontent']).'" ';

		if($formData['ffilepath'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_filepath = "'.Helper::unspecialtext((string)$formData['ffilepath']).'" ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_ipaddress = '.(int)$formData['fipaddress'].' ';

		if($formData['fdatecreate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_datecreate = '.(int)$formData['fdatecreate'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_datemodified = '.(int)$formData['fdatemodified'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'content')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'filepath')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_filepath LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ssc.ssc_content LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ssc.ssc_filepath LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'ssid')
			$orderString = 'ss_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ssc_id ' . $sorttype;
		elseif($sortby == 'content')
			$orderString = 'ssc_content ' . $sorttype;
		elseif($sortby == 'filepath')
			$orderString = 'ssc_filepath ' . $sorttype;
		elseif($sortby == 'ipaddress')
			$orderString = 'ssc_ipaddress ' . $sorttype;
		elseif($sortby == 'datecreate')
			$orderString = 'ssc_datecreate ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ssc_datemodified ' . $sorttype;
		else
			$orderString = 'ssc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}