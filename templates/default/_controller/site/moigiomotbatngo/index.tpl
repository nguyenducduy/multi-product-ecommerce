<script src="{$currentTemplate}js/countdown/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
{literal}
<script type="text/javascript">
  $(function(){
    $('#promo29counter').countdown({
      image: imageDir + '../js/countdown/digits.png',
      timerEnd: function(){ document.location.href=rooturl+"eventproducthours"; },
      startTime: '{/literal}{$countdowntime}{literal}'
    });
    $('#promo29headerdetailbutton').click(function(){
    	$('#promo29guideline').css('display', 'block');
    	$.scrollTo($('#promo29guideline').position().top, $('#promo29guideline').position().left);
    });
  });
</script>
<style type="text/css">
	#promo29main{margin:0px auto;width:1200px;}
	#promo29main a{color: #0099FF;}
	#promo29main #promo29header{width: 100%; position: relative;height: 280px;}
	#promo29main #promo29header #promo29headerlike{position: absolute;bottom: 22px;left: 358px;display:block;}
	#promo29main #promo29header #promo29headerfacebook{bottom: 22px;display: block;height: 26px;position: absolute;right: 361px;width: 28px;}
	#promo29main #promo29header #promo29headergplus{position: absolute;right: 329px;bottom: 22px;display:block;height: 26px;width: 28px;}
	#promo29main #promo29header #promo29headerdetailbutton{bottom: 18px;display: block;height: 29px;position: absolute;right: 566px;width: 175px;}
	#promo29main #promo29guideline{clear: both; margin: 40px 0px 20px;width: 100%;display: none;background-color: #FAFAFA;font-size: 13px;padding-bottom: 3px;}
	#promo29main #promo29guideline ul li{padding: 5px 0px; }
	
	#promo29main h1{font-size: 2.5em;margin: 20px 0px;text-align:center;display: block; clear: both;}
	#promo29main .cntSeparator {font-size: 54px;margin: 10px 7px;color: #000;}
	#promo29countdownbox{width: 100%;text-align:center;padding: 5px; width: 555px;margin: 0px auto;overflow:hidden;}
	#promo29main br { clear: both; }
    #promo29main .cntSeparator {font-size: 54px;margin: 10px 7px;color: #000;}
    #promo29main .promo29desc { margin: 7px 3px; }
    #promo29main .promo29desc div {float: left;font-family: Arial;width: 70px;margin-right: 65px;font-size: 44px;font-weight: bold;color: #333333;}
