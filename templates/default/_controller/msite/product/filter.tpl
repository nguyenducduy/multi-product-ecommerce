<!-- Content -->
    <section>
    	<div class="navibarlist">
        	<ul>
            	{foreach from=$fullPathCategory item=fcat}
            	<li><a href="{$fcat['fullpath']}" title="{$fcat['pc_name']|escape}">{$fcat['pc_name']} »</a></li>
            	{/foreach}
                <li>
                {if isset($smarty.get.fvid) || isset($smarty.get.vendor) || isset($smarty.get.a)}
                <a href="{$curCategory->getProductcateoryPath()}" title="{$curCategory->name|escape}">{$curCategory->name} »</a>
                {else}
        			{$curCategory->name}
        		{/if}{if !empty($myVendors->name)}{/if}
                </li>
            </ul>
        </div>
    	<div class="filter">
        	<div class="filtertop">
            	<div class="back"><a href="javascript:history.back()">« Trở về</a></div>
                <h3>Xem theo tiêu chí</h3>
            </div>
            {if count($listChildCat) == 1}
            <!--<div class="filterrow"><input class="checkbox" name="" type="checkbox" value=""><label>Chỉ hiển thị những sản phẩm có khuyến mãi (Giảm giá hoặc tặng quà)</label></div> -->
            {/if}
           <!-- list filter -->
            <div class="listfilter">
            
             <div class="filtergroup">
             {foreach from=$listChildCat item=fcat name=topsubcat}
        		{if $smarty.foreach.topsubcat.iteration == 1}{continue}{/if}
        			<h3><a href="{$fcat->getProductcateoryPath()}">Tất cả thương hiệu {$fcat->name}</a></h3>
        		{if !empty($listvendors)}
        			{if !empty($listvendors[$fcat->id])}
        				{foreach from=$listvendors[$fcat->id] item=myven name=vendorlistshow}
        					{if !empty($myven->name) && $myven->name !='-'}
        					 <div class="filterrow bgwhite"><a class="subli{if $myVendors->id == $myven->id} colorselectedfilter{/if}" href="{$myven->getVendorPath($fcat->id)}" title="{$myven->name|escape}">{*$fcat->name*}{$myven->name}</a></div>
        					{/if}
        				{/foreach}
        			{/if}
        		{/if}	            
	            {/foreach}
	            </div>
            
            
            	
                
                {if count($listChildCat) == 1}
                <div class="viewfilter"><a id="viewfilter" href="#">Lọc theo tiêu chí »</a></div>
	                <div id="itemselect" class="filtergroup">
	                	<h3 class="titlechoose">Chọn tiêu chí </h3>
	                   
	                </div>
                
	                {if !empty($listvendors)}
	                	<div class="filtergroup">
		                	<h3>Thương hiệu</h3>
		                
	        				{foreach from =$listvendors[0] item=ven name=vendorlistshow}
		                    <div class="filterrow bgwhite" ><label><input rel="{$ven}" id="{$listvendors[1][$smarty.foreach.vendorlistshow.iteration-1]}" class="checkbox" name="vendor" type="checkbox" value="vendor__{$listvendors[1][$smarty.foreach.vendorlistshow.iteration-1]}">{$ven}</label></div>
		                    {/foreach}
	               		</div>
	               	{/if}
                {/if}
            	{if !empty($attributeList['LEFT'])}
            		{foreach item=attribute from=$attributeList['LEFT'] name=topattributeout}
            			{if $attribute->value|@count > 0}
            			 <div class="filtergroup">
		                	<h3>{$attribute->display}</h3>
		                	{if !empty($attribute->value[0])}
		                	{foreach item=attrvalue from=$attribute->value[0] name=attributelistname}                            
		                        {if !empty($attrvalue)}
		                    	<div class="filterrow bgwhite"  ><label><input rel="{$attrvalue}" id="{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}" class="checkbox" name="{$attribute->panameseo}" type="checkbox" value="{$attribute->panameseo}__{$attribute->value[1][$smarty.foreach.attributelistname.iteration-1]}">{$attrvalue}</label></div>
		               			{/if}
		               		{/foreach}
		               		{/if}
		                </div>
            			{/if}
            		{/foreach}
            	{/if}
               
            </div>
        </div>
    </section>
