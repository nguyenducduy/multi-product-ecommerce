<?php

Class Core_Backend_MessageBlock extends Core_Backend_Object
{
	public $uid = 0;
	public $id = 0;
	public $reason = 0;
	public $note = '';
	public $noteunblock = '';
	public $isunblock = 0;
	public $dateblocked = 0;
	public $dateunblocked = 0;

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }


    public function addData()
    {

        $this->datecreated = $this->datemodified = time();

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'message_block (
        			u_id,
        			mb_reason,
        			mb_note,
        			mb_noteunblock,
        			mb_isunblock,
        			mb_dateblocked,
        			mb_dateunblocked
        			)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
               (int)$this->uid,
               (int)$this->reason,
               (string)$this->note,
               (string)$this->noteunblock,
               (int)$this->isunblock,
               (int)$this->dateblocked,
               (int)$this->dateunblocked,
            ))->rowCount();

        $this->id = $this->db3->lastInsertId();


    	return $this->id;
    }

    public function updateData($isupdatetime = true)
    {
        $sql = 'UPDATE ' . TABLE_PREFIX . 'message_block
                SET mb_reason = ?,
                	mb_note = ?,
                	mb_noteunblock = ?,
                	mb_isunblock = ?,
                	mb_dateblocked = ?,
                	mb_dateunblocked = ?
                WHERE mb_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->reason,
                (string)$this->note,
                (string)$this->noteunblock,
                (int)$this->isunblock,
                (int)$this->dateblocked,
                (int)$this->dateunblocked,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_block mb
                WHERE mb.mb_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->uid = $row['u_id'];
        $this->id = $row['mb_id'];
        $this->reason = $row['mb_reason'];
        $this->note = $row['mb_note'];
        $this->noteunblock = $row['mb_noteunblock'];
        $this->isunblock = $row['mb_isunblock'];
        $this->dateblocked = $row['mb_dateblocked'];
        $this->dateunblocked = $row['mb_dateunblocked'];
    }


    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'message_block
                WHERE mb_id = ?';
        $rowCount = $this->db3->query($sql, array($this->id))->rowCount();

        return $rowCount;
    }


    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'message_block mb';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '')
    {
        $db3 = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_block mb';


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
            $myMessageBlock = new Core_Backend_MessageBlock();
            $myMessageBlock->uid = $row['u_id'];
	        $myMessageBlock->id = $row['mb_id'];
	        $myMessageBlock->reason = $row['mb_reason'];
	        $myMessageBlock->note = $row['mb_note'];
	        $myMessageBlock->noteunblock = $row['mb_noteunblock'];
	        $myMessageBlock->isunblock = $row['mb_isunblock'];
	        $myMessageBlock->dateblocked = $row['mb_dateblocked'];
	        $myMessageBlock->dateunblocked = $row['mb_dateunblocked'];

            $outputList[] = $myMessageBlock;
        }
        return $outputList;
    }

	public static function getBlocks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mb.mb_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mb.u_id = '.(int)$formData['fuserid'].' ';

		if($formData['fisunblock'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mb.u_isunblock = '.(int)$formData['fisunblock'].' ';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'id')
			$orderString = ' mb.mb_id ' . $sorttype;
		else
			$orderString = ' mb.mb_dateblocked ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}



}


