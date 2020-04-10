<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Program</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_program"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<!--<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>-->
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.programBulkToken}" />
				<table class="table table-striped">
		
				{if $programs|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<!--<th>{$lang.controller.labelUid}</th>-->
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<!--<th>{$lang.controller.labelDescription}</th>
							<th><a href="{$filterUrl}sortby/storelist/sorttype/{if $formData.sortby eq 'storelist'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStorelist}</a></th>-->
							<th>{$lang.controller.labelExecutetime}</th>
							<th>{$lang.controller.labelStartdate}</th>
							<th>{$lang.controller.labelDateend}</th>
							<th></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="7">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
					
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
					<tbody>
					{foreach item=program from=$programs}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$program->id}" {if in_array($program->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$program->id}</td>
							
							<!--<td>{$program->uid}</td>-->
							<td><strong>{$program->name}</strong></td>
							<!--<td>{$program->description}</td>
							<td>{$program->storelist}</td>-->
							<td>{$program->executetime|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$program->startdate|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$program->dateend|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td>
								<a title="{$lang.default.labelReportbutton}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/report/id/{$program->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.controller.labelReportbutton}</a> &nbsp;
								<a title="{$lang.default.labelExecutebutton}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/execute/id/{$program->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.controller.labelExecutebutton}</a> &nbsp;
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$program->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$program->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
						</tr>
			

					{/foreach}
					</tbody>
		
	  
				{else}
					<tr>
						<td colspan="7"> {$lang.default.notfound}</td>
					</tr>
				{/if}
	
				</table>
			</form>

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				<table>
					<tr><td>{$lang.controller.labelName}: </td><td><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge" /></td></tr>
					<tr><td>{$lang.controller.labelExecutetime}: </td><td><input type="text" name="fstorelist" id="fstorelist" value="{$formData.fstorelist|@htmlspecialchars}" class="input-xlarge" /></td></tr>
					<tr><td>{$lang.controller.labelStartdate}: </td><td><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-xlarge" /></td></tr>
					<tr><td>{$lang.controller.labelStore}: </td><td>
						<select name="fstorelist[]" id="fstorelist" multiple="multiple" class="input-xlarge" style="width: 290px;">
							{foreach from=$formData.liststores item=store}					
								<option{if !empty($formData.fstorelist) && in_array($store->id, $formData.fstorelist)} selected="selected"{/if} value="{$store->id}">{$store->name}</option>
							{/foreach}
						</select>
					</td></tr>
					<tr><td colspan="2"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td></tr>
				</table>
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/program/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var storelist = $('#fstorelist').val();
		if(storelist.length > 0)
		{
			path += '/storelist/' + storelist;
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
			
			


