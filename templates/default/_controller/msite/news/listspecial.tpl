<div class="nav-news">
    {foreach item=nmenu from=$newsmenu}
    <li><a {if $nmenu->id == $id}class="selectnews"{/if} href="{$nmenu->getNewscategoryPath()}" title="{$nmenu->name}">{$nmenu->name}</a></li>
    {/foreach}
</div>
<!-- News -->
<div id="wrap-news">
  <div class="wrap-child">
  	<!-- Điện thoại -->


    {foreach item=news from=$myNews name="mynews"}
    {if $smarty.foreach.mynews.first}
    <div class="everyrow everyspec">
        <a href="{$news->getNewsPath()}" title="{$news->title}"><img src="{if $news->image != ''}{$news->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$news->title}" /> </a>
        <a href="{$news->getNewsPath()}" title="{$news->title}">{$news->title}</a><span>{$news->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
        <p>{$news->content|strip_tags|truncate:255}</p>
    </div> 
    {else}
    <div class="everyrow">
    	<a href="{$news->getNewsPath()}" title="{$news->title}"><img src="{if $news->image != ''}{$news->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$news->title}" /> </a>
        <a href="{$news->getNewsPath()}" title="{$news->title}">{$news->title}</a><span>{$news->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
        <p>{$news->content|strip_tags|truncate:155}</p>
    </div>
    {/if}
    {/foreach}

    <div class="pagination" style="float: right;">
        {assign var="pageurl" value="page=::PAGE::"}
        {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
    </div> <!-- End .pagination -->

 <!-- news right -->
  </div>
  <div class="news-right">
  	<div class="video">
   	  <p class="videotop">Video</p>
      {foreach item=myvideo from=$video name=myVideo}
      {if $smarty.foreach.myVideo.first}
      <p class="videofile">
        <iframe src="{$myvideo->getYoutubeLink()}" width="280" height="220"></iframe>
      </p>
      <span>{$myvideo->title}</span>
      {else}
      <ul>
        <li><a href="{$myvideo->getNewsPath()}" title="{$myvideo->title}">{$myvideo->title}</a></li>
      </ul>
      {/if}
      {/foreach}
      </div>
    <div class="quesask">
    	<div class="questop"><a href="{$conf.rooturl}site/faq" >Hỏi & đáp</a><span><a href="{$conf.rooturl}site/faq/add" rel="shadowbox;width=700;height=400">Gửi câu hỏi</a></span></div>
        {foreach item=myfaq from=$faq}
        <div class="quescont">
          <a href="javascript:void(0);" title="{$myfaq->title}">{$myfaq->title}</a>
            <span><strong>{$myfaq->fullname}</strong> - {$myfaq->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</span>
            <p>{$myfaq->content|truncate}</p>
        </div>
        {/foreach}
    </div>
  <div class="mostview">
   	<div class="mostviewtop">Xem nhiều nhất</div>
        {foreach item=vtNews from=$viewtopNews key="key"}
        <div class="mostview0{$key+1}">
          <a href="{$vtNews->getNewsPath()}" title="{$vtNews->title}"><img src="{if $vtNews->image != ''}{$vtNews->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" width="300" height="120" alt="{$vtNews->title}"/></a>
          <div class="mostviewbg"><a href="{$vtNews->getNewsPath()}" title="{$vtNews->title}">{$vtNews->title}</a></div>
        </div>
        {/foreach}
  </div>
    <div class="technology">
    	<div class="technotop">Sản phẩm công nghệ mới</div>
        <ul>
        	{foreach item=mySpcnm from=$spcnm}
            <li><a href="{$mySpcnm->getNewsPath()}" title="{$mySpcnm->title}">{$mySpcnm->title}</a></li>
            {/foreach}
        </ul>
    </div>
  </div>
<!-- end news-right -->
<div class="specialcol">
	<div class="sticktop sticky_navigation">
    {if !empty($promotionProduct)}
	<p class="specialtop">Sản phẩm khuyến mãi</p>
    <ul>
        {foreach item=promo from=$promotionProduct}
    	<li>
            <a href="{$promo->getProductPath()}" title="{$promo->name}"><img src="{$promo->getSmallImage()}" alt="{$promo->name}"/></a>
            <a href="{$promo->getProductPath()}" title="{$promo->name}">{$promo->name}</a>
            {if !empty($promo->promotionprice)}
            
            <div class="giam">{$promo->promotionprice|number_format} đ</div>
            <div class="giamc">{$promo->sellprice|number_format} đ</div>
            {else}
            <div class="giam">{$promo->sellprice|number_format} đ</div>
            {/if}
        </li>
        {/foreach}
    </ul>
    {/if}
    </div>
    
</div>
</div>
<!-- End news -->