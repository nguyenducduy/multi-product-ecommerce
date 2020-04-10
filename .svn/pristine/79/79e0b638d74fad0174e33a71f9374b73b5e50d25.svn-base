<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject">List Project</a>  <span class="divider"> /</span> </li>
    <li class="active">List Story Category <span class="divider">/</span></li>

</ul>


<div class="page-header" rel="menu_scrumstorycategory"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
        {if {$formData.permiss}=='1'}
            <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/spid/{$projectId}">{$lang.controller.head_add}</a></li>
        {/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumstorycategoryBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumstorycategorys|@count > 0}
					<thead>
						<tr>
						    <th>{$lang.controller.labelSpid}</th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.listStory}</th>							
							<th width="140"></th>
						</tr>
					</thead>
					<tbody>
					{foreach item=scrumstorycategory from=$scrumstorycategorys}
		
						<tr>							
							<td style="font-weight:bold;">{$scrumstorycategory->project}</td>
                            <td style="font-weight:bold;">{$scrumstorycategory->name}</td>
							
							<td><a href="{$conf.rooturl}{$controllerGroup}/scrumstory/index/categoryid/{$scrumstorycategory->id}"><span class="badge badge-info">{$scrumstorycategory->story}</span></a></td>
							
							<td>
                                {if {$scrumstorycategory->permiss}=='1'}
                                <a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$scrumstorycategory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$scrumstorycategory->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							    {/if}
                            </td>
						</tr>
			

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
				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>