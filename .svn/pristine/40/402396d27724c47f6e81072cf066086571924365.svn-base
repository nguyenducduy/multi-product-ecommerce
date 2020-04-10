<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteCode</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_lottecode"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
                {if $permission}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
                {/if}
        </ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.lottecodeBulkToken}" />
				<table class="table table-striped">
		
				{if $lottecodes|@count > 0}
					<thead>
						<tr>
                                                   {if $permission} 
						   <th width="40"><input class="check-all" type="checkbox" /></th>
                                                       {/if}
                                                   <th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/leid/sorttype/{if $formData.sortby eq 'leid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelLeid}</a></th>
							<th><a href="{$filterUrl}sortby/lmid/sorttype/{if $formData.sortby eq 'lmid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelLmid}</a></th>
							<th><a href="{$filterUrl}sortby/type/sorttype/{if $formData.sortby eq 'type'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelType}</a></th>
							<th><a href="{$filterUrl}sortby/code/sorttype/{if $formData.sortby eq 'code'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCode}</a></th>
							<th><a href="{$filterUrl}sortby/erpsaleorderid/sorttype/{if $formData.sortby eq 'erpsaleorderid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelErpsaleorderid}</a></th>
							<th><a href="{$filterUrl}sortby/referer/sorttype/{if $formData.sortby eq 'referer'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelReferer}</a></th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							{if $permission}
                                                        <th width="140"></th>
                                                        {/if}
                                                </tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
                                                                {if $permission}
								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
                                                                {/if}
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=lottecode from=$lottecodes}
		
						<tr>
                                                        {if $permission}
							<td><input type="checkbox" name="fbulkid[]" value="{$lottecode->id}" {if in_array($lottecode->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							{/if}
                                                        <td style="font-weight:bold;"><span class="badge badge-info">{$lottecode->id}</span></td>
							
							<td>
								{foreach $event as $k=>$v}
									{if {$lottecode->leid}==$v->id}
										{$v->name}
									{else}
										_
									{/if}
								{/foreach}</td>
							<td>{$lottecode->lmid}</td>
							<td>{$type.{$lottecode->type}}</td>
							<td>{$lottecode->code}</td>
							<td>{$lottecode->erpsaleorderid}</td>
							<td>{$lottecode->referer}</td>
							<td><span class="label label-info">{if {$lottecode->status}==1}Enable{else}Disable{/if}</span></td>
							{if $permission}
                                                        <td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$lottecode->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$lottecode->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
                                                        {/if}
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
				{$lang.controller.labelLeid}: <input type="text" name="fleid" id="fleid" value="{$formData.fleid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelLmid}: <input type="text" name="flmid" id="flmid" value="{$formData.flmid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelType}: <input type="text" name="ftype" id="ftype" value="{$formData.ftype|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCode}: <input type="text" name="fcode" id="fcode" value="{$formData.fcode|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelErpsaleorderid}: <input type="text" name="ferpsaleorderid" id="ferpsaleorderid" value="{$formData.ferpsaleorderid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelReferer}: <input type="text" name="freferer" id="freferer" value="{$formData.freferer|@htmlspecialchars}" class="input-mini" /> - 

				lọc bỏ phone: <input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-mini" /> -

				{$lang.controller.labelDatecreated}: <input type="text" name="fdatecreated" id="fdatecreated" value="{$formData.fdatecreated|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="code" {if $formData.fsearchin eq "code"}selected="selected"{/if}>{$lang.controller.labelCode}</option>
					<option value="erpsaleorderid" {if $formData.fsearchin eq "erpsaleorderid"}selected="selected"{/if}>{$lang.controller.labelErpsaleorderid}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/lottecode/index";
		

		var leid = $('#fleid').val();
		if(leid.length > 0)
		{
			path += '/leid/' + leid;
		}

		var lmid = $('#flmid').val();
		if(lmid.length > 0)
		{
			path += '/lmid/' + lmid;
		}

		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
		}

		var code = $('#fcode').val();
		if(code.length > 0)
		{
			path += '/code/' + code;
		}

		var erpsaleorderid = $('#ferpsaleorderid').val();
		if(erpsaleorderid.length > 0)
		{
			path += '/erpsaleorderid/' + erpsaleorderid;
		}

		var referer = $('#freferer').val();
		if(referer.length > 0)
		{
			path += '/referer/' + referer;
		}

		var status = $('#fphone').val();
		if(status.length > 0)
		{
			path += '/phone/' + status;
		}

		var datecreated = $('#fdatecreated').val();
		if(datecreated.length > 0)
		{
			path += '/datecreated/' + datecreated;
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
			
			


