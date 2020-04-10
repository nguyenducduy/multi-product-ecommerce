<?php
    Class Controller_Cron_GetBrandCategory extends Controller_Cron_Base
    {
        public function indexAction()
        {

        }
      	public function getbrandcategoryAction()
        {
        	$timer = new Timer();
    	 	$timer->start(); // Bắt đầu đếm thời gian để cron
        	$insertcounter = 0;
            $formData['fvendorlist'] = 1;
            $category = Core_Productcategory::getProductcategorys($formData,'','DESC');
         	unset($formData['fvendorlist']);
            $vendorlist = array();
            $brandcategory = new Core_BrandCategory();
            foreach ($category as $key => $cate) {
                $vendorlist = $cate->vendorlist;
                $vendorlist = explode(",",$vendorlist);
                $formData['fidin'] = $vendorlist;
                $vendors = Core_Vendor::getVendors($formData,'','DESC');
                foreach ($vendors as $key => $vendor) {
                	$brandcategory->pcid = $cate->id;
                	$brandcategory->vid = $vendor->id;
                	$brandcategory->name = $cate->name."-".$vendor->name;
                	if($brandcategory->addData())
                	{
                		$insertcounter++;
                	}
                }
            }
            $timer->stop();
            echo "Timer: ".$timer->get_exec_time();
            echo "Recode insert: ".$insertcounter;

        }
    }
