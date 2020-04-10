<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:22
         compiled from "templates/default/_controller/cms/product/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1522609455e8ecc7acd9b19-51528034%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'beaa87436688139742e65c13da9dc06eaa833e86' => 
    array (
      0 => 'templates/default/_controller/cms/product/edit.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1522609455e8ecc7acd9b19-51528034',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_date_format')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.date_format.php';
?><ul class="breadcrumb">
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['menudashboard'];?>
</a> <span class="divider">/</span></li>
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_edit'];?>
</li>
</ul>

<div class="page-header" rel="menu_product"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_edit'];?>
</h1></div>

<div class="navgoback"><a href="<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['formBackLabel'];?>
</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->getVariable('formData')->value['productpath'];?>
?live" target="_blank">Xem sản phẩm trên web</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<!-- <input type="hidden" name="ftoken" value="<?php echo $_SESSION['productEditToken'];?>
" /> -->
 <input type="hidden" name="ftab" id="ftab" value="<?php echo $_smarty_tpl->getVariable('formData')->value['ftab'];?>
" />


	<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==1){?>class="active"<?php }?>><a onclick="changeTab('1')" href="#tab1" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['productInfo'];?>
</a></li>
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==2){?>class="active"<?php }?>><a onclick="changeTab('2')" href="#tab2" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['attributeInfo'];?>
</a></li>
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==3){?>class="active"<?php }?>><a onclick="changeTab('3')" href="#tab3" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['mediaInfo'];?>
</a></li>
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==4){?>class="active"<?php }?> ><a onclick="changeTab('4');activeAcc()" href="#tab4" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['accessories'];?>
</a></li>
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==5){?>class="active"<?php }?> id="sampletab"><a onclick="changeTab('5');activeRec()" href="#tab5" data-toggle="tab" ><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['sample'];?>
</a></li>
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==7){?>class="active"<?php }?>><a onclick="changeTab('7')" href="#tab7" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['product2'];?>
</a></li>
			<li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==8){?>class="active"<?php }?>><a onclick="changeTab('8')" href="#tab8" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['product3'];?>
</a></li>
			<?php if ($_smarty_tpl->getVariable('category')->value->parent[0]['pc_id']==482){?><li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==9){?>class="active"<?php }?>><a onclick="changeTab('9')" href="#tab9" data-toggle="tab">Sản phẩm bán kèm</a></li><?php }?>
            <li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==6){?>class="active"<?php }?>><a onclick="changeTab('6')" href="#tab6" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['color'];?>
</a></li>
            <li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==10){?>class="active"<?php }?>><a onclick="changeTab('10')" href="#tab10" data-toggle="tab">Khuyến mãi</a></li>
            <li <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==11){?>class="active"<?php }?>><a onclick="changeTab('11')" href="#tab11" data-toggle="tab">Banner nổi bật</a></li>

		</ul>
		<div class="tab-content">
			<div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==1){?>active<?php }?>" id="tab1">
				<input type="hidden" name="fid" id="fid" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
" />
				<div class="control-group">
					<label class="control-label" for="fvid"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelVsubid'];?>
</label>
					<div class="controls"><select name="fvid" id="fvid">
						<option value="0">----</option>
						<?php  $_smarty_tpl->tpl_vars['vendor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('vendorList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vendor']->key => $_smarty_tpl->tpl_vars['vendor']->value){
?>
							<option value="<?php echo $_smarty_tpl->getVariable('vendor')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('vendor')->value->id==$_smarty_tpl->getVariable('formData')->value['fvid']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('vendor')->value->name;?>
</option>
						<?php }} ?>
						</select>
                    </div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fvsubid"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelVid'];?>
</label>
					<div class="controls">
						<select name="fvsubid" id="fvsubid">
						<option value="0">----</option>
						<?php  $_smarty_tpl->tpl_vars['vendor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subVendorList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vendor']->key => $_smarty_tpl->tpl_vars['vendor']->value){
?>
							<option value="<?php echo $_smarty_tpl->getVariable('vendor')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('vendor')->value->id==$_smarty_tpl->getVariable('formData')->value['fvsubid']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('vendor')->value->name;?>
</option>
						<?php }} ?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fpcid"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
 <span class="star_require">*</span></label>
					<div class="controls">
						<input type="hidden" name="fpcid" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fpcid'];?>
" />
						<?php  $_smarty_tpl->tpl_vars['productCategory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productcategoryList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productCategory']->key => $_smarty_tpl->tpl_vars['productCategory']->value){
?>
							<?php if ($_smarty_tpl->getVariable('formData')->value['fpcid']==$_smarty_tpl->getVariable('productCategory')->value->id){?>
								<b><?php echo $_smarty_tpl->getVariable('productCategory')->value->name;?>
</b>&nbsp;&nbsp;&nbsp;
								<a href="javascript:void(0)" onclick="changecategory(<?php echo $_smarty_tpl->getVariable('formData')->value['fpcid'];?>
 , <?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
)">Thay đổi</a>
							<?php }?>
						<?php }} ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fbarcode"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelBarcode'];?>
</label>
					<div class="controls"><input type="text" name="fbarcode" id="fbarcode" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fbarcode']);?>
" class="input-xxlarge"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fname"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</label>
					<div class="controls"><input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fname']);?>
" class="input-xxlarge"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fslug"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSlug'];?>
</label>
					<div class="controls"><input type="text" name="fslug" id="fslug" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fslug']);?>
" class="input-xxlarge" />
						<?php if (count($_smarty_tpl->getVariable('slugList')->value)>0){?>
							<div class="">Found item for slug "<?php echo $_smarty_tpl->getVariable('formData')->value['fslug'];?>
":</div>
							<?php  $_smarty_tpl->tpl_vars['slug'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('slugList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['slug']->key => $_smarty_tpl->tpl_vars['slug']->value){
?>
								<?php if ($_smarty_tpl->getVariable('slug')->value->controller!='product'||$_smarty_tpl->getVariable('slug')->value->objectid!=$_smarty_tpl->getVariable('formData')->value['fid']){?><div class="red">&raquo; <?php echo $_smarty_tpl->getVariable('slug')->value->controller;?>
 / <?php echo $_smarty_tpl->getVariable('slug')->value->objectid;?>
 <a href="<?php echo $_smarty_tpl->getVariable('slug')->value->getSlugSearch();?>
" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div><?php }?>
							<?php }} ?>
						<?php }?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fname">Màu sản phẩm</label>
					<div class="controls">
						<select id="fpchoosecolor" name="fpchoosecolor">
							<option <?php if ($_smarty_tpl->getVariable('formData')->value['fpchoosecolor']=="kxd"){?>selected="selected"<?php }?> value="kxd">Màu không xác định</option>
							<option <?php if ($_smarty_tpl->getVariable('formData')->value['fpchoosecolor']=="-1"){?>selected="selected"<?php }?> value="-1">Chọn màu</option>
						</select>
						<div class="btn-group" style="display:none;vertical-align:top;" id="groupcolor">
							<input type="tet" class="input-large" name="fpcolorname" id="fpcolorname" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fpcolorname'];?>
" placeholder="Tên màu..." />&nbsp;&nbsp;
							<a class="btn btn-info dropdown-toggle" data-toggle="dropdown">Color</a>
						  	<ul class="dropdown-menu">
						    	<li><div id="colorpalette1"></div></li>
						  	</ul><br/>
						 	<input id="fpcolorstring" name="fpcolorstring" readonly="readonly" value="<?php if ($_smarty_tpl->getVariable('formData')->value['fpcolorstring']!=''){?>#<?php }?><?php echo $_smarty_tpl->getVariable('formData')->value['fpcolorstring'];?>
">						  	
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fcontent"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelContent'];?>
</label>
					<div class="controls"><textarea name="fcontent" id="fcontent" rows="7" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fcontent'];?>
</textarea></div>
					<?php $_template = new Smarty_Internal_Template("tinymce.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
				</div>

				<div class="control-group">
					<label class="control-label" for="fsummary"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSummary'];?>
</label>
					<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="mceNoEditor input-xxlarge" readonly="readonly"><?php echo $_smarty_tpl->getVariable('formData')->value['fsummary'];?>
</textarea></div>
					<br/>
					<div class="controls">
						<?php if (!empty($_smarty_tpl->getVariable('formData',null,true,false)->value['fsummarynew'])){?>
						<?php  $_smarty_tpl->tpl_vars['summarydata'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('formData')->value['fsummarynew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['summarydata']->key => $_smarty_tpl->tpl_vars['summarydata']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>
						<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']<5){?>
						<input id="fsummarynew_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index'];?>
" name="fsummarynew[<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['summarydata']->value;?>
" class="input-xxlarge" /><br/><br/>
						<?php }?>
						<?php }} ?>
						<?php if (count($_smarty_tpl->getVariable('formData')->value['fsummarynew'])<5){?>						
							<?php $_smarty_tpl->tpl_vars['enough'] = new Smarty_variable(5-count($_smarty_tpl->getVariable('formData')->value['fsummarynew']), null, null);?>
							<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['name'] = 'foo1';
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('enough')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['foo1']['total']);
?>
							<input id="fsummarynew_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index'];?>
" name="fsummarynew[<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['foo1']['index']+count($_smarty_tpl->getVariable('formData')->value['fsummarynew']);?>
]" value="" class="input-xxlarge" /><br/><br/>							
							<?php endfor; endif; ?>
						<?php }?>
						<?php }else{ ?>
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['name'] = 'foo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total']);
?>
						<input id="fsummarynew_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['index'];?>
