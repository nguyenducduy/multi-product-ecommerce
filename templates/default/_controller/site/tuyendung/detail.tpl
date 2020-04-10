
<div class="nav-news">
    {foreach item=jmenu from=$jobmenu}
        <li><a href="{$conf.rooturl}job?p={$jmenu->id}"{if $jmenu->id == $id} class="selectnews"{/if} title="{$jmenu->name}">{$jmenu->name}</a></li>
    {/foreach}
</div>

<!-- News -->
<div id="wrap-news">
  	<!-- Điện thoại -->
  	<p class="generalname"><a href="{$conf.rooturl}job?c={$myCategory->id}" title="{$myCategory->name}">{$myCategory->name}</a></p>
    <div class="newsdetail">
    	<h1>{$myJob->title}</h1> <span>{$myJob->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
        <p>{$myJob->seodescription}</p>
        <div class="newscontent">
            {$myJob->content}
        </div>
    </div>

    <strong><a href="{$conf.rooturl}jobcv/index?id={$myJob->id}">Nộp hồ sơ trực tuyến</a></strong>
     <div class="writer">
        <strong> dienmay.com</strong>
    </div>


	<!-- comment -->
  	<div id="comments" class="wrap-one">
		<!-- fill of comment appear -->
  	</div>

</div>
<!-- End news -->
{literal}
<script type="text/javascript">
	var jid = {/literal}{$myJob->id};{literal}
	/*$(document).ready(function(){
		loadJobReview(jid, '');
	});*/
</script>
{/literal}