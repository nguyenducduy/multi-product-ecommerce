<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Bình luận Page</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_pagereview"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		{if $totalpending > 0}<li><a href="#tab3" data-toggle="tab">Danh sách chờ duyệt ({$totalpending})</a></li>{/if}
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.pagereviewBulkToken}" />
				<table class="table table-striped">

				{if $pagereviews|@count > 0}
					<thead>
						<tr>
						 	<th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							<th><a href="{$filterUrl}sortby/parentid/sorttype/{if $formData.sortby eq 'parentid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelParentid}</a></th>
							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>
							<th>{$lang.controller.labelUid}</th>
							<th>{$lang.controller.labelObjectid}</th>
							<th>{$lang.controller.labelEmail}</th>
							<th>{$lang.controller.labelText}</th>
							<th><a href="{$filterUrl}sortby/countreply/sorttype/{if $formData.sortby eq 'countreply'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreply}</a></th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
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
										<option value="success">{$lang.controller.bulkActionSuccessLabel}</option>
										<option value="pending">{$lang.controller.bulkActionPendingLabel}</option>
										<option value="spam">{$lang.controller.bulkActionSpamLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=pagereview from=$pagereviews}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$pagereview->id}" {if in_array($pagereview->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><span class="badge">{$pagereview->id}</span></td>
							<td>{if $pagereview->parentid > 0}{$pagereview->parentid}{/if}</td>
							<td>{$pagereview->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td><span class="label label-info">{if $pagereview->actor->id > 0}{$pagereview->actor->fullname}{else}{$pagereview->fullname}{/if}</span></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}page/index/id/{$pagereview->page->id}">{$pagereview->page->title}</a></td>
							<td>{$pagereview->email}</td>
							<td>{$pagereview->text}</td>
							<td><span class="badge badge-info">{$pagereview->countreply}</span></td>
							<td>
								{if $pagereview->checkStatusName('enable')}
									<span class="label label-success">{$pagereview->getStatusName()}</span>
								{elseif $pagereview->checkStatusName('pending')}
									<span class="label label-warning">{$pagereview->getStatusName()}</span>
								{else}
									<span class="label label-important">{$pagereview->getStatusName()}</span>
								{/if}
							</td>
							<td>
								<span class="tipsy-trigger" title="{$lang.default.formActionEditTooltip}"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$pagereview->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> </span>&nbsp;

								<span class="tipsy-trigger" title="{$lang.default.formActionDeleteTooltip}"><a href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$pagereview->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a></span> &nbsp;

								<a href="{$conf.rooturl_cms}pagereview/reply/parentid/{$pagereview->id}" rel="shadowbox;height=195px;width=800px" class="btn btn-mini"><i class="icon-white"></i>Reply</a>
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
		<div class="tab-pane" id="tab3">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.pagereviewBulkToken}" />
				<table class="table table-striped">

				{if $totalpending > 0}
					<thead>
						<tr>
						   	<th width="40"><input class="check-all" type="checkbox" /></th>
						   	<th width="30">{$lang.controller.labelId}</th>
						   	<th>{$lang.controller.labelParentid}</th>
						   	<th>{$lang.controller.labelDatecreated}</th>
						   	<th>{$lang.controller.labelUid}</th>
						   	<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelObjectid}</a></th>
						   	<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
						   	<th>{$lang.controller.labelText}</th>
						   	<th><a href="{$filterUrl}sortby/countreply/sorttype/{if $formData.sortby eq 'countreply'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreply}</a></th>
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
										<option value="success">{$lang.controller.bulkActionSuccessLabel}</option>
										<option value="pending">{$lang.controller.bulkActionPendingLabel}</option>
										<option value="spam">{$lang.controller.bulkActionSpamLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=pagereview from=$pagereviewspending}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$pagereview->id}" {if in_array($pagereview->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><span class="badge">{$pagereview->id}</span></td>
							<td>{if $pagereview->parentid > 0}{$pagereview->parentid}{/if}</td>
							<td>{$pagereview->datemoderated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td><span class="label label-info">{if $pagereview->actor->id > 0}{$pagereview->actor->fullname}{else}{$pagereview->fullname}{/if}</span></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}page/index/id/{$pagereview->page->id}">{$pagereview->page->title}</a></td>
							<td>{$pagereview->email}</td>
							<td>{$pagereview->text}</td>
							<td><span class="badge badge-info">{$pagereview->countreply}</span></td>
							<td>
								{if $pagereview->checkStatusName('enable')}
									<span class="label label-success">{$pagereview->getStatusName()}</span>
								{elseif $pagereview->checkStatusName('pending')}
									<span class="label label-warning">{$pagereview->getStatusName()}</span>
								{else}
									<span class="label label-important">{$pagereview->getStatusName()}</span>
								{/if}
							</td>
							<td>
								<span class="tipsy-trigger" title="{$lang.default.formActionEditTooltip}"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$pagereview->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> </span>&nbsp;

								<span class="tipsy-trigger" title="{$lang.default.formActionDeleteTooltip}"><a href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$pagereview->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a></span> &nbsp;

								<a href="{$conf.rooturl_cms}pagereview/reply/parentid/{$pagereview->id}" rel="shadowbox;height=195px;width=800px" class="btn btn-mini"><i class="icon-white"></i>Reply</a>
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
		</div><!--end #tab 3-->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				<table>
					<tr>
						<td width="200">{$lang.controller.labelUid}</td>
						<td><select name="fuid" id="fuid" class="autocompletestaff"></select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelObjectid}</td>
						<td style="float: left;"><input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini"/></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelModeratorid}</td>
						<td><select name="fmoderatorid" id="fmoderatorid" class="autocompletestaff"></select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="float:left;">
							<select name="fstatus" id="fstatus">
								<option value="">- - - -</option>
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelParentid}</td>
						<td style="float: left;"><input type="text" name="fparentid" id="fparentid" value="{$formData.fparentid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}</td>
						<td style="float: left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.formKeywordLabel}</td>
						<td><input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" /></td>
						<td>
							<select name="fsearchin" id="fsearchin">
								<option value="">{$lang.controller.formKeywordInLabel}</option>
								<option value="email" {if $formData.fsearchin eq "email"}selected="selected"{/if}>{$lang.controller.labelEmail}</option>
								<option value="text" {if $formData.fsearchin eq "text"}selected="selected"{/if}>{$lang.controller.labelText}</option>
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
		var path = rooturl + controllerGroup + "/pagereview/index";


		var uid = $('#fuid').val();
		if(uid != null)
		{
			path += '/uid/' + uid;
		}

		var objectid = $('#fobjectid').val();
		if(objectid.length > 0)
		{
			path += '/objectid/' + objectid;
		}

		var moderatorid = $('#fmoderatorid').val();
		if(moderatorid != null)
		{
			path += '/moderatorid/' + moderatorid;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
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




