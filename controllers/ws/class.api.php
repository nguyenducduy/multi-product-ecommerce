<?php

Class Controller_Ws_Api Extends Controller_Ws_Base
{
    
    function indexAction()
    {
		//get latest account
		$groupList = Core_ApidocGroup::getApidocGroups(array('fenable' => 1), 'displayorder', 'ASC', '');
		
		///////
		//get request
		for($i = 0; $i < count($groupList); $i++)
		{
			$requestList = Core_ApidocRequest::getApidocRequests(array('fagid' => $groupList[$i]->id, 'fenable' => 1), 'displayorder', 'ASC', '');
			for($j = 0; $j < count($requestList); $j++)
			{
				$requestList[$j]->paramList = Core_ApidocRequestParameter::getApidocRequestParameters(array('farid' => $requestList[$j]->id), 'displayorder', 'ASC', '');
				$requestList[$j]->responseList = Core_ApidocRequestResponse::getApidocRequestResponses(array('farid' => $requestList[$j]->id), 'displayorder', 'ASC', '');
			}
			
			$groupList[$i]->requestList = $requestList;
		}
		
		$this->registry->smarty->assign(array(	'groupList' 	=> $groupList,
												));
		
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
    }
}

