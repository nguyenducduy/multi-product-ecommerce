<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">{$lang.controller.head_list}</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_customer_list"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li {if $formData.countCus > 0}class="active"{/if}><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch}({$formData.countCus}) {/if}</a></li>
		<!-- <li {if $formData.countCom > 0}class="active"{/if}><a href="#tab2" data-toggle="tab">{$lang.controller.title_list2}({$formData.countCom})</a></li> -->
		<li {if $formData.totalcount==0}  class="active"{/if}><a href="#tab3"  data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}customer">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane  {if $formData.countCus > 0}active{/if}" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">
					
				{if $formData.countCus > 0}
					<thead>
						<tr>
						    <!-- <th width="40"><input class="check-all" type="checkbox" /></th> -->
							<th align="left" >{$lang.controller.lbrid}</th>	
							<th>{$lang.controller.lbrname}</th>
							<th align="left">{$lang.controller.lbrphone}</th>		
							<th align="left">{$lang.controller.lbremail}</th>
                            <th align="center">{$lang.controller.lbrcmnd}</th>
							<th width="70"></th>
						</tr>
					</thead>
					
<!-- 					<tfoot>
						<tr>
							<td colspan="9">
								
								
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> 
		
								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
								
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot> -->
					<tbody>
				{foreach  $customers as $key => $value}
						<tr>
							<!-- <td align="center"><input type="checkbox" name="fbulkid[]" value="{$value.CUSTOMERID}" {if in_array($customer->id, $formData.fbulkid)}checked="checked"{/if}/></td> -->
							<td style="font-weight:bold;">{$value.CUSTOMERID}</td>
							<td align="center"><a  rel=''>{$value.FULLNAME}</a></td>
							<td>{$value.MAINMOBILE}</td>
                            <td>{$value.MAINEMAIL}</td>
							<td align="center">{$value.PERSONALID}</td>
							<td style='width: 175px;'>
								<!-- <a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_crm}customer/edit/id/{$value.CUSTOMERID}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil">Chỉnh sửa</i></a> &nbsp; -->
								<a title="{$lang.default.formActionDeleteTooltip}" href="{$conf.rooturl_crm}customer/detail/group/{$formData.group}/id/{$value.CUSTOMERID}" class="btn btn-mini"><i class="icon-folder-open icon-white">Chi tiết</i></a>
							</td>
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

		<div class="tab-pane {if $formData.countCom > 0}active{/if}" id="tab2">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">

				{if $formData.countCom > 0}
					<thead>
						<tr>
						    <!-- <th width="40"><input class="check-all" type="checkbox" /></th> -->
							<th align="left" >{$lang.controller.lbyid}</th>
							<th>{$lang.controller.lbyname}</th>
							<th align="left">{$lang.controller.lbyphone}</th>
							<th align="left">{$lang.controller.lbyemail}</th>
                            <th align="center">{$lang.controller.lbytax}</th>
							<th width="70"></th>
						</tr>
					</thead>

<!-- 					<tfoot>
						<tr>
							<td colspan="9">


								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> 


								<div class="clear"></div>
							</td>
						</tr>
					</tfoot> -->
					<tbody>
				{foreach  $customers as $key => $value}
						<tr>
							<!-- <td align="center"><input type="checkbox" name="fbulkid[]" value="{$customer->id}" {if in_array($customer->id, $formData.fbulkid)}checked="checked"{/if}/></td> -->
							<td style="font-weight:bold;">{$value.COMPANYID}</td>
							<td align="center"><a href="{$conf.rooturl_crm}customer/detail/group/{$formData.group}/id/{$value.COMPANYID}" rel=''>{$value.COMPANYNAME}</a></td>
							<td>{$value.MAINPHONE}</td>
                            <td>{$value.MAINEMAIL}</td>
							<td align="center">{$value.TAXNO}</td>
							<td style='width: 175px;'>
								{literal}
                               <!-- <a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_crm}customer/edit/id/{$value.COMPANYID}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil">Chỉnh sửa</i></a>--> &nbsp;
								{/literal}
									<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}customer/delete/id/{$customer->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white">Xóa</i></a>
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


		</div><!-- end #tab 2 -->

		<div class="tab-pane {if $formData.totalcount == 0} active {/if}" id="tab3">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				<div>
				<!-- <select name="fgroupid" id="fgroupid">
					<option value="">- - in Group - -</option>
					<option value="0">Customer</option>
					<option value="1">Company</option>
				</select> -->
				<span id="fsvalue" >
					<input  type="text" name="fsearch" id="fsearch" size="20" value="" class="" placeholder="id,name,phone,cmnd..." />
					<input  type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
				</span>
				</div>
				
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_crm + "customer/index";
		

		var group = $("#fgroupid").val();
		var keywordin = $("#fsearch").val();
		/*if(keywordin.length > 0)
		{
			path += "/group/"+group+"/searchkey/" + keywordin;
		}*/
		path += "/group/0/searchkey/" + keywordin;
		document.location.href= path;
	}
	/*$("#fgroupid").change(function(){
		$("#fsvalue").show();
	});*/
</script>
{/literal}






