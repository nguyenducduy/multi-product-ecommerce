<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Tin tức</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>
       

<div class="page-header" rel="menu_news"><h1>{$lang.controller.head_list}</h1></div>  

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
				<input type="hidden" name="ftoken" value="{$smarty.session.newsBulkToken}" />
				<table class="table table-striped">
		
				{if $newss|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>  
							<th>{$lang.controller.labelId}</th>
							<th width="100">{$lang.controller.labelNcid}</th>
							<th width="100">{$lang.controller.labelImage}</th>
							<th><a href="{$filterUrl}sortby/title/sorttype/{if $formData.sortby eq 'title'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelTitle}</a></th>
							
							<th><a href="{$filterUrl}sortby/countview/sorttype/{if $formData.sortby eq 'countview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountview}</a></th>
							<th><a href="{$filterUrl}sortby/countreview/sorttype/{if $formData.sortby eq 'countreview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreview}</a></th>
                            <th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
                            <th width="70"></th>
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
                                    <input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>   
					<tbody>

					{foreach item=news from=$newss}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$news->id}" {if in_array($news->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td>{$news->id}</td>
					        <td width="150"><small><a href="{$conf.rooturl_cms}news/index/ncid/{$news->ncid}">{$news->getNewscategoryname()}</a></small></td>
							<td><img src="{if $news->image != ''}{$news->getSmallImage()}{else}{$currentTemplate}images/default.jpg{/if}" style="width:100px;"/></td>
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$news->id}/redirect/{$redirectUrl}">{$news->title}</a>
								<br /><small class="slugtext"><a href="{$news->getNewsPath()}" target="_blank" title="Preview">{$news->slug}</a></small>
								
							</td>
							<td><span class="badge badge-info">{$news->countview}</span></td>
							<td><span class="badge badge-info">{$news->countreview}</span></td> 
							<td>{if $news->checkStatusName('enable')}
                                    <span class="label label-success">{$news->getStatusName()}</span>
                                {else}
                                    <span class="label">{$news->getStatusName()}</span>
                                {/if}
                            </td>                                                                    
							
							<td>
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$news->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$news->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
						<td width="180">{$lang.controller.labelNcid}</td>
						<td>
							<select name="fncid" id="fncid">
                                <option value="">---------------------------------</option>
				                {foreach from=$newscategoryList item=category}
								{if $category->parentid==0}
									</optgroup><optgroup label="{$category->name}">
								{else}
									<option value="{$category->id}">{$category->name}</option>
								{/if}
								{/foreach}  
                            </select>
                        </td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}</td>
						<td>
							<select name="fstatus" id="fstatus">
                                <option value="">- - - -</option>
                                {html_options options=$statusList selected=$formData.fstatus}
                            </select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.formKeywordLabel}</td>
						<td>
							<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
						</td>
						<td>
							<select name="fsearchin" id="fsearchin">
			                    <option value="">{$lang.controller.formKeywordInLabel}</option>
			                    <option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option>
			                    <option value="content" {if $formData.fsearchin eq "content"}selected="selected"{/if}>{$lang.controller.labelContent}</option>
			                    <option value="source" {if $formData.fsearchin eq "source"}selected="selected"{/if}>{$lang.controller.labelSource}</option>
			                </select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}</td>
						<td><input type="text" name="fid" id="fid"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
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
		var path = rooturl + controllerGroup + "/news/index";
		 

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}

		var ncid = $('#fncid').val();
		if(ncid.length > 0)
		{
			path += '/ncid/' + ncid;
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
			
			


