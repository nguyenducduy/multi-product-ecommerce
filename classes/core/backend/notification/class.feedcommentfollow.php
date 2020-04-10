<?php

Class Core_Backend_Notification_FeedCommentFollow extends Core_Backend_Notification
{
	public $message = '';
	public $feedpath = '';
	public $summary = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_FEED_COMMENT_FOLLOW;               
	}
	
	public function getIdHash()
	{
		return $this->type . '.' . md5($this->data['feedpath']);   	
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['message'] = $this->message;
		$this->data['feedpath'] = $this->feedpath;
		$this->data['summary'] = $this->summary;
		
		return parent::addData();
	}
	
	/**
	* Add nhieu record 1 luc, su dung cu phap 
	* 
	* @param array $receiverList: danh sach ID cua nhung nguoi se nhan duoc notification
	*/
	public function addDataToMany($receiverList)
	{
		$this->data = array();
		$this->data['message'] = $this->message;
		$this->data['feedpath'] = $this->feedpath;
		$this->data['summary'] = $this->summary;
		
		return parent::addDataToMany($receiverList);
	}
	
	public function showDetail($display = false)
	{
		global $registry;	
		
		$this->message = $this->data['message'];
		$this->feedpath = $this->data['feedpath'];
		$this->summary = $this->data['summary'];
		
		$actorInfo = '';
		if(empty($this->actorList))
		{
			$actorInfo = '<strong>'.$this->actor->fullname.'</strong> ';
		}
		else
		{
			$addedId = array();
			//grouping mode
			for($i = 0; $i < count($this->actorList); $i++)
			{
				if(!in_array($this->actorList[$i]->id, $addedId))
				{
					$addedId[] = $this->actorList[$i]->id;
					if($i > 0)
					{
						$actorInfo .= ', ';
					}
					$actorInfo .= '<strong>'.$this->actorList[$i]->fullname.'</strong> ';
				}
			}
		}
		
		if($this->summary != '')
		{
			$this->summary = $registry->lang['controller']['notificationFollowLinkTextSummary'] . ' <em>' . $this->summary . '</em>' . $registry->lang['controller']['notificationFollowLinkTextSummarySuffix'];
		}
		else
		{
			$this->summary = $registry->lang['controller']['notificationFollowLinkText'];
		}
		
		$out = '<a class="notifyitem"  href="'.$this->feedpath.'" title="'.$registry->lang['controller']['notificationFeedDetailTitle'].'">'.$actorInfo . $registry->lang['controller']['notificationFollowText'].' '.$this->summary.'</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

