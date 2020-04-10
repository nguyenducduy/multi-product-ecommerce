<?php

Class Core_Feed_BlogAdd extends Core_Feed
{
	public $blogtitle = '';
	public $blogurl = '';
	public $blogsummary = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_BLOG_ADD;               
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['blogtitle'] = $this->blogtitle;
		$this->data['blogurl'] = $this->blogurl;
		$this->data['blogsummary'] = $this->blogsummary;
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->blogtitle = $this->data['blogtitle'];
		$this->blogurl = $this->data['blogurl'];
		$this->blogsummary = $this->data['blogsummary'];
		
		if($this->actor->ispage())
			$verb = 'vi&#7871;t b&#224;i ';
		else
			$verb = 'vi&#7871;t blog ';
			
		$out = '<div class="text"><a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> '.$verb.' <a href="'.$this->blogurl.'" title="'.$this->blogtitle.'">'.$this->blogtitle.'</a>.</div>
							<div class="metatext metatext_float">
								<div class="metatext_single">
									&ldquo;'.$this->blogsummary.'&rdquo;
								</div>
								<div class="clear"></div>
							</div>
							';
							
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	public function getSummary()
	{
		if($this->actor->ispage())
			$verb = 'Vi&#7871;t b&#224;i ';
		else
			$verb = 'Vi&#7871;t blog ';
		return $verb . Helper::truncateperiod($this->data['blogtitle'], 40, '...', ' ');
	}	
	
	

		
}

