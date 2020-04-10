<div id="dataTable">
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
            <td class="colhead">X</td>                        
            <td class="colhead">Y</td>                        
            <td class="colhead">Z</td>                        
            <td class="colhead">AA</td>                        
            <td class="colhead">AB</td>                        
        </tr>
		<tr style="background-color:#f3f3f3">
			<td style="width:5px" rowspan="3">1</td>
			<th style="width:245px;vertical-align: middle;" class="header" rowspan="3">Tên sản phẩm</th>
			<th style="width:245px;vertical-align: middle;" class="header" rowspan="3">Siêu thị</th>			
			<td class="colhead" style="vertical-align: middle;"  colspan="3">Đầu kỳ</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="8">Nhập kho</td>
			<td class="colhead" style="vertical-align: middle;text-align: center;" colspan="8">Xuất kho</td>
			<td class="colhead" style="vertical-align: middle;" colspan="3">Cuối kỳ</td>
			<td class="colhead" style="vertical-align: middle;" colspan="4">Phân tích-thị trường</td>			
		</tr>
		<tr style="background-color:#f3f3f3">
			<th style="vertical-align: middle;" class="header" rowspan="2">SL</th>
            <th style="vertical-align: middle;" class="header" rowspan="2">TG</th>
            <th style="vertical-align: middle;" class="header" rowspan="2">Giá vốn</th>            


			<td class="colhead" style="vertical-align: middle;" colspan="2">Mua</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Nội bộ</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Trả</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Khác</td>

            <td class="colhead" style="vertical-align: middle;" colspan="2">Mua</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Nội bộ</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Trả</td>
            <td class="colhead" style="vertical-align: middle;" colspan="2">Khác</td>

            <th style="vertical-align: middle;" class="header" rowspan="2" >SL</th>
            <th style="vertical-align: middle;" class="header" rowspan="2" >TG</th>
            <th style="vertical-align: middle;" class="header" rowspan="2">Giá vốn</th>
           
           <th style="vertical-align: middle;" class="header" rowspan="2" >Sức bán</th>
           <th style="vertical-align: middle;" class="header" rowspan="2" >Tốc độ bán</th>
           <td style="vertical-align: middle;" class="colhead" rowspan="2">Vai trò</td> 
           <td style="vertical-align: middle;" class="colhead" rowspan="2">Phân loại</td>          
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
				<td class="numberdata">{$product.trigiadauky|number_format}</td>	
				<td class="numberdata">{$product.giavondauky|number_format}</td>		
				<td class="numberdata">{$product.nhapmua}</td>
				<td class="numberdata">{$product.trigianhapmua|number_format}</td>				
				<td class="numberdata">{$product.nhapnoibo}</td>				
				<td class="numberdata">{$product.trigianhapnoibo|number_format}</td>
				<td class="numberdata">{$product.nhaptralai}</td>				
				<td class="numberdata">{$product.trigianhaptralai|number_format}</td>
				<td class="numberdata">{$product.nhapkhac}</td>
				<td class="numberdata">{$product.trigianhapkhac|number_format}</td>				
				<td class="numberdata">{$product.xuatban}</td>	
				<td class="numberdata">{$product.trigiaxuatban|number_format}</td>			
				<td class="numberdata">{$product.xuatnoibo}</td>				
				<td class="numberdata">{$product.trigiaxuatnoibo|number_format}</td>
				<td class="numberdata">{$product.xuattramuahang}</td>
				<td class="numberdata">{$product.trigiaxuattra|number_format}</td>				
				<td class="numberdata">{$product.xuatkhac}</td>
				<td class="numberdata">{$product.trigiaxuatkhac|number_format}</td>				
				<td class="numberdata">{$product.cuoiky}</td>
				<td class="numberdata">{$product.trigiacuoiky|number_format}</td>				
				<td class="numberdata">{$product.giavoncuoiky|number_format}</td>
				<td class="numberdata">{$product.sucban}</td>				
				<td class="numberdata">{$product.tocdoban}</td>				
				<td>{$product.vaitro}</td>				
				<td>{$product.phanloai}</td>										
			</tr>
			{/foreach}
		{/foreach}
</table>
</div>
{literal}
<style type="text/css">
	.header{				
		text-align: center !important;
	}
</style>
{/literal}