" name="fsummarynew[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['index'];?>
]" value="<?php echo $_smarty_tpl->getVariable('summarydata')->value;?>
" class="input-xxlarge" /><br/><br/>
						<?php endfor; endif; ?>
						<?php }?>
					</div>
				</div>				

				<div class="control-group">
					<label class="control-label" for="fsummary"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelGood'];?>
</label>
					<div class="controls"><textarea name="fgood" id="fgood" rows="7" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fgood'];?>
</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fsummary"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelBad'];?>
</label>
					<div class="controls"><textarea name="fbad" id="fbad" rows="7" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fbad'];?>
</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fdienmayreview"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDienmayreview'];?>
</label>
					<div class="controls"><textarea name="fdienmayreview" id="fdienmayreview" rows="7" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fdienmayreview'];?>
</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="ffullbox"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelFullbox'];?>
</label>
					<div class="controls"><textarea name="ffullbox" id="ffullbox" rows="7" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['ffullbox'];?>
</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="ffullboxshort">Tóm tắt bộ báng hàng chuẩn</label>
					<div class="controls"><textarea name="ffullboxshort" id="ffullboxshort" rows="7" class="mceNoEditor input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['ffullboxshort'];?>
</textarea></div>
				</div>

				<!-- <div class="control-group">
					<label class="control-label" for="flaigopauto"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labellaigopauto'];?>
</label>
					<div class="controls"><?php echo $_smarty_tpl->getVariable('formData')->value['flaigop'];?>
</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="flaigop"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labellaigop'];?>
</label>
					<div class="controls"><input type="text" name="flaigop" id="flaigop" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['flaigop']);?>
" class="input-xlarge"></div>
				</div> -->

				<div class="control-group">
					<label class="control-label" for="fseotitle"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSeotitle'];?>
</label>
					<div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fseotitle'];?>
" class="input-xxlarge"/></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseokeyword"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSeokeyword'];?>
</label>
					<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="mceNoEditor input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fseokeyword'];?>
</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseodescription">SEO Description</label>
					<div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['fseodescription'];?>
</textarea></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fseodescription">Keyword</label>
					<div class="controls"><input name="fkeyword" id="tags_keyword" type="text" class="tags" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fkeyword'];?>
" /></p></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fcanonical"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCanonical'];?>
</label>
					<div class="controls"><input type="text" name="fcanonical" id="fcanonical" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fcanonical'];?>
" class="input-xxlarge"/></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fmetarobot">Metarobot</label>
					<div class="controls"><input type="text" name="fmetarobot" id="fmetarobot" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fmetarobot'];?>
" class="input-xxlarge"/></div>
				</div>

				<div class="control-group">
			        <label class="control-label" for="ftopseokeyword">Top SEO keyword</label>
			        <div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class=" input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['ftopseokeyword'];?>
</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
			    </div>

			    <div class="control-group">
			        <label class="control-label" for="ftextfooter">Text footer</label>
			        <div class="controls"><textarea name="ftextfooter" id="ftextfooter" rows="7" class="input-xxlarge"><?php echo $_smarty_tpl->getVariable('formData')->value['ftextfooter'];?>
</textarea></div>
			    </div>

				<div class="control-group" id="sellprice">
					<label class="control-label" for="fsellprice"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</label>
					<div class="controls"><input type="text" name="fsellprice" id="fsellprice" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fsellprice']);?>
" class="input-medium" readonly>&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
&nbsp;&nbsp;&nbsp;
						<a id="viewsellprice" href="javascript:void(0)" onclick="viewShadowbox('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
productprice/index/pbarcode/<?php echo $_smarty_tpl->getVariable('formData')->value['fbarcode'];?>
' , '', 'giá')">Xem chi tiết</a>&nbsp;&nbsp;
						<a href="javascript:void(0)" onclick="viewShadowbox('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
productprice/index/pbarcode/<?php echo $_smarty_tpl->getVariable('formData')->value['fbarcode'];?>
/tab/2' , '', 'giá')">Giá đối thủ</a>
					</div>
				</div>

<!--				<div class="control-group">-->
<!--					<label class="control-label" for="fdiscountpercent"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDiscountPercent'];?>
</label>-->
<!--					<div class="controls"><input type="text" name="fdiscountpercent" id="fdiscountpercent" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fdiscountpercent']);?>
" class="input-mini" readonly>&nbsp;(%)</div>-->
<!--				</div>-->

				<!--<div class="control-group">
					<label class="control-label" for="fisbagdehot"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdehot'];?>
</label>
					<div class="controls"><input type="checkbox" value="1" name="fisbagdehots" id="fisbagdehot" <?php if ($_smarty_tpl->getVariable('formData')->value['fisbagdehot']>0){?>checked="checked"<?php }?>></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisbagdenew"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdenew'];?>
</label>
					<div class="controls"><input type="checkbox" value="1" name="fisbagdenews" id="fisbagdenew" <?php if ($_smarty_tpl->getVariable('formData')->value['fisbagdenew']>0){?>checked="checked"<?php }?>></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisbagdegift"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdegift'];?>
</label>
					<div class="controls"><input type="checkbox" value="1" name="fisbagdegifts" id="fisbagdegift" <?php if ($_smarty_tpl->getVariable('formData')->value['fisbagdegift']>0){?>checked="checked"<?php }?>></div>
				</div>-->

				<div class="control-group">
					<label class="control-label" for="fdisplaysellprice"> Hiển thị giá niêm yết </label>
					<div class="controls"><input type="checkbox" name="fdisplaysellprice" id="fdisplaysellprice" value="1" <?php if ($_smarty_tpl->getVariable('formData')->value['fdisplaysellprice']>0){?>checked="checked"<?php }?>></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fwarranty">Bảo hành</label>
					<div class="controls"><input type="text" class="input-mini" name="fwarranty" id="fwarranty" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fwarranty'];?>
">&nbsp;Tháng</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fpwidth">Chiều dài x Chiều rộng x Chiều cao</label>
					<div class="controls"><input type="text" class="input-mini" name="fpwidth" id="fpwidth" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fpwidth'];?>
"> x <input type="text" class="input-mini" name="fplength" id="fplength" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fplength'];?>
"> x <input type="text" class="input-mini" name="fpheight" id="fpheight" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fpheight'];?>
">cm</div>					
				</div>

				<div class="control-group">
					<label class="control-label" for="fpweight">Khối lượng</label>
					<div class="controls"><input type="text" class="input-mini" name="fpweight" id="fpweight" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fpweight'];?>
">kg</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="ftransporttype">Vận chuyển</label>
					<div class="controls">
						<select name="ftransporttype">
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('transporttypeList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['ftransporttype']),$_smarty_tpl);?>

						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fsetuptype">Lắp đặt</label>
					<div class="controls">
						<select name="fsetuptype">
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('setuptypeList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fsetuptype']),$_smarty_tpl);?>

						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="finstock"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstock'];?>
</label>
					<div class="controls"><input type="text" name="finstock" id="finstock" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['finstock']);?>
" class="input-mini" readonly>&nbsp;
						<?php if ($_smarty_tpl->getVariable('formData')->value['fbarcode']!=''){?>
							<a href="javascript:void(0)" onclick="viewShadowbox('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
productstock/index/pbarcode/<?php echo $_smarty_tpl->getVariable('formData')->value['fbarcode'];?>
' , '<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
' , 'tồn kho')">Xem chi tiết</a>
						<?php }?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fdisplayorder"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDisplayorder'];?>
</label>
					<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fdisplayorder']);?>
" class="input-mini"></div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="fdisplaymanual">Hiển thị manual</label>
					<div class="controls"><input type="text" name="fdisplaymanual" id="fdisplaymanual" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fdisplaymanual']);?>
" class="input-mini"></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fdisplaytype">Loại hiển thị</label>
					<div class="controls">
						<select name="fdisplaytype">
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('displaytypeList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fdisplaytype']),$_smarty_tpl);?>

						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fstatus"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStatus'];?>
</label>
					<div class="controls"><select name="fstatus">
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('statusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fstatus']),$_smarty_tpl);?>

						</select></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fstatus"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelOnsiteStatus'];?>
