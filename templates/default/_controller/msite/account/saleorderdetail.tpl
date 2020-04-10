<!-- end header -->
<div class="navbarprod">
	<li><a href="#">Trang chủ</a> ››</li>
	<li>Profiles</li>
</div>

<!-- Profiles -->
<div class="profiles">
	{include file="`$smartyControllerGroupContainer`nav_left_account.tpl"}

	<!-- đơn hang -->
	<div class="wrap_mess">
		<div class="topbar_bb">
			<div class="topbar-l">Chi tiết Đơn hàng</div>
		</div>
		<div class="row">

			<div class="oder-det">
				{if count($saleorder_info)>0}
				{foreach $saleorder_info as $k=>$V}
					<div class="det-l">
						<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
							<tr>
								<td><strong>Nhân viên thu ngân</strong></td>
								<td>{$V->inputUser}</td>
							</tr>
							<tr>
								<td><strong>Nhân viên tư vấn</strong></td>
								<td>{$V->staffUser}</td>
							</tr>
							<tr>
								<td><strong>Nhân viên quản lý</strong></td>
								<td>{$V->reviewedUser}</td>
							</tr>
						</table>

					</div>
					<div class="det-r">
						<table width="100%" bgcolor="#f8f8f8" cellpadding="0" cellspacing="8">
							<tr>
								<td><strong>Tên cửa hàng</strong></td>
								<td>{$V->storeName}</td>
							</tr>
							<tr>
								<td><strong>Ngày giao hàng</strong></td>
								<td>{$V->inputTime}</td>
							</tr>
							<tr>
								<td><strong>Ngày lập</strong></td>
								<td>{$V->inputTime}</td>
							</tr>
						</table>
					</div>
				{/foreach}
			</div>
		</div>
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
							<td style="text-align:center;"><img src="{$V->img}" width="50"/></td>
							<td>
								<b> {$V->strProductName} </b></br>
								[{if {$V->strImei}!=""}{$V->strImei}{elseif {$V->strImei}==""}Empty{/if}]
							</td>
							<td style="text-align:center;">{$V->strQuantity}</td>
							<td style="text-align:center;">{$V->strTotalCost|number_format:0:",":"."} đ</td>
						</tr>
					{/foreach}

					<tr>
						<td colspan="4" style="text-align:right;">Tổng cộng</td>
						<td><strong>{$formData.totalorder|number_format:0:",":"."} VNĐ</strong></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align:right;">Khuyến mãi</td>
						<td><strong>{$formData.promotionmoney|number_format:0:",":"."} VNĐ</strong></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align:right;">Tổng thanh toán</td>
						<td><strong style="color:#03f;"><big>{$formData.totalpayment|number_format:0:",":"."} VNĐ</big></strong></td>
					</tr>

					</tbody>
				</table>

				{else}
				<table class="table table-bordered">
					<tr>
						<td colspan="6"> Không có đơn hàng</td>
					</tr>
				</table>
				{/if}
			</div>
		</div>

	</div>

</div>

</div>
