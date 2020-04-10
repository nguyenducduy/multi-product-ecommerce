<?php
Abstract Class ExtractPrice
{
    public static function regularExpressionURL($url)
    {
        //$parttern = '#^http(s)?://(www.)?[a-z0-9-]+(.[a-z0-9-]+)#'; //http://www.abc.com || http://abc.com
        $sourceUrl = parse_url($url);
        $sourceUrl = $sourceUrl['host'];
        $sourceUrl = preg_split('[\.]',$sourceUrl);
        return trim($sourceUrl[count($sourceUrl)-2]);
    }

    public static function isValidURL($url)
	{
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}

    public function getResource($domainAppend,$externalUrls="",$saveToDirectory,&$externalSuccessDownload ="", &$externalErrorDownload = "")
    {
        global $registry;
        if(count($externalUrls) > 0)
        {
            $filename = substr($externalUrls, strrpos($externalUrls, '/') + 1);
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

            $namePart =  urldecode(substr($filename, 0, strrpos($filename, '.')));
            $namePart = preg_replace('([^a-zA-Z0-9])', '_', strip_tags($namePart));

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
            if(file_exists($saveToDirectory . $curDateDir) && Helper::saveExternalFile($externalUrls, $destination,'image',false))
            {
                $internalUrl = $registry->conf['rooturl'].$destination;
            }
        }
        /*$ftpUrl = ftpImagesContent($internalUrl);
        if($ftpUrl != "")
        {
            return $ftpUrl;
        }*/
        return $internalUrl;
    }
    public function ftpImagesContent($internalUrl){
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        //FTP List
        $resourceserverFtpList = array(
            array('id' => 1, 'ipaddress' => '172.16.141.40', 'username' => 'admin', 'password' => 'Dienmay#2013!')
        );
        //List of item need to be upload to resource server
        $successCount = $errorCount = 0;
        try
        {
            $ftpServer = $resourceserverFtpList[0];
            $myFtp = new Ftp();
            $myFtp->connect($ftpServer['ipaddress']);
            $myFtp->login($ftpServer['username'], $ftpServer['password']);
            $myFtp->pasv(true);
        }
        catch(FtpException $e)
        {
            die('Error: ' . $e->getMessage());
        }
        //Connect OK, PUT file to ftp server
        $createdDirectoryList = array();
        $urlimages = $internalUrl;
        if($urlimages != "")
        {
            //Tien hanh upload toi resource server thong qua FTP
            $resourceserverpassed = false;
            $url = parse_url($urlimages, PHP_URL_PATH);
            $url = substr($url,1);

            $destinationFilePath = urldecode($url);
            $sourceFilePath = urldecode($url);

            if(file_exists($sourceFilePath))
            {
                $extPart = substr(strrchr($url,'.'),1);
                $lastSlashPos = strrpos($destinationFilePath, '/');

                //PROCESS DIRECTORY ON REMOTE SERVER
                //if not existed, create this directory
                $filename = substr($destinationFilePath, $lastSlashPos + 1);
                $filedir = substr($destinationFilePath, 0, $lastSlashPos);

                if(!in_array($filedir, $createdDirectoryList))
                {
                    $myFtp->mkDirRecursive($filedir);
                    $createdDirectoryList[] = $filedir;
                }
                //Directory OK, start upload file
                try{
                    $myFtp->put($destinationFilePath, $sourceFilePath, FTP_BINARY);
                    $resourceserverpassed = true;

                }catch (FtpException $e)
                {
                    echo 'Can not Upload file ' . $sourceFilePath . '. ' . "\n";
                    $errorCount++;
                    continue;
                }//end PUT file

                if($resourceserverpassed){
                    $filedir = explode('/', $filedir, 2);
                    $domainUrl = 'http://dienmay.myhost/' .$filedir[1].'/'. $filename;
                }else
                    $errorCount++;

            }//end file_exists()
            else
            {
                $errorCount++;
                echo 'File not found: ' . $sourceFilePath . '. ' . "\n";
            }
        }//end empty image
        $myFtp->close();

        return $domainUrl;
    }
	abstract protected function run($url);
}