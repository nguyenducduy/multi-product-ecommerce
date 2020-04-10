<?php

Abstract Class Cache_Base
{
	private $duration = 0;	//In Seconds
	
	abstract public function set($key, $value);
	abstract public function get($key);
	abstract public function delete($key);
	abstract public function check($key);
	abstract public function setDuration($seconds);
	abstract public function getDuration();
}