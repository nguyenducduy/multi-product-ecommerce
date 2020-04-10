<?php

Abstract Class Controller_Core_Base 
{
	protected $registry;

	function __construct($registry) 
	{
		if(SUBDOMAIN == 'm' && $registry->controllerGroup == 'site')
			$controllerGroupPrefix = 'm';
		else
			$controllerGroupPrefix = '';
		
		//set smarty template container
		$registry->set('smartyControllerContainerRoot', '_controller/');
		$registry->set('smartyControllerGroupContainer', '_controller/' . $controllerGroupPrefix . $registry->controllerGroup . '/');
		$registry->set('smartyControllerContainer', '_controller/' . $controllerGroupPrefix . $registry->controllerGroup.'/'.$registry->controller . '/');
		$registry->set('smartyMailContainerRoot', '_mail/');
		
		$registry->smarty->assign(array('smartyControllerContainerRoot'	=> '_controller/', 
										'smartyControllerGroupContainer' => '_controller/' . $controllerGroupPrefix . $registry->controllerGroup . '/',
										  'smartyControllerContainer' => '_controller/' .  $controllerGroupPrefix . $registry->controllerGroup.'/' . $registry->controller . '/', 
										  'smartyMailContainerRoot' => '_mail/', 
										  ));
			
		if(isset($_GET['live']) && isset($registry->setting['site']['varnishserver']) && is_array($registry->setting['site']['varnishserver']) && count($registry->setting['site']['varnishserver']) > 0)
		{
			$hostname = $_SERVER['HTTP_HOST'];
			$url = preg_replace('/(&|\?)live$/', '',  (string)$_SERVER['REQUEST_URI']);
			$ipaddress = $registry->setting['site']['varnishserver'];
			
			foreach ($ipaddress as $ip)
			{
				$header = array(	"Host: " . $hostname, // IMPORTANT
									"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
									"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3",
									"Accept-Encoding: gzip,deflate,sdch",
									"Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4",
									"Cache-Control: max-age=0",
									"Connection: keep-alive" );
								
				$curlOptionList = array(	CURLOPT_URL => 'http://' . $ip . $url,
											CURLOPT_HTTPHEADER => $header,
											CURLOPT_CUSTOMREQUEST => "PURGE",
											CURLOPT_VERBOSE => true,
											CURLOPT_RETURNTRANSFER => true,
											CURLOPT_NOBODY => true,
											CURLOPT_CONNECTTIMEOUT_MS => 2000 );
									
				$fd = false;
			    if( $debug == true ) {
			        print "\n---- Purge Output -----\n";
			        $fd = fopen("php://output", 'w+');
			        $curlOptionList[CURLOPT_VERBOSE] = true;
			        $curlOptionList[CURLOPT_STDERR]  = $fd;
			    }
			    
				$curlHandler = curl_init();
			    curl_setopt_array( $curlHandler, $curlOptionList );
			    curl_exec( $curlHandler );
			    curl_close( $curlHandler );
			    if( $fd !== false ) {
			        fclose( $fd );
			    }
			}
		}
		
		$this->registry = $registry;
	}


	/**
	 * Check an Access Ticket when user visit a feature need to check authorization
	 */
	public function checkAccessTicket($suffix = '', $isWildcardAction = false)
	{
		$pass = false;

		$ticket = $this->getAccessTicket($suffix, $isWildcardAction);
		
		if($this->registry->me->id > 0 && $this->registry->me->haveAccessTicket($ticket))
			$pass = true;

		return $pass;
	}
	

	/**
	 * Build Access Ticket for Authorization base on feature
	 */
	public function getAccessTicket($suffix = '', $isWildcardAction = false)
	{
		if($isWildcardAction)
			$actionstring = '*';
		else
			$actionstring = $GLOBALS['action'];

		$ticket = $GLOBALS['controller_group'] . '_' . $GLOBALS['controller'] . '_' . $actionstring . '_' . $suffix;
		return $ticket;
	}


	
	function __destruct()
	{
		
		
	}

	function __call($name, $args)
	{
		if($this->registry->controllerGroup == 'site')
			header('location: ' . $this->registry->conf['rooturl'] . 'notfound');
		else
			header('location: ' . $this->registry->conf['rooturl_admin'] . 'notfound');
		exit();
	}
	
	protected function getRedirectUrl()
	{
		
		
		/*$redirectUrl = $this->registry->router->getArg('redirect');
		if(strlen($redirectUrl) > 0)
			$redirectUrl = base64_decode($redirectUrl);	
		else
			$redirectUrl = Helper::curPageURL();
		
		return $redirectUrl;*/    
        return $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller; 
	} 
	
	protected function notfound()
	{
		if($this->registry->controllerGroup == 'site')
			header('location: ' . $this->registry->conf['rooturl'] . 'notfound?r=' . base64_encode(Helper::curPageURL()));
		else
			header('location: ' . $this->registry->conf['rooturl_admin'] . 'notfound?r=' . base64_encode(Helper::curPageURL()));
		exit();
	}
	
	abstract function indexAction();
	
	
}
