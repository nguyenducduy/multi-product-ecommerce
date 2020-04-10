<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Tuyển dụng</a> <span class="divider">/</span></li>
	<li class="active">Danh sách </li>
</ul>



<div class="page-header" rel="menu_job"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.jobBulkToken}" />
				<table class="table table-striped">

				{if $jobs|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>

							<th width="50">{$lang.controller.labelDisplayorder}</th>
							<th width="100">{$lang.controller.labelImage}</th>
							<th width="150">{$lang.controller.labelCategory}</th>
							<th width="400">{$lang.controller.labelTitle}</th>
							<th><a href="{$filterUrl}sortby/countview/sorttype/{if $formData.sortby eq 'countview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountview}</a></th>
							<th><a href="{$filterUrl}sortby/countreview/sorttype/{if $formData.sortby eq 'countreview'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreview}</a></th>

							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>

							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>

							<th width="140"></th>
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
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" /> &nbsp;
									<input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=job from=$jobs}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$job->id}" {if in_array($job->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;"><span class="badge">{$job->id}</span></td>

							<td><input type="text" name="fdisplayorder[{$job->id}]" value="{$job->displayorder}" style="width: 25px;"/></td>
							<td><img src="{if $job->image != ''}{$job->getSmallImage()}{else}{$currentTemplate}images/default.jpg{/if}" style="width:100px;" /></td>
							<td><a href="{$conf.rooturl_cms}job/index/jcid/{$job->jcid}">{$job->getcategoryname()}</a></td>
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$job->id}/redirect/{$redirectUrl}" title="{$job->title}">{$job->title}</a></td>
							<td><span class="badge badge-info">{$job->countview}</span></td>
							<td><span class="badge badge-info">{$job->countreview}</span></td>
							<td>
								{if $job->checkStatusName('enable')}
		                                    <span class="label label-success">{$job->getStatusName()}</span>
		                               {else}
		                                    <span class="label">{$job->getStatusName()}</span>
		                               {/if}
							</td>
							<td><span class="label">{$job->datecreated|date_format:$lang.default.dateFormatSmarty}</span></td>

							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$job->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$job->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> -

				{$lang.controller.labelCategory}:
					<select name="fjcid" id="fjcid">
						<option value="0"> ----------------------------------- </option>
						{foreach item=mycat from=$myJobcategory}
							<option value="{$mycat->id}" {if $mycat->id == $formData.fjcid}selected="selected"{/if}>{if $mycat->level > 1} &nbsp; &nbsp; {/if}{$mycat->name}</option>
						{/foreach}
					</select> -

				{$lang.controller.labelStatus}:
					<select name="fstatus" id="fstatus">
                        <option value="">- - - -</option>
                        {html_options options=$statusList selected=$formData.fstatus}
                   </select> <br /> <br />

				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option>
					<option value="content" {if $formData.fsearchin eq "content"}selected="selected"{/if}>{$lang.controller.labelContent}</option></select>

				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />

			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/job/index";




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

		var jcid = $('#fjcid').val();
		if(jcid.length > 0)
		{
			path += '/jcid/' + jcid;
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




