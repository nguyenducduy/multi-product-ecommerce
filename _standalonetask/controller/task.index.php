<?php
	
	//prevent from direct call
	if(!defined('IN_TASK'))
		die();
		
	
	echo siteHeader();
	
	echo 'Task List:' . NL . DASH . NL;
	echo '1. <a href="?c=friendrecommendation">Friend Recommendation</a>' . NL;
	
	echo siteFooter();
	