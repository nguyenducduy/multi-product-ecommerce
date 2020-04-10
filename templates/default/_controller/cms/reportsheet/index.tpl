<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ReportSheet</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_reportsheet"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.reportsheetBulkToken}" />
				<table class="table table-striped">

				{if $reportsheets|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>

							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelType}</th>
							<th>{$lang.controller.labelCreatorid}</th>
							<th>{$lang.controller.labelStatus}</th>
							<th>{$lang.controller.labelDescription}</th>
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
					{foreach item=reportsheet from=$reportsheets}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$reportsheet->id}" {if in_array($reportsheet->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$reportsheet->id}</td>

							<td>{$reportsheet->name}</td>
							<td><span class="label">{$reportsheet->getTypeName()}</span></td>
							<td>{$reportsheet->userActor->fullname}</td>
							<td>{if $reportsheet->checkStatusName('enable')}
									<span class="label label-success">{$reportsheet->getStatusName()}</span>
								{else}
									<span class="label label-important">{$reportsheet->getStatusName()}</span>
								{/if}</td>
							<td>{$reportsheet->description}</td>

							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$reportsheet->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$reportsheet->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge" /> -

				{$lang.controller.labelType}: <select name="ftype" id="ftype">
                    <option value="0">--------</option>
                    {html_options options=$typeList selected=$formData.ftype}
                </select> -

				{$lang.controller.labelCreatorid}: <input type="text" name="fcreatorid" id="fcreatorid" value="{$formData.fcreatorid|@htmlspecialchars}" class="input-mini" /> -

				{$lang.controller.labelStatus}: <select name="fstatus" id="fstatus">
                    <option value="0">----------</option>
                    {html_options options=$statusList selected=$formData.fstatus}
                </select> -

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> -


				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option></select>

				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />

			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/reportsheet/index";


		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
		}

		var creatorid = $('#fcreatorid').val();
		if(creatorid.length > 0)
		{
			path += '/creatorid/' + creatorid;
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



