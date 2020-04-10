<?php

/**
 * core/class.programpositionstore.php
 *
 * File contains the class used for ProgramPositionStore Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProgramPositionStore extends Core_Object
{

	public $sid = 0;
	public $pid = 0;
	public $uid = 0;
	public $ppid = 0;
	public $ppsobject = null;
	public $ppobject = null;
	public $id = 0;
	public $image = "";
	public $imageobject = null;
	public $note = "";
	public $noteobject = null;
	public $isapprove = 0;
	public $approvenote = "";
	public $resourceserver = 0;
	public $updatedate = 0;
	public $uidapprove = 0;

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
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'program_position_store (
					s_id,
					p_id,
					u_id,
					pp_id,
					pps_image,
					pps_note,
					pps_isapprove,
					pps_approvenote,
					pps_updatedate,
					pps_resourceserver
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->sid,
					(int)$this->pid,
					(int)$this->uid,
					(int)$this->ppid,
					(string)$this->image,
					(string)$this->note,
					(int)$this->isapprove,
					(string)$this->approvenote,
					(int)$this->updatedate,
					(int)$this->resourceserver
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;
	}

	public function processMultiData($isedit = false){
		//neu upload theo dang multiple
		if(!empty($this->imageobject) && !empty($_FILES['fimageexecutearr']['name'])){
			//find the position of image
			foreach($this->imageobject as $poid=>$index){

				if(!empty($_FILES['fimageexecutearr']['name'][$index])){
					$ppid = $this->ppobject[$poid]['id'];
					$getprogramstore = Core_ProgramPositionStore::getProgramPositionStores(array('fsid' => $this->sid, 'fpid' => $this->pid, 'fppid' => $ppid), '', '', 1);
					if(!empty($getprogramstore[0])){
						$myProgramPostionStore = $getprogramstore[0];
						$imgpath = $myProgramPostionStore->uploadImage($_FILES['fimageexecutearr']['name'][$index],$_FILES['fimageexecutearr']['tmp_name'][$index]);
						if(!empty($imgpath)){
							if($isedit) $myProgramPostionStore->deleteImage();
							$myProgramPostionStore = new Core_ProgramPositionStore($myProgramPostionStore->id);
							$myProgramPostionStore->uid = $this->uid;
							$myProgramPostionStore->image = $imgpath;
							$myProgramPostionStore->note = $this->noteobject[$ppid];
							$myProgramPostionStore->updatedate = time();
							$myProgramPostionStore->updateData();
						}
					}
				}
			}
		}
		elseif(!empty($this->ppsobject)){
			foreach($this->ppsobject as $pps){//vi 1 sieu thi co nhieu program positionn store
				if(!empty($_FILES['fimagepos']['name'][$pps->ppid])){
					$oneprogrampoststore = new Core_ProgramPositionStore($pps->id);
					if($oneprogrampoststore->id > 0 && $oneprogrampoststore->isapprove != 1){
						$imgpath = $oneprogrampoststore->uploadImage($_FILES['fimagepos']['name'][$pps->ppid],$_FILES['fimagepos']['tmp_name'][$pps->ppid]);
						if(!empty($imgpath)){
							if($isedit) $oneprogrampoststore->deleteImage();
							$oneprogrampoststore->image = $imgpath;
							$oneprogrampoststore->uid = $this->uid;
							$oneprogrampoststore->note = $this->noteobject[$pps->ppid];
							$oneprogrampoststore->updatedate = time();
							$oneprogrampoststore->updateData();
						}
					}
				}
			}
		}
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{
		//$this->updatedate = time();
		$sql = 'UPDATE ' . TABLE_PREFIX . 'program_position_store
				SET s_id = ?,
					p_id = ?,
					u_id = ?,
					u_id_approve = ?,
					pp_id = ?,
					pps_image = ?,
					pps_note = ?,
					pps_isapprove = ?,
					pps_approvenote = ?,
					pps_updatedate = ?,
					pps_resourceserver = ?
				WHERE pps_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->sid,
					(int)$this->pid,
					(int)$this->uid,
					(int)$this->uidapprove,
					(int)$this->ppid,
					(string)$this->image,
					(string)$this->note,
					(int)$this->isapprove,
					(string)$this->approvenote,
					(int)$this->updatedate,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'program_position_store pps
				WHERE pps.pps_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->sid = $row['s_id'];
		$this->pid = $row['p_id'];
		$this->uid = $row['u_id'];
		$this->uidapprove = $row['u_id_approve'];
		$this->ppid = $row['pp_id'];
		$this->id = $row['pps_id'];
		$this->image = $row['pps_image'];
		$this->note = $row['pps_note'];
		$this->isapprove = $row['pps_isapprove'];
		$this->approvenote = $row['pps_approvenote'];
		$this->updatedate = $row['pps_updatedate'];
		$this->resourceserver = $row['pps_resourceserver'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$myProgramPositionStore = new Core_ProgramPositionStore($this->id);
		if($myProgramPositionStore->id > 0)
			$myProgramPositionStore->deleteImage();

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'program_position_store
				WHERE pps_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'program_position_store pps';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'program_position_store pps';

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
			$myProgramPositionStore = new Core_ProgramPositionStore();

			$myProgramPositionStore->sid = $row['s_id'];
			$myProgramPositionStore->pid = $row['p_id'];
			$myProgramPositionStore->uid = $row['u_id'];
			$myProgramPositionStore->uidapprove = $row['u_id_approve'];
			$myProgramPositionStore->ppid = $row['pp_id'];
			$myProgramPositionStore->id = $row['pps_id'];
			$myProgramPositionStore->image = $row['pps_image'];
			$myProgramPositionStore->note = $row['pps_note'];
			$myProgramPositionStore->isapprove = $row['pps_isapprove'];
			$myProgramPositionStore->approvenote = $row['pps_approvenote'];
			$myProgramPositionStore->updatedate = $row['pps_updatedate'];
			$myProgramPositionStore->resourceserver = $row['pps_resourceserver'];


            $outputList[] = $myProgramPositionStore;
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
	public static function getProgramPositionStores($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pps.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fsidstr'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pps.s_id IN ('.(string)$formData['fsidstr'].') ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pps.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pps.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fppid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pps.pp_id = '.(int)$formData['fppid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pps.pps_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pps_id ' . $sorttype;
		else
			$orderString = 'pps_id ' . $sorttype;

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
		$sql = 'UPDATE ' . TABLE_PREFIX . 'program_position_store
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