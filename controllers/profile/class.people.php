<?php

Class Controller_Profile_People Extends Controller_Profile_Base 
{
        private $recordPerPage = 20;
        function indexAction() 
	{
		if(isset($_GET['avatareditor']))
		{
			$this->avatareditorAction();
			exit();	
		}
		
		$error = array();
		$success = array();
		$contents = '';
		$formData = array();
		$listuser = array();
		
               
		if($this->registry->me->id > 0)
		{
			
                     
                        $page        = $curPage = (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
                        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';  
			$MyUser      = new Core_User();
                        $total       = $MyUser->getUsers(array(), 'fid' , 'ASC', '' , true);
                        $limit       = ($page-1)*$this->recordPerPage.','.$this->recordPerPage;
                        $listuser    = $MyUser->getUsers(array('fgroupidlist'=>array('1','3','5')),'ffullname','ASC',$limit,false , true);
                        foreach ($listuser as $key => $value) {
                            $user               = new Core_User($value->id);
                            $value->imgavarta   = $user->getSmallImage();
                            $edge               = new Core_UserEdge();
                            $depart             = $edge->getUserEdges(array('fuidstart'=>$value->id), '' , '');
                            
                            if(!empty($depart))
                                $departDetail   = $MyUser->getUsers(array('fid'=>$depart[0]->uidend));
                            else
                                $departDetail[0]->fullname = 'Chưa cập nhật';
                            
                            $value->depart      = $departDetail[0]->fullname; 
                            
                            $region             = new Core_Region($value->region);
                            if($region->id!=0)
                                $value->regionname  = $region->name;
                        
                            else
                                $value->regionname  = '-';
                            
                            $value->lastdatef       = date('d/m/Y',$value->datelastlogin); 
                        }
                        
                        
                        $depament = Core_Department::getFullDepartments();
                        if(!isset($_SESSION['departmentss']))
                            $strop = $_SESSION['departmentss'] =  $this->getDepartment($depament);
                        else
                            $strop = $_SESSION['departmentss'];
                            
                            
                            
			$this->registry->smarty->assign(array(	
                                                                'formData' 	=> $formData,
                                                                'strop' 	=> $strop,
                                                                'user'		=> $this->registry->me,
                                                                'listuser'	=> $listuser,
                                                                'countuser'     => count($listuser),
                                                                'paginateurl' 	=> $paginateUrl, 
                                                                'totalPage'	=> ceil($total/$this->recordPerPage),
                                                                'department' 	=> $department,
                                                                'error' 	=> $error,
                                                                'success' 	=> $success,
                                                                'curPage'	=> $curPage,
												
                                                                ));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
			
			$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		}
		else
		{
			$this->notfound();
		}
		
	} 
        private function getDepartment($department , $parentid = '0' , $kitu = '&nbsp' ,$level = 1)
        {
           
            $str = '';
            
            if(!empty($department))
            {
                foreach ($department as $key => $value) {
                    
                    if($value->level == $level && $value->parentid == $parentid)
                    {
                     
//                        $str .='<option value="'.$value->id.'">'.$kitu.$value->fullname.'</option>';
//                        $rs = $this->getDepartment($department , $value->id , $kitu.$kitu , $level+1 );
//                        if($rs!='')
//                            $str .= $rs;
//                        else
//                            return $str;
                           
                       if(preg_match('/bp(.*?)/is', $value->fullname))
                       {
                           $id = $value->id;
                           $str .='<option value="'.$id.'">'.$kitu.$value->fullname.'</option>';
                       }
                       else
                       {
                           
                          $str .=  '<optgroup label="'.$value->fullname.'">';
                       }
                        $rs = $this->getDepartment($department , $value->id , $kitu.$kitu , $level+1);
                        if($rs!='')
                            $str .= $rs.'</optgroup>';
                        else
                            return $str;
                    }
                }
                
            }
            return $str;
        }

        public function indexajaxAction()
        {
            
            $contents = '';
            $action   = isset($_POST['action']) && $_POST['action']!='' ? $_POST['action'] : '' ;
            $ArrTran  = array();
            if($action!='')
            {
                switch ($action) {
                    case 'searchpeople':
                        /* kiểm tra ít nhất user có nhập vào 1 tiêu chí */
                        $flag     = false;
                        $formData = array();
                        $ArrTran['faccdmid']    = 'fid';
                        $ArrTran['fdepartment'] = 'fdepartment';
                        $ArrTran['faccddid']    = 'foauthUid';
                        $ArrTran['ffullname']   = 'ffullname';
                        $ArrTran['fphone']      = 'fphone';
                        $ArrTran['femail']      = 'femail';
                        
                        foreach ($_POST as $key=>$value) {
                            
                            if($value !='' && $key!='action' && $key!= 'page' )
                            {
                                
                                $flag = true;
                                $formData[$ArrTran[$key]] = $value;
                                
                            }
                                
                        }      
                        
                        /* có tồn tại tiêu chí */
                        if($flag)
                        {
                            $listuser                 = array();
                            $formData['fids']         = '';
                            $page                     = $curPage = (int)($_POST['page'])>0?(int)($_POST['page']):1;
                            $MyUser                   = new Core_User();
                            
                            $limit                    = ($page-1)*$this->recordPerPage.','.$this->recordPerPage;
                            $flagDepart               = false;
                            if(isset($formData['fdepartment']) && $formData['fdepartment']!='all')
                            {
                                
                                $userDepart = Core_UserEdge::getUserEdges(array('fuidend'=>$formData['fdepartment']), '' , '', $limit);
                                foreach ($userDepart as $k => $v) {
                                    $formData['fids'] .= $formData['fids'] == '' ? $v->uidstart : ','.$v->uidstart; 
                                }
                                if($formData['fids']!='')
                                    $flagDepart = true;
                            }
                            else
                            {
                                unset($formData['fids']);
                                $flagDepart = true;
                            }
                           
                            
                            $formData['fgroupidlist'] = array('1','3','5');
                            if($formData['fids']=='')
                                unset($formData['fids']);
                            
                            
                            if($flagDepart)
                            {
                                $total                    = $MyUser->getUsers($formData, 'ffullname' , 'ASC', $limit , true  , true); 
                                $listuser                 = $MyUser->getUsers($formData, 'ffullname' , 'ASC', $limit , false , true);
                                foreach ($listuser as $key => $value) {
                                    $user               = new Core_User($value->id);
                                    $value->imgavarta   = $user->getSmallImage();
                                    $edge               = new Core_UserEdge();
                                    $depart             = $edge->getUserEdges(array('fuidstart'=>$value->id), '' , '');

                                    if(!empty($depart))
                                        $departDetail   = $MyUser->getUsers(array('fid'=>$depart[0]->uidend));
                                    else
                                        $departDetail[0]->fullname = 'Chưa cập nhật';

                                    $value->depart      = $departDetail[0]->fullname; 

                                    $region             = new Core_Region($value->region);
                                    if($region->id!=0)
                                        $value->regionname  = $region->name;

                                    else
                                        $value->regionname  = 'Chưa cập nhật';

                                    $value->lastdatef       = date('d/m/Y',$value->datelastlogin); 
                                }
                                $this->registry->smarty->assign(array(	
                                                                'formData' 	=> $formData,
                                                                'user'		=> $this->registry->me,
                                                                'listuser'	=> $listuser,
                                                                'countuser'     => count($listuser),
                                                                'paginateurl' 	=> '#', 
                                                                'totalPage'	=> ceil($total/$this->recordPerPage),
                                                                'curPage'	=> $curPage,
                                                                'error' 	=> $error,
                                                                'success' 	=> $success,

                                                                ));
                            }
                            
                            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'searchindex.tpl'); 
                            echo $contents;
                        }
                        
                        break;

                    default:
                        break;
                }
            }

            
        }

	
	
	
}


