<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>	
	<li class="active">Store Config</li>
</ul>

<div class="page-header" rel="menu_product"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formBackLabel}</a></div>
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<form action="" method="post" name="myform" class="form-horizontal">
	<h1>Vui lòng chọn ngành hàng</h1>
	<div class="control-group">
		<label class="control-label" for="fpcid">Ngành hàng<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcid" id"fpcid">
				<option value="0">-------</option>
				{foreach item=data key=pcid from=$rootcategory}
				<option value="{$pcid}">{$data.name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<!-- <div class="control-group" id="child" style="display:none">
		<label class="control-label" for="fpcid1">{$lang.controller.labelPcid1} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcid1" id="fpcid1" style="width:200px;">
			</select>
		</div>
	</div> -->
	<input type="submit" name="fsubmitNext" value="Tiếp tục" class="btn btn-large btn-primary" style="float:right;" />
</form>