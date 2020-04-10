<?php
class Controller_Site_ProductReview Extends Controller_Site_Base
{
    public $recordPerPage = 10;
	public function indexAction()
	{

	}

	function indexajaxAction()
	{        
        if(SUBDOMAIN == 'm')
        {
            $this->recordPerPage = 5;
        }
        //get productid
        $fpid = (int)$_POST['id'];
        if(isset($_POST['page']) && (int)$_POST['page'] > 0)
            $page = (int)$_POST['page'];
        else
            $page = 1;
        
        $order = strtolower(trim((string)$_POST['order']));
        $sortby = '';

        switch($order)
        {
            case 'lasted' : $sortby = 'datecreated';
            break;

            case 'like' : $sortby = 'countthumbup';
            break;
        }
        $admindienmayarr = array(43 , 41 , 48 , 10016 , 47 , 9417 , 10179 , 9759, 10180, 5024 , 5846, 10460, 14006, 18314);
		//get product's comment
        $productreviewList = array();

        $totalreview =  $productreviewroots = Core_ProductReview::getProductReviews(array('fobjectid' => $fpid,
                                                                                'fstatus' => Core_ProductReview::STATUS_ENABLE) , 'id'  , 'ASC' , '' ,true);
        $totalPage = ceil($totalreview/$this->recordPerPage);
        $curPage = $page;
        $productreviewroots = Core_ProductReview::getProductReviews(array('fobjectid' => $fpid ,
                                                                          'fparent' => true,
                                                                          'fstatus' => Core_ProductReview::STATUS_ENABLE
                                                                          ) , $sortby , 'DESC',
        (($page - 1)*$this->recordPerPage).','.$this->recordPerPage); //get root comment

        if(count($productreviewroots) > 0)
        {
            foreach ($productreviewroots as $rootreview)
            {
                $review = Core_ProductReview::getFullReview($rootreview);
                $productreviewList[] = $review;
            }
        }
        $product = new Core_Product($fpid);
		///////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////

		$this->registry->smarty->assign(array('productreviewList'		=> $productreviewList,
												'fpid' => $fpid,
                                                'total' => $totalreview,
                                                'product' => $product,
                                                'recordPerPage'=>$this->recordPerPage,
                                                'admindienmayarr' => $admindienmayarr,
                                                'order' => $order,));

		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');

	}
    function loadmoreAction()
    {        
        //get productid
        $fpid = (int)$_POST['id'];
        if(isset($_POST['page']) && (int)$_POST['page'] > 0)
            $page = (int)$_POST['page'];
        else
            $page = 1;
        $order = strtolower(trim((string)$_POST['order']));
        $sortby = '';

        switch($order)
        {
            case 'lasted' : $sortby = 'datecreated';
            break;

            case 'like' : $sortby = 'countthumbup';
            break;
        }
         $admindienmayarr = array(43 , 41 , 48 , 10016 , 47 , 9417 , 10179 , 9759, 10180, 5024 , 5846, 10460, 14006, 18314);
        //get product's comment
        $productreviewList = array();

        $totalreview =  $productreviewroots = Core_ProductReview::getProductReviews(array('fobjectid' => $fpid,
                                                                                'fstatus' => Core_ProductReview::STATUS_ENABLE) , 'id'  , 'ASC' , '' ,true);
        $totalPage = ceil($totalreview/$this->recordPerPage);
        $curPage = $page;
        $productreviewroots = Core_ProductReview::getProductReviews(array('fobjectid' => $fpid ,
                                                                          'fparent' => true,
                                                                           'recordPerPage'=>$this->recordPerPage,
                                                                          'fstatus' => Core_ProductReview::STATUS_ENABLE
                                                                          ) , $sortby , 'DESC',
        (($page - 1)*$this->recordPerPage).','.$this->recordPerPage); //get root comment
        

        if(count($productreviewroots) > 0)
        {
            foreach ($productreviewroots as $rootreview)
            {
                $review = Core_ProductReview::getFullReview($rootreview);
                $productreviewList[] = $review;
            }
        }
        $product = new Core_Product($fpid);
        ///////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////

        $this->registry->smarty->assign(array('productreviewList'       => $productreviewList,
                                                'fpid' => $fpid,
                                                'total' => $totalreview,
                                                'product' => $product,
                                                'admindienmayarr' => $admindienmayarr,
                                                'order' => $order,));
        if(count($productreviewList)>0)
            echo $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'loadmore.tpl');
        else
            echo "";

    }

    public function replyAction()
    {
        $objectid = (int)$this->registry->router->getArg('id');
        $parentreviewid = (int)$this->registry->router->getArg('parentid');

        if($objectid > 0 && $parentreviewid > 0)
        {
            $this->registry->smarty->assign(array( 'objectid' => $objectid,
                                                'parentreviewid' => $parentreviewid,
                                            ));

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reply.tpl');

            $this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
                                                        'contents'  => $contents));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
        }
    }

    public function successAction()
    {
        $success = array();

        $success[] = 'Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn';
        $this->registry->smarty->assign(array('success' => $success
                                            ));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'success.tpl');

        $this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
                                                        'contents'  => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
    }

    public function addajaxAction()
    {
        $name = (string)$_POST['name'];
        $email = (string)$_POST['email'];
        $content = (string)$_POST['content'];
        $objectid = (int)$_POST['id'];
        $parentid = (int)$_POST['parent'];
        $checksubcom = (int)$_POST['checksubcom'];
        //kiem tra xem user da dang nhap hay chua ?
        if($this->registry->me->id > 0)
        {
            $name = $this->registry->me->fullname;
            $email = $this->registry->me->email;
        }

        //kiem tra email , name , content,id
        if($objectid ==0)
        {
            echo '5'; // khong co productid
            exit();
        }

        if(strlen($name) == 0)
        {
            echo '1'; //khong co name
            exit();
        }

        if(strlen($email) == 0)
        {
            echo '2'; //khong co email
            exit();
        }
        else
        {
            if(!Helper::ValidatedEmail($email))
            {
                echo '3'; //email khong hop le
                exit();
            }
        }

        if(strlen($content) == 0)
        {
            echo '4'; // khong co content
            exit();
        }

        //them mot review moi cho san pham
        $myProductReview = new Core_ProductReview();

        $myProduct = new Core_Product($objectid , true);
        $myProductReview->uid = $this->registry->me->id;
        $myProductReview->objectid = $objectid;
        $myProductReview->subobjectid = $myProduct->pcid;
        $myProductReview->fullname = $name;
        $myProductReview->email = $email;
        if($this->registry->me->id > 0 || $checksubcom == 1)
        {
             $myProductReview->isfeedback = Core_ProductReview::EMAILFEEDBACK;
        }
        $myProductReview->text = Helper::plaintext($content);
        $myProductReview->ipaddress = Helper::getIpAddress(true);
        $myProductReview->status = Core_ProductReview::STATUS_ENABLE;
        $myProductReview->parentid = $parentid;


        if($parentid > 0)
        {
            $productreviewparent = new Core_ProductReview($parentid);
            $productreviewparent->countreply++;
            $productreviewparent->updateData();
        }

        if($myProductReview->addData() > 0)
        {
            echo '6'; //them review thanh cong
        }
        else
        {
            echo '7'; //them review khong thanh cong
        }
    }
    
    public function addinfoAction()
    {
        $objectid = (int)$this->registry->router->getArg('pid');
        $parentid = (int)$this->registry->router->getArg('parentid');
        $content =  (string)$this->registry->router->getArg('content');

        $this->registry->smarty->assign(array( 'fpid' => $objectid,
                                                'fparentid' => $parentid,                                                
                                            ));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'info.tpl');

        $this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
                                                        'contents'  => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
    }
}
