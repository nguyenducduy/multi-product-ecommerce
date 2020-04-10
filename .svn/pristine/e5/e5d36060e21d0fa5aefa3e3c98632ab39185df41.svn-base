<?php

Abstract Class Controller_Cron_Base Extends Controller_Core_Base 
{
	protected $crontask;
	protected $timer;
	protected $cronId = 0;
	
	const USERNAME = 'dmadm';
	const PASSWORD = '03avdea43';
	
	
	public function __construct($registry)
	{
		set_time_limit(3600);
		
		
		$this->crontask = new Core_Backend_Crontask();
		$this->crontask->controller = $GLOBALS['controller'];
		$this->crontask->action = $GLOBALS['action'];
		$this->crontask->status = Core_Backend_Crontask::STATUS_PROCESSING;
		$this->crontask->addData();
		
		$this->timer = new Timer();
		$this->timer->start();
		
		//simple authentication here
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$username = $_GET['username'];
		$password = $_GET['password'];
		
		if($username != self::USERNAME || $password != self::PASSWORD)
		{
			die('Permission Deny.');
		}
		
		
		parent::__construct($registry);
	}
	
	public function __destruct()
	{
		$this->timer->stop();
		
		if($this->crontask->id > 0)
		{
			$this->crontask->timeprocessing = $this->timer->get_exec_time();
			$this->crontask->output = ob_get_contents();
			$this->crontask->status = Core_Backend_Crontask::STATUS_COMPLETED;
			$this->crontask->updateData();
		}
		
	}
	
}
