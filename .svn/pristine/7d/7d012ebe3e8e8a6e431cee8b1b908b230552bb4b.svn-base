<?php

Class Core_Feed_StatusAdd extends Core_Feed
{
	public $message = '';
	public $entityList = array();	//List of user/book mentioned in this FeedComment
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_STATUS_ADD;               
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['message'] = $this->message;
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->message = Helper::plaintext($this->data['message']);
		
		
		//nice message string, prevent repeat character
		$this->message = preg_replace('/([a-z])\1{4,}/i', '\1', $this->message);
		
		//////////////////////////
		//simulate the javascript formattext, before format the mentionable data
		$this->message = preg_replace('/((http:)\/\/(([^\s]*)\.(jpg|jpeg|gif|png)))/is','image://$3', $this->message);
		$this->message = preg_replace('/((https:)\/\/(([^\s]*)\.(jpg|jpeg|gif|png)))/is','images://$3', $this->message);
		$this->message = preg_replace('/((http:)\/\/(([^\s]*)(\.mp3)))/is','musicmp3://$3', $this->message);
		$this->message = preg_replace('/((http:)\/\/(([^\s]*)(\.swf)))/is','flashswf://$3', $this->message);
		$this->message = preg_replace('/((https:\/\/|http:\/\/|ftp:\/\/)([^\s]*))/ims','<a class="statustext_link" title="$1" href="$1" rel="nofollow" target="_blank">[link]</a>', $this->message);
		//start format
		$this->message = preg_replace('/((image:)\/\/(([^\s]*)\/([^\s]+\.(jpg|jpeg|gif|png))))/is','<div class="statustext_image"><a title="http://$3" href="http://$3" rel="nofollow" target="_blank"><img src="http://$3" /></a></div>', $this->message);
		$this->message = preg_replace('/((images:)\/\/(([^\s]*)\/([^\s]+\.(jpg|jpeg|gif|png))))/is','<div class="statustext_image"><a title="https://$3" href="https://$3" rel="nofollow" target="_blank"><img src="https://$3" /></a></div>', $this->message);

		//convert mp3music format to real flashplayer
		$this->message = preg_replace('/((musicmp3:)\/\/(([^\s]*)\/([^\s]+\.(mp3))))/is','<div class="statustext_mp3"><object width="200" height="20"><param name="movie" value="'.$registry->imageDir.'dewplayer.swf?mp3=http://$3"></param><param name="allowscriptaccess" value="always"></param><embed src="'.$registry->imageDir.'dewplayer.swf?mp3=http://$3" type="application/x-shockwave-flash" allowscriptaccess="always" width="200" height="20"></embed></object></div>', $this->message);
		$this->message = preg_replace('/((flashswf:)\/\/(([^\s]*)\/([^\s]+\.(swf))))/is','<div class="statustext_flash"><object width="210" height="170"><param name="movie" value="http://$3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://$3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="210" height="170"></embed></object></div>', $this->message);
		
		//end simulate js
		//////////////////////////
		
		
		//////////////
		//new 08/2012, mentionable extracting
		$this->message = Helper::mentionParsing($this->message, $this->entityList);
		
		
		//var_dump($this);
		if($this->actor->id == $this->receiver->id)
		{
			$posterInfo = '<a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> ';
		}
		else
		{
			$posterInfo = '<a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> &raquo; <a class="tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'" href="'. $this->receiver->getUserPath().'" title="">'.$this->receiver->fullname.$this->receiver->getNameIcon().'</a>';
		}
		
		$mentionBookString = '';
		$mentionUserString = '';
		
		if(!empty($this->entityList))
		{
			foreach($this->entityList as $mentionitem)
			{
				if($mentionitem['type'] == 'book')
				{
					$myBook = $mentionitem['entity'];
					
					$mentionBookString .= '<div class="metatext metatext_float metatextbookdetail">
						<a class="tipsy-hovercard-trigger" data-url="'.$myBook->getHovercardPath().'" href="'.$myBook->getBookPath().'" title=""><img class="cover" src="'.$myBook->getSmallImage().'" alt="" /></a>
						<div class="metatext_more">
							<a class="tipsy-hovercard-trigger" data-url="'.$myBook->getHovercardPath().'" href="'.$myBook->getBookPath().'">'.$myBook->title.'</a> <span class="bookauthor">('.$myBook->parseAuthorToLink().')</span><br />
							'.($myBook->rating > 0 ? '<img class="sp sprating sprating'.$myBook->getRatingRound().'" src="'. $registry->currentTemplate . 'images/blank.png" alt="" /> <br />' : '').'
							"'.Helper::truncateperiod($myBook->introduction, 300, '...', ' ').'"
						</div>
						<div class="clear"></div>
					</div>';
					
				}
				elseif($mentionitem['type'] == 'user')
				{
					$myUser = $mentionitem['entity'];
					
					$mentionUserString .= '';
				}
				
			}
		}
		
		
		$out = '<div class="text"> '.$posterInfo. ' <span class="statustext">' .$this->message.'</span></div>' . $mentionBookString;
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	public function showDetailMobile($display = false)
	{
		global $registry;
		
		$this->message = Helper::plaintext($this->data['message']);
		
		
		//nice message string, prevent repeat character
		$this->message = preg_replace('/([a-z])\1{4,}/i', '\1', $this->message);
		
		//////////////////////////
		//simulate the javascript formattext, before format the mentionable data
		$this->message = preg_replace('/((http:)\/\/(([^\s]*)\.(jpg|jpeg|gif|png)))/is','image://$3', $this->message);
		$this->message = preg_replace('/((https:)\/\/(([^\s]*)\.(jpg|jpeg|gif|png)))/is','images://$3', $this->message);
		$this->message = preg_replace('/((http:)\/\/(([^\s]*)(\.mp3)))/is','musicmp3://$3', $this->message);
		$this->message = preg_replace('/((http:)\/\/(([^\s]*)(\.swf)))/is','flashswf://$3', $this->message);
		$this->message = preg_replace('/((https:\/\/|http:\/\/|ftp:\/\/)([^\s]*))/ims','<a class="statustext_link" title="$1" href="$1" rel="nofollow" target="_blank">[link]</a>', $this->message);
		//start format
		$this->message = preg_replace('/((image:)\/\/(([^\s]*)\/([^\s]+\.(jpg|jpeg|gif|png))))/is','<div class="statustext_image"><a title="http://$3" href="http://$3" rel="nofollow" target="_blank"><img src="http://$3" /></a></div>', $this->message);
		$this->message = preg_replace('/((images:)\/\/(([^\s]*)\/([^\s]+\.(jpg|jpeg|gif|png))))/is','<div class="statustext_image"><a title="https://$3" href="https://$3" rel="nofollow" target="_blank"><img src="https://$3" /></a></div>', $this->message);

		//convert mp3music format to real flashplayer
		$this->message = preg_replace('/((musicmp3:)\/\/(([^\s]*)\/([^\s]+\.(mp3))))/is','<div class="statustext_mp3"><object width="200" height="20"><param name="movie" value="'.$registry->imageDir.'dewplayer.swf?mp3=http://$3"></param><param name="allowscriptaccess" value="always"></param><embed src="'.$registry->imageDir.'dewplayer.swf?mp3=http://$3" type="application/x-shockwave-flash" allowscriptaccess="always" width="200" height="20"></embed></object></div>', $this->message);
		$this->message = preg_replace('/((flashswf:)\/\/(([^\s]*)\/([^\s]+\.(swf))))/is','<div class="statustext_flash"><object width="210" height="170"><param name="movie" value="http://$3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://$3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="210" height="170"></embed></object></div>', $this->message);
		
		//end simulate js
		//////////////////////////
		
		
		//////////////
		//new 08/2012, mentionable extracting
		$this->message = Helper::mentionParsing($this->message, $this->entityList);
		
		
		//var_dump($this);
		if($this->actor->id == $this->receiver->id)
		{
			$posterInfo = '<a class="username" href="'. $this->actor->getUserPath().'">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> ';
		}
		else
		{
			$posterInfo = '<a class="username" href="'. $this->actor->getUserPath().'">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> &raquo; <a href="'. $this->receiver->getUserPath().'">'.$this->receiver->fullname.$this->receiver->getNameIcon().'</a>';
		}
		
		$mentionBookString = '';
		$mentionUserString = '';
		
		if(!empty($this->entityList))
		{
			foreach($this->entityList as $mentionitem)
			{
				if($mentionitem['type'] == 'book')
				{
					$myBook = $mentionitem['entity'];
					
					$mentionBookString .= '<div class="metatext metatext_float metatextbookdetail">
						<a href="'.$myBook->getBookPath().'"><img class="cover" src="'.$myBook->getSmallImage().'" /></a>
						<div class="metatext_more">
							<a href="'.$myBook->getBookPath().'">'.$myBook->title.'</a> <span class="bookauthor">('.$myBook->parseAuthorToLink().')</span><br />
							'.($myBook->rating > 0 ? '<img class="sp sprating sprating'.$myBook->getRatingRound().'" src="'. $registry->currentTemplate . 'images/blank.png" alt="" />' : '').'
						</div>
						<div class="clear"></div>
					</div>';
					
				}
				elseif($mentionitem['type'] == 'user')
				{
					$myUser = $mentionitem['entity'];
					
					$mentionUserString .= '';
				}
				
			}
		}
		
		
		$out = '<div class="text"> '.$posterInfo. ' <span class="statustext">' .$this->message.'</span></div>' . $mentionBookString;
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
	
	
	
	public function getSummary()
	{
		$this->message = $this->data['message'];
		$summary = 'Vi&#7871;t l&#234;n trang nh&#224; "'.Helper::truncateperiod($this->message, 40, '...', ' ') . '"';
		
		return $summary;
	}	
		
}

