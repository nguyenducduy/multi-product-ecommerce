

<!-- Rao vat -->
<div class="adnewsnav">
    <div class="adnewsnav-left">
    <p>Bạn đang xem rao vặt tại:</p>
    <ul>
        <li><a href="{$conf.rooturl}rao-vat?regionid=3" {if $myStuff->regionid == 3}class="avtived"{/if} title="Tp. Hồ Chí Minh" >Tp. Hồ Chí Minh</a><i class="ardow"></i></li>
        <li><a href="{$conf.rooturl}rao-vat?regionid=" {if $myStuff->regionid == 5}class="avtived"{/if} title="Hà Nội">Hà Nội</a><i class="ardow"></i></li>
        <li><a href="#" {if $myStuff->regionid != 3 && $myStuff->regionid != 5}class="avorther"{/if} title="Tỉnh khác">Tỉnh khác</a><i class="ardow"></i>
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
  <form action="{$conf.rooturl}site/stuff/searchStuff" method="get">
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
  <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a>››</li>
  <li><a href="{$conf.rooturl}stuff" title="Rao vặt">Rao vặt</a>››</li>
  <li>{$category->name}</li>
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
        <div class="infoprodadd">
        <div class="infotext">
            	<h2>{$myStuff->title}</h2>
            	<ul>
                	<li>Mã tin: {$myStuff->id}</li>
                    <li>Giá: <span>{$myStuff->price|number_format} đ</span></li>
                    <li>Ngày đăng: <strong>{$myStuff->datecreated|date_format:$lang.default.dateFormatSmarty}</strong></li>
                    <!-- <li>Ngày hết hạn:<strong>14/01/2013</strong></li> -->
                    <li>Nơi đăng: <strong>{$myStuff->getRegionName($myStuff->regionid)}</strong></li>
                </ul>
                <!--
                <div class="soadd"><a href="#"><i class="icon-ggl"></i></a><span>400</span></div>
                <div class="soadd"><a href="#"><i class="icon-flike"></i></a><span>15</span></div>
            -->
            </div>
        <div class="infoimg"><img src="{if $myStuff->image == ''}{$currentTemplate}images/default.jpg{else}{$myStuff->getImage()}{/if}" width="330" height="300" /></div>
        	            
            <p>{$myStuff->content}</p>
      </div>

    <!-- comment -->
    <div id="comments" class="wrap-one">
            
    </div>
        </div>
    </div>
    <!-- end list rao vat -->
    <div class="addright">
   	  <div class="infocont">
      	<p><i class="icon-useradd"></i>Thông tin liên hệ</p>
        <ul>
        	<li>Đăng bởi: <span>{if $myStuff->uid > 0}{$myStuff->contactname}{else}Khách lẻ{/if}</span></li>
            {if $myStuff->contactphone != ''}<li>Điện thoại: <strong>{$myStuff->contactphone}</strong></li>{/if}
            {if $myStuff->contactemail != ''}<li>Email:<a href="#" rel="nofollow">{$myStuff->contactemail}</a></li>{/if}
        </ul>
        {if $myStuff->uid > 0}
        <p><a href="{$conf.rooturl}rao-vat?uid={$myStuff->uid}" ><i class="icon-latter"></i>Các tin đã đăng</a></p>
        {/if}
      </div>
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

{literal}
<script type="text/javascript">
  var sid = "{/literal}{$myStuff->id}{literal}";

  $(document).ready(function(){
      loadstuffReview(sid , '');   
  });
</script>
{/literal}