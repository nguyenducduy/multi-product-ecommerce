<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Đối tác</a> <span class="divider">/</span></li>
	<li class="active">Danh sách</li>
</ul>

<div class="page-header" rel="menu_vendor"><h1>{$lang.controller.head_list}</h1></div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.productreport}</a></li>		
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<form action="" method="post">
				<table class="table table-borderd">
					<thead>
						<tr>
							<th><input type="checkbox" id="checkall" /></th>
							<th>Thông tin</th>
							<th>Kiểu dữ liệu export</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=field key=fieldname from=$fieldlistt name=foo}
						<tr>
							<td><input type="checkbox" id="fcheckedfield{$smarty.foreach.foo.index+1}" name="fcheckedfield[{$fieldname}]" value="{$field}" class="chkbox" /></td>
							<td>{$field}</td>
							<td>
								<select name="ffieldname[{$fieldname}]">
									<option value="1">Boolean</option>
									<option value="2">Text</option>
									<option value="3">Datetime (dd/mm/YYYY)</option>
								</select>
							</td>
							<td></td>
						</tr>
						{/foreach}
					</tbody>
				</table>
				<div class="form-actions" style="text-align: center;">
					<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />					
				</div>
			</form>
		</div><!--end of tab 1-->
	</div>
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function() {
		$("#checkall").live('click', function(event) {
			if($(this).is(':checked')){
				$(".chkbox").each(function(index, el) {
					$(this).attr('checked', true);
				});
			}else{
				$(".chkbox").each(function(index, el) {
					$(this).attr('checked', false);
				});
			}
		});
	});
</script>
{/literal}