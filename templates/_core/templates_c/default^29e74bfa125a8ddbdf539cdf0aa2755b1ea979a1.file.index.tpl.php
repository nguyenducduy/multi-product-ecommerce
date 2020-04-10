<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:37:27
         compiled from "templates/default/_controller/profile/hovercard/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8298542095e8ec2a74e3173-13940816%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29e74bfa125a8ddbdf539cdf0aa2755b1ea979a1' => 
    array (
      0 => 'templates/default/_controller/profile/hovercard/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8298542095e8ec2a74e3173-13940816',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
?><div class="hovercard-user">
	<div class="hcu-left">
		<div class="hcu-avatar"><a href="<?php echo $_smarty_tpl->getVariable('myPartner')->value->getUserPath();?>
" title=""><img src="<?php echo $_smarty_tpl->getVariable('myPartner')->value->getSmallImage(1);?>
" /></a></div>
		<?php if ($_smarty_tpl->getVariable('myPartner')->value->id!=$_smarty_tpl->getVariable('me')->value->id){?>
		<div class="hcu-newmessage">
			<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
message/add?uid=<?php echo $_smarty_tpl->getVariable('myPartner')->value->id;?>
" onclick="$('.tipsy').remove();"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
button-send-message.png" alt="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['newmessage'];?>
" border="0" /></a>
		</div>
		<?php }?>
	</div>
	<div class="hcu-right">
		<div class="hcu-fullname"><a href="<?php echo $_smarty_tpl->getVariable('myPartner')->value->getUserPath();?>
"><?php echo $_smarty_tpl->getVariable('myPartner')->value->fullname;?>
</a></div>
		<div class="hcu-summary">
			<a href="<?php echo $_smarty_tpl->getVariable('myPartner')->value->getUserPath();?>
/following" title=""><?php echo $_smarty_tpl->getVariable('myPartner')->value->countFollowing;?>
 Following</a> &middot;
			<a href="<?php echo $_smarty_tpl->getVariable('myPartner')->value->getUserPath();?>
/follower" title=""><?php echo $_smarty_tpl->getVariable('myPartner')->value->countFollower;?>
 Follower</a> &middot;
		</div>
		
	
		<?php if ($_smarty_tpl->getVariable('totalMutualfriend')->value>0){?>
		<div class="hcu-mutual">
			<div class="hcu-label"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['sameHavePrefix'];?>
 <?php echo $_smarty_tpl->getVariable('totalMutualfriend')->value;?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['samefriendLabel'];?>
 <?php if ($_smarty_tpl->getVariable('mutualfriendlink')->value==1){?><a href="javascript:void(0);" onclick="$('.tipsy').remove();user_mutualdetail('<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
/recommendation/samefriendajax/<?php echo $_smarty_tpl->getVariable('myPartner')->value->id;?>
', '<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['mutualfrienddetail'];?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('myPartner')->value->fullname,"html");?>
')"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['viewAll'];?>
</a><?php }?></div>
			<div class="userlist">
				<?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('mutualfriendlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
?>
					<a href="<?php echo $_smarty_tpl->getVariable('user')->value->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('user')->value->fullname;?>
" class="user"><img src="<?php echo $_smarty_tpl->getVariable('user')->value->getSmallImage();?>
" /></a>
				<?php }} ?>
			</div>
		</div>
		<?php }?>
			
	</div>
	
</div>
<div class="clear"></div>