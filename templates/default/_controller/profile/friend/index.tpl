<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{if $me->id == $myUser->id}
			{include file="`$smartyControllerGroupContainer`panel-mybox.tpl"}
		{else}
			{include file="`$smartyControllerGroupContainer`panel-userbox.tpl"}
        {/if}    
		
        
         <br class="clear" />
       
		<div id="recommendationfriendholder"></div>
		
		{if $me->id == $myUser->id}
		
		{else}
			<div class="bookbox" id="panellastusing">
				<h2>{$lang.default.lastestBook} {$lang.default.ofTitle} {$myUser->fullname}</h2>
				<div class="bookboxlink">
					<a href="{$myUser->getUserPath()}/book" title="">{$lang.default.viewAll}</a>
				</div>
			</div><!-- end .bookbox -->
		{/if}
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		<div id="userprofileleft">
			<div class="shelf">

				<h1 class="head">{$lang.controller.title}{if $curPage > 1}<span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}</h1>
				
			</div><!-- end .shelf -->
			
			<div class="friendsearchbar">
				<div class="head"></div>
				<div class="right">
					<form method="get" action="{$myUser->getUserPath()}/friend/search">
						<input type="text" name="keyword" value="{$formData.fkeywordFilter}" onfocus="this.value=''" class="textbox" /><input type="submit" class="button" value="{$lang.controller.submitsearch}" />
					</form>
				</div>
			</div>
			<div class="clear"></div>
			
			{if $total > 0}
				<div class="friendrequestgrid">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								
								<tbody>
								
									{foreach item=friend from=$friendList}
					
					
									<tr class="{cycle values=",mf-row-alt"}" id="friend-{$friend->uid_friend}">
										<td class="ff-avatar"><a href="{$friend->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$friend->actor->fullname}"><img src="{$friend->actor->getSmallImage()}" alt="" /></a></td>
										<td class="ff-detail">
											<a href="{$friend->actor->getUserPath()}" class="ff-username" title="{$lang.default.gotoProfileOf} {$friend->actor->fullname}">{$friend->actor->fullname} {assign var=status value=$friend->actor->getOnlinestatus()} <img width="13" height="13" class="sp sp{$status}" src="{$imageDir}blank.png" title="{$status}" alt="{$status}" /></a> 
											{if $me->id > 0 && $me->id != $friend->uid_friend}
												<a style="float:right;" href="javascript:void(0)" onclick="message_formadd('{$me->getUserPath()}/message/addajax/{$friend->actor->id}', '')"><img src="{$imageDir}message/icon_send.gif" alt="{$lang.default.newmessage}" border="0" /></a>
											{/if}
											
											{if $me->id != $friend->uid_friend}
												{if $myUser->id == $me->id}
													<a href="javascript:void(0);" onclick="user_deleteFriend({$friend->uid_friend})" class="ff-buttonbig remove" title="{$lang.controller.deleteTitle}"><span>{$lang.controller.delete}</span></a>
													
												{elseif $me->id > 0 && !in_array($friend->uid_friend, $myFriendIds)}
													<a href="javascript:void(0);" onclick="user_requestFriend({$friend->uid_friend})" class="ff-buttonbigalt request" title="{$lang.controller.requestTitle}"><span>{$lang.controller.request}</span></a>
												{/if}
											{/if}
											<div class="ff-button">
													{if $friend->actor->countBook > 0}<a href="{$friend->actor->getUserPath()}/book" title="">{$friend->actor->countBook} {$lang.default.book}</a>,{/if}
													{if $friend->actor->countSell > 0}<a href="{$friend->actor->getUserPath()}/shop" title="">{$friend->actor->countSell} {$lang.default.bookSellCount}</a>,{/if}
													{if $friend->actor->countFav > 0}<a href="{$friend->actor->getUserPath()}/fav" title="">{$friend->actor->countFav} {$lang.default.bookCountFav}</a>,{/if}
													{if $friend->actor->countReview > 0}<a href="{$friend->actor->getUserPath()}/review" title="">{$friend->actor->countReview} {$lang.default.bookCountReview}</a>,{/if}
													{if $friend->actor->countQuote > 0}<a href="{$friend->actor->getUserPath()}/quote" title="">{$friend->actor->countQuote} {$lang.default.bookCountQuote}</a>,{/if}
													
											</div>
										</td>
									</tr>
									{/foreach}
								</tbody>
								
							</table>
							
							
							
						</div><!-- end of id:mainform-body -->
						<div id="mainform-fixfloat">&nbsp;</div>
						
					</div>
					
				</div>
				
				
				<div class="cl"></div>
				{assign var="pageurl" value="page-::PAGE::"}
				{paginate count=$totalPage curr=$curPage lang=$paginateLang max=6 url="`$paginateurl``$pageurl``$paginatesuffix`"}
			{else}
				<div style="text-align: center;padding:50px 0;">{$lang.controller.empty}. </a></div>
			{/if}
		

		</div><!-- end #userprofileleft -->
        
		
		
	</div><!-- end #panelright -->
    
	{if $me->id == $myUser->id}
	
		{literal}
		<script type="text/javascript">
		$(document).ready(function()
		{
			user_recommendLoad('full');
		});
		
		
		</script>
		{/literal}
	{else}
		{literal}
		<script type="text/javascript">
		$(document).ready(function()
		{		
			user_panelLastUsing(0);
		});
		
		
		</script>
		{/literal}
	{/if}
	
    
    
    