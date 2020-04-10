<html>
	<head>
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

		<!-- Bootstrap Responsive Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

		<!-- Customized Admin Stylesheet -->
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />

		<!-- <link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen" />
 -->
		<!-- jQuery -->
		<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

		<!-- Bootstrap Js -->
		<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>



		<!-- customized admin -->
		<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
		<!--<script type="text/javascript" src="{$currentTemplate}min/?g=jsadminchart&ver={$setting.site.jsversion}"></script>-->


        <script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_admin = "{$conf.rooturl_admin}";
		var rooturl_cms = "{$conf.rooturl_cms}";
		var rooturl_crm = "{$conf.rooturl_crm}";
		var rooturl_erp = "{$conf.rooturl_erp}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var controllerGroup = "{$controllerGroup}";
		var currentTemplate = "{$currentTemplate}";

		var websocketurl = "{$setting.site.websocketurl}";
		var websocketenable = {$setting.site.websocketenable};

		var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";


		var imageDir = "{$imageDir}";
		var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
		var gritterDelay = 3000;
		var meid = {$me->id};
		var meurl = "{$me->getUserPath()}";
		var userid = {$myUser->id};
		var userurl = "{$myUser->getUserPath()}";
		</script>
	</head>
<body>
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
{if !$denied}
<div style="padding:10px;">
	<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
		<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_list} - <span style="color:red;">Danh mục "{$productcategory->name}"{if $parentcategory->id > 0 && $productgroupattributes|@count > 0 && $formData.act == ''}
	            	kế thừa từ danh mục "{$parentcategory->name}"
	            	{/if}</span></h1></div>
	    {if $parentcategory->id > 0 && $productgroupattributes|@count > 0 && $formData.act == ''}<span><i>(Nếu bạn muốn tạo thuộc tính riêng cho danh mục này vui lòng nhấn nút "Tạo thuộc tính riêng cho danh mục hiện tại" ở phía dưới)</i></span>{/if}
		<div id="filterList">
	        <table class="table table-striped" id="groupattribute">
	        	<thead>
	            	<tr>
	            		<th style="width:94px;">{$lang.controller.labelDisplayorder}</th>
	            		<th style="width:350px;">{$lang.controller.labelGroupAttribute}</th>
	            		<th>{$lang.controller.labelAttribute}</th>
	            	</tr>
	            </thead>
	            <tbody>
	            {if $productgroupattributes|@count > 0 && $formData.act == ''}
	            	{assign var=counter value=3}
	            	{foreach item=productgroupattribute from=$productgroupattributes}
	            	<tr id="rowgpa_{$productgroupattribute->id}">
		            	<td><input type="text" style="height:25px;" class="input-mini" name="fdisplayorder[{$productgroupattribute->id}]" id="displayorder_{$productgroupattribute->id}" {if $parentcategory->id > 0}readonly="readonly"{/if} value="{$productgroupattribute->displayorder}" /></td>
		            	<td><input style="height:28px;" type="text" name="fgpa{$productgroupattribute->id}" id="fgpa{$productgroupattribute->id}" value="{$productgroupattribute->name}" {if $parentcategory->id > 0}readonly{/if} />
		            		{if $parentcategory->id == 0}

		            		<a id="dgpa_{$productgroupattribute->id}" style="float:right;" title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" onclick="deleteGpa('rowgpa_',{$productgroupattribute->id})" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>

		            		<a id="editgpa_{$productgroupattribute->id}" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a>

		            		{/if}
		            		</td>
		            	<td>
		            		<div id="rowpa_{$counter}">
		            		{assign var=have value=false}
		            		{if $productgroupattribute->attributes|@count > 0}
		            			{assign var=have value=true}
								{foreach item=attribute from=$productgroupattribute->attributes}
								<input style="height:30px;" style="float:left;" id="displayorder_{$attribute->id}" class="input-mini" type="text"  value="{$attribute->displayorder}" id="fdisplayorder_{$attribute->id}" name="fpadisplayorder[{$attribute->id}]" {if $parentcategory->id > 0}readonly="readonly"{/if}/>
								<input class="input-medium" style="height:30px;margin-left:5px;" type="text" name="fpa_{$attribute->id}" id="fpa_{$attribute->id}" value="{$attribute->name}" {if $parentcategory->id > 0}readonly="readonly"{/if} />{if $parentcategory->id == 0}
								<select id="datatype_{$attribute->id}" {if $parentcategory->id > 0}readonly="readonly"{/if} style="width:115px;margin-left:5px;">
									{html_options options=$dataTypeList selected=$attribute->datatype}
								</select>
								<input style="height:30px;margin-left:5px;" class="input-mini" type="text" id="unit_{$attribute->id}" value="{$attribute->unit}" name="unit_{$attribute->id}" {if $attribute->unit == ''}placeholder="Đơn vị"{/if} />

								<input style="height:30px;margin-left:5px;" class="input-medium" type="text" id="description_{$attribute->id}" value="{$attribute->description}" name="description_{$attribute->description}" {if $attribute->description == ''}placeholder="Mô tả"{/if} />

								<input style="height:30px;width:40px;" class="input-mini" type="text" id="weight_{$attribute->id}" value="{$attribute->weightrecommand}" name="weight_{$attribute->id}" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/>

								<a href="{$conf.rooturl_cms}productattribute/changegroup/id/{$attribute->id}">Đổi nhóm</a>
								<a id="{$attribute->id}" style="float:right;" title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" onclick="deletePa({$attribute->id})" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>

								<a id="editpa_{$attribute->id}" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a>
								{/if}<br />
								{/foreach}
							{elseif $parentcategory->id == 0}
								<input style="height:30px;float:left;" id="{$productgroupattribute->id}_{$counter}" class="input-mini" type="text" {if $parentcategory->id > 0}readonly="readonly"{/if}/>

								<input class="input-medium"  style="height:30px;margin-left:4px;" type="text" placeholder="Tên thuộc tính" id="fgpapa_{$productgroupattribute->id}_{$counter}" {if $parentcategory->id >0}readonly="readonly"{/if}/>
								<select id="datatype_{$productgroupattribute->id}_{$counter}" {if $parentcategory->id > 0}readonly="readonly"{/if} style="width:115px;margin-left:4px;">
									{html_options options=$dataTypeList selected=$attribute->datatype}
								</select>
								<input style="height:30px;margin-left:4px;" class="input-mini" type="text" id="unit_{$productgroupattribute->id}_{$counter}" placeholder="Đơn vị" />
								<input style="height:30px;margin-left:4px;" class="input-medium" type="text" id="description_{$productgroupattribute->id}_{$counter}" placeholder="Mô tả" />

								<input style="height:30px;width:40px;" class="input-mini" type="text" id="weightrecommand_{$productgroupattribute->id}_{$counter}" value="1" name="weight_{$productgroupattribute->id}_{$counter}" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/>

								<a id="editpagpa_{$productgroupattribute->id}_{$counter}" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a><br/>
		            		{/if}
		            		</div>

		            		<br />
		            		{if $parentcategory->id == 0}
					        	<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton_{$counter}" value="Thêm thuộc tính" onclick="addRow('rowpa_{$counter}' , {$productgroupattribute->id})" /><br/><br/><br/>
					        {/if}
		            	</td>
	            	</tr>
	            	{assign var=counter value=$counter+1}
	            	{/foreach}
	            {/if}
	            {if $parentcategory->parentid == 0 || $formData.act == 'add'}
	            <tr id="rowgpa_1">
	            	<td>
	            		<input style="height:30px;" type="text" class="input-mini" id="displayordernew_1"  value="" />
	            	</td>
		            <td>
		            	<input style="height:30px;" type="text" id="fgpanew_1" id="fgpanew_1" placeholder="Tên nhóm thuộc tính"/>

		            	<a id="editgpanew_1" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a>
		            </td>
		            <td>
		            	<div id="rowpa_1">
		            		<input style="height:30px;" style="float:left;" id="attrnew_1" class="input-mini" type="text"/>

		            		<input class="input-medium"  style="height:30px;margin-left:5px;" type="text" id="fpanew_1" placeholder="Tên thuộc tính" />
		            		<select id="datatype_1" style="width:115px;margin-left:5px;">
								{html_options options=$dataTypeList selected=$attribute->datatype}
							</select>
							<input style="height:30px" class="input-mini" type="text" id="unitnew_1" placeholder="Đơn vị" />
							<input style="height:30px" class="input-medium" type="text" id="descriptionnew_1" placeholder="Mô tả" />

							<input style="height:30px;width:40px;" class="input-mini" type="text" id="weightnew_1" value="1" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/>

							<a id="editpanew_1" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a><br/>
		            	</div>
		            	<br />
		            	<div id="faddbutton1">
		            		<input id="addnewrow1" style="float:right;" class="btn btn-small btn-success" type="button" value="Thêm thuộc tính" onclick="addRow('rowpa_1' , 0)" />
		            	</div>
					    <br/><br/><br/>
		            </td>
	            </tr>
	            <tr id="rowgpa_2">
	            	<td><input style="height:30px;" type="text" class="input-mini" id="displayordernew_2" /></td>
		            <td>
		            	<input style="height:30px;" type="text" id="fgpanew_2" placeholder="Tên nhóm thuộc tính"/>

		            	<a id="editgpanew_2" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a>
		            </td>
		            <td>
		            	<div id="rowpa_2">
		            		<input style="height:30px;" style="float:left;" id="attrnew_2" class="input-mini" type="text"/>
		            		<input class="input-medium"  style="height:30px;margin-left:5px;" type="text" id="fpa_2" id="fpanew_2" placeholder="Tên thuộc tính" />
		            		<select id="datatype_2" style="width:115px;margin-left:5px;">
								{html_options options=$dataTypeList selected=$attribute->datatype}
							</select>
							<input style="height:30px;" class="input-mini" type="text" id="unitnew_2" placeholder="Đơn vị" />
							<input style="height:30px;" class="input-medium" type="text" id="descriptionnew_2" placeholder="Mô tả" />
							<input style="height:30px;width:40px;" class="input-mini" type="text" id="weightnew_2" value="1" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/>

							<a id="editpanew_2" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a><br/>
		            	</div>
		            	<br />
		            	<div id="faddbutton2">
					        <input id="addnewrow2" style="float:right;" class="btn btn-small btn-success" type="button"  value="Thêm thuộc tính" onclick="addRow('rowpa_2' , 0)" />
					    </div>
					    <br/><br/><br/>
		            	</td>
	            	</tr>
	            {/if}
	            </tbody>
	        </table>
	        <br/ ><br/ ><br/ >
	        {if $parentcategory->id == 0 || $productgroupattributes|@count == 0 || $formData.act == 'add'}
			<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbuttonrow" value="Thêm nhóm thuộc tính" onclick="addRow('groupattribute' , 0)" /><br/><br/><br/>
			{/if}
       	<div class="form-actions" style="padding-left:80px;">
            {if $parentcategory->id > 0 && $productgroupattributes|@count > 0 && $formData.act == ''}
            <a class="btn btn-primary" href="{$conf.rooturl_cms}{$controller}/view/pcid/{$productcategory->id}/act/add">{$lang.controller.labelPrivateGroupAttribute}</a>
            {else}
           	<input type="submit" name="fsubmitgpa" value="{$lang.controller.formUpdateSubmitGpaDisplayOrder}" class="btn btn-large btn-primary" />
           	<input type="submit" name="fsubmitpa" value="{$lang.controller.formUpdateSubmitPaDisplayOrder}" class="btn btn-large btn-primary" />
           	<input type="submit" name="fsubmit" value="{$lang.controller.formUpdateSubmitDisplayOrder}" class="btn btn-large btn-primary" />
            {/if}
        </div>
	    </div>
	</form>
