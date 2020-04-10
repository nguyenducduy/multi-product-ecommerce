<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>{$pageTitle|default:$currentUrl}</title>

	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen"/>

	<!-- Bootstrap Responsive Stylesheet -->
	<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen"/>

	<!-- Customized Admin Stylesheet -->
	<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen"/>
	<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen"/>

	<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen"/>


	<!-- jQuery -->
	<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

	<!-- Bootstrap Js -->
	<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>


	<!-- customized admin -->
	<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
	<script type="text/javascript" src="{$currentTemplate}min/?g=jsadminchart&ver={$setting.site.jsversion}"></script>


	<script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_admin = "{$conf.rooturl_admin}";
		var rooturl_cms = "{$conf.rooturl_cms}";
		var rooturl_crm = "{$conf.rooturl_crm}";
		var rooturl_erp = "{$conf.rooturl_erp}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var controllerGroup = "{$controllerGroup}";
		var currentTemplate = "{$currentTemplate}";

		var websocketurl = "{$setting.site.websocketurl}";
		var websocketenable = {$setting.site.websocketenable};

		var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";


		var imageDir = "{$imageDir}";
		var loadingtext = '<img class="tmp_indicator" src="' + imageDir + 'ajax_indicator.gif" border="0" />';
		var gritterDelay = 3000;
		var meid = {$me->id};
		var meurl = "{$me->getUserPath()}";
		var userid = {$myUser->id};
		var userurl = "{$myUser->getUserPath()}";
	</script>

</head>


