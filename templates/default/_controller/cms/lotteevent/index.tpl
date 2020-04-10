<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteEvent</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_lotteevent"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.lotteeventBulkToken}" />
				<table class="table table-striped">
		
				{if $lotteevents|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th><a href="{$filterUrl}sortby/datebegin/sorttype/{if $formData.sortby eq 'datebegin'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatebegin}</a></th>
							<th><a href="{$filterUrl}sortby/dateend/sorttype/{if $formData.sortby eq 'dateend'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDateend}</a></th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							<th><a href="{$filterUrl}sortby/pageid/sorttype/{if $formData.sortby eq 'pageid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPageid}</a></th>

							<th width="140"></th>
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
					{foreach item=lotteevent from=$lotteevents}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$lotteevent->id}" {if in_array($lotteevent->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;"><span class="badge badge-info">{$lotteevent->id}</span></td>
							
							<td>{$lotteevent->name}</td>
							<td>{$lotteevent->datebegin|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$lotteevent->dateend|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td><span class="label label-info">{if {$lotteevent->status}==1}Enable{else}Disable{/if}</span></td>
							<td>{$lotteevent->pageid}</td>

							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$lotteevent->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$lotteevent->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatebegin}: <input type="text" name="fdatebegin" id="fdatebegin" value="{$formData.fdatebegin|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDateend}: <input type="text" name="fdateend" id="fdateend" value="{$formData.fdateend|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPageid}: <input type="text" name="fpageid" id="fpageid" value="{$formData.fpageid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatecreated}: <input type="text" name="fdatecreated" id="fdatecreated" value="{$formData.fdatecreated|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatemodified}: <input type="text" name="fdatemodified" id="fdatemodified" value="{$formData.fdatemodified|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
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
		var path = rooturl + controllerGroup + "/lotteevent/index";
		

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var datebegin = $('#fdatebegin').val();
		if(datebegin.length > 0)
		{
			path += '/datebegin/' + datebegin;
		}

		var dateend = $('#fdateend').val();
		if(dateend.length > 0)
		{
			path += '/dateend/' + dateend;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var pageid = $('#fpageid').val();
		if(pageid.length > 0)
		{
			path += '/pageid/' + pageid;
		}

		var datecreated = $('#fdatecreated').val();
		if(datecreated.length > 0)
		{
			path += '/datecreated/' + datecreated;
		}

		var datemodified = $('#fdatemodified').val();
		if(datemodified.length > 0)
		{
			path += '/datemodified/' + datemodified;
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
			
			


