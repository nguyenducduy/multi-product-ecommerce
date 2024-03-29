{include file="_controller/stat/report/headerstat.tpl"}
<div class="breadcrum">
    <span><a href="{$conf.rooturl}stat/report/company{if !empty($urlparam)}?{$urlparam}{/if}">Root</a></span> &raquo;
    {foreach item=productcategory from=$fullproductcategory key=pcid name=foo}
    <span><a title="{$productcategory.name}" href="{$conf.rooturl}stat/report/productcategory?id={$pcid}{if !empty($urlparam)}&{$urlparam}{/if}">{$productcategory.name}</a></span> &raquo;
    {/foreach}
    <span>{$myProduct->name}</span>
</div>
{if (!empty($report_timeupdatereport))}
<p><em>{$report_timeupdatereport}</em></p>
{/if}
<br/>
<form action="" method="get" id="myform">
    <input type="hidden" id="by" value="{$chartby}" />
    <input type="hidden" name="id" value="{$myProduct->id}" />
    <table style="width:100%">
        <tr>
            <td style="width:30%;vertical-align: top;padding-left:5px;">
                <div>
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
			                        <option value="0">All</option>
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
                				<input type="submit" class="btn btn-primary" name="view" value="XEM" />&nbsp;
								<!--<input type="button" class="btn btn-primary" id="compare" onclick="comparefunc('{$myProduct->id}')" value="So sánh sản phẩm" />-->
                			</td>
                		</tr> 
                		<tr>
                			<td colspan="2" style="height:10px;"></td>
                		</tr>               		
                	</table>
                </div>
                <div style="height:10px"></div>
                <div>
                    <table class="table table-bordered" style="background-color:#d7e4bc;">
                        <tr>
                            <td width="30%">Trạng thái: </td><td><b>{$strangthai}</b></td>
                        </tr>
                        <!--<tr>
                            <td>Vai trò: </td><td><b>{$svaitro}</b></td>
                        </tr>-->
                        <tr>
                            <td>Nhóm: </td><td><b>{$snhom}</b></td>
                        </tr>
                        <tr>
                            <td>Ranking: </td><td><b>{$sranking}</b></td>
                        </tr>                        
                    </table>
                    <div style="height:10px;"></div>
                    <table class="table table-bordered" style="background-color:#d7e4bc;">
                    	<tr>
                            <td width="30%">SL thực bán: </td><td><b>{$ssoluongthucban}</b></td>
                        </tr>
                        <tr>
                            <td>Trả lại: </td><td><b>{$stralai}</b></td>
                        </tr>
                        <tr>
                            <td>Doanh thu: </td><td><b>{$sdoanhthu|number_format}</b></td>
                        </tr>
                         <!--<tr>
                            <td>Doanh thu (+VAT): </td><td><b>{$sthanhtoan|number_format}</b></td>
                        </tr>-->
                        <tr>
                            <td>Lãi gộp: </td><td><b>{$slaigop|number_format}</b></td>
                        </tr>
                        <tr>
                            <td>Margin: </td><td><b>{$smargin|number_format}%</b></td>
                        </tr>
                        <tr>
                            <td>Điểm chuẩn: </td><td><b>{$sdiemchuan|number_format}</b></td>
                        </tr>
                        <!--<tr>
                            <td>Tổng điểm thưởng: </td><td><b>{$stongdiemthuong}</b></td>
                        </tr>
                        <tr>
                            <td>Giá bán TB (-VAT): </td><td><b>{$sgiabantrungbinh|number_format}</b></td>
                        </tr>
                         <tr>
                            <td>Giá bán TB (+VAT): </td><td><b>{$sgiabantrungbinhcovat|number_format}</b></td>
                        </tr>-->
                        <tr>
                            <td>Giá vốn TB: </td><td><b>{$sgiavontrungbinh|number_format}</b></td>
                        </tr>
                        <tr>
                            <td>Tồn kho: </td><td><a href="{$conf.rooturl}stat/report/productdetail?id={$myProduct->id}{if !empty($urlparam)}&{$urlparam}{/if}&tab=2"><b>{$stonkho}</b></a></td>
                        </tr>
                        <tr>
                            <td>Tốc độ bán TB: </td><td><b>{$stocdoban}</b></td>
                        </tr>
                        <tr>
                            <td>Ngày tồn kho: </td><td><b>{$sngaytonkho}</b></td>
                        </tr>
                        <tr>
                            <td>Nhập trong kỳ: </td><td><b>{$snhaptrongky}</b></td>
                        </tr>
                        <tr>
                            <td>Ngày cao điểm: </td><td><b>{$sngaycaodiem}</b></td>
                        </tr>                        
                        <tr>
                            <td>Giá mua vào: </td><td><b>{if !empty($sgiamuavao)}{$sgiamuavao}{else}0{/if}</b></td>
                        </tr>
                        <tr>
                            <td>Giá niêm yết: </td><td><b>{$sgianiemyet}</b></td>
                        </tr>
                        <tr>
                            <td>Giá bán cuối: </td><td><b>{if !empty($sgiabancuoi)}{$sgiabancuoi|number_format}{else}0{/if}</b></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="padding-left:45px;vertical-align: top;">                
                <div>
                    <table style="width:100%">
                        <tr>
                            <td>
                                <!--start chart-->
                                <div id="chart" style="min-width: 400px; height: 785px; margin: 0 auto"></div>
                                <!--end of chart-->
                                {if $chartData|@count > 0}
                                    <div id="chartTitle" stlye="display:none;" charttitledata="{$chartTitle}"></div>
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
                    </table>
                </div>
            </td>
        </tr>
    </table> 
    <div style="height:10px;"></div>
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li {if $tab ==1}class="active"{/if}><a class="tabdata" id="1"  href="" data-toggle="tab">Theo ngày</a></li><!--#tab1-->
            <li {if $tab ==2}class="active"{/if}><a class="tabdata" id="2" href="" data-toggle="tab">Tồn kho theo kho</a></li><!--#tab2-->
            <li {if $tab ==3}class="active"{/if}><a class="tabdata" id="3" href="" data-toggle="tab">Tồn kho theo trị giá</a></li><!-- #tab3-->       
            <!-- <li {if $tab ==4}class="active"{/if}><a class="tabdata" id="4" href="#tab4" data-toggle="tab">Tồn kho theo loại kho</a></li>
            <li {if $tab ==5}class="active"{/if}><a class="tabdata" id="5" href="#tab5" data-toggle="tab">Lãi gộp theo siêu thị</a></li>
            <li {if $tab ==6}class="active"{/if}><a class="tabdata" id="6" href="#tab6" data-toggle="tab">Lãi gộp theo nhân viên</a></li>
            <li {if $tab ==7}class="active"{/if}><a class="tabdata" id="7" href="#tab7" data-toggle="tab">Lãi gộp theo kênh</a></li>
            <li {if $tab ==8}class="active"{/if}><a class="tabdata" id="8" href="#tab8" data-toggle="tab">Biến động giá bán</a></li>   -->
            <!--<li {if $tab ==9}class="active"{/if}><a class="tabdata" id="9" href="#tab9" data-toggle="tab">Forecast  siêu thị</a></li>-->        
            <li {if $tab ==10}class="active"{/if}><a class="tabdata" id="10" href="" data-toggle="tab">Siêu thị forecast</a></li>     <!--#tab10-->   
            <li><a class="tabdata" id="11" href="" rel="notchange" data-toggle="tab" onclick="loadprice(11)">So sánh giá</a></li><!--#tab11-->
        </ul>
        <div class="tab-content">
            <div class="tab-pane {if $tab ==1}active{/if}" id="tab1">
                <p id="processingtab1" align="center"><img src="{$currentTemplate}images/ajax_indicator.gif" /></p>                
                {if $dataList|@count > 0 && $tab==1}
				<div id="dataTable">
                <table class="table table-bordered tablesorter" id="data">
                    <thead id="header">
                        <tr>
                            <td style="width:10px;" class="colhead"></td>
                            <td class="colhead">A</td>
                            <td class="colhead">B</td>
                            <td class="colhead">C</td>
                            <!--<td class="colhead">D</td>-->
                            <td class="colhead">E</td>
                            <td class="colhead">F</td>
                            <td class="colhead">G</td>
                            <td class="colhead">H</td>
                            <td class="colhead">I</td>
                            <td class="colhead">J</td>                        
                            <td class="colhead">K</td>  
                            <td class="colhead">L</td>
                        </tr>
                        <tr style="background-color:#f3f3f3">
                            <td>1</td>
                            <th>Ngày</th>
                            <th>Số lượng bán</th>
                            <th>Doanh thu</th>
                            <!-- <th>Giá trị khuyến mãi</th> -->
                            <!--<th>Doanh thu (+VAT)</th>-->
                            <th>Giá vốn</th>
                            <th>Giá bán (-VAT)</th>
                            <th>Giá bán (+VAT)</th>
                            <th>Giá vốn trung bình</th>                       
                            <th>Lãi gộp</th>
                            <th>Margin</th>
                            <th>Trả lại</th>
                            <th>TG hàng trả</th>
                        </tr>
                        
                        
                    </thead>
                    <tbody>
                    {foreach item=rows key=date from=$dataList name=foo}
                    	{if $rows.soluongthucban ==0 && $rows.tralai ==0 && $rows.giavon ==0}{continue}{/if}
                        <tr>
                            <td>{$smarty.foreach.foo.index+2}</td>
                            <td>{$date|date_format:"%d/%m/%Y"}</td>
                            <td class="numberdata">{$rows.soluongthucban}</td>
                            <td class="numberdata">{$rows.doanhthuthucte|number_format}</td>
                            <!-- <td class="numberdata">{$rows.giatrikhuyenmai|number_format}</td> 
                            <td class="numberdata">{$rows.thanhtoanthucte|number_format}</td>-->
                            <td class="numberdata">{$rows.giavon|number_format}</td>
                            <td class="numberdata">{$rows.giabanchuavat|number_format}</td>
                            <td class="numberdata">{$rows.giabancovat|number_format}</td>
                            <td class="numberdata">{$rows.giavontrungbinh|number_format}</td>                        
                            <td class="numberdata">{$rows.laigop|number_format}</td>
                            <td class="numberdata">{$rows.margin|string_format:"%.2f"}<span>%</span></td>
                            <td class="numberdata">{$rows.tralai}</td>
                            <td class="numberdata">{$rows.doanhthutralai|number_format}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                    <tfoot>
                    	<tr style="background-color:#f3f3f3">
                            <th colspan="2">Tổng cộng: </th>
                            <th>{$ssoluongthucban}</th>
                            <th>{$sdoanhthu|number_format}</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>{$sgiavontrungbinh|number_format}</th>                       
                            <th>{$slaigop|number_format}</th>
                            <th>{$smargin|number_format}%</th>
                            <th>{$stralai|number_format}</th>
                            <th>{$sdoanhthutralai|number_format}</th>
                        </tr>
                    </tfoot>
                </table>
				</div>
                {/if}                
            </div><!--end of tab 1-->

            <div class="tab-pane {if $tab ==2}active{/if}" id="tab2">
                <p id="processingtab2" align="center"><img src="{$currentTemplate}images/ajax_indicator.gif" /></p>
                {if $tab == 2}{$content}{/if}
            </div><!--end of tab 2-->

            <div class="tab-pane {if $tab ==3}active{/if}" id="tab3">
                 <p id="processingtab3" align="center"><img src="{$currentTemplate}images/ajax_indicator.gif" /></p>
                {if $tab == 3}{$content}{/if}
            </div><!--end of tab 3-->

            <!-- <div class="tab-pane {if $tab ==4}active{/if}" id="tab4">
                
            </div> --><!--end of tab 4-->

            <!-- <div class="tab-pane {if $tab ==5}active{/if}" id="tab5">
                
            </div> --><!--end of tab 5-->

            <!-- <div class="tab-pane {if $tab ==6}active{/if}" id="tab6">
                
            </div> --><!--end of tab 6-->

           <!--  <div class="tab-pane {if $tab ==7}active{/if}" id="tab7">
                
            </div> --><!--end of tab 7-->

            <!-- <div class="tab-pane {if $tab ==8}active{/if}" id="tab8">
                
            </div> --><!--end of tab 8-->

            <!--<div class="tab-pane {if $tab ==9}active{/if}" id="tab9">
                
            </div>--><!--end of tab 9-->

            <div class="tab-pane {if $tab ==10}active{/if}" id="tab10">
				<p id="processingtab10" align="center"><img src="{$currentTemplate}images/ajax_indicator.gif" /></p>
            	{if $tab == 10}{$content}{/if}
            </div><!--end of tab 10-->
            <div class="tab-pane" id="tab11">
                <p id="processingtab11" align="center"><img src="{$currentTemplate}images/ajax_indicator.gif" /></p>               
            </div><!--end of tab 11-->
        </div>    
    </div>    
