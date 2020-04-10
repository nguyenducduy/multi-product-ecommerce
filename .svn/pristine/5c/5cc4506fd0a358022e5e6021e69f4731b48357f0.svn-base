<?php

Class Core_Backend_FeedLike extends Core_Backend_Object
{
	public $uid = 0;
	public $fid = 0;
	public $id = 0;
	public $datecreated = 0;
	public $actor = null;


	public function __construct($id = 0)
	{
		parent::__construct($id);

		if($id > 0)
			$this->getData($id);
	}

	public function addData()
	{
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'feed_like(
					u_id,
					f_id,
					fl_datecreated
					)
				VALUES(?, ?, ?)';

		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->fid,
		    	(int)$this->datecreated
		))->rowCount();

		$this->id = $this->db3->lastInsertId();

		return $this->id;
	}

	public static function deleteFromFeed($feedId)
	{
		$db3 = self::getDb();
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feed_like
        			WHERE f_id =  ? ';
		$rowCount = $db3->query($sql, array((int)$feedId))->rowCount();
		return $rowCount;
	}

	/**
	*
	*/
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feed_like
        		WHERE fl_id =  ? ';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public static function countList($where, $getUserDetail = false)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'feed_like fl';

        if($getUserDetail)
			$sql .= ' INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON fl.u_id = u.u_id     ';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

	public static function getList($where, $order, $limit = '', $getUserDetail = false)
	{
		$db3 = self::getDb();

		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'feed_like fl';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myFeedLike = new Core_Backend_FeedLike();
			$myFeedLike->uid = $row['u_id'];
			$myFeedLike->fid = $row['f_id'];
			$myFeedLike->id = $row['fl_id'];
			$myFeedLike->datecreated = $row['fl_datecreated'];

			if($getUserDetail)
			{
			 	$myFeedLike->actor = new Core_User($row['u_id'], true);
			}

			$outputList[] = $myFeedLike;
		}
		return $outputList;
	}

	public static function getFeedLikes($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $getUserDetail = false)
	{

		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fl.fl_id = '.(int)$formData['fid'].' ';

		if($formData['ffeedid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fl.f_id = '.(int)$formData['ffeedid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fl.u_id = '.(int)$formData['fuserid'].' ';

		//$orderString = ' fl.fl_id ASC';


		if($countOnly)
			return self::countList($whereString, $getUserDetail);
		else
			return self::getList($whereString, $orderString, $limit, $getUserDetail);
	}





}


