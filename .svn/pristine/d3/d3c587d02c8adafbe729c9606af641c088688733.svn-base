<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Crazydeal</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_crazydeal"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.crazydealEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	
	<div class="control-group">
		<label class="control-label" for="fimage">{$lang.controller.labelImage} <span class="star_require">*</span></label>
		<div class="controls">
			<input type="file" name="fimage" id="fimage" class="input-xlarge"><br/>
			{if $formData.fimage != ""}
			<img src = "{$formData.fimage}" width="200px" />
		{/if}
		</div>
		
	</div>

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstarttime">{$lang.controller.labelStarttime} <span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" value="{$formData.fsttime}" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fstarttime" id="fstarttime" value="{$formData.fstarttime|@htmlspecialchars}" class="input-large inputdatepicker">

		</div>

	</div>
	
	<div class="control-group">
		<label class="control-label" for="fexpiretime">{$lang.controller.labelExpiretime} <span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" value="{$formData.fextime}" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fexpiretime" id="fexpiretime" value="{$formData.fexpiretime|@htmlspecialchars}" class="input-large inputdatepicker">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fonsitestatus">Trạng thái Sản phẩm</label>
		<div class="controls">
			<select name="fonsitestatus" id="fonsitestatus">
				<option value="26">Trạng tháiCrazydeal</option>
				<option value="0">Trạng thái ban đầu của sản phẩm</option>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{literal}
  <script type="text/javascript">
            $('#fsttime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
             $('#fextime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
    </script>
{/literal}