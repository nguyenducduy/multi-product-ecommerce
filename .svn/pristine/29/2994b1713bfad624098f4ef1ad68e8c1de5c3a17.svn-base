<div class="wrapyt_ask">
	<div class="yt_ask"><span>Câu hỏi {$pagequestion}</span></div>
    <div class="yt_time" id="yt_time"></div>
    <div id="contentquestion">
	    <div class="yt_imgnext"><a id="nextquestion" href="javascript:;" rel="{$pagequestion + 1}" data-id="1" data-action="{$myQuestion->id}" title="Xem hình kế tiếp"></a></div>
		<div class="orther_ask">
	    	<span>{$myQuestion->name}</span>
	        <div class="option_yt">
	        {foreach from=$myQuestion->answer item=answer name=myanswer}
	            <label style="float:left; width:150px">
	            	<input type="radio" id="radio-2-{$smarty.foreach.myanswer.iteration}" name="radio-2-set" class="regular-radio big-radio" value="{$smarty.foreach.myanswer.iteration}" />
	                <label for="radio-2-{$smarty.foreach.myanswer.iteration}"></label> 
	                <span class="label_yt">{$answer}</span>
	            </label>
	        {/foreach}
	        </div>
	        <p class="error" style="color: red; text-align: center"></p>
	    </div>
	    <!-- hình so sánh -->
	<div class="slide_img_yt"><img alt="" src="{$myQuestion->image}"> </div>
	</div>
</div>
   