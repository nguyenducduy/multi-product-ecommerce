$(document).ready(function(){


	if($('#statdaterange').length)
	{
		$('#statdaterange').daterangepicker(
		    {
		        ranges: {
		            'Today': ['today', 'today'],
		            'Yesterday': ['yesterday', 'yesterday'],
		            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
		            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
		            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
		            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
		        }
		    },
		    function(start, end) {
		        $('#statdaterange span').html(start.toString('dd/MM/yyyy') + ' - ' + end.toString('dd/MM/yyyy'));
				document.location.href = document.location.href + '&dateRangeStart=' + start.getTime()/1000 + '&dateRangeEnd=' + end.getTime()/1000;
		    }
		);

	}

	if($('.customchart').length)
	{
		var customchartUrl = rooturl_stat + $('.customchart').attr('id');

		$('.customchart').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
		$.ajax({
		   type: "GET",
		   dataType: 'html',
		   url: customchartUrl,
		   success: function(html){
				$('.customchart').html(html);
				$('.customchart').find('.tipsy-trigger').tipsy();
				updatefiltertip();
		   }
		 });
	}


	if($('#chartdata').length)
	{
		var chartType = $('#chartdata').attr('data-charttype');
		var data = getPageChartData();
		var xAxisLabel = $('#xaxis').text();
		var yAxisLabel = $('#yaxis').text();
		var xAxisFormat = $('#xaxis').attr('data-format');
		var yAxisFormat = $('#yaxis').attr('data-format');

		if(chartType == 'bar')
		{

			//create chart
			nv.addGraph(function() {
			    var chart = nv.models.lineChart();

				//default is Date format
				if(xAxisFormat.length == 0)
				{
					chart.xAxis.tickFormat(function(d){d *= 1000; return d3.time.format('%d/%m')(new Date(d));});
				}
				else
				{
					chart.xAxis.tickFormat(d3.format(xAxisFormat));
				}

				chart.forceY([0, d3.max(data)]);
			    chart.yAxis.tickFormat(d3.format(yAxisFormat));

				if(data.length == 1)
					chart.showLegend(false);

			    d3.select('#chart1 svg')
			        .datum(data)
			      .transition().duration(500).call(chart);

			    nv.utils.windowResize(chart.update);

			    return chart;
			});
			//end add dynamic chart



			//////////////////
			// show data table, not related to chart
			var tableHtml = '<table width="100%" border="1"><thead><tr><th></th>';
			$('.chartdatadetail').each(function(index){
				tableHtml += '<th style="background:'+chartcolorpalette[index]+'">' + $(this).attr('title') + '</th>';
			});
			tableHtml += '</tr></thead><tbody>';

			var chartcount = data.length;

			//Init total storage
			var dataTotal = new Array();
			for(var i = 0; i < chartcount; i++)
				dataTotal[i] = 0;

			for(var i = data[0].values.length - 1; i >= 0; i--)
			{
				tableHtml += '<tr><td>' + d3.time.format('%d/%m/%Y')(new Date(data[0].values[i].x * 1000)) + '</td>';
				for(var j = 0; j < chartcount; j++)
				{
					tableHtml += '<td>' + numberWithCommas(data[j].values[i].y) + '</td>';
					dataTotal[j] += data[j].values[i].y;
				}
				tableHtml += '</tr>';
			}

			//////////////////
			//append Total
			tableHtml += '<tr class="total"><td>Total</td>';
			for(var i = 0; i < chartcount; i++)
				tableHtml += '<td><big>' + numberWithCommas(dataTotal[i]) + '</big></td>';
			tableHtml += '</tr>';

			//////////////////
			//append Average Value
			tableHtml += '<tr class="average"><td>Average</td>';
			for(var i = 0; i < chartcount; i++)
				tableHtml += '<td><big>' + numberWithCommas(parseInt(dataTotal[i] / data[0].values.length)) + '</big></td>';
			tableHtml += '</tr>';


			tableHtml += '</tbody></table>';


		}
		else if(chartType == 'pie')
		{
			nv.addGraph(function() {
			  var chart = nv.models.pieChart()
			      .x(function(d) { return d.x })
			      .y(function(d) { return d.y })
			      .showLabels(true);

				if(data[0].values.length > 15)
					chart.showLegend(false).showLabels(false);

			    d3.select("#chart1 svg")
			        .datum(data)
			      .transition().duration(1200)
			        .call(chart);

			  return chart;
			});


			//////////////////
			// show data table, not related to chart
			var tableHtml = '<table width="100%" border="0" class="piechart"><thead><tr><th>'+$('.chartcanvas h2').text()+'</th><th></th><th width="100">Visitor</th><th width="100">Percent(%)</th></tr></thead></tbody>';
			var chartcount = data.length;

			////////////////////////////////
			//Start Calculate the TOTAL FIRST
			var dataTotal = new Array();
			for(var i = 0; i < chartcount; i++)
				dataTotal[i] = 0;

			for(var i = 0; i < data[0].values.length; i++)
				for(var j = 0; j < chartcount; j++)
					dataTotal[j] += data[j].values[i].y;
			//End Process TOTAL
			//////////////////////////////

			for(var i = 0; i < data[0].values.length; i++)
			{
				tableHtml += '<tr><td class="pielabel">' + data[0].values[i].x + '</td>';
				for(var j = 0; j < chartcount; j++)
				{
					var percent = roundNumber((data[j].values[i].y / dataTotal[j]) * 100, 2);

					tableHtml += '<td><div class="chartpercentbox"><div class="chartpercentvalue" style="width:'+percent+'%"></div></div></td><td>' + numberWithCommas(data[j].values[i].y) + '</td><td>'+percent+'%</td>';
				}
				tableHtml += '</tr>';
			}

			//////////////////
			//append Total
			tableHtml += '<tr class="total"><td></td><td class="totallabel">Total</td>';
			for(var i = 0; i < chartcount; i++)
				tableHtml += '<td><big>' + numberWithCommas(dataTotal[i]) + '</big></td>';
			tableHtml += '<td>100%</td></tr>';


			tableHtml += '</tbody></table>';

		}
		else
		{
			alert('Chart Type Not Valid');
		}



		$('#chartgrid').html(tableHtml);

	}

	updatefiltertip();


})


