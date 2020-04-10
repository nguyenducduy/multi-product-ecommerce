<table class="table table-bordered tablesorter" id="data">
	<thead id="header">
		<tr>
			<td class="colhead"></td>
            <td class="colhead">A</td>
            <td class="colhead">B</td>
            <td class="colhead">C</td>
            <td class="colhead">D</td>
            <td class="colhead">E</td>
            <td class="colhead">F</td>
            <td class="colhead">G</td>
            <td class="colhead">H</td>
            <td class="colhead">I</td>
            <td class="colhead">J</td>
            <td class="colhead">K</td>
            <td class="colhead">L</td>
            <td class="colhead">M</td>
            <td class="colhead">N</td>
            <td class="colhead">O</td>
        </tr>
		<tr style="background-color:#f3f3f3">
			<td style="width:5px" rowspan="2">1</td>
			<th style="width:245px;vertical-align: middle;" rowspan="2">Siêu thị</td>
			<td class="colhead" style="vertical-align: middle;" rowspan="2">Đầu kỳ<br />{$startdate}</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="4">Nhập kho</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="4">Xuất kho</td>
			<td class="colhead" style="vertical-align: middle;" class="header" rowspan="2">Cuối kỳ<br />{$enddate}</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="4">Phân tích</td>
		</tr>
		<tr style="background-color:#f3f3f3">			
			<th style="vertical-align: middle;" class="header">Mua</th>
            <th style="vertical-align: middle;" class="header">Nội bộ</th>
            <th style="vertical-align: middle;" class="header">Trả</th>
            <th style="vertical-align: middle;" class="header">Khác</th>

            <th style="vertical-align: middle;" class="header">Bán</th>
            <th style="vertical-align: middle;" class="header">Nội bộ</th>
            <th style="vertical-align: middle;" class="header">Trả</th>
            <th style="vertical-align: middle;" class="header">Khác</th>

            <th style="width:85px;vertical-align: middle;" class="header">Chờ nhập</th>
            <th style="width:75px;vertical-align: middle;" class="header">Sức bán</th>
            <th style="width:90px;vertical-align: middle;" class="header">Tốc độ bán</th>
            <th style="width:50px;" class="header">Ngày bán hàng</th>
		</tr>
	</thead>
	<tbody>
		{foreach item=storeitem from=$storedatalist name=foo}
		<tr>
			<td style="width:5px">{$smarty.foreach.foo.index+2}</td>
			<td style="width:245px;">{$storeitem.ten}</td>
			<td class="numberdata">{$storeitem.tonkhodauky}</td>
			<td class="numberdata">{$storeitem.nhapmua}</td>
			<td class="numberdata">{$storeitem.nhapnoibo}</td>
			<td class="numberdata">{$storeitem.nhaptralai}</td>
			<td class="numberdata">{$storeitem.nhapkhac}</td>
			<td class="numberdata">{$storeitem.xuatban}</td>
			<td class="numberdata">{$storeitem.xuatnoibo}</td>
			<td class="numberdata">{$storeitem.xuattramuahang}</td>
			<td class="numberdata">{$storeitem.xuatkhac}</td>
			<td class="numberdata">{$storeitem.cuoiky}</td>
			<td class="numberdata" style="width:85px;">{$storeitem.chonhapkho}</td>
			<td class="numberdata" style="width:75px;">{$storeitem.sucban}</td>
			<td class="numberdata" style="width:90px;">{$storeitem.tocdoban}</td>
			<td class="numberdata" style="width:50px;">{$storeitem.ngaybanhang}</td>
		</tr>
		{/foreach}
	</tbody>
</table>
{literal}
<style type="text/css">
	.header{				
		text-align: center !important;
	}
</style>
{/literal}