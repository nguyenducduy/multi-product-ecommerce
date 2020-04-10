<?php

/**
* Quan ly viec goi newsletter cho 1 email
*/
Class Core_Backend_NewsletterTask extends Core_Backend_Object
{
	public $nid = 0;
	public $id = 0;
	public $sendcount = 0;
	public $issent = 0;
	public $issentsuccess = 0;
	public $toname = '';
	public $toemail = '';
	public $touserid = 0;
	public $datecreated = 0;
	public $datelastsent = 0;

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }




    public function addData()
    {

        $this->datecreated = time();

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'newsletter_task (
        			n_id,
        			nt_sendcount,
        			nt_issent,
        			nt_issentsuccess,
        			nt_toname,
        			nt_toemail,
        			nt_touserid,
        			nt_datecreated,
        			nt_datelastsent
        			)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
               (int)$this->nid,
               (int)$this->sendcount,
               (int)$this->issent,
               (int)$this->issentsuccess,
               (string)$this->toname,
               (string)$this->toemail,
               (int)$this->touserid,
               (int)$this->datecreated,
               0,
            ))->rowCount();

        $this->id = $this->db3->lastInsertId();


    	return $this->id;
    }



    public function updateData()
    {
        $sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter_task
                SET n_id = ?,
                	nt_sendcount = ?,
                	nt_issent = ?,
                	nt_issentsuccess = ?,
                	nt_toname = ?,
                	nt_toemail = ?,
                	nt_touserid = ?,
                	nt_datelastsent = ?
                WHERE nt_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->nid,
                (int)$this->sendcount,
                (int)$this->issent,
                (int)$this->issentsuccess,
                (string)$this->toname,
                (string)$this->toemail,
                (int)$this->touserid,
                (int)$this->datelastsent,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newsletter_task nt
                WHERE nt.nt_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->nid = $row['n_id'];
        $this->id = $row['nt_id'];
        $this->sendcount = $row['nt_sendcount'];
        $this->issent = $row['nt_issent'];
        $this->issentsuccess = $row['nt_issentsuccess'];
        $this->toname = $row['nt_toname'];
        $this->toemail = $row['nt_toemail'];
        $this->touserid = $row['nt_touserid'];
        $this->datecreated = $row['nt_datecreated'];
        $this->datelastsent = $row['nt_datelastsent'];
    }



    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'newsletter_task
                WHERE nt_id = ?';
        $rowCount = $this->db3->query($sql, array($this->id))->rowCount();


        return $rowCount;
    }

    public static function deleteFromNewsletter($newsletterId)
    {
    	$db3 = self::getDb();

        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'newsletter_task
                WHERE n_id = ?';
        $rowCount = $db3->query($sql, array($newsletterId))->rowCount();


        return $rowCount;
    }

    public static function setSentStatusFromNewsletter($newsletterId, $status = 0)
    {
    	$db3 = self::getDb();

    	if($status != 0)
    		$status = 1;

        $sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter_task
                SET nt_issent = ?
                WHERE n_id = ?';
        $rowCount = $db3->query($sql, array($status, $newsletterId))->rowCount();
        return $rowCount;
    }



    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'newsletter_task nt';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '')
    {
        $db3 = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newsletter_task nt';

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
            $myNewsletterTask = new Core_Backend_NewsletterTask();
            $myNewsletterTask->nid = $row['n_id'];
	        $myNewsletterTask->id = $row['nt_id'];
	        $myNewsletterTask->sendcount = $row['nt_sendcount'];
	        $myNewsletterTask->issent = $row['nt_issent'];
	        $myNewsletterTask->issentsuccess = $row['nt_issentsuccess'];
	        $myNewsletterTask->toname = $row['nt_toname'];
	        $myNewsletterTask->toemail = $row['nt_toemail'];
	        $myNewsletterTask->touserid = $row['nt_touserid'];
	        $myNewsletterTask->datecreated = $row['nt_datecreated'];
	        $myNewsletterTask->datelastsent = $row['nt_datelastsent'];

            $outputList[] = $myNewsletterTask;
        }
        return $outputList;
    }

	public static function getTasks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.nt_id = '.(int)$formData['fid'].' ';

		if(count($formData['fidlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.nt_id IN ( '.implode(',', $formData['fidlist']).') ';

		if($formData['fnewsletterid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.n_id = '.(int)$formData['fnewsletterid'].' ';

		if(strlen($formData['fissent']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.nt_issent = '.(int)$formData['fissent'].' ';

		if(strlen($formData['fissentsuccess']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.nt_issentsuccess = '.(int)$formData['fissentsuccess'].' ';

		if(strlen($formData['femail']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.nt_toemail = "'.Helper::unspecialtext($formData['femail']).'" ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			$whereString .= ($whereString != '' ? ' AND ' : '') . 'nt.nt_toemail LIKE \'%'.$formData['fkeywordFilter'].'%\'';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'issent')
			$orderString = ' nt.nt_issent ' . $sorttype;
		if($sortby == 'issentsuccess')
			$orderString = ' nt.nt_issentsuccess ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = ' nt.nt_datecreated ' . $sorttype;
		elseif($sortby == 'datelastsent')
			$orderString = ' nt.nt_datelastsent ' . $sorttype;
		elseif($sortby == 'sendcount')
			$orderString = ' nt.nt_sendcount ' . $sorttype;
		else
			$orderString = ' nt.nt_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}



	public function increaseSend()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter_task SET nt_sendcount = nt_sendcount + 1
	    		WHERE nt_id = ?';
		$stmt = $this->db3->query($sql, array($this->id));
		return $stmt;
	}

	public function updateLastSent()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'newsletter_task SET nt_datelastsent = ?
	    		WHERE nt_id = ?';
		$stmt = $this->db3->query($sql, array(time(), $this->id));
		return $stmt;
	}


}


