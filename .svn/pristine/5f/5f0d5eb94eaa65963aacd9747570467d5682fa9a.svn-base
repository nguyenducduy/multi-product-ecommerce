<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">Phân quyển danh mục sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Cập nhật phân quyền</li>
</ul>

<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_edit_role}</h1></div>
 <div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.roleuserEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelAccount}</label>
		<div class="controls"><span class="label label-info">{$user->fullname}</span><input type="hidden" name="fuid" value="{$formData.fuid}" /></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvid">{$lang.controller.labelVendor}</label>
		<div class="controls">
			<select name="fvid">
				<option value="0">-----------</option>
				{foreach item=vendor from=$vendorList}
				<option value="{$vendor->id}" {if $vendor->id == $formData.fvid}selected="selected"{/if}>{$vendor->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:356px;">{$lang.controller.labelProductCategory}</th>
				<th>{$lang.controller.labelGroup}</th>
				<th>{$lang.controller.labelView}<br /><input type="checkbox" id="checkedallview" /></th>
				<th>{$lang.controller.labelChange}<br /><input type="checkbox" id="checkedallchange" /></th>
				<th>{$lang.controller.labelSale}<br /><input type="checkbox" id="checkedallsale" /></th>
			</tr>
		</thead>
		<tbody>
			{foreach item=productcategory from=$productcategoryList}
			{assign var=id value=$productcategory->id}
			<tr>
				<td rowspan="2">
					{if $productcategory->parent|@count > 0}
					{foreach item=parent from=$productcategory->parent}
					<span class="label label-info">{$parent.pc_name}</span> &raquo;
					{/foreach}
					{/if}
					<span class="label label-info">{$productcategory->name}</span>
				</td>
				<td>{$lang.controller.labelProduct}</td>
				<td><input type="checkbox" class="view" {if $formData.fproduct.$id == 'view'}checked="checked"{/if} value="view" name="fproduct[{$productcategory->id}]" id="pv_{$productcategory->id}" onclick="clickfunc('pv_{$productcategory->id}' , 'pg_{$productcategory->id}')" /></td>
				<td><input class="change" type="checkbox" {if $formData.fproduct.$id == 'change'}checked="checked"{/if} value="change" name="fproduct[{$productcategory->id}]" id="pg_{$productcategory->id}" onclick="clickfunc('pg_{$productcategory->id}' , 'pv_{$productcategory->id}')"/></td>
				<td rowspan="2"><input type="checkbox" class ="fsale" {if isset($formData.fsale.$id) && $formData.fsale.$productcategory->id == 1}checked="checked"{/if} value="1" name="fsale[{$productcategory->id}]" /></td>
			</tr>
			<!-- <tr>
				<td>{$lang.controller.labelProductCategory}</td>
				<td><input type="checkbox" class="view" {if $formData.fproductcategory.$id == 'view'}checked="checked"{/if} value="view" name="fproductcategory[{$productcategory->id}]" id="cv_{$productcategory->id}" onclick="clickfunc('cv_{$productcategory->id}' , 'cg_{$productcategory->id}')" /></td>
				<td><input type="checkbox" class="change" {if $formData.fproductcategory.$id == 'change'}checked="checked"{/if} value="change" name="fproductcategory[{$productcategory->id}]" id="cg_{$productcategory->id}" onclick="clickfunc('cg_{$productcategory->id}' , 'cv_{$productcategory->id}')"/></td>
			</tr> -->
			<tr>
				<td>{$lang.controller.labelGroupAttribute}</td>
				<td><input type="checkbox" class="view" {if $formData.fattribute.$id == 'view'}checked="checked"{/if} value="view" name="fattribute[{$productcategory->id}]" id="av_{$productcategory->id}" onclick="clickfunc('av_{$productcategory->id}' , 'ag_{$productcategory->id}')" /></td>
				<td><input type="checkbox" class="change"  {if $formData.fattribute.$id == 'change'}checked="checked"{/if} value="change" name="fattribute[{$productcategory->id}]" id="ag_{$productcategory->id}" onclick="clickfunc('ag_{$productcategory->id}' , 'av_{$productcategory->id}')" /></td>
			</tr>
			{/foreach}
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

	$('.change').click(function(e){

        if(e.shiftKey) {
            if(!lastChecked) {
                lastChecked = this;
                return;
            }

            var start = $('.change').index(this);
            var end = $('.change').index(lastChecked);

            $('.change').slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);
            $('.view').slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', false);

        }

        lastChecked = this;
    });

     $('.view').click(function(e){

        if(e.shiftKey) {
            if(!lastChecked) {
                lastChecked = this;
                return;
            }

            var start = $('.view').index(this);
            var end = $('.view').index(lastChecked);

            $('.view').slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);
            $('.change').slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', false);

        }

        lastChecked = this;
    });

	$('#checkedallview').click(function(){
		if($(this).is(':checked'))
		{
			$(".view").each( function() {
				$(this).attr("checked",true);
			})

			$(".change").each( function() {
				$(this).attr("checked",false);
			})
		}
		else
		{
			$(".view").each( function() {
				$(this).attr("checked",false);
			})

		}
	});

	$('#checkedallchange').click(function(){
		if($(this).is(':checked'))
		{
			$(".change").each( function() {
				$(this).attr("checked",true);
			})

			$(".view").each( function() {
				$(this).attr("checked",false);
			})
		}
		else
		{
			$(".change").each( function() {
				$(this).attr("checked",false);
			})

		}
	});

	$('#checkedallsale').click(function(){
		if($(this).is(':checked'))
		{
			$(".fsale").each( function() {
				$(this).attr("checked",true);
			})
		}
		else
		{
			$(".fsale").each( function() {
				$(this).attr("checked",false);
			})

		}
	});
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

