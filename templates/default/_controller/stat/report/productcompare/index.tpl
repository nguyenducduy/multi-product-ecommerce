{include file="_controller/stat/report/headerstat.tpl"}
<div class="breadcrum">
    <span><a href="{$conf.rooturl}stat/report/company">Root</a></span> &raquo;
    {foreach item=productcategory from=$fullproductcategory key=pcid name=foo}
    <span><a title="{$productcategory.name}" href="{$conf.rooturl}stat/report/productcategory?id={$pcid}">{$productcategory.name}</a></span> &raquo;
    {/foreach}
    <span>{$myProduct->name}</span>
</div>
<br/>
<form action="" method="get">
    <input type="hidden" name="id" value="{$id}" />
    <input type="hidden" name="by" id="by" value="{$chartby}" />
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
			                        <option value="0"{if $storeid == 0} selected="selected"{/if}>All</option>
			                        {foreach from=$liststores key=id item=storename}
			                        <option value="{$store->id}"{if $storeid == $id} selected="selected"{/if}>{$storename}</option>
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
                		    <td style="text-align:right;">
                		    	Sản phẩm 2 :
                		    </td>
                		    <td style="padding-left:5px;">
                		    	{if $products|@count > 1}
                		    		<span style="font-size:16px;" class="label label-success">{foreach item=product from=$products}{if $product->id == $id2}{$product->name}{/if}{/foreach}</span>									
                		    	{/if}                		    	
                		    </td>
                		</tr>        
                		<tr>
    		              	<td style="text-align:right;">Tìm kiếm :</td>
    		              	<td style="padding-left:5px;"><select style="width:325px;" name="fid2" id="fid2" class="autocompleteoneproduct"></select>							
					{if $fid2 > 0}<input type="hidden" name="fid2" id="fvalue2" value="{$fid2}" />{/if}</td>
    		              </tr>              
                		<tr>
                			<td colspan="2"></td>
                		</tr>
                		<tr>                			
                			<td colspan="2" style="text-align:center;">
                				<input type="submit" class="btn btn-primary" name="view" value="XEM" />&nbsp;								
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
                		<thead>
							<tr>
								<th></th>
								{foreach item=product from=$products}
								<th><b>{$product->name}</b></th>
								{/foreach}
							</tr>
						</thead>
						<tbody>
							<tr>
    							<td width="30%">Trạng thái: </td>
    							{foreach item=sstatus from=$strangthai}
    							<td><b>{$sstatus}</b></td>
    							{/foreach}
    						</tr>
    						<tr>
    							<td>Vai trò: </td>
    							{foreach item=ssku from=$svaitro}
    							<td><b>{$ssku}</b></td>
    							{/foreach}
    						</tr>
    						<tr>
    							<td>Nhóm: </td>
    							{foreach item=nhom from=$snhom}
    							<td><b>{$nhom}</b></td>
    							{/foreach}
    						</tr>
    						<tr>
    							<td>Ranking: </td>
    							{foreach item=ranking from=$sranking}
    							<td><b>{$ranking}</b></td>
    							{/foreach}
    						</tr>	    
    					</tbody>
                	</table>
                	<div style="height:10px"></div>
                	<table class="table table-bordered" style="background-color:#d7e4bc;">
						<tr>
							<td width="30%">SL thực bán: </td>
							{foreach item=slthucban from=$ssoluongthucban}
							<td><b>{$slthucban}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Doanh thu: </td>
							{foreach item=doanhthu from=$sdoanhthu}
							<td><b>{$doanhthu}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Lãi gộp: </td>
							{foreach item=laigop from=$slaigop}
							<td><b>{$laigop}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Lãi gộp: </td>
							{foreach item=margin from=$smargin}
							<td><b>{$margin}%</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Điểm chuẩn: </td>
							{foreach item=diemchuan from=$sdiemchuan}
							<td><b>{$diemchuan}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Tổng điểm thưởng: </td>
							{foreach item=tongdiemthuong from=$stongdiemthuong}
							<td><b>{$tongdiemthuong}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Giá bán TB: </td>
							{foreach item=giabantb from=$sgiabantrungbinh}
							<td><b>{$giabantb}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Giá vốn TB: </td>
							{foreach item=giavontb from=$sgiavontrungbinh}
							<td><b>{$giavontb}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Tồn kho: </td>
							{foreach item=tonkho from=$stonkho}
							<td><b>{$tonkho}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Tốc độ bán TB: </td>
							{foreach item=tocdoban from=$stocdobantrungbinh}
							<td><b>{$tocdoban}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Ngày tồn kho: </td>
							{foreach item=ngaytonkho from=$sngaytonkho}
							<td><b>{$ngaytonkho}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Nhập trong kỳ: </td>
							{foreach item=nhaptrongky from=$snhaptrongky}
							<td><b>{$nhaptrongky}</b></td>
							{/foreach}
						</tr>
						<tr>
							<td>Ngày cao điểm: </td>
							{foreach item=ngaycaodiem from=$sngaycaodiem}
							<td><b>{$ngaycaodiem}</b></td>
							{/foreach}
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
                                <div id="chart" style="min-width: 780px; height: 785px; margin: 0 auto"></div>
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
    <div id="dataTable">
		<table class="table table-bordered tablesorter" id="data">
			<thead>
				<tr>
					<td class="colhead"></td>
					<td class="colhead">A</td>

					{if $numberproduct > 1}
					<td class="colhead">B</td>
					<td class="colhead">C</td>
					{else}
					<td class="colhead">B</td>
					{/if}

					{if $numberproduct > 1}
					<td class="colhead">D</td>
					<td class="colhead">E</td>
					{else}
					<td class="colhead">C</td>
					{/if}

					{if $numberproduct > 1}
					<td class="colhead">F</td>
					<td class="colhead">G</td>
					{else}
					<td class="colhead">D</td>
					{/if}

					{if $numberproduct > 1}
					<td class="colhead">H</td>
					<td class="colhead">I</td>
					{else}
					<td class="colhead">E</td>
					{/if}

					{if $numberproduct > 1}
					<td class="colhead">J</td>
					<td class="colhead">K</td>
					{else}
					<td class="colhead">F</td>
					{/if}

					{if $numberproduct > 1}
					<td class="colhead">L</td>
					<td class="colhead">M</td>
					{else}
					<td class="colhead">G</td>
					{/if}

					{if $numberproduct > 1}
					<td class="colhead">N</td>
					<td class="colhead">O</td>
					{else}
					<td class="colhead">H</td>
					{/if}
					
				</tr>
                <tr style="background-color:#8db4e3">
                    <td style="width:10px;">1</th>
                    <th>Ngày</th>
                    <th style="width:100px;" colspan="{$numberproduct}">Số lượng</th>
                    <th colspan="{$numberproduct}">Doanh thu</th>
                    <th colspan="{$numberproduct}">Giá bán trung bình</th>
                    <th colspan="{$numberproduct}">Giá vốn trung bình</th>
                    <th colspan="{$numberproduct}">Lãi gộp</th>
                    <th colspan="{$numberproduct}">Margin</th>
                    <th style="width:75px;" colspan="{$numberproduct}">Trả lại</th>
                </tr>
            </thead>
            <tbody>
				{foreach item=rows key=date from=$dataList name=foo}
				<tr>
					{assign var="col" value="0"}

					<td>{$smarty.foreach.foo.index+2}</td>							
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}">{$date|date_format:"%d/%m/%Y"}</td>	
					{assign var="col" value=$col+1}

					{foreach item=row key=pid from=$rows}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="numberdata">{$row.soluong|number_format}</td>							
					{assign var="col" value=$col+1}
					{/foreach}	

					{foreach item=row key=pid from=$rows}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="editable numberdata">{$row.doanhthu|number_format}</td>
					{assign var="col" value=$col+1}							
					{/foreach}	

					{foreach item=row key=pid from=$rows}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="editable numberdata">{$row.giabanchuavat|number_format}</td>	
					{assign var="col" value=$col+1}						
					{/foreach}	

					{foreach item=row key=pid from=$rows}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="editable numberdata">{$row.giavontrungbinh|number_format}</td>
					{assign var="col" value=$col+1}							
					{/foreach}

					{foreach item=row key=pid from=$rows}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="editable numberdata">{$row.laigop|number_format}</td>		
					{assign var="col" value=$col+1}					
					{/foreach}		

					{foreach item=row key=pid from=$rows name=cell}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="numberdata">{$row.margin|string_format:"%.2f"}<span>%</span></td> 		
					{assign var="col" value=$col+1}
					{/foreach}

					{foreach item=row key=pid from=$rows}
					<td id="{$columnName.$col}{$smarty.foreach.foo.index+1}" class="numberdata">{$row.tralai|number_format}</td>		
					{assign var="col" value=$col+1}	
					{/foreach}		
				</tr>
				{/foreach}
			</tbody>	    			
		</table>
	</div>
</form>

{if $numberproduct > 1}
{literal}
<style type="text/css">
	.editable{
   		width: 100px;
	}
</style>
{/literal}
{/if}
{literal}
<script type="text/javascript">
	var step = {/literal}{$stepdate}{literal}
	$(document).ready(function(){
		//$('#fid2')
		$('.holder').css({'width':'250px'});
		$('.facebook-auto').css({'width':'250px'});
		$('#fid2_feed').css({'width':'250px'});
})
</script>
{/literal}
<script type="text/javascript" src="{$currentTemplate}js/stat/report/productcompare.js"></script>
{include file="_controller/admin/footer.tpl"}