﻿<?php

Class ExternalImageDownload {
	public $rawcontent;
	public $id;
	public $name;
	public $urlroot='';
	public function __construct($id = 0, $rawcontent = '',$name='')
	{
		//parent::__construct();
		/*if($id > 0)
		 {
		 $this->getData($id);
		 }*/
		$this->rawcontent = $rawcontent;
		if($id > 0)
		$this->id = $id;
		$this->name = $name;

	}

	/**
	 * Tien hanh phan tich noi dung
	 */
	function run($domainAppend, $saveToDirectory, $internalDomains = array(), &$externalSuccessDownloadList = array(), &$externalErrorDownloadList = array())
	{

		////////////////////////////////////////////
		//get Image resource in html content
		$resourceList = ExternalImageDownload::getResourceList($this->rawcontent);
		$internalUrls = array();
		$externalUrls = array();

		//////////////////////////////////////////
		//get all External Url
		if(count($resourceList) > 0)
		{

			foreach($resourceList as $url)
			{
				if(strpos($url,'url'))
				{
					$urltmp = explode("=",$url,2);
					$this->urlroot = $urltmp[0].'=';
					$url = base64_decode($urltmp[1]);
					$urlinfo = parse_url($url);

				}
				else{
					$urlinfo = parse_url($url);

				}
				//detect whether internal link or not
				if(ExternalImageDownload::isInternalDomain($internalDomains, $urlinfo['host']))
				{
					$internalUrls[] = $url;
				}
				else
				{
					$externalUrls[] = $url;
				}
			}
		}
		//end get external url
		////////////////////////////
		//Download external Url file
		$externalSuccessDownloadList = array();
		$externalErrorDownloadList = array();
		if(count($externalUrls) > 0)
		{
			foreach($externalUrls as $url)
			{
				//Get file name
				$filename = substr($url, strrpos($url, '/') + 1);

				$curDateDir = Helper::getCurrentDateDirName();

				$extPart = substr(strrchr($filename,'.'),1);
				if(strpos($extPart,"?") !== false)
				{
					$extPart = explode("?",$extPart);
					$extPart = $extPart[0];
				}
				if(strpos($extPart,"&") !== false)
				{
					$extPart = explode("&",$extPart);
					$extPart = $extPart[0];
				}
				//echo $extPart."<br>";

				$namePart =  urldecode(substr($filename, 0, strrpos($filename, '.')));
				$namePart = preg_replace('([^a-zA-Z0-9])', '_', strip_tags($namePart));

				$destination = $saveToDirectory . $curDateDir . $namePart . '.' . $extPart;

				//echo $destination."<br>";
				//check existed directory
				if(!file_exists($saveToDirectory . $curDateDir))
				{
					mkdir($saveToDirectory . $curDateDir, 0777, true);
				}
				 
				//Prevent duplicate file
				$i = 1;
				while(file_exists($destination))
				{
					$destination = $saveToDirectory . $curDateDir . $namePart . '-'.$i++.'.' . $extPart;
					 
				}
				//Start Download External Resource
				if(file_exists($saveToDirectory . $curDateDir) && Helper::saveExternalFile($url, $destination,'image',false))
				{
					$externalSuccessDownloadList[] = array($url, $destination);
				}
				else
				{
					$externalErrorDownloadList[] = array($url, $destination);
				}
			}
		}
		// End download external Url
		/////////////////////////

		//////////////////////////
		// Update success external Url to content
		if(count($externalSuccessDownloadList) > 0)
		{
			foreach($externalSuccessDownloadList as $info)
			{

				$url = $this->urlroot != '' ? $this->urlroot.base64_encode($info[0]):$info[0];
				$replaceurl = $domainAppend . $info[1];
				$this->rawcontent = str_replace($url, $replaceurl, $this->rawcontent);
			}
		}
		if(count($externalErrorDownloadList) > 0)
		{
			foreach($externalErrorDownloadList as $error)
			{
				$url = $this->urlroot != '' ? $this->urlroot.base64_encode($error[0]):$error[0];
				$this->rawcontent = str_replace($url, '' , $this->rawcontent);
				ExternalImageDownload::writeLogImageDownload($conf['host']."logimagedownload.txt",$this->name."-ID=".$this->id.":".$url."\n");

			}
		}
		// End update content
		////////////////////////

		return $this->rawcontent;
	}
	public static function isInternalDomain($internalDomains = array(), $host)
	{
		if(count($internalDomains) == 0)
		$internalDomains = array('dienmay.com', 'tgdt.vn',' ');

		$isInternal = false;

		//Rule here, the internalDomains appear in the source host
		foreach($internalDomains as $internalDomain)
		{
			if(strpos($host, $internalDomain) !== false || $host == '')
			$isInternal = true;
		}

		return $isInternal;
	}

	/**
	 * Return all resource/url related to this html content
	 */
	public static function getResourceList($html)
	{
		$resourceList = array();
		preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $html, $matches);
		if(count($matches) > 0)
		{
			$resourceList = $matches[1];
		}
		return $resourceList;
	}

	public static function getJavacriptResourcetList($html)
	{
		$resourceList = array();
		preg_match_all('/< *script[^>]*src *= *["\']?([^"\']*)/i', $html, $matches);
		if(count($matches) > 0)
		{
			$resourceList = $matches[1];
		}
		return $resourceList;
	}

	public static function getCssResourceList($html)
	{
		$resourceList = array();
		preg_match_all('/< *link[^>]*href *= *["\']?([^"\']*)/i', $html, $matches);
		if(count($matches) > 0)
		{
			$resourceList = $matches[1];
		}
		return $resourceList;
	}

	public static function writeLogImageDownload( $path, $content)
	{
		$file=file($path);
		$file[]= $content;
		file_put_contents($path,$file);
	}
	public static function runCron($url)
	{
		// run cron relace image
		// create a new cURL resource
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		// grab URL and pass it to the browser
		curl_exec($ch);
		// close cURL resource, and free up system resources
		curl_close($ch);
		//End run cron relace image

	}

	/**
	 * Get url in image with character cache.php
	 * @return url
	 */
	public function getResourceContent($html)
	{	
		$resourceList = array();
		preg_match_all('/< *img\ssrc*= *["]?([^"]*)/i', $html, $matches);
		if(count($matches) > 0)
		{
			foreach ($matches[1] as $match) {
				if (strpos($match, 'cache.php')){
					$resourceList[] = $match;
				}
			}
		}
		return $resourceList;
	}
}
?>