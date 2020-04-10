<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Review</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_reviewqueue_list"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback">
<a href="{$redirectUrl}">{$lang.default.formBackLabel}</a>
</div>




<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.reviewEditToken}" />

	{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
	
	<div class="control-group">
		<label class="control-label" for="fbook">Book</label>
		<div class="controls">
			<a href="{$conf.rooturl_admin}book/edit/id/{$myReview->book->id}" title="Edit this book">{$myReview->book->title}</a>
            <br />
            <img src="{$myReview->book->getSmallImage()}" alt="" width="80" height="120" style="border:1px solid #ccc;" />
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fposter">Poster</label>
		<div class="controls">
			<a href="{$conf.rooturl_admin}user/edit/id/{$myReview->actor->id}" title="Edit this user">{$myReview->actor->fullname}</a>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="ftext">Text <span class="star_require">*</span></label>
		<div class="controls">
			<textarea class="input-xxlarge" rows="10" name="ftext" id="ftext">{$formData.ftext}</textarea>
		</div>
	</div>
	
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
	
</form>