</style>
{/literal}
<div id="promo29main">
	<div id="promo29header">
		<img src="{$currentTemplate}images/site/popup/moi-gio-mot-bat-ngo-header.jpg?v=2" alt="" border="0" />
		<div id="promo29headerlike">
			<iframe src="http://www.facebook.com/plugins/like.php?href={$conf.rooturl|escape:'url'}&width=100&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px; float:left" allowTransparency="true"></iframe>
		</div>
		<a href="javascript:void(0)" id="promo29headerdetailbutton"></a>
		<a href="https://www.facebook.com/dienmaycom" id="promo29headerfacebook"></a>
		<a href="https://www.google.com/+dienmay" id="promo29headergplus"></a>
	</div>
	<h1>Chương trình sẽ bắt đầu sau:</h1>
	<div id="promo29countdownbox">
		
		<div id="promo29counter">
						
		</div>
		<div class="promo29desc">
			<div>Ngày</div>
			<div>Giờ</div>
			<div>Phút</div>
			<div>Giây</div>
		  </div>
	</div>
	<div id="promo29guideline">
		<div style="margin:0px auto;width:980px;background-color:#FAFAFA">
			<table style="width:980px">
				<tr>
					<td>					
						<div style="padding:10px"><div align="center" style="font-weight:bold; font-size:24px; color:#eb0808">QUY ĐỊNH VÀ THỂ LỆ CHƯƠNG TRÌNH
		“MỖI GIỜ MỘT BẤT NGỜ”</div><br/>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<span  style="font-weight:bold; font-size:14px;">NỘI DUNG</span>	
							<div style="height:10px;"></div>													
							<ul>

								<li>Tên chương trình: <span style="font-weight:bold">Mỗi giờ một bất ngờ</span></li>
								<li>Thời gian: từ 08h – 20h ngày 02/09/2013 </li>
								<li>Nội dung: Mừng ngày lễ Quốc Khánh 02/09, dienmay.com tổ chức chương trình<span style="font-weight:bold"> “Mỗi giờ một bất ngờ”</span> cho tất cả khách hàng thành viên dienmay.com. Khi đặt mua online, khách hàng có số thứ tự mua hàng thứ 29 sẽ được mua với giá ưu đãi chỉ với 29,000đ cho các mặt hàng tivi, tủ lạnh, máy giặt, gia dụng.</li>
							</ul>							
						</div>
						<div style="height:10px;"></div>
					</td>
				</tr>	
				<tr>
					<td>
						<div style="height:10px;"></div>
						<div>							
							<span style="font-weight:bold; font-size:14px;">CÁCH THỨC THAM GIA</span>	
							<div style="height:10px;"></div>						
							<ul>
								<li>Từ 8h sáng đến 20h ngày 02/09, dienmay.com sẽ bán 12 sản phẩm bao gồm các mặt hàng gia dụng, điện tử, điện lạnh, điện thoại với giá 29,000đ tại website dienmay.com/moi-gio-mot-bat-ngo. Tất cả 12 sản phẩm này trong ngày 02/09 sẽ được chuyển sang trạng thái<span style="font-weight:bold"> “ĐANG BÁN” </span>ngẫu nhiên trong thời gian bất kỳ.</li>
								<li>Khi sản phẩm được chuyển trạng thái sang “ĐANG BÁN”, khách hàng có thể đặt mua sản phẩm này bằng cách nhập đầy đủ thông tin: Họ tên, SĐT, email và gửi về cho dienmay.com</li>
								<li>01 sản phẩm chỉ có 01 thành viên được mua với giá <span style="font-weight:bold">29,000đ</span>, và thành viên đó phải có số thứ tự mua hàng thứ 29. <span style="font-weight:bold">Các thành viên không mua được với giá 29,000đ thì không phải chi trả thêm bất kỳ khoản tiền nào</span>.</li>
								<li>Dienmay.com sẽ liên hệ 12 người may mắn trong cùng ngày 02/09</li>
								<li>Khách hàng tại khu vực có siêu thị dienmay.com sẽ mua hàng và thanh toán trực tiếp tại siêu thị</li>
								<li>Khách hàng ở khu vực tỉnh không có siêu thị dienmay.com, dienmay.com sẽ hỗ trợ giao sản phẩm miễn phí. Khách thanh toán số tiền mua sản phẩm là 29,000đ sau khi nhận được hàng.</li>
							</ul>
						</div>
						<div style="height:10px;"></div>
					</td>
				</tr>
				<tr>
					<td>
						<div style="height:10px;"></div>
						<div> 											  	
						  	<span style="font-weight:bold; font-size:14px;">THỂ LỆ CHƯƠNG TRÌNH</span>		
						  	<div style="height:10px;"></div>				  	
						  	<ul>
								<li>Tất cả thành viên của dienmay.com trên toàn quốc đều được tham gia. Đăng ký thành viên <a target="_blank" href="https://ecommerce.kubil.app/thanh-vien/dang-ky" style="text-decoration:none"><span style="font-weight:bold">tại đây</span></a></li>
								<li>Thông tin mua hàng bắt buộc phải đầy đủ và chính xác, bao gồm : Họ tên, chứng minh nhân dân, nơi ở( tỉnh/thành phố), số điện thoại di động, địa chỉ email.</li>
								<li>Giá bán 29,000đ chỉ áp dụng cho 12 sản phẩm nằm trong quy định của chương trình</li>
								<li>12 sản phẩm sẽ được bán trong thời gian bất kỳ từ <span style=" font-weight:bold">08h – 20h</span> tại website <a target="_blank" style="color:#0000FF" href="https://ecommerce.kubil.app/moi-gio-mot-bat-ngo">dienmay.com/moi-gio-mot-bat-ngo</a></li>

								<li>01 sản phẩm / 01 lần đăng ký mua</li>
								<li>Mỗi khách hàng chỉ được mua thành công sản phẩm 29,000đ tối đa 1 lần.</li>
								<li>Danh sách tham gia sẽ được cập nhật liên tục và công khai trên website <a target="_blank" style="color:#0000FF" href="https://ecommerce.kubil.app/moi-gio-mot-bat-ngo">dienmay.com/moi-gio-mot-bat-ngo</a>.</li>
								<li>dienmay.com có quyền từ chối hỗ trợ các trường hợp thông tin cá nhân khách cung cấp không chính xác hoặc có dấu hiệu gian lận khi tham gia chương trình.</li>
								<li>Giá trị giảm giá không được quy đổi thành tiền mặt.</li>
								<li>Không áp dụng đồng thời chương trình khuyến mại khác.</li>
								<li>Chương trình không dành cho nhân viên thegioididong.com và dienmay.com</li>
								<li>Ban tổ chức có quyền thay đổi thể lệ và điều kiện chương trình mà không cần thông báo trước.</li>
								<li>Nếu có bất kỳ sự tranh chấp nào xảy ra thì quyền quyết định cuối cùng sẽ thuộc về dienmay.com.</li>
							</ul>
						</div>
						<div style="height:10px;"></div>
					</td>
				</tr>
				<tr>
					<td>
						<div style="height:10px;"></div>
						<div>							
							<span style="font-weight:bold; font-size:14px;">CƠ CẤU SẢN PHẨM</span>	
							<div style="height:10px;"></div>						
							<table style="border: 0.5px solid #cccccc;width:619px" border="1" rules="all" cellspacing="0" cellpadding="0" align="center">
								 <tr>
								    <td width="331" height="37" align="center" bgcolor="#0099FF"><span style="font-weight:bold; color:#FFFF00">Tên sản phẩm</span></td>
								    <td width="104" align="center" bgcolor="#0099FF"><span style="font-weight:bold; color:#FFFF00">Giá niêm yết</span></td>
								    <td width="86" align="center" bgcolor="#0099FF"><span style="font-weight:bold; color:#FFFF00">Giá 2/9</span></td>
								    <td width="70" align="center" bgcolor="#0099FF"><span style="font-weight:bold; color:#FFFF00">Số lượng</span></td>
								</tr>
							  	<tr>
							    	<td style="padding:10px">Máy xay sinh tố Panasonic MX-337NG</td>
							    	<td align="center">790,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Nồi cơm nắp gài Sharp KS-18EV</td>
							    	<td align="center">890,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Bếp điện từ Electrolux ETD32D</td>
							    	<td align="center">1,990,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">LVS Sanyo EM-S2182W</td>
							    	<td align="center">1,290,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Bình siêu tốc Philips HD4646</td>
							    	<td align="center">1,190,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Máy giặt LG WF-C7217T</td>
							    	<td align="center">4290000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Tủ lạnh Sharp SJ-16V-SL</td>
							    	<td align="center">5,590,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Tivi LED LG 42LN5120</td>
							    	<td align="center">9,890,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Gunners (Đầu 2015,Amply GA-303, Loa 2806, Micro LANE 151)</td>
							    	<td align="center">3,970,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">K+ HD (setup Box + đầu thu)</td>
							    	<td align="center">2,000,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">Điện thoại LG Optimus L1 II E410</td>
							    	<td align="center">1,990,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							  	<tr>
							    	<td style="padding:10px">USB Lacie 8GB</td>
							    	<td align="center">300,000</td>
							    	<td align="center">29,000</td>
							    	<td align="center">1</td>
							  	</tr>
							</table><!--end of inner table-->
						</div>
						<div style="height:10px;"></div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<div style="height:10px;"></div>		  	
							<span style="font-weight:bold; font-size:14px;">CÁCH XÁC ĐỊNH THÀNH VIÊN MUA GIÁ 29,000đ</span>
							<div style="height:10px;"></div>
							<ul>
								<li>Có 12 sản phẩm được bán với giá 29,000đ và 200 áo thun dienmay.com miễn phí cho các thành viên bất kỳ khi tham gia mua hàng ngày 02/09</li>
								<li>Thành viên được xác định mua giá 29,000đ là thành viên có số thứ tự mua hàng thứ 29.</li>
								<li>Số thứ tự mua hàng thứ 29 được căn cứ theo thời gian của hệ thống dienmay.com</li>
								<li>Trường hợp thành viên có số thứ tự mua hàng là 29 từ 2 lần trở lên thì thành viên đó được quyền chọn lựa sản phẩm có giá trị cao nhất. Sản phẩm còn lại sẽ được tính cho thành viên có số thứ tự mua hàng thứ 30 của sản phẩm đó.</li>
								<li>Thành viên được mua sản phẩm 29,000đ không được nhận áo thun dienmay.com</li>
								<li>200 khách hàng nhận áo thun sẽ được lấy ngẫu nhiên bằng kết quả quay số của số thứ tự mua hàng tại website www.random.org</li>
							</ul>						
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div style="height:10px;"></div>		  				  
						<div>									
						  	<span style="font-weight:bold; font-size:14px;">QUY ĐỊNH VỀ MUA HÀNG VÀ THANH TOÁN</span>	
						  	<div style="height:10px;"></div>					  	
						  	<ul>
								<li>Trong thời hạn 10 (mười) ngày kể từ ngày chương trình kết thúc, những 
								thành viên có số thứ tự được xác định mua giá 29,000đ không liên lạc với công ty Cổ Phần Thế Giới Điện Tử hoặc Công ty Cổ Phần Thế Giới Điện Tử không thể liên lạc để xác nhận thông tin thì sản phẩm đó được xem là không có người mua, khi đó mọi khiếu nại của thành viên có liên quan đến sản phẩm trên, Công ty Cổ Phần Thế Giới Điện Tử sẽ từ chối giải quyết.</li>

								<li>Thành viên được mua sản phẩm giá 29,000đ đến 01 trong 12 siêu thị dienmay.com trên toàn quốc để mua hàng và thanh toán số tiền 29,000đ theo quy định.</li>

								<li>Thành viên mua hàng có trách nhiệm xuất trình bản chính kèm một bản sao CMND hoặc hộ chiếu còn thời hạn hiệu lực.</li>

								<li>Nếu thành viên mua hàng không thể đến mua hàng thì có thể ủy quyền cho người khác nhận thay. Ngoài những giấy tờ theo quy định, người được ủy quyền phải xuất trình thêm Giấy ủy quyền nhận thưởng (có chứng thực bởi cơ quan chức năng có thẩm quyền). Xem mẫu giấy ủy quyền tại đây.</li>

								<li>Trường hợp thành viên ở xa không thể đến hoàn tất thủ tục mua hàng tại siêu thị, thì sẽ gửi  chứng minh nhân dân bản chụp về địa chỉ email cskh@dienmay.com, dienmay.com sẽ hỗ trợ giao sản phẩm tận nhà.</li>
							</ul>
						</div>
						<div style="height:10px;"></div>
					</td>
				</tr>
			</table>
		</div>

	</div>
</div>