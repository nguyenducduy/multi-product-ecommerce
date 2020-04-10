{if !empty($fullPathCategory)}
<ul class="navbarprod">
    <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>
    {foreach from=$fullPathCategory item=fcat}
        <li><a href="{$fcat['fullpath']}" title="{$fcat['pc_name']}">{$fcat['pc_name']} </a> ››</li>
    {/foreach}
  <li>{$productDetail->name}</li>
</ul>
{/if}
<div id="wrapper">
  <div class="summary">
      <div class="summary_left">
        
                {if $galleries360|@count>0}
                    <div class="imgtop" id="toprotate">
                    {foreach from=$galleries360 item=gal}
                        <img src="{$gal->getImage()}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->caption}{/if}" class="image360" />
                        {break}
                    {/foreach}
                    </div>
                {else}
                    <div class="imgtop" id="toprotate">
                    <a href="#gallery"><img src="{$productDetail->getImage()}" alt="{$productDetail->name}" /></a>
                    </div>
                {/if}

        
        <div class="gallvideo">
            <!--<ul class="menufeature2">
                <li><a href="#video" rel="nofollow"><i class="icon-video"></i>Video</a></li>
                <li><a href="#gallery" rel="nofollow"><i class="icon-gallery"></i>Hình ảnh</a></li>                
            </ul>-->
            <a id="compares" href="{$conf.rooturl}productcompare/?pid={$productDetail->id}"><i class="icon-comp"></i>So sánh</a>
        </div>
      {if $relProductProduct|@count>0}
      <div class="titlerelate">Sản phẩm liên quan</div>

      <div class="related">

            <ul id="slidecarousel">
                {foreach from=$relProductProduct item=relpp}
                    <li>
                        <a href="{$relpp->getProductPath()}" title="{$relpp->name}"><img src="{$relpp->getSmallImage()}" alt="{$relpp->name}" /></a>
                        <a href="{$relpp->getProductPath()}" title="{$relpp->name}">{$relpp->name}</a>
                        <span>{$relpp->sellprice|number_format}đ</span>
                    </li>
                {/foreach}
            </ul>

      </div>
      {/if}
    </div>
    <div class="summary_right">
        <h1 id="productname">{if $currentCategory->appendtoproductname == 1}{$currentCategory->name} {/if}{$productDetail->name}</h1>
        <p id="productcategory" style="display: none;">{if $currentCategory->appendtoproductname == 1}{$currentCategory->name}{/if}</p>
        <div class="btnprice">
            <ul>
                <li>
                    <div id="relprice">
                    {if $productDetail->onsitestatus == $OsERP && $productDetail->displaysellprice==0 && $firstPromotion.promotiongroup[0]->discountvalue > 0 && $productDetail->sellprice > 0}
                        {if $firstPromotion.promotiongroup[0]->isdiscountpercent == 1}
                            {math|number_format equation="x - (x*y/100)" x=$productDetail->sellprice y=$firstPromotion.promotiongroup[0]->discountvalue format="%.0f"}
                        {else}
                            {math|number_format equation="x - y" x=$productDetail->sellprice y=$firstPromotion.promotiongroup[0]->discountvalue format="%.0f"}
                        {/if}
                        <span class="vnd">VNĐ</span> <span id="promotiontop">(<strike>{$productDetail->sellprice|number_format}</strike>)</span>
                    {elseif $productDetail->sellprice > 0 && $productDetail->onsitestatus > 0}
                    	{if $productDetail->onsitestatus == $OsERP && $productDetail->instock > 0}
                    		{$productDetail->sellprice|number_format} <span class="vnd">đ</span> <span>(Giá tốt nhất)</span>
	                    {elseif $productDetail->onsitestatus == $OsERPPrepaid}
	                    	{$productDetail->prepaidprice|number_format} <span class="vnd">đ</span> <span>(Giá dự kiến)</span>
	                    {else}
	                    	{$productDetail->sellprice|number_format} <span class="vnd">đ</span> <span>(Giá tốt nhất)</span>
	                    {/if}                        
                    {elseif $productDetail->sellprice <= 0 || $productDetail->instock <=0}
                        <font color="#ff0">Hết hàng</font>
                    {else}
                        <font color="#ff0">Giá chưa cập nhật</font>
                    {/if}

                {*if !empty($promotionsInfo.listPromotions)}<i class="icon-bton"></i>
                    </div>
                    <ul>
                        {if !empty($promotionsInfo.listPromotions)}
                            {foreach from=$promotionsInfo.listPromotions item=promotion}

                                        {if $promotion['isproduct'] == 0}<!--Combo-->
                                        <li class="promotions" rel="{$productDetail->barcode|trim}_{$promotion['promoid']}">
                                            <span class="namekm">KM: </span>{$promotion['promoname']}
                                        </li>
                                        {elseif $promotion['isproduct'] == 1 && $promotion['pricepromotion'] >0}
                                        <li class="promotions" rel="{$productDetail->barcode|trim}_{$promotion['promoid']}">
                                            <span class="namekm">KM: {$promotion['promoname']}}</span>:{$promotion['pricepromotion']|number_format} VNĐ
                                        </li>
                                        {else}
                                        <li class="promotions" rel="{$productDetail->barcode|trim}_{$promotion['promoid']}">
                                            <span class="namekm">KM: {$promotion['promoname']}</span>
                                        </li>
                                        {/if}

                            {/foreach}
                        {/if}
                    </ul>
                {else}
                    </div>
                {/if*}</div>
                </li>
            </ul>
        </div>
        {if !empty($havestorestock) && $productDetail->onsitestatus == $OsERP && $productDetail->instock > 0}
        <div class="listmarket"><a href="{$conf.rooturl}product/sieuthiconhang?code={$productDetail->barcode|trim}" rel="shadowbox[width=820,height=800]">Danh sách siêu thị còn hàng</a></div>
        {/if}
        <!--<p class="totalpromo">Tổng giá trị quà tặng lên đến <span class="fred">4.000.000 đ</span> <i class="f11">(Áp dụng từ 10/12/2012 số lượng có hạn)</i></p>-->
        {*if !empty($firstPromotion)}<!--TAM ThOI BO-->
        <div class="infopromo promotiondetail" id="{$productDetail->barcode|trim}_{$firstPromotion['promotion']->id}">
            {if !empty($firstPromotion['promotioncombo']) || !empty($firstPromotion['promotiongroup'])}
             <div class="leftcell">
                {$firstPromotion['promotion']->description}
            </div>
            <div class="rightcell">
                <ul>
                {if !empty($firstPromotion['promotioncombo'])}
                    {foreach from=$firstPromotion['promotioncombo'] item=lcobo}
                        {if !empty($firstPromotion['listProductCombo'][$lcobo->coid])}
                        <li>Combo <span>{$lcobo->comboObject->name} </span>gồm:
                            {foreach from=$firstPromotion['listProductCombo'][$lcobo->coid] item=pcobo name=productcombo}
                                {if !$smarty.foreach.productcombo.first},{/if} {$pcobo->name}
                            {/foreach}
                        </li>
                        {/if}
                    {/foreach}
                {elseif !empty($firstPromotion['promotiongroup'])}
                    {foreach from=$firstPromotion['promotiongroup'] item=promogroup}
                        <li>{$firstPromotion['promotion']->name}: {$promogroup->name}
                        {if !empty($promogroup->discountvalue) && $promogroup->discountvalue > 0}
                            <span class="pricenew">Giá KM:
                            {if $promogroup->isdiscountpercent == 1}
                                {math|number_format equation="x - (x*y/100)" x=$productDetail->sellprice y=$promogroup->discountvalue format="%.0f"}
                            {else}
                                {math|number_format equation="x - y" x=$productDetail->sellprice y=$promogroup->discountvalue format="%.0f"}
                            {/if}
                            </span>
                        {/if}
                        </li>
                    {/foreach}
                {/if}
                </ul>
            </div>
            {else}
                {$firstPromotion['promotion']->description}
            {/if}
            <p class="totalpromo"><i class="f11">(Áp dụng từ {$firstPromotion['promotion']->startdate|date_format:"%e/%m/%Y"} số lượng có hạn)</i></p>

        </div>
        {/if*}
        {if !empty($listpromotionbypromotionids) && !empty($listpromotionswithexlude)}
            <div class="infopromo promotiondetail" id="{$productDetail->barcode|trim}_{$firstPromotion['promotion']->id}">
                {foreach from=$listpromotionswithexlude item=excludearray name=counterpomoide}
                    {if !empty($excludearray)}
                        {if !$smarty.foreach.counterpomoide.first}<p class="clear orpromo"><strong>HOẶC</strong></p>{/if}
                        <ul class="listpromotiondetail">
                        {foreach from=$excludearray item=promoide}                            
                            {if !empty($listpromotionbypromotionids[$promoide])}
                                <li>{$listpromotionbypromotionids[$promoide]['promoname']}</li>
                            {/if}
                        {/foreach}
                        </ul>                        
                    {/if}               
                {/foreach}
                
                {if !empty($maxstartdatepromotion) && !empty($minenddatepromotion)}
                <p class="totalpromo"><i class="f11">
                    (Áp dụng từ {$maxstartdatepromotion|date_format:"%e/%m/%Y"} đến {$minenddatepromotion|date_format:"%e/%m/%Y"} số lượng có hạn)                    
                </i></p>
                {/if}
            </div>            
        {/if}
        <div class="infobuy">
            <div class="buycell_left">

                <ul>

                    {if $productDetail->sellprice > 0 && $productDetail->onsitestatus == $OsERP && $productDetail->instock >0 && $installments.PPF.nosupport == 1 && !empty($installments.PPF.monthly)}
                    <li><input name="" type="checkbox" value="{$productDetail->id}" id="installment"  /> Mua trả góp từ <span>{$installments.PPF.monthly|round|number_format} đ/tháng<br /></span></li>
                    {elseif $productDetail->sellprice > 0 && $productDetail->onsitestatus == $OsERP && $productDetail->instock >0 && $installments.ACS.nosupport == 1 && !empty($installments.ACS.monthly)}
                    <li><input name="" type="checkbox" value="{$productDetail->id}" id="installment"  /> Mua trả góp từ <span>{$installments.ACS.monthly|round|number_format} đ/tháng</span></li>
                    {/if}
                    {if $prepaidnumberorders > 0}
                    <li><a href="javascript:void(0)" onclick="showpopupprepaid({$productDetail->id})">Đã có {$prepaidnumberorders} người đặt hàng trước</a></li>
                    {/if}
                    <!--<li><input name="" type="checkbox" value="" /> Gói bảo hành mở rộng <span>2.000.000 đ</span></li>-->
                    <li>
                        {if $productDetail->sellprice > 0 && $productDetail->onsitestatus > 0}                        
	                        {if $productDetail->onsitestatus == $OsERP && $productDetail->instock > 0}
		                    <div class="buynow2">                            
	                            <a href="javascript:void(0)" id="buypress" rel="{$productDetail->id}" title="Mua hàng">Mua hàng</a>
	                        </div>
		                    {elseif $productDetail->onsitestatus == $OsERPPrepaid}
		                    <a href="#" title="Đặt trước" class="buyprepaid" rel="{$productDetail->id}" style="display: block" id="prepaiddetail">Đặt trước</a> 
		                    {else}
		                    <div class="buynow2">                            
	                            <a href="javascript:void(0)" title="Hết hàng"><font color="#ff0">Hết hàng</font></a>
	                        </div>
		                    {/if}
                        {/if}
                        {*if $productDetail->sellprice > 0 && $productDetail->onsitestatus > 0}
                            <div class="buynow2"><a href="{$conf.rooturl}cart/checkout/?id={$productDetail->id}{if !empty($firstPromotion['promotion']->id)}&prid={$productDetail->barcode|trim}_{$firstPromotion['promotion']->id}{/if}" id="checkout" rel="nofollow">Giỏ hàng</a></div>
                        {/if*}
                    </li>
                    {if $countrelProduct > 0}
                    <li><a href="javascript:void(0)" id="advicepopup" rel="{$productDetail->id}" title="Tư vấn chọn sản phẩm"><i class="icon-ques"></i>Tư vấn chọn sản phẩm</a></li>
                    {/if}
                </ul>

            </div>
            <div class="buycell_right">
                <ul>
                    {if $productDetail->warranty > 0}
                    <li><i class="icon-bha"></i>
                        <span>Bảo hành</span>
                        <p>Chính hãng, {$productDetail->warranty} tháng</p>
                        <!--<a href="#">Tra cứu trung tâm bảo hành</a>-->
                    </li>
                    {/if}
                    {if !empty($productDetail->fullboxshort)}
                    <li><i class="icon-bhc"></i>
                        <span>Bộ bán hàng chuẩn</span>
                        <p>{$productDetail->fullboxshort}</p>
                    </li>
                    {/if}
                </ul>
            </div>
        </div>
        {*if !empty($productDetail->seodescription)*}
        <!--<div class="infoprod" id="seodescription">{*$productDetail->seodescription|nl2br*}</div>-->
        {if !empty($productDetail->summary)}
            <p class="submmary" id="summaryproduct">
                {$productDetail->summary}
            </p>
        {/if}
    </div>
  </div>
  <div class="prod_content">
      <div class="sticky_navigation" >
        <ul class="menufeature">
            <li class="current"><a href="#hightlights" title="dienmay.com đánh giá">dienmay.com đánh giá</a></li>
            <li><a {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}href="#parameters"{else}href="#attribute" class="disablesticky"{/if} title="Thông số kỹ thuật">Thông số</a></li>
            <!-- <li><a  {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}href="#features"{else}href="#attribute" class="disablesticky"{/if} title="Bảng tính năng">Tính năng</a></li> -->
            <li><a {if !empty($galleries) || !empty($videos) || !empty($productDetail->fullbox)}href="#gallery"{else}href="#" class="disablesticky"{/if} title="Hình ảnh">Hình ảnh - Video </a></li>
            <li><a {if !empty($productDetail->content)}href="#introduction"{else}href="#" class="disablesticky"{/if} title="Giới thiệu sản phẩm">Giới thiệu sản phẩm</a></li>
            <li><a href="#comments" title="Bình luận">Bình luận</a></li>
        </ul>
    </div>
        <div id="highlights" class="hightlight">
            <div class="clum" id="thegood">
                <span>Ưu điểm</span>
                {$productDetail->good}
            </div>
            <div class="clum" id="thebad">
                <span>Nhược điểm</span>
                {$productDetail->bad}
            </div>
            <div class="clum" id="review">
                <span>dienmay.com đánh giá</span>
                <p>{$productDetail->dienmayreview}</p>
            </div>
        </div>

        {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}
        <div id="parameters" class="wrap-one">
            <span class="titlename" id="techlist">Thông số kỹ thuật</span>
            <div class="para"><img src="{if !empty($specialimage)}{$specialimage}{else}{$productDetail->getImage()}{/if}" /></div>
            <div class="flrig">
                {assign var=cnt value=0}
                {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}
                    <table class="table">
                    {foreach item=groupattributes from=$productGroupAttributes}
                        {if $productAttributes[$groupattributes->id]|@count>0}

                            {foreach from=$productAttributes[$groupattributes->id] item=attribute}
                                {if !empty($relProductAttributes[$attribute->id][$productDetail->id])}
                                    <tr>
                                        <td class="fullnotename" rel="{$attribute->id}" id="k{$attribute->id}">{$attribute->name}</td>
                                        <td class="fullnote" rel="{$attribute->id}" id="v{$attribute->id}">{$relProductAttributes[$attribute->id][$productDetail->id]->value}  {$productAttributes[$groupattributes->id][$attribute->id]->unit}</td>
                                    </tr>
                                    {assign var=cnt value=$cnt+1}
                                {/if}
                                {if $cnt==10}{break}{/if}
                            {/foreach}
                            {if $cnt==10}{break}{/if}
                        {/if}
                    {/foreach}
                    </table>
                {/if}
                <div style="float:right;" id="viewbtn"><a href="#parameters" class="btn-blue" rel="nofollow" id="view">Xem thêm</a></div>
            <br />

            </div>

            <div id="more">
            {foreach item=groupattributes from=$productGroupAttributes name=groupattr}
                    {if $productAttributes[$groupattributes->id]|@count>0}
                        <div class="linebox{if $smarty.foreach.groupattr.last} lastitem{/if}">
                            <div class="colbox width30per rightborder fullnoteganame" rel="{$groupattributes->id}">{$groupattributes->name}</div>
                            <div class="colbox">
                                {foreach from=$productAttributes[$groupattributes->id] item=attribute name=listproattr}
                                    {if !empty($relProductAttributes[$attribute->id][$productDetail->id])}
                                        <p>
                                            <span class="width30pers fullnotename" rel="{$attribute->id}" id="kk{$attribute->id}">{$attribute->name}</span>
                                            <span class="fullnote" rel="{$attribute->id}" id="vv{$attribute->id}">{$relProductAttributes[$attribute->id][$productDetail->id]->value} {$productAttributes[$groupattributes->id][$attribute->id]->unit}</span>
                                        </p>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                    {/if}
                {/foreach}
            </div>

                <br/>
                    {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}
                    <div style="float:right;display:none" id="zoombtn"><a href="#parameters" class="btn-blue" rel="nofollow" id="zoom">Thu nhỏ</a></div>
                    {/if}
                </div>

        </div>
        {/if}
        {if !empty($galleries) || !empty($videos) || !empty($productDetail->fullbox)}
        <div class="wrap-video-gallery" id="gallery">
          {if !empty($videos) || !empty($productDetail->fullbox)}
          <div class="video-bhchuan">
            {if !empty($videos)}
            <div class="wrap-video"> 
                <div class="titlename">Video sản phẩm</div>
                  <div class="group-video">
                    <div class="video-larg" id="runyoutubeurl"><iframe width="420" height="315" src="{$videos[0]->moreurl}" frameborder="0" allowfullscreen></iframe></div>
                    {if $videos|@count > 1}
                    <div class="video-small">
                        <ul>
                        {foreach from=$videos item=video name=videonamesmart}
                            {if !empty($video->moreurl)}
                                <li class="{if $smarty.foreach.videonamesmart.first}actived{/if} popupvideo" rel="{$video->moreurl}"><img src="http://img.youtube.com/vi/{$video->youtubeid}/0.jpg" alt="{$productDetail->name}" width="190" height="127" /></li>
                            {/if}
                        {/foreach}
                        </ul>
                    </div>
                    {/if}
                </div>      
            </div>
            {/if}
            {if !empty($productDetail->fullbox)}
            <div class="wrap-bbhbasic">
                 <div class="titlename"> Bộ bán hàng chuẩn</div>
                 {$productDetail->fullbox}
            </div>
            {/if}
          </div>
          {/if}
          {if !empty($galleries)}
          <div class="glalery_one">
            <div class="titlename">Hình ảnh sản phẩm</div>
                <ul>
                {foreach from=$galleries item=gal}
                    <li><a href="{$gal->getImage()}" rel="shadowbox[gallery]" title="{$gal->title}"><img src="{$gal->getSmallImage()}"  alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}" title="{if !empty($gal->caption)}{$gal->caption}{else}{$gal->titleseo}{/if}" border="0" /></a></li>
                {/foreach}
                </ul>
          </div>
          {/if}
        </div>
        {/if}

        {if $productDetail->content != ''}
        <div id="introduction" class="wrap-one">
            <span class="titlename">Giới thiệu sản phẩm</span>
            
		<div class="wrap_articles">{$productDetail->content}</div>
        </div>
        {/if}
        {if $keywordList|@count > 0}
        <!-- tags -->
          <div id="tag-list">
            <span>Tags :</span>
            {foreach item=mykeyword from=$keywordList name=keywordlist}
                <a href="{$mykeyword->getKeywordPath()}" title="{$mykeyword->text}">{$mykeyword->text}</a>{if $smarty.foreach.keywordlist.last != true}, {/if}
            {/foreach}
          </div>
        {/if}

        <div id="comments" class="wrap-one">

        </div>

  </div>
  <!--<div>row3</div>-->
</div>
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$productDetail->pcid}{literal}";
var pid = "{/literal}{$productDetail->id}{literal}";
var fgpa = "{/literal}{$gpa}{literal}"
var fpa = "{/literal}{$pa}{literal}"
var prel = "{/literal}{$prel}{literal}"
$(document).ready(function(){
    initEditInline(fpcid, pid);
    loadReview(pid , '');
    $('#more').css('display' , 'none');
    $('#view').click(function(){
        if($('#more').css('display') == 'none')
        {
            $('#more').fadeIn(700);
            $('#zoombtn').fadeIn();
            $('#viewbtn').fadeOut();
        }
    });

    $('#zoom').click(function(){
        $('#more').fadeOut(700);
        $('#viewbtn').fadeIn();
        $('#zoombtn').fadeOut();
    });

});
function comparefunc()
{
    document.location.href = rooturl + 'site/productcompare/index/pid/' + pid;
}
</script>
{/literal}
