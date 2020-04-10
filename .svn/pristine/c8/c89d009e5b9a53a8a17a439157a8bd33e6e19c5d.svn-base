<div id="dataTable">
<table class="table table-bordered tablesorter" id="data">
	<thead>
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
            <td class="colhead">P</td>
            <td class="colhead">Q</td>
            <td class="colhead">R</td>
            <td class="colhead">S</td>
            <td class="colhead">T</td>                    
        </tr>        
        <tr style="background-color:#f3f3f3">
        	<td rowspan="3">1</td>
        	<th style="vertical-align: middle;width:100px" class="header" rowspan="2">Tên sản phẩm</th>
        	<th style="vertical-align: middle;width:150px" class="header" rowspan="2">Siêu thị</th>
        	<th style="vertical-align: middle;" class="header" rowspan="2">Đầu kỳ</th>
        	<td class="colhead" colspan="4">Nhập kho</td>
        	<td class="colhead" colspan="4">Xuất kho</td>
        	<th style="vertical-align: middle;width:68px;" class="header" rowspan="2">Cuối kỳ</th>
        	<td class="colhead" colspan="8">Phân tích - thị trường</td>
        </tr>
        <tr style="background-color:#f3f3f3">
        	<th style="vertical-align: middle;" class="header">Mua</th>
            <th style="vertical-align: middle;width:60px;" class="header">Nội bộ</th>
            <th style="vertical-align: middle;width:40px;" class="header">Trả</th>
            <th style="vertical-align: middle;" class="header">Khác</th>

            <th style="vertical-align: middle;" class="header">Mua</th>
            <th style="vertical-align: middle;width:60px;" class="header">Nội bộ</th>
            <th style="vertical-align: middle;width:40px;" class="header">Trả</th>
            <th style="vertical-align: middle;" class="header">Khác</th>

            <td style="width:50px;" class="colhead">Sức bán</td>
            <td style="width:50px;" class="colhead">Tốc độ bán</td>
            <td style="width:50px;" class="colhead">Vai trò</td>
            <td style="width:50px;" class="colhead">Phân loại</td>
            <td style="width:50px;" class="colhead">Nhập khẩu</td>
            <td style="width:50px;" class="colhead">GFK</td>
            <td style="width:50px;" class="colhead">Tồn bán hàng</td>
            <td style="width:50px;" class="colhead">Tồn thực tế</td>
        </tr>
	</thead>
	<tbody>
		{assign var="index" value="0"}
		{foreach from=$listsubcategories item=products name=productlists}
			{assign var="store" value="1"}
			{foreach from=$products item=product name=foo}
			{assign var="index" value=$index+2}
			<tr>
				<td>{$index}</td>
				{if $store == 1}
				<td rowspan="{$products|@count}"><a target="_blank" href="{$conf.rooturl}stat/report/productdetail?id={$product.id}" title="{$product.ten}">{$product.ten}</a></td>
				{assign var="store" value="0"}						
				{/if}
				<td>{$product.sieuthi}</td>				
				<td class="numberdata">{$product.dauky}</td>				
				<td class="numberdata">{$product.nhapmua}</td>				
				<td class="numberdata">{$product.nhapnoibo}</td>				
				<td class="numberdata">{$product.nhaptralai}</td>				
				<td class="numberdata">{$product.nhapkhac}</td>				
				<td class="numberdata">{$product.xuatban}</td>				
				<td class="numberdata">{$product.xuatnoibo}</td>				
				<td class="numberdata">{$product.xuattramuahang}</td>				
				<td class="numberdata">{$product.xuatkhac}</td>				
				<td class="numberdata">{$product.cuoiky}</td>				
				<td class="numberdata">{$product.sucban}</td>				
				<td class="numberdata">{$product.tocdoban}</td>				
				<td>{$product.vaitro} &nbsp;</td>				
				<td>{$product.phanloai} &nbsp;</td>				
				<td>{$product.nhapkhau} &nbsp;</td>				
				<td>{$product.GFK} &nbsp;</td>				
				<td>{$product.tonbanhang} &nbsp;</td>				
				<td>{$product.tonthucte} &nbsp;</td>				
			</tr>
			{/foreach}
		{/foreach}
	</tbody>
</table>
</div>