
{foreach name=feedlist item=feed from=$feedList}
    <div class="act_entry{if $smarty.foreach.feedlist.first && $page == 1} act_enty_first{/if}{if $feed->minify == 1} act_entry_minify{/if}" id="act_entry_{$feed->id}">
			<div class="avatar avatarmain"><a class="tipsy-hovercard-trigger" data-url="{$feed->actor->getHovercardPath()}" href="{$feed->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$feed->actor->fullname}"><img src="{$feed->actor->getSmallImage()}" alt="" /></a></div>
		
        <div class="info">
        
            {if $feed->minify == 1}
			<div class="minifyfeedicon"><a class="tipsy-hovercard-trigger" data-url="{$feed->actor->getHovercardPath()}" href="{$feed->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$feed->actor->fullname}"><img class="sp sp16 spfeed{$feed->type} act_entry_avatarfeedicon" src="{$imageDir}blank.png" alt="" /></a></div>
			{/if}
			
			{$feed->showDetail(1)}
            {$feed->showDetailMore(1)}
        </div>
        
        <div class="act_entry_reply{if $feed->minify == 1} hide{/if}">
			{if $feed->numlike > 0}
				{$feed->showLike(true)}
			{/if}
			
            {if $feed->numcomment > $setting.feed.commentShowPerFeed}
               <div class="act_entry_reply_showmore">
					<input type="hidden" id="act_entry_reply_morestart_{$feed->id}" value="{$setting.feed.commentShowPerFeed}" />
					<input type="button" title="{$lang.default.feedCommentShowMoreTitle}" onclick="user_feedcomment({$feed->id})" value="{$lang.default.feedCommentShowMore} &raquo;">
					<span>{$setting.feed.commentShowPerFeed}/{$feed->numcomment}</span>
					
				</div>
            {/if}
            
            {foreach name=feedcomment item=comment from=$feed->comments}
            <div class="act_reply" id="act_reply_{$comment->id}">
                <div class="avatar">
                    <a class="tipsy-hovercard-trigger" data-url="{$comment->actor->getHovercardPath()}" href="{$comment->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$comment->actor->fullname}"><img src="{$comment->actor->getSmallImage()}" alt="" /></a>
                </div>
                <div class="info">
					{if $feed->canDelete($me->id) || $comment->canDelete($me->id)}
						<div class="delete remove_btn"><a href="javascript:void(0)" onclick="feedCommentRemove('{$comment->id}')" title="{$lang.default.feedReplyDeleteTitle}">{$lang.default.delete}</a>&nbsp;&nbsp;</div>
					{/if}
					
					{if $comment->canEdit($me->id)}
						<div class="edit edit_btn">&middot; <a href="javascript:void(0)" onclick="feedCommentEdit_popup('{$comment->id}')" title="{$lang.default.feedReplyEditTitle}">{$lang.default.edit}</a>&nbsp;&nbsp;</div>
					{/if}
					
					
					{if $me->id > 0 && $feed->canComment()}<div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser('{$comment->actor->fullname|safejsname}', '{$comment->actor->id}', {$feed->id})" title="{$lang.default.feedReplyToUserTitle} {$comment->actor->fullname}">{$lang.default.reply}</a></div>{/if}
					
					
					
					
                    <div class="text"><a class="username tipsy-hovercard-trigger" data-url="{$comment->actor->getHovercardPath()}" href="{$comment->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$comment->actor->fullname}">{$comment->actor->fullname}{$comment->actor->getNameIcon()}</a> <span class="datetime relativetime">{$comment->datecreated}</span><br />
                    <span class="commenttext">{$comment->getText()}</span></div>
                    <div class="more">
                        
                    </div>
                </div>
            </div><!-- end .act_reply -->
            {if $smarty.foreach.feedcomment.first}<input type="hidden" id="act_entry_comment_first_{$feed->id}" value="{$comment->id}" />{/if}
            {/foreach}
            
			{if $me->id > 0 && $feed->canComment()}
            	<div class="act_reply act_reply_add{if $feed->canCommentMinimum() && $feed->numcomment == 0} hide{/if}">
                 
                    <div class="avatar">
                        {if $myPage->uid_creator == $me->id}
							<a href="{$myUser->getUserPath()}" title="{$lang.default.gotoProfileOf} {$myUser->fullname}"><img src="{$myUser->getSmallImage()}" alt="" /></a>
						{else}
							<a href="{$me->getUserPath()}" title="{$lang.default.gotoProfileOf} {$me->fullname}"><img src="{$me->getSmallImage()}" alt="" /></a>
						{/if}
                    </div>
                    <div class="info">
                        
                       <textarea title="{$lang.default.feedReplyTextboxTitle}" class="fmessage mentionable mentionable_feed{$feed->id}" name="" rows="1" cols="10" onfocus="user_onFeedReplyFocus({$feed->id})" onblur="user_onFeedReplyBlur({$feed->id})" onkeypress="user_onFeedReplyKeypress(event, {$feed->id})">{$lang.default.feedReplyDefaultText}</textarea>
                        <input class="button" type="button" value="{$lang.default.feedCommentButton}" onclick="user_feedcommentadd({$feed->id})" />
                    </div>
                
            	</div><!-- end .act_reply -->
			{/if}
        </div>
        
        <div class="clear"></div>
    </div>
{/foreach}