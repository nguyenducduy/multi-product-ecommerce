<?php

/**
 * core/class.storet.php
 *
 * File contains the class used for Storet Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Storet extends Core_Object
{
	const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

	public $id = 0;
	public $name = "";
	public $aid = 0;
	public $companyid = 0;
	public $storegroupid = 0;
	public $storetypeid = 0;
	public $poareaid = 0;
	public $hoststoreid = 0;
	public $ppaid = 0;
	public $storeshortname = "";
	public $storeaddress = "";
	public $storemanager = 0;
	public $storephonenum = "";
	public $storefax = "";
	public $storecode = "";
	public $taxcode = "";
	public $taxaddress = "";
	public $companynameprefix = "";
	public $companytitle = "";
	public $poreceiveaddress = "";
	public $iscenterstore = 0;
	public $isrealstore = 0;
	public $issalestore = 0;
	public $isinputstore = 0;
	public $iswarrantystore = 0;
	public $isautostorechange = 0;
	public $isauxiliarystore = 0;
	public $isactive = 0;
	public $issystem = 0;
	public $note = "";
	public $orderindex = 0;
	public $createuser = 0;
	public $createdate = 0;
	public $updateuser = 0;
	public $updatedate = 0;
	public $isdeleted = 0;
	public $deleteuser = 0;
	public $deletedate = 0;
	public $webstorename = "";
	public $disctrictid = 0;
	public $director = 0;
	public $email = 0;
	public $currentip = 0;
	public $storeipkey = "";
	public $storeipkeysource = "";
	public $imagemaplarge = "";
	public $imagemapsmall = "";
	public $openhour = "";
	public $lat = "";
	public $lng = "";
	public $isrepay = 0;
	public $isdefault = 0;
	public $isonlinestore = 0;
	public $rank = 0;
	public $bcnbstorename = "";
	public $bcnbstoreid = 0;
	public $bcnbprovinceid = 0;
	public $bcnbcompanyid = 0;
	public $isshowbcnb = 0;
	public $provinceid = 0;
	public $webstoreimage = "";
	public $isshowweb = 0;
	public $webaddress = "";
	public $isbizstockstore = 0;
	public $slug = "";
	public $region = 0;
	public $displayorder = 0;
	public $image = "";
	public $description = "";
	public $isreport = 0;
	public $datecreated = 0;
	public $dateupdated = 0;

    public function __construct($id = 0)
	{
		parent::__construct();
		if($id > 0)
		{
			if($loadFromCache)
				$this->copy(self::cacheGet($id));
			else
				$this->getData($id);
		}
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();

        $this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'store (
					s_name,
					a_id,
					s_companyid,
					s_storegroupid,
					s_storetypeid,
					s_poareaid,
					s_hoststoreid,
					ppa_id,
					s_storeshortname,
					s_storeaddress,
					s_storemanager,
					s_storephonenum,
					s_storefax,
					s_storecode,
					s_taxcode,
					s_taxaddress,
					s_companynameprefix,
					s_companytitle,
					s_poreceiveaddress,
					s_iscenterstore,
					s_isrealstore,
					s_issalestore,
					s_isinputstore,
					s_iswarrantystore,
					s_isautostorechange,
					s_isauxiliarystore,
					s_isactive,
					s_issystem,
					s_note,
					s_orderindex,
					s_createuser,
					s_createdate,
					s_updateuser,
					s_updatedate,
					s_isdeleted,
					s_deleteuser,
					s_deletedate,
					s_webstorename,
					s_disctrictid,
					s_director,
					s_email,
					s_currentip,
					s_storeipkey,
					s_storeipkeysource,
					s_imagemaplarge,
					s_imagemapsmall,
					s_openhour,
					s_lat,
					s_lng,
					s_isrepay,
					s_isdefault,
					s_isonlinestore,
					s_rank,
					s_bcnbstorename,
					s_bcnbstoreid,
					s_bcnbprovinceid,
					s_bcnbcompanyid,
					s_isshowbcnb,
					s_provinceid,
					s_webstoreimage,
					s_isshowweb,
					s_webaddress,
					s_isbizstockstore,
					s_slug,
					s_region,
					s_displayorder,
					s_image,
					s_description,
					s_isreport,
					s_datecreated,
					s_dateupdated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->aid,
					(int)$this->companyid,
					(int)$this->storegroupid,
					(int)$this->storetypeid,
					(int)$this->poareaid,
					(int)$this->hoststoreid,
					(int)$this->ppaid,
					(string)$this->storeshortname,
					(string)$this->storeaddress,
					(int)$this->storemanager,
					(string)$this->storephonenum,
					(string)$this->storefax,
					(string)$this->storecode,
					(string)$this->taxcode,
					(string)$this->taxaddress,
					(string)$this->companynameprefix,
					(string)$this->companytitle,
					(string)$this->poreceiveaddress,
					(int)$this->iscenterstore,
					(int)$this->isrealstore,
					(int)$this->issalestore,
					(int)$this->isinputstore,
					(int)$this->iswarrantystore,
					(int)$this->isautostorechange,
					(int)$this->isauxiliarystore,
					(int)$this->isactive,
					(int)$this->issystem,
					(string)$this->note,
					(int)$this->orderindex,
					(int)$this->createuser,
					(int)$this->createdate,
					(int)$this->updateuser,
					(int)$this->updatedate,
					(int)$this->isdeleted,
					(int)$this->deleteuser,
					(int)$this->deletedate,
					(string)$this->webstorename,
					(int)$this->disctrictid,
					(int)$this->director,
					(int)$this->email,
					(int)$this->currentip,
					(string)$this->storeipkey,
					(string)$this->storeipkeysource,
					(string)$this->imagemaplarge,
					(string)$this->imagemapsmall,
					(string)$this->openhour,
					(string)$this->lat,
					(string)$this->lng,
					(int)$this->isrepay,
					(int)$this->isdefault,
					(int)$this->isonlinestore,
					(int)$this->rank,
					(string)$this->bcnbstorename,
					(int)$this->bcnbstoreid,
					(int)$this->bcnbprovinceid,
					(int)$this->bcnbcompanyid,
					(int)$this->isshowbcnb,
					(int)$this->provinceid,
					(string)$this->webstoreimage,
					(int)$this->isshowweb,
					(string)$this->webaddress,
					(int)$this->isbizstockstore,
					(string)$this->slug,
					(int)$this->region,
					(int)$this->displayorder,
					(string)$this->image,
					(string)$this->description,
					(int)$this->isreport,
					(int)$this->datecreated,
					(int)$this->dateupdated
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'store
                            SET s_image = ?
                            WHERE s_id = ?';
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
		$sql = 'UPDATE ' . TABLE_PREFIX . 'store
				SET s_name = ?,
					a_id = ?,
					s_companyid = ?,
					s_storegroupid = ?,
					s_storetypeid = ?,
					s_poareaid = ?,
					s_hoststoreid = ?,
					ppa_id = ?,
					s_storeshortname = ?,
					s_storeaddress = ?,
					s_storemanager = ?,
					s_storephonenum = ?,
					s_storefax = ?,
					s_storecode = ?,
					s_taxcode = ?,
					s_taxaddress = ?,
					s_companynameprefix = ?,
					s_companytitle = ?,
					s_poreceiveaddress = ?,
					s_iscenterstore = ?,
					s_isrealstore = ?,
					s_issalestore = ?,
					s_isinputstore = ?,
					s_iswarrantystore = ?,
					s_isautostorechange = ?,
					s_isauxiliarystore = ?,
					s_isactive = ?,
					s_issystem = ?,
					s_note = ?,
					s_orderindex = ?,
					s_createuser = ?,
					s_createdate = ?,
					s_updateuser = ?,
					s_updatedate = ?,
					s_isdeleted = ?,
					s_deleteuser = ?,
					s_deletedate = ?,
					s_webstorename = ?,
					s_disctrictid = ?,
					s_director = ?,
					s_email = ?,
					s_currentip = ?,
					s_storeipkey = ?,
					s_storeipkeysource = ?,
					s_imagemaplarge = ?,
					s_imagemapsmall = ?,
					s_openhour = ?,
					s_lat = ?,
					s_lng = ?,
					s_isrepay = ?,
					s_isdefault = ?,
					s_isonlinestore = ?,
					s_rank = ?,
					s_bcnbstorename = ?,
					s_bcnbstoreid = ?,
					s_bcnbprovinceid = ?,
					s_bcnbcompanyid = ?,
					s_isshowbcnb = ?,
					s_provinceid = ?,
					s_webstoreimage = ?,
					s_isshowweb = ?,
					s_webaddress = ?,
					s_isbizstockstore = ?,
					s_slug = ?,
					s_region = ?,
					s_displayorder = ?,
					s_image = ?,
					s_description = ?,
					s_isreport = ?,
					s_datecreated = ?,
					s_dateupdated = ?
				WHERE s_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->aid,
					(int)$this->companyid,
					(int)$this->storegroupid,
					(int)$this->storetypeid,
					(int)$this->poareaid,
					(int)$this->hoststoreid,
					(int)$this->ppaid,
					(string)$this->storeshortname,
					(string)$this->storeaddress,
					(int)$this->storemanager,
					(string)$this->storephonenum,
					(string)$this->storefax,
					(string)$this->storecode,
					(string)$this->taxcode,
					(string)$this->taxaddress,
					(string)$this->companynameprefix,
					(string)$this->companytitle,
					(string)$this->poreceiveaddress,
					(int)$this->iscenterstore,
					(int)$this->isrealstore,
					(int)$this->issalestore,
					(int)$this->isinputstore,
					(int)$this->iswarrantystore,
					(int)$this->isautostorechange,
					(int)$this->isauxiliarystore,
					(int)$this->isactive,
					(int)$this->issystem,
					(string)$this->note,
					(int)$this->orderindex,
					(int)$this->createuser,
					(int)$this->createdate,
					(int)$this->updateuser,
					(int)$this->updatedate,
					(int)$this->isdeleted,
					(int)$this->deleteuser,
					(int)$this->deletedate,
					(string)$this->webstorename,
					(int)$this->disctrictid,
					(int)$this->director,
					(int)$this->email,
					(int)$this->currentip,
					(string)$this->storeipkey,
					(string)$this->storeipkeysource,
					(string)$this->imagemaplarge,
					(string)$this->imagemapsmall,
					(string)$this->openhour,
					(string)$this->lat,
					(string)$this->lng,
					(int)$this->isrepay,
					(int)$this->isdefault,
					(int)$this->isonlinestore,
					(int)$this->rank,
					(string)$this->bcnbstorename,
					(int)$this->bcnbstoreid,
					(int)$this->bcnbprovinceid,
					(int)$this->bcnbcompanyid,
					(int)$this->isshowbcnb,
					(int)$this->provinceid,
					(string)$this->webstoreimage,
					(int)$this->isshowweb,
					(string)$this->webaddress,
					(int)$this->isbizstockstore,
					(string)$this->slug,
					(int)$this->region,
					(int)$this->displayorder,
					(string)$this->image,
					(string)$this->description,
					(int)$this->isreport,
					(int)$this->datecreated,
					(int)$this->dateupdated,
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'store
                            SET s_image = ?
                            WHERE s_id = ?';
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_tmp s
				WHERE s.s_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['s_id'];
		$this->name = $row['s_name'];
		$this->aid = $row['a_id'];
		$this->companyid = $row['s_companyid'];
		$this->storegroupid = $row['s_storegroupid'];
		$this->storetypeid = $row['s_storetypeid'];
		$this->poareaid = $row['s_poareaid'];
		$this->hoststoreid = $row['s_hoststoreid'];
		$this->ppaid = $row['ppa_id'];
		$this->storeshortname = $row['s_storeshortname'];
		$this->storeaddress = $row['s_storeaddress'];
		$this->storemanager = $row['s_storemanager'];
		$this->storephonenum = $row['s_storephonenum'];
		$this->storefax = $row['s_storefax'];
		$this->storecode = $row['s_storecode'];
		$this->taxcode = $row['s_taxcode'];
		$this->taxaddress = $row['s_taxaddress'];
		$this->companynameprefix = $row['s_companynameprefix'];
		$this->companytitle = $row['s_companytitle'];
		$this->poreceiveaddress = $row['s_poreceiveaddress'];
		$this->iscenterstore = $row['s_iscenterstore'];
		$this->isrealstore = $row['s_isrealstore'];
		$this->issalestore = $row['s_issalestore'];
		$this->isinputstore = $row['s_isinputstore'];
		$this->iswarrantystore = $row['s_iswarrantystore'];
		$this->isautostorechange = $row['s_isautostorechange'];
		$this->isauxiliarystore = $row['s_isauxiliarystore'];
		$this->isactive = $row['s_isactive'];
		$this->issystem = $row['s_issystem'];
		$this->note = $row['s_note'];
		$this->orderindex = $row['s_orderindex'];
		$this->createuser = $row['s_createuser'];
		$this->createdate = $row['s_createdate'];
		$this->updateuser = $row['s_updateuser'];
		$this->updatedate = $row['s_updatedate'];
		$this->isdeleted = $row['s_isdeleted'];
		$this->deleteuser = $row['s_deleteuser'];
		$this->deletedate = $row['s_deletedate'];
		$this->webstorename = $row['s_webstorename'];
		$this->disctrictid = $row['s_disctrictid'];
		$this->director = $row['s_director'];
		$this->email = $row['s_email'];
		$this->currentip = $row['s_currentip'];
		$this->storeipkey = $row['s_storeipkey'];
		$this->storeipkeysource = $row['s_storeipkeysource'];
		$this->imagemaplarge = $row['s_imagemaplarge'];
		$this->imagemapsmall = $row['s_imagemapsmall'];
		$this->openhour = $row['s_openhour'];
		$this->lat = $row['s_lat'];
		$this->lng = $row['s_lng'];
		$this->isrepay = $row['s_isrepay'];
		$this->isdefault = $row['s_isdefault'];
		$this->isonlinestore = $row['s_isonlinestore'];
		$this->rank = $row['s_rank'];
		$this->bcnbstorename = $row['s_bcnbstorename'];
		$this->bcnbstoreid = $row['s_bcnbstoreid'];
		$this->bcnbprovinceid = $row['s_bcnbprovinceid'];
		$this->bcnbcompanyid = $row['s_bcnbcompanyid'];
		$this->isshowbcnb = $row['s_isshowbcnb'];
		$this->provinceid = $row['s_provinceid'];
		$this->webstoreimage = $row['s_webstoreimage'];
		$this->isshowweb = $row['s_isshowweb'];
		$this->webaddress = $row['s_webaddress'];
		$this->isbizstockstore = $row['s_isbizstockstore'];
		$this->slug = $row['s_slug'];
		$this->region = $row['s_region'];
		$this->displayorder = $row['s_displayorder'];
		$this->image = $row['s_image'];
		$this->description = $row['s_description'];
		$this->isreport = $row['s_isreport'];
		$this->datecreated = $row['s_datecreated'];
		$this->dateupdated = $row['s_dateupdated'];

	}

	 /**
     * Get the object data base on slug
     * @param string $slug : value for searching record.
     */
    public function getSlug($slug)
    {
        global $db;

        $slug = (string)$slug;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store s
				WHERE s.s_slug = ?';
        $row = $db->query($sql, array($slug))->fetch();

        $myStore = new Core_Store();

        $myStore->id = $row['s_id'];
		$myStore->name = $row['s_name'];
		$myStore->aid = $row['a_id'];
		$myStore->companyid = $row['s_companyid'];
		$myStore->storegroupid = $row['s_storegroupid'];
		$myStore->storetypeid = $row['s_storetypeid'];
		$myStore->poareaid = $row['s_poareaid'];
		$myStore->hoststoreid = $row['s_hoststoreid'];
		$myStore->ppaid = $row['ppa_id'];
		$myStore->storeshortname = $row['s_storeshortname'];
		$myStore->storeaddress = $row['s_storeaddress'];
		$myStore->storemanager = $row['s_storemanager'];
		$myStore->storephonenum = $row['s_storephonenum'];
		$myStore->storefax = $row['s_storefax'];
		$myStore->storecode = $row['s_storecode'];
		$myStore->taxcode = $row['s_taxcode'];
		$myStore->taxaddress = $row['s_taxaddress'];
		$myStore->companynameprefix = $row['s_companynameprefix'];
		$myStore->companytitle = $row['s_companytitle'];
		$myStore->poreceiveaddress = $row['s_poreceiveaddress'];
		$myStore->iscenterstore = $row['s_iscenterstore'];
		$myStore->isrealstore = $row['s_isrealstore'];
		$myStore->issalestore = $row['s_issalestore'];
		$myStore->isinputstore = $row['s_isinputstore'];
		$myStore->iswarrantystore = $row['s_iswarrantystore'];
		$myStore->isautostorechange = $row['s_isautostorechange'];
		$myStore->isauxiliarystore = $row['s_isauxiliarystore'];
		$myStore->isactive = $row['s_isactive'];
		$myStore->issystem = $row['s_issystem'];
		$myStore->note = $row['s_note'];
		$myStore->orderindex = $row['s_orderindex'];
		$myStore->createuser = $row['s_createuser'];
		$myStore->createdate = $row['s_createdate'];
		$myStore->updateuser = $row['s_updateuser'];
		$myStore->updatedate = $row['s_updatedate'];
		$myStore->isdeleted = $row['s_isdeleted'];
		$myStore->deleteuser = $row['s_deleteuser'];
		$myStore->deletedate = $row['s_deletedate'];
		$myStore->webstorename = $row['s_webstorename'];
		$myStore->disctrictid = $row['s_disctrictid'];
		$myStore->director = $row['s_director'];
		$myStore->email = $row['s_email'];
		$myStore->currentip = $row['s_currentip'];
		$myStore->storeipkey = $row['s_storeipkey'];
		$myStore->storeipkeysource = $row['s_storeipkeysource'];
		$myStore->imagemaplarge = $row['s_imagemaplarge'];
		$myStore->imagemapsmall = $row['s_imagemapsmall'];
		$myStore->openhour = $row['s_openhour'];
		$myStore->lat = $row['s_lat'];
		$myStore->lng = $row['s_lng'];
		$myStore->isrepay = $row['s_isrepay'];
		$myStore->isdefault = $row['s_isdefault'];
		$myStore->isonlinestore = $row['s_isonlinestore'];
		$myStore->rank = $row['s_rank'];
		$myStore->bcnbstorename = $row['s_bcnbstorename'];
		$myStore->bcnbstoreid = $row['s_bcnbstoreid'];
		$myStore->bcnbprovinceid = $row['s_bcnbprovinceid'];
		$myStore->bcnbcompanyid = $row['s_bcnbcompanyid'];
		$myStore->isshowbcnb = $row['s_isshowbcnb'];
		$myStore->provinceid = $row['s_provinceid'];
		$myStore->webstoreimage = $row['s_webstoreimage'];
		$myStore->isshowweb = $row['s_isshowweb'];
		$myStore->webaddress = $row['s_webaddress'];
		$myStore->isbizstockstore = $row['s_isbizstockstore'];
		$myStore->slug = $row['s_slug'];
		$myStore->region = $row['s_region'];
		$myStore->displayorder = $row['s_displayorder'];
		$myStore->image = $row['s_image'];
		$myStore->description = $row['s_description'];
		$myStore->isreport = $row['s_isreport'];
		$myStore->datecreated = $row['s_datecreated'];
		$myStore->dateupdated = $row['s_dateupdated'];
    }

    /**
     * Get ID by Slug
     * @param  $lug
     * @return $id
     */
    public static function getIdBySlug($slug)
    {
        global $db;

        $slug = (string)Helper::plaintext($slug);
        $sql = 'SELECT s.s_id FROM ' . TABLE_PREFIX . 'store s
				WHERE s.s_slug = ?';
        $row = $db->query($sql, array($slug))->fetch();
        if (!empty($row)) return $row['s_id'];
        return 0;
    }

    public function getDataByArray($row)
	{
		$this->id = $row['s_id'];
		$this->name = $row['s_name'];
		$this->aid = $row['a_id'];
		$this->companyid = $row['s_companyid'];
		$this->storegroupid = $row['s_storegroupid'];
		$this->storetypeid = $row['s_storetypeid'];
		$this->poareaid = $row['s_poareaid'];
		$this->hoststoreid = $row['s_hoststoreid'];
		$this->ppaid = $row['ppa_id'];
		$this->storeshortname = $row['s_storeshortname'];
		$this->storeaddress = $row['s_storeaddress'];
		$this->storemanager = $row['s_storemanager'];
		$this->storephonenum = $row['s_storephonenum'];
		$this->storefax = $row['s_storefax'];
		$this->storecode = $row['s_storecode'];
		$this->taxcode = $row['s_taxcode'];
		$this->taxaddress = $row['s_taxaddress'];
		$this->companynameprefix = $row['s_companynameprefix'];
		$this->companytitle = $row['s_companytitle'];
		$this->poreceiveaddress = $row['s_poreceiveaddress'];
		$this->iscenterstore = $row['s_iscenterstore'];
		$this->isrealstore = $row['s_isrealstore'];
		$this->issalestore = $row['s_issalestore'];
		$this->isinputstore = $row['s_isinputstore'];
		$this->iswarrantystore = $row['s_iswarrantystore'];
		$this->isautostorechange = $row['s_isautostorechange'];
		$this->isauxiliarystore = $row['s_isauxiliarystore'];
		$this->isactive = $row['s_isactive'];
		$this->issystem = $row['s_issystem'];
		$this->note = $row['s_note'];
		$this->orderindex = $row['s_orderindex'];
		$this->createuser = $row['s_createuser'];
		$this->createdate = $row['s_createdate'];
		$this->updateuser = $row['s_updateuser'];
		$this->updatedate = $row['s_updatedate'];
		$this->isdeleted = $row['s_isdeleted'];
		$this->deleteuser = $row['s_deleteuser'];
		$this->deletedate = $row['s_deletedate'];
		$this->webstorename = $row['s_webstorename'];
		$this->disctrictid = $row['s_disctrictid'];
		$this->director = $row['s_director'];
		$this->email = $row['s_email'];
		$this->currentip = $row['s_currentip'];
		$this->storeipkey = $row['s_storeipkey'];
		$this->storeipkeysource = $row['s_storeipkeysource'];
		$this->imagemaplarge = $row['s_imagemaplarge'];
		$this->imagemapsmall = $row['s_imagemapsmall'];
		$this->openhour = $row['s_openhour'];
		$this->lat = $row['s_lat'];
		$this->lng = $row['s_lng'];
		$this->isrepay = $row['s_isrepay'];
		$this->isdefault = $row['s_isdefault'];
		$this->isonlinestore = $row['s_isonlinestore'];
		$this->rank = $row['s_rank'];
		$this->bcnbstorename = $row['s_bcnbstorename'];
		$this->bcnbstoreid = $row['s_bcnbstoreid'];
		$this->bcnbprovinceid = $row['s_bcnbprovinceid'];
		$this->bcnbcompanyid = $row['s_bcnbcompanyid'];
		$this->isshowbcnb = $row['s_isshowbcnb'];
		$this->provinceid = $row['s_provinceid'];
		$this->webstoreimage = $row['s_webstoreimage'];
		$this->isshowweb = $row['s_isshowweb'];
		$this->webaddress = $row['s_webaddress'];
		$this->isbizstockstore = $row['s_isbizstockstore'];
		$this->slug = $row['s_slug'];
		$this->region = $row['s_region'];
		$this->displayorder = $row['s_displayorder'];
		$this->image = $row['s_image'];
		$this->description = $row['s_description'];
		$this->isreport = $row['s_isreport'];
		$this->datecreated = $row['s_datecreated'];
		$this->dateupdated = $row['s_dateupdated'];
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'store_tmp
				WHERE s_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'store_tmp s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store s';

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
			$myStore = new Core_Storet();

			$myStore->id = $row['s_id'];
			$myStore->name = $row['s_name'];
			$myStore->aid = $row['a_id'];
			$myStore->companyid = $row['s_companyid'];
			$myStore->storegroupid = $row['s_storegroupid'];
			$myStore->storetypeid = $row['s_storetypeid'];
			$myStore->poareaid = $row['s_poareaid'];
			$myStore->hoststoreid = $row['s_hoststoreid'];
			$myStore->ppaid = $row['ppa_id'];
			$myStore->storeshortname = $row['s_storeshortname'];
			$myStore->storeaddress = $row['s_storeaddress'];
			$myStore->storemanager = $row['s_storemanager'];
			$myStore->storephonenum = $row['s_storephonenum'];
			$myStore->storefax = $row['s_storefax'];
			$myStore->storecode = $row['s_storecode'];
			$myStore->taxcode = $row['s_taxcode'];
			$myStore->taxaddress = $row['s_taxaddress'];
			$myStore->companynameprefix = $row['s_companynameprefix'];
			$myStore->companytitle = $row['s_companytitle'];
			$myStore->poreceiveaddress = $row['s_poreceiveaddress'];
			$myStore->iscenterstore = $row['s_iscenterstore'];
			$myStore->isrealstore = $row['s_isrealstore'];
			$myStore->issalestore = $row['s_issalestore'];
			$myStore->isinputstore = $row['s_isinputstore'];
			$myStore->iswarrantystore = $row['s_iswarrantystore'];
			$myStore->isautostorechange = $row['s_isautostorechange'];
			$myStore->isauxiliarystore = $row['s_isauxiliarystore'];
			$myStore->isactive = $row['s_isactive'];
			$myStore->issystem = $row['s_issystem'];
			$myStore->note = $row['s_note'];
			$myStore->orderindex = $row['s_orderindex'];
			$myStore->createuser = $row['s_createuser'];
			$myStore->createdate = $row['s_createdate'];
			$myStore->updateuser = $row['s_updateuser'];
			$myStore->updatedate = $row['s_updatedate'];
			$myStore->isdeleted = $row['s_isdeleted'];
			$myStore->deleteuser = $row['s_deleteuser'];
			$myStore->deletedate = $row['s_deletedate'];
			$myStore->webstorename = $row['s_webstorename'];
			$myStore->disctrictid = $row['s_disctrictid'];
			$myStore->director = $row['s_director'];
			$myStore->email = $row['s_email'];
			$myStore->currentip = $row['s_currentip'];
			$myStore->storeipkey = $row['s_storeipkey'];
			$myStore->storeipkeysource = $row['s_storeipkeysource'];
			$myStore->imagemaplarge = $row['s_imagemaplarge'];
			$myStore->imagemapsmall = $row['s_imagemapsmall'];
			$myStore->openhour = $row['s_openhour'];
			$myStore->lat = $row['s_lat'];
			$myStore->lng = $row['s_lng'];
			$myStore->isrepay = $row['s_isrepay'];
			$myStore->isdefault = $row['s_isdefault'];
			$myStore->isonlinestore = $row['s_isonlinestore'];
			$myStore->rank = $row['s_rank'];
			$myStore->bcnbstorename = $row['s_bcnbstorename'];
			$myStore->bcnbstoreid = $row['s_bcnbstoreid'];
			$myStore->bcnbprovinceid = $row['s_bcnbprovinceid'];
			$myStore->bcnbcompanyid = $row['s_bcnbcompanyid'];
			$myStore->isshowbcnb = $row['s_isshowbcnb'];
			$myStore->provinceid = $row['s_provinceid'];
			$myStore->webstoreimage = $row['s_webstoreimage'];
			$myStore->isshowweb = $row['s_isshowweb'];
			$myStore->webaddress = $row['s_webaddress'];
			$myStore->isbizstockstore = $row['s_isbizstockstore'];
			$myStore->slug = $row['s_slug'];
			$myStore->region = $row['s_region'];
			$myStore->displayorder = $row['s_displayorder'];
			$myStore->image = $row['s_image'];
			$myStore->description = $row['s_description'];
			$myStore->isreport = $row['s_isreport'];
			$myStore->datecreated = $row['s_datecreated'];
			$myStore->dateupdated = $row['s_dateupdated'];


            $outputList[] = $myStore;
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
	public static function getStorets($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['faid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.a_id = '.(int)$formData['faid'].' ';

		if($formData['fstoregroupid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_storegroupid = '.(int)$formData['fstoregroupid'].' ';

		if($formData['fstoretypeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_storetypeid = '.(int)$formData['fstoretypeid'].' ';

		if($formData['fhoststoreid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_hoststoreid = '.(int)$formData['fhoststoreid'].' ';

		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.ppa_id = '.(int)$formData['fppaid'].' ';

		if($formData['fissalestore'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_issalestore = '.(int)$formData['fissalestore'].' ';

		if($formData['fisauxiliarystore'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_isauxiliarystore = '.(int)$formData['fisauxiliarystore'].' ';

		if($formData['femail'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_email = '.(int)$formData['femail'].' ';

		if($formData['flat'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_lat = "'.Helper::unspecialtext((string)$formData['flat']).'" ';

		if($formData['flng'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_lng = "'.Helper::unspecialtext((string)$formData['flng']).'" ';

		if($formData['fisbizstockstore'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_isbizstockstore = '.(int)$formData['fisbizstockstore'].' ';

		if($formData['fregion'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_region = '.(int)$formData['fregion'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fisreport'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_isreport = '.(int)$formData['fisreport'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'description')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_description LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (s.s_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.s_description LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 's_displayorder ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 's_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 's_datemodified ' . $sorttype;
		else
			$orderString = 's_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(s_displayorder) FROM ' . TABLE_PREFIX . 'store';
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
        $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['store']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['store']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['store']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['store']['imageMaxWidth'],
                                                $registry->setting['store']['imageMaxHeight'],
                                                '',
                                                $registry->setting['store']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create medium image
            $nameMediumPart = substr($name, 0, strrpos($name, '.'));
            $nameMedium = $nameMediumPart . '-medium.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['store']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['store']['imageDirectory'] . $curDateDir, $nameMedium,
                                                $registry->setting['store']['imageMediumWidth'],
                                                $registry->setting['store']['imageMediumHeight'],
                                                '',
                                                $registry->setting['store']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['store']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['store']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['store']['imageThumbWidth'],
                                                $registry->setting['store']['imageThumbHeight'],
                                                $registry->setting['store']['imageThumbRatio'],
                                                $registry->setting['store']['imageQuality']);
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
            $file = $registry->setting['store']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
                $pos = strrpos($deletefile, '.');
                $extPart = substr($deletefile, $pos+1);
                $namePart =  substr($deletefile,0, $pos);

                $deletesmallimage = $namePart . '-small.' . $extPart;
                $file = $registry->setting['store']['imageDirectory'] . $deletesmallimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);

                $deletemediumimage = $namePart . '-medium.' . $extPart;
                $file = $registry->setting['store']['imageDirectory'] . $deletemediumimage;
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

        $url = $registry->conf['rooturl'] . $registry->setting['store']['imageDirectory'] . $filesmall;
        return $url;
    }

    public function getMediumImage()
    {
        global $registry;

        $pos = strrpos($this->image, '.');
        $extPart = substr($this->image, $pos+1);
        $namePart =  substr($this->image,0, $pos);
        $filemedium = $namePart . '-medium.' . $extPart;

        $url = $registry->conf['rooturl'] . $registry->setting['store']['imageDirectory'] . $filemedium;
        return $url;
    }

    public function getImage()
    {
        global $registry;

        $url = $registry->conf['rooturl'] . $registry->setting['store']['imageDirectory'] . $this->image;
        return $url;
    }

    public function getRegionName($id = 0)
    {
		global $setting;

		return $setting['region'][$this->region];
    }

	////////////////////////////////
	////////////////////////////////
	// START CACHE PROCESS

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $id
	*/
	public static function cacheBuildKey($id)
	{
		return 'store_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myStore = new Core_Store();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store
					WHERE s_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['s_id'] > 0)
			{
				$myStore->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myStore->getDataByArray($row);
		}

		return $myStore;
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $id
	*/
	public static function cacheClear($id)
	{
		$myCacher = new Cacher(self::cacheBuildKey($id));
		return $myCacher->clear();
	}

	// - END CACHE PROCESS
	////////////////////////////////


    public function getStorePath()
    {
        global $registry;

        $storePath = $registry['conf']['rooturl'];

        if(strlen($this->slug) > 0)
        {
            $storePath .= 'sieuthi/' . $this->slug;
        }
        else
        {
            if($storePath) $storePath .= 'sieuthi/detail?id='.$this->id;
        }

        return $storePath;
    }

    public static function getStoresFromCache()
    {
    	global $conf;
    	$storelist = array();
    	$myCacher = new Cacher('storelist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);

    	$data = $myCacher->get();

    	if($data != false)
    	{
    		$datalist = explode('#' ,  $data);
    		if(count($datalist) > 0)
    		{
    			foreach ($datalist as $info)
    			{
    				$infoarr = explode(':', $info);
    				$storelist[$infoarr[0]] = $infoarr[1];
    			}
    		}
    	}

    	return $storelist;
    }

}