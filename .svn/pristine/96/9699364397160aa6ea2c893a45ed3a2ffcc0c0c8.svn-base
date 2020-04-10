
<!-- Rao vat -->
<div class="adnewsnav">
	<div class="adnewsnav-left">
    <p>Bạn đang xem rao vặt tại:</p>
    <ul>
        <li><a href="{$conf.rooturl}rao-vat?regionid=3" {if $regionFilter == 3}class="avtived"{/if} title="Tp. Hồ Chí Minh"  >Tp. Hồ Chí Minh</a><i class="ardow"></i></li>
    	<li><a href="{$conf.rooturl}rao-vat?regionid=5" {if $regionFilter == 5}class="avtived"{/if} title="Hà Nội">Hà Nội</a><i class="ardow"></i></li>
        <li><a href="#" {if $regionFilter != 3 && $regionFilter != 5}class="avorther"{/if} title="Tỉnh khác">{if $regionFilter != 3 && $regionFilter != 5}{$myRegion->name}{else}Tỉnh khác{/if}</a><i class="ardow"></i>
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
    <div class="viewall"><a href="{$conf.rooturl}rao-vat"><i class="icon-eye"></i>Xem tất cả danh mục</a></div>
</div>
<div class="navbarprod">
  <li><a href="{$conf.rooturl}">Trang chủ</a>››</li>
  <li>Rao Vặt</li>
</div>
<div id="adnews">
	<div class="addtotal">

		{foreach item=listStuff from=$myStuffcategory}
        {if $listStuff->countitem > 0}
    	<div class="addcol">
        	<div class="layeradd"><a href="{$listStuff->getStuffcategoryPath()}&regionid={$regionFilter}" title="{$listStuff->name}"><i class="{$listStuff->iconclass}"></i></a></div>
            <p><a href="{$listStuff->getStuffcategoryPath()}&regionid={$regionFilter}" title="{$listStuff->name}">{$listStuff->name}<span> ({$listStuff->countitem})</span></a></p>
            <ul>
            	{foreach item=myStuff from=$listStuff->topic}
            	<li>
                	{if $myStuff->isvip == 1}<div class="layerli"><img src="{$currentTemplate}images/site/icon-vip.png" alt="" /></div>{/if}
                	<a href="{$myStuff->getStuffPath()}" title="{$myStuff->title}">
                        <img src="{if $myStuff->image == ''}{$currentTemplate}images/default.jpg{else}{$myStuff->getSmallImage()}{/if}" alt="{$myStuff->title}" />
                    </a>
                    <a href="{$myStuff->getStuffPath()}" title="{$myStuff->title|truncate:50}">{$myStuff->title|truncate:50}</a>
                    <span>{$myStuff->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                </li>
                {/foreach}
            </ul>
        </div>
        {/if}
        {/foreach}
        
        
    </div>
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