</label>
					<div class="controls">
						<select name="fonsitestatus" id="fonsitestatus" onchange="changeonistestatus()">
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('onsitestatusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fonsitestatus']),$_smarty_tpl);?>

						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fbusinessstatus">Trạng thái kinh doanh</label>
					<div class="controls">
						<select name="fbusinessstatus" disabled>
							<option value="0">Không xác định</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('businessstatusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fbusinessstatus']),$_smarty_tpl);?>

						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fisrequestimei">Yêu cầu IMEI</label>
					<div class="controls">
						<select name="fisrequestimei">
							<option <?php if ($_smarty_tpl->getVariable('formData')->value['fisrequestimei']==1){?>selected="selected"<?php }?> value="1">Có</option>							
							<option <?php if ($_smarty_tpl->getVariable('formData')->value['fisrequestimei']==0){?>selected="selected"<?php }?> value="0">Không</option>							
						</select>
					</div>
				</div>
				<div id="osprepaid" <?php if ($_smarty_tpl->getVariable('formData')->value['fonsitestatus']!=2){?>style="display: none;"<?php }?>>
                <div class="control-group"  id="prepaidprice">
                    <label class="control-label" for="fprepaidprice">Giá đặt hàng trước</label>
                    <div class="controls"><input type="text" name="fprepaidprice" id="fprepaidprice" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fprepaidprice']);?>
" class="input-medium">&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
</div>
                </div>
			    <!-- dat hang truoc -->
			    <div class="control-group">
			        <label class="control-label" for="">Thời gian đặt hàng trước</label>
			        <div class="controls">
			        	<lable style="margin-right:20px">Từ</lable>
			        	<div class="input-append bootstrap-timepicker">
				            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fsttime'];?>
" class="input-small timepicker">
				            <span class="add-on"><i class="icon-time"></i></span>
			        	</div> 
			        	<input class='inputdatepicker' type="text" name="fprepaidstartdate" id="fprepaidstartdate" value="<?php if ($_smarty_tpl->getVariable('formData')->value['fprepaidstartdate']>0){?><?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fprepaidstartdate']);?>
<?php }?>" > 
			        </div>
			        <div class="controls" style="margin-top:10px">
			        	<lable style="margin-right:12px">Đến</lable> 
			        	<div class="input-append bootstrap-timepicker">
				            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fextime'];?>
" class="input-small timepicker">
				            <span class="add-on"><i class="icon-time"></i></span>
		        		</div>
			        	<input class='inputdatepicker' type="text" name="fprepaidenddate" id="fprepaidenddate" value="<?php if ($_smarty_tpl->getVariable('formData')->value['fprepaidenddate']>0){?><?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fprepaidenddate']);?>
<?php }?>" >
			        </div>
			    </div>
				    <div class="control-group">
				        <label class="control-label" for="">Tên chương trình đặt trước</label>
				        <div class="controls">
				        	<input type="text" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fprepaidname'];?>
" name="fprepaidname" class="input input-xxlarge" id="fprepaidname" />
				        </div>
				    </div>
				      <div class="control-group">
				        <label class="control-label" for="">Khuyến mãi</label>
				        <div class="controls">
				        	<textarea name="fprepaidpromotion" id="fprepaidpromotion" class="input input-xxlarge mceNoEditor" rows="5"><?php echo $_smarty_tpl->getVariable('formData')->value['fprepaidpromotion'];?>
</textarea>
				        </div>
				    </div>
				    <div class="control-group">
				        <label class="control-label" for="prepaidpolicy">Chính sách bán hàng</label>
				        <div class="controls">
				        	<textarea name="fprepaidpolicy" id="fprepaidpolicy" class="input input-xxlarge mceNoEditor" rows="5"><?php echo $_smarty_tpl->getVariable('formData')->value['fprepaidpolicy'];?>
</textarea>
				        </div>
				    </div>

				     <div class="control-group">
				        <label class="control-label" for="">Số lượng hàng đặt được</label>
				        <div class="controls">
				        	<input type="text" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fprepaidrand'];?>
" name="fprepaidrand" class="input input-xlarge" id="fprepaidrand" />
				        </div>
				    </div>

				    <div class="control-group">
				        <label class="control-label" for="">Yêu cầu đặt cọc</label>
				        <div class="controls">
				        	<input type="text" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fprepaiddepositrequire']);?>
" name="fprepaiddepositrequire" class="input input-xlarge" id="fprepaiddepositrequire" />
				        </div>
				    </div>
			    </div>


			    <!-- End dat truoc -->

			    <div class="control-group" id="importtime" <?php if (($_smarty_tpl->getVariable('formData')->value['fonsitestatus']!=10)||($_smarty_tpl->getVariable('formData')->value['fonsitestatus']==6&&$_smarty_tpl->getVariable('formData')->value['finstock']<=0&&$_smarty_tpl->getVariable('formData')->value['fsellprice']>0)){?>style="display: none;"<?php }?>>
			        <label class="control-label" for="">Thời gian dự kiến nhập hàng</label>
			        <div class="controls"><input class='inputdatepicker' type="text" name="fimportdate" id="fimportdate" value="<?php if ($_smarty_tpl->getVariable('formData')->value['fimportdate']>0){?><?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fimportdate']);?>
<?php }?>" ></div>
			    </div>

			    <div id="commingsoon" <?php if ($_smarty_tpl->getVariable('formData')->value['fonsitestatus']!=10){?>style="display:none;"<?php }?>>
					<div class="control-group" id="fcomingsoondate">
			        	<label class="control-label" for="">Thời gian dự kiến</label>
			        	<div class="controls"><input type="text" name="fcomingsoondate" id="fcomingsoodate" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fcomingsoondate'];?>
" />(DD/MM/YYYY)</div>
				    </div>

				    <div class="control-group" id="fcomingsoonprice">
				        <label class="control-label" for="">Giá dự kiến</label>
				        <div class="controls"><input type="text" name="fcomingsoonprice" id="fcomingsoonprice" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fcomingsoonprice'];?>
" /></div>
				    </div>
				</div>

                <?php if (!empty($_smarty_tpl->getVariable('formData',null,true,false)->value['fbarcode'])){?>
				<div class="control-group">
					<div class="controls">
						<a href="javascript:void(0)" onclick="updatepromotionforproduct('<?php echo trim($_smarty_tpl->getVariable('formData')->value['fbarcode']);?>
')" id="buttonupdatepromotion" class="btn btn-large btn-primary btn-warning">Cập nhật khuyến mãi</a>
						<a href="javascript:void(0)" onclick="clearcacheproduct();" id="clearcache" class="btn btn-large btn-primary btn-warning">Clear cache</a>
					</div>
				</div>				
                <?php }?>
				<?php if ($_smarty_tpl->getVariable('ischangeproductcolor')->value){?>
				<div class="control-group" style="float:right;">
					<div class="controls">
						<a href="javascript:void(0)" id="changeproductcolor">Chuyển sản phẩm thành sản phẩm màu</a>
					</div>					
				</div>
				<div class="control-group" style="float:right;display:none;" id="datacolor">
					<div class="controls">
						<input type="hidden" id="fiddestination" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
" />
						Id của sản phẩm chính mà bạn muốn chuyển : <input type="text" id="fidsource" class="input-large"/><br/><br/>
						<div style="margin:0px 0px 0px 228px;">
							Màu: <div class="btn-group" style="vertical-align:top;" id="groupcolor">
								<input type="tet" class="input-large" name="fpcolornamechange" id="fpcolornamechange" value="" placeholder="Tên màu..." />&nbsp;&nbsp;
								<a class="btn btn-info dropdown-toggle" data-toggle="dropdown">Color</a>
							  	<ul class="dropdown-menu">
							    	<li><div id="colorpalette2"></div></li>
							  	</ul><br/>
							 	<input id="fpcolorchange" name="fpcolorchange" readonly="readonly" value="">						  	
							</div>
						</div>
						<br/><br/>
						<input style="float:right;" type="button" class="btn btn-primary" id="fsubmitchangeproductcolor" value="Chuyển" />
					</div>
				</div>
				<?php }?>
			</div><!--end of tab1-->
			<div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==2){?>active<?php }?>" id="tab2" style="overflow:hidden">
				<img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/ajax_indicator.gif" />
				<!--load ajax-->
			</div><!--end of tab2-->
			<div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==3){?>active<?php }?>" id="tab3">
				<h1>Hình đại diện</h1>
				<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['iamgeLabel'];?>
&nbsp;:&nbsp;
				<?php if ($_smarty_tpl->getVariable('formData')->value['fimage']!=''){?>
				<a href="<?php echo $_smarty_tpl->getVariable('formData')->value['fimage'];?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('formData')->value['fimage'];?>
" width="50px" height="50px" /></a>
				<?php }?>
				<input type="file" name="fimage" /><br/>
				<span <?php if ($_smarty_tpl->getVariable('formData')->value['fimage']!=''){?>style="padding-left:120px;"<?php }else{ ?>style="padding-left:47px;"<?php }?>></span><br/><br/>
				<h1>Gallery</h1>
				<table class="table" id="gallery">
					<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productmediaList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
