<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sản phẩm đoán giá</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_productguess"><h1>Sản phẩm đoán giá</h1></div>

<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/productquestion">Nhập câu hỏi</a> | <a href="{$conf.rooturl}{$controllerGroup}/productguessuser">Quản lý người chơi</a></div>



<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productguessEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="control-group">
		<label class="control-label" for="fpid">Product ID <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fname">Tên chương trình<span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-large"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="finfogift">Thông tin quà tặng<span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="finfogift" id="finfogift" value="{$formData.finfogift|@htmlspecialchars}" class="input-large"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="frule">Thể lệ<span class="star_require">*</span></label>
		<div class="controls"><textarea name="frule" id="frule" rows="7" class="input-xxlarge">{$formData.frule}</textarea></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fblockhtml">Html (Lời cảm ơn)<span class="star_require">*</span></label>
		<div class="controls"><textarea name="fblockhtml" id="fblockhtml" rows="7" class="input-xxlarge">{$formData.fblockhtml}</textarea></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fblocknews">Html (Góc báo chí)<span class="star_require">*</span></label>
		<div class="controls"><textarea name="fblocknews" id="fblocknews" rows="7" class="input-xxlarge">{$formData.fblocknews}</textarea></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fblockuser">Html (User chiến thắng)<span class="star_require">*</span></label>
		<div class="controls"><textarea name="fblockuser" id="fblockuser" rows="7" class="input-xxlarge">{$formData.fblockuser}</textarea></div>
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
				<option value="27">Trạng thái Đoán giá</option>
				<option value="6">Trạng thái ERP</option>
				<option value="2">Trạng thái đặt trước</option>
				<option value="0">Trạng thái hết hàng</option>
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
