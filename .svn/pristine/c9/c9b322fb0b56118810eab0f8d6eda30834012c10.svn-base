<?php
Class ContentRelace{
    public function __construct()
    {

    }
    public static function replaceHttpsImageContent($httpsLink,$rawcontent,$internalDomains = array())
    {
        $resourceList = ExternalImageDownload::getResourceList($rawcontent);
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
                if(ExternalImageDownload::isInternalDomain($internalDomains, $urlinfo['host']))
                    $internalUrls[] = $url;
                else
                    $externalUrls[] = $url;
            }
        }
        ////////////////////////////
        //Download external Url file
        $externalSuccessDownloadList = array();
        $externalErrorDownloadList = array();

        if(count($externalUrls) > 0)
        {
            foreach($externalUrls as $url)
            {
                $url_encode = base64_encode($url);
                $rawcontent = str_replace($url,$httpsLink."?url=".$url_encode, $rawcontent);
            }
        }
        return $rawcontent;
    }

    public static function replaceContentImagesFTP($domainftp,$url, $rawcontent)
    {
        $rawcontent = str_replace($url, $domainftp, $rawcontent);
        return $rawcontent;
    }
}
?>