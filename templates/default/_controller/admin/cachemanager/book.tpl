<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Cache Manager</a> <span class="divider">/</span></li>
	<li class="active">Book</li>
</ul>

<div class="page-header" rel="menu_cachemanager_list"><h1>Book Cache</h1></div>
<div class="navgoback">
<a href="{$conf.rooturl_admin}{$controller}">{$lang.default.formBackLabel}</a>
</div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.default.formFormLabel}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			<form action="{$conf.rooturl_admin}cachemanager/book" method="post" name="myform" class="form-inline">
			
			Book ID: <input type="text" name="fbookid" value="{$formData.fbookid}" class="input-mini" />
			<input type="submit" name="fsubmitcheck" value="Get cache info" class="btn btn-primary" />
			
			<input type="submit" name="fsubmitstore" value="Refresh &amp; Store" class="btn btn-primary">
			<input type="submit" name="fsubmitdelete" value="Delete cache" class="btn btn-danger" />
						
			</form>
			
			{if $cachecheckOutput != ''}<pre style="line-height:1.5;">{$cachecheckOutput}</pre>{/if}
		</div><!-- end #tab 1 -->
		
	</div>
</div>




