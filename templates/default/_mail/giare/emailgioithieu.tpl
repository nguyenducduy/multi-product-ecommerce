{include file="`$smartyMailContainerRoot`header.tpl"}
<table style="margin:0 auto;font-family: arial;font-size: 12px; line-spacing: 1.7;" width="600" cellpadding="0" cellspacing="0">  
  <tr>
    <td>
        <table width="97%" cellspacing="0" cellpadding="0" style="margin:30px 0 20px">
          <tr>
            <td style="font:bold 20px/30px Arial; color:red">Giới thiệu tham gia chương trình mua sản phẩm giá 1,000đ</td>
          </tr>
        </table>
    </td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td>
        <table width="100%" cellspacing="0" cellpadding="0" style="color:#333; font:normal 15px/25px Arial;">
              <tr>
                <td><span style="font:16px Arial; line-height:25px">Chào <b>bạn {$tennguoinhan}</b>!<br />  
                {$tennguoigui} vừa giới thiệu bạn tham gia <b>chương trình mua sản phẩm giá 1,000đ</b> từ <span style="color:#00a1e6">dienmay.com</span></td>
            <tr>
                <td>Để mua tủ lạnh, máy giặt, điện thoại, laptop... với giá 1,000đ, bạn chỉ cần đăng ký với 2 bước cực kỳ đơn giản tại đường link: <a href="{$conf.rooturl}giare" target="_blank" style="text-decoration:none">{$conf.rooturl}giare</a></td>
            </tr>
              </tr>
              <tr>
                <td>Với mỗi bước giới thiệu thêm bạn bè tham gia chương trình hoặc mua hàng online tại dienmay.com, bạn càng có nhiều hơn cơ hội.</td>
              </tr>
              <tr>
                <td>Chúc bạn nhiều may mắn mua được các sản phẩm giá trị tại dienmay.com chỉ với 1,000đ </td>
              </tr>
              
              <tr>
                  <td>Trân trọng, <br />         
                    <a href="https://ecommerce.kubil.app" target="_blank" style="text-decoration:none">dienmay.com</a></td>
              </tr>
            </table>

    </td>
  </tr>  
</table>
{include file="`$smartyMailContainerRoot`footer.tpl"}