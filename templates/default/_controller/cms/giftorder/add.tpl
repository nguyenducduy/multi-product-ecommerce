<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Giftorder</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_giftorder"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.giftorderAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpricefrom">{$lang.controller.labelPricefrom} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpricefrom" id="fpricefrom" value="{$formData.fpricefrom|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpriceto">{$lang.controller.labelPriceto} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpriceto" id="fpriceto" value="{$formData.fpriceto|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstartdate">{$lang.controller.labelStartdate} <span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" value="{$formData.fsttime}" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fstartdate" id="fstartdate" value="{$formData.fstartdate|@htmlspecialchars}" class="input-large inputdatepicker">

		</div>

	</div>
	
	<div class="control-group">
		<label class="control-label" for="fenddate">{$lang.controller.labelEnddate} <span class="star_require">*</span></label>
		<div class="controls">
			<div class="input-append bootstrap-timepicker">
	            <input id="fextime" type="text" placeholder="H:m:s" name="fextime" value="{$formData.fextime}" class="input-small timepicker">
	            <span class="add-on"><i class="icon-time"></i></span>
        	</div>
			<input type="text" name="fenddate" id="fenddate" value="{$formData.fenddate|@htmlspecialchars}" class="input-large inputdatepicker">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select class="" name="fstatus" id="fstatus">{html_options options=$statusOptions selected=$formData.fstatus}</select></div>
	</div>
	<div class="control-group">
		<label class="" style="margin-left: 25px;font-size: 13px;color: #3498db;border-bottom: dashed 1px;width: 800px;padding-bottom: 5px;" for="fstatus">- Thêm sản phẩm tặng quà</label>
		
	</div>
	<div class="control-group" style="float: right;margin-right: 285px;margin-top: -20px;">
		<a id="addproduct" style="color: #fff;background: #3498db;padding: 5px 15px;border-radius: 4px;cursor:pointer">Thêm sản phẩm +</a>
	</div>
	{if $formData.fproductid|count >0}
		{foreach from=$formData.fproductid key=key item=id}
			<div class="control-product-group">
				<span style="margin-left:30px; color:#3498db">Sản phẩm 1</span>
				<div class="control-product">
					<div class="control-group">
						<label class="control-label" for="fproductid">Mã sản phẩm <span class="star_require">*</span></label>
						<div class="controls"><input type="text" name="fproductid[]" id="fproductid" value="{$formData.fproductid.$key|@htmlspecialchars}" class="input-small"></div>
					</div>

					<div class="control-group">
						<label class="control-label" for="fquantity">Tổng số <span class="star_require">*</span></label>
						<div class="controls"><input type="text" name="fquantity[]" id="fquantity" value="{$formData.fquantity.$key|@htmlspecialchars}" class="input-large"></div>
					</div>

					<div class="control-group">
						<label class="control-label" for="fstatusp">{$lang.controller.labelStatus}</label>
						<div class="controls"><select class="" name="fstatusp[]" id="fstatusp">{html_options options=$statusOptions selected=$formData.fstatusp.$key}</select></div>
					</div>
				</div>
			</div>
		{/foreach}
	{else}
			<div class="control-product-group">
				<span style="margin-left:30px; color:#3498db">Sản phẩm 1</span>
				<div class="control-product">
				    	<div class="control-group">
							<label class="control-label" for="fproductid">Mã sản phẩm <span class="star_require">*</span></label>
							<div class="controls"><input type="text" name="fproductid[]" id="fproductid" value="{$formData.fproductid|@htmlspecialchars}" class="input-large"></div>
						</div>
					<div class="control-group">
						<label class="control-label" for="fquantity">Tổng số <span class="star_require">*</span></label>
						<div class="controls"><input type="text" name="fquantity[]" id="fquantity" value="{$formData.fquantity|@htmlspecialchars}" class="input-large"></div>
					</div>

					<div class="control-group">
						<label class="control-label" for="fstatusp">{$lang.controller.labelStatus}</label>
						<div class="controls"><select class="" name="fstatusp[]" id="fstatusp">{html_options options=$statusOptions selected=$formData.fstatusp}</select></div>
					</div>
				</div>
			</div>
	{/if}
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{literal}
	<style type="text/css">
		.holder{
			width: 370px !important;
		}
	</style>
  <script type="text/javascript">
            $('#fsttime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
             $('#fextime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
        var i = 1;
        $('#addproduct').click(function(event) {
        	if(i < 3)
        	{
        		i++;
        		var data = $('.control-product-group .control-product:first').html();
        		var html = '<span style="margin-left:30px; color:#3498db">Sản phẩm '+i+'</span><div class="control-product">'+data+'</div>';
        		$('.control-product-group').append(html);
        	}
        	else
        	{
        		alert('Số lượng thêm tối đa cho một mức giá là '+ (i));
        	}
        });
    </script>
{/literal}

