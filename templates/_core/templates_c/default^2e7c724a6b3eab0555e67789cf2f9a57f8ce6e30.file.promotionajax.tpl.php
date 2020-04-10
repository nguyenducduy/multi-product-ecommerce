<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:28
         compiled from "templates/default/_controller/cms/product/promotionajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19215680555e8ecc80348261-69499026%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e7c724a6b3eab0555e67789cf2f9a57f8ce6e30' => 
    array (
      0 => 'templates/default/_controller/cms/product/promotionajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19215680555e8ecc80348261-69499026',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.html_options.php';
?><?php if (count($_smarty_tpl->getVariable('listpromotions')->value)>0){?>
            		<table class="table">
                    <thead>
                        <tr>
                        	<th></th>
                            <th>Promotion ID</th>
                            <th>Promotion Name</th>
                            <th>Tỉnh</th>
                            <th>Show giá gạch</th>
                            <th>Trạng thái khuyến mãi</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
            		<?php  $_smarty_tpl->tpl_vars['promotion'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['rid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listpromotions')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['promotion']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['promotion']->key => $_smarty_tpl->tpl_vars['promotion']->value){
 $_smarty_tpl->tpl_vars['rid']->value = $_smarty_tpl->tpl_vars['promotion']->key;
 $_smarty_tpl->tpl_vars['promotion']->index++;
 $_smarty_tpl->tpl_vars['promotion']->first = $_smarty_tpl->tpl_vars['promotion']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['first'] = $_smarty_tpl->tpl_vars['promotion']->first;
?>                       
            			<?php if (!empty($_smarty_tpl->tpl_vars['promotion']->value['promotion'])){?>
            			<?php  $_smarty_tpl->tpl_vars['promo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['promotion']->value['promotion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['promo']->key => $_smarty_tpl->tpl_vars['promo']->value){
?>
                        <?php $_smarty_tpl->tpl_vars["displaystatus"] = new Smarty_variable(($_smarty_tpl->tpl_vars['promo']->value).".promoid", null, null);?>
            			<tr>
            				<td><input type="checkbox" name="fapplyprid[<?php echo $_smarty_tpl->tpl_vars['rid']->value;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['promo']->value['promoid'];?>
" <?php if (count($_smarty_tpl->getVariable('applypromotionlist')->value)>0){?>
            					<?php  $_smarty_tpl->tpl_vars['prid'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['reid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('applypromotionlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['prid']->key => $_smarty_tpl->tpl_vars['prid']->value){
 $_smarty_tpl->tpl_vars['reid']->value = $_smarty_tpl->tpl_vars['prid']->key;
?>
            					<?php if ($_smarty_tpl->tpl_vars['prid']->value==$_smarty_tpl->tpl_vars['promo']->value['promoid']&&$_smarty_tpl->tpl_vars['rid']->value==$_smarty_tpl->tpl_vars['reid']->value){?>
            						checked="checked"
            					<?php }?>
            					<?php }} ?>
            					<?php }else{ ?>checked="checked"<?php }?> /></td>
            				<td><?php echo $_smarty_tpl->tpl_vars['promo']->value['promoid'];?>
</td>
            				<td><?php echo $_smarty_tpl->tpl_vars['promo']->value['promoname'];?>
</td>
            				<td><?php echo $_smarty_tpl->tpl_vars['promotion']->value['regionname'];?>
</td>
            				<td><?php if (!empty($_smarty_tpl->getVariable('listcurrentpromotion',null,true,false)->value[$_smarty_tpl->tpl_vars['rid']->value])&&$_smarty_tpl->getVariable('listcurrentpromotion')->value[$_smarty_tpl->tpl_vars['rid']->value]==$_smarty_tpl->tpl_vars['promo']->value['promoid']){?><span class="label label-warning">YES</span><?php }?></td>
                            <td>
                            <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['first']||$_smarty_tpl->tpl_vars['promo']->value['promoid']==$_smarty_tpl->getVariable('displaystatus')->value){?>  
                                 <?php $_smarty_tpl->tpl_vars["displaystatus"] = new Smarty_variable(($_smarty_tpl->tpl_vars['promo']->value).".promoid", null, null);?>
                                <select name="<?php echo $_smarty_tpl->tpl_vars['promo']->value['promoid'];?>
" class="promotionstatus"><!--fstatuspromo[-->
                                   	<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('promostatusList')->value,'selected'=>$_smarty_tpl->tpl_vars['promo']->value['promotionstatus']),$_smarty_tpl);?>

                                    <?php $_smarty_tpl->tpl_vars["displaystatus"] = new Smarty_variable("0", null, null);?>
                                </select>
                            <?php }?>
                            </td>
            				<td></td>                            
            			</tr>
            			<?php }} ?>
            			<?php }?>
            		<?php }} ?>
            			<tr><td colspan="2" align="center">
            				<input type="button" id="fsubmitpromotion" name="fsubmitpromotion" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formUpdateSubmit'];?>
" class="btn btn-large btn-primary" />
            			</td></tr>
            		</tbody>
            		</table>
            	<?php }else{ ?>
            	Sản phẩm này hiện thời không có chương trình khuyến mãi nào.
            	<?php }?>
