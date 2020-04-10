
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Tin rao vặt</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_stuff"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.stuffBulkToken}" />
				<table class="table table-striped">
		
				{if $stuffs|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							
							<th>ID</th>
							<th>{$lang.controller.labelImage}</th>
							<th width="180px;">{$lang.controller.labelTitle}</th>
							<th>{$lang.controller.labelPrice}</th>
							<th>{$lang.controller.labelContactname}</th>
							<!-- <th>{$lang.controller.labelContactemail}</th> -->
							<th>{$lang.controller.labelRegionid}</th>
							<!-- <th><a href="{$filterUrl}sortby/countview/sorttype/{if $formData.sortby eq 'countview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountview}</a></th>
							<th><a href="{$filterUrl}sortby/countreview/sorttype/{if $formData.sortby eq 'countreview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreview}</a></th> -->
							<th>{$lang.controller.labelStatus}</th>
							<th><a href="{$filterUrl}sortby/issms/sorttype/{if $formData.sortby eq 'issms'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelIssms}</a></th>
							<th><a href="{$filterUrl}sortby/isvip/sorttype/{if $formData.sortby eq 'isvip'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelIsvip}</a></th>
							<!-- <th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th> -->
							<th width="70"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="11">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
					
					
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
					{foreach item=stuff from=$stuffs}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$stuff->id}" {if in_array($stuff->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							
							<td>{$stuff->id}</td>
							<td><img src="{if $stuff->image != ''}{$stuff->getSmallImage()}{else}{$currentTemplate}images/default.jpg{/if}" style="width:80px;" /></td>
							<td>
								<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$stuff->id}/redirect/{$redirectUrl}">{$stuff->title}</a>
								<br /><small class="slugtext"><a href="{$stuff->getStuffPath()}" target="_blank" title="Preview">{$stuff->slug}</a></small>
							</td>
							<td><span class="label">{$stuff->price}</span></td>
							<td>{$stuff->contactname}</td>
							<!-- <td>{$stuff->contactemail}</td> -->
							<td><span class="label label-info">{$stuff->getRegionName($stuff->regionid)}</span></td>
							<td>
								{if $stuff->checkStatusName('enable')}
                                    <span class="label label-success">{$stuff->getStatusName()}</span>
                                {else}
                                    <span class="label">{$stuff->getStatusName()}</span>
                                {/if}
                            </td>
							<td>
								{if $stuff->checkSMSName('sms')}
                                    <span class="label label-inverse">{$stuff->getSMSName()}</span>
                                {else}
                                    <span class="label">{$stuff->getSMSName()}</span>
                                {/if}
							</td>
							<td>
								{if $stuff->checkVipName('vip')}
                                    <span class="label label-warning">{$stuff->getVipName()}</span>
                                {else}
                                    <span class="label">{$stuff->getVipName()}</span>
                                {/if}
							</td>
							<!-- <td>{$stuff->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td> -->
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$stuff->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$stuff->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
						<td>{$lang.controller.labelScid}</td>
						<td>
							<select name="fscid" id="fscid">
								<option value=""> -- Chọn danh mục -- </option>
								{foreach item=sc from=$myStuffcategory}
								<option value="{$sc->id}"{if $sc->id == $formData.fscid}selected="selected"{/if}>{$sc->name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelRegionid}</td>
						<td>
							<select name="fregionid" id="fregionid">
								<option value="">-- Select region --</option>
								{foreach item=region from=$setting.region key='k'}
									<option value="{$k}"{if $k== $formData.fregionid}selected="selected"{/if}>{$region}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}</td>
						<td>
							<select name="fstatus" id="fstatus">
				                {html_options options=$statusList selected=$formData.fstatus}
				            </select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelIssms}</td>
						<td>
							<select name="fissms" id="fissms">
								<option value="">------</option>
								<option value="{$issms}"{if $formData.fissms == $issms}selected="selected"{/if}>SMS</option>
							</select>	
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelIsvip}</td>
						<td>
							<select name="fisvip" id="fisvip">
								<option value="">------</option>
				                {html_options options=$vipList selected=$formData.fisvip}
				            </select>
						</td>	
					</tr>
					<tr>
						<td>{$lang.controller.labelId}</td>
						<td><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.formKeywordLabel}</td>
						<td><input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" /></td>
						<td>
							<select name="fsearchin" id="fsearchin">
								<option value="">{$lang.controller.formKeywordInLabel}</option>
								<option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option>
								<option value="content" {if $formData.fsearchin eq "content"}selected="selected"{/if}>{$lang.controller.labelContent}</option>
								<option value="contactname" {if $formData.fsearchin eq "contactname"}selected="selected"{/if}>{$lang.controller.labelContactname}</option>
								<option value="contactemail" {if $formData.fsearchin eq "contactemail"}selected="selected"{/if}>{$lang.controller.labelContactemail}</option>
								<option value="contactphone" {if $formData.fsearchin eq "contactphone"}selected="selected"{/if}>{$lang.controller.labelContactphone}</option>
							</select>	
						</td>
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
		var path = rooturl + controllerGroup + "/stuff/index";
		

		var scid = $('#fscid').val();
		if(scid.length > 0)
		{
			path += '/scid/' + scid;
		}

		var issms = $('#fissms').val();
		if(issms.length > 0)
		{
			path += '/issms/' + issms;
		}

		var isvip = $('#fisvip').val();
		if(isvip.length > 0)
		{
			path += '/isvip/' + isvip;
		}

		var regionid = $('#fregionid').val();
		if(regionid.length > 0)
		{
			path += '/regionid/' + regionid;
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
			
			


