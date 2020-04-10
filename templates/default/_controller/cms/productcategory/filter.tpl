<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_filter}</li>
</ul>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li {if $tab ==1}class="active"{/if}><a href="#tab1" data-toggle="tab">Filter thuộc tính sản phẩm</a></li>
		<li {if $tab ==2}class="active"{/if}><a href="#tab2" data-toggle="tab">Filter nhà sản xuất</a></li>
		<li {if $tab ==3}class="active"{/if}><a href="#tab3" data-toggle="tab">Cập nhật trọng số</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane {if $tab == 1}active{/if}" id="tab1">
			<form action="" method="post" name="myform" class="form-horizontal">
			    <div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_filter} - Danh mục {$productcategory->name}</h1></div>

			    <div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>
			        <input type="hidden" name="ftoken" value="{$smarty.session.productcategoryFilterToken}" />

			        {include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			        <div id="filterList">
			            {if $productcategory->parentid > 0}
			            <h1>{$lang.controller.labelFilterList}</h1>
			            <table class="table table-striped" id="filterListTable">
			            	<thead>
			            		<tr>
			            			<th>Đưa vào report</th>
			            			<th>{$lang.controller.labelDisplayorder}</th>
			            			<th>{$lang.controller.labelDisplay}</th>
			            			<th>{$lang.controller.labelPosition}</th>
			            			<th style="text-align: center;">Danh sách filter</th>
			            			<th></th>
			            		</tr>
			            	</thead>
			            	<tbody>
							{if $filterList|@count > 0}
								{foreach item=filter from=$filterList}
								<tr id="row{$filter->paid}">
									<td><input type="checkbox" name="fdisplayreport[{$filter->paid}]" value="1" {if $filter->displayreport == 1}checked="checked"{/if}></td>
									<td><input type="text" name="fdisplayorder[{$filter->paid}]" value="{$filter->displayorder}" class="input-mini" /></td>
									<td><input type="hidden" name="fname[{$filter->paid}]" value="{$filter->paname}" /><input type="text" class="input-medium" name="fdisplayname[{$filter->paid}]" value="{$filter->display}" /></td>
									<td>
										<select name="fposition[{$filter->paid}]" style="width:100px;">
											{html_options options=$positionList selected=$filter->position}
										</select>
									</td>
									<td>
										<div id="dfilter{$filter->paid}">
											{foreach key=key item=data from=$filter->filtername name=foo}
												<div class="rowa" id="row{$filter->paid}_{$key}">
													<a id="up{$filter->paid}_{$key}" href="javascript:void(0)" title="Lên" onclick="changeposition(0 , {$filter->paid} ,{$key})"><img src="{$currentTemplate}images/admin/icons/arrow-up-icon.png" /></a>
													<a id="down{$filter->paid}_{$key}" href="javascript:void(0)" title="Xuống" onclick="changeposition(1 , {$filter->paid} ,{$key})"><img src="{$currentTemplate}images/admin/icons/arrow-down-icon.png" /></a>
													<input id="ffiltername{$filter->paid}_{$key}" type="text" class="input-medium" name="ffiltername[{$filter->paid}][{$key}]" value="{$data}" />
													<select style="width:115px;" name="ftype[{$filter->paid}][{$key}]" id="ftype{$filter->paid}_{$key}" onchange="changetype({$filter->paid},{$key})">
														<option {foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type == 5}selected{/if}{/if}{/foreach} value="5">Chính xác</option>
														<option {foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type == 10}selected{/if}{/if}{/foreach} value="10">Gần đúng</option>
														<option {foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type == 15}selected{/if}{/if}{/foreach} value="15">Trọng số</option>
													</select>&nbsp;&nbsp;

													<select style=" {foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type != 5}display:none;{/if}{/if}{/foreach}width:200px;" name="fvalue[{$filter->paid}][{$key}][]" multiple="multiple" id="fexact{$filter->paid}_{$key}" class="datachoose">
													{foreach item=productAttribute from=$productAttributeList}
														{if $filter->paid == $productAttribute->id}
															{foreach item=rpa from=$productAttribute->actor}
																<option value="{$rpa->value}" {if is_array($filter->exactfilter)}
																	{foreach key=key1 item=data from=$filter->exactfilter}
																	{if $key == $key1}
																	{if in_array($rpa->value, $data)}selected="selected"{/if}
																	{/if}
																	{/foreach}
																	{/if}>{$rpa->value}</option>
															{/foreach}
														{/if}
													{/foreach}
													</select>
													<input style=" {foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type != 10}display:none;{/if}{/if}{/foreach}width:183px;" type="text" name="flikevalue[{$filter->paid}][{$key}]" id="flikevalue{$filter->paid}_{$key}" {if is_array($filter->likevalue)}
														{foreach item=data key=key1 from=$filter->likevalue}
															{if $key == $key1}
															value="{$data}"
															{/if}
														{/foreach}
													{/if}/>

													<input style="{foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type != 15}display:none;{/if}{/if}{/foreach}width:60px;" type="text" name="fweightfrom[{$filter->paid}][{$key}]" id="fweightfrom{$filter->paid}_{$key}" {if is_array($filter->weightfrom)}
														{foreach item=data key=key1 from=$filter->weightfrom}
															{if $key == $key1}
															value="{$data}"
															{/if}
														{/foreach}
													{/if}
													 />
													<span style="{foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type != 15}display:none;{/if}{/if}{/foreach}" id="unit{$filter->paid}_{$key}">
														{if is_array($filter->unit)}
														{foreach item=data key=key1 from=$filter->unit}
															{if $key == $key1}
															{$data}
															{/if}
														{/foreach}
														{/if}
													</span>&nbsp;&nbsp;
													<input style="{foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type != 15}display:none;{/if}{/if}{/foreach}width:60px;" type="text" name="fweightto[{$filter->paid}][{$key}]" id="fweightto{$filter->paid}_{$key}" {if is_array($filter->weightto)}
														{foreach item=data key=key1 from=$filter->weightto}
															{if $key == $key1}
															value="{$data}"
															{/if}
														{/foreach}
													{/if}/><span style="{foreach item=type key=key1 from=$filter->type}{if $key1 == $key}{if $type != 15}display:none;{/if}{/if}{/foreach}"  id="unit1{$filter->paid}_{$key}">
													{if is_array($filter->unit)}
														{foreach item=data key=key1 from=$filter->unit}
															{if $key == $key1}
															{$data}
															{/if}
														{/foreach}
													{/if}
													</span>
													<a class="delete{$filter->paid}_{$key}" style="color:red;" href="javascript:void(0)" onclick="removeitem({$filter->paid} , {$key})">Xóa</a>
												</div>
												<br/>
											{/foreach}
											<a style="margin-left:540px;" id="addrow{$filter->paid}" href="javascript:void(0)" onclick="addRow({$filter->paid} , {$key})">[+]Thêm</a>
										</div>
									</td>
									<td><input type="button" class="btn btn-danger" id="nondisplay{$filter->paid}" onclick="removeFilter({$filter->paid})" value="Không hiện" /></td>
								</tr>
								{/foreach}
							{/if}
							</tbody>
			            </table>
			            {/if}
                        <br/>
                        <h1>Phân khúc giá</h1>
                        <table class="table table-striped" id="priceListTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="text-align: center;">Tên hiển thị</th>
                                    <th style="text-align: center;">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                            {if $price->pricename|@count > 0}
                            {foreach item=pricename key=key from=$price->pricename}
                            <tr id="rowp_{$key}">
                                    <td>
                                        <a href="javascript:void(0)" title="Lên" onclick="changepriceposition(0,{$key})"><img src="{$currentTemplate}images/admin/icons/arrow-up-icon.png" /></a>
                                        <a href="javascript:void(0)" title="Xuống" onclick="changepriceposition(1,{$key})"><img src="{$currentTemplate}images/admin/icons/arrow-down-icon.png" /></a>
                                    </td>
                                    <td>
                                        <input id="fpricename{$key}" class="datainput" name="fpricename[]" style="margin-left: 77px;" value="{$pricename}"/>
                                    </td>
                                    <td>
                                        Từ <input id="fpricefrom{$key}" name="fpricefrom[]" placeholder="Giá"
                                        {foreach item=pricefrom key=key1 from=$price->pricefrom}
                                            {if $key == $key1 && $pricefrom > 0}value="{$pricefrom}"{/if}
                                        {/foreach}
                                         /> &nbsp;
                                        Đến <input id="fpriceto{$key}" name="fpriceto[]" placeholder="Giá"
                                        {foreach item=priceto key=key1 from=$price->priceto}
                                            {if $key == $key1 && $priceto > 0}value="{$priceto}"{/if}
                                        {/foreach}  />  &nbsp; &nbsp;
                                        <a style="color:red;" href="javascript:void(0)" onclick="removeitemprice({$key})">Xóa</a>
                                    </td>
                                </tr>
                            {/foreach}
                            {else}
                             <tr id="rowp_{$priceList|@count}">
                                    <td>
                                        <a href="javascript:void(0)" title="Lên" onclick="changepriceposition(0,{$priceList|@count})"><img src="{$currentTemplate}images/admin/icons/arrow-up-icon.png" /></a>
                                        <a href="javascript:void(0)" title="Xuống" onclick="changepriceposition(1,{$priceList|@count})"><img src="{$currentTemplate}images/admin/icons/arrow-down-icon.png" /></a>
                                    </td>
                                    <td>
                                        <input id="fpricename{$priceList|@count}" class="datainput" name="fpricename[]" style="margin-left: 77px;" value=""/>
                                    </td>
                                    <td>
                                        Từ <input id="fpricefrom{$priceList|@count}" name="fpricefrom[]" placeholder="Giá" /> &nbsp;
                                        Đến <input id="fpriceto{$priceList|@count}" name="fpriceto[]" placeholder="Giá" />  &nbsp; &nbsp;
                                        <a style="color:red;" href="javascript:void(0)" onclick="removeitemprice({$priceList|@count})">Xóa</a>
                                    </td>
                                </tr>
                            {/if}
                            </tbody>
                        </table>
                        <div><a style="float:right;" href="javascript:void(0)" onclick="addRowPrice()">[+]Thêm</a></div>
						 <div class="form-actions">
			                <input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
			            </div>
			        </div>

			        <br/><br/>
			        {if $productAttributeList|@count > 0}
			            <table class="table table-striped">
			                <thead>
			                    <tr>
			                        <th>{$lang.controller.labelAttribute}</th>
			                        <th>{$lang.controller.labelAttributeList}</th>
			                        <th></th>
			                    </tr>
			                </thead>
			            {foreach item=productAttribute from=$productAttributeList name=foo}
			                <tr>
			                    <td>{$productAttribute->name}</td>
			                    <td></td>
			                    <td>
									{if $filterList|@count > 0}
										{if in_array($productAttribute->id , $filterIdList)}
										<input type="hidden" id="fvalues{$productAttribute->id}" value="{foreach item=rpa from=$productAttribute->actor name=loops}{if $smarty.foreach.loops.last}{$rpa->value|escape:javascript}{else}{$rpa->value|escape:javascript}###{/if}{/foreach}" />

										<input class="btn btn-success" style="display:none;" type="button" id="fdisplay{$productAttribute->id}" value="{$lang.controller.labelDisplay}" onclick="getAttributeValue({$productAttribute->id}, '{$productAttribute->name}', '{$productAttribute->id}','{$productAttribute->unit}' , {$smarty.foreach.foo.index})" /><span id="choose{$productAttribute->id}">Đã chọn</span>
										{else}
										<input type="hidden" id="fvalues{$productAttribute->id}" value="{foreach item=rpa from=$productAttribute->actor name=loops}{if $smarty.foreach.loops.last}{$rpa->value|escape:javascript}{else}{$rpa->value|escape:javascript}###{/if}{/foreach}" />
										<input class="btn btn-success" type="button" id="fdisplay{$productAttribute->id}" value="{$lang.controller.labelDisplay}" onclick="getAttributeValue({$productAttribute->id}, '{$productAttribute->name}', '{$productAttribute->id}','{$productAttribute->unit}' , {$smarty.foreach.foo.index})" /><span id="choose{$productAttribute->id}" style="display:none;">Đã chọn</span>
										{/if}
									{else}
									<input type="hidden" id="fvalues{$productAttribute->id}" value="{foreach item=rpa from=$productAttribute->actor name=loops}{if $smarty.foreach.loops.last}{$rpa->value|escape:javascript}{else}{$rpa->value|escape:javascript}###{/if}{/foreach}" />

									<input class="btn btn-success" type="button" id="fdisplay{$productAttribute->id}" value="{$lang.controller.labelDisplay}" onclick="getAttributeValue({$productAttribute->id}, '{$productAttribute->name}', '{$productAttribute->id}','{$productAttribute->unit}',{$smarty.foreach.foo.index})" /><span id="choose{$productAttribute->id}" style="display:none;">Đã chọn</span>
									{/if}
								</td>
			                </tr>
			            {/foreach}
			            </table>
			        {/if}
			</form>
		</div><!-- end of tab1 -->

		<div class="tab-pane {if $tab == 2}active{/if}" id="tab2">
			{include file="notify.tpl" notifyError=$error1 notifySuccess=$success1 notifyWarning=$warning1}
			<form action="" method="post" name="vendor" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width: 50px;"><input class="check-all" type="checkbox" /></th>
							<th>TT hiển thị</th>
							<th>Hình ảnh</th>
							<th>Tên</th>
							<th>Số lượng sản phẩm</th>
							<th style="width: 375px;"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="5">


								<div class="bulk-actions align-left">
									<input type="submit" name="fsubmitvendorlist" class="btn" value="{$lang.default.formUpdateSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
						{if $vendorList|@count > 0}
						{foreach item=vendor from=$vendorList name=foo}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$vendor->id}" {if $vendorFilters|@count > 0}{if in_array($vendor->id, $vendorFilters)}checked="checked"{/if}{/if} /></td>

							<td><input class="input-mini" type="text" name="fvdisplayorder[{$vendor->id}]" value="{if $vendorFilters|@count > 0}{foreach item=vid from=$vendorFilters name=foo}{if $vid==$vendor->id}{$smarty.foreach.foo.index + 1}{/if}{/foreach}{/if}" /></td>
							<td>{if $vendor->image != ''}<img src="{$vendor->getSmallImage()}" style="width: 50px; height: 50px;" />{/if}</td>
							<td><span class="label label-info">{$vendor->name}</span></td>
							<td><span class="label">{$vendor->countproduct}</span></td>
							<td></td>
						</tr>
						{/foreach}
						{/if}
					</tbody>
				</table>
			</form>
		</div>

		<div class="tab-pane {if $tab == 3}active{/if}" id="tab3">
			{include file="notify.tpl" notifyError=$error2 notifySuccess=$success2 notifyWarning=$warning2}
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Thuộc tính</th>
							<th>Giá trị</th>
							<th>Trọng số</th>
						</tr>
					</thead>
					<tbody>
						{foreach item=productattribute from=$productAttributeList name=foo}
							{assign var="write" value="1"}
							<form id="myform" action="" method="post">
							{foreach item=relattr from=$productattribute->actor}

								<tr>
									<td>{if $write == 1}{$productattribute->name}{assign var="write" value="0"}{/if}</td>
									<td>{$relattr->value}</td>
									<td><input class="input-mini" name="fweight[{$relattr->paid}][{$relattr->valueseo}]" id="" value="{$relattr->weight}" /></td>
								</tr>
							{/foreach}
							<tr><td></td><td></td><td><input type="submit" name="fsubmitweightlist" class="btn" value="{$lang.default.formUpdateSubmit}" /></td></tr>
							</form>
						{/foreach}
					</tbody>
				</table>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript" language="Javascript">
