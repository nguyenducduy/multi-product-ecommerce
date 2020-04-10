<title>Editinline media của sản phẩm</title>
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

		<!-- Bootstrap Responsive Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

		<!-- Customized Admin Stylesheet -->
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />

		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen" />




		<!-- jQuery -->
		<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

		<!-- Bootstrap Js -->
		<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>



		<!-- customized admin -->
		<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
		<script type="text/javascript" src="{$currentTemplate}min/?g=jsadminchart&ver={$setting.site.jsversion}"></script>


        <script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_admin = "{$conf.rooturl_admin}";
		var rooturl_cms = "{$conf.rooturl_cms}";
		var rooturl_crm = "{$conf.rooturl_crm}";
		var rooturl_erp = "{$conf.rooturl_erp}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var controllerGroup = "{$controllerGroup}";
		var currentTemplate = "{$currentTemplate}";

		var websocketurl = "{$setting.site.websocketurl}";
		var websocketenable = {$setting.site.websocketenable};

		var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";


		var imageDir = "{$imageDir}";
		var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
		var gritterDelay = 3000;
		var meid = {$me->id};
		var meurl = "{$me->getUserPath()}";
		var userid = {$myUser->id};
		var userurl = "{$myUser->getUserPath()}";
		</script>

{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<div class="page-header"><h1>{$head_list}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">

	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li {if $formData.ftab == 1} class="active"{/if}><a href="#tab1" data-toggle="tab">{$lang.controller.labelAvatar}</a></li>
			<li{if $formData.ftab == 2} class="active"{/if}><a href="#tab2" data-toggle="tab">{$lang.controller.labelGallery}</a></li>
			<li{if $formData.ftab == 3} class="active"{/if}><a href="#tab3" data-toggle="tab">{$lang.controller.labelImage360}</a></li>
			<!-- <li{if $formData.ftab == 4} class="active"{/if}><a href="#tab4" data-toggle="tab">{$lang.controller.labelVideo}</a></li> -->
		</ul>
		<div class="tab-content">
			<div class="tab-pane {if $formData.ftab == 1} active{/if}" id="tab1">
				{if $formData.fimage != ''}
				<a href="{$formData.fimage}" rel="shadowbox"><img src="{$formData.fimage}" width="50px" height="50px" /></a>
				{/if}
				<input type="file" name="fimage" /><span style="padding-left:4px;">PNG,JPG,GIF</span><br/>
				<span {if $formData.fimage != ''}style="padding-left:120px;"{else}style="padding-left:47px;"{/if}></span><br/><br/>
			</div><!--end of tab1-->

			<div class="tab-pane {if $formData.ftab == 2 || $formData.ftab == 4} active{/if}" id="tab2">
				<h1>Gallery</h1>
				<table class="table" id="gallery">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					{foreach item=media from=$productmediaList}
					{if $media->type ==1}
					<tr id="{$media->id}">						
						<td>
							<input type="hidden" name="fmediaId[]" value="{$media->id}" />
							<a href="{$media->getImage()}" rel="shadowbox"><image src="{$media->getSmallImage()}" width="50px" height="50px" /></a>
						</td>
						<td><input style="height:30px;" type="text" name="fcaptionmedia[{$media->id}]" value="{$media->caption}" value="{$media->caption}" {if $media->caption == ''}placeholder="Caption..."{/if} /></td>
						<td><input style="height:30px;" type="text" name="faltmedia[{$media->id}]" value="{$media->alt}"  {if $media->alt == ''}placeholder="Alt..."{/if}  /></td>
						<td><input style="height:30px;" style="height:30px;" type="text" name="ftitleseomedia[{$media->id}]" value="{$media->titleseo}" {if $media->titleseo == ''}placeholder="Title SEO..."{/if} /></td>						
						<td><a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
					</tr>
					{/if}
					{/foreach}
					{foreach item=media from=$productmediaList}
					{if $media->type ==3}
					<tr id="{$media->id}">						
						<td>
							<input type="hidden" name="fmediaId[]" value="{$media->id}" />
							<input style="height:30px;" type="text" name="fmoreurlold[{$media->id}]" value="{$media->moreurl}" />
						</td>
						<td><input style="height:30px;" type="text" name="fcaptionmedia[{$media->id}]" value="{$media->caption}" {if $media->caption == ''}placeholder="Caption..."{/if} /></td>
						<td><input style="height:30px;" type="text" name="faltmedia[{$media->id}]" value="{$media->alt}" {if $media->alt == ''}placeholder="Alt..."{/if} /></td>
						<td><input style="height:30px;" type="text" name="ftitleseomedia[{$media->id}]" value="{$media->titleseo}" {if $media->titleseo == ''}placeholder="Title SEO..."{/if} /></td>
						<td><a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
						<td></td>
						<td></td>
						<td></td>
					{/if}
					{/foreach}
					<tr>
						<td>Hình sản phẩm</td>
						<td><input type="file" name="ffile[]" multiple /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>						
					</tr>
					<tr>
						<td>YouTube URL</td>
						<td><input style="height:30px;" type="text" id="urlvalue-2" name="furl[2]" placeholder="URL..."></span></td>
						<td><span id="caption-2"><input style="height:30px;" type="text" name="fcaption[2]" value="" placeholder="Caption..." /></span></td>
						<td><span id="alt-2"><input type="text" style="height:30px;"  name="falt[2]" value="" placeholder="Alt..." /></span></td>
						<td><span id="titleseo-2"><input type="text" style="height:30px;"  name="ftitleseo[2]" value="" placeholder="Title..." /></span></td>
						<td></td>
					</tr>					
				</table>				
				<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton" value="+" onclick="addRow('gallery')" /><br/><br/><br/>				
			</div><!--end of tab 2-->
			<div class="tab-pane {if $formData.ftab == 3} active{/if}" id="tab3">
				<table class="table" id="t360">
					{foreach item=media from=$productmediaList}
					{if $media->type == 5}
					<tr id="{$media->id}">
						<td><input type="hidden" name="fmediaId[]" value="{$media->id}" />{$media->getMediaName()}</td>
						<td>
							<a href="{$media->getSmallImage()}" rel="shadowbox"><image src="{$media->getSmallImage()}" width="50px" height="50px" /></a>
						</td>
						<td><input style="height:30px;" type="text" name="fcaptionmedia[{$media->id}]" value="{$media->caption}" /></td>
						<td><input style="height:30px;" type="text" name="faltmedia[{$media->id}]" value="{$media->alt}" /></td>
						<td><input style="height:30px;" type="text" name="ftitleseomedia[{$media->id}]" value="{$media->titleseo}" /></td>
						<td><a title="{$lang.default.formActionDeleteTooltip}" class="btn btn-mini btn-danger" href="javascript:void(0)" onclick="deleteMedia('{$media->id}')"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
					</tr>
					{/if}
					{/foreach}
					<tr id="image360_1">
						<td style="width:127px;">Upload hình 360 : </td>
						<td><input type="file" name="ffile360[]" multiple/></td>						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>				
			</div><!--end of tab 3-->

			

		</div>

	</div>
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
	</div>
</form>

{literal}
<script type="text/javascript">
	function deleteMedia(id)
	{
		bootbox.confirm("{/literal}{$lang.controller.deleteMediaConfirm}{literal}",function(confirm){
			if(confirm){
				var dataString = "id=" + id;
				$.ajax({
					type : 'post',
					dataType : "html",
					url : '/cms/product/deleteMediaAjax',
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#'+id).fadeOut(10);
						}
					}
				});
			}
		});
	}

	function deleteProductColorFunction(pidsource, piddestination, colorCode)
    {
        if(pidsource > 0 && piddestination > 0)
        {
            bootbox.confirm("{/literal}{$lang.controller.deleteMediaConfirm}{literal}",function(confirm){
			if(confirm)
			{
				var dataString = 'pidsource=' + pidsource + '&piddestination='+piddestination + '&colorcode=' + colorCode;
				$.ajax({
				    type : "post",
					dataType : "html",
					url : "/cms/product/deleteProductColorAjax",
					data : dataString,
					success : function(html){
						if(html == 'success'){
							$('#rows'+piddestination).fadeOut();
							$('#fdefaultcolor' + colorCode).fadeOut();
						}else{
								bootbox.alert("{/literal}{$lang.controller.deleteError}{literal}");
						}
					}
				});
			}
		    });
        }
    }

    function addRow(tbname)
    {
        rowCount = $('#'+ tbname +' tr').length;
        rowCount +=1 ;        
        if(tbname == 't360')
        {
            data = '<tr id="image360_'+rowCount+'"><td><input type="hidden" name="ftypeimage360['+rowCount+']" value="5"/></td><td><input type="file" name="ffile360['+rowCount+']" style="width:200px;" /></td><td><span id="caption360-'+rowCount+'"><input type="text" name="fcaption360['+rowCount+']" value="" placeholder="Caption..." /></td><td></td></tr>';
        }
        else if(tbname == 'urlmore')
        {
            data = '<tr><td><input type="hidden" name="ftype['+rowCount+']" value="3" /></td><td><input type="text" id="urlvalue-'+rowCount+'"  name="furl['+rowCount+']" placeholder="URL..."></td><td><span id="caption-'+rowCount+'"><input type="text" name="fcaption['+rowCount+']" value="" placeholder="Caption..." /></span></td><td></td></tr>';
        }
        else if(tbname = 'gallery')
        {
        	data = '<tr><td>YouTube URL</td><td><span id="url-'+rowCount+'" ><input style="height:30px;" type="text" id="urlvalue-'+rowCount+'" name="furl['+rowCount+']" placeholder="URL..."></span></td><td><span id="caption-'+rowCount+'"><input style="height:30px;" type="text" name="fcaption['+rowCount+']" value="" placeholder="Caption..." /></span></td><td><span id="alt-'+rowCount+'"><input style="height:30px;" type="text" name="falt['+rowCount+']" value="" placeholder="Alt..." /></span></td><td><span id="titleseo-'+rowCount+'"><input style="height:30px;" type="text" name="ftitleseo['+rowCount+']" value="" placeholder="Title..." /></span></td><td></td></tr>';		
        }
        $('#'+tbname).append(data);
    }
	function changeType(id)
	{
		if($('#ftype-'+id).val() == 1)
		{
			$('#file-'+id).fadeIn(10);
			$('#url-'+id).fadeOut(10);
			$('#url-'+id).val('');
			$('#urlvalue-'+id).val('');
		}
		else
		{
			$('#url-'+id).fadeIn(10);
			$('#file-'+id).fadeOut(10);
			$('#file-'+id).html($('#file-'+id).html());
		}
	}
</script>
{/literal}
