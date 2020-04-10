<section>
    <div class="ordersuccess">
        <p>
        Xin chào <strong>{$myOrder->shippingfullname}</strong>,
        </p>
        <p>
        Cám ơn bạn đã đặt hàng tại dienmay.com. Chúng tôi đã nhận được đơn hàng của bạn vào lúc <strong>{$myOrder->datecreated|date_format:"%d/%m/%Y %T"}</strong>
        </p>
        {if !empty($invoicedid)}
        <div class="order-id">
        Mã số đơn hàng của bạn:
        <span>
        {$invoicedid|strtoupper}
        </span>
        </div>
        {/if}
        <p>
        {if !empty($productGift) && $productGift->id > 0}
        <div class="gift-order">
            <p style="margin-top:5px;">
              Chúc mừng bạn nhận được món quà: <b>{$productGift->name}</b> <br/>
              Quà tặng sẽ được áp dụng kèm với đơn hàng
            </p>
            <img src="{$productGift->getSmallImage()}" style="margin-bottom:20px" />
        </div>
       {/if}
        Bộ phận CSKH của dienmay.com sẽ liên hệ với bạn để xác nhận đơn hàng. Chúng tôi cũng đã gửi email và tin nhắn SMS về đơn hàng này cho bạn.
        </p>
        <p>
        Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua hotline <strong style="color: Red;">1900 1883</strong> hoặc email <strong>cskh@dienmay.com</strong>.
        </p>
        <p>
        Hy vọng bạn đã có những trải nghiệm mua sắm online thật thú vị cùng dienmay.com
        </p>
        <div class="btnbackhome" ><a href="{$conf.rooturl}">Về trang chủ &#187;</a></div>
</div>
</section>
