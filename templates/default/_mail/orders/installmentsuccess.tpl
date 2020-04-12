{include file="`$smartyMailContainerRoot`header.tpl"}
<table style="margin:0 auto;font-family: arial;font-size: 12px; line-spacing: 1.7;" width="600" cellpadding="0" cellspacing="0">  
  <tr>
    <td>
        <table width="97%" cellspacing="0" cellpadding="0" style="margin:30px 0 20px">
          <tr>
            <td style="font:bold 20px/30px Arial; color:red">Xác nhận đặt hàng</td>
          </tr>
          <tr>
            <td style="font-family: arial;font-size: 12px;">Chào bạn <strong>{$formData.installment->fullname}</strong></td>
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
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Mã đơn hàng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.installment->invoiceid|strtoupper}</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Thời gian đặt hàng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.installment->datecreate}</strong></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Sản phẩm áp dụng:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.product->name}</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Giá sản phẩm:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.product->sellprice|number_format}</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Thời hạn trả góp:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.installment->installmentmonth} tháng</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Tỷ lệ trả trước:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{$formData.installment->segmentpercent}%</strong></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Trả góp hàng tháng với ACS:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{if $formData.installmentacs.nosupport == 1}~{$formData.installmentacs.monthly|number_format}{else}Không hỗ trợ{/if}</strong></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td style="padding: 2px 8px 0px 15px;font-family: arial;font-size: 12px;" width="35%">Trả góp hàng tháng với PPF:</td>
            <td style="padding:5px;font-family: arial;font-size: 12px;"><strong>{if $formData.installmentppf.nosupport == 1}~{$formData.installmentppf.monthly|number_format}{else}Không hỗ trợ{/if}</strong></td>
          </tr>
        </table>

    </td>
  </tr> 
  <tr>
      <td height="20">&nbsp;</td>
  </tr>
  <tr>
        <td>
            <a href="https://ecommerce.kubil.app" target="_blank" style="color:#0072cc;font-weight:bold; font-style:italic">dienmay.com</a> sẽ liên lạc với bạn để xác nhận chi tiết đơn hàng qua tổng đài <strong>19001883</strong> hoặc <strong>083 989 6789</strong>.<br /><br />

        Trân trọng,<br />
        <a href="https://ecommerce.kubil.app" target="_blank" style="color:#0072cc;font-weight:bold; font-style:italic">dienmay.com</a><br /><br />
      </td>
  </tr>
  
</table>
{include file="`$smartyMailContainerRoot`footer.tpl"}