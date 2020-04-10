<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">RelRegionPricearea</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_relregionpricearea"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.relregionpriceareaEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="control-group">
        <label class="control-label" for="fppaid">Khu vực <span class="star_require">*</span></label>
        <div class="controls">
            <select name="faid" id="faid" class="input">
                <option value="">--Chọn khu vực--</option>
                {foreach from=$formData.listarea item=area}                    
                    <option value="{$area->id}"{if $formData.faid==$area->id} selected="selected"{/if}>{$area->name}</option>
                {/foreach}
            </select>
        </div>
    </div>

	<div class="control-group">
		<label class="control-label" for="fppaid">{$lang.controller.labelPpaid} <span class="star_require">*</span></label>
		<div class="controls">
            <select name="fppaid" id="fppaid" class="input">
                <option value="">--Chọn khu vực giá--</option>
                {foreach from=$formData.listpricearea item=pricearea}                    
                    <option value="{$pricearea->id}"{if $formData.fppaid==$pricearea->id} selected="selected"{/if}>{$pricearea->name}</option>
                {/foreach}
            </select>
        </div>
	</div>

	<div class="control-group">
		<label class="control-label" for="frid">{$lang.controller.labelRid} <span class="star_require">*</span></label>
		<div class="controls">
            <select name="frid" id="frid" class="input">
                <option value="">--Chọn tỉnh--</option>
                {foreach from=$formData.listregion item=region}                    
                    <option value="{$region->id}"{if $formData.frid==$region->id} selected="selected"{/if}>{$region->name}</option>
                {/foreach}
            </select>
        </div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

