<h1>DELETE PRODUCT</h1>
{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
<form action="" method="post" enctype="multipart/form-data">
	File <input type="file" name="ffile" id="ffile"  /><br/>
	<input type="submit" name="fsubmit" value="Delete" class="btn btn-primary" />
</form>