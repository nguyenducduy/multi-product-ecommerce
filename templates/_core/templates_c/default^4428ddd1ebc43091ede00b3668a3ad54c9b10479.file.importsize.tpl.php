<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:03
         compiled from "templates/default/_controller/cms/product/importsize.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2113325925e8ecc6709c544-33134976%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4428ddd1ebc43091ede00b3668a3ad54c9b10479' => 
    array (
      0 => 'templates/default/_controller/cms/product/importsize.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2113325925e8ecc6709c544-33134976',
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
    <li class="active">Import kích thước</li>
</ul>

<div class="page-header" rel="menu_product"><h1>Import kích thước sản phẩm</h1></div>

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