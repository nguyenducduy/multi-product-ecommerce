<!-- Content -->
<form method="post" action="{$conf['rooturl']}cart/checkout" id="checkoutform" class="formcheckout">    
    <section>
    <div class="conttable">
        <div class="listcart">
            <div class="back"></div>
            <div class="conttitle">Giỏ hàng</div>
            {include file="notify.tpl" notifyError=$error notifySuccess=$success}
            {if !empty($cartItems)}
            <ul>
                
                    {foreach from=$cartItems item=item}
                        <li>
                            <div class="clearcart"><a href="{$conf.rooturl}cart/checkout/?deleteid={$item->product->id}">x</a></div>
                            <a href="{$item->product->getProductPath()}" style="float:left" title="{$item->product->name}"><img src="{$item->product->getSmallImage()}" alt="{$item->product->name}" title="{$item->product->name}" /></a>
                            <a title="{$item->product->name}" href="{$item->product->getProductPath()}">{$item->product->name}</a>
                            <select class="inputnumber cartquantity choosenb" name="fquantity[{$item->product->id}]">
                            {section name=loopquantity start=1 loop=6 step=1}
                                <option value="{$smarty.section.loopquantity.index}"{if $item->quantity == $smarty.section.loopquantity.index} selected="selected"{/if}>{$smarty.section.loopquantity.index}</option>
                            {/section}
                        </select>
                        <input type="hidden" name="promotionid[{$item->product->id}]" value="{$item->options['promotionid']}" /> 
                        <input type="hidden" name="regionid[{$item->product->id}]" value="{$item->options['regionid']}" />        
                            <label>Cái</label>
                          
                                <span class="price-cart-1" style="text-decoration: none">
                                    {if !empty($item->firstprice)}
                                    {if $item->firstprice > 0}
                                        <i style="text-decoration: line-through">{$item->firstprice|number_format}</i>
                                    {else}
                                        x
                                    {/if} đ
                                    {/if}
                                    <strong style="text-decoration: none">{math|number_format equation="x*y" x=$item->pricesell y=$item->quantity format="%.0f"} đ</strong>
                                </span>
                            <div class="clearfix"></div>
                        </li>
                    {/foreach}
            </ul>
           <div class="totalcart"><span>Tổng cộng (Đã bao gồm VAT):</span><strong>{$cartpricetotal|number_format} đ</strong></div>
           {else}
                        <p class="emptycart">Giỏ hàng hiện tại đang trống.  <a href="{$registry->conf.rooturl}">Tiếp tục mua sắm</a></p>
            {/if}
        </div>
        {if !empty($giftProduct)}
          <div class="giftProduct"></div>
          <div class="gift_box">
                <p>Cảm ơn bạn đã mua hàng tại <i><b>dienmay</b>.com</i><br/>
                <i><b>dienmay</b>.com rất vui được gửi đến bạn món quà tặng ý nghĩa nhân dịp giáng sinh</i>
                </p>
                <p>Vui lòng click chọn 1 trong 3 hộp quà dưới đây để chọn món quà như ý</p>
                
                <div class="gift_box_chose">
                <form action="">
                     {foreach from=$giftProduct key=key item=giftpro}  
                          <label>
                                <i class="icongiftbox"></i>
                                <span class="span">Hộp quà {$key+1}</span>
                                <input class="giftboxradio" name="productgift" type="radio" value="gift">
                        </label>
                    {/foreach}
                </form>
                </div>
            </div>
        {/if}
        {if !empty($cartItems)}
        <div class="infopay">
            <div class="conttitle">Thông tin khách hàng</div>
            {if $registry->me->id <= 0}<span class="infoa"><a href="{$registry->conf.rooturl}login/index/redirect/{base64_encode(Helper::curPageURL())}">
                Đã có tài khoản tại dienmay.com? Đăng nhập ngay</a></span>{/if}
            <div class="wrapinfopay">
                    <input class="inputfield wiinput inputinfo required" name="ffullname" id="ffullname" type="text" placeholder="Họ và tên (*)" maxlength="100" value="{$formData.ffullname}" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" />

                      <input class="inputfield wiinput inputinfo2 email" name="femail" id="femail" type="text" placeholder="Email (*)" value="{$formData.femail}" maxlength="80" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" />

                    <input class="inputfield wiinput inputinfo2 required" name="fphonenumber" id="fphonenumber" type="text" placeholder="Điện thoại (*)" value="{$formData.fphonenumber}" maxlength="14" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" />

                    <textarea class="inputfield wiinput textarea" name="faddress" id="faddress" cols="" rows=""  placeholder="Địa chỉ nhận hàng(*)" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)">{$formData.faddress}{if $formData.fdistrict != ""}, {$formData.fdistrict}{/if}{if $formData.fcity != ""}, {$registry->setting.region[$formData.fcity]}{/if}</textarea>
                    <textarea class="inputfield wiinput textarea" name="fnote" cols="" rows="" placeholder="Yêu cầu khác"></textarea>
                    
                <div class="textpay" style="padding-top:10px;color:#00a1e6;text-align: center"><strong>Bạn sẽ thanh toán cho nhân viên dienmay.com khi nhận hàng</strong></div>
            </div>
        </div>
        {/if}
        <div class="clearfix"></div>
    </div>
            <!-- -->    
        {if !empty($cartItems)}<input class="btn-pay btnbuynow submitform" onclick="return checkOutValidation()" type="submit" id="btncheckout" name="btncheckout" value="Mua hàng &#187;" />{/if}
        <div class="callme">Hoặc gọi cho chúng tôi: <a href="tel:+19001883" style="text-decoration: none"><strong>1900 1883</strong></a></div>     
        
    </section>
</form>
<!-- End content -->
{literal}
    <script type="text/javascript">
        // Active hop qua
        $('.giftboxradio').on('click',function(){
            $('i.icongiftbox').css('background-position',' 0 0')
            $(this).parent().children('i.icongiftbox').css('background-position',' -72px 0');
        })
        function checkOutValidation()
        {
            var pass = true;
            var fullname = $('#ffullname').val().trim();
            var email = $('#femail').val().trim();
            var phone = $('#fphonenumber').val().trim();
            var address = $('#faddress').val().trim();
            if(fullname == '')
            {
                pass = false;
                $('#ffullname').css('border','solid 1px red');
            }
            if(email == '')
            {
                pass = false;
                $('#femail').css('border','solid 1px red');
            }
            if(phone == '')
            {
                pass = false;
                $('#fphonenumber').css('border','solid 1px red');
            }
            if(address == '')
            {
                 pass = false;
                $('#faddress').css('border','solid 1px red');
            }
            if(pass == true)
            {
                var pricevalue = $('.totalcart strong').html().replace(new RegExp( ",", "g" ), "");
                pricevalue = pricevalue.split(' ');
                var opt_value = parseInt(pricevalue[0]);
                //_gaq.push(['_trackEvent', 'Checkout-Cart', 'Click', 'Mobile', opt_value, true]);

                eventclick('event', 'button_checkout','click','button_checkout',opt_value);
            }
            return pass;
        }
    </script>
{/literal}