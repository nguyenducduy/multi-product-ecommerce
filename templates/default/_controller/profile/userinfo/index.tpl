<?xml version="1.0" encoding="utf-8"?>
<result>
	<uid>{$me->id}</uid>
	<userurl>{$me->getUserPath()}</userurl>
	<mygrouplist><![CDATA[
		{foreach item=group from=$followGroupList}
			<li id="menu_group{$group->id}"><a href="{$group->getUserPath()}"><i class="icon-group"></i>{$group->fullname}</a></li>
		
		{/foreach}
		]]></mygrouplist>
	
</result>


