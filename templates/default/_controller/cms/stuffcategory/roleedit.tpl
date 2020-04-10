<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">Role of Stuffcategory</a> <span class="divider">/</span></li>
	<li class="active">Edit Role</li>
</ul>
f
<div class="page-header" rel="menu_stufcategory"><h1>{$lang.controller.head_edit_role}</h1></div>
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
				<th style="width:356px;">{$lang.controller.labelHaveStuffcategory}</th>
				<th>{$lang.controller.labelGroup}</th>
				<th>{$lang.controller.labelView}</th>
				<th>{$lang.controller.labelChange}</th>
			</tr>
		</thead>
		<tbody>			
			<tr>
				<td rowspan="3">
					{if $stuffcategory->parent|@count > 0}
					{foreach item=parent from=$stuffcategory->parent}
					<b>{$parent.sc_name}</b> &raquo;
					{/foreach}
					{/if}
					<span class="label label-info">{$stuffcategory->name}</span>
				</td>
				<td>{$lang.controller.labelHaveStuff}</td>
				<td><input type="checkbox" {if $formData.fstuff == 'view'}checked="checked"{/if} value="view" name="fstuff" id="pv_{$stuffcategory->id}" onclick="clickfunc('pv_{$stuffcategory->id}' , 'pg_{$stuffcategory->id}')" /></td>
				<td><input type="checkbox" {if $formData.fstuff == 'change'}checked="checked"{/if} value="change" name="fstuff" id="pg_{$stuffcategory->id}" onclick="clickfunc('pg_{$stuffcategory->id}' , 'pv_{$stuffcategory->id}')"/></td>
			</tr>
			<tr>
				<td>{$lang.controller.labelHaveStuffcategory}</td>
				<td><input type="checkbox" {if $formData.fstuffcategory == 'view'}checked="checked"{/if} value="view" name="fstuffcategory" id="cv_{$stuffcategory->id}" onclick="clickfunc('cv_{$stuffcategory->id}' , 'cg_{$stuffcategory->id}')" /></td>
				<td><input type="checkbox" {if $formData.fstuffcategory == 'change'}checked="checked"{/if} value="change" name="fstuffcategory" id="cg_{$stuffcategory->id}" onclick="clickfunc('cg_{$stuffcategory->id}' , 'cv_{$stuffcategory->id}')"/></td>
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