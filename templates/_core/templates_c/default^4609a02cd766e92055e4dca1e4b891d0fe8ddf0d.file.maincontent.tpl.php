<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:37:48
         compiled from "templates/default/_controller/site/maincontent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1363499075e8ec2bcd00468-57631402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4609a02cd766e92055e4dca1e4b891d0fe8ddf0d' => 
    array (
      0 => 'templates/default/_controller/site/maincontent.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1363499075e8ec2bcd00468-57631402',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_sslashes')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.sslashes.php';
?><?php echo (($tmp = @smarty_modifier_sslashes($_smarty_tpl->getVariable('contents')->value))===null||$tmp==='' ? "No contents" : $tmp);?>
