<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Homepage</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.labelUpdate}</li>
</ul>

<div class="page-header" rel="menu_homepage"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.homepageAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



	<div class="control-group">
		<label class="control-label" for="fcategory">{$lang.controller.labelCategory} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fcategory" id="fcategory">
				<option value="">---------</option>
				{foreach item=newscategory from=$newscategoryList}
				<option value="{$newscategory->id}" {if $formData.fcategory == $newscategory->id}selected="selected"{/if}>{$newscategory->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finputtype">{$lang.controller.labelType}</label>
		<div class="controls"><input type="hidden" name="ftype" value="{$formData.type}" /><span class="label label-info">{$formData.typename}</span></div>
	</div>

	<div style="margin-left:31px;">{$lang.controller.newsid} : <input type="text" id="nid" />&nbsp;{$lang.controller.newsname} : <input type="text" id="ntitle" /> &nbsp;<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="loadNewsHomepage()" /></div>
	<br />
	<div id="resultHomepage">

	</div>
	<div id="homepagenews" style="display:none"><h1>Tin tức được chọn</h1><table class="table" id="choosehomepage"><tbody></tbody></table></div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>

</form>
{literal}
<script type="text/javascript">
function loadNewsHomepage()
{
	if($('#fcategory').val() >  0)
	{
		if($('#nid').val() != '' || $('#ntitle').val() != '')
		{
			var dataString = "catid=" + $('#fcategory').val() + "&id="+ $('#nid').val() + "&title=" +$('#ntitle').val();
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/homepage/loadnewsajax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultHomepage').html(html);
						if($('#homepagenews').attr('display') != 'none'){
							$('#homepagenews').fadeIn();
						}
					}else{
						$('#resultHomepage').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errCondNewsNotEmpty}{literal}');
		}
	}
	else
	{
		bootbox.alert('{/literal}{$lang.controller.errCategoryRequired}{literal}');
	}
}
function chooseFunction(id)
{
	if(id > 0)
	{
		//kiem tra xem san pham nay da duoc chon hay chua ?
		if($('#'+id).length == 0)
		{
			var imgSource = $('#images_'+id).attr('src');
			var title = $('#names_'+id).html();
			var date = $('#date_'+id).html();
			var data = '<tr id="row_'+id+'">';
			data += '<td style="width:150px;">';
			if(imgSource != undefined)
			{
				data += '<a href="'+imgSource+'" rel="shadowbox" ><img src="'+imgSource+'" width="100px" height="100px" /></a>';
			}
			data += '</td>';
			data += '<td style="width:705px;"><input type="hidden" name="listid[]" value="'+id+'" id="'+id+'" />'+title+'</td>';
			data += '<td>'+date+'</td>';
			data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+')" value="Remove" /></td>';
			data += '</tr>';
			$('#choosehomepage').find('tbody').append(data);
			$('#rows'+id).fadeOut();
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errNewsChoose}{literal}');
		}
	}
}
function clearFunction(id)
{
	$('#row_'+id).remove();
	$('#rows'+id).fadeIn();
}
</script>
{/literal}
