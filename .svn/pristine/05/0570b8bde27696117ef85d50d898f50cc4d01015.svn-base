<?php

Class Core_Notification_FriendRequestAccept extends Core_Notification
{
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_FRIENDREQUEST_ACCEPT;    
	}
	
	public function addData()
	{
		$this->data = array();
		return parent::addData();
	}
	
	public function getIdHash()
	{
		return $this->type . '.' . $this->uidreceive;
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$actorInfo = '';
		if(empty($this->actorList))
		{
			$actorInfo = '<strong>'.$this->actor->fullname.'</strong> ';
			$clicklink = 'href="'. $this->actor->getUserPath().'" title="'.$registry->lang['controller']['notificationUserTitle'].' '.$this->actor->fullname.'"';
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
				
				if($i == 0)
				{
					$clicklink = 'href="'. $this->actorList[$i]->getUserPath().'" title="'.$registry->lang['controller']['notificationUserTitle'].' '.$this->actorList[$i]->fullname.'"';
				}
			}
		}
		
		
		$out = '<a class="notifyitem" '.$clicklink.'>'.$actorInfo . $registry->lang['controller']['notificationFriendAcceptLinkText'].'</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

