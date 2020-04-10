<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:14:42
         compiled from "templates/default/_controller/cms/product/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3024545065e8ecb62be61f9-73336271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '756aee9561f45788347bfc67d73e32f68f32c6ef' => 
    array (
      0 => 'templates/default/_controller/cms/product/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3024545065e8ecb62be61f9-73336271',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_paginate')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.paginate.php';
if (!is_callable('smarty_modifier_replace')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_function_html_options')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.html_options.php';
?><ul class="breadcrumb">
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['menudashboard'];?>
</a> <span class="divider">/</span></li>
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Danh sách</li>
</ul>


<div class="page-header" rel="menu_product"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_list'];?>
</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['title_list'];?>
 <?php if ($_smarty_tpl->getVariable('formData')->value['search']!=''){?>| <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['title_listSearch'];?>
 <?php }?>(<?php echo $_smarty_tpl->getVariable('total')->value;?>
)</a></li>
		<li><a href="#tab2" data-toggle="tab"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterLabel'];?>
</a></li>
		<?php if ($_smarty_tpl->getVariable('formData')->value['search']!=''){?>
			<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['formViewAll'];?>
</a></li>
		<?php }?>
		<li class="pull-right "><a class="btn btn-success" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/add"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</a></li>
		<li class="pull-right "><a class="btn btn-success" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/importproductsize">Import kích thước sản phẩm</a></li>
		<li class="pull-right "><a class="btn btn-success" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/importkeysellingpoint">Import key selling point</a></li>
        <li class="pull-right "><a target="_blank" class="btn btn-success" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/exportinfoproductweb">Export data</a></li>
        <li class="pull-right "><a target="_blank" class="btn btn-success" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/exportproductsize">Export kích thước sản phẩm</a></li>		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="<?php echo $_SESSION['productBulkToken'];?>
" />
				<table class="table table-striped">

				<?php if (count($_smarty_tpl->getVariable('products')->value)>0){?>
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
						    <th>TT hiển thị</th>
							<th>ID</th>
							<?php if ($_SESSION['producthidephoto']==0){?><th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['iamgeLabel'];?>
</th><?php }?>
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
</th>
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelVid'];?>
</th>
							<th>Barcode</th>
							<th width="250"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</th>
							<th><a href="<?php echo $_smarty_tpl->getVariable('filterUrl')->value;?>
sortby/sellprice/sorttype/<?php if ($_smarty_tpl->getVariable('formData')->value['sortby']=='sellprice'){?><?php if (((mb_detect_encoding($_smarty_tpl->getVariable('formData')->value['sorttype'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype']))!='DESC'){?>DESC<?php }else{ ?>ASC<?php }?><?php }?>"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
</a></th>
							<th>SL</th>
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdehot'];?>
</th>
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdenew'];?>
</th>
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdegift'];?>
</th>
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelOnsiteStatus'];?>
</th>
							<th width="140"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="15">
								<div class="pagination">
								   <?php $_smarty_tpl->tpl_vars["pageurl"] = new Smarty_variable("page/::PAGE::", null, null);?>
									<?php echo smarty_function_paginate(array('count'=>$_smarty_tpl->getVariable('totalPage')->value,'curr'=>$_smarty_tpl->getVariable('curPage')->value,'lang'=>$_smarty_tpl->getVariable('paginateLang')->value,'max'=>10,'url'=>($_smarty_tpl->getVariable('paginateurl')->value).($_smarty_tpl->getVariable('pageurl')->value)),$_smarty_tpl);?>

								</div> <!-- End .pagination -->


								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['default']['bulkActionSelectLabel'];?>
</option>
										<option value="delete"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['bulkActionDeletetLabel'];?>
</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['bulkActionSubmit'];?>
" />
									<input type="submit" name="fsubmitchangeorder" class="btn" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['bulkItemChangeOrderSubmit'];?>
" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>

						<tr>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><input type="checkbox" name="fbulkid[]" value="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
" <?php if (in_array($_smarty_tpl->getVariable('product')->value->id,$_smarty_tpl->getVariable('formData')->value['fbulkid'])){?>checked="checked"<?php }?>/></td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><input type="text" class="input-mini" name="fdisplayorder[<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('product')->value->displayorder;?>
" style="width:30px;"/></td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php echo $_smarty_tpl->getVariable('product')->value->id;?>
<br/><?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?><span class="label label-warning">Color</span><?php }?></td>
							<?php if ($_SESSION['producthidephoto']==0){?><td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php if ($_smarty_tpl->getVariable('product')->value->image!=''){?><a href="<?php echo $_smarty_tpl->getVariable('product')->value->getSmallImage();?>
" rel="shadowbox"><img src="<?php echo $_smarty_tpl->getVariable('product')->value->getSmallImage();?>
" width="50" alt="<?php echo $_smarty_tpl->getVariable('product')->value->name;?>
" /></a><?php }?></td><?php }?>


							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productcategoryList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
?>
								<?php if ($_smarty_tpl->getVariable('product')->value->pcid==$_smarty_tpl->getVariable('category')->value->id){?>
								<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
product/index/pcid/<?php echo $_smarty_tpl->getVariable('category')->value->id;?>
"><small><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('category')->value->name,'&nbsp;','');?>
</small></a>
								<?php }?>
								<?php }} ?>
							</td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php  $_smarty_tpl->tpl_vars['vendor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('vendorList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vendor']->key => $_smarty_tpl->tpl_vars['vendor']->value){
?>
								<?php if ($_smarty_tpl->getVariable('product')->value->vid==$_smarty_tpl->getVariable('vendor')->value->id){?>
								<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
product/index/vid/<?php echo $_smarty_tpl->getVariable('vendor')->value->id;?>
"><small><?php echo $_smarty_tpl->getVariable('vendor')->value->name;?>
</small></a>
								<?php }?>
								<?php }} ?>
							</td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php if ($_smarty_tpl->getVariable('product')->value->barcode!=''){?><span class="label label-info"><?php echo $_smarty_tpl->getVariable('product')->value->barcode;?>
</span><?php }else{ ?><span class="label">No barcode</span><?php }?></td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>>
								<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/edit/id/<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
"><span class="label <?php if ($_smarty_tpl->getVariable('product')->value->checkonsitestatusName('no sell')==false){?>label-success<?php }?>"><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
</span></a>
								<br /><small class="slugtext"><a href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
" target="_blank" title="Preview"><?php echo $_smarty_tpl->getVariable('product')->value->slug;?>
</a></small>
							</td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>>
								<?php if ($_smarty_tpl->getVariable('product')->value->barcode!=''){?>
								<a href="javascript:void(0)" onclick="viewShadowbox('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
productprice/index/pbarcode/<?php echo $_smarty_tpl->getVariable('product')->value->barcode;?>
' , '', 'giá')"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>0){?><?php echo $_smarty_tpl->getVariable('product')->value->sellprice;?>
<?php }else{ ?>Cập nhật giá<?php }?></a><br/>
								<a href="javascript:void(0)" onclick="viewShadowbox('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
productprice/index/pbarcode/<?php echo $_smarty_tpl->getVariable('product')->value->barcode;?>
/tab/2' ,'' , 'giá')">Giá đối thủ</a>
								<?php }?>
							</td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>>
								<?php if ($_smarty_tpl->getVariable('product')->value->barcode!=''){?>
								<a href="javascript:void(0)" onclick="viewShadowbox('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
productstock/index/pbarcode/<?php echo $_smarty_tpl->getVariable('product')->value->barcode;?>
' , '<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
', 'tồn kho')"><span class="badge badge-info"><?php echo $_smarty_tpl->getVariable('product')->value->instock;?>
</span></a>
								<?php }else{ ?>
								<span class="badge"><?php echo $_smarty_tpl->getVariable('product')->value->instock;?>
</span>
								<?php }?>
							</td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php if ($_smarty_tpl->getVariable('product')->value->isbagdehot==1){?><i class="icon-ok tipsy-trigger" title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdehot'];?>
"></i><?php }?></td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php if ($_smarty_tpl->getVariable('product')->value->isbagdenew==1){?><i class="icon-ok tipsy-trigger" title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdenew'];?>
"></i><?php }?></td>
							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php if ($_smarty_tpl->getVariable('product')->value->isbagdegift==1){?><i class="icon-ok tipsy-trigger" title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsbagdegift'];?>
"></i><?php }?></td>


							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><?php if ($_smarty_tpl->getVariable('product')->value->checkonsitestatusName('no sell')){?>
									<span class="label label"><?php echo $_smarty_tpl->getVariable('product')->value->getonsitestatusName();?>
</span>
								<?php }elseif($_smarty_tpl->getVariable('product')->value->checkonsitestatusName('prepaid_erp')){?>
									<span class="label label-warning"><?php echo $_smarty_tpl->getVariable('product')->value->getonsitestatusName();?>
</span>
								<?php }elseif($_smarty_tpl->getVariable('product')->value->checkonsitestatusName('prepaid_dm')){?>
									<span class="label label-warning"><?php echo $_smarty_tpl->getVariable('product')->value->getonsitestatusName();?>
</span>
								<?php }elseif($_smarty_tpl->getVariable('product')->value->checkonsitestatusName('erp')){?>
									<span class="label label-success"><?php echo $_smarty_tpl->getVariable('product')->value->getonsitestatusName();?>
</span>
								<?php }elseif($_smarty_tpl->getVariable('product')->value->checkonsitestatusName('dm')){?>
									<span class="label label-success"><?php echo $_smarty_tpl->getVariable('product')->value->getonsitestatusName();?>
</span>								
								<?php }else{ ?>
									<span class="label label-success"><?php echo $_smarty_tpl->getVariable('product')->value->getonsitestatusName();?>
</span>
								<?php }?>
							</td>

							<td <?php if ($_smarty_tpl->getVariable('product')->value->customizetype==20){?>style="background-color:#e1e1e1"<?php }?>><a title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['formActionCloneTooltip'];?>
" href="javascript:void(0)" onclick="cloneFunction('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/clone/id/<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
')" class="btn btn-mini"><i class="icon-copy"></i> Clone</a> &nbsp;
							<a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionEditTooltip'];?>
" href="<?php if ($_smarty_tpl->getVariable('product')->value->productmainlink!=''){?><?php echo $_smarty_tpl->getVariable('product')->value->productmainlink;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/edit/id/<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
<?php }?>" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
								
								<?php if ($_smarty_tpl->getVariable('me')->value->isGroup('administrator')||$_smarty_tpl->getVariable('me')->value->isGroup('developer')){?>
								<a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" href="javascript:delm('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/delete/id/<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
?token=<?php echo $_SESSION['securityToken'];?>
');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
								<?php }?>
							</td>
						</tr>


					<?php }} ?>
					</tbody>


				<?php }else{ ?>
					<tr>
						<td colspan="10"> <?php echo $_smarty_tpl->getVariable('lang')->value['default']['notfound'];?>
</td>
					</tr>
				<?php }?>

				</table>
			</form>

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				<table>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelVid'];?>
:</td>
						<td style="float:left;"><select name="fvid" id="fvid" style="width:100px;">
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
						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelVsubid'];?>
:</td>
						<td style="float:left;"><select name="fvsubid" id="fvsubid" style="width: 100px;">
						<option value="0" selected="selected">----</option>
						<?php  $_smarty_tpl->tpl_vars['vendor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subVendorList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vendor']->key => $_smarty_tpl->tpl_vars['vendor']->value){
?>
							<option value="<?php echo $_smarty_tpl->getVariable('vendor')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('vendor')->value->id==$_smarty_tpl->getVariable('formData')->value['fsubvid']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('vendor')->value->name;?>
</option>
						<?php }} ?>
						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPcid'];?>
:</td>
						<td style="float:left;"><select name="fpcid" id="fpcid" style="width: 200px;">
						<option value="0">----</option>
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
" <?php if ($_smarty_tpl->getVariable('formData')->value['fpcid']==$_smarty_tpl->getVariable('productCategory')->value->id){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('productCategory')->value->name;?>
</option><?php echo $_smarty_tpl->getVariable('formData')->value['fpcid'];?>

						<?php }?>
						<?php }} ?>
						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelBarcode'];?>
:</td>
						<td style="float:left;"><input type="text" name="fbarcode" id="fbarcode" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fbarcode']);?>
" class="input-medium" /></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelBarcodeStatus'];?>
:</td>
						<td style="float:left;">
							<select id="fbarcodestatus" name="fbarcodestatus">
							<option value="0">-----</option>
							<option value="1" <?php if ($_smarty_tpl->getVariable('formData')->value['fbarcodestatus']==1){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelAll'];?>
</option>
							<option value="2"<?php if ($_smarty_tpl->getVariable('formData')->value['fbarcodestatus']==2){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelHaveBarcode'];?>
</option>
							<option value="3" <?php if ($_smarty_tpl->getVariable('formData')->value['fbarcodestatus']==3){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelNotHaveBarcode'];?>
</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
:</td>
						<td style="float:left;"><input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fname']);?>
" class="input-medium" /></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelUnitprice'];?>
:</td>
						<td style="float:left;"><input type="text" name="funitprice" id="funitprice" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['funitprice']);?>
" class="input-medium" /></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSellprice'];?>
:</td>
						<td style="float:left;"><input type="text" name="fsellprice" id="fsellprice" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fsellprice']);?>
" class="input-medium" /> </td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelInstockSearch'];?>
:</td>
						<td style="float:left;"><select id="finstock" name="finstock">
							<option value="0">-----</option>
							<option value="1"<?php if ($_smarty_tpl->getVariable('formData')->value['finstock']==1){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelHaveInstock'];?>
</option>
							<option value="2" <?php if ($_smarty_tpl->getVariable('formData')->value['finstock']==2){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelNotHaveInstock'];?>
</option>
						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSyncStatus'];?>
:</td>
						<td style="float:left;"><select name="fsyncstatus" id="fsyncstatus" style="width:130px;">
							<option value="">- - - -</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('syncstatusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fsyncstatus']),$_smarty_tpl);?>

						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStatus'];?>
:</td>
						<td style="float:left;"><select name="fstatus" id="fstatus" style="width:130px;">
							<option value="">- - - -</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('statusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fstatus']),$_smarty_tpl);?>

						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelOnsiteStatus'];?>
:</td>
						<td style="float:left;"><select name="fonsitestatus" id="fonsitestatus" style="width:160px;">
							<option value="">- - - -</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('onsitestatusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fonsitestatus']),$_smarty_tpl);?>

						</select></td>
					</tr>
					<tr>
						<td>Trạng thái bán hàng:</td>
						<td style="float:left;"><select name="fbusinessstatus" id="fbusinessstatus" style="width:160px;">
							<option value="">- - - -</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('businessstatusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fbusinessstatus']),$_smarty_tpl);?>

						</select></td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelId'];?>
