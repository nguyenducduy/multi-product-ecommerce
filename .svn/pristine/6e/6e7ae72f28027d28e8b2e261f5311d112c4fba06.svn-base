<?php

Class Controller_Stat_System Extends Controller_Stat_Base
{
	public function indexAction()
	{
		$this->registry->smarty->assign(array('formData' => $formData,
												'error'	=> $error,	
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'system',
												'pageTitle'	=> 'Statistics :: System',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			
		
	}
	
	
	public function sqlmonitorAction()
	{
		//Get keylist
		$keylistData = apc_fetch('SQLLOG_TOTAL_KEY');
		if(!empty($keylistData))
		{
			$keyList = explode(',', $keylistData);
			if(count($keyList) > 0)
			{
				$data = array();
				foreach($keyList as $key)
				{
					$data[$key] = (int)apc_fetch($key);
				}
				
				if($_GET['sortby'] == 'key')
					ksort($data);
				else
					arsort($data);
				
				$sum = array_sum($data);
				
				/////////////
				//Output
				echo '<table border="1" cellpadding="5" style="border-collapse:collapse;font-family:Courier New;">
					<tr style="background:#000; color:#fff;"><td colspan="2">Total Query Stats('.$sum.')</td></tr>
					<tr style="background:#f0f0f0;"><td><a href="?sortby=key">Key</a></td><td><a href="?sortby=number">Number of query</a></td></tr>';
				foreach($data as $k => $v)
				{
					echo '<tr>
						<td>'.$k.'</td>
						<td>'.$v.'</td>
					</tr>';
				}
				echo '</table>';
			}
			else
				die('Keylist not valid.');
		}
		else
		{
			die('SQLLOG_TOTAL_KEY is empty.');
		}
	}
	
	public function apcAction()
	{
		$this->registry->smarty->assign(array(
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'apc.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'apc',
												'pageTitle'	=> 'Monitor :: APC Cache',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			
		
	}

	public function recommendationmonitorAction()
	{

		$recommendationStatus = array();

		$keyList = array('s2', 's3', 's4','s5');
		foreach($keyList as $key)
		{
			$myCacher = new Cacher('recommendation:monitor:' . $key, Cacher::STORAGE_REDIS, 30 * 24 * 3600);	
			$monitorData = $myCacher->get();


			$monitorDataDetail                  = explode('#' , $monitorData);
			$algorithmInfo                      = array ();
			$algorithmInfo['numberuser']        = (int)$monitorDataDetail[0];
			$algorithmInfo['numberitem']        = (int)$monitorDataDetail[1];
			$algorithmInfo['timestart']         = (int)$monitorDataDetail[2];
			$algorithmInfo['preprocess']        = $monitorDataDetail[3];
			$algorithmInfo['similarityprocess'] = $monitorDataDetail[4];
			$algorithmInfo['itemitemprocess']   = $monitorDataDetail[5];
			$algorithmInfo['useruserprocess']   = $monitorDataDetail[6];
			$algorithmInfo['useritemprocess']   = $monitorDataDetail[7];
			$algorithmInfo['totaltime']         = (int)$monitorDataDetail[8];
			$algorithmInfo['timefinished']      = (int)$monitorDataDetail[9];

			$recommendationStatus[$key] = $algorithmInfo;
		}
		

		$this->registry->smarty->assign(array('recommendationStatus' => $recommendationStatus
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'recommendationmonitor.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'recommendationmonitor',
												'pageTitle'	=> 'Monitor :: Recommendation Algorithms',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			
		
	}
	
	public function apcmenuAction()
	{
		$do = $_GET['do'];
		
		//Xoa tat ca cache lien quan den product detail
		
		$cacheInfo = apc_cache_info('user');
		
		$affected = 0;
		if(count($cacheInfo['cache_list']) > 0)
		{
			foreach($cacheInfo['cache_list'] as $cacheItem)
			{
				if($do == 'productdetail')
				{
					if(preg_match('/sitehtml_productdetail/', $cacheItem['info'], $match))
					{
						if(apc_delete($cacheItem['info']))
						{
							$affected++;
						}
					}
				}//end clera product detail
				elseif($do == 'productlist')
				{
					echo '';
				}
				
				
			}
		}
		
		if($do != '')
		{
			echo '<h2>' . $affected . ' affected row(s).</h2>';
		}
		
		echo '
			<ul>
				<li><a href="?do=productdetail">Clear All Product Detail Cache</a></li>
			</ul>
		';
	}
	
	public function redisAction()
	{
		$this->registry->smarty->assign(array(
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'redis.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'apc',
												'pageTitle'	=> 'Statistics :: Redis',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			
		
	}
	
	public function dosmonitorAction()
	{
		$formData = $success = $error = array();
		
		$ipaddressFilter = (string)$this->registry->router->getArg('ipaddress');
		if($ipaddressFilter != '')
		{
			$formData['search'] = 'ipaddress';
			$formData['fipaddress'] = $ipaddressFilter;
		}
		
		$myDosDetector = new DosDetector();
		
		////////////
		//Ban new IP Address
		if(isset($_GET['fsubmitbanipadd']))
		{
			if($myDosDetector->banipInsert($_GET['fsubmitbanipadd']))
				$success[] = 'Banned IP Address ['.$_GET['fsubmitbanipadd'].'] Successfully. ';
			else
				$error[] = 'Error while ban IP Address ['.$_GET['fsubmitbanipadd'].'].';
		}
		
		///////////
		// Un-banned new IP Address
		if(isset($_GET['fsubmitbanipremove']))
		{
			if($myDosDetector->banipRemove($_GET['fsubmitbanipremove']))
				$success[] = 'Remove Banned IP Address ['.$_GET['fsubmitbanipremove'].'] Successfully. ';
			else
				$error[] = 'Error while remove banned IP Address ['.$_GET['fsubmitbanipremove'].'].';
		}
		
		
		$accessList = $myDosDetector->getAccessList();
		$bannedIpList = $myDosDetector->getBannedIpList();
		
		$this->registry->smarty->assign(array(	'accessList' => $accessList,
												'bannedIpList' => $bannedIpList,
												'formData' => $formData,
												'error'	=> $error,	
												'success' => $success,
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'dosmonitor.tpl');
		
		$this->registry->smarty->assign(array(	'nav'		=> 'dosmonitor',
												'pageTitle'	=> 'Statistics :: DoS Monitor',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			
		
	}
	
}


