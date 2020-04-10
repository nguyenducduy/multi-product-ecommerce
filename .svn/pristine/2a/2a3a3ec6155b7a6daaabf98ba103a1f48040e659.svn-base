{include file="_controller/stat/report/headerstat.tpl"}

<div style="width: auto;margin: 0px auto;">
    <form action="" method="get">
    	{if !empty($fpriceseg)}
    	<input type="hidden" value="{$fpriceseg}" name="fpriceseg" />
    	{/if}
    	{if !empty($fvid)}
    	<input type="hidden" value="{$fvid}" name="fvid" />
    	{/if}
    	{if !empty($id)}
    	<input type="hidden" value="{$id}" name="id" />
    	{/if}
    	{if !empty($fsubpcid)}
    		{foreach from=$fsubpcid item=subcat}
    		<input type="hidden" value="{$subcat}" name="fsubpcid[]" />
    		{/foreach}
    	{/if}
    <table class="table">
    		<tr><td style="border: none;" width="20%">Filter by Date: </td>
    			<td style="border: none;">From: <input type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$startdate}"> to <input type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$enddate}"></td>
    		</tr>
    		<tr><td style="border: none;">Filter by Store: </td>
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
    		</tr>
    		{*if !empty($listsubcategories)}
    		<tr><td style="border: none;">Filter by Subcategory: </td>
    			<td style="border: none;">

    					<select name="fsubpcid[]" class="input-xxlarge" multiple="multiple">
    						<option value="0"{if empty($fsubpcid)} selected="selected"{/if}>All</option>
    					{foreach from=$listsubcategories item=subcat}
    						<option value="{$subcat->id}"{if !empty($fsubpcid) && in_array($subcat->id, $fsubpcid)} selected="selected"{/if}>{$subcat->name}</option>
    					{/foreach}
    					</select>

    			</td>
    		</tr>
    		{/if}
    		{if !empty($listvendors)}
    		<tr><td style="border: none;">Filter by Brand: </td>
    			<td style="border: none;">

    					<select name="fvid[]" class="input-xxlarge" multiple="multiple">
    						<option value="0"{if empty($fvid)} selected="selected"{/if}>All</option>
    					{foreach from=$listvendors item=vendor}
    						<option value="{$vendor->id}"{if !empty($fvid) && in_array($vendor->id, $fvid)} selected="selected"{/if}>{$vendor->name}</option>
    					{/foreach}
    					</select>

    			</td>
    		</tr>
    		{/if*}
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
    			<div style="float:right;margin-right:30px;">
                            <a class="btn btn-primary" href="{$conf.rooturl}stat/report/productcategory?id={$id}&by=volume&startdate={$startdate}&enddate={$enddate}&fsid={$storeid}">Số lượng bán</a>&nbsp;
                            <a class="btn btn-primary" href="{$conf.rooturl}stat/report/productcategory?id={$id}&by=revenue&startdate={$startdate}&enddate={$enddate}&fsid={$storeid}">Doanh số</a>&nbsp;
                            <a class="btn btn-primary" href="{$conf.rooturl}stat/report/productcategory?id={$id}&by=laigop&startdate={$startdate}&enddate={$enddate}&fsid={$storeid}">Lãi gộp</a>&nbsp;
                        </div><br/><br/>
                        <!--start chart-->
                        <div id="chart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                        <!--end of chart-->
                        {if $chartData|@count > 0}
                            <div id="chartdata" data-charttype="{$chartType}" style="display:none;" charttitle="{$chartTitle}">
                                <span id="xaxis" data-format="">Date</span>
                                <span id="yaxis" data-format=",d">Number</span>
                                {foreach name=chartdatalist item=data key=chartname from=$chartData}
                                <div class="chartdatadetail" title="{$chartname}" id="chartdatadetail{$smarty.foreach.chartdatalist.iteration}">
                                    {foreach item=value key=key from=$data}
                                        <span title="{$key}">{$value}</span>
                                    {/foreach}
                                </div>
                                {/foreach}
                            </div>
                        {/if}
    		</td>
    	</tr>
    </table><br />
    <div id="linksheet">
    	<a href="{$conf.rooturl}stat/report/productcategory/{$paramurl}" class="btn btn-primary">Top 20 sản phẩm</a>
    	<a href="{$conf.rooturl}stat/report/company/catebase{$paramurl}" class="btn">Category - MC - SKU</a>
    	<a href="{$conf.rooturl}stat/report/productcategory/catestore/{$paramurl}" class="btn btn-primary">Siêu thị</a>
    	<!--<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View by </span>
    	<a href="{$conf.rooturl}stat/report/company/catebase/{if empty($paramurl)}?sort=2{else}{$paramurl}&sort=2{/if}" class="{if $sortby == 2}btn{else}btn btn-primary{/if}">Volume</a>
    	<a href="{$conf.rooturl}stat/report/company/catebase/{if empty($paramurl)}?sort=1{else}{$paramurl}&sort=1{/if}" class="{if $sortby == 1}btn{else}btn btn-primary{/if}">Revenue</a>
    	<a href="{$conf.rooturl}stat/report/company/catebase/{if empty($paramurl)}?sort=3{else}{$paramurl}&sort=3{/if}" class="{if $sortby == 3}btn{else}btn btn-primary{/if}">Profit</a>-->
    </div>
    	<table class="table table-striped">
    		<thead>
    		<tr style="background-color:#8db4e3">
    			<th>STT</th>
    			<th>Cate name</th>
    			<th>Cate Role</th>
    			<th>Số lượng bán</th>
    			<th>Doanh thu</th>
    			<th>Giá bán trung bình</th>
    			<th>Giá vốn trung bình</th>
    			<th>Lãi gộp</th>
    			<th>Margin</th>
    			<th>Giá trị tồn kho</th>
    			<th>Ngày bán hàng</th>
    			<th>Trả lại</th>
    		</tr>
    		</thead>
    		<tbody>
    		{foreach from=$parentcategorylist item=product name=productlists}
    			<tr>
    				<td>{$smarty.foreach.productlists.iteration}</td>
    				<td><a href="{$conf.rooturl}stat/report/productcategory/?id={$product.cateid}">{$product.catename}</a></td>
    				<td>{$product.cateroles}</td>
    				<td>{$product.quantit|number_formaty}</td>
    				<td>{$product.revenue|number_format}</td>
    				<td>{$product.sellpriceavg|number_format}</td>
    				<td>{$product.costpriceavg|number_format}</td>
    				<td>{$product.profit|number_format}</td>
    				<td>{$product.margin|string_format: "%.2f"}</td>
    				<td>{$product.instockvalue}</td>
    				<td>{$product.datesell|number_format}</td>
    				<td>{$product.refund|number_format}</td>
    			</tr>
    		{/foreach}
    		</tbody>
    	</table>
</div>
<script type="text/javascript" src="{$currentTemplate}js/stat/report/forecastcategory.js"></script>
{include file="_controller/admin/footer.tpl"}