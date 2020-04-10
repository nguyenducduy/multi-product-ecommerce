<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Jobcv</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_jobcv"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.jobcvEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fjid">{$lang.controller.labelJid} <span class="star_require">*</span></label>
		<div class="controls"><select name="fjid" id="fjid">
				{foreach item=job from=$joblist}
				<option {if $formData.fjid == $job->id}{/if} value="{$job->id}">{$job->title}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffile">{$lang.controller.labelFile}</label>
		<div class="controls">
			<input type="file" name="ffile" id="ffile">   &nbsp;
			<a title="{$formData.ftitle}" class="tipsy-trigger" href="{$conf.rooturl}uploads/jobcv/{$formData.ffile}" target="_blank">Xem file</a>			
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffirstname">{$lang.controller.labelFirstname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ffirstname" id="ffirstname" value="{$formData.ffirstname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flastname">{$lang.controller.labelLastname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="flastname" id="flastname" value="{$formData.flastname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fbirthday">{$lang.controller.labelBirthday} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fdate" style="width:67px;">
	        	<option value="0">---</option>
	            {section name=date start=1 loop=32 step=1}<option value="{$smarty.section.date.index}" {if $formData.fdate == $smarty.section.date.index}selected="selected"{/if}>{if $smarty.section.date.index < 10}0{/if}{$smarty.section.date.index}</option>{/section}
	        </select> &nbsp; / &nbsp;
	        <select name="fmonth" style="width:67px;">
	        	<option value="0">---</option>
	            {section name=month start=1 loop=13 step=1}<option value="{$smarty.section.month.index}" {if $formData.fmonth == $smarty.section.month.index}selected="selected"{/if}>{if $smarty.section.month.index < 10}0{/if}{$smarty.section.month.index}</option>{/section}
	        </select>&nbsp; / &nbsp;
	        <input type="text" name="fyear" value="{$formData.fyear}" style="width: 68px;" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fmoderatorid">{$lang.controller.labelModeratorid}</label>
		<div class="controls"><input readonly="readonly" type="text" name="" id="" value="{$formData.fmoderatorname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="finterview">{$lang.controller.labelDateInterview}</label>
		<div class="controls">
			<select name="fdateinterview" style="width:67px;">
	        	<option value="0">---</option>
	            {section name=date start=1 loop=32 step=1}<option value="{$smarty.section.date.index}" {if $formData.fdateinterview == $smarty.section.date.index}selected="selected"{/if}>{if $smarty.section.date.index < 10}0{/if}{$smarty.section.date.index}</option>{/section}
	        </select> &nbsp; / &nbsp;
	        <select name="fmonthinterview" style="width:67px;">
	        	<option value="0">---</option>
	            {section name=month start=1 loop=13 step=1}<option value="{$smarty.section.month.index}" {if $formData.fmonthinterview == $smarty.section.month.index}selected="selected"{/if}>{if $smarty.section.month.index < 10}0{/if}{$smarty.section.month.index}</option>{/section}
	        </select>&nbsp; / &nbsp;
	        <input type="text" name="fyearinterview" value="{$formData.fyearinterview}" style="width: 72px;" />
		</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

