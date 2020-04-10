<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_segment}</li>
</ul>

<form action="" method="post" name="myform" class="form-horizontal">
	<input type="hidden" name="ftoken" value="{$smarty.session.productcategorySegmentToken}" />
    <div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_segment} - <span style="color:red"> Danh mục {$productcategory->name}{if $parentcategory->id > 0 && $parentcategory->pricesegment != ''}
            	kế thừa từ danh  {$parentcategory->name}
            	{/if}</span></h1></div>

    <div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>
        <input type="hidden" name="ftoken" value="{$smarty.session.productcategorySegmentToken}" />

        {include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
        <div id="filterList">
            <table class="table table-striped" id="segment">
            	<thead>
            		<tr>
            			<th>{$lang.controller.labelSegmentName}</th>
            			<th>{$lang.controller.labelSegmentFrom}</th>
            			<th>{$lang.controller.labelSegmentTo}</th>
            		</tr>
            	</thead>
            	<tbody>
				{if $productcategory->pricesegment|@count > 0}
					{foreach item=segment from=$productcategory->pricesegment}
					{if $segment.0 != ''}
					<tr>
						{foreach key=k item=seg from=$segment}
						{if $k == 1 || $k == 2}
						<td><input type="text" name="fsegment[]" value="{$seg}" {if $parentcategory->id > 0}readonly="readonly"{/if} />&nbsp;{$lang.controller.labelCurrency}</td>
						{else}
						<td><input type="text" name="fsegment[]" value="{$seg}" {if $parentcategory->id > 0}readonly="readonly"{/if} /></td>
						{/if}
						{/foreach}
					</tr>
					{/if}
					{/foreach}
				{/if}
				{if $parentcategory->id == 0 || $parentcategory->pricesegment == ''}
				<tr>
					<td><input type="text" name="fsegment[]" /></td>
					<td><input type="text" name="fsegment[]" />&nbsp;{$lang.controller.labelCurrency}</td>
					<td><input type="text" name="fsegment[]" />&nbsp;{$lang.controller.labelCurrency}</td>
				</tr>
				<tr>
					<td><input type="text" name="fsegment[]" /></td>
					<td><input type="text" name="fsegment[]" />&nbsp;{$lang.controller.labelCurrency}</td>
					<td><input type="text" name="fsegment[]" />&nbsp;{$lang.controller.labelCurrency}</td>
				</tr>
				<tr>
					<td><input type="text" name="fsegment[]" /></td>
					<td><input type="text" name="fsegment[]" />&nbsp;{$lang.controller.labelCurrency}</td>
					<td><input type="text" name="fsegment[]" />&nbsp;{$lang.controller.labelCurrency}</td>
				</tr>
				{/if}
				</tbody>
            </table>

            {if $parentcategory->id ==0 || $parentcategory->pricesegment == ''}
            <input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton" value="+" onclick="addRow('segment')" /><br/><br/><br/>
            {/if}

			 <div class="form-actions">
                {if $parentcategory->id ==0 || $parentcategory->pricesegment == ''}
                <input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
                {else}
                <a class="btn btn-primary" href="{$conf.rooturl_cms}{$controller}/pricesegment/id/{$productcategory->id}/redirect/{$redirectUrl}/act/add">{$lang.controller.labelPrivateSegment}</a>
                {/if}
            </div>
        </div>
</form>
{literal}
<script type="text/javascript" language="Javascript">
function addRow(tbname)
{

	var data = '<tr><td><input type="text" name="fsegment[]" /></td><td><input type="text" name="fsegment[]" />&nbsp;{/literal}{$lang.controller.labelCurrency}{literal}</td><td><input type="text" name="fsegment[]" />&nbsp;{/literal}{$lang.controller.labelCurrency}{literal}</td></tr>';
    $('#'+tbname).append(data);
}
</script>
{/literal}
