{include file="notify.tpl" notifyError=$error notifySuccess=$success}
{if $store->id > 0}
<form id="myform" action="" method="post">
	<input type="hidden" name="ftoken" value="{$smarty.session.forecaststoreAddToken}" />
	<input type="hidden" name="fmonth" value="{$nextmonth}"/>
	<input type="hidden" name="fyear" value="{$currentyear}"/>
	<input type="hidden" name="fsid" value="{$store->id}" />
	<input type="hidden" name="fsheet" value="{$sheet}" />
	<input type="hidden" name="datajax" value="2" />		
	Siêu thị : <span class="label label-info">{$store->name}</span>		
	<div style="height:10px;"></div>
	<div id="dataTableforecast">
		<div style="float:right;margin:5px;"><input type="button" class="btn btn-large btn-primary" name="fsubmituservalue" id="fsubmituservalue" value="Lưu giá trị" /></div>	
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
					<td style="display:none;" class="colhead">H</td>
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
					<td style="display:none;" class="colhead">U</td>
					<td class="colhead">V</td>
				</tr>
				<tr>
					<td class="colhead" rowspan="2">1</td>
					<td class="colhead" rowspan="2">Sản phẩm</td>					
					<td class="colhead" rowspan="2">Barcode</td>
					<td class="colhead" rowspan="2">Trạng thái</td>
					<td class="colhead" colspan="5">Hạn mức</td>
					{foreach item=month from=$last2month}
					<td class="colhead">Tháng {$month}</td>
					{/foreach}
					<td class="colhead" colspan="5">Tháng {$currentmonth}</td>
					<td class="colhead" colspan="5">Tháng {$nextmonth}</td>
				</tr>
				<tr>					
					<td class="colhead">Min</td>
					<td class="colhead">Max</td>
					<td class="colhead">Ngày Min</td>
					<td class="colhead">Ngày Max</td>
					<td style="display:none;" class="colhead">Giá mua vào 1</td>
					<td class="colhead">Giá mua vào</td>
					<td class="colhead">SL bán</td>
					<td class="colhead">SL bán</td>
					<td class="colhead">SL bán&nbsp;({$currentdate})</td>
					<td class="colhead">Tồn&nbsp;({$currentdate})</td>
					<td class="colhead">SL Bán DK</td>
					<td class="colhead">Tồn DK</td>
					<td class="colhead">Tốc độ</td>
					<td class="colhead">SL Bán</td>
					<td class="colhead">SL Nhập</td>
					<td class="colhead">Tồn cuối</td>
					<td class="colhead">Doanh thu</td>
					<td style="display:none;" class="colhead">Lãi gộp 1</td>
					<td class="colhead">Lãi gộp</td>
				</tr>
			</thead>
			<tbody>
				{foreach item=rowdata from=$datalist name=foo1}
				<tr>
					<td>{$smarty.foreach.foo1.index+2}</td>
					<td><a href="{$conf.rooturl}stat/report/productdetail?id={$rowdata.id}" target="_blank"><span style="width: 115px;display: block;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" class="label label-info">{$rowdata.name}</span></a></td>
					<td>{$rowdata.barcode}</td>
					<td>{$rowdata.bussinessstatus}</td>
					<td><span id="D{$smarty.foreach.foo1.index+2}">{$rowdata.min}</span></td>
					<td><span id="E{$smarty.foreach.foo1.index+2}">{$rowdata.max}</span></td>
					<td><span id="F{$smarty.foreach.foo1.index+2}">{$rowdata.ngaymin}</span></td>					
					<td><span id="G{$smarty.foreach.foo1.index+2}">{$rowdata.ngaymax}</span></td>
					<td style="display:none;"><span data-format="0,0[.]00" id="H{$smarty.foreach.foo1.index+2}">{$rowdata.inputpricevat}</span><br/>({$rowdata.inputdate})</td>					
					<td><span data-format="0,0[.]00" id="I{$smarty.foreach.foo1.index+2}">{$rowdata.inputpriceuser}</span></td>					
					{foreach item=month from=$last2month name=foo}
					<td><span id="{if $smarty.foreach.foo.index==0}J{$smarty.foreach.foo1.index+2}{else}K{$smarty.foreach.foo1.index+2}{/if}">{$rowdata.soluongban.$month|number_format}</span></td>
					{/foreach}
					<td><span id="L{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbanhientai}</span></td>
					<td><span id="M{$smarty.foreach.foo1.index+2}">{$rowdata.tonkhohientai}</span></td>
					<td><span id="N{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandukien}</span></td>
					<td><span id="O{$smarty.foreach.foo1.index+2}">{$rowdata.tonkhodukien}</span></td>
					<td><span id="P{$smarty.foreach.foo1.index+2}">{$rowdata.tocdo}</span></td>

					{if $isedit == 0}<td><span id="Q{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandk.value}</span></td>{else}<td dataid="RR{$smarty.foreach.foo1.index+2}" id="{$rowdata.soluongbandk.name}" class="editable" rel="Q{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandk.value}</td>{/if}

					{if $isedit == 0}<td><span id="R{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</span></td>{else}<td id="{$rowdata.soluongnhapdk.name}" data="notchange" number="W{$smarty.foreach.foo1.index+2} , X{$smarty.foreach.foo1.index+2}" class="editable" rel="R{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</td><span style="display:none;" rel="R{$smarty.foreach.foo1.index+2}" class="datanew" id="RR{$smarty.foreach.foo1.index+2}" data-formula="IF(($O{$smarty.foreach.foo1.index+2}-$Q{$smarty.foreach.foo1.index+2}) >= $W{$smarty.foreach.foo1.index+2} , 0 , $Q{$smarty.foreach.foo1.index+2}-$O{$smarty.foreach.foo1.index+2}+$W{$smarty.foreach.foo1.index+2})"></span>					
					{/if}

					<td><span  id="S{$smarty.foreach.foo1.index+2}" data-formula="$O{$smarty.foreach.foo1.index+2}+$R{$smarty.foreach.foo1.index+2}-$Q{$smarty.foreach.foo1.index+2}"></span></td>

					<td><span id="T{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="{if $rowdata.finalprice > 0}{$rowdata.finalprice}*$Q{$smarty.foreach.foo1.index+2}{else}{$rowdata.sellprice}*$Q{$smarty.foreach.foo1.index+2}{/if}"></span></td>

					<td style="display:none;"><span id="U{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="$T{$smarty.foreach.foo1.index+2} - ($Q{$smarty.foreach.foo1.index+2} * {$rowdata.inputpricereal} )"></span></td>

					<td><span id="V{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="$T{$smarty.foreach.foo1.index+2} - ($Q{$smarty.foreach.foo1.index+2} * $I{$smarty.foreach.foo1.index +2} )"></span></td>

					<span style="display:none;" id="W{$smarty.foreach.foo1.index+2}" data-formula="IF($D{$smarty.foreach.foo1.index+2} > ($F{$smarty.foreach.foo1.index+2} * $O{$smarty.foreach.foo1.index+2}) , $D{$smarty.foreach.foo1.index+2} , ($F{$smarty.foreach.foo1.index+2} * $O{$smarty.foreach.foo1.index+2}) )"></span>

					<span style="display:none;" id="X{$smarty.foreach.foo1.index+2}" data-formula="$G{$smarty.foreach.foo1.index+2} * $O{$smarty.foreach.foo1.index+2}"></span>
				</tr>
				{/foreach}
				<tr>
					<td>{$datalist|@count + 2}</td>
					<td colspan="8"><b style="text-align: center;">Total</b></td>
					<td><span class="total" id="J{$datalist|@count + 2}" rel="SUM($J2,$J{$datalist|@count+1})"></span></td>
					<td><span class="total" id="K{$datalist|@count + 2}" rel="SUM($K2,$K{$datalist|@count+1})"></span></td>
					<td><span class="total" id="L{$datalist|@count + 2}" rel="SUM($L2,$L{$datalist|@count+1})"></span></td>
					<td><span class="total" id="M{$datalist|@count + 2}" rel="SUM($M2,$M{$datalist|@count+1})"></span></td>
					<td><span class="total" id="N{$datalist|@count + 2}" rel="SUM($N2,$N{$datalist|@count+1})"></span></td>
					<td><span class="total" id="O{$datalist|@count + 2}" rel="SUM($O2,$O{$datalist|@count+1})"></span></td>
					<td><span class="total" id="P{$datalist|@count + 2}" rel="SUM($P2,$P{$datalist|@count+1})"></span></td>
					<td><span class="total" id="Q{$datalist|@count + 2}" rel="SUM($Q2,$Q{$datalist|@count+1})"></span></td>
					<td><span class="total" id="R{$datalist|@count + 2}" rel="SUM($R2,$R{$datalist|@count+1})"></span></td>
					<td><span class="total" id="S{$datalist|@count + 2}" rel="SUM($S2,$S{$datalist|@count+1})"></span></td>
					<td><span data-format="0,0[.]00" class="total" id="T{$datalist|@count + 2}" rel="SUM($T2,$T{$datalist|@count+1})"></span></td>
					<td style="display:none;"><span data-format="0,0[.]00" class="total" id="U{$datalist|@count + 2}" rel="SUM($U2,$U{$datalist|@count+1})"></span></td>
					<td><span data-format="0,0[.]00" class="total" id="V{$datalist|@count + 2}" rel="SUM($V2,$V{$datalist|@count+1})"></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</form>
{/if}

{literal}
<script type="text/javascript">
	$(document).ready(function(){
		
		loadeditable();

	   	$('.datainput').keypress(function(e) {        
	        //check element is exist       
	        var dataafter = '';
	         //if press enter
	        if(e.which == 13 || e.keyCode == 13) {             
	            e.preventDefault();                   
	            dataafter = $(this).val();                          
	                                        
	            $(this).css({'color':'red'});                
	            //excel caculate                
	            var datainfo = $(this).attr('data-info');
	            if(datainfo != undefined){                
	                var infolist = datainfo.split(',');
	                console.log();
	                console.log(infolist[1]);

	                console.log(parseInt(dataafter));
	                var mintt = parseInt($('#'+$.trim(infolist[0])).html());
	                var maxtt = parseInt($('#'+$.trim(infolist[1])).html());
	                if(mintt > dataafter){
	                    bootbox.alert('Số lượng nhập nhỏ hơn hạn mức'); 
	                }else if(maxtt < dataafter){
	                    bootbox.alert('Số lượng nhập lớn hơn hạn mức'); 
	                }
	            }
	            $('#dataTableforecast').calx({
	                readonly: false
	            });
	            dataafter = '';        
	            relid = $(this).attr('rel');                
	            if($('#' + relid).length > 0){ 
	                console.log($('#' + relid).html());                                                   
	                $('#' + $('#' + relid).attr('rel')).val( Math.round($('#' + relid).html()));
	            } 
	            $('#dataTableforecast').calx({
	                readonly: false
	            });                       
	        }           
	    });

	    //excel caculate
		$('.total').each(function(){
			var formula = $(this).attr('rel');
			$(this).attr('data-formula' , formula);
			$(this).removeAttr('rel');
		});
		
	    $('#dataTableforecast').calx();

		$("#fsubmituservalue").click(function(event) {
			/* Act on the event */			
			var url = rooturl + 'stat/report/productcategory/updatedataforecast';	
			$("#fsubmituservalue").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#fsubmituservalue").hide();		
			$.post(url, $("#myform").serialize() , function(data) {
				/*optional stuff to do after success */
				if(data === '1' || data === '-1')
                {
                    showGritterSuccess('Dữ liệu đã được cập nhật.');
                }
                else
                    showGritterError('Dữ liệu không thể cập nhập.');

                $("img.tmp_indicator").remove();
                $("#fsubmituservalue").show();
			});

		});		
	});
</script>
{/literal}