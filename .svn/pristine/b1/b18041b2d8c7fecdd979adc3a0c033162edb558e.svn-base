<h1>Recommendation Algorithm Monitoring</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Algorithm Name</th>
			<th>Start At</th>
			<th>Number User</th>
			<th>Number Item</th>
			<th>Pre-processing</th>
			<th>Similarity Measuring</th>
			<th>Item-Item Output</th>
			<th>User-Item Output</th>
			<th>Finish At</th>
			<th>Total time Execution</th>
		</tr>
	</thead>

	<tbody>
	{foreach key=acode item=algorithmInfo from=$recommendationStatus}

		<tr>
			<td>{if $acode == 's2'}Amazon Recommendation{elseif $acode == 's3'}Content-Based{elseif $acode == 's4'}Hybrid{/if}</td>
			<td>{$algorithmInfo.timestart|date_format:"%H:%M:%S, ngày %d/%m"}</td>
			<td>{$algorithmInfo.numberuser}</td>
			<td>{$algorithmInfo.numberitem}</td>
			<td>{$algorithmInfo.preprocess}</td>
			<td>{$algorithmInfo.similarityprocess}</td>
			<td>{$algorithmInfo.itemitemprocess}</td>
			<td>{$algorithmInfo.useritemprocess}</td>
			<td>{$algorithmInfo.timefinished|date_format:"%H:%M:%S, ngày %d/%m"}</td>
			<td>{$algorighmInfo.totaltime} (ms)</td>
		</tr>

	{/foreach}
	</tbody>
</table>