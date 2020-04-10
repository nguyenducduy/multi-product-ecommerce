{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<form id="myformstore" action="" method="post">
	<input type="hidden" name="ftoken" value="{$smarty.session.forecastcategoryAddToken}" />
	<input type="hidden" name="fmonth" value="{$nextmonth}"/>
	<input type="hidden" name="fyear" value="{$currentyear}"/>
	<input type="hidden" name="fsid" value="{$store->id}" />	
	<input type="hidden" name="fsheet" value="{$sheet}" />	
	<input type="hidden" name="datajax" value="1" />
	<div id="dataTableforecast">
		<div style="float:right;margin:5px;"><input type="button" class="btn btn-large btn-primary" name="fsubmituservaluestore" id="fsubmituservaluestore" value="Lưu giá trị" /></div>
		<br/>
		<table class="table table-bordered tablesorter" id="data">
			<thead id="header">
				<tr>
					<td class="colhead"></td>
					<td class="colhead">A</td>
					<td class="colhead">B</td>
					<td class="colhead">C</td>
					<td class="colhead">D</td>
					<td style="display:none;" class="colhead">E</td>
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
					<td class="colhead">AA</td>
					<td class="colhead">U</td>
					<td style="display:none;" class="colhead">V</td>
					<td class="colhead">W</td>
					<td class="colhead">X</td>															
				</tr>	
				<tr>
					<td class="colhead" rowspan="2">1</td>
					<td class="colhead" rowspan="2">Sản phẩm</td>
					<td class="colhead" rowspan="2">Barcode</td>
					<td class="colhead" rowspan="2">Trạng thái</td>
					<td class="colhead" colspan="5">Hạn mức</td>
					{foreach item=month from=$last2month}
					<td class="colhead">Tháng <br/>{$month}</td>
					{/foreach}
					<td class="colhead" colspan="5">Tháng {$currentmonth}</td>
					<td class="colhead" colspan="7">Tháng {$nextmonth}</td>
				</tr>
				<tr>					
					<td class="colhead">Min</td>
					<td style="display:none;" class="colhead">Max</td>
					<td class="colhead">Ngày Min</td>
					<td class="colhead">Ngày Max</td>					
					<td style="display:none;" class="colhead">Giá mua vào 1</td>					
					<td class="colhead">Giá mua vào</td>
					<td class="colhead">Giá bán</td>
					<td class="colhead">SL bán</td>
					<td class="colhead">SL bán</td>
					<td class="colhead">SL bán&nbsp;({$currentdate})</td>
					<td class="colhead">Tồn&nbsp;({$currentdate})</td>
					<td class="colhead">SL Bán DK</td>
					<td class="colhead">Tồn DK</td>
					<td class="colhead">Tốc độ</td>
					<td class="colhead">Siêu thị</td>
					<td class="colhead">SL Bán</td>
					<td class="colhead">SL Nhập</td>
					<td class="colhead">Tốc độ bán dự kiến</td>
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
				<td><a href="{$conf.rooturl}stat/report/productdetail?id={$rowdata.id}" target="_blank" title="{$rowdata.name}" class="tipsy-trigger"><span style="width: 115px;display: block;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" class="label label-info">{$rowdata.name}</span></a></td>
				<td>{$rowdata.barcode}</td>
				<td>{$rowdata.bussinessstatus}</td>
				<td><span id="D{$smarty.foreach.foo1.index+2}">{$rowdata.min}</span></td>
				<td style="display:none;">{$rowdata.max}</td>
				<td><span id="F{$smarty.foreach.foo1.index+2}">{$rowdata.ngaymin}</span></td>
				<td><span id="G{$smarty.foreach.foo1.index+2}">{$rowdata.ngaymax}</span></td>
				<td style="display:none;"><span data-format="0,0[.]00" id="H{$smarty.foreach.foo1.index+2}">{$rowdata.inputpricevat}</span><br/>({$rowdata.inputdate})</td>
				<td><span data-format="0,0[.]00" id="I{$smarty.foreach.foo1.index+2}">{$rowdata.inputpriceuser}</span></td>
				<td><span data-format="0,0[.]00" id="J{$smarty.foreach.foo1.index+2}">{if $rowdata.finalprice > 0}{$rowdata.finalprice}{else}{$rowdata.sellprice}{/if}</span></td>
				{foreach item=month from=$last2month name=foo}
				<td><span id="{if $smarty.foreach.foo.index==0}K{$smarty.foreach.foo1.index+2}{else}L{$smarty.foreach.foo1.index+2}{/if}">{$rowdata.soluongban.$month|number_format}</span></td>
				{/foreach}
				<td><span id="M{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbanhientai}</span></td>
				<td><span id="N{$smarty.foreach.foo1.index+2}">{$rowdata.tonkhohientai}</span></td>
				<td><span id="O{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandukien}</span></td>					
				<td><span id="P{$smarty.foreach.foo1.index+2}">{$rowdata.tonkhodukien}</span></td>
				<td><span id="Q{$smarty.foreach.foo1.index+2}">{$rowdata.tocdo}</span></td>
				<td><a rel="{$conf.rooturl}stat/report/productdetail/forecastproductajax?id={$rowdata.id}" href="javascript:void(0)" class="viewpopup"><span id="R{$smarty.foreach.foo1.index+2}" class="label label-info">{$rowdata.tongsoluongbansieuthi}</span></a></td>	
				{if $isedit == 0}
				<td>
					<span id="$S{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandk.value}</span>
				</td>
				{else}
				<td id="{$rowdata.soluongbandk.name}" class="editable" rel="S{$smarty.foreach.foo1.index+2}" info="TTTT{$smarty.foreach.foo1.index + 2}" dataid="TT{$smarty.foreach.foo1.index+2}" datarel="TTT{$smarty.foreach.foo1.index+2}" dataself="SS{$smarty.foreach.foo1.index + 2}">{$rowdata.soluongbandk.value}</td><span style="display:none;" id="SS{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandk.value}</span>
				{/if}
			
				{if $isedit == 0}
					<td>
						<span id="$T{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</span>
					</td>
				{else}
					<td id="{$rowdata.soluongnhapdk.name}" class="editable" rel="T{$smarty.foreach.foo1.index+2}" data="notchange" datarel="TTT{$smarty.foreach.foo1.index+2}" dataself="TTTT{$smarty.foreach.foo1.index+2}" datainfo="Y{$smarty.foreach.foo1.index+2} , Z{$smarty.foreach.foo1.index+2}" datatype="1">{$rowdata.soluongnhapdk.value}</td>
					<span style="display:none;" info="TTTT{$smarty.foreach.foo1.index+2}" rel="T{$smarty.foreach.foo1.index+2}" class="datanew" id="TT{$smarty.foreach.foo1.index+2}" data-formula="$S{$smarty.foreach.foo1.index+2} - $P{$smarty.foreach.foo1.index+2} + $Y{$smarty.foreach.foo1.index+2}"></span>
					<span style="display:none;" id="TTT{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</span>
					<span style="display:none;" id="TTTT{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</span>
				{/if}
				
				<td><span data-format="0.00" id="A{$smarty.foreach.foo1.index+2}" data-formula="$S{$smarty.foreach.foo1.index+2}/{$numberdayofnextmonth}"></span></td>
				
				<td><span id="U{$smarty.foreach.foo1.index+2}" data-formula="$P{$smarty.foreach.foo1.index+2} + $T{$smarty.foreach.foo1.index+2} - $S{$smarty.foreach.foo1.index+2}"></span></td>	
				<td style="display:none"><span id="V{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula=""></span></td>
				<td><span id="W{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="$J{$smarty.foreach.foo1.index+2} * $S{$smarty.foreach.foo1.index+2}"></span></td>
				<td><span id="X{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="$W{$smarty.foreach.foo1.index+2} - ($I{$smarty.foreach.foo1.index+2} * $S{$smarty.foreach.foo1.index+2})"></span></td>
				
				<span style="display:none;" id="Y{$smarty.foreach.foo1.index+2}" data-formula="IF($D{$smarty.foreach.foo1.index+2} > ($F{$smarty.foreach.foo1.index+2} * $A{$smarty.foreach.foo1.index+2}) , $D{$smarty.foreach.foo1.index+2} , ($F{$smarty.foreach.foo1.index+2} * $A{$smarty.foreach.foo1.index+2}) )"></span>

				<span style="display:none;" id="Z{$smarty.foreach.foo1.index+2}" data-formula="$G{$smarty.foreach.foo1.index+2} * $AA{$smarty.foreach.foo1.index+2}"></span>				
			</tr>
			{/foreach}
			<tr>
					<td>{$datalist|@count + 2}</td>
					<td colspan="8"><b style="text-align: center;">Total</b></td>															
					<td><span class="total" id="K{$datalist|@count + 2}" rel="SUM($K2,$K{$datalist|@count+1})"></span></td>
					<td><span class="total" id="L{$datalist|@count + 2}" rel="SUM($L2,$L{$datalist|@count+1})"></span></td>
					<td><span class="total" id="M{$datalist|@count + 2}" rel="SUM($M2,$M{$datalist|@count+1})"></span></td>
					<td><span class="total" id="N{$datalist|@count + 2}" rel="SUM($N2,$N{$datalist|@count+1})"></span></td>
					<td><span class="total" id="O{$datalist|@count + 2}" rel="SUM($O2,$O{$datalist|@count+1})"></span></td>
					<td><span class="total" id="P{$datalist|@count + 2}" rel="SUM($P2,$P{$datalist|@count+1})"></span></td>
					<td><span class="total" id="Q{$datalist|@count + 2}" rel="SUM($Q2,$Q{$datalist|@count+1})"></span></td>
					<td><span class="total" id="R{$datalist|@count + 2}" rel="SUM($R2,$R{$datalist|@count+1})"></span></td>
					<td><span class="total" id="S{$datalist|@count + 2}" rel="SUM($S2,$S{$datalist|@count+1})"></span></td>
					<td><span class="total" id="T{$datalist|@count + 2}" rel="SUM($T2,$T{$datalist|@count+1})"></span></td>					
					<td><span class="total" data-format="0.00" id="A{$datalist|@count + 2}" rel="SUM($A2,$A{$datalist|@count+1})"></span></td>					
					<td><span class="total" id="U{$datalist|@count + 2}" rel="SUM($U2,$U{$datalist|@count+1})"></span></td>										
					<td><span data-format="0,0[.]00" class="total" id="W{$datalist|@count + 2}" rel="SUM($W2,$W{$datalist|@count+1})"></span></td>
					<td><span data-format="0,0[.]00" class="total" id="X{$datalist|@count + 2}" rel="SUM($X2,$X{$datalist|@count+1})"></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</form>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".viewpopup").click(function(){
            url = $(this).attr('rel');
            if(url.length > 0){
                Shadowbox.open({
                    content:    url,
                    title : "Chi tiết siêu thị forecast",
                    player:     "iframe" 
                });
            }    
        });
        
		loadeditable('dataTableforecast');

		$('.datainput').keypress(function(e) {        
		        //check element is exist       
		        var dataafter = '';
		         //if press enter   or press tab        
		        if(e.which === 13 || e.keyCode === 13) {                         
		            e.preventDefault();                   
		            dataafter = $(this).val();                
		            var datarel = $(this).attr('datarel');
		            var datatype = $(this).attr('datatype');

		            var dataself = $(this).attr('dataself');
		            
		            if(dataself !== undefined)
		            {
		                var databefore = $('#' + dataself).html();
		            }                           			
		            $(this).css({'color':'red'});                
		            //excel caculate                
		            var datainfo = $(this).attr('data-info');            
		            if(databefore !== dataafter){				
		                if(datainfo !== undefined){    							
		                    var infolist = datainfo.split(',');                                
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
						$("#"+dataself).html(dataafter);
						relid = $(this).attr('rel');
						if ($('#' + relid).length > 0) {
							$('#' + $('#' + relid).attr('rel')).val(Math.round($('#' + relid).html()));							
							
							var info = $(this).attr('info');
							if($('#' + info).length > 0){
								$('#' + info).html(Math.round($('#' + relid).html()));
							}
						}											

						if ($('#' + datarel).length > 0) {
							if (datatype !== undefined) {
								$('#' + datarel).html(dataafter);
							} else {
								$('#' + datarel).html(Math.round($('#' + relid).html()));
							}
						}								
						
						dataafter = '';
						databefore = '';
						$('#dataTableforecast').calx({
							readonly: false
						});
		            }                                                                  
		        }           
		    });

		    
		    $('.datainput').blur(function(e) {        
		        $(this).css({'color':'blue'});    
		        //check element is exist       
		        var dataafter = '';
		        e.preventDefault();                   
		        dataafter = $(this).val();                
				var datarel = $(this).attr('datarel');
				var datatype = $(this).attr('datatype');

				var dataself = $(this).attr('dataself');

				if(dataself !== undefined)
				{
					var databefore = $('#' + dataself).html();
				}                           			
				$(this).css({'color':'red'});                
				//excel caculate                
				var datainfo = $(this).attr('data-info');            
				if(databefore !== dataafter){				
					if(datainfo !== undefined){    							
						var infolist = datainfo.split(',');                                
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
					$("#"+dataself).html(dataafter);
					relid = $(this).attr('rel');
					if ($('#' + relid).length > 0) {
						$('#' + $('#' + relid).attr('rel')).val(Math.round($('#' + relid).html()));							

						var info = $(this).attr('info');
						if($('#' + info).length > 0){
							$('#' + info).html(Math.round($('#' + relid).html()));
						}
					}											

					if ($('#' + datarel).length > 0) {
						if (datatype !== undefined) {
							$('#' + datarel).html(dataafter);
						} else {
							$('#' + datarel).html(Math.round($('#' + relid).html()));
						}
					}								

					dataafter = '';
					databefore = '';
					$('#dataTableforecast').calx({
						readonly: false
					});
				}                            
		    });

		$('.datainput').focus(function(){
		    $(this).css('color' , '');
		});

	   	$('#dataTableforecast').freezeHeader();
		
		//excel caculate
		$('.total').each(function(){
			var formula = $(this).attr('rel');
			$(this).attr('data-formula' , formula);
			$(this).removeAttr('rel');
		});
		
	    $('#dataTableforecast').calx();

		$("#fsubmituservaluestore").click(function(event) {
			/* Act on the event */			
			var url = rooturl + 'stat/report/productcategory/updatedataforecast';	
			$("#fsubmituservalue").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#fsubmituservalue").hide();		
			$.post(url, $("#myformstore").serialize() , function(data) {
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
