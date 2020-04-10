{include file="_controller/stat/report/headerstat.tpl"}
<div class="breadcrum">
    <span><a href="{$conf.rooturl}stat/report/company{if !empty($urlparam)}?{$urlparam}{/if}">Root</a></span> &raquo;
    {foreach item=productcategory from=$fullproductcategory name=foo key=categoryid}
    {if !$smarty.foreach.foo.last}
    <span><a title="{$productcategory.name}" href="{$conf.rooturl}stat/report/productcategory?id={$categoryid}{if !empty($urlparam)}&{$urlparam}{/if}">{$productcategory.name}</a></span> &raquo;
    {else}
    <span>{$productcategory.name}</span>
    {/if}
    {/foreach}    
</div>
<br/>
{if (!empty($report_timeupdatereport))}
<p><em>{$report_timeupdatereport}</em></p>
{/if}
<form action="" method="get" id="myform">
    <input type="hidden" id="by" value="{$chartby}" />
    <input type="hidden" name="id" value="{$productcategoryinfo->id}" /> 
    <input type="hidden" name="form" value="getform" />   
    <table style="width:100%">
    	<tr>
    		<td width="30%" valign="top">
    			<table width="100%" style="background-color:#c2d693;">
                        <tr>
                            <td colspan="2" style="height:10px;"></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;">Ngày :</td>
                            <td style="padding-left:5px;padding-right:20px;"><!-- <input style="width:65px;" type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$startdate}"> --><input style="width:65px;" type="text" id="startdate" value="{$startdate}" readonly="readonly">&nbsp;-&nbsp;<!-- <input style="width:65px;" type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$enddate}"> --><input style="width:65px;" type="text" id="enddate" value="{$enddate}" readonly="readonly"></td>                           
                        </tr>
                        <tr>
                            <td style="text-align:right;">Siêu thị :</td>
                            <td style="padding-left:5px;">
                                <select name="fsid" id="fsid" class="input-large">
                                    <option value="0"{if $storeid == 0} selected="selected"{/if}>All</option>
                                    {foreach from=$liststores key=id item=storename}
                                    <option value="{$id}"{if $storeid == $id} selected="selected"{/if}>{$storename}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;">Dữ liệu biểu đồ :</td>
                            <td style="padding-left:5px;">
                                <select name="chartby" id="chartby">
                                    <option {if $chartby == "volume"}selected="selected"{/if} value="volume">Số lượng</option>
                                    <option {if $chartby == "revenue"}selected="selected"{/if} value="revenue">Doanh thu</option>
                                    <option {if $chartby == "profit"}selected="selected"{/if} value="profit">Lãi gộp</option>
                                    <!-- <option  {if $chartby == "avgvalueitem"}selected="selected"{/if} value="avgvalueitem">Giá trị TB item</option> -->
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
                        <td>Lãi gộp: </td><td><b>{$slaigop|number_format}</b></td>
                    </tr><tr>
                        <td>Margin: </td><td><b>{$smargin}{*|string_format: "%.2f"|number_format*}%</b></td>
                    </tr><tr>
                        <td>Giá trị tồn kho: </td><td><b>{$sgiatritonkho|number_format}</b></td>
                    </tr><tr>
                        <td>Số lượng tồn kho: </td><td><b>{$stonkho|number_format}</b></td>
                    </tr>
                    <tr>
                        <td>Số lượng bán: </td><td><b>{$ssoluong|number_format}</b></td>
                    </tr>
                    <tr>
                        <td>Số lượng bán TB: </td><td><b>{if $sngaybanhang > 0}{($ssoluong/$sngaybanhang)|string_format: "%.0f"|number_format}{else}0{/if}</b></td>
                    </tr>
                    <tr>
                        <td>Ngày bán hàng: </td><td><b>{$sngaybanhang|number_format}</b></td>
                    </tr>
                    <tr>
                        <td>Số lượng mua vào: </td><td><b>{$snhapmua|number_format}</b></td>
                    </tr>                        
                    <tr>
                        <td>Giá trị TB item: </td><td><b>{$sgiatritrungbinhitem|number_format}</b></td>
                    </tr>
                </table>
    		</td>
    		<td>
    			<table style="width:100%">
                       <tr>
                           <td>
                               <!--start chart-->
                                <div id="linechart" style="min-width: 400px; height: 785px; margin: 0 auto"></div>
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
    		</td>
    	</tr>
    	<tr><td colspan="2" height="20">&nbsp;</td></tr>
    	<tr>
    		<td>
    			<div>
                    <a style="font-weight:bold;" href="javascript:void(0)" class="btn btn-primary">Top 20 sản phẩm</a>
                    {if $havechildrend==1}
                    <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/productcategory/listsubcate{$paramurl}" class="btn">Category - MC - SKU</a>
                    {else}
                    <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/productcategory/subcate{$paramurl}" class="btn">Category - MC - SKU</a>
                    {/if}
                    <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/productcategory/catestore{$paramurl}" class="btn">Siêu thị</a>
                </div>
    		</td>
    		<td>
    			<div>
                    View Top item by &nbsp;:&nbsp;&nbsp;
                    <span class="label">Year</span> 
                    <select id="yeartopitem" name="yeartopitem" style="width:100px;">
                        <option value="0">Chọn năm</option>
                        <option value="{$currentyear}" selected="selected">{$currentyear}</option>                                                
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <span class="label">Month</span>
                    <select id="monthtopitem" name="monthtopitem" style="width:67px;">   
                        <option value="0">Chọn tháng</option>                     
                        {section name=month start=1 loop=13 step=1}<option value="{$smarty.section.month.index}" {if $currentmonth == $smarty.section.month.index}selected="selected"{/if}>{if $smarty.section.month.index < 10}0{/if}{$smarty.section.month.index}</option>{/section}
                    </select>&nbsp;&nbsp;&nbsp;
                    <span class="label">Week of year</span>
                    <select id="weektopitem" name="weektopitem" style="width:262px;">
                        <option value="0">Chọn Tuần</option>
                        {foreach item=data key=week from=$weekOfYearList}
                        <option {if $currentweek == $week}selected="selected"{/if} value="{$week}">Tuần {$week} ({$data.from} - {$data.to})</option>
                        {/foreach}
                    </select>&nbsp;&nbsp;&nbsp;
                    <span class="label">Day</span>
                    <input style="width:65px;" type="text" class="inputdatepicker" id="daytopitem" name="daytopitem" value="{$currentday}">
               </div>
    		</td>
    	</tr>
    	<tr>
    		<td><div>
                    Xem theo : 
                    <a style="font-style:italic;" href="{$paramurl}&chartby={$chartby}&sort=2&yeartopitem={$currentyear}&monthtopitem={if $currentmonth > 0}{$currentmonth}{else}0{/if}&weektopitem={if $currentweek > 0}{$currentweek}{else}0{/if}&daytopitem={if $currentday > 0}{$currentday}{else}0{/if}" class="{if $sortby == 2}btn btn-primary{else}btn{/if}">Số lượng bán</a>
                    <a style="font-style:italic;" href="{$paramurl}&chartby={$chartby}&sort=1&yeartopitem={$currentyear}&monthtopitem={if $currentmonth > 0}{$currentmonth}{else}0{/if}&weektopitem={if $currentweek > 0}{$currentweek}{else}0{/if}&daytopitem={if $currentday > 0}{$currentday}{else}0{/if}" class="{if $sortby == 1}btn btn-primary{else}btn{/if}">Doanh thu</a>
                    <a style="font-style:italic;" href="{$paramurl}&chartby={$chartby}&sort=3&yeartopitem={$currentyear}&monthtopitem={if $currentmonth > 0}{$currentmonth}{else}0{/if}&weektopitem={if $currentweek > 0}{$currentweek}{else}0{/if}&daytopitem={if $currentday > 0}{$currentday}{else}0{/if}" class="{if $sortby == 3}btn btn-primary{else}btn{/if}">Lãi gộp</a>&nbsp;&nbsp;                                        
                </div>
            </td>
            <td></td>
    	</tr>
    </table><br />
    
    <table class="table table-bordered tablesorter">
        <thead id="header">
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
                <td class="colhead">N</td>                        
                <td class="colhead">O</td>                        
                <td class="colhead">P</td>                        
            </tr>
            <tr style="background-color:#8db4e3">
                <th>1</th>
                <th>Tên SP</th>
                <th>SKU</th>
                <th>Roles, Status</th>
                <th>Số lượng</th>
                <th>Doanh thu</th>
                <th>Giá bán trung bình</th>
                <th>Giá vốn trung bình</th>
                <th>Giá bán HT</th>
                <th>Giá mua vào HT</th>
                <th>LGộp ước tính</th>
                <th>Lãi gộp</th>
                <th>Margin</th>
                <th>Tồn kho</th>
                <th>Ngày bán hàng</th>
                <th>Trả lại</th>
                <th>TG hàng trả</th>
            </tr>
        </thead>
        <tbody>
        {$sumtopitemsoluong = 0}
        {$sumtopitemdoanhthu = 0}
        {$sumtopitemtonkho = 0}
        {$sumtopitemtralai = 0}
        {$sumtopitemtghangtra = 0}
        {$sumtopitemlaigop = 0}
        {foreach from=$producttoplist item=product name=productlists}        	
            <tr>
                <td>{$smarty.foreach.productlists.index + 2}</td>
                <td><a href="{$conf.rooturl}stat/report/productdetail/?id={$product.productid}{$productparamurl}">{$product.ten}</td>
                <td>{$product.sku}</td>
                <td>{$product.vaitro}</td>
                <td class="numberdata">{$product.soluong|number_format}</td>
                <td class="numberdata">{$product.doanhthu|number_format}</td>
                <td class="numberdata">{$product.giabantrungbinh|number_format}</td>
                <td class="numberdata">{$product.giavontrungbinh|number_format}</td>
                <td class="numberdata">{$product.giabanhientai|number_format}</td>
                <td class="numberdata">{$product.giamuahientai|number_format}</td>
                <td class="numberdata">{($product.giabanhientai - $product.giamuahientai)|string_format: "%.0f"|number_format}</td>
                <td class="numberdata">{$product.laigop|number_format}</td>
                <td class="numberdata">{$product.margin|string_format: "%.2f"}%</td>
                <td class="numberdata">{$product.tonkho|number_format}</td>
                <td class="numberdata">{$product.ngaybanhang}</td>
                <td class="numberdata">{$product.tralai}</td>
                <td class="numberdata">{$product.doanhthutralai|number_format}</td>
            </tr>
            {math assign="sumtopitemsoluong"  equation="x + y" x=$sumtopitemsoluong y=$product.soluong}
	        {math assign="sumtopitemdoanhthu"  equation="x + y" x=$sumtopitemdoanhthu y=$product.doanhthu}
	        {math assign="sumtopitemtonkho"  equation="x + y" x=$sumtopitemtonkho y=$product.tonkho}
	        {math assign="sumtopitemtralai"  equation="x + y" x=$sumtopitemtralai y=$product.tralai}
	        {math assign="sumtopitemtghangtra"  equation="x + y" x=$sumtopitemtghangtra y=$product.doanhthutralai}
	        {math assign="sumtopitemlaigop"  equation="x + y" x=$sumtopitemlaigop y=$product.laigop}
        {/foreach}
        </tbody>
        <tfoot>
            <th colspan="4" align="right">Tổng cộng: </th>
            <th class="numberdata">{$sumtopitemsoluong|number_format}</th>
            <th class="numberdata">{$sumtopitemdoanhthu|number_format}</th>
            <th class="numberdata">&nbsp;</th>
            <th class="numberdata">&nbsp;</th>
            <th class="numberdata">&nbsp;</th>
            <th class="numberdata">&nbsp;</th>
            <th class="numberdata">&nbsp;</th>
            <th class="numberdata">{$sumtopitemlaigop|number_format}</th>
            <th class="numberdata">{if $sumtopitemdoanhthu > 0}{math|number_format equation="x*100/y" x=$sumtopitemlaigop y=$sumtopitemdoanhthu format="%.2f"}{else}0{/if}%</th>
            <th class="numberdata">{$sumtopitemtonkho|number_format}</th>
            <th class="numberdata">{if $sumtopitemsoluong > 0} {math|number_format equation="x*y/z" x=$sumtopitemtonkho y=$songay z=$sumtopitemsoluong format="%.2f"}{else}0{/if}</th>
            <th class="numberdata">{$sumtopitemtralai|number_format}</th>
            <th class="numberdata">{$sumtopitemtghangtra|number_format}</th>
        </tfoot>
    </table>
