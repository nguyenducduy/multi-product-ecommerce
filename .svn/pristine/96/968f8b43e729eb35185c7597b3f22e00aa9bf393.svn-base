<div class="hovercard-user">
	<div class="hcu-left">
		<div class="hcu-avatar"><a href="{$myPartner->getUserPath()}" title=""><img src="{$myPartner->getSmallImage(1)}" /></a></div>
		{if $myPartner->id != $me->id}
		<div class="hcu-newmessage">
			<a href="{$conf.rooturl_profile}message/add?uid={$myPartner->id}" onclick="$('.tipsy').remove();"><img src="{$imageDir}button-send-message.png" alt="{$lang.controller.newmessage}" border="0" /></a>
		</div>
		{/if}
	</div>
	<div class="hcu-right">
		<div class="hcu-fullname"><a href="{$myPartner->getUserPath()}">{$myPartner->fullname}</a></div>
		<div class="hcu-summary">
			<a href="{$myPartner->getUserPath()}/following" title="">{$myPartner->countFollowing} Following</a> &middot;
			<a href="{$myPartner->getUserPath()}/follower" title="">{$myPartner->countFollower} Follower</a> &middot;
		</div>
		
	
		{if $totalMutualfriend > 0}
		<div class="hcu-mutual">
			<div class="hcu-label">{$lang.controller.sameHavePrefix} {$totalMutualfriend} {$lang.controller.samefriendLabel} {if $mutualfriendlink == 1}<a href="javascript:void(0);" onclick="$('.tipsy').remove();user_mutualdetail('{$me->getUserPath()}/recommendation/samefriendajax/{$myPartner->id}', '{$lang.controller.mutualfrienddetail} {$myPartner->fullname|escape:"html"}')">{$lang.default.viewAll}</a>{/if}</div>
			<div class="userlist">
				{foreach item=user from=$mutualfriendlist}
					<a href="{$user->getUserPath()}" title="{$user->fullname}" class="user"><img src="{$user->getSmallImage()}" /></a>
				{/foreach}
			</div>
		</div>
		{/if}
			
	</div>
	
</div>
<div class="clear"></div>