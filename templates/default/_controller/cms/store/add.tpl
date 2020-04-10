<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Siêu thị</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_store"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.storeAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
              

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
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
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="faddress">{$lang.controller.labelAddress} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="faddress" id="faddress" value="{$formData.faddress|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fregion">{$lang.controller.labelRegion} <span class="star_require">*</span></label>
		<div class="controls">
            <select name="fregion" id="fregion">
                {foreach item=region from=$regions}
                    <option value="{$region->id}"{if $region->id == $formData.fregion}selected="selected"{/if}>{$region->name}</option>
                {/foreach}
            </select>
        </div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffax">{$lang.controller.labelFax}</label>
		<div class="controls"><input type="text" name="ffax" id="ffax" value="{$formData.ffax|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flat">{$lang.controller.labelLat}</label>
		<div class="controls"><input type="text" name="flat" id="flat" value="{$formData.flat|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flng">{$lang.controller.labelLng}</label>
		<div class="controls"><input type="text" name="flng" id="flng" value="{$formData.flng|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group hide">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus} <span class="star_require">*</span></label>
		<div class="controls">
            <select name="fstatus" id="fstatus">
                {html_options options=$statusList selected=$formData.fstatus}
            </select>
        </div>
	</div>
    
    <div class="control-group">
        <label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
        <div class="controls"><input type="file" name="fimage" id="fimage" ></div>
    </div>
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


