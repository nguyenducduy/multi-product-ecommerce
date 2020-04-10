<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Ads</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_ads"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.adsEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
    {if !empty($formData.fistypebannerimage)}
	<div class="control-group">
        <label class="control-label" for="ftype">{$lang.controller.labelImage}</label>
        <div class="controls">
            <img src="{$formData.flinkimage}" alt="" border="1" />
        </div>
    </div>
    {/if}
    
	<div class="control-group">
		<label class="control-label" for="fazid">{$lang.controller.labelAzid}</label>
		<div class="controls">
			<select name="fazid" id="fazid">
				<option value="0">- - - - -</option>
				{foreach item=adszone from=$adszoneList}
					<option value="{$adszone->id}" {if $adszone->id == $formData.fazid}selected="selected"{/if}>{$adszone->name}</option>
				{/foreach}
			</select>
			
			<a href="{$conf.rooturl_cms}adszone">Manage</a>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType}</label>
		<div class="controls">
			<select name="ftype" id="ftype">
				{html_options options=$typeList selected=$formData.ftype}
			</select>
		</div>
	</div>
    
    <div class="control-group">
        <label class="control-label" for="fgroupmain">{$lang.controller.labelGroup}</label>
        <div class="controls">
            <select name="fgroupmain[]" id="fgroupmain" class="input-xlarge" multiple="multiple" style="height: 100px;">
                <option value="0">- - - - -</option>
            {foreach from=$productcategoryList item=productCategory}
                <option value="{$productCategory->id}"{if !empty($formData.fgroupmain) && in_array($productCategory->id, $formData.fgroupmain)} selected="selected"{/if}>{$productCategory->name}</option>
            {/foreach}
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="faslug">{$lang.controller.labelSlug} </label>
        <div class="controls"><input type="text" name="faslug" id="faslug" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flink">{$lang.controller.labelLink} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="flink" id="flink" value="{$formData.flink|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>



    <div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle}</label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

    {if $formData.fparent == 0}
	<div class="control-group">
		<label class="control-label" for="fwidth">{$lang.controller.labelWidth}</label>
		<div class="controls"><input type="text" name="fwidth" id="fwidth" value="{$formData.fwidth|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fheight">{$lang.controller.labelHeight}</label>
		<div class="controls"><input type="text" name="fheight" id="fheight" value="{$formData.fheight|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcampaign">{$lang.controller.labelCampaign}</label>
		<div class="controls">
			<select name="fcampaign" id="fcampaign" class="input-xlarge">
                <option value="0">- - - - -</option>
            {foreach from=$formData.listprogram item=program}
                <option value="{$program->id}"{if $formData.fcampaign==$program->id} selected="selected"{/if}>{$program->name}</option>
            {/foreach}
            </select>
		</div>
	</div>
    
    <div class="control-group">
        <label class="control-label" for="fdatestarted">{$lang.controller.labelDatebegin}</label>
        <div class="controls"><input class='inputdatepicker' type="text" name="fdatebegin" id="fdatebegin" value="{if $formData.fdatebegin > 0}{$formData.fdatebegin|@htmlspecialchars}{/if}" ></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdateended">{$lang.controller.labelDateend}</label>
        <div class="controls">
            <input type="text" class='inputdatepicker' name="fdateend" id="fdateend" value="{if $formData.fdateend > 0}{$formData.fdateend|@htmlspecialchars}{/if}" style="float: left;" >
            <label class="checkbox" style="float: left; margin-left: 5px;">
                <input type="checkbox" name="funlimited" id="funlimited" value="1"{if $formData.fdateend<=0} checked="checked"{/if}> {$lang.controller.labelUnlimited}
            </label>
        </div>
    </div>


	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>
        <input type="hidden" value="{$formData.fid}" id="ftextextSlug">
    {/if}
    <div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>
{*if $formData.fparent == 0}
<div class="page-header" rel="menu_ads"><h1>{$lang.controller.categoryads}</h1></div>
    <div id="listcategoryads">
    {if !empty($listCategoryAds)}
            <table class="table table-striped">
                <thead>
                    <tr><th>{$lang.controller.labelImage}</th><th>{$lang.controller.labelName}</th><th>{$lang.controller.labelTitle}</th><th>{$lang.controller.labelLink}</th><th>{$lang.controller.labelGroup}</th><th width="140"></th></tr>
                </thead>
                <tbody>
                {foreach from=$listCategoryAds item=catads}
                    {if !empty($catads)}
                    <tr>
                        <td><img src="{$catads->getSmallImage()}" /></td><td>{$catads->name}</td><td>{$catads->title}</td>
                        <td>{$catads->link}</td>
                        <td>{if !empty($catads->objcategory->name)}{$catads->objcategory->name}{/if}</td>
                        <td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$catads->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
                                <a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$catads->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
                        </td>
                    </tr>
                    {/if}
                {/foreach}
                </tbody>
            </table>
    {/if}
    </div>
    
