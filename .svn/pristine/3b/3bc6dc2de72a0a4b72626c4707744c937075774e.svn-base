<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">Phân quyền danh mục sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Thêm phân quyền</li>
</ul>

<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_add_role}</h1></div>
 <div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.roleuserAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelAccount}</label>
		<div class="controls"><select name="fuid" id="fuid" class="autocompletestaff">

			</select></div>
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


	{if $productcategoryList|@count > 0}
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
				<td><input class="view" type="checkbox" {foreach item=item key=pcid from=$formData.fproduct}{if $productcategory->id == $pcid && $item == 'view'}checked="checked"{/if}{/foreach} value="view" name="fproduct[{$productcategory->id}]" id="pv_{$productcategory->id}" onclick="clickfunc('pv_{$productcategory->id}' , 'pg_{$productcategory->id}')" /></td>
				<td><input class="change" type="checkbox" {foreach item=item key=pcid from=$formData.fproduct}{if $productcategory->id == $pcid && $item == 'change'}checked="checked"{/if}{/foreach} value="change" name="fproduct[{$productcategory->id}]" id="pg_{$productcategory->id}" onclick="clickfunc('pg_{$productcategory->id}' , 'pv_{$productcategory->id}')"/></td>

				<td rowspan="2"><input class ="fsale" type="checkbox" {foreach item=item key=pcid from=$formData.fsale}{if $productcategory->id == $pcid && $item == 1}checked="checked"{/if}{/foreach} value="1" name="fsale[{$productcategory->id}]" /></td>
			</tr>
			<!-- <tr>
				<td>{$lang.controller.labelProductCategory}</td>
				<td><input class="view" type="checkbox" {foreach item=item key=pcid from=$formData.fproductcategory}{if $productcategory->id == $pcid && $item == 'view'}checked="checked"{/if}{/foreach} value="view" name="fproductcategory[{$productcategory->id}]" id="cv_{$productcategory->id}" onclick="clickfunc('cv_{$productcategory->id}' , 'cg_{$productcategory->id}')" /></td>
				<td><input class="change" type="checkbox" {foreach item=item key=pcid from=$formData.fproductcategory}{if $productcategory->id == $pcid && $item == 'change'}checked="checked"{/if}{/foreach} value="change" name="fproductcategory[{$productcategory->id}]" id="cg_{$productcategory->id}" onclick="clickfunc('cg_{$productcategory->id}' , 'cv_{$productcategory->id}')"/></td>
			</tr> -->
			<tr>
				<td>{$lang.controller.labelGroupAttribute}</td>
				<td><input class="view" type="checkbox" {foreach item=item key=pcid from=$formData.fattribute}{if $productcategory->id == $pcid && $item == 'view'}checked="checked"{/if}{/foreach} value="view" name="fattribute[{$productcategory->id}]" id="av_{$productcategory->id}" onclick="clickfunc('av_{$productcategory->id}' , 'ag_{$productcategory->id}')" /></td>
				<td><input class="change" type="checkbox" {foreach item=item key=pcid from=$formData.fattribute}{if $productcategory->id == $pcid && $item == 'change'}checked="checked"{/if}{/foreach} value="change" name="fattribute[{$productcategory->id}]" id="ag_{$productcategory->id}" onclick="clickfunc('ag_{$productcategory->id}' , 'av_{$productcategory->id}')" /></td>
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

