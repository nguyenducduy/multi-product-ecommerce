<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:44:16
         compiled from "templates/default/_controller/site/product/loadpormotionlistajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1930502795e8ec440608ec9-64091085%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '277e9fc2a1c70c554a36fba1b4ecdf8ecd09e259' => 
    array (
      0 => 'templates/default/_controller/site/product/loadpormotionlistajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1930502795e8ec440608ec9-64091085',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!empty($_smarty_tpl->getVariable('listpromotionbypromotionids',null,true,false)->value)){?>
		<?php  $_smarty_tpl->tpl_vars['promotioninfo'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['promoide'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listpromotionbypromotionids')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['promotioninfo']->key => $_smarty_tpl->tpl_vars['promotioninfo']->value){
 $_smarty_tpl->tpl_vars['promoide']->value = $_smarty_tpl->tpl_vars['promotioninfo']->key;
?>
			<div class="gift-1 giftids" <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?>style="color:#444"<?php }?> id="<?php echo $_smarty_tpl->tpl_vars['promoide']->value;?>
"<?php if (trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['promotioninfo']->value['promoname']))=='-'||trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['promotioninfo']->value['promoname']))=='.'||trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['promotioninfo']->value['promoname']))=='&nbsp;'){?> style="display: none;"<?php }?>>
				<?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus!=$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->tpl_vars['promotioninfo']->value['disablegift']==1){?><i class="icon-gift"></i><?php }?>
				<input class="giftopt promotions<?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value)&&$_smarty_tpl->getVariable('parentpromotionprices')->value['promoid']==$_smarty_tpl->tpl_vars['promoide']->value&&trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['promotioninfo']->value['promoname']))!='-'&&trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['promotioninfo']->value['promoname']))!='.'){?> activefirst<?php }?>" name="giftpromo" type="radio" value="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
_<?php echo $_smarty_tpl->tpl_vars['promoide']->value;?>
" style="display:none"/><?php echo $_smarty_tpl->tpl_vars['promotioninfo']->value['promoname'];?>
</div>
		<?php }} ?>
<?php }else{ ?>
	<?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&!empty($_smarty_tpl->getVariable('productDetail',null,true,false)->value->prepaidpromotion)){?>
		<?php echo $_smarty_tpl->getVariable('productDetail')->value->prepaidpromotion;?>

	<?php }else{ ?>
		
			<script type="text/javascript">
				if($('.titinfo').length > 0)
				{
					$('.titinfo').first().remove();
					$('.infogift_pre').remove();
					$('.infodesc_pre').css('border-left','none');
				}
			</script>
		
	<?php }?>
<?php }?>