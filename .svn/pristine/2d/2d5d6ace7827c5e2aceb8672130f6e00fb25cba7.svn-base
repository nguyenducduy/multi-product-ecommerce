
{if $customchart == ''}
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
		<div id="chartdata" data-charttype="bar" style="display:none;">
			<span id="xaxis" data-format="">Date</span>
			<span id="yaxis" data-format=",d">Number</span>
			
			{foreach name=chartdatalist item=data key=chartname from=$chartData}
			<div class="chartdatadetail" title="{$chartname}" id="chartdatadetail{$smarty.foreach.chartdatalist.iteration}">
				{foreach item=value key=key from=$data}
					<span title="{$key|date_format:"%d/%m"}">{$value}</span>
				{/foreach}
			</div>
			{/foreach}
		</div>
	{/if}
{else}
	<div class="customchart" id="{$customchart}"></div>
{/if}
