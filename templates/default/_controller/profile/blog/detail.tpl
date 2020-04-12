<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		
		
        
		{include file="`$smartyControllerGroupContainer`panel-userbox.tpl"}
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<div id="blogdetail" class="shelf">
			{if $myUser->ispage()}
				<h1 class="head"><a href="{$myUser->getUserPath()}/article" title="{$lang.controller.titleArticle}">{$lang.controller.titleArticle}</a> &raquo; {$myBlog->title}</h1>
			{else}
				<h1 class="head"><a href="{$myUser->getUserPath()}/blog" title="{$lang.controller.titleBlog}">{$lang.controller.titleBlog}</a> &raquo; {$myBlog->title}</h1>
			{/if}
			            
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<div class="blogcontents">
				{if $myBlog->image != '' && $myBlog->imageintext == 1}<div class="blogimage"><a href="{$myBlog->getBlogPath()}" title=""><img src="{$myBlog->getImage()}" alt="{$myBlog->image}" /></a></div>{/if}
				<div class="text">
					{$myBlog->contents}
				</div>
				
				{if $tagbookList|@count > 0}
					<div class="sbookgrid">
					<form id="bookgridform" method="post" action="">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								<thead>
									<tr>
										<th class="bf-cover" colspan="4">{$lang.controller.tagbookListTitle}</th>
										
										
									</tr>
								</thead>
								<tbody>
								
									{foreach name=booklist item=book from=$tagbookList}
									<tr class="{cycle values=",mf-row-alt"}">{assign var=bookurl value=$book->getBookPath()}
										<td class="bf-cover"><a href="{$bookurl}" title="{$book->title}"><img src="{$book->getSmallImage()}" alt="{$book->title}" /></a></td>
										<td class="bf-title">
											<a href="{$bookurl}" title="{$book->title} - {$lang.default.coverPrice}: {$book->price|formatprice}">{$book->title}</a> 
											<div class="bf-author">{$book->author}</div>
											<div class="bf-price"></div>
										</td>
										<td class="bf-rating">{if $book->rating > 0}<img class="sp sprating sprating{$book->getRatingRound()}" src="{$imageDir}blank.png" alt="Rating: {$book->rating}" />{/if}</td>
										<td class="bf-stats">
											{if $book->countUsing > 0}
												<a href="{$bookurl}?rel=using" title="{$book->countUsing} {$lang.default.bookCountUsing}">
													<img class="sp sp16 spusersgrey" src="{$imageDir}blank.png" alt="{$lang.default.bookCountUsing}" /><span>{$book->countUsing}</span></a>										
											{else}
												<a href="#" title=""><img src="{$imageDir}blank.png" alt="" /><span>&nbsp;</span></a>
											{/if}
                                            
                                            {if $book->countSelling > 0}
												<a href="{$bookurl}?rel=sell" title="{$book->countSelling} {$lang.default.bookCountSelling}">
													<img class="sp sp16 spbasketgrey" src="{$imageDir}blank.png" alt="{$lang.default.bookCountSelling}" /><span>{$book->countSelling}</span></a>										
											{else}
												<a href="#" title=""><img src="{$imageDir}blank.png" alt="" /><span>&nbsp;</span></a>
											{/if}
											
											{if $book->countFav > 0}
												<a href="{$bookurl}?rel=fav" title="{$book->countFav} {$lang.default.bookCountFav}">
													<img class="sp sp16 spheartsgrey" src="{$imageDir}blank.png" alt="{$lang.default.bookCountFav}" /><span>{$book->countFav}</span></a>										
											{else}
												<a href="#" title=""><img src="{$imageDir}blank.png" alt="" /><span>&nbsp;</span></a>
											{/if}
											
											{if $book->countReview > 0}
												<a href="{$bookurl}#comment" title="{$book->countReview} {$lang.default.bookCountReview}">
													<img class="sp sp16 spcommentsgrey" src="{$imageDir}blank.png" alt="{$lang.default.bookCountReview}" /><span>{$book->countReview}</span></a>										
											{else}
												<a href="#" title=""><img src="{$imageDir}blank.png" alt="" /><span>&nbsp;</span></a>
											{/if}
											
											{if $book->countQuote > 0}
												<a href="{$bookurl}#quote" title="{$book->countQuote} {$lang.default.bookCountQuote}">
													<img class="sp sp16 spquotegrey" src="{$imageDir}blank.png" alt="{$lang.default.bookCountQuote}" /><span>{$book->countQuote}</span></a>										
											{else}
												<a href="#" title=""><img src="{$imageDir}blank.png" alt="" /><span>&nbsp;</span></a>
											{/if}
										</td>
										
									</tr>
									{/foreach}
									
									
									
								</tbody>
								
							</table>
							
							
							
							
							
						</div><!-- end of id:mainform-body -->
						<div id="mainform-fixfloat">&nbsp;</div>
						
					</div>
					</form>
					</div>
				{/if}
				
				<div class="controller">
					<div class="controller_left">
						{$lang.controller.author}: <a href="{$myBlog->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$myBlog->actor->fullname}">{$myBlog->actor->fullname}</a>, {$lang.controller.datecreated}{$myBlog->datecreated|date_format:$lang.global.dateFormatSmarty} , {$lang.controller.view}: {$myBlog->view}
					</div>
					<div class="controller_right">
						{if $me->id > 0}
							{if $me->id == $myBlog->uid}
								<a href="{$me->getUserPath()}/blog/edit/{$myBlog->id}" title="{$lang.controller.editTitle}">{$lang.controller.editTitle}</a> | 
								<a class="remove" href="javascript:void(0);" onclick="delm('{$me->getUserPath()}/blog/delete/{$myBlog->id}?token={$smarty.session.securityToken}')" title="{$lang.controller.deleteTitle}">{$lang.controller.delete}</a>
							{elseif $myUser->ispage() && $myPage->isadmin()}
								<a href="{$myUser->getUserPath()}/article/edit/{$myBlog->id}" title="{$lang.controller.editTitle}">{$lang.controller.editTitle}</a> | 
								<a class="remove" href="javascript:void(0);" onclick="delm('{$myUser->getUserPath()}/article/delete/{$myBlog->id}?token={$smarty.session.securityToken}')" title="{$lang.controller.deleteTitle}">{$lang.controller.delete}</a>
							{else}
								<a href="javascript:void(0)" onclick="user_blogReport('{$conf.rooturl}abuse/{$myBlog->id}?type=blog', '{$lang.controller.abuseTitle}')" title="{$lang.controller.abuseTitle}">{$lang.controller.abuse}</a>
							{/if}
						{/if}
					</div>
				</div>
				<div class="cl"><br /></div>
				
			</div><!-- end .blogcontents -->
        	
		</div><!-- end .shelf -->
		
		
		
		<div id="share-bookmark">
			<div class="title">{$lang.controller.sharebookmarkTitle}</div>
			<div class="icon">
				<a href="https://www.facebook.com/share.php?u={$myBlog->getBlogPath()}&amp;t={$myBlog->title|escape:"url"}" title="Share on Facebook" class="sp sptext spbmfacebook">Facebook</a>
				<a href="http://twitter.com/home?status={$myBlog->title|escape:"url"}-{$myBlog->getBlogPath()}" title="Tweet This!" class="sp sptext spbmtwitter">Twitter</a>
				<a href="http://delicious.com/post?url={$myBlog->getBlogPath()}&amp;title={$myBlog->title|escape:"url"}&amp;notes={$myBlog->contents|strip_tags|truncate:400:'..'|escape:"url"}" title="Bookmark on Del.icio.us" class="sp sptext spbmdelicious">Delicious</a>
				<a href="http://buzz.yahoo.com/buzz?targetUrl={$myBlog->getBlogPath()}&amp;headline={$myBlog->title|escape:"url"}&amp;summary={$myBlog->contents|strip_tags|truncate:400:'..'|escape:"url"}&amp;category=lifestyle&amp;assetType=text" title="Yahoo Buzz Up" title="Yahoo Buzz Up" class="sp sptext spbmyahoo">Yahoo Buzz!</a>
				<a href="http://www.google.com/reader/link?url={$myBlog->getBlogPath()}&amp;title={$myBlog->title|escape:"url"}&amp;srcURL={$conf.rooturl}" title="Submit on Google Buzz" class="sp sptext spbmgoogle">Google</a>
				<a href="http://digg.com/submit?phase=2&amp;url={$myBlog->getBlogPath()}&amp;title={$myBlog->title|escape:"url"}" title="Digg this!" class="sp sptext spbmdigg">Digg</a>
			</div>
			<div class="disablenotification{if $showBlogfollowDisable != 1} hide{/if}">
				<a href="javascript:void(0);" onclick="blogfollowDisable({$myBlog->id})" title="{$lang.controller.followDisableTitle}">{$lang.controller.followDisable}</a>
			</div>
		</div>
		
		<a name="comment"></a>
        
		<div id="bookcomment">
			
			<div class="head">
				<h2 class="left">{$lang.controller.commentTitle}</h2>
				<div class="right"><a href="#" title="">{$lang.controller.goToTop}</a></div>
			</div><!-- end .head -->
			<div class="commentlist">
				
				
			</div><!-- end .commentlist -->
            
            
           	<div style="text-align:center" class="emptynotify hide"><em>{$lang.controller.commentEmpty}</em></div> 
            
			
			<div id="commentform" class="myform myformwide stylizedform stylizedform_sub">
			{if $myBlog->opencomment == 1}
				{if $me->id > 0}
					{if $myUser->ispage() == false || ($myUser->ispage() && ($userIsFriend || $myPage->isadmin()))}
					<form id="formcomment" name="form1" method="get" action="">
						<p>{$lang.controller.commentMessageHeading}</p>
						
						<label>{$lang.controller.commentMessage}</label>
						<div class="mentionableinputwrapper">
					 		<textarea class="mentionable" title="" name="fmessage" id="fmessage" cols="30" rows="4"></textarea>
						</div>
						
						<input type="button" class="submit" id="fsubmit" value="{$lang.controller.commentSubmit}" onclick="user_blogcommentAdd({$myBlog->id})" />
												
						<div class="spacer"></div>
				
					</form>
					{else}
						<div>{$lang.controller.pageMemberOnly}</div>
					{/if}
				{else}
					<div>{$lang.controller.commenttoblog}. <a href="{$conf.rooturl}login?redirect={$redirectUrl}" title="">{$lang.default.loginRequired}</a></div>
				{/if}
			{else}
				<div style="color:#F60">{$lang.controller.closecommentwarning}</div>
			{/if}
			</div><!-- end #commentform -->
			
		</div><!-- end #bookcomment -->
	</div><!-- end #panelright -->
	
	
	<script type="text/javascript">
		
		var selectedcomment = "{$smarty.get.selectedcomment}";
		
		//load REVIEW AJAX
		$(document).ready(function()
		{literal}{{/literal}
			
			
			
			user_blogcommentLoad({$myBlog->id}, 1);
					
			
		{literal}});{/literal}
		
		
	
	</script>
    
    