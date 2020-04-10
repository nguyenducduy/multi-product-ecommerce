<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">PriceEnemy</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_priceenemy"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.priceenemyAddToken}" />
	

	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	 {include file="tinymce.tpl"}
	<div class="control-group" style="padding-left:110px;">		
		Barcode <input type="text" id="fpbarcodesearch">
		<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchProduct()" />
		<div id="result" style="color:red;display:none"></div>
	</div>
	<br /><br />

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="feid">{$lang.controller.labelEid} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="feid" id="feid" style="width:200px;">
				<option value="0">-------</option>
				{foreach item=enemy from=$enemys}
				<option value="{$enemy->id}" {if $enemy->id ==  $formData.feid}selected="selected"{/if}>{$enemy->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fregion">{$lang.controller.labelRegion}</label>
		<div class="controls">
			<select name="frid" id="frid" style="width:200px;"> 
				{foreach item=region key=regionid from=$setting.region}
		        	<option {if $regionid == $registry->region}selected="selected" {/if} value="{$regionid}">{$region}{if $regionid == $registry->region}{/if}</option>
		        {/foreach}
			</select>
		</div>
	</div>	
	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.lableType}</label>
		<div class="controls">
			<select name="ftype" id="ftype" style="width:200px;"> 
		        	<option {if $formData.ftype == 1}selected="selected"{/if} value="1">Online</option>
		        	<option {if $formData.ftype == 2}selected="selected"{/if} value="2">Offline</option>
			</select>
		</div>
	</div>
	<div class="group-online">
		<div class="control-group">
			<label class="control-label" for="furl">{$lang.controller.labelUrl} <span class="star_require">*</span></label>
			<div class="controls">
				<input type="text" name="furl" value="{$formData.furl}" class="input-xxlarge" />
			</div>
		</div>
		<div class="group-append">
			<div class="control-group">
				<label class="control-label" for="fimage">{$lang.controller.lableImage} </label>
				<div class="controls">
					<img src="{$formData.fimage}" name="fimage"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="fpriceauto">{$lang.controller.lablePrice} </label>
				<div class="controls">
					<input type="text" name="fpriceauto" readonly="true"  value="{$formData.fpriceauto}" class="input-xlarge" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="fpricepromotion">{$lang.controller.lablePricePromotion} </label>
				<div class="controls">
					<input type="text" name="fpricepromotion" readonly="true" value="{$formData.fpricepromotion}" class="input-xlarge" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="furl">{$lang.controller.labelDescription} </label>
				<div class="controls">
					<textarea name="fdescription" rows="3" class="input-xxlarge">
						{$formData.fdescription}
					</textarea>
				</div>
			</div>
		</div>
		<div class="control-group" style="margin-left: 488px">
			<div class="controls">
				<input type="submit" name="fsync" value="Sync" class="btn btn-large btn-warning" />
			</div>
		</div>
		
	</div>
	<div class="group-offline" style="display:none">
		<div class="control-group">
			<label class="control-label" for="fname">{$lang.controller.lableName}</label>
			<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-large"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="fprice">{$lang.controller.labelPrice}</label>
			<div class="controls"><input type="text" name="fprice" id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-large"></div>
		</div>	
		<div class="control-group">
			<label class="control-label" for="fpricepromotion">{$lang.controller.lablePricePromotion}</label>
			<div class="controls"><input type="text" name="fpricepromotion" id="fpricepromotion" value="{$formData.fpricepromotion|@htmlspecialchars}" class="input-large"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="fpromotioninfo">{$lang.controller.lablePromotionInfo}</label>
			<div class="controls">
				<textarea name="fpromotioninfo" id="fpromotioninfo" rows="5" class="input-xxlarge">
					{$formData.fpromotioninfo|@htmlspecialchars}
				</textarea>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.labelNote}</label>
		<div class="controls"><textarea name="fnote" id="fnote" rows="7" class="input-xxlarge">{$formData.fnote}</textarea></div>
	</div>		
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$("#feid").select2();
		$("#frid").select2();

		$("#ftype").change(function(event) {
			var type = $(this).val();
			if(type == 1)
			{
				$('.group-online').toggle("slow");
				$('.group-offline').fadeOut('fast');
			}
			else
			{
				$('.group-offline').toggle("slow");
 				$('.group-online').fadeOut('fast');
			}
		});
	});

	function searchProduct()
	{		
		var barcode = $('#fpbarcodesearch').val();


		if(barcode != '')
		{
			var datastring = "barcode="+barcode;
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/priceenemy/searchproductajax",
				data : datastring,
				success : function(html){
					if(html == 'error')
					{
						$('#result').html('{/literal}{$lang.controller.productPermission}{literal}');
						$('#result').fadeIn();
					}
					else if(html == 'notfound')
					{
						$('#result').html('{/literal}{$lang.controller.productNotFound}{literal}');
						$('#result').fadeIn();
					}
					else
					{
						$('#fpid').val(html);
						$('#result').fadeOut();
					}

				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errSearchCond}{literal}');
		}
	}


</script>
{/literal}

