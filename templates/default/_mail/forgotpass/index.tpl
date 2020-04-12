{include file="`$smartyMailContainerRoot`forgotpass/header.tpl"}
<tr style="margin-top: 10px;">
    <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #0d0d0d;">
        <div style="margin-top: 10px;">
            <h2 style="text-align: center;">LẤY LẠI MẬT KHẨU <i>DIENMAY.COM</i></h2>
            <div>
                <p>Xin chào <strong>{$formData.fullname}</strong>,
                    <br />
                    <br />
                    Bạn đã gửi cho <a href="https://ecommerce.kubil.app?utm_source=trigger-email&utm_medium=email-reset-password&utm_campaign=more-traffic-from-trigger-email&utm_content=body-link-dienmay"
                                      title="dienmay.com"><i><strong>dienmay</strong>.com</i></a> lời yêu cầu đổi mật khẩu, vui lòng nhấn vào hoặc chép và dán đường dẫn dưới đây vào thanh địa chỉ trên trình duyệt của bạn, nhập và xác nhận mật khẩu mới.
                    <br />
                </p>
                <div style="background: #fafafa; border: 1px dotted #cccccc; padding: 10px;"><strong>Chú ý : Hãy chọn mật khẩu khó đoán, đủ dài và chứa các ký tự số, ký tự in hoa, ký tự đặc biệt , khoảng trắng để tránh bị kẻ xấu đánh cắp.

                    </strong></div>

                <p style="text-align: center; padding: 10px;">
                    <a href="{$formData.link}?utm_source=trigger-email&utm_medium=email-reset-password&utm_campaign=more-traffic-from-trigger-email&utm_content=button-call-to-action" title="Lấy lại mật khẩu" style="text-decoration: none; color: White; background: #FE9F17; font-size: 16px;
                                            padding: 10px 20px;" >ĐỔI MẬT KHẨU ›› </a></p>
                <p><a href="{$formData.link}?utm_source=trigger-email&utm_medium=email-reset-password&utm_campaign=more-traffic-from-trigger-email&utm_content=link-to-reset-password">{$formData.link}?utm_source=trigger-email&utm_medium=email-reset-password&utm_campaign=more-traffic-from-trigger-email&utm_content=link-to-reset-password</a></p>

                <div style="text-align: center;">Nếu có gì thắc mắc, xin mời liên hệ Trung tâm chăm sóc khách hàng <b style="color: Red; font-size: 14px;">
                        1900 1883</b></div>
            </div>
        </div>
    </td>
</tr>
{include file="`$smartyMailContainerRoot`forgotpass/footer.tpl"}