$(document).ready(function(){
	{/literal}
	{foreach item=filter from=$filterList}
		{foreach key=key item=type from=$filter->type}
		{if $type == 5}
		$('#fexact{$filter->paid}_{$key}').select2();
		{/if}
		{/foreach}
	{/foreach}
	{literal}

});
function getAttributeValue(id, name, value, unit, number)
{
	var data = $('#fvalues'+id).val();
	if(data != '')
	{
		var htmlString = '';
		htmlString += '<tr id="row'+id+'">';

		htmlString += '<td><input type="checkbox" name="fdisplayreport['+id+']" /></td>';

		htmlString += '<td><input type="text" name="fdisplayorder['+id+']" class="input-mini" /></td>';
		

		htmlString += '<td><input type="hidden" name="fname['+id+']" value="'+name+'" /><input type="text" name="fdisplayname['+id+']" class="input-medium" value="'+name+'" /></td>';

		htmlString += '<td><select name="fposition['+id+']" style="width:100px;"><option value="1" selected="selected">Bên trái</option><option value="2">Ở giữa</option><option value="3">Tất cả</option></select></td>';

		htmlString += '<td><div id="dfilter'+id+'"><div class="rowa" id="row'+id+'_'+number+'" ><a id="up'+id+'_'+number+'" href="javascript:void(0)" title="Lên" onclick="changeposition(0 ,'+id+','+number+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-up-icon.png" /></a><a id="down'+id+'_'+number+'" href="javascript:void(0)" title="Lên" onclick="changeposition(1 ,'+id+','+number+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-down-icon.png" /></a><input style="margin-left:8px;" id="ffiltername'+id+'_'+number+'" type="text" class="input-medium" placeholder="Tên filter" name="ffiltername['+id+']['+number+']" /><select style="width:115px;margin-left:3px;" name="ftype['+id+']['+number+']" id="ftype'+id+'_'+number+'" onchange="changetype('+id+','+number+')"><option value="5">Chính xác</option><option value="10">Gần đúng</option><option value="15">Trọng số</option></select>&nbsp;&nbsp;<select placeholder="Chọn giá trị" id="fexact'+id+'_'+number+'" name="fvalue['+id+']['+number+'][]" multiple="multiple" class="datachoose" style="width:200px;">';
		var values = data.split("###");

		for(i = 0 ; i < values.length ; i++){
			htmlString += '<option value="'+ values[i] +'">'+ values[i] +'</option>';
		}
		htmlString += '</select><input style="display:none;width1:183px;margin-left:3px;" type="text" name="flikevalue['+id+']['+number+']" id="flikevalue'+id+'_'+number+'" placeholder="Giá trị tìm kiếm : key1,key2"/><input style="display:none;width:60px;margin-left:3px;" type="text" name="fweightfrom['+id+']['+number+']" id="fweightfrom'+id+'_'+number+'" placeholder="Từ giá trị"/><span style="display:none;" id="unit'+id+'_'+number+'">'+unit+'</span>&nbsp;&nbsp;<input style="display:none;width:60px;margin-left:3px;" type="text" name="fweightto['+id+']['+number+']" id="fweightto'+id+'_'+number+'" placeholder="Đến giá trị"/><span style="display:none;"  id="unit1'+id+'_'+number+'">'+unit+'</span></div><br/></div><a style="margin-left:540px;" id="addrow'+id+'" href="javascript:void(0)" onclick="addRow('+id+' , '+number+')">[+]Thêm</a></td>';


		htmlString += '<td><input type="button" class="btn btn-danger" id="nondisplay'+id+'" onclick="removeFilter('+id+')" value="Không hiện" /></td>';

		htmlString += '</tr>';

		$('#filterList').fadeIn();
		$('#filterListTable').find('tbody').append(htmlString);
		$('#fdisplay'+id).fadeOut();
		$('#choose'+id).fadeIn();

		$('#fexact'+id+'_'+number).select2();
	}
	else
	{
		bootbox.alert('{/literal}{$lang.controller.errorValueEmpty}{literal}');
	}
}

function addRow(id , number)
{
	var valuedata =  $('#fvalues'+id).val();
	var values = valuedata.split('#');
	var unit = $('#unit'+id+'_0').html();
	if(unit == null)
	{
		unit = '';
	}
	var htmlString = '';
	$('#addrow'+id).remove();
	number +=1;
	htmlString += '<div class="rowa" id="row'+id+'_'+number+'" class="rowa"><a id="up'+id+'_'+number+'" href="javascript:void(0)" title="Lên" onclick="changeposition(0 ,'+id+','+number+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-up-icon.png" /></a><a id="down'+id+'_'+number+'" href="javascript:void(0)" title="Lên" onclick="changeposition(1 ,'+id+','+number+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-down-icon.png" /></a><input id="ffiltername'+id+'_'+number+'" type="text" name="ffiltername['+id+']['+number+']" class="input-medium" placeholder="Tên filter" style="margin-left:8px;"/><select style="width:115px;margin-left:5px;" name="ftype['+id+']['+number+']" id="ftype'+id+'_'+number+'" onchange="changetype('+id+','+number+')"><option value="5">Chính xác</option><option value="10">Gần đúng</option><option value="15">Trọng số</option></select>&nbsp;&nbsp;<select placeholder="Chọn giá trị" id="fexact'+id+'_'+number+'" name="fvalue['+id+']['+number+'][]" multiple="multiple" class="datachoose" style="width:200px;">';
		//var values = value.split("###");

	for(i = 0 ; i < values.length ; i++){
			htmlString += '<option value="'+ values[i] +'">'+ values[i] +'</option>';
	}
	htmlString += '</select><input style="display:none;width:183px;margin-left:3px;" type="text" name="flikevalue['+id+']['+number+']" id="flikevalue'+id+'_'+number+'" placeholder="Giá trị tìm kiếm : key1,key2"/><input style="display:none;width:60px;margin-left:3px;" type="text" name="fweightfrom['+id+']['+number+']" id="fweightfrom'+id+'_'+number+'" placeholder="Từ giá trị"/><span style="display:none;" id="unit'+id+'_'+number+'">'+unit+'</span>&nbsp;&nbsp;<input style="display:none;width:60px;margin-left:3px;" type="text" name="fweightto['+id+']['+number+']" id="fweightto'+id+'_'+number+'" placeholder="Đến giá trị"/><span style="display:none;"  id="unit1'+id+'_'+number+'">'+unit+'</span><a id="delete'+id+'_'+number+'" style="color:red;" href="javascript:void(0)" onclick="removeitem('+id+' , '+number+')">Xóa</a></div><br/>';

	$('#dfilter'+id).append(htmlString);
	$('#dfilter'+id).after('<a style="margin-left:540px;" id="addrow'+id+'" href="javascript:void(0)" onclick="addRow('+id+' , '+number+')">[+]Thêm</a>')
	$('#fexact'+id+'_'+number).select2();
}

function removeFilter(id)
{
	bootbox.confirm("Are you sure ?",function(confirm){
		if(confirm){
			$('#row'+id).remove();
			$('#fdisplay'+id).fadeIn();
			$('#choose'+id).fadeOut();
		}
	});
}

function changetype(id,number)
{
	var type = $('#ftype'+id+'_'+number).val();

	if(type == 5)
	{
		$('#fexact'+id+'_'+number).show();
		$('#fexact'+id+'_'+number).select2();
		$('#flikevalue'+id+'_'+number).hide();
		$('#fweightto'+id+'_'+number).hide();
		$('#fweightfrom'+id+'_'+number).hide();
		$('#unit'+id+'_'+number).hide();
		$('#unit1'+id+'_'+number).hide();
	}

	if(type == 10)
	{
		$('#fexact'+id+'_'+number).hide();
		$('#s2id_fexact'+id+'_'+number).remove();
		$('#flikevalue'+id+'_'+number).show();
		$('#fweightto'+id+'_'+number).hide();
		$('#fweightfrom'+id+'_'+number).hide();
		$('#unit'+id+'_'+number).hide();
		$('#unit1'+id+'_'+number).hide();
	}

	if(type == 15)
	{
		$('#fexact'+id+'_'+number).hide();
		$('#s2id_fexact'+id+'_'+number).remove();
		$('#flikevalue'+id+'_'+number).hide();
		$('#fweightto'+id+'_'+number).show();
		$('#fweightfrom'+id+'_'+number).show();
		$('#unit'+id+'_'+number).show();
		$('#unit1'+id+'_'+number).show();
	}
}

function removeitem(paid , key)
{
	bootbox.confirm("Are you sure ?",function(confirm){
		if(confirm){
            var counter = $('#row'+paid+' .rowa').length;
			if(counter == 1)
            {
                $('#row'+paid).remove();
            }
            else
            {
                $('#row'+paid+'_'+key).prev('br').remove();
                $('#row'+paid+'_'+key).remove();
            }
		}
	});
}

function changeposition(type , id, number)
{

    var values =  $.map($('#fexact'+id+'_'+number+' option'), function(e) { return e.value; });
    var unit = $('#unit'+id+'_0').html();
    var htmlString = '';
    var ftype = $('#ftype'+id+'_'+number).val();
    var choosevalue = $("#fexact"+id+'_'+number).val() || [];
    var weightfrom = $('#fweightfrom'+id+'_'+number).val();
    var weightto = $('#fweightto'+id+'_'+number).val();
    var likevalue = $('#flikevalue'+id+'_'+number).val();
    var filtername = $('#ffiltername'+id+'_'+number).val();

    var htmlString = '';
    htmlString += '<div class="rowa" id="row'+id+'_'+number+'a" class="rowa"><a id="up'+id+'_'+number+'" href="javascript:void(0)" title="Lên" onclick="changeposition(0 ,'+id+','+number+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-up-icon.png" /></a><a id="down'+id+'_'+number+'" href="javascript:void(0)" title="Lên" onclick="changeposition(1 ,'+id+','+number+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-down-icon.png" /></a><input style="margin-left: 6px;" id="ffiltername'+id+'_'+number+'" type="text" name="ffiltername['+id+']['+number+']" class="input-medium" placeholder="Tên filter" style="margin-left:8px;" value="'+filtername+'"/><select style="width:115px;margin-left:5px;" name="ftype['+id+']['+number+']" id="ftype'+id+'_'+number+'" onchange="changetype('+id+','+number+')"><option '+((ftype==5) ? 'selected=selected' : '')+' value="5">Chính xác</option><option '+((ftype==10) ? 'selected=selected' : '')+' value="10">Gần đúng</option><option '+((ftype==15) ? 'selected=selected' : '')+' value="15">Trọng số</option></select>&nbsp;&nbsp;<select '+(ftype != 5 ? 'style="display:none;"' : '')+' placeholder="Chọn giá trị" id="fexact'+id+'_'+number+'" name="fvalue['+id+']['+number+'][]" multiple="multiple" class="datachoose" style="width:200px;">';
    //var values = value.split("###");

    for(i = 0 ; i < values.length ; i++){
        var have = false;
        for(j = 0 ; j < choosevalue.length ; j++){
            if(values[i] == choosevalue[j])
            {
                have = true;
                break;
            }
        }

        if(have)
        {
            htmlString += '<option selected="selected" value="'+ values[i] +'">'+ values[i] +'</option>';
        }
        else
        {
            htmlString += '<option value="'+ values[i] +'">'+ values[i] +'</option>';
        }
    }
    htmlString += '</select><input '+(ftype != 10 ? 'style="display:none;width:183px;margin-left3px;"' : 'style="width:183px;margin-left3px;"')+' type="text" name="flikevalue['+id+']['+number+']" id="flikevalue'+id+'_'+number+'" placeholder="Giá trị tìm kiếm : key1,key2" value="'+likevalue+'"/><input style="'+(ftype != 15 ? 'display:none;' : '')+'width:60px;margin-left:3px;" type="text" name="fweightfrom['+id+']['+number+']" id="fweightfrom'+id+'_'+number+'" placeholder="Từ giá trị" value="'+weightfrom+'"/><span style="'+(ftype != 15 ? 'display:none;' : '')+'" id="unit'+id+'_'+number+'">'+unit+'</span>&nbsp;&nbsp;<input style="'+(ftype != 15 ? 'display:none;' : '')+'width:60px;margin-left:3px;" type="text" name="fweightto['+id+']['+number+']" id="fweightto'+id+'_'+number+'" placeholder="Đến giá trị" value="'+weightto+'"/><span style="'+(ftype != 15 ? 'display:none;' : '')+'"  id="unit1'+id+'_'+number+'">'+unit+'</span><a id="delete'+id+'_'+number+'" style="color:red;" href="javascript:void(0)" onclick="removeitem('+id+' , '+number+')">Xóa</a></div>';

	if(type == 0)
	{
		if($('#row'+id+'_'+number).prev('br').prev('.rowa').attr('id') != undefined)
		{
			$('#row'+id+'_'+number).next().remove();
			$('#row'+id+'_'+number).prev('br').prev('.rowa').before(htmlString+'<br/>');
			$('#row'+id+'_'+number).remove();
			$('#row'+id+'_'+number+'a').attr('id' , 'row'+id+'_'+number);
            if(ftype == 5)
            {
                $("#fexact"+id+'_'+number).select2();
            }
		}
	}

	else if(type == 1)
	{
		var datahtml = $('#row'+id+'_'+number).html();
		if($('#row'+id+'_'+number).next('br').next('.rowa').attr('id') != undefined)
		{
			$('#row'+id+'_'+number).next('br').next('.rowa').after('<br/>'+htmlString);
			$('#row'+id+'_'+number).remove();
			$('#row'+id+'_'+number+'a').attr('id' , 'row'+id+'_'+number);
			$('#row'+id+'_'+number).prev('br').prev('.rowa').prev().remove();
            $('#s2id_fexact'+id+'_'+number).remove();
            if(ftype == 5)
            {
                $("#fexact"+id+'_'+number).select2();
            }
		}
	}
}

function addRowPrice()
{
    var idcuurent = $('#priceListTable tr:last').attr('id');
    ids = idcuurent.split("_");
    id =  parseInt(ids[1]) + 1;
    $('#priceListTable').append('<tr id="rowp_'+id+'"><td><a href="javascript:void(0)" title="Lên" onclick="changepriceposition(0,'+id+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-up-icon.png" /></a><a href="javascript:void(0)" title="Xuống" onclick="changepriceposition(1,'+id+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-down-icon.png" /></a></td><td><input id="fpricename'+id+'" name="fpricename[]" style="margin-left: 77px;"/></td><td>Từ <input style="margin-right:4px;" id="fpricefrom'+id+'" name="fpricefrom[]" placeholder="Giá" /> &nbsp;Đến <input style="margin-right:4px;" id="fpriceto'+id+'" name="fpriceto[]" placeholder="Giá" />  &nbsp; &nbsp;<a style="color:red;" href="javascript:void(0)" onclick="removeitemprice('+id+')">Xóa</a></td></tr>');
}
function removeitemprice(id)
{
    bootbox.confirm("Are you sure ?",function(confirm){
        if(confirm){
            $('#rowp_'+id).remove();
        }
    });
}
function changepriceposition(type , id)
{
    var pricename = $('#fpricename'+id).val();
    var pricefrom = $('#fpricefrom'+id).val();
    var priceto = $('#fpriceto'+id).val();
    if(type == 0)
    {
        if($('#rowp_'+id).prev().attr('id') != undefined)
        {
            $('#rowp_'+id).prev().before('<tr id="rowap_'+id+'"><td><a href="javascript:void(0)" title="Lên" onclick="changepriceposition(0,'+id+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-up-icon.png" /></a><a href="javascript:void(0)" title="Xuống" onclick="changepriceposition(1,'+id+')"><img src="{/literal}{$currentTemplate}{literal}images/admin/icons/arrow-down-icon.png" /></a></td><td><input id="fpricename'+id+'" name="fpricename[]" style="margin-left: 77px;" value="'+pricename+'"/></td><td>Từ <input style="margin-right:4px;" id="fpricefrom'+id+'" name="fpricefrom[]" placeholder="Giá" value="'+pricefrom+'" /> &nbsp;Đến <input style="margin-right:4px;" id="fpriceto'+id+'" name="fpriceto[]" placeholder="Giá" value="'+priceto+'" />  &nbsp; &nbsp;<a style="color:red;" href="javascript:void(0)" onclick="removeitemprice('+id+')">Xóa</a></td></tr>');
            $('#rowp_'+id).remove();
            $('#rowap_'+id).attr('id' , 'rowp_'+id);
        }
    }

    if(type == 1)
    {
        var datahtml = $('#rowp_'+id).html();
        if($('#rowp_'+id).next().attr('id') != undefined)
        {
            $('#rowp_'+id).next().after('<tr id="rowap_'+id+'">'+datahtml+'</tr>');
            $('#rowp_'+id).remove();
            $('#rowap_'+id).attr('id' , 'rowp_'+id);
        }
    }
}
</script>
{/literal}
