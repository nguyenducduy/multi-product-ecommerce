<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject">List Project</a> {if {$formData.iterationid} > 0} <span class="divider"> /</span><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject/detail/spid/{$formData.iterationid}"> Project Detail </a>{/if} <span class="divider"> /</span> </li>
    <li class="active">List Story<span class="divider">/</span> </li>
</ul>


<div class="page-header" rel="menu_scrumstory">
    <h1><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/spid/{$projectId}">{$currentProjectName}</a>
    {if $scrumIteraction} / <a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/spid/{$projectId}/siid/{$scrumIteraction}">{$scrumIterationName}</a>{/if}</h1>    
</div>

{if $countStatusList|@count > 0}
<p class="countbox">
{foreach from=$countStatusList item=status}
<a href="{$paginateurl}fstatus/{$status.statusid}" style="float: left;">
    <span class="countnum">{$status.storynumber}</span><br />
    <span class="counttext">{$status.statustext}</span>
</a>
{/foreach}
</p>
{/if}

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>

        {if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/spid/{$projectId}">{$lang.default.formViewAll}</a></li>
		{/if}
        {if {$formData.permiss}=='1'}
             <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/siid/{$sprintid}">{$lang.controller.head_add}</a></li>
        {/if}
        <li><a href="#tab3" data-toggle="tab">Chart</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumstoryBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumstorys|@count > 0}
                
					<thead>
						<tr>

                            {if !$scrumIteraction}
							<th>{$lang.controller.labelSiid}</th>
                            {/if}
							<th><a href="{$filterUrl}sortby/asa/sorttype/{if $formData.sortby eq 'asa'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStory}</a></th>
                            <th>Project name</th>
                            <th><a href="{$filterUrl}sortby/categoryid/sorttype/{if $formData.sortby eq 'categoryid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCategoryid}</a></th>
                            <th>Project Session</th>
                            <th>{$lang.controller.labelAssignee}</th>
                            <th><a href="{$filterUrl}sortby/point/sorttype/{if $formData.sortby eq 'point'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPoint}</a></th>
							<th>{$lang.controller.labelPriority}</th>
							<th>Hard Level</th>
                            <th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							<th width="140"></th>
						</tr>
					</thead>

					<tbody>
					{foreach item=scrumstory from=$scrumstorys}
		
						<tr>

							{if !$scrumIteraction}
							    <td><strong>{if $scrumstory->iterationName!=''}{$scrumstory->iterationName}{else}BackLog{/if}</strong></td>
                            {/if}
                            
							<td><span><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/detail/id/{$scrumstory->id}">{$scrumstory->asa}</a></span></td>
                            <td>{$scrumstory->projectname}</td>
                            <td>{if $scrumstory->storycategoryName!=''}<span class="label">{$scrumstory->storycategoryName}</span>{else}-{/if}</td>
                            <td>{$scrumstory->sessionname}</td>
                            <td>{if $scrumstory->countassignee!=''}<a class="badge label-info" href ="{$conf.rooturl}{$controllerGroup}/scrumstoryasignee/index/ssid/{$scrumstory->id}">{$scrumstory->countassignee}</a>{else}-{/if}</td>
							<td><span class="badge">{$scrumstory->point}</span></td>



							<td><span class="badge">{if $scrumstory->prioritytext!=''}{$scrumstory->prioritytext}{else}-{/if}</span></td>
                            <td><span class="badge">{$scrumstory->hardlevel}</span></td>

                            <td>
                                <span id="status_{$scrumstory->id}">
                                    {$scrumstory->statusname}
                                </span>
                            </td>
							
							<td>
                                {if {$formData.permiss}=='1'}
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$scrumstory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$scrumstory->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
								{/if}
							</td>
						</tr>                                                                                                                                
			    

					{/foreach}
					</tbody>
		
	  
				{else}
					<tr>
						<td colspan="{if !$scrumIteraction}9{else}10{/if}"> {$lang.default.notfound}</td>
					</tr>
				{/if}
	
				</table>
			</form>

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelSpid}: <input type="text" name="fspid" id="fspid" value="{$formData.fspid|@htmlspecialchars}" class="input-mini" /> - 
				
				<!--{$lang.controller.labelAsa}: <input type="text" name="fasa" id="fasa" value="{$formData.fasa|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIwant}: <input type="text" name="fiwant" id="fiwant" value="{$formData.fiwant|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelTag}: <input type="text" name="ftag" id="ftag" value="{$formData.ftag|@htmlspecialchars}" class="input-mini" /> - -->

				{$lang.controller.labelPoint}: <input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCategoryid}: <input type="text" name="fcategoryid" id="fcategoryid" value="{$formData.fcategoryid|@htmlspecialchars}" class="input-mini" /> - 

				<!--{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" />-->

				<br /><br />
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="asa" {if $formData.fsearchin eq "asa"}selected="selected"{/if}>{$lang.controller.labelAsa}</option>
					<option value="iwant" {if $formData.fsearchin eq "iwant"}selected="selected"{/if}>{$lang.controller.labelIwant}</option>
					<option value="tag" {if $formData.fsearchin eq "tag"}selected="selected"{/if}>{$lang.controller.labelTag}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->


        <div class="tab-pane" id="tab3">
            <!--start chart-->
            <div id="linechart" style="min-width: 1000px; height: 400px; margin: 0 auto"></div>
            <!--end of chart-->
            {if $chartiteration|@count > 0}
                <div id="chartdata" data-charttype="line" style="display:none;" charttitle="Chart Story">
                    <span id="xaxis" data-format="">Date</span>
                    <span id="yaxis" data-format=",d">Number Story</span>
                    {foreach name=chartdatalist item=data key=chartname from=$chartiteration}
                        <div class="chartdatadetail" title="{$chartname}" id="chartdatadetail{$smarty.foreach.chartdatalist.iteration}">
                            {foreach item=value key=key from=$data}
                                <span title="{$key}">{$value}</span>
                            {/foreach}
                        </div>
                    {/foreach}
                </div>
            {/if}
        </div>
	</div>
</div>


<script type="text/javascript" src="{$currentTemplate}js/stat/highcharts/highcharts.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/site/numeral.js"></script>
{literal}

<script type="text/javascript">
    var statusset = 0;
    function changestatus(id,status)
    {
        var url = '/admin/scrumstory/indexAjax';
        statusset = status;
        $.ajax({
            type : "POST",
            data : {siid:id,statuschange:status,action:"changestatus",contents:"aaa"},
            url : url,
            dataType: "html",
            success: function(data){
                if(data.trim()!='not')
                   $('#status_'+id).html(data);

            }
        });
    }
    //var step = 7;
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/scrumstory/index";
		

		var spid = $('#fspid').val();
		if(spid.length > 0)
		{
			path += '/spid/' + spid;
		}

		/*var asa = $('#fasa').val();
		if(asa.length > 0)
		{
			path += '/asa/' + asa;
		}

		var iwant = $('#fiwant').val();
		if(iwant.length > 0)
		{
			path += '/detai/' + iwant;
		}

		var tag = $('#ftag').val();
		if(tag.length > 0)
		{
			path += '/tag/' + tag;
		}*/

		var point = $('#fpoint').val();
		if(parseInt(point) > 0)
		{
			path += '/point/' + point;
		}

		var categoryid = $('#fcategoryid').val();
		if(categoryid.length > 0)
		{
			path += '/categoryid/' + categoryid;
		}

		/*var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}*/
		
		var keyword = $("#fkeyword").val();
		if(keyword.length > 0)
		{
			path += "/keyword/" + keyword;
		}

		var keywordin = $("#fsearchin").val();
		if(keywordin.length > 0)
		{
			path += "/searchin/" + keywordin;
		}
		
		document.location.href= path;
	}

    function getPageChartDataY()
    {
        //holding all data
        var chartdata = [];
        var index = 0;

        $('.chartdatadetail').each(function(index){
            var chartvalue = [];
            var chartTitle = $(this).attr('title');

            $(this).find('span').each(function(){
                var y = parseInt($(this).text());
                chartvalue.push({y: y});
            });
            chartdata.push({data: chartvalue, name: chartTitle});
        });
        return chartdata;

    }

    function getPageChartDataX()
    {
        //holding all data
        var chartdata = [];

        $('.chartdatadetail').each(function(){
            var chartvalue = [];
            var chartTitle = $(this).attr('title');

            $(this).find('span').each(function(){
                var x = $(this).attr('title');
                chartdata.push(x);
            });
        });

        return chartdata;

    }

    $(function () {


        //excel caculate

        if($('#chartdata').length)
        {
            var chartType = $('#chartdata').attr('data-charttype');
            var chartType1 = $('#chartdata1').attr('data-charttype');
            var chartTitle = $('#chartdata').attr('charttitle');
            var chartby = $('#chartby').val();

            //tuy chinh cach chia don vi cho truc Y cua highcharts
            var yAxisData = [];

            //     if(chartby == 'volume')
            //     {
            //         yAxisData.push({title:{text: yAxisLabel} , min: 0,startOnTick: false , tickInterval: 1, labels: {enabled: true,formatter: function() {return numeral(this.value).format('0,0');}},plotLines: [{value: 0,width: 1,color: '#808080'}] , lineColor: '#FF0000',
            // lineWidth: 1,});
            //     }
            //     else
            //     {
            //        yAxisData.push({title:{text: yAxisLabel} , min: 0,startOnTick: false , tickPixelInterval : 40, labels: {enabled: true,formatter: function() {return numeral(this.value).format('0,0');}},plotLines: [{value: 0,width: 1,color: '#808080'}] , lineColor: '#FF0000',
            // lineWidth: 1,});
            //     }

            yAxisData.push({title:{text: yAxisLabel} , min: 0,startOnTick: false , tickPixelInterval : 40, labels: {enabled: true,formatter: function() {return numeral(this.value).format('0,0');}},plotLines: [{value: 0,width: 1,color: '#808080'}] , lineColor: '#FF0000',lineWidth: 1,});

            //line chart
            if(chartType == 'line')
            {
                var dataY = getPageChartDataY();
                var dataX = getPageChartDataX();
                var xAxisLabel = $('#xaxis').text();
                var yAxisLabel = $('#yaxis').text();

                $('#linechart').highcharts({
                    chart: {
                        type: 'line',
                        zoomType: 'xy',
                        borderWidth: 2
                    },
                    credits: {
                        enabled: true,
                        text : 'dienmay.com',
                        href: rooturl
                    },
                    title: {
                        text: chartTitle,
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'Source: dienmay.com',
                        x: -20
                    },
                    xAxis: {
                        type: "datetime",
                        title : {
                            text : xAxisLabel
                        },
                        //tickInterval: step,
                        startOnTick: false,
                        showLastLabel: true,
                        categories : dataX
                    },
                    yAxis: yAxisData ,

                    tooltip: {
                        //valueSuffix: 'VND'
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series : dataY
                });
            }

            if(chartType1 == 'pie')
            {
                var data = getPieChartData();

                $('#piechart').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },

                    credits: {
                        enabled: true,
                        text : 'dienmay.com',
                        href: rooturl
                    },
                    title: {
                        text: chartTitle,
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'Source: dienmay.com',
                        x: -20
                    },

                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },

                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                color: '#000000',
                                connectorColor: '#000000',
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            },
                            showInLegend: true
                        }
                    },

                    series: [{
                        type: 'pie',
                        name: chartby,
                        data: data
                    }]
                });
            }
        }
    });
</script>
{/literal}
			
			


