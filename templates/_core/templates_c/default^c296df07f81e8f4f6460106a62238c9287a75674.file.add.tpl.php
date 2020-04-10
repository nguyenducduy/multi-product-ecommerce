<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:22:53
         compiled from "templates/default/_controller/profile/file/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16149292175e8ecd4d9bcae8-44680695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c296df07f81e8f4f6460106a62238c9287a75674' => 
    array (
      0 => 'templates/default/_controller/profile/file/add.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16149292175e8ecd4d9bcae8-44680695',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="page-header" rel="menu_file"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</h1></div>


<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="<?php echo $_SESSION['fileAddToken'];?>
" />


	<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
	

	<div class="control-group">
		<label class="control-label" for="fname">File Upload</label>
		<div class="controls"><input type="file" name="ffile" id="ffile" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsummary"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSummary'];?>
</label>
		<div class="controls">
			<textarea name="fsummary" id="fsummary" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fsummary'];?>
</textarea>
	</div>

	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="Upload" class="btn btn-large btn-primary" />
	</div>	
	
</form>

<?php if (count($_smarty_tpl->getVariable('success')->value)>0){?>
<script type="text/javascript">
	$(document).ready(function(){
		self.parent.location.reload(false);
	});
</script>
<?php }?>


