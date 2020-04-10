<?php
ini_set ( 'memory_limit', '1024M' );
class Controller_Cron_Systemuser extends Controller_Cron_Base
{
	private $recordperpage = 100;

	/** get user - department */
	public function indexAction()
	{

	/*	$action = 'syncuser';
		if(isset($_GET['action']))
			$action = $_GET['action'];*/


		$order = new Core_OrderArchive();
		$this->GetupdateUser($order);
		$this->GetupdateDepartment($order);
	}

	/** get department insert to systemdepartment*/
	private function GetupdateDepartment($order)
	{
		$OracleCount = 'SELECT COUNT(*) FROM ERP.VW_SYSTEM_DEPARTMENT ';

		$total = $order->query($OracleCount);
		$totalpage = ceil((int)$total[0]['COUNT(*)']/(int)$this->recordperpage);
		for($i = 1 ;$i <= $totalpage ; $i++)
		{
			$OracleSelect = 'SELECT * FROM
								(
									SELECT
										rownum rnum,
										a.*
									FROM
										ERP.VW_SYSTEM_DEPARTMENT a
									WHERE
											 rownum <='.($i*$this->recordperpage).'
								 )
								 WHERE
									rnum >='.$this->recordperpage*($i - 1).'
								 ';
			$rs = $order->query($OracleSelect);
			$this->insertDepartmentMysql($rs);
		}

		echodebug('Da dong bo thanh cong : '.$total[0]['COUNT(*)']." record");
		$this->GetupdateUser($order);
	}

	private function insertDepartmentMysql($rs)
	{
		foreach ( $rs as $key=>$value )
		{
			$systemdepartment                 = new Core_TgddSystemDepartment();
			$count                            = $systemdepartment::getTgddSystemDepartments(array ( 'fDEPARTMENTID' => $value['DEPARTMENTID'] ) , '' , '' , '' , true);
			$systemdepartment->DEPARTMENTID   = $value['DEPARTMENTID'];
			$systemdepartment->DEPARTMENTNAME = $value['DEPARTMENTNAME'];
			$systemdepartment->DECRIPTION     = $value['DECRIPTION'];
			$systemdepartment->PHONENUMBER    = $value['PHONENUMBER'];
			$systemdepartment->HEADERUSER     = $value['HEADERUSER'];
			$systemdepartment->PARENTID       = $value['PARENTID'];
			$systemdepartment->NODETREE       = $value['NODETREE'];
			$systemdepartment->ISDELETE       = $value['ISDELETE'];
			$systemdepartment->USERDELETE     = $value['USERDELETE'];
			$systemdepartment->DATEDELETE     = $value['DATEDELETE'];
			$systemdepartment->VIEWINDEX      = $value['VIEWINDEX '];
			$systemdepartment->DEPARTMENTCODE = $value['DEPARTMENTCODE'];
			if($count==0)
			{

				$systemdepartment->addData();
			}
			else
			{
				$systemdepartment->updateData();
			}
		}
	}

	/** get department insert to systemuser*/
	private function GetupdateUser($order)
	{
		$OracleCount = 'SELECT COUNT(*) FROM ERP.VW_SYSTEM_USER ';

		$total = $order->query($OracleCount);
		$totalpage = ceil((int)$total[0]['COUNT(*)']/(int)$this->recordperpage);
		for($i = 1 ;$i <= $totalpage ; $i++)
		{
			$OracleSelect = 'SELECT * FROM
								(
									SELECT
										rownum rnum,
										a.*
									FROM
										ERP.VW_SYSTEM_USER a
									WHERE
											 rownum <='.($i*$this->recordperpage).'
								 )
								 WHERE
									rnum >='.$this->recordperpage*($i - 1).'
								 ';
			$rs = $order->query($OracleSelect);
			$this->insertUserMysql($rs);
		}

		echodebug('Da dong bo thanh cong : '.$total[0]['COUNT(*)']." record");
//		$this->syncAction();
		$this->deletedepartmentAction();
	}

