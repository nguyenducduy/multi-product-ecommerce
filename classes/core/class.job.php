<?php

/**
 * core/class.job.php
 *
 * File contains the class used for Job Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Job extends Core_Object
{
	const STATUS_ENABLE = 1;
   	const STATUS_DISABLED = 2;

	public $uid = 0;
	public $id = 0;
	public $jcid = 0;
	public $image = "";
	public $title = "";
	public $slug = "";
	public $content = "";
	public $source = "";
	public $seotitle = "";
	public $seokeyword = "";
	public $seodescription = "";
	public $metarobot = "";
	public $countview = 0;
	public $countreview = 0;
	public $displayorder = 0;
	public $status = 0;
	public $ipaddress = 0;
	public $resourceserver = 0;
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
		$this->ipaddress = Helper::getIpAddress(true);

       	$this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'job (
					u_id,
					j_image,
					jc_id,
					j_title,
					j_slug,
					j_content,
					j_source,
					j_seotitle,
					j_seokeyword,
					j_seodescription,
					j_metarobot,
					j_countview,
					j_countreview,
					j_displayorder,
					j_status,
					j_ipaddress,
					j_resourceserver,
					j_datecreated,
					j_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->image,
					(int)$this->jcid,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->source,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->ipaddress,
					(int)$this->resourceserver,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();

		//update image data
    	if($this->id > 0)
    	{
        	if(strlen($_FILES['fimage']['name']) > 0)
        	{
       			//upload image
            	$uploadImageResult = $this->uploadImage();

	           	if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
	                	return false;
	           	elseif($this->image != '')
	           	{
	                	//update source
	                	$sql = 'UPDATE ' . TABLE_PREFIX . 'job
	                        SET j_image = ?,
	                        	j_resourceserver = 0
	                        WHERE j_id = ?';

	                	$result=$this->db->query($sql, array($this->image, $this->id));
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'job
				SET u_id = ?,
					j_image = ?,
					jc_id = ?,
					j_title = ?,
					j_slug = ?,
					j_content = ?,
					j_source = ?,
					j_seotitle = ?,
					j_seokeyword = ?,
					j_seodescription = ?,
					j_metarobot = ?,
					j_countview = ?,
					j_countreview = ?,
					j_displayorder = ?,
					j_status = ?,
					j_ipaddress = ?,
					j_resourceserver = ?,
					j_datecreated = ?,
					j_datemodified = ?
				WHERE j_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->image,
					(int)$this->jcid,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->source,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->ipaddress,
					(int)$this->resourceserver,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
        	{
            	if(strlen($_FILES['fimage']['name']) > 0)
            	{
	               //upload image
	               $uploadImageResult = $this->uploadImage();

	               if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
	                    return false;
	               elseif($this->image != '')
	               {
	                    //update source
	                    $sql = 'UPDATE ' . TABLE_PREFIX . 'job
	                            SET j_image = ?,
	                            	j_resourceserver = 0
	                            WHERE j_id = ?';

	                    $result=$this->db->query($sql, array($this->image, $this->id));
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'job j
				WHERE j.j_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['j_id'];
		$this->image = $row['j_image'];
		$this->jcid = $row['jc_id'];
		$this->title = $row['j_title'];
		$this->slug = $row['j_slug'];
		$this->content = $row['j_content'];
		$this->source = $row['j_source'];
		$this->seotitle = $row['j_seotitle'];
		$this->seokeyword = $row['j_seokeyword'];
		$this->seodescription = $row['j_seodescription'];
		$this->metarobot = $row['j_metarobot'];
		$this->countview = $row['j_countview'];
		$this->countreview = $row['j_countreview'];
		$this->displayorder = $row['j_displayorder'];
		$this->status = $row['j_status'];
		$this->ipaddress = $row['j_ipaddress'];
		$this->resourceserver = $row['j_resourceserver'];
		$this->datecreated = $row['j_datecreated'];
		$this->datemodified = $row['j_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'job
				WHERE j_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'job j';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'job j';

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
			$myJob = new Core_Job();

			$myJob->uid = $row['u_id'];
			$myJob->id = $row['j_id'];
			$myJob->image = $row['j_image'];
			$myJob->jcid = $row['jc_id'];
			$myJob->title = $row['j_title'];
			$myJob->slug = $row['j_slug'];
			$myJob->content = $row['j_content'];
			$myJob->source = $row['j_source'];
			$myJob->seotitle = $row['j_seotitle'];
			$myJob->seokeyword = $row['j_seokeyword'];
			$myJob->seodescription = $row['j_seodescription'];
			$myJob->metarobot = $row['j_metarobot'];
			$myJob->countview = $row['j_countview'];
			$myJob->countreview = $row['j_countreview'];
			$myJob->displayorder = $row['j_displayorder'];
			$myJob->status = $row['j_status'];
			$myJob->ipaddress = $row['j_ipaddress'];
			$myJob->resourceserver = $row['j_resourceserver'];
			$myJob->datecreated = $row['j_datecreated'];
			$myJob->datemodified = $row['j_datemodified'];


            $outputList[] = $myJob;
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
	public static function getJobs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_id = '.(int)$formData['fid'].' ';

		if($formData['fjcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_id = '.(int)$formData['fjcid'].' ';

		if($formData['fslug'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';

		if($formData['fsource'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_source = "'.Helper::unspecialtext((string)$formData['fsource']).'" ';

		if($formData['fcountview'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_countview = '.(int)$formData['fcountview'].' ';

		if($formData['fcountreview'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_countreview = '.(int)$formData['fcountreview'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_status = '.(int)$formData['fstatus'].' ';

		if($formData['fresourceserver'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_datecreated = '.(int)$formData['fdatecreated'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'title')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'content')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.j_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (j.j_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (j.j_content LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'j_id ' . $sorttype;
		elseif($sortby == 'source')
			$orderString = 'j_source ' . $sorttype;
		elseif($sortby == 'countview')
			$orderString = 'j_countview ' . $sorttype;
		elseif($sortby == 'countreview')
			$orderString = 'j_countreview ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'j_status ' . $sorttype;
		elseif($sortby == 'resourceserver')
			$orderString = 'j_resourceserver ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'j_datecreated ' . $sorttype;
		else
			$orderString = 'j_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(j_displayorder) FROM ' . TABLE_PREFIX . 'job';
        return (int)$this->db->query($sql)->fetchColumn(0);
    }

    public static function getStatusList()
    {
        $output = array();

        $output[self::STATUS_ENABLE] = 'Enable';
        $output[self::STATUS_DISABLED] = 'Disabled';

        return $output;
    }

    public function getStatusName()
    {
        $name = '';

        switch($this->status)
        {
            case self::STATUS_ENABLE: $name = 'Enable'; break;
            case self::STATUS_DISABLED: $name = 'Disabled'; break;
        }

        return $name;
    }

    public function checkStatusName($name)
    {
        $name = strtolower($name);

        if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
            return true;
        else
            return false;
    }

    public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->title, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['job']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['job']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['job']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['job']['imageMaxWidth'],
                                                $registry->setting['job']['imageMaxHeight'],
                                                '',
                                                $registry->setting['job']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['job']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['job']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['job']['imageThumbWidth'],
                                                $registry->setting['job']['imageThumbHeight'],
                                                $registry->setting['job']['imageThumbRatio'],
                                                $registry->setting['job']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //update database
            $this->image = $curDateDir . $name;
        }
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
            $file = $registry->setting['job']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
                $pos = strrpos($deletefile, '.');
                $extPart = substr($deletefile, $pos+1);
                $namePart =  substr($deletefile,0, $pos);

                $deletesmallimage = $namePart . '-small.' . $extPart;
                $file = $registry->setting['job']['imageDirectory'] . $deletesmallimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);

                $deletemediumimage = $namePart . '-medium.' . $extPart;
                $file = $registry->setting['job']['imageDirectory'] . $deletemediumimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);
            }

            //delete current image
            if($imagepath == '')
                $this->image = '';
        }
    }


    public function getSmallImage()
    {
        global $registry;

        $pos = strrpos($this->image, '.');
        $extPart = substr($this->image, $pos+1);
        $namePart =  substr($this->image,0, $pos);
        $filesmall = $namePart . '-small.' . $extPart;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'job/' . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['job']['imageDirectory'] . $filesmall;
		}


        return $url;
    }


    public function getImage()
    {
        global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'job/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['job']['imageDirectory'] . $this->image;
		}

        return $url;
    }

    public function updateImage()
    {
		global $registry;

		//get the ratio between width and height
		//read image information
		if($this->image != '')
		{
			$coverpath = $registry->setting['job']['imageDirectory'] . $this->image;
		}

		$sql = 'UPDATE ' . TABLE_PREFIX . 'job
                SET j_image = ?
                WHERE j_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->id
            ));

        return $stmt;
    }

    public function getJobPath()
    {
    	global $registry;

    	$path = $registry->conf['rooturl'];

    	if($this->id > 0)
    	{
    		if($this->slug != '')
    		{
    			$path .= $this->slug;
    		}
    		else
    		{
    			$path .= 'tuyendung/detail?id=' . $this->id;
    		}
    	}

    	return $path;
    }

    public function getJobcategoryPath()
    {
    	global $registry;

    	$path = $registry->conf['rooturl'];

    	if($this->jcid > 0)
    	{
    		if($this->slug != '')
    		{
    			$path .= $this->slug;
    		}
    		else
    		{
    			$path .= 'job/index?c=' . $this->jcid;
    		}
    	}

    	return $path;
    }

    public function getcategoryname()
    {
    	$myCategory = new Core_Jobcategory($this->jcid);

    	return $myCategory->name;
    }

}
