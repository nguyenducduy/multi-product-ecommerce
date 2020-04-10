<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">SubscriberProductoutofstock</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_subscriberproductoutofstock"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.subscriberproductoutofstockBulkToken}" />
				<table class="table table-striped">
		
				{if $subscriberproductoutofstocks|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/uid/sorttype/{if $formData.sortby eq 'uid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelUid}</a></th>
							<th><a href="{$filterUrl}sortby/pid/sorttype/{if $formData.sortby eq 'pid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPid}</a></th>
							<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
							<th>{$lang.controller.labelStatus}</th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th>{$lang.controller.labelDatemodified}</th>
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
					{foreach item=subscriberproductoutofstock from=$subscriberproductoutofstocks}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$subscriberproductoutofstock->id}" {if in_array($subscriberproductoutofstock->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$subscriberproductoutofstock->id}</td>
							
							<td>{$subscriberproductoutofstock->uid}</td>
							<td>{$subscriberproductoutofstock->pid}</td>
							<td>{$subscriberproductoutofstock->email}</td>
							<td>{$subscriberproductoutofstock->status}</td>
							<td>{$subscriberproductoutofstock->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$subscriberproductoutofstock->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$subscriberproductoutofstock->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$subscriberproductoutofstock->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				{$lang.controller.labelPid}: <input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelEmail}: <input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/subscriberproductoutofstock/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var pid = $('#fpid').val();
		if(pid.length > 0)
		{
			path += '/pid/' + pid;
		}

		var email = $('#femail').val();
		if(email.length > 0)
		{
			path += '/email/' + email;
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
			
			


