<?php

class MyPDO extends PDO
{
	// luu tru tat ca cac query moi khi truy van va insert dung ham array_unshift();
	private $storedSQL = array();
	private $enablequerystat = false;	//stat for update/delete/insert query

	function __construct($dsn, $username, $password, $enablequerystat = true)
	{
		parent::__construct($dsn, $username, $password);
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->enablequerystat = $enablequerystat;
	}

  	function prepare($sql, $driverOptions = array())
  	{
		$stmt = parent::prepare($sql);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
  	}

  	function query($sql, $params = array())
  	{
		//profiling the query
		if(defined('PROFILER_PQP'))
		{
			global $pqpProfiler;
			$start = $pqpProfiler->querydebug->getTime();
		}

		//Start tracking SQL Query
		//VDT, 10/06/2013. Tracking UPDATE/INSERT/DELETE query
		if($this->enablequerystat && stripos($sql, 'SELECT') !== 0)
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

			//Tracking
			if($querytype != '' && $table != '')
			{
				$skey = 'SQLLOG:' . $querytype . '-' . $table;
				$skeytotal = 'SQLLOG_TOTAL_QUERY';
				$skeylist = 'SQLLOG_TOTAL_KEY';

				$myCacher = new Cacher($skey);
				$skeyvalue = $myCacher->get();
				if(!empty($skeyvalue))
					$myCacher->set($skeyvalue + 1, 0);
				else
					$myCacher->set(1, 0);

				$myCacher = new Cacher($skeytotal);
				$skeytotalvalue = $myCacher->get();
				if(!empty($skeytotalvalue))
					$myCacher->set($skeytotalvalue + 1, 0);
				else
					$myCacher->set(1, 0);

				$myCacher = new Cacher($skeylist);
				$skeylistvalue = $myCacher->get();
				if(!empty($skeylistvalue))
				{
					$keylist = explode(',', $skeylistvalue);

					if(!in_array($skey, $keylist))
					{
						$keylist[] = $skey;
						$myCacher->set(implode(',', $keylist), 0);
					}

				}
				else
				{
					$myCacher->set($skey, 0);
				}
			}
		}
		//end tracking sql
		////////////////////

		$stmt = $this->prepare($sql);
		$stmt->execute($params);

		//profiling the query
		if(defined('PROFILER_PQP'))
		{
			$pqpProfiler->querydebug->logQuery($sql, $params, $start);
		}


		return $stmt;
  	}

  	function queryCountRow($sql, $params = array())
  	{
  		$sql = trim($sql);
		$sql = preg_replace('~^SELECT\s.*\sFROM~s', 'SELECT COUNT(*) FROM', $sql);
		$sql = preg_replace('~ORDER\s+BY.*?$~sD', '', $sql);
		$stmt = $this->prepare($sql);
		$stmt->execute($params);
		$r = $stmt->fetchColumn(0);
		return $r;
  	}

}


class PDOStatement_ extends PDOStatement
{
/*
  	function execute($params = array())
  	{
		parent::execute($params);
		return $this;
  	}
*/
  	function fetchSingle()
  	{
		return $this->fetchColumn(0);
  	}

  	function fetchAssoc()
  	{
		$this->setFetchMode(PDO::FETCH_NUM);
		$data = array();
		while ($row = $this->fetch())
		{
	  		$data[$row[0]] = $row[1];
		}
		return $data;
  	}
}

class Transaction
{

  	private $db = NULL;
  	private $finished = FALSE;

  	function __construct($db)
  	{
		$this->db = $db;
		$this->db->beginTransaction();
  	}

  	function __destruct()
  	{
		if (!$this->finished)
		{
	  		$this->db->rollback();
		}
  	}

  	function commit()
  	{
		$this->finished = TRUE;
		$this->db->commit();
  	}

  	function rollback()
  	{
		$this->finished = TRUE;
		$this->db->rollback();
  	}
}
