<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Export user</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productguess"><h1>Export user</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.exportuserAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}

	<div class="control-group">
		<label class="control-label" for="fpgid">Mã chương trình<span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="gfeid" id="gfeid" value="{$smarty.get.gfeid}" class="input-large"></div>
	</div>
	

<div class="control-group">
		<label class="control-label" for="fstarttime">Từ ngày<span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fstarttime" id="fstarttime" value="{$formData.fstarttime|@htmlspecialchars}" class="input-large inputdatepicker">

		</div>

	</div>
	
	<div class="control-group">
		<label class="control-label" for="fexpiretime">Đến ngày<span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fexpiretime" id="fexpiretime" value="{$formData.fexpiretime|@htmlspecialchars}" class="input-large inputdatepicker">
		</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="Export" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{literal}
  <script type="text/javascript">
            $('#fsttime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
             $('#fextime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
    </script>
{/literal}
