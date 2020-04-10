

<div class="navbarprod">
    {if $formData.myuser==1}
	<li><a href="{$conf.rooturl}">Trang chủ</a> ››</li>
	<li>Thông tin tài khoản</li>
    {/if}
</div>

<!-- Profiles -->
<div class="wr-profile">

    <div class="profiles_left">
        {if $formData.myuser==1}
            <ul>
                <li class="bar-l">Tài khoản của tôi</li>
                <li><a href="{$conf.rooturl}account/detail"><e class="ic-pr-user"></e>Thông tin cá nhân</a></li>
                <li><a href="{$conf.rooturl}account/accountsaleorder"><e class="ic-pr-bill"></e>Đơn hàng của tôi</a></li>
                <li><a href="#" class="active"><e class="ic-pr-list"></e>Sản phẩm tôi yêu thích</a></li>
                <li><a href="{$conf.rooturl}account/checksaleorder"><e class="ic-pr-check"></e>Kiểm tra đơn hàng</a></li>
            </ul>
        {else}
            <ul>
                <li><a href="#"><i class="ic-pr-user active"></i>Sản phẩm yêu thích của {$formData.name}</a></li>
                <li><a href="{$conf.rooturl}"><i class="ic-pr-list"></i>Trang chủ dienmay.com</a></li>
                <li><a href="{$conf.rooturl}thanh-vien/dang-ky"><i class="ic-pr-user"></i>Đăng nhập vào tài khoản của bạn</a></li>
                <li><a href="{$conf.rooturl}thanh-vien/dang-ky"><i class="ic-pr-bill"></i>Đăng kí tài khỏan mới</a></li>
                <li><a href="{$conf.rooturl}account/checksaleorder"><i class="ic-pr-check"></i>Kiểm tra đơn hàng</a></li>
            </ul>
        {/if}
    </div>

    <div class="Pr-favorList">
        <h3>Sản phẩm yêu thích ({count($product)})</h3>

        {if count($product) > 0}
        <div class="tx-note">Sản phẩm yêu thích của <span class="user"><a href="#">{$formData.name}</a> </span>tại dienmay.com</div>
        <div class="table-list">
            {foreach $product as $key=>$value}
            <div class="tblist-tr" id="div_{$value->id}">
                <div class="tblist-td thum-td">
                    <a href="{$value->link}"><img class="image-sp" src="{$value->img}"></a>
                    <a href="{$value->link}"><span class="name-sp">{$value->name}</span></a>
                    {if $formData.myuser==1}
                    <input type="button" class="st-del" value="Xóa" onclick='deleteItem("{$value->id}")'>
                    {/if}
                </div>
                <div class="tblist-td">   {$value->date|date_format:"%d/%m/%Y"}     </div>
                <div class="tblist-td ">
                    <a class=" status{if $value->instock == 0}-out{/if}" <a href="{$value->link}">{if $value->instock == 0}Hết hàng{else}Còn hàng{/if} </a>
                </div>
                <div class="tblist-td">
                        <div class="loadprice lp{$value->id}{$value->barcode|trim|substr:-5}" rel="{$value->id}{$value->barcode|trim|substr:-5} pric-underline">
                            {assign var="promotionprices" value=$value->promotionPrice()}
                            {if $value->displaysellprice!=1 && $value->sellprice>0 && $value->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$value->sellprice}
                                <div class="priceold price1" style="position: inherit">{if $value->sellprice > 1000}{$value->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                <div class="pricenew price2" style="position: inherit">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                            {elseif $value->onsitestatus == $OsERPPrepaid && $value->prepaidstartdate <= $currentTime && $value->prepaidenddate >= $currentTime}
                                <div class="pricenew price2" style="position: inherit">{if $value->prepaidprice > 1000}{$value->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                            {elseif $value->sellprice >0}
                                <div class="pricenew price2" style="position: inherit">{if $value->sellprice > 1000}{$value->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                            {/if}
                        </div>
                </div>
                <div class="tblist-td">
                    <a class=" b-buy{if $value->instock == 0}-off{/if}" <a href="{if $value->instock > 0}{$conf.rooturl}cart/{if $value->slug != ""}mua-{$value->slug}{else}checkout?id={$value->id}{/if}{if !empty($parentpromotionprices.promoid)}{if $value->slug != ""}?{else}&{/if}prid={$value->barcode|trim}_{$parentpromotionprices.promoid}{/if}{/if}">{if $value->instock == 0}Hết hàng{else}Mua ngay ››{/if} </a>
                </div>
            </div>

            {/foreach}
        </div>
        <div class="socialbar">
            <div class="likepage">
                <span><iframe src="http://www.facebook.com/plugins/like.php?href={$conf.rooturl}account/bookmark/id/{$formData.codeuser}&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe></span>
            </div>
            <div class="sharepage">
                <label>Chia sẻ những sản phẩm này</label>
                <span><a href="https://www.facebook.com/sharer/sharer.php?u={$conf.rooturl}account/bookmark/id/{$formData.codeuser}"><i class="icon-face"></i></a></span>
                <span><a href="https://plus.google.com/share?url={$conf.rooturl}account/bookmark/id/{$formData.codeuser}"><i class="icon-goog"></i></a></span>
                <span><a href="http://twitthis.com/twit?url={$conf.rooturl}account/bookmark/id/{$formData.codeuser}"><i class="icon-twitter"></i></a></span>
            </div>
        </div>
        {else}
        Bạn chưa có sản phẩm yêu thích nào
        </div>
        {/if}


        <!--<div class="social-ic">
        	<div class="ics">
        		<img class="face" src="images/like-ic.png">
                <span>Chia sẻ danh sách này </span>
                <img src="images/ic-tw.png">
                <img src="images/ic-fb.png">
                <img src="images/ic-gg.png">

            </div>
        </div>-->


    </div>
</div>
</div>

{literal}
    <script>
        $(document).ready(function(){

        });
        function viewdetail(id,key)
        {
            $('.detailtr').hide();
            $('#tr_'+id).show();
            $('#tr_sale_'+key).addClass('Pr-ordertrbelow');
        }
        function deleteItem(id) {
            if (confirm("Bạn có muốn xóa sản phẩm này khỏi danh sách yêu thích không ?")) {
                $.ajax({
                    type: "POST",
                    data: { value:id,'action':'delbookmark'},
                    url: rooturl + "account/indexajax",
                    dataType: "html",
                    success: function (dataCheck) {
                        $('#div_'+id).remove();
                        if($('#div_'+id).length == 0)
                            window.location.reload(true);
                    }
                });
            }
        }
    </script>
{/literal}
