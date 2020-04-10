<ul class="breadcrumb">
	<li><a href="{$conf.rooturl}{$controllerGroup}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Shipping Fee</a> <span class="divider">/</span></li>
</ul>



<div class="page-header" rel="menu_region"><h1>{$lang.controller.head_list} - Upload</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li{if $action=='index'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Shipping Prices</a></li>
		<li{if $action=='shippingprovince'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/shippingprovince">Shipping Fee Province</a></li>
		<li{if $action=='settinglabel'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/settinglabel">Setting Label</a></li>
		<li{if $action=='settingfee'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/settingfee">Setting Name of Fee</a></li>
		<li{if $action=='vxvsttc'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/vxvsttc">Fee VXVS TTC</a></li>

	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
				<p>&nbsp;</p>
				<div class="control-group">
					<label class="control-label" for="fname">Select type to upload</label>
					<div class="controls">
						<select class="input-xlarge" name="ftabletoupload" id="ftabletoupload">
							<option value="">---SELECT----</option>
							<option value="lit_shippingfee_prices"{if $formData.ftabletoupload == 'lit_shippingfee_prices'} selected="selected"{/if}>Price Template</option>
							<option value="lit_shippingfee_dienmay"{if $formData.ftabletoupload == 'lit_shippingfee_dienmay'} selected="selected"{/if}>Shipping Fee Province</option>
							<option value="lit_shippingfee_namefee"{if $formData.ftabletoupload == 'lit_shippingfee_namefee'} selected="selected"{/if}>Setting Label</option>
							<option value="lit_shippingfee_settings"{if $formData.ftabletoupload == 'lit_shippingfee_settings'} selected="selected"{/if}>Settings Fee</option>
							<option value="lit_shippingfee_vxvs_ttc"{if $formData.ftabletoupload == 'lit_shippingfee_vxvs_ttc'} selected="selected"{/if}>Fee VXVS TTC</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fname">Select file to upload</label>
					<div class="controls"><input type="file" name="fuploadfile" id="fuploadfile" class="input-xlarge"></div>
				</div>
				<div class="form-actions">
					<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
					<span class="help-inline"><span class="star_require">*</span> : Upload</span>
				</div>
			</form>
		</div><!-- end #tab 1 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/region/index";


		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
		}

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}


		document.location.href= path;
	}
</script>
{/literal}