<!--<div class="table table-striped" id="addchildcategoryads">
    <form action="" method="post" name="mysubform" id="mysubform" class="form-horizontal" enctype="multipart/form-data">
        <div class="control-group">
            <label class="control-label" for="fpcid">{$lang.controller.labelGroup}</label>
            <div class="controls">
                <select name="fgroup" id="fgroup" style="width:200px;">
                {foreach from=$productcategoryList item=productCategory}
                    <option value="{$productCategory->id}"{if $newFormData.fgroup==$productCategory->id} selected="selected"{/if}>{$productCategory->name}</option>
                {/foreach}
                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
            <div class="controls"><input type="file" name="fimage" id="fimage" class="input-xlarge"></div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="fnamesub">{$lang.controller.labelName} <span class="star_require">*</span></label>
            <div class="controls"><input type="text" name="fnamesub" id="fnamesub" value="{$newFormData.fnamesub}" class="input-xxlarge"></div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="flink">{$lang.controller.labelLink} <span class="star_require">*</span></label>
            <div class="controls"><input type="text" name="flinksub" id="flinksub" value="{$newFormData.flinksub}" class="input-xxlarge"></div>
        </div>

        <div class="control-group">
            <label class="control-label" for="ftitle">{$lang.controller.labelTitle}</label>
            <div class="controls"><input type="text" name="ftitlesub" id="ftitlesub" value="{$newFormData.ftitlesub}" class="input-xxlarge"></div>
        </div>
        <div class="control-group">
            <label class="control-label" for="ftitle"></label>
            <div class="controls"><input type="submit" name="fsubsubmit" value="{$lang.controller.head_add}" class="btn btn-large btn-primary" /> <span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span></div>
        </div>    
    </form> 
</div>-->
<div id="upload"></div>
{/if*}
{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            var dataJson = '';
            var dataEdit = '';
            var adsID = $('#ftextextSlug').val();

            $.get('/cms/ads/getslugajax', function(data) {
                dataJson=data;

            });
            $.get('/cms/ads/getslugajaxbyid?id='+adsID, function(data) {
                dataEdit=data;
                $('#faslug')
                    .textext({
                        plugins : 'tags prompt focus autocomplete arrow',
                        tagsItems: jQuery.parseJSON(dataEdit),
                        prompt : 'Nhập link cần hiện quảng cáo...'

                    }).bind('tagClick', function(e, tag, value, callback)
                    {
                        var newValue = window.prompt('New value', value);
                        if(newValue)
                            callback(newValue);
                    }).bind('isTagAllowed', function(e, data){
                        var formData = $(e.target).textext()[0].tags()._formData,
                                list = eval(formData);
                        // duplicate checking
                        if (formData.length && list.indexOf(data.tag) >= 0) {
                            var message = [ data.tag, 'is already listed.' ].join(' ');
                            alert(message);
                            data.result = false;
                        }
                    }).bind('getSuggestions', function(e, data)
                    {
                        debugger;
                        if(data.query.length>1)
                        {
                            $(".text-dropdown").show();
                            var list = jQuery.parseJSON(dataJson),
                                    textext = $(e.target).textext()[0],
                                    query = (data ? data.query : '') || ''
                                    ;
                            $(this).trigger(
                                    'setSuggestions',
                                    {
                                        result : textext.itemManager().filter(list, query)
                                    }
                            );

                        }
                        else
                            $(".text-dropdown").hide();
                    });
            });
            //if($("#fgroup").length > 0)$("#fgroup").select2();
            //if($("#fgroupmain").length > 0)$("#fgroupmain").select2();
        });
    /*function fileUpload(form, action_url, div_id) {
        // Create the iframe...
        var iframe = document.createElement("iframe");
        iframe.setAttribute("id", "upload_iframe");
        iframe.setAttribute("name", "upload_iframe");
        iframe.setAttribute("width", "0");
        iframe.setAttribute("height", "0");
        iframe.setAttribute("border", "0");
        iframe.setAttribute("style", "width: 0; height: 0; border: none;");

        // Add to document...
        $("#frmupload").append(iframe);
        window.frames['upload_iframe'].name = "upload_iframe";

        iframeId = document.getElementById("upload_iframe");

        // Add event...
        var eventHandler = function () {

                if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
                else iframeId.removeEventListener("load", eventHandler, false);

                // Message from server...
                if (iframeId.contentDocument) {
                    content = iframeId.contentDocument.body.innerHTML;
                } else if (iframeId.contentWindow) {
                    content = iframeId.contentWindow.document.body.innerHTML;
                } else if (iframeId.document) {
                    content = iframeId.document.body.innerHTML;
                }

                 document.getElementById(div_id).innerHTML = content;

                // Del the iframe...
                setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
            }

        if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
        if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);

        // Set properties of form...
        $("#frmupload").attr("target", "upload_iframe");
        $("#frmupload").attr("action", action_url);
        $("#frmupload").attr("method", "post");
        $("#frmupload").attr("enctype", "multipart/form-data");
        $("#frmupload").attr("encoding", "multipart/form-data");

        // Submit the form...
        $("#frmupload").submit();

        // document.getElementById(div_id).innerHTML = "Uploading...";
    }*/
    </script>
{/literal}
