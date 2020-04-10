<?php

/**
 * core/class.programposition.php
 *
 * File contains the class used for ProgramPosition Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProgramPosition extends Core_Object
{

	public $poid = 0;
	public $pid = 0;
	public $id = 0;
	public $image = "";
	public $noteguide = "";
	public $resourceserver = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'program_position (
					po_id,
					p_id,
					pp_image,
					pp_noteguide,
					pp_resourceserver
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->poid,
					(int)$this->pid,
					(string)$this->image,
					(string)$this->noteguide,
					(int)$this->resourceserver
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'program_position
				SET po_id = ?,
					p_id = ?,
					pp_image = ?,
					pp_noteguide = ?,
					pp_resourceserver = ?
				WHERE pp_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->poid,
					(int)$this->pid,
					(string)$this->image,
					(string)$this->noteguide,
					(int)$this->resourceserver,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'program_position pp
				WHERE pp.pp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->poid = $row['po_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['pp_id'];
		$this->image = $row['pp_image'];
		$this->noteguide = $row['pp_noteguide'];
		$this->resourceserver = $row['pp_resourceserver'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$myProgramPosition = new Core_ProgramPosition($this->id);
		if($myProgramPosition->id > 0)
			$myProgramPosition->deleteImage();

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'program_position
				WHERE pp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'program_position pp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'program_position pp';

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
			$myProgramPosition = new Core_ProgramPosition();

			$myProgramPosition->poid = $row['po_id'];
			$myProgramPosition->pid = $row['p_id'];
			$myProgramPosition->id = $row['pp_id'];
			$myProgramPosition->image = $row['pp_image'];
			$myProgramPosition->noteguide = $row['pp_noteguide'];
			$myProgramPosition->resourceserver = $row['pp_resourceserver'];


            $outputList[] = $myProgramPosition;
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
	public static function getProgramPositions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.po_id = '.(int)$formData['fpoid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.pp_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pp_id ' . $sorttype;
		elseif($sortby == 'poid')
			$orderString = 'po_id ' . $sorttype;
		else
			$orderString = 'pp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	//Ham upload anh
    public function uploadImage($fname, $temp)
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($fname,'.'),1);
        $namePart =  Helper::codau2khongdau($fname, true) . '-' . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($temp, $name, $registry->setting['posm']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return false;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['posm']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['posm']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['posm']['imageMaxWidth'],
                                                $registry->setting['posm']['imageMaxHeight'],
                                                '',
                                                $registry->setting['posm']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

			//Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['posm']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['posm']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['posm']['imageThumbWidth'],
                                                $registry->setting['posm']['imageThumbHeight'],
                                                '',
                                                $registry->setting['posm']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);


            //update database
            return $curDateDir . $name;
        }
    }

    public function updateImage()
    {
		$sql = 'UPDATE ' . TABLE_PREFIX . 'program_position
                SET pp_image = ?,
					pp_resourceserver = ?
                WHERE pp_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->resourceserver,
                (int)$this->id
            ));

        //Xu ly anh
        if($stmt)
        	return true;
		else
			return false;
    }

    public function getimage()
	{
		global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'posm/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['posm']['imageDirectory'] . $this->image;
		}
		return $url;
	}

	public function getSmallimage()
	{
		global $registry;

		$pos = strrpos($this->image, '.');
		$extPart = substr($this->image, $pos+1);
		$namePart =  substr($this->image,0, $pos);
		$filesmall = $namePart . '-small.' . $extPart;


		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'posm/' . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['posm']['imageDirectory'] . $filesmall;
		}
		return $url;
	}

	public function deleteImage($imagepath = '')
    {
        global $registry;

        //delete current image
        if($imagepath == '')
            $deletefile = $this->image;
		else
            $deletefile = $imagepath;

        if(strlen($deletefile) > 0)
        {
            $file = $registry->setting['posm']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
	            $pos = strrpos($deletefile, '.');
				$extPart = substr($deletefile, $pos+1);
				$namePart =  substr($deletefile,0, $pos);

				$deletesmallimage = $namePart . '-small.' . $extPart;
				$file = $registry->setting['posm']['imageDirectory'] . $deletesmallimage;
	            if(file_exists($file) && is_file($file))
	                @unlink($file);

				$deletemediumimage = $namePart . '-medium.' . $extPart;
				$file = $registry->setting['posm']['imageDirectory'] . $deletemediumimage;
	            if(file_exists($file) && is_file($file))
	                @unlink($file);
			}

            //delete current image
            if($imagepath == '')
                $this->image = '';
        }
    }


}