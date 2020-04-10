<?php
class CommonLib
{
  protected static $mimeTypes = array(
	  'txt' => 'text/plain',
    'htm' => 'text/html',
    'html' => 'text/html',
    'php' => 'text/html',
    'css' => 'text/css',
    'js' => 'application/javascript',
    'json' => 'application/json',
    'xml' => 'application/xml',
    'swf' => 'application/x-shockwave-flash',
    'flv' => 'video/x-flv',
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',
    'zip' => 'application/zip',
    'rar' => 'application/x-rar-compressed',
    'exe' => 'application/x-msdownload',
    'msi' => 'application/x-msdownload',
    'cab' => 'application/vnd.ms-cab-compressed',
    'mp3' => 'audio/mpeg',
    'qt' => 'video/quicktime',
    'mov' => 'video/quicktime',
    'pdf' => 'application/pdf',
    'psd' => 'image/vnd.adobe.photoshop',
    'ai' => 'application/postscript',
    'eps' => 'application/postscript',
    'ps' => 'application/postscript',
    'doc' => 'application/msword',
    'rtf' => 'application/rtf',
    'xls' => 'application/vnd.ms-excel',
    'ppt' => 'application/vnd.ms-powerpoint',
    'odt' => 'application/vnd.oasis.opendocument.text',
    'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
  );
  
  public static function getMimeType($fileName)
  {
    if (function_exists('finfo_open'))
	  {
      $finfo = finfo_open(FILEINFO_MIME);
      $mime = explode(';', finfo_file($finfo, $fileName));
      finfo_close($finfo);
      return $mime[0];
    }
    else
    {
      $ext = pathinfo($fileName, PATHINFO_EXTENSION);
      if (isset(self::$mimeTypes[$ext])) return self::$mimeTypes[$ext];
	  }
	
	  return FALSE;
  }
  
  public static function parseIniFile($path)
	{
	  $r = NULL;
		$sec = NULL;
		$f = @file($path);
		for ($i = 0; $i < @count($f); $i++)
		{
		  $newSec = 0;
			$w = @trim($f[$i]);
			if ($w)
			{
			  if ((!$r) or ($sec))
				{
				  if ((@substr($w,0,1) == "[") && (@substr($w, -1, 1)) == "]")
					{
					  $sec = @substr($w, 1, @strlen($w) - 2);
						$newSec = 1;
					}
				}
				
				if (!$newSec)
				{
				  $w = @explode('=', $w);
					$k = @trim($w[0]);
					unset($w[0]);
					$v = @trim(@implode('=', $w));
					if ((@substr($v, 0, 1) == "\"") && (@substr($v, -1, 1) == "\"")) $v = @substr($v, 1, @strlen($v) - 2);
					if ($sec) $r[$sec][$k] = preg_replace('~\\\("|\')~', '$1', $v);
					else $r[$k] = $v;
				}
			}
		}
		
		return $r;
	}
  
  public static function writeIniFile($assoc_arr, $path, $has_sections = FALSE)
	{ 
    $content = ""; 
    if ($has_sections)
		{
      foreach ($assoc_arr as $key => $elem)
			{ 
        $content .= "[".$key."]\n"; 
        foreach ($elem as $key2=>$elem2)
				{ 
          if (is_array($elem2)) 
          { 
            for($i = 0; $i < count($elem2); $i++) 
            { 
              $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
            } 
          } 
          elseif ($elem2=="") $content .= $key2." = \n"; 
          else $content .= $key2." = \"".$elem2."\"\n"; 
        } 
      } 
    } 
    else
		{ 
      foreach ($assoc_arr as $key => $elem)
			{ 
        if (is_array($elem)) 
        { 
          for($i = 0; $i < count($elem); $i++) 
          { 
            $content .= $key2."[] = \"".$elem[$i]."\"\n"; 
          } 
        } 
        elseif ($elem=="") $content .= $key2." = \n"; 
        else $content .= $key2." = \"".$elem."\"\n"; 
      } 
    }

    if (!$handle = @fopen($path, 'w')) return FALSE;
    if (!@fwrite($handle, $content)) return FALSE;
    fclose($handle);
    return TRUE;
  }

