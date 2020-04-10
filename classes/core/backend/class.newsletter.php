<?php

Class Core_Backend_Newsletter extends Core_Backend_Object
{
	public $id = 0;
	public $uid = 0;
	public $fromemail = '';
	public $fromname = '';
	public $subject = '';
	public $contents = '';
	public $sendcount = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $datelastsent = 0;
	public $actor = null;

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }




    public function addData()
    {

        $this->datecreated = time();

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'newsletter (
        			u_id,
        			n_fromemail,
        			n_fromname,
        			n_subject,
        			n_contents,
        			n_datecreated
        			)
                VALUES(?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
               (int)$this->uid,
               (string)$this->fromemail,
               (string)$this->fromname,
               (string)$this->subject,
               (string)$this->contents,
               (int)$this->datecreated,
            ))->rowCount();

        $this->id = $this->db3->lastInsertId();


    	return $this->id;
    }



    public function updateData()
    {
    	$this->datemodified = time();

        $sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter
                SET u_id = ?,
                	n_fromemail = ?,
                	n_fromname = ?,
                	n_subject = ?,
                	n_contents = ?,
                	n_datemodified = ?
                WHERE n_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->uid,
                (string)$this->fromemail,
                (string)$this->fromname,
                (string)$this->subject,
                (string)$this->contents,
                (int)$this->datemodified,
                (int)$this->id
            ));

    	if($stmt->rowCount() > 0)
    	{
    		return true;
		}else
    		return false;
    }



    public function getData($id)
    {
        $id = (int)$id;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newsletter n
                WHERE n.n_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->uid = $row['u_id'];
        $this->id = $row['n_id'];
        $this->fromemail = $row['n_fromemail'];
        $this->fromname = $row['n_fromname'];
        $this->subject = $row['n_subject'];
        $this->contents = $row['n_contents'];
        $this->sendcount = $row['n_sendcount'];
        $this->datecreated = $row['n_datecreated'];
        $this->datemodified = $row['n_datemodified'];
        $this->datelastsent = $row['n_datelastsent'];
        $this->actor = new Core_User($row['u_id'], true);
    }



    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'newsletter
                WHERE n_id = ?';
        $rowCount = $this->db3->query($sql, array($this->id))->rowCount();


        return $rowCount;
    }


    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'newsletter n';

        	$sql .= ' ';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '')
    {
        $db3 = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newsletter n';

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
            $myNewsletter = new Core_Backend_Newsletter();
            $myNewsletter->uid = $row['u_id'];
	        $myNewsletter->id = $row['n_id'];
	        $myNewsletter->fromemail = $row['n_fromemail'];
	        $myNewsletter->fromname = $row['n_fromname'];
	        $myNewsletter->subject = $row['n_subject'];
	        $myNewsletter->contents = $row['n_contents'];
	        $myNewsletter->sendcount = $row['n_sendcount'];
	        $myNewsletter->datecreated = $row['n_datecreated'];
	        $myNewsletter->datemodified = $row['n_datemodified'];
	        $myNewsletter->datelastsent = $row['n_datelastsent'];
	        $myNewsletter->actor = new Core_User($row['u_id'], true);

            $outputList[] = $myNewsletter;
        }
        return $outputList;
    }

	public static function getNewsletters($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.u_id = '.(int)$formData['fuserid'].' ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_subject LIKE \'%'.$formData['fkeywordFilter'].'%\'';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'id')
			$orderString = ' n.n_id ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = ' n.n_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = ' n.n_datemodified ' . $sorttype;
		elseif($sortby == 'sendcount')
			$orderString = ' n.n_sendcount ' . $sorttype;
		else
			$orderString = ' n.n_datelastsent ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}



	public function increaseSend()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter SET n_sendcount = n_sendcount + 1
	    		WHERE n_id = ?';
		$stmt = $this->db3->query($sql, array($this->id));
		return $stmt;
	}

	public function updateLastSentUser()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter SET u_id = ?
	    		WHERE n_id = ?';
		$stmt = $this->db3->query($sql, array($this->uid, $this->id));
		return $stmt;
	}


}


