
<!-- Rao vat -->
<div class="adnewsnav">
	<div class="adnewsnav-left">
    <p>Bạn đang xem rao vặt tại:</p>
    <ul>
        <li><a href="{$selectedCat->getStuffcategoryPath()}&regionid=3" {if $regionFilter == 3}class="avtived"{/if} >Tp. Hồ Chí Minh</a><i class="ardow"></i></li>
    	<li><a href="{$selectedCat->getStuffcategoryPath()}&regionid=5" {if $regionFilter == 5}class="avtived"{/if}>Hà Nội</a><i class="ardow"></i></li>
        <li><a href="#" {if $regionFilter != 3 && $regionFilter != 5}class="avorther"{/if}>{if $regionFilter != 3 && $regionFilter != 5}{$myRegion->name}{else}Tỉnh khác{/if}</a><i class="ardow"></i>
        	<ul>
            	<li class="rowli"></li>
                <li><span>Miền Bắc</span>
                    <a href="{$conf.rooturl}rao-vat?regionid=106" title="Bắc Ninh">Bắc Ninh</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=103" title="Bắc Giang">Bắc Giang</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=104" title="Bắc Cạn">Bắc Cạn</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=112" title="Cao Bằng">Cao Bằng</a>
                </li>
                <li><span>Miền Trung</span>
                    <a href="{$conf.rooturl}rao-vat?regionid=108" title="Bình Định">Bình Định</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=110" title="Bình Phước">Bình Phước</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=111" title="Bình Thuận">Bình Thuận</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=9" title="Đà Nẵng">Đà Nẵng</a>
                </li>
                <li><span>Miền Nam</span>
                    <a href="{$conf.rooturl}rao-vat?regionid=82" title="An Giang">An Giang</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=102" title="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=107" title="Bến Tre">Bến Tre</a>
                    <a href="{$conf.rooturl}rao-vat?regionid=105" title="Bạc Liêu">Bạc Liêu</a>
                </li>
            </ul>
        </li>
    </ul>
    </div>
    <div class="adnewsnav-right">
	<ul>
    	<li><a href="{$conf.rooturl}quy-dinh-rao-vat" title="Quy định">Quy định</a>|</li>
        <li><a href="{$conf.rooturl}tin-vip-la-gi" title="Tin VIP là gì?">Tin VIP là gì?</a>|</li>
        <li><a href="{$conf.rooturl}quan-ly-dang-tin" title="Quản lý đăng tin">Quản lý đăng tin</a></li>
    </ul>
    </div>
</div>
<div class="adnewssearch">
	<div class="marinput">
  <form action="{$conf.rooturl}rao-vat/searchstuff" method="get">
    <input type="text" name="fkeyword" placeholder="Nội dung tìm" />
    <select name="fscid">
    	<option value="0">(Tất cả nhóm sản phẩm)</option>
    	{foreach item=myCat from=$myStuffcategory}
    	<option value="{$myCat->id}" {if $formData.fscid == $myCat->id}selected="selected"{/if}>{$myCat->name}</option>
    	{/foreach}
    </select>
    <input type="submit" class="searadd" value="Tìm"/>
    </form>
    </div>
    <div class="viewall"><a href="{$conf.rooturl}rao-vat" rel="nofollow"><i class="icon-eye"></i>Xem tất cả danh mục</a></div>
</div>
<div class="navbarprod">
  <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a>››</li>
  <li><a href="{$conf.rooturl}rao-vat" title="Rao vặt">Rao vặt</a>››</li>
  <li>{$selectedCat->name}</li>
