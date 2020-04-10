<?php

/**
 * core/backend/class.scrumstory.php
 *
 * File contains the class used for ScrumStory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_ScrumStory extends Core_Backend_Object
{
	const STATUS_TODO = 1;
    const STATUS_DOING = 3;
    const STATUS_REVIEWING = 5;
    const STATUS_DONE = 7;

    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 3;
    const PRIORITY_HIGH = 5;
    const PRIORITY_HOT = 7;

	const Level_veryeasy = 1;
	const Level_easy     = 2;
	const Level_medium   = 3;
	const Level_hard     = 4;
	const Level_veryhard = 5;

    public $spid = 0;
	public $siid = 0;
	public $id = 0;
	public $asa = "";
	public $iwant = "";
	public $sothat = "";
	public $tag = "";
	public $point = 0;
	public $categoryid = 0;
	public $status = 0;
	public $priority = 0;
	public $level = 0;
	public $sssid = 0;
	public $displayorder = 0;
	public $datecompleted = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $iteration_name = '';
    public $storycategory_name = '';

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}

    public static function getStatusList()
    {
        global $lang;
        $output = array();
        $output[self::STATUS_TODO] = $lang['controller']['labelToDoStory'];//'To do';
        $output[self::STATUS_DOING] = $lang['controller']['labelDoingStory'];//'Doing';
        $output[self::STATUS_REVIEWING] = $lang['controller']['labelReviewingStory'];//'Reviewing';
        $output[self::STATUS_DONE] = $lang['controller']['labelDoneStory'];//'Done';

        return $output;
    }

    public function getStatusName()
    {
        global $lang;
        $name = '';

        switch($this->status)
        {
            case self::STATUS_TODO: $name = $lang['controller']['labelToDoStory']; break;
            case self::STATUS_DOING: $name = $lang['controller']['labelDoingStory']; break;
            case self::STATUS_REVIEWING: $name = $lang['controller']['labelReviewingStory']; break;
            case self::STATUS_DONE: $name = $lang['controller']['labelDoneStory']; break;
        }

        return $name;
    }

    public static function getPriorityList()
    {
        global $lang;
        $output = array();
        $output[self::PRIORITY_LOW] = $lang['controller']['labeLowPriority'];//'To do';
        $output[self::PRIORITY_MEDIUM] = $lang['controller']['labelMediumPriority'];//'Doing';
        $output[self::PRIORITY_HIGH] = $lang['controller']['labelHighPriority'];//'Reviewing';
        $output[self::PRIORITY_HOT] = $lang['controller']['labelHotPriority'];//'Done';

        return $output;
    }

    public function getPriorityName()
    {
        global $lang;
        $name = '';

        switch($this->priority)
        {
            case self::PRIORITY_LOW: $name = $lang['controller']['labeLowPriority']; break;
            case self::PRIORITY_MEDIUM: $name = $lang['controller']['labelMediumPriority']; break;
            case self::PRIORITY_HIGH: $name = $lang['controller']['labelHighPriority']; break;
            case self::PRIORITY_HOT: $name = $lang['controller']['labelHotPriority']; break;
        }

        return $name;
    }

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_story (
					sp_id,
					si_id,
					ss_asa,
					ss_iwant,
					ss_sothat,
					ss_tag,
					ss_point,
					ss_categoryid,
					sss_id,
					ss_status,
					ss_priority,
					ss_level,
					ss_displayorder,
					ss_datecompleted,
					ss_datecreated,
					ss_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->spid,
					(int)$this->siid,
					(string)$this->asa,
					(string)$this->iwant,
					(string)$this->sothat,
					(string)$this->tag,
					(float)$this->point,
					(int)$this->categoryid,
					(int)$this->sssid,
					(int)$this->status,
					(int)$this->priority,
					(int)$this->level,
					(int)$this->displayorder,
					(int)$this->datecompleted,
					(int)$this->datecreated,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story
				SET sp_id = ?,
					si_id = ?,
					ss_asa = ?,
					ss_iwant = ?,
					ss_sothat = ?,
					ss_tag = ?,
					ss_point = ?,
					ss_categoryid = ?,
					sss_id = ?,
					ss_status = ?,
					ss_priority = ?,
					ss_level = ?,
					ss_displayorder = ?,
					ss_datecompleted = ?,
					ss_datecreated = ?,
					ss_datemodified = ?
				WHERE ss_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->spid,
					(int)$this->siid,
					(string)$this->asa,
					(string)$this->iwant,
					(string)$this->sothat,
					(string)$this->tag,
					(float)$this->point,
					(int)$this->categoryid,
					(int)$this->sssid,
					(int)$this->status,
					(int)$this->priority,
					(int)$this->level,
					(int)$this->displayorder,
					(int)$this->datecompleted,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}
	public static function updateDataDeleteIteration($id)
	{
		$db3 = self::getDb();
		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story
				SET
					si_id = "0"
				WHERE si_id = "'.$id.'"';
		$stmt = $db3->query($sql);

		if($stmt)
			return true;
		else
			return false;
	}
	public static function updateDataDeleteCategory($id)
	{
		$db3 = self::getDb();
		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story
				SET
					ss_categoryid = ?
				WHERE ss_id = ?';
		$stmt = $db3->query($sql, array(
					"0",
					$id
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story ss
				WHERE ss.ss_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->spid = $row['sp_id'];
		$this->siid = $row['si_id'];
		$this->id = $row['ss_id'];
		$this->asa = $row['ss_asa'];
		$this->iwant = $row['ss_iwant'];
		$this->sothat = $row['ss_sothat'];
		$this->tag = $row['ss_tag'];
		$this->point = $row['ss_point'];
		$this->categoryid = $row['ss_categoryid'];
		$this->sssid = $row['sss_id'];
		$this->status = $row['ss_status'];
		$this->priority = $row['ss_priority'];
		$this->level = $row['ss_level'];
		$this->displayorder = $row['ss_displayorder'];
		$this->datecompleted = $row['ss_datecompleted'];
		$this->datecreated = $row['ss_datecreated'];
		$this->datemodified = $row['ss_datemodified'];
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story
				WHERE ss_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
    public static function deleteByproject($id)
    {
    	$db3 = self::getDb();
    	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story
				WHERE sp_id = ?';
		$rowCount = $db3->query($sql, array($id))->rowCount();
		Core_Backend_ScrumStoryComment::deleteByStoryDelete($id);
		Core_Backend_ScrumStoryAsignee::deleteByStoryDelete($id);
		return $rowCount;
    }
    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = Core_Backend_Object::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_story ss
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON ss.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
		WHERE '.TABLE_PREFIX.'scrum_project.sp_status <> 1
		';

		if($where != '')
			$sql .=  " AND ".$where;


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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story ss
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON ss.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
		WHERE '.TABLE_PREFIX.'scrum_project.sp_status <> 1
		';

		if($where != '')
			$sql .=  " AND ".$where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;
		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myScrumStory = new Core_Backend_ScrumStory();

			$myScrumStory->spid = $row['sp_id'];
			$myScrumStory->siid = $row['si_id'];
			$myScrumStory->id = $row['ss_id'];
			$myScrumStory->asa = $row['ss_asa'];
			$myScrumStory->iwant = $row['ss_iwant'];
			$myScrumStory->sothat = $row['ss_sothat'];
			$myScrumStory->tag = $row['ss_tag'];
			$myScrumStory->point = $row['ss_point'];
			$myScrumStory->categoryid = $row['ss_categoryid'];
			$myScrumStory->sssid = $row['sss_id'];
			$myScrumStory->status = $row['ss_status'];
			$myScrumStory->priority = $row['ss_priority'];
			$myScrumStory->level = $row['ss_level'];
			$myScrumStory->displayorder = $row['ss_displayorder'];
			$myScrumStory->datecompleted = $row['ss_datecompleted'];
			$myScrumStory->datecreated = $row['ss_datecreated'];
			$myScrumStory->datemodified = $row['ss_datemodified'];


            $outputList[] = $myScrumStory;
        }

        return $outputList;
    }
	public static function  getlevel()
	{
		$outpur = array();
		$outpur[self::Level_veryeasy] = 'Very Easy';
		$outpur[self::Level_easy] = 'Easy';
		$outpur[self::Level_medium] = 'Medium';
		$outpur[self::Level_hard] = 'Hard';
		$outpur[self::Level_veryhard] = 'Very Hard';
		return $outpur;
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

	public static function getScrumStorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';
		if($formData['fspid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sp_id = '.(int)$formData['fspid'].' ';

		if(isset($formData['fsiid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.si_id = '.(int)$formData['fsiid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_id = '.(int)$formData['fid'].' ';

		if($formData['fasa'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_asa = "'.Helper::unspecialtext((string)$formData['fasa']).'" ';

		if($formData['fiwant'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_iwant = "'.Helper::unspecialtext((string)$formData['fiwant']).'" ';

		if($formData['fsothat'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_sothat = "'.Helper::unspecialtext((string)$formData['fsothat']).'" ';

		if($formData['ftag'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_tag = "'.Helper::unspecialtext((string)$formData['ftag']).'" ';

		if($formData['fpoint'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_point = '.(float)$formData['fpoint'].' ';

		if($formData['fcategoryid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_categoryid = '.(int)$formData['fcategoryid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_status = '.(int)$formData['fstatus'].' ';

		if($formData['fpriority'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_priority = '.(int)$formData['fpriority'].' ';

		if($formData['flevel'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_level = '.(int)$formData['flevel'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fdatecompleted'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_datecompleted = '.(int)$formData['fdatecompleted'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_datemodified = '.(int)$formData['fdatemodified'].' ';

		if($formData['fsssid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sss_id = '.(int)$formData['fsssid'].' ';




		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'asa')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_asa LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'iwant')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_iwant LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'sothat')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_sothat LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'tag')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_tag LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ss.ss_asa LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ss.ss_iwant LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ss.ss_sothat LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ss.ss_tag LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}
		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'spid')
			$orderString = 'sp_id ' . $sorttype;
		elseif($sortby == 'siid')
			$orderString = 'si_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ss_id ' . $sorttype;
		elseif($sortby == 'asa')
			$orderString = 'ss_asa ' . $sorttype;
		elseif($sortby == 'iwant')
			$orderString = 'ss_iwant ' . $sorttype;
		elseif($sortby == 'sothat')
			$orderString = 'ss_sothat ' . $sorttype;
		elseif($sortby == 'tag')
			$orderString = 'ss_tag ' . $sorttype;
		elseif($sortby == 'point')
			$orderString = 'ss_point ' . $sorttype;
		elseif($sortby == 'categoryid')
			$orderString = 'ss_categoryid ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'ss_status ' . $sorttype;
		elseif($sortby == 'priority')
			$orderString = 'ss_priority ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'ss_displayorder ' . $sorttype;
		elseif($sortby == 'datecompleted')
			$orderString = 'ss_datecompleted ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ss_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ss_datemodified ' . $sorttype;
		else
			$orderString = 'ss_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


   public static function getScrumStorysJoinIterationCategory($formData, $sortby, $sorttype)
    {
        $db3 = self::getDb();
        $whereString = '';


        if($formData['fspid'] > 0){
            if(is_numeric($formData['fspid'])){
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sp_id = '.(int)$formData['fspid'].' ';
            }else $whereString .= ($whereString != '' ? ' AND ' : '') . 'si.si_name like "%'.Helper::plaintext((string)$formData['fspid']).'%" ';
        }
            //

        if($formData['fsiid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.si_id = '.(int)$formData['fsiid'].' ';

        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_id = '.(int)$formData['fid'].' ';

        if(isset($formData['fibacklogstory']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.si_id = '.(int)$formData['fibacklogstory'].' ';

        if($formData['fpoint'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_point = '.(float)$formData['fpoint'].' ';

        if($formData['fcategoryid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.`ss_categoryid` = "'.(int)$formData['fcategoryid'].'" ';

        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_id = '.(int)$formData['fid'].' ';

        if($formData['fsummary'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_summary = "'.Helper::unspecialtext((string)$formData['fsummary']).'" ';

        if($formData['fdetail'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_detail = "'.Helper::unspecialtext((string)$formData['fdetail']).'" ';

        if($formData['ftag'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_tag = "'.Helper::unspecialtext((string)$formData['ftag']).'" ';

        if($formData['fpoint'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_point = '.(float)$formData['fpoint'].' ';

        //if($formData['fcategoryid'] > 0)
//            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_categoryid = '.(int)$formData['fcategoryid'].' ';

        if($formData['fstatus'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_status = '.(int)$formData['fstatus'].' ';

        if($formData['fpriority'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_priority = '.(int)$formData['fpriority'].' ';

        if($formData['fdisplayorder'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_displayorder = '.(int)$formData['fdisplayorder'].' ';

        if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'summary')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'detail')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_detail LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'tag')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_tag LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (ss.ss_summary LIKE \'%'.Helper::plaintext($formData['fkeywordFilter']).'%\') OR (ss.ss_detail LIKE \'%'.Helper::plaintext($formData['fkeywordFilter']).'%\') OR (ss.ss_tag LIKE \'%'.Helper::plaintext($formData['fkeywordFilter']).'%\') )';
        }

        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'id')
            $orderString = 'ss_id ' . $sorttype;
        elseif($sortby == 'summary')
            $orderString = 'ss_summary ' . $sorttype;
        elseif($sortby == 'detail')
            $orderString = 'ss_detail ' . $sorttype;
        elseif($sortby == 'point')
            $orderString = 'ss_point ' . $sorttype;
        elseif($sortby == 'categoryid')
            $orderString = 'ss_categoryid ' . $sorttype;
        elseif($sortby == 'status')
            $orderString = 'ss_status ' . $sorttype;
        elseif($sortby == 'datecompleted')
            $orderString = 'ss_datecompleted ' . $sorttype;
        elseif($sortby == 'datecreated')
            $orderString = 'ss_datecreated ' . $sorttype;
        elseif($sortby == 'datemodified')
            $orderString = 'ss_datemodified ' . $sorttype;
        else
            $orderString = 'ss_id ' . $sorttype;

        $sql = 'SELECT
                ss.*,
                ssc.ssc_name,
                si.si_name
                FROM (' . TABLE_PREFIX . 'scrum_iteration si RIGHT JOIN ' . TABLE_PREFIX . 'scrum_story AS ss ON si.si_id = ss.si_id)
                LEFT JOIN ' . TABLE_PREFIX . 'scrum_story_category ssc ON ssc.ssc_id = ss.ss_categoryid';

        /*if(isset($formData['fibacklogstory'])){

        }
        else {
            $sql = 'SELECT
                ss.*,
                ssc.ssc_name,
                si.si_name
                FROM (' . TABLE_PREFIX . 'scrum_iteration si INNER JOIN ' . TABLE_PREFIX . 'scrum_story AS ss ON si.si_id = ss.si_id)
                LEFT JOIN ' . TABLE_PREFIX . 'scrum_story_category ssc ON ssc.ssc_id = ss.ss_categoryid';
        }*/

        $outputList = array();
        if(!empty($whereString)) $whereString = ' WHERE '.$whereString;
        //echo $sql.$whereString;
        $stmt = $db3->query($sql.$whereString);
        while($row = $stmt->fetch())
        {
            $myScrumStory = new Core_Backend_ScrumStory();

            $myScrumStory->spid = $row['sp_id'];
			$myScrumStory->siid = $row['si_id'];
			$myScrumStory->id = $row['ss_id'];
			$myScrumStory->asa = $row['ss_asa'];
			$myScrumStory->iwant = $row['ss_iwant'];
			$myScrumStory->sothat = $row['ss_sothat'];
			$myScrumStory->tag = $row['ss_tag'];
			$myScrumStory->point = $row['ss_point'];
			$myScrumStory->categoryid = $row['sss_id'];
			$myScrumStory->sssid = $row['ss_categoryid'];
			$myScrumStory->level = $row['ss_level'];
			$myScrumStory->status = $row['ss_status'];
			$myScrumStory->priority = $row['ss_priority'];
			$myScrumStory->displayorder = $row['ss_displayorder'];
			$myScrumStory->datecompleted = $row['ss_datecompleted'];
			$myScrumStory->datecreated = $row['ss_datecreated'];
			$myScrumStory->datemodified = $row['ss_datemodified'];

            $myScrumStory->storycategoryName = $row['ssc_name'];
            $myScrumStory->iterationName = $row['si_name'];
            $outputList[] = $myScrumStory;
        }

        return $outputList;
    }

    public static function countListFilterProjectCategory($sp_id, $ss_categoryid)
    {
        $whereSS = 'ss.sp_id = '.(int)$sp_id.' AND ss_categoryid = '.(int)$ss_categoryid;
        return Core_Backend_ScrumStory::countList($whereSS);
    }

	public static  function statstorydone($id , $date)
	{
		$db3 = Core_Backend_Object::getDb();
		$sql = "select count(*) as dem from lit_scrum_story where ss_status = ".Core_Backend_ScrumStory::STATUS_DONE." AND si_id = " .$id." AND ss_datecompleted = ".$date ;
		$rs = $db3->query($sql)->fetch();
		return $rs['dem'];
	}
	public static  function statstorynotdone($id,$date)
	{
		$db3 = Core_Backend_Object::getDb();
		$sql = "select count(*) as dem from lit_scrum_story where ss_status != ".Core_Backend_ScrumStory::STATUS_DONE." AND si_id = " .$id." AND ss_datecompleted = ".$date ;
		$rs = $db3->query($sql)->fetch();
		return $rs['dem'];
	}
}