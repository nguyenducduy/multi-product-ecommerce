<?php

Class Core_Backend_Notification_FeedComment extends Core_Backend_Notification
{
	public $feedid = 0;
	public $feedpath = '';
	public $summary = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_FEED_COMMENT;    
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
			$this->summary = $registry->lang['controller']['notificationCommentLinkTextSummary'] . ' <em>' . $this->summary . '</em>' . $registry->lang['controller']['notificationCommentLinkTextSummarySuffix'];
		}
		else
		{
			$this->summary = $registry->lang['controller']['notificationCommentLinkText'];
		}
				
		$out = '<a class="notifyitem" href="'.$this->feedpath.'" title="'.$registry->lang['controller']['notificationFeedDetailTitle'].'">'.$actorInfo . $registry->lang['controller']['notificationCommentText'].' '.$this->summary.'</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

