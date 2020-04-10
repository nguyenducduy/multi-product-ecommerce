<?php

Class Cache_Apc extends Cache_Base
{
	public function set($key, $value)
	{
		return apc_store($key, $value, $this->duration);
	}
	
	public function get($key)
	{
		return apc_fetch($key);
	}
	
	public function delete($key)
	{
		return apc_delete($key);
	}
	
	public function check($key)
	{
		$row = apc_fetch($key);
		if(!empty($row))
		{
			return $row;
		}
		else
		{
			return false;
		}
	}
	
	public function setDuration($seconds)
	{
		$this->duration = $seconds;
	}
	
	public function getDuration()
	{
		return $this->duration;
	}
	
}