	private function insertUserMysql($rs)
	{

		foreach ( $rs as $key=>$value )
		{
			$systemuser                      = new Core_TgddSystemUser();
			$count = $systemuser::getTgddSystemUsers(array('fUSERNAME'=>$value['USERNAME']),'','','',true);
			$systemuser->USERNAME            = $value['USERNAME'];
			$systemuser->FULLNAME            = $value['FULLNAME'];
			$systemuser->FIRSTNAME           = $value['FIRSTNAME'];
			$systemuser->LASTNAME            = $value['LASTNAME'];
			$systemuser->GENDER              = $value['GENDER'];
			$systemuser->BIRTHDAY            = $value['BIRTHDAY'];
			$systemuser->EMAIL               = $value['EMAIL'];
			$systemuser->PHONENUMBER         = $value['PHONENUMBER'];
			$systemuser->MOBI                = $value['MOBI'];
			$systemuser->ADDRESS             = $value['ADDRESS'];
			$systemuser->DESCRIPTION         = $value['DESCRIPTION'];
			$systemuser->REVIEWLEVELID       = $value['REVIEWLEVELID'];
			$systemuser->POSITIONID          = $value['POSITIONID'];
			$systemuser->AREAID              = $value['AREAID'];
			$systemuser->ISACTIVED           = $value['ISACTIVED'];
			$systemuser->ISDELETE            = $value['ISDELETE'];
			$systemuser->USERDELETE          = $value['USERDELETE'];
			$systemuser->DATEDELETE          = $value['DATEDELETE'];
			$systemuser->USERID              = $value['USERID'];
			$systemuser->IMAGEPATH           = $value['IMAGEPATH'];
			$systemuser->ISMD5               = $value['ISMD5'];
			$systemuser->CREATEDUSER         = $value['CREATEDUSER'];
			$systemuser->CREATEDDATE         = $value['CREATEDDATE'];
			$systemuser->UPDATEDUSER         = $value['UPDATEDUSER'];
			$systemuser->FULLNAMEEN          = $value['FULLNAMEEN'];
			$systemuser->ISREQUIREPWDCHAGING = $value['ISREQUIREPWDCHAGING'];
			$systemuser->ISLOCKED            = $value['ISLOCKED'];
			$systemuser->LOCKEDTIME          = $value['LOCKEDTIME'];
			$systemuser->STARTDATEWORK       = $value['STARTDATEWORK'];
			$systemuser->SHIFTID             = $value['SHIFTID'];
			$systemuser->STOREID             = $value['STOREID'];
			$systemuser->DEPARTMENTID        = $value['DEPARTMENTID'];
			$systemuser->POSITIONNAME        = $value['POSITIONNAME'];
			if($count==0)
			{

				$systemuser->addData();
			}
			else
			{
				$systemuser->updateData();
			}

		}

	}






	/*=====================================department====================================================*/


	/** sync department cron chay moi ngay*/
	public function syncAction()
	{

		$sql = "SELECT  * FROM  tgdd_system_department ";
		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{
			$countuser = Core_User::getUsers(array('fpersonalid'=>$row['DEPARTMENTID']),'','','');

			//ton tai
			if(!empty($countuser) && $row['ISDELETE'] == 0)
			{

				$user                  = new Core_User($countuser[0]->id);
				$arruser['screenname'] = str_replace(" " , "-" , Helper::codau2khongdau($row['DEPARTMENTNAME'] , true , true));
				$arruser['fullname']   = $row['DEPARTMENTNAME'];
				$arruser['parentid']   = $row['PARENTID'];
				$user->personalid	   = $row['DEPARTMENTID'];
				$arruser['groupid']    = 15;

				// chua xoa
				if($row['ISDELETE']==0)
					$user->updateData($arruser);
				else
					$user->delete();
			}
			else
			{
				// chua xoa
				if($row['ISDELETE']==0)
				{
					$user             = new Core_User();
					$user->personalid = $row['DEPARTMENTID'];
					$user->screenname = str_replace(" ","-",Helper::codau2khongdau($row['DEPARTMENTNAME'],true,true));
					$user->fullname   = $row['DEPARTMENTNAME'];
					$user->parentid   = $row['PARENTID'];
					$user->groupid    = 15;
					$user->addData();
				}


			}

		}
		$this->updateparentidAction();
	}

