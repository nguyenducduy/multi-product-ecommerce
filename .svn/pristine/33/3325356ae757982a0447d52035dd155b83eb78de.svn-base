<?php

$thumb = new PlugoBrowser_thumb(PLUGOBROWSER_CACHE_PATH);
$thumb->printThumb();

class PlugoBrowser_thumb
{
  protected static $validMime = array(
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif'
	);
	protected $cachePath = 'cache';
	protected $imEnabled = FALSE;
	protected $isWindows = FALSE;
	protected $inputParams = array(
	  'src' => 'src',
	  'width' => 'w',
	  'height' => 'h',
	  'zoomCrop' => 'zc',
	  'quality' => 'q'
	);
	protected $cleanupInterval = 2;//In days	
	
	public function __construct($cachePath)
	{
	  $this->cachePath = $cachePath;
	  if (substr($this->cachePath, -1) != '/') $this->cachePath .= '/';
	  
    $this->imEnabled = class_exists('Imagick');
    $this->isWindows = stristr(php_uname('s'), 'Windows');

		
		$this->cleanupCache(); 
    
    if (!file_exists($this->cachePath))
		{
      mkdir($this->cachePath);
      umask(0000);
      chmod($this->cachePath, 0777);
    }
	}
	
	public function printThumb($params = array())
	{
	  array_merge($this->inputParams, $params);
	  
	  $width = intval($this->getParameter('width'));
	  $height = intval($this->getParameter('height'));
	  
	  if (!$width && !$height) $this->displayError('No output size defined');
	  
	  $zc = intval($this->getParameter('zoomCrop', 0));
	  $qual = intval($this->getParameter('quality', 90));
	  
	  if (!($src = trim($this->getParameter('src')))) $this->displayError('No source defined');

    if ($this->isWindows) $src = iconv('utf-8', 'cp1250', $src);
		
		if (!file_exists($src)) $this->displayError('File not exists');
		
		$realPath = realpath($src);
		$cacheName = md5($realPath) . '_' . filesize($src) . '_' . $width . '_' . $height . '_' . $zc . '_' . $qual;
		
		$mime = $this->getMimeType($src);
		if (!$this->isValidMime($mime)) $this->displayError('Invalid file type');
		
		if (!$this->checkCacheFile($src, $cacheName))
		{
			$img = $this->openImage($src, $mime);
		  	$this->resizeImage($img, $width, $height, $zc);
		  	$this->saveThumb($img, $cacheName, $mime, $qual);
		}
		
		if (!$this->getCacheFile($cacheName, $mime)) ;
			$this->outputThumb($cacheName, $mime);
	}
	
  protected function getParameter($property, $default = NULL)
  {
    return isset($_GET[$this->inputParams[$property]]) ? $_GET[$this->inputParams[$property]] : $default;
  }
  
  protected function getMimeType($fileName)
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
	    $mimeTypes = array(
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif'
      );

