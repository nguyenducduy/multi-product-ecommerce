<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Code Generator</a> <span class="divider">/</span></li>
	<li class="active">Table Listing</li>
</ul>

<div class="page-header" rel="menu_codegenerator"><h1>Code Generator</h1></div>



<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Table Listing ({$tables|@count})</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
				<table class="table table-striped" cellpadding="5" width="100%">
					{if $tables|@count > 0}
						<thead>
							<tr>
								<th>Table Name</th>
							</tr>
						</thead>

						<tbody>
					{foreach item=table from=$tables}

							<tr>
								<td align="center"><a title="Code generate for {$table}" href="{$conf.rooturl_admin}codegenerator/generate/table/{$table}/redirect/{$redirectUrl}" class="btn"><i class="icon-circle-arrow-right icon-white"></i> {$table}</a></td>
							
							</tr>

					{/foreach}
						</tbody>
					{/if}
					
					
				</table>
			
			
		</div><!-- end #tab 1 -->
	</div>
</div>







