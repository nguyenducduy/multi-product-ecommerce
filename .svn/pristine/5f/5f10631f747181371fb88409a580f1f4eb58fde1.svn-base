<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Crontask</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<div class="page-header" rel="menu_crontask"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		<li><a href="#tab3" data-toggle="tab">Cronjob Builder</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li><a href="#tab4" data-toggle="tab">Available Task</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.crontaskBulkToken}" />
				<table class="table table-striped">
		
				{if $crontasks|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">id</th>
							
							<th>Controller</th>
							<th>Action</th>
							<th>IP Address</th>
							<th><a href="{$filterUrl}sortby/timeprocessing/sorttype/{if $formData.sortby eq 'timeprocessing'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Time Processing</a></th>
							<th>Output</th>
							<th>Status</th>
							<th>Date Created</th>
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
					{foreach item=crontask from=$crontasks}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$crontask->id}" {if in_array($crontask->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$crontask->id}</td>
							
							<td>{$crontask->controller}</td>
							<td>{$crontask->action}</td>
							<td><span class="label">{$crontask->ipaddress}</span></td>
							<td><span class="badge badge-info">{$crontask->timeprocessing}</span></td>
							<td>{$crontask->output}</td>
							<td>{if $crontask->checkStatusName('processing')}<span class="label">Processing</span>{else}<span class="label label-success">Completed</span>{/if}</td>
							<td>{$crontask->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}{$controller}/delete/id/{$crontask->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelController}: <input type="text" name="fcontroller" id="fcontroller" value="{$formData.fcontroller|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelAction}: <input type="text" name="faction" id="faction" value="{$formData.faction|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 
				
				Status: <select name="fstatus" id="fstatus">
					<option value="0">- - - - -</option>
					<option value="1" {if $formData.fstatus == 1}selected="selected"{/if}>Processing</option>
					<option value="2" {if $formData.fstatus == 2}selected="selected"{/if}>Completed</option>
				</select> -
				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="controller" {if $formData.fsearchin eq "controller"}selected="selected"{/if}>{$lang.controller.labelController}</option>
					<option value="action" {if $formData.fsearchin eq "action"}selected="selected"{/if}>{$lang.controller.labelAction}</option>
					<option value="output" {if $formData.fsearchin eq "output"}selected="selected"{/if}>{$lang.controller.labelOutput}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
		
		<div class="tab-pane" id="tab3">
			<form method="POST" name="cronf">
			<div>
			  <span>Minutes: 
			    <select size="1" name="minutes" class="input-mini">
			      <option selected="" value="*">*</option>
			      <option value="0">0</option>
			      <option value="1">1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			      <option value="4">4</option>
			      <option value="5">5</option>
			      <option value="6">6</option>
			      <option value="7">7</option>
			      <option value="8">8</option>
			      <option value="9">9</option>
			      <option value="10">10</option>
			      <option value="11">11</option>
			      <option value="12">12</option>
			      <option value="13">13</option>
			      <option value="14">14</option>
			      <option value="15">15</option>
			      <option value="16">16</option>
			      <option value="17">17</option>
			      <option value="18">18</option>
			      <option value="19">19</option>
			      <option value="20">20</option>
			      <option value="21">21</option>
			      <option value="22">22</option>
			      <option value="23">23</option>
			      <option value="24">24</option>
			      <option value="25">25</option>
			      <option value="26">26</option>
			      <option value="27">27</option>
			      <option value="28">28</option>
			      <option value="29">29</option>
			      <option value="30">30</option>
			      <option value="31">31</option>
			      <option value="32">32</option>
			      <option value="33">33</option>
			      <option value="34">34</option>
			      <option value="35">35</option>
			      <option value="36">36</option>
			      <option value="37">37</option>
			      <option value="38">38</option>
			      <option value="39">39</option>
			      <option value="40">40</option>
			      <option value="41">41</option>
			      <option value="42">42</option>
			      <option value="43">43</option>
			      <option value="44">44</option>
			      <option value="45">45</option>
			      <option value="46">46</option>
			      <option value="47">47</option>
			      <option value="48">48</option>
			      <option value="49">49</option>
			      <option value="50">50</option>
			      <option value="51">51</option>
			      <option value="52">52</option>
			      <option value="53">53</option>
			      <option value="54">54</option>
			      <option value="55">55</option>
			      <option value="56">56</option>
			      <option value="57">57</option>
			      <option value="58">58</option>
			      <option value="59">59</option>
			    </select>
			    </span> -
			  <span>Hours: 
			    <select size="1" name="hours" class="input-mini">
			      <option selected="" value="*">*</option>
			      <option value="0">0</option>
			      <option value="1">1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			      <option value="4">4</option>
			      <option value="5">5</option>
			      <option value="6">6</option>
			      <option value="7">7</option>
			      <option value="8">8</option>
			      <option value="9">9</option>
			      <option value="10">10</option>
			      <option value="11">11</option>
			      <option value="12">12</option>
			      <option value="13">13</option>
			      <option value="14">14</option>
			      <option value="15">15</option>
			      <option value="16">16</option>
			      <option value="17">17</option>
			      <option value="18">18</option>
			      <option value="19">19</option>
			      <option value="20">20</option>
			      <option value="21">21</option>
			      <option value="22">22</option>
			      <option value="23">23</option>
			    </select>
			    </span> -
			  <span>Days: 
			    <select size="1" name="days" class="input-mini">
			      <option selected="" value="*">*</option>
			      <option value="1">1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			      <option value="4">4</option>
			      <option value="5">5</option>
			      <option value="6">6</option>
			      <option value="7">7</option>
			      <option value="8">8</option>
			      <option value="9">9</option>
			      <option value="10">10</option>
			      <option value="11">11</option>
			      <option value="12">12</option>
			      <option value="13">13</option>
			      <option value="14">14</option>
			      <option value="15">15</option>
			      <option value="16">16</option>
			      <option value="17">17</option>
			      <option value="18">18</option>
			      <option value="19">19</option>
			      <option value="20">20</option>
			      <option value="21">21</option>
			      <option value="22">22</option>
			      <option value="23">23</option>
			      <option value="24">24</option>
			      <option value="25">25</option>
			      <option value="26">26</option>
			      <option value="27">27</option>
			      <option value="28">28</option>
			      <option value="29">29</option>
			      <option value="30">30</option>
			      <option value="31">31</option>
			    </select>
			    </span> -
			  <span>Months: 
			    <select size="1" name="months" class="input-mini">
			      <option selected="" value="*">*</option>
			      <option value="1">1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			      <option value="4">4</option>
			      <option value="5">5</option>
			      <option value="6">6</option>
			      <option value="7">7</option>
			      <option value="8">8</option>
			      <option value="9">9</option>
			      <option value="10">10</option>
			      <option value="11">11</option>
			      <option value="12">12</option>
			    </select>
			    </span> -
			  <span>Weekdays (0 (Sun) - 6 (Sat)): 
			    <select size="1" name="weekday" class="input-mini">
			      <option selected="" value="*">*</option>
			      <option value="0">0</option>
			      <option value="1">1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			      <option value="4">4</option>
			      <option value="5">5</option>
			      <option value="6">6</option>
			    </select>
			    </div>
			  <div><br>
			    Script/program to execute: 
				<div class="btn-group form-horizontal">
			    <input type="text" name="script" value="curl --silent 'http://reader.vn/cron/ping?username=dmadmin&password=03avdea43'" size="30" class="input-xxlarge"><input name="button" type="button" class="btn btn-primary" onclick="javascript: document.cronf.text.value=document.cronf.minutes.value +' '+document.cronf.hours.value+ ' ' +document.cronf.days.value +' '+document.cronf.months.value +' '+ document.cronf.weekday.value+' '+ document.cronf.script.value" value="Build Crontab Entry"> 
				</div>
			  </div>
			  
			  <div><span class="style1">Crontab Entry:</span><br>
			    <br> 
			    <textarea name="text" cols="80" rows="3" class="input-xxlarge"></textarea>
			</div>

			<small>Note: If Every 5 minutes, use <span class="label">*/5</span> instead of <span class="label">5</span></small><br />
			<small>Some quick note for setup crontab in Mac OS (10.7):
				<pre>
					~ > sudo chmod 0777 /usr/lib/cron/tabs
					~ > sudo crontab -u voduytuan -e
					~ > sudo crontab -u voduytuan -l
				</pre>
			</small>




			</form>
			
		</div><!-- end #tab3 -->
		
		<div class="tab-pane" id="tab4">
			<table class="table table-striped">
				<thead>
					<tr>
						<td>URL</td>
						<td>Description</td>
						<td>Run Where</td>
					</tr>
				</thead>
				<tbody>
					<tr><td><a href="{$conf.rooturl}cron/promotion/synproductpromotion?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/promotion/synproductpromotion</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/promotion/synpromotion?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/promotion/synpromotion</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/promotion/syncpromotionpriceproduct?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/promotion/syncpromotionpriceproduct</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/promotion/syncpromotionproductexpired?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/promotion/syncpromotionproductexpired</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/product/synproductindex/?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/product/synproductindex</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/archivedorder/index/action/sync/?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/archivedorder/index/action/sync/</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/product/syncproductstockprice?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/product/syncproductstockprice</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/product/updateproductstock?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/product/updateproductstock</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/product/updateproductprice?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/product/updateproductprice</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/product/syncnumberproductbycategory?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/product/syncnumberproductbycategory</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/product/syncnumberproductbyvendor?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/product/syncnumberproductbyvendor</a></td><td></td><td>172.16.141.80</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/resourceserver?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/resourceserver/index</a></td><td></td><td>172.16.141.30</td></tr>
					<tr><td><a href="{$conf.rooturl}cron/resourceserver/syncstatic?username={$cronusername}&password={$cronpassword}" target="_blank">{$conf.rooturl}cron/resourceserver/syncstatic</a></td><td></td><td>172.16.141.30</td></tr>
				</tbody>
			</table>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "crontask/index";
		

		var controller = $('#fcontroller').val();
		if(controller.length > 0)
		{
			path += '/controller/' + controller;
		}

		var action = $('#faction').val();
		if(action.length > 0)
		{
			path += '/action/' + action;
		}

		var id = $('#fid').val();
		if(parseInt(id) > 0)
		{
			path += '/id/' + id;
		}
		
		var status = $('#fstatus').val();
		if(parseInt(status) > 0)
		{
			path += '/status/' + status;
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
			
