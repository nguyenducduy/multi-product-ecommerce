{literal}
<style type="text/css">
	#dosbannedlist{background:#ffd8d8;padding:10px;border-radius:8px; -webkit-border-radius:8px; margin-bottom:20px;}
	#dosbannedlist h3{margin:0;padding:0;}
	#dosbannedlist ul{list-style-type:none;font-size:10px;margin:0;padding:0;}
	#dosbannedlist ul li{float:left; padding:3px 5px; border-radius:4px; -webkit-border-radius:4px; margin:5px 10px 5px 0; background:#ff8585;}
	#dosbannedlist ul li a{}
	.dosfontnormal{font-family: Arial, Tahoma, sans-serif;}
	.dosbannedip{text-decoration:line-through;}
	.doswarning_high td{background:#f00 !important; color:#fff !important;}
	.doswarning_medium td{background:#ff8585 !important;}
	.doswarning_low td{background:#ffd8d8 !important;}
</style>
{/literal}

<div class="page-header" rel="menu_slug"><h1>DoS Monitor</h1></div>

<div id="dosbannedlist">
	<h3>Banned IP</h3>
	
	{if $bannedIpList|@count > 0}
		<ul>
			{foreach item=ip from=$bannedIpList}
				<li>{$ip} <a href="{$conf.rooturl}{$controllerGroup}/{$controller}/dosmonitor?fsubmitbanipremove={$ip}" title="Un-ban this IP"><i class="icon-remove"></i></a></li>
			{/foreach}
		</ul>
		<div class="cl"></div>
	{else}
		<em><small>No IP Found.</small></em>
	{/if}
	
</div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">List of Access {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li>
		<li><a href="#tab2" data-toggle="tab">Search</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/dosmonitor">{$lang.default.formViewAll}</a></li>
		{/if}
		<li><a href="#tab3" data-toggle="tab">Ban an IP</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.slugBulkToken}" />
				<table class="table table-striped">
		
				{if $accessList|@count > 0}
					<thead>
						<tr>
							<th></th>
							<th width="150">IP Address</th>
							<th width="200">Timestamp</th>
							<th>User Agent</th>
							<th>Have Cookie?</th>
							<th>Num Request</th>
							<th>URI</th>
							<th>Referer</th>
							<th width="70"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
					
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody style="font-family:Courier New, mono-space;font-weight:bold;">
					{foreach item=access key=ipaddress from=$accessList}
						{if in_array($ipaddress, $bannedIpList)}
							{assign var=isbanned value=true}
						{else}
							{assign var=isbanned value=false}
						{/if}
						{foreach item=accessinfo key=timestamp from=$access|@array_reverse:true}
							{if $formData.fipaddress != '' || $accessinfo[0] > 3}
						<tr class="{if $accessinfo[0] >= 30}doswarning_high{elseif $accessinfo[0] >= 20}doswarning_medium{elseif $accessinfo[0] >= 10}doswarning_low{/if}">
							<td class="dosfontnormal">{if $isbanned}<a class="btn btn-mini btn-inverse" href="{$conf.rooturl}{$controllerGroup}/{$controller}/dosmonitor?fsubmitbanipremove={$ipaddress}">Un-ban</a>{else}<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/dosmonitor?fsubmitbanipadd={$ipaddress}" class="btn btn-mini btn-danger">Ban</a>{/if}</td>
							<td>({$access|@count})&nbsp;<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/dosmonitor/ipaddress/{$ipaddress}" {if $isbanned} class="dosbannedip"{/if}>{$ipaddress}</a></td>
							<td>{$timestamp|date_format:"%d/%b/%Y:%H:%M:%S"}</td>
							<td class="dosfontnormal" title="{$accessinfo[2]}">{if $accessinfo[2] != ''}<span class="label label-success">YES<span>{else}<span class="label label-warning">NO<span>{/if}</td>
							<td class="dosfontnormal">{if $accessinfo[1] == '1'}<span class="label label-success">YES<span>{else}<span class="label label-warning">NO<span>{/if}</td>
							<td class="dosfontnormal"><span class="badge badge-info">{$accessinfo[0]}</span></td>
							<td style="font-weight:normal;"><span class="label">{$accessinfo[3]}</span></td>
							<td style="font-weight:normal;"><small>{$accessinfo[4]}</small></td>
							<td></td>
						</tr>
							{/if}
			
						{/foreach}
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
				<table border="0" cellpadding="5">
					<tr>
						<td align="right">IP Address</td>
						<td align="left"><input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="" />
							<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
						</td>
					</tr>
				</table>
			</form>
		</div><!-- end #tab2 -->
		
		<div class="tab-pane" id="tab3">
			<form class="form-inline" action="" method="get" style="padding:0px;margin:0px;">
				<table border="0" cellpadding="5">
					<tr>
						<td align="right">IP Address</td>
						<td align="left"><input type="text" name="fsubmitbanipadd" id="fsubmitbanipadd" value="" class="" />
							<input value="Ban selected IP" class="btn btn-danger" type="submit" />
						</td>
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
		var path = rooturl + controllerGroup + "/system/dosmonitor";
		

		var ipaddress = $('#fipaddress').val();
		if(ipaddress.length > 0)
		{
			path += '/ipaddress/' + ipaddress;
		}

		document.location.href= path;
	}
</script>
{/literal}
			
			


