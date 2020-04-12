<script  type="text/javascript" src="{$currentTemplate}js/site/event-hours-sn.js"></script>
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/css-33k.css" media="screen" />
<script src="{$currentTemplate}js/countdown/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>

{literal}
    <script type="text/javascript">
      $(document).ready(function(){
            $('.likefb').html('<iframe src="http://www.facebook.com/plugins/like.php?href=https://ecommerce.kubil.app/dong-gia-33-ngan&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>');
            $.ajax({
                url: rooturl+'eventproducthours/countdownajax',
                dataType: 'html',
                data: '',
                success:function(data)
                {
                    if(data != '')
                    {
                        proccess();
                        $('#promo29main').css('display','block');
                        $('#promo29counter').countdown({
                          image: imageDir + '../js/countdown/digits.png',
                          timerEnd: function(){ $('#promo29main').remove() },
                          startTime: data
                        });
                    }
                }
            });
            $('#promo29headerdetailbutton').click(function(){
                $('#promo29guideline').css('display', 'block');
                $.scrollTo($('#promo29guideline').position().top, $('#promo29guideline').position().left);
            });
      })
    </script>
{/literal}


<div id="wrap-33k">
    <div class="banner33k">
        <img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/banner-33k.jpg?v=1">
        <div class="block-ico">
            <div class="likefb">
            </div>
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://ecommerce.kubil.app/dong-gia-33-ngan" target="_blank"><i class="ico-face"></i></a>
            <a href="https://plus.google.com/share?url=https://ecommerce.kubil.app/dong-gia-33-ngan" target="_blank"><i class="ico-ggplus"></i></a>
            <a href="http://twitthis.com/twit?url=https://ecommerce.kubil.app/dong-gia-33-ngan" target="_blank"><i class="ico-tw"></i></a>
            
        </div>
        <div class="bt_view"> <a class='view-inline userpromo0209' rel="{$registry->conf.rooturl}eventproducthours/thele" href="javascript:void()">Xem Thể lệ »</a></div>
            <!-- <div style="display:none">
                <div id='inline_thele'>
                    <div class="popup-2010">
                        <div class="tt-popup33" style="position:relative">Chi tiết thể lệ </div>
                        <div class="ct-popup33">
                             <span class="bl-33">NỘI DUNG</span>
                            <ul>
                                <li>Tên chương trình: <strong> Mua hàng đồng giá 33.000 vnđ</strong></li>
                                <li>Thời gian:  <strong>từ 08h – 20h ngày 02/09/2013</strong></li>
                                <li>Nội dung: Mừng ngày lễ Quốc Khánh 02/09, dienmay.com tổ chức chương trình “Mỗi giờ một bất ngờ” cho tất cả khách hàng thành viên dienmay.com. Khi đặt mua online, 
                                khách hàng có số thứ tự mua hàng thứ 29 sẽ được mua với giá ưu đãi chỉ với 29,000đ cho các mặt hàng tivi, tủ lạnh, máy giặt, gia dụng.</li>
                            </ul>
                            <span class="bl-33">Cách thức tham gia</span>
                            <li>Từ 9h sáng đến 21h ngày 02/09, dienmay.com sẽ bán 12 sản phẩm bao gồm các mặt hàng gia dụng, điện tử, điện lạnh, 
                            điện thoại với giá 29,000đ tại website dienmay.com/moi-gio-mot-bat-ngo. 
                            Tất cả 12 sản phẩm này trong ngày 02/09 sẽ được chuyển sang trạng thái “ĐANG BÁN” ngẫu nhiên trong thời gian bất kỳ.
                            </li>
                            <li>Khi sản phẩm được chuyển trạng thái sang “ĐANG BÁN”, khách hàng có thể đặt mua sản phẩm này bằng cách nhập đầy đủ thông tin: Họ tên, SĐT, email và gửi về cho dienmay.com