</div>
<div id="adnews">
	<div class="addleft">
    	<div class="addnavleft">
        	<div class="bgblue">Chuyên mục rao vặt</div>
        	<ul>
        		{foreach item=myCat from=$myStuffcategory}
            	<li><i class="buladd"></i><a href="{$myCat->getStuffcategoryPath()}&regionid={$regionFilter}" title="{$myCat->name}">{$myCat->name}</a></li>
            	{/foreach}
            </ul>
        </div>
        <div class="addmostview">
        	<div class="bgred">Tin xem nhiều nhất</div>
        	<ul>
        		{foreach item=top from=$topview}
            	<li><i class="buladd2"></i><a href="{$top->getStuffPath()}" title="{$top->title}">{$top->title}</a></li>
            	{/foreach}
            </ul>
        </div>
        {if !empty($bannertrai)}
        <div class="addverleft">
            {foreach item=bannerT from=$bannertrai}
            <a href="{$bannerT->getAdsPath()}" rel="nofollow"><img src="{$bannerT->getImage()}" alt="{$bannerT->title}" /></a>
            {/foreach}
        </div>
        {/if}
    </div>
    <!-- list rao vat -->
    <div class="addlist">
    	<div class="vipnews">
        	<div class="bggray"><i class="buladd3"></i>Tin VIP</div>
        	<ul>
        		{if $vipstuffs|@count > 0}
        		{foreach item=vip from=$vipstuffs}
            	<li>
                    <a href="{$vip->getStuffPath()}" title="{$vip->title}">
                        <img src="{if $vip->image == ''}{$currentTemplate}images/default.jpg{else}{$vip->getSmallImage()}{/if}" alt="{$vip->title}" />
                    </a>
                	<a href="{$vip->getStuffPath()}" title="{$vip->title|truncate:80}">{$vip->title|truncate:50}</a><span>{$vip->price} đ</span>
                	<p><strong>{$vip->getRegionName($vip->regionid)} : </strong> {$vip->content|truncate:100}</p>
                    <div class="userpost"><a href="#" rel="nofollow">{$vip->contactname}</a> </div>
                    <div class="endtime">Ngày đăng: {$vip->datecreated|date_format:$lang.default.dateFormatSmarty}</div>
                </li>
                {/foreach}
                {else}
                <li>Hiện chưa có tin VIP nào!</li>
                {/if}
            </ul>
            <div style="width:100%;height:37px; background:whiteSmoke;">
            	<div class="pagination" style="float: right;">
				   {assign var="pageurl" value="vpage=::PAGE::"}
					{paginate count=$vtotalPage curr=$vcurPage lang=$paginateLang max=4 url="`$paginateurl``$pageurl`"}
				</div> <!-- End .pagination -->
            </div>
        </div>
        <!-- rao vat moi nhat -->
        <div class="vipnews">
        	<div class="bggray2"><i class="buladd4"></i>Tin rao vặt mới nhất</div>
        	<ul>
        		{if $normalstuffs|@count > 0}
        		{foreach item=normal from=$normalstuffs}
            	<li>
                    <a href="{$normal->getStuffPath()}" title="{$normal->title}">
                        <img src="{if $normal->image == ''}{$currentTemplate}images/default.jpg{else}{$normal->getSmallImage()}{/if}" alt="{$normal->title}" />
                    </a>
                	<a href="{$normal->getStuffPath()}" title="{$normal->title|truncate:80}">{$normal->title|truncate:50}</a><span>{$normal->price} đ</span>
                	<p><strong>{$normal->getRegionName($normal->regionid)} : </strong> {$normal->content|truncate:100}</p>
                    <div class="userpost"><a href="#" rel="nofollow">{$normal->contactname}</a> </div>
                    <div class="endtime">Ngày đăng: {$normal->datecreated|date_format:$lang.default.dateFormatSmarty}</div>
                </li>
                {/foreach}
                {else}
                <li>Hiện chưa có tin nào!</li>
                {/if}
            </ul>
            <div style="width:100%;height:37px; background:whiteSmoke;">
            	<div class="pagination" style="float: right;">
				   {assign var="pageurl" value="page=::PAGE::"}
					{paginate count=$totalPage curr=$curPage lang=$paginateLang max=4 url="`$paginateurl``$pageurl`"}
				</div> <!-- End .pagination -->
            </div>
        </div>
        
        <!-- end -->
    </div>
    <!-- end list rao vat -->
    <div class="addright">
   	  <div class="postnews"><a href="{$conf.rooturl}rao-vat/post" title="Đăng tin rao vặt"><i class="icon-post"></i>Đăng tin rao vặt</a></div>
        {if !empty($bannerphai)}
        <div class="advertis">
            {foreach item=bannerP from=$bannerphai}
            <a href="{$bannerP->getAdsPath()}" rel="nofollow"><img src="{$bannerP->getImage()}" alt="{$bannerP->title}" /></a>
            {/foreach}
        </div>
        {/if}
    </div>
<div class="clear"></div>
</div>
<!-- End rao vat -->