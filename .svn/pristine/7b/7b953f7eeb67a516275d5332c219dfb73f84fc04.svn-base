<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject">List Project</a> <span class="divider"> /</span> </li>
    <li class="active">{$formData.nameproject}<span class="divider">  /</span> </li>
</ul>

<div class="page-header" rel="menu_scrumproject"><h1>PROJECT DETAIL : {$formData.nameproject}</h1></div>


<div class="tabbable">

	<div class='divTitleProject'>
			{$formData.countIteration}<br>
		<b>Interation</b>
	</div>
	<div class='divTitleProject'>
			<a href="{$conf.rooturl}{$controllerGroup}/scrumstory/index/fstatus/1">{$formData.countStory}<br>
		<b>Story Done</b></a>
	</div>

	<div class='divTitlemesProject'>
			<b>{$lang.controller.labelCurrentIteration}</b>: {$formData.iterationCur}  ({$formData.iterationTimeCurStart} - {$formData.iterationTimeCurend})<br>
			<a href='{$conf.rooturl}{$controllerGroup}/scrumstory'>{$lang.controller.labelPlaning}</a><br>
			<a href='{$conf.rooturl}{$controllerGroup}/scrumiteration/add/pid/{$projectId}'>{$lang.controller.labelAddNewStory}</a><br>
	</div>

</div>

	<div class="tab-content">
        {if {$formData.permiss}=='1'}
            <li class="pull-right" style="margin-right: 12px;margin-bottom: 8px;list-style-type: none;"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/scrumiteration/add/spid/{$projectId}">Add Iteration</a></li>
        {/if}
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumprojectBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumiterations|@count > 0 || $formData.countBackLog > 0}
					<thead>
						<tr>
							<th >{$lang.controller.labelPrint}</th>
							<th >Session</th>
							<th >{$lang.controller.labelStory}</th>
							<th >Count Meeting</th>
							<th >{$lang.controller.labelStart}</th>
							<th >{$lang.controller.labelEnd}</th>
							<th >{$lang.controller.labelStatus}</th>
							{literal}
<!-- 							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
 -->							{/literal}
                            {if {$formData.permiss}=='1'}
							<th width="300"></th>
                            {/if}
                        </tr>
					</thead>
		

					<tbody>
					<tr>
						<td style="font-weight:bold;">{$lang.controller.labelBackLog}</td>
						<td><a href='{$conf.rooturl}{$controllerGroup}/scrumstory/index/fibacklogstory/0'><span class="badge badge-info">{$formData.countBackLog}</span></a></td>
						<td>Empty</td>
						<td>Empty</td>
						<td>Empty</td>
						<td>Empty</td>
						<td>Empty</td>
						<td>						</td>
					</tr>
					{foreach item=scrumiteration from=$scrumiterations}
		
						<tr>
							<td style="font-weight:bold;"><a href='{if $scrumiteration->countstory>0}{$conf.rooturl}{$controllerGroup}/scrumstory/index/siid/{$scrumiteration->id}{else}#{/if}'>{$scrumiteration->name}</a></td>
							<td><a href='{$conf.rooturl}{$controllerGroup}/scrumsession/index/spid/{$scrumiteration->spid}'><span class="">{$scrumiteration->namesession}</span></a></td>
							<td><a href='{$conf.rooturl}{$controllerGroup}/scrumstory/index/siid/{$scrumiteration->id}'><span class="badge badge-info">{$scrumiteration->countstory}</span></a></td>
							<td><a href='{$conf.rooturl}{$controllerGroup}/scrummeeting/index/siid/{$scrumiteration->id}'><span class="badge badge-info">{$scrumiteration->countmeeting}</span></a></td>
							<td>{$scrumiteration->datestarted}</td>
							<td>{$scrumiteration->dateended}</td>
							<td><span class="badge badge-{if $scrumiteration->statusname=='Done'}success{else}warning{/if}">{$scrumiteration->statusname}</span></td>
                            {if {$formData.permiss}=='1'}
                            <td>

                                <a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/scrumiteration/edit/id/{$scrumiteration->id}/redirect/{$redirectUrl}/pid/{$projectId}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="" class="btn btn-mini "><i class="icon-calendar"></i> {$lang.controller.formPlanLabel}</a>
								<a title="{$lang.default.formActionDeleteTooltip}" href="" class="btn btn-mini "><i class="icon-signal"></i> {$lang.controller.formChartLabel}</a>
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/scrumiteration/delete/id/{$scrumiteration->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>

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

		</div><!-- end #tab 1 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	
</script>
{/literal}
			
			