?>
					<?php if ($_smarty_tpl->getVariable('media')->value->type==1){?>
					<tr id="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
">						
						<td><input type="checkbox" name="fdeletegallerys[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="1" />&nbsp;&nbsp;<input type="text" class="input-mini" name="fdisplaygallery[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->displayorder;?>
" />&nbsp;&nbsp;<input type="hidden" name="fmediaId[]" value="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
" /><?php echo $_smarty_tpl->getVariable('media')->value->getMediaName();?>
</td>						
						<td>
							<a href="<?php echo $_smarty_tpl->getVariable('media')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('media')->value->getSmallImage();?>
" width="50px" height="50px" /></a>
						</td>
						<td><input type="text" name="fcaptionmedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->caption;?>
" <?php if ($_smarty_tpl->getVariable('media')->value->caption==''){?>placeholder="Caption..."<?php }?> /></td>
						<td><input type="text" name="faltmedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->alt;?>
" <?php if ($_smarty_tpl->getVariable('media')->value->alt==''){?>placeholder="Alt..."<?php }?> /></td>
						<td><input type="text" name="ftitleseomedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->titleseo;?>
" <?php if ($_smarty_tpl->getVariable('media')->value->titleseo==''){?>placeholder="Title SEO..."<?php }?> /></td>
						<td><a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
					</tr>
					<?php }?>
					<?php }} ?>
					<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productmediaList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
?>
					<?php if ($_smarty_tpl->getVariable('media')->value->type==3){?>
					<tr id="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
">
						<td><input type="hidden" name="fmediaId[]" value="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
" /><?php echo $_smarty_tpl->getVariable('media')->value->getMediaName();?>
</td>
						<td>
							<input type="text" name="fmoreurlold[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->moreurl;?>
" />
						</td>
						<td><input type="text" name="fcaptionmedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->caption;?>
" <?php if ($_smarty_tpl->getVariable('media')->value->caption==''){?>placeholder="Caption..."<?php }?> /></td>
						<td><input type="text" name="faltmedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->alt;?>
" <?php if ($_smarty_tpl->getVariable('media')->value->alt==''){?>placeholder="Alt..."<?php }?> /></td>
						<td><input type="text" name="ftitleseomedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->titleseo;?>
" <?php if ($_smarty_tpl->getVariable('media')->value->titleseo==''){?>placeholder="Title SEO..."<?php }?> /></td>
						<td><a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
					</tr>
					<?php }?>
					<?php }} ?>
					<tr>
						<td><input type="submit" class="btn btn-mini btn-danger" value="Xóa hình ảnh" name="fdeletegallery" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Hình sản phẩm</td>
						<td><input type="file" name="ffile[]" multiple /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>YouTube URL</td>
						<td><input type="text" id="urlvalue-2" name="furl[2]" placeholder="URL..."></span></td>
						<td><span id="caption-2"><input type="text" name="fcaption[2]" value="" placeholder="Caption..." /></span></td>
						<td><span id="alt-2"><input type="text"  name="falt[2]" value="" placeholder="Alt..." /></span></td>
						<td><span id="titleseo-2"><input type="text"  name="ftitleseo[2]" value="" placeholder="Title..." /></span></td>
						<td></td>
					</tr>
				</table>
				<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton" value="+" onclick="addRow('gallery')" /><br/><br/><br/>
				<h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['image360'];?>
</h1>
				<table class="table" id="t360">
					<tr>
						<td colspan="6"><input type="checkbox" id="checkall360gallery" /></td>
					</tr>
					<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productmediaList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
?>
					<?php if ($_smarty_tpl->getVariable('media')->value->type==5){?>					
					<tr id="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
">
						<td><input class="checkgallery360" type="checkbox" name="fdeletegallerys360[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="1" /><input type="hidden" name="fmediaId[]" value="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
" /><?php echo $_smarty_tpl->getVariable('media')->value->getMediaName();?>
</td>
						<td>
							<a href="<?php echo $_smarty_tpl->getVariable('media')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('media')->value->getSmallImage();?>
" width="50px" height="50px" /></a>
						</td>
						<td><input type="text" name="fcaptionmedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->caption;?>
" /></td>
						<td><input type="text" name="faltmedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->alt;?>
" /></td>
						<td><input type="text" name="ftitleseomedia[<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('media')->value->titleseo;?>
" /></td>
						<td><a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
					</tr>
					<?php }?>
					<?php }} ?>
                    <tr>
                        <td><input type="submit" class="btn btn-mini btn-danger" value="Xóa hình ảnh 360" name="fdeletegallery360" /></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
					<tr id="image360_1">
						<td style="width:101px;">Upload hình 360 : </td>
						<td><input type="file" name="ffile360[]" multiple="multiple" max="100"/></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton" value="+" onclick="addRow('t360')" />
				<h1>Thông số kỹ thuật</h1>
				<table>
					<tr>
						<td style="width:155px;"><?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productmediaList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
?>
				<?php if ($_smarty_tpl->getVariable('media')->value->type==7){?><div id="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
"><input type="hidden" name="ftypespecial" value="<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
"/><img src="<?php echo $_smarty_tpl->getVariable('media')->value->getSmallImage();?>
" />&nbsp; <a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteSpecialMedia('<?php echo $_smarty_tpl->getVariable('media')->value->id;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a><?php }?></div>
				<?php }} ?></td>
						<td><input type="file" name="ftypespecialimg[0]" style="width:200px;" /></td>
						<td><input type="text" name="ftypespecialcaption" value="" placeholder="Caption..." value="<?php echo $_smarty_tpl->getVariable('formData')->value['ftypespecialcaption'];?>
" /></td>
						<td><input type="text" name="ftypespecialalt" value="" placeholder="Alt..." value="<?php echo $_smarty_tpl->getVariable('formData')->value['ftypespecialalt'];?>
