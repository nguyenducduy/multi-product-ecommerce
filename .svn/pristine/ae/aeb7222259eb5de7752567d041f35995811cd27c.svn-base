<?php
/**
 *
 * File contains the class used for class.gamefasteye.php
 *
 * @category dienmay.com
 * @author Nguyen Phan <phannguyen2020@gmail.com>
 * @copyright Copyright (c) 2013 - dienmay.com
 */
class Controller_Site_Gamefasteye extends Controller_Site_Base 
{
	private $blockip = array('127.255.255.255','83.170.92.186', '118.68.207.185');
	
	
	public function indexAction() {
		//session_destroy();

		if (SUBDOMAIN == 'm') {
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">Hiện tại bạn chỉ có thể chơi game này trên phiên bản máy tính';
			exit();
		}
		
		$ipaddress = Helper::getIpAddress(true);
		if (in_array(long2ip($ipaddress), $this->blockip)) {
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">Hệ thống dienmay.com phát hiện bạn có sự gian lận trong khi chơi và bị loại khỏi hệ thống theo quy định của thể lệ chương trình!';die;
		}else {
		
		
			// Get chuong trinh
			$gamefasteye = new Core_Gamefasteye(1);
			if ($gamefasteye->status == Core_Gamefasteye::STATUS_DISABLE) {
				header('location: ' . $this->registry->conf['rooturl']);
				exit();
			}
			unset($_SESSION['exprietime']);
			unset($_SESSION['pointquestion']);	
			$invitor_id = base64_decode($_GET['invitor']);
			if ($invitor_id > 0) {
				$_SESSION['invitor_id'] = $invitor_id;
			}
			$user_profile = array();
			if (!empty($_SESSION['User'])) {
				$user_profile = $_SESSION['User'];
				// Check login
				if (!empty($user_profile['email'])) {
					$myUser = Core_GamefasteyeUser::getGamefasteyeUsers(array('femail'=>$user_profile['email']), '', '');
				} else {
					$myUser = Core_GamefasteyeUser::getGamefasteyeUsers(array('fusername'=>$user_profile['username']), '', '');
				}
				
				$today = time();
				if($today <= strtotime(date("Y-m-d 10:00:00"))){
					$starttime = strtotime(date("Y-m-d 10:00:00", time() - 60 * 60 * 24));
					$endtime = strtotime(date("Y-m-d 10:00:00"));
				}else{
					$starttime = strtotime(date("Y-m-d 10:00:00"));
					$endtime = strtotime(date("Y-m-d 10:00:00", time() + 86400));
				}
				
				if($myUser[0]->id > 0) {
					if ($myUser[0]->status == Core_GamefasteyeUser::STATUS_ENABLE) {
						$_SESSION['usergameLogin'] = $myUser[0]->id;
						
						$user_profile = $myUser[0];
						if ($_SESSION['User']['oauthPartner'] == Core_User::OAUTH_PARTNER_FACEBOOK ) {
							$user_profile->avatar = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?type=large';
						}else {
							$user_profile->avatar = 'http://profiles.google.com/s2/photos/profile/'.$_SESSION['User']['id'].'?sz=160';
						}
						
						
						$datemodified = strtotime(date("Y-m-d H:i:s",$myUser[0]->datemodified));
						if ($datemodified >= $starttime && $datemodified <= $endtime) {
							
						}else {
							$myUser[0]->countplay = 2;
							$myUser[0]->point = 0;
							$myUser[0]->countshare = 0;
							$myUser[0]->updateData();
						
						}
					}else {
						echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">Hệ thống dienmay.com phát hiện bạn có sự gian lận trong khi chơi và bị loại khỏi hệ thống theo quy định của thể lệ chương trình!';die;
					}
				
				} else {
					$user = new Core_GamefasteyeUser();
					$user->gfeid = $gamefasteye->id;
					$user->fullname = $user_profile['name'];
					$user->username = $user_profile['username'];
					$user->email = $user_profile['email'];
					$user->oauthpartner = $user_profile['oauthPartner'];
					$user->countplay = 2;
					$user->status = 1;
					$user->addData();
					session_regenerate_id(true);
					$_SESSION['usergameLogin'] = $user->id;
					$user_profile = $user;
					
					if ($_SESSION['User']['oauthPartner'] == Core_User::OAUTH_PARTNER_FACEBOOK) {
						$user_profile->avatar = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?type=large';
					} else {
						$user_profile->avatar = 'http://profiles.google.com/s2/photos/profile/'.$_SESSION['User']['id'].'?sz=160';
					}
					
					// update luot chia se cho user invitor
					if ($_SESSION['invitor_id'] > 0) {
					
						$ipaddress = Helper::getIpAddress(true);
						$totalip = Core_GamefasteyeUser::getGamefasteyeUsers(array('fipaddress' => $ipaddress), '', '','', true);
						if ($totalip <= 30) {
							$invitor_id = $_SESSION['invitor_id'];
							$invitor = new Core_GamefasteyeUser($invitor_id);
							$invitor->countshare = $invitor->countshare + 1;
							$invitor->countplay = $invitor->countplay + 1;
							if (empty($invitor->shareid)) {
								$invitor->shareid = $user->id;
							} else {
								$invitor->shareid = $invitor->shareid . ',' . $user->id;
							}
							$invitor->updateData();
							unset($_SESSION['invitor_id']);	
							
							$historyshare = Core_GamefasteyeShare::getGamefasteyeShares(array('fguid'=> $invitor_id,'ftoday'=>1, 'fstarttime'=> $starttime, 'fendtime'=>$endtime), '', '',1);
							if (!empty($historyshare)) {
								$historyshare[0]->countshare = $historyshare[0]->countshare + 1;
								$historyshare[0]->updateData();
							}else {
								$share = new Core_GamefasteyeShare();
								$share->guid = $invitor_id;
								$share->countshare = 1;
								$share->addData();
							}
						}
					}
				}		
			}
			
			$_SESSION['QuestionToken'] = Helper::getSecurityToken();//Tao token moi
			
			// Get top 4 danh sach tham gia
			$cachejoin = new Cacher('FRONT_LIST_USER_JOIN');
			$listuserjoin = json_decode($cachejoin->get());
			if(isset($_GET['live'])) {
				$listuserjoin = '';
			}
			if (empty($listuserjoin)) {
				$listuserjoin = Core_GamefasteyeUser::getGamefasteyeUsers(array('fstatus'=> Core_GamefasteyeUser::STATUS_ENABLE, 'fgfeid'=> $gamefasteye->id), 'id', 'DESC', 4);
				$cachejoin->set(json_encode($listuserjoin, true), 600);
			}
			// Get top 4 user cao điểm nhất
			$cachepoint = new Cacher('FRONT_LIST_USER_POINT');
			$listuserpoint = json_decode($cachepoint->get());
			if(isset($_GET['live'])) {
				$listuserpoint = '';
			}
			if (empty($listuserpoint)) {
				$listuserpoint = Core_GamefasteyeUser::getGamefasteyeUsers(array('fstatus'=> Core_GamefasteyeUser::STATUS_ENABLE, 'fgfeid'=> $gamefasteye->id), 'point', 'DESC',4);
				$cachepoint->set(json_encode($listuserpoint, true), 600);
			}
			// Get top 4 chia se nhiều nhất
			$cacheshare = new Cacher('FRONT_LIST_USER_SHARE');
			$listusershare = json_decode($cacheshare->get());
			if(isset($_GET['live'])) {
				$listusershare = '';
			}
			if (empty($listusershare)) {
				$listusershare = Core_GamefasteyeUser::getGamefasteyeUsers(array('fstatus'=> Core_GamefasteyeUser::STATUS_ENABLE, 'fgfeid'=> $gamefasteye->id, 'fmodified'=> time()), 'share', 'DESC',4);
				$cacheshare->set(json_encode($listusershare, true), 600);
			}
			
			// Get tong so nguoi tham gia
			$cache = new Cacher('FRONT_LIST_USER_TOTAL');
			$totaluser = $cache->get();
			if ($totaluser <= 0) {
				$totaluser = Core_GamefasteyeUser::getGamefasteyeUsers(array(), '', '','', true);
				$cache->set($totaluser, 600);
			}
			
			// Get tong diem tat ca cau hoi
			$cachetotalpoint = new Cacher('FRONT_TOTAL_QUESTION');
			$totalpointquestion = $cachetotalpoint->get();
			if (empty($totalpointquestion)) {
				$totalpointquestion = Core_GamefasteyeQuestion::totalPointQuestion();
				$cachetotalpoint->set($totalpointquestion, 600);
			}
	
			 $this->registry->smarty->assign(
	            array(
	            	'gamefasteye' => $gamefasteye,
					'user_profile' => $user_profile,
	            	'listuserjoin' => $listuserjoin,
	            	'listuserpoint' => $listuserpoint,
	            	'listusershare' => $listusershare,
	            	'totaluser'    => $totaluser,
	            	'userid_share'=> base64_encode($_SESSION['usergameLogin']),
	            	'pageTitle' => 'YEAR IN REVIEW -  AI NHANH MẮT HƠN',
	            )
	        );
	        $this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
		}
	}
	
