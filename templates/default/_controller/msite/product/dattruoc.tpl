<div class="wrap-advice">
<p style="color:#00a1e6"><i class="icon-advice"></i>Danh sách khách hàng đặt hàng trước "{$myProduct->name}"</p>
{if !empty($myOrders)}
	<table class="table">
		<thead><tr>
			<th>STT</th>
			<th>Tên Khách Hàng</th>
			<th>Tỉnh</th>
			<th>Ngày đặt hàng</th>
		</tr></thead>
		<tbody>
		{foreach item=order from=$myOrders name=orderlist}
			<tr>
				<td>{$smarty.foreach.orderlist.iteration}</td>
				<td>{$order->billingfullname}</td>
				<td>{$setting.region[$order->billingregionid]}</td>
				<td>{$order->datecreated|date_format:"%d/%m/%Y %H:%m:%S"}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{else}
<p align="center">Không có sản phẩm nào để tư vấn cho sản phẩm hiện tại của bạn.</p>
{/if}
</div>