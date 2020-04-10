<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Newsletter</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<a class="pull-right btn btn-success" href="{$conf.rooturl_admin}{$controller}/add">{$lang.controller.head_add}</a>

<div class="page-header" rel="menu_newsletter_list"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">
					
				{if $newsletters|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th align="left" width="30"><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">ID</a></th>	
                            
							<th align="left">Summary</th>				
							<th align="center">Preview</th>
                            <th align="center"><a href="{$filterUrl}sortby/sendcount/sorttype/{if $formData.sortby eq 'sendcount'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Send Count</a></th>
							
                            
							<th align="center"><a href="{$filterUrl}sortby/datemodified/sorttype/{if $formData.sortby eq 'datemodified'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Modified</a></th>
							
							<th align="center"><a href="{$filterUrl}sortby/datelastsent/sorttype/{if $formData.sortby eq 'datelastsent'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Last Sent</a></th>
							<th width="100"></th>
							<th width="140"></th>
						</tr>
					</thead>
					
					<tfoot>
						<tr>
							<td colspan="9">
								
								
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
						{foreach item=newsletter from=$newsletters}

							<tr>
								<td align="center"><input type="checkbox" name="fbulkid[]" value="{$newsletter->id}" {if in_array($newsletter->id, $formData.fbulkid)}checked="checked"{/if}/></td>
								<td style="font-weight:bold;"><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}newsletter/edit/id/{$newsletter->id}/redirect/{$redirectUrl}">{$newsletter->id}</a></td>

								<td>
									<strong><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}newsletter/edit/id/{$newsletter->id}/redirect/{$redirectUrl}">{$newsletter->subject}</a></strong><br />
									<small>{$newsletter->contents|strip_tags|truncateperiod:400}</small>
								</td>
								<td class="td_center">
									<a class="btn btn-inverse btn-mini" href="javascript:void(0)" onclick="window.open('{$conf.rooturl_admin}newsletter/preview/id/{$newsletter->id}', 'mywindow','location=1,status=1,scrollbars=1, width=740,height=500');" title="Click here to preview this email">Preview</a>
								</td>
	                            <td class="td_center" title="Number of Sent">{$newsletter->sendcount}</td>


								<td>{$newsletter->datemodified|date_format:"%e/%m/%Y"}</td>
								<td>{$newsletter->datelastsent|date_format:"%e/%m/%Y"}</td>
								<td><a class="btn btn-info btn-mini" title="Send this newsletter" href="{$conf.rooturl_admin}newsletter/sendtask/id/{$newsletter->id}/redirect/{$redirectUrl}">SEND TASK</a></td>
								<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}newsletter/edit/id/{$newsletter->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
									<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}newsletter/delete/id/{$newsletter->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</tr>


						{/foreach}
						
						
				</tbody>
					
				  
				{else}
					<tr>
						<td colspan="9"> {$lang.default.notfound}</td>
					</tr>
				{/if}
				
				</table>
			</form>
			
			
		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.default.formIdLabel}: 
				<input type="text" name="fid" id="fid" size="8" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 
				
				{$lang.controller.formKeywordLabel}:
				
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="text-input" />
					
									
				
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>


{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "newsletter/index";
		
		var id = $("#fid").val();
		if(parseInt(id) > 0)
		{
			path += "/id/" + id;
		}
		
		var keyword = $("#fkeyword").val();
		if(keyword.length > 0)
		{
			path += "/keyword/" + keyword;
		}
		
						
		document.location.href= path;
	}
</script>
{/literal}






