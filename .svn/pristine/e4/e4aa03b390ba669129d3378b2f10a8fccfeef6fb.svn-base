<?php

Class Controller_Crm_Saleorder Extends Controller_Crm_Base
{
	public $recordPerPage = 20;

	public function indexAction()
	{
		// var_dump($this->registry);
	/*	var_dump(preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)com+$/", "adsadsa@"));
		die();*/

		$formData 		= array('fbulkid' => array());
		$formData['countCus'] = 0;
		$formData['countCom'] = 0;




		$saleorders =  new Core_Saleorder();


		$keysearch = $this->registry->router->getArg('searchkey');

		$saleorder = $saleorders->getSaleorderByid($keysearch);
		$formData['count'] =  count($saleorder);
		$paginateUrl = $this->registry->conf['rooturl_crm'].'customer/index/';

		//build redirect string
		$redirectUrl = $paginateUrl;

		//build redirect string
		$redirectUrl = $paginateUrl;
		$redirectUrl = base64_encode($redirectUrl);
		$error 			= array();
		$success 		= array();
		$warning 		= array();


		$_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link

		if(!empty($_POST['fsubmitbulk']))
		{
			if(!isset($_POST['fbulkid']))
			{
				$warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
			}
			else
			{
				$formData['fbulkid'] = $_POST['fbulkid'];

				//check for delete
				if($_POST['fbulkaction'] == 'delete')
				{
					$delArr = $_POST['fbulkid'];
					$deletedItems = array();
					$cannotDeletedItems = array();
					foreach($delArr as $id)
					{
						//check valid user and not admin user
						$myUser = new Core_User($id);

						if($myUser->id > 0)
						{
							//tien hanh xoa
							if($myUser->delete())
							{
								$deletedItems[] = $myUser->email;
								$this->registry->me->writelog('user_delete', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname, 'dateregister' => date('H:i:s d/m/Y', $myUser->datecreated)));
							}
							else
								$cannotDeletedItems[] = $myUser->email;
						}
						else
							$cannotDeletedItems[] = $myUser->email;
					}

					if(count($deletedItems) > 0)
						$success[] = str_replace('###email###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

					if(count($cannotDeletedItems) > 0)
						$error[] = str_replace('###email###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
				}
				else
				{
					//bulk action not select, show error
					$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
				}
			}
		}




		$userGroups = array('Customer','Company');
		$this->registry->smarty->assign(array(	'saleorder' 	=> $saleorder,
												'formData'		=> $formData,
												'userGroups' 	=> $userGroups,
												'redirectUrl'	=> $redirectUrl,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'menu'		=> 'userlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myUser = new Core_User($id);


		if($myUser->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myUser->delete())
				{
					$redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('user_delete', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname, 'dateregister' => date('H:i:s d/m/Y', $myUser->datecreated)));
				}
				else
				{
					$redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['errDelete']);
				}
			}
			else
				$redirectMsg = $this->registry->lang['default']['errFormTokenInvalid'];


		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}

		$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												'redirectMsg' => $redirectMsg,
												));
		$this->registry->smarty->display('redirect.tpl');
	}

	function addAction()
    {

		 $action  = $this->registry->router->getArg('action');
    	 $saleorders =  new Core_Saleorder();
    	 $city =  $saleorders->getCityDic();
    	$arrCity = $city[1];
    	$arrDis = $city[0];


        $error     = array();
        $success     = array();
        $contents     = '';
        $formData     = array();

        if(!empty($_POST['fsubmit']))
        {
        	//kiem tra token
			if($_SESSION['userAddToken']==$_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);
				$date =  explode("/",$formData['fbirthday']);
				$formData['fbirthday'] = $date[2]."-".$date[1]."-".$date[0];
				$date2 =  explode("/",$formData['fEXPIRATIONDATEBANKACC']);
				$formData['fEXPIRATIONDATEBANKACC']= $date2[2]."-".$date2[1]."-".$date2[0];

				//kiem tra du lieu nhap
				if($this->addActionValidator($formData, $error))
				{
					$arr['strFullname']               = $formData['fstrFullname'];
					$arr['strAddress']                = $formData['faddress'];
					$arr['strBillAddress']            = $formData['fBillAddress'];
					$arr['strShippAddress']           = $formData['fShippAddress'];
					$arr['strEmail']                  = $formData['fmainemail'];
					$arr['strPhone']                  = $formData['fmainmobile'];
					$arr['strPersonalID']             = $formData['fstrPersonalID'];
					$arr['strNote']                   = $formData['fNote'];
					$arr['intGender']                 = $formData['fgender'];
					$arr['dtBirthdate']               = $formData['fbirthday'];
					$arr['strTaxNo']                  = $formData['ftaxno'];
					$arr['intStoreID']                = $formData['fStoreID'];
					$arr['intCountryID']              = "3";
					$arr['intProvinceID']             = $formData['fcity'];
					$arr['intDistrictID']             = $formData['fdistrict'];
					$arr['intPayment']                = $formData['fPayment'];
					$arr['intDelivery']               = $formData['fDelivery'];
					$arr['dbShippingCost']            = $formData['fShippingCost'];
					$arr['intCurrencyUnit']           = $formData['fCurrencyUnit'];
					$arr['dbCurrencyExchange']        = $formData['fCurrencyExchange'];
					$arr['intProductID']              = $formData['fProductID'];
					$arr['intQuantity']               = $formData['fQuantity'];
					$arr['strProductCode']            = $formData['fProductCode'];
					$arr['strIMEI']                   = $formData['fIMEI'];
					$arr['intCategoryID']             = $formData['fCategoryID'];
					$arr['dbPrice']                   = $formData['fPrice'];
					$arr['lstProductList']            =array('0','0');
					$arr['strAccountSecretInfo']      = $formData['fstrFullname'];
					$arr['strCouponCode']             = $formData['fCouponCode'];
					$arr['flCouponDiscount']          = $formData['fCouponDiscount'];
					$arr['strOWNERBANKNAME']          = $formData['fOWNERBANKNAME'];
					$arr['dateEXPIRATIONDATEBANKACC'] = $formData['fEXPIRATIONDATEBANKACC'];
					var_dump($arr);
				    $rs =	$saleorders->addSaleorder($arr);
					if($rs != 0)
					{
						$success[] =$this->registry->lang['controller']['succAdd']." Mã đơn hàng là : ".$rs['TGDD_WEB_CreateSaleOrderCustomerResult'];
					}
				}
			}
        }
	    var_dump($rs);
        $_SESSION['userAddToken'] = Helper::getSecurityToken();  //them token moi


        $this->registry->smarty->assign(array(  'formData'         => $formData,
                                                'City'    => $arrCity,
                                                'District'    => $arrDis,
                                                'redirectUrl'    => $this->getRedirectUrl(),
                                                'userGroups' => Core_User::getGroupnameList(),
                                                'error'            => $error,
                                                'success'        => $success,

                                                ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');


        $this->registry->smarty->assign(array(    'menu'        => 'useradd',
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_add'],
                                                'contents'     => $contents));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }




    function editAction()
    {


	    $customers = new Core_Customer();

        $id = (int)$this->registry->router->getArg('id');
        $myUser = new Core_User($id);
	    $customer = $customers->searchCustomer($id,"0");
	    $city =  $customers->getCityDic();
	    $arrCity = $city[1];
	    $arrDis = $city[0];
	    $redirectUrl = $this->getRedirectUrl();
	    var_dump($customer);
        if($myUser)
        {


	        $formData['ffname'] = utf8_encode($customer[0]["FIRSTNAME"]);
	        $formData['customerID'] = $customer[0]["CUSTOMERID"];
	        $formData['flname'] = utf8_encode($customer[0]["LASTNAME"]);
	        $formData['faddress'] = $customer[0]["ADDRESS"];
	        $formData['fcity'] = $customer[0]["CITYID"];
	        $formData['fgender'] = $customer[0]["GENDER"];
	        $formData['fdistrict'] = $customer[0]["DISTRICTID"];
	        $formData['fbirthday'] = $customer[0]["BIRTHDAY"];
	        $formData['fmainmobile'] = $customer[0]["MAINMOBILE"];
	        $formData['fsubmobile'] = $customer[0]["SUBMOBILE"];
	        $formData['fmainemail'] = $customer[0]["MAINEMAIL"];
	        $formData['fsubemail'] = $customer[0]["SUBEMAIL"];
	        $formData['foaddress'] = "";
	        $formData['PID'] = 0;
	        $formData['fsms'] = true;
	        $date =  explode("-",$formData['fbirthday']);
	        $formData['fbirthday'] = $date[0]."/".$date[1]."/".$date[2];
	            if(!empty($_POST['fsubmit']))
	            {
	                if($_SESSION['userEditToken']==$_POST['ftoken'])
	                {
	                    $formData = array_merge($formData, $_POST);
	                    //kiem tra du lieu nhap
	                    if($this->editActionValidator($formData, $customer , $error))
	                    {
		                    $date =  explode("/",$formData['fbirthday']);
		                    $formData['fbirthday'] = $date[2]."-".$date[1]."-".$date[0];
		                    $arr['firstName']  = $formData['ffname'];
		                    $arr['customerID']  = $formData['customerID'];
		                    $arr['lastName']  = $formData['flname'];
		                    $arr['intGender']  = $formData['fgender'];
		                    $arr['birthDay']  =  $formData['fbirthday'];
		                    $arr['cityID']  = $formData['fcity'];
		                    $arr['address']  = $formData['faddress'];
		                    $arr['otherAddress']  = $formData['foaddress'];
		                    $arr['districtID']  = $formData['fdistrict'];
		                    $arr['mobile']  = $formData['fmainmobile'];
		                    $arr['phone']  = $formData['fsubmobile'];
		                    $arr['email']  = $formData['fmainemail'];
		                    $arr['otherEmail']  = $formData['fsubemail'];
		                    $arr['otherEmail']  = $formData['fsubemail'];
		                    $arr['DONOTSMS']  = $formData['fsms'];
		                    $rs =	$customers->updateCustomer($arr);
		                    if($rs==1)
		                    {
			                    $success[] =$this->registry->lang['controller']['succEdit'];
		                    }
	                    }
	                }
	            }
	        var_dump($rs);
	            $_SESSION['userEditToken']=Helper::getSecurityToken();//Tao token moi
	            $this->registry->smarty->assign(array(   'formData'     => $formData,
            											'myUser'	=> $myUser,
											            'City'    => $arrCity,
											            'District'    => $arrDis,
	                                                    'redirectUrl'=> $redirectUrl,
	                                                    'error'        => $error,
	                                                    'success'    => $success,

	                                                    ));
	            $contents= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
	            $this->registry->smarty->assign(array(
	                                                    'menu'        => 'userlist',
	                                                    'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'],
	                                                    'contents'             => $contents));
	            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');


        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                    'redirectMsg' => $redirectMsg,
                                                    ));
            $this->registry->smarty->display('redirect.tpl');
        }
    }

	function resetpassAction()
	{
		$id = (int)$this->registry->router->getArg('id');
        $myUser = new Core_User($id);
        $redirectUrl = $this->getRedirectUrl();

        if($myUser->id > 0)
        {
            //check priviledge priority
            //Yeu cau de edit:
            // 1. Hoac la admin
            // 2. Hoac la edit ban than, dung cho moderator, judge...
            // 3. Hoac la co priority number < priority number cua user duoc edit
            if($this->registry->me->groupid == GROUPID_ADMIN || ($this->registry->me->id == $myUser->id) )
            {
            	$error 		= array();
				$success 	= array();
				$contents 	= '';
				$formData 	= array();


				 srand((double)microtime()*1000000);
	   	 		 $newpass = rand(100000, 999999);

	   			 if($myUser->resetpass($newpass))
	   			 {
	   		 		 //send mail
	   		 		 $this->registry->smarty->assign(array('newpass' => $newpass,
	   		 	 											'myUser'	=> $myUser));
	   		 		 $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'user/resetpass.tpl');
	   		 		 $sender=  new SendMail($this->registry,
											$myUser->email,
											$myUser->fullname,
											str_replace('{USERNAME}', $myUser->username, $this->registry->setting['mail']['subjectAdminResetpassUser']),
											$mailContents,
											$this->registry->setting['mail']['fromEmail'],
											$this->registry->setting['mail']['fromName']
											);

					 $this->registry->me->writelog('user_resetpass', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname, 'newpass' => $newpass));


	   		 		 if($sender->Send())
	   		 		 {
	   		 	 		  $redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['succResetpass']);
					 }
					 else
					 {
				 		 $redirectMsg = str_replace('###email###', $myUser->email, $this->registry->lang['controller']['errResetpassSendMail']);
					 }
				 }
				 else
				 {
			 		 $redirectMsg = $this->registry->lang['controller']['errResetpass'];
				 }

				 $redirectUrl = $this->registry->conf['rooturl_admin'] . 'user/edit/id/' . $myUser->id;

			}
            else
            {
            	$redirectMsg = $this->registry->lang['global']['notpermissiontitle'];
			}

        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
        }


		 $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                'redirectMsg' => $redirectMsg,
                                                ));
        $this->registry->smarty->display('redirect.tpl');
	}

	####################################################################################################
	####################################################################################################
	####################################################################################################


	private function addActionValidator($formData, &$error)
    {
        $pass = true;

        $customer =  new Core_Customer();
        //kiem tra email co dung dinh dang hay khong    :ValidatedEmail
        if(!Helper::ValidatedEmail($formData['fmainemail']))
        {
            $error[] = $this->registry->lang['controller']['errEmailInvalid'];
            $pass = false;
        }


        //kiem tra password


        if($formData['fstrFullname'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfstrFullname'];
            $pass = false;
		}
	    if($formData['fstrPersonalID'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfstrPersonalID'];
            $pass = false;
		}
	    else
	    {
		    if(!is_numeric($formData['fstrPersonalID']) && strlen($formData['fstrPersonalID'])!=9)
		    {
			    $error[] = $this->registry->lang['controller']['errfstrPersonalIDorther'];
			    $pass = false;
		    }
	    }




        if($formData['fgender'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfgender'];
            $pass = false;
		}



        if($formData['fcity'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfcity'];
            $pass = false;
		}

        if($formData['fdistrict'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfdistrict'];
            $pass = false;
		}
        if($formData['fProductID'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfProductID'];
            $pass = false;
		}
        if($formData['fQuantity'] == '')
        {

        	$error[] = $this->registry->lang['controller']['fQuantity'];
            $pass = false;
		}
        if($formData['fCategoryID'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfCategoryID'];
            $pass = false;
		}
	    if($formData['fPrice'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfPrice'];
            $pass = false;
		}





        if($formData['fmainmobile'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errfmainmobile'];
            $pass = false;
		}
	    else
	    {
		    if(!is_numeric($formData['fmainmobile']))
		    {
			    $error[] = $this->registry->lang['controller']['errfnummainmobile'];
			    $pass = false;
		    }


	    }




        return $pass;
    }
     //khong cap nhat username
    private function editActionValidator($formData,$dataold, &$error)
    {

        $pass = true;
	    $customer =  new Core_Customer();
	    if(!Helper::ValidatedEmail($formData['fmainemail']))
	    {
		    $error[] = $this->registry->lang['controller']['errEmailInvalid'];
		    $pass = false;
	    }
	    else
	    {
		    if($dataold[0]['MAINEMAIL'] != $formData['fmainemail'])
		    {
			    if(!$customer->checkEmail($formData['fmainemail']))
			    {

				    $error[] = $this->registry->lang['controller']['errEmailExisted'];
				    $pass = false;
			    }
		    }
		    //kiem tra co trung email hay khong

	    }

	    //kiem tra password


	    if($formData['ffname'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errffname'];
		    $pass = false;
	    }


	    if($formData['flname'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errflname'];
		    $pass = false;
	    }

	    if($formData['fgender'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errfgender'];
		    $pass = false;
	    }

	    if($formData['fbirthday'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errfbirthday'];
		    $pass = false;
	    }

	    if($formData['fcity'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errfcity'];
		    $pass = false;
	    }

	    if($formData['fdistrict'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errfdistrict'];
		    $pass = false;
	    }

	    if($formData['faddress'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errfaddress'];
		    $pass = false;
	    }



	    if($formData['fmainmobile'] == '')
	    {
		    $error[] = $this->registry->lang['controller']['errfmainmobile'];
		    $pass = false;
	    }
	    else
	    {

		    if(!is_numeric($formData['fmainmobile']))
		    {
			    $error[] = $this->registry->lang['controller']['errfnummainmobile'];
			    $pass = false;
		    }
		    if($dataold[0]['MAINMOBILE']!=$formData['fmainmobile'])
		    {
			    if(!$customer->checkMobile($formData['fmainmobile']))
			    {
				    $error[] = $this->registry->lang['controller']['errmobileExisted'];
				    $pass = false;
			    }
		    }
	    }



	    return $pass;
    }


	public function searchidAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array();

		$idFilter 		= (int)($this->registry->router->getArg('id'));
		$groupidFilter 		= (int)($this->registry->router->getArg('groupid'));
		$keywordFilter 	= $this->registry->router->getArg('keyword');
		$searchKeywordIn= $this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;




		$paginateUrl = $this->registry->conf['rooturl_admin'].'user/searchid/';

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if($groupidFilter > 0)
		{
			$paginateUrl .= 'groupid/'.$groupidFilter . '/';
			$formData['fgroupid'] = $groupidFilter;
			$formData['search'] = 'groupid';
		}


		if(strlen($keywordFilter) > 0)
		{

			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'screenname')
			{
				$paginateUrl .= 'searchin/screenname/';
			}
			else if($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			else if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}


		//get latest account
		$users = Core_User::getUsers($formData, $sortby, $sorttype, 100);


		//build redirect string
		$redirectUrl = $paginateUrl;


		$this->registry->smarty->assign(array(	'users' 		=> $users,
												'formData'		=> $formData,
												'userGroups' => Core_User::getGroupnameList(),
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'redirectUrl'	=> $redirectUrl,
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'searchid.tpl');

		$this->registry->smarty->assign(array(	'menu'		=> 'userlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_tiny.tpl');
	}


	function changepasswordAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myUser = new Core_User($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myUser->id > 0)
        {
            //check priviledge priority
            //Yeu cau de edit:
            // 1. Hoac la admin
            // 2. Hoac la edit ban than
            if($this->registry->me->id == $myUser->id )
            {
            	$error         = array();
	            $success     = array();
	            $contents     = '';
	            $formData     = array();

	            if(!empty($_POST['fsubmit']))
	            {
					$formData = array_merge($formData, $_POST);

                    //kiem tra du lieu nhap
                    if($this->changepasswordActionValidator($formData, $error))
                    {

                        $myUser->newpass = $formData['fnewpass1'];

                        if($myUser->updateData(array(), $error))
                        {
                           $success[] = $this->registry->lang['controller']['succChangepassword'];
                           $this->registry->me->writelog('user_changepassword', $myUser->id, array('email' => $myUser->email, 'fullname' => $myUser->fullname));
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errChangepassword'];
                        }
                    }

	            }


	            $this->registry->smarty->assign(array(   'formData'     => $formData,
            											'myUser'	=> $myUser,
	                                                    'redirectUrl'=> $redirectUrl,
	                                                    'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                    'error'        => $error,
	                                                    'success'    => $success,
	                                                    ));
	            $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'changepassword.tpl');
	            $this->registry->smarty->assign(array(
	                                                    'pageTitle'    => $this->registry->lang['controller']['pageTitle_changepassword'],
	                                                    'contents'             => $contents));
	            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
            else
            {
            	$redirectMsg = $this->registry->lang['global']['notpermissiontitle'];
	            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
	                                                    'redirectMsg' => $redirectMsg,
	                                                    ));
	            $this->registry->smarty->display('redirect.tpl');
			}

        }
        else
        {
            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
            $this->registry->smarty->assign(array('redirect' => $redirectUrl,
                                                    'redirectMsg' => $redirectMsg,
                                                    ));
            $this->registry->smarty->display('redirect.tpl');
        }
    }



	private function changepasswordActionValidator($formData, &$error)
	{
		$pass = true;

		//check oldpass
		//change password
		if(!viephpHashing::authenticate($formData['foldpass'], $this->registry->me->password))
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errOldpassNotvalid'];
		}

		if(strlen($formData['fnewpass1']) < 6)
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotvalid'];
		}

		if($formData['fnewpass1'] != $formData['fnewpass2'])
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotmatch'];
		}

		return $pass;
	}

}
