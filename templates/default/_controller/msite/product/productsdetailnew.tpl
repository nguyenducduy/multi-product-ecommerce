<section>
      <div class="navibarlist">
          <ul>
          
              <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a> </li>
                <li><a href="{$currentCategory->getProductcateoryPath()}" title="{$currentCategory->name}">{$currentCategory->name}</a>{if !empty($myVendors->name)} ››{/if}</li>
            </ul>
        </div>
      {assign var="parentpromotionprices" value=$productDetail->promotionPrice()}

      <h1 class="nameproduct">{if $currentCategory->appendtoproductname == 1}{$currentCategory->name} {/if}{$productDetail->name}</h1>
        <!-- hình ảnh -->
        <div id="m-carousel-example-4" class="m-carousel m-fluid m-carousel-photos wrapgallery">
          <div class="tagstatus">
               {if $productDetail->onsitestatus == $OsERPPrepaid}<i class="icon-status5"></i>
                {elseif $productDetail->onsitestatus == $OsCommingSoon}<i class="icon-status2"></i>
                {elseif $productDetail->onsitestatus == $OsHot}<i class="icon-status3"></i>
                {elseif $productDetail->onsitestatus == $OsNew} <i class="icon-status1"></i>
                {elseif $productDetail->onsitestatus == $OsDoanGia} <i class="icon-status11"></i>
                {elseif $productDetail->onsitestatus == $OsBestSeller}<!-- <i class="icon-status4"></i> Neu la gift-->
                {elseif $productDetail->onsitestatus == $OsCrazySale}
                {elseif $productDetail->onsitestatus == $OsNoSell || $productDetail->instock == 0}<i class="icon-status8"></i>
                {/if}    
          </div>
             {if !empty($galleries)}
                <div class="m-carousel-inner" style="transform: translate(-2309px, 0px);">
               
                    {foreach from=$galleries item=gal name=listgallery}
                      <div class="m-item {if $smarty.foreach.listgallery.iteration == 1}m-active{/if}">
                          <div class="gallery"><img src="{$gal->getImage()}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}" title="{if !empty($gal->caption)}{$gal->caption}{else}{$gal->titleseo}{/if}"></div>
                      </div>
                      {if $smarty.foreach.listgallery.iteration == 5}
                        {break}
                      {/if}
                    {/foreach}
                
                </div>
                <!-- bullet -->
                {if $galleries|count >1}
                <div class="m-carousel-controls m-carousel-bulleted">
                  {foreach from=$galleries item=gal2 name=listgallery2}
                    <a data-slide="{$smarty.foreach.listgallery2.iteration}" href="#" {if $smarty.foreach.listgallery2.iteration == 1}class="m-active"{/if}>{$smarty.foreach.listgallery2.iteration}</a>
                      {if $smarty.foreach.listgallery2.iteration == 5}
                        {break}
                      {/if}
                  {/foreach}
                </div>
                {/if}
               {elseif $productDetail->getImage()!=''}
                  <div class="m-item m-active">
                          <div class="gallery"><img src="{$productDetail->getImage()}" alt="{$productDetail->name}" border="0" /></div>
                  </div>
                  <br/>
              {/if}
                <!-- <div class="colorproduct">
                  <ul>
                      <li class="red"><a class="selectcolor" href="#" title="Màu đỏ">red</a></li>
                        <li class="orange"><a href="#" title="Màu cam">orange</a></li>
                        <li class="yellow"><a href="#" title="Màu vàng">yellow</a></li>
                        <li class="blue"><a href="#" title="Màu xanh">blue</a></li>
                    </ul>
                </div> -->
                {if $galleries|count > 5 || (!empty($productDetail->fullbox) && !empty($specialimage)) || $videos|count > 0}
                <div class="viewallproducts"><a href="{$registry->conf.rooturl}product/loadfullgallery?pcid={$smarty.get.pcid}&pid={$smarty.get.pid}">Xem thêm hình ảnh ››</a></div>
                {/if}
            </div>
        <div class="pricesale">
       {if $productDetail->onsitestatus == $OsDoanGia} 
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
            <div id="counter">
            	<div class="J_days" style="display: inline;; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_hours" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_minutes" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_seconds" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
            </div>
            <div id="lablecounter">
            	<span class="Days">Ngày</span>
            	<span class="Hours">Giờ</span>
            	<span class="Minutes">Phút</span>
            	<span class="Seconds">Giây</span>
            </div>
           
            <div class="btn-detail">
            	<a href="{$conf.rooturl}product/showruleguess?pgid={$productGuess->id}">Xem chi tiết »</a>
            </div>
            
        </div>
        {else}
        <div class="areaguest">
        	{$productGuess->name}
            
            <div class="giftP3 giftP32">
            	<img src="{$currentTemplate}images/site/gifff.png"> {$productGuess->infogift}
            </div>
            <div class="counter-tt counter-tt2">Thời gian còn lại:</div>
            <div id="counter" class="counter">
            	<div class="J_days" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_hours" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_minutes" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_seconds" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
            </div>
             <div id="lablecounter">
            	<span class="Days">Ngày</span>
            	<span class="Hours">Giờ</span>
            	<span class="Minutes">Phút</span>
            	<span class="Seconds">Giây</span>
            </div>
            <div class="btn-detail btn-vtl">
            	<a href="{$conf.rooturl}product/showruleguess?pgid={$productGuess->id}" >Xem chi tiết »</a>
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
          <!-- Giá-->
          <div class="area">
              {if $productDetail->onsitestatus == $OsERPPrepaid}
                    <!-- Dat truoc-->
                  
        	<div class="des_pre">
            <h3><strong>{if !empty($productDetail->prepaidname)}{$productDetail->prepaidname}{else}{$productDetail->name}{/if}</strong></h3>
            <div class="area_pre">
            {if $productDetail->prepaidprice > 1000}
                <div class="pre_price">
                    <strong>Giá</strong>
                    <div class="pricepre"><span>{$productDetail->prepaidprice|number_format} <sub>đ</sub></span></div>
                </div>
                {/if}
                <div class="pre-statistic">
                    <span>Đã có <b>{$numberreorder}</b> người đặt trước</span>
                    <div class="fbcm">
                        <div class="cellsmall likepage">
                    
                        <span></span>
                   	
                        </div>
                        <div class="cellcomm totalcomm"><a href="#comment">Bình luận <span></span></a></div>
                    </div>
                </div>
            </div>
             <div class="area_time_pre">
        	<div class="date_pre">Ngày có hàng: <strong>{$productDetail->prepaidenddate|date_format:"%d/%m/%Y"}</strong></div>
            {if $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
            <div class="date_pre">
            	<div class="pre_countdown">
                	<span>Còn lại:</span>
                    <div class="timedown">
            			<div class="J_days" style="display: inline; border-radius:4px; padding:4px 8px; color : #fff; text-align:center; background:#FFA400; font:bold 20px Arial; margin-right:2px"></div> : 
        				<div class="J_hours" style="display: inline; border-radius:4px; padding:4px 8px; color : #fff;  text-align:center; background:#FFA400; font:bold 20px Arial; margin-right:2px"></div> : 
        				<div class="J_minutes" style="display: inline; border-radius:4px; padding:4px 8px; color : #fff;  text-align:center; background:#FFA400; font:bold 20px Arial; margin-right:2px"></div> :
        				<div class="J_seconds" style="display: inline; border-radius:4px; padding:4px 8px; color : #fff;  text-align:center; background:#FFA400; font:bold 20px Arial; margin-right:2px"></div>
                    </div>
                     <div id="lablecounterprepay">
            	<span class="Days">Ngày</span>
            	<span class="Hours">Giờ</span>
            	<span class="Minutes">Phút</span>
            	<span class="Seconds">Giây</span>
            </div>
                </div>
                {if $productDetail->prepaidrand <= 0 || $numberreorder < $productDetail->prepaidrand}
                <div class="btn-pre"><a href="{$registry->conf.rooturl}cart/dattruoc?id={$productDetail->id}{if !empty($parentpromotionprices.promoid)}&prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}" title=""><i class="iconcartpre"></i>Đặt Mua Ngay</a></div>
                {else}
                <div class="btn-pre"><a style="background: #cacaca;font-size: 13px;" href="javascript:void()" title="">Đã đủ số lượng đặt trước</a></div>
                {/if}
            </div>
            {else}
             <div class="btn-pre"><a style="background: #cacaca;font-size: 13px;" href="javascript:void()" title="">Hết thời gian đặt trước</a></div>
            {/if}
        </div>  
            <div class="bar_pre_center">
            	<div class="titinfo"><i class="icongiftpre"></i>Thông tin khuyến mãi</div>
            </div>
            <div class="giftpromo_pre">
            	<div id="loadpromotionlist" class="infogift_pre">
                	
                </div>

            </div>
            </div>
        </div>
             
     
                   <!-- End Dat truoc -->
              {elseif $productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller || $productDetail->onsitestatus == $OsCrazySale}
                  {if $productDetail->displaysellprice!=1 &&  $productDetail->sellprice > 0 &&  !empty($parentpromotionprices.price) && $parentpromotionprices.price<$productDetail->sellprice}
                  <!-- Co khuyen main -->
                    <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                      <div class="marketprice">
                        <span class="marketlabel">Giá thị trường:</span>
                          <span class="marketvalue"><span class="priceold">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if}đ</span></span>
                      </div>
                      <div class="dmprice">
                        <span class="dmpricelabel">Giá dienmay.com:</span>
                          <span class="dmpricevalue"><span class="pricenew">{if $parentpromotionprices.price > 1000}{$parentpromotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></span>
                      </div>
                      <div class="econo">
                        <span class="econolabel">Bạn tiết kiệm:</span>
                          <span class="econovalue"> 
                              {if !empty($listprices.online) && $listprices.online > 1000}
                              {assign var="finalprice" value=$listprices.online}
                            {elseif !empty($listprices.offline) && $listprices.offline > 1000}
                              {assign var="finalprice" value=$listprices.offline}
                            {elseif $productDetail->sellprice > 1000}
                              {assign var="finalprice" value=$productDetail->sellprice}
                            {else}{assign var="finalprice" value=1000}{/if}
                            <div class="priceecono"><span>{math|number_format equation="x - y" x=$finalprice y=$parentpromotionprices.price format="%.0f"}đ</span>
                          </span>
                      </div>
                    </div>
                    <!-- end co khuyen mai -->
                {elseif $productDetail->sellprice > 0}
                    <!-- Khong co khuyen mai -->
                 <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                      <div class="dmprice">
                          <div class="dmpricelabel">Giá dienmay.com:</div>
                          <div class="dmpricevalue"><span class="pricenew">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                      </div>
                    </div>
                    <!-- khong co khuyen mai -->
                {/if}
                {elseif $productDetail->onsitestatus == $OsCommingSoon}
                  <!-- hang sap ve -->
                  <div class="dmprice">
                    <div class="dmpricelabel">Giá dự kiến: </div>
                    <div class="dmpricevalue" style="width:100%;text-align: center;"><font size=5><strong>ĐANG CẬP NHẬT</strong></font></div>
                  </div>
                  <!-- End hang sap ve -->
                {elseif (!empty($listprices.online) && $listprices.online >0 ) || (!empty($listprices.offline) && $listprices.offline > 0)}
                  <!-- -->
                   <div class="areaprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}">
                    <div class="dmprice">
                      <div class="dmpricelabel">Giá dienmay.com:</div>
                      <div class="dmpricevalue"><span class="pricenew">{if !empty($listprices.online) && $listprices.online > 1000}{$listprices.online|number_format}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{$listprices.offline|number_format}{elseif  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                  </div>
                  </div>
                {/if}
            </div>
           
            <!-- Khuyến mãi -->
            <div class="area">

                <div class="areagift" style="display: none;" id="loadpromotionlist">  
                </div>
            </div>
            <!-- Mua ngay -->
            {if $productDetail->onsitestatus == $OsERPPrepaid}
               <!-- TH1 Dat truoc-->
               
             {elseif $productDetail->instock > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller || $productDetail->onsitestatus == $OsCrazySale) && $productDetail->sellprice > 0}
             <!--TH2 -->
                {if count($havestorestock)>0}
                <div class="supermark"><a href="{$registry->conf.rooturl}product/sieuthiconhang?code={$productDetail->barcode|trim}">Còn {count($havestorestock)} siêu thị sẵn hàng »</a></div>
                {/if}
                <div class="bh">{if !empty($productDetail->warranty)}Bảo hành chính hãng {$productDetail->warranty} tháng{/if}</div>
                 <div class="btnbuynow"><a onclick="eventclick('event', 'button_buynow_top','click','button_buynow_top','{if !empty($listprices.online) && $listprices.online > 1000}{(float)$listprices.online}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{(float)$listprices.offline}{elseif  $productDetail->sellprice > 1000}{(float)$productDetail->sellprice}{else}{$lang.default.promotionspecial}{/if}');" href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}{if !empty($parentpromotionprices.promoid) && $productDetail->slug != ""}&{else}?{/if}po=p{substr($productDetail->barcode|trim, -5, 5)}41" title="Mua ngay" id="buyonline"> Mua ngay &#187;</a></div>
            {elseif $productDetail->onsitestatus == $OsCommingSoon}
              <!-- TH3 -->
            {else}
                <div class="area">
                  <!-- 
                  <div class="promolabel">Gửi email cho tôi khi hàng trở lại</div>
                    <input class="theendinput" name="" type="text" placeholder="Email của bạn">
                    <button class="btntheend" type="submit">Gửi </button>
                  -->
                </div>
                <div class="btnbuynow" style="background:#ccc"><a href="#">Hết hàng</a></div>
              <!-- HET HANG -->
            {/if}
            <div class="callme">Hoặc gọi cho chúng tôi: <strong>1800 1061</strong></div>
        </div>
      </div>
       {/if}
        <div class="bardetail">
          <div class="articlesbar"><span>Đặc điểm sản phẩm</span></div>
            <ul>
                {if !empty($productDetail->fullboxshort)}<li id="fullshortboxedit">Bộ sản phẩm gồm có: <span>{$productDetail->fullboxshort|strip_tags}</span></li>{/if}
                {if !empty($productDetail->warranty)}<li>Bảo hành {$productDetail->warranty} tháng <!--<a class='iframe-2' href="diem-bao-hanh.html">(Xem điểm bảo hành)</a>--></li>{/if}
                {$productDetail->summary}
            </ul>
            <div class="viewallproducts"><a href="{$registry->conf.rooturl}product/loadfullgroupattributes?pcid={$smarty.get.pcid}&pid={$smarty.get.pid}" title="Xem chi tiết">Xem chi tiết »</a></div>
        </div>
        
        <article>
            {if $productDetail->good != "" || $productDetail->bad != "" || $productDetail->dienmayreview != ""}
            <div id="review">
                <div class="articlesbar"><span>Đánh giá sản phẩm</span></div>
                
                  <div class="reviewclum"> <span>Ưu điểm</span>
                     {$productDetail->good}
                  </div>
                  <div class="reviewclum"> <span>Nhược điểm</span>
                     {$productDetail->bad}
                  </div>
                  <div class="reviewclum"> <span>dienmay.com đánh giá</span>
                    <ul>
                       {$productDetail->dienmayreview}
                    </ul>
                  </div>
            </div>
             {/if}
                {if !empty($productDetail->content)}



            {* recommend  *}
            <div id="articles">
                  <div class="articlesbar"><span>Bài viết sản phẩm</span></div>
                  <div class="articles">
                      {$productDetail->content}
                  </div>
                </div>


                {/if}
              <!-- Nut mua ngay dua bai viet -->
              <!-- Mua ngay -->
                {if $productDetail->onsitestatus == $OsERPPrepaid && $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
                   <!-- TH1 Dat truoc-->
                    <div class="btnbuynow">
                      <a href="{$registry->conf.rooturl}cart/dattruoc?id={$productDetail->id}{if !empty($parentpromotionprices.promoid)}&prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}" class="buyprepaid" rel="{$productDetail->id}"{if !empty($parentpromotionprices) && $parentpromotionprices.promoid >0} id="{$productDetail->barcode}_{$parentpromotionprices.promoid}"{/if} title="Đặt hàng trước">Đặt trước &#187;</a>
                    </div>
                     {elseif $productDetail->instock > 0 && ($productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller || $productDetail->onsitestatus == $OsCrazySale) && $productDetail->sellprice > 0}
                 <!--TH2 -->
                     <div class="btnbuynow"><a onclick="eventclick('event', 'button_buynow_bottom','click','button_buynow_bottom','{if !empty($listprices.online) && $listprices.online > 1000}{(float)$listprices.online}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{(float)$listprices.offline}{elseif  $productDetail->sellprice > 1000}{(float)$productDetail->sellprice}{else}{$lang.default.promotionspecial}{/if}');" href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}{if !empty($parentpromotionprices.promoid) && $productDetail->slug != ""}&{else}?{/if}po=p{substr($productDetail->barcode|trim, -5, 5)}41" title="Mua ngay" id="buyonline"> Mua ngay &#187;</a></div>
                {elseif $productDetail->onsitestatus == $OsCommingSoon}
                  <!-- TH3 -->
                {else}
                    <div class="area">
                      <!-- 
                      <div class="promolabel">Gửi email cho tôi khi hàng trở lại</div>
                        <input class="theendinput" name="" type="text" placeholder="Email của bạn">
                        <button class="btntheend" type="submit">Gửi </button>
                      -->
                    </div>
                    <div class="btnbuynow" style="background:#ccc"><a href="#">Hết hàng</a></div>
                  <!-- HET HANG -->
                {/if}
              <!-- End nut mua ngay duoi bai viet -->
        </article>
        <article>
            <div class="comments" id="comment">
                <!-- Comment Load ajax -->
                <!-- End comment Load ajax -->

            </div>

        </article>
      {* recommend  *}
      {if $relProductProduct|count >0}
      <div class="catelist">
          <div class="articlesbar"><span>Sản phẩm liên quan ({assign var="countstore" value=1}{foreach from=$relProductProduct item=str2 key=key name=productproduct}  {if $smarty.foreach.productproduct.iteration == 4}{break}{/if}{assign var="countstores" value=$countstore++}{/foreach}{$countstores} )</span></div>
          <ul>
               {foreach from=$relProductProduct item=relpp name=relpp}
              {if $smarty.foreach.relpp.iteration == 4}{break}{/if}
              {assign var="promotionprices" value=$relpp->promotionPrice()}
              <li>
                  <a href="{$relpp->getProductPath()}?ref=recommendtion-{$relpp->id}-{$relpp->name}" title="{$relpp->name}">  
                          {if $relpp->onsitestatus == $OsERPPrepaid}<span class="tagpreorder">Đặt trước</span>
                          {elseif $relpp->onsitestatus == $OsCommingSoon} <span class="tagsapve">Sắp về</span>              
                          {elseif $relpp->onsitestatus == $OsHot} <span class="taghot">HOT</span>
                          {elseif $relpp->onsitestatus == $OsNew} <span class="tagnew">Mới</span>
                          {elseif $relpp->onsitestatus == $OsBestSeller}<!-- <i class="icon-status4"></i> Neu la gift-->
                          {elseif $relpp->onsitestatus == $OsCrazySale}
                          {elseif $relpp->onsitestatus == $OsNoSell || $relpp->instock == 0}<span class="tagtheend">Hết hàng</span>
                          {/if}   
                        <img src="{$relpp->getSmallImage()}" alt="{$relpp->name}"title="{$relpp->name}" />
                          <h3> {$relpp->name}</h3>
                          <div class="loadprice lp{$relpp->id}{$relpp->barcode|trim|substr:-5}" rel="{$relpp->id}{$relpp->barcode|trim|substr:-5}">
                               {if $relpp->displaysellprice!=1 && $relpp->sellprice>0 && $relpp->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$relpp->sellprice}
                                  <div class="priceold price1">{if $relpp->sellprice > 1000}{$relpp->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                  <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                   <span class="persale"> -{(($relpp->sellprice - $promotionprices.price)/$relpp->sellprice * 100)|floor}%</span>
                              {elseif $relpp->onsitestatus == $OsERPPrepaid && $relpp->prepaidstartdate <= $currentTime && $relpp->prepaidenddate >= $currentTime}
                                  <div class="pricenew price2">{if $relpp->prepaidprice > 1000}{$relpp->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                              {elseif $relpp->sellprice >0}
                                  <div class="pricenew price2">{if $relpp->sellprice > 1000}{$relpp->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                              {/if}                 
                          </div>
                      </a>
              </li>
             {/foreach}
          </ul>
      </div>
      {/if}

      {*end recommend*}
    </section>
<!-- End content -->
<!-- Footer -->
  <div class="clearfix"></div>
  <div class="productpath" style="display:none">{$productDetail->getProductPath()}</div>
{literal}
<script type="text/javascript">
var doangia = "{/literal}{if $productDetail->onsitestatus == $OsDoanGia}1{else}0{/if}{literal}";
var dattruoc = "{/literal}{if $productDetail->onsitestatus == $OsERPPrepaid}1{else}0{/if}{literal}";
var prepaidenddate = "{/literal}{date('Y-m-d 00:00:00', $productDetail->prepaidenddate)}{literal}";
var fpcid = "{/literal}{$productDetail->pcid}{literal}";
var pid = "{/literal}{$productDetail->id}{literal}";
var fgpa = "{/literal}{$gpa}{literal}"
var fpa = "{/literal}{$pa}{literal}"
var prel = "{/literal}{$prel}{literal}"
$(document).ready(function(){
	$('.likepage span').html('<iframe src="https://www.facebook.com/plugins/like.php?href='+$('.productpath').html()+'&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>');
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
    $('#moreview').click(function(){
        var htmlcontent = $('#attrfull').html();
    htmlcontent = '<div class="conttable">' + htmlcontent + '</div>';
        Shadowbox.open({
                    content :   htmlcontent,
                    player:     "html",
                    height:     800,
                    width:      820
                });
    });
    //campaign trung thu
    //getlantern();

//  //Doan gia 
    if(doangia == "1"){
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

    //Đặt trươc
    if(dattruoc == 1){
    	var tmpdatetime = prepaidenddate.split(' ');
        var date = tmpdatetime[0].split('-');
        var time = tmpdatetime[1].split(':');
        dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]); 
		if(dateguessprice > 0){
			dateNow = new Date(); 
			amount = dateguessprice.getTime() - dateNow.getTime();
			
			 var timedown = new CountDown({
     	        daysNode: $('.J_days'),
     	        hoursNode: $('.J_hours'),
     	        minutesNode: $('.J_minutes'),
     	        secondsNode: $('.J_seconds'),
     	        timeLeft: Math.floor(amount/1000)
     	    });

     	    timedown.start();
     	    this.timedown = timedown;
		}
    }
   
});

function countdowntimestart(timestart,timeend){
    var tmpdatetime = timestart.split(' ');
    var date = tmpdatetime[0].split('-');
    var time = tmpdatetime[1].split(':');
    dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]); 
    dateNow = new Date(); 
    amount = dateguessprice.getTime() - dateNow.getTime();
    if(amount > 0 ){
   
    	if( $('#counter .J_days').is(':empty') || $('#counter .J_hours').is(':empty') || $('#counter .J_minutes').is(':empty') || $('#counter .J_seconds').is(':empty')  ) {
//        	$('#counter').countdown({
//    			timestamp : (new Date()).getTime() + amount
//	  		});

        	 var timedown = new CountDown({
        	        daysNode: $('.J_days'),
        	        hoursNode: $('.J_hours'),
        	        minutesNode: $('.J_minutes'),
        	        secondsNode: $('.J_seconds'),
        	        timeLeft: Math.floor(amount/1000)
        	    });

        	    timedown.start();
        	    this.timedown = timedown;
    	 }
	}else{
		
		var tmpdatetime = timeend.split(' ');
        var date = tmpdatetime[0].split('-');
        var time = tmpdatetime[1].split(':');
        dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]); 
        amount = dateguessprice.getTime() - dateNow.getTime();
        if(amount <= 0){
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
                     	$('.pricesale').html(data);
                    }
                 });   
	        }
        	if( $('#counter .J_days').is(':empty') || $('#counter .J_hours').is(':empty') || $('#counter .J_minutes').is(':empty') || $('#counter .J_seconds').is(':empty')  ) {
        		var timedown = new CountDown({
        	        daysNode: $('.J_days'),
        	        hoursNode: $('.J_hours'),
        	        minutesNode: $('.J_minutes'),
        	        secondsNode: $('.J_seconds'),
        	        timeLeft: Math.floor(amount/1000)
        	    });

        	    timedown.start();
        	    this.timedown = timedown;
        	 }
	        }


	}

    setTimeout(function(){countdowntimestart(timestart,timeend)}, 1000);
    
}

$('.clicktrakingGA').click(function(event) {
  /* Act on the event */
    var pricevalue = $('.dmprice .dmpricevalue .pricenew').html().replace(new RegExp( ",", "g" ), "")
    pricevalue = pricevalue.split(' ');
    var opt_value = parseInt(pricevalue[0]);
    _gaq.push(['_trackEvent', 'Buynow-Productdetail', 'Click', 'Mobile', opt_value, true]);
});

</script>
{/literal}