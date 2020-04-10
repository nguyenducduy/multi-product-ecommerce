<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Bình luận sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Danh sách</li>
</ul>



<div class="page-header" rel="menu_productreview"><h1>{$lang.controller.head_list}</h1></div>

<div>
	Filter theo : 
	{foreach from=$rootcategorylist item=rootcategory}
	<a class="tipsy-trigger" title="Bình luận của {$rootcategory->name}" href="{$conf.rooturl_cms}productreview/index/pcid/{$rootcategory->id}"><span class="label label-info">{$rootcategory->name}</span></a>&nbsp;
	{/foreach}
</div>
<br/>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li {if $tab == 1}class="active"{/if}><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>

		<li {if $tab == 3}class="active"{/if}><a href="#tab3" data-toggle="tab">{$lang.controller.labelModeratorReview}({$totalpending})</a></li>

		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<!-- <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li> -->
		<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/reportreview">Thống kê</a></li>		
	</ul>
	<div class="tab-content">
		<div class="tab-pane {if $tab == 1}active{/if}" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.productreviewBulkToken}" />
				<table class="table table-striped">

				{if $productreviews|@count > 0}
					<thead>
						<tr>
						   	<th width="40"><input class="check-all" type="checkbox" /></th>
						   	<th>Danh mục</th>
						   	<th>{$lang.controller.labelId}</th>
						   	<th>{$lang.controller.labelParentid}</th>
						   	<th>{$lang.controller.labelDatecreated}</th>
						   	<th>{$lang.controller.labelUid}</th>
						   	<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelObjectid}</a></th>
						   	<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
						   	<th>{$lang.controller.labelText}</th>
						   	<th><a href="{$filterUrl}sortby/countreply/sorttype/{if $formData.sortby eq 'countreply'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreply}</a></th>
						   	<th>{$lang.controller.labelStatus}</th>
						   	<th width="50">{$lang.controller.labelSendMail}</th>
						   	<th width="95"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`/tab/1"}
								</div> <!-- End .pagination -->


								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
										<option value="success">{$lang.controller.bulkActionSuccessLabel}</option>
										<option value="pending">{$lang.controller.bulkActionPendingLabel}</option>
										<option value="spam">{$lang.controller.bulkActionSpamLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=productreview from=$productreviews}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$productreview->id}" {if in_array($productreview->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><span class="label label-info">{$productreview->productcategory->name}</span></td>
							<td>{$productreview->id}</td>
							<td>{if $productreview->parentid > 0}{$productreview->parentid}{/if}</td>
							<td>{$productreview->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td><span class="label label-info">{if $productreview->actor->id > 0}{$productreview->actor->fullname}{else}{$productreview->fullname}{/if}</span></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}product/index/id/{$productreview->product->id}">{$productreview->product->name}</a></td>
							<td>{$productreview->email}</td>
							<td>{$productreview->text}</td>
							<td>{$productreview->countreply}</td>
							<td>{if $productreview->checkStatusName('enable')}
									<span class="label label-success">{$productreview->getStatusName()}</span>
								{elseif $productreview->checkStatusName('pending')}
									<span class="label label-warning">{$productreview->getStatusName()}</span>
								{else}
									<span class="label label-important">{$productreview->getStatusName()}</span>
								{/if}</td>
							<td width="50">
								{$productreview->getIsSendMail()}
							</td>
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productreview->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productreview->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
								<a href="{$conf.rooturl_cms}productreview/reply/parentid/{$productreview->id}" rel="shadowbox;height=200;width=600px" class="btn btn-mini"><i class="icon-white"></i>Reply</a>
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

		</div><!-- end #tab 1 -->
		<div class="tab-pane {if $tab == 3}active{/if}" id="tab3">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.productreviewBulkToken}" />
				<table class="table table-striped">

				{if $totalpending > 0}
					<thead>
						<tr>
						   	<th width="40"><input class="check-all" type="checkbox" /></th>
						   	<th>Danh mục</th>
						   	<th>{$lang.controller.labelId}</th>
						   	<th>{$lang.controller.labelParentid}</th>
						   	<th>{$lang.controller.labelDatecreated}</th>
						   	<th>{$lang.controller.labelUid}</th>
						   	<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelObjectid}</a></th>
						   	<th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
						   	<th>{$lang.controller.labelText}</th>
						   	<th><a href="{$filterUrl}sortby/countreply/sorttype/{if $formData.sortby eq 'countreply'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountreply}</a></th>
						   	<th>{$lang.controller.labelStatus}</th>
						   	<th width="140"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`/tab/3"}
								</div> <!-- End .pagination -->


								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
										<option value="success">{$lang.controller.bulkActionSuccessLabel}</option>
										<option value="pending">{$lang.controller.bulkActionPendingLabel}</option>
										<option value="spam">{$lang.controller.bulkActionSpamLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=productreview from=$productreviewspending}
						{if $productreview->checkStatusName('pending')}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$productreview->id}" {if in_array($productreview->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><span class="label label-info">{$productreview->productcategory->name}</span></td>
							<td>{$productreview->id}</td>
							<td>{if $productreview->parentid > 0}{$productreview->parentid}{/if}</td>
							<td>{$productreview->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td><span class="label label-info">{if $productreview->actor->id > 0}{$productreview->actor->fullname}{else}{$productreview->fullname}{/if}</span></td>
							<td><a target="_blank" href="{$conf.rooturl_cms}product/index/id/{$productreview->product->id}">{$productreview->product->name}</a></td>
							<td>{$productreview->email}</td>
							<td>{$productreview->text}</td>
							<td>{$productreview->countreply}</td>
							<td>{if $productreview->checkStatusName('enable')}
									<span class="label label-success">{$productreview->getStatusName()}</span>
								{elseif $productreview->checkStatusName('pending')}
									<span class="label label-warning">{$productreview->getStatusName()}</span>
								{else}
									<span class="label label-important">{$productreview->getStatusName()}</span>
								{/if}</td>
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productreview->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productreview->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
						</tr>

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
		</div><!--end #tab 3-->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				<table>
					<tr>
						<td>{$lang.controller.labelUid}: </td>
						<td style="float:left;"><select name="fuid" id="fuid" class="autocompletestaff"></select></td>
					</tr>
					<tr>
						<td>Danh mục</td>
						<td style="float:left;">
							<select id="pcid" name="pcid">
								<option value="0">Chọn danh mục</option>
								{foreach item=productcategory from=$productcategoryList}
								<option {if $formData.fpcid == $productcategory->id}selected="selected"{/if} value="{$productcategory->id}">{$productcategory->name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelObjectid}: </td>
						<td style="float:left;"><input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>

					<tr>
						<td>{$lang.controller.labelFullname}: </td>
						<td style="float:left;"><input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-mini" /></td>
					</tr>

					<tr>
						<td>{$lang.controller.labelEmail}:</td>
						<td style="float:left;"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-mini" /></td>
					</tr>

					<tr>
						<td>{$lang.controller.labelModeratorid}:</td>
						<td style="float:left;"><select name="fmoderatorid" id="fmoderatorid" class="autocompletestaff"></select></td>
					</tr>

					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="float:left;">
							<select name="fstatus" id="fstatus">
								<option value="">- - - -</option>
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
					</tr>

					<tr>
						<td>{$lang.controller.labelParentid}:</td>
						<td style="float:left;"><input type="text" name="fparentid" id="fparentid" value="{$formData.fparentid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>

					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="float:left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>

					<tr>
						<td></td>
						<td style="float:left;"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
				 	</tr>
				</table>
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$('#pcid').select2();
		$('#s2id_pcid').css('width' , '200');
	});	

	function gosearch()
	{
		var path = rooturl + controllerGroup + "/productreview/index";


		var uid = $('#fuid').val();
		if(uid != null)
		{
			path += '/uid/' + uid;
		}

		var objectid = $('#fobjectid').val();
		if(objectid.length > 0)
		{
			path += '/objectid/' + objectid;
		}

		var pcid = $('#pcid').val();
		if(parseInt(pcid) > 0)
		{
			path += '/pcid/' + pcid;
		}

		var fullname = $('#ffullname').val();
		if(fullname.length > 0)
		{
			path += '/fullname/' + fullname;
		}

		var email = $('#femail').val();
		if(email.length > 0)
		{
			path += '/email/' + email;
		}

		var moderatorid = $('#fmoderatorid').val();
		if(moderatorid != null)
		{
			path += '/moderatorid/' + moderatorid;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
		}

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}

		document.location.href= path;
	}
</script>
{/literal}




