<form action="" method="get">
	<div style="display:block;">
		<table style="display:inline;">
			<tr>
				<th style="background-color:blue;color:white;width:100%;">Vendor</th>
			</tr>
			{if $vendorList|@count > 0}
			{foreach item=vendor from=$vendorList}
			<tr {if $formData.fvid > 0}{if $formData.fvid != $vendor->id}style="display:none;"{/if}{/if}>
				<td><a href="{if $formData.fvid == $vendor->id}{$conf.rooturl}{$controllerGroup}/{$controller}/search/pcid/{$formData.fpcid}{else}{$conf.rooturl}{$controllerGroup}/{$controller}/search/pcid/{$formData.fpcid}/vid/{$vendor->id}{/if}{if $queryString != ''}?{$queryString}{/if}"><input type="checkbox" id="fvendor_{$vendor->id}" value="{$vendor->id}" {if $formData.fvid == $vendor->id}checked="checked"{/if} />{$vendor->name}</a></td>
			</tr>
			{/foreach}
			{/if}
		</table>
		<table style="display:inline;">
			<th style="background-color:blue;color:white;width:100%;">Attribute</th>
			{if $attributeList|@count > 0}
			{foreach item=attribute from=$attributeList}
			<tr>
				<td>{$attribute->paname}
					{if $attribute->value|@count > 0}
                    <select name="fattribute[{$attribute->paid}]">
                    	<option value=""></option>
                    	{foreach item=attrvalue from=$attribute->value}
                        <option value="{$attrvalue}" {if $formData.fattribute|@count >0}{if in_array($attrvalue , $formData.fattribute)}selected="selected"{/if}{/if}>{$attrvalue}</option>
                        {/foreach}
                    </select>
                    {/if}
				</td>
			</tr>
			{/foreach}
			{/if}
		</table>
		<input type="submit" name="fsubmit" value="Search" />
	</div>
</form>
<div style="display:block;">
	<table>
		<tr>
			<th style="background-color:blue;color:white;width:100%;">Product</th>
		</tr>
		{if $productList|@count > 0}
		{foreach item=product from=$productList}
		<tr>
			<td><a target="_blank" href="{$conf.rooturl}{$groupControler}/{$controller}/detail/pid/{$product->id}">{$product->name}</a></td>
			<td>{$product->sellprice}</td>
		</tr>
		{/foreach}
		{/if}
	</table>
	<div class="pagination">
		{assign var="pageurl" value="&page=::PAGE::"}
		{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
	</div> <!-- End .pagination -->
</div>