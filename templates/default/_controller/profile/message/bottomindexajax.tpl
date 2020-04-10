<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$messageList|@count}</count>
	{if $messageList|@count > 0}
		{foreach item=message from=$messageList}
			<message>
				<id>{$message->id}</id>
				<uid>{$message->actor->id}</uid>
				<avatar>{$message->actor->getSmallImage()}</avatar>
				<fullname>{$message->actor->fullname}</fullname>
				<userurl>{$message->actor->getUserPath()}</userurl>
				<data><![CDATA[<a href="{$message->getMessagePath()}"><strong>{$message->actor->fullname}</strong><br /><span>{$message->summary|truncate:70}</span></a>]]></data>
			</message>
			
		{/foreach}
	{/if}
</result>