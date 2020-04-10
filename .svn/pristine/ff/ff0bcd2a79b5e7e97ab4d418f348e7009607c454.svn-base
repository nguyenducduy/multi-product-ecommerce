<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Newsletter Unscriber</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<a class="pull-right btn btn-success" href="{$conf.rooturl_admin}{$controller}/add">{$lang.controller.head_add}</a>

<div class="page-header" rel="menu_newsletter_unscriber"><h1>{$lang.controller.head_list}</h1></div>


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
					
				{if $unscribers|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th align="left" width="30"><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">ID</a></th>	
                            <th align="left"><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Email</a></th>				
							
                            <th>Type</th>
							<th>IP Address</th>
                            <th align="center">Date created</th>
                            
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
						{foreach item=unscriber from=$unscribers}

							<tr>
								<td align="center"><input type="checkbox" name="fbulkid[]" value="{$unscriber->id}" {if in_array($unscriber->id, $formData.fbulkid)}checked="checked"{/if}/></td>
								<td style="font-weight:bold;"><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}newsletterunscriber/edit/id/{$unscriber->id}/redirect/{$redirectUrl}">{$unscriber->id}</a></td>

								<td>
	                            	<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}newsletterunscriber/edit/id/{$unscriber->id}/redirect/{$redirectUrl}"><b>{$unscriber->email}</b></a>
	                            </td>
								<td><span class="label">{$unscriber->getTypeName()}</span></td>
								<td>{$unscriber->ipaddress}</td>

	                            <td class="td_center" title="Number of Fav">{$unscriber->datecreated|date_format:"%e/%m/%Y"}</td>

								<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}newsletterunscriber/edit/id/{$unscriber->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
									<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}newsletterunscriber/delete/id/{$unscriber->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				
				Type: 
				<select name="ftype" id="ftype">
					<option value="0">- - - -</option>
					{html_options options=$typeList selected=$formData.ftype}
				</select> -
				
				
				{$lang.controller.formKeywordLabel}:
				
					<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="text-input" />
					
					<select name="fsearchin" id="fsearchin" style="display:none;">
						<option value="email" selected="selected">{$lang.controller.formKeywordInEmailLabel}</option>
					</select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>


{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "newsletterunscriber/index";
		
		var id = $("#fid").val();
		if(parseInt(id) > 0)
		{
			path += "/id/" + id;
		}
		
		var type = $("#ftype").val();
		if(parseInt(type) > 0)
		{
			path += "/type/" + type;
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






