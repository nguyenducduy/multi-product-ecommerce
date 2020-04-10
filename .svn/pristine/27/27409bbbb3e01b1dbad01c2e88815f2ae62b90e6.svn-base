<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Keyword</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_keyword"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.keywordBulkToken}" />
				<table class="table table-striped">
		
				{if $keywords|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<!--<th width="30">{$lang.controller.labelId}</th>-->
							
							<th>{$lang.controller.labelText}</th>
							<th>{$lang.controller.labelSlug}</th>
							<th><a href="{$filterUrl}sortby/counttotal/sorttype/{if $formData.sortby eq 'counttotal'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCounttotal}</a></th>
							<th><a href="{$filterUrl}sortby/countproduct/sorttype/{if $formData.sortby eq 'countproduct'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountproduct}</a></th>
							<th><a href="{$filterUrl}sortby/countnews/sorttype/{if $formData.sortby eq 'countnews'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountnews}</a></th>
							<th><a href="{$filterUrl}sortby/countstuff/sorttype/{if $formData.sortby eq 'countstuff'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountstuff}</a></th>
							<th>{$lang.controller.labelFrom}</th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							<!--
							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>
							<th><a href="{$filterUrl}sortby/datemodified/sorttype/{if $formData.sortby eq 'datemodified'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatemodified}</a></th>
							-->
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
					{foreach item=keyword from=$keywords}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$keyword->id}" {if in_array($keyword->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<!--<td style="font-weight:bold;">{$keyword->id}</td>-->
							
							<td>{$keyword->text}</td>
							<td>{$keyword->slug}</td>
							<td><span class="badge badge-info">{$keyword->counttotal}</span></td>
							<td><span class="badge badge-info">{$keyword->countproduct}</span></td>
							<td><span class="badge badge-info">{$keyword->countnews}</span></td>
							<td><span class="badge badge-info">{$keyword->countstuff}</span></td>
							<td>
								{if $keyword->checkTypeName('product')}
                                    <span class="label label-warning">{$keyword->getTypeName()}</span>
                                {elseif $keyword->checkTypeName('news')}
                                	<span class="label label-info">{$keyword->getTypeName()}</span>
                            	{else}
                                    <span class="label label-inverse">{$keyword->getTypeName()}</span>
                                {/if}
							</td>
							<td>
								{if $keyword->checkStatusName('enable')}
                                    <span class="label label-success">{$keyword->getStatusName()}</span>
                                {else}
                                    <span class="label label-important">{$keyword->getStatusName()}</span>
                                {/if}
							</td>
							<!--
							<td>{$keyword->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$keyword->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td>
							-->
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$keyword->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$keyword->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelFrom}: 
					<select name="ffrom" id="ffrom">
						<option value="0">- - - -</option>
		                {html_options options=$typeList selected=$formData.ffrom}
		            </select> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="text" {if $formData.fsearchin eq "text"}selected="selected"{/if}>{$lang.controller.labelText}</option>
					<option value="slug" {if $formData.fsearchin eq "slug"}selected="selected"{/if}>{$lang.controller.labelSlug}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/keyword/index";
		

		var from = $('#ffrom').val();
		if(from.length > 0)
		{
			path += '/from/' + from;
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
			
			


