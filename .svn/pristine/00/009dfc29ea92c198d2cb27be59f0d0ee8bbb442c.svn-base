{include file="_controller/stat/product/headerstat.tpl"}
    	<div style="width: 850px;margin: 0px auto;">
    		<form action="" method="get">
    		<table class="table">
    				<tr><td style="border: none;">Filter by Date: </td>
    					<td style="border: none;"><input type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$startdate}"> -> <input type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$enddate}"></td>
    				</tr>
    				<tr><td style="border: none;">Filter by Date: </td>
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
    		</table>
    		</form>
    		<p align="center"><input type="button" class="btn" name="view" value="XEM" /></p><br />
    		<table width="100%">
    			<tr>
    				<td width="50%">
    					<table class="table table-bordered">
    						<tr>
    							<td width="30%">Trạng thái: </td><td>{$sstatusproduct}</td>
    						</tr><tr>
    							<td>Vai trò: </td><td>{$sskuroleproduct}</td>
    						</tr><tr>
    							<td>Nhóm: </td><td>{$snhom}</td>
    						</tr><tr>
    							<td>Ranking: </td><td>{$sranking}</td>
    						</tr><tr>
    							<td>SL thực bán: </td><td>{$sslthucban}</td>
    						</tr><tr>
    							<td>Trả lại: </td><td>{$stralai}</td>
    						</tr><tr>
    							<td>Doanh thu: </td><td>{$sdoanhthu}</td>
    						</tr><tr>
    							<td>Lãi gộp: </td><td>{$slaigop}</td>
    						</tr><tr>
    							<td>Điểm chuẩn: </td><td>{$sdiemchuan}</td>
    						</tr><tr>
    							<td>Tổng điểm thưởng: </td><td>{$stongdiemthuong}</td>
    						</tr><tr>
    							<td>Giá bán TB: </td><td>{$sgiabantb}</td>
    						</tr><tr>
    							<td>Giá vốn TB: </td><td>{$sgiavontb}</td>
    						</tr><tr>
    							<td>Tồn kho: </td><td>{$stonkho}</td>
    						</tr><tr>
    							<td>Tốc độ bán TB: </td><td>{$stocdoban}</td>
    						</tr><tr>
    							<td>Ngày tồn kho: </td><td>{$sngaytonkho}</td>
    						</tr><tr>
    							<td>Nhập trong kỳ: </td><td>{$snhaptrongky}</td>
    						</tr><tr>
    							<td>Ngày cao điểm: </td><td>{$sngaycaodiem}</td>    					
    						</tr>
    					</table>
    				</td>
    				<td>
    					<div id="chartgrid">CHART</div>
    				</td>
    			</tr>
    		</table><br />
    		<div id="dataTable" class="handsontable"></div>
    	</div>

<script type="text/javascript" src="{$currentTemplate}js/stat/forecastdefinecolumn.js"></script>
{literal}
<script type="text/javascript">
	var columns = {/literal}{$schema.columns}{literal}
    var colHeaders = {/literal}{$schema.colHeaders}{literal}
    var colWidths = {/literal}{$schema.colWidths}{literal}
    var data = {/literal}{$datahandson}{literal}
	/*var pid = {/literal}{$myProduct->id}{literal}
	$(document).ready(function() {
		$('#topheadstat').css('margin-top' , '-10px');
	});
	function viewShadowbox(url , name, type)
	{
		if(url.length > 0)
		{
			Shadowbox.open({
                    content:    url,
                    title : 	'',
                    player:     "iframe",
                    height:     500,
                    width:      1000
                });
		}
	}

	function viewdata()
	{
		var startdate = $('#startdate').val();
		var enddate = $('#enddate').val();
		var urlprocess = rooturl_stat + 'product/info?id='+pid+'&type=productdetail&view=1&startdate='+startdate+'&enddate='+enddate;
        
        window.location.href = urlprocess;        
	}*/
</script>
{/literal}
<script type="text/javascript" src="{$currentTemplate}js/stat/forecastproductcategory.js"></script>
{include file="_controller/admin/footer.tpl"}
