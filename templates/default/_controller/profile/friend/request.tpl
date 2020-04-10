<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-mybox.tpl"}
            
            
		
         <br class="clear" />
       
		
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<ul id="msgtab">
			<li><a href="{$me->getUserPath()}/message">{$lang.default.privatemessage}</a></li>
			<li><a class="selected" href="{$me->getUserPath()}/friend/request" title="">{$lang.default.mFriendRequest}{if $curPage > 1}<span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}</a></li>
			<li><a href="{$me->getUserPath()}/notification">{$lang.default.bottombarNotificationHeading}</a></li>
		</ul>
		
		
			
			
			{if $total > 0}
				<div class="friendrequestgrid">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								
								<tbody>
								
									{foreach item=request from=$requestList}
					
					
									<tr class="{cycle values=",mf-row-alt"}" id="friend-{$request->uid}">
										<td class="ff-avatar"><a href="{$request->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$request->actor->fullname}"><img src="{$request->actor->getSmallImage()}" alt="" /></a></td>
										<td class="ff-detail">
											<a href="{$request->actor->getUserPath()}" class="ff-username" title="{$lang.default.gotoProfileOf} {$request->actor->fullname}">{$request->actor->fullname} {assign var=status value=$request->actor->getOnlinestatus()} <img width="13" height="13" class="sp sp{$status}" src="{$imageDir}blank.png" title="{$status}" alt="{$status}" /></a> 
											<a href="javascript:void(0);" onclick="user_addFriend({$request->uid})" class="ff-buttonbigalt request" title="{$lang.controller.acceptTitle}"><span>{$lang.controller.accept}</span></a>
											<a href="javascript:void(0);" onclick="user_deleteRequest({$request->uid})" class="ff-buttonbig remove" title="{$lang.controller.denyTitle}"><span>{$lang.controller.deny}</span></a>
											
											<div class="ff-button">
													<a href="{$request->actor->getUserPath()}/book" title="">{$request->actor->countBook} {$lang.default.book}</a>,
													<a href="{$request->actor->getUserPath()}/review" title="">{$request->actor->countReview} {$lang.default.bookCountReview}</a>,
													<a href="{$request->actor->getUserPath()}/quote" title="">{$request->actor->countQuote} {$lang.default.bookCountQuote}</a>
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
				<div style="text-align: center;padding:50px 0;">{$lang.controller.emptyRequest}. </a></div>
			{/if}
				

		
		
		
	</div><!-- end #panelright -->
    
    
    
    
    
    