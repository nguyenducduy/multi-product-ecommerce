<?php
Class Controller_Site_News Extends Controller_Site_Base
{
	public $recordPerPage = 20;
	public $videoID = Core_News::CATEGORY_VIDEO;
	public $khuyenmaiID = Core_News::CATEGORY_KM;
	public $allkmid = Core_News::CATEGORY_ALL_KM;

	public function indexAction()
	{
		global $protocol;
		$success = array();
		$error = array();
		$warning = array();
		$formData = array();
		$parentCatArr = array();

		$ncid = (int)(isset($_GET['ncid'])?$_GET['ncid']:0);
        $subdomain = '';
        if(SUBDOMAIN == 'm'){
            $subdomain = SUBDOMAIN;
        }
        $cachefile = $protocol.$subdomain.'sitehtml_news';
        if ($ncid > 0) {
            $cachefile .= 'category'.'_'.$ncid;
        }
        else
            $cachefile .= 'home';

        $myCache = new Cacher($cachefile);

        if(isset($_GET['live'])) {
            $myCache->clear();
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();

        if(!$pageHtml )
        {
            $parentCat = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'displayorder', 'ASC', '');

            foreach($parentCat as $parent)
            {
                $parentCatArr[] = $parent->id;
            }

            if($ncid > 0)
            {
                if(in_array($ncid, $parentCatArr))
                {
                    $pageHtml = $this->listParent();
                }
                else
                {
                    $pageHtml = $this->listChild();
                }

            }
            else
            {
                foreach($parentCat as $pcat)
                {
                    $pcat->subCat = Core_Newscategory::getNewscategorys(array('fparentid' => $pcat->id), 'displayorder', 'ASC');

                    foreach($pcat->subCat as $sub)
                    {
                    	$sub->news = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $sub->id), 'datecreated', 'DESC', '0, 5');
                    }
                }
                //echodebug($parentCat);
                $myNews = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE), 'datecreated', 'DESC', '0, 9');

                $myPromotion = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $this->allkmid), 'datecreated', 'DESC', '0, 4');

                $viewtopNews = Core_News::getNewss(array('fstatus' => Core_Stuff::STATUS_ENABLE), 'countview', 'DESC', '0, 4');

                $video = Core_News::getNewss(array('fncid' => Core_News::CATEGORY_VIDEO, 'fstatus' => Core_News::STATUS_ENABLE), 'datecreated', 'DESC', '0, 1');

                $faq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), '', '', '0, 5');
                $totalfaq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), 'id', 'DESC', '0, 5', true);

                $this->registry->smarty->assign(array(    'error'        => $error,
                                                        'success'    => $success,
                                                        'warning'    => $warning,
                                                        'formData'    => $formData,
                                                        'myNews'        => $myNews,
                                                        'parentCat'    => $parentCat,
                                                        'viewtopNews'    => $viewtopNews,
                                                        'faq'        => $faq,
                                                        'video'        => $video,
                                                    	'myPromotion'	=> $myPromotion,
                                                        'videoID'    => $this->videoID,
                                                        'khuyenmaiID'    => $this->khuyenmaiID,
                                                        'totalfaq'  > $totalfaq
                                                        ));

                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

                $this->registry->smarty->assign(array(
                                                    'contents' => $contents,
                                                    'pageTitle'                 => 'Tin tức',
                                                    'pageKeyword'               => 'Tin tức, tin khuyến mãi, dienmay.com',
                                                    'pageDescription'           => 'Trang tổng hợp tin tức, tin khuyến mãi của điện máy tại dienmay.com',
                                                    'pageMetarobots'           => 'index, follow',
                                                    'pageCanonical'           => $this->registry->conf['rooturl'].'tin-tuc',));
                if(SUBDOMAIN == 'm')
                    $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                        'index.tpl');
                else
                    $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                        'indexnews.tpl');
            }

            $myCache->set($pageHtml);
        }
        echo $pageHtml;
	}

	private function listParent()
	{
		$formData = array();
		$id = $_GET['ncid'];

		$myCategory = new Core_Newscategory($id);

		$parentCat = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'displayorder', 'ASC', '');

		foreach($parentCat as $pcat)
        {
            $pcat->subCat = Core_Newscategory::getNewscategorys(array('fparentid' => $pcat->id), 'displayorder', 'ASC');
        }

        $category = Core_Newscategory::getNewscategorys(array('fparentid' => $id), 'displayorder', 'ASC');
        foreach($category as $sub)
        {
        	$sub->news = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $sub->id), 'datecreated', 'DESC', '0, 5');
        }
        //echodebug($category);
        $myPromotion = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $this->allkmid), 'datecreated', 'DESC', '0, 4');

        $viewtopNews = Core_News::getNewss(array('fstatus' => Core_Stuff::STATUS_ENABLE), 'countview', 'DESC', '0, 4');

        $video = Core_News::getNewss(array('fncid' => Core_News::CATEGORY_VIDEO, 'fstatus' => Core_News::STATUS_ENABLE), 'datecreated', 'DESC', '0, 1');

        $faq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), '', '', '0, 5');
        $totalfaq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), 'id', 'DESC', '0, 5', true);

		$this->registry->smarty->assign(array(	'myNews'        => $myNews,
                                                'parentCat'    => $parentCat,
                                                'viewtopNews'    => $viewtopNews,
                                                'faq'        => $faq,
                                                'video'        => $video,
                                            	'myPromotion'	=> $myPromotion,
                                            	'myCategory'	=> $myCategory,
                                            	'category'	=> $category,
                                                'totalfaq'  => $totalfaq,
                                                'internaltopbar_editurl'	=> $this->registry->conf['rooturl'].'cms/newscategory/edit/id/'.$id.'/',
							                    'internaltopbar_objectid'	=> $id,
							                    'internaltopbar_reporttype'	=> 'newscategory',
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'listparent.tpl');

		$this->registry->smarty->assign(array(
												'contents' => $contents,
                                                'pageTitle'                 => (!empty($myCategory->seotitle)?$myCategory->seotitle:$myCategory->name),
                                                'pageKeyword'               => $myCategory->seokeyword,
                                                'pageDescription'           => $myCategory->seodescription,
                                                'pageMetarobots'           => (!empty($myCategory->metarobot)?$myCategory->metarobot:'index, follow'),
                                                'pageCanonical'           => $myCategory->getNewscategoryPath()));

		if(SUBDOMAIN == 'm')
            $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                'index.tpl');
        else
            $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                'indexnews.tpl');

		//for View Tracking
		$_GET['trackingid'] = $_GET['ncid'];
	}

	private function listChild()
	{
		$id = (int)$_GET['ncid'];
		$page 			= (int)($_GET['page'])>0?(int)($_GET['page']):1;

		$myCategory = new Core_Newscategory($id);

		$parentCat = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'displayorder', 'ASC', '');

		foreach($parentCat as $pcat)
        {
            $pcat->subCat = Core_Newscategory::getNewscategorys(array('fparentid' => $pcat->id), 'displayorder', 'ASC');
        }

		$myPromotion = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $this->allkmid), 'datecreated', 'DESC', '0, 4');

        $viewtopNews = Core_News::getNewss(array('fstatus' => Core_Stuff::STATUS_ENABLE), 'countview', 'DESC', '0, 4');

        $video = Core_News::getNewss(array('fncid' => Core_News::CATEGORY_VIDEO, 'fstatus' => Core_News::STATUS_ENABLE), 'datecreated', 'DESC', '0, 1');

        $faq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), '', '', '0, 5');
        $totalfaq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), 'id', 'DESC', '0, 5', true);

		$paginateUrl = $myCategory->getNewscategoryPath() . '&';

		//tim tong so
		$total = Core_News::getNewss(array('fncid'	=> $id, 'fstatus' => Core_News::STATUS_ENABLE), '', '', 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;

		$myNews = Core_News::getNewss(array('fncid'	=> $id, 'fstatus' => Core_News::STATUS_ENABLE), 'datecreated', 'DESC', (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		//echodebug($myNews);
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page=' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);

		$this->registry->smarty->assign(array(	'formData'	=> $formData,
												'myNews'	=> $myNews,
												'myCategory'	=> $myCategory,
												'total'		=> $total,
												'totalPage'	=> $totalPage,
												'curPage'	=> $curPage,
												'paginateurl'	=> $paginateUrl,
                                                'redirectUrl'    => $redirectUrl,
                                                'myPromotion'	=> $myPromotion,
                                                'viewtopNews'	=> $viewtopNews,
                                                'video'		=> $video,
                                                'faq'		=> $faq,
                                                'parentCat'	=> $parentCat,
                                                'totalfaq'  => $totalfaq,
                                                'internaltopbar_editurl'	=> $this->registry->conf['rooturl'].'cms/newscategory/edit/id/'.$id.'/',
							                    'internaltopbar_objectid'	=> $id,
							                    'internaltopbar_reporttype'	=> 'newscategory',
                                                ));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'listchild.tpl');

		$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
												'contents' => $contents,
                                                'pageTitle'                 => (!empty($myCategory->seotitle)?$myCategory->seotitle:$myCategory->name),
                                                'pageKeyword'               => $myCategory->seokeyword,
                                                'pageDescription'           => $myCategory->seodescription,
                                                'pageMetarobots'           => (!empty($myCategory->metarobot)?$myCategory->metarobot:'index, follow'),
                                                'pageCanonical'           => $myCategory->getNewscategoryPath(),));

		if(SUBDOMAIN == 'm')
            $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                'index.tpl');
        else
            $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                'indexnews.tpl');

		//for View Tracking
		$_GET['trackingid'] = $_GET['ncid'];
	}

	public function detailAction()
	{
		global $protocol;
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
        $subdomain = '';
        if(SUBDOMAIN == 'm'){
            $subdomain = SUBDOMAIN;
        }
        $cachefile = $protocol.$subdomain.'sitehtml_newsdetail'.'_'.$id;

        $myCache = new Cacher($cachefile);

        if(isset($_GET['live'])) {
            $myCache->clear();
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();

        if( !$pageHtml )
        {
		    $myNews = new Core_News($id);

		    $myCategory = new Core_Newscategory($myNews->ncid);

            $parentCat = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'displayorder', 'ASC', '');

            foreach($parentCat as $pcat)
            {
                $pcat->subCat = Core_Newscategory::getNewscategorys(array('fparentid' => $pcat->id), 'displayorder', 'ASC');
            }

            $myPromotion = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $this->allkmid), 'datecreated', 'DESC', '0, 4');

            $viewtopNews = Core_News::getNewss(array('fstatus' => Core_Stuff::STATUS_ENABLE), 'countview', 'DESC', '0, 4');

            $video = Core_News::getNewss(array('fncid' => Core_News::CATEGORY_VIDEO, 'fstatus' => Core_News::STATUS_ENABLE), 'datecreated', 'DESC', '0, 1');

            $faq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), '', '', '0, 5');
            $totalfaq = Core_Faq::getFaqs(array('fstatus' => Core_Faq::STATUS_ENABLE), 'id', 'DESC', '0, 5', true);

            //seo internal link
            $myNews->content = Core_Internallink::seointernallink( $myNews->slug,$myNews->content, 'fisarticle');

		    if($myNews->id > 0)
		    {
			    //get keyword list
			    $keywordList = array();

			    $myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $myNews->id, 'ftype' => Core_RelItemKeyword::TYPE_NEWS), '', '', '');

			    foreach($myKeyword as $keyword)
			    {
				    $prebuild = new Core_Keyword($keyword->kid);

				    $keywordList[] = $prebuild;
			    }

                $samenews = Core_News::getNewss(array('fstatus' => Core_News::STATUS_ENABLE, 'fncid' => $myNews->ncid), 'datecreated', 'DESC', '0, 5');

			    $this->registry->smarty->assign(array(	'myNews'		=>	$myNews,
													    'myCategory'	=> $myCategory,
													    'viewtopNews'	=> $viewtopNews,
													    'myPromotion'	=> $myPromotion,
													    'faq'			=> $faq,
													    'video'			=> $video,
													    'keywordList'	=> $keywordList,
                                                        'parentCat'     => $parentCat,
                                                        'samenews'      => $samenews,
                                                        'totalfaq'      => $totalfaq,
		                                                'internaltopbar_editurl'	=> $this->registry->conf['rooturl'].'cms/news/edit/id/'.$id.'/',
									                    'internaltopbar_objectid'	=> $id,
									                    'internaltopbar_reporttype'	=> 'news',
                                                        ));

			    $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl');

			    $this->registry->smarty->assign(array(	'pageTitle'	=>	$this->registry->lang['controller']['pageTitle_list'],
													    'contents'	=>	$contents,
                                                        'pageTitle'                 => (!empty($myNews->seotitle)?$myNews->seotitle:$myNews->title),
                                                        'pageKeyword'               => $myNews->seokeyword,
                                                        'pageDescription'           => $myNews->seodescription,
                                                        'pageMetarobots'           => (!empty($myNews->metarobot)?$myNews->metarobot:'index, follow'),
                                                        'pageCanonical'           => $myNews->getNewsPath(),));

			    if(SUBDOMAIN == 'm')
                    $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                        'index.tpl');
                else
                    $pageHtml = $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.
                        'indexnews.tpl');

			    //for View Tracking
			    $_GET['trackingid'] = $_GET['id'];

		    }
		    else
		    {
			    $redirectMsg = $this->registry->lang['controller']['errNotFound'];
			    $this->registry->smarty->assign(array('redirect' => $redirectUrl,
													    'redirectMsg' => $redirectMsg
													    ));
			    $pageHtml = $this->registry->smarty->fetch('redirect.tpl');
		    }

            $myCache->set( $pageHtml );
        }

        echo $pageHtml;
	}


}

