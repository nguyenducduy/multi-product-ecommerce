<?php

Class Core_Backend_MessageReply extends Core_Backend_Object
{
	public $mid = 0;
	public $uid = 0;
	public $uidfirstdelete = 0;
	public $id = 0;
	public $text = '';
	public $ipaddress = '';
	public $datecreated = 0;
	public $actor = null;

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }


    public function addData()
    {

        $this->datecreated  = time();

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'message_reply (
        			m_id,
        			u_id,
        			u_id_firstdelete,
        			mr_text,
        			mr_ipaddress,
        			mr_datecreated
        			)
                VALUES(?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
               (int)$this->mid,
               (int)$this->uid,
               (int)$this->uidfirstdelete,
               (string)$this->text,
               (int)Helper::getIpAddress(true),
               (int)$this->datecreated,
            ))->rowCount();

        $this->id = $this->db3->lastInsertId();


    	return $this->id;
    }


    public function updateData()
    {

        $sql = 'UPDATE ' . TABLE_PREFIX . 'message_reply
                SET u_id_firstdelete = ?
                WHERE mr_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->uidfirstdelete,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_reply mr
                WHERE mr.mr_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->mid = $row['m_id'];
        $this->uid = $row['u_id'];
        $this->uidfirstdelete = $row['u_id_firstdelete'];
        $this->id = $row['mr_id'];
        $this->text = $row['mr_text'];
        $this->ipaddress = long2ip($row['mr_ipaddress']);
        $this->datecreated = $row['mr_datecreated'];
    }


    public function delete($deleteuserid)
    {
    	//kiem tra xem day la nguoi dau tien hay nguoi thu 2 xoa reply nay
    	//neu day la nguoi dau tien thi ko xoa ma chi bat flag deleteuser la user nay
    	//neu day la nguoi thu 2 thi xoa toan bo thong tin message + reply vi message nay khong con hieu luc nua
    	if($this->uidfirstdelete == 0)
    	{
    		//chi set la delete ma thoi
    		$this->uidfirstdelete = $deleteuserid;
    		return $this->updateData();
		}
		elseif($this->uidfirstdelete != $deleteuserid)
		{
			//nguoi thu 2 xoa, tien hanh remove tat ca moi thuve message nay
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'message_reply
	                WHERE mr_id = ?';
	        $rowCount = $this->db3->query($sql, array($this->id))->rowCount();

	        return $rowCount;
		}
    }

    public static function deleteFromMessage($messageid)
    {
    	$db3 = self::getDb();
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'message_reply
                WHERE m_id = ?';
        $rowCount = $db3->query($sql, array($messageid))->rowCount();
        return $rowCount;
    }


    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'message_reply mr';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '')
    {
        $db3 = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_reply mr';


        if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
        $stmt = $db3->query($sql, array());
        while($row = $stmt->fetch())
        {
            $myMessageReply = new Core_Backend_MessageReply();
            $myMessageReply->mid = $row['m_id'];
	        $myMessageReply->uid = $row['u_id'];
	        $myMessageReply->uidfirstdelete = $row['u_id_firstdelete'];
	        $myMessageReply->id = $row['mr_id'];
	        $myMessageReply->text = $row['mr_text'];
	        $myMessageReply->ipaddress = long2ip($row['mr_ipaddress']);
	        $myMessageReply->datecreated = $row['mr_datecreated'];

            $outputList[] = $myMessageReply;
        }
        return $outputList;
    }

	public static function getReplies($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mr.mr_id = '.(int)$formData['fid'].' ';

		if(count($formData['fidlist']) > 0 && is_array($formData['fidlist']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mr.mr_id IN ( '.implode(',', $formData['fidlist']).' )';

		if($formData['fmessageid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mr.m_id = '.(int)$formData['fmessageid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mr.u_id = '.(int)$formData['fuserid'].' ';

		if($formData['freplystart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mr.mr_id >= '.(int)$formData['freplystart'].' ';

		if($formData['fusernotdelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mr.u_id_firstdelete <> '.(int)$formData['fusernotdelete'].' ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'id')
			$orderString = ' mr.mr_id ' . $sorttype;
		else
			$orderString = ' mr.mr_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

}


