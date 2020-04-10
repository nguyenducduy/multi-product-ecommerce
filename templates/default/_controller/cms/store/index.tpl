<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Siêu thị</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.title_list}</li>
</ul>


<div class="page-header" rel="menu_store"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<!-- <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li> -->
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.storeBulkToken}" />
				<table class="table table-striped">
		
				{if $stores|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
						   <th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>Image</th>
							
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th><a href="{$filterUrl}sortby/address/sorttype/{if $formData.sortby eq 'address'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelAddress}</a></th>
							<th>{$lang.controller.labelPhone}</th>  
                            <th width="100"><a href="{$filterUrl}sortby/region/sorttype/{if $formData.sortby eq 'region'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelRegion}</a></th> 
                           	<th>{$lang.controller.labelMap}</th>
							<!--<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>-->
							<th width="140"></th>
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
                                    <!--<input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />-->
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=store from=$stores}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$store->id}" {if in_array($store->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><input type="text" name="fdisplayorder[{$store->id}]" value="{$store->displayorder}" class="input-mini" /></td>
							<td>{if $store->image != ''}<a href="{$store->getImage()}" rel="shadowbox"><img src="{$store->getSmallImage()}" width="50" height="50" /></a>{/if}</td>
							<td><span class="label label-info">{$store->name}</span></td>
							<td><small>{$store->address}
								{if $store->email != ''}
									<br /><small>Email: {$store->email}</small>
								{/if}
								</small>
							</td>
							<td><span class="label">{$store->phone}</span></td>
                            <td><a href="{$conf.rooturl_cms}store/index/region/{$store->region}">{$store->getRegionName({$store->region})}</a></td>
                            <td>{if $store->lat != 0 && $store->lng != 0}<a href="{$conf.rooturl_cms}store/getMap?address={$store->address}" rel="shadowbox;width=1000;height=600;"><i class="icon icon-globe" style="font-size:20px;"></i></a>{else}--{/if}</td>
							<!--<td>
                                {if $store->checkStatusName('enable')}
                                    <span class="label label-success">{$store->getStatusName()}</span>
                                {else}
                                    <span class="label label-important">{$store->getStatusName()}</span>
                                {/if}
                            </td>-->    
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$store->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$store->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelRegion} : 
					<select name="fregion" id="fregion">
						<option value="">-----------------------</option>
						{foreach item=region from=$myRegion}
						<option value="{$region->id}"{if $formData.fregion == $store->region}selected="selected"{/if}>{$region->name}</option>
						{/foreach}
					</select> - <br /> <br />
				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
					<option value="description" {if $formData.fsearchin eq "description"}selected="selected"{/if}>{$lang.controller.labelDescription}</option>
					<option value="address" {if $formData.fsearchin eq "address"}selected="selected"{/if}>{$lang.controller.labelAddress}</option>
					<option value="phone" {if $formData.fsearchin eq "phone"}selected="selected"{/if}>{$lang.controller.labelPhone}</option>
					<option value="email" {if $formData.fsearchin eq "email"}selected="selected"{/if}>{$lang.controller.labelEmail}</option>
					<option value="fax" {if $formData.fsearchin eq "fax"}selected="selected"{/if}>{$lang.controller.labelFax}</option>
                </select> -
                <!--
                {$lang.controller.labelStatus}: <select name="fstatus" id="fstatus">
                                                    <option value="">- - - -</option>
                                                    {html_options options=$statusList selected=$formData.fstatus}
                                                </select>  -->
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/store/index";
		 

		var region = $('#fregion').val();
		if(region.length > 0)
		{
			path += '/region/' + region;
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
			
			


