<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">GamefasteyeUser</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_gamefasteyeuser"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.gamefasteyeuserBulkToken}" />
				<table class="table table-striped">
		
				{if $gamefasteyeusers|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelGfeid}</th>
							<th>{$lang.controller.labelUsername}</th>
							<th>{$lang.controller.labelFullname}</th>
							<th>{$lang.controller.labelEmail}</th>
							<th>{$lang.controller.labelPhone}</th>
							<th><a href="{$filterUrl}sortby/point/sorttype/{if $formData.sortby eq 'point'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPoint}</a></th>
							<th>{$lang.controller.labelHistorypoint}</th>
							<th>{$lang.controller.labelCountplay}</th>
							<th>{$lang.controller.labelCountshare}</th>
							<th>{$lang.controller.labelOauthpartner}</th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th>{$lang.controller.labelDatemodified}</th>
							<th>Ip</th>
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
					{foreach item=gamefasteyeuser from=$gamefasteyeusers}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$gamefasteyeuser->id}" {if in_array($gamefasteyeuser->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$gamefasteyeuser->id}</td>
							
							<td>{$gamefasteyeuser->gfeid}</td>
							<td>{$gamefasteyeuser->username}</td>
							<td>{$gamefasteyeuser->fullname}</td>
							<td>{$gamefasteyeuser->email}</td>
							<td>{$gamefasteyeuser->phone}</td>
							<td>{$gamefasteyeuser->point}</td>
							<td>{$gamefasteyeuser->historypoint}</td>
							<td>{$gamefasteyeuser->countplay}</td>
							<td>{$gamefasteyeuser->countshare}</td>
							<td>{$gamefasteyeuser->oauthpartner}</td>
							<td>{$gamefasteyeuser->datecreated|date_format}</td>
							<td>{$gamefasteyeuser->datemodified|date_format}</td>
							<td>{$gamefasteyeuser->ipaddress}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$gamefasteyeuser->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$gamefasteyeuser->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelUsername}: <input type="text" name="fusername" id="fusername" value="{$formData.fusername|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelFullname}: <input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelEmail}: <input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelOauthpartner}: <input type="text" name="foauthpartner" id="foauthpartner" value="{$formData.foauthpartner|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/gamefasteyeuser/index";
		

		var username = $('#fusername').val();
		if(username.length > 0)
		{
			path += '/username/' + username;
		}

		var fullname = $('#ffullname').val();
		if(fullname.length > 0)
		{
			path += '/fullname/' + fullname;
		}

		var email = $('#femail').val();
		if(email.length > 0)
		{
			path += '/email/' + email;
		}

		var oauthpartner = $('#foauthpartner').val();
		if(oauthpartner.length > 0)
		{
			path += '/oauthpartner/' + oauthpartner;
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
			
			


