<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:11
         compiled from "templates/default/_controller/profile/userinfo/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16100642275e8ec25b1afd59-88233338%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b72563dea714fbce818b5fecc4535271c1f2abcf' => 
    array (
      0 => 'templates/default/_controller/profile/userinfo/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16100642275e8ec25b1afd59-88233338',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo '<?xml';?> version="1.0" encoding="utf-8"<?php echo '?>';?>
<result>
	<uid><?php echo $_smarty_tpl->getVariable('me')->value->id;?>
</uid>
	<userurl><?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
</userurl>
	<mygrouplist><![CDATA[
		<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('followGroupList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
			<li id="menu_group<?php echo $_smarty_tpl->getVariable('group')->value->id;?>
"><a href="<?php echo $_smarty_tpl->getVariable('group')->value->getUserPath();?>
"><i class="icon-group"></i><?php echo $_smarty_tpl->getVariable('group')->value->fullname;?>
</a></li>
		
		<?php }} ?>
		]]></mygrouplist>
	
</result>


