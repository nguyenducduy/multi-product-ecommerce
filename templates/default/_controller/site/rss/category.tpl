<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>

	<channel>
		<title>Siêu thị điện máy dienmay.com</title>
		<atom:link href="http://www.dienmay.com/rss" rel="self" type="application/rss+xml" />
		<link>http://www.dienmay.com</link>
		<description>Siêu thị điện máy dienmay.com - Hệ thống siêu thị điện máy chuyên cung cấp các sản phẩm điện thoại, laptop, điện tử, gia dụng, điện máy chính hãng giá rẻ</description>
		<lastBuildDate>{$lastBuildDate|date_format:$lang.default.dateFormatRssSmarty}</lastBuildDate>
		<language>en-US</language>
		<sy:updatePeriod>hourly</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		<generator>http://wordpress.org/?v=3.5.1</generator>
	
		{foreach item=product from=$productlist}
		<item>
			<title>{$product->name}</title>
			<link>{$product->getProductPath()}</link>
			<pubDate>{$product->datemodified|date_format:$lang.default.dateFormatRssSmarty}</pubDate>
			<dc:creator>dienmay.com</dc:creator>

		<description><![CDATA[{if $product->dienmayreview != ""}{$product->dienmayreview|@strip_tags|truncate}{elseif $product->summary != ""}{$product->summary|@strip_tags|truncate}{else}{$product->content|@strip_tags|truncate}{/if}]]></description>
		</item>
		{/foreach}
	</channel>
</rss>