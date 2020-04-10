<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-pagebox.tpl"}
            
		<br class="clear" />
            

		
		
		 
        
    	<div class="bookbox" id="panellastfriend">
            <h2><a href="{$myUser->getUserPath()}/pagelike" title="{$lang.default.viewAll}">{$lang.default.member} ({$myPage->countLike})</a><span class="right"><a class="moredot" href="{$myUser->getUserPath()}/pagelike" title="{$lang.default.viewAll}"><img src="{$imageDir}viewall.png" border="0" /></a></span></h2>
            <div class="bookboxlink">
                
            </div>
        </div><!-- end .bookbox -->
    
	<br class="clear" />
	{if $latestbookList|@count > 0}
	<div class="bookbox">
           <h2><a href="{$myUser->getUserPath()}/book" title="{$lang.default.viewAll}">{$lang.default.mBook}</a><span class="right"><a class="moredot" href="{$myUser->getUserPath()}/book" title="{$lang.default.viewAll}"><img src="{$imageDir}viewall.png" border="0" /></a></span></h2>
		<div class="bookthumblist">
		{foreach item=userbook from=$latestbookList}
		<div class="bookthumb"> 
			<div class="cover"><a class="tipsy-hovercard-trigger" data-url="{$userbook->book->getHovercardPath()}" title="{$userbook->book->title}" href="{$userbook->book->getBookPath()}"><img src="{$userbook->book->getSmallImage()}" alt=""></a></div> 
		</div>
		{/foreach}
		</div>
		<div class="clear"></div>

       </div>
	{/if}
	
     <br class="clear" /> 
        
    	<div class="bookbox" id="panelblog">
            <h2><a href="{$myUser->getUserPath()}/article" title="{$lang.default.viewAll}">{$lang.default.pageArticle}</a><span class="right"><a class="moredot" href="{$myUser->getUserPath()}/article" title="{$lang.default.viewAll}"><img src="{$imageDir}viewall.png" border="0" /></a></span></h2>
            <div class="bookboxlink">
                
            </div>
        </div><!-- end .bookbox -->
		
       
		
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
        <div id="userprofileleft">
			
			<div id="statuswrapper">
        		<div id="statustab">
					<ul>
						<li><a id="statustabstatus" href="javascript:void(0)" onclick="$('#statusboxtext').focus()"  class="selected">{$lang.controller.statusTabStatus}</a></li>
					</ul>
					<div class="cl"></div>
				</div>
			
				<div id="statusbox">
					{if $me->id == 0}
						<textarea disabled="disabled" id="statusboxtext" rows="1" cols="20">{$lang.default.statusboxLoginWarning}</textarea>
					{elseif $userIsFriend == 0}
						<textarea disabled="disabled" id="statusboxtext" rows="1" cols="20">{$lang.default.mPageLikeRequired}</textarea>
					{elseif $myPage->checkpermission('addstatus') == false}
						<textarea disabled="disabled" id="statusboxtext" rows="1" cols="20">{$lang.default.mPagePermissionRequired}</textarea>
					{else}
						{assign var=canaddstatus value=1}
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
                    
                    {/if}
					<div class="statuscontrol">
						{if $canaddstatus == 1}
						<div class="sright">
							<input id="statusboxSubmitButton" type="button" value="{$lang.default.statusboxButton}" onclick="user_statusadd('status')" />
						</div>
						{/if}
						
						<div class="sleft">
                        	{if $canaddstatus == 1 && $myPage->checkpermission('addlink')}
                            	
								<a href="javascript:void(0)" onclick="$('#statusbox #statusbox_link').show();$('#statusbox #statusbox_link #url').focus();$('#statusbox #statusbox_link_trigger').hide();" id="statusbox_link_trigger" title="">{$lang.default.statusboxAddLinkText}</a>
                            {/if}
						</div>
					</div>
				</div><!-- end #statusbox -->
			</div><!-- end #statuswrapper -->
				
				
				
				<h2 style="font-weight:normal; background:#f0f0f0; margin:0 10px; padding:5px 10px;">{$lang.default.feedTitle} {$lang.default.ofTitle} {$myUser->fullname}</h2>
				
                <div id="activitybox">
                
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
									<input type="button" title="{$lang.default.feedCommentShowMoreTitle}" onclick="user_feedcomment({$feed->id})" value="{$lang.default.feedCommentShowMore} &raquo;">
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
									
									
									{if $me->id > 0 && $feed->canComment()}<div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser('{$comment->actor->fullname|safejsname}', '{$comment->actor->id}',  {$feed->id})" title="{$lang.default.feedReplyToUserTitle} {$comment->actor->fullname}">{$lang.default.reply}</a></div>{/if}
									
									
									
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
                <span class="hide" id="activitynextpage">2</span>
                </div><!-- end #activitybox -->
                <div id="activitymore"><a href="javascript:void(0)" onclick="user_feedMore(0)" title="{$lang.controller.feedMoreTitle}">{$lang.default.feedMore}</a></div>
        </div><!-- end #userprofileleft -->
        
		
	</div><!-- end #panelright -->
    
    {literal}
    <script type="text/javascript">
	$(document).ready(function()
	{
		//$('#statusboxtext').autoResize({limit : 400});
		
		//xu ly url trong cac status text
		user_formatStatusText('.statustext');
		//truncate by height
		
		//disable truncate because bug on formattext
		if(false)
		$('#activitybox .statustext').each(function(){
			$(this).ThreeDots({max_rows:4, ellipsis_string:'<span class="threedots_ellipsis_wrapper">...<br /><a class="unshorten" href="javascript:void(0)" onclick="user_unshorten(event)">Xem &#273;&#7847;y &#273;&#7911;</a></span>'});
			
		});
		
		
		user_formatCommentText('.commenttext');
		user_panelBlog();

		user_panelLastFan();
		
		{/literal}
		{if $myPageLike->id > 0 && $myPageLike->notification > 0}
			user_fanpageresetnotification();
		{/if}
		{literal}
		
		//binding inview to load more feed
		user_feedmoreinview();
	
		feedPostProcess();
	});
	
	
	</script>
    {/literal}
    
    
    