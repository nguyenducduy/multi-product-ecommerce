<?php
Class Core_Backend_Object extends Core_Object
{
	protected $db3 = NULL;
	
	public function __construct()
	{
		if(is_null($GLOBALS['db3']))
			$GLOBALS['db3'] = $this->db3 = self::getDb();
		else
			$this->db3 = $GLOBALS['db3'];

		parent::__construct();
	}
	
	public static function getDb()
	{
		global $conf;
		
		if ($GLOBALS['db3'] == NULL)
		{
			try
			{
				$GLOBALS['db3'] = new MyPDO('mysql:host=' . $conf['db3']['host'] . ';dbname=' . $conf['db3']['name'] . '', '' . $conf['db3']['user'] . '', '' . $conf['db3']['pass'] . '');
				$GLOBALS['db3']->query('SET NAMES utf8');
			}
			catch(PDOException $e)
			{
				$error = $e->getMessage();
				die('Can not connect to Backend DB. <!-- '.$error.'-->');
			}
			
		}
		
		return $GLOBALS['db3'];
	}
	
	
	public function __sleep()
    {
       	$this->db3 = null;
       	return parent::__sleep();
    }
}
