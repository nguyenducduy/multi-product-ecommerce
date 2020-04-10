<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Homepage</a> <span class="divider">/</span></li>
	<li class="active">Danh sÃ¡ch</li>
</ul>



<div class="page-header" rel="menu_homepage"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<!-- <li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_listproduct} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li> -->
		{if $rolepromotion}
		<li><a href="#tab3" data-toggle="tab">{$lang.controller.title_listpromotion} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li>
		{/if}
		<li><a href="#tab4" data-toggle="tab">{$lang.controller.title_listnews} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li>
		<li {if $formData.tab == 5 || $formData.tab ==0}class="active"{/if}><a href="#tab5" data-toggle="tab">Danh mục sản phẩm</a></li>
		<li {if $formData.tab == 6}class="active"{/if}><a href="#tab6" data-toggle="tab">Sản phẩm bán chạy</a></li>		
		<!--<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>-->
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<!-- <div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.homepageBulkToken}" />

				<div class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/type/5">ThÃªm</a></div>
				<br /><br />

				<table class="table table-condensed">

				{if $homepageproduct|@count > 0}
					<thead>
						<tr>

							<th>{$lang.controller.labelDisplayorder}</th>
							<th></th>
							<th>{$lang.controller.productname}</th>
							<th width="140"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="bulk-actions align-left">
									<input type="submit" name="fsubmitchangeorderproduct" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=homepage from=$homepageproduct}
						<tr>
							<td colspan="4"><span class="label label-info">{$homepage->categoryactor->name}</span>
								<div class="pull-right"><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$homepage->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i>Cáº­p nháº­t</a></div>
								<br />
								<table class="table table-condensed">

									{if $homepage->objectlist|@count > 0}
									<thead>
										<tr>

											<th>{$lang.controller.labelDisplayorder}</th>
											<th></th>
											<th>{$lang.controller.productname}</th>
											<th width="140"></th>
										</tr>
									</thead>
									{foreach item=product key=key from=$homepage->objectlist name=foo}
										{if $product->id > 0}

										<tr id="p{$homepage->id}_{$product->id}">
											<td><input type="text" class="input-mini" name="forderproduct[{$homepage->id}][{$product->id}]" value="{$key+1}" /></td>
											<td>
												{if $product->image != ''}
												<a href="{$product->getImage()}" rel="shadowbox"><img src="{$product->getSmallImage()}" alt="{$product->name}" width="50px" height="50px"></a>
												{/if}
											</td>
											<td><a href="{$conf.rooturl_cms}product/index/id/{$product->id}" target="_blank">{$product->name}</a></td>
											<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteHomepageObject({$homepage->id} , {$product->id} , 5)"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
										</tr>


										{/if}
									{/foreach}
								{/if}
								</table>
							</td>
						</tr>
					{/foreach}
					</tbody>


				{else}
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
				{/if}

				</table>
			</form>

		</div> --><!-- end #tab 1 -->

		{if $rolepromotion}
		<div class="tab-pane" id="tab3">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			<div class="pull-right"><a class="pull-right btn btn-success" href="{if isset($promotionhomeid)}{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$promotionhomeid}{else}{$conf.rooturl}{$controllerGroup}/{$controller}/add/type/10{/if}">Thêm</a></div>

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.homepageBulkToken}" />
				<table class="table table-striped">

				{if $homepagepromotion|@count > 0}
					<thead>
						<tr>

							<th>{$lang.controller.labelDisplayorder}</th>
							<th></th>
							<th>{$lang.controller.productname}</th>
							<th width="140"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->


								<div class="bulk-actions align-left">
									<input type="submit" name="fsubmitchangeorderpromotion" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>

						{foreach item=homepage from=$homepagepromotion}
						{if $homepage->objectlist|@count > 0}
									{foreach item=product key=key from=$homepage->objectlist name=foo}
										{if $product->id > 0}

										<tr id="pr{$homepage->id}_{$product->id}">
											<td><input type="text" class="input-mini" name="forderpromotion[{$homepage->id}][{$product->id}]" value="{$key+1}" /></td>
											<td>
												{if $product->image != ''}
												<a href="{$product->getImage()}" rel="shadowbox"><img src="{$product->getSmallImage()}" alt="{$product->name}" width="50px" height="50px"></a>
												{/if}
											</td>
											<td><a href="{$conf.rooturl_cms}product/index/id/{$product->id}" target="_blank">{$product->name}</a></td>
											<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteHomepageObject({$homepage->id} , {$product->id} , 10)"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
										</tr>


										{/if}
									{/foreach}
								{/if}
						{/foreach}
					</tbody>


				{else}
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
				{/if}

				</table>
			</form>

		</div><!-- end #tab 3 -->
		{/if}

		<div class="tab-pane" id="tab4">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<div class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/type/15">Thêm</a></div><br /><br />

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.homepageBulkToken}" />
				<table class="table table-striped">

				{if $homepagenews|@count > 0}

					<tfoot>
						<tr>
							<td colspan="8">
								<div class="bulk-actions align-left">
									<input type="submit" name="fsubmitchangeordernews" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=homepage from=$homepagenews}
						<tr>
							<td colspan="4"><span class="label label-info">{$homepage->categoryactor->name}</span>
								<div class="pull-right"><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$homepage->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i>Cập nhật</a></div>
								<br />
								<table class="table table-condensed">
									<thead>
										<tr>
										   <th>{$lang.controller.labelDisplayorder}</th>

											<th></th>
											<th>Tiêu đề</th>
											<th width="140"></th>
										</tr>
									</thead>
									{if $homepage->objectlist|@count > 0}
									{foreach item=news key=key from=$homepage->objectlist name=foo}
										{if $news->id > 0}

										<tr id="n{$homepage->id}_{$news->id}">
											<td><input type="text" class="input-mini" name="fordernews[{$homepage->id}][{$news->id}]" value="{$key+1}" /></td>
											<td>
												{if $news->image != ''}
												<a href="{$news->getImage()}" rel="shadowbox"><img src="{$news->getSmallImage()}" alt="{$news->title}" width="50px" height="50px"></a>
												{/if}
											</td>
											<td><a href="{$conf.rooturl_cms}news/index/id/{$news->id}" target="_blank">{$news->title}</a></td>
											<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteHomepageObject({$homepage->id} , {$news->id} , 15)"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
										</tr>


										{/if}
									{/foreach}
								{/if}
								</table>
							</td>
						</tr>
					{/foreach}
					</tbody>


				{else}
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
				{/if}

				</table>
			</form>

		</div><!-- end #tab 4 -->

		<div class="tab-pane {if $formData.tab == 5 || $formData.tab ==0}active{/if}" id="tab5">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			{include file="tinymce.tpl"}
			<form action="" method="post" id="myform">
				<input type="hidden" name="tab" value="5" />
				<table class="table table-condensed">
					<tbody>
						{foreach item=homepage from=$homepages}
						{if $homepage->categoryactor->id > 0}
						<tr>
							<td><span class="label label-info">{$homepage->categoryactor->name}</span></td>
							<td>
								<input id="" class="input-xlarge" name="fsubcat[{$homepage->id}]" style="border:1px solid #b9b9b9" value ="{$homepage->subcategory}" />&nbsp;&nbsp;
								{assign var=homepageid value=$homepage->id}
								{if !empty($productcategoryhomepagelist.$homepageid)}
								{foreach item=category from=$productcategoryhomepagelist.$homepageid name=foo}
								<a href="{$conf.rooturl_cms}productcategory/index/id/{$category}">{$category}</a>{if !$smarty.foreach.foo.last},{/if}
								{/foreach}
								{/if}
								<br/><br/>
								<b>Block text</b> : <textarea name="fblockhomepage[{$homepage->id}]" id="fblockhomepage{$homepage->id}" rows="7" class="input-xxlarge">{$homepage->blockhomepage}</textarea><br/><br/>
								<b>Block banner right</b> : <textarea name="fblockbannerright[{$homepage->id}]" id="fblockbannerright{$homepage->id}" rows="7" class="input-xxlarge">{$homepage->blockbannerright}</textarea>
							</td>
							<td>
								<input id="" class="input-small" style="border:1px solid #b9b9b9" name="fdisplayorder[{$homepage->id}]" value="{$homepage->displayorder}" />
							</td>
						</tr>
						{/if}
						{/foreach}
					</tbody>
				</table>
				<div class="form-actions" style="text-align:center;">
					<input type="submit" name="fupdatesubcat" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
					<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
				</div>
			</form>

		</div><!--end #tab5-->
		<div class="tab-pane {if $formData.tab == 6}active{/if}" id="tab6">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			<form class="form-inline" method="post" action="">
				<input type="hidden" name="tab" value="6" />
				Từ khóa : <input class="input-xlarge" name="fkeywordsearch" id="fkeywordsearch" placeholder="Id, Barcode , Tên sản phẩm ..." /> &nbsp;
				Danh mục : 
				<select id="fcategorysearch" style="width:200px;">
					<option value="0">Tất cả</option>
					{foreach item=productcategory from=$productcategorylist}
					<option value="{$productcategory->id}">{$productcategory->name}</option>
					{/foreach}
				</select>
				<input type="button" id="fbtnsearchtopsell" value="Tìm kiếm" class="btn btn-primary" />
				<input type="button" id="fbtndeleteseach" value="Xóa kết quả tìm kiếm" class="btn btn-danger" />
				<div id="resulttopsell">
					
				</div>
				<div style="height:10px;"></div>
				<div id="productlisttopsell" {if $topsellproducts|@count == 0}style="display:none;"{/if}>
					<h1>Sản phẩm được chọn</h1>
					<table class="table table=striped" id="topproducts">
						<thead>
							<tr>
								<th>TT hiển thị</th>
								<th>Hình ảnh</th>								
								<th>Id</th>
								<th>Barcode</th>
								<th>Tên sản phẩm</th>
								<th>Danh mục</th>
								<th>Giá</th>
								<th>Số lượng</th>
								<th></th>								
							</tr>
						</thead>
						<tbody>
							{foreach item=product from=$topsellproducts name=foo}
							<tr id="row_{$product->id}">
								<td><input class="input-mini" name="ftopselldisplayorder[{$product->id}]" value="{$smarty.foreach.foo.index+1}" /></td>
								<td>{if $product->image !=""}<a href="{$product->getSmallImage()}" rel="shadowbox"><image id="images_{$product->id}" src="{$product->getSmallImage()}" width="100px;" height="100px;" /></a>{/if}</td>								
								<td>{$product->id}</td>
								<td>{$product->barcode}</td>
								<td>{$product->name}</td>
								<td><span class="label label-info">{$product->categoryactor->name}</span></td>
								<td>{if $product->finalprice}{$product->finalprice|number_format}{else}{$product->sellprice|number_format}{/if}</td>
								<td>{$product->instock|number_format}</td>
								<td><input type="button" class="btn btn-danger" id="btndel{$product->id}" onclick="deletetopproduct('{$product->id}')" value="Xóa" /></td>								
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
				<div class="form-actions" style="text-align:center;">
					<input type="submit" name="fsubmittopsell" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />					
				</div>
			</form>
		</div><!-- end #tab6 -->

		<!--<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelType}:
				<select id="ftype" onchange="getCategory()">
					<option value="0">-------------</option>
					{html_options options=$typeList selected=$formData.ftype}
				</select> -

				{$lang.controller.labelCategory}:
				<select id="fcategory">
					<option value="-1">----------------</option>
				</select>
				 -

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> -




				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />

			</form>
		</div>--><!-- end #tab2 -->
	</div>
