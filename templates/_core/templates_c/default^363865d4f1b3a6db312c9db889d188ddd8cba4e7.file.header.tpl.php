<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:10
         compiled from "templates/default/_controller/admin/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20014384985e8ec25a868c59-06082105%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '363865d4f1b3a6db312c9db889d188ddd8cba4e7' => 
    array (
      0 => 'templates/default/_controller/admin/header.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20014384985e8ec25a868c59-06082105',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html lang="en">
  <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title><?php echo (($tmp = @$_smarty_tpl->getVariable('pageTitle')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('currentUrl')->value : $tmp);?>
</title>
		
		<!-- Bootstrap Stylesheet -->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />
	  	
		<!-- Bootstrap Responsive Stylesheet -->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />
        
		<!-- Customized Admin Stylesheet -->
		<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=cssadmin&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['cssversion'];?>
" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=cssadminresponsive&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['cssversion'];?>
" media="screen" />
		
		<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=cssadminchart&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['cssversion'];?>
" media="screen" />

		
		
		
		<!-- jQuery -->
		<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
js/admin/jquery.js"></script>
		
		<!-- Bootstrap Js -->
		<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
bootstrap/js/bootstrap.min.js"></script>
		
		
		
		<!-- customized admin -->
		<script src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=jsadmin&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['jsversion'];?>
"></script>
		
		
        <script type="text/javascript">
		var rooturl = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
";
		var rooturl_admin = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
";
		var rooturl_cms = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
";
		var rooturl_crm = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_crm'];?>
";
		var rooturl_erp = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_erp'];?>
";
		var rooturl_profile = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
";
		var rooturl_stat = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_stat'];?>
";
		var controllerGroup = "<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
";
		var currentTemplate = "<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
";
		
		var websocketurl = "<?php echo $_smarty_tpl->getVariable('setting')->value['site']['websocketurl'];?>
";
		var websocketenable = <?php echo $_smarty_tpl->getVariable('setting')->value['site']['websocketenable'];?>
;
		
		var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";
		
		
		var imageDir = "<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
";
		var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
		var gritterDelay = 3000;
		var meid = <?php echo $_smarty_tpl->getVariable('me')->value->id;?>
;
		var meurl = "<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
";
		var userid = <?php echo $_smarty_tpl->getVariable('myUser')->value->id;?>
;
		var userurl = "<?php echo $_smarty_tpl->getVariable('myUser')->value->getUserPath();?>
";
		</script>
		
	</head>
    
    <body <?php if ($_smarty_tpl->getVariable('controllerGroup')->value=='profile'&&$_smarty_tpl->getVariable('controller')->value=='message'){?>id="bodymailbox"<?php }?>>
	
	
		<div class="notify-bar notify-bar-warning" style="border-radius:0;display:none;">
			<div class="notify-bar-icon"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
notify/info.png" alt="info"  width="24" height="24"/></div>
			<div class="notify-bar-button<?php if ($_smarty_tpl->getVariable('hidenotifyclose')->value){?> hide<?php }?>"><a href="javascript:void(0);" onclick="javascript:$(this).parent().parent().fadeOut();" title="close"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
notify/close-btn.png" border="0" alt="close" /></a></div>
			<div class="notify-bar-text">
				Nếu bạn muốn thử chức năng Quản lý sản phẩm/thuộc tính/danh mục thì gởi Một Tin Nhắn Cá nhân (<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
message">Gởi Tin nhắn</a>) đến tài khoản VÕ HOÀNG LONG (A32) để được phân quyền. Nội dung là Danh mục bạn muốn quản lý.
			</div>
		</div>
		
		<?php $_template = new Smarty_Internal_Template("_controller/admin/header_topbar.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		
		<?php if ($_smarty_tpl->getVariable('controllerGroup')->value=='profile'&&$_smarty_tpl->getVariable('controller')->value=='message'){?>
			<div id="mailwrapper">
				<div id="mailcontainer">
					<div id="mailbox">
		<?php }else{ ?>
			<div class="container-fluid">
		  		<div class="row-fluid">
					<?php if ($_smarty_tpl->getVariable('controllerGroup')->value!='stat'){?>
						<?php $_template = new Smarty_Internal_Template("_controller/admin/header_leftmenu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
			
	        			<div class="span10" id="container">
					<?php }else{ ?>
						<div id="container" style="margin-left:0;">
					<?php }?>
		<?php }?>
