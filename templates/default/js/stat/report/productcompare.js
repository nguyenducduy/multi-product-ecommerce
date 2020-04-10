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

		//loadeditable();

        //excel caculate
        $('#dataTable').calx();

        //editdata();
        $('#data').tablesorter();    
        $('#data').freezeHeader();            		
    if($('#chartdata').length)
    {

        var chartType = $('#chartdata').attr('data-charttype');
        var chartTitle = $('#chartTitle').attr('charttitledata')
        var dataY = getPageChartDataY();
        var dataX = getPageChartDataX();
        var xAxisLabel = $('#xaxis').text();
        var yAxisLabel = $('#yaxis').text();
        var chartby = $('#by').val();        

        //tuy chinh cach chia don vi cho truc Y cua highcharts
        var yAxisData = [];

        if(chartby == 'volume')
        {
            yAxisData.push({title:{text: yAxisLabel} , min: 0,startOnTick: false , tickInterval: 1, labels: {enabled: true,formatter: function() {return numeral(this.value).format('0,0');}},plotLines: [{value: 0,width: 1,color: '#808080'}] , lineColor: '#FF0000',
				lineWidth: 1,});
        }
        else
        {
           yAxisData.push({title:{text: yAxisLabel} , min: 0,startOnTick: false , tickPixelInterval : 40, labels: {enabled: true,formatter: function() {return numeral(this.value).format('0,0');}},plotLines: [{value: 0,width: 1,color: '#808080'}] , lineColor: '#FF0000',
				lineWidth: 1,});
        }


        //bat dau khoi tao chart
        $('#chart').highcharts({
            chart: {
               type: chartType,
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
            	tickInterval: step,								
				startOnTick: false,					
				showLastLabel: true,
            	categories : dataX
            },
            yAxis: yAxisData,
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
});