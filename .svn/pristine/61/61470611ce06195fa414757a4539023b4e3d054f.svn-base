<?php

Class Core_Backend_Message extends Core_Backend_Object
{
	const TYPE_MAIL = 1;
	const TYPE_INVITATION = 3;
	const TYPE_FILESHARING = 5;


	public $mtid = 0;
	public $uidfrom = 0;
	public $uidto = 0;
	public $id = 0;
	public $readstatus = 0;
	public $ipaddress = '';
	public $ismultirecipient = 0;	//kiem tra xem message nay co duoc goi chung cho nhieu nguoi hay khong
	public $issenderdeleted = 0;	//kiem tra xem nguoi goi da xoa msg nay chua de ko phai liet ke trong danh sach tin nhan da goi (sent)
	public $type = 0;
	public $subject = '';	//email message
	public $summary = '';
	public $icon = 0;
	public $countfile = 0;	//number of file attached to this message
	public $fileidlist = '';	//file drive id list of filedrive
	public $datespamreported = 0;	//neu > 0, thi chinh la thoi diem ma recipient report message nay la spam
	public $datecreated = 0;
	public $datemodified = 0;
	public $actor = null;	//dung de hien thi danh sach message trong inbox cua ai do, day se la user khac voi user dang xem inbox

	public $recipients = array();	//mang uidto lay duoc tu getList dung GROUP_CONCAT(u_id_to)
	public $recipientList = array();	//mang chua danh sach object Core_User lay duoc tu $recipients

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }


    public function addData()
    {
        $this->datecreated = $this->datemodified = time();

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'message (
        			mt_id,
        			u_id_from,
        			u_id_to,
        			u_id_unread,
        			m_ipaddress,
        			m_ismultirecipient,
					m_type,
					m_subject,
        			m_summary,
					m_icon,
					m_countfile,
					m_fileidlist,
        			m_datecreated,
        			m_datemodified
        			)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
               (int)$this->mtid,
               (int)$this->uidfrom,
               (int)$this->uidto,
               (int)$this->uidunread,
               (int)Helper::getIpAddress(true),
               (int)$this->ismultirecipient,
               (int)$this->type,
               (string)$this->subject,
               (string)$this->summary,
               (int)$this->icon,
               (int)$this->countfile,
               (string)$this->fileidlist,
               (int)$this->datecreated,
               (int)$this->datemodified,
            ))->rowCount();

        $this->id = $this->db3->lastInsertId();


    	return $this->id;
    }

    /**
    * Insert multi line voi nhieu userid
    *
    * @param array $receiverList: danh sach userid
    */
    public function addDataToList($receiverList)
    {
		global $registry;

    	if(count($receiverList) > 0)
		{
			$this->datecreated  = $this->datemodified = time();
			$insertCount = 0;

			//de dam bao query khong bi qua dai
			//do su dung cau truc INSERT ..VALUES(...), (...), (...)
			//nen segment receiver list theo 1 segment size nao do de lam ngan cau query
			$segmentSize = 20;	//20 userids trong 1 segment
			$segments = array_chunk($receiverList, $segmentSize);
			for($i = 0, $count = count($segments); $i < $count; $i++)
			{
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'message(
							mt_id,
        					u_id_from,
        					u_id_to,
        					m_ipaddress,
        					m_ismultirecipient,
							m_type,
							m_subject,
        					m_summary,
							m_icon,
							m_countfile,
							m_fileidlist,
        					m_datecreated,
        					m_datemodified
							)
						VALUES';

				for($j = 0, $countj = count($segments[$i]); $j < $countj; $j++)
				{
					if($j > 0)
						$sql .= ', ';
					$sql .= '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ';
				}

				$stmt = $this->db3->prepare($sql);

				//bind data
				for($j = 0, $countj = count($segments[$i]); $j < $countj; $j++)
				{
					$stmt->bindValue($j * 13 + 1, (int)$this->mtid);
					$stmt->bindValue($j * 13 + 2, (int)$this->uidfrom);
					$stmt->bindValue($j * 13 + 3, $segments[$i][$j]);
					$stmt->bindValue($j * 13 + 4, (int)Helper::getIpAddress(true));
					$stmt->bindValue($j * 13 + 5, (int)$this->ismultirecipient);
					$stmt->bindValue($j * 13 + 6, (int)$this->type);
					$stmt->bindValue($j * 13 + 7, (string)$this->subject);
					$stmt->bindValue($j * 13 + 8, (string)$this->summary);
					$stmt->bindValue($j * 13 + 9, (int)$this->icon);
					$stmt->bindValue($j * 13 + 10, (int)$this->countfile);
					$stmt->bindValue($j * 13 + 11, (string)$this->fileidlist);
					$stmt->bindValue($j * 13 + 12, (int)$this->datecreated);
					$stmt->bindValue($j * 13 + 13, (int)$this->datemodified);


				}
				//execute prepared query
				$stmt->execute();
				$insertCount += $stmt->rowCount();


			}

			return $insertCount;
		}
		else
		{
			return 0;
		}
	}

    public function updateData($isupdatetime = true)
    {
    	if($isupdatetime)
    	{
    		$this->datemodified = time();
		}

        $sql = 'UPDATE ' . TABLE_PREFIX . 'message
                SET m_issenderdeleted = ?,
					m_type = ?,
					m_subject = ?,
                	m_summary = ?,
                	m_datespamreported = ?,
                	m_datemodified = ?
                WHERE m_id = ?';

        $stmt = $this->db3->query($sql, array(
                (int)$this->issenderdeleted,
                (int)$this->type,
                (string)$this->subject,
                (string)$this->summary,
                (int)$this->datespamreported,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message m
                WHERE m.m_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->mtid = $row['mt_id'];
        $this->uidfrom = $row['u_id_from'];
        $this->uidto = $row['u_id_to'];
        $this->id = $row['m_id'];
        $this->issenderdeleted = $row['m_issenderdeleted'];
        $this->ipaddress = long2ip($row['m_ipaddress']);
        $this->ismultirecipient = $row['m_ismultirecipient'];
        $this->type = $row['m_type'];
        $this->subject = $row['m_subject'];
        $this->summary = $row['m_summary'];
        $this->icon = $row['m_icon'];
        $this->countfile = $row['m_countfile'];
        $this->fileidlist = $row['m_fileidlist'];
        $this->datespamreported = $row['m_datespamreported'];
        $this->datecreated = $row['m_datecreated'];
        $this->datemodified = $row['m_datemodified'];
    }


    public function delete($deleteuserid)
    {

    	//kiem tra xem day la nguoi dau tien hay nguoi thu 2 xoa message nay
    	//neu day la nguoi dau tien thi ko xoa ma chi bat flag deleteuser la usernay
    	//neu day la nguoi thu 2 thi xoa toan bo thong tin message + reply vi message nay khong con hieu luc nua
    	if($this->uidfirstdelete == 0)
    	{
    		//chi set la delete ma thoi
    		$this->uidfirstdelete = $deleteuserid;
    		return $this->updateData(false);
		}
		elseif($this->uidfirstdelete != $deleteuserid)
		{
			//nguoi thu 2 xoa, tien hanh remove tat ca moi thuve message nay
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'message
	                WHERE m_id = ?';
	        $rowCount = $this->db3->query($sql, array($this->id))->rowCount();

	        //khong xoa messagetext neu message nay duoc goi cho nhieu nguoi, boi vi co the co nhung message khac su dung chung message text
	        //muon xoa co the dung 1 task background de check la messagetext khong dung trong bat ky message nao
	        //moi xoa, boi vi day la thao tac ton thoi gian
	        if(!$this->ismultirecipient)
	        {
	        	$myMessageText = new Core_Backend_MessageText();
		        $myMessageText->id = $this->mtid;
		        $myMessageText->delete();
			}

	        return $rowCount;
		}




    }


    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(DISTINCT mt_id)
				FROM ' . TABLE_PREFIX . 'message m ';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '')
    {
        $db3 = self::getDb();

        $sql = 'SELECT *, GROUP_CONCAT(u_id_to separator ",") as recipients
				FROM ' . TABLE_PREFIX . 'message m';


        if($where != '')
			$sql .= ' WHERE ' . $where;


		$sql .= ' GROUP BY mt_id';

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
        $stmt = $db3->query($sql, array());
        while($row = $stmt->fetch())
        {
            $myMessage = new Core_Backend_Message();
            $myMessage->mtid = $row['mt_id'];
	        $myMessage->uidfrom = $row['u_id_from'];
	        $myMessage->uidto = $row['u_id_to'];
	        $myMessage->id = $row['m_id'];
	        $myMessage->ipaddress = long2ip($row['m_ipaddress']);
	        $myMessage->issenderdeleted = $row['m_issenderdeleted'];
	        $myMessage->ismultirecipient = $row['m_ismultirecipient'];
	        $myMessage->type = $row['m_type'];
	        $myMessage->subject = $row['m_subject'];
	        $myMessage->summary = $row['m_summary'];
	        $myMessage->icon = $row['m_icon'];
	        $myMessage->countfile = $row['m_countfile'];
	        $myMessage->fileidlist = $row['m_fileidlist'];
	        $myMessage->datespamreported = $row['m_datespamreported'];
	        $myMessage->datecreated = $row['m_datecreated'];
	        $myMessage->datemodified = $row['m_datemodified'];
			$myMessage->recipients = explode(',', $row['recipients']);

            $outputList[] = $myMessage;
        }

        return $outputList;
    }

	public static function getMessages($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		global $registry;

		$whereString = '';


		if($formData['fuidfrom'] > 0 && count($formData['fuseridlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . ' (m.u_id_from = '.(int)$formData['fuidfrom'].' OR m.u_id_to IN ( '.implode(',', $formData['fuseridlist']).') )';
		elseif($formData['fuidfrom'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . ' m.u_id_from = '.(int)$formData['fuidfrom'].'';
		elseif(count($formData['fuseridlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.u_id_to IN ( '.implode(',', $formData['fuseridlist']).') ';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.m_id = '.(int)$formData['fid'].' ';

		if($formData['fmtid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.mt_id = '.(int)$formData['fmtid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.m_type = '.(int)$formData['ftype'].' ';

		if($formData['fissenderdeleted'] == 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.m_issenderdeleted = '.(int)$formData['fissenderdeleted'].' ';

		if(isset($formData['fhasattachment']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.m_countfile <>  0';

		//check with message status
		if(isset($formData['fisinbox']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.mt_id NOT IN (SELECT mts.mt_id FROM ' . TABLE_PREFIX . 'message_text_status mts WHERE mts.u_id = '.$registry->me->id.' AND mts.mts_status > '.Core_Backend_MessageTextStatus::STATUS_INBOX .')';
		}

		if(isset($formData['fisintrash']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.mt_id IN (SELECT mts.mt_id FROM ' . TABLE_PREFIX . 'message_text_status mts WHERE mts.u_id = '.$registry->me->id.' AND mts.mts_status = '.Core_Backend_MessageTextStatus::STATUS_INTRASH .')';
		}

		if(isset($formData['fisinfolder']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.mt_id IN (SELECT mts.mt_id FROM ' . TABLE_PREFIX . 'message_text_status mts WHERE mts.u_id = '.$registry->me->id.' AND mts.mts_status = '.Core_Backend_MessageTextStatus::STATUS_INFOLDER .' AND mts.mts_folderid = '.(int)$formData['fisinfolder'].')';
		}

		if(isset($formData['fisstarred']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.mt_id IN (SELECT mts.mt_id FROM ' . TABLE_PREFIX . 'message_text_status mts WHERE mts.u_id = '.$registry->me->id.' AND mts.mts_isstarred = 1 AND mts.mts_status < '.Core_Backend_MessageTextStatus::STATUS_INTRASH.')';
		}

		if(strlen($formData['fkeywordFilter']) > 0)
		{

			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'subject')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.m_subject LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'm.m_subject LIKE \'%'.$formData['fkeywordFilter'].'%\'';
		}



		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'id')
			$orderString = ' m.m_id ' . $sorttype;
		else
			$orderString = ' m.m_datemodified ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


   /**
   * Tim so luong tin nhan tai mot khoang thoi gian nao do
   *
   * @param mixed $start: start of range in timestamp
   * @param mixed $end: end of range in timestamp
   */
   	public static function countMyMessage($userid, $start, $end)
   	{
   		$db3 = self::getDb();

   		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'message
   				WHERE u_id_from = ? AND m_datecreated BETWEEN ? AND ? ';
   		return $db3->query($sql, array((int)$userid, (int)$start, (int)$end))->fetchColumn(0);
	}

	public function getMessagePath()
	{
		global $registry;

		$url = $registry->conf['rooturl_profile'] . 'message?mtid=' . $this->mtid;


		return $url;
	}

	/**
	 * Dua vao mtid de lay toan bo danh sach uidto
	 */
	public function getFullRecipients()
	{
		//co the dung cache danh sach User ID
		$sql = 'SELECT GROUP_CONCAT(u_id_to SEPARATOR ",") AS recipients
				FROM ' . TABLE_PREFIX . 'message
				WHERE mt_id = ?
				GROUP BY mt_id';
		$recipientstring = $this->db3->query($sql, array($this->mtid))->fetchColumn(0);
		$recipients = explode(',', $recipientstring);
		$recipientList = array();
		for($i = 0; $i < count($recipients); $i++)
		{
			$myUser = new Core_User($recipients[$i], true);
			if($myUser->id > 0)
			{
				$recipientList[] = $myUser;
			}
		}

		return $recipientList;

	}

	public static function markSenderDeleted($mtid, $senderid)
	{
		$db3 = self::getDb();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'message
				SET m_issenderdeleted = 1
				WHERE u_id_from = ?
					AND mt_id = ?';
		return $db3->query($sql, array(
			$senderid,
			$mtid
		))->rowCount();
	}
}