function getPageChartData()
{
	//holding all data
	var chartdata = [];
	var index = 0;

	$('.chartdatadetail').each(function(index){
		var chartvalue = [];
		var chartTitle = $(this).attr('title');

		$(this).find('span').each(function(){
			var x = $(this).attr('title');
			var y = parseInt($(this).text());
			chartvalue.push({x:x, y: y});
		});
		chartdata.push({values: chartvalue, key: chartTitle, color: chartcolorpalette[index]});
	});

	return chartdata;

}

var chartcolorpalette = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#aec7e8', '#ffbb78', '#98df8a'];






function filter_by(section, label)
{
	/////////////////////////////////
	//Check valid group filter
	var error = '';
	//1st: Initialize value of filter
	var foriginateregion = '';
	var foriginatestore = '';
	var foutputstore = '';
	var fordertype = '';
	var fvendor = '';
	var fcategory = '';
	var fpid = '';

	//2nd: Get current select filter and update data
	if($('#filteritemvalue_originateregion').length) foriginateregion = $('#filteritemvalue_originateregion').val();
	if($('#filteritemvalue_originatestore').length) foriginatestore = $('#filteritemvalue_originatestore').val();
	if($('#filteritemvalue_outputstore').length) foutputstore = $('#filteritemvalue_outputstore').val();
	if($('#filteritemvalue_ordertype').length) fordertype = $('#filteritemvalue_ordertype').val();
	if($('#filteritemvalue_vendor').length) fvendor = $('#filteritemvalue_vendor').val();
	if($('#filteritemvalue_category').length) fcategory = $('#filteritemvalue_category').val();
	if($('#filteritemvalue_pid').length) fpid = $('#filteritemvalue_pid').val();

	//3rd: Validating
	if(section == 'pid' && (fvendor != '' || fcategory != ''))
		error = 'Bạn không thể xem theo Sản phẩm cụ thể khi đang chọn xem theo Nhà cung cấp hoặc Ngành hàng';
	else if(section == 'vendor' && fpid != '')
		error = 'Bạn không thể xem theo Nhà sản xuất khi đang xem theo một Sản phẩm cụ thể';
	else if(section == 'category' && fpid != '')
		error = 'Bạn không thể xem theo Ngành hàng khi đang xem theo một Sản phẩm cụ thể';
	else if( (section == 'originateregion' || section == 'originatestore' || section == 'outputstore' || section == 'vendor' || section == 'category') && (foriginateregion != '' || foriginatestore != '' || foutputstore != '' || fvendor != '' || fcategory != ''))
		error = 'Bạn không thể chọn xem đồng thời tiêu chí Tỉnh/Thành phố, Kho tạo, Kho xuất, Nhà cung cấp, Ngành hàng';
	else if(foriginateregion == '-1' || foriginatestore == '-1' || foutputstore == '-1' || fordertype == '-1' || fvendor == '-1' || fcategory == '-1')
	{
		//detect output chart/data type
		var numberOfMultiple = 0;

		if(foriginateregion == '-1' || isfiltervaluemultiple(foriginateregion) || foriginatestore == '-1' || isfiltervaluemultiple(foriginatestore) || foutputstore == '-1' || isfiltervaluemultiple(foutputstore) || fvendor == '-1' || isfiltervaluemultiple(fvendor) || fcategory == '-1' || isfiltervaluemultiple(fcategory))
			numberOfMultiple++;

		if(fordertype == '-1' || isfiltervaluemultiple(fordertype))
			numberOfMultiple++;

		if(section == 'pid' && numberOfMultiple == 2)
		{
			error = 'Bạn không thể chọn lọc theo sản phẩm cụ thể cùng với 2 bộ lọc khác';
		}

	}
	//end checking


	if(error.length == 0)
	{
		//boi vi khi chon xem 1 san pham cu the can phai cho chon san pham truoc khi them vao filter list
		if(section == 'pid')
		{



			//ajax popup de chon san pham cu the
			filterpopup_pid();
		}
		else
		{

			$('#filter_'+section+'btn').hide();

			var html = '<div class="filteritem" id="filteritem_'+section+'"><div class="filteritem_value"><a href="javascript:void(0)" onclick="$(this).parent().parent().fadeOut(\'fast\', function(){$(this).remove();updatefiltertip();$(\'#filter_'+section+'btn\').fadeIn()});" title="Bỏ tiêu chí này" class="btn btn-danger btn-mini"><i class="icon-remove"></i></a> <a href="javascript:void(0)" onclick="filterpopup_'+section+'()" class="filtertext">'+label+'</a></div><input type="hidden" id="filteritemvalue_'+section+'" value="-1" /></div>';

			$('#filterlistselected').append(html);
		}

	}
	else
	{
		alert(error);
	}

	updatefiltertip();
}

