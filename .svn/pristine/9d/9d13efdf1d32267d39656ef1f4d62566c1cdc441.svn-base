<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">Role of Newscategory</a> <span class="divider">/</span></li>
	<li class="active">Edit Role</li>
</ul>

<div class="page-header" rel="menu_newscategory"><h1>{$lang.controller.head_edit_role}</h1></div>
 <div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div> 

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.roleuserEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelAccount}</label>
		<div class="controls"><span class="label label-success">{$user->fullname}</span></div>
	</div>
	
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:356px;">{$lang.controller.labelName}</th>
				<th>{$lang.controller.labelGroup}</th>
				<th>{$lang.controller.labelView}</th>
				<th>{$lang.controller.labelChange}</th>
			</tr>
		</thead>
		<tbody>			
			<tr>
				<td rowspan="3">
					{if $newscategory->parent|@count > 0}
					{foreach item=parent from=$newscategory->parent}
					<b>{$parent.nc_name}</b> &raquo;
					{/foreach}
					{/if}
					<span class="label label-info">{$newscategory->name}</span>
				</td>
				<td>{$lang.controller.labelHaveNews}</td>
				<td><input type="checkbox" {if $formData.fnews == 'view'}checked="checked"{/if} value="view" name="fnews" id="pv_{$newscategory->id}" onclick="clickfunc('pv_{$newscategory->id}' , 'pg_{$newscategory->id}')" /></td>
				<td><input type="checkbox" {if $formData.fnews == 'change'}checked="checked"{/if} value="change" name="fnews" id="pg_{$newscategory->id}" onclick="clickfunc('pg_{$newscategory->id}' , 'pv_{$newscategory->id}')"/></td>
				
			</tr>
			<tr>
				<td>{$lang.controller.labelHaveNewscategory}</td>
				<td><input type="checkbox" {if $formData.fnewscategory == 'view'}checked="checked"{/if} value="view" name="fnewscategory" id="cv_{$newscategory->id}" onclick="clickfunc('cv_{$newscategory->id}' , 'cg_{$newscategory->id}')" /></td>
				<td><input type="checkbox" {if $formData.fnewscategory == 'change'}checked="checked"{/if} value="change" name="fnewscategory" id="cg_{$newscategory->id}" onclick="clickfunc('cg_{$newscategory->id}' , 'cv_{$newscategory->id}')"/></td>
			</tr>
			<tr>

			</tr>			
		</tbody>
	</table>
	<br />	

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select></div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />	
	</div>

</form>
{literal}
<script type="text/javascript">
$(document).ready(function() {
	$('.holder').css('width' , '250px');
	$('.default').css('width' , '250px');
	$('.facebook-auto').css('width' , '265px');
});

function clickfunc(selector1 , selector2)
{
	if($("#"+selector1).is(':checked'))
	{
		$("#"+selector2).attr('checked', false);
	}
}
</script>
{/literal}