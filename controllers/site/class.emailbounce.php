<?php
Class Controller_Site_Emailbounce Extends Controller_Site_Base
{	
	public function indexAction()
	{
		$numberemail = 0;
		if($_SERVER['REQUEST_METHOD'] != 'POST') 
		{
		    logger('Not POST request, quitting');
		    exit();
		}


		$post_content = file_get_contents('php://input');

		$msg_content = json_decode($post_content);
		
		if($msg_content->notificationType == 'Bounce')
		{	
			if( count($msg_content->bounce->bouncedRecipients) > 0 )
			{
				foreach ( $msg_content->bounce->bouncedRecipients as $bouncedRecipient) 
				{					
					if(Core_EmailBlacklit::checkEmailNotExist($bouncedRecipient->emailAddress))
					{						
						$myEmailBlacklist = new Core_EmailBlacklit();
						$myEmailBlacklist->email = $bouncedRecipient->emailAddress;
						$myEmailBlacklist->type = Core_EmailBlacklit::TYPE_BOUNCE;
						$myEmailBlacklist->source = 'ses';
						$myEmailBlacklist->metadata = '';
						$myEmailBlacklist->status = Core_EmailBlacklit::STATUS_ENABLE;
						if($myEmailBlacklist->addData() > 0)
						{
							$numberemail++;
						}

					}					

				}
			}
		}
		echo $numberemail;
	}


}