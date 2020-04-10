function loadeditable(){   
    $('#dataTable').find('.editable').each(function(){ 		               
        var data = $(this).text();
        var id = $(this).attr('id');
        var rel = $(this).attr('rel');
		var formula = $(this).attr('formula');
        var data1 = $(this).attr('data');  
        var relid = $(this).attr('dataid'); 
        var number = $(this).attr('number');
        var datarel = $(this).attr('datarel');
        var datatype = $(this).attr('datatype');
        var dataself = $(this).attr('dataself');
        var info = $(this).attr('info');
       
		var html = '<input class="datainput" style="width:80px;-moz-box-sizing: inherit;color: #0000FF;padding: 0px;width: 80px;" type="text" id="'+rel+'" name="fdataforecast['+id+']" value="'+data+'"';

        if(formula !== undefined){
            html += ' data-formula="'+formula+'"';
        }

        if(datarel !== undefined){
            html += ' datarel="'+datarel+'"';
        }

        if(number !== undefined){
            html += ' data-info="U'+number+' , V'+number+'"';
        }

        if(relid !== undefined){
            html += ' rel="'+relid+'"';
        }

        if(datatype !== undefined){
            html += ' datatype="1"';
        }

        if(dataself !== undefined){
            html += ' dataself="'+dataself+'"';
        }
        
        if(info !== undefined){
			html += ' info="'+info+'"';
        }

        html += "/>";

        $(this).html(html);

        $(this).removeAttr('id');
        $(this).removeAttr('rel');
		$(this).removeAttr('formula');
        $(this).removeAttr('data');
        $(this).removeAttr('dataid');
        $(this).removeAttr('number');
        $(this).removeAttr('datarel');
        $(this).removeAttr('datatype');
        $(this).removeAttr('dataself');
    });
}


$(function () {	
	loadeditable();

    $('.datainput').keypress(function(e) {        
        //check element is exist       
        var dataafter = '';
         //if press enter   or press tab        
        if(e.which === 13 || e.keyCode === 13) {                         
            e.preventDefault();                   
            dataafter = $(this).val();                
            var datarel = $(this).attr('datarel');
            var datatype = $(this).attr('datatype');

            var dataself = $(this).attr('dataself');
            
            if(dataself !== undefined)
            {
                var databefore = $('#' + dataself).html();
            }                           			
            $(this).css({'color':'red'});                
            //excel caculate                
            var datainfo = $(this).attr('data-info');            
            if(databefore !== dataafter){				
                if(datainfo !== undefined){    
					console.log("Go here");
                    var infolist = datainfo.split(',');                                
                    var mintt = parseInt($('#'+$.trim(infolist[0])).html());
                    var maxtt = parseInt($('#'+$.trim(infolist[1])).html());
                    if(mintt > dataafter){
                        bootbox.alert('Số lượng nhập nhỏ hơn hạn mức'); 
                    }else if(maxtt < dataafter){
                        bootbox.alert('Số lượng nhập lớn hơn hạn mức'); 
                    }                    
                }
                $('#dataTable').calx({
                    readonly: false
                });
				$("#"+dataself).html(dataafter);
				relid = $(this).attr('rel');
				if ($('#' + relid).length > 0) {
					$('#' + $('#' + relid).attr('rel')).val(Math.round($('#' + relid).html()));
					
					var info = $(this).attr('info');
					if($('#' + info).length > 0){
						$('#' + info).html(Math.round($('#' + relid).html()));
					}					
				}

				if ($('#' + datarel).length > 0) {
					if (datatype !== undefined) {
						$('#' + datarel).html(dataafter);
					} else {
						$('#' + datarel).html(Math.round($('#' + relid).html()));
					}
				}								
				
				dataafter = '';
				databefore = '';
				$('#dataTable').calx({
					readonly: false
				});
            }                                                                  
        }           
    });

    
    $('.datainput').blur(function(e) {        
        $(this).css({'color':'blue'});    
        //check element is exist       
        var dataafter = '';
        e.preventDefault();                   
        dataafter = $(this).val();            
        var datarel = $(this).attr('datarel');
        var datatype = $(this).attr('datatype');
        var dataself = $(this).attr('dataself');
        
        if(dataself !== undefined)
        {
            var databefore = $('#' + dataself).html();            
        }                
        
        $(this).css({'color':'red'});                
        //excel caculate                
        var datainfo = $(this).attr('data-info');	
		console.log(dataself);
		console.log("before : " + databefore);
		console.log("after : " + dataafter);
        if(databefore !== dataafter){
            if(datainfo !== undefined){                
                var infolist = datainfo.split(',');                                
                var mintt = parseInt($('#'+$.trim(infolist[0])).html());
                var maxtt = parseInt($('#'+$.trim(infolist[1])).html());
                if(mintt > dataafter){
                    bootbox.alert('Số lượng nhập nhỏ hơn hạn mức'); 
                }else if(maxtt < dataafter){
                    bootbox.alert('Số lượng nhập lớn hơn hạn mức'); 
                }                    				
            }
			$('#dataTable').calx({
				readonly: false
			});
			
			relid = $(this).attr('rel');

			if ($('#' + relid).length > 0) {
				$('#' + $('#' + relid).attr('rel')).val(Math.round($('#' + relid).html()));
				
				var info = $(this).attr('info');
				if($('#' + info).length > 0){
					$('#' + info).html(Math.round($('#' + relid).html()));
				}				
			}

			if ($('#' + datarel).length > 0) {
				if (datatype !== undefined) {
					$('#' + datarel).html(dataafter);
				} else {
					$('#' + datarel).html(Math.round($('#' + relid).html()));
				}
			}  
			dataafter = '';
			databefore = '';
			$('#dataTable').calx({
				readonly: false
			}); 
        }                             
    });

    $('.datainput').focus(function(){
        $(this).css('color' , '');
    });

    //excel caculate
	$('.total').each(function(){
		var formula = $(this).attr('rel');
		$(this).attr('data-formula' , formula);
		$(this).removeAttr('rel');
	});

    $('.tkmin').each(function(index, el) {
        var formula = $(this).attr('rel');        
        $(this).attr('data-formula' , formula);
        $(this).removeAttr('rel');
    });
	
    $('#dataTable').calx({
        readonly: false
    });    	
	///////////////      
    $("#data").freezeHeader();       
    $('.table').tablesorter();	 
	
	//////SUBMIT DATA FORECAST
	$("#fsubmituservalue").click(function(event) {
		/* Act on the event */			
		var url = rooturl + 'stat/report/productdetail/updatedataforecast';	
		$("#fsubmituservalue").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
        $("#fsubmituservalue").hide();		
		$.post(url, $("#myform").serialize() , function(data) {
			/*optional stuff to do after success */
			console.log(data);
			if(data === '1' || data === '-1')
            {
                showGritterSuccess('Dữ liệu đã được cập nhật.');
            }
            else
                showGritterError('Dữ liệu không thể cập nhập.');

            $("img.tmp_indicator").remove();
            $("#fsubmituservalue").show();
		});
	});                           		

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
                //tickPixelInterval : 200,							
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
                //align: 'right',
                verticalAlign: 'bottom',
                borderWidth: 0
            },
            series : dataY
        });
    }
});