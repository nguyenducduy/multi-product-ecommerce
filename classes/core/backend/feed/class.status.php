<?php

Class Core_Backend_Feed_Status extends Core_Backend_Feed
{
	public $message = '';
	public $url = '';
	public $title = '';
	public $description = '';
	public $image = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_STATUS;               
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['message'] = $this->message;
		$this->data['url'] = $this->url;
		$this->data['title'] = $this->title;
		$this->data['description'] = $this->description;
		$this->data['image'] = $this->image;
		
		return parent::addData();
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->message = $this->data['message'];
		$this->url = $this->data['url'];
		$this->title = $this->data['title'];
		$this->description = $this->data['description'];
		$this->image = $this->data['image'];
		
		//nice message string, prevent repeat character
		$this->message = preg_replace('/([a-z])\1{4,}/i', '\1', $this->message);
		
		if($this->actor->id == $this->receiver->id)
		{
			$posterInfo = '<a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> ';
		}
		else
		{
			$posterInfo = '<a class="username tipsy-hovercard-trigger" data-url="'.$this->actor->getHovercardPath().'" href="'. $this->actor->getUserPath().'" title="">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> &raquo; <a class="username tipsy-hovercard-trigger" data-url="'.$this->receiver->getHovercardPath().'" href="'. $this->receiver->getUserPath().'" title="">'.$this->receiver->fullname.$this->receiver->getNameIcon().'</a>';
		}
		
		if($this->message != '')
		{
			$this->message = $this->message . '.';
		}
		
		$urlInfo = parse_url($this->url);
		
		if($this->image == '')
		{
			$this->image = $registry->currentTemplate . 'images/linknoimage.png';
		}
		
		//kiem tra co fai link youtube ^^
		//de khi click vao thi open player
		$showPlayer = 0;
		if (preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->url, $match)) 
		{
			$showPlayer = 1;
		    $link = '<a onclick="user_feedplayyoutube('.$this->id.', \''.$match[1].'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		elseif (preg_match('/^https?:\/\/www\.nhaccuatui\.com\/nghe\?(M|L)\=([a-zA-Z0-9_]*)/', $this->url, $match)) 
		{
			$showPlayer = 1;
		    $link = '<a onclick="user_feedplaynhaccuatui('.$this->id.', \''.$match[1].'\', \''.$match[2].'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		elseif (preg_match('/^https?:\/\/mp3\.zing\.vn/', $this->url)) 
		{
			$showPlayer = 1;
		    $link = '<a onclick="user_feedplayzingmusic('.$this->id.', \''.$this->url.'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		elseif(preg_match('/^https?:\/\/www\.slideshare\.net/', $this->url))
		{
			$showPlayer = 1;
			$link = '<a onclick="user_feedplayslideshare('.$this->id.', \''.$this->url.'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		else
		{
			$link = '<a href="'.$this->url.'" title="'.$this->title.'" target="_blank">';
		}
		
		if($showPlayer == 1)
		{
			$playerHolder = '<div class="feedplayerholder" id="feedplayerholder_'.$this->id.'"></div>';
		    
		    //icon
		    $playerIcon = '<span class="act_entry_button"><img src="'.$registry->currentTemplate.'/images/feed_play.png"></span>';
		}
		
		
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
		
		
		$out = '<div class="text"> '.$posterInfo. ' <span class="statustext">' .$this->message.'</span>'.$playerHolder.'</div>';
		
		
		if($this->url != '')
		{
			$out .= '<div class="metatext metatext_float statuslink">
				'.$link.'<img src="'.$this->image.'" alt="" />'.$playerIcon.'</a>
				<div class="metatext_more">
					'.$link.''.$this->title.'</a>
					<div class="subtitle">'.$urlInfo['scheme'] . '://' . $urlInfo['host'].'</div>
					'.$this->description.'
				</div>
				<div class="clear"></div>
			</div>';
		}
		
				
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
	
	public function showDetailMobile($display = false)
	{
		global $registry;
		
		$this->message = $this->data['message'];
		$this->url = $this->data['url'];
		$this->title = $this->data['title'];
		$this->description = $this->data['description'];
		$this->image = $this->data['image'];
		
		//nice message string, prevent repeat character
		$this->message = preg_replace('/([a-z])\1{4,}/i', '\1', $this->message);
		
		if($this->actor->id == $this->receiver->id)
		{
			$posterInfo = '<a class="username" href="'. $this->actor->getUserPath().'">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> ';
		}
		else
		{
			$posterInfo = '<a class="username" href="'. $this->actor->getUserPath().'">'.$this->actor->fullname.$this->actor->getNameIcon().'</a> &raquo; <a class="username" href="'. $this->receiver->getUserPath().'">'.$this->receiver->fullname.$this->receiver->getNameIcon().'</a>';
		}
		
		if($this->message != '')
		{
			$this->message = $this->message . '.';
		}
		
		$urlInfo = parse_url($this->url);
		
		if($this->image == '')
		{
			$this->image = $registry->currentTemplate . 'images/linknoimage.png';
		}
		
		//kiem tra co fai link youtube ^^
		//de khi click vao thi open player
		$showPlayer = 0;
		if (preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->url, $match)) 
		{
			$showPlayer = 1;
		    $link = '<a onclick="user_feedplayyoutube('.$this->id.', \''.$match[1].'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		elseif (preg_match('/^https?:\/\/www\.nhaccuatui\.com\/nghe\?(M|L)\=([a-zA-Z0-9_]*)/', $this->url, $match)) 
		{
			$showPlayer = 1;
		    $link = '<a onclick="user_feedplaynhaccuatui('.$this->id.', \''.$match[1].'\', \''.$match[2].'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		elseif (preg_match('/^https?:\/\/mp3\.zing\.vn/', $this->url)) 
		{
			$showPlayer = 1;
		    $link = '<a onclick="user_feedplayzingmusic('.$this->id.', \''.$this->url.'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		elseif(preg_match('/^https?:\/\/www\.slideshare\.net/', $this->url))
		{
			$showPlayer = 1;
			$link = '<a onclick="user_feedplayslideshare('.$this->id.', \''.$this->url.'\')" href="javascript:void(0)" title="'.$this->title.'">';
		}
		else
		{
			$link = '<a href="'.$this->url.'">';
		}
		
		if($showPlayer == 1)
		{
			$playerHolder = '<div class="feedplayerholder" id="feedplayerholder_'.$this->id.'"></div>';
		    
		    //icon
		    $playerIcon = '<span class="act_entry_button"><img src="'.$registry->currentTemplate.'/images/feed_play.png"></span>';
		}
		
		
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
		
		
		$out = '<div class="text"> '.$posterInfo. ' <span class="statustext">' .$this->message.'</span>'.$playerHolder.'</div>
		
				<div class="metatext metatext_float statuslink">
					'.$link.'<img src="'.$this->image.'" />'.$playerIcon.'</a>
					<div class="metatext_more">
						'.$link.''.$this->title.'</a>
						<div class="subtitle">'.$urlInfo['scheme'] . '://' . $urlInfo['host'].'</div>
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
		$this->message = $this->data['message'];
		$this->url = $this->data['url'];
		
		$summary = 'Chia s&#7867; tr&#7841ng th&#225i';
		
		return $summary;
	}		
}

