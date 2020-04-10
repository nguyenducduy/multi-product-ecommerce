<a class="pull-right btn btn-success" href="{$conf.rooturl_profile}message/add"><i class="icon-envelope"></i> {$lang.controller.createtitle}</a>


<div class="page-header" rel="menu_message"><h1>{$lang.controller.title}</h1></div>

<div id="msgwrapper">

	<div id="msgtopbutton">
		<a id="msgmanager" href="javascript:void(0)" onclick="$('.msgdelete').toggle();$('#msgdeleteform').toggle();">{$lang.controller.manager}</a>
		
		<a id="msgbackall" href="{$conf.rooturl_profile}message">{$lang.controller.viewallmessage}</a>
	</div>
	
	<form method="post" action="">
	<input type="hidden" name="ftoken" value="{$smarty.session.messagedeleteToken}" />
	<div id="msgdetail">
		{if $myMessageText->id > 0}
		<div class="msgitem" id="msgparent-{$myMessage->id}">
			{if $replyList|@count > 0}<div class="msgdelete"><input type="checkbox" name="fdeletemessage[]" value="{$myMessage->id}" /></div>{/if}
			<div class="msgavatar"><a href="{$myMessage->actor->getUserPath()}"><img src="{$myMessage->actor->getSmallImage()}" /></a></div>
			<div class="msgtime">{$myMessage->datecreated|date_format:"%H:%M, %d/%m/%Y"}</div>
			<div class="msgtext">
				<div class="msgfullname"><a href="{$myMessage->actor->getUserPath()}">{$myMessage->actor->fullname}</a>{if $myMessage->uidfrom == $me->id} <img src="{$imageDir}message/send.gif" alt="&raquo;" /> <a href="{$myPartner->getUserPath()}">{$myPartner->fullname}</a> <img src="{$myPartner->getSmallImage()}" width="30" />{/if}</div>
				<p>{$myMessageText->text|nl2br}</p>
			</div>
		</div>
		{/if}
		
		{foreach item=reply from=$replyList}
			{if $reply->uid == $me->id}{assign var=replyactor value=$me}{else}{assign var=replyactor value=$myPartner}{/if}
			<div class="msgitem" id="msgreply-{$reply->id}">
				<div class="msgdelete"><input type="checkbox" name="fdelete[]" value="{$reply->id}" /></div>
				<div class="msgavatar"><a href="{$replyactor->getUserPath()}"><img src="{$replyactor->getSmallImage()}" /></a></div>
				<div class="msgtime">{$reply->datecreated|date_format:"%H:%M, %d/%m/%Y"}</div>
				<div class="msgtext">
					<div class="msgfullname"><a href="{$replyactor->getUserPath()}">{$replyactor->fullname}</a></div>
					<p>{$reply->text|nl2br}</p>
				</div>
			</div>
		
		{/foreach}
	</div>
	
	<div id="msgdeleteform">
		
		<input class="deleteall" type="submit" name="fsubmitdeleteall" value="{if $replyList|@count > 0}{$lang.controller.deleteallandreply}{else}{$lang.controller.deleteall}{/if}" />
		{if $replyList|@count > 0}<input type="submit" name="fsubmitdeleteselected" value="{$lang.controller.deleteselected}" />{/if}
	</div>
	</form>
	
	<div id="msgreplyform">
		<form>
		<input type="hidden" name="fsubmitreply" value="1" />
		<input type="hidden" name="ftoken" value="{$smarty.session.messagereplyToken}" />
		<label>{$lang.controller.replymessage}</label>
		<textarea name="fmessage" id="fmessage" cols="30" rows="4"></textarea>
		<input type="button" class="" id="fsubmit" value="{$lang.controller.replysubmit}" onclick="message_replysend('{$me->getUserPath()}/message/{$myMessage->id}')" />
		</form>	
		
		<div class="clear"></div>
	</div>
	
	
</div>

    
    