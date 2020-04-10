
	
	{include file="notify.tpl" notifyInformation=$error}

	<div class="chartcanvas">
		<div class="chart">
			<h2>{$chartTitle}</h2>
			<div id="chart1" class="chartarea">
				<svg></svg>
			</div><!-- end .chartarea -->
		</div><!-- end .chart -->
	</div><!-- end .chartcanvas -->
	
	{if $chartData|@count > 0}
		<div id="chartdata" data-charttype="{$chartType}" style="display:none;">
			{if $chartType == 'bar'}
				<span id="xaxis" data-format="">Date</span>
				<span id="yaxis" data-format=",d">Number</span>
			{elseif $chartType == 'pie'}
				<span id="xaxis" data-format="">Name</span>
				<span id="yaxis" data-format=",d">Number</span>
			{/if}
			
			{foreach name=chartdatalist item=data key=chartname from=$chartData}
			<div class="chartdatadetail" title="{$chartname}" id="chartdatadetail{$smarty.foreach.chartdatalist.iteration}">
				{foreach item=value key=key from=$data}
					<span title="{$key}">{$value}</span>
				{/foreach}
			</div>
			{/foreach}
		</div>
		
		<div id="chartgrid">
			
		</div>
	{/if}
