<?php

Class Core_ProfileAdvanced extends Core_Object
{

	const TYPE_WORK = 1;
	const TYPE_UNIVERSITY = 2;
	const TYPE_SCHOOL = 3;
	const TYPE_OTHER = 4;


	const SUBTYPESCHOOL_CAP3 = 1;
	const SUBTYPESCHOOL_CAP2 = 2;
	const SUBTYPESCHOOL_CAP1 = 3;
	const SUBTYPESCHOOL_MAMNON = 4;
	const SUBTYPESCHOOL_KHAC = 5;


	public $uid = 0;
    public $id = 0;
    public $type = 0;
    public $text1 = '';
    public $text2 = '';
    public $text3 = '';
    public $date1 = 0;
    public $date2 = 0;
    public $visibility = 0;
    public $datecreated = 0;
    public $datemodified = 0;

    public $date1_year = 0;
    public $date1_month = 0;
    public $date2_year = 0;
    public $date2_month = 0;


    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }


    public function addData()
    {

        $this->datecreated = time();

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'ac_user_profile_advanced (
        			u_id,
        			up_type,
        			up_text1,
        			up_text2,
        			up_text3,
        			up_date1,
        			up_date2,
        			up_visibility,
        			up_datecreated
        			)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
               (int)$this->uid,
               (int)$this->type,
               (string)$this->text1,
               (string)$this->text2,
               (string)$this->text3,
               (string)$this->date1,
               (string)$this->date2,
               (int)$this->visibility,
               (int)$this->datecreated
            ))->rowCount();

        $this->id = $this->db->lastInsertId();


    	return $this->id;
    }

    public function updateData()
    {
    	$this->datemodified = time();

        $sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile_advanced
                SET up_text1 = ?,
                	up_text2 = ?,
                	up_text3 = ?,
                	up_date1 = ?,
                	up_date2 = ?,
                	up_visibility = ?,
                	up_datemodified = ?
                WHERE up_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->text1,
                (string)$this->text2,
                (string)$this->text3,
                (string)$this->date1,
                (string)$this->date2,
                (int)$this->visibility,
                (int)$this->datemodified,
                (int)$this->id
            ));

    	if($stmt)
    		return true;
    	else
    		return false;
    }

    public function getData($id)
    {
        $id = (int)$id;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user_profile_advanced up
        		INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON up.u_id = u.u_id
                WHERE up.up_id = ?';
        $row = $this->db->query($sql, array($id))->fetch();

        $this->uid = $row['u_id'];
        $this->id = $row['up_id'];
        $this->type = $row['up_type'];
        $this->text1 = $row['up_text1'];
        $this->text2 = $row['up_text2'];
        $this->text3 = $row['up_text3'];
        $this->date1 = $row['up_date1'];
        $this->date2 = $row['up_date2'];
        $this->visibility = $row['up_visibility'];
        $this->datecreated = $row['up_datecreated'];
        $this->datemodified = $row['up_datemodified'];

        $date1Info = explode('-', $this->date1);
        $this->date1_year = (int)$date1Info[0];
        $this->date1_month = (int)$date1Info[1];

        $date2Info = explode('-', $this->date2);
        $this->date2_year = (int)$date2Info[0];
        $this->date2_month = (int)$date2Info[1];

        $this->actor = new Core_User();
        $this->actor->initMainInfo($row);
    }


    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'ac_user_profile_advanced
                WHERE up_id = ?';
        $rowCount = $this->db->query($sql, array($this->id))->rowCount();

        return $rowCount;
    }

    public static function countList($where)
    {
        global $db;

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user_profile_advanced up';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '', $getUserDetail = true)
    {
        global $db;

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user_profile_advanced up';


        if($getUserDetail)
        	$sql .= ' INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON up.u_id = u.u_id';


        if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
        $stmt = $db->query($sql, array());
        while($row = $stmt->fetch())
        {
            $myProfile = new Core_ProfileAdvanced();
            $myProfile->uid = $row['u_id'];
	        $myProfile->id = $row['up_id'];
	        $myProfile->type = $row['up_type'];
	        $myProfile->text1 = $row['up_text1'];
	        $myProfile->text2 = $row['up_text2'];
	        $myProfile->text3 = $row['up_text3'];
	        $myProfile->date1 = $row['up_date1'];
	        $myProfile->date2 = $row['up_date2'];
	        $myProfile->visibility = $row['up_visibility'];
	        $myProfile->datecreated = $row['up_datecreated'];
	        $myProfile->datemodified = $row['up_datemodified'];
            $date1Info = explode('-', $myProfile->date1);
	        $myProfile->date1_year = (int)$date1Info[0];
	        $myProfile->date1_month = (int)$date1Info[1];

	        $date2Info = explode('-', $myProfile->date2);
	        $myProfile->date2_year = (int)$date2Info[0];
	        $myProfile->date2_month = (int)$date2Info[1];
			if($getUserDetail)
            {
            	$myProfile->actor = new Core_User();
            	$myProfile->actor->initMainInfo($row);
			}

            $outputList[] = $myProfile;
        }
        return $outputList;
    }

	public static function getProfiles($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $getUserDetail = true)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.u_id = '.(int)$formData['fuserid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_type = '.(int)$formData['ftype'].' ';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'type')
			$orderString = ' up.up_type ' . $sorttype;
		else
			$orderString = ' up.up_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString, $getUserDetail);
		else
			return self::getList($whereString, $orderString, $limit, $getUserDetail);
	}

   	public static function isValidType($type)
	{
		$typeArray = array(1, 2, 3, 4);
		return in_array($type, $typeArray);
	}


	public static function getUserProfile($userid)
	{
		$profilelist = self::getProfiles(array('fuserid' => $userid), '', 'ASC', '');

		//sap xep theo nhom
		$profiles = array(self::TYPE_WORK => array(),
							self::TYPE_UNIVERSITY => array(),
							self::TYPE_SCHOOL => array(),
							self::TYPE_OTHER => array(),
						);

		for($i = 0, $cnt = count($profilelist); $i < $cnt; $i++)
		{
			$profiles[$profilelist[$i]->type][] = $profilelist[$i];
		}

		//sorting cac profile thuoc ve thoi gian cong viec
		if(!empty($profiles[self::TYPE_WORK]))
		{
			usort($profiles[self::TYPE_WORK], 'cmpTypeDateDesc');
		}

		//sorting cac profile thuoc ve truong dai hoc
		if(!empty($profiles[self::TYPE_UNIVERSITY]))
		{
			usort($profiles[self::TYPE_UNIVERSITY], 'cmpTypeDateDesc');
		}

		//sorting cac profile thuoc ve truong hoc
		if(!empty($profiles[self::TYPE_SCHOOL]))
		{
			usort($profiles[self::TYPE_SCHOOL], 'cmpTypeDateDesc');
		}

		return $profiles;
	}

	/**
	* Thuong thuong text3 thuong chua region id
	* su dung ham nay de lay region name tu text3
	*/
	public function getText3Region()
	{
		global $registry;

		if($this->text3 < 70)
			return $registry->setting['region'][$this->text3];
		else
			return '';
	}

	public function getText2Schooltype()
	{
		global $registry;
		$out = '';
		switch($this->text2)
		{
			case 1: $out = $registry->lang['controller']['schooltypecap3']; break;
			case 2: $out = $registry->lang['controller']['schooltypecap2']; break;
			case 3: $out = $registry->lang['controller']['schooltypecap1']; break;
			case 4: $out = $registry->lang['controller']['schooltypemamnon']; break;
			default: '';
		}
		return $out;
	}
}

/**
* Dung de sap xep cac record theo thoi gian tu moi toi cu cua cong viec/ truong hoc
*
* @param Core_ProfileAdvanced $p1
* @param Core_ProfileAdvanced $p2
*/
function cmpTypeDateDesc(Core_ProfileAdvanced $p1, Core_ProfileAdvanced $p2)
{
	$timestamp1 = strtotime($p1->date1);
	$timestamp2 = strtotime($p2->date1);

	if($timestamp1 > $timestamp2)
		return -1;
	elseif($timestamp1 < $timestamp2)
		return 1;
	else
		return 0;
}



