<?php
/**
* Tinh nang fetch data tu 1 URL cua chuc nang statusbox attach link
*/
Class Controller_Profile_StatusboxLinkFetch Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
		$url = urldecode($_GET['url']);
		$url = str_replace(' ', '%20', $url);	//fix bug when have space in url
		
		$url = $this->checkValues($url);

		$string = file_get_contents($url);
		
		//echo $string;
		
		/// fecth title
		$title_regex = "/<title>([^<]*)<\/title>/ims";
		preg_match($title_regex, $string, $title);
		$url_title = trim($title[1]);
		if($url_title == '')
		{
			die('Can not read data from your URL');
		}

		/// fecth decription
		$tags = get_meta_tags($url);
		
		//check this is youtube link
		if(preg_match('/youtube\.com\/(v\/|watch\?v=)([\w\-]+)/', $url, $match)) 
		{
			//$match[2] is youtube video id
			$images_array = array();
			$images_array[] = 'http://img.youtube.com/vi/'.$match[2].'/0.jpg';
			$images_array[] = 'http://img.youtube.com/vi/'.$match[2].'/1.jpg';
			$images_array[] = 'http://img.youtube.com/vi/'.$match[2].'/2.jpg';
			$images_array[] = 'http://img.youtube.com/vi/'.$match[2].'/3.jpg';
		} 
		elseif(preg_match('/slideshare\.net/', $url)) 
		{
			//$match[2] is youtube video id
			$images_array = array();
			
			$fetchUrl = 'http://www.slideshare.net/api/oembed/2?url='.$url.'&format=json';
			$slideshareOEmbed = @file_get_contents($fetchUrl);
			$data = json_decode($slideshareOEmbed, true);
			//var_dump($data);
			if($data['thumbnail'] != '')
				$images_array[] = $data['thumbnail'];
		} 
		else
		{
			// fetch images
			$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
			preg_match_all($image_regex, $string, $img);
			$images_array = $img[1];
			
			//fetch LINK META preview
			preg_match('/<link rel="image_src" href="([^"]*)"/', $string, $match);
			if($match[1] != '')
			{
				array_unshift($images_array, $match[1]);
			}
		}
		
		
		
		echo '<div class="images">';
		
		$k = 1;
		for ($i = 0; $i <= sizeof($images_array); $i++)
		{
			if(@$images_array[$i])
			{
				//khong nen su dung getimagesize boi vi neu site lon thi se rat lau
				/*
				if(@getimagesize(@$images_array[$i]))
				{
					list($width, $height, $type, $attr) = getimagesize(@$images_array[$i]);
					if($width > 50 && $height > 50 ){
					
					echo "<img src='".@$images_array[$i]."' width='50' id='".$k."' >";
					
					$k++;
					
					}
				}
				*/
				$extPart = strtoupper(substr(strrchr($images_array[$i],'.'),1));
				if($extPart != 'GIF' && $extPart != 'PNG' && $extPart != 'BMP')
				{
					echo "<img src='".@$images_array[$i]."' width='50' id='".$k."' >";
					
					$k++;
				}
			}
		}
		
		$totalImage = --$k;
		
		$urlInfo = parse_url($url);
		echo '
			<input type="hidden" name="total_images" id="total_images" value="'. $totalImage . '" />
			</div>
			<div class="info">
				
				<label class="title'.($url_title == '' ? ' hide':'').'" onclick="status_attachlink_edit(\'title\')">' . $url_title . '</label>
				<input style="display:none;" type="text" id="title_edit" value="'.$url_title.'" class="'.($url_title != '' ? 'hide':'').'" onblur="status_attachlink_editsave(\'title\')" />
				<label class="url">
					' . $urlInfo['scheme'] . '://' . $urlInfo['host'] . '
				</label>
				<label class="desc'.(trim($tags['description']) == '' ? ' hide':'').'" onclick="status_attachlink_edit(\'desc\')">'. @$tags['description'] . '</label>
				<textarea id="desc_edit" class="'.(trim($tags['description']) != '' ? 'hide':'').'" onblur="status_attachlink_editsave(\'desc\')" >'.@$tags['description'].'</textarea>
				
				<label style="float:left"><img src="'. $this->registry->currentTemplate.'images/attachlink/prev.png" id="prev" alt="" onclick="status_attachlink_prev()" /><img src="'. $this->registry->currentTemplate.'images/attachlink/next.png" id="next" alt="" onclick="status_attachlink_next()" /></label>
				
				<label class="totalimg">';
				
			if($totalImage > 0)
			{
				echo 'H&#236;nh #<span id="currentimageshow">1</span>/' . $k . '';
			}
			else
			{
				echo 'Kh&#244;ng c&#243; h&#236;nh';
			}				
			
			echo '</label>
				<br clear="all" />
				
			</div>';
	} 
	
	function checkValues($value)
	{
		$value = trim($value);
		if (get_magic_quotes_gpc()) 
		{
			$value = stripslashes($value);
		}
		$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		return $value;
	}	

	
}

