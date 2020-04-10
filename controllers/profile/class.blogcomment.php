<?php

Class Controller_Profile_BlogComment Extends Controller_Profile_Base
{

	public function indexAction()
	{

	}

	/**
	* Load cac comment cua 1 blog
	*
	*/
	function indexajaxAction()
	{
		$myBlog = new Core_Blog($_GET['id']);
		//check buyer hoac seller co phai la ME
		if($myBlog->id > 0)
	    {
	    	$page = (int)$_GET['page'];
			$recordPerPage = $this->registry->setting['blogcomment']['recordPerPage'];

			if($page <= 0) $page = 1;

			//tim tong so record
			$total = Core_BlogComment::getComments(array('fblogid' => $myBlog->id), '', '', '', true);
			$totalPage = ceil($total/$recordPerPage);
			$paginateUrl = 'user_blogcommentLoad('.$myBlog->id.', ::PAGE::)';

			$comments = Core_BlogComment::getComments(array('fblogid' => $myBlog->id), 'id', 'DESC', '' . (($page - 1) * $recordPerPage) . ',' . $recordPerPage);


			if(count($comments) == 0)
			{
				echo 'empty';
			}
			else
			{
				//reverse time order
				$comments = array_reverse($comments);

				for($i = 0; $i < count($comments); $i++)
				{
					$comments[$i]->text = Helper::mentionParsing($comments[$i]->text, $comments[$i]->entityList);
				}

				$this->registry->smarty->assign(array('comments'		=> $comments,
													'total' => $total,
													'totalPage' => $totalPage,
													'curPage' => $page,
													'paginateUrl' => $paginateUrl
													));

				$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');
			}
		}
		else
		{
			echo 'empty';
		}



	}

	/**
	* Them 1 comment cho 1 blog
	*
	*/
	function addajaxAction()
	{
		$myBlog = new Core_Blog($_GET['id']);
		$success = 0;
		$message = '';
		$moreMessage = '';

		if($myBlog->id == 0 || ($this->registry->me->id != $this->registry->myUser->id && !$myBlog->isAvailable($this->registry->me->id, $this->registry->userIsFriend)))
		{
		    $success = 0;
			$message = $this->registry->lang['controller']['blognotfound'];
		}
		elseif($myBlog->opencomment == 0)
		{
			$success = 0;
			$message = $this->registry->lang['controller']['closecommentwarning'];
		}
	    else
	    {
	    	$moreMessage = '';
			$error = array();
			$formData = $_POST;
			array_walk($formData, 'trim');

			if($this->addajaxValidator($formData, $error))
			{
				//get the poster
				//boi vi neu post len page thi phai
				//quan tam den poster neu dang login la page creator
				$posterAsPage = 1;	//default
				$poster = $this->registry->me;
				if($this->registry->myUser->ispage() && $this->registry->myPage->uid_creator == $this->registry->me->id && $posterAsPage)
				{
					$poster = $this->registry->myUser;
				}


				$myComment = new Core_BlogComment();
				$myComment->uid = $poster->id;
				$myComment->bid = $myBlog->id;
				$myComment->text = htmlspecialchars($formData['fmessage']);

				if($myComment->addData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succAdd'];
					$moreMessage = '<comment>';
					$moreMessage .= '<id>'.$myComment->id.'</id>';
					$moreMessage .= '<text><![CDATA['.Helper::mentionParsing($myComment->text, $myComment->entityList).']]></text>';
					$moreMessage .= '<time>'.$myComment->datecreated.'</time>';
					$moreMessage .= '<fullname>'.$poster->fullname.'</fullname>';
					$moreMessage .= '<userpath>'.$poster->getUserPath().'</userpath>';
					$moreMessage .= '<avatar>'.$poster->getSmallImage().'</avatar>';
					$moreMessage .= '</comment>';

					$_SESSION['commentSpam'] = time();
					$_SESSION['previousComment'] = $formData['fmessage'];


					//boi vi khi add comment thi ngoai viec update metadata
					//con tao notification den nhung userid lien quan den blog nay dua vao metadata lists
					//do do, su dung co che async job de vua send notification (co the co nhieu INSERT sql)
					//de process nhanh cho nay
					//viec goi notification nay duoc thiet ke rieng 1 automatic task (standalone) voi cac tham so tuong ung
					//de tu dong goi ma thoi
					//goi email toi nhung nguoi lien quan
					$taskUrl = $this->registry->conf['rooturl'] . 'task/blogcommentfinish';
					Helper::backgroundHttpPost($taskUrl, 'uid=' . $poster->id.'&bid=' . $myBlog->id.'&cid=' . $myComment->id);
				}
				else
				{
					$success = 0;
					$message = $this->registry->lang['controller']['errAdd'];
				}
			}
			else
			{
				$success = 0;
				$message = implode(', ', $error);
			}
		}


		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}


	/**
	* Remove 1 comment cho 1 user doi voi 1 blog
	*
	*/
	function removeajaxAction()
	{
		$myComment = new Core_BlogComment((int)$_GET['id']);
		if($myComment->uid != $this->registry->me->id)
		{
			$success = 0;
			$message = $this->registry->lang['controller']['notfound'];
		}
		else
		{
			if($myComment->delete())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succRemove'];

				//descrease comment
				$myComment->blog->increaseComment(-1);
			}
			else
			{
				$success = 0;
				$message = $this->registry->lang['controller']['errRemove'];
			}
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}


	###########################################################3
	###########################################################3
	###########################################################3
	protected function addajaxValidator($formData, &$error)
	{
		$pass = true;

		//check feed comment on page
		if($this->registry->myUser->ispage())
		{
			//check member
			if(!($this->registry->myPage->isadmin() || $this->registry->userIsFriend))
			{
				$pass = false;
				$error[] = $this->registry->lang['default']['errPagePermission'];
			}
		}


		$strlen = mb_strlen($formData['fmessage'], 'utf-8');
		if($strlen < $this->registry->setting['blogcomment']['messageMinLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['blogcomment']['messageMinLength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}

		if($strlen > $this->registry->setting['blogcomment']['messageMaxLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['blogcomment']['messageMaxLength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}

		if($strlen > 0 && strcmp($formData['fmessage'], $_SESSION['previousComment']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errDuplicate'];
		}

		//check spam
		if(isset($_SESSION['commentSpam']) && $_SESSION['commentSpam'] + $this->registry->setting['blogcomment']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}

		return $pass;
	}
}

