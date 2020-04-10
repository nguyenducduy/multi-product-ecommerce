<?php

/**
 * Class dung de download cac resource tu ngoai domain va luu tren he thong local
 */
class Core_ExternalResourceDownload
{
	public $rawcontent;
	
	public function __construct($id = 0, $rawcontent = '')
	{
		parent::__construct();

		if($id > 0)
		{
			$this->getData($id);
		}
		
		$this->rawcontent = $rawcontent;
	}
	
	
	/**
	 * Tien hanh phan tich noi dung
	 */
	function run($domainAppend, $saveToDirectory, $internalDomains = array(), &$externalSuccessDownloadList = array(), &$externalErrorDownloadList = array())
	{
		
		////////////////////////////////////////////
		//get Image resource in html content
		$resourceList = $this->getResourceList($this->rawcontent);
		$internalUrls = array();
		$externalUrls = array();
		
		//////////////////////////////////////////
		//get all External Url
		if(count($resourceList) > 0)
		{
			foreach($resourceList as $url)
			{
				$urlinfo = parse_url($url);
				
				//detect whether internal link or not
				if($this->isInternalDomain($internalDomains, $urlinfo['host']))
					$internalUrls[] = $url;
				else
					$externalUrls[] = $url;
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
			    $namePart =  substr($filename, 0, strrpos($filename, '.'));
				
				$destination = $saveToDirectory . $curDateDir . $namePart . '.' . $extPart;
				
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
				if(file_exists($saveToDirectory . $curDateDir) && Helper::saveExternalFile($url, $destination))
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
				$url = $info[0];
				$replaceurl = $domainAppend . $info[1];
				
				$this->rawcontent = str_replace($url, $replaceurl, $this->rawcontent);
			}
		}
		// End update content
		////////////////////////
		
		return $this->rawcontent;
	}
	
	private function isInternalDomain($internalDomains = array(), $host)
	{
		if(count($internalDomains) == 0)
			$internalDomains = array('dienmay.com', 'tgdt.vn');
		
		$isInternal = false;
		
		//Rule here, the internalDomains appear in the source host
		foreach($internalDomains as $internalDomain)
		{
			if(strpos($host, $internalDomain) !== false)
				$isInternal = true;
		}
		
		return $isInternal;
	}
	
	/**
	 * Return all resource/url related to this html content
	 */
	private function getResourceList($html)
	{
		$resourceList = array();
		
		preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $html, $matches);

		if(count($matches) > 0)
		{
			$resourceList = $matches[1];
		}
		
		
		return $resourceList;
	}
	
	
	
}
