<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$comments|@count}</count>
	<nextstart>{$nextstart}</nextstart>
	<loadedcount>{$loadedcount}/{$myFeed->numcomment}</loadedcount>
	<remaincomment>{$remaincomment}</remaincomment>
	<candelete>{if $myFeed->canDelete($me->id)}1{else}0{/if}</candelete>
	{if $comments|@count > 0}
		{foreach item=comment from=$comments}
			<comment>
				<id>{$comment->id}</id>
				<text><![CDATA[{$comment->getText()}]]></text>
                <datecreated>{$comment->datecreated}</datecreated>
                <poster>{$comment->actor->fullname}</poster>
				<nameicon><![CDATA[{$comment->actor->getNameIcon()}]]></nameicon>
                <userurl>{$comment->actor->getUserPath()}</userurl>
				<hovercardurl>{$comment->actor->getHovercardPath()}</hovercardurl>
                <avatar>{$comment->actor->getSmallImage()}</avatar>
			</comment>
		{/foreach}
	{/if}
</result>