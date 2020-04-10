<!-- end header -->
<div class="navbarprod">
	<li><a href="#">Trang chủ</a> ››</li>
	<li>Profiles</li>
</div>

<!-- Profiles -->
<div class="profiles">

	<!-- đơn hang -->
	<div class="wrap_mess detailchecksaleorder">
		<div class="topbar_bb">
			<div class="topbar-l">Chi tiết Đơn hàng</div>
		</div>
		{if {$formData.countsale}>0}
			{if {$formData.invoice}==0}
				<div class="row">

					<div class="oder-det">

						{foreach $saleorder_info as $k=>$V}
							<div class="det-l">
								<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
									<tr>
										<td style='padding:4px'><strong>Nhân viên thu ngân</strong></td>
										<td>{$V.inputUser}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Nhân viên tư vấn</strong></td>
										<td>{$V.staffUser}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Nhân viên quản lý</strong></td>
										<td>{$V.reviewedUser}</td>
									</tr>
								</table>

							</div>
							<div class="det-r">
								<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
									<tr>
										<td style='padding:4px'><strong>Tên cửa hàng</strong></td>
										<td>{$V.storeName}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Ngày giao hàng</strong></td>
										<td>{$V.inputTime}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Ngày lập</strong></td>
										<td>{$V.inputTime}</td>
									</tr>
								</table>
							</div>
						{/foreach}
					</div>
				</div>
			{/if}
            
            
			{if {$formData.invoice}==2}
				<div class="row">

					<div class="oder-det">

						{foreach $saleorder as $k=>$V}
							<div class="det-l">
								<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
									<tr>
										<td style='padding:4px'><strong>Tên khách hàng</strong></td>
										<td>{$V.fullname}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Điện thoại</strong></td>
										<td>{$V.phone}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Email</strong></td>
										<td>{$V.email}</td>
									</tr>
								</table>

							</div>
							<div class="det-r">
								<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
									<tr>
										<td style='padding:4px'><strong>Thời gian góp</strong></td>
										<td>{$V.installmentmonth} tháng</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Số tiền góp mỗi tháng </strong></td>
										<td>{$V.pricemonthly|number_format} đ</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Ngày lập</strong></td>
										<td>{$V.datecreate}</td>
									</tr>
								</table>
							</div>
						{/foreach}
					</div>
				</div>
			{/if}
            
            
            {if {$formData.invoice}==4}
				<div class="row">

					<div class="oder-det">

						{foreach $saleorder_info as $k=>$V}
							<div class="det-l">
								<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
									<tr>
										<td style='padding:4px'><strong>Tên khách hàng</strong></td>
										<td>{$V.cusname}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Email</strong></td>
										<td>{$V.cusmail}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Số điện thoại</strong></td>
										<td>{$V.cusphone}</td>
									</tr>
								</table>

							</div>
							<div class="det-r">
								<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
									<tr>
										<td style='padding:4px'><strong>Tên cửa hàng</strong></td>
										<td>{$formData.storename}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Ngày giao hàng</strong></td>
										<td>{$V.inputTime}</td>
									</tr>
									<tr>
										<td style='padding:4px'><strong>Ngày lập</strong></td>
										<td>{$V.inputTime}</td>
									</tr>
								</table>
							</div>
						{/foreach}
					</div>
				</div>
			{/if}
			<div class="row">
				<div class="span10">
					<h1><big>Invoice #{$formData.saleid}</big></h1>
				</div>
			</div>
			<div class="row">
				<div class="span10 well invoice-body">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th width="50" style="text-align:center;">Thứ tự</th>
							<th width="60" style="text-align:center;">Hình</th>
							<th width="50%" style="text-align:center;">Tên sản phẩm</th>
							<th style="text-align:center;">Số lượng</th>
							<th width="164" style="text-align:center;">Giá bán</th>
						</tr>
						</thead>
						<tbody>
						{foreach $saleorder as $k=>$V}
							<tr>
								<td style="text-align:center;">{$k+1}</td>
								<td style="text-align:center;"><img src="{$V.img}" width="50"/></td>
								<td>
									<b> {$V.strProductName} </b></br>
									[{if {$V.strImei}!=""}{$V.strImei}{elseif {$V.strImei}==""}Empty{/if}]
								</td>
								<td style="text-align:center;">{$V.strQuantity}</td>
								<td style="text-align:center;">{$V.strTotalCost|number_format} đ</td>
							</tr>
						{/foreach}

						<tr>
							<td colspan="4" style="text-align:right;">Tổng cộng</td>
							<td><strong>{$formData.totalorder|number_format} đ</strong></td>
						</tr>
						{if {$formData.invoice}=="2"}
							<tr>
								<td colspan="4" style="text-align:right;">Khuyến mãi</td>
								<td><strong>{$formData.promotionmoney|number_format} đ</strong></td>
							</tr>
						{/if}
						<tr>
							<td colspan="4" style="text-align:right;">Tổng thanh toán</td>
							<td><strong style="color:#03f;"><big>{$formData.totalpayment|number_format} đ</big></strong></td>
						</tr>

						</tbody>
					</table>

					{*	<div id="saleordernote">Ghi chú: <em>N/A</em></div>
						<div id="saleorderpromotion">Thông tin khuyến mãi: <em>{$formData.discountname}</em></div>*}
				</div>
			</div>
		{else}
			<table class="table table-striped" cellpadding="5" width="100%">
				<tbody>
				<tr>
					<td colspan="6"> Không có đơn hàng</td>
				</tr>
				</tbody>
			</table>
		{/if}
	</div>

</div>

</div>
