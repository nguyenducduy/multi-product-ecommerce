{include file="_controller/stat/report/headerstat.tpl"}
<div class="breadcrum">
    <span>dienmay.com Root view</span>
</div>
{if (!empty($report_timeupdatereport))}
<p><em>{$report_timeupdatereport}</em></p>
{/if}
<form action="" method="get">
    <input type="hidden" id="by" value="{$chartby}" />
    <table style="width:100%">
        <tr>
        	<td width="30%">
        		<table width="100%" style="background-color:#c2d693;">
                    <tr>
                        <td colspan="2" style="height:10px;"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Ngày :</td>
                        <td style="padding-left:5px;padding-right:20px;"><input style="width:65px;" type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$startdate}">&nbsp;-&nbsp;<input style="width:65px;" type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$enddate}"></td>                           
                    </tr>
                    <tr>
                        <td style="text-align:right;">Dữ liệu biểu đồ :</td>
                        <td style="padding-left:5px;">
                            <select name="chartby" id="chartby">
                                <option {if $chartby == "volume"}selected="selected"{/if} value="volume">Số lượng bán</option>
                                <option {if $chartby == "revenue"}selected="selected"{/if} value="revenue">Doanh thu</option>
                                <option {if $chartby == "profit"}selected="selected"{/if} value="profit">Lãi gộp</option>
                            </select>
                        </td>
                    </tr>                       
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>                            
                        <td colspan="2" style="text-align:center;">
                            <input type="submit" class="btn btn-primary" name="view" value="XEM" />                                
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="2" style="height:10px;"></td>
                    </tr>                       
                </table>
                <br />
                 <table class="table table-bordered" style="background-color:#d7e4bc;">
                    <tr>
                        <td width="50%">Doanh thu: </td><td><b>{$sdoanhthu|number_format}</b></td>
                    </tr><tr>
                        <td>Lãi gộp chưa trừ KM: </td><td><b>{$slaigop|number_format}</b></td>
                    </tr><tr>
                        <td>Margin: </td><td><b>{$smargin}{*|string_format: "%.2f"|number_format*}%</b></td>
                    </tr><tr>
                        <td>Giá trị tồn kho: </td><td><b>{$sgiatritonkho|number_format}</b></td>
                    </tr><tr>
                        <td>Tổng traffic: </td><td><b>{$stongtraffic|number_format}</b></td>
                    </tr><tr>
                        <td>SL đơn hàng: </td><td><b>{$ssoluongdonhang|number_format}</b></td>
                    </tr><tr>
                        <td>Conversion rate: </td><td><b>{$sconversionrate}%</b></td>
                    </tr><tr>
                        <td>Giá trị TB đơn hàng: </td><td><b>{$sgiatritrungbinhdonhang|number_format}</b></td>
                    </tr>
                </table>
        	</td>
        	<td>
        		<table style="width:100%">
                   <tr>
                       <td>
                           <!--start chart-->
                            <div id="piechart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                            <!--end of chart-->
                            {if $pieChartData|@count > 0}
                                <div id="chartdata1" data-charttype="{$pieChartType}" style="display:none;" charttitle="{$chartTitle}">
                                    <span id="xaxis" data-format="">Date</span>
                                    <span id="yaxis" data-format=",d">Number</span>
                                    {foreach name=chartdatalist item=data key=chartname from=$pieChartData}
                                    <div class="chartdatadetail1" title="{$chartname}" id="chartdatadetail{$smarty.foreach.chartdatalist.iteration}">
                                        {foreach item=value key=key from=$data}
                                            <span title="{$key}">{$value}</span>
                                        {/foreach}
                                    </div>
                                    {/foreach}
                                </div>
                            {/if}
                       </td>
                   </tr>
               </table>
        		
        	</td>
    	</tr>
    	<tr><td colspan="2" height="20">&nbsp;</td></tr>
    	<tr><td colspan="2">
    		<table style="width:100%">
               <tr>
                   <td>
                       <!--start chart-->
                        <div id="linechart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                        <!--end of chart-->
                        {if $lineChartData|@count > 0}
                            <div id="chartdata" data-charttype="{$lineChartType}" style="display:none;" charttitle="{$chartTitle}">
                                <span id="xaxis" data-format="">Date</span>
                                <span id="yaxis" data-format=",d">Number</span>
                                {foreach name=chartdatalist item=data key=chartname from=$lineChartData}
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
           </table>
    	</td></tr>
    </table>
    <div style="clear: both; margin-top: 20px;">
        <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/company{$paramurl}" class="btn">Top 20 sản phẩm</a>                                            
        <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/company/catebase{$paramurl}" class="btn">Category - MC - SKU</a>
        <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/company/catestore{$paramurl}" class="btn btn-primary">Siêu thị</a>
    </div>
    <div id="dataTable">
        <table class="table table-bordered tablesorter" id="data">
            <thead>
                <tr>
                    <td style="width:10px;" class="colhead"></td>
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
                </tr>
                <tr style="background-color:#8db4e3">
                    <th>1</th>
                    <th>Siêu thị</th>
                    <th>Số lượt khách</th>                    
                    <th>Số lượng đơn hàng</th>
                    <th>Conversion Rate</th>
                    <th>Giá trị TB đơn hàng</th>
                    <th>Doanh thu</th>                    
                    <th>Lãi gộp</th>
                    <th>Lãi / đơn hàng</th>
                    <th>Margin</th>
                    <th>Giá trị tồn kho</th>
                    <th>Ngày bán hàng</th>
                    <th>Trả lại</th>
                    <th>TG hàng trả</th>
                </tr>
            </thead>
            <tbody>
            {$sumsoluongdonhang = 0}
            {$sumtopitemtralai = 0}
            {$sumtopitemtghangtra = 0}
            {foreach from=$storeitemlist item=product name=productlists}
                <tr>
                    <td>{$smarty.foreach.productlists.index+2}</td>
                    <td><a href="{$conf.rooturl}stat/report/company/{if !empty($subparamurl)}{$subparamurl}&{else}?{/if}fsid={$product.storeid}">{$product.tenkho}</a></td>
                    <td class="numberdata">{$product.soluotkhach}</td>
                    <td class="numberdata">{$product.soluongdonhang|number_format}</td>
                    <td class="numberdata">{$product.conversionrate|string_format: "%.2f"}%</td>
                    <td class="numberdata">{$product.giatritrungbinhdonhang|number_format}</td>
                    <td class="numberdata">{$product.doanhthu|number_format}</td>
                    <td class="numberdata">{$product.laigop|number_format}</td>
                    <td class="numberdata">{$product.laidonhang|number_format}</td>
                    <td class="numberdata">{$product.margin|string_format: "%.2f"}%</td>
                    <td class="numberdata">{$product.trigiatonkho|number_format}</td>
                    <td class="numberdata">{$product.ngaybanhang}</td>
                    <td class="numberdata">{$product.tralai}</td>
                    <td class="numberdata">{$product.doanhthutralai|number_format}</td>
                </tr>
                {math assign="sumsoluongdonhang"  equation="x + y" x=$sumsoluongdonhang y=$product.soluongdonhang}
                {math assign="sumtopitemtralai"  equation="x + y" x=$sumtopitemtralai y=$product.tralai}
	            {math assign="sumtopitemtghangtra"  equation="x + y" x=$sumtopitemtghangtra y=$product.doanhthutralai}
            {/foreach}
            </tbody>
            <tfoot>
            	<th colspan="2" align="right">Tổng cộng: </th>
            	<th class="numberdata">{$stongtraffic|number_format}</th>
            	<th class="numberdata">{$sumsoluongdonhang|number_format}</th>
            	<th class="numberdata">{$sconversionrate|number_format}%</th>
            	<th class="numberdata">&nbsp;</th>
            	<th class="numberdata">{$sdoanhthu|number_format}</th>
            	<th class="numberdata">{$slaigop|number_format}</th>
            	<th class="numberdata">&nbsp;</th>
            	<th class="numberdata">{$smargin|number_format}%</th>
                <th class="numberdata">{$sgiatritonkho|number_format}</th>
                <th class="numberdata">{if $sdoanhthu > 0} {math|number_format equation="x*y/z" x=$sgiatritonkho y=$songay z=$sdoanhthu format="%.2f"}{else}0{/if}</th>
                <th class="numberdata">{$sumtopitemtralai|number_format}</th>
                <th class="numberdata">{$sumtopitemtghangtra|number_format}</th>
            </tfoot>
        </table>
    </div>
</form>
{literal}
<script type="text/javascript">
    var step = {/literal}{$stepdate}{literal};  
</script>
{/literal}
<script type="text/javascript" src="http://dienmay.myhost/templates/default/js/stat/report/companystores.js"></script>
{include file="_controller/admin/footer.tpl"}