<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:10
         compiled from "templates/default/_controller/admin/maincontent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12074476195e8ec25ab6aa74-23602675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '948da8c970e02be616a49fb809aef4889e3848fa' => 
    array (
      0 => 'templates/default/_controller/admin/maincontent.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12074476195e8ec25ab6aa74-23602675',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_sslashes')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.sslashes.php';
?>
<?php echo (($tmp = @smarty_modifier_sslashes($_smarty_tpl->getVariable('contents')->value))===null||$tmp==='' ? "No contents" : $tmp);?>

