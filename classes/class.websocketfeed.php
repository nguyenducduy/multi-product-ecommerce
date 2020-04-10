<?php

/**
 * Utility Class de lam input cho WebSocket
 */
class WebSocketFeed
{
	const EMITTYPE_PUSHNOTIFICATION = 'pushnotification';
	
	public $userid = 0;
	public $emittype = '';	//type of emit used in server.js to navigate the receiver socket
	public $type = 0;
	public $url = '';
	public $icon = '';
	public $meta = '';
}
