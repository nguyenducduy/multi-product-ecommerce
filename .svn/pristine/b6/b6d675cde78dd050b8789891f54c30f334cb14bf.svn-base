<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">CampaignAutumn</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_campaignautumn"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.campaignautumnAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName}</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flistproduct">{$lang.controller.labelListproduct}</label>
		<div class="controls">
		<input type="text" name="flistproduct" id="flistproduct" value="{$formData.flistproduct}" class="input-xlarge"></div>
	</div>

<div class="control-group">
        <label class="control-label" for="fstarttime">Ngày bắt đầu</label>
        <div class="controls"><input class='inputdatepicker' type="text" name="fstarttime" id="fstarttime" value="{if $formData.fstarttime > 0}{$formData.fstarttime|date_format:"%d/%m/%Y"}{/if}" ></div>
    </div>

		<div class="control-group">
        <label class="control-label" for="fvid">Status</label>
        <div class="controls">
            <select name="fstatus">
                <option value="1" {if $formData.fstatus == 1 && isset($formData.fstatus)}selected='selected'{/if}}>Enable</option>
                <option value="0" {if $formData.fstatus == 0 && isset($formData.fstatus)}selected='selected'{/if}}>Disable</option>              
            </select>
        </div>
    </div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


