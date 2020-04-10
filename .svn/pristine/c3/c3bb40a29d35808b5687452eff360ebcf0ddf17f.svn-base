<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">JobReview</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_jobreview"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab3" data-toggle="tab">{$lang.controller.labelModeratorReview}({$totalpending})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<!--<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>-->
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.jobreviewBulkToken}" />
				<table class="table table-striped">
		
				{if $jobreviews|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							<th><a href="{$filterUrl}sortby/parentid/sorttype/{if $formData.sortby eq 'parentid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelParentid}</a></th>							
							
							<th>{$lang.controller.labelUid}</th>
							<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelObjectid}</a></th>							
							<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
							<th><a href="{$filterUrl}sortby/text/sorttype/{if $formData.sortby eq 'text'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelText}</a></th>														
							<th>{$lang.controller.labelStatus}</th>							
							<th><a href="{$filterUrl}sortby/countreply/sorttype/{if $formData.sortby eq 'countreply'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreply}</a></th>
																				
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
										<option value="success">{$lang.controller.bulkActionSuccessLabel}</option>
										<option value="pending">{$lang.controller.bulkActionPendingLabel}</option>
										<option value="spam">{$lang.controller.bulkActionSpamLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=jobreview from=$jobreviews}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$jobreview->id}" {if in_array($jobreview->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$jobreview->id}</td>
							<td>{if $jobreview->parentid > 0}{$jobreview->parentid}{/if}</td>							
							<td><span class="label label-info">{if $jobreview->actor->id > 0}{$jobreview->actor->fullname}{else}{$jobreview->fullname}{/if}</span></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}job/index/id/{$jobreview->product->id}">{$jobreview->jobactor->title}</a></td>							
							<td>{$jobreview->email}</td>
							<td>{$jobreview->text}</td>														
							<td>{if $jobreview->checkStatusName('enable')}
									<span class="label label-success">{$jobreview->getStatusName()}</span>
								{elseif $jobreview->checkStatusName('pending')}
									<span class="label label-warning">{$jobreview->getStatusName()}</span>
								{else}
									<span class="label label-important">{$jobreview->getStatusName()}</span>
								{/if}</td>							
							<td>{$jobreview->countreply}</td>
														
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$jobreview->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$jobreview->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
		
		<div class="tab-pane" id="tab3">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.jobreviewBulkToken}" />
				<table class="table table-striped">

				{if $totalpending > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							<th><a href="{$filterUrl}sortby/parentid/sorttype/{if $formData.sortby eq 'parentid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelParentid}</a></th>							
							
							<th>{$lang.controller.labelUid}</th>
							<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelObjectid}</a></th>							
							<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
							<th><a href="{$filterUrl}sortby/text/sorttype/{if $formData.sortby eq 'text'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelText}</a></th>														
							<th>{$lang.controller.labelStatus}</th>							
							<th><a href="{$filterUrl}sortby/countreply/sorttype/{if $formData.sortby eq 'countreply'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreply}</a></th>
																				
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
										<option value="success">{$lang.controller.bulkActionSuccessLabel}</option>
										<option value="pending">{$lang.controller.bulkActionPendingLabel}</option>
										<option value="spam">{$lang.controller.bulkActionSpamLabel}</option>										
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=jobreview from=$jobreviewpending}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$jobreview->id}" {if in_array($jobreview->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$jobreview->id}</td>
							<td>{if $jobreview->parentid > 0}{$jobreview->parentid}{/if}</td>							
							<td><span class="label label-info">{if $jobreview->actor->id > 0}{$jobreview->actor->fullname}{else}{$jobreview->fullname}{/if}</span></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}job/index/id/{$jobreview->product->id}">{$jobreview->jobactor->title}</a></td>							
							<td>{$jobreview->email}</td>
							<td>{$jobreview->text}</td>														
							<td>{if $jobreview->checkStatusName('enable')}
									<span class="label label-success">{$jobreview->getStatusName()}</span>
								{elseif $jobreview->checkStatusName('pending')}
									<span class="label label-warning">{$jobreview->getStatusName()}</span>
								{else}
									<span class="label label-important">{$jobreview->getStatusName()}</span>
								{/if}</td>							
							<td>{$jobreview->countreply}</td>
														
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$jobreview->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$jobreview->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
								<a href="{$conf.rooturl_cms}jobreview/reply/parentid/{$productreview->id}" rel="shadowbox;height=200;width=600px" class="btn btn-mini"><i class="icon-white"></i>Reply</a>
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
		</div><!--end #tab 3-->
		
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelObjectid}: <input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelFullname}: <input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelEmail}: <input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelText}: <input type="text" name="ftext" id="ftext" value="{$formData.ftext|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelModeratorid}: <input type="text" name="fmoderatorid" id="fmoderatorid" value="{$formData.fmoderatorid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCountreply}: <input type="text" name="fcountreply" id="fcountreply" value="{$formData.fcountreply|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelParentid}: <input type="text" name="fparentid" id="fparentid" value="{$formData.fparentid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="fullname" {if $formData.fsearchin eq "fullname"}selected="selected"{/if}>{$lang.controller.labelFullname}</option>
					<option value="email" {if $formData.fsearchin eq "email"}selected="selected"{/if}>{$lang.controller.labelEmail}</option>
					<option value="text" {if $formData.fsearchin eq "text"}selected="selected"{/if}>{$lang.controller.labelText}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/jobreview/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var objectid = $('#fobjectid').val();
		if(objectid.length > 0)
		{
			path += '/objectid/' + objectid;
		}

		var fullname = $('#ffullname').val();
		if(fullname.length > 0)
		{
			path += '/fullname/' + fullname;
		}

		var email = $('#femail').val();
		if(email.length > 0)
		{
			path += '/email/' + email;
		}

		var text = $('#ftext').val();
		if(text.length > 0)
		{
			path += '/text/' + text;
		}

		var moderatorid = $('#fmoderatorid').val();
		if(moderatorid.length > 0)
		{
			path += '/moderatorid/' + moderatorid;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var countreply = $('#fcountreply').val();
		if(countreply.length > 0)
		{
			path += '/countreply/' + countreply;
		}

		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
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
			
			


