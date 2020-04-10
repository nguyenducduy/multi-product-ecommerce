<div class="navibarlist">
    {if !empty($fullPathCategory)}
		<ul>
		    <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ››</a> </li>
		  <li>{$pageDetail->name}</li>
		</ul>
	{/if}
</div>
<div class="conttitle" style="position:relative"><div class="back"><a href="javascript:history.back()">&#171;Trở về</a></div>{$pageDetail->title}</div>
 <!-- news detail -->
<div class="newsdetail">
<h1>{$pageDetail->title}</h1>
<span>{$myNews->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
<p>
         {$pageDetail->content}
</p>
</div>

<div id="comment" class="wrap-one">
	                    
</div>
{literal}
<script type="text/javascript">
 var pid = "{/literal}{$pageDetail->id}{literal}";
  var isblank = "{/literal}{$pageDetail->blank}{literal}";
$(document).ready(function(){
    loadpageReview(pid , '');
});
</script>
{/literal}