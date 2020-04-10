<link href="{$currentTemplate}css/site/auction.css" rel="stylesheet" type="text/css" media="screen" />
<div id="container">
    <div class="bn_auction">
        <img src="{$currentTemplate}images/auctions/banner-dau-gia-nguoc.png" alt="" />
        <div class="row_bot_auc">
            <div class="view_auc-rules"><a href="javascript:void(0)" onclick="showpopupthele()" title="Xem thể lệ chương trình"></a></div>
            <div class="wrap_auc_like_social">
                <div class="auc_like_social">
                <div class="auc_float">
                    <div class="likepage">
                        <span></span>
                    </div>
                </div>
                <div class="auc_float"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://dienmay.com/dau-gia-nguoc"><i class="icon-face"></i></a>
                </div>
                <div class="auc_float"><a target="_blank" href="https://plus.google.com/share?url=http://dienmay.com/dau-gia-nguoc"><i class="icon-goog"></i></a>
                </div>
                <div class="auc_float"><a target="_blank" href="http://twitthis.com/twit?url=http://dienmay.com/dau-gia-nguoc"><i class="icon-twitter"></i></a>
                </div>
            </div>
            </div>
        </div>
    </div>
    {if !empty($runningproduct)}
    <div class="row_auction">
        <div class="col_auc_1">
            <div class="row_auc_top">
                <div class="title_auc"><strong>Sản phẩm</strong> đang được đấu giá</div>
          
                {if $runningproduct['status'] == 3 &&  $runningtime >2}
                    <div class="time_auc">
                        <strong>Thời gian còn lại:</strong>
                        <div class="realtime">
                            <div class="rowtime"  id="countbox1">
                                
                            </div>
                        </div>
                    </div>
                 {/if}
                <div class="clear"></div>
           
            </div>
            
            <div class="head-left">
                
                <div class="head-left">
          <!-- 360 small -->
            <!--<div id="360sprite" class="image360"></div>-->
            <!-- end 360 small -->
            <!-- Video -->
            <!--<div><iframe width="400" height="390" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/5nRj9pv0y9M"></iframe></div>-->
            <!-- end video -->
            <input type="hidden" value="{$registry->conf.rooturl}reverseauctions" class="productpath"/>
            <div id="zoomslide">
                  {if !empty($runningproduct['image'])}
                  <div class="fixzoom">
                    <img data-zoom-image="{$runningproduct['image'][0]}" src="{$runningproduct['image'][0]}" alt="{$runningproduct['productname']}" id="zoom">
                  </div>
                    <div id="zoomslides">
                    {foreach from=$runningproduct['image'] item=gal key=key name=listgallery}
                      <a data-zoom-image="{$gal}" data-image="{$gal}" data-update="" class="elevatezoom-gallery  {if $smarty.foreach.listgallery.iteration==1}active{/if} withumb_{$key}" >
                        <img class="withumb" src="{$gal}" onclick="clickimage(this)" alt="{$runningproduct['productname']}">
                      </a>
                    {/foreach}
                    </div>
                    {/if}
                </div>
                 <!-- load video -->
                {if $runningproduct['video'] != ''}
                    <div id="videothumb"><a style="cursor:pointer">
                        {assign var=idyoutube value=explode('/',$runningproduct['video'])}
                      <span class="iconvideoyoutube"></span>
                      <img src="http://img.youtube.com/vi/{$idyoutube[$idyoutube|count-1]}/default.jpg" alt="{$runningproduct['productname']}"/></a>
                    <input type="hidden" class="contentvideo" value="{$runningproduct['video']}"/>
                    </div>
                 {/if}
                <!-- load hình xoay 360 -->
                {if $runningproduct['image360'] != ''}
                    <div id="360thumb" class="i360thumb"><a style="cursor:pointer"><i class="icon-img360"></i></a></div>
                {/if}
               
              <div class="clear"></div>
            </div>

            </div>
            <div class="col_auc_desc">
                <h1>{$runningproduct['productname']} </h1>
                <div class="area_price_auc">
                {$runningproduct->technical}
                    {if !empty($runningproduct['technical'])}

                         <div class="priceset" style="text-align:left;font:13px/18px arial">
                            {$runningproduct['technical']}    
                        </div>
                    {/if}
                    <div class="priceset">
                        <span>Giá khởi điểm:</span>
                        <strong>{if $runningproduct > 0}{$runningproduct['price']|number_format}{/if} <sub>đ</sub></strong>
                    </div>
                    {if !empty($userwinnercurrent[$runningproduct['id']])}
                    <div class="price_auc">
                        <span>Giá duy nhất và thấp nhất hiện tại:</span>
                        <div class="wrap_price_auc"><strong>{$userwinnercurrent[$runningproduct['id']].price|number_format} <sub>đ</sub></strong></div>
                        <b>{$userwinnercurrent[$runningproduct['id']].username}</b>
                    </div>
                    {/if}
                </div>
                
                    {if $runningproduct['status'] == 3 && $runningtime >2}
                      <div class="area_auction">
                          <span>Không còn nhiều thời gian. Tham gia đấu giá ngay</span>
                          <div class="btn-auction"><a href="javascript:void()" onclick="showpopupreverseautions({$runningproduct['id']})"> <i class="icon_auc"></i> Đấu giá</a></div>
                      </div>
                      {else}
                      <div class="area_auction">
                          <span>Thời gian đấu giá cho sản phẩm này đã kết thúc</span>
                          <div class="btn-auction" ><a href="javascript:void()" style="background:#cacaca"> <i class="icon_auc"></i> Đấu giá</a></div>
                      </div>
                    {/if}
              
            </div>
        </div>
        <div class="col_auc_2">
            <div class="bar_auc"><strong>{if $listUser|count > 0}{count($listUser)}{/if}</strong> Người đã tham gia đấu giá</div>
            <div class="listplayer_auc">
                <ul>
                  {if $listUserLimit|count > 0}
                    {foreach from=$listUserLimit item=user name=list}
                    {if $user['price'] > 0}
                    <li>
                        <strong>{$user['fullname']}</strong>
                        <span>{$user['price']|number_format} đ</span>
                    </li>
                    {/if}
                    {/foreach}
                  {/if}
                </ul>
                <div class="viewall_auc"><a href="javascript:void(0)" onclick="showpopuplistuser({$runningproduct['id']})" title="Xem tất cả">Xem tất cả ››</a></div>
            </div>
        </div>
    </div>
    {else}
          <div class="row_auction" style=" font-size: 36px; margin-top: 38px; text-align: center; ">
                Chưa có sản phẩm đấu giá
          </div>
    {/if}
    {if $runningproduct['isshowblock'] == 1}
    <div class="row_auction">
        <div class="col_auc_1">
            <div class="row_auc_top">
                <div class="title_auc_2"><strong>Sản phẩm</strong> đấu giá</div>
            </div>
             <div class="list_auc_prod">
                <ul>
                {if $listProduct|count > 0}
                    {foreach from=$listProduct item=product}
                    {if $product['id'] != $runningproduct['id']}
                    <li><div class="layer_auc">{if $product['status'] == 1}<i class="icon_auc_saled">{/if}</i></div>
                        <a href="Javascript:void(0)" title=""><img src="{$product['image'][0]}" alt="{$product['productname']}" /></a>
                        <a title="{$product['productname']}" href="javascript:void()" class="position-a"><h4>{$product['productname']}</h4></a>
                        <div class=" {if $product['status'] == 1}auc_block_1{else}auc_block_2{/if}">
                            <div class="row_block">
                                <span>Ngày bán:</span><strong> {$product['startdate']|date_format:"%d/%m/%Y"}</strong>
                            </div>
                            
                            <div class="row_block">
                                <span>
                                    {if $product['id'] == 4}
                                        21218 Người đã tham gia<br>
                                    {elseif $product['id'] == 5}
                                        19393 Người đã tham gia<br>
                                    {elseif $product['id'] == 6} 
                                        44789 Người đã tham gia<br>
                                    {/if}     
                                   
                                </span>
                            </div>
                            
                            <div class="row_block">
                                <span>Người chiến thắng:</span>
                                <div class="clear"></div>
                                {if $product['status'] == 1}
                                    {if !empty($userwinnercurrent[$product['id']])}
                                    <strong>{$userwinnercurrent[$product['id']].username}  ({$userwinnercurrent[$product['id']].price|number_format})</strong>
                                    {else}
                                        {if $product['id'] == 4}
                                             <strong>Trần An Hùng (445,000)</strong>
                                         {elseif $product['id'] == 6}    
                                            <strong>Nguyen Chi Cong (2,223,000)</strong>
                                         {else}                                    
                                            chưa tìm được người chiến thắng
                                        {/if}
                                    {/if}
                                 {/if}
                            </div>     
                        </div>
                    </li>
                    {/if}
                    {/foreach}
                    {/if}
                </ul>
            </div>
        </div>
        {if !empty($runningproduct['journalistically'])}
        <div class="col_auc_2">
            <div class="listpress_auc">
               {$runningproduct['journalistically']}
            </div>
        </div>
        {/if}
    </div>
    {/if}
    {$runningproduct['content']}
       <!-- comment -->
  <div id="comments" class="wrap-one">
            
  </div>
</div>


{literal}
<script type="text/javascript">
  var pid = "{/literal}{$runningproduct['id']}{literal}";
  //console.log(pid);
  var image360path = "{/literal}{$runningproduct['image360']}{literal}";
  $(document).ready(function(){
    loadpageReview(85 , '');            
 });
</script>
{/literal}
<script type="text/javascript" src="{$currentTemplate}js/site/reverseautions.js"></script>