function loadeditable(){   
    $('#dataTable').find('.editable').each(function(){                     
        var data = $(this).text();
        var id = $(this).attr('id');
        $(this).html('<input type="text" id="'+id+'" class="input" value="'+data+'" onkeypress="editdata(\''+id+'\')" />');
        $(this).removeAttr('id');
    });
}
function editdata(id){   
    var databefore = ''; 
    if($('#'+id).length > 0){
        databefore = $('#'+id).val();                
    }
        
    $('#'+id).keypress(function(e) {        
        //check element is exist       
        var dataafter = '';
         //if press enter
        if(e.which == 13) {                            
            dataafter = $(this).val();  
            console.log(dataafter);
            if(dataafter != databefore){                             
                databefore = dataafter;
                dataafter = '';                            
                $(this).css({'color':'red'});                
                //excel caculate
                $('#dataTable').calx();
            }
        }           
    });

    $('#'+id).focusout(function() {
        dataafter = $('.editable input').val();                
        if(dataafter != databefore){                             
            databefore = dataafter;
            dataafter = '';                            
            $(this).css({'color':'red'});
            //excel caculate
            $('#dataTable').calx();
        }
    });
    $('#'+id).focus(function(){
        $(this).css('color' , '');
    });
}


$(function () {

    loadeditable();

    //excel caculate
    $('#dataTable').calx();    
    editdata();        
    $("#data").freezeHeader();       
    $('.table').tablesorter();

    if($('#chartdata').length)
    {

        var chartType = $('#chartdata').attr('data-charttype');
        var chartType1 = $('#chartdata1').attr('data-charttype');
        var chartTitle = $('#chartdata').attr('charttitle');
        var chartTitle1 = $('#chartdata1').attr('charttitle');
        var chartTitle2 = $('#chartdata2').attr('charttitle');//SL
        var chartTitle3 = $('#chartdata3').attr('charttitle');//LG
        var chartby = $('#chartby').val();
        
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
                    tickInterval: 4,
                    startOnTick: false,
                    showLastLabel: true,
                    categories : dataX
                },
                yAxis: {
                    title: {
                        text: yAxisLabel
                    },
                    //min: 0,
                    lineColor: '#FF0000',
                    lineWidth: 1,
                    tickPixelInterval : 40,
                    labels: {
                        enabled: true,
                        formatter: function() {
                         return numeral(this.value).format('0,0');
                        }
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
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
            
            $('#piechart1').highcharts({
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
                    text: chartTitle1,
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
            
            if ($('#piechart2').length > 0) $('#piechart2').highcharts({
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
                    text: chartTitle2,
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
            
            if ($('#piechart3').length > 0) $('#piechart3').highcharts({
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
                    text: chartTitle3,
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