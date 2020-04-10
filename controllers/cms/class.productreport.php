<?php
Class Controller_Cms_Productreport extends Controller_Cms_Base
{
    public function indexAction()
    {
        $formData = array();
        $success = array();
        $error = array();
        $warning = array();

        $fieldlist = $this->getFieldList();

        if(isset($_POST['fsubmit']))
        {
            /** Include PHPExcel */
            require_once SITE_PATH . 'libs/phpexcel/PHPExcel.php';

            //create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('dienmay.com')
                                            ->setTitle('Thống kê sản phẩm web dienmay.com')
                                            ->setSubject('Thống kê sản phẩm web dienmay.com');

            $formData = array_merge($formData , $_POST);           

            if(count( $formData['fcheckedfield'] ) > 0)
            {
                $index = 1;
                foreach ($formData['fcheckedfield'] as $fielddata => $fielddataname) 
                {                    
                    $index++;
                }                    
            }
        }        
        $this->registry->smarty->assign(array('fieldlistt' => $fieldlist,
													));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }


    public function getFieldList()
    {
        $fieldlistt = array();
        
        $fieldlist['uid'] = 'User';
        $fieldlist['vid'] = 'Nhà cung cấp';
        $fieldlist['vsubid'] = 'Nhà phân phối';
        $fieldlist['pcid'] = 'Danh mục';
        $fieldlist['rootpcid']= 'Ngành hàng';
        $fieldlist['id'] = 'ID';
        $fieldlist['image'] = 'Hình đại diện';
        $fieldlist['barcode'] = 'Barcode';
        $fieldlist['name'] = 'Tên sản phẩm';
        $fieldlist['slug'] = 'Slug';
        $fieldlist['content'] = 'Nội dung';
        $fieldlist['summary'] = 'Đặc điểm';
        $fieldlist['summarynew'] = 'Key selling point';
        $fieldlist['good'] = 'Ưu điểm';
        $fieldlist['bad'] = 'Nhược điểm';
        $fieldlist['dienmayreview'] = 'dienmay.com đánh giá';
        $fieldlist['seotitle'] = 'SEO title'; 
        $fieldlist['seokeyword'] = 'SEO keyword';
        $fieldlist['seodescription'] = 'SEO description';
        $fieldlist['canonical'] = 'Canonical';
        $fieldlist['topseokeyword'] = 'Top SEO keyword';
        $fieldlist['textfooter'] = 'Textfooter';
        $fieldlist['sellprice'] = 'Giá bán';
        $fieldlist['finalprice'] = 'Giá bán sau khuyến mãi';
        $fieldlist['onsitestatus'] = 'Onsitestatus';
        $fieldlist['bussinesstatus'] = 'ERP status';
        $fieldlist['width'] = 'Chiều rộng';
        $fieldlist['lenght'] = 'Chiều dài';
        $fieldlist['height'] = 'Chiều cao';
        $fieldlist['imagefullbox'] = 'Hình bộ bán hàng chuẩn';
        $fieldlist['fullboxshort']= 'Bộ bán hàng chuẩn (text)';
        $fieldlist['video'] = 'Video';
        $fieldlist['gallery'] = 'Gallery';
        $fieldlist['image360'] = 'Hình 360';
        $fieldlist['accessories'] = 'Phụ kiện bán kèm';
        $fieldlist['sameproduct'] = 'Sản phẩm liên quan';
        $fieldlist['datecreated'] = 'Ngày tạo';
        $fieldlist['dateupdated'] = 'Ngày cập nhật';
        $fieldlist['instock'] = 'Tồn kho';
        

        return $fieldlist;
    }

}
