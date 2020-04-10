<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Gamefasteye</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_gamefasteye"><h1>{$lang.controller.head_list}</h1></div>
<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/gamefasteyequestion">Nhập câu hỏi</a> | <a href="{$conf.rooturl}{$controllerGroup}/gamefasteyeuser">Quản lý người chơi</a></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.gamefasteyeBulkToken}" />
				<table class="table table-striped">
		
				{if $gamefasteyes|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelName}</th>
							
							<th>{$lang.controller.labelTime}</th>
							<th>{$lang.controller.labelStarttime}</th>
							<th>{$lang.controller.labelExpiretime}</th>
							<th>{$lang.controller.labelStatus}</th>
							<th>{$lang.controller.labelDatecreated}</th>
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
					{foreach item=gamefasteye from=$gamefasteyes}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$gamefasteye->id}" {if in_array($gamefasteye->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$gamefasteye->id}</td>
							
							<td>{$gamefasteye->name}</td>
							<td>{date("H:i:s",$gamefasteye->time)}</td>
							<td>
							{if $smarty.now > $gamefasteye->starttime}
								<span class="label label">{if $gamefasteye->starttime > 0}{$gamefasteye->starttime|date_format:$lang.default.dateFormatTimeSmarty}{/if}</span>
							{else}
								<span class="label label-info">{$gamefasteye->starttime|date_format:$lang.default.dateFormatTimeSmarty}</span>
							{/if}	
							</td>
							<td>
							{if $smarty.now > $gamefasteye->expiretime}
								<span class="label label-important">{if $gamefasteye->expiretime > 0}{$gamefasteye->expiretime|date_format:$lang.default.dateFormatTimeSmarty}{/if}</span>
							{else}
								<span class="label label-info">{$gamefasteye->expiretime|date_format:$lang.default.dateFormatTimeSmarty}</span>
							{/if}
							</td>
							
							<td>
							{if $gamefasteye->status == 1}
								{if $smarty.now > $gamefasteye->starttime}
									{if $smarty.now > $gamefasteye->expiretime}
										<span class="label label-important">Kết thúc</span>
									{else}
										<span class="label label-success">Đang chơi</span>
									{/if}
								{elseif $smarty.now > $gamefasteye->expiretime}
									<span class="label label-important">Kết thúc</span>
								{else}
									<span class="label label-info">Chờ chơi</span>
								{/if}
							{else}
								<span class="label label-important">{$gamefasteye->getstatusName()}</span>
							
							{/if}
							</td>
							
							<td>{$gamefasteye->datecreated|date_format}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$gamefasteye->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$gamefasteye->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStarttime}: <input type="text" name="fstarttime" id="fstarttime" value="{$formData.fstarttime|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelExpiretime}: <input type="text" name="fexpiretime" id="fexpiretime" value="{$formData.fexpiretime|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: 
					<select name="fstatus" id="fstatus">
						<option value="0">- - - - -</option>
						{html_options options=$statusOptions selected=$formData.fstatus}
					</select>

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
		var path = rooturl + controllerGroup + "/gamefasteye/index";
		

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var starttime = $('#fstarttime').val();
		if(starttime.length > 0)
		{
			path += '/starttime/' + starttime;
		}

		var expiretime = $('#fexpiretime').val();
		if(expiretime.length > 0)
		{
			path += '/expiretime/' + expiretime;
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
			
			


