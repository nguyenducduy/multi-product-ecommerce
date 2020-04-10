<div class="areaguest">
        	{$productGuess->name}
            
            <div class="giftP3 giftP32">
            	<img src="{$currentTemplate}images/site/gifff.png"> {$productGuess->infogift}
            </div>
            <div class="counter-tt counter-tt2">Thời gian còn lại:</div>
            <div id="counter" class="counter"></div>
            <div class="btn-detail btn-vtl">
            	<a href="javascript:;" onclick="showpopuptruleguess('{$productGuess->id}')">Xem chi tiết »</a>
            </div>
            
</div>
<div class="p3question">
        <div id="answesitem">
        	<strong>Câu hỏi 1/{$totalquestion}</strong>
            <span>{$myQuestion->name}</span>
           
	            {foreach from=$myQuestion->answer item=answer name=myanswer}
	            <label>
	            	<input class="radio" id="answer_{$smarty.foreach.myanswer.iteration}" name="itemanswer" type="radio" value="{if $smarty.foreach.myanswer.iteration == $myQuestion->correct}true{else}false{/if}">{$answer}</label>
	            	<div class="clear"></div>
	            {/foreach}
	            <div class="btn-step"><a data-id="{$productGuess->id}" rel="{$totalquestion}" id="next" href="javascript:;">Tiếp tục »</a></div>
        </div>
        
        <label class="p3alert"></label>
        <label class="loadinggif p3alert guessloading"></label>
</div>