<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Contact</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_contact_list"><h1>{$lang.controller.head_list}</h1></div>


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
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">
					
				{if $contacts|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30"><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.default.formIdLabel}</a></th>
							<th width="150">{$lang.controller.formFullnameLabel}</th>	
							<th width="100"><a href="{$filterUrl}sortby/reason/sorttype/{if $formData.sortby eq 'reason'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.formReasonLabel}</a></th>	
							<th>{$lang.controller.formMessageLabel}</th>
							<th width="80"><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.formStatusLabel}</a></th>	
							<th width="100">{$lang.controller.formIpAddressLabel}</th>
							<th width="100"><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.formDateCreatedLabel}</a></th>
							<th width="140"></th>
						</tr>
					</thead>
					
					<tfoot>
						<tr>
							<td colspan="9">
								
								
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
						{foreach item=contact from=$contacts}

								<tr>
									<td><input type="checkbox" name="fbulkid[]" value="{$contact->id}" {if in_array($contact->id, $formData.fbulkid)}checked="checked"{/if}/></td>
									<td style="font-weight:bold;">{$contact->id}</td>
									<td><strong>{$contact->fullname}</strong><br />
										<div style="color:#888;">
											<small>
												{$contact->email}<br />
												{if $contact->phone != ''}{$lang.controller.formPhoneLabel}:{$contact->phone}<br />{/if}

											</small></div>
										</td>
									<td>{if $contact->reason == 'general'}{$lang.controller.reasonGeneral}{elseif $contact->reason == 'ads'}{$lang.controller.reasonAds}{elseif $contact->reason == 'idea'}{$lang.controller.reasonIdea}{elseif $contact->reason == 'support'}{$lang.controller.reasonSupport}{/if}</td>
									<td>{$contact->message}</td>
									<td>{if $contact->status == 'completed'}<span class="label label-success"><i class="icon-ok icon-white"></i> Completed</span>{elseif $contact->status == 'pending'}<span class="label">Pending</span>{else}<span class="label">New</span>{/if}
										{if $contact->note != ''}<div style="font-style:italic; font-size:11px;" title="{$contact->note}"><small>{$lang.controller.formNoteLabel}: {$contact->note}</small></div>{/if}
									</td>
									<td>{$contact->ipaddress}</td>
									<td title="{$contact->datecreated|date_format:"%H:%M, %B %e, %Y"}">{$contact->datecreated|relative_datetime}</td>
									<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}contact/edit/id/{$contact->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
									<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}contact/delete/id/{$contact->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
									</td>
								</tr>


						{/foreach}
						
				</tbody>
					
				  
				{else}
					<tr>
						<td colspan="9"> {$lang.default.notfound}</td>
					</tr>
				{/if}
				
				</table>
			</form>
			
			
		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.default.formIdLabel}: 
				<input type="text" name="fid" id="fid" size="8" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 
				
				{$lang.controller.formReasonLabel}:	
				<select name="freason" id="freason">
					<option value="">- - - - - - - - - - - - -</option>
					<option value="general" {if $formData.freason eq 'general'}selected="selected"{/if}>{$lang.controller.reasonGeneral}</option>
					<option value="ads" {if $formData.freason eq 'ads'}selected="selected"{/if}>{$lang.controller.reasonAds}</option>
					<option value="idea" {if $formData.freason eq 'idea'}selected="selected"{/if}>{$lang.controller.reasonIdea}</option>
					<option value="support" {if $formData.freason eq 'support'}selected="selected"{/if}>{$lang.controller.reasonSupport}</option>
				</select> -
			
				{$lang.controller.formStatusLabel}:	
				<select name="fstatus" id="fstatus">
					<option value="">- - - - - - - - - - - - -</option>
					<option value="new" {if $formData.fstatus eq 'new'}selected="selected"{/if}>New</option>
					<option value="pending" {if $formData.fstatus eq 'pending'}selected="selected"{/if}>Pending</option>
					<option value="completed" {if $formData.fstatus eq 'completed'}selected="selected"{/if}>Completed</option>
				</select> -
			
				{$lang.controller.formKeywordLabel}:
		
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="text-input" /><select name="fsearchin" id="fsearchin">
					<option value="">- - - - - - - - - - - - -</option>
					<option value="fullname" {if $formData.fsearchin eq 'fullname'}selected="selected"{/if}>{$lang.controller.formKeywordInFullnameLabel}</option>
					<option value="email" {if $formData.fsearchin eq 'email'}selected="selected"{/if}>{$lang.controller.formKeywordInEmailLabel}</option>
					<option value="phone" {if $formData.fsearchin eq 'phone'}selected="selected"{/if}>{$lang.controller.formKeywordInPhoneLabel}</option>
					<option value="message" {if $formData.fsearchin eq 'message'}selected="selected"{/if}>{$lang.controller.formKeywordInMessageLabel}</option>
					<option value="ipaddress" {if $formData.fsearchin eq 'ipaddress'}selected="selected"{/if}>{$lang.controller.formKeywordInIpAddressLabel}</option>
					<option value="note" {if $formData.fsearchin eq 'note'}selected="selected"{/if}>{$lang.controller.formKeywordInNoteLabel}</option>
				
				</select>
			
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>


{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "contact/index";
		
		var id = $("#fid").val();
		if(parseInt(id) > 0)
		{
			path += "/id/" + id;
		}
		
		var reason = $("#freason").val();
		if(reason.length > 0)
		{
			path += "/reason/" + reason;
		}
		
		var status = $("#fstatus").val();
		if(status.length > 0)
		{
			path += "/status/" + status;
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



