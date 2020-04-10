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
            <td class="colhead">P</td>
            <td class="colhead">Q</td>
            <td class="colhead">R</td>
            <td class="colhead">S</td>
            <td class="colhead">T</td>
            <td class="colhead">U</td>
            <td class="colhead">V</td>            
            <td class="colhead">W</td>            
        </tr>
		<tr style="background-color:#f3f3f3">
			<td style="width:5px" rowspan="3">1</td>
			<th style="width:245px;vertical-align: middle;" class="header" rowspan="3">Siêu thị</th>
			<td class="colhead" style="vertical-align: middle;"  colspan="3">Đầu kỳ<br />{$startdate}</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="8">Nhập kho</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="8">Xuất kho</td>
			<td class="colhead" style="vertical-align: middle;" colspan="3">Cuối kỳ<br />{$enddate}</td>			
		</tr>
		<tr style="background-color:#f3f3f3">
			<th style="vertical-align: middle;" class="header" rowspan="2">SL</th>
            <th style="vertical-align: middle;" class="header" rowspan="2">TG</th>
            <th style="vertical-align: middle;" class="header" rowspan="2">Giá vốn</th>            


			<td class="colhead" style="vertical-align: middle;" colspan="2">Mua</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Nội bộ</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Trả</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Khác</td>

            <td class="colhead" style="vertical-align: middle;" colspan="2">Bán</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Nội bộ</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Trả</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Khác</td>

            <th style="vertical-align: middle;" class="header" rowspan="2" >SL</th>
            <th style="vertical-align: middle;" class="header" rowspan="2" >TG</th>
            <th style="vertical-align: middle;" class="header" rowspan="2">Giá vốn</th>
                      
		</tr>
		<tr style="background-color:#f3f3f3">			

            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>            

            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>

            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>
            
            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>
          

            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>            

            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>

            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>
            
            <th style="vertical-align: middle;" class="header">SL</th>
            <th style="vertical-align: middle;" class="header">TG</th>         
		</tr>
	</thead>
	<tbody>
		{foreach item=storeitem from=$storedatalist name=foo}
		<tr>
			<td style="width:5px;">{$smarty.foreach.foo.index+2}</td>
			<td style="width:245px;">{$storeitem.ten}</td>
			<td class="numberdata">{$storeitem.tonkhodauky}</td>
			<td class="numberdata">{$storeitem.trigiadauky|number_format}</td>
			<td class="numberdata">{$storeitem.giavondauky}</td>
			<td class="numberdata">{$storeitem.nhapmua}</td>
			<td class="numberdata">{$storeitem.trigianhapmua|number_format}</td>
			<td class="numberdata">{$storeitem.nhapnoibo}</td>
			<td class="numberdata">{$storeitem.trigianhapnoibo|number_format}</td>
			<td class="numberdata">{$storeitem.nhaptralai}</td>
			<td class="numberdata">{$storeitem.trigianhaptra|number_format}</td>
			<td class="numberdata">{$storeitem.nhapkhac}</td>		
			<td class="numberdata">{$storeitem.trigianhapkhac|number_format}</td>		
			<td class="numberdata">{$storeitem.xuatban}</td>
			<td class="numberdata">{$storeitem.trigiaxuatban|number_format}</td>
			<td class="numberdata">{$storeitem.xuatnoibo}</td>
			<td class="numberdata">{$storeitem.trigiaxuatnoibo|number_format}</td>
			<td class="numberdata">{$storeitem.xuattramuahang}</td>
			<td class="numberdata">{$storeitem.trigiaxuattra|number_format}</td>
			<td class="numberdata">{$storeitem.xuatkhac}</td>
			<td class="numberdata">{$storeitem.trigiaxuatkhac|number_format}</td>
			<td class="numberdata">{$storeitem.cuoiky}</td>
			<td class="numberdata">{$storeitem.trigiacuoiky|number_format}</td>					
			<td class="numberdata">{$storeitem.giavoncuoiky|number_format}</td>
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