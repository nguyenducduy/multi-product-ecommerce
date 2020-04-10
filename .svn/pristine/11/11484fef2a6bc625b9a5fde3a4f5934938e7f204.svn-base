<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject">List Project</a> <span class="divider"> /</span> </li>
    <li class="active">List Team Member<span class="divider">/</span> </li>
    
</ul>

<div class="page-header" rel="menu_scrumteammember"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
        {if {$formData.permiss}=='1'}
             <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/spid/{$projectId}">{$lang.controller.head_add}</a></li>
        {/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumteammemberBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumteammembers|@count > 0}
					<thead>
						<tr>

                            <th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelSpid}</th>
							<th><a href="{$filterUrl}sortby/stid/sorttype/{if $formData.sortby eq 'stid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStid}</a></th>
							<th><a href="{$filterUrl}sortby/uid/sorttype/{if $formData.sortby eq 'uid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelUid}</a></th>
							<th>{$lang.controller.labelRole}</th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th width="140"></th>
						</tr>
					</thead>

					<tbody>
					{foreach item=scrumteammember from=$scrumteammembers}
		
						<tr>

                            <td style="font-weight:bold;">{$scrumteammember->id}</td>
							
							<td>{$scrumteammember->spname}</td>
							<td>{$scrumteammember->stname}</td>
							<td>{$scrumteammember->uname}</td>
							<td>{$scrumteammember->rname}</td>
							<td>{$scrumteammember->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td>
                                {if {$scrumteammember->permiss}=='1'}
                                <a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$scrumteammember->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$scrumteammember->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							    {/if}
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
				{$lang.controller.labelSpid}: <input type="text" name="fspid" id="fspid" value="{$formData.fspid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStid}: <input type="text" name="fstid" id="fstid" value="{$formData.fstid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/scrumteammember/index";
		

		var spid = $('#fspid').val();
		if(spid.length > 0)
		{
			path += '/spid/' + spid;
		}

		var stid = $('#fstid').val();
		if(stid.length > 0)
		{
			path += '/stid/' + stid;
		}

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
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
			
			


