<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Review</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<div class="page-header" rel="menu_review_list"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">
					
				{if $reviews|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th align="left" width="30"><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">ID</a></th>	
                            <th align="left" width="50">Avatar</th>
                            <th align="center" width="120">Poster</th>
                            <th align="left">Review</th>				
							<th align="center">Characters</th>
                            <th align="left" width="50">Cover</th>
							
                            
                            <th align="center" width="120">Date created</th>
							<th width="80">XU ID</th>
							<th align="center" width="80">Is parent?</th>
                            
							<th width="140"></th>
						</tr>
					</thead>
					
					<tfoot>
						<tr>
							<td colspan="9">
								
								
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
		
								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="button" value="{$lang.default.bulkActionSubmit}" />
								</div>
							</td>
						</tr>
					</tfoot>
					<tbody>
				{foreach item=review from=$reviews}
					<tr id="review-{$review->id}">
						<td align="center"><input type="checkbox" name="fbulkid[]" value="{$review->id}" {if in_array($review->id, $formData.fbulkid)}checked="checked"{/if}/></td>
						<td style="font-weight:bold;"><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}review/edit/id/{$review->id}/redirect/{$redirectUrl}">{$review->id}</a></td>
                        
                        <td class="td_left"><a target="_blank" href="{$review->actor->getUserPath()}" title="Go to User Home"><img src="{if $review->actor->avatar != ''}{$review->actor->getSmallImage()}{else}{$imageDir}noavatar200.jpg{/if}" alt="avatar" style="border:1px solid #ccc;" width="50" height="50" /></a></td>
                        
                        <td class="td_left"><strong><a href="{$conf.rooturl_admin}review/index/userid/{$review->actor->id}" title="View all reviews of this user">{$review->actor->fullname}</a><br /><small>[<a href="{$conf.rooturl_admin}user/edit/id/{$review->actor->id}" target="_blank">Edit User</a>]</small></strong><br /><small><a class="ip2location" target="_blank" href="http://www.ip2location.com/{$review->ipaddress}" title="Trace this IP Address">{$review->ipaddress}</a></small></td>
						<td><strong><a href="{$conf.rooturl_admin}review/index/bookid/{$review->book->id}" title="View all reviews of this book">{$review->book->title}</a></strong><br />
                        	<small>{$review->text|strip_tags}</small>
                        </td>
                        <td>{$review->charactercount}</td>
                        <td class="td_left"><a target="_blank" href="{$review->book->getBookPath()}" title="Go to Book Page"><img src="{$review->book->getSmallImage()}" alt="cover" style="border:1px solid #ccc;" width="50" height="80" /></a></td>
						
                        
                        
                       
                        <td class="td_center" >{$review->datecreated|date_format:"%H:%M, %e/%m/%Y"}</td>
						<td class="td_center">
							{if $review->xuid > 0}
								<a href="{$conf.rooturl_admin}xu/index/id/{$review->xuid}"><span class="label label-success">XU{$review->xuid}</span></a>
							{else}
								<a class="btn btn-small btn-warning btnbonus" href="javascript:void(0)" onclick="createxu('{$conf.rooturl_admin}review/createxuajax/id/{$review->id}', {$review->id})"><em class="icon icon-plus icon-white"></em> {$setting.review.xubonus} &#8363;</a>
							{/if}
						</td>
						<td align="center">{if $review->parentid == 0}<span class="label label-success"><i class="icon-ok icon-white"></i></span>{else}
							<span class="label label-important"><i class="icon-remove icon-white"></i></span>
							<br />
							<a href="{$conf.rooturl}review/detail/{$review->parentid}" target="_blank" title="Open new window"><small>View Parent</small></a>
						{/if}</td>
                        
						<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}review/edit/id/{$review->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
							<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}review/delete/id/{$review->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.default.formIdLabel}: 
				<input type="text" name="fid" id="fid" size="8" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 
				{$lang.controller.formKeywordLabel}:
				
					<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="text-input" /><select name="fsearchin" id="fsearchin">
						<option value="">- - - - - - - - - - - - -</option>
						<option value="text" {if $formData.fsearchin eq 'text'}selected="selected"{/if}>{$lang.controller.formKeywordInTextLabel}</option>
					</select>
					
				
	
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "review/index";
		
		var id = $("#fid").val();
		if(parseInt(id) > 0)
		{
			path += "/id/" + id;
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
	
	function createxu(url, reviewid)
	{
		$("#review-" + reviewid + " .btnbonus").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: url,
		   error: function(){
				$("#review-" + reviewid + " img.tmp_indicator").remove();
			   },
		   success: function(xml){
				$("#review-" + reviewid + " img.tmp_indicator").remove();
				$("#review-" + reviewid + " .btnbonus").fadeOut();
				
				var success = $(xml).find('success').text();
				var message = $(xml).find('message').text();

				if(success == "1")
					showGritterSuccess(message);
				else
					showGritterError(message);
		   }
		 });
	}
</script>
{/literal}






