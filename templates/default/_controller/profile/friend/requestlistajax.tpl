<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$requestList|@count}</count>
	{if $requestList|@count > 0}
		{foreach item=request from=$requestList}
			<request>
				<id>{$request->id}</id>
				<uid>{$request->actor->id}</uid>
				<avatar>{$request->actor->getSmallImage()}</avatar>
				<fullname>{$request->actor->fullname}</fullname>
				<userurl>{$request->actor->getUserPath()}</userurl>
				<countbook>{if $request->actor->countBook > 0}{$request->actor->countBook} {$lang.default.bookFirstCap}{/if}</countbook>
				<countreview>{if $request->actor->countReview > 0}{$request->actor->countReview} {$lang.default.bookReview}{/if}</countreview>
				<countquote>{if $request->actor->countQuote > 0}{$request->actor->countQuote} {$lang.default.bookQuote}{/if}</countquote>
				<countfriend>{$request->actor->countFriend} {$lang.default.mFriend}</countfriend>
			</request>
						
		{/foreach}
	{/if}
</result>