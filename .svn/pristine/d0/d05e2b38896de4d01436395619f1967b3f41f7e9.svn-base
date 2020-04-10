<?xml version="1.0" encoding="utf-8"?>
<result>
	<count>{$blogList|@count}</count>
	{if $blogList|@count > 0}
		{foreach item=blog from=$blogList}
			<blog>
            	<id>{$blog->id}</id>
                <title><![CDATA[{$blog->title}]]></title>
                <image>{if $blog->image != ''}{$blog->getSmallImage()}{else}{$imageDir}linknoimage.png{/if}</image>
                <url>{$blog->getBlogPath()}</url>
                <text><![CDATA[{$blog->contents|truncateperiod:100}]]></text>
			</blog>
		{/foreach}
	{/if}
</result>