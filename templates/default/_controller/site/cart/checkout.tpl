<form method="post" action="{$conf['rooturl']}cart/checkout" id="checkoutform" class="formcheckout">
    <div id="shopping">
        <div class="barshop">
            <ul>
                <li><i class="icon-market"></i><strong>Sản phẩm chính hãng</strong></li>
                <li class="margin-shop"><i class="icon-warranty"></i><strong>10 ngày đổi trả</strong></li>
                <li class="margin-shop"><i class="icon-care"></i><strong>Tổng đài tư vấn: <span>1900 1883</span> </strong></li>
            </ul>
        </div>
        <!-- cart-->
        <div class="infocust">
            {include file="notify.tpl" notifyError=$error notifySuccess=$success}
            <span>Thông tin khách hàng</span>
            <div class="forminfo">
                <i class="redstar">*</i>
                <select name="myregion" id="myregion" class="inputfield selectinfo required">
                    <option value="">--Chọn tỉnh--</option>
                    {foreach item=region key=regionid from=$setting.region}
                    <option {if $regionid == $formData.fregion}selected="selected" {/if} value="{$regionid}">{$region}</option>
                    {/foreach}
                </select>
                <i class="redstar">*</i>
                <select name="fgender" class="inputfield selectinfo1 required">
                    <option value="-1"{if !isset($formData.fgender) || $formData.fgender<0} selected="selected"{/if}>Anh/Chị</option>
                    <option value="1"{if isset($formData.fgender) && $formData.fgender==1} selected="selected"{/if}>Anh</option>
                    <option value="0"{if isset($formData.fgender) && $formData.fgender==0} selected="selected"{/if}>Chị</option>
                </select>
                <input class="inputfield inputinfo required" name="ffullname" type="text" placeholder="Họ và tên" maxlength="100" value="{$formData.ffullname}" />
                <i class="redstar">*</i>
                <input class="inputfield inputinfo2 required" name="fphonenumber" type="text" placeholder="Điện thoại" value="{$formData.fphonenumber}" maxlength="14" />
                <input class="inputfield inputinfo2" name="femail" type="text" placeholder="Email" value="{$formData.femail}" maxlength="80" />
                <input class="inputfield inputinfo2" name="faddress" type="text" placeholder="Địa chỉ nhận hàng" value="{$formData.faddress}" maxlength="200" />
                <!--<div class="clear"></div>
                <div class="checkbox"><input name="ftransfer" class="checkalign" type="checkbox" value="5" /> Giao hàng tận nhà</div>
                <div class="clear"></div>
                <div class="checkbox"><input name="fpaymentmethod" class="checkalign" type="checkbox" value="10" />  Thanh toán trực tuyến </div>-->
                {if !empty($paymentMethod)}
                    {foreach item=deli key=delik from=$paymentMethod}
                        {if !isset($formData.fpaymentmethod) && $delik==1}
                        <div class="checkbox"><input name="fpaymentmethod" class="checkalign" type="radio" value="{$delik}" checked="checked"/> {$deli}</div>
                        {else}
                        <div class="checkbox"><input name="fpaymentmethod" class="checkalign" type="radio" value="{$delik}"{if isset($formData.fpaymentmethod) && $formData.fpaymentmethod==$delik} checked="checked"{/if} /> {$deli}</div>
                        {/if}
                    {/foreach}
                {/if}
                <div class="clear"></div>
                <textarea class="inputfield textarea" name="" cols="" rows="" placeholder="Yêu cầu khác"></textarea>
            </div>
        </div>
        <div class="cart">
            <span>Thông tin giỏ hàng</span>
            <div class="cart-info">
            {if !empty($cartItems)}
                {foreach from=$cartItems item=item}
                <div class="cart-row">
                    <div class="delete-cart"><a title="Xóa sản phẩm" href="{$conf.rooturl}cart?deleteid={$item->product->id}"><i class="icon-delete"></i></a></div>
                    <div class="image"><a href="{$item->product->getProductPath()}" title="{$item->product->name}"><img src="{$item->product->getSmallImage()}" alt="{$item->product->name}" title="{$item->product->name}" /></a></div>
                    <div class="name"><a title="{$item->product->name}" href="{$item->product->getProductPath()}">{$item->product->name}</a></div>
                    <div class="number">
                        <input class="inputnumber cartquantity2" name="fquantity[{$item->product->id}]" type="text" value="{$item->quantity}" />
                        <!--<a href="#"><i class="icon-add"></i></a>
                        <a href="#"><i class="icon-except"></i></a>-->
                    </div>

                    {if !empty($item->firstprice)}
                    <div class="price-cart-1">{$item->firstprice|number_format} đ</div>
                    {/if}
                    <div class="multip">x</div>
                    <div class="price-cart">{$item->pricesell|number_format} đ</div>
                    <div class="multip">=</div>
                    <div class="price-total">{math|number_format equation="x*y" x=$item->pricesell y=$item->quantity format="%.0f"} đ</div>

                    
                    {if !empty($item->promotion)}
                        {assign var="promotioninfo" value=$item->promotion}
                    {else}
                        {assign var="promotioninfo" value=$item->product->promotionPrice()}
                    {/if}
                    {if !empty($promotioninfo)}
                    <div class="clear"></div>
                    <div class="cart-promot">
                        <div class="cart-promottext">Khuyến Mãi</div>
                        <div class="cart-promotdes">
                            <div class="promotdes">{if !empty($item->promotion)}{$promotioninfo->description}{else}{$promotioninfo.promodescription}{/if}</div>
                        </div>
                    </div>
                    {/if}
                    <div class="clear"></div>
                </div>
                {/foreach}
            {/if}
                <!--<div class="total-bill">
                    <ul>
                        <li>Tổng đơn hàng</li>
                        <li><span>{$cartpricetotal|number_format} đ</span></li>
                    </ul>
                </div>
                <div class="code-pay">
                    <ul>
                        <li><span>Nhập mã thanh toán nếu có:</span></li>
                        <li><input class="inputfield inputcode" name="" type="text" /></li>
                        <li><span class="deductible">- 1,000,000đ</span></li>
                    </ul>
                </div>-->
                <div class="total-pay">
                    <ul>
                        <li>Tổng giá trị thanh toán:</li>
                        <li><span class="pricered">{$cartpricetotal|number_format} đ</span></li>
                    </ul>
                </div>
                <div class="btn-wrap">
                    <div class="btn-wrap-left"><a href="{$conf.rooturl}">Tiếp tục mua hàng</a></div>
                    {if !empty($cartItems)}<div class="btn-wrap-right"><input class="btn-pay submitform" type="submit" id="btncheckout" name="btncheckout" value="Mua hàng" /></div>{/if}
                </div>
                <!-- Phụ kiện đi kèm -->
                <!--<div class="recom">
                    <div class="recomtitle">Phụ kiện kèm theo <span>(Mua phụ kiện kèm với sản phẩm Quí Khách tiết kiệm được nhiều hơn)</span></div>
                    <div class="recomlist">
                        <ul>
                            <li> <a href="#"><img src="images/tivi-led-.jpg" alt="" title="" /> </a>
                                 <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                                 <div class="priceold pricerecom-1">289.000 VND</div>
                                 <div class="pricenew pricerecom-2">189.000 VND</div>
                                 <div class="addshop"><input name="" class="checkalign" type="checkbox" value="" />Mua</div>
                            </li>
                            <li> <a href="#"><img src="images/tivi-led-.jpg" alt="" title="" /> </a>
                                 <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                                 <div class="priceold pricerecom-1">289.000 VND</div>
                                 <div class="pricenew pricerecom-2">189.000 VND</div>
                                 <div class="addshop"><input name="" class="checkalign" type="checkbox" value="" />Mua</div>
                            </li>
                            <li> <a href="#"><img src="images/tivi-led-.jpg" alt="" title="" /> </a>
                                 <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                                 <div class="priceold pricerecom-1">289.000 VND</div>
                                 <div class="pricenew pricerecom-2">189.000 VND</div>
                                 <div class="addshop"><input name="" class="checkalign" type="checkbox" value="" />Mua</div>
                            </li>
                            <li> <a href="#"><img src="images/tivi-led-.jpg" alt="" title="" /> </a>
                                 <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                                 <div class="priceold pricerecom-1">289.000 VND</div>
                                 <div class="pricenew pricerecom-2">189.000 VND</div>
                                 <div class="addshop"><input name="" class="checkalign" type="checkbox" value="" />Mua</div>
                            </li>
                            <li> <a href="#"><img src="images/tivi-led-.jpg" alt="" title="" /> </a>
                                 <a class="position-a" href="#">Điện tử Tiger JBA - V18W </a>
                                 <div class="priceold pricerecom-1">289.000 VND</div>
                                 <div class="pricenew pricerecom-2">189.000 VND</div>
                                 <div class="addshop"><input name="" class="checkalign" type="checkbox" value="" />Mua</div>
                            </li>
                        </ul>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</form>