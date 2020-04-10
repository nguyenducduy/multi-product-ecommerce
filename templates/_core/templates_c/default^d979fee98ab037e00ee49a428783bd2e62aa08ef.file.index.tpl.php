<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:38
         compiled from "templates/default/_controller/cms/news/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11500682995e8ec276b34ab1-91612386%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd979fee98ab037e00ee49a428783bd2e62aa08ef' => 
    array (
      0 => 'templates/default/_controller/cms/news/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11500682995e8ec276b34ab1-91612386',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_paginate')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.paginate.php';
if (!is_callable('smarty_function_html_options')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.html_options.php';
?><ul class="breadcrumb">
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['menudashboard'];?>
</a> <span class="divider">/</span></li>
	<li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
">Tin tức</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>
       

<div class="page-header" rel="menu_news"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_list'];?>
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
		<li class="pull-right"><a class="pull-right btn btn-success" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/add"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="<?php echo $_SESSION['newsBulkToken'];?>
" />
				<table class="table table-striped">
		
				<?php if (count($_smarty_tpl->getVariable('newss')->value)>0){?>
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>  
							<th><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelId'];?>
</th>
							<th width="100"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelNcid'];?>
</th>
							<th width="100"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelImage'];?>
</th>
							<th><a href="<?php echo $_smarty_tpl->getVariable('filterUrl')->value;?>
sortby/title/sorttype/<?php if ($_smarty_tpl->getVariable('formData')->value['sortby']=='title'){?><?php if (((mb_detect_encoding($_smarty_tpl->getVariable('formData')->value['sorttype'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype']))!='DESC'){?>DESC<?php }else{ ?>ASC<?php }?><?php }?>"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelTitle'];?>
</a></th>
							
							<th><a href="<?php echo $_smarty_tpl->getVariable('filterUrl')->value;?>
sortby/countview/sorttype/<?php if ($_smarty_tpl->getVariable('formData')->value['sortby']=='countview'){?><?php if (((mb_detect_encoding($_smarty_tpl->getVariable('formData')->value['sorttype'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype']))!='DESC'){?>DESC<?php }else{ ?>ASC<?php }?><?php }?>"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCountview'];?>
</a></th>
							<th><a href="<?php echo $_smarty_tpl->getVariable('filterUrl')->value;?>
sortby/countreview/sorttype/<?php if ($_smarty_tpl->getVariable('formData')->value['sortby']=='countreview'){?><?php if (((mb_detect_encoding($_smarty_tpl->getVariable('formData')->value['sorttype'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype']))!='DESC'){?>DESC<?php }else{ ?>ASC<?php }?><?php }?>"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelCountreview'];?>
</a></th>
                            <th><a href="<?php echo $_smarty_tpl->getVariable('filterUrl')->value;?>
sortby/status/sorttype/<?php if ($_smarty_tpl->getVariable('formData')->value['sortby']=='status'){?><?php if (((mb_detect_encoding($_smarty_tpl->getVariable('formData')->value['sorttype'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('formData')->value['sorttype']))!='DESC'){?>DESC<?php }else{ ?>ASC<?php }?><?php }?>"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStatus'];?>
</a></th>
                            <th width="70"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="10">
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

					<?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('newss')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value){
?>
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="<?php echo $_smarty_tpl->getVariable('news')->value->id;?>
" <?php if (in_array($_smarty_tpl->getVariable('news')->value->id,$_smarty_tpl->getVariable('formData')->value['fbulkid'])){?>checked="checked"<?php }?>/></td>
							<td><?php echo $_smarty_tpl->getVariable('news')->value->id;?>
</td>
					        <td width="150"><small><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
news/index/ncid/<?php echo $_smarty_tpl->getVariable('news')->value->ncid;?>
"><?php echo $_smarty_tpl->getVariable('news')->value->getNewscategoryname();?>
</a></small></td>
							<td><img src="<?php if ($_smarty_tpl->getVariable('news')->value->image!=''){?><?php echo $_smarty_tpl->getVariable('news')->value->getSmallImage();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/default.jpg<?php }?>" style="width:100px;"/></td>
							<td><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/edit/id/<?php echo $_smarty_tpl->getVariable('news')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
"><?php echo $_smarty_tpl->getVariable('news')->value->title;?>
</a>
								<br /><small class="slugtext"><a href="<?php echo $_smarty_tpl->getVariable('news')->value->getNewsPath();?>
" target="_blank" title="Preview"><?php echo $_smarty_tpl->getVariable('news')->value->slug;?>
</a></small>
								
							</td>
							<td><span class="badge badge-info"><?php echo $_smarty_tpl->getVariable('news')->value->countview;?>
</span></td>
							<td><span class="badge badge-info"><?php echo $_smarty_tpl->getVariable('news')->value->countreview;?>
</span></td> 
							<td><?php if ($_smarty_tpl->getVariable('news')->value->checkStatusName('enable')){?>
                                    <span class="label label-success"><?php echo $_smarty_tpl->getVariable('news')->value->getStatusName();?>
</span>
                                <?php }else{ ?>
                                    <span class="label"><?php echo $_smarty_tpl->getVariable('news')->value->getStatusName();?>
</span>
                                <?php }?>
                            </td>                                                                    
							
							<td>
								<a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionEditTooltip'];?>
" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/edit/id/<?php echo $_smarty_tpl->getVariable('news')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" href="javascript:delm('<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/delete/id/<?php echo $_smarty_tpl->getVariable('news')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
?token=<?php echo $_SESSION['securityToken'];?>
');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
						<td width="180"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelNcid'];?>
</td>
						<td>
							<select name="fncid" id="fncid">
                                <option value="">---------------------------------</option>
				                <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('newscategoryList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
?>
								<?php if ($_smarty_tpl->getVariable('category')->value->parentid==0){?>
									</optgroup><optgroup label="<?php echo $_smarty_tpl->getVariable('category')->value->name;?>
">
								<?php }else{ ?>
									<option value="<?php echo $_smarty_tpl->getVariable('category')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('category')->value->name;?>
</option>
								<?php }?>
								<?php }} ?>  
                            </select>
                        </td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStatus'];?>
</td>
						<td>
							<select name="fstatus" id="fstatus">
                                <option value="">- - - -</option>
                                <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('statusList')->value,'selected'=>$_smarty_tpl->getVariable('formData')->value['fstatus']),$_smarty_tpl);?>

                            </select>
						</td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['formKeywordLabel'];?>
</td>
						<td>
							<input type="text" name="fkeyword" id="fkeyword" size="20" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fkeyword']);?>
" class="" />
						</td>
						<td>
							<select name="fsearchin" id="fsearchin">
			                    <option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['formKeywordInLabel'];?>
</option>
			                    <option value="title" <?php if ($_smarty_tpl->getVariable('formData')->value['fsearchin']=="title"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelTitle'];?>
</option>
			                    <option value="content" <?php if ($_smarty_tpl->getVariable('formData')->value['fsearchin']=="content"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelContent'];?>
</option>
			                    <option value="source" <?php if ($_smarty_tpl->getVariable('formData')->value['fsearchin']=="source"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSource'];?>
</option>
			                </select>
						</td>
					</tr>
					<tr>
						<td><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelId'];?>
</td>
						<td><input type="text" name="fid" id="fid"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="gosearch();"  /></td>
					</tr>
				</table>
				
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			


<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/news/index";
		 

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}

		var ncid = $('#fncid').val();
		if(ncid.length > 0)
		{
			path += '/ncid/' + ncid;
		}       

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}               
		
        var keyword = $("#fkeyword").val();
        if(keyword.length > 0)
        {
            path += "/keyword/" + keyword;
        }

        var keywordin = $("#fsearchin").val();
        if(keywordin.length > 0)
        {
            path += "/searchin/" + keywordin;
        }
        
		document.location.href= path;
	}
</script>

			
			


