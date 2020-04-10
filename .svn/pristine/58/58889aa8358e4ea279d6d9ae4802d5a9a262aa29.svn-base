<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$friendList|@count}</count>
	{if $friendList|@count > 0}
		{foreach item=friend from=$friendList}
			<user>
            	<id>{$friend->actor->id}</id>
                <fullname><![CDATA[{$friend->actor->fullname}]]></fullname>
                <avatar>{$friend->actor->getSmallImage()}</avatar>
                <userurl>{$friend->actor->getUserPath()}</userurl>
                <hovercardurl>{$friend->actor->getHovercardPath()}</hovercardurl>
				<status>{$friend->actor->getOnlinestatus()}</status>
			</user>
		{/foreach}
		
	{/if}
</result>