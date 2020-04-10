<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ApiPartnerSale</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_apipartnersale"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
        <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/exportpartnersaleinfo">Export sale info</a></li>
        <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/importpartnersaleinfo">Import sale info</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.apipartnersaleBulkToken}" />
				<table class="table table-striped">
		
				{if $apipartnersales|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/apid/sorttype/{if $formData.sortby eq 'apid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelApid}</a></th>							
							<th>{$lang.controller.labelPid}</th>
							<th>{$lang.controller.labelPbarcode}</th>
							<th><a href="{$filterUrl}sortby/discountvalue/sorttype/{if $formData.sortby eq 'discountvalue'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDiscountvalue}(%)</a></th>
							<th>{$lang.controller.labelStatus}</th>							
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
					{foreach item=apipartnersale from=$apipartnersales}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$apipartnersale->id}" {if in_array($apipartnersale->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$apipartnersale->id}</td>
							
							<td><a target="_blank" href="{$conf.rooturl_cms}apipartner/edit/id/{$apipartnersale->apid}" class="tipsy-trigger" title="Xem chi tiết"><span class="label">{$apipartnersale->apipartneractor->name}</span></a></td>							
							<td><a target="_blank" href="{$conf.rooturl_cms}product/edit/id/{$apipartnersale->pid}" class="tipsy-trigger" title="Chi tiết sản phẩm">{$apipartnersale->pid}</a></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}product/edit/id/{$apipartnersale->pid}" class="tipsy-trigger" title="Chi tiết sản phẩm">{$apipartnersale->pbarcode}</a></td>
							<td><span class="label label-warning">{$apipartnersale->discountvalue}%</span></td>
							<td>{if $apipartnersale->checkStatusName('enable')}
									<span class="label label-success">{$apipartnersale->getStatusName()}</span>
								{else}
									<span class="label label-important">{$apipartnersale->getStatusName()}</span>
								{/if}
							</td>					
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$apipartnersale->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$apipartnersale->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
						<td>{$lang.controller.labelApid}:</td>
						<td style="text-align: left;"><input type="text" name="fapid" id="fapid" value="{$formData.fapid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>					
					<tr>
						<td>{$lang.controller.labelPid}:</td>
						<td style="text-align: left;"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelPbarcode}:</td>
						<td style="text-align: left;"><input type="text" name="fpbarcode" id="fpbarcode" value="{$formData.fpbarcode|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="text-align: left;">
							<select id="fstatus" name="fstatus">
								<option value="">- - - -</option>
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="text-align: left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.formKeywordLabel}:</td>
						<td style="text-align: left;">
							<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
							<select name="fsearchin" id="fsearchin">
								<option value="">{$lang.controller.formKeywordInLabel}</option>
								<option value="pbarcode" {if $formData.fsearchin eq "pbarcode"}selected="selected"{/if}>{$lang.controller.labelPbarcode}</option></select>
						</td>
					</tr>
					<tr>						
						<td colspan="2" style="text-align: center;"><br/><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
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
		var path = rooturl + controllerGroup + "/apipartnersale/index";
		

		var apid = $('#fapid').val();
		if(apid.length > 0)
		{
			path += '/apid/' + apid;
		}		

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
			
			