" /></td>
						<td><input type="text" name="ftypespecialtitle" value="" placeholder="Titlte..."  /></td>
						<td></td>
					</tr>
				</table>
			</div><!--end of tab3-->


            <div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==4){?>active<?php }?>" id="tab4"><!--end of tab5-->
                <?php if (count($_smarty_tpl->getVariable('accessoriesList')->value)>0){?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDisplayorder'];?>
</th>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstock'];?>
</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['accessories'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('accessoriesList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['accessories']->key => $_smarty_tpl->tpl_vars['accessories']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['accessories']->key;
?>
                        <tr id="row_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
                            <td>
                                <input typpe="text" name="faccessoriesdisplayorder[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->getVariable('accessories')->value->rppdisplayorder;?>
" class="input-mini" />
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->getVariable('accessories')->value->image!=''){?>
                                    <a href="<?php echo $_smarty_tpl->getVariable('accessories')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('accessories')->value->getSmallImage();?>
" width="50px" height="50px" /></a>
                                <?php }?>
                            </td>
                            <td><?php echo $_smarty_tpl->getVariable('accessories')->value->id;?>
</td>
                            <td><?php echo $_smarty_tpl->getVariable('accessories')->value->barcode;?>
</td>
                            <td><span class="label label-info"><?php echo $_smarty_tpl->getVariable('accessories')->value->categoryactor->name;?>
</span></td>
                            <td><?php echo $_smarty_tpl->getVariable('accessories')->value->name;?>
</td>
                            <td><?php echo $_smarty_tpl->getVariable('accessories')->value->instock;?>
</td>
                            <td><?php echo $_smarty_tpl->getVariable('accessories')->value->sellprice;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
</td>
                            <td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeAccessories_<?php echo $_smarty_tpl->getVariable('key')->value->id;?>
" onclick="removeProduct('#row_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
                        </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                <?php }?>

                <div id="accessoriesproduct" style=""><h1>Product Choose</h1>
                    <table class="table" id="chooseaccessories">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th>Danh mục</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id='acctab'>
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a onclick="" href="#stab5" data-toggle="tab">Manual</a></li>
                    <li class=""><a onclick="" href="#stab4" data-toggle="tab">Goi y</a></li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                    <div class="tab-pane fade in active" id="stab5">
                        <?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterLabel'];?>
 <input type="text" name="fsearchaccessories" id="fsearchaccessories"/>
                        <input type="button" name="fsearchButton" id="fsearchButton" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="searchProductAccessories()" />
                        <div id="resultAccessories">

                        </div>
                    </div>
                    <div class="tab-pane fade in" id="stab4">
                        <div>
                            <?php echo $_smarty_tpl->getVariable('formData')->value['access'];?>

                        </div>
                    </div>


                </div>
            </div>







            <!--end of tab4-->
            <div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==5){?>active<?php }?>" id="tab5"><!--end of tab5-->
                <?php if (count($_smarty_tpl->getVariable('sampleList')->value)>0){?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDisplayorder'];?>
</th>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstock'];?>
</th>
                            <th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['sample'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sampleList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sample']->key => $_smarty_tpl->tpl_vars['sample']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['sample']->key;
?>
                            <tr id="rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
                                <td><input name="fsampledisplayorder[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->getVariable('sample')->value->rppdisplayorder;?>
"
                                           class="input-mini"/></td>
                                <td>
                                    <?php if ($_smarty_tpl->getVariable('sample')->value->image!=''){?>
                                        <a href="<?php echo $_smarty_tpl->getVariable('sample')->value->getSmallImage();?>
" rel="shadowbox"><img
                                                    src="<?php echo $_smarty_tpl->getVariable('sample')->value->getSmallImage();?>
" width="50px" height="50px"/></a>
                                    <?php }?>
                                </td>
                                <td><?php echo $_smarty_tpl->getVariable('sample')->value->id;?>
</td>
                                <td><?php echo $_smarty_tpl->getVariable('sample')->value->barcode;?>
</td>
                                <td><span class="label label-info"><?php echo $_smarty_tpl->getVariable('sample')->value->categoryactor->name;?>
</span></td>
                                <td><?php echo $_smarty_tpl->getVariable('sample')->value->name;?>
</td>
                                <td><?php echo $_smarty_tpl->getVariable('sample')->value->instock;?>
</td>
                                <td><?php echo $_smarty_tpl->getVariable('sample')->value->sellprice;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
</td>
                                <td><a class="btn btn-mini btn-danger" href="javascript:void(0)"
                                       id="removeSample_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="removeProduct('#rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' , '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')"><i
                                                class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a>
                                </td>
                            </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                <?php }?>

                <div id="sampleproduct" style=""><h1>Product Choose</h1>
                    <table class="table" id="choosesample">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Barcode</th>
                            <th>Danh mục</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('formData')->value['recommendSample']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                            <tr id="rowsample_<?php echo $_smarty_tpl->getVariable('value')->value->id;?>
">
                                <td>
                                    <a href="<?php echo $_smarty_tpl->getVariable('value')->value->image;?>
"
                                       rel="shadowbox"><img
                                                src="<?php echo $_smarty_tpl->getVariable('value')->value->image;?>
"
                                                width="100px" height="100px"></a></td>
                                <td><?php echo $_smarty_tpl->getVariable('value')->value->id;?>
</td>
                                <td><?php echo $_smarty_tpl->getVariable('value')->value->barcode;?>
</td>
                                <td><span class="label label-info"><span
                                                class="label label-info"><?php echo $_smarty_tpl->getVariable('value')->value->productCategory;?>
</span></span></td>
                                <td><input type="hidden" name="sample[]" value="<?php echo $_smarty_tpl->getVariable('value')->value->id;?>
"
                                           id="sample_<?php echo $_smarty_tpl->getVariable('value')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('value')->value->name;?>

                                </td>
                                <td><?php echo $_smarty_tpl->getVariable('value')->value->sellprice;?>
</td>
                                <td><?php echo $_smarty_tpl->getVariable('value')->value->instock;?>
</td>
                                <td><input type="button" class="btn btn-danger" id="fclear_<?php echo $_smarty_tpl->getVariable('value')->value->id;?>
"
                                           onclick="clearFunction(<?php echo $_smarty_tpl->getVariable('value')->value->id;?>
,2)" value="Remove"></td>
                            </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id='retab'>
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a onclick="" href="#stab1" data-toggle="tab">Manual</a></li>
                    <li class=""><a onclick="" href="#stab2" data-toggle="tab">Mua cung</a></li>
                    <li class=""><a onclick="" href="#stab3" data-toggle="tab">Tuong tu</a></li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                    <div class="tab-pane fade in active" id="stab1">
                        <?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterLabel'];?>
 <input type="text" name="fsearchsample" id="fsearchsample"/>
                        <input type="button" name="fsearchButton" id="fsearchButton"
                               value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary"
                               onclick="searchProductSample()"/>

                        <div id="resultSample">

                        </div>
                    </div>
                    <div class="tab-pane fade active in" id="stab2">
                        <div>
                            <?php echo $_smarty_tpl->getVariable('formData')->value['recommendationf2'];?>

                        </div>
                    </div>
                    <div class="tab-pane fade in" id="stab3">
                        <div>
                            <?php echo $_smarty_tpl->getVariable('formData')->value['recommendationf3'];?>

                        </div>

                    </div>

                </div>
            </div>
				<!--end of tab5-->

			<div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==7){?>active<?php }?>" id="tab7"><!--end of tab7-->
				<?php if (count($_smarty_tpl->getVariable('product2List')->value)>0){?>
					<table class="table">
						<thead>
							<tr>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDisplayorder'];?>
</th>
								<th></th>
								<th>Id</th>
						        <th>Barcode</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstock'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStartdate'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelEnddate'];?>
</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php  $_smarty_tpl->tpl_vars['product2'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product2List')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product2']->key => $_smarty_tpl->tpl_vars['product2']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product2']->key;
?>
							<tr id="rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
								<td><input name="fproduct2displayorder[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->getVariable('product2')->value->rppdisplayorder;?>
" class="input-mini" /></td>
								<td>
									<?php if ($_smarty_tpl->getVariable('product2')->value->image!=''){?>
									<a href="<?php echo $_smarty_tpl->getVariable('product2')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('product2')->value->getSmallImage();?>
" width="50px" height="50px" /></a>
									<?php }?>
								</td>
								<td><?php echo $_smarty_tpl->getVariable('product2')->value->id;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product2')->value->barcode;?>
</td>
								<td><span class="label label-info"><?php echo $_smarty_tpl->getVariable('product2')->value->categoryactor->name;?>
</span></td>
								<td><span <?php if ($_smarty_tpl->getVariable('product2')->value->enddate<time()){?>style="color:red"<?php }?>><?php echo $_smarty_tpl->getVariable('product2')->value->name;?>
</span></td>
								<td><?php echo $_smarty_tpl->getVariable('product2')->value->instock;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product2')->value->sellprice;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
</td>
								<td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('product2')->value->datecreated,"%d/%m/%Y");?>
</td>
								<td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('product2')->value->enddate,"%d/%m/%Y");?>
</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeSample_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="removeProduct('#rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' , '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				<?php }?>
				<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterLabel'];?>
 <input type="text" name="fsearchproduct2" id="fsearchproduct2"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="searchProduct2()" />
				<div id="resultProduct2">

				</div>
				<div id="product2" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseproduct2"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab7-->

			<div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==8){?>active<?php }?>" id="tab8"><!--end of tab8-->
				<?php if (count($_smarty_tpl->getVariable('product3List')->value)>0){?>
					<table class="table">
						<thead>
							<tr>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDisplayorder'];?>
</th>
								<th></th>
								<th>Id</th>
        						<th>Barcode</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstock'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStartdate'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelEnddate'];?>
</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php  $_smarty_tpl->tpl_vars['product3'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product3List')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product3']->key => $_smarty_tpl->tpl_vars['product3']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product3']->key;
?>
							<tr id="rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
								<td><input name="fproduct3displayorder[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->getVariable('product3')->value->rppdisplayorder;?>
" class="input-mini" /></td>
								<td>
									<?php if ($_smarty_tpl->getVariable('product3')->value->image!=''){?>
									<a href="<?php echo $_smarty_tpl->getVariable('product3')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('product3')->value->getSmallImage();?>
" width="50px" height="50px" /></a>
									<?php }?>
								</td>
								<td><?php echo $_smarty_tpl->getVariable('product3')->value->id;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product3')->value->barcode;?>
</td>
								<td><span class="label label-info"><?php echo $_smarty_tpl->getVariable('product3')->value->categoryactor->name;?>
</span></td>
								<td><span <?php if ($_smarty_tpl->getVariable('product3')->value->enddate<time()){?>style="color:red"<?php }?>><?php echo $_smarty_tpl->getVariable('product3')->value->name;?>
</span></td>
								<td><?php echo $_smarty_tpl->getVariable('product3')->value->instock;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product3')->value->sellprice;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
</td>
								<td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('product3')->value->datecreated,"%d/%m/%Y");?>
</td>
								<td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('product3')->value->enddate,"%d/%m/%Y");?>
</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeSample_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="removeProduct('#rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' , '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				<?php }?>
				<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterLabel'];?>
 <input type="text" name="fsearchproduct3" id="fsearchproduct3"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="searchProduct3()" />
				<div id="resultProduct3">

				</div>
				<div id="product3" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseproduct3"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab8-->

			<?php if ($_smarty_tpl->getVariable('category')->value->parent[0]['pc_id']==482){?>  <!--tinh nang danh rieng cho nganh hang phu kien-->
			<div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==9){?>active<?php }?>" id="tab9">
				<?php if (count($_smarty_tpl->getVariable('product4List')->value)>0){?>
					<table class="table">
						<thead>
							<tr>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDisplayorder'];?>
</th>
								<th></th>
								<th>Id</th>
        						<th>Barcode</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstock'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php  $_smarty_tpl->tpl_vars['product4'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product4List')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product4']->key => $_smarty_tpl->tpl_vars['product4']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product4']->key;
?>
							<tr id="rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
								<td><input name="fproduct4displayorder[<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->getVariable('product4')->value->rppdisplayorder;?>
