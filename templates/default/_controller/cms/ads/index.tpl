<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Ads</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_ads"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.adsBulkToken}" />
				<table class="table table-striped">
		
				{if $adss|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
                            <th>{$lang.controller.labelDisplayOrder}</th>
							<th width="30">{$lang.controller.labelId}</th>
							<th>{$lang.controller.labelImage}</th>
                            <th>{$lang.controller.labelName}</th>
                            <th>{$lang.controller.labelDatebegin}</th>
							<th>{$lang.controller.labelDateend}</th>
							<th>{$lang.controller.labelAzid} | {$lang.controller.labelCampaign} | {$lang.controller.labelLink}</th>
							<th><a href="{$filterUrl}sortby/click/sorttype/{if $formData.sortby eq 'click'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelClick}</a></th>
							<th>{$lang.controller.labelStatus}</th>
							<th width="70"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="11">
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
					{foreach item=ads from=$adss}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$ads->id}" {if in_array($ads->id, $formData.fbulkid)}checked="checked"{/if}/></td>
                            <td style=""><input type="text" class="input-mini" name="fdisplayorder[{$ads->id}]" value="{$ads->displayorder}" style="width:30px;" /></td>
							<td style="font-weight:bold;">{$ads->id}</td>
							
							<td>{if $ads->checkTypeName('textonly')}
									<span class="label label-inverse">Text Only</span>
								{else}<a href="{$ads->getImage()}" rel="shadowbox[gallery]" title="{$ads->title}"><img src="{$ads->getSmallImage()}" title="{$ads->width} &times; {$ads->height}" class="tipsy-trigger" widht="50" height="50" style="height: 50px;" /></a>{/if}</td>
							<td>                                
                                <span class="label label-info">{$ads->name}</span>
                                <br /><small>{$ads->title}</small>
                            </td>
                            <td>{if $ads->datebegin>0}{$ads->datebegin|date_format:"%d/%m/%Y %H:%m:%S"}{/if}</td>
                            <td>
                                {if $smarty.now>$ads->dateend}
                                <span class="label label-important">{if $ads->dateend>0}{$ads->dateend|date_format:"%d/%m/%Y %H:%m:%S"}{/if}</span>
                                {else}
                                {$ads->dateend|date_format:"%d/%m/%Y %H:%m:%S"}
                                {/if}
							</td>
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/azid/{$ads->azid}" title="View all ads in this zone"><span class="label">{$ads->zone->name}</span></a> <a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/campaign/{$ads->campaign|escape}" title="View all ads from this campaign">{if $ads->countsubads > 0}<span class="label label-warning">{$ads->countsubads} category</span>{/if}<span class="label label-info">{$ads->campaign}</span></a>
								<br />                                
								<small>{$ads->link}</small> <a href="{$ads->link}" target="_blank"><i class="icon-share"></i></a>
							</td>
							<td><span class="badge badge-success">{$ads->click}</span></td>
							<td>{if $ads->checkStatusName('enable')}<span class="label label-success">Enable</span>{elseif $ads->checkStatusName('disable')}<span class="label label-inverse">Expired</span>{else}<span class="label">Disable</span>{/if}</td>
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$ads->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$ads->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
				{$lang.controller.labelAzid}: 
				<select name="fazid" id="fazid">
					<option value="0">- - - - -</option>
					{foreach item=adszone from=$adszoneList}
						<option value="{$adszone->id}" {if $adszone->id == $formData.fazid}selected="selected"{/if}>{$adszone->name}</option>
					{/foreach}
				</select> - 

				{$lang.controller.labelType}: 
				<select name="ftype" id="ftype">
					<option value="0">- - - - -</option>
					{html_options options=$typeList selected=$formData.ftype}
				</select> - 

				{$lang.controller.labelCampaign}: <input type="text" name="fcampaign" id="fcampaign" value="{$formData.fcampaign|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: 
				<select name="fstatus" id="fstatus">
					<option value="0">- - - - -</option>
					{html_options options=$statusList selected=$formData.fstatus}
				</select> - 

				<br /><br />
				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
					<option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option>
					<option value="campaign" {if $formData.fsearchin eq "campaign"}selected="selected"{/if}>{$lang.controller.labelCampaign}</option>
                    <option value="slug" {if $formData.fsearchin eq "slug"}selected="selected"{/if}>{$lang.controller.labelSlug}</option>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/ads/index";
		

		var azid = $('#fazid').val();
		if(azid.length > 0)
		{
			path += '/azid/' + azid;
		}

		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
		}

		var campaign = $('#fcampaign').val();
		if(campaign.length > 0)
		{
			path += '/campaign/' + campaign;
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
			
			


