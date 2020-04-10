<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Câu hỏi cho chương trình đoán giá</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_productquestion"><h1>Câu hỏi cho chương trình đoán giá</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productquestionEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

		<div class="control-group">
		<label class="control-label" for="fpgid">Chương trình đoán giá</label>
		<div class="controls">
			<select id="fpgid" name="fpgid">
				<option value="0">- - - - - - - - - - - - - - - - - - -</option>
				{foreach item=productitem from=$productguess}
					<option value="{$productitem->id}" title="{$productitem->name}" {if $productitem->id == $formData.fpgid}selected="selected"{/if}>{$productitem->name}</option>
				{/foreach}
			</select>
		</div>
	</div>	
	
	<div class="control-group">
		<label class="control-label" for="fpgid">Kiểu câu hỏi</label>
		<div class="controls">
			<label class="checkbox" style="float: left;">
                <input style="margin-top: -2px;" type="radio" name="ftype" id="ftype" value="0" {if $formData.ftype == 0} checked="checked" {/if}/> Radio
            </label>
            <label class="checkbox" style="float: left;margin-top: 5px;">
                <input style="margin-top: -2px;" type="radio" name="ftype" id="ftype" value="1" {if $formData.ftype == 1} checked="checked" {/if}/> Text
            </label>
		</div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="fname">Câu hỏi<span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge">
		</div>
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
		<label class="control-label" for="fstarttime">Thời gian bắt đầu<span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" value="{$formData.fsttime}" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fstarttime" id="fstarttime" value="{$formData.fstarttime|@htmlspecialchars}" class="input-large inputdatepicker">

		</div>

	</div>
	
	<div class="control-group">
		<label class="control-label" for="fexpiretime">Thời gian kết thúc<span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" value="{$formData.fextime}" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fexpiretime" id="fexpiretime" value="{$formData.fexpiretime|@htmlspecialchars}" class="input-large inputdatepicker">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
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