</div>
{/if}
</body>
</html>
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$productcategory->id}{literal}";
$(document).ready(function(){
    initEditInline(fpcid);

    $('a').live('click',function(){
    		var data = $(this).attr('id').split('_');
    		//cap nhat thong tin cua group attribute
    		if(data[0] == 'editgpa')
    		{
    			if(data[1] > 0)
    			{
    				var gpavalue = $('#fgpa'+data[1]).val();
    				var gpadisplayorder = $('#displayorder_'+data[1]).val();

    				if(gpavalue != '')
    				{
    					datastring = 'type=edit&gpaid='+data[1]+'&value=' + gpavalue+"&displayorder="+gpadisplayorder+'&pcid='+fpcid;

	    				$.ajax({
	    					type : "post",
	    					dataType : "html",
	    					url : "/cms/productgroupattribute/editproductgroupattributeajax",
	    					data : datastring,
	    					success : function(html){
	    						if(html != '0'){
	    							alert('Cập nhật thông tin thành công.');
	    						}
	    						else{
	    							alert('Có lỗi trong quá trình cập nhật thông tin . Vui lòng thử lại');
	    						}
	    					}
	    				});
    				}
    				else
    				{
    					alert('Vui lòng nhập tên nhóm thuộc tính');
    				}
    			}
    		}

    		//them thong tin nhom thuoc tinh moi
    		if(data[0] == 'editgpanew')
    		{
    			if(data[1] > 0)
    			{
    				var gpavalue = $('#fgpanew_'+data[1]).val();
    				var gpadisplayorder = $('#displayordernew_'+data[1]).val();
    				if(gpavalue != '')
    				{
    					datastring = 'type=add&value=' + gpavalue+"&displayorder="+gpadisplayorder+'&pcid='+fpcid;

	    				$.ajax({
	    					type : "post",
	    					dataType : "html",
	    					url : "/cms/productgroupattribute/editproductgroupattributeajax",
	    					data : datastring,
	    					success : function(html){
	    						if(html != '0'){
	    							$('#displayordernew_'+data[1]).attr('name' , 'fdisplayorder['+html+']');
	    							$('#displayordernew_'+data[1]).attr('id' , 'displayorder_'+html);
	    							$('#fgpanew_'+data[1]).attr('id' , 'fgpa'+html);
	    							$('#editgpanew_'+data[1]).before('<a id="dgpa_'+html+'" style="float:right;" title="{/literal}{$lang.default.formActionDeleteTooltip}{literal}" href="javascript:void(0)" onclick="deleteGpa(\'rowgpa_\','+html+')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>');
	    							$('#editgpanew_'+data[1]).attr('id' , 'editgpa_'+html);
	    							$('#rowgpa_'+data[1]).attr('id' , 'rowgpa_'+html);
	    							$('#attrnew_'+data[1]).attr('id' , html+'_'+data[1]);
	    							$('#fpanew_'+data[1]).attr('id','fgpapa_' + html + '_' + data[1]);
	    							$('#unitnew_'+data[1]).attr('id','unit_' + html + '_' + data[1]);
	    							$('#descriptionnew_'+data[1]).attr('id','description_' + html + '_' + data[1]);
	    							$('#weightnew_'+data[1]).attr('id','weightrecommand_' + html + '_' + data[1]);
	    							$('#datatype_'+data[1]).attr('id','datatype_' + html + '_' + data[1]);
	    							$('#faddbutton'+data[1]).html('');
	    							$('#editpanew_'+data[1]).attr('id' , 'editpagpa_'+html + '_'+data[1]);
	    							$('#faddbutton'+data[1]).append('<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton_'+data[1]+'" value="Thêm thuộc tính" onclick="addRow(\'rowpa_'+data[1]+'\' , '+html+')" /><br/><br/><br/>');

	    							alert('Cập nhật thông tin thành công.');
	    						}
	    						else{
	    							alert('Có lỗi trong quá trình cập nhật thông tin . Vui lòng thử lại');
	    						}
	    					}
	    				});
    				}
    				else
    				{
    					alert('Vui lòng nhập tên nhóm thuộc tính');
    				}
    			}
    		}

    		//thuoc tinh nay chua thuoc nhom thuoc tinh nao
    		if(data[0] == 'editpanew')
    		{
    			alert('Vui lòng tạo nhóm thuộc tính trước khi tạo thuộc tính');
    		}

    		//them thuoc tinh moi
    		if(data[0] ==  'editpagpa')
    		{
    			if(data[1] > 0)
    			{
    				var pavalue = $('#fgpapa_'+data[1]+'_'+data[2]).val();
    				var padisplayorder = $('#'+data[1]+'_'+data[2]).val();
    				var padatatype = $('#datatype_'+data[1]+'_'+data[2]).val();
    				var paunit = $('#unit_'+data[1]+'_'+data[2]).val();
    				var description = $('#description_'+data[1]+'_'+data[2]).val();
    				var weightrecommand = $('#weightrecommand_'+data[1]+'_'+data[2]).val();

    				if(pavalue != '')
    				{
    					datastring = 'type=add&name=' + pavalue + '&displayorder='+padisplayorder + '&datatype=' + padatatype + '&unit='+paunit+'&pcid='+fpcid+'&gpaid='+data[1]+'&description='+description+'&weight='+weightrecommand;
    					$.ajax({
    						type : "post",
    						dataType : "html",
    						url : "/cms/productattribute/editproductattributeajax",
    						data : datastring,
    						success : function(html){
    							if(html != '0'){
    								$('#'+data[1]+'_'+data[2]).attr('name' , 'fpadisplayorder['+html+']');
    								$('#'+data[1]+'_'+data[2]).attr('id' , 'displayorder_' + html);
    								$('#fgpapa_'+data[1]+'_'+data[2]).attr('id' , 'fpa_' + html);
    								$('#datatype_'+data[1]+'_'+data[2]).attr('id' , 'datatype_'+html);
    								$('#unit_'+data[1]+'_'+data[2]).attr('id' , 'unit_'+html);
    								$('#description_'+data[1]+'_'+data[2]).attr('id' , 'description_'+html);
    								$('#weightrecommand_'+data[1]+'_'+data[2]).attr('id' , 'weight_'+html);
    								$('#editpagpa_'+data[1]+'_'+data[2]).remove();
    								$('#weight_'+html).after('<a id="'+html+'" style="float:right;" title="{/literal}{$lang.default.formActionDeleteTooltip}{literal}" href="javascript:void(0)" onclick="deletePa('+html+')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>');

    								$('#'+html).after('<a id="editpa_'+html+'" style="float:right;height:12px;right: 10px;" title="{/literal}{$lang.default.formActionEditTooltip}{literal}" href="javascript:void(0)" class="btn btn-mini">Lưu</a>');

    								alert('Cập nhật thông tin thành công.');
    							}
    							else{
    								alert('Có lỗi trong quá trình cập nhật thông tin . Vui lòng thử lại');
    							}
    						}
    					});
    				}
    				else
    				{
    					alert('Vui lòng nhập tên thuộc tính');
    				}
    			}
    		}


    		//cap nhat thong tin cua thuoc tinh
    		if(data[0] == 'editpa')
    		{
    			if(data[1] > 0)
    			{
    				var pavalue = $('#fpa_'+data[1]).val();
    				var padisplayorder = $('#displayorder_'+data[1]).val();
    				var padatatype = $('#datatype_'+data[1]).val();
    				var paunit = $('#unit_'+data[1]).val();
    				var description = $('#description_'+data[1]).val();
    				var weight = $('#weight_'+data[1]).val();

    				if(pavalue != '')
    				{
    					datastring = 'type=edit&name=' + pavalue + '&displayorder='+padisplayorder + '&datatype=' + padatatype + '&unit='+paunit+'&pcid='+fpcid+'&id='+data[1]+'&description='+description + '&weight='+weight;
    					$.ajax({
    						type : "post",
    						dataType : "html",
    						url : "/cms/productattribute/editproductattributeajax",
    						data : datastring,
    						success : function(html){
    							if(html != '0'){

    								alert('Cập nhật thông tin thành công.');
    							}
    							else{
    								alert('Có lỗi trong quá trình cập nhật thông tin . Vui lòng thử lại');
    							}
    						}
    					});
    				}
    				else
    				{
    					alert('Vui lòng nhập tên thuộc tính');
    				}
    			}
    		}

    });
});

