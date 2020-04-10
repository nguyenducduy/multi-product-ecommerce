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
		chartdata.push({values: chartvalue, key: chartTitle});
	});

	return chartdata;

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

function getPieChartData()
{
	//holding all data
	var chartdata = new Array();

	$('.chartdatadetail1').each(function(index){		
		var x = $(this).attr('title');
        var chartvalue = new Array();
		$(this).find('span').each(function(){
			var y = parseFloat($(this).text());
			chartvalue[0] = x;
			chartvalue[1] = y;
			chartdata[index] = chartvalue; 
		});		
	});
	
	

	return chartdata;

}