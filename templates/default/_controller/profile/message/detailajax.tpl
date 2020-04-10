<div id="emailsubject">
	<div class="emailcontrol">
		<a href="javascript:void(0)" onclick="message_detailclose()" class="close"><i class="icon-remove"></i></a>
	</div>
	
	<h2>{$myMessageText->subject}</h2>
	
</div>

<div id="emailpeople">
	<a href="{$mySender->getUserPath()}" class="fromimage tipsy-hovercard-trigger" data-url="{$mySender->getHovercardPath()}"><img src="{$mySender->getSmallImage()}" /></a>
	<a href="{$mySender->getUserPath()}" class="fromname tipsy-hovercard-trigger" data-url="{$mySender->getHovercardPath()}">{$mySender->fullname}</a>
	<span class="recipients"><em>{$lang.controller.to}</em> 
		{foreach name=recipientList item=user from=$fullRecipientList}{if $smarty.foreach.recipientList.first == false},{/if} <a href="{$user->getUserPath()}" class="tipsy-hovercard-trigger" data-url="{$user->getHovercardPath()}">{if $user->id == $me->id}{$lang.controller.tome}{else}{$user->fullname}{/if}</a>{/foreach}.</span>
	<span class="datesent">{$myMessage->datecreated|date_format:"%H:%M, %d/%m"}</span>
</div><!-- end #emailpeople -->

<div id="emailtext">
	{$myMessageText->text}
</div><!-- end #emailtext -->

{if $attachmentList|@count > 0}
<div id="emailattachment">
	<ul>
		{foreach item=attachment from=$attachmentList}
			<li><a href="{$conf.rooturl_profile}message/attachmentdownload?mtid={$attachment->mtid}&fdid={$attachment->fdid}"><span class="label label-success">{$attachment->getExtension()}</span> <b>{$attachment->name}</b> <em>({$attachment->filedrive->getDisplaySize()})</em></a></li>
		{/foreach}
	</ul>
</div><!-- end #emailattachment -->
{/if}

<div id="emailreply">
	{$lang.controller.replytextText} <a href="javascript:void(0)" onclick="message_showadd('{$conf.rooturl_profile}message/add?type=reply&mtid={$myMessageText->id}')">{$lang.controller.replytextReply}</a>{if $recipientList|@count > 1}, <a href="javascript:void(0)" onclick="message_showadd('{$conf.rooturl_profile}message/add?type=replyall&mtid={$myMessageText->id}')">{$lang.controller.replytextReplyall}</a>{/if} {$lang.controller.replytextOr} <a href="javascript:void(0)" onclick="message_showadd('{$conf.rooturl_profile}message/add?type=forward&mtid={$myMessageText->id}')">{$lang.controller.replytextForward}</a>
</div><!-- end #emailreply -->


<div id="emailreplywrapper"></div>