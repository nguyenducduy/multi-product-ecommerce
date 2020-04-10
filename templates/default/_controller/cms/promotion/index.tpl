<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Promotion</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_promotion"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right "><a target="_blank" class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/product/exportproductbuying">Export thông tin khuyến mãi</a></li>
		<!--<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>-->
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.promotionBulkToken}" />
				<table class="table table-striped">

				{if $promotions|@count > 0}
					<thead>
						<tr>
							<th width="30">{$lang.controller.labelId}</th>

							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
                            <th>{$lang.controller.labelStartdate}</th>
                            <th>{$lang.controller.labelEnddate}</th>
							<th>{$lang.controller.labelIsnew}</th>
							<th>{$lang.controller.labelIscombo}</th>
							<th>{$lang.controller.labelIsunlimited}</th>
							<th>{$lang.controller.labelIshot}</th>
							<th>{$lang.controller.labelIsactived}</th>
						</tr>
					</thead>

                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <div class="pagination">
                                   {assign var="pageurl" value="page/::PAGE::"}
                                    {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>

					<tbody>
					{foreach item=promotion from=$promotions}

						<tr>
							<td style="font-weight:bold;"><span class="badge">{$promotion->id}</span></td>


							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$promotion->id}" rel="shadowbox">{$promotion->name}</a></td>
                            <td>{$promotion->startdate|date_format:"%d/%m/%Y %H:%m:%S"}</span></td>
                            <td>{if $smarty.now>$promotion->enddate}<span class="badge badge-important">{$promotion->enddate|date_format:"%d/%m/%Y %H:%m:%S"}</span>{else}{$promotion->enddate|date_format:"%d/%m/%Y %H:%m:%S"}{/if}</td>
							<td>{if $promotion->isnew==1} <i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIsnew}"></i>{/if}</td>
							<td>{if $promotion->iscombo==1} <i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIscombo}"></i>{/if}</span></td>
							<td>{if $promotion->isunlimited==1} <i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIsunlimited}"></i>{/if}</td>
							<td>{if $promotion->ishot==1} <i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIshot}"></i>{/if}</td>
							<td>{if $promotion->isactived==1} <i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIsactived}"></i>{/if}</td>
						</tr>
					{/foreach}
					</tbody>
				{else}
					<tr>
						<td colspan="9"> {$lang.default.notfound}</td>
					</tr>
				{/if}

				</table>
			</form>

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
        <form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
            <table>
                <tr><td align="right">{$lang.controller.labelName}: </td>
				    <td style="text-align:left"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="" /> </td>
                </tr>
                <tr>
                    <td align="right">{$lang.controller.labelId}</td>
                    <td style="text-align:left">
                        <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="" />
                        <input type="button" value="Đồng bộ ERP" class="btn btn-primary" id="btnsynpromotionbyid" onclick="gosynerp();"  />
                        <input type="button" value="Xóa Khuyến mãi này" class="btn btn-primary" id="btndelpromotionbyid" onclick="godeletepromo();"  />
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">{$lang.controller.formKeywordLabel}</td>
                    <td>
                        <input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
                        <select name="fsearchin" id="fsearchin">
                            <option value="">{$lang.controller.formKeywordInLabel}</option>
                            <option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option>
                            <option value="description" {if $formData.fsearchin eq "description"}selected="selected"{/if}>Nội dung chương trình</option>
                        </select>
                    </td>
                </tr>
				<tr>
				    <td colspan="2"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
		        </tr>

            </table>
        </form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/promotion/index";
		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}

		var keyword = $("#fkeyword").val();
		if(keyword.length > 0)
		{
			path += "/keyword/" + keyword;
		}

		var keywordin = $("#fsearchin").val();
		if(keywordin.length > 0)
		{
			path += "/searchin/" + keywordin;
		}

		document.location.href= path;
	}

    function gosynerp()
    {
        var path = rooturl + controllerGroup + "/promotion/syncerpajax";
        var id = $('#fid').val();
        if(id.length > 0)
        {
            path += '/id/' + id;
            $("#btnsynpromotionbyid").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#btnsynpromotionbyid").hide();
            $.post(path,{}, function(data){
            	if(data && data.success==1)
            	{
            		document.location.href = rooturl + controllerGroup + '/promotion/index/id/' + id;
            	}
            	else
        			showGritterError('Khuyến mãi đã có hoặc lỗi trong quá trình đồng bộ.');
        		$("img.tmp_indicator").remove();
            	$("#btnsynpromotionbyid").show();
            }, 'json');
        }
        else
        		showGritterError('Nhập mã khuyến mãi');
    }
    function godeletepromo()
    {
        var path = rooturl + controllerGroup + "/promotion/deletepromotionbyidajax";
        var id = $('#fid').val();
        if(id.length > 0)
        {
            path += '/id/' + id;
            $("#btndelpromotionbyid").after('<img class="tmp_indicator tmp_indicator2" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#btndelpromotionbyid").hide();
            $.post(path,{}, function(data){
            	if(data && data.success==1)
            	{
            		showGritterSuccess('Bạn đã xóa khuyến mãi thành công');
            	}
            	else
        			showGritterError('Lỗi trong quá trình xóa khuyến mãi vui lòng thử lại');
        		$("img.tmp_indicator2").remove();
            	$("#btndelpromotionbyid").show();
            }, 'json');
        }
        else
        		showGritterError('Nhập mã khuyến mãi cần xóa');
    }
</script>
{/literal}




