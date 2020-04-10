$(document).ready(function(){
	var base_url = $('#apidocbaseurl span').html();

	$('.apirurl div').each(function(){
		var cururl = $(this).html();
		$(this).html(cururl.replace('{BASE_URL}', base_url));
	});
});

function apigroup_listing(gid)
{
	$('#apigroup-'+gid+' .apigbody').slideDown();
	$('#apigroup-' + gid + ' .apirequest').addClass('apirequest_lite');
}

function apigroup_expand(gid)
{
	$('#apigroup-'+gid+' .apigbody').slideDown();
	$('#apigroup-' + gid + ' .apirequest').removeClass('apirequest_lite');
}

function api_request(requestId)
{

	$('#apirequest-'+requestId+' .trynowbox').html('<img src="/templates/default/images/ajax_indicator.gif" class="tmp_indicator" />').show();

	var method = $('#apirequest-' + requestId + ' .apirmethod').text();
	var url = $('#apirequest-' + requestId + ' .apirurl div span').text();

	if(method == 'GET' || method == 'POST')
	{
		//manipulate URL for GET request data
		$('#apirequest-' +requestId + ' .itemparam_GET').each(function(){
			var name = $(this).find('.itemparam_name').text();
			var value = $(this).find('.itemparam_value').val();

			url = url.replace('{'+name+'}', encodeURIComponent(value));
		});

		//get POST data string
		var postData = '';
		$('#apirequest-' +requestId + ' .itemparam_POST').each(function(){
			var name = $(this).find('.itemparam_name').text();
			var value = $(this).find('.itemparam_value').val();

			if(postData.length > 0)
				postData += '&';

			postData += name + '=' + encodeURIComponent(value);
		});


		$.ajax({
	            type : method,
	            data : postData,
	            url : url,
	            success: function(html){
					//$('#apirequest-'+requestId+' .trynowbox').html(html);

					//we can format output to the trynow data
					$('#apirequest-' + requestId+' .trynowbox').JSONView(html);
	            }
	    });
	}
	else
	{
		alert('This feature only supports for GET and POST method.');
	}
}