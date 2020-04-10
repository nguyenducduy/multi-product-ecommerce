 
<div class="navbarprod">
    <ul>
        <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a>››</li>
        <li>Hỏi & đáp</li>
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
            <div id="viewmost">
                <a href="{$conf.rooturl}site/faq/add" rel="shadowbox;width=700;height=400" class="btn-blue btnconsnew" >Gửi câu hỏi</a>
            </div> 
                <!-- hoi dap -->
                <div class="newsquest">
                    <span>Câu hỏi mới</span>
                    <ul>
                    {foreach item=newf from=$newfaq}
                        <li>
                            <a href="javascript:void(0)">{$newf->title}</a>
                            <strong>{$newf->fullname}</strong><span>- {$newf->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</span>
                            <p>{$newf->content|strip_tags}</p>
                        </li>
                    {/foreach}
                    </ul>
                    {if $totalfaq > 5}<div class="viewallques"><a href="{$conf.rooturl}site/faq">Xem tất cả ››</a></div>{/if}
                </div>
        </div>
        <!--news content -->
        <div class="newsmid">
            <div id="faq_cont">
                {foreach item=myf from=$myFaqs}
                <div class="quescont">
                  <div class="quest">{$myf->title} <span><strong>{$myf->fullname}</strong> - {$myf->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</span></div>
                    <div class="ask">{$myf->content}</div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>

    <div id="back-top" style="display: block;"><a href="#top"><span></span><strong>Lên đầu trang</strong></a></div>

    

