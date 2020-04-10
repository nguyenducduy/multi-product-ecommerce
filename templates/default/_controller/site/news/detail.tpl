 
<div class="navbarprod">
    <ul>
        <li><a href="{$rooturl}" title="dienmay.com">Trang chủ</a>››</li>
        <li><a href="{$rooturl}tin-tuc">Tin tức</a>››</li>
        <li><a href="{$myCategory->getNewscategoryPath()}" title="{$myCategory->name}">{$myCategory->name}</li>
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
        	<!-- Cộng tác viên -->
            <!-- <div class="collaborators">
            	<strong>Thông tin cộng tác viên</strong>
                <div class="infocolla">
                	<img src="http://dienmay.myhost/templates/default/images/site/user.jpg" />
                    <a href="#"><strong>Đặng Ngọc Thanh Tâm</strong></a>
                    <span>Tham gia: 1/12/2012</span>
                    <span>Bài viết: 10 bài</span>
                    <a class="uplist" href="#" title="">Bài viết mới nhất</a>
                    <a class="uplist" href="#" title="">Bài viết đã đăng</a>
                </div>
            </div> -->
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
            <div class="titlenews">
            	<h1>{$myNews->title}</h1>
                <div><a href="{$myNews->getNewsPath()}"><i class="icon-usernews"></i>{if $myNews->uid > 0}{$myNews->getActorName()}{else}dienmay.com{/if}</a> |</div>
                <div><i class="icon-calenda"></i> {$myNews->datecreated|date_format:$lang.default.dateFormatSmarty} &nbsp; &nbsp; |</div>
                <div><a href="{$myNews->getNewscategorypath()}">{$myNews->getNewscategoryname()}</a></div>
            </div>
            <div class="sociallike"><iframe src="//www.facebook.com/plugins/like.php?href={$myNews->getNewsPath()|escape}&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
            <div class="newsdetcont">
            	{$myNews->content}
            	{if preg_match("#^http?://.+#", $myNews->source)}
	            <iframe src="{$myNews->getYoutubeLink()}" width="450" height="320"></iframe>
	            {/if}
            </div>
            <div class="authors">
            	<span>{if $myNews->uid > 0}{$myNews->getActorName()}{else}dienmay.com{/if}</span>
            	<div class="sociallike"><iframe src="//www.facebook.com/plugins/like.php?href={$myNews->getNewsPath()|escape}&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
            </div>

            {if $keywordList|@count > 0}
            <div id="tag-list">
                <span>Tags :</span>
                {foreach item=mykeyword from=$keywordList}
                <a href="{$mykeyword->getKeywordPath(isnews)}" title="{$mykeyword->text}">{$mykeyword->text}</a>
                {/foreach}
      		</div>
      		{/if}
            
            <!--<div class="newsproduct">
            	<div class="products newsbortop">
                  <ul>
                    <li> <a href="#"><img src="images/dien-thoai-di-dong-iphone5-10.jpg" alt="" title="" /> </a> <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                      <div class="priceold">289.000 VND</div>
                      <div class="pricenew">189.000 VND</div>
                      <div class="buynow"></div>
                      <a href="#" class="textbuynow">Mua</a>
                      <div class="salemethod">Chỉ bán online</div>
                    </li>
                    
                    <li> <a href="#"><img src="images/dien-thoai-di-dong-iphone5-11.jpg" alt="" title="" /> </a> <a class="position-a" href="#"> D9ie65n thoai Điện tử Tiger JBA - V18W </a>
                      <div class="priceold">289.000 VND</div>
                      <div class="pricenew">189.000 VND</div>
                      <div class="buynow"></div>
                      <a href="#" class="textbuynow">Mua</a> 
                      <div class="salemethod">Chỉ bán online</div>
                    </li>
                    <li>
                      <div class="special"><i class="icon-new"></i></div>
                      <a href="#"><img src="images/htc-one-580941367743040-small.jpg" alt="" title="" /> </a> <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                      <div class="priceold">289.000 VND</div>
                      <div class="pricenew">189.000 VND</div>
                      <div class="buynow"></div>
                      <a href="#" class="textbuynow">Mua</a>
                      <div class="salemethod">Xả hàng</div>
                    </li>
                    <li> <a href="#"><img src="images/sony-xperia-z-579581367742747-small.jpg" alt="" title="" /> </a> <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                      <div class="priceold">289.000 VND</div>
                      <div class="pricenew">189.000 VND</div>
                      <div class="buynow"></div>
                      <a href="#" class="textbuynow">Mua</a>
                      <div class="salemethod">Đấu giá</div>
                    </li>
                  </ul>
                </div>
            </div>-->
            
            <div class="similarnews">
            	<span>Tin cùng chuyên mục</span>
                <ul>
            	{foreach item=nsame from=$samenews}
                	<li><a href="{$nsame->getNewsPath()}" title="{$nsame->title}">{$nsame->title}</a> <span>- {$nsame->datecreated|date_format:$lang.default.dateFormatSmarty}</span></li>
            	{/foreach}
                </ul>
            </div>
            
        </div>
    </div>

   <!-- <div id="back-top" style="display: block;"><a href="#top"><span></span><strong>Lên đầu trang</strong></a></div> -->

    

