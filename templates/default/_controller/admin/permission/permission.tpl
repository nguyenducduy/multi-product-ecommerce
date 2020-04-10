<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Phân quyền</a> <span class="divider">/</span></li>
	<li class="active">Quản lý</li>
</ul>

<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_list_role}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal">
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">Sản phẩm</a></li>
			<li><a href="#tab2" data-toggle="tab">Tin tức</a></li>
			<li><a href="#tab3" data-toggle="tab">Rao vặt</a></li>
			<li><a href="#tab4" data-toggle="tab">Hệ thống phòng ban</a></li>
			<li><a href="#tab5" data-toggle="tab">Phân quyền cho cho nhân viên</a></li>
			<li><a href="#tab6" data-toggle="tab">Sản phẩm khuyến mãi</a></li>
			<li><a href="#tab7" data-toggle="tab">Xem doanh số</a></li>
			<li><a href="#tab8" data-toggle="tab">Xem khuyến mãi</a></li>
			<li><a href="#tab9" data-toggle="tab">Xem hóa đơn</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<a target="_blank" href="{$conf.rooturl_cms}productcategory/role">Phân quyền sản phẩm</a>
			</div><!-- end #tab 1 -->

			<div class="tab-pane" id="tab2">
				<a target="_blank" href="{$conf.rooturl_cms}newscategory/role">Phân quyền tin tức</a>
			</div><!--end #tab 2-->

			<div class="tab-pane" id="tab3">
				<a target="_blank" href="{$conf.rooturl_cms}stuffcategory/role">Phân quyền rao vặt</a>
			</div><!--end #tab 3-->

			<div class="tab-pane" id="tab4">
				<a target="_blank" href="{$conf.rooturl}erp/hrmdepartment?view=list">Hệ thống phòng ban</a>
			</div><!--end #tab 4-->

			<div class="tab-pane" id="tab5">
				{if $delegateList|@count > 0}
				<table class="table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tên</th>
							<th>Phòng ban</th>
							<th>Chức vụ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=delegates from=$delegateList}
							<tr id="d{$delegates.id}">
								<td><span class="label label-info">{$delegates.id}</span></td>
								<td>{$delegates.name}</td>
								<td>{$delegates.department}</td>
								<td>{$delegates.position}</td>
								<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteUserRole(6001 , {$delegates.id})"><i class="icon-remove icon-white"></i></a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}
				<div style="float:right;"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/adduser/type/delegate" rel="shadowbox;height=200;width=350">Thêm tài khoản</a></div>
			</div><!--end #tab 5-->

			<div class="tab-pane" id="tab6">
				{if $promotionList|@count > 0}
				<table class="table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tên</th>
							<th>Phòng ban</th>
							<th>Chức vụ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=promtions from=$promotionList}
							<tr id="p{$promotions.id}">
								<td><span class="label label-info">{$promtions.id}</span></td>
								<td>{$promtions.name}</td>
								<td>{$promtions.department}</td>
								<td>{$promtions.position}</td>
								<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteUserRole(7001 , {$promtions.id})"><i class="icon-remove icon-white"></i></a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}
				<div style="float:right;"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/adduser/type/promotion" rel="shadowbox;height=200;width=350">Thêm tài khoản</a></div>
			</div><!--end #tab 6-->

			<div class="tab-pane" id="tab7">
				{if $orderList|@count > 0}
				<table class="table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tên</th>
							<th>Phòng ban</th>
							<th>Chức vụ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=promtions from=$orderList}
							<tr id="p{$promotions.id}">
								<td><span class="label label-info">{$promtions.id}</span></td>
								<td>{$promtions.name}</td>
								<td>{$promtions.department}</td>
								<td>{$promtions.position}</td>
								<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteUserRole(7001 , {$promtions.id})"><i class="icon-remove icon-white"></i></a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}
				<div style="float:right;"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/adduser/type/order" rel="shadowbox;height=200;width=350">Thêm tài khoản</a></div>
			</div><!--end #tab 7-->

			<div class="tab-pane" id="tab8">
				{if $viewpromotion|@count > 0}
				<table class="table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tên</th>
							<th>Phòng ban</th>
							<th>Chức vụ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=viewpromtion from=$viewpromotion}
							<tr id="vp{$viewpromtion.id}">
								<td><span class="label label-info">{$viewpromtion.id}</span></td>
								<td>{$viewpromtion.name}</td>
								<td>{$viewpromtion.department}</td>
								<td>{$viewpromtion.position}</td>
								<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteUserRole(9300 , {$viewpromtion.id})"><i class="icon-remove icon-white"></i></a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}
				<div style="float:right;"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/adduser/type/viewpromotion" rel="shadowbox;height=200;width=350">Thêm tài khoản</a></div>
			</div><!--end #tab 8-->

			<div class="tab-pane" id="tab9">
				{if $vieworders|@count > 0}
				<table class="table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tên</th>
							<th>Phòng ban</th>
							<th>Chức vụ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=vieworder from=$vieworders}
							<tr id="vp{$vieworder.id}">
								<td><span class="label label-info">{$vieworder.id}</span></td>
								<td>{$vieworder.name}</td>
								<td>{$vieworder.department}</td>
								<td>{$vieworder.position}</td>
								<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:void(0)" class="btn btn-mini btn-danger" onclick="deleteUserRole(9500 , {$vieworder.id})"><i class="icon-remove icon-white"></i></a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}
				<div style="float:right;"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/adduser/type/vieworder" rel="shadowbox;height=200;width=350">Thêm tài khoản</a></div>
			</div><!--end #tab 9-->
			
		</div>
	</div>
</form>
