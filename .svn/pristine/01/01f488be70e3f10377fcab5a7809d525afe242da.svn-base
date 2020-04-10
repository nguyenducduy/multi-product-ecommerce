<!-- Content -->
    <section>
       <div class="login">
          <div class="btnback"><a href="javascript:history.back()">« Trở về</a></div>
          <h5>Kiểm tra đơn hàng</h5>
       </div>
       <div class="search">
       <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
        <form action="" method="post">
            <input onfocus="return false" class="textinput" name="fidsaleorder" type="text" value="{$formData.fidsaleorder}" placeholder="Nhập mã đơn hàng">
            <button class="btnsearch" type="submit" name="submit"><i class="icon-search"></i></button>
            <input class="textinput" name="action" type="hidden" value="checkordermobile">
       </form>
      </div>
      <article>
      	<p style="padding:10px">
        	<i>Lưu ý:</i> Bạn không nhớ mã số đơn hàng? Bạn hãy kiểm tra email hay tin nhắn mà dienmay.com đã gửi cho bạn lúc đặt hàng. Trong đó có chứa thông tin đơn hàng của bạn.
        </p>
        {if $formData.countSal > 0}
      	<table width="100%" border="0">
          <tr bgcolor="#f8f8f8">
            <td>
            	<table width="100%" border="0" cellspacing="10" cellpadding="0">
                  <tr>
                    <td width="50%">Mã đơn hàng:</td>
                    <td width="50%"><strong style="color:#00a1e6">{$formData.saleorder[0]['saleorderid']}</strong></td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="10" cellpadding="0">
                  <tr>
                    <td width="50%">Ngày đặt hàng</td>
                    <td width="50%"><span style="color:#0C0">{$formData.saleorder[0]['inputtime']}</span></td>
                  </tr>
                </table>
            </td>
          </tr>
           <tr bgcolor="#f8f8f8" >
            <td>
            	<table width="100%" border="0" cellspacing="10" cellpadding="0">
                  <tr>
                    <td width="50%">Tỉnh thành</td>
                    <td width="50%"><span style="color:#0C0">{$formData.saleorder[0]['outputstorename']}</span></td>
                  </tr>
                </table>
            </td>
          </tr>
           
          <tr>
            <td>
            	<table width="100%" border="0" cellspacing="10" cellpadding="0" >
                  <tr>
                    <td width="50%">Tình trạng: </td>
                    <td width="50%"><strong style="color:#ff8400">Đang giao</strong></td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr bgcolor="#f8f8f8">
            <td>
            	<table width="100%" border="0" cellspacing="10" cellpadding="0">
                  <tr>
                    <td width="50%">Tổng</td>
                    <td width="50%"><span style="color:#0C0">{$formData.saleorder[0]['totalamount']|number_format}</span></td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
 {/if}

      </article>
    </section>
<!-- End content -->