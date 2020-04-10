<?php
/**
 * User: Nguyen Phan
 * Date: 8/2/13
 * Time: 10:32 AM
 * To change this template use File | Settings | File Templates.
 */
class Controller_Task_ExternalImageDownload extends Controller_Task_Base
{
    public function indexAction()
    {

    }
    public function imagenewsdownloadbyidAction()
    {
        $id = $_GET['id'];
        set_time_limit(0);
        $sql = 'SELECT n_content,n_id FROM '.TABLE_PREFIX.'news
                WHERE n_id = ?
                AND n_content != ""
                ORDER BY n_id DESC';

        $stmt = $this->registry->db->query($sql,array($id));
        while($row = $stmt->fetch())
        {
            $content = $row['n_content'];
            $myExternalResourceDownload =  new ExternalImageDownload($id,$content,'tin tuc');
            $refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/News/');

            // upload image on server 40 - tgdt.vn and relace content
            $ftpContent = $this->ftpImagesContent($refinedcontent);

            $sql = 'UPDATE ' . TABLE_PREFIX . 'news
                SET n_content = ?
                WHERE n_id = ?';
            $this->registry->db->query($sql, array($ftpContent,$row['n_id']));
        }
    }
    public function imageproductdownloadbyidAction()
    {
        set_time_limit(0);
        $id = $_GET['id'];
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product
                WHERE p_id = ? AND (p_content != "" OR p_fullbox != "")
                ORDER BY p_id DESC
                ';
        $stmt = $this->registry->db->query($sql,array($id));
        while($row = $stmt->fetch())
        {
            //xử lý p_fullbox
            $newfullbox = $row['p_fullbox'];
            $myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newfullbox,'san pham');
            $refinedfullbox = $myExternalResourceDownload->run('/', 'uploads/pimages/Products/');
            // Upload image on server 40 - tgdt.vn
            $ftpFullbox = $this->ftpImagesContent($refinedfullbox);

            //xử lý content
            $newcontent = $row['p_content'];
            $myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newcontent,'san pham');
            $refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/Products/');
            // Upload image on server 40 - tgdt.vn
            $ftpContent  = $this->ftpImagesContent($refinedcontent);

            // everything ok, update
            $sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'product
                    SET p_content = ?,
                        p_fullbox = ?
                    WHERE p_id = ?';
            $this->registry->db->query($sqlUpdate, array($ftpContent, $ftpFullbox, $row['p_id']));
        }
    }
    public function imagepagedownloadbyidAction()
    {
        set_time_limit(0);
        $id = $_GET['id'];
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'page
                WHERE p_id = ? AND p_content != ""
                ORDER BY p_id DESC
                ';
        $stmt = $this->registry->db->query($sql,array($id));
        while($row = $stmt->fetch())
        {
            //xử lý content
            $newcontent = $row['p_content'];
            $myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newcontent,'page');
            $refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/Pages/');

            // upload image on server 40 - tgdt.vn and relace content
            $ftpContent = $this->ftpImagesContent($refinedcontent);

            // everything ok, update
            $sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'page
                    SET p_content = ?
                    WHERE p_id = ?';
            $this->registry->db->query($sqlUpdate, array($ftpContent, $row['p_id']));
        }
    }
    
	public function imagehomepagedownloadbyidAction()
    {
        set_time_limit(0);
        $id = $_GET['id'];
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'homepage
                WHERE h_id = ? AND (h_blockbannerright != "" OR h_blockhomepage != "")
                ';
        $stmt = $this->registry->db->query($sql,array($id));
        while($row = $stmt->fetch())
        {
        	
        	//xử lý h_blockhomepage
            $newblockhomepage = $row['h_blockhomepage'];
            $myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newblockhomepage,'banner right');
            $refinedblockhomepage = $myExternalResourceDownload->run('/', 'uploads/pimages/bannerright/');
            // Upload image on server 40 - tgdt.vn
            $ftpBlockhomepage  = $this->ftpImagesContent($refinedblockhomepage);
        	
            //xử lý h_blockbannerright
            $newcontent = $row['h_blockbannerright'];
            $myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newcontent,'banner right');
            $refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/bannerright/');
            // Upload image on server 40 - tgdt.vn
            $ftpContent  = $this->ftpImagesContent($refinedcontent);

            // everything ok, update
            $sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'homepage
                    SET h_blockhomepage = ?,
                    	h_blockbannerright = ?
                    WHERE h_id = ?';
            $this->registry->db->query($sqlUpdate, array($ftpBlockhomepage, $ftpContent, $row['h_id']));
        }
    }

    public function ftpImagesContent($content){
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        //FTP List
        $resourceserverFtpList = array(
            array('id' => 1, 'ipaddress' => '172.16.141.40', 'username' => 'admin', 'password' => 'Dienmay#2013!')
        );

        //List of item need to be upload to resource server
        $successCount = $errorCount = 0;

        $imagesContent = ExternalImageDownload::getResourceList($content);

        if(count($imagesContent) == 0)
        {
            return $content;
        }
        else
        {
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
        }

        //Connect OK, PUT file to ftp server
        $createdDirectoryList = array();
        $ftpContent = $content;
        if(is_array($imagesContent))
        {
            foreach($imagesContent as $urlimages)
            {
            	$host = parse_url($urlimages, PHP_URL_HOST);
            	if(empty($host))
            		$host = "dienmay.com";
            	if(!ExternalImageDownload::isInternalDomain(array('tgdt.vn'), $host)){
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
	                        $ftpContent = ContentRelace::replaceContentImagesFTP($domainUrl ,$urlimages, $ftpContent);
	                    }else
	                        $errorCount++;
	
	                }//end file_exists()
	                else
	                {
	                    $errorCount++;
	                    echo 'File not found: ' . $sourceFilePath . '. ' . "\n";
	                }
	            }
            }
        }//end empty image
        $myFtp->close();

        return $ftpContent;
    }
}
?>