<script type="text/javascript" src="{$currentTemplate}js/stat/nvd3/lib/d3.v2.min.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/nvd3/stream_layers.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/nvd3/nv.d3.min.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/date.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" src="{$currentTemplate}css/stat/daterangepicker.css" />

<div class="page-header" rel="menu_stat_list"><h1>Website Statistics</h1></div>





<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Charts</a></li>
		<li class="pull-right"><a class="btn btn-success" href="javascript:delm('http://{$conf.rooturl_cms}stat/collector');">Run Stat collector</a></li>
		<li class="pull-right"><a class="btn btn-success" href="javascript:void(0)"><i class="icon-plus"></i> Append More Chart</a></li>
		<li class="pull-right">
			<div id="reportrange" class="pull-right">
			    <i class="icon-calendar icon-large"></i>
			    <span>{$dateRangeStart|date_format:"%B %d, %Y"} - {$dateRangeEnd|date_format:"%B %d, %Y"}</span> <b class="caret"></b>
			</div>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			
			<!-- start chart group -->
			<div class="chartcanvas">
				<div class="charttool">
					<div class="editbox">
						<div class="lite"><a href="javascript:void(0)" onclick="$(this).parent().parent().find('.editboxchild').toggle();$(this).parent().parent().toggleClass('editboxwide')"><i class="icon-pencil"></i> Change</a></div>
						<div class="full editboxchild hide form-horizontal form-inline">
							<div class="item">Start</div> 
							<div class="input"><input type="text" class="time timestart inputdatepickersmall" size="10" /></div>

							<div class="item">End</div> 
							<div class="input"><input type="text" class="time timeend inputdatepickersmall" size="10" /></div>
							
							<div class="item">Style</div> 
							<div class="input">
								<select class="style">
									<option value="line">Line Chart</option>
									<option value="bar">Bar Chart</option>
									<option value="pie">Pie Chart</option>
								</select>
							</div>
							
							
						</div><!-- end .full -->
					</div><!-- end .editbox -->
				</div><!-- end .charttool -->
				<div class="chart">
					<h2>Product View</h2>
					<div id="chart1" class="chartarea">
						<svg></svg>
					</div><!-- end .chartarea -->
				</div><!-- end .chart -->
			</div><!-- end .chartcanvas -->
			
			<div id="morechart">
			</div><!-- end #morechart -->
			
		</div><!-- end #tab 1 -->
	</div>
</div>

{literal}
<script type="text/javascript">
	
	
	
	
	nv.addGraph(function() {
	    var chart = nv.models.multiBarChart();

	    chart.xAxis
	        .tickFormat(d3.format(',f'));

	    chart.yAxis
	        .tickFormat(d3.format(',.1f'));
	

	    d3.select('#chart1 svg')
	        .datum(exampleData())
	      .transition().duration(500).call(chart);

	    nv.utils.windowResize(chart.update);

	    return chart;
	});




	function exampleData() {
	  return stream_layers(3,10+Math.random()*100,.1).map(function(data, i) {
	    return {
	      key: 'Stream' + i,
	      values: data
	    };
	  });
	}

</script>
{/literal}

