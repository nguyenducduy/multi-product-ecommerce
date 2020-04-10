<?php

Class Core_Backend_MutualfriendHidelog extends Core_Backend_Object
{
	public $uid = 0;
	public $uid_friend = 0;
	public $id = 0;
	public $datecreated = 0;
	
	public function __construct($id = 0)
	{
		parent::__construct($id);                
		
		if($id > 0)
			$this->getData($id);
	}
	
	public function addData()
	{
		$this->datecreated = time();
	
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'mutual_friend_hidelog(
					u_id,
					u_id_friend,
					mh_datecreated
					)
				VALUES(?, ?, ?)';  
				
		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->uid_friend,
		    	(int)$this->datecreated
			))->rowCount();
			
		$this->id = $this->db3->lastInsertId();
		
		return $this->id;
	}
	
	
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'mutual_friend_hidelog
        		WHERE mh_id =  ? ';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();
		
		return $rowCount;
	}
	
	
	
}


