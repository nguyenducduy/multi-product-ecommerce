<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Page</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>
       

<div class="page-header" rel="menu_page"><h1>{$lang.controller.head_list}</h1></div>  

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
		<li class="pull-right"><a class="pull-right btn" href="{$conf.rooturl}{$controllerGroup}/pagetheme">Theme Manager</a></li>
		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.pageBulkToken}" />
				<table class="table table-striped">
		
				{if $pages|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>  
							
							<th width="200px;"><a href="{$filterUrl}sortby/title/sorttype/{if $formData.sortby eq 'title'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelTitle}</a></th>
							<th>{$lang.controller.labelContent}</th>
							<th><a href="{$filterUrl}sortby/countview/sorttype/{if $formData.sortby eq 'countview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountview}</a></th>
							<th><a href="{$filterUrl}sortby/countreview/sorttype/{if $formData.sortby eq 'countreview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreview}</a></th>
                            <th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
                            <th width="130px;"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="10">
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

					{foreach item=page from=$pages}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$page->id}" {if in_array($page->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$page->id}/redirect/{$redirectUrl}" class="tipsy-trigger" title="{$page->slug}">{$page->title}</a>
								<br /><small><a href="{$page->getPagePath()}" style="color:#000" target="_blank" title="Preview">{$page->slug}</a></small>
							</td>
							<td><small>{$page->content|strip_tags|truncate:200}</small></td>
							<td><span class="badge badge-info">{$page->countview}</span></td>
							<td><span class="badge badge-info">{$page->countreview}</span></td> 
							<td>{if $page->checkStatusName('enable')}
                                    <span class="label label-success">{$page->getStatusName()}</span>
                                {else}
                                    <span class="label label-important">{$page->getStatusName()}</span>
                                {/if}
                            </td>                                                                    
							
							<td>
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$page->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$page->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				{$lang.controller.formKeywordLabel}:
                <input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
                <select name="fsearchin" id="fsearchin">
                    <option value="">{$lang.controller.formKeywordInLabel}</option>
                    <option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option>
                    <option value="content" {if $formData.fsearchin eq "content"}selected="selected"{/if}>{$lang.controller.labelContent}</option>
                </select> -
                
				{$lang.controller.labelStatus}: <select name="fstatus" id="fstatus">
                                                    <option value="">- - - -</option>
                                                    {html_options options=$statusList selected=$formData.fstatus}
                                                </select> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" class="span1"/> 
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/page/index";
		 

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}
 

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
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
			
			