function updatefiltertip()
{
	var foriginateregion = '';
	var foriginatestore = '';
	var foutputstore = '';
	var fordertype = '';
	var fvendor = '';
	var fcategory = '';
	var fpid = '';

	//2nd: Get current select filter and update data
	if($('#filteritemvalue_originateregion').length) foriginateregion = $('#filteritemvalue_originateregion').val();
	if($('#filteritemvalue_originatestore').length) foriginatestore = $('#filteritemvalue_originatestore').val();
	if($('#filteritemvalue_outputstore').length) foutputstore = $('#filteritemvalue_outputstore').val();
	if($('#filteritemvalue_ordertype').length) fordertype = $('#filteritemvalue_ordertype').val();
	if($('#filteritemvalue_vendor').length) fvendor = $('#filteritemvalue_vendor').val();
	if($('#filteritemvalue_category').length) fcategory = $('#filteritemvalue_category').val();
	if($('#filteritemvalue_pid').length) fpid = $('#filteritemvalue_pid').val();

	//detect output chart/data type
	var numberOfMultiple = 0;

	if(foriginateregion == '-1' || isfiltervaluemultiple(foriginateregion) || foriginatestore == '-1' || isfiltervaluemultiple(foriginatestore) || foutputstore == '-1' || isfiltervaluemultiple(foutputstore))
		numberOfMultiple++;

	if(fordertype == '-1' || isfiltervaluemultiple(fordertype))
		numberOfMultiple++;

	if(fvendor == '-1' || isfiltervaluemultiple(fvendor))
		numberOfMultiple++;

	if(fcategory == '-1' || isfiltervaluemultiple(fcategory))
		numberOfMultiple++;

	var tip = '';
	if(numberOfMultiple == 0)	// 1x1
		tip = 'LINE/BAR chart theo thời gian.';
	else if(numberOfMultiple == 1)	// 1xN
		tip = 'LINE/BAR chart theo thời gian. PIE chart theo tiêu chí có nhiều tùy chọn.';
	else if(numberOfMultiple == 2)	// NxM
		tip = 'Chỉ trả về bảng dữ liệu. Không vẽ được biểu đồ dựa vào 2 tiêu chí cho chọn nhiều tùy chọn.';

	$('#filteroutputtip').html(tip);
}