" class="input-mini" /></td>
								<td>
									<?php if ($_smarty_tpl->getVariable('product4')->value->image!=''){?>
									<a href="<?php echo $_smarty_tpl->getVariable('product4')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('product4')->value->getSmallImage();?>
" width="50px" height="50px" /></a>
									<?php }?>
								</td>
								<td><?php echo $_smarty_tpl->getVariable('product4')->value->id;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product4')->value->barcode;?>
</td>
								<td><span class="label label-info"><?php echo $_smarty_tpl->getVariable('product4')->value->categoryactor->name;?>
</span></td>
								<td><?php echo $_smarty_tpl->getVariable('product4')->value->name;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product4')->value->instock;?>
</td>
								<td><?php echo $_smarty_tpl->getVariable('product4')->value->sellprice;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCurrency'];?>
</td>
								<td><a class="btn btn-mini btn-danger" href="javascript:void(0)" id="removeSample_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="removeProduct('#rows_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' , '<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				<?php }?>
				<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterLabel'];?>
 <input type="text" name="fsearchproduct4" id="fsearchproduct4"/>
				<input type="button" name="fsearchButton" id="fsearchButton" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="searchProduct4()" />
				<div id="resultProduct4">

				</div>
				<div id="product4" style="display:none"><h1>Product Choose</h1><table class="table" id="chooseproduct4"><thead>
					<tr>
						<th></th>
						<th>Id</th>
						<th>Barcode</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Giá</th>
						<th>Số lượng</th>						
						<th></th>
					</tr>
				</thead><tbody></tbody></table></div>
			</div><!--end of tab9-->
			<?php }?>

            <div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==6){?>active<?php }?>" id="tab6">
                <div>
                    <h1 style="display:inline;"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['colorTitle'];?>
</h1>
                     <a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
product/addProductColor/pid/<?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
" rel="shadowbox;height=400;width=1000" style="display:inline;float:right"><span class="label label-info"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelAddColor'];?>
</span></a>
                </div>
                <div style="height:30px;"></div>
				<table>
					<?php  $_smarty_tpl->tpl_vars['productcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('formData')->value['fcolorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productcolor']->key => $_smarty_tpl->tpl_vars['productcolor']->value){
?>
					<?php if ($_smarty_tpl->tpl_vars['productcolor']->value['id']!=$_smarty_tpl->getVariable('formData')->value['fid']){?>
					<tr id="rows<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
">
						<td><span class="label label-info"><?php echo $_smarty_tpl->tpl_vars['productcolor']->value['colorname'];?>
</span></td>
						<td></td>
						<td><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
product/editProductColor/pid/<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
/value/<?php echo substr($_smarty_tpl->tpl_vars['productcolor']->value['colorcode'],1);?>
/pidsource/<?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
" rel="shadowbox;height=500;width=1000"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelEdit'];?>
</a>&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0)" onclick="deleteProductColorFunction(<?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
,<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['colorcode'];?>
')"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDelete'];?>
</a>
                        </td>
					</tr>
					<?php }?>
					<?php }} ?>
				</table>   
				<div style="height:30px;"></div>
				<div>Màu mặc định : </div>
				<table>	
					<tr>				
					<?php  $_smarty_tpl->tpl_vars['productcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('formData')->value['fcolorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productcolor']->key => $_smarty_tpl->tpl_vars['productcolor']->value){
?>
					<td id="fdefaultcolor<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
">
						<label class="radio inline">
							<input type="hidden" id="hcolor<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
" name="fdefaultcolor[<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
]" value="1" />
							<input type="radio" value="<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['default'];?>
" <?php if ($_smarty_tpl->tpl_vars['productcolor']->value['default']=="1"){?>checked="checked"<?php }?> name="fdefaultcolormain[<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['id'];?>
]" class="fpcolor">&nbsp;<?php echo $_smarty_tpl->tpl_vars['productcolor']->value['colorname'];?>

						</label>					
					</td>
					<?php }} ?>
					</tr>
				</table>             
            </div><!--end of tab 6-->

            <div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==10){?>active<?php }?>" id="tab10">
            	<!--load ajax-->
            	<img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/ajax_indicator.gif" />
            </div><!--end of tab 10 -->

            <div class="tab-pane <?php if ($_smarty_tpl->getVariable('formData')->value['ftab']==11){?>active<?php }?>" id="tab11">
            	<h3>Banner ngang</h3>
            	<div id="horizonbanner">
            		<?php if (count($_smarty_tpl->getVariable('horizonalbanners')->value)>0){?>
	            	<table class="table" id="horizon">
	            		<?php  $_smarty_tpl->tpl_vars['horizonalbanner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('horizonalbanners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['horizonalbanner']->key => $_smarty_tpl->tpl_vars['horizonalbanner']->value){
?>
	            		<tr>
	            			<td><input type="hidden" name="fhbanner[]" value="<?php echo $_smarty_tpl->getVariable('horizonalbanner')->value->id;?>
"><a href="<?php echo $_smarty_tpl->getVariable('horizonalbanner')->value->getImage();?>
"><img src="<?php echo $_smarty_tpl->getVariable('horizonalbanner')->value->getSmallImage();?>
"></a>&nbsp;&nbsp;<a class="btn btn-mini btn-danger" href="javascript:void(0)" id="" onclick="deletebanner(<?php echo $_smarty_tpl->getVariable('horizonalbanner')->value->id;?>
 , 'h')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
	            		</tr>
	            		<?php }} ?>
	            	</table>
	            	<?php }else{ ?>
	            	<input type="file" name="fhorizonbanner" />
	            	<?php }?>
            	</div>
            	<h3>Banner dọc</h3>
            	<div id="verticalbanner">
            		<?php if (count($_smarty_tpl->getVariable('verticalbanners')->value)>0){?>
	            	<table class="table" id="vertical">
	            		<?php  $_smarty_tpl->tpl_vars['verticalbanner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('verticalbanners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['verticalbanner']->key => $_smarty_tpl->tpl_vars['verticalbanner']->value){
?>
	            		<tr>
	            			<td><input type="hidden" name="fvbanner[]" value="<?php echo $_smarty_tpl->getVariable('verticalbanner')->value->id;?>
"><a href="<?php echo $_smarty_tpl->getVariable('verticalbanner')->value->getImage();?>
"><img src="<?php echo $_smarty_tpl->getVariable('verticalbanner')->value->getSmallImage();?>
"></a>&nbsp;&nbsp;<a class="btn btn-mini btn-danger" href="javascript:void(0)" id="" onclick="deletebanner(<?php echo $_smarty_tpl->getVariable('verticalbanner')->value->id;?>
 , 'v')"><i class="icon-remove icon-white"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formDeleteLabel'];?>
</a></td>
	            		</tr>
	            		<?php }} ?>
	            	</table>
	            	<?php }else{ ?>
	            	<input type="file" name="fverticalbanner" />
	            	<?php }?>
            	</div>
            	<div class="control-group" id="timebanner">
			        <label class="control-label" for="">Thời gian hiển thị</label>
			        <div class="controls">Từ <input class='inputdatepicker' type="text" name="fbannerstartdate" id="fbannerstartdate" value="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('formData')->value['fbannerstartdate'],"%d/%m/%Y");?>
" > Đến <input class='inputdatepicker' type="text" name="fbannerendate" id="fbannerendate" value="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('formData')->value['fbannerendate'],"%d/%m/%Y");?>
" ></div>
			    </div>
            </div><!--end of tab 11-->
		</div>
	</div>
	<div class="form-actions" id="submitallbutton">
		<input type="submit" name="fsubmit" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formUpdateSubmit'];?>
" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : <?php echo $_smarty_tpl->getVariable('lang')->value['default']['formRequiredLabel'];?>
</span>
	</div>
</form>


