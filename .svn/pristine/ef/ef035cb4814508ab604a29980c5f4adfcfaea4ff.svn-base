<div id="reviewpage-{$curPage}">

{foreach item=comment from=$comments}
<div class="comment" id="comment-{$comment->id}">
    <div class="avatar"><a name="comment-{$comment->id}" class="tipsy-hovercard-trigger" data-url="{$comment->actor->getHovercardPath()}" href="{$comment->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$comment->actor->fullname}"><img src="{$comment->actor->getSmallImage()}" alt="Avatar" /></a></div>
    <div class="commentdetail">
        <div class="commentor"><a class="tipsy-hovercard-trigger" data-url="{$comment->actor->getHovercardPath()}" href="{$comment->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$comment->actor->fullname}">{$comment->actor->fullname}</a> <span class="time"></span></div>
        <div class="text">{$comment->text|nl2br}</div>
        
        <div class="controlbar">
        	<span class="time relativetime" title="{$comment->datecreated}"></span>
           	{if $me->id > 0}
				|
                {if $me->id == $comment->uid}
                    <a class="remove" href="javascript:void(0)" onclick="user_blogcommentRemove('{$me->getUserPath()}/blogcomment/removeajax/{$comment->id}', {$comment->id})" title="">{$lang.controller.remove}</a>
                {else}
                    <a href="javascript:void(0)" onclick="user_blogcommentReport('{$conf.rooturl}abuse/{$comment->id}?type=blogcomment', '{$lang.controller.abuseTitle}')" title="{$lang.controller.abuseTitle}">{$lang.controller.abuse}</a>
                {/if}
				
				|
				
				<a href="javascript:void(0)" onclick="reviewreply('{$comment->actor->fullname}', '{$comment->actor->screenname}')">{$lang.controller.reply}</a>
				
            {/if}
        </div>
    </div><!-- end .commentdetail -->
</div><!-- end .comment -->
{/foreach}
</div>

{if $totalPage > 1}
{paginateajax count=$totalPage curr=$curPage lang=$paginateLang max=10 urlformat=$paginateUrl}
{/if}
<script type="text/javascript">
	{literal}
	//convert timestamp to relativetime
	$('.relativetime').each(function(){
		var tmp_text = $(this).text();
		if(tmp_text.length == 0)
		{
			$(this).text(relativeTime($(this).attr('title')));
		}
		$(this).show();
	});
	
	$('#reviewpage-{/literal}{$curPage}{literal} .text').each(function(){user_formatCommentText($(this))})
	{/literal}
</script>