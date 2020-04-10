<style type="text/css">
    .wrap-advice {
        position: relative;
        padding: 0;
        margin: 0;
        overflow: inherit;
        border-radius: 0;
        box-shadow:none;
    }
    .wrap-advice p{
        background: #00a1e6;
        color: #fff;
        padding: 10px 10px 10px 40px;
        font-size: 15px;
        font-family: arial;
        text-transform: uppercase;
        display: block;
width: 752px;
    }
    .icon-advice{
    	background-position: -330px -30px;
		position: absolute;
		left: 5px;
		top: 5px;
    }
    table{
    	padding: 10px;
    }
    .table tbody > tr > td{
		padding: 8px;
		line-height: 1.428571429;
		vertical-align: top;
		border-top: 1px solid #dddddd;
	}
	table> tbody > tr:nth-child(odd) > td, .table > tbody > tr:nth-child(odd) > th {
		background-color: #f9f9f9;
	}
	.table thead > tr > th {
		vertical-align: bottom;
	}
</style>
<div class="wrap-advice">
<p><i class="icon-advice"></i>Danh sách khách hàng đặt hàng trước "{$myProduct->name}"</p>
{if !empty($myOrders)}
	<table class="table">
		<thead><tr>
			<th>STT</th>
			<th>Mã đơn hàng</th>
			<th>Tên Khách Hàng</th>
			<th>Tỉnh</th>
			<th>Ngày đặt hàng</th>
		</tr></thead>
		<tbody>
		{foreach item=order from=$myOrders name=orderlist}
			<tr>
				<td>{$smarty.foreach.orderlist.iteration}</td>
				<td style="text-transform: uppercase;">{$order->invoiceid}</td>
				<td>{$order->billingfullname}</td>
				<td>{$setting.region[$order->billingregionid]}</td>
				<td>{$order->datecreated|date_format:"%d/%m/%Y %T"}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{else}
<p align="center">Không có sản phẩm nào để tư vấn cho sản phẩm hiện tại của bạn.</p>
{/if}
</div>