<?php

Class Core_Department extends Core_User
{
	
	/**
	 * Tra ve danh sach cac department (chinh la User record) tinh tu 1 nhanh nao do, default la lay tat ca
	 */
	public static function getFullDepartments($parentId = '0', $level = 0, $prefix='')
	{
		global $db, $registry;
		$output = array();
		
		$sql = 'SELECT * 
				FROM ' . TABLE_PREFIX . 'ac_user u
				WHERE u_groupid = ? AND u_parentid = ?
				ORDER BY u_screenname';
		$departmentList = $db->query($sql, array(GROUPID_DEPARTMENT, $parentId))->fetchAll();
		$level++; 
		foreach($departmentList as $department)
		{
			$prefixTemp = $prefix . ' &raquo; ' . $department['u_fullname'];
			$myDepartment = new Core_Department();
            
			$myDepartment->level = $level;
			$myDepartment->id = $department['u_id'];
			$myDepartment->parentid = $department['u_parentid'];
			$myDepartment->fullname = $department['u_fullname'];
			$myDepartment->title = $prefixTemp;
			$output[] = $myDepartment;
			$output = array_merge($output, self::getFullDepartments($department['u_id'], $level, $prefixTemp ));
		}
		return $output;
	}
	
	public static function getFullParentDepartments($departmentId)
	{
		global $db, $registry;
		
		$myDepartment = new Core_Department($departmentId);
		$output = array();
		
		$sql = 'SELECT * 
				FROM ' . TABLE_PREFIX . 'ac_user u
				WHERE u_groupid = ? AND u_id = ?
				LIMIT 1';
				
		$departmentList = $db->query($sql, array(GROUPID_DEPARTMENT, $myDepartment->parentid))->fetchAll();

		foreach($departmentList as $department)
		{
			$output[] = $department;
			$output = array_merge($output, self::getFullParentDepartments($department['u_id']));
		}
		
		return $output;
	}
	
	public static function getFullDepartmentsList($parentId = '0', $level = 0)
	{
		global $db, $registry;
		$output = '';
		
		$sql = 'SELECT * 
				FROM ' . TABLE_PREFIX . 'ac_user u
				WHERE u_groupid = ? AND u_parentid = ?
				ORDER BY u_screenname';
		$departmentList = $db->query($sql, array(GROUPID_DEPARTMENT, $parentId))->fetchAll();
		$level++; 
		foreach($departmentList as $department)
		{
			//tim so nhan vien cua department nay
			$countemployee = Core_UserEdge::getUserEdges(array('fuidend' => $department['u_id'], 'ftype' => Core_UserEdge::TYPE_EMPLOY), '', '', '', true);
			
			$children = self::getFullDepartmentsList($department['u_id'], $level);
			
			//only show add employee button on leaf department
			$addlink = '<a class="btn btn-small btn-info" href="'.$registry['conf']['rooturl_erp'].'hrmdepartment/employeeadd/departmentid/'.$department['u_id'].'" rel="shadowbox;width=800;height=400"><i class="icon-plus"></i> '.$registry->lang['controller']['addEmployee'].'</a>';
				
			$output .= '<li id="department'.$department['u_id'].'"><span class="listtext level'.$level.'"><a style="color:#000" href="'.$registry['conf']['rooturl_erp'].'hrmdepartment/employeelist/departmentid/'.$department['u_id'].'" rel="shadowbox;width=960;height=600">' . $department['u_fullname'].' ('.$countemployee.') </a></span>';
			
			
			if($children != '')
				$output .= '<ul>'.$children.'</ul>';
			
			$output .= '</li>';
		}
		return $output;
	}

	public static function getFullDepartmentsListOLD($parentId = '0', $level = 0)
	{
		global $db, $registry;
		$output = '';
		
		$sql = 'SELECT * 
				FROM ' . TABLE_PREFIX . 'ac_user u
				WHERE u_groupid = ? AND u_parentid = ?
				ORDER BY u_screenname';
		$departmentList = $db->query($sql, array(GROUPID_DEPARTMENT, $parentId))->fetchAll();
		$level++; 
		foreach($departmentList as $department)
		{
			//tim so nhan vien cua department nay
			$countemployee = Core_UserEdge::getUserEdges(array('fuidend' => $department['u_id'], 'ftype' => Core_UserEdge::TYPE_EMPLOY), '', '', '', true);
			
			$children = self::getFullDepartmentsList($department['u_id'], $level);
			
			//only show add employee button on leaf department
			$addlink = '<a class="btn btn-small btn-info" href="'.$registry['conf']['rooturl_erp'].'hrmdepartment/employeeadd/departmentid/'.$department['u_id'].'" rel="shadowbox;width=800;height=400"><i class="icon-plus"></i> '.$registry->lang['controller']['addEmployee'].'</a>';
				
			$output .= '<li id="department'.$department['u_id'].'"><span class="listtext level'.$level.'">' . $department['u_fullname'].'<span class="button pull-right btn-group">'.$addlink.'<a href="'.$registry['conf']['rooturl_erp'].'hrmdepartment/employeelist/departmentid/'.$department['u_id'].'" class="btn btn-small" title="" rel="shadowbox;width=960;height=600"><i class="icon-user"></i> '.$countemployee.'</a></span></span>';
			
			
			if($children != '')
				$output .= '<ul>'.$children.'</ul>';
			
			$output .= '</li>';
		}
		return $output;
	}
	
}