</form>
{literal}
<script type="text/javascript">
    var step = {/literal}{$stepdate}{literal};  
    

    $('#daytopitem')
    .datepicker({format: 'dd/mm/yyyy'})
    .on('changeDate', function(ev){
    	var inputdate = ev.date.valueOf() / 1000;

        //reset month top item                
        $('#monthtopitem').find('option[value="0"]').attr('selected' , 'selected');

        //reset week top item
        $('#weektopitem').find('option[value="0"]').attr('selected', 'selected');

        $('#yeartopitem').find('option[value="0"]').attr('selected', 'selected');

        $('#myform').submit();
    }); 

    $('#monthtopitem').change(function(event) {        
        var monthtopitem = $(this).val();

        //reset week top item        
        $('#weektopitem').find('option[value="0"]').attr('selected','selected');

        $('#daytopitem').val('');

        $('#yeartopitem').find('option[value="0"]').attr('selected', 'selected');

        $('#myform').submit();
    });

    $('#weektopitem').change(function(event) {
        var weektopitem = $(this).val();

        //reset month top item
        $('#monthtopitem').find('option[value="0"]').attr('selected' , 'selected');

        //reset day topitem        
        $('#daytopitem').val('');

        $('#yeartopitem').find('option[value="0"]').attr('selected', 'selected');

        $('#myform').submit();
    });
</script>
{/literal}
<script type="text/javascript" src="{$currentTemplate}js/stat/report/forecastcategory.js"></script>
{include file="_controller/admin/footer.tpl"}