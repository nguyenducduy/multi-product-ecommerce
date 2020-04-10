
		
<div class="page-header" rel="menu_notification"><h1>{$lang.controller.title}</h1></div>
			
<div id="notificationlist">
{if $total > 0}
	
	{foreach item=notificationgroup key=dategroup from=$notificationGroups}
		<div class="dategroup">
			{$dategroup}
		</div>
		{foreach item=notification from=$notificationgroup}
			<div class="notificationitem" id="notification-{$notification->id}">
				<div class="avatar"><a href="{$notification->actor->getUserPath()}" title="{$lang.controller.notificationUserTitle} {$notification->actor->fullname}"><img src="{$notification->actor->getSmallImage()}" alt="" /></a></div>
				<div class="info">
					{$notification->showDetail()}
				</div>
			</div><!-- end .notification_item -->
		{/foreach}
	{/foreach}
	<div class="cl"></div>
	{assign var="pageurl" value="page-::PAGE::"}
	{paginate count=$totalPage curr=$curPage lang=$paginateLang max=6 url="`$paginateurl``$pageurl``$paginatesuffix`"}
{else}
	<div style="text-align: center;padding:50px 0;">{$lang.controller.empty}. </a></div>
{/if}
</div><!-- end #notificationlist -->
	
			
