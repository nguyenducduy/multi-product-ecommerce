<?php

/**
 * XML Sitemap PHP Script
 */

class Controller_Cron_Sitemap extends Controller_Cron_Base
{
	protected $dir = 'sitemap';

	public function indexAction()
	{
		$listsitemap = Core_Backend_Sitemap::getSitemaps(array(), '', '');
		foreach ($listsitemap as $sitemap) {
			if ($sitemap->name == 'sitemap-sanpham')
				$this->sitemapproductAction();
			if ($sitemap->name == 'sitemap-nganhhang')
				$this->sitemapcategoryAction();
			if ($sitemap->name == 'sitemap-nganhhang-thuonghieu')
				$this->sitemapbrandcategoryAction();
			if ($sitemap->name == 'sitemap-thuonghieu')
				$this->sitemapvendorAction();
			if($sitemap->name == 'sitemap-tintuc')
				$this->sitemapnewsAction();
			if ($sitemap->name == 'sitemap-images')
				$this->sitemapimagesAction();
		}
		$this->sitemapAction();
	}
	
	/**
	 * Generator sitemap.xml
	 * @return XML Sitemap
	 */
	public function sitemapAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		//Create dir
		if(!is_dir($this->dir))
		mkdir($this->dir);
		$fp = fopen($this->dir. '/sitemap.xml', 'w+');
		// Infomation xml
		$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
		fwrite($fp, $header_xml);
		$getfile = glob('sitemap/*.*');
		foreach($getfile as $filename){
			$url = $this->registry->conf['root_url'] . $filename;
			$date = date ("Y-m-d H:i:s", filemtime($filename));
			$xml_content = "<sitemap>\n<loc>" . $url . "</loc>\n<lastmod>". $date ."</lastmod>\n</sitemap>\n";
			fwrite($fp, $xml_content);
			$counter++;
		}
		$footer_xml = "</sitemapindex>";
		fwrite($fp, $footer_xml);
		fclose($fp);
		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br />';
		echo 'So record thuc thi la : ' . $counter . '<br />';
		echo "Done! Click <a href=". $this->registry->conf['root_url'] ."/sitemap/sitemap.xml alt=\"Site-Map\" title=\"Site Map\">Sitemap</a><br /><br />";
	}

	/**
	 * Generator sitemap for product
	 * @return XML Sitemap
	 */
	public function sitemapproductAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		
		//Get setting sitemap
		$config_sitemap = Core_Backend_Sitemap::getSitemaps(array('fname' => 'sitemap-sanpham'), '', '', 1);
		if(!empty($config_sitemap)){
			$changefreq = $config_sitemap[0]->getChangefregName();
			$priority = $config_sitemap[0]->priority;
			$lastchanged = $config_sitemap[0]->lastchanged;
		}else{
			$changefreq = 'hourly';
			$priority = '0.9';
		}
		
		if($this->gettimeexecute($config_sitemap[0]->changefreq, $lastchanged)){
		
			//Create dir
			if(!is_dir($this->dir))
			mkdir($this->dir);
			$fp = fopen($this->dir. '/sitemap-sanpham.xml', 'w+');
			// Infomation xml
			$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			fwrite($fp, $header_xml);
			$xml_content_default = "<url>\n<loc>http://dienmay.com/</loc>\n<changefreq>always</changefreq>\n<priority>1.00</priority>\n</url>\n";
			fwrite($fp, $xml_content_default);
	
			// Get all product avalible
			$arrayConditionProduct = array();
			$arrayConditionProduct['fisonsitestatus'] = 1;
			$arrayConditionProduct['fstatus'] = Core_Product::STATUS_ENABLE;
			$arrayConditionProduct['fpricethan0'] = 1;
			$arrayConditionProduct['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
			
			$totalRecord = Core_Product::getProducts($arrayConditionProduct, '', '','',true);
	
			$recordperpage = 500;
			$totalPage = ceil($totalRecord / $recordperpage);
			$totalaffected = 0;
			for ($i = 0; $i < $totalPage; $i++) {
				$offset = $i * $recordperpage;
				$listproduct = Core_Product::getProducts($arrayConditionProduct, 'id', 'DESC', $offset . ',' . $recordperpage);
				foreach ($listproduct as $product) {
					if($product->slug != ''){
						$url = $product->getProductPath();
						$date = date("Y-m-d");
						$xml_content = "<url>\n<loc>" . $url . "</loc>\n<lastmod>". $date ."</lastmod>\n<changefreq>". $changefreq ."</changefreq>\n<priority>". $priority ."</priority>\n</url>\n";
						fwrite($fp, $xml_content);
						$counter++;
					}
				}
			}
			$footer_xml = "</urlset>";
			fwrite($fp, $footer_xml);
			fclose($fp);
			
			// update lastchange
			$config_sitemap[0]->lastchanged = time();
			$config_sitemap[0]->updateData();
			
			$timer->stop();
			echo 'time : ' . $timer->get_exec_time() . '<br />';
			echo 'So record thuc thi la : ' . $counter . '<br />';
			echo "Done! Click <a href=". $this->registry->conf['root_url'] ."/sitemap/sitemap-sanpham.xml alt=\"Site-Map-Product\" title=\"Site Map Product\">Sitemap San Pham</a><br /><br />";
		}
	}

	/**
	 * Grenrator sitemap for Category
	 * @return XML Sitemap
	 */
	public function sitemapcategoryAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		
		//Get setting sitemap
		$config_sitemap = Core_Backend_Sitemap::getSitemaps(array('fname' => 'sitemap-nganhhang'), '', '', 1);
		if(!empty($config_sitemap)){
			$changefreq = $config_sitemap[0]->getChangefregName();
			$priority = $config_sitemap[0]->priority;
			$lastchanged = $config_sitemap[0]->lastchanged;
		}else{
			$changefreq = 'hourly';
			$priority = '0.9';
		}
		
		if($this->gettimeexecute($config_sitemap[0]->changefreq, $lastchanged)){

			if(!is_dir($this->dir))
			mkdir($this->dir);
			$fp = fopen($this->dir . '/sitemap-nganhhang.xml', 'w+');
			// Infomation xml
			$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			fwrite($fp, $header_xml);
			$xml_content_default = "<url>\n<loc>http://dienmay.com/</loc>\n<changefreq>always</changefreq>\n<priority>1.00</priority>\n</url>\n";
			fwrite($fp, $xml_content_default);
			// Get all category avalible
			$listrootcategory = Core_Productcategory::getRootProductcategory();
			foreach ($listrootcategory as $rootcate) {
				$url = $rootcate->getProductcateoryPath();
				$date = date("Y-m-d");
				$xml_content = "<url>\n<loc>" . $url . "</loc>\n<lastmod>". $date ."</lastmod>\n<changefreq>". $changefreq ."</changefreq>\n<priority>". $priority ."</priority>\n</url>\n";
				fwrite($fp, $xml_content);
				$counter++;
			}
			$footer_xml = "</urlset>";
			fwrite($fp, $footer_xml);
			fclose($fp);
			
			// update lastchange
			$config_sitemap[0]->lastchanged = time();
			$config_sitemap[0]->updateData();
			
			$timer->stop();
			echo 'time : ' . $timer->get_exec_time() . '<br />';
			echo 'So record thuc thi la : ' . $counter . '<br />';
			echo "Done! Click <a href=". $this->registry->conf['root_url'] ."/sitemap/sitemap-nganhhang.xml alt=\"Site-Map-Category\" title=\"Site Map Category\">Sitemap Nganh hang</a><br /><br />";
		}
	}

	/**
	 * Grenrator sitemap for Vendor
	 * @return XML Sitemap
	 */
	public function sitemapvendorAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		
		//Get setting sitemap
		$config_sitemap = Core_Backend_Sitemap::getSitemaps(array('fname' => 'sitemap-thuonghieu'), '', '', 1);
		if(!empty($config_sitemap)){
			$changefreq = $config_sitemap[0]->getChangefregName();
			$priority = $config_sitemap[0]->priority;
			$lastchanged = $config_sitemap[0]->lastchanged;
		}else{
			$changefreq = 'hourly';
			$priority = '0.9';
		}

		if($this->gettimeexecute($config_sitemap[0]->changefreq, $lastchanged)){
		
			if(!is_dir($this->dir))
			mkdir($this->dir);
			$fp = fopen($this->dir . '/sitemap-thuonghieu.xml', 'w+');
			// Infomation xml
			$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			fwrite($fp, $header_xml);
			$xml_content_default = "<url>\n<loc>http://dienmay.com/</loc>\n<changefreq>always</changefreq>\n<priority>1.00</priority>\n</url>\n";
			fwrite($fp, $xml_content_default);
			// Get all vendor avalible
			$arrConditionVendor = array();
			$arrConditionVendor['fstatus'] = Core_Vendor::STATUS_ENABLE;
			$listVendor = Core_Vendor::getVendors($arrConditionVendor, 'id', 'DESC');
			foreach ($listVendor as $vendor) {
				$url = $vendor->getVendorPath();
				$date = date("Y-m-d");
				$xml_content = "<url>\n<loc>" . $url . "</loc>\n<lastmod>". $date ."</lastmod>\n<changefreq>". $changefreq ."</changefreq>\n<priority>" . $priority . "</priority>\n</url>\n";
				fwrite($fp, $xml_content);
				$counter++;
			}
			$footer_xml = "</urlset>";
			fwrite($fp, $footer_xml);
			fclose($fp);
			
			// update lastchange
			$config_sitemap[0]->lastchanged = time();
			$config_sitemap[0]->updateData();
			
			$timer->stop();
			echo 'time : ' . $timer->get_exec_time() . '<br />';
			echo 'So record thuc thi la : ' . $counter . '<br />';
			echo "Done! Click <a href=". $this->registry->conf['root_url'] ."/sitemap/sitemap-thuonghieu.xml alt=\"Site-Map-Vendor\" title=\"Site Map Vendor\">Sitemap Thuong hieu</a><br /><br />";
		}
	}

	/**
	 * Grenrator sitemap for Brand Category
	 * @return XML Sitemap
	 */
	public function sitemapbrandcategoryAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		
		//Get setting sitemap
		$config_sitemap = Core_Backend_Sitemap::getSitemaps(array('fname' => 'sitemap-nganhhang-thuonghieu'), '', '', 1);
		if(!empty($config_sitemap)){
			$changefreq = $config_sitemap[0]->getChangefregName();
			$priority = $config_sitemap[0]->priority;
			$lastchanged = $config_sitemap[0]->lastchanged;
		}else{
			$changefreq = 'hourly';
			$priority = '0.9';
		}
		
		if($this->gettimeexecute($config_sitemap[0]->changefreq, $lastchanged)){

			if(!is_dir($this->dir))
			mkdir($this->dir);
			$fp = fopen($this->dir . '/sitemap-nganhhang-thuonghieu.xml', 'w+');
			// Infomation xml
			$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			fwrite($fp, $header_xml);
			$xml_content_default = "<url>\n<loc>http://dienmay.com/</loc>\n<changefreq>always</changefreq>\n<priority>1.00</priority>\n</url>\n";
			fwrite($fp, $xml_content_default);
			// Get all Brand Category avalible
			$arrConditionBrandcategory = array();
			$listBrandCategory = Core_BrandCategory::getBrandCategorys($arrConditionBrandcategory, 'id', 'DESC');
			foreach ($listBrandCategory as $brandcate) {
				$myVendor = new Core_Vendor($brandcate->vid);
				$url = $myVendor->getVendorPath($brandcate->pcid);
				$date = date("Y-m-d");
				$xml_content = "<url>\n<loc>" . $url . "</loc>\n<lastmod>". $date ."</lastmod>\n<changefreq>" . $changefreq . "</changefreq>\n<priority>" . $priority . "</priority>\n</url>\n";
				fwrite($fp, $xml_content);
				$counter++;
			}
			$footer_xml = "</urlset>";
			fwrite($fp, $footer_xml);
			fclose($fp);
			
			// update lastchange
			$config_sitemap[0]->lastchanged = time();
			$config_sitemap[0]->updateData();
			
			$timer->stop();
			echo 'time : ' . $timer->get_exec_time() . '<br />';
			echo 'So record thuc thi la : ' . $counter . '<br />';
			echo "Done! Click <a href=". $this->registry->conf['root_url'] ."/sitemap/sitemap-nganhhang-thuonghieu.xml alt=\"Site-Map-Brand-category\" title=\"Site Map Brand Category\">Sitemap Thuong hieu nganh hang</a><br /><br />";
		}
	}

	/**
	 * Grenrator sitemap for News
	 * @return XML Sitemap
	 */
	public function sitemapnewsAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		
		//Get setting sitemap
		$config_sitemap = Core_Backend_Sitemap::getSitemaps(array('fname' => 'sitemap-tintuc'), '', '', 1);
		if(!empty($config_sitemap)){
			$changefreq = $config_sitemap[0]->getChangefregName();
			$priority = $config_sitemap[0]->priority;
			$lastchanged = $config_sitemap[0]->lastchanged;
		}else{
			$changefreq = 'hourly';
			$priority = '0.9';
		}
		
		if($this->gettimeexecute($config_sitemap[0]->changefreq, $lastchanged)){

			if(!is_dir($this->dir))
			mkdir($this->dir);
			$fp = fopen($this->dir . '/sitemap-tintuc.xml', 'w+');
			// Infomation xml
			$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			fwrite($fp, $header_xml);
			$xml_content_default = "<url>\n<loc>http://dienmay.com/</loc>\n<changefreq>" . $changefreq . "</changefreq>\n<priority>" . $priority . "</priority>\n</url>\n";
			fwrite($fp, $xml_content_default);
			//Get all News avalible
			$arrConditionNews = array();
			$arrConditionNews['fstatus'] = Core_News::STATUS_ENABLE;
			$listNews = Core_News::getNewss($arrConditionNews, 'id', 'DESC');
			foreach ($listNews as $news) {
				if($news->slug != ''){
					$url = $news->getNewsPath();
					$date = date("Y-m-d");
					$xml_content = "<url>\n<loc>" . $url . "</loc>\n<lastmod>". $date ."</lastmod>\n<changefreq>hourly</changefreq>\n<priority>0.9</priority>\n</url>\n";
					fwrite($fp, $xml_content);
					$counter++;
				}
			}
			$footer_xml = "</urlset>";
			fwrite($fp, $footer_xml);
			fclose($fp);
			
			// update lastchange
			$config_sitemap[0]->lastchanged = time();
			$config_sitemap[0]->updateData();
			
			$timer->stop();
			echo 'time : ' . $timer->get_exec_time() . '<br />';
			echo 'So record thuc thi la : ' . $counter . '<br />';
			echo "Done! Click <a href=". $this->registry->conf['root_url'] ."/sitemap/sitemap-tintuc.xml alt=\"Site-Map-news\" title=\"Site Map news\">Sitemap tin tuc</a><br /><br />";
		}
	}

	/**
	 * Grenrator sitemap for Images
	 * @return XML Sitemap
	 */
	public function sitemapimagesAction()
	{
		set_time_limit(0);
		$timer = new Timer();
		$counter = 0;

		$timer->start();
		
		//Get setting sitemap
		$config_sitemap = Core_Backend_Sitemap::getSitemaps(array('fname' => 'sitemap-images'), '', '', 1);
		if(!empty($config_sitemap)){
			$changefreq = $config_sitemap[0]->getChangefregName();
			$priority = $config_sitemap[0]->priority;
			$lastchanged = $config_sitemap[0]->lastchanged;
		}else{
			$changefreq = 'hourly';
			$priority = '0.9';
		}
		
		if($this->gettimeexecute($config_sitemap[0]->changefreq, $lastchanged)){

			if(!is_dir($this->dir))
			mkdir($this->dir);
			$fp = fopen($this->dir . '/sitemap-images.xml', 'w+');
			// Infomation xml
			$header_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			fwrite($fp, $header_xml);
			//Get all images in product media avalible
			$arrConditionImages = array();
			$arrConditionImages['fstatus'] = Core_ProductMedia::STATUS_ENABLE;
	
			$arrayConditionProduct = array();
			$arrayConditionProduct['fisonsitestatus'] = 1;
			$arrayConditionProduct['fstatus'] = Core_Product::STATUS_ENABLE;
			$arrayConditionProduct['fpricethan0'] = 1;
			$arrayConditionProduct['fcustomizetype'] = Core_Product::CUSTOMIZETYPE_MAIN;
	
			$totalRecord = Core_Product::getProducts($arrayConditionProduct, '', '','',true);
	
			$recordperpage = 500;
			$totalPage = ceil($totalRecord / $recordperpage);
			$totalaffected = 0;
			for ($i = 0; $i < $totalPage; $i++) {
				$offset = $i * $recordperpage;
				$listProduct = Core_Product::getProducts($arrayConditionProduct, 'id', 'DESC', $offset . ',' . $recordperpage);
				foreach ($listProduct as $product) {
					if($product->slug != ''){
						$urlproduct = $product->getProductPath();
						$arrConditionImages['fpid'] = $product->id;
						$listImages = Core_ProductMedia::getProductMedias($arrConditionImages, 'id', 'DESC');
						if(!empty($listImages)){
							fwrite($fp, "<url>\n<loc>" . $urlproduct . "</loc>\n");
							foreach ($listImages as $image) {
								$urlimage = $image->getImage();
								$xml_content = "<image:image>\n<image:loc>". $urlimage ."</image:loc>\n</image:image>\n";
								fwrite($fp, $xml_content);
							}
							fwrite($fp, "</url>\n");
							$counter++;
						}
					}
				}
			}
			$footer_xml = "</urlset>";
			fwrite($fp, $footer_xml);
			fclose($fp);
			
			// update lastchange
			$config_sitemap[0]->lastchanged = time();
			$config_sitemap[0]->updateData();
			
			$timer->stop();
			echo 'time : ' . $timer->get_exec_time() . '<br />';
			echo 'So record thuc thi la : ' . $counter . '<br />';
			echo "Done! Images<br /><br />";
		}
	}
	
	/**
	 * Get time execute for every action
	 * @param String $changefreq and $lastchange
	 */
	public function gettimeexecute($changefreq, $lastchanged){
		$flag = false;
		if($lastchanged > 0){	
			$time_elapsed = time() - $lastchanged;
			
			switch ($changefreq) {
				case Core_Backend_Sitemap::ALWAYS:
					$flag = true;
					break;
				case Core_Backend_Sitemap::HOURLY:
					$hours = floor($time_elapsed / 3600);
					if ($hours == 1)
						$flag = true;
					break;
				case Core_Backend_Sitemap::DAILY:
					$days = floor($time_elapsed / 86400);
					if($days == 1)
						$flag = true;
					break;
				case Core_Backend_Sitemap::WEEKLY:
					$weeks = floor($time_elapsed / 604800);
					if($weeks == 1)
						$flag = true;
					break;
				case Core_Backend_Sitemap::MONTHLY:
					$months = floor($time_elapsed / 2600640) ;
					if ($months == 1)
						$flag = true;
					break;
				case Core_Backend_Sitemap::NERVER:
					$years = floor($time_elapsed / 31207680);
					if ($years == 1)
						$flag = true;
					break;
				default:
					$flag = false;
			}
		}else{
			$flag = true;
		}
		return $flag;
	}
	
}