<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Parking</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_parking"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.parkingBulkToken}" />
				<table class="table table-striped">
		
				{if $parkings|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelUid}</th>
							<th>{$lang.controller.labelPosition}</th>
							<th><a href="{$filterUrl}sortby/day/sorttype/{if $formData.sortby eq 'day'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDay}</a></th>
							<th><a href="{$filterUrl}sortby/month/sorttype/{if $formData.sortby eq 'month'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelMonth}</a></th>
							<th><a href="{$filterUrl}sortby/year/sorttype/{if $formData.sortby eq 'year'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelYear}</a></th>
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
					{foreach item=parking from=$parkings}
		                {if $me->id==$parking->uid && $parking->day=={'j'|date} && $parking->month=={'n'|date} && $parking->year=={'Y'|date}}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$parking->id}" {if in_array($parking->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;"><font size="4" color="#f00">{$parking->id}</font></td>
							
							<td><font size="4" color="#f00">{$parking->uid}</font></td>
							<td><font size="4" color="#f00">{$parking->position}</font></td>
							<td><font size="4" color="#f00">{$parking->day}</font></td>
							<td><font size="4" color="#f00">{$parking->month}</font></td>
							<td><font size="4" color="#f00">{$parking->year}</font></td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$parking->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$parking->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
						</tr>
			           {else}
                       <tr>
                            <td><input type="checkbox" name="fbulkid[]" value="{$parking->id}" {if in_array($parking->id, $formData.fbulkid)}checked="checked"{/if}/></td>
                            <td style="font-weight:bold;">{$parking->id}</td>
                            
                            <td>{$parking->uid}</td>
                            <td>{$parking->position}</td>
                            <td>{$parking->day}</td>
                            <td>{$parking->month}</td>
                            <td>{$parking->year}</td>
                            
                            <td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$parking->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
                                <a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$parking->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
                            </td>
                        </tr>
                       {/if}

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
				{$lang.controller.labelDay}: <input type="text" name="fday" id="fday" value="{$formData.fday|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelMonth}: <input type="text" name="fmonth" id="fmonth" value="{$formData.fmonth|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelYear}: <input type="text" name="fyear" id="fyear" value="{$formData.fyear|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="position" {if $formData.fsearchin eq "position"}selected="selected"{/if}>{$lang.controller.labelPosition}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/parking/index";
		

		var day = $('#fday').val();
		if(day.length > 0)
		{
			path += '/day/' + day;
		}

		var month = $('#fmonth').val();
		if(month.length > 0)
		{
			path += '/month/' + month;
		}

		var year = $('#fyear').val();
		if(year.length > 0)
		{
			path += '/year/' + year;
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
			
			


