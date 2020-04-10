<?php 
	Class Controller_Cms_EventUserHours Extends Controller_Cms_Base{
		public $recordPerPage = 100;
		public function indexAction()
		{
			$error 			= array();
	        $success 		= array();
	        $warning 		= array();
	        $formData 		= array('fbulkid' => array());
	        $_SESSION['securityToken']=Helper::getSecurityToken();//Token
          	$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
          	$epid 			= (int)($this->registry->router->getArg('id'));
          	//GET ARG
      		$search		= (string)($this->registry->router->getArg('search'));
          	$keywordFilter 		= (string)($this->registry->router->getArg('keyword'));
      	  	$searchKeywordIn 		= (string)($this->registry->router->getArg('searchin'));
          	$fphone			= (string)($this->registry->router->getArg('phone'));
        
          	//END GET ARG
	        $sortby 	= $this->registry->router->getArg('sortby');
	        if($sortby == '') $sortby = 'position';
	        	$formData['sortby'] = $sortby;
	        $sorttype 	= $this->registry->router->getArg('sorttype');
	        if(strtoupper($sorttype) != 'DESC') 
	        	$sorttype = 'ASC';
	        $formData['sorttype'] = $sorttype;

	        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';
	        //////
	        if($search != "")
	        {
		        if($keywordFilter != "")
		        {

		        	$paginateUrl .= 'keyword/' . $keywordFilter . '/';
		        	$formData['fkeywordFilter'] = $keywordFilter;
		        	 if($searchKeywordIn == 'fullname')
		            {
		                $paginateUrl .= 'searchin/name/';
		            }
		            elseif($searchKeywordIn == 'email')
		            {
		                $paginateUrl .= 'searchin/email/';
		            }
		            $formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
		            $formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
		            $formData['search'] = 'keyword';
		           
		        }
		        if($fphone  != "")
		        {
		            $paginateUrl .= 'phone/'.$fphone . '/';
		            $formData['fphone'] = $fphone;
		        }
		    }
	        //////
	        $formDataRel['fepid'] = $epid;
	       	$relProductEventUserList = Core_RelProductEventUser::getRelProductEventUsers($formDataRel,$sortby,$sorttype,(($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
	        $total = Core_RelProductEventUser::getRelProductEventUsers($formDataRel, $sortby, $sorttype,'', true);
        	$totalPage = ceil($total/$this->recordPerPage);
        	$curPage = $page;
        	$filterUrl = $paginateUrl;
        	///////////////////////////////////////////////////////////////////////////////////
	        $userList = array();
	        foreach ($relProductEventUserList as $k => $relProductEventUser) {
				$userList[$k+1] = $relProductEventUser->euid;
	        }
	        $userListID = $userList;
	        if(!empty($userListID))
	        {
        		foreach ($userListID as $key => $userID) {
        			$formData['fid'] = $userID;
        			$eventUserHoursList[$key] = Core_EventUserHours::getEventUserHourss($formData, $sortby, $sorttype);
        		}
        		
        	}
        	///////////////////////////////////////////////////////////////////////////////////////
	        $this->registry->smarty->assign(array(	         
	            'formData'		=> $formData,
	            'success'		=> $success,
	            'error'			=> $error,
	            'warning'		=> $warning,
	            'paginateurl' 	=> $paginateUrl,
	            'filterUrl'		=> $filterUrl,
	            'total'			=> $total,
	            'totalPage' 	=> $totalPage,
	            'curPage'		=> $curPage,
	            'formDataRel'	=> $formDataRel,
	            'eventUserHoursList'=>$eventUserHoursList
												
			));
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
		}
	}
?>
