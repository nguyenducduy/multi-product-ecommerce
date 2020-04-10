<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:22:46
         compiled from "templates/default/_controller/index_shadowbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8648320325e8ecd46e3f7d1-40787962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6b98384e665aea6bd3261c7162564558457a5a2' => 
    array (
      0 => 'templates/default/_controller/index_shadowbox.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8648320325e8ecd46e3f7d1-40787962',
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
		
		<title><?php echo $_smarty_tpl->getVariable('lang')->value['default']['adminPanel'];?>
 &raquo; <?php echo (($tmp = @$_smarty_tpl->getVariable('pageTitle')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('lang')->value['default']['menuDashboard'] : $tmp);?>
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
		var controllerGroup = "<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
";
		var currentTemplate = "<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
";
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
    
    <body id="bodyshadowbox">
		<div id="containershadowbox">
	<?php echo $_smarty_tpl->getVariable('contents')->value;?>

	</div>
	</body>
</html>

	
	

