<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sitemap</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_sitemap"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.sitemapEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName}</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fchangefreq">{$lang.controller.labelChangefreq}</label>
		<div class="controls">
		<select name="fchangefreq" id="fchangefreq">
              {html_options options=$changefregList selected=$formData.fchangefreq}
                          
            </select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpriority">{$lang.controller.labelPriority}</label>
		<div class="controls">
		 <select name="fpriority" id="fpriority">
              <option value="0.0"{if '0.0' == {$formData.fpriority}}selected="selected"{/if}>0.0</option>
              <option value="0.1"{if '0.1' == {$formData.fpriority}}selected="selected"{/if}>0.1</option>
              <option value="0.2"{if '0.2' == {$formData.fpriority}}selected="selected"{/if}>0.2</option>
              <option value="0.3"{if '0.3' == {$formData.fpriority}}selected="selected"{/if}>0.3</option>
              <option value="0.4"{if '0.4' == {$formData.fpriority}}selected="selected"{/if}>0.4</option>
              <option value="0.5"{if '0.5' == {$formData.fpriority}}selected="selected"{/if}>0.5</option>
              <option value="0.6"{if '0.6' == {$formData.fpriority}}selected="selected"{/if}>0.6</option>
              <option value="0.7"{if '0.7' == {$formData.fpriority}}selected="selected"{/if}>0.7</option>
              <option value="0.8"{if '0.8' == {$formData.fpriority}}selected="selected"{/if}>0.8</option>
              <option value="0.9"{if '0.9' == {$formData.fpriority}}selected="selected"{/if}>0.9</option>
              <option value="1.0"{if '1.0' == {$formData.fpriority}}selected="selected"{/if}>1.0</option>
             
            </select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flastchanged">{$lang.controller.labelLastchanged}</label>
		<div class="controls"><input type="text" name="flastchanged" id="flastchanged" value="{$formData.flastchanged|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