  public static function getTimezoneList()
  {
    return array(
	    '-12' => 'International Date Line West',
	    '-11' => 'Midway Island Samoa',
	    '-10' => 'Hawaii',
	    '-9' => 'Alaska',
	    '-8' => array(
			  'Pacific Time (US & Canada)',
				'Tijuna, Baja California'
			),
	    '-7' => array(
			  'Arizona',
				'Chihuahua, La Paz, Mazatlan',
				'Mountain Time (US & Canada)'
			),
	    '-6' => array(
			  'Central America',
				'Central Time (US & Canada)',
				'Guadalajara, Mexico City, Monterrey',
				'Saskatchewan'
			),
	    '-5' => array(
			  'Bogota, Lima, Quito, Rio Branco',
				'Eastern Time (US & Canada)',
				'Indiana (East)'
			),
	    '-4' => array(
			  'Atlantic Time (Canada)',
				'Caracas, La Paz',
				'Manaus',
				'Santiago'
			),
	    '-3.5' => 'Newfoundland',
	    '-3' => array(
			  'Brazilia',
				'Buenos Aires, Georgtown',
				'Greenland',
				'Montevideo'
			),
	    '-2' => 'Mid-Atlantic',
	    '-1' => array(
			  'Azores',
				'Cape Verde Is.'
			),
	    '0' => array(
			  'Casablanka, Monrovia, Reykjavik',
				'GMT: Dublin, Edinburgh, Lisbon, London'
			),
	    '1' => array(
			  'Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
				'Belgrade, Bratislava, Budapest, Ljubljana, Prague',
				'Brussels, Copenhagen, Madrid, Paris',
				'Sarajeva, Skopje, Warsaw, Zagreb',
				'West Central Africa'
			),
	    '2' => array(
			  'Amman',
				'Athens, Bucharest, Istanbul',
				'Beriut',
				'Cario',
				'Harare, Pretoria',
				'Helsinki, Kyiv, Rig, Sofia, Tallin, Vilnius',
				'Jerusalem',
				'Minsk',
				'Windhoek'
			),
	    '3' => array(
			  'Baghdad',
				'Kuwait, Riyadh',
				'Moscow, St. Petersburg, Volgograd',
				'Nairobi',
				'Tbilisi',
				'Tehran'
			),
	    '4' => array(
			  'Abu Dhabi, Muscat',
				'Baku',
				'Yerevan',
				'Kabul'
			),
	    '5' => array(
			  'Ekaterinburg',
				'Islamabad, Karachi, Tashkent'
			),
	    '5.5' => array(
			  'Chennai, Kolkata, Mumbai, New Delhi',
				'Sri Jayawardenepura'
			),
	    '5.75' => 'Kathmandu',
	    '6' => array(
			  'Almaty, Novosibirsk',
				'Astana, Dhaka'
			),
	    '6.5' => 'Yangon (Rangoon)',
	    '7' => array(
			  'Bangkok, Hanoi, Jakarta',
				'Krasnoyarsk'
			),
	    '8' => array(
			  'Beijing, Chongping, Hong Kong, Urmaqi',
				'Irkutsk, Ulaan Bataar',
				'Kuala Lumpur, Singapore',
				'Perth',
				'Taipei'
			),
	    '9' => array(
			  'Osaka, Sapporo, Tokyo',
				'Seoul',
				'Yakutsk'
			),
	    '9.5' => array(
			  'Adelaide',
				'Darwin'
			),
	    '10' => array(
			  'Brisbane',
				'Canberra, Melbourne, Sydney',
				'Guam, Port Moresby',
				'Hobart, Vladivostok'
			),
	    '11' => 'Magadan, Solomon Is., New Caledonia',
	    '12' => array(
			  'Auckland, wellington',
				'Fiji, Kamchatka, Marshall Is.'
			),
	    '13' => 'Nuku\'alofa'
	  );
	}
	
	public static function getPhpTimezone($offset)
	{
	  $zones = array
		(
      'Kwajalein' => -12.00,
      'Pacific/Midway' => -11.00,
      'Pacific/Honolulu' => -10.00,
      'America/Anchorage' => -9.00,
      'America/Los_Angeles' => -8.00,
      'America/Denver' => -7.00,
      'America/Tegucigalpa' => -6.00,
      'America/New_York' => -5.00,
      'America/Caracas' => -4.30,
      'America/Halifax' => -4.00,
      'America/St_Johns' => -3.30,
      'America/Argentina/Buenos_Aires' => -3.00,
      'America/Sao_Paulo' => -3.00,
      'Atlantic/South_Georgia' => -2.00,
      'Atlantic/Azores' => -1.00,
      'Europe/Dublin' => 0,
      'Europe/Belgrade' => 1.00,
      'Europe/Minsk' => 2.00,
      'Asia/Kuwait' => 3.00,
      'Asia/Tehran' => 3.30,
      'Asia/Muscat' => 4.00,
      'Asia/Yekaterinburg' => 5.00,
      'Asia/Kolkata' => 5.30,
      'Asia/Katmandu' => 5.45,
      'Asia/Dhaka' => 6.00,
      'Asia/Rangoon' => 6.30,
      'Asia/Krasnoyarsk' => 7.00,
      'Asia/Brunei' => 8.00,
      'Asia/Seoul' => 9.00,
      'Australia/Darwin' => 9.30,
      'Australia/Canberra' => 10.00,
      'Asia/Magadan' => 11.00,
      'Pacific/Fiji' => 12.00,
      'Pacific/Tongatapu' => 13.00
    );
    
    $i = array_keys($zones, $offset);
    return isset($i[0]) ? $i[0] : FALSE;
	}
}