<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Program</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_program"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" id="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.programEditToken}" />

	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="3" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fexecutetime">{$lang.controller.labelExecutetime} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fexecutetime" id="fexecutetime" value="{$formData.fexecutetime|@htmlspecialchars}" class="input-xlarge inputdatepicker"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstartdate">{$lang.controller.labelStartdate} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fstartdate" id="fstartdate" value="{$formData.fstartdate|@htmlspecialchars}" class="input-xlarge inputdatepicker"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdateend">{$lang.controller.labelDateend} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdateend" id="fdateend" value="{$formData.fdateend|@htmlspecialchars}" class="input-xlarge inputdatepicker"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstorelist">{$lang.controller.labelStorelist} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fstorelist[]" id="fstorelist" multiple="multiple" class="input-xlarge" style="width: 290px; height: 200px">
				{foreach from=$formData.liststores item=store}					
					<option{if !empty($formData.fstorelist) && in_array($store->id, $formData.fstorelist)} selected="selected"{/if} value="{$store->id}">{$store->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	<p class="clear">&nbsp;</p>
	<table class="table table-bordered" width="70%">
		<thead>
		<tr>
			<th width="30">STT</th>
			<th>{$lang.controller.labelPoid}</th>
			<th>{$lang.controller.labelImageguide}&nbsp;<input type="button" name="btnupload" id="btnupload" value="Upload" class="btn btn-info" onclick="showuploadpopup()" />
				<input type="file" multiple="multiple" name="fimageguidearr[]" id="fimageguidearr" style="display: none;" />
			</th>
			<th width="400">{$lang.controller.labelNoteguide}</th>
		</tr>
		</thead>
		<tbody>
		{foreach item=position from=$formData.listpositions name=nameposition}
		<tr>
			<th width="30">{$smarty.foreach.nameposition.iteration}</td>
			<td>{$position->name}</td>
			<td>
				<div class="imageposition">					
					{if !empty($formData.programposition[$position->id])}
						<img src="{$formData.programposition[$position->id]}" width="250" />
						<a href="javascript:void(0)" rel="{$position->id}" class="delete"><img src="{$currentTemplate}images/notify/close-btn.png" alt="" /></a>
					{else}
						<input type="file" name="fimagepos[{$position->id}]"/>
					{/if}
				</div>
			</td>
			<td><textarea name="fnoteguide[{$position->id}]" id="fnoteguide_{$position->id}" row="4" class="input-xlarge" style="width: 96%;">{$formData.fnoteguide[$position->id]}</textarea></td>
		</tr>
		{/foreach}
		</tbody>
	</table>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>
{literal}
<style type="text/css">
	.imageposition{position: relative; width: 100%; height: 100%;}
	.imageposition .delete{position: absolute; top: 0px; right: 0px;display:none;width: 13px height: 13px;}
	.imageposition .delete img{border: none;}
	.imageposition:hover .delete{display: block;}
</style>
<script type="text/javascript" language="Javascript">
$(document).ready(function(){
	//$('#fstorelist').select2();
	$('#fimageguidearr').change(function(){
		$('#myform').submit();
	});
	$('.delete').click(function(){
		var parentobj = $(this).parent();
		//parentobj.find('img').remove();
		//parentobj.find('input').css('display', 'block');
		parentobj.html('<input type="file" name="fimagepos['+$(this).attr('rel')+']"/>');
	});
});

function showuploadpopup(){
	$('#fimageguidearr').click();
}
</script>
{/literal}