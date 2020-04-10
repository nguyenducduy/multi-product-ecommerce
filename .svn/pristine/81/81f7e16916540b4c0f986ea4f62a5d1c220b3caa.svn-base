{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<input type="hidden" name="ftoken" value="{$smarty.session.forecastcategoryAddToken}" />
<input type="hidden" name="fmonth" value="{$nextmonth}"/>
<input type="hidden" name="fyear" value="{$currentyear}"/>
<input type="hidden" name="fsheet" value="{$sheet}"/>
<div id="dataTable" style="overflow:hidden;">
    {if $isedit == 1}<div style="float:right;margin:5px;"><input type="button" class="btn btn-large btn-primary" name="fsubmituservalue" id="fsubmituservalue" value="Lưu giá trị" /></div>{/if}
	<table class="table table-bordered tablesorter" id="data">
		<thead id="header">
			<tr>
				<td class="colhead"></td>
				<td class="colhead">A</td>
				<td class="colhead">B</td>				
				<td class="colhead">C</td>
				<td class="colhead">D</td>
				<td style="display:none" class="colhead">E</td>
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
				<td style="display:none" class="colhead">R</td>
				<td class="colhead">S</td>
			</tr>
			<tr>
				<td class="colhead" rowspan="2">1</td>
				<td class="colhead" rowspan="2">Siêu thị</td>
				<td class="colhead" colspan="4">Hạn mức</td>
				{foreach item=month from=$last2month}
				<td class="colhead">Tháng {$month}</td>
				{/foreach}
				<td class="colhead" colspan="5">Tháng {$currentmonth}</td>
				<td class="colhead" colspan="5">Tháng {$nextmonth}</td>
			</tr>
			<tr>					
				<td class="colhead">Min</td>				
				<td class="colhead">Ngày Min</td>
				<td class="colhead">Ngày Max</td>
				<td style="display:none" class="colhead">Giá mua vào 1 ({$inputpricedata.inputdate})</td>
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
				<td style="display:none" class="colhead">Lãi gộp 1</td>
				<td class="colhead">Lãi gộp</td>
			</tr>
		</thead>
		<tbody>
			{foreach item=rowdata from=$datalist name=foo1}
			<tr>
				{if $rowdata.sid == 919}
					<td>{$smarty.foreach.foo1.index+2}</td>
					<td colspan="8"><span class="label label-info">{$rowdata.name}</span></td>
					<td><span id="J{$smarty.foreach.foo1.index + 2}">{$rowdata.tonkhohientai}</span></td>
                    <td></td>
                    <td><span id="L{$smarty.foreach.foo1.index + 2}">{$rowdata.tonkhodukien}</span></td>
					<td colspan="6"></td>
				{elseif $rowdata.sid != 5 && $rowdata.sid != 891}		
					<td>{$smarty.foreach.foo1.index+2}</td>
					<td><span class="label label-info">{$rowdata.name}</span>({foreach item=typename key=typeid from=$typelist}{if $rowdata.storetype == $typeid}{$typename}{/if}{/foreach})</td>
					<td><span id="B{$smarty.foreach.foo1.index+2}">{$rowdata.min}<span></td>				
					<td><span id="C{$smarty.foreach.foo1.index+2}">{$rowdata.ngaymin}</span></td>
					<td><span id="D{$smarty.foreach.foo1.index+2}">{$rowdata.ngaymax}</span></td>
					<td style="display:none"><span id="E{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00">{$inputpricedata.inputpricevat}</span></td>
					<td><span id="F{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00">{$inputpriceuserdata.inputpriceuser}</span></td>
					{foreach item=month from=$last2month name=foo}
					<td><span id="{if $smarty.foreach.foo.index==0}G{$smarty.foreach.foo1.index+2}{else}H{$smarty.foreach.foo1.index+2}{/if}">{$rowdata.soluongban.$month|number_format}</span></td>
					{/foreach}
					<td><span id="I{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbanhientai}</span></td>
					<td><span id="J{$smarty.foreach.foo1.index+2}">{$rowdata.tonkhohientai}</span></td>
					<td><span id="K{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandukien}</span></td>
					<td><span id="L{$smarty.foreach.foo1.index+2}">{$rowdata.tonkhodukien}</span></td>				
					<td><span id="M{$smarty.foreach.foo1.index+2}">{$rowdata.tocdo}</span></td>
					{if $isedit == 0}<td><span id="N{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandk.value}</span></td>{else}<td dataid="OO{$smarty.foreach.foo1.index+2}" id="{$rowdata.soluongbandk.name}" class="editable" rel="N{$smarty.foreach.foo1.index+2}">{$rowdata.soluongbandk.value}</td>{/if}

					{if $isedit == 0}<td><span id="O{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</span></td>{else}<td id="{$rowdata.soluongnhapdk.name}" data="notchange" number="{$smarty.foreach.foo1.index+2}" class="editable" rel="O{$smarty.foreach.foo1.index+2}">{$rowdata.soluongnhapdk.value}</td><span style="display:none;" rel="O{$smarty.foreach.foo1.index+2}" class="datanew" id="OO{$smarty.foreach.foo1.index+2}" data-formula="IF(($L{$smarty.foreach.foo1.index+2}-$N{$smarty.foreach.foo1.index+2}) >= $T{$smarty.foreach.foo1.index+2} , 0 , $N{$smarty.foreach.foo1.index+2}-$L{$smarty.foreach.foo1.index+2}+$T{$smarty.foreach.foo1.index+2})"></span>					
					{/if}

					<td><span  id="P{$smarty.foreach.foo1.index+2}" data-formula="$L{$smarty.foreach.foo1.index+2}+$O{$smarty.foreach.foo1.index+2}-$N{$smarty.foreach.foo1.index+2}"></span></td>	

					<td><span id="Q{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="{if $product->finalprice > 0}{$product->finalprice}*$N{$smarty.foreach.foo1.index+2}{else}{$product->sellprice}*$N{$smarty.foreach.foo1.index+2}{/if}"></span></td>

					<td style="display:none"><span id="R{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="$Q{$smarty.foreach.foo1.index+2} - ($N{$smarty.foreach.foo1.index+2} * {$inputpricedata.inputpricereal} )"></span></td>

					<td><span id="S{$smarty.foreach.foo1.index+2}" data-format="0,0[.]00" data-formula="$Q{$smarty.foreach.foo1.index+2} - ($N{$smarty.foreach.foo1.index+2} * $F{$smarty.foreach.foo1.index +2} )"></span></td>

					<span style="display:none;" id="T{$smarty.foreach.foo1.index+2}" data-formula="IF($B{$smarty.foreach.foo1.index+2} > ($C{$smarty.foreach.foo1.index+2} * $M{$smarty.foreach.foo1.index+2}) , $B{$smarty.foreach.foo1.index+2} , ($C{$smarty.foreach.foo1.index+2} * $M{$smarty.foreach.foo1.index+2}) )"></span>

					<span style="display:none;" id="U{$smarty.foreach.foo1.index+2}" data-formula="$D{$smarty.foreach.foo1.index+2} * $M{$smarty.foreach.foo1.index+2}"></span>				
					
				{/if}		
			</tr>
			{/foreach}	
			<tr>
				<td>{$datalist|@count + 2}</td>
				<td colspan="5"><b style="text-align: center;">Grand Total</b></td>
				<td><span class="total" id="G{$datalist|@count}" rel="SUM($G3,$G{$datalist|@count-1})"></span></td>
				<td><span class="total" id="H{$datalist|@count}" rel="SUM($H3,$H{$datalist|@count-1})"></span></td>
				<td><span class="total" id="I{$datalist|@count}" rel="SUM($I3,$I{$datalist|@count-1})"></span></td>
				<td><span class="total" id="J{$datalist|@count}" rel="SUM($J3,$J{$datalist|@count-1})"></span></td>
				<td><span class="total" id="K{$datalist|@count}" rel="SUM($K3,$K{$datalist|@count-1})"></span></td>
				<td><span class="total" id="L{$datalist|@count}" rel="SUM($L3,$L{$datalist|@count-1})"></span></td>
				<td><span class="total" id="M{$datalist|@count}" rel="SUM($M3,$M{$datalist|@count-1})"></span></td>
				<td><span class="total" id="N{$datalist|@count}" rel="SUM($N3,$N{$datalist|@count-1})"></span></td>
				<td><span class="total" id="O{$datalist|@count}" rel="SUM($O3,$O{$datalist|@count-1})"></span></td>
				<td><span class="total" id="P{$datalist|@count}" rel="SUM($P3,$P{$datalist|@count-1})"></span></td>
				<td><span data-format="0,0[.]00" class="total" id="Q{$datalist|@count}" rel="SUM($Q3,$Q{$datalist|@count-1})"></span></td>
				<td style="display:none"><span data-format="0,0[.]00" class="total" id="R{$datalist|@count}" rel="SUM($R3,$R{$datalist|@count-1})"></span></td>
				<td><span data-format="0,0[.]00" class="total" id="S{$datalist|@count}" rel="SUM($S3,$S{$datalist|@count-1})"></span></td>
			</tr>
			<tr>
				<td>{$datalist|@count + 3}</td>
				<td><b class="total">Ngành hàng</b></td>
				<td><span id="B{$datalist|@count +1}" class="total">{$datacategory.min}</span></td>				
				<td><span id="C{$datalist|@count +1}" class="total">{$datacategory.ngaymin}</span></td>
				<td><span id="D{$datalist|@count +1}" class="total">{$datacategory.ngaymax}</span></td>
				<td style="display:none"><span data-format="0,0[.]00" id="E{$datalist|@count + 3}" class="total">{$inputpricedata.inputpricevat}</span></td>
				<td><span data-format="0,0[.]00" id="F{$datalist|@count + 1}" class="total">{$inputpriceuserdata.inputpriceuser}</span></td>
				<td><span class="total" id="G{$datalist|@count+1}" rel="SUM($G3,$G{$datalist|@count-1})"></span></td>
				<td><span class="total" id="H{$datalist|@count+1}" rel="SUM($H3,$H{$datalist|@count-1})"></span></td>
				<td><span class="total" id="I{$datalist|@count+1}" rel="SUM($I3,$I{$datalist|@count-1})"></span></td>
				<td><span class="total" id="J{$datalist|@count+1}" rel="SUM($J2,$J{$datalist|@count-1})"></span></td>
				<td><span class="total" id="K{$datalist|@count+1}" rel="SUM($K3,$K{$datalist|@count-1})"></span></td>
				<td><span class="total" id="L{$datalist|@count+1}" rel="SUM($L2,$L{$datalist|@count-1})"></span></td>
				<td><span class="total" id="M{$datalist|@count+1}" rel="SUM($M3,$M{$datalist|@count-1})"></span></td>
				{if $isedit == 0}<td><span id="N{$datalist|@count +1}">{$datacategory.soluongbandk.value}</span></td>{else}<td dataid="OO{$datalist|@count +1}" id="{$datacategory.soluongbandk.name}" class="editable" rel="N{$datalist|@count +1}">{$datacategory.soluongbandk.value}</td>{/if}

				{if $isedit == 0}<td><span id="O{$datalist|@count +1}">{$datacategory.soluongnhapdk.value}</span></td>{else}<td id="{$datacategory.soluongnhapdk.name}" data="notchange" number="{$datalist|@count +1}" class="editable" rel="O{$datalist|@count +1}">{$datacategory.soluongnhapdk.value}</td><span style="display:none;" rel="O{$datalist|@count +1}" class="datanew" id="OO{$datalist|@count +1}" data-formula="IF(($L{$datalist|@count +1}-$N{$datalist|@count +1}) >= $T{$datalist|@count +1} , 0 , $N{$datalist|@count +1}-$L{$datalist|@count +1}+$T{$datalist|@count +1})"></span>					
				{/if}	

				<td><span  id="P{$datalist|@count +1}" data-formula="$L{$datalist|@count +1}+$O{$datalist|@count +1}-$N{$datalist|@count +1}"></span></td>	

				<td><span id="Q{$datalist|@count +1}" data-format="0,0[.]00" data-formula="{if $product->finalprice > 0}{$product->finalprice}*$N{$datalist|@count +1}{else}{$product->sellprice}*$N{$datalist|@count +1}{/if}"></span></td>

				<td style="display:none"><span id="R{$datalist|@count +1}" data-format="0,0[.]00" data-formula="$Q{$datalist|@count +1} - ($N{$datalist|@count +1} * {$inputpricedata.inputpricereal} )"></span></td>

				<td><span id="S{$datalist|@count+1}" data-format="0,0[.]00" data-formula="$Q{$datalist|@count +1} - ($N{$datalist|@count +1} * {$inputpriceuserdata.inputpriceuser} )"></span></td>

				<span style="display:none;" id="T{$datalist|@count +1}" data-formula="IF($B{$datalist|@count +1} > ($C{$datalist|@count +1} * $M{$datalist|@count +1}) , $B{$datalist|@count +1} , ($C{$datalist|@count +1} * $M{$datalist|@count +1}) )"></span>

				<span style="display:none;" id="U{$datalist|@count + 1}" data-formula="$D{$datalist|@count +1} * $M{$datalist|@count +1}"></span>
			</tr>		
		</tbody>
	</table>
</div>
