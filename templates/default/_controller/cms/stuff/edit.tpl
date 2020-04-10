<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Stuff</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_stuff"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.stuffEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
	<div class="control-group">
		<label class="control-label" for="fscid">{$lang.controller.labelScid} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fscid">
				<option value="">----------------------------</option>
				{foreach item=sc from=$stuffcategory}
				<option value="{$sc->id}"{if $sc->id == $formData.fscid}selected="selected"{/if}>{$sc->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fslug">{$lang.controller.labelSlug}</label>
		<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent}</label>
		<div class="controls">
			<textarea name="fcontent" id="fcontent" rows="20" class="input-xxlarge">{$formData.fcontent}</textarea>
			{include file="tinymce.tpl"}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fprice">{$lang.controller.labelPrice}</label>
		<div class="controls"><input type="text" name="fprice" id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-small"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontactname">{$lang.controller.labelContactname}</label>
		<div class="controls"><input type="text" name="fcontactname" id="fcontactname" value="{$formData.fcontactname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontactemail">{$lang.controller.labelContactemail}</label>
		<div class="controls"><input type="text" name="fcontactemail" id="fcontactemail" value="{$formData.fcontactemail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontactphone">{$lang.controller.labelContactphone}</label>
		<div class="controls"><input type="text" name="fcontactphone" id="fcontactphone" value="{$formData.fcontactphone|@htmlspecialchars}" class="input-small"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fregionid">{$lang.controller.labelRegionid}</label>
		<div class="controls">
			<select name="fregionid" id="fregionid">
				{foreach item=region from=$setting.region key="k"}
					<option value="{$k}"{if $k == $formData.fregionid}selected="selected"{/if}>{$region}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<!--
	<div class="control-group" id="districtArea">
		<label class="control-label" for="fdistrictid">{$lang.controller.labelDistrictid}</label>
		<div class="controls" id="districtList">
			<select name="fdistrictid" id="fdistrictid">
				<option value="">-- Select district --</option>
				{foreach item=district from=$selectedDistrict}
				<option value="{$district->id}"{if $district->id == $formData.fdistrictid}selected="selected"{/if}>{$district->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	-->
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
                {html_options options=$statusList selected=$formData.fstatus}
            </select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fimage"><img src="{$conf.rooturl}uploads/stuff/{$formData.fimage}" height="100px"/></label>
		<div class="controls"><input type="file" name="fimage" id="fimage"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#fregionid').change(function()
		{
			var id=$(this).val();
			var dataString = 'id='+ id;

			$.ajax
			({
				type: "POST",
				url: rooturl + 'cms/stuff/getDistrict',
				data: dataString,
				cache: false,
				success: function(html)
				{
					$('#districtArea').show();
					$('#districtList').html(html);
				} 
			});

		});

	});
</script>