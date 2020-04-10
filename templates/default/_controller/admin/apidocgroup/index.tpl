<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">API DOCS</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_apidocgroup"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.apidocgroupBulkToken}" />
				<table class="table table-striped">
		
				{if $apidocgroups|@count > 0}
					<thead>
						<tr>
							<th width="80">Display Order</th>
							<th>{$lang.controller.labelName}</th>
							<th>Zone</th>
							<th>{$lang.controller.labelSummary}</th>
							<th width="220"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
								<div class="bulk-actions align-left">
									<input type="submit" name="fsubmitchangeorder" class="btn btn-primary" value="Update Display Order" />
								</div>
								
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=apidocgroup from=$apidocgroups}
		
						<tr>
							<td><input type="text" name="fgroupdisplayorder[{$apidocgroup->id}]" value="{$apidocgroup->displayorder}" class="input-mini" style="width:50px;padding:0 5px;" /></td>
							<td><span class="label label-success"><big>{$apidocgroup->name}</big></span><em><small>{if $apidocgroup->checkStatusName('implement') == false} - {$apidocgroup->getStatusName()}{/if}</small></em></td>
							<td><span class="label label-warning">{$apidocgroup->getZoneName()}</span></td>
							<td><strong>{$apidocgroup->summary}</strong></td>
							
							<td><a href="{$conf.rooturl}{$controllerGroup}/apidocrequest/add?agid={$apidocgroup->id}" rel="shadowbox;height=600" class="btn btn-mini"><i class="icon-plus"></i> Request</a> &nbsp;
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$apidocgroup->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$apidocgroup->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
						</tr>
						
						{if $apidocgroup->requestList|@count > 0}
							{foreach item=request from=$apidocgroup->requestList}
								<tr>
									<td></td>
									<td colspan="2"><input title="Display Order" type="text" name="frequestdisplayorder[{$request->id}]" value="{$request->displayorder}" class="input-mini" style="font-size:smaller;padding:0px;width:30px;text-align:center;line-height:1;" /> <a href="{$conf.rooturl}{$controllerGroup}/apidocrequest/edit/id/{$request->id}/redirect/{$redirectUrl}" rel="shadowbox;height=600;"><span class="label">{$request->name}</span></a></td>
									<td>{$request->summary}</td>
									<td>
									<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/apidocrequest/delete/id/{$request->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
								</tr>
							{/foreach}
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				Zone: <select name="fzone" id="fzone">
					<option value="">All Zone</option>
					{html_options options=$zoneList selected=$formData.fzone}
				</select>
				
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
		var path = rooturl + controllerGroup + "/apidocgroup/index";
		

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}


		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}

		var zone = $('#fzone').val();
		if(fzone.length > 0)
		{
			path += '/zone/' + zone;
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
			
			


