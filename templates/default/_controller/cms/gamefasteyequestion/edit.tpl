<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">GamefasteyeQuestion</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_gamefasteyequestion"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.gamefasteyequestionEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpgid">Chương trình</label>
		<div class="controls">
			<select id="fgfeid" name="fgfeid">
				<option value="0">- - - - - - - - - - - - - - - - - - -</option>
				{foreach item=item from=$gamefasteye}
					<option value="{$item->id}" title="{$item->name}" {if $item->id == $formData.fgfeid}selected="selected"{/if}>{$item->name}</option>
				{/foreach}
			</select>
		</div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fname"><span class="star_require"></span></label>
		<div class="controls"><img width="100" height="100" alt="" src="{$formData.fimage|@htmlspecialchars}""></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fimage">{$lang.controller.labelImage} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fimage" id="fimage" value="{$formData.fimage|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	{foreach item=answer name=itemList from=$formData.fanswer}
	<div class="control-group">
		<label class="control-label" for="fanswer">Câu trả lời {$smarty.foreach.itemList.iteration}<span class="star_require">*</span></label>
		<div class="controls"><input style="float:left" type="text" name="fanswer[]" id="fanswer" value="{$answer}" class="input-xlarge">
		<label class="checkbox" style="float: left; margin-top: 5px;">
                <input style="margin-top: -2px;" type="radio" name="fcorrect" id="fcorrect" value="{$smarty.foreach.itemList.iteration}" {if $smarty.foreach.itemList.iteration == $formData.fcorrect}checked="checked" {/if} /> Câu trả lời đúng
            </label>
		</div>
		
	</div>
	{/foreach}

	<div class="control-group">
		<label class="control-label" for="fpoint">{$lang.controller.labelPoint} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select class="" name="fstatus" id="fstatus">{html_options options=$statusOptions selected=$formData.fstatus}</select></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