      $ext = pathinfo($fileName, PATHINFO_EXTENSION);
      if (isset($mimeTypes[$ext])) return $mimeTypes[$ext];
	  }
	
	  return FALSE;
  }
  
  protected function isValidMime($mime)
  {
    return in_array($mime, self::$validMime);
  }
  
  protected function displayError($msg = NULL)
  {
    header('HTTP/1.1 400 Bad Request');
    echo '<pre>' . $msg . '</pre>';
    exit;
  }
  
  protected function cleanupCache()
  {
		if ($handle = opendir($this->cachePath))
		{
		  $limit = time() - ($this->cleanupInterval * 60 * 60 * 24);
		  										
  		while (false !== ($fn = readdir($handle)))
	  	{
		  	if ($fn == "." || $fn == "..") continue;
			  if (is_file($this->cachePath . $fn))
  			{
	  		  $modifyTime = filemtime($this->cachePath . $fn);			
		  	  if ($modifyTime < $limit) unlink($this->cachePath . $fn);
			  }			
    	}
    	closedir($handle);
    }    	
	}		  
  
  protected function checkCacheFile($fileName, $cacheFileName)
  {	  
	  clearstatcache();
	  return file_exists($this->cachePath . $cacheFileName) && filemtime($this->cachePath . $cacheFileName) > filemtime($fileName);
	}
  
  protected function getCacheFile($fileName, $mime)
  {
	  $path = $this->cachePath . $fileName;
	  
	  if (file_exists($path))
	  {
  		clearstatcache();
	    $modified = gmdate("D, d M Y H:i:s", filemtime($path));
      if (!strstr($modified, 'GMT')) $modified .= ' GMT';

      if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
  		{
        $modifiedSince = preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE']);
        if ($modifiedSince == $modified)
  			{
          header("HTTP/1.1 304 Not Modified");
          exit;
        }
      }
    
	    header('Last-Modified: ' . $modified);
		  header('Expires: ' . $modified);
		  $this->outputThumb($fileName, $mime);
		}
		else return FALSE;
	}
  
	protected function outputThumb($fileName, $mime)
	{
		$path = $this->cachePath . $fileName;
    
		header('Content-Type: ' . $mime);
		header('Accept-Ranges: bytes');
		header('Content-Length: ' . filesize($path));
		header('Cache-Control: max-age=9999, must-revalidate');
		readfile($path);
		exit;
	}
	
	protected function openImage($path, $mime)
	{
		if ($this->imEnabled)
		{
	    	$img = new Imagick();
	    	if ($this->isWindows) 
				$path = iconv('cp1250', 'utf-8', $path);
			$img->readImage($path);
			return $img;
		}
		else
		{
  	  		switch ($mime)
	  		{
			  	case('image/jpeg'):
				  	return imagecreatefromjpeg($path);
				
	  			case('image/gif'):
		  			return imagecreatefromgif($path);
			
			  	case('image/png'):
				  	if ($img = imagecreatefrompng($path))
				    {
					    imagealphablending($img, true);
	  			    	imagesavealpha($img, true);
		  		  	}
					return $img;
		
			  	default:
				  	return FALSE;
			}
		}
	}
	
	
	protected function saveThumb(&$img, $fileName, $mime, $qual = NULL)
	{
		$path = $this->cachePath . $fileName;
	
		if ($this->imEnabled)
		{
			if ($this->isWindows) 
				$path = iconv('cp1250', 'utf-8', $path);
	    
			if ($qual) 
				$img->setCompressionQuality($qual);
	    
			$img->stripImage();
			$r = $img->writeImages($path, TRUE);
			$img->clear();
			$img->destroy();
		}
		else
		{		  
	    	switch ($mime)
  			{
				case('image/jpeg'):
					$r = @imagejpeg($img, $path, $qual);
		  		break;
	  			
  				case('image/gif'):
			  		$r = @imagegif($img, $path);
		  		break;
	 		
  				case('image/png'):
				  	$r = @imagepng($img, $path);
			  	break;
  			}
  		
		  	imagedestroy($img);
  		}
  	
  		if (isset($r) && $r)
		{
			umask(0000);
	  		chmod($path, 0744);
  		}
  	
  		return $r;
	}
	
	protected function resizeImage(&$img, $w, $h, $zc)
	{
		if ($this->imEnabled)
		{
	    	$tmp = $img->coalesceImages();
	    	$tmp->nextImage();
	    
	    	$origW = $tmp->getImageWidth();
      		$origH = $tmp->getImageHeight();
	  	}
	  	else
	  	{
		  	$origW = imagesx($img);
      		$origH = imagesy($img);
    	}

    	if ($w && !$h) 
			$w = $origH * ($w / $origW);
    	elseif ($h && !$w) 
			$w = $origW * ($h / $origH);

    	if ($zc == 1)
		{
      		$copyX = $copyY = 0;
      		$copyW = $origW;
      		$copyH = $origH;

      		$cmpX = $origW / $w;
      		$cmpY = $origH / $h;

      		if ($cmpX > $cmpY)
			{
        		$copyW = round(($origW / $cmpX * $cmpY));
        		$copyX = round(($origW - ($origW / $cmpX * $cmpY)) / 2);
      		}
			elseif ($cmpY > $cmpX)
			{
        		$copyH = round(($origH / $cmpY * $cmpX));
        		$copyY = round(($origH - ($origH / $cmpY * $cmpX)) / 2);
      		}
      
      		if ($this->imEnabled)
			{
			  	$img = $img->coalesceImages();
        		do 
				{
          			$img->cropImage($copyW, $copyH, $copyX, $copyY);
			    	$img->resizeImage($w, $h, Imagick::FILTER_LANCZOS, 1);
        		} 
				while ($img->nextImage());
        		$img = $img->deconstructImages();
			}
	    	else
	    	{
		    	$r = imagecreatetruecolor($w, $w);
	  	  		imagecopyresampled($r, $img, 0, 0, $copyX, $copyY, $w, $h, $copyW, $copyH);
	  	  		imagedestroy($img);
	  	  		$img = $r;
  			}
    	}
    	else
		{
      		$newRatio = $w / $h;
			if ($origW <= $w && $origH <= $h)
			{
				$w = $origW;
				$h = $origH;
			}
			else
			{
			  	if ($origW > round($origH * $newRatio, 0))
				{
	  				$ratio = $origW / $origH;
  		    		$h = round($w / $ratio, 0);
			  	}
			  	elseif ($origW < round($origH * $newRatio, 0))
				{
		      		$ratio = $origH / $origW;
	    	  		$w = round($h / $ratio, 0);
		    	}
	    	}
	    
	    	if ($this->imEnabled)
			{
			  	$img = $img->coalesceImages();
        		do 
				{
			    	$img->resizeImage($w, $h, Imagick::FILTER_LANCZOS, 1);
        		} 
				while ($img->nextImage());
        		$img = $img->deconstructImages();
			}
	    	else
	    	{
		    	$r = imagecreatetruecolor($w, $h);
	  	  		imagecopyresampled($r, $img, 0, 0, 0, 0, $w, $h, $origW, $origH);
	  	  		imagedestroy($img);
	  	  		$img = $r;
  			}
    	}
    
    	return TRUE;
	}
}