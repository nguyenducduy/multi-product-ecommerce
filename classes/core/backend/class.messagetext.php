<?php

Class Core_Backend_MessageText extends Core_Backend_Object
{

    public $id = 0;
    public $subject = '';
    public $text = '';

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }


    public function addData()
    {

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'message_text (
					mt_subject,
        			mt_text
        			)
                VALUES(?, ?)';
        $rowCount = $this->db3->query($sql, array(
               (string)$this->subject,
               (string)$this->text,
            ))->rowCount();

        $this->id = $this->db3->lastInsertId();

    	return $this->id;
    }

    public function updateData()
    {
        $sql = 'UPDATE ' . TABLE_PREFIX . 'message_text
                SET mt_subject = ?,
					mt_text = ?
                WHERE mt_id = ?';

        $stmt = $this->db3->query($sql, array(
                (string)$this->subject,
                (string)$this->text,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_text
                WHERE mt_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->id = $row['mt_id'];
        $this->subject = $row['mt_subject'];
        $this->text = $row['mt_text'];
    }


    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'message_text
                WHERE mt_id = ?';
        $rowCount = $this->db3->query($sql, array($this->id))->rowCount();

        return $rowCount;
    }


    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'message_text mt';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

    public static function getList($where, $order, $limit = '')
    {
        $db3 = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_text mt';

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
            $myMessageText = new Core_Backend_MessageText();
            $myMessageText->id = $row['mt_id'];
            $myMessageText->subject = $row['mt_subject'];
            $myMessageText->text = $row['mt_text'];

            $outputList[] = $myMessageText;
        }
        return $outputList;
    }

	public static function getTexts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mt.mt_id = '.(int)$formData['fid'].' ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mt.mt_text LIKE \'%'.$formData['fkeywordFilter'].'%\'';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'id')
			$orderString = ' mt.mt_id ' . $sorttype;
		else
			$orderString = ' mt.mt_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	 * Preprocess html of current message for forward predefined text
	 */
	public function getForwardedText(Core_Backend_Message $myMessage, Core_User $sender, $recipientList)
	{
		global $lang;

		$html = $this->text;

		$html = '<p></p><p></p>
					<div class="forwardedmessagewrapper" id="mt-'.$this->id.'">
						<p class="forwardedmessagemeta">
							<div class="forwaredmessagemetahead">'.$lang['controller']['forwardedHead'].'</div>
							<div class="forwardedmessagefrom">'.$lang['controller']['forwardedFrom'].': <a href="'.$sender->getUserPath().'" class="tipsy-hovercard-trigger" data-url="'.$sender->getHovercardPath().'">'.$sender->fullname.'</a></div>
							<div class="forwardedmessagedate">'.$lang['controller']['forwardedDate'].': '.date('H:i, d/m/Y', $myMessage->datecreated).'</div>
							<div class="forwardedmessageto">'.$lang['controller']['forwardedTo'].': ';
		//process recipientList
		for($i = 0; $i < count($recipientList); $i++)
		{
			$user = $recipientList[$i];
			if($i > 0)
				$html .= ', ';

			$html .= '<a href="'.$user->getUserPath().'" class="tipsy-hovercard-trigger" data-url="'.$user->getHovercardPath().'">'.$user->fullname.'</a>';
		}

		$html .= '</div>
						</p>
						<p>&nbsp;</p>
					<div class="forwardedmessage">' . $this->text . '</div>
					</div>
					<p></p>';


		return $html;
	}


	/**
	 * Preprocess html of current message for reply/replyall predefined text
	 */
	public function getQuotedText(Core_Backend_Message $myMessage, Core_User $sender)
	{
		global $lang;

		$html = $this->text;

		$html = '<p></p><p></p>
					<div class="quotedmessagewrapper" id="mt-'.$this->id.'"><p class="quotedmessagemeta">'.$lang['controller']['quotedsenderTime'].' '.date('H:i, d/m/Y', $myMessage->datecreated).', <a href="'.$sender->getUserPath().'" class="tipsy-hovercard-trigger" data-url="'.$sender->getHovercardPath().'">'.$sender->fullname.'</a> '.$lang['controller']['quotedsenderWrite'].': </p><div class="quotedmessage">' . $html . '</div>
					</div>
					<p></p>';


		return $html;
	}


}



