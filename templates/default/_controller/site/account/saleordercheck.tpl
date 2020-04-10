<!-- Profiles -->
<div class="profiles">
	<!-- đơn hang -->

	<div class="wrap_mess detailchecksaleorder">
		<div class="topbar_bb">
			<div class="topbar-l">Danh sách Đơn hàng</div>
		</div>
		<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">

			<table class="table table-striped" cellpadding="5" width="100%">
				{if $formData.countSal>0}
					<thead>
					<tr>
						<th align="left">{$lang.controller.lbsaleorderid}</th>
						<th align="left">{$lang.controller.lbsaleorderproductname}</th>
						<th width="100px">{$lang.controller.lbsaleorderprice}</th>
						<th width="100px">{if {$formData.invoice}==0}{$lang.controller.lbordertype}{else}{$lang.controller.city}{/if}</th>
						<th width="100px" align="left">{$lang.controller.lbsaleorderdatecreat}</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					{foreach $saleorder as $k=>$v}
						<tr>
							<td style="font-weight:bold; vertical-align: middle;"><span class="label label-info">{$v.saleorderid}</span></td>
							<td style="font-weight:bold; vertical-align: middle; width:40%">{$v.productname}</td>
							<td style="vertical-align: middle;" align="center">{$v.totalamount|number_format} đ</td>

							{*<td style="vertical-align: middle; width:18%">{if {$formData.invoice}==0}{$v->STATUSNAME}{else}{$v->OUTPUTSTORENAME}{/if}</td>*}
							<td style="vertical-align: middle; width:18%">{$v.outputstorename}</td>
							<td style="vertical-align: middle;" align="center">{$v.inputtime}</td>
							<td class="moreorder">
								<a title="{$lang.default.formActionEditTooltip}"
								   href="{$conf.rooturl}site/account/{if {$formData.invoice}==4}showorderdetailcheck{elseif {$formData.invoice}==2}showdetailins{else}showdetailinvoice{/if}/saleid/{trim({$v.saleorderid})}/user/{$formData.user}">Chi
									tiết</a>
							</td>

						</tr>
					{/foreach}
					</tbody>
				{else}
					<tr>
						<td colspan="6"> Không có đơn hàng</td>
					</tr>
				{/if}
			</table>
		</form>
	</div>
</div>
<div class="button" style="float: right">
	<div class="btnsubmit" id="btnagain" style="width: 160px;" onclick="goback()">Kiểm tra đơn hàng khác</div>
</div>


