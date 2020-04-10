<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Bình luận sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Thống kê bình luận sản phẩm</li>
</ul>

<div class="page-header" rel="menu_productreview"><h1>Thống kê bình luận sản phẩm</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<div>
	Filter theo : 
	{foreach from=$rootcategorylist item=rootcategory}
	<a class="tipsy-trigger" title="Bình luận của {$rootcategory->name}" href="{$conf.rooturl_cms}productreview/index/pcid/{$rootcategory->id}"><span class="label label-info">{$rootcategory->name}</span></a>&nbsp;
	{/foreach}
</div>
<br/>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/tab/1">{$lang.controller.title_list}</a></li>

		<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/tab/3">{$lang.controller.labelModeratorReview}</a></li>

		<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/tab/2">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="active"><a href="#tab4" data-toggle="tab">Thống kê</a></li>
		<!-- <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li> -->		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab4">
			<form action="" method="post" name="manage" class="form-inline">
				Danh mục : 
				<select name="fpcid" id="fpcid">
					<option value="0">Tất cả danh mục</option>
					{foreach item=rootcategory from=$rootcategorylist}
					<option {if $formData.fpcid == $rootcategory->id}selected="selected"{/if} value="{$rootcategory->id}">{$rootcategory->name}</option>
					{/foreach}
				</select>&nbsp;&nbsp;&nbsp;
				Loại : 
				<select name="fstatus" id="fstatus">
					<option value="0">Tất cả</option>					
					{html_options options=$statusList selected=$formData.fstatus}					
				</select>&nbsp;&nbsp;
				Từ <input style="width:100px;" type="text" class="inputdatepicker" name="startdate" id="startdate" value="{$formData.startdate|date_format:'%d/%m/%Y'}"> Đến <input style="width:100px;" type="text" class="inputdatepicker" name="enddate" id="enddate" value="{$formData.enddate|date_format:'%d/%m/%Y'}" />&nbsp;&nbsp;
				<input type="submit" name="fsubmit" value="Xem" class="btn btn-primary" />
			</form>
			<!--start chart-->
			<div id="chartdata" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
			<table id="datatable" style="display:none;">
				<thead>
					<tr>
						<th></th>
						{foreach item=catname from=$pcidlist}
						<th>{$catname}</th>						
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach item=data key=date from=$chartData}
					<tr>
						<th>{$date}</th>
						{foreach item=catname key=catid from=$pcidlist}						
						{assign var=pcid value=$catid}
						<td>{$data.$pcid}</td>
						{/foreach}
					</tr>
					{/foreach}
				</tbody>
			</table>
			<!--end chart-->
		</div>
	</div>
</div>
<script type="text/javascript" src="{$currentTemplate}js/stat/highcharts/highcharts.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/highcharts/modules/data.js"></script>
{literal}
<script type="text/javascript">
	var step = {/literal}{$stepdate}{literal}
	$(document).ready(function() {
		$('.inputdatepicker_help').css('display', 'none');

		$('#chartdata').highcharts({
        data: {
            table: document.getElementById('datatable')
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Thống kê số lượt nhận xét'
        },
        xAxis: {
        	tickInterval: step,								
			startOnTick: false,					
			showLastLabel: true
        },
        yAxis: {
        	min: 0,
            allowDecimals: false,
            title: {
                text: 'Số nhận xét'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} (nhận xét)</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
        }
    });		
	});
</script>
{/literal}