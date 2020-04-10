<?php

Class Core_Backend_Notification_StatusAdd extends Core_Backend_Notification
{
	public $feedid = 0;
	public $feedpath = '';
	public $summary = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_STATUS_ADD; 
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['feedid'] = $this->feedid;
		$this->data['feedpath'] = $this->feedpath;
		$this->data['summary'] = $this->summary;
		
		return parent::addData();
	}
	
	public function getIdHash()
	{
		return  $this->type . '.' . md5($this->data['feedpath']);              
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->feedid = $this->data['feedid'];
		$this->feedpath = $this->data['feedpath'];
		$this->summary = $this->data['summary'];
		
		if($this->summary != '')
			$this->summary = '<br />"<em>' . $this->summary . '</em>"';
		
		$out = '<a class="notifyitem" href="'.$this->feedpath.'" title="'.$registry->lang['controller']['notificationFeedDetailTitle'].'"><strong>'.$this->actor->fullname.'</strong> '.$registry->lang['controller']['notificationStatusAddText'].' '.$registry->lang['controller']['notificationStatusAddLinkText'].' ' . $this->summary . '</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

