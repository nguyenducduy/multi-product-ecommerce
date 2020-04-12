{include file="_controller/stat/report/headerstat.tpl"}
<div class="breadcrum">
    <span><a href="{$conf.rooturl}stat/report/company{if !empty($urlparam)}?{$urlparam}{/if}">Root</a></span> &raquo;
    {foreach item=productcategory from=$fullproductcategory name=foo key=cateid}
    <span><a title="{$productcategory.name}" href="{$conf.rooturl}stat/report/productcategory?id={$cateid}{if !empty($urlparam)}&{$urlparam}{/if}">{$productcategory.name}</a></span> 
    {if !$smarty.foreach.foo.last}
    &raquo;    
    {/if}
    {/foreach}
    <span> &raquo; Main Character</span>
    {if !empty($breadcum)} &raquo; {$breadcum}{/if}
</div>
<br/>
{if (!empty($report_timeupdatereport))}
<p><em>{$report_timeupdatereport}</em></p>
{/if}
<form action="" method="get">
    <input type="hidden" id="by" value="{$chartby}" />
    <input type="hidden" name="id" value="{$productcategoryinfo->id}" />
    <table style="width:100%">
        <tr>
        	<td style="width:30%;vertical-align: top;padding-left:5px;" valign="top">
        		<table width="100%" style="background-color:#c2d693;">
                    <tr>
                        <td colspan="2" style="height:10px;"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Ngày :</td>
                        <td style="padding-left:5px;padding-right:20px;"><input style="width:65px;" type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$startdate}">&nbsp;-&nbsp;<input style="width:65px;" type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$enddate}"></td>                           
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
                                <option {if $chartby == "volume"}selected="selected"{/if} value="volume">Số lượng bán</option>
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
                </table><br />
                <table class="table table-bordered" style="background-color:#d7e4bc;">
                    <tr>
                        <td width="50%">Doanh thu: </td><td><b>{$sdoanhthu|number_format}</b></td>
                    </tr><tr>
                        <td>Lãi gộp: </td><td><b>{$slaigop|number_format}</b></td>
                    </tr><tr>
                        <td>Margin: </td><td><b>{$smargin}{*|string_format: "%.2f"|number_format*}%</b></td>
                    </tr><tr>
                        <td>Giá trị tồn kho: </td><td><b>{$strigiatonkho|number_format}</b></td>
                    </tr><tr>
                        <td>Số lượng bán: </td><td><b>{$ssoluong|number_format}</b></td>
                    </tr><tr>
                        <td>Giá trị TB item: </td><td><b>{$strigiatrungbinhitem|number_format}</b></td>
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
    <br />
    <div>
        <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/productcategory{$paramurl}" class="btn">Top 20 sản phẩm</a>
        <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/productcategory/subcate{$paramurl}" class="btn btn-primary">Category - MC - SKU</a>
        <a style="font-weight:bold;" href="{$conf.rooturl}stat/report/productcategory/catestore{$paramurl}" class="btn">Siêu thị</a>
    </div>
    <div style="height:5px;"></div>
    <div>
        Xem theo :                           
        <!--<a style="font-style:italic;" href="{$conf.rooturl}stat/report/productcategory/listsubcate{$paramurl}" class="btn">Subcate</a>                          -->
        <a style="font-style:italic;" href="{$conf.rooturl}stat/report/productcategory/brandcate{$paramurl}" class="btn">Brandname</a>        
        <a style="font-style:italic;" href="{$conf.rooturl}stat/report/productcategory/subcatepricesegment{$paramurl}" class="btn">Phân khúc giá</a>        
        {foreach item=attributefilter key=attrslug from=$listattributefilter}
        {if $attrslug == 'gia'}{continue}{/if}
        <a style="font-style:italic;" href="{$conf.rooturl}stat/report/productcategory/maincharacter{$paramurl}&pa={$attrslug}" class="btn {if $attrslug == $panamefilter}btn-primary{/if}">{$attributefilter.name}</a>
        {/foreach}
        <a style="font-style:italic;" href="{$conf.rooturl}stat/report/productcategory/subcate{$paramurl}" class="btn">SKUs</a>
    </div>
    <div style="height:5px;"></div>
    <div id="dataTable">            
        <table class="table table-bordered tablesorter" id="data">
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
                </tr>
                <tr style="background-color:#8db4e3">
                    <th>1</th>
                    <th>Phân khúc</th>              
                    <th>Mức đóng góp %</th>
                    <th>Model (SKU)</th>
                    <th>Số lượng bán</th>
                    <th>Doanh thu</th>
                    <th>Giá bán trung bình(-VAT)</th>
                    <th>Giá bán trung bình(+VAT)</th>
                    <th>Giá vốn trung bình</th>
                    <th>Lãi gộp</th>
                    <th>Margin</th>
                    <th>Tồn kho</th>                
                    <th>Ngày bán hàng</th>              
                    <th>Trả lại</th>
                    <th>TG hàng trả</th>
                </tr>
            </thead>
            <tbody>
            {$tonggiatriton = 0}
            {$tongngaybanhang = 0}
            {$tongtralai = 0}
            {$tongdoanhthutralai = 0}
            {$tongsomodels = 0}
            {foreach from=$listattrdata item=product name=productlists}           
                <tr>
                    <td>{$smarty.foreach.productlists.iteration}</td>                   
                    <td><a title="{$product.tengiatrithuoctinh}" href="{$conf.rooturl}stat/report/productcategory/subcate{$paramurl}&a={$product.nameseo},{$product.filterseo}">{$product.tengiatrithuoctinh}</a></td>
                    <td>{$product.mucdonggop}</td>
                    <td>{$product.numskus}</td>
                    <td>{$product.soluong}</td>
                    <td>{$product.doanhthu|number_format}</td>
                    <td>{$product.giabanchuavat|number_format}</td>
                    <td>{$product.giabancovat|number_format}</td>
                    <td>{$product.giavontrungbinh|number_format}</td>
                    <td>{$product.laigop|number_format}</td>
                    <td>{$product.margin|string_format: "%.2f"}%</td>
                    <td>{$product.giatriton}</td>
                    <td>{$product.ngaybanhang}</td>
                    <td>{$product.tralai}</td>
                    <td>{$product.doanhthutralai}</td>
                </tr>
                {math assign="tonggiatriton"  equation="x + y" x=$tonggiatriton y=$product.giatriton}
                {math assign="tongtralai" equation="x + y" x=$tongtralai y=$product.tralai}
                {math assign="tongdoanhthutralai" equation="x + y" x=$tongdoanhthutralai y=$product.doanhthutralai}
                {math assign="tongsomodels" equation="x + y" x=$tongsomodels y=$product.numskus}
            {/foreach}
            </tbody>
            <tfoot>
            	<tr>
                    <th colspan="2">Tổng cộng:</th>
                    <th></th>
                    <th>{$tongsomodels|number_format}</th>
                    <th>{$ssoluong|number_format}</th>
                    <th>{$sdoanhthu|number_format}</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>{$slaigop|number_format}</th>
                    <th>{$smargin}%</th>
                    <th>{$tonggiatriton|number_format}</th>                
                    <th>{if $ssoluong > 0} {math|number_format equation="x*y/z" x=$tonggiatriton y=$songay z=$ssoluong format="%.2f"}{else}0{/if}</th>              
                    <th>{$tongtralai|number_format}</th>
                    <th>{$tongdoanhthutralai|number_format}</th>
                </tr>
            </tfoot>
        </table>
    <div>
</form>
<script type="text/javascript">
    var step = {$stepdate}
</script>
<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/report/subcateattribute.js"></script>
{include file="_controller/admin/footer.tpl"}