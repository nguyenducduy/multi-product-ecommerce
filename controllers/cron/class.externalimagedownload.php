<?php

class Controller_Cron_ExternalImageDownload extends Controller_Cron_Base
{
	public function indexAction()
	{

	}
	public function imagenewsdownloadAction()
	{
		$timer = new Timer();
		$timer->start(); // Bắt đầu đếm thời gian để cron
		$count = 0;
		set_time_limit(0);
		$sql = 'SELECT n_content,n_id FROM '.TABLE_PREFIX.'news
                    WHERE n_id > 0
                    AND n_content != ""
                    ORDER BY n_id DESC';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$content = $row['n_content'];

			$myExternalResourceDownload =  new ExternalImageDownload($row['n_id'],$content,'tin tuc');
			$refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/News/');
			$sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'news
                    SET n_content = ?
                    WHERE n_id = ?';
			$this->registry->db->query($sqlUpdate, array($refinedcontent,$row['n_id']));
			$count++;
		}
		$timer->stop();
		echo "Số dòng được Replace Image :".$count."<br/>";
		echo "Tổng số thời gian thực thi : ".$timer->get_exec_time();
		//$externalresourcedownload = new Core_ExternalResourceDownload();
		//$content = preg_replace('', '', $newfullbox);
		//$myExternalResourceDownload = new relaceImage(0,$content);
		//$refinedfullbox = $myExternalResourceDownload->run('/', 'uploads/pimages/Article/');
		//return $refinedfullbox;
	}
	public function imageproductdownloadAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$timer->start(); // Bắt đầu đếm thời gian để cron
		$count = 0;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product
                    WHERE p_id > 0 AND (p_content != "" OR p_fullbox != "")
                    ORDER BY p_id DESC
                    ';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			//xu ly dienmayreview
			//$refineddienmayreview = preg_replace('/\[specs id="\d+"\]/', '', $row['p_dienmayreview']);
			//xữ lý p_fullbox
			$newfullbox = $row['p_fullbox'];
			$myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newfullbox,'San pham');
			$refinedfullbox = $myExternalResourceDownload->run('/', 'uploads/pimages/Products/');
			/////
			//xy ly content
			$newcontent = $row['p_content'];
			$myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newcontent,'San pham');
			$refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/Products/');

			//////////////////
			//////////////////
			// everything ok, update
			$sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'product
                        SET p_content = ?,
                            p_fullbox = ?
                        WHERE p_id = ?';
			$this->registry->db->query($sqlUpdate, array($refinedcontent, $refinedfullbox, $row['p_id']));
			$count++;
		}
		$timer->stop();
		echo "Số dòng được Replace Image: ".$count."<br>";
		echo "Tổng số thời gian thực thi : ".$timer->get_exec_time();

	}
	public function imagenewsdownloadbyidAction()
	{
		//$timer = new Timer();
		//$timer->start(); // Bắt đầu đếm thời gian để cron
		//$count = 0;
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

			$myExternalResourceDownload =  new ExternalImageDownload($id,$content);
			$refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/News/','tin tuc');
			$sql = 'UPDATE ' . TABLE_PREFIX . 'news
                    SET n_content = ?
                    WHERE n_id = ?';
			$this->registry->db->query($sql, array($refinedcontent,$row['n_id']));
			//$count++;
		}
		//$timer->stop();
		//echo "Số dòng được Replace Image :".$count."<br/>";
		//echo "Tổng số thời gian thực thi : ".$timer->get_exec_time();
	}
	public function imageproductdownloadbyidAction()
	{
		set_time_limit(0);
		//$timer = new Timer();
		//$timer->start(); // Bắt đầu đếm thời gian để cron
		//$count = 0;
		$id = $_GET['id'];
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product
                    WHERE p_id = ? AND (p_content != "" OR p_fullbox != "")
                    ORDER BY p_id DESC
                    ';
		$stmt = $this->registry->db->query($sql,array($id));
		while($row = $stmt->fetch())
		{
			//xữ lý p_fullbox
			$newfullbox = $row['p_fullbox'];
			$myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newfullbox,'san pham');
			$refinedfullbox = $myExternalResourceDownload->run('/', 'uploads/pimages/Products/');
			/////
			//xy ly content
			$newcontent = $row['p_content'];
			$myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newcontent,'san pham');
			$refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/Products/');

			//////////////////
			//////////////////
			// everything ok, update
			$sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'product
                        SET p_content = ?,
                            p_fullbox = ?
                        WHERE p_id = ?';
			$this->registry->db->query($sqlUpdate, array($refinedcontent, $refinedfullbox, $row['p_id']));
			//$count++;
		}
		//$timer->stop();
		//echo "Số dòng được Replace Image: ".$count."<br>";
		//echo "Tổng số thời gian thực thi : ".$timer->get_exec_time();
	}
	public function imagepagedownloadbyidAction()
	{
		set_time_limit(0);
		//$timer = new Timer();
		//$timer->start(); // Bắt đầu đếm thời gian để cron
		//$count = 0;
		$id = $_GET['id'];
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'page
                    WHERE p_id = ? AND p_content != ""
                    ORDER BY p_id DESC
                    ';
		$stmt = $this->registry->db->query($sql,array($id));
		while($row = $stmt->fetch())
		{

			//xy ly content
			$newcontent = $row['p_content'];
			$myExternalResourceDownload = new ExternalImageDownload($row['p_id'],$newcontent,'page');
			$refinedcontent = $myExternalResourceDownload->run('/', 'uploads/pimages/Pages/');

			//////////////////
			//////////////////
			// everything ok, update
			$sqlUpdate = 'UPDATE ' . TABLE_PREFIX . 'page
                        SET p_content = ?
                        WHERE p_id = ?';
			$this->registry->db->query($sqlUpdate, array($refinedcontent, $row['p_id']));
			//$count++;
		}
		//$timer->stop();
		//echo "Số dòng được Replace Image: ".$count."<br>";
		//echo "Tổng số thời gian thực thi : ".$timer->get_exec_time();
	}

	/**
	 * Find all content with url containt cache.php
	 * @return
	 */
	public function replaceurlimagecontentAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$timer->start();
		//List of item need replace
		$queueList = array();
		$successCount = $errorCount = 0;

		// Get content Product
		$arrayConditionProduct = array();
		$arrayConditionProduct['fisonsitestatus'] = 1;
		$arrayConditionProduct['fstatus'] = Core_Product::STATUS_ENABLE;
		$arrayConditionProduct['fpricethan0'] = 1;
		$arrayConditionProduct['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
		$arrayConditionProduct['fhasimage'] = Core_Product::STATUS_ENABLE;
		$itemList = Core_Product::getProducts($arrayConditionProduct, 'id', 'DESC', '');

		if(count($itemList) > 0)
		{
			foreach($itemList as $item)
			{
				$imagescontent = ExternalImageDownload::getResourceContent($item->content);
				$imagefullbox = ExternalImageDownload::getResourceContent($item->fullbox);
				if(!empty($imagescontent) || !empty($imagefullbox)){
					$queueList[] = array('type' => 'product', 'obj' => $item,'content' => $item->content, 'imagescontent'=> $imagescontent,'fullbox' => $item->fullbox, 'imagefullbox' => $imagefullbox);
				}
			}
		}

		//Get content News
		$arrayConditionNews = array();
		$itemList = Core_News::getNewss($arrayConditionNews,'id', 'DESC');

		if(count($itemList) > 0)
		{
			foreach ($itemList as $item) {
				$imagescontent = ExternalImageDownload::getResourceContent($item->content);
				if(!empty($imagescontent))
				{
					$queueList[] = array('type' => 'news', 'obj' => $item,'content' => $item->content, 'imagescontent'=> $imagescontent);
				}
			}
		}

		//Get content Page
		$itemList = Core_Page::getPages(array(), 'id', 'DESC');

		if(count($itemList) > 0)
		{
			foreach ($itemList as $item) {
				$imagescontent = ExternalImageDownload::getResourceContent($item->content);
				if(!empty($imagescontent))
				{
					$queueList[] = array('type' => 'page', 'obj' => $item,'content' => $item->content, 'imagescontent'=> $imagescontent);
				}
			}
		}

		if(count($queueList) != 0)
		{
			foreach ($queueList as $queue) {
				if(!empty($queue['imagescontent']))
				{
					$newcontent = $queue['content'];
					foreach ($queue['imagescontent'] as $urlImage) {
						$newcontent = $this->replaceImages($urlImage, $newcontent);
						$queue['obj']->content = $newcontent;
						if($queue['obj']->updateData())
						{
							$successCount++;
						}else {
							$errorCount++;
						}
					}
				}
				if(!empty($queue['imagefullbox']))
				{
					$newfullbox = $queue['fullbox'];
					foreach ($queue['imagefullbox'] as $urlImage) {
						$newfullbox = $this->replaceImages($urlImage, $newfullbox);
						$queue['obj']->fullbox = $newfullbox;
						if($queue['obj']->updateData())
						{
							$successCount++;
						}else {
							$errorCount++;
						}
					}
				}
			}
		}
		$timer->stop();
		echo $successCount . ' url image replace thanh cong<br>';
		echo $errorCount . ' url image replace khong thanh cong<br>';
		echo "Time thuc thi : ".$timer->get_exec_time();
	}

	public function replaceImages($urlImage, $content)
	{
		$oldurl = '"' . $urlImage . '"';
		$urlImage = str_replace('cache.php?src=/', '', $urlImage);
		$url = explode('&', $urlImage)	;
		$urlImage = $url[0];
		$width = str_replace('amp;w=','',$url[1]);
		$height = str_replace('amp;h=','',$url[2]);

		$newurl = '"' . $urlImage . '" width = "' . $width . '" height = "' . $height . '"';
		$newcontent = str_replace($oldurl, $newurl, $content);

		return $newcontent;
	}
}
?>