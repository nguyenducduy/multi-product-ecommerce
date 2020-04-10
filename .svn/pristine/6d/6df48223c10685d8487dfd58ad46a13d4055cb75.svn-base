<!-- Content -->
    <section>
    	<div class="navibarlist">
        	<ul>
            	 <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a> </li>
                <li><a href="{$currentCategory->getProductcateoryPath()}" title="{$currentCategory->name}">{$currentCategory->name} ››</a> </li>
                <li><a><span>Gallery</span></a></li>
            </ul>
        </div>
    	<h1 class="nameproduct">{$productDetail->name}</h1>
        <!-- Thông số kỹ thuật -->  
        <div class="conttable">
		<div class="conttitle"><div class="back"><a href="{$registry->conf.rooturl}{$currentCategory->slug}/{$productDetail->slug}">&#171;Trở về</a></div>Hình ảnh - Video</div>
            {if !empty($galleries)}
            	<!-- gallery -->
                <div id="m-carousel-example-4" class="m-carousel m-fluid m-carousel-photos wrapgallery">
                    <div class="m-carousel-inner" style="transform: translate(-2309px, 0px);">
                     {foreach from=$galleries item=gal name=listgallery}
                      <div class="m-item {if $smarty.foreach.listgallery.iteration == 1}m-active{/if}">
                          <div class="gallery"><img src="{$gal->getImage()}" alt="{if !empty($gal->alt)}{$gal->alt}{else}{$gal->alt}{/if}" title="{if !empty($gal->caption)}{$gal->caption}{else}{$gal->titleseo}{/if}"></div>
                      </div>
                    {/foreach}
                        
                    </div>
                    <!-- bullet -->
                    <div class="m-carousel-controls m-carousel-bulleted">
                        {foreach from=$galleries item=gal2 name=listgallery2}
                        <a data-slide="{$smarty.foreach.listgallery2.iteration}" href="#" {if $smarty.foreach.listgallery2.iteration == 1}class="m-active"{/if}>{$smarty.foreach.listgallery2.iteration}</a>
                      {/foreach}
                    </div>
                </div>
            {else}
            {/if}
            <!-- -->
             {if !empty($productDetail->fullbox) && !empty($specialimage)}
            <div class="descimg">
            	 <img src="{$specialimage}" alt="{$productDetail->name}" />
            </div>
            {/if}
            <!-- Video -->
            <div class="clearfix"></div>
             {if !empty($videos)}
                <div>
                {foreach from=$videos item=video name=videonamesmart}
                    {if !empty($video->moreurl)}
                        <div class="video">
                        	  <iframe width="100%" height="315" src="{$video->moreurl}" frameborder="0" allowfullscreen></iframe>            </div>
                    {/if}
                {/foreach}
                <div class="clearfix"></div>
                </div>
            {/if}
        <!-- -->
    	{if $productDetail->onsitestatus != $OsDoanGia}   
       <div style="display:none">
            <div class="areagift" style="display: none;" id="loadpromotionlist">  
            </div>
        </div>
        {if $productDetail->onsitestatus == $OsERPPrepaid && $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
                  <div class="btnbuynow">
                  <a href="{$registry->conf.rooturl}cart/dattruoc?id={$productDetail->id}{if !empty($parentpromotionprices.promoid)}&prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}" class="buyprepaid" rel="{$productDetail->id}"{if !empty($parentpromotionprices) && $parentpromotionprices.promoid >0} id="{$productDetail->barcode}_{$parentpromotionprices.promoid}"{/if} title="Đặt hàng trước">Đặt trước &#187;</a>
                </div>
        {elseif $productDetail->instock > 0 && $productDetail->onsitestatus > 0 && $productDetail->sellprice > 0}
               <div class="btnbuynow"><a onclick="eventclick('event', 'button_buynow_gallery','click', 'button_buynow_gallery', '{if !empty($listprices.online) && $listprices.online > 1000}{(float)$listprices.online}{elseif !empty($listprices.offline) && $listprices.offline > 1000}{(float)$listprices.offline}{elseif  $productDetail->sellprice > 1000}{(float)$productDetail->sellprice}{else}{$lang.default.promotionspecial}{/if}');" href="{$conf.rooturl}cart/{if $productDetail->slug != ""}mua-{$productDetail->slug}{else}checkout?id={$productDetail->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $productDetail->slug != ""}?{else}&{/if}prid={$productDetail->barcode|trim}_{$parentpromotionprices.promoid}{/if}{if !empty($parentpromotionprices.promoid) && $productDetail->slug != ""}&{else}?{/if}po=p{substr($productDetail->barcode|trim, -5, 5)}41" title="Mua ngay" id="buyonline"> Mua ngay &#187;</a></div>
        {elseif $productDetail->onsitestatus == $OsCommingSoon}
              <!-- COMMING SOON -->
              <div class="btnbuynow"><a href="#">Comming Soon</a></div>
        {else}
            <div class="btnbuynow"><a href="#">Hết hàng</a></div>
            <!-- HET HANG -->

        {/if}
        <div class="callme">Hoặc gọi cho chúng tôi: <a href="tel:+19001883" style="text-decoration: none"><strong>1900 1883</strong></a></div>
                <div class="back-bottom" style=" margin-bottom: 10px; margin-left: 20px;"><a href="{$registry->conf.rooturl}{$currentCategory->slug}/{$productDetail->slug}" style="text-decoration: none;
color: #fff;
background: #00a1e6;
padding: 10px 20px;
border-radius: 5px;">&#171;Trở về</a>
    </div>   
	{/if}
    </div>       
        
    </section>
<!-- End content -->
{literal}
    <script type="text/javascript">
    var fpcid = "{/literal}{$productDetail->pcid}{literal}";
    var pid = "{/literal}{$productDetail->id}{literal}";
    var fgpa = "{/literal}{$gpa}{literal}";
    var fpa = "{/literal}{$pa}{literal}";
    var prel = "{/literal}{$prel}{literal}";
    </script>
{/literal}