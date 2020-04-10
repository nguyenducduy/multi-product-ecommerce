


<div class="tabbable">
	<ul class="nav nav-tabs hide">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} ({$total})</a></li>
	</ul>
	
	<div id="filebuttonbar">
		<div id="filebuttonbarleft" class="pull-left">
			<div class="btn-group">
				
				
				{foreach item=directory from=$parentDirectoryList}
					<a class="btn btn-inverse" href="{$myFile->getPublicUrl()}/b/{$directory->id}">{$directory->name}</a>
				{/foreach}
				
				
				{if $currentDirectory->id > 0}<a class="btn btn-inverse" href="{$myFile->getPublicUrl()}/b/{$currentDirectory->id}">{$currentDirectory->name}</a>{/if}
				
				
			</div>
			
		</div><!-- end #filebuttonbarleft -->
		
		<div class="cl"></div>
	</div><!-- end #filebuttonbar -->
	
	
	
	<div class="tab-content" style="padding:0;background:none;">
		
		
		
		<div class="tab-pane active" id="tab1">

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-hover" id="filedirectorytable">
		
				{if $files|@count > 0}
					
					<tbody>
					{foreach item=file from=$files}
						{if $file->isdirectory == 1}
							<tr id="file-{$file->id}">
								<td width="48"><a href="{$myFile->getPublicUrl()}/b/{$file->id}"><img src="{$imageDir}admin/general_folder.png" /></a></td>
								<td><a class="filedirectorytitle" href="{$myFile->getPublicUrl()}/b/{$file->id}">{$file->name}</a>
									<div class="filedirectorydatecreated">{$lang.controller.labelDatecreated}: {$file->datecreated|date_format:"%d/%m/%Y"}</div>
								</td>
								<td>
								</td>
							</tr>
						{else}
							<tr id="file-{$file->id}">
								<td width="48"><a href="javascript:void(0)"><img src="{$imageDir}admin/filetype/{$file->extension}.png" width="36px" style="padding:6px;" /></a></td>
								<td><a class="filedirectorytitle" href="{$myFile->getPublicUrl()}/l/{$file->id}/lt/{$file->publictoken}/d/1">{$file->name}</a>
									<div class="filedirectorydatecreated">{$lang.controller.labelDateuploaded}: {$file->datecreated|date_format:"%d/%m/%Y"}</div>
								</td>
								<td>
									<div class="btn-group">
										<a title="" href="{$file->getPublicUrl()}/d/1" class="btn btn-mini"><i class="icon-download-alt"></i> Download</a> &nbsp;										
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
		
	</div>
</div>
			
			



