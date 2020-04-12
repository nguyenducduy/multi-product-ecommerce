<!-- navigation bar -->
<div class="navbarprod asdasd">
    <ul>
        <li><a href="{$conf.rooturl}" title="Về trang chủ dienmay.com">Trang chủ</a> ››</li>
        <li><a href="{$currentCategory->getProductcateoryPath()}" title="{$currentCategory->name}">{$currentCategory->name}</a>{if !empty($myVendors->name)} ››{/if}</li>
    </ul>
</div>
{assign var="parentpromotionprices" value=$productDetail->promotionPrice()}
<!-- content -->
<div id="container">
    <div id="detail-head">
      <div class="head-left">
          <div id="zoomslide">
              {if !empty($crazydeal)}
                   <div class="special"> <i class="icon-crazydeal"></i></div>
              {else}
                    {if $productDetail->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                    {elseif $productDetail->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                    {elseif $productDetail->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                    {elseif $productDetail->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                    {elseif $productDetail->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                    {elseif $productDetail->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                     {elseif $productDetail->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-bettingg"></i></div>
                    {elseif $productDetail->onsitestatus == $OsNoSell || $productDetail->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                    {/if}
              {/if} <!-- End if khong phai crazydeal -->
              {if !empty($galleries)}
                  {foreach from=$galleries item=gal name=listgallery}
                      {if $smarty.foreach.listgallery.iteration==2}{break}{/if}
                      <div class="fixzoom">
                        <img data-zoom-image="{$gal->getImage()}" src="{if $gal->checkimagevalid($gal->getMediumImage()) == true}{$gal->getMediumImage()}{else}{$gal->getImage()}{/if}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}" id="zoom">
                      </div>
                  {/foreach}
                <div id="zoomslides">
                   {if count($galleries360) >= 36 && !empty($videos)}
                      {capture assign=numberslider}{4}{/capture}
                   {else}
                      {if count($galleries360) >= 36 || !empty($videos)}
                        {capture assign=numberslider}{5}{/capture}
                      {else}
                          {capture assign=numberslider}{6}{/capture}
                    {/if}
                  {/if}
                  {foreach from=$galleries item=gal key=key name=listgallery}
                      {if $smarty.foreach.listgallery.iteration== $numberslider}{break}{/if}
                    <a data-zoom-image="{$gal->getImage()}" data-image="{if $gal->checkimagevalid($gal->getMediumImage()) == true}{$gal->getMediumImage()}{else}{$gal->getImage()}{/if}" data-update="" class="elevatezoom-gallery  {if $smarty.foreach.listgallery.iteration==1}active{/if} withumb_{$key}" >
                      <img class="withumb" src="{$gal->getSmallImage()}" onclick="clickimage(this)" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}">
                    </a>
                  {/foreach}
                </div>
                {elseif $productDetail->getImage()!=''}
                    <div class="fixzoom">
                      <img data-zoom-image="{$productDetail->getImage()}" src="{$productDetail->getImage()}" id="zoom" >
                    </div>
                     <a data-zoom-image="{$productDetail->getImage()}" data-image="{$productDetail->getImage()}" data-update="" class="elevatezoom-gallery  active withumb_0" >
                      <img class="withumb" src="{$productDetail->getImage()}" onclick="clickimage(this)" alt="{$productDetail->name}">
                    </a>
                {/if}
            </div>
             <!-- load video -->
            {if count($galleries360) > 0 || !empty($videos)}
              {if !empty($videos)}
                <div id="videothumb"><a style="cursor:pointer">
                  <span class="iconvideoyoutube"></span>
                  <img src="http://img.youtube.com/vi/{$videos[0]->youtubeid}/default.jpg" alt="{$productDetail->name}"/></a>
                </div>
              {/if}
              <!-- load hình xoay 360 -->
              {if count($galleries360) >= 36}
                <div id="360thumb" class="i360thumb"><a style="cursor:pointer"><i class="icon-img360"></i></a></div>
              {/if}
            {/if}
          <div class="clear"></div>
      </div>
        {if $productDetail->onsitestatus == $OsERPPrepaid}

              <div class="pre_center">
                <div class="des_pre">
                  <h1>{if $currentCategory->appendtoproductname == 1}{$currentCategory->name} {/if}{if $productDetail->prepaidname != ''}{$productDetail->prepaidname}{else}{$productDetail->name}{/if}</h1>
                  <div class="area_pre">
                      <div class="pre_price">
                          <strong>Giá</strong>
                          <div class="pricepre"><span>{if $productDetail->prepaidprice > 1000}{$productDetail->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if}<sub>đ</sub></span></div>
                      </div>
                      <div class="pre-statistic">
                         {if !empty($prepaidnumberorders)} <span>Đã có <b> {$numberreorder}</b> người đặt trước</span>{/if}
                          <div class="fbcm">
                              <div class="productpath" style="display:none">{$productDetail->getProductPath()}</div>
                              <div class="cellsmall likepage">
                                <span></span>
                              </div>
                              <div class="cellcomm totalcomm"><a href="#comment" style=" margin-top: 8px;">Bình luận <span style="display:inline">(0)</span></a> </div>
                          </div>
                      </div>
                  </div>
                  <div class="bar_pre_center">
                    <div class="titinfo"><i class="icongiftpre"></i>Thông tin khuyến mãi</div>
                      <div class="titinfo"><i class="iconlistpre"></i>Thông tin sản phẩm</div>
                  </div>
                  <div class="giftpromo_pre">
                    <div class="infogift_pre">
                        <div class="areagift" id="loadpromotionlist">
                          <div class="gift-1"></div>
                        </div>
                      </div>
                      <div class="infodesc_pre">
                          {if $productDetail->summarynew != ''}
                            <ul>
                                {foreach from=$productDetail->summarynew item=summary name=summaryname}
                                  {if $smarty.foreach.summaryname.iteration == 6}
                                    {break}
                                  {/if}
                                  {if $summary != ""}
                                    <li>{$summary}</li>
                                  {/if}
                                {/foreach}
                                <li>  <div class="viewmore"><a id="moreview" class="readfullsumary" onclick="readfullsumary()" href="javascript:void(0)">Xem thêm ››</a></div></li>
                            </ul>
                          {/if}
                      </div>
                  </div>
                </div>
                <div class="area_time_pre">
                  <div class="date_pre">Ngày có hàng: <strong>{$productDetail->prepaidenddate|date_format:"%d/%m/%Y"}</strong></div>
                    {if $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
                    <div class="date_pre">
                      <div class="pre_countdown">
                          <span style="margin-right:3px">Còn lại:</span>
                            <div class="timedown" id="countbox1"></div>
                        </div>
                        <div class="btn-pre">
                        {if $productDetail->prepaidrand <= 0 || $numberreorder < $productDetail->prepaidrand}
                          <a href="{$registry->conf.rooturl}cart/dattruoc?id={$productDetail->id}"  class="buyprepaid"  {if !empty($parentpromotionprices.promoid)}&prid={$productDetail->barcode}_{$parentpromotionprices.promoid}{/if} title="Đặt hàng trước"><i class="icon-cart"></i>Đặt Mua Ngay</a>
                        {else}
                          <a href="javascript:void()" title="Đặt hàng trước" style="font:bold 13px Arial;background:#cacaca"><i class="icon-cart"></i>Đã đủ số lượng đặt trước</a>
                      </div>
                        {/if}
                    </div>
                    {else}
                      <div class="date_pre">
                        <div class="pre_countdown">
                            Hết thời gian đặt trước
                          </div>
                          <div class="btn-pre"><a href="javascript:void()" style="font:bold 13px Arial;background:#cacaca" title="Đặt hàng trước"><i class="icon-cart"></i>Hết thời gian đặt trước</a></div>
                      </div>
                    {/if}
                </div>
                </div>
              </div>
        {else}
        <!-- head-center -->
        <div class="head-center">
          <h1 class="nameproduct" id="productname">{if $currentCategory->appendtoproductname == 1}{$currentCategory->name} {/if}{$productDetail->name}{if $productcolorlist[0][2] != "" && $productcolorlist[0][2]|lower != 'không xác định'} - {$productcolorlist[0][2]}{/if}</h1>
            {assign var="parentpromotionprices" value=$productDetail->promotionPrice()}
            <div class="areacenter">
              {if !empty($crazydeal)}
                <!-- KKhông quan tâm màu -->
              {else}
                <div class="colorproduct">
                    <i class="textcolor">Màu sản phẩm:</i>
                    <ul>
                      {if count($productcolorlist) > 0}
                        {foreach from=$productcolorlist item=productcolor name=productcolorname}
                          {if $productcolor[0] > 0}
                          <li><a class="black color_{$productcolor[0]} {if $productcolor[4] == 1}actcolor{/if} productcolor" colorid="{$productcolor[0]}" rel="{$productcolor[1]|htmlspecialchars} - {$productcolor[2]}" style="background:#{$productcolor[3]};cursor: pointer"  title="{$productcolor[2]}"   {if $productcolor[0] > 1}onclick="productcolor(this)"{/if}></a></li>
                          {/if}
                        {/foreach}
                      {/if}
                    </ul>
                    {if $productDetail->sellprice > 0 && $productDetail->instock > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller)}
                      <div class="conhang addloading instockstatus">Còn hàng</div>
                    {elseif $productDetail->onsitestatus == $OsCommingSoon}
                      <div class="conhang addloading instockstatus">Hàng sắp về</div>
                    {elseif $productDetail->onsitestatus == $OsDoanGia}
                      <div class="conhang addloading"></div>
                    {else}
                      <div class="hethang addloading instockstatus">Hết hàng</div>
                    {/if}
                </div>
                {/if}
                <div class="totalcomm"><a href="#comment">Bình luận <span>(0)</span></a> </div>
                <div class="clear"></div>
            </div>
        	{if $productDetail->onsitestatus == $OsDoanGia}
        	<div id="productguess">
        	    	<!-- HTML DOAN GIA -->
        	    {if $productGuess->starttime >= time()}
            	<div class="areaguest">
                	{$productGuess->name}

                    {if $productDetail->summarynew != ''}
                    <ul>
                        {foreach from=$productDetail->summarynew item=summary name=summaryname}
                          {if $smarty.foreach.summaryname.iteration == 6}
                            {break}
                          {/if}
                          {if $summary != ""}
                            <li>{$summary}</li>
                          {/if}
                        {/foreach}
                    </ul>
                    {/if}
                    <div class="giftP3">
                    	<img src="{$currentTemplate}images/site/gifff.png"> {$productGuess->infogift}
                    </div>
                    <div class="counter-tt">Thời gian bắt đầu dự đoán:</div>
                    <div id="counter"></div>
                    <div class="btn-detail">
                    	<a href="javascript:;" onclick="showpopuptruleguess({$productGuess->id})">Xem chi tiết »</a>
                    </div>
                </div>
                {else}
                <div class="areaguest">
                	{$productGuess->name}
                    <div class="giftP3 giftP32">
                    	<img src="{$currentTemplate}images/site/gifff.png"> {$productGuess->infogift}
                    </div>
                    <div class="counter-tt counter-tt2">Thời gian còn lại:</div>
                    <div id="counter" class="counter"></div>
                    <div class="btn-detail btn-vtl">
                    	<a href="javascript:;" onclick="showpopuptruleguess({$productGuess->id})">Xem chi tiết »</a>
                    </div>
                </div>
                <div class="p3question">
               	  <div id="answesitem" data-id="{$productGuess->id}" >
        	      </div>
                <label class="p3alert"></label>
                <label class="loadinggif p3alert guessloading"></label>
                </div>
                {/if}
              </div>
               <!-- End DOAN GIA -->
        	{else}
          <div class="areadescshort">
            {if $productDetail->summarynew != ''}
            <ul>
                {foreach from=$productDetail->summarynew item=summary name=summaryname}
                  {if $smarty.foreach.summaryname.iteration == 6}
                    {break}
                  {/if}
                  {if $summary != ""}
                    <li>{$summary}</li>
                  {/if}
                {/foreach}
                <li>  <div class="viewmore"><a id="moreview" class="readfullsumary" onclick="readfullsumary()" href="javascript:void(0)">Xem thêm ››</a></div></li>
            </ul>
            {/if}
            {if $productDetail->warranty > 0}
              <div class="warranty"><span><i class="icon-help"></i>Bảo hành chính hãng <strong>{if !empty($productDetail->warranty)}{$productDetail->warranty}{/if} tháng</strong></span></div>
            {else}
                <div class="warranty"><span><i class="icon-help"></i>Đảm bảo 100% <br> <b>hàng chính hãng</b></span></div>
            {/if}
            <!--<div id="regionbox" style="float: right; overflow: hidden; width: 200px; font: 13px/18px Arial; margin-top: 10px;">
              <label style="clear: both; display: block;">Giao hàng đến</label>
              <select name="myregiondetail" id="fcitydetail" class="provincedetail" style="padding: 5px; width: 100%">
                <option value="">---Tỉnh/Thành---</option>
                  {foreach item=region key=regionid from=$setting.region}
                      <option value="{$regionid}" {if {$regionid}=={$me->city}}selected{/if} >{$region}</option>
                  {/foreach}
              </select>
            </div>-->
            <div class="clear"></div>
          </div>
          <div class="areapricegift">
            {if !empty($crazydeal)}
                {if $productDetail->displaysellprice != 1 && $productDetail->sellprice > 0 && !empty($parentpromotionprices.price) &&$parentpromotionprices.price<$productDetail->sellprice}
                  <!-- San pham co khuyen mai -->
                  <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                    <div class="wrapdienmay">
                      <div class="dienmay">
                          <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                          <div class="pricedienmay"><span class="pricenew">{if $parentpromotionprices.price > 1000}{$parentpromotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                      </div>
                      <div class="genuine">
                          <div class="textgenuine">Giá thị trường:</div>
                          <div class="pricegenuine"><span class="priceold">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                      </div>
                    </div>
                    <div class="econo">
                        <div class="textecono">Bạn tiết kiệm được:</div>
                        {if !empty($listprices.online) && $listprices.online > 1000}
                                {assign var="finalprice" value=$listprices.online}
                              {elseif !empty($listprices.offline) && $listprices.offline > 1000}
                                {assign var="finalprice" value=$listprices.offline}
                              {elseif $productDetail->sellprice > 1000}
                                {assign var="finalprice" value=$productDetail->sellprice}
                              {else}{assign var="finalprice" value=1000}{/if}
                              <div class="priceecono"><span>{math|number_format equation="x - y" x=$finalprice y=$parentpromotionprices.price format="%.0f"}đ</span> (  <span class="persale"> -{(($productDetail->sellprice - $parentpromotionprices.price)/$productDetail->sellprice * 100)|floor}%</span> )
                        </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                  <!-- End san pham co khuyen mai -->
                  {elseif $productDetail->sellprice > 0}
                  <!-- San pham khong co khuyen mai -->
                  <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                    <div class="dienmay">
                        <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                        <div class="pricedienmay"><span class="pricenew">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                    </div>
                    </div>
                    <!-- End san pham khong co khuyen mai -->
                {/if}
                <div class="areagift" style="display: none;" id="loadpromotionlist">
                <div class="gift-1"><i class="icon-gift"></i></div>
              </div>
              <div class="crazydetail"><span>Sản phẩm Crazy deal. Giá cực tốt 1 ngày duy nhất</span>
                <div class="crazydeal" style="margin-top:10px"><a title="Crazy deal là gì ?" href="#">Crazy deal là gì <span>?</span></a>
                    <div class="dropcrazy"><b>CrazyDeal</b> là chương trình giá shock mỗi ngày của <span class="text-dienmay"><strong>dienmay</strong>.com</span>span>. Theo đó, mỗi ngày chúng tôi sẽ giảm giá đến <b>50%</b> cho 01 sản phẩm bất kì.</div>
                </div>
                <div class="clear"></div>
              </div>
              <div class="wrap-sale">
                <div class="dealtime" id="countbox1"></div>
                <div class="datesatus"><i>Thời gian còn lại:</i></div>
              </div>
            {else}
              {if $productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller}
                {if $productDetail->displaysellprice != 1 && $productDetail->sellprice > 0 && !empty($parentpromotionprices.price) &&$parentpromotionprices.price<$productDetail->sellprice}
                <!-- San pham co khuyen mai -->
                 <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                  <div class="wrapdienmay">
                    <div class="dienmay">
                        <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                        <div class="pricedienmay"><span class="pricenew">{if $parentpromotionprices.price > 1000}{$parentpromotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                    </div>
                    <div class="genuine">
                        <div class="textgenuine">Giá thị trường:</div>
                        <div class="pricegenuine"><span class="priceold">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                    </div>
                  </div>
                  <div class="econo">
                      <div class="textecono">Bạn tiết kiệm được:</div>
                      {if !empty($listprices.online) && $listprices.online > 1000}
                              {assign var="finalprice" value=$listprices.online}
                            {elseif !empty($listprices.offline) && $listprices.offline > 1000}
                              {assign var="finalprice" value=$listprices.offline}
                            {elseif $productDetail->sellprice > 1000}
                              {assign var="finalprice" value=$productDetail->sellprice}
                            {else}{assign var="finalprice" value=1000}{/if}
                            <div class="priceecono"><span>{math|number_format equation="x - y" x=$finalprice y=$parentpromotionprices.price format="%.0f"}đ</span> (  <span class="persale"> -{(($productDetail->sellprice - $parentpromotionprices.price)/$productDetail->sellprice * 100)|floor}%</span> )
                      </div>
                  </div>
                  <div class="clear"></div>
                </div>
                <!-- End san pham co khuyen mai -->
                {elseif $productDetail->sellprice > 0}
                  <!-- San pham khong co khuyen mai -->
                 <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                   <div class="dienmay">
                      <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                      <div class="pricedienmay"><span class="pricenew">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                  </div>
                  </div>
                  <!-- End san pham khong co khuyen mai -->
                {/if}
                {elseif $productDetail->onsitestatus == $OsCommingSoon}
                <!-- hANG Sap ve -->
                  <div class="dienmay">
                      <div class="textdienmay">Giá dự kiến <span class="text-dienmay"><strong>dienmay</strong>.com</span>: </div>
                      <div class="pricedienmay"><span>{if $productDetail->comingsoonprice > 0}{$productDetail->comingsoonprice|number_format} đ{else}Chưa có giá{/if}</span></div>
                      {if $productDetail->comingsoondate != ""}
                      <div class="datesatus dattruoc"><i>Dự kiến có hàng:</i><strong>{$productDetail->comingsoondate}</strong></div>
                      {/if}
                  </div>
                  <div class="notestatus">
                    <div class="textnote"><i>Lưu ý:</i>
                        <p>Giá trên chỉ là giá dự kiến của <span class="text-dienmay"><strong>dienmay</strong>.com</span> và không phải là giá bán cuối cùng của sản phẩm này<br>
                          Giá sẽ được cập nhật khi sản phẩm chính thức ra mắt
                          </p>
                      </div>
                  </div>
                <!-- End  hang sap ve-->
                {elseif (!empty($listprices.online) && $listprices.online >0 ) || (!empty($listprices.offline) && $listprices.offline > 0)}
                 <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                  <div class="dienmay">
                        <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                        <div class="pricedienmay"><span class="pricenew">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                    </div>
                  </div>
              {/if}
              <div class="areagift" style="display: none;" id="loadpromotionlist">
                <div class="gift-1"><i class="icon-gift"></i></div>
              </div>
            {/if}
              <div class="wrap-sale">
                {if !empty($crazydeal)}
                       <!-- Mua ngay -->
                   <div class="btn-buy"><a href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}"  id="buyonline"> <i class="icon-cart"></i> Mua ngay</a></div>
                  <!-- End mua ngay -->
                {else}
                <!-- BTN MUA -->
                {if $productDetail->instock > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller) && $productDetail->sellprice > 0}
                  <!-- Mua ngay -->
                   <div class="btn-buy"><a href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}"  id="buyonline"> <i class="icon-cart"></i> Mua ngay</a></div>
                  <!-- End mua ngay -->
                {elseif $productDetail->onsitestatus == $OsCommingSoon}
                  <!-- Coming soon -->
                  <div class="btn-hsapve">
                    <a href="javascript:void(0)" class="buyprepaid" title="HÀNG SẮP VỀ">HÀNG SẮP VỀ</a>
                  </div>
                  <!-- Comming soon -->
                 {else}
                  <!-- Het hang -->
                    <div class="btn-hethang" >
                      <a href="javascript:void(0)" class="buyprepaid" style="background:#cacaca" title="Tạm thời hết hàng">Tạm thời hết hàng</a>
                    </div>
                    <form method="post" action="">
                      <div class="theendtext">
                        <input type="hidden" value="{$smarty.session.endstocksubcriberAddToken}" id="ftoken" name="ftoken">
                        <i>Gửi email cho tôi khi hàng trở lại:</i>
                        <div class="notifi" style="display:none;color:#00a1e6;margin: 3px 0px"></div>
                        <input class="theendinput" name="femail" id="femail" type="text" placeholder="Email của bạn">
                        <a href="javascript:void()" class="btntheend" rel="{$productDetail->id}" onclick="subcriberendofstock(true,$('#ftoken').val(),$('#femail').val())">Gửi</a>
                      </div>
                    </form>
                  <!-- End het hang -->
                 {/if}
                <!-- END BTN MUA -->
                <!-- Sieu thi con hang -->
                <div class="btn-spmark">
                {if ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller || $productDetail->onsitestatus == $OsCrazySale) && $productDetail->instock > 0}
                  {if !empty($havestorestock)}
                    <a href="#" title="Siêu thị còn hàng"><i class="icon-chart"></i>Có {if $havestorestock|count > 0}{$havestorestock|count}{/if} siêu thị sẵn hàng</a>
                    <div class="dropsthi">
                      <ul>
                          {foreach from=$havestorestock item=str}
                            {if $str->lat !=0 && $str->lng !=0}
                              <li><a href="{$registry->conf.rooturl}sieuthi/{$str->slug}" target="_blank" id="{$str->lat}_{$str->lng}" rel="{$str->region}_{$listregions[$str->region]->lat}_{$listregions[$str->region]->lng}" title="{$str->name}">{$str->name}
                                <span>{$str->storeaddress}</span>
                                  </a>
                              </li>
                            {/if}
                          {/foreach}
                        </ul>
                    </div>
                  {/if}
                {/if}
                  </div>
                <!-- End sieu thi con hang -->
              {/if} <!-- End crazy deal -->
              </div>
          </div>
          {/if}
      </div>
      {/if}
      <!-- head - right -->
       {if $productDetail->onsitestatus == $OsERPPrepaid}
          <div class="des_right">
           {if !empty($prepaidnumberorders)}
            <div class="list_pre">

              <div class="bar_list_pre">
                {if $productDetail->prepaidrand >0}
                  {if ($productDetail->prepaidrand - $numberreorder) > 0}
                  Chỉ còn <b>{$productDetail->prepaidrand - $numberreorder}</b> đơn hàng có thể đặt trước
                  {else}
                    Đã đủ số lượng đơn hàng đặt trước
                  {/if}
                {else}
                  Đã có <b>{$numberreorder}</b> đơn hàng đặt trước
                {/if}
              </div>
              <ul>
                  {foreach from=$prepaidnumberorders item=userprepaid key=prepaidposition name=userprepaid}
                    <li> <strong>{$userprepaid|capitalize:true}</strong>
                    <span style="margin-left:0"> {Helper::time_ago($prepaidnumberorderstime[$prepaidposition])} trước</span>
                    </li>
                  {/foreach}
              </ul>
              <div class="viewall_pre">
                <a href="javascript:void(0)" onclick="showpopupprepaid({$productDetail->id})"> Xem tất cả ››</a>
              </div>
            </div>
            {/if}
            {if $productDetail->prepaidpolicy}
            <div class="policy_pre">
              <ul>
                  {$productDetail->prepaidpolicy}
              </ul>
            </div>
            {/if}
        </div>
       {else}
      <div class="head-right">
         {if $productDetail->onsitestatus == $OsDoanGia}
         <!-- USER CHOI DOAN GIA -->
      		 {if $productGuess->starttime >= time()}
      			 {$productGuess->blocknews}
    		 {else}
			   {if !empty($userguess)}
	          <div class="listorder">
	              <ul>
	                <li class="til">{$totaluserguess} người tham gia</li>
	                   {foreach from=$userguess item=user}
	                    <li>{$user->fullname}<span style="margin-left:0">tham gia {Helper::time_ago($user->datecreated)} trước</span></li>

	                  {/foreach}
	                    <li><a href="javascript:void(0)" onclick="showpopupuserguess({$productGuess->id})"> Xem tất cả ››</a></li>
	              </ul>
	            </div>
    	       {else}
    	         	{$productGuess->blocknews}
    	       {/if}
		      {/if}
	         <ul>
                <li>
                   <div class="sharepage sharebor">
                      <div class="productpath" style="display:none">{$productDetail->getProductPath()}</div>
                       <label class="fom">Chia sẻ sản phẩm này</label>
                       <span><a href="https://www.facebook.com/sharer/sharer.php?u={$productDetail->getProductPath()}" target="_blank"><i class="icon-face"></i></a></span>
                       <span><a href="https://plus.google.com/share?url={$productDetail->getProductPath()}" target="_blank"><i class="icon-goog"></i></a></span>
                       <span><a href="http://twitthis.com/twit?url={$productDetail->getProductPath()}" target="_blank"><i class="icon-twitter"></i></a></span>
                       <div style="margin-top:5px" class="likepage"><span></span></div>
					             <div class="clear"></div>
                   </div>
                </li>
                <li><i class="icon-policy"></i>Đảm bảo 100% hàng chính hãng</li>
                <li><i class="icon-comp"></i>Đổi trả hàng trong 7 ngày (*)</li>
                <li><i class="icon-guide"></i>Dịch vụ khách hàng tốt nhất</li>
                <li>
                  <div class="numbercall"><i class="icon-numcall"></i><span>1800 1061</span></div>
                </li>
            </ul>
         <!-- END USER CHOI DOAN GIA -->
          {else}
         	{if !empty($prepaidnumberorders)}
          <div class="listorder">
              <ul>
                <li class="til">Đã có {$numberreorder} người đặt trước</li>
                   {foreach from=$prepaidnumberorders item=userprepaid key=prepaidposition name=userprepaid}
                    <li>{$userprepaid|capitalize:true}<span style="margin-left:0"> {Helper::time_ago($prepaidnumberorderstime[$prepaidposition])} trước</span></li>

                  {/foreach}
                    <li><a href="javascript:void(0)" onclick="showpopupprepaid({$productDetail->id})"> Xem tất cả ››</a></li>
              </ul>
            </div>
            {else}
            {if $myVendor->name != ''}
              <div class="maker">{if $myVendor->getImage() != ""}<img src="{$myVendor->getImage()}"/>{else}{$myVendor->name}{/if}</div>
              {/if}
           {/if}
              <ul>
                <li class="productbookmark"><a id="addproductbookmark" onclick="return addproductbookmark();" rel="{$productDetail->id}" data-barcode="{$productDetail->barcode}"  href="javascript:;"><i class="icon-heart"></i>Tôi thích sản phẩm này</a></li>

                {if $productDetail->sellprice > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller) && $productDetail->instock >0 && $installments.PPF.nosupport == 1 && !empty($installments.PPF.monthly)}

                  <li><a href="javascript:void(0)" title="Mua trả góp" id="installment" rel="{$productDetail->id}" ><i class="icon-inst"></i> Mua trả góp từ <span class="installment">{$installments.PPF.monthly|round|number_format}đ/tháng</span></a></li>

                 {elseif $productDetail->sellprice > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller) && $productDetail->instock >0 && $installments.ACS.nosupport == 1 && !empty($installments.ACS.monthly)}
                      <li><a href="javascript:void(0)" title="Mua trả góp" id="installment" rel="{$productDetail->id}" ><i class="icon-inst"></i> Mua trả góp từ <span class="installment">{$installments.ACS.monthly|round|number_format}đ/tháng</span></a></li>
                 {/if}
                <li>
                   <div class="sharepage sharebor">
                        <div class="productpath" style="display:none">{$productDetail->getProductPath()}</div>
                       <label class="fom">Chia sẻ sản phẩm này</label>
                       <!--<span><a href="#"><i class="icon-mail"></i></a></span> -->
                       <span><a href="https://www.facebook.com/sharer/sharer.php?u={$productDetail->getProductPath()}" target="_blank"><i class="icon-face"></i></a></span>
                       <span><a href="https://plus.google.com/share?url={$productDetail->getProductPath()}" target="_blank"><i class="icon-goog"></i></a></span>
                       <span><a href="http://twitthis.com/twit?url={$productDetail->getProductPath()}" target="_blank"><i class="icon-twitter"></i></a></span>
                       <!--<span><a href="#"><i class="icon-youtube"></i></a></span> -->
                       <div class="clear"></div>
                   </div>
                </li>
                <li><i class="icon-policy"></i>Đảm bảo 100% hàng chính hãng</li>
                <li><i class="icon-comp"></i>Đổi trả hàng trong 7 ngày (*)</li>
                <li><i class="icon-guide"></i>Dịch vụ khách hàng tốt nhất</li>
                <li>
                  <div class="numbercall"><i class="icon-numcall"></i><span>1800 1061</span></div>
                </li>
                <li>
                   <div class="likepage">
                        <span></span>
                    </div>
                </li>
            </ul>
             {/if}
        </div>
        {/if}
        <div class="clear"></div>
    </div>
    <!-- content detail -->
    <div class="articlesdetail">
    <div class="main">
      <article class="post__article">
        {if !empty($productDetail->fullbox) && !empty($specialimage)}
        <h6>Chức năng - Kích thước</h6>
          <div id="feature">
            <div class="featcol">

              <div class="featbar"><h2>Mô tả tính năng</h2></div>
                {$productDetail->fullbox}
                </div>
                <div class="featcol featfloat">
                    <div class="featbar"><h2>Kích thước sản phẩm</h2></div>
                     <img src="{$specialimage}" alt="{$productDetail->name}" />
                </div>
            </div>
        {/if}
        {if !empty($galleries) || !empty($videos)}
        <h6>Hình ảnh - Video</h6>
         <!-- gallery video -->
          <div id="gallery" class="s2">
            <!-- gallery -->
            <div class="glalery_one" {if empty($videos)}style="width:100%"{/if}>
              <div class="galvidbar titlename"><h2>Hình ảnh sản phẩm</h2></div>
              <!-- Xoay 360 -->
              <!--<div id="360frames"></div>-->
              <!-- end xoay 360 -->
              <div class="doubleSlider-1">
                <div class="slider">
                  {foreach from=$galleries item=gal name=listimag}
                    <div class="item thumnail">
                      <img border="0" title="{if !empty($gal->caption)}{$gal->caption}{else}{$gal->titleseo}{/if}" src="{$gal->getImage()}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}">
                    </div>
                 {/foreach}
                </div>
              </div>
              <div class="wrapButtonslide">
                <div class="doubleSliderPrevButton" style="cursor: pointer;"></div>
                <div class="doubleSliderNextButton" style="cursor: pointer;"></div>
              </div>
              {if count($galleries360) >= 36}
              <div class="cell360px"><a href="javascrip:void()"><i class="icon-img360"></i></a></div>
              {/if}
              <div class="doubleSlider-2">
                <div class="slider">
                   {foreach from=$galleries item=gal name=listimag}
                      <div class="button thumnail borderfirst actived"><img border="0" title="{if !empty($gal->caption)}{$gal->caption}{else}{$gal->titleseo}{/if}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}" src="{$gal->getSmallImage()}"></div>
                  {/foreach}
                </div>
              </div>
            </div>
            <!-- video -->
          {if !empty($videos)}
            <div class="wrap-video" id="#video">
                <div class="galvidbar titlename"><h2>Video sản phẩm</h2></div>
                <div class="group-video">
                  <div id="runyoutubeurl" class="video-larg">
                    <iframe width="420" height="390" frameborder="0" allowfullscreen="" src="{$videos[0]->moreurl}"></iframe>
                    <input type="hidden" class="contentvideo" value="{$videos[0]->moreurl}"/>
                  </div>
                  {if $videos|@count > 0}
                    <div class="video-small">
                      <ul>
                        {foreach from=$videos item=video name=videonamesmart}
                            {if !empty($video->moreurl)}
                                <li class="{if $smarty.foreach.videonamesmart.first}activede{/if} popupvideo" rel="{$video->moreurl}"><img src="http://img.youtube.com/vi/{$video->youtubeid}/default.jpg" alt="{$productDetail->name}"/></li>
                            {/if}
                        {/foreach}
                      </ul>
                    </div>
                  {/if}
                  <ul class="nguon-youtube">
                      <li>
                        Nguồn Youtube
                      </li>
                  </ul>
                </div>
              </div>
            {/if}
          </div>
        {/if}
         <!-- ================== -->
        <h6>Giới thiệu sản phẩm</h6>
        <div class="wrap_article" {if $relProductProduct|@count<0}style="width:100%"{/if}>
         <!-- Bài viết -->
         {if !empty($productDetail->content)}
            <div id="articles" class="s3">
                <div class="articlesbar" id="introduction"><h2>Bài viết sản phẩm</h2></div>
                <div class="articles">
                  {$productDetail->content}
                </div>
                <!-- nut mua ngay -->
                {if $productDetail->onsitestatus == $OsERPPrepaid && $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
                 <!-- TH1 Dat truoc-->
                  <div class="btnbuynow btn-muangay">
                    <a href="{$registry->conf.rooturl}cart/dattruoc?id={$productDetail->id}" class="buyprepaid" rel="{$productDetail->id}"{if !empty($parentpromotionprices) && $parentpromotionprices.promoid >0} id="{$productDetail->barcode}_{$parentpromotionprices.promoid}"{/if} title="Đặt hàng trước">Đặt trước &#187;</a>
                  </div>
               {elseif $productDetail->instock > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller) && $productDetail->sellprice > 0}
                <!--TH2 -->
                   <div class="btnbuynow btn-muangay"><a  href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}{if !empty($parentpromotionprices.promoid) && $productDetail->slug != ""}&{else}?{/if}po=p{substr($productDetail->barcode|trim, -5, 5)}41"  id="buyonline"> Mua ngay &#187;</a></div>
              {elseif $productDetail->onsitestatus == $OsCommingSoon}
                <!-- TH3 -->
              {else}
                <!-- HET HANG -->
              {/if}
                <!-- end nut mua ngay -->
            </div>
        {/if}
            <!-- Sản phẩm liên quan -->
          <div class="related sticktop">
            {if $relProductProduct|@count>0}
          <div class="relatedbar"><h2>Sản phẩm liên quan</h2></div>
          <ul>
             {foreach from=$relProductProduct item=product name=relpp}
                {if $smarty.foreach.relpp.iteration == 6}{break}{/if}
                {assign var="promotionprices" value=$product->promotionPrice()}

              <li>
                 {if $product->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                  {elseif $product->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                  {elseif $product->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                  {elseif $product->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                  {elseif $product->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                  {elseif $product->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                  {elseif $product->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                  {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                  {/if}
                <a href="{$product->getProductPath()}?ref=related_product_link"><h4>{$product->name}</h4></a>
                <div class="imageproductsame"><a href="{$product->getProductPath()}?ref=related_product_link" title="{$product->name|escape}"><img src="{$product->getSmallImage()}" alt="{$product->name|escape}" title="{$product->name|escape}" /> </a> </div>
                {if $product->displaysellprice!=1 && $product->sellprice>0 && ($product->onsitestatus == $OsERP || $product->onsitestatus == $OsHot || $product->onsitestatus == $OsNew || $product->onsitestatus == $OsBestSeller) && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
                  <div class="priceold price1">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                        <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                        <span class="salepercent"> -{(($product->sellprice - $promotionprices.price)/$product->sellprice * 100)|floor}%</span>
               {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
                         <div class="pricenew price2">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                       {elseif $product->sellprice >0}
                         <div class="pricenew price2">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                       {/if}
              </li>
              {/foreach}
            </ul>
            {/if}
           </div>
        </div>
         <!-- ================== -->
       <div class="clear"></div>
         <!-- Thông tin thương hiệu -->
         {if $myVendor->insurance != ""}

        <h6>Thông tin thương hiệu</h6>
            <div id="infobrand">
                <div class="articlesbar"><h2>Thông tin thương hiệu</h2></div>
                {if $myVendor->getImage() != ""}
                  <img src="{$myVendor->getImage()}" alt="{$myVendor->name}"/>
                {/if}
                <p>{$myVendor->insurance}</p>
                <a href="{$registry->conf.rooturl}{$myVendor->slug}" title="Xem tất cả sản phẩm khác của {$myVendor->name}">Xem tất cả sản phẩm khác của {$myVendor->name} ›› </a>
            </div>
          {/if}
            <!-- Mua kèm -->
            {if !empty($accessoriesProducts)}
            <div id="accessory">
                <div class="articlesbar"><h2>Khách hàng mua sản phẩm này thường mua kèm với nhau</h2></div>
                <div class="accesscont" id="accessoryparentbox">
                    <div class="accessleft">
                        <div class="accessimg"><img src="{$productDetail->getSmallImage()}" /></div>

                        <div class="accesslist">
                          {foreach from=$accessoriesProducts item=accessory name=assessoryproducts}
                            <div class="accessmath" id="accessmath_{$accessory->id}">+</div>
                            <div class="accessproduct" id="accessproduct_{$accessory->id}">
                                <a href="{$accessory->getProductPath()}" title="{$accessory->name}"><img src="{$accessory->getSmallImage()}" alt="{$accessory->name}" /></a>
                            </div>
                          {/foreach}
                        </div>
                        <!-- ==== -->
                            <div class="clear"></div>
                            {foreach from=$accessoriesProducts item=accessory name=assessoryproducts}
                              {assign var="promotionprices" value=$accessory->promotionPrice()}
                                  {if $accessory->displaysellprice!=1 && !empty($promotionprices.price) && $promotionprices.price<$accessory->sellprice}
                                  <div class="accessprice-2">
                                    <label style="cursor: pointer"><input class="acccheck chkaccessory" name="access_{$accessory->id}" rel="{$accessory->id}" type="checkbox" checked="checked" value="{$accessory->id}" />
                                        <a>{$accessory->name}</a>
                                        <div class="accessprice-1" style="float:left;margin-left:9px">{$accessory->sellprice|number_format}đ</div>
                                        <div class="accessprice-2"><span>{$promotionprices.price|number_format}đ</span></div>
                                      </label>
                                  </div>
                              {else}
                                  <div class="accessprice-2">
                                    <label style="cursor: pointer"><input class="acccheck chkaccessory" name="access_{$accessory->id}" rel="{$accessory->id}" type="checkbox" checked="checked" value="{$accessory->id}" />
                                      <a>{$accessory->name}</a>
                                  <span>{$accessory->sellprice|number_format}đ</span>
                                  </label>
                                </div>
                              {/if}
                            {/foreach}
                    </div>
                    <div class="accessmath">=</div>
                    <div class="accessright" id="accessorybox" rel="{$productDetail->id}">
                        {if !empty($parentpromotionprices) && !empty($parentpromotionprices.price) && $parentpromotionprices.price < $productDetail->sellprice}

                          <div class="accessrow" id="priceretail">Giá mua lẻ: <span>{$productDetail->sellprice|number_format}đ</span></div>
                          <div class="accessrow" id="priceassessory">Giá mua kèm: <strong>{$parentpromotionprices.price|number_format}đ</strong></div>
                          <div class="accessrow" id="pricesaving">Tiết kiệm: <span>{math|number_format equation="x - y" x=$productDetail->sellprice y=$parentpromotionprices.price format="%.0f"}đ</span></div>
                          {else}
                          <div class="accessrow">Giá mua: <strong>{$productDetail->sellprice|number_format}đ</strong></div>
                          {/if}
                          <div class="accessrow accbtn"><a href="javascript:void(0)" id="addaccessoryproduct" onclick="addaccessorytocart()">Mua sản phẩm đã chọn</span></a></div>
                    </div>
                </div>
            </div>
            {/if}
         <!-- ======================= -->
        <h6>Nhận xét</h6>
         <!-- Comment -->
            <div id="comment">

            </div>
         <!-- ================= -->
         <h6><a class="readfullsumary" href="javascript:void(0)">Thông số kỹ thuật</a></h6>
         <div style="min-height:450px; display:none"></div>
        <!--<a class="iframe" href="thong-so-ky-thuat.html"><h4>Thong số kỹ thuật</h4></a>-->
      </article>
  </div>
    <!-- Sản phẩm đề nghị -->

     {if $relProductProduct|@count>5}

    <div id="interested">
          <div class="articlesbar"><h2>Có thể bạn quan tâm</h2></div>
            <div class="products">

                        <ul>
                          {section name=item loop=$relProductProduct start=5 max=5}
                            {assign var="promotionprices" value=$relProductProduct[item]->promotionPrice()}

                          <li>
                            {if $relProductProduct[item]->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                            {elseif $relProductProduct[item]->onsitestatus == $OsNoSell || $relProductProduct[item]->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                            {/if}
                            <a href="{$relProductProduct[item]->getProductPath()}?ref=you_may_interest_link" title="{$relProductProduct[item]->name|escape}"><img src="{$relProductProduct[item]->getSmallImage()}" alt="{$relProductProduct[item]->name|escape}" title="{$relProductProduct[item]->name|escape}" /> </a> <a class="position-a" href="{$relProductProduct[item]->getProductPath()}?ref=you_may_interest_link"><h3>{$relProductProduct[item]->name}</h3>
                            </a>
                            {if $relProductProduct[item]->displaysellprice!=1 && $relProductProduct[item]->sellprice>0 && ($relProductProduct[item]->onsitestatus == $OsERP || $relProductProduct[item]->onsitestatus == $OsHot || $relProductProduct[item]->onsitestatus == $OsNew || $relProductProduct[item]->onsitestatus == $OsBestSeller) && !empty($promotionprices.price) && $promotionprices.price<$relProductProduct[item]->sellprice}
                              <div class="priceold price1">{if $relProductProduct[item]->sellprice > 1000}{$relProductProduct[item]->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                    <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                    <span class="salepercent"> -{(($relProductProduct[item]->sellprice - $promotionprices.price)/$relProductProduct[item]->sellprice * 100)|floor}%</span>
                           {elseif $relProductProduct[item]->onsitestatus == $OsERPPrepaid && $relProductProduct[item]->prepaidstartdate <= $currentTime && $relProductProduct[item]->prepaidenddate >= $currentTime}
                                     <div class="pricenew price2">{if $relProductProduct[item]->prepaidprice > 1000}{$relProductProduct[item]->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                   {elseif $relProductProduct[item]->sellprice >0}
                                     <div class="pricenew price2">{if $relProductProduct[item]->sellprice > 1000}{$relProductProduct[item]->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                   {/if}
                          </li>
                           {/section}
                        </ul>

                    </div>
        </div>
        {/if}
        <!--Thong so ky thuat full-->
    <div class="conttable" style="display: none;" id="attrfull">
        <div class="conttitle" style="position: relative;"> Chi tiết tính năng sản phẩm</div>
        {if $productGroupAttributes|@count>0 && $productAttributes|@count>0 && $relProductAttributes|@count>0}
            <table class="martable" cellspacing="0" width="100%" cellpadding="0" style="margin-top: 0;">
            {foreach item=groupattributes from=$productGroupAttributes}
            {if !empty($productAttributes[$groupattributes->id])}
            <tr>
                <td valign="top" class="generaltd">{$groupattributes->name}</td>
                <td class="generaltd-2">
                    <table width="100%" cellspacing="10" cellpadding="0">
                    {foreach from=$productAttributes[$groupattributes->id] item=attribute name=listproattr}
                        {if !empty($relProductAttributes[$attribute->id][$productDetail->id])}
                            <tr>
                                <td width="200">{$attribute->name}</td>
                                <td>{$relProductAttributes[$attribute->id][$productDetail->id]->value} {$productAttributes[$groupattributes->id][$attribute->id]->unit}</td>
                              </tr>
                        {/if}
                    {/foreach}
                </table>
                </td>
            </tr>
            {/if}
            {/foreach}
            </table>
        {/if}
    </div>
    <!--end-->
</div>

{literal}
<script type="text/javascript">
  // add 360
  //ENd 360
  var doangia = "{/literal}{if $productDetail->onsitestatus == $OsDoanGia}1{else}0{/if}{literal}";
  var fpcid = "{/literal}{$productDetail->pcid}{literal}";
  var pid = "{/literal}{$productDetail->id}{literal}";
  var fgpa = "{/literal}{$gpa}{literal}";
  var fpa = "{/literal}{$pa}{literal}";
  var prel = "{/literal}{$prel}{literal}";
  var image360path = "{/literal}{$pathimage360}{literal}";
  var countimagepath = "{/literal}{count($galleries360)}{literal}";
  if($('#360thumb').length > 0)
  {
    var framess = [];
    for(var i = 1 ; i<=countimagepath ; i++)
    {
        framess.push(image360path.replace('#',i));
    }
  }
  $(document).ready(function(){
      $('.likepage span').html('<iframe src="http://www.facebook.com/plugins/like.php?href='+$('.productpath').html()+'&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>');
      //Load comment
      initEditInline(fpcid, pid);
      loadReview(pid , '');
      //End load cmment
      //Creazydeal
      if($('.dropcrazy').length > 0){
        var dateFuture1 = '';
        $.post( rooturl+"product/gettimecrazydeal",{fpid:pid,fpcid:fpcid}, function(data) {
            var tmpdatetime = data.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateFuture1 = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
            GetCount(dateFuture1,'countbox1');
        });
      }
      //End crazydeal
      if($('.pre_countdown').length > 0){
        var dateFuture1 = '';
        $.post( rooturl+"product/gettimeprepaid",{fpid:pid}, function(data) {
            var tmpdatetime = data.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateFuture1 = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
            GetCount(dateFuture1,'countbox1');
        });
      }
      //Doan gia
      if(doangia == "1"){
	      if( pid == 62611){
	    	  	$("<p style='text-align: center; margin-bottom: 15px;'><img style='max-width: 100%;' src='https://ecommerce.kubil.app/uploads/pimages/Khuyen-mai/Event/doangiatab3lite/galaxy-lite-1200x160.jpg' alt='TRẢ LỜI HAY, TRÚNG NGAY NOKIA LUMIA 1320' /></p>" ).insertBefore("#detail-head");
	      }
        var dateguessprice = '';
  		  $.ajax({
    			type : "POST",
    			data : {fpid:pid,fpcid:fpcid},
    			url : rooturl+"product/gettimedoangia",
    			dataType: "json",
    			success: function(data){
    				if(data.error >= 0){
    					countdowntimestart(data.timestart, data.timeend);
    				}
    			}
  		  });
      }
      //End crazydeal

      $('.cell360px').bind('click',function(event) {
          $('#360sprite').addClass('loadingframe');
          $('.slider > img').css('display','none');
          $('.actived').removeClass('actived');
          $(this).addClass('actived');
          $('#360frames').remove();
          var doubleslider = $('.doubleSlider-1');
          doubleslider.prepend('<div id="360frames"></div>');
          xoay360(framess);
          $('.loadingframe').removeClass('loadingframe');
      });
      $('.thumnail > img').click(function(event) {
        $('.slider > img').css('display','block');
          $('#360frames').remove();
      });
      $('#360thumb a').bind("click",function(){
          $('.active').removeClass('active');
          $(this).parent().addClass('active');
          $('#zoomslide > .fixzoom ').css("display","none");
          if($('#zoomslide .fixzoomvideo > iframe').length > 0)
              $('#zoomslide .fixzoomvideo').remove();
          if($('#360sprite').length > 0)
              $('#360sprite').remove();
          $('#zoomslide').prepend('<div id="360sprite" class="image360">');
          $('.zoomContainer').css("display","none");
          xoay360thumb(framess);
      });
      $('#videothumb a').bind('click',function() {
          $('.active').removeClass('active');
          $(this).parent().addClass('active');
          $('#zoomslide > .fixzoom').css("display","none");
          if($('#360sprite').length > 0)
              $('#360sprite').remove();
          if($('#zoomslide .fixzoomvideo > iframe').length > 0)
              $('#zoomslide .fixzoomvideo').remove();
          var url = $('.contentvideo').val();
          $('#zoomslide').prepend('<div class="fixzoomvideo"><iframe width="400" height="380" frameborder="0" allowfullscreen="" src="'+url+'"></iframe></div>');
          $('.zoomContainer').css("display","none");
      });

      $('#fcitydetail').change(function(){
        $.post(rooturl + '', {rid: $(this).val()}, function(){

        });
      });
  });
  setTimeout(addfullsumary,1000);
  function addfullsumary()
  {
    $('.articlesdetail .main .scroll-nav .scroll-nav__wrapper li:last-child a').attr('href','javascript:void(0)');
    $('.articlesdetail .main .scroll-nav .scroll-nav__wrapper li:last-child a').attr('onclick','readfullsumary()');
  }

  function GetCount(ddate,iid){

    dateNow = new Date(); //grab current date
    amount = ddate.getTime() - dateNow.getTime(); //calc milliseconds between dates
    delete dateNow;
    // if time is already past
    if(amount < 0){
      if ($('.dropcrazy').length > 0) {
         $.post( rooturl+"product/updatestatusandpromotion",{fpid:pid,fpcid:fpcid}, function(data) {
            if(data == 1)
            {
              $('.crazydetail').remove();
              $('.datesatus').remove();
              $('.dealtime').remove();

              location.reload();
            }
         });
       }
       else {

       }
    }
    // else date is still good
    else{
      if ($('.dropcrazy').length > 0) {
        hours=0;mins=0;secs=0;out="";
        amount = Math.floor(amount/1000);
        hours=Math.floor(amount/3600);
        amount=amount%3600;
        mins=Math.floor(amount/60);
        amount=amount%60;
        secs=Math.floor(amount);//seconds
        if(hours != 0){out +="<div class='hours'>"+ hours +" "+((hours==1)?" ":"H")+" </div>  ";}
        out +="<div class='mins'>"+ mins +" "+((mins==1)?" ":" ' ")+" </div> ";
        out +="<div class='secs'>"+ secs +" "+((secs==1)?" ":" s ")+"</div>  ";
      }
      else {
        days=0;hours=0;mins=0;secs=0;out="";
        amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs
        days=Math.floor(amount/86400);//days
        amount=amount%86400;
        hours=Math.floor(amount/3600);//hours
        amount=amount%3600;
        mins=Math.floor(amount/60);//minutes
        amount=amount%60;
        secs=Math.floor(amount);//seconds
        if(days != 0){out += "<div style='float:left'><span>"+ days +"</span><strong>:</strong><b>Ngày</b></div>";}
        out +="<div style='float:left'><span>"+ hours +"</span><strong>:</strong><b>Giờ</b></div>";
        out +="<div style='float:left'><span>"+ mins +" </span><strong>:</strong><b>Phút</b></div>";
        out +=" <div style='float:left'><span>"+ secs +"</span><b>Giây</b></div>";
      }
      out = out.substr(0,out.length-2);
      document.getElementById(iid).innerHTML=out;
      setTimeout(function(){GetCount(ddate,iid)}, 1000);
    }
  }

  function countdowntimestart(timestart,timeend){
        var tmpdatetime = timestart.split(' ');
        var date = tmpdatetime[0].split('-');
        var time = tmpdatetime[1].split(':');
        dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
        dateNow = new Date();
        amount = dateguessprice.getTime() - dateNow.getTime();
        if(Math.floor(amount) > 0 ){

            if( $('#counter').is(':empty') ) {
	        	$('#counter').countdown({
	    			timestamp : Math.floor((new Date()).getTime() + amount)
    	  		});
        	 }
		}else{

			var tmpdatetime = timeend.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
            amount = dateguessprice.getTime() - dateNow.getTime();
            if(Math.floor(amount) <= 0){
            	clearTimeout();
                $.post( rooturl+"product/updatestatusdoangia",{fpid:pid,fpcid:fpcid}, function(data) {
                    if(data == 1)
                    {
                      location.reload();
                    }
                 });
	        }else{
		        if($(".p3question").length == 0 ){
		        	$.post( rooturl+"product/showformguess",{fpid:pid,fpcid:fpcid,action:'showformguess'}, function(data) {
	                    if(data != '')
	                    {
	                     	$('#productguess').html(data);
	                    }
	                 });
		        }
	        	if( $('#counter').is(':empty') ) {
		        	$('#counter').countdown({
		    			timestamp : Math.floor((new Date()).getTime() + amount)
	    	  		});
	        	 }
		        }
		}
    setTimeout(function(){countdowntimestart(timestart,timeend)}, 1000);
  }


</script>
{/literal}