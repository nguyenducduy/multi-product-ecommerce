<?php
class Controller_Cms_ProductEditInline extends Controller_Cms_Base
{
	const TAB_IMAGE = 1;
	const TAB_GALLERY = 2;
	const TAB_IMAGE360 = 3;
	const TAB_VIDEO = 4;

	public function indexAction()
	{

	}

    private function editInit($pcid, $vid = 0)
    {
        global $db;
        global $registry;
        $permission = false;
        //kiem tra xem user nay co trong nhom nguoi dc phep sua hay khong
        if(in_array($registry->me->groupid, $registry->setting['product']['allowEdit']))
        {
            if(!$registry->me->isGroup('administrator') && !$registry->me->isGroup('developer'))
            {               
                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($pcid);

                //create suffix
                $suffix = 'pedit_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);
            }
            else
            {
                $permission = true;
            }
        }

        return $permission;
    }


    public function edittextareaAction()
	{
		$pid = (int)$this->registry->router->getArg('fpid');
		$pcid = (int)$this->registry->router->getArg('fpcid');
		$col = (string)$this->registry->router->getArg('fcol');;


		$formData = array();
		$error = array();
		$success = array();
		$warning = array();

		if($this->editInit($pcid))
		{
			$myProduct = new Core_Product($pid);

			if($myProduct->id > 0 && $myProduct->pcid == $pcid && $col != '')
			{


				$formData['fpid'] = $myProduct->id;
				$formData['fcol'] = $col;

				$formData['fdata'] = $myProduct->$col;

				if(!empty($_POST['fsubmit']))
				{

					$formData = array_merge($formData, $_POST);
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product
							SET p_' . $formData['fcol'] .'=?
							WHERE p_id = ?';
					$stmt = $this->registry->db->query($sql, array(Helper::xss_clean($formData['fdata']), (int)$formData['fpid']));
					if($stmt){
                        $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
                        if(!empty($listregion))
                        {
                            foreach($listregion as $ritem)
                            {
                                $cachefile1 = 'sitehtml_productdetail'.$myProduct->id.'_'.$ritem->id;
                                $removeCache1 = new Cacher($cachefile1);
                                $removeCache1->clear();
                            }
                        }
                        $success[] = $this->registry->lang['controller']['succUpdate'];
                    }						
					else
						$error[] = $this->registry->lang['controller']['errUpdate'];
				}

				$head_list = str_replace(array('###PRODUCT_NAME###' , '###COLUMN_NAME###'), array($myProduct->name, $col), $this->registry->lang['controller']['head_lists']);


				$_SESSION['productEditToken'] = Helper::getSecurityToken();//Tao token moi

				$this->registry->smarty->assign(array(	'myProduct' => $myProduct,
														'head_list' => $head_list,
														'formData' => $formData,
														'success' 	=> $success,
														'error' 	=> $error,
														));
				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edittextarea.tpl');

				$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
														'contents' 	=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerContainer . 'edittextarea.tpl');
			}
			else
			{
				$error[] = $this->registry->lang['controller']['errProductId'];
			}
		}
	}

	public function editMediaAction()
	{

		$pid = (int)$this->registry->router->getArg('fpid');
		$pcid = (int)$this->registry->router->getArg('fpcid');
		$tab = ((int)$this->registry->router->getArg('tab') > 0) ? (int)$this->registry->router->getArg('tab') : 1;

		$error = array();
		$success = array();
		$warning = array();
		$formData = array();


		if($this->editInit($pcid))
		{
			$myProduct = new Core_Product($pid);
			if($myProduct->id > 0 && $myProduct->pcid == $pcid)
			{
				if(!empty($_POST['fsubmit']))
				{
					$ok = false;
					$formData = array_merge($formData, $_POST);

					//echodebug($formData,true);

					if($this->editActionValidator($formData, $error))
					{
						//cap nhat hinh dai dien va mau mac dinh cua san pham
						$newList = array();
                        $newList[] = (string)$formData['fdefaultcolor'];

                        $oldList = explode('###', $myProduct->colorlist);
                        for($i = 0 ; $i < count($oldList) ; $i++)
                        {
                            if($formData['fdefaultcolor'] != $oldList[$i])
                            {
                                $newList[] = $oldList[$i];
                            }
                        }

                        $myProduct->colorlist = implode('###', $newList);

						$stmt = $myProduct->updateData();
						if($stmt)
						{
							$ok =true;
							//update lai media
							if(count($formData['fmediaId']) > 0)
							{
								foreach($formData['fmediaId'] as $key=>$value)
								{
									$productMedia = new Core_ProductMedia($value);
									if($productMedia->id > 0)
									{
										$productMedia->caption = $formData['fcaptionmedia'][$value];
										$productMedia->alt = $formData['faltmedia'][$value];
                                        $productMedia->titleseo = $formData['ftitleseomedia'][$value];										
										$productMedia->mediaorder = -1;
										$productMedia->updateData();
									}
								}
							}


							if(count($formData['fmoreurlold']) > 0)
							{
								foreach ($formData['fmoreurlold'] as $key => $value)
								{
									$productMedia = new Core_ProductMedia($key);
									if($productMedia->id >0)
									{
										$productMedia->moreurl = $value;
										$productMedia->mediaorder = -1;
										$productMedia->updateData();
									}
								}
							}
																	
								
							
							//them moi media
							foreach($formData['furl'] as $key=>$value)
                            {
								$productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;                                
                                $productMedia->moreurl = $value;                                          
                                $productMedia->caption = $formData['fcaption'][$key];
                                $productMedia->alt = $formData['falt'][$key];
                                $productMedia->titleseo = $formData['ftitleseo'][$key];
                                $productMedia->mediaorder = -1;
                                $productMedia->type = Core_ProductMedia::TYPE_URL;
                                if(strlen($value) > 0)
                                {
                                	if($productMedia->addData() > 0)
	                                {
	                                    $ok = true;
	                                }  
                                }                              
                            }


							for($key = 0 ; $key < count($_FILES['ffile']['size']); $key++)
                            {
								$productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                if(strrpos($formData['fimageurl'][$key], '?'))
                                {
                                    $formData['fimageurl'][$key] = substr($formData['fimageurl'][$key], 0, strrpos($formData['fimageurl'][$key], '?'));
                                }                                
                                $productMedia->caption = Helper::codau2khongdau($myProduct->name,true,true) . $key;
                                $productMedia->alt = Helper::codau2khongdau($myProduct->name,true,true) . $key;
                                $productMedia->titleseo = Helper::codau2khongdau($myProduct->name,true,true);
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_FILE;
                                if($productMedia->moreurl != '' || strlen($_FILES['ffile']['name'][$productMedia->mediaorder]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }                                    
                                }
                            }
																			
													
							
							//
							/*if(isset($_FILES['ffile']))
							{
								//unset($_FILES['ffile']);
								$_FILES['ffile'] = $_FILES['ffile360'];
							}*/

							$_FILES['ffile'] = $_FILES['ffile360'];

							//them hinh 360
							for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
                            {
								$productMedia = new Core_ProductMedia();
                                $productMedia->pid = $myProduct->id;
                                $productMedia->uid = $this->registry->me->id;
                                $productMedia->caption = Helper::codau2khongdau($myProduct->name , true, true) . '-360-'. $key;
                                $productMedia->alt = Helper::codau2khongdau($myProduct->name , true, true) . '-360-'. $key;
                                $productMedia->titleseo = Helper::codau2khongdau($myProduct->name , true, true) . '-360-'. $key;
                                $productMedia->mediaorder = $key;
                                $productMedia->type = Core_ProductMedia::TYPE_360;
                                if(strlen($_FILES['ffile']['name'][$key]) > 0)
                                {
                                    if($productMedia->addData() > 0)
                                    {
                                        $ok = true;
                                    }                                    
                                }
                            }

							if($ok)
							{
								$success[] = $this->registry->lang['controller']['succUpdate'];
								$this->registry->me->writelog('product_edit', $myProduct->id, array());
							}
							else
							{
								$error[] = $this->registry->lang['controller']['errUpdate'];
							}
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}

				}


				$formData['ftab'] = $tab;
				$formData['fimage'] = ($myProduct->image != '') ? $myProduct->getSmallImage() : '';
				$formData['fcolorList'] = explode('###',$myProduct->colorlist);
				$formData['fpid'] = $pid;
				$formData['fpcid'] = $pcid;
				$productMediaList = Core_ProductMedia::getProductMedias(array('fpid' => $pid), 'displayorder' , 'ASC');
				//echodebug($productMediaList,true);
				 //get all customize product color
            	 $relProductColor = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$myProduct->id), 'id', 'ASC');

				//hien thi mau mac dinh
				$defaultColor =  new Core_Productcolor();

				for($i = 0 ; $i < count($formData['fcolorList']) ; $i++)
				{
					if(strtolower(trim($formData['fcolorList'][$i])) == 'no')
					{
						$defaultColor->getProductcolorByCode($formData['fcolorList'][$i]);
					}
				}



				$head_list = str_replace(array('###PRODUCT_NAME###'), array($myProduct->name), $this->registry->lang['controller']['head_list']);

				$this->registry->smarty->assign(array(	'productmediaList' => $productMediaList,
															'head_list_media' => $head_list,
															'formData' => $formData,
															'success' 	=> $success,
															'error' 	=> $error,
															'colorList' => Core_Productcolor::getProductcolors(array(), 'id', 'ASC'),
															'relProductColor' => $relProductColor,
															'defaultColor' => $defaultColor,
															'myProduct' => $myProduct,
															'mediaList'		=> Core_ProductMedia::getMediaType(),
															
															));
				$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'editmedia.tpl');

				$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
															'contents' 	=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerContainer . 'editmedia.tpl');
			}
		}
	}

	#####################################################
	#####################################################
	#####################################################
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;

		if(strlen($_FILES['fimage']['name']) > 0)
		{
			//kiem tra dinh dang hinh anh
			if(!in_array(strtoupper(end(explode('.', $_FILES['fimage']['name']))), $this->registry->setting['product']['imageValidType']))
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}

			//kiem tra kich thuoc file
			if($_FILES['fimage']['size'] > $this->registry->setting['product']['imageMaxFileSize'])
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}
		}

		for($key = 0 ; $key < count($_FILES['ffile']['size']) ; $key++)
        {
			if(strlen($_FILES['ffile']['name'][$key]) > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name'][$key]))), $this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFileMediaType'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile']['size'][$key] > $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }
            }
        }

		for($key = 0 ; $key < count($_FILES['ffile360']['size']) ; $key++)
        {
			if($_FILES['ffile360']['name'][$key] > 0)
            {
                if(!in_array(strtoupper(end(explode('.', $_FILES['ffile360']['name'][$key]))),$this->registry->setting['product']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFile360Type'];
                    $pass = false;
                }

                //kiem tra kich thuoc file
                if($_FILES['ffile360']['size'][$key] >  $this->registry->setting['product']['imageMaxFileSize'])
                {
                    $error[] = $this->registry->lang['controller']['errFileType'];
                    $pass = false;
                }

                //kiem tra xem hinh da ton tai hay chua
                $productmedias = Core_ProductMedia::getProductMedias(array('fpid' => $formData['fid'] , 'ftype' => Core_ProductMedia::TYPE_360) , 'id' , 'ASC');
                if(count($productmedias) > 0)
                {
                    $productmedia = $productmedias[0];
                    $path = explode('/', $productmedia->file);

                    $curDateDir = '';

                    for($i = 0 ; $i< count($path) - 1 ; $i++)
                    {
                        $curDateDir .= $path[$i] . '/';
                    }

                    if(file_exists($this->registry->setting['product']['imageDirectory'] . $curDateDir . $_FILES['ffile360']['name'][$key]))
                    {
                        $error = str_replace('###filename###', $_FILES['ffile360']['name'][$key] , $this->registry->lang['controller']['errFileExist']);
                        $pass = false;
                    }
                }
            }
        }

		return $pass;
	}
}