//check the valud of selected filter, whether it multiple choice
function isfiltervaluemultiple(str)
{
	return (str.indexOf(",") >= 0);
}



function filterpopup_originateregion()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_originateregionwrapper',
		player:     "inline",
		height:     400,
		width:      300
	});
}


function filterpopup_originatestore()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_originatestorewrapper',
		player:     "inline",
		height:     600,
		width:      500
	});
}


function filterpopup_outputstore()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_outputstorewrapper',
		player:     "inline",
		height:     600,
		width:      500
	});
}



function filterpopup_ordertype()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_ordertypewrapper',
		player:     "inline",
		height:     600,
		width:      500
	});
}


function filterpopup_vendor()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_vendorwrapper',
		player:     "inline",
		height:     600,
		width:      500
	});
}


function filterpopup_category()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_categorywrapper',
		player:     "inline",
		height:     600,
		width:      500
	});
}

function filterpopup_pid()
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    '#filteroption_pidwrapper',
		player:     "inline",
		height:     500,
		width:      400
	});
}

function filterpopup_select(section, type)
{
	if(type == 'all')
	{
		$('#filteritemvalue_' + section).val('-1');
		var label = $('#filteroption_'+section+' .filterall input').attr('title');
		$('#filteritem_' + section + ' .filtertext').html(label);

		Shadowbox.close();
	}
	else
	{
		var label = '';
		var value = '';

		$("input:checkbox[name=f"+section+"option]:checked").each(function()
		{
		    // add $(this).val() to your array
			if(value != '')
				value += ',';

			value += $(this).val();

			if(label != '')
				label += ', ';

			label += $(this).attr('title');
		});

		$('#filteritemvalue_' + section).val(value);
		$('#filteritem_'+section+' .filtertext').html(label);
	}

}


function filterpopup_pid_search()
{
	var keyword = $('#filteroption_pid_keyword').val();

	$('#filteroption_pidlist').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl_stat + '/sale/productsearchajax?keyword=' + keyword,
	   success: function(html){
			$('#filteroption_pidlist').html(html);
	   }
	 });
}

function filterpopup_pid_select(pid, name)
{

	if($('#filteritem_pid').length)
	{
		$('#filteritemvalue_pid').val(pid);
		$('#filteritem_pid .filtertext').html(name);
	}
	else
	{
		$('#filter_pidbtn').hide();

		var html = '<div class="filteritem" id="filteritem_pid"><div class="filteritem_value"><a href="javascript:void(0)" onclick="$(this).parent().parent().fadeOut(\'fast\', function(){$(this).remove();updatefiltertip();$(\'#filter_pidbtn\').fadeIn()});" title="Bỏ tiêu chí này" class="btn btn-danger btn-mini"><i class="icon-remove"></i></a> <a href="javascript:void(0)" onclick="filterpopup_pid()" class="filtertext">'+name+'</a></div><input type="hidden" id="filteritemvalue_pid" value="'+pid+'" /></div>';

		$('#filterlistselected').append(html);
	}

}

