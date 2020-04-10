{include file="_controller/stat/report/headerstat.tpl"}

<div style="width: auto;margin: 0px auto;">
	{if (!empty($report_timeupdatereport))}
	<p><em>{$report_timeupdatereport}</em></p>
	{/if}
    <form action="" method="get">
    	{if !empty($id)}
    	<input type="hidden" value="{$id}" name="id" />
    	{/if}
    <table class="table">
    		<tr><td style="border: none;" width="20%">Filter by Date: </td>
    			<td style="border: none;">From: <input type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$startdate}"> to <input type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$enddate}"></td>
    		</tr>
    		<!--<tr><td style="border: none;">Filter by Store: </td>
    			<td style="border: none;">
    				{if !empty($liststores)}
    					<select name="fsid" id="fsid" class="input-xxlarge">
    						<option value="0"{if $storeid == 0} selected="selected"{/if}>All</option>
    					{foreach from=$liststores item=store}
    						<option value="{$store->id}"{if $storeid == $store->id} selected="selected"{/if}>{$store->name}</option>
    					{/foreach}
    					</select>
    				{/if}
    			</td>
    		</tr>-->
    </table>
    <p align="center"><input type="submit" class="btn" name="view" value="XEM" /></p><br />
    </form>
    
    <table width="100%">
    	<tr>
    		<td width="30%">
    			<table class="table table-bordered">
    				<tr>
    					<td width="50%">Doanh thu: </td><td>{$sdoanhthu|number_format}</td>
    				</tr><tr>
    					<td>Lãi gộp: </td><td>{$slaigop|number_format}</td>
    				</tr><tr>
    					<td>Margin: </td><td>{$smargin|string_format: "%.2f"}</td>
    				</tr><tr>
    					<td>Giá trị tồn kho: </td><td>{$sgiatritonkho}</td>
    				</tr><tr>
    					<td>Tổng traffic: </td><td>{$stongtraffic}</td>
    				</tr><tr>
    					<td>SL đơn hàng: </td><td>{$ssoluongdonhang|number_format}</td>
    				</tr><tr>
    					<td>Conversion rate: </td><td>{$sonversionrate}</td>
    				</tr><tr>
    					<td>Giá trị TB đơn hàng: </td><td>{$sgiatritbdh}</td>
    				</tr>
    			</table>
    		</td>
    		<td>
    			<div id="chartgrid">CHART</div>
    		</td>
    	</tr>
    </table><br />
    <div id="linksheet">
    	<a href="{$conf.rooturl}stat/report/productcategory/{$paramurl}" class="btn btn-primary">Top 20 sản phẩm</a>
    	<a href="{$conf.rooturl}stat/report/company/catebase/{$paramurl}" class="btn btn-primary">Category - MC - SKU</a>
    	<a href="javascript:void(0)" class="btn">Siêu thị</a>
    	<!--<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View by </span>
    	<a href="{$currurl}&sort=2" class="{if $sortby == 2}btn{else}btn btn-primary{/if}">Subcate</a>
    	<a href="{$currurl}&sort=1" class="{if $sortby == 1}btn{else}btn btn-primary{/if}">Brandname</a>
    	<a href="{$currurl}&sort=3" class="{if $sortby == 3}btn{else}btn btn-primary{/if}">Main character 1</a>-->
    </div>
    	<table class="table table-striped">
    		<thead>
    		<tr style="background-color:#8db4e3">
    			<th>STT</th>
    			<th>Siêu thị</th>
    			<th>Số lượt khách</th>
    			<th>SL đơn hàng</th>
    			<th>Conversion Rate</th>
    			<th>Giá trị TB đơn hàng</th>
    			<th>Doanh thu</th>
    			<th>Lãi gộp</th>
    			<th>Lãi/đơn hàng</th>
    			<th>Margin</th>
    			<th>Giá trị tồn kho</th>
    			<th>Ngày bán hàng</th>
    			<th>Trả lại</th>
    			<th>TG hàng trả</th>
    		</tr>
    		</thead>
    		<tbody>
    		{foreach from=$listcategorystores item=product name=productlists}
    			<tr>
    				<td>{$smarty.foreach.productlists.iteration}</td>
    				<td><a href="{$conf.rooturl}stat/report/company/?fsid={$product.storeid}">{$product.storename}</a></td>
    				<td>{$product.soluotkhach}</td>
    				<td>{$product.soluongdonhang|number_format}</td>
    				<td>{$product.conversionrate}</td>
    				<td>{$product.giatritbdonhang}</td>
    				<td>{$product.doanhthu|number_format}</td>
    				<td>{$product.laigop|number_format}</td>
    				<td>{$product.laidonhang}</td>
    				<td>{$product.margin}</td>
    				<td>{$product.giatritonkho}</td>
    				<td>{$product.ngaybanhang}</td>
    				<td>{$product.tralai}</td>
    				<td>{$product.doanhthutralai|number_format}</td>
    			</tr>
    		{/foreach}
    		</tbody>
    	</table>
</div>
<script type="text/javascript" src="http://dienmay.myhost/templates/default/js/stat/forecastproductcategory.js"></script>
<script type="text/javascript" src="http://dienmay.myhost/templates/default/js/stat/forecastcategory.js"></script>
{include file="_controller/admin/footer.tpl"}