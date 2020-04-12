<?php

Class Controller_Cms_News Extends Controller_Cms_Base
{
    private $recordPerPage = 20;

    public function indexAction()
    {

        $error 			= array();
        $success 		= array();
        $warning 		= array();
        $formData 		= array('fbulkid' => array());
        $_SESSION['securityToken']=Helper::getSecurityToken();//Token
        $page 			= (int) ($this->registry->router->getArg('page'))>0?(int) ($this->registry->router->getArg('page')):1;
        $permission = $this->registry->router->getArg('permission');

        //display error permission
        switch ($permission) {
            case 'add' : $error[] = $this->registry->lang['controller']['errorAddPermission'];
                break;
            case 'edit' : $error[] = $this->registry->lang['controller']['errorEditPermission'];
                break;
            case 'delete' : $error[] = $this->registry->lang['controller']['errorDeletePermission'];
                break;
        }

        $uidFilter = (int) ($this->registry->router->getArg('uid'));
        $ncidFilter = (int) ($this->registry->router->getArg('ncid'));
        $titleFilter = (string) ($this->registry->router->getArg('title'));
        $countviewFilter = (int) ($this->registry->router->getArg('countview'));
        $countreviewFilter = (int) ($this->registry->router->getArg('countreview'));
        $statusFilter = (int) ($this->registry->router->getArg('status'));
        $idFilter = (int) ($this->registry->router->getArg('id'));

        $keywordFilter = (string) $this->registry->router->getArg('keyword');
        $searchKeywordIn= (string) $this->registry->router->getArg('searchin');

        //check sort column condition
        $sortby 	= $this->registry->router->getArg('sortby');
        if($sortby == '') $sortby = 'datecreated';
        $formData['sortby'] = $sortby;
        $sorttype 	= $this->registry->router->getArg('sorttype');
        if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
        $formData['sorttype'] = $sorttype;

        if (!empty($_POST['fsubmitbulk'])) {
            if ($_SESSION['newsBulkToken']==$_POST['ftoken']) {
                 if (!isset($_POST['fbulkid'])) {
                    $warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
                } else {
                    $formData['fbulkid'] = $_POST['fbulkid'];

                    //check for delete
                    if ($_POST['fbulkaction'] == 'delete') {
                        $delArr = $_POST['fbulkid'];
                        $deletedItems = array();
                        $cannotDeletedItems = array();
                        foreach ($delArr as $id) {
                            //check valid user and not admin user
                            $myNews = new Core_News($id);

                            if ($myNews->id > 0) {
                                //tien hanh xoa
                                if ($myNews->delete()) {
                                    $deletedItems[] = $myNews->id;
                                    $this->registry->me->writelog('news_delete', $myNews->id, array());

                                    //xoa slug lien quan den item nay
                                    Core_Slug::deleteSlug($myNews->slug, 'site', 'news', 'detail', $myNews->id);
                                } else
                                    $cannotDeletedItems[] = $myNews->id;

                            } else
                                $cannotDeletedItems[] = $myNews->id;
                        }

                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    } else {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }

        }

        //change order of item
        if (!empty($_POST['fsubmitchangeorder'])) {
            $displayorderList = $_POST['fdisplayorder'];
            foreach ($displayorderList as $id => $neworder) {
                $myItem = new Core_News($id);
                if ($myItem->id > 0 && $myItem->displayorder != $neworder) {
                    $myItem->displayorder = $neworder;
                    $myItem->updateData();
                }
            }

            $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
        }

        $_SESSION['newsBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';

        if ($uidFilter > 0) {
            $paginateUrl .= 'uid/'.$uidFilter . '/';
            $formData['fuid'] = $uidFilter;
            $formData['search'] = 'uid';
        }

        if ($ncidFilter > 0) {
            $paginateUrl .= 'ncid/'.$ncidFilter . '/';
            $formData['fncid'] = $ncidFilter;
            $formData['search'] = 'ncid';
        }

        if ($titleFilter != "") {
            $paginateUrl .= 'title/'.$titleFilter . '/';
            $formData['ftitle'] = $titleFilter;
            $formData['search'] = 'title';
        }

        if ($countviewFilter > 0) {
            $paginateUrl .= 'countview/'.$countviewFilter . '/';
            $formData['fcountview'] = $countviewFilter;
            $formData['search'] = 'countview';
        }

        if ($countreviewFilter > 0) {
            $paginateUrl .= 'countreview/'.$countreviewFilter . '/';
            $formData['fcountreview'] = $countreviewFilter;
            $formData['search'] = 'countreview';
        }

        if ($statusFilter > 0) {
            $paginateUrl .= 'status/'.$statusFilter . '/';
            $formData['fstatus'] = $statusFilter;
            $formData['search'] = 'status';
        }

        if ($idFilter > 0) {
            $paginateUrl .= 'id/'.$idFilter . '/';
            $formData['fid'] = $idFilter;
            $formData['search'] = 'id';
        }

        if (strlen($keywordFilter) > 0) {
            $paginateUrl .= 'keyword/' . $keywordFilter . '/';

            if ($searchKeywordIn == 'title') {
                $paginateUrl .= 'searchin/title/';
            } elseif ($searchKeywordIn == 'content') {
                $paginateUrl .= 'searchin/content/';
            } elseif ($searchKeywordIn == 'source') {
                $paginateUrl .= 'searchin/source/';
            }
            $formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
            $formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
            $formData['search'] = 'keyword';
        }

        if (!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) {
            $formData['fncidarr'] = array();
            $accessTicketSuffixWithoutId = $this->getAccessTicket('nview_');
            $accessTicketSuffixObjectIdList = $this->registry->me->getAccessTicketSuffixId($accessTicketSuffixWithoutId);

            if ( count($accessTicketSuffixObjectIdList) > 0 ) {
                foreach ($accessTicketSuffixObjectIdList as $newscategoryid) {
                    $fullsubcategorylist = Core_Newscategory::getFullSubCategory( $newscategoryid );
                    $formData['fncidarr'] = array_merge($formData['fncidarr'] , $fullsubcategorylist);
                }
            }

        }

        if (count($formData['fncidarr']) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer')) {
            //tim tong so
            $total = Core_News::getNewss($formData, $sortby, $sorttype, 0, true);
            $totalPage = ceil($total/$this->recordPerPage);
            $curPage = $page;

            //get latest account
            $newss = Core_News::getNewss($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
        }

        $newscategoryList = array();
        $parentCategory1 = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'parentid', 'ASC');
        for ($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++) {
            if ($parentCategory1[$i]->parentid == 0) {
                $newscategoryList[] = $parentCategory1[$i];
                $parentCategory2 = Core_Newscategory::getNewscategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                for ($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++) {
                    $parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                    $newscategoryList[] = $parentCategory2[$j];

                    $subCategory = Core_Newscategory::getNewscategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                    foreach ($subCategory as $sub) {
                        $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                        $newscategoryList[] = $sub;
                    }
                }
            }
        }

        //filter for sortby & sorttype
        $filterUrl = $paginateUrl;

        //append sort to paginate url
        $paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

        //build redirect string
        $redirectUrl = $paginateUrl;
        if($curPage > 1)
            $redirectUrl .= 'page/' . $curPage;

        $redirectUrl = base64_encode($redirectUrl);

        $this->registry->smarty->assign(array(	'newss' 	=> $newss,
                                                'formData'		=> $formData,
                                                'success'		=> $success,
                                                'error'			=> $error,
                                                'warning'		=> $warning,
                                                'filterUrl'		=> $filterUrl,
                                                'paginateurl' 	=> $paginateUrl,
                                                'redirectUrl'	=> $redirectUrl,
                                                'total'			=> $total,
                                                'totalPage' 	=> $totalPage,
                                                'curPage'		=> $curPage,
                                                'statusList'    => Core_News::getStatusList(),
                                                'newscategoryList'	=> $newscategoryList
                                                ));

        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

        //testing using externalresourcedownload
        /*
        $myNews = new Core_News(23);
        $myExternalResourceDownload = new ExternalResourceDownload($myNews->content);
        $contents = $myExternalResourceDownload->run('http://dienmay.com/', 'uploads/pimages/ex/');
        */
        //end testing using externalresourcedownload;
        $myFaq = new Core_Faq(1, true);
        //Core_Faq::cacheClear(1);

        $this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
                                                'contents' 	=> $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

    }

    public function addAction()
    {
        $error 	= array();
        $success 	= array();
        $contents 	= '';
        $formData 	= array();
        $slugList = array();

        if (!empty($_POST['fsubmit'])) {
            if ($_SESSION['newsAddToken'] == $_POST['ftoken']) {
                $formData = array_merge($formData, $_POST);

                // check permission of add news
                $checker = false;
                if (!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) {
                    $checker = false;
                    $parentinfocategorylist = Core_Newscategory::getFullParentNewsCategorysId($formData['fncid']);

                    //create suffix
                    $suffix = 'nadd_' . $parentinfocategorylist[0];
                    $checker = $this->checkAccessTicket($suffix);
                } else {
                    $checker = true;
                }

                if ($checker) {

                    //get all slug related to current slug
                    $formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
                    if($formData['fslug'] != '')
                        $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                    if ($this->addActionValidator($formData, $error)) {
                        $myNews = new Core_News();

                        $myNews->uid = $this->registry->me->id;
                        $myNews->ncid = $formData['fncid'];
                        $myNews->image = $formData['fimage'];
                        $myNews->title = Helper::plaintext($formData['ftitle']);
                        $myNews->slug = $formData['fslug'];
                        $myNews->content = Helper::xss_clean($formData['fcontent']);
                        //Relace image in content
                        $myNews->content = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myNews->content);
                        $myNews->source = $formData['fsource'];
                        $myNews->seotitle = $formData['fseotitle'];
                        $myNews->seokeyword = $formData['fseokeyword'];
                        $myNews->metarobot = $formData['fmetarobot'];
                        $myNews->seodescription = $formData['fseodescription'];
                        $myNews->status = $formData['fstatus'];

                        if ($myNews->addData()) {
                            //Insert keyword to keyword table
                            if ($formData['fkeyword'] != '') {
                                $keywordArr = explode(',', $formData['fkeyword']);

                                foreach ($keywordArr as $keyword) {
                                    $existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');

                                    if (empty($existKeyword)) {
                                        $myKeyword = new Core_Keyword();
                                        $myKeyword->text = trim($keyword);
                                        $myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
                                        $myKeyword->hash = MD5($keyword);
                                        $myKeyword->from = Core_Keyword::TYPE_NEWS;
                                        $myKeyword->status = Core_Keyword::STATUS_ENABLE;

                                        $myKeyword->id = $myKeyword->addData();

                                        $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myNews->id), '', '', '');

                                        if (empty($record)) {
                                            $myRelkeyword = new Core_RelItemKeyword();
                                            $myRelkeyword->kid = $myKeyword->id;
                                            $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                            $myRelkeyword->objectid = $myNews->id;

                                            $myRelkeyword->addData();
                                        }
                                    }

                                    foreach ($existKeyword as $existkey) {
                                        $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myNews->id), '', '', '');

                                        if (empty($record)) {
                                            $myRelkeyword = new Core_RelItemKeyword();
                                            $myRelkeyword->kid = $existkey->id;
                                            $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                            $myRelkeyword->objectid = $myNews->id;

                                            $myRelkeyword->addData();
                                        }
                                    }
                                }
                            }

                            $success[] = $this->registry->lang['controller']['succAdd'];
                            $this->registry->me->writelog('news_add', $myNews->id, array());

                            $urlcron = $this->registry->conf['rooturl']."task/externalimagedownload/imagenewsdownloadbyid?id=".$myNews->id;
                            //Run scon
                            Helper::backgroundHttpGet($urlcron);

                            $formData = array();

                            ///////////////////////////////////
                               //Add Slug base on slug of news
                            $mySlug = new Core_Slug();
                            $mySlug->uid = $this->registry->me->id;
                            $mySlug->slug = $myNews->slug;
                            $mySlug->controller = 'news';
                            $mySlug->objectid = $myNews->id;
                            if (!$mySlug->addData()) {
                                $error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

                                //reset slug of current item
                                $myNews->slug = '';
                                $myNews->updateData();
                            }
                            //end Slug process
                            ////////////////////////////////
                        } else {
                            $error[] = $this->registry->lang['controller']['errAdd'];
                        }

                    }
                } else {
                    header('location: ' . $this->registry['conf']['rooturl_cms'].'news/index/permission/add');
                    exit();
                }

            }

        }

        $newscategoryList = array();
        $parentCategory1 = Core_Newscategory::getNewscategorys(array('fparentid' => 0), 'parentid', 'ASC');
        for ($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++) {
            if ($parentCategory1[$i]->parentid == 0) {
                $newscategoryList[] = $parentCategory1[$i];
                $parentCategory2 = Core_Newscategory::getNewscategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                for ($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++) {
                    $parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                    $newscategoryList[] = $parentCategory2[$j];

                    $subCategory = Core_Newscategory::getNewscategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                    foreach ($subCategory as $sub) {
                        $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                        $newscategoryList[] = $sub;
                    }
                }
            }
        }

        $_SESSION['newsAddToken']=Helper::getSecurityToken();//Tao token moi

        $this->registry->smarty->assign(array(	'formData' 		=> $formData,
                                                'redirectUrl'	=> $this->getRedirectUrl(),
                                                'error'			=> $error,
                                                'success'		=> $success,
                                                'statusList'    => Core_News::getStatusList(),
                                                'slugList'		=> $slugList,
                                                'newscategory'	=> $newscategoryList
                                                ));
        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
        $this->registry->smarty->assign(array(
                                                'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
                                                'contents' 			=> $contents));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    public function editAction()
    {
        $id = (int) $this->registry->router->getArg('id');
        $myNews = new Core_News($id);

        $redirectUrl = $this->getRedirectUrl();
        if ($myNews->id > 0) {
            $error 		= array();
            $success 	= array();
            $contents 	= '';
            $formData 	= array();
            $slugList	= array();

            $formData['fbulkid'] = array();

            //select keyword
            $myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $myNews->id), 'ik_id', 'ASC', '');
            $selectKeywordArr = array();

            foreach ($myKeyword as $keyword) {
                $selectKeyword = new Core_Keyword($keyword->kid);

                $selectKeywordArr[] = $selectKeyword->text;
            }

            $formData['fkeyword'] = implode(',',$selectKeywordArr);

            $formData['fuid'] = $myNews->uid;
            $formData['fncid'] = $myNews->ncid;
            $formData['fid'] = $myNews->id;
            $formData['fimage'] = $myNews->image;
            $formData['ftitle'] = $myNews->title;
            $formData['fslug'] = $myNews->slug;
            $formData['fcontent'] = $myNews->content;
            $formData['fsource'] = $myNews->source;
            $formData['fseotitle'] = $myNews->seotitle;
            $formData['fseokeyword'] = $myNews->seokeyword;
            $formData['fseodescription'] = $myNews->seodescription;
            $formData['fmetarobot'] = $myNews->metarobot;
            $formData['fcountview'] = $myNews->countview;
            $formData['fcountreview'] = $myNews->countreview;
            $formData['fdisplayorder'] = $myNews->displayorder;
            $formData['fstatus'] = $myNews->status;
            $formData['fipaddress'] = $myNews->ipaddress;
            $formData['fdatecreated'] = $myNews->datecreated;
            $formData['fdatemodified'] = $myNews->datemodified;

            //Current Slug
            $formData['fslugcurrent'] = $myNews->slug;

            if (!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) { //khong phai la admin
                $checker = false;
                $parentinfocategorylist = Core_Newscategory::getFullParentNewsCategorysId($formData['fncid']);

                //create suffix
                $suffix = 'nedit_' . $parentinfocategorylist[0];
                $checker = $this->checkAccessTicket($suffix);

            }

            if (!empty($_POST['fsubmit'])) {
                if ($_SESSION['newsEditToken'] == $_POST['ftoken']) {

                    $formData = array_merge($formData, $_POST);

                    /////////////////////////
                    //get all slug related to current slug
                    $formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
                    if($formData['fslug'] != '')
                        $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

                    if ($this->editActionValidator($formData, $error)) {

                        $myNews->ncid = $formData['fncid'];
                        $myNews->image = $formData['fimage'];
                        $myNews->title = $formData['ftitle'];
                        $myNews->slug = $formData['fslug'];

                        $myNews->content = Helper::xss_clean($formData['fcontent']);
                        //Relace image in content
                        $myNews->content = ContentRelace::replaceHttpsImageContent($this->registry->conf['rooturl'].'geturlcontent',$myNews->content);

                        $myNews->source = $formData['fsource'];
                        $myNews->seotitle = $formData['fseotitle'];
                        $myNews->seokeyword = $formData['fseokeyword'];
                        $myNews->seodescription = $formData['fseodescription'];
                        $myNews->metarobot = $formData['fmetarobot'];
                        $myNews->status = $formData['fstatus'];

                        if ($myNews->updateData()) {
                            //update keyword to keyword table
                            if ($formData['fkeyword'] != '') {
                                $keywordArr = explode(',', $formData['fkeyword']);

                                //kiem tra array de xoa keyword
                                $checkKeyword = array_diff($selectKeywordArr, $keywordArr);

                                if (!empty($checkKeyword)) {
                                    foreach ($checkKeyword as $keyname) {
                                        $keyhash = MD5($keyname);

                                        $deleteList = Core_Keyword::getKeywords(array('fkeyword' => $keyhash), '', '', '');

                                        foreach ($deleteList as $delete) {
                                            $myDelete = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $delete->id), '', '', '');

                                            foreach ($myDelete as $deleted) {
                                                $deleted->delete();
                                            }
                                        }
                                    }
                                }

                                foreach ($keywordArr as $keyword) {
                                    $existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');

                                    if (empty($existKeyword)) {
                                        $myKeyword = new Core_Keyword();
                                        $myKeyword->text = trim($keyword);
                                        $myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
                                        $myKeyword->hash = MD5($keyword);
                                        $myKeyword->from = Core_Keyword::TYPE_NEWS;
                                        $myKeyword->status = Core_Keyword::STATUS_ENABLE;

                                        $myKeyword->id = $myKeyword->addData();

                                        $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myNews->id), '', '', '');

                                        if (empty($record)) {
                                            $myRelkeyword = new Core_RelItemKeyword();
                                            $myRelkeyword->kid = $myKeyword->id;
                                            $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                            $myRelkeyword->objectid = $myNews->id;

                                            $myRelkeyword->addData();
                                        }
                                    }

                                    foreach ($existKeyword as $existkey) {
                                        $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myNews->id), '', '', '');

                                        if (empty($record)) {
                                            $myRelkeyword = new Core_RelItemKeyword();
                                            $myRelkeyword->kid = $existkey->id;
                                            $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                            $myRelkeyword->objectid = $myNews->id;

                                            $myRelkeyword->addData();
                                        }
                                    }
                                }
                            }

                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('news_edit', $myNews->id, array());

                            $urlcron = $this->registry->conf['rooturl']."task/externalimagedownload/imagenewsdownloadbyid?id=".$myNews->id;
                            //Run scon
                            Helper::backgroundHttpGet($urlcron);
                            ///////////////////////////////////
                               //Add Slug base on slug of news
                            if ($formData['fslug'] != $formData['fslugcurrent']) {
                                $mySlug = new Core_Slug();
                                $mySlug->uid = $this->registry->me->id;
                                $mySlug->slug = $myNews->slug;
                                $mySlug->controller = 'news';
                                $mySlug->objectid = $myNews->id;
                                if (!$mySlug->addData()) {
                                    $error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

                                    //reset slug of current item
                                    $myNews->slug = $formData['fslugcurrent'];
                                    $myNews->updateData();
                                } else {
                                    //Add new slug ok, keep old slug but change the link to keep the reference to new ref
                                    Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'news', $myNews->id);
                                }
                            }

                            //end Slug process
                            ////////////////////////////////

                        } else {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }

            }

            $_SESSION['newsEditToken'] = Helper::getSecurityToken();//Tao token moi

            $this->registry->smarty->assign(array(	'formData' 	=> $formData,
                                                    'redirectUrl'=> $redirectUrl,
                                                    'error'		=> $error,
                                                    'success'	=> $success,
                                                    'slugList'	=> $slugList,
                                                    'newscategorys' => Core_Newscategory::getNewscategorys(array(), 'nc_id', 'ASC', ''),
                                                    'statusList'    => Core_News::getStatusList(),

                                                    ));
            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
            $this->registry->smarty->assign(array(
                                                    'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'].' &raquo; '.$myNews->title,
                                                    'contents' 			=> $contents));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
        } else {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                    'redirectMsg' => $redirectMsg,
                                                    ));
            $this->registry->smarty->display('redirect.tpl');
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->registry->router->getArg('id');
        $myNews = new Core_News($id);
        if ($myNews->id > 0) {
            if (!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) { // khong phai la admin
                $checker = false;

                $parentinfocategorylist = Core_Newscategory::getFullParentNewsCategorysId($myNews->ncid);

                //create suffix
                $suffix = 'ndelete_' . $parentinfocategorylist[0];
                $checker = $this->checkAccessTicket($suffix);

                if (!$checker) {
                    header('location: ' . $this->registry['conf']['rooturl_cms'].'news/index/permission/delete');
                    exit();
                } else {
                    //tien hanh xoa
                    if ($myNews->delete()) {
                        $redirectMsg = str_replace('###id###', $myNews->id, $this->registry->lang['controller']['succDelete']);

                        $this->registry->me->writelog('news_delete', $myNews->id, array());

                        ///////////////////////////
                        //xoa slug lien quan den item nay
                        Core_Slug::deleteSlug($myNews->slug, 'news', $myNews->id);
                    } else {
                        $redirectMsg = str_replace('###id###', $myNews->id, $this->registry->lang['controller']['errDelete']);
                    }
                }

            }

        } else {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
        }

        $this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
                                                'redirectMsg' => $redirectMsg,
                                                ));
        $this->registry->smarty->display('redirect.tpl');

    }

    ####################################################################################################
    ####################################################################################################
    ####################################################################################################

    //Kiem tra du lieu nhap trong form them moi
    private function addActionValidator($formData, &$error)
    {
        $pass = true;

        if ($formData['fncid'] == '') {
            $error[] = $this->registry->lang['controller']['errNcidRequired'];
            $pass = false;
        }

        if ($formData['ftitle'] == '') {
            $error[] = $this->registry->lang['controller']['errTitleRequired'];
            $pass = false;
        }

        /*if ($formData['fseodescription'] == '') {
            $error[] = $this->registry->lang['controller']['errMetaDescriptionRequired'];
            $pass = false;
        }*/

        if ($formData['fcontent'] == '') {
            $error[] = $this->registry->lang['controller']['errContentRequired'];
            $pass = false;
        }

        if ($formData['fstatus'] == '') {
            $error[] = $this->registry->lang['controller']['errStatusRequired'];
            $pass = false;
        }

        //CHECKING SLUG
        if (Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0) {
            $error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
            $pass = false;
        }

        return $pass;
    }
    //Kiem tra du lieu nhap trong form cap nhat
    private function editActionValidator($formData, &$error)
    {
        $pass = true;

        if ($formData['fncid'] == '') {
            $error[] = $this->registry->lang['controller']['errNcidRequired'];
            $pass = false;
        }

        if ($formData['ftitle'] == '') {
            $error[] = $this->registry->lang['controller']['errTitleRequired'];
            $pass = false;
        }

        /*if ($formData['fseodescription'] == '') {
            $error[] = $this->registry->lang['controller']['errMetaDescriptionRequired'];
            $pass = false;
        }*/

        if ($formData['fcontent'] == '') {
            $error[] = $this->registry->lang['controller']['errContentRequired'];
            $pass = false;
        }

        if ($formData['fstatus'] == '') {
            $error[] = $this->registry->lang['controller']['errStatusRequired'];
            $pass = false;
        }

        //CHECKING SLUG
        if ($formData['fslug'] != $formData['fslugcurrent'] && Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0) {
            $error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
            $pass = false;
        }

        return $pass;
    }

    //script test redis cache
    public function setAction()
    {
        $myRedis = new RedisCache();
        $a = $myRedis->set('product:id:2', json_encode(new Core_User(1)));

        if($a)
            echo 'cached ok';
        else
            echo 'cache already existed, get it';
    }

    public function getAction()
    {
        $myRedis = new RedisCache();
        $a =  $myRedis->get('product:id:2');
        $b = json_decode($a);
        var_dump($b);
    }

    public function checkAction()
    {
        $myRedis = new RedisCache();
        echo $myRedis->check('user:id:1');
    }

    public function testAction()
    {

        $myRedis = new RedisCache();

        $string = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        for ($i = 1; $i < 20000; $i++) {
            $value = $i.$string;
            $myRedis->set('test:id:' . $i .'', $value);
        }

    }

    public function clearAllCacheAction()
    {
        $myRedis = new RedisCache();
        $myRedis->redis->_instance('127.0.0.1:6379')->flushAll();
    }

    //Script import data tu oracle qua mysql
    public function importAction()
    {
        $oracle = new Oracle();

        //script test build duong dan image de download image ve.
        /*$sqlOra = 'SELECT NEWSID, CREATEDDATE, DETAILIMAGE FROM TGDD_NEWS.NEWS WHERE CATEGORYID=118';

        $result = $oracle->query($sqlOra);

        foreach ($result as $res) {
            $imagepath = 'https://ecommerce.kubil.app/Files/';

            $dateCreated = DateTime::createFromFormat('d-M-y', $res['CREATEDDATE']);

            $dateFormat =  $dateCreated->format('Y-m-d');
            $arrDate = explode('-', $dateFormat);
            $imagepath .= $arrDate[0] . '/' . $arrDate[1] . '/' . $arrDate[2] . '/' . $res['NEWSID'] . '/' . $res['DETAILIMAGE'] ;
            echo $imagepath ;
            unset($imagepath);
            echo '<hr />';
        }*/

        $sqlSelect = 'SELECT nc_id FROM ' . TABLE_PREFIX . 'newscategory WHERE nc_status = 1';

        $stmt = $this->registry->db->query($sqlSelect);

        while ($row = $stmt->fetch()) {
            set_time_limit(0);

            $sqlOra = 'SELECT * FROM TGDD_NEWS.NEWS WHERE CATEGORYID='.$row['nc_id'].'';

            $result = $oracle->query($sqlOra);

            foreach ($result as $res) {
                $imagepath = 'https://ecommerce.kubil.app/Files/';

                //chuyen doi time oracle thanh timestamp
                $dateCreated = DateTime::createFromFormat('d-M-y', $res['CREATEDDATE']);
                $dateFormat =  $dateCreated->format('Y-m-d');
                $arrDate = explode('-', $dateFormat);

                //duong dan hinh can lay ve
                $imagepath .= $arrDate[0] . '/' . $arrDate[1] . '/' . $arrDate[2] . '/' . $res['NEWSID'] . '/' . $res['THUMBNAILIMAGE'] ;

                //chuyen doi gia tri 0,1 thanh 2,1 cho status
                if($res['ISACTIVED'] == 0)
                    $status = 2;
                else
                    $status = $res['ISACTIVED'];

                if($res['URL'] == '')
                    $res['URL'] = Helper::codau2khongdau($res['TITLE'], true, true);

                $sqlImport = 'INSERT INTO ' . TABLE_PREFIX . 'news (
                                    nc_id,
                                    n_image,
                                    n_title,
                                    n_slug,
                                    n_content,
                                    n_source,
                                    n_seotitle,
                                    n_seokeyword,
                                    n_seodescription,
                                    n_countview,
                                    n_displayorder,
                                    n_status,
                                    n_datecreated)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

                $this->registry->db->query($sqlImport,array(
                                    (int) $res['CATEGORYID'],
                                    (string) $res['THUMBNAILIMAGE'],
                                    (string) $res['TITLE'],
                                    (string) $res['URL'],
                                    (string) $res['CONTENT']->load(),
                                    (string) $res['SOURCE'],
                                    (string) $res['METATITLE'],
                                    (string) $res['METAKEYWORD'],
                                    (string) $res['METADESCRIPTION'],
                                    (int) $res['VIEWCOUNTER'],
                                    (int) $res['DISPLAYORDER'],
                                    (int) $status,
                                    Helper::strtotimedmy($dateCreated->format('d/m/Y'))
                                    ));
                $id = $this->registry->db->lastInsertId();

                //Script download image tu server ve
                // vi do tin test cua ben tgdd khong dung dinh dang file type nen khj chay script nay tam thoi tat check request image type trong class imageresizer
                $myNews = new Core_News();
                $myNews->image = $imagepath;
                $myNews->name = $res['THUMBNAILIMAGE'];
                $myNews->id = $id;
                $myNews->slug = Helper::codau2khongdau($res['TITLE'], true, true);
                $myNews->importImage();

                //Insert keyword to keyword table
                if ($res['KEYWORD'] != '') {
                    $keywordArr = explode(',', $res['KEYWORD']);

                    foreach ($keywordArr as $keyword) {
                        $existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');

                        if (empty($existKeyword)) {
                            $myKeyword = new Core_Keyword();
                            $myKeyword->text = trim($keyword);
                            $myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
                            $myKeyword->hash = MD5($keyword);
                            $myKeyword->from = Core_Keyword::TYPE_NEWS;
                            $myKeyword->status = Core_Keyword::STATUS_ENABLE;

                            $myKeyword->id = $myKeyword->addData();

                            $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myNews->id), '', '', '');

                            if (empty($record)) {
                                $myRelkeyword = new Core_RelItemKeyword();
                                $myRelkeyword->kid = $myKeyword->id;
                                $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                $myRelkeyword->objectid = $myNews->id;

                                $myRelkeyword->addData();
                            }
                        }

                        foreach ($existKeyword as $existkey) {
                            $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myNews->id), '', '', '');

                            if (empty($record)) {
                                $myRelkeyword = new Core_RelItemKeyword();
                                $myRelkeyword->kid = $existkey->id;
                                $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                $myRelkeyword->objectid = $myNews->id;

                                $myRelkeyword->addData();
                            }
                        }
                    }
                }

                ///////////////////////////////////
                //Add Slug base on slug of news
                /*$mySlug = new Core_Slug();
                $mySlug->uid = $this->registry->me->id;
                $mySlug->slug = $myNews->slug;
                $mySlug->controller = 'news';
                $mySlug->objectid = $myNews->id;
                if (!$mySlug->addData()) {
                    $error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

                    //reset slug of current item
                    $myNews->slug = '';
                    $myNews->updateData();
                }*/
                //end Slug process
                ////////////////////////////////

                if($stmt)
                    echo $res['TITLE'] . ' <i>inserted</i> <br />';

                unset($imagepath);
            }

        }

    }

    public function importkeywordAction()
    {
        $oracle = new Oracle();

        $sqlSelect = 'SELECT nc_id FROM ' . TABLE_PREFIX . 'newscategory WHERE nc_status = 1';

        $stmt = $this->registry->db->query($sqlSelect);

        while ($row = $stmt->fetch()) {
            set_time_limit(0);

            $sqlOra = 'SELECT * FROM TGDD_NEWS.NEWS WHERE CATEGORYID='.$row['nc_id'].'';

            $result = $oracle->query($sqlOra);

            foreach ($result as $res) {
                //Insert keyword to keyword table
                if ($res['KEYWORD'] != '') {
                    $keywordArr = explode(',', $res['KEYWORD']);

                    foreach ($keywordArr as $keyword) {
                        $existKeyword = Core_Keyword::getKeywords(array('fkeyword' => MD5($keyword)), '', '', '');

                        if (empty($existKeyword)) {
                            $myKeyword = new Core_Keyword();
                            $myKeyword->text = trim($keyword);
                            $myKeyword->slug = Helper::codau2khongdau($keyword, true, true);
                            $myKeyword->hash = MD5($keyword);
                            $myKeyword->from = Core_Keyword::TYPE_NEWS;
                            $myKeyword->status = Core_Keyword::STATUS_ENABLE;

                            $myKeyword->id = $myKeyword->addData();

                            $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $myKeyword->id, 'fobjectid' => $myNews->id), '', '', '');

                            if (empty($record)) {
                                $myRelkeyword = new Core_RelItemKeyword();
                                $myRelkeyword->kid = $myKeyword->id;
                                $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                $myRelkeyword->objectid = $myNews->id;

                                $myRelkeyword->addData();
                            }
                        }

                        foreach ($existKeyword as $existkey) {
                            $record = Core_RelItemKeyword::getRelItemKeywords(array('fkid' => $existkey->id, 'fobjectid' => $myNews->id), '', '', '');

                            if (empty($record)) {
                                $myRelkeyword = new Core_RelItemKeyword();
                                $myRelkeyword->kid = $existkey->id;
                                $myRelkeyword->type = Core_RelItemKeyword::TYPE_NEWS;
                                $myRelkeyword->objectid = $myNews->id;

                                $myRelkeyword->addData();
                            }
                        }
                    }
                }
            }
        }
    }

}
