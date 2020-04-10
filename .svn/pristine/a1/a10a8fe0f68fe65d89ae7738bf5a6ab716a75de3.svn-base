<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">AccessTicketType</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_accesstickettype"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.accesstickettypeBulkToken}" />
				<table class="table table-striped">
		
				{if $accesstickettypes|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelGroupcontroller}</th>
							<th>{$lang.controller.labelController}</th>
							<th>{$lang.controller.labelAction}</th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelDescription}</th>
							<th>{$lang.controller.labelStatus}</th>
							<!-- <th>{$lang.controller.labelIpaddress}</th> -->
							<!-- <th>{$lang.controller.labelDatecreated}</th>
							<th>{$lang.controller.labelDatemodified}</th> -->
							<th width="140"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="12">
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
					{foreach item=accesstickettype from=$accesstickettypes}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$accesstickettype->id}" {if in_array($accesstickettype->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$accesstickettype->id}</td>
							
							<td>{$accesstickettype->groupcontroller}</td>
							<td>{$accesstickettype->controller}</td>
							<td>{$accesstickettype->action}</td>
							<td>{$accesstickettype->name}</td>
							<td>{$accesstickettype->description}</td>
							<td>{if $accesstickettype->checkStatusName('enable')}
									<span class="label label-success">{$accesstickettype->getStatusName()}</span>
								{else}
									<span class="label label-important">{$accesstickettype->getStatusName()}</span>
								{/if}</td>
							<!-- <td>{$accesstickettype->ipaddress}</td> -->
							<!-- <td>{$accesstickettype->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$accesstickettype->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td> -->
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$accesstickettype->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$accesstickettype->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
						<td>{$lang.controller.labelGroupcontroller}:</td>
						<td style="float:left;">
							<select name="fgroupcontroller" id="fgroupcontroller" style="width:200px;">
								<option value="">---Group Controller---</option>
								{foreach item=groupcontroller from=$groupcontrollerlist}
								<option value="{$groupcontroller}" {if $groupcontroller==$formData.fgroupcontroller}selected="selected"{/if}>{$groupcontroller}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelController}:</td>
						<td style="float:left;">
							<select name="fcontroller" id="fcontroller" style="width:200px;">
								<option value="">---Controller---</option>
								{foreach item=controller from=$controllerlist}
								<option value="{$controller}" {if $formData.fcontroller == $controller}selected="selected"{/if}>{$controller}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelAction}:</td>
						<td style="float:left;"><input type="text" name="faction" id="faction" value="{$formData.faction|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelName}:</td>
						<td style="float:left;"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="float:left;">
							<select name="fstatus" id="fstatus">
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="float:left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.formKeywordLabel}:</td>
						<td style="float:left;">
							<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
							<select name="fsearchin" id="fsearchin">
								<option value="">{$lang.controller.formKeywordInLabel}</option>
								<option value="groupcontroller" {if $formData.fsearchin eq "groupcontroller"}selected="selected"{/if}>{$lang.controller.labelGroupcontroller}</option>
								<option value="controller" {if $formData.fsearchin eq "controller"}selected="selected"{/if}>{$lang.controller.labelController}</option>
								<option value="action" {if $formData.fsearchin eq "action"}selected="selected"{/if}>{$lang.controller.labelAction}</option>
								<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
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
	
	$(document).ready(function() {
		$("#fgroupcontroller").select2();
		$("#fcontroller").select2();

		$("#fgroupcontroller").change(function(event) {
			var groupcontroller = $(this).val();
			$.ajax({
				url: rooturl_cms + 'accesstickettype/getcontrollerajax',
				type: 'POST',
				dataType: 'json',
				data: {groupcontroller:groupcontroller},
				success : function(data){
					var htmldata = '<option selected="selected" value="">---Controller---</option>';
					$.each(data, function(index, value) {						 
						if(index == 0){
							htmldata += '<option value="'+value+'">'+value+'</option>';
						}else{
							htmldata += '<option value="'+value+'">'+value+'</option>';
						}
					});
					$("#fcontroller").html(htmldata);
				}
			})						
		});
	});

	function gosearch()
	{
		var path = rooturl + controllerGroup + "/accesstickettype/index";
		

		var groupcontroller = $('#fgroupcontroller').val();
		if(groupcontroller.length > 0)
		{
			path += '/groupcontroller/' + groupcontroller;
		}

		if($("#fcontroller").length > 0)
		{
			var controller = $('#fcontroller').val();
			if(controller.length > 0)
			{
				path += '/controller/' + controller;
			}
		}

		var action = $('#faction').val();
		if(action.length > 0)
		{
			path += '/action/' + action;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
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
			
			


