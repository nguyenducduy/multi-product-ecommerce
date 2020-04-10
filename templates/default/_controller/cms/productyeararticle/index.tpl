<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ProductyearArticle</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_productyeararticle"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.productyeararticleBulkToken}" />
				<table class="table table-striped">
		
				{if $productyeararticles|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelPid}</th>
							<th>{$lang.controller.labelPyuid}</th>
							<th><a href="{$filterUrl}sortby/title/sorttype/{if $formData.sortby eq 'title'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelTitle}</a></th>
							<th>{$lang.controller.labelContent}</th>
							<th><a href="{$filterUrl}sortby/point/sorttype/{if $formData.sortby eq 'point'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPoint}</a></th>
							<th>{$lang.controller.labelCountlike}</th>
							<th>{$lang.controller.labelCountshare}</th>
							<th>{$lang.controller.labelStatus}</th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th>{$lang.controller.labelDatemodified}</th>
							<th>{$lang.controller.labelIpaddress}</th>
							<th width="140"></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
					
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
					</tfoot>
					<tbody>
					{foreach item=productyeararticle from=$productyeararticles}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$productyeararticle->id}" {if in_array($productyeararticle->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$productyeararticle->id}</td>
							
							<td>{$productyeararticle->pid}</td>
							<td>{$productyeararticle->pyuid}</td>
							<td>{$productyeararticle->title}</td>
							<td>{$productyeararticle->content}</td>
							<td>{$productyeararticle->point}</td>
							<td>{$productyeararticle->countlike|date_format}</td>
							<td>{$productyeararticle->countshare|date_format}</td>
							<td>{$productyeararticle->getStatusName()}</td>
							<td>{$productyeararticle->datecreated|date_format}</td>
							<td>{$productyeararticle->datemodified|date_format}</td>
							<td>{$productyeararticle->ipaddress}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productyeararticle->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productyeararticle->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelTitle}: <input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelContent}: <input type="text" name="fcontent" id="fcontent" value="{$formData.fcontent|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPoint}: <input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCountlike}: <input type="text" name="fcountlike" id="fcountlike" value="{$formData.fcountlike|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelCountshare}: <input type="text" name="fcountshare" id="fcountshare" value="{$formData.fcountshare|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: 
					<select name="fstatus" id="fstatus">
						<option value="0">- - - - -</option>
						{html_options options=$statusOptions selected=$formData.fstatus}
					</select>

				{$lang.controller.labelIpaddress}: <input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="title" {if $formData.fsearchin eq "title"}selected="selected"{/if}>{$lang.controller.labelTitle}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/productyeararticle/index";
		

		var title = $('#ftitle').val();
		if(title.length > 0)
		{
			path += '/title/' + title;
		}

		var content = $('#fcontent').val();
		if(content.length > 0)
		{
			path += '/content/' + content;
		}

		var point = $('#fpoint').val();
		if(point.length > 0)
		{
			path += '/point/' + point;
		}

		var countlike = $('#fcountlike').val();
		if(countlike.length > 0)
		{
			path += '/countlike/' + countlike;
		}

		var countshare = $('#fcountshare').val();
		if(countshare.length > 0)
		{
			path += '/countshare/' + countshare;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var ipaddress = $('#fipaddress').val();
		if(ipaddress.length > 0)
		{
			path += '/ipaddress/' + ipaddress;
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
</script>
{/literal}
			
			