<div style="padding: 15px;margin-top:-50px;">

	<div class="page-header" rel="menu_feedback"><h1>{$lang.controller.head_list}</h1></div>


	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
			<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
			{if $formData.search != ''}
				<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
			{/if}
			<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
			<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/feedbacksection/add">{$lang.controller.head_add_section}</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">

				{include file="notify.tpl" notifyError=$error notifySuccess=$success}

				<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
					<input type="hidden" name="ftoken" value="{$smarty.session.feedbackBulkToken}"/>
					<table class="table table-striped">

						{if $feedbacks|@count > 0}
							<thead>
							<tr>
								{if {$formData.permiss}}
									<th width="40"><input class="check-all" type="checkbox"/></th>
								{/if}
								<th>
									<a href="{$filterUrl}sortby/section/sorttype/{if $formData.sortby eq 'section'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSection}</a>
								</th>
								<th>{$lang.controller.labelUid}</th>
								{if {$formData.pemiss}}
									<th>Match to Story</th>
								{/if}
								<th>{$lang.controller.labelAsa}</th>
								<th>{$lang.controller.labelIwant}</th>
								<th>{$lang.controller.labelSothat}</th>
								<th>{$lang.controller.labelFilepath}</th>
								<th>{$lang.controller.labelStatus}</th>
								<th>
									<a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a>
								</th>
								{if $myUser->groupid == $myUser->isGroup('administrator')}
									<th width="140"></th>
								{/if}
							</tr>
							</thead>
							{if {$formData.permiss}}
								<tfoot>
								<tr>
									<td colspan="8">
										<div class="pagination">
											{assign var="pageurl" value="page/::PAGE::"}
											{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
										</div>
										<!-- End .pagination -->


										<div class="bulk-actions align-left">
											<select name="fbulkaction">
												<option value="">{$lang.default.bulkActionSelectLabel}</option>
												<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
											</select>
											<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}"/>
										</div>

										<div class="clear"></div>
									</td>
								</tr>
								</tfoot>
							{/if}
							<tbody>
							{foreach item=feedback from=$feedbacks}
								<tr>
									{if {$formData.permiss}}
										<td><input type="checkbox" name="fbulkid[]" value="{$feedback->id}" {if in_array($feedback->id, $formData.fbulkid)}checked="checked"{/if}/></td>
									{/if}
									<td><a href="{$conf.rooturl_cms}feedback/index/section/{$feedback->section}/redirect/{$redirectUrl}">{$feedback->getFeedbacksectionName($feedback->section)}</a>
									</td>
									<td><img src="{$feedback->actor->getSmallImage()}" style="width:30px;height:30px;"/> <a
												href="{$conf.rooturl_cms}feedback/index/uid/{$feedback->actor->id}/redirect/{$redirectUrl}">{$feedback->actor->fullname}</a></td>
									{if {$formData.pemiss}}
										<td><a class="btn btn-primary" href="{$conf.rooturl_cms}feedback/match/id/{$feedback->id}" rel="shadowbox;height=170;width=600">Macth</a></td>{/if}
									<td>
										<span class="label">{$feedback->asa}</span><br/>

									</td>
									<td>{$feedback->iwant}</td>
									<td>{$feedback->sothat}</td>
									<td>{if $feedback->filepath != ''}<a href="{$conf.rooturl}uploads/feedback/{$feedback->filepath}" title="{$feedback->filepath}"><i class="icon icon-paper-clip"
																																									   style="font-size:16px;"></i>
											</a>{/if}</td>
									<td>
										{if $feedback->checkStatusName('new')}
										<span class="label label-info">{$feedback->getStatusName()}</span>
										{elseif $feedback->checkStatusName('accept')}
										<span class="label label-success">{$feedback->getStatusName()}</span>
										{elseif $feedback->checkStatusName('onprogress')}
										<span class="label label-warning">{$feedback->getStatusName()}<span>
                        		{elseif $feedback->checkStatusName('completed')}
												<span class="label label-inverse">{$feedback->getStatusName()}<span>
                                {/if}
									</td>
									<td style="text-align: left;">{$feedback->datecreated|date_format:$lang.default.dateFormatSmarty}</td>

									{if $myUser->groupid == $myUser->isGroup('administrator')}
										<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$feedback->id}/redirect/{$redirectUrl}"
											   class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
											{if {$formData.permiss}}
												<a title="{$lang.default.formActionDeleteTooltip}"
												   href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$feedback->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');"
												   class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
											{/if}
										</td>
									{/if}
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

			</div>
			<!-- end #tab 1 -->
			<div class="tab-pane" id="tab2">
				<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">

					{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini"/> -

					{$lang.controller.labelSection}:
					<select name="fsection" id="fsection">
						<option value="">------</option>
						{foreach item=section from=$mySection}
							<option value="{$section->id}" {if $formData.fsection == $section->id}selected="selected"{/if}>{$section->name}</option>
						{/foreach}
					</select> -


					{$lang.controller.formKeywordLabel}:
					<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class=""/>
					<select name="fsearchin" id="fsearchin">
						<option value="">{$lang.controller.formKeywordInLabel}</option>
						<option value="asa" {if $formData.fsearchin eq "asa"}selected="selected"{/if}>{$lang.controller.labelAsa}</option>
						<option value="iwant" {if $formData.fsearchin eq "iwant"}selected="selected"{/if}>{$lang.controller.labelIwant}</option>
						<option value="sothat" {if $formData.fsearchin eq "sothat"}selected="selected"{/if}>{$lang.controller.labelSothat}</option>
						<option value="filepath" {if $formData.fsearchin eq "filepath"}selected="selected"{/if}>{$lang.controller.labelFilepath}</option>
					</select>

					<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"/>

				</form>
			</div>
			<!-- end #tab2 -->
		</div>
	</div>

</div>

{literal}
	<script type="text/javascript">
		function gosearch() {
			var path = rooturl + controllerGroup + "/feedback/index";


			var section = $('#fsection').val();
			if (section.length > 0) {
				path += '/section/' + section;
			}

			var id = $('#fid').val();
			if (id.length > 0) {
				path += '/id/' + id;
			}

			var keyword = $("#fkeyword").val();
			if (keyword.length > 0) {
				path += "/keyword/" + keyword;
			}

			var keywordin = $("#fsearchin").val();
			if (keywordin.length > 0) {
				path += "/searchin/" + keywordin;
			}

			document.location.href = path;
		}
	</script>
{/literal}
			
			


