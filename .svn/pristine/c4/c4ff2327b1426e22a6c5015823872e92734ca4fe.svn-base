<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">CalendarEvent</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a>

<div class="page-header" rel="menu_calendarevent"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.calendareventBulkToken}" />
				<table class="table table-striped">
		
				{if $calendarevents|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelUid}</th>
							<th>{$lang.controller.labelCid}</th>
							<th>{$lang.controller.labelCcid}</th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelDescription}</th>
							<th>{$lang.controller.labelAddress}</th>
							<th>{$lang.controller.labelRegion}</th>
							<th>{$lang.controller.labelLat}</th>
							<th>{$lang.controller.labelLng}</th>
							<th>{$lang.controller.labelDatestart}</th>
							<th>{$lang.controller.labelDateend}</th>
							<th>{$lang.controller.labelTimestart}</th>
							<th>{$lang.controller.labelTimeend}</th>
							<th>{$lang.controller.labelIsrepeat}</th>
							<th>{$lang.controller.labelRepeattype}</th>
							<th>{$lang.controller.labelRepeatweekday}</th>
							<th>{$lang.controller.labelRepeatmonthday}</th>
							<th>{$lang.controller.labelPartnertype}</th>
							<th>{$lang.controller.labelPartnerid}</th>
							<th>{$lang.controller.labelPartnerdatesynced}</th>
							<th>{$lang.controller.labelStatus}</th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th>{$lang.controller.labelDatemodified}</th>
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
					{foreach item=calendarevent from=$calendarevents}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$calendarevent->id}" {if in_array($calendarevent->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$calendarevent->id}</td>
							
							<td>{$calendarevent->uid}</td>
							<td>{$calendarevent->cid}</td>
							<td>{$calendarevent->ccid}</td>
							<td>{$calendarevent->name}</td>
							<td>{$calendarevent->description}</td>
							<td>{$calendarevent->address}</td>
							<td>{$calendarevent->region}</td>
							<td>{$calendarevent->lat}</td>
							<td>{$calendarevent->lng}</td>
							<td>{$calendarevent->datestart|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$calendarevent->dateend|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$calendarevent->timestart|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$calendarevent->timeend|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$calendarevent->isrepeat}</td>
							<td>{$calendarevent->repeattype}</td>
							<td>{$calendarevent->repeatweekday}</td>
							<td>{$calendarevent->repeatmonthday}</td>
							<td>{$calendarevent->partnertype}</td>
							<td>{$calendarevent->partnerid}</td>
							<td>{$calendarevent->partnerdatesynced|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$calendarevent->status}</td>
							<td>{$calendarevent->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$calendarevent->datemodified|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$calendarevent->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$calendarevent->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCid}: <input type="text" name="fcid" id="fcid" value="{$formData.fcid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCcid}: <input type="text" name="fccid" id="fccid" value="{$formData.fccid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelRegion}: <input type="text" name="fregion" id="fregion" value="{$formData.fregion|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatestart}: <input type="text" name="fdatestart" id="fdatestart" value="{$formData.fdatestart|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDateend}: <input type="text" name="fdateend" id="fdateend" value="{$formData.fdateend|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIsrepeat}: <input type="text" name="fisrepeat" id="fisrepeat" value="{$formData.fisrepeat|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelRepeattype}: <input type="text" name="frepeattype" id="frepeattype" value="{$formData.frepeattype|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPartnertype}: <input type="text" name="fpartnertype" id="fpartnertype" value="{$formData.fpartnertype|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPartnerid}: <input type="text" name="fpartnerid" id="fpartnerid" value="{$formData.fpartnerid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
					<option value="description" {if $formData.fsearchin eq "description"}selected="selected"{/if}>{$lang.controller.labelDescription}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/calendarevent/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var cid = $('#fcid').val();
		if(cid.length > 0)
		{
			path += '/cid/' + cid;
		}

		var ccid = $('#fccid').val();
		if(ccid.length > 0)
		{
			path += '/ccid/' + ccid;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var region = $('#fregion').val();
		if(region.length > 0)
		{
			path += '/region/' + region;
		}

		var datestart = $('#fdatestart').val();
		if(datestart.length > 0)
		{
			path += '/datestart/' + datestart;
		}

		var dateend = $('#fdateend').val();
		if(dateend.length > 0)
		{
			path += '/dateend/' + dateend;
		}

		var isrepeat = $('#fisrepeat').val();
		if(isrepeat.length > 0)
		{
			path += '/isrepeat/' + isrepeat;
		}

		var repeattype = $('#frepeattype').val();
		if(repeattype.length > 0)
		{
			path += '/repeattype/' + repeattype;
		}

		var partnertype = $('#fpartnertype').val();
		if(partnertype.length > 0)
		{
			path += '/partnertype/' + partnertype;
		}

		var partnerid = $('#fpartnerid').val();
		if(partnerid.length > 0)
		{
			path += '/partnerid/' + partnerid;
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
			
			


