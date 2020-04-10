<div class="page-header"><h1>System Information</h1></div>

<table class="table table-striped">
	<tr>
		<td width="200" class="td_right">Server IP :</td>
		<td>{$formData.fserverip}</td>
	</tr>
	<tr>
		<td class="td_right">Server Name :</td>
		<td>{$formData.fserver}</td>
	</tr>
	<tr>
		<td class="td_right">PHP Version :</td>
		<td>{$formData.fphp}</td>
	</tr>
	
	<tr>
		<td class="td_right">Server Time :</td>
		<td>{$smarty.now|date_format:$lang.default.dateFormatTimeSmarty}</td>
	</tr>
</table>





<div class="clear"></div>