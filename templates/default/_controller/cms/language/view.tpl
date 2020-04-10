<h2>{$lang.controller.head_list}</h2>
<div id="page-intro">{$lang.controller.intro_list}</div>




<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">		
		<h3>{$lang.controller.title_list}</h3>
		
		<div class="clear"></div>  
	</div> <!-- End .content-box-header -->
	
	
	<div class="content-box-content">
		<form method="get" action="">
			<input type="text" class="text-input" name="keyword" value="{$smarty.get.keyword}" /><input type="submit" value="SEARCH" />
		</form>
		<br />
		{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
		
		{if $foundList|@count > 0}
			<h3></h3>
			<div class="langfolder" style="width:100%;">
			<ul>
				<li class="langfolder_folder">Found language xml file with string "<em>{$smarty.get.keyword}</em>"
					<ul>
						{foreach item=fileinfo from=$foundList}
							<li class="langfolder_file"><a href="{$conf.rooturl_admin}language/edit/folder/{$fileinfo.folder}/subfolder/{$fileinfo.subfolder}/file/{$fileinfo.file}?highlight={$smarty.get.keyword}">{$fileinfo.fullpath}</a></li>
						{/foreach}
					</ul>
				</li>
			</ul>
			</div>
			<div class="clear"></div>
		{/if}
	</div>
	
	
	
	<div class="content-box-content">
		{foreach item=language from=$langPacks}
			<div class="langfolder">
				<div class="langfolder_langpack">
					{$language.folder}
				</div>
				<ul>
					{foreach item=groupfiles key=groupname from=$language.controllergroup}
						<li class="langfolder_folder">
							{$groupname}
							<ul>
								{foreach item=langfile from=$groupfiles}
									<li class="langfolder_file">
										<a href="{$conf.rooturl_admin}language/edit/folder/{$language.folder}/subfolder/{$groupname}/file/{$langfile}">{$langfile}</a>
									</li>
								{/foreach}
							</ul>
						</li>
					{/foreach}
					
					{foreach item=langfile from=$language.files}
						<li class="langfolder_file">
							<a href="{$conf.rooturl_admin}language/edit/folder/{$language.folder}/file/{$langfile}">{$langfile}</a>
						</li>
					{/foreach}
				</ul>
				
			</div>
		{/foreach}
	
		<div class="clear">&nbsp;</div>
	</div>
	
	
	
	

    	
</div>



