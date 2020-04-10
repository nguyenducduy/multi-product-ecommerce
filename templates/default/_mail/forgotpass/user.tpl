{include file="`$smartyMailContainerRoot`header.tpl"}
{if $myUser->fullname != ''}<p>Hi {$myUser->fullname},</p>{/if}
<p>Your request to recovery password at {$datecreated}</p>
<p>Account:</p>
<p>&nbsp;&nbsp;Email: <b>{$myUser->email}</b></p>

{if $activatedCode neq ''}
	<p>Click this link <a href="{$conf.rooturl}forgotpass?sub=reset&amp;email={$myUser->email}&amp;code={$activatedCode}">{$conf.rooturl}forgotpass?sub=reset&amp;email={$myUser->email}&amp;code={$activatedCode}</a> and type your new password to reset your password.</p>
    
{/if}
{include file="`$smartyMailContainerRoot`footer.tpl"}