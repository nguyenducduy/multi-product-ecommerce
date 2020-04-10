<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:15
         compiled from "templates/default/_controller/profile/notification/refreshajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13069249665e8ec25ff29225-22228658%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f86e2c953eb6811e792be1be70a19552ec3e499b' => 
    array (
      0 => 'templates/default/_controller/profile/notification/refreshajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13069249665e8ec25ff29225-22228658',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo '<?xml';?> version="1.0" encoding="utf-8"<?php echo '?>';?>
<result>
	<notification><?php echo (($tmp = @$_smarty_tpl->getVariable('me')->value->newnotification)===null||$tmp==='' ? '' : $tmp);?>
</notification>
	<message><?php echo $_smarty_tpl->getVariable('me')->value->newmessage;?>
</message>
</result>