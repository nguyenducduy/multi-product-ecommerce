
	
<div id="panelmain">
	
	<div id="statuswrapper">
      		
		<div id="statusbox">
              {if $me->id > 0}
				<textarea id="statusboxtext" class="mentionable mentionable_status" rows="1" cols="20" onfocus="if($('#statusboxtext').val() == '{$lang.default.statusboxTitle} {$myUser->fullname}') $('#statusboxtext').val('')">{$lang.default.statusboxTitle} {$myUser->fullname}</textarea>
				<div id="statusbox_link" class="hide">
					<input type="hidden" id="statusbox_link_attach" value="0" />
					<div class="box" align="left">
						<input type="hidden" name="cur_image" id="cur_image" />
						<div class="head">{$lang.default.statusboxAddLinkTitle}</div>
						<div class="close" align="right">
							<div class="closes"><a href="javascript:void(0);" onclick="status_attachlink_close()" title="{$lang.default.statusboxAddLinkCloseTitle}">X</a></div>
						</div>
					
						<br clear="all" /><br clear="all" />
					
						<input type="text" name="url" size="64" id="url" title="http://..." onblur="if($('#url').val().length > 0) status_attachlink_fetch()" />
						<input type="button" name="attach" value="{$lang.default.statusboxAddLinkAttach}" id="attach" onclick="status_attachlink_fetch()" />
						<br clear="all" />
						<div align="center" id="load" style="display:none"><img src="{$imageDir}ajax_indicator.gif" alt="loading..." /></div>
						<div id="loader">
						
						</div>
						<br clear="all" />
					</div>
				</div><!-- end #statusbox_link -->
                  {else}
                	<textarea disabled="disabled" id="statusboxtext" rows="1" cols="20">{$lang.default.statusboxLoginWarning}</textarea>
                {/if}
			<div class="statuscontrol">
				<div class="sright">
					<input id="statusboxSubmitButton" type="button" value="{$lang.default.statusboxButton}" onclick="user_statusadd('status')" />
				</div>
				
				<div class="sleft">
					{if $me->id == 0}
                          	<a href="{$conf.rooturl}login?redirect={$redirectUrl}" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a>
					{else}
						
						<a href="javascript:void(0)" onclick="$('#statusbox #statusbox_link').show();$('#statusbox #statusbox_link #url').focus();$('#statusbox #statusbox_link_trigger').hide();" id="statusbox_link_trigger" title="{$lang.default.statusboxAddLinkText}" class="tipsy-trigger"><img src="{$imageDir}link-current-map.png" alt="Add Link" /></a>
						
						
					{/if}
					
				</div>
			</div>
		</div><!-- end #statusbox -->
	</div><!-- end #statuswrapper -->
	
	
	<h2 style="font-weight:normal; text-transform:uppercase; border-bottom:2px solid #08c; color:#08c; margin:10px 0; padding:10px 0;">{$lang.default.feedTitle} {if $myUser->isStaff() == false}{$lang.controller.inGroupDepartment} <span class="label label-info">{$myUser->getGroupName()}</span>{else}{$lang.default.ofTitle}{/if} <em>"{$myUser->fullname}"</em></h2>
	
		
		
		
	<div id="activitybox">
            {if $feedList|@count == 0}
				<em>{$lang.controller.emptyactivity}</em>
			{/if}
			
            {foreach name=feedlist item=feed from=$feedList}
            	<div class="act_entry{if $smarty.foreach.feedlist.first} act_enty_first{/if}{if $feed->minify == 1} act_entry_minify{/if}" id="act_entry_{$feed->id}">
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
					<input type="button" title="{$lang.default.feedCommentShowMoreTitle}" onclick="user_feedcomment({$feed->id})" value="{$lang.default.feedCommentShowMore} &raquo;" class="btn">
					<img class="hide" src="{$imageDir}ajax_indicator.gif" />
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
					
					
					
					{if $me->id > 0 && $feed->canComment()}<div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser('{$comment->actor->fullname|safejsname:true}', '{$comment->actor->id}',  {$feed->id})" title="{$lang.default.feedReplyToUserTitle} {$comment->actor->fullname}">{$lang.default.reply}</a></div>{/if}
					
					
					
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
                                    <a href="{$me->getUserPath()}" title="{$lang.default.gotoProfileOf} {$me->fullname}"><img src="{$me->getSmallImage()}" alt="" /></a>
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
            <span class="hide" id="activitynextpage">2</span>
            </div><!-- end #activitybox -->
            <div id="activitymore"><a href="javascript:void(0)" onclick="user_feedMore(0)" title="{$lang.controller.feedMoreTitle}">{$lang.default.feedMore}</a></div>
    </div><!-- end #panelmain -->
    
	<div id="panelsub">
    	<div id="profileinfo"></div>
	</div><!-- end #panelsub -->




   
   {literal}
   <script type="text/javascript">
$(document).ready(function()
{

	//binding inview to load more feed
	user_feedmoreinview();
	
	feedPostProcess();
	user_loadprofile();

});


</script>
   {/literal}
   
   
    