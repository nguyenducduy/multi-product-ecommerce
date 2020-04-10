<?php

Class Core_Backend_Notification_SystemNotify extends Core_Backend_Notification
{
	public $text = '';
	public $objectid = 0;
	public $url = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_SYSTEM_NOTIFY; 
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['text'] = $this->text;
		$this->data['objectid'] = $this->objectid;
		$this->data['url'] = $this->url;
		
		return parent::addData();
	}
	
	public function getIdHash()
	{
		return  $this->type . '-' . $this->objectid;              
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->text = $this->data['text'];
		$this->url = $this->data['url'];
		
		if($this->url == '')
			$this->url = 'javascript:void(0);';
		
		$out = '<a class="notifyitem" href="'.$this->url.'">' . $this->text . '</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

