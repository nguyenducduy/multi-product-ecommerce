<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Program</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.labelUpdateExecutebutton}</li>
</ul>

<div class="page-header" rel="menu_program"><h1>{$lang.controller.labelStoreExecute}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform"  id="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.programEditToken}" />

	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<table class="table">
		<tr><td width="150">{$lang.controller.labelName}:</td><td>{$formData.fname}</td></tr>
		<tr><td width="150">{$lang.controller.labelDescription}:</td><td>{$formData.fdescription}</td></tr>
		<tr><td width="150">{$lang.controller.labelExecutetime}:</td><td>{$formData.fexecutetime}</td></tr>
		<tr><td width="150">{$lang.controller.labelStartdate}:</td><td>{$formData.fstartdate}</td></tr>
		<tr><td width="150">{$lang.controller.labelDateend}:</td><td>{$formData.fdateend}</td></tr>
		<tr><td width="150">{$lang.controller.labelStorelist}:</td><td>
			{if !empty($formData.liststoresapply)}
				{foreach from=$formData.liststoresapply item=storeapp}
					{$storeapp->name}<br />	
				{/foreach}
			{/if}
		</td></tr>
	</table>
	
	<p class="clear">&nbsp;</p>
	<table class="table table-bordered" width="70%">
		<thead>
		<tr>
			<th width="30">STT</th>
			<th>{$lang.controller.labelPoid}</th>
			<th width="250">{$lang.controller.labelImageguide}</th>
			<th width="250">{$lang.controller.labelExecutebutton}{if $formData.hasapprove ==2}&nbsp;<input type="button" name="btnupload" id="btnupload" value="Upload" class="btn btn-info" onclick="showuploadpopup()" />
				<input type="file" multiple="multiple" name="fimageexecutearr[]" id="fimageexecutearr" style="display: none;" />{/if}
			</th>
			<th width="300">{$lang.controller.labelNote}</th>
		</tr>
		</thead>
		<tbody>
		{foreach item=position from=$formData.listpositions name=nameposition}
		{if empty($formData.programposition[$position->id].image)}{continue}{/if}
		<tr>
			<th width="30">{$smarty.foreach.nameposition.iteration}</td>
			<td>{$position->name}</td>
			<td>{if !empty($formData.programposition[$position->id])}
					<a href="{$formData.programposition[$position->id].image}" rel="shadowbox" title="Click để xem hình đúng kích thước"><img src="{$formData.programposition[$position->id].image}" width="250" /></a>
				{/if}			
			</td>
			<td>
				{if !empty($formData.programpositionstore) && !empty($formData.programposition[$position->id])}
					{if  $formData.fapprove[$formData.programposition[$position->id].id] != 1}
					<div class="imageposition">					
						{if !empty($formData.programpositionstore[$formData.programposition[$position->id].id])}
							<a title="Click để xem hình đúng kích thước" href="{$formData.programpositionstore[$formData.programposition[$position->id].id]}" rel="shadowbox"><img src="{$formData.programpositionstore[$formData.programposition[$position->id].id]}" width="250" /></a>
							<a href="javascript:void(0)" rel="{$formData.programposition[$position->id].id}" class="delete"><img src="{$currentTemplate}images/notify/close-btn.png" alt="" /></a>
						{else}
							<input type="file" name="fimagepos[{$formData.programposition[$position->id].id}]"/>
						{/if}
					</div>
					{else}
						<a href="{$formData.programpositionstore[$formData.programposition[$position->id].id]}" rel="shadowbox" title="Click để xem hình đúng kích thước"><img src="{$formData.programpositionstore[$formData.programposition[$position->id].id]}" width="250" /></a>
					{/if}
				{/if}
			</td>
			<td><strong>{$formData.fnote[$formData.programposition[$position->id].id]}</strong><p>{if $formData.fapprove[$formData.programposition[$position->id].id] == 2}<a href="javascript:void(0)" class="btn btn-danger">KHÔNG ĐẠT</a>{if !empty($formData.fapproveuser[$formData.programposition[$position->id].id])}{/if}</p>{elseif $formData.fapprove[$formData.programposition[$position->id].id] == 1}<a href="javascript:void(0)" class="btn btn-success">ĐẠT</a>{else}<a href="javascript:void(0)" class="btn btn-info">CHƯA DUYỆT</a>{/if}<br />Người duyệt: <em>{$formData.fapproveuser[$formData.programposition[$position->id].id]}</em></td>
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
	$('#fimageexecutearr').change(function(){
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
	$('#fimageexecutearr').click();
}
</script>
{/literal}