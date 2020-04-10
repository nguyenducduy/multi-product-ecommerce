<iframe id="myiframe" src="{$conf.rooturl}_internal/apc/apc.php" style="width:100%;height:560px;border-width:0;" onload="javascript:resizeIframe(this);" >
	
	
</iframe>

{literal}
<script type="text/javascript">
	function resizeIframe(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	  }
	
</script>
{/literal}