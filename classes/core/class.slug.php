<?php

/**
 * core/class.slug.php
 *
 * File contains the class used for Slug Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Slug extends Core_Object
{

	const STATUS_SYNCING = 1;
	const STATUS_SYNCED = 3;
	const STATUS_REFERENCE = 5;
	const STATUS_REDIRECT = 7;	//set URL in redirecturl
	const STATUS_NOTFOUND = 9;

	public $uid = 0;
	public $id = 0;
	public $slug = "";
	public $hash = "";
	public $ref = 0;
	public $controller = "";
	public $objectid = 0;
	public $redirecturl = '';
	public $status = 0;
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
		$this->hash = md5($this->slug);
		if($this->status == 0)
		{
			$this->status = self::STATUS_SYNCED;
		}

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'slug (
					u_id,
					s_slug,
					s_hash,
					s_ref,
					s_controller,
					s_objectid,
					s_redirecturl,
					s_status,
					s_datecreated,
					s_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->slug,
					(string)$this->hash,
					(int)$this->ref,
					(string)$this->controller,
					(int)$this->objectid,
					(string)$this->redirecturl,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'slug
				SET u_id = ?,
					s_slug = ?,
					s_hash = ?,
					s_ref = ?,
					s_controller = ?,
					s_objectid = ?,
					s_redirecturl = ?,
					s_status = ?,
					s_datecreated = ?,
					s_datemodified = ?
				WHERE s_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->slug,
					(string)$this->hash,
					(int)$this->ref,
					(string)$this->controller,
					(int)$this->objectid,
					(string)$this->redirecturl,
					(int)$this->status,
					(int)$this->datecreated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'slug s
				WHERE s.s_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['s_id'];
		$this->slug = $row['s_slug'];
		$this->hash = $row['s_hash'];
		$this->ref = $row['s_ref'];
		$this->controller = $row['s_controller'];
		$this->objectid = $row['s_objectid'];
		$this->redirecturl = $row['s_redirecturl'];
		$this->status = $row['s_status'];
		$this->datecreated = $row['s_datecreated'];
		$this->datemodified = $row['s_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->uid = $row['u_id'];
		$this->id = $row['s_id'];
		$this->slug = $row['s_slug'];
		$this->hash = $row['s_hash'];
		$this->ref = $row['s_ref'];
		$this->controller = $row['s_controller'];
		$this->objectid = $row['s_objectid'];
		$this->redirecturl = $row['s_redirecturl'];
		$this->status = $row['s_status'];
		$this->datecreated = $row['s_datecreated'];
		$this->datemodified = $row['s_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'slug
				WHERE s_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public static function linkSlug($linktoSlugId, $slug, $controller = '', $objectid = 0)
	{
		global $db;
		$sql = 'UPDATE ' . TABLE_PREFIX . 'slug
				SET s_ref = ?,
					s_status = ?
				WHERE s_hash = ?';

		if($controller != '')
			$sql .= ' AND s_controller = "'.Helper::plaintext($controller).'"';

		if($objectid > 0)
			$sql .= ' AND s_objectid = '.(int)$objectid.'';

		$rowCount = $db->query($sql, array($linktoSlugId, self::STATUS_REFERENCE, md5($slug)))->rowCount();
		return $rowCount;
	}

	public static function deleteSlug($slug, $controller, $objectid)
	{
		global $db;
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'slug
				WHERE s_hash = ?';

		if($controller != '')
			$sql .= ' AND s_controller = "'.Helper::plaintext($controller).'"';

		if($objectid > 0)
			$sql .= ' AND s_objectid = '.(int)$objectid.'';

		$rowCount = $db->query($sql, array(md5($slug)))->rowCount();
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'slug s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'slug s';

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
			$mySlug = new Core_Slug();

			$mySlug->uid = $row['u_id'];
			$mySlug->id = $row['s_id'];
			$mySlug->slug = $row['s_slug'];
			$mySlug->hash = $row['s_hash'];
			$mySlug->ref = $row['s_ref'];
			$mySlug->controller = $row['s_controller'];
			$mySlug->objectid = $row['s_objectid'];
			$mySlug->redirecturl = $row['s_redirecturl'];
			$mySlug->status = $row['s_status'];
			$mySlug->datecreated = $row['s_datecreated'];
			$mySlug->datemodified = $row['s_datemodified'];


            $outputList[] = $mySlug;
        }

        return $outputList;
    }

	public static function getSlugFromText($slug)
	{


		$mySlug = new Core_Slug();

		$hash = md5($slug);
		$cacheKey = 'slug:' . $hash;

		//Tim cache
		$myCacher = new Cacher($cacheKey);
		$slugInfo = $myCacher->get();
		if(!$slugInfo || isset($_GET['live']))
		{
			$list = self::getSlugs(array('fhash' => $hash), 'id', 'DESC', 1);

			if(count($list) > 0)
			{
				$mySlug = $list[0];

				$slugInfo = array();
				$slugInfo['u_id'] = $mySlug->uid;
				$slugInfo['s_id'] = $mySlug->id;
				$slugInfo['s_slug'] = $mySlug->slug;
				$slugInfo['s_hash'] = $mySlug->hash;
				$slugInfo['s_ref'] = $mySlug->ref;
				$slugInfo['s_controller'] = $mySlug->controller;
				$slugInfo['s_objectid'] = $mySlug->objectid;
				$slugInfo['s_redirecturl'] = $mySlug->redirecturl;
				$slugInfo['s_status'] = $mySlug->status;
				$slugInfo['s_datecreated'] = $mySlug->datecreated;
				$slugInfo['s_datemodified'] = $mySlug->datemodified;

				//cache back
				$myCacher->set($slugInfo, 3600 * 24 * 3);
			}
		}
		else
		{
			$mySlug->getDataByArray($slugInfo);
		}



		return $mySlug;
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
	public static function getSlugs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_id = '.(int)$formData['fid'].' ';

		if($formData['fslug'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';

		if($formData['fhash'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_hash = "'.Helper::unspecialtext((string)$formData['fhash']).'" ';

		if($formData['fcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_controller = "'.Helper::unspecialtext((string)$formData['fcontroller']).'" ';

        if($formData['fcontrollernotin'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_controller NOT IN ("'.Helper::unspecialtext((string)$formData['fcontrollernotin']).'") ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_status = '.(int)$formData['fstatus'].' ';


		if($formData['fexceptController'] != '')
			$sql .= ' AND s_controller != "' . Helper::plaintext($formData['fexceptController']) . '" ';

		if($formData['fexceptObjectId'] != '')
			$sql .= ' AND s_objectid != ' . (int)$formData['fexceptObjectId'] . ' ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 's_id ' . $sorttype;
		else
			$orderString = 's_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	 * Sync all slug of current system
	 */
	public static function sync()
	{
		die('disabled');
		global $db;

		//Clear Existed slug
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'slug
				WHERE s_status = ' . self::STATUS_SYNCED . '
					AND s_controller IN ("page", "vendor", "product", "productcategory", "news", "newscategory", "stuffcategory")';
		$db->query($sql);

		//List of conflic Slugs
		$conflictList = array();

		////////////////////////////////////
		////////////////////////////////////
		//Main query to insert/update slug
		$sqlSlug = 'INSERT INTO ' . TABLE_PREFIX . 'slug (
						s_slug,
						s_hash,
						s_controller,
						s_objectid,
						s_status,
						s_datecreated)
					VALUES(?, ?, ?, ?, ?, ?)';
		$stmtSlug = $db->prepare($sqlSlug);

		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// PAGE
		$stmt = $db->query('SELECT p_id as id, p_slug slug, p_title FROM ' . TABLE_PREFIX . 'page');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['p_title'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'page', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'page SET p_slug = ? WHERE p_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}


		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// VENDOR
		$stmt = $db->query('SELECT v_id as id, v_slug slug, v_name FROM ' . TABLE_PREFIX . 'vendor');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['v_name'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'vendor', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'vendor SET v_slug = ? WHERE v_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}



		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// PRODUCT CATEGORY
		$stmt = $db->query('SELECT pc_id as id, pc_slug slug, pc_name FROM ' . TABLE_PREFIX . 'productcategory');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['pc_name'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'productcategory', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'productcategory SET pc_slug = ? WHERE pc_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}


		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// PRODUCT
		$stmt = $db->query('SELECT p_id as id, p_slug slug, p_name FROM ' . TABLE_PREFIX . 'product');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['p_name'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'product', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_slug = ? WHERE p_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}

		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// NEWS
		$stmt = $db->query('SELECT n_id as id, n_slug slug, n_title FROM ' . TABLE_PREFIX . 'news');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['n_title'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'news', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'news SET n_slug = ? WHERE n_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}

		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// NEWS CATEGORY
		$stmt = $db->query('SELECT nc_id as id, nc_slug slug, nc_name FROM ' . TABLE_PREFIX . 'newscategory');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['nc_name'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'newscategory', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'newscategory SET nc_slug = ? WHERE nc_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}



		/////////////////////////////////////////////
		/////////////////////////////////////////////
		// STUFF CATEGORY
		$stmt = $db->query('SELECT sc_id as id, sc_slug slug, sc_name FROM ' . TABLE_PREFIX . 'stuffcategory');
		while($row = $stmt->fetch())
		{
			if(trim($row['slug']) == '')
				$myslug = Helper::codau2khongdau($row['sc_name'], true, true);
			else
				$myslug = $row['slug'];

			//Search this slug is existed
			$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
			if($slugExisted)
			{
				while(1)
				{
					$myslug .= '-2';
					$slugExisted = self::getSlugs(array('fhash' => md5($myslug)), '', '', '', true) > 0 ? true : false;
					if(!$slugExisted)
						break;
				}
			}
			//Insert slug
			$stmtSlug->execute(array($row['slug'], md5($myslug), 'stuffcategory', $row['id'], Core_Slug::STATUS_SYNCED, time()));

			//Update slug
			$sql = 'UPDATE ' . TABLE_PREFIX . 'stuffcategory SET sc_slug = ? WHERE sc_id = ?';
			$db->query($sql, array($myslug, $row['id']));
		}


		return $conflictList;

	}

	public static function getStatusList()
	{
		$list = array();

		$list[self::STATUS_SYNCING] = 'Syncing';
		$list[self::STATUS_SYNCED] = 'Synced';
		$list[self::STATUS_REFERENCE] = 'Reference';
		$list[self::STATUS_REDIRECT] = 'Redirect';
		$list[self::STATUS_NOTFOUND] = 'Not Found';

		return $list;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_SYNCING: $name = 'Syncing'; break;
			case self::STATUS_SYNCED: $name = 'Synced'; break;
			case self::STATUS_REFERENCE: $name = 'Reference'; break;
			case self::STATUS_REDIRECT: $name = 'Redirect'; break;
			case self::STATUS_NOTFOUND: $name = 'Not Found'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return (
				($this->status == self::STATUS_SYNCING && $name == 'syncing')
			|| ($this->status == self::STATUS_SYNCED && $name == 'synced')
			|| ($this->status == self::STATUS_REFERENCE && $name == 'reference')
			|| ($this->status == self::STATUS_REDIRECT && $name == 'redirect')
			|| ($this->status == self::STATUS_NOTFOUND && $name == 'notfound')
			);
	}

	public function getSlugPath()
	{
		global $registry;

		return $registry->conf['rooturl'] . $this->slug;
	}

    public function getSlugPathRedirect()
    {
        global $registry;

        $redirecturl = $this->redirecturl;
        if(preg_match('/(http:|https:)/', $redirecturl))
        {
            return $redirecturl;
        }
        return $registry->conf['rooturl'] . $redirecturl;
    }

	public function getSlugSearch()
	{
		global $registry;

		return $registry->conf['rooturl_cms'] . 'slug/index/hash/' . $this->hash;
	}

	public function getObjectPath()
	{
		$url = '';

		switch($this->controller)
		{
			case 'product': $obj = new Core_Product($this->objectid); $url = $obj->getProductPath(); break;
			case 'productcategory': $obj = new Core_Productcategory($this->objectid); $url = $obj->getProductcateoryPath(); break;
			case 'vendor': $obj = new Core_Vendor($this->objectid); $url = $obj->getVendorPath(); break;
			case 'news': $obj = new Core_News($this->objectid); $url = $obj->getNewsPath(); break;
			case 'newscategory': $obj = new Core_Newscategory($this->objectid); $url = $obj->getNewscategoryPath(); break;
			case 'stuffcategory': $obj = new Core_Stuffcategory($this->objectid); $url = $obj->getStuffcategoryPath(); break;
			case 'page': $obj = new Core_Page($this->objectid); $url = $obj->getPagePath(); break;
		}

		return $url;
	}
}