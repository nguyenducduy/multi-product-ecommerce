<?php

Class Core_Backend_Feed_ProfileEdit extends Core_Backend_Feed
{
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_PROFILE_EDIT;               
	}
	
	public function addData()
	{
		$this->data = array();
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$out = '<div class="text"><a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> c&#7853;p nh&#7853;t <a href="'. $this->actor->getUserPath().'">th&#244;ng tin t&#224;i kho&#7843;n</a>.</div>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
	/**
	* Ke thua tu Core_Backend_Feed de trien khai kiem tra co compact feed nay ko
	* 
	* @param Core_Backend_Feed $prevFeed
	*/
	public function checkcompact(Core_Backend_Feed $prevFeed)
	{
		if($prevFeed->type == $this->type && $prevFeed->uid == $this->uid)
		{
			return 'douple';
		}
		else
		{
			return '';
		}
	}
	

		
}

