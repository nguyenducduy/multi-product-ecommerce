{if $datalist|@count > 0}
<div style="float:right;"><input class="btn btn-primary" type="button" id="fsave" name="fsave" value="Lưu" /></div><br/>
<div>
	<input type="hidden" name="ftoken" value="{$smarty.session.storeconfigAddToken}" />
	<input type="hidden" name="fsheet" value="{$fsheet}" />
	<table class="table table-bordered tablesorter" style="overflow:none;" id="data">
		<thead>
			<tr>
				<th style="vertical-align: top;" rowspan="2">Sản phẩm</th>
				<th style="vertical-align: top;" rowspan="2">Barcode</th>
				<th style="vertical-align: top;" rowspan="2">Trạng thái</th>
				<th style="vertical-align: top;" rowspan="2">Giá mua vào</th>
				{foreach item=typename from=$storetypelist}
				<th colspan="3">Hạn mức {$typename}</th>
				{/foreach}
			</tr>
			<tr>
				<th>Min</th>
				<th>Ngày Min</th>
				<th>Ngày Max</th>
				<th>Min</th>
				<th>Ngày Min</th>
				<th>Ngày Max</th>
				<th>Min</th>
				<th>Ngày Min</th>
				<th>Ngày Max</th>
				<th>Min</th>
				<th>Ngày Min</th>
				<th>Ngày Max</th>
			</tr>
		</thead>
		<tbody>
			{foreach item=datarow from=$datalist}
			<tr>
				<td><a href="javascript:void(0)" class="tipsy-trigger" title="{$datarow.name}"><span style="width: 100px;display: block;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" class="label label-info">{$datarow.name}<span></a></td>
				<td><span class="label label-success">{$datarow.barcode}</span></td>
				<td>{$datarow.bussinessstatus}</td>
				<td><input style="width:80px !important;-moz-box-sizing: inherit;color: #0000FF;padding: 0px;width: 80px;" name="fdataforecast[{$datarow.gianhapmua.name}]" value="{$datarow.gianhapmua.value}"/></td>
				{foreach item=typename key=typeid from=$storetypelist}				
				<td><input style="width:50px !important;-moz-box-sizing: inherit;color: #0000FF;padding: 0px;width: 80px;" name="fdataforecast[{$datarow.$typeid.min.name}]" value="{$datarow.$typeid.min.value}"/></td>
				<td><input style="width:50px !important;-moz-box-sizing: inherit;color: #0000FF;padding: 0px;width: 80px;" name="fdataforecast[{$datarow.$typeid.ngaymin.name}]" value="{$datarow.$typeid.ngaymin.value}"/></td>
				<td><input style="width:50px !important;-moz-box-sizing: inherit;color: #0000FF;padding: 0px;width: 80px;" name="fdataforecast[{$datarow.$typeid.ngaymax.name}]" value="{$datarow.$typeid.ngaymax.value}"/></td>
				{/foreach}
			</tr>
			{/foreach}
		</tbody>
	</table>
</div>
{else}
Không tìm thấy thông tin mà bạn yêu cầu
{/if}
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$("#data").freezeHeader(); 
		$("#fsave").click(function(event) {
			/* Act on the event */			
			var url = rooturl_cms + 'storeconfig/updatedataforecast';	
			$("#fsave").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#fsave").hide();		
			$.post(url, $("#productdata").serialize() , function(data) {
				/*optional stuff to do after success */
				//console.log(data);
				if(data === '1' || data === '-1')
                {
                    showGritterSuccess('Dữ liệu đã được cập nhật.');
                }
                else
                    showGritterError('Dữ liệu không thể cập nhập.');

                $("img.tmp_indicator").remove();
                $("#fsave").show();
			});
		});
	});
</script>
{/literal}