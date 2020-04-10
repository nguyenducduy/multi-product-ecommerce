<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ScrumStoryComment</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_scrumstorycomment"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumstorycommentBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumstorycomments|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/uid/sorttype/{if $formData.sortby eq 'uid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelUid}</a></th>
							<th><a href="{$filterUrl}sortby/ssid/sorttype/{if $formData.sortby eq 'ssid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSsid}</a></th>
							<th><a href="{$filterUrl}sortby/content/sorttype/{if $formData.sortby eq 'content'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelContent}</a></th>
							<th><a href="{$filterUrl}sortby/file/sorttype/{if $formData.sortby eq 'file'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelFile}</a></th>
							<th><a href="{$filterUrl}sortby/ipaddress/sorttype/{if $formData.sortby eq 'ipaddress'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelIpaddress}</a></th>
							<th><a href="{$filterUrl}sortby/datecreate/sorttype/{if $formData.sortby eq 'datecreate'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreate}</a></th>
							<th><a href="{$filterUrl}sortby/datemodified/sorttype/{if $formData.sortby eq 'datemodified'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatemodified}</a></th>
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
					{foreach item=scrumstorycomment from=$scrumstorycomments}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$scrumstorycomment->id}" {if in_array($scrumstorycomment->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$scrumstorycomment->id}</td>
							
							<td>{$scrumstorycomment->uid}</td>
							<td>{$scrumstorycomment->ssid}</td>
							<td>{$scrumstorycomment->content}</td>
							<td>{$scrumstorycomment->file}</td>
							<td>{$scrumstorycomment->ipaddress}</td>
							<td>{$scrumstorycomment->datecreate}</td>
							<td>{$scrumstorycomment->datemodified}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$scrumstorycomment->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$scrumstorycomment->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelSsid}: <input type="text" name="fssid" id="fssid" value="{$formData.fssid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelContent}: <input type="text" name="fcontent" id="fcontent" value="{$formData.fcontent|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelFile}: <input type="text" name="ffile" id="ffile" value="{$formData.ffile|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIpaddress}: <input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatecreate}: <input type="text" name="fdatecreate" id="fdatecreate" value="{$formData.fdatecreate|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatemodified}: <input type="text" name="fdatemodified" id="fdatemodified" value="{$formData.fdatemodified|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="content" {if $formData.fsearchin eq "content"}selected="selected"{/if}>{$lang.controller.labelContent}</option>
					<option value="file" {if $formData.fsearchin eq "file"}selected="selected"{/if}>{$lang.controller.labelFile}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/scrumstorycomment/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var ssid = $('#fssid').val();
		if(ssid.length > 0)
		{
			path += '/ssid/' + ssid;
		}

		var content = $('#fcontent').val();
		if(content.length > 0)
		{
			path += '/content/' + content;
		}

		var file = $('#ffile').val();
		if(file.length > 0)
		{
			path += '/file/' + file;
		}

		var ipaddress = $('#fipaddress').val();
		if(ipaddress.length > 0)
		{
			path += '/ipaddress/' + ipaddress;
		}

		var datecreate = $('#fdatecreate').val();
		if(datecreate.length > 0)
		{
			path += '/datecreate/' + datecreate;
		}

		var datemodified = $('#fdatemodified').val();
		if(datemodified.length > 0)
		{
			path += '/datemodified/' + datemodified;
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
			
			


