<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">CheapProduct</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_cheapproduct"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_cms}{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		
	</ul>
	<div class="tab-content">
		<div id="tab1">
            {include file="notify.tpl" notifyError=$error notifySuccess=$success}
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelProductName}: <input type="text" name="fsearchproduct" id="fsearchproduct" value="{$formData.fsearchproduct|@htmlspecialchars}" />
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchChipProduct();"  />		        
			</form>
            <form action="{$conf.rooturl}{$controllerGroup}/{$controller}/update" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
                <div id="resultcheapproduct">

                </div>
                <div id="accessoriesproduct" {if empty($cheapproducts)}style="display:none;"{/if}><h1>{$lang.controller.labelProductListChoose}</h1><table class="table" id="choose"><thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Barcode</th>
                        <th>Danh mục</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead><tbody>
                {if !empty($cheapproducts)}{$cheapproducts}{/if}
                </tbody></table></div>
                <div class="form-actions">
                    <input type="submit" class="btn btn-large btn-primary" value=" {$lang.controller.labelUpdate} " name="fsubmit">
                </div>
            </form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function searchChipProduct()
    {
        if($('#fsearchproduct').val() != '')
        {
            var dataString = "pname=" + $('#fsearchproduct').val();
            $.ajax({
                type : "post",
                dataType : "html",
                url : "/cms/cheapproduct/searchProductAjax",
                data : dataString,
                success : function(html){
                    if(html != ''){
                        $('#resultcheapproduct').html(html);
                        if($('#accessoriesproduct').attr('display') != 'none'){
                            $('#accessoriesproduct').fadeIn(10);
                        }
                    }else{
                        $('#resultcheapproduct').html('{/literal}{$lang.controller.errNotFound}{literal}');
                    }
                }
            });
        }
        else
        {
            bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
        }
    }


    function chooseFunction(id)
    {
        if(id > 0)
        {
            //kiem tra xem san pham nay da duoc chon hay chua ?
            if($('#'+'_'+id).length == 0)
            {
                var imgSource = $('#images_'+id).attr('src');
                var pid = $('#pid').html();
                var barcode = $('#barcode').html();
                var category = $('#categorys_'+id).html();
                var productName = $('#names_'+id).html();
                var productInstock = $("#instocks_"+id).html();
                var productPrice = $('#prices_'+id).html();
                var data = '<tr id="row'+'_'+id+'">';
                data += '<td>';
                if(imgSource != undefined)
                {
                    data += '<a href="'+imgSource+'" rel="shadowbox" ><img src="'+imgSource+'" width="100" height="100" /></a>';
                }
                data += '</td>';
                data += '<td>'+pid+'</td>';
                data += '<td>'+barcode+'</td>';
                data += '<td><span class="label label-info">'+category+'</span></td>';
                data += '<td><input type="hidden" name="listpids[]" value="'+id+'" id="'+'_'+id+'" />'+productName+'</td>';
                data += '<td>'+productInstock+'</td>';
                data += '<td>'+productPrice+'</td>';
                data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+')" value="Remove" /></td>';
                data += '</tr>';
                $('#choose').find('tbody').append(data);
                $('#rows'+'_'+id).fadeOut(10);
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
        $('#row_'+id).fadeIn(10);
    }
</script>
{/literal}