<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$reviewList|@count}</count>
	{if $reviewList|@count > 0}
		{foreach item=review from=$reviewList}
			<book>
            	<id>{$review->book->id}</id>
                <title><![CDATA[{$review->book->title}]]></title>
                <image>{$review->book->getSmallImage()}</image>
                <author><![CDATA[{$review->book->author}]]></author>
                <url>{$review->getReviewPath()}</url>
				<hovercardurl>{$review->book->getHovercardPath()}</hovercardurl>
                <text><![CDATA[{$review->text|truncateperiod:100}]]></text>
                <poster><![CDATA[{$review->actor->fullname}]]></poster>
                <userpath>{$review->actor->getUserPath()}</userpath>
			</book>
		{/foreach}
	{/if}
</result>