function addRow(tbname,pgaid)
{

	var arr = tbname.split("_");
	var name = arr[0];
	var count = arr[1] + 1;

	if(name == 'rowpa')
	{
		rowCount = $('#'+ tbname +' select').length;
		rowCount +=3 ;
	}
	else
	{
		rowCount = $('#'+ name +' tr').length;
		rowCount +=1 ;
	}


	var data = '';

	if(name == 'groupattribute')
	{
		data = '<tr id="rowgpa_'+rowCount+'"><td><input style="height:30px;" type="text" class="input-mini" id="displayordernew_'+rowCount+'" value="" /></td><td><input style="height:30px;" type="text" name="fgpanew_'+rowCount+'" id="fgpanew_'+rowCount+'" placeholder="Tên nhóm thuộc tính"/><a id="editgpanew_'+rowCount+'" style="float:right;height:12px;right: 10px;" title="{/literal}{$lang.default.formActionEditTooltip}{literal}" href="javascript:void(0)" class="btn btn-mini">Lưu</a></td><td><div id="rowpa_'+rowCount+'"><input style="height:30px;" style="float:left;" id="attrnew_'+rowCount+'" class="input-mini" type="text"/><input class="input-medium"  style="height:30px;margin-left:9px;" type="text" id="fpanew_'+rowCount+'" placeholder="Tên thuộc tính" /><select name="datatypenew_'+rowCount+'" style="width:115px;margin-left:9px;"> <option value="5">Kiểu số</option><option value="10">Kiểu chuỗi</option>  </select><input style="height:30px;margin-left:4px;" class="input-mini" type="text" id="unitnew_'+rowCount+'" placeholder="Đơn vị" /><input style="height:30px;margin-left:7px;" class="input-medium" type="text" id="descriptionnew_'+rowCount+'" placeholder="Mô tả" /><input style="height:30px;width:40px;margin-left:5px;" class="input-mini" type="text" id="weightnew_'+rowCount+'" value="1" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/><a id="editpanew_'+rowCount+'" style="float:right;height:12px;right: 10px;" title="{/literal}{$lang.default.formActionEditTooltip}{literal}" href="javascript:void(0)" class="btn btn-mini">Lưu</a><br/></div><br /><div id="faddbutton'+rowCount+'"><input style="float:right;" class="btn btn-small btn-success" type="button" value="Thêm thuộc tính" onclick="addRow(\'rowpa_'+rowCount+'\' , 0)" /></div><br/><br/><br/></td></tr>';
	}
	else if(name == 'rowpa')
	{

		if(pgaid > 0)
		{		
			data = '<input style="height:30px;float:left;" id="'+pgaid+'_'+rowCount+'" class="input-mini" type="text"><input class="input-medium" style="height:30px;margin-left:8px;" type="text" id="fgpapa_'+pgaid+'_'+rowCount+'" placeholder="Tên thuộc tính"/><select id="datatype_'+pgaid+'_'+rowCount+'" style="width:115px;margin-left:8px;"><option value="5">Kiểu số</option><option value="10">Kiểu chuỗi</option></select><input style="height:30px;margin-left:10px;" class="input-mini" type="text" id="unit_'+pgaid+'_'+rowCount+'" placeholder="Đơn vị" /><input style="height:30px;margin-left:10px;" class="input-medium" type="text" id="description_'+pgaid+'_'+rowCount+'" placeholder="Mô tả" /><input style="height:30px;width:40px;margin-left:5px;" class="input-mini" type="text" id="weightrecommand_'+pgaid+'_'+rowCount+'" value="1" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/><a id="editpagpa_'+pgaid+'_'+rowCount+'" style="float:right;height:12px;right: 10px;" title="{/literal}{$lang.default.formActionEditTooltip}{literal}" href="javascript:void(0)"  class="btn btn-mini">Lưu</a><br/>';
		}
		else
		{			
			data = '<input style="height:30px;float:left;" id="attrnew_'+rowCount+'" class="input-mini" type="text"/><input class="input-medium" style="height:30px;;margin-left:9px;" type="text" name="fpanew_'+rowCount+'" id="fpa_'+rowCount+'" placeholder="Tên thuộc tính" /><select id="datatype_'+rowCount+'" style="width:115px;margin-left:8px;"><option value="5">Kiểu số</option><option value="10">Kiểu chuỗi</option></select><input style="height:30px;;margin-left:5px;" class="input-mini" type="text" id="unitnew_'+rowCount+'" placeholder="Đơn vị" /><input style="height:30px;;margin-left:7px;" class="input-medium" type="text" id="descriptionnew_'+rowCount+'" placeholder="Mô tả" /><input style="height:30px;width:40px;margin-left:5px;" class="input-mini" type="text" id="weightnew_'+rowCount+'" value="1" title="Trọng số dùng cho chức năng đề xuất sản phẩm" class="tipsy-trigger"/><a id="editpanew_'+rowCount+'" style="float:right;height:12px;right: 10px;" title="{$lang.default.formActionEditTooltip}" href="javascript:void(0)" class="btn btn-mini">Lưu</a><br/>';
		}
	}

    $('#'+tbname).append(data);

 //    //////////////////////////////////////////////////////////////////////////////////////
 //    $('#editpanew_'+rowCount).bind('click',function(){
 //    		alert('Vui lòng tạo nhóm thuộc tính trước khi tạo thuộc tính');
 //    });

 //    //////////////////////////////////////////////////////////////////////////////////////
 //    $('#editgpanew_'+rowCount).bind('click',function(){
 //    		//them thong tin nhom thuoc tinh moi
 //    		if(rowCount > 0)
 //    		{
 //    			var gpavalue = $('#fgpanew_'+rowCount).val();
 //    			var gpadisplayorder = $('#displayordernew_'+rowCount).val();
 //    			if(gpavalue != '')
 //    			{
 //    				datastring = 'type=add&value=' + gpavalue+"&displayorder="+gpadisplayorder+'&pcid='+fpcid;

	//     				$.ajax({
	//     					type : "post",
	//     					dataType : "html",
	//     					url : "/cms/productgroupattribute/editproductgroupattributeajax",
	//     					data : datastring,
	//     					success : function(html){
	//     						if(html != '0'){
	//     							$('#displayordernew_'+rowCount).attr('name' , 'fdisplayorder['+html+']');
	//     							$('#fgpanew_'+rowCount).attr('id' , 'fgpa_'+html);
	//     							$('#editgpanew_'+rowCount).before('<a id="dgpa_'+html+'" style="float:right;" title="{/literal}{$lang.default.formActionDeleteTooltip}{literal}" href="javascript:void(0)" onclick="deleteGpa(\'rowgpa_\','+html+')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>');
	//     							$('#editgpanew_'+rowCount).attr('id' , 'editgpa_'+html);
	//     							$('#rowgpa_'+rowCount).attr('id' , 'rowgpa_'+html);
	//     							$('#attrnew_'+rowCount).attr('id' , html+'_'+rowCount);
	//     							$('#fpanew_'+rowCount).attr('id','fgpapa_' + html + '_' + rowCount);
	//     							$('#unitnew_'+rowCount).attr('id','unit_' + html + '_' + rowCount);
	//     							$('#datatype_'+rowCount).attr('id','datatype_' + html + '_' + rowCount);
	//     							$('#addnewrow'+rowCount).remove();
	//     							$('#editpanew_'+rowCount).attr('id' , 'editpagpa_'+html + '_'+rowCount);
	//     							$('#faddbutton'+rowCount).append('<input style="float:right;" class="btn btn-small btn-success" type="button" id="faddbutton_'+rowCount+'" value="Thêm thuộc tính" onclick="addRow(\'rowpa_'+rowCount+'\' , '+html+')" /><br/><br/><br/>');

	//     							alert('Cập nhật thông tin thành công.');
	//     						}
	//     						else{
	//     							alert('Có lỗi trong quá trình cập nhật thông tin . Vui lòng thử lại');
	//     						}
	//     					}
	//     				});
 //    			}
 //    			else
 //    			{
 //    				alert('Vui lòng nhập tên nhóm thuộc tính');
 //    			}
 //    		}
 //    });



	// $('#editpagpa_'+pgaid+'_'+rowCount).bind('click',function(){
	// 	if(pgaid > 0)
 //    		{
 //    			var pavalue = $('#fgpapa_'+pgaid+'_'+rowCount).val();
 //    			var padisplayorder = $('#'+pgaid+'_'+rowCount).val();
 //    			var padatatype = $('#datatype_'+pgaid+'_'+rowCount).val();
 //    			var paunit = $('#unit_'+pgaid+'_'+rowCount).val();

 //    			if(pavalue != '')
 //    			{
 //    				datastring = 'type=add&name=' + pavalue + '&displayorder='+padisplayorder + '&datatype=' + padatatype + '&unit='+paunit+'&pcid='+fpcid+'&gpaid='+pgaid;
 //    				$.ajax({
 //    					type : "post",
 //    						dataType : "html",
 //    						url : "/cms/productattribute/editproductattributeajax",
 //    						data : datastring,
 //    						success : function(html){
 //    							if(html != '0'){
 //    								$('#'+pgaid+'_'+rowCount).attr('name' , 'fpadisplayorder['+html+']');
 //    								$('#'+pgaid+'_'+rowCount).attr('id' , 'displayorder_' + html);
 //    								$('#fgpapa_'+pgaid+'_'+rowCount).attr('id' , 'fpa_' + html);
 //    								$('#datatype_'+pgaid+'_'+rowCount).attr('id' , 'datatype_'+html);
 //    								$('#unit_'+pgaid+'_'+rowCount).attr('id' , 'unit_'+html);
 //    								$('#editpagpa_'+pgaid+'_'+rowCount).remove();
 //    								$('#unit_'+html).after('<a id="'+html+'" style="float:right;" title="{/literal}{$lang.default.formActionDeleteTooltip}{literal}" href="javascript:void(0)" onclick="deletePa('+html+')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>');

 //    								$('#'+html).after('<a id="editpa_'+html+'" style="float:right;height:12px;right: 10px;" title="{/literal}{$lang.default.formActionEditTooltip}{literal}" href="javascript:void(0)" class="btn btn-mini">Lưu</a>');

 //    								alert('Cập nhật thông tin thành công.');
 //    							}
 //    							else{
 //    								alert('Có lỗi trong quá trình cập nhật thông tin . Vui lòng thử lại');
 //    							}
 //    						}
 //    					});
 //    				}
 //    				else
 //    				{
 //    					alert('Vui lòng nhập tên thuộc tính');
 //    				}
 //    			}
	// });
    //initEditInline(fpcid);
}


