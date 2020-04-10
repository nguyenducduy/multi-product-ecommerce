<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-userbox.tpl"}
            
            
				
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<div id="userprofileleft">
			<div class="shelf">
				<h1 class="head">{$lang.controller.titleSearch} "<em>{$formData.fkeywordFilter}</em>"</h1>
			</div><!-- end .shelf -->
			
			<div class="friendsearchbar">
				<div class="left"><a href="{$me->getUserPath()}/friend" title="{$lang.controller.returnToFriendlist}">{$lang.controller.returnToFriendlist}</a></div>
				<div class="right">
					<form method="get" action="{$myUser->getUserPath()}/friend/search">
						<input type="text" name="keyword" value="{$formData.fkeywordFilter}" onfocus="this.value=''" class="textbox" /><input type="submit" class="button" value="{$lang.controller.submitsearch}" />
					</form>
				</div>
			</div>
			<div class="clear"></div>
			
			{if $friendList|@count > 0}
				<div class="friendrequestgrid">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								
								<tbody>
								
									{foreach item=friend from=$friendList}
					
					
									<tr class="{cycle values=",mf-row-alt"}" id="friend-{$friend->uid_friend}">
										<td class="ff-avatar"><a href="{$friend->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$friend->actor->fullname}"><img src="{$friend->actor->getSmallImage()}" alt="" /></a></td>
										<td class="ff-detail">
											<a href="{$friend->actor->getUserPath()}" class="ff-username" title="{$lang.default.gotoProfileOf} {$friend->actor->fullname}">{$friend->actor->fullname}</a> 
											
											{if $me->id != $friend->uid_friend}
												<a href="javascript:void(0);" onclick="user_deleteFriend({$friend->uid_friend})" class="ff-buttonbig remove" title="{$lang.controller.deleteTitle}"><span>{$lang.controller.delete}</span></a>
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
				
			{else}
				<div style="text-align: center;padding:50px 0;">{$lang.controller.empty}. </a></div>
			{/if}
				
		</div><!-- end #userprofileleft -->
        
		
		
	</div><!-- end #panelright -->
    
    {literal}
    <script type="text/javascript">
	$(document).ready(function()
	{
	

		
		user_panelLastUsing(0);
		
	
	});
	
	
	</script>
    {/literal}
    
    
    