<?php

/**
* parsing thong tin tu cac website khac nhu slideshare de replace player
*/
Class Controller_Profile_FeedUrlParser Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
		
		
		
	} 
	
	function slideshareAction()
	{
		$url = $_POST['url'];
		$width = $_POST['width'];
		$height = $_POST['height'];
		
		$success = 0;
		$message = '';
		//check slideshare url
		
		if(preg_match('/^https?:\/\/www\.slideshare\.net\/.*+/i', $url))
		{
			$fetchUrl = 'http://www.slideshare.net/api/oembed/2?url='.$url.'&maxwidth='.$width.'&maxheight='.$height.'&format=json&';
			$output = @file_get_contents($fetchUrl);
			$data = json_decode($output, true);
		}
		else
			$data = array();
			
		//output
		if($data['html'] != '')
		{
			$success = 1;
			$embeddata = $data['html'];
		}
		else
		{
			$success = 0;
			$embeddata = '';
		}
		
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><embeddata><![CDATA['.$embeddata.']]></embeddata></result>';
		
	}
	
	
	function zingmusicAction()
	{
		$url = $_POST['url'];
		
		
		$success = 0;
		$message = '';
		//check slideshare url
		if(preg_match('/^https?:\/\/mp3\.zing\.vn/i', $url))
		{
			$output = @file_get_contents($url);
			
			//parsing video_src link tag
			preg_match('/link rel="video_src" href="([^"]+)"/i', $output, $match);
			
			if($match[1] != '')
			{
				$width = 390;
				$height = 300;
				
				//neu play 1 bai thi height=50
				if(strpos($url, 'mp3.zing.vn/bai-hat/') !== false)
				{
					$height = 35;
				}
				
				$data = '<div class="statustext_youtube"><object width="'.$width.'" height="'.$height.'"><param name="movie" value="'.$match[1].'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"><param name="autostart" value="true"></param><embed src="'.$match[1].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" flashvars="&autostart=true" width="'.$width.'" height="'.$height.'"></embed></object></div>';
				
			}
		}
		else
			$data = array();
			
		//output
		if($data != '')
		{
			$success = 1;
			$embeddata = $data;
		}
		else
		{
			$success = 0;
			$embeddata = '';
		}
		
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><embeddata><![CDATA['.$embeddata.']]></embeddata></result>';
		
	}
	
	
}

