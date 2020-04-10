<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteMember</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_lottemember"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		<li><a href="#tab3" data-toggle="tab">Thông kê code</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
                {if $permission}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
                {/if}
        </ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.lottememberBulkToken}" />
				<table class="table table-striped">
		
				{if $lottemembers|@count > 0}
					<thead>
						<tr>
                                                        {if $permission}
                                                        <th width="40"><input class="check-all" type="checkbox" /></th>
                                                        {/if}
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/leid/sorttype/{if $formData.sortby eq 'leid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Tên Event</a></th>
							<th><a href="{$filterUrl}sortby/fullname/sorttype/{if $formData.sortby eq 'fullname'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelFullname}</a></th>
							<th><a href="{$filterUrl}sortby/gender/sorttype/{if $formData.sortby eq 'gender'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelGender}</a></th>
							<th><a href="{$filterUrl}sortby/region/sorttype/{if $formData.sortby eq 'region'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelRegion}</a></th>
							<th><a href="{$filterUrl}sortby/referermemberid/sorttype/{if $formData.sortby eq 'referermemberid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelReferermemberid}</a></th>
							<th>cmnd</th>
							<th>phone</th>
                                                        {if $permission}
							<th width="140"></th>
                                                        {/if}
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="9">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
                                                                {if $permission}
								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
                                                                {/if}
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=lottemember from=$lottemembers}
		
						<tr>
                                                        {if $permission}
							<td><input type="checkbox" name="fbulkid[]" value="{$lottemember->id}" {if in_array($lottemember->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							{/if}
                                                        <td style="font-weight:bold;"><span class="badge badge-info">{$lottemember->id}</span></td>
							
							<td>
								{foreach $event as $k=>$v}
									{if {$lottemember->leid}==$v->id}
										{$v->name}
									{else}
										_
									{/if}
								{/foreach}
							</td>
							<td>{$lottemember->fullname}</td>
							<td><span class="label label-info">{if {$lottemember->gender}==1}Nam{else}Nữ{/if}</span></td>
							<td>{$region.{$lottemember->region}}</td>
							<td>{$lottemember->referermemberid}</td>
							<td>{$lottemember->cmnd}</td>
							<td>{$lottemember->phone}</td>

							{if $permission}
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$lottemember->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$lottemember->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelLeid}: <input type="text" name="fleid" id="fleid" value="{$formData.fleid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelUrlcode}: <input type="text" name="furlcode" id="furlcode" value="{$formData.furlcode|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelFullname}: <input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelEmail}: <input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelGender}: <input type="text" name="fgender" id="fgender" value="{$formData.fgender|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPhone}: <input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCmnd}: <input type="text" name="fcmnd" id="fcmnd" value="{$formData.fcmnd|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelRegion}: <input type="text" name="fregion" id="fregion" value="{$formData.fregion|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelReferermemberid}: <input type="text" name="freferermemberid" id="freferermemberid" value="{$formData.freferermemberid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatecreated}: <input type="text" name="fdatecreated" id="fdatecreated" value="{$formData.fdatecreated|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatemodified}: <input type="text" name="fdatemodified" id="fdatemodified" value="{$formData.fdatemodified|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="urlcode" {if $formData.fsearchin eq "urlcode"}selected="selected"{/if}>{$lang.controller.labelUrlcode}</option>
					<option value="fullname" {if $formData.fsearchin eq "fullname"}selected="selected"{/if}>{$lang.controller.labelFullname}</option>
					<option value="email" {if $formData.fsearchin eq "email"}selected="selected"{/if}>{$lang.controller.labelEmail}</option>
					<option value="phone" {if $formData.fsearchin eq "phone"}selected="selected"{/if}>{$lang.controller.labelPhone}</option>
					<option value="cmnd" {if $formData.fsearchin eq "cmnd"}selected="selected"{/if}>{$lang.controller.labelCmnd}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
                <div class="tab-pane" id="tab3">
				<table class="table table-striped">
				{if $staticmember|@count > 0}
					<thead>
						<tr>
							
							<th>Mã người chơi</th>
							<th>Tên Người chơi</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Cmnd</th>
							<th>Tổng số code</th>

						</tr>
					</thead>
					<tbody>
					{foreach $staticmember as $k=>$staticmembers}
		
						<tr>
							<td style="font-weight:bold;"><span class="badge badge-info">{$staticmembers.lm_id}</span></td>
							
							
							<td>{$staticmembers.name}</td>
							<td>{$staticmembers.email}</td>
							<td>{$staticmembers.phone}</td>
							<td>{$staticmembers.cmnd}</td>
							<td>{$staticmembers.countcode}</td>

							
						</tr>
			

					{/foreach}
					</tbody>
		
	  
				{else}
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
				{/if}
	
				</table>

		</div>
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/lottemember/index";
		

		var leid = $('#fleid').val();
		if(leid.length > 0)
		{
			path += '/leid/' + leid;
		}

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var urlcode = $('#furlcode').val();
		if(urlcode.length > 0)
		{
			path += '/urlcode/' + urlcode;
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

		var gender = $('#fgender').val();
		if(gender.length > 0)
		{
			path += '/gender/' + gender;
		}

		var phone = $('#fphone').val();
		if(phone.length > 0)
		{
			path += '/phone/' + phone;
		}

		var cmnd = $('#fcmnd').val();
		if(cmnd.length > 0)
		{
			path += '/cmnd/' + cmnd;
		}

		var region = $('#fregion').val();
		if(region.length > 0)
		{
			path += '/region/' + region;
		}

		var referermemberid = $('#freferermemberid').val();
		if(referermemberid.length > 0)
		{
			path += '/referermemberid/' + referermemberid;
		}

		var datecreated = $('#fdatecreated').val();
		if(datecreated.length > 0)
		{
			path += '/datecreated/' + datecreated;
		}

		var datemodified = $('#fdatemodified').val();
		if(datemodified.length > 0)
		{
			path += '/datemodified/' + datemodified;
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
			
			


