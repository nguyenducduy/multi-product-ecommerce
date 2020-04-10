<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ApiPartnerSale</a> <span class="divider">/</span></li>
    <li class="active">Import Discount value</li>
</ul>
	
<div class="page-header" rel="menu_product"><h1>Import Discount value</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
	{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
	<div class="control-group">
		<label class="control-label" for="fapipartner">Partner</label>
		<div class="controls">
			<select id="fapid" name="fapid" style="width:200px;">
				{foreach from=$apipartnerList item=apipartner}
					<option value="{$apipartner->id}">{$apipartner->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fvsubid">File</label>
		<div class="controls">
			<input type="file" id="ffile" name="ffile" />
		</div>
	</div> 
	<div class="form-actions" id="submitallbutton">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
	</div>
</form>
{literal}
	<script type="text/javascript">
		$(document).ready(function(){
			$("#fapid").select2();
		});
	</script>
{/literal}