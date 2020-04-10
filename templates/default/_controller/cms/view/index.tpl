<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">View</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_viewtracking"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.viewBulkToken}" />
				<table class="table table-striped">
		
				{if $views|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							                                    
							<th><a href="{$filterUrl}sortby/type/sorttype/{if $formData.sortby eq 'type'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelType}</a></th>
							<th>{$lang.controller.labelObjectid}</th>
							<th><a href="{$filterUrl}sortby/rel/sorttype/{if $formData.sortby eq 'rel'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelRel}</a></th>
							<th>{$lang.controller.labelIpaddress}</th>
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
					{foreach item=view from=$views}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$view->id}" {if in_array($view->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$view->id}</td>
							                 
							<td>
                                {if $view->checkTypeName('Product')}
                                    <span class="label label-warning">{$view->getTypeName()}</span>
                                {elseif $view->checkTypeName('News')}
                                    <span class="label label-info">{$view->getTypeName()}</span>
                                {else}
                                    <span class="label label-inverse">{$view->getTypeName()}</span>    
                                {/if}
                            </td>
							<td>{$view->objectid}</td>
							<td>{$view->rel}</td>
							<td>{$view->ipaddress}</td>
							<td>{$view->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td>
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$view->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				{$lang.controller.labelType}:   <select name="ftype" id="ftype">
                                                    {html_options options=$typeList selected=$formData.ftype}
                                                </select> -
				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="rel" {if $formData.fsearchin eq "rel"}selected="selected"{/if}>{$lang.controller.labelRel}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/view/index";
		
        
		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
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
			
			