<!-- End content -->
<script>
	$('document').ready(function() {
		
		var urlroot = "{$curCategory->getProductcateoryPath()}";
		$( ".listfilter [type=checkbox]" ).click(function(){
			var hashdata = '';
			var urlvendor = '';
			var urltype = '';
			var hash = '';
			var i = 0;

			var rel = $(this).attr('rel');
			var id = $(this).attr('id');
			if (this.checked) {
				$('#itemselect').append( '<div id="check'+ id + '" class="filterrow bgwhite"> <div rel="'+ id + '" class="uncheck">X</div><label>'+ rel + '</label></div>');
			}else{
				$( "#check" + id ).remove();
			}
			
			
			$('.listfilter input[type=checkbox]').each(function () {
		           if (this.checked) {
		        	   
			           var name  = $(this).attr('name');
			           hashdata = $(this).val();
			           var arrItem = hashdata.split("__");
				       if(arrItem[0] == 'vendor'){
						  if(urlvendor == ''){
							  urlvendor = "?" + arrItem[0] + "=" + arrItem[1];
						  }else{
							  urlvendor += "," + arrItem[1];
						  }
					   }else if(arrItem[0] == name){
							   if(urltype ==''){
							    	 urltype = "a=" + arrItem[0] + "," + arrItem[1];
							    	 hash = name;
								 }else{
									 if(arrItem[0] == hash){
										 urltype += "," + arrItem[1];
								     }else{
								    	 urltype += "," + arrItem[0] + "," + arrItem[1];
								    	 hash = name;
									 }
								 }
					   }
			          i++;
		              // console.log($(this).val()); 
		           }
			});
			
			$('.titlechoose').html('Bạn đã chọn (' + i + ')');
			
			var fullurl = '';
			if(urlvendor != ''){
				if(urltype != ''){
					fullurl = urlroot + urlvendor + '&' +  urltype;
				}else{
					fullurl = urlroot + urlvendor;
				}
			}else{
				if(urltype != ''){
					fullurl = urlroot + '?' + urltype;
				}else{
					fullurl = urlroot;
					}
			}
			$('#viewfilter').attr('href',fullurl);
			if(i == 0)
				$('#viewfilter').html('Lọc theo tiêu chí »');
			else
				$('#viewfilter').html('Lọc theo ' + i + ' tiêu chí »');
			//alert(fullurl);
		});


		$('body').on('click', '.uncheck', function() {
			
			var rel = $(this).attr('rel');
			if ('#' + rel.checked) {
				 //alert('d');
				 $('#check' + rel).remove();
				 $("#" + rel).prop("checked",false);
			}
			//var i = $("#itemselect > div").size();
			//$('.titlechoose').html('Bạn đã chọn (' + i + ')');
			var hashdata = '';
			var urlvendor = '';
			var urltype = '';
			var hash = '';
			var i = 0;

			var rel = $(this).attr('rel');
			var id = $(this).attr('id');
			if (this.checked) {
				$('#itemselect').append( '<div id="check'+ id + '" class="filterrow bgwhite"> <div rel="'+ id + '" class="uncheck">X</div><label>'+ rel + '</label></div>');
			}else{
				$( "#check" + id ).remove();
			}
			
			
			$('.listfilter input[type=checkbox]').each(function () {
		           if (this.checked) {
		        	   
			           var name  = $(this).attr('name');
			           hashdata = $(this).val();
			           var arrItem = hashdata.split("__");
				       if(arrItem[0] == 'vendor'){
						  if(urlvendor == ''){
							  urlvendor = "?" + arrItem[0] + "=" + arrItem[1];
						  }else{
							  urlvendor += "," + arrItem[1];
						  }
					   }else if(arrItem[0] == name){
							   if(urltype ==''){
							    	 urltype = "a=" + arrItem[0] + "," + arrItem[1];
							    	 hash = name;
								 }else{
									 if(arrItem[0] == hash){
										 urltype += "," + arrItem[1];
								     }else{
								    	 urltype += "," + arrItem[0] + "," + arrItem[1];
								    	 hash = name;
									 }
								 }
					   }
			          i++;
		              // console.log($(this).val()); 
		           }
			});
			
			$('.titlechoose').html('Bạn đã chọn (' + i + ')');
			
			var fullurl = '';
			if(urlvendor != ''){
				if(urltype != ''){
					fullurl = urlroot + urlvendor + '&' +  urltype;
				}else{
					fullurl = urlroot + urlvendor;
				}
			}else{
				if(urltype != ''){
					fullurl = urlroot + '?' + urltype;
				}else{
					fullurl = urlroot;
					}
			}
			$('#viewfilter').attr('href',fullurl);
			if(i == 0)
				$('#viewfilter').html('Lọc theo tiêu chí »');
			else
				$('#viewfilter').html('Lọc theo ' + i + ' tiêu chí »');
			//alert(fullurl);
			
		});

		 var vendor = geturl('vendor');
		 if(vendor != ''){
			 var arr_vendor = vendor.split(',');
			 $.each(arr_vendor, function(index, value) { 
				  $('#' + value).prop("checked",true);
				});
		 }
		 var a = geturl('a');
		 if(a != ''){
			 var arr_a = a.split(',');
			 $.each(arr_a, function(index, value) { 
				  $('#' + value).prop("checked",true);
				});
		 }

		 checkedbox();
		
	});

	// Parse URL Queries Method
	   function geturl(query){
	        query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	        var expr = "[\\?&]"+query+"=([^&#]*)";
	        var regex = new RegExp( expr );
	        var results = regex.exec( window.location.href );
	        if( results !== null ) {
	            return results[1];
	            //return decodeURIComponent(results[1].replace(/\+/g, " "));
	        } else {
	            return false;
	        }
	   }

	   function checkedbox(){
		    var urlroot = "{$curCategory->getProductcateoryPath()}";
		    var hashdata = '';
			var urlvendor = '';
			var urltype = '';
			var hash = '';
			var i = 0;
			
			$('.listfilter input[type=checkbox]').each(function () {
				
		           if (this.checked) {

		        	   	var rel = $(this).attr('rel');
		   				var id = $(this).attr('id');
		   				if (this.checked) {
		   					$('#itemselect').append( '<div id="check'+ id + '" class="filterrow bgwhite"> <div rel="'+ id + '" class="uncheck">X</div><label>'+ rel + '</label></div>');
		   				}else{
		   					$( "#check" + id ).remove();
		   				}
		        	   
			           var name  = $(this).attr('name');
			           hashdata = $(this).val();
			           var arrItem = hashdata.split("__");
				       if(arrItem[0] == 'vendor'){
						  if(urlvendor == ''){
							  urlvendor = "?" + arrItem[0] + "=" + arrItem[1];
						  }else{
							  urlvendor += "," + arrItem[1];
						  }
					   }else if(arrItem[0] == name){
							   if(urltype ==''){
							    	 urltype = "a=" + arrItem[0] + "," + arrItem[1];
							    	 hash = name;
								 }else{
									 if(arrItem[0] == hash){
										 urltype += "," + arrItem[1];
								     }else{
								    	 urltype += "," + arrItem[0] + "," + arrItem[1];
								    	 hash = name;
									 }
								 }
					   }
			          i++;
		              // console.log($(this).val()); 
		           }
			});
			
			$('.titlechoose').html('Bạn đã chọn (' + i + ')');
			
			var fullurl = '';
			if(urlvendor != ''){
				if(urltype != ''){
					fullurl = urlroot + urlvendor + '&' +  urltype;
				}else{
					fullurl = urlroot + urlvendor;
				}
			}else{
				if(urltype != ''){
					fullurl = urlroot + '?' + urltype;
				}else{
					fullurl = urlroot;
					}
			}
			$('#viewfilter').attr('href',fullurl);
			if(i == 0)
				$('#viewfilter').html('Lọc theo tiêu chí »');
			else
				$('#viewfilter').html('Lọc theo ' + i + ' tiêu chí »');
	   }


</script>