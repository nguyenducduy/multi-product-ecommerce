<?php

Class Core_StatHook extends Core_Object
{
	const TYPE_LOGIN_MANUAL				= 1;
	const TYPE_LOGIN_REMEMBER			= 2;
	const TYPE_LOGIN_OAUTH				= 3;

	public $uid = 0;
	public $id = 0;
	public $type = 0;
	public $datecreated = 0;

	public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}

	public function addData()
	{
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stat_hook(
					u_id,
					s_type,
					s_datecreated)
				VALUES(?, ?, ?)';

		$rowCount = $this->db->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->type,
		    	(int)$this->datecreated
			))->rowCount();

		$this->id = $this->db->lastInsertId();

		return $this->id;
	}

	public function delete()
	{
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'stat_hook
        		WHERE s_id = ? ';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}


	private function getData($id)
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_hook
				WHERE s_id = ?';
		$row = $this->db->query($sql, array((int)$id))->fetch();
		$this->uid = $row['u_id'];
		$this->id = $row['s_id'];
		$this->type = $row['s_type'];
		$this->datecreated = $row['s_datecreated'];

		$this->actor = new Core_User();
		$this->actor->initMainInfo($row);
	}

	public static function countList($where)
	{
		global $db;
		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stat_hook';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db->query($sql)->fetchColumn(0);
	}

	public static function getList($where, $order , $limit = '')
	{
		global $db;
		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_hook';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myStat = new Core_StatHook();
			$myStat->uid = $row['u_id'];
			$myStat->id = $row['s_id'];
			$myStat->type = $row['s_type'];
			$myStat->datecreated = $row['s_datecreated'];
			$outputList[] = $myStat;
		}
		return $outputList;
	}

	public static function getStats($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u_id = '.(int)$formData['fuserid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's_type = '.(int)$formData['ftype'].' ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'type')
			$orderString = ' s_type ' . $sorttype;
		else
			$orderString = ' s_id ' . $sorttype;


		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

}


