<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$notificationList|@count}</count>
	{if $notificationList|@count > 0}
		{foreach item=notification from=$notificationList}
			<notification>
				<id>{$notification->id}</id>
				<uid>{$notification->actor->id}</uid>
				<avatar>{$notification->actor->getSmallImage()}</avatar>
				<fullname>{$notification->actor->fullname}</fullname>
				<userurl>{$notification->actor->getUserPath()}</userurl>
				<data><![CDATA[{$notification->showDetail()}]]></data>
			</notification>
			
		{/foreach}
	{/if}
</result>