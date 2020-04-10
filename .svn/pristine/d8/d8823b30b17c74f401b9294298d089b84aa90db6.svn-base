<script  type="text/javascript" src="{$currentTemplate}js/site/popup.js"></script>
<div class="wrap-quickbuy">
<p style="color:#00a1e6"><i class="icon-advice"></i>Mua hàng nhanh</p>
<!--<p>Đặt hàng nhanh</p><div class="closed"><a href="#"><img src="images/closed.png" width="25" height="25" /></a></div>-->
    <div class="qb-left">
        <div class="qb-left-sp">
            {if !empty($cartItems)}
            <ul>
                {foreach from=$cartItems item=item}
                <li>
                    <span class="deleted"><a href="{$conf.rooturl}cart/?deleteid={$item->product->id}" rel="nofollow" id="{$item->product->id}"><img src="{$currentTemplate}images/site/delete.jpg" width="14" height="14" alt="" /></a></span>
                    <a href="javascript:parent.location.href='{$item->product->getProductPath()}'" title="{$item->product->name}"><img src="{$item->product->getSmallImage()}" width="60" height="60" alt="{$item->product->name}" border="0" /></a>
                    <a href="javascript:parent.location.href='{$item->product->getProductPath()}'" class="showproduct" title="{$item->product->name}">{$item->product->name}</a>
                    <span>{$item->quantity} x {$item->pricesell|number_format} đ</span>
                    {if !empty($item->firstprice)}
                        <span class="price2">{$item->firstprice|number_format} đ</span>                    
                    {/if}                    
                </li>
                {/foreach} 
            </ul>
            {/if}
            <div class="totalqb"><span>Tổng tiền:</span> {$cartpricetotal|number_format} đ</div>
            </div>
           
        <div class="infocust">
            <form method="post" action="{$conf.rooturl}{$controller}{if $action!='index'}/{$action}{/if}" class="formcheckout">
                <label class="inline-qb">Chọn tỉnh <span>*</span></label>
                <select class="wi_240px required" name="myregion" id="myregion">
                    {foreach item=region key=regionid from=$setting.region}
                    <option {if $regionid == $formData.fregion}selected="selected" {/if} value="{$regionid}">{$region}</option>
                    {/foreach}
                </select><br />
                
                <label class="inline-qb">Họ và tên <span>*</span></label>
                <select name="fgender" class="required" style="width:85px">
                    <option value=""{if !isset($formData.fgender) || $formData.fgender==''} selected="selected"{/if}>Anh/Chị</option>
                    <option value="1"{if isset($formData.fgender) && $formData.fgender==1} selected="selected"{/if}>Anh</option>
                    <option value="0"{if isset($formData.fgender) && $formData.fgender==0} selected="selected"{/if}>Chị</option>
                </select>
                <input class="wi_170px required" name="ffullname" type="text" style="width: 150px!important;" maxlength="100" value="{$formData.ffullname}" />
                <label class="inline-qb">Điện thoại <span>*</span></label>
                <input class="wi_240px required" name="fphonenumber" type="text" value="{$formData.fphonenumber}" maxlength="14" />
                
                <label class="inline-qb">Email</label>
                <input class="wi_240px email" name="femail" type="text" value="{$formData.femail}" maxlength="80" />
                
                <label class="inline-qb">Địa chỉ nhận hàng</label>
                <input class="wi_240px" name="faddress" type="text" value="{$formData.faddress}" maxlength="200" />
                <label class="inline-qb">Lựa chọn giao hàng <span>*</span></label>
                <p>
                {if !empty($orderDelivery)}
                    {foreach item=deli key=delik from=$orderDelivery}
                        {if !isset($formData.ftransfer) && $delik == 1}
                        <input name="ftransfer" type="radio" value="{$delik}" checked="checked" /> {$deli}<br/>
                        {else}
                        <input name="ftransfer" type="radio" value="{$delik}"{if isset($formData.ftransfer) || $formData.ftransfer==$delik} checked="checked"{/if} /> {$deli}<br/>
                        {/if}
                    {/foreach}
                {/if}
                </p>
                <div class="clear"></div>
                <label class="inline-qb">Yêu cầu khác</label>
                <textarea class="wi_240px" name="frequest" cols="" rows="">{$formData.frequest}</textarea>
                <div class="buynow2 wi_120px" id="popupbuy">
                    <input type="submit" value="Mua ngay" name="btncheckout" class="submitform" />
                </div>
            </form>
        </div>
    </div>
    {if !empty($relProductCart)}
       <div class="qb-right" >
               <p>NHỮNG SẢN PHẨM MÀ BẠN CÓ THỂ QUAN TÂM</p>
            <ul class="qb-right-sp">
            {foreach item=product from=$relProductCart}
                <li>
                    <a href="javascript:parent.location.href='{$product->getProductPath()}'" title="{$product->name}"><img src="{$product->getSmallImage()}" width="60" height="60" alt="{$product->name}" /></a>
                    <a href="javascript:parent.location.href='{$product->getProductPath()}'" title="{$product->name}">{$product->name}</a>
                    <span>{$product->sellprice|number_format} đ</span>                        
                    <a href="{$conf.rooturl}cart/?id={$product->id}" class="addbuy" rel="nofollow">Mua thêm</a>
                </li> 
            {/foreach}                
            </ul>           
       </div>
    {/if}
</div>