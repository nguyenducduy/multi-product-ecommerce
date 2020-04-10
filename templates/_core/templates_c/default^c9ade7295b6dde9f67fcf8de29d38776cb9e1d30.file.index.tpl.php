<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:22:49
         compiled from "templates/default/_controller/profile/file/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17123300035e8ecd494d9e30-64563783%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9ade7295b6dde9f67fcf8de29d38776cb9e1d30' => 
    array (
      0 => 'templates/default/_controller/profile/file/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17123300035e8ecd494d9e30-64563783',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.date_format.php';
?>


<div class="page-header" rel="menu_file" style="margin-bottom:0;display:none;"><h1><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_list'];?>

	<?php if (count($_smarty_tpl->getVariable('parentDirectoryList')->value)>0){?>
	<?php  $_smarty_tpl->tpl_vars['directory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('parentDirectoryList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['directory']->key => $_smarty_tpl->tpl_vars['directory']->value){
?>
		\\ <?php echo $_smarty_tpl->getVariable('directory')->value->name;?>

	<?php }} ?>
	<?php }?>
	
	<?php if ($_smarty_tpl->getVariable('currentDirectory')->value->id>0){?>\\ <?php echo $_smarty_tpl->getVariable('currentDirectory')->value->name;?>
<?php }?>
</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs hide">
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
	</ul>
	
	<div id="filebuttonbar">
		<div id="filebuttonbarleft" class="pull-left">
			<a class="btn btn-info" href="javascript:void(0)" onclick="file_search()"><i class="icon-search"></i></a>
			
			<div class="btn-group">
				
				
				<a class="btn btn-inverse" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
"><i class="icon-hdd"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_list'];?>
</a>
				
				<?php  $_smarty_tpl->tpl_vars['directory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('parentDirectoryList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['directory']->key => $_smarty_tpl->tpl_vars['directory']->value){
?>
					<a class="btn btn-inverse" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/index/parentid/<?php echo $_smarty_tpl->getVariable('directory')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('directory')->value->name;?>
</a>
				<?php }} ?>
				
				
				<?php if ($_smarty_tpl->getVariable('currentDirectory')->value->id>0){?><a class="btn btn-inverse" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/index/parentid/<?php echo $_smarty_tpl->getVariable('currentDirectory')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('currentDirectory')->value->name;?>
</a><?php }?>
				
				
			</div>
			
			<?php if ($_smarty_tpl->getVariable('formData')->value['fkeyword']!=''){?>
				<a class="btn">Search Result(s) for keyword "<em><?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('formData')->value['fkeyword']);?>
"</em></a>
			<?php }?>
		</div><!-- end #filebuttonbarleft -->
		
		<?php if ($_smarty_tpl->getVariable('formData')->value['fkeyword']==''){?>
		<div id="filebuttonbarright" class="pull-right">
				<a class="btn btn-warning" id="btncreatedirectory" href="javascript:void(0)" onclick="file_newdirectory(<?php echo $_smarty_tpl->getVariable('formData')->value['fparentid'];?>
)"><i class="icon-folder-close"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['createDirectory'];?>
</a>
				<a class="btn btn-success" rel="shadowbox;width=800;height=500" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/add/parentid/<?php echo $_smarty_tpl->getVariable('formData')->value['fparentid'];?>
"><i class="icon-arrow-up"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['head_add'];?>
</a>
		</div><!-- end #filebuttonbarleft -->
		<?php }?>
		
		<div class="cl"></div>
	</div><!-- end #filebuttonbar -->
	
	
	
	<div class="tab-content" style="padding:0;background:none;">
		
		
		
		<div class="tab-pane active" id="tab1">

			<?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="<?php echo $_SESSION['fileBulkToken'];?>
