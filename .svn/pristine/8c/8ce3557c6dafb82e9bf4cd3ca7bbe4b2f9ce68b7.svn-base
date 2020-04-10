<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục tin tức</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_newscategory"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
		<li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">{$lang.controller.labelCategoryPermission}</a></li>	
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.newscategoryBulkToken}" />
				<table class="table table-striped">
		
				{if $newscategorys|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th>{$lang.controller.labelId}</th>
							
                            <th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>{$lang.controller.labelParentid}</th>
							<th width="150px;"><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th>{$lang.controller.labelSlug}</th>
							<th><a href="{$filterUrl}sortby/countitem/sorttype/{if $formData.sortby eq 'countitem'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountitem}</a></th>
                            <!-- <th>{$lang.controller.labelStatus}</th>    -->
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
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />  &nbsp;
                                    <input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=newscategory from=$newscategorys}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$newscategory->id}" {if in_array($newscategory->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><span class="badge">{$newscategory->id}</span></td>
                            <td><input type="text" name="fdisplayorder[{$newscategory->id}]" value="{$newscategory->displayorder}" style="width: 25px;"/></td>
                            <td class="span3">
                            	{if $newscategory->parentid != 0}
                            	{$newscategory->getCatArr($newscategory->parentid)}
                            	{/if}
                            </td>
                            <td width="150px;"><b>{$newscategory->name}</b></td>
							<td>{$newscategory->slug}</td>
							<td><a title="Xem tất cả tin trong danh mục này." href="{$conf.rooturl}{$controllerGroup}/news/index/ncid/{$newscategory->id}"><span class="badge badge-info">{$newscategory->countitem}</span></a></td> 
							<!-- 
							<td>
                                {if $newscategory->checkStatusName('enable')}
                                    <span class="label label-success">{$newscategory->getStatusName()}</span>
                                {else}
                                    <span class="label label-important">{$newscategory->getStatusName()}</span>
                                {/if}
                            </td> 
                            -->
							<td width="130px;">
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$newscategory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$newscategory->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
             			<td width="180">{$lang.controller.labelParentid}</td>
             			<td>
             				<select name="fparentid" id="fparentid">
                                <option value="">----------</option>
                                {foreach item=category from=$newscategorys}
                                    <option value="{$category->id}"{if $category->id == $formData.fncid}selected="selected"{/if}>{$category->name}</option>
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
             			<td><input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" /></td>
             			<td>
             				<select name="fsearchin" id="fsearchin">
					            <option value="">{$lang.controller.formKeywordInLabel}</option>
					            <option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
					            <option value="summary" {if $formData.fsearchin eq "summary"}selected="selected"{/if}>{$lang.controller.labelSummary}</option>
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
		var path = rooturl + controllerGroup + "/newscategory/index";

		
		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}

		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
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
			
			