	/** xoa department cu */
	public function deletedepartmentAction()
	{
		$user = Core_User::getUsers(array(),'','','');
		foreach ( $user as $k=>$v ) {
			if($v->groupid == GROUPID_DEPARTMENT)
			{
				$deluser = new Core_User($v->id);
				$deluser->delete();
			}
		}
		$this->syncdepartmentnewAction();
	}

	/** sync department moi */
	public function syncdepartmentnewAction()
	{
		$sql = "SELECT  * FROM  tgdd_system_department WHERE ISDELETE=0";
		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{

				$user             = new Core_User();
				$user->personalid = $row['DEPARTMENTID'];
				$user->screenname = str_replace(" ","-",Helper::codau2khongdau($row['DEPARTMENTNAME'],true,true));
				$user->fullname   = $row['DEPARTMENTNAME'];
				$user->groupid    = 15;
				$user->addData();

		}
		$this->updateparentidAction();
	}

	/** update parentid */
	public  function updateparentidAction()
	{
		$sql = "SELECT  * FROM  tgdd_system_department WHERE ISDELETE=0";

		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{
			if($row['PARENTID']!=0)
			{
				$myDepartment = Core_User::getUsers(array('fpersonalid'=>$row['DEPARTMENTID']),'','','');
				$user  =  new Core_User($myDepartment[0]->id);
				$parentDepartment = Core_User::getUsers(array('fpersonalid'=>$row['PARENTID']),'','','');
				$arr['parentid'] = $parentDepartment[0]->id;
				$user->updateData($arr);
			}
		}
		$this->synchrmAction();
	}



	/*=======================================user======================================================*/

	/** sync ten chuc vu */
	public function synchrmAction()
	{
		$arr = array();
		$sql = "SELECT  * FROM  tgdd_system_user";
		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{
			$arr[$row['POSITIONID']] = $row['POSITIONNAME'];
		}

		foreach ( $arr as $k=>$v ) {
			$hrm = new Core_HrmTitle($k);
			if(!empty($hrm))
			{
				$hrm->id         = $k;
				$hrm->name       = $v;
				$hrm->isofficial = 1;
				$hrm->updateData();
			}
			else
			{
				$hrm->id = $k;
				$hrm->name = $v;
				$hrm->isofficial = 1;
				$hrm->addidData();
			}


		}
		$this->syncuserAction();
	}

