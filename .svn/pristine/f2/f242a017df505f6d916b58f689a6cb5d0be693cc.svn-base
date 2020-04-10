
<div class="page-header" rel="menu_apidocrequest"><h1>{$lang.controller.head_add}</h1></div>


<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.apidocrequestAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	
	<div class="control-group">
		<label class="control-label" for="fagid">Group</label>
		<div class="controls">
			<select name="fagid">
				{foreach item=apidocgroup from=$groupList}
					<option value="{$apidocgroup->id}" {if $formData.fagid == $apidocgroup->id}selected="selected"{/if}>{$apidocgroup->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	
	<div class="control-group">
		<label class="control-label" for="furl">{$lang.controller.labelUrl}</label>
		<div class="controls">
			<select name="fhttpmethod" class="input-small">
				{html_options options=$methodList selected=$formData.fhttpmethod}
			</select>
		
			<input type="text" name="furl" id="furl" placeholder="{literal}{BASE_URL}{/literal}/path/to/feature/" value="{if $formData.furl != ''}{$formData.furl}{else}{literal}{BASE_URL}/{/literal}{/if}" class="input-xxlarge"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName}</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary}</label>
		<div class="controls"><textarea name="fsummary" id="fsummary" rows="3" class="input-xxlarge">{$formData.fsummary}</textarea></div>
	</div>
	
	

	<div class="control-group">
		<label class="control-label" for="fimplementnote">{$lang.controller.labelImplementnote}</label>
		<div class="controls"><textarea name="fimplementnote" id="fimplementnote" rows="3" class="input-xxlarge">{$formData.fimplementnote}</textarea></div>
	</div>


	<div class="control-group hide">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>
	
	
	<div class="control-group" style="background:#bbd9ff;padding:10px 0;">
		<label class="control-label" for=""><strong>Parameters</strong> <br /><a href="javascript:void(0)" onclick="$('#parameterlist tbody').append($('#parameterlist tbody tr:last').clone())" class="btn"><i class="icon-plus"></i></a></label>
		<div class="controls">
			<div id="parameterlist">
				<table>
					<thead>
						<tr>
							<td><em>Type</em></td>
							<td><em>Name</em></td>
							<td><em>Data Type</em></td>
							<td><em>Description</em></td>
							<td><em>Required?</em></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						{section name="paramcount" loop=5}
						<tr>
							<td><select name="fparamtype[]" class="input-small">{html_options options=$paramtypeList}</select></td>
							<td><input type="text" name="fparamname[]" value="" /></td>
							<td><select name="fparamdatatype[]" class="input-small">{html_options options=$datatypeList}</select></td>
							<td><input type="text" name="fparamdescription[]" class="input-xlarge" value="" /></td>
							<td><select name="fparamisrequired[]" class="input-mini"><option value="0">NO</option><option value="1">YES</option></select></td>
							<td><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();" class=""><i class="icon-remove"></i> Remove</a></td>
						</tr>
						{/section}
					</tbody>
				</table>
			</div><!-- end #parameterlist -->
		</div>
	</div>
	
	
	
	<div class="control-group" style="background:#ffeec8;padding:10px 0;">
		<label class="control-label" for=""><strong>Response</strong> <br /><a href="javascript:void(0)" onclick="$('#responselist tbody').append($('#responselist tbody tr:last').clone())" class="btn"><i class="icon-plus"></i></a></label>
		<div class="controls">
			<div id="responselist">
				<table>
					<thead>
						<tr>
							<td><em>Content Type</em></td>
							<td><em>Output</em></td>
							<td><em>Sample</em></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td valign="top"><select name="fresponsetype[]" class="input-small">{html_options options=$contenttypeList}</select></td>
							<td><textarea name="fresponseoutput[]" class="input-xlarge" rows="7" style="font-size:smaller;width:400px;"></textarea></td>
							<td><textarea name="fresponsesample[]" class="input-xlarge" rows="7" style="font-size:smaller;width:400px;"></textarea></td>
							<td valign="top"><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();" class=""><i class="icon-remove"></i> Remove</a></td>
						</tr>
					</tbody>
				</table>
			</div><!-- end #responselist -->
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


