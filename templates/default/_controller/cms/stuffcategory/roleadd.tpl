<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">Role of Stuffcategory</a> <span class="divider">/</span></li>
	<li class="active">Add Role</li>
</ul>

<div class="page-header" rel="menu_stuffcategory"><h1>{$lang.controller.head_add_role}</h1></div>
 <div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div> 

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.roleuserAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelAccount}</label>
		<div class="controls"><select name="fuid" id="fuid" class="autocompletestaff"></select></div>
	</div>

	{if $stuffcategoryList|@count > 0}
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:356px;">{$lang.controller.head_list}</th>
				<th>{$lang.controller.labelGroup}</th>
				<th>{$lang.controller.labelView}</th>
				<th>{$lang.controller.labelChange}</th>
			</tr>
		</thead>
		<tbody>
			{foreach item=stuffcategory from=$stuffcategoryList}
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
				<td><input type="checkbox" {foreach item=item key=scid from=$formData.fstuff}{if $stuffcategory->id == $scid && $item == 'view'}checked="checked"{/if}{/foreach} value="view" name="fstuff[{$stuffcategory->id}]" id="pv_{$stuffcategory->id}" onclick="clickfunc('pv_{$stuffcategory->id}' , 'pg_{$stuffcategory->id}')" /></td>

				<td><input type="checkbox" {foreach item=item key=scid from=$formData.fstuff}{if $stuffcategory->id == $scid && $item == 'change'}checked="checked"{/if}{/foreach} value="change" name="fstuff[{$stuffcategory->id}]" id="pg_{$stuffcategory->id}" onclick="clickfunc('pg_{$stuffcategory->id}' , 'pv_{$stuffcategory->id}')"/></td>
			</tr>
			<tr>
				<td>{$lang.controller.labelHaveStuffcategory}</td>
				<td><input type="checkbox" {foreach item=item key=scid from=$formData.fstuffcategory}{if $stuffcategory->id == $scid && $item == 'view'}checked="checked"{/if}{/foreach} value="view" name="fstuffcategory[{$stuffcategory->id}]" id="cv_{$stuffcategory->id}" onclick="clickfunc('cv_{$stuffcategory->id}' , 'cg_{$stuffcategory->id}')" /></td>
				<td><input type="checkbox" {foreach item=item key=scid from=$formData.fstuffcategory}{if $productcategory->id == $scid && $item == 'change'}checked="checked"{/if}{/foreach} value="change" name="fstuffcategory[{$stuffcategory->id}]" id="cg_{$stuffcategory->id}" onclick="clickfunc('cg_{$stuffcategory->id}' , 'cv_{$stuffcategory->id}')"/></td>
			</tr>
			<tr>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<br />
	{/if}

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select></div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
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