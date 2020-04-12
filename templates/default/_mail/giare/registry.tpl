{include file="`$smartyMailContainerRoot`header.tpl"}
<table width="100%" cellspacing="0" cellpadding="0" style="font:normal 15px/25px Arial;">
  <tr>
    <td><span style="font:16px Arial; line-height:25px">Chúc mừng {$formData.gender} {$formData.name} đăng ký thành công <b>Chương trình mua điện máy giá 1000đ</b> từ <span>dienmay.com</span>, mã rút thăm của {$formData.gender} {$formData.name} là: <strong>{$formData.code}</strong></span></td>
  </tr>
  <tr>
    <td> Để có thêm nhiều mã rút thăm từ chương trình, {$formData.gender} có thể: </td>
  </tr>
  <tr>
      <td> - Mời bạn bè cùng tham gia và đăng ký chơi game bằng đường link này:  <a href="{$formData.link}" style="color:#00a1e6; text-decoration:none">{$formData.link}</a>thông qua facebook, forum, email hoặc trò chuyện, chat với bạn bè. </td>
  </tr>
  <tr>
    <td>Với mỗi lượt giới thiệu đăng ký chơi thành công, {$formData.gender} sẽ nhận thêm một mã rút thăm. Nếu bạn của {$formData.gender} đăng ký chơi và được giải, {$formData.gender} {$formData.name} cũng được nhận quà. <a href="https://ecommerce.kubil.app/giare" style="text-decoration:none">(Xem thể lệ chương trình)</a>	</td>
  </tr>
 
  <tr>
    <td> - Mua hàng online tại website <a href="https://ecommerce.kubil.app" target="_blank" style="color:#00a1e6; text-decoration:none">www.dienmay.com,</a> với mỗi <span style=" font:bold 16px Arial">500,000đ</span> giá trị hoá đơn mua hàng online {$formData.gender} cũng có thêm một mã rút thăm mới <a href="https://ecommerce.kubil.app/giare" style="color:#00a1e6; text-decoration:none">(xem thể lệ chương trình)</a></td>
  </tr>
  <tr>
    <td> Chi tiết về kết quả trúng thưởng sẽ được cập nhật tại <a href="https://ecommerce.kubil.app/giare" target="_blank" style="color:#00a1e6; text-decoration:none">www.dienmay.com/giare</a> 	</td>
  </tr>
  <tr>
    <td>Chúc {$formData.gender} <b>{$formData.name}</b> nhiều may mắn mua được các sản phẩm giá trị tại  <a href="https://ecommerce.kubil.app" target="_blank" style="color:#00a1e6; text-decoration:none">dienmay.com</a> chỉ với <span style="font:bold 16px Arial">1000đ</span></td>
  </tr>
  <tr>
  	<td>Trân trọng, <br /> 		
        <a href="https://ecommerce.kubil.app" target="_blank" style="color:#00a1e6; text-decoration:none">dienmay.com</a>
        </td>
  </tr>
</table>
{include file="`$smartyMailContainerRoot`footer.tpl"}