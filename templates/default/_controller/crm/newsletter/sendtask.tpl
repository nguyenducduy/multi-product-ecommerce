<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Newsletter</a> <span class="divider">/</span></li>
	<li class="active">Send Task</li>
</ul>

<div class="page-header" rel="menu_newsletter_list"><h1>Newsletter Task List :: {$myNewsletter->subject} <a href="{$conf.rooturl_admin}newsletter/edit/id/{$myNewsletter->id}" class="btn btn-info"><i class="icon-pencil icon-white"></i></a></h1></div>


<form action="" method="post" name="myform" class="form-inline">
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">		
		<h3>Add Email to Send task list</h3>
		
		<div class="clear"></div>  
	</div> <!-- End .content-box-header -->
	
	<div class="content-box-content">
		<div class="tab-content default-tab">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
				<fieldset>
				
						
				<p>
					SELECT email FROM user u
					INNER JOIN profile p ON u.u_id = p.u_id
					WHERE</strong>
					<input type="text" name="fquery" id="fquery" size="40" value="{$formData.fquery|default:"u.u_id > 0 limit 3"}" class="text-input">
					<input type="submit" name="fquerysubmit" class="btn btn-primary" value="Add Found Email to Newsletter Task" />
					<br />
					(Available columns: u.u_id, u_avatar, u_groupid, u_count_book, b_count_review, u_count_quote, u_count_friend, u_count_sell, u_count_shelf,
					u_count_fav, u_datelastaction, u_gender, u_region, u_point, u_privacy_binary, u_datecreated, u_datemodified, u_datelastlogin, u_oauth_partner)
				</p>
				        
				<hr />
				<strong>OR - add custom record</strong><br /><br />
				User ID: <input type="text" name="fuserid" size="5" class="input-mini" /> - 
				Full Name: <input type="text" name="ffullname" class="text-input" /> - 
				Email: <input type="text" name="femail" class="text-input" />
				<input type="submit" name="fsubmitadd" class="btn btn-primary" value="Add" />       
				</fieldset>
			
		</div>
		
	</div>
	
	
    	
</div>
</form>









<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Newsletter Send Task List {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}newsletter/sendtask/id/{$myNewsletter->id}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
			
			<form class="form-inline" action="" method="post" onsubmit="return confirm('Are You Sure ?');">
				<table class="table table-striped" cellpadding="5" width="100%">
					
				{if $newsletterTasks|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th align="left" width="30"><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">ID</a></th>	
                            
							<th align="left">To Name</th>			
							<th align="left">To Email</th>
							<th align="center">To User ID</th>			
							<th align="left"><a href="{$filterUrl}sortby/issent/sorttype/{if $formData.sortby eq 'issent'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Is sent</a></th>	
							<th align="left"><a href="{$filterUrl}sortby/sendcount/sorttype/{if $formData.sortby eq 'sendcount'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Send Count</a></th>	
							<th align="center">Date Added</th>		
							<th align="center"><a href="{$filterUrl}sortby/datelastsent/sorttype/{if $formData.sortby eq 'datelastsent'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Last Sent</a></th>			
							
							
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
										<option value="delete">Delete selected</option>
										<option value="reset">Reset selected to UN-SENT</option>
										<option value="settosent">Mark selected as SENT</option>
										<option value="send">Send email to selected item.</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
									<input type="submit" name="fsubmitdeleteall" class="btn btn-danger" value="DELETE ALL" />
									<input type="submit" name="fsubmitresetall" class="btn btn-warning" value="Reset ALL to UN-SENT" />
									<input type="submit" name="fsubmitsettosentall" class="btn btn-warning" value="Mark ALL as SENT" />
									<input type="submit" name="fsubmitsendall" class="btn btn-success" value="Send to ALL" />
								</div>
								
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
						{foreach item=newslettertask from=$newsletterTasks}

								<tr id="newslettertask-{$newslettertask->id}">
									<td align="center"><input type="checkbox" name="fbulkid[]" value="{$newslettertask->id}" {if in_array($newslettertask->id, $formData.fbulkid)}checked="checked"{/if}/></td>
									<td style="font-weight:bold;">{$newslettertask->id}</td>

									<td>{if $newslettertask->touserid > 0}<a href="{$conf.rooturl_admin}user/edit/id/{$newslettertask->touserid}" target="_blank" title="Edit this User">{$newslettertask->toname}</a>{else}{$newslettertask->toname}{/if}</td>
									<td>{$newslettertask->toemail}</td>
									<td class="td_center">{$newslettertask->touserid}</td>
									<td class="td_center issent">{if $newslettertask->issent == 1}<span class="label label-success"><i class="icon-ok icon-white"></i></span>{else}<span class="label label-important"><i class="icon-remove icon-white"></i></span>{/if}</td>
									<td class="td_center sendcount">{$newslettertask->sendcount}</td>
									<td>{$newslettertask->datecreated|date_format:"%e/%m/%Y"}</td>
									<td class="datelastsent">{if $newslettertask->datelastsent > 0}{$newslettertask->datelastsent|date_format:"%e/%m/%Y"}{else}n/a{/if}</td>


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
				
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="text-input" />
					
									
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{if $startsender == 1}


{literal}
<script type="text/javascript">
	function startsender()
	{
						
		Shadowbox.open({
			content:    "{/literal}{$conf.rooturl_admin}newsletter/sender/id/{$myNewsletter->id}{literal}",
			player:     "iframe",
			title:      "Email Sender",
			options: {
                       modal:   true
        	}, 
			height:     400,
			width:      640
		});
	}
	
	$(function(){ //jQuery's DOM Ready
	  // you still have to give the browser a chance to complete the insertion of
	  // Shadowbox's html (from the init() call) ...
	  window.setTimeout(startsender, 1000);
	});

	
</script>
{/literal}
{/if}

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "newsletter/sendtask/id/{/literal}{$myNewsletter->id}{literal}";
		
		var id = $("#fid").val();
		if(parseInt(id) > 0)
		{
			path += "/taskid/" + id;
		}
		
		var keyword = $("#fkeyword").val();
		if(keyword.length > 0)
		{
			path += "/keyword/" + keyword;
		}
		
						
		document.location.href= path;
	}
</script>
{/literal}









