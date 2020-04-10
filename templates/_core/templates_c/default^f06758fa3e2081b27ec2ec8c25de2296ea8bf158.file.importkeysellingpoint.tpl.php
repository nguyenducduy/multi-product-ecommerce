<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:00
         compiled from "templates/default/_controller/cms/product/importkeysellingpoint.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10915433205e8ecc64bd41d9-16520701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f06758fa3e2081b27ec2ec8c25de2296ea8bf158' => 
    array (
      0 => 'templates/default/_controller/cms/product/importkeysellingpoint.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10915433205e8ecc64bd41d9-16520701',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<ul class="breadcrumb">
    <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['menudashboard'];?>
</a> <span class="divider">/</span></li>
    <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
">Sản phẩm</a> <span class="divider">/</span></li>
    <li class="active">Import Key Selling Point</li>
</ul>

<div class="page-header" rel="menu_product"><h1>Import Key Selling Point</h1></div>

<div class="navgoback"><a href="<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['formBackLabel'];?>
</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->getVariable('formData')->value['productpath'];?>
" target="_blank">Xem sản phẩm trên web</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
	<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value);$_template->assign('notifyWarning',$_smarty_tpl->getVariable('warning')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<div class="control-group">
		<label class="control-label" for="fvsubid">File</label>
		<div class="controls">
			<input type="file" id="ffile" name="ffile" />
		</div>
	</div> 
	<div class="form-actions" id="submitallbutton">
		<input type="submit" name="fsubmit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formUpdateSubmit'];?>
" class="btn btn-large btn-primary" />
	</div>
</form>