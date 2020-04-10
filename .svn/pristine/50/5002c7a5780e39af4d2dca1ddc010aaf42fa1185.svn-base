<?php
class Controller_Site_GiareReview Extends Controller_Site_Base
{
    public $recordPerPage = 20;
	public function indexAction()
	{

	}

	function indexajaxAction()
	{
        $admindienmayarr = array(43 , 41 , 48);
        //get productid
        $fpid = (int)$_POST['id'];
        $order = strtolower(trim((string)$_POST['order']));
        $sortby = '';
        $page           = $curPage = (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

        switch($order)
        {
            case 'lasted' : $sortby = 'datecreated';
            break;

            case 'like' : $sortby = 'countthumbup';
            break;
        }

		//get product's comment
        $giarereviewList = array();

        $totalreview =  $productreviewroots = Core_GiareReview::getGiareReviews(array('fobjectid' => $fpid,
                                                                                'fstatus' => Core_ProductReview::STATUS_ENABLE) , 'id' , 'ASC' ,'',true);

        $giarereviewroots = Core_GiareReview::getGiareReviews(array('fobjectid' => $fpid ,
                                                                                'fparent' => true,
                                                                                'fstatus' => Core_ProductReview::STATUS_ENABLE) , $sortby , 'DESC' , '0 , ' . ($page*$this->recordPerPage)); //get root comment

        if(count($giarereviewroots) > 0)
        {
            foreach ($giarereviewroots as $rootreview)
            {
                $review = Core_GiareReview::getFullReview($rootreview);
                $giarereviewList[] = $review;
            }
        }

        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/indexajax/';


		///////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////

		$this->registry->smarty->assign(array('giarereviewList'		=> $giarereviewList,
												'fpid' => $fpid,
                                                'total' => $totalreview,
                                                'totalPage' => $totalPage,
                                                'order' => $order,
                                                'dienmayadmin' => $admindienmayarr,
                                                'paginateurl'   => $paginateUrl,
                                                'page' => $page+1));

		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');

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

        //kiem tra xem user da dang nhap hay chua ?
        if($this->registry->me->id > 0)
        {
            $name = $this->registry->me->fullname;
            $email = $this->registry->me->email;
        }

        //kiem tra email , name , content,id
        //if($objectid ==0)
//        {
//            echo '5'; // khong co productid
//            exit();
//        }

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

        if($content != '')
        {
            //kiem tra noi dung trong session
            if($_SESSION['contentreview'] != $content && strlen($content) >50)
            {
                //them mot review moi cho san pham
                $myGiareReview = new Core_GiareReview();

                $myGiareReview->uid = $this->registry->me->id;
                $myGiareReview->objectid = $objectid;
                $myGiareReview->fullname = $name;
                $myGiareReview->email = $email;
                $myGiareReview->text = Helper::plaintext($content);
                $myGiareReview->ipaddress = Helper::getIpAddress(true);
                $myGiareReview->status = Core_GiareReview::STATUS_PENDING;
                $myGiareReview->parentid = $parentid;

                if($parentid > 0)
                {
                    $giareviewparent = new Core_GiareReview($parentid);
                    $giareviewparent->countreply++;
                    $giareviewparent->updateData();
                }

                if($myGiareReview->addData() > 0)
                {
                    $_SESSION['contentreview'] = $content;
                    echo '6'; //them review thanh cong
                }
                else
                {
                    echo '7'; //them review khong thanh cong
                }
            }
            else
            {
                 echo '6'; //them review thanh cong
            }
        }
    }

    public function addinfoAction()
    {
        $objectid = (int)$this->registry->router->getArg('pid');
        $parentid = (int)$this->registry->router->getArg('parentid');
        $content =  (string)$this->registry->router->getArg('content');

        $this->registry->smarty->assign(array( 'fpid' => $objectid,
                                                'fparentid' => $parentid,
                                                'content' => $content,
                                            ));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'info.tpl');

        $this->registry->smarty->assign(array(  'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
                                                        'contents'  => $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
    }
}