<script type="text/javascript" language="JavaScript">
    var myclass = $('#sampletab').attr('class');
    if(typeof myclass != "undefined" )
      $('#retab').attr('class', $('#retab').attr('class') + 'active');

	var pcid = <?php echo $_smarty_tpl->getVariable('formData')->value['fpcid'];?>

	var pid = <?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>

	var pbarcode = <?php echo $_smarty_tpl->getVariable('formData')->value['fbarcode'];?>

	$(document).ready(function(){
		$("form").bind("keypress", function (e) {
		    if (e.keyCode == 13) {
		        return false;
		    }

		});

		loadAttribute();
		loadPromotion();
		$('#fvid').select2();
		$('#fvsubid').select2();
		$('#fpcid').select2();
		$('.select2-choice').css('width' , '200px');
		$('#fslug').limit(50 , '#slugcounter');
		$('#fseotitle').limit(70 , '#seotitlecounter');
		$('#fseodescription').limit(160 , '#seodescriptioncounter');
		$('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
		$('#tags_keyword').tagsInput({width:'532px'});
		
		$("#checkall360gallery").live('click' , function(e){
			if($(this).is(':checked'))
			{
				$(".checkgallery360").each(function(){
					$(this).attr("checked",true);
				});
			}
			else
			{
				$(".checkgallery360").each(function(){
					$(this).attr("checked",false);
				});
			}
		});

		$('.fpcolor').on("click" , function(){
			$('.fpcolor').attr('checked', false);						
			$(this).attr('checked' , true);
		});	

		$("#fpcolor").change(function(event){
			$("#datacolor").css('background-color' , $(this).val());
		});


		$("#datacolor").css('background-color' , $("#fpcolor").val());
		
		$('#changeproductcolor').click(function(){
			$('#datacolor').toggle();
		});
		
		$('#fsubmitchangeproductcolor').live('click' , function(){
			var pidsource = $('#fidsource').val();
			var piddestination = $('#fiddestination').val();
			var colornamechange = $("#fpcolornamechange").val();
			var colorchange = $("#fpcolorchange").val();
			
			if(pidsource === '' || pidsource === undefined || colornamechange === '' || colorchange === '')
			{
				bootbox.alert('Vui lòng nhập đầy đủ thông tin của sản phẩm mà bạn muốn chuyển đến.');
			}
			else
			{
				$.ajax({
					type : "POST",
					datatype : "html",
					url : "/cms/product/changedatacolor",
					data : "pidsource=" + pidsource + "&piddestination=" + piddestination+"&colornamechange="+colornamechange+"&colorchange="+colorchange,
					success : function(html){
						if(html === '1'){
							window.location.href = '/cms/product/edit/id/'+pidsource;
						}else{
							bootbox.alert('Không thể chuyển sản phẩm hiện tại thành sản phẩm màu. Xin vui lòng thử lại.');
						}
					}
				});
			}
		});

		//xu ly KM
		$('#fsubmitpromotion').live('click', function(){
			var val = $('.promotionstatus').serializeArray();//Array();
			$.post('/cms/product/updateproductpromotionstatus', {promo: val, pid: pid}, function(data){
				if(data && data.success)
				{
					if(data.success == 1)
					{
						showGritterSuccess('Khuyến mãi đã được cập nhật.');
					}
				}
			},'json');
		});

		$('#colorpalette1').colorPalette()
          .on('selectColor', function(e) {
            $('#fpcolorstring').val(e.color);            
            //var color = $('#fpcolor').val(e.color);            
        });
        
        $('#colorpalette2').colorPalette()
          .on('selectColor', function(e) {
            $('#fpcolorchange').val(e.color);            
            //var color = $('#fpcolor').val(e.color);            
        });

        if($('#fpchoosecolor').val() === '-1')
        {
        	$("#groupcolor").show();
        }

        $("#fpchoosecolor").change(function(event) {
        	/* Act on the event */
        	if($(this).val() === '-1'){
        		$("#groupcolor").show();
        	}else{
        		$("#groupcolor").hide();
        	}
        });

        $(".btn-color").click(function(event) {
        	/* Act on the event */        	
        	event.preventDefault();
        });

       $("#fonsitestatus").change(function(){
        	var onsitestatus = $(this).val();        	
        	if(onsitestatus === '10'){
        		$("#commingsoon").show();
        	}else{
        		$("#commingsoon").hide();
        	}
        	if(onsitestatus === '2')
        	{
        		$("#osprepaid").show();
        	}
        	else
        	{
        		$("#osprepaid").hide();
        	}
        }); 

	});

    /*Shadowbox.init({
        onClose: function(){ window.location.reload(); }
    });*/

	function loadAttribute()
	{		
		$.ajax({
			type : "post",
			dataType : "html",
			url : "/cms/product/getproductattributeajax",
			data : "pcid=" + pcid+"&pid="+pid ,
			success :  function(html){
				$('#tab2').html('');
				$('#tab2').html(html);
			}
		});
	}

	function loadPromotion()
	{
		$.ajax({
			type : "post",
			dataType : "html",
			url : "/cms/product/getpromotionajax",
			data : "pid=" + pid,
			success :  function(html){
				$('#tab10').html('');
				$('#tab10').html(html);
			}
		});
	}

	function changevalueattr(attrid)
	{
		var value = $('#valuechoose'+attrid).val();
		if(value == -1)
		{
			$('#valueoption'+attrid).fadeIn();
		}
		else
		{
			$('#valueoption'+attrid).fadeOut();
		}
	}

	function changeType(id)
	{
		if($('#ftype-'+id).val() == 1)
		{
			$('#file-'+id).fadeIn(10);
			$('#url-'+id).fadeOut(10);
			$('#url-'+id).val('');
			$('#urlvalue-'+id).val('');
		}
		else
		{
			$('#url-'+id).fadeIn(10);
			$('#file-'+id).fadeOut(10);
			$('#file-'+id).html($('#file-'+id).html());
		}
	}
	function changeFunction()
	{
		if(confirm('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['warningChangeCategory'];?>
'))
		{
			//load all new group attribute and attribute
			var pcid = $('#fpcid').val();
			var pid = $('#fid').val();
			var dataString = "fpcid=" +  pcid + "&fpid="+pid;
			$.ajax({
				type : "post",
				dataType : "html",
				url : '/cms/product/getAttributeAjax',
				data : dataString,
				success : function(html){
					if(html != '')
					{
						$('#tab2').html(html);
					}
					else
					{
						bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errAttributeGroup'];?>
');
					}
				}
			});
		}
	}
	function deleteMedia(id)
	{
		bootbox.confirm("<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['deleteMediaConfirm'];?>
",function(confirm){
			if(confirm){
				var dataString = "id=" + id;
				$.ajax({
					type : 'post',
					dataType : "html",
					url : '/cms/product/deleteMediaAjax',
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#'+id).fadeOut(10);
						}
					}
				});
			}
		});
	}
	function deleteSpecialMedia(id)
	{
		bootbox.confirm("<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['deleteMediaConfirm'];?>
",function(confirm){
			if(confirm){
				var dataString = "id=" + id;
				$.ajax({
					type : 'post',
					dataType : "html",
					url : '/cms/product/deleteMediaAjax',
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#'+id).remove();

						}
					}
				});
			}
		});
	}
	function searchProductAccessories()
	{
		if($('#fsearchaccessories').val() != '')
		{
			var dataString = "pname=" + $('#fsearchaccessories').val() + "&type=accessories&pid=" + <?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
;
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultAccessories').html(html);
						if($('#accessoriesproduct').attr('display') != 'none'){
							$('#accessoriesproduct').fadeIn();
						}
					}else{
						$('#resultAccessories').html('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNotFound'];?>
');
					}
				}
			});
		}
		else
		{
			bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNameNotEmpty'];?>
');
		}
	}

	function searchProductSample()
	{
		if($('#fsearchsample').val() != '')
		{
			var dataString = "pname=" + $('#fsearchsample').val() + "&type=sample&pid=" + <?php echo $_smarty_tpl->getVariable('formData')->value['fid'];?>
;
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultSample').html(html);
						if($('#sampleproduct').attr('display') != 'none'){
							$('#sampleproduct').fadeIn();
						}
					}else{
						$('#resultSample').html('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNotFound'];?>
');
					}
				}
			});
		}
		else
		{
			bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNameNotEmpty'];?>
');
		}
	}

	function searchProduct2()
	{
		if($('#fsearchproduct2').val() != '')
		{
			var dataString = "pname=" + $('#fsearchproduct2').val() + "&type=product2";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultProduct2').html(html);
						if($('#product2').attr('display') != 'none'){
							$('#product2').fadeIn();
						}
					}else{
						$('#fsearchproduct2').html('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNotFound'];?>
');
					}
				}
			});
		}
		else
		{
			bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNameNotEmpty'];?>
');
		}
	}

	function searchProduct3()
	{
		if($('#fsearchproduct3').val() != '')
		{
			var dataString = "pname=" + $('#fsearchproduct3').val() + "&type=product3";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultProduct3').html(html);
						if($('#product3').attr('display') != 'none'){
							$('#product3').fadeIn();
						}
					}else{
						$('#resultProduct3').html('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNotFound'];?>
');
					}
				}
			});
		}
		else
		{
			bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNameNotEmpty'];?>
');
		}
	}

	function searchProduct4()
	{
		if($('#fsearchproduct4').val() != '')
		{
			var dataString = "pname=" + $('#fsearchproduct4').val() + "&type=product4";
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/product/searchProductAjax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultProduct4').html(html);
						if($('#product4').attr('display') != 'none'){
							$('#product4').fadeIn();
						}
					}else{
						$('#resultProduct4').html('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNotFound'];?>
');
					}
				}
			});
		}
		else
		{
			bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errNameNotEmpty'];?>
');
		}
	}

        function chooseFunction(id,type)
	{
		if(id > 0)
		{
			//kiem tra xem san pham nay da duoc chon hay chua ?
			if($('#'+type+'_'+id).length == 0)
			{
				var imgSource = $('#images_'+id).attr('src');
				var pid = $('#pid').html();
                var barcode = $('#barcode').html();
				var category = $('#categorys_'+id).html();
				var productName = $('#names_'+id).html();
				var productPrice = $('#prices_'+id).html();
				var productInstock = $('#instocks_'+id).html();
				var data = '<tr id="row'+type+'_'+id+'">';
				data += '<td>';
				if(imgSource != undefined)
				{
					data += '<a href="'+imgSource+'" rel="shadowbox"><img src="'+imgSource+'" width="100px" height="100px" /></a>';
				}
				data += '</td>';
				data += '<td>'+pid+'</td>';
				data += '<td>'+barcode+'</td>';
				data += '<td><span class="label label-info">'+category+'</span></td>';
				data += '<td><input type="hidden" name="'+type+'[]" value="'+id+'" id="'+type+'_'+id+'" />'+productName+'</td>';
				data += '<td>'+productPrice+'</td>';
				data += '<td>'+productInstock+'</td>';
				if(type =='accessories')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',1)" value="Remove" /></td>';
				}
				if(type == 'sample')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',2)" value="Remove" /></td>';
				}
				if(type == 'product2')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',3)" value="Remove" /></td>';
				}
				if(type == 'product3')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',4)" value="Remove" /></td>';
				}
				if(type == 'product4')
				{
					data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+',5)" value="Remove" /></td>';
				}
				data += '</tr>';
				$('#choose'+type).find('tbody').append(data);
				$('#rows'+type+'_'+id).fadeOut();
			}
			else
			{
				bootbox.alert('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['errProductChoose'];?>
');
			}
		}
	}
	function clearFunction(id, type)
	{
		if(type == 1)
		{
			$('#rowaccessories_'+id).remove();
			$('#rowsaccessories_'+id).fadeIn();
		}
		else if(type == 2)
		{
			$('#rowsample_'+id).remove();
			$('#rowssample_'+id).fadeIn();
		}
		else if(type == 3)
		{
			$('#rowproduct2_'+id).remove();
			$('#rowsproduct2_'+id).fadeIn(10);
		}
		else if(type == 4)
		{
			$('#rowproduct3_'+id).remove();
			$('#rowsproduct3_'+id).fadeIn(10);
		}

		else if(type == 5)
		{
			$('#rowproduct4_'+id).remove();
			$('#rowsproduct4_'+id).fadeIn(10);
		}
	}

	function removeProduct(selector, id)
	{
		bootbox.confirm("<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['deleteProductConfirm'];?>
",function(confirm){
			if(confirm)
			{
				if(id > 0)
				{
					var dataString = 'id=' + id;
					$.ajax({
						type : "post",
						dataType : "html",
						url : "/cms/product/deleteRelProductAjax",
						data : dataString,
						success : function(html){
							if(html == 'success'){
								$(selector).fadeOut();
							}else{
								bootbox.alert('Can not delete this product !');
							}
						}
					});
				}
			}
		});

	}

    function deleteProductColorFunction(pidsource, piddestination, colorCode)
    {
        if(pidsource > 0 && piddestination > 0)
        {
            bootbox.confirm("<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['deleteMediaConfirm'];?>
",function(confirm){
			if(confirm)
			{
				var dataString = 'pidsource=' + pidsource + '&piddestination='+piddestination + '&colorcode=' + colorCode;
				$.ajax({
				    type : "post",
					dataType : "html",
					url : "/cms/product/deleteProductColorAjax",
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#rows'+piddestination).remove();
							$('#fdefaultcolor' + piddestination).remove();							
						}else{
								bootbox.alert("<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['deleteError'];?>
");
						}
					}
				});
			}
		    });
        }
    }

    function addRow(tbname)
	{
		rowCount = $('#'+ tbname +' tr').length;
		rowCount +=1 ;
		//alert(rowCount);
		if(tbname == 't360')
		{
			data = '<tr id="image360_'+rowCount+'"><td style="width:155px;"><input type="hidden" name="ftypeimage360['+rowCount+']" value="5"/></td><td><input type="file" name="ffile360['+rowCount+']" style="width:200px;" /></td><td><span id="caption360-'+rowCount+'"><input type="text" name="fcaption360['+rowCount+']" value="" placeholder="Caption..." /></td><td><span id="alt360-'+rowCount+'"><input type="text" name="falt360['+rowCount+']" value="" placeholder="Alt..." /></td><td><span id="titleseo360-'+rowCount+'"><input type="text" name="ftitlesep360['+rowCount+']" value="" placeholder="Title..." /></td><td></td></tr>'
		}
		else
		{
			data = '<tr><td>YouTube URL</td><td><span id="url-'+rowCount+'" ><input type="text" id="urlvalue-'+rowCount+'" name="furl['+rowCount+']" placeholder="URL..."></span></td><td><span id="caption-'+rowCount+'"><input type="text" name="fcaption['+rowCount+']" value="" placeholder="Caption..." /></span></td><td><span id="alt-'+rowCount+'"><input type="text" name="falt['+rowCount+']" value="" placeholder="Alt..." /></span></td><td><span id="titleseo-'+rowCount+'"><input type="text" name="ftitleseo['+rowCount+']" value="" placeholder="Title..." /></span></td><td></td></tr>';
		}
		$('#'+tbname).append(data);
	}

	function viewShadowbox(url , name, type)
	{
		if(url.length > 0)
		{
			Shadowbox.open({
                    content:    url,
                    title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                    player:     "iframe",
                });
		}
	}

    function updatepromotionforproduct(barcode)
    {
        if(barcode.length > 0)
        {
            var path = rooturl + controllerGroup + "/product/updatepromotionajax";
            path += '/barcode/' + barcode;
            $("#buttonupdatepromotion").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#buttonupdatepromotion").hide();
            $.post(path,{}, function(data){
                if(data && data.success==1)
                {
                    showGritterSuccess('Khuyến mãi đã được cập nhật.');
                }
                else
                    showGritterError('Khuyến mãi đã có hoặc lỗi trong quá trình đồng bộ.');
                $("img.tmp_indicator").remove();
                $("#buttonupdatepromotion").show();
            }, 'json');
        }
        else
            showGritterError('Không có barcode để đồng bộ');
    }

    function changecategory(pcid , pid)
    {
    		url = rooturl_cms + 'product/changecategory/pcid/'+pcid+'/pid/'+pid;
    		Shadowbox.open({
                    content:    url,
                    //title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                    player:     "iframe",
                    height:     480,
                    width:      1400
         });
    }

    function changeonistestatus()
    {
    	var onsitestatus = $('#fonsitestatus').val();

    	if(onsitestatus == 2)
    	{
    		$('#sellprice').hide();
    		$('#importtime').hide();
            $('#viewsellprice').hide();
    		$('#prepaidprice').show();
    		$('#timeprepaid').show();
    	}
    	else if(onsitestatus == 10)
    	{
    		//$('#importtime').show();
    		$("#commingsoon").show();
    	}
    	else
    	{
    		$('#prepaidprice').hide();
    		$("#commingsoon").hide();
    		$('#timeprepaid').hide();
    		$('#importtime').hide();
    		$('#sellprice').show();
            $('#viewsellprice').show();
    	}
    }

    function changeTab(tab)
    {

        $('#ftab').val(tab);
        if(tab == 10 ) $('#submitallbutton').css('display', 'none');
        else  $('#submitallbutton').css('display', 'block');
        $('#retab').attr('class','tab-pane');
        $('#acctab').attr('class','tab-pane');
    }

    function activeRec()
    {
        $('#retab').attr('class', $('#retab').attr('class') + 'active');
    }

    function activeAcc()
    {
        $('#acctab').attr('class', $('#acctab').attr('class') + 'active');
    }

    function deletebanner(id,type)
    {
    	if(id > 0)
    	{
    		bootbox.confirm("Bạn có muốn xóa banner này ?",function(confirm){
    			if(confirm)
    			{
    				$.ajax({
		    			type : "post",
		    			dataType : "html",
		    			url : rooturl_cms + 'ads/deletebannerajax',
		    			data : 'id='+id,
		    			success : function(html){
		    				if(html == 1){
		    					if(type == 'h'){
		    						$('#horizon').remove();
		    						$('#horizonbanner').append('<input type="file" name="fhorizonbanner" />');
		    					} else if(type == 'v'){
		    						$('#vertical').remove();
		    						$('#verticalbanner').append('<input type="file" name="fverticalbanner" />');
		    					}
		    				} else {
		    					bootbox.alert('Không thể xóa banner này.');
		    				}
		    			}
		    		});
    			}
    		});
    	}
    }

    function clearcacheproduct() {
    	var productpath = "<?php echo $_smarty_tpl->getVariable('formData')->value['fproductlink'];?>
"
    	if(productpath !== '') {
    		$.ajax({
	    		url: productpath,
	    		type: 'get',
	    		dataType: 'html',
	    		data: {"live": 1},
	    		success : function(html) {
	    			if(html !== '') {
	    				showGritterSuccess('Clear cache sản phẩm thành công.');
	    			} else {
	    				showGritterError('Có lỗi trong quá trình xóa cache . Xin vui lòng thử lại.');
	    			}
	    		}
	    	}); 
    	}   	
    	
    }
</script>


