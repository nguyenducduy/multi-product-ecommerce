<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">AccessTicket</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_accessticket"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/clone">{$lang.controller.head_clone}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.accessticketBulkToken}" />
				<table class="table table-striped">
		
				{if $accesstickets|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelUid}</th>							
							<th>{$lang.controller.labelTickettype}</th>
							<th><a href="{$filterUrl}sortby/groupcontroller/sorttype/{if $formData.sortby eq 'groupcontroller'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelGroupcontroller}</a></th>
							<th><a href="{$filterUrl}sortby/controller/sorttype/{if $formData.sortby eq 'controller'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelController}</a></th>
							<th><a href="{$filterUrl}sortby/action/sorttype/{if $formData.sortby eq 'action'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelAction}</a></th>
							<th><a href="{$filterUrl}sortby/suffix/sorttype/{if $formData.sortby eq 'suffix'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSuffix}</a></th>
							<th><a href="{$filterUrl}sortby/fullticket/sorttype/{if $formData.sortby eq 'fullticket'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelFullticket}</a></th>							
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
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=accessticket from=$accesstickets}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$accessticket->id}" {if in_array($accessticket->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$accessticket->id}</td>
							
							<td><span class="label label-info">{$accessticket->actor->fullname}</span></td>							
							<td>{$accessticket->accesstickettypeactor->name}</td>
							<td>{$accessticket->groupcontroller}</td>
							<td>{$accessticket->controller}</td>
							<td>{$accessticket->action}</td>
							<td>{$accessticket->suffix}</td>
							<td>{$accessticket->fullticket}</td>
							<td>
								{if $accessticket->checkStatusName('enable')}
									<span class="label label-success">{$accessticket->getStatusName()}</span>
								{else}
									<span class="label label-important">{$accessticket->getStatusName()}</span>
								{/if}								
							</td>							
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$accessticket->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$accessticket->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
						<td>{$lang.controller.labelUid}:</td>
						<td style="float:left;"><input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelTickettype}:</td>
						<td style="float:left;">
							<select name="ftickettype" id="ftickettype" style="width:200px;">
								<option value="0">----------</option>
								{foreach item=accesstickettype from=$accesstickettypelist}
								<option {if $accesstickettype->id == $formData.ftickettype}selected="selected"{/if} value="{$accesstickettype->id}">{$accesstickettype->name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
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
						<td><input type="text" name="faction" id="faction" value="{$formData.faction|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelSuffix}:</td>
						<td style="float:left;"><input type="text" name="fsuffix" id="fsuffix" value="{$formData.fsuffix|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelFullticket}:</td>
						<td style="float:left;"><input type="text" name="ffullticket" id="ffullticket" value="{$formData.ffullticket|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="float:left;">
							<select name="fstatus" id="fstatus">
								<option value="0">----------</option>
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="float:left;">
							<input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" />
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
		$("#ftickettype").select2();

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
		var path = rooturl + controllerGroup + "/accessticket/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}		

		var tickettype = $('#ftickettype').val();
		if(tickettype.length > 0)
		{
			path += '/tickettype/' + tickettype;
		}

		var groupcontroller = $('#fgroupcontroller').val();
		if(groupcontroller.length > 0)
		{
			path += '/groupcontroller/' + groupcontroller;
		}

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

		var suffix = $('#fsuffix').val();
		if(suffix.length > 0)
		{
			path += '/suffix/' + suffix;
		}

		var fullticket = $('#ffullticket').val();
		if(fullticket.length > 0)
		{
			path += '/fullticket/' + fullticket;
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
		
		
		document.location.href= path;
	}
</script>
{/literal}
			
			


