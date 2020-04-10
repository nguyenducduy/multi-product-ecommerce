<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-mybox.tpl"}
            
		<div class="bookbox" id="panellastfriend">
			<h2>{$lang.default.latestFriend}</h2>
			<div class="bookboxlink">
				<a href="javascript:void()" onclick="user_friendsearchprompt('{$lang.controller.searchfriendPopupTitle}')" title="{$lang.controller.searchfriendTitle}">&raquo; {$lang.controller.searchfriend}</a>
			</div>
		</div><!-- end .bookbox -->
			
			
		<div class="bookbox" id="panelmembersearch">
                <h2>{$lang.default.panelSearchMember}</h2>
				<form method="get" action="{$conf.rooturl}member">
					<input type="hidden" name="search" value="1" />
					<input class="textbox tipsy-trigger" title="{$lang.default.panelSearchMemberTooltip}" type="text" name="keyword" value="" /> 
					<input class="button" type="submit" value="{$lang.default.panelSearchMemberSubmit}" />
				</form>
                
            </div><!-- end .bookbox -->
			
		{include file="`$smartyControllerGroupContainer`hotshelf.tpl"}
        
         <br class="clear" />
       
						
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
        <div id="userprofileleft">
        	<h2>{$lang.default.statusboxTitleSelf}</h2>
				<div id="statusbox">
					<textarea id="statusboxtext" rows="1" cols="20"></textarea>
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
					
					<div class="statuscontrol">
						<div class="sleft">
                        	{if $me->id == 0}
                            	<a href="{$conf.rooturl}login?redirect={$redirectUrl}" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a>
							{else}
								<a href="javascript:void(0)" onclick="$('#statusbox #statusbox_link').show();$('#statusbox #statusbox_link #url').focus();$('#statusbox #statusbox_link_trigger').hide();" id="statusbox_link_trigger" title="">{$lang.default.statusboxAddLinkText}</a>
                            {/if}
						</div>
						<div class="sright">
							<input id="statusboxSubmitButton" type="button" value="{$lang.default.statusboxButton}" onclick="user_statusadd()" />
						</div>
					</div>
				</div><!-- end #statusbox -->
				<br />
				<h2>{$lang.default.feedTitleSelf}</h2>
                
                {if $feedList|@count > 0}
					<div id="activitybox">
					{foreach name=feedlist item=feed from=$feedList}
						
						<div class="act_entry{if $smarty.foreach.feedlist.first} act_enty_first{/if}" id="act_entry_{$feed->id}">
							<div class="avatar"><a href="{$feed->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$feed->actor->fullname}" data-url="{$feed->actor->getHovercardPath()}" class="tipsy-hovercard-trigger"><img src="{$feed->actor->getSmallImage()}" alt="" /></a></div>
							<div class="info">
							
								{$feed->showDetail(1)}
								{$feed->showDetailMore(1)}
							</div>
							
							<div class="act_entry_reply">
								{if $feed->numlike > 0}
									{$feed->showLike(true)}
								{/if}
								{if $feed->numcomment > $setting.feed.commentShowPerFeed}
									<div class="act_entry_reply_showmore">
										<input type="button" title="{$lang.default.feedCommentShowMoreTitle}" onclick="user_feedcomment({$feed->id})" value="{$lang.default.feedCommentShowMore} {$feed->numcomment} {$lang.default.feedComment} &raquo;">
										<img class="hide" src="{$imageDir}ajax_indicator.gif" />
									</div>
								{/if}
								
								{foreach name=feedcomment item=comment from=$feed->comments}
								<div class="act_reply" id="act_reply_{$comment->id}">
									<div class="avatar">
										<a class="tipsy-hovercard-trigger" href="{$comment->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$comment->actor->fullname}" data-url="{$comment->actor->getHovercardPath()}"><img src="{$comment->actor->getSmallImage()}" alt="" /></a>
									</div>
									<div class="info">
										{if $me->id > 0 && $feed->canComment()}<div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser('{$comment->actor->fullname}', '{$comment->actor->screenname}', {$feed->id})" title="{$lang.default.feedReplyToUserTitle} {$comment->actor->fullname}">@</a></div>{/if}
										<div class="text"><a class="username tipsy-hovercard-trigger" data-url="{$comment->actor->getHovercardPath()}" href="{$comment->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$comment->actor->fullname}">{$comment->actor->fullname}</a> <span class="datetime relativetime">{$comment->datecreated}</span><br />
										<span class="commenttext">{$comment->text}</span></div>
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
											
											<textarea title="{$lang.default.feedReplyTextboxTitle}" class="fmessage" name="" rows="1" cols="10" onfocus="user_onFeedReplyFocus({$feed->id})" onblur="user_onFeedReplyBlur({$feed->id})" onkeypress="user_onFeedReplyKeypress(event, {$feed->id})">{$lang.default.feedReplyDefaultText}</textarea>
											
											<input class="button" type="button" value="{$lang.default.feedCommentButton}" onclick="user_feedcommentadd({$feed->id})" />
											
										</div>
									
									</div><!-- end .act_reply -->
								{/if}
							</div>
							
							<div class="clear"></div>
						</div>
						
						
					{/foreach}
					<input type="hidden" id="activitynextpage" value="2" />
					</div><!-- end #activitybox -->
					<div id="activitymore"><a href="javascript:void(0)" onclick="user_feedMore(1)" title="{$lang.controller.feedMoreTitle}">{$lang.default.feedMore}</a></div>
				{else}
					<div id="activityempty">{$lang.controller.feedempty} <a href="{$conf.rooturl}member" title="{$lang.controller.feedemptySearchfriendTitle}">{$lang.controller.feedemptySearchfriend}</a></div>
				{/if}
				
        </div><!-- end #userprofileleft -->
        
        <div id="userprofileright">
					
			
			
			
			
			
			
        	<div class="bookbox" id="panellastusing">
                <h2>{$lang.default.lastestBookOnSite}</h2>
                <div class="bookboxlink">
                    <a href="{$conf.rooturl}book" title="">{$lang.default.viewAll}</a>
                </div>
            </div><!-- end .bookbox -->
            
        	<div class="bookbox" id="panelshopsuggest">
                <h2>{$lang.default.mShopSuggest}</h2>
                
                <div class="bookboxlink">
                    <a href="{$conf.rooturl}shop" title="">{$lang.default.viewAll}</a>
                </div>
            </div><!-- end .bookbox -->		            
            
        </div><!-- end #userprofileright -->
		
		
		
	</div><!-- end #panelright -->
    
    {literal}
    <script type="text/javascript">
	$(document).ready(function()
	{
		$('#statusboxtext').autoResize({limit : 400});
				
		//xu ly url trong cac status text
		user_formatStatusText('.statustext');
		user_formatCommentText('.commenttext');
		
		user_recommendLoad();
		user_panelLastFriend('home');
		
		user_panelLastUsing(1);	//load from all books
		user_panelShopSuggest();
		

		
		//request to update all stat of this user
		$.get(meurl + '/home/updatestatajax');
		
		
	
	});
	
	
	</script>
    {/literal}
    
    
    