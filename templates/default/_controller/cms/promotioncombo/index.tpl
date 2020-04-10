<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">PromotionCombo</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_promotioncombo"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.promotioncomboBulkToken}" />
				<table class="table table-striped">
		
				{if $promotioncombos|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelPid}</th>
							<th>{$lang.controller.labelPbarcode}</th>
							<th>{$lang.controller.labelPromoid}</th>
							<th>{$lang.controller.labelCoid}</th>
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
					{foreach item=promotioncombo from=$promotioncombos}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$promotioncombo->id}" {if in_array($promotioncombo->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$promotioncombo->id}</td>
							
							<td>{$promotioncombo->pid}</td>
							<td>{$promotioncombo->pbarcode}</td>
							<td>{$promotioncombo->promoid}</td>
							<td>{$promotioncombo->coid}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$promotioncombo->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$promotioncombo->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				{$lang.controller.labelPbarcode}: <input type="text" name="fpbarcode" id="fpbarcode" value="{$formData.fpbarcode|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPromoid}: <input type="text" name="fpromoid" id="fpromoid" value="{$formData.fpromoid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCoid}: <input type="text" name="fcoid" id="fcoid" value="{$formData.fcoid|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/promotioncombo/index";
		

		var pid = $('#fpid').val();
		if(pid.length > 0)
		{
			path += '/pid/' + pid;
		}

		var pbarcode = $('#fpbarcode').val();
		if(pbarcode.length > 0)
		{
			path += '/pbarcode/' + pbarcode;
		}

		var promoid = $('#fpromoid').val();
		if(promoid.length > 0)
		{
			path += '/promoid/' + promoid;
		}

		var coid = $('#fcoid').val();
		if(coid.length > 0)
		{
			path += '/coid/' + coid;
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
			
			

