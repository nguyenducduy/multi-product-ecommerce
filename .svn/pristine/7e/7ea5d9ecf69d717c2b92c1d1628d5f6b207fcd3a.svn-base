<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Jobcv</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_jobcv"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.jobcvBulkToken}" />
				<table class="table table-striped">
		
				{if $jobcvs|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/jid/sorttype/{if $formData.sortby eq 'jid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelJid}</a></th>
							<th>{$lang.controller.labelTitle}</th>							
							<th><a href="{$filterUrl}sortby/firstname/sorttype/{if $formData.sortby eq 'firstname'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelFirstnameLastname}</a></th>							
							<th>{$lang.controller.labelBirthday}</th>
							<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
							<th><a href="{$filterUrl}sortby/phone/sorttype/{if $formData.sortby eq 'phone'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPhone}</a></th>
							<!--<th>{$lang.controller.labelModeratorid}</th>-->
							<!--<th>{$lang.controller.labelIpaddress}</th>-->
							<th>{$lang.controller.labelStatus}</th>
							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>
							<th>{$lang.controller.labelDateInterview}</th>
							<th>{$lang.controller.labelFile}</th>
							<th width="140"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="13">
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
					{foreach item=jobcv from=$jobcvs}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$jobcv->id}" {if in_array($jobcv->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$jobcv->id}</td>
							
							<td><a target="_blank" href="{$conf.rooturl_cms}job/index/id/{$jobcv->jid}">{$jobcv->jobactor->title}</a></td>
							<td>{$jobcv->title}</td>							
							<td>{$jobcv->firstname} {$jobcv->lastname}</td>							
							<td>{$jobcv->birthday}</td>
							<td>{$jobcv->email}</td>
							<td>{$jobcv->phone}</td>							
							<td>{if $jobcv->checkStatusName('mới')}
									<span class="label label-success">{$jobcv->getStatusName()}</span>
								{elseif $jobcv->checkStatusName('hẹn phỏng vấn')}
									<span class="label label-info">{$jobcv->getStatusName()}</span>
								{else}
									<span class="label label">{$jobcv->getStatusName()}</span>
								{/if}</td>
							<td>{$jobcv->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{if $jobcv->dateinterview != 0}{$jobcv->dateinterview|date_format:$lang.default.dateFormatTimeSmarty}{else}-{/if}</td>
							<td><a title="{$jobcv->title}" class="tipsy-trigger" href="{$conf.rooturl}uploads/jobcv/{$jobcv->file}" target="_blank">Xem file</a></td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$jobcv->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$jobcv->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
						<td style="text-align: right;">{$lang.controller.labelJid}:</td>
						<td style="text-align: left;">
							<select name="fjid" id="fjid">
								{foreach item=job from=$joblist}
								<option {if $formData.fjid == $job->id}{/if} value="{$job->id}">{$job->title}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelTitle}:</td>
						<td style="text-align: left;"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xlarge" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelFirstname}:</td>
						<td style="text-align: left;"><input type="text" name="ffirstname" id="ffirstname" value="{$formData.ffirstname|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelLastname}:</td>
						<td style="text-align: left;"><input type="text" name="flastname" id="flastname" value="{$formData.flastname|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelEmail}:</td>
						<td style="text-align: left;"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelPhone}:</td>
						<td style="text-align: left;"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-large" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelModeratorid}:</td>
						<td style="text-align: left;"><select name="fmoderatorid" id="fmoderatorid" class="autocompletestaff"></select></td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelStatus}:</td>
						<td style="text-align: left;">
							<select name="fstatus" id="fstatus">
								<option value="">- - - -</option>
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.formKeywordLabel}:</td>
						<td style="text-align: left;">
							<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
							<select name="fsearchin" id="fsearchin">
								<option value="">{$lang.controller.formKeywordInLabel}</option>
								<option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option>
								<option value="firstname" {if $formData.fsearchin eq "firstname"}selected="selected"{/if}>{$lang.controller.labelFirstname}</option>
								<option value="lastname" {if $formData.fsearchin eq "lastname"}selected="selected"{/if}>{$lang.controller.labelLastname}</option>
								<option value="email" {if $formData.fsearchin eq "email"}selected="selected"{/if}>{$lang.controller.labelEmail}</option>
								<option value="phone" {if $formData.fsearchin eq "phone"}selected="selected"{/if}>{$lang.controller.labelPhone}</option></select>	
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">{$lang.controller.labelId}:</td>
						<td style="text-align: left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>						
						<td style="text-align: right;"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
						<td></td>
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
		var path = rooturl + controllerGroup + "/jobcv/index";
		

		var jid = $('#fjid').val();
		if(jid.length > 0)
		{
			path += '/jid/' + jid;
		}

		var title = $('#ftitle').val();
		if(title.length > 0)
		{
			path += '/title/' + title;
		}

		var firstname = $('#ffirstname').val();
		if(firstname.length > 0)
		{
			path += '/firstname/' + firstname;
		}

		var lastname = $('#flastname').val();
		if(lastname.length > 0)
		{
			path += '/lastname/' + lastname;
		}

		var email = $('#femail').val();
		if(email.length > 0)
		{
			path += '/email/' + email;
		}

		var phone = $('#fphone').val();
		if(phone.length > 0)
		{
			path += '/phone/' + phone;
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
			
			


