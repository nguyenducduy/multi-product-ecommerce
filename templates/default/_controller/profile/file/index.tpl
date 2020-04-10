


<div class="page-header" rel="menu_file" style="margin-bottom:0;display:none;"><h1>{$lang.controller.head_list}
	{if $parentDirectoryList|@count > 0}
	{foreach item=directory from=$parentDirectoryList}
		\\ {$directory->name}
	{/foreach}
	{/if}
	
	{if $currentDirectory->id > 0}\\ {$currentDirectory->name}{/if}
</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs hide">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	
	<div id="filebuttonbar">
		<div id="filebuttonbarleft" class="pull-left">
			<a class="btn btn-info" href="javascript:void(0)" onclick="file_search()"><i class="icon-search"></i></a>
			
			<div class="btn-group">
				
				
				<a class="btn btn-inverse" href="{$conf.rooturl}{$controllerGroup}/{$controller}"><i class="icon-hdd"></i> {$lang.controller.head_list}</a>
				
				{foreach item=directory from=$parentDirectoryList}
					<a class="btn btn-inverse" href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$directory->id}">{$directory->name}</a>
				{/foreach}
				
				
				{if $currentDirectory->id > 0}<a class="btn btn-inverse" href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$currentDirectory->id}">{$currentDirectory->name}</a>{/if}
				
				
			</div>
			
			{if $formData.fkeyword != ''}
				<a class="btn">Search Result(s) for keyword "<em>{$formData.fkeyword|strip_tags}"</em></a>
			{/if}
		</div><!-- end #filebuttonbarleft -->
		
		{if $formData.fkeyword == ''}
		<div id="filebuttonbarright" class="pull-right">
				<a class="btn btn-warning" id="btncreatedirectory" href="javascript:void(0)" onclick="file_newdirectory({$formData.fparentid})"><i class="icon-folder-close"></i> {$lang.controller.createDirectory}</a>
				<a class="btn btn-success" rel="shadowbox;width=800;height=500" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/parentid/{$formData.fparentid}"><i class="icon-arrow-up"></i> {$lang.controller.head_add}</a>
		</div><!-- end #filebuttonbarleft -->
		{/if}
		
		<div class="cl"></div>
	</div><!-- end #filebuttonbar -->
	
	
	
	<div class="tab-content" style="padding:0;background:none;">
		
		
		
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.fileBulkToken}" />
				<table class="table table-hover" id="filedirectorytable">
		
				{if $files|@count > 0}
					
					<tbody>
					{foreach item=file from=$files}
						{if $file->isdirectory == 1}
							<tr id="file-{$file->id}">
								<td width="48"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$file->id}"><img src="{$imageDir}admin/general_folder.png" /></a></td>
								<td><a class="filedirectorytitle" href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$file->id}">{$file->name}{if $file->checkStatusName('enable') == false} <span class="label"><i class="icon-lock"></i> Disabled Sharing</span>{/if}</a>
									<div class="filedirectorydatecreated">{$lang.controller.labelDatecreated}: {$file->datecreated|date_format:"%d/%m/%Y"}</div>
								</td>
								<td>
									<div class="btn-group">
										<a title="" href="#file{$file->id}publicurl" rel="shadowbox;width=700;height=100" class="btn btn-mini"><i class="icon-share"></i> Share URL</a> &nbsp;
										
										<a title="" href="javascript:void(0)" onclick="file_renamedirectory({$file->id}, '{$file->name}', '{$smarty.session.securityToken}')" class="btn  btn-mini btnrename hide"><i class="icon-pencil"></i> {$lang.controller.rename}</a> &nbsp;
										
										<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$file->id}/redirect/{$redirectUrl}" rel="shadowbox;width=800;height=500" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
										
										<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" onclick="file_deletedirectory({$file->id}, '{$smarty.session.securityToken}', '{$lang.controller.directoryDeleteConfirm}', '{$file->name}')" class="btn btn-mini btn-danger btndelete"><i class="icon-remove icon-white"></i></a>
									</div>
								</td>
							</tr>
						{else}
							<tr id="file-{$file->id}">
								<td width="48"><a href="javascript:void(0)"><img src="{$imageDir}admin/filetype/{$file->extension}.png" width="36px" style="padding:6px;" /></a></td>
								<td><a class="filedirectorytitle" href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$file->id}">{$file->name}{if $file->checkStatusName('enable') == false} <span class="label"><i class="icon-lock"></i> Disabled Sharing</span>{/if}</a>
									<div class="filedirectorydatecreated">{$lang.controller.labelDateuploaded}: {$file->datecreated|date_format:"%d/%m/%Y"}</div>
								</td>
								<td>
									<div class="btn-group">
										<a title="" href="{$file->getDownloadUrl()}" class="btn btn-mini"><i class="icon-download-alt"></i> Download</a> &nbsp;
										
										<div id="file{$file->id}publicurl" class="hide"><div class="filepublicurl">{$file->getPublicUrl()}</div></div>
										<a title="" href="#file{$file->id}publicurl" rel="shadowbox;width=700;height=100" class="btn btn-mini"><i class="icon-share"></i> Share URL</a> &nbsp;
										
										<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$file->id}/redirect/{$redirectUrl}" rel="shadowbox;width=800;height=500" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
										<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" onclick="file_deletefile({$file->id}, '{$smarty.session.securityToken}', '{$lang.controller.fileDeleteConfirm}', '{$file->name}')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
									</div>
								</td>
							</tr>
						{/if}
			

					{/foreach}
					</tbody>
		
	  
				{else}
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
				{/if}
	
				</table>
			</form>

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelIsstarred}: <input type="text" name="fisstarred" id="fisstarred" value="{$formData.fisstarred|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPermission}: <input type="text" name="fpermission" id="fpermission" value="{$formData.fpermission|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
					<option value="summary" {if $formData.fsearchin eq "summary"}selected="selected"{/if}>{$lang.controller.labelSummary}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
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
{/literal}
			
			