</form>              
{include file="_controller/admin/footer.tpl"}
{literal}
<script type="text/javascript">
   var tab = {/literal}{$tab}{literal};
   var step = {/literal}{$stepdate}{literal}
   var pid = {/literal}{$myProduct->id}{literal}
    $('.tabdata').on("click",function(){        
        if($(this).attr('rel') == undefined){
            tab = $(this).attr("id");
            $('#tab'+tab).css('height' , '500px');                
            $('#tab'+tab).html('<img src="{$currentTemplate}images/ajax_indicator.gif" />');
            
            var loc = window.location.href;        
            var path = loc.replace(/(&tab=)[0-9]/,"");        
            var url = path + '&tab=' + tab;

            window.location = url;
        }
    });
    $(document).ready(function($) {
        $('#processingtab'+tab).hide();
    });

    function comparefunc(id)
    {
    	window.location = rooturl + 'stat/report/productcompare?id=' + id;
    }

    function loadprice(tabid)
    {        
        $.ajax({
            url: rooturl + 'productcompare/priceenemy',
            type: 'GET',
            dataType: 'html',
            data: 'pid='+pid,
            success : function(html){                        
                $('#processingtab'+tabid).hide();                
                $('#tab' +tabid).html(html);                
                $(".tab-content .tab-pane").each(function(){
                    $(this).attr('class' , 'tab-pane');
                });  
                $("#tab" + tabid).attr('class' , 'tab-pane active');
            }
        })        
        
    }

    function openShadowbox(url){
            if(url != ""){
                Shadowbox.open({
                    content:    url, 
                    title : 'So sánh giá đối thủ',                  
                    player:     "iframe" 
                });
            }     
    }
</script>

{/literal}
<script type="text/javascript" src="{$currentTemplate}js/stat/report/productdetail.js"></script>