	public function logoutAction() {
		session_regenerate_id(true);
		session_destroy();		
		header('location: ' . $this->registry->conf['rooturl'] . 'year-in-review');
	}
	
	public function loadquestionAction() {
		$result = array('error'=> -1, 'html'=>'', 'time'=> '', 'token'=>'');
		if (isset($_POST) && $_POST['action'] == 'loadquestion') {
			$userid = $_SESSION['usergameLogin'];
			if ($_SESSION['QuestionToken'] == $_POST['token']) {
				if ($userid > 0) {
						$_SESSION['QuestionToken'] = Helper::getSecurityToken();//Tao token moi
						if (!empty($_SESSION['exprietime'])) {
							unset($_SESSION['exprietime']);
						}
						$user = new Core_GamefasteyeUser($userid);
						if ($user->countplay > 0) {
							$fgfeid = $_POST['fgfeid'];
							$pagequestion = (int)(($_POST['page'])> 0 ? (int)($_POST['page']) : 1 );
							$totalquestion = Core_GamefasteyeQuestion::getGamefasteyeQuestions(array('fgfeid'=>$fgfeid, 'fstatus'=> Core_GamefasteyeQuestion::STATUS_ENABLE), '', '', '', true);
							if ($pagequestion <= $totalquestion) {
								$limitStart = ($pagequestion - 1) * 1 . ',' . 1;
								$question = Core_GamefasteyeQuestion::getGamefasteyeQuestions(array('fgfeid'=>$fgfeid, 'fgfeid' => $fgfeid, 'fstatus'=>Core_GamefasteyeQuestion::STATUS_ENABLE), 'displayorder', 'ASC', $limitStart);
						    	$myQuestion = $question[0];
						    	$myQuestion->answer = unserialize($myQuestion->answer);
						    	$this->registry->smarty->assign(
							            array(
											'myQuestion' => $myQuestion,
							            	'pagequestion' => $pagequestion
							            )
						        	);
				        		$items = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'ajaxquestion.tpl');
								// update trừ lượt chơi
								$user->countplay = $user->countplay - 1;
								$user->phone = 0;
								$user->updateData();
								
								$gamefasteye = new Core_Gamefasteye($fgfeid);
								
								$time = date("H:i:s",$gamefasteye->time);
								$tmptime = explode(':', $time);
								$today = date("H:i:s",time());
								$tmptoday = explode(':', $today);
								$hours = $tmptoday[0] + $tmptime[0];
								$minutes = $tmptoday[1] + $tmptime[1];
								$seconds = $tmptoday[2] + $tmptime[2];
								
								$reviewtime = $hours . ':' . $minutes . ':' . $seconds;
								
								$exprietime = strtotime(date("Y-m-d " . $reviewtime));
								$_SESSION['exprietime'] = $exprietime;
								
				        		$result = array('error'=> 0, 'html'=>$items, 'time' => date("H:i:s", $gamefasteye->time), 'token'=> $_SESSION['QuestionToken']);
							}
						}else {
							$items = '<div class="gamenote"><b>Bạn đã hết lượt chơi, hãy mời bạn bè để có thêm lượt chơi</b></div>';
							$result = array('error'=> 0, 'html'=> $items, 'time' => '', 'token'=> $_SESSION['QuestionToken']);
						}
				}else {
					$items = '<div class="gamenote"><b>Bạn chưa đăng nhập, vui lòng đăng nhập để tiếp tục chơi!</b></div>';
					$result = array('error'=> 0, 'html'=> $items, 'time' => '', 'token' => $_SESSION['QuestionToken']);
				}
			}
		}
		echo json_encode($result);
	
	}
	
	public function nextquestionAction() {
		$result = array('error' => -1, 'page'=>'', 'contentquestion' => '', 'token'=> '');
		if(isset($_POST) && $_POST['action'] == 'nextquestion'){
			$answer = $_POST['answer'];
			if ($_SESSION['QuestionToken'] == $_POST['token']) {
				$userid = $_SESSION['usergameLogin'];
				if ($userid > 0) {
					$exprietime = $_SESSION['exprietime'];
					if ($exprietime > 0 && $exprietime > time()) {
						$currquestion_id = $_POST['currentquestion'];
						if ($currquestion_id > 0) {
							$currquestion = new Core_GamefasteyeQuestion($currquestion_id);
							if ($currquestion->correct == $answer) {
								// Cộng điểm cho user nếu trả lời đúng
								$user = new Core_GamefasteyeUser($userid);
								$user->phone = $user->phone + $currquestion->point;
								$user->updateData();
								//$_SESSION['pointquestion'] = $_SESSION['pointquestion'] + $currquestion->point; 
							}
						}
					
						$fgfeid = $_POST['fgfeid'];
						$pagequestion = (int)(($_POST['page'])> 1 ? (int)($_POST['page']) : 2 );
						$totalquestion = Core_GamefasteyeQuestion::getGamefasteyeQuestions(array('fgfeid'=>$fgfeid, 'fstatus'=> Core_GamefasteyeQuestion::STATUS_ENABLE), '', '', '', true);
						if ($pagequestion <= $totalquestion) {
							$_SESSION['QuestionToken'] = Helper::getSecurityToken();//Tao token moi
							$limitStart = ($pagequestion - 1) * 1 . ',' . 1;
							$question = Core_GamefasteyeQuestion::getGamefasteyeQuestions(array('fgfeid'=>$fgfeid, 'fgfeid' => $fgfeid, 'fstatus'=>Core_GamefasteyeQuestion::STATUS_ENABLE), 'displayorder', 'ASC', $limitStart);
					    	$myQuestion = $question[0];
					    	$myQuestion->answer = unserialize($myQuestion->answer);
					    	
					    	$contentquestion = '';
					    	if( !empty($myQuestion)) {
					    		$contentquestion .= '<div class="yt_imgnext"><a id="nextquestion" href="javascript:;" data-id="1" rel="' . ($pagequestion + 1) . '" data-action="' . $myQuestion->id . '" title="Xem hình kế tiếp"></a></div>';
					    		$contentquestion .= '<div class="orther_ask"><span>' . $myQuestion->name . '</span><div class="option_yt">';
					    		$i = 0;
					    		foreach ($myQuestion->answer as $answer) {
					    			$i++;
					    			$contentquestion .= '<label style="float:left; width:150px">';
					    			$contentquestion .= '<input type="radio" id="radio-2-' . $i . '" name="radio-2-set" class="regular-radio big-radio" value="' . $i . '" />';
					    			$contentquestion .= '<label for="radio-2-' . $i . '"></label> ';
					    			$contentquestion .= '<span class="label_yt">' . $answer . '</span></label>';
					    		}
					    		
					    		$contentquestion .= '</div><p class="error" style="color: red; text-align: center"></p></div>';
					    		$contentquestion .='<div class="slide_img_yt"><img alt="" src=" ' . $myQuestion->image . '"> </div>';
				    			$result = array('error' => 0, 'page'=> $pagequestion, 'contentquestion' => $contentquestion, 'token'=> $_SESSION['QuestionToken']);
					    	}else{
					    		$result = array('error' => 2, 'page'=> $pagequestion, 'contentquestion' => '', 'token'=> $_SESSION['QuestionToken']);
					    	}
				    		
						}else {
							$result = array('error' => 2, 'page'=> $pagequestion, 'contentquestion' => '', 'token'=> $_SESSION['QuestionToken']);
						}
					}else {
							$result = array('error' => 2, 'page'=> $pagequestion, 'contentquestion' => '', 'token'=> $_SESSION['QuestionToken']);
						}
				}else{
					$result = array('error' => 0, 'page'=> $pagequestion, 'contentquestion' => 'Bạn chưa đăng nhập! Vui lòng đăng nhập để tiếp tục chơi', 'token'=> $_SESSION['QuestionToken']);	
				}
			}
		}
		echo json_encode($result);
	}
	
	public function greetingAction() {
		if(isset($_POST) && $_POST['action'] == 'greeting') {
			if ($_SESSION['QuestionToken'] == $_POST['token']) {
				$_SESSION['QuestionToken'] = Helper::getSecurityToken();//Tao token moi
				$userid = $_SESSION['usergameLogin'];
				if ($userid > 0) {
					$exprietime = $_SESSION['exprietime'];
					if ($exprietime > 0) {
						$time = $_POST['time'];
//						if ($_SESSION['pointquestion'] > 0) {
//							$point = $_SESSION['pointquestion'];
//						}else {$point = 0;}
						
						$user = new Core_GamefasteyeUser($userid);
						if ($user->phone > 0) {
							$point = $user->phone;
							$user->phone = 0;
							$user->updateData();
						}else {
							$point = 0;
						}
						
						// Get tong diem tat ca cau hoi
						$cachetotalpoint = new Cacher('FRONT_TOTAL_QUESTION');
						$totalpointquestion = $cachetotalpoint->get();
						if (empty($totalpointquestion)) {
							$totalpointquestion = Core_GamefasteyeQuestion::totalPointQuestion();
							$cachetotalpoint->set($totalpointquestion, 600);
						}
						
						if ($point > $totalpointquestion) {
							$point = $totalpointquestion - 100;
						}
						
						$history = new Core_GamefasteyeHistory();
						$history->guid = $userid;
						$history->timeplayed = $time;
						$history->point = $point;
						$history->addData();
						
						$maxpoint = $history->getMaxPoint();
						
						$user = new Core_GamefasteyeUser($userid);
						if ($maxpoint >= $point) {
							$user->point = $maxpoint;
						}else {
							$user->point = $point;
						}
						$user->updateData();
		
						$html = '<div class="point_yt"><span class="point_size2"><b>Số điểm của bạn là:</b></span>';
						$html .= ' <strong class="point_size">' . $point . '</strong>';
						$html .= '<span>Số điểm cao nhất của bạn: <b>' . $maxpoint . ' điểm </b></span>';
						$html .= '  <span><b>Cảm ơn bạn đã tham gia !</b></span></div>';
						
						if (!empty($_SESSION['pointquestion'])) {
							unset($_SESSION['pointquestion']);
						}
						echo $html;	
					}else {
						echo '';
					}
				}else{
					echo 'Bạn chưa đăng nhập! Vui lòng đăng nhập để tiếp tục chơi';
				}
			}
			if (!empty($_SESSION['exprietime'])) {
				unset($_SESSION['exprietime']);
			}
		}
	}
	
	public function loginfacebookAction() {

		$ipaddress = Helper::getIpAddress(true);
		if (in_array(long2ip($ipaddress), $this->blockip)) {
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">Hệ thống dienmay.com phát hiện bạn có sự gian lận trong khi chơi và bị loại khỏi hệ thống theo quy định của thể lệ chương trình!';die;
		}else {
			require_once(SITE_PATH. 'libs/facebook/facebook.php');
			$facebook = new Facebook(array(
				'appId'		=>  '403992816397723',
				'secret'	=>  'bb179513ac955e873f230e664104e3e2',
			));
			
			//get the user facebook id
			$user = $facebook->getUser();
			if($user){
	
				try{
					//get the facebook user profile data
					$user_profile = $facebook->api('/me');
					$user_profile['oauthPartner'] = Core_User::OAUTH_PARTNER_FACEBOOK;
					$_SESSION['User'] = $user_profile;
					header('Location: ' . $this->registry->conf['rooturl'].'year-in-review');
					
				}catch (FacebookApiException $e) {
					error_log($e);
					$user = NULL;
				}
			}
			if(empty($user)){
				$loginurl = $facebook->getLoginUrl(array(
					'scope'			=> 'email,read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
					'redirect_uri'	=> $this->registry->conf['rooturl'].'gamefasteye/loginfacebook'
					));
					header('Location: ' . $loginurl);
			}
		}
	}
	
	public function logingoogleAction() {

		$ipaddress = Helper::getIpAddress(true);
		if (in_array(long2ip($ipaddress), $this->blockip)) {
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">Hệ thống dienmay.com phát hiện bạn có sự gian lận trong khi chơi và bị loại khỏi hệ thống theo quy định của thể lệ chương trình!';die;
		}else {
		
			require_once(SITE_PATH. 'libs/google/google.config.php');
			require_once(SITE_PATH. 'libs/google/google_auth.php');
	
			$client = new Google_Client();
			$client->setApplicationName("dienmay");
			$oauth2 = new Google_Oauth2Service($client);
			
			if (isset($_GET['code'])) { // IF GOOGLE
				$client->authenticate($_GET['code']);
				$_SESSION['token'] = $client->getAccessToken();
				$_SESSION['oauth_type'] ="google";
				$user_profile = $oauth2->userinfo->get();
	
				$user_profile['oauthPartner'] = Core_User::OAUTH_PARTNER_GOOGLE;
				$_SESSION['User'] = $user_profile;
	
				header('Location: ' . $this->registry->conf['rooturl'].'year-in-review');
			}else{
				$authUrl = $client->createAuthUrl();
				header('Location: ' . $authUrl);
			}
		}
			
	}
}