	/**  sync user */
	public function syncuserAction()
	{
		$sql = "SELECT  * FROM  tgdd_system_user WHERE  ISDELETE=0";
		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{

			$countuser = Core_User::getUsers(array('foauthUid'=>$row['USERNAME']),'','','');
			if(empty($countuser) && $countuser[0]->id==0)
				$countuser = Core_User::getUsers(array('femail'=>$row['EMAIL']),'','','');





			if(empty($countuser))
			{
				if($row['ISACTIVED']==1)
				{
					$user           = new Core_User();
					$user->oauthUid = $user->oauthUid != '' ? $user->oauthUid : $row['USERNAME'];
					$user->fullname = $user->fullname != '' ? $user->fullname : $row['FULLNAME'];
					$user->gender   = $user->gender   != '' ? $user->gender : $row['GENDER'];
					$user->birthday = $user->birthday != '' ? $user->birthday : $row['BIRTHDAY'];
					$user->email    = $user->email 	  != '' ? $user->email : $row['EMAIL'];
					$user->phone    = $user->phone    != '' ? $user->phone : $row['MOBI'];
					$user->address  = $user->address  != '' ? $user->address : $row['ADDRESS'];
					$user->groupid  = $user->groupid  == GROUPID_DEVELOPER || $user->groupid == GROUPID_ADMIN ? $user->groupid : GROUPID_EMPLOYEE;
					//$user->avatar   = $user->avatar != '' ? $user->avatar : 'https://insite.thegioididong.com/Images/UserImages/'.$row['IMAGEPATH']  ;

					$user->addData();
				}

			}
			else
			{
				$get     			   = $countuser;
				if(!empty($get))
				{
					$user                  = new Core_User($get[0]->id);

					$arruser['fullname'] = $user->fullname != '' ? $user->fullname : $row['FULLNAME'];
					$arruser['gender']   = $user->gender != '' ? $user->gender : $row['GENDER'];


					$user->oauthUid = $user->oauthUid != '0' ? $user->oauthUid : $row['USERNAME'];
					$user->birthday = $user->birthday != '0000-00-00' ? $user->birthday : $row['BIRTHDAY'];
					$user->email    = $user->email != '' ? $user->email : $row['EMAIL'];
					$user->phone    = $user->phone != '' ? $user->phone : $row['MOBI'];
					$user->address  = $user->address != '' ? $user->address : $row['ADDRESS'];
					//	$user->avatar   = $user->avatar != '' ? $user->avatar : 'https://insite.thegioididong.com/Images/UserImages/'.$row['IMAGEPATH']  ;
					if($row['ISACTIVED']==1)
					{
						$arruser['groupid']  = $user->groupid == GROUPID_DEVELOPER || $user->groupid == GROUPID_ADMIN ? $user->groupid : GROUPID_EMPLOYEE;
						$user->updateData($arruser);
					}
					else
					{
						$arruser['groupid']  = GROUPID_MEMBER;
						$user->updateData($arruser);
					}

				}

			}
		}
		$this->syncdepartmentforuserAction();
	}

	/** sync department moi cho user */
	public function syncdepartmentforuserAction()
	{
		$user = Core_User::getUsers(array(),'','','');
		foreach ( $user as $k=>$v ) {
			if($v->groupid == GROUPID_EMPLOYEE || $v->groupid == GROUPID_DEVELOPER || $v->groupid == GROUPID_ADMIN )
			{
				// tao doi tuong user
				$myuser                = new Core_User($v->id);
				if($myuser->parentid!=0)
				{
					// get department
					$deparment             = Core_User::getUsers(array ( 'fpersonalid' => $myuser->parentid ) , '' , '' , '');
					$arrupdate['parentid'] = $deparment[0]->id;
					$myuser->updateData($arrupdate);
				}


			}
		}
		$this->syncuseredgeAction();
	}



	/** sync ten phong ban*/
	public function syncuseredgeAction()
	{
		$arr = array();
		// get system user
		$sql = "SELECT  * FROM  tgdd_system_user where ISACTIVED = 1";
		$tmp = $this->registry->db->query($sql);
		while($row = $tmp->fetch())
		{
			$arr[$row['USERNAME']][] = $row['DEPARTMENTID'];
			$arr[$row['USERNAME']][] = $row['POSITIONID'];
		}





		$user = Core_User::getUsers(array(),'','','');
		foreach ( $user as $k=>$v ) {
			if($v->groupid == GROUPID_EMPLOYEE ||$v->groupid == GROUPID_DEVELOPER ||$v->groupid == GROUPID_ADMIN)
			{
				$edge 	   = Core_UserEdge::getUserEdges(array('fuidstart'=>$v->id,'ftype'=>Core_UserEdge::TYPE_EMPLOY ),'','','');
				if(!empty($edge))
				{
					foreach ( $edge as $key => $value ) {
						$EgdeDel  = new Core_UserEdge($value->id);
						$EgdeDel->delete();
					}

				}
				if(isset($arr[$v->oauthUid][1]))
				{
					// tao doi tuong
					$myedge           = new Core_UserEdge();

					// lay department
					$myuser   		  = Core_User::getUsers(array('fpersonalid' => $arr[$v->oauthUid][0]),'','','');

					$myedge->uidstart = $v->id;
					$myedge->uidend   = $myuser[0]->id;
					$myedge->type     = Core_UserEdge::TYPE_EMPLOY;
					$myedge->point    = $arr[$v->oauthUid][1];
					$myedge->addData();
				}
			}

		}
	}

}