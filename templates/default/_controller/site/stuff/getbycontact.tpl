
<!-- Rao vat -->
<div class="adnewsnav">
	<div class="adnewsnav-left">
    <p>Bạn đang xem rao vặt tại:</p>
    <ul>
        <li><a href="{$conf.rooturl}rao-vat?regionid=3" {if $regionFilter == 3}class="avtived"{/if} title="Tp. Hồ Chí Minh" >Tp. Hồ Chí Minh</a><i class="ardow"></i></li>
    	<li><a href="{$conf.rooturl}rao-vat?regionid=5" {if $regionFilter == 5}class="avtived"{/if} title="Hà Nội" >Hà Nội</a><i class="ardow"></i></li>
        <li><a href="#" {if $regionFilter != 3 && $regionFilter != 5}class="avorther"{/if} title="Tỉnh khác" >Tỉnh khác</a><i class="ardow"></i>
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
  <form  action="{$conf.rooturl}site/stuff/searchStuff" method="get">
    <input name="fkeyword" type="text" placeholder="Nội dung tìm" />
    <select name="fscid">
    	<option value="0">(Tất cả nhóm sản phẩm)</option>
    	{foreach item=myCat from=$myStuffcategory}
    	<option value="{$myCat->id}" {if $formData.fscid == $myCat->id}selected="selected"{/if}>{$myCat->name}</option>
    	{/foreach}
    </select>

    <input type="submit" class="searadd" value="Tìm" />
    </form>
    </div>
    <div class="viewall"><a href="{$conf.rooturl}stuff"><i class="icon-eye"></i>Xem tất cả danh mục</a></div>
</div>
<div class="navbarprod">
  <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a>››</li>
  <li>Rao Vặt</li>
</div>
<div id="adnews">
	<div class="addleft">
    	<div class="addnavleft">
        	<div class="bgblue">Chuyên mục rao vặt</div>
        	<ul>
        		{foreach item=myCat from=$myStuffcategory}
            	<li><i class="buladd"></i><a href="{$myCat->getStuffcategoryPath()}" title="{$myCat->name}">{$myCat->name}</a></li>
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
        	<div class="bggray2"><i class="buladd4"></i>Tin rao vặt</div>
        	<ul>
        		{if $stuffs|@count > 0}
        		{foreach item=stuff from=$stuffs}
            	<li><a href="{$stuff->getStuffPath}" title="{$stuff->title}">
                    <img src="{if $stuff->image == ''}{$currentTemplate}images/default.jpg{else}{$stuff->getImage()}{/if}" alt="{$stuff->title}" />
                </a>
                	<a href="{$stuff->getStuffPath()}" title="{$stuff->title|truncate:80}">{$stuff->title|truncate:80}</a><span>{$stuff->price} đ</span>
                	<p><strong>{$stuff->getRegionName($stuff->regionid)} : </strong> {$stuff->content|truncate:150}</p>
                    <div class="userpost"><a href="#" rel="nofollow">{$stuff->contactname}</a> </div>
                    <div class="endtime">Ngày đăng: {$stuff->datecreated|date_format:$lang.default.dateFormatSmarty}</div>
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




