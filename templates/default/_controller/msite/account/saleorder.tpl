<div class="navbarprod">
	<li><a href="#">Trang chủ</a> ››</li>
	<li>Profiles</li>
</div>

<!-- Profiles -->
<div class="profiles">
	{include file="`$smartyControllerGroupContainer`nav_left_account.tpl"}
	<!-- đơn hang -->

	<div class="wrap_mess">
		<div>
			<form method="POST">
				<label class="labprof">Mã đơn hàng :</label><input type="text" class='mini-text wiinprof'
																   name="fsearchsaleid">
				<label class="labprof">Ngày giao dịch :</label><input type="text" class='mini-text wiinprof inputdate'
																	  name="fsearchdate" placeholder='Ngày/tháng/năm'>
				<label class="labprof">Tình trạng :</label>
				<select name="fsearchstatus" class="wiinprof">
					<option value="">----</option>
					<option value="0">Chờ xử lý</option>
					<option value="1">Đang xử lý</option>
					<option value="2">Đã giao hàng</option>
					<option value="3">Đang vận chuyển</option>
				</select>
				<input class="btn-all go seabtnprof" type="submit" value="Tìm kiếm">
				<input type="hidden" name="fsubmit">
			</form>
		</div>
		{if $formData.countSal>0}
			<div class="topbar_bb">
				<div class="topbar-l">Danh sách Đơn hàng</div>
			</div>
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">

				<table class="table table-striped" cellpadding="5" width="100%">

					<thead>
					<tr>
						<th align="left">{$lang.controller.lbsaleorderid}</th>
						<th align="left">{$lang.controller.lbsaleorderproductname}</th>
						<th width="100px">{$lang.controller.lbsaleorderprice}</th>
						<th width="100px">{$lang.controller.lbordertype}</th>
						<th width="150px" align="left">{$lang.controller.lbsaleorderdatecreat}</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					{foreach $saleorder as $k=>$v}
						<tr>
							<td style="font-weight:bold; vertical-align: middle;"><span
										class="label label-info">{$v.SALEORDERID}</span></td>
							<td style="font-weight:bold; vertical-align: middle; width:40%">{$v.PRODUCTNAME}</td>
							<td style="vertical-align: middle;" align="center">{$v.TOTALAMOUNT} đ</td>
							<td style="vertical-align: middle; width:18%">{$v.strOutputTypeName}</td>
							<td style="vertical-align: middle;" align="center">{$v.INPUTTIME}</td>
							<td class="moreorder">
								<a title="{$lang.default.formActionEditTooltip}"
								   href="{$conf.rooturl}account/saleorderdetail/saleid/{$v.SALEORDERID}">Chi tiết</a>
							</td>

						</tr>
					{/foreach}
					</tbody>

				</table>
			</form>
		{else}
			<table class="table table-striped" cellpadding="5" width="100%">
				<tbody>
					<tr>
						<td colspan="6"> Không có đơn hàng</td>
					</tr>
				</tbody>
			</table>
		{/if}
	</div>

</div>


</div>

{literal}
<script>
	$('.inputdate').datepicker({'format':'dd/mm/yyyy', 'weekStart' : 1})
			.on('changeDate', function(ev){
				$('.datepicker').hide();
				$(this).blur();
			});
</script>
{/literal}
