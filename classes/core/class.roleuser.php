<?php

/**
 * core/class.roleuser.php
 *
 * File contains the class used for RoleUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RoleUser extends Core_Object
{

	const TYPE_PRODUCT = 1001;
    const TYPE_PRODUCTCATEGORY = 1002;
    const TYPE_PRODUCTATTRIBUTE = 1003;


    const TYPE_NEWS = 2001;
    const TYPE_NEWSCATEGORY = 2002;

    const TYPE_STUFF = 3001;
    const TYPE_STUFFCATEGORY = 3002;

    const TYPE_BANNER = 4001;

    const TYPE_SALE = 5001;

    const TYPE_DELEGATE = 6001;

    const TYPE_PRODUCTPROMOTION = 7001;

    const TYPE_PAGE = 8001;

    const TYPE_SLUG = 9001;

    const TYPE_ORDER = 9100;

    const TYPE_VIEWPROMOTION = 9300;

	const TYPE_VIEWORDER = 9500;

    const ROLE_READ = 1;
    const ROLE_VERIFY = 4;
    const ROLE_CHANGE = 8;
    const ROLE_FULL = 15;


    const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;


	public $uid = 0;
	public $id = 0;
	public $type = 0;
	public $value = 0;
	public $objectid = 0;
	public $subobjectid = 0;
	public $creatorid = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $actor = null;
	public $productcategory = null;
	public $newscategory = null;
	public $stuffcategory = null;
	public $vendor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'role_user (
					u_id,
					ru_type,
					ru_value,
					ru_objectid,
					ru_subobjectid,
					ru_creatorid,
					ru_status,
					ru_datecreated,
					ru_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->type,
					(int)$this->value,
					(int)$this->objectid,
					(int)$this->subobjectid,
					(int)$this->creatorid,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'role_user
				SET u_id = ?,
					ru_type = ?,
					ru_value = ?,
					ru_objectid = ?,
					ru_subobjectid = ?,
					ru_creatorid = ?,
					ru_status = ?,
					ru_datecreated = ?,
					ru_datemodified = ?
				WHERE ru_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->type,
					(int)$this->value,
					(int)$this->objectid,
					(int)$this->subobjectid,
					(int)$this->creatorid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'role_user ru
				WHERE ru.ru_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['ru_id'];
		$this->type = $row['ru_type'];
		$this->value = $row['ru_value'];
		$this->objectid = $row['ru_objectid'];
		$this->subobjectid = $row['ru_subobjectid'];
		$this->creatorid = $row['ru_creatorid'];
		$this->status = $row['ru_status'];
		$this->datecreated = $row['ru_datecreated'];
		$this->datemodified = $row['ru_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'role_user
				WHERE ru_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where, $groupby)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'role_user ru';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($groupby)
		{
			$sql .= ' GROUP BY u_id , ru_objectid, ru_subobjectid ';
		}

		return $db->query($sql)->fetchColumn(0);
	}

	/**
	 * Get the record in the table with paginating and filtering
	 *
	 * @param string $where the WHERE condition in SQL string
	 * @param string $order the ORDER in SQL string
	 * @param string $limit the LIMIT in SQL string
	 */
	public static function getList($where, $order, $limit = '', $groupby)
	{
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'role_user ru';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($groupby)
		{
			$sql .= ' GROUP BY  u_id , ru_objectid , ru_subobjectid ';
		}

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myRoleUser = new Core_RoleUser();

			$myRoleUser->uid = $row['u_id'];
			$myRoleUser->id = $row['ru_id'];
			$myRoleUser->type = $row['ru_type'];
			$myRoleUser->value = $row['ru_value'];
			$myRoleUser->objectid = $row['ru_objectid'];
			$myRoleUser->subobjectid = $row['ru_subobjectid'];
			$myRoleUser->creatorid = $row['ru_creatorid'];
			$myRoleUser->status = $row['ru_status'];
			$myRoleUser->datecreated = $row['ru_datecreated'];
			$myRoleUser->datemodified = $row['ru_datemodified'];


            $outputList[] = $myRoleUser;
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
	public static function getRoleUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $groupby = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_type = '.(int)$formData['ftype'].' ';

		if($formData['fvalue'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_value = '.(int)$formData['fvalue'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['fsubobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_subobjectid = '.(int)$formData['fsubobjectid'].' ';

		if($formData['fcreatorid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_creatorid = '.(int)$formData['fcreatorid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_status = '.(int)$formData['fstatus'].' ';

		if(count($formData['ftypearr']) > 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_type IN('.implode(',', $formData['ftypearr']).') ';
		}


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'u_id ,ru_id, ru_objectid ' . $sorttype;
		elseif($sortby == 'objectid')
			$orderString = 'u_id, ru_objectid ' . $sorttype;
		elseif($sortby == 'subobjectid')
			$orderString = 'u_id , ru_subobjectid ' . $sorttype;
		else
			$orderString = 'u_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString, $groupby);
		else
			return self::getList($whereString, $orderString, $limit, $groupby);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public static function getRoleType($type ='')
	{
		$output = 0;
		switch ($type) {
			case 'delegate':
				$output = Core_RoleUser::TYPE_DELEGATE;
				break;

			case 'promotion':
				$output = Core_RoleUser::TYPE_PRODUCTPROMOTION;
				break;

			case 'order':
				$output = Core_RoleUser::TYPE_ORDER;
				break;

			case 'viewpromotion':
				$output = Core_RoleUser::TYPE_VIEWPROMOTION;
				break;
			case 'vieworder' :
				$output = Core_RoleUser::TYPE_VIEWORDER;
				break;
		}

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

	public static function getRoleValue($value='')
	{
		$role = 0;

		$value = trim(strtolower($value));

		switch ($value)
		{
			case 'view':
				$role = self::ROLE_READ;
				break;
			case 'change' :
				$role = self::ROLE_CHANGE;
				break;

			case 'verify' :
				$role = self::ROLE_VERIFY;
				break;
		}

		return $role;
	}

	public static function getRoleName($value = '')
	{
		$name = '';

		switch ($value)
		{
			case Core_RoleUser::ROLE_READ :
				$name = 'view';
				break;
			case Core_RoleUser::ROLE_CHANGE :
				$name = 'change';
				break;

			case Core_RoleUser::ROLE_VERIFY :
				$name = 'verify';
				break;
		}

		return $name;
	}

	public static function deleteRoles($uid = 0 , $subobjectid = 0)
	{
		global $db;

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'role_user
				WHERE u_id = ?
				AND ru_subobjectid = ?';

		$rowCount = $db->query($sql, array($uid , $subobjectid))->rowCount();

		return $rowCount;
	}

	/**
	* put your comment there...
	*
	* @param mixed $type
	* @param mixed $uid
	* @param mixed $objectid
	* @param mixed $subobjectid
	* @param mixed $rolevalue
	*/
	public static function checkRoleUser($type = 0 , $uid = 0 , $objectid = 0, $subobjectid = 0, $rolevalue=0, $status = 0)
	{
		global $db;
		$whereString = '';

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'role_user';

		if($type > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru_type = ' . (int)$type . ' ';

		if($uid > 0)
		    $whereString .= ($whereString != '' ? ' AND ' : '') . 'u_id = ' . (int)$uid . ' ';

		if($objectid > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru_objectid = ' . (int)$objectid . ' ';

		if($subobjectid > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru_subobjectid = ' . (int)$subobjectid . ' ';

		if($rolevalue > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru_value = ' . (int)$rolevalue . ' ';

		if($status > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru_status = ' . (int)$status . ' ';

		if($whereString != '')
		{
			$sql .= ' WHERE ' . $whereString;
		}

		$rowCount = $db->query($sql)->rowCount();


		if($rowCount > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function getParentrootcategory()
	{
		global $registry;

		$rootcategoryList = array();
		$roles = self::getRoleUsers(array('fuid' => $registry->me->id , 'ftype'=>self::TYPE_PRODUCTCATEGORY) , 'id' , 'ASC');
		if(count($roles) > 0)
		{
			foreach($roles as $role)
			{
				$category = new Core_Productcategory($role->objectid);
				$category->parent = Core_Productcategory::getFullParentProductCategorys($category->id);
				if(count($rootcategoryList) == 0)
				{
					$rootcategoryList[$category->parent[0]['pc_id']]  = new Core_Productcategory($category->parent[0]['pc_id']);
				}
				else
				{
					for($i = 0 ; $i < count($rootcategoryList) ; $i++)
					{
						if(!array_key_exists($category->parent[0]['pc_id'], $rootcategoryList))
						{
							$rootcategoryList[$category->parent[0]['pc_id']]  = new Core_Productcategory($category->parent[0]['pc_id']);
						}
					}
				}

			}
		}
		return $rootcategoryList;
	}

    public static function checkProductcategory($pcid = 0)
    {
        $pass = true;
        global $db;
        global $registry;

        if( (int)$pcid > 0 )
        {
            $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'role_user WHERE u_id = ? AND ru_objectid = ?';
            $rowCount = $db->query($sql , array( $registry->me->id , $pcid ))->fetchColumn(0);
            if($rowCount == 0)
            {
                $pass = false;
            }
        }

        return $pass;
    }

}
