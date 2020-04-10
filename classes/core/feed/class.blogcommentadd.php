<?php

Class Core_Feed_BlogCommentAdd extends Core_Feed
{
	public $blogtitle = '';
	public $blogpath = '';
	public $commentid = 0;
	public $comment = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_BLOGCOMMENT_ADD;               
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['blogtitle'] = $this->blogtitle;
		$this->data['blogpath'] = $this->blogpath;
		$this->data['commentid'] = $this->commentid;
		$this->data['comment'] = $this->comment;
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->blogtitle = $this->data['blogtitle'];
		$this->blogpath = $this->data['blogpath'];
		$this->commentid = $this->data['commentid'];
		$this->comment = $this->data['comment'];
		
		//replace reply string
		$this->comment = preg_replace('/(@([a-z0-9.]+)\[([^\]]+)\])/ims', '<a href="'.$registry->conf['rooturl'].'$2" target="_blank" title="T&#7899;i nh&#224; c&#7911;a $3">@$3</a>', $this->comment);
		
		if($this->actor->ispage())
			$noun = 'b&#224;i vi&#7871;t';
		else
			$noun = 'blog ';
			
		$out = '<div class="text"><a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> b&#236;nh lu&#7853;n cho '.$noun.' <a href="'.$this->blogpath.'?selectedcomment='.$this->commentid.'">'.$this->blogtitle.'</a>.</div>
							<div class="metatext metatext_float">
								<div class="metatext_more">
									&ldquo;'.$this->comment.'&rdquo;
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
		$this->blogtitle = $this->data['blogtitle'];
		$this->comment = $this->data['comment'];
		
		if($this->actor->ispage())
			$noun = 'b&#224;i vi&#7871;t';
		else
			$noun = 'blog ';
			
		$summary = 'Vi&#7871;t b&#236;nh lu&#7853;n cho '.$noun.' '.Helper::truncateperiod($this->blogtitle, 40, '...', ' ') . ' "' . Helper::truncateperiod($this->comment, 40, '...', ' ') .'"';
		
		return $summary;
	}	
		
}

