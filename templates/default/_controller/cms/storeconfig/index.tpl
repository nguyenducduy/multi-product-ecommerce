<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>	
	<li class="active">Report Config</li>
</ul>

<div class="page-header" rel="menu_vendor"><h1>{$lang.controller.head_list}</h1></div>

<h1>{$myrootcategory->name}</h1>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Cấu hình Siêu Thị</a></li>
		<li><a href="#tab2" data-toggle="tab">Hạn mức siêu thị</a></li>		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">		
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		<form action="" method="post" id="myform" class="form-inline">
			<input type="hidden" name="fpcid" value="{$myrootcategory->id}" id="fpcid" />
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Siêu thị</th>
						<th>Loại</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach item=store from=$storelist}
					<tr>
						<td><span class="label label-info">{$store->name}</span></td>
						<td>
							<select name="fstoretype[{$store->id}]">
								{assign var=sid value=$store->id}
								{foreach key=typeid item=typename from=$typelist}								
								<option {foreach item=storeconfig from=$storeconfiglist}{if $storeconfig->sid == $store->id}{if $storeconfig->type == $typeid}selected="selected"{/if}{/if}{/foreach} value="{$typeid}">{$typename}</option>
								{/foreach}
							</select>
						</td>
						<td></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			<div class="form-actions" style="text-align:center;">
				<input type="submit" name="fsubmit" value="Lưu" class="btn btn-large btn-primary" />				
			</div>
		</form>
		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
		<div>
			Barcode &nbsp; <input style="width:100px;" class="input-large" type="text" id="fbarcode" name="fbarcode" value="" />&nbsp;
			Tên sản phẩm &nbsp; <input type="text" id="fname" name="fname" value="" /> &nbsp;
			Brand name &nbsp; 
				<select id="vendorlist" name="vendorlist[]" multiple="multiple" style="width:150px;">
					{html_options options=$vendorlist}				
				</select>
			Trạng thái sản phẩm &nbsp;
			<select id="bussinesslist" name="bussinesslist[]" multiple="multiple" style="width:200px;">
				{html_options options=$bussinessstatusList}				
			</select>
			&nbsp; <input type="button" id="fsearch" value="Tìm" class="btn btn-primary" />
		</div>	
		<div style="height:20px;"></div>		
		<div>
			<form id="productdata" method="post" action="">
				
			</form>
		</div>
		</div><!-- end #tab2 -->
	</div>
</div>
<script type="text/javascript" src="{$currentTemplate}js/stat/report/jquery.freezeheader.js"></script>
{literal}
<script type="text/javascript">
	$(document).ready(function(){	
		$('#bussinesslist').select2();	
		$('#vendorlist').select2();
		$('#fsearch').click(function(event) {
			var url = rooturl_cms + 'storeconfig/searchajax';			

        	var bussinessarr = new Array();                    	        
	        $('#bussinesslist :selected').each(function(i, selected){ 
			  bussinessarr[i] = $(selected).val(); 			  
			});	      

	        bsid = bussinessarr.join();	    

	        var vendorlist = new Array();
	        $('#vendorlist :selected').each(function(i, selected) {
	        	vendorlist[i] = $(selected).val();
	        });
	        vid = vendorlist.join();

	        pname = $('#fname').val();	        
	        pcid = $('#fpcid').val();
	        pbarcode = $("#fbarcode").val();	        	       

	        if(bsid === '' && pname === '' && pbarcode === '' && vid === ''){
	        	bootbox.alert('Vui lòng nhập thông tin để tìm kiếm sản phẩm.');
	        }
	        else{
	        	$("#fsearch").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
        		$("#fsearch").hide();	
	        	$.ajax({
	        		url: url,
	        		type: 'POST',
	        		dataType: 'html',
	        		data: {bs:bsid , pname:pname , pbarcode:pbarcode , pcid:pcid , vid:vid},
	        		success:function(html){	        			
	        			if(html === '-1'){		                    
	        				bootbox.alert('Vui lòng nhập thông tin đê tìm kiếm');
		                }else{
		                	$('#productdata').html(html);
		                }		                		             
		                $("img.tmp_indicator").remove();
		                $("#fsearch").show();
	        		}
	        	})       
	        }        	 
        	
		});
	});
</script>
{/literal}
