<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		<div id="ebooksamplecontainer"></div>

		<div class="headingbox bookbox">
			<h2>{$lang.controller.sampleList}</h2>
			<div class="owners" id="samplesummary">
				
			</div><!-- end .owners -->
		</div>

		<div class="clear"></div>
		<br /><br />
		<div class="headingbox bookbox">
			<h2><a href="javascript:void(0)" onclick="bookdetailUsing('{$myBook->getBookPath()}', '{$redirectUrl}')" title="{$lang.default.viewAll}">{$lang.controller.ownerList}</a><span class="right"><a class="moredot" href="javascript:void(0)" onclick="bookdetailUsing('{$myBook->getBookPath()}', '{$redirectUrl}')" title="{$lang.default.viewAll}"><img src="{$imageDir}viewall.png" border="0" /></a></span></h2>
			<div class="owners" id="ownersummary">
				
			</div><!-- end .owners -->
		</div>
            
			
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<div id="book" class="shelf" style="margin-bottom:0;">
			<h1 class="head">{$myBook->title}</h1>
            <!-- BOOK_DETAIL_NOTIFY -->
        	
			<div class="shelfrow shelfrowdetail">
				<div class="badge_add_sell hide">
					<a href="{if $me->id > 0}{$myBook->getBookPath()}/book/add?startsell{else}{$conf.rooturl}login?refer=1&amp;redirect={$redirectUrl}{/if}" title="{$lang.controller.sellbookTitle}"><img class="sp spbtnsellbadge" src="{$imageDir}blank.png" alt="{$lang.controller.sellbookImageAlt}" /></a>
				</div>
				
                <div class="cover"><a href="{$myBook->getBookPath()}" title="{$myBook->title}"><img src="{$myBook->getImage()}" alt="{$myBook->title}"  style="" /></a></div>
				<div class="bookinfo">
					<p>
						
						{if $myBook->author != ''}{$lang.default.bookAuthor}: {$myBook->parseAuthorToLink()}<br />{/if}
                        {if $myCategory->id > 0}{$lang.default.bookCategory}: <a href="{$conf.rooturl}book?category={$myCategory->id}" title="{$lang.controller.viewBookFromCategory} {$myCategory->name}">{$myCategory->name}</a><br />	{/if}
						 
						 <!--{if $myBook->rating > 0}{$lang.default.bookRating}: <span id="staticrating"><img class="sp sprating sprating{$myBook->getRatingRound()}" src="{$imageDir}blank.png" alt="Rating: {$myBook->rating}" /></span><br />{/if}-->
						{$lang.default.bookPriceCover}: {if $myBook->price > 0}{$myBook->price|formatprice}{else}{$lang.default.bookPriceCoverNotUpdated}{/if}<br />						
						{$lang.default.bookPublish}: {if $myBook->publisher != ''}{$myBook->publisher}, {/if}{$myBook->publishdate}<br />
						{if $myBook->page > 0}{$lang.default.bookPage}: {$myBook->page}<br />{/if}
						
                       <br />
						
					</p>
				</div><!-- end .bookinfo --> 	
				<div class="posterinfo">
					<div class="subtitle">
						<!--{$myBook->view} {$lang.controller.view}<br />-->
						
						{if $myBook->countUsing > 0}<a id="bookloadusing" href="{$myBook->getBookPath()}?rel=using" title="{$lang.controller.bookUsingTitle}">{$myBook->countUsing} {$lang.default.bookCountUsing}</a><br />{/if}
						{if $myBook->countSelling > 0}<a id="bookloadsell" href="{$myBook->getBookPath()}?rel=sell" title="{$lang.controller.bookSellTitle}">{$myBook->countSelling} {$lang.default.bookCountSelling}</a><br />{/if}
						{if $myBook->countFav > 0}<a id="bookloadfav" href="{$myBook->getBookPath()}?rel=fav" title="{$lang.controller.bookFavTitle}">{$myBook->countFav} {$lang.default.bookCountFav}</a><br />{/if}
						{if $myBook->countReview > 0}<a href="{$myBook->getBookPath()}#comment" title="{$lang.controller.bookReviewTitle}">{$myBook->countReview} {$lang.default.bookCountReview}</a><br />{/if}
						{if $myBook->countQuote > 0}<a href="{$myBook->getBookPath()}#quote" title="{$lang.controller.bookQuoteTitle}">{$myBook->countQuote} {$lang.default.bookCountQuote}</a><br />{/if}
					</div>
					<div class="info">
						
						<div class="editbutton">
                        	
							
							
                            
						</div>
					</div>
				</div><!-- end .posterinfo -->
				
			</div><!-- end .shelfrow, .shelfrowdetail -->
		</div><!-- end .shelf -->
		
		
		<div class="cl"></div>
		
		
		
		<div id="bookcomment">
			
			<div class="head">
				<h2 class="left">{$lang.controller.reviewFromBook}</h2>
				<div class="right"><a href="javascript:void(0)" onclick="popup_reviewadd('{$myBook->getBookPath()}', {$myBook->id})" title="{$lang.controller.reviewAddTitle}">{$lang.controller.reviewAdd}</a></div>
			</div><!-- end .head -->
			<div class="commentlist">
				{foreach item=review from=$reviewList}
				<div class="comment review_wide review_float" id="review-{$review->id}">
				    <div class="avatar"><a href="{$review->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$review->actor->fullname}"><img src="{$review->actor->getSmallImage()}" alt="Avatar" /></a></div>
				    <div class="commentdetail">
				        <div class="commentor"><a href="{$review->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$review->actor->fullname}">{$review->actor->fullname}</a> 
							{assign var=reviewuserid value=$review->uid}
							{if isset($reviewRatings.$reviewuserid)}
								<img class="sp sprating sprating{$reviewRatings.$reviewuserid}" src="{$imageDir}blank.png" alt="Rating: {$reviewRatings.$reviewuserid}" />
							{/if}	

							{if isset($reviewFavs.$reviewuserid)}
								<img class="sp sp16 spheartadd" src="{$imageDir}blank.png" alt="Favourite" />
							{/if}

							 <span class="time"></span></div>
				        <div class="text">{$review->text}</div>
				        {$review->showLike(true)}
				        <div class="controlbar">
				        	<span class="time relativetime" title="{$review->datecreated}"></span>

				            {if $me->id > 0}
								 |
				                {if $me->id == $review->actor->id}
				                    <a class="remove" href="javascript:void(0)" onclick="bookreviewRemove('{$bookpath}/review/removeajax/{$review->id}', {$review->id})" title="">{$lang.controller.reviewRemove}</a>
				                {else}
				                    <a href="javascript:void(0)" onclick="bookreviewReport('{$conf.rooturl}abuse/{$review->id}?type=review', '{$lang.controller.reviewAbuseTitle}')" title="{$lang.controller.reviewAbuseTitle}">{$lang.controller.reviewAbuse}</a>
				                {/if}

								|

								<a href="javascript:void(0)" onclick="reviewreplyToggle({$review->id})">{$lang.controller.reply}</a>
								{if in_array($me->id, $review->likelist) == false}
								|

								<a href="javascript:void(0)" onclick="bookreviewlikeadd({$review->bid}, {$review->id}, 0)" class="like_btn">{$lang.controller.like}</a>
								{/if}

				            {/if}
				        </div><!-- end .controlbar -->
						<div class="replylist">
							{foreach item=reply from=$review->replies}
								<div class="reply" id="review-{$reply->id}">
									<div class="avatar"><a href="{$reply->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$reply->actor->fullname}"><img src="{$reply->actor->getSmallImage()}" alt="Avatar" /></a></div>
								    <div class="commentdetail">
										<div class="commentor"><a href="{$reply->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$reply->actor->fullname}">{$reply->actor->fullname}</a> </div>
								        <div class="text">{$reply->text}</div>
										{$reply->showLike(true)}
								        <div class="controlbar">
								        	<span class="time relativetime" title="{$reply->datecreated}"></span>
								            {if $me->id > 0}
												 |
								                {if $me->id == $reply->actor->id}
								                    <a class="remove" href="javascript:void(0)" onclick="bookreviewRemove('{$bookpath}/review/removeajax/{$reply->id}', {$reply->id})" title="">{$lang.controller.reviewRemove}</a>
								                {else}
								                    <a href="javascript:void(0)" onclick="bookreviewReport('{$conf.rooturl}abuse/{$reply->id}?type=review', '{$lang.controller.reviewAbuseTitle}')" title="{$lang.controller.reviewAbuseTitle}">{$lang.controller.reviewAbuse}</a>
								                {/if}
												|
												<a href="javascript:void(0)" onclick="bookreviewlikeadd({$reply->bid}, {$reply->id}, 0)" class="like_btn">{$lang.controller.like}</a>

								            {/if}
								        </div><!-- end .controlbar -->
									</div><!-- end .commentdetail -->
								</div><!-- end .reply -->

							{/foreach}
						</div><!-- end .replylist -->
						<div class="replyform {if $review->uid != $me->id || $review->numreply == 0}hide{/if}">
							<div class="avt"><img src="{$me->getSmallImage()}" /></div>
							<div class="input">
								<textarea class="mentionable fmessagereply" placeholder="{$lang.controller.replyPlaceholder}"></textarea>
								<input type="button" class="buttonreply" value="{$lang.controller.replySubmit}" onclick="reviewreplyAdd('{$bookpath}/review/addajax', {$review->id})" />
							</div>
							<div class="cl"></div>
						</div><!-- end .replyform -->
				    </div><!-- end .commentdetail -->
				</div><!-- end .comment -->
				{/foreach}
				
			</div><!-- end .commentlist -->
            <div class="cl"></div>
		</div><!-- end #bookcomment -->
		
		
		
       
       
	</div><!-- end #panelright -->
    
    <script type="text/javascript">
	{literal}
	$(document).ready(function()
	{
		//convert timestamp to relativetime
		$('.relativetime').each(function(){
			var tmp_text = $(this).text();
			if(tmp_text.length == 0)
			{
				$(this).text(relativeTime($(this).attr('title')));
			}
			$(this).show();
		});
		
		
		{/literal}
		bookdetailSummary({$myBook->id}, {$myBook->category});
		{literal}
	});
	{/literal}
	</script>