<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Email Preview</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<div class="page-header" rel="menu_emailpreview"><h1>Email Template Preview</h1></div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.default.formFormLabel}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<ul style="list-style-type:circle; list-style-position:inside; line-height:2;">
				<li><a href="javascript:void(0);" onclick="emailpreview('registeradmin')">Register for Admin</a></li>
				<li><a href="javascript:void(0);" onclick="emailpreview('registeruser')">Register for User</a></li>
				<li><a href="javascript:void(0);" onclick="emailpreview('message')">New Message</a></li>
				<li><a href="javascript:void(0);" onclick="emailpreview('friendrequest')">Friend Request</a></li>
				<li><a href="javascript:void(0);" onclick="emailpreview('booksellcheckout')">Book sell Checkout</a></li>
				<li><a href="javascript:void(0);" onclick="emailpreview('ebookcheckoutprovider')">Ebook Checkout Provider</a> | <a href="javascript:void(0);" onclick="emailpreview('ebookcheckoutreceiver')">Ebook Checkout Receiver</a> | <a href="javascript:void(0);" onclick="emailpreview('ebookcheckoutreceivernew')">Ebook Checkout Receiver (Create User)</a>  | <a href="javascript:void(0);" onclick="emailpreview('ebookcheckoutbuyer')">Buyer</a>  | <a href="javascript:void(0);" onclick="emailpreview('ebookcheckoutgiftbuyer')">Gift Buyer</a> </li>
			</ul>
		</div><!-- end #tab 1 -->
		
	</div>
</div>








{literal}
<script type="text/javascript">
	function emailpreview(type)
	{
		window.open('{/literal}{$conf.rooturl_admin}{literal}emailpreview/preview?type=' + type, 'mywindow','location=1,status=1,scrollbars=1, width=740,height=500');
	}
</script>
{/literal}








