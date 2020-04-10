<?php

Class Core_Backend_FeedComment extends Core_Backend_Object
{
	public $uid = 0;
	public $fid = 0;
	public $id = 0;
	public $text = '';
	public $ipaddress = '';
	public $datecreated = 0;
	public $actor = null;
	
	public $entityList = array();	//List of user/book mentioned in this FeedComment
	
	public function __construct($id = 0)
	{
		parent::__construct($id);                
		
		if($id > 0)
			$this->getData($id);
	}
	
	public function addData()
	{
		$this->datecreated = time();
	
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'feed_comment(
					u_id,
					f_id,
					fc_text,
					fc_ipaddress,
					fc_datecreated
					)
				VALUES(?, ?, ?, ?, ?)';  
				
		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->fid,
		    	(string)$this->text,
		    	(int)Helper::getIpAddress(true),
		    	(int)$this->datecreated
			))->rowCount();
			
		$this->id = $this->db3->lastInsertId();
		
		return $this->id;
	}
	
	public function updateData()
	{
		
		$sql = 'UPDATE ' . TABLE_PREFIX . 'feed_comment
				SET fc_text = ?
        		WHERE fc_id =  ? ';
		$stmt = $this->db3->query($sql, array( 
			(string)$this->text,
			$this->id));
		
		if($stmt)
			return true;
		else
			return false;
	}
	
	
	/**
	* 
	*/
	public function delete($feedId = 0)
	{
		if($feedId > 0)
		{
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feed_comment
        			WHERE f_id =  ? ';
			$rowCount = $this->db3->query($sql, array((int)$feedId))->rowCount();
		}
		else
		{
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feed_comment
        			WHERE fc_id =  ? ';
			$rowCount = $this->db3->query($sql, array($this->id))->rowCount();
		}
		
		return $rowCount;
	}
	
	/**
	* Ham xoa tat ca record dua theo 1 feed
	* 
	* Thuong duoc goi sau khi xoa 1 feed tu Core_Backend_feed
	* 
	* @param int $feedId
	*/
	public static function deleteFromFeed($feedId)
	{
		$db3 = self::getDb();
		
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feed_comment
        		WHERE f_id =  ? ';
		$rowCount = $db3->query($sql, array((int)$feedId))->rowCount();
		
		return $rowCount;
	}
	
	private function getData($id)
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'feed_comment fc
				WHERE fc_id = ? ';
		$row = $this->db3->query($sql, array((int)$id))->fetch();
		$this->uid = $row['u_id'];
		$this->fid = $row['f_id'];
		$this->id = $row['fc_id'];
		$this->text = $row['fc_text'];
		$this->ipaddress = long2ip($row['fc_ipaddress']);
		$this->datecreated = $row['fc_datecreated'];
		$this->actor = new Core_User($row['u_id'], true);
	}
	
	public static function getList($where, $order, $limit = '')
	{
		$db3 = self::getDb();
		
		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'feed_comment fc';
		
		if($where != '')
			$sql .= ' WHERE ' . $where;
			
		if($order != '')
			$sql .= ' ORDER BY ' . $order;
				
		if($limit != '')
			$sql .= ' LIMIT ' . $limit;
				
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myFeedComment = new Core_Backend_FeedComment();
			$myFeedComment->uid = $row['u_id'];
			$myFeedComment->fid = $row['f_id'];
			$myFeedComment->id = $row['fc_id'];
			$myFeedComment->text = $row['fc_text'];
			//nice message string, prevent repeat character
			$myFeedComment->text = preg_replace('/([a-z])\1{4,}/i', '<b>\1\1\1\1</b>', $myFeedComment->text);
		
		
			$myFeedComment->ipaddress = long2ip($row['fc_ipaddress']);
			$myFeedComment->datecreated = $row['fc_datecreated'];
			$myFeedComment->actor = new Core_User($row['u_id'], true);
		
			$outputList[] = $myFeedComment;
		}
		
		return $outputList;
	}
	
	public static function getComments($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';
		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fc.fc_id = '.(int)$formData['fid'].' ';
		
		if($formData['ffeedid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fc.f_id = '.(int)$formData['ffeedid'].' ';
		
		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fc.u_id = '.(int)$formData['fuserid'].' ';
		
		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'ASC';
			
		if($sortby == 'id')
			$orderString = ' fc.fc_id ' . $sorttype;    
		else
			$orderString = ' fc.fc_id ' . $sorttype;   
				
				
		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}
	
	/**
	* tra ve noi dung comment sau khi da format, cac dangj co dau @abc deu se thanh link toi user do
	* 
	*/
	public function getFormatedText()
	{
		global $registry;
		
		$out = $this->text;
		
		
		$out = preg_replace('/(@([a-z0-9.]+))/', '<a href="'.$registry->conf['rooturl'].'\2">\1</a>', $out);
		$out = nl2br($out);
		
		return $out;
	}
	
	
	/**
	 * Return formated text comment after extract mention link
	 */
	public function getText()
	{
		$this->message = Helper::plaintext($this->text);
		
		$this->message = Helper::mentionParsing($this->message, $this->entityList);
		
		return $this->message;
	}
	
	/**
	 * Check xem user nay co the edit
	 */
	public function canEdit($userid)
	{
		global $registry;
		return ($userid == $this->uid && (time() - $this->datecreated <= $registry->setting['feedcomment']['ownerEditExpire']));
	}
	
	/**
	 * Check xem user nay co the edit
	 */
	public function canDelete($userid)
	{
		global $registry;
		
		return ($userid == $this->uid && (time() - $this->datecreated <= $registry->setting['feedcomment']['ownerEditExpire']));
	}
	
	
	
}



