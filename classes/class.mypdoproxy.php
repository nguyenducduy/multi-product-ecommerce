<?php

class MyPDOProxy
{
	// luu tru tat ca cac query moi khi truy van va insert dung ham array_unshift();
	private $storedSQL = array();

	protected $connectinfo = array();
	protected $isconnected = array();
	protected $master = array();
	protected $slaver = array();
	protected $latestReplicate = null;
	
		
	public function __construct()
	{

	}

	public function addMaster($host, $username, $password, $database)
	{
		$identifier = md5($host . $username . $password . $database);
		$this->connectinfo['master'][$identifier] = array('identifier' => $identifier, 'host' => $host, 'database' => $database, 'username' => $username, 'password' => $password);
	}

	public function addSlaver($host, $username, $password, $database)
	{
		$identifier = md5($host . $username . $password . $database);
		$this->connectinfo['slaver'][$identifier] = array('identifier' => $identifier, 'host' => $host, 'database' => $database, 'username' => $username, 'password' => $password);
	}

	public function initConnection($isMaster, $identifier)
	{
		$replicate = $isMaster ? 'master' : 'slaver';

		//For Tracking Metric
		$metricHost = substr($this->connectinfo[$replicate][$identifier]['host'], strrpos($this->connectinfo[$replicate][$identifier]['host'], '.') + 1);

		if(!isset($this->isconnected[$replicate . '-' . $identifier]))
		{
			try 
			{
				if($isMaster)
				{
					$this->master[$identifier] = new MyPDO('mysql:host=' . $this->connectinfo['master'][$identifier]['host'] . ';dbname=' . $this->connectinfo['master'][$identifier]['database'] , $this->connectinfo['master'][$identifier]['username'], $this->connectinfo['master'][$identifier]['password']);
					$this->master[$identifier]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->master[$identifier]->query('SET NAMES utf8');

					//Tracking Metric
					MonitorMetric::increment('dienmay.mysql.' . $replicate . '_'. $metricHost . '.success');
				}
				else
				{
					$this->slaver[$identifier] = new MyPDO('mysql:host=' . $this->connectinfo['slaver'][$identifier]['host'] . ';dbname=' . $this->connectinfo['slaver'][$identifier]['database'] , $this->connectinfo['slaver'][$identifier]['username'], $this->connectinfo['slaver'][$identifier]['password']);
					$this->slaver[$identifier]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->slaver[$identifier]->query('SET NAMES utf8');

					//Tracking Metric
					MonitorMetric::increment('dienmay.mysql.' . $replicate . '_'. $metricHost . '.success');
				}
				
				//mark as connect to this replicate
	            $this->isconnected[$replicate . '-' . $identifier] = true;
			}
			catch(PDOException $e)
			{
				global $registry;				

				//Tracking Metric
				MonitorMetric::increment('dienmay.mysql.' . $replicate . '_'. $metricHost . '.fail');

				if(isset($_COOKIE['isdeveloper']) || isset($_COOKIE['isadministrator']))
				{
					$error = $e->getMessage();
					die('Database connection failed. ('.strtoupper($replicate).': '. $identifier . ' | ' . $e->getMessage(). '). (Only administrator & developer can see this error message. Other people will see <a href="'.$registry->conf['rooturl'].'dberror.html">dberror.html</a> error page.)');
				}
				else
				{
					header('Location: ' . $registry->conf['rooturl'] . 'dberror.html');
				}
			}
		}//end check connection

		$db = null;
		if(isset($this->isconnected[$replicate . '-' . $identifier]) && $this->isconnected[$replicate . '-' . $identifier])
		{
			if($isMaster)
			{
				if(!empty($this->master[$identifier]))
					$db = $this->master[$identifier];
			}
			else
			{
				if(!empty($this->slaver[$identifier]))
					$db = $this->slaver[$identifier];
			}
		}
		

		return $db;
	}

	/**
	 * Base on the SQL query, we will route the query to valid/suitable replicate(master or slave) to load balancing between db servers
	 */
	protected function getReplicateDb($sql)
	{
		$sql = trim($sql);




		if(stripos($sql, 'SELECT') !== 0)
		{
			//Not select query
			if(preg_match('/insert\s+into\s+([a-z0-9_]+)/ims', $sql, $match))
			{
				$table = $match[1];
				$querytype = 'INSERT';
			}
			elseif(preg_match('/update\s+([a-z0-9_]+)/ims', $sql, $match))
			{
				$table = $match[1];
				$querytype = 'UPDATE';
			}
			elseif(preg_match('/delete\s+from\s+([a-z0-9_]+)/ims', $sql, $match))
			{
				$table = $match[1];
				$querytype = 'DELETE';
			}
			else
				$querytype = 'OTHER';
		}
		else
		{
			$querytype = 'SELECT';

			if(preg_match('/^select.*?from\s+([a-z0-9_]+)/ims', $sql, $match))
			{
				$table = $match[1];
			}
		}


		//Tracking Metric
		MonitorMetric::increment('dienmay.mysql.query.' . strtolower($querytype) . '.count');


		//////////////////////
		// SELECT DB BASE ON QUERY TYPE
		if($querytype == 'SELECT')
		{
			$replicateCount = count($this->connectinfo['slaver']);

			//select slaver
			if($replicateCount == 0)
				die('Slaver DB Config not found.');
			else
			{
				//Select a random slaver info
				$randomConnectInfo = array();
				$randseed = rand(1, $replicateCount);
				$i = 1;
				foreach($this->connectinfo['slaver'] as $connectinfo)
				{
					if($i == $randseed)
						$randomConnectInfo = $connectinfo;
					$i++;
				}

				/////////////////////////////////
				$db = $this->initConnection(false, $randomConnectInfo['identifier']);

			}
		}
		else
		{
			$replicateCount = count($this->connectinfo['master']);
			if($replicateCount == 0)
				die('Master DB Config not found.');
			else
			{
				//Select a random master info
				$randomConnectInfo = array();
				$randseed = rand(1, $replicateCount);
				$i = 1;
				foreach($this->connectinfo['master'] as $connectinfo)
				{
					if($i == $randseed)
						$randomConnectInfo = $connectinfo;
					$i++;
				}

				/////////////////////////////////
				$db = $this->initConnection(true, $randomConnectInfo['identifier']);
			}
		}


		//////////////
		return $db;
	}

  	public function prepare($sql, $driverOptions = array()) 
  	{
  		$this->latestReplicate = $replicatedb = $this->getReplicateDb($sql);


		$stmt = $replicatedb::prepare($sql);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);        
		return $stmt;
  	}

  	

  	public function query($sql, $params = array()) 
  	{
  		$this->latestReplicate = $replicatedb = $this->getReplicateDb($sql);

		//profiling the query
		if(defined('PROFILER_PQP'))
		{
			global $pqpProfiler;
			$start = $pqpProfiler->querydebug->getTime();
		}
		
		
		
		$stmt = $replicatedb->prepare($sql);
		$stmt->execute($params);
		
		//profiling the query
		if(defined('PROFILER_PQP'))
		{
			$pqpProfiler->querydebug->logQuery($sql, $params, $start);
		}
		
		
		return $stmt;
  	}

  	public function __call($name, $args)
  	{
  		if($this->latestReplicate)
  			return call_user_func_array(array($this->latestReplicate, $name), $args);	
  		else
  			return false;
  	}
}
