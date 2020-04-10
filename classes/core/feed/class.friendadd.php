<?php

Class Core_Feed_FriendAdd extends Core_Feed
{
	public $actormore = array();
	public $receivermore = array();
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_FRIEND_ADD;               
	}
	
	public function updateActiveActor()
	{
		global $registry;
		$tmp = null;
		if($this->actor->id != $registry->myUser->id)
		{
			$tmp = $this->actor;
			$this->actor = $this->receiver;
			$this->receiver = $tmp;
		}	
	}
	
	public function addData()
	{
		$this->data = array();
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		if(!empty($this->receivermore))
		{
			$morefullname = '';
			$moreavatar = '';
			$count = count($this->receivermore);
			for($i = 0; $i < $count; $i++)
			{
				$receiver = $this->receivermore[$i];
				
				if($i == $count - 1)
				{
					$morefullname .= ' v&#224; ';
				}
				else
				{
					$morefullname .= ', ';
				}
				$morefullname .= '<a class="tipsy-hovercard-trigger" data-url="'.$receiver->getHovercardPath().'" href="'. $receiver->getUserPath().'" title="">'.$receiver->fullname.$receiver->getNameIcon().'</a>';
				
				$moreavatar .= '<a class="tipsy-hovercard-trigger" data-url="'.$receiver->getHovercardPath().'"  href="'.$receiver->getUserPath().'" title=""><img class="avatar avatarmerge" src="'.$receiver->getSmallImage().'" alt="" /></a>';
			}
			
			$out = '<div class="text"><a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> k&#7871;t b&#7841;n v&#7899;i <a class="tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'" href="'. $this->receiver->getUserPath().'" title="">'.$this->receiver->fullname.$this->receiver->getNameIcon().'</a>'.$morefullname.'.</div>
			
			<div class="metatext metatext_float">
				<a class="tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'"  href="'.$this->receiver->getUserPath().'" title=""><img class="avatar avatarmerge" src="'.$this->receiver->getSmallImage().'" alt="" /></a>
				'.$moreavatar.'
				
				<div class="clear"></div>
			</div>
			';
		}
		elseif(!empty($this->actormore))
		{
			$morefullname = '';
			$count = count($this->actormore);
			for($i = 0; $i < $count; $i++)
			{
				$actor = $this->actormore[$i];
				
				if($i == $count - 1)
				{
					$morefullname .= ' v&#224; ';
				}
				else
				{
					$morefullname .= ', ';
				}
				$morefullname .= '<a class="tipsy-hovercard-trigger" data-url="'.$actor->getHovercardPath().'" href="'. $actor->getUserPath().'" title="">'.$actor->fullname.$actor->getNameIcon().'</a>';
				
			}
			
			$out = '<div class="text"><a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a>'.$morefullname.' &#273;&#7873;u k&#7871;t b&#7841;n v&#7899;i <a class="tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'" href="'. $this->receiver->getUserPath().'" title="">'.$this->receiver->fullname.$this->receiver->getNameIcon().'</a>.</div>
			
			<div class="metatext metatext_float">
				<a class="tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'"  href="'.$this->receiver->getUserPath().'" title=""><img class="avatar" src="'.$this->receiver->getSmallImage().'" alt="" /></a>
				<div class="metatext_more">';
				
			if($this->receiver->countBook > 0)
				$out .= '<a href="'.$this->receiver->getUserPath().'/book" title="">'.$this->receiver->countBook.' '.$registry->lang['default']['book'].'</a>, ';
			if($this->receiver->countReview > 0)
				$out .= '<a href="'.$this->receiver->getUserPath().'/review" title="">'.$this->receiver->countReview.' '.$registry->lang['default']['bookCountReview'].'</a>, ';
			if($this->receiver->countQuote > 0)
				$out .= '<a href="'.$this->receiver->getUserPath().'/quote" title="">'.$this->receiver->countQuote.' '.$registry->lang['default']['bookCountQuote'].'</a>, ';
			if($this->receiver->countSell > 0)
				$out .= '<a href="'.$this->receiver->getUserPath().'/shop" title="">'.$this->receiver->countSell.' '.$registry->lang['default']['bookSellCount'].'</a>, ';
			
			$out .= '...</div>
				<div class="clear"></div>
			</div>
			';
		}
		else
		{
			$out = '<div class="text"><a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> k&#7871;t b&#7841;n v&#7899;i <a class="tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'" href="'. $this->receiver->getUserPath().'" title=""><img src="'.$this->receiver->getSmallImage().'" alt="" style="width:16px;" /> '.$this->receiver->fullname.$this->receiver->getNameIcon().'</a></div>
			
			
			';
		}
		
		
		
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
	public function canDelete($userid)
	{
		return ($this->receiver->id == $userid || $this->actor->id == $userid);
	}
	
	
	/**
	* Ke thua tu Core_Feed de trien khai kiem tra co compact feed nay ko
	* 
	* @param Core_Feed $prevFeed
	*/
	public function checkcompact(Core_Feed $prevFeed)
	{
		if($prevFeed->type == $this->type && $prevFeed->actor->id == $this->actor->id)
		{
			//tien hanh merge feed nay vao prevfeed
			$prevFeed->receivermore[] = $this->receiver;
			
			return 'merge';
		}
		elseif($prevFeed->type == $this->type && $prevFeed->receiver->id == $this->receiver->id)
		{
			//tien hanh merge feed nay vao prevfeed
			$prevFeed->actormore[] = $this->actor;
			
			return 'merge';
		}
		else
		{
			return '';
		}
	}

		
}

