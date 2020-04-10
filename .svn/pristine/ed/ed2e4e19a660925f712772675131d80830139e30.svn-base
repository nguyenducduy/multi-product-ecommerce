<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>API</title>
		<script type="text/javascript" src="{$currentTemplate}js/jquery.js"></script>
		<script type="text/javascript" src="{$currentTemplate}js/apidoc.js"></script>
		<link rel="stylesheet" href="{$currentTemplate}css/apidoc.css" type="text/css" media="screen" />
	</head>
	
	<body>
		<h1>API Documentations</h1>
		
		<div id="apidocbaseurl" style="display:none;">BASE_URL: <span>http://appmuaban.com</span></div>
		
		<div id="apidoc">
		{if $groupList|@count > 0}
			{foreach item=group from=$groupList}
				<div class="apigroup" id="apigroup-{$group->id}">
					<div class="apighead">
						<h2 {if $group->checkStatusName('deprecated')}class="deprecated"{/if}><a href="javascript:void(0)" onclick="$('#apigroup-{$group->id} .apigbody').slideToggle();" title="Show/Hide This Group"><span>{$group->name}</span>{if $group->checkStatusName('prototype')} - <em>Just Prototype</em>{elseif $group->checkStatusName('deprecated')} - <em>Deprecated</em> {/if}</a></h2>
						
						<div class="apiglink">
							<a href="javascript:void(0)" onclick="$('#apigroup-{$group->id} .apigbody').slideToggle()" title="Show/Hide This Group">Show/Hide</a>
							<a href="javascript:void(0)" onclick="apigroup_listing({$group->id})" title="List All Operations in this Group">List Operations</a>
							<a href="javascript:void(0)" onclick="apigroup_expand({$group->id})" title="Expand operation detail">Expand Operations</a>
						</div>
						{if $group->summary != ''}
							<div class="apigsummary">{$group->summary}</div>
						{/if}
					</div><!-- end .apighead -->
					<div class="apigbody">
						{foreach item=r from=$group->requestList}
							<div class="apirequest apirequest_lite apirequest_{$r->getMethodName()} {if $r->checkStatusName('deprecated')}deprecated{/if}" id="apirequest-{$r->id}">
								<div class="apirhead">
									<div class="apirmethod" onclick="$('#apirequest-{$r->id}').toggleClass('apirequest_lite')">{$r->getMethodName()}</div>
									<div class="apirname"><a href="javascript:void(0)" onclick="$('#apirequest-{$r->id}').toggleClass('apirequest_lite')">{$r->name}</a>{if $r->checkStatusName('prototype')} - <em>Just Prototype</em>{elseif $r->checkStatusName('deprecated')} - <em>Deprecated</em> {/if}</div>
									<div class="apirsummary" onclick="$('#apirequest-{$r->id}').toggleClass('apirequest_lite')">{$r->summary}</div>
									<div class="cl"></div>
								</div><!-- end .apirhead -->
								<div class="apirbody">
									<div class="apirblock apirurl">
										<h3>Full URL</h3> 
										<div><strong>{$r->getMethodName()}</strong> <span>{$r->getUrlWithQuery()}</span></div>
									</div>
									{if $r->implementnote != ''}
									<div class="apirblock apirimplementnote">
										<h3>Implementation Notes</h3>
										<div class="note">{$r->implementnote}</div>
									</div><!-- end .apirimplementnote -->
									{/if}
									
									<div class="apirblock apirparameterlist">
										<h3>Parameters</h3>
										{if $r->paramList|@count > 0}
											<table>
												<thead>
													<tr>
														<th width="30"></th>
														<th>Parameter</th>
														<th>Type</th>
														<th>Value</th>
														<th>Description</th>
													</tr>
												</thead>
												<tbody>
													{foreach item=param from=$r->paramList}
														<tr class="itemparam itemparam_{$param->getTypeName()} {if $param->isrequired == 1}paramrequired{/if}">
															<td align="right" class=""><small><em>[{$param->getTypeName()}]</em></small></td>
															<td class="itemparam_name">{$param->name}</td>
															<td>{$param->getDatatypeName()}</td>
															<td><input type="text" class="param itemparam_value" id="param-{$param->name}" value="" {if $param->isrequired == 1}placeholder="(Required)"{/if} /></td>
															<td>{$param->summary}</td>
														</tr>
													{/foreach}
												</tbody>
											</table>
										{else}
											<div class="apirnoparam">No Param</div>
											
										{/if}
										
										<br />
										<input type="button" class="buttonrequest" value="Try now!" onclick="api_request({$r->id})" />
									</div><!-- end .apirparameterlist -->
									
									<div class="trynowbox">
											
									</div>
									
									
									<div class="apirblock apirresponselist">
										<h3>Response</h3>
										{if $r->responseList|@count > 0}
											
											<ul class="apirresponsetab apirresponsetablist-{$r->id}">
												{foreach name=responselist item=response from=$r->responseList}
													<li id="apirresponsetab-{$response->id}" {if $smarty.foreach.responselist.first}class="active"{/if}><a href="javascript:void(0)" onclick="$('.apirresponsetablist-{$r->id} li').removeClass('active');$('#apirresponsetab-{$response->id}').addClass('active');$('#apirresponsetabdata-{$r->id} li').hide();$('.apirresponsetab-{$response->id}').show();">{$response->getContenttypeName()}</a></li>
												{/foreach}
											</ul>
											
											<ul class="apirresponsetabdata" id="apirresponsetabdata-{$r->id}">
												{foreach name=responselist item=response from=$r->responseList}
													<li class="apirresponsetab-{$response->id} {if $smarty.foreach.responselist.first} active{/if}">
														<h4>OUTPUT:</h4>
														<textarea>{$response->output}</textarea>
														
														{if $response->sample != ''}
															<h4>SAMPLE:</h4>
															<textarea>{$response->sample}</textarea>
														{/if}
													</li>
												{/foreach}
											</ul>
												
										{else}
											<div class="apirnoparam">Un-defined</div>
										{/if}
									</div><!-- end .apirparameterlist -->
									
									
								</div><!-- end .apirbody -->
							</div><!-- end .apirequest -->
						{/foreach}
					</div><!-- end .apigbody -->
				</div><!-- end .apigroup -->
			{/foreach}
		{else}
			<em>No API documentations found.</em>
		{/if}
		</div><!-- end #apidoc -->
	</body>
</html>



