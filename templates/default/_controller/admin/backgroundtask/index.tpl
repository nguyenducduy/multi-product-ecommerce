<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Background Task</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<div class="page-header" rel="menu_backgroundtask"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.backgroundtaskBulkToken}" />
				<table class="table table-striped">
		
				{if $backgroundtasks|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">id</th>
							
							<th>URL</th>
							<th>Output</th>
							<th>IP Address</th>
							<th><a href="{$filterUrl}sortby/timeprocessing/sorttype/{if $formData.sortby eq 'timeprocessing'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Time Processing</a></th>
							<th>Date Created</th>
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
					{foreach item=backgroundtask from=$backgroundtasks}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$backgroundtask->id}" {if in_array($backgroundtask->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$backgroundtask->id}</td>
							
							<td><a href="{$backgroundtask->url}"><span class="label label-inverse">{$backgroundtask->url}</span></a>
								{if $backgroundtask->postdata != ''}<br />
									<small>POST data: <span class="label label-warning">{$backgroundtask->postdata}</span></small>
								{/if}
							</td>
							<td>{$backgroundtask->output}</td>
							<td><span class="label">{$backgroundtask->ipaddress}</span></td>
							<td><span class="badge badge-info">{$backgroundtask->timeprocessing}</span></td>
							<td>{$backgroundtask->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}{$controller}/delete/id/{$backgroundtask->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="url" {if $formData.fsearchin eq "url"}selected="selected"{/if}>{$lang.controller.labelUrl}</option>
					<option value="postdata" {if $formData.fsearchin eq "postdata"}selected="selected"{/if}>{$lang.controller.labelPostData}</option>
					<option value="output" {if $formData.fsearchin eq "output"}selected="selected"{/if}>{$lang.controller.labelOutput}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
		
	
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "backgroundtask/index";
		

		var controller = $('#fcontroller').val();
		if(controller.length > 0)
		{
			path += '/controller/' + controller;
		}

		var action = $('#faction').val();
		if(action.length > 0)
		{
			path += '/action/' + action;
		}

		var id = $('#fid').val();
		if(parseInt(id) > 0)
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
			
