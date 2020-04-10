<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ApiPartnerSaleRequest</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_apipartnersalerequest"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.apipartnersalerequestBulkToken}" />
				<table class="table table-striped">
		
				{if $apipartnersalerequests|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/apid/sorttype/{if $formData.sortby eq 'apid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelApid}</a></th>
							<th>{$lang.controller.labelParameter}</th>
							<th><a href="{$filterUrl}sortby/executetime/sorttype/{if $formData.sortby eq 'executetime'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelExecutetime}</a></th>
							<th><a href="{$filterUrl}sortby/record/sorttype/{if $formData.sortby eq 'record'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelRecord}</a></th>
							<th>{$lang.controller.labelIpaddress}</th>
							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>
							<th><a href="{$filterUrl}sortby/datemodified/sorttype/{if $formData.sortby eq 'datemodified'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatemodified}</a></th>
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
					{foreach item=apipartnersalerequest from=$apipartnersalerequests}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$apipartnersalerequest->id}" {if in_array($apipartnersalerequest->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$apipartnersalerequest->id}</td>
							
							<td>{$apipartnersalerequest->apipartneractor->name}</td>
							<td>{$apipartnersalerequest->parameter}</td>
							<td>{$apipartnersalerequest->executetime}</td>
							<td>{$apipartnersalerequest->record}</td>
							<td>{$apipartnersalerequest->ipaddress}</td>
							<td>{$apipartnersalerequest->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$apipartnersalerequest->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$apipartnersalerequest->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$apipartnersalerequest->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				<table>
					<tr>
						<td>{$lang.controller.labelApid}:</td>
						<td style="text-align: left;"><input type="text" name="fapid" id="fapid" value="{$formData.fapid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelParameter}:</td>
						<td style="text-align: left;"><input type="text" name="fparameter" id="fparameter" value="{$formData.fparameter|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelRecord}:</td>
						<td style="text-align: left;"><input type="text" name="frecord" id="frecord" value="{$formData.frecord|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelIpaddress}:</td>
						<td style="text-align: left;"><input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="text-align: left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.formKeywordLabel}:</td>
						<td style="text-align: left;">
							<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
							<select name="fsearchin" id="fsearchin">
								<option value="">{$lang.controller.formKeywordInLabel}</option>
								<option value="parameter" {if $formData.fsearchin eq "parameter"}selected="selected"{/if}>{$lang.controller.labelParameter}</option></select>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
					</tr>
				</table>
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/apipartnersalerequest/index";
		

		var apid = $('#fapid').val();
		if(apid.length > 0)
		{
			path += '/apid/' + apid;
		}

		var parameter = $('#fparameter').val();
		if(parameter.length > 0)
		{
			path += '/parameter/' + parameter;
		}

		var record = $('#frecord').val();
		if(record.length > 0)
		{
			path += '/record/' + record;
		}

		var ipaddress = $('#fipaddress').val();
		if(ipaddress.length > 0)
		{
			path += '/ipaddress/' + ipaddress;
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
			
			


