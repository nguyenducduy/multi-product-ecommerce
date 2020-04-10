<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Crazydeal</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_crazydeal"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.crazydealBulkToken}" />
				<table class="table table-striped">
		
				{if $crazydeals|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelUid}</th>
							<th>{$lang.controller.labelPid}</th>
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th>{$lang.controller.labelImage}</th>
							<th>{$lang.controller.labelDescription}</th>
							<th>{$lang.controller.labelStarttime}</th>
							<th>{$lang.controller.labelExpiretime}</th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							<th>{$lang.controller.labelDatecreated}</th>
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
					{foreach item=crazydeal from=$crazydeals}
						
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$crazydeal->id}" {if in_array($crazydeal->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$crazydeal->id}</td>
							
							<td>{$crazydeal->uid}</td>
							<td><span class="label label-info">{$crazydeal->pid}</span></td>
							<td><a target="_blank" href="{$crazydeal->getProductPathByPid()}"><span class="label label-success">{$crazydeal->name}</span></a></td>
							<td><img src="{$crazydeal->getSmallImage()}" /></td>
							<td>{$crazydeal->description}</td>

							<td>{$crazydeal->starttime|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>
								
								 {if $smarty.now>$ads->dateend}
                               		<label class="label label-important">{$crazydeal->expiretime|date_format:$lang.default.dateFormatTimeSmarty}</label>
                               	{else}
                               		{$crazydeal->expiretime|date_format:$lang.default.dateFormatTimeSmarty}
                                {/if}
							</td>
							<td>
								{if $crazydeal->checkStatusName('enable')}
									<span class="label label-info">{$crazydeal->getstatusName()}</span>
								{elseif $crazydeal->checkStatusName('disable')}
									<span class="label label">{$crazydeal->getstatusName()}</span>
								{elseif $crazydeal->checkStatusName('expired')}
									<span class="label label-important">{$crazydeal->getstatusName()}</span>
								{/if}
							</td>
							<td>{$crazydeal->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$crazydeal->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$crazydeal->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelPid}: <input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/crazydeal/index";
		

		var pid = $('#fpid').val();
		if(pid.length > 0)
		{
			path += '/pid/' + pid;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
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
		
		
		document.location.href= path;
	}
</script>
{/literal}
			
			


