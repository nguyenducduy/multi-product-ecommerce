<?php

Class Core_Backend_Notification_MentionStatusLink extends Core_Backend_Notification
{
	public $feedid = 0;
	public $feedpath = '';
	public $summary = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_MENTION_STATUSLINK;    
	}
	
	public function getIdHash()
	{
		return $this->type . '.' . $this->data['feedid'];   	
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['feedid'] = $this->feedid;
		$this->data['feedpath'] = $this->feedpath;
		$this->data['summary'] = $this->summary;
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->feedid = $this->data['feedid'];
		$this->feedpath = $this->data['feedpath'];
		$this->summary = $this->data['summary'];
			
		$out = '<a class="notifyitem" href="'.$this->feedpath.'"><strong>'.$this->actor->fullname.'</strong>  '. $registry->lang['controller']['notificationMentionStatusLink'].' <em>"'.$this->summary.'"</em></a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

