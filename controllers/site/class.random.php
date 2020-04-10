<?php

Class Controller_Site_Random Extends Controller_Site_Base
{
	public function indexAction()
	{
		if(!isset($_SESSION['quaysocode']))
			$_SESSION['quaysocode'] = array('0000000');
			
		$winner = array();
		if(isset($_POST['fsubmit']))
		{
			$quaysocodeTmp = array();
			foreach($_SESSION['quaysocode'] as $code)
			{
				$quaysocodeTmp[] = '"'.$code.'"';
			}
			
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code NOT IN ('.implode(',', $quaysocodeTmp).')
					ORDER BY RAND()
					LIMIT 1';
			$winner = $this->registry->db->query($sql)->fetch();
			if($winner['lc_id'] > 0)
			{
				$winner['memberinfo'] = new Core_LotteMember($winner['lm_id']);
				$winner['memberinfo']->regionname = $this->getRegionName($winner['memberinfo']->region);
				
				if($winner['memberinfo']->referermemberid > 0)
				{
					$winner['referer'] = new Core_LotteMember($winner['memberinfo']->referermemberid);
					$winner['referer']->regionname = $this->getRegionName($winner['referer']->region);
				}
				
				$_SESSION['quaysocode'][] = $winner['lc_code'];
				$_SESSION['quaysoHistory'][] = $winner;
			}
		}
		
		
		

		
		$this->registry->smarty->assign(array(	'historyList' => $_SESSION['quaysoHistory'],
												'winner' => $winner,
												//'hideMenu' => 1
                                                    ));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(
											'contents' => $contents,
                                            'pageTitle'                 => 'Random'));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}
	
	
	public function khuyenkhichAction()
	{
		set_time_limit(0);
		
		if(!empty($_POST['fsubmit']))
		{
			if(isset($_GET['code']))
				$randomcode = $_GET['code'];
			elseif(isset($_SESSION['quaysokhuyenkhichcode']))
				$randomcode = $_SESSION['quaysokhuyenkhichcode'];
			else
			{
				$randomnumber = rand(1, 99999);
				$randomcode = '10' . sprintf('%05d', $randomnumber);
				$_SESSION['quaysokhuyenkhichcode'] = $randomcode;
			}
			
			///////
			//tien hanh tim danh sach
			$winnerTotal = 819;
			$winners = array();
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 7 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code = "'.$randomcode.'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]))
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 6 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -6).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]))
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 5 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -5).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 4 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -4).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 3 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -3).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 2 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -2).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 1 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -1).'"
					ORDER BY lc_id ASC
					LIMIT 1000'; 
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			
			/////////////////////////
			////////////////////////
			$winnerDetailList = array();
			foreach($winners as $lcid => $lottecode)
			{
				$lottecode['memberinfo'] = new Core_LotteMember($lottecode['lm_id']);
				$lottecode['memberinfo']->regionname = $this->getRegionName($lottecode['memberinfo']->region);
				$winnerDetailList[] = $lottecode;
			}
			
		}
		
		
	
		
		

		
		$this->registry->smarty->assign(array(	'historyList' => $_SESSION['quaysoHistory'],
												'randomcode' => $randomcode,
												//'hideMenu' => 1,
												'winnerDetailList' => $winnerDetailList,
                                                    ));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'khuyenkhich.tpl');

		$this->registry->smarty->assign(array(
											'contents' => $contents,
                                            'pageTitle'                 => 'Random'));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}
	
	public function remainAction()
	{
		set_time_limit(0);
		
		if(!empty($_POST['fsubmit']))
		{
			if(isset($_GET['code']))
				$randomcode = $_GET['code'];
			elseif(isset($_SESSION['quaysokhuyenkhichcode_remain']))
				$randomcode = $_SESSION['quaysokhuyenkhichcode_remain'];
			else
			{
				$randomnumber = rand(1, 99999);
				$randomcode = '10' . sprintf('%05d', $randomnumber);
				$_SESSION['quaysokhuyenkhichcode_remain'] = $randomcode;
			}
			
			///////
			//tien hanh tim danh sach
			$winnerTotal = $_POST['total'];
			$winners = array();
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 7 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code = "'.$randomcode.'"
					ORDER BY lm_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]))
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 6 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -6).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]))
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 5 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -5).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 4 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -4).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 3 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -3).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 2 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -2).'"
					ORDER BY lc_id ASC
					LIMIT 1000';
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			////////////////////////////////////////
			////////////////////////////////////////
			// Tim ticket co trung 1 chu so
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_code
					WHERE lc_code LIKE "%'.substr($randomcode, -1).'"
					ORDER BY lc_id ASC
					LIMIT 1000'; 
			$stmt = $this->registry->db->query($sql);
			while($row = $stmt->fetch())
			{
				if(!isset($winners[$row['lm_id']]) && $winnerTotal > 0)
				{
					$winners[$row['lm_id']] = $row;
					$winnerTotal--;
				}	
			}
			
			
			/////////////////////////
			////////////////////////
			$winnerDetailList = array();
			foreach($winners as $lcid => $lottecode)
			{
				$lottecode['memberinfo'] = new Core_LotteMember($lottecode['lm_id']);
				$lottecode['memberinfo']->regionname = $this->getRegionName($lottecode['memberinfo']->region);
				$winnerDetailList[] = $lottecode;
			}
			
		}
		
		
		
		$this->registry->smarty->assign(array(	'randomcode' => $randomcode,
												//'hideMenu' => 1,
												'winnerDetailList' => $winnerDetailList,
                                                    ));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'khuyenkhich_remain.tpl');

		$this->registry->smarty->assign(array(
											'contents' => $contents,
                                            'pageTitle'                 => 'Random'));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}

	public function getRegionName($regionid)
	{
		global $setting;
		
		if($regionid > 0)
			return $setting['region'][$regionid];
		else
			return '';
	}
}

