<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li class="active">List Project <span class="divider">/</span> </li>

</ul>









<div class="page-header" rel="menu_scrum"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
        {if {$formData.permiss}=='1'}
            <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
        {/if}



	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumprojectBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumprojects|@count > 0}
					<thead>
						<tr>
							{if {$formData.permiss}=='1'}
						         <th width="30"><input class="check-all" type="checkbox" /></th>
							{/if}
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							

							<th>Session</th>
							<th>{$lang.controller.labeliteration}</th>
							<th>{$lang.controller.labelTeam}</th>
							<th>{$lang.controller.labelTeammember}</th>
							<th>Count StoryCategory</th>
							<th width="140"></th>
						</tr>
					</thead>
					{if {$formData.permiss} =='1'}
					<tfoot>
						<tr>
							<td colspan="9">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div>

								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					{/if}
					<tbody>
					{foreach item=scrumproject from=$scrumprojects}
		
						<tr>
                            {if {$formData.permiss} =='1'}
							    <td><input type="checkbox" name="fbulkid[]" value="{$scrumproject->id}" {if in_array($scrumproject->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							{/if}
							<td style="font-weight:bold;">{$scrumproject->id}</td>


							<td>{$scrumproject->name}</td>
							<td style="font-weight:bold;"><a class="badge label-info" href ="{$conf.rooturl}{$controllerGroup}/scrumsession/index/spid/{$scrumproject->id}">{$scrumproject->countsession}<a></td>
							<td style="font-weight:bold;"><a class="badge label-info" href ="{$conf.rooturl}{$controllerGroup}/{$controller}/detail/spid/{$scrumproject->id}">{$scrumproject->countiteration}<a></td>
							<td style="font-weight:bold;"><a class="badge label-info" href ="{if {$scrumproject->countteam}>0}{$conf.rooturl}{$controllerGroup}/scrumteam/index/spid/{$scrumproject->id}{/if}">{$scrumproject->countteam}</a></td>
							<td style="font-weight:bold;"><a class="badge label-info" href ="{if {$scrumproject->countteammember}>0}{$conf.rooturl}{$controllerGroup}/scrumteammember/index/spid/{$scrumproject->id}{/if}">{$scrumproject->countteammember}<a></td>
							<td style="font-weight:bold;"><a class="badge label-info" href ="{if {$scrumproject->countteammember}>0}{$conf.rooturl}{$controllerGroup}/scrumstorycategory/index/spid/{$scrumproject->id}{/if}">{$scrumproject->countstorycategory}<a></td>


							<td>{if {$formData.permiss} =='1'}<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$scrumproject->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;{/if}
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
				
				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/scrumproject/index";
		
       
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
			
			


