<?php

Class Core_Notification_BlogComment extends Core_Notification
{
	public $blogid = 0;
	public $blogtitle = '';
	public $blogpath = '';
	public $commentid = 0;
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_BLOG_COMMENT;    
	}
	
	public function getIdHash()
	{
		return $this->type .  '.' . $this->data['blogid'];   	
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['blogid'] = $this->blogid;
		$this->data['blogtitle'] = htmlspecialchars($this->blogtitle);
		$this->data['blogpath'] = $this->blogpath;
		$this->data['commentid'] = $this->commentid;
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->blogid = $this->data['blogid'];
		$this->blogtitle = $this->data['blogtitle'];
		$this->blogpath = $this->data['blogpath'];
		$this->commentid = $this->data['commentid'];
		
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
		
		
		$out = '<a class="notifyitem" href="'.$this->blogpath . '?selectedcomment='.$this->commentid.'">'.$actorInfo .$registry->lang['controller']['notificationBlogCommentAction'].' '.$registry->lang['controller']['notificationBlogCommentNoun'].' '.$registry->lang['controller']['notificationBlogCommentText'].' '.$this->blogtitle.'</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