:</td>
						<td style="float:left;"><input type="text" name="fid" id="fid" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fid']);?>
" class="input-mini" /></td>
					</tr>
					<tr>
						<td></td>
						<td style="float:left;"><input type="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="gosearch();"  /></td>
					</tr>
				</table>

			</form>
		</div><!-- end #tab2 -->
	</div>
</div>




<script type="text/javascript">
	$(document).ready(function(){
		$('#fpcid').select2();
		$('#fvid').select2();
		$('#fvsubid').select2();
	});

	function gosearch()
	{
		var path = rooturl + controllerGroup + "/product/index";


		var vid = $('#fvid').val();
		if(vid.length > 0)
		{
			path += '/vid/' + vid;
		}

		var vid = $('#fvsubid').val();
		if(vid.length > 0)
		{
			path += '/vsubid/' + vid;
		}

		var pcid = $('#fpcid').val();
		if(pcid.length > 0)
		{
			path += '/pcid/' + pcid;
		}

		var barcode = $('#fbarcode').val();
		if(barcode.length > 0)
		{
			path += '/barcode/' + barcode;
		}

		var barcodestatus = $('#fbarcodestatus').val();
		if(parseInt(barcodestatus) > 0)
		{
			path += '/barcodestatus/' + barcodestatus;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var unitprice = $('#funitprice').val();
		if(parseInt(unitprice) > 0)
		{
			path += '/unitprice/' + unitprice;
		}

		var instock = $('#finstock').val();
		if(parseInt(instock) > 0)
		{
			path += '/instock/' + instock;
		}

		var sellprice = $('#fsellprice').val();
		if(parseInt(sellprice) > 0)
		{
			path += '/sellprice/' + sellprice;
		}

		var syncstatus = $('#fsyncstatus').val();
		if(syncstatus.length > 0)
		{
			path += '/syncstatus/' + syncstatus;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var status = $('#fonsitestatus').val();
		if(status.length > 0)
		{
			path += '/onsitestatus/' + status;
		}

		var status = $('#fbusinessstatus').val();
		if(status.length > 0)
		{
			path += '/businessstatus/' + status;
		}

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}


		document.location.href= path;
	}

	function cloneFunction(url)
	{
		bootbox.confirm('<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['cloneProductConfirm'];?>
',function(confirm){
			if(confirm){
				window.location.href = url;
			}
		});
	}

	function viewShadowbox(url , name, type)
	{
		if(url.length > 0)
		{
			Shadowbox.open({
                    content:    url,
                    //title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                    player:     "iframe" 
                });
		}
	}
</script>


