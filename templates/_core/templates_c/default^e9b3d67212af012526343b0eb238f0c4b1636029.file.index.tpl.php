<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:23:48
         compiled from "templates/default/_controller/admin/login/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14757527975e8ebf74151b28-21165290%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9b3d67212af012526343b0eb238f0c4b1636029' => 
    array (
      0 => 'templates/default/_controller/admin/login/index.tpl',
      1 => 1568482494,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14757527975e8ebf74151b28-21165290',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
	<head>
		<title>Authentication</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=cssadmin&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['cssversion'];?>
" media="screen" />
		
		<style type="text/css">
			*{box-sizing: content-box;-moz-box-sizing: content-box;-ms-box-sizing: content-box;}
			.login_body {
			  background: #3498db;
			}
			.clear{clear:both;}
			.login_body h2{font-size:24px;padding-bottom:7px;}
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
			  width: 400px;
			  background: #fff;
			  position: absolute;
			  top: 50%;
			  left: 50%;
			  margin: -300px 0 0 -200px;

			  z-index: 1000;
			
				-webkit-border-radius: 2px;
				       -moz-border-radius: 2px;
					        border-radius: 2px;
				
			}
			.login_body .wrap .alert {
			  margin: 20px;
			}
			.login_body .wrap h2 {
			  margin: 15px 20px 0 20px;
			}
			.login_body .wrap h4 {
			  margin: 5px 0 10px 20px;
			  color: #999;
			  font-size: 14px;
			font-weight:normal;
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
			
			.input-append .add-on, .input-prepend .add-on{border-width:0;}
			.login_body .wrap .login .email label, .login_body .wrap .login .pw label{font-weight:normal;}
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
		
	</head>
	
	
	<body class='login_body'>
		<div class="wrap">
			<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
" class="pull-right" style="color:#ccc;margin:20px;font-size:14px;"><i class="icon-home"></i></a>
			
			<h2>MyWebShop.vn</h2>
			<h4><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['help'];?>
</h4>
			<form action="" autocomplete="off" method="post" class="validate">
			
			
			<div class="clear" style="padding:20px;border-top:1px solid #eee;text-align:center; font-size:14px;">
				<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
logintgdd" class="btn btn-primary" style=""><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['loginWithTgdd'];?>
</a>
				<br /><br /><em>Hoặc</em><br />
			</div>
			
			<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value);$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
			
			<div class="login">
				<div class="email">
					<label for="user"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['email'];?>
</label><div class="email-input"><div class="control-group"><div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="text" id="femail" name="femail" class=""></div></div></div>
				</div>
				<div class="pw">
					<label for="pw"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['password'];?>
</label><div class="pw-input"><div class="control-group"><div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span><input type="password" id="fpassword" name="fpassword" class=''></div></div></div>
				</div>
				<div class="remember">
					<label class="checkbox" title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['remembermeTip'];?>
">
						<input type="checkbox" value="1" name="fremember"> <small><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['rememberme'];?>
</small>
					</label>
				</div>
			</div>
			<div class="submit">
				<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
forgotpass" style="color:#555;"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['forgotpass'];?>
</a>
				<input type="submit" name="fsubmit" class="btn btn-primary pull-right" style="margin-right:20px;" value="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['submitLabel'];?>
" />
			</div>

			
			
			
			
			</form>
			
			
		</div>
</body>
</html>

	
	
	
	
	

