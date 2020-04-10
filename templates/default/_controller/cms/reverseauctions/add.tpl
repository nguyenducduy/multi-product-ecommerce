{include file="tinymce.tpl"}
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ReverseAuctions</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_reverseauctions"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.reverseauctionsAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fproductname">{$lang.controller.labelProductname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fproductname" id="fproductname" value="{$formData.fproductname|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group" id="imageappend">
		<label class="control-label" for="fimage">{$lang.controller.labelImage} <span class="star_require">*</span></label>
		{if $formData.fimage|count > 0}
			{foreach from=$formData.fimage item=image name="images"}
				{if $smarty.foreach.images.iteration == 1}
					<div class="controls"><input type="text" name="fimage[]" id="fimage" value="{$image}" class="input-xxlarge" style="float:left">
					<div style="float:left; background:#00a1e6;padding:5px 10px;border-radius:3px;color:#fff;margin-left:5px; font-size:18px;cursor:pointer" id="addrecodeimage">+</div>
					</div>
				{else}
					<div class="controls"><input type="text" name="fimage[]" id="fimage" value="{$image}" class="input-xxlarge" style="margin-top:15px"></div>
				{/if}
				
			{/foreach}
			{else}
				<div class="controls"><input type="text" name="fimage[]" id="fimage" value="" class="input-xxlarge" style="float:left">
				<div style="float:left; background:#00a1e6;padding:5px 10px;border-radius:3px;color:#fff;margin-left:5px; font-size:18px;cursor:pointer" id="addrecodeimage">+</div>
				</div>
		{/if}
	</div>
	<div class="control-group">
		<label class="control-label" for="fvideo">{$lang.controller.labelVideo} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fvideo" id="fvideo" value="{$formData.fvideo|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fimage360">{$lang.controller.labelImage360} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fimage360" id="fimage360" value="{$formData.fimage360|@htmlspecialchars}" class="input-xxlarge" placeholder="Demo : p.tgdt.vn/uploads/.../tenhinh-#.[jpg/jpeg/png]"></div> 
	</div>

	<div class="control-group">
		<label class="control-label" for="fprice">{$lang.controller.labelPrice} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fprice" id="fprice" value="{$formData.fprice|number_format}" class="input-large"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fcontent" id="fcontent" rows="12" class="input-xxlarge">{$formData.fcontent}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fjournalistically">{$lang.controller.labelJournalistically} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fjournalistically" id="fjournalistically" rows="12" class="input-xxlarge">{$formData.fjournalistically}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftechnical"> thông số kỷ thuật<span class="star_require">*</span></label>
		<div class="controls"><textarea name="ftechnical" id="ftechnical" rows="12" class="input-xxlarge mceNoEditor">{$formData.ftechnical}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstarttime">{$lang.controller.labelStartdate} <span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fstartdate" id="fstartdate" value="{$formData.fstarttime|@htmlspecialchars}" class="input-large inputdatepicker">

		</div>

	</div>
	
	<div class="control-group">
		<label class="control-label" for="fexpiretime">{$lang.controller.labelEnddate} <span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fenddate" id="fenddate" value="{$formData.fexpiretime|@htmlspecialchars}" class="input-large inputdatepicker">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">Status</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstatus">Show block other product</label>
		<div class="controls">
			<select name="fisshowblock" id="fisshowblock">
				<option value="1"> Show block </option>
				<option value="0"> Không show block</option>
			</select>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


{literal}
  <script type="text/javascript">
            $('#fsttime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
             $('#fextime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
         var i =0;
        $('#addrecodeimage').bind("click",function(){
        	i++;
        	if(i < 3)
        	{
	        var html = '<div class="controls"><input type="text" name="fimage[]" id="fimage" value="" class="input-xxlarge" style="margin-top:15px"></div>';
	        	$('#imageappend').append(html);
	        }
	        else
	        {
	        	alert('Add max 3 file image');
	        }
        })
    </script>
{/literal}

