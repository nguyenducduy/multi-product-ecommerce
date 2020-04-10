<?php

/**
 * core/backend/class.feedback.php
 *
 * File contains the class used for Feedback Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_Feedback extends Core_Backend_Object
{
	const STATUS_NEW = 1;
    const STATUS_ACCEPT = 2;
    const STATUS_ONPROGRESS = 3;
    const STATUS_COMPLETED = 4;

	public $uid = 0;
	public $id = 0;
	public $asa = "";
	public $iwant = "";
	public $sothat = "";
	public $section = 0;
	public $status = 0;
	public $scrumstoryid = 0;
	public $filepath = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'feedback (
					u_id,
					f_asa,
					f_iwant,
					f_sothat,
					f_section,
					f_status,
					f_scrumstoryid,
					f_filepath,
					f_datecreated,
					f_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->asa,
					(string)$this->iwant,
					(string)$this->sothat,
					(int)$this->section,
					(int)$this->status,
					(int)$this->scrumstoryid,
					(string)$this->filepath,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db3->lastInsertId();

		//update image data
        if($this->id > 0)
        {
            if(strlen($_FILES['ffilepath']['name']) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->filepath != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'feedback
                            SET f_filepath = ?
                            WHERE f_id = ?';
                    $result=$this->db3->query($sql, array($this->filepath, $this->id));
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'feedback
				SET u_id = ?,
					f_asa = ?,
					f_iwant = ?,
					f_sothat = ?,
					f_section = ?,
					f_status = ?,
					f_scrumstoryid = ?,
					f_filepath = ?,
					f_datecreated = ?,
					f_datemodified = ?
				WHERE f_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->asa,
					(string)$this->iwant,
					(string)$this->sothat,
					(int)$this->section,
					(int)$this->status,
					(int)$this->scrumstoryid,
					(string)$this->filepath,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
		{
			if(strlen($_FILES['ffilepath']['name']) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->filepath != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'feedback
                            SET f_filepath = ?
                            WHERE f_id = ?';
                    $result=$this->db3->query($sql, array($this->filepath, $this->id));
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'feedback f
				WHERE f.f_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['f_id'];
		$this->asa = $row['f_asa'];
		$this->iwant = $row['f_iwant'];
		$this->sothat = $row['f_sothat'];
		$this->section = $row['f_section'];
		$this->status = $row['f_status'];
		$this->scrumstoryid = $row['f_scrumstoryid'];
		$this->filepath = $row['f_filepath'];
		$this->datecreated = $row['f_datecreated'];
		$this->datemodified = $row['f_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feedback
				WHERE f_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'feedback f';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'feedback f';

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
			$myFeedback = new Core_Backend_Feedback();

			$myFeedback->uid = $row['u_id'];
			$myFeedback->id = $row['f_id'];
			$myFeedback->asa = $row['f_asa'];
			$myFeedback->iwant = $row['f_iwant'];
			$myFeedback->sothat = $row['f_sothat'];
			$myFeedback->section = $row['f_section'];
			$myFeedback->status = $row['f_status'];
			$myFeedback->scrumstoryid = $row['f_scrumstoryid'];
			$myFeedback->filepath = $row['f_filepath'];
			$myFeedback->datecreated = $row['f_datecreated'];
			$myFeedback->datemodified = $row['f_datemodified'];


            $outputList[] = $myFeedback;
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
	public static function getFeedbacks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_id = '.(int)$formData['fid'].' ';

		if($formData['fasa'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_asa = "'.Helper::unspecialtext((string)$formData['fasa']).'" ';

		if($formData['fsection'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_section = '.(int)$formData['fsection'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_status = '.(int)$formData['fstatus'].' ';

		if($formData['fscrumstoryid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_scrumstoryid = '.(int)$formData['fscrumstoryid'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_datecreated = '.(int)$formData['fdatecreated'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'asa')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_asa LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'iwant')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_iwant LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'sothat')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_sothat LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'filepath')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_filepath LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (f.f_asa LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (f.f_iwant LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (f.f_sothat LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (f.f_filepath LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'f_id ' . $sorttype;
		elseif($sortby == 'section')
			$orderString = 'f_section ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'f_status ' . $sorttype;
		elseif($sortby == 'scrumstoryid')
			$orderString = 'f_scrumstoryid ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'f_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'f_datemodified ' . $sorttype;
		else
			$orderString = 'f_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
    {
        $output = array();

        $output[self::STATUS_NEW] = 'New';
        $output[self::STATUS_ACCEPT] = 'Accept';
        $output[self::STATUS_ONPROGRESS] = 'On progress';
        $output[self::STATUS_COMPLETED] = 'Completed';

        return $output;
    }

    public function getStatusName()
    {
        $name = '';

        switch($this->status)
        {
            case self::STATUS_NEW: $name = 'New'; break;
            case self::STATUS_ACCEPT: $name = 'Accept'; break;
            case self::STATUS_ONPROGRESS: $name = 'On progress'; break;
            case self::STATUS_COMPLETED: $name = 'Completed'; break;
        }

        return $name;
    }

    public function checkStatusName($name)
    {
        $name = strtolower($name);

        if($this->status == self::STATUS_NEW && $name == 'new' || $this->status == self::STATUS_ACCEPT && $name == 'accept' || $this->status == self::STATUS_ONPROGRESS && $name == 'onprogress' || $this->status == self::STATUS_COMPLETED && $name == 'completed')
            return true;
        else
            return false;
    }

    public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['ffilepath']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->asa, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['ffilepath']['tmp_name'], $name, $registry->setting['feedback']['imageDirectory'] . $curDateDir, '');
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
        }
    }

    public function getFeedbacksectionName($sectionid)
    {
    	$name = '';

    	$mySection = new Core_Backend_Feedbacksection($sectionid);

    	$name = $mySection->name;

    	return $name;
    }


}