<div class="navbarprod">
    <ul>
        <li><a href="{$rooturl}" title="dienmay.com">Trang chủ</a>››</li>
        <li>Tin tức</li>
    </ul>
</div>

<div id="container">
	<div class="newscont">
    	<!-- menu news -->
        <div class="newsleft">
        	<nav role="navigation">
                <ul class="sticknews" >
                {foreach item=parentcat from=$parentCat key=k}
                    <li 
                    {if $k == 0}
                    class="sp"
                    {elseif $k == 1}
                    class="dg"
                    {elseif $k == 2}
                    class="dss"
                    {elseif $k == 3}
                    class="cdg"
                    {elseif $k == 4}
                    class="cde"
                    {elseif $k == 5}
                    class="vde"
                    {elseif $k == 6}
                    class="hdsd"
                    {elseif $k == 7}
                    class="wiki"
                    {/if}
                    ><a href="{$parentcat->getNewscategoryPath()}">{$parentcat->name}</a>
                        <ul>
                        {foreach item=subcat from=$parentcat->subCat}
                            <li><a href="{$subcat->getNewscategoryPath()}">{$subcat->name}</a></li>
                        {/foreach}
                        </ul>
                    </li>
                {/foreach}
                </ul>
            </nav>
        </div>
        <!-- news right -->
        <div class="newsright">
        	<!-- Xem nhiều nhất (viewmost)-->
            <div id="viewmost">
            	<span>Tin xem nhiều</span>
                <ul>
                {foreach item=viewtop from=$viewtopNews}
                	<li><a href="{$viewtop->getNewsPath()}" title="{$viewtop->title}"><img src="{$viewtop->getSmallImage()}" alt="{$viewtop->title}" title="{$viewtop->title}" /></a>
                    	<a href="{$viewtop->getNewsPath()}" title="{$viewtop->title}">{$viewtop->title}</a>
                        <strong>{if $viewtop->uid == 0}dienmay.com{else}{$viewtop->getActorName()}{/if}</strong><span>{$viewtop->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                    </li>
                {/foreach}
                </ul>
            </div>
                {if $video|@count != 0}
            	<!-- video -->
            	<div class="newsvideo">
                	<span>Video nổi bật</span>
                    <div class="wrapvideo">
                    	<div><iframe width="240" height="180" src="{$video.0->getYoutubeLink()}" frameborder="0" allowfullscreen></iframe></div>
                        <div>{$video.0->title}</div>
                    </div>
                </div>
                {/if}
                <!-- tin khuyen mai -->
                <div id="newspromo">
                <div class="tabscontainer" id="latest">
                 <div class="tabs">
                     <div class="tab selected" id="tab_menu_1">
                         <div class="link newspromo-1">Tin Khuyến Mãi</div>
                     </div>
                      <div class="tab" id="tab_menu_2">
                         <div class="link newspromo-2">Tư Vấn Sử Dụng</div>
                     </div>
                </div>
                <div class="clear"></div>
                <div class="curvedContainer">
                                   
                    <div class="tabcontent tab_content_1 newsbor-1 display">
                        <div class="newspromo-list">
                            <ul>
                            {foreach item=promotion from=$myPromotion}
                                <li><a href="{$promotion->getNewsPath()}" title=""><img src="{$promotion->getSmallImage()}" alt="{$promotion->title}" title="{$promotion->title}" /></a>
                                    <a href="{$promotion->getNewsPath()}" title="{$promotion->title}">{$promotion->title}</a>
                                    <span>{$promotion->getActorName()} {$promotion->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                                </li>
                            {/foreach}
                                <li><a class="seeall" href="{$rooturl}tat-ca-khuyen-mai" title="Xem tất cả tin khuyến mãi">Xem tất cả tin khuyến mãi  ››</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="tabcontent tab_content_2 newsbor-2">
                        <div class="newsconsult">
                            <span>Gửi câu hỏi tư vấn cho dienmay.com</span>
                            <form action="{$conf.rooturl}contact" method="post" name="contactform" id="contactform">
                                <input type="text" name="ffullname" id="ffullname" placeholder="Họ và tên" value="{$formData.ffullname}" class="inputfield newscons">
                                <input type="email" name="femail" id="femail" placeholder="Email" value="{$formData.femail}" class="inputfield newscons">
                                <input type="text" name="fphone" id="fphone" placeholder="Số điện thoại" value="{$formData.fphone}" class="inputfield newscons">
                                <textarea name="fmessage" id="fmessage" placeholder="Câu hỏi của anh chị ..." rows="2" class="inputfield newscons">{$formData.fmessage}</textarea>
                                <button class="btn-blue btnconsnew" type="button" name="fsubmit" onclick="processContact()">Gửi câu hỏi</button>
                            </form>
                        </div>
                    </div>
            
                </div>
            </div>
            </div>
                <!-- hoi dap -->
                <div class="newsquest">
                	<span>Câu hỏi thường gặp</span>
                    <div class="newsendquest"><a href="{$conf.rooturl}site/faq/add" rel="shadowbox;width=700;height=400"><i class="icon-sendques"></i>Gửi câu hỏi</a></div>
                    <ul>
                    {foreach item=myfaq from=$faq}
                    	<li>
                        	<a href="javascript:void(0)">{$myfaq->title}</a>
                            <strong>{$myfaq->fullname}</strong><span>- {$myfaq->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</span>
                        	<p>{$myfaq->content} </p>
                        </li>
                    {/foreach}
                    </ul>
                    {if $totalfaq > 5}<div class="viewallques"><a href="{$conf.rooturl}site/faq">Xem tất cả ››</a></div>{/if}
                    
                </div>
        </div>
        <!--news content -->
        <div class="newsmid">
        	<div class="slidenews">
            	<div class="swiper-container swiper-content">
                    <div class="swiper-wrapper">
                        {foreach item=news from=$myNews}
                        <div class="swiper-slide">
                            <div class="inner">
                                <a href="{$news->getNewsPath()}"><img class="movie-pic" src="{$news->getImage()}" alt="{$news->title}" title="{$news->title}"></a>
                                <div class="wrapdes">
                                    <h2><a href="{$news->getNewsPath()}" title="{$news->title}">{$news->title} </a></h2>
                                    <div class="movie-text">{$news->content|strip_tags|truncate:300} </div>
                                </div>
                            </div>
                        </div>
                        {/foreach}
                    </div>
                </div>
                <div class="swiper-container swiper-nav">
                    <div class="swiper-wrapper">
                        {foreach item=news from=$myNews name=mynewss}
                        {if $smarty.foreach.mynewss.first}
                        <div class="swiper-slide active-nav">
                            <span class="angle"></span>
                            <img src="{$news->getSmallImage()}" alt="{$news->title}" title="{$news->title}">
                            <div class="title">{$news->title}</div>
                        </div>
                        {else}
                        <div class="swiper-slide">
                            <span class="angle"></span>
                            <img src="{$news->getSmallImage()}" alt="{$news->title}" title="{$news->title}">
                            <div class="title">{$news->title}</div>
                        </div>
                        {/if}
                        {/foreach}
                        
                    </div>
                </div>
            </div>
            {foreach item=homenews from=$parentCat}
                {foreach item=homelist from=$homenews->subCat}
                {if $homelist->news|@count > 0}
                <div class="newsblock">
                	<div class="blocktitle"><span><a href="{$homelist->getNewscategorypath()}">{$homelist->name}</a></span></div>
                	{foreach item=mn from=$homelist->news name=mnnews}
                    {if $smarty.foreach.mnnews.first}
                    <div class="classify">
                    	<a href="{$mn->getNewsPath()}" title="{$mn->title}"><img src="{$mn->getSmallImage()}" alt="{$mn->title}" title="{$mn->title}" /></a>
                        <a href="{$mn->getNewsPath()}" title="{$mn->title}">{$mn->title}</a>
                        <p>{$mn->content|strip_tags|truncate:150}</p>
                        <div><a href="javascript:void(0)"><i class="icon-usernews"></i>{if $mn->uid != 0}{$mn->getActorName()}{else}dienmay.com{/if}</a> |</div>
                        <div><i class="icon-calenda"></i> {$mn->datecreated|date_format:$lang.default.dateFormatSmarty} &nbsp; &nbsp; |</div>
                        <div><a href="{$mn->getNewscategorypath()}">{$mn->getNewscategoryname()}</a></div>
                    </div>
                    <div class="classifylist">
                    	<ul>
                    {else}
                        	<li><a href="{$mn->getNewsPath()}" title="{$mn->title}">{$mn->title} </a></li>
                    {/if}
                    {if $smarty.foreach.mnnews.last}
                        </ul>
                    </div>
                    {/if}
                    {/foreach}
                </div>
                {/if}
                {/foreach}
            {/foreach}
        </div>
    </div>

<!--     <div id="back-top" style="display: block;"><a href="#top"><span></span><strong>Lên đầu trang</strong></a></div> -->




