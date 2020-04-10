<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Orders</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_orders"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<!--<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>-->
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.ordersBulkToken}" />
				<table class="table table-striped">

				{if $orderss|@count > 0}
					<thead>
						<tr>

							<th><a href="{$filterUrl}sortby/orderidcrm/sorttype/{if $formData.sortby eq 'orderidcrm'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelOrderidcrm}</a></th>

							<th><a href="{$filterUrl}sortby/invoiceid/sorttype/{if $formData.sortby eq 'invoiceid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelInvoiceid}</a></th>
							<th>{$lang.controller.labelPricefinal}</th>
                            <th>{$lang.controller.labelDatecreated}</th>
							<th>{$lang.controller.formorderprogramtype}</th>
							<th>{$lang.controller.labelContactemail}</th>
							<th>{$lang.controller.labelBillingfullname}</th>
							<th>{$lang.controller.labelBillingphone}</th>
							<!--<th>{$lang.controller.labelPaymentisdone}</th>
							<th>{$lang.controller.labelStatus}</th>-->
							<th>Ngày lưu CRM</th>
							<th></th>
						</tr>
					</thead>

					<tfoot>
                        <tr>
                            <td colspan="9">
                                <div class="pagination">
                                   {assign var="pageurl" value="page/::PAGE::"}
                                    {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl``$paginateurl2`"}
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
					<tbody>
					{foreach item=orders from=$orderss}

						<tr>
							<td>{$orders->orderidcrm}</td>
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/history/id/{$orders->id}" rel="shadowbox">{$orders->invoiceid}</a></td>
							<td>{$orders->pricefinal|number_format}</td>
							<td>{$orders->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{if $orders->promotionid==34}<span class="label label-warning">Giá rẻ</span>{elseif $orders->promotionid==38}<span class="label label-success">Đặt trước</span>{elseif $orders->promotionid > 0}<span class="label">{$orders->promotionid}</span>{/if}</td>
							<td>{$orders->contactemail}</td>
							<td>{$orders->billingfullname}</td>
							<td>{$orders->billingphone}</td>
							<!--<td>{$orders->paymentisdone}</td>
							<td><span class="label">{$orders->getpaymentOrderStatus()}</span></td>-->
							<td>{$orders->ordercrmdate|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{if $orders->orderidcrm == 0}<a class="btn btn-primary" href="javascript: void(0)" onclick="updatetocrm('{$orders->id}','{$orders->uid}')">Lưu xuống CRM</a>{/if}</td>
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
				<tr><td>{$lang.controller.labelOrderidcrm}:</td><td align="left"> <input type="text" name="forderidcrm" id="forderidcrm" value="{$formData.forderidcrm|@htmlspecialchars}" class="input-mini" /></td><td></td></tr>


				<tr><td>{$lang.controller.labelInvoiceid}: </td><td align="left"><input type="text" name="finvoiceid" id="finvoiceid" value="{$formData.finvoiceid|@htmlspecialchars}" class="input-mini" /></td><td></td></tr>

				<tr><td>{$lang.controller.labelContactemail}: </td><td><input type="text" name="fcontactemail" id="fcontactemail" value="{$formData.fcontactemail|@htmlspecialchars}" class="input" /></td><td></td></tr>

				<tr><td>{$lang.controller.labelBillingfullname}: </td><td><input type="text" name="fbillingfullname" id="fbillingfullname" value="{$formData.fbillingfullname|@htmlspecialchars}" class="input" /></td><td></td></tr>

				<tr><td>{$lang.controller.labelBillingphone}: </td><td><input type="text" name="fbillingphone" id="fbillingphone" value="{$formData.fbillingphone|@htmlspecialchars}" class="input" /></td><td></td></tr>

				<tr><td> Ngày tạo đơn hàng: </td><td align="left"><input type="text" name="fstartdate" id="fstartdate" value="{$formData.fstartdate|date_format:"%d/%m/%Y"}" class="input-medium inputdatepicker" />&nbsp;<input type="text" name="fenddate" id="fenddate" value="{$formData.fenddate|date_format:"%d/%m/%Y"}" class="input-medium inputdatepicker" /></td><td></td></tr>

				<tr><td></td><td><input type="button" value="Xem đơn hàng chưa lưu xuống CRM" class="btn btn-primary" onclick="gosearchnosuccess();"  />&nbsp;<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td><td></td></tr>

		        </table>
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/orders/index";


		var orderidcrm = $('#forderidcrm').val();
		if(orderidcrm.length > 0)
		{
			path += '/orderidcrm/' + orderidcrm;
		}

		var invoiceid = $('#finvoiceid').val();
		if(invoiceid.length > 0)
		{
			path += '/invoiceid/' + invoiceid;
		}

		var contactemail = $('#fcontactemail').val();
		if(contactemail.length > 0)
		{
			path += '/contactemail/' + contactemail;
		}

		var billingfullname = $('#fbillingfullname').val();
		if(billingfullname.length > 0)
		{
			path += '/billingfullname/' + billingfullname;
		}

		var billingphone = $('#fbillingphone').val();
		if(billingphone.length > 0)
		{
			path += '/billingphone/' + billingphone;
		}

		var startdate = $('#fstartdate').val();
		var enddate = $('#fenddate').val();
		if(startdate.length > 0 && enddate.length > 0)
		{
			path += '?fstartdate=' + encodeURIComponent(startdate);
			path += '&fenddate=' + encodeURIComponent(enddate);
		}

		document.location.href= path;
	}

	function gosearchnosuccess()
	{
		var path = rooturl + controllerGroup + "/orders/index/orderidcrm/-1";
		document.location.href= path;
	}

	function updatetocrm(orderid, uid)
	{
		if(orderid.length > 0 && uid.length > 0 )
		{
			$.post(rooturl + controllerGroup + "/orders/syncrmajax/", {uid: uid, orderidcrm: orderid}, function(data){
				if(data)
				{
					if(data.success == 1)
					{
						window.location.reload();
					}
					else showGritterError('Lỗi trong quá trình lưu đơn hàng xuống CRM vui lòng thử lại.');
				}
			},'json');
		}
	}
</script>
{/literal}




