<table class="table">	
	{foreach item=attributes key=groupattr from=$productAttributeList}
		{assign var="checker" value="true"}
		{if $attributes|@count > 0}
		{foreach item=attr from=$attributes}
		<tr>
			{if $checker == "true"}
			<td><b>{$groupattr}</b></td>
			{assign var="checker" value="false"}
			{else}
			<td></td>
			{/if}
			<td>{$attr->name}</td>
			{assign var=attrid value=$attr->id}
			<td>{if $attr->values|@count > 0}
				<select id="valuechoose{$attr->id}" name="fattr[{$attr->id}]" onchange="changevalueattr({$attr->id})" class="valuechoose" style="width: 200px;">
					<option value="-1" placeholder="Hoặc nhập giá trị khác">Giá trị khác</option>
					{foreach item=valuedata from=$attr->values}
					<option {if $attr->value == $valuedata}selected="selected"{/if} value="{$valuedata}">{$valuedata}</option>
					{/foreach}
				</select>
				{/if}<input id="valueoption{$attr->id}" type="text" name="fattropt[{$attr->id}]" placeholder="Hoặc nhập giá trị khác" value="{$formData.fattropt.$attrid}">&nbsp;&nbsp;{$attr->unit}</td>
			<td><input type="text" name="fweight[{$attr->id}]" placeholder="Trọng số" class="input-mini" value="{$formData.fweight.$attrid}"/></td>
			<td><input type="text" name="fattrdescription[{$attr->id}]" placeholder="Mô tả" class="input-medium" value="{$formData.fattrdescription.$attrid}"/></td>
			<td style="width:50px;"></td>
		<tr/>
		{/foreach}
		{else}
		<tr>
			<td><b>{$groupattr}</b></td>
			<td></td>
			<td></td>
			<td style="width:100px;"></td>
		<tr/>
		{/if}
	{/foreach}
</table>
<input type="hidden" name="fattributeloadajaxsuccess" value="1" />
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$('.valuechoose').select2();
	});
</script>
{/literal}