</div>

{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$("#fcategorysearch").select2();
    	
    	$("#fbtndeleteseach").click(function(){
    		$("#resulttopsell").html('');    		
    		$("#fkeywordsearch").val('');
    	})
    	
		$("#fbtnsearchtopsell").click(function(event) {
			var keywordsearch = $("#fkeywordsearch").val();
			var categorysearch =$("#fcategorysearch").val();
			if(keywordsearch !== ""){
				url = rooturl_cms + 'homepage/loadproductajax';
				$.ajax({
					url: url,
					type: 'POST',
					dataType: 'html',
					data: {keywordsearch:keywordsearch , categorysearch:categorysearch},
					success : function(html){
						if(html === '-1'){
							bootbox.alert('Vui lòng nhập từ khóa để tìm kiếm.');
						}else if(html === '0'){
							bootbox.alert('Không tìm thấy dữ liệu mà bạn tìm kiếm.');
						}else{
							$("#resulttopsell").html(html);
						}
					}
				})				
				
			}else{
				bootbox.alert('Vui lòng nhập từ khóa để tìm kiếm.');
			}
		});
	});
	
	function deletetopproduct(pid){
		$("#row_"+pid).remove();
	}

	function chooseFunction(id)
	{
		if(id > 0)
		{
			//kiem tra xem san pham nay da duoc chon hay chua ?
			if($('#'+id).length == 0)
			{
				if( $("#productlisttopsell :hidden")){
					$("#productlisttopsell").show();
				}

				var imgSource = $('#images_'+id).attr('src');
				var category = $('#categorys_'+id).html();
				var productName = $('#names_'+id).html();
				var instock = $('#instocks_'+id).html();
				var productPrice = $('#prices_'+id).html();
				var pid = $("#pid_" + id).html();
				var pbarcode = $("#pbarcode_" + id).html();
				var data = '<tr id="row_'+id+'">';				
				data += '<td><input class="input-mini" name="ftopselldisplayorder['+id+']" value="0" /></td>';
				data += '<td style="width:228px;">';
				if(imgSource != undefined)
				{
					data += '<a href="'+imgSource+'" rel="shadowbox" ><img src="'+imgSource+'" width="100px" height="100px" /></a>';
				}
				data += '</td>';
				//data += '<td>'+category+'</td>';
				data += '<td>'+pid+'</td>';
				data += '<td>'+pbarcode+'</td>';
				data += '<td style="width:527px;">'+productName+'</td>';
				data += '<td>'+category+'</td>';
				data += '<td>'+productPrice+'</td>';
				data += '<td>'+instock+'</td>';
				data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+')" value="Remove" /></td>';
				data += '</tr>';
				$('#productlisttopsell').find('tbody').append(data);
				$('#rows'+id).fadeOut();
			}
			else
			{
				bootbox.alert('{/literal}{$lang.controller.errProductChoose}{literal}');
			}
		}
	}
	function clearFunction(id)
	{
		$('#row_'+id).remove();
		$('#rows'+id).fadeIn();
	}

	function gosearch()
	{
		var path = rooturl + controllerGroup + "/homepage/index";


		var category = $('#fcategory').val();
		if(category.length > 0)
		{
			path += '/category/' + category;
		}

		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
		}


		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}


		document.location.href= path;
	}
	function getCategory()
	{
		var type = $('#ftype').val();
		if(type != '0')
		{
			var datastring = 'type='+type;
			$.ajax({
				type : 'post',
				url : '/cms/homepage/getcategoryajax',
				dataType : 'html',
				data : datastring,
				success : function(html){
					$('#fcategory').html('<option value="-1">----------------</option>' + html);
				}
			});
		}
	}
</script>
{/literal}




