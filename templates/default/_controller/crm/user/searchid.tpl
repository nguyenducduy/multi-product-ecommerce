<div class="page-header"><h1>Search User ID</h1></div>



<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}user/searchid?elementid={$smarty.get.elementid}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">
					
				{if $users|@count > 0}
					<thead>
						<tr>
							<th align="left" width="30">ID</th>	
							<th align="left">Email</th>		
                            <th align="left">Screen Name</th>				
							<th align="center">Group</th>
							<th align="left">Full Name</th>	
							<th width="100">Registered</th>
							<th width="70"></th>
						</tr>
					</thead>
					
					
					<tbody>
				{foreach item=user from=$users}
					
						<tr>
							
							<td style="font-weight:bold;"><a href="javascript:void(0)" onclick="insertuserid({$user->id}, '{$smarty.get.elementid}')" title="Click to select this ID">{$user->id}</a></td>
							<td>{$user->email}</td>
                            <td><a target="_blank" title="Go to this user's home" href="{$conf.rooturl}{$user->screenname}" target="_blank">{$user->screenname}</a></td>
							<td align="center">{$user->groupname($user->groupid)}</td>
							<td><a href="javascript:void(0)" onclick="insertuserid({$user->id}, '{$smarty.get.elementid}')" title="Click to select this ID">{$user->fullname}</a></td>
							<td>{$user->datecreated|date_format}</td>
							<td><a href="javascript:void(0)" onclick="insertuserid({$user->id}, '{$smarty.get.elementid}')"><span class="btn btn-success">Insert</span></a></td>
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
	
				
				ID: 
				<input type="text" name="fid" id="fid" size="8" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 
				{$lang.controller.formKeywordLabel}:
				
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				
				<select name="fsearchin" id="fsearchin">
					<option value="">- - - - - - - - - - - - -</option>
					<option value="email" {if $formData.fsearchin eq 'email'}selected="selected"{/if}>{$lang.controller.formKeywordInEmailLabel}</option>
					<option value="screenname" {if $formData.fsearchin eq 'screenname'}selected="selected"{/if}>{$lang.controller.formKeywordInScreennameLabel}</option>
					<option value="fullname" {if $formData.fsearchin eq 'fullname'}selected="selected"{/if}>{$lang.controller.formKeywordInFullnameLabel}</option>
				</select>
				
				<select name="fgroupid" id="fgroupid">
					<option value="">- - in Group - -</option>
					{html_options options=$userGroups selected=$formData.fgroupid}
				</select>
				
				<input type="button" name="fsubmit" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch('{$smarty.get.elementid}');"  />
				
				
				
				
				
				
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>









{literal}
<script type="text/javascript">
	function insertuserid(userid, elementid)
	{
		var element = window.opener.$("#" + elementid);
		var currentvalue = jQuery.trim(element.val());
		
		
		var newvalue = currentvalue;
		if(currentvalue.length > 0)
			newvalue += ',' + userid;
		else
			newvalue = userid;
		
		element.val(newvalue);
		
		window.close();
	}
	
	function gosearch(elementid)
	{
		var path = rooturl_admin + "user/searchid";
		
		var id = $("#fid").val();
		if(parseInt(id) > 0)
		{
			path += "/id/" + id;
		}
		
		var groupid = $("#fgroupid").val();
		if(parseInt(groupid) > 0)
		{
			path += "/groupid/" + groupid;
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
		
		//add elementid
		path += '?elementid=' + elementid;
		
				
		document.location.href= path;
	}
</script>
{/literal}