" />
				<table class="table table-hover" id="filedirectorytable">
		
				<?php if (count($_smarty_tpl->getVariable('files')->value)>0){?>
					
					<tbody>
					<?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('files')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value){
?>
						<?php if ($_smarty_tpl->getVariable('file')->value->isdirectory==1){?>
							<tr id="file-<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
">
								<td width="48"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/index/parentid/<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
admin/general_folder.png" /></a></td>
								<td><a class="filedirectorytitle" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/index/parentid/<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('file')->value->name;?>
<?php if ($_smarty_tpl->getVariable('file')->value->checkStatusName('enable')==false){?> <span class="label"><i class="icon-lock"></i> Disabled Sharing</span><?php }?></a>
									<div class="filedirectorydatecreated"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDatecreated'];?>
: <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('file')->value->datecreated,"%d/%m/%Y");?>
</div>
								</td>
								<td>
									<div class="btn-group">
										<a title="" href="#file<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
publicurl" rel="shadowbox;width=700;height=100" class="btn btn-mini"><i class="icon-share"></i> Share URL</a> &nbsp;
										
										<a title="" href="javascript:void(0)" onclick="file_renamedirectory(<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
, '<?php echo $_smarty_tpl->getVariable('file')->value->name;?>
', '<?php echo $_SESSION['securityToken'];?>
')" class="btn  btn-mini btnrename hide"><i class="icon-pencil"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['rename'];?>
</a> &nbsp;
										
										<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/edit/id/<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
" rel="shadowbox;width=800;height=500" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
										
										<a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" href="javascript:void(0)" onclick="file_deletedirectory(<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
, '<?php echo $_SESSION['securityToken'];?>
', '<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['directoryDeleteConfirm'];?>
', '<?php echo $_smarty_tpl->getVariable('file')->value->name;?>
')" class="btn btn-mini btn-danger btndelete"><i class="icon-remove icon-white"></i></a>
									</div>
								</td>
							</tr>
						<?php }else{ ?>
							<tr id="file-<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
">
								<td width="48"><a href="javascript:void(0)"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
admin/filetype/<?php echo $_smarty_tpl->getVariable('file')->value->extension;?>
.png" width="36px" style="padding:6px;" /></a></td>
								<td><a class="filedirectorytitle" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/index/parentid/<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('file')->value->name;?>
<?php if ($_smarty_tpl->getVariable('file')->value->checkStatusName('enable')==false){?> <span class="label"><i class="icon-lock"></i> Disabled Sharing</span><?php }?></a>
									<div class="filedirectorydatecreated"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelDateuploaded'];?>
: <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('file')->value->datecreated,"%d/%m/%Y");?>
</div>
								</td>
								<td>
									<div class="btn-group">
										<a title="" href="<?php echo $_smarty_tpl->getVariable('file')->value->getDownloadUrl();?>
" class="btn btn-mini"><i class="icon-download-alt"></i> Download</a> &nbsp;
										
										<div id="file<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
publicurl" class="hide"><div class="filepublicurl"><?php echo $_smarty_tpl->getVariable('file')->value->getPublicUrl();?>
</div></div>
										<a title="" href="#file<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
publicurl" rel="shadowbox;width=700;height=100" class="btn btn-mini"><i class="icon-share"></i> Share URL</a> &nbsp;
										
										<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
/<?php echo $_smarty_tpl->getVariable('controller')->value;?>
/edit/id/<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
/redirect/<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
" rel="shadowbox;width=800;height=500" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
										<a title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['formActionDeleteTooltip'];?>
" href="javascript:void(0)" onclick="file_deletefile(<?php echo $_smarty_tpl->getVariable('file')->value->id;?>
, '<?php echo $_SESSION['securityToken'];?>
', '<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['fileDeleteConfirm'];?>
', '<?php echo $_smarty_tpl->getVariable('file')->value->name;?>
')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
									</div>
								</td>
							</tr>
						<?php }?>
			

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
				<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelIsstarred'];?>
: <input type="text" name="fisstarred" id="fisstarred" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fisstarred']);?>
" class="input-mini" /> - 

				<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelStatus'];?>
: <input type="text" name="fstatus" id="fstatus" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fstatus']);?>
" class="input-mini" /> - 

				<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelPermission'];?>
: <input type="text" name="fpermission" id="fpermission" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fpermission']);?>
" class="input-mini" /> - 

				<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelId'];?>
: <input type="text" name="fid" id="fid" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fid']);?>
" class="input-mini" /> - 

				
				<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['formKeywordLabel'];?>
:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="<?php echo htmlspecialchars($_smarty_tpl->getVariable('formData')->value['fkeyword']);?>
" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value=""><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['formKeywordInLabel'];?>
</option>
					<option value="name" <?php if ($_smarty_tpl->getVariable('formData')->value['fsearchin']=="name"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelName'];?>
</option>
					<option value="summary" <?php if ($_smarty_tpl->getVariable('formData')->value['fsearchin']=="summary"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['labelSummary'];?>
</option></select>
				
				<input type="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['filterSubmit'];?>
" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			


<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/file/index";
		

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}


		var isstarred = $('#fisstarred').val();
		if(isstarred.length > 0)
		{
			path += '/isstarred/' + isstarred;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}


		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
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

			
			


