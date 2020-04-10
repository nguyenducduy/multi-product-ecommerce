<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$emailsenderTitle|default:"Email Sender Module"}</title>
<style type="text/css">
	{literal}
	body, table{font-size:12px; background:#fff;}
	*{font-family:Arial, Helvetica, sans-serif;}
	h1{padding:10px 0; text-align:center; margin:0;}

	
	#emailstat{clear:both; padding:10px;}
	.tdleft{text-align:right; font-weight:bold; font-size:14px; }
	.sepline{border-bottom:1px solid #ddd;}
	#sendbutton{font-size:18px; font-weight:bold; padding:10px 30px; cursor:pointer;}
	.typeometer-left{text-align:left;width:300px; margin:auto; background:#f0f0f0; margin-top:5px;}
	.typeometer-bar{background:#09f; width:0; height:20px; -moz-box-shadow: 0px 0px 5px #999;-webkit-box-shadow: 0px 0px 5px #999;box-shadow: 0px 0px 5px #999;}
	.stopsending{font-size:14px; font-weight:bold; background:#000; color:#fff; padding:10px 30px; text-decoration:none; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px;}
	.stopsending:hover{background:#555;}
	{/literal}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>
<body>
<form method="post" action="{$conf.rooturl_admin}newsletter/sender/id/{$myNewsletter->id}">
<input type="hidden" name="ftotal" id="ftotal" value="{$emailstat.total}" />
<input type="hidden" name="ftotal_unsent" id="ftotal_unsent" value="{$emailstat.total_unsent}" />
	<h1>Email Sender</h1>
	<table cellpadding="4" width="100%">
		<tr>
			<td colspan="2"><div class="sepline"></div></td>
		</tr>
		
		{if $sessionTask.start > 0}
			<tr>
				<td colspan="2" align="center" style="font-weight:bold;">{$myNewsletter->subject} <a class="button" href="javascript:void(0)" onclick="window.open('{$conf.rooturl_admin}newsletter/preview/id/{$myNewsletter->id}', 'mywindowpreview','location=1,status=1,scrollbars=1, width=740,height=500');" title="Click here to preview this email">[Preview]</a></td>
			</tr>
			
			<tr><td colspan="2"><div class="sepline"></div></td></tr>
			
			<tr>
				<td colspan="2" align="center">
				{if $sessionTask.isfinish == 1}
					<div style="text-align:center; padding:30px; font-size:24px; font-style:italic; color:#3C0;">
						<img src="{$imageDir}newsletter/sentfinish.png" /><br />
					Sent {$sessionTask.total} email{if $sessionTask.total > 1}s{/if} Completed.<br /></div>
					
					<div>Total Time: {$sessionTask.totaltime} seconds.</div>
				{else}
					<div><br /><br /><img src="{$imageDir}newsletter/ajax_indicator.gif" /><br /><br /></div>
					<div style="font-style:italic; color:#ccc;">Sent to {$sessionTask.currentToEmail}.</div>
					<div class="typeometer-left" title="{$sessionTask.sendprocess}%"><div class="typeometer-bar" style="width:{$sessionTask.sendprocess}%"></div></div>
					
					<div style="text-align:center; padding-top:10px; font-size:16px; color:#999;">{$sessionTask.sendcount}/{$sessionTask.total} email{if $sessionTask.total > 1}s{/if} sent.</div></div>
					<br /><br /><br />
					<a href="javascript:void(0)" title="" onclick="stopnext()" class="stopsending">STOP SENDING</a>
					<a href="javascript:void(0)" title="" onclick="gotonext()" class="resumesending" style="display:none;">RESUME SENDING</a>
					
					{literal}
					<script type="text/javascript">
						
						//redirect to next request
						var redirecttimeout = setTimeout("gotonext()", 1000);
						
						function gotonext()
						{
							document.location.href = '{/literal}{$conf.rooturl_admin}newsletter/sender/id/{$myNewsletter->id}?start={$nextStartposition}{literal}';
						}
						
						function stopnext()
						{
							clearTimeout(redirecttimeout);
							$('.stopsending').hide();
							$('.resumesending').show();
						}
					
					</script>
					{/literal}
				{/if}
				</td>
			</tr>
		{else}
		<tr>
			<td class="tdleft" width="150">SUBJECT</td>
			<td>{$myNewsletter->subject} <a class="button" href="javascript:void(0)" onclick="window.open('{$conf.rooturl_admin}newsletter/preview/id/{$myNewsletter->id}', 'mywindowpreview','location=1,status=1,scrollbars=1, width=740,height=500');" title="Click here to preview this email">[Preview]</a></td>
		</tr>
		
		
		<tr>
			<td class="tdleft">TO</td>
			<td>
				{if $emailstat.total != $emailstat.total_unsent || $emailstat.total_unsent == 1}
				<label><input onClick="togglesendlimit()" type="radio" name="flimitrecord" {if $formData.flimitrecord == 'all'}checked="checked"{/if} id="flimitrecordall" value="all" />
					{if $emailstat.sendtype == 'group'}
						<strong>{$emailstat.total}</strong> selected email{if $emailstat.total > 1}s{/if}
					{else}
						All <strong>{$emailstat.total}</strong> email{if $emailstat.total > 1}s{/if}
					{/if}
					<span style="color:#ccc;">x <strong>{$emailstat.length|money_format}</strong> Bytes/email = <strong>{$emailstat.lengthtotal|money_format}</strong> Bytes ~ <strong>{$emailstat.lengthtotalInMB} MB</strong><br /></span>
				</label>
				{/if}
				
				
				<label><input onClick="togglesendlimit()" type="radio" name="flimitrecord" {if $formData.flimitrecord == 'unsent' OR $formData.fsubmit == ''}checked="checked"{/if} value="unsent" />
					{if $emailstat.sendtype == 'group'}
						<strong>{$emailstat.total_unsent}</strong> selected UN-SENT email{if $emailstat.total_unsent > 1}s{/if}
					{else}
						All <strong>{$emailstat.total_unsent}</strong> UN-SENT email{if $emailstat.total_unsent > 1}s{/if}
					{/if}
					<span style="color:#ccc;">x <strong>{$emailstat.length|money_format}</strong> Bytes/email = <strong>{$emailstat.lengthtotal_unsent|money_format}</strong> Bytes ~ <strong>{$emailstat.lengthtotalInMB_unsent} MB</strong></span>
				</label>
			</td>
		</tr>
		<tr><td colspan="2"><div class="sepline"></div></td></tr>
		
		<tr style="color:#C30">
			<td class="tdleft">SEGMENT</td>
			<td>

				<label><input type="radio" name="fgrouptype" {if $formData.fgrouptype == 1 OR $formData.fsubmit == ''}checked="checked"{/if} value="1" />Send 1 Email for each Request </label><br />
				<label><input type="radio" name="fgrouptype" {if $formData.fgrouptype == 2}checked="checked"{/if} value="2" />Send <input type="text" name="fsegmentsize" id="fsegmentsize" size="2" value="{$formData.fsegmentsize|default:$emailstat.segmentsize}" /> Emails for each Request (Sending group using BCC mail) </label>

				
				
			
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<input id="sendbutton" type="submit" title="Click here to start sending email using above settings" name="fsubmit" value="SEND NOW" />
			</td>
		</tr>
		{/if}
		
	</table>
</form>
{literal}
<script type="text/javascript">
	
	
	
</script>
{/literal}
</body>
</head>