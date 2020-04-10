<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Installment</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_installment"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}

	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.installmentBulkToken}" />
				<table class="table table-striped">

				{if $installments|@count > 0}
					<thead>
						<tr>

							<th><a href="{$filterUrl}sortby/invoiceid/sorttype/{if $formData.sortby eq 'invoiceid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelInvoiceid}</a></th>
							<!--<th>{$lang.controller.labelPid}</th>                            -->
                            <th>{$lang.controller.labelOrderCRM}</th>
                            <th>{$lang.controller.labelPricesell}</th>
							<!--<th>{$lang.controller.labelGender}</th>-->
							<th>{$lang.controller.labelFullname}</th>
							<th>{$lang.controller.labelPhone}</th>
							<th>{$lang.controller.labelInstallmentmonth}</th>
							<th>{$lang.controller.labelSegmentpercent}</th>
							<th>{$lang.controller.labelDatecreate}</th>
							<th>Ngày lưu CRM</th>
							<th></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl``$paginateurl2`"}
								</div> <!-- End .pagination -->



								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=installment from=$installments}

						<tr>
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/detail/id/{$installment->id}" rel="shadowbox[width=700, height=500]">{$installment->invoiceid}</a></td>
                            <!--<td>{$installment->pid}</td>-->
                            <td>{$installment->installmentcrm}</td>
							<td>{$installment->pricesell|number_format}</td>
							<!--<td>{$installment->gender}</td>-->
							<td>{$installment->fullname}</td>
							<td>{$installment->phone}</td>
							<td><span class="label label-warning">{$installment->installmentmonth}</span></td>
							<td><span class="label label-important">{$installment->segmentpercent}%</span></td>
							<td>{$installment->datecreate|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$installment->installmentcrmdate|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{if $installment->installmentcrm == 0}<a class="btn btn-primary" href="javascript: void(0)" onclick="updatetocrm('{$installment->id}')">Lưu xuống CRM</a>{/if}</td>
							<!--<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$installment->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$installment->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>-->
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

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				<table>
				<tr><td>
				{$lang.controller.labelInvoiceid}: </td><td align="left"><input type="text" name="finvoiceid" id="finvoiceid" value="{$formData.finvoiceid|@htmlspecialchars}" class="input-mini" /></td><td></td></tr>

				<tr><td>
				{$lang.controller.labelPhone}: </td><td align="left"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-mini" /></td><td></td></tr>

				<tr><td>
				{$lang.controller.labelEmail}: </td><td align="left"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-mini" /></td><td></td></tr>

				<tr><td> Ngày tạo đơn hàng: </td><td align="left"><input type="text" name="fstartdate" id="fstartdate" value="{$formData.fstartdate|date_format:"%d/%m/%Y"}" class="input-medium inputdatepicker" />&nbsp;<input type="text" name="fenddate" id="fenddate" value="{$formData.fenddate|date_format:"%d/%m/%Y"}" class="input-medium inputdatepicker" /></td><td></td></tr>

				<tr><td></td><td>
				<input type="button" value="Xem đơn hàng chưa thành công" class="btn btn-primary" onclick="gosearchnosuccess();"  />&nbsp;<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td><td></td></tr>

			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/installment/index";

		/*
		var pid = $('#fpid').val();
		if(pid.length > 0)
		{
			path += '/pid/' + pid;
		}*/

		var invoiceid = $('#finvoiceid').val();
		if(invoiceid.length > 0)
		{
			path += '/invoiceid/' + invoiceid;
		}

		var phone = $('#fphone').val();
		if(phone.length > 0)
		{
			path += '/phone/' + phone;
		}

		var email = $('#femail').val();
		if(email.length > 0)
		{
			path += '/email/' + email;
		}

		var startdate = $('#fstartdate').val();
		var enddate = $('#fenddate').val();
		if(startdate.length > 0 && enddate.length > 0)
		{
			path += '?fstartdate=' + encodeURIComponent(startdate);
			path += '&fenddate=' + encodeURIComponent(enddate);
		}
		/*
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
		}*/

		document.location.href= path;
	}
	function gosearchnosuccess()
	{
		var path = rooturl + controllerGroup + "/installment/index/orderidcrm/-1";
		document.location.href= path;
	}
	function updatetocrm(orderid)
	{
		if(orderid.length > 0 )
		{
			$.post(rooturl + controllerGroup + "/installment/syncrmajax/", {iid: orderid}, function(data){
				if(data)
				{
					if(data.success == 1)
					{
						window.location.reload();
					}
					else showGritterError('Lỗi trong quá trình lưu xuống CRM vui lòng thử lại.');
				}
			},'json');
		}
	}
</script>
{/literal}