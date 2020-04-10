<div class="areaguest">
        	{$productGuess->name}
            
            <div class="giftP3 giftP32">
            	<img src="{$currentTemplate}images/site/gifff.png"> {$productGuess->infogift}
            </div>
            <div class="counter-tt counter-tt2">Thời gian còn lại:</div>
            <div id="counter" class="counter">
            	<div class="J_days" style="display: inline;; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_hours" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_minutes" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
        		<div class="J_seconds" style="display: inline; border-radius:4px; padding:4px 8px; text-align:center; background:white; font:bold 20px Arial; margin-right:2px"></div>
            </div>
            <div id="lablecounter">
            	<span class="Days">Ngày</span>
            	<span class="Hours">Giờ</span>
            	<span class="Minutes">Phút</span>
            	<span class="Seconds">Giây</span>
            </div>
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