function deleteGpa(selector , gpaid)
{
	if(gpaid > 0)
	{
		bootbox.confirm("{/literal}{$lang.controller.deleteProductGroupAttributeConfirm}{literal}",function(confirm){
			if(confirm)
			{
				if(gpaid > 0)
				{
					var dataString = 'id=' + gpaid;
					$.ajax({
						type : "post",
						dataType : "html",
						url : "/cms/productgroupattribute/deletegroupattributeajax",
						data : dataString,
						success : function(html){
							if(html == 'success'){
								$('#'+selector+gpaid).fadeOut();
							}else{
								bootbox.alert('Không thể xóa nhóm thuộc tính này .');
							}
						}
					});
				}
			}
		});
	}
}

function deletePa(paid)
{
	if(paid > 0)
	{
		bootbox.confirm("{/literal}{$lang.controller.deleteProductAttributeConfirm}{literal}",function(confirm){
			if(confirm)
			{
				if(paid > 0)
				{
					var dataString = 'id=' + paid;
					$.ajax({
						type : "post",
						dataType : "html",
						url : "/cms/productattribute/deleteattributeajax",
						data : dataString,
						success : function(html){
							if(html == 'success'){
								window.location.reload(true);
							}else{
								bootbox.alert('Không thể xóa thuộc tính này .');
							}
						}
					});
				}
			}
		});
	}
}

</script>
{/literal}
