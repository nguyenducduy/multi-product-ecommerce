function loadeditable(id){   
    $('#'+id).find('.editable').each(function(){                     
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
		var datainfo = $(this).attr('datainfo');
		var info = $(this).attr('info');
       
        var html = '<input class="datainput" style="width:80px;-moz-box-sizing: inherit;color: #0000FF;padding: 0px;width: 80px;" type="text" id="'+rel+'" name="fdataforecast['+id+']" value="'+data+'"';

        if(formula !== undefined){
            html += ' data-formula="'+formula+'"';
        }

        if(datarel !== undefined){
            html += ' datarel="'+datarel+'"';
        }

        if(datainfo !== undefined){
            html += ' data-info="'+datainfo+'"';
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
        $(this).removeAttr('datainfo');
        $(this).removeAttr('info');
    });
}

function closefunc (selectorname) {
    $('#'+selectorname).hide();
}
$.urlParam = function(name){
	var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
	if (results==null){
		return null;
	}
	else{
		return results[1] || 0;
	}
}

function clickfunc (selectorname){
    var filterdataarr = new Array();                        
    var i = 0;
    $('#'+selectorname+' :checkbox').each(function(index, el) {            
        if($(this).is(':checked')){             
            filterdataarr[i] = $(this).val();
            i++;
        }
    });        
    var aparam = $.urlParam('a');
    var loc = window.location.href;                       
    var path = loc.replace(/(&tab=)[0-9]+/,"");  
    path = path.replace(/(&page=)[0-9]+&/,"");                
    path = path.replace(/(&a=)[0-9a-z\-,]+&/g,"");
    path = path.replace(/(&a=)[0-9a-z\-,]+/g,"");   
    filterdata = filterdataarr.join();
    
    if(aparam != null){
    	if(filterdata != ''){
    		var url = path + '&a=' + aparam + ',' + filterdata;
    	}else{
    		var url = path;
    	}
    }else{
        if(filterdata != ''){
        	var url = path + '&a=' + filterdata;
        }else{
        	var url = path;
        }
    }
    window.location = url;
}

function forecaststore(){
    alert('hello');
}

$(function () {		
    
    ///////////////////////////////////////
    var columnindex = '<tr>';    
    $('#column').find('[rel="col"]').each(function(index) {
        if(index == 0){
            columnindex += '<td class="colhead"></td>';
        }
        else{
            columnindex += '<td class="colhead">'+String.fromCharCode(64+index)+'</td>';
        }        
    });    
    columnindex += '</tr>';

    $('#column').before(columnindex);

    $('.tabdata').on("click",function(){
        tab = $(this).attr("id");        
        if(tab != 11 && tab != 12){
           $('#tab'+tab).css('height' , '500px');
            var loc = window.location.href;               
            var path = loc.replace(/(&tab=)[0-9]+/,"");  
            path = loc.replace(/(page=)[0-9]+&/,"");
             var getoldvalue = getParameterByName(path, 'tab=');        	
	        if (getoldvalue != undefined) 
	        {
				path = path.replace('&tab='+getoldvalue, '');
				path = path.replace('?tab='+getoldvalue, '');
	        }
            var url = path + '&tab=' + tab;                                
            window.location = url; 
        }
    })
    $('#processingtab'+tab).hide();
    
    //prevent submit form when press enter
    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

    $('#brandclick').live('click' , function(event) {
        /* Act on the event */        
        
        $('#branddata').toggle(); 
        $('#branddata').css('top' , event.pageY);               
        $('#segmentdata').css('display', 'none');
        $('#bussinessdata').css('display', 'none');
    });

    $(window).scroll(function(event) {
        /* Act on the event */
        $('#branddata').css('display', 'none');
        $('#segmentdata').css('display', 'none'); 
        $('#bussinessdata').css('display', 'none'); 
        $('.filterlistdata').css('display' , 'none');
    });

    $('#segclick').live('click' , function(event) {
        /* Act on the event */        
        $('#segmentdata').toggle();
        $('#segmentdata').css('top' , event.pageY);
        $('#bussinessdata').css('display', 'none');
        $('#branddata').css('display', 'none');        
    });

    $('#bussinessclick').live('click' , function(event) {
        /* Act on the event */
        $('#bussinessdata').toggle();
        $('#bussinessdata').css('top' , event.pageY);
        $('#branddata').css('display', 'none');        
        $('#segmentdata').css('display', 'none');        
    });

    $('.filterclick').live('click' , function(event) {
        /* Act on the event */
        var id = $(this).attr('id');
        $('#filterdata'+id).toggle();
        $('#filterdata'+id).css('top' , event.pageY);
        $('#branddata').css('display', 'none');        
        $('#segmentdata').css('display', 'none'); 
        $('#bussinessdata').css('display', 'none'); 
    });

    $("body").click(function(event) {
        /* Act on the event */
        var obj = event.target;
        //console.log(obj.ClassName);
    });

    $('#brandok').click(function(event) {
        /* Act on the event */
        var vidarr = new Array();                    
        var i = 0;        
        $('#brandlist :checkbox').each(function(index, el) {        	
            if($(this).is(':checked')){            	
                vidarr[i] = $(this).val();
                i++;
            }
        });
        vid = vidarr.join();
        var loc = window.location.href;               
        var path = loc.replace(/(&vid=)[0-9,]+/,""); 
        path = path.replace(/(&vid=)[0-9,]+&/,""); 
        path = path.replace(/(&tab=)[0-9]+/,"");  
        path = path.replace(/(page=)[0-9]+&/,"");  
        
        var getoldvalue = getParameterByName(path, 'vid=');        	
        if (getoldvalue != undefined) 
        {
			path = path.replace('&vid='+getoldvalue, '');
			path = path.replace('?vid='+getoldvalue, '');
        }
           
        if(vid != ''){
        	var url = path + '&vid=' +vid;
        }  
        else{
        	var url = path;
        }      
        window.location = url;
    });

    $('#bussinessok').click(function(event) {
        /* Act on the event */
        var bussinessarr = new Array();                    
        var i = 0;
        $('#bussinesslist :checkbox').each(function(index, el) {            
            if($(this).is(':checked')){             
                bussinessarr[i] = $(this).val();
                i++;
            }
        });
        bsid = bussinessarr.join();
        var loc = window.location.href;               
        var path = loc.replace(/(&bs=)[0-9]+/,""); 
        path = path.replace(/(&bs=)[0-9]+&/,""); 
        path = path.replace(/(&tab=)[0-9]+/,"");  
        path = path.replace(/(page=)[0-9]+&/,"");    
        
        var getoldvalue = getParameterByName(path, 'bs=');        	
        if (getoldvalue != undefined) 
        {
			path = path.replace('&bs='+getoldvalue, '');
			path = path.replace('?bs='+getoldvalue, '');
        }
        
        if(bsid != ''){
        	var url = path + '&bs=' +bsid;
        }else{
        	var url = path;
        }
        window.location = url;
    });

    $('#segok').click(function(event) {
        /* Act on the event */
        var segdata = new Array();                    
        var segsearch = '';
        var i = 0;
        $('#segmentlist :checkbox').each(function(index, el) {            
            if($(this).is(':checked')){             
                segdata[i] = $(this).val();
                i++;
            }
        });        
        var loc = window.location.href;                       
        var path = loc.replace(/(&tab=)[0-9]+/,"");  
        path = path.replace(/(page=)[0-9]+&/,"");                
        
        var getoldvalue = getParameterByName(path, 'a=');        	
        if (getoldvalue != undefined) 
        {
			path = path.replace('&a='+getoldvalue, '');
			path = path.replace('?a='+getoldvalue, '');
        }
        
        for (var i = segdata.length - 1; i >= 0; i--) {
            if(i > 0){
                segsearch += 'gia,' + segdata[i] + ',';
            }else{
                segsearch += 'gia,' + segdata[i];
            }
        };
        if(segsearch != ''){
        	var url = path + '&a=' + segsearch;
        }else{
        	var url = path;
        }        
        window.location = url;
    });

    $('body').click(function(event) {
        /* Act on the event */        
        var condition = ["iconfilter" , "rdatalist" , "rdata" , "brandlistdata" , "btn" , "seglistdata" , "bussinesslistdata"];        
        if($.inArray(event.target.className, condition) == -1){            
            $('#branddata').css('display', 'none');
            $('#segmentdata').css('display', 'none');
            $('#bussinessdata').css('display', 'none');
        }
    });

   loadeditable();

   $('.datainput').keypress(function(e) {        
        //check element is exist       
        var dataafter = '';
         //if press enter
        if(e.which == 13 || e.keyCode == 13) {             
            e.preventDefault();                   
            dataafter = $(this).val();                          
                                        
            $(this).css({'color':'red'});                
            //excel caculate                
            var datainfo = $(this).attr('data-info');
            if(datainfo != undefined){                
                var infolist = datainfo.split(',');
                console.log();
                console.log(infolist[1]);

                console.log(parseInt(dataafter));
                var mintt = parseInt($('#'+$.trim(infolist[0])).html());
                var maxtt = parseInt($('#'+$.trim(infolist[1])).html());
                if(mintt > dataafter){
                    bootbox.alert('Số lượng nhập nhỏ hơn hạn mức'); 
                }else if(maxtt < dataafter){
                    bootbox.alert('Số lượng nhập lớn hơn hạn mức'); 
                }
            }
            $('#dataTableforecast').calx({
                readonly: false
            });
            dataafter = '';        
            relid = $(this).attr('rel');                
            if($('#' + relid).length > 0){ 
                console.log($('#' + relid).html());                                                   
                $('#' + $('#' + relid).attr('rel')).val( Math.round($('#' + relid).html()));
            } 
            $('#dataTableforecast').calx({
                readonly: false
            });                       
        }           
    });

    //excel caculate
	$('.total').each(function(){
		var formula = $(this).attr('rel');
		$(this).attr('data-formula' , formula);
		$(this).removeAttr('rel');
	});
	
    $('#dataTableforecast').calx();    	
	///////////////
         
    $("#data").freezeHeader();       
    $('.table').tablesorter();	

    if($('#chartdata').length)
    {

        var chartType = $('#chartdata').attr('data-charttype');
        var chartTitle = $('#chartTitle').attr('charttitledata')
        var dataY = getPageChartDataY();
        var dataX = getPageChartDataX();
        var xAxisLabel = $('#xaxis').text();
        var yAxisLabel = $('#yaxis').text();
        var chartby = $('#by').val();


    //     //tuy chinh cach chia don vi cho truc Y cua highcharts
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

        yAxisData.push({title:{text: yAxisLabel} , startOnTick: false , tickPixelInterval : 40, labels: {enabled: true,formatter: function() {return numeral(this.value).format('0,0');}},plotLines: [{value: 0,width: 1,color: '#808080'}] , lineColor: '#FF0000',lineWidth: 1,});

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
                //align: 'right',
                verticalAlign: 'bottom',
                borderWidth: 0
            },
            series : dataY
        });
    }
});
function getParameterByName(url, name){//url     = document.URL,
        
    var count   = url.indexOf(name);
        sub     = url.substring(count);
        amper   = sub.indexOf("&");

    if(amper == "-1"){
        var param = sub.split("=");
        return param[1];
    }else{
        var param = sub.substr(0,amper).split("=");
        return param[1];
    }
}