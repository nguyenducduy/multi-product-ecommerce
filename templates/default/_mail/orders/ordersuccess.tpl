{include file="`$smartyMailContainerRoot`header.tpl"}
<table style="margin:0 auto;font-family: arial;font-size: 12px; line-spacing: 1.7;" width="600" cellpadding="0" cellspacing="0">  
  <tr>
    <td>
        <table width="97%" cellspacing="0" cellpadding="0" style="margin:30px 0 20px">
          <tr>
            <td style="font:bold 20px/30px Arial; color:red">Xác nhận đặt hàng</td>
          </tr>
          <tr>
            <td style="font-family: arial;font-size: 12px;">Chào bạn <strong>{$formData.order->billingfullname}</strong></td>
          </tr>
          <tr>
            <td style="font-family: arial;font-size: 12px;">
                Cảm ơn bạn đã tham gia giao dịch và sử dụng dịch vụ tại <a href="https://ecommerce.kubil.app" target="_blank" style="color:#0072cc; font-weight:bold; font-style:italic">dienmay.com</a><br />
Bạn đã đặt hàng thành công với thông tin đơn hàng như sau:
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td>
        <table width="97%" cellpadding="1" cellspacing="1" style="margin:10px;">
        <tr>
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="30%">Mã đơn hàng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.order->invoiceid|strtoupper}</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="30%">Thời gian đặt hàng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.order->datecreated}</strong></td>
          </tr>
          {if !empty($formData.order->deliverymethod)}
          <tr bgcolor="#ffffff">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="30%">Phương thức nhận hàng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.order->deliverymethod}</strong></td>
          </tr>
          {/if}
          {if !empty($formData.order->paymentmethod)}
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="30%">Phương thức thanh toán:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.order->paymentmethod}</strong></td>
          </tr>
          {/if}
          <tr bgcolor="#ffffff">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="30%">Thông tin người nhận:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.order->shippingfullname}</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="30%">Lưu ý về đơn hàng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.order->note}</strong></td>
          </tr>
        </table>

    </td>
  </tr>
  <tr bgcolor="#ffffff">
    <td height="30">&nbsp;</td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td>
        <table width="97%" cellpadding="1" cellspacing="1" style="margin:10px;">
          <tr bgcolor="#0072cc">
            <td width="50%" align="center" style="padding:5px; font-weight:bold;color:#ffffff;font-family: arial;font-size: 12px;">Tên sản phẩm</td>
            <td align="center" style="padding:5px; font-weight:bold;color:#ffffff;font-family: arial;font-size: 12px;">Đơn giá</td>
            <td align="center" style="padding:5px; font-weight:bold;color:#ffffff;font-family: arial;font-size: 12px;">Số lượng</td>
            <td align="center" style="padding:5px; font-weight:bold;color:#ffffff;font-family: arial;font-size: 12px;">Thành tiền</td>
          </tr>
          {foreach from=$formData.orderdetail item=orderdetailloop name=orderdetailloop}
          <tr bgcolor="#{if $smarty.foreach.orderdetailloop.iteration % 2 ==0}ffffff{else}FFFFCC{/if}">
            <td align="center" style="padding:5px;font-family: arial;font-size: 12px;">{$orderdetailloop->product->name}</td>
            <td align="center" style="padding:5px;font-family: arial;font-size: 12px;">{if $orderdetailloop->product->finalprice > 0}{$orderdetailloop->product->finalprice|number_format} đ (*){else}{$orderdetailloop->product->sellprice|number_format} đ (*){/if}</td>
            <td align="center" style="padding:5px;font-family: arial;font-size: 12px;">{$orderdetailloop->quantity}</td>
            <td align="center" style="padding:5px;font-family: arial;font-size: 12px;">{math|number_format equation="x*y" x=$orderdetailloop->pricefinal y=$orderdetailloop->quantity format="%.0f"} đ</td>
          </tr>
          {/foreach}
          <tr bgcolor="#0099CC">
            <td colspan="3" align="right" style="padding:5px; color:#fff; font-weight:bold;font-family: arial;font-size: 12px;">Tổng cộng</td>
            <td align="center" style="padding:5px; color:#FF0;font-weight:bold;font-family: arial;font-size: 12px;">{$formData.order->pricefinal|number_format} đ</td>
          </tr>
        </table>

    </td>
  </tr>
  <tr>
      <td height="20">&nbsp;</td>
  </tr>
  <tr>
      <td>(*) Giá niêm yết chưa bao gồm khuyến mãi: giảm giá hoặc tặng quà (nếu có).<br /><br /></td>
  </tr>
  <tr>
        <td>
            <a href="https://ecommerce.kubil.app" target="_blank" style="color:#0072cc;font-weight:bold; font-style:italic;font-family: arial;font-size: 12px;">dienmay.com</a> sẽ liên lạc với bạn để xác nhận chi tiết đơn hàng qua tổng đài <strong>19001883</strong> hoặc <strong>08 39 48 6789</strong>. Sau khi đơn hàng được xác nhận, chúng tôi sẽ tiến hành giao hàng.<br /><br />

        Trân trọng,<br />
        <a href="https://ecommerce.kubil.app" target="_blank" style="color:#0072cc;font-weight:bold; font-style:italic;font-family: arial;font-size: 12px;">dienmay.com</a><br /><br />
      </td>
  </tr>
  
</table>
{include file="`$smartyMailContainerRoot`footer.tpl"}