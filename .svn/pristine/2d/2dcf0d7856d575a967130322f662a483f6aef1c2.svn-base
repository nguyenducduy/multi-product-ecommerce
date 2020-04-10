<?php

Abstract Class Controller_Task_Base Extends Controller_Core_Base 
{
	protected $backgroundtask;
	protected $timer;
	
	public function __construct($registry)
	{
		set_time_limit(3600);
		
		if(isset($_GET['debug']))
		{
			$this->backgroundtask = new Core_Backend_BackgroundTask();
			$this->backgroundtask->url = $_SERVER['REQUEST_URI'];
			if(!empty($_POST) && count($_POST) > 0)
			{
				$tmp = $_POST;
				$keyvaluepairs = array();
				foreach($tmp as $key => $value)
				{
					$keyvaluepairs[] = $key . '=' . $value;
				}
				$this->backgroundtask->postdata = implode('&', $keyvaluepairs);
			}

			$this->timer = new Timer();
			$this->timer->start();
		}
		
		parent::__construct($registry);
	}
	
	public function __destruct()
	{
		if(isset($_GET['debug']))
		{
			$this->timer->stop();
			$this->backgroundtask->timeprocessing = $this->timer->get_exec_time();

			$this->backgroundtask->output = ob_get_contents();

			$this->backgroundtask->addData();
		}
		
	}
		
}
