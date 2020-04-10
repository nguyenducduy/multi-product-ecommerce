<div class="page-header" rel="menu_file"><h1>{$lang.controller.head_add}</h1></div>


<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.fileAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">File Upload</label>
		<div class="controls"><input type="file" name="ffile" id="ffile" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary}</label>
		<div class="controls">
			<textarea name="fsummary" id="fsummary" class="input-xxlarge">{$formData.fsummary}</textarea>
	</div>

	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="Upload" class="btn btn-large btn-primary" />
	</div>	
	
</form>

{if $success|@count > 0}
<script type="text/javascript">
	$(document).ready(function(){
		self.parent.location.reload(false);
	});
</script>
{/if}


