<?php

	Class Controller_Cms_LotteCode Extends Controller_Cms_Base
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


			$leidFilter           = (int)($this->registry->router->getArg('leid'));
			$lmidFilter           = (int)($this->registry->router->getArg('lmid'));
			$typeFilter           = (int)($this->registry->router->getArg('type'));
			$codeFilter           = (string)($this->registry->router->getArg('code'));
			$erpsaleorderidFilter = (string)($this->registry->router->getArg('erpsaleorderid'));
			$refererFilter        = (int)($this->registry->router->getArg('referer'));
			$phoneFilter         = (int)($this->registry->router->getArg('phone'));
			$datecreatedFilter    = (int)($this->registry->router->getArg('datecreated'));
			$idFilter             = (int)($this->registry->router->getArg('id'));

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
				if ($_SESSION['lottecodeBulkToken'] == $_POST['ftoken']) {
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
								$myLotteCode = new Core_LotteCode($id);

								if ($myLotteCode->id > 0) {
									//tien hanh xoa
									if ($myLotteCode->delete()) {
										$deletedItems[] = $myLotteCode->id;
										$this->registry->me->writelog('lottecode_delete', $myLotteCode->id, array());
									}
									else {
										$cannotDeletedItems[] = $myLotteCode->id;
									}
								}
								else {
									$cannotDeletedItems[] = $myLotteCode->id;
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

			$_SESSION['lottecodeBulkToken'] = Helper::getSecurityToken(); //Gan token de kiem soat viec nhan nut submit form

			$paginateUrl = $this->registry->conf['rooturl'] . $this->registry->controllerGroup . '/' . $this->registry->controller . '/index/';


			if ($leidFilter > 0) {
				$paginateUrl .= 'leid/' . $leidFilter . '/';
				$formData['fleid']  = $leidFilter;
				$formData['search'] = 'leid';
			}

			if ($lmidFilter > 0) {
				$paginateUrl .= 'lmid/' . $lmidFilter . '/';
				$formData['flmid']  = $lmidFilter;
				$formData['search'] = 'lmid';
			}

			if ($typeFilter > 0) {
				$paginateUrl .= 'type/' . $typeFilter . '/';
				$formData['ftype']  = $typeFilter;
				$formData['search'] = 'type';
			}

			if ($codeFilter != "") {
				$paginateUrl .= 'code/' . $codeFilter . '/';
				$formData['fcode']  = $codeFilter;
				$formData['search'] = 'code';
			}

			if ($erpsaleorderidFilter != "") {
				$paginateUrl .= 'erpsaleorderid/' . $erpsaleorderidFilter . '/';
				$formData['ferpsaleorderid'] = $erpsaleorderidFilter;
				$formData['search']          = 'erpsaleorderid';
			}

			if ($refererFilter > 0) {
				$paginateUrl .= 'referer/' . $refererFilter . '/';
				$formData['freferer'] = $refererFilter;
				$formData['search']   = 'referer';
			}

			if ($phoneFilter > 0) {
				$paginateUrl .= 'phone/' . $phoneFilter . '/';
				$formData['fphone'] = $phoneFilter;
				$formData['search']  = 'phone';
			}

			if ($datecreatedFilter > 0) {
				$paginateUrl .= 'datecreated/' . $datecreatedFilter . '/';
				$formData['fdatecreated'] = $datecreatedFilter;
				$formData['search']       = 'datecreated';
			}

			if ($idFilter > 0) {
				$paginateUrl .= 'id/' . $idFilter . '/';
				$formData['fid']    = $idFilter;
				$formData['search'] = 'id';
			}

			if (strlen($keywordFilter) > 0) {
				$paginateUrl .= 'keyword/' . $keywordFilter . '/';

				if ($searchKeywordIn == 'code') {
					$paginateUrl .= 'searchin/code/';
				}
				elseif ($searchKeywordIn == 'erpsaleorderid') {
					$paginateUrl .= 'searchin/erpsaleorderid/';
				}
				$formData['fkeyword']  = $formData['fkeywordFilter'] = $keywordFilter;
				$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
				$formData['search']    = 'keyword';
			}

			//tim tong so
			$total     = Core_LotteCode::getLotteCodes($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total / $this->recordPerPage);
			$curPage   = $page;


			//get latest account
			$lottecodes = Core_LotteCode::getLotteCodes($formData, $sortby, $sorttype, (($page - 1) * $this->recordPerPage) . ',' . $this->recordPerPage);
			if(isset($formData['fphone']))
			{
				foreach ($lottecodes as $key=>$value) {
					$member = new Core_LotteMember($value->lmid);
					if($member->id!=null)
					{
						if($member->phone==$formData['fphone'])
						{
							unset($lottecodes[$key]);
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
			if ($curPage > 1) {
				$redirectUrl .= 'page/' . $curPage;
			}


			$redirectUrl = base64_encode($redirectUrl);
			$event       = Core_LotteEvent::getLotteEvents(array(), '', '');
			$type 		 = Core_LotteCode::getType();
			$this->registry->smarty->assign(array('lottecodes' => $lottecodes,
												  'formData' => $formData,
												  'success' => $success,
												  'error' => $error,
												  'warning' => $warning,
												  'filterUrl' => $filterUrl,
												  'paginateurl' => $paginateUrl,
												  'redirectUrl' => $redirectUrl,
												  'total' => $total,
												  'totalPage' => $totalPage,
												  'curPage' => $curPage,
												  'type' => $type,
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
				if ($_SESSION['lottecodeAddToken'] == $_POST['ftoken']) {
					$formData = array_merge($formData, $_POST);


					if ($this->addActionValidator($formData, $error)) {
						$myLotteCode = new Core_LotteCode();


						$myLotteCode->lmid           = $formData['flmid'];
						$myLotteCode->type           = $formData['ftype'];
						$myLotteCode->code           = $formData['fcode'];
						$myLotteCode->erpsaleorderid = $formData['ferpsaleorderid'];
						$myLotteCode->referer        = $formData['freferer'];
						$myLotteCode->status         = $formData['fstatus'];

						if ($myLotteCode->addData()) {
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('lottecode_add', $myLotteCode->id, array());
							$formData = array();
						}
						else {
							$error[] = $this->registry->lang['controller']['errAdd'];
						}
					}
				}

			}

			$_SESSION['lottecodeAddToken'] = Helper::getSecurityToken(); //Tao token moi
			$type                          = Core_LotteCode::getType();
			$this->registry->smarty->assign(array('formData' => $formData,
												  'redirectUrl' => $this->getRedirectUrl(),
												  'error' => $error,
												  'success' => $success,
												  'type' => $type));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'add.tpl');
			$this->registry->smarty->assign(array('pageTitle' => $this->registry->lang['controller']['pageTitle_add'],
												  'contents' => $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}


		function editAction()
		{
			$id          = (int)$this->registry->router->getArg('id');
			$myLotteCode = new Core_LotteCode($id);

			$redirectUrl = $this->getRedirectUrl();
			if ($myLotteCode->id > 0) {
				$error    = array();
				$success  = array();
				$contents = '';
				$formData = array();

				$formData['fbulkid'] = array();


				$formData['fleid']           = $myLotteCode->leid;
				$formData['flmid']           = $myLotteCode->lmid;
				$formData['fid']             = $myLotteCode->id;
				$formData['ftype']           = $myLotteCode->type;
				$formData['fcode']           = $myLotteCode->code;
				$formData['ferpsaleorderid'] = $myLotteCode->erpsaleorderid;
				$formData['freferer']        = $myLotteCode->referer;
				$formData['fstatus']         = $myLotteCode->status;
				$formData['fdatecreated']    = $myLotteCode->datecreated;

				if (!empty($_POST['fsubmit'])) {
					if ($_SESSION['lottecodeEditToken'] == $_POST['ftoken']) {
						$formData = array_merge($formData, $_POST);

						if ($this->editActionValidator($formData, $error)) {

							$myLotteCode->lmid           = $formData['flmid'];
							$myLotteCode->type           = $formData['ftype'];
							$myLotteCode->code           = $formData['fcode'];
							$myLotteCode->erpsaleorderid = $formData['ferpsaleorderid'];
							$myLotteCode->referer        = $formData['freferer'];
							$myLotteCode->status         = $formData['fstatus'];

							if ($myLotteCode->updateData()) {
								$success[] = $this->registry->lang['controller']['succUpdate'];
								$this->registry->me->writelog('lottecode_edit', $myLotteCode->id, array());
							}
							else {
								$error[] = $this->registry->lang['controller']['errUpdate'];
							}
						}
					}


				}


				$_SESSION['lottecodeEditToken'] = Helper::getSecurityToken(); //Tao token moi

				$this->registry->smarty->assign(array('formData' => $formData,
													  'redirectUrl' => $redirectUrl,
													  'error' => $error,
													  'success' => $success,

												));
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
			$id          = (int)$this->registry->router->getArg('id');
			$myLotteCode = new Core_LotteCode($id);
			if ($myLotteCode->id > 0) {
				//tien hanh xoa
				if ($myLotteCode->delete()) {
					$redirectMsg = str_replace('###id###', $myLotteCode->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('lottecode_delete', $myLotteCode->id, array());
				}
				else {
					$redirectMsg = str_replace('###id###', $myLotteCode->id, $this->registry->lang['controller']['errDelete']);
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


			if ($formData['flmid'] == '') {
				$error[] = $this->registry->lang['controller']['errLmidRequired'];
				$pass    = false;
			}

			if ($formData['ftype'] == '') {
				$error[] = $this->registry->lang['controller']['errTypeRequired'];
				$pass    = false;
			}

			if ($formData['fcode'] == '') {
				$error[] = $this->registry->lang['controller']['errCodeRequired'];
				$pass    = false;
			}

			if ($formData['ferpsaleorderid'] == '') {
				$error[] = $this->registry->lang['controller']['errErpsaleorderidRequired'];
				$pass    = false;
			}

			if ($formData['freferer'] == '') {
				$error[] = $this->registry->lang['controller']['errRefererRequired'];
				$pass    = false;
			}

			return $pass;
		}

		//Kiem tra du lieu nhap trong form cap nhat
		private function editActionValidator($formData, &$error)
		{
			$pass = true;


			if ($formData['flmid'] == '') {
				$error[] = $this->registry->lang['controller']['errLmidRequired'];
				$pass    = false;
			}

			if ($formData['ftype'] == '') {
				$error[] = $this->registry->lang['controller']['errTypeRequired'];
				$pass    = false;
			}

			if ($formData['fcode'] == '') {
				$error[] = $this->registry->lang['controller']['errCodeRequired'];
				$pass    = false;
			}

			if ($formData['ferpsaleorderid'] == '') {
				$error[] = $this->registry->lang['controller']['errErpsaleorderidRequired'];
				$pass    = false;
			}

			if ($formData['freferer'] == '') {
				$error[] = $this->registry->lang['controller']['errRefererRequired'];
				$pass    = false;
			}

			return $pass;
		}
	}

