<?php

/**
 * core/class.crazydeal.php
 *
 * File contains the class used for Crazydeal Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Crazydeal extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;
	const STATUS_EXPIRED = 3;

	const OS_NOSELL = 0;
    const OS_ERP_PREPAID = 2;
    const OS_DM_PREPAID = 4;
    const OS_ERP = 6;
    const OS_DM = 8;
    const OS_COMMINGSOON = 10;
    const OS_NEWARRIVAL = 12;
    const OS_CLEARSTOCK = 14;
    const OS_SHOWROOM = 16;
    const OS_ONLINEONY = 18;
    const OS_HOT = 20;
    const OS_NEW = 22;
    const OS_BESTSELLER = 24;
    const OS_CRAZYSALE = 26;

	public $uid = 0;
	public $pid = 0;
	public $pcid = 0;
	public $id = 0;
	public $name = "";
	public $image = "";
	public $description = "";
	public $starttime = 0;
	public $expiretime = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $resourceserver = 0;
	public $oldonsitestatus = 0;
    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}
      //Ham upload anh
    //Da kiem tra co anh roi!!!
    public function uploadImage()
    {
        global $registry;


        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . '-' . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['crazydeal']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {

            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['crazydeal']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['crazydeal']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['crazydeal']['imageMaxWidth'],
                                                $registry->setting['crazydeal']['imageMaxHeight'],
                                                '',
                                                $registry->setting['crazydeal']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

			//Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer( $registry->setting['crazydeal']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['crazydeal']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['crazydeal']['imageThumbWidth'],
                                                $registry->setting['crazydeal']['imageThumbHeight'],
                                                '',
                                                $registry->setting['crazydeal']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //update database
            $this->image = $curDateDir . $name;

			//reset resource server
			$this->resourceserver = 0;
        }
    }
	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'crazydeal (
					u_id,
					p_id,
					cd_name,
					cd_image,
					cd_description,
					cd_starttime,
					cd_expiretime,
					cd_resourceserver,
					cd_oldonsitestatus,
					cd_status,
					cd_datecreated,
					cd_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->name,
					(string)$this->image,
					(string)$this->description,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->resourceserver,
					(int)$this->oldonsitestatus,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'crazydeal
                            SET cd_image = ?,
                            	cd_resourceserver = 0
                            WHERE cd_id = ?';
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'crazydeal
				SET u_id = ?,
					p_id = ?,
					cd_name = ?,
					cd_image = ?,
					cd_description = ?,
					cd_starttime = ?,
					cd_expiretime = ?,
					cd_resourceserver = ?,
					cd_oldonsitestatus = ?,
					cd_status = ?,
					cd_datecreated = ?,
					cd_datemodified = ?
				WHERE cd_id = ?';
		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->name,
					(string)$this->image,
					(string)$this->description,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->resourceserver,
					(int)$this->oldonsitestatus,
					(int)$this->status,
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'crazydeal
                            SET cd_image = ?,
                            	cd_resourceserver = 0
                            WHERE cd_id = ?';
                    $result=$this->db->query($sql, array($this->image, $this->id));
                    if(!$result)
                    	return false;
                    else
                    	return true;
                }
            }
            else
            {
            	return true;
            }
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'crazydeal cd
				WHERE cd.cd_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['cd_id'];
		$this->name = $row['cd_name'];
		$this->image = $row['cd_image'];
		$this->description = $row['cd_description'];
		$this->starttime = $row['cd_starttime'];
		$this->expiretime = $row['cd_expiretime'];
		$this->resourceserver = $row['cd_resourceserver'];
		$this->oldonsitestatus = $row['cd_oldonsitestatus'];
		$this->status = $row['cd_status'];
		$this->datecreated = $row['cd_datecreated'];
		$this->datemodified = $row['cd_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'crazydeal
				WHERE cd_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'crazydeal cd';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'crazydeal cd';

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
			$myCrazydeal = new Core_Crazydeal();

			$myCrazydeal->uid = $row['u_id'];
			$myCrazydeal->pid = $row['p_id'];
			$myCrazydeal->id = $row['cd_id'];
			$myCrazydeal->name = $row['cd_name'];
			$myCrazydeal->image = $row['cd_image'];
			$myCrazydeal->description = $row['cd_description'];
			$myCrazydeal->starttime = $row['cd_starttime'];
			$myCrazydeal->expiretime = $row['cd_expiretime'];
			$myCrazydeal->resourceserver = $row['cd_resourceserver'];
			$myCrazydeal->oldonsitestatus = $row['cd_oldonsitestatus'];
			$myCrazydeal->status = $row['cd_status'];
			$myCrazydeal->datecreated = $row['cd_datecreated'];
			$myCrazydeal->datemodified = $row['cd_datemodified'];


            $outputList[] = $myCrazydeal;
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
	public static function getCrazydeals($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cd.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cd.cd_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cd.cd_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cd.cd_status = '.(int)$formData['fstatus'].' ';

		if(isset($formData['fisactive']) && $formData['fisactive'] == 1)
        {
            $wheredate = ($whereString != '' ? ' AND ' : '');
            $wheredate .= '((cd.cd_status = '.(int)Core_Crazydeal::STATUS_ENABLE.'
                           AND cd.cd_starttime <= '.(int)time().'
                           AND cd.cd_expiretime >= '.(int)time().'
                          ) OR (
                           cd.cd_starttime = 0
                           AND cd.cd_expiretime >= '.(int)time().'
                          ) OR (
                           cd.cd_starttime <= '.(int)time().'
                           AND cd.cd_expiretime = 0
                          ) OR (
                            cd.cd_starttime = 0
                            AND cd.cd_expiretime = 0
                          ) )';
            $whereString .= $wheredate;
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'cd_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'cd_name ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'cd_status ' . $sorttype;
		else
			$orderString = 'cd_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disabled';
		//$output[self::STATUS_EXPIRED] = 'Expired';

		return $output;
	}
   	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return ($name == 'enable' && $this->status == self::STATUS_ENABLE ||
			$name = 'disable' && $this->status == self::STATUS_DISABLE ||
			$name = 'expired' && $this->status == self::STATUS_EXPIRED
		);

	}
	public function getstatusName()
	{
        $name = '';
        switch($this->status)
        {
            case self::STATUS_ENABLE : $name = 'enable'; break;
            case self::STATUS_DISABLE : $name = 'disable'; break;
            case self::STATUS_EXPIRED : $name = 'expired'; break;
        }

        return $name;
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
			$url = ResourceServer::getUrl($this->resourceserver, 'crazydeal') . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['crazydeal']['imageDirectory'] . $filesmall;
		}

		return $url;
	}

	public function getProductPathByPid()
    {
    	global $registry;
    	$productPath = $registry['conf']['rooturl'];
        //if($productPath) $productPath .= 'product/detail/?pcid='.$this->pcid.'&pid='.$this->id;
    	$product = new Core_Product($this->pid);
    	if(strlen($product->slug) > 0)
    	{
    		$myProductCategory = $this->getCategoryByProductID($this->pid);
    		$productPath .= $myProductCategory['pc_slug'] . '/' . $product->slug;

    	}
    	else
    	{
    		if($productPath) $productPath .= 'product/detail/?pcid='.$myProductCategory['pc_id'].'&pid='.$this->pid;
    	}

    	return $productPath;
    }
    public function getCategoryByProductID($pid =0)
    {

        if($pid > 0)
        {
            $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'product WHERE p_id = ' . $pid;
            $row = $this->db->query($sql)->fetch();
            $output = Core_Productcategory::getFullParentProductCategorys((int)$row['pc_id']);

            //lay thong tin cua category hien tai
            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_id = ' . (int)$row['pc_id'];
            $rows = $this->db->query($sql)->fetch();
            if(!empty($rows))
            {
                $pc = new Core_Productcategory();
                $rows['fullpath'] = $pc->getProductcateoryPath($rows['pc_id']);

            }
            $output = $rows;
            //echodebug($output);
            return $output;
        }
    }

	public function getImage()
	{
		global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'crazydeal/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['crazydeal']['imageDirectory'] . $this->image;
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
			$coverpath = $registry->setting['crazydeal']['imageDirectory'] . $this->image;
		}

		$sql = 'UPDATE ' . TABLE_PREFIX . 'crazydeal
                SET cd_image = ?,
                	  cd_resourceserver = 0
                WHERE cd_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->id
            ));
        return $stmt;
    }

}