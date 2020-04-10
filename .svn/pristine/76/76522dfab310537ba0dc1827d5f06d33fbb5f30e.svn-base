<?php

Class RedisCache
{
	private $productServer = "127.0.0.1:6379";
	private $generalServer = "10.1.6.10:6378";

	public $redis;
	public $expireTime = 1200;

	public function __construct()
	{
		if (extension_loaded('redis'))
			$this->redis = new Redis();
	}

	public function balancer($key)
	{
		$keyarr = explode(':', $key);

		$prefix = $keyarr[0]; //ten prefix tuong ung voi ten model

		$k = $keyarr[1]. ':' . $keyarr[2];

		if($prefix == 'product')
		{
			$connected = $this->redis->connect($this->productServer);
		}
		else
		{
			$connected = $this->redis->connect($this->generalServer);
		}

		if(!$connected)
			return 1;
		else
		{
			$this->redis->setOption(Redis::OPT_PREFIX, '' . $prefix . ':');

			return $k;	
		}
	}

	public function check($key)
	{
		$keyCache = $this->balancer($key);

		if($keyCache == 1)
			return false;
		else
		{
			if($this->redis->exists($keyCache))
				return true;
			else
				return false;
		}
	}

	public function set($key, $value, $time = false)
	{
		if($time)
			$this->expireTime = (int)$time;

		$keyCache = $this->balancer($key);

		if($keyCache == 1)
			return false;
		else
		{
			if($this->redis->exists($keyCache) == false)
			{
				if($this->redis->set($keyCache, $value, $this->expireTime))
					return true;
				else
					return false;
			}
		}
	}

	public function get($key)
	{
		$keyCache = $this->balancer($key);

		$cached = $this->redis->get($keyCache);

		if($cached)
			return $cached;
	}

	public function delete($key)
	{
		$keyCache = $this->balancer($key);

		$numberItemDeleted = $this->redis->delete($keyCache);

		return $numberItemDeleted;
	}
	
}
























