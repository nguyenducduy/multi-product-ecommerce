<?php

Class Controller_Profile_UserInfo Extends Controller_Profile_Base 
{
	
		
	/**
	* Boi vi co su dung co che cache html
	* nen phan top menu (link danh cho user neu co dang nhap) 
	* phai dung ajax de load
	* 
	*/
	function indexAction()
	{
		header ("content-type: text/xml");
		if($this->registry->me->id > 0)
		{
			
			//lay tat ca group ma user nay tao
			$createdGroupList = Core_User::getUsers(array('fparentid' => $this->registry->me->id, 'fgroupid' => GROUPID_GROUP), '', '', '');
			
			//lay tat ca group ma user nay follow
			$userEdgeList = Core_UserEdge::getUserEdges(array('fuidstart' => $this->registry->me->id, 'ftype' => Core_UserEdge::TYPE_JOIN), 'datemodified', 'DESC', 10);
			
			
			$followGroupList = array();
			for($i = 0; $i < count($userEdgeList);$i++)
			{
				$followGroupList[$userEdgeList[$i]->uidend] = new Core_User($userEdgeList[$i]->uidend, true);
			}
			
			for($i = 0; $i < count($createdGroupList); $i++)
			{
				if(!isset($followGroupList[$createdGroupList[$i]->id]))
					$followGroupList[$createdGroupList[$i]->id] = $createdGroupList[$i];
			}
			
			$this->registry->smarty->assign(array('followGroupList' => $followGroupList,

												));
			
			
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl'); 
		}
		else
		{
			echo '<?xml version="1.0" encoding="utf-8"?><result></result>';
		}
	}
}

