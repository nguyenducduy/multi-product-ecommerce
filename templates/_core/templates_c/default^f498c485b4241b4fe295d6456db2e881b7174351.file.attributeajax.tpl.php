<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:28
         compiled from "templates/default/_controller/cms/product/attributeajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6902702865e8ecc8009f804-59464276%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f498c485b4241b4fe295d6456db2e881b7174351' => 
    array (
      0 => 'templates/default/_controller/cms/product/attributeajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6902702865e8ecc8009f804-59464276',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table class="table">	
	<?php  $_smarty_tpl->tpl_vars['attributes'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['groupattr'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productAttributeList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attributes']->key => $_smarty_tpl->tpl_vars['attributes']->value){
 $_smarty_tpl->tpl_vars['groupattr']->value = $_smarty_tpl->tpl_vars['attributes']->key;
?>
		<?php $_smarty_tpl->tpl_vars["checker"] = new Smarty_variable("true", null, null);?>
		<?php if (count($_smarty_tpl->tpl_vars['attributes']->value)>0){?>
		<?php  $_smarty_tpl->tpl_vars['attr'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attr']->key => $_smarty_tpl->tpl_vars['attr']->value){
?>
		<tr>
			<?php if ($_smarty_tpl->getVariable('checker')->value=="true"){?>
			<td><b><?php echo $_smarty_tpl->tpl_vars['groupattr']->value;?>
</b></td>
			<?php $_smarty_tpl->tpl_vars["checker"] = new Smarty_variable("false", null, null);?>
			<?php }else{ ?>
			<td></td>
			<?php }?>
			<td><?php echo $_smarty_tpl->getVariable('attr')->value->name;?>
</td>
			<?php $_smarty_tpl->tpl_vars['attrid'] = new Smarty_variable($_smarty_tpl->getVariable('attr')->value->id, null, null);?>
			<td><?php if (count($_smarty_tpl->getVariable('attr')->value->values)>0){?>
				<select id="valuechoose<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
" name="fattr[<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
]" onchange="changevalueattr(<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
)" class="valuechoose" style="width: 200px;">
					<option value="-1" placeholder="Hoặc nhập giá trị khác">Giá trị khác</option>
					<?php  $_smarty_tpl->tpl_vars['valuedata'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attr')->value->values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['valuedata']->key => $_smarty_tpl->tpl_vars['valuedata']->value){
?>
					<option <?php if ($_smarty_tpl->getVariable('attr')->value->value==$_smarty_tpl->tpl_vars['valuedata']->value){?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['valuedata']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['valuedata']->value;?>
</option>
					<?php }} ?>
				</select>
				<?php }?><input id="valueoption<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
" type="text" name="fattropt[<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
]" placeholder="Hoặc nhập giá trị khác" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fattropt'][$_smarty_tpl->getVariable('attrid')->value];?>
">&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('attr')->value->unit;?>
</td>
			<td><input type="text" name="fweight[<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
]" placeholder="Trọng số" class="input-mini" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fweight'][$_smarty_tpl->getVariable('attrid')->value];?>
"/></td>
			<td><input type="text" name="fattrdescription[<?php echo $_smarty_tpl->getVariable('attr')->value->id;?>
]" placeholder="Mô tả" class="input-medium" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fattrdescription'][$_smarty_tpl->getVariable('attrid')->value];?>
"/></td>
			<td style="width:50px;"></td>
		<tr/>
		<?php }} ?>
		<?php }else{ ?>
		<tr>
			<td><b><?php echo $_smarty_tpl->tpl_vars['groupattr']->value;?>
</b></td>
			<td></td>
			<td></td>
			<td style="width:100px;"></td>
		<tr/>
		<?php }?>
	<?php }} ?>
</table>
<input type="hidden" name="fattributeloadajaxsuccess" value="1" />

<script type="text/javascript">
	$(document).ready(function(){
		$('.valuechoose').select2();
	});
</script>
