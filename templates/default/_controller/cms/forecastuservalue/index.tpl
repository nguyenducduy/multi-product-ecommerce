<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ForecastUservalue</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_forecastuservalue"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.forecastuservalueBulkToken}" />
				<table class="table table-striped">
		
				{if $forecastuservalues|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/uid/sorttype/{if $formData.sortby eq 'uid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelUid}</a></th>
							<th>{$lang.controller.labelIdentifier}</th>
							<th>{$lang.controller.labelSheet}</th>
							<th>{$lang.controller.labelValue}</th>
							<th>{$lang.controller.labelDescription}</th>
							<th><a href="{$filterUrl}sortby/date/sorttype/{if $formData.sortby eq 'date'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDate}</a></th>
							<th>{$lang.controller.labelLevel}</th>
							<th>{$lang.controller.labelIsofficial}</th>
							<th>{$lang.controller.labelCanedit}</th>
							<th>{$lang.controller.labelCandelete}</th>
							<th>{$lang.controller.labelSessionid}</th>
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
					{foreach item=forecastuservalue from=$forecastuservalues}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$forecastuservalue->id}" {if in_array($forecastuservalue->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$forecastuservalue->id}</td>
							
							<td>{$forecastuservalue->uid}</td>
							<td>{$forecastuservalue->identifier}</td>
							<td>{$forecastuservalue->sheet}</td>
							<td>{$forecastuservalue->value}</td>
							<td>{$forecastuservalue->description}</td>
							<td>{$forecastuservalue->date}</td>
							<td>{$forecastuservalue->level}</td>
							<td>{$forecastuservalue->isofficial}</td>
							<td>{$forecastuservalue->canedit}</td>
							<td>{$forecastuservalue->candelete}</td>
							<td>{$forecastuservalue->sessionid}</td>
							<td>{$forecastuservalue->ipaddress}</td>
							<td>{$forecastuservalue->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$forecastuservalue->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$forecastuservalue->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$forecastuservalue->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIdentifier}: <input type="text" name="fidentifier" id="fidentifier" value="{$formData.fidentifier|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelSheet}: <input type="text" name="fsheet" id="fsheet" value="{$formData.fsheet|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelValue}: <input type="text" name="fvalue" id="fvalue" value="{$formData.fvalue|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDate}: <input type="text" name="fdate" id="fdate" value="{$formData.fdate|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelLevel}: <input type="text" name="flevel" id="flevel" value="{$formData.flevel|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIsofficial}: <input type="text" name="fisofficial" id="fisofficial" value="{$formData.fisofficial|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCanedit}: <input type="text" name="fcanedit" id="fcanedit" value="{$formData.fcanedit|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCandelete}: <input type="text" name="fcandelete" id="fcandelete" value="{$formData.fcandelete|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelSessionid}: <input type="text" name="fsessionid" id="fsessionid" value="{$formData.fsessionid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIpaddress}: <input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/forecastuservalue/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var identifier = $('#fidentifier').val();
		if(identifier.length > 0)
		{
			path += '/identifier/' + identifier;
		}

		var sheet = $('#fsheet').val();
		if(sheet.length > 0)
		{
			path += '/sheet/' + sheet;
		}

		var value = $('#fvalue').val();
		if(value.length > 0)
		{
			path += '/value/' + value;
		}

		var date = $('#fdate').val();
		if(date.length > 0)
		{
			path += '/date/' + date;
		}

		var level = $('#flevel').val();
		if(level.length > 0)
		{
			path += '/level/' + level;
		}

		var isofficial = $('#fisofficial').val();
		if(isofficial.length > 0)
		{
			path += '/isofficial/' + isofficial;
		}

		var canedit = $('#fcanedit').val();
		if(canedit.length > 0)
		{
			path += '/canedit/' + canedit;
		}

		var candelete = $('#fcandelete').val();
		if(candelete.length > 0)
		{
			path += '/candelete/' + candelete;
		}

		var sessionid = $('#fsessionid').val();
		if(sessionid.length > 0)
		{
			path += '/sessionid/' + sessionid;
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
		
		
		document.location.href= path;
	}
</script>
{/literal}
			
			