01 sản phẩm chỉ có 01 thành viên được mua với giá 29,000đ, và thành viên đó phải có số thứ tự mua hàng thứ 29 (Tính từ 0 đến 29). Các thành viên không mua được với giá 29,000đ thì không phải chi trả thêm bất kỳ khoản tiền nào.
                            </li>
                          </div>
                    </div>
                </div>
            </div> -->
    </div>
    <div class="brand33">
        <p>Chương trình được tài trợ bởi:</p>
        <div class="logo-list33">
            <ul>
                <li><a href="{$registry->conf.rooturl}panasonic?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/l-pana.png"></a></li>
                <li><a href="{$registry->conf.rooturl}philips?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/l-philip.png"></a></li>
                <li><a href="{$registry->conf.rooturl}sharp?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/l-sharp.png"></a></li>
                <li><a href="{$registry->conf.rooturl}midea?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/l-media.png"></a></li>
                <li><a href="{$registry->conf.rooturl}acer?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/acer.png"></a></li>
                <li><a href="{$registry->conf.rooturl}hitachi?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/l-hitachi.png"></a></li>
                <li><a href="{$registry->conf.rooturl}gunners?ref=dong-gia-33-ngan" target="_blank"><img src="https://ecommerce.kubil.app/templates/default/images/site/sndienmay/l-gunner.png"></a></li>
            </ul>
            
        </div>
    </div>
    <div style="text-align: center;font-size: 19px;font-weight: bold;line-height: 25px;display:none" class="sloganfinal"> CHƯƠNG TRÌNH HÔM NAY ĐÃ KẾT THÚC <br> BẠN VUI LÒNG TRỞ LẠI VÀO LÚC 9H NGÀY MAI (08/11/2013) ĐỂ TIẾP TỤC THAM GIA</div>
    <div class="product33k">
        <div id="promo29main" style="display:none">
            <h1>Chương trình sẽ bắt đầu sau:</h1>
            <div id="promo29countdownbox">
                <div id="promo29counter">
                                
                </div>
                <div class="promo29desc">
                    <div>Ngày</div>
                    <div>Giờ</div>
                    <div>Phút</div>
                    <div>Giây</div>
                  </div>
            </div>
        </div>
        <div class="header-33"><span class="tt-33">DANH SÁCH SẢN PHẨM ĐỒNG GIÁ 33.000Đ</span></div>
        <ul>
        {foreach from=$listproduct name=listproductevent item=productevent}
            <!-- Đang bán -->
            {if $productevent->status == 3}
                 <li class="trt1 listproductevent act33" id="{$productevent->randid}">
                    <div class="sold33"><i class="ico-sell selling29"></i></div>
                     <div class="buy29 buy33"><a class="inline291 buypromo0209" href="javascript:void(0)" rel="{$registry->conf.rooturl}site/eventproducthours/addeventuser?pid={$productevent->id}">Mua ngay</a></div>
                    <a href="#"><img src="{$productevent->images}" title="{$productevent->name}" alt="{$productevent->name}" /></a>
                    <div class="title-pr"><a href="#" title="{$productevent->name}">{$productevent->name}</a></div>
                    <div class="bottom-pr">
                        <div class="price"><span>Giá sinh nhật dienmay.com (dành cho người thứ 33)</span><br> {$productevent->discountprice|number_format} VNĐ</div>
                        <div class="price-throught">Giá thị trường<br> <span>{$productevent->currentprice|number_format} VNĐ</span></div>
                    </div>
                </li>
             {elseif ($productevent->status == 1)}
                <li class="pro-end trt2 listproductevent" id="{$productevent->randid}">
                    <div class="sold33"><i class="ico-sold"></i></div>
                    <div class="infocustom33">
                          <a class="inline292 userpromo0209" href="javascript:void(0)"  rel="{$registry->conf.rooturl}site/eventproducthours/listuser/pid/{$productevent->id}">Danh sách khách hàng tham gia mua sản phẩm</a>
                    </div>
                    <a href="#"><img src="{$productevent->images}" title="{$productevent->name}" alt="{$productevent->name}" /></a>
                    <div class="title-pr"><a href="#">{$productevent->name}</a></div>
                    <div class="bottom-pr">
                        <div class="price"><span>Giá sinh nhật dienmay.com (dành cho người thứ 33)</span><br> {$productevent->discountprice|number_format} VNĐ</div>
                        <div class="price-throught">Giá thị trường<br> <span>{$productevent->currentprice|number_format} VNĐ</span></div>
                    </div>
                </li>
            {else}
            <li class="chuaban listproductevent act33" id="{$productevent->randid}">
               <div class="selling_{$productevent->randid}"></div>
                <div class="buy_{$productevent->randid}"><a class="inline291" href=""></a></div>
                <a href="#"><img src="{$productevent->images}" title="{$productevent->name}" alt="{$productevent->name}" /></a>
                <div class="title-pr"><a href="#">{$productevent->name}</a></div>
                <div class="bottom-pr">
                    <div class="price"><span>Giá sinh nhật dienmay.com (dành cho người thứ 33)</span><br> {$productevent->discountprice|number_format} VNĐ</div>
                    <div class="price-throught">Giá thị trường<br> <span>{$productevent->currentprice|number_format} VNĐ</span></div>
                </div>
            </li>
            {/if}
        {/foreach}
        </ul>
    </div>
    
    <div class="other-pro">
        <div class="header-33"><span class="tt-33">Những sản phẩm hot khác tại dienmay.com</span></div>
        <ul>
            {if !empty($listProduct2)}
                {foreach from=$listProduct2 item=listp}
                      {assign var="promotionprices" value=$listp->promotionPrice()}
                        <li> 
                            <div class="areaprice loadprice lp{$listp->id}{$listp->barcode|trim|substr:-5}" rel="{$listp->id}{$listp->barcode|trim|substr:-5}">
                            <a href="{$listp->getProductPath()}"> <img src="{$listp->getImage()}"></a>
                            <div class="name-other"><a href="{$listp->getProductPath()}">{$listp->name}</a></div>
                            <div class="bot-other">
                                  {if $listp->displaysellprice!=1 && $listp->sellprice>0 && $listp->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$listp->sellprice}
                                   <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                   <div class="priceold price1">{if $listp->sellprice > 1000}{$listp->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                   <span class="salepercent">-{(($listp->sellprice - $promotionprices.price)/$listp->sellprice * 100)|floor}%</span>
                                   {elseif $listp->onsitestatus == $OsERPPrepaid && $listp->prepaidstartdate <= $currentTime && $listp->prepaidenddate >= $currentTime}
                                    <div class="pricenew price2">{if $listp->prepaidprice > 1000}{$listp->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                   {elseif $listp->sellprice >0}
                                   <div class="pricenew price2">{if $listp->sellprice > 1000}{$listp->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                               {/if} 
                            </div>
                            </div>
                        </li>
                {/foreach}
            {/if}
        </ul>
    </div>
</div>
