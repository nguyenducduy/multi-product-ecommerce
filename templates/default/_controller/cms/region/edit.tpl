<div class="page-header" rel="menu_region"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.regionEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">Name</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

    <div class="control-group">
        <label class="control-label" for="fslug">{$lang.controller.labelSlug}</label>
        <div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge">
            {if $slugList|@count > 0}
                <div class="red">Found item for slug "{$formData.fslug}":</div>
                {foreach item=slug from=$slugList}
                    <div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>
                {/foreach}
            {/if}
        </div>
    </div>

	<div class="control-group">
		<label class="control-label" for="fname">Lat</label>
		<div class="controls"><input type="text" name="flat" id="flat" value="{$formData.flat|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fname">Lng</label>
		<div class="controls"><input type="text" name="flng" id="flng" value="{$formData.flng|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group hide">
		<label class="control-label" for="fdisplayorder">Display Order</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fparentid">Parent</label>
		<div class="controls">
			<select name="fparentid" id="fparentid">
				<option value="0">- - This is parent region - -</option>
				{foreach item=region from=$regionList}
					{if $region->id != $formData.fid}
						<option value="{$region->id}" {if $region->id == $formData.fparentid}selected="selected"{/if}>{$region->name}</option>
					{/if}
				{/foreach}
			</select>
	</div>
	
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

