<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:22:46
         compiled from "templates/default/_controller/profile/group/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5241739715e8ecd46df0633-43007220%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7cd3a41cb391b367deefb95e64e31a7b5cacd1b5' => 
    array (
      0 => 'templates/default/_controller/profile/group/add.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5241739715e8ecd46df0633-43007220',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="page-header" rel="menu_file"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</h1></div>


<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="<?php echo $_SESSION['groupAddToken'];?>
" />


	<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	

	<div class="control-group">
		<label class="control-label" for="fname"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
 <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fbio"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDescription'];?>
</label>
		<div class="controls">
			<textarea name="fbio" id="fbio" class="input-xxlarge" rows="8"><?php echo $_smarty_tpl->getVariable('formData')->value['fbio'];?>
</textarea>
	</div>

	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formCreateSubmit'];?>
" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formRequiredLabel'];?>
</span>
	</div>	
	
</form>

<?php if (count($_smarty_tpl->getVariable('success')->value)>0){?>
<script type="text/javascript">
	$(document).ready(function(){
		self.parent.location.href = "<?php echo $_smarty_tpl->getVariable('successGroupUrl')->value;?>
";
	});
</script>
<?php }?>


