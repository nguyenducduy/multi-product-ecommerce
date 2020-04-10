<html>
	<head>
		<title>Authentication</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
		{literal}
		<style type="text/css">
			*{box-sizing: content-box;-moz-box-sizing: content-box;-ms-box-sizing: content-box;}
			.login_body {
			  background: url({/literal}{$imageDir}admin/loginbg.jpg{literal}) repeat;
			}
			.clear{clear:both;}
			.login_body h2{font-size:28px;padding-bottom:7px;}
			.login_body .social-toggle {
			  width: 205px;
			  position: absolute;
			  bottom: -30px;
			  right: 0;
			  margin: 10px 0 0 -5px;
			  background: #fff;
			  z-index: 1001;
			text-align:right;
			  -webkit-border-radius: 8px 8px 8px 8px;
			  -moz-border-radius: 8px 8px 8px 8px;
			  border-radius: 8px 8px 8px 8px;
			  -webkit-box-shadow: 0 2px 10px #999999;
			  -moz-box-shadow: 0 2px 10px #999999;
			  box-shadow: 0 2px 10px #999999;
			  *zoom: 1;
			}
			.login_body .social-toggle:before,
			.login_body .social-toggle:after {
			  display: table;
			  content: "";
			}
			.login_body .social-toggle:after {
			  clear: both;
			}
			.login_body .social-toggle a {
			  padding: 10px 15px 10px 20px;
			  display: block;
			}
			.login_body .social-toggle a:hover .caret {
			  border-top-color: #94100d;
			  opacity: 0.8;
			  filter: alpha(opacity=0.8);
			}
			.login_body .social-toggle a:hover .caret.caret-up {
			  border-top-color: transparent;
			  margin-top: 2px;
			  border-bottom: 4px solid #94100d;
			}
			.login_body .social-toggle .caret {
			  margin-top: 6px;
			  border-top-color: #c15656;
			  opacity: 0.8;
			  filter: alpha(opacity=0.8);
			}
			.login_body .social-toggle .caret.caret-up {
			  border-top-color: transparent;
			  margin-top: 2px;
			  border-bottom: 4px solid #c15656;
			}
			.login_body .social-shadow-hider {
			  background: #fff;
			  width: 240px;
			  height: 16px;
			  display: block;
			  position: absolute;
			  bottom: 0;
			  right: 0;
			  margin: 1px 0 0 -10px;
			  z-index: 1999;
			}
			.login_body .wrap {
			  width: 500px;
			  background: #fff;
			  position: absolute;
			  top: 50%;
			  left: 50%;
			  margin: -300px 0 0 -200px;

			  z-index: 1000;
			
				-webkit-border-radius: 2px;
				       -moz-border-radius: 2px;
					        border-radius: 2px;
					-webkit-box-shadow: 0px 0px 0px 5px rgba(0,0,0,0.15);
				       -moz-box-shadow: 0px 0px 0px 5px rgba(0,0,0,0.15);
				         	box-shadow: 0px 0px 0px 5px rgba(0,0,0,0.15);
				
				
			}
			.login_body .wrap .alert {
			  margin: 20px;
			}
			.login_body .wrap h2 {
			  margin: 15px 20px 0 20px;
			}
			.login_body .wrap h4 {
			  margin: -3px 0 30px 20px;
			  color: #999;
			  font-size: 14px;
			}
			.login_body .wrap form {
			  margin: 0;
			}
			.login_body .wrap .submit {
			  *zoom: 1;
			  margin-bottom: 15px;
			}
			.login_body .wrap .submit:before,
			.login_body .wrap .submit:after {
			  display: table;
			  content: "";
			}
			.login_body .wrap .submit:after {
			  clear: both;
			}
			.login_body .wrap .submit button {
			  float: right;
			  margin-right: 20px;
			}
			.login_body .wrap .submit a {
			  float: left;
			  margin: 7px 20px;
			}
			.login_body .wrap .login {
			  background: #f8f8f8;
			  padding: 10px;
			  margin: 5px 20px 20px 20px;
			  -webkit-border-radius: 6px 6px 6px 6px;
			  -moz-border-radius: 6px 6px 6px 6px;
			  border-radius: 6px 6px 6px 6px;
			  *zoom: 1;
			}
			.login_body .wrap .login .remember {
			  margin: 15px 0 0 105px;
			}
			.login_body .wrap .login:before,
			.login_body .wrap .login:after {
			  display: table;
			  content: "";
			}
			.login_body .wrap .login:after {
			  clear: both;
			}
			.login_body .wrap .login .email {
			  margin-top: 5px;
			}
			.login_body .wrap .login .pw {
			  margin-top: 15px;
			}
			.login_body .wrap .login .email,
			.login_body .wrap .login .pw {
			  *zoom: 1;
			}
			.login_body .wrap .login .email .input-prepend,
			.login_body .wrap .login .pw .input-prepend {
			  margin: 0;
			}
			.login_body .wrap .login .email:before,
			.login_body .wrap .login .pw:before,
			.login_body .wrap .login .email:after,
			.login_body .wrap .login .pw:after {
			  display: table;
			  content: "";
			}
			.login_body .wrap .login .email:after,
			.login_body .wrap .login .pw:after {
			  clear: both;
			}
			.login_body .wrap .login .email label,
			.login_body .wrap .login .pw label {
			  float: left;
			  margin: 10px 5px;
			  font-weight: bold;
			  width: 80px;
			}
			.login_body .wrap .login .email label.error,
			.login_body .wrap .login .pw label.error {
			  width: auto;
			  font-weight: normal;
			}
			.login_body .wrap .login .email-input,
			.login_body .wrap .login .pw-input {
			  float: right;
			  padding: 1px;
			  background: #eee;
			  -webkit-border-radius: 3px 3px 3px 3px;
			  -moz-border-radius: 3px 3px 3px 3px;
			  border-radius: 3px 3px 3px 3px;
			}
			.login_body .wrap .login .email-input input,
			.login_body .wrap .login .pw-input input {
			  margin: 0;
			  width: 190px !important;
			}
			.login_body .wrap .login .email-input .control-group,
			.login_body .wrap .login .pw-input .control-group {
			  margin: 0;
			}
			.login_body .wrap .login.social {
			  display: none;
			}
			.login_body .wrap .login.social .btn-row {
			  margin-top: 5px;
			}
			.login_body .wrap .login.social .btn-row:first-child {
			  margin-top: 0;
			}
			.login_body .wrap .login.social .btn {
			  width: 150px;
			}
			.login_body .wrap .login.social .btn.btn-social {
			  padding: 4px 8px;
			  text-align: left;
			}
			.login_body .wrap .login.social .btn.btn-social img {
			  margin-right: 2px;
			  float: left;
			}
			@media (max-height: 650px) {
			  .login_body .wrap {
			    margin-top: -150px;
			  }
			  .login_body .social-shadow-hider {
			    margin-top: 150px;
			  }
			  .login_body .social-toggle {
			    margin-top: 160px;
			  }
			}
			@media (max-width: 467px) {
			  .mobile-hide {
			    display: none;
			  }
			  .login_body .wrap {
			    width: 300px;
			    margin: 30px 30px 60px 30px;
			    top: auto;
			    left: auto;
			  }
			  .login_body .wrap h2 {
			    font-size: 24px;
			  }
			  .login_body .wrap h4 {
			    font-size: 12px;
			  }
			  .login_body .wrap .login .email label,
			  .login_body .wrap .login .pw label {
			    width: 100%;
			    margin: 5px;
			    display: block;
			  }
			  .login_body .wrap .login.social .btn {
			    width: 100px;
			  }
			}
			
			
			/* ---- NOTIFY BAR ---- */
			.notify-bar{padding:10px;border-radius: 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; margin:0 20px 10px 20px;}
			.notify-bar-success{background:#eaffa5;color:#6c8c00;}
			.notify-bar-error{background:#ffcfce;color:#9e3737;}
			.notify-bar-warning{background:#ffeeb1;color:#e37b00;}
			.notify-bar-info{background:#d6e2ff;color:#577bd1;}
			.notify-bar-icon{float:left;width:35px;}
			.notify-bar-icon img{width:24px; height:24px;}
			.notify-bar-text{padding:0 20px 0 35px; font-size:14px;line-height:1.5;}
			.notify-bar-text p{margin-bottom:0;}
			.notify-bar-text-sep{border-top:1px solid #eee;margin:10px 0;}
			.notify-bar-button{float:right;width:15px;text-align:right;display:none;}
			
		</style>
		{/literal}
	</head>
	
	
	<body class='login_body'>
		<div class="wrap">
			<a href="{$conf.rooturl}logout" class="pull-right" style="color:#ccc;margin:20px;font-size:14px;">Logout</a>
			
			<h2>Chào bạn {$me->fullname},</h2>
			<h4>Mã tài khoản của bạn <span class="label label-success">{$me->getCode()}</span></h4>
			
			<div style="padding:0 20px">
				<p>Chào mừng bạn đến với hệ thống nội bộ của website dienmay.com.</p>
				<p>Đây là lần đầu tiên bạn truy cập và hệ thống nhận thấy bạn chưa được thêm vào phòng ban nào trong hệ thống. Vì lý do bảo mật nên bạn không thể tiếp tục thực hiện các chức năng khác.</p>
				<p>Hãy liên hệ với các thành viên của phòng nhân sự hoặc bộ phận phát triển web để đưa bạn vào phòng ban tương ứng. Sau khi thêm vào phòng ban của hệ thống, bạn sẽ truy cập được các chức năng chính của hệ thống.</p>
				<p>Nội dung liên hệ: Mã số nhân viên trên báo cáo nội bộ, Họ tên, phòng ban, chức vụ, Mã tài khoản ở trên (<span class="label label-success">{$me->getCode()}</span>).</p>
				<p style="padding:10px; border-top: 2px solid #eee; border-bottom:2px solid #eee;font-weight:bold;line-height:1.7;">
					Võ Hoàng Long (BCNB: 16445) (Bộ phận phát triển web)<br />
					Nguyễn Đức Duy (BCNB: 17004) (Bộ phận phát triển web)<br />
					Nguyễn Hoàng Quân (BCNB: 17003) (Bộ phận phát triển web)<br />
					Lê Thị Thắm (BCNB: 11399) (Bộ phận phát triển web)<br />
				</p>
				
				<p>Sau khi thêm vào phòng ban, để thực hiện chức năng cần quyền cao hơn (thay đổi sản phẩm, tin tức, nhân sự...):
					<ul>
						<li>Nếu là trưởng bộ phận, liên hệ trực tiếp với thành viên nhóm phát triển web ở trên để hỗ trợ.</li>
						<li>Nếu không phải là trưởng bộ phận, hãy liên hệ với trưởng bộ phận của mình để được cấp quyền, không cần liên hệ nhóm phát triển web nữa.</li>
					</ul>
				</p>
				<p><br />Trân trọng, <br />Bộ Phận Phát Triển Web.</p>
			</div>
			
			
		</div>
</body>
</html>

	
	
	
	
	

