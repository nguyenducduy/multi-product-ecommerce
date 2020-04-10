<div class="page-header"><h1>{$lang.controller.head_employeelist} :: {$myDepartment->fullname} ({$useredgeList|@count})</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.securityToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<table class="table table-striped" cellpadding="5" width="100%">
		
	{if $useredgeList|@count > 0}
		<thead>
			<tr>
				<th align="left" width="100">Account ID</th>	
				<th align="left">Full Name</th>	
				<th align="left">Email</th>		
				<th align="left">Phone</th>	
				<th align="center">Position</th>	
				<th width="100">Registered</th>			
				<th width="100"></th>
			</tr>
		</thead>
		
		<tbody>
	{foreach item=useredge from=$useredgeList}
		{assign var=user value=$useredge->actor}
		
			<tr>
				<td style="font-weight:bold;"><span class="label label-success">{$user->getCode()}</a></td>
				<td>{$user->fullname}</td>
				<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}user/edit/id/{$user->id}/redirect/{$redirectUrl}">{$user->email}</a></td>
				<td>{$user->phone}</td>
				<td><span class="label label-inverse">{$useredge->jobtitle->name}</span></td>
				
				<td title="{$user->ipaddress}">{$user->datecreated|date_format}</td>
				<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_erp}hrmdepartment/employeeedit/id/{$useredge->id}" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
					<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_erp}hrmdepartment/employeeremove/id/{$useredge->id}?ftoken={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
