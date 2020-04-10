<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:04
         compiled from "templates/default/_controller/cms/product/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9050607965e8ecc68e878a6-12488424%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f33378fd16599f0910dcd49186963e4025afd638' => 
    array (
      0 => 'templates/default/_controller/cms/product/add.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9050607965e8ecc68e878a6-12488424',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<ul class="breadcrumb">
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['menudashboard'];?>
</a> <span class="divider">/</span></li>
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</li>
</ul>

<div class="page-header" rel="menu_product"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</h1></div>

<div class="navgoback"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['formBackLabel'];?>
</a></div>
<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<form action="" method="post" name="myform" class="form-horizontal">
	<h1>Vui lòng chọn danh mục sản phẩm</h1>
	<div class="control-group">
		<label class="control-label" for="fpcid"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
 <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcid" id="fpcid"  style="width:200px;">
			<?php  $_smarty_tpl->tpl_vars['productCategory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productcategoryList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productCategory']->key => $_smarty_tpl->tpl_vars['productCategory']->value){
?>
			<?php if ($_smarty_tpl->getVariable('productCategory')->value->parentid==0){?>
				</optgroup><optgroup label="<?php echo $_smarty_tpl->getVariable('productCategory')->value->name;?>
">
			<?php }else{ ?>
				<option value="<?php echo $_smarty_tpl->getVariable('productCategory')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('productCategory')->value->name;?>
</option>
			<?php }?>
			<?php }} ?>
			</select>
		</div>
	</div>
	<!-- <div class="control-group" id="child" style="display:none">
		<label class="control-label" for="fpcid1"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid1'];?>
 <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcid1" id="fpcid1" style="width:200px;">
			</select>
		</div>
	</div> -->
	<input type="submit" name="fsubmitNext" value="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelNext'];?>
" class="btn btn-large btn-primary" style="float:right;" />
</form>

<script type="text/javascript">
function changeFunction()
{
	pcat = $('#fpcid').val();
	dataString = 'fpcid=' + pcat;
	url = '/cms/product/indexAjax';
	$.ajax({
		type : "POST",
		data : dataString,
		url : url,
		success: function(data){
			if(data != ''){
				$('#child').fadeIn();
				$('#fpcid1').find('option')
			    .remove()
			    .end().append(data);
			}
			else{
				$('#child').fadeOut();
				$('#fpcid1').find('option')
			    .remove()
			    .end()
			}
		}
	});
}
$(document).ready(function(){
	$("#fpcid").select2();
	$("#fpcid1").select2();

	pcat = $('#fpcid').val();
	dataString = 'fpcid=' + pcat;
	url = '/cms/product/indexAjax';
	$.ajax({
		type : "POST",
		data : dataString,
		url : url,
		success: function(data){
			if(data != ''){
				$('#child').fadeIn();
				$('#fpcid1').find('option')
			    .remove()
			    .end().append(data);
			}
			else{
				$('#child').fadeOut();
				$('#fpcid1').find('option')
			    .remove()
			    .end()
			}
		}
	});
});
</script>


