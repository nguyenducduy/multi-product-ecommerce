<?php

	Class Controller_Cms_LotteMember Extends Controller_Cms_Base
	{
		private $recordPerPage = 20;

		function indexAction()
                {       
                        $permission = false;
                        $user = new Core_User($this->registry->me->id);
                        if($user->groupid=='3' || $user->id=='1')
                        {
                            $permission = true;
                        }
			$error                     = array();
			$success                   = array();
			$warning                   = array();
			$formData                  = array('fbulkid' => array());
			$_SESSION['securityToken'] = Helper::getSecurityToken(); //Token
			$page                      = (int)($this->registry->router->getArg('page')) > 0 ? (int)($this->registry->router->getArg('page')) : 1;


			$leidFilter            = (int)($this->registry->router->getArg('leid'));
			$uidFilter             = (int)($this->registry->router->getArg('uid'));
			$urlcodeFilter         = (string)($this->registry->router->getArg('urlcode'));
			$fullnameFilter        = (string)($this->registry->router->getArg('fullname'));
			$emailFilter           = (string)($this->registry->router->getArg('email'));
			$genderFilter          = (int)($this->registry->router->getArg('gender'));
			$phoneFilter           = (string)($this->registry->router->getArg('phone'));
			$cmndFilter            = (string)($this->registry->router->getArg('cmnd'));
			$regionFilter          = (int)($this->registry->router->getArg('region'));
			$referermemberidFilter = (int)($this->registry->router->getArg('referermemberid'));
			$datecreatedFilter     = (int)($this->registry->router->getArg('datecreated'));
			$datemodifiedFilter    = (int)($this->registry->router->getArg('datemodified'));
			$idFilter              = (int)($this->registry->router->getArg('id'));

			$keywordFilter   = (string)$this->registry->router->getArg('keyword');
			$searchKeywordIn = (string)$this->registry->router->getArg('searchin');

			//check sort column condition
			$sortby = $this->registry->router->getArg('sortby');
			if ($sortby == '') {
				$sortby = 'id';
			}
			$formData['sortby'] = $sortby;
			$sorttype           = $this->registry->router->getArg('sorttype');
			if (strtoupper($sorttype) != 'ASC') {
				$sorttype = 'DESC';
			}
			$formData['sorttype'] = $sorttype;


			if (!empty($_POST['fsubmitbulk'])) {
				if ($_SESSION['lottememberBulkToken'] == $_POST['ftoken']) {
					if (!isset($_POST['fbulkid'])) {
						$warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
					}
					else {
						$formData['fbulkid'] = $_POST['fbulkid'];

						//check for delete
						if ($_POST['fbulkaction'] == 'delete') {
							$delArr             = $_POST['fbulkid'];
							$deletedItems       = array();
							$cannotDeletedItems = array();
							foreach ($delArr as $id) {
								//check valid user and not admin user
								$myLotteMember = new Core_LotteMember($id);

								if ($myLotteMember->id > 0) {
									//tien hanh xoa
									if ($myLotteMember->delete()) {
										$deletedItems[] = $myLotteMember->id;
										$this->registry->me->writelog('lottemember_delete', $myLotteMember->id, array());
									}
									else {
										$cannotDeletedItems[] = $myLotteMember->id;
									}
								}
								else {
									$cannotDeletedItems[] = $myLotteMember->id;
								}
							}

							if (count($deletedItems) > 0) {
								$success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);
							}

							if (count($cannotDeletedItems) > 0) {
								$error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
							}
						}
						else {
							//bulk action not select, show error
							$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
						}
					}
				}

			}

			$_SESSION['lottememberBulkToken'] = Helper::getSecurityToken(); //Gan token de kiem soat viec nhan nut submit form

			$paginateUrl = $this->registry->conf['rooturl'] . $this->registry->controllerGroup . '/' . $this->registry->controller . '/index/';


			if ($leidFilter > 0) {
				$paginateUrl .= 'leid/' . $leidFilter . '/';
				$formData['fleid']  = $leidFilter;
				$formData['search'] = 'leid';
			}

			if ($uidFilter > 0) {
				$paginateUrl .= 'uid/' . $uidFilter . '/';
				$formData['fuid']   = $uidFilter;
				$formData['search'] = 'uid';
			}

			if ($urlcodeFilter != "") {
				$paginateUrl .= 'urlcode/' . $urlcodeFilter . '/';
				$formData['furlcode'] = $urlcodeFilter;
				$formData['search']   = 'urlcode';
			}

			if ($fullnameFilter != "") {
				$paginateUrl .= 'fullname/' . $fullnameFilter . '/';
				$formData['ffullname'] = $fullnameFilter;
				$formData['search']    = 'fullname';
			}

			if ($emailFilter != "") {
				$paginateUrl .= 'email/' . $emailFilter . '/';
				$formData['femail'] = $emailFilter;
				$formData['search'] = 'email';
			}

			if ($genderFilter > 0) {
				$paginateUrl .= 'gender/' . $genderFilter . '/';
				$formData['fgender'] = $genderFilter;
				$formData['search']  = 'gender';
			}

			if ($phoneFilter != "") {
				$paginateUrl .= 'phone/' . $phoneFilter . '/';
				$formData['fphone'] = $phoneFilter;
				$formData['search'] = 'phone';
			}

			if ($cmndFilter != "") {
				$paginateUrl .= 'cmnd/' . $cmndFilter . '/';
				$formData['fcmnd']  = $cmndFilter;
				$formData['search'] = 'cmnd';
			}

			if ($regionFilter > 0) {
				$paginateUrl .= 'region/' . $regionFilter . '/';
				$formData['fregion'] = $regionFilter;
				$formData['search']  = 'region';
			}

			if ($referermemberidFilter > 0) {
				$paginateUrl .= 'referermemberid/' . $referermemberidFilter . '/';
				$formData['freferermemberid'] = $referermemberidFilter;
				$formData['search']           = 'referermemberid';
			}

			if ($datecreatedFilter > 0) {
				$paginateUrl .= 'datecreated/' . $datecreatedFilter . '/';
				$formData['fdatecreated'] = $datecreatedFilter;
				$formData['search']       = 'datecreated';
			}

			if ($datemodifiedFilter > 0) {
				$paginateUrl .= 'datemodified/' . $datemodifiedFilter . '/';
				$formData['fdatemodified'] = $datemodifiedFilter;
				$formData['search']        = 'datemodified';
			}

			if ($idFilter > 0) {
				$paginateUrl .= 'id/' . $idFilter . '/';
				$formData['fid']    = $idFilter;
				$formData['search'] = 'id';
			}

			if (strlen($keywordFilter) > 0) {
				$paginateUrl .= 'keyword/' . $keywordFilter . '/';

				if ($searchKeywordIn == 'urlcode') {
					$paginateUrl .= 'searchin/urlcode/';
				}
				elseif ($searchKeywordIn == 'fullname') {
					$paginateUrl .= 'searchin/fullname/';
				}
				elseif ($searchKeywordIn == 'email') {
					$paginateUrl .= 'searchin/email/';
				}
				elseif ($searchKeywordIn == 'phone') {
					$paginateUrl .= 'searchin/phone/';
				}
				elseif ($searchKeywordIn == 'cmnd') {
					$paginateUrl .= 'searchin/cmnd/';
				}
				$formData['fkeyword']  = $formData['fkeywordFilter'] = $keywordFilter;
				$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
				$formData['search']    = 'keyword';
			}

			//tim tong so
			$total     = Core_LotteMember::getLotteMembers($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total / $this->recordPerPage);
			$curPage   = $page;


			//get latest account
			$lottemembers = Core_LotteMember::getLotteMembers($formData, $sortby, $sorttype, (($page - 1) * $this->recordPerPage) . ',' . $this->recordPerPage);
			$event        = Core_LotteEvent::getLotteEvents(array(), '', '');
			//filter for sortby & sorttype
			$filterUrl = $paginateUrl;

			//append sort to paginate url
			$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
                        
                        
                        $rsstatic = Core_LotteCode::getstatic();
                        foreach ($rsstatic as $key => $value) {
                            $rsmember = Core_LotteMember::getLotteMembers(array('fid'=>$value['lm_id']), '', '');
                            $rsstatic[$key]['name']       = $rsmember[0]->fullname;
                            $rsstatic[$key]['phone']      = $rsmember[0]->phone;
                            $rsstatic[$key]['email']      = $rsmember[0]->email;
                            $rsstatic[$key]['cmnd']       = $rsmember[0]->cmnd;
                            $rsstatic[$key]['countcode']  = $value['dem'];
                            
                        }
			//build redirect string
			$redirectUrl = $paginateUrl;
			if ($curPage > 1) {
				$redirectUrl .= 'page/' . $curPage;
			}


			$redirectUrl = base64_encode($redirectUrl);


			$this->registry->smarty->assign(array('lottemembers' => $lottemembers,
                                                                'formData' => $formData,
                                                                'staticmember' => $rsstatic,
                                                                'success' => $success,
                                                                'error' => $error,
                                                                'warning' => $warning,
                                                                'filterUrl' => $filterUrl,
                                                                'paginateurl' => $paginateUrl,
                                                                'redirectUrl' => $redirectUrl,
                                                                'total' => $total,
                                                                'totalPage' => $totalPage,
                                                                'curPage' => $curPage,
                                                                'region' => $this->registry->setting['region'],
                                                                'permission' => $permission,
                                                                'event' => $event,));


			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');

			$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
												  'contents' => $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		}


		function addAction()
		{
			$error    = array();
			$success  = array();
			$contents = '';
			$formData = array();

			if (!empty($_POST['fsubmit'])) {
				if ($_SESSION['lottememberAddToken'] == $_POST['ftoken']) {
					$formData = array_merge($formData, $_POST);


					if ($this->addActionValidator($formData, $error)) {
						$myLotteMember = new Core_LotteMember();


						$myLotteMember->urlcode         = $formData['furlcode'];
						$myLotteMember->leid            = $formData['fleid'];
						$myLotteMember->fullname        = $formData['ffullname'];
						$myLotteMember->email           = $formData['femail'];
						$myLotteMember->gender          = $formData['fgender'];
						$myLotteMember->phone           = $formData['fphone'];
						$myLotteMember->cmnd            = $formData['fcmnd'];
						$myLotteMember->region          = $formData['fregion'];
						$myLotteMember->referermemberid = $formData['freferermemberid'];

						if ($myLotteMember->addData()) {
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('lottemember_add', $myLotteMember->id, array());
							$formData = array();
						}
						else {
							$error[] = $this->registry->lang['controller']['errAdd'];
						}
					}
				}

			}
			$_SESSION['lottememberAddToken'] = Helper::getSecurityToken(); //Tao token moi
			$event                           = Core_LotteEvent::getLotteEvents(array(), '', '');
			$this->registry->smarty->assign(array('formData' => $formData,
												  'redirectUrl' => $this->getRedirectUrl(),
												  'error' => $error,
												  'region' => $this->registry->setting['region'],
												  'success' => $success,
												  'event' => $event,

											));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'add.tpl');
			$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_add'],
												  'contents' => $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}


		function editAction()
		{
			$id            = (int)$this->registry->router->getArg('id');
			$myLotteMember = new Core_LotteMember($id);

			$redirectUrl = $this->getRedirectUrl();
			if ($myLotteMember->id > 0) {
				$error    = array();
				$success  = array();
				$contents = '';
				$formData = array();

				$formData['fbulkid'] = array();


				$formData['fleid']            = $myLotteMember->leid;
				$formData['fuid']             = $myLotteMember->uid;
				$formData['fid']              = $myLotteMember->id;
				$formData['furlcode']         = $myLotteMember->urlcode;
				$formData['ffullname']        = $myLotteMember->fullname;
				$formData['femail']           = $myLotteMember->email;
				$formData['fgender']          = $myLotteMember->gender;
				$formData['fphone']           = $myLotteMember->phone;
				$formData['fcmnd']            = $myLotteMember->cmnd;
				$formData['fregion']          = $myLotteMember->region;
				$formData['freferermemberid'] = $myLotteMember->referermemberid;
				$formData['fdatecreated']     = $myLotteMember->datecreated;
				$formData['fdatemodified']    = $myLotteMember->datemodified;

				if (!empty($_POST['fsubmit'])) {
					if ($_SESSION['lottememberEditToken'] == $_POST['ftoken']) {
						$formData = array_merge($formData, $_POST);

						if ($this->editActionValidator($formData, $error)) {

							$myLotteMember->urlcode         = $formData['furlcode'];
							$myLotteMember->fullname        = $formData['ffullname'];
							$myLotteMember->email           = $formData['femail'];
							$myLotteMember->gender          = $formData['fgender'];
							$myLotteMember->phone           = $formData['fphone'];
							$myLotteMember->cmnd            = $formData['fcmnd'];
							$myLotteMember->region          = $formData['fregion'];
							$myLotteMember->referermemberid = $formData['freferermemberid'];

							if ($myLotteMember->updateData()) {
								$success[] = $this->registry->lang['controller']['succUpdate'];
								$this->registry->me->writelog('lottemember_edit', $myLotteMember->id, array());
							}
							else {
								$error[] = $this->registry->lang['controller']['errUpdate'];
							}
						}
					}


				}

				$event                            = Core_LotteEvent::getLotteEvents(array(), '', '');
				$_SESSION['lottememberEditToken'] = Helper::getSecurityToken(); //Tao token moi

				$this->registry->smarty->assign(array('formData' => $formData,
													  'redirectUrl' => $redirectUrl,
													  'error' => $error,
													  'success' => $success,
													  'region' => $this->registry->setting['region'],
													  'event' => $event,));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'edit.tpl');
				$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_edit'],
													  'contents' => $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
			else {
				$redirectMsg = $this->registry->lang['controller']['errNotFound'];
				$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													  'redirectMsg' => $redirectMsg,));
				$this->registry->smarty->display('redirect.tpl');
			}
		}

		function deleteAction()
		{
			$id            = (int)$this->registry->router->getArg('id');
			$myLotteMember = new Core_LotteMember($id);
			if ($myLotteMember->id > 0) {
				//tien hanh xoa
				if ($myLotteMember->delete()) {
					$redirectMsg = str_replace('###id###', $myLotteMember->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('lottemember_delete', $myLotteMember->id, array());
				}
				else {
					$redirectMsg = str_replace('###id###', $myLotteMember->id, $this->registry->lang['controller']['errDelete']);
				}

			}
			else {
				$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			}

			$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												  'redirectMsg' => $redirectMsg,));
			$this->registry->smarty->display('redirect.tpl');

		}

		####################################################################################################
		####################################################################################################
		####################################################################################################

		//Kiem tra du lieu nhap trong form them moi
		private function addActionValidator($formData, &$error)
		{
			$pass = true;


			if ($formData['furlcode'] == '') {
				$error[] = $this->registry->lang['controller']['errUrlcodeRequired'];
				$pass    = false;
			}

			if ($formData['ffullname'] == '') {
				$error[] = $this->registry->lang['controller']['errFullnameRequired'];
				$pass    = false;
			}

			if ($formData['femail'] == '') {
				$error[] = $this->registry->lang['controller']['errEmailRequired'];
				$pass    = false;
			}

			if ($formData['fgender'] == '') {
				$error[] = $this->registry->lang['controller']['errGenderRequired'];
				$pass    = false;
			}

			if ($formData['fphone'] == '') {
				$error[] = $this->registry->lang['controller']['errPhoneRequired'];
				$pass    = false;
			}

			if ($formData['fcmnd'] == '') {
				$error[] = $this->registry->lang['controller']['errCmndRequired'];
				$pass    = false;
			}
			if ($formData['fleid'] == '') {
				$error[] = 'Event not empty';
				$pass    = false;
			}

			if ($formData['freferermemberid'] == '') {
				$error[] = $this->registry->lang['controller']['errReferermemberidRequired'];
				$pass    = false;
			}

			return $pass;
		}

		//Kiem tra du lieu nhap trong form cap nhat
		private function editActionValidator($formData, &$error)
		{
			$pass = true;


			if ($formData['furlcode'] == '') {
				$error[] = $this->registry->lang['controller']['errUrlcodeRequired'];
				$pass    = false;
			}

			if ($formData['ffullname'] == '') {
				$error[] = $this->registry->lang['controller']['errFullnameRequired'];
				$pass    = false;
			}

			if ($formData['femail'] == '') {
				$error[] = $this->registry->lang['controller']['errEmailRequired'];
				$pass    = false;
			}

			if ($formData['fgender'] == '') {
				$error[] = $this->registry->lang['controller']['errGenderRequired'];
				$pass    = false;
			}

			if ($formData['fphone'] == '') {
				$error[] = $this->registry->lang['controller']['errPhoneRequired'];
				$pass    = false;
			}

			if ($formData['fcmnd'] == '') {
				$error[] = $this->registry->lang['controller']['errCmndRequired'];
				$pass    = false;
			}

			if ($formData['fleid'] == '') {
				$error[] = 'Event not empty';
				$pass    = false;
			}

			if ($formData['freferermemberid'] == '') {
				$error[] = $this->registry->lang['controller']['errReferermemberidRequired'];
				$pass    = false;
			}

			return $pass;
		}
	}

