<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Ads</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_ads"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.adsAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

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
		<label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
		<div class="controls"><input type="file" name="fimage" id="fimage" class="input-xlarge"></div>
	</div>

    <div class="control-group">
        <label class="control-label" for="faslug">{$lang.controller.labelSlug} </label>
        <div class="controls"><input type="text" name="faslug" id="faslug" value="{$formData.faslug|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="flink">{$lang.controller.labelLink} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="flink" id="flink" value="{$formData.flink|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	

	<div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle}</label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fwidth">{$lang.controller.labelWidth}</label>
		<div class="controls"><input type="text" name="fwidth" id="fwidth" value="{$formData.fwidth|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fheight">{$lang.controller.labelHeight}</label>
		<div class="controls"><input type="text" name="fheight" id="fheight" value="{$formData.fheight|@htmlspecialchars}" class="input-mini">
			<span>(Zero or Blank if auto-height)</span>
		</div>
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
        <div class="controls"><input class='inputdatepicker' type="text" name="fdatebegin" id="fdatebegin" value="{if $formData.fdateend > 0}{$formData.fdatebegin|@htmlspecialchars}{/if}" ></div>
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
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
</form>

{literal}
    <script type="text/javascript">
          /*$('#fcampaignsource').textext({
                plugins : 'tags prompt focus autocomplete ajax arrow',
                prompt : 'Nhập̣p tag vào nhấn enter...',
                ajax : {
                    url : '',
                    dataType : 'json',
                    cacheResults : true
                },
                 autocomplete: {

              }
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
            }}).bind('getSuggestions', function(e, data) {
                      debugger;
                      $(this).trigger('setSuggestions', { data : [ "item1", "item2" ] });
          });
        */
          var dataJson = '';
          $.get('/cms/ads/getslugajax', function(data) {
              dataJson=data;
          });
          $('#faslug')
                  .textext({
                      plugins : 'tags prompt focus autocomplete arrow',
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
                      if(data.query.length>2)
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
                  })
          ;




    </script>

{/literal}