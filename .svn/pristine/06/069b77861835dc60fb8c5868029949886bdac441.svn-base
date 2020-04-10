<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Program</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.labelUpdateExecutebutton}</li>
</ul>

<div class="page-header" rel="menu_program"><h1>{$lang.controller.labelReportbutton}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<table class="table">
		<tr><td style="max-width: 250px; max-height: 200px;">{$lang.controller.labelName}:</td><td><strong>{$formData.fname}</strong></td></tr>
		<tr><td style="max-width: 250px; max-height: 200px;">{$lang.controller.labelDescription}:</td><td>{$formData.fdescription}</td></tr>
		<tr><td style="max-width: 250px; max-height: 200px;">{$lang.controller.labelExecutetime}:</td><td>{$formData.fexecutetime}</td></tr>
		<tr><td style="max-width: 250px; max-height: 200px;">{$lang.controller.labelStartdate}:</td><td>{$formData.fstartdate}</td></tr>
		<tr><td style="max-width: 250px; max-height: 200px;">{$lang.controller.labelDateend}:</td><td>{$formData.fdateend}</td></tr>
		<tr><td style="max-width: 250px; max-height: 200px;">{$lang.controller.labelStorelist}:</td><td>
			{if !empty($formData.liststoresapply)}
				{foreach from=$formData.liststoresapply item=storeapp}
					{$storeapp->name}<br />
				{/foreach}<strong>(Tổng công: {$formData.liststoresapply|count})</strong>
			{/if}
		</td></tr>
	</table>

	<p class="clear">&nbsp;</p>
	<table class="table table-bordered" width="70%">
		<thead>
		<tr>
			<th valign="middle" width="30">STT</th>
			<th valign="middle">{$lang.controller.labelPoid}</th>
			<th valign="middle">{$lang.controller.labelImageguide}</th>
			{if !empty($formData.liststoresapply)}
				{foreach from=$formData.liststoresapply item=storeapp}					
					<th valign="middle">{$storeapp->name}</th>
				{/foreach}
			{/if}

		</tr>
		</thead>
		<tbody>
		{foreach item=position from=$formData.listpositions name=nameposition}
		{if empty($formData.programposition[$position->id].image)}{continue}{/if}
		<tr>
			<th width="30">{$smarty.foreach.nameposition.iteration}</td>
			<td>{$position->name}</td>
			<td>{if !empty($formData.programposition[$position->id])}
					<a href="{$formData.programposition[$position->id].image}" rel="shadowbox" title="Click để xem hình đúng kích thước"><img src="{$formData.programposition[$position->id].image}" style="max-width: 250px; max-height: 200px;" /></a>
				{/if}
			</td>
			{if !empty($formData.liststoresapply)}
				{foreach from=$formData.liststoresapply item=storeapp}
					<td align="center">
						{if !empty($formData.programposition[$position->id]) && !empty($formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id])}
							{if $formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->isapprove == 1}
								<a href="{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->getImage()}" rel="shadowbox" title="Click để xem hình đúng kích thước"><img src="{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->getImage()}" alt="" style="max-width: 250px; max-height: 200px;"></a>
							{elseif $formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->isapprove == 2}
								<p><strong>{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->approvenote}</strong></p>
								<p><a href="javascript:void(0)" class="btn btn-danger">KHÔNG ĐẠT</a></p>
							{else}
								<a id="imgex_{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id}" href="{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->getImage()}" rel="shadowbox" title="Click để xem hình đúng kích thước"><img src="{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->getImage()}" alt="" style="max-width: 250px; max-height: 200px;"></a><br />
								<form method="post" action="" id="approveform_{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id}" class="approveform" style="display: none;">
									<textarea rows="2" name="fcomment" id="fcomment"></textarea><br />
									<input class="btn btn-primary" type="button" value="OK" onclick="approvecomment({$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id}, 2)" />
								</form>
								{if $ismarketing ==1}
								<p><br /><a href="javascript:void(0)" class="btn btn-primary" onclick="approvefunc({$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id}, 1)" id="btnapprove_{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id}">ĐẠT</a>&nbsp;<a href="javascript:void(0)" class="btn btn-primary" onclick="unapprovefunc({$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id})" id="btnnotapprove_{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->id}">KHÔNG ĐẠT</a></p>
								{else}
									<a href="javascript:void(0)" class="btn">CHƯA DUYỆT</a>
								{/if}
							{/if}
							<p>Ngày upload: {$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->updatedate|date_format:"%d/%m/%Y %H:%m:%S"}</p>
							<p>Người upload: <em>{$formData.programpositionstore[$formData.programposition[$position->id].id][$storeapp->id]->fapproveuser}</em></p>
						{/if}
					</td>
				{/foreach}
			{/if}
		</tr>
		{/foreach}
		</tbody>
	</table>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
{literal}
<style type="text/css">
	.imageposition{position: relative; width: 100%; height: 100%;}
	.imageposition .delete{position: absolute; top: 0px; right: 0px;display:none;width: 13px height: 13px;}
	.imageposition .delete img{border: none;}
	.imageposition:hover .delete{display: block;}

</style>
<script type="text/javascript" language="Javascript">
function unapprovefunc(id){
	$('#approveform_'+id).css('display',' block');
	$('#imgex_'+id).remove();
	$('#btnapprove_'+id).remove();
	$('#btnnotapprove_'+id).remove();
}

function approvecomment(id, tp){
	$.post(rooturl +'cms/program/approve', $('#approveform_'+id).serialize()+'&id='+id+'&tp='+tp, function(data){
		if(data && data.success == 2){
			nalert(data.message, 'Lỗi');
		}
		else{
			$('#btnapprove_'+id).remove();
			$('#btnnotapprove_'+id).remove();
			var par = $('#approveform_'+id).parent();
			var cmm = '<strong>'+$('#approveform_'+id + ' #fcomment').val()+'</strong>';
			$('#approveform_'+id).remove();
			var oldhtml = par.html();

			par.html('<p>'+cmm+'</p><p><a href="javascript:void(0)" class="btn btn-danger">KHÔNG ĐẠT</a></p>'+oldhtml);

		}
	}, 'json');
	//this.remove();
}

function approvefunc(id, tp){
	$.post(rooturl +'cms/program/approve', {id: id, tp: tp}, function(data){
		if(data && data.success == 2){
			nalert(data.message, 'Lỗi');
		}
		else{
			$('#btnapprove_'+id).remove();
			$('#btnnotapprove_'+id).remove();
		}
	}, 'json');
}
</script>
{/literal}