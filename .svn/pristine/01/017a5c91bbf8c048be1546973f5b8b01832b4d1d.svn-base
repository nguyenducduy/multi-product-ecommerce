<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sản phẩm đoán giá</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_productguess"><h1>Sản phẩm đoán giá</h1></div>

<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/productquestion">Nhập câu hỏi</a> | <a href="{$conf.rooturl}{$controllerGroup}/productguessuser">Quản lý người chơi</a></div>

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
				<input type="hidden" name="ftoken" value="{$smarty.session.productguessBulkToken}" />
				<table class="table table-striped">
		
				{if $productguesss|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelUid}</th>
							<th>Product ID</th>
							<th>Ngày bắt đầu</th>
							<th>Ngày kết thúc</th>
							<th>Trạng thái</th>
							<th>Ngày tạo</th>
							<th>Người tham gia</th>
							<th>Export User</th>
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
					{foreach item=productguess from=$productguesss}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$productguess->id}" {if in_array($productguess->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$productguess->id}</td>
							
							<td>{$productguess->uid}</td>
							<td>{$productguess->pid}</td>
							<td>
							{if $smarty.now > $productguess->starttime}
								<span class="label label">{if $productguess->starttime > 0}{$productguess->starttime|date_format:$lang.default.dateFormatTimeSmarty}{/if}</span>
							{else}
								<span class="label label-info">{$productguess->starttime|date_format:$lang.default.dateFormatTimeSmarty}</span>
							{/if}	
							</td>
							
							<td>
							{if $smarty.now > $productguess->expiretime}
								<span class="label label-important">{if $productguess->expiretime > 0}{$productguess->expiretime|date_format:$lang.default.dateFormatTimeSmarty}{/if}</span>
							{else}
								<span class="label label-info">{$productguess->expiretime|date_format:$lang.default.dateFormatTimeSmarty}</span>
							{/if}
							</td>
						
							<td>
							{if $productguess->status == 1}
								{if $smarty.now > $productguess->starttime}
									{if $smarty.now > $productguess->expiretime}
										<span class="label label-important">Kết thúc</span>
									{else}
										<span class="label label-success">Đang chơi</span>
									{/if}
								{elseif $smarty.now > $productguess->expiretime}
									<span class="label label-important">Kết thúc</span>
								{else}
									<span class="label label-info">Chờ chơi</span>
								{/if}
							{else}
								<span class="label label-important">{$productguess->getstatusName()}</span>
							
							{/if}
							</td>
							<td>{$productguess->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td><a href="javascript:void(0)" onclick="showpopupuserguess({$productguess->id})"> Xem người chơi ››</a></td>
							<td><a href="{$conf.rooturl}{$controllerGroup}/productguessuser/exportuserguess?pgid={$productguess->id}" > Export user</a></td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productguess->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productguess->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
		var path = rooturl + controllerGroup + "/productguess/index";
		

		var pid = $('#fpid').val();
		if(pid.length > 0)
		{
			path += '/pid/' + pid;
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

	function showpopupuserguess(id)
	{
		Shadowbox.open({
	        content:    rooturl + 'site/product/showpopupusergues/id/' + id,
	        player:     "iframe",
	        options: {
	                       modal:   true
	        },
	        height:     500,
	        width:      800
	    });
	}
</script>
{/literal}
			
			


